<?php

class SARekeninguangmukaM extends RekeninguangmukaM {
	public $instalasi_id,$instalasi_nama,$nmrekening5,$kdrekening5;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}	
	public function search()
	{
//		echo $this->instalasi_id;exit;
		$criteria=new CDbCriteria;
		$criteria->with = array('instalasi','rekening5');
		$criteria->compare('instalasi.instalasi_id',$this->instalasi_id);
		$criteria->compare('rekening5.rekening5_id',$this->rekening5_id);
		$criteria->compare('LOWER(instalasi.instalasi_nama)',  strtolower($this->instalasi_nama), true);
		$criteria->compare('LOWER(rekening5.nmrekening5)',  strtolower($this->nmrekening5), true);
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
