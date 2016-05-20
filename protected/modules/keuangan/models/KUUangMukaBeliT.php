<?php

class KUUangMukaBeliT extends UangmukabeliT
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return UangmukabeliT the static model class
	 */
    
        public $tgl_awal, $tgl_akhir;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        public function searchInformasi()
        {
            $criteria = new CDbCriteria;
            
            return new CActiveDataProvider($this, array(
                'criteria'=>$criteria,
            ));
        }
}