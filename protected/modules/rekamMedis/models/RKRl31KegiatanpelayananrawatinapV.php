<?php
class RKRl31KegiatanpelayananrawatinapV extends Rl31KegiatanpelayananrawatinapV
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function searchRL()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		if(!empty($this->profilrs_id)){
			$criteria->addCondition('profilrs_id = '.$this->profilrs_id);
		}
		$criteria->compare('LOWER(propinsi)',strtolower($this->propinsi),true);
		$criteria->compare('LOWER(kabupaten)',strtolower($this->kabupaten),true);
		$criteria->compare('LOWER(koders)',strtolower($this->koders),true);
		$criteria->compare('LOWER(namars)',strtolower($this->namars),true);
		$criteria->compare('LOWER(tgl_laporan)',strtolower($this->tgl_laporan),true);
		if(!empty($this->jeniskasuspenyakit_id)){
			$criteria->addCondition('jeniskasuspenyakit_id = '.$this->jeniskasuspenyakit_id);
		}
		$criteria->compare('LOWER(jeniskasuspenyakit_nama)',strtolower($this->jeniskasuspenyakit_nama),true);
		$criteria->compare('LOWER(pasienawaltahun)',strtolower($this->pasienawaltahun),true);
		$criteria->compare('LOWER(pasienmasuk)',strtolower($this->pasienmasuk),true);
		$criteria->compare('LOWER(pasienkeluarhidup)',strtolower($this->pasienkeluarhidup),true);
		$criteria->compare('LOWER(pasienmatikurang48jam)',strtolower($this->pasienmatikurang48jam),true);
		$criteria->compare('LOWER(pasienmatilebih48jam)',strtolower($this->pasienmatilebih48jam),true);
		$criteria->compare('LOWER(lamadirawat)',strtolower($this->lamadirawat),true);
		$criteria->compare('LOWER(hariperawatan)',strtolower($this->hariperawatan),true);
		$criteria->compare('LOWER(kelasvvip)',strtolower($this->kelasvvip),true);
		$criteria->compare('LOWER(kelasvip)',strtolower($this->kelasvip),true);
		$criteria->compare('LOWER(kelasi)',strtolower($this->kelasi),true);
		$criteria->compare('LOWER(kelasii)',strtolower($this->kelasii),true);
		$criteria->compare('LOWER(kelasiii)',strtolower($this->kelasiii),true);
		$criteria->compare('LOWER(kelaskhusus)',strtolower($this->kelaskhusus),true);
		$criteria->compare('LOWER(pasienakhirtahun)',strtolower($this->pasienakhirtahun),true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}