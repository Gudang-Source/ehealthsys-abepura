<?php
class SATugaspenggunaK extends TugaspenggunaK
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function getModul()
    {
        return ModulK::model()->findAll('modul_aktif = true order by modul_nama');
    }

    public function getPeranPengguna()
    {
        return PeranpenggunaK::model()->findAll('peranpengguna_aktif = true order by peranpenggunanama');
    }
}