<?php

/**
 * This is the model class for table "pemeriksaanpartografobat_t".
 *
 * The followings are the available columns in table 'pemeriksaanpartografobat_t':
 * @property integer $pemeriksaanpartografobat_id
 * @property integer $pemeriksaanpartograf_id
 * @property integer $obatalkes_id
 * @property integer $obatalkes_jumlah
 */
class PemeriksaanpartografobatT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PemeriksaanpartografobatT the static model class
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
		return 'pemeriksaanpartografobat_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pemeriksaanpartograf_id, obatalkes_id', 'required'),
			array('pemeriksaanpartograf_id, obatalkes_id, obatalkes_jumlah', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pemeriksaanpartografobat_id, pemeriksaanpartograf_id, obatalkes_id, obatalkes_jumlah', 'safe', 'on'=>'search'),
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
                    'obatAlkes' => array(self::BELONGS_TO, 'ObatalkesT', 'obatalkes_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'pemeriksaanpartografobat_id' => 'Pemeriksaanpartografobat',
			'pemeriksaanpartograf_id' => 'Pemeriksaanpartograf',
			'obatalkes_id' => 'Obatalkes',
			'obatalkes_jumlah' => 'Obatalkes Jumlah',
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

		$criteria->compare('pemeriksaanpartografobat_id',$this->pemeriksaanpartografobat_id);
		$criteria->compare('pemeriksaanpartograf_id',$this->pemeriksaanpartograf_id);
		$criteria->compare('obatalkes_id',$this->obatalkes_id);
		$criteria->compare('obatalkes_jumlah',$this->obatalkes_jumlah);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}