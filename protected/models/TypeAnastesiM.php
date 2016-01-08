<?php

/**
 * This is the model class for table "typeanastesi_m".
 *
 * The followings are the available columns in table 'typeanastesi_m':
 * @property string $typeanastesi_id
 * @property integer $anastesi_id
 * @property string $typeanastesi_nama
 * @property string $typeanastesi_namalainnya
 */
class TypeAnastesiM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TypeAnastesiM the static model class
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
		return 'typeanastesi_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('typeanastesi_id', 'required'),
			array('anastesi_id', 'numerical', 'integerOnly'=>true),
			array('typeanastesi_id, typeanastesi_nama, typeanastesi_namalainnya', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('typeanastesi_id, anastesi_id, typeanastesi_nama, typeanastesi_namalainnya', 'safe', 'on'=>'search'),
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
			'typeanastesi_id' => 'Typeanastesi',
			'anastesi_id' => 'Anastesi',
			'typeanastesi_nama' => 'Typeanastesi Nama',
			'typeanastesi_namalainnya' => 'Typeanastesi Namalainnya',
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

		$criteria->compare('LOWER(typeanastesi_id)',strtolower($this->typeanastesi_id),true);
		$criteria->compare('anastesi_id',$this->anastesi_id);
		$criteria->compare('LOWER(typeanastesi_nama)',strtolower($this->typeanastesi_nama),true);
		$criteria->compare('LOWER(typeanastesi_namalainnya)',strtolower($this->typeanastesi_namalainnya),true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('LOWER(typeanastesi_id)',strtolower($this->typeanastesi_id),true);
		$criteria->compare('anastesi_id',$this->anastesi_id);
		$criteria->compare('LOWER(typeanastesi_nama)',strtolower($this->typeanastesi_nama),true);
		$criteria->compare('LOWER(typeanastesi_namalainnya)',strtolower($this->typeanastesi_namalainnya),true);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
}