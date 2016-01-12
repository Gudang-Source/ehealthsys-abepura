<?php

class InformasiPenerimaanBarangController extends MyAuthController
{
	public $defaultAction ='index';

	public function actionIndex()
	{
		$model=new GFInformasipenerimaanbarangV;
		$format = new MyFormatter();
		$model->tgl_awal =date('Y-m-d');
		$model->tgl_akhir =date('Y-m-d');

		if(isset($_GET['GFInformasipenerimaanbarangV'])){
			$model->attributes=$_GET['GFInformasipenerimaanbarangV'];
			$model->tgl_awal  = $format->formatDateTimeForDb($_GET['GFInformasipenerimaanbarangV']['tgl_awal']);
			$model->tgl_akhir = $format->formatDateTimeForDb($_GET['GFInformasipenerimaanbarangV']['tgl_akhir']);
		}
		$this->render('index',array('format'=>$format,'model'=>$model));
	}
	
}