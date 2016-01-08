<?php

class AKSaldoawalT extends SaldoawalT
{
	public $debit,$kredit, $rekening1_id, $rekening2_id, $rekening3_id, $rekening4_id, $rekening5_id;
        /**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return AnamnesaT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
	public function searchByFilter()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		if(!empty($this->saldoawal_id)){
			$criteria->addCondition("saldoawal_id = ".$this->saldoawal_id);			
		}
		if(!empty($this->rekening4_id)){
			$criteria->addCondition("rekening4_id = ".$this->rekening4_id);			
		}
		if(!empty($this->rekperiod_id)){
			$criteria->addCondition("rekperiod_id = ".$this->rekperiod_id);			
		}
		if(!empty($this->matauang_id)){
			$criteria->addCondition("matauang_id = ".$this->matauang_id);			
		}
		if(!empty($this->rekening5_id)){
			$criteria->addCondition("rekening5_id = ".$this->rekening5_id);			
		}
		if(!empty($this->kursrp_id)){
			$criteria->addCondition("kursrp_id = ".$this->kursrp_id);			
		}
		if(!empty($this->rekening2_id)){
			$criteria->addCondition("rekening2_id = ".$this->rekening2_id);			
		}
		if(!empty($this->rekening1_id)){
			$criteria->addCondition("rekening1_id = ".$this->rekening1_id);			
		}
		if(!empty($this->rekening3_id)){
			$criteria->addCondition("rekening3_id = ".$this->rekening3_id);			
		}
		$criteria->compare('jmlanggaran',$this->jmlanggaran);
		$criteria->compare('jmlsaldoawald',$this->jmlsaldoawald);
		$criteria->compare('jmlsaldoawalk',$this->jmlsaldoawalk);
		$criteria->compare('jmlmutasid',$this->jmlmutasid);
		$criteria->compare('jmlmutasik',$this->jmlmutasik);
		$criteria->compare('jmlsaldoakhird',$this->jmlsaldoakhird);
		$criteria->compare('jmlsaldoakhirk',$this->jmlsaldoakhirk);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
		$criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);
                $criteria->order = 'rekening1_id, rekening2_id, rekening3_id, rekening4_id, rekening5_id';
                
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        public function isExis($id)
        {
            $data = $this->getRecordModel($id);
            if($data->rekperiod_id == $this->rekperiod_id)
            {
                return false;
            }else{
                $criteria=new CDbCriteria;
				if(!empty($this->rekening1_id)){
					$criteria->addCondition("rekening1_id = ".$this->rekening1_id);			
				}	
				if(!empty($this->rekening2_id)){
					$criteria->addCondition("rekening2_id = ".$this->rekening2_id);			
				}	
				if(!empty($this->rekening3_id)){
					$criteria->addCondition("rekening3_id = ".$this->rekening3_id);			
				}	
				if(!empty($this->rekening4_id)){
					$criteria->addCondition("rekening4_id = ".$this->rekening4_id);			
				}	
				if(!empty($this->rekening5_id)){
					$criteria->addCondition("rekening5_id = ".$this->rekening5_id);			
				}	
				if(!empty($this->rekperiod_id)){
					$criteria->addCondition("rekperiod_id = ".$this->rekperiod_id);			
				}
                $record = $this->model()->find($criteria);
                if($record){
                    return true;
                }else{
                    return false;
                }   
            }
        }
        
        private function getRecordModel($id)
        {
            $record = $this->model()->findBypk($id);
            return $record;
        }
}
?>
