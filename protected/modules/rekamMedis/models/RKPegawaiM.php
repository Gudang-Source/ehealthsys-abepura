<?php

class RKPegawaiM extends PegawaiM
{
    
    public $nama_pemakai;
    public $new_password;
    public $new_password_repeat;  
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PegawaiM the static model class
	 */
    public $tempPhoto;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        public function searchPegawaiTriase()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->with = array('gelarbelakang');
		$criteria->compare('t.pegawai_id',$this->pegawai_id);
		$criteria->compare('t.gelarbelakang_id',$this->gelarbelakang_id);
		$criteria->compare('LOWER(gelarbelakang.gelarbelakang_nama)',strtolower($this->gelarbelakang_nama),true);
		$criteria->compare('LOWER(t.gelardepan)',strtolower($this->gelardepan),true);
		$criteria->compare('LOWER(t.nama_pegawai)',strtolower($this->nama_pegawai),true);
		$criteria->compare('LOWER(t.jeniskelamin)',strtolower($this->jeniskelamin),true);
		$criteria->compare('LOWER(t.alamat_pegawai)',strtolower($this->alamat_pegawai),true);
		$criteria->compare('LOWER(t.agama)',strtolower($this->agama),true);
		
		$criteria->order = 't.pegawai_id ASC';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                  		));
	}
        
        public function getPegawai()
        {
            $criteria=new CDbCriteria();
            $criteria->with = array('ruanganpegawai');
            $criteria->addCondition('ruanganpegawai.ruangan_id = '.Yii::app()->user->getState('ruangan_id'));
            $criteria->addCondition('t.pegawai_aktif = TRUE');
            $criteria->order = 't.nama_pegawai ASC';
            
            return $this->findAll($criteria);
        }

}