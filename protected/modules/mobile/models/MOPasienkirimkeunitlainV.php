<?php

/**
 * This is the model class for table "pasienkirimkeunitlain_v".
 *
 * The followings are the available columns in table 'pasienkirimkeunitlain_v':
 * @property integer $pasienkirimkeunitlain_id
 * @property integer $pasien_id
 * @property string $no_rekam_medik
 * @property string $namadepan
 * @property string $nama_pasien
 * @property string $nama_bin
 * @property string $jeniskelamin
 * @property string $tempat_lahir
 * @property string $tanggal_lahir
 * @property string $alamat_pasien
 * @property string $agama
 * @property string $golongandarah
 * @property string $rhesus
 * @property integer $penanggungjawab_id
 * @property string $pengantar
 * @property string $hubungankeluarga
 * @property string $nama_pj
 * @property string $tgl_kirimpasien
 * @property string $nourut
 * @property integer $pendaftaran_id
 * @property string $no_pendaftaran
 * @property string $tgl_pendaftaran
 * @property integer $jeniskasuspenyakit_id
 * @property string $jeniskasuspenyakit_nama
 * @property integer $carabayar_id
 * @property string $carabayar_nama
 * @property integer $penjamin_id
 * @property string $penjamin_nama
 * @property integer $kelaspelayanan_id
 * @property string $kelaspelayanan_nama
 * @property integer $pegawai_id
 * @property string $gelardepan
 * @property string $nama_pegawai
 * @property integer $gelarbelakang_id
 * @property string $gelarbelakang_nama
 * @property string $catatandokterpengirim
 * @property integer $ruanganasal_id
 * @property string $ruanganasal_nama
 * @property integer $instalasiasal_id
 * @property string $instalasiasal_nama
 * @property integer $ruangan_id
 * @property string $ruangan_nama
 * @property integer $instalasi_id
 * @property integer $pasienmasukpenunjang_id
 * @property string $create_time
 * @property string $create_loginpemakai_id
 * @property string $umur
 */
