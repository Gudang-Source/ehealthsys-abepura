<?php
class BSLaporantindakankomponenV extends LaporantindakankomponenV
{
        public $tgl_awal,$tgl_akhir;
        public $jns_periode,$bln_awal,$bln_akhir,$thn_awal,$thn_akhir;
		public $data, $jumlah;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        // -- REKAP JASA DOKTER -- //
        
        public function searchJasaDokter()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
                
		$criteria->group = 't.nama_pasien,t.ruangan_id,t.ruangan_nama,t.no_rekam_medik,t.no_pendaftaran,t.tgl_pendaftaran,t.tgl_keluar,t.kelaspelayanan_nama,t.nama_pegawai,t.daftartindakan_nama,t.tarif_tindakankomp';
		$criteria->select = $criteria->group;
		$criteria->addBetweenCondition('date(t.tgl_pendaftaran)',$this->tgl_awal,$this->tgl_akhir,true);
		//$criteria->compare("t.komponentarif_id", Params::KOMPONENTARIF_ID_JASA_MEDIS);   
		$criteria->compare("p.kelompokkomponentarif_id", 1);
		$criteria->join = "join persenkelkomponentarif_m p on p.komponentarif_id = t.komponentarif_id";
		
                if(!empty($this->pegawai_id)){
			$criteria->addCondition('t.pegawai_id = '.$this->pegawai_id);
		}
                if (!empty($this->ruangan_id)){
                    $criteria->addCondition('t.ruangan_id = '.$this->ruangan_id);
                }

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        public function searchPrintJasaDokter()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
                
		$criteria->group = 't.nama_pasien,t.ruangan_id,t.ruangan_nama,t.no_rekam_medik,t.no_pendaftaran,t.tgl_pendaftaran,t.tgl_keluar,t.kelaspelayanan_nama,t.nama_pegawai,t.daftartindakan_nama,t.tarif_tindakankomp';
		$criteria->select = $criteria->group;
		$criteria->addBetweenCondition('date(t.tgl_pendaftaran)',$this->tgl_awal,$this->tgl_akhir,true);
		if(!empty($this->pegawai_id)){
			$criteria->addCondition('t.pegawai_id = '.$this->pegawai_id);
		}
		// $criteria->compare("t.komponentarif_id", Params::KOMPONENTARIF_ID_JASA_MEDIS);
		
		$criteria->compare("p.kelompokkomponentarif_id", 1);
		$criteria->join = "join persenkelkomponentarif_m p on p.komponentarif_id = t.komponentarif_id";
		
		if (!empty($this->ruangan_id)){
			$criteria->addCondition('t.ruangan_id = '.$this->ruangan_id);
		}
		$criteria->limit = -1;

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'pagination'=>false,
		));
	}
        public function searchGrafik()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
                
		$criteria->group = 't.nama_pasien,t.ruangan_id,t.ruangan_nama,t.no_rekam_medik,t.no_pendaftaran,t.tgl_pendaftaran,t.tgl_keluar,t.kelaspelayanan_nama,t.nama_pegawai,t.daftartindakan_nama,t.tarif_tindakankomp';
		$criteria->select = $criteria->group;
		$criteria->addBetweenCondition('date(t.tgl_pendaftaran)',$this->tgl_awal,$this->tgl_akhir,true);
		
		$criteria->compare("p.kelompokkomponentarif_id", 1);
		$criteria->join = "join persenkelkomponentarif_m p on p.komponentarif_id = t.komponentarif_id";
		
		
		if (!empty($this->ruangan_id)){
			$criteria->addCondition('t.ruangan_id = '.$this->ruangan_id);
		}
		if(!empty($this->pegawai_id)){
			$criteria->addCondition('t.pegawai_id = '.$this->pegawai_id);
		}
		$criteria->limit = -1;

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'pagination'=>false,
		));
	}
        // -- END REKAP JASA DOKTER -- //
        
        // -- DETAIL JASA DOKTER -- //
        public function searchDetailJasaDokter()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
                
		$criteria->select = 'pendaftaran_id, pasien_id, nama_pasien, namaperusahaan,no_pendaftaran, no_rekam_medik,tgl_pendaftaran,ruangan_nama,
							ruangan_id,gelardepan,nama_pegawai,gelarbelakang_nama,instalasi_nama,instalasi_id,
							sum(tarif_tindakan) As tarif_tindakan,
							sum(tarif_tindakan) As total,
							sum(tarif_tindakankomp) As tarif_rsakomodasi,
							sum(qty_tindakan) As qty_tindakan
							';
		$criteria->group = 'pendaftaran_id, pasien_id, nama_pasien, namaperusahaan,no_pendaftaran, 
							no_rekam_medik,tgl_pendaftaran,ruangan_nama,ruangan_id,gelardepan,nama_pegawai,gelarbelakang_nama,instalasi_nama,instalasi_id';

		$criteria->addBetweenCondition('date(tgl_pendaftaran)',$this->tgl_awal,$this->tgl_akhir);
		if(!empty($this->pegawai_id)){
			$criteria->addCondition('pegawai_id = '.$this->pegawai_id);
		}
		if(!empty($this->ruangan_id)){
			$criteria->addCondition('ruangan_id = '.$this->ruangan_id);
		}
		

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        public function searchPrintDetailJasaDokter()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria = new CDbCriteria;
                
		$criteria->select = 'pendaftaran_id, pasien_id, nama_pasien, namaperusahaan,no_pendaftaran, no_rekam_medik,tgl_pendaftaran,ruangan_nama,
							ruangan_id,gelardepan,nama_pegawai,gelarbelakang_nama,instalasi_nama,instalasi_id,
							sum(tarif_tindakan) As tarif_tindakan,
							sum(tarif_tindakan) As total,
							sum(tarif_tindakankomp) As tarif_rsakomodasi,
							sum(qty_tindakan) As qty_tindakan
							';
		$criteria->group = 'pendaftaran_id, pasien_id, nama_pasien, namaperusahaan,no_pendaftaran, 
							no_rekam_medik,tgl_pendaftaran,ruangan_nama,ruangan_id,gelardepan,nama_pegawai,gelarbelakang_nama,instalasi_nama,instalasi_id';

		$criteria->addBetweenCondition('date(tgl_pendaftaran)',$this->tgl_awal,$this->tgl_akhir);
		if(!empty($this->pegawai_id)){
			$criteria->addCondition('pegawai_id = '.$this->pegawai_id);
		}
		if(!empty($this->ruangan_id)){
			$criteria->addCondition('ruangan_id = '.$this->ruangan_id);
		}		
		$criteria->limit = -1;

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'pagination'=>false,
		));
	}
        // -- END DETAIL JASA DOKTER -- //
        
        public function getDokterItems()
        {
            return DokterV::model()->findAll();
        }
}