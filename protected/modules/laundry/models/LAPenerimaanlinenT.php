<?php
class LAPenerimaanlinenT extends PenerimaanlinenT{
	public $pegawaimengetahui_nama,$pegawaimenerima_nama;
	public $instalasi_nama,$ruangan_nama;
	public $tgl_awal,$tgl_akhir,$instalasi_id;
        public $pengperawatanlinen_no;
	
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	// fungsi untuk informasi penerimaan linen controller
	public function searchInformasi()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->addBetweenCondition('DATE(t.tglpenerimaanlinen)',$this->tgl_awal, $this->tgl_akhir);
		
		if(!empty($this->penerimaanlinen_id)){
			$criteria->addCondition('t.penerimaanlinen_id = '.$this->penerimaanlinen_id);
		}
		if(!empty($this->ruangan_id)){
			$criteria->addCondition('t.ruangan_id = '.$this->ruangan_id);
		}
		if(!empty($this->pengperawatanlinen_id)){
			$criteria->addCondition('t.pengperawatanlinen_id = '.$this->pengperawatanlinen_id);
		}
		$criteria->compare('LOWER(t.nopenerimaanlinen)',strtolower($this->nopenerimaanlinen),true);
		$criteria->compare('LOWER(t.keterangan_penerimaanlinen)',strtolower($this->keterangan_penerimaanlinen),true);
		if(!empty($this->pegmenerima_id)){
			$criteria->addCondition('t.pegmenerima_id = '.$this->pegmenerima_id);
		}
		if(!empty($this->pegmengetahui_id)){
			$criteria->addCondition('t.pegmengetahui_id = '.$this->pegmengetahui_id);
		}
		if(!empty($this->beratlinen)){
			$criteria->addCondition('t.beratlinen = '.$this->beratlinen);
		}
		$criteria->compare('LOWER(t.create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(t.update_time)',strtolower($this->update_time),true);
		if(!empty($this->create_loginpemakai_id)){
			$criteria->addCondition('t.create_loginpemakai_id = '.$this->create_loginpemakai_id);
		}
		if(!empty($this->update_loginpemakai_id)){
			$criteria->addCondition('t.update_loginpemakai_id = '.$this->update_loginpemakai_id);
		}
		if(!empty($this->create_ruangan)){
			$criteria->addCondition('t.create_ruangan = '.$this->create_ruangan);
		}

		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
		));
	}
	
}