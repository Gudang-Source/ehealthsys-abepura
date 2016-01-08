<?php

/**
 * This is the model class for table "pasienmasukpenunjang_t".
 *
 * The followings are the available columns in table 'pasienmasukpenunjang_t':
 * @property integer $pasienmasukpenunjang_id
 * @property integer $pasienkirimkeunitlain_id
 * @property integer $kelaspelayanan_id
 * @property integer $jeniskasuspenyakit_id
 * @property integer $pasienadmisi_id
 * @property integer $pegawai_id
 * @property integer $ruangan_id
 * @property integer $pasien_id
 * @property integer $pendaftaran_id
 * @property string $no_masukpenunjang
 * @property string $tglmasukpenunjang
 * @property string $no_urutperiksa
 * @property string $kunjungan
 * @property string $statusperiksa
 * @property integer $ruanganasal_id
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 * @property boolean $panggilantrian
 *
 * The followings are the available model relations:
 * @property PengambilansampleT[] $pengambilansampleTs
 * @property JadwalkunjunganrmT[] $jadwalkunjunganrmTs
 * @property HasilpemeriksaanlabT[] $hasilpemeriksaanlabTs
 * @property HasilpemeriksaanrmT[] $hasilpemeriksaanrmTs
 * @property HasilpemeriksaanpaT[] $hasilpemeriksaanpaTs
 * @property ObatalkespasienT[] $obatalkespasienTs
 * @property TindakanpelayananT[] $tindakanpelayananTs
 * @property PasienkirimkeunitlainT $pasienkirimkeunitlain
 * @property JeniskasuspenyakitM $jeniskasuspenyakit
 * @property KelaspelayananM $kelaspelayanan
 * @property PasienM $pasien
 * @property PasienadmisiT $pasienadmisi
 * @property PegawaiM $pegawai
 * @property PendaftaranT $pendaftaran
 * @property RuanganM $ruangan
 * @property RuanganM $ruanganasal
 * @property RencanaoperasiT[] $rencanaoperasiTs
 * @property PembjasadetailT[] $pembjasadetailTs
 * @property PasienanastesiT[] $pasienanastesiTs
 * @property PasienkirimkeunitlainT[] $pasienkirimkeunitlainTs
 * @property PasienbatalperiksaR[] $pasienbatalperiksaRs
 * @property HasilpemeriksaanradT[] $hasilpemeriksaanradTs
 */
