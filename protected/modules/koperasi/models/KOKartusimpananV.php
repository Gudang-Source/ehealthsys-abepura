<?php

class KOKartusimpananV extends KartusimpananV
{
    public $tgl_awal;
    public $tgl_akhir;
    	
    public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }
    
    public function searchInformasi(){
        $criteria = new CDbCriteria();
        $criteria->addBetweenCondition('tglsimpanan', $this->tgl_awal.' 00:00:00', $this->tgl_akhir.' 23:59:59');
        $criteria->compare('LOWER(nosimpanan)', strtolower($this->nosimpanan), true);
        $criteria->compare('LOWER(nokeanggotaan)', strtolower($this->nokeanggotaan), true);
        $criteria->compare('LOWER(nama_pegawai)', strtolower($this->nama_pegawai), true);
        
        if (!empty($this->golonganpegawai_id)){
            $criteria->addCondition("golonganpegawai_id = '".$this->golonganpegawai_id."' ");
        }
        
        if (!empty($this->jenissimpanan_id)){
            $criteria->addCondition("jenissimpanan_id = '".$this->jenissimpanan_id."' ");
        }
        
        return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
    }
}