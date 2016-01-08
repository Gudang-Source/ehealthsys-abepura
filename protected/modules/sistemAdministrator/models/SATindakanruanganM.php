<?php

class SATindakanruanganM extends TindakanruanganM
{
    public $instalasi_id,$instalasi_nama,$ruangan_nama;

    /**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TabularlistM the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function search()
	{
		$criteria=new CDbCriteria;
		$criteria->with = array('ruangan','daftartindakan','daftartindakan.kategoritindakan','daftartindakan.kelompoktindakan');
		$criteria->compare('t.ruangan_id',$this->ruangan_id);
		$criteria->compare('t.daftartindakan_id',$this->daftartindakan_id);
		$criteria->compare('LOWER(ruangan.ruangan_nama)',  strtolower($this->ruangan_nama), true);
		$criteria->compare('LOWER(kelompoktindakan.kelompoktindakan_nama)',  strtolower($this->kelompoktindakan_nama), true);
		$criteria->compare('LOWER(kategoritindakan.kategoritindakan_nama)',  strtolower($this->kategoritindakan_nama), true);
		$criteria->compare('LOWER(daftartindakan.daftartindakan_kode)',  strtolower($this->daftartindakan_kode), true);
		$criteria->compare('LOWER(daftartindakan.daftartindakan_nama)',  strtolower($this->daftartindakan_nama), true);
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}