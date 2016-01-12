<?php

class STPenyimpanansterildetT extends PenyimpanansterildetT{
	public $namaPeralatan, $namaLinen;
	public $checklist,$status_penerimaan;
	public $ruangan_nama,$barang_nama,$sterilisasi_no,$waktukadaluarsa,$instalasi_nama;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}	
}
