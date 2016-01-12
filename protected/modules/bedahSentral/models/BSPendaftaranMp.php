<?php
class BSPendaftaranMp extends PendaftaranT {
    
    public static function model($className=__CLASS__)
    {
		return parent::model($className);
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
                    'penanggungjawab_id' => 'Penanggung Jawab',
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
                    'namapemilik_asuransi' => 'Nama Pemilik Asuransi',
                    'nopokokperusahaan' => 'No. Pokok Perusahaan',
                    'kelastanggungan_id' => 'Kelas Tanggungan',
                    'namaperusahaan' => 'Nama Perusahaan',
                
                    'create_time' => 'Create Time',
                    'update_time' => 'update Time',
                    'create_loginpemakai_id' => 'Create Login Pemakai',
                    'update_loginpemakai_id' => 'Update Login Pemakai',
                    'create_ruangan' => 'Create Ruangan',
                    'nopendaftaran_aktif' => 'Aktif',
            );
    }
    
    public function getRuanganItems($instalasiId ='') 
    {
        $modRuangan = RuanganM::model()->findAll('(instalasi_id = '.Params::INSTALASI_ID_LAB.' OR instalasi_id = '.Params::INSTALASI_ID_RAD.' OR instalasi_id = '.Params::INSTALASI_ID_REHAB. ' OR instalasi_id = '.Params::INSTALASI_ID_IBS. ') AND ruangan_aktif=true ORDER BY ruangan_nama');
        return $modRuangan;
    }
    
    public function getDokterItems($ruangan_id='')
    {
        if(!empty($ruangan_id))
            return DokterV::model()->findAllByAttributes(array('ruangan_id'=>$ruangan_id));
        else
            return array();
    }  
    
    public function getParamedisItems($ruangan_id='')
        {
            if(!empty($ruangan_id))
                return ParamedisV::model()->findAllByAttributes(array('ruangan_id'=>$ruangan_id));
            else
                return array();
        }

    /**
    * Mengambil daftar semua KelasPelayanan
    * @return CActiveDataProvider 
    */
    public function getKelasPelayananItems()
    {
        return KelaspelayananM::model()->findAll('kelaspelayanan_aktif=true ORDER BY kelaspelayanan_nama');
    }
	
	/**
	* mengambil data jenis kasus penyakit berdasarkan ruangan
	* @param type $ruangan_id
	*/
	public static function getJenisKasusPenyakitItems($ruangan_id = null)
	{            
		if(empty($ruangan_id)){
			$ruangan_id = Yii::app()->user->getState('ruangan_id');
		}
		$criteria = new CdbCriteria();
		$criteria->addCondition('kasuspenyakitruangan_m.ruangan_id = '.$ruangan_id);
		$criteria->addCondition('t.jeniskasuspenyakit_aktif = true');
		$criteria->order = "t.jeniskasuspenyakit_nama";
		$criteria->join = "JOIN kasuspenyakitruangan_m ON t.jeniskasuspenyakit_id = kasuspenyakitruangan_m.jeniskasuspenyakit_id";
		return JeniskasuspenyakitM::model()->findAll($criteria);
	}
    
}
?>
