<?php

class AKSaldorekeningV extends SaldorekeningV
{
	public $NamaRekPeriod,$KodeRekening;
    /**
    * Returns the static model of the specified AR class.
    * @param string $className active record class name.
    * @return AnamnesaT the static model class
    */

    public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
    
	public function searchByFilter()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		if(!empty($this->saldoawal_id)){
			$criteria->addCondition('saldoawal_id = '.$this->saldoawal_id);
		}
		if(!empty($this->rekperiod_id)){
			$criteria->addCondition('rekperiod_id = '.$this->rekperiod_id);
		}
		$criteria->compare('LOWER(perideawal)',strtolower($this->perideawal),true);
		$criteria->compare('LOWER(sampaidgn)',strtolower($this->sampaidgn),true);
		if(!empty($this->kursrp_id)){
			$criteria->addCondition('kursrp_id = '.$this->kursrp_id);
		}
		$criteria->compare('nilai',$this->nilai);
		if(!empty($this->matauang_id)){
			$criteria->addCondition('matauang_id = '.$this->matauang_id);
		}
		$criteria->compare('LOWER(matauang)',strtolower($this->matauang),true);
		if(!empty($this->periodeposting_id)){
			$criteria->addCondition('periodeposting_id = '.$this->periodeposting_id);
		}
		$criteria->compare('LOWER(periodeposting_nama)',strtolower($this->periodeposting_nama),true);
		$criteria->compare('LOWER(tglperiodeposting_awal)',strtolower($this->tglperiodeposting_awal),true);
		$criteria->compare('LOWER(tglperiodeposting_akhir)',strtolower($this->tglperiodeposting_akhir),true);
		$criteria->compare('LOWER(deskripsiperiodeposting)',strtolower($this->deskripsiperiodeposting),true);
		
		if(!empty($this->rekening5_id)){
			$criteria->addCondition('rekening5_id = '.$this->rekening5_id);
		}
		$criteria->compare('LOWER(kdrekening5)',strtolower($this->kdrekening5),true);
		$criteria->compare('LOWER(nmrekening5)',strtolower($this->nmrekening5),true);
		$criteria->compare('LOWER(nmrekeninglain5)',strtolower($this->nmrekeninglain5),true);
		$criteria->compare('LOWER(rekening5_nb)',strtolower($this->rekening5_nb),true);
		$criteria->compare('LOWER(keterangan)',strtolower($this->keterangan),true);
		if(!empty($this->nourutrek)){
			$criteria->addCondition('nourutrek = '.$this->nourutrek);
		}
		$criteria->compare('rekening5_aktif',$this->rekening5_aktif);
		$criteria->compare('LOWER(kelompokrek)',strtolower($this->kelompokrek),true);
		$criteria->compare('sak',$this->sak);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
		$criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);
		$criteria->compare('jmlanggaran',$this->jmlanggaran);
		$criteria->compare('jmlsaldoawald',$this->jmlsaldoawald);
		$criteria->compare('jmlsaldoawalk',$this->jmlsaldoawalk);
		$criteria->compare('jmlmutasid',$this->jmlmutasid);
		$criteria->compare('jmlmutasik',$this->jmlmutasik);
		$criteria->compare('jmlsaldoakhird',$this->jmlsaldoakhird);
		$criteria->compare('jmlsaldoakhirk',$this->jmlsaldoakhirk);
		$criteria->order = 'nourutrek';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}    
	public function searchByFilterPrint()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		if(!empty($this->saldoawal_id)){
			$criteria->addCondition('saldoawal_id = '.$this->saldoawal_id);
		}
		if(!empty($this->rekperiod_id)){
			$criteria->addCondition('rekperiod_id = '.$this->rekperiod_id);
		}
		$criteria->compare('LOWER(perideawal)',strtolower($this->perideawal),true);
		$criteria->compare('LOWER(sampaidgn)',strtolower($this->sampaidgn),true);
		if(!empty($this->kursrp_id)){
			$criteria->addCondition('kursrp_id = '.$this->kursrp_id);
		}
		$criteria->compare('nilai',$this->nilai);
		if(!empty($this->matauang_id)){
			$criteria->addCondition('matauang_id = '.$this->matauang_id);
		}
		$criteria->compare('LOWER(matauang)',strtolower($this->matauang),true);
		if(!empty($this->periodeposting_id)){
			$criteria->addCondition('periodeposting_id = '.$this->periodeposting_id);
		}
		$criteria->compare('LOWER(periodeposting_nama)',strtolower($this->periodeposting_nama),true);
		$criteria->compare('LOWER(tglperiodeposting_awal)',strtolower($this->tglperiodeposting_awal),true);
		$criteria->compare('LOWER(tglperiodeposting_akhir)',strtolower($this->tglperiodeposting_akhir),true);
		$criteria->compare('LOWER(deskripsiperiodeposting)',strtolower($this->deskripsiperiodeposting),true);
		
		if(!empty($this->rekening5_id)){
			$criteria->addCondition('rekening5_id = '.$this->rekening5_id);
		}
		$criteria->compare('LOWER(kdrekening5)',strtolower($this->kdrekening5),true);
		$criteria->compare('LOWER(nmrekening5)',strtolower($this->nmrekening5),true);
		$criteria->compare('LOWER(nmrekeninglain5)',strtolower($this->nmrekeninglain5),true);
		$criteria->compare('LOWER(rekening5_nb)',strtolower($this->rekening5_nb),true);
		$criteria->compare('LOWER(keterangan)',strtolower($this->keterangan),true);
		if(!empty($this->nourutrek)){
			$criteria->addCondition('nourutrek = '.$this->nourutrek);
		}
		$criteria->compare('rekening5_aktif',$this->rekening5_aktif);
		$criteria->compare('LOWER(kelompokrek)',strtolower($this->kelompokrek),true);
		$criteria->compare('sak',$this->sak);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
		$criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);
		$criteria->compare('jmlanggaran',$this->jmlanggaran);
		$criteria->compare('jmlsaldoawald',$this->jmlsaldoawald);
		$criteria->compare('jmlsaldoawalk',$this->jmlsaldoawalk);
		$criteria->compare('jmlmutasid',$this->jmlmutasid);
		$criteria->compare('jmlmutasik',$this->jmlmutasik);
		$criteria->compare('jmlsaldoakhird',$this->jmlsaldoakhird);
		$criteria->compare('jmlsaldoakhirk',$this->jmlsaldoakhirk);
		$criteria->order = 'nourutrek';
		$criteria->limit = -1;

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'pagination'=>false,
		));
	}    
	
	public function getNamaRekPeriod()
    {
		$deskripsi = "";
        $rekperiod_id = isset($this->rekperiod_id) ? $this->rekperiod_id : null;
		$modRekPeriod = AKRekperiodM::model()->findByPk($rekperiod_id);
		if(isset($modRekPeriod) && count($modRekPeriod) > 0){
			$deskripsi = $modRekPeriod->deskripsi;
		}
		return $deskripsi;
    }
	
	public function getKodeRekening(){
		$kodeRekening = '';
		if ((!empty($this->kdrekening5))){
			$kodeRekening .=  $this->kdrekening5;
		}else{
			$kodeRekening .= "-";
		}
		
		return $kodeRekening;
	}
	
	public function getNamaRekening(){
		$nama_rekening = '';
		 if(!empty($this->nmrekening5)){
			$nama_rekening = $this->nmrekening5;
		}
		
		return $nama_rekening;
	}
    
    
}
?>
