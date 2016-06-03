<?php

/**
 * This is the model class for table "lappengkajiankep_v".
 *
 * The followings are the available columns in table 'lappengkajiankep_v':
 * @property integer $pengkajianaskep_id
 * @property integer $pendaftaran_id
 * @property integer $ruangan_id
 * @property string $pengkajianaskep_tgl
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 * @property string $no_pengkajian
 * @property integer $anamesa_id
 * @property integer $pemeriksaanfisik_id
 * @property string $no_pendaftaran
 * @property string $nama_pasien
 * @property string $jeniskelamin
 * @property string $ruangan_nama
 * @property integer $kelaspelayanan_id
 * @property string $kelaspelayanan_nama
 * @property string $kamarruangan_nokamar
 * @property string $kamarruangan_nobed
 * @property integer $kamarruangan_id
 * @property integer $pegawai_id
 * @property string $nama_pegawai
 */
class LappengkajiankepV extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return LappengkajiankepV the static model class
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
		return 'lappengkajiankep_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pengkajianaskep_id, pendaftaran_id, ruangan_id, anamesa_id, pemeriksaanfisik_id, kelaspelayanan_id, kamarruangan_id, pegawai_id', 'numerical', 'integerOnly'=>true),
			array('no_pengkajian, no_pendaftaran, jeniskelamin', 'length', 'max'=>20),
			array('nama_pasien, ruangan_nama, kelaspelayanan_nama, nama_pegawai', 'length', 'max'=>50),
			array('kamarruangan_nokamar', 'length', 'max'=>25),
			array('kamarruangan_nobed', 'length', 'max'=>10),
			array('pengkajianaskep_tgl, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pengkajianaskep_id, pendaftaran_id, ruangan_id, pengkajianaskep_tgl, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, no_pengkajian, anamesa_id, pemeriksaanfisik_id, no_pendaftaran, nama_pasien, jeniskelamin, ruangan_nama, kelaspelayanan_id, kelaspelayanan_nama, kamarruangan_nokamar, kamarruangan_nobed, kamarruangan_id, pegawai_id, nama_pegawai', 'safe', 'on'=>'search'),
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
			'pengkajianaskep_id' => 'Pengkajianaskep',
			'pendaftaran_id' => 'Pendaftaran',
			'ruangan_id' => 'Ruangan',
			'pengkajianaskep_tgl' => 'Pengkajianaskep Tgl',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'create_loginpemakai_id' => 'Create Loginpemakai',
			'update_loginpemakai_id' => 'Update Loginpemakai',
			'create_ruangan' => 'Create Ruangan',
			'no_pengkajian' => 'No Pengkajian',
			'anamesa_id' => 'Anamesa',
			'pemeriksaanfisik_id' => 'Pemeriksaanfisik',
			'no_pendaftaran' => 'No Pendaftaran',
			'nama_pasien' => 'Nama Pasien',
			'jeniskelamin' => 'Jeniskelamin',
			'ruangan_nama' => 'Ruangan Nama',
			'kelaspelayanan_id' => 'Kelaspelayanan',
			'kelaspelayanan_nama' => 'Kelaspelayanan Nama',
			'kamarruangan_nokamar' => 'Kamarruangan Nokamar',
			'kamarruangan_nobed' => 'Kamarruangan Nobed',
			'kamarruangan_id' => 'Kamarruangan',
			'pegawai_id' => 'Pegawai',
			'nama_pegawai' => 'Nama Pegawai',
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

		$criteria->compare('pengkajianaskep_id',$this->pengkajianaskep_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('pengkajianaskep_tgl',$this->pengkajianaskep_tgl,true);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id,true);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id,true);
		$criteria->compare('create_ruangan',$this->create_ruangan,true);
		$criteria->compare('no_pengkajian',$this->no_pengkajian,true);
		$criteria->compare('anamesa_id',$this->anamesa_id);
		$criteria->compare('pemeriksaanfisik_id',$this->pemeriksaanfisik_id);
		$criteria->compare('no_pendaftaran',$this->no_pendaftaran,true);
		$criteria->compare('nama_pasien',$this->nama_pasien,true);
		$criteria->compare('jeniskelamin',$this->jeniskelamin,true);
		$criteria->compare('ruangan_nama',$this->ruangan_nama,true);
		$criteria->compare('kelaspelayanan_id',$this->kelaspelayanan_id);
		$criteria->compare('kelaspelayanan_nama',$this->kelaspelayanan_nama,true);
		$criteria->compare('kamarruangan_nokamar',$this->kamarruangan_nokamar,true);
		$criteria->compare('kamarruangan_nobed',$this->kamarruangan_nobed,true);
		$criteria->compare('kamarruangan_id',$this->kamarruangan_id);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('nama_pegawai',$this->nama_pegawai,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}