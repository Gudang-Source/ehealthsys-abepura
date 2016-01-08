<?php
class STPenerimaansterilisasiT extends PenerimaansterilisasiT{
	public $pegawaipenerima_nama, $pegawaimengetahui_nama;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}

