<?php

class GZPendaftaranT extends PendaftaranT {
    /** variable ini digunakan pada PendaftaranKonsultasiGiziController_old  */
        public $adaKarcisKonsul = false;
        public $adaTindakanKonsul = false;
        public $isUpdatePasien = false;
        public $adaKarcisLab = false;
        public $adaKarcisRad = false;
        public $pakeSample = false;
        public $isRujukan = false;
        public $isPasienLama = false;
        public $pakeAsuransi = false;
        public $adaPenanggungJawab = false;
        public $adaKarcis = false;
        public $noRekamMedik;
        
    /** end variable ini digunakan pada PendaftaranKonsultasiGiziController_old */
        public $jeniskasuspenyakit_nama='';
        public $is_adapjpasien = 0;
        public $is_pasienrujukan = 0;
        
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    
    public function relations()
	{ 
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
                        'pasien'=>array(self::BELONGS_TO,'PasienM','pasien_id'),
                        'penanggungJawab'=>array(self::BELONGS_TO,'PenanggungjawabM','penanggungjawab_id'),
                        'ruangan'=>array(self::BELONGS_TO,'RuanganM','ruangan_id'),
                        'jeniskasuspenyakit'=>array(self::BELONGS_TO,'JeniskasuspenyakitM','jeniskasuspenyakit_id'),
                        'dokter'=>array(self::BELONGS_TO,'PegawaiM','pegawai_id'),
                        'penjamin'=>array(self::BELONGS_TO, 'PenjaminpasienM', 'penjamin_id'),
                        'instalasi'=>array(self::BELONGS_TO, 'InstalasiM', 'instalasi_id'),
                        'carabayar'=>array(self::BELONGS_TO,  'CarabayarM', 'carabayar_id'),
                        'kirimkeunitlain'=>array(self::HAS_MANY, 'PasienkirimkeunitlainT', 'pendaftaran_id'),
                        'anamnesa'=>array(self::HAS_ONE, 'AnamnesaT', 'pendaftaran_id'),
                        'pemeriksaanfisik'=>array(self::HAS_ONE, 'PemeriksaanfisikT', 'pendaftaran_id'),
                        'pasienmasukpenunjang'=>array(self::HAS_ONE, 'PasienmasukpenunjangT', 'pendaftaran_id'),
                        'diagnosa'=>array(self::HAS_MANY, 'PasienmorbiditasT', 'pendaftaran_id'),
                        'pegawai'=>array(self::BELONGS_TO, 'PegawaiM', 'pegawai_id'),
                        'hasilpemeriksaanlab'=>array(self::HAS_ONE, 'HasilpemeriksaanlabT', 'pendaftaran_id'),
                        'pasienpulang'=>array(self::HAS_ONE, 'PasienpulangT', 'pasienpulang_id'),
                        'tindakanpelayanan'=>array(self::HAS_MANY, 'TindakanpelayananT', 'pendaftaran_id'),
                        'kelaspelayanan'=>array(self::BELONGS_TO, 'KelaspelayananM', 'kelaspelayanan_id'),
                    
		);
	}
    
    public function searchDialog()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
                $criteria->with=array('pasien','ruangan');
                $criteria->compare('LOWER(pasien.no_rekam_medik)',  strtolower($this->noRekamMedik),true);
                $criteria->compare('LOWER(pasien.nama_pasien)',  strtolower($this->namaPasien),true);
                $criteria->compare('LOWER(pasien.nama_bin)',  strtolower($this->namaBin),true);
                $criteria->compare('LOWER(pasien.alamat_pasien)',  strtolower($this->alamat),true);
                $criteria->compare('pasien.propinsi_id',  strtolower($this->propinsi));
                $criteria->compare('pasien.kabupaten_id',  strtolower($this->kabupaten));
                $criteria->compare('pasien.kecamatan_id',  strtolower($this->kecamatan));
                $criteria->compare('pasien.kelurahan_id',  strtolower($this->kelurahan));
                $criteria->compare('pendaftaran_id',$this->pendaftaran_id);
                $criteria->compare('penjamin_id',$this->penjamin_id);
                $criteria->compare('caramasuk_id',$this->caramasuk_id);
                $criteria->compare('carabayar_id',$this->carabayar_id);
                $criteria->compare('pasien_id',$this->pasien_id);
                $criteria->compare('shift_id',$this->shift_id);
                $criteria->compare('golonganumur_id',$this->golonganumur_id);
                $criteria->compare('kelaspelayanan_id',$this->kelaspelayanan_id);
                $criteria->compare('rujukan_id',$this->rujukan_id);
                $criteria->compare('penanggungjawab_id',$this->penanggungjawab_id);
                $criteria->compare('t.ruangan_id',$this->ruangan_id);
                $criteria->compare('instalasi_id',$this->instalasi_id);
                $criteria->compare('jeniskasuspenyakit_id',$this->jeniskasuspenyakit_id);
                $criteria->compare('LOWER(no_pendaftaran)',strtolower($this->no_pendaftaran),true);
                $criteria->compare('LOWER(tgl_pendaftaran)',strtolower($this->tgl_pendaftaran),true);
                $criteria->compare('no_urutantri',$this->no_urutantri);
                $criteria->compare('LOWER(transportasi)',strtolower($this->transportasi),true);
                $criteria->compare('LOWER(keadaanmasuk)',strtolower($this->keadaanmasuk),true);
                $criteria->compare('LOWER(statusperiksa)',strtolower($this->statusperiksa),true);
                $criteria->compare('LOWER(statuspasien)',strtolower($this->statuspasien),true);
                $criteria->compare('LOWER(kunjungan)',strtolower($this->kunjungan),true);
                $criteria->compare('alihstatus',$this->alihstatus);
                $criteria->compare('byphone',$this->byphone);
                $criteria->compare('kunjunganrumah',$this->kunjunganrumah);
                $criteria->compare('LOWER(statusmasuk)',strtolower($this->statusmasuk),true);
                $criteria->compare('LOWER(umur)',strtolower($this->umur),true);
                $criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
                $criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
                $criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
                $criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
                $criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);
                $criteria->compare('nopendaftaran_aktif',$this->nopendaftaran_aktif);
                $criteria->limit = 10;
                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
    public function getRuanganItems() 
        {
            $modRuangan = RuanganM::model()->findAll('(instalasi_id = '.Params::INSTALASI_ID_GIZI.') AND ruangan_aktif=true ORDER BY ruangan_nama');
            return $modRuangan;
        }
        public function getNamaLengkap(){
            $dokter = DokterV::model()->findByPk(array('pegawai_id'=>$this->pegawai_id));
            return $dokter->gelardepan." ".$dokter->nama_pegawai." ".$dokter->gelarbelakang_nama;
        }
        /**
         * mengambil data jenis kasus penyakit berdasarkan ruangan
         * @param type $ruangan_id
         */
        public function getJenisKasusPenyakitItems($ruangan_id = null)
        {            
            if($ruangan_id == ''){
                $ruangan_id = Yii::app()->user->getState('ruangan_id');
            }
            $criteria = new CdbCriteria();
            $criteria->addCondition('kasuspenyakitruangan_m.ruangan_id = '.$ruangan_id);
            $criteria->addCondition('t.jeniskasuspenyakit_aktif = true');
            $criteria->order = "t.jeniskasuspenyakit_nama";
            $criteria->join = "JOIN kasuspenyakitruangan_m ON t.jeniskasuspenyakit_id = kasuspenyakitruangan_m.jeniskasuspenyakit_id";
            return JeniskasuspenyakitM::model()->findAll($criteria);
        }
        /**
         * Mengambil daftar semua kelaspelayanan
         * @return CActiveDataProvider 
         */
        public function getKelasPelayananItems($ruangan_id = null)
        {
            if($ruangan_id == ''){
                $ruangan_id = Yii::app()->user->getState('ruangan_id');
            }
            $criteria = new CdbCriteria();
            $criteria->addCondition('kelasruangan_m.ruangan_id = '.$ruangan_id);
            $criteria->addCondition('t.kelaspelayanan_aktif = true');
            $criteria->order = "t.urutankelas";
            $criteria->join = "JOIN kelasruangan_m ON t.kelaspelayanan_id = kelasruangan_m.kelaspelayanan_id";
            return KelaspelayananM::model()->findAll($criteria);
        }
        
		/**
         * Mengambil daftar semua kelaspelayanan di kelastanggungan
         * @return CActiveDataProvider 
         */
        public static function getKelasPelayanan()
        {
            return KelaspelayananM::model()->findAllByAttributes(array('kelaspelayanan_aktif'=>true),array('order'=>'urutankelas'));
        }
		
        /**
         * Mengambil daftar semua carabayar
         * @return CActiveDataProvider 
         */
        public function getCaraBayarItems()
        {
            return CarabayarM::model()->findAllByAttributes(array('carabayar_aktif'=>true),array('order'=>'carabayar_nourut'));
        }
        /**
         * Mengambil daftar semua penjamin
         * @return CActiveDataProvider 
         */
        public function getPenjaminItems($carabayar_id=null)
        {
            if(!empty($carabayar_id))
                    return PenjaminpasienM::model()->findAllByAttributes(array('carabayar_id'=>$carabayar_id,'penjamin_aktif'=>true),array('order'=>'penjamin_nama'));
            else
                    return array();
        }
        /**
         * menampilkan dokter 
         * @param type $ruangan_id
         * @return type
         */
        public function getDokterItems($ruangan_id='')
        {
            $criteria = new CdbCriteria();
            $criteria->compare('ruangan_id',$ruangan_id);
            $criteria->addCondition('pegawai_aktif = true');
            $criteria->order = "nama_pegawai, gelardepan";
            $modDokter = DokterV::model()->findAll($criteria);
            return $modDokter;
        }
	
        /**
         * menampilkan pegawai gizi (Nutrisionis) 
         * @param type $ruangan_id = gizi
         * RSN-306
         */
        public function getNutrisionis()
        {
            $criteria = new CdbCriteria();
            $criteria->addCondition('ruangan_id='.Yii::app()->user->getState('ruangan_id'));
            $criteria->addCondition('pegawai_aktif = true');
            $modNutrisionis = PegawairuanganV::model()->findAll($criteria);
            return $modNutrisionis;
        }
        
         /**
         * menampilkan riwayat pendaftaran pasien di:
         * - pendaftaran Konsultasi Gizi Luar
         * @return \CActiveDataProvider
         */
        public function searchRiwayatPasien(){
            $criteria=new CDbCriteria;
            $criteria->addCondition('pasien_id = '.$this->pasien_id);
            $criteria->order = 'tgl_pendaftaran desc';          
            $criteria->limit = 5;          
            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));
        }
        
        

}
