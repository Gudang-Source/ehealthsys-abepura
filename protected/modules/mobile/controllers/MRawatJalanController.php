<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MRawatJalanController
 *
 * @author programer
 */
ini_set('memory_limit', '128M');
class MRawatJalanController extends Controller {
	//put your code here
	/**
	 * set form pendaftaran rawat jalan
	 * MA-281
	 * @params: ruangan_id, pendaftaran_id, pasienadmisi_id
	 * @return:
	 * - 
	 */
	
	public function actionSetFormPendaftaran(){
		header("content-type:application/json");
		$data = array();
		$data['jenisidentitas'] = array();
		$data['namadepan'] = array();
		$data['jeniskelamin'] = array();
		$data['golongandarah'] = array();
		$data['rhesus'] = array();
		$data['statusperkawinan'] = array();
		$data['warganegara'] = array();
		$data['agama'] = array();
		$data['propinsi'] = array();
		$data['kabupaten'] = array();
		$data['kecamatan'] = array();
		$data['kelurahan'] = array();
		$data['pekerjaan'] = array();
		$data['suku'] = array();
		$data['pendidikan'] = array();
		
		$data['ruangan'] = array();
		$data['jeniskasuspenyakit'] = array();
		$data['kelaspelayanan'] = array();
		$data['carabayar'] = array();
		$data['penjamin'] = array();
		
		$data['kelastanggunganasuransi'] = array();
		//default
		$ruangan_id = null;
		$carabayar_id = null;
		
		$sql = "SELECT lookup_type, lookup_name, lookup_value
				FROM lookup_m
				WHERE LOWER(lookup_type) IN ('jenisidentitas', 'namadepan', 'jeniskelamin', 'golongandarah', 'rhesus', 'statusperkawinan', 'warganegara', 'agama')
				AND lookup_aktif = TRUE
				ORDER BY lookup_type, lookup_urutan";
		$loadDatas = Yii::app()->db->createCommand($sql)->queryAll();
		if(count($loadDatas) > 0){
			foreach($loadDatas AS $i => $val){
				$data[$val["lookup_type"]][] = $val;
			}
		}
		$sql = "SELECT pekerjaan_id, pekerjaan_nama
				FROM pekerjaan_m
				WHERE pekerjaan_aktif = TRUE
				ORDER BY pekerjaan_nama";
		$loadDatas = Yii::app()->db->createCommand($sql)->queryAll();
		if(count($loadDatas) > 0){
			$data['pekerjaan'] = $loadDatas;
		}
		$sql = "SELECT lookup_id, lookup_name, lookup_value
				FROM lookup_m
				WHERE lookup_aktif = TRUE
				AND lookup_type = 'warganegara'
				ORDER BY lookup_value";
		$loadDatas = Yii::app()->db->createCommand($sql)->queryAll();
		if(count($loadDatas) > 0){
			$data['warganegara'] = $loadDatas;
		}
		$sql = "SELECT pendidikan_id, pendidikan_nama
				FROM pendidikan_m
				WHERE pendidikan_aktif = TRUE
				ORDER BY pendidikan_urutan";
		$loadDatas = Yii::app()->db->createCommand($sql)->queryAll();
		if(count($loadDatas) > 0){
			$data['pendidikan'] = $loadDatas;
		}
		//$data['propinsi'] = $this->getPropinsis();
		//$data['kabupaten'] = (isset($_GET['propinsi_id']) ? $this->getKabupatens($_GET['propinsi_id']) : array());
		//$data['kecamatan'] = (isset($_GET['kabupaten_id']) ? $this->getKecamatans($_GET['kabupaten_id']) : array());
		//$data['kelurahan'] = (isset($_GET['kecamatan_id']) ? $this->getKelurahans($_GET['kecamatan_id']) : array());
		
		$sql = "SELECT ruangan_id, ruangan_nama 
				FROM ruangan_m
				WHERE ruangan_aktif = TRUE
				ORDER BY ruangan_nama";
		$loadDatas = Yii::app()->db->createCommand($sql)->queryAll();
		if(count($loadDatas) > 0){
			$data['ruangan'] = $loadDatas;
		}
		
		//$data['jeniskasuspenyakit'] = $this->getJeniskasuspenyakits($ruangan_id);
		
		//$data['kelaspelayanan'] = $this->getKelaspelayanans($ruangan_id);
		
		//$data['kelastanggunganasuransi'] = $this->getKelaspelayanans();
		
		if(!empty($carabayar_id)){
			$data['penjamin'] = $this->getPenjamins($carabayar_id);
		}
		
		$sql = "SELECT carabayar_id, carabayar_nama 
				FROM carabayar_m
				WHERE carabayar_aktif = TRUE
				ORDER BY carabayar_nourut";
		$loadDatas = Yii::app()->db->createCommand($sql)->queryAll();
		if(count($loadDatas) > 0){
			$data['carabayar'] = $loadDatas;
		}
		
		$encode = CJSON::encode($data);
		echo "jsonCallback(".$encode.")";
		Yii::app()->end();
	}
	
	/**
    * action untuk mendapatkan list kamar
    * @param q
    * @return array of kamar
    */
    public function actionGetRoom() {
        header("content-type:application/json");
        $format = new MyFormatter();
        $data = array();
        $data['is_found'] = 0;
        $data['pesan'] = "Data tidak ditemukan!";
        $data['data'] = '';
        if (isset($_GET['q'])) {				
            $q = strtolower($_GET['q']);		
			$sql = "SELECT * FROM ruanganrawatjalan_v
                WHERE ruangan_aktif= TRUE AND (LOWER(ruangan_nama) like '%".$q."%'
                OR LOWER(ruangan_namalainnya) like '%".$q."%'
                OR LOWER(ruangan_singkatan) like '%".$q."%')
                ORDER BY ruangan_nama";
            $loadData = Yii::app()->db->createCommand($sql)->queryAll();
            $data['data'] = $loadData;
            $n = sizeof($loadData);
            if ($n>0) {
                $data['is_found'] = 1;
                $data['pesan'] = "Data ditemukan!";    
            }
        }
        $encode = CJSON::encode($data);
        echo "jsonCallback(".$encode.")";
    }
	/**
    * action untuk mendapatkan list kamar
    * @param q
    * @return array of kamar
    */
    public function actionGetRoomRI() {
        header("content-type:application/json");
        $format = new MyFormatter();
        $data = array();
        $data['is_found'] = 0;
        $data['pesan'] = "Data tidak ditemukan!";
        $data['data'] = '';
        if (isset($_GET['q'])) {				
            $q = strtolower($_GET['q']);		
			$sql = "SELECT * FROM ruangan_m
                WHERE ruangan_aktif= TRUE AND (LOWER(ruangan_nama) like '%".$q."%'
                OR LOWER(ruangan_namalainnya) like '%".$q."%'
                OR LOWER(ruangan_singkatan) like '%".$q."%')
				AND instalasi_id=".Params::INSTALASI_ID_RI." 
                ORDER BY ruangan_nama";
            $loadData = Yii::app()->db->createCommand($sql)->queryAll();
            $data['data'] = $loadData;
            $n = sizeof($loadData);
            if ($n>0) {
                $data['is_found'] = 1;
                $data['pesan'] = "Data ditemukan!";    
            }
        }
        $encode = CJSON::encode($data);
        echo "jsonCallback(".$encode.")";
    }
	
	/**
    * action untuk mendapatkan list ruangan rawat jalan berdasarkan id pegawai
    * @param instalasi_id
    * @return array of kamar
    */
    public function actionGetRoomDokter() {
        header("content-type:application/json");
        $data = array();
        $data['is_found'] = 0;
        $data['pesan'] = "Data tidak ditemukan!";
        if (isset($_GET['pegawai_id'])) {
			$q = strtolower($_GET['q']);
			$sql = "SELECT ruangan_m.ruangan_id, ruangan_m.ruangan_nama, instalasi_m.instalasi_id, instalasi_m.instalasi_nama 
					FROM ruangan_m JOIN ruanganpegawai_m ON ruangan_m.ruangan_id=ruanganpegawai_m.ruangan_id 
					JOIN instalasi_m ON ruangan_m.instalasi_id = instalasi_m.instalasi_id 
					WHERE ruanganpegawai_m.pegawai_id = ".$_GET['pegawai_id']." AND (LOWER(ruangan_m.ruangan_nama) LIKE '%".$q."%' OR LOWER(instalasi_m.instalasi_nama) LIKE '%".$q."%') ORDER BY instalasi_m.instalasi_id";
            $loadData = Yii::app()->db->createCommand($sql)->queryAll();
			if (sizeof($loadData)>0) {
				$data['data'] = $loadData;
				$data['is_found'] = 1;
				$data['pesan'] = "Data ditemukan!";
			}
        }
        $encode = CJSON::encode($data);
        echo "jsonCallback(".$encode.")";
    }
	
	/**
    * action untuk mendapatkan list jenis kasus penyakit
    * @param q
    * @return array of jenis kasus penyakit
    */
    public function actionGetKasusPenyakit() {
        header("content-type:application/json");
        $format = new MyFormatter();
        $data = array();
        $data['is_found'] = 0;
        $data['pesan'] = "Data tidak ditemukan!";
        $data['data'] = '';
        if (isset($_GET['q'])&&isset($_GET['ruangan_id'])) {				
            $q = strtolower($_GET['q']);		
			$ruangan_id = $_GET['ruangan_id'];
			$sql = "SELECT * FROM jeniskasuspenyakit_m JOIN kasuspenyakitruangan_m ON kasuspenyakitruangan_m.jeniskasuspenyakit_id= jeniskasuspenyakit_m.jeniskasuspenyakit_id
                WHERE kasuspenyakitruangan_m.ruangan_id = $ruangan_id
				AND jeniskasuspenyakit_aktif= TRUE AND (LOWER(jeniskasuspenyakit_nama) like '%".$q."%'
                OR LOWER(jeniskasuspenyakit_namalainnya) like '%".$q."%')
                ORDER BY jeniskasuspenyakit_nama LIMIT 8 OFFSET 0";
            $loadData = Yii::app()->db->createCommand($sql)->queryAll();
            $data['data'] = $loadData;
            $n = sizeof($loadData);
            if ($n>0) {
                $data['is_found'] = 1;
                $data['pesan'] = "Data ditemukan!";    
            }
        }
        $encode = CJSON::encode($data);
        echo "jsonCallback(".$encode.")";
    }
	
	/**
    * action untuk mendapatkan list kelas pelayanan
    * @param q
    * @return array of kelas pelayanaan
    */
    public function actionGetKelasPelayanan() {
        header("content-type:application/json");
        $format = new MyFormatter();
        $data = array();
        $data['is_found'] = 0;
        $data['pesan'] = "Data tidak ditemukan!";
        $data['data'] = '';
        if (isset($_GET['q'])) {				
            $q = strtolower($_GET['q']);		
			$sql = "SELECT * FROM kelaspelayanan_m
                WHERE kelaspelayanan_aktif= TRUE AND (LOWER(kelaspelayanan_nama) like '%".$q."%'
                OR LOWER(kelaspelayanan_namalainnya) like '%".$q."%')
                ORDER BY kelaspelayanan_nama LIMIT 8 OFFSET 0";
            $loadData = Yii::app()->db->createCommand($sql)->queryAll();
            $data['data'] = $loadData;
            $n = sizeof($loadData);
            if ($n>0) {
                $data['is_found'] = 1;
                $data['pesan'] = "Data ditemukan!";    
            }
        }
        $encode = CJSON::encode($data);
        echo "jsonCallback(".$encode.")";
    }
	
	/**
    * action untuk mendapatkan list grup penjamin
    * @param q
	* @param 
    * @return array of guarantor group
    */
    public function actionGetCaraBayar() {
        header("content-type:application/json");
        $format = new MyFormatter();
        $data = array();
        $data['is_found'] = 0;
        $data['pesan'] = "Data tidak ditemukan!";
        $data['data'] = '';
        if (isset($_GET['q'])) {            
            $q = strtolower($_GET['q']);
			$sql = "SELECT * from carabayar_m WHERE (LOWER(carabayar_nama) LIKE '%$q%' "
					. "OR LOWER(carabayar_namalainnya) LIKE '%$q%' OR LOWER(carabayar_loket) LIKE '%$q%' "
					. "OR LOWER(carabayar_singkatan) ='$q') AND carabayar_aktif= TRUE "
					. "ORDER BY carabayar_nama LIMIT 8 OFFSET 0";
            $loadData = Yii::app()->db->createCommand($sql)->queryAll();
            $data['data'] = $loadData;
            $n = sizeof($loadData);
            if ($n>0) {
                $data['is_found'] = 1;
                $data['pesan'] = "Data ditemukan!";    
            }
        }
        $encode = CJSON::encode($data);
        echo "jsonCallback(".$encode.")";
    }
	
	/**
    * action untuk mendapatkan data anamnesa
    * @param pendaftaran_id
    * @return array of anamnesa
    */
    public function actionGetAnamnesa() {
        header("content-type:application/json");
        $format = new MyFormatter();
        $data = array();
        $data['is_found'] = 0;
        $data['pesan'] = "Data tidak ditemukan!";
        $data['data'] = '';
        if (isset($_GET['pendaftaran_id'])) {            
            $pendaftaran_id = $_GET['pendaftaran_id'];
			$sql = "SELECT * FROM anamnesa_t a JOIN pegawai_m p ON a.pegawai_id=p.pegawai_id "
					. "WHERE pendaftaran_id=".$pendaftaran_id;
            $loadData = Yii::app()->db->createCommand($sql)->queryAll();
            $data['data'] = $loadData;
            $n = sizeof($loadData);
            if ($n>0) {
                $data['is_found'] = 1;
                $data['pesan'] = "Data ditemukan!";    
            }
        }
        $encode = CJSON::encode($data);
        echo "jsonCallback(".$encode.")";
    }
	
	/**
    * action untuk mendapatkan list penjamin
    * @param q
	* @param 
    * @return array of guarantor
    */
    public function actionGetPenjamin() {
        header("content-type:application/json");
        $format = new MyFormatter();
        $data = array();
        $data['is_found'] = 0;
        $data['pesan'] = "Data tidak ditemukan!";
        $data['data'] = '';
        if (isset($_GET['q'])) {            
            $q = strtolower($_GET['q']);
			$carabayar_id = strtolower($_GET['carabayar_id']);
			$sql = "SELECT * from penjaminpasien_m WHERE (LOWER(penjamin_nama) LIKE '%$q%' "
					. "OR LOWER(penjamin_namalainnya) LIKE '%$q%') "
					. "AND penjamin_aktif=TRUE AND carabayar_id=$carabayar_id"
					. "ORDER BY penjamin_nama LIMIT 8 OFFSET 0";
            $loadData = Yii::app()->db->createCommand($sql)->queryAll();
            $data['data'] = $loadData;
            $n = sizeof($loadData);
            if ($n>0) {
                $data['is_found'] = 1;
                $data['pesan'] = "Data ditemukan!";    
            }
        }
        $encode = CJSON::encode($data);
        echo "jsonCallback(".$encode.")";
    }
	
	/**
    * action untuk mendapatkan list penjamin
    * @param q
	* @param 
    * @return array of guarantor
    */
    public function actionGetDokterRI() {
        header("content-type:application/json");
        $format = new MyFormatter();
        $data = array();
        $data['is_found'] = 0;
        $data['pesan'] = "Data tidak ditemukan!";
        $data['data'] = '';
        if (isset($_GET['q'])) {            
            $q = strtolower($_GET['q']);
			$ruanganID = $_GET['ruangan_id'];
			$sql = "SELECT * from dokter_v WHERE (ruangan_id = $ruanganID AND LOWER(nama_pegawai) LIKE '%$q%' "
					. "AND LOWER(gelardepan) LIKE '%$q%') AND pegawai_aktif=TRUE";
            $loadData = Yii::app()->db->createCommand($sql)->queryAll();
            $data['data'] = $loadData;
            $n = sizeof($loadData);
            if ($n>0) {
                $data['is_found'] = 1;
                $data['pesan'] = "Data ditemukan!";    
            }
        }
        $encode = CJSON::encode($data);
        echo "jsonCallback(".$encode.")";
    }
	
	/**
    * action untuk mendapatkan list penjamin
    * @param q
	* @param 
    * @return array of guarantor
    */
    public function actionGetDokter() {
        header("content-type:application/json");
        $format = new MyFormatter();
        $data = array();
        $data['is_found'] = 0;
        $data['pesan'] = "Data tidak ditemukan!";
        $data['data'] = '';
        if (isset($_GET['q'])) {            
            $q = strtolower($_GET['q']);
			$ruanganID = $_GET['ruangan_id'];
			$sql = "SELECT * from dokter_v WHERE (ruangan_id = $ruanganID AND LOWER(nama_pegawai) LIKE '%$q%' "
					. "AND LOWER(gelardepan) LIKE '%$q%') AND pegawai_aktif=TRUE";
            $loadData = Yii::app()->db->createCommand($sql)->queryAll();
            $data['data'] = $loadData;
            $n = sizeof($loadData);
            if ($n>0) {
                $data['is_found'] = 1;
                $data['pesan'] = "Data ditemukan!";    
            }
        }
        $encode = CJSON::encode($data);
        echo "jsonCallback(".$encode.")";
    }
	
	/**
	 * transaksi pendaftaran rawat jalan (klinik)
	 * MA-282
	 * @param $_GET['pasien'] array
	 * @param $_GET['pendaftaran'] array
	 * @return json
	 */
	public function actionPendaftaranRJ(){
		header("content-type:application/json");
		$data = array();
		$data['sukses'] = 0;
		$data['pesan'] = 'Error 404 : Request tidak valid. Cek parameter';
		if(isset($_GET['Pasien']) && isset($_GET['Pendaftaran'])){
			$transaction = Yii::app()->db->beginTransaction();
			try{
				if (isset($_GET['Pasien']['pasien_id'])) {
					$oldPasienID = $_GET['Pasien']['pasien_id'];
				}else {
					$oldPasienID = "";
				}
				
				
				if ($oldPasienID==''||$oldPasienID==null) {
					$modPasien = new MOPasienM;
					$modPasien->attributes = $_GET['Pasien'];
					$statuspasien = Params::STATUSPASIEN_BARU;
					$modPasien->pasien_id = null; //agar auto sequence tidak error
				}else {
					$modPasien = MOPasienM::model()->findByPk($oldPasienID);
					$modPasien->update_time = date("Y-m-d H:i:s");
					$statuspasien = Params::STATUSPASIEN_LAMA;
				}
				$modPasien->tgl_rekam_medik = date("Y-m-d");
				$modPasien->statusrekammedis = 'AKTIF';
				$modPasien->loginpemakai_id = 1;
				$modPasien->create_loginpemakai_id = 1;
				$modPasien->update_time = date('Y-m-d H:i:s');
				$modPasien->create_time = date("Y-m-d H:i:s");
				$modPasien->kelompokumur_id = CustomFunction::getKelompokUmur($modPasien->tanggal_lahir);
				//print_r($modPasien);
				//exit;
				$modPasien->no_rekam_medik = MyGenerator::noRekamMedik();
				if ($modPasien->save()){
					$modPendaftaran = new MOPendaftaranT;
					$modPendaftaran->attributes = $_GET['Pendaftaran'];
					$modPendaftaran->pasien_id = $modPasien->pasien_id;
					$modPendaftaran->tgl_pendaftaran = (empty($modPendaftaran->tgl_pendaftaran) ? date("Y-m-d H:i:s") : $modPendaftaran->tgl_pendaftaran);
					$modPendaftaran->create_time = date("Y-m-d H:i:s");
					$modPendaftaran->kelompokumur_id = (!empty($modPasien->kelompokumur_id) ? $modPasien->kelompokumur_id : CustomFunction::getKelompokUmur($modPasien->tanggal_lahir));
					$modPendaftaran->statusmasuk = (!empty($modPendaftaran->rujukan_id) ? Params::STATUSMASUK_RUJUKAN : Params::STATUSMASUK_NONRUJUKAN);
					$modPendaftaran->statusperiksa = Params::STATUSPERIKSA_ANTRIAN;
					$modPendaftaran->statuspasien = $statuspasien;
					$modPendaftaran->golonganumur_id = CustomFunction::getGolonganUmur($modPasien->tanggal_lahir);
					$modPendaftaran->kunjungan = CustomFunction::getKunjungan($modPasien, $modPendaftaran->ruangan_id);
					$modPendaftaran->no_pendaftaran = MyGenerator::noPendaftaran(Params::INSTALASI_ID_RJ);
					$modPendaftaran->no_urutantri = MyGenerator::noAntrian($modPendaftaran->ruangan_id);
					$modPendaftaran->umur = CustomFunction::getUmur($modPasien->tanggal_lahir);
					//$modPendaftaran->loginpemakai_id = 1;
					$modPendaftaran->create_loginpemakai_id = 1;
					//$data['umur'] = CustomFunction::getUmur($_GET['tanggal_lahir']);
					if($modPendaftaran->save()){
						$transaction->commit();
						$data['sukses'] = 1;
						$data['pesan'] = 'Data pasien dan pendaftaran berhasil disimpan!';
					}else{
						$transaction->rollback();
						$data['sukses'] = 0;
						$data['pesan'] = 'Data pendaftaran gagal disimpan!<br>'.CHtml::errorSummary($modPendaftaran);
					}
				}else{
					$transaction->rollback();
					$data['sukses'] = 0;
					$data['pesan'] = 'Data pasien gagal disimpan! <br>'.CHtml::errorSummary($modPasien);
				}
			}catch (Exception $exc) {
				$transaction->rollback();
				$data['sukses'] = 0;
				$data['pesan'] = 'Data pasien dan pendaftaran gagal disimpan!'.MyExceptionMessage::getMessage($exc,true);
			}

		}
		$encode = CJSON::encode($data);
		echo "jsonCallback(".$encode.")";
		Yii::app()->end();
	}
	
