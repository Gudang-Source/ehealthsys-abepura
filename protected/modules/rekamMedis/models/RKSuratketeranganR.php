<?php
class RKSuratketeranganR extends SuratketeranganR
{
        public $lama_istirahat,$lab_rad,$pukul_lahir;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

}
?>