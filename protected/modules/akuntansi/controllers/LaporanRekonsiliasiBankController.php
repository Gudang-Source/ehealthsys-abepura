<?php

class LaporanRekonsiliasiBankController extends MyAuthController{
	protected $path_view = 'akuntansi.views.laporanRekonsiliasiBank.';
	
	public function actionIndex(){
		$format = new MyFormatter();
		$model	= new AKLaporanrekonsiliasibankV('searchLaporan');
		$model->tgl_awal = date('Y-m-d H:i:s');
		$model->tgl_akhir = date('Y-m-d H:i:s');
		
		if(isset($_GET['AKLaporanrekonsiliasibankV'])){
			$model->attributes = $_GET['AKLaporanrekonsiliasibankV'];
			$model->tgl_awal = $format->formatDateTimeForDb($_GET['AKLaporanrekonsiliasibankV']['tgl_awal']);
			$model->tgl_akhir = $format->formatDateTimeForDb($_GET['AKLaporanrekonsiliasibankV']['tgl_akhir']);
		}
		
		$this->render($this->path_view.'admin',array(
			'format'=>$format,
			'model'=>$model
		));
	}
	
	public function actionPrintLaporanRekonsiliasiBank(){
        $format = new MyFormatter();
        $model = new AKLaporanrekonsiliasibankV('searchLaporanPrint');
        $judulLaporan = 'Laporan Rekonsiliasi Bank';
        //Data Grafik
        $data['title'] = 'Laporan Rekonsiliasi Bank';
        $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : null);
        if (isset($_REQUEST['AKLaporanrekonsiliasibankV'])) {
            $model->attributes = $_REQUEST['AKLaporanrekonsiliasibankV'];
            $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['AKLaporanrekonsiliasibankV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['AKLaporanrekonsiliasibankV']['tgl_akhir']);
        }

        $caraPrint = $_REQUEST['caraPrint'];
        $target = $this->path_view.'_print';

        $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
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
            $mpdf->Output();
        }
    }
}