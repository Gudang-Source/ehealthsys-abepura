<?php

class ASInfopengkajiankebidananV extends InfopengkajiankebidananV {

	public $tgl_awal, $tgl_akhir, $instalasi_id;

	public static function model($className = __CLASS__) {
		return parent::model($className);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search() {
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria = new CDbCriteria;

		$criteria->compare('pengkajianaskep_id', $this->pengkajianaskep_id);
		$criteria->addBetweenCondition('DATE(pengkajianaskep_tgl)', $this->tgl_awal, $this->tgl_akhir);
		$criteria->compare('pendaftaran_id', $this->pendaftaran_id);
		$criteria->compare('LOWER(no_pendaftaran)', strtolower($this->no_pendaftaran),true);
		$criteria->compare('pasien_id', $this->pasien_id);
		$criteria->compare('LOWER(nama_pasien)', strtolower($this->nama_pasien), true);
		$criteria->compare('LOWER(jeniskelamin)', strtolower($this->jeniskelamin), true);
		$criteria->compare('pegawai_id', $this->pegawai_id);
		if(!empty($this->nama_pegawai)){
			$criteria->compare('LOWER(nama_pegawai)', strtolower($this->nama_pegawai), true);
		}
		$criteria->compare('LOWER(ruangan_nama)', strtolower($this->ruangan_nama), true);
		$criteria->compare('LOWER(kelaspelayanan_nama)', strtolower($this->kelaspelayanan_nama), true);
		$criteria->compare('LOWER(no_pengkajian)',strtolower($this->no_pengkajian),true);
		$criteria->compare('anamesa_id',$this->anamesa_id);
		$criteria->compare('pemeriksaanfisik_id',$this->pemeriksaanfisik_id);
		if(!empty($this->ruangan_id)){
			$criteria->addCondition('ruangan_id ='.$this->ruangan_id);
		}
		$criteria->compare('kelaspelayanan_id',$this->kelaspelayanan_id);
		
		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
	
	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function searchInformasi() {
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria = new CDbCriteria;

		$criteria->compare('pengkajianaskep_id', $this->pengkajianaskep_id);
		$criteria->compare('pendaftaran_id', $this->pendaftaran_id);
		$criteria->compare('LOWER(no_pendaftaran)', strtolower($this->no_pendaftaran),true);
		$criteria->compare('pasien_id', $this->pasien_id);
		$criteria->compare('LOWER(nama_pasien)', strtolower($this->nama_pasien), true);
		$criteria->compare('LOWER(jeniskelamin)', strtolower($this->jeniskelamin), true);
		$criteria->compare('pegawai_id', $this->pegawai_id);
		if(!empty($this->nama_pegawai)){
			$criteria->compare('LOWER(nama_pegawai)', strtolower($this->nama_pegawai), true);
		}
		$criteria->compare('LOWER(ruangan_nama)', strtolower($this->ruangan_nama), true);
		$criteria->compare('LOWER(kelaspelayanan_nama)', strtolower($this->kelaspelayanan_nama), true);
		$criteria->compare('LOWER(no_pengkajian)',strtolower($this->no_pengkajian),true);
		$criteria->compare('anamesa_id',$this->anamesa_id);
		$criteria->compare('pemeriksaanfisik_id',$this->pemeriksaanfisik_id);
		if(!empty($this->ruangan_id)){
			$criteria->addCondition('ruangan_id ='.$this->ruangan_id);
		}
		$criteria->compare('kelaspelayanan_id',$this->kelaspelayanan_id);
		
		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}

}
