<?php

/**
 * This is the model class for table "tindaklanjutigd_r".
 *
 * The followings are the available columns in table 'tindaklanjutigd_r':
 * @property integer $tindaklanjutigd_id
 * @property string $tanggal
 * @property integer $dirawat
 * @property integer $dirujuk
 * @property integer $pulang
 * @property integer $meinggal
 */
class SETindaklanjutigdR extends TindaklanjutigdR
{
	public $jns_periode;
	public $periode, $jumlah_dirawat, $jumlah_dirujuk, $jumlah_pulang, $jumlah_meninggal;
	public $tgl_awal, $tgl_akhir, $bln_awal, $bln_akhir, $thn_awal, $thn_akhir;
	public $data, $data_2;
	
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TindaklanjutigdR the static model class
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
		return 'tindaklanjutigd_r';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('dirawat, dirujuk, pulang, meninggal', 'numerical', 'integerOnly'=>true),
			array('tanggal', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('tindaklanjutigd_id, tanggal, dirawat, dirujuk, pulang, meninggal', 'safe', 'on'=>'search'),
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
			'tindaklanjutigd_id' => 'Tindaklanjutigd',
			'tanggal' => 'Tanggal',
			'dirawat' => 'Rawat Inap',
			'dirujuk' => 'Rawat Jalan',
			'pulang' => 'Pasien Pulang',
			'meninggal' => 'Pasien Meninggal',
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

		if(!empty($this->tindaklanjutigd_id)){
			$criteria->addCondition('tindaklanjutigd_id = '.$this->tindaklanjutigd_id);
		}
		$criteria->compare('LOWER(tanggal)',strtolower($this->tanggal),true);
		if(!empty($this->dirawat)){
			$criteria->addCondition('dirawat = '.$this->dirawat);
		}
		if(!empty($this->dirujuk)){
			$criteria->addCondition('dirujuk = '.$this->dirujuk);
		}
		if(!empty($this->pulang)){
			$criteria->addCondition('pulang = '.$this->pulang);
		}
		if(!empty($this->meninggal)){
			$criteria->addCondition('meninggal = '.$this->meninggal);
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