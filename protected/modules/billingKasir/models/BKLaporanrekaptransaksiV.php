<?php
class BKLaporanrekaptransaksiV extends LaporanrekaptransaksiV {

    public $tarif_tindakan, $total, $tarif_rsakomodasi, $tarif_karcis, $qty_tindakan, $komponentarif_id;
    public $instalasi;
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    
    public function searchTable()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		$this->tgl_awal = MyFormatter::formatDateTimeForDb($this->tgl_awal);
		$this->tgl_akhir = MyFormatter::formatDateTimeForDb($this->tgl_akhir);
		
		if($this->daftartindakan_karcis == true){
			$criteria->select = 'instalasipendaftaran_id,pendaftaran_id, pasien_id, nama_pasien, namaperusahaan,
								no_pendaftaran, no_rekam_medik,tgl_pendaftaran,
								sum(tarif_tindakan) As tarif_tindakan,
								sum(tarif_tindakan) As tarif_karcis,
								sum(tarif_rsakomodasi) As tarif_rsakomodasi
								';
			$criteria->group = 'instalasipendaftaran_id,pendaftaran_id, pasien_id, nama_pasien, namaperusahaan,
								no_pendaftaran, no_rekam_medik,tgl_pendaftaran';
		}
		$criteria->select = 'instalasipendaftaran_id,pendaftaran_id, pasien_id, nama_pasien, namaperusahaan,
							no_pendaftaran, no_rekam_medik,tgl_pendaftaran,
							sum(tarif_tindakan) As tarif_tindakan,
							sum(tarif_tindakan) As total,
							sum(tarif_rsakomodasi) As tarif_rsakomodasi
							';
		$criteria->group = 'instalasipendaftaran_id,pendaftaran_id, pasien_id, nama_pasien, namaperusahaan,
							no_pendaftaran, no_rekam_medik,tgl_pendaftaran';
		if($this->instalasi == "rawat_jalan"){
			$criteria->addCondition('instalasipendaftaran_id = '.Params::INSTALASI_ID_RJ);
		}else if($this->instalasi == "rawat_inap"){
			$criteria->addCondition('instalasipendaftaran_id = '.Params::INSTALASI_ID_RI);
		}else if($this->instalasi == "ugd"){
			$criteria->addCondition('instalasipendaftaran_id = '.Params::INSTALASI_ID_RD);
		}
		$criteria->addBetweenCondition('tgl_pendaftaran',$this->tgl_awal,$this->tgl_akhir);
		

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	/*Optimasi print dan pencarian*/
	public function searchPrintOpt()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		$this->tgl_awal = MyFormatter::formatDateTimeForDb($this->tgl_awal);
		$this->tgl_akhir = MyFormatter::formatDateTimeForDb($this->tgl_akhir);
		
