<?php

class LaporanPermintaanPembelianController extends MyAuthController{
	
	
	public function actionLaporanPermintaanPembelian()
	{
		$model = new ADPermintaanPembelianT;
		$format = new MyFormatter();
		$model->unsetAttributes();
		$model->jns_periode = "hari";
		$model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
		$model->tgl_akhir = date('Y-m-d');
		$model->bln_awal = date('Y-m', strtotime('first day of january'));
		$model->bln_akhir = date('Y-m');
		$model->thn_awal = date('Y');
		$model->thn_akhir = date('Y');

		if (isset($_GET['ADPermintaanPembelianT'])) {
			$format = new MyFormatter;
			$model->attributes = $_GET['ADPermintaanPembelianT'];
			$model->jns_periode = $_GET['ADPermintaanPembelianT']['jns_periode'];
			$model->tgl_awal = $format->formatDateTimeForDb($_GET['ADPermintaanPembelianT']['tgl_awal']);
			$model->tgl_akhir = $format->formatDateTimeForDb($_GET['ADPermintaanPembelianT']['tgl_akhir']);
			$model->bln_awal = $format->formatMonthForDb($_GET['ADPermintaanPembelianT']['bln_awal']);
			$model->bln_akhir = $format->formatMonthForDb($_GET['ADPermintaanPembelianT']['bln_akhir']);
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
		$this->render('index',array(
			'model'=>$model,'format'=>$format
		));
	}

	public function actionPrintLaporanPermintaanPembelian() {
		$model = new ADPermintaanPembelianT('search');
		$judulLaporan = 'Laporan Permintaan Pembelian';
		$format = new MyFormatter();
		$model->unsetAttributes();
		$model->jns_periode = "hari";
		$model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
		$model->tgl_akhir = date('Y-m-d');
		$model->bln_awal = date('Y-m', strtotime('first day of january'));
		$model->bln_akhir = date('Y-m');
		$model->thn_awal = date('Y');
		$model->thn_akhir = date('Y');

		//Data Grafik
		$data['title'] = 'Grafik Laporan Permintaan Pembelian';
		$data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : null);
		if (isset($_REQUEST['ADPermintaanPembelianT'])) {
			$model->attributes = $_REQUEST['ADPermintaanPembelianT'];
			$model->jns_periode = $_REQUEST['ADPermintaanPembelianT']['jns_periode'];
			$model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['ADPermintaanPembelianT']['tgl_awal']);
			$model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['ADPermintaanPembelianT']['tgl_akhir']);
			$model->bln_awal = $format->formatMonthForDb($_REQUEST['ADPermintaanPembelianT']['bln_awal']);
			$model->bln_akhir = $format->formatMonthForDb($_REQUEST['ADPermintaanPembelianT']['bln_akhir']);
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
		$target = 'Print';

		$this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
	}
	public function actionPrintDetailLaporanPermintaanPembelian($id = null, $idPembelian = null) {
		$model = new ADPermintaanPembelianT();
		$modDetail = ADPermintaanDetailT::model()->findAllByAttributes(array('permintaanpembelian_id'=>$idPembelian));
		$judulLaporan = 'Laporan Permintaan Pembelian';

		//Data Grafik
		$data['title'] = 'Grafik Laporan Permintaan Pembelian';
		$data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : null);
		if (isset($_REQUEST['ADPermintaanPembelianT'])) {
			$model->attributes = $_REQUEST['ADPermintaanPembelianT'];
			$format = new MyFormatter();
			$model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['ADPermintaanPembelianT']['tgl_awal']);
			$model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['ADPermintaanPembelianT']['tgl_akhir']);
		}

		$caraPrint = (isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null);
		$target = 'detailPrint';

		$format = new MyFormatter();
		$periode = $this->parserTanggal($model->tgl_awal).' s/d '.$this->parserTanggal($model->tgl_akhir);

		$this->layout = '//layouts/printWindows';
		$this->render($target, array('model' => $model, 'modDetail'=>$modDetail,'periode'=>$periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
	}

	public function actionFrameGrafikLaporanPermintaanPembelian() {
		$this->layout = '//layouts/iframe';

		$model = new ADPermintaanPembelianT;
		$format = new MyFormatter();
		$model->unsetAttributes();
		$model->jns_periode = "hari";
		$model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
		$model->tgl_akhir = date('Y-m-d');
		$model->bln_awal = date('Y-m', strtotime('first day of january'));
		$model->bln_akhir = date('Y-m');
		$model->thn_awal = date('Y');
		$model->thn_akhir = date('Y');

		//Data Grafik
		$data['title'] = 'Grafik Laporan Permintaan Pembelian';
		$data['type'] = $_GET['type'];

		if (isset($_GET['ADPermintaanPembelianT'])) {
			$format = new MyFormatter();
			$model->attributes = $_GET['ADPermintaanPembelianT'];
			$model->jns_periode = $_GET['ADPermintaanPembelianT']['jns_periode'];
			$model->tgl_awal = $format->formatDateTimeForDb($_GET['ADPermintaanPembelianT']['tgl_awal']);
			$model->tgl_akhir = $format->formatDateTimeForDb($_GET['ADPermintaanPembelianT']['tgl_akhir']);
			$model->bln_awal = $format->formatMonthForDb($_GET['ADPermintaanPembelianT']['bln_awal']);
			$model->bln_akhir = $format->formatMonthForDb($_GET['ADPermintaanPembelianT']['bln_akhir']);
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
			'data'=>$data,
		));
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
        } else if ((isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null) == 'PDF') {
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
	protected function parserTanggal($tgl){
        $tgl = date('Y-m-d h:i:s',strtotime($tgl));
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