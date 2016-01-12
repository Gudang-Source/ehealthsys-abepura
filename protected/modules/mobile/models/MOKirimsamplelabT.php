<?php

/**
 * This is the model class for table "kirimsamplelab_t".
 *
 * The followings are the available columns in table 'kirimsamplelab_t':
 * @property integer $kirimsamplelab_id
 * @property integer $terimasamplelab_id
 * @property integer $labklinikrujukan_id
 * @property integer $pengambilansample_id
 * @property string $nokirimsample
 * @property string $tglkirimsample
 * @property string $tglterimahasilsample
 * @property string $keterangan_kirim
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 *
 * The followings are the available model relations:
 * @property TerimasamplelabT[] $terimasamplelabTs
 * @property LabklinikrujukanM $labklinikrujukan
 * @property PengambilansampleT $pengambilansample
 * @property TerimasamplelabT $terimasamplelab
 * @property PengambilansampleT[] $pengambilansampleTs
 */
class MOKirimsamplelabT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return MOKirimsamplelabT the static model class
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
		return 'kirimsamplelab_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('labklinikrujukan_id, nokirimsample, tglkirimsample, create_time, create_loginpemakai_id', 'required'),
			array('terimasamplelab_id, labklinikrujukan_id, pengambilansample_id', 'numerical', 'integerOnly'=>true),
			array('nokirimsample', 'length', 'max'=>20),
			array('tglterimahasilsample, keterangan_kirim, update_time, update_loginpemakai_id, create_ruangan', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('kirimsamplelab_id, terimasamplelab_id, labklinikrujukan_id, pengambilansample_id, nokirimsample, tglkirimsample, tglterimahasilsample, keterangan_kirim, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'terimasamplelabTs' => array(self::HAS_MANY, 'TerimasamplelabT', 'kirimsamplelab_id'),
			'labklinikrujukan' => array(self::BELONGS_TO, 'LabklinikrujukanM', 'labklinikrujukan_id'),
			'pengambilansample' => array(self::BELONGS_TO, 'PengambilansampleT', 'pengambilansample_id'),
			'terimasamplelab' => array(self::BELONGS_TO, 'TerimasamplelabT', 'terimasamplelab_id'),
			'pengambilansampleTs' => array(self::HAS_MANY, 'PengambilansampleT', 'kirimsamplelab_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'kirimsamplelab_id' => 'Kirimsamplelab',
			'terimasamplelab_id' => 'Terimasamplelab',
			'labklinikrujukan_id' => 'Labklinikrujukan',
			'pengambilansample_id' => 'Pengambilansample',
			'nokirimsample' => 'Nokirimsample',
			'tglkirimsample' => 'Tglkirimsample',
			'tglterimahasilsample' => 'Tglterimahasilsample',
			'keterangan_kirim' => 'Keterangan Kirim',
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

		if(!empty($this->kirimsamplelab_id)){
			$criteria->addCondition('kirimsamplelab_id = '.$this->kirimsamplelab_id);
		}
		if(!empty($this->terimasamplelab_id)){
			$criteria->addCondition('terimasamplelab_id = '.$this->terimasamplelab_id);
		}
		if(!empty($this->labklinikrujukan_id)){
			$criteria->addCondition('labklinikrujukan_id = '.$this->labklinikrujukan_id);
		}
		if(!empty($this->pengambilansample_id)){
			$criteria->addCondition('pengambilansample_id = '.$this->pengambilansample_id);
		}
		$criteria->compare('LOWER(nokirimsample)',strtolower($this->nokirimsample),true);
		$criteria->compare('LOWER(tglkirimsample)',strtolower($this->tglkirimsample),true);
		$criteria->compare('LOWER(tglterimahasilsample)',strtolower($this->tglterimahasilsample),true);
		$criteria->compare('LOWER(keterangan_kirim)',strtolower($this->keterangan_kirim),true);
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