		if($this->daftartindakan_karcis == true){
			$criteria->select = 'instalasipendaftaran_id,pendaftaran_id, pasien_id, nama_pasien, namaperusahaan,
								no_pendaftaran, no_rekam_medik,tgl_pendaftaran,
								sum(tarif_tindakan) As tarif_tindakan,
								sum(tarif_tindakan) As tarif_karcis,
								sum(tarif_rsakomodasi) As tarif_rsakomodasi
								';
			$criteria->group = 'instalasipendaftaran_id,pendaftaran_id, pasien_id, nama_pasien, namaperusahaan,
								no_pendaftaran, no_rekam_medik,tgl_pendaftaran';
		}
		$criteria->select = 'instalasipendaftaran_id,pendaftaran_id, pasien_id, nama_pasien, namaperusahaan,
							no_pendaftaran, no_rekam_medik,tgl_pendaftaran,
							sum(tarif_tindakan) As tarif_tindakan,
							sum(tarif_tindakan) As total,
							sum(tarif_rsakomodasi) As tarif_rsakomodasi
							';
		$criteria->group = 'instalasipendaftaran_id,pendaftaran_id, pasien_id, nama_pasien, namaperusahaan,
							no_pendaftaran, no_rekam_medik,tgl_pendaftaran';
		if($this->instalasi == "rawat_jalan"){
			$criteria->addCondition('instalasipendaftaran_id = '.Params::INSTALASI_ID_RJ);
		}else if($this->instalasi == "rawat_inap"){
			$criteria->addCondition('instalasipendaftaran_id = '.Params::INSTALASI_ID_RI);
		}else if($this->instalasi == "ugd"){
			$criteria->addCondition('instalasipendaftaran_id = '.Params::INSTALASI_ID_RD);
		}
		$criteria->addBetweenCondition('tgl_pendaftaran',$this->tgl_awal,$this->tgl_akhir);
		

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>false,
		));
	}
	
	public function getTagihanOpt($pendaftaran_id,$tgl_pendaftaran=null,$kolom = null){
		$format = new MyFormatter();
		$criteria= new CDbCriteria;
		$criteria->group = 'pendaftaran_id, tgl_pendaftaran';
		$criteria->select = $criteria->group.', sum(tarif_tindakan) as  total';
		
		$this->pendaftaran_id = isset($pendaftaran_id) ? $pendaftaran_id : null;
		if(!empty($this->pendaftaran_id)){
			$criteria->addCondition('pendaftaran_id = '.$this->pendaftaran_id);
		}
		
		if(!empty($tgl_pendaftaran)){
			$criteria->addBetweenCondition('DATE(tgl_pendaftaran)',$tgl_pendaftaran,$tgl_pendaftaran);
		}
		switch($kolom):
			case "lainnya": $criteria->addCondition('daftartindakan_karcis = TRUE');
							break;
			case "farmasi": $criteria->addCondition('instalasi_id = '.Params::INSTALASI_ID_FARMASI);
							break;
			case "adm":
							break;
			case "ambulance":
							break;
			case "bedah":
							break;
			case "gizi":
							break;
			case "konsul": $criteria->addCondition('daftartindakan_konsul = TRUE');
							break;
			case "lab": $criteria->addCondition('instalasi_id = '.Params::INSTALASI_ID_LAB);
							break;
			case "laundry":
							break;
			case "obsgyn":
							break;
			case "pulasara":
							break;
			case "rad": $criteria->addCondition('instalasi_id = '.Params::INSTALASI_ID_RAD);
							break;
			case "ruangan": $criteria->addCondition('daftartindakan_akomodasi = TRUE');
							break;
			case "tindakan":
							break;
			case "visit": $criteria->addCondition('daftartindakan_visite = TRUE');
							break;
			case "total":
							break;
		endswitch;

		$modTotalTransaksi = BKLaporanrekaptransaksiV::model()->findAll($criteria);

		$jml = 0;
		foreach($modTotalTransaksi as $saldo){
			$jml += $saldo->total;
		}
		return $jml;
	}
	
