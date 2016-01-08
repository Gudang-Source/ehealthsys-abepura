<?php

class SAPasienM extends PasienM
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return PasienM the static model class
     */
    public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }
    
    /**
    * Retrieves a list of models based on the current search/filter conditions.
    * @return CdbCriteria that can return criterias.
    */
    public function searchDialog()
    {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.
            $format = new MyFormatter();
            $criteria=new CDbCriteria;
			
			if (!empty($this->pasien_id)){
				$criteria->addCondition('pasien_id ='.$this->pasien_id);
			}
			if (!empty($this->kelompokumur_id)){
				$criteria->addCondition('kelompokumur_id ='.$this->kelompokumur_id);
			}
			if (!empty($this->kecamatan_id)){
				$criteria->addCondition('kecamatan_id ='.$this->kecamatan_id);
			}
			if (!empty($this->pendidikan_id)){
				$criteria->addCondition('pendidikan_id ='.$this->pendidikan_id);
			}
			if (!empty($this->profilrs_id)){
				$criteria->addCondition('profilrs_id ='.$this->profilrs_id);
			}
			if (!empty($this->kelurahan_id)){
				$criteria->addCondition('kelurahan_id ='.$this->kelurahan_id);
			}
			if (!empty($this->loginpemakai_id)){
				$criteria->addCondition('loginpemakai_id ='.$this->loginpemakai_id);
			}
			if (!empty($this->suku_id)){
				$criteria->addCondition('suku_id ='.$this->suku_id);
			}
			if (!empty($this->pekerjaan_id)){
				$criteria->addCondition('pekerjaan_id ='.$this->pekerjaan_id);
			}
			if (!empty($this->kabupaten_id)){
				$criteria->addCondition('kabupaten_id ='.$this->kabupaten_id);
			}
			if (!empty($this->propinsi_id)){
				$criteria->addCondition('propinsi_id ='.$this->propinsi_id);
			}
			if (!empty($this->dokrekammedis_id)){
				$criteria->addCondition('dokrekammedis_id ='.$this->dokrekammedis_id);
			}
            $criteria->compare('LOWER(no_rekam_medik)',strtolower($this->no_rekam_medik),true);
            $criteria->compare('LOWER(tgl_rekam_medik)',strtolower($this->tgl_rekam_medik),true);
            $criteria->compare('LOWER(jenisidentitas)',strtolower($this->jenisidentitas),true);
            $criteria->compare('LOWER(no_identitas_pasien)',strtolower($this->no_identitas_pasien),true);
            $criteria->compare('LOWER(namadepan)',strtolower($this->namadepan),true);
            $criteria->compare('LOWER(nama_pasien)',strtolower($this->nama_pasien),true);
            $criteria->compare('LOWER(nama_bin)',strtolower($this->nama_bin),true);
            $criteria->compare('LOWER(jeniskelamin)',strtolower($this->jeniskelamin),true);
            $criteria->compare('LOWER(tempat_lahir)',strtolower($this->tempat_lahir),true);
            $criteria->compare('LOWER(alamat_pasien)',strtolower($this->alamat_pasien),true);
            $criteria->compare('rt',$this->rt);
            $criteria->compare('rw',$this->rw);
            $criteria->compare('LOWER(statusperkawinan)',strtolower($this->statusperkawinan),true);
            $criteria->compare('LOWER(agama)',strtolower($this->agama),true);
            $criteria->compare('LOWER(golongandarah)',strtolower($this->golongandarah),true);
            $criteria->compare('LOWER(rhesus)',strtolower($this->rhesus),true);
            $criteria->compare('anakke',$this->anakke);
            $criteria->compare('jumlah_bersaudara',$this->jumlah_bersaudara);
            $criteria->compare('LOWER(no_telepon_pasien)',strtolower($this->no_telepon_pasien),true);
            $criteria->compare('LOWER(no_mobile_pasien)',strtolower($this->no_mobile_pasien),true);
            $criteria->compare('LOWER(warga_negara)',strtolower($this->warga_negara),true);
            $criteria->compare('LOWER(photopasien)',strtolower($this->photopasien),true);
            $criteria->compare('LOWER(alamatemail)',strtolower($this->alamatemail),true);
            $criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
            $criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
            $criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
            $criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
            $criteria->compare('LOWER(tgl_meninggal)',strtolower($this->tgl_meninggal),true);
            $criteria->compare('ispasienluar',$this->ispasienluar);
            $criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);
            $criteria->compare('LOWER(nama_ibu)',strtolower($this->nama_ibu),true);
            $criteria->compare('LOWER(nama_ayah)',strtolower($this->nama_ayah),true);
            $criteria->compare('LOWER(norm_lama)',strtolower($this->norm_lama),true);
            $criteria->addCondition("statusrekammedis LIKE '%AKTIF%'");

            return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
    }
	
	public function getPropinsiItems()
        {
            return PropinsiM::model()->findAllByAttributes(array('propinsi_aktif'=>true),array('order'=>'propinsi_nama'));
        }
        /**
         * Mengambil daftar semua kabupaten berdasarkan propinsi
         * @return CActiveDataProvider 
         */
        public function getKabupatenItems($propinsi_id=null)
        {
            $criteria = new CDbCriteria();
			if(!empty($propinsi_id)){
				$criteria->addCondition("propinsi_id = ".$propinsi_id); 			
			}
            $criteria->compare('kabupaten_aktif', true);
            $criteria->order='kabupaten_nama';
            $models = KabupatenM::model()->findAll($criteria);
            return $models;
        }
        /**
         * Mengambil daftar semua kecamatan berdasarkan kabupaten
         * @return CActiveDataProvider 
         */
        public function getKecamatanItems($kabupaten_id=null)
        {
            $criteria = new CDbCriteria();
			if(!empty($kabupaten_id)){
				$criteria->addCondition("kabupaten_id = ".$kabupaten_id); 			
			}
            $criteria->compare('kecamatan_aktif', true);
            $criteria->order='kecamatan_nama';
            $models = KecamatanM::model()->findAll($criteria);
            return $models;
        }
        /**
         * Mengambil daftar semua kelurahan berdasarkan kecamatan
         * @return CActiveDataProvider 
         */
        public function getKelurahanItems($kecamatan_id=null)
        {
            $criteria = new CDbCriteria();
			if(!empty($kecamatan_id)){
				$criteria->addCondition("kecamatan_id = ".$kecamatan_id); 			
			}
            $criteria->compare('kelurahan_aktif', true);
            $criteria->order='kelurahan_nama';
            $models = KelurahanM::model()->findAll($criteria);
            return $models;
        }
	    
}
?>
