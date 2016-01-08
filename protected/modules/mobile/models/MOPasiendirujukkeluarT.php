<?php

/**
 * This is the model class for table "pasiendirujukkeluar_t".
 *
 * The followings are the available columns in table 'pasiendirujukkeluar_t':
 * @property integer $pasiendirujukkeluar_id
 * @property integer $pasien_id
 * @property integer $rujukankeluar_id
 * @property integer $pasienadmisi_id
 * @property integer $pegawai_id
 * @property integer $pendaftaran_id
 * @property string $nosuratrujukan
 * @property string $tgldirujuk
 * @property string $kepadayth
 * @property string $dirujukkebagian
 * @property string $alasandirujuk
 * @property string $hasilpemeriksaan_ruj
 * @property string $diagnosasementara_ruj
 * @property string $pengobatan_ruj
 * @property string $lainlain_ruj
 * @property string $catatandokterperujuk
 * @property integer $ruanganasal_id
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $tglberlakusurat
 * @property string $sampaidengan
 * @property string $lampiransurat
 * @property string $dokterpemeriksa
 *
 * The followings are the available model relations:
 * @property RuanganM $ruanganasal
 * @property PasienM $pasien
 * @property PasienadmisiT $pasienadmisi
 * @property PegawaiM $pegawai
 * @property PendaftaranT $pendaftaran
 * @property RujukankeluarM $rujukankeluar
 */
class MOPasiendirujukkeluarT extends CActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return MOPasiendirujukkeluarT the static model class
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
        return 'pasiendirujukkeluar_t';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('pasien_id, rujukankeluar_id, pegawai_id, nosuratrujukan, tgldirujuk, ruanganasal_id, create_time, create_loginpemakai_id, tglberlakusurat, sampaidengan', 'required'),
            array('pasien_id, rujukankeluar_id, pasienadmisi_id, pegawai_id, pendaftaran_id, ruanganasal_id', 'numerical', 'integerOnly'=>true),
            array('nosuratrujukan', 'length', 'max'=>50),
            array('kepadayth', 'length', 'max'=>100),
            array('dirujukkebagian', 'length', 'max'=>30),
            array('lampiransurat', 'length', 'max'=>20),
            array('alasandirujuk, hasilpemeriksaan_ruj, diagnosasementara_ruj, pengobatan_ruj, lainlain_ruj, catatandokterperujuk, update_time, update_loginpemakai_id, dokterpemeriksa', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('pasiendirujukkeluar_id, pasien_id, rujukankeluar_id, pasienadmisi_id, pegawai_id, pendaftaran_id, nosuratrujukan, tgldirujuk, kepadayth, dirujukkebagian, alasandirujuk, hasilpemeriksaan_ruj, diagnosasementara_ruj, pengobatan_ruj, lainlain_ruj, catatandokterperujuk, ruanganasal_id, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, tglberlakusurat, sampaidengan, lampiransurat, dokterpemeriksa', 'safe', 'on'=>'search'),
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
            'ruanganasal' => array(self::BELONGS_TO, 'RuanganM', 'ruanganasal_id'),
            'pasien' => array(self::BELONGS_TO, 'PasienM', 'pasien_id'),
            'pasienadmisi' => array(self::BELONGS_TO, 'PasienadmisiT', 'pasienadmisi_id'),
            'pegawai' => array(self::BELONGS_TO, 'PegawaiM', 'pegawai_id'),
            'pendaftaran' => array(self::BELONGS_TO, 'PendaftaranT', 'pendaftaran_id'),
            'rujukankeluar' => array(self::BELONGS_TO, 'RujukankeluarM', 'rujukankeluar_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'pasiendirujukkeluar_id' => 'Pasiendirujukkeluar',
            'pasien_id' => 'Pasien',
            'rujukankeluar_id' => 'Rujukankeluar',
            'pasienadmisi_id' => 'Pasienadmisi',
            'pegawai_id' => 'Pegawai',
            'pendaftaran_id' => 'Pendaftaran',
            'nosuratrujukan' => 'Nosuratrujukan',
            'tgldirujuk' => 'Tgldirujuk',
            'kepadayth' => 'Kepadayth',
            'dirujukkebagian' => 'Dirujukkebagian',
            'alasandirujuk' => 'Alasandirujuk',
            'hasilpemeriksaan_ruj' => 'Hasilpemeriksaan Ruj',
            'diagnosasementara_ruj' => 'Diagnosasementara Ruj',
            'pengobatan_ruj' => 'Pengobatan Ruj',
            'lainlain_ruj' => 'Lainlain Ruj',
            'catatandokterperujuk' => 'Catatandokterperujuk',
            'ruanganasal_id' => 'Ruanganasal',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
            'create_loginpemakai_id' => 'Create Loginpemakai',
            'update_loginpemakai_id' => 'Update Loginpemakai',
            'tglberlakusurat' => 'Tglberlakusurat',
            'sampaidengan' => 'Sampaidengan',
            'lampiransurat' => 'Lampiransurat',
            'dokterpemeriksa' => 'Dokterpemeriksa',
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

        if(!empty($this->pasiendirujukkeluar_id)){
            $criteria->addCondition('pasiendirujukkeluar_id = '.$this->pasiendirujukkeluar_id);
        }
        if(!empty($this->pasien_id)){
            $criteria->addCondition('pasien_id = '.$this->pasien_id);
        }
        if(!empty($this->rujukankeluar_id)){
            $criteria->addCondition('rujukankeluar_id = '.$this->rujukankeluar_id);
        }
        if(!empty($this->pasienadmisi_id)){
            $criteria->addCondition('pasienadmisi_id = '.$this->pasienadmisi_id);
        }
        if(!empty($this->pegawai_id)){
            $criteria->addCondition('pegawai_id = '.$this->pegawai_id);
        }
        if(!empty($this->pendaftaran_id)){
            $criteria->addCondition('pendaftaran_id = '.$this->pendaftaran_id);
        }
        $criteria->compare('LOWER(nosuratrujukan)',strtolower($this->nosuratrujukan),true);
        $criteria->compare('LOWER(tgldirujuk)',strtolower($this->tgldirujuk),true);
        $criteria->compare('LOWER(kepadayth)',strtolower($this->kepadayth),true);
        $criteria->compare('LOWER(dirujukkebagian)',strtolower($this->dirujukkebagian),true);
        $criteria->compare('LOWER(alasandirujuk)',strtolower($this->alasandirujuk),true);
        $criteria->compare('LOWER(hasilpemeriksaan_ruj)',strtolower($this->hasilpemeriksaan_ruj),true);
        $criteria->compare('LOWER(diagnosasementara_ruj)',strtolower($this->diagnosasementara_ruj),true);
        $criteria->compare('LOWER(pengobatan_ruj)',strtolower($this->pengobatan_ruj),true);
        $criteria->compare('LOWER(lainlain_ruj)',strtolower($this->lainlain_ruj),true);
        $criteria->compare('LOWER(catatandokterperujuk)',strtolower($this->catatandokterperujuk),true);
        if(!empty($this->ruanganasal_id)){
            $criteria->addCondition('ruanganasal_id = '.$this->ruanganasal_id);
        }
        $criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
        $criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
        $criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
        $criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
        $criteria->compare('LOWER(tglberlakusurat)',strtolower($this->tglberlakusurat),true);
        $criteria->compare('LOWER(sampaidengan)',strtolower($this->sampaidengan),true);
        $criteria->compare('LOWER(lampiransurat)',strtolower($this->lampiransurat),true);
        $criteria->compare('LOWER(dokterpemeriksa)',strtolower($this->dokterpemeriksa),true);

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
