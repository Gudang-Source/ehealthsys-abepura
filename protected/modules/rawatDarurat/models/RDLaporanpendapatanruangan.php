<?php

class RDLaporanpendapatanruangan extends LaporanpendapatanruanganV {

    public $jumlah;
    public $data;
    public $tick;
    public $tgl_awal,$tgl_akhir;
    public $bln_awal,$bln_akhir;
    public $thn_awal,$thn_akhir;
    public $jns_periode;

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function searchTable() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria = $this->functionCriteria();

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
    }

    public function searchGrafik() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;
        
        $criteria = $this->functionCriteria();

        $criteria->select = 'count(pendaftaran_id) as jumlah, kelaspelayanan_nama as data';
        $criteria->group = 'kelaspelayanan_nama';
        if (!empty($this->carabayar_id)) {
            $criteria->select .= ', penjamin_nama as tick';
            $criteria->group .= ', penjamin_nama';
        } else {
            $criteria->select .= ', carabayar_nama as tick';
            $criteria->group .= ', carabayar_nama';
        }

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
    }

    public function searchPrint() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria = $this->functionCriteria();

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                    'pagination' => false,
                ));
    }
    
    public function functionCriteria(){
        $criteria = new CDbCriteria();
        
        if (!is_array($this->kelaspelayanan_id)){
            $this->kelaspelayanan_id = 0;
        }
        
        $criteria->addBetweenCondition('date(tgl_pendaftaran)', $this->tgl_awal, $this->tgl_akhir);
        if(is_array($this->penjamin_id)){
            $criteria->addInCondition("penjamin_id",$this->penjamin_id);
        }else{
            if(!empty($this->penjamin_id)){
                $criteria->addCondition("penjamin_id = ".$this->penjamin_id);               
            }
        }
        $criteria->compare('LOWER(penjamin_nama)', strtolower($this->penjamin_nama), true);
        if(is_array($this->carabayar_id)){
            $criteria->addInCondition("carabayar_id",$this->carabayar_id);
        }else{
            if(!empty($this->carabayar_id)){
                $criteria->addCondition("carabayar_id = ".$this->carabayar_id);               
            }
        }
        $criteria->compare('LOWER(carabayar_nama)', strtolower($this->carabayar_nama), true);
        if(is_array($this->kelaspelayanan_id)){
            $criteria->addInCondition("kelaspelayanan_id",$this->kelaspelayanan_id);
        }else{
            if(!empty($this->kelaspelayanan_id)){
                $criteria->addCondition("kelaspelayanan_id = ".$this->kelaspelayanan_id);               
            }
        }
        $criteria->compare('LOWER(kelaspelayanan_nama)', strtolower($this->kelaspelayanan_nama), true);
		if(!empty($this->instalasi_id)){
			$criteria->addCondition("instalasi_id = ".$this->instalasi_id);				
		}
        $criteria->compare('LOWER(instalasi_nama)', strtolower($this->instalasi_nama), true);
        $criteria->addCondition('ruangan_id = '.Yii::app()->user->getState('ruangan_id'));
        $criteria->compare('LOWER(ruangan_nama)', strtolower($this->ruangan_nama), true);
        $criteria->compare('LOWER(tgl_tindakan)', strtolower($this->tgl_tindakan), true);
		if(!empty($this->tipepaket_id)){
			$criteria->addCondition("tipepaket_id = ".$this->tipepaket_id);				
		}
        $criteria->compare('LOWER(tipepaket_nama)', strtolower($this->tipepaket_nama), true);
        $criteria->compare('LOWER(nama_pegawai)', strtolower($this->nama_pegawai), true);
        
        
        return $criteria;
    }

    public function getNamaModel() {
        return __CLASS__;
    }

}