	/**
	 * action untuk mendapatkan tanggal lahir pasien
	 * 
	 * @param tanggallahir pasien
	 * @return umur pasien 
	 */
	public function actionGetUmurPasien() {
		header("content-type:application/json");
        $format = new MyFormatter();
        $data = array();
		if (isset($_GET['tanggal_lahir'])){
			$tanggalLahir = $_GET['tanggal_lahir'];
			$data['umur'] = CustomFunction::hitungUmur($tanggalLahir);
		}
		$encode = CJSON::encode($data);
		echo "jsonCallback(".$encode.")";
		Yii::app()->end();
	}
	
	/**
	 * action untuk mendapatkan list pasien
	 * 
	 * @param q, status, sort date, sort name
	 * @return array list pasien
	 * 
	 */
	public function actionGetDaftarPasien() {
		header("content-type:application/json");
        $format = new MyFormatter();
        $data = array();
        $data['is_found'] = 0;
        $data['pesan'] = "Data tidak ditemukan!";
        $data['data'] = '';
        $statusPasien = '';
		$tglPendaftaran = '';
		if (isset($_GET['q'])&&isset($_GET['status'])&&isset($_GET['start_date'])&&isset($_GET['end_date'])&&isset($_GET['pegawai_id'])&&isset($_GET['ruangan_id'])) {            
            $q = strtolower($_GET['q']);
			$statusPeriksa = $_GET['status'];
			$startDate = $_GET['start_date'];			
			$endDate = $_GET['end_date'];			
			$pegawai_id = $_GET['pegawai_id'];
			$ruangan_id = $_GET['ruangan_id'];
			if ($statusPeriksa=="") 
				$statusStr='';
			else 
				$statusStr = "AND statusperiksa='".$statusPeriksa."'";
						
			if ($ruangan_id=="") 
				$ruangan_id='';
			else 
				$ruangan_id = "ruangan_id='".$ruangan_id."' AND";
			
			if ($startDate!='' && $endDate!='') {
				$strBetween = " AND tgl_pendaftaran::timestamp::date BETWEEN '".$startDate."' AND '".$endDate."'";
			}else {
				$strBetween = "AND tgl_pendaftaran::timestamp::date='".date('Y-m-d')."'";
			}
			
			if ($tglPendaftaran=='') {
				$tglPendaftaran = date('Y-m-d');
			}
			
			$sql = "SELECT * from infokunjunganrj_v 
					WHERE $ruangan_id instalasi_id=".Params::INSTALASI_ID_RJ." AND pegawai_id=".$pegawai_id." AND (LOWER(nama_pasien) LIKE '%$q%' OR LOWER(no_pendaftaran) LIKE '%$q%') ".$statusStr.$strBetween." 
					ORDER BY tgl_pendaftaran ASC LIMIT 8";
            $loadData = Yii::app()->db->createCommand($sql)->queryAll();
            $data['data'] = $loadData;
            $n = sizeof($loadData);
            if ($n>0) {
                $data['is_found'] = 1;
                $data['pesan'] = "Data ditemukan!";    
            }
        }
        $encode = CJSON::encode($data);
        echo "jsonCallback(".$encode.")";
	} 
	
	
	/**
    * action untuk mendapatkan list paramedis
    * @param q
	* @param ruangan_id	
    * @return array of paramedis
    */
    public function actionGetParamedis() {
        header("content-type:application/json");
        $format = new MyFormatter();
        $data = array();
        $data['is_found'] = 0;
        $data['pesan'] = "Data tidak ditemukan!";
        $data['data'] = '';
        if (isset($_GET['q'])) {            
            $q = strtolower($_GET['q']);
			$ruanganID = $_GET['ruangan_id'];
			$sql = "SELECT pegawai_m.pegawai_id, pegawai_m.gelardepan, pegawai_m.nama_pegawai, gelarbelakang_m.gelarbelakang_nama
				FROM pegawai_m
				JOIN ruanganpegawai_m ON ruanganpegawai_m.pegawai_id = pegawai_m.pegawai_id
				LEFT JOIN gelarbelakang_m ON pegawai_m.gelarbelakang_id = gelarbelakang_m.gelarbelakang_id
				WHERE pegawai_m.kelompokpegawai_id <> 1  
					AND ruanganpegawai_m.ruangan_id = ".$ruanganID;
            $loadData = Yii::app()->db->createCommand($sql)->queryAll();
            $data['data'] = $loadData;
            $n = sizeof($loadData);
            if ($n>0) {
                $data['is_found'] = 1;
                $data['pesan'] = "Data ditemukan!";    
            }
        }
        $encode = CJSON::encode($data);
        echo "jsonCallback(".$encode.")";
    }
	
	/**
    * action untuk mendapatkan list diagnosa
    * @param q
	* @param dialog_imunisasi, true or false	
    * @return array of paramedis
    */
    public function actionGetDiagnosa() {
        header("content-type:application/json");
        $format = new MyFormatter();
        $data = array();
        $data['is_found'] = 0;
        $data['pesan'] = "Data tidak ditemukan!";
        $data['data'] = '';
        if (isset($_GET['q'])) {            
            $q = strtolower($_GET['q']);
			$dialogImunisasi = $_GET['diagnosa_imunisasi'];
			$sql = "SELECT * FROM diagnosa_m
					WHERE diagnosa_aktif = TRUE AND diagnosa_imunisasi = ".$dialogImunisasi." 
					AND (LOWER(diagnosa_kode) like '%".$q."%' OR LOWER(diagnosa_nama) like '%".$q."%')
					LIMIT 8";
            $loadData = Yii::app()->db->createCommand($sql)->queryAll();
            $data['data'] = $loadData;
            $n = sizeof($loadData);
            if ($n>0) {
                $data['is_found'] = 1;
                $data['pesan'] = "Data ditemukan!";    
            }
        }
        $encode = CJSON::encode($data);
        echo "jsonCallback(".$encode.")";
    }
	
	public function actionGetRuanganDokter() {
		header("content-type:application/json");
        $format = new MyFormatter();
        $data = array();
        $data['is_found'] = 0;
        $data['pesan'] = "Data tidak ditemukan!";
        $data['data'] = '';
        if (isset($_GET['pegawai_id'])) {            
            $pegawai_id = $_GET['pegawai_id'];
			//$dialogImunisasi = $_GET['diagnosa_imunisasi'];
			$sql = "SELECT ruangan_m.ruangan_id, ruangan_m.ruangan_nama  FROM ruangan_m 
					JOIN ruanganpegawai_m ON ruangan_m.ruangan_id=ruanganpegawai_m.ruangan_id
					WHERE ruanganpegawai_m.pegawai_id = $pegawai_id
					AND ruangan_m.instalasi_id=".Params::INSTALASI_ID_RJ." 
					LIMIT 8";
            $loadData = Yii::app()->db->createCommand($sql)->queryAll();
            $data['data'] = $loadData;
            $n = sizeof($loadData);
            if ($n>0) {
                $data['is_found'] = 1;
                $data['pesan'] = "Data ditemukan!";    
            }
        }
        $encode = CJSON::encode($data);
        echo "jsonCallback(".$encode.")";
	}
	
	/**
	 * action untuk memasukkan data hasil pemeriksaan anamnesa
	 * @param array serialize
	 * @return array 1/0 sukses message
	 */
	public function actionSubmitAnamnesa(){
		header("content-type:application/json");
		$data = array();
		$data['sukses'] = 0;
		$data['pesan'] = 'Error 404 : Request tidak valid. Cek parameter';
		if(isset($_GET['anamnesa'])){
			$transaction = Yii::app()->db->beginTransaction();
			try{
				if($_GET['anamesa_id']!=''){
					$model = MOAnamnesaT::model()->findByPk($_GET['anamesa_id']);
					$model->attributes = $_GET['anamnesa'];
					$model->update_time = date("Y-m-d H:i:s");				
				}else{
					$model = new MOAnamnesaT;
					$model->attributes = $_GET['anamnesa'];
					$model->anamesa_id = null; //agar auto sequence tidak error
				}
				
				$model->create_time = date("Y-m-d H:i:s");
				if($model->save()){
					MOPendaftaranT::model()->updateByPk($model->pendaftaran_id,array('statusperiksa'=>Params::STATUSPERIKSA_SEDANG_PERIKSA,'update_time'=>date("Y-m-d H:i:s"),'update_loginpemakai_id'=>$model->create_loginpemakai_id));
					$transaction->commit();
					$data['sukses'] = 1;
					$data['pesan'] = 'Data anamnesa berhasil diubah dan simpan!';
				}else{
					$transaction->rollback();
					$data['sukses'] = 0;
					$data['pesan'] = 'Data anamnesa gagal disimpan! <br>'.CHtml::errorSummary($model);
				}
			}catch (Exception $exc) {
				$transaction->rollback();
				$data['sukses'] = 0;
				$data['pesan'] = 'Data anamnesa gagal disimpan!'.MyExceptionMessage::getMessage($exc,true);
			}

		}
		$encode = CJSON::encode($data);
		echo "jsonCallback(".$encode.")";
		Yii::app()->end();
	}
	
	/**
	 * Action untuk mendapatkan master lookup
	 * @param lookup_type, tipe jenis master
	 * @return array data lookup
	 */	
	public function actionGetLookup() {
        header("content-type:application/json");
        $format = new MyFormatter();
        $data = array();
        $data['is_found'] = 0;
        $data['pesan'] = "Data tidak ditemukan!";
        $data['data'] = '';
        if (isset($_GET['lookup_type'])) {            
			$lookupType = $_GET['lookup_type'];
			$sql = "SELECT * FROM lookup_m WHERE lookup_type='$lookupType'";
            $loadData = Yii::app()->db->createCommand($sql)->queryAll();
            $data['data'] = $loadData;
            $n = sizeof($loadData);
            if ($n>0) {
                $data['is_found'] = 1;
                $data['pesan'] = "Data ditemukan!";    
            }
        }
        $encode = CJSON::encode($data);
        echo "jsonCallback(".$encode.")";
    }
	
	
	/**
	 * action untuk mendapatkan Hasil Tekanan Darah
	 * @param systolic
	 * @param diastolic
	 * 
	 * @return nilai Meanarteripressure
	 */
	public function actionGetHasilTekananDarah(){
		header("content-type:application/json");
		$data = array();
		$data['is_found'] = 0;
        $data['pesan'] = "Data tidak ditemukan!";
        $data['data'] = '';
		if(isset($_GET['systolic']) && isset($_GET['diastolic'])){
			$systolic = $_GET['systolic'];
			$diastolic = $_GET['diastolic'];
			$meanarteripressure = ($systolic+(2*$diastolic))/3;
			$sql = "SELECT sysdia_id, sysdia_nama
				FROM sysdia_m
				WHERE ".$systolic." >= systolic_min
					AND ".$systolic." < (systolic_max + 1) 
					AND ".$diastolic." >= diastolic_min 
					AND ".$diastolic." < (diastolic_max + 1) 
					AND sysdia_aktif = TRUE";
			$loadData = Yii::app()->db->createCommand($sql)->queryRow();			
			$data['data'] = $loadData;
            $n = sizeof($loadData);
            if ($n>0) {
                $data['is_found'] = 1;
				$data['data']['meanarteripressure'] = $meanarteripressure;
                $data['pesan'] = "Data ditemukan!";    
            }

		}
		$encode = CJSON::encode($data);
		echo "jsonCallback(".$encode.")";
		Yii::app()->end();
	}
	
	/**
	 * action untuk mendapatkan Index Massa Tubuh dan Berat Badan Ideal
	 * @param tinggibadan (cm)
	 * @param beratbadan (kg)
	 * @param pasien_id
	 * 
	 * @return array dari hasil body mass index dan ideal weight
	 */
	public function actionGetBMI(){
		header("content-type:application/json");
		$data = array();
		$data['is_found'] = 0;
        $data['pesan'] = "Data tidak ditemukan!";
        $data['data'] = '';
		if(isset($_GET['tinggibadan_cm']) && isset($_GET['beratbadan_kg']) && isset($_GET['pasien_id'])){

			$tinggibadan_cm = (float)$_GET['tinggibadan_cm'];
			$beratbadan_kg = (float)$_GET['beratbadan_kg'];
			$bmi = ($beratbadan_kg/(($tinggibadan_cm*$tinggibadan_cm)/10000));

			$sql = "SELECT nama_pasien, jeniskelamin
				FROM pasien_m
				WHERE pasien_id = ".$_GET['pasien_id'];
			$loadData = Yii::app()->db->createCommand($sql)->queryRow();
			if(strtolower(trim($loadData['jeniskelamin'])) == strtolower(trim(Params::JENIS_KELAMIN_PEREMPUAN))){
				$bb_ideal = ($tinggibadan_cm - 100) - ((15/100)*($tinggibadan_cm-100));
			}else{
				$bb_ideal = ($tinggibadan_cm - 100) - ((10/100)*($tinggibadan_cm-100));
			}
			if ($bmi>0) {
				$sql = "SELECT bodymassindex_id, bmi_sign, bmi_defenisi, bmi_pesan
					FROM bodymassindex_m
					WHERE ".$bmi." >= bmi_minimum
					AND ".$bmi." < (bmi_maksimum + 1) 
					AND bodymassindex_aktif = TRUE";
				$loadData = Yii::app()->db->createCommand($sql)->queryRow();
			}
			$data['data'] = $loadData;
			$n = sizeof($loadData);
			if ($n>0) {
				$data['bmi'] = $bmi;
				$data['bb_ideal'] = $bb_ideal;
				$data['is_found'] = 1;
				$data['pesan'] = "Data ditemukan!";    
			}
		}
		$encode = CJSON::encode($data);
		echo "jsonCallback(".$encode.")";
		Yii::app()->end();
	}
	
	/**
	 * action untuk menyimpan data pemeriksaan fisik
	 * @param serialize form 
	 * @return 1/0 sukses, pesan 
	 */	
	public function actionSubmitPemeriksaanFisik(){
		header("content-type:application/json");
		$data = array();
		$data['sukses'] = 0;
		$data['pesan'] = 'Error 404 : Request tidak valid. Cek parameter';
		if(isset($_GET['pemeriksaanfisik'])){
			$transaction = Yii::app()->db->beginTransaction();
			try{
				if($_GET['pemeriksaanfisik_id']!=''){
					$model = MOPemeriksaanfisikT::model()->findByPk($_GET['pemeriksaanfisik_id']);
					$model->attributes = $_GET['pemeriksaanfisik'];
					$model->update_time = date("Y-m-d H:i:s");
							
				}else{
					$model = new MOPemeriksaanfisikT;
					$model->attributes = $_GET['pemeriksaanfisik'];
					$model->create_time = date("Y-m-d H:i:s");
					$model->pemeriksaanfisik_id = null; //agar auto sequence tidak error
				}							
				if($model->save()){
					MOPendaftaranT::model()->updateByPk($model->pendaftaran_id,array('statusperiksa'=>Params::STATUSPERIKSA_SEDANG_PERIKSA,'update_time'=>date("Y-m-d H:i:s"),'update_loginpemakai_id'=>$model->create_loginpemakai_id));
					$transaction->commit();
					$data['sukses'] = 1;
					$data['pesan'] = 'Data pemeriksaan fisik berhasil disimpan!';
				}else{
					$transaction->rollback();
					$data['sukses'] = 0;
					$data['pesan'] = 'Data pemeriksaan fisik gagal disimpan!<br>'.CHtml::errorSummary($model);
				}
			}catch (Exception $exc) {
				$transaction->rollback();
				$data['sukses'] = 0;
				$data['pesan'] = 'Data pemeriksaan fisik gagal disimpan!'.MyExceptionMessage::getMessage($exc,true);
			}
		}
		$encode = CJSON::encode($data);
		echo "jsonCallback(".$encode.")";
		Yii::app()->end();
	}
	
	/**
    * action untuk mendapatkan data pemeriksaan fisik
    * @param pendaftaran_id
    * @return array of pemeriksaan fisik
    */
    public function actionGetPemeriksaanFisik() {
        header("content-type:application/json");
        $format = new MyFormatter();
        $data = array();
        $data['is_found'] = 0;
        $data['pesan'] = "Data tidak ditemukan!";
        $data['data'] = '';
        if (isset($_GET['pendaftaran_id'])) {            
            $pendaftaran_id = $_GET['pendaftaran_id'];
			$sql = "SELECT * FROM pemeriksaanfisik_t f JOIN pegawai_m p ON f.pegawai_id=p.pegawai_id "
					. "WHERE pendaftaran_id=".$pendaftaran_id;
            $loadData = Yii::app()->db->createCommand($sql)->queryAll();
            $data['data'] = $loadData;	
            $n = sizeof($loadData);
            if ($n>0) {
                $data['is_found'] = 1;
                $data['pesan'] = "Data ditemukan!";    
            }
        }
        $encode = CJSON::encode($data);
        echo "jsonCallback(".$encode.")";
    }
	
	/**
	 * action untuk pemilihan pemeriksaan lab klinik
	 * @params ruangan_id, penjamin_id, kelaspelayanan_id, q
	 * @return array pf pemeriksaan lab klinik
	 * 
	 */
	public function actionGetPemeriksaanLabKlinik(){
		header("content-type:application/json");
		$data = array();
		if(isset($_GET['ruangan_id']) && isset($_GET['penjamin_id']) && isset($_GET['kelaspelayanan_id'])){
			$req = (isset($_GET['q']) ? str_replace('"','',str_replace("'","",strtolower(trim($_GET['q'])))) : "");
			$sql = "SELECT daftartindakan_m.daftartindakan_id, 
						jenispemeriksaanlab_m.jenispemeriksaanlab_id, 
						jenispemeriksaanlab_m.jenispemeriksaanlab_kode, 
						jenispemeriksaanlab_m.jenispemeriksaanlab_nama,
						pemeriksaanlab_m.pemeriksaanlab_id, 
						pemeriksaanlab_m.pemeriksaanlab_kode, 
						pemeriksaanlab_m.pemeriksaanlab_nama,
						tariftindakan_m.harga_tariftindakan, 
						tariftindakan_m.persendiskon_tind, 
						tariftindakan_m.hargadiskon_tind, 
						tariftindakan_m.persencyto_tind
					FROM pemeriksaanlab_m
					JOIN jenispemeriksaanlab_m ON pemeriksaanlab_m.jenispemeriksaanlab_id = jenispemeriksaanlab_m.jenispemeriksaanlab_id
					JOIN daftartindakan_m ON daftartindakan_m.daftartindakan_id = pemeriksaanlab_m.daftartindakan_id
					JOIN tindakanruangan_m ON daftartindakan_m.daftartindakan_id = tindakanruangan_m.daftartindakan_id
					JOIN tariftindakan_m ON tariftindakan_m.daftartindakan_id = daftartindakan_m.daftartindakan_id
					JOIN jenistarifpenjamin_m ON jenistarifpenjamin_m.jenistarif_id = tariftindakan_m.jenistarif_id
					WHERE tariftindakan_m.komponentarif_id = ".Params::KOMPONENTARIF_ID_TOTAL."
					AND jenispemeriksaanlab_m.jenispemeriksaanlab_aktif = true 
					AND tariftindakan_m.kelaspelayanan_id = ".$_GET['kelaspelayanan_id']."
					 AND tariftindakan_m.jenistarif_id = ".Params::JENISTARIF_ID_PELAYANAN."
					 AND pemeriksaanlab_m.pemeriksaanlab_aktif = true
					AND jenispemeriksaanlab_m.jenispemeriksaanlab_id<>	2
					AND(
						LOWER(jenispemeriksaanlab_m.jenispemeriksaanlab_kode) like '%$req%'
						OR LOWER(jenispemeriksaanlab_m.jenispemeriksaanlab_nama) like '%$req%'
						OR LOWER(pemeriksaanlab_m.pemeriksaanlab_kode) like '%$req%'
						OR LOWER(pemeriksaanlab_m.pemeriksaanlab_nama) like '%$req%'
					)
					ORDER BY jenispemeriksaanlab_m.jenispemeriksaanlab_urutan ASC, pemeriksaanlab_m.pemeriksaanlab_urutan ASC";
			$loadData = Yii::app()->db->createCommand($sql)->queryAll();
			$data['data'] = $loadData;	
            $n = sizeof($loadData);
            if ($n>0) {
                $data['is_found'] = 1;
                $data['pesan'] = "Data ditemukan!";    
            }
		}
		$encode = CJSON::encode($data);
		echo "jsonCallback(".$encode.")";
		Yii::app()->end();
	}
	
