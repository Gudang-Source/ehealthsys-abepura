<?php

/**
 * This is the model class for table "potonganpinjamandari_t".
 *
 * The followings are the available columns in table 'potonganpinjamandari_t':
 * @property integer $potonganpinjamandari_id
 * @property integer $permohonanpinjaman_id
 * @property integer $potongansumber_id
 * @property integer $pinjaman_id
 * @property double $jumlahpotongan
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 */
class PotonganpinjamandariT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PotonganpinjamandariT the static model class
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
		return 'potonganpinjamandari_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('permohonanpinjaman_id, potongansumber_id, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('permohonanpinjaman_id, potongansumber_id, pinjaman_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('jumlahpotongan', 'numerical'),
			array('update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('potonganpinjamandari_id, permohonanpinjaman_id, potongansumber_id, pinjaman_id, jumlahpotongan, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'potonganpinjamandari_id' => 'Potonganpinjamandari',
			'permohonanpinjaman_id' => 'Permohonanpinjaman',
			'potongansumber_id' => 'Potongansumber',
			'pinjaman_id' => 'Pinjaman',
			'jumlahpotongan' => 'Jumlahpotongan',
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

		$criteria->compare('potonganpinjamandari_id',$this->potonganpinjamandari_id);
		$criteria->compare('permohonanpinjaman_id',$this->permohonanpinjaman_id);
		$criteria->compare('potongansumber_id',$this->potongansumber_id);
		$criteria->compare('pinjaman_id',$this->pinjaman_id);
		$criteria->compare('jumlahpotongan',$this->jumlahpotongan);
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