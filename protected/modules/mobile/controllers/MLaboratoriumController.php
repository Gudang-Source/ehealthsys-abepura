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
class MLaboratoriumController extends Controller {
	
	
	/**
	 * action untuk mendapatkan list daftar pasien lab
	 * 
	 * @param pegawai_id
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
		if (isset($_GET['pegawai_id'])) {            			
			$sql = "SELECT * FROM pasienmasukpenunjang_v WHERE tglmasukpenunjang::date = NOW()::date AND pegawai_id=".$_GET['pegawai_id'];
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
	 * action untuk input pengambilan sampel yang dilakukan oleh dokter
	 * 
	 * @param array dari pengambilan sample
	 * @return sukses 1/0
	 */
	public function actionSubmitPengambilanSample() {
		header("content-type:application/json");
		$data = array();
		$data['sukses'] = 0;
		$data['pesan'] = 'Error 404 : Request tidak valid. Cek parameter';
		$error = "";
		$format = new MyFormatter();
		if(isset($_GET['pasienmasukpenunjang_id']) && isset($_GET['ambilsample'])){
			$transaction = Yii::app()->db->beginTransaction();
			$sampletersimpan = true; //looping
			$sample = $_GET['ambilsample'];
			try{
				//foreach($_GET['pengambilansample'] AS $i => $sample){
					if(!empty($sample['pengambilansample_id'])){
						$model = MOPengambilansampleT::model()->findByPk($sample['pengambilansample_id']);
						$model->samplelab_id = $sample['samplelab_id'];
						$model->tglpengambilansample = $format->formatDateTimeForDb($sample['tglpengambilansample']);
						$model->jmlpengambilansample = $sample['jmlpengambilansample'];
						$model->tempatsimpansample = $sample['tempatsimpansample'];
						$model->keterangansample = $sample['keterangansample'];
						$model->update_loginpemakai_id = $sample['update_loginpemakai_id'];
						$model->update_time = date('Y-m-d H:i:s');
						if($model->update()){
							$sampletersimpan &= true;
						}else{
							$sampletersimpan = false;
							$error .= CHtml::errorSummary($model);
						}
					}else{
						$model = new MOPengambilansampleT;
						$model->attributes = $sample;
						$model->tglpengambilansample = $format->formatDateTimeForDb($sample['tglpengambilansample']);
						$model->jmlpengambilansample = $sample['jmlpengambilansample'];
						$model->no_pengambilansample = MyGenerator::noPengambilanSample($model->alatmedis_id);
						$model->pasienmasukpenunjang_id = $_GET['pasienmasukpenunjang_id'];
						$model->create_time = date('Y-m-d H:i:s');
						if($model->save()){
							$sampletersimpan &= true;
						}else{
							$sampletersimpan = false;
							$error .= CHtml::errorSummary($model);
						}
					}
					if (isset($_GET['is_kirimsample'])){
						if(empty($_GET['kirimsample']['kirimsamplelab_id'])){
							$modKirim = new MOKirimsamplelabT;
							$modKirim->create_time = date("Y-m-d H:i:s");
							$modKirim->pengambilansample_id = $model->pengambilansample_id;
						}else{
							$modKirim = MOKirimsamplelabT::model()->findByPk($_GET['kirimsample']['kirimsamplelab_id']);
							$modKirim->update_time = date("Y-m-d H:i:s");
						}
						$modKirim->attributes = $_GET['kirimsample'];
						$modKirim->tglkirimsample = $format->formatDateTimeForDb($modKirim->tglkirimsample);
						if($modKirim->save()){
							$sampletersimpan &= true;
						}else{
							$sampletersimpan = false;
							$error .= CHtml::errorSummary($modKirim);
						}
					}
					if($sampletersimpan){
						$transaction->commit();
						$data['sukses'] = 1;
						$data['pesan'] = 'Data sampel lab berhasil disimpan!';
					}else{
						$transaction->rollback();
						$data['sukses'] = 0;
						$data['pesan'] = 'Data sampel lab gagal disimpan!'.$error;
					}
			}catch (Exception $exc) {
				$transaction->rollback();
				$data['sukses'] = 0;
				$data['pesan'] = 'Data sampel lab gagal disimpan!'.MyExceptionMessage::getMessage($exc,true);
			}
		}

		$encode = CJSON::encode($data);
		echo "jsonCallback(".$encode.")";
		Yii::app()->end();
	}
	
