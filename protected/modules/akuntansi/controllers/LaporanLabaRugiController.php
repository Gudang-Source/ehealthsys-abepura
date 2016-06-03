<?php
class LaporanLabaRugiController extends MyAuthController{
	
	public $path_view = 'akuntansi.views.laporanLabaRugi.';
	
	public function actionIndex() {
        $model = new AKLaporanlabarugiV('searchLaporan2');
		$model->tgl_awal = date('m-d', strtotime('first day of this month'));
		$model->thn_awal = date('Y');
		
		if (isset($_GET['AKLaporanlabarugiV'])) {
			
			$model->attributes = $_GET['AKLaporanlabarugiV'];
			$format = new MyFormatter();
			$model->bulan = $_GET['AKLaporanlabarugiV']['bulan'];
			$model->thn_awal = $_GET['AKLaporanlabarugiV']['thn_awal'];
		}
		$models = $model->findAll($model->searchLaporan2());
		echo $this->render($this->path_view.'admin', array(
			'model' => $model,
			'models' => $models,
				), true
		);
    }

    public function actionPrintLaporanLabaRugi() {
        $model = new AKLaporanlabarugiV('searchLaporan2');
		$model->unsetAttributes();
		$model->tgl_awal = date('m-d', strtotime('first day of this month'));
		$model->thn_awal = date('Y');
		$judulLaporan = 'Laporan Laba Rugi';

		//Data Grafik       
		$data['title'] = 'Grafik Laporan Laba Rugi';
		isset($_REQUEST['type']) ? $data['type'] = $_REQUEST['type'] : $data['type'] = null;
		if (isset($_REQUEST['AKLaporanlabarugiV'])) {
			$model->attributes = $_REQUEST['AKLaporanlabarugiV'];
			$format = new MyFormatter();
//			$model->periodeposting_id = $_GET['AKLaporanlabarugiV']['periodeposting_id'];
			$model->bulan = $_GET['AKLaporanlabarugiV']['bulan'];
			$model->thn_awal = $_GET['AKLaporanlabarugiV']['thn_awal'];
		}
		$models = $model->findAll($model->searchLaporan2());
		$caraPrint = $_REQUEST['caraPrint'];
		$target = $this->path_view.'_print';

//		$periodeposting_id = AKPeriodepostingM::model()->findByPk($model->periodeposting_id);

//		$periode = $periodeposting_id->periodeposting_nama;

		$format = new MyFormatter();
		if ($caraPrint == 'PRINT' || $caraPrint == 'GRAFIK') {
			$this->layout = '//layouts/printWindows';
			$this->render($target, array('model' => $model, 'models' => $models,/* 'periode' => $periode, */ 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
		} else if ($caraPrint == 'EXCEL') {
			$this->layout = '//layouts/printExcel';
			$this->render($target, array('model' => $model, 'models' => $models,/* 'periode' => $periode, */'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
		} else if ($_REQUEST['caraPrint'] == 'PDF') {
			$ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');	  //Ukuran Kertas Pdf
			$posisi = Yii::app()->user->getState('posisi_kertas');		 //Posisi L->Landscape,P->Portait
			$mpdf = new MyPDF('', $ukuranKertasPDF);
			$mpdf->useOddEven = 2;
			$stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
			$mpdf->WriteHTML($stylesheet, 1);
			$mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
			$mpdf->WriteHTML($this->renderPartial($target, array('model' => $model, 'models' => $models,/* 'periode' => $periode, */ 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
			$mpdf->Output();
		}
	}
}