<?php

class GZInfopasienmasukkamarV extends InfopasienmasukkamarV
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return PasienrawatinapV the static model class
     */
   
    
    public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }
    
    public function searchRI()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.
        
		$criteria=new CDbCriteria;
		
		if(!empty($this->ruangan_id)){
			$criteria->addCondition('ruangan_id ='.$this->ruangan_id);
		}
		if(!empty($this->penjamin_id)){
			$criteria->addCondition("penjamin_id = ".$this->penjamin_id); 	
		}
		if(!empty($this->carabayar_id)){
			$criteria->addCondition("carabayar_id = ".$this->carabayar_id); 	
		}
		if(!empty($this->caramasuk_id)){
			$criteria->addCondition("caramasuk_id = ".$this->caramasuk_id); 	
		}
		$criteria->compare('LOWER(no_rekam_medik)',strtolower($this->no_rekam_medik),true);
		$criteria->compare('LOWER(nama_pasien)',strtolower($this->nama_pasien),true);
		$criteria->compare('LOWER(no_pendaftaran)',strtolower($this->no_pendaftaran),true);
		$criteria->compare('LOWER(nama_pegawai)',strtolower($this->nama_pegawai),true);
                $criteria->compare('LOWER(umur)',strtolower($this->umur),true);
                $criteria->compare('kamarruangan_id', $this->kamarruangan_id);
		//if($this->ceklis == 1)
		//{
			//$criteria->addBetweenCondition('tgladmisi::date',$this->tgl_awal,$this->tgl_akhir);
		//}

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
	
	        
}
?>
