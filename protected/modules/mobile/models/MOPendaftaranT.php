<?php

/**
 * This is the model class for table "pendaftaran_t".
 *
 * The followings are the available columns in table 'pendaftaran_t':
 * @property integer $pendaftaran_id
 * @property integer $pasienpulang_id
 * @property integer $pasienbatalperiksa_id
 * @property integer $penanggungjawab_id
 * @property integer $penjamin_id
 * @property integer $shift_id
 * @property integer $pasien_id
 * @property integer $persalinan_id
 * @property integer $pegawai_id
 * @property integer $instalasi_id
 * @property integer $caramasuk_id
 * @property integer $pengirimanrm_id
 * @property integer $peminjamanrm_id
 * @property integer $jeniskasuspenyakit_id
 * @property integer $pembayaranpelayanan_id
 * @property integer $kelaspelayanan_id
 * @property integer $carabayar_id
 * @property integer $pasienadmisi_id
 * @property integer $kelompokumur_id
 * @property integer $golonganumur_id
 * @property integer $rujukan_id
 * @property integer $antrian_id
 * @property integer $karcis_id
 * @property integer $ruangan_id
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
 * @property string $tglselesaiperiksa
 * @property string $keterangan_reg
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 * @property boolean $nopendaftaran_aktif
 * @property string $status_konfirmasi
 * @property string $tgl_konfirmasi
 * @property string $tglrenkontrol
 * @property boolean $statusfarmasi
 * @property boolean $panggilantrian
 * @property integer $asuransipasien_id
 * @property string $tglakandilayani
 *
 * The followings are the available model relations:
 * @property UnitdosisT[] $unitdosisTs
 * @property UbahruanganR[] $ubahruanganRs
 * @property UbahcarabayarR[] $ubahcarabayarRs
 * @property RencanaoperasiT[] $rencanaoperasiTs
 * @property ReturresepT[] $returresepTs
 * @property PindahkamarT[] $pindahkamarTs
 * @property PesanmenudetailT[] $pesanmenudetailTs
 * @property PesanambulansT[] $pesanambulansTs
 * @property PeriksakehamilanT[] $periksakehamilanTs
 * @property PengajuanklaimdetailT[] $pengajuanklaimdetailTs
 * @property PasienmasukpenunjangT[] $pasienmasukpenunjangTs
 * @property PembklaimdetalT[] $pembklaimdetalTs
 * @property PembjasadetailT[] $pembjasadetailTs
 * @property PemakaianambulansT[] $pemakaianambulansTs
 * @property PasienpulangT[] $pasienpulangTs
 * @property PasiennapzaT[] $pasiennapzaTs
 * @property PasienkbT[] $pasienkbTs
 * @property PasienimunisasiT[] $pasienimunisasiTs
 * @property PasienapachescoreT[] $pasienapachescoreTs
 * @property OdontogramdetailT[] $odontogramdetailTs
 * @property KirimmenupasienT[] $kirimmenupasienTs
 * @property KegbayitabungT[] $kegbayitabungTs
 * @property KartupasienR[] $kartupasienRs
 * @property HasilpemeriksaanrmT[] $hasilpemeriksaanrmTs
 * @property JadwalkunjunganrmT[] $jadwalkunjunganrmTs
 * @property HasilpemeriksaanlabT[] $hasilpemeriksaanlabTs
 * @property DietpasienT[] $dietpasienTs
 * @property BookingkamarT[] $bookingkamarTs
 * @property AnamesadietT[] $anamesadietTs
 * @property AmbiljenazahT[] $ambiljenazahTs
 * @property BayaruangmukaT[] $bayaruangmukaTs
 * @property AsuhankeperawatanT[] $asuhankeperawatanTs
 * @property TindakanpelayananT[] $tindakanpelayananTs
 * @property HasilpemeriksaanradT[] $hasilpemeriksaanradTs
 * @property RincianCetakan[] $rincianCetakans
 * @property HasilpemeriksaanpaT[] $hasilpemeriksaanpaTs
 * @property SuratketeranganR[] $suratketeranganRs
 * @property PasiendirujukkeluarT[] $pasiendirujukkeluarTs
 * @property ObatalkespasienT[] $obatalkespasienTs
 * @property PasienanastesiT[] $pasienanastesiTs
 * @property UbahdokterR[] $ubahdokterRs
 * @property PasienkecelakaanT[] $pasienkecelakaanTs
 * @property PasienmorbiditasT[] $pasienmorbiditasTs
 * @property PenjualanresepT[] $penjualanresepTs
 * @property BuatjanjipoliT[] $buatjanjipoliTs
 * @property AnamnesaT[] $anamnesaTs
 * @property CaramasukM $caramasuk
 * @property AntrianT $antrian
 * @property CarabayarM $carabayar
 * @property GolonganumurM $golonganumur
 * @property InstalasiM $instalasi
 * @property JeniskasuspenyakitM $jeniskasuspenyakit
 * @property KarcisM $karcis
 * @property KelaspelayananM $kelaspelayanan
 * @property KelompokumurM $kelompokumur
 * @property PasienM $pasien
 * @property PasienadmisiT $pasienadmisi
 * @property PasienbatalperiksaR $pasienbatalperiksa
 * @property PegawaiM $pegawai
 * @property PembayaranpelayananT $pembayaranpelayanan
 * @property PeminjamanrmT $peminjamanrm
 * @property PenanggungjawabM $penanggungjawab
 * @property PengirimanrmT $pengirimanrm
 * @property PenjaminpasienM $penjamin
 * @property PersalinanT $persalinan
 * @property RuanganM $ruangan
 * @property RujukanT $rujukan
 * @property ShiftM $shift
 * @property KembalirmT[] $kembalirmTs
 * @property PasienkirimkeunitlainT[] $pasienkirimkeunitlainTs
 * @property ResepturT[] $resepturTs
 * @property PasienbatalperiksaR[] $pasienbatalperiksaRs
 * @property KonsulpoliT[] $konsulpoliTs
 * @property PersalinanT[] $persalinanTs
 * @property PengirimanrmT[] $pengirimanrmTs
 * @property PeminjamanrmT[] $peminjamanrmTs
 * @property PembayaranpelayananT[] $pembayaranpelayananTs
 * @property PasienadmisiT[] $pasienadmisiTs
 * @property AntrianT[] $antrianTs
 */
