<?php
/**
 * This is the model class for table "tariftindakan_m".
 *
 * The followings are the available columns in table 'tariftindakan_m':
 * @property integer $tariftindakan_id
 * @property integer $jenistarif_id
 * @property integer $daftartindakan_id
 * @property integer $komponentarif_id
 * @property integer $perdatarif_id
 * @property double $harga_tariftindakan
 * @property integer $persendiskon_tind
 * @property double $hargadiskon_tind
 * @property integer $persencyto_tind
 */
class RMTarifTindakanM extends TariftindakanM{
    /**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TariftindakanM the static model class
	 */
        public $komponentarifNama;
	public $daftartindakan_nama;
        
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        public function getKelasPelayanan()
        {
            return KelaspelayananM::model()->findAll(
                array('order'=>'kelaspelayanan_nama')
            );
        }        
        
        public function searchDaftarTindakan()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		if (!empty($this->tariftindakan_id)){
			$criteria->addCondition('t.tariftindakan_id ='.$this->tariftindakan_id);
		}
		if (!empty($this->jenistarif_id)){
			$criteria->addCondition('t.jenistarif_id ='.$this->jenistarif_id);
		}
//		$criteria->compare('jenistarif.jenistarif_nama',$this->jenistarif_nama);
		$criteria->compare('LOWER(daftartindakan.daftartindakan_nama)',strtolower($this->daftartindakan_id),true);
//		$criteria->compare('daftartindakan.daftartindakan_nama',$this->daftartindakan_nama);
		if (!empty($this->komponentarif_id)){
			$criteria->addCondition('t.komponentarif_id ='.$this->komponentarif_id);
		}
//		$criteria->compare('komponentarif.komponentarif_nama',$this->komponentarif_nama);
		if (!empty($this->perdatarif_id)){
			$criteria->addCondition('t.perdatarif_id ='.$this->perdatarif_id);
		}
		$criteria->compare('harga_tariftindakan',$this->harga_tariftindakan);
		$criteria->compare('persendiskon_tind',$this->persendiskon_tind);
		$criteria->compare('hargadiskon_tind',$this->hargadiskon_tind);
		$criteria->compare('persencyto_tind',$this->persencyto_tind);
		if (!empty($this->kelaspelayanan_id)){
			$criteria->addCondition('t.kelaspelayanan_id ='.$this->kelaspelayanan_id);
		}
                
                $criteria->compare('tr.ruangan_id', Yii::app()->user->getState('ruangan_id'));
                
                //$criteria->addCondition('t.komponentarif_id = '.Params::KOMPONENTARIF_ID_TOTAL);
                //$criteria->with=array('perdatarif','jenistarif','komponentarif','daftartindakan','kelaspelayanan');
                $criteria->join = 
                        "left join daftartindakan_m daftartindakan on daftartindakan.daftartindakan_id = t.daftartindakan_id "
                        . "left join perdatarif_m perdatarif on perdatarif.perdatarif_id = t.perdatarif_id "
                        . "left join jenistarif_m jenistarif on jenistarif.jenistarif_id = t.jenistarif_id "
                        . "left join komponentarif_m komponentarif on komponentarif.komponentarif_id = t.komponentarif_id "
                        . "left join kelaspelayanan_m kelaspelayanan on kelaspelayanan.kelaspelayanan_id = t.kelaspelayanan_id "
                        . "left join tindakanruangan_m tr on daftartindakan.daftartindakan_id = tr.daftartindakan_id";
                
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
//                        'pagination'=>array(
//                            'pageSize'=>1,
//                        ),
		));
	}
}
