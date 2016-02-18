<?php

class DiagnosakeperawatanMController extends MyAuthController
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
		$model=new DiagnosakeperawatanM;
                $modKriteriaHasil = new RIKriteriahasilM();
                $modDiagnosakeperawatanM = new RIDiagnosakeperawatanM();
                $modDiagnosa = array();
		// Uncomment the following line if AJAX validation is needed
		

		  if(isset($_POST['DiagnosakeperawatanM'])) {
                                    $valid=true;
                                    foreach($_POST['DiagnosakeperawatanM'] as $i=>$item)
                                    {
                                        if(is_integer($i)) {
                                            $model=new DiagnosakeperawatanM;
                                            if(isset($_POST['DiagnosakeperawatanM'][$i]))
                                                $model->attributes=$_POST['DiagnosakeperawatanM'][$i];
                                                //$model->lookup_id = $_POST['LookupM']['lookup_id'];
                                                //$model->diagnosakeperawatan_kode = $_POST['DiagnosakeperawatanM']['diagnosakeperawatan_kode'];
                                                $model->diagnosa_keperawatan_aktif = true;
                                                $model->diagnosa_id = $_POST['DiagnosakeperawatanM']['diagnosa_id'];
                                                $valid=$model->validate() && $valid;
                                            if($valid) {
                                                if ($model->save()) {
                                                    Yii::app()->user->setFlash('success', '<strong>Berhasil</strong> Data berhasil disimpan');
                                                }
                                            }
                                        }
                                    }
                                    $this->redirect(array('admin'));
                              }   

		$this->render('create',array(
			'model'=>$model,
                        'modKriteriaHasil'=>$modKriteriaHasil,
                        'modDiagnosakeperawatanM'=>$modDiagnosakeperawatanM,
                        'modDiagnosa'=>$modDiagnosa
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
            //$dataDiagnosakeperawatan = RIDiagnosakeperawatanM::model()->with('diagnosa')->findAllByAttributes(array('diagnosa_id'=>$model->diagnosa_id));
            $modIdDiagnosa = RIDiagnosakeperawatanM::model()->findAllByAttributes(array('diagnosakeperawatan_id'=>$model->diagnosakeperawatan_id));
            $modDiagnosa = RIDiagnosaM::model()->findByPk($model->diagnosakeperawatan_id);
            $model=new DiagnosakeperawatanM;
            $modKriteriaHasil = new RIKriteriahasilM();
            $modDiagnosakeperawatanM = new RIDiagnosakeperawatanM();

            if(isset($_POST['RIDiagnosakeperawatanM']))
            {
                $valid=true;
                $relasi = false;
                foreach($_POST['RIDiagnosakeperawatanM'] as $i=>$item)
                {
                    if(is_integer($i)) {
                        $model=new DiagnosakeperawatanM;
                        if(isset($_POST['RIDiagnosakeperawatanM'][$i])){
                            $model->attributes=$_POST['RIDiagnosakeperawatanM'][$i];
//                            $model->diagnosakeperawatan_kode = $_POST['DiagnosakeperawatanM']['diagnosakeperawatan_kode'];
                            $selectImplementasi = ImplementasikeperawatanM::model()->findAllByAttributes(array('diagnosakeperawatan_id'=>$id));
                            $selectRencana = RencanakeperawatanM::model()->findAllByAttributes(array('diagnosakeperawatan_id'=>$id));
                            $selectKriteriaHasil = KriteriahasilM::model()->findAllByAttributes(array('diagnosakeperawatan_id'=>$id));
                            if(count($selectImplementasi) > 0){
//                                $deleteImplementasi = ImplementasikeperawatanM::model()->deleteAllByAttributes(array('diagnosakeperawatan_id'=>$id));
                                $relasi = true;
                            }
                            
                            if(count($selectRencana) > 0){
//                                $deleteRencana = RencanakeperawatanM::model()->deleteAllByAttributes(array('diagnosakeperawatan_id'=>$id));
                                $relasi = true;
                            }
                            
                            if(count($selectKriteriaHasil)>0){
//                                $deleteKriteriaHasil = KriteriahasilM::model()->deleteAllByAttributes(array('diagnosakeperawatan_id'=>$id));
                                $relasi = true;
                            }
                            
                            if($relasi == true){
                                $attributes = array('diagnosakeperawatan_kode'=>$_POST['RIDiagnosakeperawatanM'][$i]['diagnosakeperawatan_kode'],'diagnosa_medis'=>$_POST['RIDiagnosakeperawatanM'][$i]['diagnosa_medis'],'diagnosa_keperawatan'=>$_POST['RIDiagnosakeperawatanM'][$i]['diagnosa_keperawatan'],'diagnosa_tujuan'=>$_POST['RIDiagnosakeperawatanM'][$i]['diagnosa_tujuan']);
                                DiagnosakeperawatanM::model()->updateByPk($_POST['RIDiagnosakeperawatanM'][$i]['diagnosakeperawatan_id'],$attributes);
                            }else{
                                RIDiagnosakeperawatanM::model()->deleteByPk($_POST['RIDiagnosakeperawatanM'][$i]['diagnosakeperawatan_id']);
                            }
                            
                            if (!empty($modDiagnosa->diagnosa_id)){                                
                                $model->diagnosa_id = $modDiagnosa->diagnosa_id;
                            }
                            if(!empty($_POST['diagnosakeperawatan_id'][$i]['diagnosakeperawatan_id'])){
                                $model->diagnosakeperawatan_id = $_POST['diagnosakeperawatan_id'][$i]['diagnosakeperawatan_id'];
                            }
                            $valid=$model->validate() && $valid;
                            if($valid) {
                                $model->save();
                                    Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
                            } else {
                                    Yii::app()->user->setFlash('error', '<strong>Gagal!</strong> Data tidak valid.');
                            }
                        } 
                    }
                    else {
                            Yii::app()->user->setFlash('error', '<strong>Gagal!</strong> Data tidak valid.');
                    }
                }  
                $this->redirect(array('admin'));
            }

            $this->render('update',array(
                    'model'=>$model,
                    'modIdDiagnosa'=>$modIdDiagnosa,
                    'modKriteriaHasil'=>$modKriteriaHasil,
                    'modDiagnosakeperawatanM'=>$modDiagnosakeperawatanM,
                    'modDiagnosa' => $modDiagnosa
            ));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('RIDiagnosakeperawatanM');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
                
		$model=new RIDiagnosakeperawatanM('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['RIDiagnosakeperawatanM']))
			$model->attributes=$_GET['RIDiagnosakeperawatanM'];

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
		$model=RIDiagnosakeperawatanM::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='sadiagnosakeperawatan-m-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	public function actionDelete()
	{
		//if(!Yii::app()->user->checkAccess(Params::DEFAULT_DELETE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
		if(Yii::app()->request->isPostRequest)
		{
					$id = $_POST['id'];
                    $rencanaKeperawatan = RencanakeperawatanM::model()->findByAttributes(array('diagnosakeperawatan_id'=>$id));
                    if ($rencanaKeperawatan){
                                echo CJSON::encode(array(
                                    'status'=>'error',
                                    ));
                                exit();
                                            //throw new CHttpException(400,'Maaf data ini tidak bisa dihapus dikarenakan digunakan pada table lain.');
                    }else{
                        $this->loadModel($id)->delete();
                        if (Yii::app()->request->isAjaxRequest)
                            {
                                echo CJSON::encode(array(
                                    'status'=>'proses_form', 
                                    'div'=>"<div class='flash-success'>Data berhasil dihapus.</div>",
                                    ));
                                exit();
                            }
                    }
	                    
			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

     /**
     *Mengubah status aktif
     * @param type $id 
     */
    public function actionRemoveTemporary()
    {
                //if(!Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
//                    SAPropinsiM::model()->updateByPk($id, array('propinsi_aktif'=>false));
//                    $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
              
        
        $id = $_POST['id'];   
        if(isset($_POST['id']))
        {
           $update = DiagnosakeperawatanM::model()->updateByPk($id,array('diagnosa_keperawatan_aktif'=>false));
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
                                                              
             $model= new DiagnosakeperawatanM;
             $model->attributes=$_REQUEST['RIDiagnosakeperawatanM'];
             $judulLaporan='Laporan Diagnosa Keperawatan';
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
