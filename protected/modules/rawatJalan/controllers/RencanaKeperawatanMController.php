
<?php

class RencanaKeperawatanMController extends MyAuthController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/iframe';
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
		$model=new RencanakeperawatanM;

		// Uncomment the following line if AJAX validation is needed
		

		  if(isset($_POST['RencanakeperawatanM']))
                    {

                        $valid=true;
                        foreach($_POST['RencanakeperawatanM'] as $i=>$item)
                        {
                            if(is_integer($i)) {
                                $model=new RencanakeperawatanM;
                                if(isset($_POST['RencanakeperawatanM'][$i]))
                                    
                                    $model->attributes=$_POST['RencanakeperawatanM'][$i];
                                    //$model->lookup_id = $_POST['LookupM']['lookup_id'];
                                    //$model->diagnosakeperawatan_kode = $_POST['DiagnosakeperawatanM']['diagnosakeperawatan_kode'];
                                    $model->diagnosakeperawatan_id = $_POST['RencanakeperawatanM']['diagnosakeperawatan_id'];
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
                        $this->redirect(array('admin'));
                      }   

		$this->render('create',array(
			'model'=>$model,
		));
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
                $modRencanaKeperawatan = RJRencanaKeperawatanM::model()->findAllByAttributes(array('diagnosakeperawatan_id'=>$model->diagnosakeperawatan_id));
//                                

		// Uncomment the following line if AJAX validation is needed
		

		if(isset($_POST['RJRencanaKeperawatanM']))
                    {
//                    echo count($_POST['RJRencanaKeperawatanM']);
//                    exit();
                        $valid=true;
                        foreach($_POST['RJRencanaKeperawatanM'] as $i=>$item)
                        {
                            if(is_integer($i)) {

                                if(!empty($_POST['RJRencanaKeperawatanM'][$i]['rencanakeperawatan_id'])){
                                        $model = RJRencanaKeperawatanM::model()->findByPk($_POST['RJRencanaKeperawatanM'][$i]['rencanakeperawatan_id']);
//                                        $model->diagnosakeperawatan_id = $_POST['RJRencanaKeperawatanM'][$i]['diagnosakeperawatan_id'];
                                }else{
                                    $model=new RJRencanaKeperawatanM;
                                }
//                                if(isset($_POST['RJRencanaKeperawatanM'][$i]))
//                                    if ($_POST['RJRencanaKeperawatanM']['diagnosakeperawatan_id'] == 0){
//                                        $_POST['RJRencanaKeperawatanM']['diagnosakeperawatan_id'] = null;
//                                    }
//                                    $model->attributes=$_POST['RJRencanaKeperawatanM'][$i];
//                                    if ((!empty($_POST['RJRencanaKeperawatanM']['diagnosakeperawatan_id']))||(($_POST['RJRencanaKeperawatanM']['diagnosakeperawatan_id']) != 0)){
//                                        RencanakeperawatanM::model()->deleteByPk($_POST['RJRencanaKeperawatanM'][$i]['diagnosakeperawatan_id']);
                                
                                if(isset($_POST['RJRencanaKeperawatanM'][$i]))
                                    if ($_POST['RJRencanaKeperawatanM']['diagnosakeperawatan_id'] == 0){
                                        $_POST['RJRencanaKeperawatanM']['diagnosakeperawatan_id'] = null;
                                    }
                                    if (empty($_POST['RJRencanaKeperawatanM'][$i]['rencanakeperawatan_id'])){
                                        $model=new RJRencanaKeperawatanM;
                                        $model->attributes=$_POST['RJRencanaKeperawatanM'][$i];
                                        
                                    }else{
//                                        echo 'b';
                                        $model = RJRencanaKeperawatanM::model()->findByPk($_POST['RJRencanaKeperawatanM'][$i]['rencanakeperawatan_id']);
                                        $model->attributes=$_POST['RJRencanaKeperawatanM'][$i];
                                    }
                                    
                                    if ((!empty($_POST['RJRencanaKeperawatanM']['diagnosakeperawatan_id']))||(($_POST['RJRencanaKeperawatanM'][$i]['diagnosakeperawatan_id']) != 0)){
                                        RJRencanaKeperawatanM::model()->deleteByPk($_POST['RJRencanaKeperawatanM']['diagnosakeperawatan_id']);

                                        $model->diagnosakeperawatan_id = $_POST['RJRencanaKeperawatanM']['diagnosakeperawatan_id'];
                                    }
                                    if(!empty($_POST['rencanakeperawatan_id'][$i]['rencanakeperawatan_id'])){
                                        $model->rencanakeperawatan_id = $_POST['rencanakeperawatan_id'][$i]['rencanakeperawatan_id'];
                                    }
                                    //$model->lookup_id = $_POST['LookupM']['lookup_id'];
                                    $model->rencana_kode = $_POST['RJRencanaKeperawatanM'][$i]['rencana_kode'];
                                   // $model->lookup_aktif = true;
//                                    echo '<pre>';
//                                    echo print_r($_POST['RJRencanaKeperawatanM'][$i]);
//                                    echo '<pre>';
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
                        $this->redirect(array('admin'));
                      }   

		$this->render('update',array(
			'model'=>$model,
                        'modRencanaKeperawatan'=>$modRencanaKeperawatan,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
//	public function actionDelete($id)
//	{
//		if(Yii::app()->request->isPostRequest)
//		{
//			// we only allow deletion via POST request
//                        //if(!Yii::app()->user->checkAccess(Params::DEFAULT_DELETE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
//			$this->loadModel($id)->delete();
//
//			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
//			if(!isset($_GET['ajax']))
//				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
//		}
//		else
//			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
//	}

        public function actionDelete()
        {              
            //if(!Yii::app()->user->checkAccess(Params::DEFAULT_DELETE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
            if(Yii::app()->request->isPostRequest)
            {
            $transaction = Yii::app()->db->beginTransaction();
            try{
                $id = $_POST['id'];
                $rencanakeperawatan = RJRencanaKeperawatanM::model()->findByAttributes(array('rencanakeperawatan_id'=>$id));
                if ($rencanakeperawatan){
                            echo CJSON::encode(array(
                                'status'=>'error',
                                ));
                            $transaction->rollback();
                            exit();
                }else{
                    $this->loadModel($id)->delete();
                    if (Yii::app()->request->isAjaxRequest)
                        {
                            echo CJSON::encode(array(
                                'status'=>'proses_form', 
                                'div'=>"<div class='flash-success'>Data berhasil dihapus.</div>",
                                ));
                            $transaction->commit();
                            exit;               
                        }
                }

                            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
                            if(!isset($_GET['ajax']))
                                    $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));

                    } catch (Exception $exc) {
                        $transaction->rollback();
                        echo CJSON::encode(array(
                                                    'status'=>'error',
                                                    ));
                                                exit();
                        }
                }
                 else
                    throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
        }
	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('RJRencanaKeperawatanM');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
                
		$model=new RJRencanaKeperawatanM('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['RJRencanaKeperawatanM']))
			$model->attributes=$_GET['RJRencanaKeperawatanM'];

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
		$model=RJRencanaKeperawatanM::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='sarencana-keperawatan-m-form')
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

            $id = $_POST['id'];   
            if(isset($_POST['id']))
            {
               $update = RJRencanaKeperawatanM::model()->updateByPk($id,array('iskolaborasiintervensi'=>false));
               if($update)
                {
                    if (Yii::app()->request->isAjaxRequest)
                    {
                        echo CJSON::encode(array(
                            'status'=>'proses_form', 
                            ));
                        exit;               
                    }
                 }
            } else {
                    if (Yii::app()->request->isAjaxRequest)
                    {
                        echo CJSON::encode(array(
                            'status'=>'proses_form', 
                            ));
                        exit;               
                    }
            }

        }
        
        public function actionPrint()
         {
                                                              
             $model= new RencanakeperawatanM;
             $model->attributes=$_REQUEST['RJRencanaKeperawatanM'];
             $judulLaporan='Laporan Rencana Keperawatan';
             $caraPrint=$_REQUEST['caraPrint'];
            if($caraPrint=='PRINT')
                {
                    $this->layout='//layouts/printWindows';
                    $this->render('Print',array('model'=>$model,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint));
                }
            else if($caraPrint=='EXCEL')    
                {
                    $this->layout='//layouts/printExcel';
                    $this->render('Print',array('model'=>$model,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint));
                }
            else if($_REQUEST['caraPrint']=='PDF')
                {
                   
                    $ukuranKertasPDF=Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
                    $posisi=Yii::app()->user->getState('posisi_kertas');                            //Posisi L->Landscape,P->Portait
                    $mpdf=new MyPDF('',$ukuranKertasPDF); 
                    $mpdf->useOddEven = 2;  
                    $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
                    $mpdf->WriteHTML($stylesheet,1);  
                    $mpdf->AddPage($posisi,'','','','',15,15,15,15,15,15);
                    $mpdf->WriteHTML($this->renderPartial('Print',array('model'=>$model,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint),true));
                    $mpdf->Output();
                }                       
         }
}
