<?php

class InformasiResepPasienController extends InformasiPenjualanResepController
{
    public function actionIndex()
    {
        $modInfoPenjualan = new FAInformasipenjualanresepV('searchInfoResepPasien');
        $format = new MyFormatter();
        $modInfoPenjualan->unsetAttributes();
        $modInfoPenjualan->tgl_awal = date('Y-m-d');
        $modInfoPenjualan->tgl_akhir = date('Y-m-d');
        if(isset($_GET['FAInformasipenjualanresepV'])){                
            $modInfoPenjualan->attributes = $_GET['FAInformasipenjualanresepV'];
            $modInfoPenjualan->ruanganasalobat = $_GET['FAInformasipenjualanresepV']['ruanganasalobat'];
            $modInfoPenjualan->tgl_awal = $format->formatDateTimeForDb($_GET['FAInformasipenjualanresepV']['tgl_awal']);
            $modInfoPenjualan->tgl_akhir = $format->formatDateTimeForDb($_GET['FAInformasipenjualanresepV']['tgl_akhir']);
        }

        $this->render('index',array('format'=>$format,'modInfoPenjualan'=>$modInfoPenjualan));
    }
}