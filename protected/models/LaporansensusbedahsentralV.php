<?php

/**
 * This is the model class for table "laporansensusbedahsentral_v".
 *
 * The followings are the available columns in table 'laporansensusbedahsentral_v':
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
 * @property string $no_rekam_medik
 * @property string $tgl_rekam_medik
 * @property integer $pendaftaran_id
 * @property string $no_pendaftaran
 * @property string $tgl_pendaftaran
 * @property string $umur
 * @property integer $kelaspelayanan_id
 * @property string $kelaspelayanan_nama
 * @property string $no_masukpenunjang
 * @property string $tglmasukpenunjang
 * @property integer $pasienadmisi_id
 * @property string $kunjungan
 * @property integer $pasienkirimkeunitlain_id
 * @property integer $carabayar_id
 * @property string $carabayar_nama
 * @property integer $penjamin_id
 * @property string $penjamin_nama
 * @property integer $daftartindakan_id
 * @property string $daftartindakan_nama
 * @property integer $operasi_id
 * @property string $operasi_kode
 * @property string $operasi_nama
 * @property integer $kegiatanoperasi_id
 * @property string $kegiatanoperasi_kode
 * @property string $kegiatanoperasi_nama
 * @property integer $golonganoperasi_id
 * @property string $golonganoperasi_nama
 * @property string $dokterpelaksana1_id
 * @property string $dokteranastesi_id
 * @property string $mulaioperasi
 * @property integer $anastesi_id
 * @property string $anastesi_nama
 * @property integer $jenisanastesi_id
 * @property string $jenisanastesi_nama
 * @property integer $dokteroperator_peg_id
 * @property string $dokteroperator_glrdepan
 * @property string $dokteroperator_nama
 * @property string $dokteroperator_glrblkg
 * @property integer $dokteranastesi_peg_id
 * @property string $dokteranastesi_glrdepan
 * @property string $dokteranastesi_nama
 * @property string $dokteranastesi_glrblkg
 * @property integer $dokterkonsul_peg_id
 * @property string $dokterkonsul_glrdepan
 * @property string $dokterkonsul_nama
 * @property string $dokterkonsul_glrblkg
 * @property boolean $is_admisi
 * @property integer $diagnosa_id
 * @property string $diagnosa_kode
 * @property string $diagnosa_nama
 * @property integer $ruanganasal_id
 * @property string $ruanganasal_nama
 * @property integer $ruanganpenunj_id
 * @property string $ruanganpenunj_nama
 * @property integer $instalasiasal_id
 * @property string $instalasiasal_nama
 */
