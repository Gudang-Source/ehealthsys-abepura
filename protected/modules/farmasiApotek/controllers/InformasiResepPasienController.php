<?php

Yii::import('farmasiApotek.controllers.InformasiPenjualanResepController');
Yii::import('farmasiApotek.views.informasiPenjualanResep.*');

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
            $modInfoPenjualan->pegawai_id = $_GET['FAInformasipenjualanresepV']['pegawai_id'];
            $modInfoPenjualan->carabayar_id = $_GET['FAInformasipenjualanresepV']['carabayar_id'];
            $modInfoPenjualan->statusperiksa = $_GET['FAInformasipenjualanresepV']['statusperiksa'];
            $modInfoPenjualan->ruanganpendaftaran_id = $_GET['FAInformasipenjualanresepV']['ruanganpendaftaran_id'];
            $modInfoPenjualan->tgl_awal = $format->formatDateTimeForDb($_GET['FAInformasipenjualanresepV']['tgl_awal']);
            $modInfoPenjualan->tgl_akhir = $format->formatDateTimeForDb($_GET['FAInformasipenjualanresepV']['tgl_akhir']);
        }

        $this->render('index',array('format'=>$format,'modInfoPenjualan'=>$modInfoPenjualan));
    }
}