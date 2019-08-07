<?php

class KOLaporanangsuranV extends LaporanangsuranV
{
    
    public $jumlah, $data;
    	
    public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }
    
    public function searchCriteria(){
        $criteria = new CDbCriteria();
        
        $criteria->addBetweenCondition('tglangsuran', $this->tgl_awal, $this->tgl_akhir);                             
        return $criteria;
    }
    
    public function searchTable(){
        
        $criteria = $this->searchCriteria();
        $criteria->order = "tglangsuran ASC";
                              
        return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
    }
    
    public function searchPrint(){
        
        $criteria = $this->searchCriteria();
        $criteria->order = "tglangsuran ASC";
      
                              
        return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
    }
    
    public function searchGrafik(){
        
        $criteria = $this->searchCriteria();
       
            $criteria->select = " count(keanggotaan_id) as jumlah,  Jenispinjaman as data";
            $criteria->group = 'Jenispinjaman';
       
        
        
        $criteria->order = "jumlah DESC";
                              
        return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
    }
    
    
}