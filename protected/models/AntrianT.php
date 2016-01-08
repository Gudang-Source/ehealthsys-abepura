<?php

/**
 * This is the model class for table "antrian_t".
 *
 * The followings are the available columns in table 'antrian_t':
 * @property integer $antrian_id
 * @property integer $ruangan_id
 * @property integer $carabayar_id
 * @property integer $pendaftaran_id
 * @property integer $profilrs_id
 * @property string $tglantrian
 * @property string $noantrian
 * @property string $statuspasien
 * @property string $carabayar_loket
 * @property boolean $panggil_flaq
 * @property integer $loket_id
 *
 * The followings are the available model relations:
 * @property CarabayarM $carabayar
 * @property PendaftaranT $pendaftaran
 * @property ProfilrumahsakitM $profilrs
 * @property RuanganM $ruangan
 * @property PendaftaranT[] $pendaftaranTs
 */
class AntrianT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return AntrianT the static model class
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
		return 'antrian_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ruangan_id, carabayar_id, profilrs_id, tglantrian, noantrian', 'required'),
			array('ruangan_id, carabayar_id, pendaftaran_id, profilrs_id, loket_id', 'numerical', 'integerOnly'=>true),
			array('noantrian', 'length', 'max'=>6),
			array('statuspasien, carabayar_loket', 'length', 'max'=>50),
			array('panggil_flaq', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('antrian_id, ruangan_id, carabayar_id, pendaftaran_id, profilrs_id, tglantrian, noantrian, statuspasien, carabayar_loket, panggil_flaq, loket_id', 'safe', 'on'=>'search'),
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
			'carabayar' => array(self::BELONGS_TO, 'CarabayarM', 'carabayar_id'),
			'pendaftaran' => array(self::BELONGS_TO, 'PendaftaranT', 'pendaftaran_id'),
			'profilrs' => array(self::BELONGS_TO, 'ProfilrumahsakitM', 'profilrs_id'),
			'ruangan' => array(self::BELONGS_TO, 'RuanganM', 'ruangan_id'),
			'loket' => array(self::BELONGS_TO, 'LoketM', 'loket_id'),
			'pendaftaranTs' => array(self::HAS_MANY, 'PendaftaranT', 'antrian_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'antrian_id' => 'Antrian',
			'ruangan_id' => 'Ruangan Tujuan',
			'carabayar_id' => 'Cara Bayar',
			'pendaftaran_id' => 'Pendaftaran',
			'profilrs_id' => 'Profilrs',
			'tglantrian' => 'Tanggal Antrian',
			'noantrian' => 'No. Antrian',
			'statuspasien' => 'Status Pasien',
			'carabayar_loket' => 'Cara Bayar Loket',
			'panggil_flaq' => 'Panggil Flaq',
			'loket_id' => 'Loket',
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

		$criteria->compare('antrian_id',$this->antrian_id);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('carabayar_id',$this->carabayar_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('profilrs_id',$this->profilrs_id);
		$criteria->compare('LOWER(noantrian)',strtolower($this->noantrian),true);
		$criteria->compare('LOWER(statuspasien)',strtolower($this->statuspasien),true);
		$criteria->compare('LOWER(carabayar_loket)',strtolower($this->carabayar_loket),true);
		$criteria->compare('panggil_flaq',$this->panggil_flaq);
		$criteria->compare('loket_id',$this->loket_id);

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