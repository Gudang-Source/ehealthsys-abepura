
<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class MAInvperalatanT extends InvperalatanT
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
    
    public function searchInformasiPeralatanMedis()
    {
        $criteria = new CDbCriteria();
        $criteria->with = array('barang');
        $criteria->addBetweenCondition('t.tglpenghapusan::date', $this->tgl_awal, $this->tgl_akhir);
        $criteria->compare('LOWER(t.invperalatan_kode)', strtolower($this->invperalatan_kode), TRUE);        
        $criteria->compare('LOWER(t.invperalatan_noregister)', strtolower($this->invperalatan_noregister), TRUE);
        $criteria->compare('LOWER(barang.barang_nama)', strtolower($this->barang_nama), TRUE);
        $criteria->addCondition("split_part(t.invperalatan_noregister,'-',3)='04'");
        $criteria->addCondition(" t.tipepenghapusan iLIKE '".Params::TIPE_PENGHAAPUSAN_PENJUALAN."' ");
        $criteria->limit = 10;
        
        return new CActiveDataProvider($this, array(
                'criteria'=>$criteria,
        ));
    }
    
    public function searchInformasiPeralatanNonMedis()
    {
        $criteria = new CDbCriteria();
        $criteria->with = array('barang');
        $criteria->addBetweenCondition('t.tglpenghapusan::date', $this->tgl_awal, $this->tgl_akhir);
        $criteria->compare('LOWER(t.invperalatan_kode)', strtolower($this->invperalatan_kode), TRUE);        
        $criteria->compare('LOWER(t.invperalatan_noregister)', strtolower($this->invperalatan_noregister), TRUE);
        $criteria->compare('LOWER(barang.barang_nama)', strtolower($this->barang_nama), TRUE);
        $criteria->addCondition("split_part(t.invperalatan_noregister,'-',3)='05'");
        $criteria->addCondition(" t.tipepenghapusan iLIKE '".Params::TIPE_PENGHAAPUSAN_PENJUALAN."' ");
        $criteria->limit = 10;
        
        return new CActiveDataProvider($this, array(
                'criteria'=>$criteria,
        ));
    }
    
    public function searchInformasiKendaraan()
    {
        $criteria = new CDbCriteria();
        $criteria->with = array('barang');
        $criteria->addBetweenCondition('t.tglpenghapusan::date', $this->tgl_awal, $this->tgl_akhir);
        $criteria->compare('LOWER(t.invperalatan_kode)', strtolower($this->invperalatan_kode), TRUE);        
        $criteria->compare('LOWER(t.invperalatan_noregister)', strtolower($this->invperalatan_noregister), TRUE);
        $criteria->compare('LOWER(barang.barang_nama)', strtolower($this->barang_nama), TRUE);
        $criteria->addCondition("split_part(t.invperalatan_noregister,'-',3)='03'");
        $criteria->addCondition(" t.tipepenghapusan iLIKE '".Params::TIPE_PENGHAAPUSAN_PENJUALAN."' ");
        $criteria->limit = 10;
        
        return new CActiveDataProvider($this, array(
                'criteria'=>$criteria,
        ));
    }
}
?>
