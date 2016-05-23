<?php

class LookupMController extends MyAuthController
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
    public function actionCreate()
    {
                //if(!Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}                                             
		$model=new LookupM;
		$model->lookup_type ="jenistransaksi";
		// Uncomment the following line if AJAX validation is needed
		

                
                
		  if(isset($_POST['LookupM']))
                    {
                        $valid=true;
                        foreach($_POST['LookupM'] as $i=>$item)
                        {
                            if(is_integer($i)) {
                                $model=new LookupM;
                                if(isset($_POST['LookupM'][$i]))

                                    $model->attributes=$_POST['LookupM'][$i];
                                    $model->lookup_type = $_POST['LookupM']['lookup_type'];
                                    $model->lookup_aktif = true;
                                    $valid=$model->validate() && $valid;
                                    echo $i;
                                if($valid) {
                                    $model->save();
                                        Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
                                } else {
                                        Yii::app()->user->setFlash('error', '<strong>Gagal!</strong> Data tidak valid.');
                                }
                            }
                        }
                        $this->redirect(array('admin','sukses'=>1));
                      }   

		$this->render('create',array(
			'model'=>$model,
		));
    }
    
    private function validasiTabular($postarray,$insert){
        $models = null;
        if(empty($insert)){     
            if (count($postarray) > 0){
                foreach ($postarray as $key => $value) {
                    if (is_integer($key)){
                        $models[$key] = new LookupM();
                        $models[$key]->attributes = $value;
                        $models[$key]->lookup_type = "jenistransaksi";
                        $models[$key]->validate();
                    }
                }
            }
        }else{
            if(count($postarray > 0)){ 
                foreach ($postarray as $key => $value) {
                    if(is_integer($key)){
//                        $models[$key] = new LookupM('update'); ini juga bisa
                        if (empty($value['lookup_id'])){
                            $models[$key] = new LookupM();
                            $models[$key]->attributes = $value;
                            $models[$key]->lookup_id = null;
                            $models[$key]->lookup_type = 'jenistransaksi';
                            $models[$key]->validate();
                        }else{
                            $models[$key] = LookupM::model()->findByPk($value['lookup_id']);
                            $models[$key]->lookup_type = 'jenistransaksi';
                            $models[$key]->attributes = $value;
                        }
                        
                    }
                }
            }
        }
        return $models;
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id)
    {
//                if(!Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}                                                        
		$model=$this->loadModel($id);
                $model->lookup_type = "jenistransaksi";
                $modLookup = LookupM::model()->findAllByAttributes(array('lookup_type'=>$model->lookup_type));
		// Uncomment the following line if AJAX validation is needed
		
                
		if(isset($_POST['LookupM']))
                    {
                        $insert = 1;
                        $modLookup = $this->validasiTabular($_POST['LookupM'],$insert);
                        
                        $transaction = Yii::app()->db->beginTransaction();
                        try {
                            $jumlah = count($modLookup);
                            $jumlahupdate = 0;
                            if($jumlah > 0){
                                foreach ($modLookup as $key => $value) {
                                    if ($value->save()){
//                                      $pk=$value->lookup_id;                       
//                                      $update = LookupM::model()->updateByPk($pk, $value->attributes);
//                                      if($update){
                                          $jumlahupdate++;
                                    }
                                }
                            }
                            
                            if(($jumlah>0) && ($jumlahupdate>0) && ($jumlah == $jumlahupdate)){
                                $transaction->commit();
                                Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
                                $this->redirect(array('admin','sukses'=>1));
                            }else{
                                $transaction->rollback();
                                Yii::app()->user->setFlash('error', '<strong>Gagal!</strong> Data tidak valid.');
                            }
                        
                        }  catch (Exception $exc){
                            $transaction->rollback();
                             Yii::app()->user->setFlash('error', '<strong>Gagal!</strong> Data tidak valid.'.MyExceptionMessage::getMessage($exc));
                        }
//                        foreach($_POST['KULookupM'] as $i=>$item)
//                        {
//                            $model->attributes=$_POST['KULookupM'][$i];
//                                    echo "<pre>";
//                                    echo print_r($model->attributes);
//                            if(is_integer($i)) {
//                                $model=new LookupM;
//                                if(isset($_POST['KULookupM'][$i]))
//                                    if ($_POST['KULookupM'][$i]['lookup_id'] == 0){
//                                        $_POST['KULookupM'][$i]['lookup_id'] = null;
//                                    }
//                                    $model->attributes=$_POST['KULookupM'][$i];
//                                    if ((!empty($_POST['KULookupM'][$i]['lookup_id']))||(($_POST['KULookupM'][$i]['lookup_id']) != 0)){
//                                        LookupM::model()->deleteByPk($_POST['KULookupM'][$i]['lookup_id']);
//                                        $model->lookup_id = $_POST['KULookupM'][$i]['lookup_id'];
//                                    }
//                                    
//                                    //$model->lookup_id = $_POST['LookupM']['lookup_id'];
//                                    $model->lookup_type = $_POST['KULookupM']['lookup_type'];
//                                    $model->lookup_aktif = true;
//                                    $valid=$model->validate() && $valid;
//                                    echo $i;
//                                if($valid) {
//                                    $model->save();
//                                        Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
//                                } else {
//                                        Yii::app()->user->setFlash('error', '<strong>Gagal!</strong> Data tidak valid.');
//                                }
//                            }
//                        }
                       
                      }   

		$this->render('update',array(
			'model'=>$model,
                        'modLookup'=>$modLookup
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
    public function actionIndex()
    {
        $dataProvider=new CActiveDataProvider('KULookupM');
        $this->render('index',array(
            'dataProvider'=>$dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin($sukses='')
    {
        if ($sukses == 1):
            Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
        endif;
                
        $model=new KULookupM('searchJenisTransaksi');
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['KULookupM']))
            $model->attributes=$_GET['KULookupM'];

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
        $model=KULookupM::model()->findByPk($id);
        if($model===null)
            throw new CHttpException(404,'The requested page does not exist.');
        return $model;
    }
	public function actionNonActive($id)
	{
		if(Yii::app()->request->isAjaxRequest)
		{
			$data['sukses']=0;
			$model = $this->loadModel($id);
			// set non-active this
			// example: 
			 $model->lookup_aktif = false;
			 if($model->save()){
				$data['sukses'] = 1;
			 }
			echo CJSON::encode($data); 
		}
	}
	/**
	 * Memanggil dan menonaktifkan status 
	 */
//	public function actionActive($id)
//	{
//		if(Yii::app()->request->isAjaxRequest)
//		{
//			$data['sukses']=0;
//			$model = $this->loadModel($id);
//			// set non-active this
//			// example: 
//			 $model->lookup_aktif = true;
//			 if($model->save()){
//				$data['sukses'] = 1;
//			 }
//			echo CJSON::encode($data); 
//		}
//	}

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if(isset($_POST['ajax']) && $_POST['ajax']==='salookup-m-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
        
        /**
         *Mengubah status aktif
         * @param type $id 
         */
        public function actionRemoveTemporary()
    {
                //if(!Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
                //SAKabupatenM::model()->updateByPk($id, array('kabupaten_aktif'=>false));
                //$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
//			 $id = $_POST['id'];   
//        if(isset($_POST['id']))
//        {
//           $update = KULookupM::model()->updateByPk($id,array('lookup_aktif'=>false));
//           if($update)
//            {
//                if (Yii::app()->request->isAjaxRequest)
//                {
//                    echo CJSON::encode(array(
//                        'status'=>'proses_form', 
//                        ));
//                    exit;               
//                }
//             }
//        } else {
//                if (Yii::app()->request->isAjaxRequest)
//                {
//                    echo CJSON::encode(array(
//                        'status'=>'proses_form', 
//                        ));
//                    exit;               
//                }
//        }

    }
        
        public function actionPrint()
        {
            $model= new KULookupM;
            $model->attributes=$_REQUEST['KULookupM'];
            $judulLaporan='Data Jenis Transaksi';
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
                $mpdf->Output($judulLaporan.'_'.date('Y-m-d').'.pdf','I');
            }                       
        }
}