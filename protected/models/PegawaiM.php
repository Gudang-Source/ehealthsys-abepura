<?php

/**
 * This is the model class for table "pegawai_m".
 *
 * The followings are the available columns in table 'pegawai_m':
 * @property integer $pegawai_id
 * @property integer $kelurahan_id
 * @property integer $kecamatan_id
 * @property integer $profilrs_id
 * @property integer $gelarbelakang_id
 *  * @property integer $gelarbelakang_nama
 * @property integer $suku_id
 * @property integer $kelompokpegawai_id
 * @property integer $pendkualifikasi_id
 * @property integer $jabatan_id
 * @property integer $pendidikan_id
 * @property integer $propinsi_id
 * @property integer $pangkat_id
 * @property integer $kabupaten_id
 * @property string $nomorindukpegawai
 * @property string $no_kartupegawainegerisipil
 * @property string $no_karis_karsu
 * @property string $no_taspen
 * @property string $no_askes
 * @property string $gelardepan
 * @property string $nama_pegawai
 * @property string $nama_keluarga
 * @property string $tempatlahir_pegawai
 * @property string $tgl_lahirpegawai
 * @property string $jeniskelamin
 * @property string $statusperkawinan
 * @property string $alamat_pegawai
 * @property string $agama
 * @property string $golongandarah
 * @property string $rhesus
 * @property string $alamatemail
 * @property string $notelp_pegawai
 * @property string $nomobile_pegawai
 * @property string $warganegara_pegawai
 * @property string $jeniswaktukerja
 * @property string $kelompokjabatan
 * @property string $kategoripegawai
 * @property string $kategoripegawaiasal
 * @property string $photopegawai
 * @property boolean $pegawai_aktif
 * @property integer $esselon_id
 * @property integer $statuskepemilikanrumah_id
 * @property string $jenisidentitas
 * @property string $noidentitas
 * @property string $nofingerprint
 * @property double $tinggibadan
 * @property double $beratbadan
 * @property string $kemampuanbahasa
 * @property string $warnakulit
 * @property string $nip_lama
 * @property string $no_rekening
 * @property string $bank_no_rekening
 * @property string $npwp
 * @property string $tglditerima
 * @property string $tglberhenti
 */
