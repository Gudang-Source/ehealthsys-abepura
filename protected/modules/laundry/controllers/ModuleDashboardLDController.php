<?php
Yii::import("pendaftaranPenjadwalan.controllers.ModuleDashboardNeonController");
Yii::import("pendaftaranPenjadwalan.models.PPTodolistR");

class ModuleDashboardLDController extends ModuleDashboardNeonController
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
		
		$sql = "SELECT COUNT(penerimaanlinen_id) AS jumlah
                FROM penerimaanlinen_t
                WHERE DATE(tglpenerimaanlinen) = '".date('Y-m-d')."'";
                $result = Yii::app()->db->createCommand($sql)->queryRow();
                $dataKolom[1] = $result['jumlah'];

        $sql = "SELECT COUNT(pencucianlinen_id) AS jumlah
                FROM pencucianlinen_t
                WHERE DATE(tglpencucianlinen) = '".date('Y-m-d')."'";
        $result = Yii::app()->db->createCommand($sql)->queryRow();
        $dataKolom[2] = $result['jumlah'];

        $sql = "SELECT COUNT(pengperawatanlinen_id) AS jumlah
                FROM pengperawatanlinen_t
                WHERE DATE(tglpengperawatanlinen) = '".date('Y-m-d')."'";
        $result = Yii::app()->db->createCommand($sql)->queryRow();
        $dataKolom[3] = $result['jumlah'];

        $sql = "SELECT COUNT(perawatanlinen_id) AS jumlah
                FROM perawatanlinen_t
                WHERE DATE(tglperawatanlinen) = '".date('Y-m-d')."'";
        $result = Yii::app()->db->createCommand($sql)->queryRow();
        $dataKolom[4] = $result['jumlah'];
		
		//=== end 4 kolom ===
		
		//=== chart ===
		$sql = "SELECT DATE(pl.tglperawatanlinen) as tglperawatanlinen, count(pl.perawatanlinen_id) as jumlah
				FROM perawatanlinen_t pl JOIN
                                perawatanlinendetail_t pld ON pl.perawatanlinen_id = pld.perawatanlinen_id
				WHERE DATE(pl.tglperawatanlinen) BETWEEN '".date("Y-m")."-01' AND '".date("Y-m-d")."'                
				GROUP BY DATE(pl.tglperawatanlinen)
				ORDER BY pl.tglperawatanlinen ASC";
		$result = Yii::app()->db->createCommand($sql)->queryAll();

		$dataAreaChart = $result;
		//=== chart ===
		$sql = "SELECT DATE(pl.tglperawatanlinen) as tglperawatanlinen, count(pl.perawatanlinen_id) as jumlah_1
				FROM perawatanlinen_t pl JOIN
                                perawatanlinendetail_t pld ON pl.perawatanlinen_id = pld.perawatanlinen_id
				WHERE DATE(pl.tglperawatanlinen) BETWEEN '".date("Y-m")."-01' AND '".date("Y-m-d")."'                
					AND pld.statusperawatanlinen != '".Params::STATUSPERAWATAN_SELESAI."'                    
				GROUP BY DATE(pl.tglperawatanlinen)
				ORDER BY pl.tglperawatanlinen ASC";
		$result_1 = Yii::app()->db->createCommand($sql)->queryAll();                
		$sql = "SELECT DATE(pl.tglperawatanlinen) as tglperawatanlinen, count(pl.perawatanlinen_id) as jumlah_2
				FROM perawatanlinen_t pl JOIN
                                perawatanlinendetail_t pld ON pl.perawatanlinen_id = pld.perawatanlinen_id
				WHERE DATE(pl.tglperawatanlinen) BETWEEN '".date("Y-m")."-01' AND '".date("Y-m-d")."'                
					AND statusperawatanlinen = '".Params::STATUSPERAWATAN_SELESAI."'                    
				GROUP BY DATE(pl.tglperawatanlinen)
				ORDER BY pl.tglperawatanlinen ASC";
		$result_2 = Yii::app()->db->createCommand($sql)->queryAll();
        $dataLineChart = CustomFunction::joinTwo2DArrays($dataAreaChart, $result_1, 'tglperawatanlinen');
		$dataLineChart = CustomFunction::joinTwo2DArrays($dataLineChart, $result_2, 'tglperawatanlinen');
		
		$sql = "SELECT  pd.linen_id,l.namalinen,count(pd.linen_id) as jumlah
				FROM perawatanlinendetail_t pd
				JOIN perawatanlinen_t pl ON pl.perawatanlinen_id = pd.perawatanlinen_id
				JOIN linen_m l ON l.linen_id = pd.linen_id
				WHERE DATE(pl.tglperawatanlinen) BETWEEN '".date("Y-m")."-01' AND '".date("Y-m-d")."'					
				GROUP BY pd.linen_id, l.namalinen
				ORDER BY jumlah DESC
				";	
		$result = Yii::app()->db->createCommand($sql)->queryAll();
        $dataDonutChart = $result;
		
