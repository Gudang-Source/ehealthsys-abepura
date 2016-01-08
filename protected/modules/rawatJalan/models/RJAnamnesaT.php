<?php

class RJAnamnesaT extends AnamnesaT
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return AnamnesaT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
	public function searchDiagnosaAnamnesa(){
		$criteria=new CDbCriteria;

		if(!empty($this->anamesa_id)){
			$criteria->addCondition('anamesa_id = '.$this->anamesa_id);
		}
		if(!empty($this->pendaftaran_id)){
			$criteria->addCondition('pendaftaran_id = '.$this->pendaftaran_id);
		}
		if(!empty($this->pasien_id)){
			$criteria->addCondition('pasien_id = '.$this->pasien_id);
		}
		if(!empty($this->triase_id)){
			$criteria->addCondition('triase_id = '.$this->triase_id);
		}
		if(!empty($this->pasienadmisi_id)){
			$criteria->addCondition('pasienadmisi_id = '.$this->pasienadmisi_id);
		}
		if(!empty($this->pegawai_id)){
			$criteria->addCondition('pegawai_id = '.$this->pegawai_id);
		}
		
		$criteria->compare('LOWER(tglanamnesis)',strtolower($this->tglanamnesis),true);
		$criteria->compare('LOWER(keluhanutama)',strtolower($this->keluhanutama),true);
		$criteria->compare('LOWER(keluhantambahan)',strtolower($this->keluhantambahan),true);
		$criteria->compare('LOWER(riwayatpenyakitterdahulu)',strtolower($this->riwayatpenyakitterdahulu),true);
		$criteria->compare('LOWER(riwayatpenyakitkeluarga)',strtolower($this->riwayatpenyakitkeluarga),true);
		$criteria->compare('LOWER(lamasakit)',strtolower($this->lamasakit),true);
		$criteria->compare('LOWER(pengobatanygsudahdilakukan)',strtolower($this->pengobatanygsudahdilakukan),true);
		$criteria->compare('LOWER(riwayatalergiobat)',strtolower($this->riwayatalergiobat),true);
		$criteria->compare('LOWER(riwayatkelahiran)',strtolower($this->riwayatkelahiran),true);
		$criteria->compare('LOWER(riwayatmakanan)',strtolower($this->riwayatmakanan),true);
		$criteria->compare('LOWER(riwayatimunisasi)',strtolower($this->riwayatimunisasi),true);
		$criteria->compare('LOWER(paramedis_nama)',strtolower($this->paramedis_nama),true);
		$criteria->compare('LOWER(keterangananamesa)',strtolower($this->keterangananamesa),true);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
		$criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);
		$criteria->compare('LOWER(riwayatperjalananpasien)',strtolower($this->riwayatperjalananpasien),true);
		if(!empty($this->petugas_triase_id)){
			$criteria->addCondition('petugas_triase_id = '.$this->petugas_triase_id);
		}
		$criteria->compare('statusmerokok',$this->statusmerokok);
		if(!empty($this->jmlrokok_btg_hr)){
			$criteria->addCondition('jmlrokok_btg_hr = '.$this->jmlrokok_btg_hr);
		}
		$criteria->compare('LOWER(riwayatimunisasiblm)',strtolower($this->riwayatimunisasiblm),true);
		$criteria->compare('LOWER(riwayatobatygsering)',strtolower($this->riwayatobatygsering),true);
		$criteria->compare('LOWER(keb_olahraga)',strtolower($this->keb_olahraga),true);
		$criteria->compare('LOWER(keb_jnsolahraga)',strtolower($this->keb_jnsolahraga),true);
		if(!empty($this->keb_frekuensi_kaliminggu)){
			$criteria->addCondition('keb_frekuensi_kaliminggu = '.$this->keb_frekuensi_kaliminggu);
		}
		$criteria->compare('LOWER(keb_konsumsialkohol)',strtolower($this->keb_konsumsialkohol),true);
		$criteria->compare('LOWER(keb_minumkopi)',strtolower($this->keb_minumkopi),true);
		$criteria->compare('LOWER(riwayat_kecelakaan)',strtolower($this->riwayat_kecelakaan),true);
		$criteria->compare('LOWER(riwayat_operasi)',strtolower($this->riwayat_operasi),true);
        $criteria->compare('LOWER(keb_konsumsidrug)',strtolower($this->keb_konsumsidrug),true);
			
			
	}
		
        public function searchDetailAnamnesa($pendaftaran_id)
	{
		
			$criteria=new CDbCriteria;

		if(!empty($this->anamesa_id)){
			$criteria->addCondition('anamesa_id = '.$this->anamesa_id);
		}
		if(!empty($this->pendaftaran_id)){
			$criteria->addCondition('pendaftaran_id = '.$this->pendaftaran_id);
		}
		if(!empty($this->pasien_id)){
			$criteria->addCondition('pasien_id = '.$this->pasien_id);
		}
		if(!empty($this->triase_id)){
			$criteria->addCondition('triase_id = '.$this->triase_id);
		}
		if(!empty($this->pasienadmisi_id)){
			$criteria->addCondition('pasienadmisi_id = '.$this->pasienadmisi_id);
		}
		if(!empty($this->pegawai_id)){
			$criteria->addCondition('pegawai_id = '.$this->pegawai_id);
		}
		
		$criteria->compare('LOWER(tglanamnesis)',strtolower($this->tglanamnesis),true);
		$criteria->compare('LOWER(keluhanutama)',strtolower($this->keluhanutama),true);
		$criteria->compare('LOWER(keluhantambahan)',strtolower($this->keluhantambahan),true);
		$criteria->compare('LOWER(riwayatpenyakitterdahulu)',strtolower($this->riwayatpenyakitterdahulu),true);
		$criteria->compare('LOWER(riwayatpenyakitkeluarga)',strtolower($this->riwayatpenyakitkeluarga),true);
		$criteria->compare('LOWER(lamasakit)',strtolower($this->lamasakit),true);
		$criteria->compare('LOWER(pengobatanygsudahdilakukan)',strtolower($this->pengobatanygsudahdilakukan),true);
		$criteria->compare('LOWER(riwayatalergiobat)',strtolower($this->riwayatalergiobat),true);
		$criteria->compare('LOWER(riwayatkelahiran)',strtolower($this->riwayatkelahiran),true);
		$criteria->compare('LOWER(riwayatmakanan)',strtolower($this->riwayatmakanan),true);
		$criteria->compare('LOWER(riwayatimunisasi)',strtolower($this->riwayatimunisasi),true);
		$criteria->compare('LOWER(paramedis_nama)',strtolower($this->paramedis_nama),true);
		$criteria->compare('LOWER(keterangananamesa)',strtolower($this->keterangananamesa),true);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
		$criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);
		$criteria->compare('LOWER(riwayatperjalananpasien)',strtolower($this->riwayatperjalananpasien),true);
		if(!empty($this->petugas_triase_id)){
			$criteria->addCondition('petugas_triase_id = '.$this->petugas_triase_id);
		}
		$criteria->compare('statusmerokok',$this->statusmerokok);
		if(!empty($this->jmlrokok_btg_hr)){
			$criteria->addCondition('jmlrokok_btg_hr = '.$this->jmlrokok_btg_hr);
		}
		$criteria->compare('LOWER(riwayatimunisasiblm)',strtolower($this->riwayatimunisasiblm),true);
		$criteria->compare('LOWER(riwayatobatygsering)',strtolower($this->riwayatobatygsering),true);
		$criteria->compare('LOWER(keb_olahraga)',strtolower($this->keb_olahraga),true);
		$criteria->compare('LOWER(keb_jnsolahraga)',strtolower($this->keb_jnsolahraga),true);
		if(!empty($this->keb_frekuensi_kaliminggu)){
			$criteria->addCondition('keb_frekuensi_kaliminggu = '.$this->keb_frekuensi_kaliminggu);
		}
		$criteria->compare('LOWER(keb_konsumsialkohol)',strtolower($this->keb_konsumsialkohol),true);
		$criteria->compare('LOWER(keb_minumkopi)',strtolower($this->keb_minumkopi),true);
		$criteria->compare('LOWER(riwayat_kecelakaan)',strtolower($this->riwayat_kecelakaan),true);
		$criteria->compare('LOWER(riwayat_operasi)',strtolower($this->riwayat_operasi),true);
        $criteria->compare('LOWER(keb_konsumsidrug)',strtolower($this->keb_konsumsidrug),true);
		
		
		return $criteria;
		
	}
	
	/**
	* menampilkan paramedis
	* @param type $ruangan_id
	* @return type
	*/
	public function getParamedisItems()
	{
	    $criteria = new CDbCriteria;
	    $criteria->join = 'LEFT JOIN pegawai_m ON pegawai_m.pegawai_id = t.pegawai_id LEFT JOIN kelompokpegawai_m ON kelompokpegawai_m.kelompokpegawai_id = pegawai_m.kelompokpegawai_id';
	    $ruangan_id = Yii::app()->user->getState('ruangan_id');
	    $criteria->addCondition('t.ruangan_id='.$ruangan_id);
	    $paramedis = Params::KELOMPOKPEGAWAI_ID_TENAGA_KEPERAWATAN;
//	    $criteria->addCondition('kelompokpegawai_m.kelompokpegawai_id='.$paramedis); //RND-8563 disamakan dengan kondisi di view : paramedis_v
	    $criteria->addCondition('kelompokpegawai_m.kelompokpegawai_id <> 1 ');
	    
	    return RuanganpegawaiM::model()->findAll($criteria);
	}

}