<?php

Yii::import("pendaftaranPenjadwalan.controllers.ModuleDashboardNeonController");
Yii::import("pendaftaranPenjadwalan.models.*");

class ModuleDashboardMAController extends ModuleDashboardNeonController {

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

		$sql = "SELECT COUNT(invtanah_id) AS jumlah
				FROM invtanah_t
				WHERE DATE(create_time) = '" . date('Y-m-d') . "'";
		$result = Yii::app()->db->createCommand($sql)->queryRow();
		$dataKolom[1] = $result['jumlah'];

		$sql = "SELECT COUNT(invperalatan_id) AS jumlah
				FROM invperalatan_t
				WHERE DATE(create_time) = '" . date('Y-m-d') . "'";
		$result = Yii::app()->db->createCommand($sql)->queryRow();
		$dataKolom[2] = $result['jumlah'];

		$sql = "SELECT COUNT(invgedung_id) AS jumlah
				FROM invgedung_t
				WHERE DATE(create_time) = '" . date('Y-m-d') . "'";
		$result = Yii::app()->db->createCommand($sql)->queryRow();
		$dataKolom[3] = $result['jumlah'];

		$sql = "SELECT COUNT(invjalan_id) AS jumlah
				FROM invjalan_t
				WHERE DATE(craete_time) = '" . date('Y-m-d') . "'";
		$result = Yii::app()->db->createCommand($sql)->queryRow();
		$dataKolom[4] = $result['jumlah'];

		//=== end 4 kolom ===
		//=== chart ===
		$sql = "SELECT DATE(create_time) as create_time, count(invtanah_id) as jumlah_1
				FROM invtanah_t
				WHERE DATE(create_time) BETWEEN '" . date("Y-m") . "-01' AND '" . date("Y-m-d") . "'
				GROUP BY DATE(create_time)
				ORDER BY create_time ASC";
		$result_1 = Yii::app()->db->createCommand($sql)->queryAll();
		$sql = "SELECT DATE(create_time) as create_time, count(invperalatan_id) as jumlah_2
				FROM invperalatan_t
				WHERE DATE(create_time) BETWEEN '" . date("Y-m") . "-01' AND '" . date("Y-m-d") . "'
				GROUP BY DATE(create_time)
				ORDER BY create_time ASC";
		$result_2 = Yii::app()->db->createCommand($sql)->queryAll();
		$sql = "SELECT DATE(create_time) as create_time, count(invgedung_id) as jumlah_3
				FROM invgedung_t
				WHERE DATE(create_time) BETWEEN '" . date("Y-m") . "-01' AND '" . date("Y-m-d") . "'
				GROUP BY DATE(create_time)
				ORDER BY create_time ASC";
		$result_3 = Yii::app()->db->createCommand($sql)->queryAll();
		$sql = "SELECT DATE(craete_time) as create_time, count(invjalan_id) as jumlah_4
				FROM invjalan_t
				WHERE DATE(craete_time) BETWEEN '" . date("Y-m") . "-01' AND '" . date("Y-m-d") . "'
				GROUP BY DATE(craete_time)
				ORDER BY create_time ASC";
		$result_4 = Yii::app()->db->createCommand($sql)->queryAll();
		$dataAreaChart = CustomFunction::joinTwo2DArrays($result_1, $result_2, 'create_time');
		$dataAreaChart = CustomFunction::joinTwo2DArrays($dataAreaChart, $result_3, 'create_time');
		$dataAreaChart = CustomFunction::joinTwo2DArrays($dataAreaChart, $result_4, 'create_time');

		//=== chart ===
		$sql = "SELECT DATE(reevaluasiaset_tgl) as reevaluasiaset_tgl, count(reevaluasiaset_id) as jumlah_1, DATE(reevaluasiaset_tgl) as create_time
				FROM reevaluasiaset_t
				WHERE DATE(reevaluasiaset_tgl) BETWEEN '" . date("Y-m") . "-01' AND '" . date("Y-m-d") . "'
				GROUP BY DATE(reevaluasiaset_tgl)
				ORDER BY reevaluasiaset_tgl ASC";
		$result_1 = Yii::app()->db->createCommand($sql)->queryAll();
		$sql = "SELECT DATE(tgl_penyusutan) as tgl_penyusutan, count(penyusutanaset_id) as jumlah_2, DATE(tgl_penyusutan) as create_time
				FROM penyusutanaset_t
				WHERE DATE(tgl_penyusutan) BETWEEN '" . date("Y-m") . "-01' AND '" . date("Y-m-d") . "'
				GROUP BY DATE(tgl_penyusutan)
				ORDER BY tgl_penyusutan ASC";
		$result_2 = Yii::app()->db->createCommand($sql)->queryAll();
                
