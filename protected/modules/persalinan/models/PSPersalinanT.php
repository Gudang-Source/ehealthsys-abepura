<?php
class PSPersalinanT extends PersalinanT {

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    
    public function getDokterItems($ruangan_id='')
        {
            $ruangan_id = Yii::app()->user->getState('ruangan_id');
            if(!empty($ruangan_id))
                return DokterV::model()->findAllByAttributes(array('ruangan_id'=>$ruangan_id));
            else
                return array();
        }
        
    public function getBidanItems($ruangan_id='')
        {
            $ruangan_id = Yii::app()->user->getState('ruangan_id');
            if(!empty($ruangan_id))
                return PegawaiM::model()->findAllByAttributes(array('kelompokpegawai_id'=>2));
            else
                return array();
        }
        
    public function getParamedisItems($ruangan_id='')
        {
            $ruangan_id = Yii::app()->user->getState('ruangan_id');
            if(!empty($ruangan_id))
                return PegawaiM::model()->findAllByAttributes(array('kelompokpegawai_id'=>2));
            else
                return array();
        }

    public function search10Terakhir()
    {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria=new CDbCriteria;
            $criteria->order = "tglmelahirkan";
            $criteria->limit=10; 
            

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
                    'pagination'=>false,
            ));
    }

}