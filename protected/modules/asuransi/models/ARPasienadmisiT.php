<?php
class ARPasienadmisiT extends PasienadmisiT
{
	public $ruangan_nama,$kamarruangan_nama;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
}