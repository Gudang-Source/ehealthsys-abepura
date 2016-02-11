<?php
class LapVerifikasiKlaimController extends MyAuthController{
	
	public $defaultAction = 'index';
	public $path_view = 'asuransi.views.lapVerifikasiKlaim.';
	
	public function actionIndex(){
		$format = new MyFormatter();
		$model=new ARLapverifikasiinasisV('searchLaporan');
		$model->unsetAttributes();
		$model->verifikasi_bytagihan = 0;
		$model->verifikasi_bytagihan_sampaidengan = 0;
		$model->verifikasi_bytarifgruper = 0;
		$model->verifikasi_bytarifgruper_sampaidengan = 0;
		
		if(isset($_GET['ARLapverifikasiinasisV'])){
				$model->attributes=$_GET['ARLapverifikasiinasisV'];
				$model->verifikasiinasis_tglmasuk=$format->formatDateTimeForDb($_GET['ARLapverifikasiinasisV']['verifikasiinasis_tglmasuk']);
				$model->verifikasiinasis_tglmasuk_sampaidengan=$format->formatDateTimeForDb($_GET['ARLapverifikasiinasisV']['verifikasiinasis_tglmasuk_sampaidengan']);
				$model->verifikasiinasis_tglkeluar=$format->formatDateTimeForDb($_GET['ARLapverifikasiinasisV']['verifikasiinasis_tglkeluar']);
				$model->verifikasiinasis_tglkeluar_sampaidengan=$format->formatDateTimeForDb($_GET['ARLapverifikasiinasisV']['verifikasiinasis_tglkeluar_sampaidengan']);
		}
		
		$this->render($this->path_view.'index',array(
			'format'=>$format,
			'model'=>$model
		));
	}
	
	public function actionPrint(){
        $format = new MyFormatter();
        $model = new ARLapverifikasiinasisV();
        $judulLaporan = 'Laporan Verifikasi Klaim';
        //Data Grafik
        $data['title'] = 'Laporan Verifikasi Klaim';
        $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : null);
        if (isset($_REQUEST['ARLapverifikasiinasisV'])) {
            $model->attributes = $_REQUEST['ARLapverifikasiinasisV'];
            $model->verifikasiinasis_tglmasuk=$format->formatDateTimeForDb($_REQUEST['ARLapverifikasiinasisV']['verifikasiinasis_tglmasuk']);
			$model->verifikasiinasis_tglmasuk_sampaidengan=$format->formatDateTimeForDb($_REQUEST['ARLapverifikasiinasisV']['verifikasiinasis_tglmasuk_sampaidengan']);
			$model->verifikasiinasis_tglkeluar=$format->formatDateTimeForDb($_REQUEST['ARLapverifikasiinasisV']['verifikasiinasis_tglkeluar']);
			$model->verifikasiinasis_tglkeluar_sampaidengan=$format->formatDateTimeForDb($_REQUEST['ARLapverifikasiinasisV']['verifikasiinasis_tglkeluar_sampaidengan']);
        }

        $caraPrint = $_REQUEST['caraPrint'];
        $target = $this->path_view.'Print';

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