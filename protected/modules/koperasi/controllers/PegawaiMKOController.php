<?php

class PegawaiMKOController extends MyAuthController
{
	public $layout='//layouts/main';
	public $defaultAction = 'admin';
	// $menuActive = array(index menu,index sub menu);
	// index menu dan sub menu dapat di lihat di Params.php -> function menu()


/**
* @var string the default layout for the views. Defaults to '//layouts/column2', meaning
* using two-column layout. See 'protected/views/layouts/column2.php'.
*/
// public $layout='//layouts/column2';

/**
* @return array action filters
*/
/*
public function filters()
{
return array(
'accessControl', // perform access control for CRUD operations
);
}
*/
/**
* Specifies the access control rules.
* This method is used by the 'accessControl' filter.
* @return array access control rules
*/
/*
public function accessRules()
{
return array(
array('allow',  // allow all users to perform 'index' and 'view' actions
'actions'=>array('index','view'),
'users'=>array('*'),
),
array('allow', // allow authenticated user to perform 'create' and 'update' actions
'actions'=>array('create','update'),
'users'=>array('@'),
),
array('allow', // allow admin user to perform 'admin' and 'delete' actions
'actions'=>array('admin','delete'),
'users'=>array('admin'),
),
array('deny',  // deny all users
'users'=>array('*'),
),
);
}
 */
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
*/ /*
public function actionCreate($id = null)
{
	$model=new PegawaiM;

	// Uncomment the following line if AJAX validation is needed
	// $this->performAjaxValidation($model);

	if(isset($_POST['PegawaiM']))
	{
		$trans = Yii::app()->db->beginTransaction();
		$model->attributes=$_POST['PegawaiM'];
		$model->tgl_lahirpegawai = MyFormatter::formatDateForDb($model->tgl_lahirpegawai);
		if (!empty($model->tglmulaibekerja) || $model->tglmulaibekerja != '') $model->tglmulaibekerja = MyFormatter::formatDateForDb($model->tglmulaibekerja);
		else $model->tglmulaibekerja = null;

		$model->gajipokok = str_replace(".", "", $model->gajipokok);
		$model->insentifpegawai = str_replace(".", "", $model->insentifpegawai);

		$model->peg_create_time = date('Y-m-d H:i:s');
		$model->peg_create_login = Yii::app()->user->name;
		$model->photopegawai=CUploadedFile::getInstance($model,'photopegawai');
		//$model->validate();
		if ($model->validate()) {
			if($model->save()) {
				if (!empty($model->photopegawai)) $model->photopegawai->saveAs(Params::pathPegawaiGambar().$model->photopegawai); //.$model->photopegawai);
				$trans->commit();
				$this->redirect(array('create', 'id'=>$model->pegawai_id, 'status'=>1));
			} else {
				$trans->rollback();
				$this->setFlash('error', 'Input Pegawai gagal di ubah.');
			}
		} else {
			$trans->rollback();
			$this->setFlash('error', 'Input Pegawai gagal di ubah.');
		}
	}

	if (!empty($id)) {
		$model = PegawaiM::model()->findByPk($id);
		$model->tgl_lahirpegawai = date('d/m/Y', strtotime($model->tgl_lahirpegawai));
		if (!empty($model->tglmulaibekerja)) $model->tglmulaibekerja = date('d/m/Y', strtotime($model->tglmulaibekerja));
	}

	$this->render('create',array(
		'model'=>$model,
	));
}

/**
* Updates a particular model.
* If update is successful, the browser will be redirected to the 'view' page.
* @param integer $id the ID of the model to be updated
*/ /*
public function actionUpdate($id)
{
	$model=$this->loadModel($id);
	$model->tgl_lahirpegawai = date('d/m/Y', strtotime($model->tgl_lahirpegawai));
	if (!empty($model->tglmulaibekerja) || $model->tglmulaibekerja != '') $model->tglmulaibekerja = date('d/m/Y', strtotime($model->tglmulaibekerja));

	$photoPath = $model->photopegawai;

	$model->gajipokok = MyFormatter::formatNumberForPrint($model->gajipokok);
	$model->insentifpegawai = MyFormatter::formatNumberForPrint($model->insentifpegawai);

// Uncomment the following line if AJAX validation is needed
// $this->performAjaxValidation($model);

	if(isset($_POST['PegawaiM']))
	{
		$trans = Yii::app()->db->beginTransaction();
		$model->attributes=$_POST['PegawaiM'];
		$model->tgl_lahirpegawai = MyFormatter::formatDateForDb($model->tgl_lahirpegawai);
		if (!empty($model->tglmulaibekerja) || $model->tglmulaibekerja != '') $model->tglmulaibekerja = MyFormatter::formatDateForDb($model->tglmulaibekerja);
		else $model->tglmulaibekerja = null;
		$model->peg_update_time = date('Y-m-d H:i:s');

		$model->gajipokok = str_replace(".", "", $model->gajipokok);
		$model->insentifpegawai = str_replace(".", "", $model->insentifpegawai);

		$model->peg_update_login = Yii::app()->user->name;
		$model->photopegawai=CUploadedFile::getInstance($model,'photopegawai');
		$cond = true;
		if (empty($model->photopegawai)) {
			$model->photopegawai = $photoPath;
			$cond = false;
		}
		if ($model->validate()) {
			if($model->save()) {
				if ($cond) $model->photopegawai->saveAs(Params::pathPegawaiGambar().$model->photopegawai); //.$model->photopegawai);
				$trans->commit();
				$this->redirect(array('admin', 'status'=>1));
			} else {
				$trans->rollback();
				$this->setFlash('error', 'Data Pegawai gagal di ubah.');
			}
		} else {
			//var_dump($model->errors); die;
			$trans->rollback();
			$this->setFlash('error', 'Data Pegawai gagal di ubah.');
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
*/ /*
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
*/ /*
public function actionIndex()
{
	$dataProvider=new CActiveDataProvider('PegawaiM');
	$this->render('index',array(
		'dataProvider'=>$dataProvider,
	));
}

/**
* Manages all models.
*/
public function actionAdmin()
{
	$model=new PegawaiM('search');
	$model->unsetAttributes();  // clear any default values
	if(isset($_GET['PegawaiM'])){
		$model->attributes=$_GET['PegawaiM'];
		$model->golonganpegawai_id = $_GET['PegawaiM']['golonganpegawai_id'];
		//if (isset($_GET['PegawaiM']['isanggota'])) $model->isanggota=$_GET['PegawaiM']['isanggota'];
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
	$model=PegawaiM::model()->findByPk($id);
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
	if(isset($_POST['ajax']) && $_POST['ajax']==='pegawai-m-form')
	{
		echo CActiveForm::validate($model);
		Yii::app()->end();
	}
}



	public function actionPrintSuratAnggota($id) {
		$this->layout='//layouts/print';
		$this->pageTitle = 'ecoopsys - Print Surat Permohonan Keanggotaan';
		// $anggota = KeanggotaanT::model()->findByPk($id);
		$pegawai = PegawaiM::model()->findByPk($id);
		$konfig = KonfigkoperasiK::model()->find(array('order'=>'konfigkoperasi_id asc'));
		$profil = ProfilrumahsakitM::model()->find(array('order'=>'profilrs_id asc'));
		$this->render('print', array(
			'pegawai'=>$pegawai,
			'konfig'=>$konfig,
			'profil'=>$profil,
			//'anggota'=>$anggota,
		));
	}


}
