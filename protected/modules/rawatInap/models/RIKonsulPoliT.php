<?php

class RIKonsulPoliT extends KonsulpoliT
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return PasiendirujukkeluarT the static model class
     */
    public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }
		/**
         * Mengambil daftar semua ruangan 
         * @return CActiveDataProvider 
         */
        public function getRuanganInstalasi()
        {
			return RuanganM::model()->findAll();
        }
}
?>