	/**
	 * action untuk pemilihan pemeriksaan lab klinik
	 * @params ruangan_id, penjamin_id, kelaspelayanan_id, q
	 * @return array pf pemeriksaan lab klinik
	 * 
	 */
	public function actionGetPemeriksaanLabAnatomi(){
		header("content-type:application/json");
		$data = array();
		if(isset($_GET['ruangan_id']) && isset($_GET['penjamin_id']) && isset($_GET['kelaspelayanan_id'])){
			$req = (isset($_GET['q']) ? str_replace('"','',str_replace("'","",strtolower(trim($_GET['q'])))) : "");
			$sql = "SELECT daftartindakan_m.daftartindakan_id, 
						jenispemeriksaanlab_m.jenispemeriksaanlab_id, 
						jenispemeriksaanlab_m.jenispemeriksaanlab_kode, 
						jenispemeriksaanlab_m.jenispemeriksaanlab_nama,
						pemeriksaanlab_m.pemeriksaanlab_id, 
						pemeriksaanlab_m.pemeriksaanlab_kode, 
						pemeriksaanlab_m.pemeriksaanlab_nama,
						tariftindakan_m.harga_tariftindakan, 
						tariftindakan_m.persendiskon_tind, 
						tariftindakan_m.hargadiskon_tind, 
						tariftindakan_m.persencyto_tind
					FROM pemeriksaanlab_m
					JOIN jenispemeriksaanlab_m ON pemeriksaanlab_m.jenispemeriksaanlab_id = jenispemeriksaanlab_m.jenispemeriksaanlab_id
					JOIN daftartindakan_m ON daftartindakan_m.daftartindakan_id = pemeriksaanlab_m.daftartindakan_id
					JOIN tindakanruangan_m ON daftartindakan_m.daftartindakan_id = tindakanruangan_m.daftartindakan_id
					JOIN tariftindakan_m ON tariftindakan_m.daftartindakan_id = daftartindakan_m.daftartindakan_id
					JOIN jenistarifpenjamin_m ON jenistarifpenjamin_m.jenistarif_id = tariftindakan_m.jenistarif_id
					WHERE tariftindakan_m.komponentarif_id = ".Params::KOMPONENTARIF_ID_TOTAL."
					AND jenispemeriksaanlab_m.jenispemeriksaanlab_aktif = true 
					AND tariftindakan_m.kelaspelayanan_id = ".$_GET['kelaspelayanan_id'].
					" AND tariftindakan_m.jenistarif_id = ".Params::JENISTARIF_ID_PELAYANAN.
					" AND pemeriksaanlab_m.pemeriksaanlab_aktif = true
					AND jenispemeriksaanlab_m.jenispemeriksaanlab_id=2
					AND(
						LOWER(jenispemeriksaanlab_m.jenispemeriksaanlab_kode) like '%$req%'
						OR LOWER(jenispemeriksaanlab_m.jenispemeriksaanlab_nama) like '%$req%'
						OR LOWER(pemeriksaanlab_m.pemeriksaanlab_kode) like '%$req%'
						OR LOWER(pemeriksaanlab_m.pemeriksaanlab_nama) like '%$req%'
					)
					ORDER BY jenispemeriksaanlab_m.jenispemeriksaanlab_urutan ASC, pemeriksaanlab_m.pemeriksaanlab_urutan ASC";
			$loadData = Yii::app()->db->createCommand($sql)->queryAll();
			$data['data'] = $loadData;	
            $n = sizeof($loadData);
            if ($n>0) {
                $data['is_found'] = 1;
                $data['pesan'] = "Data ditemukan!";    
            }
		}
		$encode = CJSON::encode($data);
		echo "jsonCallback(".$encode.")";
		Yii::app()->end();
	}
	
	/**
	 * transaksi rujuk ke laboratorium
	 * @param $_GET['pasienkirimkeunitlain'] array
	 * @param $_GET['permintaankepenunjang'] array(array()) //detail pemeriksaan
	 * @return json
	 */
	public function actionSubmitRujukKeLab(){
		header("content-type:application/json");
		$data = array();
		$data['sukses'] = 0;
		$data['pesan'] = 'Error 404 : Request tidak valid. Cek parameter';
		$errorDetail = "";
		if(isset($_GET['pasienkirimkeunitlain']) && isset($_GET['permintaankepenunjang'])){
			$transaction = Yii::app()->db->beginTransaction();
			try{
				$format = new MyFormatter;
				$model = new MOPasienkirimkeunitlainT;
				$model->attributes = $_GET['pasienkirimkeunitlain'];
				$model->tgl_kirimpasien = $format->formatDateTimeForDb($_GET['pasienkirimkeunitlain']['tgl_kirimpasien']);
				$model->create_time = date("Y-m-d H:i:s");
				$model->update_time = $model->create_time;
				$model->update_loginpemakai_id = $model->create_loginpemakai_id;
				$model->nourut = MyGenerator::noUrutPasienKirimKeUnitLain($model->ruangan_id);
				
				if($model->save()) {
					if(count($_GET['permintaankepenunjang']) > 0){
						foreach($_GET['permintaankepenunjang'] AS $i => $detail){
							$modPermintaan = new MOPermintaankepenunjangT();							
							$modPermintaan->attributes = $detail;
							$modPermintaan->pasienkirimkeunitlain_id = $model->pasienkirimkeunitlain_id;

							$modPermintaan->tglpermintaankepenunjang = $model->tgl_kirimpasien;
							$prefix = (!empty($model->ruangan->ruangan_singkatan) ? $model->ruangan->ruangan_singkatan : "LB");
							$modPermintaan->noperminatanpenujang = MyGenerator::noPermintaanPenunjang($prefix);

							if($modPermintaan->save()){
							}else{
								$errorDetail .= CHtml::errorSummary($modPermintaan);
							}
						}
					}
					if(empty($errorDetail)){
						$transaction->commit();
						$data['sukses'] = 1;
						$data['pesan'] = 'Data rujuk pasien ke laboratorium berhasil disimpan!';
					}else{
						$transaction->rollback();
						$data['sukses'] = 0;
						$data['pesan'] = 'Data detail pemeriksaan gagal disimpan!<br>'.$errorDetail;
					}

				}else{
					$transaction->rollback();
					$data['sukses'] = 0;
					$data['pesan'] = 'Data rujuk pasien ke laboratorium gagal disimpan!<br>'.CHtml::errorSummary($model)."<br><pre>".$errorDetail."</pre>";
				}
			}catch (Exception $exc) {
				$transaction->rollback();
				$data['sukses'] = 0;
				$data['pesan'] = 'Data rujuk pasien ke laboratorium gagal disimpan!'.MyExceptionMessage::getMessage($exc,true);
			}

		}
		$encode = CJSON::encode($data);
		echo "jsonCallback(".$encode.")";
		Yii::app()->end();
	}
	
	/**
	 * action untuk mendapatkan item rujukan yang telah diinput sebelumnya
	 * @param pendaftaran_id
	 * @return item rujukan dan informasi data yang dikirim ke penunjang
	 */	
	public function actionGetRujukanKeLab() {
		header("content-type:application/json");
		$data['is_found'] = 0;
        $data['pesan'] = "Data tidak ditemukan!";
        $data['data'] = '';
		$data['header'] = '';
		if (isset($_GET['pendaftaran_id'])) {
			$pendaftaran_id = $_GET['pendaftaran_id'];
			$sql = "SELECT * FROM pasienkirimkeunitlain_t pkul JOIN kelaspelayanan_m kp ON pkul.kelaspelayanan_id=kp.kelaspelayanan_id WHERE pkul.pendaftaran_id=".$pendaftaran_id;
			$loadData = Yii::app()->db->createCommand($sql)->queryAll();			
			if (sizeof($loadData)>0) {
				$i=0;
				foreach ($loadData as $datum) {
					$data['data'][$i]['tgl_kirimpasien'] = $datum['tgl_kirimpasien'];
					$data['data'][$i]['pasienkirimkeunitlain_id'] = $datum['pasienkirimkeunitlain_id'];
					$pasienKirimKeUnitlainID = $datum['pasienkirimkeunitlain_id'];
					$sql = "SELECT pkp.permintaankepenunjang_id, pkp.daftartindakan_id, "
							. "pkp.pemeriksaanlab_id, pl.pemeriksaanlab_nama, pkp.qtypermintaan, jpl.jenispemeriksaanlab_nama "
							. "FROM permintaankepenunjang_t pkp JOIN pemeriksaanlab_m pl ON pkp.pemeriksaanlab_id=pl.pemeriksaanlab_id "
							. "JOIN jenispemeriksaanlab_m jpl ON pl.jenispemeriksaanlab_id=jpl.jenispemeriksaanlab_id "
							. "WHERE pkp.pasienkirimkeunitlain_id=".$pasienKirimKeUnitlainID;
					$loadData2 = Yii::app()->db->createCommand($sql)->queryAll();
					if (sizeof($loadData2)>0) {
						$data['data'][$i]['detail']=$loadData2;
						$data['is_found'] = 1;
						$data['pesan'] = "Data ditemukan!"; 
					}
					$i++;
				}
				
			}
		}
		
		$encode = CJSON::encode($data);
		echo "jsonCallback(".$encode.")";
		Yii::app()->end();
	}
	
	/**
	 * action untuk mendapatkan item rujukan yang telah diinput sebelumnya
	 * @param pendaftaran_id
	 * @return item rujukan dan informasi data yang dikirim ke penunjang
	 */	
	public function actionGetRujukanKeRadiologi() {
		header("content-type:application/json");
		$data['is_found'] = 0;
        $data['pesan'] = "Data tidak ditemukan!";
        $data['data'] = '';
		$data['header'] = '';
		if (isset($_GET['pendaftaran_id'])) {
			$pendaftaran_id = $_GET['pendaftaran_id'];
			$sql = "SELECT * FROM pasienkirimkeunitlain_t pkul JOIN kelaspelayanan_m kp ON pkul.kelaspelayanan_id=kp.kelaspelayanan_id WHERE pkul.pendaftaran_id=".$pendaftaran_id;
			$loadData = Yii::app()->db->createCommand($sql)->queryAll();			
			if (sizeof($loadData)>0) {
				$i=0;
				foreach ($loadData as $datum) {
					$data['data'][$i]['tgl_kirimpasien'] = $datum['tgl_kirimpasien'];
					$data['data'][$i]['pasienkirimkeunitlain_id'] = $datum['pasienkirimkeunitlain_id'];
					$pasienKirimKeUnitlainID = $datum['pasienkirimkeunitlain_id'];
					$sql = "SELECT pkp.permintaankepenunjang_id, pkp.daftartindakan_id, "
							. "pkp.pemeriksaanrad_id, pl.pemeriksaanrad_nama, pkp.qtypermintaan, jpl.jenispemeriksaanrad_nama "
							. "FROM permintaankepenunjang_t pkp JOIN pemeriksaanrad_m pl ON pkp.pemeriksaanrad_id=pl.pemeriksaanrad_id "
							. "JOIN jenispemeriksaanrad_m jpl ON pl.jenispemeriksaanrad_id=jpl.jenispemeriksaanrad_id "
							. "WHERE pkp.pasienkirimkeunitlain_id=".$pasienKirimKeUnitlainID;
					$loadData2 = Yii::app()->db->createCommand($sql)->queryAll();
					if (sizeof($loadData2)>0) {
						$data['data'][$i]['detail']=$loadData2;
						$data['is_found'] = 1;
						$data['pesan'] = "Data ditemukan!"; 
					}
					$i++;
				}
				
			}
		}
		
		$encode = CJSON::encode($data);
		echo "jsonCallback(".$encode.")";
		Yii::app()->end();
	}
	
	/**
	 * action untuk menghapus data item lab
	 * @param pasienkirimkeunitlain_id
	 * @return status 1/0 deleted or not
	 */	
	public function actionDeleteItemLab() {
		header("content-type:application/json");
		$data['is_found'] = 0;
        $data['pesan'] = "Data tidak ditemukan!";
        $data['sukses'] = 0;
		
		if (isset($_GET['pasienkirimkeunitlain_id'])) {
			//$sql = "DELETE FROM pasienkirimkeunitlain_t WHERE pasienkirimkeunitlain_id=".$pasienKirimKeUnitlainID;
			
			
			if (Yii::app()->db->createCommand()->delete('permintaankepenunjang_t', 'pasienkirimkeunitlain_id=:id', array(':id'=>$_GET['pasienkirimkeunitlain_id']))) {
				if (Yii::app()->db->createCommand()->delete('pasienkirimkeunitlain_t', 'pasienkirimkeunitlain_id=:id', array(':id'=>$_GET['pasienkirimkeunitlain_id']))) {
					$data['sukses'] = 1;
					$data['pesan'] = 'Data berhasil dihapus!';
				}
			}
		}
		
		$encode = CJSON::encode($data);
		echo "jsonCallback(".$encode.")";
		Yii::app()->end();
	}
	
	/**
	 * action untuk pemilihan pemeriksaan radiologi
	 * @params ruangan_id, penjamin_id, kelaspelayanan_id, q
	 * @return array pf pemeriksaan lab
	 * 
	 */
	public function actionGetPemeriksaanRadiologi(){
		header("content-type:application/json");
		$data = array();
		if(isset($_GET['ruangan_id']) && isset($_GET['penjamin_id']) && isset($_GET['kelaspelayanan_id'])){
			$req = (isset($_GET['q']) ? str_replace('"','',str_replace("'","",strtolower(trim($_GET['q'])))) : "");
			
			$sql = "SELECT daftartindakan_m.daftartindakan_id,
						jenispemeriksaanrad_m.jenispemeriksaanrad_id, 
						jenispemeriksaanrad_m.jenispemeriksaanrad_kode, 
						jenispemeriksaanrad_m.jenispemeriksaanrad_nama,
						pemeriksaanrad_m.pemeriksaanrad_id, 
						pemeriksaanrad_m.pemeriksaanrad_kode, 
						pemeriksaanrad_m.pemeriksaanrad_nama,
						tariftindakan_m.harga_tariftindakan, 
						tariftindakan_m.persendiskon_tind, 
						tariftindakan_m.hargadiskon_tind
						FROM pemeriksaanrad_m
						JOIN jenispemeriksaanrad_m ON jenispemeriksaanrad_m.jenispemeriksaanrad_id = pemeriksaanrad_m.jenispemeriksaanrad_id
						JOIN daftartindakan_m ON daftartindakan_m.daftartindakan_id = pemeriksaanrad_m.daftartindakan_id
						JOIN tindakanruangan_m ON daftartindakan_m.daftartindakan_id = tindakanruangan_m.daftartindakan_id
						JOIN tariftindakan_m ON tariftindakan_m.daftartindakan_id = daftartindakan_m.daftartindakan_id
						JOIN jenistarifpenjamin_m ON jenistarifpenjamin_m.jenistarif_id = tariftindakan_m.jenistarif_id
						WHERE tariftindakan_m.komponentarif_id = ".Params::KOMPONENTARIF_ID_TOTAL."
						AND jenispemeriksaanrad_m.jenispemeriksaanrad_aktif = TRUE
						AND pemeriksaanrad_m.pemeriksaanrad_aktif = TRUE
						AND tariftindakan_m.kelaspelayanan_id = ".$_GET['kelaspelayanan_id']."
						AND tariftindakan_m.jenistarif_id = ".Params::JENISTARIF_ID_PELAYANAN."
						AND(
							LOWER(jenispemeriksaanrad_m.jenispemeriksaanrad_kode) like '%".$req."%'
							OR LOWER(jenispemeriksaanrad_m.jenispemeriksaanrad_nama) like '%".$req."%'
							OR LOWER(pemeriksaanrad_m.pemeriksaanrad_kode) like '%".$req."%'
							OR LOWER(pemeriksaanrad_m.pemeriksaanrad_nama) like '%".$req."%'
						)
					ORDER BY daftartindakan_m.daftartindakan_id ASC, pemeriksaanrad_m.pemeriksaanrad_urutan ASC";
			$loadData = Yii::app()->db->createCommand($sql)->queryAll();
			$data['data'] = $loadData;	
            $n = sizeof($loadData);
            if ($n>0) {
                $data['is_found'] = 1;
                $data['pesan'] = "Data ditemukan!";    
            }
		}
		$encode = CJSON::encode($data);
		echo "jsonCallback(".$encode.")";
		Yii::app()->end();
	}
	
	/**
	 * transaksi simpan rujuk ke radiologi
	 * @param $_GET['pasienkirimkeunitlain'] array
	 * @param $_GET['permintaankepenunjang'] array(array()) //detail pemeriksaan
	 * @return json
	 */
	public function actionSubmitRujukKeRadiologi(){
		header("content-type:application/json");
		$data = array();
		$data['sukses'] = 0;
		$data['pesan'] = 'Error 404 : Request tidak valid. Cek parameter';
		$errorDetail = "";
		if(isset($_GET['pasienkirimkeunitlain']) && isset($_GET['permintaankepenunjang'])){
			$transaction = Yii::app()->db->beginTransaction();
			try{
				$format = new MyFormatter;
				$model = new MOPasienkirimkeunitlainT;
				$model->attributes = $_GET['pasienkirimkeunitlain'];
				$model->tgl_kirimpasien = $format->formatDateTimeForDb($_GET['pasienkirimkeunitlain']['tgl_kirimpasien']);
				$model->create_time = date("Y-m-d H:i:s");
				$model->update_time = $model->create_time;
				$model->update_loginpemakai_id = $model->create_loginpemakai_id;
				$model->nourut = MyGenerator::noUrutPasienKirimKeUnitLain($model->ruangan_id);
				
				if($model->save()) {
					if(count($_GET['permintaankepenunjang']) > 0){
						foreach($_GET['permintaankepenunjang'] AS $i => $detail){
							$modPermintaan = new MOPermintaankepenunjangT();							
							$modPermintaan->attributes = $detail;
							$modPermintaan->pasienkirimkeunitlain_id = $model->pasienkirimkeunitlain_id;

							$modPermintaan->tglpermintaankepenunjang = $model->tgl_kirimpasien;
							$prefix = (!empty($model->ruangan->ruangan_singkatan) ? $model->ruangan->ruangan_singkatan : "LB");
							$modPermintaan->noperminatanpenujang = MyGenerator::noPermintaanPenunjang($prefix);

							if($modPermintaan->save()){
							}else{
								$errorDetail .= CHtml::errorSummary($modPermintaan);
							}
						}
					}
					if(empty($errorDetail)){
						$transaction->commit();
						$data['sukses'] = 1;
						$data['pesan'] = 'Data rujuk pasien ke laboratorium berhasil disimpan!';
					}else{
						$transaction->rollback();
						$data['sukses'] = 0;
						$data['pesan'] = 'Data detail pemeriksaan gagal disimpan!<br>'.$errorDetail;
					}

				}else{
					$transaction->rollback();
					$data['sukses'] = 0;
					$data['pesan'] = 'Data rujuk pasien ke laboratorium gagal disimpan!<br>'.CHtml::errorSummary($model)."<br><pre>".$errorDetail."</pre>";
				}
			}catch (Exception $exc) {
				$transaction->rollback();
				$data['sukses'] = 0;
				$data['pesan'] = 'Data rujuk pasien ke laboratorium gagal disimpan!'.MyExceptionMessage::getMessage($exc,true);
			}

		}
		$encode = CJSON::encode($data);
		echo "jsonCallback(".$encode.")";
		Yii::app()->end();
	}
	
