<?php

class BKLaporanpenerimaankasirV extends LaporanpenerimaankasirV {

    public $tgl_awal,$tgl_akhir;
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function searchGrafik() {

        $criteria = new CDbCriteria;

        $criteria = $this->functionCriteria();
        
        $criteria->select = 'count(tandabuktibayar_id) as jumlah, ruangan_nama as data';
        $criteria->group = 'ruangan_nama';

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
    }
    public function searchTable() {

        $criteria = new CDbCriteria;

        $criteria = $this->functionCriteria();

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
    }
    
    public function searchPrint() {

        $criteria = new CDbCriteria;

        $criteria = $this->functionCriteria();

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                    'pagination'=>false,
                ));
    }

    protected function functionCriteria() {
        $criteria = new CDbCriteria();

        if (!is_array($this->ruangan_id)){
            $this->ruangan_id = 0;
        }
        
        $criteria->addBetweenCondition('DATE(tglbuktibayar)', $this->tgl_awal, $this->tgl_akhir);
		if(!empty($this->ruangan_id)){
			$criteria->addInCondition('ruangan_id ',$this->ruangan_id);
		}
        $criteria->compare('LOWER(ruangan_nama)', strtolower($this->ruangan_nama), true);
		if(!empty($this->shift_id)){
			$criteria->addCondition('shift_id = '.$this->shift_id);
		}
        $criteria->compare('LOWER(shift_nama)', strtolower($this->shift_nama), true);
        

        return $criteria;
    }

}