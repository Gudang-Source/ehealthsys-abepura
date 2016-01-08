<?php
class BKLaporanrekappendapatanV extends LaporanrekappendapatanV
{
	public $totaliurbiaya,$totalsubsidiasuransi;
	public $jns_periode,$tgl_awal,$tgl_akhir,$bln_awal,$bln_akhir,$thn_awal,$thn_akhir;
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
                
                $criteria->addBetweenCondition('tglpembayaran',$this->tgl_awal,$this->tgl_akhir);

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

}
?>