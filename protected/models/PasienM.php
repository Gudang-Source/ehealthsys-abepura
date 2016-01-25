<?php

/**
 * This is the model class for table "pasien_m".
 *
 * The followings are the available columns in table 'pasien_m':
 * @property integer $pasien_id
 * @property integer $kelompokumur_id
 * @property integer $kecamatan_id
 * @property integer $pendidikan_id
 * @property integer $profilrs_id
 * @property integer $kelurahan_id
 * @property integer $loginpemakai_id
 * @property integer $suku_id
 * @property integer $pekerjaan_id
 * @property integer $kabupaten_id
 * @property integer $propinsi_id
 * @property integer $dokrekammedis_id
 * @property string $no_rekam_medik
 * @property string $tgl_rekam_medik
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
 * @property string $statusperkawinan
 * @property string $agama
 * @property string $golongandarah
 * @property string $rhesus
 * @property integer $anakke
 * @property integer $jumlah_bersaudara
 * @property string $no_telepon_pasien
 * @property string $no_mobile_pasien
 * @property string $warga_negara
 * @property string $photopasien
 * @property string $alamatemail
 * @property string $statusrekammedis
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $tgl_meninggal
 * @property boolean $ispasienluar
 * @property string $create_ruangan
 * @property string $nama_ibu
 * @property string $nama_ayah
 * @property string $norm_lama
 *
 * The followings are the available model relations:
 * @property AnamesadietT[] $anamesadietTs
 * @property AmbiljenazahT[] $ambiljenazahTs
 * @property AnamnesaT[] $anamnesaTs
 * @property PenjualanresepT[] $penjualanresepTs
 * @property ObatalkespasienT[] $obatalkespasienTs
 * @property BookingkamarT[] $bookingkamarTs
 * @property BayaruangmukaT[] $bayaruangmukaTs
 * @property BuatjanjipoliT[] $buatjanjipoliTs
 * @property PasienmasukpenunjangT[] $pasienmasukpenunjangTs
 * @property PasienadmisiT[] $pasienadmisiTs
 * @property DokrekammedisM $dokrekammedis
 * @property KabupatenM $kabupaten
 * @property KecamatanM $kecamatan
 * @property KelompokumurM $kelompokumur
 * @property KelurahanM $kelurahan
 * @property LoginpemakaiK $loginpemakai
 * @property PekerjaanM $pekerjaan
 * @property PendidikanM $pendidikan
 * @property ProfilrumahsakitM $profilrs
 * @property PropinsiM $propinsi
 * @property SukuM $suku
 * @property DokfilermR[] $dokfilermRs
 * @property PasienpulangT[] $pasienpulangTs
 * @property DietpasienT[] $dietpasienTs
 * @property PeminjamanrmT[] $peminjamanrmTs
 * @property PengirimanrmT[] $pengirimanrmTs
 * @property HasilpemeriksaanpaT[] $hasilpemeriksaanpaTs
 * @property HasilpemeriksaanrmT[] $hasilpemeriksaanrmTs
 * @property HasilpemeriksaanlabT[] $hasilpemeriksaanlabTs
 * @property ResepturT[] $resepturTs
 * @property PasienkirimkeunitlainT[] $pasienkirimkeunitlainTs
 * @property KembalirmT[] $kembalirmTs
 * @property PasienbatalperiksaR[] $pasienbatalperiksaRs
 * @property KonsulpoliT[] $konsulpoliTs
 * @property JadwalkunjunganrmT[] $jadwalkunjunganrmTs
 * @property KegbayitabungT[] $kegbayitabungTs
 * @property KartupasienR[] $kartupasienRs
 * @property PasienmorbiditasT[] $pasienmorbiditasTs
 * @property ReturresepT[] $returresepTs
 * @property OdontogrampasienR[] $odontogrampasienRs
 * @property PasienapachescoreT[] $pasienapachescoreTs
 * @property PasienimunisasiT[] $pasienimunisasiTs
 * @property PasienkbT[] $pasienkbTs
 * @property PindahkamarT[] $pindahkamarTs
 * @property PemeriksaanfisikT[] $pemeriksaanfisikTs
 * @property PesanmenudetailT[] $pesanmenudetailTs
 * @property PesanambulansT[] $pesanambulansTs
 * @property RencanaoperasiT[] $rencanaoperasiTs
 * @property SuratketeranganR[] $suratketeranganRs
 * @property UbahruanganR[] $ubahruanganRs
 * @property PemakaianambulansT[] $pemakaianambulansTs
 * @property TindakanpelayananT[] $tindakanpelayananTs
 * @property PasiendirujukkeluarT[] $pasiendirujukkeluarTs
 * @property OdontogramdetailT[] $odontogramdetailTs
 * @property PasienanastesiT[] $pasienanastesiTs
 * @property PembklaimdetalT[] $pembklaimdetalTs
 * @property PeriksakehamilanT[] $periksakehamilanTs
 * @property PersalinanT[] $persalinanTs
 * @property AsuhankeperawatanT[] $asuhankeperawatanTs
 * @property PendaftaranT[] $pendaftaranTs
 * @property HasilpemeriksaanradT[] $hasilpemeriksaanradTs
 * @property PembayaranpelayananT[] $pembayaranpelayananTs
 * @property KirimmenupasienT[] $kirimmenupasienTs
 * @property PasiennapzaT[] $pasiennapzaTs
 */
