<?php

/**
 * This is the model class for table "laporankunjunganrd_v".
 *
 * The followings are the available columns in table 'laporankunjunganrd_v':
 * @property integer $pasien_id
 * @property string $jenisidentitas
 * @property string $no_identitas_pasien
 * @property string $namadepan
 * @property string $nama_pasien
 * @property string $nama_bin
 * @property string $jeniskelamin
 * @property string $tempat_lahir
 * @property string $tanggal_lahir
 * @property string $alamat_pasien
 * @property integer $rt
 * @property integer $rw
 * @property string $agama
 * @property string $golongandarah
 * @property string $photopasien
 * @property string $alamatemail
 * @property string $statusrekammedis
 * @property string $statusperkawinan
 * @property string $no_rekam_medik
 * @property string $tgl_rekam_medik
 * @property integer $pendaftaran_id
 * @property string $no_pendaftaran
 * @property string $tgl_pendaftaran
 * @property string $no_urutantri
 * @property string $transportasi
 * @property string $keadaanmasuk
 * @property string $statusperiksa
 * @property string $statuspasien
 * @property string $kunjungan
 * @property boolean $alihstatus
 * @property boolean $byphone
 * @property boolean $kunjunganrumah
 * @property string $statusmasuk
 * @property string $umur
 * @property string $no_asuransi
 * @property string $namapemilik_asuransi
 * @property string $nopokokperusahaan
 * @property string $create_time
 * @property string $create_loginpemakai_id
 * @property string $create_ruangan
 * @property integer $shift_id
 * @property integer $ruangan_id
 * @property string $ruangan_nama
 * @property integer $instalasi_id
 * @property string $instalasi_nama
 * @property integer $jeniskasuspenyakit_id
 * @property string $jeniskasuspenyakit_nama
 * @property integer $kelaspelayanan_id
 * @property string $kelaspelayanan_nama
 * @property integer $rujukan_id
 * @property integer $pasienpulang_id
 * @property integer $profilrd_id
 */
