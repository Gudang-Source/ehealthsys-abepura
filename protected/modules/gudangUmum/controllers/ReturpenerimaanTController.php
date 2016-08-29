
<?php

class ReturpenerimaanTController extends MyAuthController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column1';
        public $defaultAction = 'admin';

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionIndex($id = null)
	{
                //if(!Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
		$model=new GUReturpenerimaanT;
                $modTerima = new TerimapersediaanT;
                $modDetails = array();
                $modLogin = LoginpemakaiK::model()->findByAttributes(array('loginpemakai_id' => Yii::app()->user->id));
                $model->peg_retur_id = $modLogin->pegawai_id;
                $model->tglreturterima = MyFormatter::formatDateTimeForUser(date('Y-m-d H:i:s'));
                $model->noreturterima = MyGenerator::noReturTerima();
                if (!empty($model->peg_retur_id)) $model->peg_retur_nama = $modLogin->pegawai->nama_pegawai;
                if (isset($id)){
                    
                    // Uncomment the following line if AJAX validation is needed
                    
                    $modDetails = array();
                    
                    $modTerima = TerimapersediaanT::model()->find('terimapersediaan_id  = '.$id.' and returpenerimaan_id is null');
                    $modDetailTerima = TerimapersdetailT::model()->findAll('terimapersediaan_id = '.$id.' and retpendetail_id is null');
                    if ((count($modTerima) == 1) && (count($modDetailTerima) > 0)){
                        
                        $model->terimapersediaan_id = $modTerima->terimapersediaan_id;
                        foreach ($modDetailTerima as $i=>$row){
                            $modDetails[$i]= new RetpendetailT();
                            $modDetails[$i]->terimapersdetail_id = $row->terimapersdetail_id;
                            $modDetails[$i]->jmlretur = $row->jmlterima;
                            $modDetails[$i]->hargasatuan = $row->hargasatuan;
                            $modDetails[$i]->satuanbeli = $row->satuanbeli;
                            $modDetails[$i]->kondisibarang = $row->kondisibarang;
                            $modDetails[$i]->jmlterima = $row->jmlterima;
                        }
                    }
                }
                    
                if(isset($_POST['GUReturpenerimaanT']))
                {
                        // var_dump($_POST); die;
                        $model->attributes=$_POST['GUReturpenerimaanT'];
                        $model->totalretur = str_replace(".","",$model->totalretur);
                        // var_dump($model->attributes, $model->validate(), $model->errors); die;
                        if (count($_POST['RetpendetailT']) > 0){
                        $modDetailTerima = TerimapersdetailT::model()->findAll('terimapersediaan_id = '.$model->terimapersediaan_id.' and retpendetail_id is null');
                        $modDetails = $this->validasiTabular($model, $_POST['RetpendetailT'], $modDetailTerima);
                            if ($model->validate()){
                                $transaction = Yii::app()->db->beginTransaction();
                                try{
                                    $success = true;
                                    if($model->save()){
                                        TerimapersediaanT::model()->updateByPk($model->terimapersediaan_id, array('returpenerimaan_id'=>$model->returpenerimaan_id));
                                        $modDetails = $this->validasiTabular($model, $_POST['RetpendetailT'], $modDetailTerima);
                                        foreach ($modDetails as $i=>$data){
                                            $data->hargasatuan = str_replace(".", "", $data->hargasatuan);
                                            // var_dump($data->attributes, $data->validate(), $data->errors); die;
                                            if ($data->jmlretur > 0){
                                                if ($data->save()){
                                                    InventarisasiruanganT::kurangiStokBerdasarkanInventaris($data->jmlretur, $data->terimapersdetail->inventaris->inventarisasi_id);
                                                    TerimapersdetailT::model()->updateByPk($data->terimapersdetail_id, array('retpendetail_id'=>$data->retpendetail_id));
                                                }
                                                else{
                                                    $success = false;
                                                }                                               
                                            }
                                        }
                                    }
                                    else{
                                        $success = false;
                                    }
                                    
                                    if ($success == true){
                                        $transaction->commit();
                                        Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
                                        $url = Yii::app()->createUrl('gudangUmum/TerimapersediaanT/informasi');
                                        $this->redirect($url);
                                    }
                                    else{
                                        $transaction->rollback();
                                        Yii::app()->user->setFlash('error',"Data gagal disimpan ");
                                    }
                                }
                                catch (Exception $ex){
                                     $transaction->rollback();
                                     Yii::app()->user->setFlash('error',"Data gagal disimpan ".MyExceptionMessage::getMessage($ex,true));
                                }
                            }
                        }else{
                            $model->validate();
                            Yii::app()->user->setFlash('error', '<strong>Gagal!</strong> Data detail barang harus diisi.');
                        }
                }
                
                $this->render('index',array(
                            'model'=>$model, 'modDetails'=>$modDetails, 'modTerima'=>$modTerima, 'id'=>$id,
                ));
	}
        
        protected function validasiTabular($model, $datas, $modDetailTerima){
            $valid = true;
            foreach ($datas as $i=>$data){
                $modDetails[$i] = new RetpendetailT();
                $modDetails[$i]->attributes = $data;
                $modDetails[$i]->returpenerimaan_id = $model->returpenerimaan_id;
                $modDetails[$i]->jmlterima = $modDetailTerima[$i]->jmlterima;
                $valid = $modDetails[$i]->validate() && $valid;
            }
            
            return $modDetails;
        }

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
                //if(!Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		

		if(isset($_POST['GUReturpenerimaanT']))
		{
			$model->attributes=$_POST['GUReturpenerimaanT'];
			if($model->save()){
                                Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
				$this->redirect(array('view','id'=>$model->returpenerimaan_id));
                        }
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
                        //if(!Yii::app()->user->checkAccess(Params::DEFAULT_DELETE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
			$this->loadModel($id)->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Lists all models.
	 */
//	public function actionIndex()
//	{
//		$dataProvider=new CActiveDataProvider('GUReturpenerimaanT');
//		$this->render('index',array(
//			'dataProvider'=>$dataProvider,
//		));
//	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
                
		$model=new GUReturpenerimaanT('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['GUReturpenerimaanT']))
			$model->attributes=$_GET['GUReturpenerimaanT'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=GUReturpenerimaanT::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='gureturpenerimaan-t-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
        
        /**
         *Mengubah status aktif
         * @param type $id 
         */
        public function actionRemoveTemporary($id)
	{
                //if(!Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
                //SAKabupatenM::model()->updateByPk($id, array('kabupaten_aktif'=>false));
                //$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}
        
        public function actionPrint()
        {
            $model= new GUReturpenerimaanT;
            $model->attributes=$_REQUEST['GUReturpenerimaanT'];
            $judulLaporan='Data GUReturpenerimaanT';
            $caraPrint=$_REQUEST['caraPrint'];
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
                $mpdf->WriteHTML($this->renderPartial('Print',array('model'=>$model,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint),true));
                $mpdf->Output();
            }                       
        }
        
        
        public function actionLoadPenerimaanID()
        {
            if(Yii::app()->request->isPostRequest) {
                $id = $_POST['id'];
                $modDetails = array();
                
                $modDetails = array();
                $res = array();
                
                $modTerima = TerimapersediaanT::model()->find('terimapersediaan_id  = '.$id.' and returpenerimaan_id is null');
                $modDetailTerima = TerimapersdetailT::model()->findAll('terimapersediaan_id = '.$id.' and retpendetail_id is null');
                if ((count($modTerima) == 1) && (count($modDetailTerima) > 0)){

                    //$model->terimapersediaan_id = $modTerima->terimapersediaan_id;
                    foreach ($modDetailTerima as $i=>$row){
                        $modDetails[$i]= new RetpendetailT();
                        $modDetails[$i]->terimapersdetail_id = $row->terimapersdetail_id;
                        $modDetails[$i]->jmlretur = $row->jmlterima;
                        $modDetails[$i]->hargasatuan = $row->hargasatuan;
                        $modDetails[$i]->satuanbeli = $row->satuanbeli;
                        $modDetails[$i]->kondisibarang = $row->kondisibarang;
                        $modDetails[$i]->jmlterima = $row->jmlterima;
                    }
                }
                
                $modTerima->sumberdana_id = $modTerima->sumberdana->sumberdana_nama;
                
                $res['data'] = $modTerima->attributes;
                $res['tab'] = $this->renderPartial('_rowBarang', array('modDetails' => $modDetails), true);
                
                echo CJSON::encode($res);
                
                Yii::app()->end();
            }
        }
        
        public function actionLoadPenerimaan($term)
        {
            if(Yii::app()->request->isAjaxRequest) {
                $returnVal = array();
                $nopenerimaan = $_GET['term'];
                
                $criteria = new CDbCriteria();
                $criteria->compare('lower(nopenerimaan)', strtolower($nopenerimaan), true);
                $criteria->addCondition('returpenerimaan_id is null');
                $criteria->order = 'tglterima desc';
                
                
                $dat = TerimapersediaanT::model()->findAll($criteria);
                
                foreach ($dat as $i=>$item) {
                    $returnVal[$i]['label'] = $item->nopenerimaan." - ".MyFormatter::formatDateTimeForUser($item->tglterima);
                    $returnVal[$i]['value'] = $item->terimapersediaan_id;
                }
                
                echo CJSON::encode($returnVal);
                
                Yii::app()->end();
            }
        }
}
