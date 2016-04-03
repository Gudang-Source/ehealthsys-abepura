<?php
class RKPendaftaranT extends PendaftaranT
{
    public $kunjunganperhari, $tahun;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        public function getInstalasiResepturItems(){
            $criteria = new CDbCriteria();
            $criteria->addInCondition('instalasi_id',array(
                        Params::INSTALASI_ID_RI, 
                        Params::INSTALASI_ID_RJ, 
                        Params::INSTALASI_ID_RD) 
                    );
            $criteria->order = 'instalasi_nama';
            $modInstalasis = InstalasiM::model()->findAll($criteria);
            if(count($modInstalasis) > 0)
                return $modInstalasis;
            else
                return null;
        }

}
