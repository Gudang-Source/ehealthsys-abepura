<?php

class KadarObatMController extends MyAuthController
{
    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout='//layouts/iframe'; //diakses dari tab menu master - master obat
	public $defaultAction = 'admin';

	public $path_view = 'sistemAdministrator.views.kadarObatM.';

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id)
    {
        $this->render($this->path_view.'view',array(
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
		$model=new SALookupM;
                
                $model->lookup_type = PARAMS::LOOKUPTYPE_OBATALKES_KADAROBAT;
		// Uncomment the following line if AJAX validation is needed
		
                
		  if(isset($_POST['SALookupM']))
                    {
                      
//                        $valid=true;
//                        foreach($_POST['SALookupM'] as $i=>$item)
//                        {
                            
//                            if(is_int($i)) {
                                $model=new SALookupM;
                                if(isset($_POST['SALookupM']))
									
                                    $model->attributes=$_POST['SALookupM'];
//                                    $model->lookup_id = $_POST['SALookupM']['lookup_id'];
                                    $model->lookup_type = PARAMS::LOOKUPTYPE_OBATALKES_KADAROBAT;
                                    $model->lookup_aktif = true;
                                    
//                                    $valid=$model->validate() && $valid;
//                                    echo $i;
//                                if($valid) {
                                  if($model->save()) {
                                        Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
                                } else {
                                        Yii::app()->user->setFlash('error', '<strong>Gagal!</strong> Data tidak valid.');
                                }
//                            }
//                        }
                        $this->redirect(array('admin'));
                      }   

		$this->render($this->path_view.'create',array(
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
		$model= SALookupM::model()->findByPk($id);
                $model->lookup_type = PARAMS::LOOKUPTYPE_OBATALKES_KADAROBAT;

		// Uncomment the following line if AJAX validation is needed
		

		if(isset($_POST['SALookupM']))
                    {
                        $model->attributes=$_POST['SALookupM'];
			if($model->save()){
                                Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
				$this->redirect(array('admin','id'=>$model->lookup_id));
                        }
//                        $valid=true;
//                        foreach($_POST['SALookupM'] as $i=>$item)
//                        {
//                            if(is_integer($i)) {
//                                $model=new SALookupM;
//                                if(isset($_POST['SALookupM'][$i]))
//                                    if ($_POST['SALookupM'][$i]['lookup_id'] == 0){
//                                        $_POST['SALookupM'][$i]['lookup_id'] = null;
//                                    }
//                                    $model->attributes=$_POST['SALookupM'][$i];
//                                    if ((!empty($_POST['SALookupM'][$i]['lookup_id']))||(($_POST['SALookupM'][$i]['lookup_id']) != 0)){
//                                        SALookupM::model()->deleteByPk($_POST['SALookupM'][$i]['lookup_id']);
//                                        $model->lookup_id = $_POST['SALookupM'][$i]['lookup_id'];
//                                    }
//                                    
//                                    //$model->lookup_id = $_POST['SALookupM']['lookup_id'];
//                                    $model->lookup_type = $_POST['SALookupM']['lookup_type'];
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
//                        $this->redirect(array('admin'));
                      }   

		$this->render($this->path_view.'update',array(
			'model'=>$model,
		));
    }

    /**
     * Lists all models.
     */
    public function actionIndex()
    {
        $dataProvider=new CActiveDataProvider('SASALookupM');
        $this->render($this->path_view.'index',array(
            'dataProvider'=>$dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin()
    {
        
        
        $model=new SALookupM('search');
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['SALookupM'])){
            $model->attributes=$_GET['SALookupM'];
        }
        $model->lookup_type = PARAMS::LOOKUPTYPE_OBATALKES_KADAROBAT;

        $this->render($this->path_view.'admin',array(
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
        $model=SALookupM::model()->findByPk($id);
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
        if(isset($_POST['ajax']) && $_POST['ajax']==='kadarobat-m-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete()
    {
        //if(!Yii::app()->user->checkAccess(Params::DEFAULT_DELETE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
        if(Yii::app()->request->isPostRequest)
        {
            $id = $_POST['id'];
            $this->loadModel($id)->delete();
            if (Yii::app()->request->isAjaxRequest)
                {
                    echo CJSON::encode(array(
                        'status'=>'proses_form', 
                        'div'=>"<div class='flash-success'>Data berhasil dihapus.</div>",
                        ));
                    exit;
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
           $update = SALookupM::model()->updateByPk($id,array('lookup_aktif'=>false));
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
            $model= new SALookupM('searchPrint');
            $model->unsetAttributes();
            if(isset($_REQUEST['SALookupM'])){
                $model->attributes = $_REQUEST['SALookupM'];
                $model->lookup_name = !empty($_REQUEST['SALookupM']['lookup_name'])?$_REQUEST['SALookupM']['lookup_name']:'';
                $model->lookup_value = !empty($_REQUEST['SALookupM']['lookup_value'])?$_REQUEST['SALookupM']['lookup_value']:'';
                $model->lookup_kode = !empty($_REQUEST['SALookupM']['lookup_kode'])?$_REQUEST['SALookupM']['lookup_kode']:'';
                $model->lookup_type = PARAMS::LOOKUPTYPE_OBATALKES_KADAROBAT;
            }
            
            $judulLaporan='Data Kadar Obat';
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
}