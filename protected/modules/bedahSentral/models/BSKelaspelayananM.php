<?php
class BSKelaspelayananM extends KelaspelayananM
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return KelaspelayananM the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        public static function getKelasPelayananItems()
        {
            return KelaspelayananM::model()->findAllByAttributes(array('kelaspelayanan_aktif'=>true),array('order'=>'urutankelas'));
        }

}