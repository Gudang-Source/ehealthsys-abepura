<?php

/**
 * This is the model class for table "inforencanaaskep_v".
 *
 */
class ASInfoimplementasiaskepV extends InfoimplementasiaskepV
{
	public $tgl_awal,$tgl_akhir,$instalasi_id;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InforencanaaskepV the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'implementasiaskep_id' => 'Implementasiaskep',
			'no_implementasi' => 'No Implementasi',
			'implementasiaskep_tgl' => 'Implementasiaskep Tgl',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'create_loginpemakai_id' => 'Create Loginpemakai',
			'update_loginpemakai_id' => 'Update Loginpemakai',
			'create_ruangan' => 'Create Ruangan',
			'rencanaaskep_id' => 'Rencanaaskep',
			'ruangan_id' => 'Ruangan',
			'ruangan_nama' => 'Ruangan Nama',
			'kelaspelayanan_nama' => 'Kelaspelayanan Nama',
			'pasien_id' => 'Pasien',
			'nama_pasien' => 'Nama Pasien',
			'pegawai_id' => 'Pegawai',
			'nama_pegawai' => 'Nama Pegawai',
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

		$criteria->compare('implementasiaskep_id',$this->implementasiaskep_id);
		$criteria->compare('no_implementasi',$this->no_implementasi,true);
		$criteria->addBetweenCondition('DATE(implementasiaskep_tgl)', $this->tgl_awal, $this->tgl_akhir);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id,true);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id,true);
		$criteria->compare('create_ruangan',$this->create_ruangan,true);
		$criteria->compare('rencanaaskep_id',$this->rencanaaskep_id);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('ruangan_nama',$this->ruangan_nama,true);
		$criteria->compare('kelaspelayanan_nama',$this->kelaspelayanan_nama,true);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('nama_pasien',$this->nama_pasien,true);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('nama_pegawai',$this->nama_pegawai,true);
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

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}