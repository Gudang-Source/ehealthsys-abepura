<?php

class KOKeanggotaanV extends KeanggotaanV
{

	
	
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function searchInformasi(){
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

		$criteria=new CDbCriteria;
		$criteria->addBetweenCondition('tglkeanggotaaan', $this->tgl_awal, $this->tgl_akhir);
                if (!empty($this->jabatan_id)){
                    $criteria->addCondition('jabatan_id = '.$this->jabatan_id);
                }
                
                 if (!empty($this->golonganpegawai_id)){
                    $criteria->addCondition('golonganpegawai_id = '.$this->golonganpegawai_id);
                }
                $criteria->order = 'tglkeanggotaaan DESC';
                $criteria->limit=10; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        //'pagination'=>false,
                ));
	}
        
       
}