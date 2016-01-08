<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class RILaporanpemakaiobatalkesV extends LaporanpemakaiobatalkesV  {

    public $jns_periode,$tgl_awal,$tgl_akhir,$bln_awal,$bln_akhir,$thn_awal,$thn_akhir;
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    
    public function searchGrafik()
	{
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria=new CDbCriteria;

            if (is_array($this->jenisobatalkes_id)){
                $criteria->addInCondition('jenisobatalkes_id',$this->jenisobatalkes_id);
            } else{
                $criteria->addCondition('jenisobatalkes_id = 0');
            }     
            $criteria->select = 'count(jenisobatalkes_id) as jumlah, jenisobatalkes_nama as tick, obatalkes_nama as data';
            $criteria->group = 'jenisobatalkes_nama, obatalkes_nama';

			if(!empty($this->obatalkes_id)){
				$criteria->addCondition("obatalkes_id = ".$this->obatalkes_id); 	
			}
            $criteria->compare('LOWER(jenisobatalkes_nama)',strtolower($this->jenisobatalkes_nama),true);
            $criteria->compare('LOWER(obatalkes_golongan)',strtolower($this->obatalkes_golongan),true);
            $criteria->compare('LOWER(obatalkes_kategori)',strtolower($this->obatalkes_kategori),true);
            $criteria->compare('LOWER(obatalkes_kode)',strtolower($this->obatalkes_kode),true);
            $criteria->compare('LOWER(obatalkes_nama)',strtolower($this->obatalkes_nama),true);
			if(!empty($this->satuankecil_id)){
				$criteria->addCondition("satuankecil_id = ".$this->satuankecil_id); 	
			}
            $criteria->compare('LOWER(satuankecil_nama)',strtolower($this->satuankecil_nama),true);
            $criteria->compare('LOWER(generik_nama)',strtolower($this->generik_nama),true);
			if(!empty($this->carabayar_id)){
				$criteria->addCondition("carabayar_id = ".$this->carabayar_id); 	
			}
            $criteria->compare('LOWER(carabayar_nama)',strtolower($this->carabayar_nama),true);
			if(!empty($this->penjamin_id)){
				$criteria->addCondition("penjamin_id = ".$this->penjamin_id); 	
			}
            $criteria->compare('LOWER(penjamin_nama)',strtolower($this->penjamin_nama),true);
			if(!empty($this->sumberdana_id)){
				$criteria->addCondition("sumberdana_id = ".$this->sumberdana_id); 	
			}
            $criteria->compare('LOWER(sumberdana_nama)',strtolower($this->sumberdana_nama),true);
            $criteria->addBetweenCondition('tglpelayanan',$this->tgl_awal, $this->tgl_akhir);
			if(!empty($this->ruangan_id)){
				$criteria->addCondition("ruangan_id = ".$this->ruangan_id); 	
			}
            $criteria->compare('qty_oa',$this->qty_oa);
            $criteria->compare('hargasatuan_oa',$this->hargasatuan_oa);

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));
	}
        
        public function searchTable()
	{
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria=new CDbCriteria;

			if (is_array($this->jenisobatalkes_id)){
					$criteria->addInCondition('jenisobatalkes_id',$this->jenisobatalkes_id);
			}
			else{
					$criteria->addCondition('jenisobatalkes_id = 0');
			}                                
			if(!empty($this->obatalkes_id)){
				$criteria->addCondition("obatalkes_id = ".$this->obatalkes_id); 	
			}
            $criteria->compare('LOWER(jenisobatalkes_nama)',strtolower($this->jenisobatalkes_nama),true);
            $criteria->compare('LOWER(obatalkes_golongan)',strtolower($this->obatalkes_golongan),true);
            $criteria->compare('LOWER(obatalkes_kategori)',strtolower($this->obatalkes_kategori),true);
            $criteria->compare('LOWER(obatalkes_kode)',strtolower($this->obatalkes_kode),true);
            $criteria->compare('LOWER(obatalkes_nama)',strtolower($this->obatalkes_nama),true);
			if(!empty($this->satuankecil_id)){
				$criteria->addCondition("satuankecil_id = ".$this->satuankecil_id); 	
			}
            $criteria->compare('LOWER(satuankecil_nama)',strtolower($this->satuankecil_nama),true);
            $criteria->compare('LOWER(generik_nama)',strtolower($this->generik_nama),true);
			if(!empty($this->carabayar_id)){
				$criteria->addCondition("carabayar_id = ".$this->carabayar_id); 	
			}
            $criteria->compare('LOWER(carabayar_nama)',strtolower($this->carabayar_nama),true);
			if(!empty($this->penjamin_id)){
				$criteria->addCondition("penjamin_id = ".$this->penjamin_id); 	
			}
            $criteria->compare('LOWER(penjamin_nama)',strtolower($this->penjamin_nama),true);
			if(!empty($this->sumberdana_id)){
				$criteria->addCondition("sumberdana_id = ".$this->sumberdana_id); 	
			}
            $criteria->compare('LOWER(sumberdana_nama)',strtolower($this->sumberdana_nama),true);
            $criteria->addBetweenCondition('tglpelayanan',$this->tgl_awal, $this->tgl_akhir);
			if(!empty($this->ruangan_id)){
				$criteria->addCondition("ruangan_id = ".$this->ruangan_id); 	
			}
            $criteria->compare('qty_oa',$this->qty_oa);
            $criteria->compare('hargasatuan_oa',$this->hargasatuan_oa);

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));
	}
        
        
        public function searchPrint()
        {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria=new CDbCriteria;

            if (is_array($this->jenisobatalkes_id)){
				$criteria->addInCondition('jenisobatalkes_id',$this->jenisobatalkes_id);
            }
            else{
				$criteria->addCondition('jenisobatalkes_id = 0');
            }                                

            $criteria->compare('LOWER(jenisobatalkes_nama)',strtolower($this->jenisobatalkes_nama),true);
            $criteria->compare('LOWER(obatalkes_golongan)',strtolower($this->obatalkes_golongan),true);
            $criteria->compare('LOWER(obatalkes_kategori)',strtolower($this->obatalkes_kategori),true);
            $criteria->compare('LOWER(obatalkes_kode)',strtolower($this->obatalkes_kode),true);
            $criteria->compare('LOWER(obatalkes_nama)',strtolower($this->obatalkes_nama),true);
			if(!empty($this->satuankecil_id)){
				$criteria->addCondition("satuankecil_id = ".$this->satuankecil_id); 	
			}
            $criteria->compare('LOWER(satuankecil_nama)',strtolower($this->satuankecil_nama),true);
            $criteria->compare('LOWER(generik_nama)',strtolower($this->generik_nama),true);
			if(!empty($this->carabayar_id)){
				$criteria->addCondition("carabayar_id = ".$this->carabayar_id); 	
			}
            $criteria->compare('LOWER(carabayar_nama)',strtolower($this->carabayar_nama),true);
			if(!empty($this->penjamin_id)){
				$criteria->addCondition("penjamin_id = ".$this->penjamin_id); 	
			}
            $criteria->compare('LOWER(penjamin_nama)',strtolower($this->penjamin_nama),true);
			if(!empty($this->sumberdana_id)){
				$criteria->addCondition("sumberdana_id = ".$this->sumberdana_id); 	
			}
            $criteria->compare('LOWER(sumberdana_nama)',strtolower($this->sumberdana_nama),true);
            $criteria->addBetweenCondition('tglpelayanan',$this->tgl_awal, $this->tgl_akhir);
			if(!empty($this->ruangan_id)){
				$criteria->addCondition("ruangan_id = ".$this->ruangan_id); 	
			}
            $criteria->compare('qty_oa',$this->qty_oa);
            $criteria->compare('hargasatuan_oa',$this->hargasatuan_oa);
            // Klo limit lebih kecil dari nol itu berarti ga ada limit 
            $criteria->limit=-1; 

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
                    'pagination'=>false,
            ));
        }

}

?>
