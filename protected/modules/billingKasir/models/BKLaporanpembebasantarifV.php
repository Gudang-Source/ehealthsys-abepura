<?php

class BKLaporanpembebasantarifV extends LaporanpembebasantarifV {

    public $jumlah, $tick, $data;

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function searchGrafik() {

        $criteria = new CDbCriteria;

        $criteria = $this->functionCriteria();
        
        $criteria->select = 'count(pasien_id) as jumlah, nama_pegawai as data';
        $criteria->group = 'nama_pegawai';

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
		if(!empty($this->pegawai_id)){
			$criteria->addCondition('pegawai_id = '.$this->pegawai_id);
		}
        $criteria->addBetweenCondition('tgl_tindakan', $this->tgl_awal, $this->tgl_akhir);

        return $criteria;
    }

}