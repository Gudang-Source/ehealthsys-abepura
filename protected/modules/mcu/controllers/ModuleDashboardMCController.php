<?php

Yii::import("pendaftaranPenjadwalan.controllers.ModuleDashboardNeonController");
Yii::import("pendaftaranPenjadwalan.models.*");

class ModuleDashboardMCController extends ModuleDashboardNeonController {

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
		$dataKolom = array();
		$dataAreaChart = array();
		$dataLineChart = array();
		$dataDonutChart = array();
		$dataPieChart = array();
		$dataBarChart = array();

		$sql = "SELECT COUNT(pendaftaran_id) AS jumlah
				FROM pendaftaran_t
				WHERE DATE(tgl_pendaftaran) = '" . date('Y-m-d') . "'
					AND ruangan_id = 25";
		$result = Yii::app()->db->createCommand($sql)->queryRow();
		$dataKolom[1] = $result['jumlah'];

		$sql = "SELECT COUNT(pasiendirujukkeluar_t.pasiendirujukkeluar_id) AS jumlah
				FROM pasiendirujukkeluar_t
				JOIN pendaftaran_t ON pasiendirujukkeluar_t.pendaftaran_id = pendaftaran_t.pendaftaran_id
				WHERE DATE(pasiendirujukkeluar_t.tgldirujuk) = '" . date('Y-m-d') . "'
					AND pendaftaran_t.ruangan_id = 25";
		$result = Yii::app()->db->createCommand($sql)->queryRow();
		$dataKolom[2] = $result['jumlah'];

		$sql = "SELECT COUNT(buatjanjipoli_id) AS jumlah
				FROM buatjanjipoli_t
				WHERE DATE(tglbuatjanji) = '" . date('Y-m-d') . "'
					AND ruangan_id = 25";
		$result = Yii::app()->db->createCommand($sql)->queryRow();
		$dataKolom[3] = $result['jumlah'];

		$sql = "SELECT COUNT(pengajuangantikm_id) AS jumlah
				FROM pengajuangantikm_t
				WHERE DATE(tglpengajuan_km) = '" . date('Y-m-d') . "'";
		$result = Yii::app()->db->createCommand($sql)->queryRow();
		$dataKolom[4] = $result['jumlah'];

		//=== end 4 kolom ===
		//=== chart ===
		$sql = "SELECT DATE(tgl_pendaftaran) as tgl_pendaftaran, count(pendaftaran_id) as jumlah
				FROM pendaftaran_t
				WHERE DATE(tgl_pendaftaran) BETWEEN '" . date("Y-m") . "-01' AND '" . date("Y-m-d") . "'
					AND ruangan_id = 25
				GROUP BY DATE(tgl_pendaftaran)
				ORDER BY tgl_pendaftaran ASC";
		$result = Yii::app()->db->createCommand($sql)->queryAll();

