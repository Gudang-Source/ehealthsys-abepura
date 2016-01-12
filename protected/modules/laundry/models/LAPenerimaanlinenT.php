<?php
class LAPenerimaanlinenT extends PenerimaanlinenT{
	public $pegawaimengetahui_nama,$pegawaimenerima_nama;
	public $instalasi_nama,$ruangan_nama;
	public $tgl_awal,$tgl_akhir,$instalasi_id;
	
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

		$criteria->addBetweenCondition('DATE(tglpenerimaanlinen)',$this->tgl_awal, $this->tgl_akhir);
		
		if(!empty($this->penerimaanlinen_id)){
			$criteria->addCondition('penerimaanlinen_id = '.$this->penerimaanlinen_id);
		}
		if(!empty($this->ruangan_id)){
			$criteria->addCondition('ruangan_id = '.$this->ruangan_id);
		}
		if(!empty($this->pengperawatanlinen_id)){
			$criteria->addCondition('pengperawatanlinen_id = '.$this->pengperawatanlinen_id);
		}
		$criteria->compare('LOWER(nopenerimaanlinen)',strtolower($this->nopenerimaanlinen),true);
		$criteria->compare('LOWER(keterangan_penerimaanlinen)',strtolower($this->keterangan_penerimaanlinen),true);
		if(!empty($this->pegmenerima_id)){
			$criteria->addCondition('pegmenerima_id = '.$this->pegmenerima_id);
		}
		if(!empty($this->pegmengetahui_id)){
			$criteria->addCondition('pegmengetahui_id = '.$this->pegmengetahui_id);
		}
		if(!empty($this->beratlinen)){
			$criteria->addCondition('beratlinen = '.$this->beratlinen);
		}
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		if(!empty($this->create_loginpemakai_id)){
			$criteria->addCondition('create_loginpemakai_id = '.$this->create_loginpemakai_id);
		}
		if(!empty($this->update_loginpemakai_id)){
			$criteria->addCondition('update_loginpemakai_id = '.$this->update_loginpemakai_id);
		}
		if(!empty($this->create_ruangan)){
			$criteria->addCondition('create_ruangan = '.$this->create_ruangan);
		}

		$criteria->limit=10;
		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
		));
	}
	
}