<?php
class AKLaporanbukubesarV extends LaporanbukubesarV
{
	public $tgl_awal, $tgl_akhir, $ruangan_id;
	public $koderekening,$namarekening;
	public $urutan;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return LaporanbukubesarV the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function searchLaporan()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.
		$criteria=new CDbCriteria;

		echo $this->periodeposting_id;
		if(!empty($this->periodeposting_id)){
			$criteria->addCondition('periodeposting_id = '.$this->periodeposting_id);
		}
		if(!empty($this->instalasi_id)){
			$criteria->addCondition('instalasi_id = '.$this->instalasi_id);
		}
		$criteria->compare('LOWER(instalasi_nama)',strtolower($this->instalasi_nama),true);
		if(!empty($this->ruangan_id)){
			$criteria->addCondition('ruangan_id = '.$this->ruangan_id);
		}
		$criteria->compare('LOWER(ruangan_nama)',strtolower($this->ruangan_nama),true);
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
		$criteria->compare('LOWER(periodeposting_nama)',strtolower($this->periodeposting_nama),true);
		$criteria->compare('LOWER(tglperiodeposting_awal)',strtolower($this->tglperiodeposting_awal),true);
		$criteria->compare('LOWER(tglperiodeposting_akhir)',strtolower($this->tglperiodeposting_akhir),true);
		$criteria->compare('LOWER(deskripsiperiodeposting)',strtolower($this->deskripsiperiodeposting),true);
		if(!empty($this->bukubesar_id)){
			$criteria->addCondition('bukubesar_id = '.$this->bukubesar_id);
		}
		if(!empty($this->rekening1_id)){
			$criteria->addCondition('rekening1_id = '.$this->rekening1_id);
		}
		$criteria->compare('LOWER(kdrekening1)',strtolower($this->kdrekening1),true);
		$criteria->compare('LOWER(nmrekening1)',strtolower($this->nmrekening1),true);
		$criteria->compare('LOWER(rekening1_nb)',strtolower($this->rekening1_nb),true);
		if(!empty($this->rekening2_id)){
			$criteria->addCondition('rekening2_id = '.$this->rekening2_id);
		}
		$criteria->compare('LOWER(kdrekening2)',strtolower($this->kdrekening2),true);
		$criteria->compare('LOWER(nmrekening2)',strtolower($this->nmrekening2),true);
		$criteria->compare('LOWER(rekening2_nb)',strtolower($this->rekening2_nb),true);
		if(!empty($this->rekening3_id)){
			$criteria->addCondition('rekening3_id = '.$this->rekening3_id);
		}
		$criteria->compare('LOWER(kdrekening3)',strtolower($this->kdrekening3),true);
		$criteria->compare('LOWER(nmrekening3)',strtolower($this->nmrekening3),true);
		$criteria->compare('LOWER(rekening3_nb)',strtolower($this->rekening3_nb),true);
		if(!empty($this->rekening4_id)){
			$criteria->addCondition('rekening4_id = '.$this->rekening4_id);
		}
		$criteria->compare('LOWER(kdrekening4)',strtolower($this->kdrekening4),true);
		$criteria->compare('LOWER(nmrekening4)',strtolower($this->nmrekening4),true);
		$criteria->compare('LOWER(rekening4_nb)',strtolower($this->rekening4_nb),true);
		if(!empty($this->rekening5_id)){
			$criteria->addCondition('rekening5_id = '.$this->rekening5_id);
		}
		$criteria->compare('LOWER(kdrekening5)',strtolower($this->kdrekening5),true);
		$criteria->compare('LOWER(nmrekening5)',strtolower($this->nmrekening5),true);
		$criteria->compare('LOWER(rekening5_nb)',strtolower($this->rekening5_nb),true);
		$criteria->compare('LOWER(tglbukubesar)',strtolower($this->tglbukubesar),true);
		$criteria->compare('LOWER(no_referensi)',strtolower($this->no_referensi),true);
		$criteria->compare('LOWER(uraiantransaksi)',strtolower($this->uraiantransaksi),true);
		$criteria->compare('saldodebit',$this->saldodebit);
		$criteria->compare('saldokredit',$this->saldokredit);
		$criteria->compare('saldoakhirberjalan',$this->saldoakhirberjalan);
		if(!empty($this->jurnalrekening_id)){
			$criteria->addCondition('jurnalrekening_id = '.$this->jurnalrekening_id);
		}
		if(!empty($this->jenisjurnal_id)){
			$criteria->addCondition('jenisjurnal_id = '.$this->jenisjurnal_id);
		}
		$criteria->compare('LOWER(jenisjurnal_nama)',strtolower($this->jenisjurnal_nama),true);
		$criteria->compare('LOWER(tglbuktijurnal)',strtolower($this->tglbuktijurnal),true);
		$criteria->compare('LOWER(nobuktijurnal)',strtolower($this->nobuktijurnal),true);
		$criteria->compare('LOWER(kodejurnal)',strtolower($this->kodejurnal),true);
		$criteria->compare('LOWER(noreferensi)',strtolower($this->noreferensi),true);
		$criteria->compare('LOWER(tglreferensi)',strtolower($this->tglreferensi),true);
		if(!empty($this->nobku)){
			$criteria->addCondition('nobku = '.$this->nobku);
		}
		$criteria->compare('LOWER(urianjurnal)',strtolower($this->urianjurnal),true);
		if(!empty($this->jurnaldetail_id)){
			$criteria->addCondition('jurnaldetail_id = '.$this->jurnaldetail_id);
		}
		if(!empty($this->rekeningjurnal1_id)){
			$criteria->addCondition('rekeningjurnal1_id = '.$this->rekeningjurnal1_id);
		}
		$criteria->compare('LOWER(rekeningjurnal1_kode)',strtolower($this->rekeningjurnal1_kode),true);
		$criteria->compare('LOWER(rekeningjurnal1_nama)',strtolower($this->rekeningjurnal1_nama),true);
		$criteria->compare('LOWER(rekeningjurnal1_saldonormal)',strtolower($this->rekeningjurnal1_saldonormal),true);
		if(!empty($this->rekeningjurnal2_id)){
			$criteria->addCondition('rekeningjurnal2_id = '.$this->rekeningjurnal2_id);
		}
		$criteria->compare('LOWER(rekeningjurnal2_kode)',strtolower($this->rekeningjurnal2_kode),true);
		$criteria->compare('LOWER(rekeningjurnal2_nama)',strtolower($this->rekeningjurnal2_nama),true);
		$criteria->compare('LOWER(rekeningjurnal2_saldonormal)',strtolower($this->rekeningjurnal2_saldonormal),true);
		if(!empty($this->rekeningjurnal3_id)){
			$criteria->addCondition('rekeningjurnal3_id = '.$this->rekeningjurnal3_id);
		}
		$criteria->compare('LOWER(rekeningjurnal3_kode)',strtolower($this->rekeningjurnal3_kode),true);
		$criteria->compare('LOWER(rekeningjurnal3_nama)',strtolower($this->rekeningjurnal3_nama),true);
		$criteria->compare('LOWER(rekeningjurnal3_saldonormal)',strtolower($this->rekeningjurnal3_saldonormal),true);
		if(!empty($this->rekeningjurnal4_id)){
			$criteria->addCondition('rekeningjurnal4_id = '.$this->rekeningjurnal4_id);
		}
		$criteria->compare('LOWER(rekeningjurnal4_kode)',strtolower($this->rekeningjurnal4_kode),true);
		$criteria->compare('LOWER(rekeningjurnal4_nama)',strtolower($this->rekeningjurnal4_nama),true);
		$criteria->compare('LOWER(rekeningjurnal4_saldonormal)',strtolower($this->rekeningjurnal4_saldonormal),true);
		if(!empty($this->rekeningjurnal5_id)){
			$criteria->addCondition('rekeningjurnal5_id = '.$this->rekeningjurnal5_id);
		}
		$criteria->compare('LOWER(rekeningjurnal5_kode)',strtolower($this->rekeningjurnal5_kode),true);
		$criteria->compare('LOWER(rekeningjurnal5_nama)',strtolower($this->rekeningjurnal5_nama),true);
		$criteria->compare('LOWER(rekeningjurnal5_saldonormal)',strtolower($this->rekeningjurnal5_saldonormal),true);
		$criteria->compare('LOWER(nourut)',strtolower($this->nourut),true);
		$criteria->compare('LOWER(uraiantransaksijurnal)',strtolower($this->uraiantransaksijurnal),true);
		$criteria->compare('saldodebitjurnal',$this->saldodebitjurnal);
		$criteria->compare('saldokreditjurnal',$this->saldokreditjurnal);
		$criteria->compare('koreksi',$this->koreksi);
		$criteria->compare('LOWER(catatan)',strtolower($this->catatan),true);
		if(!empty($this->jurnalposting_id)){
			$criteria->addCondition('jurnalposting_id = '.$this->jurnalposting_id);
		}
		$criteria->compare('LOWER(tgljurnalpost)',strtolower($this->tgljurnalpost),true);
		$criteria->compare('LOWER(keterangan)',strtolower($this->keterangan),true);
		
