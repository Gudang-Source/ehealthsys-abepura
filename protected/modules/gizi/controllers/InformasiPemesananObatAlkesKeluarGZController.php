<?php
Yii::import('gudangFarmasi.models.*');
Yii::import('gudangFarmasi.controllers.InformasiPemesananObatAlkesKeluarController');
class InformasiPemesananObatAlkesKeluarGZController extends InformasiPemesananObatAlkesKeluarController
{
	/**
	 * menampilkan url print karna setiap modul berbeda
	 */
	public function getUrlPrint(){
		return $this->createUrl('pemesananObatAlkesGZ/print');
	}
}