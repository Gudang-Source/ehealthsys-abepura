<?php
class PJTarifTindakanPerdaRuanganV  extends TariftindakanperdaruanganV
{
        public $tipepaket_id = Params::TIPEPAKET_ID_NONPAKET; //untuk PaketpelayananV di search dialog
        public $penjamin_id;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TariftindakanperdaruanganV the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
       public function searchInformasi()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		if (!empty($this->kelaspelayanan_id)){
			$criteria->addCondition('kelaspelayanan_id ='.$this->kelaspelayanan_id);
		}		
		if (!empty($this->kategoritindakan_id)){
			$criteria->addCondition('kategoritindakan_id ='.$this->kategoritindakan_id);
		}
		$criteria->addCondition('ruangan_id ='.Yii::app()->user->getState('ruangan_id'));
		if(!empty($this->jenistarif_id)){
			$criteria->addCondition('jenistarif_id = '.$this->jenistarif_id);
		}
                if(!empty($this->kelompoktindakan_id)){
			$criteria->addCondition('kelompoktindakan_id = '.$this->kelompoktindakan_id);
		}
                if(!empty($this->komponenunit_id)){
			$criteria->addCondition('komponenunit_id = '.$this->komponenunit_id);
		}
                
                $criteria->compare('LOWER(daftartindakan_nama)',  strtolower($this->daftartindakan_nama), TRUE);
		$criteria->limit = 10;
		$criteria->order = "jenistarif_nama ASC, kelompoktindakan_nama ASC, komponenunit_nama ASC, kategoritindakan_nama ASC, kelaspelayanan_nama ASC, daftartindakan_nama ASC";
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
//        public function searchDialog($ruangan_id = null,$kelaspelayanan_id = null, $jenistarif_id = null, $penjamin_id=null)
//	{
//		// Warning: Please modify the following code to remove attributes that
//		// should not be searched.
//
//		$criteria=new CDbCriteria;
//                
//                if(!empty($ruangan_id)){
//                    $criteria->compare('ruangan_id',$ruangan_id);
//                }
//                
//                if(!empty($kelaspelayanan_id)){
//                    $criteria->compare('kelaspelayanan_id',$kelaspelayanan_id);
//                }
//                
//                if(!empty($jenistarif_id)){
//                    $criteria->compare('jenistarif_id',$jenistarif_id);
//                }
//                
//                if(!empty($penjamin_id)){
//                    $criteria->compare('penjamin_id',$penjamin_id);
//                }
//                
//                $criteria->compare('kelaspelayanan_id',$this->kelaspelayanan_id);
//                $criteria->compare('LOWER(daftartindakan_nama)',  strtolower($this->daftartindakan_id),true);
//                $criteria->compare('kategoritindakan_id',  $this->kategoritindakan_id);
//                $criteria->compare('ruangan_id',$this->ruangan_id);
//		return new CActiveDataProvider($this, array(
//			'criteria'=>$criteria,
//		));
//	}
        /**
	 * untuk dialog box pilih tindakan
	 */
	public function searchDialog()
	{
            $criteria = new CDbCriteria();
            $criteria->compare('LOWER(daftartindakan_nama)', strtolower($this->daftartindakan_nama), true);
            $criteria->compare('LOWER(kategoritindakan_nama)', strtolower($this->kategoritindakan_nama), true);
            $criteria->compare('LOWER(daftartindakan_kode)', strtolower($this->daftartindakan_kode), true);
            $criteria->compare('daftartindakan_akomodasi', $this->daftartindakan_akomodasi);
			if($this->tipepaket_id == Params::TIPEPAKET_ID_LUARPAKET){
				if(!empty($this->tipepaket_id)){
					$criteria->addCondition("tipepaket_id = ".$this->tipepaket_id);		
				}
                if(Yii::app()->user->getState('tindakanruangan')){
                    $criteria->addCondition('ruangan_id = '.Yii::app()->user->getState('ruangan_id'));
				}
                if(Yii::app()->user->getState('tindakankelas')){
					if(!empty($this->kelaspelayanan_id)){
						$criteria->addCondition("kelaspelayanan_id = ".$this->kelaspelayanan_id);		
					}
				}
                $models = new PaketpelayananV;
            }else if($this->tipepaket_id == Params::TIPEPAKET_ID_NONPAKET){
				if(!empty($this->jenistarif_id)){
					$criteria->addCondition("jenistarif_id = ".$this->jenistarif_id);		
				}
                if(Yii::app()->user->getState('tindakankelas')){
					if(!empty($this->kelaspelayanan_id)){
						$criteria->addCondition("kelaspelayanan_id = ".$this->kelaspelayanan_id);		
					}
				}
				if(!empty($this->penjamin_id)){
					$criteria->addCondition('penjamin_id = '.$this->penjamin_id);
				}
                if(Yii::app()->user->getState('tindakanruangan')){
                    $criteria->addCondition('ruangan_id = '.Yii::app()->user->getState('ruangan_id'));
                    $models = new PJTarifTindakanPerdaRuanganV;
                } else {
                    if(Yii::app()->user->getState('tindakanruangan')){
						if(!empty($this->ruangan_id)){
							$criteria->addCondition("ruangan_id = ".$this->ruangan_id);		
						}
					}
                    if(Yii::app()->user->getState('tindakankelas')){
						if(!empty($this->kelaspelayanan_id)){
							$criteria->addCondition("kelaspelayanan_id = ".$this->kelaspelayanan_id);		
						}
						if(!empty($this->tipepaket_id)){
							$criteria->addCondition("tipepaket_id = ".$this->tipepaket_id);		
						}
					}
                    $models = new TariftindakanperdaV;
                }
            }else{
				if(!empty($this->tipepaket_id)){
					$criteria->addCondition("tipepaket_id = ".$this->tipepaket_id);		
				}
                $models = new PaketpelayananV;
            }
            $criteria->order = 'daftartindakan_nama';
            $criteria->limit = 5;
            return new CActiveDataProvider($models, array(
                    'criteria'=>$criteria,
                    'pagination'=>array('pageSize'=>5),
            ));
	}
        
         public function searchTarifPrint() {
            $provider = $this->searchInformasi();
            $provider->criteria->limit = -1;
           // $provider->criteria->order = "jenistarif_nama ASC, kategoritindakan_nama ASC, kelaspelayanan_nama ASC, daftartindakan_nama ASC";
            $provider->pagination = false;
            
            return $provider;
        }
}

