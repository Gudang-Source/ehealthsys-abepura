<?php

/**
 * This is the model class for table "tindakanpelayanan_t".
 *
 * The followings are the available columns in table 'tindakanpelayanan_t':
 * @property integer $tindakanpelayanan_id
 * @property integer $penjamin_id
 * @property integer $pasienadmisi_id
 * @property integer $pasien_id
 * @property integer $kelaspelayanan_id
 * @property integer $tipepaket_id
 * @property integer $instalasi_id
 * @property integer $pendaftaran_id
 * @property integer $shift_id
 * @property integer $pasienmasukpenunjang_id
 * @property integer $daftartindakan_id
 * @property integer $carabayar_id
 * @property integer $jeniskasuspenyakit_id
 * @property string $tgl_tindakan
 * @property double $tarif_tindakan
 * @property string $satuantindakan
 * @property string $qty_tindakan
 * @property boolean $cyto_tindakan
 * @property double $tarifcyto_tindakan
 * @property string $dokterpemeriksa1_id
 * @property string $dokterpemeriksa2_id
 * @property string $dokterpendamping_id
 * @property string $dokteranastesi_id
 * @property string $dokterdelegasi_id
 * @property string $bidan_id
 * @property string $suster_id
 * @property string $perawat_id
 * @property integer $kelastanggungan_id
 * @property double $discount_tindakan
 * @property double $subsidiasuransi_tindakan
 * @property double $subsidipemerintah_tindakan
 * @property double $subsisidirumahsakit_tindakan
 * @property double $iurbiaya_tindakan
 * @property string $tm 
 * 
 * @property string $kategoriTindakanNama
 * @property string $daftartindakanNama
 * @property double $jumlahTarif
 * @property double $persenCyto
 * 
 * @property double $tarif_satuan
 * @property integer $rencanaoperasi_id
 * @property integer $hasilpemeriksaanpa_id
 * @property integer $hasilpemeriksaanrm_id
 * @property integer $konsulpoli_id
 * @property integer $hasilpemeriksaanrad_id
 * @property integer $detailhasilpemeriksaanlab_id
 * 
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 * @property integer $rencanatindakan_id
 */
class TindakanpelayananT extends CActiveRecord
{
    public $jumlahTarif;
    public $persenCyto;
    public $kategoriTindakanNama;
    public $daftartindakanNama;
    public $tgl_awal;
    public $tgl_akhir;
    public $total_biaya;
    public $jmlbayar_tindakan,$bayartindakan;
    public $jmlsisabayar_tindakan,$sisatindakan;
    public $no_pendaftaran,$nama_pasien,$alamat_pasien;
    public $Poliklinik;

