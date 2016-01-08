<?php

class FAInfostokobatalkesruanganV extends InfostokobatalkesruanganV{
        public $tick,$data,$jumlah,$totalharga,$qtyinnetto,$qtyoutnetto,$qtycurrentnetto, $isGroupObat;
        public $tgl_awal,$tgl_akhir,$qtystok_current;
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    
    public function searchInformasi()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.
		$criteria=new CDbCriteria;
                                
                if($this->filterTanggal) {
                    $criteria->addBetweenCondition('DATE(tglstok_in)',$this->tgl_awal,$this->tgl_akhir);
                }
                    
                //Group berdasarkan Obat
                if($this->isGroupObat == 1){
                    $criteria->select = "jenisobatalkes_id,jenisobatalkes_nama,obatalkes_id,obatalkes_kode, obatalkes_nama, obatalkes_golongan, obatalkes_kategori, obatalkes_kadarobat, sumberdana_id, sumberdana_nama, satuankecil_nama, 
                        SUM(harganetto_oa) AS harganetto_oa, SUM(hargajual) AS hargajual, SUM(qtystok_in) AS qtystok_in, SUM(qtystok_out) AS qtystok_out, SUM(qtystok_current) AS qtystok_current";
                    $criteria->group = "jenisobatalkes_id,jenisobatalkes_nama,obatalkes_id,obatalkes_kode, obatalkes_nama, obatalkes_golongan, obatalkes_kategori, obatalkes_kadarobat, sumberdana_id, sumberdana_nama, satuankecil_nama";
                }
                $ruangansession = Yii::app()->user->ruangan_id;
				if(!empty($this->jenisobatalkes_id)){
					$criteria->addCondition("jenisobatalkes_id = ".$this->jenisobatalkes_id);						
				}
                $criteria->compare('LOWER(jenisobatalkes_nama)',strtolower($this->jenisobatalkes_nama),true);
                $criteria->compare('LOWER(obatalkes_kode)',strtolower($this->obatalkes_kode),true);
                $criteria->compare('LOWER(obatalkes_nama)',strtolower($this->obatalkes_nama),true);
                $criteria->compare('LOWER(obatalkes_golongan)',strtolower($this->obatalkes_golongan),true);
                $criteria->compare('LOWER(obatalkes_kategori)',strtolower($this->obatalkes_kategori),true);
                $criteria->compare('LOWER(obatalkes_kadarobat)',strtolower($this->obatalkes_kadarobat),true);
                $criteria->compare('kemasanbesar',$this->kemasanbesar);
                $criteria->compare('kekuatan',$this->kekuatan);
                $criteria->compare('LOWER(satuankekuatan)',strtolower($this->satuankekuatan),true);
                $criteria->compare('minimalstok',$this->minimalstok);
				if(!empty($this->satuankecil_id)){
					$criteria->addCondition("satuankecil_id = ".$this->satuankecil_id);						
				}
                $criteria->compare('LOWER(satuankecil_nama)',strtolower($this->satuankecil_nama),true);
				if(!empty($this->sumberdana_id)){
					$criteria->addCondition("sumberdana_id = ".$this->sumberdana_id);						
				}
                $criteria->compare('LOWER(sumberdana_nama)',strtolower($this->sumberdana_nama),true);
				if(!empty($ruangansession)){
					$criteria->addCondition("ruangan_id = ".$ruangansession);						
				}
                $criteria->compare('LOWER(ruangan_nama)',strtolower($this->ruangan_nama),true);
				if(!empty($this->instalasi_id)){
					$criteria->addCondition("instalasi_id = ".$this->instalasi_id);						
				}
                $criteria->compare('LOWER(tglstok_in)',strtolower($this->tglstok_in),true);
                $criteria->compare('LOWER(tglstok_out)',strtolower($this->tglstok_out),true);
                $criteria->compare('qtystok_in',$this->qtystok_in);
                $criteria->compare('qtystok_out',$this->qtystok_out);
                $criteria->compare('qtystok_current',$this->qtystok_current);
                $criteria->compare('harganetto_oa',$this->harganetto_oa);
                $criteria->compare('hargajual',$this->hargajual);
                $criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
                $criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
                $criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
                $criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
                $criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);
				if(!empty($this->penerimaandetail_id)){
					$criteria->addCondition("penerimaandetail_id = ".$this->penerimaandetail_id);						
				}
                $criteria->addCondition('qtystok_current > 0');
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        public function searchInformasiStok(){
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.
		$criteria=new CDbCriteria;
                //Group berdasarkan Obat
                $criteria->select = "jenisobatalkes_id,jenisobatalkes_nama,obatalkes_id,obatalkes_kode, obatalkes_nama, obatalkes_golongan, obatalkes_kategori, obatalkes_kadarobat, sumberdana_id, sumberdana_nama, satuankecil_nama, 
                    SUM(harganetto) AS harganetto, SUM(hargajual) AS hargajual, SUM(qtystok_in) AS qtystok_in, SUM(qtystok_out) AS qtystok_out, SUM(qtystok_in-qtystok_out) AS qtystok_current";
                $criteria->group = "jenisobatalkes_id,jenisobatalkes_nama,obatalkes_id,obatalkes_kode, obatalkes_nama, obatalkes_golongan, obatalkes_kategori, obatalkes_kadarobat, sumberdana_id, sumberdana_nama, satuankecil_nama";
                $ruangansession = Yii::app()->user->ruangan_id;
				if(!empty($this->jenisobatalkes_id)){
					$criteria->addCondition("jenisobatalkes_id = ".$this->jenisobatalkes_id);						
				}
                $criteria->compare('LOWER(jenisobatalkes_nama)',strtolower($this->jenisobatalkes_nama),true);
                $criteria->compare('LOWER(obatalkes_kode)',strtolower($this->obatalkes_kode),true);
                $criteria->compare('LOWER(obatalkes_nama)',strtolower($this->obatalkes_nama),true);
                $criteria->compare('LOWER(obatalkes_golongan)',strtolower($this->obatalkes_golongan),true);
                $criteria->compare('LOWER(obatalkes_kategori)',strtolower($this->obatalkes_kategori),true);
                $criteria->compare('LOWER(obatalkes_kadarobat)',strtolower($this->obatalkes_kadarobat),true);
                $criteria->compare('kemasanbesar',$this->kemasanbesar);
                $criteria->compare('kekuatan',$this->kekuatan);
                $criteria->compare('LOWER(satuankekuatan)',strtolower($this->satuankekuatan),true);
                $criteria->compare('minimalstok',$this->minimalstok);
				if(!empty($this->satuankecil_id)){
					$criteria->addCondition("satuankecil_id = ".$this->satuankecil_id);						
				}
                $criteria->compare('LOWER(satuankecil_nama)',strtolower($this->satuankecil_nama),true);
				if(!empty($this->sumberdana_id)){
					$criteria->addCondition("sumberdana_id = ".$this->sumberdana_id);						
				}
                $criteria->compare('LOWER(sumberdana_nama)',strtolower($this->sumberdana_nama),true);
                $criteria->addCondition('ruangan_id = '.Yii::app()->user->getState('ruangan_id'));
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
    
      public function criteriaCategory()
                {
		$criteria=new CDbCriteria;

                                $criteria->select =
                                        'hargajual,harganetto_oa,jenisobatalkes_id, obatalkes_nama,obatalkes_kode,jenisobatalkes_nama,obatalkes_golongan,sumberdana_nama,satuankecil_nama,
                                        tglkadaluarsa,
                                        SUM(qtystok_in) AS qtystok_in,
                                        SUM(qtystok_out) AS qtystok_out,
                                        SUM(qtystok_current) AS qtystok_current,
                                        SUM(qtystok_in * harganetto_oa) As qtyinnetto,
                                        SUM(qtystok_out * harganetto_oa) As qtyoutnetto,
                                        SUM(qtystok_current * harganetto_oa) As qtycurrentnetto';
                                $criteria->group = 'jenisobatalkes_id, obatalkes_nama,obatalkes_kode,jenisobatalkes_nama,obatalkes_golongan,sumberdana_nama,satuankecil_nama,
                                                    hargajual, harganetto_oa, tglkadaluarsa';
		if(!empty($this->obatalkes_id)){
			$criteria->addCondition("obatalkes_id = ".$this->obatalkes_id);						
		}
		$criteria->addCondition('ruangan_id = '.Yii::app()->user->getState('ruangan_id'));
		if(!empty($this->jenisobatalkes_id)){
			$criteria->addCondition("jenisobatalkes_id = ".$this->jenisobatalkes_id);						
		}
		$criteria->compare('LOWER(jenisobatalkes_nama)',strtolower($this->jenisobatalkes_nama),true);
		$criteria->compare('LOWER(obatalkes_kode)',strtolower($this->obatalkes_kode),true);
		$criteria->compare('LOWER(obatalkes_nama)',strtolower($this->obatalkes_nama),true);
		$criteria->compare('LOWER(obatalkes_golongan)',strtolower($this->obatalkes_golongan),true);
		$criteria->compare('LOWER(obatalkes_kategori)',strtolower($this->obatalkes_kategori),true);
		$criteria->compare('LOWER(obatalkes_kadarobat)',strtolower($this->obatalkes_kadarobat),true);
		$criteria->compare('kemasanbesar',$this->kemasanbesar);
		$criteria->compare('kekuatan',$this->kekuatan);
		$criteria->compare('LOWER(satuankekuatan)',strtolower($this->satuankekuatan),true);
		$criteria->compare('minimalstok',$this->minimalstok);
		if(!empty($this->satuankecil_id)){
			$criteria->addCondition("satuankecil_id = ".$this->satuankecil_id);						
		}
		$criteria->compare('LOWER(satuankecil_nama)',strtolower($this->satuankecil_nama),true);
		if(!empty($this->sumberdana_id)){
			$criteria->addCondition("sumberdana_id = ".$this->sumberdana_id);						
		}
		$criteria->compare('LOWER(sumberdana_nama)',strtolower($this->sumberdana_nama),true);
		if(!empty($ruangansession)){
			$criteria->addCondition("ruangan_id = ".$ruangansession);						
		}
		$criteria->compare('LOWER(ruangan_nama)',strtolower($this->ruangan_nama),true);
		if(!empty($this->instalasi_id)){
			$criteria->addCondition("instalasi_id = ".$this->instalasi_id);						
		}
		$criteria->compare('LOWER(tglstok_in)',strtolower($this->tglstok_in),true);
		$criteria->compare('LOWER(tglstok_out)',strtolower($this->tglstok_out),true);
		$criteria->compare('qtystok_in',$this->qtystok_in);
		$criteria->compare('qtystok_out',$this->qtystok_out);
		$criteria->compare('qtystok_current',$this->qtystok_current);
		$criteria->compare('harganetto_oa',$this->harganetto_oa);
		$criteria->compare('hargajual',$this->hargajual);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
		$criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);
		if(!empty($this->penerimaandetail_id)){
			$criteria->addCondition("penerimaandetail_id = ".$this->penerimaandetail_id);						
		}
		$criteria->addCondition('qtystok_current > 0');
		$criteria->addBetweenCondition('DATE(tglstok_in)',$this->tgl_awal,$this->tgl_akhir);
                
                                return $criteria;
                }
                