class PegawaiM extends CActiveRecord
{
        public $tglpenilaian;
        public $pegawai_nama;
        public $no_rekening;
        public $bank_no_rekening;
        public $gelarbelakang_nama;
        public $dokter_pemeriksa;
        public $ruangan_id;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PegawaiM the static model class
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
		return 'pegawai_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('profilrs_id, kelompokpegawai_id, nama_pegawai, jeniskelamin, statusperkawinan, agama, tgl_lahirpegawai', 'required'),
			array('kelurahan_id, kecamatan_id, profilrs_id, gelarbelakang_id, suku_id, kelompokpegawai_id, pendkualifikasi_id, jabatan_id, pendidikan_id, propinsi_id, pangkat_id, kabupaten_id, esselon_id, statuskepemilikanrumah_id', 'numerical', 'integerOnly'=>true),
			array('tinggibadan, beratbadan', 'numerical'),
			array('nomorindukpegawai, no_kartupegawainegerisipil, no_karis_karsu, no_taspen, no_askes, tempatlahir_pegawai, kelompokjabatan', 'length', 'max'=>30),
			array('gelardepan, kategoripegawai', 'length', 'max'=>100),
			array('nama_pegawai, nama_keluarga, notelp_pegawai, nomobile_pegawai, kategoripegawaiasal, jenisidentitas, deskripsi', 'length', 'max'=>50),
			array('jeniskelamin, statusperkawinan, agama, rhesus, jeniswaktukerja', 'length', 'max'=>100),
			array('golongandarah', 'length', 'max'=>2),
                        array('create_time,update_time','default','value'=>date('Y-m-d'),'setOnEmpty'=>false,'on'=>'insert'),
                        array('update_time','default','value'=>date('Y-m-d'),'setOnEmpty'=>false,'on'=>'update'),
                        array('create_loginpemakai_id','default','value'=>Yii::app()->user->id,'on'=>'insert'),
                        array('update_loginpemakai_id','default','value'=>Yii::app()->user->id,'on'=>'update,insert'),
                        array('create_ruangan','default','value'=>Yii::app()->user->getState('ruangan_id'),'on'=>'insert'),
			array('alamatemail, kemampuanbahasa', 'length', 'max'=>100),
			array('warganegara_pegawai', 'length', 'max'=>25),
			array('photopegawai', 'length', 'max'=>200),
			array('tgl_lahirpegawai, unit_perusahaan, suratizinpraktek, tglpenilaian, alamat_pegawai, pegawai_aktif, noidentitas, nofingerprint,warnakulit, nip_lama, tglditerima, tglberhenti,deskripsi, golonganpegawai_id', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('deskripsi, pegawai_id, unit_perusahaan, suratizinpraktek kelurahan_id, tglpenilaian, kecamatan_id, profilrs_id, gelarbelakang_id,gelarbelakang_nama, suku_id, kelompokpegawai_id,kelompokpegawai_nama, pendkualifikasi_id, jabatan_id, pendidikan_id, propinsi_id, pangkat_id, kabupaten_id, nomorindukpegawai, no_kartupegawainegerisipil, no_karis_karsu, no_taspen, no_askes, gelardepan, nama_pegawai, nama_keluarga, tempatlahir_pegawai, tgl_lahirpegawai, jeniskelamin, statusperkawinan, alamat_pegawai, agama, golongandarah, rhesus, alamatemail, notelp_pegawai, nomobile_pegawai, warganegara_pegawai, jeniswaktukerja, kelompokjabatan, kategoripegawai, kategoripegawaiasal, photopegawai, pegawai_aktif, esselon_id, statuskepemilikanrumah_id, jenisidentitas, noidentitas, nofingerprint, tinggibadan, beratbadan, kemampuanbahasa, warnakulit, nip_lama, norekening, banknorekening, npwp, tglditerima, tglberhenti,gelarbelakang_nama, golonganpegawai_id', 'safe', 'on'=>'search'),
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

                    'jabatan' => array(self::BELONGS_TO, 'JabatanM', 'jabatan_id'),
                    'kelompokpegawai' => array(self::BELONGS_TO, 'KelompokpegawaiM', 'kelompokpegawai_id'),
                    'pangkat' => array(self::BELONGS_TO, 'PangkatM', 'pangkat_id'),
                    'pendidikan' => array(self::BELONGS_TO, 'PendidikanM', 'pendidikan_id'),
                    'gelarbelakang'=>array(self::BELONGS_TO,'GelarbelakangM','gelarbelakang_id'),
                    'suku'=>array(self::BELONGS_TO,'SukuM','suku_id'),
                    'pendkualifikasi'=>array(self::BELONGS_TO,'PendidikankualifikasiM','pendkualifikasi_id'),
                    'propinsi'=>array(self::BELONGS_TO,'PropinsiM','propinsi_id'),
                    'kabupaten'=>array(self::BELONGS_TO,'KabupatenM','kabupaten_id'),
                    'kecamatan'=>array(self::BELONGS_TO,'KecamatanM','kecamatan_id'),
                    'kelurahan'=>array(self::BELONGS_TO,'KelurahanM','kelurahan_id'),
                    'penilaiankaryawan'=>array(self::BELONGS_TO,'PenilaianpegawaiT','pegawai_id'),

		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'pegawai_id' => 'Pegawai',
			'kelurahan_id' => 'Kelurahan',
			'kecamatan_id' => 'Kecamatan',
			'profilrs_id' => 'Profile RS.',
			'gelarbelakang_id' => 'Gelar belakang',
			'suku_id' => 'Suku',
			'kelompokpegawai_id' => 'Kelompok pegawai',
			'pendkualifikasi_id' => 'Pendidikan kualifikasi',
			'jabatan_id' => 'Jabatan',
			'pendidikan_id' => 'Pendidikan',
			'propinsi_id' => 'Propinsi',
			'pangkat_id' => 'Pangkat',
			'kabupaten_id' => 'Kabupaten',
			'nomorindukpegawai' => 'NIP',
			'no_kartupegawainegerisipil' => 'No. PNS',
			'no_karis_karsu' => 'No. Karis Karsu',
			'no_taspen' => 'No. Taspen',
			'no_askes' => 'No. Askes',
			'gelardepan' => 'Gelar depan',
			'nama_pegawai' => 'Nama Pegawai',
			'nama_keluarga' => 'Nama Keluarga',
			'tempatlahir_pegawai' => 'Tempat lahir',
			'tgl_lahirpegawai' => 'Tanggal lahir',
			'jeniskelamin' => 'Jenis Kelamin',
			'statusperkawinan' => 'Status perkawinan',
			'alamat_pegawai' => 'Alamat Pegawai',
			'agama' => 'Agama',
			'golongandarah' => 'Golongan darah',
			'rhesus' => 'Rhesus',
			'alamatemail' => 'Email',
			'notelp_pegawai' => 'No. Telepon',
			'nomobile_pegawai' => 'No. HP',
			'warganegara_pegawai' => 'Warga Negara',
			'jeniswaktukerja' => 'Jenis waktu kerja',
			'kelompokjabatan' => 'Kelompok jabatan',
			'kategoripegawai' => 'Kategori pegawai',
			'kategoripegawaiasal' => 'Kategori pegawai asal',
			'photopegawai' => 'Photo pegawai',
			'pegawai_aktif' => 'Aktif',
			'esselon_id' => 'Esselon',
			'statuskepemilikanrumah_id' => 'Status kepemilikan rumah',
			'jenisidentitas' => 'Jenis identitas',
			'noidentitas' => 'No. identitas',
			'nofingerprint' => 'No. fingerprint',
			'tinggibadan' => 'Tinggi badan',
			'beratbadan' => 'Berat badan',
			'kemampuanbahasa' => 'Kemampuan bahasa',
			'warnakulit' => 'Warna kulit',
			'nip_lama' => 'Nip Lama',
			'norekening' => 'No. Rekening',
			'banknorekening' => 'Bank No. Rekening',
			'npwp' => 'Npwp',
			'tglditerima' => 'Tanggal Diterima',
			'tglberhenti' => 'Tanggal Berhenti',
			'nipsampai'=>'NIP Sampai',
			'namasampai'=>'Nama Sampai',
			'jabatansampai'=>'Jabatan Sampai',
			'kelompoksampai'=>'Kelompok Sampai',
			'unit_perusahaan'=>'Unit / Perusahaan',
			'suratizinpraktek'=>'Surat Izin Praktek',
			'deskripsi'=>'Deskripsi',
			'jenistenagamedis_id'=>'Jenis Tenaga Medis',
			'tglmasaaktifpeg'=>'Masa Aktif',
			'tglmasaaktifpeg_sd'=>'Sampai Dengan',
                        'golonganpegawai_id'=>'Golongan Pegawai',
                        'ruangan_id'=>'Ruangan Pegawai',
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

		$criteria->compare('t.pegawai_id',$this->pegawai_id);
		$criteria->compare('kelurahan_id',$this->kelurahan_id);
		$criteria->compare('kecamatan_id',$this->kecamatan_id);
		$criteria->compare('profilrs_id',$this->profilrs_id);
               
		$criteria->compare('gelarbelakang_id',$this->gelarbelakang_id);
		$criteria->compare('gelarbelakang_nama',$this->gelarbelakang_nama);
		$criteria->compare('suku_id',$this->suku_id);
		$criteria->compare('kelompokpegawai_id',$this->kelompokpegawai_id);
		$criteria->compare('pendkualifikasi_id',$this->pendkualifikasi_id);
		$criteria->compare('jabatan_id',$this->jabatan_id);
		$criteria->compare('pendidikan_id',$this->pendidikan_id);
		$criteria->compare('propinsi_id',$this->propinsi_id);
		$criteria->compare('pangkat_id',$this->pangkat_id);
		$criteria->compare('kabupaten_id',$this->kabupaten_id);
		$criteria->compare('LOWER(nomorindukpegawai)',strtolower($this->nomorindukpegawai),true);
		$criteria->compare('LOWER(no_kartupegawainegerisipil)',strtolower($this->no_kartupegawainegerisipil),true);
		$criteria->compare('LOWER(no_karis_karsu)',strtolower($this->no_karis_karsu),true);
		$criteria->compare('LOWER(gelarbelakang_nama)',strtolower($this->gelarbelakang_nama),true);
		$criteria->compare('LOWER(no_taspen)',strtolower($this->no_taspen),true);
		$criteria->compare('LOWER(no_askes)',strtolower($this->no_askes),true);
		$criteria->compare('LOWER(gelardepan)',strtolower($this->gelardepan),true);
		$criteria->compare('LOWER(nama_pegawai)',strtolower($this->nama_pegawai),true);
		$criteria->compare('LOWER(nama_keluarga)',strtolower($this->nama_keluarga),true);
		$criteria->compare('LOWER(tempatlahir_pegawai)',strtolower($this->tempatlahir_pegawai),true);
		$criteria->compare('LOWER(tgl_lahirpegawai)',strtolower($this->tgl_lahirpegawai),true);
		$criteria->compare('LOWER(jeniskelamin)',strtolower($this->jeniskelamin),true);
		$criteria->compare('LOWER(statusperkawinan)',strtolower($this->statusperkawinan),true);
		$criteria->compare('LOWER(alamat_pegawai)',strtolower($this->alamat_pegawai),true);
		$criteria->compare('LOWER(agama)',strtolower($this->agama),true);
		$criteria->compare('LOWER(golongandarah)',strtolower($this->golongandarah),true);
		$criteria->compare('LOWER(rhesus)',strtolower($this->rhesus),true);
		$criteria->compare('LOWER(alamatemail)',strtolower($this->alamatemail),true);
		$criteria->compare('LOWER(notelp_pegawai)',strtolower($this->notelp_pegawai),true);
		$criteria->compare('LOWER(nomobile_pegawai)',strtolower($this->nomobile_pegawai),true);
		$criteria->compare('LOWER(warganegara_pegawai)',strtolower($this->warganegara_pegawai),true);
		$criteria->compare('LOWER(jeniswaktukerja)',strtolower($this->jeniswaktukerja),true);
		$criteria->compare('LOWER(kelompokjabatan)',strtolower($this->kelompokjabatan),true);
		$criteria->compare('LOWER(kategoripegawai)',strtolower($this->kategoripegawai),true);
		$criteria->compare('LOWER(kategoripegawaiasal)',strtolower($this->kategoripegawaiasal),true);
		$criteria->compare('LOWER(photopegawai)',strtolower($this->photopegawai),true);
		$criteria->compare('pegawai_aktif',isset($this->pegawai_aktif)?$this->pegawai_aktif:true);
		$criteria->compare('esselon_id',$this->esselon_id);
		$criteria->compare('statuskepemilikanrumah_id',$this->statuskepemilikanrumah_id);
		$criteria->compare('LOWER(jenisidentitas)',strtolower($this->jenisidentitas),true);
		$criteria->compare('LOWER(noidentitas)',strtolower($this->noidentitas),true);
		$criteria->compare('LOWER(nofingerprint)',strtolower($this->nofingerprint),true);
		$criteria->compare('tinggibadan',$this->tinggibadan);
		$criteria->compare('beratbadan',$this->beratbadan);
		$criteria->compare('unit_perusahaan',$this->unit_perusahaan);
		$criteria->compare('suratizinpraktek',$this->suratizinpraktek);
		$criteria->compare('LOWER(kemampuanbahasa)',strtolower($this->kemampuanbahasa),true);
		$criteria->compare('LOWER(warnakulit)',strtolower($this->warnakulit),true);
		$criteria->compare('LOWER(deskripsi)',strtolower($this->deskripsi),true);
                $criteria->order = 'pegawai_id ASC';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                  		));
	}
        
	public function searchByDokter()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		$criteria->compare('gelarbelakang_id',$this->gelarbelakang_id);
		$criteria->compare('kelompokpegawai_id', 1);
		$criteria->compare('pendkualifikasi_id',$this->pendkualifikasi_id);
		$criteria->compare('jabatan_id',$this->jabatan_id);
		$criteria->compare('pendidikan_id',$this->pendidikan_id);
		$criteria->compare('propinsi_id',$this->propinsi_id);
		$criteria->compare('pangkat_id',$this->pangkat_id);
		$criteria->compare('kabupaten_id',$this->kabupaten_id);
		$criteria->compare('LOWER(nomorindukpegawai)',strtolower($this->nomorindukpegawai),true);
		$criteria->compare('LOWER(no_kartupegawainegerisipil)',strtolower($this->no_kartupegawainegerisipil),true);
		$criteria->compare('LOWER(no_karis_karsu)',strtolower($this->no_karis_karsu),true);
		$criteria->compare('LOWER(no_taspen)',strtolower($this->no_taspen),true);
		$criteria->compare('LOWER(no_askes)',strtolower($this->no_askes),true);
		$criteria->compare('LOWER(gelardepan)',strtolower($this->gelardepan),true);
		$criteria->compare('LOWER(nama_pegawai)',strtolower($this->nama_pegawai),true);
		$criteria->compare('LOWER(nama_keluarga)',strtolower($this->nama_keluarga),true);
		$criteria->compare('LOWER(tempatlahir_pegawai)',strtolower($this->tempatlahir_pegawai),true);
		$criteria->compare('LOWER(tgl_lahirpegawai)',strtolower($this->tgl_lahirpegawai),true);
		$criteria->compare('LOWER(jeniskelamin)',strtolower($this->jeniskelamin),true);
		$criteria->compare('LOWER(statusperkawinan)',strtolower($this->statusperkawinan),true);
		$criteria->compare('LOWER(alamat_pegawai)',strtolower($this->alamat_pegawai),true);
		$criteria->compare('LOWER(agama)',strtolower($this->agama),true);
		$criteria->compare('LOWER(golongandarah)',strtolower($this->golongandarah),true);
		$criteria->compare('LOWER(rhesus)',strtolower($this->rhesus),true);
		$criteria->compare('LOWER(alamatemail)',strtolower($this->alamatemail),true);
		$criteria->compare('LOWER(notelp_pegawai)',strtolower($this->notelp_pegawai),true);
		$criteria->compare('LOWER(nomobile_pegawai)',strtolower($this->nomobile_pegawai),true);
		$criteria->compare('LOWER(warganegara_pegawai)',strtolower($this->warganegara_pegawai),true);
		$criteria->compare('LOWER(jeniswaktukerja)',strtolower($this->jeniswaktukerja),true);
		$criteria->compare('LOWER(kelompokjabatan)',strtolower($this->kelompokjabatan),true);
		$criteria->compare('LOWER(kategoripegawai)',strtolower($this->kategoripegawai),true);
		$criteria->compare('LOWER(kategoripegawaiasal)',strtolower($this->kategoripegawaiasal),true);
		$criteria->compare('LOWER(photopegawai)',strtolower($this->photopegawai),true);
		$criteria->compare('pegawai_aktif',isset($this->pegawai_aktif)?$this->pegawai_aktif:true);
		$criteria->compare('esselon_id',$this->esselon_id);
		$criteria->compare('statuskepemilikanrumah_id',$this->statuskepemilikanrumah_id);
		$criteria->compare('LOWER(jenisidentitas)',strtolower($this->jenisidentitas),true);
		$criteria->compare('LOWER(noidentitas)',strtolower($this->noidentitas),true);
		$criteria->compare('LOWER(nofingerprint)',strtolower($this->nofingerprint),true);
		$criteria->compare('tinggibadan',$this->tinggibadan);
		$criteria->compare('beratbadan',$this->beratbadan);
		$criteria->compare('unit_perusahaan',$this->unit_perusahaan);
		$criteria->compare('suratizinpraktek',$this->suratizinpraktek);
		$criteria->compare('LOWER(kemampuanbahasa)',strtolower($this->kemampuanbahasa),true);
		$criteria->compare('LOWER(warnakulit)',strtolower($this->warnakulit),true);
		$criteria->compare('LOWER(deskripsi)',strtolower($this->deskripsi),true);
                $criteria->order = 'pegawai_id ASC';
		$criteria->limit = 10;
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			//'pagination'=>false,
		));
	}        
        
	public function searchByNofinger()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('kelurahan_id',$this->kelurahan_id);
		$criteria->compare('kecamatan_id',$this->kecamatan_id);
		$criteria->compare('profilrs_id',$this->profilrs_id);
		$criteria->compare('gelarbelakang_id',$this->gelarbelakang_id);
		$criteria->compare('suku_id',$this->suku_id);
		$criteria->compare('kelompokpegawai_id',$this->kelompokpegawai_id);
		$criteria->compare('pendkualifikasi_id',$this->pendkualifikasi_id);
		$criteria->compare('jabatan_id',$this->jabatan_id);
		$criteria->compare('pendidikan_id',$this->pendidikan_id);
		$criteria->compare('propinsi_id',$this->propinsi_id);
		$criteria->compare('pangkat_id',$this->pangkat_id);
		$criteria->compare('kabupaten_id',$this->kabupaten_id);
		$criteria->compare('LOWER(nomorindukpegawai)',strtolower($this->nomorindukpegawai),true);
		$criteria->compare('LOWER(no_kartupegawainegerisipil)',strtolower($this->no_kartupegawainegerisipil),true);
		$criteria->compare('LOWER(no_karis_karsu)',strtolower($this->no_karis_karsu),true);
		$criteria->compare('LOWER(no_taspen)',strtolower($this->no_taspen),true);
		$criteria->compare('LOWER(no_askes)',strtolower($this->no_askes),true);
		$criteria->compare('LOWER(gelardepan)',strtolower($this->gelardepan),true);
		$criteria->compare('LOWER(nama_pegawai)',strtolower($this->nama_pegawai),true);
		$criteria->compare('LOWER(nama_keluarga)',strtolower($this->nama_keluarga),true);
		$criteria->compare('LOWER(tempatlahir_pegawai)',strtolower($this->tempatlahir_pegawai),true);
		$criteria->compare('LOWER(tgl_lahirpegawai)',strtolower($this->tgl_lahirpegawai),true);
		$criteria->compare('LOWER(jeniskelamin)',strtolower($this->jeniskelamin),true);
		$criteria->compare('LOWER(statusperkawinan)',strtolower($this->statusperkawinan),true);
		$criteria->compare('LOWER(alamat_pegawai)',strtolower($this->alamat_pegawai),true);
		$criteria->compare('LOWER(agama)',strtolower($this->agama),true);
		$criteria->compare('LOWER(golongandarah)',strtolower($this->golongandarah),true);
		$criteria->compare('LOWER(rhesus)',strtolower($this->rhesus),true);
		$criteria->compare('LOWER(alamatemail)',strtolower($this->alamatemail),true);
		$criteria->compare('LOWER(notelp_pegawai)',strtolower($this->notelp_pegawai),true);
		$criteria->compare('LOWER(nomobile_pegawai)',strtolower($this->nomobile_pegawai),true);
		$criteria->compare('LOWER(warganegara_pegawai)',strtolower($this->warganegara_pegawai),true);
		$criteria->compare('LOWER(jeniswaktukerja)',strtolower($this->jeniswaktukerja),true);
		$criteria->compare('LOWER(kelompokjabatan)',strtolower($this->kelompokjabatan),true);
		$criteria->compare('LOWER(kategoripegawai)',strtolower($this->kategoripegawai),true);
		$criteria->compare('LOWER(kategoripegawaiasal)',strtolower($this->kategoripegawaiasal),true);
		$criteria->compare('LOWER(photopegawai)',strtolower($this->photopegawai),true);
		$criteria->compare('pegawai_aktif',isset($this->pegawai_aktif)?$this->pegawai_aktif:true);
		$criteria->compare('esselon_id',$this->esselon_id);
		$criteria->compare('statuskepemilikanrumah_id',$this->statuskepemilikanrumah_id);
		$criteria->compare('LOWER(jenisidentitas)',strtolower($this->jenisidentitas),true);
		$criteria->compare('LOWER(noidentitas)',strtolower($this->noidentitas),true);
		$criteria->compare('LOWER(nofingerprint)',strtolower($this->nofingerprint),true);
		$criteria->compare('tinggibadan',$this->tinggibadan);
		$criteria->compare('beratbadan',$this->beratbadan);
		$criteria->compare('unit_perusahaan',$this->unit_perusahaan);
		$criteria->compare('suratizinpraktek',$this->suratizinpraktek);
		$criteria->compare('LOWER(kemampuanbahasa)',strtolower($this->kemampuanbahasa),true);
		$criteria->compare('LOWER(warnakulit)',strtolower($this->warnakulit),true);
		$criteria->compare('LOWER(deskripsi)',strtolower($this->deskripsi),true);
                $criteria->addCondition("nofingerprint IS NOT NULL");
                $criteria->order = 'pegawai_id ASC';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}        
        
        public function searchNoMobile()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

                $criteria->addCondition('TRIM(nomobile_pegawai) != \'\'');
		$criteria->compare('LOWER(nomobile_pegawai)',strtolower($this->nomobile_pegawai),true);
		$criteria->compare('LOWER(nama_pegawai)',strtolower($this->nama_pegawai),true);
		$criteria->compare('LOWER(nomorindukpegawai)',strtolower($this->nomorindukpegawai),true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('kelurahan_id',$this->kelurahan_id);
		$criteria->compare('kecamatan_id',$this->kecamatan_id);
		$criteria->compare('profilrs_id',$this->profilrs_id);
		$criteria->compare('gelarbelakang_id',$this->gelarbelakang_id);
		$criteria->compare('suku_id',$this->suku_id);
		$criteria->compare('kelompokpegawai_id',$this->kelompokpegawai_id);
		$criteria->compare('pendkualifikasi_id',$this->pendkualifikasi_id);
		$criteria->compare('jabatan_id',$this->jabatan_id);
		$criteria->compare('pendidikan_id',$this->pendidikan_id);
		$criteria->compare('propinsi_id',$this->propinsi_id);
		$criteria->compare('pangkat_id',$this->pangkat_id);
		$criteria->compare('kabupaten_id',$this->kabupaten_id);
		$criteria->compare('LOWER(nomorindukpegawai)',strtolower($this->nomorindukpegawai),true);
		$criteria->compare('LOWER(no_kartupegawainegerisipil)',strtolower($this->no_kartupegawainegerisipil),true);
		$criteria->compare('LOWER(no_karis_karsu)',strtolower($this->no_karis_karsu),true);
		$criteria->compare('LOWER(no_taspen)',strtolower($this->no_taspen),true);
		$criteria->compare('LOWER(no_askes)',strtolower($this->no_askes),true);
		$criteria->compare('LOWER(gelardepan)',strtolower($this->gelardepan),true);
		$criteria->compare('LOWER(nama_pegawai)',strtolower($this->nama_pegawai),true);
		$criteria->compare('LOWER(nama_keluarga)',strtolower($this->nama_keluarga),true);
		$criteria->compare('LOWER(tempatlahir_pegawai)',strtolower($this->tempatlahir_pegawai),true);
		$criteria->compare('LOWER(tgl_lahirpegawai)',strtolower($this->tgl_lahirpegawai),true);
		$criteria->compare('LOWER(jeniskelamin)',strtolower($this->jeniskelamin),true);
		$criteria->compare('LOWER(statusperkawinan)',strtolower($this->statusperkawinan),true);
		$criteria->compare('LOWER(alamat_pegawai)',strtolower($this->alamat_pegawai),true);
		$criteria->compare('LOWER(agama)',strtolower($this->agama),true);
		$criteria->compare('LOWER(golongandarah)',strtolower($this->golongandarah),true);
		$criteria->compare('LOWER(rhesus)',strtolower($this->rhesus),true);
		$criteria->compare('LOWER(alamatemail)',strtolower($this->alamatemail),true);
		$criteria->compare('LOWER(notelp_pegawai)',strtolower($this->notelp_pegawai),true);
		$criteria->compare('LOWER(nomobile_pegawai)',strtolower($this->nomobile_pegawai),true);
		$criteria->compare('LOWER(warganegara_pegawai)',strtolower($this->warganegara_pegawai),true);
		$criteria->compare('LOWER(jeniswaktukerja)',strtolower($this->jeniswaktukerja),true);
		$criteria->compare('LOWER(kelompokjabatan)',strtolower($this->kelompokjabatan),true);
		$criteria->compare('LOWER(kategoripegawai)',strtolower($this->kategoripegawai),true);
		$criteria->compare('LOWER(kategoripegawaiasal)',strtolower($this->kategoripegawaiasal),true);
		$criteria->compare('LOWER(photopegawai)',strtolower($this->photopegawai),true);
		$criteria->compare('pegawai_aktif',isset($this->pegawai_aktif)?$this->pegawai_aktif:true);
		$criteria->compare('esselon_id',$this->esselon_id);
		$criteria->compare('statuskepemilikanrumah_id',$this->statuskepemilikanrumah_id);
		$criteria->compare('LOWER(jenisidentitas)',strtolower($this->jenisidentitas),true);
		$criteria->compare('LOWER(noidentitas)',strtolower($this->noidentitas),true);
		$criteria->compare('LOWER(nofingerprint)',strtolower($this->nofingerprint),true);
		$criteria->compare('tinggibadan',$this->tinggibadan);
		$criteria->compare('unit_perusahaan',$this->unit_perusahaan);
		$criteria->compare('suratizinpraktek',$this->suratizinpraktek);
		$criteria->compare('beratbadan',$this->beratbadan);
		$criteria->compare('LOWER(kemampuanbahasa)',strtolower($this->kemampuanbahasa),true);
		$criteria->compare('LOWER(warnakulit)',strtolower($this->warnakulit),true);
		$criteria->compare('LOWER(deskripsi)',strtolower($this->deskripsi),true);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
        
   

    public function getProfilRSItems()
    {
        return ProfilrumahsakitM::model()->findAll(array('order'=>'nama_rumahsakit'));
    }     

    public function getGelarBelakangItems()
    {
        return GelarbelakangM::model()->findAll('gelarbelakang_aktif=TRUE order by gelarbelakang_nama');
    } 

    public function getSukuItems()
    {
        return SukuM::model()->findAll('suku_aktif=TRUE order by suku_nama');
    }  

    public function getkelompokPegawaiItems()
    {
        return KelompokpegawaiM::model()->findAll('kelompokpegawai_aktif=TRUE order by kelompokpegawai_nama');
    }  

    public function getPendidikanKualifikasiItems()
    {
        return PendidikankualifikasiM::model()->findAll('pendkualifikasi_aktif=TRUE order by pendkualifikasi_nama');
    }  

    public function getJabatanItems()
    {
        return JabatanM::model()->findAll('jabatan_aktif=TRUE order by jabatan_nama');
    } 

    public function getPendidikanItems()
    {
        return PendidikanM::model()->findAll('pendidikan_aktif=TRUE order by pendidikan_nama');
    }
    
     public function getPangkatItems()
    {
        return PangkatM::model()->findAll('pangkat_aktif=TRUE order by pangkat_nama');
    } 

    public function getPropinsiItems()
    {
        return PropinsiM::model()->findAll('propinsi_aktif=TRUE order by propinsi_nama');
    }

    public function getKabupatenItems()
    {
        if(!empty($this->propinsi_id))
          {     
            return KabupatenM::model()->findAll('propinsi_id='.$this->propinsi_id.' order BY kabupaten_nama');
          }
        else  
          {
            return array();
          }  
    } 
    
    public function getItemsByInstalasi()
    {
        if(!empty($this->propinsi_id))
          {     
            return KabupatenM::model()->findAll('propinsi_id='.$this->propinsi_id.' order BY kabupaten_nama');
          }
        else  
          {
            return array();
          }  
    } 
    
     public function getKecamatanItems()
    {
       return KecamatanM::model()->findAll();
            
        
    }
    
     public function getKelurahanItems()
    {
       return KelurahanM::model()->findAll();
    }
    
    public function getLoginpemakaiItems()
    {
        return PegawaiM::model()->findAll();
    }
    
    public function getNamaLengkap()
    {
        return (isset($this->gelardepan) ? $this->gelardepan : "").' '.$this->nama_pegawai.(isset($this->gelarbelakang_id) ? ', '.$this->gelarbelakang->gelarbelakang_nama : "");
    }
    
    public function getNamaGelar()
    {
        return (isset($this->gelarbelakang->gelarbelakang_nama)? $this->gelarbelakang->gelarbelakang_nama : "");
    }
    
    public function getNamaDepanGelar()
    {
       // return $this->gelarbelakang->gelarbelakang_nama;
        return $this->gelardepan;
    }
    
    public function getNamaKelompok()
    {
        return $this->kelompokpegawai->kelompokpegawai_nama;
        
    }
    
    public function getEsselonItems()
    {
        return EsselonM::model()->findAll('esselon_aktif=TRUE ORDER BY esselon_nama');
    }
           
    public function getStatuskepemilikanrumahItems()
    {
        return StatuskepemilikanrumahM::model()->findAll('statuskepemilikanrumah_aktif=TRUE ORDER BY statuskepemilikanrumah_nama');
    }
    
    public function getGolonganPegawaiItems()
    {
        return GolonganpegawaiM::model()->findAll('golonganpegawai_aktif=TRUE ORDER BY golonganpegawai_nama');
    }
   
/*
    protected function beforeValidate ()
    {
    $format = new MyFormatter();
    foreach($this->metadata->tableSchema->columns as $columnName => $column){
        if ($column->dbType == 'date'){
                $this->$columnName = Yii::app()->dateFormatter->formatDateTime(
                                CDateTimeParser::parse($this->$columnName, 'yyyy-MM-dd'),'medium',null);
        }elseif ($column->dbType == 'datetime'){
                $this->$columnName = date('Y-m-d H:i:s', CDateTimeParser::parse($this->$columnName, Yii::app()->locale->dateFormat));
        }

    }

    return parent::beforeValidate ();
    }

    public function beforeSave() 
    {
        if($this->tgl_lahirpegawai===null || trim($this->tgl_lahirpegawai)=='')
            {
                $this->setAttribute('tgl_lahirpegawai', null);
            } 
        if($this->tglditerima===null || trim($this->tglditerima)=='')
            {
                $this->setAttribute('tglditerima', null);
            } 
        if($this->tglberhenti===null || trim($this->tglberhenti)=='')
            {
                $this->setAttribute('tglberhenti', null);
            }
        return parent::beforeSave();
    }

    protected function afterFind()
    {
        foreach($this->metadata->tableSchema->columns as $columnName => $column)
            {

                if (!strlen($this->$columnName)) continue;

                if ($column->dbType == 'date')
                    {                         
                        $this->$columnName = Yii::app()->dateFormatter->formatDateTime(
                                        CDateTimeParser::parse($this->$columnName, 'yyyy-MM-dd'),'medium',null);
                    }
                elseif ($column->dbType == 'datetime')
                    {
                        $this->$columnName = Yii::app()->dateFormatter->formatDateTime(
                                        CDateTimeParser::parse($this->$columnName, 'yyyy-MM-dd hh:mm:ss'));
                    }
             }
        return true;
    }
 * 
 */
}