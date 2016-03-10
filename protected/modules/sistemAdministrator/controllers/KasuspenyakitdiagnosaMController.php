<?php

class KasuspenyakitdiagnosaMController extends MyAuthController
{
    
	public $layout = '//layouts/column1';
	public $defaultAction = 'admin';
    public $path_view = 'sistemAdministrator.views.kasuspenyakitdiagnosaM.';
                
	public function actionIndex()
	{
		$this->render($this->path_view.'index');
	}
        
        public function actionAdmin()
        {
            $model = new SAKasuspenyakitdiagnosaM('searchTabel');
            $model->unsetAttributes();
            if (isset($_GET['SAKasuspenyakitdiagnosaM'])){
                $model->attributes = $_GET['SAKasuspenyakitdiagnosaM'];
                $model->diagnosa_nama = $_GET['SAKasuspenyakitdiagnosaM']['diagnosa_nama'];
                $model->diagnosa_namalainnya = $_GET['SAKasuspenyakitdiagnosaM']['diagnosa_namalainnya'];                
            }
            $this->render($this->path_view.'admin',array('model'=>$model));
        }

        public function actionCreate()
        {
            $model = new SAKasuspenyakitdiagnosaM;
            $modDetails=array();
            if (isset($_POST['SAKasuspenyakitdiagnosaM']))
            {
                        
                $modDetails = $this->validasiTabular($model, $_POST['SAKasuspenyakitdiagnosaM']);
                $transaction = Yii::app()->db->beginTransaction();
                try {
                    $jumlah = 0;
                    foreach ($modDetails as $j=>$row)
                    {
                        if($row->save()) {
                            $jumlah++;
                        }
                    }
                    if ($jumlah == count($modDetails)) {
                        $transaction->commit();
                        Yii::app()->user->setFlash('success','<strong>Berhasil</strong> Data Berhasil disimpan');
                        $this->redirect(array('admin', 'sukses'=>1));
                    } else {
                        throw new Exception('Error');
                    }
                }
                catch(Exception $ex) {
                    $transaction->rollback();
                    Yii::app()->user->setFlash('error','<strong>Gagal</strong> Data gagal disimpan'.MyExceptionMessage::getMessage($ex));
                }
            }
            $this->render($this->path_view.'create',array('model'=>$model,'modDetails'=>$modDetails));
        }

        protected function validasiTabular($model, $data) {
            foreach ($data as $i=>$row) {
                if(is_array($row)){
                $modDetails[$i] = new SAKasuspenyakitdiagnosaM;
                $modDetails[$i]->attributes = $row;
                $modDetails[$i]->validate();
//                        echo '<pre>'.print_r($modDetails[$i]->attributes);
                }
            }
//                    echo count($modDetails);
//                    exit();
            return $modDetails;
        }

        public function actionUpdate($id)
        {
            //if(!Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE))
            // {
            //     throw new CHttpException(401,Yii::t('mds','You are probihited to access this page. Contact Super Administrator'));
            // }
            $model = new SAKasuspenyakitdiagnosaM;
            $modDetails=array();
            if (isset($_POST['SAKasuspenyakitdiagnosaM']))
            {
                    $jmlhsave = 0;
                    foreach ($_POST['SAKasuspenyakitdiagnosaM'] as $value=>$row)
                    {
//                                $modKasuspenyakitdiagnosa = SAKasuspenyakitdiagnosaM::model()->findByAttributes(array('jeniskasuspenyakit_id'=>$row['jeniskasuspenyakit_id'],'diagnosa_id'=>$row['diagnosa_id']));
                            $model = new SAKasuspenyakitdiagnosaM;
                            $model->attributes = $row;
                            $model->save();
                            $jmlhsave++;
                    }
                    if ($jmlhsave==COUNT($_POST['SAKasuspenyakitdiagnosaM']))
                    {
                        Yii::app()->user->setFlash('success','<strong>Berhasil</strong> Data berhasil disimpan');
                        $this->redirect(array('admin', 'sukses'=>1));
                    }
//                        $modDetails = $this->validasiTabular($model, $_POST['SAKasuspenyakitdiagnosaM']);
//                        $transaction = Yii::app()->db->beginTransaction();
//                        try {
//                            $jumlah = 0;
//                            foreach ($modDetails as $j=>$row)
//                            {
//                                if($row->save()) {
//                                    $jumlah++;
//                                }
//                            }
//                            if ($jumlah == count($modDetails)) {
//                                $transaction->commit();
//                                Yii::app()->user->setFlash('success','<strong>Berhasil</strong> Data Berhasil disimpan');
//                                $this->redirect(array('admin'));
//                            } else {
//                                throw new Exception('Error');
//                            }
//                        }
//                        catch(Exception $ex) {
//                            $transaction->rollback();
//                            Yii::app()->user->setFlash('error','<strong>Gagal</strong> Data gagal disimpan'.MyExceptionMessage::getMessage($ex));
//                        }
            }
            $this->render($this->path_view.'update',array('model'=>$model,'modDetails'=>$modDetails));
        }
                
