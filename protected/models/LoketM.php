<?php

/**
 * This is the model class for table "loket_m".
 *
 * The followings are the available columns in table 'loket_m':
 * @property integer $loket_id
 * @property integer $carabayar_id
 * @property string $loket_nama
 * @property string $loket_namalain
 * @property string $loket_fungsi
 * @property string $loket_singkatan
 * @property integer $loket_nourut
 * @property string $loket_formatnomor
 * @property boolean $loket_aktif
 */
class LoketM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return LoketM the static model class
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
		return 'loket_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('loket_nama, loket_fungsi, loket_nourut', 'required'),
			array('carabayar_id, loket_nourut', 'numerical', 'integerOnly'=>true),
			array('loket_nama, loket_namalain', 'length', 'max'=>50),
			array('loket_singkatan', 'length', 'max'=>1),
			array('loket_formatnomor', 'length', 'max'=>5),
			array('loket_aktif', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('loket_id, carabayar_id, loket_nama, loket_namalain, loket_fungsi, loket_singkatan, loket_nourut, loket_formatnomor, loket_aktif', 'safe', 'on'=>'search'),
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
			'carabayar' => array(self::BELONGS_TO, 'CarabayarM', 'carabayar_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'loket_id' => 'Loket',
			'carabayar_id' => 'Cara bayar',
			'loket_nama' => 'Nama Loket',
			'loket_namalain' => 'Nama lain',
			'loket_fungsi' => 'Fungsi',
			'loket_singkatan' => 'Singkatan',
			'loket_nourut' => 'No.urut',
			'loket_formatnomor' => 'Formatnomor',
			'loket_aktif' => 'Aktif',
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

		$criteria->compare('loket_id',$this->loket_id);
		$criteria->compare('carabayar_id',$this->carabayar_id);
		$criteria->compare('LOWER(loket_nama)',strtolower($this->loket_nama),true);
		$criteria->compare('LOWER(loket_namalain)',strtolower($this->loket_namalain),true);
		$criteria->compare('LOWER(loket_fungsi)',strtolower($this->loket_fungsi),true);
		$criteria->compare('LOWER(loket_singkatan)',strtolower($this->loket_singkatan),true);
		$criteria->compare('loket_nourut',$this->loket_nourut);
		$criteria->compare('LOWER(loket_formatnomor)',strtolower($this->loket_formatnomor),true);
		$criteria->compare('loket_aktif',isset($this->loket_aktif)?$this->loket_aktif:true);
                //$criteria->addCondition('loket_aktif is true');

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('loket_id',$this->loket_id);
		$criteria->compare('carabayar_id',$this->carabayar_id);
		$criteria->compare('LOWER(loket_nama)',strtolower($this->loket_nama),true);
		$criteria->compare('LOWER(loket_namalain)',strtolower($this->loket_namalain),true);
		$criteria->compare('LOWER(loket_fungsi)',strtolower($this->loket_fungsi),true);
		$criteria->compare('LOWER(loket_singkatan)',strtolower($this->loket_singkatan),true);
		$criteria->compare('loket_nourut',$this->loket_nourut);
		$criteria->compare('LOWER(loket_formatnomor)',strtolower($this->loket_formatnomor),true);
		//$criteria->compare('loket_aktif',$this->loket_aktif);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
}