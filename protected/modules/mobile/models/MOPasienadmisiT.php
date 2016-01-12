<?php

/**
 * This is the model class for table "pasienadmisi_t".
 *
 * The followings are the available columns in table 'pasienadmisi_t':
 * @property integer $pasienadmisi_id
 * @property integer $shift_id
 * @property integer $carabayar_id
 * @property integer $penjamin_id
 * @property integer $pasien_id
 * @property integer $caramasuk_id
 * @property integer $ruangan_id
 * @property integer $pasienpulang_id
 * @property integer $bookingkamar_id
 * @property integer $pembayaranpelayanan_id
 * @property integer $pendaftaran_id
 * @property integer $kamarruangan_id
 * @property integer $kelaspelayanan_id
 * @property integer $pegawai_id
 * @property string $tgladmisi
 * @property string $tglpendaftaran
 * @property string $tglpulang
 * @property string $kunjungan
 * @property boolean $statuskeluar
 * @property boolean $rawatgabung
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 * @property string $rencanapulang
 * @property boolean $statusfarmasi
 *
 * The followings are the available model relations:
 * @property PendaftaranT[] $pendaftaranTs
 * @property AnamnesaT[] $anamnesaTs
 * @property HasilpemeriksaanradT[] $hasilpemeriksaanradTs
 * @property PasienmasukpenunjangT[] $pasienmasukpenunjangTs
 * @property HasilpemeriksaanlabT[] $hasilpemeriksaanlabTs
 * @property ObatalkespasienT[] $obatalkespasienTs
 * @property PasiendirujukkeluarT[] $pasiendirujukkeluarTs
 * @property BookingkamarT $bookingkamar
 * @property CarabayarM $carabayar
 * @property CaramasukM $caramasuk
 * @property KamarruanganM $kamarruangan
 * @property KelaspelayananM $kelaspelayanan
 * @property PasienM $pasien
 * @property PegawaiM $pegawai
 * @property PembayaranpelayananT $pembayaranpelayanan
 * @property PendaftaranT $pendaftaran
 * @property PenjaminpasienM $penjamin
 * @property RuanganM $ruangan
 * @property ShiftM $shift
 * @property ResepturT[] $resepturTs
 * @property PasienpulangT[] $pasienpulangTs
 * @property AsuhankeperawatanT[] $asuhankeperawatanTs
 * @property RencanaoperasiT[] $rencanaoperasiTs
 * @property PindahkamarT[] $pindahkamarTs
 * @property KirimmenupasienT[] $kirimmenupasienTs
 * @property KonsulpoliT[] $konsulpoliTs
 * @property PembayaranpelayananT[] $pembayaranpelayananTs
 * @property PesanmenudetailT[] $pesanmenudetailTs
 * @property PemeriksaanfisikT[] $pemeriksaanfisikTs
 * @property PembjasadetailT[] $pembjasadetailTs
 * @property PasienbatalrawatR[] $pasienbatalrawatRs
 * @property PasienapachescoreT[] $pasienapachescoreTs
 * @property PasienmorbiditasT[] $pasienmorbiditasTs
 * @property ReturresepT[] $returresepTs
 * @property TindakanpelayananT[] $tindakanpelayananTs
 * @property HasilpemeriksaanpaT[] $hasilpemeriksaanpaTs
 * @property HasilpemeriksaanrmT[] $hasilpemeriksaanrmTs
 * @property DietpasienT[] $dietpasienTs
 * @property MasukkamarT[] $masukkamarTs
 * @property BayaruangmukaT[] $bayaruangmukaTs
 * @property BookingkamarT[] $bookingkamarTs
 * @property AnamesadietT[] $anamesadietTs
 * @property PenjualanresepT[] $penjualanresepTs
 */
