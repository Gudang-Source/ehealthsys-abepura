<?php
class InformasiPemesananAmbulansController extends MyAuthController
{
    public $layout='//layouts/column1';
    public function actionIndex(){
		$model = new AMInformasipesanambulansV;
		$format = new MyFormatter;
	    $model->tgl_awal  = date('Y-m-d');
	    $model->tgl_akhir  = date('Y-m-d');
		if(isset($_GET['AMInformasipesanambulansV'])){
			$model->unsetAttributes();
			$model->attributes=$_GET['AMInformasipesanambulansV'];
			$model->tgl_awal = $format->formatDateTimeForDb($_GET['AMInformasipesanambulansV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['AMInformasipesanambulansV']['tgl_akhir']);
		}
		$this->render('index',array('model'=>$model,'format'=>$format));
	}
}