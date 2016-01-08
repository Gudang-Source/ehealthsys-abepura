<?php

class LaporanController extends MyAuthController {

	public $path_view = 'manajemenAset.views.laporan.';

	public function actionLaporanPenyusutanAset() {
        $model = new MALaporanpenyusutanasetV();
        $model->tgl_awal = date('d M Y');
        $model->tgl_akhir = date('d M Y');
//        if (isset($_GET['MALaporanpenyusutanasetV'])) {
//            $model->attributes = $_GET['MALaporanpenyusutanasetV'];
//            $format = new MyFormatter();
//            $model->tgl_awal = $format->formatDateTimeForDb($_GET['MALaporanpenyusutanasetV']['tgl_awal']);
//            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['MALaporanpenyusutanasetV']['tgl_akhir']);
//        }
        if (Yii::app()->request->isAjaxRequest) {
			$modPenyusutans = $model->getPenyusutan();
			echo $this->renderPartial($this->path_view.'penyusutanAset._table', array('model'=>$model,'modPenyusutans'=>$modPenyusutans),true);
		}else{
			$this->render($this->path_view.'penyusutanAset/admin', array('model' => $model,));
		}

       
    }

	public function actionLaporanReevaluasiAset() {
			$this->pageTitle = Yii::app()->name." - Laporan Re-evaluasi Aset";
			$model = new MALaporanreevaluasiasetV('Search');
			$format = new MyFormatter();
			$model->unsetAttributes();
			$model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
			$model->tgl_akhir = date('Y-m-d');


			if (isset($_GET['MALaporanreevaluasiasetV'])) {
				$model->attributes = $_GET['MALaporanreevaluasiasetV'];            
				$model->tgl_awal = $format->formatDateTimeForUser($_GET['MALaporanreevaluasiasetV']['tgl_awal']);
				$model->tgl_akhir = $format->formatDateTimeForUser($_GET['MALaporanreevaluasiasetV']['tgl_akhir']);

				$model->tgl_awal = $model->tgl_awal." 00:00:00";
				$model->tgl_akhir = $model->tgl_akhir." 23:59:59";
			}

			$this->render($this->path_view.'reevaluasiAset/index', array(
				'model' => $model,'format'=>$format
			));
	}

   public function actionPrintReevaluasi() {
		$model = new MALaporanreevaluasiasetV('search');
		$format = new MyFormatter();
		$model->unsetAttributes();
		$model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
		$model->tgl_akhir = date('Y-m-d');
		$judulLaporan = 'Laporan Re-Evaluasi Aset';

		//Data Grafik
		$data['title'] = 'Grafik Laporan Indikator Dokter';
		$data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : "");
		if (isset($_REQUEST['MALaporanreevaluasiasetV'])) {
			$model->attributes = $_GET['MALaporanreevaluasiasetV'];            
			$model->tgl_awal = $format->formatDateTimeForDb($_GET['MALaporanreevaluasiasetV']['tgl_awal']);
			$model->tgl_akhir = $format->formatDateTimeForDb($_GET['MALaporanreevaluasiasetV']['tgl_akhir']);
			$model->tgl_awal = $model->tgl_awal." 00:00:00";
			$model->tgl_akhir = $model->tgl_akhir." 23:59:59";
		}

		$caraPrint = $_REQUEST['caraPrint'];
		$target = $this->path_view.'reevaluasiAset/_printReevaluasi';

		$this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
	}	

	public function actionPrintLaporanPenyusutanAset() {
        $model = new RJLaporansensusharian('search');
        $ruanganId = Yii::app()->user->getState('ruangan_id');
        $ruanganNama = RuanganM::model()->findByPk($ruanganId);
        $judulLaporan = 'Laporan Sensus Harian Rawat Jalan <br/> '.$ruanganNama->ruangan_nama.'';

        //Data Grafik
        $data['title'] = 'Grafik Laporan Sensus Harian';
        $data['type'] = isset($_REQUEST['type'])?$_REQUEST['type']:null;
        if (isset($_REQUEST['RJLaporansensusharian'])) {
            $model->attributes = $_REQUEST['RJLaporansensusharian'];
            $format = new MyFormatter();
            $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['RJLaporansensusharian']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['RJLaporansensusharian']['tgl_akhir']);
        }
               
        $caraPrint = $_REQUEST['caraPrint'];
        $target = $this->path_view.'sensus/_print';
        
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
			$mpdf->useOddEven = 2;
			$stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
			$mpdf->WriteHTML($stylesheet, 1);
			$mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
			$mpdf->WriteHTML($this->renderPartial($target, array('model' => $model, 'periode'=>$periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
			$mpdf->Output();
		}
	}


}