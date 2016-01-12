<?php 
Yii::import("pendaftaranPenjadwalan.controllers.ModuleDashboardNeonController");
Yii::import("pendaftaranPenjadwalan.models.PPTodolistR");

class ModuleDashboardBSController extends ModuleDashboardNeonController{
	public $path_view = 'pendaftaranPenjadwalan.views.moduleDashboardNeon.';
	
	public function actionIndex()
	{
        $this->render('index');
	}
	
	/**
	 * menampilkan halaman dashboard (iframe)
	 * beberapa menggunakan DAO (createCommand) agar lebih cepat
	 */
    public function actionSetIFrameDashboard(){

		$this->layout= '//layouts/iframeNeon';
		$format = new MyFormatter();

	// KOLOM BARIS PERTAMA
		$dataKolom = array();
		// Query Jumlah Pasien Selesai Operasi Hari Ini 
		$sql = "SELECT COUNT(pasien_id) AS jumlah
						FROM rencanaoperasi_t
						WHERE DATE(selesaioperasi) ='".date('Y-m-d')."' 
						AND statusoperasi = '".Params::STATUSOPERASI_SELESAI."'";
		$result = Yii::app()->db->createCommand($sql)->queryRow();
		$dataKolom[1] = $result['jumlah'];
		// Query Jumlah Pasien Rencana Operasi Hari Ini
		$sql = "SELECT COUNT(pasien_id) AS jumlah
						FROM rencanaoperasi_t
						WHERE DATE(selesaioperasi) ='".date('Y-m-d')."'
						AND statusoperasi = '".Params::DEFAULT_STATUS_OPERASI."'";
		$result = Yii::app()->db->createCommand($sql)->queryRow();
		$dataKolom[2] = $result['jumlah'];
		// Query Jumlah Pasien Batal Periksa Hari Ini
		$sql = "SELECT COUNT(pasien_id) AS jumlah
						FROM pasienbatalperiksa_r
						WHERE DATE(tglbatal) ='".date('Y-m-d')."'
						AND LOWER(keterangan_batal) = '".strtolower(Params::KETERANGANBATAL_BEDAH_SENTRAL)."'";
		$result = Yii::app()->db->createCommand($sql)->queryRow();
		$dataKolom[3] = $result['jumlah'];
		// Query Jumlah Keseluruhan Pasien di Instalasi Bedah Sentral Hari Ini
		$sql = "SELECT COUNT(pasien_id) AS jumlah
						FROM pasienmasukpenunjang_v
						WHERE DATE(tglmasukpenunjang) ='".date('Y-m-d')."'";
		$result = Yii::app()->db->createCommand($sql)->queryRow();
		$dataKolom[4] = $result['jumlah'];

	// AREA CHART
		$sql = "SELECT DATE(selesaioperasi) as selesaioperasi, count(pasien_id) as jumlah
						FROM rencanaoperasi_t
						WHERE DATE(selesaioperasi) BETWEEN  '".date("Y-m")."-01' AND '".date("Y-m-d")."'
						GROUP BY selesaioperasi
						ORDER BY selesaioperasi ASC";
		$result = Yii::app()->db->createCommand($sql)->queryAll();
		$dataAreaChart = $result;

	// LINE CHART
	
		// LINE I
        $sql = "SELECT  DATE(selesaioperasi) as selesaioperasi, count(pasien_id)  as jumlah_1
                        FROM rencanaoperasi_t
                        JOIN operasi_m ON rencanaoperasi_t.operasi_id = operasi_m.operasi_id
                        JOIN kegiatanoperasi_m ON operasi_m.kegiatanoperasi_id = kegiatanoperasi_m.kegiatanoperasi_id
                        WHERE DATE(selesaioperasi) BETWEEN  '".date("Y-m")."-01' AND '".date("Y-m-d")."'
                        AND kegiatanoperasi_aktif = true AND kegiatanoperasi_nama = 'Bedah Umum dan Mata'
                        GROUP BY selesaioperasi
                        ORDER BY selesaioperasi ASC";
        $result_1    = Yii::app()->db->createCommand($sql)->queryAll(); 
        // LINE 2
        $sql = "SELECT  DATE(selesaioperasi) as selesaioperasi, count(pasien_id)  as jumlah_2
                        FROM rencanaoperasi_t
                        JOIN operasi_m ON rencanaoperasi_t.operasi_id = operasi_m.operasi_id
                        JOIN kegiatanoperasi_m ON operasi_m.kegiatanoperasi_id = kegiatanoperasi_m.kegiatanoperasi_id
                        WHERE DATE(selesaioperasi) BETWEEN  '".date("Y-m")."-01' AND '".date("Y-m-d")."'
                        AND kegiatanoperasi_aktif = true AND kegiatanoperasi_nama = 'Bedah Orthopedia'
                        GROUP BY selesaioperasi
                        ORDER BY selesaioperasi ASC";
        $result_2 = Yii::app()->db->createCommand($sql)->queryAll(); 
        // LINE 3
        $sql = "SELECT  DATE(selesaioperasi) as selesaioperasi, count(pasien_id)  as jumlah_3
                        FROM rencanaoperasi_t
                        JOIN operasi_m ON rencanaoperasi_t.operasi_id = operasi_m.operasi_id
                        JOIN kegiatanoperasi_m ON operasi_m.kegiatanoperasi_id = kegiatanoperasi_m.kegiatanoperasi_id
                        WHERE DATE(selesaioperasi) BETWEEN  '".date("Y-m")."-01' AND '".date("Y-m-d")."'
                        AND kegiatanoperasi_aktif = true AND kegiatanoperasi_nama = 'Bedah Mulut'
                        GROUP BY selesaioperasi
                        ORDER BY selesaioperasi ASC";
        $result_3 = Yii::app()->db->createCommand($sql)->queryAll(); 
        // LINE 4
        $sql = "SELECT  DATE(selesaioperasi) as selesaioperasi, count(pasien_id)  as jumlah_4
                        FROM rencanaoperasi_t
                        JOIN operasi_m ON rencanaoperasi_t.operasi_id = operasi_m.operasi_id
                        JOIN kegiatanoperasi_m ON operasi_m.kegiatanoperasi_id = kegiatanoperasi_m.kegiatanoperasi_id
                        WHERE DATE(selesaioperasi) BETWEEN  '".date("Y-m")."-01' AND '".date("Y-m-d")."'
                        AND kegiatanoperasi_aktif = true AND kegiatanoperasi_nama = 'Bedah Urologi'
                        GROUP BY selesaioperasi
                        ORDER BY selesaioperasi ASC";
        $result_4 = Yii::app()->db->createCommand($sql)->queryAll(); 
        // LINE 5
        $sql = "SELECT  DATE(selesaioperasi) as selesaioperasi, count(pasien_id)  as jumlah_5
                        FROM rencanaoperasi_t
                        JOIN operasi_m ON rencanaoperasi_t.operasi_id = operasi_m.operasi_id
                        JOIN kegiatanoperasi_m ON operasi_m.kegiatanoperasi_id = kegiatanoperasi_m.kegiatanoperasi_id
                        WHERE DATE(selesaioperasi) BETWEEN  '".date("Y-m")."-01' AND '".date("Y-m-d")."'
                        AND kegiatanoperasi_aktif = true AND kegiatanoperasi_nama = 'ODS Bedah Umum'
                        GROUP BY selesaioperasi
                        ORDER BY selesaioperasi ASC";
        $result_5 = Yii::app()->db->createCommand($sql)->queryAll(); 
        // LINE 6
        $sql = "SELECT  DATE(selesaioperasi) as selesaioperasi, count(pasien_id)  as jumlah_6
                        FROM rencanaoperasi_t
                        JOIN operasi_m ON rencanaoperasi_t.operasi_id = operasi_m.operasi_id
                        JOIN kegiatanoperasi_m ON operasi_m.kegiatanoperasi_id = kegiatanoperasi_m.kegiatanoperasi_id
                        WHERE DATE(selesaioperasi) BETWEEN  '".date("Y-m")."-01' AND '".date("Y-m-d")."'
                        AND kegiatanoperasi_aktif = true AND kegiatanoperasi_nama = 'ODS Bedah Orthopedi'
                        GROUP BY selesaioperasi
                        ORDER BY selesaioperasi ASC";
        $result_6 = Yii::app()->db->createCommand($sql)->queryAll(); 
        // LINE 7
        $sql = "SELECT  DATE(selesaioperasi) as selesaioperasi, count(pasien_id)  as jumlah_7
                        FROM rencanaoperasi_t
                        JOIN operasi_m ON rencanaoperasi_t.operasi_id = operasi_m.operasi_id
                        JOIN kegiatanoperasi_m ON operasi_m.kegiatanoperasi_id = kegiatanoperasi_m.kegiatanoperasi_id
                        WHERE DATE(selesaioperasi) BETWEEN  '".date("Y-m")."-01' AND '".date("Y-m-d")."'
                        AND kegiatanoperasi_aktif = true AND kegiatanoperasi_nama = 'ODS Bedah THT'
                        GROUP BY selesaioperasi
                        ORDER BY selesaioperasi ASC";
        $result_7 = Yii::app()->db->createCommand($sql)->queryAll(); 
        // LINE 8
        $sql = "SELECT  DATE(selesaioperasi) as selesaioperasi, count(pasien_id)  as jumlah_8
                        FROM rencanaoperasi_t
                        JOIN operasi_m ON rencanaoperasi_t.operasi_id = operasi_m.operasi_id
                        JOIN kegiatanoperasi_m ON operasi_m.kegiatanoperasi_id = kegiatanoperasi_m.kegiatanoperasi_id
                        WHERE DATE(selesaioperasi) BETWEEN  '".date("Y-m")."-01' AND '".date("Y-m-d")."'
                        AND kegiatanoperasi_aktif = true AND kegiatanoperasi_nama = 'Operasi Obgyn'
                        GROUP BY selesaioperasi
                        ORDER BY selesaioperasi ASC";
        $result_8 = Yii::app()->db->createCommand($sql)->queryAll(); 
        // LINE 9
        $sql = "SELECT  DATE(selesaioperasi) as selesaioperasi, count(pasien_id)  as jumlah_9
                        FROM rencanaoperasi_t
                        JOIN operasi_m ON rencanaoperasi_t.operasi_id = operasi_m.operasi_id
                        JOIN kegiatanoperasi_m ON operasi_m.kegiatanoperasi_id = kegiatanoperasi_m.kegiatanoperasi_id
                        WHERE DATE(selesaioperasi) BETWEEN  '".date("Y-m")."-01' AND '".date("Y-m-d")."'
                        AND kegiatanoperasi_aktif = true AND kegiatanoperasi_nama = 'Bedah Tht'
                        GROUP BY selesaioperasi
                        ORDER BY selesaioperasi ASC";
        $result_9 = Yii::app()->db->createCommand($sql)->queryAll(); 
        
        $dataLineChart = CustomFunction::joinTwo2DArrays($result_1, $result_2, 'selesaioperasi');
        $dataLineChart = CustomFunction::joinTwo2DArrays($dataLineChart, $result_3, 'selesaioperasi');
        $dataLineChart = CustomFunction::joinTwo2DArrays($dataLineChart, $result_4, 'selesaioperasi');
        $dataLineChart = CustomFunction::joinTwo2DArrays($dataLineChart, $result_5, 'selesaioperasi');
        $dataLineChart = CustomFunction::joinTwo2DArrays($dataLineChart, $result_6, 'selesaioperasi');
        $dataLineChart = CustomFunction::joinTwo2DArrays($dataLineChart, $result_7, 'selesaioperasi');
        $dataLineChart = CustomFunction::joinTwo2DArrays($dataLineChart, $result_8, 'selesaioperasi');
        $dataLineChart = CustomFunction::joinTwo2DArrays($dataLineChart, $result_9, 'selesaioperasi');
		

	// DONUT CHART
		$sql = "SELECT  instalasiasal_nama, instalasiasal_id, instalasi_id, count(pasien_id) as jumlah
						FROM pasienmasukpenunjang_v 
						WHERE DATE(tglmasukpenunjang) BETWEEN '".date("Y-m")."-01' AND '".date("Y-m-d")."'
						AND (
						instalasiasal_id = ".Params::INSTALASI_ID_RJ."
						OR instalasiasal_id = ".Params::INSTALASI_ID_RD."
						OR instalasiasal_id = ".Params::INSTALASI_ID_RI."
						)
						AND instalasi_id = '".Params::INSTALASI_ID_IBS."'
						GROUP BY instalasiasal_nama,instalasiasal_id,instalasi_id
						ORDER BY instalasiasal_nama ASC";
		$result = Yii::app()->db->createCommand($sql)->queryAll();
		$dataDonutChart = $result;

	// PIE CHART
		$sql = "SELECT count(pasien_id) as jumlah, jeniskasuspenyakit_nama
						FROM pasienmasukpenunjang_v
						WHERE DATE(tgl_pendaftaran) BETWEEN '".date("Y-m")."-01' AND '".date("Y-m-d")."'
						AND instalasi_id = '".Params::INSTALASI_ID_IBS."'
						GROUP BY jeniskasuspenyakit_nama
						ORDER BY jeniskasuspenyakit_nama ASC";
		$result = Yii::app()->db->createCommand($sql)->queryAll();
		$dataPieChart = $result;

	// KOLOM BARIS KETIGA
		// Query Jumlah Kunjungan Baru
		$sql = "SELECT count(pasien_id) as jumlah FROM pasienmasukpenunjang_v
						WHERE instalasi_id = '".Params::INSTALASI_ID_IBS."' 
						AND kunjungan = '".Params::STATUSKUNJUNGAN_BARU."' 
						GROUP BY kunjungan 
						ORDER BY kunjungan";
		$result = Yii::app()->db->createCommand($sql)->queryRow();
		$dataKolom[5] = $result['jumlah'];
		// Query Jumlah Kunjungan Lama
		$sql = "SELECT count(pasien_id) as jumlah FROM pasienmasukpenunjang_v
						WHERE instalasi_id = '".Params::INSTALASI_ID_IBS."' 
						AND kunjungan = '".Params::STATUSKUNJUNGAN_LAMA."' 
						GROUP BY kunjungan 
						ORDER BY kunjungan";
		$result = Yii::app()->db->createCommand($sql)->queryRow();
		$dataKolom[6] = $result['jumlah'];		

	// BAR CHART
		$sql = "SELECT	kegiatanoperasi_nama, count(rencanaoperasi_id) as jumlah
						FROM rencanaoperasi_t
						JOIN operasi_m ON rencanaoperasi_t.operasi_id = operasi_m.operasi_id
						JOIN kegiatanoperasi_m ON operasi_m.kegiatanoperasi_id = kegiatanoperasi_m.kegiatanoperasi_id
						WHERE DATE(selesaioperasi) BETWEEN '".date("Y-m")."-01' AND '".date("Y-m-d")."'
						AND kegiatanoperasi_aktif = true
						GROUP BY kegiatanoperasi_nama
						ORDER BY kegiatanoperasi_nama ASC";
		$result = Yii::app()->db->createCommand($sql)->queryAll();
		$dataBarChart = $result;

	// TABEL
		$dataTable = new BSRencanaOperasiT();    

	// MAP 
		$sql = "SELECT kecamatan_m.kecamatan_id, kecamatan_m.kecamatan_nama, kecamatan_m.longitude, kecamatan_m.latitude, count(pendaftaran_id) as jumlah
				FROM pasienmasukpenunjang_v
				JOIN kecamatan_m ON pasienmasukpenunjang_v.kecamatan_id = kecamatan_m.kecamatan_id
				WHERE date_part('year',tgl_pendaftaran) = '".date('Y')."'
				AND instalasi_id = '".Params::INSTALASI_ID_IBS."'
				GROUP BY kecamatan_m.kecamatan_id, kecamatan_m.kecamatan_nama, kecamatan_m.longitude, kecamatan_m.latitude
				ORDER BY jumlah DESC
				LIMIT 10
				";
		$result = Yii::app()->db->createCommand($sql)->queryAll();
		$dataMap = $result;
	
	// TO DO LIST
		$modTodolist = new PPTodolistR();
        $dataProviderTodolist = $modTodolist->searchTodolistWidget();
		
		$this->render('dashboard',array(
					'dataKolom'=>$dataKolom,
					'dataAreaChart'=>$dataAreaChart,
					'dataLineChart'=>$dataLineChart,
					'dataDonutChart'=>$dataDonutChart,
					'dataPieChart'=>$dataPieChart,
					'dataBarChart'=>$dataBarChart,
					'dataTable'=>$dataTable,
					'modTodolist'=>$modTodolist,
					'dataProviderTodolist'=>$dataProviderTodolist,
					'dataMap'=>$dataMap,
				));

	}
}
?>