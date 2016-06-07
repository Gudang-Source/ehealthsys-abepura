<?php
Yii::import("billingKasir.models.*");
class LaporanController extends MyAuthController {
    
    public function actionLaporanKunjungan() {
        $model = new RIInfokunjunganriV('search');        
        $model->unsetAttributes();
        $format = new MyFormatter();
        $model->jns_periode = "hari";
        $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
        $model->tgl_akhir = date('Y-m-d');
        $model->bln_awal = date('Y-m', strtotime('first day of january'));
        $model->bln_akhir = date('Y-m');
        $model->thn_awal = date('Y');
        $model->thn_akhir = date('Y');
        $model->ruangan_id = Yii::app()->user->getState('ruangan_id');

        if (isset($_GET['RIInfokunjunganriV'])) {
            $model->attributes = $_GET['RIInfokunjunganriV'];
            $model->jns_periode = $_GET['RIInfokunjunganriV']['jns_periode'];
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['RIInfokunjunganriV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['RIInfokunjunganriV']['tgl_akhir']);
            $model->bln_awal = $format->formatMonthForDb($_GET['RIInfokunjunganriV']['bln_awal']);
            $model->bln_akhir = $format->formatMonthForDb($_GET['RIInfokunjunganriV']['bln_akhir']);
            $model->thn_awal = $_GET['RIInfokunjunganriV']['thn_awal'];
            $model->thn_akhir = $_GET['RIInfokunjunganriV']['thn_akhir'];
            $bln_akhir = $model->bln_akhir."-".date("t",strtotime($model->bln_akhir));
            $thn_akhir = $model->thn_akhir."-".date("m-t",strtotime($model->thn_akhir."-12"));
            switch($model->jns_periode){
                case 'bulan' : $model->tgl_awal = $model->bln_awal."-01"; $model->tgl_akhir = $bln_akhir; break;
                case 'tahun' : $model->tgl_awal = $model->thn_awal."-01-01"; $model->tgl_akhir = $thn_akhir; break;
                default : null;
            }
            $model->tgl_awal = $model->tgl_awal." 00:00:00";
            $model->tgl_akhir = $model->tgl_akhir." 23:59:59";
            $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
            $model->pilihanx = $_GET['RIInfokunjunganriV']['pilihanx'];
        }


        $this->render('kunjungan/adminKunjungan', array(
            'model' => $model,'format'=>$format
        ));
    }

    public function actionPrintLaporanKunjungan() {
        $model = new RIInfokunjunganriV('search');
        $format = new MyFormatter();
        $model->jns_periode = "hari";
        $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
        $model->tgl_akhir = date('Y-m-d');
        $model->bln_awal = date('Y-m', strtotime('first day of january'));
        $model->bln_akhir = date('Y-m');
        $model->thn_awal = date('Y');
        $model->thn_akhir = date('Y');
        $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
        $judulLaporan = 'Laporan Info Kunjungan Pasien Rawat Inap';

        //Data Grafik       
        $data['title'] = 'Grafik Laporan Info Kunjungan';
        $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : null);
        if (isset($_REQUEST['RIInfokunjunganriV'])) {
            $model->attributes = $_REQUEST['RIInfokunjunganriV'];            
            $model->jns_periode = $_GET['RIInfokunjunganriV']['jns_periode'];
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['RIInfokunjunganriV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['RIInfokunjunganriV']['tgl_akhir']);
            $model->bln_awal = $format->formatMonthForDb($_GET['RIInfokunjunganriV']['bln_awal']);
            $model->bln_akhir = $format->formatMonthForDb($_GET['RIInfokunjunganriV']['bln_akhir']);
            $model->thn_awal = $_GET['RIInfokunjunganriV']['thn_awal'];
            $model->thn_akhir = $_GET['RIInfokunjunganriV']['thn_akhir'];
            $bln_akhir = $model->bln_akhir."-".date("t",strtotime($model->bln_akhir));
            $thn_akhir = $model->thn_akhir."-".date("m-t",strtotime($model->thn_akhir."-12"));
            switch($model->jns_periode){
                case 'bulan' : $model->tgl_awal = $model->bln_awal."-01"; $model->tgl_akhir = $bln_akhir; break;
                case 'tahun' : $model->tgl_awal = $model->thn_awal."-01-01"; $model->tgl_akhir = $thn_akhir; break;
                default : null;
            }
            $model->tgl_awal = $model->tgl_awal." 00:00:00";
            $model->tgl_akhir = $model->tgl_akhir." 23:59:59";
            $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
            $model->pilihanx = $_GET['RIInfokunjunganriV']['pilihanx'];
        }
        
        $caraPrint = $_REQUEST['caraPrint'];
        $target = 'kunjungan/_printKunjungan';
        
        $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
    }

    public function actionFrameGrafikKunjungan() {
        $this->layout = '//layouts/iframe';
        $model = new RIInfokunjunganriV('search');
        $format = new MyFormatter();
        $model->jns_periode = "hari";
        $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
        $model->tgl_akhir = date('Y-m-d');
        $model->bln_awal = date('Y-m', strtotime('first day of january'));
        $model->bln_akhir = date('Y-m');
        $model->thn_awal = date('Y');
        $model->thn_akhir = date('Y');
        $model->ruangan_id = Yii::app()->user->getState('ruangan_id');

        //Data Grafik
        $data['title'] = 'Grafik Info Kunjungan';
        $data['type'] = $_GET['type'];
        if (isset($_GET['RIInfokunjunganriV'])) {
            $model->attributes = $_GET['RIInfokunjunganriV'];
            $model->jns_periode = $_GET['RIInfokunjunganriV']['jns_periode'];
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['RIInfokunjunganriV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['RIInfokunjunganriV']['tgl_akhir']);
            $model->bln_awal = $format->formatMonthForDb($_GET['RIInfokunjunganriV']['bln_awal']);
            $model->bln_akhir = $format->formatMonthForDb($_GET['RIInfokunjunganriV']['bln_akhir']);
            $model->thn_awal = $_GET['RIInfokunjunganriV']['thn_awal'];
            $model->thn_akhir = $_GET['RIInfokunjunganriV']['thn_akhir'];
            $bln_akhir = $model->bln_akhir."-".date("t",strtotime($model->bln_akhir));
            $thn_akhir = $model->thn_akhir."-".date("m-t",strtotime($model->thn_akhir."-12"));
            switch($model->jns_periode){
                case 'bulan' : $model->tgl_awal = $model->bln_awal."-01"; $model->tgl_akhir = $bln_akhir; break;
                case 'tahun' : $model->tgl_awal = $model->thn_awal."-01-01"; $model->tgl_akhir = $thn_akhir; break;
                default : null;
            }
            $model->tgl_awal = $model->tgl_awal." 00:00:00";
            $model->tgl_akhir = $model->tgl_akhir." 23:59:59";
            $model->ruangan_id = Yii::app()->user->getState('ruangan_id');  
            $model->pilihanx = $_GET['RIInfokunjunganriV']['pilihanx'];
        }
        
        $this->render('_grafik', array(
            'model' => $model,
            'data' => $data,
        ));
    }
    
    public function actionLaporanSensusHarian() {
        $model = new RILaporansensusharian('search');        
        $model->unsetAttributes();
        $format = new MyFormatter();
        $model->jns_periode = "hari";
        $model->tgl_awal = date('Y-m-d');//, strtotime('first day of this month')
        $model->tgl_akhir = date('Y-m-d');
        $model->bln_awal = date('Y-m', strtotime('first day of january'));
        $model->bln_akhir = date('Y-m');
        $model->thn_awal = date('Y');
        $model->thn_akhir = date('Y');
        $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
        
        if (isset($_GET['RILaporansensusharian'])) {
            $model->attributes = $_GET['RILaporansensusharian'];
            $model->jns_periode = $_GET['RILaporansensusharian']['jns_periode'];
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['RILaporansensusharian']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['RILaporansensusharian']['tgl_akhir']);
            $model->bln_awal = $format->formatMonthForDb($_GET['RILaporansensusharian']['bln_awal']);
            $model->bln_akhir = $format->formatMonthForDb($_GET['RILaporansensusharian']['bln_akhir']);
            $model->thn_awal = $_GET['RILaporansensusharian']['thn_awal'];
            $model->thn_akhir = $_GET['RILaporansensusharian']['thn_akhir'];
            $bln_akhir = $model->bln_akhir."-".date("t",strtotime($model->bln_akhir));
            $thn_akhir = $model->thn_akhir."-".date("m-t",strtotime($model->thn_akhir."-12"));
            switch($model->jns_periode){
                case 'bulan' : $model->tgl_awal = $model->bln_awal."-01"; $model->tgl_akhir = $bln_akhir; break;
                case 'tahun' : $model->tgl_awal = $model->thn_awal."-01-01"; $model->tgl_akhir = $thn_akhir; break;
                default : null;
            }
            $model->tgl_awal = $model->tgl_awal." 00:00:00";
            $model->tgl_akhir = $model->tgl_akhir." 23:59:59";
            $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
        }

        $this->render('sensus/adminSensus', array(
            'model' => $model,'format'=>$format
        ));
    }

    public function actionPrintLaporanSensusHarian() {
        $model = new RILaporansensusharian('search');
        $format = new MyFormatter();
        $model->jns_periode = "hari";
        $model->tgl_awal = date('Y-m-d');//, strtotime('first day of this month')
        $model->tgl_akhir = date('Y-m-d');
        $model->bln_awal = date('Y-m', strtotime('first day of january'));
        $model->bln_akhir = date('Y-m');
        $model->thn_awal = date('Y');
        $model->thn_akhir = date('Y');
        $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
        $judulLaporan = 'Laporan Sensus Harian Rawat Inap';

        //Data Grafik
        $data['title'] = 'Grafik Laporan Sensus Harian';
        $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : null);
        if (isset($_REQUEST['RILaporansensusharian'])) {
            $model->attributes = $_REQUEST['RILaporansensusharian'];
            $model->jns_periode = $_GET['RILaporansensusharian']['jns_periode'];
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['RILaporansensusharian']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['RILaporansensusharian']['tgl_akhir']);
            $model->bln_awal = $format->formatMonthForDb($_GET['RILaporansensusharian']['bln_awal']);
            $model->bln_akhir = $format->formatMonthForDb($_GET['RILaporansensusharian']['bln_akhir']);
            $model->thn_awal = $_GET['RILaporansensusharian']['thn_awal'];
            $model->thn_akhir = $_GET['RILaporansensusharian']['thn_akhir'];
            $bln_akhir = $model->bln_akhir."-".date("t",strtotime($model->bln_akhir));
            $thn_akhir = $model->thn_akhir."-".date("m-t",strtotime($model->thn_akhir."-12"));
            switch($model->jns_periode){
                case 'bulan' : $model->tgl_awal = $model->bln_awal."-01"; $model->tgl_akhir = $bln_akhir; break;
                case 'tahun' : $model->tgl_awal = $model->thn_awal."-01-01"; $model->tgl_akhir = $thn_akhir; break;
                default : null;
            }
            $model->tgl_awal = $model->tgl_awal." 00:00:00";
            $model->tgl_akhir = $model->tgl_akhir." 23:59:59";
            $model->ruangan_id = Yii::app()->user->getState('ruangan_id');            
        }
               
