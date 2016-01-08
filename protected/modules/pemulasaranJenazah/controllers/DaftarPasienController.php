<?php

class DaftarPasienController extends MyAuthController
{
	public function actionIndex()
	{
            $this->pageTitle = Yii::app()->name." - Daftar Pasien Pemulasaran Jenazah";
            $format = new MyFormatter();
            $model = new PJPasienmasukpenunjangV;
            $model->tgl_awal = date("Y-m-d");
            $model->tgl_akhir = date('Y-m-d');
            if(isset ($_GET['PJPasienmasukpenunjangV'])){
                $model->attributes=$_GET['PJPasienmasukpenunjangV'];
                $model->tgl_awal = $format->formatDateTimeForDb($_GET['PJPasienmasukpenunjangV']['tgl_awal']);
                $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PJPasienmasukpenunjangV']['tgl_akhir']);
                $model->ceklis = $_GET['PJPasienmasukpenunjangV']['ceklis'];
            }

            $this->render('index',array('model'=>$model,'format'=>$format));
	}

	// Uncomment the following methods and override them if needed
	/*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
}