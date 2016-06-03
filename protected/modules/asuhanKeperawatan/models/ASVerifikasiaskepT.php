<?php
class ASVerifikasiaskepT extends VerifikasiaskepT
{

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
			'verifikasiaskep_id' => 'Verifikasiaskep',
			'pegawai_id' => 'Pegawai',
			'ruangan_id' => 'Ruangan',
			'verifikasiaskep_tgl' => 'Tgl Verifikasi',
			'verifikasiaskep_no' => 'No Verifikasi',
			'verifikasiaskep_ket' => 'Keterangan',
			'petugasverifikasi_nama' => 'Petugas Verifikasi',
			'mengetahui_nama' => 'Mengetahui',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'create_loginpemakai_id' => 'Create Loginpemakai',
			'update_loginpemakai_id' => 'Update Loginpemakai',
			'create_ruangan' => 'Create Ruangan',
			'verifikasiaskep_status' => 'Status',
			'pendaftaran_id' => 'Pendaftaran',
			'pengkajianaskep_id' => 'Pengkajianaskep',
			'rencanaaskep_id' => 'Rencanaaskep',
			'implementasiaskep_t' => 'Implementasiaskep T',
			'evaluasiaskep_t' => 'Evaluasiaskep T',
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

		$criteria->compare('verifikasiaskep_id',$this->verifikasiaskep_id);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('verifikasiaskep_tgl',$this->verifikasiaskep_tgl,true);
		$criteria->compare('verifikasiaskep_no',$this->verifikasiaskep_no,true);
		$criteria->compare('verifikasiaskep_ket',$this->verifikasiaskep_ket,true);
		$criteria->compare('petugasverifikasi_nama',$this->petugasverifikasi_nama,true);
		$criteria->compare('mengetahui_nama',$this->mengetahui_nama,true);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id,true);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id,true);
		$criteria->compare('create_ruangan',$this->create_ruangan,true);
		$criteria->compare('verifikasiaskep_status',$this->verifikasiaskep_status,true);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('pengkajianaskep_id',$this->pengkajianaskep_id);
		$criteria->compare('rencanaaskep_id',$this->rencanaaskep_id);
		$criteria->compare('implementasiaskep_t',$this->implementasiaskep_t);
		$criteria->compare('evaluasiaskep_t',$this->evaluasiaskep_t);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function searchPrint($verifikasiaskep_id)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->addCondition('verifikasiaskep_id ='.$verifikasiaskep_id);
//		$criteria->compare('pegawai_id',$this->pegawai_id);
//		$criteria->compare('ruangan_id',$this->ruangan_id);
//		$criteria->compare('verifikasiaskep_tgl',$this->verifikasiaskep_tgl,true);
//		$criteria->compare('verifikasiaskep_no',$this->verifikasiaskep_no,true);
//		$criteria->compare('verifikasiaskep_ket',$this->verifikasiaskep_ket,true);
//		$criteria->compare('petugasverifikasi_nama',$this->petugasverifikasi_nama,true);
//		$criteria->compare('mengetahui_nama',$this->mengetahui_nama,true);
//		$criteria->compare('create_time',$this->create_time,true);
//		$criteria->compare('update_time',$this->update_time,true);
//		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id,true);
//		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id,true);
//		$criteria->compare('create_ruangan',$this->create_ruangan,true);
//		$criteria->compare('verifikasiaskep_status',$this->verifikasiaskep_status,true);
//		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
//		$criteria->compare('pengkajianaskep_id',$this->pengkajianaskep_id);
//		$criteria->compare('rencanaaskep_id',$this->rencanaaskep_id);
//		$criteria->compare('implementasiaskep_t',$this->implementasiaskep_t);
//		$criteria->compare('evaluasiaskep_t',$this->evaluasiaskep_t);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}