	/**
	 * action untuk menghapus data item radiologi
	 * @param pasienkirimkeunitlain_id
	 * @return status 1/0 deleted or not
	 */	
	public function actionDeleteItemRadiologi() {
		header("content-type:application/json");
		$data['is_found'] = 0;
        $data['pesan'] = "Data tidak ditemukan!";
        $data['sukses'] = 0;
		
		if (isset($_GET['pasienkirimkeunitlain_id'])) {
			//$sql = "DELETE FROM pasienkirimkeunitlain_t WHERE pasienkirimkeunitlain_id=".$pasienKirimKeUnitlainID;
			
			
			if (Yii::app()->db->createCommand()->delete('permintaankepenunjang_t', 'pasienkirimkeunitlain_id=:id', array(':id'=>$_GET['pasienkirimkeunitlain_id']))) {
				if (Yii::app()->db->createCommand()->delete('pasienkirimkeunitlain_t', 'pasienkirimkeunitlain_id=:id', array(':id'=>$_GET['pasienkirimkeunitlain_id']))) {
					$data['sukses'] = 1;
					$data['pesan'] = 'Data berhasil dihapus!';
				}
			}
		}
		
		$encode = CJSON::encode($data);
		echo "jsonCallback(".$encode.")";
		Yii::app()->end();
	}
	
	
	/**
	 * action untuk mendapatkan item rujukan yang telah diinput sebelumnya
	 * @param pendaftaran_id
	 * @return item rujukan dan informasi data yang dikirim ke penunjang
	 */	
	public function actionGetRujukanKeRehabMedis() {
		header("content-type:application/json");
		$data['is_found'] = 0;
        $data['pesan'] = "Data tidak ditemukan!";
        $data['data'] = '';
		$data['header'] = '';
		if (isset($_GET['pendaftaran_id'])) {
			$pendaftaran_id = $_GET['pendaftaran_id'];
			$sql = "SELECT * FROM pasienkirimkeunitlain_t pkul JOIN kelaspelayanan_m kp ON pkul.kelaspelayanan_id=kp.kelaspelayanan_id WHERE pkul.pendaftaran_id=".$pendaftaran_id;
			$loadData = Yii::app()->db->createCommand($sql)->queryAll();			
			if (sizeof($loadData)>0) {
				$i=0;
				foreach ($loadData as $datum) {
					$data['data'][$i]['tgl_kirimpasien'] = $datum['tgl_kirimpasien'];
					$data['data'][$i]['pasienkirimkeunitlain_id'] = $datum['pasienkirimkeunitlain_id'];
					$pasienKirimKeUnitlainID = $datum['pasienkirimkeunitlain_id'];
					$sql = "SELECT pkp.permintaankepenunjang_id, pkp.daftartindakan_id, "
							. "jtr.jenistindakanrm_id, trm.tindakanrm_nama, pkp.qtypermintaan, jtr.jenistindakanrm_nama "
							. "FROM permintaankepenunjang_t pkp JOIN tindakanrm_m trm ON pkp.tindakanrm_id=trm.tindakanrm_id "
							. "JOIN jenistindakanrm_m jtr ON trm.jenistindakanrm_id=jtr.jenistindakanrm_id "
							. "WHERE pkp.pasienkirimkeunitlain_id=".$pasienKirimKeUnitlainID;
					$loadData2 = Yii::app()->db->createCommand($sql)->queryAll();
					if (sizeof($loadData2)>0) {
						//echo sizeof($loadData2)
						$data['data'][$i]['detail']=$loadData2;
						$data['is_found'] = 1;
						$data['pesan'] = "Data ditemukan!"; 
					}
					$i++;	
				}	
			}
		}
		
		$encode = CJSON::encode($data);
		echo "jsonCallback(".$encode.")";
		Yii::app()->end();
	}
	
	/**
	 * action untuk pemilihan pemeriksaan radiologi
	 * @params ruangan_id, penjamin_id, kelaspelayanan_id, q
	 * @return array pf pemeriksaan lab
	 * 
	 */
	public function actionGetTindakanRehabMedis(){
		header("content-type:application/json");
		$data = array();
		if(isset($_GET['ruangan_id']) && isset($_GET['penjamin_id']) && isset($_GET['kelaspelayanan_id'])){
			$req = (isset($_GET['q']) ? str_replace('"','',str_replace("'","",strtolower(trim($_GET['q'])))) : "");
			$sql = "SELECT daftartindakan_m.daftartindakan_id,
						jenistindakanrm_m.jenistindakanrm_id, 
						jenistindakanrm_m.jenistindakanrm_kode, 
						jenistindakanrm_m.jenistindakanrm_nama,
						tindakanrm_m.tindakanrm_id, 
						tindakanrm_m.tindakanrm_kode, 
						tindakanrm_m.tindakanrm_nama,
						tariftindakan_m.harga_tariftindakan, 
						tariftindakan_m.persendiskon_tind, 
						tariftindakan_m.hargadiskon_tind
						FROM tindakanrm_m
						JOIN jenistindakanrm_m ON jenistindakanrm_m.jenistindakanrm_id = tindakanrm_m.jenistindakanrm_id
						JOIN daftartindakan_m ON daftartindakan_m.daftartindakan_id = tindakanrm_m.daftartindakan_id
						JOIN tindakanruangan_m ON daftartindakan_m.daftartindakan_id = tindakanruangan_m.daftartindakan_id
						JOIN tariftindakan_m ON tariftindakan_m.daftartindakan_id = daftartindakan_m.daftartindakan_id
						JOIN jenistarifpenjamin_m ON jenistarifpenjamin_m.jenistarif_id = tariftindakan_m.jenistarif_id
						WHERE tariftindakan_m.komponentarif_id = ".Params::KOMPONENTARIF_ID_TOTAL."
						AND jenistindakanrm_m.jenistindakanrm_aktif = TRUE
						AND tindakanrm_m.tindakanrm_aktif = TRUE
						AND tariftindakan_m.kelaspelayanan_id = ".$_GET['kelaspelayanan_id']."
						AND tariftindakan_m.jenistarif_id = ".Params::JENISTARIF_ID_PELAYANAN."
						AND(
							LOWER(jenistindakanrm_m.jenistindakanrm_kode) like '%".$req."%'
							OR LOWER(jenistindakanrm_m.jenistindakanrm_nama) like '%".$req."%'
							OR LOWER(tindakanrm_m.tindakanrm_kode) like '%".$req."%'
							OR LOWER(tindakanrm_m.tindakanrm_nama) like '%".$req."%'
						)
					ORDER BY jenistindakanrm_m.jenistindakanrm_urutan ASC, tindakanrm_m.tindakanrm_urutan ASC";
			$loadData = Yii::app()->db->createCommand($sql)->queryAll();
			$data['data'] = $loadData;	
            $n = sizeof($loadData);
			
            if ($n>0) {
                $data['is_found'] = 1;
                $data['pesan'] = "Data ditemukan!";    
            }
		}
		$encode = CJSON::encode($data);
		echo "jsonCallback(".$encode.")";
		Yii::app()->end();
	}
	
	
	/**
	 * transaksi simpan rujuk ke rehab medis
	 * @param $_GET['pasienkirimkeunitlain'] array
	 * @param $_GET['permintaankepenunjang'] array(array()) //detail pemeriksaan
	 * @return json
	 */	
	public function actionSubmitRujukKeRehabMedis(){
		header("content-type:application/json");
		$data = array();
		$data['sukses'] = 0;
		$data['pesan'] = 'Error 404 : Request tidak valid. Cek parameter';
		$errorDetail = "";
		if(isset($_GET['pasienkirimkeunitlain']) && isset($_GET['permintaankepenunjang'])){
			$transaction = Yii::app()->db->beginTransaction();
			try{
				$format = new MyFormatter;
				$model = new MOPasienkirimkeunitlainT;
				$model->attributes = $_GET['pasienkirimkeunitlain'];
				$model->tgl_kirimpasien = $format->formatDateTimeForDb($_GET['pasienkirimkeunitlain']['tgl_kirimpasien']);
				$model->create_time = date("Y-m-d H:i:s");
				$model->update_time = $model->create_time;
				$model->update_loginpemakai_id = $model->create_loginpemakai_id;
				$model->nourut = MyGenerator::noUrutPasienKirimKeUnitLain($model->ruangan_id);
				
				if($model->save()) {
					if(count($_GET['permintaankepenunjang']) > 0){
						foreach($_GET['permintaankepenunjang'] AS $i => $detail){
							$modPermintaan = new MOPermintaankepenunjangT();							
							$modPermintaan->attributes = $detail;
							$modPermintaan->pasienkirimkeunitlain_id = $model->pasienkirimkeunitlain_id;
							$modPermintaan->tglpermintaankepenunjang = $model->tgl_kirimpasien;
							$prefix = (!empty($model->ruangan->ruangan_singkatan) ? $model->ruangan->ruangan_singkatan : "RM");
							$modPermintaan->noperminatanpenujang = MyGenerator::noPermintaanPenunjang($prefix);

							if($modPermintaan->save()){
							}else{
								$errorDetail .= CHtml::errorSummary($modPermintaan);
							}
						}
					}
					if(empty($errorDetail)){
						$transaction->commit();
						$data['sukses'] = 1;
						$data['pesan'] = 'Data rujuk pasien ke laboratorium berhasil disimpan!';
					}else{
						$transaction->rollback();
						$data['sukses'] = 0;
						$data['pesan'] = 'Data detail pemeriksaan gagal disimpan!<br>'.$errorDetail;
					}

				}else{
					$transaction->rollback();
					$data['sukses'] = 0;
					$data['pesan'] = 'Data rujuk pasien ke laboratorium gagal disimpan!<br>'.CHtml::errorSummary($model)."<br><pre>".$errorDetail."</pre>";
				}
			}catch (Exception $exc) {
				$transaction->rollback();
				$data['sukses'] = 0;
				$data['pesan'] = 'Data rujuk pasien ke laboratorium gagal disimpan!'.MyExceptionMessage::getMessage($exc,true);
			}

		}
		$encode = CJSON::encode($data);
		echo "jsonCallback(".$encode.")";
		Yii::app()->end();
	}
	
	/**
	 * action untuk menghapus data item rehab medis
	 * @param pasienkirimkeunitlain_id
	 * @return status 1/0 deleted or not
	 */	
	public function actionDeleteItemRehabMedis() {
		header("content-type:application/json");
		$data['is_found'] = 0;
        $data['pesan'] = "Data tidak ditemukan!";
        $data['sukses'] = 0;
		
		if (isset($_GET['pasienkirimkeunitlain_id'])) {
			//$sql = "DELETE FROM pasienkirimkeunitlain_t WHERE pasienkirimkeunitlain_id=".$pasienKirimKeUnitlainID;
			
			
			if (Yii::app()->db->createCommand()->delete('permintaankepenunjang_t', 'pasienkirimkeunitlain_id=:id', array(':id'=>$_GET['pasienkirimkeunitlain_id']))) {
				if (Yii::app()->db->createCommand()->delete('pasienkirimkeunitlain_t', 'pasienkirimkeunitlain_id=:id', array(':id'=>$_GET['pasienkirimkeunitlain_id']))) {
					$data['sukses'] = 1;
					$data['pesan'] = 'Data berhasil dihapus!';
				}
			}
		}
		
		$encode = CJSON::encode($data);
		echo "jsonCallback(".$encode.")";
		Yii::app()->end();
	}
	
	/**
	 * set form pemilihan tindakan konsul gizi
	 * MA-201
	 * @params: ruangan_id, penjamin_id, kelaspelayanan_id, q
	 * @return:
	 * - 
	 */
	public function actionGetTindakanKonsulGizi(){
		header("content-type:application/json");
		$data = array();
		$data['sukses'] = 0;
		$data['pesan'] = 'Error 404 : Request tidak valid. Cek parameter';
		if(isset($_GET['ruangan_id']) && isset($_GET['penjamin_id']) && isset($_GET['kelaspelayanan_id'])){
			$req = (isset($_GET['q']) ? str_replace('"','',str_replace("'","",strtolower(trim($_GET['q'])))) : "");
			$sql = "SELECT daftartindakan_m.daftartindakan_id, daftartindakan_m.daftartindakan_kode, daftartindakan_m.daftartindakan_nama, 
						tariftindakan_m.harga_tariftindakan, tariftindakan_m.persendiskon_tind, tariftindakan_m.hargadiskon_tind
					FROM daftartindakan_m
					JOIN tindakanruangan_m ON daftartindakan_m.daftartindakan_id = tindakanruangan_m.daftartindakan_id
					JOIN tariftindakan_m ON tariftindakan_m.daftartindakan_id = daftartindakan_m.daftartindakan_id
					JOIN jenistarifpenjamin_m ON jenistarifpenjamin_m.jenistarif_id = tariftindakan_m.jenistarif_id
					WHERE tariftindakan_m.komponentarif_id = ".Params::KOMPONENTARIF_ID_TOTAL."
					AND tindakanruangan_m.ruangan_id = ".Params::RUANGAN_ID_GIZI."	
					AND daftartindakan_m.daftartindakan_aktif = TRUE
					AND daftartindakan_m.daftartindakan_konsul is TRUE
					AND tariftindakan_m.kelaspelayanan_id = ".$_GET['kelaspelayanan_id']."
					AND tariftindakan_m.jenistarif_id = ".Params::JENISTARIF_ID_PELAYANAN."
					AND(
						LOWER(daftartindakan_m.daftartindakan_kode) like '%".$req."%'
						OR LOWER(daftartindakan_m.daftartindakan_nama) like '%".$req."%'
					)
					ORDER BY daftartindakan_m.daftartindakan_kode ASC, daftartindakan_m.daftartindakan_nama ASC LIMIT 8
					";
			$loadData = Yii::app()->db->createCommand($sql)->queryAll();
			$data['data'] = $loadData;	
            $n = sizeof($loadData);
            if ($n>0) {
                $data['is_found'] = 1;
                $data['pesan'] = "Data ditemukan!";    
            }
		}
		$encode = CJSON::encode($data);
		echo "jsonCallback(".$encode.")";
		Yii::app()->end();
	}
	
	/**
	 * transaksi simpan konsultasi gizi
	 * @param $_GET['pasienkirimkeunitlain'] array
	 * @param $_GET['permintaankepenunjang'] array(array()) //detail pemeriksaan
	 * @return json
	 */	
	public function actionSubmitKonsultasiGizi(){
		header("content-type:application/json");
		$data = array();
		$data['sukses'] = 0;
		$data['pesan'] = 'Error 404 : Request tidak valid. Cek parameter';
		$errorDetail = "";
		if(isset($_GET['pasienkirimkeunitlain']) && isset($_GET['permintaankepenunjang'])){
			$transaction = Yii::app()->db->beginTransaction();
			try{
				$format = new MyFormatter;
				$model = new MOPasienkirimkeunitlainT;
				$model->attributes = $_GET['pasienkirimkeunitlain'];
				$model->tgl_kirimpasien = $format->formatDateTimeForDb($_GET['pasienkirimkeunitlain']['tgl_kirimpasien']);
				$model->create_time = date("Y-m-d H:i:s");
				$model->update_time = $model->create_time;
				$model->update_loginpemakai_id = $model->create_loginpemakai_id;
				$model->nourut = MyGenerator::noUrutPasienKirimKeUnitLain($model->ruangan_id);
				if ($model->save()) {
					if(count($_GET['permintaankepenunjang']) > 0){
						foreach($_GET['permintaankepenunjang'] AS $i => $detail){
							$modPermintaan = new MOPermintaankepenunjangT();							
							$modPermintaan->attributes = $detail;
							$modPermintaan->pasienkirimkeunitlain_id = $model->pasienkirimkeunitlain_id;

							$modPermintaan->tglpermintaankepenunjang = $model->tgl_kirimpasien;
							$prefix = (!empty($model->ruangan->ruangan_singkatan) ? $model->ruangan->ruangan_singkatan : "RM");
							$modPermintaan->noperminatanpenujang = MyGenerator::noPermintaanPenunjang($prefix);

							if($modPermintaan->save()){
							}else{
								$errorDetail .= CHtml::errorSummary($modPermintaan);
							}
						}
					}
					if(empty($errorDetail)){
						$transaction->commit();
						$data['sukses'] = 1;
						$data['pesan'] = 'Data rujuk pasien ke laboratorium berhasil disimpan!';
					}else{
						$transaction->rollback();
						$data['sukses'] = 0;
						$data['pesan'] = 'Data detail pemeriksaan gagal disimpan!<br>'.$errorDetail;
					}

				}else{
					$transaction->rollback();
					$data['sukses'] = 0;
					$data['pesan'] = 'Data rujuk pasien ke laboratorium gagal disimpan!<br>'.CHtml::errorSummary($model)."<br><pre>".$errorDetail."</pre>";
				}
			}catch (Exception $exc) {
				$transaction->rollback();
				$data['sukses'] = 0;
				$data['pesan'] = 'Data rujuk pasien ke laboratorium gagal disimpan!'.MyExceptionMessage::getMessage($exc,true);
			}

		}
		$encode = CJSON::encode($data);
		echo "jsonCallback(".$encode.")";
		Yii::app()->end();
	}
	
	
	/**
	 * action untuk mendapatkan item konsultasi gizi yang telah diinput sebelumnya
	 * @param pendaftaran_id
	 * @return item konsultasi gizi
	 */	
	public function actionGetKonsultasiGizi() {
		header("content-type:application/json");
		$data['is_found'] = 0;
        $data['pesan'] = "Data tidak ditemukan!";
        $data['data'] = '';
		$data['header'] = '';
		if (isset($_GET['pendaftaran_id'])) {
			$pendaftaran_id = $_GET['pendaftaran_id'];
			//$ruangan_id = $_GET['ruangan_id'];
			$sql = "SELECT * FROM pasienkirimkeunitlain_t pkul JOIN kelaspelayanan_m kp ON pkul.kelaspelayanan_id=kp.kelaspelayanan_id WHERE pkul.ruangan_id=".Params::RUANGAN_ID_GIZI." AND pkul.pendaftaran_id=".$pendaftaran_id;
			$loadData = Yii::app()->db->createCommand($sql)->queryAll();			
			if (sizeof($loadData)>0) {
				$i=0;
				foreach ($loadData as $datum) {
					$data['data'][$i]['tgl_kirimpasien'] = $datum['tgl_kirimpasien'];
					$data['data'][$i]['pasienkirimkeunitlain_id'] = $datum['pasienkirimkeunitlain_id'];
					$pasienKirimKeUnitlainID = $datum['pasienkirimkeunitlain_id'];
					$sql = "SELECT pkp.permintaankepenunjang_id, pkp.daftartindakan_id, "
							. "dt.daftartindakan_nama, pkp.qtypermintaan "
							. "FROM permintaankepenunjang_t pkp JOIN daftartindakan_m dt ON pkp.daftartindakan_id=dt.daftartindakan_id "
							. "WHERE pkp.pasienkirimkeunitlain_id=".$pasienKirimKeUnitlainID
							. "AND pkp.pasienkirimkeunitlain_id=".$pasienKirimKeUnitlainID;
					$loadData2 = Yii::app()->db->createCommand($sql)->queryAll();
					if (sizeof($loadData2)>0) {
						$data['data'][$i]['detail']=$loadData2;
						$data['is_found'] = 1;
						$data['pesan'] = "Data ditemukan!"; 
					}
					$i++;	
				}	
			}
		}
		
		$encode = CJSON::encode($data);
		echo "jsonCallback(".$encode.")";
		Yii::app()->end();
	}
	
	/**
	 * action untuk menghapus data item konsultasi gizi
	 * @param pasienkirimkeunitlain_id
	 * @return status 1/0 deleted or not
	 */	
	public function actionDeleteItemKonsultasiGizi() {
		header("content-type:application/json");
		$data['is_found'] = 0;
        $data['pesan'] = "Data tidak ditemukan!";
        $data['sukses'] = 0;
		
		if (isset($_GET['pasienkirimkeunitlain_id'])) {
			if (Yii::app()->db->createCommand()->delete('permintaankepenunjang_t', 'pasienkirimkeunitlain_id=:id', array(':id'=>$_GET['pasienkirimkeunitlain_id']))) {
				if (Yii::app()->db->createCommand()->delete('pasienkirimkeunitlain_t', 'pasienkirimkeunitlain_id=:id', array(':id'=>$_GET['pasienkirimkeunitlain_id']))) {
					$data['sukses'] = 1;
					$data['pesan'] = 'Data berhasil dihapus!';
				}
			}
		}
		
		$encode = CJSON::encode($data);
		echo "jsonCallback(".$encode.")";
		Yii::app()->end();
	}
	
	
	/**
	 * transaksi submit konsul poli
	 * @param $_GET['konsulpoli'] array
	 * @return json
	 */
	public function actionSubmitKonsultasiPoliklinik(){
		header("content-type:application/json");
		$data = array();
		$data['sukses'] = 0;
		$data['pesan'] = 'Error 404 : Request tidak valid. Cek parameter';
		
		if(isset($_GET['konsulpoli'])){
			
			$transaction = Yii::app()->db->beginTransaction();
			try{
				$format = new MyFormatter;
				$model = new MOKonsulpoliT();
				$model->attributes = $_GET['konsulpoli'];
				$model->tglkonsulpoli = $format->formatDateTimeForDb($_GET['konsulpoli']['tglkonsulpoli']);
				$model->statusperiksa = PARAMS::STATUSPERIKSA_ANTRIAN;
				$model->catatan_dokter_konsul = str_replace("'","",str_replace('"', '', $_GET['konsulpoli']['catatan_dokter_konsul']));
				$model->create_time = date("Y-m-d H:i:s");
				$model->update_time = $model->create_time;
				$model->update_loginpemakai_id = $model->create_loginpemakai_id;
				$model->create_ruangan = $model->ruangan_id;
				$model->no_antriankonsul = MyGenerator::noAntrianKonsulPoli($model->ruangan_id);
				
				if($model->save()){
					$transaction->commit();
					$data['sukses'] = 1;
					$data['pesan'] = 'Data konsul poli berhasil disimpan!';
				}else{
					$transaction->rollback();
					$data['sukses'] = 0;
					$data['pesan'] = 'Data konsul poli gagal disimpan!<br>'.CHtml::errorSummary($model);
				}
			}catch (Exception $exc) {
				$transaction->rollback();
				$data['sukses'] = 0;
				$data['pesan'] = 'Data konsul poli gagal disimpan!'.MyExceptionMessage::getMessage($exc,true);
			}

		}
		$encode = CJSON::encode($data);
		echo "jsonCallback(".$encode.")";
		Yii::app()->end();
	}
	
