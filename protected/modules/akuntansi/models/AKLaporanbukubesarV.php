<?php
class AKLaporanbukubesarV extends LaporanbukubesarV
{
	public $tgl_awal, $tgl_akhir, $ruangan_id;
	public $koderekening,$namarekening;
	public $urutan;
	public $is_tglposting = 1;
	public $is_tgltransaksi;
	public $tgl_posting_awal,$tgl_posting_akhir,$tgl_transaksi_awal,$tgl_transaksi_akhir;
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

		if(!empty($this->periodeposting_id)){
			$criteria->addCondition('periodeposting_id = '.$this->periodeposting_id);
		}
		$criteria->compare('LOWER(periodeposting_nama)',strtolower($this->periodeposting_nama),true);
		if(!empty($this->ruangan_id)){
			$criteria->addCondition('ruangan_id = '.$this->ruangan_id);
		}
		$criteria->compare('LOWER(ruangan_nama)',strtolower($this->ruangan_nama),true);
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
		$criteria->compare('LOWER(rekening5_nb)',strtolower($this->rekening5_nb),true);
		$criteria->compare('LOWER(tgljurnalpost)',strtolower($this->tgljurnalpost),true);
		$criteria->compare('LOWER(uraiantransaksi)',strtolower($this->uraiantransaksi),true);
		$criteria->compare('LOWER(no_referensi)',strtolower($this->no_referensi),true);
		$criteria->compare('saldodebit',$this->saldodebit);
		$criteria->compare('saldokredit',$this->saldokredit);
		$criteria->compare('LOWER(tglbukubesar)',strtolower($this->tglbukubesar),true);
		$criteria->compare('saldo',$this->saldo);
		$criteria->compare('LOWER(koderekening)',strtolower($this->koderekening),true);
		
		$criteria->limit=10;

		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
		));
	}
	
	public function getTglPeriode($rekperiod_id = null)
	{
//		$next_year = date('Y-m-d',mktime(0, 0, 0, date("m"),   date("d"),   date("Y")));
		$criteria = new CDbCriteria();
//		$criteria->addCondition('DATE(tglperiodeposting_awal) <=\''.$next_year.'\'');
//		$criteria->addCondition('DATE(tglperiodeposting_akhir) >= \''.$next_year.'\'');
		$criteria->compare('LOWER(periodeposting_nama)',strtolower($this->periodeposting_nama),true);
//		$criteria->order = "tglperiodeposting_akhir";
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