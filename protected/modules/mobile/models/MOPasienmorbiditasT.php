<?php

/**
 * This is the model class for table "pasienmorbiditas_t".
 *
 * The followings are the available columns in table 'pasienmorbiditas_t':
 * @property integer $pasienmorbiditas_id
 * @property integer $morfologineoplasma_id
 * @property integer $kamarruangan_id
 * @property integer $jenisketunaan_id
 * @property integer $jeniskasuspenyakit_id
 * @property integer $ruangan_id
 * @property integer $diagnosaicdix_id
 * @property integer $pegawai_id
 * @property integer $sebabdiagnosa_id
 * @property integer $kelompokumur_id
 * @property integer $diagnosa_id
 * @property integer $sebabin_id
 * @property integer $pasien_id
 * @property integer $jenisin_id
 * @property integer $kelompokdiagnosa_id
 * @property integer $golonganumur_id
 * @property integer $pendaftaran_id
 * @property integer $penyebabluarcedera_id
 * @property integer $pasienadmisi_id
 * @property string $tglmorbiditas
 * @property string $kasusdiagnosa
 * @property integer $umur_0_28hr
 * @property integer $umur_28hr_1thn
 * @property integer $umur_1_4thn
 * @property integer $umur_5_14thn
 * @property integer $umur_15_24thn
 * @property integer $umur_25_44thn
 * @property integer $umur_45_64thn
 * @property integer $umur_65
 * @property boolean $infeksinosokomial
 * @property integer $laki_laki
 * @property integer $perempuan
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 *
 * The followings are the available model relations:
 * @property DiagnosaicdixM $diagnosaicdix
 * @property DiagnosaM $diagnosa
 * @property GolonganumurM $golonganumur
 * @property JenisinM $jenisin
 * @property JeniskasuspenyakitM $jeniskasuspenyakit
 * @property JenisketunaanM $jenisketunaan
 * @property KamarruanganM $kamarruangan
 * @property KelompokumurM $kelompokumur
 * @property KelompokdiagnosaM $kelompokdiagnosa
 * @property MorfologineoplasmaM $morfologineoplasma
 * @property PasienM $pasien
 * @property PasienadmisiT $pasienadmisi
 * @property PegawaiM $pegawai
 * @property PendaftaranT $pendaftaran
 * @property PenyebabluarcederaM $penyebabluarcedera
 * @property RuanganM $ruangan
 * @property SebabdiagnosaM $sebabdiagnosa
 * @property SebabinM $sebabin
 */
