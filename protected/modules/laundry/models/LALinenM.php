<?php
class LALinenM extends LinenM {
	
	public $barang_nama;
	public $jenislinen_nama;
	
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function searchDialog()
	{
	   // Warning: Please modify the following code to remove attributes that
	   // should not be searched.

	    $criteria=new CDbCriteria;
        $criteria->join = " LEFT JOIN  barang_m b ON b.barang_id = t.barang_id  "
						. " LEFT JOIN  jenislinen_m jl ON jl.jenislinen_id = t.jenislinen_id   "  ;
		if(!empty($this->linen_id)){
			$criteria->addCondition('t.linen_id = '.$this->linen_id);
		}
		if(!empty($this->jenislinen_id)){
			$criteria->addCondition('t.jenislinen_id = '.$this->jenislinen_id);
		}
		if(!empty($this->ruangan_id)){
			$criteria->addCondition('t.ruangan_id = '.$this->ruangan_id);
		}
		if(!empty($this->rakpenyimpanan_id)){
			$criteria->addCondition('t.rakpenyimpanan_id = '.$this->rakpenyimpanan_id);
		}
		if(!empty($this->bahanlinen_id)){
			$criteria->addCondition('t.bahanlinen_id = '.$this->bahanlinen_id);
		}
		if(!empty($this->barang_id)){
			$criteria->addCondition('t.barang_id = '.$this->barang_id);
		}
		$criteria->compare('LOWER(t.kodelinen)',strtolower($this->kodelinen),true);
		$criteria->compare('LOWER(t.tglregisterlinen)',strtolower($this->tglregisterlinen),true);
		$criteria->compare('LOWER(t.noregisterlinen)',strtolower($this->noregisterlinen),true);
		$criteria->compare('LOWER(t.namalinen)',strtolower($this->namalinen),true);
		$criteria->compare('LOWER(t.namalainnya)',strtolower($this->namalainnya),true);
		$criteria->compare('LOWER(t.merklinen)',strtolower($this->merklinen),true);
		if(!empty($this->beratlinen)){
			$criteria->addCondition('t.beratlinen = '.$this->beratlinen);
		}
		$criteria->compare('LOWER(t.warna)',strtolower($this->warna),true);
		$criteria->compare('LOWER(t.tahunbeli)',strtolower($this->tahunbeli),true);
		$criteria->compare('LOWER(t.gambarlinen)',strtolower($this->gambarlinen),true);
		if(!empty($this->jmlcucilinen)){
			$criteria->addCondition('t.jmlcucilinen = '.$this->jmlcucilinen);
		}
		$criteria->compare('LOWER(t.create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(t.update_time)',strtolower($this->update_time),true);
		if(!empty($this->create_loginpemakai_id)){
			$criteria->addCondition('t.create_loginpemakai_id = '.$this->create_loginpemakai_id);
		}
		if(!empty($this->update_loginpemakai_id)){
			$criteria->addCondition('t.update_loginpemakai_id = '.$this->update_loginpemakai_id);
		}
		if(!empty($this->create_ruangan)){
			$criteria->addCondition('t.create_ruangan = '.$this->create_ruangan);
		} 
		$criteria->compare('t.linen_aktif',$this->linen_aktif);
		$criteria->compare('LOWER(t.satuanlinen)',strtolower($this->satuanlinen),true);
		$criteria->compare('LOWER(b.barang_nama)',strtolower($this->barang_nama),true);
		$criteria->compare('LOWER(jl.jenislinen_nama)',strtolower($this->jenislinen_nama),true);
		// $criteria->addCondition("linen_id in(select linen_id from penyimpananlinen_t)");
		// $criteria->limit=10;
             
	   return new CActiveDataProvider($this, array(
			   'criteria'=>$criteria,
	   ));
	}
}
