<?php

class InformasiPemesananAmbulansController extends MyAuthController
{	

	
	public function actionIndex()
	{
            $format = new MyFormatter();
            $modPemesanan = new RDPesanambulansT('search');
            $modPemesanan->tgl_awal  = date('Y-m-d');
            $modPemesanan->tgl_akhir  = date('Y-m-d');
            if(isset($_GET['RDPesanambulansT'])){
                $modPemesanan->unsetAttributes();
                $modPemesanan->attributes = $_GET['RDPesanambulansT'];
                $modPemesanan->tgl_awal  = $format->formatDateTimeForDb($_GET['RDPesanambulansT']['tgl_awal']);
                $modPemesanan->tgl_akhir  = $format->formatDateTimeForDb($_GET['RDPesanambulansT']['tgl_akhir']);
            }
            $this->render('index',array('format'=>$format,'modPemesanan'=>$modPemesanan));
            
	}
        
}