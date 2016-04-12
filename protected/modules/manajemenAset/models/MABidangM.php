<?php

class MABidangM extends BidangM
{

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	public static function getBidangItems2(){
		$criteria = new CDbCriteria();
		$criteria->addCondition('bidang_aktif = TRUE');
		$criteria->order = "bidang_nama";
		return self::model()->findAll($criteria);
	}
}