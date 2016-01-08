<?php
class PPPendaftaranMp extends PendaftaranT {
    public $noRekamMedik;
    public $namaPasien;
    public $namaBin;
    public $alamat;
    public $propinsi;
    public $propinsi_id, $kabupaten_id;
    public $pendidikan_id, $pekerjaan_id, $suku_id;
    public $kabupaten;
    public $kecamatan;
    public $kelurahan;
    public $rt;
    public $rw;
    public $jenisidentitas;
    public $no_identitas_pasien;
    public $namadepan;
    public $nama_pasien;
    public $nama_bin;
    public $jeniskelamin;
    public $tempat_lahir;
    public $tanggal_lahir;
    public $alamat_pasien;
    public $no_rekam_medik;
    public $tgl_rekam_medik;
    public $kelaspelayanan_nama;
    public $profilrs_id;

    public $isRujukan = false;
    public $isPasienLama = false;
    public $adaKarcis = false;
    public $adaTindakanKonsul = false;
    public $adaKarcisKonsul = false;
    public $pakeAsuransi = false;
    public $adaPenanggungJawab = false;
    public $pakeSample = false;
    public $isKecelakaan = false;
    public $jeniskasuspenyakit_nama;
    public $isUpdatePasien = false;

    public $tgl_awal, $tgl_akhir;

    public $dokter_nama;
    public $nama_pegawai;
    public $dokter_id;
    public $dokter_pemeriksa;
    public $gelardokter;

    public $instalasi_nama;
    public $ruangan_nama;
    public $kunjunganbaru, $kunjunganlama;
    public $bulan,$tahun;

    public $data,$jumlah,$tick;

    public $isPemeriksaanLab = true; //Jika Pemeriksaan Laboratorium di ceklis
    public $isPemeriksaanRad = false; //Jika Pemeriksaan Radiologi di ceklis

    public $adaBiayaAdministrasi = false;
    public $tarifAdministrasi;
    public $jumlah_kunjungan;
    public $kelas_layanan;
    public static function model($class = __CLASS__){
        return parent::model();
    }
    
    /**
    * @return array validation rules for model attributes.
    */
    public function rules()
    {
            // NOTE: you should only define rules for those attributes that
            // will receive user inputs.
            return array(
                    array('pegawai_id, pasien_id, no_pendaftaran, tgl_pendaftaran, no_urutantri, statusperiksa, statuspasien, kunjungan, statusmasuk, umur, ruangan_id, carabayar_id, penjamin_id', 'required'),
                    array('penjamin_id, caramasuk_id, carabayar_id, pasien_id, shift_id, golonganumur_id, kelaspelayanan_id, rujukan_id, penanggungjawab_id, ruangan_id, instalasi_id, jeniskasuspenyakit_id, no_urutantri', 'numerical', 'integerOnly'=>true),
                    array('no_pendaftaran', 'length', 'max'=>12),
                    array('transportasi, keadaanmasuk, statusperiksa, statuspasien, kunjungan, statusmasuk', 'length', 'max'=>50),
                    array('umur', 'length', 'max'=>30),
                    array('pegawai_id, alihstatus, byphone, kunjunganrumah, nopendaftaran_aktif', 'safe'),

                    array('create_time','default','value'=>date( 'Y-m-d H:i:s', time()),'setOnEmpty'=>false,'on'=>'insert'),
                    array('update_time','default','value'=>date( 'Y-m-d H:i:s', time()),'setOnEmpty'=>false,'on'=>'update,insert'),
                    array('create_loginpemakai_id','default','value'=>Yii::app()->user->id,'on'=>'insert'),
                    array('update_loginpemakai_id','default','value'=>Yii::app()->user->id,'on'=>'update,insert'),

                    // The following rule is used by search().
                    // Please remove those attributes that should not be searched.
                    array('pendaftaran_id, penjamin_id, caramasuk_id, carabayar_id, pasien_id, shift_id, golonganumur_id, kelaspelayanan_id, rujukan_id, penanggungjawab_id, ruangan_id, instalasi_id, jeniskasuspenyakit_id, no_pendaftaran, tgl_pendaftaran, no_urutantri, transportasi, keadaanmasuk, statusperiksa, statuspasien, kunjungan, alihstatus, byphone, kunjunganrumah, statusmasuk, umur, create_time, upate_time, create_loginpemakai_id, upate_loginpemakai_id, create_ruangan, nopendaftaran_aktif', 'safe', 'on'=>'search'),
            );
    }