	/**
	 * action untuk menampilkan data list  pemeriksaan lab
	 * 
	 * @param array tindakan pelayanan lab
	 */
	public function actionGetTindakanPelayananLab() {
		header("content-type:application/json");
        $format = new MyFormatter();
        $data = array();
        $data['is_found'] = 0;
        $data['pesan'] = "Data tidak ditemukan!";
        $data['data'] = '';
        $statusPasien = '';
		$tglPendaftaran = '';
		if (isset($_GET['pendaftaran_id'])) {
			$pendaftaran_id = $_GET['pendaftaran_id'];
			$sql = "SELECT * FROM pendaftaran_t WHERE pendaftaran_id=".$pendaftaran_id;
			$loadData = Yii::app()->db->createCommand($sql)->queryRow();			
			if (sizeof($loadData)>0) {	
				$sql = "SELECT * "
						. "FROM tindakanpelayanan_t JOIN daftartindakan_m ON tindakanpelayanan_t.daftartindakan_id=daftartindakan_m.daftartindakan_id "
						. "WHERE tindakanpelayanan_t.pendaftaran_id=".$pendaftaran_id;
				$loadData2 = Yii::app()->db->createCommand($sql)->queryAll();
				if (sizeof($loadData2)>0) {
					$data['data']=$loadData2;
					$data['is_found'] = 1;
					$data['pesan'] = "Data ditemukan!"; 
					$data['no_pendaftaran'] = $loadData['no_pendaftaran'];	
				}
			}
		}
        $encode = CJSON::encode($data);
        echo "jsonCallback(".$encode.")";
	} 
	
	/**
	 * action untuk menampilkan data riwayat ambil dan kirim sample
	 * 
	 * @param array ambil dan kirim sample
	 */
	public function actionGetRiwayatAmbilKirimSample() {
		header("content-type:application/json");
        $format = new MyFormatter();
        $data = array();
        $data['is_found'] = 0;
        $data['pesan'] = "Data tidak ditemukan!";
        $data['data'] = '';
        $statusPasien = '';
		$tglPendaftaran = '';
		if (isset($_GET['pasienmasukpenunjang_id'])) {
			$pasienmasukpenunjang_id = $_GET['pasienmasukpenunjang_id'];
			$sql = "SELECT * FROM pengambilansample_t "
					. "JOIN samplelab_m ON pengambilansample_t.samplelab_id=samplelab_m.samplelab_id "
					. "WHERE pasienmasukpenunjang_id=".$pasienmasukpenunjang_id;
			$loadData = Yii::app()->db->createCommand($sql)->queryAll();	
			$i = 0;
			foreach ($loadData as $datum) {
				$data['data'][$i]['ambilsample']=$datum;				
				$sql = "SELECT * FROM kirimsamplelab_t "
					. "JOIN pengambilansample_t ON kirimsamplelab_t.pengambilansample_id=pengambilansample_t.pengambilansample_id "
					. "JOIN labklinikrujukan_m ON labklinikrujukan_m.labklinikrujukan_id=kirimsamplelab_t.labklinikrujukan_id "
					. "WHERE pengambilansample_t.pengambilansample_id=".$datum['pengambilansample_id'];
				$loadData2 = Yii::app()->db->createCommand($sql)->queryRow();				
				if (sizeof($loadData2)>0) {	
					$data['data'][$i]['kirimsample']=$loadData2;
				}
				$data['is_found'] = 1;
				$data['pesan'] = "Data ditemukan!";
				$i++;
			}
		}
        $encode = CJSON::encode($data);
        echo "jsonCallback(".$encode.")";
	} 
	
