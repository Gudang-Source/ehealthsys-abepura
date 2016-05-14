<?php
class AKLaporanJurnalV extends LaporanjurnalV
{
    public $data;
    public $jumlah;
    public $tick;
    public $curProvider, $curProvDat;
    
    public static function model($className = __CLASS__) {
        parent::model($className);
    }
    
    public function searchTable()
    {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria=new CDbCriteria;

            $criteria->addBetweenCondition('tgljurnalpost', $this->tgl_awal, $this->tgl_akhir);
			if(!empty($this->jenisjurnal_id)){
				$criteria->addCondition("jenisjurnal_id = ".$this->jenisjurnal_id);			
			}
            $criteria->compare('LOWER(jenisjurnal_nama)',strtolower($this->jenisjurnal_nama),true);
			if(!empty($this->rekperiod_id)){
				$criteria->addCondition("rekperiod_id = ".$this->rekperiod_id);			
			}
            $criteria->compare('LOWER(tglbuktijurnal)',strtolower($this->tglbuktijurnal),true);
            $criteria->compare('LOWER(nobuktijurnal)',strtolower($this->nobuktijurnal),true);
            $criteria->compare('LOWER(kodejurnal)',strtolower($this->kodejurnal),true);
            $criteria->compare('LOWER(noreferensi)',strtolower($this->noreferensi),true);
            $criteria->compare('LOWER(tglreferensi)',strtolower($this->tglreferensi),true);
            $criteria->compare('nobku',$this->nobku);
            $criteria->compare('LOWER(urianjurnal)',strtolower($this->urianjurnal),true);
            $criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
            $criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
            $criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
            $criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
            $criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);
			if(!empty($this->jurnalposting_id)){
				$criteria->addCondition("jurnalposting_id = ".$this->jurnalposting_id);			
			}
            $criteria->compare('LOWER(tgljurnalpost)',strtolower($this->tgljurnalpost),true);
            $criteria->compare('LOWER(keterangan)',strtolower($this->keterangan),true);
			if(!empty($this->rekening1_id)){
				$criteria->addCondition("rekening1_id = ".$this->rekening1_id);			
			}
            $criteria->compare('LOWER(kdrekening1)',strtolower($this->kdrekening1),true);
            $criteria->compare('LOWER(nmrekening1)',strtolower($this->nmrekening1),true);
			if(!empty($this->rekening2_id)){
				$criteria->addCondition("rekening2_id = ".$this->rekening2_id);			
			}
            $criteria->compare('LOWER(kdrekening2)',strtolower($this->kdrekening2),true);
            $criteria->compare('LOWER(nmrekening2)',strtolower($this->nmrekening2),true);
			if(!empty($this->rekening3_id)){
				$criteria->addCondition("rekening3_id = ".$this->rekening3_id);			
			}
            $criteria->compare('LOWER(kdrekening3)',strtolower($this->kdrekening3),true);
            $criteria->compare('LOWER(nmrekening3)',strtolower($this->nmrekening3),true);
			if(!empty($this->rekening4_id)){
				$criteria->addCondition("rekening4_id = ".$this->rekening4_id);			
			}
            $criteria->compare('LOWER(kdrekening4)',strtolower($this->kdrekening4),true);
            $criteria->compare('LOWER(nmrekening4)',strtolower($this->nmrekening4),true);
			if(!empty($this->rekening5_id)){
				$criteria->addCondition("rekening5_id = ".$this->rekening5_id);			
			}
            $criteria->compare('LOWER(kdrekening5)',strtolower($this->kdrekening5),true);
            $criteria->compare('LOWER(nmrekening5)',strtolower($this->nmrekening5),true);
			if(!empty($this->tiperekening_id)){
				$criteria->addCondition("tiperekening_id = ".$this->tiperekening_id);			
			}
            $criteria->compare('LOWER(nourut)',strtolower($this->nourut),true);
            $criteria->compare('LOWER(uraiantransaksi)',strtolower($this->uraiantransaksi),true);
            $criteria->compare('saldodebit',$this->saldodebit);
            $criteria->compare('saldokredit',$this->saldokredit);
            $criteria->compare('koreksi',$this->koreksi);
            $criteria->compare('LOWER(catatan)',strtolower($this->catatan),true);

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));
    }
	
	public function searchPrint()
    {
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->addBetweenCondition('tgljurnalpost', $this->tgl_awal, $this->tgl_akhir);
		if(!empty($this->jenisjurnal_id)){
			$criteria->addCondition("jenisjurnal_id = ".$this->jenisjurnal_id);			
		}
		$criteria->compare('LOWER(jenisjurnal_nama)',strtolower($this->jenisjurnal_nama),true);
		if(!empty($this->rekperiod_id)){
			$criteria->addCondition("rekperiod_id = ".$this->rekperiod_id);			
		}
		$criteria->compare('LOWER(tglbuktijurnal)',strtolower($this->tglbuktijurnal),true);
		$criteria->compare('LOWER(nobuktijurnal)',strtolower($this->nobuktijurnal),true);
		$criteria->compare('LOWER(kodejurnal)',strtolower($this->kodejurnal),true);
		$criteria->compare('LOWER(noreferensi)',strtolower($this->noreferensi),true);
		$criteria->compare('LOWER(tglreferensi)',strtolower($this->tglreferensi),true);
		$criteria->compare('nobku',$this->nobku);
		$criteria->compare('LOWER(urianjurnal)',strtolower($this->urianjurnal),true);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
		$criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);
		if(!empty($this->jurnalposting_id)){
			$criteria->addCondition("jurnalposting_id = ".$this->jurnalposting_id);			
		}
		$criteria->compare('LOWER(tgljurnalpost)',strtolower($this->tgljurnalpost),true);
		$criteria->compare('LOWER(keterangan)',strtolower($this->keterangan),true);
		if(!empty($this->rekening1_id)){
			$criteria->addCondition("rekening1_id = ".$this->rekening1_id);			
		}
		$criteria->compare('LOWER(kdrekening1)',strtolower($this->kdrekening1),true);
		$criteria->compare('LOWER(nmrekening1)',strtolower($this->nmrekening1),true);
		if(!empty($this->rekening2_id)){
			$criteria->addCondition("rekening2_id = ".$this->rekening2_id);			
		}
		$criteria->compare('LOWER(kdrekening2)',strtolower($this->kdrekening2),true);
		$criteria->compare('LOWER(nmrekening2)',strtolower($this->nmrekening2),true);
		if(!empty($this->rekening3_id)){
			$criteria->addCondition("rekening3_id = ".$this->rekening3_id);			
		}
		$criteria->compare('LOWER(kdrekening3)',strtolower($this->kdrekening3),true);
		$criteria->compare('LOWER(nmrekening3)',strtolower($this->nmrekening3),true);
		if(!empty($this->rekening4_id)){
			$criteria->addCondition("rekening4_id = ".$this->rekening4_id);			
		}
		$criteria->compare('LOWER(kdrekening4)',strtolower($this->kdrekening4),true);
		$criteria->compare('LOWER(nmrekening4)',strtolower($this->nmrekening4),true);
		if(!empty($this->rekening5_id)){
			$criteria->addCondition("rekening5_id = ".$this->rekening5_id);			
		}
		$criteria->compare('LOWER(kdrekening5)',strtolower($this->kdrekening5),true);
		$criteria->compare('LOWER(nmrekening5)',strtolower($this->nmrekening5),true);
		if(!empty($this->tiperekening_id)){
			$criteria->addCondition("tiperekening_id = ".$this->tiperekening_id);			
		}
		$criteria->compare('LOWER(nourut)',strtolower($this->nourut),true);
		$criteria->compare('LOWER(uraiantransaksi)',strtolower($this->uraiantransaksi),true);
		$criteria->compare('saldodebit',$this->saldodebit);
		$criteria->compare('saldokredit',$this->saldokredit);
		$criteria->compare('koreksi',$this->koreksi);
		$criteria->compare('LOWER(catatan)',strtolower($this->catatan),true);
		
		$criteria->limit = -1;
		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
				'pagination'=>false,
		));
    }
    
    public function getTotal($col, $prov = null)
    {
        if (empty($this->curProvDat)) {
            if (empty($prov)) return 0;
            $this->curProvider = clone $prov;
            $this->curProvider->pagination = false;
            $this->curProvider->criteria->limit = -1;
            $this->curProvDat = $this->curProvider->data;
        }
        $total = 0;
        foreach ($this->curProvDat as $item) {
            $total += $item[$col];
        }
        return MyFormatter::formatNumberForPrint($total);
    }
    
    public static function criteriaGrafikJurnal($model, $type='data', $addCols = array()){
        $criteria = new CDbCriteria;
        $criteria->select = 'count(jenisjurnal_id) as jumlah';
        $criteria->select .= ',saldokredit as '.$type.', saldodebit as '.$type;
        $criteria->group .= 'saldodebit,saldokredit';
        if (count($addCols) > 0){
            if (is_array($addCols)){
                foreach ($addCols as $i => $v){
                    $criteria->group .= ','.$v;
                    $criteria->select .= ','.$v.' as '.$i;
                }
            }            
        }
        return $criteria;
    }
    
    public static function criteriaGrafikBukuKas($model, $type='data', $addCols = array()){
        $criteria = new CDbCriteria;
        $criteria->select = 'count(rekening1_id) as jumlah';
        
        
//        if (!isset($_GET['AKLaporanJurnalV'])){
            $criteria->select .= ',saldokredit as '.$type.', saldodebit as '.$type;
            $criteria->group .= 'saldodebit,saldokredit';
//        }
        
        if (count($addCols) > 0){
            if (is_array($addCols)){
                foreach ($addCols as $i => $v){
                    $criteria->group .= ','.$v;
                    $criteria->select .= ','.$v.' as '.$i;
                }
            }            
        }
        
        return $criteria;
    }
    
    public function searchGrafik(){
               
                $criteria = $this->criteriaGrafikJurnal($this,'data', array('tick'=>'jenisjurnal_nama'));
                
                $criteria->order = 'jenisjurnal_nama';
                
                $criteria->addBetweenCondition('tgljurnalpost', $this->tgl_awal, $this->tgl_akhir);
				if(!empty($this->jenisjurnal_id)){
					$criteria->addCondition("jenisjurnal_id = ".$this->jenisjurnal_id);			
				}
                $criteria->compare('LOWER(jenisjurnal_nama)',strtolower($this->jenisjurnal_nama),true);
				if(!empty($this->rekperiod_id)){
					$criteria->addCondition("rekperiod_id = ".$this->rekperiod_id);			
				}
                $criteria->compare('LOWER(tglbuktijurnal)',strtolower($this->tglbuktijurnal),true);
                $criteria->compare('LOWER(nobuktijurnal)',strtolower($this->nobuktijurnal),true);
                $criteria->compare('LOWER(kodejurnal)',strtolower($this->kodejurnal),true);
                $criteria->compare('LOWER(noreferensi)',strtolower($this->noreferensi),true);
                $criteria->compare('LOWER(tglreferensi)',strtolower($this->tglreferensi),true);
                $criteria->compare('nobku',$this->nobku);
                $criteria->compare('LOWER(urianjurnal)',strtolower($this->urianjurnal),true);
                $criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
                $criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
                $criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
                $criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
                $criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);
				if(!empty($this->jurnalposting_id)){
					$criteria->addCondition("jurnalposting_id = ".$this->jurnalposting_id);			
				}
                $criteria->compare('LOWER(tgljurnalpost)',strtolower($this->tgljurnalpost),true);
                $criteria->compare('LOWER(keterangan)',strtolower($this->keterangan),true);
				if(!empty($this->rekening1_id)){
					$criteria->addCondition("rekening1_id = ".$this->rekening1_id);			
				}
                $criteria->compare('LOWER(kdrekening1)',strtolower($this->kdrekening1),true);
                $criteria->compare('LOWER(nmrekening1)',strtolower($this->nmrekening1),true);
				if(!empty($this->rekening2_id)){
					$criteria->addCondition("rekening2_id = ".$this->rekening2_id);			
				}
                $criteria->compare('LOWER(kdrekening2)',strtolower($this->kdrekening2),true);
                $criteria->compare('LOWER(nmrekening2)',strtolower($this->nmrekening2),true);
				if(!empty($this->rekening3_id)){
					$criteria->addCondition("rekening3_id = ".$this->rekening3_id);			
				}
                $criteria->compare('LOWER(kdrekening3)',strtolower($this->kdrekening3),true);
                $criteria->compare('LOWER(nmrekening3)',strtolower($this->nmrekening3),true);
				if(!empty($this->rekening4_id)){
					$criteria->addCondition("rekening4_id = ".$this->rekening4_id);			
				}
                $criteria->compare('LOWER(kdrekening4)',strtolower($this->kdrekening4),true);
                $criteria->compare('LOWER(nmrekening4)',strtolower($this->nmrekening4),true);
				if(!empty($this->rekening5_id)){
					$criteria->addCondition("rekening5_id = ".$this->rekening5_id);			
				}
                $criteria->compare('LOWER(kdrekening5)',strtolower($this->kdrekening5),true);
                $criteria->compare('LOWER(nmrekening5)',strtolower($this->nmrekening5),true);
				if(!empty($this->tiperekening_id)){
					$criteria->addCondition("tiperekening_id = ".$this->tiperekening_id);			
				}
                $criteria->compare('LOWER(nourut)',strtolower($this->nourut),true);
                $criteria->compare('LOWER(uraiantransaksi)',strtolower($this->uraiantransaksi),true);
                $criteria->compare('saldodebit',$this->saldodebit);
                $criteria->compare('saldokredit',$this->saldokredit);
                $criteria->compare('koreksi',$this->koreksi);
                $criteria->compare('LOWER(catatan)',strtolower($this->catatan),true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
        }
    
    public function getKodeRekening($jurnalposting_id = null)
    {
		$kodeRekening = "";
		$criteria = new CDbCriteria;
		if(!empty($jurnalposting_id)){
			$criteria->addCondition("jurnalposting_id = ".$jurnalposting_id);			
		}
		$criteria->compare('kdrekening1',$this->kdrekening1);
		$criteria->compare('kdrekening2',$this->kdrekening2);
		$criteria->compare('kdrekening3',$this->kdrekening3);
		$criteria->compare('kdrekening4',$this->kdrekening4);
		$criteria->compare('kdrekening5',$this->kdrekening5);
		
		$kodRekening = LaporanJurnalV::model()->find($criteria);
		if ((!empty($kodRekening->kdrekening1)) && (!empty($kodRekening->kdrekening2)) && (!empty($kodRekening->kdrekening3)) && (!empty($kodRekening->kdrekening4)) && (!empty($kodRekening->kdrekening5))){
			return $kodRekening->kdrekening5;
		}elseif ((!empty($kodRekening->kdrekening1)) && (!empty($kodRekening->kdrekening2)) && (!empty($kodRekening->kdrekening3)) && (!empty($kodRekening->kdrekening4))){
			return $kodRekening->kdrekening4;
		}elseif ((!empty($kodRekening->kdrekening1)) && (!empty($kodRekening->kdrekening2)) && (!empty($kodRekening->kdrekening3))){
			return $kodRekening->kdrekening3;
		}elseif ((!empty($kodRekening->kdrekening1)) && (!empty($kodRekening->kdrekening2))){
			return $kodRekening->kdrekening2;
		}elseif (!empty($kodRekening->kdrekening1)){
			return $kodRekening->kdrekening1;
		}else{
			$kodeRekening .= "-";
		}
            return $kodeRekening;
    }
    
    public function getNamaRekening($jurnalposting_id = null)
    {
			
		$namaRekening = "";
		$criteria = new CDbCriteria;
		if(!empty($jurnalposting_id)){
			$criteria->addCondition("jurnalposting_id = ".$jurnalposting_id);			
		}
		$criteria->compare('nmrekening1',$this->nmrekening1);
		$criteria->compare('nmrekening2',$this->nmrekening2);
		$criteria->compare('nmrekening3',$this->nmrekening3);
		$criteria->compare('nmrekening4',$this->nmrekening4);
		$criteria->compare('nmrekening5',$this->nmrekening5);
		
		$nmRekening = LaporanJurnalV::model()->find($criteria);
		if (!empty($nmRekening->nmrekening5)){
			$namaRekening =  $nmRekening->nmrekening5;
		}elseif (!empty($nmRekening->nmrekening4)){
			$namaRekening =  $nmRekening->nmrekening4;
		}elseif (!empty($nmRekening->nmrekening3)){
			$namaRekening =  $nmRekening->nmrekening3;
		}elseif (!empty($nmRekening->nmrekening2)){
			$namaRekening =  $nmRekening->nmrekening2;
		}elseif (!empty($nmRekening->nmrekening1)){
			$namaRekening =  $nmRekening->nmrekening1;
		}else{
			$namaRekening = "-";
		}
            return $namaRekening;
    } 
	
}

?>