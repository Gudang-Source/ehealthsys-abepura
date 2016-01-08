<?php
Yii::import("pendaftaranPenjadwalan.controllers.ModuleDashboardNeonController");
Yii::import("pendaftaranPenjadwalan.models.PPTodolistR");

class ModuleDashboardFAController extends ModuleDashboardNeonController
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
                FROM laporanpenjualanobat_v
                WHERE DATE(tglpenjualan) = '".date('Y-m-d')."'";
        $result = Yii::app()->db->createCommand($sql)->queryRow();
        $dataKolom[1] = $result['jumlah'];

        $sql = "SELECT COUNT(pasien_id) AS jumlah
                FROM laporanpenjualanobat_v
                WHERE DATE(tglpenjualan) = '".date('Y-m-d')."' and racikan_id = ".Params::RACIKAN_ID_RACIKAN;
        $result = Yii::app()->db->createCommand($sql)->queryRow();
        $dataKolom[2] = $result['jumlah'];

        $sql = "SELECT COUNT(pasien_id) AS jumlah
                FROM laporanpenjualanobat_v
                WHERE DATE(tglpenjualan) = '".date('Y-m-d')."' and racikan_id = ".Params::RACIKAN_ID_NONRACIKAN;
        $result = Yii::app()->db->createCommand($sql)->queryRow();
        $dataKolom[3] = $result['jumlah'];

        $sql = "SELECT COUNT(pasien_id) AS jumlah
                FROM informasipenjualanresep_v
                WHERE DATE(tglresep) = '".date('Y-m-d')."' and jenispenjualan = '".Params::JENISPENJUALAN_RESEP."'";
        $result = Yii::app()->db->createCommand($sql)->queryRow();
        $dataKolom[4] = $result['jumlah'];
		
		//=== end 4 kolom ===
		
		//=== chart ===
		$sql = "SELECT DATE(tglpenjualan) as tglpenjualan, sum(hargajual_oa) as jumlah
				FROM laporanpendapatanfarmasi_v
				WHERE DATE(tglpenjualan) BETWEEN '".date("Y-m")."-01' AND '".date("Y-m-d")."'
				AND ruangan_id = ".Yii::app()->user->getState('ruangan_id')."
				GROUP BY DATE(tglpenjualan)
				ORDER BY tglpenjualan ASC";
		$result = Yii::app()->db->createCommand($sql)->queryAll();

		$dataAreaChart = $result;
		//=== chart ===
		$sql = "SELECT DATE(tglpenjualan) as tglpenjualan, sum(hargajual_oa) as jumlah_1
				FROM laporanpendapatanfarmasi_v
				WHERE DATE(tglpenjualan) BETWEEN '".date("Y-m")."-01' AND '".date("Y-m-d")."'
				GROUP BY DATE(tglpenjualan)
				ORDER BY tglpenjualan ASC";
		$dataLineChart = Yii::app()->db->createCommand($sql)->queryAll();
		
		$sql = "SELECT jenispenjualan, sum(totalhargajual) as jumlah
				FROM penjualanresep_t
				WHERE DATE(tglpenjualan) BETWEEN '".date("Y-m")."-01' AND '".date("Y-m-d")."'
                AND ruangan_id = ".Yii::app()->user->getState('ruangan_id')."
				GROUP BY jenispenjualan
				ORDER BY jenispenjualan ASC";
		$result = Yii::app()->db->createCommand($sql)->queryAll();
        $dataDonutChart = $result;
		
		$sql = "SELECT jenisobatalkes_nama, count(penjualanresep_id) as jumlah
				FROM laporanpenjualanjenisoa_v 
				WHERE DATE(tglresep) BETWEEN '".date("Y-m")."-01' AND '".date("Y-m-d")."'
				GROUP BY jenisobatalkes_nama
				ORDER BY jenisobatalkes_nama ASC";
		$result = Yii::app()->db->createCommand($sql)->queryAll();
        $dataPieChart = $result;

		$sql = "SELECT COUNT(pasien_id) AS jumlah
				FROM laporanpenjualanobat_v
				WHERE DATE(tglpenjualan) BETWEEN '".date("Y-m")."-01' AND '".date("Y-m-d")."'
					AND racikan_id = ".Params::RACIKAN_ID_RACIKAN;
		$result = Yii::app()->db->createCommand($sql)->queryRow();
        $dataKolom[5] = $result['jumlah'];
		
		$sql = "SELECT COUNT(pasien_id) AS jumlah
				FROM laporanpenjualanobat_v
				WHERE DATE(tglpenjualan) BETWEEN '".date("Y-m")."-01' AND '".date("Y-m-d")."'
					AND racikan_id = ".Params::RACIKAN_ID_NONRACIKAN;
		$result = Yii::app()->db->createCommand($sql)->queryRow();
        $dataKolom[6] = $result['jumlah'];
		
		
		
		$sql = "SELECT jnskelompok, sum(infostokobatalkesruangan_v.hargajual) AS hargajual
				FROM infostokobatalkesruangan_v JOIN obatalkes_m ON infostokobatalkesruangan_v.obatalkes_id = obatalkes_m.obatalkes_id
				WHERE ruangan_id = 59 GROUP BY jnskelompok";
		$result = Yii::app()->db->createCommand($sql)->queryAll();
        $dataBarChart = $result;
		//=== end chart ===

		//=== start table ===
		// $criteria_updatepasien = new CDbCriteria();
		// $criteria_updatepasien->limit=5;
		// $criteria_updatepasien->order = 'tgl_pendaftaran DESC';
		// $dataTable = LKPendaftaranMp::model()->findAll($criteria_updatepasien);
		
		
		$dataTable = new FALaporanpenjualanobatV('search10Besar');
		
		//=== end table ===

		//=== start todo list ===
		$modTodolist = new PPTodolistR;
        $dataProviderTodolist = $modTodolist->searchTodolistWidget();
		//=== end todo list ===

		//=== start map ===
		$sql = "SELECT kecamatan_m.kecamatan_id, kecamatan_m.kecamatan_nama, kecamatan_m.longitude, kecamatan_m.latitude, count(pendaftaran_id) as jumlah
				FROM pasienmasukpenunjang_v
				JOIN kecamatan_m ON pasienmasukpenunjang_v.kecamatan_id = kecamatan_m.kecamatan_id
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