<?php
class JurnalRekPenjaminController extends MyAuthController
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
                $model=AKPenjaminRekM::model()->findByAttributes(array('penjamin_id'=>$id));
                
		$this->render('view',array(
			'model'=>$model,
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
                //if(!Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
		$model=new AKPenjaminRekM();       
		$modPenjamin = new AKPenjaminpasienM();
		$modDetails = array();
		$model->rekening5_id = isset($_POST['AKPenjaminRekM']['rekening'][1]['rekening5_id']) ? $_POST['AKPenjaminRekM']['rekening'][1]['rekening5_id'] : null;
		if (isset($_GET['AKPenjaminpasienM'])){
				$modPenjamin->unsetAttributes();
				$modPenjamin->attributes=$_GET['AKPenjaminpasienM'];
				$modPenjamin->penjamin_nama = isset($_GET['AKPenjaminpasienM']['penjamin_nama'])?$_GET['AKPenjaminpasienM']['penjamin_nama']:null;
				$modPenjamin->carabayar_nama = isset($_GET['AKPenjaminpasienM']['carabayar_nama'])?$_GET['AKPenjaminpasienM']['carabayar_nama']:null;
		}
		if (isset($_GET['AKPenjaminRekM'])) {
			$model->attributes = $_GET['AKPenjaminRekM'];
		}
		if(isset($_POST['AKPenjaminRekM']))
		{
                            $transaction = Yii::app()->db->beginTransaction();
                            try{
                                 $success = true;
                                 $modDetails = $this->validasiTabular($_POST['AKPenjaminRekM']);
                                    foreach ($modDetails as $i => $data) {
    //                                    echo '<pre>';
    //                                    echo print_r($data->jmlsisapiutang);
    //                                    echo exit();
                                        
                                            if ($data->save()) {
                                                $success = true;
                                                
                                            } else {
                                                $success = false;
                                            }
                                            echo '<pre>';
                                            echo print_r($data->getErrors());
                                            echo '</pre>';
//                                          exit();
                                    }
                                
                                if ($success == true) {
                                    $transaction->commit();
                                    Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
                                    $this->redirect(array('admin','id'=>1));
                                } else {
                                    $transaction->rollback();
                                    Yii::app()->user->setFlash('error', "Data gagal disimpan ");
                                }
                                
                            }
                            catch(Exception $ex){
                                $transaction->rollback();
                                Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($ex, true));
                            }

		}

		$this->render('create',array(
			'model'=>$model, 'modDetails'=>$modDetails,
                        'modPenjamin'=>$modPenjamin,
		));
	}
        
        protected function validasiTabular($data){
            $x = 0;
            foreach ($data['rekening'] as $i => $row) {
                foreach($data['penjamin'] as $key=>$datas){
                    $modDetails[$x] = new AKPenjaminRekM;                    
                    $modDetails[$x]->attributes = $row; 
                    $modDetails[$x]->penjamin_id = $key;               
//                    $modDetails[$x]->rekening1_id = $row['rekening1_id'];
//                    $modDetails[$x]->rekening2_id = $row['rekening2_id'];
//                    $modDetails[$x]->rekening3_id = $row['rekening3_id'];
//                    $modDetails[$x]->rekening4_id = $row['rekening4_id'];
                    $modDetails[$x]->rekening5_id = $row['rekening5_id'];
//                    $modDetails[$x]->saldonormal = $row['saldonormal'];                    
                    $modDetails[$x]->validate();
                    $x++;
                    
                    /*
                    if($datas['pilihPenjamin'] == 1){

                    } 
                     * 
                     */  
            }
                    
                
    //            echo '<pre>';
    //            echo print_r($modDetails[$i]->getErrors());
    //            echo '</pre>';
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
		$model=AKPenjaminpasienM::model()->findByPk($id);

		// Uncomment the following line if AJAX validation is needed
		

		if(isset($_POST['AKPenjaminpasienM']))
		{
			$model->attributes=$_POST['AKPenjaminpasienM'];
			if($model->save()){
                                Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
				$this->redirect(array('admin','id'=>$model->penjamin_id));
                        }
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

         public function actionUbahRekeningDebit($id)
	{
                //if(!Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
				$this->layout = '//layouts/iframe';
                $model= AKPenjaminRekM::model()->findByPk($id);
                $modPenjamin = AKPenjaminpasienM::model()->findByPk($model->penjamin_id);

		// Uncomment the following line if AJAX validation is needed
		

		if(isset($_POST['AKPenjaminrekM']))
		{
                        $model->attributes=$_POST['AKPenjaminrekM'];
                        $view = 'UbahRekeningDebit';
                           
                        $update = AKPenjaminrekM::model()->updateByPk($id,array('rekening5_id'=>$_POST['AKPenjaminrekM']['rekening5_id']));
			if($update){
                                Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
				if (isset($_GET['frame']) && !empty($_GET['idPenjamin'])){
                                    $this->redirect(array(((isset($view)) ? $view : 'UbahRekeningDebitKredit'),'id'=>$model->penjaminrek_id, 'frame'=>$_GET['frame'], 'idPenjamin'=>$_GET['idPenjamin']));
                                }else{
                                    $this->redirect(array(((isset($view)) ? $view : 'admin'),'id'=>$model->penjamin_id));
                                }
                        }
                }

		$this->render(((isset($view)) ? $view : '_ubahRekeningDebit'),array(
			'model'=>$model,
                        'modPenjamin'=>$modPenjamin
		));
	}
         public function actionUbahRekeningKredit($id)
	{
                //if(!Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
				$this->layout = '//layouts/iframe';
                $model= AKPenjaminRekM::model()->findByPk($id);
                $modPenjamin = AKPenjaminpasienM::model()->findByPk($model->penjamin_id);

		// Uncomment the following line if AJAX validation is needed
		

		if(isset($_POST['AKPenjaminrekM']))
		{
                        $model->attributes=$_POST['AKPenjaminrekM'];
                        $view = 'UbahRekeningKredit';
                           
                        $update = AKPenjaminrekM::model()->updateByPk($id,array('rekening5_id'=>$_POST['AKPenjaminrekM']['rekening5_id']));
			if($update){
                                Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
				if (isset($_GET['frame']) && !empty($_GET['idPenjamin'])){
                                    $this->redirect(array(((isset($view)) ? $view : 'UbahRekeningDebitKredit'),'id'=>$model->penjaminrek_id, 'frame'=>$_GET['frame'], 'idPenjamin'=>$_GET['idPenjamin']));
                                }else{
                                    $this->redirect(array(((isset($view)) ? $view : 'admin'),'id'=>$model->penjamin_id));
                                }
                        }
                }

		$this->render(((isset($view)) ? $view : '_ubahRekeningKredit'),array(
			'model'=>$model,
                        'modPenjamin'=>$modPenjamin
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
                        $model = AKPenjaminRekM::model()->deleteAllByAttributes(array('penjamin_id'=>$id));
                        
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
		$dataProvider=new CActiveDataProvider('AKPenjaminpasienM');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin($id='')
	{
                if ($id == 1):
                    Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
                endif;
                
		$model=new AKPenjaminRekM('search');
		$model->unsetAttributes(); 
                
		if(isset($_GET['AKPenjaminRekM'])){
			$model->attributes=$_GET['AKPenjaminRekM'];
		}
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
		$model=AKPenjaminpasienM::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
        
        public function loadDelete($id)
	{
		$model=AKPenjaminpasienM::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='penjaminpasien-m-form')
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
                AKPenjaminpasienM::model()->updateByPk($id, array('penjamin_aktif '=>false));
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}
        
        public function actionPrint()
        {
            $model= new AKPenjaminRekM;
			if(isset($_REQUEST['AKPenjaminRekM'])){
				$model->attributes=$_REQUEST['AKPenjaminRekM'];		
				$model->carabayar_nama = !empty($_REQUEST['AKPenjaminRekM']['carabayar_nama'])?$_REQUEST['AKPenjaminRekM']['carabayar_nama']:null;				
			}
            $judulLaporan='Data Jurnal Rekening Penjamin ';
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
                $mpdf->Output($judulLaporan.'-'.date('Y/m/d').'.pdf','I');
            }                       
        }
		
		/* jurnal rek penjamin */
    public function actionGetRekeningEditDebitPenjamin()
    {
          if(Yii::app()->request->isAjaxRequest) {
              
              $rekening5_id =$_POST['rekening5_id'];
              $penjamin_id =$_POST['penjamin_id'];
              $penjaminrek_id =$_POST['penjaminrek_id'];
              
               $update =  AKPenjaminRekM::model()->updateByPk($penjaminrek_id, array('rekening5_id'=>$rekening5_id));
                if($update){
                    $data['pesan']='<div class="flash-success">Ubah Data Rekening <b></b> Berhasil  Disimpan </div>';
                }else{
                    $data['pesan']='<div class="flash-error">Ubah Data Rekening <b></b> Gagal  Disimpan </div>';
                }
              echo json_encode($data);
         Yii::app()->end();
        }
    }
    
    
    public function actionGetRekeningEditKreditPenjamin()

    {
          if(Yii::app()->request->isAjaxRequest) {
              
              $rekening5_id =$_POST['rekening5_id'];

              $penjamin_id =$_POST['penjamin_id'];
              $penjaminrek_id =$_POST['penjaminrek_id'];
              
               $update =  AKPenjaminRekM::model()->updateByPk($penjaminrek_id, array('rekening5_id'=>$rekening5_id));
                if($update){
                    $data['pesan']='<div class="flash-success">Ubah Data Rekening <b></b> Berhasil  Disimpan </div>';
                }else{
                    $data['pesan']='<div class="flash-error">Ubah Data Rekening <b></b> Gagal  Disimpan </div>';
                }
              echo json_encode($data);
         Yii::app()->end();
        }
    }


    /*end jurnal rek penjamin */
        
}
