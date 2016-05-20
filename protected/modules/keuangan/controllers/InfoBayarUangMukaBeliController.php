<?php
class InfoBayarUangMukaBeliController extends MyAuthController
{
	public function actionIndex()
	{
		$modBayar = new KUUangMukaBeliT;
		$format = new MyFormatter();
		$modBayar->tgl_awal=date('Y-m-d');
		$modBayar->tgl_akhir=date('Y-m-d');

		if(isset($_GET['KUInformasibayaruangmukaV'])){
			$modBayar->attributes=$_GET['KUInformasibayaruangmukaV'];
			$modBayar->tgl_awal = $format->formatDateTimeForDb($_GET['KUInformasibayaruangmukaV']['tgl_awal']);
			$modBayar->tgl_akhir = $format->formatDateTimeForDb($_GET['KUInformasibayaruangmukaV']['tgl_akhir']);
		}

		$this->render('index', array('modBayar'=>$modBayar));
	}
}