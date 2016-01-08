<?php

/**
 * This is the model class for table "subkegiatanprogram_m".
 *
 * The followings are the available columns in table 'subkegiatanprogram_m':
 * @property integer $subkegiatanprogram_id
 * @property integer $kegiatanprogram_id
 * @property string $subkegiatanprogram_kode
 * @property string $subkegiatanprogram_nama
 * @property string $subkegiatanprogram_namalain
 * @property string $subkegiatanprogram_ket
 * @property integer $rekeningdebit_id
 * @property integer $rekeningkredit_id
 * @property boolean $subkegiatanprogram_aktif
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 */
class SubkegiatanprogramM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return SubkegiatanprogramM the static model class
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
		return 'subkegiatanprogram_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('kegiatanprogram_id, subkegiatanprogram_nama, subkegiatanprogram_namalain, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('kegiatanprogram_id, rekeningdebit_id, rekeningkredit_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('subkegiatanprogram_kode', 'length', 'max'=>5),
			array('subkegiatanprogram_nama, subkegiatanprogram_namalain', 'length', 'max'=>500),
			array('subkegiatanprogram_ket, subkegiatanprogram_aktif, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('subkegiatanprogram_id, kegiatanprogram_id, subkegiatanprogram_kode, subkegiatanprogram_nama, subkegiatanprogram_namalain, subkegiatanprogram_ket, rekeningdebit_id, rekeningkredit_id, subkegiatanprogram_aktif, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'subkegiatanprogram_id' => 'ID Sub Kegiatan Program',
			'kegiatanprogram_id' => 'ID Kegiatan Program',
			'subkegiatanprogram_kode' => 'Kode',
			'subkegiatanprogram_nama' => 'Nama Sub Kegiatan',
			'subkegiatanprogram_namalain' => 'Nama Lain',
			'subkegiatanprogram_ket' => 'Keterangan',
			'rekeningdebit_id' => 'Rekeningdebit',
			'rekeningkredit_id' => 'Rekeningkredit',
			'subkegiatanprogram_aktif' => 'Aktif',
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

		if(!empty($this->subkegiatanprogram_id)){
			$criteria->addCondition('subkegiatanprogram_id = '.$this->subkegiatanprogram_id);
		}
		if(!empty($this->kegiatanprogram_id)){
			$criteria->addCondition('kegiatanprogram_id = '.$this->kegiatanprogram_id);
		}
		$criteria->compare('LOWER(subkegiatanprogram_kode)',strtolower($this->subkegiatanprogram_kode),true);
		$criteria->compare('LOWER(subkegiatanprogram_nama)',strtolower($this->subkegiatanprogram_nama),true);
		$criteria->compare('LOWER(subkegiatanprogram_namalain)',strtolower($this->subkegiatanprogram_namalain),true);
		$criteria->compare('LOWER(subkegiatanprogram_ket)',strtolower($this->subkegiatanprogram_ket),true);
		if(!empty($this->rekeningdebit_id)){
			$criteria->addCondition('rekeningdebit_id = '.$this->rekeningdebit_id);
		}
		if(!empty($this->rekeningkredit_id)){
			$criteria->addCondition('rekeningkredit_id = '.$this->rekeningkredit_id);
		}
		$criteria->compare('subkegiatanprogram_aktif',$this->subkegiatanprogram_aktif);
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