	public function actionGetRuanganRawatJalan() {
		header("content-type:application/json");
		$data = array();
		$data['is_found'] = 0;
        $data['pesan'] = "Data tidak ditemukan!";
        $data['sukses'] = 0;
		$sql = "SELECT *
				FROM ruangan_m
				WHERE ruangan_aktif = TRUE AND instalasi_id='".Params::INSTALASI_ID_RJ."'
				ORDER BY ruangan_nourut";
		$loadData = Yii::app()->db->createCommand($sql)->queryAll();
		$data['data'] = $loadData;
		if(sizeof($loadData)>0){
			$data['is_found'] = 1;
            $data['pesan'] = "Data ditemukan!";    
		}
		$encode = CJSON::encode($data);
		echo "jsonCallback(".$encode.")";
		Yii::app()->end();
	}
	
	public function actionGetTarifKonsulPoli() {
		header("content-type:application/json");
		$data = array();
		$data['is_found'] = 0;
        $data['pesan'] = "Data tidak ditemukan!";
		if (isset($_GET['kelaspelayanan_id'])) {	
			$kelasPelayananID = $_GET['kelaspelayanan_id'];
			$jenistarif = JenistarifpenjaminM::model()->find('penjamin_id ='.$penjaminID)->jenistarif_id;
			$sql = "SELECT *
				FROM tariftindakan_m
				WHERE kelaspelayanan_id =$kelasPelayananID"
					."AND komponentarif_id=".Params::KOMPONENTARIF_ID_TOTAL." 
					AND	daftartindakan_id =".Params::DAFTARTINDAKAN_ID_KONSUL."
				ORDER BY ruangan_nourut";
			$loadData = Yii::app()->db->createCommand($sql)->queryAll();
			$data['data'] = $loadData;
			if(sizeof($loadData)>0){
				$data['is_found'] = 1;
				$data['pesan'] = "Data ditemukan!";    
			}
		}
        $data['sukses'] = 0;
		
		$encode = CJSON::encode($data);
		echo "jsonCallback(".$encode.")";
		Yii::app()->end();
	}
	
	public function actionGetPolyCounseling() {
		header("content-type:application/json");
		$data['is_found'] = 0;
        $data['pesan'] = "Data tidak ditemukan!";
        $data['data'] = '';
		if (isset($_GET['pendaftaran_id'])) {
			$pendaftaran_id = $_GET['pendaftaran_id'];
			$sql = "SELECT *, (SELECT ruangan_nama FROM ruangan_m r WHERE r.ruangan_id=kp.ruangan_id) AS ruangan_tujuan, "
					. "(SELECT ruangan_nama FROM ruangan_m r WHERE r.ruangan_id=kp.asalpoliklinikkonsul_id) AS ruangan_asal FROM konsulpoli_t kp "
					. "WHERE kp.pendaftaran_id=".$pendaftaran_id;
			$loadData = Yii::app()->db->createCommand($sql)->queryAll();			
			if (sizeof($loadData)>0) {
				$data['data']=$loadData;
				$data['is_found'] = 1;
				$data['pesan'] = "Data ditemukan!"; 	
			}
		}		
		$encode = CJSON::encode($data);
		echo "jsonCallback(".$encode.")";
		Yii::app()->end();
	}
	
	public function actionAjaxSetTarif()
	{
		if(Yii::app()->request->isAjaxRequest) {
		$penjamin_id = (isset($_POST['penjamin_id']) ? $_POST['penjamin_id'] : null);
		$ruangan_id = (isset($_POST['ruangan_id']) ? $_POST['ruangan_id'] : null);
		$kelaspelayanan_id = (isset($_POST['kelaspelayanan_id']) ? $_POST['kelaspelayanan_id'] : null);
		$ruangan = RuanganM::model()->findByPk($ruangan_id);
		$ruangan_nama = $ruangan->ruangan_nama;
		$jenistarif = JenistarifpenjaminM::model()->find('penjamin_id ='.$penjamin_id)->jenistarif_id;

		$criteria = new CDbCriteria();            
		$criteria->addCondition('komponentarif_id ='.Params::KOMPONENTARIF_ID_TOTAL);
		$criteria->addCondition('daftartindakan_id = '.Params::DAFTARTINDAKAN_ID_KONSUL);
		if(!empty($kelaspelayanan_id)){
			$criteria->addCondition("kelaspelayanan_id = ".$kelaspelayanan_id);						
		}
		if(!empty($jenistarif)){
			$criteria->addCondition("jenistarif_id = ".$jenistarif);						
		}
		$model = TariftindakanM::model()->findAll($criteria);

		$data['result'] = $this->renderPartial($this->path_view.'_listTarifKonsul', array('model'=>$model,'ruangan_nama'=>$ruangan_nama), true);

		echo json_encode($data);
		Yii::app()->end();
		}
	}
	
	/**
	 * action untuk menghapus data item konsultasi poliklinik
	 * @param konsulpoli_id
	 * @return status 1/0 deleted or not
	 */	
	public function actionDeleteKonsultasiPoliklinik() {
		header("content-type:application/json");
		$data['is_found'] = 0;
        $data['pesan'] = "Data tidak ditemukan!";
        $data['sukses'] = 0;
		
		if (isset($_GET['konsulpoli_id'])) {
			if (Yii::app()->db->createCommand()->delete('konsulpoli_t', 'konsulpoli_id=:id', array(':id'=>$_GET['konsulpoli_id']))) {
				$data['sukses'] = 1;
				$data['pesan'] = 'Data berhasil dihapus!';
			}
		}
		
		$encode = CJSON::encode($data);
		echo "jsonCallback(".$encode.")";
		Yii::app()->end();
	}
	
	/**
	 * action untuk mendapatkan list diagnosa yang telah dilakukan kepada pasien
	 * 
	 * @param pendaftaran_id
	 * @return array history diagnosa pasien
	 */
	public function actionRiwayatDiagnosa() {
		header("content-type:application/json");
		$data = array();
		$data['is_found'] = 0;
        $data['pesan'] = "Data tidak ditemukan!";
		if (isset($_GET['pendaftaran_id'])) {	
			$pendaftaranID = $_GET['pendaftaran_id'];
			$sql = "SELECT * FROM pasienmorbiditas_t pmd JOIN diagnosa_m d ON pmd.diagnosa_id=d.diagnosa_id "
					. "WHERE pmd.pendaftaran_id=$pendaftaranID";
			$loadData = Yii::app()->db->createCommand($sql)->queryAll();
			$data['data'] = $loadData;
			if(sizeof($loadData)>0){
				$data['is_found'] = 1;
				$data['pesan'] = "Data ditemukan!";    
			}
		}
        $data['sukses'] = 0;
		$encode = CJSON::encode($data);
		echo "jsonCallback(".$encode.")";
		Yii::app()->end();
	}
	
	
	/**
	 * action untuk mendapatkan kelompok diagnosa
	 * 
	 * @return group diagnosa
	 */
	public function actionGetGroupDiagnosa() {
		header("content-type:application/json");
		$data = array();
		$data['is_found'] = 0;
        $data['pesan'] = "Data tidak ditemukan!";
		$sql = "SELECT * 
					FROM kelompokdiagnosa_m
					WHERE kelompokdiagnosa_aktif = TRUE";
		$loadData = Yii::app()->db->createCommand($sql)->queryAll();
        if (sizeof($loadData)>0) {
			$data['is_found'] = 1;
			$data['pesan'] = "Data ditemukan!";
			$data['data'] = $loadData;
		}		
		$encode = CJSON::encode($data);
		echo "jsonCallback(".$encode.")";
		Yii::app()->end();				
	}
	
	/**
	 * action untuk untuk menyimpan data mordibitas dari diagnosis yang dilakukan pada pasien rawat jalan
	 * 
	 * @param data mordibitas
	 */
	public function actionSubmitMordibitas() {
		header("content-type:application/json");
		$data = array();
		$data['sukses'] = 0;
		$data['pesan'] = 'Error 404 : Request tidak valid. Cek parameter';
		if(isset($_GET['pasienmordibitas'])){
			$transaction = Yii::app()->db->beginTransaction();
			$format = new MyFormatter;
			$errorDetail = "";
			try{
				$model = new MOPasienmorbiditasT;
				$model->attributes = $_GET['pasienmordibitas'];	
				
				$model->tglmorbiditas = (!empty($model->tglmorbiditas) ? $format->formatDateTimeForDb($model->tglmorbiditas) : date("Y-m-d H:i:s"));
				$model->create_time = date("Y-m-d H:i:s");
				$model->kasusdiagnosa = $this->getKasusDiagnosa($model->pasien_id);
			
				if($model->save()){
					$transaction->commit();
					$data['sukses'] = 1;
					$data['pesan'] = 'Data diagnosis berhasil disimpan!';
				}else{
					$errorDetail .= CHtml::errorSummary($model);
					$transaction->rollback();
					$data['sukses'] = 0;
					$data['pesan'] = 'Data diagnosis gagal disimpan!<br>'.$errorDetail;
				}
			}catch (Exception $exc) {
				$transaction->rollback();
				$data['sukses'] = 0;
				$data['pesan'] = 'Data diagnosis gagal disimpan!'.MyExceptionMessage::getMessage($exc,true);
			}
		}
		$encode = CJSON::encode($data);
		echo "jsonCallback(".$encode.")";
		Yii::app()->end();
	}
	
	protected function getKasusDiagnosa($pasien_id){
		$sql = "SELECT pasienmorbiditas_id 
			FROM pasienmorbiditas_t
			WHERE pasien_id = ".$pasien_id;
		$loadData = Yii::app()->db->createCommand($sql)->queryRow();
		if(isset($loadData['pasienmorbiditasi_id'])){
			return Params::KASUSDIAGNOSA_KASUS_LAMA;
		}else{
			return Params::KASUSDIAGNOSA_KASUS_BARU;
		}
	}
	
	/**
	 * action untuk menghapus data item pasien mordibitas
	 * @param konsulpoli_id
	 * @return status 1/0 deleted or not
	 */	
	public function actionDeletePasienMordibitas() {
		header("content-type:application/json");
		$data['is_found'] = 0;
        $data['pesan'] = "Data gagal hapus!";
        $data['sukses'] = 0;
		
		if (isset($_GET['pasienmorbiditas_id'])) {
			if (Yii::app()->db->createCommand()->delete('pasienmorbiditas_t', 'pasienmorbiditas_id=:id', array(':id'=>$_GET['pasienmorbiditas_id']))) {
				$data['sukses'] = 1;
				$data['pesan'] = 'Data berhasil dihapus!';
			}
		}
		
		$encode = CJSON::encode($data);
		echo "jsonCallback(".$encode.")";
		Yii::app()->end();
	}
	
	/**
	 * action untuk mendapatkan data item tipe paket
	 * @param carabayar_id
	 * @param kelaspelayanan_id
	 * @param penjamin_id
	 * 
	 * @return tipe paket tindakan
	 */
	public function actionGetTipePaket() {
		header("content-type:application/json");
		$data = array();
		$data['is_found'] = 0;
        $data['pesan'] = "Data tidak ditemukan!";
		$data['is_found'] = 0;
		if(isset($_GET['carabayar_id']) && isset($_GET['kelaspelayanan_id']) && isset($_GET['penjamin_id'])){
			$sql = "SELECT tipepaket_id, tipepaket_nama, tipepaket_singkatan, tarifpaket, paketsubsidiasuransi, paketsubsidirs, paketiurbiaya 
					FROM 
					tipepaket_m 
					WHERE tipepaket_aktif = TRUE
						AND (
							(carabayar_id = ".$_GET['carabayar_id']." AND kelaspelayanan_id = ".$_GET['kelaspelayanan_id']." AND penjamin_id = ".$_GET['penjamin_id'].")
							OR tipepaket_id = ".Params::TIPEPAKET_ID_NONPAKET."
						)
					ORDER BY tipepaket_id ASC";
			$loadData = Yii::app()->db->createCommand($sql)->queryAll();
			if(sizeof($loadData) > 0){
				$data['data'] = $loadData;
				$data['pesan'] = "Data ditemukan!";
				$data['is_found'] = 1;
			}
		}
		
		$encode = CJSON::encode($data);
		echo "jsonCallback(".$encode.")";
		Yii::app()->end();
	}
	
	/**
	 * action untuk mendapatkan data nama tindakan
	 * @param ruangan_id
	 * @param penjamin_id
	 * @param kelaspelayanan_id
	 * @param tipepaket_id
	 * 
	 * @return array item tindakan
	 */
	public function actionGetItemTindakan(){
		header("content-type:application/json");
		$data = array();
		$data['pesan'] = "Data tidak ditemukan!";
		$data['is_found'] = 0;
		$data['data'] = '';
		if(isset($_GET['ruangan_id']) && isset($_GET['penjamin_id']) && isset($_GET['kelaspelayanan_id']) && isset($_GET['tipepaket_id'])){
			$req = (isset($_GET['q']) ? str_replace('"','',str_replace("'","",strtolower(trim($_GET['q'])))) : "");
			if($_GET['tipepaket_id'] == Params::TIPEPAKET_ID_NONPAKET){
				$sql = "SELECT kelompoktindakan_m.kelompoktindakan_nama, daftartindakan_m.daftartindakan_id, daftartindakan_m.daftartindakan_kode, daftartindakan_m.daftartindakan_nama, 
						tariftindakan_m.harga_tariftindakan, tariftindakan_m.persendiskon_tind, tariftindakan_m.hargadiskon_tind
					FROM daftartindakan_m JOIN kelompoktindakan_m ON daftartindakan_m.kelompoktindakan_id=kelompoktindakan_m.kelompoktindakan_id
					JOIN tindakanruangan_m ON daftartindakan_m.daftartindakan_id = tindakanruangan_m.daftartindakan_id
					JOIN tariftindakan_m ON tariftindakan_m.daftartindakan_id = daftartindakan_m.daftartindakan_id
					JOIN jenistarifpenjamin_m ON tariftindakan_m.jenistarif_id = jenistarifpenjamin_m.jenistarif_id
					WHERE tariftindakan_m.komponentarif_id = ".Params::KOMPONENTARIF_ID_TOTAL."
					AND daftartindakan_m.daftartindakan_aktif = TRUE
					AND tariftindakan_m.kelaspelayanan_id = ".$_GET['kelaspelayanan_id']."
					AND jenistarifpenjamin_m.penjamin_id = ".$_GET['penjamin_id']."
					AND tindakanruangan_m.ruangan_id = ".$_GET['ruangan_id']."
					AND(
						LOWER(daftartindakan_m.daftartindakan_kode) like '%".$req."%'
						OR LOWER(daftartindakan_m.daftartindakan_nama) like '%".$req."%'
					)
					ORDER BY daftartindakan_m.daftartindakan_kode ASC, daftartindakan_m.daftartindakan_nama ASC LIMIT 8
					";
			}else{
				$sql = "SELECT kelompoktindakan_m.kelompoktindakan_nama, daftartindakan_m.daftartindakan_id, daftartindakan_m.daftartindakan_kode, daftartindakan_m.daftartindakan_nama, 
							paketpelayanan_m.tarifpaketpel, paketpelayanan_m.subsidiasuransi, paketpelayanan_m.subsidipemerintah, paketpelayanan_m.subsidirumahsakit, paketpelayanan_m.iurbiaya 
						FROM daftartindakan_m
					JOIN paketpelayanan_m ON daftartindakan_m.daftartindakan_id = paketpelayanan_m.daftartindakan_id
					JOIN tipepaket_m ON tipepaket_m.tipepaket_id = paketpelayanan_m.tipepaket_id
					JOIN penjaminpasien_m ON tipepaket_m.penjamin_id = penjaminpasien_m.penjamin_id
					JOIN jenistarifpenjamin_m ON tariftindakan_m.jenistarif_id = jenistarifpenjamin_m.jenistarif_id
					WHERE tipepaket_m.tipepaket_aktif = true 
						AND daftartindakan_m.daftartindakan_aktif = TRUE
						AND tipepaket_m.tipepaket_id = ".$_GET['tipepaket_id']."
						AND(
							LOWER(daftartindakan_m.daftartindakan_kode) like '%".$req."%'
							OR LOWER(daftartindakan_m.daftartindakan_nama) like '%".$req."%'
						)
					ORDER BY daftartindakan_m.daftartindakan_kode ASC, daftartindakan_m.daftartindakan_nama ASC
					";
			}
			$loadData = Yii::app()->db->createCommand($sql)->queryAll();
			if(sizeof($loadData) > 0){
				$data['data'] = $loadData;
				$data['pesan'] = "Data ditemukan!";
				$data['is_found'] = 1;
			}
		}
		$encode = CJSON::encode($data);
		echo "jsonCallback(".$encode.")";
		Yii::app()->end();
	}
	
	/**
	 * action untuk mendapatkan satuan tindakan
	 * @return array satuan tindakan
	 */	
	public function actionGetSatuanTindakan() {
		header("content-type:application/json");
		$data = array();
		$data['pesan'] = "Data tidak ditemukan!";
		$data['is_found'] = 0;
		$data['data'] = '';
		$sql = "SELECT * FROM lookup_m WHERE lookup_type='satuantindakan'"; 
		$loadData = Yii::app()->db->createCommand($sql)->queryAll();
		if(sizeof($loadData) > 0){
			$data['data'] = $loadData;
			$data['pesan'] = "Data ditemukan!";
			$data['is_found'] = 1;
		}
		$encode = CJSON::encode($data);
		echo "jsonCallback(".$encode.")";
		Yii::app()->end();
	}
	
	/**
	 * action untuk menyimpan data tindakan pelayanan
	 * 
	 * @param serialize tindakan pelayanan
	 * @return sukses 1/0 dan pesan setelah submit
	 */
	public function actionSubmitTindakanPelayanan(){
		header("content-type:application/json");
		$data = array();
		$data['sukses'] = 0;
		$data['pesan'] = 'Error 404 : Request tidak valid. Cek parameter';
		if(isset($_GET['tindakanpelayanan'])){
			$transaction = Yii::app()->db->beginTransaction();
			$format = new MyFormatter;
			$errorTindakan = "";
			$errorDetail = "";
			$tersimpan = true; //di looping tindakan pelayanan + tindakan komponen
			try{
				if(isset($_GET['tindakanpelayanan'])){
					$model = new MOTindakanpelayananT;
					$model->attributes = $_GET['tindakanpelayanan'];
					$model->tgl_tindakan = (!empty($model->tgl_tindakan) ? $format->formatDateTimeForDb($model->tgl_tindakan) : date("Y-m-d H:i:s"));
					$model->create_time = date("Y-m-d H:i:s");
					$model->shift_id = $this->getShift("shift_id");
					$model->tarif_satuan = $model->getTarifSatuan(); //RND-7250
					$model->tarif_tindakan = $model->tarif_satuan * $model->qty_tindakan;
					if(!$model->cyto_tindakan){ //false
						$model->tarifcyto_tindakan = 0;
					}else{
						$model->tarifcyto_tindakan = $model->tarif_tindakan + ($model->tarif_tindakan * 10 / 100);
					}

					$model->pembebasan_tindakan = 0;
					$model->subsidiasuransi_tindakan = 0;
					$model->subsidipemerintah_tindakan = 0;
					$model->subsisidirumahsakit_tindakan = 0;
					$model->iurbiaya_tindakan = 0;

					$model->tarif_rsakomodasi = 0;
					$model->tarif_medis = 0;
					$model->tarif_paramedis = 0;
					$model->tarif_bhp = 0;

					if($model->save()){
						$tersimpan &= $model->saveTindakanKomponen();
					}else{
						$tersimpan = false;
						$errorTindakan .= CHtml::errorSummary($model);
					}
				}
				if($tersimpan){
					$transaction->commit();
					$data['sukses'] = 1;
					$data['pesan'] = 'Data tindakan / pelayanan berhasil disimpan!';
				}else{
					$transaction->rollback();
					$data['sukses'] = 0;
					$data['pesan'] = 'Data tindakan gagal disimpan! <br>'.$errorTindakan;
					if(!empty($errorDetail)){
						$data['pesan'] = 'Data komponen tindakan / pelayanan gagal disimpan!<br>'.$errorDetail;
					}
				}
			}catch (Exception $exc) {
				$transaction->rollback();
				$data['sukses'] = 0;
				$data['pesan'] = 'Data tindakan / pelayanan gagal disimpan!'.MyExceptionMessage::getMessage($exc,true);
			}
		}
		$encode = CJSON::encode($data);
		echo "jsonCallback(".$encode.")";
		Yii::app()->end();
	}
	
	/**
	 * action untuk mendapatkan riwayat tindakan pelayanan
	 * @param pendaftaran_id
	 * @return array dari tindakan
	 */	
	public function actionGetTindakanPelayanan() {
		header("content-type:application/json");
		$data = array();
		$data['pesan'] = "Data tidak ditemukan!";
		$data['is_found'] = 0;
		$data['data'] = '';
		if (isset($_GET['pendaftaran_id'])){
			$sql = "SELECT tindakanpelayanan_t.tgl_tindakan, tindakanpelayanan_t.tindakanpelayanan_id, daftartindakan_m.daftartindakan_nama, tindakanpelayanan_t.qty_tindakan, "
				. "daftartindakan_m.daftartindakan_nama FROM tindakanpelayanan_t "
				. "JOIN daftartindakan_m ON daftartindakan_m.daftartindakan_id=tindakanpelayanan_t.daftartindakan_id "
				. "WHERE tindakanpelayanan_t.pendaftaran_id=".$_GET['pendaftaran_id']; 
			$loadData = Yii::app()->db->createCommand($sql)->queryAll();
			if(sizeof($loadData) > 0){
				$data['data'] = $loadData;
				$data['pesan'] = "Data ditemukan!";
				$data['is_found'] = 1;
			}
		}
		
		$encode = CJSON::encode($data);
		echo "jsonCallback(".$encode.")";
		Yii::app()->end();
	}
	