class MOPendaftaranT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return MOPendaftaranT the static model class
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
		return 'pendaftaran_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('kelompokumur_id, no_pendaftaran, tgl_pendaftaran, no_urutantri, statuspasien, kunjungan, statusmasuk, umur, create_time, create_loginpemakai_id', 'required'),
			array('pasienpulang_id, pasienbatalperiksa_id, penanggungjawab_id, penjamin_id, shift_id, pasien_id, persalinan_id, pegawai_id, instalasi_id, caramasuk_id, pengirimanrm_id, peminjamanrm_id, jeniskasuspenyakit_id, pembayaranpelayanan_id, kelaspelayanan_id, carabayar_id, pasienadmisi_id, kelompokumur_id, golonganumur_id, rujukan_id, antrian_id, karcis_id, ruangan_id, asuransipasien_id', 'numerical', 'integerOnly'=>true),
			array('no_pendaftaran', 'length', 'max'=>20),
			array('no_urutantri', 'length', 'max'=>6),
			array('transportasi, keadaanmasuk, statusperiksa, statuspasien, kunjungan, statusmasuk, status_konfirmasi', 'length', 'max'=>50),
			array('umur', 'length', 'max'=>30),
			array('alihstatus, byphone, kunjunganrumah, tglselesaiperiksa, keterangan_reg, update_time, update_loginpemakai_id, create_ruangan, nopendaftaran_aktif, tgl_konfirmasi, tglrenkontrol, statusfarmasi, panggilantrian, tglakandilayani', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pendaftaran_id, pasienpulang_id, pasienbatalperiksa_id, penanggungjawab_id, penjamin_id, shift_id, pasien_id, persalinan_id, pegawai_id, instalasi_id, caramasuk_id, pengirimanrm_id, peminjamanrm_id, jeniskasuspenyakit_id, pembayaranpelayanan_id, kelaspelayanan_id, carabayar_id, pasienadmisi_id, kelompokumur_id, golonganumur_id, rujukan_id, antrian_id, karcis_id, ruangan_id, no_pendaftaran, tgl_pendaftaran, no_urutantri, transportasi, keadaanmasuk, statusperiksa, statuspasien, kunjungan, alihstatus, byphone, kunjunganrumah, statusmasuk, umur, tglselesaiperiksa, keterangan_reg, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, nopendaftaran_aktif, status_konfirmasi, tgl_konfirmasi, tglrenkontrol, statusfarmasi, panggilantrian, asuransipasien_id, tglakandilayani', 'safe', 'on'=>'search'),
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
			'unitdosisTs' => array(self::HAS_MANY, 'UnitdosisT', 'pendaftaran_id'),
			'ubahruanganRs' => array(self::HAS_MANY, 'UbahruanganR', 'pendaftaran_id'),
			'ubahcarabayarRs' => array(self::HAS_MANY, 'UbahcarabayarR', 'pendaftaran_id'),
			'rencanaoperasiTs' => array(self::HAS_MANY, 'RencanaoperasiT', 'pendaftaran_id'),
			'returresepTs' => array(self::HAS_MANY, 'ReturresepT', 'pendaftaran_id'),
			'pindahkamarTs' => array(self::HAS_MANY, 'PindahkamarT', 'pendaftaran_id'),
			'pesanmenudetailTs' => array(self::HAS_MANY, 'PesanmenudetailT', 'pendaftaran_id'),
			'pesanambulansTs' => array(self::HAS_MANY, 'PesanambulansT', 'pendaftaran_id'),
			'periksakehamilanTs' => array(self::HAS_MANY, 'PeriksakehamilanT', 'pendaftaran_id'),
			'pengajuanklaimdetailTs' => array(self::HAS_MANY, 'PengajuanklaimdetailT', 'pendaftaran_id'),
			'pasienmasukpenunjangTs' => array(self::HAS_MANY, 'PasienmasukpenunjangT', 'pendaftaran_id'),
			'pembklaimdetalTs' => array(self::HAS_MANY, 'PembklaimdetalT', 'pendaftaran_id'),
			'pembjasadetailTs' => array(self::HAS_MANY, 'PembjasadetailT', 'pendaftaran_id'),
			'pemakaianambulansTs' => array(self::HAS_MANY, 'PemakaianambulansT', 'pendaftaran_id'),
			'pasienpulangTs' => array(self::HAS_MANY, 'PasienpulangT', 'pendaftaran_id'),
			'pasiennapzaTs' => array(self::HAS_MANY, 'PasiennapzaT', 'pendaftaran_id'),
			'pasienkbTs' => array(self::HAS_MANY, 'PasienkbT', 'pendaftaran_id'),
			'pasienimunisasiTs' => array(self::HAS_MANY, 'PasienimunisasiT', 'pendaftaran_id'),
			'pasienapachescoreTs' => array(self::HAS_MANY, 'PasienapachescoreT', 'pendaftaran_id'),
			'odontogramdetailTs' => array(self::HAS_MANY, 'OdontogramdetailT', 'pendaftaran_id'),
			'kirimmenupasienTs' => array(self::HAS_MANY, 'KirimmenupasienT', 'pendaftaran_id'),
			'kegbayitabungTs' => array(self::HAS_MANY, 'KegbayitabungT', 'pendaftaran_id'),
			'kartupasienRs' => array(self::HAS_MANY, 'KartupasienR', 'pendaftaran_id'),
			'hasilpemeriksaanrmTs' => array(self::HAS_MANY, 'HasilpemeriksaanrmT', 'pendaftaran_id'),
			'jadwalkunjunganrmTs' => array(self::HAS_MANY, 'JadwalkunjunganrmT', 'pendaftaran_id'),
			'hasilpemeriksaanlabTs' => array(self::HAS_MANY, 'HasilpemeriksaanlabT', 'pendaftaran_id'),
			'dietpasienTs' => array(self::HAS_MANY, 'DietpasienT', 'pendaftaran_id'),
			'bookingkamarTs' => array(self::HAS_MANY, 'BookingkamarT', 'pendaftaran_id'),
			'anamesadietTs' => array(self::HAS_MANY, 'AnamesadietT', 'pendaftaran_id'),
			'ambiljenazahTs' => array(self::HAS_MANY, 'AmbiljenazahT', 'pendaftaran_id'),
			'bayaruangmukaTs' => array(self::HAS_MANY, 'BayaruangmukaT', 'pendaftaran_id'),
			'asuhankeperawatanTs' => array(self::HAS_MANY, 'AsuhankeperawatanT', 'pendaftaran_id'),
			'tindakanpelayananTs' => array(self::HAS_MANY, 'TindakanpelayananT', 'pendaftaran_id'),
			'hasilpemeriksaanradTs' => array(self::HAS_MANY, 'HasilpemeriksaanradT', 'pendaftaran_id'),
			'rincianCetakans' => array(self::HAS_MANY, 'RincianCetakan', 'pendaftaran_id'),
			'hasilpemeriksaanpaTs' => array(self::HAS_MANY, 'HasilpemeriksaanpaT', 'pendaftaran_id'),
			'suratketeranganRs' => array(self::HAS_MANY, 'SuratketeranganR', 'pendaftaran_id'),
			'pasiendirujukkeluarTs' => array(self::HAS_MANY, 'PasiendirujukkeluarT', 'pendaftaran_id'),
			'obatalkespasienTs' => array(self::HAS_MANY, 'ObatalkespasienT', 'pendaftaran_id'),
			'pasienanastesiTs' => array(self::HAS_MANY, 'PasienanastesiT', 'pendaftaran_id'),
			'ubahdokterRs' => array(self::HAS_MANY, 'UbahdokterR', 'pendaftaran_id'),
			'pasienkecelakaanTs' => array(self::HAS_MANY, 'PasienkecelakaanT', 'pendaftaran_id'),
			'pasienmorbiditasTs' => array(self::HAS_MANY, 'PasienmorbiditasT', 'pendaftaran_id'),
			'penjualanresepTs' => array(self::HAS_MANY, 'PenjualanresepT', 'pendaftaran_id'),
			'buatjanjipoliTs' => array(self::HAS_MANY, 'BuatjanjipoliT', 'pendaftaran_id'),
			'anamnesaTs' => array(self::HAS_MANY, 'AnamnesaT', 'pendaftaran_id'),
			'caramasuk' => array(self::BELONGS_TO, 'CaramasukM', 'caramasuk_id'),
			'antrian' => array(self::BELONGS_TO, 'AntrianT', 'antrian_id'),
			'carabayar' => array(self::BELONGS_TO, 'CarabayarM', 'carabayar_id'),
			'golonganumur' => array(self::BELONGS_TO, 'GolonganumurM', 'golonganumur_id'),
			'instalasi' => array(self::BELONGS_TO, 'InstalasiM', 'instalasi_id'),
			'jeniskasuspenyakit' => array(self::BELONGS_TO, 'JeniskasuspenyakitM', 'jeniskasuspenyakit_id'),
			'karcis' => array(self::BELONGS_TO, 'KarcisM', 'karcis_id'),
			'kelaspelayanan' => array(self::BELONGS_TO, 'KelaspelayananM', 'kelaspelayanan_id'),
			'kelompokumur' => array(self::BELONGS_TO, 'KelompokumurM', 'kelompokumur_id'),
			'pasien' => array(self::BELONGS_TO, 'PasienM', 'pasien_id'),
			'pasienadmisi' => array(self::BELONGS_TO, 'PasienadmisiT', 'pasienadmisi_id'),
			'pasienbatalperiksa' => array(self::BELONGS_TO, 'PasienbatalperiksaR', 'pasienbatalperiksa_id'),
			'pegawai' => array(self::BELONGS_TO, 'PegawaiM', 'pegawai_id'),
			'pembayaranpelayanan' => array(self::BELONGS_TO, 'PembayaranpelayananT', 'pembayaranpelayanan_id'),
			'peminjamanrm' => array(self::BELONGS_TO, 'PeminjamanrmT', 'peminjamanrm_id'),
			'penanggungjawab' => array(self::BELONGS_TO, 'PenanggungjawabM', 'penanggungjawab_id'),
			'pengirimanrm' => array(self::BELONGS_TO, 'PengirimanrmT', 'pengirimanrm_id'),
			'penjamin' => array(self::BELONGS_TO, 'PenjaminpasienM', 'penjamin_id'),
			'persalinan' => array(self::BELONGS_TO, 'PersalinanT', 'persalinan_id'),
			'ruangan' => array(self::BELONGS_TO, 'RuanganM', 'ruangan_id'),
			'rujukan' => array(self::BELONGS_TO, 'RujukanT', 'rujukan_id'),
			'shift' => array(self::BELONGS_TO, 'ShiftM', 'shift_id'),
			'kembalirmTs' => array(self::HAS_MANY, 'KembalirmT', 'pendaftaran_id'),
			'pasienkirimkeunitlainTs' => array(self::HAS_MANY, 'PasienkirimkeunitlainT', 'pendaftaran_id'),
			'resepturTs' => array(self::HAS_MANY, 'ResepturT', 'pendaftaran_id'),
			'pasienbatalperiksaRs' => array(self::HAS_MANY, 'PasienbatalperiksaR', 'pendaftaran_id'),
			'konsulpoliTs' => array(self::HAS_MANY, 'KonsulpoliT', 'pendaftaran_id'),
			'persalinanTs' => array(self::HAS_MANY, 'PersalinanT', 'pendaftaran_id'),
			'pengirimanrmTs' => array(self::HAS_MANY, 'PengirimanrmT', 'pendaftaran_id'),
			'peminjamanrmTs' => array(self::HAS_MANY, 'PeminjamanrmT', 'pendaftaran_id'),
			'pembayaranpelayananTs' => array(self::HAS_MANY, 'PembayaranpelayananT', 'pendaftaran_id'),
			'pasienadmisiTs' => array(self::HAS_MANY, 'PasienadmisiT', 'pendaftaran_id'),
			'antrianTs' => array(self::HAS_MANY, 'AntrianT', 'pendaftaran_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'pendaftaran_id' => 'Pendaftaran',
			'pasienpulang_id' => 'Pasien Pulang',
			'pasienbatalperiksa_id' => 'Pasien Batal Periksa',
			'penanggungjawab_id' => 'Penanggung Jawab',
			'penjamin_id' => 'Penjamin',
			'shift_id' => 'Shift',
			'pasien_id' => 'Pasien',
			'persalinan_id' => 'Persalinan',
			'pegawai_id' => 'Dokter',
			'instalasi_id' => 'Instalasi',
			'caramasuk_id' => 'Cara Masuk',
			'pengirimanrm_id' => 'Pengiriman RM',
			'peminjamanrm_id' => 'Peminjaman RM',
			'jeniskasuspenyakit_id' => 'Jenis Kasus Penyakit',
			'pembayaranpelayanan_id' => 'Pembayaran Pelayanan',
			'kelaspelayanan_id' => 'Kelas Pelayanan',
			'carabayar_id' => 'Cara Bayar',
			'pasienadmisi_id' => 'Pasien Admisi',
			'kelompokumur_id' => 'Kelompok Umur',
			'golonganumur_id' => 'Golongan Umur',
			'rujukan_id' => 'Rujukan',
			'antrian_id' => 'Antrian',
			'karcis_id' => 'Karcis',
			'ruangan_id' => 'Ruangan',
			'no_pendaftaran' => 'No. Pendaftaran',
			'tgl_pendaftaran' => 'Tgl. Pendaftaran',
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
			'tglselesaiperiksa' => 'Tanggal Selesai Periksa',
			'keterangan_reg' => 'Keterangan Registrasi',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
			'nopendaftaran_aktif' => 'No. Pendaftaran Aktif',
			'status_konfirmasi' => 'Status Konfirmasi',
			'tgl_konfirmasi' => 'Tanggal Konfirmasi',
			'tglrenkontrol' => 'Tgl. Rencana Kontrol',
			'statusfarmasi' => 'Status Farmasi',
                                                'no_rekam_medik'=>'No. Rekam Medik'
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

		if(!empty($this->pendaftaran_id)){
			$criteria->addCondition('pendaftaran_id = '.$this->pendaftaran_id);
		}
		if(!empty($this->pasienpulang_id)){
			$criteria->addCondition('pasienpulang_id = '.$this->pasienpulang_id);
		}
		if(!empty($this->pasienbatalperiksa_id)){
			$criteria->addCondition('pasienbatalperiksa_id = '.$this->pasienbatalperiksa_id);
		}
		if(!empty($this->penanggungjawab_id)){
			$criteria->addCondition('penanggungjawab_id = '.$this->penanggungjawab_id);
		}
		if(!empty($this->penjamin_id)){
			$criteria->addCondition('penjamin_id = '.$this->penjamin_id);
		}
		if(!empty($this->shift_id)){
			$criteria->addCondition('shift_id = '.$this->shift_id);
		}
		if(!empty($this->pasien_id)){
			$criteria->addCondition('pasien_id = '.$this->pasien_id);
		}
		if(!empty($this->persalinan_id)){
			$criteria->addCondition('persalinan_id = '.$this->persalinan_id);
		}
		if(!empty($this->pegawai_id)){
			$criteria->addCondition('pegawai_id = '.$this->pegawai_id);
		}
		if(!empty($this->instalasi_id)){
			$criteria->addCondition('instalasi_id = '.$this->instalasi_id);
		}
		if(!empty($this->caramasuk_id)){
			$criteria->addCondition('caramasuk_id = '.$this->caramasuk_id);
		}
		if(!empty($this->pengirimanrm_id)){
			$criteria->addCondition('pengirimanrm_id = '.$this->pengirimanrm_id);
		}
		if(!empty($this->peminjamanrm_id)){
			$criteria->addCondition('peminjamanrm_id = '.$this->peminjamanrm_id);
		}
		if(!empty($this->jeniskasuspenyakit_id)){
			$criteria->addCondition('jeniskasuspenyakit_id = '.$this->jeniskasuspenyakit_id);
		}
		if(!empty($this->pembayaranpelayanan_id)){
			$criteria->addCondition('pembayaranpelayanan_id = '.$this->pembayaranpelayanan_id);
		}
		if(!empty($this->kelaspelayanan_id)){
			$criteria->addCondition('kelaspelayanan_id = '.$this->kelaspelayanan_id);
		}
		if(!empty($this->carabayar_id)){
			$criteria->addCondition('carabayar_id = '.$this->carabayar_id);
		}
		if(!empty($this->pasienadmisi_id)){
			$criteria->addCondition('pasienadmisi_id = '.$this->pasienadmisi_id);
		}
		if(!empty($this->kelompokumur_id)){
			$criteria->addCondition('kelompokumur_id = '.$this->kelompokumur_id);
		}
		if(!empty($this->golonganumur_id)){
			$criteria->addCondition('golonganumur_id = '.$this->golonganumur_id);
		}
		if(!empty($this->rujukan_id)){
			$criteria->addCondition('rujukan_id = '.$this->rujukan_id);
		}
		if(!empty($this->antrian_id)){
			$criteria->addCondition('antrian_id = '.$this->antrian_id);
		}
		if(!empty($this->karcis_id)){
			$criteria->addCondition('karcis_id = '.$this->karcis_id);
		}
		if(!empty($this->ruangan_id)){
			$criteria->addCondition('ruangan_id = '.$this->ruangan_id);
		}
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
		$criteria->compare('LOWER(tglselesaiperiksa)',strtolower($this->tglselesaiperiksa),true);
		$criteria->compare('LOWER(keterangan_reg)',strtolower($this->keterangan_reg),true);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
		$criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);
		$criteria->compare('nopendaftaran_aktif',$this->nopendaftaran_aktif);
		$criteria->compare('LOWER(status_konfirmasi)',strtolower($this->status_konfirmasi),true);
		$criteria->compare('LOWER(tgl_konfirmasi)',strtolower($this->tgl_konfirmasi),true);
		$criteria->compare('LOWER(tglrenkontrol)',strtolower($this->tglrenkontrol),true);
		$criteria->compare('statusfarmasi',$this->statusfarmasi);
		$criteria->compare('panggilantrian',$this->panggilantrian);
		if(!empty($this->asuransipasien_id)){
			$criteria->addCondition('asuransipasien_id = '.$this->asuransipasien_id);
		}
		$criteria->compare('LOWER(tglakandilayani)',strtolower($this->tglakandilayani),true);

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