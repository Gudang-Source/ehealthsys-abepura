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
        $sql = "SELECT DATE(tglpinjaman) as tglditerima, count(keanggotaan_id) as jumlah
                        FROM pinjaman_t
                        WHERE DATE(tglpinjaman) BETWEEN '".date("Y-m")."-01' AND '".date("Y-m-d")."'
                        AND statuspinjaman = TRUE
                        GROUP BY DATE(tglpinjaman)
                        ORDER BY tglpinjaman ASC";
        $result = Yii::app()->db->createCommand($sql)->queryAll();

        $dataAreaChart = $result;
        //=== chart ===
        
        $sql = "SELECT DATE(tgl_kasmasuk) as tgl_kasmasuk, SUM(uangditerima) as jumlah_1
				FROM laporankasmasukkop_v				
				WHERE DATE(tgl_kasmasuk) BETWEEN '".date("Y-m")."-01' AND '".date("Y-m-d")."'
				AND jenistransaksi_id = 1
				GROUP BY DATE(tgl_kasmasuk)
				ORDER BY tgl_kasmasuk ASC";
		$result_1 = Yii::app()->db->createCommand($sql)->queryAll();
        $dataLineChart = CustomFunction::joinTwo2DArrays($dataLineChart, $result_1, 'tgl_kasmasuk');

         $sql = "SELECT DATE(tgl_kasmasuk) as tgl_kasmasuk, SUM(uangditerima) as jumlah_1
				FROM laporankasmasukkop_v				
				WHERE DATE(tgl_kasmasuk) BETWEEN '".date("Y-m")."-01' AND '".date("Y-m-d")."'
				AND jenistransaksi_id = 2
				GROUP BY DATE(tgl_kasmasuk)
				ORDER BY tgl_kasmasuk ASC";
		$result_2 = Yii::app()->db->createCommand($sql)->queryAll();
        $dataLineChart = CustomFunction::joinTwo2DArrays($dataLineChart, $result_2, 'tgl_kasmasuk');
        

		$sql = "SELECT namatransaksi, count(buktikasmasukkop_id) as jumlah
				FROM laporankasmasukkop_v
				WHERE DATE(tgl_kasmasuk) BETWEEN '".date("Y-m")."-01' AND '".date("Y-m-d")."'				
				GROUP BY namatransaksi
				ORDER BY namatransaksi ASC";
		$result = Yii::app()->db->createCommand($sql)->queryAll();
        $dataDonutChart = $result;
		
		$sql = "SELECT jenispinjaman_permohonan, count(keanggotaan_id) as jumlah
				FROM permohonanpinjaman_t	
                                WHERE DATE(tglpermohonanpinjaman) BETWEEN '".date("Y-m")."-01' AND '".date("Y-m-d")."'
				GROUP BY jenispinjaman_permohonan
				ORDER BY jenispinjaman_permohonan DESC";
		$result = Yii::app()->db->createCommand($sql)->queryAll();
        $dataPieChart = $result;

		$sql = "SELECT SUM(uangditerima) AS jumlah
				FROM laporankasmasukkop_v
				WHERE (tgl_kasmasuk BETWEEN '".$tglAwal."' AND '".$tglAkhir."')";
		$result = Yii::app()->db->createCommand($sql)->queryRow();
        $dataKolom[5] = $result['jumlah'];
		
		$sql = "SELECT SUM(jmlkaskeluar) AS jumlah
				FROM laporankaskeluarkop_v
				WHERE (tgl_bkk BETWEEN '".$tglAwal."' AND '".$tglAkhir."')";
		$result = Yii::app()->db->createCommand($sql)->queryRow();
        $dataKolom[6] = $result['jumlah'];
		
		
		
		$sql = "SELECT nama_pegawai, SUM(jmlpinjaman) as jumlah
				FROM informasipermohonanpinjaman_v
				WHERE (tglpermohonanpinjaman BETWEEN '".$tglAwal."' AND '".$tglAkhir."')
				GROUP BY nama_pegawai
				ORDER BY jumlah DESC";
		$result = Yii::app()->db->createCommand($sql)->queryAll();
        $dataBarChart = $result;
		//=== end chart ===

		//=== start table ===
		// $criteria_updatepasien = new CDbCriteria();
		// $criteria_updatepasien->limit=5;
		// $criteria_updatepasien->order = 'tgl_pendaftaran DESC';
		// $dataTable = LKPendaftaranMp::model()->findAll($criteria_updatepasien);
		
		
		$dataTable = new KOInformasipermohonanpinjamanV("search10PegawaiBaru");
		
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
                
                $gaji = KOInfopengajuanpemotonganV::model()->findAll(array('condition'=>"potongansumber_id = 1"));
		$insentif = KOInfopengajuanpemotonganV::model()->findAll(array('condition'=>"potongansumber_id = 2"));
		$totGaji = 0;
		$totInsentif = 0;
		foreach ($gaji as $key => $value) {
			$totGaji+=$value->jmlpengajuan_pengangsuran;
		}
		foreach ($insentif as $key => $value) {
			$totInsentif+=$value->jmlpengajuan_pengangsuran;
		}
		$totPot = $totGaji + $totInsentif;
                
                
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
                    'periode'=>$periode,
                    'totGaji' => $totGaji,
                    'totInsentif' => $totInsentif,
                    'totPot' => $totPot
		));

    }
}
?>