	/**
	 * action untuk menghapus data item tindakan
	 * @param tindakanpelayanan_id
	 * @return status 1/0 deleted or not
	 */	
	public function actionDeleteTindakan() {
		header("content-type:application/json");
		$data['is_found'] = 0;
        $data['pesan'] = "Data gagal hapus!";
        $data['sukses'] = 0;
		
		if (isset($_GET['tindakanpelayanan_id'])) {
			if (Yii::app()->db->createCommand()->delete('tindakanpelayanan_t', 'tindakanpelayanan_id=:id', array(':id'=>$_GET['tindakanpelayanan_id']))) {
				$data['sukses'] = 1;
				$data['pesan'] = 'Data berhasil dihapus!';
			}
		}
		
		$encode = CJSON::encode($data);
		echo "jsonCallback(".$encode.")";
		Yii::app()->end();
	}
	
	/**
	 * action untuk menyimpan rujukan ke luar
	 * @param serialize data rujukan
	 * @return 1/0, pesan sukses
	 */
	public function actionSubmitRujukanKeLuar(){
		header("content-type:application/json");
		$data = array();
		$data['sukses'] = 0;
		$data['pesan'] = 'Error 404 : Request tidak valid. Cek parameter';
		if(isset($_GET['pasiendirujukkeluar'])){
			$transaction = Yii::app()->db->beginTransaction();
			try{
				$model = new MOPasiendirujukkeluarT;
				$model->attributes = $_GET['pasiendirujukkeluar'];
				$model->create_time = date("Y-m-d H:i:s");
//				print_r($model->attributes);
//				exit;
				if($model->save()){
					MOPendaftaranT::model()->updateByPk($model->pendaftaran_id,array('statusperiksa'=>Params::STATUSPERIKSA_SEDANG_PERIKSA,'update_time'=>date("Y-m-d H:i:s"),'update_loginpemakai_id'=>$model->create_loginpemakai_id));
					$transaction->commit();
					$data['sukses'] = 1;
					$data['pesan'] = 'Data rujukan ke luar berhasil disimpan!';
				}else{
					$transaction->rollback();
					$data['sukses'] = 0;
					$data['pesan'] = 'Data rujukan ke luar gagal disimpan! <br>'.CHtml::errorSummary($model);
				}
			}catch (Exception $exc) {
				$transaction->rollback();
				$data['sukses'] = 0;
				$data['pesan'] = 'Data rujukan ke luar gagal disimpan!'.MyExceptionMessage::getMessage($exc,true);
			}

		}
		$encode = CJSON::encode($data);
		echo "jsonCallback(".$encode.")";
		Yii::app()->end();
	}
	
	/**
	 * action untuk mendapatkan item rujukan ke luar
	 * 
	 * @return array data rujukan keluar 
	 */	
	public function actionGetItemRujukanKeluar() {
		header("content-type:application/json");
		$data = array();
		$data['pesan'] = "Data tidak ditemukan!";
		$data['is_found'] = 0;
		$data['data'] = '';		
		$sql = "SELECT * 
				FROM rujukankeluar_m
				WHERE rujukankeluar_aktif = TRUE
				ORDER BY rumahsakitrujukan ASC";
		$loadData = Yii::app()->db->createCommand($sql)->queryAll();	
		if(sizeof($loadData) > 0){
			$data['data'] = $loadData;
			$data['pesan'] = "Data ditemukan!";
			$data['is_found'] = 1;
		}
		
		$encode = CJSON::encode($data);
		echo "jsonCallback(".$encode.")";
		Yii::app()->end();
	}
	
	/**
	 * action untuk mendapatkan riwayat rujukan keluar
	 * @param pendaftaran_id
	 * @return array riwayat rujukan keluar
	 */	
	public function actionGetRiwayatRujukanKeluar() {
		header("content-type:application/json");
		$data['is_found'] = 0;
        $data['pesan'] = "Data tidak ditemukan!";
        $data['data'] = '';
		$data['header'] = '';
		if (isset($_GET['pendaftaran_id'])) {
			$pendaftaran_id = $_GET['pendaftaran_id'];
			$sql = "SELECT * FROM pasiendirujukkeluar_t prk JOIN rujukankeluar_m rk ON prk.rujukankeluar_id=rk.rujukankeluar_id "
					. " WHERE prk.pendaftaran_id=".$pendaftaran_id;
			$loadData = Yii::app()->db->createCommand($sql)->queryAll();			
			if (sizeof($loadData)>0) {
				$data['data']=$loadData;
				$data['is_found'] = 1;
				$data['pesan'] = "Data ditemukan!"; 
			}
		}
		
		$encode = CJSON::encode($data);
		echo "jsonCallback(".$encode.")";
		Yii::app()->end();
	}
	
	/**
	 * action untuk menghapus data item referensi keluar
	 * @param pasienkirimkeunitlain_id
	 * @return status 1/0 deleted or not
	 */	
	public function actionDeleteItemRefKeluar() {
		header("content-type:application/json");
		$data['is_found'] = 0;
        $data['pesan'] = "Data tidak berhasil dihapus!";
        $data['sukses'] = 0;
		
		if (isset($_GET['pasiendirujukkeluar_id'])) {
			if (Yii::app()->db->createCommand()->delete('pasiendirujukkeluar_t', 'pasiendirujukkeluar_id=:id', array(':id'=>$_GET['pasiendirujukkeluar_id']))) {
				$data['sukses'] = 1;
				$data['pesan'] = 'Data berhasil dihapus!';
			}
		}
		
		$encode = CJSON::encode($data);
		echo "jsonCallback(".$encode.")";
		Yii::app()->end();
	}
	
	/**
	 * action untuk mendapatkan riwayat reseptur
	 * @param pendaftaran_id
	 * @return array riwayat reseptur
	 */	
	public function actionGetRiwReseptur() {
		header("content-type:application/json");
		$data['is_found'] = 0;
        $data['pesan'] = "Data tidak ditemukan!";
        $data['data'] = '';
		$data['header'] = '';
		if (isset($_GET['pendaftaran_id'])) {
			$pendaftaran_id = $_GET['pendaftaran_id'];
			$sql = "SELECT * FROM reseptur_t r WHERE r.pendaftaran_id=".$pendaftaran_id;
			$loadData = Yii::app()->db->createCommand($sql)->queryAll();			
			if (sizeof($loadData)>0) {
				$i=0;
				foreach ($loadData as $datum) {
					$data['data'][$i]['tglreseptur'] = $datum['tglreseptur'];
					$data['data'][$i]['noresep'] = $datum['noresep'];
					$data['data'][$i]['reseptur_id'] = $datum['reseptur_id'];
					$resepID = $datum['reseptur_id'];
					$sql = "SELECT * "
							. "FROM resepturdetail_t rd JOIN obatalkes_m oa ON rd.obatalkes_id=oa.obatalkes_id "
							. "JOIN racikan_m r ON rd.racikan_id=r.racikan_id "
							. "JOIN satuankecil_m sk ON sk.satuankecil_id = rd.satuankecil_id "
							. "JOIN sumberdana_m sd ON rd.sumberdana_id = sd.sumberdana_id "
							. "WHERE rd.reseptur_id=".$resepID;
					$loadData2 = Yii::app()->db->createCommand($sql)->queryAll();
					if (sizeof($loadData2)>0) {
						$data['data'][$i]['detail']=$loadData2;
						$data['is_found'] = 1;
						$data['pesan'] = "Data ditemukan!"; 
					}
					$i++;	
				}	
			}
		}
		$encode = CJSON::encode($data);
		echo "jsonCallback(".$encode.")";
		Yii::app()->end();
	}
	
	public function actionGetRiwayatReseptur() {		
		header("content-type:application/json");
		$data['is_found'] = 0;
        $data['pesan'] = "Data tidak ditemukan!";
        $data['data'] = '';
		$data['header'] = '';
		if (isset($_GET['pendaftaran_id'])) {
			$pendaftaran_id = $_GET['pendaftaran_id'];
			$sql = "SELECT * FROM reseptur_t r JOIN resepturdetail_t rd On r.reseptur_id=rd.reseptur_id "
					. "WHERE r.pendaftaran_id=".$pendaftaran_id;
			$loadData = Yii::app()->db->createCommand($sql)->queryAll();			
			if (sizeof($loadData)>0) {
				$data['data']=$loadData;
				$data['is_found'] = 1;
				$data['pesan'] = "Data ditemukan!"; 
			}
		}		
		$encode = CJSON::encode($data);
		echo "jsonCallback(".$encode.")";
		Yii::app()->end();
	}
	
	/**
	 * menampilkan data shift_m
	 * @param type $attribute
	 * @return type
	 */
	protected function getShift($attribute = "", $jam = ""){
		$jam = (!empty($jam) ? $jam : date("H:i"));
		$sql = "SELECT * 
			FROM shift_m
			WHERE '".$jam."' BETWEEN shift_jamawal AND shift_jamakhir";
		$loadData = Yii::app()->db->createCommand($sql)->queryRow();
		if(!empty($attribute)){
			return $loadData[$attribute];
		}else{
			return $loadData;
		}
	}
	
	/**
	 * action untuk menghapus data item konsultasi gizi
	 * @param pasienkirimkeunitlain_id
	 * @return status 1/0 deleted or not
	 */	
	public function actionDeleteReseptur() {
		header("content-type:application/json");
		$data['is_found'] = 0;
        $data['pesan'] = "Data tidak ditemukan!";
        $data['sukses'] = 0;
		
		if (isset($_GET['reseptur_id'])) {
			if (Yii::app()->db->createCommand()->delete('resepturdetail_t', 'reseptur_id=:id', array(':id'=>$_GET['reseptur_id']))) {
				if (Yii::app()->db->createCommand()->delete('reseptur_t', 'reseptur_id=:id', array(':id'=>$_GET['reseptur_id']))) {
					$data['sukses'] = 1;
					$data['pesan'] = 'Data berhasil dihapus!';
				}
			}
		}
		
		$encode = CJSON::encode($data);
		echo "jsonCallback(".$encode.")";
		Yii::app()->end();
	}
	
	/**
	 * action untuk mendapatkan ruangan farmasi
	 * 
	 * @return array ruangan id farmasi
	 */
	public function actionGetSigna() {
		header("content-type:application/json");
		$data = array();
		$data['is_found'] = 0;
        $data['pesan'] = "Data tidak ditemukan!";
		$sql = "SELECT lookup_name, lookup_value
			FROM lookup_m
			WHERE lookup_aktif = TRUE
				AND LOWER(lookup_type) = 'signa_oa'
			ORDER BY lookup_urutan ASC";
		$loadData = Yii::app()->db->createCommand($sql)->queryAll();
		if(sizeof($loadData) > 0){
			$data['is_found'] = 1;
			$data['pesan'] = "Data ditemukan!";
			$data['data'] = $loadData;
		}
		$encode = CJSON::encode($data);
		echo "jsonCallback(".$encode.")";
		Yii::app()->end();
	}
	/**
	 * action untuk mendapatkan ruangan farmasi
	 * 
	 * @return array ruangan id farmasi
	 */
	public function actionGetEtiket() {
		header("content-type:application/json");
		$data = array();
		$data['is_found'] = 0;
        $data['pesan'] = "Data tidak ditemukan!";
		$sql = "SELECT lookup_name, lookup_value
			FROM lookup_m
			WHERE lookup_aktif = TRUE
				AND LOWER(lookup_type) = 'etiket'
			ORDER BY lookup_urutan ASC";
		$loadData = Yii::app()->db->createCommand($sql)->queryAll();
		if(sizeof($loadData) > 0){
			$data['is_found'] = 1;
			$data['pesan'] = "Data ditemukan!";
			$data['data'] = $loadData;
		}
		$encode = CJSON::encode($data);
		echo "jsonCallback(".$encode.")";
		Yii::app()->end();
	}
	
	/**
	 * action untuk mendapatkan ruangan farmasi
	 * 
	 * @return array ruangan id farmasi
	 */
	public function actionGetRuanganFarmasi() {
		header("content-type:application/json");
		$data['is_found'] = 0;
        $data['pesan'] = "Data tidak ditemukan!";
       
		$sql = "SELECT ruangan_m.ruangan_id, ruangan_m.ruangan_nama
			FROM ruangan_m
			WHERE ruangan_m.instalasi_id = ".Params::INSTALASI_ID_FARMASI."
				AND ruangan_m.ruangan_aktif = TRUE
				AND ruangan_m.ruangan_id <> ".Params::RUANGAN_ID_GUDANG_FARMASI."
				ORDER BY ruangan_m.ruangan_nourut ASC, ruangan_m.ruangan_nama ASC";
		$loadData = Yii::app()->db->createCommand($sql)->queryAll();
		if(sizeof($loadData) > 0){
			$data['data'] = $loadData;
			$data['pesan'] = "Data ditemukan!";
			$data['is_found'] = 1;
		}		
		
		$encode = CJSON::encode($data);
		echo "jsonCallback(".$encode.")";
		Yii::app()->end();
	}
	
	/**
	 * action untuk mendapatkan etiket
	 * @return: array of obat etiket
	 */
	public function actionGetObatAlkes(){
		header("content-type:application/json");
		$data = array();
		$data['is_found'] = 0;
        $data['pesan'] = "Data tidak ditemukan!";
		
		$req = (isset($_GET['q']) ? str_replace('"','',str_replace("'","",strtolower(trim($_GET['q'])))) : "");
		$sql = "SELECT obatalkes_m.obatalkes_id, obatalkes_m.obatalkes_barcode, obatalkes_m.obatalkes_kode, obatalkes_m.obatalkes_nama, obatalkes_m.obatalkes_namalain, obatalkes_m.obatalkes_golongan, obatalkes_m.obatalkes_kategori, obatalkes_m.obatalkes_kadarobat, obatalkes_m.harganetto, obatalkes_m.hargajual,
				sumberdana_m.sumberdana_id, sumberdana_m.sumberdana_nama,
				satuankecil_m.satuankecil_id, satuankecil_m.satuankecil_nama,
				generik_m.generik_id, generik_m.generik_nama
				FROM obatalkes_m
				JOIN sumberdana_m ON sumberdana_m.sumberdana_id = obatalkes_m.sumberdana_id
				JOIN satuankecil_m ON satuankecil_m.satuankecil_id = obatalkes_m.satuankecil_id
				LEFT JOIN generik_m ON generik_m.generik_id = obatalkes_m.generik_id
				WHERE obatalkes_m.obatalkes_aktif = TRUE
				AND obatalkes_m.obatalkes_farmasi = TRUE
				AND (
					LOWER(obatalkes_m.obatalkes_barcode) = '".$req."'
					OR LOWER(obatalkes_m.obatalkes_kode) like '%".$req."%'
					OR LOWER(obatalkes_m.obatalkes_nama) like '%".$req."%'
					OR LOWER(obatalkes_m.obatalkes_namalain) like '%".$req."%'
					OR LOWER(obatalkes_m.obatalkes_golongan) like '%".$req."%'
					OR LOWER(obatalkes_m.obatalkes_kategori) like '%".$req."%'
					OR LOWER(obatalkes_m.obatalkes_kadarobat) like '%".$req."%'
					OR LOWER(sumberdana_m.sumberdana_nama) like '%".$req."%'
					OR LOWER(satuankecil_m.satuankecil_nama) like '%".$req."%'
					OR LOWER(generik_m.generik_nama) like '%".$req."%'
				)
				LIMIT 8";
		$loadData = Yii::app()->db->createCommand($sql)->queryAll();
		if(sizeof($loadData) > 0){
			$data['is_found'] = 1;
			$data['pesan'] = "Data ditemukan!";
			$data['data'] = $loadData;
		}
		$encode = CJSON::encode($data);
		echo "jsonCallback(".$encode.")";
		Yii::app()->end();
	}
	
	/**
	 * action submit reseptur
	 * MA-265
	 * @param serialize dari array reseptur
	 * @param serialize dari array detail reseptur
	 * @return json
	 */
	public function actionSubmitReseptur(){
		header("content-type:application/json");
		$data = array();
		$data['sukses'] = 0;
		$data['pesan'] = 'Error 404 : Request tidak valid. Cek parameter';
		$errorDetail = "";
		if(isset($_GET['reseptur']) && isset($_GET['resepturdetail'])){
			$transaction = Yii::app()->db->beginTransaction();
			try{
				$format = new MyFormatter;
				$model = new MOResepturT;
				$model->attributes = $_GET['reseptur'];				
				$model->tglreseptur = (!empty($_GET['reseptur']['tglreseptur']) ? $format->formatDateTimeForDb($_GET['reseptur']['tglreseptur']) : date("Y-m-d H:i:s"));
				$model->create_time = date("Y-m-d H:i:s");
				$model->noresep = MyGenerator::noResepReseptur();	
				if($model->save()){
					if(count($_GET['resepturdetail']) > 0){
						foreach($_GET['resepturdetail'] AS $i => $detail){
							$modDetail = new MOResepturdetailT();
							$modDetail->attributes = $detail;
							$modDetail->reseptur_id = $model->reseptur_id;
							$modDetail->hargajual_reseptur = $modDetail->qty_reseptur * $modDetail->hargasatuan_reseptur;
							if($modDetail->save()){

							}else{
								$errorDetail .= CHtml::errorSummary($modDetail);
							}
						}
					}
					if(empty($errorDetail)){
						$transaction->commit();
						$data['sukses'] = 1;
						$data['pesan'] = 'Data resep berhasil disimpan!';
					}else{
						$transaction->rollback();
						$data['sukses'] = 0;
						$data['pesan'] = 'Data detail resep gagal disimpan!<br>'.$errorDetail;
					}
				}else{
					$transaction->rollback();
					$data['sukses'] = 0;
					$data['pesan'] = 'Data resep gagal disimpan!<br>'.CHtml::errorSummary($model)."<br><pre>".$errorDetail."</pre>";
				}
			}catch (Exception $exc) {
				$transaction->rollback();
				$data['sukses'] = 0;
				$data['pesan'] = 'Data resep gagal disimpan!'.MyExceptionMessage::getMessage($exc,true);
			}

		}
		$encode = CJSON::encode($data);
		echo "jsonCallback(".$encode.")";
		Yii::app()->end();
	}
	
	public function actionSubmitPenggunaanBahan() {
		header("content-type:application/json");
		$data = array();
		$data['sukses'] = 0;
		$data['pesan'] = 'Error 404 : Request tidak valid. Cek parameter';
		$errorDetail = "";
		if(isset($_GET['bahan'])){
			$transaction = Yii::app()->db->beginTransaction();
			try{
				$format = new MyFormatter;
				$model = new MOObatalkespasienT;
				$model->attributes = $_GET['bahan'];
				$model->tglpelayanan = date("Y-m-d H:i:s");
				$model->tipepaket_id = Params::TIPEPAKET_ID_NONPAKET;				
				$model->pasienmasukpenunjang_id = null;
				$model->shift_id = $this->getShift("shift_id");				
				$model->tglpelayanan = date ('Y-m-d H:i:s');
				$model->create_time = date ('Y-m-d H:i:s');
				if($model->save()){
					if(empty($errorDetail)){
						$transaction->commit();
						$data['sukses'] = 1;
						$data['pesan'] = 'Data resep berhasil disimpan!';
					}else{
						$transaction->rollback();
						$data['sukses'] = 0;
						$data['pesan'] = 'Data detail resep gagal disimpan!<br>'.$errorDetail;
					}
				}else{
					$transaction->rollback();
					$data['sukses'] = 0;
					$data['pesan'] = 'Data resep gagal disimpan!<br>'.CHtml::errorSummary($model)."<br><pre>".$errorDetail."</pre>";
				}
			}catch (Exception $exc) {
				$transaction->rollback();
				$data['sukses'] = 0;
				$data['pesan'] = 'Data resep gagal disimpan!'.MyExceptionMessage::getMessage($exc,true);
			}

		}
		$encode = CJSON::encode($data);
		echo "jsonCallback(".$encode.")";
		Yii::app()->end();
	}
	
	public function actionGetRiwayatPemakaianBahan() {		
		header("content-type:application/json");
		$data['is_found'] = 0;
        $data['pesan'] = "Data tidak ditemukan!";
        $data['data'] = '';
		$data['header'] = '';
		if (isset($_GET['pendaftaran_id'])) {
			$pendaftaran_id = $_GET['pendaftaran_id'];
			$sql = "SELECT * FROM obatalkespasien_t op JOIN obatalkes_m oa ON op.obatalkes_id=oa.obatalkes_id "
					. "WHERE op.pendaftaran_id=".$pendaftaran_id;
			$loadData = Yii::app()->db->createCommand($sql)->queryAll();			
			if (sizeof($loadData)>0) {
				$data['data']=$loadData;
				$data['is_found'] = 1;
				$data['pesan'] = "Data ditemukan!"; 
			}
		}		
		$encode = CJSON::encode($data);
		echo "jsonCallback(".$encode.")";
		Yii::app()->end();
	}
	
