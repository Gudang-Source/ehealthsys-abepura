<?php

class KOPemberhentiananggotaV extends PemberhentiananggotaV
{
	public $tgl_awal;
        public $tgl_akhir;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
		
         public function searchInformasi() {
		$criteria = new CDbCriteria();
                $criteria->addBetweenCondition('tglberhenti_dipecat', $this->tgl_awal.' 00:00:00', $this->tgl_akhir.' 23:59:59');
                
                $criteria->compare('LOWER(nokeanggotaan)', strtolower($this->nokeanggotaan),true);
                $criteria->compare('LOWER(nama_pegawai)', strtolower($this->nama_pegawai),true);
                
                if (!empty($this->potongansumber_id)){
                    $criteria->addCondition("potongamsumber_id = '".$this->potongamsumber_id."'  ");
                }
                
                $criteria->order = 'tglberhenti_dipecat DESC';
		

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}