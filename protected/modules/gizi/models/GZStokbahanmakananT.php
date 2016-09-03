<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of GZStokbahanmakananT
 *
 * @author sujana
 */
class GZStokbahanmakananT extends StokbahanmakananT {
    
    public $tgl_awal;
    public $tgl_akhir;
    public $namabahanmakanan;
    public $jumlah;
    public $masuk;
    public $keluar;
    public $cekTgl;
    
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    
    public function searchInformasi() {
        
      
        $criteria = new CDbCriteria();        
        $criteria->limit = 10;
        $criteria->select = "bm.namabahanmakanan, bm.bahanmakanan_id,SUM(t.qty_masuk) as masuk, SUM(t.qty_keluar) as keluar, SUM(t.qty_current) as jumlah, bm.jmlpersediaan";
        $criteria->join =       "RIGHT JOIN bahanmakanan_m bm ON bm.bahanmakanan_id = t.bahanmakanan_id "
                            .   "LEFT JOIN terimabahandetail_t tbd ON tbd.terimabahandetail_id = t.terimabahandetail_id ".
                                "LEFT JOIN terimabahanmakan_t tbm ON tbm.terimabahanmakan_id = tbd.terimabahanmakan_id";
        if ($this->cekTgl == 1){
            $criteria->addBetweenCondition('tbm.tglterimabahan', $this->tgl_awal, $this->tgl_akhir);
        }
        $criteria->compare('LOWER(bm.namabahanmakanan)', strtolower($this->namabahanmakanan), TRUE);
        $criteria->group = "bm.bahanmakanan_id, bm.namabahanmakanan, jmlpersediaan";
        $criteria->order = "bm.namabahanmakanan ASC";
        return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
    }
}

?>
