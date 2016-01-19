<?php
class SATugaspenggunaK extends TugaspenggunaK
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function getModul($modul_id = null)
    {
            if (empty($modul_id))
                return ModulK::model()->findAll('modul_aktif = true order by modul_nama');
            return ModulK::model()->findAll('modul_aktif = true and modul_id = '.$modul_id.' order by modul_nama');
    }

    public function getPeranPengguna()
    {
        return PeranpenggunaK::model()->findAll('peranpengguna_aktif = true order by peranpenggunanama');
    }
    
    public function searchTugasPengguna() {
        $provider = $this->search();
        $provider->criteria->group = 'peranpengguna_id, tugas_nama, tugas_namalainnya';
        $provider->criteria->select = $provider->criteria->group;
        
        return $provider;
    }
}