	/** 
	 * action untuk mendapatkan sampel lab
	 * 
	 * @return array sampel lab 
	 */
	public function actionGetSampleLab() {
		header("content-type:application/json");
        $format = new MyFormatter();
        $data = array();
        $data['is_found'] = 0;
        $data['pesan'] = "Data tidak ditemukan!";
        $data['data'] = '';
		$pendaftaran_id = $_GET['pendaftaran_id'];
		$sql = "SELECT * FROM samplelab_m";
		$loadData = Yii::app()->db->createCommand($sql)->queryAll();			
		if (sizeof($loadData)>0) {
			$data['data']=$loadData;
			$data['is_found'] = 1;
			$data['pesan'] = "Data ditemukan!"; 

		}
        $encode = CJSON::encode($data);
        echo "jsonCallback(".$encode.")";
	}
	
	/** 
	 * action untuk mendapatkan sample lab
	 * 
	 * @return array sample lab 
	 */
	public function actionHapusItemAmbilLab() {
		header("content-type:application/json");
        $format = new MyFormatter();
        $data = array();
        $data['is_found'] = 0;
        $data['pesan'] = "Data tidak ditemukan!";
        $data['data'] = '';
		$pengambilansampleID = $_GET['pengambilansample_id'];
		
		$sql = "DELETE FROM kirimsamplelab_t WHERE pengambilansample_id = ".$pengambilansampleID;
		$loadData = Yii::app()->db->createCommand($sql)->queryAll();			
		if (sizeof($loadData)>0) {
			$data['data']=$loadData;
			$data['is_found'] = 1;
			$data['pesan'] = "Data ditemukan!"; 

		}
        $encode = CJSON::encode($data);
        echo "jsonCallback(".$encode.")";
	}
	
