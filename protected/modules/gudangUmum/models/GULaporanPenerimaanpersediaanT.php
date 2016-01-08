<?php

class GULaporanPenerimaanpersediaanT extends TerimapersediaanT{
    public $jns_periode,$tgl_awal,$tgl_akhir,$bln_awal,$bln_akhir,$thn_awal,$thn_akhir;
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    
    public function searchInformasi()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->addBetweenCondition('date(tglterima)', $this->tgl_awal, $this->tgl_akhir);
		if(!empty($this->terimapersediaan_id)){
			$criteria->addCondition("terimapersediaan_id = ".$this->terimapersediaan_id);			
		}
		if(!empty($this->pembelianbarang_id)){
			$criteria->addCondition("pembelianbarang_id = ".$this->pembelianbarang_id);			
		}
		if(!empty($this->sumberdana_id)){
			$criteria->addCondition("sumberdana_id = ".$this->sumberdana_id);			
		}
		if(!empty($this->returpenerimaan_id)){
			$criteria->addCondition("returpenerimaan_id = ".$this->returpenerimaan_id);			
		}
		$criteria->compare('LOWER(nopenerimaan)',strtolower($this->nopenerimaan),true);
		$criteria->compare('LOWER(tglsuratjalan)',strtolower($this->tglsuratjalan),true);
		$criteria->compare('LOWER(nosuratjalan)',strtolower($this->nosuratjalan),true);
		$criteria->compare('LOWER(tglfaktur)',strtolower($this->tglfaktur),true);
		$criteria->compare('LOWER(nofaktur)',strtolower($this->nofaktur),true);
		$criteria->compare('LOWER(keterangan_persediaan)',strtolower($this->keterangan_persediaan),true);
		$criteria->compare('totalharga',$this->totalharga);
		$criteria->compare('discount',$this->discount);
		$criteria->compare('biayaadministrasi',$this->biayaadministrasi);
		$criteria->compare('pajakpph',$this->pajakpph);
		$criteria->compare('pajakppn',$this->pajakppn);
		$criteria->compare('LOWER(nofakturpajak)',strtolower($this->nofakturpajak),true);
		if(!empty($this->peg_penerima_id)){
			$criteria->addCondition("peg_penerima_id = ".$this->peg_penerima_id);			
		}
		if(!empty($this->peg_mengetahui_id)){
			$criteria->addCondition("peg_mengetahui_id = ".$this->peg_mengetahui_id);			
		}
		if(!empty($this->ruanganpenerima_id)){
			$criteria->addCondition("ruanganpenerima_id = ".$this->ruanganpenerima_id);			
		}
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
		$criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        public function getNamaModel(){
            return __CLASS__;
        }
        
	public function searchPenerimaanPersediaan()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->addBetweenCondition('date(tglterima)', $this->tgl_awal, $this->tgl_akhir);
		if(!empty($this->terimapersediaan_id)){
			$criteria->addCondition("terimapersediaan_id = ".$this->terimapersediaan_id);			
		}
		if(!empty($this->pembelianbarang_id)){
			$criteria->addCondition("pembelianbarang_id = ".$this->pembelianbarang_id);			
		}
		if(!empty($this->sumberdana_id)){
			$criteria->addCondition("sumberdana_id = ".$this->sumberdana_id);			
		}
		if(!empty($this->returpenerimaan_id)){
			$criteria->addCondition("returpenerimaan_id = ".$this->returpenerimaan_id);			
		}
		$criteria->compare('LOWER(nopenerimaan)',strtolower($this->nopenerimaan),true);
		$criteria->compare('LOWER(tglsuratjalan)',strtolower($this->tglsuratjalan),true);
		$criteria->compare('LOWER(nosuratjalan)',strtolower($this->nosuratjalan),true);
		$criteria->compare('LOWER(tglfaktur)',strtolower($this->tglfaktur),true);
		$criteria->compare('LOWER(nofaktur)',strtolower($this->nofaktur),true);
		$criteria->compare('LOWER(keterangan_persediaan)',strtolower($this->keterangan_persediaan),true);
		$criteria->compare('totalharga',$this->totalharga);
		$criteria->compare('discount',$this->discount);
		$criteria->compare('biayaadministrasi',$this->biayaadministrasi);
		$criteria->compare('pajakpph',$this->pajakpph);
		$criteria->compare('pajakppn',$this->pajakppn);
		$criteria->compare('LOWER(nofakturpajak)',strtolower($this->nofakturpajak),true);
		if(!empty($this->peg_penerima_id)){
			$criteria->addCondition("peg_penerima_id = ".$this->peg_penerima_id);			
		}
		if(!empty($this->peg_mengetahui_id)){
			$criteria->addCondition("peg_mengetahui_id = ".$this->peg_mengetahui_id);			
		}
		if(!empty($this->ruanganpenerima_id)){
			$criteria->addCondition("ruanganpenerima_id = ".$this->ruanganpenerima_id);			
		}
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
		$criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

