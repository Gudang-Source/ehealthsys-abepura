<?php

/**
 * This is the model class for table "penyimpananlinen_t".
 *
 * The followings are the available columns in table 'penyimpananlinen_t':
 * @property integer $penyimpananlinen_id
 * @property string $tglpenyimpananlinen
 * @property string $nopenyimpamanlinen
 * @property string $keterangan_penyimpanan
 * @property integer $petugas_id
 * @property integer $pegmengetahui_id
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 */
class PenyimpananlinenT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PenyimpananlinenT the static model class
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
		return 'penyimpananlinen_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('tglpenyimpananlinen, nopenyimpamanlinen, petugas_id, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('petugas_id, pegmengetahui_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('nopenyimpamanlinen', 'length', 'max'=>50),
			array('keterangan_penyimpanan', 'length', 'max'=>200),
			array('update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('penyimpananlinen_id, tglpenyimpananlinen, nopenyimpamanlinen, keterangan_penyimpanan, petugas_id, pegmengetahui_id, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'petugas'=>array(self::BELONGS_TO,'PegawaiM','pegmengetahui_id'),
			'pegmengetahui'=>array(self::BELONGS_TO,'PegawaiM','pegmengetahui_id'),
			'ruangan'=>array(self::BELONGS_TO,'RuanganM','create_ruangan'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'penyimpananlinen_id' => 'Penyimpanan Linen',
			'tglpenyimpananlinen' => 'Tanggal Penyimpanan',
			'nopenyimpamanlinen' => 'No. Penyimpanan',
			'keterangan_penyimpanan' => 'Keterangan',
			'petugas_id' => 'Petugas',
			'pegmengetahui_id' => 'Pegawai Mengetahui',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
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

		if(!empty($this->penyimpananlinen_id)){
			$criteria->addCondition('penyimpananlinen_id = '.$this->penyimpananlinen_id);
		}
		$criteria->compare('LOWER(tglpenyimpananlinen)',strtolower($this->tglpenyimpananlinen),true);
		$criteria->compare('LOWER(nopenyimpamanlinen)',strtolower($this->nopenyimpamanlinen),true);
		$criteria->compare('LOWER(keterangan_penyimpanan)',strtolower($this->keterangan_penyimpanan),true);
		if(!empty($this->petugas_id)){
			$criteria->addCondition('petugas_id = '.$this->petugas_id);
		}
		if(!empty($this->pegmengetahui_id)){
			$criteria->addCondition('pegmengetahui_id = '.$this->pegmengetahui_id);
		}
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