	/** 
	 * action untuk mendapatkan lab klinik rujukan
	 * 
	 * @return array sampel lab 
	 */
	public function actionGetLabKlinikRujukan() {
		header("content-type:application/json");
        $format = new MyFormatter();
        $data = array();
        $data['is_found'] = 0;
        $data['pesan'] = "Data tidak ditemukan!";
        $data['data'] = '';
		$sql = "SELECT * FROM labklinikrujukan_m";
		$loadData = Yii::app()->db->createCommand($sql)->queryAll();			
		if (sizeof($loadData)>0) {
			$data['data']=$loadData;
			$data['is_found'] = 1;
			$data['pesan'] = "Data ditemukan!"; 
		}
        $encode = CJSON::encode($data);
        echo "jsonCallback(".$encode.")";
	}
	
	
	/*
	 * action untuk menampilkan pasien rujukan dari lab
	 * 
	 * @param pegawai_id
	 */	
	public function actionGetPasienLab() {
		header("content-type:application/json");
		$data = array();
		$data['is_found'] = 0;
		$data['pesan'] = 'Error 404 : Request tidak valid. Cek parameter';
		$q = $_GET['q'];
		$limit = $_GET['lim'];
		$offset = $_GET['off'];
		if (isset($_GET['q'])) {
			
//$loadData = CHtml::listData($arrPasienLabAnatomi, $valueField, $textField)
//			$sql = "SELECT pasienkirimkeunitlain_t.pasienkirimkeunitlain_id, pasien_m.pasien_id, pasien_m.nama_pasien, pasien_m.tempat_lahir, 
//					pasien_m.tempat_lahir, pendaftaran_t.penjamin_id, pendaftaran_t.carabayar_id, pasien_m.alamat_pasien, pendaftaran_t.umur, pendaftaran_t.jeniskasuspenyakit_id, daftartindakan_m.daftartindakan_id, 
//					daftartindakan_m.daftartindakan_kode, pendaftaran_t.ruangan_id, pendaftaran_t.instalasi_id, daftartindakan_m.daftartindakan_nama, kelompoktindakan_m.kelompoktindakan_nama, pasien_m.no_rekam_medik, pasienkirimkeunitlain_t.pendaftaran_id
//					FROM pasienkirimkeunitlain_t
//					JOIN pendaftaran_t ON pendaftaran_t.pendaftaran_id = pasienkirimkeunitlain_t.pendaftaran_id 
//					JOIN permintaankepenunjang_t ON pasienkirimkeunitlain_t.pasienkirimkeunitlain_id = permintaankepenunjang_t.pasienkirimkeunitlain_id
//					JOIN daftartindakan_m ON permintaankepenunjang_t.daftartindakan_id = daftartindakan_m.daftartindakan_id
//					JOIN kelompoktindakan_m ON daftartindakan_m.kelompoktindakan_id = kelompoktindakan_m.kelompoktindakan_id
//					JOIN pasien_m ON pasienkirimkeunitlain_t.pasien_id = pasien_m.pasien_id
//					WHERE pasien_m.nama_pasien ilike '%".$q."%' OR pasien_m.no_rekam_medik ilike '%".$q."%' OR pendaftaran_t.no_pendaftaran ilike '%".$q."% '
//					AND pendaftaran_t.ruangan_id = $ruangan_lab_id
//					ORDER BY pasienkirimkeunitlain_t.pasienkirimkeunitlain_id DESC LIMIT $limit OFFSET $offset";
//			$loadData = Yii::app()->db->createCommand($sql)->queryAll();
			$sql = " SELECT pasienkirimkeunitlain_t.pasienkirimkeunitlain_id, pasien_m.pasien_id, pasien_m.no_rekam_medik, pasien_m.namadepan, pasien_m.nama_pasien, pasien_m.nama_bin, pasien_m.jeniskelamin, pasien_m.tempat_lahir, pasien_m.tanggal_lahir, pasien_m.alamat_pasien, pasien_m.agama, pasien_m.golongandarah, pasien_m.rhesus, penanggungjawab_m.penanggungjawab_id, penanggungjawab_m.pengantar, penanggungjawab_m.hubungankeluarga, penanggungjawab_m.nama_pj, pasienkirimkeunitlain_t.tgl_kirimpasien, pasienkirimkeunitlain_t.nourut, pendaftaran_t.pendaftaran_id, pendaftaran_t.no_pendaftaran, pendaftaran_t.tgl_pendaftaran, jeniskasuspenyakit_m.jeniskasuspenyakit_id, jeniskasuspenyakit_m.jeniskasuspenyakit_nama, carabayar_m.carabayar_id, carabayar_m.carabayar_nama, penjaminpasien_m.penjamin_id, penjaminpasien_m.penjamin_nama, kelaspelayanan_m.kelaspelayanan_id, kelaspelayanan_m.kelaspelayanan_nama, pegawai_m.pegawai_id, pegawai_m.gelardepan, pegawai_m.nama_pegawai, gelarbelakang_m.gelarbelakang_id, gelarbelakang_m.gelarbelakang_nama, pasienkirimkeunitlain_t.catatandokterpengirim, ruanganasal_m.ruangan_id AS ruanganasal_id, ruanganasal_m.ruangan_nama AS ruanganasal_nama, instalasiasal_m.instalasi_id AS instalasiasal_id, instalasiasal_m.instalasi_nama AS instalasiasal_nama, ruangan_m.ruangan_id, ruangan_m.ruangan_nama, pasienkirimkeunitlain_t.instalasi_id, pasienkirimkeunitlain_t.pasienmasukpenunjang_id, pasienkirimkeunitlain_t.create_time, pasienkirimkeunitlain_t.create_loginpemakai_id, pendaftaran_t.umur
   FROM pasienkirimkeunitlain_t
   JOIN pasien_m ON pasienkirimkeunitlain_t.pasien_id = pasien_m.pasien_id
   JOIN pendaftaran_t ON pasienkirimkeunitlain_t.pendaftaran_id = pendaftaran_t.pendaftaran_id
   JOIN jeniskasuspenyakit_m ON pendaftaran_t.jeniskasuspenyakit_id = jeniskasuspenyakit_m.jeniskasuspenyakit_id
   JOIN carabayar_m ON pendaftaran_t.carabayar_id = carabayar_m.carabayar_id
   JOIN penjaminpasien_m ON pendaftaran_t.penjamin_id = penjaminpasien_m.penjamin_id
   JOIN kelaspelayanan_m ON pasienkirimkeunitlain_t.kelaspelayanan_id = kelaspelayanan_m.kelaspelayanan_id
   JOIN pegawai_m ON pasienkirimkeunitlain_t.pegawai_id = pegawai_m.pegawai_id
   LEFT JOIN gelarbelakang_m ON pegawai_m.gelarbelakang_id = gelarbelakang_m.gelarbelakang_id
   LEFT JOIN penanggungjawab_m ON pendaftaran_t.penanggungjawab_id = penanggungjawab_m.penanggungjawab_id
   JOIN ruangan_m ruanganasal_m ON pasienkirimkeunitlain_t.create_ruangan = ruanganasal_m.ruangan_id
   JOIN ruangan_m ON pasienkirimkeunitlain_t.ruangan_id = ruangan_m.ruangan_id
   JOIN instalasi_m instalasiasal_m ON ruanganasal_m.instalasi_id = instalasiasal_m.instalasi_id
  WHERE ruangan_m.ruangan_id = ".Params::RUANGAN_ID_LAB_ANATOMI." AND pasienkirimkeunitlain_t.pasienmasukpenunjang_id IS NULL LIMIT 10 OFFSET 0;";
			$loadData = Yii::app()->db->createCommand($sql)->queryAll();
			if (sizeof($loadData)>0) {
				$data['data'] = $loadData;
				$data['is_found'] = 1;
				$data['pesan'] = 'Data found';
			}
		}
		$encode = CJSON::encode($data);
		echo "jsonCallback(".$encode.")";
		Yii::app()->end();
	}
	
