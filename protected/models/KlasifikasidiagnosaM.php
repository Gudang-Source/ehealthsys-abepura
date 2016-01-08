<?php

/**
 * This is the model class for table "klasifikasidiagnosa_m".
 *
 * The followings are the available columns in table 'klasifikasidiagnosa_m':
 * @property integer $klasifikasidiagnosa_id
 * @property string $klasifikasidiagnosa_kode
 * @property string $klasifikasidiagnosa_nama
 * @property string $klasifikasidiagnosa_namalain
 * @property boolean $klasifikasidiagnosa_aktif
 * @property string $klasifikasidiagnosa_desc
 *
 * The followings are the available model relations:
 * @property DiagnosaM[] $diagnosaMs
 */
class KlasifikasidiagnosaM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return KlasifikasidiagnosaM the static model class
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
		return 'klasifikasidiagnosa_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('klasifikasidiagnosa_id, klasifikasidiagnosa_kode, klasifikasidiagnosa_nama, klasifikasidiagnosa_aktif', 'required'),
			array('klasifikasidiagnosa_id', 'numerical', 'integerOnly'=>true),
			array('klasifikasidiagnosa_kode', 'length', 'max'=>10),
			array('klasifikasidiagnosa_nama', 'length', 'max'=>500),
			array('klasifikasidiagnosa_namalain, klasifikasidiagnosa_desc', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('klasifikasidiagnosa_id, klasifikasidiagnosa_kode, klasifikasidiagnosa_nama, klasifikasidiagnosa_namalain, klasifikasidiagnosa_aktif, klasifikasidiagnosa_desc', 'safe', 'on'=>'search'),
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
			'diagnosaMs' => array(self::HAS_MANY, 'DiagnosaM', 'klasifikasidiagnosa_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'klasifikasidiagnosa_id' => 'Klasifikasi Diagnosa',
			'klasifikasidiagnosa_kode' => 'Kode Klasifikasi',
			'klasifikasidiagnosa_nama' => 'Nama Klasifikasi',
			'klasifikasidiagnosa_namalain' => 'Nama Lain',
			'klasifikasidiagnosa_aktif' => 'Klasifikasi Aktif',
			'klasifikasidiagnosa_desc' => 'Deskripsi Klasifikasi',
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

		if(!empty($this->klasifikasidiagnosa_id)){
			$criteria->addCondition('klasifikasidiagnosa_id = '.$this->klasifikasidiagnosa_id);
		}
		$criteria->compare('LOWER(klasifikasidiagnosa_kode)',strtolower($this->klasifikasidiagnosa_kode),true);
		$criteria->compare('LOWER(klasifikasidiagnosa_nama)',strtolower($this->klasifikasidiagnosa_nama),true);
		$criteria->compare('LOWER(klasifikasidiagnosa_namalain)',strtolower($this->klasifikasidiagnosa_namalain),true);
		$criteria->compare('klasifikasidiagnosa_aktif',$this->klasifikasidiagnosa_aktif);
		$criteria->compare('LOWER(klasifikasidiagnosa_desc)',strtolower($this->klasifikasidiagnosa_desc),true);

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
		/**
		 * menampilkan kode dan nama
		 * @return type
		 */
		public function getKlasifikasiKodeNama(){
			return $this->klasifikasidiagnosa_kode." - ".$this->klasifikasidiagnosa_nama;
		}
}