    public function attributeLabels()
    {
            return array(
                    'pendaftaran_id' => 'Pendaftaran',
                    'penjamin_id' => 'Penjamin',
                    'caramasuk_id' => 'Cara masuk',
                    'carabayar_id' => 'Cara Bayar',
                    'pegawai_id' => 'Dokter',
                    'pasien_id' => 'ID Pasien',
                    'shift_id' => 'Shift',
                    'golonganumur_id' => 'Golongan Umur',
                    'kelaspelayanan_id' => 'Kelas pelayanan',
                    'rujukan_id' => 'Rujukan',
                    'penanggungjawab_id' => 'Penanggungjawab',
                    'ruangan_id' => 'Ruangan',
                    'instalasi_id' => 'Instalasi',
                    'jeniskasuspenyakit_id' => 'Jenis Kasus Penyakit',
                    'no_pendaftaran' => 'No. Pendaftaran',
                    'tgl_pendaftaran' => 'Tgl. Pendaftaran',
                    'no_urutantri' => 'No. Urut Antri',
                    'transportasi' => 'Transportasi',
                    'keadaanmasuk' => 'Keadaan Masuk',
                    'statusperiksa' => 'Status Periksa',
                    'statuspasien' => 'Status Pasien',
                    'kunjungan' => 'Kunjungan',
                    'alihstatus' => 'Alih Status',
                    'byphone' => 'By Phone',
                    'kunjunganrumah' => 'Kunjungan Rumah',
                    'statusmasuk' => 'Status Masuk',
                    'umur' => 'Umur',
                    'no_asuransi' => 'No. Asuransi',
                    'namapemilik_asuransi' => 'Namapemilik Asuransi',
                    'nopokokperusahaan' => 'Nopokokperusahaan',
                    'kelastanggungan_id' => 'Kelastanggungan',
                    'namaperusahaan' => 'Namaperusahaan',
                
                    'create_time' => 'Create Time',
                    'update_time' => 'update Time',
                    'create_loginpemakai_id' => 'Create Loginpemakai',
                    'update_loginpemakai_id' => 'Update Loginpemakai',
                    'create_ruangan' => 'Create Ruangan',
                    'nopendaftaran_aktif' => 'Aktif',
            );
    }
    
    /**
     * validasi pada versi awal
     * @return type
     */
    protected function beforeValidate ()
    {
        // convert to storage format
        //$this->tglrevisimodul = date ('Y-m-d', strtotime($this->tglrevisimodul));
        $format = new MyFormatter();
        //$this->tglrevisimodul = $format->formatDateTimeForDb($this->tglrevisimodul);
        foreach($this->metadata->tableSchema->columns as $columnName => $column){
                if ($column->dbType == 'date'){
                        $this->$columnName = $format->formatDateTimeForDb($this->$columnName);
                }elseif ($column->dbType == 'timestamp without time zone'){
//                            $this->$columnName = date('Y-m-d H:i:s', CDateTimeParser::parse($this->$columnName, Yii::app()->locale->dateFormat));
//                            $this->$columnName = date('Y-m-d H:i:s', strtotime($this->$columnName));
                        $this->$columnName = $format->formatDateTimeForDb($this->$columnName);
                }
        }

        return parent::beforeValidate();
    }
    /**
     * validasi pada versi awal
     * @return type
     */
    public function beforeSave()
    {
        if($this->tglselesaiperiksa===null || trim($this->tglselesaiperiksa)==''){
            $this->setAttribute('tglselesaiperiksa', null);
        }
        if($this->tgl_konfirmasi===null || trim($this->tgl_konfirmasi)==''){
            $this->setAttribute('tgl_konfirmasi', null);
        }            
        if($this->tglrenkontrol===null || trim($this->tglrenkontrol)==''){
            $this->setAttribute('tglrenkontrol', null);
        }            

        return parent::beforeSave();
    }
    /**
     * validasi pada versi awal
     * @return boolean
     */
    protected function afterFind(){
        foreach($this->metadata->tableSchema->columns as $columnName => $column){

            if (!strlen($this->$columnName)) continue;

            if ($column->dbType == 'date'){                         
                    $this->$columnName = Yii::app()->dateFormatter->formatDateTime(
                                    CDateTimeParser::parse($this->$columnName, 'yyyy-MM-dd'),'medium',null);
                    }elseif ($column->dbType == 'timestamp without time zone'){
                            $this->$columnName = Yii::app()->dateFormatter->formatDateTime(
                                    CDateTimeParser::parse($this->$columnName, 'yyyy-MM-dd hh:mm:ss','medium',null));
                    }
        }
        return true;
    }
        /**
         * Mengambil daftar semua kelaspelayanan
         * @return CActiveDataProvider 
         */
        public function getKelasPelayananItems()
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
         * Mengambil daftar semua caramasuk
         * @return CActiveDataProvider 
         */
        public function getCaraMasukItems()
        {
            return CaramasukM::model()->findAllByAttributes(array('caramasuk_aktif'=>true),array('order'=>'caramasuk_nama'));
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
                    //return PenjaminpasienM::model()->findAllByAttributes(array('penjamin_aktif'=>true),array('order'=>'penjamin_nama'));
        }
        
