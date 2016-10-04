<?php
class ASPengkajianaskepT extends PengkajianaskepT
{
	public $nama_pegawai,$no_pendaftaran,$ruangan_nama, $notemp;
        
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
			'pengkajianaskep_id' => 'Pengkajianaskep',
			'pegawai_id' => 'Pegawai',
			'pendaftaran_id' => 'Pendaftaran',
			'ruangan_id' => 'Ruangan',
			'anamesa_id' => 'Anamesa',
			'pemeriksaanfisik_id' => 'Pemeriksaan Fisik',
			'no_pengkajian' => 'No. Pengkajian',
			'pengkajianaskep_tgl' => 'Tgl. Pengkajian',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'create_loginpemakai_id' => 'Create Loginpemakai',
			'update_loginpemakai_id' => 'Update Loginpemakai',
			'create_ruangan' => 'Create Ruangan',
			'verifikasiaskep_id' => 'Verifikasi Askep',
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
		$criteria->with = array('pegawai');
		$criteria->compare('pengkajianaskep_id',$this->pengkajianaskep_id);
		$criteria->compare('pegawai_id',$this->pegawai_id);
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
		$criteria->compare('verifikasiaskep_id',$this->verifikasiaskep_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
         public function searchPengkajian()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
                $criteria->join = " LEFT JOIN rencanaaskep_t renc ON renc.pengkajianaskep_id = t.pengkajianaskep_id "
                                . " JOIN pendaftaran_t p ON p.pendaftaran_id = t.pendaftaran_id "
                                . " JOIN pegawai_m peg ON peg.pegawai_id = t.pegawai_id";		                
                $criteria->addCondition(' renc.pengkajianaskep_id IS NULL');		
                $criteria->compare('LOWER(t.no_pengkajian)',  strtolower($this->no_pengkajian),true);
                $criteria->compare('LOWER(p.no_pendaftaran)',  strtolower($this->no_pendaftaran),true);
                $criteria->compare('LOWER(peg.nama_pegawai)',  strtolower($this->nama_pegawai),true);
                if (!empty($this->pengkajianaskep_tgl)){
                    $criteria->addCondition(" t.pengkajianaskep_tgl = '".MyFormatter::formatDateTimeForDb($this->pengkajianaskep_tgl)."' ");
                }
		if (!empty($this->ruangan_id)){
                    $criteria->addCondition(" t.ruangan_id = '".$this->ruangan_id."' ");
                }

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}