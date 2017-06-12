<?php

/**
 * This is the model class for table "shiftberlaku_m".
 *
 * The followings are the available columns in table 'shiftberlaku_m':
 * @property integer $shiftberlaku_id
 * @property integer $shift_id
 * @property string $shiftberlaku_tgl
 * @property string $shiftberlaku_jmasuk
 * @property string $shiftberlaku_jmasuk_mulai
 * @property string $shiftberlaku_jmasuk_akhir
 * @property string $shiftberlaku_jpulang
 * @property string $shiftberlaku_jpulang_mulai
 * @property string $shiftberlaku_jpulang_akhir
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 *
 * The followings are the available model relations:
 * @property ShiftM $shift
 */
class ShiftberlakuM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ShiftberlakuM the static model class
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
		return 'shiftberlaku_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('shift_id, shiftberlaku_tgl, shiftberlaku_jmasuk, shiftberlaku_jmasuk_mulai, shiftberlaku_jmasuk_akhir, shiftberlaku_jpulang, shiftberlaku_jpulang_mulai, shiftberlaku_jpulang_akhir, create_time, create_loginpemakai_id', 'required'),
			array('shift_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('shiftberlaku_id, shift_id, shiftberlaku_tgl, shiftberlaku_jmasuk, shiftberlaku_jmasuk_mulai, shiftberlaku_jmasuk_akhir, shiftberlaku_jpulang, shiftberlaku_jpulang_mulai, shiftberlaku_jpulang_akhir, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'shift' => array(self::BELONGS_TO, 'ShiftM', 'shift_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'shiftberlaku_id' => 'Shiftberlaku',
			'shift_id' => 'Shift',
			'shiftberlaku_tgl' => 'Shiftberlaku Tgl',
			'shiftberlaku_jmasuk' => 'Shiftberlaku Jmasuk',
			'shiftberlaku_jmasuk_mulai' => 'Shiftberlaku Jmasuk Mulai',
			'shiftberlaku_jmasuk_akhir' => 'Shiftberlaku Jmasuk Akhir',
			'shiftberlaku_jpulang' => 'Shiftberlaku Jpulang',
			'shiftberlaku_jpulang_mulai' => 'Shiftberlaku Jpulang Mulai',
			'shiftberlaku_jpulang_akhir' => 'Shiftberlaku Jpulang Akhir',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'create_loginpemakai_id' => 'Create Loginpemakai',
			'update_loginpemakai_id' => 'Update Loginpemakai',
			'create_ruangan' => 'Create Ruangan',
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

		$criteria->compare('shiftberlaku_id',$this->shiftberlaku_id);
		$criteria->compare('shift_id',$this->shift_id);
		$criteria->compare('shiftberlaku_tgl',$this->shiftberlaku_tgl,true);
		$criteria->compare('shiftberlaku_jmasuk',$this->shiftberlaku_jmasuk,true);
		$criteria->compare('shiftberlaku_jmasuk_mulai',$this->shiftberlaku_jmasuk_mulai,true);
		$criteria->compare('shiftberlaku_jmasuk_akhir',$this->shiftberlaku_jmasuk_akhir,true);
		$criteria->compare('shiftberlaku_jpulang',$this->shiftberlaku_jpulang,true);
		$criteria->compare('shiftberlaku_jpulang_mulai',$this->shiftberlaku_jpulang_mulai,true);
		$criteria->compare('shiftberlaku_jpulang_akhir',$this->shiftberlaku_jpulang_akhir,true);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id);
		$criteria->compare('create_ruangan',$this->create_ruangan);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}