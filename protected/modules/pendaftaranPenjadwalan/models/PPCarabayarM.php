<?php
class PPCarabayarM extends CarabayarM {

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
	
	public function searchPrint()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('carabayar_id',$this->carabayar_id);
		$criteria->compare('LOWER(carabayar_nama)',strtolower($this->carabayar_nama),true);
		$criteria->compare('LOWER(carabayar_namalainnya)',strtolower($this->carabayar_namalainnya),true);
		$criteria->compare('LOWER(metode_pembayaran)',strtolower($this->metode_pembayaran),true);
		$criteria->compare('carabayar_aktif',isset($this->carabayar_aktif)?$this->carabayar_aktif:true);
		$criteria->compare('LOWER(carabayar_loket)',strtolower($this->carabayar_loket),true);
		$criteria->compare('LOWER(carabayar_singkatan)',strtolower($this->carabayar_singkatan),true);
		$criteria->compare('carabayar_nourut',$this->carabayar_nourut);
		$criteria->limit = -1;
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'pagination'=>false,
		));
	}
	

}