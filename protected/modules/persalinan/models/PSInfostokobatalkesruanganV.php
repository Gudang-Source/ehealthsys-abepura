<?php

class PSInfostokobatalkesruanganV extends InfostokobatalkesruanganV{
  
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
   
        public function searchDataObat()
        {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria=new CDbCriteria;
                $criteria->select = "obatalkes_id,obatalkes_nama,obatalkes_golongan,obatalkes_kategori,jenisobatalkes_id,jenisobatalkes_nama,obatalkes_kode,satuankecil_nama, tglkadaluarsa";
                //var_dump($this->instalasi_id);
		if(!empty($this->instalasi_id)){
			$criteria->addCondition('instalasi_id = '.$this->instalasi_id);
                }else{
                    $criteria->addCondition('instalasi_id is NULL ');
                }
		$criteria->compare('LOWER(instalasi_nama)',strtolower($this->instalasi_nama),true);
                
		if(!empty($this->ruangan_id)){
			$criteria->addCondition('ruangan_id = '.$this->ruangan_id);
                }else{
                   $criteria->addCondition('ruangan_id is NULL ');
                }
		//$criteria->compare('LOWER(ruangan_nama)',strtolower($this->ruangan_nama),true);
		if(!empty($this->jenisobatalkes_id)){
			$criteria->addCondition('jenisobatalkes_id = '.$this->jenisobatalkes_id);
		}		
		$criteria->compare('LOWER(jenisobatalkes_nama)',strtolower($this->jenisobatalkes_nama),true);		
		if(!empty($this->obatalkes_id)){
			$criteria->addCondition('obatalkes_id = '.$this->obatalkes_id);
		}		
		$criteria->compare('LOWER(obatalkes_kode)',strtolower($this->obatalkes_kode),true);
		$criteria->compare('LOWER(obatalkes_nama)',strtolower($this->obatalkes_nama),true);		
		$criteria->compare('LOWER(obatalkes_golongan)',strtolower($this->obatalkes_golongan),true);
		$criteria->compare('LOWER(obatalkes_kategori)',strtolower($this->obatalkes_kategori),true);
		$criteria->compare('LOWER(obatalkes_kadarobat)',strtolower($this->obatalkes_kadarobat),true);
		if(!empty($this->satuankecil_id)){
			$criteria->addCondition('satuankecil_id = '.$this->satuankecil_id);
		}
		$criteria->compare('LOWER(satuankecil_nama)',strtolower($this->satuankecil_nama),true);		
                if(!empty($this->tglkadaluarsa)){
			 $criteria->addCondition("tglkadaluarsa ='$this->tglkadaluarsa'");
		}
               
		
		$criteria->compare('qtystok',$this->qtystok);
                $criteria->group = 'obatalkes_id, obatalkes_nama,obatalkes_golongan,obatalkes_kategori, jenisobatalkes_id,jenisobatalkes_nama,obatalkes_kode,satuankecil_nama, tglkadaluarsa';

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));
        }
        
       /*
        
        public function getStokObatRuanganPemesan($ruangan_id = null){ // menampilkan stok obat berdasarkan ruangan pemesan
            if(isset($_GET['pesanobatalkes_id'])){
                    $modInfoOa = GFInformasipesanobatalkesV::model()->findByAttributes(array('pesanobatalkes_id'=>$_GET['pesanobatalkes_id']));
                    if(!empty($modInfoOa)){
                            return StokobatalkesT::getJumlahStok($this->obatalkes_id,$modInfoOa->ruanganpemesan_id, $this->tglkadaluarsa);
                    }else{
                            return 0;
                    }
            }else{
                    if (empty($ruangan_id)) $ruangan_id = $this->ruangan_id;
                    return StokobatalkesT::getJumlahStok($this->obatalkes_id,$ruangan_id, $this->tglkadaluarsa);
            }
	}*/
        
        
        
}

?>
