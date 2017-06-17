<?php

class PSRiwayatkbT extends RiwayatkbT
{
        public $tambah_jenis_kb;
        public $tambah_lepas_kb;
        public $tambah_pasang_kb;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return AnamnesaT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
                
	}

}