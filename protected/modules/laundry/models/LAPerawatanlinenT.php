<?php
class LAPerawatanlinenT extends PerawatanlinenT
{
	public $pegmengetahui_nama,$pegperawat_nama;
	public $tgl_awal,$tgl_akhir,$instalasi_id,$ruangan_id;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PerawatanlinenT the static model class
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

		$criteria->addBetweenCondition('DATE(tglperawatanlinen)', $this->tgl_awal, $this->tgl_akhir,true);
		if(!empty($this->perawatanlinen_id)){
			$criteria->addCondition('perawatanlinen_id = '.$this->perawatanlinen_id);
		}
		$criteria->compare('LOWER(noperawatan)',strtolower($this->noperawatan),true);
		$criteria->compare('LOWER(tglperawatanlinen)',strtolower($this->tglperawatanlinen),true);
		$criteria->compare('LOWER(keterangan_perawatan)',strtolower($this->keterangan_perawatan),true);
		if(!empty($this->pegperawatan_id)){
			$criteria->addCondition('pegperawatan_id = '.$this->pegperawatan_id);
		}
		if(!empty($this->pegmengetahui)){
			$criteria->addCondition('pegmengetahui = '.$this->pegmengetahui);
		}
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		if(!empty($this->create_loginpemakai_id)){
			$criteria->addCondition('create_loginpemakai_id = '.$this->create_loginpemakai_id);
		}
		if(!empty($this->udpate_loginpemakai_id)){
			$criteria->addCondition('udpate_loginpemakai_id = '.$this->udpate_loginpemakai_id);
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