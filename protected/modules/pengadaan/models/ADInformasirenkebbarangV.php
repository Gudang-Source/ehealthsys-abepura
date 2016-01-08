<?php

class ADInformasirenkebbarangV extends InformasirenkebbarangV
{
	public $tgl_awal,$tgl_akhir;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function searchInformasi()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
                
		$criteria->addBetweenCondition('DATE(renkebbarang_tgl)',$this->tgl_awal,$this->tgl_akhir,true);
		
		$criteria->compare('LOWER(renkebbarang_no)',strtolower($this->renkebbarang_no),true);
		//$criteria->distinct="renkebbarang_no,renkebbarang_tgl,renkebbarang_id";
		if(!empty($this->pegmengetahui_id)){
			$criteria->addCondition('pegmengetahui_id = '.$this->pegmengetahui_id);
		}
		if(!empty($this->pegmenyetujui_id)){
			$criteria->addCondition('pegmenyetujui_id = '.$this->pegmenyetujui_id);
		}
		
		$criteria->group="renkebbarang_no,renkebbarang_tgl,ro_barang_bulan,pegmengetahui_id,pegmenyetujui_id,renkebbarang_id";
		$criteria->select = $criteria->group;
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public static function pegawaimengetahui($pegmengetahui_id){
		$pegawaimengetahui = ADPegawaiM::model()->findBypk($pegmengetahui_id);
		return isset($pegawaimengetahui->nama_pegawai) ? $pegawaimengetahui->gelardepan.' '.$pegawaimengetahui->nama_pegawai : "";
	}

	public static function pegawaimenyetujui($pegmenyetujui_id){
		$pegawaimenyetujui = ADPegawaiM::model()->findBypk($pegmenyetujui_id);
		return isset($pegawaimenyetujui->nama_pegawai) ? $pegawaimenyetujui->gelardepan.' '.$pegawaimenyetujui->nama_pegawai : "";
	}
	
}