//	public function searchInformasi()
//	{
//		// Warning: Please modify the following code to remove attributes that
//		// should not be searched.
//
//		return new CActiveDataProvider($this, array(
//			'criteria'=>$this->criteriaCategory(),
//		));
//	}
        
                public function searchCategoryprint()
                {
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		return new CActiveDataProvider($this, array(
			'criteria'=>$this->criteriaCategory(),
                                                'pagination'=>false,
		));
                }
                
        // Modify in February, 21 2013 //
         public function getQtystock_in()
         {
             $criteria=$this->criteriaCategory();
             $criteria->select = 'SUM(qtystok_in)';
             return $this->commandBuilder->createFindCommand($this->getTableSchema(),$criteria)->queryScalar();
         }
                
         public function getTotalqtystok_in()
        {
            $criteria=$this->criteriaCategory();
            $criteria->select = 'SUM(qtystok_in)';
            return $this->commandBuilder->createFindCommand($this->getTableSchema(),$criteria)->queryScalar();
        }
        
        public function getTotalhargajual()
        {
            $criteria=$this->criteriaCategory();
            $criteria->select = 'SUM(hargajual)';
            return $this->commandBuilder->createFindCommand($this->getTableSchema(),$criteria)->queryScalar();
        }
        
        public function getTotalharga()
        {
            $criteria=$this->criteriaCategory();
            $criteria->select = '(SUM(hargajual) * SUM(qtystok_in)) AS totalharga';
            return $this->commandBuilder->createFindCommand($this->getTableSchema(),$criteria)->queryScalar();
        }
        
        public function searchGrafik()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

		$criteria=new CDbCriteria;
		$criteria->select = 'count(obatalkes_kode) as jumlah, obatalkes_nama as data';
		$criteria->group = 'obatalkes_nama,obatalkes_kode';
		$criteria->addBetweenCondition('date(tglstok_in)', $this->tgl_awal, $this->tgl_akhir);
		if(!empty($this->jenisobatalkes_id)){
			$criteria->addCondition("jenisobatalkes_id = ".$this->jenisobatalkes_id);						
		}
		$criteria->compare('LOWER(jenisobatalkes_nama)',strtolower($this->jenisobatalkes_nama),true);
		$criteria->compare('LOWER(obatalkes_kode)',strtolower($this->obatalkes_kode),true);
		if(!empty($this->satuankecil_id)){
			$criteria->addCondition("satuankecil_id = ".$this->satuankecil_id);						
		}
		$criteria->compare('LOWER(satuankecil_nama)',strtolower($this->satuankecil_nama),true);
		$criteria->compare('LOWER(obatalkes_nama)',strtolower($this->obatalkes_nama),true);
		$criteria->compare('hargajual',$this->hargajual);
		$criteria->compare('minimalstok',$this->minimalstok);
		$criteria->compare('qtystok_in',$this->qtystok_in);
		$criteria->compare('qtystok_out',$this->qtystok_out);
		$criteria->compare('qtystok_current',$this->qtystok_current);
		$criteria->compare('LOWER(ruangan_id)',strtolower($this->ruangan_id),true);
		$criteria->addBetweenCondition('DATE(tglstok_in)',$this->tgl_awal, $this->tgl_akhir);
		$criteria->addCondition('ruangan_id = '.Yii::app()->user->getState('ruangan_id'));
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
               // $criteria->limit=-1; 
                return  new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
        ));
        }
		
		public function search()
		{
			return new CActiveDataProvider($this, array(
				'criteria'=>$this->criteria(),
							'pagination'=>array(
								'pageSize'=>10,
							)
			));
		}
		
        public function searchPrint()
        {
            $criteria = $this->criteria();
            $criteria->limit=-1; 
            return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
  
        public function searchGrafikStock(){
        
            $criteria = $this->Criteria();

            $criteria2 = $criteria;
            $criteria2->select = 'count(obatalkes_id) as jumlah, obatalkes_nama as data'; 
            $criteria2->group = 'obatalkes_nama';


            return  new CActiveDataProvider($this, array(
                        'criteria'=>$criteria2,
            ));

        }
         public function Criteria()
        {
            $criteria=new CDbCriteria;

//            $criteria->with=array('obatalkes');
//            $criteria->join = 'LEFT JOIN obatalkes_m ON obatalkes_m.obatalkes_id=stokobatalkes_t.obatalkes_id';
            $criteria->select = 'obatalkes_kode, hargajual, obatalkes_nama, SUM(qtystok_in-qtystok_out) AS qty_current, SUM(qtystok_in) AS qty_in, SUM(qtystok_out) AS qty_out, 
                                (SUM(hargajual) * SUM(qtystok_in)) AS totalharga';
            $criteria->group = 'obatalkes_kode, hargajual, obatalkes_nama';
			if(!empty($this->jenisobatalkes_id)){
				$criteria->addCondition("jenisobatalkes_id = ".$this->jenisobatalkes_id);						
			}
            $criteria->addCondition('ruangan_id = '.Yii::app()->user->ruangan_id);
            $criteria->compare('LOWER(obatalkes_nama)',strtolower($this->obatalkes_nama),true);
            $criteria->compare('LOWER(obatalkes_kode)',strtolower($this->obatalkes_kode),true);
//            $criteria->compare('qtystok_in',$this->qtystok_in);
//            $criteria->compare('qtystok_out',$this->qtystok_out);
//            $criteria->compare('qtystok_current',$this->qtystok_current);
            
            if($this->qtystok_in == null)
                $criteria->addCondition('qtystok_in != 0');
            
            if($this->qtystok_out == null)
                $criteria->addCondition('qtystok_out != 0');
//            $criteria->addBetweenCondition('tglstok_in',$this->tgl_awal, $this->tgl_akhir);

            return $criteria;
        }
        
        // End Modify //
}

?>
