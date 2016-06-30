<?php

class LaporanController extends MyAuthController {

    public $tgl_awal = "d M Y 00:00:00";
    public $tgl_akhir = "d M Y 23:59:59";
    
/*
 * gizi->Laporan->LaporanKonsultasiGizi
 */   
    public function actionLaporanKonsulGizi() {
        $model = new GZLaporankonsultasigiziV('search');
        $format = new MyFormatter();
        $model->unsetAttributes();
        $model->jns_periode = "hari";
        $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
        $model->tgl_akhir = date('Y-m-d');
        $model->bln_awal = date('Y-m', strtotime('first day of january'));
        $model->bln_akhir = date('Y-m');
        $model->thn_awal = date('Y');
        $model->thn_akhir = date('Y');
        if (isset($_GET['GZLaporankonsultasigiziV'])) {
            $model->attributes = $_GET['GZLaporankonsultasigiziV'];
            $model->jns_periode = $_GET['GZLaporankonsultasigiziV']['jns_periode'];
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['GZLaporankonsultasigiziV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['GZLaporankonsultasigiziV']['tgl_akhir']);
            $model->bln_awal = $format->formatMonthForDb($_GET['GZLaporankonsultasigiziV']['bln_awal']);
            $model->bln_akhir = $format->formatMonthForDb($_GET['GZLaporankonsultasigiziV']['bln_akhir']);
            $bln_akhir = $model->bln_akhir."-".date("t",strtotime($model->bln_akhir));
            $thn_akhir = $model->thn_akhir."-".date("m-t",strtotime($model->thn_akhir."-12"));
            switch($model->jns_periode){
                case 'bulan' : $model->tgl_awal = $model->bln_awal."-01"; $model->tgl_akhir = $bln_akhir; break;
                case 'tahun' : $model->tgl_awal = $model->thn_awal."-01-01"; $model->tgl_akhir = $thn_akhir; break;
                default : null;
            }
            $model->tgl_awal = $model->tgl_awal." 00:00:00";
            $model->tgl_akhir = $model->tgl_akhir." 23:59:59";
        }
        $this->render('konsulGizi/admin', array(
            'model' => $model, 'format'=>$format
        ));
    }

    public function actionPrintLaporanKonsulGizi() {
        $model = new GZLaporankonsultasigiziV('search');
        $judulLaporan = 'LAPORAN KONSULTASI GIZI <BR/> INSTALASI GIZI BULAN';
        $format = new MyFormatter();
        $model->unsetAttributes();
        $model->jns_periode = "hari";
        $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
        $model->tgl_akhir = date('Y-m-d');
        $model->bln_awal = date('Y-m', strtotime('first day of january'));
        $model->bln_akhir = date('Y-m');
        $model->thn_awal = date('Y');
        $model->thn_akhir = date('Y');

        //Data Grafik
        $data['title'] = 'Grafik Laporan Konsultasi Gizi';
        $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : "");

        if (isset($_REQUEST['GZLaporankonsultasigiziV'])) {
            $model->attributes = $_REQUEST['GZLaporankonsultasigiziV'];
            $model->jns_periode = $_GET['GZLaporankonsultasigiziV']['jns_periode'];
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['GZLaporankonsultasigiziV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['GZLaporankonsultasigiziV']['tgl_akhir']);
            $model->bln_awal = $format->formatMonthForDb($_GET['GZLaporankonsultasigiziV']['bln_awal']);
            $model->bln_akhir = $format->formatMonthForDb($_GET['GZLaporankonsultasigiziV']['bln_akhir']);
            $bln_akhir = $model->bln_akhir."-".date("t",strtotime($model->bln_akhir));
            $thn_akhir = $model->thn_akhir."-".date("m-t",strtotime($model->thn_akhir."-12"));
            switch($model->jns_periode){
                case 'bulan' : $model->tgl_awal = $model->bln_awal."-01"; $model->tgl_akhir = $bln_akhir; break;
                case 'tahun' : $model->tgl_awal = $model->thn_awal."-01-01"; $model->tgl_akhir = $thn_akhir; break;
                default : null;
            }
            $model->tgl_awal = $model->tgl_awal." 00:00:00";
            $model->tgl_akhir = $model->tgl_akhir." 23:59:59";
        }

        $caraPrint = $_REQUEST['caraPrint'];
        $target ='konsulGizi/_print';

        $this->printFunctionNew($model, $data, $caraPrint, $judulLaporan, $target);
    }

    public function actionFrameGrafikLaporanKonsulGizi() {
        $this->layout = '//layouts/iframe';
        $model = new GZLaporankonsultasigiziV('search');
        $model->tgl_awal = date('d M Y 00:00:00');
        $model->tgl_akhir = date('d M Y H:i:s');

        //Data Grafik
        $data['title'] = 'Grafik Laporan Konsultasi Gizi';
        $data['type'] = $_GET['type'];
        if (isset($_GET['GZLaporankonsultasigiziV'])) {
            $model->attributes = $_GET['GZLaporankonsultasigiziV'];
            $format = new MyFormatter();
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['GZLaporankonsultasigiziV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['GZLaporankonsultasigiziV']['tgl_akhir']);
        }

        $this->render('_grafik', array(
            'model' => $model,
            'data' => $data,
        ));
    }
/* end
 * gizi->Laporan->LaporanKonsultasiGizi
 */ 

 /*
 * gizi->Laporan->LaporanKonsultasiGiziBerdasarkanRuangan
 */   
    public function actionLaporanKonsulGiziRekap() {
        $model = new GZLaporankonsultasigizirekapV('search');
        $format = new MyFormatter();
        $model->unsetAttributes();
        $model->jns_periode = "hari";
        $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
        $model->tgl_akhir = date('Y-m-d');
        $model->bln_awal = date('Y-m', strtotime('first day of january'));
        $model->bln_akhir = date('Y-m');
        $model->thn_awal = date('Y');
        $model->thn_akhir = date('Y');
        if (isset($_GET['GZLaporankonsultasigizirekapV'])) {
            $model->attributes = $_GET['GZLaporankonsultasigizirekapV'];
            $model->jns_periode = $_GET['GZLaporankonsultasigizirekapV']['jns_periode'];
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['GZLaporankonsultasigizirekapV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['GZLaporankonsultasigizirekapV']['tgl_akhir']);
            $model->bln_awal = $format->formatMonthForDb($_GET['GZLaporankonsultasigizirekapV']['bln_awal']);
            $model->bln_akhir = $format->formatMonthForDb($_GET['GZLaporankonsultasigizirekapV']['bln_akhir']);
            $bln_akhir = $model->bln_akhir."-".date("t",strtotime($model->bln_akhir));
            $thn_akhir = $model->thn_akhir."-".date("m-t",strtotime($model->thn_akhir."-12"));
            switch($model->jns_periode){
                case 'bulan' : $model->tgl_awal = $model->bln_awal."-01"; $model->tgl_akhir = $bln_akhir; break;
                case 'tahun' : $model->tgl_awal = $model->thn_awal."-01-01"; $model->tgl_akhir = $thn_akhir; break;
                default : null;
            }
            $model->tgl_awal = $model->tgl_awal." 00:00:00";
            $model->tgl_akhir = $model->tgl_akhir." 23:59:59";
        }
        $models = $model->findAll($model->searchTable());
        if (Yii::app()->request->isAjaxRequest) {
            echo $this->renderPartial('gizi.views.laporan.konsulGiziRekap/_table',
                        array(
                            'model'=>$model,
                            'models'=>$models,
                            'format' => $format
                             ), true
                    );
        }else{
        $this->render('konsulGiziRekap/admin', array(
            'model' => $model,
            'models' => $models,
            'format' => $format
        ));
        }
    }

    // public function actionPrintLaporanKonsulGiziRekap2() {
    //     $model = new GZLaporankonsultasigizirekapV('search');
    //     $judulLaporan = 'LAPORAN KONSULTASI GIZI <BR/> INSTALASI GIZI BULAN';

    //     //Data Grafik
    //     $data['title'] = 'Laporan Konsultasi Gizi';
    //     $data['type'] = $_REQUEST['type'];

    //     if (isset($_REQUEST['GZLaporankonsultasigizirekapV'])) {
    //         $model->attributes = $_REQUEST['GZLaporankonsultasigizirekapV'];
    //         $format = new MyFormatter();
    //         $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['GZLaporankonsultasigizirekapV']['tgl_awal']);
    //         $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['GZLaporankonsultasigizirekapV']['tgl_akhir']);
    //     }

    //     $caraPrint = $_REQUEST['caraPrint'];
    //     $target ='konsulGiziRekap/_print';

    //     $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
    // }

   public function actionPrintLaporanKonsulGiziRekap(){
        $this->layout='//layouts/printWindows';
        $model = new GZLaporankonsultasigizirekapV('search');
        $format = new MyFormatter();
        $model->unsetAttributes();
        $model->jns_periode = "hari";
        $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
        $model->tgl_akhir = date('Y-m-d');
        $model->bln_awal = date('Y-m', strtotime('first day of january'));
        $model->bln_akhir = date('Y-m');
        $model->thn_awal = date('Y');
        $model->thn_akhir = date('Y');
        if (isset($_GET['GZLaporankonsultasigizirekapV'])) {
            $model->attributes = $_GET['GZLaporankonsultasigizirekapV'];
            $model->jns_periode = $_GET['GZLaporankonsultasigizirekapV']['jns_periode'];
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['GZLaporankonsultasigizirekapV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['GZLaporankonsultasigizirekapV']['tgl_akhir']);
            $model->bln_awal = $format->formatMonthForDb($_GET['GZLaporankonsultasigizirekapV']['bln_awal']);
            $model->bln_akhir = $format->formatMonthForDb($_GET['GZLaporankonsultasigizirekapV']['bln_akhir']);
            $bln_akhir = $model->bln_akhir."-".date("t",strtotime($model->bln_akhir));
            $thn_akhir = $model->thn_akhir."-".date("m-t",strtotime($model->thn_akhir."-12"));
            switch($model->jns_periode){
                case 'bulan' : $model->tgl_awal = $model->bln_awal."-01"; $model->tgl_akhir = $bln_akhir; break;
                case 'tahun' : $model->tgl_awal = $model->thn_awal."-01-01"; $model->tgl_akhir = $thn_akhir; break;
                default : null;
            }
            $model->tgl_awal = $model->tgl_awal." 00:00:00";
            $model->tgl_akhir = $model->tgl_akhir." 23:59:59";
        }
        $models = $model->findAll($model->searchTable());
        $data = array();
        $data['judulLaporan'] = 'Laporan Pasien Konsultasi Gizi Berdasarkan Ruangan';
        $data['periode'] = 'Periode : ' . $format->formatDateTimeForUser($model->tgl_awal) . ' sampai dengan ' . $format->formatDateTimeForUser($model->tgl_akhir);
        if($_REQUEST['caraPrint'] == 'PDF'){
            $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
            $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
            $mpdf = new MyPDF('',$ukuranKertasPDF); 
            $mpdf->useOddEven = 2;
            $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
            $mpdf->WriteHTML($stylesheet,1);  
            $mpdf->AddPage($posisi,'','','','',15,15,15,15,15,15);
            
            $mpdf->WriteHTML(
                    $this->render('gizi.views.laporan.konsulGiziRekap/_print',
                        array(
                            'model'=>$model,
                            'models'=>$models,
                            'data'=>$data,
                            'caraPrint'=>$_REQUEST['caraPrint']
                        ),true)
                );  
            $mpdf->Output();
        }else{
            $this->render('gizi.views.laporan.konsulGiziRekap/_print', array(
                'model' => $model,
                'models'=>$models,
                'caraPrint'=>$_REQUEST['caraPrint'],
                'data'=>$data
            )); 

        }
    }    

    public function actionFrameGrafikLaporanKonsulGiziRekap() {
        $this->layout = '//layouts/iframe';
        $model = new GZLaporankonsultasigizirekapV('search');
        $model->tgl_awal = date('d M Y 00:00:00');
        $model->tgl_akhir = date('d M Y H:i:s');

        //Data Grafik
        $data['title'] = 'Grafik Laporan Konsultasi Gizi Berdasarkan Ruangan';
        $data['type'] = $_GET['type'];
        if (isset($_GET['GZLaporankonsultasigizirekapV'])) {
            $model->attributes = $_GET['GZLaporankonsultasigizirekapV'];
            $format = new MyFormatter();
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['GZLaporankonsultasigizirekapV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['GZLaporankonsultasigizirekapV']['tgl_akhir']);
        }

        $this->render('_grafik', array(
            'model' => $model,
            'data' => $data,
        ));
    }
/* end
 * gizi->Laporan->LaporanKonsultasiGiziBerdasarkanRuangan
 */         
    
/*
 * gizi->Laporan->LaporanJasaKonsultasiGizi
 */   
    public function actionLaporanJasaKonsulGizi() {
        $model = new GZLaporanjasakomponengiziV('search');
        $format = new MyFormatter();
        $model->unsetAttributes();
        $model->jns_periode = "hari";
        $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
        $model->tgl_akhir = date('Y-m-d');
        $model->bln_awal = date('Y-m', strtotime('first day of january'));
        $model->bln_akhir = date('Y-m');
        $model->thn_awal = date('Y');
        $model->thn_akhir = date('Y');
        if (isset($_GET['GZLaporanjasakomponengiziV'])) {
            $model->attributes = $_GET['GZLaporanjasakomponengiziV'];
            $model->jns_periode = $_GET['GZLaporanjasakomponengiziV']['jns_periode'];
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['GZLaporanjasakomponengiziV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['GZLaporanjasakomponengiziV']['tgl_akhir']);
            $model->bln_awal = $format->formatMonthForDb($_GET['GZLaporanjasakomponengiziV']['bln_awal']);
            $model->bln_akhir = $format->formatMonthForDb($_GET['GZLaporanjasakomponengiziV']['bln_akhir']);
            $bln_akhir = $model->bln_akhir."-".date("t",strtotime($model->bln_akhir));
            $thn_akhir = $model->thn_akhir."-".date("m-t",strtotime($model->thn_akhir."-12"));
            switch($model->jns_periode){
                case 'bulan' : $model->tgl_awal = $model->bln_awal."-01"; $model->tgl_akhir = $bln_akhir; break;
                case 'tahun' : $model->tgl_awal = $model->thn_awal."-01-01"; $model->tgl_akhir = $thn_akhir; break;
                default : null;
            }
            $model->tgl_awal = $model->tgl_awal." 00:00:00";
            $model->tgl_akhir = $model->tgl_akhir." 23:59:59";
        }

        $this->render('jasaKonsulGizi/admin', array(
            'model' => $model, 'format'=>$format
        ));
    }

    public function actionPrintLaporanJasaKonsulGizi() {
        $model = new GZLaporanjasakomponengiziV('search');
        $judulLaporan = 'Laporan Jasa Konsultasi Gizi';
        $format = new MyFormatter();
        $model->unsetAttributes();
        $model->jns_periode = "hari";
        $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
        $model->tgl_akhir = date('Y-m-d');
        $model->bln_awal = date('Y-m', strtotime('first day of january'));
        $model->bln_akhir = date('Y-m');
        $model->thn_awal = date('Y');
        $model->thn_akhir = date('Y');

        //Data Grafik
        $data['title'] = 'Grafik Laporan Jasa Konsultasi Gizi';
        $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : "");

        if (isset($_REQUEST['GZLaporanjasakomponengiziV'])) {
            $model->attributes = $_REQUEST['GZLaporanjasakomponengiziV'];
            $model->jns_periode = $_GET['GZLaporanjasakomponengiziV']['jns_periode'];
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['GZLaporanjasakomponengiziV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['GZLaporanjasakomponengiziV']['tgl_akhir']);
            $model->bln_awal = $format->formatMonthForDb($_GET['GZLaporanjasakomponengiziV']['bln_awal']);
            $model->bln_akhir = $format->formatMonthForDb($_GET['GZLaporanjasakomponengiziV']['bln_akhir']);
            $bln_akhir = $model->bln_akhir."-".date("t",strtotime($model->bln_akhir));
            $thn_akhir = $model->thn_akhir."-".date("m-t",strtotime($model->thn_akhir."-12"));
            switch($model->jns_periode){
                case 'bulan' : $model->tgl_awal = $model->bln_awal."-01"; $model->tgl_akhir = $bln_akhir; break;
                case 'tahun' : $model->tgl_awal = $model->thn_awal."-01-01"; $model->tgl_akhir = $thn_akhir; break;
                default : null;
            }
            $model->tgl_awal = $model->tgl_awal." 00:00:00";
            $model->tgl_akhir = $model->tgl_akhir." 23:59:59";
        }

        $caraPrint = $_REQUEST['caraPrint'];
        $target ='jasaKonsulGizi/_print';

        $this->printFunctionNew($model, $data, $caraPrint, $judulLaporan, $target);
    }

    public function actionFrameGrafikLaporanJasaKonsulGizi() {
        $this->layout = '//layouts/iframe';
        $model = new GZLaporanjasakomponengiziV('search');
        $model->tgl_awal = date('d M Y 00:00:00');
        $model->tgl_akhir = date('d M Y H:i:s');

        //Data Grafik
        $data['title'] = 'Grafik Laporan Jasa Konsultasi Gizi';
        $data['type'] = $_GET['type'];
        if (isset($_GET['GZLaporanjasakomponengiziV'])) {
            $model->attributes = $_GET['GZLaporanjasakomponengiziV'];
            $format = new MyFormatter();
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['GZLaporanjasakomponengiziV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['GZLaporanjasakomponengiziV']['tgl_akhir']);
        }

        $this->render('_grafik', array(
            'model' => $model,
            'data' => $data,
        ));
    }
/* end
 * gizi->Laporan->LaporanJasaKonsultasiGizi
 */
    
/*
 * gizi->Laporan->LaporanMakananHarian
 */   
    public function actionLaporanMakananHarian() {
        $model = new GZLaporanmakanangiziV('search');
        $format = new MyFormatter();
        $model->unsetAttributes();
        $model->jns_periode = "hari";
        $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
        $model->tgl_akhir = date('Y-m-d');
        $model->bln_awal = date('Y-m', strtotime('first day of january'));
        $model->bln_akhir = date('Y-m');
        $model->thn_awal = date('Y');
        $model->thn_akhir = date('Y');
        if (isset($_GET['GZLaporanmakanangiziV'])) {
            $model->attributes = $_GET['GZLaporanmakanangiziV'];
            $model->jns_periode = $_GET['GZLaporanmakanangiziV']['jns_periode'];
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['GZLaporanmakanangiziV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['GZLaporanmakanangiziV']['tgl_akhir']);
            $model->bln_awal = $format->formatMonthForDb($_GET['GZLaporanmakanangiziV']['bln_awal']);
            $model->bln_akhir = $format->formatMonthForDb($_GET['GZLaporanmakanangiziV']['bln_akhir']);
            $bln_akhir = $model->bln_akhir."-".date("t",strtotime($model->bln_akhir));
            $thn_akhir = $model->thn_akhir."-".date("m-t",strtotime($model->thn_akhir."-12"));
            switch($model->jns_periode){
                case 'bulan' : $model->tgl_awal = $model->bln_awal."-01"; $model->tgl_akhir = $bln_akhir; break;
                case 'tahun' : $model->tgl_awal = $model->thn_awal."-01-01"; $model->tgl_akhir = $thn_akhir; break;
                default : null;
            }
            $model->tgl_awal = $model->tgl_awal." 00:00:00";
            $model->tgl_akhir = $model->tgl_akhir." 23:59:59";
        }

        $this->render('makananHarian/admin', array(
            'model' => $model, 'format'=>$format
        ));
    }

    public function actionPrintLaporanMakananHarian() {
        $model = new GZLaporanmakanangiziV('search');
        $judulLaporan = 'Laporan Makanan Harian';
        $format = new MyFormatter();
        $model->unsetAttributes();
        $model->jns_periode = "hari";
        $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
        $model->tgl_akhir = date('Y-m-d');
        $model->bln_awal = date('Y-m', strtotime('first day of january'));
        $model->bln_akhir = date('Y-m');
        $model->thn_awal = date('Y');
        $model->thn_akhir = date('Y');
        
        //Data Grafik
        $data['title'] = 'Grafik Laporan Makanan Harian';
        $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : "");

        if (isset($_REQUEST['GZLaporanmakanangiziV'])) {
            $model->attributes = $_REQUEST['GZLaporanmakanangiziV'];
            $model->jns_periode = $_GET['GZLaporanmakanangiziV']['jns_periode'];
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['GZLaporanmakanangiziV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['GZLaporanmakanangiziV']['tgl_akhir']);
            $model->bln_awal = $format->formatMonthForDb($_GET['GZLaporanmakanangiziV']['bln_awal']);
            $model->bln_akhir = $format->formatMonthForDb($_GET['GZLaporanmakanangiziV']['bln_akhir']);
            $bln_akhir = $model->bln_akhir."-".date("t",strtotime($model->bln_akhir));
            $thn_akhir = $model->thn_akhir."-".date("m-t",strtotime($model->thn_akhir."-12"));
            switch($model->jns_periode){
                case 'bulan' : $model->tgl_awal = $model->bln_awal."-01"; $model->tgl_akhir = $bln_akhir; break;
                case 'tahun' : $model->tgl_awal = $model->thn_awal."-01-01"; $model->tgl_akhir = $thn_akhir; break;
                default : null;
            }
            $model->tgl_awal = $model->tgl_awal." 00:00:00";
            $model->tgl_akhir = $model->tgl_akhir." 23:59:59";
        }

        $caraPrint = $_REQUEST['caraPrint'];
        $target ='makananHarian/_print';

        $this->printFunctionNew($model, $data, $caraPrint, $judulLaporan, $target);
    }

    public function actionFrameGrafikLaporanMakananHarian() {
        $this->layout = '//layouts/iframe';
        $model = new GZLaporanmakanangiziV('search');
        $model->tgl_awal = date('d M Y 00:00:00');
        $model->tgl_akhir = date('d M Y H:i:s');

        //Data Grafik
        $data['title'] = 'Grafik Laporan Makanan Harian';
        $data['type'] = $_GET['type'];
        if (isset($_GET['GZLaporanmakanangiziV'])) {
            $model->attributes = $_GET['GZLaporanmakanangiziV'];
            $format = new MyFormatter();
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['GZLaporanmakanangiziV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['GZLaporanmakanangiziV']['tgl_akhir']);
        }

        $this->render('_grafik', array(
            'model' => $model,
            'data' => $data,
        ));
    }
/* end
 * gizi->Laporan->LaporanMakananHarian
 */    
    
    public function actionLaporanJumlahPasienHarian()
    {
        $model = new GZLaporanjmlpasienhariangiziV('searchLaporan');
        $model->tgl_awal = date('d M Y');
        $model->tgl_akhir = date('d M Y');
        if (isset($_GET['GZLaporanjmlpasienhariangiziV'])) {
            $model->attributes = $_GET['GZLaporanjmlpasienhariangiziV'];
            $model->pilihanTab = $_GET['GZLaporanjmlpasienhariangiziV']['pilihan_tab'];
            $format = new MyFormatter();
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['GZLaporanjmlpasienhariangiziV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['GZLaporanjmlpasienhariangiziV']['tgl_akhir']);
        }
        $models = $model->findAll($model->searchLaporan());
        $modRekaps = $model->findAll($model->searchRekap());
        if (Yii::app()->request->isAjaxRequest) {
            echo $this->renderPartial('gizi.views.laporan.jumlahPasienHarian/_tables',
                        array(
                            'model'=>$model,
                            'models'=>$models,
                            'modRekaps'=>$modRekaps,
                            'pilihanTab'=>$_GET['GZLaporanjmlpasienhariangiziV']['pilihan_tab'],
                        ), true
                    );
        }else{
            $this->render('jumlahPasienHarian/adminJmlPasienHarian', array(
                'model' => $model,
                'models' => $models,
                'modRekaps' => $modRekaps,
            ));    
        }

    }
    
    public function actionPrintLaporanJumlahPasienHarian(){
        $this->layout='//layouts/printWindows';
        $model = new GZLaporanjmlpasienhariangiziV('searchLaporan');
        $model->tgl_awal = date('d M Y').' 00:00:00';
        $model->tgl_akhir = date('d M Y H:i:s');
        if (isset($_GET['GZLaporanjmlpasienhariangiziV'])) {
            $model->attributes = $_GET['GZLaporanjmlpasienhariangiziV'];
            $model->pilihanTab = $_GET['GZLaporanjmlpasienhariangiziV']['pilihan_tab'];
            $format = new MyFormatter();
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['GZLaporanjmlpasienhariangiziV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['GZLaporanjmlpasienhariangiziV']['tgl_akhir']);
        }
        $models = $model->findAll($model->searchLaporan());
        $modRekaps = $model->findAll($model->searchRekap());
        $data = array();
        if($_GET['GZLaporanjmlpasienhariangiziV']['pilihan_tab'] == 'rekap'){
            $data['judulLaporan'] = 'Laporan Rekap Jumlah';
        }else{
            $data['judulLaporan'] = 'Laporan Jumlah Harian';
        }
        $data['periode'] = 'Periode : ' . date("d-m-Y", strtotime($model->tgl_awal)) . ' s/d ' . date("d-m-Y", strtotime($model->tgl_akhir));
        if($_REQUEST['caraPrint'] == 'PDF'){
            $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
            $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
            $mpdf = new MyPDF('',$ukuranKertasPDF); 
            $mpdf->useOddEven = 2;
            $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
            $mpdf->WriteHTML($stylesheet,1);  
            $mpdf->AddPage($posisi,'','','','',15,15,15,15,15,15);
            
            $mpdf->WriteHTML(
                    $this->render('gizi.views.laporan.jumlahPasienHarian/print',
                        array(
                            'model'=>$model,
                            'models'=>$models,
                            'modRekaps'=>$modRekaps,
                            'pilihanTab'=>$_GET['GZLaporanjmlpasienhariangiziV']['pilihan_tab'],
                            'caraPrint'=>$_REQUEST['caraPrint'],
                            'data'=>$data
                        ),true)
                );  
            $mpdf->Output();
        }else{
            $this->render('gizi.views.laporan.jumlahPasienHarian/print', array(
                'model' => $model,
                'models'=>$models,
                'modRekaps'=>$modRekaps,
                'pilihanTab'=>$_GET['GZLaporanjmlpasienhariangiziV']['pilihan_tab'],
                'caraPrint'=>$_REQUEST['caraPrint'],
                'data'=>$data
            )); 

        }
    }

/*
 * gizi->Laporan->LaporanExtraFooding
 */   
    public function actionLaporanExtraFooding() {
        $model = new GZLaporanextrafoodinggiziV('search');
        $format = new MyFormatter();
        $model->unsetAttributes();
        $model->jns_periode = "hari";
        $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
        $model->tgl_akhir = date('Y-m-d');
        $model->bln_awal = date('Y-m', strtotime('first day of january'));
        $model->bln_akhir = date('Y-m');
        $model->thn_awal = date('Y');
        $model->thn_akhir = date('Y');
        if (isset($_GET['GZLaporanextrafoodinggiziV'])) {
            $model->attributes = $_GET['GZLaporanextrafoodinggiziV'];
            $model->jns_periode = $_GET['GZLaporanextrafoodinggiziV']['jns_periode'];
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['GZLaporanextrafoodinggiziV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['GZLaporanextrafoodinggiziV']['tgl_akhir']);
            $model->bln_awal = $format->formatMonthForDb($_GET['GZLaporanextrafoodinggiziV']['bln_awal']);
            $model->bln_akhir = $format->formatMonthForDb($_GET['GZLaporanextrafoodinggiziV']['bln_akhir']);
            $bln_akhir = $model->bln_akhir."-".date("t",strtotime($model->bln_akhir));
            $thn_akhir = $model->thn_akhir."-".date("m-t",strtotime($model->thn_akhir."-12"));
            switch($model->jns_periode){
                case 'bulan' : $model->tgl_awal = $model->bln_awal."-01"; $model->tgl_akhir = $bln_akhir; break;
                case 'tahun' : $model->tgl_awal = $model->thn_awal."-01-01"; $model->tgl_akhir = $thn_akhir; break;
                default : null;
            }
            $model->tgl_awal = $model->tgl_awal." 00:00:00";
            $model->tgl_akhir = $model->tgl_akhir." 23:59:59";
        }

        $this->render('extraFooding/admin', array(
            'model' => $model, 'format' => $format
        ));
    }

    public function actionPrintLaporanExtraFooding() {
        $model = new GZLaporanextrafoodinggiziV('search');
        $judulLaporan = 'Laporan Extra Fooding';
        $format = new MyFormatter();
        $model->unsetAttributes();
        $model->jns_periode = "hari";
        $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
        $model->tgl_akhir = date('Y-m-d');
        $model->bln_awal = date('Y-m', strtotime('first day of january'));
        $model->bln_akhir = date('Y-m');
        $model->thn_awal = date('Y');
        $model->thn_akhir = date('Y');

        //Data Grafik
        $data['title'] = 'Grafik Laporan Extra Fooding';
        $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : "");

        if (isset($_REQUEST['GZLaporanextrafoodinggiziV'])) {
            $model->attributes = $_REQUEST['GZLaporanextrafoodinggiziV'];
            $model->jns_periode = $_REQUEST['GZLaporanextrafoodinggiziV']['jns_periode'];
            $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['GZLaporanextrafoodinggiziV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['GZLaporanextrafoodinggiziV']['tgl_akhir']);
            $model->bln_awal = $format->formatMonthForDb($_REQUEST['GZLaporanextrafoodinggiziV']['bln_awal']);
            $model->bln_akhir = $format->formatMonthForDb($_REQUEST['GZLaporanextrafoodinggiziV']['bln_akhir']);
            $bln_akhir = $model->bln_akhir."-".date("t",strtotime($model->bln_akhir));
            $thn_akhir = $model->thn_akhir."-".date("m-t",strtotime($model->thn_akhir."-12"));
            switch($model->jns_periode){
                case 'bulan' : $model->tgl_awal = $model->bln_awal."-01"; $model->tgl_akhir = $bln_akhir; break;
                case 'tahun' : $model->tgl_awal = $model->thn_awal."-01-01"; $model->tgl_akhir = $thn_akhir; break;
                default : null;
            }
            $model->tgl_awal = $model->tgl_awal." 00:00:00";
            $model->tgl_akhir = $model->tgl_akhir." 23:59:59";
        }

        $caraPrint = $_REQUEST['caraPrint'];
        $target ='extraFooding/_print';

        $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
    }

    public function actionFrameGrafikLaporanExtraFooding() {
        $this->layout = '//layouts/iframe';
        $model = new GZLaporanextrafoodinggiziV('search');
        $model->tgl_awal = date('d M Y 00:00:00');
        $model->tgl_akhir = date('d M Y H:i:s');

        //Data Grafik
        $data['title'] = 'Grafik Laporan Extra Fooding';
        $data['type'] = $_GET['type'];
        if (isset($_GET['GZLaporanextrafoodinggiziV'])) {
            $model->attributes = $_GET['GZLaporanextrafoodinggiziV'];
            $format = new MyFormatter();
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['GZLaporanextrafoodinggiziV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['GZLaporanextrafoodinggiziV']['tgl_akhir']);
        }

        $this->render('_grafik', array(
            'model' => $model,
            'data' => $data,
        ));
    }
    
   /*
 * gizi->Laporan->LaporanJumlahPorsiKelas
 */   
    public function actionLaporanJumlahPorsiKelas() {
        $model = new GZLaporanjmlporsikelasruanganV('search');
        $format = new MyFormatter();
        $model->unsetAttributes();
        $model->jns_periode = "hari";
        $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
        $model->tgl_akhir = date('Y-m-d');
        $model->bln_awal = date('Y-m', strtotime('first day of january'));
        $model->bln_akhir = date('Y-m');
        $model->thn_awal = date('Y');
        $model->thn_akhir = date('Y');
        if (isset($_GET['GZLaporanjmlporsikelasruanganV'])) {
            $model->attributes = $_GET['GZLaporanjmlporsikelasruanganV'];
            $model->jns_periode = $_GET['GZLaporanjmlporsikelasruanganV']['jns_periode'];
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['GZLaporanjmlporsikelasruanganV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['GZLaporanjmlporsikelasruanganV']['tgl_akhir']);
            $model->bln_awal = $format->formatMonthForDb($_GET['GZLaporanjmlporsikelasruanganV']['bln_awal']);
            $model->bln_akhir = $format->formatMonthForDb($_GET['GZLaporanjmlporsikelasruanganV']['bln_akhir']);
            $bln_akhir = $model->bln_akhir."-".date("t",strtotime($model->bln_akhir));
            $thn_akhir = $model->thn_akhir."-".date("m-t",strtotime($model->thn_akhir."-12"));
            switch($model->jns_periode){
                case 'bulan' : $model->tgl_awal = $model->bln_awal."-01"; $model->tgl_akhir = $bln_akhir; break;
                case 'tahun' : $model->tgl_awal = $model->thn_awal."-01-01"; $model->tgl_akhir = $thn_akhir; break;
                default : null;
            }
            $model->tgl_awal = $model->tgl_awal." 00:00:00";
            $model->tgl_akhir = $model->tgl_akhir." 23:59:59";
        }

        $this->render('jmlPorsiKelas/admin', array(
            'model' => $model, 'format'=>$format
        ));
    }

    public function actionPrintLaporanJumlahPorsiKelas() {
        $model = new GZLaporanjmlporsikelasruanganV('search');
        $judulLaporan = 'Laporan Jumlah Porsi per Kelas';
        $format = new MyFormatter();
        $model->unsetAttributes();
        $model->jns_periode = "hari";
        $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
        $model->tgl_akhir = date('Y-m-d');
        $model->bln_awal = date('Y-m', strtotime('first day of january'));
        $model->bln_akhir = date('Y-m');
        $model->thn_awal = date('Y');
        $model->thn_akhir = date('Y');

        //Data Grafik
        $data['title'] = 'Grafik Laporan Jumlah Porsi per Kelas';
        $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : "");

        if (isset($_REQUEST['GZLaporanjmlporsikelasruanganV'])) {
            $model->attributes = $_REQUEST['GZLaporanjmlporsikelasruanganV'];
            $model->jns_periode = $_GET['GZLaporanjmlporsikelasruanganV']['jns_periode'];
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['GZLaporanjmlporsikelasruanganV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['GZLaporanjmlporsikelasruanganV']['tgl_akhir']);
            $model->bln_awal = $format->formatMonthForDb($_GET['GZLaporanjmlporsikelasruanganV']['bln_awal']);
            $model->bln_akhir = $format->formatMonthForDb($_GET['GZLaporanjmlporsikelasruanganV']['bln_akhir']);
            $bln_akhir = $model->bln_akhir."-".date("t",strtotime($model->bln_akhir));
            $thn_akhir = $model->thn_akhir."-".date("m-t",strtotime($model->thn_akhir."-12"));
            switch($model->jns_periode){
                case 'bulan' : $model->tgl_awal = $model->bln_awal."-01"; $model->tgl_akhir = $bln_akhir; break;
                case 'tahun' : $model->tgl_awal = $model->thn_awal."-01-01"; $model->tgl_akhir = $thn_akhir; break;
                default : null;
            }
            $model->tgl_awal = $model->tgl_awal." 00:00:00";
            $model->tgl_akhir = $model->tgl_akhir." 23:59:59";
        }

        $caraPrint = $_REQUEST['caraPrint'];
        $target ='jmlPorsiKelas/_print';

        $this->printFunctionNew($model, $data, $caraPrint, $judulLaporan, $target);
    }

    public function actionFrameGrafikLaporanJumlahPorsiKelas() {
        $this->layout = '//layouts/iframe';
        $model = new GZLaporanjmlporsikelasruanganV('search');
        $model->tgl_awal = date('d M Y 00:00:00');
        $model->tgl_akhir = date('d M Y H:i:s');

        //Data Grafik
        $data['title'] = 'Grafik Laporan Jumlah Porsi per Kelas';
        $data['type'] = $_GET['type'];
        if (isset($_GET['GZLaporanjmlporsikelasruanganV'])) {
            $model->attributes = $_GET['GZLaporanjmlporsikelasruanganV'];
            $format = new MyFormatter();
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['GZLaporanjmlporsikelasruanganV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['GZLaporanjmlporsikelasruanganV']['tgl_akhir']);
        }

        $this->render('_grafik', array(
            'model' => $model,
            'data' => $data,
        ));
    }
/* end
 * gizi->Laporan->LaporanJumlahPorsiKelas
 */


public function actionLaporanJumlahPorsiGizi() {

        $model = new GZLaporanJumlahPorsiV('search');
        $model->tgl_awal = date('d M Y');
        $model->tgl_akhir = date('d M Y');
        
        if (isset($_GET['GZLaporanJumlahPorsiV'])) {
            $model->attributes = $_GET['GZLaporanJumlahPorsiV'];
            $format = new MyFormatter();
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['GZLaporanJumlahPorsiV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['GZLaporanJumlahPorsiV']['tgl_akhir']);
        }

        if (Yii::app()->request->isAjaxRequest) {
            echo $this->renderPartial('gizi.views.laporan.jumlahPorsi/_tableJumlahPorsi',
                        array(
                            'model'=>$model,
                        ), true
                    );
        }else{
             $this->render('jumlahPorsi/adminJumlahPorsi', array(
            'model' => $model
        ));
        }

       
    }

    public function actionPrintLaporanJumlahPorsiGizi() {
        $model = new GZLaporanJumlahPorsiV('');
        $judulLaporan = 'Laporan Jumlah Porsi Berdasarkan Ruangan';

        //Data Grafik
        $data['title'] = 'Grafik Laporan Jumlah Porsi Berdasarkan Ruangan';
        $data['type'] = $_REQUEST['type'];

        if (isset($_REQUEST['GZLaporanJumlahPorsiV'])) {
            $model->attributes = $_REQUEST['GZLaporanJumlahPorsiV'];
            $format = new MyFormatter();
            $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['GZLaporanJumlahPorsiV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['GZLaporanJumlahPorsiV']['tgl_akhir']);
        }

        $caraPrint = $_REQUEST['caraPrint'];
        $target ='jumlahPorsi/_print';

        $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
    }

    public function actionFrameGrafikLaporanJumlahPorsiGizi() {
        $this->layout = '//layouts/iframe';
        $model = new GZLaporanJumlahPorsiV('search');
        $model->tgl_awal = date('d M Y 00:00:00');
        $model->tgl_akhir = date('d M Y H:i:s');

        //Data Grafik
        $data['title'] = 'Grafik Laporan Jumlah Porsi Berdasarkan Ruangan';
        $data['type'] = $_GET['type'];
        if (isset($_GET['GZLaporanJumlahPorsiV'])) {
            $model->attributes = $_GET['GZLaporanJumlahPorsiV'];
            $format = new MyFormatter();
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['GZLaporanJumlahPorsiV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['GZLaporanJumlahPorsiV']['tgl_akhir']);
        }

        $this->render('_grafik', array(
            'model' => $model,
            'data' => $data,
        ));
    }
    
    //pemakaian obat alkes ruangan
    public function actionLaporanPemakaiObatAlkes()
    {
        $model = new GZLaporanpemakaiobatalkesruanganV;
        $model->unsetAttributes();
        $format = new MyFormatter();
        $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
        $model->jns_periode = "hari";
        $model->tgl_awal = date('Y-m-d');
        $model->tgl_akhir = date('Y-m-d');
        $model->bln_awal = date('Y-m', strtotime('first day of january'));
        $model->bln_akhir = date('Y-m');
        $model->thn_awal = date('Y');
        $model->thn_akhir = date('Y');   
        $jenisObat =CHtml::listData($model->getJenisobatalkesItems(),'jenisobatalkes_id','jenisobatalkes_id');
        $model->jenisobatalkes_id = $jenisObat;
        if(isset($_GET['GZLaporanpemakaiobatalkesruanganV']))
        {
            $model->attributes = $_GET['GZLaporanpemakaiobatalkesruanganV'];
            $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
            $model->jns_periode = $_GET['GZLaporanpemakaiobatalkesruanganV']['jns_periode'];
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['GZLaporanpemakaiobatalkesruanganV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['GZLaporanpemakaiobatalkesruanganV']['tgl_akhir']);
            $model->bln_awal = $format->formatMonthForDb($_GET['GZLaporanpemakaiobatalkesruanganV']['bln_awal']);
            $model->bln_akhir = $format->formatMonthForDb($_GET['GZLaporanpemakaiobatalkesruanganV']['bln_akhir']);
            $model->thn_awal = $_GET['GZLaporanpemakaiobatalkesruanganV']['thn_awal'];
            $model->thn_akhir = $_GET['GZLaporanpemakaiobatalkesruanganV']['thn_akhir'];
            $bln_akhir = $model->bln_akhir."-".date("t",strtotime($model->bln_akhir));
            $thn_akhir = $model->thn_akhir."-".date("m-t",strtotime($model->thn_akhir."-12"));
            switch($model->jns_periode){
                case 'bulan' : $model->tgl_awal = $model->bln_awal."-01"; $model->tgl_akhir = $bln_akhir; break;
                case 'tahun' : $model->tgl_awal = $model->thn_awal."-01-01"; $model->tgl_akhir = $thn_akhir; break;
                default : null;
            }
            
        }
        
        $this->render('pemakaiObatAlkes/adminPemakaiObatAlkes',array(
            'model'=>$model,'format'=>$format
        ));
       
    }

    public function actionPrintLaporanPemakaiObatAlkes() {
        $model = new GZLaporanpemakaiobatalkesruanganV('search');
        $format = new MyFormatter();
        $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
        $model->jns_periode = "hari";
        $model->tgl_awal = date('Y-m-d');
        $model->tgl_akhir = date('Y-m-d');
        $model->bln_awal = date('Y-m', strtotime('first day of january'));
        $model->bln_akhir = date('Y-m');
        $model->thn_awal = date('Y');
        $model->thn_akhir = date('Y');   
        $judulLaporan = 'Laporan Info Pemakai Obat Alkes Rawat Jalan';

        //Data Grafik       
        $data['title'] = 'Grafik Laporan Pemakai Obat Alkes';
        $data['type'] = $_REQUEST['type'];
        if (isset($_REQUEST['GZLaporanpemakaiobatalkesruanganV'])) {
            $model->attributes = $_REQUEST['GZLaporanpemakaiobatalkesruanganV'];
            $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
            $model->jns_periode = $_GET['GZLaporanpemakaiobatalkesruanganV']['jns_periode'];
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['GZLaporanpemakaiobatalkesruanganV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['GZLaporanpemakaiobatalkesruanganV']['tgl_akhir']);
            $model->bln_awal = $format->formatMonthForDb($_GET['GZLaporanpemakaiobatalkesruanganV']['bln_awal']);
            $model->bln_akhir = $format->formatMonthForDb($_GET['GZLaporanpemakaiobatalkesruanganV']['bln_akhir']);
            $model->thn_awal = $_GET['GZLaporanpemakaiobatalkesruanganV']['thn_awal'];
            $model->thn_akhir = $_GET['GZLaporanpemakaiobatalkesruanganV']['thn_akhir'];
            $bln_akhir = $model->bln_akhir."-".date("t",strtotime($model->bln_akhir));
            $thn_akhir = $model->thn_akhir."-".date("m-t",strtotime($model->thn_akhir."-12"));
            switch($model->jns_periode){
                case 'bulan' : $model->tgl_awal = $model->bln_awal."-01"; $model->tgl_akhir = $bln_akhir; break;
                case 'tahun' : $model->tgl_awal = $model->thn_awal."-01-01"; $model->tgl_akhir = $thn_akhir; break;
                default : null;
            }
            $model->tgl_awal = $model->tgl_awal;
            $model->tgl_akhir = $model->tgl_akhir;
        }
        
        $caraPrint = $_REQUEST['caraPrint'];
        $target = 'pemakaiObatAlkes/_printPemakaiObatAlkes';
        
        $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
    }
    

    public function actionFrameGrafikLaporanPemakaiObatAlkes() {
        $this->layout = '//layouts/iframe';
        $model = new GZLaporanpemakaiobatalkesruanganV('search');
        $format = new MyFormatter();
        $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
        $model->jns_periode = "hari";
        $model->tgl_awal = date('Y-m-d');
        $model->tgl_akhir = date('Y-m-d');
        $model->bln_awal = date('Y-m', strtotime('first day of january'));
        $model->bln_akhir = date('Y-m');
        $model->thn_awal = date('Y');
        $model->thn_akhir = date('Y');   

        //Data Grafik
        $data['title'] = 'Grafik Laporan Pemakai Obat Alkes';
        $data['type'] = $_GET['type'];
        if (isset($_GET['GZLaporanpemakaiobatalkesruanganV'])) {
            $model->attributes = $_GET['GZLaporanpemakaiobatalkesruanganV'];
            $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
            $model->jns_periode = $_GET['GZLaporanpemakaiobatalkesruanganV']['jns_periode'];
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['GZLaporanpemakaiobatalkesruanganV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['GZLaporanpemakaiobatalkesruanganV']['tgl_akhir']);
            $model->bln_awal = $format->formatMonthForDb($_GET['GZLaporanpemakaiobatalkesruanganV']['bln_awal']);
            $model->bln_akhir = $format->formatMonthForDb($_GET['GZLaporanpemakaiobatalkesruanganV']['bln_akhir']);
            $model->thn_awal = $_GET['GZLaporanpemakaiobatalkesruanganV']['thn_awal'];
            $model->thn_akhir = $_GET['GZLaporanpemakaiobatalkesruanganV']['thn_akhir'];
            $bln_akhir = $model->bln_akhir."-".date("t",strtotime($model->bln_akhir));
            $thn_akhir = $model->thn_akhir."-".date("m-t",strtotime($model->thn_akhir."-12"));
            switch($model->jns_periode){
                case 'bulan' : $model->tgl_awal = $model->bln_awal."-01"; $model->tgl_akhir = $bln_akhir; break;
                case 'tahun' : $model->tgl_awal = $model->thn_awal."-01-01"; $model->tgl_akhir = $thn_akhir; break;
                default : null;
            }
            $model->tgl_awal = $model->tgl_awal;
            $model->tgl_akhir = $model->tgl_akhir;
        }
                
        $this->render('_grafik', array(
            'model' => $model,
            'data' => $data,
        ));
    }

    protected function printFunction($model, $data, $caraPrint, $judulLaporan, $target){
        $format = new MyFormatter();
        $periode = $model->tgl_awal.' s/d '.$model->tgl_akhir;
        
        if ($caraPrint == 'PRINT' || $caraPrint == 'GRAFIK') {
            $this->layout = '//layouts/printWindows2';
            $this->render($target, array('model' => $model, 'periode'=>$periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
        } else if ($caraPrint == 'EXCEL') {
            $this->layout = '//layouts/printExcel';
             $this->render($target, array('model' => $model, 'periode'=>$periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
        } else if ($_REQUEST['caraPrint'] == 'PDF') {
            $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
            $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
            $mpdf = new MyPDF('', $ukuranKertasPDF);
            $mpdf->useOddEven = 2;
            $footer = '<table width="100%"><tr>'
                    . '<td style = "text-align:left;font-size:8px;"><i><b>Generated By eHealthsys</b></i></td>'
                    . '<td style = "text-align:right;font-size:8px;"><i><b>Print Count :</b></i></td>'
                    . '</tr></table>';
            $mpdf->SetHtmlFooter($footer,'E');
            $mpdf->SetHtmlFooter($footer,'O');              
            $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
            $mpdf->WriteHTML($stylesheet, 1);
            $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
            $mpdf->WriteHTML($this->renderPartial($target, array('model' => $model, 'periode'=>$periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
            $mpdf->Output();
        }
    }
    
    protected function printFunctionNew($model, $data, $caraPrint, $judulLaporan, $target){
        $format = new MyFormatter();
        $periode = $format->formatDateTimeForUser($model->tgl_awal).' sampai dengan '.$format->formatDateTimeForUser($model->tgl_akhir);
        
        if ($caraPrint == 'PRINT' || $caraPrint == 'GRAFIK') {
            $this->layout = '//layouts/printWindows';
            $this->render($target, array('model' => $model, 'periode'=>$periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
        } else if ($caraPrint == 'EXCEL') {
            $this->layout = '//layouts/printExcel';
             $this->render($target, array('model' => $model, 'periode'=>$periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
        } else if ($_REQUEST['caraPrint'] == 'PDF') {
            $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
            $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
            $mpdf = new MyPDF('', $ukuranKertasPDF);
            $mpdf->useOddEven = 2;
            $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
            $mpdf->WriteHTML($stylesheet, 1);
            $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
            $mpdf->WriteHTML($this->renderPartial($target, array('model' => $model, 'periode'=>$periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
            $mpdf->Output();
        }
    }
    
    protected function parserTanggal($tgl){
    $tgl = explode(' ', $tgl);
    $result = array();
        foreach ($tgl as $row){
            if (!empty($row)){
                $result[] = $row;
            }
        }
    return Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($result[0], 'yyyy-MM-dd'),'medium',null).' '.$result[1];
        
    }
}