	/*
	 * action untuk menampilkan item rujukan lab
	 * 
	 * @param pasienkirimkeunitlain_id
	 * @param pendaftaran_id
	 */	
	public function actionGetItemRujukanLab() {
		header("content-type:application/json");
		$data = array();
		$data['is_found'] = 0;
		$data['pesan'] = 'Error 404 : Request tidak valid. Cek parameter';		
			
		if (isset($_GET['pasienkirimkeunitlain_id'])&&isset($_GET['pendaftaran_id'])) {
			$pasienkirimkeunitlain_id = $_GET['pasienkirimkeunitlain_id'];
			$pasienkirimkeunitlain_id = $_GET['pasienkirimkeunitlain_id'];
			
			$sql = "SELECT pasienkirimkeunitlain_id, jenispemeriksaanlab_m.jenispemeriksaanlab_nama,
						pemeriksaanlab_m.pemeriksaanlab_nama, pemeriksaanlab_m.pemeriksaanlab_id
					FROM permintaankepenunjang_t 
					JOIN pemeriksaanlab_m ON pemeriksaanlab_m.pemeriksaanlab_id=permintaankepenunjang_t.pemeriksaanlab_id
					JOIN jenispemeriksaanlab_m ON pemeriksaanlab_m.jenispemeriksaanlab_id=jenispemeriksaanlab_m.jenispemeriksaanlab_id
					WHERE pasienkirimkeunitlain_id = $pasienkirimkeunitlain_id
					ORDER BY pemeriksaanlab_m.pemeriksaanlab_nama";
			$loadData = Yii::app()->db->createCommand($sql)->queryAll();
			if (sizeof($loadData)>0) {
				$data['data'] = $loadData;
				$data['is_found'] = 1;
				$data['pesan'] = 'Data found';
			}else {
				echo $pendaftaran_id;
			}
		}
		$encode = CJSON::encode($data);
		echo "jsonCallback(".$encode.")";
		Yii::app()->end();
	}
	
	/**
	 * action untuk mendapatkan info item rujukan
	 * 
	 * @param array pasienmasukpenunujang_m
	 * @return array sukses 1/0
	 */
	
