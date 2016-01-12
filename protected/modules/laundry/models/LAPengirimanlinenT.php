<?php
class LAPengirimanlinenT extends PengirimanlinenT
{
	public $pegpengirim_nama,$mengetahui_nama;
	public $tgl_awal, $tgl_akhir, $instalasi_id;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PengirimanlinenT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function searchInformasi(){
		
		$criteria=new CDbCriteria;
		
		$criteria->addBetweenCondition('DATE(tglpengirimanlinen)',$this->tgl_awal,$this->tgl_akhir);
		if(!empty($this->pengirimanlinen_id)){
			$criteria->addCondition('pengirimanlinen_id = '.$this->pengirimanlinen_id);
		}
		$criteria->compare('LOWER(nopengirimanlinen)',strtolower($this->nopengirimanlinen),true);
		$criteria->compare('LOWER(keterangan_pengiriman)',strtolower($this->keterangan_pengiriman),true);
		if(!empty($this->ruangantujuan_id)){
			$criteria->addCondition('ruangantujuan_id = '.$this->ruangantujuan_id);
		}
		if(!empty($this->pegpengirim_id)){
			$criteria->addCondition('pegpengirim_id = '.$this->pegpengirim_id);
		}
		if(!empty($this->mengetahui_id)){
			$criteria->addCondition('mengetahui_id = '.$this->mengetahui_id);
		}
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		if(!empty($this->create_loginpemakai_id)){
			$criteria->addCondition('create_loginpemakai_id = '.$this->create_loginpemakai_id);
		}
		if(!empty($this->update_loginpemakai_id)){
			$criteria->addCondition('update_loginpemakai_id = '.$this->update_loginpemakai_id);
		}
		if(!empty($this->create_ruangan)){
			$criteria->addCondition('create_ruangan = '.$this->create_ruangan);
		}
//		$criteria->addCondition('ruangantujuan_id ='.Yii::app()->user->ruangan_id);
//		$criteria->addCondition('issudahditerima IS TRUE');

		$criteria->limit=10;

		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
		));
	}
}