
<?php

class TarifTindakanController extends MyAuthController
{
	public $layout='//layouts/iframe';
	public $defaultAction = 'admin';
	public $_lastDaftarTindakanId = null;
	public $_lastDaftarTindakanId2 = null;
	public $_lastTindakanTarifId = null;
	public $_lastKelasPelayanan_id = null;
        
        public $daftartindakan_nama;

	public function actionView($id)
	{
		$model = $this->loadTarifPerdaV($id);
		$modKomponenTarif = TariftindakanM::model()->findAllByAttributes(array('daftartindakan_id'=>$model->daftartindakan_id,'jenistarif_id'=>$model->jenistarif_id,'kelaspelayanan_id'=>$model->kelaspelayanan_id),array('order'=>'komponentarif_id'));
		$this->render('view',array(
				'model'=>$model,
				'modKomponenTarif'=>$modKomponenTarif
		));
	}

	public function actionIndex()
	{
            $detailtersimpan = true;
            $model=new SATarifTindakanM;
            $modDetails=new TariftindakanM;
            $lists = array();
            $isCreate = true;
            // $model->komponentarif_id = Params::KOMPONENTARIF_ID_TOTAL;

            if(isset($_GET['jenistarif_id'])&&isset($_GET['perdatarif_id'])&&isset($_GET['perdatarif_id'])&&isset($_GET['daftartindakan_id'])){
                $isCreate = false;
                $jenistarif_id = $_GET['jenistarif_id'];
                $perdatarif_id = $_GET['perdatarif_id'];
                $kelaspelayanan_id = $_GET['kelaspelayanan_id'];
                $daftartindakan_id = $_GET['daftartindakan_id'];
                $criteria = new CDbCriteria;
                $criteria->addCondition('jenistarif_id ='.$jenistarif_id);
                $criteria->addCondition('perdatarif_id ='.$perdatarif_id);
                $criteria->addCondition('kelaspelayanan_id ='.$kelaspelayanan_id);
                $criteria->addCondition('daftartindakan_id ='.$daftartindakan_id);
                $lists = TariftindakanM::model()->findAll($criteria);
                $model->jenistarif_id = $jenistarif_id;
                $model->perdatarif_id = $perdatarif_id;
                $model->kelaspelayanan_id = $kelaspelayanan_id;
                $model->daftartindakan_id = $daftartindakan_id;
            }

            if(isset($_POST['TariftindakanM'])){
                $transaction = Yii::app()->db->beginTransaction();
                // var_dump($_POST); die;
                
                foreach ($lists as $item) {
                    $item->delete();
                }
                
                try {
                    // var_dump($_POST);
                    
                    $total = 0;
                    $modTotal = new TariftindakanM;
                    
                    foreach ($_POST['TariftindakanM'] as $i => $post) {
                        //var_dump($post);
                        //if(empty($post['tariftindakan_id'])){
                            $modDetail = new TariftindakanM;
                            $modDetail->attributes = $modTotal->attributes = $post;
                            // var_dump($modDetail->attributes); die;
                            $modDetail->create_time = date('Y-m-d H:i:s');
                            $modDetail->create_loginpemakai_id = Yii::app()->user->id;
                            $modDetail->create_ruangan = Yii::app()->user->getState('ruangan_id');
                            
                            if($modDetail->validate()){
                                $detailtersimpan &= $modDetail->save();
                                $total += $modDetail->harga_tariftindakan;
                            }else{
                                // var_dump($modDetail->errors); die;
                                $detailtersimpan &= false;
                            }
                        //}
                    }
                    
                    $modTotal->komponentarif_id = Params::KOMPONENTARIF_ID_TOTAL;
                    $modTotal->harga_tariftindakan = $total;
                    $modTotal->create_time = date('Y-m-d H:i:s');
                    $modTotal->create_loginpemakai_id = Yii::app()->user->id;
                    $modTotal->create_ruangan = Yii::app()->user->getState('ruangan_id');
                    
                    if ($modTotal->validate()) {
                        $detailtersimpan &= $modTotal->save();
                    } else {
                        var_dump($modTotal->errors);
                        $detailtersimpan &= false;
                    }
                    
                    //var_dump($detailtersimpan); die;
                    
                    if($detailtersimpan){
                        $transaction->commit();
                        $this->redirect(array('admin','sukses'=>1));
                    }
                } catch (Exception $e) {
                    $transaction->rollback();
                     Yii::app()->user->setFlash('error',"Data pasien gagal disimpan !".MyExceptionMessage::getMessage($e,true));
                }


            }
            $this->render('create',array(
		'model'=>$model,
                'modDetails'=>$modDetails,
                'lists'=>$lists,
                'isCreate'=>$isCreate,
            ));
	}
        
