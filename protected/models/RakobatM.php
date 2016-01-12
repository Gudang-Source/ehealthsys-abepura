<?php

/**
 * This is the model class for table "rakobat_m".
 *
 * The followings are the available columns in table 'rakobat_m':
 * @property integer $rakobat_id
 * @property string $rakobat_nama
 * @property string $rakobat_namalain
 * @property string $rakobat_label
 * @property boolean $rakobat_aktif
 *
 * The followings are the available model relations:
 * @property StokobatalkesT[] $stokobatalkesTs
 */
class RakobatM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return RakobatM the static model class
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
		return 'rakobat_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('rakobat_nama, rakobat_namalain, rakobat_label', 'required'),
			array('rakobat_nama, rakobat_namalain', 'length', 'max'=>200),
			array('rakobat_label', 'length', 'max'=>1),
			array('rakobat_aktif', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('rakobat_id, rakobat_nama, rakobat_namalain, rakobat_label, rakobat_aktif', 'safe', 'on'=>'search'),
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
			'stokobatalkesTs' => array(self::HAS_MANY, 'StokobatalkesT', 'rakobat_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'rakobat_id' => 'Rak Obat ID',
			'rakobat_nama' => 'Rak Obat',
			'rakobat_namalain' => 'Rak Obat Lainnya',
			'rakobat_label' => 'Rak Obat Label',
			'rakobat_aktif' => 'Rak Obat Aktif',
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
        
		if(!empty($this->rakobat_id)){
			$criteria->addCondition('rakobat_id = '.$this->rakobat_id);
		}
		$criteria->compare('LOWER(rakobat_nama)',strtolower($this->rakobat_nama),true);
		$criteria->compare('LOWER(rakobat_namalain)',strtolower($this->rakobat_namalain),true);
		$criteria->compare('LOWER(rakobat_label)',strtolower($this->rakobat_label),true);
		$criteria->compare('rakobat_aktif',$this->rakobat_aktif);
        
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