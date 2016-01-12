<?php

/**
 * This is the model class for table "unitkerja_m".
 *
 * The followings are the available columns in table 'unitkerja_m':
 * @property integer $unitkerja_id
 * @property string $kodeunitkerja
 * @property string $namaunitkerja
 * @property string $namalain
 * @property boolean $unitkerja_aktif
 *
 * The followings are the available model relations:
 * @property RuanganM[] $ruanganMs
 */
class UnitkerjaM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return UnitkerjaM the static model class
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
		return 'unitkerja_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('kodeunitkerja, namaunitkerja', 'required'),
			array('kodeunitkerja', 'length', 'max'=>50),
			array('namaunitkerja, namalain', 'length', 'max'=>200),
			array('unitkerja_aktif', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('unitkerja_id, kodeunitkerja, namaunitkerja, namalain, unitkerja_aktif', 'safe', 'on'=>'search'),
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
			'ruanganMs' => array(self::MANY_MANY, 'RuanganM', 'unitkerjaruangan_m(unitkerja_id, ruangan_id)'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'unitkerja_id' => 'Unitkerja',
			'kodeunitkerja' => 'Kode',
			'namaunitkerja' => 'Nama Unit',
			'namalain' => 'Nama Lain',
			'unitkerja_aktif' => 'Aktif',
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

		if(!empty($this->unitkerja_id)){
			$criteria->addCondition('unitkerja_id = '.$this->unitkerja_id);
		}
		$criteria->compare('LOWER(kodeunitkerja)',strtolower($this->kodeunitkerja),true);
		$criteria->compare('LOWER(namaunitkerja)',strtolower($this->namaunitkerja),true);
		$criteria->compare('LOWER(namalain)',strtolower($this->namalain),true);
		if(!empty($this->unitkerja_aktif)){
			$criteria->addCondition('unitkerja_aktif = '.$this->unitkerja_aktif);
		}

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