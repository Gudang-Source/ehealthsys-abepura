<?php

class PasienMeninggalController extends MyAuthController
{
	public function actionIndex()
	{
            $this->pageTitle = Yii::app()->name." - Pasien Meninggal";
            $format = new MyFormatter();
            $model = new PJDaftarpasienmeninggalV;
            $model->tgl_awal = date("Y-m-d");
            $model->tgl_akhir = date('Y-m-d');
            if(isset ($_GET['PJDaftarpasienmeninggalV'])){
                $model->attributes=$_GET['PJDaftarpasienmeninggalV'];
                $model->tgl_awal = $format->formatDateTimeForDb($_GET['PJDaftarpasienmeninggalV']['tgl_awal']);
                $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PJDaftarpasienmeninggalV']['tgl_akhir']);
                $model->ceklis = $_GET['PJDaftarpasienmeninggalV']['ceklis'];
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