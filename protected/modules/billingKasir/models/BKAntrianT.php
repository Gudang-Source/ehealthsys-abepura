<?php
class BKAntrianT extends AntrianT
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return AntrianT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function searchKarcisTerakhir()
        {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria=$this->criteriaSearch();
            $criteria->compare('ruangan_id',Yii::app()->user->getState('ruangan_id'));
            $criteria->compare('LOWER(noantrian)',strtolower($this->noantrian),true);
            $criteria->compare('panggil_flaq',$this->panggil_flaq);
            
            $criteria->compare('DATE(tglantrian)',date('Y-m-d H:i:s'));
            $criteria->limit=5;
            if(!isset($_GET[get_class($this)."_sort"])){
                $criteria->order = 'tglantrian DESC';
            }
            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
                    'pagination'=>array('pageSize'=>3),
            ));
        }

	/**
     * menampilkan racikan_m
     * @return array
     */
    public function getListRuangans($ruangan_id = null){
        $criteria = new CDbCriteria();
        if(!empty($ruangan_id)){
        	$criteria->addCondition("ruangan_id=".$ruangan_id);
        }
        $criteria->addCondition("instalasi_id=".Params::INSTALASI_ID_KASIR);
        $criteria->addCondition ("ruangan_aktif = TRUE");
        $modRuangans = RuanganM::model()->findAll($criteria);
        $data = array();
        if(count($modRuangans) > 0){
            foreach($modRuangans AS $i=>$ruangan){
                $data[$ruangan->ruangan_id] = $ruangan->ruangan_nama." (".$ruangan->ruangan_singkatan.")";
            } 
        }
        return $data;
    }

    public function getAntrianBerikut()
    {
        $criteria = new CDbCriteria;
        $criteria->addCondition("antrian_id > ".$this->antrian_id);
        $criteria->addCondition("pendaftaran_id IS NOT NULL");
        $criteria->compare('DATE(tglantrian)',date('Y-m-d H:i:s'));
        $criteria->addCondition("ruangan_id =". Yii::app()->user->getState('ruangan_id'));
        $criteria->order = "antrian_id ASC";
        $criteria->limit = 1;
        $record=self::model()->find($criteria);
        if($record!==null)
            return $record;
        return null;
    }
    /**
     * menentukan antrian sebelumnya
     * @return null
     */
    public function getAntrianSebelum()
    {
        $criteria = new CDbCriteria;
        $criteria->addCondition("antrian_id < ".$this->antrian_id);
        $criteria->addCondition("pendaftaran_id IS NOT NULL");
        $criteria->compare('DATE(tglantrian)',date('Y-m-d H:i:s'));
        $criteria->addCondition("ruangan_id =". Yii::app()->user->getState('ruangan_id'));
        $criteria->order = "antrian_id DESC";
        $criteria->limit = 1;
        $record=self::model()->find($criteria);
        if($record!==null)
            return $record;
        return null;
    }
    
    /**
     * menampilkan loket antrian (loket_m)
     */
    public function getLokets($loket_id = null){
        $data = array();
        $criteria = new CDbCriteria();
        if (!empty($loket_id)){
        $criteria->addCondition("loket_id = ".$loket_id);
        }
        $criteria->addCondition("iskasir = TRUE");
        $criteria->addCondition("loket_aktif = TRUE");
        $criteria->order = "loket_nourut ASC";
        $modLokets = LoketM::model()->findAll($criteria);
        if(count($modLokets) > 0){
            return $modLokets;
        }else{
            return array();
        }
    }
}