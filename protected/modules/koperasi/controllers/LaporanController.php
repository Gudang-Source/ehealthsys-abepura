<?php

class LaporanController extends MyAuthController
{
	public $layout='//layouts/column1';
	
	public function actionKeanggotaan()
	{		
		$model = new KOLaporankeanggotaanV();
		$format = new MyFormatter();
                $model->unsetAttributes();
                $model->jns_periode = "hari";
                $model->tgl_awal = date('Y-m-d');
                $model->tgl_akhir = date('Y-m-d');
                $model->bln_awal = date('Y-m', strtotime('first day of january'));
                $model->bln_akhir = date('Y-m');
                $model->thn_awal = date('Y');
                $model->thn_akhir = date('Y');

		if (isset($_GET['KOLaporankeanggotaanV'])) {
			$model->attributes = $_GET['KOLaporankeanggotaanV'];
			$model->jns_periode = $_GET['KOLaporankeanggotaanV']['jns_periode'];
                        $model->tgl_awal = $format->formatDateTimeForDb($_GET['KOLaporankeanggotaanV']['tgl_awal']);
                        $model->tgl_akhir = $format->formatDateTimeForDb($_GET['KOLaporankeanggotaanV']['tgl_akhir']);
                        $model->bln_awal = $format->formatMonthForDb($_GET['KOLaporankeanggotaanV']['bln_awal']);
                        $model->bln_akhir = $format->formatMonthForDb($_GET['KOLaporankeanggotaanV']['bln_akhir']);
                        $model->thn_awal = $_GET['KOLaporankeanggotaanV']['thn_awal'];
                        $model->thn_akhir = $_GET['KOLaporankeanggotaanV']['thn_akhir'];
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
	$this->render('keanggotaan/index',array('model'=>$model,'format'=>$format));
	}

	public function actionPrintKeanggotaan()
	{
		//$this->layout = '//layouts/print';
		$model = new KOLaporankeanggotaanV();
		$format = new MyFormatter();
                $model->unsetAttributes();
                $model->jns_periode = "hari";
                $model->tgl_awal = date('Y-m-d');
                $model->tgl_akhir = date('Y-m-d');
                $model->bln_awal = date('Y-m');
                $model->bln_akhir = date('Y-m');
                $model->thn_awal = date('Y');
                $model->thn_akhir = date('Y');
                $judulLaporan = 'Laporan Keanggotaan';

                $data['title'] = 'Grafik Laporan Keanggotaan';
                $data['type'] = $_REQUEST['type'];
		if (isset($_GET['KOLaporankeanggotaanV'])) {
			$model->attributes = $_GET['KOLaporankeanggotaanV'];
			$model->jns_periode = $_GET['KOLaporankeanggotaanV']['jns_periode'];
                        $model->tgl_awal = $format->formatDateTimeForDb($_GET['KOLaporankeanggotaanV']['tgl_awal']);
                        $model->tgl_akhir = $format->formatDateTimeForDb($_GET['KOLaporankeanggotaanV']['tgl_akhir']);
                        $model->bln_awal = $format->formatMonthForDb($_GET['KOLaporankeanggotaanV']['bln_awal']);
                        $model->bln_akhir = $format->formatMonthForDb($_GET['KOLaporankeanggotaanV']['bln_akhir']);
                        $model->thn_awal = $_GET['KOLaporankeanggotaanV']['thn_awal'];
                        $model->thn_akhir = $_GET['KOLaporankeanggotaanV']['thn_akhir'];
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
                $target = 'keanggotaan/_print';

                $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
        }
        
	public function actionFrameGrafikKeanggotaan() {
        $this->layout = '//layouts/iframe';
        $model = new KOLaporankeanggotaanV();
        $format = new MyFormatter();
        $model->unsetAttributes();
        $model->jns_periode = "hari";
        $model->tgl_awal = date('Y-m-d');
        $model->tgl_akhir = date('Y-m-d');
        $model->bln_awal = date('Y-m');
        $model->bln_akhir = date('Y-m');
        $model->thn_awal = date('Y');
        $model->thn_akhir = date('Y');

        //Data Grafik
        $data['title'] = 'Grafik Laporan Keanggotaan';
        $data['type'] = (isset($_GET['type']) ? $_GET['type'] : null);
        
        
        
        if (isset($_GET['KOLaporankeanggotaanV'])) {
            $model->attributes = $_GET['KOLaporankeanggotaanV'];
            $model->jns_periode = $_GET['KOLaporankeanggotaanV']['jns_periode'];
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['KOLaporankeanggotaanV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['KOLaporankeanggotaanV']['tgl_akhir']);
            $model->bln_awal = $format->formatMonthForDb($_GET['KOLaporankeanggotaanV']['bln_awal']);
            $model->bln_akhir = $format->formatMonthForDb($_GET['KOLaporankeanggotaanV']['bln_akhir']);
            $model->thn_awal = $_GET['KOLaporankeanggotaanV']['thn_awal'];
            $model->thn_akhir = $_GET['KOLaporankeanggotaanV']['thn_akhir'];
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
    
    public function actionSimpananAnggota()
	{		
		$model = new KOLaporansimpananV();
		$format = new MyFormatter();
                $model->unsetAttributes();
                $model->jns_periode = "hari";
                $model->tgl_awal = date('Y-m-d');
                $model->tgl_akhir = date('Y-m-d');
                $model->bln_awal = date('Y-m', strtotime('first day of january'));
                $model->bln_akhir = date('Y-m');
                $model->thn_awal = date('Y');
                $model->thn_akhir = date('Y');

		if (isset($_GET['KOLaporansimpananV'])) {
			$model->attributes = $_GET['KOLaporansimpananV'];
			$model->jns_periode = $_GET['KOLaporansimpananV']['jns_periode'];
                        $model->tgl_awal = $format->formatDateTimeForDb($_GET['KOLaporansimpananV']['tgl_awal']);
                        $model->tgl_akhir = $format->formatDateTimeForDb($_GET['KOLaporansimpananV']['tgl_akhir']);
                        $model->bln_awal = $format->formatMonthForDb($_GET['KOLaporansimpananV']['bln_awal']);
                        $model->bln_akhir = $format->formatMonthForDb($_GET['KOLaporansimpananV']['bln_akhir']);
                        $model->thn_awal = $_GET['KOLaporansimpananV']['thn_awal'];
                        $model->thn_akhir = $_GET['KOLaporansimpananV']['thn_akhir'];
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
	$this->render('simpananAnggota/index',array('model'=>$model,'format'=>$format));
	}

	public function actionPrintSimpananAnggota()
	{
		//$this->layout = '//layouts/print';
		$model = new KOLaporansimpananV();
		$format = new MyFormatter();
                $model->unsetAttributes();
                $model->jns_periode = "hari";
                $model->tgl_awal = date('Y-m-d');
                $model->tgl_akhir = date('Y-m-d');
                $model->bln_awal = date('Y-m');
                $model->bln_akhir = date('Y-m');
                $model->thn_awal = date('Y');
                $model->thn_akhir = date('Y');
                $judulLaporan = 'Laporan Simpanan Anggota';

                $data['title'] = 'Grafik Laporan Simpanan Anggota';
                $data['type'] = $_REQUEST['type'];
		if (isset($_GET['KOLaporansimpananV'])) {
			$model->attributes = $_GET['KOLaporansimpananV'];
			$model->jns_periode = $_GET['KOLaporansimpananV']['jns_periode'];
                        $model->tgl_awal = $format->formatDateTimeForDb($_GET['KOLaporansimpananV']['tgl_awal']);
                        $model->tgl_akhir = $format->formatDateTimeForDb($_GET['KOLaporansimpananV']['tgl_akhir']);
                        $model->bln_awal = $format->formatMonthForDb($_GET['KOLaporansimpananV']['bln_awal']);
                        $model->bln_akhir = $format->formatMonthForDb($_GET['KOLaporansimpananV']['bln_akhir']);
                        $model->thn_awal = $_GET['KOLaporansimpananV']['thn_awal'];
                        $model->thn_akhir = $_GET['KOLaporansimpananV']['thn_akhir'];
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
                $target = 'simpananAnggota/_print';

                $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
        }
        
	public function actionFrameGrafikSimpananAnggota() {
        $this->layout = '//layouts/iframe';
        $model = new KOLaporansimpananV();
        $format = new MyFormatter();
        $model->unsetAttributes();
        $model->jns_periode = "hari";
        $model->tgl_awal = date('Y-m-d');
        $model->tgl_akhir = date('Y-m-d');
        $model->bln_awal = date('Y-m');
        $model->bln_akhir = date('Y-m');
        $model->thn_awal = date('Y');
        $model->thn_akhir = date('Y');

        //Data Grafik
        $data['title'] = 'Grafik Laporan Simpanan Anggota';
        $data['type'] = (isset($_GET['type']) ? $_GET['type'] : null);
                        
        if (isset($_GET['KOLaporansimpananV'])) {
            $model->attributes = $_GET['KOLaporansimpananV'];
            $model->jns_periode = $_GET['KOLaporansimpananV']['jns_periode'];
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['KOLaporansimpananV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['KOLaporansimpananV']['tgl_akhir']);
            $model->bln_awal = $format->formatMonthForDb($_GET['KOLaporansimpananV']['bln_awal']);
            $model->bln_akhir = $format->formatMonthForDb($_GET['KOLaporansimpananV']['bln_akhir']);
            $model->thn_awal = $_GET['KOLaporansimpananV']['thn_awal'];
            $model->thn_akhir = $_GET['KOLaporansimpananV']['thn_akhir'];
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
    
    public function actionPinjamanAnggota()
	{		
		$model = new KOLaporanpinjamanV();
		$format = new MyFormatter();
                $model->unsetAttributes();
                $model->jns_periode = "hari";
                $model->tgl_awal = date('Y-m-d');
                $model->tgl_akhir = date('Y-m-d');
                $model->bln_awal = date('Y-m', strtotime('first day of january'));
                $model->bln_akhir = date('Y-m');
                $model->thn_awal = date('Y');
                $model->thn_akhir = date('Y');

		if (isset($_GET['KOLaporanpinjamanV'])) {
			$model->attributes = $_GET['KOLaporanpinjamanV'];
			$model->jns_periode = $_GET['KOLaporanpinjamanV']['jns_periode'];
                        $model->tgl_awal = $format->formatDateTimeForDb($_GET['KOLaporanpinjamanV']['tgl_awal']);
                        $model->tgl_akhir = $format->formatDateTimeForDb($_GET['KOLaporanpinjamanV']['tgl_akhir']);
                        $model->bln_awal = $format->formatMonthForDb($_GET['KOLaporanpinjamanV']['bln_awal']);
                        $model->bln_akhir = $format->formatMonthForDb($_GET['KOLaporanpinjamanV']['bln_akhir']);
                        $model->thn_awal = $_GET['KOLaporanpinjamanV']['thn_awal'];
                        $model->thn_akhir = $_GET['KOLaporanpinjamanV']['thn_akhir'];
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
	$this->render('pinjamanAnggota/index',array('model'=>$model,'format'=>$format));
	}

	public function actionPrintPinjamanAnggota()
	{
		//$this->layout = '//layouts/print';
		$model = new KOLaporanpinjamanV();
		$format = new MyFormatter();
                $model->unsetAttributes();
                $model->jns_periode = "hari";
                $model->tgl_awal = date('Y-m-d');
                $model->tgl_akhir = date('Y-m-d');
                $model->bln_awal = date('Y-m');
                $model->bln_akhir = date('Y-m');
                $model->thn_awal = date('Y');
                $model->thn_akhir = date('Y');
                $judulLaporan = 'Laporan Pinjaman Anggota';

                $data['title'] = 'Grafik Laporan Pinjaman Anggota';
                $data['type'] = $_REQUEST['type'];
		if (isset($_GET['KOLaporanpinjamanV'])) {
			$model->attributes = $_GET['KOLaporanpinjamanV'];
			$model->jns_periode = $_GET['KOLaporanpinjamanV']['jns_periode'];
                        $model->tgl_awal = $format->formatDateTimeForDb($_GET['KOLaporanpinjamanV']['tgl_awal']);
                        $model->tgl_akhir = $format->formatDateTimeForDb($_GET['KOLaporanpinjamanV']['tgl_akhir']);
                        $model->bln_awal = $format->formatMonthForDb($_GET['KOLaporanpinjamanV']['bln_awal']);
                        $model->bln_akhir = $format->formatMonthForDb($_GET['KOLaporanpinjamanV']['bln_akhir']);
                        $model->thn_awal = $_GET['KOLaporanpinjamanV']['thn_awal'];
                        $model->thn_akhir = $_GET['KOLaporanpinjamanV']['thn_akhir'];
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
                $target = 'simpananAnggota/_print';

                $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
        }
        
	public function actionFrameGrafikPinjamanAnggota() {
        $this->layout = '//layouts/iframe';
        $model = new KOLaporanpinjamanV();
        $format = new MyFormatter();
        $model->unsetAttributes();
        $model->jns_periode = "hari";
        $model->tgl_awal = date('Y-m-d');
        $model->tgl_akhir = date('Y-m-d');
        $model->bln_awal = date('Y-m');
        $model->bln_akhir = date('Y-m');
        $model->thn_awal = date('Y');
        $model->thn_akhir = date('Y');

        //Data Grafik
        $data['title'] = 'Grafik Laporan Pinjaman Anggota';
        $data['type'] = (isset($_GET['type']) ? $_GET['type'] : null);
                        
        if (isset($_GET['KOLaporanpinjamanV'])) {
            $model->attributes = $_GET['KOLaporanpinjamanV'];
            $model->jns_periode = $_GET['KOLaporanpinjamanV']['jns_periode'];
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['KOLaporanpinjamanV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['KOLaporanpinjamanV']['tgl_akhir']);
            $model->bln_awal = $format->formatMonthForDb($_GET['KOLaporanpinjamanV']['bln_awal']);
            $model->bln_akhir = $format->formatMonthForDb($_GET['KOLaporanpinjamanV']['bln_akhir']);
            $model->thn_awal = $_GET['KOLaporanpinjamanV']['thn_awal'];
            $model->thn_akhir = $_GET['KOLaporanpinjamanV']['thn_akhir'];
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
    
    public function actionAngsuranPinjamanAnggota()
	{		
		$model = new KOLaporanangsuranV();
		$format = new MyFormatter();
                $model->unsetAttributes();
                $model->jns_periode = "hari";
                $model->tgl_awal = date('Y-m-d');
                $model->tgl_akhir = date('Y-m-d');
                $model->bln_awal = date('Y-m', strtotime('first day of january'));
                $model->bln_akhir = date('Y-m');
                $model->thn_awal = date('Y');
                $model->thn_akhir = date('Y');

		if (isset($_GET['KOLaporanangsuranV'])) {
			$model->attributes = $_GET['KOLaporanangsuranV'];
			$model->jns_periode = $_GET['KOLaporanangsuranV']['jns_periode'];
                        $model->tgl_awal = $format->formatDateTimeForDb($_GET['KOLaporanangsuranV']['tgl_awal']);
                        $model->tgl_akhir = $format->formatDateTimeForDb($_GET['KOLaporanangsuranV']['tgl_akhir']);
                        $model->bln_awal = $format->formatMonthForDb($_GET['KOLaporanangsuranV']['bln_awal']);
                        $model->bln_akhir = $format->formatMonthForDb($_GET['KOLaporanangsuranV']['bln_akhir']);
                        $model->thn_awal = $_GET['KOLaporanangsuranV']['thn_awal'];
                        $model->thn_akhir = $_GET['KOLaporanangsuranV']['thn_akhir'];
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
	$this->render('angsuranPinjamanAnggota/index',array('model'=>$model,'format'=>$format));
	}

	public function actionPrintAngsuranPinjamanAnggota()
	{
		//$this->layout = '//layouts/print';
		$model = new KOLaporanangsuranV();
		$format = new MyFormatter();
                $model->unsetAttributes();
                $model->jns_periode = "hari";
                $model->tgl_awal = date('Y-m-d');
                $model->tgl_akhir = date('Y-m-d');
                $model->bln_awal = date('Y-m');
                $model->bln_akhir = date('Y-m');
                $model->thn_awal = date('Y');
                $model->thn_akhir = date('Y');
                $judulLaporan = 'Laporan Angsuran Pinjaman Anggota';

                $data['title'] = 'Grafik Laporan Angsuran Pinjaman Anggota';
                $data['type'] = $_REQUEST['type'];
		if (isset($_GET['KOLaporanangsuranV'])) {
			$model->attributes = $_GET['KOLaporanangsuranV'];
			$model->jns_periode = $_GET['KOLaporanangsuranV']['jns_periode'];
                        $model->tgl_awal = $format->formatDateTimeForDb($_GET['KOLaporanangsuranV']['tgl_awal']);
                        $model->tgl_akhir = $format->formatDateTimeForDb($_GET['KOLaporanangsuranV']['tgl_akhir']);
                        $model->bln_awal = $format->formatMonthForDb($_GET['KOLaporanangsuranV']['bln_awal']);
                        $model->bln_akhir = $format->formatMonthForDb($_GET['KOLaporanangsuranV']['bln_akhir']);
                        $model->thn_awal = $_GET['KOLaporanangsuranV']['thn_awal'];
                        $model->thn_akhir = $_GET['KOLaporanangsuranV']['thn_akhir'];
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
                $target = 'angsuranPinjamanAnggota/_print';

                $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
        }
        
	public function actionFrameGrafikAngsuranPinjamanAnggota() {
        $this->layout = '//layouts/iframe';
        $model = new KOLaporanangsuranV();
        $format = new MyFormatter();
        $model->unsetAttributes();
        $model->jns_periode = "hari";
        $model->tgl_awal = date('Y-m-d');
        $model->tgl_akhir = date('Y-m-d');
        $model->bln_awal = date('Y-m');
        $model->bln_akhir = date('Y-m');
        $model->thn_awal = date('Y');
        $model->thn_akhir = date('Y');

        //Data Grafik
        $data['title'] = 'Grafik Laporan Angsuran Pinjaman Anggota';
        $data['type'] = (isset($_GET['type']) ? $_GET['type'] : null);
                        
        if (isset($_GET['KOLaporanangsuranV'])) {//angsuan
            $model->attributes = $_GET['KOLaporanangsuranV'];
            $model->jns_periode = $_GET['KOLaporanangsuranV']['jns_periode'];
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['KOLaporanangsuranV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['KOLaporanangsuranV']['tgl_akhir']);
            $model->bln_awal = $format->formatMonthForDb($_GET['KOLaporanangsuranV']['bln_awal']);
            $model->bln_akhir = $format->formatMonthForDb($_GET['KOLaporanangsuranV']['bln_akhir']);
            $model->thn_awal = $_GET['KOLaporanangsuranV']['thn_awal'];
            $model->thn_akhir = $_GET['KOLaporanangsuranV']['thn_akhir'];
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
    
    public function actionPotonganPinjamanAnggota()
	{		
		$model = new KOLaporanpotonganV();
		$format = new MyFormatter();
                $model->unsetAttributes();
                $model->jns_periode = "hari";
                $model->tgl_awal = date('Y-m-d');
                $model->tgl_akhir = date('Y-m-d');
                $model->bln_awal = date('Y-m', strtotime('first day of january'));
                $model->bln_akhir = date('Y-m');
                $model->thn_awal = date('Y');
                $model->thn_akhir = date('Y');

		if (isset($_GET['KOLaporanpotonganV'])) {
			$model->attributes = $_GET['KOLaporanpotonganV'];
			$model->jns_periode = $_GET['KOLaporanpotonganV']['jns_periode'];
                        $model->tgl_awal = $format->formatDateTimeForDb($_GET['KOLaporanpotonganV']['tgl_awal']);
                        $model->tgl_akhir = $format->formatDateTimeForDb($_GET['KOLaporanpotonganV']['tgl_akhir']);
                        $model->bln_awal = $format->formatMonthForDb($_GET['KOLaporanpotonganV']['bln_awal']);
                        $model->bln_akhir = $format->formatMonthForDb($_GET['KOLaporanpotonganV']['bln_akhir']);
                        $model->thn_awal = $_GET['KOLaporanpotonganV']['thn_awal'];
                        $model->thn_akhir = $_GET['KOLaporanpotonganV']['thn_akhir'];
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
	$this->render('potonganPinjamanAnggota/index',array('model'=>$model,'format'=>$format));
	}

	public function actionPrintPotonganPinjamanAnggota()
	{
		//$this->layout = '//layouts/print';
		$model = new KOLaporanpotonganV();
		$format = new MyFormatter();
                $model->unsetAttributes();
                $model->jns_periode = "hari";
                $model->tgl_awal = date('Y-m-d');
                $model->tgl_akhir = date('Y-m-d');
                $model->bln_awal = date('Y-m');
                $model->bln_akhir = date('Y-m');
                $model->thn_awal = date('Y');
                $model->thn_akhir = date('Y');
                $judulLaporan = 'Laporan Potongan Pinjaman Anggota';

                $data['title'] = 'Grafik Laporan Potongan Pinjaman Anggota';
                $data['type'] = $_REQUEST['type'];
		if (isset($_GET['KOLaporanpotonganV'])) {
			$model->attributes = $_GET['KOLaporanpotonganV'];
			$model->jns_periode = $_GET['KOLaporanpotonganV']['jns_periode'];
                        $model->tgl_awal = $format->formatDateTimeForDb($_GET['KOLaporanpotonganV']['tgl_awal']);
                        $model->tgl_akhir = $format->formatDateTimeForDb($_GET['KOLaporanpotonganV']['tgl_akhir']);
                        $model->bln_awal = $format->formatMonthForDb($_GET['KOLaporanpotonganV']['bln_awal']);
                        $model->bln_akhir = $format->formatMonthForDb($_GET['KOLaporanpotonganV']['bln_akhir']);
                        $model->thn_awal = $_GET['KOLaporanpotonganV']['thn_awal'];
                        $model->thn_akhir = $_GET['KOLaporanpotonganV']['thn_akhir'];
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
                $target = 'potonganPinjamanAnggota/_print';

                $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
        }
        
	public function actionFrameGrafikPotonganPinjamanAnggota() {
        $this->layout = '//layouts/iframe';
        $model = new KOLaporanpotonganV();
        $format = new MyFormatter();
        $model->unsetAttributes();
        $model->jns_periode = "hari";
        $model->tgl_awal = date('Y-m-d');
        $model->tgl_akhir = date('Y-m-d');
        $model->bln_awal = date('Y-m');
        $model->bln_akhir = date('Y-m');
        $model->thn_awal = date('Y');
        $model->thn_akhir = date('Y');

        //Data Grafik
        $data['title'] = 'Grafik Laporan Potongan Pinjaman Anggota';
        $data['type'] = (isset($_GET['type']) ? $_GET['type'] : null);
                        
        if (isset($_GET['KOLaporanpotonganV'])) {//angsuan
            $model->attributes = $_GET['KOLaporanpotonganV'];
            $model->jns_periode = $_GET['KOLaporanpotonganV']['jns_periode'];
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['KOLaporanpotonganV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['KOLaporanpotonganV']['tgl_akhir']);
            $model->bln_awal = $format->formatMonthForDb($_GET['KOLaporanpotonganV']['bln_awal']);
            $model->bln_akhir = $format->formatMonthForDb($_GET['KOLaporanpotonganV']['bln_akhir']);
            $model->thn_awal = $_GET['KOLaporanpotonganV']['thn_awal'];
            $model->thn_akhir = $_GET['KOLaporanpotonganV']['thn_akhir'];
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
    
    public function actionPenerimaanKas()
	{		
		$model = new KOLaporankasmasukkopV();
		$format = new MyFormatter();
                $model->unsetAttributes();
                $model->jns_periode = "hari";
                $model->tgl_awal = date('Y-m-d');
                $model->tgl_akhir = date('Y-m-d');
                $model->bln_awal = date('Y-m');
                $model->bln_akhir = date('Y-m');
                $model->thn_awal = date('Y');
                $model->thn_akhir = date('Y');

		if (isset($_GET['KOLaporankasmasukkopV'])) {
			$model->attributes = $_GET['KOLaporankasmasukkopV'];
			$model->jns_periode = $_GET['KOLaporankasmasukkopV']['jns_periode'];
                        $model->tgl_awal = $format->formatDateTimeForDb($_GET['KOLaporankasmasukkopV']['tgl_awal']);
                        $model->tgl_akhir = $format->formatDateTimeForDb($_GET['KOLaporankasmasukkopV']['tgl_akhir']);
                        $model->bln_awal = $format->formatMonthForDb($_GET['KOLaporankasmasukkopV']['bln_awal']);
                        $model->bln_akhir = $format->formatMonthForDb($_GET['KOLaporankasmasukkopV']['bln_akhir']);
                        $model->thn_awal = $_GET['KOLaporankasmasukkopV']['thn_awal'];
                        $model->thn_akhir = $_GET['KOLaporankasmasukkopV']['thn_akhir'];
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
	$this->render('penerimaanKas/index',array('model'=>$model,'format'=>$format));
	}

	public function actionPrintPenerimaanKas()
	{
		//$this->layout = '//layouts/print';
		$model = new KOLaporankasmasukkopV();
		$format = new MyFormatter();
                $model->unsetAttributes();
                $model->jns_periode = "hari";
                $model->tgl_awal = date('Y-m-d');
                $model->tgl_akhir = date('Y-m-d');
                $model->bln_awal = date('Y-m');
                $model->bln_akhir = date('Y-m');
                $model->thn_awal = date('Y');
                $model->thn_akhir = date('Y');
                $judulLaporan = 'Laporan Penerimaan Kas';

                $data['title'] = 'Grafik Laporan Penerimaan Kas';
                $data['type'] = $_REQUEST['type'];
		if (isset($_GET['KOLaporankasmasukkopV'])) {
			$model->attributes = $_GET['KOLaporankasmasukkopV'];
			$model->jns_periode = $_GET['KOLaporankasmasukkopV']['jns_periode'];
                        $model->tgl_awal = $format->formatDateTimeForDb($_GET['KOLaporankasmasukkopV']['tgl_awal']);
                        $model->tgl_akhir = $format->formatDateTimeForDb($_GET['KOLaporankasmasukkopV']['tgl_akhir']);
                        $model->bln_awal = $format->formatMonthForDb($_GET['KOLaporankasmasukkopV']['bln_awal']);
                        $model->bln_akhir = $format->formatMonthForDb($_GET['KOLaporankasmasukkopV']['bln_akhir']);
                        $model->thn_awal = $_GET['KOLaporankasmasukkopV']['thn_awal'];
                        $model->thn_akhir = $_GET['KOLaporankasmasukkopV']['thn_akhir'];
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
                $target = 'penerimaanKas/_print';

                $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
        }
        
	public function actionFrameGrafikPenerimaanKas() {
        $this->layout = '//layouts/iframe';
        $model = new KOLaporankasmasukkopV();
        $format = new MyFormatter();
        $model->unsetAttributes();
        $model->jns_periode = "hari";
        $model->tgl_awal = date('Y-m-d');
        $model->tgl_akhir = date('Y-m-d');
        $model->bln_awal = date('Y-m');
        $model->bln_akhir = date('Y-m');
        $model->thn_awal = date('Y');
        $model->thn_akhir = date('Y');

        //Data Grafik
        $data['title'] = 'Grafik Laporan Penerimaan Kas';
        $data['type'] = (isset($_GET['type']) ? $_GET['type'] : null);
                        
        if (isset($_GET['KOLaporankasmasukkopV'])) {//angsuan
            $model->attributes = $_GET['KOLaporankasmasukkopV'];
            $model->jns_periode = $_GET['KOLaporankasmasukkopV']['jns_periode'];
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['KOLaporankasmasukkopV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['KOLaporankasmasukkopV']['tgl_akhir']);
            $model->bln_awal = $format->formatMonthForDb($_GET['KOLaporankasmasukkopV']['bln_awal']);
            $model->bln_akhir = $format->formatMonthForDb($_GET['KOLaporankasmasukkopV']['bln_akhir']);
            $model->thn_awal = $_GET['KOLaporankasmasukkopV']['thn_awal'];
            $model->thn_akhir = $_GET['KOLaporankasmasukkopV']['thn_akhir'];
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
    
    public function actionPengeluaraanKas()
	{		
		$model = new KOLaporankaskeluarkopV();
		$format = new MyFormatter();
                $model->unsetAttributes();
                $model->jns_periode = "hari";
                $model->tgl_awal = date('Y-m-d');
                $model->tgl_akhir = date('Y-m-d');
                $model->bln_awal = date('Y-m');
                $model->bln_akhir = date('Y-m');
                $model->thn_awal = date('Y');
                $model->thn_akhir = date('Y');

		if (isset($_GET['KOLaporankaskeluarkopV'])) {
			$model->attributes = $_GET['KOLaporankaskeluarkopV'];
			$model->jns_periode = $_GET['KOLaporankaskeluarkopV']['jns_periode'];
                        $model->tgl_awal = $format->formatDateTimeForDb($_GET['KOLaporankaskeluarkopV']['tgl_awal']);
                        $model->tgl_akhir = $format->formatDateTimeForDb($_GET['KOLaporankaskeluarkopV']['tgl_akhir']);
                        $model->bln_awal = $format->formatMonthForDb($_GET['KOLaporankaskeluarkopV']['bln_awal']);
                        $model->bln_akhir = $format->formatMonthForDb($_GET['KOLaporankaskeluarkopV']['bln_akhir']);
                        $model->thn_awal = $_GET['KOLaporankaskeluarkopV']['thn_awal'];
                        $model->thn_akhir = $_GET['KOLaporankaskeluarkopV']['thn_akhir'];
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
	$this->render('pengeluaranKas/index',array('model'=>$model,'format'=>$format));
	}

	public function actionPrintPengeluaranKas()
	{
		//$this->layout = '//layouts/print';
		$model = new KOLaporankaskeluarkopV();
		$format = new MyFormatter();
                $model->unsetAttributes();
                $model->jns_periode = "hari";
                $model->tgl_awal = date('Y-m-d');
                $model->tgl_akhir = date('Y-m-d');
                $model->bln_awal = date('Y-m');
                $model->bln_akhir = date('Y-m');
                $model->thn_awal = date('Y');
                $model->thn_akhir = date('Y');
                $judulLaporan = 'Laporan Pengeluaraan Kas';

                $data['title'] = 'Grafik Laporan Pengeluaraan Kas';
                $data['type'] = $_REQUEST['type'];
		if (isset($_GET['KOLaporankaskeluarkopV'])) {
			$model->attributes = $_GET['KOLaporankaskeluarkopV'];
			$model->jns_periode = $_GET['KOLaporankaskeluarkopV']['jns_periode'];
                        $model->tgl_awal = $format->formatDateTimeForDb($_GET['KOLaporankaskeluarkopV']['tgl_awal']);
                        $model->tgl_akhir = $format->formatDateTimeForDb($_GET['KOLaporankaskeluarkopV']['tgl_akhir']);
                        $model->bln_awal = $format->formatMonthForDb($_GET['KOLaporankaskeluarkopV']['bln_awal']);
                        $model->bln_akhir = $format->formatMonthForDb($_GET['KOLaporankaskeluarkopV']['bln_akhir']);
                        $model->thn_awal = $_GET['KOLaporankaskeluarkopV']['thn_awal'];
                        $model->thn_akhir = $_GET['KOLaporankaskeluarkopV']['thn_akhir'];
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
                $target = 'pengeluaranKas/_print';

                $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
        }
        
	public function actionFrameGrafikPengeluaranKas() {
        $this->layout = '//layouts/iframe';
        $model = new KOLaporankaskeluarkopV();
        $format = new MyFormatter();
        $model->unsetAttributes();
        $model->jns_periode = "hari";
        $model->tgl_awal = date('Y-m-d');
        $model->tgl_akhir = date('Y-m-d');
        $model->bln_awal = date('Y-m');
        $model->bln_akhir = date('Y-m');
        $model->thn_awal = date('Y');
        $model->thn_akhir = date('Y');

        //Data Grafik
        $data['title'] = 'Grafik Laporan Pengeluaraan Kas';
        $data['type'] = (isset($_GET['type']) ? $_GET['type'] : null);
                        
        if (isset($_GET['KOLaporankaskeluarkopV'])) {//angsuan
            $model->attributes = $_GET['KOLaporankaskeluarkopV'];
            $model->jns_periode = $_GET['KOLaporankaskeluarkopV']['jns_periode'];
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['KOLaporankaskeluarkopV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['KOLaporankaskeluarkopV']['tgl_akhir']);
            $model->bln_awal = $format->formatMonthForDb($_GET['KOLaporankaskeluarkopV']['bln_awal']);
            $model->bln_akhir = $format->formatMonthForDb($_GET['KOLaporankaskeluarkopV']['bln_akhir']);
            $model->thn_awal = $_GET['KOLaporankaskeluarkopV']['thn_awal'];
            $model->thn_akhir = $_GET['KOLaporankaskeluarkopV']['thn_akhir'];
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
            $mpdf->Output($judulLaporan.'_'.date('Y-m-d').'.pdf','I');
        }
    }
}
