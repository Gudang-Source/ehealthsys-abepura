<?php

/**
 * This is the model class for table "tindakanpelayanan_t".
 *
 * The followings are the available columns in table 'tindakanpelayanan_t':
 * @property integer $tindakanpelayanan_id
 * @property integer $detailhasilpemeriksaanlab_id
 * @property integer $shift_id
 * @property integer $kelaspelayanan_id
 * @property integer $pasien_id
 * @property integer $rencanaoperasi_id
 * @property integer $instalasi_id
 * @property integer $daftartindakan_id
 * @property integer $alatmedis_id
 * @property integer $tipepaket_id
 * @property integer $tindakansudahbayar_id
 * @property integer $karcis_id
 * @property integer $carabayar_id
 * @property integer $pendaftaran_id
 * @property integer $hasilpemeriksaanrad_id
 * @property integer $jeniskasuspenyakit_id
 * @property integer $hasilpemeriksaanrm_id
 * @property integer $ruangan_id
 * @property integer $konsulpoli_id
 * @property integer $pasienmasukpenunjang_id
 * @property integer $hasilpemeriksaanpa_id
 * @property integer $penjamin_id
 * @property integer $pasienadmisi_id
 * @property string $tgl_tindakan
 * @property double $tarif_rsakomodasi
 * @property double $tarif_medis
 * @property double $tarif_paramedis
 * @property double $tarif_bhp
 * @property double $tarif_satuan
 * @property double $tarif_tindakan
 * @property string $satuantindakan
 * @property integer $qty_tindakan
 * @property boolean $cyto_tindakan
 * @property double $tarifcyto_tindakan
 * @property string $dokterpemeriksa1_id
 * @property string $dokterpemeriksa2_id
 * @property string $dokterpendamping_id
 * @property string $dokteranastesi_id
 * @property string $dokterdelegasi_id
 * @property string $bidan_id
 * @property string $suster_id
 * @property integer $perawat_id
 * @property integer $kelastanggungan_id
 * @property double $discount_tindakan
 * @property double $pembebasan_tindakan
 * @property double $subsidiasuransi_tindakan
 * @property double $subsidipemerintah_tindakan
 * @property double $subsisidirumahsakit_tindakan
 * @property double $iurbiaya_tindakan
 * @property string $tm
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 * @property integer $verifikasitagihan_id
 * @property integer $jurnalrekening_id
 * @property string $keterangantindakan
 *
 * The followings are the available model relations:
 * @property ObatalkespasienT[] $obatalkespasienTs
 * @property KonsulpoliT[] $konsulpoliTs
 * @property TindakansudahbayarT[] $tindakansudahbayarTs
 * @property HasilpemeriksaanradT $hasilpemeriksaanrad
 * @property TindakansudahbayarT $tindakansudahbayar
 * @property AlatmedisM $alatmedis
 * @property PegawaiM $bidan
 * @property CarabayarM $carabayar
 * @property DaftartindakanM $daftartindakan
 * @property DetailhasilpemeriksaanlabT $detailhasilpemeriksaanlab
 * @property PegawaiM $dokteranastesi
 * @property PegawaiM $dokterdelegasi
 * @property PegawaiM $dokterpemeriksa1
 * @property PegawaiM $dokterpemeriksa2
 * @property PegawaiM $dokterpendamping
 * @property HasilpemeriksaanrmT $hasilpemeriksaanrm
 * @property HasilpemeriksaanpaT $hasilpemeriksaanpa
 * @property InstalasiM $instalasi
 * @property JeniskasuspenyakitM $jeniskasuspenyakit
 * @property KarcisM $karcis
 * @property KelaspelayananM $kelaspelayanan
 * @property KelaspelayananM $kelastanggungan
 * @property KonsulpoliT $konsulpoli
 * @property PasienM $pasien
 * @property PasienadmisiT $pasienadmisi
 * @property PasienmasukpenunjangT $pasienmasukpenunjang
 * @property PendaftaranT $pendaftaran
 * @property PenjaminpasienM $penjamin
 * @property PegawaiM $perawat
 * @property RencanaoperasiT $rencanaoperasi
 * @property RuanganM $ruangan
 * @property ShiftM $shift
 * @property PegawaiM $suster
 * @property TipepaketM $tipepaket
 * @property VerifikasitagihanT $verifikasitagihan
 * @property JurnalrekeningT $jurnalrekening
 * @property RencanaoperasiT[] $rencanaoperasiTs
 * @property HasilpemeriksaanpaT[] $hasilpemeriksaanpaTs
 * @property DetailhasilpemeriksaanlabT[] $detailhasilpemeriksaanlabTs
 * @property TindakankomponenT[] $tindakankomponenTs
 * @property PembebasantarifT[] $pembebasantarifTs
 * @property HasilpemeriksaanrmT[] $hasilpemeriksaanrmTs
 */
