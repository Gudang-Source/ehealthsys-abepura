<?php

/**
 * This is the model class for table "riwayatkb_t".
 *
 * The followings are the available columns in table 'riwayatkb_t':
 * @property integer $riwayatkb_id
 * @property integer $pemeriksaanginekologi_id
 * @property boolean $kb_status
 * @property string $kb_pasang
 * @property string $kb_lepas
 * @property string $kb_jenis
 * @property string $kb_periksaluar
 * @property string $kb_periksadalam
 * @property string $kb_keterangan
 *
 * The followings are the available model relations:
 * @property PemeriksaanginekologiT $pemeriksaanginekologi
 */
class RiwayatkbT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return RiwayatkbT the static model class
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
		return 'riwayatkb_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pemeriksaanginekologi_id', 'required'),
			array('pemeriksaanginekologi_id', 'numerical', 'integerOnly'=>true),
			array('kb_jenis', 'length', 'max'=>100),
			array('kb_keterangan', 'length', 'max'=>255),
			array('kb_status, kb_pasang, kb_lepas', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('riwayatkb_id, pemeriksaanginekologi_id, kb_status, kb_pasang, kb_lepas, kb_jenis, kb_keterangan', 'safe', 'on'=>'search'),
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
			'pemeriksaanginekologi' => array(self::BELONGS_TO, 'PemeriksaanginekologiT', 'pemeriksaanginekologi_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'riwayatkb_id' => 'ID',
			'pemeriksaanginekologi_id' => 'Pemeriksaan Ginekologi',
			'kb_status' => 'Status',
			'kb_pasang' => 'Pasang',
			'kb_lepas' => 'Lepas',
			'kb_jenis' => 'Jenis',
			'kb_periksaluar' => 'Periksa Luar',
			'kb_periksadalam' => 'Periksa Dalam',
			'kb_keterangan' => 'Keterangan',
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

		$criteria->compare('riwayatkb_id',$this->riwayatkb_id);
		$criteria->compare('pemeriksaanginekologi_id',$this->pemeriksaanginekologi_id);
		$criteria->compare('kb_status',$this->kb_status);
		$criteria->compare('kb_pasang',$this->kb_pasang,true);
		$criteria->compare('kb_lepas',$this->kb_lepas,true);
		$criteria->compare('kb_jenis',$this->kb_jenis,true);
		$criteria->compare('kb_periksaluar',$this->kb_periksaluar,true);
		$criteria->compare('kb_periksadalam',$this->kb_periksadalam,true);
		$criteria->compare('kb_keterangan',$this->kb_keterangan,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}