<?php

/**
 * This is the model class for table "obatalkespasien_t".
 *
 * The followings are the available columns in table 'obatalkespasien_t':
 * @property integer $obatalkespasien_id
 * @property integer $sumberdana_id
 * @property integer $racikan_id
 * @property integer $returresepdet_id
 * @property integer $tipepaket_id
 * @property integer $ruangan_id
 * @property integer $carabayar_id
 * @property integer $pegawai_id
 * @property integer $daftartindakan_id
 * @property integer $tindakanpelayanan_id
 * @property integer $satuankecil_id
 * @property integer $shift_id
 * @property integer $pendaftaran_id
 * @property integer $obatalkes_id
 * @property integer $pasien_id
 * @property integer $penjamin_id
 * @property integer $kelaspelayanan_id
 * @property integer $pasienanastesi_id
 * @property integer $pasienmasukpenunjang_id
 * @property integer $pasienadmisi_id
 * @property integer $oasudahbayar_id
 * @property integer $penjualanresep_id
 * @property string $tglpelayanan
 * @property string $r
 * @property integer $rke
 * @property integer $permintaan_oa
 * @property integer $jmlkemasan_oa
 * @property integer $kekuatan_oa
 * @property string $satuankekuatan_oa
 * @property double $qty_oa
 * @property double $hargasatuan_oa
 * @property string $signa_oa
 * @property double $harganetto_oa
 * @property double $hargajual_oa
 * @property string $etiket
 * @property double $jmlexposerad
 * @property string $kontrasrad
 * @property double $biayaservice
 * @property double $biayakonseling
 * @property double $jasadokterresep
 * @property double $biayakemasan
 * @property double $biayaadministrasi
 * @property double $tarifcyto
 * @property double $discount
 * @property double $subsidiasuransi
 * @property double $subsidipemerintah
 * @property double $subsidirs
 * @property double $iurbiaya
 * @property string $oa
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 * @property integer $verifikasitagihan_id
 * @property integer $jurnalrekening_id
 * @property integer $permohonanoadetail_id
 * @property integer $persenppnjual
 * @property integer $resepturdetail_id
 *
 * The followings are the available model relations:
 * @property StokobatalkesT[] $stokobatalkesTs
 * @property CarabayarM $carabayar
 * @property DaftartindakanM $daftartindakan
 * @property KelaspelayananM $kelaspelayanan
 * @property OasudahbayarT $oasudahbayar
 * @property PasienM $pasien
 * @property PasienadmisiT $pasienadmisi
 * @property PasienanastesiT $pasienanastesi
 * @property PasienmasukpenunjangT $pasienmasukpenunjang
 * @property PegawaiM $pegawai
 * @property PendaftaranT $pendaftaran
 * @property PenjaminpasienM $penjamin
 * @property PenjualanresepT $penjualanresep
 * @property RacikanM $racikan
 * @property ReturresepdetT $returresepdet
 * @property RuanganM $ruangan
 * @property SatuankecilM $satuankecil
 * @property ShiftM $shift
 * @property SumberdanaM $sumberdana
 * @property TindakanpelayananT $tindakanpelayanan
 * @property TipepaketM $tipepaket
 * @property ObatalkesM $obatalkes
 * @property VerifikasitagihanT $verifikasitagihan
 * @property JurnalrekeningT $jurnalrekening
 * @property PermohonanoadetailT $permohonanoadetail
 * @property ResepturdetailT $resepturdetail
 * @property ReturresepdetT[] $returresepdetTs
 * @property ObatalkeskomponenT[] $obatalkeskomponenTs
 * @property OasudahbayarT[] $oasudahbayarTs
 * @property JurnalrekeningT[] $jurnalrekeningTs
 */
