<?php

class BSOperasiM extends OperasiM
{
    /**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return KegiatanOperasiM the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function getDaftarTindakanNama($daftartindakanId = null) {
        return DaftartindakanM::model()->findByPk($daftartindakanId);
    }
}
?>
