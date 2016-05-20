<?php

/**
 * This is the model class for table "lokasiaset_m".
 *
 * The followings are the available columns in table 'lokasiaset_m':
 * @property integer $lokasi_id
 * @property string $lokasiaset_kode
 * @property string $lokasiaset_namainstalasi
 * @property string $lokasiaset_namabagian
 * @property string $lokasiaset_namalokasi
 * @property boolean $lokasiaset_aktif
 * @property double $garis_latitude
 * @property double $garis_longitude
 *
 * The followings are the available model relations:
 * @property InvtanahT[] $invtanahTs
 * @property InvperalatanT[] $invperalatanTs
 * @property InvgedungT[] $invgedungTs
 * @property InvjalanT[] $invjalanTs
 * @property InvasetlainT[] $invasetlainTs
 */
class LokasiasetM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return LokasiasetM the static model class
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
		return 'lokasiaset_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('lokasiaset_kode, lokasiaset_namalokasi', 'required'),
			array('garis_latitude, garis_longitude', 'numerical'),
			array('lokasiaset_kode, lokasiaset_namabagian', 'length', 'max'=>50),
			array('lokasiaset_namainstalasi, lokasiaset_namalokasi', 'length', 'max'=>100),
			array('lokasiaset_aktif', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('lokasi_id, lokasiaset_kode, lokasiaset_namainstalasi, lokasiaset_namabagian, lokasiaset_namalokasi, lokasiaset_aktif, garis_latitude, garis_longitude', 'safe', 'on'=>'search'),
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
			'invtanahTs' => array(self::HAS_MANY, 'InvtanahT', 'lokasi_id'),
			'invperalatanTs' => array(self::HAS_MANY, 'InvperalatanT', 'lokasi_id'),
			'invgedungTs' => array(self::HAS_MANY, 'InvgedungT', 'lokasi_id'),
			'invjalanTs' => array(self::HAS_MANY, 'InvjalanT', 'lokasi_id'),
			'invasetlainTs' => array(self::HAS_MANY, 'InvasetlainT', 'lokasi_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'lokasi_id' => 'ID',
			'lokasiaset_kode' => 'Aset Kode',
			'lokasiaset_namainstalasi' => 'Nama Instalasi',
			'lokasiaset_namabagian' => 'Nama Bagian',
			'lokasiaset_namalokasi' => 'Nama Lokasi',
			'lokasiaset_aktif' => 'Lokasi Aset Aktif',
			'garis_latitude' => 'Garis Latitude',
			'garis_longitude' => 'Garis Longitude',
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

		if(!empty($this->lokasi_id)){
			$criteria->addCondition('lokasi_id = '.$this->lokasi_id);
		}
		$criteria->compare('LOWER(lokasiaset_kode)',strtolower($this->lokasiaset_kode),true);
		$criteria->compare('LOWER(lokasiaset_namainstalasi)',strtolower($this->lokasiaset_namainstalasi),true);
		$criteria->compare('LOWER(lokasiaset_namabagian)',strtolower($this->lokasiaset_namabagian),true);
		$criteria->compare('LOWER(lokasiaset_namalokasi)',strtolower($this->lokasiaset_namalokasi),true);
		$criteria->compare('lokasiaset_aktif',isset($this->lokasiaset_aktif)?$this->lokasiaset_aktif:true);
		$criteria->compare('garis_latitude',$this->garis_latitude);
		$criteria->compare('garis_longitude',$this->garis_longitude);

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