class LaporankunjunganrdV extends CActiveRecord
{
        public $jumlah;
        public $data;
        public $tick;
        public $pilihanx;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return LaporankunjunganrdV the static model class
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
		return 'laporankunjunganrd_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pasien_id, rt, rw, pendaftaran_id, shift_id, ruangan_id, instalasi_id, jeniskasuspenyakit_id, kelaspelayanan_id, rujukan_id, pasienpulang_id, profilrd_id', 'numerical', 'integerOnly'=>true),
			array('jenisidentitas, namadepan, jeniskelamin, agama, statusperkawinan, no_pendaftaran', 'length', 'max'=>20),
			array('no_identitas_pasien, nama_bin, umur', 'length', 'max'=>30),
			array('nama_pasien, transportasi, keadaanmasuk, statusperiksa, statuspasien, kunjungan, statusmasuk, no_asuransi, namapemilik_asuransi, nopokokperusahaan, ruangan_nama, instalasi_nama, kelaspelayanan_nama', 'length', 'max'=>50),
			array('tempat_lahir', 'length', 'max'=>25),
			array('golongandarah', 'length', 'max'=>2),
			array('photopasien', 'length', 'max'=>200),
			array('alamatemail, jeniskasuspenyakit_nama', 'length', 'max'=>100),
			array('statusrekammedis, no_rekam_medik', 'length', 'max'=>10),
			array('no_urutantri', 'length', 'max'=>6),
			array('tanggal_lahir, alamat_pasien, tgl_rekam_medik, tgl_pendaftaran, alihstatus, byphone, kunjunganrumah, create_time, create_loginpemakai_id, create_ruangan', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pilihanx, tgl_awal, tgl_akhir, pasien_id, jenisidentitas, no_identitas_pasien, namadepan, nama_pasien, nama_bin, jeniskelamin, tempat_lahir, tanggal_lahir, alamat_pasien, rt, rw, agama, golongandarah, photopasien, alamatemail, statusrekammedis, statusperkawinan, no_rekam_medik, tgl_rekam_medik, pendaftaran_id, no_pendaftaran, tgl_pendaftaran, no_urutantri, transportasi, keadaanmasuk, statusperiksa, statuspasien, kunjungan, alihstatus, byphone, kunjunganrumah, statusmasuk, umur, no_asuransi, namapemilik_asuransi, nopokokperusahaan, create_time, create_loginpemakai_id, create_ruangan, shift_id, ruangan_id, ruangan_nama, instalasi_id, instalasi_nama, jeniskasuspenyakit_id, jeniskasuspenyakit_nama, kelaspelayanan_id, kelaspelayanan_nama, rujukan_id, pasienpulang_id, profilrd_id', 'safe', 'on'=>'search'),
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
			'pasien_id' => 'Pasien',
			'jenisidentitas' => 'Jenis Identitas',
			'no_identitas_pasien' => 'No. Identitas Pasien',
			'namadepan' => 'Nama Depan',
			'nama_pasien' => 'Nama Pasien',
			'nama_bin' => 'Nama Bin',
			'jeniskelamin' => 'Jenis Kelamin',
			'tempat_lahir' => 'Tempat Lahir',
			'tanggal_lahir' => 'Tanggal Lahir',
			'alamat_pasien' => 'Alamat Pasien',
			'rt' => 'RT',
			'rw' => 'RW',
			'agama' => 'Agama',
			'golongandarah' => 'Golongan Darah',
			'photopasien' => 'Photo Pasien',
			'alamatemail' => 'Alamat Email',
			'statusrekammedis' => 'Status Rekam Medis',
			'statusperkawinan' => 'Status Perkawinan',
			'no_rekam_medik' => 'No. Rekam Medik',
			'tgl_rekam_medik' => 'Tanggal Rekam Medik',
			'pendaftaran_id' => 'Pendaftaran',
			'no_pendaftaran' => 'No. Pendaftaran',
			'tgl_pendaftaran' => 'Tanggal Pendaftaran',
			'no_urutantri' => 'No. Urut Antri',
			'transportasi' => 'Transportasi',
			'keadaanmasuk' => 'Keadaan Masuk',
			'statusperiksa' => 'Status Periksa',
			'statuspasien' => 'Status Pasien',
			'kunjungan' => 'Kunjungan',
			'alihstatus' => 'Alih Status',
			'byphone' => 'By Phone',
			'kunjunganrumah' => 'Kunjungan Rumah',
			'statusmasuk' => 'Status Masuk',
			'umur' => 'Umur',
			'no_asuransi' => 'No. Asuransi',
			'namapemilik_asuransi' => 'Nama Pemilik Asuransi',
			'nopokokperusahaan' => 'No. Pokok Perusahaan',
			'create_time' => 'Create Time',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
			'shift_id' => 'Shift',
			'ruangan_id' => 'Ruangan',
			'ruangan_nama' => 'Ruangan Nama',
			'instalasi_id' => 'Instalasi',
			'instalasi_nama' => 'Instalasi Nama',
			'jeniskasuspenyakit_id' => 'Jenis Kasus Penyakit',
			'jeniskasuspenyakit_nama' => 'Jenis Kasus Penyakit Nama',
			'kelaspelayanan_id' => 'Kelas Pelayanan',
			'kelaspelayanan_nama' => 'Kelas Pelayanan Nama',
			'rujukan_id' => 'Rujukan',
			'pasienpulang_id' => 'Pasien Pulang',
			'profilrd_id' => 'Profil rd',
			'NamaNamaBIN'=>'Nama Pasien',
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

		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('LOWER(jenisidentitas)',strtolower($this->jenisidentitas),true);
		$criteria->compare('LOWER(no_identitas_pasien)',strtolower($this->no_identitas_pasien),true);
		$criteria->compare('LOWER(namadepan)',strtolower($this->namadepan),true);
		$criteria->compare('LOWER(nama_pasien)',strtolower($this->nama_pasien),true);
		$criteria->compare('LOWER(nama_bin)',strtolower($this->nama_bin),true);
		$criteria->compare('LOWER(jeniskelamin)',strtolower($this->jeniskelamin),true);
		$criteria->compare('LOWER(tempat_lahir)',strtolower($this->tempat_lahir),true);
		$criteria->compare('LOWER(tanggal_lahir)',strtolower($this->tanggal_lahir),true);
		$criteria->compare('LOWER(alamat_pasien)',strtolower($this->alamat_pasien),true);
		$criteria->compare('rt',$this->rt);
		$criteria->compare('rw',$this->rw);
		$criteria->compare('LOWER(agama)',strtolower($this->agama),true);
		$criteria->compare('LOWER(golongandarah)',strtolower($this->golongandarah),true);
		$criteria->compare('LOWER(photopasien)',strtolower($this->photopasien),true);
		$criteria->compare('LOWER(alamatemail)',strtolower($this->alamatemail),true);
		$criteria->compare('LOWER(statusrekammedis)',strtolower($this->statusrekammedis),true);
		$criteria->compare('LOWER(statusperkawinan)',strtolower($this->statusperkawinan),true);
		$criteria->compare('LOWER(no_rekam_medik)',strtolower($this->no_rekam_medik),true);
		$criteria->compare('LOWER(tgl_rekam_medik)',strtolower($this->tgl_rekam_medik),true);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('LOWER(no_pendaftaran)',strtolower($this->no_pendaftaran),true);
		$criteria->compare('LOWER(tgl_pendaftaran)',strtolower($this->tgl_pendaftaran),true);
		$criteria->compare('LOWER(no_urutantri)',strtolower($this->no_urutantri),true);
		$criteria->compare('LOWER(transportasi)',strtolower($this->transportasi),true);
		$criteria->compare('LOWER(keadaanmasuk)',strtolower($this->keadaanmasuk),true);
		$criteria->compare('LOWER(statusperiksa)',strtolower($this->statusperiksa),true);
		$criteria->compare('LOWER(statuspasien)',strtolower($this->statuspasien),true);
		$criteria->compare('LOWER(kunjungan)',strtolower($this->kunjungan),true);
		$criteria->compare('alihstatus',$this->alihstatus);
		$criteria->compare('byphone',$this->byphone);
		$criteria->compare('kunjunganrumah',$this->kunjunganrumah);
		$criteria->compare('LOWER(statusmasuk)',strtolower($this->statusmasuk),true);
		$criteria->compare('LOWER(umur)',strtolower($this->umur),true);
		$criteria->compare('LOWER(no_asuransi)',strtolower($this->no_asuransi),true);
		$criteria->compare('LOWER(namapemilik_asuransi)',strtolower($this->namapemilik_asuransi),true);
		$criteria->compare('LOWER(nopokokperusahaan)',strtolower($this->nopokokperusahaan),true);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);
		$criteria->compare('shift_id',$this->shift_id);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('LOWER(ruangan_nama)',strtolower($this->ruangan_nama),true);
		$criteria->compare('instalasi_id',$this->instalasi_id);
		$criteria->compare('LOWER(instalasi_nama)',strtolower($this->instalasi_nama),true);
		$criteria->compare('jeniskasuspenyakit_id',$this->jeniskasuspenyakit_id);
		$criteria->compare('LOWER(jeniskasuspenyakit_nama)',strtolower($this->jeniskasuspenyakit_nama),true);
		$criteria->compare('kelaspelayanan_id',$this->kelaspelayanan_id);
		$criteria->compare('LOWER(kelaspelayanan_nama)',strtolower($this->kelaspelayanan_nama),true);
		$criteria->compare('rujukan_id',$this->rujukan_id);
		$criteria->compare('pasienpulang_id',$this->pasienpulang_id);
		$criteria->compare('profilrd_id',$this->profilrd_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

        $criteria=new CDbCriteria;
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->addBetweenCondition('tgl_pendaftaran', $this->tgl_awal, $this->tgl_akhir);
		$criteria->compare('LOWER(jenisidentitas)',strtolower($this->jenisidentitas),true);
		$criteria->compare('LOWER(no_identitas_pasien)',strtolower($this->no_identitas_pasien),true);
		$criteria->compare('LOWER(namadepan)',strtolower($this->namadepan),true);
		$criteria->compare('LOWER(nama_pasien)',strtolower($this->nama_pasien),true);
		$criteria->compare('LOWER(nama_bin)',strtolower($this->nama_bin),true);
		$criteria->compare('LOWER(jeniskelamin)',strtolower($this->jeniskelamin),true);
		$criteria->compare('LOWER(tempat_lahir)',strtolower($this->tempat_lahir),true);
		$criteria->compare('LOWER(tanggal_lahir)',strtolower($this->tanggal_lahir),true);
		$criteria->compare('LOWER(alamat_pasien)',strtolower($this->alamat_pasien),true);
		$criteria->compare('rt',$this->rt);
		$criteria->compare('rw',$this->rw);
		$criteria->compare('LOWER(agama)',strtolower($this->agama),true);
		$criteria->compare('LOWER(golongandarah)',strtolower($this->golongandarah),true);
		$criteria->compare('LOWER(photopasien)',strtolower($this->photopasien),true);
		$criteria->compare('LOWER(alamatemail)',strtolower($this->alamatemail),true);
		$criteria->compare('LOWER(statusrekammedis)',strtolower($this->statusrekammedis),true);
		$criteria->compare('LOWER(statusperkawinan)',strtolower($this->statusperkawinan),true);
		$criteria->compare('LOWER(no_rekam_medik)',strtolower($this->no_rekam_medik),true);
		$criteria->compare('LOWER(tgl_rekam_medik)',strtolower($this->tgl_rekam_medik),true);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('LOWER(no_pendaftaran)',strtolower($this->no_pendaftaran),true);
		$criteria->compare('LOWER(no_urutantri)',strtolower($this->no_urutantri),true);
		$criteria->compare('LOWER(transportasi)',strtolower($this->transportasi),true);
		$criteria->compare('LOWER(keadaanmasuk)',strtolower($this->keadaanmasuk),true);
		$criteria->compare('LOWER(statusperiksa)',strtolower($this->statusperiksa),true);
		$criteria->compare('LOWER(statuspasien)',strtolower($this->statuspasien),true);
		$criteria->compare('LOWER(kunjungan)',strtolower($this->kunjungan),true);
		$criteria->compare('alihstatus',$this->alihstatus);
		$criteria->compare('byphone',$this->byphone);
		$criteria->compare('kunjunganrumah',$this->kunjunganrumah);
		$criteria->compare('LOWER(statusmasuk)',strtolower($this->statusmasuk),true);
		$criteria->compare('LOWER(umur)',strtolower($this->umur),true);
		$criteria->compare('LOWER(no_asuransi)',strtolower($this->no_asuransi),true);
		$criteria->compare('LOWER(namapemilik_asuransi)',strtolower($this->namapemilik_asuransi),true);
		$criteria->compare('LOWER(nopokokperusahaan)',strtolower($this->nopokokperusahaan),true);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);
		$criteria->compare('shift_id',$this->shift_id);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('LOWER(ruangan_nama)',strtolower($this->ruangan_nama),true);
		$criteria->compare('instalasi_id',$this->instalasi_id);
		$criteria->compare('LOWER(instalasi_nama)',strtolower($this->instalasi_nama),true);
		$criteria->compare('jeniskasuspenyakit_id',$this->jeniskasuspenyakit_id);
		$criteria->compare('LOWER(jeniskasuspenyakit_nama)',strtolower($this->jeniskasuspenyakit_nama),true);
		$criteria->compare('kelaspelayanan_id',$this->kelaspelayanan_id);
		$criteria->compare('LOWER(kelaspelayanan_nama)',strtolower($this->kelaspelayanan_nama),true);
		// $criteria->compare('rujukan_id',$this->rujukan_id);
		// $criteria->compare('pasienpulang_id',$this->pasienpulang_id);
		// $criteria->compare('profilrd_id',$this->profilrd_id);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
        $criteria->limit=-1; 

        return new CActiveDataProvider($this, array(
                'criteria'=>$criteria,
                'pagination'=>false,
        ));
        }

        public function searchTable() {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria = new CDbCriteria;

            $criteria->compare('pasien_id', $this->pasien_id);
            $criteria->addBetweenCondition('tgl_pendaftaran', $this->tgl_awal, $this->tgl_akhir);
            $criteria->compare('LOWER(jenisidentitas)', strtolower($this->jenisidentitas), true);
            $criteria->compare('LOWER(no_identitas_pasien)', strtolower($this->no_identitas_pasien), true);
            $criteria->compare('LOWER(namadepan)', strtolower($this->namadepan), true);
            $criteria->compare('LOWER(nama_pasien)', strtolower($this->nama_pasien), true);
            $criteria->compare('LOWER(nama_bin)', strtolower($this->nama_bin), true);
            $criteria->compare('LOWER(jeniskelamin)', strtolower($this->jeniskelamin), true);
            $criteria->compare('LOWER(tempat_lahir)', strtolower($this->tempat_lahir), true);
            $criteria->compare('LOWER(tanggal_lahir)', strtolower($this->tanggal_lahir), true);
            $criteria->compare('LOWER(alamat_pasien)', strtolower($this->alamat_pasien), true);
            $criteria->compare('rt', $this->rt);
            $criteria->compare('rw', $this->rw);
            $criteria->compare('LOWER(agama)', strtolower($this->agama), true);
            $criteria->compare('LOWER(golongandarah)', strtolower($this->golongandarah), true);
            $criteria->compare('LOWER(photopasien)', strtolower($this->photopasien), true);
            $criteria->compare('LOWER(alamatemail)', strtolower($this->alamatemail), true);
            $criteria->compare('LOWER(statusrekammedis)', strtolower($this->statusrekammedis), true);
            $criteria->compare('LOWER(statusperkawinan)', strtolower($this->statusperkawinan), true);
            $criteria->compare('LOWER(no_rekam_medik)', strtolower($this->no_rekam_medik), true);
            $criteria->compare('LOWER(tgl_rekam_medik)', strtolower($this->tgl_rekam_medik), true);
            $criteria->compare('propinsi_id', $this->propinsi_id);
            $criteria->compare('LOWER(propinsi_nama)', strtolower($this->propinsi_nama), true);
            $criteria->compare('kabupaten_id', $this->kabupaten_id);
            $criteria->compare('LOWER(kabupaten_nama)', strtolower($this->kabupaten_nama), true);
            $criteria->compare('kelurahan_id', $this->kelurahan_id);
            $criteria->compare('LOWER(kelurahan_nama)', strtolower($this->kelurahan_nama), true);
            $criteria->compare('kecamatan_id', $this->kecamatan_id);
            $criteria->compare('LOWER(kecamatan_nama)', strtolower($this->kecamatan_nama), true);
            $criteria->compare('pendaftaran_id', $this->pendaftaran_id);
            $criteria->compare('LOWER(no_pendaftaran)', strtolower($this->no_pendaftaran), true);
            $criteria->compare('LOWER(no_urutantri)', strtolower($this->no_urutantri), true);
            $criteria->compare('LOWER(transportasi)', strtolower($this->transportasi), true);
            $criteria->compare('LOWER(keadaanmasuk)', strtolower($this->keadaanmasuk), true);
            $criteria->compare('LOWER(statusperiksa)', strtolower($this->statusperiksa), true);
            $criteria->compare('LOWER(statuspasien)', strtolower($this->statuspasien), true);
            $criteria->compare('LOWER(kunjungan)', strtolower($this->kunjungan), true);
            $criteria->compare('alihstatus', $this->alihstatus);
            $criteria->compare('byphone', $this->byphone);
            $criteria->compare('kunjunganrumah', $this->kunjunganrumah);
            $criteria->compare('LOWER(statusmasuk)', strtolower($this->statusmasuk), true);
            $criteria->compare('LOWER(umur)', strtolower($this->umur), true);
            $criteria->compare('LOWER(no_asuransi)', strtolower($this->no_asuransi), true);
            $criteria->compare('LOWER(namapemilik_asuransi)', strtolower($this->namapemilik_asuransi), true);
            $criteria->compare('LOWER(nopokokperusahaan)', strtolower($this->nopokokperusahaan), true);
            $criteria->compare('LOWER(create_time)', strtolower($this->create_time), true);
            $criteria->compare('LOWER(create_loginpemakai_id)', strtolower($this->create_loginpemakai_id), true);
            $criteria->compare('LOWER(create_ruangan)', strtolower($this->create_ruangan), true);
            $criteria->compare('carabayar_id', $this->carabayar_id);
            $criteria->compare('LOWER(carabayar_nama)', strtolower($this->carabayar_nama), true);
            $criteria->compare('penjamin_id', $this->penjamin_id);
            $criteria->compare('LOWER(penjamin_nama)', strtolower($this->penjamin_nama), true);
            $criteria->compare('caramasuk_id', $this->caramasuk_id);
            $criteria->compare('LOWER(caramasuk_nama)', strtolower($this->caramasuk_nama), true);
            $criteria->compare('shift_id', $this->shift_id);
            $criteria->compare('LOWER(no_rujukan)', strtolower($this->no_rujukan), true);
            $criteria->compare('LOWER(nama_perujuk)', strtolower($this->nama_perujuk), true);
            $criteria->compare('LOWER(tanggal_rujukan)', strtolower($this->tanggal_rujukan), true);
            $criteria->compare('LOWER(diagnosa_rujukan)', strtolower($this->diagnosa_rujukan), true);
            $criteria->compare('asalrujukan_id', $this->asalrujukan_id);
            $criteria->compare('LOWER(asalrujukan_nama)', strtolower($this->asalrujukan_nama), true);
            $criteria->compare('ruangan_id', Yii::app()->user->getState('ruangan_id'));
            $criteria->compare('LOWER(ruangan_nama)', strtolower($this->ruangan_nama), true);
            $criteria->compare('instalasi_id', $this->instalasi_id);
            $criteria->compare('LOWER(instalasi_nama)', strtolower($this->instalasi_nama), true);
            $criteria->compare('jeniskasuspenyakit_id', $this->jeniskasuspenyakit_id);
            $criteria->compare('LOWER(jeniskasuspenyakit_nama)', strtolower($this->jeniskasuspenyakit_nama), true);
            $criteria->compare('kelaspelayanan_id', $this->kelaspelayanan_id);
            $criteria->compare('LOWER(kelaspelayanan_nama)', strtolower($this->kelaspelayanan_nama), true);

            return new CActiveDataProvider($this, array(
                        'criteria' => $criteria,
                    ));
        }

        /** fungsi untuk generate filter / criteria pada model untuk grafik
         * $model adalah model yang akan digunakan untuk grafik
         * $type adalah filter akan digunakan sebagai x-axis('data') atau group('tick'), default type sebagai x-axis('data')
         * $addCols variable untuk column tmbahan, typenya mix, diantaranya untuk order dll,
         */
        public static function criteriaGrafik($model, $type='data', $addCols = array()){
            $criteria = new CDbCriteria;
            $criteria->select = 'count(pendaftaran_id) as jumlah';
            if ($_GET['filter'] == 'carabayar') {
                if (!empty($model->penjamin_id)) {
                    $criteria->select .= ', penjamin_nama as '.$type;
                    $criteria->group .= 'penjamin_nama';
                } else if (!empty($model->carabayar_id)) {
                    $criteria->select .= ', penjamin_nama as '.$type;
                    $criteria->group = 'penjamin_nama';
                } else {
                    $criteria->select .= ', carabayar_nama as '.$type;
                    $criteria->group = 'carabayar_nama';
                }
            } else if ($_GET['filter'] == 'wilayah') {
                if (!empty($model->kelurahan_id)) {
                    $criteria->select .= ', kelurahan_nama as '.$type;
                    $criteria->group .= 'kelurahan_nama';
                } else if (!empty($model->kecamatan_id)) {
                    $criteria->select .= ', kelurahan_nama as '.$type;
                    $criteria->group .= 'kelurahan_nama';
                } else if (!empty($model->kabupaten_id)) {
                    $criteria->select .= ', kecamatan_nama as '.$type;
                    $criteria->group .= 'kecamatan_nama';
                } else if (!empty($model->propinsi_id)) {
                    $criteria->select .= ', kabupaten_nama as '.$type;
                    $criteria->group .= 'kabupaten_nama';
                } else {
                    $criteria->select .= ', propinsi_nama as '.$type;
                    $criteria->group .= 'propinsi_nama';
                }
            }

            if (!isset($_GET['filter'])){
                $criteria->select .= ', propinsi_nama as '.$type;
                $criteria->group .= 'propinsi_nama';
            }

            if (count($addCols) > 0){
                if (is_array($addCols)){
                    foreach ($addCols as $i => $v){
                        $criteria->group .= ','.$v;
                        $criteria->select .= ','.$v.' as '.$i;
                    }
                }            
            }

            return $criteria;
        }
        
        public function searchGrafik() {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.



            $criteria = $this->criteriaGrafik($this, 'tick');
            if (!empty($criteria->group) &&(!empty($this->pilihanx))){
                $criteria->group .=',';
            }
            if ($this->pilihanx == 'pengunjung') {
                $criteria->select .= ', statuspasien as data';
                $criteria->group .= ' statuspasien';
            } else if ($this->pilihanx == 'kunjungan') {
                $criteria->select .= ', kunjungan as data';
                $criteria->group .= ' kunjungan';
            }
            else if ($this->pilihanx == 'rujukan'){
                $criteria->select .= ', statusmasuk as data';
                $criteria->group .= ' statusmasuk';
            }


            $criteria->addBetweenCondition('tgl_pendaftaran', $this->tgl_awal, $this->tgl_akhir);
            $criteria->compare('propinsi_id', $this->propinsi_id);
            $criteria->compare('LOWER(propinsi_nama)', strtolower($this->propinsi_nama), true);
            $criteria->compare('kabupaten_id', $this->kabupaten_id);
            $criteria->compare('LOWER(kabupaten_nama)', strtolower($this->kabupaten_nama), true);
            $criteria->compare('kelurahan_id', $this->kelurahan_id);
            $criteria->compare('LOWER(kelurahan_nama)', strtolower($this->kelurahan_nama), true);
            $criteria->compare('kecamatan_id', $this->kecamatan_id);
            $criteria->compare('LOWER(kecamatan_nama)', strtolower($this->kecamatan_nama), true);
            $criteria->compare('carabayar_id', $this->carabayar_id);
            $criteria->compare('LOWER(carabayar_nama)', strtolower($this->carabayar_nama), true);
            $criteria->compare('penjamin_id', $this->penjamin_id);
            $criteria->compare('LOWER(penjamin_nama)', strtolower($this->penjamin_nama), true);
            $criteria->compare('ruangan_id', Yii::app()->user->getState('ruangan_id'));
            $criteria->compare('LOWER(ruangan_nama)', strtolower($this->ruangan_nama), true);

            return new CActiveDataProvider($this, array(
                        'criteria' => $criteria,
                    ));
        }
        
        public function getPropinsiItems()
        {
            return PropinsiM::model()->findAll('propinsi_aktif=TRUE ORDER BY propinsi_nama');
        }

        public function getNamaModel() {
            return __CLASS__;
        }
        
        public function getCaraBayarItems()
        {
            return CarabayarM::model()->findAll('carabayar_aktif=TRUE ORDER BY carabayar_nama ASC') ;
        }
        
        public function getPenjaminItems()
        {
            return PenjaminpasienM::model()->findAll('penjamin_aktif=TRUE ORDER BY penjamin_nama ASC');
        }
        
        public function getCaraBayarPenjamin()
        {
                return $this->carabayar_nama.' / '.$this->penjamin_nama;
        }
        
        public function getRTRW()
        {
            return $this->rt.' / '.$this->rw;
        }
        public function getNamaNamaBIN()
        {
            if ($this->nama_bin == null){
            	return $this->nama_pasien;
            }
            return $this->nama_pasien.' Alias '.$this->nama_bin;
        }
        
        public static function berdasarkanStatus() {
            $status = array('pengunjung' => 'Berdasarkan Pengunjung',
                'kunjungan' => 'Berdasarkan Kunjungan',
                'rujukan' => 'Berdasarkan Rujukan'
            );
            return $status;
        }                
        
        protected function afterFind(){
            foreach($this->metadata->tableSchema->columns as $columnName => $column){

                if (!strlen($this->$columnName)) continue;

                if ($column->dbType == 'date'){                         
                        $this->$columnName = Yii::app()->dateFormatter->formatDateTime(
                                        CDateTimeParser::parse($this->$columnName, 'yyyy-MM-dd'),'medium',null);
                        }elseif ($column->dbType == 'timestamp without time zone'){
                                $this->$columnName = Yii::app()->dateFormatter->formatDateTime(
                                        CDateTimeParser::parse($this->$columnName, 'yyyy-MM-dd hh:mm:ss'));
                        }
            }
            return true;
        }
        
        public function primaryKey() {
            return 'pendaftaran_id';
        }
}