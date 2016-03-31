<?php

class RKPengirimanrmT extends PengirimanrmT {

	public $cekList,$kelengkapan;
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    
    public function searchPenyimpanan()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
                
                $criteria->with = array('pendaftaran', 'dokrekammedis','pasien');
                $criteria->addCondition('t.peminjamanrm_id is null');                
                $criteria->addCondition('dokrekammedis.subrak_id is null and dokrekammedis.lokasirak_id is null');
                
		if (!empty($this->no_rekam_medik_akhir)){
                    $criteria->addCondition("CAST(pasien.no_rekam_medik as integer) between ".$this->no_rekam_medik." and ".$this->no_rekam_medik_akhir);
                } else {
                    $criteria->compare('LOWER(pasien.no_rekam_medik)',strtolower($this->no_rekam_medik),true);
                }
                if (!empty($this->tgl_rekam_medik_akhir)){
                    $this->tgl_rekam_medik = MyFormatter::formatDateTimeForDb($this->tgl_rekam_medik);
                    $this->tgl_rekam_medik_akhir = MyFormatter::formatDateTimeForDb($this->tgl_rekam_medik_akhir);
                    $criteria->addBetweenCondition('(dokrekammedis.tglrekammedis)', $this->tgl_rekam_medik, $this->tgl_rekam_medik_akhir);
                }
                else{
                    $this->tgl_rekam_medik = MyFormatter::formatDateTimeForDb($this->tgl_rekam_medik);
                    $criteria->compare('DATE(dokrekammedis.tglrekammedis)',$this->tgl_rekam_medik);    
                }
		$criteria->compare('LOWER(pasien.nama_pasien)',strtolower($this->nama_pasien),true);
		$criteria->compare('LOWER(dokrekammedis.statusrekammedis)',strtolower($this->statusrekammedis),true);
		if(!empty($this->instalasi_id)){
			//$criteria->addCondition("pendaftaran.ruangan_id = ".$this->ruangan_id);			
		}
		$criteria->compare('LOWER(pendaftaran.no_pendaftaran)',strtolower($this->no_pendaftaran),true);
		if(!empty($this->instalasi_id)){
			$criteria->addCondition("pendaftaran.instalasi_id = ".$this->instalasi_id);			
		}

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}