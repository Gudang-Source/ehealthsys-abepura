<?php

/**
 * This is the model class for table "shift_m".
 *
 * The followings are the available columns in table 'shift_m':
 * @property integer $shift_id
 * @property string $shift_nama
 * @property string $shift_namalainnya
 * @property string $shift_jamawal
 * @property string $shift_jamakhir
 * @property boolean $shift_aktif
 */
class ShiftM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ShiftM the static model class
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
		return 'shift_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('shift_nama, shift_jamawal, shift_jamakhir, shift_aktif', 'required'),
			array('shift_nama, shift_namalainnya', 'length', 'max'=>50),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('shift_id, shift_nama, shift_namalainnya, shift_jamawal, shift_jamakhir, shift_aktif', 'safe', 'on'=>'search'),
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
			'shift_id' => 'Shift',
			'shift_nama' => 'Nama Shift',
			'shift_namalainnya' => 'Nama Lain Shift',
			'shift_jamawal' => 'Jam Awal Shift',
			'shift_jamakhir' => 'Jam Akhir Shift',
			'shift_aktif' => 'Aktif',
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
		
		$criteria->compare('shift_id',$this->shift_id);
		$criteria->compare('LOWER(shift_nama)',strtolower($this->shift_nama),true);
		$criteria->compare('LOWER(shift_namalainnya)',strtolower($this->shift_namalainnya),true);

		if((!empty($this->shift_jamawal))&&(strlen($this->shift_jamawal)>3)){
			$criteria->addCondition("shift_jamawal = '".$this->shift_jamawal."'");
		}
		if((!empty($this->shift_jamakhir))&&(strlen($this->shift_jamakhir)>3)){
			$criteria->addCondition("shift_jamakhir = '".$this->shift_jamakhir."'");
		}
		$criteria->compare('shift_aktif',isset($this->shift_aktif)?$this->shift_aktif:true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		
		$criteria->compare('shift_id',$this->shift_id);
		$criteria->compare('LOWER(shift_nama)',strtolower($this->shift_nama),true);
		$criteria->compare('LOWER(shift_namalainnya)',strtolower($this->shift_namalainnya),true);

		if((!empty($this->shift_jamawal))&&(strlen($this->shift_jamawal)>3)){
			$criteria->addCondition("shift_jamawal = '".$this->shift_jamawal."'");
		}
		if((!empty($this->shift_jamakhir))&&(strlen($this->shift_jamakhir)>3)){
			$criteria->addCondition("shift_jamakhir = '".$this->shift_jamakhir."'");
		}
		$criteria->compare('shift_aktif',isset($this->shift_aktif)?$this->shift_aktif:true);
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
        
         public function beforeSave() {
            $this->shift_nama = ucwords(strtolower($this->shift_nama));
            $this->shift_namalainnya = strtoupper($this->shift_namalainnya);
            return parent::beforeSave();
        }
}