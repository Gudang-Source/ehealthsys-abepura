<?php

/**
 * This is the model class for table "pelamarpegawai_r".
 *
 * The followings are the available columns in table 'pelamarpegawai_r':
 * @property integer $pelamarpegawai_id
 * @property string $tanggal
 * @property integer $pelamar
 * @property integer $pegawai
 */
class SEPelamarpegawaiR extends PelamarpegawaiR
{
    public $jns_periode;
    public $periode, $jumlah_pelamar, $jumlah_pegawai;
    public $tgl_awal, $tgl_akhir, $bln_awal, $bln_akhir, $thn_awal, $thn_akhir;
    public $data, $data_2;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PelamarpegawaiR the static model class
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
		return 'pelamarpegawai_r';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pelamar, pegawai', 'numerical', 'integerOnly'=>true),
			array('tanggal', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pelamarpegawai_id, tanggal, pelamar, pegawai', 'safe', 'on'=>'search'),
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
			'pelamarpegawai_id' => 'Pelamarpegawai',
			'tanggal' => 'Tanggal',
			'pelamar' => 'Pelamar',
			'pegawai' => 'Pegawai',
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

		if(!empty($this->pelamarpegawai_id)){
			$criteria->addCondition('pelamarpegawai_id = '.$this->pelamarpegawai_id);
		}
		$criteria->compare('LOWER(tanggal)',strtolower($this->tanggal),true);
		if(!empty($this->pelamar)){
			$criteria->addCondition('pelamar = '.$this->pelamar);
		}
		if(!empty($this->pegawai)){
			$criteria->addCondition('pegawai = '.$this->pegawai);
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