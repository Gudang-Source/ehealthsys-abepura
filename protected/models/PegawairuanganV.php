<?php

/**
 * This is the model class for table "pegawairuangan_v".
 *
 * The followings are the available columns in table 'pegawairuangan_v':
 * @property integer $ruangan_id
 * @property integer $instalasi_id
 * @property string $ruangan_nama
 * @property integer $pegawai_id
 * @property string $gelardepan
 * @property string $nama_pegawai
 * @property string $gelarbelakang_nama
 * @property string $jeniskelamin
 * @property string $nama_keluarga
 * @property string $tempatlahir_pegawai
 * @property string $tgl_lahirpegawai
 * @property string $alamat_pegawai
 * @property boolean $pegawai_aktif
 * @property string $agama
 * @property string $golongandarah
 * @property string $alamatemail
 * @property string $notelp_pegawai
 * @property string $nomobile_pegawai
 * @property string $photopegawai
 * @property integer $pendidikan_id
 * @property string $pendidikan_nama
 * @property integer $pendkualifikasi_id
 * @property string $pendkualifikasi_nama
 * @property string $nomorindukpegawai
 * @property integer $pangkat_id
 * @property integer $kelompokpegawai_id
 * @property integer $jabatan_id
 */
class PegawairuanganV extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PegawairuanganV the static model class
	 */
    
        public $nama_pemakai;
    
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'pegawairuangan_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ruangan_id, instalasi_id, pegawai_id, pendidikan_id, pendkualifikasi_id, pangkat_id, kelompokpegawai_id, jabatan_id', 'numerical', 'integerOnly'=>true),
			array('ruangan_nama, nama_pegawai, nama_keluarga, notelp_pegawai, nomobile_pegawai, pendidikan_nama, pendkualifikasi_nama', 'length', 'max'=>50),
			array('gelardepan', 'length', 'max'=>10),
			array('gelarbelakang_nama', 'length', 'max'=>15),
			array('jeniskelamin, agama', 'length', 'max'=>20),
			array('tempatlahir_pegawai, nomorindukpegawai', 'length', 'max'=>30),
			array('golongandarah', 'length', 'max'=>2),
			array('alamatemail', 'length', 'max'=>100),
			array('photopegawai', 'length', 'max'=>200),
			array('tgl_lahirpegawai, alamat_pegawai, pegawai_aktif', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('ruangan_id, instalasi_id, ruangan_nama, pegawai_id, gelardepan, nama_pegawai, gelarbelakang_nama, jeniskelamin, nama_keluarga, tempatlahir_pegawai, tgl_lahirpegawai, alamat_pegawai, pegawai_aktif, agama, golongandarah, alamatemail, notelp_pegawai, nomobile_pegawai, photopegawai, pendidikan_id, pendidikan_nama, pendkualifikasi_id, pendkualifikasi_nama, nomorindukpegawai, pangkat_id, kelompokpegawai_id, jabatan_id', 'safe', 'on'=>'search'),
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
                                    'ruangan'=>array(self::BELONGS_TO,'RuanganM','ruangan_id'),
                                    'instalasi'=>array(self::BELONGS_TO, 'InstalasiM', 'instalasi_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'ruangan_id' => 'Ruangan',
			'instalasi_id' => 'Instalasi',
			'ruangan_nama' => 'Ruangan Nama',
			'pegawai_id' => 'Pegawai',
			'gelardepan' => 'Gelar Depan',
			'nama_pegawai' => 'Nama Pegawai',
			'gelarbelakang_nama' => 'Gelar Belakang Nama',
			'jeniskelamin' => 'Jenis Kelamin',
			'nama_keluarga' => 'Nama Keluarga',
			'tempatlahir_pegawai' => 'Tempat Lahir Pegawai',
			'tgl_lahirpegawai' => 'Tanggal Lahir Pegawai',
			'alamat_pegawai' => 'Alamat Pegawai',
			'pegawai_aktif' => 'Pegawai Aktif',
			'agama' => 'Agama',
			'golongandarah' => 'Golongan Darah',
			'alamatemail' => 'Alamat Email',
			'notelp_pegawai' => 'No. Telp Pegawai',
			'nomobile_pegawai' => 'No. Mobile Pegawai',
			'photopegawai' => 'Photo Pegawai',
			'pendidikan_id' => 'Pendidikan',
			'pendidikan_nama' => 'Pendidikan Nama',
			'pendkualifikasi_id' => 'Pendidikan Kualifikasi',
			'pendkualifikasi_nama' => 'Pendidikan Kualifikasi Nama',
			'nomorindukpegawai' => 'Nomor Induk Pegawai',
			'pangkat_id' => 'Pangkat',
			'kelompokpegawai_id' => 'Kelompok Pegawai',
			'jabatan_id' => 'Jabatan',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('t.ruangan_id',$this->ruangan_id);
		$criteria->compare('t.instalasi_id',$this->instalasi_id);
		$criteria->compare('LOWER(t.ruangan_nama)',strtolower($this->ruangan_nama),true);
		$criteria->compare('t.pegawai_id',$this->pegawai_id);
		$criteria->compare('LOWER(t.gelardepan)',strtolower($this->gelardepan),true);
		$criteria->compare('LOWER(t.nama_pegawai)',strtolower($this->nama_pegawai),true);
		$criteria->compare('LOWER(t.gelarbelakang_nama)',strtolower($this->gelarbelakang_nama),true);
		$criteria->compare('LOWER(t.jeniskelamin)',strtolower($this->jeniskelamin),true);
		$criteria->compare('LOWER(t.nama_keluarga)',strtolower($this->nama_keluarga),true);
		$criteria->compare('LOWER(t.tempatlahir_pegawai)',strtolower($this->tempatlahir_pegawai),true);
		$criteria->compare('LOWER(t.tgl_lahirpegawai)',strtolower($this->tgl_lahirpegawai),true);
		$criteria->compare('LOWER(t.alamat_pegawai)',strtolower($this->alamat_pegawai),true);
		$criteria->compare('t.pegawai_aktif',$this->pegawai_aktif);
		$criteria->compare('LOWER(t.agama)',strtolower($this->agama),true);
		$criteria->compare('LOWER(t.golongandarah)',strtolower($this->golongandarah),true);
		$criteria->compare('LOWER(t.alamatemail)',strtolower($this->alamatemail),true);
		$criteria->compare('LOWER(t.notelp_pegawai)',strtolower($this->notelp_pegawai),true);
		$criteria->compare('LOWER(t.nomobile_pegawai)',strtolower($this->nomobile_pegawai),true);
		$criteria->compare('LOWER(t.photopegawai)',strtolower($this->photopegawai),true);
		$criteria->compare('t.pendidikan_id',$this->pendidikan_id);
		$criteria->compare('LOWER(t.pendidikan_nama)',strtolower($this->pendidikan_nama),true);
		$criteria->compare('t.pendkualifikasi_id',$this->pendkualifikasi_id);
		$criteria->compare('LOWER(t.pendkualifikasi_nama)',strtolower($this->pendkualifikasi_nama),true);
		$criteria->compare('LOWER(t.nomorindukpegawai)',strtolower($this->nomorindukpegawai),true);
		$criteria->compare('t.pangkat_id',$this->pangkat_id);
		$criteria->compare('t.kelompokpegawai_id',$this->kelompokpegawai_id);
		$criteria->compare('t.jabatan_id',$this->jabatan_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        function searchPetugasLoket() {
            $provider = $this->search();
            
            $provider->criteria->join = 'left join loginpemakai_k l on l.pegawai_id = t.pegawai_id';
            $provider->criteria->compare('lower(nama_pemakai)', strtolower($this->nama_pemakai), true);
            
            return $provider;
        }
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('instalasi_id',$this->instalasi_id);
		$criteria->compare('LOWER(ruangan_nama)',strtolower($this->ruangan_nama),true);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('LOWER(gelardepan)',strtolower($this->gelardepan),true);
		$criteria->compare('LOWER(nama_pegawai)',strtolower($this->nama_pegawai),true);
		$criteria->compare('LOWER(gelarbelakang_nama)',strtolower($this->gelarbelakang_nama),true);
		$criteria->compare('LOWER(jeniskelamin)',strtolower($this->jeniskelamin),true);
		$criteria->compare('LOWER(nama_keluarga)',strtolower($this->nama_keluarga),true);
		$criteria->compare('LOWER(tempatlahir_pegawai)',strtolower($this->tempatlahir_pegawai),true);
		$criteria->compare('LOWER(tgl_lahirpegawai)',strtolower($this->tgl_lahirpegawai),true);
		$criteria->compare('LOWER(alamat_pegawai)',strtolower($this->alamat_pegawai),true);
		$criteria->compare('pegawai_aktif',$this->pegawai_aktif);
		$criteria->compare('LOWER(agama)',strtolower($this->agama),true);
		$criteria->compare('LOWER(golongandarah)',strtolower($this->golongandarah),true);
		$criteria->compare('LOWER(alamatemail)',strtolower($this->alamatemail),true);
		$criteria->compare('LOWER(notelp_pegawai)',strtolower($this->notelp_pegawai),true);
		$criteria->compare('LOWER(nomobile_pegawai)',strtolower($this->nomobile_pegawai),true);
		$criteria->compare('LOWER(photopegawai)',strtolower($this->photopegawai),true);
		$criteria->compare('pendidikan_id',$this->pendidikan_id);
		$criteria->compare('LOWER(pendidikan_nama)',strtolower($this->pendidikan_nama),true);
		$criteria->compare('pendkualifikasi_id',$this->pendkualifikasi_id);
		$criteria->compare('LOWER(pendkualifikasi_nama)',strtolower($this->pendkualifikasi_nama),true);
		$criteria->compare('LOWER(nomorindukpegawai)',strtolower($this->nomorindukpegawai),true);
		$criteria->compare('pangkat_id',$this->pangkat_id);
		$criteria->compare('kelompokpegawai_id',$this->kelompokpegawai_id);
		$criteria->compare('jabatan_id',$this->jabatan_id);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
        
}