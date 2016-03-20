<?php
class AKPeriodepostingM extends PeriodepostingM
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function getTglPeriode($rekperiod_id = null)
	{
		$next_year = date('Y-m-d',mktime(0, 0, 0, date("m"),   date("d"),   date("Y")));
		$criteria = new CDbCriteria();
		$criteria->addCondition('DATE(tglperiodeposting_awal) <=\''.$next_year.'\'');
		$criteria->addCondition('DATE(tglperiodeposting_akhir) >= \''.$next_year.'\'');
		$criteria->compare('LOWER(deskripsiperiodeposting)',strtolower($this->deskripsiperiodeposting),true);
		$criteria->order = "deskripsiperiodeposting ASC";
		if(!empty($rekperiod_id)){
			$criteria->addCondition('rekperiode_id = '.$rekperiod_id);
		}
		
		return self::model()->findAll($criteria);
	}
}