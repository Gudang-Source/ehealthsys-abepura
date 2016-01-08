<?php

class BKInformasiclosingkasirV extends InformasiclosingkasirV
{
        public $tgl_awal, $tgl_akhir;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InformasiclosingkasirV the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
         * digunakan di:
         * - Bilingkasir - Informasi - Closing Kasir
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function searchInformasi()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		if(!empty($this->closingkasir_id)){
			$criteria->addCondition('closingkasir_id = '.$this->closingkasir_id);
		}
		if(!empty($this->shift_id)){
			$criteria->addCondition('shift_id = '.$this->shift_id);
		}
		$criteria->compare('LOWER(shift_nama',$this->shift_nama,true);
		if(!empty($this->pegawai_id)){
			$criteria->addCondition('pegawai_id = '.$this->pegawai_id);
		}
		$criteria->compare('LOWER(nama_pegawai)', strtolower($this->nama_pegawai),true);
		if(!empty($this->setorbank_id)){
			$criteria->addCondition('setorbank_id = '.$this->setorbank_id);
		}
		$criteria->addBetweenCondition('DATE(tglclosingkasir)',$this->tgl_awal,$this->tgl_akhir);
		$criteria->compare('closingdari',$this->closingdari,true);
		$criteria->compare('sampaidengan',$this->sampaidengan,true);
		$criteria->compare('closingsaldoawal',$this->closingsaldoawal);
		$criteria->compare('terimauangmuka',$this->terimauangmuka);
		$criteria->compare('terimauangpelayanan',$this->terimauangpelayanan);
		$criteria->compare('totalsetoran',$this->totalsetoran);
		$criteria->compare('nilaiclosingtrans',$this->nilaiclosingtrans);
		$criteria->addCondition('create_ruangan = '.Yii::app()->user->getState('ruangan_id'));
		if(!empty($this->tandabuktibayar_id)){
			$criteria->addCondition('tandabuktibayar_id = '.$this->tandabuktibayar_id);
		}
//                $criteria->group = "closingkasir_id, tglclosingkasir, closingdari, sampaidengan, pegawai_id, nama_pegawai, shift_id, shift_nama, closingsaldoawal, terimauangmuka, terimauangpelayanan, totalsetoran, nilaiclosingtrans, setorbank_id, create_ruangan, tandabuktibayar_id";
//                $criteria->select = "closingkasir_id, tglclosingkasir, closingdari, sampaidengan, pegawai_id, nama_pegawai, shift_id, shift_nama, closingsaldoawal, terimauangmuka, terimauangpelayanan, totalsetoran, nilaiclosingtrans, setorbank_id, create_ruangan, tandabuktibayar_id";
                $criteria->group = "closingkasir_id, tglclosingkasir, pegawai_id, nama_pegawai, shift_id, shift_nama, closingdari, sampaidengan, closingsaldoawal, terimauangmuka, terimauangpelayanan, setorbank_id, nilaiclosingtrans, nostruksetor, tgldisetor, namabank, norekening, jumlahsetoran";
                $criteria->select = "closingkasir_id, tglclosingkasir, pegawai_id, nama_pegawai, shift_id, shift_nama, closingdari, sampaidengan, closingsaldoawal, terimauangmuka, terimauangpelayanan, setorbank_id, nilaiclosingtrans, nostruksetor, tgldisetor, namabank, norekening, jumlahsetoran";
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
                
        public function getBuktibayar($attr){
            $modTandabukti = TandabuktibayarT::model()->findByPk($this->tandabuktibayar_id);
            if($attr = "tglbuktibayar"){
                return $modTandabukti->tglbuktibayar;
            }else{
                return null;
            }
        }
        
        public function getShiftItems(){
            $modShift = ShiftM::model()->findAllByAttributes(array('shift_aktif'=>true), array('order'=>'shift_jamawal'));
            return $modShift;
        }
}