<?php

class LaporanController extends LaporanFarmasiController {

    //untuk range tanggal default
    public $tgl_awal = "d M Y 00:00:00";
    public $tgl_akhir = "d M Y 23:59:59";
    
    public function actionLaporanPenjualanObat() {
        $model = new FALaporanpenjualanobatV();
        $format = new MyFormatter();
        $model->tgl_awal = date("d M Y");
        $model->tgl_akhir = date("d M Y");
//        $model->unsetAttributes();
        if (isset($_GET['FALaporanpenjualanobatV'])) {
            $model->attributes = $_GET['FALaporanpenjualanobatV'];
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['FALaporanpenjualanobatV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['FALaporanpenjualanobatV']['tgl_akhir']);
            $model->jenispenjualan = $_GET['FALaporanpenjualanobatV']['jenispenjualan'];
            echo "<pre>";
            print_r($_GET['FALaporanpenjualanobatV']);
        }

        
        $this->render('penjualanObat/index', array(
            'model' => $model,
        ));
    }

    public function actionPrintLaporanPenjualanObat() {
        $model = new FALaporanpenjualanobatV('search');
        $judulLaporan = 'Laporan Penjualan Obat';

        //Data Grafik       
        $data['title'] = 'Grafik Laporan Penjualan Obat';
        $data['type'] = $_REQUEST['type'];
        if (isset($_REQUEST['FALaporanpenjualanobatV'])) {
            $model->attributes = $_REQUEST['FALaporanpenjualanobatV'];
            $format = new MyFormatter();
            $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['FALaporanpenjualanobatV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['FALaporanpenjualanobatV']['tgl_akhir']);
        }
        
        $caraPrint = $_REQUEST['caraPrint'];
        $target = 'penjualanObat/_printPenjualanObat';
        
        $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
    }

    public function actionFrameGrafikPenjualanObat() {
        $this->layout = '//layouts/iframe';
        $model = new FALaporanpenjualanobatV('search');
        $model->tgl_awal = date('d M Y');
        $model->tgl_akhir = date('d M Y');
        //Data Grafik
        $data['title'] = 'Grafik Penjualan Obat';
        $data['type'] = $_GET['type'];
        if (isset($_GET['FALaporanpenjualanobatV'])) {
            $model->attributes = $_GET['FALaporanpenjualanobatV'];
            $format = new MyFormatter();
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['FALaporanpenjualanobatV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['FALaporanpenjualanobatV']['tgl_akhir']);
            $model->jenispenjualan = $_GET['FALaporanpenjualanobatV']['jenispenjualan'];
        }
//        echo "<pre>";
//        print_r($_GET['FALaporanpenjualanobatV']);
//        exit;
        $this->render('penjualanObat/_grafik', array(
            'model' => $model,
            'data' => $data,
        ));
    }
    
    public function actionLaporanLembarResep() {

        $model = new FALaporanlembarresepV('search');
        $format = new MyFormatter;
        $model->tgl_awal = date('Y-m-d');
        $model->tgl_akhir = date('Y-m-d');
        if (isset($_GET['FALaporanlembarresepV'])) {
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['FALaporanlembarresepV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['FALaporanlembarresepV']['tgl_akhir']);
        }
        $this->render('laporanlembarresepV/index',array(
            'model'=>$model,
            'tgl_awal'=>$model->tgl_awal,
            'tgl_akhir'=>$model->tgl_akhir,
        ));
    }
    
    public function actionPrintLaporanLembarResep() {
        $model = new FALaporanlembarresepV('search');
        $judulLaporan = 'Laporan Lembar Resep';

        //Data Grafik  

        $data['title'] = 'Grafik Laporan Penjualan Obat';
        $data['type'] = isset($_REQUEST['type'])?$_REQUEST['type']:'';
        if (isset($_REQUEST['FALaporanlembarresepV'])) {
            $model->attributes = $_REQUEST['FALaporanlembarresepV'];
            $format = new MyFormatter();
            $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['FALaporanlembarresepV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['FALaporanlembarresepV']['tgl_akhir']);
        }
        
         $periode = $format->formatDateTimeForUser($model->tgl_awal).' s/d '.$format->formatDateTimeForUser($model->tgl_akhir);
        $caraPrint = $_REQUEST['caraPrint'];
        $target = 'laporanlembarresepV/Print';
        
//        $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
        if ($caraPrint == 'PRINT' || $caraPrint == 'GRAFIK') {
            $this->layout = '//layouts/printWindows';
            $this->render($target, array('model' => $model, 'periode'=>$periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint, 'tgl_awal'=>$model->tgl_awal, 'tgl_akhir'=>$model->tgl_akhir));
        } else if ($caraPrint == 'EXCEL') {
            $this->layout = '//layouts/printExcel';
            $this->render($target, array('model' => $model, 'periode'=>$periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint, 'tgl_awal'=>$model->tgl_awal, 'tgl_akhir'=>$model->tgl_akhir));
        } else if ($_REQUEST['caraPrint'] == 'PDF') {
            $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
            $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
            $mpdf = new MyPDF('', $ukuranKertasPDF);
            $mpdf->useOddEven = 2;
            $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
            $mpdf->WriteHTML($stylesheet, 1);
            $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 0, 5, 15, 15);
            $mpdf->tMargin=5;
            $mpdf->WriteHTML($this->renderPartial($target, array('model' => $model, 'periode'=>$periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint, 'tgl_awal'=>$model->tgl_awal, 'tgl_akhir'=>$model->tgl_akhir), true));
            $mpdf->Output();
        }
    }
    
    public function actionframeGrafikLaporanLembarResep() {
        $this->layout = '//layouts/iframe';
        $model = new FALaporanlembarresepV('search');
        $model->tgl_awal = date('Y-m-d');
        $model->tgl_akhir = date('Y-m-d');

        //Data Grafik
        $data['title'] = 'Grafik Laporan Lembar Resep';
        $data['type'] = $_GET['type'];
        $searchdata = $model->searchGrafikLembarResep();
        if (isset($_GET['FALaporanlembarresepV'])) {
            $model->attributes = $_GET['FALaporanlembarresepV'];
            $format = new MyFormatter();
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['FALaporanlembarresepV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['FALaporanlembarresepV']['tgl_akhir']);
        }
        
        $this->render('_grafik', array(
            'model' => $model,
            'data' => $data,
            'searchdata'=>$searchdata
        ));
    }
    
    public function actionLaporanLembarResepLuar() {
        $model = new FALaporanlembarresepluarV('search');
        $format = new MyFormatter;
        $model->tgl_awal = date('d M Y');
        $model->tgl_akhir = date('d M Y');
        $model->tgl_awal = $format->formatDateTimeForUser($model->tgl_awal);
        $model->tgl_akhir = $format->formatDateTimeForUser($model->tgl_akhir);
        if (isset($_GET['FALaporanlembarresepluarV'])) {
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['FALaporanlembarresepluarV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['FALaporanlembarresepluarV']['tgl_akhir']);
        }
        $this->render('laporanlembarresepluarV/index',array(
            'model'=>$model,
        ));
    }
    
    public function actionframeGrafikLaporanLembarResepLuar() {
        $this->layout = '//layouts/iframe';
        $model = new FALaporanlembarresepluarV('search');
        $model->tgl_awal = date('d M Y 00:00:00');
        $model->tgl_akhir = date('d M Y 23:59:59');

        //Data Grafik
        $data['title'] = 'Grafik Laporan Lembar Resep Luar';
        $data['type'] = $_GET['type'];
        $searchdata = $model->searchGrafik();
        if (isset($_GET['FALaporanlembarresepV'])) {
            $model->attributes = $_GET['FALaporanlembarresepV'];
            $format = new MyFormatter();
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['FALaporanlembarresepluarV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['FALaporanlembarresepluarV']['tgl_akhir']);
        }
        
        $this->render('_grafik', array(
            'model' => $model,
            'data' => $data,
            'searchdata'=>$searchdata
        ));
    }
    
    public function actionPrintLaporanLembarResepLuar() {
        $model = new FALaporanlembarresepluarV('search');
        $judulLaporan = 'Laporan Lembar Resep Luar';

        //Data Grafik       
        $data['title'] = 'Grafik Laporan Lembar Resep Luar';
        if (isset($_REQUEST['type'])){
            $data['type'] = $_REQUEST['type'];
        } else {
            $data['type'] = null;
        }
        if (isset($_REQUEST['FALaporanlembarresepluarV'])) {
            $model->attributes = $_REQUEST['FALaporanlembarresepluarV'];
            $format = new MyFormatter();
            $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['FALaporanlembarresepluarV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['FALaporanlembarresepluarV']['tgl_akhir']);
        }
        
        $caraPrint = $_REQUEST['caraPrint'];
        $target = 'laporanlembarresepluarV/Print';
        $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
    }

//    YANG INI ERROR JADI MENGGUNAKAN CONTROLLER LaporanFarmasiController 
//    protected function printFunction($model, $modDetail, $data, $caraPrint, $judulLaporan, $target){
//        $format = new MyFormatter();
//        $periode = $this->parserTanggal($model->tgl_awal).' s/d '.$this->parserTanggal($model->tgl_akhir);
////        echo $caraPrint;
//        if ($caraPrint == 'PRINT' || $caraPrint == 'GRAFIK') {
//            $this->layout = '//layouts/printWindows';
//            $this->render($target, array('modDetail'=>$modDetail,'rincianUang'=>$rincianUang,'model' => $model, 'periode'=>$periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint , 'modRincian'=>$modRincian));
//        } else if ($caraPrint == 'EXCEL') {
//            $this->layout = '//layouts/printExcel';
//            $this->render($target, array('modDetail'=>$modDetail,'rincianUang'=>$rincianUang,'model' => $model, 'periode'=>$periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint, 'modRincian'=>$modRincian));
//        } else if ($_REQUEST['caraPrint'] == 'PDF') {
//            $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
//            $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
//            $mpdf = new MyPDF('', $ukuranKertasPDF);
//            $mpdf->useOddEven = 2;
//            $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
//            $mpdf->WriteHTML($stylesheet, 1);
//            $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
//            $mpdf->WriteHTML($this->renderPartial($target, array('modDetail'=>$modDetail,'rincianUang'=>$rincianUang,'model' => $model, 'periode'=>$periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint, 'modRincian'=>$modRincian), true));
//            $mpdf->Output();
//        }
//    }
    
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