<?php

/**
 * This is the model class for table "hasilpemeriksaanrm_t".
 *
 * The followings are the available columns in table 'hasilpemeriksaanrm_t':
 * @property integer $hasilpemeriksaanrm_id
 * @property integer $pegawai_id
 * @property integer $ruangan_id
 * @property integer $pasien_id
 * @property integer $jadwalkunjunganrm_id
 * @property integer $jenistindakanrm_id
 * @property integer $tindakanpelayanan_id
 * @property integer $pendaftaran_id
 * @property integer $pasienmasukpenunjang_id
 * @property integer $tindakanrm_id
 * @property integer $pasienadmisi_id
 * @property string $tglpemeriksaanrm
 * @property string $nohasilrm
 * @property integer $kunjunganke
 * @property string $hasilpemeriksaanrm
 * @property string $keteranganhasilrm
 * @property string $peralatandigunakan
 * @property string $paramedis1_id
 * @property string $paramedis2_id
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 *
 * The followings are the available model relations:
 * @property JadwalkunjunganrmT $jadwalkunjunganrm
 * @property JenistindakanrmM $jenistindakanrm
 * @property PasienmasukpenunjangT $pasienmasukpenunjang
 * @property PasienM $pasien
 * @property PasienadmisiT $pasienadmisi
 * @property PendaftaranT $pendaftaran
 * @property RuanganM $ruangan
 * @property TindakanrmM $tindakanrm
 * @property TindakanpelayananT $tindakanpelayanan
 * @property PegawaiM $pegawai
 * @property PegawaiM $paramedis1
 * @property TindakanpelayananT[] $tindakanpelayananTs
 */