class LaporansensusbedahsentralV extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return LaporansensusbedahsentralV the static model class
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
		return 'laporansensusbedahsentral_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pasien_id, pendaftaran_id, kelaspelayanan_id, pasienadmisi_id, pasienkirimkeunitlain_id, carabayar_id, penjamin_id, daftartindakan_id, operasi_id, kegiatanoperasi_id, golonganoperasi_id, anastesi_id, jenisanastesi_id, dokteroperator_peg_id, dokteranastesi_peg_id, dokterkonsul_peg_id, diagnosa_id, ruanganasal_id, ruanganpenunj_id, instalasiasal_id', 'numerical', 'integerOnly'=>true),
			array('jenisidentitas, namadepan, jeniskelamin, no_pendaftaran, no_masukpenunjang, operasi_kode, kegiatanoperasi_kode', 'length', 'max'=>20),
			array('no_identitas_pasien, umur', 'length', 'max'=>30),
			array('nama_pasien, nama_bin, kelaspelayanan_nama, kunjungan, carabayar_nama, penjamin_nama, golonganoperasi_nama, anastesi_nama, jenisanastesi_nama, dokteroperator_nama, dokteranastesi_nama, dokterkonsul_nama, ruanganasal_nama, ruanganpenunj_nama, instalasiasal_nama', 'length', 'max'=>50),
			array('tempat_lahir', 'length', 'max'=>25),
			array('no_rekam_medik, dokteroperator_glrdepan, dokteranastesi_glrdepan, dokterkonsul_glrdepan, diagnosa_kode', 'length', 'max'=>10),
			array('daftartindakan_nama, operasi_nama, diagnosa_nama', 'length', 'max'=>200),
			array('kegiatanoperasi_nama', 'length', 'max'=>100),
			array('dokteroperator_glrblkg, dokteranastesi_glrblkg, dokterkonsul_glrblkg', 'length', 'max'=>15),
			array('tanggal_lahir, alamat_pasien, tgl_rekam_medik, tgl_pendaftaran, tglmasukpenunjang, dokterpelaksana1_id, dokteranastesi_id, mulaioperasi, is_admisi', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pasien_id, jenisidentitas, no_identitas_pasien, namadepan, nama_pasien, nama_bin, jeniskelamin, tempat_lahir, tanggal_lahir, alamat_pasien, no_rekam_medik, tgl_rekam_medik, pendaftaran_id, no_pendaftaran, tgl_pendaftaran, umur, kelaspelayanan_id, kelaspelayanan_nama, no_masukpenunjang, tglmasukpenunjang, pasienadmisi_id, kunjungan, pasienkirimkeunitlain_id, carabayar_id, carabayar_nama, penjamin_id, penjamin_nama, daftartindakan_id, daftartindakan_nama, operasi_id, operasi_kode, operasi_nama, kegiatanoperasi_id, kegiatanoperasi_kode, kegiatanoperasi_nama, golonganoperasi_id, golonganoperasi_nama, dokterpelaksana1_id, dokteranastesi_id, mulaioperasi, anastesi_id, anastesi_nama, jenisanastesi_id, jenisanastesi_nama, dokteroperator_peg_id, dokteroperator_glrdepan, dokteroperator_nama, dokteroperator_glrblkg, dokteranastesi_peg_id, dokteranastesi_glrdepan, dokteranastesi_nama, dokteranastesi_glrblkg, dokterkonsul_peg_id, dokterkonsul_glrdepan, dokterkonsul_nama, dokterkonsul_glrblkg, is_admisi, diagnosa_id, diagnosa_kode, diagnosa_nama, ruanganasal_id, ruanganasal_nama, ruanganpenunj_id, ruanganpenunj_nama, instalasiasal_id, instalasiasal_nama', 'safe', 'on'=>'search'),
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
			'jenisidentitas' => 'Jenisidentitas',
			'no_identitas_pasien' => 'No Identitas Pasien',
			'namadepan' => 'Namadepan',
			'nama_pasien' => 'Nama Pasien',
			'nama_bin' => 'Nama Bin',
			'jeniskelamin' => 'Jeniskelamin',
			'tempat_lahir' => 'Tempat Lahir',
			'tanggal_lahir' => 'Tanggal Lahir',
			'alamat_pasien' => 'Alamat Pasien',
			'no_rekam_medik' => 'No Rekam Medik',
			'tgl_rekam_medik' => 'Tgl Rekam Medik',
			'pendaftaran_id' => 'Pendaftaran',
			'no_pendaftaran' => 'No Pendaftaran',
			'tgl_pendaftaran' => 'Tgl Pendaftaran',
			'umur' => 'Umur',
			'kelaspelayanan_id' => 'Kelaspelayanan',
			'kelaspelayanan_nama' => 'Kelaspelayanan Nama',
			'no_masukpenunjang' => 'No Masukpenunjang',
			'tglmasukpenunjang' => 'Tglmasukpenunjang',
			'pasienadmisi_id' => 'Pasienadmisi',
			'kunjungan' => 'Kunjungan',
			'pasienkirimkeunitlain_id' => 'Pasienkirimkeunitlain',
			'carabayar_id' => 'Carabayar',
			'carabayar_nama' => 'Carabayar Nama',
			'penjamin_id' => 'Penjamin',
			'penjamin_nama' => 'Penjamin Nama',
			'daftartindakan_id' => 'Daftartindakan',
			'daftartindakan_nama' => 'Daftartindakan Nama',
			'operasi_id' => 'Operasi',
			'operasi_kode' => 'Operasi Kode',
			'operasi_nama' => 'Operasi Nama',
			'kegiatanoperasi_id' => 'Kegiatanoperasi',
			'kegiatanoperasi_kode' => 'Kegiatanoperasi Kode',
			'kegiatanoperasi_nama' => 'Kegiatanoperasi Nama',
			'golonganoperasi_id' => 'Golonganoperasi',
			'golonganoperasi_nama' => 'Golonganoperasi Nama',
			'dokterpelaksana1_id' => 'Dokterpelaksana1',
			'dokteranastesi_id' => 'Dokteranastesi',
			'mulaioperasi' => 'Mulaioperasi',
			'anastesi_id' => 'Anastesi',
			'anastesi_nama' => 'Anastesi Nama',
			'jenisanastesi_id' => 'Jenisanastesi',
			'jenisanastesi_nama' => 'Jenisanastesi Nama',
			'dokteroperator_peg_id' => 'Dokteroperator Peg',
			'dokteroperator_glrdepan' => 'Dokteroperator Glrdepan',
			'dokteroperator_nama' => 'Dokteroperator Nama',
			'dokteroperator_glrblkg' => 'Dokteroperator Glrblkg',
			'dokteranastesi_peg_id' => 'Dokteranastesi Peg',
			'dokteranastesi_glrdepan' => 'Dokteranastesi Glrdepan',
			'dokteranastesi_nama' => 'Dokteranastesi Nama',
			'dokteranastesi_glrblkg' => 'Dokteranastesi Glrblkg',
			'dokterkonsul_peg_id' => 'Dokterkonsul Peg',
			'dokterkonsul_glrdepan' => 'Dokterkonsul Glrdepan',
			'dokterkonsul_nama' => 'Dokterkonsul Nama',
			'dokterkonsul_glrblkg' => 'Dokterkonsul Glrblkg',
			'is_admisi' => 'Is Admisi',
			'diagnosa_id' => 'Diagnosa',
			'diagnosa_kode' => 'Diagnosa Kode',
			'diagnosa_nama' => 'Diagnosa Nama',
			'ruanganasal_id' => 'Ruanganasal',
			'ruanganasal_nama' => 'Ruanganasal Nama',
			'ruanganpenunj_id' => 'Ruanganpenunj',
			'ruanganpenunj_nama' => 'Ruanganpenunj Nama',
			'instalasiasal_id' => 'Instalasiasal',
			'instalasiasal_nama' => 'Instalasiasal Nama',
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
		$criteria->compare('jenisidentitas',$this->jenisidentitas,true);
		$criteria->compare('no_identitas_pasien',$this->no_identitas_pasien,true);
		$criteria->compare('namadepan',$this->namadepan,true);
		$criteria->compare('nama_pasien',$this->nama_pasien,true);
		$criteria->compare('nama_bin',$this->nama_bin,true);
		$criteria->compare('jeniskelamin',$this->jeniskelamin,true);
		$criteria->compare('tempat_lahir',$this->tempat_lahir,true);
		$criteria->compare('tanggal_lahir',$this->tanggal_lahir,true);
		$criteria->compare('alamat_pasien',$this->alamat_pasien,true);
		$criteria->compare('no_rekam_medik',$this->no_rekam_medik,true);
		$criteria->compare('tgl_rekam_medik',$this->tgl_rekam_medik,true);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('no_pendaftaran',$this->no_pendaftaran,true);
		$criteria->compare('tgl_pendaftaran',$this->tgl_pendaftaran,true);
		$criteria->compare('umur',$this->umur,true);
		$criteria->compare('kelaspelayanan_id',$this->kelaspelayanan_id);
		$criteria->compare('kelaspelayanan_nama',$this->kelaspelayanan_nama,true);
		$criteria->compare('no_masukpenunjang',$this->no_masukpenunjang,true);
		$criteria->compare('tglmasukpenunjang',$this->tglmasukpenunjang,true);
		$criteria->compare('pasienadmisi_id',$this->pasienadmisi_id);
		$criteria->compare('kunjungan',$this->kunjungan,true);
		$criteria->compare('pasienkirimkeunitlain_id',$this->pasienkirimkeunitlain_id);
		$criteria->compare('carabayar_id',$this->carabayar_id);
		$criteria->compare('carabayar_nama',$this->carabayar_nama,true);
		$criteria->compare('penjamin_id',$this->penjamin_id);
		$criteria->compare('penjamin_nama',$this->penjamin_nama,true);
		$criteria->compare('daftartindakan_id',$this->daftartindakan_id);
		$criteria->compare('daftartindakan_nama',$this->daftartindakan_nama,true);
		$criteria->compare('operasi_id',$this->operasi_id);
		$criteria->compare('operasi_kode',$this->operasi_kode,true);
		$criteria->compare('operasi_nama',$this->operasi_nama,true);
		$criteria->compare('kegiatanoperasi_id',$this->kegiatanoperasi_id);
		$criteria->compare('kegiatanoperasi_kode',$this->kegiatanoperasi_kode,true);
		$criteria->compare('kegiatanoperasi_nama',$this->kegiatanoperasi_nama,true);
		$criteria->compare('golonganoperasi_id',$this->golonganoperasi_id);
		$criteria->compare('golonganoperasi_nama',$this->golonganoperasi_nama,true);
		$criteria->compare('dokterpelaksana1_id',$this->dokterpelaksana1_id,true);
		$criteria->compare('dokteranastesi_id',$this->dokteranastesi_id,true);
		$criteria->compare('mulaioperasi',$this->mulaioperasi,true);
		$criteria->compare('anastesi_id',$this->anastesi_id);
		$criteria->compare('anastesi_nama',$this->anastesi_nama,true);
		$criteria->compare('jenisanastesi_id',$this->jenisanastesi_id);
		$criteria->compare('jenisanastesi_nama',$this->jenisanastesi_nama,true);
		$criteria->compare('dokteroperator_peg_id',$this->dokteroperator_peg_id);
		$criteria->compare('dokteroperator_glrdepan',$this->dokteroperator_glrdepan,true);
		$criteria->compare('dokteroperator_nama',$this->dokteroperator_nama,true);
		$criteria->compare('dokteroperator_glrblkg',$this->dokteroperator_glrblkg,true);
		$criteria->compare('dokteranastesi_peg_id',$this->dokteranastesi_peg_id);
		$criteria->compare('dokteranastesi_glrdepan',$this->dokteranastesi_glrdepan,true);
		$criteria->compare('dokteranastesi_nama',$this->dokteranastesi_nama,true);
		$criteria->compare('dokteranastesi_glrblkg',$this->dokteranastesi_glrblkg,true);
		$criteria->compare('dokterkonsul_peg_id',$this->dokterkonsul_peg_id);
		$criteria->compare('dokterkonsul_glrdepan',$this->dokterkonsul_glrdepan,true);
		$criteria->compare('dokterkonsul_nama',$this->dokterkonsul_nama,true);
		$criteria->compare('dokterkonsul_glrblkg',$this->dokterkonsul_glrblkg,true);
		$criteria->compare('is_admisi',$this->is_admisi);
		$criteria->compare('diagnosa_id',$this->diagnosa_id);
		$criteria->compare('diagnosa_kode',$this->diagnosa_kode,true);
		$criteria->compare('diagnosa_nama',$this->diagnosa_nama,true);
		$criteria->compare('ruanganasal_id',$this->ruanganasal_id);
		$criteria->compare('ruanganasal_nama',$this->ruanganasal_nama,true);
		$criteria->compare('ruanganpenunj_id',$this->ruanganpenunj_id);
		$criteria->compare('ruanganpenunj_nama',$this->ruanganpenunj_nama,true);
		$criteria->compare('instalasiasal_id',$this->instalasiasal_id);
		$criteria->compare('instalasiasal_nama',$this->instalasiasal_nama,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}