<?php
class ASRencanaaskepT extends RencanaaskepT
{
	public $nama_pegawai,$no_pengkajian,$ruangan_nama,$nama_pasien,$diagnosakep_nama,$notemp;
        public $no_pendaftaran;
        
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
			'rencanaaskep_id' => 'Rencanaaskep',
			'pengkajianaskep_id' => 'Pengkajianaskep',
			'pegawai_id' => 'Pegawai',
			'ruangan_id' => 'Ruangan',
			'no_rencana' => 'No Rencana',
			'rencanaaskep_tgl' => 'Tanggal Rencana',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'create_loginpemakai_id' => 'Create Loginpemakai',
			'update_loginpemakai_id' => 'Update Loginpemakai',
			'create_ruangan' => 'Create Ruangan',
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
		$criteria->with = array('pegawai','pengkajianaskep');
		$criteria->compare('rencanaaskep_id',$this->rencanaaskep_id);
		$criteria->compare('pengkajianaskep_id',$this->pengkajianaskep_id);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('no_rencana',$this->no_rencana,true);
		$criteria->compare('rencanaaskep_tgl',$this->rencanaaskep_tgl,true);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id,true);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id,true);
		$criteria->compare('create_ruangan',$this->create_ruangan,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	/**
		 * kriteria pencarian untuk dashboard
		 * @return \CActiveDataProvider
		 */
		public function searchDashboard()
		{
			// Warning: Please modify the following code to remove attributes that
			// should not be searched.

			$criteria=new CDbCriteria;
			$criteria->compare('DATE(rencanaaskep_tgl)', date("Y-m-d"));
			$criteria->order = 'rencanaaskep_tgl ASC';
			$criteria->limit = 10;
			return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
				'pagination'=>false
			));
		}
		
	public function searchDashboardAS(){
		// Warning: Please modify the following code to remove attributes that
			// should not be searched.

			$criteria=new CDbCriteria;
			$criteria->select = 't.no_rencana,t.rencanaaskep_tgl, pasien.nama_pasien, diagnosakep.diagnosakep_nama';
			$criteria->join = 'JOIN rencanaaskepdet_t AS rencanaaskepdet ON rencanaaskepdet.rencanaaskep_id= t.rencanaaskep_id
								JOIN diagnosakep_m AS diagnosakep ON diagnosakep.diagnosakep_id = rencanaaskepdet.diagnosakep_id
								JOIN pengkajianaskep_t AS pengkajianaskep ON pengkajianaskep.pengkajianaskep_id = t.pengkajianaskep_id
								JOIN pendaftaran_t AS pendaftaran ON pendaftaran.pendaftaran_id = pengkajianaskep.pendaftaran_id
								JOIN pasien_m AS pasien ON pasien.pasien_id = pendaftaran.pasien_id';
			$criteria->group = 'diagnosakep.diagnosakep_nama,pasien.nama_pasien,no_rencana,t.rencanaaskep_tgl';
			$criteria->order = 't.rencanaaskep_tgl desc';
			$criteria->limit = 10;
			return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
				'pagination'=>false
			));
	}
        
        public function searchRencanaKeperawatan()
        {
                $criteria=new CDbCriteria;
                $criteria->join = " LEFT JOIN implementasiaskep_t imple ON imple.rencanaaskep_id = t.rencanaaskep_id "
                                . " RIGHT  JOIN pengkajianaskep_t peng ON peng.pengkajianaskep_id = t.pengkajianaskep_id "
                                . " JOIN pendaftaran_t p ON p.pendaftaran_id = peng.pendaftaran_id "                                 
                                . " JOIN pegawai_m peg ON peg.pegawai_id = t.pegawai_id";		                
                $criteria->addCondition(' imple.rencanaaskep_id IS NULL');		
                $criteria->compare('LOWER(t.no_rencana)',  strtolower($this->no_rencana),true);
                $criteria->compare('LOWER(peng.no_pengkajian)',  strtolower($this->no_pengkajian),true);
                $criteria->compare('LOWER(peg.nama_pegawai)',  strtolower($this->nama_pegawai),true);
                if (!empty($this->rencanaaskep_tgl)){
                    $criteria->addCondition(" t.rencanaaskep_tgl = '".MyFormatter::formatDateTimeForDb($this->rencanaaskep_tgl)."' ");
                }
		if (!empty($this->ruangan_id)){
                    $criteria->addCondition(" t.ruangan_id = '".$this->ruangan_id."' ");
                }

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
        }
}