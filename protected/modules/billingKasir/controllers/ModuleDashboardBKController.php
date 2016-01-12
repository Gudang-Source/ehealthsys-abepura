<?php
Yii::import("pendaftaranPenjadwalan.controllers.ModuleDashboardNeonController");
Yii::import("pendaftaranPenjadwalan.models.PPTodolistR");

class ModuleDashboardBKController extends ModuleDashboardNeonController
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
		
		$sql = "SELECT COUNT(pasienadmisi_id) AS jumlah
                FROM pasienadmisi_t
                WHERE DATE(rencanapulang) = '".date('Y-m-d')."'";
        $result = Yii::app()->db->createCommand($sql)->queryRow();
        $dataKolom[1] = $result['jumlah'];

        $sql = "SELECT COUNT(pendaftaran_id) AS jumlah
                FROM pendaftaran_t
                WHERE DATE(tgl_pendaftaran) = '".date('Y-m-d')."' AND statusperiksa ='".Params::STATUSPERIKSA_SUDAH_DIPERIKSA."'";
        $result = Yii::app()->db->createCommand($sql)->queryRow();
        $dataKolom[2] = $result['jumlah'];

        $sql = "SELECT COUNT(pasienadmisi_id) AS jumlah
                FROM pasienadmisi_t
                WHERE DATE(tglpulang) = '".date('Y-m-d')."'";
        $result = Yii::app()->db->createCommand($sql)->queryRow();
        $dataKolom[3] = $result['jumlah'];

        $sql = "SELECT COUNT(DISTINCT pasien_id) AS jumlah
                FROM pembayaranpelayanan_t
                WHERE DATE(tglpembayaran) = '".date('Y-m-d')."'";
        $result = Yii::app()->db->createCommand($sql)->queryRow();
        $dataKolom[4] = $result['jumlah'];
		
		//=== end 4 kolom ===
		
		//=== chart ===
		$sql = "SELECT DATE(tglpembayaran) as tglpembayaran, sum(totalbayartindakan) as jumlah
				FROM pembayaranpelayanan_t
				WHERE DATE(tglpembayaran) BETWEEN '".date("Y-m")."-01' AND '".date("Y-m-d")."'
				GROUP BY DATE(tglpembayaran)
				ORDER BY tglpembayaran ASC";
		$result = Yii::app()->db->createCommand($sql)->queryAll();

		$dataAreaChart = $result;
		//=== chart ===
		$modRuanganKasirs = RuanganM::model()->findAllByAttributes(array('instalasi_id'=>Params::INSTALASI_ID_KASIR,'ruangan_aktif'=>true));
		if(count($modRuanganKasirs) > 0){
			foreach ($modRuanganKasirs as $i => $kasir) {
				$sql = "SELECT ruangan_m.ruangan_nama,ruangan_m.ruangan_id, sum(pembayaranpelayanan_t.totalbayartindakan) as jumlah_2
						FROM pembayaranpelayanan_t
						JOIN ruangan_m ON pembayaranpelayanan_t.ruangan_id = ruangan_m.ruangan_id
						WHERE DATE(pembayaranpelayanan_t.tglpembayaran) BETWEEN '".date("Y-m")."-01' AND '".date("Y-m-d")."'
						AND pembayaranpelayanan_t.ruangan_id = ".$kasir->ruangan_id."
						GROUP BY ruangan_nama,ruangan_m.ruangan_id
						ORDER BY ruangan_m.ruangan_nama ASC";
				$result[$i] = Yii::app()->db->createCommand($sql)->queryAll();
				if($i > 0){
					$dataLineChart = CustomFunction::joinTwo2DArrays($dataLineChart, $result[$i-1], 'ruangan_nama');
				}
			}
		}

		$sql = "SELECT instalasi_m.instalasi_nama, sum(pembayaranpelayanan_t.totalbayartindakan) as jumlah
				FROM pembayaranpelayanan_t
				JOIN ruangan_m ON pembayaranpelayanan_t.ruangan_id = ruangan_m.ruangan_id
				JOIN instalasi_m ON ruangan_m.instalasi_id = instalasi_m.instalasi_id
				WHERE DATE(pembayaranpelayanan_t.tglpembayaran) BETWEEN '".date("Y-m")."-01' AND '".date("Y-m-d")."'
				GROUP BY instalasi_nama
				ORDER BY instalasi_m.instalasi_nama ASC";
		$result = Yii::app()->db->createCommand($sql)->queryAll();
        $dataDonutChart = $result;
		
		$sql = "SELECT instalasi_nama, count(pendaftaran_id) as jumlah
				FROM laporankunjunganrs_v
				WHERE DATE(tgl_pendaftaran) BETWEEN '".date("Y-m")."-01' AND '".date("Y-m-d")."'
				GROUP BY instalasi_nama
				ORDER BY instalasi_nama ASC";
		$result = Yii::app()->db->createCommand($sql)->queryAll();
        $dataPieChart = $result;
		

		$sql = "SELECT COUNT(closingkasir_id) AS jumlah
				FROM closingkasir_t
				WHERE DATE(tglclosingkasir) BETWEEN '".date("Y-m")."-01' AND '".date("Y-m-d")."'
				AND setorbank_id IS NULL";
		$result = Yii::app()->db->createCommand($sql)->queryRow();
        $dataKolom[5] = $result['jumlah'];
		
		$sql = "SELECT COUNT(closingkasir_id) AS jumlah
				FROM closingkasir_t
				WHERE DATE(tglclosingkasir) BETWEEN '".date("Y-m")."-01' AND '".date("Y-m-d")."'
				AND setorbank_id IS NOT NULL";
		$result = Yii::app()->db->createCommand($sql)->queryRow();
        $dataKolom[6] = $result['jumlah'];
		
		
		
		$sql = "SELECT penjaminpasien_m.penjamin_nama, sum(pembayaranpelayanan_t.totalbayartindakan) as jumlah
				FROM pembayaranpelayanan_t
				JOIN penjaminpasien_m ON penjaminpasien_m.penjamin_id = pembayaranpelayanan_t.penjamin_id
				WHERE DATE(pembayaranpelayanan_t.tglpembayaran) BETWEEN '".date("Y-m")."-01' AND '".date("Y-m-d")."'
				GROUP BY penjaminpasien_m.penjamin_nama
				ORDER BY penjaminpasien_m.penjamin_nama ASC";
		$result = Yii::app()->db->createCommand($sql)->queryAll();
        $dataBarChart = $result;
		//=== end chart ===

		//=== start table ===
		// $criteria_updatepasien = new CDbCriteria();
		// $criteria_updatepasien->limit=5;
		// $criteria_updatepasien->order = 'tgl_pendaftaran DESC';
		// $dataTable = LKPendaftaranMp::model()->findAll($criteria_updatepasien);
		
		
		$dataTable = new BKBayaruangmukaT("searchBayarUangmukaTerakhir");
		
		//=== end table ===

		//=== start todo list ===
		$modTodolist = new PPTodolistR;
        $dataProviderTodolist = $modTodolist->searchTodolistWidget();
		//=== end todo list ===

		//=== start map ===
		$sql = "SELECT kecamatan_m.kecamatan_nama, kecamatan_m.longitude, kecamatan_m.latitude, count(bayaruangmuka_t.bayaruangmuka_id) as jumlah
				FROM bayaruangmuka_t
				JOIN pasien_m ON bayaruangmuka_t.pasien_id = pasien_m.pasien_id
				JOIN kecamatan_m ON kecamatan_m.kecamatan_id = pasien_m.kecamatan_id
				WHERE date_part('year',tgluangmuka) = '".date('Y')."'
				GROUP BY kecamatan_m.kecamatan_nama, kecamatan_m.longitude, kecamatan_m.latitude
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