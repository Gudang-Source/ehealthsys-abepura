<?php

class GUPesanbarangT extends PesanbarangT {
    

    public $tgl_awal,$tgl_akhir;
    public $instalasi_id;
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    
    public function getNamaModel(){
        return __CLASS__;
    }
    
    public function searchInformasi()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->addBetweenCondition('date(tglpesanbarang)', $this->tgl_awal, $this->tgl_akhir);
		if(!empty($this->pesanbarang_id)){
			$criteria->addCondition("pesanbarang_id = ".$this->pesanbarang_id);			
		}
		if(!empty($this->mutasibrg_id)){
			$criteria->addCondition("mutasibrg_id = ".$this->mutasibrg_id);			
		}
		$criteria->compare('LOWER(nopemesanan)',strtolower($this->nopemesanan),true);
		if(!empty($this->ruanganpemesan_id)){
			$criteria->addCondition("ruanganpemesan_id = ".$this->ruanganpemesan_id);			
		}
		$criteria->compare('LOWER(keterangan_pesan)',strtolower($this->keterangan_pesan),true);
		if(!empty($this->pegpemesan_id)){
			$criteria->addCondition("pegpemesan_id = ".$this->pegpemesan_id);			
		}
		if(!empty($this->pegmengetahui_id)){
			$criteria->addCondition("pegmengetahui_id = ".$this->pegmengetahui_id);			
		}
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
    public function searchInformasiGudang()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->addBetweenCondition('date(tglpesanbarang)', $this->tgl_awal, $this->tgl_akhir);
		if(!empty($this->pesanbarang_id)){
			$criteria->addCondition("pesanbarang_id = ".$this->pesanbarang_id);			
		}
		if(!empty($this->mutasibrg_id)){
			$criteria->addCondition("mutasibrg_id = ".$this->mutasibrg_id);			
		}
		$criteria->compare('LOWER(nopemesanan)',strtolower($this->nopemesanan),true);
		$criteria->compare('LOWER(tglmintadikirim)',strtolower($this->tglmintadikirim),true);
		if(!empty($this->ruanganpemesan_id)){
			$criteria->addCondition("ruanganpemesan_id = ".$this->ruanganpemesan_id);			
		}
		$criteria->compare('LOWER(keterangan_pesan)',strtolower($this->keterangan_pesan),true);
		if(!empty($this->pegpemesan_id)){
			$criteria->addCondition("pegpemesan_id = ".$this->pegpemesan_id);			
		}
		if(!empty($this->pegmengetahui_id)){
			$criteria->addCondition("pegmengetahui_id = ".$this->pegmengetahui_id);			
		}
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
		$criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        public function getPegawaiRuangan()
        {
            $cr = new CDbCriteria();
            $cr->addCondition(" ruangan_id = '".Yii::app()->user->getState('ruangan_id')."' ");
            $cr->addCondition(" pegawai_aktif= TRUE ");
            $cr->order = "nama_pegawai ASC";
            
            return PegawairuanganV::model()->findAll($cr);
        }

}