class MOHasilpemeriksaanrmT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return MOHasilpemeriksaanrmT the static model class
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
		return 'hasilpemeriksaanrm_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ruangan_id, pasien_id, jenistindakanrm_id, pendaftaran_id, pasienmasukpenunjang_id, tindakanrm_id, tglpemeriksaanrm, nohasilrm, kunjunganke, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('pegawai_id, ruangan_id, pasien_id, jadwalkunjunganrm_id, jenistindakanrm_id, tindakanpelayanan_id, pendaftaran_id, pasienmasukpenunjang_id, tindakanrm_id, pasienadmisi_id, kunjunganke', 'numerical', 'integerOnly'=>true),
			array('nohasilrm', 'length', 'max'=>20),
			array('hasilpemeriksaanrm, keteranganhasilrm', 'length', 'max'=>500),
			array('peralatandigunakan', 'length', 'max'=>100),
			array('paramedis1_id, paramedis2_id, update_time, update_loginpemakai_id', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('hasilpemeriksaanrm_id, pegawai_id, ruangan_id, pasien_id, jadwalkunjunganrm_id, jenistindakanrm_id, tindakanpelayanan_id, pendaftaran_id, pasienmasukpenunjang_id, tindakanrm_id, pasienadmisi_id, tglpemeriksaanrm, nohasilrm, kunjunganke, hasilpemeriksaanrm, keteranganhasilrm, peralatandigunakan, paramedis1_id, paramedis2_id, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'jadwalkunjunganrm' => array(self::BELONGS_TO, 'JadwalkunjunganrmT', 'jadwalkunjunganrm_id'),
			'jenistindakanrm' => array(self::BELONGS_TO, 'JenistindakanrmM', 'jenistindakanrm_id'),
			'pasienmasukpenunjang' => array(self::BELONGS_TO, 'PasienmasukpenunjangT', 'pasienmasukpenunjang_id'),
			'pasien' => array(self::BELONGS_TO, 'PasienM', 'pasien_id'),
			'pasienadmisi' => array(self::BELONGS_TO, 'PasienadmisiT', 'pasienadmisi_id'),
			'pendaftaran' => array(self::BELONGS_TO, 'PendaftaranT', 'pendaftaran_id'),
			'ruangan' => array(self::BELONGS_TO, 'RuanganM', 'ruangan_id'),
			'tindakanrm' => array(self::BELONGS_TO, 'TindakanrmM', 'tindakanrm_id'),
			'tindakanpelayanan' => array(self::BELONGS_TO, 'TindakanpelayananT', 'tindakanpelayanan_id'),
			'pegawai' => array(self::BELONGS_TO, 'PegawaiM', 'pegawai_id'),
			'paramedis1' => array(self::BELONGS_TO, 'PegawaiM', 'paramedis1_id'),
			'tindakanpelayananTs' => array(self::HAS_MANY, 'TindakanpelayananT', 'hasilpemeriksaanrm_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'hasilpemeriksaanrm_id' => 'Hasilpemeriksaanrm',
			'pegawai_id' => 'Pegawai',
			'ruangan_id' => 'Ruangan',
			'pasien_id' => 'Pasien',
			'jadwalkunjunganrm_id' => 'Jadwalkunjunganrm',
			'jenistindakanrm_id' => 'Jenistindakanrm',
			'tindakanpelayanan_id' => 'Tindakanpelayanan',
			'pendaftaran_id' => 'Pendaftaran',
			'pasienmasukpenunjang_id' => 'Pasienmasukpenunjang',
			'tindakanrm_id' => 'Tindakanrm',
			'pasienadmisi_id' => 'Pasienadmisi',
			'tglpemeriksaanrm' => 'Tglpemeriksaanrm',
			'nohasilrm' => 'Nohasilrm',
			'kunjunganke' => 'Kunjunganke',
			'hasilpemeriksaanrm' => 'Hasilpemeriksaanrm',
			'keteranganhasilrm' => 'Keteranganhasilrm',
			'peralatandigunakan' => 'Peralatandigunakan',
			'paramedis1_id' => 'Paramedis1',
			'paramedis2_id' => 'Paramedis2',
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

		if(!empty($this->hasilpemeriksaanrm_id)){
			$criteria->addCondition('hasilpemeriksaanrm_id = '.$this->hasilpemeriksaanrm_id);
		}
		if(!empty($this->pegawai_id)){
			$criteria->addCondition('pegawai_id = '.$this->pegawai_id);
		}
		if(!empty($this->ruangan_id)){
			$criteria->addCondition('ruangan_id = '.$this->ruangan_id);
		}
		if(!empty($this->pasien_id)){
			$criteria->addCondition('pasien_id = '.$this->pasien_id);
		}
		if(!empty($this->jadwalkunjunganrm_id)){
			$criteria->addCondition('jadwalkunjunganrm_id = '.$this->jadwalkunjunganrm_id);
		}
		if(!empty($this->jenistindakanrm_id)){
			$criteria->addCondition('jenistindakanrm_id = '.$this->jenistindakanrm_id);
		}
		if(!empty($this->tindakanpelayanan_id)){
			$criteria->addCondition('tindakanpelayanan_id = '.$this->tindakanpelayanan_id);
		}
		if(!empty($this->pendaftaran_id)){
			$criteria->addCondition('pendaftaran_id = '.$this->pendaftaran_id);
		}
		if(!empty($this->pasienmasukpenunjang_id)){
			$criteria->addCondition('pasienmasukpenunjang_id = '.$this->pasienmasukpenunjang_id);
		}
		if(!empty($this->tindakanrm_id)){
			$criteria->addCondition('tindakanrm_id = '.$this->tindakanrm_id);
		}
		if(!empty($this->pasienadmisi_id)){
			$criteria->addCondition('pasienadmisi_id = '.$this->pasienadmisi_id);
		}
		$criteria->compare('LOWER(tglpemeriksaanrm)',strtolower($this->tglpemeriksaanrm),true);
		$criteria->compare('LOWER(nohasilrm)',strtolower($this->nohasilrm),true);
		if(!empty($this->kunjunganke)){
			$criteria->addCondition('kunjunganke = '.$this->kunjunganke);
		}
		$criteria->compare('LOWER(hasilpemeriksaanrm)',strtolower($this->hasilpemeriksaanrm),true);
		$criteria->compare('LOWER(keteranganhasilrm)',strtolower($this->keteranganhasilrm),true);
		$criteria->compare('LOWER(peralatandigunakan)',strtolower($this->peralatandigunakan),true);
		$criteria->compare('LOWER(paramedis1_id)',strtolower($this->paramedis1_id),true);
		$criteria->compare('LOWER(paramedis2_id)',strtolower($this->paramedis2_id),true);
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