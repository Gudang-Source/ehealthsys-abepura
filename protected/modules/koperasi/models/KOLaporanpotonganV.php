<?php

class KOLaporanpotonganV extends LaporanpotonganV
{
    
    public $jumlah, $data;
    	
    public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }
    
    public function searchCriteria(){
        $criteria = new CDbCriteria();
        
        $criteria->addBetweenCondition('tglpengajuanpemb', $this->tgl_awal, $this->tgl_akhir);    
        if (!empty($this->potongansumber_id)){
            $criteria->addInCondition('potongansumber_id', $this->potongansumber_id);
        }
        return $criteria;
    }
    
    public function searchTable(){
        
        $criteria = $this->searchCriteria();
        $criteria->order = "tglpengajuanpemb ASC";
                              
        return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
    }
    
    public function searchPrint(){
        
        $criteria = $this->searchCriteria();
        $criteria->order = "tglpengajuanpemb ASC";
      
                              
        return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
    }
    
    public function searchGrafik(){
        
        $criteria = $this->searchCriteria();
       
            $criteria->select = " count(nopengajuan) as jumlah,  namapotongan as data";
            $criteria->group = 'namapotongan';
       
        
        
        $criteria->order = "jumlah DESC";
                              
        return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
    }
    
    
}