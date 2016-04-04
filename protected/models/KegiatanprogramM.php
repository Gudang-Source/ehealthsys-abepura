<?php

/**
 * This is the model class for table "kegiatanprogram_m".
 *
 * The followings are the available columns in table 'kegiatanprogram_m':
 * @property integer $kegiatanprogram_id
 * @property integer $subprogramkerja_id
 * @property string $kegiatanprogram_kode
 * @property string $kegiatanprogram_nama
 * @property string $kegiatanprogram_namalain
 * @property string $kegiatanprogram_ket
 * @property boolean $kegiatanprogram_aktif
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 */
class KegiatanprogramM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return KegiatanprogramM the static model class
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
		return 'kegiatanprogram_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('subprogramkerja_id, kegiatanprogram_kode, kegiatanprogram_nama, kegiatanprogram_namalain, kegiatanprogram_aktif, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('subprogramkerja_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('kegiatanprogram_kode', 'length', 'max'=>5),
			array('kegiatanprogram_nama, kegiatanprogram_namalain', 'length', 'max'=>500),
			array('kegiatanprogram_ket, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('kegiatanprogram_id, subprogramkerja_id, kegiatanprogram_kode, kegiatanprogram_nama, kegiatanprogram_namalain, kegiatanprogram_ket, kegiatanprogram_aktif, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'kegiatanprogram_id' => 'Kegiatanprogram',
			'subprogramkerja_id' => 'Subprogramkerja',
			'kegiatanprogram_kode' => 'Kode',
			'kegiatanprogram_nama' => 'Kegiatan Program',
			'kegiatanprogram_namalain' => 'Nama Lain',
			'kegiatanprogram_ket' => 'Keterangan',
			'kegiatanprogram_aktif' => 'Aktif',
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

		if(!empty($this->kegiatanprogram_id)){
			$criteria->addCondition('kegiatanprogram_id = '.$this->kegiatanprogram_id);
		}
		if(!empty($this->subprogramkerja_id)){
			$criteria->addCondition('subprogramkerja_id = '.$this->subprogramkerja_id);
		}
		$criteria->compare('LOWER(kegiatanprogram_kode)',strtolower($this->kegiatanprogram_kode),true);
		$criteria->compare('LOWER(kegiatanprogram_nama)',strtolower($this->kegiatanprogram_nama),true);
		$criteria->compare('LOWER(kegiatanprogram_namalain)',strtolower($this->kegiatanprogram_namalain),true);
		$criteria->compare('LOWER(kegiatanprogram_ket)',strtolower($this->kegiatanprogram_ket),true);
		$criteria->compare('kegiatanprogram_aktif',$this->kegiatanprogram_aktif);
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