class MOPasienmorbiditasT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return MOPasienmorbiditasT the static model class
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
		return 'pasienmorbiditas_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('jeniskasuspenyakit_id, ruangan_id, pegawai_id, kelompokumur_id, diagnosa_id, pasien_id, kelompokdiagnosa_id, golonganumur_id, pendaftaran_id, tglmorbiditas, kasusdiagnosa, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('morfologineoplasma_id, kamarruangan_id, jenisketunaan_id, jeniskasuspenyakit_id, ruangan_id, diagnosaicdix_id, pegawai_id, sebabdiagnosa_id, kelompokumur_id, diagnosa_id, sebabin_id, pasien_id, jenisin_id, kelompokdiagnosa_id, golonganumur_id, pendaftaran_id, penyebabluarcedera_id, pasienadmisi_id, umur_0_28hr, umur_28hr_1thn, umur_1_4thn, umur_5_14thn, umur_15_24thn, umur_25_44thn, umur_45_64thn, umur_65, laki_laki, perempuan', 'numerical', 'integerOnly'=>true),
			array('kasusdiagnosa', 'length', 'max'=>20),
			array('infeksinosokomial, update_time, update_loginpemakai_id', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pasienmorbiditas_id, morfologineoplasma_id, kamarruangan_id, jenisketunaan_id, jeniskasuspenyakit_id, ruangan_id, diagnosaicdix_id, pegawai_id, sebabdiagnosa_id, kelompokumur_id, diagnosa_id, sebabin_id, pasien_id, jenisin_id, kelompokdiagnosa_id, golonganumur_id, pendaftaran_id, penyebabluarcedera_id, pasienadmisi_id, tglmorbiditas, kasusdiagnosa, umur_0_28hr, umur_28hr_1thn, umur_1_4thn, umur_5_14thn, umur_15_24thn, umur_25_44thn, umur_45_64thn, umur_65, infeksinosokomial, laki_laki, perempuan, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'diagnosaicdix' => array(self::BELONGS_TO, 'DiagnosaicdixM', 'diagnosaicdix_id'),
			'diagnosa' => array(self::BELONGS_TO, 'DiagnosaM', 'diagnosa_id'),
			'golonganumur' => array(self::BELONGS_TO, 'GolonganumurM', 'golonganumur_id'),
			'jenisin' => array(self::BELONGS_TO, 'JenisinM', 'jenisin_id'),
			'jeniskasuspenyakit' => array(self::BELONGS_TO, 'JeniskasuspenyakitM', 'jeniskasuspenyakit_id'),
			'jenisketunaan' => array(self::BELONGS_TO, 'JenisketunaanM', 'jenisketunaan_id'),
			'kamarruangan' => array(self::BELONGS_TO, 'KamarruanganM', 'kamarruangan_id'),
			'kelompokumur' => array(self::BELONGS_TO, 'KelompokumurM', 'kelompokumur_id'),
			'kelompokdiagnosa' => array(self::BELONGS_TO, 'KelompokdiagnosaM', 'kelompokdiagnosa_id'),
			'morfologineoplasma' => array(self::BELONGS_TO, 'MorfologineoplasmaM', 'morfologineoplasma_id'),
			'pasien' => array(self::BELONGS_TO, 'PasienM', 'pasien_id'),
			'pasienadmisi' => array(self::BELONGS_TO, 'PasienadmisiT', 'pasienadmisi_id'),
			'pegawai' => array(self::BELONGS_TO, 'PegawaiM', 'pegawai_id'),
			'pendaftaran' => array(self::BELONGS_TO, 'PendaftaranT', 'pendaftaran_id'),
			'penyebabluarcedera' => array(self::BELONGS_TO, 'PenyebabluarcederaM', 'penyebabluarcedera_id'),
			'ruangan' => array(self::BELONGS_TO, 'RuanganM', 'ruangan_id'),
			'sebabdiagnosa' => array(self::BELONGS_TO, 'SebabdiagnosaM', 'sebabdiagnosa_id'),
			'sebabin' => array(self::BELONGS_TO, 'SebabinM', 'sebabin_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'pasienmorbiditas_id' => 'Pasienmorbiditas',
			'morfologineoplasma_id' => 'Morfologineoplasma',
			'kamarruangan_id' => 'Kamarruangan',
			'jenisketunaan_id' => 'Jenisketunaan',
			'jeniskasuspenyakit_id' => 'Jeniskasuspenyakit',
			'ruangan_id' => 'Ruangan',
			'diagnosaicdix_id' => 'Diagnosaicdix',
			'pegawai_id' => 'Pegawai',
			'sebabdiagnosa_id' => 'Sebabdiagnosa',
			'kelompokumur_id' => 'Kelompokumur',
			'diagnosa_id' => 'Diagnosa',
			'sebabin_id' => 'Sebabin',
			'pasien_id' => 'Pasien',
			'jenisin_id' => 'Jenisin',
			'kelompokdiagnosa_id' => 'Kelompokdiagnosa',
			'golonganumur_id' => 'Golonganumur',
			'pendaftaran_id' => 'Pendaftaran',
			'penyebabluarcedera_id' => 'Penyebabluarcedera',
			'pasienadmisi_id' => 'Pasienadmisi',
			'tglmorbiditas' => 'Tglmorbiditas',
			'kasusdiagnosa' => 'Kasusdiagnosa',
			'umur_0_28hr' => 'Umur 0 28hr',
			'umur_28hr_1thn' => 'Umur 28hr 1thn',
			'umur_1_4thn' => 'Umur 1 4thn',
			'umur_5_14thn' => 'Umur 5 14thn',
			'umur_15_24thn' => 'Umur 15 24thn',
			'umur_25_44thn' => 'Umur 25 44thn',
			'umur_45_64thn' => 'Umur 45 64thn',
			'umur_65' => 'Umur 65',
			'infeksinosokomial' => 'Infeksinosokomial',
			'laki_laki' => 'Laki Laki',
			'perempuan' => 'Perempuan',
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

		$criteria->compare('pasienmorbiditas_id',$this->pasienmorbiditas_id);
		$criteria->compare('morfologineoplasma_id',$this->morfologineoplasma_id);
		$criteria->compare('kamarruangan_id',$this->kamarruangan_id);
		$criteria->compare('jenisketunaan_id',$this->jenisketunaan_id);
		$criteria->compare('jeniskasuspenyakit_id',$this->jeniskasuspenyakit_id);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('diagnosaicdix_id',$this->diagnosaicdix_id);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('sebabdiagnosa_id',$this->sebabdiagnosa_id);
		$criteria->compare('kelompokumur_id',$this->kelompokumur_id);
		$criteria->compare('diagnosa_id',$this->diagnosa_id);
		$criteria->compare('sebabin_id',$this->sebabin_id);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('jenisin_id',$this->jenisin_id);
		$criteria->compare('kelompokdiagnosa_id',$this->kelompokdiagnosa_id);
		$criteria->compare('golonganumur_id',$this->golonganumur_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('penyebabluarcedera_id',$this->penyebabluarcedera_id);
		$criteria->compare('pasienadmisi_id',$this->pasienadmisi_id);
		$criteria->compare('LOWER(tglmorbiditas)',strtolower($this->tglmorbiditas),true);
		$criteria->compare('LOWER(kasusdiagnosa)',strtolower($this->kasusdiagnosa),true);
		$criteria->compare('umur_0_28hr',$this->umur_0_28hr);
		$criteria->compare('umur_28hr_1thn',$this->umur_28hr_1thn);
		$criteria->compare('umur_1_4thn',$this->umur_1_4thn);
		$criteria->compare('umur_5_14thn',$this->umur_5_14thn);
		$criteria->compare('umur_15_24thn',$this->umur_15_24thn);
		$criteria->compare('umur_25_44thn',$this->umur_25_44thn);
		$criteria->compare('umur_45_64thn',$this->umur_45_64thn);
		$criteria->compare('umur_65',$this->umur_65);
		$criteria->compare('infeksinosokomial',$this->infeksinosokomial);
		$criteria->compare('laki_laki',$this->laki_laki);
		$criteria->compare('perempuan',$this->perempuan);
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