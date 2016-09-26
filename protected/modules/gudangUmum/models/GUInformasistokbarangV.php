<?php

class GUInformasistokbarangV extends InformasistokbarangV
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InformasistokbarangV the static model class
	 */
        public $tgl_awal, $tgl_akhir;
        public $bln_awal, $bln_akhir;
        public $thn_awal, $thn_akhir;
        public $jns_periode;
        public $jumlah, $data;
        public $stok;
        
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CdbCriteria that can return criterias.
	 */
	public function criteriaSearch()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		if(!empty($this->barang_id)){
			$criteria->addCondition('barang_id = '.$this->barang_id);
		}
		$criteria->compare('LOWER(barang_type)',strtolower($this->barang_type),true);
		$criteria->compare('LOWER(barang_kode)',strtolower($this->barang_kode),true);
		$criteria->compare('LOWER(barang_nama)',strtolower($this->barang_nama),true);
		$criteria->compare('LOWER(barang_merk)',strtolower($this->barang_merk),true);
		$criteria->compare('LOWER(barang_noseri)',strtolower($this->barang_noseri),true);
		$criteria->compare('LOWER(barang_ukuran)',strtolower($this->barang_ukuran),true);
		$criteria->compare('LOWER(barang_thnbeli)',strtolower($this->barang_thnbeli),true);
		if(!empty($this->ruangan_id)){
			$criteria->addCondition('ruangan_id = '.$this->ruangan_id);
		}
		if(!empty($this->instalasi_id)){
			$criteria->addCondition('instalasi_id = '.$this->instalasi_id);
		}

		return $criteria;
	}
        
        public function searchBarangRuangan()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		if(!empty($this->barang_id)){
			$criteria->addCondition('barang_id = '.$this->barang_id);
		}
		$criteria->compare('LOWER(barang_type)',strtolower($this->barang_type),true);
		$criteria->compare('LOWER(barang_kode)',strtolower($this->barang_kode),true);
		$criteria->compare('LOWER(barang_nama)',strtolower($this->barang_nama),true);
		$criteria->compare('LOWER(barang_merk)',strtolower($this->barang_merk),true);
		$criteria->compare('LOWER(barang_noseri)',strtolower($this->barang_noseri),true);
		$criteria->compare('LOWER(barang_ukuran)',strtolower($this->barang_ukuran),true);
		$criteria->compare('LOWER(barang_thnbeli)',strtolower($this->barang_thnbeli),true);
                $criteria->compare('LOWER(barang_satuan)',strtolower($this->barang_satuan),true);
		if(!empty($this->ruangan_id)){
			$criteria->addCondition('ruangan_id = '.$this->ruangan_id);
		}else{
                    $criteria->addCondition('ruangan_id is null ');
                }
		//if(!empty($this->instalasi_id)){
		//	$criteria->addCondition('instalasi_id = '.$this->instalasi_id);
		//}
                $criteria->limit=10;
                
		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
		));
	}
                
        
        
	/**
	 * untuk informasi stok
	 */
	public function searchInformasi()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=$this->criteriaSearch();
		$criteria->limit=10;

		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
		));
	}
        
        
        public function searchMaterialHabisTable() {
            $criteria = new CDbCriteria();
            $criteria = $this->functionMaterialHabisCriteria();
            $criteria->order = 'ruangan_nama, barang_nama ASC';

            return new CActiveDataProvider($this, array(
                        'criteria' => $criteria,
                    ));
        }

        public function searchMaterialHabisPrint() {
            $criteria = new CDbCriteria();
            $criteria = $this->functionMaterialHabisCriteria();
            $criteria->order = 'ruangan_nama, barang_nama ASC';
            $criteria->limit = -1;

            return new CActiveDataProvider($this, array(
                        'criteria' => $criteria,
                        'pagination' => false,
                    ));
        }

        protected function functionMaterialHabisCriteria() {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria = new CDbCriteria;

            $criteria->compare('LOWER(barang_nama)',strtolower($this->barang_nama), TRUE);
            $criteria->compare('LOWER(barang_noseri)',strtolower($this->barang_noseri), TRUE);
            $criteria->compare('LOWER(barang_merk)',strtolower($this->barang_merk), TRUE);
            $criteria->compare('LOWER(barang_kode)',strtolower($this->barang_kode), TRUE);
            
            if ($this->stok == '0'){
                $criteria->addCondition(" inventarisasi_stok = 0 ");
            }elseif ($this->stok == '1'){
                $criteria->addCondition(" inventarisasi_stok > 0 ");
            }
            
            if(!empty($this->ruangan_id)){                    
                $criteria->addInCondition('ruangan_id', $this->ruangan_id);
            }else{
               if (!empty($this->instalasi_id)){
                   $criteria->addCondition("instalasi_id = '".$this->instalasi_id."' ");
               }
            }
            


            return $criteria;
        }

         public function searchMaterialHabisGrafik()
         {
                    // Warning: Please modify the following code to remove attributes that
                    // should not be searched.

                $criteria=new CDbCriteria;

                $criteria->select = "count(barang_id) as jumlah , (CASE WHEN inventarisasi_stok > 0 THEN 'Stok Ada' ELSE 'Habis' END) as data";
                
                $criteria->compare('LOWER(barang_nama)',strtolower($this->barang_nama), TRUE);
                $criteria->compare('LOWER(barang_noseri)',strtolower($this->barang_noseri), TRUE);
                $criteria->compare('LOWER(barang_merk)',strtolower($this->barang_merk), TRUE);
                $criteria->compare('LOWER(barang_kode)',strtolower($this->barang_kode), TRUE);
                
                if ($this->stok == '0'){
                    $criteria->addCondition(" inventarisasi_stok = 0 ");
                }elseif ($this->stok == '1'){
                    $criteria->addCondition(" inventarisasi_stok > 0 ");
                }
                
                if(!empty($this->ruangan_id)){                    
                    $criteria->addInCondition('ruangan_id', $this->ruangan_id);
                }else{
                   if (!empty($this->instalasi_id)){
                       $criteria->addCondition("instalasi_id = '".$this->instalasi_id."' ");
                   }
                }
                $criteria->group = 'inventarisasi_stok, ruangan_nama ';
                $criteria->order = 'jumlah DESC';

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                ));
        }        
}