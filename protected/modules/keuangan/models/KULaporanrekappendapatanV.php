<?php
class KULaporanrekappendapatanV extends LaporanrekappendapatanV
{
	public $totaliurbiaya,$totalsubsidiasuransi;
	public $jns_periode,$tgl_awal,$tgl_akhir,$bln_awal,$bln_akhir,$thn_awal,$thn_akhir;
        public $data, $tick, $jumlah;
        public $instalasi_id, $ruangan_id;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        public function searchTable()
	{
		$criteria=new CDbCriteria;

		$criteria->select = 'pendaftaran_id,pasien_id,nama_pasien,no_rekam_medik,carapembayaran,nama_pemakai,penjamin_nama,tglpembayaran,ruanganakhir_nama, namadepan,ruanganpelakhir_id,
                                     sum(totalsisatagihan) as totalsisatagihan,
                                     sum(totalpembebasan) as totalpembebasan,
                                     sum(totaldiscount) as totaldiscount,
                                     sum(totalbayartindakan) as totalbayartindakan,
                                     sum(totaliurbiaya) as totaliurbiaya,
                                     sum(totalsubsidirs) as totalsubsidirs,
                                     sum(totalsubsidipemerintah) as totalsubsidipemerintah,
                                     sum(totalsubsidiasuransi) as totalsubsidiasuransi,
                                     sum(totalbiayapelayanan) as totalbiayapelayanan,
                                     sum(totalbiayatindakan) as totlabiayatindakan,
                                     sum(totalbiayaoa) as totalbiayaoa';
                $criteria->group = 'pendaftaran_id,pasien_id,nama_pasien,no_rekam_medik,carapembayaran,nama_pemakai,penjamin_nama,tglpembayaran,ruanganakhir_nama, namadepan,ruanganpelakhir_id';
                if (!empty($this->carabayar_id)){
                    $criteria->addCondition(" carabayar_id = '".$this->carabayar_id."' ");
                }else{
                    if (!empty($this->penjamin_id)){
                        $criteria->addCondition(" penjamin_id = '".$this->penjamin_id."' ");
                    }
                }
                
                if(!empty($this->ruangan_id)){                    
                    $criteria->addInCondition('ruanganpelakhir_id', $this->ruangan_id);
                }else{
                   if (!empty($this->instalasi_id)){
                       $ruangan = RuanganM::model()->findAll("instalasi_id = '".$this->instalasi_id."' AND ruangan_aktif = TRUE ");
                        $r = array();
                        foreach($ruangan as $ruang){
                            $r[] = $ruang->ruangan_id; 
                        }
                        
                        $criteria->addInCondition('ruangan_id', $r);
                   }
                }
                
                $criteria->addBetweenCondition('tglpembayaran',$this->tgl_awal.' 00:00:00',$this->tgl_akhir.' 23:59:59');
                $criteria->order = 'tglpembayaran ASC';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        public function searchPrint()
	{
		$criteria=new CDbCriteria;

		$criteria->select = 'pendaftaran_id,pasien_id,nama_pasien,no_rekam_medik,carapembayaran,nama_pemakai,penjamin_nama,tglpembayaran,ruanganakhir_nama, namadepan,ruanganpelakhir_id,
                                     sum(totalsisatagihan) as totalsisatagihan,
                                     sum(totalpembebasan) as totalpembebasan,
                                     sum(totaldiscount) as totaldiscount,
                                     sum(totalbayartindakan) as totalbayartindakan,
                                     sum(totaliurbiaya) as totaliurbiaya,
                                     sum(totalsubsidirs) as totalsubsidirs,
                                     sum(totalsubsidipemerintah) as totalsubsidipemerintah,
                                     sum(totalsubsidiasuransi) as totalsubsidiasuransi,
                                     sum(totalbiayapelayanan) as totalbiayapelayanan,
                                     sum(totalbiayatindakan) as totlabiayatindakan,
                                     sum(totalbiayaoa) as totalbiayaoa';
                $criteria->group = 'pendaftaran_id,pasien_id,nama_pasien,no_rekam_medik,carapembayaran,nama_pemakai,penjamin_nama,tglpembayaran,ruanganakhir_nama, namadepan,ruanganpelakhir_id';
                if (!empty($this->carabayar_id)){
                    $criteria->addCondition(" carabayar_id = '".$this->carabayar_id."' ");
                }else{
                    if (!empty($this->penjamin_id)){
                        $criteria->addCondition(" penjamin_id = '".$this->penjamin_id."' ");
                    }
                }
                
                if(!empty($this->ruangan_id)){                    
                    $criteria->addInCondition('ruanganpelakhir_id', $this->ruangan_id);
                }else{
                   if (!empty($this->instalasi_id)){
                       $ruangan = RuanganM::model()->findAll("instalasi_id = '".$this->instalasi_id."' AND ruangan_aktif = TRUE ");
                        $r = array();
                        foreach($ruangan as $ruang){
                            $r[] = $ruang->ruangan_id; 
                        }
                        
                        $criteria->addInCondition('ruangan_id', $r);
                   }
                }
                
                $criteria->addBetweenCondition('tglpembayaran',$this->tgl_awal,$this->tgl_akhir);
                $criteria->order = 'tglpembayaran ASC';
                $criteria->limit = -1;

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'pagination'=>false,
		));
	}                
        
        public function searchGrafik()
	{
		$criteria=new CDbCriteria;

		$criteria->select = 'sum(totalbayartindakan) as jumlah, ruanganakhir_nama as data';
                $criteria->addBetweenCondition('tglpembayaran',$this->tgl_awal,$this->tgl_akhir);
                if(!empty($this->ruangan_id)){                    
                    $criteria->addInCondition('ruanganpelakhir_id', $this->ruangan_id);
                }else{
                   if (!empty($this->instalasi_id)){
                       $ruangan = RuanganM::model()->findAll("instalasi_id = '".$this->instalasi_id."' AND ruangan_aktif = TRUE ");
                        $r = array();
                        foreach($ruangan as $ruang){
                            $r[] = $ruang->ruangan_id; 
                        }
                        
                        $criteria->addInCondition('ruangan_id', $r);
                   }
                }                
                $criteria->group = 'ruanganakhir_nama';
                $criteria->order = 'jumlah DESC, ruanganakhir_nama ASC';
                  
                $criteria->limit = 10;

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'pagination'=>false,
		));
	} 
        
        public function searchGrafikPenjamin()
	{
		$criteria=new CDbCriteria;

		$criteria->select = 'sum(totalbayartindakan) as jumlah, penjamin_nama as data';
                $criteria->addBetweenCondition('tglpembayaran',$this->tgl_awal,$this->tgl_akhir);
                if (!empty($this->carabayar_id)){
                    $criteria->addCondition(" carabayar_id = '".$this->carabayar_id."' ");
                }else{
                    if (!empty($this->penjamin_id)){
                        $criteria->addCondition(" penjamin_id = '".$this->penjamin_id."' ");
                    }
                }
                $criteria->group = 'penjamin_nama';
                $criteria->order = 'jumlah DESC, penjamin_nama ASC';
                  
                $criteria->limit = 10;

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'pagination'=>false,
		));
	} 
        
        public function getNamaModel()
        {
            return __CLASS__;
        }
        
        public function getCaraBayarItems()
        {
            return CarabayarM::model()->findAll("carabayar_aktif = TRUE ORDER BY carabayar_nama ASC");
        }

}
?>