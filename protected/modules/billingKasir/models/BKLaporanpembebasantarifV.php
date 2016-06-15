<?php

class BKLaporanpembebasantarifV extends LaporanpembebasantarifV {

    public $jumlah, $tick, $data, $jns_periode, $tgl_awal, $tgl_akhir, $bln_awal, $bln_akhir, $thn_awal, $thn_akhir;

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
        $format = new MyFormatter();
        
        $criteria = new CDbCriteria();
        if(!empty($this->pegawai_id)){
                $criteria->addCondition('pegawai_id = '.$this->pegawai_id);
        }
        //$criteria->compare('ruangan_id', $this->ruangan_id);
        $criteria->compare('create_ruangan', $this->ruangan_id);
        $criteria->addBetweenCondition('tgl_tindakan', $format->formatDateTimeForDb($this->tgl_awal), $format->formatDateTimeForDb($this->tgl_akhir));

        return $criteria;
    }
      
}