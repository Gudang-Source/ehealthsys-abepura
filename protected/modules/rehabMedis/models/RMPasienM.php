<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class RMPasienM extends PasienM
{
    public $cari_kecamatan_nama,$cari_kelurahan_nama;
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return KelompokmenuK the static model class
     */
    public $umur,$propinsiNama,$kabupatenNama,$kecamatanNama,$kelurahanNama;
//    public $tgl_rm_awal;
//    public $tgl_rm_akhir;
    public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }
    
    public function attributeLabels()
    {
            return array(
                    'pasien_id' => 'Pasien',
                    'pekerjaan_id' => 'Pekerjaan',
                    'kelurahan_id' => 'Kelurahan',
                    'pendidikan_id' => 'Pendidikan',
                    'propinsi_id' => 'Propinsi',
                    'kecamatan_id' => 'Kecamatan',
                    'suku_id' => 'Suku',
                    'profilrs_id' => 'Profilrs',
                    'kabupaten_id' => 'Kota / Kabupaten',
                    'no_rekam_medik' => 'No. Rekam Medik',
                    'tgl_rekam_medik' => 'Tgl. Rekam Medik',
                    'jenisidentitas' => 'Jenis Identitas',
                    'no_identitas_pasien' => 'No. Identitas',
                    'namadepan' => 'Nama Depan',
                    'nama_pasien' => 'Nama Pasien',
                    'nama_bin' => 'Bin',
                    'jeniskelamin' => 'Jenis Kelamin',
                    'kelompokumur_id' => 'Kelompok Umur',
                    'tempat_lahir' => 'Tempat Lahir',
                    'tanggal_lahir' => 'Tanggal Lahir',
                    'alamat_pasien' => 'Alamat Pasien',
                    'rt' => 'RT/RW',
                    'rw' => 'Rw',
                    'statusperkawinan' => 'Status Perkawinan',
                    'agama' => 'Agama',
                    'golongandarah' => 'Golongan Darah',
                    'rhesus' => 'Rhesus',
                    'anakke' => 'Anak ke',
                    'jumlah_bersaudara' => 'Jumlah Bersaudara',
                    'no_telepon_pasien' => 'No. Telepon',
                    'no_mobile_pasien' => 'No. Mobile',
                    'warga_negara' => 'Warga Negara',
                    'photopasien' => '',
                    'alamatemail' => 'Alamat Email',
                    'statusrekammedis' => 'Status Rekam medis',
                    'create_time' => 'Create Time',
                    'update_time' => 'Update Time',
                    'create_loginpemakai_id' => 'Create Loginpemakai',
                    'update_loginpemakai_id' => 'Update Loginpemakai',
                    'create_ruangan' => 'Create Ruangan',
                    'tgl_meninggal' => 'Tgl. Meninggal',
                    'tgl_rm_awal' => 'Tgl. Rekam Medik',
                    'tgl_rm_akhir' => 's/d',
            );
    }
    
     /**
      * 
      * @param type $cek mixed array
      * @return CActiveDataProvider 
      */
     public function searchPasien(){
         
            $criteria=new CDbCriteria;
//            $criteria->addBetweenCondition('tgl_rekam_medik', $this->tgl_rm_awal, $this->tgl_rm_akhir);
            $criteria->addCondition('tgl_rekam_medik BETWEEN \''.$this->tgl_rm_awal.'\' AND \''.$this->tgl_rm_akhir.'\'');
            $criteria->compare('TRIM(no_rekam_medik)', trim($this->no_rekam_medik),true);
            $criteria->compare('LOWER(nama_pasien)',strtolower($this->nama_pasien),true);
            $criteria->compare('LOWER(nama_bin)',strtolower($this->nama_bin),true);
			if (!empty($this->propinsi_id)){
				$criteria->addCondition('t.propinsi_id ='.$this->propinsi_id);
			}
			if (!empty($this->kabupaten_id)){
				$criteria->addCondition('t.kabupaten_id ='.$this->kabupaten_id);
			}
			if (!empty($this->kecamatan_id)){
				$criteria->addCondition('t.kecamatan_id ='.$this->kecamatan_id);
			}
			if (!empty($this->kelurahan_id)){
				$criteria->addCondition('t.kelurahan_id ='.$this->kelurahan_id);
			}
            $criteria->compare('LOWER(alamat_pasien)',strtolower($this->alamat_pasien),true);
            $criteria->compare('rt',$this->rt);
            $criteria->compare('rw',$this->rw);
            $criteria->with = array('propinsi','kabupaten','kecamatan','kelurahan');
            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));
        }

    public function searchWithDaerahPenunjang()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria=new CDbCriteria;
		
		if (!empty($this->pasien_id)){
			$criteria->addCondition('pasien_id ='.$this->pasien_id);
		}
		if (!empty($this->pekerjaan_id)){
			$criteria->addCondition('pekerjaan_id ='.$this->pekerjaan_id);
		}
		if (!empty($this->pendidikan_id)){
			$criteria->addCondition('pendidikan_id ='.$this->pendidikan_id);
		}
		if (!empty($this->propinsi_id)){
			$criteria->addCondition('t.propinsi_id ='.$this->propinsi_id);
		}
		if (!empty($this->kabupaten_id)){
			$criteria->addCondition('t.kabupaten_id ='.$this->kabupaten_id);
		}
		if (!empty($this->kecamatan_id)){
			$criteria->addCondition('t.kecamatan_id ='.$this->kecamatan_id);
		}
		if (!empty($this->kelurahan_id)){
			$criteria->addCondition('t.kelurahan_id ='.$this->kelurahan_id);
		}
        $criteria->compare('LOWER(propinsi.propinsi_nama)',strtolower($this->propinsiNama),true);
        $criteria->compare('LOWER(kabupaten.kabupaten_nama)',strtolower($this->kabupatenNama),true);
        $criteria->compare('LOWER(kecamatan.kecamatan_nama)',strtolower($this->kecamatanNama),true);
        $criteria->compare('LOWER(kelurahan.kelurahan_nama)',strtolower($this->kelurahanNama),true);
		if (!empty($this->suku_id)){
			$criteria->addCondition('suku_id ='.$this->suku_id);
		}
		if (!empty($this->profilrs_id)){
			$criteria->addCondition('profilrs_id ='.$this->profilrs_id);
		}
        $criteria->compare('LOWER(no_rekam_medik)',strtolower($this->no_rekam_medik),true);
        $criteria->compare('LOWER(tgl_rekam_medik)',strtolower($this->tgl_rekam_medik),true);
        $criteria->compare('LOWER(jenisidentitas)',strtolower($this->jenisidentitas),true);
        $criteria->compare('LOWER(no_identitas_pasien)',strtolower($this->no_identitas_pasien),true);
        $criteria->compare('LOWER(namadepan)',strtolower($this->namadepan),true);
        $criteria->compare('LOWER(nama_pasien)',strtolower($this->nama_pasien),true);
        $criteria->compare('LOWER(nama_bin)',strtolower($this->nama_bin),true);
        $criteria->compare('LOWER(jeniskelamin)',strtolower($this->jeniskelamin),true);
		if (!empty($this->kelompokumur_id)){
			$criteria->addCondition('kelompokumur_id ='.$this->kelompokumur_id);
		}
        $criteria->compare('LOWER(tempat_lahir)',strtolower($this->tempat_lahir),true);
        $criteria->compare('LOWER(tanggal_lahir)',strtolower($this->tanggal_lahir),true);
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
        $criteria->compare('LOWER(alamatemail)',strtolower($this->alamatemail),true);
        $criteria->compare('LOWER(statusrekammedis)',strtolower(Params::STATUSREKAMMEDIS_AKTIF),true);
        $criteria->compare('LOWER(tgl_meninggal)',strtolower($this->tgl_meninggal),true);
        $criteria->compare('t.ispasienluar',1);
                //Jika di filter berdasarkan No. Lab dan Rad
                $criteria->addCondition('create_ruangan IN ('.Params::RUANGAN_ID_RAD.','.Params::RUANGAN_ID_LAB.')');
                $criteria->with = array('propinsi','kabupaten','kecamatan','kelurahan');
                $criteria->order = 'pasien_id DESC';

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }

    /**
     * untuk menampilkan data pada grid dialog pasien
     * @return \CActiveDataProvider
     */
    public function searchDialog()
    {
            $criteria=$this->criteriaSearch();
            $criteria->join = " LEFT JOIN kecamatan_m ON t.kecamatan_id = kecamatan_m.kecamatan_id
                            LEFT JOIN kelurahan_m ON t.kelurahan_id = kelurahan_m.kelurahan_id ";
            $criteria->compare('LOWER(kecamatan_m.kecamatan_nama)',  strtolower($this->cari_kecamatan_nama), true);
            $criteria->compare('LOWER(kelurahan_m.kelurahan_nama)',  strtolower($this->cari_kelurahan_nama), true);
            $criteria->limit=5;
            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
                    'pagination'=>false,
            ));
    }
    
        /**
         * Mengambil daftar semua propinsi
         * @return CActiveDataProvider 
         */
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
    public function getPendidikanItems()
    {
            return PendidikanM::model()->findAll('pendidikan_aktif=TRUE ORDER BY pendidikan_nama');
    }
    public function getPekerjaanItems()
    {
            return PekerjaanM::model()->findAll('pekerjaan_aktif=TRUE ORDER BY pekerjaan_nama');
    }
    public function getSukuItems()
    {
            return SukuM::model()->findAll('suku_aktif=TRUE ORDER BY suku_nama');
    }
   
}
?>
