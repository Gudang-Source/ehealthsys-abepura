<?php
class LaporanNeracaController extends MyAuthController{
	
	public $path_view = 'akuntansi.views.laporanNeraca.';
	
	public function actionIndex() {
        $model = new AKLaporanneracaV('searchLaporan2');
		$model->tgl_awal = date('m-d', strtotime('first day of this month'));
		$model->thn_awal = date('Y');
		
		if (isset($_GET['AKLaporanneracaV'])) {
			
			$model->attributes = $_GET['AKLaporanneracaV'];
			$format = new MyFormatter();
			$model->bulan = $_GET['AKLaporanneracaV']['bulan'];
			$model->thn_awal = $_GET['AKLaporanneracaV']['thn_awal'];
		}
		$models = $model->findAll($model->searchLaporan2());
		echo $this->render($this->path_view.'admin', array(
			'model' => $model,
			'models' => $models,
				), true
		);
    }

    public function actionPrintLaporanLabaRugi() {
        $model = new AKLaporanneracaV('searchLaporan2');
		$model->unsetAttributes();
		$model->tgl_awal = date('m-d', strtotime('first day of this month'));
		$model->thn_awal = date('Y');
		$judulLaporan = 'Laporan Neraca';

		//Data Grafik       
		$data['title'] = 'Grafik Laporan Neraca';
		isset($_REQUEST['type']) ? $data['type'] = $_REQUEST['type'] : $data['type'] = null;
		if (isset($_REQUEST['AKLaporanneracaV'])) {
			$model->attributes = $_REQUEST['AKLaporanneracaV'];
			$format = new MyFormatter();
//			$model->periodeposting_id = $_GET['AKLaporanlabarugiV']['periodeposting_id'];
			$model->bulan = $_GET['AKLaporanneracaV']['bulan'];
			$model->thn_awal = $_GET['AKLaporanneracaV']['thn_awal'];
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