<?php

class LAPengperawatanlinenT extends PengperawatanlinenT {
	public $pegawaimengetahui_nama,$pegawaimengajukan_nama;
	public $tgl_awal,$tgl_akhir;
	public $instalasi_id;
        public $ruanganpengirim_id;
        
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function searchInformasi()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

                $criteria->join = 'join ruangan_m r on r.ruangan_id = t.ruangan_id';
                
                if (!empty($this->tgl_awal) && !empty($this->tgl_akhir)) {
                    $criteria->addBetweenCondition('DATE(t.tglpengperawatanlinen)',$this->tgl_awal, $this->tgl_akhir);
                }
                if(!empty($this->pengperawatanlinen_id)){
			$criteria->addCondition('t.pengperawatanlinen_id = '.$this->pengperawatanlinen_id);
		}
		if(!empty($this->ruanganpengirim_id)){
			$criteria->addCondition('t.ruangan_id = '.$this->ruanganpengirim_id);
                }
		$criteria->compare('LOWER(t.pengperawatanlinen_no)',strtolower($this->pengperawatanlinen_no),true);
		$criteria->compare('LOWER(t.keterangan_pengperawatanlinen)',strtolower($this->keterangan_pengperawatanlinen),true);
		if(!empty($this->mengajukan_id)){
			$criteria->addCondition('t.mengajukan_id = '.$this->mengajukan_id);
		}
		if(!empty($this->mengetahui_id)){
			$criteria->addCondition('t.mengetahui_id = '.$this->mengetahui_id);
		}
		$criteria->compare('LOWER(t.create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(t.update_time)',strtolower($this->update_time),true);
		if(!empty($this->create_loginpemakai_id)){
			$criteria->addCondition('t.create_loginpemakai_id = '.$this->create_loginpemakai_id);
		}
		if(!empty($this->update_loginpemakai_id)){
			$criteria->addCondition('t.update_loginpemakai_id = '.$this->update_loginpemakai_id);
		}
		if(!empty($this->create_ruangan)){
			$criteria->addCondition('t.create_ruangan = '.$this->create_ruangan);
		}
                
                $criteria->compare('r.instalasi_id', $this->instalasi_id);
                
		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
		));
	}
        
        public function searchInformasiDialog() {
                $provider = $this->searchInformasi();
                $provider->criteria->join .= " left join penerimaanlinen_t l on l.pengperawatanlinen_id = t.pengperawatanlinen_id";
                $provider->criteria->addCondition('l.pengperawatanlinen_id is null');
                return $provider;
        }
	
	public function getSudahTerima($pengperawatanlinen_id){
		$modPenerimaan = LAPenerimaanlinenT::model()->findByAttributes(array('pengperawatanlinen_id'=>$pengperawatanlinen_id));
		return $modPenerimaan;
	}
}