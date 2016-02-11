<?php

class SAImplementasikeperawatanM extends ImplementasikeperawatanM
{

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    
    public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('implementasikeperawatan_id',$this->implementasikeperawatan_id);
		$criteria->compare('diagnosakeperawatan_id',$this->diagnosakeperawatan_id);
		$criteria->compare('rencanakeperawatan_id',$this->rencanakeperawatan_id);
		$criteria->compare('LOWER(implementasikeperawatan_kode)',strtolower($this->implementasikeperawatan_kode),true);
		$criteria->compare('LOWER(implementasi_nama)',strtolower($this->implementasi_nama),true);
		//$criteria->compare('iskolaborasiimplementasi',isset($this->iskolaborasiimplementasi)?$this->iskolaborasiimplementasi:true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

}