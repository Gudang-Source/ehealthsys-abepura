<?php

class LaporanRencanaAskepController extends MyAuthController{
	
	public $path_view = 'asuhanKeperawatan.views.lapRencanaAskep.';
	
	public function actionIndex(){
		$model = new ASLaprencanakepV('searchLaporan');
        $format = new MyFormatter();
        $model->unsetAttributes();
        $model->jns_periode = "hari";
        $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
        $model->tgl_akhir = date('Y-m-d');
        $model->bln_awal = date('Y-m', strtotime('first day of january'));
        $model->bln_akhir = date('Y-m');
        $model->thn_awal = date('Y');
        $model->thn_akhir = date('Y');
        if (isset($_GET['ASLaprencanakepV'])) {
            $model->attributes = $_GET['ASLaprencanakepV'];
            $model->jns_periode = $_GET['ASLaprencanakepV']['jns_periode'];
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['ASLaprencanakepV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['ASLaprencanakepV']['tgl_akhir']);
            $model->bln_awal = $format->formatMonthForDb($_GET['ASLaprencanakepV']['bln_awal']);
            $model->bln_akhir = $format->formatMonthForDb($_GET['ASLaprencanakepV']['bln_akhir']);
            $model->thn_awal = $_GET['ASLaprencanakepV']['thn_awal'];
            $model->thn_akhir = $_GET['ASLaprencanakepV']['thn_akhir'];
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
        $this->render($this->path_view.'admin',array(
            'model'=>$model,'format'=>$format
        ));
	}
	
	public function actionPrint()
    {

        $model = new ASLaprencanakepV('searchLaporanPrint');
        $format = new MyFormatter();
        $model->unsetAttributes();
        $model->jns_periode = "hari";
        $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
        $model->tgl_akhir = date('Y-m-d');
        $model->bln_awal = date('Y-m', strtotime('first day of january'));
        $model->bln_akhir = date('Y-m');
        $model->thn_awal = date('Y');
        $model->thn_akhir = date('Y');
        $judulLaporan = 'Laporan Rencana Keperawatan';

        //Data Grafik
        $data['title'] = 'Grafik Rencana Keperawatan';
        $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : null);
        if (isset($_REQUEST['ASLaprencanakepV'])) {
                $model->attributes = $_REQUEST['ASLaprencanakepV'];
                $model->jns_periode = $_REQUEST['ASLaprencanakepV']['jns_periode'];
                $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['ASLaprencanakepV']['tgl_awal']);
                $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['ASLaprencanakepV']['tgl_akhir']);
                $model->bln_awal = $format->formatMonthForDb($_REQUEST['ASLaprencanakepV']['bln_awal']);
                $model->bln_akhir = $format->formatMonthForDb($_REQUEST['ASLaprencanakepV']['bln_akhir']);
                $model->thn_awal = $_GET['ASLaprencanakepV']['thn_awal'];
                $model->thn_akhir = $_GET['ASLaprencanakepV']['thn_akhir'];
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
        $target = $this->path_view.'print';

        $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
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
            $mpdf->mirrorMargins = 2;
            $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
            $mpdf->WriteHTML($stylesheet, 1);
            $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
            $mpdf->WriteHTML($this->renderPartial($target, array('model' => $model, 'periode'=>$periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
            $mpdf->Output($judulLaporan.'_'.date('Y-m-d').'.pdf','I');
        }
    }
}