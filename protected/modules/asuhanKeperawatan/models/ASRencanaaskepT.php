<?php
class ASRencanaaskepT extends RencanaaskepT
{
        public $nama_pegawai,$no_pengkajian,$ruangan_nama,$nama_pasien,$diagnosakep_nama,$iskeperawatan;
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
        
        public function getNoKamar($pendaftaran_id) {
		$no_kamar = '-';
		if (!empty($pendaftaran_id)) {
			$kamar = KamarruanganM::model()->findBySql('
			SELECT kamarruangan_m.kamarruangan_nokamar
			FROM kamarruangan_m
			JOIN masukkamar_t ON kamarruangan_m.kamarruangan_id = masukkamar_t.kamarruangan_id
			JOIN pasienadmisi_t ON pasienadmisi_t.pasienadmisi_id = masukkamar_t.pasienadmisi_id
			JOIN pendaftaran_t ON pendaftaran_t.pendaftaran_id = pasienadmisi_t.pendaftaran_id
			WHERE pendaftaran_t.pendaftaran_id = ' . $pendaftaran_id);
			if (count($kamar)) {
				$no_kamar = $kamar->kamarruangan_nokamar;
			}
		}
		return $no_kamar;
	}

	public function getNoBed($pendaftaran_id) {
		
		$no_bed = '-';
		if (!empty($pendaftaran_id)) {
			$kamar = KamarruanganM::model()->findBySql('
			SELECT kamarruangan_m.kamarruangan_nobed
			FROM kamarruangan_m
			JOIN masukkamar_t ON kamarruangan_m.kamarruangan_id = masukkamar_t.kamarruangan_id
			JOIN pasienadmisi_t ON pasienadmisi_t.pasienadmisi_id = masukkamar_t.pasienadmisi_id
			JOIN pendaftaran_t ON pendaftaran_t.pendaftaran_id = pasienadmisi_t.pendaftaran_id
			WHERE pendaftaran_t.pendaftaran_id = ' . $pendaftaran_id);
			if (count($kamar)) {
				$no_bed = $kamar->kamarruangan_nobed;
			}
		}
		return $pendaftaran_id;
	}

	public function getKelasPelayanan($pendaftaran_id) {

		$pelayanan = '-';
		if (!empty($pendaftaran_id)) {
			$kelas = KelaspelayananM::model()->findBySql('
			SELECT kelaspelayanan_m.kelaspelayanan_nama
			FROM kelaspelayanan_m
			JOIN masukkamar_t ON kelaspelayanan_m.kelaspelayanan_id = masukkamar_t.kelaspelayanan_id
			JOIN pasienadmisi_t ON pasienadmisi_t.pasienadmisi_id = masukkamar_t.pasienadmisi_id
			JOIN pendaftaran_t ON pendaftaran_t.pendaftaran_id = pasienadmisi_t.pendaftaran_id
			WHERE pendaftaran_t.pendaftaran_id = ' . $pendaftaran_id);
			if (count($kelas)) {
				$pelayanan = $kelas->kelaspelayanan_nama;
			}
		}

		return $pelayanan;
	}

	public function getDiagnosaMedis($pasien_id, $pendaftaran_id) {
		$nama = '-';

		if (!empty($pasien_id) && !empty($pendaftaran_id)) {
			$diagnosa = ASDiagnosaM::model()->findBySql('
			SELECT diagnosa_m.diagnosa_nama
			FROM diagnosa_m
			JOIN pasienmorbiditas_t ON pasienmorbiditas_t.diagnosa_id = diagnosa_m.diagnosa_id
			WHERE pasienmorbiditas_t.pasien_id = ' . $pasien_id . ' AND pendaftaran_id =' . $pendaftaran_id);
			if (count($diagnosa)) {
				$nama = $diagnosa->diagnosa_nama;
			}
		}
		return $nama;
	}

	public function getNamaDokter($pendaftaran_id) {
		$nama = '-';
		$dokter = ASPegawaiM::model()->findBySql('
			SELECT pegawai_m.nama_pegawai,pegawai_m.gelardepan,gelarbelakang_m.gelarbelakang_nama
			FROM pendaftaran_t 
			JOIN pegawai_m ON pegawai_m.pegawai_id = pendaftaran_t.pegawai_id
			LEFT JOIN gelarbelakang_m ON gelarbelakang_m.gelarbelakang_id = pegawai_m.gelarbelakang_id
			WHERE pendaftaran_id =' . $pendaftaran_id);
		if (count($dokter)) {
			$nama = (isset($dokter->gelardepan) ? $dokter->gelardepan : "") . (isset($dokter->nama_pegawai) ? $dokter->nama_pegawai : "") . (isset($dokter->gelarbelakang_nama) ? $dokter->gelarbelakang_nama : "");
		}
		return $nama;
	}
}