	public function actionDelete($id)
	{
            if (Yii::app()->request->isAjaxRequest) {
                $model = TariftindakanM::model()->findByPk($id);
                TariftindakanM::model()->deleteAllByAttributes(array(
                    'kelaspelayanan_id'=>$model->kelaspelayanan_id,
                    'daftartindakan_id'=>$model->daftartindakan_id,
                    'jenistarif_id'=>$model->jenistarif_id,
                    'perdatarif_id'=>$model->perdatarif_id,
                ));
                Yii::app()->end();
            }
	}


	public function actionAdmin()
	{
		$model=new TariftindakanperdaV('search');
		$model->unsetAttributes(); 
		if(isset($_GET['TariftindakanperdaV'])) {
			$model->attributes=$_GET['TariftindakanperdaV'];
                }

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	public function loadTarifPerdaV($id)
	{
		$model=TariftindakanperdaV::model()->findByAttributes(array('tariftindakan_id'=>$id));
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
        
	
	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='satarif-tindakan-m-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
        
    public function actionPrint()
    {
       // if(!Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
        $model= new TariftindakanperdaV;
        $model->unsetAttributes();
            if (isset($_GET['TariftindakanperdaV'])) {
                      $model->attributes=$_GET['TariftindakanperdaV'];
            }
        
        $judulLaporan='Data Tarif Tindakan';
        $caraPrint=$_REQUEST['caraPrint'];
        $perdaTarif = Params::DEFAULT_PERDA_TARIF;
        if($caraPrint=='PRINT') {
            $this->layout='//layouts/printWindows';
            $this->render('Print',array('model'=>$model,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint));
        }
        else if($caraPrint=='EXCEL') {
            $this->layout='//layouts/printExcel';
            $this->render('Print',array('model'=>$model,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint));
        }
        else if($_REQUEST['caraPrint']=='PDF') {
            $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
            $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
            $mpdf = new MyPDF('',$ukuranKertasPDF); 
            $mpdf->useOddEven = 2;  
            $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
            $mpdf->WriteHTML($stylesheet,1);  
            $mpdf->AddPage($posisi,'','','','',15,15,15,15,15,15);
            $mpdf->WriteHTML($this->renderPartial('Print',array('model'=>$model,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint,'perdaTarif'=>$per
                ),true));
            $mpdf->Output();
        }                       
    }

    public function actionAjaxGetDaftarTindakan()
    {
        if(Yii::app()->request->isAjaxRequest){

            $criteria = new CDbCriteria;
            $criteria->select = array('daftartindakan_nama, daftartindakan_id, kelaspelayanan_id, kategoritindakan_id');
            if (isset($_POST['kategoritindakan_id'])){
				if (!empty($_POST['kategoritindakan_id'])){
					$criteria->addCondition('kategoritindakan_id ='.$_POST['kategoritindakan_id']);
				}
			}
			if (isset($_POST['daftartindakan_id'])){
				if (!empty($_POST['daftartindakan_id'])){
					$criteria->addCondition('daftartindakan_id ='.$_POST['daftartindakan_id']);
				}
			}
            $criteria->order = 'daftartindakan_nama';

            $datas = DaftartindakannontarifV::model()->findAll($criteria);
            $kelas = KelaspelayananM::model()->findByPk($_POST['kelaspelayanan_id']);
            $daftartindakan = DaftartindakanM::model()->findByPk($_POST['daftartindakan_id']);

            $tarifTindakan = TariftindakanM::model()->findByAttributes(array('daftartindakan_id'=>$_POST['daftartindakan_id'], 'kelaspelayanan_id'=>$_POST['kelaspelayanan_id']));
            if (!((boolean)count($tarifTindakan))){
                $inputHiddenKomponen = '<input type="hidden" size="4" name="komponen[1]" id="komponen_1" readonly="true" value="'.Params::KOMPONENTARIF_ID_TOTAL.'"  class="komponen"/>';
                $tr = '<table id="tblInputTarifTindakan"><th> Pilih Semua <br/>'.CHtml::checkBox('checkUncheck', true, array('onclick'=>'checkUncheckAll(this);')).'</th>
                                   <th>Tindakan</th><th>'.$inputHiddenKomponen.'Tarif Total</th>';
                foreach($datas as $data)
                {
                        $td = "<tr><td>";
                        $td .= CHtml::checkBox('daftartindakan_id[1]', true, array('value'=>$data->getAttribute('daftartindakan_id')));
                        $td .= '</td><td>'.$data->getAttribute('daftartindakan_nama');
                        $td .= '</td><td>'.CHtml::textField('totalHarga[1]', '0', array('size'=>6,'class'=>'default'));
                        $td .= "</td></tr>";
                }
                $tr .= ((!empty($td)) ? $td : '');
                $returnVal['table'] = $tr;
                $returnVal['status'] = 'Not Empty';
            }
            else{
                $returnVal['status'] = 'Empty';
                $returnVal['messege'] = 'Tindakan sudah memiliki tarif';
                
            }
            if(!empty($datas)){
                echo CJSON::encode($returnVal);
            }else{
                $returnVal['status'] = 'Empty';
                $returnVal['messege'] = 'Daftar Tidak Ditemukan';
                echo CJSON::encode($returnVal);
            }
            
         } 
         Yii::app()->end();
    }
            
    public function actionTindakan()
    {
        if(Yii::app()->request->isAjaxRequest) {
            $criteria = new CDbCriteria();
            $criteria->select = array('daftartindakan_nama, daftartindakan_id,kategoritindakan_id');
            $criteria->group = 'daftartindakan_nama, daftartindakan_id, kategoritindakan_id';
            if(!empty($_GET['idKategori'])){
                $idKategori = $_GET['idKategori'];
				if (!empty($idKategori)){
					$criteria->addCondition('kategoritindakan_id ='.$idKategori);
				}
                $criteria->compare('LOWER(daftartindakan_nama)', strtolower($_GET['term']), true);
            }else{
                $criteria->compare('LOWER(daftartindakan_nama)', strtolower($_GET['term']), true);
            }
            $criteria->order = 'daftartindakan_nama';
            
            $models = DaftartindakannontarifV::model()->findAll($criteria);
			$returnVal = array();
            foreach($models as $i=>$model)
            {
                $attributes = $model->attributeNames();
                foreach($attributes as $j=>$attribute) {
                    $returnVal[$i]["$attribute"] = $model->$attribute;
                }
                $returnVal[$i]['label'] = $model->daftartindakan_nama;
                $returnVal[$i]['value'] = $model->daftartindakan_nama;
            }

            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }
	/**
	 * untuk mencari data komponen tarif total yang tidak sesuai
	 * @throws CHttpException
	 */
	public function actionCariPerbaikanTarif(){
		if(Yii::app()->request->isAjaxRequest) {
			$data['sukses'] = 0;
			$data['pesan'] = "Pencarian gagal";
			$sql_tarif = "SELECT *
				FROM tariftindakanperda_v
				OFFSET ".($_POST['pageaktif']*10)."
				LIMIT 100
				";
			$tarifKomponens = Yii::app()->db->createCommand($sql_tarif)->queryAll();

			if(count($tarifKomponens) > 0){
				foreach($tarifKomponens AS $i => $tarif){
					$model = new TariftindakanperdaV;
					$model->attributes = $tarif;
					if(!$model->IsKomponenValid){
						$data = $model->attributes;
						$data['sukses'] = 1;
						$data['pesan'] = "Data ditemukan!";
						break; //stop looping
					}else{
						$data['pesan'] = "Data tidak ditemukan!";
					}
				}
			}
			echo CJSON::encode($data);
		}else{
			throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));
		}
	}

    public function actionHapusDetailTarif()
    {   $data['status'] = 0;
        if(Yii::app()->request->isAjaxRequest) {
            if(isset($_POST['tariftindakan_id'])){
                $delete = TariftindakanM::model()->deleteByPk($_POST['tariftindakan_id']);
                if($delete){
                    $data['status'] = 1;
                }
                echo CJSON::encode($data);
            }
        }else{
           throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));
        }
    }

    public function actionSetTarifDet()
    {
        if(Yii::app()->getRequest()->getIsAjaxRequest()) {

            $jenistarif_id = $_POST['jenistarif_id'];
            $perdatarif_id = $_POST['perdatarif_id'];
            $kelaspelayanan_id = $_POST['kelaspelayanan_id'];
            $daftartindakan_id = $_POST['daftartindakan_id'];
            $isCreate = $_POST['isCreate'];

            $data['form'] = "";
            $data['error'] = 0;
            $criteria = new CDbCriteria;
            $criteria->addCondition('jenistarif_id ='.$jenistarif_id);
            $criteria->addCondition('perdatarif_id ='.$perdatarif_id);
            $criteria->addCondition('kelaspelayanan_id ='.$kelaspelayanan_id);
            $criteria->addCondition('daftartindakan_id ='.$daftartindakan_id);
            $models = TariftindakanM::model()->findAll($criteria);
           
            
            if(count($models) > 0){
                if ($isCreate) $data['error'] = 1;
                else {
                    foreach ($models AS $i=>$model){
                        $data['form'] .= $this->renderPartial('_rowDetail',array('model'=>$model),true);
                    }
                }
            }
            echo CJSON::encode($data);
            Yii::app()->end();
        }
    }
    
                
                           
}
