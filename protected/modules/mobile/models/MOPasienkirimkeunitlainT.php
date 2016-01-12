<?php

/**
 * This is the model class for table "pasienkirimkeunitlain_t".
 *
 * The followings are the available columns in table 'pasienkirimkeunitlain_t':
 * @property integer $pasienkirimkeunitlain_id
 * @property integer $pegawai_id
 * @property integer $pasienmasukpenunjang_id
 * @property integer $instalasi_id
 * @property integer $pasien_id
 * @property integer $pendaftaran_id
 * @property integer $kelaspelayanan_id
 * @property integer $ruangan_id
 * @property string $nourut
 * @property string $tgl_kirimpasien
 * @property string $catatandokterpengirim
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 * @property integer $ahligizi
 *
 * The followings are the available model relations:
 * @property PasienmasukpenunjangT[] $pasienmasukpenunjangTs
 * @property PermintaankepenunjangT[] $permintaankepenunjangTs
 * @property InstalasiM $instalasi
 * @property KelaspelayananM $kelaspelayanan
 * @property PasienM $pasien
 * @property PasienmasukpenunjangT $pasienmasukpenunjang
 * @property PegawaiM $pegawai
 * @property PendaftaranT $pendaftaran
 * @property RuanganM $ruangan
 * @property PasienbatalperiksaR[] $pasienbatalperiksaRs
 */
class MOPasienkirimkeunitlainT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return MOPasienkirimkeunitlainT the static model class
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
		return 'pasienkirimkeunitlain_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pegawai_id, instalasi_id, pasien_id, pendaftaran_id, kelaspelayanan_id, ruangan_id, nourut, tgl_kirimpasien, create_time, update_loginpemakai_id, create_ruangan', 'required'),
			array('pegawai_id, pasienmasukpenunjang_id, instalasi_id, pasien_id, pendaftaran_id, kelaspelayanan_id, ruangan_id, ahligizi', 'numerical', 'integerOnly'=>true),
			array('nourut', 'length', 'max'=>3),
			array('catatandokterpengirim, update_time, create_loginpemakai_id', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pasienkirimkeunitlain_id, pegawai_id, pasienmasukpenunjang_id, instalasi_id, pasien_id, pendaftaran_id, kelaspelayanan_id, ruangan_id, nourut, tgl_kirimpasien, catatandokterpengirim, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, ahligizi', 'safe', 'on'=>'search'),
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
			'pasienmasukpenunjangTs' => array(self::HAS_MANY, 'PasienmasukpenunjangT', 'pasienkirimkeunitlain_id'),
			'permintaankepenunjangTs' => array(self::HAS_MANY, 'PermintaankepenunjangT', 'pasienkirimkeunitlain_id'),
			'instalasi' => array(self::BELONGS_TO, 'InstalasiM', 'instalasi_id'),
			'kelaspelayanan' => array(self::BELONGS_TO, 'KelaspelayananM', 'kelaspelayanan_id'),
			'pasien' => array(self::BELONGS_TO, 'PasienM', 'pasien_id'),
			'pasienmasukpenunjang' => array(self::BELONGS_TO, 'PasienmasukpenunjangT', 'pasienmasukpenunjang_id'),
			'pegawai' => array(self::BELONGS_TO, 'PegawaiM', 'pegawai_id'),
			'pendaftaran' => array(self::BELONGS_TO, 'PendaftaranT', 'pendaftaran_id'),
			'ruangan' => array(self::BELONGS_TO, 'RuanganM', 'ruangan_id'),
			'pasienbatalperiksaRs' => array(self::HAS_MANY, 'PasienbatalperiksaR', 'pasienkirimkeunitlain_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'pasienkirimkeunitlain_id' => 'Pasienkirimkeunitlain',
			'pegawai_id' => 'Pegawai',
			'pasienmasukpenunjang_id' => 'Pasienmasukpenunjang',
			'instalasi_id' => 'Instalasi',
			'pasien_id' => 'Pasien',
			'pendaftaran_id' => 'Pendaftaran',
			'kelaspelayanan_id' => 'Kelaspelayanan',
			'ruangan_id' => 'Ruangan',
			'nourut' => 'Nourut',
			'tgl_kirimpasien' => 'Tgl. Kirimpasien',
			'catatandokterpengirim' => 'Catatandokterpengirim',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'create_loginpemakai_id' => 'Create Loginpemakai',
			'update_loginpemakai_id' => 'Update Loginpemakai',
			'create_ruangan' => 'Create Ruangan',
			'ahligizi' => 'Ahligizi',
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

		$criteria->compare('pasienkirimkeunitlain_id',$this->pasienkirimkeunitlain_id);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('pasienmasukpenunjang_id',$this->pasienmasukpenunjang_id);
		$criteria->compare('instalasi_id',$this->instalasi_id);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('kelaspelayanan_id',$this->kelaspelayanan_id);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('LOWER(nourut)',strtolower($this->nourut),true);
		$criteria->compare('LOWER(tgl_kirimpasien)',strtolower($this->tgl_kirimpasien),true);
		$criteria->compare('LOWER(catatandokterpengirim)',strtolower($this->catatandokterpengirim),true);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
		$criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);
		$criteria->compare('ahligizi',$this->ahligizi);

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