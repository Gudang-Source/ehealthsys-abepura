<?php

/**
 * This is the model class for table "detailhasilpemeriksaanlab_t".
 *
 * The followings are the available columns in table 'detailhasilpemeriksaanlab_t':
 * @property integer $detailhasilpemeriksaanlab_id
 * @property integer $tindakanpelayanan_id
 * @property integer $pemeriksaanlabdet_id
 * @property integer $pemeriksaanlab_id
 * @property integer $hasilpemeriksaanlab_id
 * @property string $hasilpemeriksaan
 * @property string $nilairujukan
 * @property string $hasilpemeriksaan_satuan
 * @property string $hasilpemeriksaan_metode
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 *
 * The followings are the available model relations:
 * @property TindakanpelayananT[] $tindakanpelayananTs
 * @property HasilpemeriksaanlabT $hasilpemeriksaanlab
 * @property PemeriksaanlabdetM $pemeriksaanlabdet
 * @property PemeriksaanlabM $pemeriksaanlab
 * @property TindakanpelayananT $tindakanpelayanan
 */
class MODetailhasilpemeriksaanlabT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return MODetailhasilpemeriksaanlabT the static model class
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
		return 'detailhasilpemeriksaanlab_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pemeriksaanlabdet_id, pemeriksaanlab_id, hasilpemeriksaanlab_id, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('tindakanpelayanan_id, pemeriksaanlabdet_id, pemeriksaanlab_id, hasilpemeriksaanlab_id', 'numerical', 'integerOnly'=>true),
			array('nilairujukan, hasilpemeriksaan_metode', 'length', 'max'=>100),
			array('hasilpemeriksaan_satuan', 'length', 'max'=>50),
			array('hasilpemeriksaan, update_time, update_loginpemakai_id', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('detailhasilpemeriksaanlab_id, tindakanpelayanan_id, pemeriksaanlabdet_id, pemeriksaanlab_id, hasilpemeriksaanlab_id, hasilpemeriksaan, nilairujukan, hasilpemeriksaan_satuan, hasilpemeriksaan_metode, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'tindakanpelayananTs' => array(self::HAS_MANY, 'TindakanpelayananT', 'detailhasilpemeriksaanlab_id'),
			'hasilpemeriksaanlab' => array(self::BELONGS_TO, 'HasilpemeriksaanlabT', 'hasilpemeriksaanlab_id'),
			'pemeriksaanlabdet' => array(self::BELONGS_TO, 'PemeriksaanlabdetM', 'pemeriksaanlabdet_id'),
			'pemeriksaanlab' => array(self::BELONGS_TO, 'PemeriksaanlabM', 'pemeriksaanlab_id'),
			'tindakanpelayanan' => array(self::BELONGS_TO, 'TindakanpelayananT', 'tindakanpelayanan_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'detailhasilpemeriksaanlab_id' => 'Detailhasilpemeriksaanlab',
			'tindakanpelayanan_id' => 'Tindakanpelayanan',
			'pemeriksaanlabdet_id' => 'Pemeriksaanlabdet',
			'pemeriksaanlab_id' => 'Pemeriksaanlab',
			'hasilpemeriksaanlab_id' => 'Hasilpemeriksaanlab',
			'hasilpemeriksaan' => 'Hasilpemeriksaan',
			'nilairujukan' => 'Nilairujukan',
			'hasilpemeriksaan_satuan' => 'Hasilpemeriksaan Satuan',
			'hasilpemeriksaan_metode' => 'Hasilpemeriksaan Metode',
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

		if(!empty($this->detailhasilpemeriksaanlab_id)){
			$criteria->addCondition('detailhasilpemeriksaanlab_id = '.$this->detailhasilpemeriksaanlab_id);
		}
		if(!empty($this->tindakanpelayanan_id)){
			$criteria->addCondition('tindakanpelayanan_id = '.$this->tindakanpelayanan_id);
		}
		if(!empty($this->pemeriksaanlabdet_id)){
			$criteria->addCondition('pemeriksaanlabdet_id = '.$this->pemeriksaanlabdet_id);
		}
		if(!empty($this->pemeriksaanlab_id)){
			$criteria->addCondition('pemeriksaanlab_id = '.$this->pemeriksaanlab_id);
		}
		if(!empty($this->hasilpemeriksaanlab_id)){
			$criteria->addCondition('hasilpemeriksaanlab_id = '.$this->hasilpemeriksaanlab_id);
		}
		$criteria->compare('LOWER(hasilpemeriksaan)',strtolower($this->hasilpemeriksaan),true);
		$criteria->compare('LOWER(nilairujukan)',strtolower($this->nilairujukan),true);
		$criteria->compare('LOWER(hasilpemeriksaan_satuan)',strtolower($this->hasilpemeriksaan_satuan),true);
		$criteria->compare('LOWER(hasilpemeriksaan_metode)',strtolower($this->hasilpemeriksaan_metode),true);
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