	/**
	 * action dashboard untuk mendapatkan total registrasi
	 * total registrasi dihitung berdasarkan hari kemarin dan hari sekarang serta
	 * ditampilkan apakah mengalami penurunan atau kenaikan jumlah register
	 * 
	 * @param pegawai_id
	 * @return array data total register dan kenaikannya
	 */
	public function actionGetTotalReg() {		
		header("content-type:application/json");
		$data['is_found'] = 0;
        $data['pesan'] = "Data tidak ditemukan!";
		if (isset($_GET['pegawai_id'])) {
			
			//------------------- total register/pasien per hari -----------------------------
			$pegawai_id = $_GET['pegawai_id'];
			$sql = "SELECT COUNT(*) as totCurrDate FROM pendaftaran_t 
					WHERE pegawai_id=".$_GET['pegawai_id'].
					" AND tgl_pendaftaran::timestamp::date = NOW()::timestamp::date";
			$loadData = Yii::app()->db->createCommand($sql)->queryRow();			
			if (sizeof($loadData)>0) {
				$data['totalreg']['totCurrDate']=$loadData['totcurrdate'];
				$sql = "SELECT COUNT(*) as totYestDate FROM pendaftaran_t 
						WHERE pegawai_id=".$_GET['pegawai_id'].
						" AND tgl_pendaftaran::timestamp::date = (SELECT DATE 'yesterday')";
				$loadData2 = Yii::app()->db->createCommand($sql)->queryRow();
				if (sizeof($loadData2>0)) {
					$data['totalreg']['totYestDate']=$loadData2['totyestdate'];
					if ($data['totalreg']['totYestDate']!=0) {
						$data['totalreg']['increase']= (($data['totalreg']['totCurrDate'] - $data['totalreg']['totYestDate']) / $data['totalreg']['totYestDate'])*100;
					}else {
						if ($data['totalreg']['totCurrDate']==0) {
							$data['totalreg']['increase']= 0;
						}else {
							$data['totalreg']['increase']= 100;
						}
						
					}					
					$data['is_found'] = 1;
					$data['pesan'] = "Data ditemukan!";					
				}
			}
			//------------------- end of total register/pasien per hari -----------------------------
			
			//------------------- dashboard get register per tahun      -----------------------------
			$currDay = date('d');
			$currMonth = date('m');
			$currYear = date('Y');
			$arrMonth = array();
			if ($currMonth<=6) {
				for ($i=1;$i<=6;$i++) {
					$arrMonth[$i] = $i;
				}
			}else {
				for ($i=7;$i<=12;$i++) {
					$arrMonth[$i] = $i;
				}
			}
			$currYearMonth = $currYear."-".$currMonth."-";
			$i = 0;
			foreach ($arrMonth as $datum) {
				$currDate = $currYearMonth.$datum;
				$sql = "SELECT COUNT(*) as totCurrDate FROM pendaftaran_t "
						. "WHERE pegawai_id=$pegawai_id AND EXTRACT(YEAR FROM tgl_pendaftaran)=EXTRACT(YEAR FROM NOW()) "
						. "AND EXTRACT(MONTH FROM tgl_pendaftaran)=".$datum;
				$loadData = Yii::app()->db->createCommand($sql)->queryRow();			
				if (sizeof($loadData)>0) {					
					$data['regtahun'][$i]['bulan']=$datum;
					$data['regtahun'][$i]['count']=$loadData['totcurrdate'];
				}
				$i++;
			}
			//------------------- end of dashboard get register per tahun  -----------------------------
			
			//-------------------- dashboard jenis kelamin per tahun
			$sql = "SELECT COUNT(*) as totCurrLTahun FROM pendaftaran_t JOIN pasien_m ON pendaftaran_t.pasien_id=pasien_m.pasien_id "
						. "WHERE pendaftaran_t.pegawai_id=$pegawai_id AND EXTRACT(YEAR FROM tgl_pendaftaran)=EXTRACT(YEAR FROM NOW()) "
						. "AND pasien_m.jeniskelamin='".Params::JENIS_KELAMIN_LAKI_LAKI."'";
			$loadData = Yii::app()->db->createCommand($sql)->queryRow();			
			if (sizeof($loadData)>0) {					
				$data['jeniskelamin']['tahun']['laki']=$loadData['totcurrltahun'];				
				$sql = "SELECT COUNT(*) as totCurrLTahun FROM pendaftaran_t JOIN pasien_m ON pendaftaran_t.pasien_id=pasien_m.pasien_id "
						. "WHERE pendaftaran_t.pegawai_id=$pegawai_id AND EXTRACT(YEAR FROM tgl_pendaftaran)=EXTRACT(YEAR FROM NOW()) "
						. "AND pasien_m.jeniskelamin='".Params::JENIS_KELAMIN_PEREMPUAN."'";
				$loadData = Yii::app()->db->createCommand($sql)->queryRow();
				if (sizeof($loadData)>0) {			
					$data['jeniskelamin']['tahun']['perempuan']=$loadData['totcurrltahun'];
				}
			}
			// ------------------ end of dashboard jenis kelamin per tahun
			
			//------------------- dashboard get register per bulan      -----------------------------
			$currDay = date('d');
			//$currMonth = date('m');
			//$currYear = date('Y');
			$arrDay = array();
			if ($currDay<=6) {
				for ($i=1;$i<=6;$i++) {
					$arrDay[$i] = $i;
				}
			}else {
				for ($i=($currDay-5);$i<=$currDay;$i++) {
					$arrDay[$i] = $i;
				}
			}
			$i = 0;
			foreach ($arrDay as $datum) {
				$sql = "SELECT COUNT(*) as totcurrdate FROM pendaftaran_t "
						. "WHERE pegawai_id=$pegawai_id AND EXTRACT(YEAR FROM tgl_pendaftaran)=EXTRACT(YEAR FROM NOW()) "
						. "AND EXTRACT(MONTH FROM tgl_pendaftaran)=EXTRACT(MONTH FROM NOW()) AND EXTRACT(DAY FROM tgl_pendaftaran)=".$datum;
				$sqlJasdokBulan = "SELECT SUM(tarif_kompsatuan) AS tottarifkomponen FROM pasienpelayanandokterrs_v "
						. "WHERE pegawai_id=$pegawai_id AND EXTRACT(YEAR FROM tgl_pendaftaran)=EXTRACT(YEAR FROM NOW()) "
						. "AND EXTRACT(MONTH FROM tgl_pendaftaran)=EXTRACT(MONTH FROM NOW()) AND EXTRACT(DAY FROM tgl_pendaftaran)=".$datum;
				$loadData = Yii::app()->db->createCommand($sql)->queryRow();	
				$loadDataJasDokBulan = Yii::app()->db->createCommand($sqlJasdokBulan)->queryRow();
				if (sizeof($loadData)>0) {					
					$data['regbulan'][$i]['tgl']='Tgl. '.$datum;
					$data['regbulan'][$i]['count']=$loadData['totcurrdate'];
				}
				if (sizeof($loadDataJasDokBulan)>0) {					
					$data['jasdokbulan'][$i]['tgl']='Tgl. '.$datum;
					$data['jasdokbulan'][$i]['sum']=($loadDataJasDokBulan['tottarifkomponen']==null?0:$loadDataJasDokBulan['tottarifkomponen']);
				}
				$i++;
			}
			//------------------- get register per bulan  -----------------------------
			
			//-------------------- dashboard jenis kelamin per bulan
			$sql = "SELECT COUNT(*) as totCurrLTahun FROM pendaftaran_t JOIN pasien_m ON pendaftaran_t.pasien_id=pasien_m.pasien_id "
						. "WHERE pendaftaran_t.pegawai_id=$pegawai_id AND EXTRACT(YEAR FROM tgl_pendaftaran)=EXTRACT(YEAR FROM NOW()) AND EXTRACT(MONTH FROM tgl_pendaftaran)=EXTRACT(MONTH FROM NOW())"
						. "AND pasien_m.jeniskelamin='".Params::JENIS_KELAMIN_LAKI_LAKI."'";
			$loadData = Yii::app()->db->createCommand($sql)->queryRow();			
			if (sizeof($loadData)>0) {					
				$data['jeniskelamin']['bulan']['laki']=$loadData['totcurrltahun'];
				
				$sql = "SELECT COUNT(*) as totCurrLTahun FROM pendaftaran_t JOIN pasien_m ON pendaftaran_t.pasien_id=pasien_m.pasien_id "
						. "WHERE pendaftaran_t.pegawai_id=$pegawai_id AND EXTRACT(YEAR FROM tgl_pendaftaran)=EXTRACT(YEAR FROM NOW()) AND EXTRACT(MONTH FROM tgl_pendaftaran)=EXTRACT(MONTH FROM NOW())"
						. "AND pasien_m.jeniskelamin='".Params::JENIS_KELAMIN_PEREMPUAN."'";
				$loadData = Yii::app()->db->createCommand($sql)->queryRow();
				if (sizeof($loadData)>0) {			
					$data['jeniskelamin']['bulan']['perempuan']=$loadData['totcurrltahun'];
				}
			}
			// ------------------ end of dashboard jenis kelamin per tahun
			
			//------------------- beginning total jasa dokter hari ini-------------------------------
			$totalJasDokHari = 0;
			$data['jasdok']['hari'] = $totalJasDokHari;
			$criteria = new CDbCriteria ();
			$criteria->addCondition('pegawai_id = '.$pegawai_id);
			$criteria->addCondition('tgl_pendaftaran::date = now()::date');
			$criteria->group = "pendaftaran_id, tgl_pendaftaran, pegawai_id, no_pendaftaran, no_rekam_medik, pasien_id, nama_pasien, jeniskelamin, alamat_pasien, penjamin_nama";
			$criteria->select = $criteria->group;
			$dataDetails = MOPasienpelayanandokterrsV::model()->findAll($criteria);
			
			$sql = "SELECT SUM(tarif_kompsatuan) as totcurrjasdokharidate FROM pasienpelayanandokterrs_v "
						. "WHERE pegawai_id=$pegawai_id AND tgl_pendaftaran::date = now()::date";
			
			
			if ($loadData = Yii::app()->db->createCommand($sql)->queryRow()) {
				$sql = "SELECT SUM(tarif_kompsatuan) as totyestjasdokharidate FROM pasienpelayanandokterrs_v "
						. "WHERE pegawai_id=$pegawai_id AND tgl_pendaftaran::date = (SELECT DATE 'yesterday')";
				if ($loadData['totcurrjasdokharidate']==null) {
					$currJasDok = 0;
				}else {
					$currJasDok = $loadData['totcurrjasdokharidate'];
				}
				$loadData2 = Yii::app()->db->createCommand($sql)->queryRow();
				$yestJasDok  = ($loadData2['totyestjasdokharidate']==null?0:$loadData2['totyestjasdokharidate']);
				$data['jasdok']['kemarin']=$yestJasDok;
				if ($yestJasDok!=0) {
					$data['jasdok']['increase'] = (($currJasDok - $yestJasDok) / $yestJasDok)*100;
				}else  {
					if ($currJasDok==0) {
						$data['jasdok']['increase']= 0;
					}else {
						$data['jasdok']['increase']= 100;
					}
					
				}	
				$data['jasdok']['hari']= $currJasDok;
			}
			//$data['jasdok']['hari']  = ($loadData['totcurrjasdokharidate']==null?0:$loadData['totcurrjasdokharidate']);
			
			//------------------ end of total jasa dokter hari ini ----------------------------------
		}
		
		$encode = CJSON::encode($data);
		echo "jsonCallback(".$encode.")";
		Yii::app()->end();
	}
	
	
	/**
	 * action dashboard untuk mendapatkan jumlah register  per tahun
	 * 
	 * @param pegawai_id
	 * @return array data register per tahun
	 */
	public function actionGetRegistrasiTahun() {		
		header("content-type:application/json");
		$data['is_found'] = 0;
        $data['pesan'] = "Data tidak ditemukan!";		
		if (isset($_GET['pegawai_id'])) {			
			$pegawai_id = $_GET['pegawai_id'];			
			$currDay = date('d');
			$currMonth = date('m');
			$currYear = date('Y');
			$arrMonth = array();
			if ($currMonth<=6) {
				for ($i=1;$i<=6;$i++) {
					$arrMonth[$i] = $i;
				}
			}else {
				for ($i=7;$i<=12;$i++) {
					$arrMonth[$i] = $i;
				}
			}
			$currYearMonth = $currYear."-".$currMonth."-";
			$i = 0;
			foreach ($arrMonth as $datum) {
				$currDate = $currYearMonth.$datum;
				$sql = "SELECT COUNT(*) as totCurrDate FROM pendaftaran_t "
						. "WHERE pegawai_id=19 AND EXTRACT(YEAR FROM tgl_pendaftaran)=EXTRACT(YEAR FROM NOW()) "
						. "AND EXTRACT(MONTH FROM tgl_pendaftaran)=".$datum;
				$loadData = Yii::app()->db->createCommand($sql)->queryRow();			
				if (sizeof($loadData)>0) {
					
					$data['data'][$i]['bulan']=$datum;
					$data['data'][$i]['count']=$loadData['totcurrdate'];
				}
				$i++;
			}
		}		
		$encode = CJSON::encode($data);
		echo "jsonCallback(".$encode.")";
		Yii::app()->end();
	}
	
	public function actionBatalPemeriksaan() {
		header("content-type:application/json");
		$data['is_sukses'] = 0;
      
		if (isset($_GET['pendaftaran_id'])&&isset($_GET['pasien_id'])&&isset($_GET['ruangan_id'])) {
			$pendaftaranID = $_GET['pendaftaran_id'];
			$pasienID = $_GET['pasien_id'];
			$ruanganID = $_GET['ruangan_id'];
			
			$model = new MOPasienbatalperiksaR();
			$model->pendaftaran_id = $pendaftaranID;
			$model->pasien_id = $pasienID;			
			$model->tglbatal = date('Y-m-d');
			$model->create_time = date('Y-m-d');
			$model->create_loginpemakai_id =  Params::LOGINPEMAKAI_ID_ADMIN;
			$model->keterangan_batal = "Batal Rawat Jalan";
			$model->create_ruangan = $ruanganID;
		
			$transaction = Yii::app()->db->beginTransaction();
			try {
				if ($model->save()) {
						//print_r($model);exit;
					$attributes = array(
						'pasienbatalperiksa_id' => $model->pasienbatalperiksa_id,
						'update_time' => date('Y-m-d H:i:s'),
						'update_loginpemakai_id' => Params::LOGINPEMAKAI_ID_ADMIN,
						'statusperiksa'=>Params::STATUSPERIKSA_BATAL_PERIKSA
					);
					$pendaftaran = MOPendaftaranT::model()->updateByPk($pendaftaranID, $attributes);
					$transaction->commit();		
					$data['is_sukses'] = 1;
					$data['pesan'] = "Data berhasil dibatalkan!";
				}else{					
					$pesan = "Pemeriksaan gagal dibatalkan! ".CHtml::errorSummary($model);
					 $data['pesan'] = $pesan;
					$transaction->rollback();
				}
			} catch (Exception $ex) {
				$status = false;
				$pesan = "exist";
				$transaction->rollback();
			}
		}
		$encode = CJSON::encode($data);
		echo "jsonCallback(".$encode.")";
		Yii::app()->end();
	}
	/**
	 * action untuk tindak lanjut ke rawat inap
	 * 
	 * @param pendaftaran_id
	 * @param pasien_id
	 * @param ruangan_id
	 * @param loginpemakai_id
	 * 
	 * @return 1/0 pesan sukses
	 */
	public function actionTindakLanjutRI()
	{
		$format = new MyFormatter();
		$ruangan_id = $_GET['ruangan_id'];
		$pendaftaran_id = $_GET['pendaftaran_id'];
		$modPendaftaran = MOPendaftaranT::model()->with('jeniskasuspenyakit')->findByPk($pendaftaran_id);
		$modPasien = MOPasienM::model()->findByPk($modPendaftaran->pasien_id);
		$modRujukan=new MORujukanT;
		$modPasienAdmisi = new MOPasienAdmisiT;
		$status =0;
		
		if ($instalasi_id == Params::INSTALASI_ID_RD){
			$modPasienPulang = new RDPasienPulangT;
			$modPasienPulang->tglpasienpulang = date('d M Y H:i:s');
			$modPasienPulang->pendaftaran_id = $modPendaftaran->pendaftaran_id;
			$modPasienPulang->pasien_id = $modPasien->pasien_id;

			$date1 = $format->formatDateTimeForDb($modPendaftaran->tgl_pendaftaran);
			$date2 = date('Y-m-d H:i:s');
			$diff = abs(strtotime($date2) - strtotime($date1));
			$hours   = floor(($diff)/3600); 

			$modPasienPulang->lamarawat = $hours;
		}else{
			$modPasienPulang = array();
		}
		if (isset($_POST['RJPendaftaranT'])){
			$transaction = Yii::app()->db->beginTransaction();
			try {
				if (isset($_POST['RDPasienPulangT'])){ // Proses khusus dari rawat darurat
					$modPasienPulang = $this->savePasienPulang($modPasienPulang,$_POST['RDPasienPulangT']);
					$this->rujukrisukses = true;
				}else{
					$this->pasienpulangtersimpan = true;
					$modRujuk = $this->pulangRujukRI();
				}
				if ($this->rujukrisukses == true){						
					if(isset($_POST['RJPasienM'])){
						$modPasien = $this->simpanPasien($modPasien, $_POST['RJPasienM']);
					}else{
						$this->pasientersimpan = true;
					}
					if($_POST['RJPendaftaranT']['is_bpjs']){
						if(isset($_POST['RJRujukanbpjsT'])){
							$modRujukanBpjs = $this->simpanRujukanBpjs($modRujukanBpjs, $_POST['RJRujukanbpjsT']);
						} else {
							$this->rujukantersimpan = true; 
						}
					}else{
						$this->rujukantersimpan = true; 
					}
					if(isset($_POST['RJAsuransipasienM'])){
						if(isset($_POST['RJAsuransipasienM']['asuransipasien_id'])){
							if(!empty($_POST['RJAsuransipasienM']['asuransipasien_id'])){
								$modAsuransiPasien = RJAsuransipasienM::model()->findByPk($_POST['RJAsuransipasienM']['asuransipasien_id']);
							}
						}
						$modAsuransiPasien = $this->simpanAsuransiPasien($modAsuransiPasien, $_POST['RJPendaftaranT'], $modPasien, $_POST['RJAsuransipasienM']);
					}else{
						$this->asuransipasientersimpan = true;
					}

					if(isset($_POST['RJAsuransipasienbpjsM'])){
						if(isset($_POST['RJAsuransipasienbpjsM']['asuransipasien_id'])){
							if(!empty($_POST['RJAsuransipasienbpjsM']['asuransipasien_id'])){
								$modAsuransiPasienBpjs = RJAsuransipasienM::model()->findByPk($_POST['PPAsuransipasienbpjsM']['asuransipasien_id']);
							}
						}
						$modAsuransiPasienBpjs = $this->simpanAsuransiPasien($modAsuransiPasienBpjs, $_POST['PPPendaftaranT'], $modPasien, $_POST['PPAsuransipasienbpjsM']);
					}else{
						$this->asuransipasientersimpan = true;
					}

					
					$modPasienAdmisi = $this->simpanPasienAdmisi($modPendaftaran,$modPasien,$modPasienAdmisi,$_POST['RJPasienAdmisiT']);
					$modPasienAdmisi->masukkamar = isset($_POST['RJPasienAdmisiT']['masukkamar']) ? $_POST['RJPasienAdmisiT']['masukkamar'] : false;
					if($modPasienAdmisi->masukkamar){ // Jika centang langsung masuk kamar
						$this->simpanMasukKamar($modPendaftaran, $modPasien, $modPasienAdmisi);
					}else{
						$this->masukkamartersimpan = true; //bypass masuk kamar
					}
					if($this->pasienpulangtersimpan && $this->pasientersimpan && $this->rujukantersimpan && $this->admisitersimpan && $this->masukkamartersimpan){
						$transaction->commit();

					}else{
						$transaction->rollback();

					}
				} else {
					$transaction->rollback();

				}

			} catch (Exception $ex) {
				$transaction->rollback();
				 Yii::app()->user->setFlash('error', '<strong>Gagal</strong> Data Gagal disimpan'.MyExceptionMessage::getMessage($ex));
			}
		}
	}
	
