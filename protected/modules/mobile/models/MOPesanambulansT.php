<?php

/**
 * This is the model class for table "pesanambulans_t".
 *
 * The followings are the available columns in table 'pesanambulans_t':
 * @property integer $pesanambulans_t
 * @property integer $ruangan_id
 * @property integer $pendaftaran_id
 * @property integer $mobilambulans_id
 * @property integer $pemakaianambulans_id
 * @property integer $pasien_id
 * @property string $pesanambulans_no
 * @property string $tglpemesananambulans
 * @property string $norekammedis
 * @property string $namapasien
 * @property string $tempattujuan
 * @property string $kelurahan_nama
 * @property string $alamattujuan
 * @property string $rt_rw
 * @property string $nomobile
 * @property string $notelepon
 * @property string $tglpemakaianambulans
 * @property string $untukkeperluan
 * @property string $keteranganpesan
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 * @property string $longitude
 * @property string $latitude
 *
 * The followings are the available model relations:
 * @property PemakaianambulansT[] $pemakaianambulansTs
 * @property MobilambulansM $mobilambulans
 * @property PasienM $pasien
 * @property PemakaianambulansT $pemakaianambulans
 * @property PendaftaranT $pendaftaran
 * @property RuanganM $ruangan
 */
class MOPesanambulansT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return MOPesanambulansT the static model class
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
		return 'pesanambulans_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ruangan_id, pesanambulans_no, tglpemesananambulans, namapasien, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('ruangan_id, pendaftaran_id, mobilambulans_id, pemakaianambulans_id, pasien_id', 'numerical', 'integerOnly'=>true),
			array('pesanambulans_no, rt_rw', 'length', 'max'=>20),
			array('norekammedis', 'length', 'max'=>10),
			array('namapasien, nomobile, notelepon', 'length', 'max'=>100),
			array('tempattujuan, kelurahan_nama', 'length', 'max'=>50),
			array('alamattujuan, tglpemakaianambulans, untukkeperluan, keteranganpesan, update_time, update_loginpemakai_id, longitude, latitude', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pesanambulans_t, ruangan_id, pendaftaran_id, mobilambulans_id, pemakaianambulans_id, pasien_id, pesanambulans_no, tglpemesananambulans, norekammedis, namapasien, tempattujuan, kelurahan_nama, alamattujuan, rt_rw, nomobile, notelepon, tglpemakaianambulans, untukkeperluan, keteranganpesan, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, longitude, latitude', 'safe', 'on'=>'search'),
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
			'pemakaianambulansTs' => array(self::HAS_MANY, 'PemakaianambulansT', 'pesanambulans_t'),
			'mobilambulans' => array(self::BELONGS_TO, 'MobilambulansM', 'mobilambulans_id'),
			'pasien' => array(self::BELONGS_TO, 'PasienM', 'pasien_id'),
			'pemakaianambulans' => array(self::BELONGS_TO, 'PemakaianambulansT', 'pemakaianambulans_id'),
			'pendaftaran' => array(self::BELONGS_TO, 'PendaftaranT', 'pendaftaran_id'),
			'ruangan' => array(self::BELONGS_TO, 'RuanganM', 'ruangan_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'pesanambulans_t' => 'Pesanambulans T',
			'ruangan_id' => 'Ruangan',
			'pendaftaran_id' => 'Pendaftaran',
			'mobilambulans_id' => 'Mobilambulans',
			'pemakaianambulans_id' => 'Pemakaianambulans',
			'pasien_id' => 'Pasien',
			'pesanambulans_no' => 'Pesanambulans No',
			'tglpemesananambulans' => 'Tglpemesananambulans',
			'norekammedis' => 'Norekammedis',
			'namapasien' => 'Namapasien',
			'tempattujuan' => 'Tempattujuan',
			'kelurahan_nama' => 'Kelurahan Nama',
			'alamattujuan' => 'Alamattujuan',
			'rt_rw' => 'Rt Rw',
			'nomobile' => 'Nomobile',
			'notelepon' => 'Notelepon',
			'tglpemakaianambulans' => 'Tglpemakaianambulans',
			'untukkeperluan' => 'Untukkeperluan',
			'keteranganpesan' => 'Keteranganpesan',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'create_loginpemakai_id' => 'Create Loginpemakai',
			'update_loginpemakai_id' => 'Update Loginpemakai',
			'create_ruangan' => 'Create Ruangan',
			'longitude' => 'Longitude',
			'latitude' => 'Latitude',
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

		$criteria->compare('pesanambulans_t',$this->pesanambulans_t);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('mobilambulans_id',$this->mobilambulans_id);
		$criteria->compare('pemakaianambulans_id',$this->pemakaianambulans_id);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('LOWER(pesanambulans_no)',strtolower($this->pesanambulans_no),true);
		$criteria->compare('LOWER(tglpemesananambulans)',strtolower($this->tglpemesananambulans),true);
		$criteria->compare('LOWER(norekammedis)',strtolower($this->norekammedis),true);
		$criteria->compare('LOWER(namapasien)',strtolower($this->namapasien),true);
		$criteria->compare('LOWER(tempattujuan)',strtolower($this->tempattujuan),true);
		$criteria->compare('LOWER(kelurahan_nama)',strtolower($this->kelurahan_nama),true);
		$criteria->compare('LOWER(alamattujuan)',strtolower($this->alamattujuan),true);
		$criteria->compare('LOWER(rt_rw)',strtolower($this->rt_rw),true);
		$criteria->compare('LOWER(nomobile)',strtolower($this->nomobile),true);
		$criteria->compare('LOWER(notelepon)',strtolower($this->notelepon),true);
		$criteria->compare('LOWER(tglpemakaianambulans)',strtolower($this->tglpemakaianambulans),true);
		$criteria->compare('LOWER(untukkeperluan)',strtolower($this->untukkeperluan),true);
		$criteria->compare('LOWER(keteranganpesan)',strtolower($this->keteranganpesan),true);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
		$criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);
		$criteria->compare('LOWER(longitude)',strtolower($this->longitude),true);
		$criteria->compare('LOWER(latitude)',strtolower($this->latitude),true);

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