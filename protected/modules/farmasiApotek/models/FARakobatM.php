<?php

/**
 * This is the model class for table "rakobat_m".
 *
 * The followings are the available columns in table 'rakobat_m':
 * @property integer $rakobat_id
 * @property string $rakobat_nama
 * @property string $rakobat_namalain
 * @property string $rakobat_label
 * @property boolean $rakobat_aktif
 *
 * The followings are the available model relations:
 * @property StokobatalkesT[] $stokobatalkesTs
 */
class FARakobatM extends RakobatM
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return RakobatM the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function criteriaSearch()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		if(!empty($this->rakobat_id)){
			$criteria->addCondition('rakobat_id = '.$this->rakobat_id);
		}
		$criteria->compare('LOWER(rakobat_nama)',strtolower($this->rakobat_nama),true);
		$criteria->compare('LOWER(rakobat_namalain)',strtolower($this->rakobat_namalain),true);
		$criteria->compare('LOWER(rakobat_label)',strtolower($this->rakobat_label),true);
		$criteria->compare('rakobat_aktif',isset($this->rakobat_aktif)?$this->rakobat_aktif:true);
		return $criteria;
	}
}