<?php

class RujukanPasienController extends MyAuthController {

	public $path_view = 'sistemInformasiEksekutif.views.rujukanPasien.';

	public function actionIndex() {
		$this->render('index');
	}

	/**
	 * menampilkan halaman dashboard (iframe)
	 * beberapa menggunakan DAO (createCommand) agar lebih cepat
	 */
	public function actionSetIFrameDashboard() {

		$this->layout = '//layouts/iframeNeon';
		$format = new MyFormatter();
		//=== start 4 kolom ===
		$dataPie = array();
		$dataPieChart = array();
		$dataBarLineChart = array();

		$format = new MyFormatter();
		$model = new SERujukanpasienR();
		$model->unsetAttributes();
		$model->jns_periode = "hari";
		$model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
		$model->tgl_akhir = date('Y-m-d');
		$model->bln_awal = date('Y-m', strtotime('first day of january'));
		$model->bln_akhir = date('Y-m');
		$model->thn_awal = date('Y');
		$model->thn_akhir = date('Y');

		if (isset($_GET['SERujukanpasienR'])) {
			$model->attributes = $_GET['SERujukanpasienR'];
			$model->jns_periode = $_GET['SERujukanpasienR']['jns_periode'];
			$model->tgl_awal = $format->formatDateTimeForDb($_GET['SERujukanpasienR']['tgl_awal']);
			$model->tgl_akhir = $format->formatDateTimeForDb($_GET['SERujukanpasienR']['tgl_akhir']);
			$model->bln_awal = $format->formatMonthForDb($_GET['SERujukanpasienR']['bln_awal']);
			$model->bln_akhir = $format->formatMonthForDb($_GET['SERujukanpasienR']['bln_akhir']);
			$bln_akhir = $model->bln_akhir . "-" . date("t", strtotime($model->bln_akhir));
			$model->thn_awal = $_GET['SERujukanpasienR']['thn_awal'];
			$model->thn_akhir = $_GET['SERujukanpasienR']['thn_akhir'];
			$thn_akhir = $model->thn_akhir . "-" . date("m-t", strtotime($model->thn_akhir . "-12"));
			switch ($model->jns_periode) {
				case 'bulan' : $model->tgl_awal = $model->bln_awal . "-01";
					$model->tgl_akhir = $bln_akhir;
					break;
				case 'tahun' : $model->tgl_awal = $model->thn_awal . "-01-01";
					$model->tgl_akhir = $thn_akhir;
					break;
				default : null;
			}
			$model->tgl_awal = $model->tgl_awal . " 00:00:00";
			$model->tgl_akhir = $model->tgl_akhir . " 23:59:59";
		}
		//=== chart ===
		switch ($model->jns_periode) {
			case 'bulan' : $sql = "
										SELECT 
										date_trunc('month', tanggal) as periode, sum(rujukanrs) as jumlah_rs, sum(rujukanklinik) as jumlah_klinik, sum(rujukandokter) jumlah_dokter, sum(rujukanpuskesmas) jumlah_puskesmas
										FROM rujukanpasien_r
										WHERE DATE(tanggal) BETWEEN '" . $model->tgl_awal . "' AND '" . $model->tgl_akhir . "'
										GROUP BY periode
										ORDER BY periode ASC
									";
				break;
			case 'tahun' : $sql = "
										SELECT 
										date_trunc('year', tanggal) as periode, sum(rujukanrs) as jumlah_rs, sum(rujukanklinik) as jumlah_klinik, sum(rujukandokter) jumlah_dokter, sum(rujukanpuskesmas) jumlah_puskesmas
										FROM rujukanpasien_r
										WHERE DATE(tanggal) BETWEEN '" . $model->tgl_awal . "' AND '" . $model->tgl_akhir . "'
										GROUP BY periode
										ORDER BY periode ASC

									";
				break;
			default : $sql = "
										SELECT 
										date_trunc('day', tanggal) as periode, sum(rujukanrs) as jumlah_rs, sum(rujukanklinik) as jumlah_klinik, sum(rujukandokter) jumlah_dokter, sum(rujukanpuskesmas) jumlah_puskesmas
										FROM rujukanpasien_r
										WHERE DATE(tanggal) BETWEEN '" . $model->tgl_awal . "' AND '" . $model->tgl_akhir . "'
										GROUP BY periode
										ORDER BY periode ASC

									";
		}

		$result = Yii::app()->db->createCommand($sql)->queryAll();
		$dataBarLineChart = $result;

		$sql = "
				SELECT 
				sum(rujukanrs) as jumlah_rs, sum(rujukanklinik) as jumlah_klinik, sum(rujukandokter) jumlah_dokter, sum(rujukanpuskesmas) jumlah_puskesmas
				FROM rujukanpasien_r
				WHERE DATE(tanggal) BETWEEN '" . $model->tgl_awal . "' AND '" . $model->tgl_akhir . "'
				";


		$result = Yii::app()->db->createCommand($sql)->queryRow();
		$dataPie = $result;

		foreach ($dataPie as $key => $value) {
			if ($key == "jumlah_rs") {
				$key = "Rumah Sakit";
			} elseif ($key == "jumlah_klinik") {
				$key = "Klinik";
			} elseif ($key == "jumlah_dokter") {
				$key = "Dokter";
			}else {
				$key = "Puskesmas";
			}
			$temp['jenis'] = $key;
			$temp['jumlah'] = $value;

			array_push($dataPieChart, $temp);
		}
		//=== end chart ===
		//=== start table ===
		$criteria = new CDbCriteria;

		switch ($model->jns_periode) {
			case 'bulan' : $criteria->select = array('date_trunc(' . "'month'" . ', tanggal) as periode, sum(rujukanrs) as jumlah_rs, sum(rujukanklinik) as jumlah_klinik, sum(rujukandokter) jumlah_dokter, sum(rujukanpuskesmas) jumlah_puskesmas');
				$criteria->addBetweenCondition('DATE(tanggal)', $model->tgl_awal, $model->tgl_akhir);
				$criteria->group = 'periode';
				$criteria->order = 'periode ASC';
				break;
			case 'tahun' : $criteria->select = array('date_trunc(' . "'year'" . ', tanggal) as periode, sum(rujukanrs) as jumlah_rs, sum(rujukanklinik) as jumlah_klinik, sum(rujukandokter) jumlah_dokter, sum(rujukanpuskesmas) jumlah_puskesmas');
				$criteria->addBetweenCondition('DATE(tanggal)', $model->tgl_awal, $model->tgl_akhir);
				$criteria->group = 'periode';
				$criteria->order = 'periode ASC';
				break;
			default : $criteria->select = array('date_trunc(' . "'day'" . ', tanggal) as periode, sum(rujukanrs) as jumlah_rs, sum(rujukanklinik) as jumlah_klinik, sum(rujukandokter) jumlah_dokter, sum(rujukanpuskesmas) jumlah_puskesmas');
				$criteria->addBetweenCondition('DATE(tanggal)', $model->tgl_awal, $model->tgl_akhir);
				$criteria->group = 'periode';
				$criteria->order = 'periode ASC';
		}

		$dataTable = new CActiveDataProvider($model, array(
			'criteria' => $criteria
		));

		//=== end table ===

		$model->tgl_awal = $format->formatDateTimeForUser(date('Y-m-d', (strtotime($model->tgl_awal))));
		$model->tgl_akhir = $format->formatDateTimeForUser(date('Y-m-d', (strtotime($model->tgl_akhir))));
		$model->bln_awal = $format->formatMonthForUser(date('Y-m', (strtotime($model->bln_awal))));
		$model->bln_akhir = $format->formatMonthForUser(date('Y-m', (strtotime($model->bln_akhir))));

		$this->render('dashboard', array(
			'model' => $model,
			'dataBarLineChart' => $dataBarLineChart,
			'dataPieChart' => $dataPieChart,
			'dataTable' => $dataTable
		));
	}

}

?>