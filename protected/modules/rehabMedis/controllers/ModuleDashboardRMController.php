<?php
Yii::import("pendaftaranPenjadwalan.controllers.ModuleDashboardNeonController");
Yii::import("pendaftaranPenjadwalan.models.*");
class ModuleDashboardRMController extends ModuleDashboardNeonController
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
				FROM pasienmasukpenunjang_v
				WHERE DATE(tglmasukpenunjang) = '".date('Y-m-d')."'
					AND instalasi_id != ".Params::INSTALASI_ID_REHAB;
		$result = Yii::app()->db->createCommand($sql)->queryRow();
        $dataKolom[1] = $result['jumlah'];
		
		$sql = "SELECT COUNT(pasien_id) AS jumlah
				FROM pasienmasukpenunjang_v
				WHERE DATE(tglmasukpenunjang) = '".date('Y-m-d')."'
					AND instalasi_id = ".Params::INSTALASI_ID_REHAB;
		$result = Yii::app()->db->createCommand($sql)->queryRow();
        $dataKolom[2] = $result['jumlah'];
		
		$sql = "SELECT COUNT(pasien_id) AS jumlah
				FROM hasilpemeriksaanrm_t
				WHERE DATE(tglpemeriksaanrm) = '".date('Y-m-d')."'";
		$result = Yii::app()->db->createCommand($sql)->queryRow();
        $dataKolom[3] = $result['jumlah'];
		
		$sql = "SELECT COUNT(pasien_id) AS jumlah
				FROM pasienmasukpenunjang_v
				WHERE DATE(tglmasukpenunjang) = '".date('Y-m-d')."'
					AND instalasi_id = ".Params::INSTALASI_ID_REHAB."
					AND LOWER(statusperiksa) = '".strtolower(Params::STATUSPERIKSA_ANTRIAN)."'";
		$result = Yii::app()->db->createCommand($sql)->queryRow();
        $dataKolom[4] = $result['jumlah'];
		
		//=== end 4 kolom ===
		
		//=== chart ===
		$sql = "SELECT DATE(tglmasukpenunjang) as tglmasukpenunjang, count(pasien_id) as jumlah
				FROM pasienmasukpenunjang_v
				WHERE DATE(tglmasukpenunjang) BETWEEN '".date("Y-m")."-01' AND '".date("Y-m-d")."'
					AND instalasi_id = ".Params::INSTALASI_ID_REHAB."
				GROUP BY DATE(tglmasukpenunjang)
				ORDER BY tglmasukpenunjang ASC";
		$result = Yii::app()->db->createCommand($sql)->queryAll();

		$dataAreaChart = $result;
		//=== chart ===
		$sql = "SELECT DATE(tglmasukpenunjang) as tglmasukpenunjang, count(pendaftaran_id) as jumlah_1
				FROM pasienmasukpenunjang_v
				WHERE DATE(tglmasukpenunjang) BETWEEN '".date("Y-m")."-01' AND '".date("Y-m-d")."'
					AND ruangan_id = '".Yii::app()->user->getState('ruangan_id')."'
					AND jeniskasuspenyakit_id = 53
				GROUP BY DATE(tglmasukpenunjang)
				ORDER BY tglmasukpenunjang ASC";
		$result_1 = Yii::app()->db->createCommand($sql)->queryAll();
		$sql = "SELECT DATE(tglmasukpenunjang) as tglmasukpenunjang, count(pendaftaran_id) as jumlah_2
				FROM pasienmasukpenunjang_v
				WHERE DATE(tglmasukpenunjang) BETWEEN '".date("Y-m")."-01' AND '".date("Y-m-d")."'
					AND ruangan_id = '".Yii::app()->user->getState('ruangan_id')."'
					AND jeniskasuspenyakit_id = 74
				GROUP BY DATE(tglmasukpenunjang)
				ORDER BY tglmasukpenunjang ASC";
		$result_2 = Yii::app()->db->createCommand($sql)->queryAll();
		$sql = "SELECT DATE(tglmasukpenunjang) as tglmasukpenunjang, count(pendaftaran_id) as jumlah_3
				FROM pasienmasukpenunjang_v
				WHERE DATE(tglmasukpenunjang) BETWEEN '".date("Y-m")."-01' AND '".date("Y-m-d")."'
					AND ruangan_id = '".Yii::app()->user->getState('ruangan_id')."'
					AND jeniskasuspenyakit_id = 77
				GROUP BY DATE(tglmasukpenunjang)
				ORDER BY tglmasukpenunjang ASC";
		$result_3 = Yii::app()->db->createCommand($sql)->queryAll();
		$sql = "SELECT DATE(tglmasukpenunjang) as tglmasukpenunjang, count(pendaftaran_id) as jumlah_4
				FROM pasienmasukpenunjang_v
				WHERE DATE(tglmasukpenunjang) BETWEEN '".date("Y-m")."-01' AND '".date("Y-m-d")."'
					AND ruangan_id = '".Yii::app()->user->getState('ruangan_id')."'
					AND jeniskasuspenyakit_id = 78
				GROUP BY DATE(tglmasukpenunjang)
				ORDER BY tglmasukpenunjang ASC";
		$result_4 = Yii::app()->db->createCommand($sql)->queryAll();
		$sql = "SELECT DATE(tglmasukpenunjang) as tglmasukpenunjang, count(pendaftaran_id) as jumlah_5
				FROM pasienmasukpenunjang_v
				WHERE DATE(tglmasukpenunjang) BETWEEN '".date("Y-m")."-01' AND '".date("Y-m-d")."'
					AND ruangan_id = '".Yii::app()->user->getState('ruangan_id')."'
					AND jeniskasuspenyakit_id = 79
				GROUP BY DATE(tglmasukpenunjang)
				ORDER BY tglmasukpenunjang ASC";
		$result_5 = Yii::app()->db->createCommand($sql)->queryAll();
		$sql = "SELECT DATE(tglmasukpenunjang) as tglmasukpenunjang, count(pendaftaran_id) as jumlah_6
				FROM pasienmasukpenunjang_v
				WHERE DATE(tglmasukpenunjang) BETWEEN '".date("Y-m")."-01' AND '".date("Y-m-d")."'
					AND ruangan_id = '".Yii::app()->user->getState('ruangan_id')."'
					AND jeniskasuspenyakit_id = 80
				GROUP BY DATE(tglmasukpenunjang)
				ORDER BY tglmasukpenunjang ASC";
		$result_6 = Yii::app()->db->createCommand($sql)->queryAll();
		$dataLineChart = CustomFunction::joinTwo2DArrays($dataLineChart, $result_1,'tglmasukpenunjang');
		$dataLineChart = CustomFunction::joinTwo2DArrays($dataLineChart, $result_2,'tglmasukpenunjang');
		$dataLineChart = CustomFunction::joinTwo2DArrays($dataLineChart, $result_3,'tglmasukpenunjang');
		$dataLineChart = CustomFunction::joinTwo2DArrays($dataLineChart, $result_4,'tglmasukpenunjang');
		$dataLineChart = CustomFunction::joinTwo2DArrays($dataLineChart, $result_5,'tglmasukpenunjang');
		$dataLineChart = CustomFunction::joinTwo2DArrays($dataLineChart, $result_6,'tglmasukpenunjang');
		
		$sql = "SELECT tindakanrm_m.tindakanrm_nama, count(hasilpemeriksaanrm_t.pendaftaran_id) as jumlah
				FROM hasilpemeriksaanrm_t
				JOIN tindakanrm_m on tindakanrm_m.tindakanrm_id = hasilpemeriksaanrm_t.tindakanrm_id
				WHERE DATE(hasilpemeriksaanrm_t.tglpemeriksaanrm) BETWEEN '".date("Y-m")."-01' AND '".date("Y-m-d")."'
				GROUP BY tindakanrm_m.tindakanrm_nama
				ORDER BY tindakanrm_m.tindakanrm_nama ASC";
		$result = Yii::app()->db->createCommand($sql)->queryAll();
        $dataDonutChart = $result;
		
		$sql = "SELECT carabayar_nama, count(pendaftaran_id) as jumlah
				FROM pasienmasukpenunjang_v
				WHERE DATE(tglmasukpenunjang) BETWEEN '".date("Y-m")."-01' AND '".date("Y-m-d")."'
					AND ruangan_id = '".Yii::app()->user->getState('ruangan_id')."'
					AND instalasi_id = ".Params::INSTALASI_ID_REHAB."
				GROUP BY carabayar_nama
				ORDER BY carabayar_nama ASC";
		$result = Yii::app()->db->createCommand($sql)->queryAll();
        $dataPieChart = $result;
		
		$sql = "SELECT COUNT(pendaftaran_id) AS jumlah
				FROM pasienmasukpenunjang_v
				WHERE DATE(tgl_pendaftaran) BETWEEN '".date("Y-m")."-01' AND '".date("Y-m-d")."'
					AND LOWER(statusmasuk) = '".strtolower(Params::STATUSMASUK_RUJUKAN)."'
					AND ruangan_id = '".Yii::app()->user->getState('ruangan_id')."'";
		$result = Yii::app()->db->createCommand($sql)->queryRow();
        $dataKolom[5] = $result['jumlah'];
		
		$sql = "SELECT COUNT(pendaftaran_id) AS jumlah
				FROM pasienmasukpenunjang_v
				WHERE DATE(tgl_pendaftaran) BETWEEN '".date("Y-m")."-01' AND '".date("Y-m-d")."'
					AND LOWER(statusmasuk) = '".strtolower(Params::STATUSMASUK_NONRUJUKAN)."'
					AND ruangan_id = '".Yii::app()->user->getState('ruangan_id')."'";
		$result = Yii::app()->db->createCommand($sql)->queryRow();
        $dataKolom[6] = $result['jumlah'];


		$sql = "SELECT tindakanrm_m.tindakanrm_nama,count(hasilpemeriksaanrm_t.pendaftaran_id) as jumlah
				FROM hasilpemeriksaanrm_t
				JOIN tindakanrm_m on tindakanrm_m.tindakanrm_id = hasilpemeriksaanrm_t.tindakanrm_id
				WHERE date_part('year',hasilpemeriksaanrm_t.tglpemeriksaanrm) = '".date('Y')."'
				GROUP BY tindakanrm_m.tindakanrm_nama
				ORDER BY jumlah DESC
				LIMIT 10";
		$result = Yii::app()->db->createCommand($sql)->queryAll();
        $dataBarChart = $result;
		//=== end chart ===

		//=== start table ===
		$dataTable = new RMHasilpemeriksaanrmT("search10Terakhir");
		
		//=== end table ===

		//=== start todo list ===
		$modTodolist = new PPTodolistR;
        $dataProviderTodolist = $modTodolist->searchTodolistWidget();
		//=== end todo list ===

		//=== start map ===
		$sql = "SELECT kecamatan_m.kecamatan_id, kecamatan_m.kecamatan_nama, kecamatan_m.longitude, kecamatan_m.latitude,COUNT(pasienmasukpenunjang_v.pasien_id) AS jumlah
				FROM pasienmasukpenunjang_v
				JOIN pasien_m ON pasienmasukpenunjang_v.pasien_id = pasien_m.pasien_id
				JOIN kecamatan_m ON pasien_m.kecamatan_id = kecamatan_m.kecamatan_id
				WHERE date_part('year',tglmasukpenunjang) = '".date('Y')."'
				AND pasienmasukpenunjang_v.instalasi_id != ".Params::INSTALASI_ID_REHAB."
				GROUP BY kecamatan_m.kecamatan_id, kecamatan_m.kecamatan_nama, kecamatan_m.longitude, kecamatan_m.latitude
				ORDER BY jumlah DESC
				LIMIT 10
				";
		$result = Yii::app()->db->createCommand($sql)->queryAll();
		$dataMap = $result;
		$modPropinsi = PropinsiM::model()->findByPk(Yii::app()->user->getState('propinsi_id'));
		$latitude = $modPropinsi->latitude;
		$longitude = $modPropinsi->longitude;
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
					'latitude'=>$latitude,
					'longitude'=>$longitude,
		));

    }
	
	/**
     * menampilkan data kecamatan berdasarkan diagnosa_id dari ajax
     * @throws CHttpException
     */
    public function actionSetKecamatan(){
        if(Yii::app()->request->isAjaxRequest)
        {
            $data = array();
            $diagnosa_id = (isset($_POST['diagnosa_id']) ? $_POST['diagnosa_id'] : null);
            if(!empty($diagnosa_id)){
				//=== start map ===
				$sql = "SELECT kecamatan_m.kecamatan_id, kecamatan_m.kecamatan_nama, kecamatan_m.longitude, kecamatan_m.latitude, diagnosa_m.diagnosa_id, diagnosa_m.diagnosa_kode, diagnosa_m.diagnosa_nama,COUNT(pasienmorbiditas_id) AS jumlah
						FROM pasienmorbiditas_t
						JOIN pasien_m ON pasienmorbiditas_t.pasien_id = pasien_m.pasien_id
						JOIN diagnosa_m ON diagnosa_m.diagnosa_id = pasienmorbiditas_t.diagnosa_id
						JOIN kecamatan_m ON pasien_m.kecamatan_id = kecamatan_m.kecamatan_id
						WHERE date_part('year',tglmorbiditas) = '".date('Y')."' AND diagnosa_m.diagnosa_id = '".$diagnosa_id."'
						GROUP BY kecamatan_m.kecamatan_id, kecamatan_m.kecamatan_nama, kecamatan_m.longitude, kecamatan_m.latitude, diagnosa_m.diagnosa_id, diagnosa_m.diagnosa_kode, diagnosa_m.diagnosa_nama
						ORDER BY jumlah DESC
						LIMIT 10
						";
				$result = Yii::app()->db->createCommand($sql)->queryAll();
				$dataMap = $result;
				//=== end map ===
            }else{
            }			
			if(count($dataMap) > 0){
				foreach($dataMap as $i=>$map){
					$data[$i]['latitude'] = $map['latitude'];
					$data[$i]['longitude'] = $map['longitude'];
					$data[$i]['kecamatan_nama'] = $map['kecamatan_nama'];
				}
			}
            echo CJSON::encode($data);
            Yii::app()->end();
        }
        else
            throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
    }
}
?>