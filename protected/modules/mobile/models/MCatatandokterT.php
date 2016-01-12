<?php

/**
 * This is the model class for table "mcatatandokter_t".
 *
 * The followings are the available columns in table 'mcatatandokter_t':
 * @property integer $mcatatandokter_id
 * @property integer $pegawai_id
 * @property integer $mkategoricatatan_id
 * @property string $judulcatatan
 * @property string $isicatatan
 * @property string $status_catatan
 * @property string $tglrencana
 * @property string $tempat_kegiatan
 * @property string $alamat_kegiatan
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 */
class MCatatandokterT extends CActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return MCatatandokterT the static model class
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
        return 'mcatatandokter_t';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('pegawai_id, mkategoricatatan_id, judulcatatan, isicatatan, status_catatan, create_time, create_loginpemakai_id', 'required'),
            array('pegawai_id, mkategoricatatan_id, create_loginpemakai_id, update_loginpemakai_id', 'numerical', 'integerOnly'=>true),
            array('judulcatatan', 'length', 'max'=>200),
            array('status_catatan', 'length', 'max'=>50),
            array('tempat_kegiatan', 'length', 'max'=>100),
            array('alamat_kegiatan', 'length', 'max'=>400),
            array('tglrencana, update_time', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('mcatatandokter_id, pegawai_id, mkategoricatatan_id, judulcatatan, isicatatan, status_catatan, tglrencana, tempat_kegiatan, alamat_kegiatan, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id', 'safe', 'on'=>'search'),
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
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'mcatatandokter_id' => 'Mcatatandokter',
            'pegawai_id' => 'Pegawai',
            'mkategoricatatan_id' => 'Mkategoricatatan',
            'judulcatatan' => 'Judulcatatan',
            'isicatatan' => 'Isicatatan',
            'status_catatan' => 'Status Catatan',
            'tglrencana' => 'Tglrencana',
            'tempat_kegiatan' => 'Tempat Kegiatan',
            'alamat_kegiatan' => 'Alamat Kegiatan',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
            'create_loginpemakai_id' => 'Create Loginpemakai',
            'update_loginpemakai_id' => 'Update Loginpemakai',
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

        if(!empty($this->mcatatandokter_id)){
            $criteria->addCondition('mcatatandokter_id = '.$this->mcatatandokter_id);
        }
        if(!empty($this->pegawai_id)){
            $criteria->addCondition('pegawai_id = '.$this->pegawai_id);
        }
        if(!empty($this->mkategoricatatan_id)){
            $criteria->addCondition('mkategoricatatan_id = '.$this->mkategoricatatan_id);
        }
        $criteria->compare('LOWER(judulcatatan)',strtolower($this->judulcatatan),true);
        $criteria->compare('LOWER(isicatatan)',strtolower($this->isicatatan),true);
        $criteria->compare('LOWER(status_catatan)',strtolower($this->status_catatan),true);
        $criteria->compare('LOWER(tglrencana)',strtolower($this->tglrencana),true);
        $criteria->compare('LOWER(tempat_kegiatan)',strtolower($this->tempat_kegiatan),true);
        $criteria->compare('LOWER(alamat_kegiatan)',strtolower($this->alamat_kegiatan),true);
        $criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
        $criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
        if(!empty($this->create_loginpemakai_id)){
            $criteria->addCondition('create_loginpemakai_id = '.$this->create_loginpemakai_id);
        }
        if(!empty($this->update_loginpemakai_id)){
            $criteria->addCondition('update_loginpemakai_id = '.$this->update_loginpemakai_id);
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