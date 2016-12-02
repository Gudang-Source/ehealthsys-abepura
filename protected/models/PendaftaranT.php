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
 * @property integer $sep_id
 *
 * The followings are the available model relations:
 * @property AnamesadietT[] $anamesadietTs
 * @property AmbiljenazahT[] $ambiljenazahTs
 * @property AnamnesaT[] $anamnesaTs
 * @property AntrianT[] $antrianTs
 * @property PenjualanresepT[] $penjualanresepTs
 * @property ObatalkespasienT[] $obatalkespasienTs
 * @property BookingkamarT[] $bookingkamarTs
 * @property BayaruangmukaT[] $bayaruangmukaTs
 * @property PasienmasukpenunjangT[] $pasienmasukpenunjangTs
 * @property PasienadmisiT[] $pasienadmisiTs
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
 * @property KonsulpoliT[] $konsulpoliTs
 * @property JadwalkunjunganrmT[] $jadwalkunjunganrmTs
 * @property KegbayitabungT[] $kegbayitabungTs
 * @property PasienmorbiditasT[] $pasienmorbiditasTs
 * @property PasienkecelakaanT[] $pasienkecelakaanTs
 * @property ReturresepT[] $returresepTs
 * @property PasienapachescoreT[] $pasienapachescoreTs
 * @property PasienimunisasiT[] $pasienimunisasiTs
 * @property PasienkbT[] $pasienkbTs
 * @property PindahkamarT[] $pindahkamarTs
 * @property PemeriksaanfisikT[] $pemeriksaanfisikTs
 * @property PesanmenudetailT[] $pesanmenudetailTs
 * @property PesanambulansT[] $pesanambulansTs
 * @property RencanaoperasiT[] $rencanaoperasiTs
 * @property RincianCetakan[] $rincianCetakans
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
 * @property AntrianT $antrian
 * @property CarabayarM $carabayar
 * @property CaramasukM $caramasuk
 * @property GolonganumurM $golonganumur
 * @property InstalasiM $instalasi
 * @property JeniskasuspenyakitM $jeniskasuspenyakit
 * @property KarcisM $karcis
 * @property KelaspelayananM $kelaspelayanan
 * @property KelompokumurM $kelompokumur
 * @property PasienM $pasien
 * @property PasienbatalperiksaR $pasienbatalperiksa
 * @property PasienpulangT $pasienpulang
 * @property PegawaiM $pegawai
 * @property PeminjamanrmT $peminjamanrm
 * @property PenanggungjawabM $penanggungjawab
 * @property PengirimanrmT $pengirimanrm
 * @property PenjaminpasienM $penjamin
 * @property PersalinanT $persalinan
 * @property RuanganM $ruangan
 * @property RujukanT $rujukan
 * @property ShiftM $shift
 * @property HasilpemeriksaanradT[] $hasilpemeriksaanradTs
 * @property KirimmenupasienT[] $kirimmenupasienTs
 * @property PasiennapzaT[] $pasiennapzaTs
 * @property SepT[] $sepTs
 */
