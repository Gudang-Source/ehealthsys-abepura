<?php 
class GZTerimabahanmakan extends TerimabahanmakanT {

    public $temp_no;
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    
    public function searchInformasi()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
                
                $criteria->addBetweenCondition('DATE(tglterimabahan)', $this->tgl_awal, $this->tgl_akhir);
		$criteria->compare('terimabahanmakan_id',$this->terimabahanmakan_id);
		$criteria->compare('pengajuanbahanmkn_id',$this->pengajuanbahanmkn_id);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('supplier_id',$this->supplier_id);
		$criteria->compare('LOWER(sumberdanabhn)',strtolower($this->sumberdanabhn),true);
		$criteria->compare('LOWER(nopenerimaanbahan)',strtolower($this->nopenerimaanbahan),true);
//		$criteria->compare('LOWER(tglterimabahan)',strtolower($this->tglterimabahan),true);
		$criteria->compare('LOWER(nosuratjalan)',strtolower($this->nosuratjalan),true);
		$criteria->compare('LOWER(tglsurjalan)',strtolower($this->tglsurjalan),true);
		$criteria->compare('LOWER(nofaktur)',strtolower($this->nofaktur),true);
		$criteria->compare('LOWER(tglfaktur)',strtolower($this->tglfaktur),true);
		$criteria->compare('totalharganetto',$this->totalharganetto);
		$criteria->compare('totaldiscount',$this->totaldiscount);
		$criteria->compare('LOWER(keterangan_terima_bahan)',strtolower($this->keterangan_terima_bahan),true);
		$criteria->order='tglterimabahan DESC';
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	/**
         * menampilkan nama supplier 
         * @param type $ruangan_id = gizi
         * @param type $supplier_jenis = gizi
         * RSN-322
         */
        public function getSupplier()
        {
            $criteria = new CdbCriteria();
            $criteria->addCondition("supplier_jenis= '".Params::SUPPLIER_JENIS_GIZI."'");
            $criteria->addCondition('supplier_aktif = true');
            $modSupplier = SupplierM::model()->findAll($criteria);
            return $modSupplier;
        }
}
