<?php
class PPTarifTindakanPerdaRuanganV  extends TariftindakanperdaruanganV
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TariftindakanperdaruanganV the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        public function getInstalasiRuangan(){
            return $this->instalasi_nama."  /   ".$this->ruangan_nama;
        }
        public function searchInformasi()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		if (!empty($this->kelaspelayanan_id)){
			$criteria->addCondition('kelaspelayanan_id ='.$this->kelaspelayanan_id);
		}
		$criteria->compare('LOWER(daftartindakan_nama)',  strtolower($this->daftartindakan_nama),true);
		if (!empty($this->kategoritindakan_id)){
			$criteria->addCondition('kategoritindakan_id ='.$this->kategoritindakan_id);
		}
		if (!empty($this->ruangan_id)){
			$criteria->addCondition('ruangan_id ='.$this->ruangan_id);
		}
		if(!empty($this->jenistarif_id)){
			$criteria->addCondition('jenistarif_id = '.$this->jenistarif_id);
		}
		$criteria->limit = 10;
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
//                        'pagination'=>false,
		));
	}
        
        /**
         * Mengambil daftar semua ruangan
         * @return CActiveDataProvider 
         */
        public function getRuanganItems($instalasi_id=null)
        {
            $criteria = new CDbCriteria();
			if (!empty($instalasi_id)){
				$criteria->addCondition('instalasi_id ='.$instalasi_id);
			}
            $criteria->addCondition('ruangan_aktif = true');
            $criteria->order = "ruangan_nama";
            return RuanganM::model()->findAll($criteria);
        }
        
        /**
         * Mengambil daftar semua instalasi
         * @return CActiveDataProvider 
         */
        public function getInstalasiItems()
        {
            $criteria = new CDbCriteria();
            $criteria->addCondition('instalasi_aktif = true');
            $criteria->order = "instalasi_nama";
            return InstalasiM::model()->findAll($criteria);
        }
}

