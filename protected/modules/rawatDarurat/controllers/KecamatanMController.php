<?php

class KecamatanMController extends MyAuthController
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
		$model=new RDKecamatanM;

		// Uncomment the following line if AJAX validation is needed
		

		if(isset($_POST['RDKecamatanM']))
		{
                                    $valid=true;
                                    foreach($_POST['RDKecamatanM'] as $i=>$item)
                                    {
                                        if(is_integer($i)) 
                                        {
                                            $model=new RDKecamatanM;
                                            if(isset($_POST['RDKecamatanM'][$i]))
                                                $model->attributes=$_POST['RDKecamatanM'][$i];
                                                $model->kecamatan_aktif = true;
                                                $model->kabupaten_id = $_POST['RDKecamatanM']['kabupaten_id'];
                                                $valid=$model->validate() && $valid;
                                                echo $i;
                                            if($valid) 
                                            {
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

		// Uncomment the following line if AJAX validation is needed
		
                                
		if(isset($_POST['RDKecamatanM']))
		{
			$model->attributes=$_POST['RDKecamatanM'];
			if($model->save()){
                                Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
				$this->redirect(array('admin'));
                        }
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('RDKecamatanM');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
                                
		$model=new RDKecamatanM('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['RDKecamatanM']))
			$model->attributes=$_GET['RDKecamatanM'];

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
		$model=RDKecamatanM::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(401,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='sakecamatan-m-form')
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
                $kelurahan = RDKelurahanM::model()->findByAttributes(array('kecamatan_id'=>$id));
                if ($kelurahan){
                        	echo CJSON::encode(array(
                                	'status'=>'error',
                                ));
                            exit();
                }else{
                    $this->loadModel($id)->delete();
                    if (Yii::app()->request->isAjaxRequest)
                        {
                            echo CJSON::encode(array(
                                'status'=>'proses_form', 
                                'div'=>"<div class='flash-success'>Data berhasil dihapus.</div>",
                                ));
                            exit;               
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
           $update = RDKecamatanM::model()->updateByPk($id,array('kecamatan_aktif'=>false));
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
                    
                    $model= new RDKecamatanM;
                    $model->attributes=$_REQUEST['RDKecamatanM'];
                    $judulLaporan='Data Kecamatan';
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

                public function actionDynamicKabupaten()
                {
                    $data=KabupatenM::model()->findAll('propinsi_id=:prop_id', 
                          array(':prop_id'=>(int) $_POST['propinsi'],),array('order'=>'kabupaten_nama'));

                    $data=CHtml::listData($data,'kabupaten_id','kabupaten_nama');

                    if(empty($data))
                    {
                        echo CHtml::tag('option',
                                   array('value'=>''),CHtml::encode('-- Pilih --'),true);
                    }
                    else
                   {
                        echo CHtml::tag('option',
                                   array('value'=>''),CHtml::encode('-- Pilih --'),true);
                        foreach($data as $value=>$name)
                        {
                            echo CHtml::tag('option',
                                       array('value'=>$value),CHtml::encode($name),true);
                        }
                    }
                }
                
}
