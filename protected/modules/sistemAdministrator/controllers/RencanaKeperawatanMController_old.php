<?php

class RencanaKeperawatanMController extends MyAuthController
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
                 if(!Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}                                             
		$model=new RencanakeperawatanM;

		// Uncomment the following line if AJAX validation is needed
		
		  if(isset($_POST['RencanakeperawatanM']))
                    {

                        $valid=true;
                        $jmlhsave=0;
//                        echo nl2br(print_r($_POST,1));
//                        exit();
                        foreach($_POST['RencanakeperawatanM'] as $i=>$item)
                        {
                            if(is_integer($i)) {
                                $model=new RencanakeperawatanM;
                                if(isset($_POST['RencanakeperawatanM'][$i]))
                                {
                                        $model->attributes=$_POST['RencanakeperawatanM'][$i];
                                        //$model->lookup_id = $_POST['LookupM']['lookup_id'];
                                        //$model->diagnosakeperawatan_kode = $_POST['DiagnosakeperawatanM']['diagnosakeperawatan_kode'];
                                        $model->diagnosakeperawatan_id = $_POST['diagnosakeperawatan_id'];
                                        $valid=$model->validate() && $valid;
//                                        echo $i;
//                                        echo nl2br(print_r($model->attributes,1));
                                    if($valid) {
                                        if ($model->save()) {
                                            $jmlhsave++;
                                        }
                                    }
                                }
                            }
                        }
                        if ($jmlhsave==COUNT($_POST['RencanakeperawatanM'])) {
                            Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
                            $this->redirect(array('admin'));
                        } else {
                            Yii::app()->user->setFlash('error', '<strong>Gagal!</strong> Data tidak valid.');
                        }
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
                if(!Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
		$model=$this->loadModel($id);
                $modRencanaKeperawatan = SARencanaKeperawatanM::model()->findAllByAttributes(array('diagnosakeperawatan_id'=>$model->diagnosakeperawatan_id));
//                                

		// Uncomment the following line if AJAX validation is needed
		

		if(isset($_POST['SARencanaKeperawatanM']))
                    {
//                    echo count($_POST['SARencanaKeperawatanM']);
//                    exit();
                        $valid=true;
                        foreach($_POST['SARencanaKeperawatanM'] as $i=>$item)
                        {
                            if(is_integer($i)) {

                                if(!empty($_POST['SARencanaKeperawatanM'][$i]['rencanakeperawatan_id'])){
                                        $model = SARencanaKeperawatanM::model()->findByPk($_POST['SARencanaKeperawatanM'][$i]['rencanakeperawatan_id']);
//                                        $model->diagnosakeperawatan_id = $_POST['SARencanaKeperawatanM'][$i]['diagnosakeperawatan_id'];
                                }else{
                                    $model=new SARencanaKeperawatanM;
                                }
//                                if(isset($_POST['SARencanaKeperawatanM'][$i]))
//                                    if ($_POST['SARencanaKeperawatanM']['diagnosakeperawatan_id'] == 0){
//                                        $_POST['SARencanaKeperawatanM']['diagnosakeperawatan_id'] = null;
//                                    }
//                                    $model->attributes=$_POST['SARencanaKeperawatanM'][$i];
//                                    if ((!empty($_POST['SARencanaKeperawatanM']['diagnosakeperawatan_id']))||(($_POST['SARencanaKeperawatanM']['diagnosakeperawatan_id']) != 0)){
//                                        RencanakeperawatanM::model()->deleteByPk($_POST['SARencanaKeperawatanM'][$i]['diagnosakeperawatan_id']);
                                
                                if(isset($_POST['SARencanaKeperawatanM'][$i]))
                                    if ($_POST['SARencanaKeperawatanM']['diagnosakeperawatan_id'] == 0){
                                        $_POST['SARencanaKeperawatanM']['diagnosakeperawatan_id'] = null;
                                    }
                                    if (empty($_POST['SARencanaKeperawatanM'][$i]['rencanakeperawatan_id'])){
                                        $model=new SARencanaKeperawatanM;
                                        $model->attributes=$_POST['SARencanaKeperawatanM'][$i];
                                        
                                    }else{
//                                        echo 'b';
                                        $model = SARencanaKeperawatanM::model()->findByPk($_POST['SARencanaKeperawatanM'][$i]['rencanakeperawatan_id']);
                                        $model->attributes=$_POST['SARencanaKeperawatanM'][$i];
                                    }
                                    
                                    if ((!empty($_POST['SARencanaKeperawatanM']['diagnosakeperawatan_id']))||(($_POST['SARencanaKeperawatanM'][$i]['diagnosakeperawatan_id']) != 0)){
                                        SARencanaKeperawatanM::model()->deleteByPk($_POST['SARencanaKeperawatanM']['diagnosakeperawatan_id']);

                                        $model->diagnosakeperawatan_id = $_POST['SARencanaKeperawatanM']['diagnosakeperawatan_id'];
                                    }
                                    if(!empty($_POST['rencanakeperawatan_id'][$i]['rencanakeperawatan_id'])){
                                        $model->rencanakeperawatan_id = $_POST['rencanakeperawatan_id'][$i]['rencanakeperawatan_id'];
                                    }
                                    //$model->lookup_id = $_POST['LookupM']['lookup_id'];
                                    $model->rencana_kode = $_POST['SARencanaKeperawatanM'][$i]['rencana_kode'];
                                   // $model->lookup_aktif = true;
//                                    echo '<pre>';
//                                    echo print_r($_POST['SARencanaKeperawatanM'][$i]);
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
	public function actionDelete($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
                        if(!Yii::app()->user->checkAccess(Params::DEFAULT_DELETE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
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
		$dataProvider=new CActiveDataProvider('SARencanaKeperawatanM');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
                if(!Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
		$model=new SARencanaKeperawatanM('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['SARencanaKeperawatanM']))
			$model->attributes=$_GET['SARencanaKeperawatanM'];

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
		$model=SARencanaKeperawatanM::model()->findByPk($id);
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
        public function actionRemoveTemporary($id)
	{
                if(!Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
               
                    SARencanaKeperawatanM::model()->updateByPk($id, array('iskolaborasiintervensi'=>false));
                    $this->redirect(isset ($_POST['returnUrl'])? $_POST['returnUrl'] : array('admin'));
                
                //SAKabupatenM::model()->updateByPk($id, array('kabupaten_aktif'=>false));
                //$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}
        
        public function actionPrint()
         {
             if(!Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}                                                 
             $model= new RencanakeperawatanM;
             $model->attributes=$_REQUEST['RencanakeperawatanM'];
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
