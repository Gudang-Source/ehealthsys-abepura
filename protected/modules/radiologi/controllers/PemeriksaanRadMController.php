
<?php

class PemeriksaanRadMController extends MyAuthController
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
		$model=new ROPemeriksaanRadM;
        $modReferensiHasil = new ROReferensiHasilRadM;

		if(isset($_POST['ROPemeriksaanRadM']))
		{
			$model->attributes = $_POST['ROPemeriksaanRadM'];
			$model->daftartindakan_id = $_POST['daftartindakan_id'];
			$validModel = $model->validate();
			if($model->is_adareferensihasil = true){
				$modReferensiHasil->attributes = $_POST['ROReferensiHasilRadM'];
				$validReferensi = $modReferensiHasil->validate();
			}else{
				$validReferensi = false;
			}
			if($validModel){
				$model->save();
				if($validReferensi = true){
					$modReferensiHasil->pemeriksaanrad_id = $model->pemeriksaanrad_id;
					$modReferensiHasil->save();
				}

				Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
				$this->redirect(array('admin','id'=>$model->pemeriksaanrad_id, 'sukses'=>1));
			}
		}

		$this->render('create',array(
			'model'=>$model,
                        'modReferensiHasil'=>$modReferensiHasil,
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
                
                if(!empty($modReferensiHasil)){
                    $modReferensiHasil = ROReferensiHasilRadM::model()->findByAttributes(array('pemeriksaanrad_id'=>$model->pemeriksaanrad_id,'refhasilrad_aktif'=>true));
                    $modReferensiHasil->pemeriksaanrad_id = $modReferensiHasil->pemeriksaanrad_id;
                    $modReferensiHasil->refhasilrad_kode = $modReferensiHasil->refhasilrad_kode;
                }else{
                    $modReferensiHasil = new ROReferensiHasilRadM;
                }

		// Uncomment the following line if AJAX validation is needed
		

		if(isset($_POST['ROPemeriksaanRadM']))
		{
			$model->attributes = $_POST['ROPemeriksaanRadM'];
                        $modReferensiHasil->attributes = $_POST['ROReferensiHasilRadM'];
                        $modReferensiHasil->pemeriksaanrad_id = $model->pemeriksaanrad_id;
                        $validModel = $model->validate();
                        $validReferensi = $modReferensiHasil->validate();
                        if($validModel && $validReferensi){
                            $model->save();
                            $modReferensiHasil->save();
                            
                            Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
                            $this->redirect(array('admin','id'=>$model->pemeriksaanrad_id, 'sukses'=>1));
                        }
		}

		$this->render('update',array(
			'model'=>$model,
                        'modReferensiHasil'=>$modReferensiHasil,
		));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('ROPemeriksaanRadM');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
                
		$model=new ROPemeriksaanRadM('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['ROPemeriksaanRadM'])){
			$model->attributes=$_GET['ROPemeriksaanRadM'];
			$model->jenispemeriksaanrad_nama= isset($_GET['ROPemeriksaanRadM']['jenispemeriksaanrad_nama']) ? $_GET['ROPemeriksaanRadM']['jenispemeriksaanrad_nama'] : null;
                        $model->daftartindakan_nama = isset($_GET['ROPemeriksaanRadM']['daftartindakan_nama']) ? $_GET['ROPemeriksaanRadM']['daftartindakan_nama'] : null;
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
		$model=ROPemeriksaanRadM::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='sapemeriksaan-rad-m-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	public function actionDelete($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$this->loadModel($id)->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}
	/**
	 * Memanggil dan menonaktifkan status 
	 */
	public function actionNonActive($id)
	{
		if(Yii::app()->request->isAjaxRequest)
		{
			$data['sukses'] = 0;
			$model = $this->loadModel($id);
			// set non-active this
			// example: 
                        if (isset($_GET['add'])):
                            $model->pemeriksaanrad_aktif = 1;                        
                        else:    
                            $model->pemeriksaanrad_aktif = 0;                        
                        endif;
			 
			 if($model->save()){
				$data['sukses'] = 1;
			 }
			echo CJSON::encode($data); 
		}
	}
        
        public function actionPrint()
        {
            $model= new ROPemeriksaanRadM;
            if(isset($_REQUEST['ROPemeriksaanRadM'])){
                $model->attributes=$_REQUEST['ROPemeriksaanRadM'];
            }
            $judulLaporan='Data Pemeriksaan Radiologi';
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
