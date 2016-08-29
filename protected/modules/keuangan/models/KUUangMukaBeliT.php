<?php

class KUUangMukaBeliT extends UangmukabeliT
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return UangmukabeliT the static model class
	 */
    
        public $tgl_awal, $tgl_akhir;
        public $nokaskeluar, $nopenerimaan, $nopermintaan;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
         public function searchInformasi() {
                $criteria=new CDbCriteria;
               // var_dump($this->tgl_awal);
                $criteria->with = array('penerimaanbarang','tandabuktikeluar','permintaanpembelian');
                $criteria->addBetweenCondition('tgluangmukabeli', $this->tgl_awal, $this->tgl_akhir);
		//$criteria->compare('uangmukabeli_id',$this->uangmukabeli_id);
                if (!empty($this->supplier_id)){
                    $criteria->addCondition("supplier_id = '".$this->supplier_id."' ");
                }
		$criteria->compare('supplier_id',$this->supplier_id);
                $criteria->compare('LOWER(penerimaanbarang.noterima)',  strtolower($this->nopenerimaan), TRUE);
		$criteria->compare('LOWER(tandabuktikeluar.nokaskeluar)',  strtolower($this->nokaskeluar), TRUE);
                $criteria->compare('LOWER(permintaanpembelian.nopermintaan)',  strtolower($this->nopermintaan), TRUE);
		//$criteria->compare('LOWER(namabank)',strtolower($this->namabank),true);
		//$criteria->compare('LOWER(norekening)',strtolower($this->norekening),true);
		//$criteria->compare('LOWER(rekatasnama)',strtolower($this->rekatasnama),true);
		//$criteria->compare('jumlahuang',$this->jumlahuang);
                //$criteria->addCondition("penerimaanbarang_id IS NOT NULL");

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
        }
}