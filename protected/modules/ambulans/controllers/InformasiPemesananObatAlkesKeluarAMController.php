<?php
Yii::import('gudangFarmasi.models.*');
Yii::import('gudangFarmasi.controllers.InformasiPemesananObatAlkesKeluarController');
class InformasiPemesananObatAlkesKeluarAMController extends InformasiPemesananObatAlkesKeluarController
{
	/**
	 * menampilkan url print karna setiap modul berbeda
	 */
	public function getUrlPrint(){
		return $this->createUrl('pemesananObatAlkesAM/print');
	}
}