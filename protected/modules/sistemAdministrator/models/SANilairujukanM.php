<?php

class SANilairujukanM extends NilairujukanM
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return NilairujukanM the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function searchPilih()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		if(!empty($this->nilairujukan_id)){
			$criteria->addCondition('nilairujukan_id = '.$this->nilairujukan_id);
		}
		if(!empty($this->kelkumurhasillab_id)){
			$criteria->addCondition('kelkumurhasillab_id = '.$this->kelkumurhasillab_id);
		}
		$criteria->compare('LOWER(kelompokdet)',strtolower($this->kelompokdet),true);
		$criteria->compare('LOWER(namapemeriksaandet)',strtolower($this->namapemeriksaandet),true);
		$criteria->compare('LOWER(nilairujukan_jeniskelamin)',strtolower($this->nilairujukan_jeniskelamin),true);
		$criteria->compare('LOWER(nilairujukan_nama)',strtolower($this->nilairujukan_nama),true);
		$criteria->compare('nilairujukan_min',$this->nilairujukan_min);
		$criteria->compare('nilairujukan_max',$this->nilairujukan_max);
		$criteria->compare('LOWER(nilairujukan_satuan)',strtolower($this->nilairujukan_satuan),true);
		$criteria->compare('LOWER(nilairujukan_metode)',strtolower($this->nilairujukan_metode),true);
		$criteria->compare('LOWER(nilairujukan_keterangan)',strtolower($this->nilairujukan_keterangan),true);
		$criteria->addCondition("nilairujukan_aktif = TRUE");
		$criteria->limit=10;

		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
		));
	}
	/**
	 * nilai yang sudah ada converting symbol
	 */
	public function getNilaiRujukan(){
		return CustomFunction::symbolsConverter($this->nilairujukan_nama);
	}
	public function getNilaiSatuan(){
		return CustomFunction::symbolsConverter($this->nilairujukan_satuan);
	}
}