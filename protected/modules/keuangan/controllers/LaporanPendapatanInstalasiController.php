<?php
class LaporanPendapatanInstalasiController extends MyAuthController{
		
    /*
     * Laporan Pendapatan Instalasi
     */
    
     public function actionIndex() {
        $format = new MyFormatter();
        $model = new KULaporanrekappendapatanV('search');
		
        $model->unsetAttributes();
        //$model->jns_periode = "hari";
        $model->tgl_awal = date('Y-m-d 00:00:00');//, strtotime('first day of this month');
        $model->tgl_akhir = date('Y-m-d 23:59:59');
        $model->bln_awal = date('Y-m');
        $model->bln_akhir = date('Y-m');
        $model->thn_awal = date('Y');
        $model->thn_akhir = date('Y');
		
        if (isset($_GET['KULaporanrekappendapatanV'])) {
            $model->attributes = $_GET['KULaporanrekappendapatanV'];
            $model->jns_periode = $_GET['KULaporanrekappendapatanV']['jns_periode'];
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['KULaporanrekappendapatanV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['KULaporanrekappendapatanV']['tgl_akhir']);
            $model->bln_awal = $format->formatMonthForDb($_GET['KULaporanrekappendapatanV']['bln_awal']);
            $model->bln_akhir = $format->formatMonthForDb($_GET['KULaporanrekappendapatanV']['bln_akhir']);
            $model->thn_awal = $_GET['KULaporanrekappendapatanV']['thn_awal'];
            $model->thn_akhir = $_GET['KULaporanrekappendapatanV']['thn_akhir'];
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

        $this->render('index', array(
            'model' => $model, 'format'=>$format
        ));
    }

    public function actionPrintLaporanPendapatanInstalasi() {
        $model = new KULaporanrekappendapatanV('search');
        $model->tgl_awal = date('Y-m-d');//, strtotime('first day of this month');
        $model->tgl_akhir = date('Y-m-d ');
        $model->bln_awal = date('Y-m');
        $model->bln_akhir = date('Y-m');
        $model->thn_awal = date('Y');
        $model->thn_akhir = date('Y');
        $judulLaporan = 'Laporan Pendapatan Instalasi';

        //Data Grafik
        $data['title'] = 'Grafik Laporan Pendapatan Instalasi';
        $data['type'] = $_REQUEST['type'];
        if (isset($_REQUEST['KULaporanrekappendapatanV'])) {
            $model->attributes = $_REQUEST['KULaporanrekappendapatanV'];
            $format = new MyFormatter();
            $model->jns_periode = $_GET['KULaporanrekappendapatanV']['jns_periode'];
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['KULaporanrekappendapatanV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['KULaporanrekappendapatanV']['tgl_akhir']);
            $model->bln_awal = $format->formatMonthForDb($_GET['KULaporanrekappendapatanV']['bln_awal']);
            $model->bln_akhir = $format->formatMonthForDb($_GET['KULaporanrekappendapatanV']['bln_akhir']);
            $model->thn_awal = $_GET['KULaporanrekappendapatanV']['thn_awal'];
            $model->thn_akhir = $_GET['KULaporanrekappendapatanV']['thn_akhir'];
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
        $target = '_print';

        $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
    }

    public function actionFrameGrafikLaporanPendapatanInstalasi() {
        $this->layout = '//layouts/iframe';
        $model = new KULaporanrekappendapatanV('search');
        $model->tgl_awal = date('Y-m-d');//, strtotime('first day of this month');
        $model->tgl_akhir = date('Y-m-d ');
        $model->bln_awal = date('Y-m');
        $model->bln_akhir = date('Y-m');
        $model->thn_awal = date('Y');
        $model->thn_akhir = date('Y');

        //Data Grafik
        $data['title'] = 'Grafik Laporan Pendapatan Instalasi';
        $data['type'] = $_GET['type'];
        if (isset($_GET['KULaporanrekappendapatanV'])) {
            $model->attributes = $_GET['KULaporanrekappendapatanV'];
            $format = new MyFormatter();
            $model->jns_periode = $_GET['KULaporanrekappendapatanV']['jns_periode'];
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['KULaporanrekappendapatanV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['KULaporanrekappendapatanV']['tgl_akhir']);
            $model->bln_awal = $format->formatMonthForDb($_GET['KULaporanrekappendapatanV']['bln_awal']);
            $model->bln_akhir = $format->formatMonthForDb($_GET['KULaporanrekappendapatanV']['bln_akhir']);
            $model->thn_awal = $_GET['KULaporanrekappendapatanV']['thn_awal'];
            $model->thn_akhir = $_GET['KULaporanrekappendapatanV']['thn_akhir'];
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
        if(empty($model->tgl_awal)){
            $periode = $format->formatDateTimeForUser($model->tgl_awal).' s/d '.$format->formatDateTimeForUser($model->tgl_akhir);
        }
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

?>
