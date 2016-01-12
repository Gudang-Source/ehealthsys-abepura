<?php

class FAInstalasiM extends InstalasiM
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InstalasiM the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        /**
         * menampilkan instalasi pelayanan RS
         * @return array
         */
        public function getInstalasiPelayanans(){
            $criteria = new CDbCriteria();
            $criteria->addInCondition('instalasi_id',array(
                        Params::INSTALASI_ID_RJ, 
                        Params::INSTALASI_ID_RD, 
                        Params::INSTALASI_ID_RI) 
                    );
            $criteria->addCondition('instalasi_aktif = true');
            $criteria->order = 'instalasi_id';
            $modInstalasis = InstalasiM::model()->findAll($criteria);
            if(count($modInstalasis) > 0)
                return $modInstalasis;
            else
                return array();
        }
	/**
         * menampilkan instalasi penunjang 
         * @return array
         */
        public function getInstalasiPenunjangs(){
            $criteria = new CDbCriteria();
            $criteria->addCondition('instalasirujukaninternal = true');
            $criteria->addCondition('instalasi_aktif = true');
            $criteria->order = 'instalasi_id';
            $modInstalasis = $this->model()->findAll($criteria);
            if(count($modInstalasis) > 0)
                return $modInstalasis;
            else
                return array();
        }

}