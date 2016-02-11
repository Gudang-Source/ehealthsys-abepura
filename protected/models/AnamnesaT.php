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
 * @property integer $petugas_triase_id
 * @property boolean $statusmerokok
 * @property integer $jmlrokok_btg_hr
 * @property string $riwayatimunisasiblm
 * @property string $riwayatobatygsering
 * @property string $keb_olahraga
 * @property string $keb_jnsolahraga
 * @property integer $keb_frekuensi_kaliminggu
 * @property string $keb_konsumsialkohol
 * @property string $keb_minumkopi
 * @property string $riwayat_kecelakaan
 * @property string $riwayat_operasi
 *
 * The followings are the available model relations:
 * @property PasienM $pasien
 * @property PasienadmisiT $pasienadmisi
 * @property PegawaiM $pegawai
 * @property PendaftaranT $pendaftaran
 * @property TriaseM $triase
 */
class AnamnesaT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return AnamnesaT the static model class
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
			array('pendaftaran_id, pasien_id, triase_id, pasienadmisi_id, pegawai_id, petugas_triase_id, jmlrokok_btg_hr, keb_frekuensi_kaliminggu', 'numerical', 'integerOnly'=>true),
			array('riwayatpenyakitterdahulu, riwayatpenyakitkeluarga, pengobatanygsudahdilakukan, riwayatalergiobat, riwayatkelahiran, riwayatmakanan, paramedis_nama, riwayatperjalananpasien', 'length', 'max'=>100),
			array('lamasakit', 'length', 'max'=>20),
			array('riwayatimunisasi, riwayatimunisasiblm, riwayatobatygsering', 'length', 'max'=>500),
			array('keb_olahraga, keb_konsumsialkohol, keb_minumkopi', 'length', 'max'=>5),
			array('keb_jnsolahraga', 'length', 'max'=>200),
			array('tglanamnesis, keluhanutama, keluhantambahan, keterangananamesa, update_time, update_loginpemakai_id, statusmerokok, riwayat_kecelakaan, riwayat_operasi, apht, tgl_persalinan', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('anamesa_id, pendaftaran_id, pasien_id, triase_id, pasienadmisi_id, pegawai_id, tglanamnesis, keluhanutama, keluhantambahan, riwayatpenyakitterdahulu, riwayatpenyakitkeluarga, lamasakit, pengobatanygsudahdilakukan, riwayatalergiobat, riwayatkelahiran, riwayatmakanan, riwayatimunisasi, paramedis_nama, keterangananamesa, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, riwayatperjalananpasien, petugas_triase_id, statusmerokok, jmlrokok_btg_hr, riwayatimunisasiblm, riwayatobatygsering, keb_olahraga, keb_jnsolahraga, keb_frekuensi_kaliminggu, keb_konsumsialkohol, keb_minumkopi, riwayat_kecelakaan, riwayat_operasi, konsumsi_drug, apht, tgl_persalinan', 'safe', 'on'=>'search'),
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
			'triase' => array(self::BELONGS_TO, 'Triase', 'triase_id'),
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
			'pegawai_id' => 'Dokter Pemeriksa',
			'tglanamnesis' => 'Tanggal Anamnesis',
			'keluhanutama' => 'Keluhan Utama',
			'keluhantambahan' => 'Keluhan Tambahan',
			'riwayatpenyakitterdahulu' => 'Riwayat Penyakit Terdahulu',
			'riwayatpenyakitkeluarga' => 'Riwayat Penyakit Keluarga',
			'lamasakit' => 'Lama Sakit',
			'pengobatanygsudahdilakukan' => 'Pengobatan Yang Sudah Dilakukan',
			'riwayatalergiobat' => 'Riwayat Alergi Obat',
			'riwayatkelahiran' => 'Riwayat Kelahiran',
			'riwayatmakanan' => 'Riwayat Makanan',
			'riwayatimunisasi' => 'Riwayat Imunisasi',
			'paramedis_nama' => 'Paramedis Nama',
			'keterangananamesa' => 'Keterangan Anamesa',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'create_loginpemakai_id' => 'Create Loginpemakai',
			'update_loginpemakai_id' => 'Update Loginpemakai',
			'create_ruangan' => 'Create Ruangan',
			'riwayatperjalananpasien' => 'Riwayat Perjalanan Pasien',
			'petugas_triase_id' => 'Petugas Triase',
			'statusmerokok' => 'Status Merokok',
			'jmlrokok_btg_hr' => 'Jumlah Rokok Batang',
			'riwayatimunisasiblm' => 'Riwayatimunisasiblm',
			'riwayatobatygsering' => 'Riwayatobatygsering',
			'keb_olahraga' => 'Keb Olahraga',
			'keb_jnsolahraga' => 'Keb Jnsolahraga',
			'keb_frekuensi_kaliminggu' => 'Keb Frekuensi Kaliminggu',
			'keb_konsumsialkohol' => 'Keb Konsumsialkohol',
			'keb_minumkopi' => 'Keb Minumkopi',
			'riwayat_kecelakaan' => 'Riwayat Kecelakaan',
			'riwayat_operasi' => 'Riwayat Operasi',
			'konsumsi_drug' => 'Konsumsi Drug',
                        'apht'=>'APHT',
                        'tgl_persalinan'=>'Tanggal Persalinan',
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

		if(!empty($this->anamesa_id)){
			$criteria->addCondition('anamesa_id = '.$this->anamesa_id);
		}
		if(!empty($this->pendaftaran_id)){
			$criteria->addCondition('pendaftaran_id = '.$this->pendaftaran_id);
		}
		if(!empty($this->pasien_id)){
			$criteria->addCondition('pasien_id = '.$this->pasien_id);
		}
		if(!empty($this->triase_id)){
			$criteria->addCondition('triase_id = '.$this->triase_id);
		}
		if(!empty($this->pasienadmisi_id)){
			$criteria->addCondition('pasienadmisi_id = '.$this->pasienadmisi_id);
		}
		if(!empty($this->pegawai_id)){
			$criteria->addCondition('pegawai_id = '.$this->pegawai_id);
			
		}
		
		
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
		if(!empty($this->petugas_triase_id)){
			$criteria->addCondition('petugas_triase_id = '.$this->petugas_triase_id);
		}
		$criteria->compare('statusmerokok',$this->statusmerokok);
		if(!empty($this->jmlrokok_btg_hr)){
			$criteria->addCondition('jmlrokok_btg_hr = '.$this->jmlrokok_btg_hr);
		}
		$criteria->compare('LOWER(riwayatimunisasiblm)',strtolower($this->riwayatimunisasiblm),true);
		$criteria->compare('LOWER(riwayatobatygsering)',strtolower($this->riwayatobatygsering),true);
		$criteria->compare('LOWER(keb_olahraga)',strtolower($this->keb_olahraga),true);
		$criteria->compare('LOWER(keb_jnsolahraga)',strtolower($this->keb_jnsolahraga),true);
		if(!empty($this->keb_frekuensi_kaliminggu)){
			$criteria->addCondition('keb_frekuensi_kaliminggu = '.$this->keb_frekuensi_kaliminggu);
		}
		$criteria->compare('LOWER(keb_konsumsialkohol)',strtolower($this->keb_konsumsialkohol),true);
		$criteria->compare('LOWER(keb_minumkopi)',strtolower($this->keb_minumkopi),true);
		$criteria->compare('LOWER(riwayat_kecelakaan)',strtolower($this->riwayat_kecelakaan),true);
		$criteria->compare('LOWER(riwayat_operasi)',strtolower($this->riwayat_operasi),true);
        $criteria->compare('LOWER(konsumsi_drug)',strtolower($this->konsumsi_drug),true);
		
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
		
		public function getDokterItems($ruangan_id=null){
            if (Yii::app()->user->getState('dokterruangan')==true){
				if(empty($ruangan_id))
					$ruangan_id = Yii::app()->user->getState('ruangan_id');
                if(!empty($ruangan_id))
                    return DokterV::model()->findAllByAttributes(array('pegawai_aktif'=>true,'ruangan_id'=>$ruangan_id),array('order'=>'nama_pegawai'));
                else
                    return array();
            }else{
                //criteria disamakan dengan dokter_v
				$criteria = new CDbCriteria();
				$criteria->addInCondition('kelompokpegawai_id', array(Params::KELOMPOKPEGAWAI_ID_TENAGA_MEDIK, Params::KELOMPOKPEGAWAI_ID_PARAMEDIS_KEPERAWATAN));
				$criteria->addCondition("pegawai_aktif = TRUE");
				$criteria->order = 'nama_pegawai';
                return PegawaiM::model()->findAll($criteria);
            }
        }
}