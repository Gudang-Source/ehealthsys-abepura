<?php

class KOLaporanpinjamanV extends LaporanpinjamanV
{
    
    public $jumlah, $data;
    	
    public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }
    
    public function searchCriteria(){
        $criteria = new CDbCriteria();
        
        $criteria->addBetweenCondition('tglpinjaman', $this->tgl_awal, $this->tgl_akhir);
        if (!empty($this->golonganpegawai_id)){
            $criteria->addInCondition('golonganpegawai_id', $this->golonganpegawai_id);
        }
        
      
        
        return $criteria;
    }
    
    public function searchTable(){
        
        $criteria = $this->searchCriteria();
        //$criteria->order = "tglsimpanan ASC";
                              
        return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
    }
    
    public function searchPrint(){
        
        $criteria = $this->searchCriteria();
        //$criteria->order = "tglsimpanan ASC";
      
                              
        return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
    }
    
    public function searchGrafik(){
        
        $criteria = $this->searchCriteria();
       if ($_GET['tampilGrafik'] == 'golonganpegawai'){
            $criteria->select = " count(keanggotaan_id) as jumlah,  golonganpegawai_nama as data";
            $criteria->group = 'golonganpegawai_nama';
        }
        
        
        $criteria->order = "jumlah DESC";
                              
        return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
    }
    
    
}