    /**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TindakanpelayananT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tindakanpelayanan_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('penjamin_id, pasien_id, kelaspelayanan_id, instalasi_id, pendaftaran_id, shift_id, daftartindakan_id, carabayar_id, jeniskasuspenyakit_id, tgl_tindakan, tarif_tindakan, satuantindakan, qty_tindakan, cyto_tindakan, tarifcyto_tindakan, discount_tindakan, subsidiasuransi_tindakan, subsidipemerintah_tindakan, subsisidirumahsakit_tindakan, iurbiaya_tindakan', 'required'),
			array('penjamin_id, pasienadmisi_id, pasien_id, kelaspelayanan_id, tipepaket_id, instalasi_id, pendaftaran_id, shift_id, pasienmasukpenunjang_id, daftartindakan_id, carabayar_id, jeniskasuspenyakit_id, kelastanggungan_id,
                               dokterpemeriksa1_id, dokterpemeriksa2_id, dokterpendamping_id, dokteranastesi_id, dokterdelegasi_id, bidan_id, suster_id, perawat_id, rencanatindakan_id', 'numerical', 'integerOnly'=>true),
			array('tarifcyto_tindakan, discount_tindakan, subsidiasuransi_tindakan, subsidipemerintah_tindakan, subsisidirumahsakit_tindakan, iurbiaya_tindakan', 'numerical'),
			array('satuantindakan', 'length', 'max'=>10),
			array('tm', 'length', 'max'=>2),
			array('ruangan_id,kategoriTindakanNama, daftartindakanNama, tarif_satuan, tarif_tindakan, persenCyto, jumlahTarif, dokterpemeriksa1_id, dokterpemeriksa2_id, dokterpendamping_id, dokteranastesi_id, dokterdelegasi_id, bidan_id, suster_id, perawat_id, keterangantindakan', 'safe'),
			                    
                        array('create_time','default','value'=>date('Y-m-d H:i:s'),'setOnEmpty'=>false,'on'=>'insert'),
                        array('update_time','default','value'=>date('Y-m-d H:i:s'),'setOnEmpty'=>false,'on'=>'update,insert'),
                        array('create_loginpemakai_id','default','value'=>Yii::app()->user->id,'on'=>'insert'),
                        array('update_loginpemakai_id','default','value'=>Yii::app()->user->id,'on'=>'update,insert'),
                        array('create_ruangan','default','value'=>Yii::app()->user->getState('ruangan_id'),'on'=>'insert'),
                        
                        // The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('tindakanpelayanan_id, Poliklinik, penjamin_id, pasienadmisi_id, pasien_id, kelaspelayanan_id, tipepaket_id, instalasi_id, pendaftaran_id, shift_id, pasienmasukpenunjang_id, daftartindakan_id, carabayar_id, jeniskasuspenyakit_id, tgl_tindakan, tarif_tindakan, satuantindakan, qty_tindakan, cyto_tindakan, tarifcyto_tindakan, dokterpemeriksa1_id, dokterpemeriksa2_id, dokterpendamping_id, dokteranastesi_id, dokterdelegasi_id, bidan_id, suster_id, perawat_id, kelastanggungan_id, discount_tindakan, subsidiasuransi_tindakan, subsidipemerintah_tindakan, subsisidirumahsakit_tindakan, iurbiaya_tindakan, tm, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, keterangantindakan, rencanatindakan_id', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
                        'daftartindakan'=>array(self::BELONGS_TO,'DaftartindakanM','daftartindakan_id'),
                        'dokter1'=>array(self::BELONGS_TO,'PegawaiM','dokterpemeriksa1_id'),
                        'dokter2'=>array(self::BELONGS_TO,'PegawaiM','dokterpemeriksa2_id'),
                        'dokterPendamping'=>array(self::BELONGS_TO,'PegawaiM','dokterpendamping_id'),
                        'dokterAnastesi'=>array(self::BELONGS_TO,'PegawaiM','dokteranastesi_id'),
                        'dokterDelegasi'=>array(self::BELONGS_TO,'PegawaiM','dokterdelegasi_id'),
                        'bidan'=>array(self::BELONGS_TO,'PegawaiM','bidan_id'),
                        'suster'=>array(self::BELONGS_TO,'PegawaiM','suster_id'),
                        'perawat'=>array(self::BELONGS_TO,'PegawaiM','perawat_id'),
                        'tipePaket'=>array(self::BELONGS_TO,'TipepaketM','tipepaket_id'),
                        'tipepaket'=>array(self::BELONGS_TO,'TipepaketM','tipepaket_id'),
                        'pendaftaran'=>array(self::BELONGS_TO,'PendaftaranT','pendaftaran_id'),
                        'pasien'=>array(self::BELONGS_TO,'PasienM','pasien_id'),
                        'alatmedis'=>array(self::BELONGS_TO,'AlatmedisM','alatmedis_id'),
                        'tindakansudahbayar'=>array(self::BELONGS_TO,'TindakansudahbayarT','tindakansudahbayar_id'),
                        'hasilpemeriksaanrad'=>array(self::BELONGS_TO,'HasilpemeriksaanradT','hasilpemeriksaanrad_id'),
                        'karcis'=>array(self::BELONGS_TO,'KarcisM','karcis_id'),
                        'instalasi'=>array(self::BELONGS_TO,'InstalasiM','instalasi_id'),
                        'ruangan'=>array(self::BELONGS_TO,'RuanganM','ruangan_id'),
                        'pasienmasukpenunjang'=>array(self::HAS_MANY,'PasienmasukpenunjangT','pasienmasukpenunjang_id'),
                        'jeniskasuspenyakit'=>array(self::BELONGS_TO,'JeniskasuspenyakitM','jeniskasuspenyakit_id'),
                        'detailhasilpemeriksaanlab'=>array(self::BELONGS_TO,'DetailhasilpemeriksaanlabT','detailhasilpemeriksaanlab_id'),
                        'rencanatindakan'=>array(self::BELONGS_TO,'RencanatindakanT','rencanatindakan_id'),

		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'tindakanpelayanan_id' => 'ID Tindakan Pelayanan',
			'penjamin_id' => 'Penjamin',
			'pasienadmisi_id' => 'Pasien Admisi',
			'pasien_id' => 'Pasien',
			'kelaspelayanan_id' => 'Kelas Pelayanan',
			'tipepaket_id' => 'Tipe Paket',
			'instalasi_id' => 'Instalasi',
			'pendaftaran_id' => 'Pendaftaran',
			'shift_id' => 'Shift',
			'pasienmasukpenunjang_id' => 'Pasien Masuk Penunjang',
			'daftartindakan_id' => 'Daftar Tindakan',
			'carabayar_id' => 'Cara Bayar',
			'jeniskasuspenyakit_id' => 'Kasus Penyakit',
			'tgl_tindakan' => 'Tanggal Tindakan',
			'tarif_tindakan' => 'Tarif',
			'satuantindakan' => 'Satuan',
			'qty_tindakan' => 'Jumlah',
			'cyto_tindakan' => 'Cyto',
			'tarifcyto_tindakan' => 'Tarifcyto',
			'dokterpemeriksa1_id' => 'Dokter Pemeriksa 1',
			'dokterpemeriksa2_id' => 'Dokter Pemeriksa 2',
			'dokterpendamping_id' => 'Dokter Pendamping',
			'dokteranastesi_id' => 'Dokter Anastesi',
			'dokterdelegasi_id' => 'Dokter Delegasi',
			'bidan_id' => 'Bidan',
			'suster_id' => 'Suster',
			'perawat_id' => 'Perawat',
			'kelastanggungan_id' => 'Kelas Tanggungan',
			'discount_tindakan' => 'Discount',
			'subsidiasuransi_tindakan' => 'Subsidi Asuransi',
			'subsidipemerintah_tindakan' => 'Subsidi Pemerintah',
			'subsisidirumahsakit_tindakan' => 'Subsisidi Rumah Sakit',
			'iurbiaya_tindakan' => 'Iur Biaya',
			'tm' => 'Tm',
                    
                        'jumlahTarif' => 'Jumlah Tarif',
                        'persenCyto' => 'Persen Cyto',
                        'kategoriTindakanNama' => 'Kategori Tindakan',
                        'ruangan_id'=>'Ruangan',
                    
                        'hasilpemeriksaanrm_id' => 'Hasil Pemeriksaan',
			'konsulpoli_id' => 'Konsulpoli',
			'hasilpemeriksaanrad_id' => 'Hasil Pemeriksaan Rad',
                        'detailhasilpemeriksaanlab_id' => 'Detail Hasil Pemeriksaan Lab',
                        'rencanaoperasi_id' => 'Rencana Operasi',
                        'hasilpemeriksaanpa_id' => 'Hasil Pemeriksaan Pa',
                        'tarif_satuan' => 'Tarif Satuan',
                    
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
			'karcis_id' => 'Karcis',
			'keterangantindakan' => 'Keterangan Tindakan',
			'rencanatindakan_id'=>'Rencana Tindakan'
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('tindakanpelayanan_id',$this->tindakanpelayanan_id);
		$criteria->compare('penjamin_id',$this->penjamin_id);
		$criteria->compare('pasienadmisi_id',$this->pasienadmisi_id);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('kelaspelayanan_id',$this->kelaspelayanan_id);
		$criteria->compare('tipepaket_id',$this->tipepaket_id);
		$criteria->compare('instalasi_id',$this->instalasi_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('shift_id',$this->shift_id);
		$criteria->compare('pasienmasukpenunjang_id',$this->pasienmasukpenunjang_id);
		$criteria->compare('daftartindakan_id',$this->daftartindakan_id);
		$criteria->compare('carabayar_id',$this->carabayar_id);
		$criteria->compare('jeniskasuspenyakit_id',$this->jeniskasuspenyakit_id);
		$criteria->compare('LOWER(tgl_tindakan)',strtolower($this->tgl_tindakan),true);
		$criteria->compare('tarif_tindakan',$this->tarif_tindakan);
		$criteria->compare('LOWER(satuantindakan)',strtolower($this->satuantindakan),true);
		$criteria->compare('LOWER(qty_tindakan)',strtolower($this->qty_tindakan),true);
		$criteria->compare('cyto_tindakan',$this->cyto_tindakan);
		$criteria->compare('tarifcyto_tindakan',$this->tarifcyto_tindakan);
		$criteria->compare('LOWER(dokterpemeriksa1_id)',strtolower($this->dokterpemeriksa1_id),true);
		$criteria->compare('LOWER(dokterpemeriksa2_id)',strtolower($this->dokterpemeriksa2_id),true);
		$criteria->compare('LOWER(dokterpendamping_id)',strtolower($this->dokterpendamping_id),true);
		$criteria->compare('LOWER(dokteranastesi_id)',strtolower($this->dokteranastesi_id),true);
		$criteria->compare('LOWER(dokterdelegasi_id)',strtolower($this->dokterdelegasi_id),true);
		$criteria->compare('LOWER(bidan_id)',strtolower($this->bidan_id),true);
		$criteria->compare('LOWER(suster_id)',strtolower($this->suster_id),true);
		$criteria->compare('LOWER(perawat_id)',strtolower($this->perawat_id),true);
		$criteria->compare('kelastanggungan_id',$this->kelastanggungan_id);
		$criteria->compare('discount_tindakan',$this->discount_tindakan);
		$criteria->compare('subsidiasuransi_tindakan',$this->subsidiasuransi_tindakan);
		$criteria->compare('subsidipemerintah_tindakan',$this->subsidipemerintah_tindakan);
		$criteria->compare('subsisidirumahsakit_tindakan',$this->subsisidirumahsakit_tindakan);
		$criteria->compare('iurbiaya_tindakan',$this->iurbiaya_tindakan);
		$criteria->compare('LOWER(tm)',strtolower($this->tm),true);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
		$criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('tindakanpelayanan_id',$this->tindakanpelayanan_id);
		$criteria->compare('penjamin_id',$this->penjamin_id);
		$criteria->compare('pasienadmisi_id',$this->pasienadmisi_id);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('kelaspelayanan_id',$this->kelaspelayanan_id);
		$criteria->compare('tipepaket_id',$this->tipepaket_id);
		$criteria->compare('instalasi_id',$this->instalasi_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('shift_id',$this->shift_id);
		$criteria->compare('pasienmasukpenunjang_id',$this->pasienmasukpenunjang_id);
		$criteria->compare('daftartindakan_id',$this->daftartindakan_id);
		$criteria->compare('carabayar_id',$this->carabayar_id);
		$criteria->compare('jeniskasuspenyakit_id',$this->jeniskasuspenyakit_id);
		$criteria->compare('LOWER(tgl_tindakan)',strtolower($this->tgl_tindakan),true);
		$criteria->compare('tarif_tindakan',$this->tarif_tindakan);
		$criteria->compare('LOWER(satuantindakan)',strtolower($this->satuantindakan),true);
		$criteria->compare('LOWER(qty_tindakan)',strtolower($this->qty_tindakan),true);
		$criteria->compare('cyto_tindakan',$this->cyto_tindakan);
		$criteria->compare('tarifcyto_tindakan',$this->tarifcyto_tindakan);
		$criteria->compare('LOWER(dokterpemeriksa1_id)',strtolower($this->dokterpemeriksa1_id),true);
		$criteria->compare('LOWER(dokterpemeriksa2_id)',strtolower($this->dokterpemeriksa2_id),true);
		$criteria->compare('LOWER(dokterpendamping_id)',strtolower($this->dokterpendamping_id),true);
		$criteria->compare('LOWER(dokteranastesi_id)',strtolower($this->dokteranastesi_id),true);
		$criteria->compare('LOWER(dokterdelegasi_id)',strtolower($this->dokterdelegasi_id),true);
		$criteria->compare('LOWER(bidan_id)',strtolower($this->bidan_id),true);
		$criteria->compare('LOWER(suster_id)',strtolower($this->suster_id),true);
		$criteria->compare('LOWER(perawat_id)',strtolower($this->perawat_id),true);
		$criteria->compare('kelastanggungan_id',$this->kelastanggungan_id);
		$criteria->compare('discount_tindakan',$this->discount_tindakan);
		$criteria->compare('subsidiasuransi_tindakan',$this->subsidiasuransi_tindakan);
		$criteria->compare('subsidipemerintah_tindakan',$this->subsidipemerintah_tindakan);
		$criteria->compare('subsisidirumahsakit_tindakan',$this->subsisidirumahsakit_tindakan);
		$criteria->compare('iurbiaya_tindakan',$this->iurbiaya_tindakan);
		$criteria->compare('LOWER(tm)',strtolower($this->tm),true);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
		$criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
        
        protected function beforeSave() {
            if(trim($this->dokterpemeriksa1_id == "")) $this->setAttribute('dokterpemeriksa1_id', null);
            if(trim($this->dokterpemeriksa2_id == "")) $this->setAttribute('dokterpemeriksa2_id', null);
            if(trim($this->dokterpendamping_id == "")) $this->setAttribute('dokterpendamping_id', null);
            if(trim($this->dokteranastesi_id == "")) $this->setAttribute('dokteranastesi_id', null);
            if(trim($this->dokterdelegasi_id == "")) $this->setAttribute('dokterdelegasi_id', null);
            if(trim($this->bidan_id == "")) $this->setAttribute('bidan_id', null);
            if(trim($this->suster_id == "")) $this->setAttribute('suster_id', null);
            if(trim($this->perawat_id == "")) $this->setAttribute('perawat_id', null);
            
            
            return parent::beforeSave();
        }
        
        protected function afterSave() {
            parent::afterSave();
            
            $this->checkSudahbayar();
        }
        
        function checkSudahBayar() {
            $pendaftaran = PendaftaranT::model()->findByPk($this->pendaftaran_id);
            $adm = PasienadmisiT::model()->findByAttributes(array('pendaftaran_id'=>$pendaftaran->pendaftaran_id));
            
            if ($this->cekTindakanOa()) {
                // echo $this->pendaftaran_id; die;
                PendaftaranT::model()->updateByPk($this->pendaftaran_id, array(
                    'pembayaranpelayanan_id'=>null,
                ));
                if (!empty($adm)) {
                    PasienadmisiT::model()->updateByPk($adm->pasienadmisi_id, array(
                        'pembayaranpelayanan_id'=>null,
                    ));
                }
            }
        }

        function cekTindakanOa() {
            $tindakan = self::model()->findAllByAttributes(array(
                'pendaftaran_id'=>$this->pendaftaran_id,
            ), array(
                'condition'=>'tindakansudahbayar_id is null',
            ));
            
            $oa = ObatalkespasienT::model()->findAllByAttributes(array(
                'pendaftaran_id'=>$this->pendaftaran_id,
            ), array(
                'condition'=>'oasudahbayar_id is null',
            ));
            
            return (count($tindakan) + count($oa)) > 0;
        }



//        FUNGSI INI JANGAN DIGUNAKAN LAGI (BERLAKU DI SEMUA MODEL) KARENA SERING TERJADI ERROR KETIKA UPDATE
//        protected function afterFind(){
//            foreach($this->metadata->tableSchema->columns as $columnName => $column){
//
//                if (!strlen($this->$columnName)) continue;
//
//                if ($column->dbType == 'date'){                         
//                        $this->$columnName = Yii::app()->dateFormatter->formatDateTime(
//                                        CDateTimeParser::parse($this->$columnName, 'yyyy-MM-dd'),'medium',null);
//                }else if ($column->dbType == 'timestamp without time zone'){
//                        $this->$columnName = Yii::app()->dateFormatter->formatDateTime(
//                                CDateTimeParser::parse($this->$columnName, 'yyyy-MM-dd hh:mm:ss','medium',null));
//                }
//            }
//            return true;
//        }
        
        protected function beforeValidate ()
        {
            $format = new MyFormatter();
            foreach($this->metadata->tableSchema->columns as $columnName => $column)
            {
                if ($column->dbType == 'date')
                {
                        $this->$columnName = $format->formatDateTimeForDb($this->$columnName);
                }elseif ($column->dbType == 'timestamp without time zone')
                {
                        $this->$columnName = $format->formatDateTimeForDb($this->$columnName);
                }
            }
            return parent::beforeValidate();
        }        

        
        public function getTipePaketItems($carabayar_id = '')
        {
            if(!empty($carabayar_id))
            {
                $tipePaket = TipepaketM::model()->findAllByAttributes(
                    array(
                        'tipepaket_aktif' => true,
                        'carabayar_id' => $carabayar_id
                    )
                );
                
                if(empty($tipePaket))
                {
                    $tipePaket = TipepaketM::model()->findAllByPk((int)Params::TIPEPAKET_ID_NONPAKET);
                }
                return $tipePaket;
            }else
                return TipepaketM::model()->findAllByAttributes(array('tipepaket_aktif'=>true));
        }
		
		/**
		 * untuk menyimpan tindakankomponen_t
		 * RND-6249
		 * untuk function proses simpan seharusnya di controller (function ini pengecualian)
		 */
		public function saveTindakanKomponen(){
			$tindakankomponentersimpan = true;
			
			return $tindakankomponentersimpan;
		}

