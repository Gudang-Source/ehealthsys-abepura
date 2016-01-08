<?php
class AKPenjaminRekM extends PenjaminrekM
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return BankM the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function searchPenjamin()
	{
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

		$criteria=new CDbCriteria;
		
		if(!empty($this->penjaminrek_id)){
			$criteria->addCondition("t.penjaminrek_id = ".$this->penjaminrek_id);			
		}
		if(!empty($this->rekening5_id)){
			$criteria->addCondition("t.rekening5_id = ".$this->rekening5_id);			
		}
		if(!empty($this->carabayar_nama)){
			$criteria->compare('LOWER(carabayar_nama)', strtolower($this->carabayar_nama), true);
		}
		if(!empty($this->penjamin_nama)){
			$criteria->compare('LOWER(penjamin_nama)', strtolower($this->penjamin_nama), true);
		}
		if(!empty($this->rekening_debit)){
			$criteria->compare('LOWER(nmrekening5)', strtolower($this->rekening_debit), true);
		}
		if(!empty($this->rekeningKredit)){
			$criteria->compare('LOWER(nmrekening5)', strtolower($this->rekeningKredit), true);
		}
		
//		$criteria->compare('LOWER(t.saldonormal)',strtolower($this->saldonormal),true);
		$criteria->group = 't.penjamin_id';
		$criteria->select = 't.penjamin_id';
		$criteria->join =	"JOIN penjaminpasien_m ON penjaminpasien_m.penjamin_id = t.penjamin_id
							JOIN carabayar_m ON carabayar_m.carabayar_id = penjaminpasien_m.carabayar_id
							JOIN rekening5_m ON rekening5_m.rekening5_id = t.rekening5_id";
		
			return new CActiveDataProvider($this, array(
					'criteria'=>$criteria,
			));
	}
        
	public function searchPenjaminPrint()
	{
			// Warning: Please modify the following code to remove attributes that
			// should not be searched.

			$criteria=new CDbCriteria;
		if(!empty($this->penjaminrek_id)){
			$criteria->addCondition("t.penjaminrek_id = ".$this->penjaminrek_id);			
		}
		if(!empty($this->rekening5_id)){
			$criteria->addCondition("t.rekening5_id = ".$this->rekening5_id);			
		}
		if(!empty($this->carabayar_nama)){
			$criteria->compare('LOWER(carabayar_nama)', strtolower($this->carabayar_nama), true);
		}
		if(!empty($this->penjamin_nama)){
			$criteria->compare('LOWER(penjamin_nama)', strtolower($this->penjamin_nama), true);
		}
		if(!empty($this->rekening_debit)){
			$criteria->compare('LOWER(nmrekening5)', strtolower($this->rekening_debit), true);
		}
		if(!empty($this->rekeningKredit)){
			$criteria->compare('LOWER(nmrekening5)', strtolower($this->rekeningKredit), true);
		}
		
//		$criteria->compare('LOWER(t.saldonormal)',strtolower($this->saldonormal),true);
		$criteria->group = 't.penjamin_id';
		$criteria->select = 't.penjamin_id';
		$criteria->join =	"JOIN penjaminpasien_m ON penjaminpasien_m.penjamin_id = t.penjamin_id
							JOIN carabayar_m ON carabayar_m.carabayar_id = penjaminpasien_m.carabayar_id
							JOIN rekening5_m ON rekening5_m.rekening5_id = t.rekening5_id";
			// Klo limit lebih kecil dari nol itu berarti ga ada limit 
			$criteria->limit=-1; 
			
			return new CActiveDataProvider($this, array(
					'criteria'=>$criteria,
					'pagination'=>false,
			));
	}
}

?>