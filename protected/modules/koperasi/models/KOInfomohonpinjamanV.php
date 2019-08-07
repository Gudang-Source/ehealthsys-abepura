<?php

class KOInfomohonpinjamanV extends InfomohonpinjamanV
{
    public $tgl_awal;
    public $tgl_akhir;
    public $cair, $surat_peminjaman;
    	
    public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }
    
    public function searchInformasi(){
        $criteria = new CDbCriteria();
        $criteria->addBetweenCondition('tglpermohonanpinjaman', $this->tgl_awal.' 00:00:00', $this->tgl_akhir.' 23:59:59');
        $criteria->compare('LOWER(nopermohonan)', strtolower($this->nopermohonan), true);
        $criteria->compare('LOWER(nokeanggotaan)', strtolower($this->nokeanggotaan), true);
        $criteria->compare('LOWER(nama_pegawai)', strtolower($this->nama_pegawai), true);
        
        if (!empty($this->golongapegawai_id)){
            $criteria->addCondition("golongapegawai_id = '".$this->golonganpegawai_id."' ");
        }
        
        if ($this->status_disetujui == 3){ 
            $criteria->addCondition('approval_id is null');
        }elseif ($this->status_disetujui == 1){
            $criteria->addCondition('status_disetujui = true');
        }else if ($this->status_disetujui == 2) {
            $criteria->addCondition('status_disetujui = false');            
        }
		
        if ($this->cair == 1){
            $criteria->addCondition('pinjaman_id is not null');
        }elseif ($this->cair == 2){
            $criteria->addCondition('pinjaman_id is null');
        }
        
        if (!empty($this->jenispinjaman_permohonan)){
            $criteria->compare('LOWER(jenispinjaman_permohonan)', strtolower($this->jenispinjaman_permohonan), true);
        }
       
        
        return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
    }
}