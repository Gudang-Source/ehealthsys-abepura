<?php
class ASAsuhankeperawatanT extends AsuhankeperawatanT
{
        public $paramedis_nama;
        public $dokter_nama;
        public $diagnosa_nama;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}