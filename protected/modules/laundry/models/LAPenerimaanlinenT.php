<?php
class LAPenerimaanlinenT extends PenerimaanlinenT{
	public $pegawaimengetahui_nama,$pegawaimenerima_nama;
	public $instalasi_nama,$ruangan_nama;
	public $tgl_awal,$tgl_akhir,$instalasi_id;
        public $pengperawatanlinen_no;
        public $pegawaipengirim_id;
        public $ruanganpengirim_id;
        
	
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	// fungsi untuk informasi penerimaan linen controller
	public function searchInformasi()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
                $criteria->join = "JOIN pengperawatanlinen_t ppl ON t.pengperawatanlinen_id = ppl.pengperawatanlinen_id";
		$criteria->addBetweenCondition('DATE(t.tglpenerimaanlinen)',$this->tgl_awal, $this->tgl_akhir);
		
		if(!empty($this->penerimaanlinen_id)){
			$criteria->addCondition('t.penerimaanlinen_id = '.$this->penerimaanlinen_id);
		}
		if(!empty($this->ruangan_id)){
			$criteria->addCondition('t.ruangan_id = '.$this->ruangan_id);
		}
		if(!empty($this->pengperawatanlinen_id)){
			$criteria->addCondition('t.pengperawatanlinen_id = '.$this->pengperawatanlinen_id);
		}
		$criteria->compare('LOWER(t.nopenerimaanlinen)',strtolower($this->nopenerimaanlinen),true);
		$criteria->compare('LOWER(t.keterangan_penerimaanlinen)',strtolower($this->keterangan_penerimaanlinen),true);
		if(!empty($this->pegmenerima_id)){
			$criteria->addCondition('t.pegmenerima_id = '.$this->pegmenerima_id);
		}
		if(!empty($this->pegmengetahui_id)){
			$criteria->addCondition('t.pegmengetahui_id = '.$this->pegmengetahui_id);
		}
		if(!empty($this->beratlinen)){
			$criteria->addCondition('t.beratlinen = '.$this->beratlinen);
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
                if(!empty($this->create_ruangan)){
			$criteria->addCondition('t.create_ruangan = '.$this->create_ruangan);
		}
                if (!empty($this->pegawaipengirim_id)){
                    $criteria->addCondition('ppl.mengajukan_id = '.$this->pegawaipengirim_id);
                }
                if (!empty($this->ruanganpengirim_id)){
                    
                    $criteria->addCondition('ppl.ruangan_id = '.$this->ruanganpengirim_id);
                }else{
                    if (!empty($this->instalasi_id)){
                        $ruangan =  Yii::app()->db->createCommand(" SELECT ruangan_id FROM  ruangan_m WHERE instalasi_id = '".$this->instalasi_id."' AND ruangan_aktif = TRUE")->queryAll();
                        $r = array();
                        
                        if (count($ruangan)>0){
                            foreach($ruangan as $data){
                                $r[] = $data['ruangan_id'];
                            }
                            
                            $criteria->addInCondition('ppl.ruangan_id', $r);
                        }
                                                
                    }
                }

		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
		));
	}
	
}