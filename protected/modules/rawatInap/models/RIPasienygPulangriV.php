<?php

class RIPasienygPulangriV  extends PasienygpulangriV
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PasienygpulangriV the static model class
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
			if($this->ceklis==1){
				$criteria->addBetweenCondition('DATE(tglpasienpulang)',$this->tgl_awal,$this->tgl_akhir,true);
//                    $criteria->addCondition('tglpasienpulang BETWEEN \''.$this->tgl_awal.'\' AND \''.$this->tgl_akhir.'\' ');
			}
			$criteria->compare('LOWER(no_pendaftaran)',strtolower($this->prefix_pendaftaran.$this->no_pendaftaran),true);
			$criteria->compare('LOWER(nama_pasien)',strtolower($this->nama_pasien),true);
			$criteria->compare('LOWER(nama_bin)',strtolower($this->nama_bin),true);
			$criteria->compare('LOWER(no_rekam_medik)',strtolower($this->no_rekam_medik),true);
			$criteria->compare('LOWER(keterangan_kamar)',strtolower($this->keterangan_kamar),true);
			$criteria->addCondition('ruangan_id = '.Yii::app()->user->getState('ruangan_id'));
			if(!empty($this->penjamin_id)){
				$criteria->addCondition("penjamin_id = ".$this->penjamin_id); 	
			}
			if(!empty($this->carabayar_id)){
				$criteria->addCondition("carabayar_id = ".$this->carabayar_id); 	
			}
                        $criteria->order = "tglpasienpulang DESC";

			return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
			));
        }

}