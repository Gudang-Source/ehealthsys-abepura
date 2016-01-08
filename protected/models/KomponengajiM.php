<?php

/**
 * This is the model class for table "komponengaji_m".
 *
 * The followings are the available columns in table 'komponengaji_m':
 * @property integer $komponengaji_id
 * @property integer $nourutgaji
 * @property string $komponengaji_kode
 * @property string $komponengaji_nama
 * @property string $komponengaji_singkt
 * @property boolean $ispotongan
 * @property boolean $komponengaji_aktif
 */
class KomponengajiM extends CActiveRecord
{
	public $penerimaan;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return KomponengajiM the static model class
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
		return 'komponengaji_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('nourutgaji, komponengaji_kode, komponengaji_nama, komponengaji_singkt', 'required'),
			array('nourutgaji', 'numerical', 'integerOnly'=>true),
			array('komponengaji_kode', 'length', 'max'=>50),
			array('komponengaji_nama', 'length', 'max'=>100),
			array('komponengaji_singkt', 'length', 'max'=>20),
			array('ispotongan, komponengaji_aktif', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('komponengaji_id, nourutgaji, komponengaji_kode, komponengaji_nama, komponengaji_singkt, ispotongan, komponengaji_aktif', 'safe', 'on'=>'search'),
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
			'komponengaji_id' => 'Komponen Gaji',
			'nourutgaji' => 'No. Urut Gaji',
			'komponengaji_kode' => 'Kode Gaji',
			'komponengaji_nama' => 'Nama Gaji',
			'komponengaji_singkt' => 'Singkatan Gaji',
			'ispotongan' => 'Potongan',
			'komponengaji_aktif' => 'Gaji Aktif',
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

		$criteria->compare('komponengaji_id',$this->komponengaji_id);
		$criteria->compare('nourutgaji',$this->nourutgaji);
		$criteria->compare('LOWER(komponengaji_kode)',strtolower($this->komponengaji_kode),true);
		$criteria->compare('LOWER(komponengaji_nama)',strtolower($this->komponengaji_nama),true);
		$criteria->compare('LOWER(komponengaji_singkt)',strtolower($this->komponengaji_singkt),true);
		$criteria->compare('ispotongan',isset($this->ispotongan)?$this->ispotongan:0);
		$criteria->compare('komponengaji_aktif',isset($this->komponengaji_aktif)?$this->komponengaji_aktif:true);
                //$criteria->addCondition('komponengaji_aktif is true');

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('komponengaji_id',$this->komponengaji_id);
		$criteria->compare('nourutgaji',$this->nourutgaji);
		$criteria->compare('LOWER(komponengaji_kode)',strtolower($this->komponengaji_kode),true);
		$criteria->compare('LOWER(komponengaji_nama)',strtolower($this->komponengaji_nama),true);
		$criteria->compare('LOWER(komponengaji_singkt)',strtolower($this->komponengaji_singkt),true);
		$criteria->compare('ispotongan',$this->ispotongan);
		$criteria->compare('komponengaji_aktif',$this->komponengaji_aktif);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
}