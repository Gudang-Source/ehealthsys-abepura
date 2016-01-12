<?php
class MCPegawaiM extends PegawaiM
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PegawaiM the static model class
	 */
	public $jabatan_nama;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}