                // var_dump($result_1, $result_2); die;
                
		$dataLineChart = CustomFunction::joinTwo2DArrays($result_1, $result_2, 'create_time');


		//=== chart ===
		$sql = "SELECT count(invtanah_id) as jumlah_1
				FROM invtanah_t
				WHERE DATE(create_time) BETWEEN '" . date("Y-m") . "-01' AND '" . date("Y-m-d") . "'
				";
		$result_1 = Yii::app()->db->createCommand($sql)->queryAll();
		$sql = "SELECT count(invperalatan_id) as jumlah_2
				FROM invperalatan_t
				WHERE DATE(create_time) BETWEEN '" . date("Y-m") . "-01' AND '" . date("Y-m-d") . "'";
		$result_2 = Yii::app()->db->createCommand($sql)->queryAll();
		$sql = "SELECT count(invgedung_id) as jumlah_3
				FROM invgedung_t
				WHERE DATE(create_time) BETWEEN '" . date("Y-m") . "-01' AND '" . date("Y-m-d") . "'
				";
		$result_3 = Yii::app()->db->createCommand($sql)->queryAll();
		$sql = "SELECT count(invjalan_id) as jumlah_4
				FROM invjalan_t
				WHERE DATE(craete_time) BETWEEN '" . date("Y-m") . "-01' AND '" . date("Y-m-d") . "'
				";
		$result_4 = Yii::app()->db->createCommand($sql)->queryAll();
		foreach ($result_1 as $tanah) {
			$tempTanah['label'] = "Inventaris Tanah";
			$tempTanah['jumlah'] = $tanah['jumlah_1'];
			array_push($dataDonutChart, $tempTanah);
		}
		foreach ($result_2 as $alat) {
			$tempAlat['label'] = "Inventaris Peralatan";
			$tempAlat['jumlah'] = $alat['jumlah_2'];
			array_push($dataDonutChart, $tempAlat);
		}
		foreach ($result_3 as $gedung) {
			$tempGedung['label'] = "Inventaris Gedung";
			$tempGedung['jumlah'] = $gedung['jumlah_3'];
			array_push($dataDonutChart, $tempGedung);
		}
		foreach ($result_4 as $jalan) {
			$tempJalan['label'] = "Inventaris Jalan";
			$tempJalan['jumlah'] = $jalan['jumlah_4'];
			array_push($dataDonutChart, $tempJalan);
		}
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
		$dataPieChart = $dataDonutChart;

		$sql = "SELECT COUNT(pemeliharaanaset_id) AS jumlah
				FROM pemeliharaanaset_t
				WHERE DATE(pemeliharaanaset_tgl) BETWEEN '" . date("Y-m") . "-01' AND '" . date("Y-m-d") . "'";
		$result = Yii::app()->db->createCommand($sql)->queryRow();
		$dataKolom[5] = $result['jumlah'];

		$sql = "SELECT COUNT(penyusutanaset_id) AS jumlah
				FROM penyusutanaset_t
				WHERE DATE(tgl_penyusutan) BETWEEN '" . date("Y-m") . "-01' AND '" . date("Y-m-d") . "'";
		$result = Yii::app()->db->createCommand($sql)->queryRow();
		$dataKolom[6] = $result['jumlah'];

		$sql = "SELECT barang_m.barang_nama as barang_nama, SUM(pemakaianbrgdetail_t.jmlpakai) as jumlah
				FROM pemakaianbrgdetail_t
				JOIN pemakaianbarang_t ON pemakaianbarang_t.pemakaianbarang_id = pemakaianbrgdetail_t.pemakaianbarang_id
				JOIN barang_m ON barang_m.barang_id = pemakaianbrgdetail_t.barang_id
				WHERE DATE(pemakaianbarang_t.tglpemakaianbrg) BETWEEN '" . date("Y-m") . "-01' AND '" . date("Y-m-d") . "'
				GROUP BY barang_nama
				ORDER BY jumlah DESC
				LIMIT 10";
		$result = Yii::app()->db->createCommand($sql)->queryAll();
		$dataBarChart = $result;

