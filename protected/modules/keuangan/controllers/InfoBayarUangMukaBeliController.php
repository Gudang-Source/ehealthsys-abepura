<?php
class InfoBayarUangMukaBeliController extends MyAuthController
{
	public function actionIndex()
	{
		$modBayar = new KUUangMukaBeliT;
		$format = new MyFormatter();
		$modBayar->tgl_awal=date('Y-m-d 00:00:00');
		$modBayar->tgl_akhir=date('Y-m-d 23:59:59');

		if(isset($_GET['KUUangMukaBeliT'])){
			$modBayar->attributes=$_GET['KUUangMukaBeliT'];
			$modBayar->tgl_awal = $format->formatDateTimeForDb($_GET['KUUangMukaBeliT']['tgl_awal'].' 00:00:00');
			$modBayar->tgl_akhir = $format->formatDateTimeForDb($_GET['KUUangMukaBeliT']['tgl_akhir'].' 23:59:59');
                        $modBayar->nopenerimaan = $_GET['KUUangMukaBeliT']['nopenerimaan'];
                        $modBayar->nokaskeluar = $_GET['KUUangMukaBeliT']['nokaskeluar'];
                        $modBayar->nopermintaan = $_GET['KUUangMukaBeliT']['nopermintaan'];
		}//KUInformasibayaruangmukaV

		$this->render('index', array('modBayar'=>$modBayar));
	}
}