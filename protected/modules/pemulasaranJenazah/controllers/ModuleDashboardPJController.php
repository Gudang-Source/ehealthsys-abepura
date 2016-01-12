<?php
Yii::import("pendaftaranPenjadwalan.controllers.ModuleDashboardNeonController");
Yii::import("pendaftaranPenjadwalan.models.PPTodolistR");

class ModuleDashboardPJController extends ModuleDashboardNeonController
{
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
		//=== start 4 kolom ===
		$dataKolom = array();
		$dataAreaChart = array();
		$dataLineChart = array();
		$dataDonutChart = array();
		$dataPieChart = array();
		$dataBarChart = array();
		
		$sql = "SELECT COUNT(pasien_id) AS jumlah
                FROM informasiambiljenazah_v
                WHERE DATE(tglpengambilan) = '".date('Y-m-d')."'";
        $result = Yii::app()->db->createCommand($sql)->queryRow();
        $dataKolom[1] = $result['jumlah'];

        $sql = "SELECT COUNT(pasien_id) AS jumlah
                FROM tindakanpelayanan_t
                WHERE DATE(tgl_tindakan) = '".date('Y-m-d')."' AND daftartindakan_id = 124";
        $result = Yii::app()->db->createCommand($sql)->queryRow();
        $dataKolom[2] = $result['jumlah'];

        $sql = "SELECT COUNT(pendaftaran_id) AS jumlah
                FROM daftarpasienmeninggal_v
                WHERE DATE(tglpasienpulang) = '".date('Y-m-d')."' and kondisikeluar_id IN (3,4)";
        $result = Yii::app()->db->createCommand($sql)->queryRow();
        $dataKolom[3] = $result['jumlah'];

        $sql = "SELECT COUNT(pasien_id) AS jumlah
                FROM pemakaianambulans_t
                JOIN mobilambulans_m ON pemakaianambulans_t.mobilambulans_id = mobilambulans_m.mobilambulans_id
                WHERE LOWER(mobilambulans_m.jeniskendaraan) = 'mobil jenazah'
                AND DATE(tglpemakaianambulans) = '".date('Y-m-d')."'";
        $result = Yii::app()->db->createCommand($sql)->queryRow();
        $dataKolom[4] = $result['jumlah'];
		
		//=== end 4 kolom ===
		
		//=== chart ===
		$sql = "SELECT DATE(tgl_tindakan) as tgl_tindakan, count(pasien_id) as jumlah
				FROM tindakanpelayanan_t
				WHERE DATE(tgl_tindakan) BETWEEN '".date("Y-m")."-01' AND '".date("Y-m-d")."'
                AND daftartindakan_id = 124
				GROUP BY DATE(tgl_tindakan)
				ORDER BY tgl_tindakan ASC";
		$result = Yii::app()->db->createCommand($sql)->queryAll();

		$dataAreaChart = $result;
		//=== chart ===
		$sql = "SELECT DATE(tgl_tindakan) as tgl_tindakan, count(pasien_id) as jumlah_1
				FROM tindakanpelayanan_t
				JOIN daftartindakan_m ON daftartindakan_m.daftartindakan_id = tindakanpelayanan_t.daftartindakan_id
				WHERE DATE(tgl_tindakan) BETWEEN '".date("Y-m")."-01' AND '".date("Y-m-d")."'
				AND kelompoktindakan_id = 13
				GROUP BY DATE(tgl_tindakan)
				ORDER BY tgl_tindakan ASC";
		$result_1 = Yii::app()->db->createCommand($sql)->queryAll();
		
        $dataLineChart = CustomFunction::joinTwo2DArrays($dataLineChart, $result_1, 'tgl_pendaftaran');
		
		
		$sql = "SELECT instalasi_nama, count(pendaftaran_id) as jumlah
				FROM daftarpasienmeninggal_v
				WHERE DATE(tglpasienpulang) BETWEEN '".date("Y-m")."-01' AND '".date("Y-m-d")."'
                AND kondisikeluar_id IN (3,4)
				GROUP BY instalasi_nama
				ORDER BY instalasi_nama ASC";
		$result = Yii::app()->db->createCommand($sql)->queryAll();
        $dataDonutChart = $result;
		
		$sql = "SELECT carabayar_nama, count(pendaftaran_id) as jumlah
				FROM daftarpasienmeninggal_v
				WHERE DATE(tgl_pendaftaran) BETWEEN '".date("Y-m")."-01' AND '".date("Y-m-d")."'
				GROUP BY carabayar_nama
				ORDER BY carabayar_nama ASC";
		$result = Yii::app()->db->createCommand($sql)->queryAll();
        $dataPieChart = $result;

		$sql = "SELECT COUNT(pendaftaran_id) AS jumlah
				FROM informasiambiljenazah_v
				WHERE DATE(tglpengambilan) BETWEEN '".date("Y-m")."-01' AND '".date("Y-m-d")."'";
		$result = Yii::app()->db->createCommand($sql)->queryRow();
        $dataKolom[5] = $result['jumlah'];
		
		$sql = "SELECT COUNT(pendaftaran_id) AS jumlah
				FROM tindakanpelayanan_t
				WHERE DATE(tgl_tindakan) BETWEEN '".date("Y-m")."-01' AND '".date("Y-m-d")."'
				AND daftartindakan_id = 124";
		$result = Yii::app()->db->createCommand($sql)->queryRow();
        $dataKolom[6] = $result['jumlah'];
		
		
		
		$sql = "SELECT diagnosa_nama, count(diagnosa_id) as jumlah
				FROM laporan10besarpenyakit_v
				WHERE DATE(tglmorbiditas) BETWEEN '".date("Y-m")."-01' AND '".date("Y-m-d")."'
				GROUP BY diagnosa_nama
				ORDER BY diagnosa_nama ASC";
		$result = Yii::app()->db->createCommand($sql)->queryAll();
        $dataBarChart = $result;
		//=== end chart ===
		
		$dataTable = new PJTindakanPelayananT("search10Besar");
		
		//=== end table ===

		//=== start todo list ===
		$modTodolist = new PPTodolistR;
        $dataProviderTodolist = $modTodolist->searchTodolistWidget();
		//=== end todo list ===

		//=== start map ===
		$sql = "SELECT kecamatan_m.kecamatan_id, kecamatan_m.kecamatan_nama, kecamatan_m.longitude, kecamatan_m.latitude, count(pendaftaran_id) as jumlah
				FROM daftarpasienmeninggal_v
				JOIN kecamatan_m ON daftarpasienmeninggal_v.kecamatan_id = kecamatan_m.kecamatan_id
				WHERE date_part('year',tgl_pendaftaran) = '".date('Y')."'
				GROUP BY kecamatan_m.kecamatan_id, kecamatan_m.kecamatan_nama, kecamatan_m.longitude, kecamatan_m.latitude
				ORDER BY jumlah DESC
				LIMIT 10
				";
		$result = Yii::app()->db->createCommand($sql)->queryAll();
		$dataMap = $result;
		//=== end map ===
		
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