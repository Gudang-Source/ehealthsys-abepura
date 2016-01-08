<?php

/**
 * This is the model class for table "metodegcs_m".
 *
 * The followings are the available columns in table 'metodegcs_m':
 * @property integer $metodegcs_id
 * @property string $metodegcs_nama
 * @property string $metodegcs_singkatan
 * @property integer $metodegcs_nilai
 * @property boolean $metodegcs_aktif
 */
class MetodegcsM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return MetodegcsM the static model class
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
		return 'metodegcs_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('metodegcs_nama', 'required'),
			array('metodegcs_nilai', 'numerical', 'integerOnly'=>true),
			array('metodegcs_nama', 'length', 'max'=>300),
			array('metodegcs_singkatan', 'length', 'max'=>1),
			array('metodegcs_aktif', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('metodegcs_id, metodegcs_nama, metodegcs_singkatan, metodegcs_nilai, metodegcs_aktif', 'safe', 'on'=>'search'),
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
			'metodegcs_id' => 'Metodegcs',
			'metodegcs_nama' => 'Metodegcs Nama',
			'metodegcs_singkatan' => 'Metodegcs Singkatan',
			'metodegcs_nilai' => 'Metodegcs Nilai',
			'metodegcs_aktif' => 'Metodegcs Aktif',
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

		$criteria->compare('metodegcs_id',$this->metodegcs_id);
		$criteria->compare('LOWER(metodegcs_nama)',strtolower($this->metodegcs_nama),true);
		$criteria->compare('LOWER(metodegcs_singkatan)',strtolower($this->metodegcs_singkatan),true);
		$criteria->compare('metodegcs_nilai',$this->metodegcs_nilai);
		$criteria->compare('metodegcs_aktif',$this->metodegcs_aktif);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('metodegcs_id',$this->metodegcs_id);
		$criteria->compare('LOWER(metodegcs_nama)',strtolower($this->metodegcs_nama),true);
		$criteria->compare('LOWER(metodegcs_singkatan)',strtolower($this->metodegcs_singkatan),true);
		$criteria->compare('metodegcs_nilai',$this->metodegcs_nilai);
		$criteria->compare('metodegcs_aktif',$this->metodegcs_aktif);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
}