	/**
	 * action untuk rencana kontrol
	 * 
	 * @param pendaftaran_id
	 * @param tglrencanakontrol
	 * 
	 * @return 1/0 pesan sukses
	 */
	public function actionRencanaKontrol(){
		header("content-type:application/json");
		$data = array();
		$data['sukses'] = 0;
		$data['pesan'] = 'Error 404 : Request tidak valid. Cek parameter';
		if(isset($_GET['pendaftaran_id']) && isset($_GET['tglrencanakontrol'])){
			$transaction = Yii::app()->db->beginTransaction();
			try{
				$format = new MyFormatter;
				$updatePendaftaran = MOPendaftaranT::model()->updateByPk($_GET['pendaftaran_id'],array('tglrencanakontrol'=>$format->formatDateTimeForDb($_GET['tglrencanakontrol']),'update_time'=>date("Y-m-d H:i:s")));
				if($updatePendaftaran){
					$transaction->commit();
					$data['sukses'] = 1;
					$data['pesan'] = 'Data rencana kontrol berhasil disimpan!';
				}else{
					$transaction->rollback();
					$data['sukses'] = 0;
					$data['pesan'] = 'Data rencana kontrol gagal disimpan!<br>'.CHtml::errorSummary($updatePendaftaran);
				}
			}catch (Exception $exc) {
				$transaction->rollback();
				$data['sukses'] = 0;
				$data['pesan'] = 'Data rencana kontrol gagal disimpan!'.MyExceptionMessage::getMessage($exc,true);
			}

		}
		$encode = CJSON::encode($data);
		echo "jsonCallback(".$encode.")";
		Yii::app()->end();
	}
	
	/**
	 * action untuk mendapatkan pasien lama
	 * 
	 * @param medical record dari pasien, eg 635968
	 * @return array dari data pasien
	 */
	public function actionGetPasienByRekamMedik() {		
		header("content-type:application/json");
        $format = new MyFormatter();
        $data = array();
        $data['is_found'] = 0;
        $data['pesan'] = "Data not found!";
        $data['data'] = '';
        if (isset($_GET['no_rekam_medik'])) {            
            $medRec = strtolower($_GET['no_rekam_medik']);
						
			$sql = "SELECT * from pasien_m WHERE no_rekam_medik = '$medRec'";
            $loadData = Yii::app()->db->createCommand($sql)->queryAll();
            $data['data'] = $loadData;
            $n = sizeof($loadData);
            if ($n>0) {
                $data['is_found'] = 1;
                $data['pesan'] = "Data ditemukan!";    
            }
        }
        $encode = CJSON::encode($data);
        echo "jsonCallback(".$encode.")";
        Yii::app()->end();
	}
	
	/**
	 * action panggil pasien
	 * 
	 * @param instalasi_id
	 * @param pendaftaran_id
	 * 
	 * @return 1/0 sukses
	 */
	public function actionPanggilPasien(){
		header("content-type:application/json");
		$data = array();
		$data['sukses'] = 0;
		$data['pesan'] = 'Error 404 : Request tidak valid. Cek parameter';
		if(isset($_GET['pendaftaran_id']) && isset($_GET['instalasi_id'])){
			$transaction = Yii::app()->db->beginTransaction();
			try{
				$format = new MyFormatter;
				$updatePendaftaran = MOPendaftaranT::model()->updateByPk($_GET['pendaftaran_id'],array('update_time'=>date("Y-m-d H:i:s"),'update_loginpemakai_id'=>Params::LOGINPEMAKAI_ID_ADMIN));
				if($updatePendaftaran){
					//$transaction->commit();
					//echo $updatePendaftaran->ruangan->ruangan_nama;
					//$data_telnet = $updatePendaftaran->ruangan->ruangan_nama.", ".$updatePendaftaran->ruangan->ruangan_singkatan."-".$updatePendaftaran->no_urutantri;
					//self::postTelnet($data_telnet);
					$data['sukses'] = 1;
					$data['pesan'] = 'Data rencana kontrol berhasil disimpan!';
				}else{
					$transaction->rollback();
					$data['sukses'] = 0;
					$data['pesan'] = 'Data rencana kontrol gagal disimpan!<br>'.CHtml::errorSummary($updatePendaftaran);
				}
			}catch (Exception $exc) {
				$transaction->rollback();
				$data['sukses'] = 0;
				$data['pesan'] = 'Data rencana kontrol gagal disimpan!'.MyExceptionMessage::getMessage($exc,true);
			}

		}
		$encode = CJSON::encode($data);
		echo "jsonCallback(".$encode.")";
		Yii::app()->end();
		
		
		header("content-type:application/json");
		$data = array();
		$data['sukses'] = 0;
		$data['pesan'] = 'Error 404 : Request tidak valid. Cek parameter';
		if(isset($_GET['instalasi_id']) && isset($_GET['pendaftaran_id'])){
//			$sql = "UPDATE pendaftaran_t SET panggilantrian=TRUE, update_time='".date("Y-m-d H:i:s")."', "
//					. "update_loginpemakai_id=".Params::LOGINPEMAKAI_ID_ADMIN." WHERE pendaftaran_id=".$_GET['pendaftaran_id'];
//			if (Yii::app()->db->createCommand($sql)->queryRow()) {
//				$data['sukses'] = 1;
//				$data['pesan'] = 'Pemanggilan pasien berhasil dilakukan!';
//			}else {
//				$data['sukses'] = 0;
//				$data['pesan'] = 'Pemanggilan pasien gagal dilakukan!';
//			}		
			
			$transaction = Yii::app()->db->beginTransaction();
			try {
				$modPendaftaran =  MOPendaftaranT::model()->findByPk($_GET['pendaftaran_id']);
				$modPendaftaran->panggilantrian = TRUE;
				$modPendaftaran->update_time = date("Y-m-d H:i:s");
				$modPendaftaran->update_loginpemakai_id = Params::LOGINPEMAKAI_ID_ADMIN;
				
				if ($modPendaftaran->save()) {
					$data['sukses'] = 1;
					$data['pesan'] = 'Pemanggilan pasien berhasil dilakukan!';
				}else {
					$data['sukses'] = 0;
					$data['pesan'] = 'Pemanggilan pasien gagal dilakukan!';
				}
			} catch (Exception $exc) {
				$transaction->rollback();
				$data['sukses'] = 0;
				$data['pesan'] = 'Pemanggilan pasien gagal dilakukan!'.MyExceptionMessage::getMessage($exc,true);
			}
		}
		$encode = CJSON::encode($data);
		echo "jsonCallback(".$encode.")";
		Yii::app()->end();
	}
	
	public function actionPanggilPasienPoliklinik($pendaftaran_id){
		header("content-type:application/json");
		$data = array();
		$data['sukses'] = 0;
		$data['pesan'] = 'Error 404 : Request tidak valid. Cek parameter';
		$transaction = Yii::app()->db->beginTransaction();
		try{
			
			if (MOPendaftaranT::model()->updateByPk($pendaftaran_id,array('panggilantrian'=>TRUE,'update_time'=>date("Y-m-d H:i:s"),'update_loginpemakai_id'=>Params::LOGINPEMAKAI_ID_ADMIN))) {
				$transaction->commit();
				$data['sukses'] = 1;
				$data['pesan'] = 'Pemanggilan pasien berhasil dilakukan!';
			}
			
			

//			if ($updatePendaftaran->save()){
//				$transaction->commit();
//				
//			}
//			$updatePendaftaran->panggilantrian = TRUE;
//			$updatePendaftaran->update_time = date("Y-m-d H:i:s");
//			if($updatePendaftaran->save()){
//				$transaction->commit();
//				$data['sukses'] = 1;
//				$data['pesan'] = 'Pemanggilan pasien berhasil dilakukan!';
//				$data_telnet = $updatePendaftaran->ruangan->ruangan_nama.", ".$updatePendaftaran->ruangan->ruangan_singkatan."-".$updatePendaftaran->no_urutantri;
//				self::postTelnet($data_telnet);
//			}else{
//				$transaction->rollback();
//				$data['sukses'] = 0;
//				$data['pesan'] = 'Pemanggilan pasien gagal dilakukan!<br>'.CHtml::errorSummary($updatePendaftaran);
//			}
		}catch (Exception $exc) {
			$transaction->rollback();
			$data['sukses'] = 0;
			$data['pesan'] = 'Pemanggilan pasien gagal dilakukan!'.MyExceptionMessage::getMessage($exc,true);
		}
		return $data;
	}
	
	/**
	 * kirim data ke telnet (untuk dimasukkan ke led matrix)
	 * MIC-91
	 */
	public static function postTelnet($data){
		if(Yii::app()->user->getState('is_telnetaktif')){
			$address = Yii::app()->user->getState('telnet_host');
			$port = Yii::app()->user->getState('telnet_port');
			$socket = socket_create(AF_INET, SOCK_STREAM, 0) OR FALSE;
			socket_set_option($socket, SOL_SOCKET, SO_RCVTIMEO, array('sec' => 3, 'usec' => 0));
			if($socket){
				if(socket_connect($socket, $address, $port)){
					socket_write($socket, $data);
					socket_close();
				}
			}
		}
	}
	
	/**
	 * action untuk menghapus pemakaian bahan
	 * 
	 * @param obatalkespasien_id
	 */
	public function actionDeletePemakaianBahan() {
		header("content-type:application/json");
		$data['is_found'] = 0;
        $data['pesan'] = "Data gagal dihapus!";
		if (isset($_GET['obatalkespasien_id'])) {
			if (Yii::app()->db->createCommand()->delete('obatalkespasien_t', 'obatalkespasien_id=:id', array(':id'=>$_GET['obatalkespasien_id']))) {
				$data['sukses'] = 1;
				$data['pesan'] = 'Data berhasil dihapus!';
			}
		}		
		$encode = CJSON::encode($data);
		echo "jsonCallback(".$encode.")";
		Yii::app()->end();
	}
	
	/**
	 * action untuk mendapatkan daftar info jasa dokter
	 * 
	 * @param pegawai_id
	 * @param startDate, tanggal awal filter info jasas dokter
	 * @param endDate, tanggal akhir filter info jasa dokter
	 * @param q, keyword untuk nama pasien, no pendaftaran, no rekam medik
	 * @return array dari info jasa dokter
	 */
	public function actionGetInfoJasaDokter() {
		header("content-type:application/json");
		$data['is_found'] = 0;
        $data['pesan'] = "Data not found!";
        $data['data'] = '';
		
		if (isset($_GET['sta_date'])&&isset($_GET['end_date'])&&isset($_GET['pegawai_id'])&&isset($_GET['q'])) {
			$tgl_awal = $_GET['sta_date'];
			$tgl_akhir = $_GET['end_date'];
			$pegawai_id = $_GET['pegawai_id'];
			$q = $_GET['q'];		
			
			$criteria = new CDbCriteria ();
			if ($tgl_awal!=''&&$tgl_akhir!='') {
				$criteria->addBetweenCondition('tgl_pendaftaran', $tgl_awal, $tgl_akhir);
			}
			
			$criteria->addCondition('pegawai_id = '.$pegawai_id);
			$criteria->addCondition('LOWER(nama_pasien) LIKE \'%'.strtolower($q).'%\' OR LOWER(no_rekam_medik) LIKE \'%'.strtolower($q).'%\' OR LOWER(no_rekam_medik) LIKE \'%'.strtolower($q).'%\'');
			$criteria->group = "pendaftaran_id, tgl_pendaftaran, pegawai_id, no_pendaftaran, no_rekam_medik, pasien_id, nama_pasien, jeniskelamin, alamat_pasien, penjamin_nama";
			$criteria->select = $criteria->group;
			$criteria->order = 'tgl_pendaftaran DESC';
			$criteria->limit = 4;
			
			$dataDetails = MOPasienpelayanandokterrsV::model()->findAll($criteria);
			$totalPeriod = 0;
			if (sizeof($dataDetails)>0) {
				$data['data'] = $dataDetails;
				foreach ($dataDetails as $datum) {
					$totalPeriod = $totalPeriod+($datum->tarif_kompsatuan==null?0:$datum->tarif_kompsatuan);
				}
				
				$data['is_found'] = 1;
				$data['pesan'] = "Data is found!";
				$data['total_period'] = $totalPeriod;
			}
		}
		$encode = CJSON::encode($data);
		echo "jsonCallback(".$encode.")";
		Yii::app()->end();
	}
	
	
	/**
	 * action untuk mendapatkan jenis pemeriksaan
	 * 
	 * @return jenis periksa pasien
	 */
	public function actionGetStatusPeriksaPasien() {
		header("content-type:application/json");
		$data['is_found'] = 0;
        $data['pesan'] = "Data not found!";
        $data['data'] = '';
		
		$sql = "SELECT * FROM lookup_m WHERE lookup_type='statusperiksa'";
		$loadData = Yii::app()->db->createCommand($sql)->queryAll();
		if (sizeof($loadData)>0) {
			$data['is_found'] = 1;
			$data['pesan'] = "Data is found!";
			$data['data'] = $loadData;
		}
		
		$encode = CJSON::encode($data);
		echo "jsonCallback(".$encode.")";
		Yii::app()->end();
	}
	
	/**
	 * action untuk mendapatkan kategori catatan dokter
	 * 
	 * @return kategori catatan dokter
	 */
	public function actionGetKatCatDokter() {
		header("content-type:application/json");
		$data['is_found'] = 0;
        $data['pesan'] = "Data not found!";
        $data['data'] = '';
		$kategoriNama = $_GET['q'];
		$sql = "SELECT * FROM mkategoricatatan_m WHERE mkategoricatatan_nama LIKE '%$kategoriNama%'";
		$loadData = Yii::app()->db->createCommand($sql)->queryAll();
		if (sizeof($loadData)>0) {
			$data['is_found'] = 1;
			$data['pesan'] = "Data is found!";
			$data['data'] = $loadData;
		}
		
		$encode = CJSON::encode($data);
		echo "jsonCallback(".$encode.")";
		Yii::app()->end();
	}
	
	
	public function actionSubmitCatatan() {
		header("content-type:application/json");
		$data = array();
		$data['sukses'] = 0;
		$data['pesan'] = 'Error 404 : Request tidak valid. Cek parameter';
		$errorDetail = "";
		if(isset($_GET['catatandokter'])){
			$transaction = Yii::app()->db->beginTransaction();
			try{
				$format = new MyFormatter;
				$model = new MCatatandokterT;
				$model->attributes = $_GET['catatandokter'];
				$model->create_time = date("Y-m-d H:i:s");
				if($model->save()){
					if(empty($errorDetail)){
						$transaction->commit();
						$data['sukses'] = 1;
						$data['pesan'] = 'Data catatan berhasil disimpan!';
					}else{
						$transaction->rollback();
						$data['sukses'] = 0;
						$data['pesan'] = 'Data catatan gagal disimpan!<br>'.$errorDetail;
					}
				}else{
					$transaction->rollback();
					$data['sukses'] = 0;
					$data['pesan'] = 'Data catatan disimpan!<br>'.CHtml::errorSummary($model)."<br><pre>".$errorDetail."</pre>";
				}
			}catch (Exception $exc) {
				$transaction->rollback();
				$data['sukses'] = 0;
				$data['pesan'] = 'Data catatan gagal disimpan!'.MyExceptionMessage::getMessage($exc,true);
			}

		}
		$encode = CJSON::encode($data);
		echo "jsonCallback(".$encode.")";
		Yii::app()->end();
	}
	public function actionEditCatatan() {
		header("content-type:application/json");
		$data = array();
		$data['sukses'] = 0;
		$data['pesan'] = 'Error 404 : Request tidak valid. Cek parameter';
		
		if (isset($_GET['catatandokter'])) {
			if ($model = MCatatandokterT::model()->findByPk($_GET['catatandokter']['mcatatandokter_id'])) {
				$model->attributes  = $_GET['catatandokter'];
				$model->update_time = date("Y-m-d H:i:s");
				if ($model->save()) {
					$data['sukses'] = 1;
					$data['pesan'] = 'Data catatan berhasil disimpan!';
				}
			}
			
		}
		$encode = CJSON::encode($data);
		echo "jsonCallback(".$encode.")";
	}
	
	/**
	 * action untuk mendapatkan catatan umum
	 * 
	 * @return array dari catatan dokter
	 */
	public function actionGetCatatan() {
		header("content-type:application/json");
		$data['is_found'] = 0;
        $data['pesan'] = "Data not found!";
        $data['data'] = '';
		$sql = "SELECT * FROM mcatatandokter_t JOIN mkategoricatatan_m "
				. "ON mcatatandokter_t.mkategoricatatan_id=mkategoricatatan_m.mkategoricatatan_id "
				. "WHERE mcatatandokter_t.mkategoricatatan_id=".Params::KATEGORICATATAN_ID_UMUM
				. " AND mcatatandokter_t.status_catatan!='READ' "
				. "ORDER BY mcatatandokter_t.mcatatandokter_id DESC LIMIT 8";
		$loadData = Yii::app()->db->createCommand($sql)->queryAll();
		if (sizeof($loadData)>0) {
			$data['is_found'] = 1;
			$data['pesan'] = "Data is found!";
			$data['data'] = $loadData;
			$sql2 = "SELECT *, tglrencana::time as time_rencana, tglrencana::date as date_rencana FROM mcatatandokter_t JOIN mkategoricatatan_m "
				. "ON mcatatandokter_t.mkategoricatatan_id=mkategoricatatan_m.mkategoricatatan_id "
				. "WHERE mcatatandokter_t.mkategoricatatan_id=".Params::KATEGORICATATAN_ID_AGENDA
				. " ORDER BY mcatatandokter_t.mcatatandokter_id DESC";
		
			if ($loadData2 = Yii::app()->db->createCommand($sql2)->queryRow()) {
				$data['agenda']['agenda_title'] = $loadData2['judulcatatan'];
				$data['agenda']['agenda_time'] = $loadData2['time_rencana'];
				$data['agenda']['agenda_date'] = $loadData2['date_rencana'];
			}else {
				$data['agenda']['agenda_title'] = 'No agenda found!';
				$data['agenda']['agenda_time'] = '-';
				$data['agenda']['agenda_date'] = '-';
			}
		}
		
		$encode = CJSON::encode($data);
		echo "jsonCallback(".$encode.")";
		Yii::app()->end();
	}
	
	/**
	 * action untuk mendapatkan agenda dokter
	 * 
	 * @return array dari catatan dokter
	 */
	public function actionGetAgenda() {
		header("content-type:application/json");
		$data['is_found'] = 0;
        $data['pesan'] = "Data not found!";
        $data['data'] = '';
		$sql = "SELECT * FROM mcatatandokter_t JOIN mkategoricatatan_m "
				. "ON mcatatandokter_t.mkategoricatatan_id=mkategoricatatan_m.mkategoricatatan_id "
				. "WHERE mcatatandokter_t.mkategoricatatan_id=".Params::KATEGORICATATAN_ID_AGENDA
				. " AND mcatatandokter_t.status_catatan!='READ' "
				. "ORDER BY mcatatandokter_t.mcatatandokter_id DESC LIMIT 8";
		$loadData = Yii::app()->db->createCommand($sql)->queryAll();
		if (sizeof($loadData)>0) {
			$data['is_found'] = 1;
			$data['pesan'] = "Data is found!";
			$data['data'] = $loadData;
			$sql2 = "SELECT *, tglrencana::time as time_rencana, tglrencana::date as date_rencana FROM mcatatandokter_t JOIN mkategoricatatan_m "
				. "ON mcatatandokter_t.mkategoricatatan_id=mkategoricatatan_m.mkategoricatatan_id "
				. "WHERE mcatatandokter_t.mkategoricatatan_id=".Params::KATEGORICATATAN_ID_AGENDA
				. " AND mcatatandokter_t.status_catatan!='READ' "
				. " ORDER BY mcatatandokter_t.mcatatandokter_id DESC";
		
			if ($loadData2 = Yii::app()->db->createCommand($sql2)->queryRow()) {
				$data['agenda']['agenda_title'] = $loadData2['judulcatatan'];
				$data['agenda']['agenda_time'] = $loadData2['time_rencana'];
				$data['agenda']['agenda_date'] = $loadData2['date_rencana'];
			}else {
				$data['agenda']['agenda_title'] = 'No agenda found!';
				$data['agenda']['agenda_time'] = '-';
				$data['agenda']['agenda_date'] = '-';
			}
		}
		
		$encode = CJSON::encode($data);
		echo "jsonCallback(".$encode.")";
		Yii::app()->end();
	}
	/**
	 * action untuk membuat catatan sudah dibaca
	 * 
	 * @param catatan_id, mcatatandokter_id
	 */
	public function actionMarkAsDoneNote() {
		header("content-type:application/json");
		$data = array();
		$data['sukses'] = 0;
		$data['pesan'] = 'Error 404 : Request tidak valid. Cek parameter';
		if (isset($_GET['catatan_id'])) {
			$sql = "UPDATE mcatatandokter_t SET status_catatan = 'READ' WHERE mcatatandokter_id=".$_GET['catatan_id'];
			if (Yii::app()->db->createCommand()->update('mcatatandokter_t', 
					array('status_catatan'=>'READ'), 'mcatatandokter_id=:id', array(':id'=>$_GET['catatan_id']))) {
				$data['sukses'] = 1;
				$data['pesan'] = 'Data have been sucessfully changed!';
			}else {
				$data['pesan'] = 'Data have not been sucessfully changed!';
			}
			
		}
		$encode = CJSON::encode($data);
		echo "jsonCallback(".$encode.")";
		Yii::app()->end();
	}
	
	
}
