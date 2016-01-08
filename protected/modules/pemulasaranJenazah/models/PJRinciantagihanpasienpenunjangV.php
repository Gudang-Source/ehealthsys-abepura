<?php
class PJRinciantagihanpasienpenunjangV extends RinciantagihanpasienpenunjangV
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        public function getSubTotal(){
            return ($this->tarif_satuan*$this->qty_tindakan)+$this->tarifcyto_tindakan+$this->discount_tindakan;
        }
        
        public function getNamaModel(){
            return __CLASS__;
        }      
        

}