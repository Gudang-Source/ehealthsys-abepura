<?php

class KUPegawaiM extends PegawaiM
{
    
                public $nama_pemakai;
                public $new_password;
                public $new_password_repeat;  
                public $tempPhoto;
                
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PegawaiM the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
                }
    
                public function searchDialog()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('kelurahan_id',$this->kelurahan_id);
		$criteria->compare('kecamatan_id',$this->kecamatan_id);
		$criteria->compare('profilrs_id',$this->profilrs_id);
		$criteria->compare('gelarbelakang_id',$this->gelarbelakang_id);
		$criteria->compare('suku_id',$this->suku_id);
		$criteria->compare('kelompokpegawai_id',$this->kelompokpegawai_id);
		$criteria->compare('pendkualifikasi_id',$this->pendkualifikasi_id);
		$criteria->compare('jabatan_id',$this->jabatan_id);
		$criteria->compare('pendidikan_id',$this->pendidikan_id);
		$criteria->compare('propinsi_id',$this->propinsi_id);
		$criteria->compare('pangkat_id',$this->pangkat_id);
		$criteria->compare('kabupaten_id',$this->kabupaten_id);
		$criteria->compare('LOWER(nomorindukpegawai)',strtolower($this->nomorindukpegawai),true);
		$criteria->compare('LOWER(no_kartupegawainegerisipil)',strtolower($this->no_kartupegawainegerisipil),true);
		$criteria->compare('LOWER(no_karis_karsu)',strtolower($this->no_karis_karsu),true);
		$criteria->compare('LOWER(no_taspen)',strtolower($this->no_taspen),true);
		$criteria->compare('LOWER(no_askes)',strtolower($this->no_askes),true);
		$criteria->compare('LOWER(gelardepan)',strtolower($this->gelardepan),true);
		$criteria->compare('LOWER(nama_pegawai)',strtolower($this->nama_pegawai),true);
		$criteria->compare('LOWER(nama_keluarga)',strtolower($this->nama_keluarga),true);
		$criteria->compare('LOWER(tempatlahir_pegawai)',strtolower($this->tempatlahir_pegawai),true);
		$criteria->compare('LOWER(tgl_lahirpegawai)',strtolower($this->tgl_lahirpegawai),true);
		$criteria->compare('LOWER(jeniskelamin)',strtolower($this->jeniskelamin),true);
		$criteria->compare('LOWER(statusperkawinan)',strtolower($this->statusperkawinan),true);
		$criteria->compare('LOWER(alamat_pegawai)',strtolower($this->alamat_pegawai),true);
		$criteria->compare('LOWER(agama)',strtolower($this->agama),true);
		$criteria->compare('LOWER(golongandarah)',strtolower($this->golongandarah),true);
		$criteria->compare('LOWER(rhesus)',strtolower($this->rhesus),true);
		$criteria->compare('LOWER(alamatemail)',strtolower($this->alamatemail),true);
		$criteria->compare('LOWER(notelp_pegawai)',strtolower($this->notelp_pegawai),true);
		$criteria->compare('LOWER(nomobile_pegawai)',strtolower($this->nomobile_pegawai),true);
		$criteria->compare('LOWER(warganegara_pegawai)',strtolower($this->warganegara_pegawai),true);
		$criteria->compare('LOWER(jeniswaktukerja)',strtolower($this->jeniswaktukerja),true);
		$criteria->compare('LOWER(kelompokjabatan)',strtolower($this->kelompokjabatan),true);
		$criteria->compare('LOWER(kategoripegawai)',strtolower($this->kategoripegawai),true);
		$criteria->compare('LOWER(kategoripegawaiasal)',strtolower($this->kategoripegawaiasal),true);
		$criteria->compare('LOWER(photopegawai)',strtolower($this->photopegawai),true);
		$criteria->compare('pegawai_aktif',$this->pegawai_aktif);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

}