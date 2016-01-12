<?php

/**
 * This is the model class for table "sumberanggaran_m".
 *
 * The followings are the available columns in table 'sumberanggaran_m':
 * @property integer $sumberanggaran_id
 * @property string $kodesumberanggaran
 * @property string $sumberanggarannama
 * @property string $sumberanggarannamalain
 * @property boolean $sumberanggaran_aktif
 */
class SumberanggaranM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return SumberanggaranM the static model class
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
		return 'sumberanggaran_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('kodesumberanggaran, sumberanggarannama, sumberanggarannamalain', 'required'),
			array('kodesumberanggaran', 'length', 'max'=>5),
			array('sumberanggarannama, sumberanggarannamalain', 'length', 'max'=>200),
			array('sumberanggaran_aktif', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('sumberanggaran_id, kodesumberanggaran, sumberanggarannama, sumberanggarannamalain, sumberanggaran_aktif', 'safe', 'on'=>'search'),
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
			'sumberanggaran_id' => 'Sumber Anggaran',
			'kodesumberanggaran' => 'Kode Sumber Anggaran',
			'sumberanggarannama' => 'Nama Sumber Anggaran',
			'sumberanggarannamalain' => 'Nama Lain',
			'sumberanggaran_aktif' => 'Sumber Anggaran Aktif',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CdbCriteria that can return criterias.
	 */
	public function criteriaSearch()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		if(!empty($this->sumberanggaran_id)){
			$criteria->addCondition('sumberanggaran_id = '.$this->sumberanggaran_id);
		}
		$criteria->compare('LOWER(kodesumberanggaran)',strtolower($this->kodesumberanggaran),true);
		$criteria->compare('LOWER(sumberanggarannama)',strtolower($this->sumberanggarannama),true);
		$criteria->compare('LOWER(sumberanggarannamalain)',strtolower($this->sumberanggarannamalain),true);
		$criteria->compare('sumberanggaran_aktif',$this->sumberanggaran_aktif);

		return $criteria;
	}
        
        
        /**
         * Retrieves a list of models based on the current search/filter conditions.
         * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
         */
        public function search()
        {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria=$this->criteriaSearch();
            $criteria->limit=10;

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));
        }


        public function searchPrint()
        {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria=$this->criteriaSearch();
            $criteria->limit=-1; 

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
                    'pagination'=>false,
            ));
        }
}