<?php

class FAResepturDetailT extends ResepturdetailT
{
	public $jmlstok,$therapiobat_id, $qty_dilayani, $subtotal, $grandtotal, $takaranresep;
	public $obatalkes_nama,$jasadokterresep,$discount,$iurbiaya,$stokobatalkes_id;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return AnamnesaT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function getObatAlkesNama(){
		$obatalkes_id = $this->obatalkes_id;
		$modOa = FAObatalkesM::model()->findByPk($obatalkes_id);
		return $modOa->obatalkes_nama;
	}

}