		$dataAreaChart = $result;
		//=== chart ===
		$sql = "SELECT DATE(tgl_pendaftaran) as tgl_pendaftaran, count(pendaftaran_id) as jumlah_1
				FROM pendaftaran_t
				WHERE DATE(tgl_pendaftaran) BETWEEN '" . date("Y-m") . "-01' AND '" . date("Y-m-d") . "'
					AND ruangan_id = 25
					AND statuspasien = 'PENGUNJUNG BARU'
				GROUP BY DATE(tgl_pendaftaran)
				ORDER BY tgl_pendaftaran ASC";
		$result_1 = Yii::app()->db->createCommand($sql)->queryAll();
		$sql = "SELECT DATE(tgl_pendaftaran) as tgl_pendaftaran, count(pendaftaran_id) as jumlah_2
				FROM pendaftaran_t
				WHERE DATE(tgl_pendaftaran) BETWEEN '" . date("Y-m") . "-01' AND '" . date("Y-m-d") . "'
					AND ruangan_id = 25
					AND statuspasien = 'PENGUNJUNG LAMA'
				GROUP BY DATE(tgl_pendaftaran)
				ORDER BY tgl_pendaftaran ASC";
		$result_2 = Yii::app()->db->createCommand($sql)->queryAll();
		$sql = "SELECT DATE(tgl_pendaftaran) as tgl_pendaftaran, count(pendaftaran_id) as jumlah_3
				FROM pendaftaran_t
				WHERE DATE(tgl_pendaftaran) BETWEEN '" . date("Y-m") . "-01' AND '" . date("Y-m-d") . "'
					AND ruangan_id = 25
					AND kunjungan = 'KUNJUNGAN BARU'
				GROUP BY DATE(tgl_pendaftaran)
				ORDER BY tgl_pendaftaran ASC";
		$result_3 = Yii::app()->db->createCommand($sql)->queryAll();
		$sql = "SELECT DATE(tgl_pendaftaran) as tgl_pendaftaran, count(pendaftaran_id) as jumlah_4
				FROM pendaftaran_t
				WHERE DATE(tgl_pendaftaran) BETWEEN '" . date("Y-m") . "-01' AND '" . date("Y-m-d") . "'
					AND ruangan_id = 25
					AND kunjungan = 'KUNJUNGAN LAMA'
				GROUP BY DATE(tgl_pendaftaran)
				ORDER BY tgl_pendaftaran ASC";
		$result_4 = Yii::app()->db->createCommand($sql)->queryAll();
		$dataLineChart = CustomFunction::joinTwo2DArrays($result_1, $result_2, 'tgl_pendaftaran');
		$dataLineChart = CustomFunction::joinTwo2DArrays($result_3, $result_4, 'tgl_pendaftaran');

		$sql = "SELECT pendaftaran_t.ruangan_id, ruangan_m.ruangan_nama,DATE(konsulpoli_t.tglkonsulpoli) as tglkonsulpoli, count(konsulpoli_t.pendaftaran_id) as jumlah
				FROM pendaftaran_t
				JOIN konsulpoli_t ON pendaftaran_t.pendaftaran_id = konsulpoli_t.pendaftaran_id
				JOIN ruangan_m ON pendaftaran_t.ruangan_id = ruangan_m.ruangan_id
					WHERE pendaftaran_t.ruangan_id = 25
					AND konsulpoli_t.create_ruangan = 25
					AND DATE(konsulpoli_t.tglkonsulpoli) BETWEEN '" . date("Y-m") . "-01' AND '" . date("Y-m-d") . "'
				GROUP BY DATE(tglkonsulpoli), pendaftaran_t.ruangan_id, ruangan_m.ruangan_nama
				ORDER BY tglkonsulpoli ASC";
		$result = Yii::app()->db->createCommand($sql)->queryAll();
		$dataDonutChart = $result;

//		$sql = "SELECT carabayar_nama, count(pendaftaran_id) as jumlah
//				FROM laporankunjunganrs_v
//				WHERE DATE(tgl_pendaftaran) BETWEEN '".date("Y-m")."-01' AND '".date("Y-m-d")."'
//					AND (
//						instalasi_id = ".Params::INSTALASI_ID_RJ."
//						OR instalasi_id = ".Params::INSTALASI_ID_RD."
//						OR instalasi_id = ".Params::INSTALASI_ID_RI."
//					)
//				GROUP BY carabayar_nama
//				ORDER BY carabayar_nama ASC";
		// LNG-1
		$sql = "
				SELECT carabayar_m.carabayar_nama as carabayar_nama, count(pendaftaran_t.pendaftaran_id) as jumlah
				FROM pendaftaran_t
				JOIN carabayar_m ON pendaftaran_t.carabayar_id = carabayar_m.carabayar_id
				WHERE DATE(pendaftaran_t.tgl_pendaftaran) BETWEEN '" . date("Y-m") . "-01' AND '" . date("Y-m-d") . "'
				AND ruangan_id = 25					
				GROUP BY carabayar_nama
				";
		$result = Yii::app()->db->createCommand($sql)->queryAll();
		$dataPieChart = $result;

