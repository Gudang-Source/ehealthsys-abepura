<?php
class ARPasienmorbiditasT extends PasienmorbiditasT
{
	public $diagnosa_kode,$diagnosa_nama,$kelompokdiagnosa_nama,$level,$checklist;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}