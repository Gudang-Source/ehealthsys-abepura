<?php

class LaporanPengirimanLinenController extends MyAuthController 
{
	
	public $path_view='laundry.views.laporan.';
    public function actionIndex() {
        $this->pageTitle = Yii::app()->name." - Laporan Pengiriman Linen";
        $model = new LALaporanpengirimanlinenV('search');
        $format = new MyFormatter();
        $model->unsetAttributes();        
        $model->jns_periode = "hari";
        $model->tgl_awal = date('Y-m-d');
        $model->tgl_akhir = date('Y-m-d');
        $model->bln_awal = date('Y-m');
        $model->bln_akhir = date('Y-m');
        $model->thn_awal = date('Y');
        $model->thn_akhir = date('Y');
		//$model->jml_tampil = -1;

        if (isset($_GET['LALaporanpengirimanlinenV'])) {
            $model->attributes = $_GET['LALaporanpengirimanlinenV'];            
			$model->jns_periode = $_GET['LALaporanpengirimanlinenV']['jns_periode'];
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['LALaporanpengirimanlinenV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['LALaporanpengirimanlinenV']['tgl_akhir']);
            $model->bln_awal = $format->formatMonthForDb($_GET['LALaporanpengirimanlinenV']['bln_awal']);
            $model->bln_akhir = $format->formatMonthForDb($_GET['LALaporanpengirimanlinenV']['bln_akhir']);
            $model->thn_awal = $_GET['LALaporanpengirimanlinenV']['thn_awal'];
            $model->thn_akhir = $_GET['LALaporanpengirimanlinenV']['thn_akhir'];
            $bln_akhir = $model->bln_akhir."-".date("t",strtotime($model->bln_akhir));
            $thn_akhir = $model->thn_akhir."-".date("m-t",strtotime($model->thn_akhir."-12"));
            switch($model->jns_periode){
                case 'bulan' : $model->tgl_awal = $model->bln_awal."-01"; $model->tgl_akhir = $bln_akhir; break;
                case 'tahun' : $model->tgl_awal = $model->thn_awal."-01-01"; $model->tgl_akhir = $thn_akhir; break;
                default : null;
            }
            $model->tgl_awal = $model->tgl_awal." 00:00:00";
            $model->tgl_akhir = $model->tgl_akhir." 23:59:59";
			//$model->jml_tampil = $_GET['LALaporanpengirimanlinenV']['jml_tampil'];
            
           
        }

        $this->render($this->path_view.'pengirimanLinen/index', array(
            'model' => $model,'format'=>$format
        ));
    }
    
    protected function printFunction($model, $caraPrint, $judulLaporan, $target)
    {
        $format = new MyFormatter();
        $periode = $format->formatDateTimeForUser($model->tgl_awal).' s/d '.$format->formatDateTimeForUser($model->tgl_akhir);
        if ($caraPrint == 'PRINT' || $caraPrint == 'GRAFIK') {
            $this->layout = '//layouts/printWindows';
            $this->render($target, array('model' => $model, 'periode'=>$periode, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
        } else if ($caraPrint == 'EXCEL') {
            $this->layout = '//layouts/printExcel';
            $this->render($target, array('model' => $model, 'periode'=>$periode, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
        } else if ($_REQUEST['caraPrint'] == 'PDF') {
            $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
            $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
            $mpdf = new MyPDF('', $ukuranKertasPDF);
            $mpdf->useOddEven = 2;
            $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
            $mpdf->WriteHTML($stylesheet, 1);
            $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
            $mpdf->WriteHTML($this->renderPartial($target, array('model' => $model, 'periode'=>$periode, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
            $mpdf->Output();
        }
    }
    
    
    public function actionPrintLaporanPengirimanLinen() {
        $model = new LALaporanpengirimanlinenV('searchPrint');
        $format = new MyFormatter();
        $model->unsetAttributes();
        $model->jns_periode = "hari";
        $model->tgl_awal = date('Y-m-d');
        $model->tgl_akhir = date('Y-m-d');
        $model->bln_awal = date('Y-m');
        $model->bln_akhir = date('Y-m');
        $model->thn_awal = date('Y');
        $model->thn_akhir = date('Y');
        
        $judulLaporan = 'Laporan Pengiriman Linen';
        if (isset($_REQUEST['LALaporanpengirimanlinenV'])) {
            $model->attributes = $_GET['LALaporanpengirimanlinenV'];            
            $model->jns_periode = $_GET['LALaporanpengirimanlinenV']['jns_periode'];
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['LALaporanpengirimanlinenV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['LALaporanpengirimanlinenV']['tgl_akhir']);
            $model->bln_awal = $format->formatMonthForDb($_GET['LALaporanpengirimanlinenV']['bln_awal']);
            $model->bln_akhir = $format->formatMonthForDb($_GET['LALaporanpengirimanlinenV']['bln_akhir']);
            $model->thn_awal = $_GET['LALaporanpengirimanlinenV']['thn_awal'];
            $model->thn_akhir = $_GET['LALaporanpengirimanlinenV']['thn_akhir'];
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
        $target = $this->path_view.'pengirimanLinen/_printPengirimanLinen';
	$this->printFunction($model, $caraPrint, $judulLaporan, $target);
    }
    
}

?>
