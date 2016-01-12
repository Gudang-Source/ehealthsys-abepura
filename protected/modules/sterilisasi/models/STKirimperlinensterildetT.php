<?php

class STKirimperlinensterildetT extends KirimperlinensterildetT{
	public $namaPeralatan, $namaLinen;
	public $checklist,$status_penerimaan;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
