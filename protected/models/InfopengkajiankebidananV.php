<?php

/**
 * This is the model class for table "infopengkajiankebidanan_v".
 *
 * The followings are the available columns in table 'infopengkajiankebidanan_v':
 * @property integer $pendaftaran_id
 * @property integer $ruangan_id
 * @property integer $anamesa_id
 * @property integer $pemeriksaanfisik_id
 * @property string $no_pengkajian
 * @property string $pengkajianaskep_tgl
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 * @property integer $pegawai_id
 * @property string $nama_pegawai
 * @property integer $pengkajianaskep_id
 * @property string $ruangan_nama
 * @property string $kelaspelayanan_nama
 * @property string $nama_pasien
 * @property string $no_pendaftaran
 * @property string $tgl_pendaftaran
 * @property string $no_rekam_medik
 * @property string $umur
 * @property string $statusperkawinan
 * @property string $jeniskelamin
 * @property string $pekerjaan_nama
 * @property string $pendidikan_nama
 * @property string $agama
 * @property string $alamat_pasien
 * @property string $kamarruangan_nokamar
 * @property string $kamarruangan_nobed
 * @property string $diagnosa_nama
 * @property string $nama_pj
 * @property string $no_identitas
 * @property string $tgllahir_pj
 * @property string $no_teleponpj
 * @property string $no_mobilepj
 * @property string $hubungankeluarga
 * @property string $alamat_pj
 * @property string $jk
 * @property integer $pasien_id
 * @property integer $kelaspelayanan_id
 * @property integer $penanggungjawab_id
 * @property integer $pasienadmisi_id
 * @property integer $instalasi_id
 * @property integer $masukkamar_id
 * @property integer $kamarruangan_id
 * @property integer $pekerjaan_id
 * @property integer $pendidikan_id
 * @property integer $pasienmorbiditas_id
 * @property integer $diagnosa_id
 */
