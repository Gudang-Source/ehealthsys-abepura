<?php

class InformasiPemesananAmbulansController extends MyAuthController
{	
	public $ambulansRS = 'PemakaianAmbulanPasienRSRD';
        public $ambulansLuar = 'PemakaianAmbulanPasienLuarRD';
        public $path_view = 'rawatDarurat.views.informasiPemesananAmbulans.';
        
	public function actionIndex()
	{
            $format = new MyFormatter();
            $modPemesanan = new RDPesanambulansT('search');
            $modPemesanan->tgl_awal  = date('Y-m-d');
            $modPemesanan->tgl_akhir  = date('Y-m-d'); 
            $modPemesanan->ruangan_id = Yii::app()->user->getState('ruangan_id');
            if(isset($_GET['RDPesanambulansT'])){
                $modPemesanan->unsetAttributes();
                $modPemesanan->attributes = $_GET['RDPesanambulansT'];
                $modPemesanan->tgl_awal  = $format->formatDateTimeForDb($_GET['RDPesanambulansT']['tgl_awal']);
                $modPemesanan->tgl_akhir  = $format->formatDateTimeForDb($_GET['RDPesanambulansT']['tgl_akhir']);
                $modPemesanan->nama_pemakai  = $_GET['RDPesanambulansT']['nama_pemakai'];
            }
            $this->render($this->path_view.'index',array('format'=>$format,'modPemesanan'=>$modPemesanan));
            
	}
        
}