class MOPasienkirimkeunitlainV extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return MOPasienkirimkeunitlainV the static model class
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
		return 'pasienkirimkeunitlain_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pasienkirimkeunitlain_id, pasien_id, penanggungjawab_id, pendaftaran_id, jeniskasuspenyakit_id, carabayar_id, penjamin_id, kelaspelayanan_id, pegawai_id, gelarbelakang_id, ruanganasal_id, instalasiasal_id, ruangan_id, instalasi_id, pasienmasukpenunjang_id', 'numerical', 'integerOnly'=>true),
			array('no_rekam_medik, gelardepan', 'length', 'max'=>10),
			array('namadepan, jeniskelamin, agama, rhesus, no_pendaftaran', 'length', 'max'=>20),
			array('nama_pasien, pengantar, hubungankeluarga, nama_pj, carabayar_nama, penjamin_nama, kelaspelayanan_nama, nama_pegawai, ruanganasal_nama, instalasiasal_nama, ruangan_nama', 'length', 'max'=>50),
			array('nama_bin, umur', 'length', 'max'=>30),
			array('tempat_lahir', 'length', 'max'=>25),
			array('golongandarah', 'length', 'max'=>2),
			array('nourut', 'length', 'max'=>3),
			array('jeniskasuspenyakit_nama', 'length', 'max'=>100),
			array('gelarbelakang_nama', 'length', 'max'=>15),
			array('tanggal_lahir, alamat_pasien, tgl_kirimpasien, tgl_pendaftaran, catatandokterpengirim, create_time, create_loginpemakai_id', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pasienkirimkeunitlain_id, pasien_id, no_rekam_medik, namadepan, nama_pasien, nama_bin, jeniskelamin, tempat_lahir, tanggal_lahir, alamat_pasien, agama, golongandarah, rhesus, penanggungjawab_id, pengantar, hubungankeluarga, nama_pj, tgl_kirimpasien, nourut, pendaftaran_id, no_pendaftaran, tgl_pendaftaran, jeniskasuspenyakit_id, jeniskasuspenyakit_nama, carabayar_id, carabayar_nama, penjamin_id, penjamin_nama, kelaspelayanan_id, kelaspelayanan_nama, pegawai_id, gelardepan, nama_pegawai, gelarbelakang_id, gelarbelakang_nama, catatandokterpengirim, ruanganasal_id, ruanganasal_nama, instalasiasal_id, instalasiasal_nama, ruangan_id, ruangan_nama, instalasi_id, pasienmasukpenunjang_id, create_time, create_loginpemakai_id, umur', 'safe', 'on'=>'search'),
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
			'pasienkirimkeunitlain_id' => 'Pasienkirimkeunitlain',
			'pasien_id' => 'Pasien',
			'no_rekam_medik' => 'No Rekam Medik',
			'namadepan' => 'Namadepan',
			'nama_pasien' => 'Nama Pasien',
			'nama_bin' => 'Nama Bin',
			'jeniskelamin' => 'Jeniskelamin',
			'tempat_lahir' => 'Tempat Lahir',
			'tanggal_lahir' => 'Tanggal Lahir',
			'alamat_pasien' => 'Alamat Pasien',
			'agama' => 'Agama',
			'golongandarah' => 'Golongandarah',
			'rhesus' => 'Rhesus',
			'penanggungjawab_id' => 'Penanggungjawab',
			'pengantar' => 'Pengantar',
			'hubungankeluarga' => 'Hubungankeluarga',
			'nama_pj' => 'Nama Pj',
			'tgl_kirimpasien' => 'Tgl Kirimpasien',
			'nourut' => 'Nourut',
			'pendaftaran_id' => 'Pendaftaran',
			'no_pendaftaran' => 'No Pendaftaran',
			'tgl_pendaftaran' => 'Tgl Pendaftaran',
			'jeniskasuspenyakit_id' => 'Jeniskasuspenyakit',
			'jeniskasuspenyakit_nama' => 'Jeniskasuspenyakit Nama',
			'carabayar_id' => 'Carabayar',
			'carabayar_nama' => 'Carabayar Nama',
			'penjamin_id' => 'Penjamin',
			'penjamin_nama' => 'Penjamin Nama',
			'kelaspelayanan_id' => 'Kelaspelayanan',
			'kelaspelayanan_nama' => 'Kelaspelayanan Nama',
			'pegawai_id' => 'Pegawai',
			'gelardepan' => 'Gelardepan',
			'nama_pegawai' => 'Nama Pegawai',
			'gelarbelakang_id' => 'Gelarbelakang',
			'gelarbelakang_nama' => 'Gelarbelakang Nama',
			'catatandokterpengirim' => 'Catatandokterpengirim',
			'ruanganasal_id' => 'Ruanganasal',
			'ruanganasal_nama' => 'Ruanganasal Nama',
			'instalasiasal_id' => 'Instalasiasal',
			'instalasiasal_nama' => 'Instalasiasal Nama',
			'ruangan_id' => 'Ruangan',
			'ruangan_nama' => 'Ruangan Nama',
			'instalasi_id' => 'Instalasi',
			'pasienmasukpenunjang_id' => 'Pasienmasukpenunjang',
			'create_time' => 'Create Time',
			'create_loginpemakai_id' => 'Create Loginpemakai',
			'umur' => 'Umur',
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

		if(!empty($this->pasienkirimkeunitlain_id)){
			$criteria->addCondition('pasienkirimkeunitlain_id = '.$this->pasienkirimkeunitlain_id);
		}
		if(!empty($this->pasien_id)){
			$criteria->addCondition('pasien_id = '.$this->pasien_id);
		}
		$criteria->compare('LOWER(no_rekam_medik)',strtolower($this->no_rekam_medik),true);
		$criteria->compare('LOWER(namadepan)',strtolower($this->namadepan),true);
		$criteria->compare('LOWER(nama_pasien)',strtolower($this->nama_pasien),true);
		$criteria->compare('LOWER(nama_bin)',strtolower($this->nama_bin),true);
		$criteria->compare('LOWER(jeniskelamin)',strtolower($this->jeniskelamin),true);
		$criteria->compare('LOWER(tempat_lahir)',strtolower($this->tempat_lahir),true);
		$criteria->compare('LOWER(tanggal_lahir)',strtolower($this->tanggal_lahir),true);
		$criteria->compare('LOWER(alamat_pasien)',strtolower($this->alamat_pasien),true);
		$criteria->compare('LOWER(agama)',strtolower($this->agama),true);
		$criteria->compare('LOWER(golongandarah)',strtolower($this->golongandarah),true);
		$criteria->compare('LOWER(rhesus)',strtolower($this->rhesus),true);
		if(!empty($this->penanggungjawab_id)){
			$criteria->addCondition('penanggungjawab_id = '.$this->penanggungjawab_id);
		}
		$criteria->compare('LOWER(pengantar)',strtolower($this->pengantar),true);
		$criteria->compare('LOWER(hubungankeluarga)',strtolower($this->hubungankeluarga),true);
		$criteria->compare('LOWER(nama_pj)',strtolower($this->nama_pj),true);
		$criteria->compare('LOWER(tgl_kirimpasien)',strtolower($this->tgl_kirimpasien),true);
		$criteria->compare('LOWER(nourut)',strtolower($this->nourut),true);
		if(!empty($this->pendaftaran_id)){
			$criteria->addCondition('pendaftaran_id = '.$this->pendaftaran_id);
		}
		$criteria->compare('LOWER(no_pendaftaran)',strtolower($this->no_pendaftaran),true);
		$criteria->compare('LOWER(tgl_pendaftaran)',strtolower($this->tgl_pendaftaran),true);
		if(!empty($this->jeniskasuspenyakit_id)){
			$criteria->addCondition('jeniskasuspenyakit_id = '.$this->jeniskasuspenyakit_id);
		}
		$criteria->compare('LOWER(jeniskasuspenyakit_nama)',strtolower($this->jeniskasuspenyakit_nama),true);
		if(!empty($this->carabayar_id)){
			$criteria->addCondition('carabayar_id = '.$this->carabayar_id);
		}
		$criteria->compare('LOWER(carabayar_nama)',strtolower($this->carabayar_nama),true);
		if(!empty($this->penjamin_id)){
			$criteria->addCondition('penjamin_id = '.$this->penjamin_id);
		}
		$criteria->compare('LOWER(penjamin_nama)',strtolower($this->penjamin_nama),true);
		if(!empty($this->kelaspelayanan_id)){
			$criteria->addCondition('kelaspelayanan_id = '.$this->kelaspelayanan_id);
		}
		$criteria->compare('LOWER(kelaspelayanan_nama)',strtolower($this->kelaspelayanan_nama),true);
		if(!empty($this->pegawai_id)){
			$criteria->addCondition('pegawai_id = '.$this->pegawai_id);
		}
		$criteria->compare('LOWER(gelardepan)',strtolower($this->gelardepan),true);
		$criteria->compare('LOWER(nama_pegawai)',strtolower($this->nama_pegawai),true);
		if(!empty($this->gelarbelakang_id)){
			$criteria->addCondition('gelarbelakang_id = '.$this->gelarbelakang_id);
		}
		$criteria->compare('LOWER(gelarbelakang_nama)',strtolower($this->gelarbelakang_nama),true);
		$criteria->compare('LOWER(catatandokterpengirim)',strtolower($this->catatandokterpengirim),true);
		if(!empty($this->ruanganasal_id)){
			$criteria->addCondition('ruanganasal_id = '.$this->ruanganasal_id);
		}
		$criteria->compare('LOWER(ruanganasal_nama)',strtolower($this->ruanganasal_nama),true);
		if(!empty($this->instalasiasal_id)){
			$criteria->addCondition('instalasiasal_id = '.$this->instalasiasal_id);
		}
		$criteria->compare('LOWER(instalasiasal_nama)',strtolower($this->instalasiasal_nama),true);
		if(!empty($this->ruangan_id)){
			$criteria->addCondition('ruangan_id = '.$this->ruangan_id);
		}
		$criteria->compare('LOWER(ruangan_nama)',strtolower($this->ruangan_nama),true);
		if(!empty($this->instalasi_id)){
			$criteria->addCondition('instalasi_id = '.$this->instalasi_id);
		}
		if(!empty($this->pasienmasukpenunjang_id)){
			$criteria->addCondition('pasienmasukpenunjang_id = '.$this->pasienmasukpenunjang_id);
		}
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(umur)',strtolower($this->umur),true);

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