class MOPasienmasukpenunjangT extends CActiveRecord
{
	public $perawat_id = null; //untuk analis lab / radiografer
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return MOPasienmasukpenunjangT the static model class
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
		return 'pasienmasukpenunjang_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('kelaspelayanan_id, jeniskasuspenyakit_id, ruangan_id, pasien_id, no_masukpenunjang, tglmasukpenunjang, no_urutperiksa, kunjungan, ruanganasal_id, create_time, create_loginpemakai_id', 'required'),
			array('pasienkirimkeunitlain_id, kelaspelayanan_id, jeniskasuspenyakit_id, pasienadmisi_id, pegawai_id, ruangan_id, pasien_id, pendaftaran_id, ruanganasal_id', 'numerical', 'integerOnly'=>true),
			array('no_masukpenunjang', 'length', 'max'=>20),
			array('no_urutperiksa', 'length', 'max'=>3),
			array('kunjungan, statusperiksa', 'length', 'max'=>50),
			array('update_time, update_loginpemakai_id, create_ruangan, panggilantrian', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pasienmasukpenunjang_id, pasienkirimkeunitlain_id, kelaspelayanan_id, jeniskasuspenyakit_id, pasienadmisi_id, pegawai_id, ruangan_id, pasien_id, pendaftaran_id, no_masukpenunjang, tglmasukpenunjang, no_urutperiksa, kunjungan, statusperiksa, ruanganasal_id, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, panggilantrian', 'safe', 'on'=>'search'),
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
			'pengambilansampleTs' => array(self::HAS_MANY, 'PengambilansampleT', 'pasienmasukpenunjang_id'),
			'jadwalkunjunganrmTs' => array(self::HAS_MANY, 'JadwalkunjunganrmT', 'pasienmasukpenunjang_id'),
			'hasilpemeriksaanlabTs' => array(self::HAS_MANY, 'HasilpemeriksaanlabT', 'pasienmasukpenunjang_id'),
			'hasilpemeriksaanrmTs' => array(self::HAS_MANY, 'HasilpemeriksaanrmT', 'pasienmasukpenunjang_id'),
			'hasilpemeriksaanpaTs' => array(self::HAS_MANY, 'HasilpemeriksaanpaT', 'pasienmasukpenunjang_id'),
			'obatalkespasienTs' => array(self::HAS_MANY, 'ObatalkespasienT', 'pasienmasukpenunjang_id'),
			'tindakanpelayananTs' => array(self::HAS_MANY, 'TindakanpelayananT', 'pasienmasukpenunjang_id'),
			'pasienkirimkeunitlain' => array(self::BELONGS_TO, 'PasienkirimkeunitlainT', 'pasienkirimkeunitlain_id'),
			'jeniskasuspenyakit' => array(self::BELONGS_TO, 'JeniskasuspenyakitM', 'jeniskasuspenyakit_id'),
			'kelaspelayanan' => array(self::BELONGS_TO, 'KelaspelayananM', 'kelaspelayanan_id'),
			'pasien' => array(self::BELONGS_TO, 'PasienM', 'pasien_id'),
			'pasienadmisi' => array(self::BELONGS_TO, 'PasienadmisiT', 'pasienadmisi_id'),
			'pegawai' => array(self::BELONGS_TO, 'PegawaiM', 'pegawai_id'),
			'pendaftaran' => array(self::BELONGS_TO, 'PendaftaranT', 'pendaftaran_id'),
			'ruangan' => array(self::BELONGS_TO, 'RuanganM', 'ruangan_id'),
			'ruanganasal' => array(self::BELONGS_TO, 'RuanganM', 'ruanganasal_id'),
			'rencanaoperasiTs' => array(self::HAS_MANY, 'RencanaoperasiT', 'pasienmasukpenunjang_id'),
			'pembjasadetailTs' => array(self::HAS_MANY, 'PembjasadetailT', 'pasienmasukpenunjang_id'),
			'pasienanastesiTs' => array(self::HAS_MANY, 'PasienanastesiT', 'pasienmasukpenunjang_id'),
			'pasienkirimkeunitlainTs' => array(self::HAS_MANY, 'PasienkirimkeunitlainT', 'pasienmasukpenunjang_id'),
			'pasienbatalperiksaRs' => array(self::HAS_MANY, 'PasienbatalperiksaR', 'pasienmasukpenunjang_id'),
			'hasilpemeriksaanradTs' => array(self::HAS_MANY, 'HasilpemeriksaanradT', 'pasienmasukpenunjang_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'pasienmasukpenunjang_id' => 'Pasienmasukpenunjang',
			'pasienkirimkeunitlain_id' => 'Pasienkirimkeunitlain',
			'kelaspelayanan_id' => 'Kelaspelayanan',
			'jeniskasuspenyakit_id' => 'Jeniskasuspenyakit',
			'pasienadmisi_id' => 'Pasienadmisi',
			'pegawai_id' => 'Pegawai',
			'ruangan_id' => 'Ruangan',
			'pasien_id' => 'Pasien',
			'pendaftaran_id' => 'Pendaftaran',
			'no_masukpenunjang' => 'No. Masukpenunjang',
			'tglmasukpenunjang' => 'Tglmasukpenunjang',
			'no_urutperiksa' => 'No. Urutperiksa',
			'kunjungan' => 'Kunjungan',
			'statusperiksa' => 'Statusperiksa',
			'ruanganasal_id' => 'Ruanganasal',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'create_loginpemakai_id' => 'Create Loginpemakai',
			'update_loginpemakai_id' => 'Update Loginpemakai',
			'create_ruangan' => 'Create Ruangan',
			'panggilantrian' => 'Panggilantrian',
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

		if(!empty($this->pasienmasukpenunjang_id)){
			$criteria->addCondition('pasienmasukpenunjang_id = '.$this->pasienmasukpenunjang_id);
		}
		if(!empty($this->pasienkirimkeunitlain_id)){
			$criteria->addCondition('pasienkirimkeunitlain_id = '.$this->pasienkirimkeunitlain_id);
		}
		if(!empty($this->kelaspelayanan_id)){
			$criteria->addCondition('kelaspelayanan_id = '.$this->kelaspelayanan_id);
		}
		if(!empty($this->jeniskasuspenyakit_id)){
			$criteria->addCondition('jeniskasuspenyakit_id = '.$this->jeniskasuspenyakit_id);
		}
		if(!empty($this->pasienadmisi_id)){
			$criteria->addCondition('pasienadmisi_id = '.$this->pasienadmisi_id);
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
		if(!empty($this->pendaftaran_id)){
			$criteria->addCondition('pendaftaran_id = '.$this->pendaftaran_id);
		}
		$criteria->compare('LOWER(no_masukpenunjang)',strtolower($this->no_masukpenunjang),true);
		$criteria->compare('LOWER(tglmasukpenunjang)',strtolower($this->tglmasukpenunjang),true);
		$criteria->compare('LOWER(no_urutperiksa)',strtolower($this->no_urutperiksa),true);
		$criteria->compare('LOWER(kunjungan)',strtolower($this->kunjungan),true);
		$criteria->compare('LOWER(statusperiksa)',strtolower($this->statusperiksa),true);
		if(!empty($this->ruanganasal_id)){
			$criteria->addCondition('ruanganasal_id = '.$this->ruanganasal_id);
		}
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
		$criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);
		$criteria->compare('panggilantrian',$this->panggilantrian);

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