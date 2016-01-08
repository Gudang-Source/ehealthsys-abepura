<?php
Yii::import('radiologi.controllers.PendaftaranRadiologiController');
Yii::import('radiologi.models.*');
Yii::import('radiologi.views.pendaftaranRadiologi');
class PendaftaranRadiologiPPController extends PendaftaranRadiologiController
{
	
	public $pageTitle = 'Pendaftaran Pasien Radiologi';
	public $path_view_pendaftaran = 'pendaftaranPenjadwalan.views.pendaftaranRadiologiPP.';
	
	/**
	* proses simpan / ubah data pasien
	* @param type $modPasien
	* @param type $post
	* @return type
	*/
	public function simpanPasien($modPasien, $post){
	   $format = new MyFormatter();
	   if(isset($post['pasien_id']) && (!empty($post['pasien_id']))){
		   $load = new $modPasien;
		   $modPasien = $load->findByPk($post['pasien_id']);
	   }
	   $modPasien->attributes = $post;
	   $modPasien->tanggal_lahir = $format->formatDateTimeForDb($modPasien->tanggal_lahir);
	   $modPasien->kelompokumur_id = CustomFunction::getKelompokUmur($modPasien->tanggal_lahir);
	   if(isset($post['tempPhoto'])){
		   $modPasien->photopasien = $post['tempPhoto'];
	   }
	   if(empty($modPasien->pasien_id)){
		   $modPasien->tgl_rekam_medik = date('Y-m-d H:i:s');
		   $modPasien->profilrs_id = Params::DEFAULT_PROFIL_RUMAH_SAKIT;
		   $modPasien->statusrekammedis = Params::STATUSREKAMMEDIS_AKTIF;
		   $modPasien->ispasienluar = FALSE;
		   $modPasien->create_ruangan = Yii::app()->user->getState('ruangan_id');
		   $modPasien->create_loginpemakai_id = Yii::app()->user->id;
		   $modPasien->create_time = date('Y-m-d H:i:s');
		   $modPasien->no_rekam_medik = MyGenerator::noRekamMedik();
	   }else{
		   $modPasien->update_loginpemakai_id = Yii::app()->user->id;
		   $modPasien->update_time = date('Y-m-d H:i:s');
	   }
	   $modPasien->kelurahan_id = (!empty($modPasien->kelurahan_id) ? $modPasien->kelurahan_id : null);
	   $modPasien->statusrekammedis = Params::STATUSREKAMMEDIS_AKTIF;
	   if($modPasien->save()){
		   $this->pasientersimpan = true;
	   }

	   return $modPasien;
	}
	
}