class MOObatalkespasienT extends CActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return MOObatalkespasienT the static model class
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
        return 'obatalkespasien_t';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('sumberdana_id, tipepaket_id, ruangan_id, carabayar_id, pegawai_id, shift_id, obatalkes_id, pasien_id, penjamin_id, tglpelayanan, qty_oa, harganetto_oa, hargajual_oa, biayaservice, biayakonseling, jasadokterresep, biayakemasan, biayaadministrasi, tarifcyto, discount, subsidiasuransi, subsidipemerintah, subsidirs, iurbiaya', 'required'),
            array('sumberdana_id, racikan_id, returresepdet_id, tipepaket_id, ruangan_id, carabayar_id, pegawai_id, daftartindakan_id, tindakanpelayanan_id, satuankecil_id, shift_id, pendaftaran_id, obatalkes_id, pasien_id, penjamin_id, kelaspelayanan_id, pasienanastesi_id, pasienmasukpenunjang_id, pasienadmisi_id, oasudahbayar_id, penjualanresep_id, rke, permintaan_oa, jmlkemasan_oa, kekuatan_oa, verifikasitagihan_id, jurnalrekening_id, permohonanoadetail_id, persenppnjual, resepturdetail_id', 'numerical', 'integerOnly'=>true),
            array('qty_oa, hargasatuan_oa, harganetto_oa, hargajual_oa, jmlexposerad, biayaservice, biayakonseling, jasadokterresep, biayakemasan, biayaadministrasi, tarifcyto, discount, subsidiasuransi, subsidipemerintah, subsidirs, iurbiaya', 'numerical'),
            array('r, oa', 'length', 'max'=>2),
            array('satuankekuatan_oa, kontrasrad', 'length', 'max'=>20),
            array('signa_oa', 'length', 'max'=>30),
            array('etiket', 'length', 'max'=>100),
            array('create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('obatalkespasien_id, sumberdana_id, racikan_id, returresepdet_id, tipepaket_id, ruangan_id, carabayar_id, pegawai_id, daftartindakan_id, tindakanpelayanan_id, satuankecil_id, shift_id, pendaftaran_id, obatalkes_id, pasien_id, penjamin_id, kelaspelayanan_id, pasienanastesi_id, pasienmasukpenunjang_id, pasienadmisi_id, oasudahbayar_id, penjualanresep_id, tglpelayanan, r, rke, permintaan_oa, jmlkemasan_oa, kekuatan_oa, satuankekuatan_oa, qty_oa, hargasatuan_oa, signa_oa, harganetto_oa, hargajual_oa, etiket, jmlexposerad, kontrasrad, biayaservice, biayakonseling, jasadokterresep, biayakemasan, biayaadministrasi, tarifcyto, discount, subsidiasuransi, subsidipemerintah, subsidirs, iurbiaya, oa, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, verifikasitagihan_id, jurnalrekening_id, permohonanoadetail_id, persenppnjual, resepturdetail_id', 'safe', 'on'=>'search'),
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
            'stokobatalkesTs' => array(self::HAS_MANY, 'StokobatalkesT', 'obatalkespasien_id'),
            'carabayar' => array(self::BELONGS_TO, 'CarabayarM', 'carabayar_id'),
            'daftartindakan' => array(self::BELONGS_TO, 'DaftartindakanM', 'daftartindakan_id'),
            'kelaspelayanan' => array(self::BELONGS_TO, 'KelaspelayananM', 'kelaspelayanan_id'),
            'oasudahbayar' => array(self::BELONGS_TO, 'OasudahbayarT', 'oasudahbayar_id'),
            'pasien' => array(self::BELONGS_TO, 'PasienM', 'pasien_id'),
            'pasienadmisi' => array(self::BELONGS_TO, 'PasienadmisiT', 'pasienadmisi_id'),
            'pasienanastesi' => array(self::BELONGS_TO, 'PasienanastesiT', 'pasienanastesi_id'),
            'pasienmasukpenunjang' => array(self::BELONGS_TO, 'PasienmasukpenunjangT', 'pasienmasukpenunjang_id'),
            'pegawai' => array(self::BELONGS_TO, 'PegawaiM', 'pegawai_id'),
            'pendaftaran' => array(self::BELONGS_TO, 'PendaftaranT', 'pendaftaran_id'),
            'penjamin' => array(self::BELONGS_TO, 'PenjaminpasienM', 'penjamin_id'),
            'penjualanresep' => array(self::BELONGS_TO, 'PenjualanresepT', 'penjualanresep_id'),
            'racikan' => array(self::BELONGS_TO, 'RacikanM', 'racikan_id'),
            'returresepdet' => array(self::BELONGS_TO, 'ReturresepdetT', 'returresepdet_id'),
            'ruangan' => array(self::BELONGS_TO, 'RuanganM', 'ruangan_id'),
            'satuankecil' => array(self::BELONGS_TO, 'SatuankecilM', 'satuankecil_id'),
            'shift' => array(self::BELONGS_TO, 'ShiftM', 'shift_id'),
            'sumberdana' => array(self::BELONGS_TO, 'SumberdanaM', 'sumberdana_id'),
            'tindakanpelayanan' => array(self::BELONGS_TO, 'TindakanpelayananT', 'tindakanpelayanan_id'),
            'tipepaket' => array(self::BELONGS_TO, 'TipepaketM', 'tipepaket_id'),
            'obatalkes' => array(self::BELONGS_TO, 'ObatalkesM', 'obatalkes_id'),
            'verifikasitagihan' => array(self::BELONGS_TO, 'VerifikasitagihanT', 'verifikasitagihan_id'),
            'jurnalrekening' => array(self::BELONGS_TO, 'JurnalrekeningT', 'jurnalrekening_id'),
            'permohonanoadetail' => array(self::BELONGS_TO, 'PermohonanoadetailT', 'permohonanoadetail_id'),
            'resepturdetail' => array(self::BELONGS_TO, 'ResepturdetailT', 'resepturdetail_id'),
            'returresepdetTs' => array(self::HAS_MANY, 'ReturresepdetT', 'obatalkespasien_id'),
            'obatalkeskomponenTs' => array(self::HAS_MANY, 'ObatalkeskomponenT', 'obatalkespasien_id'),
            'oasudahbayarTs' => array(self::HAS_MANY, 'OasudahbayarT', 'obatalkespasien_id'),
            'jurnalrekeningTs' => array(self::HAS_MANY, 'JurnalrekeningT', 'obatalkespasien_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'obatalkespasien_id' => 'Obatalkespasien',
            'sumberdana_id' => 'Sumberdana',
            'racikan_id' => 'Racikan',
            'returresepdet_id' => 'Returresepdet',
            'tipepaket_id' => 'Tipepaket',
            'ruangan_id' => 'Ruangan',
            'carabayar_id' => 'Carabayar',
            'pegawai_id' => 'Pegawai',
            'daftartindakan_id' => 'Daftartindakan',
            'tindakanpelayanan_id' => 'Tindakanpelayanan',
            'satuankecil_id' => 'Satuankecil',
            'shift_id' => 'Shift',
            'pendaftaran_id' => 'Pendaftaran',
            'obatalkes_id' => 'Obatalkes',
            'pasien_id' => 'Pasien',
            'penjamin_id' => 'Penjamin',
            'kelaspelayanan_id' => 'Kelaspelayanan',
            'pasienanastesi_id' => 'Pasienanastesi',
            'pasienmasukpenunjang_id' => 'Pasienmasukpenunjang',
            'pasienadmisi_id' => 'Pasienadmisi',
            'oasudahbayar_id' => 'Oasudahbayar',
            'penjualanresep_id' => 'Penjualanresep',
            'tglpelayanan' => 'Tglpelayanan',
            'r' => 'R',
            'rke' => 'Rke',
            'permintaan_oa' => 'Permintaan Oa',
            'jmlkemasan_oa' => 'Jmlkemasan Oa',
            'kekuatan_oa' => 'Kekuatan Oa',
            'satuankekuatan_oa' => 'Satuankekuatan Oa',
            'qty_oa' => 'Qty Oa',
            'hargasatuan_oa' => 'Hargasatuan Oa',
            'signa_oa' => 'Signa Oa',
            'harganetto_oa' => 'Harganetto Oa',
            'hargajual_oa' => 'Hargajual Oa',
            'etiket' => 'Etiket',
            'jmlexposerad' => 'Jmlexposerad',
            'kontrasrad' => 'Kontrasrad',
            'biayaservice' => 'Biayaservice',
            'biayakonseling' => 'Biayakonseling',
            'jasadokterresep' => 'Jasadokterresep',
            'biayakemasan' => 'Biayakemasan',
            'biayaadministrasi' => 'Biayaadministrasi',
            'tarifcyto' => 'Tarifcyto',
            'discount' => 'Discount',
            'subsidiasuransi' => 'Subsidiasuransi',
            'subsidipemerintah' => 'Subsidipemerintah',
            'subsidirs' => 'Subsidirs',
            'iurbiaya' => 'Iurbiaya',
            'oa' => 'Oa',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
            'create_loginpemakai_id' => 'Create Loginpemakai',
            'update_loginpemakai_id' => 'Update Loginpemakai',
            'create_ruangan' => 'Create Ruangan',
            'verifikasitagihan_id' => 'Verifikasitagihan',
            'jurnalrekening_id' => 'Jurnalrekening',
            'permohonanoadetail_id' => 'Permohonanoadetail',
            'persenppnjual' => 'Persenppnjual',
            'resepturdetail_id' => 'Resepturdetail',
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

        if(!empty($this->obatalkespasien_id)){
            $criteria->addCondition('obatalkespasien_id = '.$this->obatalkespasien_id);
        }
        if(!empty($this->sumberdana_id)){
            $criteria->addCondition('sumberdana_id = '.$this->sumberdana_id);
        }
        if(!empty($this->racikan_id)){
            $criteria->addCondition('racikan_id = '.$this->racikan_id);
        }
        if(!empty($this->returresepdet_id)){
            $criteria->addCondition('returresepdet_id = '.$this->returresepdet_id);
        }
        if(!empty($this->tipepaket_id)){
            $criteria->addCondition('tipepaket_id = '.$this->tipepaket_id);
        }
        if(!empty($this->ruangan_id)){
            $criteria->addCondition('ruangan_id = '.$this->ruangan_id);
        }
        if(!empty($this->carabayar_id)){
            $criteria->addCondition('carabayar_id = '.$this->carabayar_id);
        }
        if(!empty($this->pegawai_id)){
            $criteria->addCondition('pegawai_id = '.$this->pegawai_id);
        }
        if(!empty($this->daftartindakan_id)){
            $criteria->addCondition('daftartindakan_id = '.$this->daftartindakan_id);
        }
        if(!empty($this->tindakanpelayanan_id)){
            $criteria->addCondition('tindakanpelayanan_id = '.$this->tindakanpelayanan_id);
        }
        if(!empty($this->satuankecil_id)){
            $criteria->addCondition('satuankecil_id = '.$this->satuankecil_id);
        }
        if(!empty($this->shift_id)){
            $criteria->addCondition('shift_id = '.$this->shift_id);
        }
        if(!empty($this->pendaftaran_id)){
            $criteria->addCondition('pendaftaran_id = '.$this->pendaftaran_id);
        }
        if(!empty($this->obatalkes_id)){
            $criteria->addCondition('obatalkes_id = '.$this->obatalkes_id);
        }
        if(!empty($this->pasien_id)){
            $criteria->addCondition('pasien_id = '.$this->pasien_id);
        }
        if(!empty($this->penjamin_id)){
            $criteria->addCondition('penjamin_id = '.$this->penjamin_id);
        }
        if(!empty($this->kelaspelayanan_id)){
            $criteria->addCondition('kelaspelayanan_id = '.$this->kelaspelayanan_id);
        }
        if(!empty($this->pasienanastesi_id)){
            $criteria->addCondition('pasienanastesi_id = '.$this->pasienanastesi_id);
        }
        if(!empty($this->pasienmasukpenunjang_id)){
            $criteria->addCondition('pasienmasukpenunjang_id = '.$this->pasienmasukpenunjang_id);
        }
        if(!empty($this->pasienadmisi_id)){
            $criteria->addCondition('pasienadmisi_id = '.$this->pasienadmisi_id);
        }
        if(!empty($this->oasudahbayar_id)){
            $criteria->addCondition('oasudahbayar_id = '.$this->oasudahbayar_id);
        }
        if(!empty($this->penjualanresep_id)){
            $criteria->addCondition('penjualanresep_id = '.$this->penjualanresep_id);
        }
        $criteria->compare('LOWER(tglpelayanan)',strtolower($this->tglpelayanan),true);
        $criteria->compare('LOWER(r)',strtolower($this->r),true);
        if(!empty($this->rke)){
            $criteria->addCondition('rke = '.$this->rke);
        }
        if(!empty($this->permintaan_oa)){
            $criteria->addCondition('permintaan_oa = '.$this->permintaan_oa);
        }
        if(!empty($this->jmlkemasan_oa)){
            $criteria->addCondition('jmlkemasan_oa = '.$this->jmlkemasan_oa);
        }
        if(!empty($this->kekuatan_oa)){
            $criteria->addCondition('kekuatan_oa = '.$this->kekuatan_oa);
        }
        $criteria->compare('LOWER(satuankekuatan_oa)',strtolower($this->satuankekuatan_oa),true);
        $criteria->compare('qty_oa',$this->qty_oa);
        $criteria->compare('hargasatuan_oa',$this->hargasatuan_oa);
        $criteria->compare('LOWER(signa_oa)',strtolower($this->signa_oa),true);
        $criteria->compare('harganetto_oa',$this->harganetto_oa);
        $criteria->compare('hargajual_oa',$this->hargajual_oa);
        $criteria->compare('LOWER(etiket)',strtolower($this->etiket),true);
        $criteria->compare('jmlexposerad',$this->jmlexposerad);
        $criteria->compare('LOWER(kontrasrad)',strtolower($this->kontrasrad),true);
        $criteria->compare('biayaservice',$this->biayaservice);
        $criteria->compare('biayakonseling',$this->biayakonseling);
        $criteria->compare('jasadokterresep',$this->jasadokterresep);
        $criteria->compare('biayakemasan',$this->biayakemasan);
        $criteria->compare('biayaadministrasi',$this->biayaadministrasi);
        $criteria->compare('tarifcyto',$this->tarifcyto);
        $criteria->compare('discount',$this->discount);
        $criteria->compare('subsidiasuransi',$this->subsidiasuransi);
        $criteria->compare('subsidipemerintah',$this->subsidipemerintah);
        $criteria->compare('subsidirs',$this->subsidirs);
        $criteria->compare('iurbiaya',$this->iurbiaya);
        $criteria->compare('LOWER(oa)',strtolower($this->oa),true);
        $criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
        $criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
        $criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
        $criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
        $criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);
        if(!empty($this->verifikasitagihan_id)){
            $criteria->addCondition('verifikasitagihan_id = '.$this->verifikasitagihan_id);
        }
        if(!empty($this->jurnalrekening_id)){
            $criteria->addCondition('jurnalrekening_id = '.$this->jurnalrekening_id);
        }
        if(!empty($this->permohonanoadetail_id)){
            $criteria->addCondition('permohonanoadetail_id = '.$this->permohonanoadetail_id);
        }
        if(!empty($this->persenppnjual)){
            $criteria->addCondition('persenppnjual = '.$this->persenppnjual);
        }
        if(!empty($this->resepturdetail_id)){
            $criteria->addCondition('resepturdetail_id = '.$this->resepturdetail_id);
        }

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
