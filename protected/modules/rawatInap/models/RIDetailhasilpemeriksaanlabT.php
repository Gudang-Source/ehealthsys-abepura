<?php
class RIDetailhasilpemeriksaanlabT extends DetailhasilpemeriksaanlabT {

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    
    public function searchDetailHasilLab($data)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		if(!empty($this->detailhasilpemeriksaanlab_id)){
			$criteria->addCondition("detailhasilpemeriksaanlab_id = ".$this->detailhasilpemeriksaanlab_id); 	
		}
		if(!empty($this->hasilpemeriksaanlab_id)){
			$criteria->addCondition("hasilpemeriksaanlab_id = ".$this->hasilpemeriksaanlab_id); 	
		}
		if(!empty($this->pemeriksaanlab_id)){
			$criteria->addCondition("pemeriksaanlab_id = ".$this->pemeriksaanlab_id); 	
		}
		$criteria->condition = 'hasilpemeriksaanlab_id ='.$data;
		$criteria->order = 'pemeriksaanlabdet_id';
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}