		$sql = "SELECT COUNT(gantikacamata_id) AS jumlah
				FROM gantikacamata_t
				WHERE DATE(tglgantikacamata) BETWEEN '" . date("Y-m") . "-01' AND '" . date("Y-m-d") . "'";
		$result = Yii::app()->db->createCommand($sql)->queryRow();
		$dataKolom[5] = $result['jumlah'];

		$sql = "SELECT COUNT(pengajuangantikm_id) AS jumlah
				FROM pengajuangantikm_t
				WHERE DATE(tglpengajuan_km) BETWEEN '" . date("Y-m") . "-01' AND '" . date("Y-m-d") . "'";
		$result = Yii::app()->db->createCommand($sql)->queryRow();
		$dataKolom[6] = $result['jumlah'];

		$sql = "SELECT diagnosa_nama, count(tglmorbiditas) as jumlah
				FROM laporan10besarpenyakit_v
				WHERE DATE(tglmorbiditas) BETWEEN '" . date("Y-m") . "-01' AND '" . date("Y-m-d") . "'
				GROUP BY diagnosa_nama
				ORDER BY jumlah DESC
				LIMIT 10";
		$result = Yii::app()->db->createCommand($sql)->queryAll();
		$dataBarChart = $result;

		//=== end chart ===
		//=== start table ===
		$criteria_updatepasien = new CDbCriteria();
		$criteria_updatepasien->limit = 5;
		$criteria_updatepasien->order = 'tgldirujuk DESC';
		$dataTable = MCPasiendirujukkeluarT::model()->findAll($criteria_updatepasien);


		$dataTable = new MCPasiendirujukkeluarT("searchRiwayatPasien");

		//=== end table ===
		//=== start todo list ===
		$modTodolist = new MCTodolistR();
		$dataProviderTodolist = $modTodolist->searchTodolistWidget();
		//=== end todo list ===
		//=== start map ===
		$sql = "SELECT kecamatan_m.kecamatan_id,kecamatan_m.kecamatan_nama,kecamatan_m.longitude, kecamatan_m.latitude,pasien_m.garis_latitude,pasien_m.garis_longitude, count(pendaftaran_t.pendaftaran_id) as jumlah
				FROM pendaftaran_t
				JOIN pasien_m ON pendaftaran_t.pasien_id = pasien_m.pasien_id
				JOIN kecamatan_m ON pasien_m.kecamatan_id = kecamatan_m.kecamatan_id
				WHERE pendaftaran_t.ruangan_id = 25 AND DATE(pendaftaran_t.tgl_pendaftaran) BETWEEN '" . date("Y-m") . "-01' AND '" . date("Y-m-d") . "'
				GROUP BY kecamatan_m.kecamatan_id,kecamatan_m.kecamatan_nama, kecamatan_m.longitude, kecamatan_m.latitude,pasien_m.garis_latitude,pasien_m.garis_longitude
				ORDER BY jumlah DESC
				LIMIT 10
				";
		$result = Yii::app()->db->createCommand($sql)->queryAll();
		$dataMap = $result;
		$modPropinsi = PropinsiM::model()->findByPk(Yii::app()->user->getState('propinsi_id'));
		//=== end map ===

