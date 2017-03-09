<?php

class LaporanController extends MyAuthController
{
    public $layout='//layouts/column1';
    public $defaultAction ='PembelianBarang';
    public function actionIndex()
    {
            $this->render('index');
    }
    
    /* START LAPORAN PENERIMAAN BAHAN MAKANAN  */
    public function actionLaporanBahanPenerimaanMakanan() {
        $model = new GULaporanpenerimaanbhnmakananV('search');
        $format = new MyFormatter();
        $model->unsetAttributes();
        $model->jns_periode = "hari";
        $model->tgl_awal = date('Y-m-d');
        $model->tgl_akhir = date('Y-m-d');
        $model->bln_awal = date('Y-m', strtotime('first day of january'));
        $model->bln_akhir = date('Y-m');
        $model->thn_awal = date('Y');
        $model->thn_akhir = date('Y');
        $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
        
        if (isset($_GET['GULaporanpenerimaanbhnmakananV'])) {
            $model->attributes = $_GET['GULaporanpenerimaanbhnmakananV'];
            $model->jns_periode = $_GET['GULaporanpenerimaanbhnmakananV']['jns_periode'];
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['GULaporanpenerimaanbhnmakananV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['GULaporanpenerimaanbhnmakananV']['tgl_akhir']);
            $model->bln_awal = $format->formatMonthForDb($_GET['GULaporanpenerimaanbhnmakananV']['bln_awal']);
            $model->bln_akhir = $format->formatMonthForDb($_GET['GULaporanpenerimaanbhnmakananV']['bln_akhir']);
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
        $searchData = $model->searchGrafik();
        $this->render('terimaBahanMak/admin', array(
            'model' => $model, 'format'=>$format, 'searchdata'=>$searchData
        ));
    }

    public function actionPrintLaporanBahanPenerimaanMakanan() {
        $model = new GULaporanpenerimaanbhnmakananV('search');
        $judulLaporan = 'Laporan Penerimaan Bahan Makanan';        
        $model->unsetAttributes();
        $format = new MyFormatter();
        $model->jns_periode = "hari";
        $model->tgl_awal = date('Y-m-d');
        $model->tgl_akhir = date('Y-m-d');
        $model->bln_awal = date('Y-m', strtotime('first day of january'));
        $model->bln_akhir = date('Y-m');
        $model->thn_awal = date('Y');
        $model->thn_akhir = date('Y');
        $model->ruangan_id = Yii::app()->user->getState('ruangan_id');

        //Data Grafik
        $berdasarkan = 'Berdasarkan Supplier';
        if (isset($_GET['filter']))
        {
            $berdasarkan = 'Berdasarkan Supplier';           
        }
        if (isset($_GET['filter1']))
        {
            $berdasarkan = 'Berdasarkan Golongan Bahan Makanan';           
        }
        if (isset($_GET['filter2']))
        {
            $berdasarkan = 'Berdasarkan Jenis Bahan Makanan';           
        }
        if (isset($_GET['filter3']))
        {
            $berdasarkan = 'Berdasarkan Kelompok Bahan Makanan';           
        }
        
        $data['title'] = 'Grafik Laporan Penerimaan Bahan Makanan '.$berdasarkan;
        $data['type'] = (isset($_GET['type']) ? $_GET['type'] : "");

        if (isset($_REQUEST['GULaporanpenerimaanbhnmakananV'])) {
            $model->attributes = $_REQUEST['GULaporanpenerimaanbhnmakananV'];
            $model->jns_periode = $_GET['GULaporanpenerimaanbhnmakananV']['jns_periode'];
            $model->tgl_awal = date('Y-m-d',  strtotime($format->formatDateTimeForDb($_GET['GULaporanpenerimaanbhnmakananV']['tgl_awal'])));
            $model->tgl_akhir = date('Y-m-d',  strtotime($format->formatDateTimeForDb($_GET['GULaporanpenerimaanbhnmakananV']['tgl_akhir'])));
            $model->bln_awal = $format->formatMonthForDb($_GET['GULaporanpenerimaanbhnmakananV']['bln_awal']);
            $model->bln_akhir = $format->formatMonthForDb($_GET['GULaporanpenerimaanbhnmakananV']['bln_akhir']);
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
        $target ='terimaBahanMak/_print';

        $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
    }

    public function actionFrameGrafikLaporanBahanPenerimaanMakanan() {
        $this->layout = '//layouts/iframe';
        $model = new GULaporanpenerimaanbhnmakananV('search');
        $format = new MyFormatter();
        $model->jns_periode = "hari";
        $model->tgl_awal = date('Y-m-d');
        $model->tgl_akhir = date('Y-m-d');
        $model->bln_awal = date('Y-m', strtotime('first day of january'));
        $model->bln_akhir = date('Y-m');
        $model->thn_awal = date('Y');
        $model->thn_akhir = date('Y');
        $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
        //Data Grafik
        //Data Grafik
        $berdasarkan = 'Berdasarkan Supplier';
        if (isset($_GET['filter']))
        {
            $berdasarkan = 'Berdasarkan Supplier';           
        }
        if (isset($_GET['filter1']))
        {
            $berdasarkan = 'Berdasarkan Golongan Bahan Makanan';           
        }
        if (isset($_GET['filter2']))
        {
            $berdasarkan = 'Berdasarkan Jenis Bahan Makanan';           
        }
        if (isset($_GET['filter3']))
        {
            $berdasarkan = 'Berdasarkan Kelompok Bahan Makanan';           
        }
        
        $data['title'] = 'Grafik Laporan Penerimaan Bahan Makanan '.$berdasarkan;
        
        $data['type'] = (isset($_GET['type']) ? $_GET['type'] : "");
        if (isset($_GET['GULaporanpenerimaanbhnmakananV'])) {
            $model->attributes = $_GET['GULaporanpenerimaanbhnmakananV'];
            $model->jns_periode = $_GET['GULaporanpenerimaanbhnmakananV']['jns_periode'];
            $model->tgl_awal = date('Y-m-d',  strtotime($format->formatDateTimeForDb($_GET['GULaporanpenerimaanbhnmakananV']['tgl_awal'])));
            $model->tgl_akhir = date('Y-m-d',  strtotime($format->formatDateTimeForDb($_GET['GULaporanpenerimaanbhnmakananV']['tgl_akhir'])));
            $model->bln_awal = $format->formatMonthForDb($_GET['GULaporanpenerimaanbhnmakananV']['bln_awal']);
            $model->bln_akhir = $format->formatMonthForDb($_GET['GULaporanpenerimaanbhnmakananV']['bln_akhir']);
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
        $searchData = $model->searchGrafik();
        $this->render('_grafik', array(
            'model' => $model,
            'data' => $data,
            'searchdata'=>$searchData,
        ));
    }
    /* END LAPORAN PENERIMAAN BAHAN MAKANAN */
        
// Laporan Pembelian Barang Gudang Umum //
    public function actionPembelianBarang()
    {
        $model = new GULaporanPembelianbarangT;
        $format = new MyFormatter();
        $model->unsetAttributes();
        $model->jns_periode = "hari";
        $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
        $model->tgl_akhir = date('Y-m-d');
        $model->bln_awal = date('Y-m', strtotime('first day of january'));
        $model->bln_akhir = date('Y-m');
        $model->thn_awal = date('Y');
        $model->thn_akhir = date('Y');
        if (isset($_GET['GULaporanPembelianbarangT'])) {
            $model->attributes = $_GET['GULaporanPembelianbarangT'];
            $model->jns_periode = $_GET['GULaporanPembelianbarangT']['jns_periode'];
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['GULaporanPembelianbarangT']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['GULaporanPembelianbarangT']['tgl_akhir']);
            $model->bln_awal = $format->formatMonthForDb($_GET['GULaporanPembelianbarangT']['bln_awal']);
            $model->bln_akhir = $format->formatMonthForDb($_GET['GULaporanPembelianbarangT']['bln_akhir']);
            $model->thn_awal = $_GET['GULaporanPembelianbarangT']['thn_awal'];
            $model->thn_akhir = $_GET['GULaporanPembelianbarangT']['thn_akhir'];
            $bln_akhir = $model->bln_akhir."-".date("t",strtotime($model->bln_akhir));
            $thn_akhir = $model->thn_akhir."-".date("m-t",strtotime($model->thn_akhir."-12"));
            switch($model->jns_periode){
                case 'bulan' : $model->tgl_awal = $model->bln_awal."-01"; $model->tgl_akhir = $bln_akhir; break;
                case 'tahun' : $model->tgl_awal = $model->thn_awal."-01-01"; $model->tgl_akhir = $thn_akhir; break;
                default : null;
            }
            $model->tgl_awal = $model->tgl_awal." 00:00:00";
            $model->tgl_akhir = $model->tgl_akhir." 23:59:59";
            $model->supplier_id = $_GET['GULaporanPembelianbarangT']['supplier_id'];
        }
        $this->render('pembelianBarang/pembelianBarang',array(
            'model'=>$model,'format'=>$format
        ));
    }

    public function actionPrintPembelianBarang()
    {

        $model = new GULaporanPembelianbarangT;
        $format = new MyFormatter();
        $model->unsetAttributes();
        $model->jns_periode = "hari";
        $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
        $model->tgl_akhir = date('Y-m-d');
        $model->bln_awal = date('Y-m', strtotime('first day of january'));
        $model->bln_akhir = date('Y-m');
        $model->thn_awal = date('Y');
        $model->thn_akhir = date('Y');
        $judulLaporan = 'Laporan Pembelian Barang';

        //Data Grafik
        $data['title'] = 'Grafik Pembelian Barang';
        $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : null);
        if (isset($_REQUEST['GULaporanPembelianbarangT'])) {
                $model->attributes = $_REQUEST['GULaporanPembelianbarangT'];
                $model->jns_periode = $_REQUEST['GULaporanPembelianbarangT']['jns_periode'];
                $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['GULaporanPembelianbarangT']['tgl_awal']);
                $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['GULaporanPembelianbarangT']['tgl_akhir']);
                $model->bln_awal = $format->formatMonthForDb($_REQUEST['GULaporanPembelianbarangT']['bln_awal']);
                $model->bln_akhir = $format->formatMonthForDb($_REQUEST['GULaporanPembelianbarangT']['bln_akhir']);
                $model->thn_awal = $_GET['GULaporanPembelianbarangT']['thn_awal'];
                $model->thn_akhir = $_GET['GULaporanPembelianbarangT']['thn_akhir'];
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
        $caraPrint = (isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null);
        $target = 'pembelianBarang/printPembelianBarang';

        $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
    }   

    public function actionFramePembelianBarang() {
        $this->layout = '//layouts/iframe';

        $model = new GULaporanPembelianbarangT;
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
        $data['title'] = 'Grafik Pembelian Barang';
        $data['type'] = (isset($_GET['type']) ? $_GET['type'] : null);

        if (isset($_REQUEST['GULaporanPembelianbarangT'])) {
                $model->attributes = $_GET['GULaporanPembelianbarangT'];
                $model->jns_periode = $_GET['GULaporanPembelianbarangT']['jns_periode'];
                $model->tgl_awal = $format->formatDateTimeForDb($_GET['GULaporanPembelianbarangT']['tgl_awal']);
                $model->tgl_akhir = $format->formatDateTimeForDb($_GET['GULaporanPembelianbarangT']['tgl_akhir']);
                $model->bln_awal = $format->formatMonthForDb($_GET['GULaporanPembelianbarangT']['bln_awal']);
                $model->bln_akhir = $format->formatMonthForDb($_GET['GULaporanPembelianbarangT']['bln_akhir']);
                $model->thn_awal = $_GET['GULaporanPembelianbarangT']['thn_awal'];
                $model->thn_akhir = $_GET['GULaporanPembelianbarangT']['thn_akhir'];
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
        $searchdata = $model->searchPembelianBaranggrafik();
        $this->render('_grafik', array(
            'model' => $model,
            'data' => $data,
            'searchdata'=>$searchdata,
        ));
    }

   // Akhir Laporan Pembelian Barang Gudang Umum //   

   // Laporan Penerimaan Persediaan Gudang Umum //
   public function actionPenerimaanPersediaan()
    {
        $model = new GULaporanPenerimaanpersediaanT;
        $format = new MyFormatter();
        $model->unsetAttributes();
        $model->jns_periode = "hari";
        $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
        $model->tgl_akhir = date('Y-m-d');
        $model->bln_awal = date('Y-m', strtotime('first day of january'));
        $model->bln_akhir = date('Y-m');
        $model->thn_awal = date('Y');
        $model->thn_akhir = date('Y');
        if (isset($_GET['GULaporanPenerimaanpersediaanT'])) {
            $model->attributes = $_GET['GULaporanPenerimaanpersediaanT'];
            $model->jns_periode = $_GET['GULaporanPenerimaanpersediaanT']['jns_periode'];
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['GULaporanPenerimaanpersediaanT']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['GULaporanPenerimaanpersediaanT']['tgl_akhir']);
            $model->bln_awal = $format->formatMonthForDb($_GET['GULaporanPenerimaanpersediaanT']['bln_awal']);
            $model->bln_akhir = $format->formatMonthForDb($_GET['GULaporanPenerimaanpersediaanT']['bln_akhir']);
            $model->thn_awal = $_GET['GULaporanPenerimaanpersediaanT']['thn_awal'];
            $model->thn_akhir = $_GET['GULaporanPenerimaanpersediaanT']['thn_akhir'];
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
        $this->render('penerimaanPersediaan/penerimaanPersediaan',array(
            'model'=>$model,'format'=>$format
        ));
    }

    public function actionPrintPenerimaanPersediaan()
    {

        $model = new GULaporanPenerimaanpersediaanT;
        $format = new MyFormatter();
        $model->unsetAttributes();
        $model->jns_periode = "hari";
        $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
        $model->tgl_akhir = date('Y-m-d');
        $model->bln_awal = date('Y-m', strtotime('first day of january'));
        $model->bln_akhir = date('Y-m');
        $model->thn_awal = date('Y');
        $model->thn_akhir = date('Y');
        $judulLaporan = 'Laporan Penerimaan Persediaan';

        //Data Grafik
        $data['title'] = 'Grafik Penerimaan Persediaan';
        $data['type'] = $_REQUEST['type'];
        if (isset($_REQUEST['GULaporanPenerimaanpersediaanT'])) {
            $model->attributes = $_REQUEST['GULaporanPenerimaanpersediaanT'];
            $model->jns_periode = $_REQUEST['GULaporanPenerimaanpersediaanT']['jns_periode'];
            $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['GULaporanPenerimaanpersediaanT']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['GULaporanPenerimaanpersediaanT']['tgl_akhir']);
            $model->bln_awal = $format->formatMonthForDb($_REQUEST['GULaporanPenerimaanpersediaanT']['bln_awal']);
            $model->bln_akhir = $format->formatMonthForDb($_REQUEST['GULaporanPenerimaanpersediaanT']['bln_akhir']);
            $model->thn_awal = $_GET['GULaporanPenerimaanpersediaanT']['thn_awal'];
            $model->thn_akhir = $_GET['GULaporanPenerimaanpersediaanT']['thn_akhir'];
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
        $target = 'penerimaanPersediaan/printPenerimaanPersediaan';

        $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
    }   

    public function actionFramePenerimaanPersediaan() {
        $this->layout = '//layouts/iframe';

        $model = new GULaporanPenerimaanpersediaanT;
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
        $data['title'] = 'Grafik Penerimaan Persediaan';
        $data['type'] = $_GET['type'];

        if (isset($_REQUEST['GULaporanPenerimaanpersediaanT'])) {
                $model->attributes = $_GET['GULaporanPenerimaanpersediaanT'];
                $model->jns_periode = $_GET['GULaporanPenerimaanpersediaanT']['jns_periode'];
                $model->tgl_awal = $format->formatDateTimeForDb($_GET['GULaporanPenerimaanpersediaanT']['tgl_awal']);
                $model->tgl_akhir = $format->formatDateTimeForDb($_GET['GULaporanPenerimaanpersediaanT']['tgl_akhir']);
                $model->bln_awal = $format->formatMonthForDb($_GET['GULaporanPenerimaanpersediaanT']['bln_awal']);
                $model->bln_akhir = $format->formatMonthForDb($_GET['GULaporanPenerimaanpersediaanT']['bln_akhir']);
                $model->thn_awal = $_GET['GULaporanPenerimaanpersediaanT']['thn_awal'];
                $model->thn_akhir = $_GET['GULaporanPenerimaanpersediaanT']['thn_akhir'];
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
        $searchdata = $model->searchPenerimaanPersediaangrafik();
        $this->render('_grafik', array(
            'model' => $model,
            'data' => $data,
            'searchdata'=>$searchdata,
        ));
    }

   // Akhir Laporan Penerimaan Persediaan Gudang Umum //

   // Laporan Retur Penerimaan Gudang Umum //
    public function actionReturPenerimaan()
    {
        $model = new GULaporanReturPenerimaanT;
        $format = new MyFormatter();
        $model->unsetAttributes();
        $model->jns_periode = "hari";
        $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
        $model->tgl_akhir = date('Y-m-d');
        $model->bln_awal = date('Y-m', strtotime('first day of january'));
        $model->bln_akhir = date('Y-m');
        $model->thn_awal = date('Y');
        $model->thn_akhir = date('Y');
        if (isset($_GET['GULaporanReturPenerimaanT'])) {
            $model->attributes = $_GET['GULaporanReturPenerimaanT'];
            $model->jns_periode = $_GET['GULaporanReturPenerimaanT']['jns_periode'];
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['GULaporanReturPenerimaanT']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['GULaporanReturPenerimaanT']['tgl_akhir']);
            $model->bln_awal = $format->formatMonthForDb($_GET['GULaporanReturPenerimaanT']['bln_awal']);
            $model->bln_akhir = $format->formatMonthForDb($_GET['GULaporanReturPenerimaanT']['bln_akhir']);
            $model->thn_awal = $_GET['GULaporanReturPenerimaanT']['thn_awal'];
            $model->thn_akhir = $_GET['GULaporanReturPenerimaanT']['thn_akhir'];
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
        $this->render('returPenerimaan/returPenerimaan',array(
            'model'=>$model,'format'=>$format
        ));
    }

    public function actionPrintReturPenerimaan()
    {

        $model = new GULaporanReturPenerimaanT;
        $format = new MyFormatter();
        $model->unsetAttributes();
        $model->jns_periode = "hari";
        $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
        $model->tgl_akhir = date('Y-m-d');
        $model->bln_awal = date('Y-m', strtotime('first day of january'));
        $model->bln_akhir = date('Y-m');
        $model->thn_awal = date('Y');
        $model->thn_akhir = date('Y');
        $judulLaporan = 'Laporan Retur Penerimaan';

        //Data Grafik
        $data['title'] = 'Grafik Retur Penerimaan';
        $data['type'] = $_REQUEST['type'];
        if (isset($_REQUEST['GULaporanReturPenerimaanT'])) {
                $model->attributes = $_REQUEST['GULaporanReturPenerimaanT'];
                $model->jns_periode = $_REQUEST['GULaporanReturPenerimaanT']['jns_periode'];
                $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['GULaporanReturPenerimaanT']['tgl_awal']);
                $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['GULaporanReturPenerimaanT']['tgl_akhir']);
                $model->bln_awal = $format->formatMonthForDb($_REQUEST['GULaporanReturPenerimaanT']['bln_awal']);
                $model->bln_akhir = $format->formatMonthForDb($_REQUEST['GULaporanReturPenerimaanT']['bln_akhir']);
                $model->thn_awal = $_GET['GULaporanReturPenerimaanT']['thn_awal'];
                $model->thn_akhir = $_GET['GULaporanReturPenerimaanT']['thn_akhir'];
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
        $target = 'returPenerimaan/printReturPenerimaan';

        $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
    }   

    public function actionFrameReturPenerimaan() {
        $this->layout = '//layouts/iframe';

        $model = new GULaporanReturPenerimaanT;
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
        $data['title'] = 'Grafik Retur Penerimaan';
        $data['type'] = $_GET['type'];

        if (isset($_REQUEST['GULaporanReturPenerimaanT'])) {
            $model->attributes = $_GET['GULaporanReturPenerimaanT'];
            $model->jns_periode = $_GET['GULaporanReturPenerimaanT']['jns_periode'];
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['GULaporanReturPenerimaanT']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['GULaporanReturPenerimaanT']['tgl_akhir']);
            $model->bln_awal = $format->formatMonthForDb($_GET['GULaporanReturPenerimaanT']['bln_awal']);
            $model->bln_akhir = $format->formatMonthForDb($_GET['GULaporanReturPenerimaanT']['bln_akhir']);
            $model->thn_awal = $_GET['GULaporanReturPenerimaanT']['thn_awal'];
            $model->thn_akhir = $_GET['GULaporanReturPenerimaanT']['thn_akhir'];
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
        $searchdata = $model->searchReturPenerimaangrafik();
        $this->render('_grafik', array(
            'model' => $model,
            'data' => $data,
            'searchdata'=>$searchdata,
        ));
    }    

   // Akhir Laporan Retur Penerimaan Gudang Umum //
    
    // AWAL LAPORAN RETUR PEMBELIAN
    
    public function actionReturPembelian()
    {
        $model = new GUInformasireturpembelianV;
        $format = new MyFormatter();
        $model->unsetAttributes();
        $model->jns_periode = "hari";
        $model->tgl_awal = date('Y-m-d');
        $model->tgl_akhir = date('Y-m-d');
        $model->bln_awal = date('Y-m');
        $model->bln_akhir = date('Y-m');
        $model->thn_awal = date('Y');
        $model->thn_akhir = date('Y');
        if (isset($_GET['GUInformasireturpembelianV'])) {
            $model->attributes = $_GET['GUInformasireturpembelianV'];
            $model->jns_periode = $_GET['GUInformasireturpembelianV']['jns_periode'];
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['GUInformasireturpembelianV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['GUInformasireturpembelianV']['tgl_akhir']);
            $model->bln_awal = $format->formatMonthForDb($_GET['GUInformasireturpembelianV']['bln_awal']);
            $model->bln_akhir = $format->formatMonthForDb($_GET['GUInformasireturpembelianV']['bln_akhir']);
            $model->thn_awal = $_GET['GUInformasireturpembelianV']['thn_awal'];
            $model->thn_akhir = $_GET['GUInformasireturpembelianV']['thn_akhir'];
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
         $searchdata = $model->searchReturPembelianGrafik();
        $this->render('returPembelian/admin',array(
            'model'=>$model,'format'=>$format,'searchdata'=>$searchdata
        ));
    }

    public function actionPrintReturPembelian()
    {

        $model = new GUInformasireturpembelianV;
        $format = new MyFormatter();
        $model->unsetAttributes();
        $model->jns_periode = "hari";
        $model->tgl_awal = date('Y-m-d');
        $model->tgl_akhir = date('Y-m-d');
        $model->bln_awal = date('Y-m');
        $model->bln_akhir = date('Y-m');
        $model->thn_awal = date('Y');
        $model->thn_akhir = date('Y');
        $judulLaporan = 'Laporan Retur Pembelian';

        //Data Grafik
        $data['title'] = 'Grafik Retur Pembelian';
        $data['type'] = isset($_GET['type'])?$_GET['type']:null;
        if (isset($_REQUEST['GUInformasireturpembelianV'])) {
                $model->attributes = $_REQUEST['GUInformasireturpembelianV'];
                $model->jns_periode = $_REQUEST['GUInformasireturpembelianV']['jns_periode'];
                $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['GUInformasireturpembelianV']['tgl_awal']);
                $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['GUInformasireturpembelianV']['tgl_akhir']);
                $model->bln_awal = $format->formatMonthForDb($_REQUEST['GUInformasireturpembelianV']['bln_awal']);
                $model->bln_akhir = $format->formatMonthForDb($_REQUEST['GUInformasireturpembelianV']['bln_akhir']);
                $model->thn_awal = $_GET['GUInformasireturpembelianV']['thn_awal'];
                $model->thn_akhir = $_GET['GUInformasireturpembelianV']['thn_akhir'];
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
        $target = 'returPembelian/_print';
        $searchdata = $model->searchReturPembelianGrafik();
        $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target, $searchdata);
    }   

    public function actionFrameReturPembelian() {
        $this->layout = '//layouts/iframe';

        $model = new GUInformasireturpembelianV;
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
        $data['title'] = 'Grafik Retur Pembelian';
        $data['type'] = isset($_GET['type'])?$_GET['type']:null;

        if (isset($_REQUEST['GUInformasireturpembelianV'])) {
            $model->attributes = $_GET['GUInformasireturpembelianV'];
            $model->jns_periode = $_GET['GUInformasireturpembelianV']['jns_periode'];
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['GUInformasireturpembelianV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['GUInformasireturpembelianV']['tgl_akhir']);
            $model->bln_awal = $format->formatMonthForDb($_GET['GUInformasireturpembelianV']['bln_awal']);
            $model->bln_akhir = $format->formatMonthForDb($_GET['GUInformasireturpembelianV']['bln_akhir']);
            $model->thn_awal = $_GET['GUInformasireturpembelianV']['thn_awal'];
            $model->thn_akhir = $_GET['GUInformasireturpembelianV']['thn_akhir'];
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
        $searchdata = $model->searchReturPembelianGrafik();
        $this->render('_grafik', array(
            'model' => $model,
            'data' => $data,
            'searchdata'=>$searchdata,
        ));
    }   
    
    // AKHIR LAPORAN RETUR PEMBELIAN
    
    // AWAL LAPORAN MATERIAL RUSAK
    
    public function actionMaterialRusak()
    {
        $model = new GUInfoinventarisasibarangV;                       
        $format = new MyFormatter();
        $model->unsetAttributes();
        $model->jns_periode = "hari";
        $model->tgl_awal = date('Y-m-d');
        $model->tgl_akhir = date('Y-m-d');
        $model->bln_awal = date('Y-m');
        $model->bln_akhir = date('Y-m');
        $model->thn_awal = date('Y');
        $model->thn_akhir = date('Y');
        if (isset($_GET['GUInfoinventarisasibarangV'])) {
            $model->attributes = $_GET['GUInfoinventarisasibarangV'];
            $model->jns_periode = $_GET['GUInfoinventarisasibarangV']['jns_periode'];
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['GUInfoinventarisasibarangV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['GUInfoinventarisasibarangV']['tgl_akhir']);
            $model->bln_awal = $format->formatMonthForDb($_GET['GUInfoinventarisasibarangV']['bln_awal']);
            $model->bln_akhir = $format->formatMonthForDb($_GET['GUInfoinventarisasibarangV']['bln_akhir']);
            $model->thn_awal = $_GET['GUInfoinventarisasibarangV']['thn_awal'];
            $model->thn_akhir = $_GET['GUInfoinventarisasibarangV']['thn_akhir'];
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
         $searchdata = $model->searchMaterialRusakGrafik();
        $this->render('materialRusak/admin',array(
            'model'=>$model,'format'=>$format,'searchdata'=>$searchdata
        ));
    }

    public function actionPrintMaterialRusak()
    {

        $model = new GUInfoinventarisasibarangV;
        $format = new MyFormatter();
        $model->unsetAttributes();
        $model->jns_periode = "hari";
        $model->tgl_awal = date('Y-m-d');
        $model->tgl_akhir = date('Y-m-d');
        $model->bln_awal = date('Y-m');
        $model->bln_akhir = date('Y-m');
        $model->thn_awal = date('Y');
        $model->thn_akhir = date('Y');
        $judulLaporan = 'Laporan Material Rusak';

        //Data Grafik
        $data['title'] = 'Grafik Material Rusak';
        $data['type'] = isset($_GET['type'])?$_GET['type']:null;
        if (isset($_REQUEST['GUInfoinventarisasibarangV'])) {
                $model->attributes = $_REQUEST['GUInfoinventarisasibarangV'];
                $model->jns_periode = $_REQUEST['GUInfoinventarisasibarangV']['jns_periode'];
                $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['GUInfoinventarisasibarangV']['tgl_awal']);
                $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['GUInfoinventarisasibarangV']['tgl_akhir']);
                $model->bln_awal = $format->formatMonthForDb($_REQUEST['GUInfoinventarisasibarangV']['bln_awal']);
                $model->bln_akhir = $format->formatMonthForDb($_REQUEST['GUInfoinventarisasibarangV']['bln_akhir']);
                $model->thn_awal = $_GET['GUInfoinventarisasibarangV']['thn_awal'];
                $model->thn_akhir = $_GET['GUInfoinventarisasibarangV']['thn_akhir'];
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
        $target = 'materialRusak/_print';
        $searchdata = $model->searchMaterialRusakGrafik();
        $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target, $searchdata);
    }   

    public function actionFrameMaterialRusak() {
        $this->layout = '//layouts/iframe';

        $model = new GUInfoinventarisasibarangV;
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
        $data['title'] = 'Grafik Material Rusak';
        $data['type'] = isset($_GET['type'])?$_GET['type']:null;

        if (isset($_REQUEST['GUInfoinventarisasibarangV'])) {
            $model->attributes = $_GET['GUInfoinventarisasibarangV'];
            $model->jns_periode = $_GET['GUInfoinventarisasibarangV']['jns_periode'];
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['GUInfoinventarisasibarangV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['GUInfoinventarisasibarangV']['tgl_akhir']);
            $model->bln_awal = $format->formatMonthForDb($_GET['GUInfoinventarisasibarangV']['bln_awal']);
            $model->bln_akhir = $format->formatMonthForDb($_GET['GUInfoinventarisasibarangV']['bln_akhir']);
            $model->thn_awal = $_GET['GUInfoinventarisasibarangV']['thn_awal'];
            $model->thn_akhir = $_GET['GUInfoinventarisasibarangV']['thn_akhir'];
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
        $searchdata = $model->searchMaterialRusakGrafik();
        $this->render('_grafik', array(
            'model' => $model,
            'data' => $data,
            'searchdata'=>$searchdata,
        ));
    }   
    
    // AKHIR LAPORAN Material rusak
    
    
    // AWAL LAPORAN MATERIAL HABIS
    
    public function actionMaterialHabis()
    {
        $model = new GUInformasistokbarangV;                       
        $format = new MyFormatter();
        $model->unsetAttributes();        
       /* $model->jns_periode = "hari";
        $model->tgl_awal = date('Y-m-d');
        $model->tgl_akhir = date('Y-m-d');
        $model->bln_awal = date('Y-m');
        $model->bln_akhir = date('Y-m');
        $model->thn_awal = date('Y');
        $model->thn_akhir = date('Y');*/
        if (isset($_GET['GUInformasistokbarangV'])) {
            $model->attributes = $_GET['GUInformasistokbarangV'];
            $model->stok = $_GET['GUInformasistokbarangV']['stok'];
            /*$model->jns_periode = $_GET['GUInformasistokbarangV']['jns_periode'];
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['GUInformasistokbarangV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['GUInformasistokbarangV']['tgl_akhir']);
            $model->bln_awal = $format->formatMonthForDb($_GET['GUInformasistokbarangV']['bln_awal']);
            $model->bln_akhir = $format->formatMonthForDb($_GET['GUInformasistokbarangV']['bln_akhir']);
            $model->thn_awal = $_GET['GUInformasistokbarangV']['thn_awal'];
            $model->thn_akhir = $_GET['GUInformasistokbarangV']['thn_akhir'];
            $bln_akhir = $model->bln_akhir."-".date("t",strtotime($model->bln_akhir));
            $thn_akhir = $model->thn_akhir."-".date("m-t",strtotime($model->thn_akhir."-12"));
            switch($model->jns_periode){
                case 'bulan' : $model->tgl_awal = $model->bln_awal."-01"; $model->tgl_akhir = $bln_akhir; break;
                case 'tahun' : $model->tgl_awal = $model->thn_awal."-01-01"; $model->tgl_akhir = $thn_akhir; break;
                default : null;
            }
            $model->tgl_awal = $model->tgl_awal." 00:00:00";
            $model->tgl_akhir = $model->tgl_akhir." 23:59:59";*/
        }
         $searchdata = $model->searchMaterialHabisGrafik();
        $this->render('materialHabis/admin',array(
            'model'=>$model,'format'=>$format,'searchdata'=>$searchdata
        ));
    }

    public function actionPrintMaterialHabis()
    {

        $model = new GUInformasistokbarangV;
        $format = new MyFormatter();
        $model->unsetAttributes();
       /* $model->jns_periode = "hari";
        $model->tgl_awal = date('Y-m-d');
        $model->tgl_akhir = date('Y-m-d');
        $model->bln_awal = date('Y-m');
        $model->bln_akhir = date('Y-m');
        $model->thn_awal = date('Y');
        $model->thn_akhir = date('Y');*/
        $judulLaporan = 'Laporan Material Habis';

        //Data Grafik
        $data['title'] = 'Grafik Material Habis';
        $data['type'] = isset($_GET['type'])?$_GET['type']:null;
        if (isset($_REQUEST['GUInformasistokbarangV'])) {
                $model->attributes = $_REQUEST['GUInformasistokbarangV'];
                $model->stok = $_GET['GUInformasistokbarangV']['stok'];
                /*$model->jns_periode = $_REQUEST['GUInformasistokbarangV']['jns_periode'];
                $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['GUInformasistokbarangV']['tgl_awal']);
                $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['GUInformasistokbarangV']['tgl_akhir']);
                $model->bln_awal = $format->formatMonthForDb($_REQUEST['GUInformasistokbarangV']['bln_awal']);
                $model->bln_akhir = $format->formatMonthForDb($_REQUEST['GUInformasistokbarangV']['bln_akhir']);
                $model->thn_awal = $_GET['GUInformasistokbarangV']['thn_awal'];
                $model->thn_akhir = $_GET['GUInformasistokbarangV']['thn_akhir'];
                $bln_akhir = $model->bln_akhir."-".date("t",strtotime($model->bln_akhir));
                $thn_akhir = $model->thn_akhir."-".date("m-t",strtotime($model->thn_akhir."-12"));
                switch($model->jns_periode){
                    case 'bulan' : $model->tgl_awal = $model->bln_awal."-01"; $model->tgl_akhir = $bln_akhir; break;
                    case 'tahun' : $model->tgl_awal = $model->thn_awal."-01-01"; $model->tgl_akhir = $thn_akhir; break;
                    default : null;
                }
                $model->tgl_awal = $model->tgl_awal." 00:00:00";
                $model->tgl_akhir = $model->tgl_akhir." 23:59:59";*/
        }
        $caraPrint = $_REQUEST['caraPrint'];
        $target = 'materialHabis/_print';
        $searchdata = $model->searchMaterialHabisGrafik();
        $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target, $searchdata);
    }   

    public function actionFrameMaterialHabis() {
        $this->layout = '//layouts/iframe';

        $model = new GUInformasistokbarangV;
        $format = new MyFormatter();
        $model->unsetAttributes();
        /*$model->jns_periode = "hari";
        $model->tgl_awal = date('Y-m-d');
        $model->tgl_akhir = date('Y-m-d');
        $model->bln_awal = date('Y-m');
        $model->bln_akhir = date('Y-m');
        $model->thn_awal = date('Y');
        $model->thn_akhir = date('Y');*/

        //Data Grafik
        $data['title'] = 'Grafik Material Habis';
        $data['type'] = isset($_GET['type'])?$_GET['type']:null;

        if (isset($_REQUEST['GUInformasistokbarangV'])) {
            $model->attributes = $_GET['GUInformasistokbarangV'];
            $model->stok = $_GET['GUInformasistokbarangV']['stok'];
            /*$model->jns_periode = $_GET['GUInformasistokbarangV']['jns_periode'];
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['GUInformasistokbarangV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['GUInformasistokbarangV']['tgl_akhir']);
            $model->bln_awal = $format->formatMonthForDb($_GET['GUInformasistokbarangV']['bln_awal']);
            $model->bln_akhir = $format->formatMonthForDb($_GET['GUInformasistokbarangV']['bln_akhir']);
            $model->thn_awal = $_GET['GUInformasistokbarangV']['thn_awal'];
            $model->thn_akhir = $_GET['GUInformasistokbarangV']['thn_akhir'];
            $bln_akhir = $model->bln_akhir."-".date("t",strtotime($model->bln_akhir));
            $thn_akhir = $model->thn_akhir."-".date("m-t",strtotime($model->thn_akhir."-12"));
            switch($model->jns_periode){
                case 'bulan' : $model->tgl_awal = $model->bln_awal."-01"; $model->tgl_akhir = $bln_akhir; break;
                case 'tahun' : $model->tgl_awal = $model->thn_awal."-01-01"; $model->tgl_akhir = $thn_akhir; break;
                default : null;
            }
            $model->tgl_awal = $model->tgl_awal." 00:00:00";
            $model->tgl_akhir = $model->tgl_akhir." 23:59:59";*/
        }
        $searchdata = $model->searchMaterialHabisGrafik();
        $this->render('_grafik', array(
            'model' => $model,
            'data' => $data,
            'searchdata'=>$searchdata,
        ));
    }   
    
    // AKHIR LAPORAN MATERIAL HABIS

    protected function printFunction($model, $data, $caraPrint, $judulLaporan, $target, $searchdata=null){
        $format = new MyFormatter();
        $periode = $format->formatDateTimeForUser($model->tgl_awal).' s/d '.$format->formatDateTimeForUser($model->tgl_akhir);
        if ($caraPrint == 'PRINT' || $caraPrint == 'GRAFIK') {
            $this->layout = '//layouts/printWindows2';
            $this->render($target, array('model' => $model, 'periode'=>$periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint, 'searchdata'=>$searchdata));
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
            $mpdf->Output($judulLaporan.'_'.date('Y-m-d').'.pdf','I');
        }
    }


    public function actionStock()
    {
            $model = new RELaporanstokprodukposV;
            $model->tgl_awal = date('Y-m-d 00:00:00');
            $model->tgl_akhir = date('Y-m-d 23:59:59');
            if (isset($_GET['RELaporanstokprodukposV'])) {
                $format = new MyFormatter;
                $model->attributes = $_GET['RELaporanstokprodukposV'];
                $model->tgl_awal = $format->formatDateTimeForDb($_GET['RELaporanstokprodukposV']['tgl_awal']);
                $model->tgl_akhir = $format->formatDateTimeForDb($_GET['RELaporanstokprodukposV']['tgl_akhir']);
            }
            $this->render('stock/stock',array(
                'model'=>$model,
            ));
    }

    public function actionPrintStock()
    {
        $model = new RELaporanstokprodukposV;
        $model->tgl_awal = date('Y-m-d 00:00:00');
        $model->tgl_akhir = date('Y-m-d 23:59:59');
        $judulLaporan = 'Stock Barang';

        //Data Grafik
        $data['title'] = 'Grafik Stock';
        $data['type'] = $_REQUEST['type'];
        if (isset($_REQUEST['RELaporanstokprodukposV'])) {
                $format = new MyFormatter;
                $model->attributes = $_GET['RELaporanstokprodukposV'];
                $model->tgl_awal = $format->formatDateTimeForDb($_GET['RELaporanstokprodukposV']['tgl_awal']);
                $model->tgl_akhir = $format->formatDateTimeForDb($_GET['RELaporanstokprodukposV']['tgl_akhir']);
        }
        $caraPrint = $_REQUEST['caraPrint'];
        $target = 'stock/printStock';

        $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
    }   

    public function actionFrameStock() {
        $this->layout = '//layouts/iframe';

        $model = new RELaporanstokprodukposV;
        $model->tgl_awal = date('Y-m-d 00:00:00');
        $model->tgl_akhir = date('Y-m-d 23:59:59');

        //Data Grafik
        $data['title'] = 'Grafik Stock Barang';
        $data['type'] = $_GET['type'];

        if (isset($_REQUEST['RELaporanstokprodukposV'])) {
                $format = new MyFormatter;
                $model->attributes = $_GET['RELaporanstokprodukposV'];
                $model->tgl_awal = $format->formatDateTimeForDb($_GET['RELaporanstokprodukposV']['tgl_awal']);
                $model->tgl_akhir = $format->formatDateTimeForDb($_GET['RELaporanstokprodukposV']['tgl_akhir']);
        }
        $searchdata = $model->searchGrafik();
        $this->render('_grafik', array(
            'model' => $model,
            'data' => $data,
            'searchdata'=>$searchdata,
        ));
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