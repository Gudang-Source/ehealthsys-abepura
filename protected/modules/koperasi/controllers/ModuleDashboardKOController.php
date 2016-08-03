<?php
Yii::import("pendaftaranPenjadwalan.controllers.ModuleDashboardNeonController");
Yii::import("pendaftaranPenjadwalan.models.PPTodolistR");

class ModuleDashboardKOController extends ModuleDashboardNeonController
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
	
        $tglAwal = date('Y-m-d', strtotime('first day of this month'));
        $tglAkhir = date('Y-m-d');
        
        $sql = "SELECT SUM(jumlahsimpanan) AS jumlah
                FROM simpanan_t
                WHERE (tglsimpanan BETWEEN '".$tglAwal."' AND '".$tglAkhir."')";
        $result = Yii::app()->db->createCommand($sql)->queryRow();
        $dataKolom[1] = $result['jumlah'];//total simpanan

        $sql = "SELECT SUM(jml_pinjaman) AS jumlah
                FROM pinjaman_t
                WHERE (tglpinjaman BETWEEN '".$tglAwal."' AND '".$tglAkhir."')";
        $result = Yii::app()->db->createCommand($sql)->queryRow();
        $dataKolom[2] = $result['jumlah'];//total pinjaman

        $sql = "SELECT keanggotaan_id 
                FROM permohonanpinjaman_t
                WHERE DATE(tglpermohonanpinjaman) = '".date('Y-m-d')."' GROUP BY keanggotaan_id";
        $result = Yii::app()->db->createCommand($sql)->queryRow();
        $dataKolom[3] = ($result == false)?0:count($result);//permohonan pinjaman
        

        $sql = "SELECT SUM(jmlbayar_pembangsuran) AS jumlah
                FROM pembayaranangsuran_t
                WHERE (tglpembayaranangsuran BETWEEN '".$tglAwal."' AND '".$tglAkhir."')";
        $result = Yii::app()->db->createCommand($sql)->queryRow();
        $dataKolom[4] = $result['jumlah']; //pembarayn angsuran
		
		//=== end 4 kolom ===
		
		//=== chart ===
		$sql = "SELECT DATE(tglditerima) as tglditerima, count(pegawai_id) as jumlah
				FROM pegawai_m
				WHERE DATE(tglditerima) BETWEEN '".date("Y-m")."-01' AND '".date("Y-m-d")."'
				AND tglberhenti IS NULL
				GROUP BY DATE(tglditerima)
				ORDER BY tglditerima ASC";
		$result = Yii::app()->db->createCommand($sql)->queryAll();

		$dataAreaChart = $result;
		//=== chart ===
		$sql = "SELECT DATE(presensi_t.tglpresensi) as tglpresensi, count(presensi_t.pegawai_id) as jumlah_1
				FROM presensi_t
				JOIN statuskehadiran_m ON presensi_t.statuskehadiran_id = statuskehadiran_m.statuskehadiran_id
				WHERE DATE(presensi_t.tglpresensi) BETWEEN '".date("Y-m")."-01' AND '".date("Y-m-d")."'
				AND statuskehadiran_m.statuskehadiran_id = 1
				GROUP BY DATE(presensi_t.tglpresensi)
				ORDER BY tglpresensi ASC";
		$result_1 = Yii::app()->db->createCommand($sql)->queryAll();
        $dataLineChart = CustomFunction::joinTwo2DArrays($dataLineChart, $result_1, 'tglpresensi');

        $sql = "SELECT DATE(presensi_t.tglpresensi) as tglpresensi, count(presensi_t.pegawai_id) as jumlah_2
				FROM presensi_t
				JOIN statuskehadiran_m ON presensi_t.statuskehadiran_id = statuskehadiran_m.statuskehadiran_id
				WHERE DATE(presensi_t.tglpresensi) BETWEEN '".date("Y-m")."-01' AND '".date("Y-m-d")."'
				AND statuskehadiran_m.statuskehadiran_id = 2
				GROUP BY DATE(presensi_t.tglpresensi)
				ORDER BY tglpresensi ASC";
		$result_2 = Yii::app()->db->createCommand($sql)->queryAll();
        $dataLineChart = CustomFunction::joinTwo2DArrays($dataLineChart, $result_2, 'tglpresensi');

        $sql = "SELECT DATE(presensi_t.tglpresensi) as tglpresensi, count(presensi_t.pegawai_id) as jumlah_3
				FROM presensi_t
				JOIN statuskehadiran_m ON presensi_t.statuskehadiran_id = statuskehadiran_m.statuskehadiran_id
				WHERE DATE(presensi_t.tglpresensi) BETWEEN '".date("Y-m")."-01' AND '".date("Y-m-d")."'
				AND statuskehadiran_m.statuskehadiran_id = 3
				GROUP BY DATE(presensi_t.tglpresensi)
				ORDER BY tglpresensi ASC";
		$result_3 = Yii::app()->db->createCommand($sql)->queryAll();
        $dataLineChart = CustomFunction::joinTwo2DArrays($dataLineChart, $result_3, 'tglpresensi');

        $sql = "SELECT DATE(presensi_t.tglpresensi) as tglpresensi, count(presensi_t.pegawai_id) as jumlah_4
				FROM presensi_t
				JOIN statuskehadiran_m ON presensi_t.statuskehadiran_id = statuskehadiran_m.statuskehadiran_id
				WHERE DATE(presensi_t.tglpresensi) BETWEEN '".date("Y-m")."-01' AND '".date("Y-m-d")."'
				AND statuskehadiran_m.statuskehadiran_id = 4
				GROUP BY DATE(presensi_t.tglpresensi)
				ORDER BY tglpresensi ASC";
		$result_4 = Yii::app()->db->createCommand($sql)->queryAll();
        $dataLineChart = CustomFunction::joinTwo2DArrays($dataLineChart, $result_4, 'tglpresensi');

        $sql = "SELECT DATE(presensi_t.tglpresensi) as tglpresensi, count(presensi_t.pegawai_id) as jumlah_5
				FROM presensi_t
				JOIN statuskehadiran_m ON presensi_t.statuskehadiran_id = statuskehadiran_m.statuskehadiran_id
				WHERE DATE(presensi_t.tglpresensi) BETWEEN '".date("Y-m")."-01' AND '".date("Y-m-d")."'
				AND statuskehadiran_m.statuskehadiran_id = 5
				GROUP BY DATE(presensi_t.tglpresensi)
				ORDER BY tglpresensi ASC";
		$result_5 = Yii::app()->db->createCommand($sql)->queryAll();
        $dataLineChart = CustomFunction::joinTwo2DArrays($dataLineChart, $result_5, 'tglpresensi');

		$sql = "SELECT kelompokjabatan, count(pegawai_id) as jumlah
				FROM pegawai_m
				WHERE DATE(tglditerima) BETWEEN '".date("Y-m")."-01' AND '".date("Y-m-d")."'
				AND tglberhenti IS NULL
				GROUP BY kelompokjabatan
				ORDER BY kelompokjabatan ASC";
		$result = Yii::app()->db->createCommand($sql)->queryAll();
        $dataDonutChart = $result;
		
		$sql = "SELECT pendidikan_m.pendidikan_nama, count(pegawai_m.pegawai_id) as jumlah
				FROM pegawai_m
				JOIN pendidikan_m ON pendidikan_m.pendidikan_id = pegawai_m.pendidikan_id
				GROUP BY pendidikan_m.pendidikan_nama
				ORDER BY pendidikan_m.pendidikan_nama DESC";
		$result = Yii::app()->db->createCommand($sql)->queryAll();
        $dataPieChart = $result;

		$sql = "SELECT COUNT(pegawai_id) AS jumlah
				FROM realisasilembur_t
				WHERE DATE(tglrealisasi) BETWEEN '".date("Y-m")."-01' AND '".date("Y-m-d")."'";
		$result = Yii::app()->db->createCommand($sql)->queryRow();
        $dataKolom[5] = $result['jumlah'];
		
		$sql = "SELECT COUNT(pegawai_id) AS jumlah
				FROM pegawaicuti_t
				WHERE DATE(tglmulaicuti) BETWEEN '".date("Y-m")."-01' AND '".date("Y-m-d")."'";
		$result = Yii::app()->db->createCommand($sql)->queryRow();
        $dataKolom[6] = $result['jumlah'];
		
		
		
		$sql = "SELECT minatpekerjaan, count(pelamar_id) as jumlah
				FROM pelamar_t
				WHERE DATE(create_time) BETWEEN '".date("Y-m")."-01' AND '".date("Y-m-d")."'
				GROUP BY minatpekerjaan
				ORDER BY minatpekerjaan ASC";
		$result = Yii::app()->db->createCommand($sql)->queryAll();
        $dataBarChart = $result;
		//=== end chart ===

		//=== start table ===
		// $criteria_updatepasien = new CDbCriteria();
		// $criteria_updatepasien->limit=5;
		// $criteria_updatepasien->order = 'tgl_pendaftaran DESC';
		// $dataTable = LKPendaftaranMp::model()->findAll($criteria_updatepasien);
		
		
		$dataTable = new KOPegawaiM("search10PegawaiBaru");
		
		//=== end table ===

		//=== start todo list ===
		$modTodolist = new PPTodolistR;
        $dataProviderTodolist = $modTodolist->searchTodolistWidget();
		//=== end todo list ===

		//=== start map ===
		$sql = "SELECT kecamatan_m.kecamatan_nama, kecamatan_m.longitude, kecamatan_m.latitude, count(pegawai_m.pegawai_id) as jumlah
				FROM pegawai_m
				JOIN kecamatan_m ON kecamatan_m.kecamatan_id = pegawai_m.kecamatan_id
				WHERE date_part('year',tglditerima) = '".date('Y')."'
				GROUP BY kecamatan_m.kecamatan_nama, kecamatan_m.longitude, kecamatan_m.latitude
				ORDER BY jumlah DESC
				LIMIT 10
				";
		$result = Yii::app()->db->createCommand($sql)->queryAll();
		$dataMap = $result;
		//=== end map ===
		$periode = MyFormatter::getMonthId(date('m'))." ".date('Y');
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
                    'periode'=>$periode
		));

    }
}
?>