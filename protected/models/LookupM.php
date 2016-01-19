<?php

/**
 * This is the model class for table "lookup_m".
 *
 * The followings are the available columns in table 'lookup_m':
 * @property integer $lookup_id
 * @property string $lookup_type
 * @property string $lookup_name
 * @property string $lookup_value
 * @property integer $lookup_urutan
 * @property string $lookup_kode
 * @property boolean $lookup_aktif
 */
class LookupM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return LookupM the static model class
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
		return 'lookup_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('lookup_type, lookup_name, lookup_value, lookup_urutan', 'required'),
			array('lookup_urutan', 'numerical', 'integerOnly'=>true),
			array('lookup_type', 'length', 'max'=>100),
			array('lookup_name, lookup_value', 'length', 'max'=>200),
			array('lookup_kode', 'length', 'max'=>50),
			array('lookup_aktif', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('lookup_id, lookup_type, lookup_name, lookup_value, lookup_urutan, lookup_kode, lookup_aktif', 'safe', 'on'=>'search'),
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
			'lookup_id' => 'ID',
			'lookup_type' => 'Type',
			'lookup_name' => 'Name',
			'lookup_value' => 'Value',
			'lookup_urutan' => 'Urutan',
			'lookup_kode' => 'Kode',
			'lookup_aktif' => 'Aktif',
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

		$criteria->compare('lookup_id',$this->lookup_id);
		$criteria->compare('lookup_type',$this->lookup_type,true);
		$criteria->compare('lookup_name',$this->lookup_name,true);
		$criteria->compare('lookup_value',$this->lookup_value,true);
		$criteria->compare('lookup_urutan',$this->lookup_urutan);
		$criteria->compare('lookup_kode',$this->lookup_kode,true);
		$criteria->compare('lookup_aktif',$this->lookup_aktif);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        /**
         * manampilkan list lookup
         * @param type $lookup_type
         * @return array $data[$lookup_value] = $lookup_name
         */
	public static function getItems($lookup_type=null)
	{
            $data = array();
            $criteria = new CDbCriteria();
            if(is_array($lookup_type))
                $criteria->addInCondition ('lookup_type', $lookup_type);
            else{
                $lookup_type = isset($lookup_type) ? trim(strtolower($lookup_type)) : null;
                $criteria->compare('lookup_type',$lookup_type);
            }
            $criteria->order = "lookup_urutan";
            $criteria->addCondition("lookup_aktif IS TRUE");
            $models=self::model()->findAll($criteria);
            if(count($models) > 0){
                foreach($models as $model)
                    // $data[$model->lookup_value]= ucwords(strtolower($model->lookup_name));
                    $data[$model->lookup_value]= ($model->lookup_name);
            }else{
                $data[""] = null;
            }
            
            return $data;
	}
        /**
         * manampilkan list kode lookup
         * @param type $lookup_type
         * @return array $data[$lookup_kode] = $lookup_kode
         */
	public static function getKodeItems($lookup_type=null)
	{
            
            $data = array();
            $criteria = new CDbCriteria();
            if(is_array($lookup_type))
                $criteria->addInCondition ('lookup_type', $lookup_type);
            else{
                $lookup_type = isset($lookup_type) ? trim(strtolower($lookup_type)) : null;
                $criteria->compare('lookup_type',$lookup_type);
            }
            $criteria->order = "lookup_kode";
            $criteria->addCondition("lookup_aktif IS TRUE");
            $models=self::model()->findAll($criteria);
            if(count($models) > 0){
                foreach($models as $model)
                    $data[$model->lookup_kode]= ucwords(strtolower($model->lookup_kode));
            }else{
                $data[""] = null;
            }
            
            return $data;
	}
        /**
         * menampilkan semua lookup_type
         * @return models
         */
        public static function getAllLookupType(){
            $data = array();
            $criteria = new CDbCriteria();
            $criteria->order = "lookup_type,lookup_urutan";
            $criteria->addCondition("lookup_aktif IS TRUE");
            $models=self::model()->findAll($criteria);
            return $models;
        }

}