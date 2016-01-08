<?php

/**
 * This is the model class for table "pemeriksaanlab_m".
 *
 * The followings are the available columns in table 'pemeriksaanlab_m':
 * @property integer $pemeriksaanlab_id
 * @property integer $daftartindakan_id
 * @property integer $jenispemeriksaanlab_id
 * @property string $pemeriksaanlab_kode
 * @property integer $pemeriksaanlab_urutan
 * @property string $pemeriksaanlab_nama
 * @property string $pemeriksaanlab_namalainnya
 * @property boolean $pemeriksaanlab_aktif
 */
class SAPemeriksaanlabM extends PemeriksaanlabM
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PemeriksaanlabM the static model class
	 */

	public $daftartindakan_nama;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

			$criteria=new CDbCriteria;

			$criteria->with = array('jenispemeriksaan','daftartindakan');
			$criteria->compare('LOWER(daftartindakan.daftartindakan_nama)',strtolower($this->daftartindakan_nama),true);
			$criteria->compare('LOWER(jenispemeriksaan.jenispemeriksaanlab_nama)',strtolower($this->jenispemeriksaanlab_nama),true);
			if (!empty($this->pemeriksaanlab_id)){
				$criteria->addCondition('pemeriksaanlab_id ='.$this->pemeriksaanlab_id);
			}
			if (!empty($this->daftartindakan_id)){
				$criteria->addCondition('daftartindakan.daftartindakan_id ='.$this->daftartindakan_id);
			}
			if (!empty($this->jenispemeriksaanlab_id)){
				$criteria->addCondition('jenispemeriksaan.jenispemeriksaanlab_id ='.$this->jenispemeriksaanlab_id);
			}
			$criteria->compare('LOWER(pemeriksaanlab_kode)',strtolower($this->pemeriksaanlab_kode),true);
			$criteria->compare('pemeriksaanlab_urutan',$this->pemeriksaanlab_urutan);
			$criteria->compare('LOWER(pemeriksaanlab_nama)',strtolower($this->pemeriksaanlab_nama),true);
			$criteria->compare('LOWER(pemeriksaanlab_namalainnya)',strtolower($this->pemeriksaanlab_namalainnya),true);
			$criteria->compare('pemeriksaanlab_aktif',isset($this->pemeriksaanlab_aktif)?$this->pemeriksaanlab_aktif:true);
				
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}	
	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function searchDialog()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

			$criteria->with = array('jenispemeriksaan','daftartindakan');
			$criteria->compare('LOWER(daftartindakan.daftartindakan_nama)',strtolower($this->daftartindakan_nama),true);
			$criteria->compare('LOWER(jenispemeriksaan.jenispemeriksaanlab_nama)',strtolower($this->jenispemeriksaanlab_nama),true);
			if (!empty($this->pemeriksaanlab_id)){
				$criteria->addCondition('pemeriksaanlab_id ='.$this->pemeriksaanlab_id);
			}
			if (!empty($this->daftartindakan_id)){
				$criteria->addCondition('daftartindakan.daftartindakan_id ='.$this->daftartindakan_id);
			}
			if (!empty($this->jenispemeriksaanlab_id)){
				$criteria->addCondition('jenispemeriksaan.jenispemeriksaanlab_id ='.$this->jenispemeriksaanlab_id);
			}
			$criteria->compare('LOWER(pemeriksaanlab_kode)',strtolower($this->pemeriksaanlab_kode),true);
			$criteria->compare('pemeriksaanlab_urutan',$this->pemeriksaanlab_urutan);
			$criteria->compare('LOWER(pemeriksaanlab_nama)',strtolower($this->pemeriksaanlab_nama),true);
			$criteria->compare('LOWER(pemeriksaanlab_namalainnya)',strtolower($this->pemeriksaanlab_namalainnya),true);
			$criteria->addCondition("pemeriksaanlab_aktif = TRUE");
				
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	
}