        public function searchPenerimaanPersediaanPrint()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->addBetweenCondition('date(tglterima)', $this->tgl_awal, $this->tgl_akhir);
		if(!empty($this->terimapersediaan_id)){
			$criteria->addCondition("terimapersediaan_id = ".$this->terimapersediaan_id);			
		}
		if(!empty($this->pembelianbarang_id)){
			$criteria->addCondition("pembelianbarang_id = ".$this->pembelianbarang_id);			
		}
		if(!empty($this->sumberdana_id)){
			$criteria->addCondition("sumberdana_id = ".$this->sumberdana_id);			
		}
		if(!empty($this->returpenerimaan_id)){
			$criteria->addCondition("returpenerimaan_id = ".$this->returpenerimaan_id);			
		}
		$criteria->compare('LOWER(nopenerimaan)',strtolower($this->nopenerimaan),true);
		$criteria->compare('LOWER(tglsuratjalan)',strtolower($this->tglsuratjalan),true);
		$criteria->compare('LOWER(nosuratjalan)',strtolower($this->nosuratjalan),true);
		$criteria->compare('LOWER(tglfaktur)',strtolower($this->tglfaktur),true);
		$criteria->compare('LOWER(nofaktur)',strtolower($this->nofaktur),true);
		$criteria->compare('LOWER(keterangan_persediaan)',strtolower($this->keterangan_persediaan),true);
		$criteria->compare('totalharga',$this->totalharga);
		$criteria->compare('discount',$this->discount);
		$criteria->compare('biayaadministrasi',$this->biayaadministrasi);
		$criteria->compare('pajakpph',$this->pajakpph);
		$criteria->compare('pajakppn',$this->pajakppn);
		$criteria->compare('LOWER(nofakturpajak)',strtolower($this->nofakturpajak),true);
		if(!empty($this->peg_penerima_id)){
			$criteria->addCondition("peg_penerima_id = ".$this->peg_penerima_id);			
		}
		if(!empty($this->peg_mengetahui_id)){
			$criteria->addCondition("peg_mengetahui_id = ".$this->peg_mengetahui_id);			
		}
		if(!empty($this->ruanganpenerima_id)){
			$criteria->addCondition("ruanganpenerima_id = ".$this->ruanganpenerima_id);			
		}
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
		$criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);
                $criteria->limit = -1;
                
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'pagination'=>false,
		));
	}
        
           public function searchTable() {
            $criteria = new CDbCriteria();
            $criteria = $this->functionCriteria();
            $criteria->order = 'tglterima';

            return new CActiveDataProvider($this, array(
                        'criteria' => $criteria,
                    ));
         }
     
        protected function functionCriteria() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->addBetweenCondition('date(tglterima)', $this->tgl_awal, $this->tgl_akhir);
		if(!empty($this->terimapersediaan_id)){
			$criteria->addCondition("terimapersediaan_id = ".$this->terimapersediaan_id);			
		}
		if(!empty($this->pembelianbarang_id)){
			$criteria->addCondition("pembelianbarang_id = ".$this->pembelianbarang_id);			
		}
		if(!empty($this->sumberdana_id)){
			$criteria->addCondition("sumberdana_id = ".$this->sumberdana_id);			
		}
		if(!empty($this->returpenerimaan_id)){
			$criteria->addCondition("returpenerimaan_id = ".$this->returpenerimaan_id);			
		}
        $criteria->compare('LOWER(nopenerimaan)',strtolower($this->nopenerimaan),true);
        $criteria->compare('LOWER(tglsuratjalan)',strtolower($this->tglsuratjalan),true);
        $criteria->compare('LOWER(nosuratjalan)',strtolower($this->nosuratjalan),true);
        $criteria->compare('LOWER(tglfaktur)',strtolower($this->tglfaktur),true);
        $criteria->compare('LOWER(nofaktur)',strtolower($this->nofaktur),true);
        $criteria->compare('LOWER(keterangan_persediaan)',strtolower($this->keterangan_persediaan),true);
        $criteria->compare('totalharga',$this->totalharga);
        $criteria->compare('discount',$this->discount);
        $criteria->compare('biayaadministrasi',$this->biayaadministrasi);
        $criteria->compare('pajakpph',$this->pajakpph);
        $criteria->compare('pajakppn',$this->pajakppn);
        $criteria->compare('LOWER(nofakturpajak)',strtolower($this->nofakturpajak),true);
		if(!empty($this->peg_penerima_id)){
			$criteria->addCondition("peg_penerima_id = ".$this->peg_penerima_id);			
		}
		if(!empty($this->peg_mengetahui_id)){
			$criteria->addCondition("peg_mengetahui_id = ".$this->peg_mengetahui_id);			
		}
		if(!empty($this->ruanganpenerima_id)){
			$criteria->addCondition("ruanganpenerima_id = ".$this->ruanganpenerima_id);			
		}
        $criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
        $criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
        $criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
        $criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
        $criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);

        return $criteria;
    }
     
     public function searchPenerimaanPersediaangrafik()
     {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

            $criteria=new CDbCriteria;
            
            $criteria->select = 'count(terimapersediaan_id) as jumlah, date(tglterima) as data';
            $criteria->group = 'date(tglterima)';
            $criteria->addBetweenCondition('date(tglterima)', $this->tgl_awal, $this->tgl_akhir);
			if(!empty($this->terimapersediaan_id)){
				$criteria->addCondition("terimapersediaan_id = ".$this->terimapersediaan_id);			
			}
			if(!empty($this->pembelianbarang_id)){
				$criteria->addCondition("pembelianbarang_id = ".$this->pembelianbarang_id);			
			}
			if(!empty($this->sumberdana_id)){
				$criteria->addCondition("sumberdana_id = ".$this->sumberdana_id);			
			}
			if(!empty($this->returpenerimaan_id)){
				$criteria->addCondition("returpenerimaan_id = ".$this->returpenerimaan_id);			
			}
            $criteria->compare('LOWER(nopenerimaan)',strtolower($this->nopenerimaan),true);
            $criteria->compare('LOWER(tglsuratjalan)',strtolower($this->tglsuratjalan),true);
            $criteria->compare('LOWER(nosuratjalan)',strtolower($this->nosuratjalan),true);
            $criteria->compare('LOWER(tglfaktur)',strtolower($this->tglfaktur),true);
            $criteria->compare('LOWER(nofaktur)',strtolower($this->nofaktur),true);
            $criteria->compare('LOWER(keterangan_persediaan)',strtolower($this->keterangan_persediaan),true);
            $criteria->compare('totalharga',$this->totalharga);
            $criteria->compare('discount',$this->discount);
            $criteria->compare('biayaadministrasi',$this->biayaadministrasi);
            $criteria->compare('pajakpph',$this->pajakpph);
            $criteria->compare('pajakppn',$this->pajakppn);
            $criteria->compare('LOWER(nofakturpajak)',strtolower($this->nofakturpajak),true);
			if(!empty($this->peg_penerima_id)){
				$criteria->addCondition("peg_penerima_id = ".$this->peg_penerima_id);			
			}
			if(!empty($this->peg_mengetahui_id)){
				$criteria->addCondition("peg_mengetahui_id = ".$this->peg_mengetahui_id);			
			}
			if(!empty($this->ruanganpenerima_id)){
				$criteria->addCondition("ruanganpenerima_id = ".$this->ruanganpenerima_id);			
			}
            $criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
            $criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
            $criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
            $criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
            $criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);

                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
               // $criteria->limit=-1; 

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));
    }
	public function Criteria()
	{
		$criteria = new CDbCriteria;

		if(!empty($this->terimapersediaan_id)){
			$criteria->addCondition("terimapersediaan_id = ".$this->terimapersediaan_id);			
		}
		$criteria->addBetweenCondition('date(tglterima)',$this->tgl_awal,$this->tgl_akhir);
		return $criteria;
	}  
      public function getTotalharga()
        {
            $criteria=$this->Criteria();
            $criteria->select = 'SUM(totalharga)';
            return $this->commandBuilder->createFindCommand($this->getTableSchema(),$criteria)->queryScalar();
        }
}

?>
