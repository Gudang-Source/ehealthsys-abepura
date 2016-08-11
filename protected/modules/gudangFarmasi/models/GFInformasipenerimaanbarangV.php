<?php
class GFInformasipenerimaanbarangV extends InformasipenerimaanbarangV
{
        public $tgl_awal;
        public $tgl_akhir;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InformasipenerimaanbarangV the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        public function searchInformasi()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
                
		$criteria->addBetweenCondition('DATE(tglterima)',$this->tgl_awal,$this->tgl_akhir,true);
		if(!empty($this->penerimaanbarang_id)){
			$criteria->addCondition('penerimaanbarang_id = '.$this->penerimaanbarang_id);
		}
		$criteria->compare('LOWER(noterima)',strtolower($this->noterima),true);		
		$criteria->compare('tglterimafaktur',$this->tglterimafaktur,true);
		$criteria->compare('LOWER(nofaktur)',strtolower($this->nofaktur),true);
		$criteria->compare('tglfaktur',$this->tglfaktur,true);
		$criteria->compare('tgljatuhtempo',$this->tgljatuhtempo,true);
		$criteria->compare('keteranganfaktur',$this->keteranganfaktur,true);
		$criteria->compare('LOWER(nosuratjalan)',strtolower($this->nosuratjalan),true);
		$criteria->compare('tglsuratjalan',$this->tglsuratjalan,true);
		if(!empty($this->supplier_id)){
			$criteria->addCondition('supplier_id = '.$this->supplier_id);
		}
		if(!empty($this->gudangpenerima_id)){
			$criteria->addCondition('gudangpenerima_id = '.$this->gudangpenerima_id);
		}
                if(!empty($this->pegawaimengetahui_id)){
			$criteria->addCondition('pegawaimengetahui_id = '.$this->pegawaimengetahui_id);
		}
                if(!empty($this->pegawaimenyetujui_id)){
			$criteria->addCondition('pegawaimenyetujui_id = '.$this->pegawaimenyetujui_id);
		}
		$criteria->compare('LOWER(statuspenerimaan)',strtolower($this->statuspenerimaan),true);
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        public function searchDialog()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		
		if(!empty($this->penerimaanbarang_id)){
			$criteria->addCondition('penerimaanbarang_id = '.$this->penerimaanbarang_id);
		}
		$criteria->compare('LOWER(noterima)',strtolower($this->noterima),true);		
		$criteria->compare('tglterimafaktur',$this->tglterimafaktur,true);
		$criteria->compare('LOWER(nofaktur)',strtolower($this->nofaktur),true);
		$criteria->compare('tglfaktur',$this->tglfaktur,true);
		$criteria->compare('tgljatuhtempo',$this->tgljatuhtempo,true);
		$criteria->compare('keteranganfaktur',$this->keteranganfaktur,true);
		$criteria->compare('LOWER(nosuratjalan)',strtolower($this->nosuratjalan),true);
		$criteria->compare('tglsuratjalan',$this->tglsuratjalan,true);
		if(!empty($this->supplier_id)){
			$criteria->addCondition('supplier_id = '.$this->supplier_id);
		}
		if(!empty($this->gudangpenerima_id)){
			$criteria->addCondition('gudangpenerima_id = '.$this->gudangpenerima_id);
		}
                
                $criteria->addCondition('fakturpembelian_id is null');
		$criteria->compare('LOWER(statuspenerimaan)',strtolower($this->statuspenerimaan),true);
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        public function getPegawaimengetahuiLengkap()
        {
            return (isset($this->pegawaimengetahui_gelardepan) ? $this->pegawaimengetahui_gelardepan : "").' '.$this->pegawaimengetahui_nama.(isset($this->pegawaimengetahui_gelarbelakang) ? ', '.$this->pegawaimengetahui_gelardepan : "");
        }

        public function getPegawaimenyetujuiLengkap()
        {
            return (isset($this->pegawaimenyetujui_gelardepan) ? $this->pegawaimenyetujui_gelardepan : "").' '.$this->pegawaimenyetujui_nama.(isset($this->pegawaimenyetujui_gelarbelakang) ? ', '.$this->pegawaimenyetujui_gelardepan : "");
        }
		
        public function getJmlTerima()
        {
			$return = 0;
			$modPenerimaanDetails = GFPenerimaanDetailT::model()->findAllByAttributes(array('penerimaanbarang_id'=>$this->penerimaanbarang_id));
			if(count($modPenerimaanDetails)>0){
				foreach($modPenerimaanDetails as $i => $modPenerimaanDetail){
					$return += $modPenerimaanDetail->jmlterima;
				}
			}
            return $return;
        }
}