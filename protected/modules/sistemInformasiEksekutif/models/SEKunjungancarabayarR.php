<?php

/**
 * This is the model class for table "kunjungancarabayar_r".
 *
 * The followings are the available columns in table 'kunjungancarabayar_r':
 * @property integer $kunjugnancarabayar_id
 * @property string $tanggal
 * @property integer $carabayar_id
 * @property string $carabayar_nama
 * @property integer $jumlah
 */
class SEKunjungancarabayarR extends KunjungancarabayarR
{
    public $jns_periode;
    public $periode, $jumlah, $jenis;
    public $tgl_awal, $tgl_akhir, $bln_awal, $bln_akhir, $thn_awal, $thn_akhir;
    public $data, $data_2;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return KunjungancarabayarR the static model class
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
		return 'kunjungancarabayar_r';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('carabayar_id, jumlah', 'numerical', 'integerOnly'=>true),
			array('carabayar_nama', 'length', 'max'=>50),
			array('tanggal', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('kunjugnancarabayar_id, tanggal, carabayar_id, carabayar_nama, jumlah', 'safe', 'on'=>'search'),
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
			'kunjugnancarabayar_id' => 'Kunjugnancarabayar',
			'tanggal' => 'Tanggal',
			'carabayar_id' => 'Carabayar',
			'carabayar_nama' => 'Carabayar Nama',
			'jumlah' => 'Jumlah',
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

		if(!empty($this->kunjugnancarabayar_id)){
			$criteria->addCondition('kunjugnancarabayar_id = '.$this->kunjugnancarabayar_id);
		}
		$criteria->compare('LOWER(tanggal)',strtolower($this->tanggal),true);
		if(!empty($this->carabayar_id)){
			$criteria->addCondition('carabayar_id = '.$this->carabayar_id);
		}
		$criteria->compare('LOWER(carabayar_nama)',strtolower($this->carabayar_nama),true);
		if(!empty($this->jumlah)){
			$criteria->addCondition('jumlah = '.$this->jumlah);
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