		$criteria->limit=10;

		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
		));
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
		if(!empty($this->periodeposting_id)){
			$criteria->addCondition('rekperiode_id = '.$this->periodeposting_id);
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
	
	public function getNamaRekeningJurnal(){
        if(!empty($this->rekeningjurnal5_id)){
			$nama_rekening = $this->rekeningjurnal5_nama;
		}else if(!empty($this->rekeningjurnal4_id)){
			$nama_rekening = $this->rekeningjurnal4_nama;
		}else if(!empty($this->rekeningjurnal3_id)){
			$nama_rekening = $this->rekeningjurnal3_nama;
		}else if(!empty($this->rekeningjurnal2_id)){
			$nama_rekening = $this->rekeningjurnal2_nama;
		}
        
        return $nama_rekening;
    }
	
	public function getRekeningJurnal(){
        if(!empty($this->rekeningjurnal5_id)){
			$rekening_id = $this->rekeningjurnal5_id;
		}else if(!empty($this->rekeningjurnal4_id)){
			$rekening_id = $this->rekeningjurnal4_id;
		}else if(!empty($this->rekeningjurnal3_id)){
			$rekening_id = $this->rekeningjurnal3_id;
		}else if(!empty($this->rekeningjurnal2_id)){
			$rekening_id = $this->rekeningjurnal2_id;
		}
        
        return $rekening_id;
    }
}