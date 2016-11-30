<?php

class InformasiRekonsiliasiBankController extends MyAuthController{
	protected $path_view = 'akuntansi.views.informasiRekonsiliasiBank.';
	
	public function actionIndex(){
		$format = new MyFormatter();
		$model = new AKInformasirekonsiliasibankV;
		$model->tgl_awal = date("Y-m-d");
		$model->tgl_akhir = date("Y-m-d");
		
		if(isset($_GET['AKInformasirekonsiliasibankV'])){
			$model->attributes = $_GET['AKInformasirekonsiliasibankV'];
			$model->tgl_awal = $format->formatDateTimeForDb($_GET['AKInformasirekonsiliasibankV']['tgl_awal']);
			$model->tgl_akhir = $format->formatDateTimeForDb($_GET['AKInformasirekonsiliasibankV']['tgl_akhir']);
		}
		
		$this->render($this->path_view.'index',array(
			'format'=>$format,
			'model'=>$model
		));
	}
}
