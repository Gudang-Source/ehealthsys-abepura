
<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class MAInvgedungT extends InvgedungT
{
    public $barang_nama;
    public $tgl_awal, $tgl_akhir;
    
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return KabupatenM the static model class
     */
    public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }
    
    public function searchInformasiGedungDanBangunan()
    {
        $criteria = new CDbCriteria();
        $criteria->with = array('barang');
        $criteria->addBetweenCondition('t.tglpenghapusan', $this->tgl_awal, $this->tgl_akhir);
        $criteria->compare('LOWER(t.invgedung_kode)', strtolower($this->invgedung_kode), TRUE);        
        $criteria->compare('LOWER(t.invgedung_noregister)', strtolower($this->invgedung_noregister), TRUE);
        $criteria->compare('LOWER(barang.barang_nama)', strtolower($this->barang_nama), TRUE);        
        $criteria->addCondition(" t.tipepenghapusan iLIKE '".Params::TIPE_PENGHAAPUSAN_PENJUALAN."' ");
        $criteria->limit = 10;
        
        return new CActiveDataProvider($this, array(
                'criteria'=>$criteria,
        ));
    }
}
?>
