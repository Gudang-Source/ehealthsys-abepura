<?php

class KOLaporankaskeluarkopV extends LaporankaskeluarkopV
{
    
    public $jumlah, $data;
    	
    public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }
    
    public function searchCriteria(){
        $criteria = new CDbCriteria();
        
        $criteria->addBetweenCondition('tgl_bkk', $this->tgl_awal, $this->tgl_akhir);    
        if (!empty($this->jenistransaksi_id)){
            $criteria->addInCondition('jenistransaksi_id', $this->jenistransaksi_id);
        }
        return $criteria;
    }
    
    public function searchTable(){
        
        $criteria = $this->searchCriteria();
        $criteria->order = "tgl_bkk ASC";
                              
        return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
    }
    
    public function searchPrint(){
        
        $criteria = $this->searchCriteria();
        $criteria->order = "tgl_bkk ASC";
      
                              
        return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
    }
    
    public function searchGrafik(){
        
        $criteria = $this->searchCriteria();
       
            $criteria->select = " count(buktikaskeluarkop_id) as jumlah,  namatransaksi as data";
            $criteria->group = 'namatransaksi';
       
        
        
        $criteria->order = "jumlah DESC";
                              
        return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
    }
    
    
}