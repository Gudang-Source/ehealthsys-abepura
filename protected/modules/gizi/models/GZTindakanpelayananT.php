<?php

class GZTindakanpelayananT extends TindakanpelayananT {

    public $pemeriksaanrad_id,$jenistarif_id;
    public $dokterpemeriksa1Nama;
    public $ruangan_nama,$kategoritindakan_nama,$daftartindakan_nama;
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    
     public function searchDetailKonsul($pendaftaran_id)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		if(!empty($this->tindakanpelayanan_id))
            $criteria->addCondition('tindakanpelayanan_id='. $this->tindakanpelayanan_id);
		if(!empty($this->penjamin_id))
            $criteria->addCondition('penjamin_id='. $this->penjamin_id);
		if(!empty($this->pasienadmisi_id))
            $criteria->addCondition('pasienadmisi_id='. $this->pasienadmisi_id);
		if(!empty($this->pasien_id))
            $criteria->addCondition('pasien_id='. $thispasien_idruangan_id);
		if(!empty($this->kelaspelayanan_id))
            $criteria->addCondition('kelaspelayanan_id='. $this->kelaspelayanan_id);
		if(!empty($this->instalasi_id))
            $criteria->addCondition('instalasi_id='. $this->instalasi_id);
		if(!empty($this->pendaftaran_id))
            $criteria->addCondition('pendaftaran_id='. $this->pendaftaran_id);
		if(!empty($this->shift_id))
            $criteria->addCondition('shift_id='. $this->shift_id);
		if(!empty($this->pasienmasukpenunjang_id))
            $criteria->addCondition('pasienmasukpenunjang_id='. $this->pasienmasukpenunjang_id);
		if(!empty($this->daftartindakan_id))
            $criteria->addCondition('daftartindakan_id='. $this->daftartindakan_id);
        if(!empty($this->pendaftaran_id))
        	$criteria->addCondition('pendaftaran_id = '.$pendaftaran_id);

		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function detailRiwayatKonsul($pendaftaran_id)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.
		
		$criteria=new CDbCriteria;
		$criteria->group = 't.tindakanpelayanan_id,
							instalasi_m.instalasi_id,
							instalasi_m.instalasi_nama,
							ruangan_m.ruangan_id,
							ruangan_m.ruangan_nama,
							kategoritindakan_m.kategoritindakan_id,
							kategoritindakan_m.kategoritindakan_nama,
							daftartindakan_m.daftartindakan_id,
							daftartindakan_m.daftartindakan_kode,
							daftartindakan_m.daftartindakan_nama,
							t.tgl_tindakan';
		$criteria->select = $criteria->group.' , SUM(t.qty_tindakan) as qty_tindakan';
		$criteria->join = 'JOIN daftartindakan_m ON t.daftartindakan_id = daftartindakan_m.daftartindakan_id
							JOIN ruangan_m ON t.ruangan_id = ruangan_m.ruangan_id
							JOIN instalasi_m ON ruangan_m.instalasi_id = instalasi_m.instalasi_id
							LEFT JOIN kategoritindakan_m ON daftartindakan_m.kategoritindakan_id = kategoritindakan_m.kategoritindakan_id';
		$criteria->addCondition('komponenunit_id = '.Params::KOMPONENUNIT_ID_GIZI);
		$criteria->addCondition('pendaftaran_id = '.$pendaftaran_id);
		
		$modTindakan = GZTindakanpelayananT::model()->findAll($criteria);
		
		return $modTindakan;
	}

	public function getPemeriksaanKonsultasi($daftartindakan_id = null){
		if(isset($daftartindakan_id)){
			return DaftartindakanM::model()->findByAttributes(array('daftartindakan_id'=>$daftartindakan_id));
		}else{
			return DaftartindakanM::model()->findByAttributes(array('daftartindakan_id'=>$this->daftartindakan_id));
		}
	}
}