		/**
		 * menampilkan tarif satuan terupdate RND-7248
		 */
		public function getTarifSatuan(){
			$tarif_satuan = 0;
			//recheck tarif  menggunakan DAO agar lebih cepat 
			$sql = "SELECT tariftindakan_m.*, daftartindakan_m.daftartindakan_nama
					FROM tariftindakan_m
					JOIN daftartindakan_m ON daftartindakan_m.daftartindakan_id = tariftindakan_m.daftartindakan_id
					JOIN jenistarifpenjamin_m ON jenistarifpenjamin_m.jenistarif_id = tariftindakan_m.jenistarif_id
					WHERE tariftindakan_m.komponentarif_id = ".Params::KOMPONENTARIF_ID_TOTAL." 
						AND tariftindakan_m.daftartindakan_id = ".$this->daftartindakan_id."
						AND tariftindakan_m.kelaspelayanan_id = ".$this->kelaspelayanan_id."
						AND jenistarifpenjamin_m.penjamin_id = ".$this->penjamin_id."
					";
			$loadData = Yii::app()->db->createCommand($sql)->queryRow();
			if(isset($loadData['harga_tariftindakan'])){
				$tarif_satuan = $loadData['harga_tariftindakan']; 
			}
			return $tarif_satuan;
		}

		/**
        * menampilkan nilai yang disubsidi, $attr:
        * - subsidiasuransitind
        * - subsidipemerintahtind
        * - subsidirumahsakittind
        */
        public function getSubsidiPenjamin($attr){
        	$modAsuransipasien = AsuransipasienM::model()->findByPk($this->pendaftaran->asuransipasien_id);
        	if($modAsuransipasien){
        		$modTanggungan = TanggunganpenjaminM::model()->findByAttributes(array('kelaspelayanan_id'=>$modAsuransipasien->kelastanggunganasuransi_id,'penjamin_id'=>$modAsuransipasien->penjamin_id));
        		$modTanggungan2 = CHtml::listData(TanggunganpenjaminM::model()->findAllByAttributes(array('penjamin_id'=>$modAsuransipasien->penjamin_id)), 'kelaspelayanan_id', 'kelaspelayanan_id');
                        if($modTanggungan){
        			$sql_tarif = "SELECT tariftindakan_m.* 
							FROM tariftindakan_m 
							JOIN jenistarifpenjamin_m ON jenistarifpenjamin_m.jenistarif_id = tariftindakan_m.jenistarif_id
							WHERE daftartindakan_id = ".$this->daftartindakan_id." ";
                                if ($modTanggungan->carabayar_id == Params::CARABAYAR_ID_JAMKESPA && in_array($this->instalasi_id, array(
                                    Params::INSTALASI_ID_RJ,
                                    Params::INSTALASI_ID_RD,
                                    Params::INSTALASI_ID_LAB,
                                    Params::INSTALASI_ID_RAD,
                                    Params::INSTALASI_ID_REHAB,
                                    Params::INSTALASI_ID_ICU,
                                ))) {
                                    $sql_tarif .= ""; //"AND tariftindakan_m.kelaspelayanan_id in (".Params::KELASPELAYANAN_ID_TANPA_KELAS.", ".$modTanggungan->kelaspelayanan_id.") ";
                                } else {
                                    // $sql_tarif .= "AND tariftindakan_m.kelaspelayanan_id = ".$modTanggungan->kelaspelayanan_id." ";
                                    $sql_tarif .= "AND tariftindakan_m.kelaspelayanan_id in (".implode(",", $modTanggungan2).") ";
                                }
							
				$sql_tarif .= "AND tariftindakan_m.komponentarif_id = ".Params::KOMPONENTARIF_ID_TOTAL."
							AND jenistarifpenjamin_m.penjamin_id = ".$modTanggungan->penjamin_id;

                                        $dataTarif = Yii::app()->db->createCommand($sql_tarif)->queryRow();
					if(isset($dataTarif['harga_tariftindakan'])){
						$subsidi = ($dataTarif['harga_tariftindakan'] * $modTanggungan->$attr /100);
						if($this->tarif_satuan >= $subsidi){
							return $subsidi * $this->qty_tindakan;
						}else{
							return $this->tarif_satuan * $this->qty_tindakan;
						}
					}else{
						return 0;
					}
        		}else{
        			return 0;
        		}
        	}else{
        		return 0;
        	}
        }
}