//	public function getTotalTagihanOpt($pendaftaran_id,$tgl_pendaftaran=null,$kolom = null){
//		$total = 0;
//		$lainnya				= $this->getTagihanOpt($pendaftaran_id,$tgl_pendaftaran,"lainnya");
//		$farmasi				= $this->getTagihanOpt($pendaftaran_id,$tgl_pendaftaran,"farmasi");
//		$adm					= $this->getTagihanOpt($pendaftaran_id,$tgl_pendaftaran,"adm");
//		$ambulance				= $this->getTagihanOpt($pendaftaran_id,$tgl_pendaftaran,"ambulance");
//		$bedah					= $this->getTagihanOpt($pendaftaran_id,$tgl_pendaftaran,"bedah");
//		$gizi					= $this->getTagihanOpt($pendaftaran_id,$tgl_pendaftaran,"gizi");
//		$konsul					= $this->getTagihanOpt($pendaftaran_id,$tgl_pendaftaran,"konsul");
//		$lab					= $this->getTagihanOpt($pendaftaran_id,$tgl_pendaftaran,"lab");
//		$laundry				= $this->getTagihanOpt($pendaftaran_id,$tgl_pendaftaran,"laundry");
//		$obsgyn					= $this->getTagihanOpt($pendaftaran_id,$tgl_pendaftaran,"obsgyn");
//		$pulasara				= $this->getTagihanOpt($pendaftaran_id,$tgl_pendaftaran,"pulasara");
//		$rad					= $this->getTagihanOpt($pendaftaran_id,$tgl_pendaftaran,"rad");
//		$ruangan				= $this->getTagihanOpt($pendaftaran_id,$tgl_pendaftaran,"ruangan");
//		$tindakan				= $this->getTagihanOpt($pendaftaran_id,$tgl_pendaftaran,"tindakan");
//		$visit					= $this->getTagihanOpt($pendaftaran_id,$tgl_pendaftaran,"visit");		
////		$total = $lainnya+$farmasi+$adm+$ambulance+$bedah+$gizi+$konsul+$lab+$laundry+$obsgyn+$pulasara+$rad+$ruangan+$tindakan+$visit;
//		$total = $tindakan+$visit+$konsul+$farmasi+$lab+$rad+$bedah+$ruangan+$obsgyn+$gizi+$lainnya;
//		return $total;
//	}
	public function getTotalTagihanOpt($pendaftaran_id,$tgl_pendaftaran=null,$kolom = null){
		$total = 0;
		$format = new MyFormatter();
		$criteria= new CDbCriteria;
		$criteria->group = 'pendaftaran_id, tgl_pendaftaran';
		$criteria->select = $criteria->group.', sum(tarif_tindakan) as  total';
		
		$this->pendaftaran_id = isset($pendaftaran_id) ? $pendaftaran_id : null;
		if(!empty($this->pendaftaran_id)){
			$criteria->addCondition('pendaftaran_id = '.$this->pendaftaran_id);
		}
		
		if(!empty($tgl_pendaftaran)){
			$criteria->addBetweenCondition('DATE(tgl_pendaftaran)',$tgl_pendaftaran,$tgl_pendaftaran);
		}
		$criteria->addCondition('daftartindakan_karcis = TRUE OR instalasi_id = '.Params::INSTALASI_ID_FARMASI.'OR daftartindakan_konsul = TRUE '
				. 'OR instalasi_id = '.Params::INSTALASI_ID_LAB.'OR instalasi_id = '.Params::INSTALASI_ID_RAD.'OR daftartindakan_akomodasi = TRUE OR daftartindakan_visite = TRUE');
	//	$criteria->addCondition('instalasi_id = '.Params::INSTALASI_ID_FARMASI.'OR');
	//	$criteria->addCondition('daftartindakan_konsul = TRUE OR');
	//	$criteria->addCondition('instalasi_id = '.Params::INSTALASI_ID_LAB.'OR');
	//	$criteria->addCondition('instalasi_id = '.Params::INSTALASI_ID_RAD.'OR');
	//	$criteria->addCondition('daftartindakan_akomodasi = TRUE OR');
	//	$criteria->addCondition('daftartindakan_visite = TRUE');
		$modTotalTransaksi = BKLaporanrekaptransaksiV::model()->findAll($criteria);

		$jml = 0;
		foreach($modTotalTransaksi as $saldo){
			$jml += $saldo->total;
		}
		return $jml;
	}
