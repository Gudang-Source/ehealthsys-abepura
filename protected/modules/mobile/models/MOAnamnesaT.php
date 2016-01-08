<?php

/**
 * This is the model class for table "anamnesa_t".
 *
 * The followings are the available columns in table 'anamnesa_t':
 * @property integer $anamesa_id
 * @property integer $pendaftaran_id
 * @property integer $pasien_id
 * @property integer $triase_id
 * @property integer $pasienadmisi_id
 * @property integer $pegawai_id
 * @property string $tglanamnesis
 * @property string $keluhanutama
 * @property string $keluhantambahan
 * @property string $riwayatpenyakitterdahulu
 * @property string $riwayatpenyakitkeluarga
 * @property string $lamasakit
 * @property string $pengobatanygsudahdilakukan
 * @property string $riwayatalergiobat
 * @property string $riwayatkelahiran
 * @property string $riwayatmakanan
 * @property string $riwayatimunisasi
 * @property string $paramedis_nama
 * @property string $keterangananamesa
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 * @property string $riwayatperjalananpasien
 *
 * The followings are the available model relations:
 * @property PasienM $pasien
 * @property PasienadmisiT $pasienadmisi
 * @property PegawaiM $pegawai
 * @property PendaftaranT $pendaftaran
 * @property TriaseM $triase
 */
class MOAnamnesaT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return MOAnamnesaT the static model class
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
		return 'anamnesa_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pendaftaran_id, pasien_id, pegawai_id, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('pendaftaran_id, pasien_id, triase_id, pasienadmisi_id, pegawai_id', 'numerical', 'integerOnly'=>true),
			array('riwayatpenyakitterdahulu, riwayatpenyakitkeluarga, pengobatanygsudahdilakukan, riwayatalergiobat, riwayatkelahiran, riwayatmakanan, riwayatimunisasi, paramedis_nama, riwayatperjalananpasien', 'length', 'max'=>100),
			array('lamasakit', 'length', 'max'=>20),
			array('tglanamnesis, keluhanutama, keluhantambahan, keterangananamesa, update_time, update_loginpemakai_id', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('anamesa_id, pendaftaran_id, pasien_id, triase_id, pasienadmisi_id, pegawai_id, tglanamnesis, keluhanutama, keluhantambahan, riwayatpenyakitterdahulu, riwayatpenyakitkeluarga, lamasakit, pengobatanygsudahdilakukan, riwayatalergiobat, riwayatkelahiran, riwayatmakanan, riwayatimunisasi, paramedis_nama, keterangananamesa, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, riwayatperjalananpasien', 'safe', 'on'=>'search'),
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
			'pasien' => array(self::BELONGS_TO, 'PasienM', 'pasien_id'),
			'pasienadmisi' => array(self::BELONGS_TO, 'PasienadmisiT', 'pasienadmisi_id'),
			'pegawai' => array(self::BELONGS_TO, 'PegawaiM', 'pegawai_id'),
			'pendaftaran' => array(self::BELONGS_TO, 'PendaftaranT', 'pendaftaran_id'),
			'triase' => array(self::BELONGS_TO, 'TriaseM', 'triase_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'anamesa_id' => 'Anamesa',
			'pendaftaran_id' => 'Pendaftaran',
			'pasien_id' => 'Pasien',
			'triase_id' => 'Triase',
			'pasienadmisi_id' => 'Pasienadmisi',
			'pegawai_id' => 'Pegawai',
			'tglanamnesis' => 'Tglanamnesis',
			'keluhanutama' => 'Keluhanutama',
			'keluhantambahan' => 'Keluhantambahan',
			'riwayatpenyakitterdahulu' => 'Riwayatpenyakitterdahulu',
			'riwayatpenyakitkeluarga' => 'Riwayatpenyakitkeluarga',
			'lamasakit' => 'Lamasakit',
			'pengobatanygsudahdilakukan' => 'Pengobatanygsudahdilakukan',
			'riwayatalergiobat' => 'Riwayatalergiobat',
			'riwayatkelahiran' => 'Riwayatkelahiran',
			'riwayatmakanan' => 'Riwayatmakanan',
			'riwayatimunisasi' => 'Riwayatimunisasi',
			'paramedis_nama' => 'Paramedis Nama',
			'keterangananamesa' => 'Keterangananamesa',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'create_loginpemakai_id' => 'Create Loginpemakai',
			'update_loginpemakai_id' => 'Update Loginpemakai',
			'create_ruangan' => 'Create Ruangan',
			'riwayatperjalananpasien' => 'Riwayatperjalananpasien',
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

		$criteria->compare('anamesa_id',$this->anamesa_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('triase_id',$this->triase_id);
		$criteria->compare('pasienadmisi_id',$this->pasienadmisi_id);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('LOWER(tglanamnesis)',strtolower($this->tglanamnesis),true);
		$criteria->compare('LOWER(keluhanutama)',strtolower($this->keluhanutama),true);
		$criteria->compare('LOWER(keluhantambahan)',strtolower($this->keluhantambahan),true);
		$criteria->compare('LOWER(riwayatpenyakitterdahulu)',strtolower($this->riwayatpenyakitterdahulu),true);
		$criteria->compare('LOWER(riwayatpenyakitkeluarga)',strtolower($this->riwayatpenyakitkeluarga),true);
		$criteria->compare('LOWER(lamasakit)',strtolower($this->lamasakit),true);
		$criteria->compare('LOWER(pengobatanygsudahdilakukan)',strtolower($this->pengobatanygsudahdilakukan),true);
		$criteria->compare('LOWER(riwayatalergiobat)',strtolower($this->riwayatalergiobat),true);
		$criteria->compare('LOWER(riwayatkelahiran)',strtolower($this->riwayatkelahiran),true);
		$criteria->compare('LOWER(riwayatmakanan)',strtolower($this->riwayatmakanan),true);
		$criteria->compare('LOWER(riwayatimunisasi)',strtolower($this->riwayatimunisasi),true);
		$criteria->compare('LOWER(paramedis_nama)',strtolower($this->paramedis_nama),true);
		$criteria->compare('LOWER(keterangananamesa)',strtolower($this->keterangananamesa),true);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
		$criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);
		$criteria->compare('LOWER(riwayatperjalananpasien)',strtolower($this->riwayatperjalananpasien),true);

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