<?php

/**
 * This is the model class for table "pesanmenudetail_t".
 *
 * The followings are the available columns in table 'pesanmenudetail_t':
 * @property integer $pesanmenudetail_id
 * @property integer $pesanmenudiet_id
 * @property integer $pendaftaran_id
 * @property integer $pasienadmisi_id
 * @property integer $jeniswaktu_id
 * @property integer $kirimmenupasien_id
 * @property integer $menudiet_id
 * @property integer $pasien_id
 * @property double $jml_pesan_porsi
 * @property string $satuanjml_urt
 * @property string $status_menu
 *
 * The followings are the available model relations:
 * @property JeniswaktuM $jeniswaktu
 * @property KirimmenupasienT $kirimmenupasien
 * @property MenudietM $menudiet
 * @property PasienM $pasien
 * @property PasienadmisiT $pasienadmisi
 * @property PendaftaranT $pendaftaran
 * @property PesanmenudietT $pesanmenudiet
 */
class MOPesanmenudetailT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return MOPesanmenudetailT the static model class
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
		return 'pesanmenudetail_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pesanmenudiet_id, pendaftaran_id, jeniswaktu_id, menudiet_id, pasien_id, jml_pesan_porsi', 'required'),
			array('pesanmenudiet_id, pendaftaran_id, pasienadmisi_id, jeniswaktu_id, kirimmenupasien_id, menudiet_id, pasien_id', 'numerical', 'integerOnly'=>true),
			array('jml_pesan_porsi', 'numerical'),
			array('satuanjml_urt', 'length', 'max'=>50),
			array('status_menu', 'length', 'max'=>20),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pesanmenudetail_id, pesanmenudiet_id, pendaftaran_id, pasienadmisi_id, jeniswaktu_id, kirimmenupasien_id, menudiet_id, pasien_id, jml_pesan_porsi, satuanjml_urt, status_menu', 'safe', 'on'=>'search'),
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
			'jeniswaktu' => array(self::BELONGS_TO, 'JeniswaktuM', 'jeniswaktu_id'),
			'kirimmenupasien' => array(self::BELONGS_TO, 'KirimmenupasienT', 'kirimmenupasien_id'),
			'menudiet' => array(self::BELONGS_TO, 'MenudietM', 'menudiet_id'),
			'pasien' => array(self::BELONGS_TO, 'PasienM', 'pasien_id'),
			'pasienadmisi' => array(self::BELONGS_TO, 'PasienadmisiT', 'pasienadmisi_id'),
			'pendaftaran' => array(self::BELONGS_TO, 'PendaftaranT', 'pendaftaran_id'),
			'pesanmenudiet' => array(self::BELONGS_TO, 'PesanmenudietT', 'pesanmenudiet_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'pesanmenudetail_id' => 'Pesanmenudetail',
			'pesanmenudiet_id' => 'Pesanmenudiet',
			'pendaftaran_id' => 'Pendaftaran',
			'pasienadmisi_id' => 'Pasienadmisi',
			'jeniswaktu_id' => 'Jeniswaktu',
			'kirimmenupasien_id' => 'Kirimmenupasien',
			'menudiet_id' => 'Menudiet',
			'pasien_id' => 'Pasien',
			'jml_pesan_porsi' => 'Jml Pesan Porsi',
			'satuanjml_urt' => 'Satuanjml Urt',
			'status_menu' => 'Status Menu',
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

		$criteria->compare('pesanmenudetail_id',$this->pesanmenudetail_id);
		$criteria->compare('pesanmenudiet_id',$this->pesanmenudiet_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('pasienadmisi_id',$this->pasienadmisi_id);
		$criteria->compare('jeniswaktu_id',$this->jeniswaktu_id);
		$criteria->compare('kirimmenupasien_id',$this->kirimmenupasien_id);
		$criteria->compare('menudiet_id',$this->menudiet_id);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('jml_pesan_porsi',$this->jml_pesan_porsi);
		$criteria->compare('LOWER(satuanjml_urt)',strtolower($this->satuanjml_urt),true);
		$criteria->compare('LOWER(status_menu)',strtolower($this->status_menu),true);

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