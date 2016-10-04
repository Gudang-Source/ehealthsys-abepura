<?php

class ASPegawaiM extends PegawaiM {

	public static function model($className = __CLASS__) {
		return parent::model($className);
	}

	public function searchPerawat() {
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria = new CDbCriteria;		
		$criteria->compare('kelompokpegawai_id', 2);		
                if (!empty($this->jabatan_id)){
                    $criteria->addCondition('jabatan_id ='.$this->jabatan_id);
                }
                $criteria->compare('LOWER(nomorindukpegawai)', strtolower($this->nomorindukpegawai), TRUE);
                $criteria->compare('LOWER(nama_pegawai)', strtolower($this->nama_pegawai), TRUE);
		$criteria->addCondition('pegawai_aktif = TRUE');
		$criteria->order = 'pegawai_id ASC';
		$criteria->limit = 10;
		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
			//'pagination' => false,
		));
	}

}
