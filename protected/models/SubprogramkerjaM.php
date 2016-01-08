<?php

/**
 * This is the model class for table "subprogramkerja_m".
 *
 * The followings are the available columns in table 'subprogramkerja_m':
 * @property integer $subprogramkerja_id
 * @property integer $programkerja_id
 * @property string $subprogramkerja_kode
 * @property string $subprogramkerja_nama
 * @property string $subprogramkerja_namalain
 * @property string $subprogramkerja_ket
 * @property integer $subprogramkerja_nourut
 * @property boolean $subprogramkerja_aktif
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 */
class SubprogramkerjaM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return SubprogramkerjaM the static model class
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
		return 'subprogramkerja_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('programkerja_id, subprogramkerja_kode, subprogramkerja_nama, subprogramkerja_namalain, subprogramkerja_nourut, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('programkerja_id, subprogramkerja_nourut, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('subprogramkerja_kode', 'length', 'max'=>5),
			array('subprogramkerja_nama, subprogramkerja_namalain', 'length', 'max'=>500),
			array('subprogramkerja_ket, subprogramkerja_aktif, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('subprogramkerja_id, programkerja_id, subprogramkerja_kode, subprogramkerja_nama, subprogramkerja_namalain, subprogramkerja_ket, subprogramkerja_nourut, subprogramkerja_aktif, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'subprogramkerja_id' => 'Subprogramkerja',
			'programkerja_id' => 'ID Programkerja',
			'subprogramkerja_kode' => 'Kode',
			'subprogramkerja_nama' => 'Nama Sub Program',
			'subprogramkerja_namalain' => 'Nama Lain',
			'subprogramkerja_ket' => 'Keterangan',
			'subprogramkerja_nourut' => 'Subprogramkerja Nourut',
			'subprogramkerja_aktif' => 'Aktif',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'create_loginpemakai_id' => 'Create Loginpemakai',
			'update_loginpemakai_id' => 'Update Loginpemakai',
			'create_ruangan' => 'Create Ruangan',
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

		if(!empty($this->subprogramkerja_id)){
			$criteria->addCondition('subprogramkerja_id = '.$this->subprogramkerja_id);
		}
		if(!empty($this->programkerja_id)){
			$criteria->addCondition('programkerja_id = '.$this->programkerja_id);
		}
		$criteria->compare('LOWER(subprogramkerja_kode)',strtolower($this->subprogramkerja_kode),true);
		$criteria->compare('LOWER(subprogramkerja_nama)',strtolower($this->subprogramkerja_nama),true);
		$criteria->compare('LOWER(subprogramkerja_namalain)',strtolower($this->subprogramkerja_namalain),true);
		$criteria->compare('LOWER(subprogramkerja_ket)',strtolower($this->subprogramkerja_ket),true);
		if(!empty($this->subprogramkerja_nourut)){
			$criteria->addCondition('subprogramkerja_nourut = '.$this->subprogramkerja_nourut);
		}
		$criteria->compare('subprogramkerja_aktif',$this->subprogramkerja_aktif);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		if(!empty($this->create_loginpemakai_id)){
			$criteria->addCondition('create_loginpemakai_id = '.$this->create_loginpemakai_id);
		}
		if(!empty($this->update_loginpemakai_id)){
			$criteria->addCondition('update_loginpemakai_id = '.$this->update_loginpemakai_id);
		}
		if(!empty($this->create_ruangan)){
			$criteria->addCondition('create_ruangan = '.$this->create_ruangan);
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