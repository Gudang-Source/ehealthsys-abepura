<?php

class RMLaporanbiayapelayanan extends LaporanbiayapelayananV{
    
    
    
    public function searchGrafik() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;
                        
        if ($_REQUEST['tampilGrafik'] == 'kelaspelayanan'){
            $criteria->select = 'count(pendaftaran_id) as jumlah, kelaspelayanan_nama as data';        
            $criteria->addBetweenCondition('date(tgl_pendaftaran)', $this->tgl_awal, $this->tgl_akhir);
            $criteria->group = 'kelaspelayanan_nama';
        }elseif ($_REQUEST['tampilGrafik'] == 'carabayar'){
            $criteria->select = 'count(pendaftaran_id) as jumlah, carabayar_nama as data';        
            $criteria->addBetweenCondition('date(tgl_pendaftaran)', $this->tgl_awal, $this->tgl_akhir);
            $criteria->group = 'carabayar_nama';
        }else{
            $criteria->select = 'count(pendaftaran_id) as jumlah, carabayar_nama as data';        
            $criteria->addBetweenCondition('date(tgl_pendaftaran)', $this->tgl_awal, $this->tgl_akhir);
            $criteria->group = 'carabayar_nama';
        }
            
        if (!empty($this->penjamin_id)){
            $criteria->addInCondition('penjamin_id', $this->penjamin_id);
        }else{
            //$criteria->addCondition('penjamin_id is null');
        }
        if (!empty($this->kelaspelayanan_id)){
            $criteria->addInCondition('kelaspelayanan_id', $this->kelaspelayanan_id);
        }else{
            //$criteria->addCondition('kelaspelayanan_id is null');
        }

        $criteria->addCondition('ruangan_id = '.Yii::app()->user->getState('ruangan_id'));
        $criteria->addCondition('instalasi_id = '.Params::INSTALASI_ID_REHAB);        
        
         return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                    'pagination'=>false,
                ));

    }
    public function searchPrint() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria = $this->functionCriteria();
        $criteria->order = "tgl_pendaftaran ASC";
        

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                    'pagination'=>false,
                ));
    }
    
    public function searchTable() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria = $this->functionCriteria();
        $criteria->order = "tgl_pendaftaran ASC";

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
    }
    
    protected function functionCriteria(){
        $criteria = new CDbCriteria();
        
        $criteria->addBetweenCondition('date(tgl_pendaftaran)', $this->tgl_awal, $this->tgl_akhir);
        $criteria->select = 'namadepan, pendaftaran_id, ruangan_id, tgl_pendaftaran, no_rekam_medik, nama_pasien, nama_bin, jeniskelamin, umur, no_pendaftaran, jeniskasuspenyakit_nama, kelaspelayanan_nama, kelaspelayanan_id, carabayar_nama, penjamin_nama, penjamin_id, carabayar_id, sum(tarif_tindakan) as total, sum(iurbiaya_tindakan) as iurbiaya, daftartindakan_nama, tindakanpelayanan_id';
        $criteria->group = 'namadepan, pendaftaran_id, ruangan_id, tgl_pendaftaran, no_rekam_medik, nama_pasien, nama_bin, jeniskelamin, umur, no_pendaftaran, jeniskasuspenyakit_nama, kelaspelayanan_nama, kelaspelayanan_id, carabayar_nama, penjamin_nama, penjamin_id, carabayar_id, daftartindakan_nama, tindakanpelayanan_id';
        if (is_array($this->penjamin_id)){
            $criteria->addInCondition('penjamin_id', $this->penjamin_id);
        }else{
            //$criteria->addCondition('penjamin_id is null');
        }
        if (is_array($this->kelaspelayanan_id)){
            $criteria->addInCondition('kelaspelayanan_id', $this->kelaspelayanan_id);
        }else{
            //$criteria->addCondition('kelaspelayanan_id is null');
        }

        $criteria->addCondition('ruangan_id = '.Yii::app()->user->getState('ruangan_id'));
        $criteria->addCondition('instalasi_id = '.Params::INSTALASI_ID_REHAB);

        
        return $criteria;
    }
    
    public function getNamaModel(){
        return __CLASS__;
    }
}

?>