        $caraPrint = $_REQUEST['caraPrint'];
        $target = 'sensus/_print';
        
        $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
    }

    public function actionFrameGrafikSensusHarian() {
        $this->layout = '//layouts/iframe';
        $model = new RILaporansensusharian('search');
        $format = new MyFormatter();
        $model->jns_periode = "hari";
        $model->tgl_awal = date('Y-m-d');//, strtotime('first day of this month')
        $model->tgl_akhir = date('Y-m-d');
        $model->bln_awal = date('Y-m', strtotime('first day of january'));
        $model->bln_akhir = date('Y-m');
        $model->thn_awal = date('Y');
        $model->thn_akhir = date('Y');
        $model->ruangan_id = Yii::app()->user->getState('ruangan_id');

        //Data Grafik
        $data['title'] = 'Grafik Laporan Sensus Harian';
        $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : null);
        
        if (isset($_GET['RILaporansensusharian'])) {
            $model->attributes = $_GET['RILaporansensusharian'];
            $model->jns_periode = $_GET['RILaporansensusharian']['jns_periode'];
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['RILaporansensusharian']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['RILaporansensusharian']['tgl_akhir']);
            $model->bln_awal = $format->formatMonthForDb($_GET['RILaporansensusharian']['bln_awal']);
            $model->bln_akhir = $format->formatMonthForDb($_GET['RILaporansensusharian']['bln_akhir']);
            $model->thn_awal = $_GET['RILaporansensusharian']['thn_awal'];
            $model->thn_akhir = $_GET['RILaporansensusharian']['thn_akhir'];
            $bln_akhir = $model->bln_akhir."-".date("t",strtotime($model->bln_akhir));
            $thn_akhir = $model->thn_akhir."-".date("m-t",strtotime($model->thn_akhir."-12"));
            switch($model->jns_periode){
                case 'bulan' : $model->tgl_awal = $model->bln_awal."-01"; $model->tgl_akhir = $bln_akhir; break;
                case 'tahun' : $model->tgl_awal = $model->thn_awal."-01-01"; $model->tgl_akhir = $thn_akhir; break;
                default : null;
            }
            $model->tgl_awal = $model->tgl_awal." 00:00:00";
            $model->tgl_akhir = $model->tgl_akhir." 23:59:59";
            $model->ruangan_id = Yii::app()->user->getState('ruangan_id');  
        }
        
        $this->render('_grafik', array(
            'model' => $model,
            'data' => $data,
        ));
    }

    public function actionLaporanTindakLanjut() {
        $model = new RILaporantindaklanjutri('search');        
        $model->unsetAttributes();
        $format = new MyFormatter();
        $model->jns_periode = "hari";
        $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
        $model->tgl_akhir = date('Y-m-d');
        $model->bln_awal = date('Y-m', strtotime('first day of january'));
        $model->bln_akhir = date('Y-m');
        $model->thn_awal = date('Y');
        $model->thn_akhir = date('Y');
        $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
               
        
        $temp = array();
        foreach (LookupM::getItems('carakeluar') as $i=>$data){
            $temp[] = strtoupper($data);
        }
        $model->carakeluar = $temp;
        
        if (isset($_GET['RILaporantindaklanjutri'])) {
            $model->attributes = $_GET['RILaporantindaklanjutri'];
            $model->jns_periode = $_GET['RILaporantindaklanjutri']['jns_periode'];
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['RILaporantindaklanjutri']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['RILaporantindaklanjutri']['tgl_akhir']);
            $model->bln_awal = $format->formatMonthForDb($_GET['RILaporantindaklanjutri']['bln_awal']);
            $model->bln_akhir = $format->formatMonthForDb($_GET['RILaporantindaklanjutri']['bln_akhir']);
            $model->thn_awal = $_GET['RILaporantindaklanjutri']['thn_awal'];
            $model->thn_akhir = $_GET['RILaporantindaklanjutri']['thn_akhir'];
            $bln_akhir = $model->bln_akhir."-".date("t",strtotime($model->bln_akhir));
            $thn_akhir = $model->thn_akhir."-".date("m-t",strtotime($model->thn_akhir."-12"));
            switch($model->jns_periode){
                case 'bulan' : $model->tgl_awal = $model->bln_awal."-01"; $model->tgl_akhir = $bln_akhir; break;
                case 'tahun' : $model->tgl_awal = $model->thn_awal."-01-01"; $model->tgl_akhir = $thn_akhir; break;
                default : null;
            }
            $model->tgl_awal = $model->tgl_awal." 00:00:00";
            $model->tgl_akhir = $model->tgl_akhir." 23:59:59";
            $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
        }

        $this->render('tindakLanjut/adminTindakLanjut', array(
            'model' => $model,'format'=>$format
        ));
    }

    public function actionPrintLaporanTindakLanjut() {
        $model = new RILaporantindaklanjutri('search');
         $format = new MyFormatter();
        $model->jns_periode = "hari";
        $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
        $model->tgl_akhir = date('Y-m-d');
        $model->bln_awal = date('Y-m', strtotime('first day of january'));
        $model->bln_akhir = date('Y-m');
        $model->thn_awal = date('Y');
        $model->thn_akhir = date('Y');
        $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
        $judulLaporan = 'Laporan Tindak Lanjut Pasien Rawat Inap';

        //Data Grafik
        $data['title'] = 'Grafik Laporan Tindak Lanjut Pasien';
        $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : null);
        if (isset($_REQUEST['RILaporantindaklanjutri'])) {
            $model->attributes = $_REQUEST['RILaporantindaklanjutri'];
            $model->jns_periode = $_GET['RILaporantindaklanjutri']['jns_periode'];
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['RILaporantindaklanjutri']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['RILaporantindaklanjutri']['tgl_akhir']);
            $model->bln_awal = $format->formatMonthForDb($_GET['RILaporantindaklanjutri']['bln_awal']);
            $model->bln_akhir = $format->formatMonthForDb($_GET['RILaporantindaklanjutri']['bln_akhir']);
            $model->thn_awal = $_GET['RILaporantindaklanjutri']['thn_awal'];
            $model->thn_akhir = $_GET['RILaporantindaklanjutri']['thn_akhir'];
            $bln_akhir = $model->bln_akhir."-".date("t",strtotime($model->bln_akhir));
            $thn_akhir = $model->thn_akhir."-".date("m-t",strtotime($model->thn_akhir."-12"));
            switch($model->jns_periode){
                case 'bulan' : $model->tgl_awal = $model->bln_awal."-01"; $model->tgl_akhir = $bln_akhir; break;
                case 'tahun' : $model->tgl_awal = $model->thn_awal."-01-01"; $model->tgl_akhir = $thn_akhir; break;
                default : null;
            }
            $model->tgl_awal = $model->tgl_awal." 00:00:00";
            $model->tgl_akhir = $model->tgl_akhir." 23:59:59";
            $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
        }
        
        $caraPrint = $_REQUEST['caraPrint'];
        $target = 'tindakLanjut/_printTindakLanjut';
        
        $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
    }

    public function actionFrameGrafikLaporanTindakLanjut() {
        $this->layout = '//layouts/iframe';
        $model = new RILaporantindaklanjutri('search');
         $format = new MyFormatter();
        $model->jns_periode = "hari";
        $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
        $model->tgl_akhir = date('Y-m-d');
        $model->bln_awal = date('Y-m', strtotime('first day of january'));
        $model->bln_akhir = date('Y-m');
        $model->thn_awal = date('Y');
        $model->thn_akhir = date('Y');
        $model->ruangan_id = Yii::app()->user->getState('ruangan_id');

        //Data Grafik 
        $data['title'] = 'Grafik Laporan Tindak Lanjut Pasien';
        $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : null);
        if (isset($_GET['RILaporantindaklanjutri'])) {
            $model->attributes = $_GET['RILaporantindaklanjutri'];
            $model->jns_periode = $_GET['RILaporantindaklanjutri']['jns_periode'];
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['RILaporantindaklanjutri']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['RILaporantindaklanjutri']['tgl_akhir']);
            $model->bln_awal = $format->formatMonthForDb($_GET['RILaporantindaklanjutri']['bln_awal']);
            $model->bln_akhir = $format->formatMonthForDb($_GET['RILaporantindaklanjutri']['bln_akhir']);
            $model->thn_awal = $_GET['RILaporantindaklanjutri']['thn_awal'];
            $model->thn_akhir = $_GET['RILaporantindaklanjutri']['thn_akhir'];
            $bln_akhir = $model->bln_akhir."-".date("t",strtotime($model->bln_akhir));
            $thn_akhir = $model->thn_akhir."-".date("m-t",strtotime($model->thn_akhir."-12"));
            switch($model->jns_periode){
                case 'bulan' : $model->tgl_awal = $model->bln_awal."-01"; $model->tgl_akhir = $bln_akhir; break;
                case 'tahun' : $model->tgl_awal = $model->thn_awal."-01-01"; $model->tgl_akhir = $thn_akhir; break;
                default : null;
            }
            $model->tgl_awal = $model->tgl_awal." 00:00:00";
            $model->tgl_akhir = $model->tgl_akhir." 23:59:59";
            $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
        }
                
        $this->render('_grafik', array(
            'model' => $model,
            'data' => $data,
        ));
    }
    
    public function actionLaporanPasienMeninggal() {
        $model = new RILaporanpasienmeninggalriV('searchTable');
        $format = new MyFormatter();
        $model->unsetAttributes();
        $model->jns_periode = "hari";
        $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
        $model->tgl_akhir = date('Y-m-d');
        $model->bln_awal = date('Y-m', strtotime('first day of january'));
        $model->bln_akhir = date('Y-m');
        $model->thn_awal = date('Y');
        $model->thn_akhir = date('Y');
        $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
        $caramasuk = CHtml::listData(CaramasukM::model()->findAll('caramasuk_aktif = true'), 'caramasuk_id', 'caramasuk_id');
        $model->caramasuk_id = $caramasuk;
        
        if (isset($_GET['RILaporanpasienmeninggalriV'])) {
            $model->attributes = $_GET['RILaporanpasienmeninggalriV'];
            $model->jns_periode = $_GET['RILaporanpasienmeninggalriV']['jns_periode'];
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['RILaporanpasienmeninggalriV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['RILaporanpasienmeninggalriV']['tgl_akhir']);
            $model->bln_awal = $format->formatMonthForDb($_GET['RILaporanpasienmeninggalriV']['bln_awal']);
            $model->bln_akhir = $format->formatMonthForDb($_GET['RILaporanpasienmeninggalriV']['bln_akhir']);
            $model->thn_awal = $_GET['RILaporanpasienmeninggalriV']['thn_awal'];
            $model->thn_akhir = $_GET['RILaporanpasienmeninggalriV']['thn_akhir'];
            $bln_akhir = $model->bln_akhir."-".date("t",strtotime($model->bln_akhir));
            $thn_akhir = $model->thn_akhir."-".date("m-t",strtotime($model->thn_akhir."-12"));
            switch($model->jns_periode){
                case 'bulan' : $model->tgl_awal = $model->bln_awal."-01"; $model->tgl_akhir = $bln_akhir; break;
                case 'tahun' : $model->tgl_awal = $model->thn_awal."-01-01"; $model->tgl_akhir = $thn_akhir; break;
                default : null;
            }
            $model->tgl_awal = $model->tgl_awal." 00:00:00";
            $model->tgl_akhir = $model->tgl_akhir." 23:59:59";
            $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
            
        }

        $this->render('pasienMeninggal/index', array(
            'model' => $model,'format'=>$format
        ));
    }

    public function actionPrintLaporanPasienMeninggal() {
        $model = new RILaporanpasienmeninggalriV('search');
        $judulLaporan = 'Laporan Pasien Meninggal';
        $format = new MyFormatter();	
		$model->unsetAttributes();
        $model->jns_periode = "hari";
        $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
        $model->tgl_akhir = date('Y-m-d');
        $model->bln_awal = date('Y-m', strtotime('first day of january'));
        $model->bln_akhir = date('Y-m');
        $model->thn_awal = date('Y');
        $model->thn_akhir = date('Y');
        $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
        //Data Grafik
        $data['title'] = 'Grafik Laporan Pasien Meninggal';
        $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : "");
		
        if (isset($_REQUEST['RILaporanpasienmeninggalriV'])) {
            $model->attributes = $_REQUEST['RILaporanpasienmeninggalriV'];
            $model->jns_periode = $_REQUEST['RILaporanpasienmeninggalriV']['jns_periode'];
            $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['RILaporanpasienmeninggalriV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['RILaporanpasienmeninggalriV']['tgl_akhir']);
            $model->bln_awal = $format->formatMonthForDb($_REQUEST['RILaporanpasienmeninggalriV']['bln_awal']);
            $model->bln_akhir = $format->formatMonthForDb($_REQUEST['RILaporanpasienmeninggalriV']['bln_akhir']);
            $bln_akhir = $model->bln_akhir."-".date("t",strtotime($model->bln_akhir));
            $thn_akhir = $model->thn_akhir."-".date("m-t",strtotime($model->thn_akhir."-12"));
            switch($model->jns_periode){
                case 'bulan' : $model->tgl_awal = $model->bln_awal."-01"; $model->tgl_akhir = $bln_akhir; break;
                case 'tahun' : $model->tgl_awal = $model->thn_awal."-01-01"; $model->tgl_akhir = $thn_akhir; break;
                default : null;
            }
            $model->tgl_awal = $model->tgl_awal." 00:00:00";
            $model->tgl_akhir = $model->tgl_akhir." 23:59:59";
            $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
        }
               
        $caraPrint = $_REQUEST['caraPrint'];
        $target = 'pasienMeninggal/_print';
        
        $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
    }

    public function actionFrameGrafikPasienMeninggal() {
        $this->layout = '//layouts/iframe';
		$format = new MyFormatter();
        $model = new RILaporanpasienmeninggalriV('search');
        $model->unsetAttributes();
        $model->jns_periode = "hari";
        $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
        $model->tgl_akhir = date('Y-m-d');
        $model->bln_awal = date('Y-m', strtotime('first day of january'));
        $model->bln_akhir = date('Y-m');
        $model->thn_awal = date('Y');
        $model->thn_akhir = date('Y');
        $model->ruangan_id = Yii::app()->user->getState('ruangan_id');

        //Data Grafik
        $data['title'] = 'Grafik Laporan Pasien Meninggal';
        $data['type'] = (isset($_GET['type']) ? $_GET['type'] : null);
        
        if (isset($_GET['RILaporanpasienmeninggalriV'])) {
           $model->attributes = $_GET['RILaporanpasienmeninggalriV'];
            $model->jns_periode = $_GET['RILaporanpasienmeninggalriV']['jns_periode'];
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['RILaporanpasienmeninggalriV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['RILaporanpasienmeninggalriV']['tgl_akhir']);
            $model->bln_awal = $format->formatMonthForDb($_GET['RILaporanpasienmeninggalriV']['bln_awal']);
            $model->bln_akhir = $format->formatMonthForDb($_GET['RILaporanpasienmeninggalriV']['bln_akhir']);
            $bln_akhir = $model->bln_akhir."-".date("t",strtotime($model->bln_akhir));
            $thn_akhir = $model->thn_akhir."-".date("m-t",strtotime($model->thn_akhir."-12"));
            switch($model->jns_periode){
                case 'bulan' : $model->tgl_awal = $model->bln_awal."-01"; $model->tgl_akhir = $bln_akhir; break;
                case 'tahun' : $model->tgl_awal = $model->thn_awal."-01-01"; $model->tgl_akhir = $thn_akhir; break;
                default : null;
            }
            $model->tgl_awal = $model->tgl_awal." 00:00:00";
            $model->tgl_akhir = $model->tgl_akhir." 23:59:59";
            $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
        }
        
        $this->render('_grafik', array(
            'model' => $model,
            'data' => $data,
        ));
    }
    
    public function actionLaporanBukuRegister() {
        $model = new RIBukuregisterriV('search');
        $format = new MyFormatter();
        $model->unsetAttributes();
        $model->jns_periode = "hari";
        $model->tgl_awal = date('Y-m-d');//, strtotime('first day of this month')
        $model->tgl_akhir = date('Y-m-d');
        $model->bln_awal = date('Y-m', strtotime('first day of january'));
        $model->bln_akhir = date('Y-m');
        $model->thn_awal = date('Y');
        $model->thn_akhir = date('Y');
        $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
        
        if (isset($_GET['RIBukuregisterriV']))
        {
            $model->attributes = $_GET['RIBukuregisterriV'];
            $model->jns_periode = $_GET['RIBukuregisterriV']['jns_periode'];
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['RIBukuregisterriV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['RIBukuregisterriV']['tgl_akhir']);
            $model->bln_awal = $format->formatMonthForDb($_GET['RIBukuregisterriV']['bln_awal']);
            $model->bln_akhir = $format->formatMonthForDb($_GET['RIBukuregisterriV']['bln_akhir']);
            $model->thn_awal = $_GET['RIBukuregisterriV']['thn_awal'];
            $model->thn_akhir = $_GET['RIBukuregisterriV']['thn_akhir'];
            $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
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
        
        $this->render('bukuRegister/adminBukuRegister', array(
            'model'=>$model,'format'=>$format
        ));
    }
    
    public function actionPrintLaporanBukuRegister() {
        $model = new RIBukuregisterriV('search');
        $model->jns_periode = "hari";
        $model->tgl_awal = date('Y-m-d');//, strtotime('first day of this month')
        $model->tgl_akhir = date('Y-m-d');
        $model->bln_awal = date('Y-m', strtotime('first day of january'));
        $model->bln_akhir = date('Y-m');
        $model->thn_awal = date('Y');
        $model->thn_akhir = date('Y');
        $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
        
        $judulLaporan = 'Laporan Buku Register Rawat Inap';
        $format = new MyFormatter();
        // Data untuk Grafik
        $data['title'] = 'Grafik Laporan Buku Register Rawat Inap';
        $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : null);
        
        if (isset($_REQUEST['RIBukuregisterriV'])) {
            $model->attributes = $_REQUEST['RIBukuregisterriV'];
            $model->jns_periode = $_REQUEST['RIBukuregisterriV']['jns_periode'];
            $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['RIBukuregisterriV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['RIBukuregisterriV']['tgl_akhir']);
            $model->bln_awal = $format->formatMonthForDb($_REQUEST['RIBukuregisterriV']['bln_awal']);
            $model->bln_akhir = $format->formatMonthForDb($_REQUEST['RIBukuregisterriV']['bln_akhir']);
            $bln_akhir = $model->bln_akhir."-".date("t",strtotime($model->bln_akhir));
            $thn_akhir = $model->thn_akhir."-".date("m-t",strtotime($model->thn_akhir."-12"));
            switch($model->jns_periode){
                case 'bulan' : $model->tgl_awal = $model->bln_awal."-01"; $model->tgl_akhir = $bln_akhir; break;
                case 'tahun' : $model->tgl_awal = $model->thn_awal."-01-01"; $model->tgl_akhir = $thn_akhir; break;
                default : null;
            }
            $model->tgl_awal = $model->tgl_awal." 00:00:00";
            $model->tgl_akhir = $model->tgl_akhir." 23:59:59";
            $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
        }
        
        $caraPrint = $_REQUEST['caraPrint'];
        $target = 'bukuRegister/_printBukuRegister';
        
        $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
    }

    public function actionFrameGrafikBukuRegister() {
        $this->layout = '//layouts/iframe';
        $model = new RIBukuregisterriV('search');
        $model->jns_periode = "hari";
        $model->tgl_awal = date('Y-m-d');//, strtotime('first day of this month')
        $model->tgl_akhir = date('Y-m-d');
        $model->bln_awal = date('Y-m', strtotime('first day of january'));
        $model->bln_akhir = date('Y-m');
        $model->thn_awal = date('Y');
        $model->thn_akhir = date('Y');
        $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
        // Data untuk Grafik
        $data['title'] = 'Grafik Laporan Buku Register Pasien Rawat Inap';
        $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : null);
        
        if (isset($_REQUEST['RIBukuregisterriV'])) {
            $model->attributes = $_GET['RIBukuregisterriV'];
            $format = new MyFormatter();
            $model->jns_periode = $_REQUEST['RIBukuregisterriV']['jns_periode'];
            $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['RIBukuregisterriV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['RIBukuregisterriV']['tgl_akhir']);
            $model->bln_awal = $format->formatMonthForDb($_REQUEST['RIBukuregisterriV']['bln_awal']);
            $model->bln_akhir = $format->formatMonthForDb($_REQUEST['RIBukuregisterriV']['bln_akhir']);
            $bln_akhir = $model->bln_akhir."-".date("t",strtotime($model->bln_akhir));
            $thn_akhir = $model->thn_akhir."-".date("m-t",strtotime($model->thn_akhir."-12"));
            switch($model->jns_periode){
                case 'bulan' : $model->tgl_awal = $model->bln_awal."-01"; $model->tgl_akhir = $bln_akhir; break;
                case 'tahun' : $model->tgl_awal = $model->thn_awal."-01-01"; $model->tgl_akhir = $thn_akhir; break;
                default : null;
            }
            $model->tgl_awal = $model->tgl_awal." 00:00:00";
            $model->tgl_akhir = $model->tgl_akhir." 23:59:59";
            $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
        }
        
        $this->render('_grafik',array(
            'model'=>$model,
            'data'=>$data,
        ));
    }
    
    public function actionLaporan10BesarPenyakit() {
        $model = new RILaporan10besarpenyakit('search');
        $format = new MyFormatter();
        $model->unsetAttributes();
        $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
        $model->jns_periode = "hari";
        $model->tgl_awal = date('Y-m-d');
        $model->tgl_akhir = date('Y-m-d');
        $model->bln_awal = date('Y-m', strtotime('first day of january'));
        $model->bln_akhir = date('Y-m');
        $model->thn_awal = date('Y');
        $model->thn_akhir = date('Y');
        $model->jumlahTampil = 10;        
		
        if (isset($_GET['RILaporan10besarpenyakit'])) {
            $model->attributes = $_GET['RILaporan10besarpenyakit'];
            $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
            $model->jns_periode = $_GET['RILaporan10besarpenyakit']['jns_periode'];
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['RILaporan10besarpenyakit']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['RILaporan10besarpenyakit']['tgl_akhir']);
            $model->bln_awal = $format->formatMonthForDb($_GET['RILaporan10besarpenyakit']['bln_awal']);
            $model->bln_akhir = $format->formatMonthForDb($_GET['RILaporan10besarpenyakit']['bln_akhir']);
            $model->thn_awal = $_GET['RILaporan10besarpenyakit']['thn_awal'];
            $model->thn_akhir = $_GET['RILaporan10besarpenyakit']['thn_akhir'];
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

        $this->render('10Besar/admin10BesarPenyakit', array(
            'model' => $model,'format'=>$format
        ));
    }

    public function actionPrintLaporan10BesarPenyakit() {
        $model = new RILaporan10besarpenyakit('search');
		$model->jns_periode = "hari";
		$model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
		$model->tgl_akhir = date('Y-m-d');
		$model->bln_awal = date('Y-m', strtotime('first day of january'));
		$model->bln_akhir = date('Y-m');
		$model->thn_awal = date('Y');
		$model->thn_akhir = date('Y');
        $judulLaporan = 'Laporan 10 Besar Penyakit Pasien Rawat Inap';
        $format = new MyFormatter();
        
        //Data Grafik
        $data['title'] = 'Grafik Laporan 10 Besar Penyakit Pasien';
        $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : null);
        if (isset($_REQUEST['RILaporan10besarpenyakit'])) {
            $model->attributes = $_REQUEST['RILaporan10besarpenyakit'];            
            $model->jns_periode = $_GET['RILaporan10besarpenyakit']['jns_periode'];
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['RILaporan10besarpenyakit']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['RILaporan10besarpenyakit']['tgl_akhir']);
            $model->bln_awal = $format->formatMonthForDb($_GET['RILaporan10besarpenyakit']['bln_awal']);
            $model->bln_akhir = $format->formatMonthForDb($_GET['RILaporan10besarpenyakit']['bln_akhir']);
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
        $target = '10Besar/_print10Besar';
        
        $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
    }

    public function actionFrameGrafik10BesarPenyakit() {
        $this->layout = '//layouts/iframe';
        $model = new RILaporan10besarpenyakit('search');
		$model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
		$model->tgl_akhir = date('Y-m-d');
		$model->bln_awal = date('Y-m', strtotime('first day of january'));
		$model->bln_akhir = date('Y-m');
		$model->thn_awal = date('Y');
		$model->thn_akhir = date('Y');

        //Data Grafik
        $data['title'] = 'Grafik Laporan 10 Besar Penyakit';
        $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : null);
        if (isset($_GET['RILaporan10besarpenyakit'])) {
            $model->attributes = $_GET['RILaporan10besarpenyakit'];
            $format = new MyFormatter();
			$model->attributes = $_REQUEST['RILaporan10besarpenyakit'];            
            $model->jns_periode = $_GET['RILaporan10besarpenyakit']['jns_periode'];
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['RILaporan10besarpenyakit']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['RILaporan10besarpenyakit']['tgl_akhir']);
            $model->bln_awal = $format->formatMonthForDb($_GET['RILaporan10besarpenyakit']['bln_awal']);
            $model->bln_akhir = $format->formatMonthForDb($_GET['RILaporan10besarpenyakit']['bln_akhir']);
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
               
        $this->render('_grafik', array(
            'model' => $model,
            'data' => $data,
        ));
    }
    
    public function actionLaporanBiayaPelayanan() {
        $model = new RILaporanbiayapelayanan('search');
        $model->unsetAttributes();
        $format = new MyFormatter();        
        $model->jns_periode = "hari";
        $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
        $model->tgl_akhir = date('Y-m-d');
        $model->bln_awal = date('Y-m', strtotime('first day of january'));
        $model->bln_akhir = date('Y-m');
        $model->thn_awal = date('Y');
        $model->thn_akhir = date('Y');
        $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
        
        $penjamin = CHtml::listData(PenjaminpasienM::model()->findAll('penjamin_aktif=TRUE'),'penjamin_id', 'penjamin_id');
        $model->penjamin_id = $penjamin;
        $kelas = CHtml::listData(KelaspelayananM::model()->findAll(), 'kelaspelayanan_id', 'kelaspelayanan_id');
        $model->kelaspelayanan_id = $kelas;
        $filter = (isset($_GET['filter']) ? $_GET['filter'] : null);
        if (isset($_GET['RILaporanbiayapelayanan'])) {
            $model->attributes = $_GET['RILaporanbiayapelayanan'];
            $model->jns_periode = $_GET['RILaporanbiayapelayanan']['jns_periode'];
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['RILaporanbiayapelayanan']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['RILaporanbiayapelayanan']['tgl_akhir']);
            $model->bln_awal = $format->formatMonthForDb($_GET['RILaporanbiayapelayanan']['bln_awal']);
            $model->bln_akhir = $format->formatMonthForDb($_GET['RILaporanbiayapelayanan']['bln_akhir']);
            $model->thn_awal = $_GET['RILaporanbiayapelayanan']['thn_awal'];
            $model->thn_akhir = $_GET['RILaporanbiayapelayanan']['thn_akhir'];
            $bln_akhir = $model->bln_akhir."-".date("t",strtotime($model->bln_akhir));
            $thn_akhir = $model->thn_akhir."-".date("m-t",strtotime($model->thn_akhir."-12"));
            switch($model->jns_periode){
                case 'bulan' : $model->tgl_awal = $model->bln_awal."-01"; $model->tgl_akhir = $bln_akhir; break;
                case 'tahun' : $model->tgl_awal = $model->thn_awal."-01-01"; $model->tgl_akhir = $thn_akhir; break;
                default : null;
            }
            $model->tgl_awal = $model->tgl_awal." 00:00:00";
            $model->tgl_akhir = $model->tgl_akhir." 23:59:59";
            $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
        }

        $this->render('biayaPelayanan/adminBiayaPelayanan', array(
            'model' => $model, 'filter'=>$filter, 'format'=>$format
        ));
    }

    public function actionPrintLaporanBiayaPelayanan() {
        $model = new RILaporanbiayapelayanan('search');
		$model->jns_periode = "hari";
		$model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
		$model->tgl_akhir = date('Y-m-d');
		$model->bln_awal = date('Y-m', strtotime('first day of january'));
		$model->bln_akhir = date('Y-m');
		$model->thn_awal = date('Y');
		$model->thn_akhir = date('Y');
                $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
        $judulLaporan = 'Laporan Biaya Pelayanan Rawat Inap';
        $format = new MyFormatter();
        //Data Grafik        
        $data['title'] = 'Grafik Laporan Biaya Pelayanan';
        $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : null);
        if (isset($_REQUEST['RILaporanbiayapelayanan'])) {
            $model->attributes = $_REQUEST['RILaporanbiayapelayanan'];
            $model->jns_periode = $_REQUEST['RILaporanbiayapelayanan']['jns_periode'];
            $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['RILaporanbiayapelayanan']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['RILaporanbiayapelayanan']['tgl_akhir']);
            $model->bln_awal = $format->formatMonthForDb($_REQUEST['RILaporanbiayapelayanan']['bln_awal']);
            $model->bln_akhir = $format->formatMonthForDb($_REQUEST['RILaporanbiayapelayanan']['bln_akhir']);
            $bln_akhir = $model->bln_akhir."-".date("t",strtotime($model->bln_akhir));
            $thn_akhir = $model->thn_akhir."-".date("m-t",strtotime($model->thn_akhir."-12"));
            switch($model->jns_periode){
                case 'bulan' : $model->tgl_awal = $model->bln_awal."-01"; $model->tgl_akhir = $bln_akhir; break;
                case 'tahun' : $model->tgl_awal = $model->thn_awal."-01-01"; $model->tgl_akhir = $thn_akhir; break;
                default : null;
            }
            $model->tgl_awal = $model->tgl_awal." 00:00:00";
            $model->tgl_akhir = $model->tgl_akhir." 23:59:59";
            $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
        }
        
        $caraPrint = $_REQUEST['caraPrint'];
        $target = 'biayaPelayanan/_printBiayaPelayanan';
        
        $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
    }

    public function actionFrameGrafikLaporanBiayaPelayanan() {
        $this->layout = '//layouts/iframe';
        $model = new RILaporanbiayapelayanan('search');
        $format = new MyFormatter();        
        $model->jns_periode = "hari";
        $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
        $model->tgl_akhir = date('Y-m-d');
        $model->bln_awal = date('Y-m', strtotime('first day of january'));
        $model->bln_akhir = date('Y-m');
        $model->thn_awal = date('Y');
        $model->thn_akhir = date('Y');
        $model->ruangan_id = Yii::app()->user->getState('ruangan_id');

        //Data Grafik
        $data['title'] = 'Grafik Laporan Biaya Pelayanan Rawat Inap';
        $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : null);
        if (isset($_GET['RILaporanbiayapelayanan'])) {
            $model->attributes = $_GET['RILaporanbiayapelayanan'];
            $model->jns_periode = $_GET['RILaporanbiayapelayanan']['jns_periode'];
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['RILaporanbiayapelayanan']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['RILaporanbiayapelayanan']['tgl_akhir']);
            $model->bln_awal = $format->formatMonthForDb($_GET['RILaporanbiayapelayanan']['bln_awal']);
            $model->bln_akhir = $format->formatMonthForDb($_GET['RILaporanbiayapelayanan']['bln_akhir']);
            $model->thn_awal = $_GET['RILaporanbiayapelayanan']['thn_awal'];
            $model->thn_akhir = $_GET['RILaporanbiayapelayanan']['thn_akhir'];
            $bln_akhir = $model->bln_akhir."-".date("t",strtotime($model->bln_akhir));
            $thn_akhir = $model->thn_akhir."-".date("m-t",strtotime($model->thn_akhir."-12"));
            switch($model->jns_periode){
                case 'bulan' : $model->tgl_awal = $model->bln_awal."-01"; $model->tgl_akhir = $bln_akhir; break;
                case 'tahun' : $model->tgl_awal = $model->thn_awal."-01-01"; $model->tgl_akhir = $thn_akhir; break;
                default : null;
            }
            $model->tgl_awal = $model->tgl_awal." 00:00:00";
            $model->tgl_akhir = $model->tgl_akhir." 23:59:59";
            $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
        }
                
        $this->render('_grafik', array(
            'model' => $model,
            'data' => $data,
        ));
    }
    
    public function actionLaporanPendapatanRuangan() {
        $model = new RILaporanpendapatanruangan('search');
        $model->unsetAttributes();
        $format = new MyFormatter();        
        $model->jns_periode = "hari";
        $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
        $model->tgl_akhir = date('Y-m-d');
        $model->bln_awal = date('Y-m', strtotime('first day of january'));
        $model->bln_akhir = date('Y-m');
        $model->thn_awal = date('Y');
        $model->thn_akhir = date('Y');
        $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
        
        $penjamin = CHtml::listData($model->getPenjaminItems(), 'penjamin_id', 'penjamin_id');
        $model->penjamin_id = $penjamin;
        $kelas = CHtml::listData(KelaspelayananM::model()->findAll(), 'kelaspelayanan_id', 'kelaspelayanan_id');
        $model->kelaspelayanan_id = $kelas;
        $filter = (isset($_GET['filter']) ? $_GET['filter'] : null);
        
        if (isset($_GET['RILaporanpendapatanruangan'])) {
            $model->attributes = $_GET['RILaporanpendapatanruangan'];
            $model->jns_periode = $_GET['RILaporanpendapatanruangan']['jns_periode'];
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['RILaporanpendapatanruangan']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['RILaporanpendapatanruangan']['tgl_akhir']);
            $model->bln_awal = $format->formatMonthForDb($_GET['RILaporanpendapatanruangan']['bln_awal']);
            $model->bln_akhir = $format->formatMonthForDb($_GET['RILaporanpendapatanruangan']['bln_akhir']);
            $model->thn_awal = $_GET['RILaporanpendapatanruangan']['thn_awal'];
            $model->thn_akhir = $_GET['RILaporanpendapatanruangan']['thn_akhir'];
            $bln_akhir = $model->bln_akhir."-".date("t",strtotime($model->bln_akhir));
            $thn_akhir = $model->thn_akhir."-".date("m-t",strtotime($model->thn_akhir."-12"));
            switch($model->jns_periode){
                case 'bulan' : $model->tgl_awal = $model->bln_awal."-01"; $model->tgl_akhir = $bln_akhir; break;
                case 'tahun' : $model->tgl_awal = $model->thn_awal."-01-01"; $model->tgl_akhir = $thn_akhir; break;
                default : null;
            }
            $model->tgl_awal = $model->tgl_awal." 00:00:00";
            $model->tgl_akhir = $model->tgl_akhir." 23:59:59";
            $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
        }

        $this->render('pendapatanRuangan/adminPendapatanRuangan', array(
            'model' => $model, 'filter'=>$filter,'format'=>$format
        ));
    }

    public function actionPrintLaporanPendapatanRuangan() {
        $model = new RILaporanpendapatanruangan('search');
        $model->jns_periode = "hari";
        $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
        $model->tgl_akhir = date('Y-m-d');
        $model->bln_awal = date('Y-m', strtotime('first day of january'));
        $model->bln_akhir = date('Y-m');
        $model->thn_awal = date('Y');
        $model->thn_akhir = date('Y');
        $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
        $judulLaporan = 'Laporan Grafik Pendapatan Ruangan Rawat Inap';
        $format = new MyFormatter();
        //Data Grafik        
        $data['title'] = 'Grafik Laporan Pendapatan Ruangan';
        $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : null);
        if (isset($_REQUEST['RILaporanpendapatanruangan'])) {
            $model->attributes = $_REQUEST['RILaporanpendapatanruangan'];
            $model->jns_periode = $_REQUEST['RILaporanpendapatanruangan']['jns_periode'];
            $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['RILaporanpendapatanruangan']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['RILaporanpendapatanruangan']['tgl_akhir']);
            $model->bln_awal = $format->formatMonthForDb($_REQUEST['RILaporanpendapatanruangan']['bln_awal']);
            $model->bln_akhir = $format->formatMonthForDb($_REQUEST['RILaporanpendapatanruangan']['bln_akhir']);
            $bln_akhir = $model->bln_akhir."-".date("t",strtotime($model->bln_akhir));
            $thn_akhir = $model->thn_akhir."-".date("m-t",strtotime($model->thn_akhir."-12"));
            switch($model->jns_periode){
                case 'bulan' : $model->tgl_awal = $model->bln_awal."-01"; $model->tgl_akhir = $bln_akhir; break;
                case 'tahun' : $model->tgl_awal = $model->thn_awal."-01-01"; $model->tgl_akhir = $thn_akhir; break;
                default : null;
            }
            $model->tgl_awal = $model->tgl_awal." 00:00:00";
            $model->tgl_akhir = $model->tgl_akhir." 23:59:59";
            $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
        }
        
        $caraPrint = $_REQUEST['caraPrint'];
        $target = 'pendapatanRuangan/_printPendapatanRuangan';
        
        $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
    }
			
    public function actionFrameGrafikLaporanPendapatanRuangan() {
        $this->layout = '//layouts/iframe';
        $model = new RILaporanpendapatanruangan('search');
        $format = new MyFormatter();        
        $model->jns_periode = "hari";
        $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
        $model->tgl_akhir = date('Y-m-d');
        $model->bln_awal = date('Y-m', strtotime('first day of january'));
        $model->bln_akhir = date('Y-m');
        $model->thn_awal = date('Y');
        $model->thn_akhir = date('Y');
        $model->ruangan_id = Yii::app()->user->getState('ruangan_id');

        //Data Grafik
        $data['title'] = 'Grafik Laporan Pendapatan Ruangan Rawat Inap';
        $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : null);
        if (isset($_GET['RILaporanpendapatanruangan'])) {
            $model->attributes = $_GET['RILaporanpendapatanruangan'];
           $model->jns_periode = $_GET['RILaporanpendapatanruangan']['jns_periode'];
            $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['RILaporanpendapatanruangan']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['RILaporanpendapatanruangan']['tgl_akhir']);
            $model->bln_awal = $format->formatMonthForDb($_REQUEST['RILaporanpendapatanruangan']['bln_awal']);
            $model->bln_akhir = $format->formatMonthForDb($_REQUEST['RILaporanpendapatanruangan']['bln_akhir']);
            $bln_akhir = $model->bln_akhir."-".date("t",strtotime($model->bln_akhir));
            $thn_akhir = $model->thn_akhir."-".date("m-t",strtotime($model->thn_akhir."-12"));
            switch($model->jns_periode){
                case 'bulan' : $model->tgl_awal = $model->bln_awal."-01"; $model->tgl_akhir = $bln_akhir; break;
                case 'tahun' : $model->tgl_awal = $model->thn_awal."-01-01"; $model->tgl_akhir = $thn_akhir; break;
                default : null;
            }
            $model->tgl_awal = $model->tgl_awal." 00:00:00";
            $model->tgl_akhir = $model->tgl_akhir." 23:59:59";
            $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
        }
                
        $this->render('_grafik', array(
            'model' => $model,
            'data' => $data,
        ));
    }
    
    public function actionLaporanPemakaiObatAlkes()
    {
        $model = new RILaporanpemakaiobatalkesV('searchTable');        
        $model->unsetAttributes();
        $format = new MyFormatter();
        $model->jns_periode = "hari";
        $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
        $model->tgl_akhir = date('Y-m-d');
        $model->bln_awal = date('Y-m', strtotime('first day of january'));
        $model->bln_akhir = date('Y-m');
        $model->thn_awal = date('Y');
        $model->thn_akhir = date('Y');
        $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
        
        if (isset($_GET['RILaporanpemakaiobatalkesV'])) {
            $model->attributes = $_GET['RILaporanpemakaiobatalkesV'];
            $model->jns_periode = $_GET['RILaporanpemakaiobatalkesV']['jns_periode'];
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['RILaporanpemakaiobatalkesV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['RILaporanpemakaiobatalkesV']['tgl_akhir']);
            $model->bln_awal = $format->formatMonthForDb($_GET['RILaporanpemakaiobatalkesV']['bln_awal']);
            $model->bln_akhir = $format->formatMonthForDb($_GET['RILaporanpemakaiobatalkesV']['bln_akhir']);
            $bln_akhir = $model->bln_akhir."-".date("t",strtotime($model->bln_akhir));
            $thn_akhir = $model->thn_akhir."-".date("m-t",strtotime($model->thn_akhir."-12"));
            switch($model->jns_periode){
                case 'bulan' : $model->tgl_awal = $model->bln_awal."-01"; $model->tgl_akhir = $bln_akhir; break;
                case 'tahun' : $model->tgl_awal = $model->thn_awal."-01-01"; $model->tgl_akhir = $thn_akhir; break;
                default : null;
            }
            $model->tgl_awal = $model->tgl_awal." 00:00:00";
            $model->tgl_akhir = $model->tgl_akhir." 23:59:59";
            $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
        }
        
        $this->render('pemakaiObatAlkes/adminPemakaiObatAlkes',array(
            'model'=>$model,'format'=>$format
        ));
    }
    
    public function actionPrintLaporanPemakaiObatAlkes()
    {
        $model = new RILaporanpemakaiobatalkesV('searchTable');
		$model->jns_periode = "hari";
		$model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
		$model->tgl_akhir = date('Y-m-d');
		$model->bln_awal = date('Y-m', strtotime('first day of january'));
		$model->bln_akhir = date('Y-m');
		$model->thn_awal = date('Y');
		$model->thn_akhir = date('Y');
                $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
        $judulLaporan = 'Laporan Pemakai Obat Alkes Rawat Inap';
        $format = new MyFormatter();
        
         //Data Grafik
        $data['title'] = 'Grafik Laporan Pemakai Obat Alkes Rawat Inap';
        $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : null);
        
        if (isset($_REQUEST['RILaporanpemakaiobatalkesV'])) {
            $model->attributes = $_REQUEST['RILaporanpemakaiobatalkesV'];            
            $model->jns_periode = $_REQUEST['RILaporanpemakaiobatalkesV']['jns_periode'];
            $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['RILaporanpemakaiobatalkesV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['RILaporanpemakaiobatalkesV']['tgl_akhir']);
            $model->bln_awal = $format->formatMonthForDb($_REQUEST['RILaporanpemakaiobatalkesV']['bln_awal']);
            $model->bln_akhir = $format->formatMonthForDb($_REQUEST['RILaporanpemakaiobatalkesV']['bln_akhir']);
            $bln_akhir = $model->bln_akhir."-".date("t",strtotime($model->bln_akhir));
            $thn_akhir = $model->thn_akhir."-".date("m-t",strtotime($model->thn_akhir."-12"));
            switch($model->jns_periode){
                case 'bulan' : $model->tgl_awal = $model->bln_awal."-01"; $model->tgl_akhir = $bln_akhir; break;
                case 'tahun' : $model->tgl_awal = $model->thn_awal."-01-01"; $model->tgl_akhir = $thn_akhir; break;
                default : null;
            }
            $model->tgl_awal = $model->tgl_awal." 00:00:00";
            $model->tgl_akhir = $model->tgl_akhir." 23:59:59";
            $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
        }
        
        $caraPrint = (isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null);
        $target = 'pemakaiObatAlkes/_printPemakaiObatAlkes';
        
        $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
    }

    public function actionFrameGrafikLaporanPemakaiObatAlkes() {
        $this->layout = '//layouts/iframe';
        $model = new RILaporanpemakaiobatalkesV('searchGrafik');
        $format = new MyFormatter();
        $model->jns_periode = "hari";
        $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
        $model->tgl_akhir = date('Y-m-d');
        $model->bln_awal = date('Y-m', strtotime('first day of january'));
        $model->bln_akhir = date('Y-m');
        $model->thn_awal = date('Y');
        $model->thn_akhir = date('Y');
        $model->ruangan_id = Yii::app()->user->getState('ruangan_id');

        //Data Grafik
        $data['title'] = 'Grafik Laporan Pemakai Obat Alkes Rawat Inap';
        $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : null);
        if (isset($_GET['RILaporanpemakaiobatalkesV'])) {
            $model->attributes = $_GET['RILaporanpemakaiobatalkesV'];
            $model->jns_periode = $_GET['RILaporanpemakaiobatalkesV']['jns_periode'];
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['RILaporanpemakaiobatalkesV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['RILaporanpemakaiobatalkesV']['tgl_akhir']);
            $model->bln_awal = $format->formatMonthForDb($_GET['RILaporanpemakaiobatalkesV']['bln_awal']);
            $model->bln_akhir = $format->formatMonthForDb($_GET['RILaporanpemakaiobatalkesV']['bln_akhir']);
            $bln_akhir = $model->bln_akhir."-".date("t",strtotime($model->bln_akhir));
            $thn_akhir = $model->thn_akhir."-".date("m-t",strtotime($model->thn_akhir."-12"));
            switch($model->jns_periode){
                case 'bulan' : $model->tgl_awal = $model->bln_awal."-01"; $model->tgl_akhir = $bln_akhir; break;
                case 'tahun' : $model->tgl_awal = $model->thn_awal."-01-01"; $model->tgl_akhir = $thn_akhir; break;
                default : null;
            }
            $model->tgl_awal = $model->tgl_awal." 00:00:00";
            $model->tgl_akhir = $model->tgl_akhir." 23:59:59";
            $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
        }
                
        $this->render('_grafik', array(
            'model' => $model,
            'data' => $data,
        ));
    }
    
    public function actionLaporanJasaInstalasi()
    {
        $model = new RILaporanjasainstalasi('searchTable');        
        $model->unsetAttributes();
        $format = new MyFormatter();
        $model->jns_periode = "hari";
        $model->tgl_awal = date('Y-m-d');//, strtotime('first day of this month')
        $model->tgl_akhir = date('Y-m-d');
        $model->bln_awal = date('Y-m', strtotime('first day of january'));
        $model->bln_akhir = date('Y-m');
        $model->thn_awal = date('Y');
        $model->thn_akhir = date('Y');
        $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
        
        if (isset($_GET['RILaporanjasainstalasi'])) {
            $model->attributes = $_GET['RILaporanjasainstalasi'];
            $model->jns_periode = $_GET['RILaporanjasainstalasi']['jns_periode'];
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['RILaporanjasainstalasi']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['RILaporanjasainstalasi']['tgl_akhir']);
            $model->bln_awal = $format->formatMonthForDb($_GET['RILaporanjasainstalasi']['bln_awal']);
            $model->bln_akhir = $format->formatMonthForDb($_GET['RILaporanjasainstalasi']['bln_akhir']);
			$model->thn_awal = $_GET['RILaporanjasainstalasi']['thn_awal'];
			$model->thn_akhir = $_GET['RILaporanjasainstalasi']['thn_akhir'];
            $bln_akhir = $model->bln_akhir."-".date("t",strtotime($model->bln_akhir));
            $thn_akhir = $model->thn_akhir."-".date("m-t",strtotime($model->thn_akhir."-12"));
            switch($model->jns_periode){
                case 'bulan' : $model->tgl_awal = $model->bln_awal."-01"; $model->tgl_akhir = $bln_akhir; break;
                case 'tahun' : $model->tgl_awal = $model->thn_awal."-01-01"; $model->tgl_akhir = $thn_akhir; break;
                default : null;
            }
            $model->tgl_awal = $model->tgl_awal." 00:00:00";
            $model->tgl_akhir = $model->tgl_akhir." 23:59:59";
            $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
        }
        $this->render('jasaInstalasi/adminJasaInstalasi',array(
            'model'=>$model,'format'=>$format
        ));
    }
    
    public function actionPrintLaporanJasaInstalasi()
    {
        $model = new RILaporanjasainstalasi('searchTable');
        $judulLaporan = 'Laporan Jasa Instalasi Rawat Inap';
        $format = new MyFormatter();
        $model->jns_periode = "hari";
        $model->tgl_awal = date('Y-m-d');//, strtotime('first day of this month')
        $model->tgl_akhir = date('Y-m-d');
        $model->bln_awal = date('Y-m', strtotime('first day of january'));
        $model->bln_akhir = date('Y-m');
        $model->thn_awal = date('Y');
        $model->thn_akhir = date('Y');
        $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
        
        //Data Grafik
        $data['title'] = 'Grafik Laporan Jasa Instalasi';
        $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : null);
        if (isset($_REQUEST['RILaporanjasainstalasi'])) {
            $model->attributes = $_REQUEST['RILaporanjasainstalasi'];            
            $model->jns_periode = $_REQUEST['RILaporanjasainstalasi']['jns_periode'];
            $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['RILaporanjasainstalasi']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['RILaporanjasainstalasi']['tgl_akhir']);
            $model->bln_awal = $format->formatMonthForDb($_REQUEST['RILaporanjasainstalasi']['bln_awal']);
            $model->bln_akhir = $format->formatMonthForDb($_REQUEST['RILaporanjasainstalasi']['bln_akhir']);
            $bln_akhir = $model->bln_akhir."-".date("t",strtotime($model->bln_akhir));
            $thn_akhir = $model->thn_akhir."-".date("m-t",strtotime($model->thn_akhir."-12"));
            switch($model->jns_periode){
                case 'bulan' : $model->tgl_awal = $model->bln_awal."-01"; $model->tgl_akhir = $bln_akhir; break;
                case 'tahun' : $model->tgl_awal = $model->thn_awal."-01-01"; $model->tgl_akhir = $thn_akhir; break;
                default : null;
            }
            $model->tgl_awal = $model->tgl_awal." 00:00:00";
            $model->tgl_akhir = $model->tgl_akhir." 23:59:59";
            $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
        }
        $caraPrint = $_REQUEST['caraPrint'];
        $target = 'jasaInstalasi/_printJasaInstalasi';
        
        $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
    }

    public function actionFrameGrafikLaporanJasaInstalasi() {
        $this->layout = '//layouts/iframe';
        $model = new RILaporanjasainstalasi('searchGrafik');
        $format = new MyFormatter();
        $model->jns_periode = "hari";
        $model->tgl_awal = date('Y-m-d');//, strtotime('first day of this month')
        $model->tgl_akhir = date('Y-m-d');
        $model->bln_awal = date('Y-m', strtotime('first day of january'));
        $model->bln_akhir = date('Y-m');
        $model->thn_awal = date('Y');
        $model->thn_akhir = date('Y');
        $model->ruangan_id = Yii::app()->user->getState('ruangan_id');

        //Data Grafik
        $data['title'] = 'Grafik Laporan Jasa Instalasi Rawat Inap';
        $data['type'] = (isset($_GET['type']) ? $_GET['type'] : null);
        if (isset($_GET['RILaporanjasainstalasi'])) {
            $model->attributes = $_GET['RILaporanjasainstalasi'];
            $model->jns_periode = $_GET['RILaporanjasainstalasi']['jns_periode'];
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['RILaporanjasainstalasi']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['RILaporanjasainstalasi']['tgl_akhir']);
            $model->bln_awal = $format->formatMonthForDb($_GET['RILaporanjasainstalasi']['bln_awal']);
            $model->bln_akhir = $format->formatMonthForDb($_GET['RILaporanjasainstalasi']['bln_akhir']);
            $bln_akhir = $model->bln_akhir."-".date("t",strtotime($model->bln_akhir));
            $thn_akhir = $model->thn_akhir."-".date("m-t",strtotime($model->thn_akhir."-12"));
            switch($model->jns_periode){
                case 'bulan' : $model->tgl_awal = $model->bln_awal."-01"; $model->tgl_akhir = $bln_akhir; break;
                case 'tahun' : $model->tgl_awal = $model->thn_awal."-01-01"; $model->tgl_akhir = $thn_akhir; break;
                default : null;
            }
            $model->tgl_awal = $model->tgl_awal." 00:00:00";
            $model->tgl_akhir = $model->tgl_akhir." 23:59:59";
            $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
        }
                
        $this->render('_grafik', array(
            'model' => $model,
            'data' => $data,
        ));
    }
    
    /*
     * ======================== PEMBEBASAN TARIF ===============================
     */
    
    public function actionLaporanPembebasanTarif() {
        $model = new BKLaporanpembebasantarifV('search');
        $format = new MyFormatter();
        $model->jns_periode = "hari";
        $model->tgl_awal = date('Y-m-d');//, strtotime('first day of this month')
        $model->tgl_akhir = date('Y-m-d');
        $model->bln_awal = date('Y-m', strtotime('first day of january'));
        $model->bln_akhir = date('Y-m');
        $model->thn_awal = date('Y');
        $model->thn_akhir = date('Y');
        $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
        $filter = null;
        if (isset($_GET['BKLaporanpembebasantarifV'])) {
            $model->attributes = $_GET['BKLaporanpembebasantarifV'];
            $model->jns_periode = $_GET['BKLaporanpembebasantarifV']['jns_periode'];
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['BKLaporanpembebasantarifV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['BKLaporanpembebasantarifV']['tgl_akhir']);
            $model->bln_awal = $format->formatMonthForDb($_GET['BKLaporanpembebasantarifV']['bln_awal']);
            $model->bln_akhir = $format->formatMonthForDb($_GET['BKLaporanpembebasantarifV']['bln_akhir']);
            $bln_akhir = $model->bln_akhir."-".date("t",strtotime($model->bln_akhir));
            $thn_akhir = $model->thn_akhir."-".date("m-t",strtotime($model->thn_akhir."-12"));
            switch($model->jns_periode){
                case 'bulan' : $model->tgl_awal = $model->bln_awal."-01"; $model->tgl_akhir = $bln_akhir; break;
                case 'tahun' : $model->tgl_awal = $model->thn_awal."-01-01"; $model->tgl_akhir = $thn_akhir; break;
                default : null;
            }
            $model->tgl_awal = $model->tgl_awal." 00:00:00";
            $model->tgl_akhir = $model->tgl_akhir." 23:59:59";
            $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
        }

        $this->render('pembebasanTarif/index', array(
            'model' => $model, 'filter' => $filter
        ));
    }

    public function actionPrintLaporanPembebasanTarif() {
        $model = new BKLaporanpembebasantarifV('search');
        $format = new MyFormatter();
        $model->jns_periode = "hari";
        $model->tgl_awal = date('Y-m-d');//, strtotime('first day of this month')
        $model->tgl_akhir = date('Y-m-d');
        $model->bln_awal = date('Y-m', strtotime('first day of january'));
        $model->bln_akhir = date('Y-m');
        $model->thn_awal = date('Y');
        $model->thn_akhir = date('Y');
        $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
        $judulLaporan = 'Laporan Pembebasan Tarif';

        //Data Grafik
        $data['title'] = 'Grafik Laporan Pembebasan Tarif';
        $data['type'] = $_REQUEST['type'];
        $data['nama_pegawai'] = LoginpemakaiK::model()->findByPK(Yii::app()->user->id)->pegawai->nama_pegawai;
        if (isset($_REQUEST['BKLaporanpembebasantarifV'])) {
            $model->attributes = $_REQUEST['BKLaporanpembebasantarifV'];
            $model->jns_periode = $_REQUEST['BKLaporanpembebasantarifV']['jns_periode'];
            $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['BKLaporanpembebasantarifV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['BKLaporanpembebasantarifV']['tgl_akhir']);
            $model->bln_awal = $format->formatMonthForDb($_REQUEST['BKLaporanpembebasantarifV']['bln_awal']);
            $model->bln_akhir = $format->formatMonthForDb($_REQUEST['BKLaporanpembebasantarifV']['bln_akhir']);
            $bln_akhir = $model->bln_akhir."-".date("t",strtotime($model->bln_akhir));
            $thn_akhir = $model->thn_akhir."-".date("m-t",strtotime($model->thn_akhir."-12"));
            switch($model->jns_periode){
                case 'bulan' : $model->tgl_awal = $model->bln_awal."-01"; $model->tgl_akhir = $bln_akhir; break;
                case 'tahun' : $model->tgl_awal = $model->thn_awal."-01-01"; $model->tgl_akhir = $thn_akhir; break;
                default : null;
            }
            $model->tgl_awal = $model->tgl_awal." 00:00:00";
            $model->tgl_akhir = $model->tgl_akhir." 23:59:59";
            $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
        }

        $caraPrint = $_REQUEST['caraPrint'];
        $target = 'pembebasanTarif/_print';

        $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
    }


    public function actionFrameGrafikLaporanPembebasanTarif() {
        $this->layout = '//layouts/iframe';
        $model = new BKLaporanpembebasantarifV('search');
        $format = new MyFormatter();
        $model->jns_periode = "hari";
        $model->tgl_awal = date('Y-m-d');//, strtotime('first day of this month')
        $model->tgl_akhir = date('Y-m-d');
        $model->bln_awal = date('Y-m', strtotime('first day of january'));
        $model->bln_akhir = date('Y-m');
        $model->thn_awal = date('Y');
        $model->thn_akhir = date('Y');
        $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
        //Data Grafik
        $data['title'] = 'Grafik Laporan Pembebasan Tarif';
        $data['type'] = $_GET['type'];
        if (isset($_GET['BKLaporanpembebasantarifV'])) {
            $model->attributes = $_GET['BKLaporanpembebasantarifV'];
            $model->jns_periode = $_REQUEST['BKLaporanpembebasantarifV']['jns_periode'];
            $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['BKLaporanpembebasantarifV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['BKLaporanpembebasantarifV']['tgl_akhir']);
            $model->bln_awal = $format->formatMonthForDb($_REQUEST['BKLaporanpembebasantarifV']['bln_awal']);
            $model->bln_akhir = $format->formatMonthForDb($_REQUEST['BKLaporanpembebasantarifV']['bln_akhir']);
            $bln_akhir = $model->bln_akhir."-".date("t",strtotime($model->bln_akhir));
            $thn_akhir = $model->thn_akhir."-".date("m-t",strtotime($model->thn_akhir."-12"));
            switch($model->jns_periode){
                case 'bulan' : $model->tgl_awal = $model->bln_awal."-01"; $model->tgl_akhir = $bln_akhir; break;
                case 'tahun' : $model->tgl_awal = $model->thn_awal."-01-01"; $model->tgl_akhir = $thn_akhir; break;
                default : null;
            }
            $model->tgl_awal = $model->tgl_awal." 00:00:00";
            $model->tgl_akhir = $model->tgl_akhir." 23:59:59";
            $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
        }

        $this->render('_grafik', array(
            'model' => $model,
            'data' => $data,
        ));
    }
    
    /*
     * ======================== END PEMBEBASAN TARIF ===========================
     */
    
    protected function printFunction($model, $data, $caraPrint, $judulLaporan, $target){
        $format = new MyFormatter();
        $periode = $format->formatDateTimeForUser($model->tgl_awal).' s/d '.$format->formatDateTimeForUser($model->tgl_akhir);
        
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
            $mpdf->Output($judulLaporan.'-'.date('Y/m/d').'.pdf','I');
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
	
	public function actionGetPenjaminPasienForCheckBox($encode=false,$namaModel='')
    {
        if(Yii::app()->request->isAjaxRequest) {
           $carabayar_id = $_POST["$namaModel"]['carabayar_id'];

           if($encode) {
                echo CJSON::encode($penjamin);
           } else {
                if(empty($carabayar_id)){
//                    $penjamin = PenjaminpasienM::model()->findAll();
                    echo '<label>Data Tidak Ditemukan</label>';
                } else {
					$criteria = new CDbCriteria();
					$criteria->addCondition('carabayar_id = '.$carabayar_id);
					$criteria->addCondition('penjamin_aktif is true');
					$criteria->order = 'penjamin_nama ASC';
                    $penjamindata = PenjaminpasienM::model()->findAll($criteria);
                    $penjamin = CHtml::listData($penjamindata,'penjamin_id','penjamin_nama');
                    echo CHtml::hiddenField(''.$namaModel.'[penjamin_id]');
                    echo "<div style='margin-left:0px;'>".CHtml::checkBox('checkAllCaraBayar',true, array('onkeypress'=>"return $(this).focusNextInputField(event)",
                            'class'=>'checkbox-column','onclick'=>'checkAll()','checked'=>'checked'))." Pilih Semua";
                    echo "</div><br/>";
                    $i = 0;
                    if (count($penjamin) > 0){
                        foreach($penjamin as $value=>$name) {
                            echo '<label class="checkbox">';
                            echo CHtml::checkBox(''.$namaModel.'[penjamin_id][]', true, array('value'=>$value));
                            echo '<label for="'.$namaModel.'_penjamin_id_'.$i.'">'.$name.'</label></label>';

                            $i++;
                        }
                    } else{
                        echo '<label>Data Tidak Ditemukan</label>';
                    }
                }
           }
        }
        Yii::app()->end();
    }

//    public function actionLaporanKunjungan()
//    {
//        $model = new RILaporankunjunganriV('search');
//        $model->tgl_awal = date('Y-m-d H:i:s');
//        $model->tgl_akhir = date('Y-m-d H:i:s');
//
//        if (isset($_GET['RILaporankunjunganriV'])) {
//            $model->attributes = $_GET['RILaporankunjunganriV'];
//            $format = new MyFormatter();
//            $model->tgl_awal = $format->formatDateTimeForDb($_GET['RILaporankunjunganriV']['tgl_awal']);
//            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['RILaporankunjunganriV']['tgl_akhir']);
//        }
//
//
//        $this->render('kunjungan/adminKunjungan', array(
//            'model' => $model,
//        ));
//    }
    
}
?>
