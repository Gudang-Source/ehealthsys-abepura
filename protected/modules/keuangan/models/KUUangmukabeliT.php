<?php
class KUUangmukabeliT extends UangmukabeliT
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return UangmukabeliT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        public function searchInformasi() {
                $criteria=new CDbCriteria;

		$criteria->compare('uangmukabeli_id',$this->uangmukabeli_id);
		$criteria->compare('supplier_id',$this->supplier_id);
		$criteria->compare('penerimaanbarang_id',$this->penerimaanbarang_id);
		$criteria->compare('LOWER(namabank)',strtolower($this->namabank),true);
		$criteria->compare('LOWER(norekening)',strtolower($this->norekening),true);
		$criteria->compare('LOWER(rekatasnama)',strtolower($this->rekatasnama),true);
		$criteria->compare('jumlahuang',$this->jumlahuang);
                $criteria->addCondition("penerimaanbarang_id IS NOT NULL");

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
        }

}