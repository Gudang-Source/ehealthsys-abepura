<?php

class KOLaporansimpananV extends LaporansimpananV
{
    
    public $jumlah, $data;
    	
    public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }
    
    public function searchCriteria(){
        $criteria = new CDbCriteria();
        $criteria->group = 'nokeanggotaan, nama_pegawai, golonganpegawai_nama';
        $criteria->select = $criteria->group.',
                sum(total_simpananpokok) as total_simpananpokok,
                sum(total_simpananwajib) as total_simpananwajib,
                sum(total_simpanansukarela) as total_simpanansukarela,
                sum(total_simpanandeposito) as total_simpanandeposito
                ';
        $criteria->addBetweenCondition('tglsimpanan', $this->tgl_awal, $this->tgl_akhir);
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