<?php
Yii::import("pendaftaranPenjadwalan.controllers.ModuleDashboardNeonController");
Yii::import("pendaftaranPenjadwalan.models.PPTodolistR");

class ModuleDashboardAMController extends ModuleDashboardNeonController
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
		
		$sql = "SELECT COUNT(pesanambulans_t) AS jumlah
                FROM pesanambulans_t
                WHERE DATE(tglpemesananambulans) = '".date('Y-m-d')."' AND pendaftaran_id IS null";
        $result = Yii::app()->db->createCommand($sql)->queryRow();
        $dataKolom[1] = $result['jumlah'];

        $sql = "SELECT COUNT(pesanambulans_t) AS jumlah
                FROM pesanambulans_t
                WHERE DATE(tglpemesananambulans) = '".date('Y-m-d')."' AND pendaftaran_id IS NOT null";
        $result = Yii::app()->db->createCommand($sql)->queryRow();
        $dataKolom[2] = $result['jumlah'];

        $sql = "SELECT COUNT(pemakaianambulans_id) AS jumlah
                FROM informasipemakaianambulans_v
                WHERE DATE(tglpemakaianambulans) = '".date('Y-m-d')."'";
        $result = Yii::app()->db->createCommand($sql)->queryRow();
        $dataKolom[3] = $result['jumlah'];

        $sql = "SELECT COUNT(batalpakaiambulans_id) AS jumlah
                FROM batalpakaiambulans_t
                WHERE DATE(tglpembatalan) = '".date('Y-m-d')."'";
        $result = Yii::app()->db->createCommand($sql)->queryRow();
        $dataKolom[4] = $result['jumlah'];
		
		//=== end 4 kolom ===
		
		//=== chart ===
		$sql = "SELECT DATE(tglpemesananambulans) as tglpemesananambulans, count(pesanambulans_t) as jumlah
				FROM pesanambulans_t
				WHERE DATE(tglpemesananambulans) BETWEEN '".date("Y-m")."-01' AND '".date("Y-m-d")."'
				GROUP BY DATE(tglpemesananambulans)
				ORDER BY tglpemesananambulans ASC";
		$result = Yii::app()->db->createCommand($sql)->queryAll();

		$dataAreaChart = $result;
		//=== chart ===
		$sql = "SELECT DATE(tglpemesananambulans) as tglpemesananambulans, count(pesanambulans_t) as jumlah_1
				FROM pesanambulans_t
				WHERE DATE(tglpemesananambulans) BETWEEN '".date("Y-m")."-01' AND '".date("Y-m-d")."'
				AND pendaftaran_id IS null
				GROUP BY DATE(tglpemesananambulans)
				ORDER BY tglpemesananambulans ASC";
		$result_1 = Yii::app()->db->createCommand($sql)->queryAll();
		$sql = "SELECT DATE(tglpemesananambulans) as tglpemesananambulans, count(pesanambulans_t) as jumlah_2
				FROM pesanambulans_t
				WHERE DATE(tglpemesananambulans) BETWEEN '".date("Y-m")."-01' AND '".date("Y-m-d")."'
				AND pendaftaran_id IS NOT null
				GROUP BY DATE(tglpemesananambulans)
				ORDER BY tglpemesananambulans ASC";
		$result_2 = Yii::app()->db->createCommand($sql)->queryAll();
        $dataLineChart = CustomFunction::joinTwo2DArrays($dataLineChart, $result_1, 'tglpemesananambulans');
		$dataLineChart = CustomFunction::joinTwo2DArrays($dataLineChart, $result_2, 'tglpemesananambulans');
		
		$sql = "SELECT instalasi_nama, count(instalasi_id) as jumlah
				FROM informasipemakaianambulans_v
				WHERE DATE(tglpemakaianambulans) BETWEEN '".date("Y-m")."-01' AND '".date("Y-m-d")."'
				GROUP BY instalasi_nama
				ORDER BY instalasi_nama ASC";
		$result = Yii::app()->db->createCommand($sql)->queryAll();
        $dataDonutChart = $result;
		
		$sql = "SELECT mobilambulans_m.nopolisi, count(pemakaianambulans_t.mobilambulans_id) as jumlah
				FROM pemakaianambulans_t
				JOIN mobilambulans_m ON mobilambulans_m.mobilambulans_id = pemakaianambulans_t.mobilambulans_id
				GROUP BY mobilambulans_m.nopolisi
				ORDER BY mobilambulans_m.nopolisi DESC";
		$result = Yii::app()->db->createCommand($sql)->queryAll();
        $dataPieChart = $result;

		$sql = "SELECT COUNT(pemakaianambulans_id) AS jumlah
				FROM informasipemakaianambulans_v
				WHERE DATE(tglpemakaianambulans) BETWEEN '".date("Y-m")."-01' AND '".date("Y-m-d")."'";
		$result = Yii::app()->db->createCommand($sql)->queryRow();
        $dataKolom[5] = $result['jumlah'];
		
		$sql = "SELECT COUNT(batalpakaiambulans_id) AS jumlah
				FROM batalpakaiambulans_t
				WHERE DATE(tglpembatalan) BETWEEN '".date("Y-m")."-01' AND '".date("Y-m-d")."'";
		$result = Yii::app()->db->createCommand($sql)->queryRow();
        $dataKolom[6] = $result['jumlah'];
		
		
		
		$sql = "SELECT alamattujuan, count(pemakaianambulans_id) as jumlah
				FROM informasipemakaianambulans_v
				WHERE DATE(tglpemakaianambulans) BETWEEN '".date("Y-m")."-01' AND '".date("Y-m-d")."'
				GROUP BY alamattujuan
				ORDER BY alamattujuan ASC";
		$result = Yii::app()->db->createCommand($sql)->queryAll();
        $dataBarChart = $result;
		//=== end chart ===

		//=== start table ===
		// $criteria_updatepasien = new CDbCriteria();
		// $criteria_updatepasien->limit=5;
		// $criteria_updatepasien->order = 'tgl_pendaftaran DESC';
		// $dataTable = LKPendaftaranMp::model()->findAll($criteria_updatepasien);
		
		
		$dataTable = new AMPesanambulansT("searchPemesananAmbulans");
		
		//=== end table ===

		//=== start todo list ===
		$modTodolist = new PPTodolistR;
        $dataProviderTodolist = $modTodolist->searchTodolistWidget();
		//=== end todo list ===

		//=== start map ===
		$sql = "SELECT alamattujuan, longitude, latitude, count(pemakaianambulans_id) as jumlah
				FROM informasipemakaianambulans_v
				WHERE date_part('year',tglpemakaianambulans) = '".date('Y')."'
				GROUP BY alamattujuan, longitude, latitude
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