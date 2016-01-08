<?php
class AKLaporanneracaV extends LaporanneracaV
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return LaporanneracaV the static model class
	 */
	public static function model($className=__CLASS__)
	{
			return parent::model($className);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function searchNeraca()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		if(!empty($this->rekperiod_id)){
			$criteria->addCondition('rekperiod_id = '.$this->rekperiod_id);
		}
		$criteria->compare('LOWER(perideawal)',strtolower($this->perideawal),true);
		$criteria->compare('LOWER(sampaidgn)',strtolower($this->sampaidgn),true);
		$criteria->compare('LOWER(deskripsi)',strtolower($this->deskripsi),true);
		$criteria->compare('isclosing',$this->isclosing);
		if(!empty($this->konfiganggaran_id)){
			$criteria->addCondition('konfiganggaran_id = '.$this->konfiganggaran_id);
		}
		$criteria->compare('LOWER(deskripsiperiode)',strtolower($this->deskripsiperiode),true);
		$criteria->compare('LOWER(tglanggaran)',strtolower($this->tglanggaran),true);
		$criteria->compare('LOWER(sd_tglanggaran)',strtolower($this->sd_tglanggaran),true);
		$criteria->compare('LOWER(tglrencanaanggaran)',strtolower($this->tglrencanaanggaran),true);
		$criteria->compare('LOWER(sd_tglrencanaanggaran)',strtolower($this->sd_tglrencanaanggaran),true);
		$criteria->compare('LOWER(tglrevisianggaran)',strtolower($this->tglrevisianggaran),true);
		$criteria->compare('LOWER(sd_tglrevisianggaran)',strtolower($this->sd_tglrevisianggaran),true);
		$criteria->compare('LOWER(digitnilaianggaran)',strtolower($this->digitnilaianggaran),true);
		$criteria->compare('isclosing_anggaran',$this->isclosing_anggaran);
		if(!empty($this->periodeposting_id)){
			$criteria->addCondition('periodeposting_id = '.$this->periodeposting_id);
		}
		$criteria->compare('LOWER(periodeposting_nama)',strtolower($this->periodeposting_nama),true);
		$criteria->compare('LOWER(tglperiodeposting_awal)',strtolower($this->tglperiodeposting_awal),true);
		$criteria->compare('LOWER(tglperiodeposting_akhir)',strtolower($this->tglperiodeposting_akhir),true);
		$criteria->compare('LOWER(deskripsiperiodeposting)',strtolower($this->deskripsiperiodeposting),true);
		if(!empty($this->laporanneraca_id)){
			$criteria->addCondition('laporanneraca_id = '.$this->laporanneraca_id);
		}
		if(!empty($this->laporanperubahanmodal_id)){
			$criteria->addCondition('laporanperubahanmodal_id = '.$this->laporanperubahanmodal_id);
		}
		if(!empty($this->laporanneracadetail_id)){
			$criteria->addCondition('laporanneracadetail_id = '.$this->laporanneracadetail_id);
		}
		if(!empty($this->bukubesar_id)){
			$criteria->addCondition('bukubesar_id = '.$this->bukubesar_id);
		}
		if(!empty($this->rekening1_id)){
			$criteria->addCondition('rekening1_id = '.$this->rekening1_id);
		}
		$criteria->compare('LOWER(kdrekening1)',strtolower($this->kdrekening1),true);
		$criteria->compare('LOWER(nmrekening1)',strtolower($this->nmrekening1),true);
		if(!empty($this->rekening2_id)){
			$criteria->addCondition('rekening2_id = '.$this->rekening2_id);
		}
		$criteria->compare('LOWER(kdrekening2)',strtolower($this->kdrekening2),true);
		$criteria->compare('LOWER(nmrekening2)',strtolower($this->nmrekening2),true);
		if(!empty($this->rekening3_id)){
			$criteria->addCondition('rekening3_id = '.$this->rekening3_id);
		}
		$criteria->compare('LOWER(kdrekening3)',strtolower($this->kdrekening3),true);
		$criteria->compare('LOWER(nmrekening3)',strtolower($this->nmrekening3),true);
		if(!empty($this->rekening4_id)){
			$criteria->addCondition('rekening4_id = '.$this->rekening4_id);
		}
		$criteria->compare('LOWER(kdrekening4)',strtolower($this->kdrekening4),true);
		$criteria->compare('LOWER(nmrekening4)',strtolower($this->nmrekening4),true);
		if(!empty($this->rekening5_id)){
			$criteria->addCondition('rekening5_id = '.$this->rekening5_id);
		}
		$criteria->compare('LOWER(kdrekening5)',strtolower($this->kdrekening5),true);
		$criteria->compare('LOWER(nmrekening5)',strtolower($this->nmrekening5),true);
		$criteria->compare('saldodebit',$this->saldodebit);
		$criteria->compare('saldokredit',$this->saldokredit);
		$criteria->compare('saldoakhirberjalan',$this->saldoakhirberjalan);
		$criteria->compare('modal',$this->modal);
		$criteria->compare('kewajiban',$this->kewajiban);
		$criteria->compare('aktiva',$this->aktiva);
		$criteria->compare('passiva',$this->passiva);
		$criteria->compare('LOWER(keteranganneraca)',strtolower($this->keteranganneraca),true);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		if(!empty($this->create_loginpemakai_id)){
			$criteria->addCondition('create_loginpemakai_id = '.$this->create_loginpemakai_id);
		}
		if(!empty($this->update_loginpemakai_id)){
			$criteria->addCondition('update_loginpemakai_id = '.$this->update_loginpemakai_id);
		}
		if(!empty($this->create_ruangan)){
			$criteria->addCondition('create_ruangan = '.$this->create_ruangan);
		}
		if(!empty($this->instalasi_id)){
			$criteria->addCondition('instalasi_id = '.$this->instalasi_id);
		}
		$criteria->compare('LOWER(instalasi_nama)',strtolower($this->instalasi_nama),true);
		if(!empty($this->ruangan_id)){
			$criteria->addCondition('ruangan_id = '.$this->ruangan_id);
		}
		$criteria->compare('LOWER(ruangan_nama)',strtolower($this->ruangan_nama),true);
		if(!empty($this->kelrekening_id)){
			$criteria->addCondition('kelrekening_id = '.$this->kelrekening_id);
		}
		$criteria->compare('LOWER(koderekeningkel)',strtolower($this->koderekeningkel),true);
		$criteria->compare('LOWER(namakelrekening)',strtolower($this->namakelrekening),true);
		$criteria->compare('LOWER(kelompokneraca)',strtolower($this->kelompokneraca),true);

		$criteria->limit=10;

		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
		));
	}
	
	public function getSaldoNeraca($periodeposting_id = null, $ruangan_id = null, $kelompokneraca){
		$kolom = '';
		if($kelompokneraca == 'ACTIVA'){
			$kolom = 'aktiva';
		}else{
			$kolom = 'passiva';
		}
		$criteria= new CDbCriteria;
		$criteria->group = 'periodeposting_id,kelompokneraca, aktiva, passiva';
		$criteria->select = $criteria->group.', aktiva, passiva';
		
		$this->periodeposting_id = isset($periodeposting_id) ? $periodeposting_id : null;
		$this->ruangan_id = isset($ruangan_id) ? $ruangan_id : null;
		if(!empty($this->periodeposting_id)){
			$criteria->addCondition('periodeposting_id = '.$this->periodeposting_id);
		}
		if(!empty($this->ruangan_id)){
			$criteria->addCondition('ruangan_id = '.$this->ruangan_id);
		}
		if(!empty($kelompokneraca)){
			$criteria->compare('LOWER(kelompokneraca)',strtolower($kelompokneraca),true);
		}
		$criteria->limit = 1;
		$modSaldoNeraca = AKLaporanneracaV::model()->findAll($criteria);

		$jml = 0;
		foreach($modSaldoNeraca as $saldo){
			$jml += $saldo->$kolom;
		}
		return $jml;
	}
		        
	public function getTglPeriode($rekperiod_id = null)
	{
		$next_year = date('Y-m-d',mktime(0, 0, 0, date("m"),   date("d"),   date("Y")));
		$criteria = new CDbCriteria();
		$criteria->addCondition('DATE(tglperiodeposting_awal) <=\''.$next_year.'\'');
		$criteria->addCondition('DATE(tglperiodeposting_akhir) >= \''.$next_year.'\'');
		$criteria->compare('LOWER(deskripsiperiodeposting)',strtolower($this->deskripsiperiodeposting),true);
		$criteria->order = "tglperiodeposting_akhir";
		if(!empty($rekperiod_id)){
			$criteria->addCondition('rekperiode_id = '.$rekperiod_id);
		}
		
		return self::model()->find($criteria);
	}
	
	public function getRekening(){
        if(!empty($this->rekening5_id)){
			$rekening_id = $this->rekening5_id;
		}else if(!empty($this->rekening4_id)){
			$rekening_id = $this->rekening4_id;
		}else if(!empty($this->rekening3_id)){
			$rekening_id = $this->rekening3_id;
		}else if(!empty($this->rekening2_id)){
			$rekening_id = $this->rekening2_id;
		}
        
        return $rekening_id;
    }
	
	public function getNamaRekening(){
        if(!empty($this->rekening5_id)){
			$nama_rekening = $this->nmrekening5;
		}else if(!empty($this->rekening4_id)){
			$nama_rekening = $this->nmrekening4;
		}else if(!empty($this->rekening3_id)){
			$nama_rekening = $this->nmrekening3;
		}else if(!empty($this->rekening2_id)){
			$nama_rekening = $this->nmrekening2;
		}
        
        return $nama_rekening;
    }
}