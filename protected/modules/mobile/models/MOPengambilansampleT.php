<?php

/**
 * This is the model class for table "pengambilansample_t".
 *
 * The followings are the available columns in table 'pengambilansample_t':
 * @property integer $pengambilansample_id
 * @property integer $pasienmasukpenunjang_id
 * @property integer $samplelab_id
 * @property integer $kirimsamplelab_id
 * @property string $tglpengambilansample
 * @property string $no_pengambilansample
 * @property integer $jmlpengambilansample
 * @property string $tempatsimpansample
 * @property string $keterangansample
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 *
 * The followings are the available model relations:
 * @property KirimsamplelabT[] $kirimsamplelabTs
 * @property KirimsamplelabT $kirimsamplelab
 * @property PasienmasukpenunjangT $pasienmasukpenunjang
 * @property SamplelabM $samplelab
 */
class MOPengambilansampleT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return MOPengambilansampleT the static model class
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
		return 'pengambilansample_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pasienmasukpenunjang_id, samplelab_id, tglpengambilansample, no_pengambilansample, jmlpengambilansample, create_time, create_loginpemakai_id', 'required'),
			array('pasienmasukpenunjang_id, samplelab_id, kirimsamplelab_id, jmlpengambilansample', 'numerical', 'integerOnly'=>true),
			array('no_pengambilansample', 'length', 'max'=>50),
			array('tempatsimpansample', 'length', 'max'=>100),
			array('keterangansample, update_time, update_loginpemakai_id, create_ruangan', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pengambilansample_id, pasienmasukpenunjang_id, samplelab_id, kirimsamplelab_id, tglpengambilansample, no_pengambilansample, jmlpengambilansample, tempatsimpansample, keterangansample, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'kirimsamplelabTs' => array(self::HAS_MANY, 'KirimsamplelabT', 'pengambilansample_id'),
			'kirimsamplelab' => array(self::BELONGS_TO, 'KirimsamplelabT', 'kirimsamplelab_id'),
			'pasienmasukpenunjang' => array(self::BELONGS_TO, 'PasienmasukpenunjangT', 'pasienmasukpenunjang_id'),
			'samplelab' => array(self::BELONGS_TO, 'SamplelabM', 'samplelab_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'pengambilansample_id' => 'Pengambilansample',
			'pasienmasukpenunjang_id' => 'Pasienmasukpenunjang',
			'samplelab_id' => 'Samplelab',
			'kirimsamplelab_id' => 'Kirimsamplelab',
			'tglpengambilansample' => 'Tglpengambilansample',
			'no_pengambilansample' => 'No. Pengambilansample',
			'jmlpengambilansample' => 'Jmlpengambilansample',
			'tempatsimpansample' => 'Tempatsimpansample',
			'keterangansample' => 'Keterangansample',
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

		if(!empty($this->pengambilansample_id)){
			$criteria->addCondition('pengambilansample_id = '.$this->pengambilansample_id);
		}
		if(!empty($this->pasienmasukpenunjang_id)){
			$criteria->addCondition('pasienmasukpenunjang_id = '.$this->pasienmasukpenunjang_id);
		}
		if(!empty($this->samplelab_id)){
			$criteria->addCondition('samplelab_id = '.$this->samplelab_id);
		}
		if(!empty($this->kirimsamplelab_id)){
			$criteria->addCondition('kirimsamplelab_id = '.$this->kirimsamplelab_id);
		}
		$criteria->compare('LOWER(tglpengambilansample)',strtolower($this->tglpengambilansample),true);
		$criteria->compare('LOWER(no_pengambilansample)',strtolower($this->no_pengambilansample),true);
		if(!empty($this->jmlpengambilansample)){
			$criteria->addCondition('jmlpengambilansample = '.$this->jmlpengambilansample);
		}
		$criteria->compare('LOWER(tempatsimpansample)',strtolower($this->tempatsimpansample),true);
		$criteria->compare('LOWER(keterangansample)',strtolower($this->keterangansample),true);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
		$criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);

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