class PendaftaranT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PendaftaranT the static model class
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
			array('instalasi_id, kelompokumur_id, no_pendaftaran, tgl_pendaftaran, no_urutantri, statuspasien, kunjungan, statusmasuk, umur, create_time, create_loginpemakai_id', 'required'),
			array('pasienpulang_id, pasienbatalperiksa_id, penanggungjawab_id, penjamin_id, shift_id, pasien_id, persalinan_id, pegawai_id, instalasi_id, caramasuk_id, pengirimanrm_id, peminjamanrm_id, jeniskasuspenyakit_id, pembayaranpelayanan_id, kelaspelayanan_id, carabayar_id, pasienadmisi_id, kelompokumur_id, golonganumur_id, rujukan_id, antrian_id, karcis_id, ruangan_id, sep_id', 'numerical', 'integerOnly'=>true),
			array('no_pendaftaran', 'length', 'max'=>20),
			array('no_urutantri', 'length', 'max'=>6),
			array('transportasi, keadaanmasuk, statusperiksa, statuspasien, kunjungan, statusmasuk, status_konfirmasi', 'length', 'max'=>50),
			array('umur', 'length', 'max'=>30),
			array('alihstatus, byphone, kunjunganrumah, tglselesaiperiksa, keterangan_reg, update_time, update_loginpemakai_id, create_ruangan, nopendaftaran_aktif, tgl_konfirmasi, tglrenkontrol, statusfarmasi, ruangankontrol_id', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pendaftaran_id, pasienpulang_id, pasienbatalperiksa_id, penanggungjawab_id, penjamin_id, shift_id, pasien_id, persalinan_id, pegawai_id, instalasi_id, caramasuk_id, pengirimanrm_id, peminjamanrm_id, jeniskasuspenyakit_id, pembayaranpelayanan_id, kelaspelayanan_id, carabayar_id, pasienadmisi_id, kelompokumur_id, golonganumur_id, rujukan_id, antrian_id, karcis_id, ruangan_id, no_pendaftaran, tgl_pendaftaran, no_urutantri, transportasi, keadaanmasuk, statusperiksa, statuspasien, kunjungan, alihstatus, byphone, kunjunganrumah, statusmasuk, umur, tglselesaiperiksa, keterangan_reg, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, nopendaftaran_aktif, status_konfirmasi, tgl_konfirmasi, tglrenkontrol, statusfarmasi, sep_id, ruangankontrol_id', 'safe', 'on'=>'search'),
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
			'anamesadietTs' => array(self::HAS_MANY, 'AnamesadietT', 'pendaftaran_id'),
			'ambiljenazahTs' => array(self::HAS_MANY, 'AmbiljenazahT', 'pendaftaran_id'),
			'anamnesaTs' => array(self::HAS_MANY, 'AnamnesaT', 'pendaftaran_id'),
			'anamnesa'=>array(self::HAS_ONE, 'AnamnesaT', 'pendaftaran_id'),
			'antrianTs' => array(self::HAS_MANY, 'AntrianT', 'pendaftaran_id'),
			'penjualanresepTs' => array(self::HAS_MANY, 'PenjualanresepT', 'pendaftaran_id'),
			'obatalkespasienTs' => array(self::HAS_MANY, 'ObatalkespasienT', 'pendaftaran_id'),
			'bookingkamarTs' => array(self::HAS_MANY, 'BookingkamarT', 'pendaftaran_id'),
			'bayaruangmukaTs' => array(self::HAS_MANY, 'BayaruangmukaT', 'pendaftaran_id'),
			'pasienmasukpenunjangTs' => array(self::HAS_MANY, 'PasienmasukpenunjangT', 'pendaftaran_id'),
			'pasienmasukpenunjang'=>array(self::HAS_ONE, 'PasienmasukpenunjangT', 'pendaftaran_id'),
			'pasienadmisiTs' => array(self::HAS_MANY, 'PasienadmisiT', 'pendaftaran_id'),
			'pasienpulangTs' => array(self::HAS_MANY, 'PasienpulangT', 'pendaftaran_id'),
			'dietpasienTs' => array(self::HAS_MANY, 'DietpasienT', 'pendaftaran_id'),
			'peminjamanrmTs' => array(self::HAS_MANY, 'PeminjamanrmT', 'pendaftaran_id'),
			'pengirimanrmTs' => array(self::HAS_MANY, 'PengirimanrmT', 'pendaftaran_id'),
			'hasilpemeriksaanpaTs' => array(self::HAS_MANY, 'HasilpemeriksaanpaT', 'pendaftaran_id'),
			'hasilpemeriksaanrmTs' => array(self::HAS_MANY, 'HasilpemeriksaanrmT', 'pendaftaran_id'),
			'hasilpemeriksaanlabTs' => array(self::HAS_MANY, 'HasilpemeriksaanlabT', 'pendaftaran_id'),
			'hasilpemeriksaanlab'=>array(self::HAS_ONE, 'HasilpemeriksaanlabT', 'pendaftaran_id'),
			'resepturTs' => array(self::HAS_MANY, 'ResepturT', 'pendaftaran_id'),
			'pasienkirimkeunitlainTs' => array(self::HAS_MANY, 'PasienkirimkeunitlainT', 'pendaftaran_id'),
			'kembalirmTs' => array(self::HAS_MANY, 'KembalirmT', 'pendaftaran_id'),
			'konsulpoliTs' => array(self::HAS_MANY, 'KonsulpoliT', 'pendaftaran_id'),
			'jadwalkunjunganrmTs' => array(self::HAS_MANY, 'JadwalkunjunganrmT', 'pendaftaran_id'),
			'kegbayitabungTs' => array(self::HAS_MANY, 'KegbayitabungT', 'pendaftaran_id'),
			'pasienmorbiditasTs' => array(self::HAS_MANY, 'PasienmorbiditasT', 'pendaftaran_id'),
			'pasienkecelakaanTs' => array(self::HAS_MANY, 'PasienkecelakaanT', 'pendaftaran_id'),
			'returresepTs' => array(self::HAS_MANY, 'ReturresepT', 'pendaftaran_id'),
			'pasienapachescoreTs' => array(self::HAS_MANY, 'PasienapachescoreT', 'pendaftaran_id'),
			'pasienimunisasiTs' => array(self::HAS_MANY, 'PasienimunisasiT', 'pendaftaran_id'),
			'pasienkbTs' => array(self::HAS_MANY, 'PasienkbT', 'pendaftaran_id'),
			'pindahkamarTs' => array(self::HAS_MANY, 'PindahkamarT', 'pendaftaran_id'),
			'pemeriksaanfisikTs' => array(self::HAS_MANY, 'PemeriksaanfisikT', 'pendaftaran_id'),
			'pemeriksaanfisik'=>array(self::HAS_ONE, 'PemeriksaanfisikT', 'pendaftaran_id'),
			'pesanmenudetailTs' => array(self::HAS_MANY, 'PesanmenudetailT', 'pendaftaran_id'),
			'pesanambulansTs' => array(self::HAS_MANY, 'PesanambulansT', 'pendaftaran_id'),
			'rencanaoperasiTs' => array(self::HAS_MANY, 'RencanaoperasiT', 'pendaftaran_id'),
			'rincianCetakans' => array(self::HAS_MANY, 'RincianCetakan', 'pendaftaran_id'),
			'suratketeranganRs' => array(self::HAS_MANY, 'SuratketeranganR', 'pendaftaran_id'),
			'ubahruanganRs' => array(self::HAS_MANY, 'UbahruanganR', 'pendaftaran_id'),
			'pemakaianambulansTs' => array(self::HAS_MANY, 'PemakaianambulansT', 'pendaftaran_id'),
			'tindakanpelayananTs' => array(self::HAS_MANY, 'TindakanpelayananT', 'pendaftaran_id'),
			'pasiendirujukkeluarTs' => array(self::HAS_MANY, 'PasiendirujukkeluarT', 'pendaftaran_id'),
			'odontogramdetailTs' => array(self::HAS_MANY, 'OdontogramdetailT', 'pendaftaran_id'),
			'pasienanastesiTs' => array(self::HAS_MANY, 'PasienanastesiT', 'pendaftaran_id'),
			'pembklaimdetalTs' => array(self::HAS_MANY, 'PembklaimdetalT', 'pendaftaran_id'),
			'periksakehamilanTs' => array(self::HAS_MANY, 'PeriksakehamilanT', 'pendaftaran_id'),
			'persalinanTs' => array(self::HAS_MANY, 'PersalinanT', 'pendaftaran_id'),
			'asuhankeperawatanTs' => array(self::HAS_MANY, 'AsuhankeperawatanT', 'pendaftaran_id'),
			'antrian' => array(self::BELONGS_TO, 'AntrianT', 'antrian_id'),
			'carabayar' => array(self::BELONGS_TO, 'CarabayarM', 'carabayar_id'),
			'caramasuk' => array(self::BELONGS_TO, 'CaramasukM', 'caramasuk_id'),
			'golonganumur' => array(self::BELONGS_TO, 'GolonganumurM', 'golonganumur_id'),
			'instalasi' => array(self::BELONGS_TO, 'InstalasiM', 'instalasi_id'),
			'kasuspenyakit'=>array(self::BELONGS_TO,'JeniskasuspenyakitM','jeniskasuspenyakit_id'),
			'jeniskasuspenyakit' => array(self::BELONGS_TO, 'JeniskasuspenyakitM', 'jeniskasuspenyakit_id'),
			'karcis' => array(self::BELONGS_TO, 'KarcisM', 'karcis_id'),
			'kelaspelayanan' => array(self::BELONGS_TO, 'KelaspelayananM', 'kelaspelayanan_id'),
			'kelompokumur' => array(self::BELONGS_TO, 'KelompokumurM', 'kelompokumur_id'),
			'pasien' => array(self::BELONGS_TO, 'PasienM', 'pasien_id'),
			'pasienbatalperiksa' => array(self::BELONGS_TO, 'PasienbatalperiksaR', 'pasienbatalperiksa_id'),
			'pasienpulang' => array(self::BELONGS_TO, 'PasienpulangT', 'pasienpulang_id'),
			'pegawai' => array(self::BELONGS_TO, 'PegawaiM', 'pegawai_id'),
			'peminjamanrm' => array(self::BELONGS_TO, 'PeminjamanrmT', 'peminjamanrm_id'),
			'penanggungjawab' => array(self::BELONGS_TO, 'PenanggungjawabM', 'penanggungjawab_id'),
			'penanggungJawab' => array(self::BELONGS_TO, 'PenanggungjawabM', 'penanggungjawab_id'),
			'pengirimanrm' => array(self::BELONGS_TO, 'PengirimanrmT', 'pengirimanrm_id'),
			'penjamin' => array(self::BELONGS_TO, 'PenjaminpasienM', 'penjamin_id'),
			'persalinan' => array(self::BELONGS_TO, 'PersalinanT', 'persalinan_id'),
			'ruangan' => array(self::BELONGS_TO, 'RuanganM', 'ruangan_id'),
			'rujukan' => array(self::BELONGS_TO, 'RujukanT', 'rujukan_id'),
			'shift' => array(self::BELONGS_TO, 'ShiftM', 'shift_id'),
			'hasilpemeriksaanradTs' => array(self::HAS_MANY, 'HasilpemeriksaanradT', 'pendaftaran_id'),
			'kirimmenupasienTs' => array(self::HAS_MANY, 'KirimmenupasienT', 'pendaftaran_id'),
			'pasiennapzaTs' => array(self::HAS_MANY, 'PasiennapzaT', 'pendaftaran_id'),
			'pembayaranpelayanan'=>array(self::HAS_MANY,'PembayaranpelayananT','pembayaranpelayanan_id'),
			'obatalkespasien'=>array(self::HAS_MANY,'ObatalkespasienT','pendaftaran_id'),
            'tindakanpelayanan'=>array(self::HAS_MANY,'TindakanpelayananT','pendaftaran_id'),
			'dokter'=>array(self::BELONGS_TO,'PegawaiM','pegawai_id'),
			'kirimkeunitlain'=>array(self::HAS_MANY, 'PasienkirimkeunitlainT', 'pendaftaran_id'),
			'diagnosa'=>array(self::HAS_MANY, 'PasienmorbiditasT', 'pendaftaran_id'),
			'sepTs'=>array(self::BELONGS_TO, 'SepT', 'sep_id'),
                        'ruangankontrol'=>array(self::BELONGS_TO, 'RuanganM', 'ruangankontrol_id'),
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
			'no_pendaftaran' => 'No Pendaftaran',
			'tgl_pendaftaran' => 'Tgl Pendaftaran',
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
			'tglrenkontrol' => 'Tgl Rencana Kontrol',
			'statusfarmasi' => 'Status Farmasi',
			'no_rekam_medik'=>'No Rekam Medik',
			'sep_id'=>'SEP',
                        'ruangankontrol_id'=>'Polik Kontrol',
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

		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('pasienpulang_id',$this->pasienpulang_id);
		$criteria->compare('pasienbatalperiksa_id',$this->pasienbatalperiksa_id);
		$criteria->compare('penanggungjawab_id',$this->penanggungjawab_id);
		$criteria->compare('penjamin_id',$this->penjamin_id);
		$criteria->compare('shift_id',$this->shift_id);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('persalinan_id',$this->persalinan_id);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('instalasi_id',$this->instalasi_id);
		$criteria->compare('caramasuk_id',$this->caramasuk_id);
		$criteria->compare('pengirimanrm_id',$this->pengirimanrm_id);
		$criteria->compare('peminjamanrm_id',$this->peminjamanrm_id);
		$criteria->compare('jeniskasuspenyakit_id',$this->jeniskasuspenyakit_id);
		$criteria->compare('pembayaranpelayanan_id',$this->pembayaranpelayanan_id);
		$criteria->compare('kelaspelayanan_id',$this->kelaspelayanan_id);
		$criteria->compare('carabayar_id',$this->carabayar_id);
		$criteria->compare('pasienadmisi_id',$this->pasienadmisi_id);
		$criteria->compare('kelompokumur_id',$this->kelompokumur_id);
		$criteria->compare('golonganumur_id',$this->golonganumur_id);
		$criteria->compare('rujukan_id',$this->rujukan_id);
		$criteria->compare('antrian_id',$this->antrian_id);
		$criteria->compare('karcis_id',$this->karcis_id);
		$criteria->compare('ruangan_id',$this->ruangan_id);
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
		$criteria->compare('sep_id',$this->sep_id);

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
        
        public function setStatusPeriksa($status) {
                // var_dump($this->attributes, $status); die;
                $a = PasienadmisiT::model()->findByAttributes(array(
                    'pendaftaran_id'=>$this->pendaftaran_id,
                ));
                $p = PasienpulangT::model()->findByAttributes(array(
                    'pendaftaran_id'=>$this->pendaftaran_id,
                ), array(
                    'condition'=>'pasienbatalpulang_id is null',
                ));
                
                $pj = PasienmasukpenunjangT::model()->findByAttributes(array(
                    'pendaftaran_id'=>$this->pendaftaran_id,
                    'ruangan_id' => Yii::app()->user->getState('ruangan_id'),
                    'pasienkirimkeunitlain_id' => NULL,
                ),array('order'=>'pasienmasukpenunjang_id DESC'));
                                   
                
                if (empty($a) && empty($p)) {
                    
                    $this->statusperiksa = $status;                    
                    
                    if (Yii::app()->user->getState('ruangan_id') == Params::RUANGAN_ID_FISIOTERAPI){                                                
                        if (count($pj)>0){                            
                            $updateStatusPeriksa=PasienmasukpenunjangT::model()->updateByPk($pj->pasienmasukpenunjang_id,array('statusperiksa'=>$status));
                        }
                    }
                    
                    return $this->save();
                }
                
                return true;
        }
        
        public function getColumn($prefix=''){
            $sql = " select column_name from information_schema.columns where column_name ilike 'nopendaftaran_%' AND table_name = 'konfigsystem_k' ORDER BY column_name ASC";
            $column = Yii::app()->db->createCommand($sql)->queryAll();
            $totCol = count($column);
                        
            $col = "";
            $col2 = array();
            foreach ($column as $data){
                $col .= $data['column_name'].', ';
                $col2[]=$data['column_name']; 
            }
            $col = rtrim($col, ', ');
            
            $criteria = new CDbCriteria();
            $criteria->select  = " ".$col." ";
            $hasil = KonfigsystemK::model()->find($criteria);
                
            $value = array();
            if (count($prefix)>1){
                $value['empty'] = '-- Pilih --';
            }
            for($i=0; $i<$totCol;$i++){      
                if (!empty($prefix)>0){                
                    foreach($prefix as $pr){
                        if (isset($pr)){
                            if ($pr == $hasil->$col2[$i])
                            {                            
                                $value[$hasil->$col2[$i]]= $hasil->$col2[$i];                
                            }else{
                             // tidak melakukan apa2 /skip   
                            }
                        }
                    }
                }
            }
                                                
            return $value;
            
        }
}