        /**
         * Mengambil daftar semua ruangan
         * @return CActiveDataProvider 
         */
        public function getRuanganItems($instalasiId='')
        {
            if($instalasiId!='')
                return RuanganM::model()->findAllByAttributes(array('instalasi_id'=>$instalasiId,'ruangan_aktif'=>true),array('order'=>'ruangan_nama'));
            else
                return RuanganM::model()->findAllByAttributes(array('ruangan_aktif'=>true),array('order'=>'ruangan_nama'));
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
        
        public function getDokterItems($ruangan_id='')
        {
            if(!empty($ruangan_id))
                return DokterV::model()->findAllByAttributes(array('ruangan_id'=>$ruangan_id,'pegawai_aktif'=>true), array('order'=>'pegawai_id'));
            else
                return DokterV::model()->findAllByAttributes(array('pegawai_aktif'=>true), array('order'=>'pegawai_id'));
        }
        
        public function getDokterItemsInstalasi($instalasi_id='')
        {
            if(!empty($instalasi_id))
                return DokterV::model()->findAllByAttributes(array('instalasi_id'=>$instalasi_id,'pegawai_aktif'=>true));
            else
                return array();
        }
        
        public function getParamedisItems($ruangan_id='')
        {
            if(!empty($ruangan_id))
                return ParamedisV::model()->findAllByAttributes(array('ruangan_id'=>$ruangan_id,'pegawai_aktif'=>true));
            else
                return array();
        }
        
        public function searchListKunjungan(){
            $criteria = new CDBCriteria();
			if(!empty($this->pasien_id)){
				$criteria->addCondition("pasien_id' = ".$this->pasien_id);			
			}
            $criteria->order = 'tgl_pendaftaran DESC';
            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));
        }
        
        
        public function getPropinsiItems()
        {
            return PropinsiM::model()->findAll('propinsi_aktif=TRUE ORDER BY propinsi_nama');
        }
        
        public function getNamaNamaBIN()
        {
            return $this->nama_pasien.' bin '.$this->nama_bin;
        }
        
        public function getCaraBayarPenjamin()
        {
                return $this->carabayar_nama.' / '.$this->penjamin_nama;
        }
        
        public function getRTRW()
        {
            return $this->rt.' / '.$this->rw;
        }
        
         public function getPekerjaanItems()
        {
            return PekerjaanM::model()->findAll('pekerjaan_aktif=TRUE ORDER BY pekerjaan_nama');
        }
        
         public function getPendidikanItems()
        {
            return PendidikanM::model()->findAll('pendidikan_aktif=TRUE ORDER BY pendidikan_nama');
        }
        
         public function getSukuItems()
        {
            return SukuM::model()->findAll('suku_aktif=TRUE ORDER BY suku_nama');
        }
        public function getLamaRawat(){
            $format = new MyFormatter();
            $date1 = $format->formatDateTimeForDb($this->tgl_pendaftaran);
            $date2 = date('Y-m-d H:i:s');
            $diff = abs(strtotime($date2) - strtotime($date1));
            $hours   = floor(($diff)/3600); 
            return $hours;
        }

}
?>
