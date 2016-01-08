<?php

/**
 * This is the model class for table "masukkamar_t".
 *
 * The followings are the available columns in table 'masukkamar_t':
 * @property integer $masukkamar_id
 * @property integer $ruangan_id
 * @property integer $carabayar_id
 * @property integer $bookingkamar_id
 * @property integer $pasienadmisi_id
 * @property integer $penjamin_id
 * @property integer $pindahkamar_id
 * @property integer $pegawai_id
 * @property integer $kelaspelayanan_id
 * @property integer $shift_id
 * @property integer $kamarruangan_id
 * @property string $tglmasukkamar
 * @property string $nomasukkamar
 * @property string $jammasukkamar
 * @property string $tglkeluarkamar
 * @property string $jamkeluarkamar
 * @property integer $lamadirawat_kamar
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 *
 * The followings are the available model relations:
 * @property PindahkamarT[] $pindahkamarTs
 * @property BookingkamarT $bookingkamar
 * @property CarabayarM $carabayar
 * @property KamarruanganM $kamarruangan
 * @property KelaspelayananM $kelaspelayanan
 * @property PasienadmisiT $pasienadmisi
 * @property PegawaiM $pegawai
 * @property PenjaminpasienM $penjamin
 * @property RuanganM $ruangan
 * @property ShiftM $shift
 * @property PindahkamarT $pindahkamar
 */
class MOMasukkamarT extends CActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return MOMasukkamarT the static model class
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
        return 'masukkamar_t';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('ruangan_id, carabayar_id, pasienadmisi_id, penjamin_id, kelaspelayanan_id, shift_id, tglmasukkamar, nomasukkamar, jammasukkamar, create_time, create_loginpemakai_id, create_ruangan', 'required'),
            array('ruangan_id, carabayar_id, bookingkamar_id, pasienadmisi_id, penjamin_id, pindahkamar_id, pegawai_id, kelaspelayanan_id, shift_id, kamarruangan_id, lamadirawat_kamar', 'numerical', 'integerOnly'=>true),
            array('nomasukkamar', 'length', 'max'=>50),
            array('tglkeluarkamar, jamkeluarkamar, update_time, update_loginpemakai_id', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('masukkamar_id, ruangan_id, carabayar_id, bookingkamar_id, pasienadmisi_id, penjamin_id, pindahkamar_id, pegawai_id, kelaspelayanan_id, shift_id, kamarruangan_id, tglmasukkamar, nomasukkamar, jammasukkamar, tglkeluarkamar, jamkeluarkamar, lamadirawat_kamar, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
            'pindahkamarTs' => array(self::HAS_MANY, 'PindahkamarT', 'masukkamar_id'),
            'bookingkamar' => array(self::BELONGS_TO, 'BookingkamarT', 'bookingkamar_id'),
            'carabayar' => array(self::BELONGS_TO, 'CarabayarM', 'carabayar_id'),
            'kamarruangan' => array(self::BELONGS_TO, 'KamarruanganM', 'kamarruangan_id'),
            'kelaspelayanan' => array(self::BELONGS_TO, 'KelaspelayananM', 'kelaspelayanan_id'),
            'pasienadmisi' => array(self::BELONGS_TO, 'PasienadmisiT', 'pasienadmisi_id'),
            'pegawai' => array(self::BELONGS_TO, 'PegawaiM', 'pegawai_id'),
            'penjamin' => array(self::BELONGS_TO, 'PenjaminpasienM', 'penjamin_id'),
            'ruangan' => array(self::BELONGS_TO, 'RuanganM', 'ruangan_id'),
            'shift' => array(self::BELONGS_TO, 'ShiftM', 'shift_id'),
            'pindahkamar' => array(self::BELONGS_TO, 'PindahkamarT', 'pindahkamar_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'masukkamar_id' => 'Masukkamar',
            'ruangan_id' => 'Ruangan',
            'carabayar_id' => 'Carabayar',
            'bookingkamar_id' => 'Bookingkamar',
            'pasienadmisi_id' => 'Pasienadmisi',
            'penjamin_id' => 'Penjamin',
            'pindahkamar_id' => 'Pindahkamar',
            'pegawai_id' => 'Pegawai',
            'kelaspelayanan_id' => 'Kelaspelayanan',
            'shift_id' => 'Shift',
            'kamarruangan_id' => 'Kamarruangan',
            'tglmasukkamar' => 'Tglmasukkamar',
            'nomasukkamar' => 'Nomasukkamar',
            'jammasukkamar' => 'Jammasukkamar',
            'tglkeluarkamar' => 'Tglkeluarkamar',
            'jamkeluarkamar' => 'Jamkeluarkamar',
            'lamadirawat_kamar' => 'Lamadirawat Kamar',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
            'create_loginpemakai_id' => 'Create Loginpemakai',
            'update_loginpemakai_id' => 'Update Loginpemakai',
            'create_ruangan' => 'Create Ruangan',
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

        if(!empty($this->masukkamar_id)){
            $criteria->addCondition('masukkamar_id = '.$this->masukkamar_id);
        }
        if(!empty($this->ruangan_id)){
            $criteria->addCondition('ruangan_id = '.$this->ruangan_id);
        }
        if(!empty($this->carabayar_id)){
            $criteria->addCondition('carabayar_id = '.$this->carabayar_id);
        }
        if(!empty($this->bookingkamar_id)){
            $criteria->addCondition('bookingkamar_id = '.$this->bookingkamar_id);
        }
        if(!empty($this->pasienadmisi_id)){
            $criteria->addCondition('pasienadmisi_id = '.$this->pasienadmisi_id);
        }
        if(!empty($this->penjamin_id)){
            $criteria->addCondition('penjamin_id = '.$this->penjamin_id);
        }
        if(!empty($this->pindahkamar_id)){
            $criteria->addCondition('pindahkamar_id = '.$this->pindahkamar_id);
        }
        if(!empty($this->pegawai_id)){
            $criteria->addCondition('pegawai_id = '.$this->pegawai_id);
        }
        if(!empty($this->kelaspelayanan_id)){
            $criteria->addCondition('kelaspelayanan_id = '.$this->kelaspelayanan_id);
        }
        if(!empty($this->shift_id)){
            $criteria->addCondition('shift_id = '.$this->shift_id);
        }
        if(!empty($this->kamarruangan_id)){
            $criteria->addCondition('kamarruangan_id = '.$this->kamarruangan_id);
        }
        $criteria->compare('LOWER(tglmasukkamar)',strtolower($this->tglmasukkamar),true);
        $criteria->compare('LOWER(nomasukkamar)',strtolower($this->nomasukkamar),true);
        $criteria->compare('LOWER(jammasukkamar)',strtolower($this->jammasukkamar),true);
        $criteria->compare('LOWER(tglkeluarkamar)',strtolower($this->tglkeluarkamar),true);
        $criteria->compare('LOWER(jamkeluarkamar)',strtolower($this->jamkeluarkamar),true);
        if(!empty($this->lamadirawat_kamar)){
            $criteria->addCondition('lamadirawat_kamar = '.$this->lamadirawat_kamar);
        }
        $criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
        $criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
        $criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
        $criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
        $criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);

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