        public function actionDelete($jeniskasuspenyakit_id, $diagnosa_id)
        {
                $this->loadModel($jeniskasuspenyakit_id,$diagnosa_id)->delete();
                if(!isset($_GET['ajax']))
                        $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        }
		/**
		 * untuk autocomplete jenis kasus penyakit
		 */
		public function actionAutocompleteJenisKasusPenyakit()
		{
			if(Yii::app()->request->isAjaxRequest) {
				$criteria = new CDbCriteria();
				$criteria->compare('LOWER(jeniskasuspenyakit_nama)', strtolower($_GET['term']), true);
				$criteria->addCondition("jeniskasuspenyakit_aktif = TRUE");
				$criteria->order = 'jeniskasuspenyakit_nama';
				$criteria->limit=10;
				$models = JeniskasuspenyakitM::model()->findAll($criteria);
				foreach($models as $i=>$model)
				{
					$attributes = $model->attributeNames();
					foreach($attributes as $j=>$attribute) {
						$returnVal[$i]["$attribute"] = $model->$attribute;
					}
					$returnVal[$i]['label'] = $model->jeniskasuspenyakit_nama;
					$returnVal[$i]['value'] = $model->jeniskasuspenyakit_id;
				}

				echo CJSON::encode($returnVal);
			}
			Yii::app()->end();
		}
		/**
		 * Autocomplete Diagnosa
		 */
		public function actionAutocompleteDiagnosa()
		{
				if(Yii::app()->request->isAjaxRequest) {
					$criteria = new CDbCriteria();
					$criteria->compare('LOWER(diagnosa_nama)', strtolower($_GET['term']), true);
					$criteria->addCondition("diagnosa_aktif = TRUE");
					$criteria->order = 'diagnosa_nama';
					$criteria->limit=10;
					$models = DiagnosaM::model()->findAll($criteria);
					foreach($models as $i=>$model)
					{
						$attributes = $model->attributeNames();
						foreach($attributes as $j=>$attribute) {
							$returnVal[$i]["$attribute"] = $model->$attribute;
						}
						$returnVal[$i]['label'] = $model->diagnosa_kode. '-' .$model->diagnosa_nama;
						$returnVal[$i]['value'] = $model->diagnosa_id;
					}

					echo CJSON::encode($returnVal);
				}
				Yii::app()->end();
		}
                
	public function actionView($id)
	{
            $this->render($this->path_view.'view',array(
                    'model'=>$this->loadModel($id),
            ));
	}
        
	public function loadModel($id, $diagnosa = null)
	{
            if (empty($diagnosa))
            {
                $model=SAKasuspenyakitdiagnosaM::model()->findByAttributes(array('jeniskasuspenyakit_id'=>$id));
            } else {
                $model=SAKasuspenyakitdiagnosaM::model()->findByAttributes(array('jeniskasuspenyakit_id'=>$id, 'diagnosa_id'=>$diagnosa));
            }
            if($model===null)
                    throw new CHttpException(404,'The requested page does not exist.');
            return $model;
	}
                
        public function actionPrint()
        {
            $model= new SAKasuspenyakitdiagnosaM;
            $model->attributes=$_REQUEST['SAKasuspenyakitdiagnosaM'];
            $judulLaporan='Data Diagnosa Kasus Penyakit';
            $caraPrint=$_REQUEST['caraPrint'];
            if($caraPrint=='PRINT') {
                $this->layout='//layouts/printWindows';
                $this->render($this->path_view.'Print',array('model'=>$model,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint));
            }
            else if($caraPrint=='EXCEL') {
                $this->layout='//layouts/printExcel';
                $this->render($this->path_view.'Print',array('model'=>$model,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint));
            }
            else if($_REQUEST['caraPrint']=='PDF') {
                $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
                $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
                $mpdf = new MyPDF('',$ukuranKertasPDF); 
                $mpdf->useOddEven = 2;  
                $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
                $mpdf->WriteHTML($stylesheet,1);  
                $mpdf->AddPage($posisi,'','','','',15,15,15,15,15,15);
                $mpdf->WriteHTML($this->renderPartial($this->path_view.'Print',array('model'=>$model,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint),true));
                $mpdf->Output($judulLaporan.'-'.date("Y/m/d").'.pdf', 'I');
            }                       
        }
		/**
		 * load ajax detail kasus
		 */
		public function actionGetKasusPenyakitDiagnosa()
		{
			if(Yii::app()->request->isAjaxRequest) { 
				$jeniskasuspenyakit_id = $_POST['jeniskasuspenyakit_id'];
				$diagnosa_id = $_POST['diagnosa_id'];

				$modjeniskasuspenyakit = JeniskasuspenyakitM::model()->findByPK($jeniskasuspenyakit_id);
				$moddiagnosa = DiagnosaM::model()->findByPK($diagnosa_id);

				$modKasuspenyakitdiagnosa = new SAKasuspenyakitdiagnosaM;
					$tr = "<tr>";
					$tr .= "<td>"
								.$modjeniskasuspenyakit->jeniskasuspenyakit_nama
								.CHtml::activehiddenField($modKasuspenyakitdiagnosa,'[]jeniskasuspenyakit_id',array('readonly'=>true,'value'=>$jeniskasuspenyakit_id,'class'=>'jenispenyakit'))
								.CHtml::activehiddenField($modKasuspenyakitdiagnosa,'[]diagnosa_id',array('readonly'=>true,'value'=>$diagnosa_id))
								."</td>";
					$tr .= "<td>".$moddiagnosa->diagnosa_kode.' - '.$moddiagnosa->diagnosa_nama."</td>";
					$tr .= "<td>".$moddiagnosa->diagnosa_namalainnya."</td>";
					$tr .= "<td>".CHtml::link("<i class='icon-form-silang'></i>", '#', array('onclick'=>'hapusBaris(this);return false;'))."</td>";
					$tr .= "</tr>";

			   $data['tr']=$tr;
			   echo json_encode($data);
			 Yii::app()->end();
			}
		}
}