	public function actionSubmitPasienKePenunjang() {
		header('content-type: application/json');
		$data = array();
		$data['sukses'] = 0;
		$data['pesan'] = 'Error 404 : Request tidak valid. Cek parameter';		
		
		if(isset($_GET['pasienmasukpenunjang']) && isset($_GET['tindakanpelayanan'])){
			
			$transaction = Yii::app()->db->beginTransaction();
			$sampletersimpan = true; //looping
			$masukpenunjang = $_GET['pasienmasukpenunjang'];
			$tindakanpelayanan = $_GET['tindakanpelayanan'];
			//$model = 
			$model = new MOPasienmasukpenunjangT();
			
			try{
				$model->attributes = $_GET['pasienmasukpenunjang'];
				//echo $model->pasien_id;
				//exit;
				
				$model->create_time = date("Y-m-d H:i:s");
//				$model->shift_id = 1;
				$model->kunjungan = 'KUNJUNGAN BARU';
				$model->create_loginpemakai_id = 1;
				$model->no_masukpenunjang = MyGenerator::noMasukPenunjang('LB');
				$model->tglmasukpenunjang = date("Y-m-d H:i:s");
				$model->no_urutperiksa =  MyGenerator::noAntrianPenunjang($model->ruangan_id);
	//				print_r($model);
	//				exit;
				if ($model->save()) {
					$n = sizeof($tindakanpelayanan);
					$i = 0;
				
//					echo $n;
//					exit;
					while ($i<$n) {
						$modelTindakanPelayanan = new MOTindakanpelayananT;
						$modelTindakanPelayanan->attributes = $tindakanpelayanan[$i];
						$modelTindakanPelayanan->create_time = date("Y-m-d H:i:s");
						$modelTindakanPelayanan->shift_id = 1;						
						$modelTindakanPelayanan->pasien_id = $model->pasien_id;				
						$modelTindakanPelayanan->kelaspelayanan_id =  $model->kelaspelayanan_id;					
						$modelTindakanPelayanan->instalasi_id =  $_GET['pasienmasukpenunjang']['instalasi_id'];					
						$modelTindakanPelayanan->ruangan_id =  $model->ruangan_id;					
						$modelTindakanPelayanan->carabayar_id =  $_GET['pasienmasukpenunjang']['carabayar_id'];					
						$modelTindakanPelayanan->pendaftaran_id =  $model->pendaftaran_id;					
						$modelTindakanPelayanan->tgl_tindakan =  date("Y-m-d H:i:s");
						$modelTindakanPelayanan->penjamin_id =  $_GET['pasienmasukpenunjang']['penjamin_id'];
						$modelTindakanPelayanan->tarif_rsakomodasi =  0;
						$modelTindakanPelayanan->tarif_medis =  0;
						$modelTindakanPelayanan->tarif_paramedis =  0;
						$modelTindakanPelayanan->tarif_bhp =  0;
						$modelTindakanPelayanan->tarif_satuan =  0;
						$modelTindakanPelayanan->tarif_tindakan =  0;
						$modelTindakanPelayanan->satuantindakan =  0;
						$modelTindakanPelayanan->cyto_tindakan =  0;
						$modelTindakanPelayanan->tarifcyto_tindakan =  0;
						$modelTindakanPelayanan->discount_tindakan =  0;
						$modelTindakanPelayanan->pembebasan_tindakan =  0;
						$modelTindakanPelayanan->subsidiasuransi_tindakan =  0;
						$modelTindakanPelayanan->subsidipemerintah_tindakan =  0;
						$modelTindakanPelayanan->subsisidirumahsakit_tindakan =  0;
						$modelTindakanPelayanan->iurbiaya_tindakan =  0;
						$modelTindakanPelayanan->create_loginpemakai_id =  1;
						$modelTindakanPelayanan->create_ruangan =  $_GET['pasienmasukpenunjang']['ruangan_id'];;
						$modelTindakanPelayanan->jeniskasuspenyakit_id =  $_GET['pasienmasukpenunjang']['jeniskasuspenyakit_id'];											
						if ($modelTindakanPelayanan->save()) {
							//print_r($modelTindakanPelayanan);
							$data['sukses'] = 1;
							$data['pesan'] = 'Penambahan data telah berhasil dilakukan!';	
						}else {
							$data['is_sukses'] = 0;
							$data['pesan'] = 'Penambahan data gagal dilakukan!';
						}
						$i++;
						
					}
				}else {
					
				}
					
			}catch (Exception $exc) {
				$transaction->rollback();
				$data['sukses'] = 0;
				$data['pesan'] = 'Data sampel lab gagal disimpan!'.MyExceptionMessage::getMessage($exc,true);
			}
		}
		
		$encode = CJSON::encode($data);
		echo "jsonCallback(".$encode.")";
		Yii::app()->end();
	}
	
}
