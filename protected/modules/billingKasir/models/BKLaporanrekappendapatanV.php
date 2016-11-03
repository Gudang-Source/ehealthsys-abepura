<?php
class BKLaporanrekappendapatanV extends LaporanrekappendapatanV
{
	public $totaliurbiaya,$totalsubsidiasuransi;
	public $jns_periode,$tgl_awal,$tgl_akhir,$bln_awal,$bln_akhir,$thn_awal,$thn_akhir;
        public $instalasi_id, $jumlah, $tick, $data, $ruangan_id;
        
        
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        public function searchTable()
	{
		$criteria=new CDbCriteria;

		$criteria->select = 'pendaftaran_id,pasien_id,nama_pasien,no_rekam_medik,carapembayaran,nama_pemakai,penjamin_nama,tglpembayaran,
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
                $criteria->group = 'pendaftaran_id,pasien_id,nama_pasien,no_rekam_medik,carapembayaran,nama_pemakai,penjamin_nama,tglpembayaran';
                
                $criteria->addBetweenCondition('tglpembayaran',$this->tgl_awal.' 00:00:00',$this->tgl_akhir.' 23:59:59');                
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
                                
                if (!empty($this->carabayar_id)){
                    $criteria->addCondition(" carabayar_id = '".$this->carabayar_id."' ");
                }else{
                    if (!empty($this->penjamin_id)){
                        $criteria->addCondition(" penjamin_id = '".$this->penjamin_id."' ");
                    }
                }
                
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        public function searchPrint()
	{
		$criteria=new CDbCriteria;

		$criteria->select = 'pendaftaran_id,pasien_id,nama_pasien,no_rekam_medik,carapembayaran,nama_pemakai,penjamin_nama,tglpembayaran,
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
                $criteria->group = 'pendaftaran_id,pasien_id,nama_pasien,no_rekam_medik,carapembayaran,nama_pemakai,penjamin_nama,tglpembayaran';
                
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
                
                if (!empty($this->carabayar_id)){
                    $criteria->addCondition(" carabayar_id = '".$this->carabayar_id."' ");
                }else{
                    if (!empty($this->penjamin_id)){
                        $criteria->addCondition(" penjamin_id = '".$this->penjamin_id."' ");
                    }
                }
                $criteria->limit = -1;

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'pagination'=>false,
		));
	}
        
        public function searchPiutangPenjamin()
	{
		$criteria=new CDbCriteria;
		$this->tgl_awal = MyFormatter::formatDateTimeForDb($this->tgl_awal);
		$this->tgl_akhir = MyFormatter::formatDateTimeForDb($this->tgl_akhir);
		$criteria->select = 'pendaftaran_id,pasien_id,nama_pasien,no_rekam_medik,no_pendaftaran,carapembayaran,nama_pemakai,penjamin_nama,tglpembayaran,
                                     ruanganakhir_nama,tgl_pendaftaran,tglpulang,penjamin_id,carabayar_id,
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
                $criteria->group = 'pendaftaran_id,pasien_id,nama_pasien,no_rekam_medik,no_pendaftaran,
                                    carapembayaran,nama_pemakai,penjamin_nama,tglpembayaran,ruanganakhir_nama,
                                    tgl_pendaftaran,tglpulang,penjamin_id,carabayar_id';
                $criteria->addCondition('penjamin_id !=1');
                $criteria->addBetweenCondition('tglpembayaran',$this->tgl_awal,$this->tgl_akhir);
				
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        public function searchPrintPenjamin()
	{
		$criteria=new CDbCriteria;

		$criteria->select = 'pendaftaran_id,pasien_id,nama_pasien,no_rekam_medik,no_pendaftaran,carapembayaran,nama_pemakai,penjamin_nama,tglpembayaran,
                                     ruanganakhir_nama,tgl_pendaftaran,tglpulang,penjamin_id,carabayar_id,
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
                $criteria->group = 'pendaftaran_id,pasien_id,nama_pasien,no_rekam_medik,no_pendaftaran,
                                    carapembayaran,nama_pemakai,penjamin_nama,tglpembayaran,ruanganakhir_nama,
                                    tgl_pendaftaran,tglpulang,penjamin_id,carabayar_id';
                $criteria->addCondition('penjamin_id !=1');
                $criteria->addBetweenCondition('tglpembayaran',$this->tgl_awal,$this->tgl_akhir);
                $criteria->limit = -1;

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'pagination'=>false,
		));
	}
        
        public function searchPiutangUmum()
	{
		$criteria=new CDbCriteria;

		$criteria->select = 'pendaftaran_id,pasien_id,nama_pasien,no_rekam_medik,no_pendaftaran,carapembayaran,nama_pemakai,penjamin_nama,tglpembayaran,
                                     ruanganakhir_nama,tgl_pendaftaran,tglpulang,penjamin_id,carabayar_id,
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
                $criteria->group = 'pendaftaran_id,pasien_id,nama_pasien,no_rekam_medik,no_pendaftaran,
                                    carapembayaran,nama_pemakai,penjamin_nama,tglpembayaran,ruanganakhir_nama,
                                    tgl_pendaftaran,tglpulang,penjamin_id,carabayar_id';
                $criteria->addCondition('penjamin_id = 1');        
                $criteria->addBetweenCondition('tglpembayaran',$this->tgl_awal,$this->tgl_akhir);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        public function searchPrintUmum()
	{
		$criteria=new CDbCriteria;

		$criteria->select = 'pendaftaran_id,pasien_id,nama_pasien,no_rekam_medik,no_pendaftaran,carapembayaran,nama_pemakai,penjamin_nama,tglpembayaran,
                                     ruanganakhir_nama,tgl_pendaftaran,tglpulang,penjamin_id,carabayar_id,
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
                $criteria->group = 'pendaftaran_id,pasien_id,nama_pasien,no_rekam_medik,no_pendaftaran,
                                    carapembayaran,nama_pemakai,penjamin_nama,tglpembayaran,ruanganakhir_nama,
                                    tgl_pendaftaran,tglpulang,penjamin_id,carabayar_id';
                $criteria->addCondition('penjamin_id = 1');      
                $criteria->addBetweenCondition('tglpembayaran',$this->tgl_awal,$this->tgl_akhir);
                $criteria->limit = -1;

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'pagination'=>false,
		));
	}
        
        public function searchGrafik()
	{
		$criteria=new CDbCriteria;

		$criteria->select = 'sum(totalbayartindakan) as jumlah, penjamin_nama as data';
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