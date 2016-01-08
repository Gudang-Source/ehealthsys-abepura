<?php

class FALaporanpenjualanjenisoaV extends LaporanpenjualanjenisoaV {

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function getNamaModel() {
        return __CLASS__;
    }
    
    public function primaryKey() {
        return 'penjualanresep_id';
    }

    public function functionCriteria() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.
        
        $criteria = new CDbCriteria;
        $criteria->order = 'obatalkes_nama';
        $criteria->select = 'jenisobatalkes_nama,obatalkes_golongan,obatalkes_kategori,obatalkes_nama, count(r) as r,sum(qty_oa) as qty_oa';
        $criteria->group = 'jenisobatalkes_nama,obatalkes_golongan,obatalkes_kategori,obatalkes_nama';
		if(!empty($this->penjualanresep_id)){
			$criteria->addCondition("penjualanresep_id = ".$this->penjualanresep_id);						
		}
        
        $this->tgl_awal = MyFormatter::formatDateTimeForDb($this->tgl_awal);
        $this->tgl_akhir = MyFormatter::formatDateTimeForDb($this->tgl_akhir);
        $criteria->addBetweenCondition('DATE(tglpenjualan)', $this->tgl_awal, $this->tgl_akhir);
        $criteria->compare('LOWER(noresep)', strtolower($this->noresep), true);
		if(!empty($this->obatalkes_id)){
			$criteria->addCondition("obatalkes_id = ".$this->obatalkes_id);						
		}
        if (!is_array($this->jenisobatalkes_id)){
            $this->jenisobatalkes_id = 0;
        }
		if(!empty($this->jenisobatalkes_id)){
			$criteria->addInCondition("jenisobatalkes_id",$this->jenisobatalkes_id);						
		}
        $criteria->compare('LOWER(jenisobatalkes_nama)', strtolower($this->jenisobatalkes_nama), true);
        $criteria->compare('LOWER(obatalkes_kode)', strtolower($this->obatalkes_kode), true);
        $criteria->compare('LOWER(obatalkes_nama)', strtolower($this->obatalkes_nama), true);
        $criteria->compare('LOWER(obatalkes_golongan)', strtolower($this->obatalkes_golongan), true);
        $criteria->compare('LOWER(obatalkes_kategori)', strtolower($this->obatalkes_kategori), true);
        $this->r = 'R/';
        $criteria->compare('LOWER(r)', strtolower($this->r), true);
        $criteria->compare('rke', $this->rke);
        $criteria->compare('qty_oa', $this->qty_oa);
        
        return $criteria;
    }

    public function searchPrint() {
        $criteria = $this->functionCriteria();

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                    'pagination' => false,
                ));
    }

    public function searchGrafik(){
        
            $criteria = $this->functionCriteria();

            $criteria2 = $criteria;
            $criteria2->select = 'count(jenisobatalkes_nama) as jumlah, jenisobatalkes_nama as data'; 
            $criteria2->group = 'obatalkes_nama, jenisobatalkes_nama';

            return  new CActiveDataProvider($this, array(
                        'criteria'=>$criteria2,
            ));

        }

    public function searchTable() {
        $criteria = $this->functionCriteria();

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
    }

}