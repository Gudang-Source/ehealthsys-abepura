<?php
Yii::import('gudangFarmasi.models.*');
Yii::import('gudangFarmasi.controllers.InformasiPemesananObatAlkesMasukController');
class InformasiPemesananObatAlkesMasukMCController extends InformasiPemesananObatAlkesMasukController
{
	/**
	 * menampilkan url print karna setiap modul berbeda
	 */
	public function getUrlPrint(){
		return $this->createUrl('pemesananObatAlkesMC/print');
	}
	/**
	 * menampilkan url action transaksi mutasi karna setiap modul berbeda
	 */
	public function getUrlMutasi(){
		return $this->createUrl("MutasiObatAlkesMC/Index");
	}
}