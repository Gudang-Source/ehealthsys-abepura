<?php

class KOLaporankeanggotaanV extends LaporankeanggotaanV
{
    
    public $jumlah, $data;
    	
    public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }
    
    public function searchCriteria(){
        $criteria = new CDbCriteria();
        $criteria->addBetweenCondition('tglkeanggotaaan', $this->tgl_awal, $this->tgl_akhir);
        if (!empty($this->golonganpegawai_id)){
            $criteria->addInCondition('golonganpegawai_id', $this->golonganpegawai_id);
        }
        
        if (!empty($this->jeniskelamin)){
            $criteria->addInCondition('jeniskelamin', $this->jeniskelamin);
        }
        
        if (!empty($this->jabatan_id)){
            $criteria->addInCondition('jabatan_id', $this->jabatan_id);
        }
        
        if (!empty($this->pangkat_id)){
            $criteria->addInCondition('pangkat_id', $this->pangkat_id);
        }
        
        return $criteria;
    }
    
    public function searchTable(){
        
        $criteria = $this->searchCriteria();
        $criteria->order = "tglkeanggotaaan ASC";
                              
        return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
    }
    
    public function searchPrint(){
        
        $criteria = $this->searchCriteria();
        $criteria->order = "tglkeanggotaaan ASC";
      
                              
        return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
    }
    
    public function searchGrafik(){
        
        $criteria = $this->searchCriteria();
        if ($_GET['tampilGrafik'] == 'jabatan'){
            $criteria->select = " count(keanggotaan_id) as jumlah,  jabatan_nama as data";
            $criteria->group = 'jabatan_nama';
        }elseif ($_GET['tampilGrafik'] == 'golonganpegawai'){
            $criteria->select = " count(keanggotaan_id) as jumlah,  golonganpegawai_nama as data";
            $criteria->group = 'golonganpegawai_nama';
        }elseif ($_GET['tampilGrafik'] == 'pangkat'){
            $criteria->select = " count(keanggotaan_id) as jumlah,  pangkat_nama as data";
            $criteria->group = 'pangkat_nama';
        }elseif ($_GET['tampilGrafik'] == 'jeniskelamin'){
            $criteria->select = " count(keanggotaan_id) as jumlah,  jeniskelamin as data";
            $criteria->group = 'jeniskelamin';
        }
        
        
        $criteria->order = "jumlah DESC";
                              
        return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
    }
    
    
}