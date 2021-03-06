<?php

/**
 * This is the model class for table "kegiatanradiologi_r".
 *
 * The followings are the available columns in table 'kegiatanradiologi_r':
 * @property integer $kegiatanradiologi_id
 * @property string $tanggal
 * @property integer $jenispemeriksaanrad_id
 * @property string $jenispemeriksaanrad_nama
 * @property integer $jumlah
 */
class KegiatanradiologiR extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return KegiatanradiologiR the static model class
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
		return 'kegiatanradiologi_r';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('jenispemeriksaanrad_id, jumlah', 'numerical', 'integerOnly'=>true),
			array('jenispemeriksaanrad_nama', 'length', 'max'=>100),
			array('tanggal', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('kegiatanradiologi_id, tanggal, jenispemeriksaanrad_id, jenispemeriksaanrad_nama, jumlah', 'safe', 'on'=>'search'),
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
			'kegiatanradiologi_id' => 'Kegiatanradiologi',
			'tanggal' => 'Tanggal',
			'jenispemeriksaanrad_id' => 'Jenispemeriksaanrad',
			'jenispemeriksaanrad_nama' => 'Jenispemeriksaanrad Nama',
			'jumlah' => 'Jumlah',
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

		if(!empty($this->kegiatanradiologi_id)){
			$criteria->addCondition('kegiatanradiologi_id = '.$this->kegiatanradiologi_id);
		}
		$criteria->compare('LOWER(tanggal)',strtolower($this->tanggal),true);
		if(!empty($this->jenispemeriksaanrad_id)){
			$criteria->addCondition('jenispemeriksaanrad_id = '.$this->jenispemeriksaanrad_id);
		}
		$criteria->compare('LOWER(jenispemeriksaanrad_nama)',strtolower($this->jenispemeriksaanrad_nama),true);
		if(!empty($this->jumlah)){
			$criteria->addCondition('jumlah = '.$this->jumlah);
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