class InfopengkajiankebidananV extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InfopengkajiankebidananV the static model class
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
		return 'infopengkajiankebidanan_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pendaftaran_id, ruangan_id, anamesa_id, pemeriksaanfisik_id, pegawai_id, pengkajianaskep_id, pasien_id, kelaspelayanan_id, penanggungjawab_id, pasienadmisi_id, instalasi_id, masukkamar_id, kamarruangan_id, pekerjaan_id, pendidikan_id, pasienmorbiditas_id, diagnosa_id', 'numerical', 'integerOnly'=>true),
			array('no_pengkajian, no_pendaftaran, statusperkawinan, jeniskelamin, agama, jk', 'length', 'max'=>20),
			array('nama_pegawai, ruangan_nama, kelaspelayanan_nama, nama_pasien, pekerjaan_nama, pendidikan_nama, nama_pj, no_identitas, hubungankeluarga', 'length', 'max'=>50),
			array('no_rekam_medik, kamarruangan_nobed', 'length', 'max'=>10),
			array('umur', 'length', 'max'=>30),
			array('kamarruangan_nokamar', 'length', 'max'=>25),
			array('diagnosa_nama', 'length', 'max'=>200),
			array('no_teleponpj, no_mobilepj', 'length', 'max'=>15),
			array('pengkajianaskep_tgl, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, tgl_pendaftaran, alamat_pasien, tgllahir_pj, alamat_pj', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pendaftaran_id, ruangan_id, anamesa_id, pemeriksaanfisik_id, no_pengkajian, pengkajianaskep_tgl, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, pegawai_id, nama_pegawai, pengkajianaskep_id, ruangan_nama, kelaspelayanan_nama, nama_pasien, no_pendaftaran, tgl_pendaftaran, no_rekam_medik, umur, statusperkawinan, jeniskelamin, pekerjaan_nama, pendidikan_nama, agama, alamat_pasien, kamarruangan_nokamar, kamarruangan_nobed, diagnosa_nama, nama_pj, no_identitas, tgllahir_pj, no_teleponpj, no_mobilepj, hubungankeluarga, alamat_pj, jk, pasien_id, kelaspelayanan_id, penanggungjawab_id, pasienadmisi_id, instalasi_id, masukkamar_id, kamarruangan_id, pekerjaan_id, pendidikan_id, pasienmorbiditas_id, diagnosa_id', 'safe', 'on'=>'search'),
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
			'pendaftaran_id' => 'Pendaftaran',
			'ruangan_id' => 'Ruangan',
			'anamesa_id' => 'Anamesa',
			'pemeriksaanfisik_id' => 'Pemeriksaanfisik',
			'no_pengkajian' => 'No Pengkajian',
			'pengkajianaskep_tgl' => 'Pengkajianaskep Tgl',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'create_loginpemakai_id' => 'Create Loginpemakai',
			'update_loginpemakai_id' => 'Update Loginpemakai',
			'create_ruangan' => 'Create Ruangan',
			'pegawai_id' => 'Pegawai',
			'nama_pegawai' => 'Nama Pegawai',
			'pengkajianaskep_id' => 'Pengkajianaskep',
			'ruangan_nama' => 'Ruangan Nama',
			'kelaspelayanan_nama' => 'Kelaspelayanan Nama',
			'nama_pasien' => 'Nama Pasien',
			'no_pendaftaran' => 'No Pendaftaran',
			'tgl_pendaftaran' => 'Tgl Pendaftaran',
			'no_rekam_medik' => 'No Rekam Medik',
			'umur' => 'Umur',
			'statusperkawinan' => 'Statusperkawinan',
			'jeniskelamin' => 'Jeniskelamin',
			'pekerjaan_nama' => 'Pekerjaan Nama',
			'pendidikan_nama' => 'Pendidikan Nama',
			'agama' => 'Agama',
			'alamat_pasien' => 'Alamat Pasien',
			'kamarruangan_nokamar' => 'Kamarruangan Nokamar',
			'kamarruangan_nobed' => 'Kamarruangan Nobed',
			'diagnosa_nama' => 'Diagnosa Nama',
			'nama_pj' => 'Nama Pj',
			'no_identitas' => 'No Identitas',
			'tgllahir_pj' => 'Tgllahir Pj',
			'no_teleponpj' => 'No Teleponpj',
			'no_mobilepj' => 'No Mobilepj',
			'hubungankeluarga' => 'Hubungankeluarga',
			'alamat_pj' => 'Alamat Pj',
			'jk' => 'Jk',
			'pasien_id' => 'Pasien',
			'kelaspelayanan_id' => 'Kelaspelayanan',
			'penanggungjawab_id' => 'Penanggungjawab',
			'pasienadmisi_id' => 'Pasienadmisi',
			'instalasi_id' => 'Instalasi',
			'masukkamar_id' => 'Masukkamar',
			'kamarruangan_id' => 'Kamarruangan',
			'pekerjaan_id' => 'Pekerjaan',
			'pendidikan_id' => 'Pendidikan',
			'pasienmorbiditas_id' => 'Pasienmorbiditas',
			'diagnosa_id' => 'Diagnosa',
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

		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('anamesa_id',$this->anamesa_id);
		$criteria->compare('pemeriksaanfisik_id',$this->pemeriksaanfisik_id);
		$criteria->compare('no_pengkajian',$this->no_pengkajian,true);
		$criteria->compare('pengkajianaskep_tgl',$this->pengkajianaskep_tgl,true);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id,true);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id,true);
		$criteria->compare('create_ruangan',$this->create_ruangan,true);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('nama_pegawai',$this->nama_pegawai,true);
		$criteria->compare('pengkajianaskep_id',$this->pengkajianaskep_id);
		$criteria->compare('ruangan_nama',$this->ruangan_nama,true);
		$criteria->compare('kelaspelayanan_nama',$this->kelaspelayanan_nama,true);
		$criteria->compare('nama_pasien',$this->nama_pasien,true);
		$criteria->compare('no_pendaftaran',$this->no_pendaftaran,true);
		$criteria->compare('tgl_pendaftaran',$this->tgl_pendaftaran,true);
		$criteria->compare('no_rekam_medik',$this->no_rekam_medik,true);
		$criteria->compare('umur',$this->umur,true);
		$criteria->compare('statusperkawinan',$this->statusperkawinan,true);
		$criteria->compare('jeniskelamin',$this->jeniskelamin,true);
		$criteria->compare('pekerjaan_nama',$this->pekerjaan_nama,true);
		$criteria->compare('pendidikan_nama',$this->pendidikan_nama,true);
		$criteria->compare('agama',$this->agama,true);
		$criteria->compare('alamat_pasien',$this->alamat_pasien,true);
		$criteria->compare('kamarruangan_nokamar',$this->kamarruangan_nokamar,true);
		$criteria->compare('kamarruangan_nobed',$this->kamarruangan_nobed,true);
		$criteria->compare('diagnosa_nama',$this->diagnosa_nama,true);
		$criteria->compare('nama_pj',$this->nama_pj,true);
		$criteria->compare('no_identitas',$this->no_identitas,true);
		$criteria->compare('tgllahir_pj',$this->tgllahir_pj,true);
		$criteria->compare('no_teleponpj',$this->no_teleponpj,true);
		$criteria->compare('no_mobilepj',$this->no_mobilepj,true);
		$criteria->compare('hubungankeluarga',$this->hubungankeluarga,true);
		$criteria->compare('alamat_pj',$this->alamat_pj,true);
		$criteria->compare('jk',$this->jk,true);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('kelaspelayanan_id',$this->kelaspelayanan_id);
		$criteria->compare('penanggungjawab_id',$this->penanggungjawab_id);
		$criteria->compare('pasienadmisi_id',$this->pasienadmisi_id);
		$criteria->compare('instalasi_id',$this->instalasi_id);
		$criteria->compare('masukkamar_id',$this->masukkamar_id);
		$criteria->compare('kamarruangan_id',$this->kamarruangan_id);
		$criteria->compare('pekerjaan_id',$this->pekerjaan_id);
		$criteria->compare('pendidikan_id',$this->pendidikan_id);
		$criteria->compare('pasienmorbiditas_id',$this->pasienmorbiditas_id);
		$criteria->compare('diagnosa_id',$this->diagnosa_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}