/* End Of Optimization */
        
    public function searchPrint()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
                
		$criteria->select	= 'instalasipendaftaran_id,pendaftaran_id, pasien_id, nama_pasien, namaperusahaan,no_pendaftaran, no_rekam_medik,tgl_pendaftaran,
								sum(tarif_tindakan) As tarif_tindakan,
								sum(tarif_tindakan) As total,
								sum(tarif_rsakomodasi) As tarif_rsakomodasi
							';
		$criteria->group	= 'instalasipendaftaran_id,pendaftaran_id, pasien_id, nama_pasien, namaperusahaan,no_pendaftaran, no_rekam_medik,tgl_pendaftaran';

		$criteria->addBetweenCondition('tgl_pendaftaran',$this->tgl_awal,$this->tgl_akhir);
		if($this->instalasi == "rawat_jalan"){
			$criteria->addCondition('instalasipendaftaran_id = '.Params::INSTALASI_ID_RJ);
		}else if($this->instalasi == "rawat_inap"){
			$criteria->addCondition('instalasipendaftaran_id = '.Params::INSTALASI_ID_RI);
		}else if($this->instalasi == "ugd"){
			$criteria->addCondition('instalasipendaftaran_id = '.Params::INSTALASI_ID_RD);
		}
				
		if(!empty($this->profilrs_id)){
			$criteria->addCondition('profilrs_id = '.$this->profilrs_id);
		}
		if(!empty($this->pasien_id)){
			$criteria->addCondition('pasien_id = '.$this->pasien_id);
		}
		$criteria->compare('LOWER(no_rekam_medik)',strtolower($this->no_rekam_medik),true);
		$criteria->compare('LOWER(tgl_rekam_medik)',strtolower($this->tgl_rekam_medik),true);
		$criteria->compare('LOWER(jenisidentitas)',strtolower($this->jenisidentitas),true);
		$criteria->compare('LOWER(no_identitas_pasien)',strtolower($this->no_identitas_pasien),true);
		$criteria->compare('LOWER(namadepan)',strtolower($this->namadepan),true);
		$criteria->compare('LOWER(nama_pasien)',strtolower($this->nama_pasien),true);
		$criteria->compare('LOWER(nama_bin)',strtolower($this->nama_bin),true);
		$criteria->compare('LOWER(jeniskelamin)',strtolower($this->jeniskelamin),true);
		$criteria->compare('LOWER(tempat_lahir)',strtolower($this->tempat_lahir),true);
		$criteria->compare('LOWER(tanggal_lahir)',strtolower($this->tanggal_lahir),true);
		$criteria->compare('LOWER(alamat_pasien)',strtolower($this->alamat_pasien),true);
		$criteria->compare('rt',$this->rt);
		$criteria->compare('rw',$this->rw);
		$criteria->compare('LOWER(statusperkawinan)',strtolower($this->statusperkawinan),true);
		$criteria->compare('LOWER(agama)',strtolower($this->agama),true);
		$criteria->compare('LOWER(golongandarah)',strtolower($this->golongandarah),true);
		$criteria->compare('LOWER(rhesus)',strtolower($this->rhesus),true);
		$criteria->compare('anakke',$this->anakke);
		$criteria->compare('jumlah_bersaudara',$this->jumlah_bersaudara);
		$criteria->compare('LOWER(no_telepon_pasien)',strtolower($this->no_telepon_pasien),true);
		$criteria->compare('LOWER(no_mobile_pasien)',strtolower($this->no_mobile_pasien),true);
		$criteria->compare('LOWER(warga_negara)',strtolower($this->warga_negara),true);
		$criteria->compare('LOWER(photopasien)',strtolower($this->photopasien),true);
		$criteria->compare('LOWER(alamatemail)',strtolower($this->alamatemail),true);
		if(!empty($this->pendaftaran_id)){
			$criteria->addCondition('pendaftaran_id = '.$this->pendaftaran_id);
		}
		$criteria->compare('LOWER(no_pendaftaran)',strtolower($this->no_pendaftaran),true);
		$criteria->compare('LOWER(umur)',strtolower($this->umur),true);
		$criteria->compare('LOWER(no_asuransi)',strtolower($this->no_asuransi),true);
		$criteria->compare('LOWER(namapemilik_asuransi)',strtolower($this->namapemilik_asuransi),true);
		$criteria->compare('LOWER(nopokokperusahaan)',strtolower($this->nopokokperusahaan),true);
		$criteria->compare('LOWER(namaperusahaan)',strtolower($this->namaperusahaan),true);
		$criteria->compare('LOWER(tglselesaiperiksa)',strtolower($this->tglselesaiperiksa),true);
		if(!empty($this->tindakanpelayanan_id)){
			$criteria->addCondition('tindakanpelayanan_id = '.$this->tindakanpelayanan_id);
		}
		if(!empty($this->penjamin_id)){
			$criteria->addCondition('penjamin_id = '.$this->penjamin_id);
		}
		$criteria->compare('LOWER(penjamin_nama)',strtolower($this->penjamin_nama),true);
		if(!empty($this->carabayar_id)){
			$criteria->addCondition('carabayar_id = '.$this->carabayar_id);
		}
		$criteria->compare('LOWER(carabayar_nama)',strtolower($this->carabayar_nama),true);
		if(!empty($this->kelaspelayanan_id)){
			$criteria->addCondition('kelaspelayanan_id = '.$this->kelaspelayanan_id);
		}
		$criteria->compare('LOWER(kelaspelayanan_nama)',strtolower($this->kelaspelayanan_nama),true);
		if(!empty($this->instalasi_id)){
			$criteria->addCondition('instalasi_id = '.$this->instalasi_id);
		}
		$criteria->compare('LOWER(instalasi_nama)',strtolower($this->instalasi_nama),true);
		if(!empty($this->ruangan_id)){
			$criteria->addCondition('ruangan_id = '.$this->ruangan_id);
		}
		$criteria->compare('LOWER(ruangan_nama)',strtolower($this->ruangan_nama),true);
		$criteria->compare('LOWER(tgl_tindakan)',strtolower($this->tgl_tindakan),true);
		if(!empty($this->daftartindakan_id)){
			$criteria->addCondition('daftartindakan_id = '.$this->daftartindakan_id);
		}
		$criteria->compare('LOWER(daftartindakan_kode)',strtolower($this->daftartindakan_kode),true);
		$criteria->compare('LOWER(daftartindakan_nama)',strtolower($this->daftartindakan_nama),true);
		if(!empty($this->tipepaket_id)){
			$criteria->addCondition('tipepaket_id = '.$this->tipepaket_id);
		}
		$criteria->compare('LOWER(tipepaket_nama)',strtolower($this->tipepaket_nama),true);
		$criteria->compare('daftartindakan_karcis',$this->daftartindakan_karcis);
		$criteria->compare('daftartindakan_visite',$this->daftartindakan_visite);
		$criteria->compare('daftartindakan_konsul',$this->daftartindakan_konsul);
		$criteria->compare('tarif_rsakomodasi',$this->tarif_rsakomodasi);
		$criteria->compare('tarif_medis',$this->tarif_medis);
		$criteria->compare('tarif_paramedis',$this->tarif_paramedis);
		$criteria->compare('tarif_bhp',$this->tarif_bhp);
		$criteria->compare('tarif_satuan',$this->tarif_satuan);
		$criteria->compare('tarif_tindakan',$this->tarif_tindakan);
		$criteria->compare('LOWER(satuantindakan)',strtolower($this->satuantindakan),true);
		$criteria->compare('qty_tindakan',$this->qty_tindakan);
		$criteria->compare('cyto_tindakan',$this->cyto_tindakan);
		$criteria->compare('tarifcyto_tindakan',$this->tarifcyto_tindakan);
		$criteria->compare('discount_tindakan',$this->discount_tindakan);
		$criteria->compare('pembebasan_tindakan',$this->pembebasan_tindakan);
		$criteria->compare('subsidiasuransi_tindakan',$this->subsidiasuransi_tindakan);
		$criteria->compare('subsidipemerintah_tindakan',$this->subsidipemerintah_tindakan);
		$criteria->compare('subsisidirumahsakit_tindakan',$this->subsisidirumahsakit_tindakan);
		$criteria->compare('iurbiaya_tindakan',$this->iurbiaya_tindakan);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
		$criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);
		if(!empty($this->jeniskasuspenyakit_id)){
			$criteria->addCondition('jeniskasuspenyakit_id = '.$this->jeniskasuspenyakit_id);
		}
		$criteria->compare('LOWER(jeniskasuspenyakit_nama)',strtolower($this->jeniskasuspenyakit_nama),true);
		if(!empty($this->pembayaranpelayanan_id)){
			$criteria->addCondition('pembayaranpelayanan_id = '.$this->pembayaranpelayanan_id);
		}
		if(!empty($this->kategoritindakan_id)){
			$criteria->addCondition('kategoritindakan_id = '.$this->kategoritindakan_id);
		}
		$criteria->compare('LOWER(kategoritindakan_nama)',strtolower($this->kategoritindakan_nama),true);
		if(!empty($this->pegawai_id)){
			$criteria->addCondition('pegawai_id = '.$this->pegawai_id);
		}
		$criteria->compare('LOWER(gelardepan)',strtolower($this->gelardepan),true);
		$criteria->compare('LOWER(nama_pegawai)',strtolower($this->nama_pegawai),true);
		if(!empty($this->gelarbelakang_id)){
			$criteria->addCondition('gelarbelakang_id = '.$this->gelarbelakang_id);
		}
		$criteria->compare('LOWER(gelarbelakang_nama)',strtolower($this->gelarbelakang_nama),true);
		if(!empty($this->ruanganpendaftaran_id)){
			$criteria->addCondition('ruanganpendaftaran_id = '.$this->ruanganpendaftaran_id);
		}
		if(!empty($this->tindakansudahbayar_id)){
			$criteria->addCondition('tindakansudahbayar_id = '.$this->tindakansudahbayar_id);
		}
		$criteria->order='tgl_pendaftaran DESC';
                $criteria->limit = -1;

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'pagination'=>false,
		));
	}
        
	public function searchTableUgd()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
                
		$criteria->select	= 'pendaftaran_id, pasien_id, nama_pasien, namaperusahaan,no_pendaftaran, no_rekam_medik,tgl_pendaftaran,ruangan_nama,ruangan_id,
								sum(tarif_tindakan) As tarif_tindakan,
								sum(tarif_tindakan) As total,
								sum(tarif_rsakomodasi) As tarif_rsakomodasi
							';
		$criteria->group	= 'pendaftaran_id, pasien_id, nama_pasien, namaperusahaan,no_pendaftaran, no_rekam_medik,tgl_pendaftaran,ruangan_nama,ruangan_id';

		$criteria->addBetweenCondition('tgl_pendaftaran',$this->tgl_awal,$this->tgl_akhir);
		$criteria->addCondition('instalasi_id = '.Params::INSTALASI_ID_RD);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	public function searchTableRj()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
                
		$criteria->select	= 'pendaftaran_id, pasien_id, nama_pasien, namaperusahaan,no_pendaftaran, no_rekam_medik,tgl_pendaftaran,ruangan_nama,ruangan_id,
								sum(tarif_tindakan) As tarif_tindakan,
								sum(tarif_tindakan) As total,
								sum(tarif_rsakomodasi) As tarif_rsakomodasi
							';
		$criteria->group	= 'pendaftaran_id, pasien_id, nama_pasien, namaperusahaan,no_pendaftaran, no_rekam_medik,tgl_pendaftaran,ruangan_nama,ruangan_id';

		$criteria->addBetweenCondition('tgl_pendaftaran',$this->tgl_awal,$this->tgl_akhir);
		$criteria->addCondition('instalasi_id = '.Params::INSTALASI_ID_RJ);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	public function searchTableRi()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
                
		$criteria->select = 'pendaftaran_id, pasien_id, nama_pasien, namaperusahaan,no_pendaftaran, no_rekam_medik,tgl_pendaftaran,ruangan_nama,ruangan_id,
								sum(tarif_tindakan) As tarif_tindakan,
								sum(tarif_tindakan) As total,
								sum(tarif_rsakomodasi) As tarif_rsakomodasi
							';
		$criteria->group = 'pendaftaran_id, pasien_id, nama_pasien, namaperusahaan,no_pendaftaran, no_rekam_medik,tgl_pendaftaran,ruangan_nama,ruangan_id';

		$criteria->addBetweenCondition('tgl_pendaftaran',$this->tgl_awal,$this->tgl_akhir);
		$criteria->addCondition('instalasi_id = '.Params::INSTALASI_ID_RI);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
	// -- REKAP JASA DOKTER -- //
        
	public function searchJasaDokter()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
                
		$criteria->select = 't.gelardepan,t.nama_pegawai,t.gelarbelakang_nama,t.pegawai_id,
								sum(t.tarif_tindakan) As tarif_tindakan,
								sum(t.tarif_tindakan) As total,
								sum(t.tarif_rsakomodasi) As tarif_rsakomodasi,
								sum(t.qty_tindakan) As qty_tindakan
							';
		$criteria->group = 't.gelardepan,t.nama_pegawai,t.gelarbelakang_nama,t.pegawai_id';
		$criteria->join	 = 'LEFT JOIN tindakanpelayanan_t ON t.tindakanpelayanan_id = tindakanpelayanan_t.tindakanpelayanan_id LEFT JOIN tindakankomponen_t ON tindakankomponen_t.tindakanpelayanan_id = t.tindakanpelayanan_id';

		$criteria->addBetweenCondition('t.tgl_pendaftaran',$this->tgl_awal,$this->tgl_akhir);
		if(!empty($this->pegawai_id)){
			$criteria->addCondition('t.pegawai_id = '.$this->pegawai_id);
		}

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	public function searchDetailJasaDokter()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
                
		$criteria->select = 'pendaftaran_id, pasien_id, nama_pasien, namaperusahaan,no_pendaftaran, no_rekam_medik,tgl_pendaftaran,ruangan_nama,
							ruangan_id,gelardepan,nama_pegawai,gelarbelakang_nama,instalasi_nama,instalasi_id,
							sum(tarif_tindakan) As tarif_tindakan,
							sum(tarif_tindakan) As total,
							sum(tarif_rsakomodasi) As tarif_rsakomodasi,
							sum(qty_tindakan) As qty_tindakan
							';
		$criteria->group = 'pendaftaran_id, pasien_id, nama_pasien, namaperusahaan,no_pendaftaran, 
							no_rekam_medik,tgl_pendaftaran,ruangan_nama,ruangan_id,gelardepan,nama_pegawai,gelarbelakang_nama,instalasi_nama,instalasi_id';

		$criteria->addBetweenCondition('tgl_pendaftaran',$this->tgl_awal,$this->tgl_akhir);
		if(!empty($this->pegawai_id)){
			$criteria->addCondition('pegawai_id = '.$this->pegawai_id);
		}
		if(!empty($this->ruangan_id)){
			$criteria->addCondition('ruangan_id = '.$this->ruangan_id);
		}
		if(!empty($this->ruangan_id)){
			$criteria->addCondition('instalasi_id = '.$this->ruangan_id);
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
                
		$criteria->select = 't.gelardepan,t.nama_pegawai,t.gelarbelakang_nama,t.pegawai_id,
							sum(t.tarif_tindakan) As tarif_tindakan,
							sum(t.tarif_tindakan) As total,
							sum(t.tarif_rsakomodasi) As tarif_rsakomodasi,
							sum(t.qty_tindakan) As qty_tindakan
							';
		$criteria->group = 't.gelardepan,t.nama_pegawai,t.gelarbelakang_nama,t.pegawai_id';
		$criteria->join = 'LEFT JOIN tindakanpelayanan_t ON t.tindakanpelayanan_id = tindakanpelayanan_t.tindakanpelayanan_id LEFT JOIN tindakankomponen_t ON tindakankomponen_t.tindakanpelayanan_id = t.tindakanpelayanan_id';

		$criteria->addBetweenCondition('t.tgl_pendaftaran',$this->tgl_awal,$this->tgl_akhir);
		if(!empty($this->pegawai_id)){
			$criteria->addCondition('t.pegawai_id = '.$this->pegawai_id);
		}
		$criteria->limit = -1;

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'pagination'=>false,
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
							sum(tarif_rsakomodasi) As tarif_rsakomodasi,
							sum(qty_tindakan) As qty_tindakan
							';
		$criteria->group = 'pendaftaran_id, pasien_id, nama_pasien, namaperusahaan,no_pendaftaran, 
							no_rekam_medik,tgl_pendaftaran,ruangan_nama,ruangan_id,gelardepan,nama_pegawai,gelarbelakang_nama,instalasi_nama,instalasi_id';

		$criteria->addBetweenCondition('tgl_pendaftaran',$this->tgl_awal,$this->tgl_akhir);
		if(!empty($this->pegawai_id)){
			$criteria->addCondition('pegawai_id = '.$this->pegawai_id);
		}
		if(!empty($this->ruangan_id)){
			$criteria->addCondition('ruangan_id = '.$this->ruangan_id);
		}
		if(!empty($this->instalasi_id)){
			$criteria->addCondition('instalasi_id = '.$this->instalasi_id);
		}
		$criteria->limit = -1;

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'pagination'=>false,
		));
	}
	// -- END REKAP JASA DOKTER -- //
	public function getTagihan($pendaftaran_id,$tgl_pendaftaran=null,$kolom = null){
		$format = new MyFormatter();
		$criteria= new CDbCriteria;
		$criteria->group = 'pendaftaran_id, tgl_pendaftaran';
		$criteria->select = $criteria->group.', sum(tarif_tindakan) as  total';
		
		$this->pendaftaran_id = isset($pendaftaran_id) ? $pendaftaran_id : null;
		if(!empty($this->pendaftaran_id)){
			$criteria->addCondition('pendaftaran_id = '.$this->pendaftaran_id);
		}
		
		if(!empty($tgl_pendaftaran)){
			$criteria->addBetweenCondition('DATE(tgl_pendaftaran)',$tgl_pendaftaran,$tgl_pendaftaran);
		}
		
		if ($kolom == 'lainnya'){
			$criteria->addCondition('daftartindakan_karcis = TRUE');
		} else if ($kolom == 'farmasi'){
			$criteria->addCondition('instalasi_id = '.Params::INSTALASI_ID_FARMASI);
		} else if ($kolom == 'adm'){
			
		} else if ($kolom == 'ambulance'){

		} else if ($kolom == 'bedah'){

		} else if ($kolom == 'gizi'){
			
		} else if ($kolom == 'konsul'){
			$criteria->addCondition('daftartindakan_konsul = TRUE');
		} else if ($kolom == 'lab'){
			$criteria->addCondition('instalasi_id = '.Params::INSTALASI_ID_LAB);
		} else if ($kolom == 'laundry'){
			
		} else if ($kolom == 'obsgyn'){
			
		} else if ($kolom == 'pulasara'){
			
		} else if ($kolom == 'rad'){
			$criteria->addCondition('instalasi_id = '.Params::INSTALASI_ID_RAD);
		} else if ($kolom == 'ruangan'){
			$criteria->addCondition('daftartindakan_akomodasi = TRUE');
		} else if ($kolom == 'tindakan'){
			
		} else if ($kolom == 'visit'){
			$criteria->addCondition('daftartindakan_visite = TRUE');
		} else if ($kolom == 'total'){
			
		}

		$modTotalTransaksi = BKLaporanrekaptransaksiV::model()->findAll($criteria);

		$jml = 0;
		foreach($modTotalTransaksi as $saldo){
			$jml += $saldo->total;
		}
		return $jml;
	}
	
	public function getTotalTagihan($pendaftaran_id,$tgl_pendaftaran=null,$kolom = null){
		$total = 0;
		$lainnya				= $this->getTagihan($pendaftaran_id,$tgl_pendaftaran,"lainnya");
		$farmasi				= $this->getTagihan($pendaftaran_id,$tgl_pendaftaran,"farmasi");
		$adm					= $this->getTagihan($pendaftaran_id,$tgl_pendaftaran,"adm");
		$ambulance				= $this->getTagihan($pendaftaran_id,$tgl_pendaftaran,"ambulance");
		$bedah					= $this->getTagihan($pendaftaran_id,$tgl_pendaftaran,"bedah");
		$gizi					= $this->getTagihan($pendaftaran_id,$tgl_pendaftaran,"gizi");
		$konsul					= $this->getTagihan($pendaftaran_id,$tgl_pendaftaran,"konsul");
		$lab					= $this->getTagihan($pendaftaran_id,$tgl_pendaftaran,"lab");
		$laundry				= $this->getTagihan($pendaftaran_id,$tgl_pendaftaran,"laundry");
		$obsgyn					= $this->getTagihan($pendaftaran_id,$tgl_pendaftaran,"obsgyn");
		$pulasara				= $this->getTagihan($pendaftaran_id,$tgl_pendaftaran,"pulasara");
		$rad					= $this->getTagihan($pendaftaran_id,$tgl_pendaftaran,"rad");
		$ruangan				= $this->getTagihan($pendaftaran_id,$tgl_pendaftaran,"ruangan");
		$tindakan				= $this->getTagihan($pendaftaran_id,$tgl_pendaftaran,"tindakan");
		$visit					= $this->getTagihan($pendaftaran_id,$tgl_pendaftaran,"visit");		
//		$total = $lainnya+$farmasi+$adm+$ambulance+$bedah+$gizi+$konsul+$lab+$laundry+$obsgyn+$pulasara+$rad+$ruangan+$tindakan+$visit;
		$total = $tindakan+$visit+$konsul+$farmasi+$lab+$rad+$bedah+$ruangan+$obsgyn+$gizi+$lainnya;
		return $total;
	}
	
	public function getDokterItems()
	{
		return DokterV::model()->findAll();
	}
        
}
?>
