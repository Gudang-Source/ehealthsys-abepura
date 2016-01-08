<?php

class PresentasiHargaJualController extends MyAuthController
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
            $model=new GFKonfigfarmasiK;
            $modKonfig = GFKonfigfarmasiK::model()->find('konfigfarmasi_aktif is true');

            if(count($modKonfig->konfigfarmasi_aktif == True) > 0){
                echo "<script>
                            myAlert('Maaf masih ada konfigurasi untuk farmasi yang berlaku');
                            window.top.location.href='".Yii::app()->createUrl('gudangFarmasi/PresentasiHargaJual/admin')."';
                      </script>";
            }
            // Uncomment the following line if AJAX validation is needed
            

            if(isset($_POST['GFKonfigfarmasiK']))
            {
                    $model->attributes=$_POST['GFKonfigfarmasiK'];
                    $model->totalpersenhargajual = $_POST['persenhj'] + $_POST['totalphj'];
                    $model->persjualbebas = $_POST['persenjb'] + $_POST['totalpjb'];
                    if($model->save()){
                            Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
                            $this->redirect(array('admin','id'=>$model->konfigfarmasi_id));
                    }
            }

            $this->render('create',array(
                    'model'=>$model,
                    'modKonfig'=>$modKonfig,
            ));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id=null)
	{
                //if(!Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
		if ($id == null){
                    $id = 1;
                }
                $model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		

		if(isset($_POST['GFKonfigfarmasiK']))
		{
			$model->attributes=$_POST['GFKonfigfarmasiK'];
			if($model->save()){
                                Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
//				$this->redirect(array('admin','id'=>$model->konfigfarmasi_id));
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
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('GFKonfigfarmasiK');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
//	public function actionAdmin()
//	{
//                
//		$model=new GFKonfigfarmasiK('search');
//                                $format = new MyFormatter;
//		$model->unsetAttributes();  // clear any default values
//		if(isset($_GET['GFKonfigfarmasiK']))
//                                {
//			$model->attributes=$_GET['GFKonfigfarmasiK'];
//                                                $model->tglberlaku = $format->formatDateTimeForDb($_GET['GFKonfigfarmasiK']['tglberlaku']);
//                                }
//		$this->render('admin',array(
//			'model'=>$model,
//		));
//	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=GFKonfigfarmasiK::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='gfkonfigfarmasi-k-form')
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
                    GFKonfigfarmasiK::model()->updateByPk($id, array('konfigfarmasi_aktif'=>false));
                    $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}
  
        public function actionPrint()
         {
                                      
             $model= new GFKonfigfarmasiK;
             $model->attributes=$_REQUEST['GFKonfigfarmasiK'];
             $judulLaporan='Data Konfigurasi Farmasi';
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

?>