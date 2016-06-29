<?php

class GMProduksigasmedisT extends ProduksigasmedisT
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InformasistokobatalkesV the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        public $tgl_awal, $tgl_akhir, $petugas_nama, $mengetahui_nama;
        
        public function searchInformasi() {
           $criteria=new CDbCriteria;

            $criteria->addBetweenCondition('tgl_produksi', $this->tgl_awal, $this->tgl_akhir);   
            if (!empty($this->petugasgasmedis_id)){
                $criteria->compare('petugasgasmedis_id',$this->petugasgasmedis_id);
            }
            
            if (!empty($this->mengetahui_id)){
                $criteria->compare('mengetahui_id',$this->mengetahui_id);
            }
            
           

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));
           
            
            
        }
}