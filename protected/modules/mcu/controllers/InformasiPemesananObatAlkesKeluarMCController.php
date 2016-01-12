<?php
Yii::import('gudangFarmasi.controllers.InformasiPemesananObatAlkesKeluarController');
Yii::import('gudangFarmasi.models.*');
Yii::import('gudangFarmasi.views.informasiPemesananObatAlkesKeluar');
class InformasiPemesananObatAlkesKeluarMCController extends InformasiPemesananObatAlkesKeluarController
{
	
	public function getUrlPrint(){
		return $this->createUrl('PemesananObatAlkesMCU/print');
	}
}

