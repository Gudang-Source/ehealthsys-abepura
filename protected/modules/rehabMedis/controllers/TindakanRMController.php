
<?php

class TindakanRMController extends MyAuthController
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
		$model=new RMTindakanrmM;

		// Uncomment the following line if AJAX validation is needed
		

		if(isset($_POST['RMTindakanrmM']))
		{
			$model->attributes=$_POST['RMTindakanrmM'];
			//$model->daftartindakan_id=$_POST['daftartindakan_id'];
			$model->tindakanrm_aktif=true;
			if($model->save()){
                                Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
				$this->redirect(array('admin','id'=>$model->tindakanrm_id));
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
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		

		if(isset($_POST['RMTindakanrmM']))
		{
			$_POST['RMTindakanrmM']['jenistindakanrm_id']=$model->jenistindakanrm_id;
			$_POST['RMTindakanrmM']['daftartindakan_id']=$model->daftartindakan_id;
			$model->attributes=$_POST['RMTindakanrmM'];
			if($model->save()){
                                Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
				$this->redirect(array('admin','id'=>$model->tindakanrm_id));
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
		$dataProvider=new CActiveDataProvider('RMTindakanrmM');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new RMTindakanrmM('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['RMTindakanrmM'])){
			$model->attributes=$_GET['RMTindakanrmM'];
			$model->daftartindakan_nama = $_GET['RMTindakanrmM']['daftartindakan_nama'];
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
		$model=RMTindakanrmM::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='rmtindakanrm-m-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
        
	public function actionDelete()
		{              
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
                            exit();
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
	        $id = $_POST['id'];   
	        if(isset($_POST['id']))
	        {
	           $update = RMTindakanrmM::model()->updateByPk($id,array('tindakanrm_aktif'=>false));
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
            $model= new RMTindakanrmM;
            $model->attributes=$_REQUEST['RMTindakanrmM'];
            $judulLaporan='Data RMTindakanrmM';
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
}
