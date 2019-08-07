<?php

class ASPegawaiM extends PegawaiM {
        public $jabatan_nama;

	public static function model($className = __CLASS__) {
		return parent::model($className);
	}

	public function searchPerawat() {
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria = new CDbCriteria;		
                $criteria->with = array('ruanganpegawai');
		$criteria->compare('t.kelompokpegawai_id', 2);		
                if (!empty($this->jabatan_id)){
                    $criteria->addCondition('t.jabatan_id ='.$this->jabatan_id);
                }
                $criteria->addCondition(" ruanganpegawai.ruangan_id = '".Yii::app()->user->getState('ruangan_id')."' ");
                $criteria->compare('LOWER(t.nomorindukpegawai)', strtolower($this->nomorindukpegawai), TRUE);
                $criteria->compare('LOWER(t.nama_pegawai)', strtolower($this->nama_pegawai), TRUE);
		$criteria->addCondition('t.pegawai_aktif = TRUE');
		$criteria->order = 't.pegawai_id ASC';
		$criteria->limit = 10;
		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
			//'pagination' => false,
		));
	}

}