		//=== end chart ===
		//=== start table ===
		$criteria_updatepasien = new CDbCriteria();
		$criteria_updatepasien->limit = 5;
		$criteria_updatepasien->with = array('pemakaianbarang', 'barang');
		$criteria_updatepasien->order = 'pemakaianbarang.tglpemakaianbrg DESC';
		$dataTable = MAPemakaianbrgdetailT::model()->findAll($criteria_updatepasien);


		$dataTable = new MAPemakaianbrgdetailT("searchPemakaianBarang");

		//=== end table ===
		//=== start todo list ===
		$modTodolist = new MATodolistR();
		$dataProviderTodolist = $modTodolist->searchTodolistWidget();
		//=== end todo list ===
		//=== start map ===
		$sql = "SELECT lokasiaset_namalokasi, garis_latitude, garis_longitude, count(lokasi_id) as jumlah
				FROM lokasiaset_m
				WHERE lokasiaset_aktif = TRUE
				GROUP BY lokasiaset_namalokasi, garis_latitude, garis_longitude
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
				$modTodolist = MATodolistR::model()->findByPk($todolist_id);
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

			$IdTodolist = isset($isi['MATodolistR']['todolist_id']) ? $isi['MATodolistR']['todolist_id'] : '';

			if (empty($IdTodolist)) { //antrian baru
				$modTodolist = new MATodolistR;
				$modTodolist->todolist_nama = isset($isi['MATodolistR']['todolist_nama']) ? $isi['MATodolistR']['todolist_nama'] : '';
				$modTodolist->todolist_aktif = isset($isi['MATodolistR']['todolist_aktif']) ? $isi['MATodolistR']['todolist_aktif'] : true;
				$modTodolist->tgltodolist = isset($isi['MATodolistR']['tgltodolist_new']) ? MyFormatter::formatDateTimeForDb($isi['MATodolistR']['tgltodolist_new']) : date('Y-m-d');
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
				$modTodolist = MATodolistR::model()->findByPk($IdTodolist);
				$modTodolist->todolist_nama = isset($isi['MATodolistR']['todolist_nama']) ? $isi['MATodolistR']['todolist_nama'] : '';
				$modTodolist->todolist_aktif = isset($isi['MATodolistR']['todolist_aktif']) ? $isi['MATodolistR']['todolist_aktif'] : true;
				$modTodolist->tgltodolist = isset($isi['MATodolistR']['tgltodolist']) ? MyFormatter::formatDateTimeForDb($isi['MATodolistR']['tgltodolist']) : date('Y-m-d');
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

			$IdTodolist = isset($isi['MATodolistR']['todolist_id']) ? $isi['MATodolistR']['todolist_id'] : '';

			if (empty($IdTodolist)) { //antrian baru
				$modTodolist = new MATodolistR;
				$modTodolist->todolist_nama = isset($isi['MATodolistR']['todolist_nama']) ? $isi['MATodolistR']['todolist_nama'] : '';
				$modTodolist->todolist_aktif = isset($isi['MATodolistR']['todolist_aktif']) ? $isi['MATodolistR']['todolist_aktif'] : true;
				$modTodolist->tgltodolist = isset($isi['MATodolistR']['tgltodolist']) ? MyFormatter::formatDateTimeForDb($isi['MATodolistR']['tgltodolist']) : date('Y-m-d');
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
				$modTodolist = MATodolistR::model()->findByPk($IdTodolist);
				$modTodolist->todolist_nama = isset($isi['MATodolistR']['todolist_nama']) ? $isi['MATodolistR']['todolist_nama'] : '';
				$modTodolist->todolist_aktif = isset($isi['MATodolistR']['todolist_aktif']) ? $isi['MATodolistR']['todolist_aktif'] : true;
				$modTodolist->tgltodolist = isset($isi['MATodolistR']['tgltodolist']) ? MyFormatter::formatDateTimeForDb($isi['MATodolistR']['tgltodolist']) : date('Y-m-d');
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
				$modTodolist = MATodolistR::model()->deleteByPk($todolist_id);
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
				$modTodolist = MATodolistR::model()->findByPk($todolist_id);
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