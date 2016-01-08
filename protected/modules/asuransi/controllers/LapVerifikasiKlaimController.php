<?php
class LapVerifikasiKlaimController extends MyAuthController{
	
	public $defaultAction = 'index';
	public $path_view = 'asuransi.view.lapVerifikasiKlaim.';
	
	public function actionIndex(){
		$format = new MyFormatter();
		$model=new ARLapveriklaiminasisR();
		$model->unsetAttributes();
		$model->tgl_awal = date('d M Y');
		$model->tgl_akhir = date('d M Y');
		
		if(isset($_GET['ARLapveriklaiminasisR'])){
				$model->attributes=$_GET['ARLapveriklaiminasisR'];
				$model->tgl_awal=$format->formatDateTimeForDb($_GET['ARLapveriklaiminasisR']['tgl_awal']);
				$model->tgl_akhir=$format->formatDateTimeForDb($_GET['ARLapveriklaiminasisR']['tgl_akhir']);
		}
		
		$this->render($this->path_view.'index',array(
			'format'=>$format,
			'model'=>$model
		));
	}
	
	public function actionPrint(){
        $format = new MyFormatter();
        $model = new ARLapveriklaiminasisR();
        $judulLaporan = 'Laporan Verifikasi Klaim';
        //Data Grafik
        $data['title'] = 'Laporan Verifikasi Klaim';
        $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : null);
        if (isset($_REQUEST['ARLapveriklaiminasisR'])) {
            $model->attributes = $_REQUEST['ARLapveriklaiminasisR'];
            $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['ARLapveriklaiminasisR']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['ARLapveriklaiminasisR']['tgl_akhir']);
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