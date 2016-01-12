<?php
class LAPencucianlinenT extends PencucianlinenT
{
	public $pegpenerima_nama,$pegmengetahui_nama;
	public $tgl_awal,$tgl_akhir,$instalasi_id,$ruangan_id;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PencucianlinenT the static model class
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

		$criteria->addBetweenCondition('DATE(tglpencucianlinen)', $this->tgl_awal, $this->tgl_akhir,true);
		if(!empty($this->pencucianlinen_id)){
			$criteria->addCondition('pencucianlinen_id = '.$this->pencucianlinen_id);
		}
		if(!empty($this->perawatanlinen_id)){
			$criteria->addCondition('perawatanlinen_id = '.$this->perawatanlinen_id);
		}
		if(!empty($this->penerimaanlinen_id)){
			$criteria->addCondition('penerimaanlinen_id = '.$this->penerimaanlinen_id);
		}
		$criteria->compare('LOWER(tglpencucianlinen)',strtolower($this->tglpencucianlinen),true);
		$criteria->compare('LOWER(nopencucianlinen)',strtolower($this->nopencucianlinen),true);
		$criteria->compare('LOWER(keterangan_pencucianlinen)',strtolower($this->keterangan_pencucianlinen),true);
		if(!empty($this->petugas_id)){
			$criteria->addCondition('petugas_id = '.$this->petugas_id);
		}
		if(!empty($this->pegpenerima_id)){
			$criteria->addCondition('pegpenerima_id = '.$this->pegpenerima_id);
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