class MOTindakanpelayananT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return MOTindakanpelayananT the static model class
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
			array('shift_id, kelaspelayanan_id, pasien_id, instalasi_id, daftartindakan_id, carabayar_id, pendaftaran_id, jeniskasuspenyakit_id, ruangan_id, penjamin_id, tgl_tindakan, tarif_rsakomodasi, tarif_medis, tarif_paramedis, tarif_bhp, tarif_satuan, tarif_tindakan, satuantindakan, cyto_tindakan, tarifcyto_tindakan, discount_tindakan, pembebasan_tindakan, subsidiasuransi_tindakan, subsidipemerintah_tindakan, subsisidirumahsakit_tindakan, iurbiaya_tindakan, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('detailhasilpemeriksaanlab_id, shift_id, kelaspelayanan_id, pasien_id, rencanaoperasi_id, instalasi_id, daftartindakan_id, alatmedis_id, tipepaket_id, tindakansudahbayar_id, karcis_id, carabayar_id, pendaftaran_id, hasilpemeriksaanrad_id, jeniskasuspenyakit_id, hasilpemeriksaanrm_id, ruangan_id, konsulpoli_id, pasienmasukpenunjang_id, hasilpemeriksaanpa_id, penjamin_id, pasienadmisi_id, qty_tindakan, perawat_id, kelastanggungan_id, verifikasitagihan_id, jurnalrekening_id', 'numerical', 'integerOnly'=>true),
			array('tarif_rsakomodasi, tarif_medis, tarif_paramedis, tarif_bhp, tarif_satuan, tarif_tindakan, tarifcyto_tindakan, discount_tindakan, pembebasan_tindakan, subsidiasuransi_tindakan, subsidipemerintah_tindakan, subsisidirumahsakit_tindakan, iurbiaya_tindakan', 'numerical'),
			array('satuantindakan', 'length', 'max'=>10),
			array('tm', 'length', 'max'=>2),
			array('keterangantindakan', 'length', 'max'=>200),
			array('dokterpemeriksa1_id, dokterpemeriksa2_id, dokterpendamping_id, dokteranastesi_id, dokterdelegasi_id, bidan_id, suster_id, update_time, update_loginpemakai_id', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('tindakanpelayanan_id, detailhasilpemeriksaanlab_id, shift_id, kelaspelayanan_id, pasien_id, rencanaoperasi_id, instalasi_id, daftartindakan_id, alatmedis_id, tipepaket_id, tindakansudahbayar_id, karcis_id, carabayar_id, pendaftaran_id, hasilpemeriksaanrad_id, jeniskasuspenyakit_id, hasilpemeriksaanrm_id, ruangan_id, konsulpoli_id, pasienmasukpenunjang_id, hasilpemeriksaanpa_id, penjamin_id, pasienadmisi_id, tgl_tindakan, tarif_rsakomodasi, tarif_medis, tarif_paramedis, tarif_bhp, tarif_satuan, tarif_tindakan, satuantindakan, qty_tindakan, cyto_tindakan, tarifcyto_tindakan, dokterpemeriksa1_id, dokterpemeriksa2_id, dokterpendamping_id, dokteranastesi_id, dokterdelegasi_id, bidan_id, suster_id, perawat_id, kelastanggungan_id, discount_tindakan, pembebasan_tindakan, subsidiasuransi_tindakan, subsidipemerintah_tindakan, subsisidirumahsakit_tindakan, iurbiaya_tindakan, tm, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, verifikasitagihan_id, jurnalrekening_id, keterangantindakan', 'safe', 'on'=>'search'),
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
			'obatalkespasienTs' => array(self::HAS_MANY, 'ObatalkespasienT', 'tindakanpelayanan_id'),
			'konsulpoliTs' => array(self::HAS_MANY, 'KonsulpoliT', 'tindakanpelayanan_id'),
			'tindakansudahbayarTs' => array(self::HAS_MANY, 'TindakansudahbayarT', 'tindakanpelayanan_id'),
			'hasilpemeriksaanrad' => array(self::BELONGS_TO, 'HasilpemeriksaanradT', 'hasilpemeriksaanrad_id'),
			'tindakansudahbayar' => array(self::BELONGS_TO, 'TindakansudahbayarT', 'tindakansudahbayar_id'),
			'alatmedis' => array(self::BELONGS_TO, 'AlatmedisM', 'alatmedis_id'),
			'bidan' => array(self::BELONGS_TO, 'PegawaiM', 'bidan_id'),
			'carabayar' => array(self::BELONGS_TO, 'CarabayarM', 'carabayar_id'),
			'daftartindakan' => array(self::BELONGS_TO, 'DaftartindakanM', 'daftartindakan_id'),
			'detailhasilpemeriksaanlab' => array(self::BELONGS_TO, 'DetailhasilpemeriksaanlabT', 'detailhasilpemeriksaanlab_id'),
			'dokteranastesi' => array(self::BELONGS_TO, 'PegawaiM', 'dokteranastesi_id'),
			'dokterdelegasi' => array(self::BELONGS_TO, 'PegawaiM', 'dokterdelegasi_id'),
			'dokterpemeriksa1' => array(self::BELONGS_TO, 'PegawaiM', 'dokterpemeriksa1_id'),
			'dokterpemeriksa2' => array(self::BELONGS_TO, 'PegawaiM', 'dokterpemeriksa2_id'),
			'dokterpendamping' => array(self::BELONGS_TO, 'PegawaiM', 'dokterpendamping_id'),
			'hasilpemeriksaanrm' => array(self::BELONGS_TO, 'HasilpemeriksaanrmT', 'hasilpemeriksaanrm_id'),
			'hasilpemeriksaanpa' => array(self::BELONGS_TO, 'HasilpemeriksaanpaT', 'hasilpemeriksaanpa_id'),
			'instalasi' => array(self::BELONGS_TO, 'InstalasiM', 'instalasi_id'),
			'jeniskasuspenyakit' => array(self::BELONGS_TO, 'JeniskasuspenyakitM', 'jeniskasuspenyakit_id'),
			'karcis' => array(self::BELONGS_TO, 'KarcisM', 'karcis_id'),
			'kelaspelayanan' => array(self::BELONGS_TO, 'KelaspelayananM', 'kelaspelayanan_id'),
			'kelastanggungan' => array(self::BELONGS_TO, 'KelaspelayananM', 'kelastanggungan_id'),
			'konsulpoli' => array(self::BELONGS_TO, 'KonsulpoliT', 'konsulpoli_id'),
			'pasien' => array(self::BELONGS_TO, 'PasienM', 'pasien_id'),
			'pasienadmisi' => array(self::BELONGS_TO, 'PasienadmisiT', 'pasienadmisi_id'),
			'pasienmasukpenunjang' => array(self::BELONGS_TO, 'PasienmasukpenunjangT', 'pasienmasukpenunjang_id'),
			'pendaftaran' => array(self::BELONGS_TO, 'PendaftaranT', 'pendaftaran_id'),
			'penjamin' => array(self::BELONGS_TO, 'PenjaminpasienM', 'penjamin_id'),
			'perawat' => array(self::BELONGS_TO, 'PegawaiM', 'perawat_id'),
			'rencanaoperasi' => array(self::BELONGS_TO, 'RencanaoperasiT', 'rencanaoperasi_id'),
			'ruangan' => array(self::BELONGS_TO, 'RuanganM', 'ruangan_id'),
			'shift' => array(self::BELONGS_TO, 'ShiftM', 'shift_id'),
			'suster' => array(self::BELONGS_TO, 'PegawaiM', 'suster_id'),
			'tipepaket' => array(self::BELONGS_TO, 'TipepaketM', 'tipepaket_id'),
			'verifikasitagihan' => array(self::BELONGS_TO, 'VerifikasitagihanT', 'verifikasitagihan_id'),
			'jurnalrekening' => array(self::BELONGS_TO, 'JurnalrekeningT', 'jurnalrekening_id'),
			'rencanaoperasiTs' => array(self::HAS_MANY, 'RencanaoperasiT', 'tindakanpelayanan_id'),
			'hasilpemeriksaanpaTs' => array(self::HAS_MANY, 'HasilpemeriksaanpaT', 'tindakanpelayanan_id'),
			'detailhasilpemeriksaanlabTs' => array(self::HAS_MANY, 'DetailhasilpemeriksaanlabT', 'tindakanpelayanan_id'),
			'tindakankomponenTs' => array(self::HAS_MANY, 'TindakankomponenT', 'tindakanpelayanan_id'),
			'pembebasantarifTs' => array(self::HAS_MANY, 'PembebasantarifT', 'tindakanpelayanan_id'),
			'hasilpemeriksaanrmTs' => array(self::HAS_MANY, 'HasilpemeriksaanrmT', 'tindakanpelayanan_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'tindakanpelayanan_id' => 'Tindakanpelayanan',
			'detailhasilpemeriksaanlab_id' => 'Detailhasilpemeriksaanlab',
			'shift_id' => 'Shift',
			'kelaspelayanan_id' => 'Kelaspelayanan',
			'pasien_id' => 'Pasien',
			'rencanaoperasi_id' => 'Rencanaoperasi',
			'instalasi_id' => 'Instalasi',
			'daftartindakan_id' => 'Daftartindakan',
			'alatmedis_id' => 'Alatmedis',
			'tipepaket_id' => 'Tipepaket',
			'tindakansudahbayar_id' => 'Tindakansudahbayar',
			'karcis_id' => 'Karcis',
			'carabayar_id' => 'Carabayar',
			'pendaftaran_id' => 'Pendaftaran',
			'hasilpemeriksaanrad_id' => 'Hasilpemeriksaanrad',
			'jeniskasuspenyakit_id' => 'Jeniskasuspenyakit',
			'hasilpemeriksaanrm_id' => 'Hasilpemeriksaanrm',
			'ruangan_id' => 'Ruangan',
			'konsulpoli_id' => 'Konsulpoli',
			'pasienmasukpenunjang_id' => 'Pasienmasukpenunjang',
			'hasilpemeriksaanpa_id' => 'Hasilpemeriksaanpa',
			'penjamin_id' => 'Penjamin',
			'pasienadmisi_id' => 'Pasienadmisi',
			'tgl_tindakan' => 'Tgl. Tindakan',
			'tarif_rsakomodasi' => 'Tarif Rsakomodasi',
			'tarif_medis' => 'Tarif Medis',
			'tarif_paramedis' => 'Tarif Paramedis',
			'tarif_bhp' => 'Tarif Bhp',
			'tarif_satuan' => 'Tarif Satuan',
			'tarif_tindakan' => 'Tarif Tindakan',
			'satuantindakan' => 'Satuantindakan',
			'qty_tindakan' => 'Jumlah Tindakan',
			'cyto_tindakan' => 'Cyto Tindakan',
			'tarifcyto_tindakan' => 'Tarifcyto Tindakan',
			'dokterpemeriksa1_id' => 'Dokterpemeriksa1',
			'dokterpemeriksa2_id' => 'Dokterpemeriksa2',
			'dokterpendamping_id' => 'Dokterpendamping',
			'dokteranastesi_id' => 'Dokteranastesi',
			'dokterdelegasi_id' => 'Dokterdelegasi',
			'bidan_id' => 'Bidan',
			'suster_id' => 'Suster',
			'perawat_id' => 'Perawat',
			'kelastanggungan_id' => 'Kelastanggungan',
			'discount_tindakan' => 'Discount Tindakan',
			'pembebasan_tindakan' => 'Pembebasan Tindakan',
			'subsidiasuransi_tindakan' => 'Subsidiasuransi Tindakan',
			'subsidipemerintah_tindakan' => 'Subsidipemerintah Tindakan',
			'subsisidirumahsakit_tindakan' => 'Subsisidirumahsakit Tindakan',
			'iurbiaya_tindakan' => 'Iurbiaya Tindakan',
			'tm' => 'Tm',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'create_loginpemakai_id' => 'Create Loginpemakai',
			'update_loginpemakai_id' => 'Update Loginpemakai',
			'create_ruangan' => 'Create Ruangan',
			'verifikasitagihan_id' => 'Verifikasitagihan',
			'jurnalrekening_id' => 'Jurnalrekening',
			'keterangantindakan' => 'Keterangantindakan',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CdbCriteria that can return criterias.
	 */
	public function criteriaSearch()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('tindakanpelayanan_id',$this->tindakanpelayanan_id);
		$criteria->compare('detailhasilpemeriksaanlab_id',$this->detailhasilpemeriksaanlab_id);
		$criteria->compare('shift_id',$this->shift_id);
		$criteria->compare('kelaspelayanan_id',$this->kelaspelayanan_id);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('rencanaoperasi_id',$this->rencanaoperasi_id);
		$criteria->compare('instalasi_id',$this->instalasi_id);
		$criteria->compare('daftartindakan_id',$this->daftartindakan_id);
		$criteria->compare('alatmedis_id',$this->alatmedis_id);
		$criteria->compare('tipepaket_id',$this->tipepaket_id);
		$criteria->compare('tindakansudahbayar_id',$this->tindakansudahbayar_id);
		$criteria->compare('karcis_id',$this->karcis_id);
		$criteria->compare('carabayar_id',$this->carabayar_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('hasilpemeriksaanrad_id',$this->hasilpemeriksaanrad_id);
		$criteria->compare('jeniskasuspenyakit_id',$this->jeniskasuspenyakit_id);
		$criteria->compare('hasilpemeriksaanrm_id',$this->hasilpemeriksaanrm_id);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('konsulpoli_id',$this->konsulpoli_id);
		$criteria->compare('pasienmasukpenunjang_id',$this->pasienmasukpenunjang_id);
		$criteria->compare('hasilpemeriksaanpa_id',$this->hasilpemeriksaanpa_id);
		$criteria->compare('penjamin_id',$this->penjamin_id);
		$criteria->compare('pasienadmisi_id',$this->pasienadmisi_id);
		$criteria->compare('LOWER(tgl_tindakan)',strtolower($this->tgl_tindakan),true);
		$criteria->compare('tarif_rsakomodasi',$this->tarif_rsakomodasi);
		$criteria->compare('tarif_medis',$this->tarif_medis);
		$criteria->compare('tarif_paramedis',$this->tarif_paramedis);
		$criteria->compare('tarif_bhp',$this->tarif_bhp);
		$criteria->compare('tarif_satuan',$this->tarif_satuan);
		$criteria->compare('tarif_tindakan',$this->tarif_tindakan);
		$criteria->compare('LOWER(satuantindakan)',strtolower($this->satuantindakan),true);
		$criteria->compare('qty_tindakan',$this->qty_tindakan);
		$criteria->compare('cyto_tindakan',$this->cyto_tindakan);
		$criteria->compare('tarifcyto_tindakan',$this->tarifcyto_tindakan);
		$criteria->compare('LOWER(dokterpemeriksa1_id)',strtolower($this->dokterpemeriksa1_id),true);
		$criteria->compare('LOWER(dokterpemeriksa2_id)',strtolower($this->dokterpemeriksa2_id),true);
		$criteria->compare('LOWER(dokterpendamping_id)',strtolower($this->dokterpendamping_id),true);
		$criteria->compare('LOWER(dokteranastesi_id)',strtolower($this->dokteranastesi_id),true);
		$criteria->compare('LOWER(dokterdelegasi_id)',strtolower($this->dokterdelegasi_id),true);
		$criteria->compare('LOWER(bidan_id)',strtolower($this->bidan_id),true);
		$criteria->compare('LOWER(suster_id)',strtolower($this->suster_id),true);
		$criteria->compare('perawat_id',$this->perawat_id);
		$criteria->compare('kelastanggungan_id',$this->kelastanggungan_id);
		$criteria->compare('discount_tindakan',$this->discount_tindakan);
		$criteria->compare('pembebasan_tindakan',$this->pembebasan_tindakan);
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
		$criteria->compare('verifikasitagihan_id',$this->verifikasitagihan_id);
		$criteria->compare('jurnalrekening_id',$this->jurnalrekening_id);
		$criteria->compare('LOWER(keterangantindakan)',strtolower($this->keterangantindakan),true);

		return $criteria;
	}
        
        
        /**
         * Retrieves a list of models based on the current search/filter conditions.
         * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
         */
        public function search()
        {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria=$this->criteriaSearch();
            $criteria->limit=10;

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));
        }


        public function searchPrint()
        {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria=$this->criteriaSearch();
            $criteria->limit=-1; 

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
                    'pagination'=>false,
            ));
        }
		
		/**
		 * untuk menyimpan tindakankomponen_t
		 * RND-6249
		 */
		public function saveTindakanKomponen(){
			$tindakankomponentersimpan = true;
			/* TRIGGER DILAKUKAN DI DATABASE (RND-8014)
			 * 
			 */
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
}