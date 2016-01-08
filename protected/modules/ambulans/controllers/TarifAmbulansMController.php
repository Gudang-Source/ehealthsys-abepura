<?php

class TarifAmbulansMController extends MyAuthController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column1';
                public $defaultAction='admin';

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
		$model=new TarifAmbulansM;
		$modDaftartindakan = new AMDaftartindakanM;
		$modDaftartindakan->unsetAttributes();
		if(isset($_GET['AMDaftarTindakanM'])) {
		    $modDaftartindakan->attributes = $_GET['AMDaftarTindakanM'];
		}

		// Uncomment the following line if AJAX validation is needed
		

		if(isset($_POST['TarifAmbulansM']))
		{
			$model->attributes=$_POST['TarifAmbulansM'];
			if($model->save())
				$this->redirect(array('admin','id'=>$model->tarifambulans_id));
		}

		$this->render('create',array(
			'model'=>$model,'modDaftartindakan'=>$modDaftartindakan,
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
		

		if(isset($_POST['TarifAmbulansM']))
		{
			$model->attributes=$_POST['TarifAmbulansM'];
			if($model->save())
				$this->redirect(array('admin','id'=>$model->tarifambulans_id));
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
		$dataProvider=new CActiveDataProvider('TarifAmbulansM');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new TarifAmbulansM('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['TarifAmbulansM']))
			$model->attributes=$_GET['TarifAmbulansM'];

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
		$model=TarifAmbulansM::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='tarif-ambulans-m-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
        
	public function actionPrint()
	{

		$model= new TarifAmbulansM;
		$judulLaporan='Data Tarif Ambulans';
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
	
	/**
	 * Mengatur dropdown kabupaten
	 * @param type $encode jika = true maka return array jika false maka set Dropdown 
	 * @param type $model_nama
	 * @param type $attr
	 */
	public function actionSetDropdownKabupaten($encode=false,$model_nama='',$attr='')
	{
		if(Yii::app()->request->isAjaxRequest) {
			$modTarif = new AMTarifambulansM;
			if($model_nama !=='' && $attr == ''){
				$propinsi_nama = $_POST["$model_nama"]['kepropinsi_nama'];
			}
			 elseif ($model_nama == '' && $attr !== '') {
				$propinsi_nama = $_POST["$attr"];
			}
			 elseif ($model_nama !== '' && $attr !== '') {
				$propinsi_nama = $_POST["$model_nama"]["$attr"];
			}
			$kabupaten = null;
			if($propinsi_nama){
				$kabupaten = $modTarif->getKabupatenItems($propinsi_nama);
				$kabupaten = CHtml::listData($kabupaten,'kabupaten_id','kabupaten_nama');
			}
			if($encode){
				echo CJSON::encode($kabupaten);
			} else {
				if(empty($kabupaten)){
					echo CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
				} else {
					echo CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
					foreach($kabupaten as $value=>$name) {
						echo CHtml::tag('option', array('value'=>$value),CHtml::encode($name),true);
					}
				}
			}
		}
		Yii::app()->end();
	}
	
	/**
	 * Mengatur dropdown kecamatan
	 * @param type $encode jika = true maka return array jika false maka set Dropdown 
	 * @param type $model_nama
	 * @param type $attr
	 */
	public function actionSetDropdownKecamatan($encode=false,$model_nama='',$attr='')
	{
		if(Yii::app()->request->isAjaxRequest) {
			$modTarif = new AMTarifambulansM;
			if($model_nama !=='' && $attr == ''){
				$kabupaten_nama = $_POST["$model_nama"]['kekabupaten_nama'];
			}
			 elseif ($model_nama == '' && $attr !== '') {
				$kabupaten_nama = $_POST["$attr"];
			}
			 elseif ($model_nama !== '' && $attr !== '') {
				$kabupaten_nama = $_POST["$model_nama"]["$attr"];
			}
			$kecamatan = null;
			if($kabupaten_nama){
				$kecamatan = $modTarif->getKecamatanItems($kabupaten_nama);
				$kecamatan = CHtml::listData($kecamatan,'kecamatan_id','kecamatan_nama');
			}

			if($encode){
				echo CJSON::encode($kecamatan);
			} else {
				if(empty($kecamatan)){
					echo CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
				}else{
					echo CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
					foreach($kecamatan as $value=>$name)
					{
						echo CHtml::tag('option', array('value'=>$value),CHtml::encode($name),true);
					}
				}
			}
		}
		Yii::app()->end();
	}
	
	/**
	 * Mengatur dropdown kelurahan
	 * @param type $encode jika = true maka return array jika false maka set Dropdown 
	 * @param type $model_nama
	 * @param type $attr
	 */
	public function actionSetDropdownKelurahan($encode=false,$model_nama='',$attr='')
	{
		if(Yii::app()->request->isAjaxRequest) {
			$modTarif = new AMTarifambulansM;
			if($model_nama !=='' && $attr == ''){
				$kecamatan_nama = $_POST["$model_nama"]['kekecamatan_nama'];
			}
			 elseif ($model_nama == '' && $attr !== '') {
				$kecamatan_nama = $_POST["$attr"];
			}
			elseif ($model_nama !== '' && $attr !== '') {
				$kecamatan_nama = $_POST["$model_nama"]["$attr"];
			}
			$kelurahan = null;
			if($kecamatan_nama){
				$kelurahan = $modTarif->getKelurahanItems($kecamatan_nama);
				$kelurahan = CHtml::listData($kelurahan,'kelurahan_id','kelurahan_nama');
			}

			if($encode){
				echo CJSON::encode($kelurahan);
			} else {
				if(empty($kelurahan)){
					echo CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
				}else{
					echo CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
					foreach($kelurahan as $value=>$name)
					{
						echo CHtml::tag('option', array('value'=>$value),CHtml::encode($name),true);
					}
				}
			}
		}
		Yii::app()->end();
	}
}
