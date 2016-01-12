<?php

/**
 * This is the model class for table "buatjanjipoli_t".
 *
 * The followings are the available columns in table 'buatjanjipoli_t':
 * @property integer $buatjanjipoli_id
 * @property integer $pegawai_id
 * @property integer $ruangan_id
 * @property integer $pasien_id
 * @property string $tglbuatjanji
 * @property string $harijadwal
 * @property string $tgljadwal
 * @property boolean $byphone
 * @property string $keteranganbuatjanji
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 * @property string $no_antrianjanji
 * @property string $no_buatjanji
 * @property integer $pendaftaran_id
 *
 * The followings are the available model relations:
 * @property PendaftaranT $pendaftaran
 * @property PasienM $pasien
 * @property PegawaiM $pegawai
 * @property RuanganM $ruangan
 */
class MOBuatjanjipoliT extends CActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return MOBuatjanjipoliT the static model class
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
        return 'buatjanjipoli_t';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('ruangan_id, pasien_id, tglbuatjanji, harijadwal, tgljadwal, create_time, create_loginpemakai_id, no_antrianjanji', 'required'),
            array('pegawai_id, ruangan_id, pasien_id, pendaftaran_id', 'numerical', 'integerOnly'=>true),
            array('harijadwal', 'length', 'max'=>20),
            array('no_antrianjanji', 'length', 'max'=>6),
            array('no_buatjanji', 'length', 'max'=>100),
            array('byphone, keteranganbuatjanji, update_time, update_loginpemakai_id, create_ruangan', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('buatjanjipoli_id, pegawai_id, ruangan_id, pasien_id, tglbuatjanji, harijadwal, tgljadwal, byphone, keteranganbuatjanji, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, no_antrianjanji, no_buatjanji, pendaftaran_id', 'safe', 'on'=>'search'),
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
            'pendaftaran' => array(self::BELONGS_TO, 'PendaftaranT', 'pendaftaran_id'),
            'pasien' => array(self::BELONGS_TO, 'PasienM', 'pasien_id'),
            'pegawai' => array(self::BELONGS_TO, 'PegawaiM', 'pegawai_id'),
            'ruangan' => array(self::BELONGS_TO, 'RuanganM', 'ruangan_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'buatjanjipoli_id' => 'Buatjanjipoli',
            'pegawai_id' => 'Pegawai',
            'ruangan_id' => 'Ruangan',
            'pasien_id' => 'Pasien',
            'tglbuatjanji' => 'Tglbuatjanji',
            'harijadwal' => 'Harijadwal',
            'tgljadwal' => 'Tgljadwal',
            'byphone' => 'Byphone',
            'keteranganbuatjanji' => 'Keteranganbuatjanji',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
            'create_loginpemakai_id' => 'Create Loginpemakai',
            'update_loginpemakai_id' => 'Update Loginpemakai',
            'create_ruangan' => 'Create Ruangan',
            'no_antrianjanji' => 'No Antrianjanji',
            'no_buatjanji' => 'No Buatjanji',
            'pendaftaran_id' => 'Pendaftaran',
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

        if(!empty($this->buatjanjipoli_id)){
            $criteria->addCondition('buatjanjipoli_id = '.$this->buatjanjipoli_id);
        }
        if(!empty($this->pegawai_id)){
            $criteria->addCondition('pegawai_id = '.$this->pegawai_id);
        }
        if(!empty($this->ruangan_id)){
            $criteria->addCondition('ruangan_id = '.$this->ruangan_id);
        }
        if(!empty($this->pasien_id)){
            $criteria->addCondition('pasien_id = '.$this->pasien_id);
        }
        $criteria->compare('LOWER(tglbuatjanji)',strtolower($this->tglbuatjanji),true);
        $criteria->compare('LOWER(harijadwal)',strtolower($this->harijadwal),true);
        $criteria->compare('LOWER(tgljadwal)',strtolower($this->tgljadwal),true);
        $criteria->compare('byphone',$this->byphone);
        $criteria->compare('LOWER(keteranganbuatjanji)',strtolower($this->keteranganbuatjanji),true);
        $criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
        $criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
        $criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
        $criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
        $criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);
        $criteria->compare('LOWER(no_antrianjanji)',strtolower($this->no_antrianjanji),true);
        $criteria->compare('LOWER(no_buatjanji)',strtolower($this->no_buatjanji),true);
        if(!empty($this->pendaftaran_id)){
            $criteria->addCondition('pendaftaran_id = '.$this->pendaftaran_id);
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
?>