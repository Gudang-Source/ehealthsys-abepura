<?php

class FAInformasiresepturV extends InformasiresepturV
{
	public $tgl_awal,$tgl_akhir;

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function searchInformasiPasienResep()
    {
        $criteria=$this->criteriaSearch();
        $criteria->addBetweenCondition('date(tglreseptur)', $this->tgl_awal, $this->tgl_akhir);
        $criteria->order = 'tglreseptur DESC';
        $criteria->limit=10;

        return new CActiveDataProvider($this, array(
                'criteria'=>$criteria,
        ));
    }
	
	public function GetNoPenjualanResep($reseptur_id)
    {
		$modPenjualans = FAPenjualanResepT::model()->findAllByAttributes(array('reseptur_id'=>$reseptur_id));
		$echo ='';
		if(count($modPenjualans) > 0){
			foreach($modPenjualans as $i => $modPenjualan){
				$echo .= $modPenjualan->noresep."<br>";
			}
		}
		return $echo;
	}
}