		$this->render('dashboard', array(
			'dataKolom' => $dataKolom,
			'dataAreaChart' => $dataAreaChart,
			'dataLineChart' => $dataLineChart,
			'dataDonutChart' => $dataDonutChart,
			'dataPieChart' => $dataPieChart,
			'dataBarChart' => $dataBarChart,
			'dataTable' => $dataTable,
			'modTodolist' => $modTodolist,
			'dataProviderTodolist' => $dataProviderTodolist,
			'dataMap' => $dataMap,
			'modPropinsi' => $modPropinsi,
		));
	}

	/**
	 * menampilkan form antrian dari request ajax
	 * @param type $record
	 * @param type $noantrian
	 * @throws CHttpException
	 */
	public function actionSetFormTodolist() {
		if (Yii::app()->request->isAjaxRequest) {
			$data = array();
			$data['pesan'] = "";
			$todolist_id = (isset($_POST['todolist_id']) ? $_POST['todolist_id'] : null);
			if (!empty($todolist_id)) { //antrian baru
				$modTodolist = MCTodolistR::model()->findByPk($todolist_id);
			} else {
				$data['pesan'] = 'tidak ditemukan';
			}
			$data['form_todolist'] = $this->renderPartial($this->path_view . '_formTodolist', array('modTodolist' => $modTodolist), true);
			echo CJSON::encode($data);
			Yii::app()->end();
		} else
			throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * menyimpan data todolist by ajax
	 * @throws CHttpException
	 */
	public function actionSimpanTodolist() {
		if (Yii::app()->request->isAjaxRequest) {
			parse_str($_POST['isi'], $isi);

			$data = array();
			$data['pesan'] = "";



			// echo "<pre>"; print_r($isi['PPTodolistR']['todolist_id']);exit();

			$IdTodolist = isset($isi['PPTodolistR']['todolist_id']) ? $isi['MCTodolistR']['todolist_id'] : '';

			if (empty($IdTodolist)) { //antrian baru
				$modTodolist = new MCTodolistR;
				$modTodolist->todolist_nama = isset($isi['MCTodolistR']['todolist_nama']) ? $isi['MCTodolistR']['todolist_nama'] : '';
				$modTodolist->todolist_aktif = isset($isi['MCTodolistR']['todolist_aktif']) ? $isi['MCTodolistR']['todolist_aktif'] : true;
				$modTodolist->tgltodolist = isset($isi['MCTodolistR']['tgltodolist_new']) ? MyFormatter::formatDateTimeForDb($isi['MCTodolistR']['tgltodolist_new']) : date('Y-m-d');
				$modTodolist->create_time = date('Y-m-d');
				$modTodolist->create_loginpemakai_id = Yii::app()->user->id;
				$modTodolist->create_ruangan_id = Yii::app()->user->getState('ruangan_id');
				$modTodolist->create_modul_id = Yii::app()->session['modul_id'];
				$simpan = $modTodolist->save();
				if ($simpan) {
					$data['pesan'] = 'Todolist Berhasil Disimpan!';
				} else {
					$data['pesan'] = 'Todolist Gagal Disimpan!';
				}
			} else {
				$modTodolist = PPTodolistR::model()->findByPk($IdTodolist);
				$modTodolist->todolist_nama = isset($isi['MCTodolistR']['todolist_nama']) ? $isi['MCTodolistR']['todolist_nama'] : '';
				$modTodolist->todolist_aktif = isset($isi['MCTodolistR']['todolist_aktif']) ? $isi['MCTodolistR']['todolist_aktif'] : true;
				$modTodolist->tgltodolist = isset($isi['MCTodolistR']['tgltodolist']) ? MyFormatter::formatDateTimeForDb($isi['MCTodolistR']['tgltodolist']) : date('Y-m-d');
				$modTodolist->update_time = date('Y-m-d');
				$modTodolist->update_loginpemakai_id = Yii::app()->user->id;

				$update = $modTodolist->update();
				if ($update) {
					$data['pesan'] = 'Todolist Berhasil Diubah!';
				} else {
					$data['pesan'] = 'Todolist Gagal Diubah!';
				}
			}
			$data['form_todolist'] = $this->renderPartial($this->path_view . '_formTodolist', array('modTodolist' => $modTodolist), true);
			echo CJSON::encode($data);
			Yii::app()->end();
		} else
			throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * update by ajax
	 * @throws CHttpException
	 */
	public function actionUpdateTodolist() {
		if (Yii::app()->request->isAjaxRequest) {
			parse_str($_POST['isi'], $isi);

			$data = array();
			$data['pesan'] = "";

			$IdTodolist = isset($isi['MCTodolistR']['todolist_id']) ? $isi['MCTodolistR']['todolist_id'] : '';

			if (empty($IdTodolist)) { //antrian baru
				$modTodolist = new PPTodolistR;
				$modTodolist->todolist_nama = isset($isi['MCTodolistR']['todolist_nama']) ? $isi['MCTodolistR']['todolist_nama'] : '';
				$modTodolist->todolist_aktif = isset($isi['MCTodolistR']['todolist_aktif']) ? $isi['MCTodolistR']['todolist_aktif'] : true;
				$modTodolist->tgltodolist = isset($isi['MCTodolistR']['tgltodolist']) ? MyFormatter::formatDateTimeForDb($isi['MCTodolistR']['tgltodolist']) : date('Y-m-d');
				$modTodolist->create_time = date('Y-m-d');
				$modTodolist->create_loginpemakai_id = Yii::app()->user->id;
				$modTodolist->create_ruangan_id = Yii::app()->user->getState('ruangan_id');
				$modTodolist->create_modul_id = Yii::app()->session['modul_id'];
				$simpan = $modTodolist->save();
				if ($simpan) {
					$data['pesan'] = 'Todolist Berhasil Disimpan!';
				} else {
					$data['pesan'] = 'Todolist Gagal Disimpan!';
				}
			} else {
				$modTodolist = MCTodolistR::model()->findByPk($IdTodolist);
				$modTodolist->todolist_nama = isset($isi['MCTodolistR']['todolist_nama']) ? $isi['MCTodolistR']['todolist_nama'] : '';
				$modTodolist->todolist_aktif = isset($isi['MCTodolistR']['todolist_aktif']) ? $isi['MCTodolistR']['todolist_aktif'] : true;
				$modTodolist->tgltodolist = isset($isi['MCTodolistR']['tgltodolist']) ? MyFormatter::formatDateTimeForDb($isi['MCTodolistR']['tgltodolist']) : date('Y-m-d');
				$modTodolist->update_time = date('Y-m-d');
				$modTodolist->update_loginpemakai_id = Yii::app()->user->id;

				$update = $modTodolist->update();
				if ($update) {
					$data['pesan'] = 'Todolist Berhasil Diubah!';
				} else {
					$data['pesan'] = 'Todolist Gagal Diubah!';
				}
			}
			$data['form_todolist'] = $this->renderPartial($this->path_view . '_formTodolist', array('modTodolist' => $modTodolist), true);
			echo CJSON::encode($data);
			Yii::app()->end();
		} else
			throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * hapus todo list ajax dari tombol di widget
	 * @throws CHttpException
	 */
	public function actionHapusTodolist() {
		if (Yii::app()->request->isAjaxRequest) {
			$data = array();
			$data['pesan'] = "";
			$todolist_id = (isset($_POST['todolist_id']) ? $_POST['todolist_id'] : null);
			if (!empty($todolist_id)) { //antrian baru
				$modTodolist = MCTodolistR::model()->deleteByPk($todolist_id);
				$data['pesan'] = 'Data Berhasil Dihapus';
			} else {
				$data['pesan'] = 'Data Gagal Dihapus';
			}
			echo CJSON::encode($data);
			Yii::app()->end();
		} else
			throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * ubah todolist ajax dari widget
	 * @throws CHttpException
	 */
	public function actionUbahStatusTodolist() {
		if (Yii::app()->request->isAjaxRequest) {
			$data = array();
			$data['pesan'] = "";
			$todolist_id = (isset($_POST['todolist_id']) ? $_POST['todolist_id'] : null);
			if (!empty($todolist_id)) { //antrian baru
				$modTodolist = MCTodolistR::model()->findByPk($todolist_id);
				$modTodolist->todolist_aktif = false;
				$update = $modTodolist->update();
				if ($update) {
					$data['pesan'] = 'Status Todolist Berhasil Diubah!';
				} else {
					$data['pesan'] = 'Status Todolist Gagal Diubah!';
				}
			} else {
				$data['pesan'] = 'Status Todolist Gagal Diubah!';
			}
			echo CJSON::encode($data);
			Yii::app()->end();
		} else
			throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
	}

}

?>