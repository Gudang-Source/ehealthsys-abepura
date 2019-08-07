
<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class MAInfoInventarisasiRuanganV extends InfoinventarisasiruanganV
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
    
    public function searchInformasiAsetRumahSakit()
    {
        $criteria = new CDbCriteria();        
        //$criteria->addBetweenCondition('t.tglpenghapusan', $this->tgl_awal, $this->tgl_akhir);
        $criteria->compare('LOWER(inventarisasi_kode)', strtolower($this->inventarisasi_kode), TRUE);        
        $criteria->compare('LOWER(barang_nama)', strtolower($this->barang_nama), TRUE);
        $criteria->compare('LOWER(barang_kode)', strtolower($this->barang_kode), TRUE);        
        $criteria->compare('LOWER(barang_thnbeli)', strtolower($this->barang_thnbeli), TRUE);        
        $criteria->compare('LOWER(inventarisasi_keadaan)', strtolower($this->inventarisasi_keadaan), TRUE);        
        $criteria->addCondition(" LOWER(barang_type) ilike '%Aset%' ");
        if (!empty($this->ruangan_id)){
            $criteria->addCondition("ruangan_id = '".$this->ruangan_id."' ");
        }
        $criteria->limit = 10;
        
        return new CActiveDataProvider($this, array(
                'criteria'=>$criteria,
        ));
    }
}
?>
