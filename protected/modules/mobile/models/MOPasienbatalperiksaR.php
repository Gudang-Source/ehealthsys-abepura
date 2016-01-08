<?php

/**
 * This is the model class for table "pasienbatalperiksa_r".
 *
 * The followings are the available columns in table 'pasienbatalperiksa_r':
 * @property integer $pasienbatalperiksa_id
 * @property integer $pendaftaran_id
 * @property integer $pasien_id
 * @property string $tglbatal
 * @property string $keterangan_batal
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 * @property integer $pasienmasukpenunjang_id
 * @property integer $pasienkirimkeunitlain_id
 *
 * The followings are the available model relations:
 * @property PendaftaranT[] $pendaftaranTs
 * @property PasienM $pasien
 * @property PendaftaranT $pendaftaran
 * @property LoginpemakaiK $createLoginpemakai
 * @property RuanganM $createRuangan
 * @property PasienkirimkeunitlainT $pasienkirimkeunitlain
 * @property PasienmasukpenunjangT $pasienmasukpenunjang
 * @property LoginpemakaiK $updateLoginpemakai
 */
class MOPasienbatalperiksaR extends CActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return MOPasienbatalperiksaR the static model class
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
        return 'pasienbatalperiksa_r';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('pasien_id, tglbatal, keterangan_batal, create_time, create_loginpemakai_id', 'required'),
            array('pendaftaran_id, pasien_id, pasienmasukpenunjang_id, pasienkirimkeunitlain_id', 'numerical', 'integerOnly'=>true),
            array('update_time, update_loginpemakai_id, create_ruangan', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('pasienbatalperiksa_id, pendaftaran_id, pasien_id, tglbatal, keterangan_batal, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, pasienmasukpenunjang_id, pasienkirimkeunitlain_id', 'safe', 'on'=>'search'),
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
            'pendaftaranTs' => array(self::HAS_MANY, 'PendaftaranT', 'pasienbatalperiksa_id'),
            'pasien' => array(self::BELONGS_TO, 'PasienM', 'pasien_id'),
            'pendaftaran' => array(self::BELONGS_TO, 'PendaftaranT', 'pendaftaran_id'),
            'createLoginpemakai' => array(self::BELONGS_TO, 'LoginpemakaiK', 'create_loginpemakai_id'),
            'createRuangan' => array(self::BELONGS_TO, 'RuanganM', 'create_ruangan'),
            'pasienkirimkeunitlain' => array(self::BELONGS_TO, 'PasienkirimkeunitlainT', 'pasienkirimkeunitlain_id'),
            'pasienmasukpenunjang' => array(self::BELONGS_TO, 'PasienmasukpenunjangT', 'pasienmasukpenunjang_id'),
            'updateLoginpemakai' => array(self::BELONGS_TO, 'LoginpemakaiK', 'update_loginpemakai_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'pasienbatalperiksa_id' => 'Pasienbatalperiksa',
            'pendaftaran_id' => 'Pendaftaran',
            'pasien_id' => 'Pasien',
            'tglbatal' => 'Tglbatal',
            'keterangan_batal' => 'Keterangan Batal',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
            'create_loginpemakai_id' => 'Create Loginpemakai',
            'update_loginpemakai_id' => 'Update Loginpemakai',
            'create_ruangan' => 'Create Ruangan',
            'pasienmasukpenunjang_id' => 'Pasienmasukpenunjang',
            'pasienkirimkeunitlain_id' => 'Pasienkirimkeunitlain',
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

        if(!empty($this->pasienbatalperiksa_id)){
            $criteria->addCondition('pasienbatalperiksa_id = '.$this->pasienbatalperiksa_id);
        }
        if(!empty($this->pendaftaran_id)){
            $criteria->addCondition('pendaftaran_id = '.$this->pendaftaran_id);
        }
        if(!empty($this->pasien_id)){
            $criteria->addCondition('pasien_id = '.$this->pasien_id);
        }
        $criteria->compare('LOWER(tglbatal)',strtolower($this->tglbatal),true);
        $criteria->compare('LOWER(keterangan_batal)',strtolower($this->keterangan_batal),true);
        $criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
        $criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
        $criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
        $criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
        $criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);
        if(!empty($this->pasienmasukpenunjang_id)){
            $criteria->addCondition('pasienmasukpenunjang_id = '.$this->pasienmasukpenunjang_id);
        }
        if(!empty($this->pasienkirimkeunitlain_id)){
            $criteria->addCondition('pasienkirimkeunitlain_id = '.$this->pasienkirimkeunitlain_id);
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