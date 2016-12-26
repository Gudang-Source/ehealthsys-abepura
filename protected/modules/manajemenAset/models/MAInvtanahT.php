<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class MAInvtanahT extends InvtanahT
{    
    public $tgl_awal;
    public $tgl_akhir;
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return KabupatenM the static model class
     */
    public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }
    
    public function getTahunNama(){
        return $this->invtanah_thnpengadaan.PHP_EOL."".$this->invtanah_tglguna;
    }
    public function getSertifikat(){
        return $this->invtanah_nosertifikat.'--'.$this->invtanah_tglsertifikat;
    }
    
    public function searchInformasiTanah()
    {
        $criteria = new CDbCriteria();
        $criteria->with = array('barang');
        $criteria->addBetweenCondition('t.tglpenghapusan::date', $this->tgl_awal, $this->tgl_akhir);
        $criteria->compare('LOWER(t.invtanah_kode)', strtolower($this->invtanah_kode), TRUE);        
        $criteria->compare('LOWER(t.invtanah_noregister)', strtolower($this->invtanah_noregister), TRUE);
        $criteria->compare('LOWER(barang.barang_nama)', strtolower($this->barang_nama), TRUE);
        $criteria->addCondition(" t.tipepenghapusan iLIKE '".Params::TIPE_PENGHAAPUSAN_PENJUALAN."' ");
        // $criteria->limit = 10;
        
        return new CActiveDataProvider($this, array(
                'criteria'=>$criteria,
        ));
    }
}
?>