//		$sql = "SELECT carabayar_nama, count(pendaftaran_id) as jumlah
//				FROM pasienmasukpenunjang_v
//				WHERE DATE(tgl_pendaftaran) BETWEEN '".date("Y-m")."-01' AND '".date("Y-m-d")."'
//                AND instalasi_id = ".Params::INSTALASI_ID_LAB."
//				GROUP BY carabayar_nama
//				ORDER BY carabayar_nama ASC";
		$sql = "
				SELECT 
				r.ruangan_nama, count(t.pengperawatanlinen_id) as jumlah
				FROM pengperawatanlinen_t t JOIN ruangan_m r ON t.ruangan_id = r.ruangan_id 
				WHERE DATE(tglpengperawatanlinen) BETWEEN '".date("Y-m")."-01' AND '".date("Y-m-d")."'				
				GROUP BY r.ruangan_nama, t.tglpengperawatanlinen				
				";
                /*
                 * UNION
				SELECT 
				'Lainnya'::CHARACTER VARYING(50) AS penjamin_nama, count(pendaftaran_id) as jumlah
				FROM pasienmasukpenunjang_v
				WHERE DATE(tgl_pendaftaran) BETWEEN '".date("Y-m")."-01' AND '".date("Y-m-d")."'
				AND penjamin_id NOT IN (".Params::PENJAMIN_ID_PISA.",".Params::PENJAMIN_ID_PROKESPEN.") 
				AND instalasi_id = ".Params::INSTALASI_ID_LAB."
                 * 
                 */
		$result = Yii::app()->db->createCommand($sql)->queryAll();
        $dataPieChart = $result;

		$sql = "SELECT count(pld.perawatanlinendetail_id) as jumlah
				FROM perawatanlinen_t pl JOIN
                                perawatanlinendetail_t pld ON pl.perawatanlinen_id = pld.perawatanlinen_id
				WHERE DATE(pl.tglperawatanlinen) BETWEEN '".date("Y-m")."-01' AND '".date("Y-m-d")."'                
					AND pld.statusperawatanlinen = '".Params::STATUSPERAWATAN_SELESAI."'                    
				
				";
		$result = Yii::app()->db->createCommand($sql)->queryRow();
              
        $dataKolom[5] = $result['jumlah'];
		
		$sql = "SELECT count(pld.perawatanlinen_id) as jumlah
				FROM perawatanlinen_t pl JOIN
                                perawatanlinendetail_t pld ON pl.perawatanlinen_id = pld.perawatanlinen_id
				WHERE DATE(pl.tglperawatanlinen) BETWEEN '".date("Y-m")."-01' AND '".date("Y-m-d")."'                
					AND statusperawatanlinen != '".Params::STATUSPERAWATAN_SELESAI."'                    				
				";
		$result = Yii::app()->db->createCommand($sql)->queryRow();
        $dataKolom[6] = $result['jumlah'];
		
		$sql = "SELECT  l.namalinen,count(l.linen_id) as jumlah
				FROM pencuciandetail_t pd
				JOIN pencucianlinen_t pl ON pl.pencucianlinen_id = pd.pencucianlinen_id
				JOIN linen_m l ON l.linen_id = pd.linen_id
				WHERE DATE(pl.tglpencucianlinen) BETWEEN '".date("Y-m")."-01' AND '".date("Y-m-d")."'					
				GROUP BY l.namalinen
				ORDER BY jumlah DESC
				LIMIT 10";				
		$result = Yii::app()->db->createCommand($sql)->queryAll();
        $dataBarChart = $result;
		//=== end chart ===

		//=== start table ===
		// $criteria_updatepasien = new CDbCriteria();
		// $criteria_updatepasien->limit=5;
		// $criteria_updatepasien->order = 'tgl_pendaftaran DESC';
		// $dataTable = LBPendaftaranMp::model()->findAll($criteria_updatepasien);
		
		
		//$dataTable = new LBPasienMasukPenunjangV("searchPemeriksaan");
		
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
					//'dataTable'=>$dataTable,
					'modTodolist'=>$modTodolist,
					'dataProviderTodolist'=>$dataProviderTodolist,
					'dataMap'=>$dataMap,
		));

    }
}
?>