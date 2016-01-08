<?php

class BatalKeluarUmumController extends MyAuthController
{
        protected $successSave=true;
        public $path_view = 'billingKasir.views.batalKeluarUmum.';
		
        public function actionIndex()
	{
            $format = New MyFormatter;
            $modBatalBayar = new BKBatalKeluarUmumT;
            $modPengeluaran = new BKPengeluaranumumT;
		
            if(isset($_POST['BKBatalKeluarUmumT'])){
                
                $modPengeluaran->attributes = $_POST['BKPengeluaranumumT'];
               
                $modPengeluaran->tglpengeluaran = $format->formatDateTimeForDb($_REQUEST['BKPengeluaranumumT']['tglpengeluaran']);
             
                $transaction = Yii::app()->db->beginTransaction();
                try {
                    $modBatalBayar = $this->saveBatalKeluarUmum($_POST['BKBatalKeluarUmumT']);
                    $this->updateBuktiKeluar($modBatalBayar);
                    $this->updatePengeluaranUmum($modBatalBayar);
                    
                    if($this->successSave){
                        $transaction->commit();
                        Yii::app()->user->setFlash('success',"Data berhasil disimpan");
                    } else {

                        $transaction->rollback();
                        Yii::app()->user->setFlash('error',"Data gagal disimpan ");
                    }
                } catch (Exception $exc) {
                    $transaction->rollback();
                    Yii::app()->user->setFlash('error',"Data gagal disimpan ".MyExceptionMessage::getMessage($exc,true));
                }
            }
            
            $this->render($this->path_view.'index',array('modBatalBayar'=>$modBatalBayar,
                                        'modPengeluaran'=>$modPengeluaran));
	}
	
	/**
	 * untuk autocomplete
	 */
	public function actionAutocompleteInfoPengeluaranUmum()
    {
        if(Yii::app()->request->isAjaxRequest) {
                $criteria = new CDbCriteria();
                $criteria->with = array('uraian','buktikeluar');
                $criteria->compare('LOWER(nopengeluaran)', strtolower($_GET['term']), true);
                $criteria->addCondition('t.batalkeluarumum_id IS NULL');
                $models = PengeluaranumumT::model()->findAll($criteria);
                foreach($models as $i=>$model)
                {
                    $attributes = $model->attributeNames();
                    foreach($attributes as $j=>$attribute) {
                        $returnVal[$i]["$attribute"] = $model->$attribute;
                    }
                    $returnVal[$i]['label'] = $model->nopengeluaran;
                    $returnVal[$i]['value'] = $model->nopengeluaran;
                    
                    $attrBuktiKeluar = (!empty($model->tandabuktikeluar_id)) ? $model->buktikeluar->attributeNames() : TandabuktikeluarT::model()->attributeNames();
                    foreach($attrBuktiKeluar as $j=>$attribute) {
                        $returnVal[$i]["buktikeluar"]["$attribute"] = $model->buktikeluar->$attribute;
                    }
                }

                echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }
        
        protected function saveBatalKeluarUmum($postBatalKeluarUmum)
        {   $format = new MyFormatter;
            $modBatal = new BKBatalKeluarUmumT;
            $modBatal->attributes = $postBatalKeluarUmum;
            $modBatal->ruangan_id = Yii::app()->user->getState('ruangan_id');
            $modBatal->tglbatalkeluar = $format->formatDateTimeForDb($_REQUEST['BKBatalKeluarUmumT']['tglbatalkeluar']);
            if($modBatal->validate()){
                $modBatal->save();
                $this->successSave = $this->successSave && true;
            } else {
                $this->successSave = false;
            }
            
            return $modBatal;
        }
        
        protected function updateBuktiKeluar($modBatal)
        {
            TandabuktikeluarT::model()->updateByPk($modBatal->tandabuktikeluar_id, array('batalkeluarumum_id'=>$modBatal->batalkeluarumum_id));
        }
        
        protected function updatePengeluaranUmum($modBatal)
        {
            PengeluaranumumT::model()->updateByPk($modBatal->pengeluaranumum_id, array('batalkeluarumum_id'=>$modBatal->batalkeluarumum_id));
        }
		
		public function actionCekLogin($task='Retur') 
		{
			if(Yii::app()->request->isAjaxRequest){
				$username = $_POST['username'];
				$password = $_POST['password'];
				$idRuangan = Yii::app()->user->getState('ruangan_id');

				$user = LoginpemakaiK::model()->findByAttributes(array('nama_pemakai' => $username,
																	   'loginpemakai_aktif' =>TRUE));
				if ($user === null) {
					$data['error'] = "Login Pemakai salah!";
					$data['cssError'] = 'username';
					$data['status'] = 'Gagal Login';
				} else {
					// cek password
					if ($user->katakunci_pemakai !== $user->encrypt($password)) {
						$data['error'] = 'password salah!';
						$data['cssError'] = 'password';
						$data['status'] = 'Gagal Login';
					} else {
						// cek ruangan
						$ruangan_user = RuanganpemakaiK::model()->findByAttributes(array('loginpemakai_id'=>$user->loginpemakai_id,
																						 'ruangan_id'=> $idRuangan));
						if($ruangan_user===null) {
							$data['error'] = 'ruangan salah!';
							$data['status'] = 'Gagal Login';
						} else {
							$data['error'] = '';
							$cek = $this->checkAccess(array('loginpemakai_id'=>$user->loginpemakai_id)); //dari MyAuthController
							if($cek){
								$data['status'] = 'success';
								$data['userid'] = $user->loginpemakai_id;
								$data['username'] = $user->nama_pemakai;
							} else {
								$data['status'] = 'Anda tidak memiliki hak melakukan proses ini!';
							}
						}
					}
				}

				echo json_encode($data);
				Yii::app()->end();
			}
		}

        // Uncomment the following methods and override them if needed
	/*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
}