class MOPasienadmisiT extends CActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return MOPasienadmisiT the static model class
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
        return 'pasienadmisi_t';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('shift_id, carabayar_id, penjamin_id, pasien_id, caramasuk_id, ruangan_id, kelaspelayanan_id, tgladmisi, tglpendaftaran, kunjungan, create_time, create_loginpemakai_id, create_ruangan', 'required'),
            array('shift_id, carabayar_id, penjamin_id, pasien_id, caramasuk_id, ruangan_id, pasienpulang_id, bookingkamar_id, pembayaranpelayanan_id, pendaftaran_id, kamarruangan_id, kelaspelayanan_id, pegawai_id', 'numerical', 'integerOnly'=>true),
            array('kunjungan', 'length', 'max'=>50),
            array('tglpulang, statuskeluar, rawatgabung, update_time, update_loginpemakai_id, rencanapulang, statusfarmasi', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('pasienadmisi_id, shift_id, carabayar_id, penjamin_id, pasien_id, caramasuk_id, ruangan_id, pasienpulang_id, bookingkamar_id, pembayaranpelayanan_id, pendaftaran_id, kamarruangan_id, kelaspelayanan_id, pegawai_id, tgladmisi, tglpendaftaran, tglpulang, kunjungan, statuskeluar, rawatgabung, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, rencanapulang, statusfarmasi', 'safe', 'on'=>'search'),
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
            'pendaftaranTs' => array(self::HAS_MANY, 'PendaftaranT', 'pasienadmisi_id'),
            'anamnesaTs' => array(self::HAS_MANY, 'AnamnesaT', 'pasienadmisi_id'),
            'hasilpemeriksaanradTs' => array(self::HAS_MANY, 'HasilpemeriksaanradT', 'pasienadmisi_id'),
            'pasienmasukpenunjangTs' => array(self::HAS_MANY, 'PasienmasukpenunjangT', 'pasienadmisi_id'),
            'hasilpemeriksaanlabTs' => array(self::HAS_MANY, 'HasilpemeriksaanlabT', 'pasienadmisi_id'),
            'obatalkespasienTs' => array(self::HAS_MANY, 'ObatalkespasienT', 'pasienadmisi_id'),
            'pasiendirujukkeluarTs' => array(self::HAS_MANY, 'PasiendirujukkeluarT', 'pasienadmisi_id'),
            'bookingkamar' => array(self::BELONGS_TO, 'BookingkamarT', 'bookingkamar_id'),
            'carabayar' => array(self::BELONGS_TO, 'CarabayarM', 'carabayar_id'),
            'caramasuk' => array(self::BELONGS_TO, 'CaramasukM', 'caramasuk_id'),
            'kamarruangan' => array(self::BELONGS_TO, 'KamarruanganM', 'kamarruangan_id'),
            'kelaspelayanan' => array(self::BELONGS_TO, 'KelaspelayananM', 'kelaspelayanan_id'),
            'pasien' => array(self::BELONGS_TO, 'PasienM', 'pasien_id'),
            'pegawai' => array(self::BELONGS_TO, 'PegawaiM', 'pegawai_id'),
            'pembayaranpelayanan' => array(self::BELONGS_TO, 'PembayaranpelayananT', 'pembayaranpelayanan_id'),
            'pendaftaran' => array(self::BELONGS_TO, 'PendaftaranT', 'pendaftaran_id'),
            'penjamin' => array(self::BELONGS_TO, 'PenjaminpasienM', 'penjamin_id'),
            'ruangan' => array(self::BELONGS_TO, 'RuanganM', 'ruangan_id'),
            'shift' => array(self::BELONGS_TO, 'ShiftM', 'shift_id'),
            'resepturTs' => array(self::HAS_MANY, 'ResepturT', 'pasienadmisi_id'),
            'pasienpulangTs' => array(self::HAS_MANY, 'PasienpulangT', 'pasienadmisi_id'),
            'asuhankeperawatanTs' => array(self::HAS_MANY, 'AsuhankeperawatanT', 'pasienadmisi_id'),
            'rencanaoperasiTs' => array(self::HAS_MANY, 'RencanaoperasiT', 'pasienadmisi_id'),
            'pindahkamarTs' => array(self::HAS_MANY, 'PindahkamarT', 'pasienadmisi_id'),
            'kirimmenupasienTs' => array(self::HAS_MANY, 'KirimmenupasienT', 'pasienadmisi_id'),
            'konsulpoliTs' => array(self::HAS_MANY, 'KonsulpoliT', 'pasienadmisi_id'),
            'pembayaranpelayananTs' => array(self::HAS_MANY, 'PembayaranpelayananT', 'pasienadmisi_id'),
            'pesanmenudetailTs' => array(self::HAS_MANY, 'PesanmenudetailT', 'pasienadmisi_id'),
            'pemeriksaanfisikTs' => array(self::HAS_MANY, 'PemeriksaanfisikT', 'pasienadmisi_id'),
            'pembjasadetailTs' => array(self::HAS_MANY, 'PembjasadetailT', 'pasienadmisi_id'),
            'pasienbatalrawatRs' => array(self::HAS_MANY, 'PasienbatalrawatR', 'pasienadmisi_id'),
            'pasienapachescoreTs' => array(self::HAS_MANY, 'PasienapachescoreT', 'pasienadmisi_id'),
            'pasienmorbiditasTs' => array(self::HAS_MANY, 'PasienmorbiditasT', 'pasienadmisi_id'),
            'returresepTs' => array(self::HAS_MANY, 'ReturresepT', 'pasienadmisi_id'),
            'tindakanpelayananTs' => array(self::HAS_MANY, 'TindakanpelayananT', 'pasienadmisi_id'),
            'hasilpemeriksaanpaTs' => array(self::HAS_MANY, 'HasilpemeriksaanpaT', 'pasienadmisi_id'),
            'hasilpemeriksaanrmTs' => array(self::HAS_MANY, 'HasilpemeriksaanrmT', 'pasienadmisi_id'),
            'dietpasienTs' => array(self::HAS_MANY, 'DietpasienT', 'pasienadmisi_id'),
            'masukkamarTs' => array(self::HAS_MANY, 'MasukkamarT', 'pasienadmisi_id'),
            'bayaruangmukaTs' => array(self::HAS_MANY, 'BayaruangmukaT', 'pasienadmisi_id'),
            'bookingkamarTs' => array(self::HAS_MANY, 'BookingkamarT', 'pasienadmisi_id'),
            'anamesadietTs' => array(self::HAS_MANY, 'AnamesadietT', 'pasienadmisi_id'),
            'penjualanresepTs' => array(self::HAS_MANY, 'PenjualanresepT', 'pasienadmisi_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'pasienadmisi_id' => 'Pasienadmisi',
            'shift_id' => 'Shift',
            'carabayar_id' => 'Carabayar',
            'penjamin_id' => 'Penjamin',
            'pasien_id' => 'Pasien',
            'caramasuk_id' => 'Caramasuk',
            'ruangan_id' => 'Ruangan',
            'pasienpulang_id' => 'Pasienpulang',
            'bookingkamar_id' => 'Bookingkamar',
            'pembayaranpelayanan_id' => 'Pembayaranpelayanan',
            'pendaftaran_id' => 'Pendaftaran',
            'kamarruangan_id' => 'Kamarruangan',
            'kelaspelayanan_id' => 'Kelaspelayanan',
            'pegawai_id' => 'Pegawai',
            'tgladmisi' => 'Tgladmisi',
            'tglpendaftaran' => 'Tglpendaftaran',
            'tglpulang' => 'Tglpulang',
            'kunjungan' => 'Kunjungan',
            'statuskeluar' => 'Statuskeluar',
            'rawatgabung' => 'Rawatgabung',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
            'create_loginpemakai_id' => 'Create Loginpemakai',
            'update_loginpemakai_id' => 'Update Loginpemakai',
            'create_ruangan' => 'Create Ruangan',
            'rencanapulang' => 'Rencanapulang',
            'statusfarmasi' => 'Statusfarmasi',
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

        if(!empty($this->pasienadmisi_id)){
            $criteria->addCondition('pasienadmisi_id = '.$this->pasienadmisi_id);
        }
        if(!empty($this->shift_id)){
            $criteria->addCondition('shift_id = '.$this->shift_id);
        }
        if(!empty($this->carabayar_id)){
            $criteria->addCondition('carabayar_id = '.$this->carabayar_id);
        }
        if(!empty($this->penjamin_id)){
            $criteria->addCondition('penjamin_id = '.$this->penjamin_id);
        }
        if(!empty($this->pasien_id)){
            $criteria->addCondition('pasien_id = '.$this->pasien_id);
        }
        if(!empty($this->caramasuk_id)){
            $criteria->addCondition('caramasuk_id = '.$this->caramasuk_id);
        }
        if(!empty($this->ruangan_id)){
            $criteria->addCondition('ruangan_id = '.$this->ruangan_id);
        }
        if(!empty($this->pasienpulang_id)){
            $criteria->addCondition('pasienpulang_id = '.$this->pasienpulang_id);
        }
        if(!empty($this->bookingkamar_id)){
            $criteria->addCondition('bookingkamar_id = '.$this->bookingkamar_id);
        }
        if(!empty($this->pembayaranpelayanan_id)){
            $criteria->addCondition('pembayaranpelayanan_id = '.$this->pembayaranpelayanan_id);
        }
        if(!empty($this->pendaftaran_id)){
            $criteria->addCondition('pendaftaran_id = '.$this->pendaftaran_id);
        }
        if(!empty($this->kamarruangan_id)){
            $criteria->addCondition('kamarruangan_id = '.$this->kamarruangan_id);
        }
        if(!empty($this->kelaspelayanan_id)){
            $criteria->addCondition('kelaspelayanan_id = '.$this->kelaspelayanan_id);
        }
        if(!empty($this->pegawai_id)){
            $criteria->addCondition('pegawai_id = '.$this->pegawai_id);
        }
        $criteria->compare('LOWER(tgladmisi)',strtolower($this->tgladmisi),true);
        $criteria->compare('LOWER(tglpendaftaran)',strtolower($this->tglpendaftaran),true);
        $criteria->compare('LOWER(tglpulang)',strtolower($this->tglpulang),true);
        $criteria->compare('LOWER(kunjungan)',strtolower($this->kunjungan),true);
        $criteria->compare('statuskeluar',$this->statuskeluar);
        $criteria->compare('rawatgabung',$this->rawatgabung);
        $criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
        $criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
        $criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
        $criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
        $criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);
        $criteria->compare('LOWER(rencanapulang)',strtolower($this->rencanapulang),true);
        $criteria->compare('statusfarmasi',$this->statusfarmasi);

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
}