class PasienM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PasienM the static model class
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
		return 'pasien_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('kelompokumur_id, kecamatan_id, kabupaten_id, propinsi_id, no_rekam_medik, tgl_rekam_medik, nama_pasien, jeniskelamin, tanggal_lahir, alamat_pasien, agama, warga_negara, statusrekammedis, create_time, create_loginpemakai_id', 'required'),
			array('kelompokumur_id, kecamatan_id, pendidikan_id, profilrs_id, kelurahan_id, loginpemakai_id, suku_id, pekerjaan_id, kabupaten_id, propinsi_id, dokrekammedis_id, rt, rw, anakke, jumlah_bersaudara, pegawai_id', 'numerical', 'integerOnly'=>true),
			array('no_rekam_medik, statusrekammedis, norm_lama', 'length', 'max'=>10),
			array('jenisidentitas, namadepan, jeniskelamin, statusperkawinan, agama, rhesus, no_mobile_pasien', 'length', 'max'=>20),
			array('no_identitas_pasien, nama_bin', 'length', 'max'=>30),
			array('nama_pasien, nama_ibu, nama_ayah', 'length', 'max'=>50),
			array('tempat_lahir, warga_negara', 'length', 'max'=>25),
			array('golongandarah', 'length', 'max'=>2),
			array('no_telepon_pasien', 'length', 'max'=>15),
			array('photopasien', 'length', 'max'=>200),
			array('alamatemail', 'length', 'max'=>100),
			array('update_time, update_loginpemakai_id, tgl_meninggal, ispasienluar, create_ruangan, no_jamkespa', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pasien_id, kelompokumur_id, kecamatan_id, pendidikan_id, profilrs_id, kelurahan_id, loginpemakai_id, suku_id, pekerjaan_id, kabupaten_id, propinsi_id, dokrekammedis_id, no_rekam_medik, tgl_rekam_medik, jenisidentitas, no_identitas_pasien, namadepan, nama_pasien, nama_bin, jeniskelamin, tempat_lahir, tanggal_lahir, alamat_pasien, rt, rw, statusperkawinan, agama, golongandarah, rhesus, anakke, jumlah_bersaudara, no_telepon_pasien, no_mobile_pasien, warga_negara, photopasien, alamatemail, statusrekammedis, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, tgl_meninggal, ispasienluar, create_ruangan, nama_ibu, nama_ayah, norm_lama, pegawai_id', 'safe', 'on'=>'search'),
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
			'anamesadietTs' => array(self::HAS_MANY, 'AnamesadietT', 'pasien_id'),
			'ambiljenazahTs' => array(self::HAS_MANY, 'AmbiljenazahT', 'pasien_id'),
			'anamnesaTs' => array(self::HAS_MANY, 'AnamnesaT', 'pasien_id'),
			'penjualanresepTs' => array(self::HAS_MANY, 'PenjualanresepT', 'pasien_id'),
			'obatalkespasienTs' => array(self::HAS_MANY, 'ObatalkespasienT', 'pasien_id'),
			'bookingkamarTs' => array(self::HAS_MANY, 'BookingkamarT', 'pasien_id'),
			'bayaruangmukaTs' => array(self::HAS_MANY, 'BayaruangmukaT', 'pasien_id'),
			'buatjanjipoliTs' => array(self::HAS_MANY, 'BuatjanjipoliT', 'pasien_id'),
			'pasienmasukpenunjangTs' => array(self::HAS_MANY, 'PasienmasukpenunjangT', 'pasien_id'),
			'pasienadmisiTs' => array(self::HAS_MANY, 'PasienadmisiT', 'pasien_id'),
			'dokrekammedis' => array(self::BELONGS_TO, 'DokrekammedisM', 'dokrekammedis_id'),
			'kabupaten' => array(self::BELONGS_TO, 'KabupatenM', 'kabupaten_id'),
			'kecamatan' => array(self::BELONGS_TO, 'KecamatanM', 'kecamatan_id'),
			'kelompokumur' => array(self::BELONGS_TO, 'KelompokumurM', 'kelompokumur_id'),
			'kelurahan' => array(self::BELONGS_TO, 'KelurahanM', 'kelurahan_id'),
			'loginpemakai' => array(self::BELONGS_TO, 'LoginpemakaiK', 'loginpemakai_id'),
			'pekerjaan' => array(self::BELONGS_TO, 'PekerjaanM', 'pekerjaan_id'),
			'pendidikan' => array(self::BELONGS_TO, 'PendidikanM', 'pendidikan_id'),
			'profilrs' => array(self::BELONGS_TO, 'ProfilrumahsakitM', 'profilrs_id'),
			'propinsi' => array(self::BELONGS_TO, 'PropinsiM', 'propinsi_id'),
			'suku' => array(self::BELONGS_TO, 'SukuM', 'suku_id'),
			'pegawai' => array(self::BELONGS_TO, 'PegawaiM', 'pegawai_id'),
			'dokfilermRs' => array(self::HAS_MANY, 'DokfilermR', 'pasien_id'),
			'pasienpulangTs' => array(self::HAS_MANY, 'PasienpulangT', 'pasien_id'),
			'dietpasienTs' => array(self::HAS_MANY, 'DietpasienT', 'pasien_id'),
			'peminjamanrmTs' => array(self::HAS_MANY, 'PeminjamanrmT', 'pasien_id'),
			'pengirimanrmTs' => array(self::HAS_MANY, 'PengirimanrmT', 'pasien_id'),
			'hasilpemeriksaanpaTs' => array(self::HAS_MANY, 'HasilpemeriksaanpaT', 'pasien_id'),
			'hasilpemeriksaanrmTs' => array(self::HAS_MANY, 'HasilpemeriksaanrmT', 'pasien_id'),
			'hasilpemeriksaanlabTs' => array(self::HAS_MANY, 'HasilpemeriksaanlabT', 'pasien_id'),
			'resepturTs' => array(self::HAS_MANY, 'ResepturT', 'pasien_id'),
			'pasienkirimkeunitlainTs' => array(self::HAS_MANY, 'PasienkirimkeunitlainT', 'pasien_id'),
			'kembalirmTs' => array(self::HAS_MANY, 'KembalirmT', 'pasien_id'),
			'pasienbatalperiksaRs' => array(self::HAS_MANY, 'PasienbatalperiksaR', 'pasien_id'),
			'konsulpoliTs' => array(self::HAS_MANY, 'KonsulpoliT', 'pasien_id'),
			'jadwalkunjunganrmTs' => array(self::HAS_MANY, 'JadwalkunjunganrmT', 'pasien_id'),
			'kegbayitabungTs' => array(self::HAS_MANY, 'KegbayitabungT', 'pasien_id'),
			'kartupasienRs' => array(self::HAS_MANY, 'KartupasienR', 'pasien_id'),
			'pasienmorbiditasTs' => array(self::HAS_MANY, 'PasienmorbiditasT', 'pasien_id'),
			'returresepTs' => array(self::HAS_MANY, 'ReturresepT', 'pasien_id'),
			'odontogrampasienRs' => array(self::HAS_MANY, 'OdontogrampasienR', 'pasien_id'),
			'pasienapachescoreTs' => array(self::HAS_MANY, 'PasienapachescoreT', 'pasien_id'),
			'pasienimunisasiTs' => array(self::HAS_MANY, 'PasienimunisasiT', 'pasien_id'),
			'pasienkbTs' => array(self::HAS_MANY, 'PasienkbT', 'pasien_id'),
			'pindahkamarTs' => array(self::HAS_MANY, 'PindahkamarT', 'pasien_id'),
			'pemeriksaanfisikTs' => array(self::HAS_MANY, 'PemeriksaanfisikT', 'pasien_id'),
			'pesanmenudetailTs' => array(self::HAS_MANY, 'PesanmenudetailT', 'pasien_id'),
			'pesanambulansTs' => array(self::HAS_MANY, 'PesanambulansT', 'pasien_id'),
			'rencanaoperasiTs' => array(self::HAS_MANY, 'RencanaoperasiT', 'pasien_id'),
			'suratketeranganRs' => array(self::HAS_MANY, 'SuratketeranganR', 'pasien_id'),
			'ubahruanganRs' => array(self::HAS_MANY, 'UbahruanganR', 'pasien_id'),
			'pemakaianambulansTs' => array(self::HAS_MANY, 'PemakaianambulansT', 'pasien_id'),
			'tindakanpelayananTs' => array(self::HAS_MANY, 'TindakanpelayananT', 'pasien_id'),
			'pasiendirujukkeluarTs' => array(self::HAS_MANY, 'PasiendirujukkeluarT', 'pasien_id'),
			'odontogramdetailTs' => array(self::HAS_MANY, 'OdontogramdetailT', 'pasien_id'),
			'pasienanastesiTs' => array(self::HAS_MANY, 'PasienanastesiT', 'pasien_id'),
			'pembklaimdetalTs' => array(self::HAS_MANY, 'PembklaimdetalT', 'pasien_id'),
			'periksakehamilanTs' => array(self::HAS_MANY, 'PeriksakehamilanT', 'pasien_id'),
			'persalinanTs' => array(self::HAS_MANY, 'PersalinanT', 'pasien_id'),
			'asuhankeperawatanTs' => array(self::HAS_MANY, 'AsuhankeperawatanT', 'pasien_id'),
			'pendaftaranTs' => array(self::HAS_MANY, 'PendaftaranT', 'pasien_id'),
			'hasilpemeriksaanradTs' => array(self::HAS_MANY, 'HasilpemeriksaanradT', 'pasien_id'),
			'pembayaranpelayananTs' => array(self::HAS_MANY, 'PembayaranpelayananT', 'pasien_id'),
			'kirimmenupasienTs' => array(self::HAS_MANY, 'KirimmenupasienT', 'pasien_id'),
			'pasiennapzaTs' => array(self::HAS_MANY, 'PasiennapzaT', 'pasien_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'pasien_id' => 'Pasien Id',
			'kelompokumur_id' => 'Kelompok Umur',
			'kecamatan_id' => 'Kecamatan',
			'pendidikan_id' => 'Pendidikan',
			'profilrs_id' => 'Profil RS',
			'kelurahan_id' => 'Kelurahan',
			'loginpemakai_id' => 'Login Pemakai',
			'suku_id' => 'Suku',
			'pekerjaan_id' => 'Pekerjaan',
			'kabupaten_id' => 'Kabupaten',
			'propinsi_id' => 'Propinsi',
			'dokrekammedis_id' => 'Dok. Rekammedis',
			'no_rekam_medik' => 'No. Rekam Medik',
			'tgl_rekam_medik' => 'Tanggal Rekam Medik',
			'jenisidentitas' => 'Jenis Identitas',
			'no_identitas_pasien' => 'No. Identitas Pasien',
			'namadepan' => 'Nama Depan',
			'nama_pasien' => 'Nama Pasien',
			'nama_bin' => 'Nama Panggilan',
			'jeniskelamin' => 'Jenis Kelamin',
			'tempat_lahir' => 'Tempat Lahir',
			'tanggal_lahir' => 'Tanggal Lahir',
			'alamat_pasien' => 'Alamat Pasien',
			'rt' => 'RT',
			'rw' => 'RW',
			'statusperkawinan' => 'Status Perkawinan',
			'agama' => 'Agama',
			'golongandarah' => 'Golongan Darah',
			'rhesus' => 'Rhesus',
			'anakke' => 'Anak ke',
			'jumlah_bersaudara' => 'Jumlah Bersaudara',
			'no_telepon_pasien' => 'No. Telepon Pasien',
			'no_mobile_pasien' => 'No. Mobile Pasien',
			'warga_negara' => 'Warga Negara',
			'photopasien' => 'Foto Pasien',
			'alamatemail' => 'Alamat E-mail',
			'statusrekammedis' => 'Status Rekam Medis',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'create_loginpemakai_id' => 'Create Loginpemakai',
			'update_loginpemakai_id' => 'Update Loginpemakai',
			'tgl_meninggal' => 'Tanggal Meninggal',
			'ispasienluar' => 'Pasien Luar',
			'create_ruangan' => 'Create Ruangan',
			'nama_ibu' => 'Nama Ibu',
			'nama_ayah' => 'Nama Ayah',
			'norm_lama' => 'No. Rekam Medik Lama',
			'pegawai_id' => 'Pegawai',
                        'no_jamkespa' => 'No. Jamkespa',
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
		$format = new MyFormatter();
		$criteria=new CDbCriteria;

		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('kelompokumur_id',$this->kelompokumur_id);
		$criteria->compare('kecamatan_id',$this->kecamatan_id);
		$criteria->compare('pendidikan_id',$this->pendidikan_id);
		$criteria->compare('profilrs_id',$this->profilrs_id);
		$criteria->compare('kelurahan_id',$this->kelurahan_id);
		$criteria->compare('loginpemakai_id',$this->loginpemakai_id);
		$criteria->compare('suku_id',$this->suku_id);
		$criteria->compare('pekerjaan_id',$this->pekerjaan_id);
		$criteria->compare('kabupaten_id',$this->kabupaten_id);
		$criteria->compare('propinsi_id',$this->propinsi_id);
		$criteria->compare('dokrekammedis_id',$this->dokrekammedis_id);
		$criteria->compare('LOWER(no_rekam_medik)',strtolower($this->no_rekam_medik),true);
		$criteria->compare('LOWER(tgl_rekam_medik)',strtolower($this->tgl_rekam_medik),true);
		$criteria->compare('LOWER(jenisidentitas)',strtolower($this->jenisidentitas),true);
		$criteria->compare('LOWER(no_identitas_pasien)',strtolower($this->no_identitas_pasien),true);
		$criteria->compare('LOWER(namadepan)',strtolower($this->namadepan),true);
		$criteria->compare('LOWER(nama_pasien)',strtolower($this->nama_pasien),true);
		$criteria->compare('LOWER(nama_bin)',strtolower($this->nama_bin),true);
		$criteria->compare('LOWER(jeniskelamin)',strtolower($this->jeniskelamin),true);
		$criteria->compare('LOWER(tempat_lahir)',strtolower($this->tempat_lahir),true);
		$criteria->compare('DATE(tanggal_lahir)',$format->formatDateTimeForDb($this->tanggal_lahir));
		$criteria->compare('LOWER(alamat_pasien)',strtolower($this->alamat_pasien),true);
		$criteria->compare('rt',$this->rt);
		$criteria->compare('rw',$this->rw);
		$criteria->compare('LOWER(statusperkawinan)',strtolower($this->statusperkawinan),true);
		$criteria->compare('LOWER(agama)',strtolower($this->agama),true);
		$criteria->compare('LOWER(golongandarah)',strtolower($this->golongandarah),true);
		$criteria->compare('LOWER(rhesus)',strtolower($this->rhesus),true);
		$criteria->compare('anakke',$this->anakke);
		$criteria->compare('jumlah_bersaudara',$this->jumlah_bersaudara);
		$criteria->compare('LOWER(no_telepon_pasien)',strtolower($this->no_telepon_pasien),true);
		$criteria->compare('LOWER(no_mobile_pasien)',strtolower($this->no_mobile_pasien),true);
		$criteria->compare('LOWER(warga_negara)',strtolower($this->warga_negara),true);
		$criteria->compare('LOWER(photopasien)',strtolower($this->photopasien),true);
		$criteria->compare('LOWER(alamatemail)',strtolower($this->alamatemail),true);
		$criteria->compare('LOWER(statusrekammedis)',strtolower($this->statusrekammedis));
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
		$criteria->compare('LOWER(tgl_meninggal)',strtolower($this->tgl_meninggal),true);
		$criteria->compare('ispasienluar',$this->ispasienluar);
		$criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);
		$criteria->compare('LOWER(nama_ibu)',strtolower($this->nama_ibu),true);
		$criteria->compare('LOWER(nama_ayah)',strtolower($this->nama_ayah),true);
		$criteria->compare('LOWER(norm_lama)',strtolower($this->norm_lama),true);

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