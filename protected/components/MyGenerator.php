<?php

/**
 * Class Generator untuk menyimpan function generator kode / nomor unik
 * modify by: @author Research Development | 03 Jun 2014 | RND-95 RND-94
 */
class MyGenerator 
{
    /**
     * Generate nomasukkamar untuk masukkamar_t
     * @return string 
     */
    public static function noMasukKamar($ruangan_id)
    {
		$default = '001';
        $ruangan = RuanganM::model()->findByPk($ruangan_id);
        $nama_ruangan = null;
        if ($ruangan)
            $nama_ruangan=strtoupper(trim($ruangan->ruangan_singkatan));
        $prefix = $nama_ruangan.date('ymd');
		$sql = "SELECT CAST(MAX(SUBSTR(nomasukkamar,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal 
				FROM masukkamar_t 
				WHERE nomasukkamar LIKE ('".$prefix."%')";
        // var_dump($sql);
        $masukKamar = Yii::app()->db->createCommand($sql)->queryRow();
        $no_masuk_kamar_baru = $prefix.(isset($masukKamar['nomaksimal']) ? (str_pad($masukKamar['nomaksimal']+1, (strlen($default)), 0,STR_PAD_LEFT)) : $default);
        // var_dump($no_masuk_kamar_baru);
        return $no_masuk_kamar_baru;
    }
    
    /**
     * Generate nomasukkamar untuk masukkamar_t
     * @return string 
     */
    public static function noPindahKamar($ruangan_id)
    {
		$default = '001';
        $ruangan = RuanganM::model()->findByPk($ruangan_id);
        $nama_ruangan = null;
        if ($ruangan)
            $nama_ruangan=strtoupper(trim($ruangan->ruangan_singkatan));
        $prefix = $nama_ruangan.date('ymd');
		$sql = "SELECT CAST(MAX(SUBSTR(nopindahkamar,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal 
				FROM pindahkamar_t 
				WHERE nopindahkamar LIKE ('".$prefix."%')";
        // var_dump($sql);
        $masukKamar = Yii::app()->db->createCommand($sql)->queryRow();
        $no_masuk_kamar_baru = $prefix.(isset($masukKamar['nomaksimal']) ? (str_pad($masukKamar['nomaksimal']+1, (strlen($default)), 0,STR_PAD_LEFT)) : $default);
        // var_dump($no_masuk_kamar_baru);
        return $no_masuk_kamar_baru;
    }
    
    /**
     * Generate noretur untuk returpembelian_t
     * @return string 
     */
    public static function noRetur()
    {
		$default="0001";
        $prefix = 'RETUR'.date('ymd');
		$sql = "SELECT CAST(MAX(SUBSTR(noretur,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal 
				FROM returpembelian_t 
				WHERE noretur LIKE ('".$prefix."%')";
        $returPembelian = Yii::app()->db->createCommand($sql)->queryRow();
        $no_retur_baru =$prefix.(isset($returPembelian['nomaksimal']) ? (str_pad($returPembelian['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $no_retur_baru;
    }
    
    /**
     * Generate noreturresep untuk returresep_t
     * @return string 
     */
    public static function noReturResep()
    {
		$default = "0001";
        $prefix = 'RETRESEP'.date('ymd');
		$sql = "SELECT CAST(MAX(SUBSTR(noreturresep,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal 
				FROM returresep_t 
				WHERE noreturresep LIKE ('".$prefix."%')";
        $returResep = Yii::app()->db->createCommand($sql)->queryRow();
        $no_retur_baru =$prefix.(isset($returResep['nomaksimal']) ? (str_pad($returResep['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $no_retur_baru;
    }
    
     /**
     * Generate nofaktur untuk fakturpembelian_t
     * @return string 
     */
    public static function noFaktur()
    {
		$dafault = "0001";
        $prefix = 'FAKTUR'.date('ymd');
		$sql = "SELECT CAST(MAX(SUBSTR(nofaktur,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal 
				FROM fakturpembelian_t 
				WHERE nofaktur LIKE ('".$prefix."%')";
        $fakturPembelian = Yii::app()->db->createCommand($sql)->queryRow();
        $no_faktur_baru = $prefix.(isset($fakturPembelian['nomaksimal']) ? (str_pad($fakturPembelian['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $no_faktur_baru;
    }
    
     /**
     * Generate noperencnaan untuk rencanakebfarmasi_t
     * @return string 
     */
    public static function noPerencanaan()
    {
		$default = "0001";
        $prefix = 'RENCANA'.date('ymd');
		$sql = "SELECT CAST(MAX(SUBSTR(noperencnaan,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal 
				FROM rencanakebfarmasi_t 
				WHERE noperencnaan LIKE ('".$prefix."%')";
        $rencKebFarmasi = Yii::app()->db->createCommand($sql)->queryRow();
        $no_perencanaan_baru =$prefix.(isset($rencKebFarmasi['nomaksimal']) ? (str_pad($rencKebFarmasi['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $no_perencanaan_baru;
    }
    
     /**
     * Generate noterima untuk penerimaanbarang_t
     * @return string 
     */
    public static function noTerimaBarang()
    {
		$default = "0001";
        $prefix = 'TERIMA'.date('ymd');
		$sql = "SELECT CAST(MAX(SUBSTR(noterima,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal 
				FROM penerimaanbarang_t 
				WHERE noterima LIKE ('".$prefix."%')";
        $penerimaanBarang = Yii::app()->db->createCommand($sql)->queryRow();
        $no_terimabarang_baru = $prefix.(isset($penerimaanBarang['nomaksimal']) ? (str_pad($penerimaanBarang['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $no_terimabarang_baru;
    }
    
    
     /**
     * Generate nosuratpenawaran untuk permintaanpenawaran_t
     * @return string 
     */
    public static function noPenawaran()
    {
		$default = "0001";
        $prefix = 'PENAWARAN'.date('ymd');
		$sql = "SELECT CAST(MAX(SUBSTR(nosuratpenawaran,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal 
				FROM permintaanpenawaran_t 
				WHERE nosuratpenawaran LIKE ('".$prefix."%')";
        $permintaanPenawaran = Yii::app()->db->createCommand($sql)->queryRow();
        $no_penawaran_baru =$prefix.(isset($permintaanPenawaran['nomaksimal']) ? (str_pad($permintaanPenawaran['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $no_penawaran_baru;
    }
    
     /**
     * Generate nopermintaan untuk permintaanpembelian_t
     * @return string 
     */
    public static function noPembelian()
    {
		$default = "0001";
        $prefix = 'PEMBELIAN'.date('ymd');
		$sql = "SELECT CAST(MAX(SUBSTR(nopermintaan,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal 
				FROM permintaanpembelian_t 
				WHERE nopermintaan LIKE ('".$prefix."%')";
        $permintaanPembelian = Yii::app()->db->createCommand($sql)->queryRow();
        $no_perencanaan_baru =$prefix.(isset($permintaanPembelian['nomaksimal']) ? (str_pad($permintaanPembelian['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $no_perencanaan_baru;
    }

     /**
     * Generate renkebbarang_no untuk renkebbarang_t
     * @return string 
     */
    public static function noPerencanaanKebutuhanBarang()
    {
		$default = "0001";
        $prefix = 'RENCANA'.date('ymd');
		$sql = "SELECT CAST(MAX(SUBSTR(renkebbarang_no,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal 
				FROM renkebbarang_t 
				WHERE renkebbarang_no LIKE ('".$prefix."%')";
        $rencKebFarmasi = Yii::app()->db->createCommand($sql)->queryRow();
        $no_perencanaan_baru =$prefix.(isset($rencKebFarmasi['nomaksimal']) ? (str_pad($rencKebFarmasi['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $no_perencanaan_baru;
    }	
	
    /**
     * Generate nosediaanpa untuk hasilpemeriksaanpa_t 
     * @return string 
     */
    public static function noSediaanPA()
    {
		$default = "001";
        $prefix = date('ymd');
		$sql = "SELECT CAST(MAX(SUBSTR(nosediaanpa,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal 
				FROM hasilpemeriksaanpa_t 
				WHERE nosediaanpa LIKE ('".$prefix."%')";
        $hasilPemeriksaanPA = Yii::app()->db->createCommand($sql)->queryRow();
        $no_sediaan_pa_baru = $prefix.(isset($hasilPemeriksaanPA['nomaksimal']) ? (str_pad($hasilPemeriksaanPA['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $no_sediaan_pa_baru;
    }
        
    /**
     * Generate nohasilperiksalab untuk hasilpemeriksaanlab_t
     * @return string 
     */
    public static function noHasilPemeriksaanLK()
    {
		$default = "001";
        $prefix = date('ymd');
		$sql = "SELECT CAST(MAX(SUBSTR(nohasilperiksalab,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal 
				FROM hasilpemeriksaanlab_t 
				WHERE nohasilperiksalab LIKE ('".$prefix."%')";
        $hasilPemeriksaanLab = Yii::app()->db->createCommand($sql)->queryRow();
        $no_hasilperiksalab_baru = $prefix.(isset($hasilPemeriksaanLab['nomaksimal']) ? (str_pad($hasilPemeriksaanLab['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $no_hasilperiksalab_baru;
    }
    
    /**
     * Generate noantrian untuk antrian_t berdasarkan loket_id
     * @return string 
     */
    public static function noAntrianLoket($loket_id = null, $format = "000")
    {
        $sql = "SELECT CAST(MAX(SUBSTR(noantrian,1,".strlen($format).")) AS integer) nomaksimal FROM antrian_t 
                WHERE DATE(tglantrian)='".date('Y-m-d')."'
                    ".(!empty($loket_id) ? " AND loket_id = ".$loket_id : "");
        $antrian = Yii::app()->db->createCommand($sql)->queryRow();
        if(!isset($antrian['nomaksimal'])){
            $antrian['nomaksimal'] = 0;
        }
		$noantrian_baru = (isset($antrian['nomaksimal']) ? (str_pad($antrian['nomaksimal']+1, strlen($format), 0,STR_PAD_LEFT)) : (str_pad($format+1, strlen($format), 0,STR_PAD_LEFT)));
        return $noantrian_baru;
    }
    
    /**
     * Generate noantrian untuk antrianfarmasi_t (farmasi)
     * @return string 
     */
    public static function noAntrianFarmasi($racikan_id = null)
    {
		$default = '0001';
        $tgl = date('Y-m-d');
        $sql = "SELECT CAST(MAX(SUBSTR(noantrian,1,".(strlen($default)).")) AS integer) nomaksimal FROM antrianfarmasi_t
                      WHERE date(tglambilantrian)='".$tgl."' AND racikan_id = $racikan_id ";
        $farmasi = Yii::app()->db->createCommand($sql)->queryRow();
        $no_farmasi_baru = (isset($farmasi['nomaksimal']) ? (str_pad($farmasi['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $no_farmasi_baru;
    }


    /**
     * Generate no_rekam_medik untuk pasien_m
     * @param type $prefix
     * @param type $is_pasienluar
     * @return type
     */
    public static function noRekamMedik($prefix='',$is_pasienluar='FALSE')
    {
        $default = null;
		$digit_rm = self::DigitRM();
		for($i=1;$i<=$digit_rm;$i++){
            if($i == $digit_rm)
                $default .= "1";
            else
                $default .= "0";
        }
		
		
        		
		$sql = "SELECT CAST(SUBSTR(no_rekam_medik,".(strlen($prefix)+1).",".(strlen($default)).") AS integer) nomaksimal 
					FROM pasien_m WHERE ispasienluar=$is_pasienluar AND no_rekam_medik like '".$prefix."%' 
					ORDER BY no_rekam_medik DESC 
					LIMIT 1";

        $pasien = Yii::app()->db->createCommand($sql)->queryRow();
        
        if(isset($pasien['nomaksimal'])){
			$nomaksimal = $pasien['nomaksimal']+1;
			$sql = "SELECT normlama_min, normlama_maks FROM konfigsystem_k LIMIT 1";
			$normlama = Yii::app()->db->createCommand($sql)->queryRow();
                        
                        // var_dump($nomaksimal);
                        
			if($nomaksimal == $normlama['normlama_min']){
                            $nomaksimal = ((int)$normlama['normlama_maks'])+1;
			} else if ($nomaksimal >= ((int)$normlama['normlama_min']) && $nomaksimal < ((int)$normlama['normlama_maks']+1)) {
                            $nomaksimal = ((int)$normlama['normlama_maks'])+1;
                        }
			$no_rm_baru = $prefix.str_pad($nomaksimal, $digit_rm, 0,STR_PAD_LEFT);
		}else{
			$no_rm_baru = $prefix.$default;
		}    
                // var_dump($no_rm_baru); die;
        return trim($no_rm_baru);
    }
    
    public static function DigitRM()
    {
        $sql="SELECT jmldigitrm FROM konfigsystem_k LIMIT 1";
        $Konfigjmldigitrm = Yii::app()->db->createCommand($sql)->queryRow();
        $digitrm = $Konfigjmldigitrm['jmldigitrm'];
        return $digitrm;
    }
    /**
     * Generate no_rekam_medik untuk pasien_m (Penunjang)
     * @param type $prefix
     * @return type
     */
    public static function noRekamMedikPenunjang($prefix)
    {
		return self::noRekamMedik($prefix,'TRUE');
    }
    
    /**
     * Generate no_rekam_medik untuk pasien_m (Janji Poli)
     * @param type $prefix
     * @return type
     */
    public static function noRekamMedikJanjiPoli($prefix = 'JP')
    {
        return self::noRekamMedik($prefix,'TRUE');
    }
    /**
     * Generate no_rekam_medik untuk pasien_m (Booking Kamar)
     * @param type $prefix
     * @return type
     */
    public static function noRekamMedikBookingKamar($prefix = 'BK')
    {
        return self::noRekamMedik($prefix,'TRUE');
    }
    /**
     * Generate no_pendaftaran untuk pendaftaran_t
     * @param type $instalasi_id
     * @param type $tgl_pendaftaran
     * @return string
     */
    public static function noPendaftaran($instalasi_id, $tgl_pendaftaran = null)
    {
        $default = '0001';
		$konfig = KonfigsystemK::model()->find();
		$tgl = date('ymd');
		if(!empty($tgl_pendaftaran)){
			$tgl = date('ymd', strtotime($tgl_pendaftaran));
		}
		$kode_instalasi = "";
		if($instalasi_id == Params::INSTALASI_ID_RJ){
			$kode_instalasi = $konfig->nopendaftaran_rj;
		}else if($instalasi_id == Params::INSTALASI_ID_RD){
			$kode_instalasi = $konfig->nopendaftaran_gd;
		}else if($instalasi_id == Params::INSTALASI_ID_RI){
			$kode_instalasi = $konfig->nopendaftaran_ri;
		}else if($instalasi_id == Params::INSTALASI_ID_LAB){
			$kode_instalasi = $konfig->nopendaftaran_lab;
		}else if($instalasi_id == Params::INSTALASI_ID_RAD){
			$kode_instalasi = $konfig->nopendaftaran_rad;
		}else if($instalasi_id == Params::INSTALASI_ID_IBS){
			$kode_instalasi = $konfig->nopendaftaran_ibs;
		}else if($instalasi_id == Params::INSTALASI_ID_REHAB){
			$kode_instalasi = $konfig->nopendaftaran_rehabmedis;
		}else if($instalasi_id == Params::INSTALASI_ID_JZ){
			$kode_instalasi = $konfig->nopendaftaran_jenazah;
		}else if($instalasi_id == Params::INSTALASI_ID_FARMASI){
			$kode_instalasi = $konfig->nopendaftaran_apotik;
		}else{
			$kode_instalasi = InstalasiM::model()->findByPk($instalasi_id)->instalasi_singkatan;
		}
		
        $prefix=$kode_instalasi.$tgl;
        $sql = "SELECT CAST(MAX(SUBSTR(no_pendaftaran,".(strlen($prefix)+1).",".strlen($default).")) AS integer) nomaksimal 
				FROM pendaftaran_t 
				WHERE no_pendaftaran LIKE ('".$prefix."%')";
        $nopendaftaran = Yii::app()->db->createCommand($sql)->queryRow();
        $no_pendaftaran_baru=$prefix.(isset($nopendaftaran['nomaksimal']) ? (str_pad($nopendaftaran['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $no_pendaftaran_baru;
    }
    
    /**
     * Generate noPendaftaranPenjualanResep untuk pendaftaran_t
     * @param type 
     * @return string
     */
    public static function noPendaftaranPenjualanResep($tgl_pendaftaran = null)
    {
		return self::noPendaftaran(Params::INSTALASI_ID_FARMASI, $tgl_pendaftaran);
    }

    /**
     * Generate no_pengambilansample untuk pengambilansample_t
     * @return string 
	 * RND-8327
     */
    public static function noPengambilanSample($alatmedis_id = null)
    {
		$default = "0001";
		$prefix = date('y')."00";
		if(!empty($alatmedis_id)){
			$sqlalat = "SELECT *
					FROM alatmedis_m 
					WHERE alatmedis_id = ".$alatmedis_id;
			$alatmedis = Yii::app()->db->createCommand($sqlalat)->queryRow();
			$prefix = date('y').$alatmedis['alatmedis_kode'];
			if(!empty($alatmedis['alatmedis_format'])){
				$default = $alatmedis['alatmedis_format'];
			}
		}
        $sql = "SELECT CAST(MAX(SUBSTR(no_pengambilansample,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
				FROM pengambilansample_t 
				WHERE no_pengambilansample LIKE ('".$prefix."%')";
        $pengambilanSample = Yii::app()->db->createCommand($sql)->queryRow();
        $no_pengambilansample_baru=$prefix.(isset($pengambilanSample['nomaksimal']) ? (str_pad($pengambilanSample['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $no_pengambilansample_baru;
    }
    
    /**
     * Generate bookingkamar_no untuk bookingkamar_t
     * @return string 
     */
    public static function noBookingKamar()
    {
		$default = '001';
        $tgl = date('ymd');
        $prefix = 'BOOK'.$tgl;
        $sql = "SELECT CAST(MAX(SUBSTR(bookingkamar_no,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
				FROM bookingkamar_t 
				WHERE bookingkamar_no LIKE ('".$prefix."%')";
        $bookingKamar = Yii::app()->db->createCommand($sql)->queryRow();
        $no_book_baru = $prefix.(isset($bookingKamar['nomaksimal']) ? (str_pad($bookingKamar['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
		return $no_book_baru;
    }
    
    /**
     * Generate no_urutantri untuk pendaftaran_t
     * @param type $ruangan_id
     * @return type string
     */
    public static function noAntrian($ruangan_id)
    {
		$default = '001';
        $tgl = date('Y-m-d');
        $sql = "select max(no_urutantri) nomaksimal
				from pendaftaran_t 
				where date(tgl_pendaftaran) = '".$tgl."' AND ruangan_id = '".$ruangan_id."'";
        $pendaftaran = Yii::app()->db->createCommand($sql)->queryRow();
        $no_urut_baru=(isset($pendaftaran['nomaksimal']) ? (str_pad($pendaftaran['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $no_urut_baru;
    }
    /**
     * Generate no_masukpenunjang untuk pasienmasukpenunjang_t
     * @param type $kode_instalasi
     * @return string
     */
    public static function noMasukPenunjang($kode_instalasi = '')
    {
		$default = "001";
        $tgl = date('Y-m-d');
		if(empty($kode_instalasi)){
			$kode_instalasi = Yii::app()->user->getState('instalasi_singkatan');
		}
		$prefix = $kode_instalasi;
        $sql = "SELECT CAST(MAX(SUBSTR(no_masukpenunjang,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
				FROM pasienmasukpenunjang_t 
				WHERE no_masukpenunjang LIKE ('".$kode_instalasi."%') AND DATE(tglmasukpenunjang) = '".$tgl."'";
        $pasienMasukPenunjang = Yii::app()->db->createCommand($sql)->queryRow();
        $no_masukpenunjang_baru=$prefix.(isset($pasienMasukPenunjang['nomaksimal']) ? (str_pad($pasienMasukPenunjang['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $no_masukpenunjang_baru;
    }

    /**
     * Generate noperminatanpenujang untuk permintaankepenunjang_t
     * @param type $prefix
     * @return string
     */
    public static function noPermintaanPenunjang($prefix='')
    {
		$default = "0001";
        $tgl = date('Y-m-d');
        $sql = "SELECT CAST(MAX(SUBSTR(noperminatanpenujang,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal 
                        FROM permintaankepenunjang_t 
                        WHERE noperminatanpenujang LIKE ('".$prefix."%') AND DATE(tglpermintaankepenunjang) = '".$tgl."'";
        $no = Yii::app()->db->createCommand($sql)->queryRow();
        $no_permintaan_baru=$prefix.(isset($no['nomaksimal']) ? (str_pad($no['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $no_permintaan_baru;
    }
    
    /**
     * Generate no_urutperiksa untuk pasienmasukpenunjang_t
     * @param type $ruangan_id
     * @return type string
     */
    public static function noAntrianPenunjang($ruangan_id)
    {
        if(!empty($ruangan_id)){
			$default = '001';
            $tgl = date('Y-m-d');
            $sql = "select max(no_urutperiksa) nomaksimal
					from pasienmasukpenunjang_t 
					where date(tglmasukpenunjang) = '".$tgl."' AND ruangan_id = '".$ruangan_id."'";
            $pasienMasukPenunjang = Yii::app()->db->createCommand($sql)->queryRow();
            $no_urutperiksa_baru=(isset($pasienMasukPenunjang['nomaksimal']) ? (str_pad($pasienMasukPenunjang['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
            return $no_urutperiksa_baru;
        } else {
            return null;
        }
    }

    /**
     * Generate nourut untuk pasienkirimkeunitlain_t
     * @param type $ruangan_id
     * @return int
     */
    public static function noUrutPasienKirimKeUnitLain($ruangan_id)
    {
        $nourut_baru = null;
        if(!empty($ruangan_id)){
            $tgl = date('Y-m-d');
            $sql = "select max(nourut) nomaksimal
					from pasienkirimkeunitlain_t 
					where date(tgl_kirimpasien) = '".$tgl."' AND ruangan_id = '".$ruangan_id."'";
            $pasienKeUnitLain = Yii::app()->db->createCommand($sql)->queryRow();
            $nourut_baru = (isset($pasienKeUnitLain['nomaksimal']) ? $pasienKeUnitLain['nomaksimal']+1 : 1);
        }
        return $nourut_baru;
    }
    /**
     * Generate norencanaoperasi untuk rencanaoperasi_t
     * @return string
     */
    public static function noRencanaOperasi()
    {
		$default = "001";
        $prefix = 'RENCANA'.date('ymd');
        $sql = "SELECT CAST(MAX(SUBSTR(norencanaoperasi,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
				FROM rencanaoperasi_t 
				WHERE norencanaoperasi LIKE ('".$prefix."%')";
        $rencanaOperasi= Yii::app()->db->createCommand($sql)->queryRow();
        $norencanaoperasi_baru=$prefix.(isset($rencanaOperasi['nomaksimal']) ? (str_pad($rencanaOperasi['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $norencanaoperasi_baru;
    }
    
    /**
     * Generate nohasilrm untuk hasilpemeriksaanrm_t
     * @return string 
     */
    public static function noHasilPemeriksaanRM()
    {
		$default = "001";
        $prefix = 'HASIL'.date('ymd');
        $sql = "SELECT CAST(MAX(SUBSTR(nohasilrm,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
				FROM hasilpemeriksaanrm_t 
				WHERE nohasilrm LIKE ('".$prefix."%')";
        $hasilPemeriksaan= Yii::app()->db->createCommand($sql)->queryRow();
        $nohasilrm_baru=$prefix.(isset($hasilPemeriksaan['nomaksimal']) ? (str_pad($hasilPemeriksaan['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $nohasilrm_baru;
    }
    
    /**
     * Generate nopengajuan untuk pengajuanbahanmkn_t
     * @return string 
     */
    public static function noPengajuanBahan()
    {
		$default = "001";
        $prefix = 'PB'.date('ymd');
        $sql = "SELECT CAST(MAX(SUBSTR(nopengajuan,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
				FROM pengajuanbahanmkn_t 
				WHERE nopengajuan LIKE ('".$prefix."%')";
        $nohasil= Yii::app()->db->createCommand($sql)->queryRow();
        $nobaru=$prefix.(isset($nohasil['nomaksimal']) ? (str_pad($nohasil['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $nobaru;
    }
    
    /**
     * Generate nopenerimaanbahan untuk terimabahanmakan_t
     * @return string 
     */
    public static function noPenerimaanBahan()
    {
		$default = "001";
        $prefix = 'TB'.date('ymd');
        $sql = "SELECT CAST(MAX(SUBSTR(nopenerimaanbahan,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
				FROM terimabahanmakan_t
				WHERE nopenerimaanbahan LIKE ('".$prefix."%')";
		$terimaBahan= Yii::app()->db->createCommand($sql)->queryRow();
        $nopenerimaanbahan_baru=$prefix.(isset($terimaBahan['nomaksimal']) ? (str_pad($terimaBahan['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $nopenerimaanbahan_baru;
    }
    
    /**
     * Generate nopesanmenu untuk pesanmenudiet_t
     * @return string 
     */
    public static function noPesanMenuDiet()
    {
		$default = "00001";
        $prefix = 'PD'.date('ymd');
        $sql = "SELECT CAST(MAX(SUBSTR(nopesanmenu,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
				FROM pesanmenudiet_t 
				WHERE nopesanmenu LIKE ('".$prefix."%')";
        $pesanMenuDiet= Yii::app()->db->createCommand($sql)->queryRow();
        $nopesanmenu_baru = $prefix.(isset($pesanMenuDiet['nomaksimal']) ? (str_pad($pesanMenuDiet['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $nopesanmenu_baru;
    }
    
    /**
     * generate nokirimmenu untuk kirimmenudiet_t
     * @return string 
     */
    public static function noKirimMenuDiet()
    {
		$default = "00001";
        $prefix = 'KD'.date('ymd');
        $sql = "SELECT CAST(MAX(SUBSTR(nokirimmenu,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
				FROM kirimmenudiet_t 
				WHERE nokirimmenu LIKE ('".$prefix."%')";
        $kirimMenuDiet= Yii::app()->db->createCommand($sql)->queryRow();
        $nokirimmenu_baru=$prefix.(isset($kirimMenuDiet['nomaksimal']) ? (str_pad($kirimMenuDiet['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $nokirimmenu_baru;
    }
    
    /**
     * Generate nojadwal untuk jadwalkunjunganrm_t
     * @return string 
     */
    public static function noUrutJadwalRencanaRM()
    {
		$default = "001";
        $prefix = "JADWAL".date('ymd');
        $sql = "SELECT CAST(MAX(SUBSTR(nojadwal,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
				FROM jadwalkunjunganrm_t 
				WHERE nojadwal LIKE ('".$prefix."%')";
        $jadwalKunjungan= Yii::app()->db->createCommand($sql)->queryRow();
        $nojadwal_baru = $prefix.(isset($jadwalKunjungan['nomaksimal']) ? (str_pad($jadwalKunjungan['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $nojadwal_baru;
    }
    /**
     * Generate noresep untuk penjualanresep_t
     * @param type $instalasi_id
     * @return string
     */
    public static function noResep($instalasi_id)
    {
		$instalasi = InstalasiM::model()->findByPk($instalasi_id);
		$default = "0001";
        $prefix = "PR".strtoupper($instalasi->instalasi_singkatan).date("ymd");
        $sql = "SELECT CAST(MAX(SUBSTR(noresep,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
				FROM penjualanresep_t 
				WHERE noresep LIKE ('".$prefix."%')";
        $penjualanResep= Yii::app()->db->createCommand($sql)->queryRow();
        $noresep_baru = $prefix.(isset($penjualanResep['nomaksimal']) ? (str_pad($penjualanResep['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $noresep_baru;
    }
    /**
     * Generate noresep untuk reseptur_t
     * @return string
     */
    public static function noResepReseptur()
    {
        $default = "0001";
        $prefix = "R".date("ymd");
		$sql = "SELECT CAST(MAX(SUBSTR(noresep,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
				FROM reseptur_t 
				WHERE noresep LIKE ('".$prefix."%')";
        $reseptur= Yii::app()->db->createCommand($sql)->queryRow();
        $noresep_baru = $prefix.(isset($reseptur['nomaksimal']) ? (str_pad($reseptur['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $noresep_baru;
    }
    
    /**
     * Generate nourutkasir untuk tandabuktibayar_t
     * @param type $ruangan_id
     * @return type
     */
    public static function noUrutKasir($ruangan_id)
    {
        $tgl = date('Y-m-d');
        $sql = "SELECT CAST(MAX(nourutkasir) AS integer) nourut FROM tandabuktibayar_t
                WHERE ruangan_id = $ruangan_id AND date(tglbuktibayar)='".$tgl."'";
        $data = Yii::app()->db->createCommand($sql)->queryRow();
        $nourutkasir_baru = (isset($data['nourut']) ? $data['nourut']+1 : 1);
        return $nourutkasir_baru;
    }
    
    /**
     * Generate nobuktibayar untuk tandabuktibayar_t
     * @return type
     */
    public static function noBuktiBayar()
    {
		$default = "00001";
        $prefix = 'BKM'.date('ymd');
		$sql = "SELECT CAST(MAX(SUBSTR(nobuktibayar,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
				FROM tandabuktibayar_t 
				WHERE nobuktibayar LIKE ('".$prefix."%')";
        $data = Yii::app()->db->createCommand($sql)->queryRow();
        $nobuktibayar_baru = $prefix.(isset($data['nomaksimal']) ? (str_pad($data['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $nobuktibayar_baru;
    }
	
	/**
     * Generate nobuktibayar untuk tandabuktibayar_t
     * @return type
     */
    public static function noBuktiBayarAnggaran($tglbuktibayar = null)
    {
		$default = "00001";
		$tgl = date('Y-m-d');
		if(!empty($tglbuktibayar)){
			$tgl = $tglbuktibayar;
		}
        $prefix = 'BKMA'.date('ymd',  strtotime($tgl));
		$sql = "SELECT CAST(MAX(SUBSTR(nobuktibayar,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal 
				FROM tandabuktibayar_t
				WHERE nobuktibayar LIKE ('".$prefix."%')";
        $data = Yii::app()->db->createCommand($sql)->queryRow();
        $nobuktibayar_baru = $prefix.(isset($data['nomaksimal']) ? (str_pad($data['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $nobuktibayar_baru;
    }
	
    /**
     * Generate nokaskeluar untuk tandabuktikeluar_t
     * @return type
     */
    public static function noBuktiKeluarAnggaran($tglbuktikeluar = null)
    {
		$default = "00001";
		$tgl = date('Y-m-d');
		if(!empty($tglbuktikeluar)){
			$tgl = $tglbuktikeluar;
		}
        $prefix = 'BKKA'.date('ymd',  strtotime($tgl));
		$sql = "SELECT CAST(MAX(SUBSTR(nokaskeluar,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
				FROM tandabuktikeluar_t 
				WHERE nokaskeluar LIKE ('".$prefix."%')";
        $data = Yii::app()->db->createCommand($sql)->queryRow();
        $nokaskeluar_baru = $prefix.(isset($data['nomaksimal'])?(str_pad($data['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)):$default);
        return $nokaskeluar_baru;
    }
	
    /**
     * Generate nokaskeluar untuk tandabuktikeluar_t
     * @return type
     */
    public static function noBuktiKeluar()
    {
		$default = "00001";
        $prefix = 'BKK'.date('ymd');
		$sql = "SELECT CAST(MAX(SUBSTR(nokaskeluar,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
				FROM tandabuktikeluar_t 
				WHERE nokaskeluar LIKE ('".$prefix."%')";
        $data = Yii::app()->db->createCommand($sql)->queryRow();
        $nokaskeluar_baru = $prefix.(isset($data['nomaksimal'])?(str_pad($data['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)):$default);
        return $nokaskeluar_baru;
    }
    
    /**
     * Generate nopembayaran untuk pembayaranpelayanan_t
     * @return string 
     */
    public static function noPembayaran()
    {
		$default = "00001";
        $prefix = 'BYR'.date('ymd');
        $sql = "SELECT CAST(MAX(SUBSTR(nopembayaran,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
				FROM pembayaranpelayanan_t 
				WHERE nopembayaran LIKE ('".$prefix."%')";
		$data = Yii::app()->db->createCommand($sql)->queryRow();
        $nopembayaran_baru = $prefix.(isset($data['nomaksimal']) ? (str_pad($data['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)):$default);
        return $nopembayaran_baru;
    }
    
    /**
     * Generate noreturbayar untuk returbayarpelayanan_t
     * @return string 
     */
    public static function noReturBayarPelayanan()
    {
		$default = "00001";
        $prefix = 'RTR'.date('ymd');
		$sql = "SELECT CAST(MAX(SUBSTR(noreturbayar,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
				FROM returbayarpelayanan_t 
				WHERE noreturbayar LIKE ('".$prefix."%')";
        $data = Yii::app()->db->createCommand($sql)->queryRow();
        $noretur_baru = $prefix.(isset($data['nomaksimal']) ? (str_pad($data['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $noretur_baru;
    }
    
    /**
     * Generate nopenerimaan untuk penerimaanumum_t
     * @return string 
     */
    public static function noPenerimaanUmum()
    {
        $default = "00001";
        $prefix = 'TRU'.date('ymd');
		$sql = "SELECT CAST(MAX(SUBSTR(nopenerimaan,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
				FROM penerimaanumum_t 
				WHERE nopenerimaan LIKE ('".$prefix."%')";
        $data = Yii::app()->db->createCommand($sql)->queryRow();
        $nopenerimaan_baru = $prefix.(isset($data['nomaksimal']) ? (str_pad($data['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $nopenerimaan_baru;
    }
    
    /**
     * Generate nopengeluaran untuk pengeluaranumum_t
     * @return string 
     */
    public static function noPengeluaranUmum()
    {
		$default = "00001";
        $prefix = 'KLU'.date('ymd');
		$sql = "SELECT CAST(MAX(SUBSTR(nopengeluaran,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
				FROM pengeluaranumum_t 
				WHERE nopengeluaran LIKE ('".$prefix."%')";
        $data = Yii::app()->db->createCommand($sql)->queryRow();
        $nopengeluaran_baru = $prefix.(isset($data['nomaksimal']) ? (str_pad($data['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $nopengeluaran_baru;
    }
    
    /**
     * Generate nokaskeluar untuk tandabuktikeluar_t
     * @return string 
     */
    public static function noKasKeluar()
    {
		$default = "00001";
        $prefix = 'KKL'.date('ymd');
		$sql = "SELECT CAST(MAX(SUBSTR(nokaskeluar,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
				FROM tandabuktikeluar_t 
				WHERE nokaskeluar LIKE ('".$prefix."%')";
        $data = Yii::app()->db->createCommand($sql)->queryRow();
        $nokaskeluar_baru = $prefix.(isset($data['nomaksimal']) ? (str_pad($data['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $nokaskeluar_baru;
    }
    
    /**
     * Generate nourutbayi untuk kelahiranbayi_t
     * @return string 
     */
    public static function noUrutBayi($pasien_id){
        $persalinan = PersalinanT::model()->findByAttributes(array('pasien_id'=>$pasien_id));
        $sql = "select MAX(nourutbayi) AS nomaksimal
				from kelahiranbayi_t 
				where persalinan_id= '$persalinan->persalinan_id'";
        $data = Yii::app()->db->createCommand($sql)->queryRow();
        $nourut_baru = (isset($data['nomaksimal']) ? $data['nomaksimal'] + 1 : 1);
        return $nourut_baru; 
    }
    
    /**
     * Generate nopemesanan untuk pesanobatalkes_t
     * @return string 
     */
    public static function noPemesanan()
    {
        $default = "00001";
        $prefix = 'PSNOA'.date('ymd');
		$sql = "SELECT CAST(MAX(SUBSTR(nopemesanan,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
				FROM pesanobatalkes_t 
				WHERE nopemesanan LIKE ('".$prefix."%')";
		$nohasil= Yii::app()->db->createCommand($sql)->queryRow();
        $nopemesanan_baru = $prefix.(isset($nohasil['nomaksimal']) ? (str_pad($nohasil['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $nopemesanan_baru;
    }
    
    /**
     * Generate nomutasioa untuk mutasioaruangan_t
     * @return string 
     */
    public static function noMutasi()
    {
		$default = "00001";
        $prefix = 'MUTOA'.date('ymd');
		$sql = "SELECT CAST(MAX(SUBSTR(nomutasioa,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
				FROM mutasioaruangan_t 
				WHERE nomutasioa LIKE ('".$prefix."%')";
        $no_penawaran = Yii::app()->db->createCommand($sql)->queryRow();
        $no_penawaran_baru = $prefix.(isset($no_penawaran['nomaksimal']) ? (str_pad($no_penawaran['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $no_penawaran_baru;
    }
    
    /**
     * Generate noterimamutasi untuk terimamutasi_t
     * @return string 
     */
    public static function noTerimaMutasi()
    {
		$default = "00001";
        $prefix = 'TRMUT'.date('ymd');
		$sql = "SELECT CAST(MAX(SUBSTR(noterimamutasi,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
				FROM terimamutasi_t 
				WHERE noterimamutasi LIKE ('".$prefix."%')";
        $terimaMutasi = Yii::app()->db->createCommand($sql)->queryRow();
        $noterimamutasi_baru = $prefix.(isset($terimaMutasi['nomaksimal']) ? (str_pad($terimaMutasi['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $noterimamutasi_baru;
    }
    /**
     * generate nourut_pinjam untuk peminjamanrm_t
     * @return type
     */
    public static function noUrutPinjamRM()
    {
		$default = "00001";
// RND-8408       $prefix = 'PJMRM'.date('ymd'); // nourut terlalu panjang maks. 5 karakter
        $prefix = '';
		$sql = "SELECT CAST(MAX(SUBSTR(nourut_pinjam,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
				FROM peminjamanrm_t 
				WHERE nourut_pinjam LIKE ('".$prefix."%')";
        $peminjamanRM = Yii::app()->db->createCommand($sql)->queryRow();
        $nourut_pinjam_baru = $prefix.(isset($peminjamanRM['nomaksimal']) ? (str_pad($peminjamanRM['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $nourut_pinjam_baru;
    }
    /**
     * generate nourut_keluar untuk pengirimanrm_t
     * @return type
     */
	public static function noUrutKeluarRM()
    {
		$default = "00001";
        $prefix = '';
        $tgl = date('Y-m-d');
        $sql = "SELECT CAST(MAX(SUBSTR(nourut_keluar,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal FROM pengirimanrm_t
                WHERE date(tglpengirimanrm)='".$tgl."'";
        $pengirimanRM = Yii::app()->db->createCommand($sql)->queryRow();
		$nourut_keluar_baru = $prefix.(isset($pengirimanRM['nomaksimal']) ? (str_pad($pengirimanRM['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $nourut_keluar_baru;
    }
    /**
     * Generate nodokumenrm untuk dokrekammedis_m
     * @return string
     */
    public static function noDokumenRM()
    {
		$default = "0001";
        $prefix = date('ymd'); 
		$sql = "SELECT CAST(MAX(SUBSTR(nodokumenrm,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
				FROM dokrekammedis_m 
				WHERE nodokumenrm LIKE ('".$prefix."%')";
        $dokRekammedis = Yii::app()->db->createCommand($sql)->queryRow();
        $nodokumenrm_baru = $prefix.(isset($dokRekammedis['nomaksimal']) ? (str_pad($dokRekammedis['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $nodokumenrm_baru;
    }
    /**
     * Generate barang_kode untuk barang_m
     * @return type
     */
    public static function kodeBarang()
    {     
        $sql = "SELECT MAX(barang_kode) AS kodebarang FROM barang_m";
        $barang = Yii::app()->db->createCommand($sql)->queryRow();
        $kodebarang_baru = (isset($barang['kodebarang']) ? $barang['kodebarang']+1 : 1);
        return $kodebarang_baru;
    }
    /**
     * Generate nopemesanan untuk pesanbarang_t
     * @param type $instalasi_id
     * @return string 
     */
    public static function noPemesananBarang()
    {
        $default = "0001";
        $prefix = "PSNBRG".date('ymd'); 
		$sql = "SELECT CAST(MAX(SUBSTR(nopemesanan,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
				FROM pesanbarang_t 
				WHERE nopemesanan LIKE ('".$prefix."%')";
		$pesanBarang= Yii::app()->db->createCommand($sql)->queryRow();
        $nopemesanan_baru = $prefix.(isset($pesanBarang['nomaksimal']) ? (str_pad($pesanBarang['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $nopemesanan_baru;
    }
    /**
     * Generate nomutasibrg untuk mutasibrg_t
     * @param type $instalasi_id
     * @return string
     */
    public static function noMutasiBarang()
    {
        $default = "0001";
        $prefix = "MUTBRG".date('ymd'); 
		$sql = "SELECT CAST(MAX(SUBSTR(nomutasibrg,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
				FROM mutasibrg_t 
				WHERE nomutasibrg LIKE ('".$prefix."%')";
		$mutasiBrg= Yii::app()->db->createCommand($sql)->queryRow();
        $nomutasibrg_baru=$prefix.(isset($mutasiBrg['nomaksimal']) ? (str_pad($mutasiBrg['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $nomutasibrg_baru;
    }
    /**
     * Generate nopembelian untuk pembelianbarang_t
     * @param type $instalasi_id
     * @return string
     */
    public static function noPembelianBarang()
    {
        $default = "0001";
        $prefix = "BLIBRG".date('ymd'); 
		$sql = "SELECT CAST(MAX(SUBSTR(nopembelian,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
				FROM pembelianbarang_t 
				WHERE nopembelian LIKE ('".$prefix."%')";
		$nohasil= Yii::app()->db->createCommand($sql)->queryRow();
        $nopembelian_baru=$prefix.(isset($nohasil['nomaksimal']) ? (str_pad($nohasil['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $nopembelian_baru;
    }
    /**
     * Generate nopenerimaan untuk terimapersediaan_t
     * @param type $instalasi_id
     * @return string
     */
    public static function noPenerimaanPersediaan()
    {
        $default = "0001";
        $prefix = "TRMBRG".date('ymd'); 
		$sql = "SELECT CAST(MAX(SUBSTR(nopenerimaan,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
				FROM terimapersediaan_t 
				WHERE nopenerimaan LIKE ('".$prefix."%')";
		$terimaPersediaan= Yii::app()->db->createCommand($sql)->queryRow();
        $nopenerimaan_baru=$prefix.(isset($terimaPersediaan['nomaksimal']) ? (str_pad($terimaPersediaan['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $nopenerimaan_baru;
    }
    /**
     * Generate noreturterima untuk returpenerimaan_t
     * @return string 
     */
    public static function noReturTerima()
    {
		$default = "0001";
        $prefix = "RTRBRG".date('ymd'); 
		$sql = "SELECT CAST(MAX(SUBSTR(noreturterima,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
				FROM returpenerimaan_t 
				WHERE noreturterima LIKE ('".$prefix."%')";
        $returPenerimaan= Yii::app()->db->createCommand($sql)->queryRow();
        $noreturterima_baru=$prefix.(isset($returPenerimaan['nomaksimal']) ? (str_pad($returPenerimaan['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $noreturterima_baru;
    }
    /**
     * Generate inventarisasi_kode untuk inventarisasiruangan_t
     * @return string
     */
    public static function kodeTerimaPersediaan()
    {
        $default = "001";
        $prefix = "TRMSTOK".date('ymd'); 
		$sql = "SELECT CAST(MAX(SUBSTR(inventarisasi_kode,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
				FROM inventarisasiruangan_t 
				WHERE inventarisasi_kode LIKE ('".$prefix."%')";
        $nohasil= Yii::app()->db->createCommand($sql)->queryRow();
        $inventarisasi_kode=$prefix.(isset($nohasil['nomaksimal']) ? (str_pad($nohasil['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $inventarisasi_kode;
    }
    
    /**
     * Generate inventarisasi_kode untuk inventarisasiruangan_t
     * @return string
     */
    public static function kodeTerimaMutasi()
    {
        $default = "001";
        $prefix = "MTSSTOK".date('ymd'); 
		$sql = "SELECT CAST(MAX(SUBSTR(inventarisasi_kode,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
				FROM inventarisasiruangan_t 
				WHERE inventarisasi_kode LIKE ('".$prefix."%')";
        $nohasil= Yii::app()->db->createCommand($sql)->queryRow();
        $inventarisasi_kode=$prefix.(isset($nohasil['nomaksimal']) ? (str_pad($nohasil['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $inventarisasi_kode;
    }
    
    /**
     * Generate inventarisasi_kode untuk inventarisasiruangan_t
     * @return string
     */
    public static function kodeStokAwalPersediaan()
    {
        $default = "001";
        $prefix = "STOKAWL".date('ymd'); 
		$sql = "SELECT CAST(MAX(SUBSTR(inventarisasi_kode,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
				FROM inventarisasiruangan_t 
				WHERE inventarisasi_kode LIKE ('".$prefix."%')";
        $nohasil= Yii::app()->db->createCommand($sql)->queryRow();
        $inventarisasi_kode=$prefix.(isset($nohasil['nomaksimal']) ? (str_pad($nohasil['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $inventarisasi_kode;
    }
    
    /**
     * Generate noformulir untuk formuliropname_r
     * @return string
     */
    public static function noFormulirOpname()
    {
		$default = "001";
        $prefix = 'FOPNM'.date('ymd');
        $sql = "SELECT CAST(MAX(SUBSTR(noformulir,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
				FROM formuliropname_r 
				WHERE noformulir LIKE ('".$prefix."%')";
		$formulirOpname= Yii::app()->db->createCommand($sql)->queryRow();
        $noformulir_baru=$prefix.(isset ($formulirOpname['nomaksimal']) ? (str_pad($formulirOpname['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $noformulir_baru;
    }
    /**
     * Generate nostokopname untuk stokopname_t
     * @param type $instalasi_id
     * @return string
     */
    public static function noStokOpname($instalasi_id)
    {
        $default = "001";
        $prefix = 'SOPNM'.date('ymd');
        $sql = "SELECT CAST(MAX(SUBSTR(nostokopname,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
				FROM stokopname_t 
				WHERE nostokopname LIKE ('".$prefix."%')";
        $stokOpname= Yii::app()->db->createCommand($sql)->queryRow();
        $nostokopname_baru = $prefix.(isset($stokOpname['nomaksimal']) ? (str_pad($stokOpname['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $nostokopname_baru;
    }
    /**
     * Generate pengangkatantphl_noperjanjian untuk pengangkatantphl_t
     * @return string
     */
    public static function noPerjanjian()
    {
		$default = "001";
        $prefix = 'PJNJ'.date('ymd');
        $sql = "SELECT CAST(MAX(SUBSTR(pengangkatantphl_noperjanjian,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
				FROM pengangkatantphl_t 
				WHERE pengangkatantphl_noperjanjian LIKE ('".$prefix."%')";
		$pengangkatanTphl= Yii::app()->db->createCommand($sql)->queryRow();
        $noperjanjian_baru=$prefix.(isset($pengangkatanTphl['nomaksimal']) ? (str_pad($pengangkatanTphl['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $noperjanjian_baru;
    }
    
    /**
     * Generate nopenggajian untuk penggajianpeg_t
     */
    public static function noPenggajian()
    {
		$default = "001";
        $prefix = 'GAJI'.date('ymd');
        $sql = "SELECT CAST(MAX(SUBSTR(nopenggajian,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
				FROM penggajianpeg_t 
				WHERE nopenggajian LIKE ('".$prefix."%')";
        $penggajianPeg= Yii::app()->db->createCommand($sql)->queryRow();
        $nopenggajian=$prefix.(isset($penggajianPeg['nomaksimal']) ? (str_pad($penggajianPeg['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
		
        return $nopenggajian;
    }
    /**
     * Generate nopenggajian untuk penggajianpeg_t
     */
    public static function noRealisasiLembur()
    {
		$default = "001";
        $prefix = 'RLP'.date('ymd');
        $sql = "SELECT CAST(MAX(SUBSTR(norealisasi,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
				FROM realisasilembur_t 
				WHERE norealisasi LIKE ('".$prefix."%')";
        $penggajianPeg= Yii::app()->db->createCommand($sql)->queryRow();
        $nopenggajian=$prefix.(isset($penggajianPeg['nomaksimal']) ? (str_pad($penggajianPeg['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
		
        return $nopenggajian;
    }
    /**
     * Generate nobayarjasa untuk pembayaranjasa_id
     * @return string
     */
    public static function noBayarJasa()
    {
        $default = "01";
        $prefix = 'BJ'.date('ymd');
        $sql = "SELECT CAST(MAX(SUBSTR(nobayarjasa,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
				FROM pembayaranjasa_t 
				WHERE nobayarjasa LIKE ('".$prefix."%')";
        $pembayaranJasa = Yii::app()->db->createCommand($sql)->queryRow();
        $nobayarjasa_baru =$prefix.(isset($pembayaranJasa['pembayaranjasa_id']) ? (str_pad($pembayaranJasa['pembayaranjasa_id']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $nobayarjasa_baru;
    }
    
    /**
     * Generate noresep untuk penjualanresep_t (retailer)
     * @return string 
     */
    public static function noResepRetailer($prefix='NR')
    {
		$default = "0001";
        $prefix = $prefix.date('ymd');
        $sql = "SELECT CAST(MAX(SUBSTR(noresep,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
				FROM penjualanresep_t 
				WHERE noresep LIKE ('".$prefix."%')";
        $penjualanResep= Yii::app()->db->createCommand($sql)->queryRow();
        $noresep_baru=$prefix.(isset($penjualanResep['nomaksimal']) ? (str_pad($penjualanResep['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $noresep_baru;
    }
    /**
     * Generate noresep untuk penjualanresep_t (Penjualan Bebas)
     * @param type $prefix
     * @return string
     */
    public static function noResepPenjualanBebas($prefix=null){
		$default = "0001";
        $prefix = (isset($prefix) ? $prefix : 'BEBAS').date('ymd');
        $sql = "SELECT CAST(MAX(SUBSTR(noresep,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
				FROM penjualanresep_t 
				WHERE noresep LIKE ('".$prefix."%')";
        $penjualanResep= Yii::app()->db->createCommand($sql)->queryRow();
        $noresep_baru=$prefix.(isset($penjualanResep['nomaksimal']) ? (str_pad($penjualanResep['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $noresep_baru;
    }
    
    /**
     * Generate nopembayaranklaim untuk pembayarklaim_t
     * @return string 
     */
    public static function noPembayaranKlaim()
    {
		$default = "0001";
        $prefix = "BKL".date('ymd');
        $sql = "SELECT CAST(MAX(SUBSTR(nopembayaranklaim,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
				FROM pembayarklaim_t 
				WHERE nopembayaranklaim LIKE ('".$prefix."%')";
        $pembayarKlaim = Yii::app()->db->createCommand($sql)->queryRow();
        $no_pembayarklaim_baru = $prefix.(isset($pembayarKlaim['nomaksimal']) ? (str_pad($pembayarKlaim['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $no_pembayarklaim_baru;
    }
	 /**
     * Generate nopembayaranklaim untuk pembayarklaim_t
     * @return string 
     */
    public static function noPengajuanKlaim()
    {
        $default = "0001";
        $prefix = "AKL".date('ymd');
        $sql = "SELECT CAST(MAX(SUBSTR(nopengajuanklaimanklaim,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
				FROM pengajuanklaimpiutang_t 
				WHERE nopengajuanklaimanklaim LIKE ('".$prefix."%')";
        $pengajuanKlaim = Yii::app()->db->createCommand($sql)->queryRow();
        $no_pengajuanklaim_baru = $prefix.(isset($pengajuanKlaim['nomaksimal']) ? (str_pad($pengajuanKlaim['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $no_pengajuanklaim_baru;
    }
	
    /**
     * Generate nobuktijurnal untuk jurnalrekening_t
     * @return string
     */
    public static function noBuktiJurnalRek()
    {
		$default = "00001";
        $prefix = "BJR".date('ymd');
        $sql = "SELECT CAST(MAX(SUBSTR(nobuktijurnal,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
				FROM jurnalrekening_t 
				WHERE nobuktijurnal LIKE ('".$prefix."%')";
        $jurnalRek = Yii::app()->db->createCommand($sql)->queryRow();
        $nobuktijurnal_baru = $prefix.(isset($jurnalRek['nomaksimal']) ? (str_pad($jurnalRek['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $nobuktijurnal_baru;
    }
    /**
     * Generate kodejurnal untuk jurnalrekening_t
     * @return type
     */
    public static function kodeJurnalRek()
    {
		$default = "000000001";
        $prefix = "";
        $sql = "SELECT CAST(MAX(SUBSTR(kodejurnal,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
				FROM jurnalrekening_t 
				WHERE kodejurnal LIKE ('".$prefix."%')";
        $jurnalRek = Yii::app()->db->createCommand($sql)->queryRow();
        $kodejurnal_baru = $prefix.(isset($jurnalRek['nomaksimal']) ? (str_pad($jurnalRek['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $kodejurnal_baru;
    }

    /**
     * Generate noverifikasi untuk verifikasitagihan_t
     * @return string 
     */
    public static function noVerifikasi()
    {
		$default = "0001";
        $prefix = 'VR'.date('ymd');
        $sql = "SELECT CAST(MAX(SUBSTR(noverifikasi,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
				FROM verifikasitagihan_t 
				WHERE noverifikasi LIKE ('".$prefix."%')";
        $verifikasiTagihan = Yii::app()->db->createCommand($sql)->queryRow();
        $noverifikasi_baru = $prefix.(isset($verifikasiTagihan['nomaksimal']) ? (str_pad($verifikasiTagihan['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $noverifikasi_baru;
    }

    /**
     * Generate nokodeobat untuk obatalkes_m
     * @param string $obatalkes_nama
     * @return string
     */
    public static function noKodeObatAlkes($obatalkes_nama = ""){
		$default = "000000001";
        $prefix=(!empty($obatalkes_nama)) ? strtoupper(substr(trim($obatalkes_nama),0,3)) : "";
        $sql = "SELECT CAST(MAX(SUBSTR(obatalkes_kode,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
				FROM obatalkes_m 
				WHERE obatalkes_kode LIKE ('".$prefix."%')";
        $obatAlkes = Yii::app()->db->createCommand($sql)->queryRow();
        $nokodeobat_baru = $prefix.(isset($obatAlkes['nomaksimal']) ? (str_pad($obatAlkes['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $nokodeobat_baru;
    }
    /**
     * Generate no_pendaftaran untuk pesanambulans_t
     * @param type $kode_instalasi
     * @return string
     */
    public static function noPesanAmbulans($instalasi_id)
    {
        $default = "0001";
        $prefix = "PAMB".date('ymd');
        $sql = "SELECT CAST(MAX(SUBSTR(pesanambulans_no,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
				FROM pesanambulans_t 
				WHERE pesanambulans_no LIKE ('".$prefix."%')";
		$nopendaftaran = Yii::app()->db->createCommand($sql)->queryRow();
        $no_pendaftaran_baru=$prefix.(isset($nopendaftaran['nomaksimal']) ? (str_pad($nopendaftaran['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $no_pendaftaran_baru;
    }
    
    /**
     * Generate nomorsurat untuk suratketerangan_r
     * @param type $jenissurat_id
     * @return integer
     */
    public static function noSurat($jenissurat_id)
    {
        $bulan = date('m');
        if($bulan < 10){
            $bln = number_format($bulan);
        }else{
            $bln = $bulan;
        }
        $bulanRomawi = CustomFunction::Romawi($bln);
        $tahun = date('Y');
        $tglsurat = $tahun."-".$bulan;
        $sqlNoSurat = "SELECT MAX(nomorsurat) AS nop FROM suratketerangan_r WHERE jenissurat_id=$jenissurat_id AND to_char(tglsurat,'yyyy-mm')='$tglsurat'";
        $genSurat = Yii::app()->db->createCommand($sqlNoSurat)->queryRow();        
        $noSurat = str_pad($genSurat['nop']+1, 3, 0,STR_PAD_LEFT)."/SK/RS/".$bulanRomawi."/".$tahun;
        return trim($noSurat);
    }
    
    /**
     * Generate permohonanoa_nomor untuk permohonanoa_t
     * @return string 
     */
    public static function noPermohonanBantuan()
    {
        $default = "0001";
        $prefix = "PBOA".date('ymd');
        $sql = "SELECT CAST(MAX(SUBSTR(permohonanoa_nomor,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
				FROM permohonanoa_t 
				WHERE permohonanoa_nomor LIKE ('".$prefix."%')";
        $permohonanOa = Yii::app()->db->createCommand($sql)->queryRow();
        $no_permohonanoa = $prefix.(isset($permohonanOa['nomaksimal']) ? (str_pad($permohonanOa['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $no_permohonanoa;
    }
    
    /**
     * Generate nopemusnahan untuk pemusnahanobatalkes_t
     * @return string 
     */
    public static function noPemusnahan()
    {
		$default = "0001";
        $prefix = "MSOA".date('ymd');
        $sql = "SELECT CAST(MAX(SUBSTR(nopemusnahan,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
				FROM pemusnahanobatalkes_t 
				WHERE nopemusnahan LIKE ('".$prefix."%')";
        $no_pemusnahan = Yii::app()->db->createCommand($sql)->queryRow();
        $no_pemusnahan_baru = $prefix.(isset($no_pemusnahan['nomaksimal']) ? (str_pad($no_pemusnahan['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $no_pemusnahan_baru;
    }
	
	/**
     * Generate no_antriankonsul untuk konsulpoli_t
     * @return string 
     */
    public static function noAntrianKonsulPoli($ruangan_id = null, $format = "000")
    {
        $sql = "SELECT CAST(MAX(SUBSTR(no_antriankonsul,1,".(strlen($format)).")) AS integer) nomaksimal FROM konsulpoli_t 
                WHERE DATE(tglkonsulpoli)='".date('Y-m-d')."'
                    ".(!empty($ruangan_id) ? " AND ruangan_id = ".$ruangan_id : "");
        $antrian = Yii::app()->db->createCommand($sql)->queryRow();
        if(!isset($antrian['nomaksimal'])){
            $antrian['nomaksimal'] = 0;
        }
        $noantrian_baru = str_pad($antrian['nomaksimal']+1, strlen($format), 0, STR_PAD_LEFT);
        return $noantrian_baru;
    }
	
	/**
	* Fungsi Untuk Mengenerate No Pemakaian Barang Secara Otomatis
	* @return string 
	*/
    public static function noPemakaianBarang()
    {
		$default = "0001";
        $prefix = "PMBR".date('ymd');
        $sql = "SELECT CAST(MAX(SUBSTR(nopemakaianbrg,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
				FROM pemakaianbarang_t 
				WHERE nopemakaianbrg LIKE ('".$prefix."%')";
        $noPemakaian = Yii::app()->db->createCommand($sql)->queryRow();
        $noPemakaianBaru =$prefix.(isset($noPemakaian['nomaksimal']) ? (str_pad($noPemakaian['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $noPemakaianBaru;
    }
	
	/**
	* Fungsi Untuk Mengenerate No Hasil MCU Secara Otomatis
	* @return string 
	*/
    public static function noHasilMcu()
    {
		$default = "0001";
        $prefix = "HMCU".date('ymd');
        $sql = "SELECT CAST(MAX(SUBSTR(nohasilmcu,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
				FROM hasilpemeriksaanmcu_t 
				WHERE nohasilmcu LIKE ('".$prefix."%')";
        $nomor = Yii::app()->db->createCommand($sql)->queryRow();
        $nomorbaru = $prefix.(isset($nomor['nomaksimal']) ? (str_pad($nomor['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $nomorbaru;
    }
	
	/**
     * Fungsi Untuk Menggenerate No. Antrian Janji Poli Secara Otomatis
     * @return string 
     */
    public static function noAntrianJanjiPoli($ruangan_id = null, $format = "000")
    {
		$tgl = date('Y-m-d');
		$antrian = 0;
		
        $sql_pendaftaran = "select max(no_urutantri) nourut from pendaftaran_t where date(tgl_pendaftaran) = '".$tgl."' AND ruangan_id = '".$ruangan_id."'";
        $pendaftaran = Yii::app()->db->createCommand($sql_pendaftaran)->queryRow();
		$no_pendaftaran = isset($pendaftaran['nourut']) ? $pendaftaran['nourut'] : "001";
		
		$sql_konsulpoli = "SELECT max(no_antriankonsul) no_antriankonsul FROM konsulpoli_t 
                WHERE DATE(tglkonsulpoli)='".$tgl."'
                    ".(!empty($ruangan_id) ? " AND ruangan_id = ".$ruangan_id : "");
        $konsul = Yii::app()->db->createCommand($sql_konsulpoli)->queryRow();
		$no_konsul = isset($konsul['no_antriankonsul']) ? $konsul['no_antriankonsul'] : "001";
		
        $sql_buatjanji = "select max(no_antrianjanji) no_antrian from buatjanjipoli_t where date(tglbuatjanji) = '".$tgl."' AND ruangan_id = '".$ruangan_id."'";
        $buatjanji = Yii::app()->db->createCommand($sql_buatjanji)->queryRow();
		$no_buatjanji = isset($buatjanji['no_antrian']) ? $buatjanji['no_antrian'] : "001";
		
		if((int)$no_pendaftaran < (int)$no_konsul){
			if((int)$no_konsul < (int)$no_buatjanji){
				$antrian = (str_pad($no_buatjanji+1, 3, 0,STR_PAD_LEFT));
			}else{
				$antrian = (str_pad($no_konsul+1, 3, 0,STR_PAD_LEFT));
			}
		}else{
			if((int)$no_pendaftaran < (int)$no_buatjanji){
				$antrian = (str_pad($no_buatjanji+1, 3, 0,STR_PAD_LEFT));
			}else{
				$antrian = $antrian = (str_pad($no_pendaftaran+1, 3, 0,STR_PAD_LEFT));
			}
		}
		return $antrian;
    }
	
	/**
     * Generate no_buatjanji di buatjanjipoli_t
     * @param type $kode_ruangan	
     * @return string
     */
    public static function noJanjiPoli($kode_ruangan = "JP")
    {
        $default = "0001";
        $prefix = $kode_ruangan.date('ymd');
        $sql = "SELECT CAST(MAX(SUBSTR(no_buatjanji,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
				FROM buatjanjipoli_t 
				WHERE no_buatjanji LIKE ('".$prefix."%')";
		$nobuatjanji = Yii::app()->db->createCommand($sql)->queryRow();
        $nobuatjanji_baru=$prefix.(isset($nobuatjanji['nomaksimal']) ? (str_pad($nobuatjanji['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $nobuatjanji_baru;
    }
	
    /**
     * Generate nodocmedis untuk resumemedis_r
     * @return string
     */
    public static function noDokMedis()
    {
        $bulan = date('m');
        if($bulan < 10){
            $bln = number_format($bulan);
        }else{
            $bln = $bulan;
        }
        $bulanRomawi = CustomFunction::Romawi($bln);
        $tahun = date('Y');
        $tglsurat = $tahun."-".$bulan;
        $sqlNoDok = "SELECT MAX(nodocmedis) AS nodoc FROM resumemedis_r WHERE date_part('year', tglresume)='".$tahun."' AND date_part('month', tglresume) = '".$bulan."'";
        $noDok = Yii::app()->db->createCommand($sqlNoDok)->queryRow();        
        $noDokMedis = str_pad($noDok['nodoc']+1, STR_PAD_LEFT)."/Resume Medis/".$bulanRomawi."/".$tahun;
        return trim($noDokMedis);
	}
	
    /**
     * Generate nodocmedis untuk resumeperawat_r
     * @return string
     */
    public static function noDokResPerwt()
    {
        $bulan = date('m');
        if($bulan < 10){
            $bln = number_format($bulan);
        }else{
            $bln = $bulan;
        }
        $bulanRomawi = CustomFunction::Romawi($bln);
        $tahun = date('Y');
        $tglsurat = $tahun."-".$bulan;
        $sqlNoDok = "SELECT MAX(nodocresperwt) AS nodoc FROM resumeperawat_r WHERE date_part('year', tglreseumperwt)='".$tahun."' AND date_part('month', tglreseumperwt) = '".$bulan."'";
        $noDok = Yii::app()->db->createCommand($sqlNoDok)->queryRow();        
        $noDokMedis = str_pad($noDok['nodoc']+1, STR_PAD_LEFT)."/Resume Keperawatan/".$bulanRomawi."/".$tahun;
        return trim($noDokMedis);
	}
	/**
	* Fungsi Untuk Mengenerate No Verifikasi Tindakan secara Otomatis
	* @return string 
	*/
    public static function noVerifikasiTindakan()
    {
		$default = "0001";
        $prefix = "VER".date('ymd');
        $sql = "SELECT CAST(MAX(SUBSTR(noverifikasi_renc,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
				FROM verifrenctindakan_t 
				WHERE noverifikasi_renc LIKE ('".$prefix."%')";
        $noVerifikasi = Yii::app()->db->createCommand($sql)->queryRow();
        $noVerifikasiBaru = $prefix.(isset($noVerifikasi['nomaksimal']) ? (str_pad($noVerifikasi['nomaksimal']+1, 4, 0,STR_PAD_LEFT)) : $default);
        return $noVerifikasiBaru;
    }
    
	/**
     * Generate nosuratrujukan untuk pasiendirujukkeluar_t
     * @return string 
     */
    public static function noSuratRujukanKeluar()
    {
        $tahun = date('Y');
        $sqlNoSurat = "SELECT MAX(nosuratrujukan) AS nosuratrujukan FROM pasiendirujukkeluar_t WHERE date_part('year', tgldirujuk)='".$tahun."'";
        $noSurat = Yii::app()->db->createCommand($sqlNoSurat)->queryRow();        
        $noSuratRujukan = str_pad($noSurat['nosuratrujukan']+1, STR_PAD_LEFT)."/BP5000/".$tahun."-S1";
        return trim($noSuratRujukan);
    }
	
    /**
     * Generate pabrik_kode untuk pabrik_m
     * @return type
     */
    public static function kodePabrik()
    {
		$default = "0001";
        $prefix = "PM"; // (Pharmacy Manufactory) LNG-1221
        $sql = "SELECT CAST(MAX(SUBSTR(pabrik_kode,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
				FROM pabrik_m 
				WHERE pabrik_kode LIKE ('".$prefix."%')";
        $kodePabrik = Yii::app()->db->createCommand($sql)->queryRow();
        $kodepabrik_baru = $prefix.(isset($kodePabrik['nomaksimal']) ? (str_pad($kodePabrik['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $kodepabrik_baru;
    }
	
    /**
     * Generate rencanggaranpeng_no untuk rencanggaranpeng_t
     * @return string 
     */
    public static function noRencAnggPeng()
    {
		$default = "000001";
        $prefix = "RAPNG".date('Y');
        $sql = "SELECT CAST(MAX(SUBSTR(rencanggaranpeng_no,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
				FROM rencanggaranpeng_t 
				WHERE rencanggaranpeng_no LIKE ('".$prefix."%')";
        $noRencAnggPeng = Yii::app()->db->createCommand($sql)->queryRow();
        $noRencAnggPeng_baru = $prefix.(isset($noRencAnggPeng['nomaksimal']) ? (str_pad($noRencAnggPeng['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $noRencAnggPeng_baru;
		
    }  
	
    /**
     * Generate noren_penerimaan untuk renanggpenerimaan_t
     * @return string 
     */
    public static function noRencAnggPen()
    {
		$default = "000001";
        $prefix = "RAPNR".date('Y');
        $sql = "SELECT CAST(MAX(SUBSTR(noren_penerimaan,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
				FROM renanggpenerimaan_t 
				WHERE noren_penerimaan LIKE ('".$prefix."%')";
        $noRencAnggPen = Yii::app()->db->createCommand($sql)->queryRow();
        $noRencAnggPen_baru = $prefix.(isset($noRencAnggPen['nomaksimal']) ? (str_pad($noRencAnggPen['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $noRencAnggPen_baru;
		
    }
	
	/**
     * Generate nosimulasianggaran untuk simulasianggaran_t
     * @return string
     */
    public static function noSimulasiAnggaran()
    {
        $default = "000001";
        $prefix = "SIMAG".date('Y');
        $sql = "SELECT CAST(MAX(SUBSTR(nosimulasianggaran,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
				FROM simulasianggaran_t 
				WHERE nosimulasianggaran LIKE ('".$prefix."%')";
		$noSimulasiRes = Yii::app()->db->createCommand($sql)->queryRow();
        $noSimulasiBaru = $prefix.(isset($noSimulasiRes['nomaksimal']) ? (str_pad($noSimulasiRes['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $noSimulasiBaru;
	}
	
    /**
     * Generate no_realisasi_peng untuk realisasianggpeng_t
     * @return string 
     */
    public static function noReaAnggPeng()
    {
		$default = "000001";
        $prefix = "REAPNG".date('Ym');
        $sql = "SELECT CAST(MAX(SUBSTR(no_realisasi_peng,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
				FROM realisasianggpeng_t 
				WHERE no_realisasi_peng LIKE ('".$prefix."%')";
        $noReaAnggPeng = Yii::app()->db->createCommand($sql)->queryRow();
        $noReaAnggPeng_baru = $prefix.(isset($noReaAnggPeng['nomaksimal']) ? (str_pad($noReaAnggPeng['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $noReaAnggPeng_baru;
		
    }
	
	/**
	 * Generate no_alokasi untuk alokasianggaran_t
	 * @return string
	 */
	public static function noAlokasiAnggaran(){
		$default = "000001";
        $prefix = "ALOAG".date('Y');
        $sql = "SELECT CAST(MAX(SUBSTR(no_alokasi,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
				FROM alokasianggaran_t 
				WHERE no_alokasi LIKE ('".$prefix."%')";
        $noAlokasiAnggaran = Yii::app()->db->createCommand($sql)->queryRow();
        $noAlokasiAnggaran_baru = $prefix.(isset($noAlokasiAnggaran['no']) ? (str_pad($noAlokasiAnggaran['no']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $noAlokasiAnggaran_baru;
		
	}
	
	/**
	 * Generate norencanadiklat untuk rencanadiklat_t
	 * @return string
	 */
	public static function noRencanaDiklat(){
		$default = "001";
        $prefix = "RENPEL".date('Ym');
        $sql = "SELECT CAST(MAX(SUBSTR(norencanadiklat,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
				FROM rencanadiklat_t 
				WHERE norencanadiklat LIKE ('".$prefix."%')";
        $noRencanaDiklat = Yii::app()->db->createCommand($sql)->queryRow();
        $noRencanaDiklat_baru = $prefix.(isset($noRencanaDiklat['nomaksimal']) ? (str_pad($noRencanaDiklat['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $noRencanaDiklat_baru;
		
	}
	
	/**
	* Fungsi Untuk Mengenerate No Pemanggilan MCU secara Otomatis
	* @return string 
	*/
    public static function noPemanggilanMcu()
    {
		$default = "0001";
        $prefix = "MCU".date('ymd');
        $sql = "SELECT CAST(MAX(SUBSTR(no_pemanggilan,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
				FROM pemanggilanmcu_t 
				WHERE no_pemanggilan LIKE ('".$prefix."%')";
        $noPemanggilan = Yii::app()->db->createCommand($sql)->queryRow();
        $noPemanggilanBaru = $prefix.(isset($noPemanggilan['nomaksimal']) ? (str_pad($noPemanggilan['nomaksimal']+1, 4, 0,STR_PAD_LEFT)) : $default);
        return $noPemanggilanBaru;
    }
	
	/**
	* Fungsi Untuk Mengenerate No Verifikasi Berkas MCU secara Otomatis
	* @return string 
	*/
    public static function noVerifikasiBerkasMcu()
    {
		$default = "0001";
        $prefix = "VER".date('ymd');
        $sql = "SELECT CAST(MAX(SUBSTR(noverifkasiberkasmcu,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
				FROM verifikasiberkasmcu_t 
				WHERE noverifkasiberkasmcu LIKE ('".$prefix."%')";
        $noVerifikasi = Yii::app()->db->createCommand($sql)->queryRow();
        $noVerifikasiBaru = $prefix.(isset($noVerifikasi['nomaksimal']) ? (str_pad($noVerifikasi['nomaksimal']+1, 4, 0,STR_PAD_LEFT)) : $default);
        return $noVerifikasiBaru;
    }
	
	/**
	* Fungsi Untuk Mengenerate No Perawatan Linen
	* @return string 
	*/
    public static function noPerawatanLinen()
    {
		$default = "0001";
        $prefix = "PWL".date('ymd');
        $sql = "SELECT CAST(MAX(SUBSTR(noperawatan,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
				FROM perawatanlinen_t 
				WHERE noperawatan LIKE ('".$prefix."%')";
        $noPerawatan = Yii::app()->db->createCommand($sql)->queryRow();
        $noPerawatanBaru = $prefix.(isset($noPerawatan['nomaksimal']) ? (str_pad($noPerawatan['nomaksimal']+1, 4, 0,STR_PAD_LEFT)) : $default);
        return $noPerawatanBaru;
    }
	
	/**
	* Fungsi Untuk Mengenerate No Pengiriman Linen
	* @return string 
	*/
    public static function noPengirimanLinen()
    {
		$default = "0001";
        $prefix = "KRM".date('ymd');
        $sql = "SELECT CAST(MAX(SUBSTR(nopengirimanlinen,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
				FROM pengirimanlinen_t 
				WHERE nopengirimanlinen LIKE ('".$prefix."%')";
        $noPengiriman = Yii::app()->db->createCommand($sql)->queryRow();
        $noPengirimanBaru = $prefix.(isset($noPengiriman['nomaksimal']) ? (str_pad($noPengiriman['nomaksimal']+1, 4, 0,STR_PAD_LEFT)) : $default);
        return $noPengirimanBaru;
	}
	
    /**
     * Generate nopenyusutanaset untuk penyusutanaset_t
     * @return string 
     */
    public static function noPenyusutanAset()
    {
		$default="0001";
        $prefix = 'ST'.date('ymd');
		$sql = "SELECT CAST(MAX(SUBSTR(no_penyusutan,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal 
				FROM penyusutanaset_t 
				WHERE no_penyusutan LIKE ('".$prefix."%')";
        $penyusutanAset = Yii::app()->db->createCommand($sql)->queryRow();
        $no_retur_baru =$prefix.(isset($penyusutanAset['nomaksimal']) ? (str_pad($penyusutanAset['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $no_retur_baru;
    }
	
    /**
     * Generate noregisterlinen untuk linen_m
     * @return string 
     */
    public static function noRegisterLinen()
    {
		$default="0001";
        $prefix = 'RL'.date('ymd');
		$sql = "SELECT CAST(MAX(SUBSTR(noregisterlinen,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal 
				FROM linen_m 
				WHERE noregisterlinen LIKE ('".$prefix."%')";
        $registerLinen = Yii::app()->db->createCommand($sql)->queryRow();
        $no_retur_baru =$prefix.(isset($registerLinen['nomaksimal']) ? (str_pad($registerLinen['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $no_retur_baru;
    }
	
    /**
     * Generate noregisterlinen untuk pengperawatanlinen_t
     * @return string 
     */
    public static function noPengPerawatanLinen()
    {
		$default="0001";
        $prefix = 'PPL'.date('ymd');
		$sql = "SELECT CAST(MAX(SUBSTR(pengperawatanlinen_no,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal 
				FROM pengperawatanlinen_t 
				WHERE pengperawatanlinen_no LIKE ('".$prefix."%')";
        $pengPerawatanLinen = Yii::app()->db->createCommand($sql)->queryRow();
        $no_retur_baru =$prefix.(isset($pengPerawatanLinen['nomaksimal']) ? (str_pad($pengPerawatanLinen['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $no_retur_baru;
    }    
	
    /**
     * Generate nopenerimaanlinen untuk penerimaanlinen_t
     * @return string 
     */
    public static function noPenerimaanLinen()
    {
		$default="0001";
        $prefix = 'PL'.date('ymd');
		$sql = "SELECT CAST(MAX(SUBSTR(nopenerimaanlinen,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal 
				FROM penerimaanlinen_t 
				WHERE nopenerimaanlinen LIKE ('".$prefix."%')";
        $penerimaanLinen = Yii::app()->db->createCommand($sql)->queryRow();
        $no_retur_baru =$prefix.(isset($penerimaanLinen['nomaksimal']) ? (str_pad($penerimaanLinen['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $no_retur_baru;
    }
	
	/**
     * Generate nopencucianlinen untuk pencucianlinen_t
     * @return string 
     */
    public static function noPencucianLinen()
    {
		$default="0001";
        $prefix = 'PCL'.date('ymd');
		$sql = "SELECT CAST(MAX(SUBSTR(nopencucianlinen,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal 
				FROM pencucianlinen_t 
				WHERE nopencucianlinen LIKE ('".$prefix."%')";
        $noPencucian = Yii::app()->db->createCommand($sql)->queryRow();
        $noPencucianBaru =$prefix.(isset($noPencucian['nomaksimal']) ? (str_pad($noPencucian['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $noPencucianBaru;
    }
	
	/**
     * Generate nopenyimpananlinen untuk penyimpananlinen_t
     * @return string 
     */
    public static function noPenyimpananLinen()
    {
		$default="0001";
        $prefix = 'PYL'.date('ymd');
		$sql = "SELECT CAST(MAX(SUBSTR(nopenyimpamanlinen,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal 
				FROM penyimpananlinen_t 
				WHERE nopenyimpamanlinen LIKE ('".$prefix."%')";
        $noPenyimpanan = Yii::app()->db->createCommand($sql)->queryRow();
        $noPenyimpananBaru =$prefix.(isset($noPenyimpanan['nomaksimal']) ? (str_pad($noPenyimpanan['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $noPenyimpananBaru;
    }
	
    /**
     * Generate nopenerimaanlinen untuk penlinenruangan_t
     * @return string 
     */
    public static function noPenerimaanLinenR()
    {
		$default="0001";
        $prefix = 'PLR'.date('ymd');
		$sql = "SELECT CAST(MAX(SUBSTR(nopenlinenruangan,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal 
				FROM penlinenruangan_t 
				WHERE nopenlinenruangan LIKE ('".$prefix."%')";
        $penLinenRuangan = Yii::app()->db->createCommand($sql)->queryRow();
        $noPenerimaanLinenBaru =$prefix.(isset($penLinenRuangan['nomaksimal']) ? (str_pad($penLinenRuangan['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $noPenerimaanLinenBaru;
	}
	
    /**
     * Generate pengajuansterlilisasi_no untuk pengajuansterlilisasi_t
     * @return string 
     */
    public static function noPengSterilisasi()
    {
		$default="0001";
        $prefix = 'PSTR'.date('ymd');
		$sql = "SELECT CAST(MAX(SUBSTR(pengajuansterlilisasi_no,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal 
				FROM pengajuansterlilisasi_t 
				WHERE pengajuansterlilisasi_no LIKE ('".$prefix."%')";
        $pengSteril = Yii::app()->db->createCommand($sql)->queryRow();
        $noPengSterilBaru =$prefix.(isset($pengSteril['nomaksimal']) ? (str_pad($pengSteril['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $noPengSterilBaru;
	}
	
    /**
     * Generate pesanperlinensteril_no untuk pesanperlinensteril_t
     * @return string 
     */
    public static function noPesanSterilisasi()
    {
		$default="0001";
        $prefix = 'PESTR'.date('ymd');
		$sql = "SELECT CAST(MAX(SUBSTR(pesanperlinensteril_no,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal 
				FROM pesanperlinensteril_t 
				WHERE pesanperlinensteril_no LIKE ('".$prefix."%')";
        $pesSteril = Yii::app()->db->createCommand($sql)->queryRow();
        $noPesSterilBaru =$prefix.(isset($pesSteril['nomaksimal']) ? (str_pad($pesSteril['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $noPesSterilBaru;
	}
	
    /**
     * Generate penerimaansterilisasi_no untuk penerimaansterilisasi_t
     * @return string 
     */
    public static function noPenerimaanSteril()
    {
		$default="0001";
        $prefix = 'PRSTR'.date('ymd');
		$sql = "SELECT CAST(MAX(SUBSTR(penerimaansterilisasi_no,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal 
				FROM penerimaansterilisasi_t 
				WHERE penerimaansterilisasi_no LIKE ('".$prefix."%')";
        $penSteril = Yii::app()->db->createCommand($sql)->queryRow();
        $noPenSterilBaru =$prefix.(isset($penSteril['nomaksimal']) ? (str_pad($penSteril['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $noPenSterilBaru;
	}
	
	/**
     * Generate dekontaminasi_no untuk dekontaminasi_t
     * @return string 
     */
    public static function noDekontaminasi()
    {
		$default="0001";
        $prefix = 'DK'.date('ymd');
		$sql = "SELECT CAST(MAX(SUBSTR(dekontaminasi_no,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal 
				FROM dekontaminasi_t 
				WHERE dekontaminasi_no LIKE ('".$prefix."%')";
        $noDekontaminasi = Yii::app()->db->createCommand($sql)->queryRow();
        $noDekontaminasiBaru =$prefix.(isset($noDekontaminasi['nomaksimal']) ? (str_pad($noDekontaminasi['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $noDekontaminasiBaru;
    }
	
	/**
     * Generate sterilisasi_no untuk sterilisasi_t
     * @return string 
     */
    public static function noSterilisasi()
    {
		$default="0001";
        $prefix = 'STR'.date('ymd');
		$sql = "SELECT CAST(MAX(SUBSTR(sterilisasi_no,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal 
				FROM sterilisasi_t 
				WHERE sterilisasi_no LIKE ('".$prefix."%')";
        $noSterilisasi = Yii::app()->db->createCommand($sql)->queryRow();
        $noSterilisasiBaru =$prefix.(isset($noSterilisasi['nomaksimal']) ? (str_pad($noSterilisasi['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $noSterilisasiBaru;
	}
	
    /** Generate terimaperlinensteril_no untuk terimaperlinensteril_t
     * @return string 
     */
    public static function noPenerimaanSterilRuangan()
    {
		$default="0001";
        $prefix = 'PSR'.date('ymd');
		$sql = "SELECT CAST(MAX(SUBSTR(terimaperlinensteril_no,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal 
				FROM terimaperlinensteril_t 
				WHERE terimaperlinensteril_no LIKE ('".$prefix."%')";
        $noPenerimaan = Yii::app()->db->createCommand($sql)->queryRow();
        $noPenerimaanBaru =$prefix.(isset($noPenerimaan['nomaksimal']) ? (str_pad($noPenerimaan['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $noPenerimaanBaru;
    }
	
	/**
     * Generate kirimperlinensteril_no untuk kirimperlinensteril_t
     * @return string 
     */
    public static function noKirimSterilisasi()
    {
		$default="0001";
        $prefix = 'KRMSTR'.date('ymd');
		$sql = "SELECT CAST(MAX(SUBSTR(kirimperlinensteril_no,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal 
				FROM kirimperlinensteril_t 
				WHERE kirimperlinensteril_no LIKE ('".$prefix."%')";
        $noKirimSteril = Yii::app()->db->createCommand($sql)->queryRow();
        $noKirimSterilBaru =$prefix.(isset($noKirimSteril['nomaksimal']) ? (str_pad($noKirimSteril['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $noKirimSterilBaru;
    }
	
	/**
     * Generate penyimpanansteril_no untuk penyimpanansteril_t
     * @return string 
     */
    public static function noPenyimpananSteril()
    {
		$default="0001";
        $prefix = 'PNSTR'.date('ymd');
		$sql = "SELECT CAST(MAX(SUBSTR(penyimpanansteril_no,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal 
				FROM penyimpanansteril_t 
				WHERE penyimpanansteril_no LIKE ('".$prefix."%')";
        $noPenyimpananSteril = Yii::app()->db->createCommand($sql)->queryRow();
        $noPenyimpananSterilBaru =$prefix.(isset($noPenyimpananSteril['nomaksimal']) ? (str_pad($noPenyimpananSteril['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $noPenyimpananSterilBaru;
	}
	
	/**
     * Generate pemeliharaanaset_no untuk pemeliharaanaset_t
     * @return string 
     */
    public static function noPemeliharaanAset()
    {
		$default="0001";
        $prefix = 'PMAST'.date('ymd');
		$sql = "SELECT CAST(MAX(SUBSTR(pemeliharaanaset_no,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal 
				FROM pemeliharaanaset_t 
				WHERE pemeliharaanaset_no LIKE ('".$prefix."%')";
        $noPemeliharaan = Yii::app()->db->createCommand($sql)->queryRow();
        $noPemeliharaanBaru =$prefix.(isset($noPemeliharaan['nomaksimal']) ? (str_pad($noPemeliharaan['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $noPemeliharaanBaru;
	}	
	
	/**
     * Generate rekonsiliasibank_no untuk rekonsiliasibank_t
     * @return string 
     */
    public static function noRekonsiliasiBank()
    {
		$default="0001";
        $prefix = 'REKBANK'.date('ymd');
		$sql = "SELECT CAST(MAX(SUBSTR(rekonsiliasibank_no,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal 
				FROM rekonsiliasibank_t 
				WHERE rekonsiliasibank_no LIKE ('".$prefix."%')";
        $noRekonsiliasi = Yii::app()->db->createCommand($sql)->queryRow();
        $noRekonsiliasiBaru =$prefix.(isset($noRekonsiliasi['nomaksimal']) ? (str_pad($noRekonsiliasi['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $noRekonsiliasiBaru;
	}	
	
	/**
     * Generate norenpengembalian untuk renpengembalianed_t
     * @return string 
     */
    public static function noRenPengemED()
    {
		$default="0001";
        $prefix = 'RENPENG'.date('ymd');
		$sql = "SELECT CAST(MAX(SUBSTR(norenpengembalian,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal 
				FROM renpengembalianed_t 
				WHERE norenpengembalian LIKE ('".$prefix."%')";
        $noRenPengemED = Yii::app()->db->createCommand($sql)->queryRow();
        $noRenPengemEDBaru =$prefix.(isset($noRenPengemED['nomaksimal']) ? (str_pad($noRenPengemED['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $noRenPengemEDBaru;
	}	
	
	/**
     * Generate no_pembuatanjadwal untuk penjadwalan_t
     * @return string 
     */
    public static function noPenjadwalanPegawai()
    {
		$default="0001";
        $prefix = 'PP'.date('ymd');
		$sql = "SELECT CAST(MAX(SUBSTR(no_pembuatanjadwal,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal 
				FROM penjadwalan_t 
				WHERE no_pembuatanjadwal LIKE ('".$prefix."%')";
        $noPenjadwalan = Yii::app()->db->createCommand($sql)->queryRow();
        $noPenjadwalanBaru =$prefix.(isset($noPenjadwalan['nomaksimal']) ? (str_pad($noPenjadwalan['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $noPenjadwalanBaru;
	}
	
	/**
     * Generate no_permohonanpertukaran untuk pertukaranjadwal_t
     * @return string 
     */
    public static function noPertukaranJadwal()
    {
		$default="0001";
        $prefix = 'PJ'.date('ymd');
		$sql = "SELECT CAST(MAX(SUBSTR(no_permohonanpertukaran,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal 
				FROM pertukaranjadwal_t 
				WHERE no_permohonanpertukaran LIKE ('".$prefix."%')";
        $noPertukaranJadwal = Yii::app()->db->createCommand($sql)->queryRow();
        $noPertukaranJadwalBaru =$prefix.(isset($noPertukaranJadwal['nomaksimal']) ? (str_pad($noPertukaranJadwal['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $noPertukaranJadwalBaru;
	}
	/**
     * Generate noproduksiobt untuk produksiobat_t
     * @return string 
     */
	public static function noProduksiObat()
    {
		$default = "0001";
        $prefix = "PO"; //
        $sql = "SELECT CAST(MAX(SUBSTR(noproduksiobt,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
				FROM produksiobat_t 
				WHERE noproduksiobt LIKE ('".$prefix."%')";
        $noproduksi = Yii::app()->db->createCommand($sql)->queryRow();
        $noproduksi_baru = $prefix.(isset($noproduksi['nomaksimal']) ? (str_pad($noproduksi['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $noproduksi_baru;
    }
	/**
     * Generate nopemakaian_obat untuk pemakaianobat_t
     * @return string 
     */
	public static function noPemakaianObat()
    {
		$default = "001";
        $prefix = "PKOB".date('ymd'); //
        $sql = "SELECT CAST(MAX(SUBSTR(nopemakaian_obat,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
				FROM pemakaianobat_t 
				WHERE nopemakaian_obat LIKE ('".$prefix."%')";
        $nopemakaian = Yii::app()->db->createCommand($sql)->queryRow();
        $nopemakaian_baru = $prefix.(isset($nopemakaian['nomaksimal']) ? (str_pad($nopemakaian['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $nopemakaian_baru;
    }
	/**
     * Generate lookup_kode, lookup_type = 'satuanbarang' untuk lookup_m
     * @return string 
     */
	public static function kodeSatuanBarang()
    {
		$default = "0001";
        $prefix = "STBR";
        $sql = "SELECT CAST(MAX(SUBSTR(lookup_kode,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
				FROM lookup_m 
				WHERE lookup_kode LIKE ('".$prefix."%') AND lookup_type = 'satuanbarang'";
        $kode = Yii::app()->db->createCommand($sql)->queryRow();
        $kode_baru = $prefix.(isset($kode['nomaksimal']) ? (str_pad($kode['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $kode_baru;
    }
	
	/**
     * Generate obatalkes_kode untuk obatalkes_m
     * @return string 
     */
	public static function kodeObatAlkes($prefix)
    {
		$default = "0001";
        $sql = "SELECT CAST(MAX(SUBSTR(obatalkes_kode,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
				FROM obatalkes_m 
				WHERE obatalkes_kode LIKE ('".$prefix."%')";
        $kode = Yii::app()->db->createCommand($sql)->queryRow();
        $kode_baru = $prefix.(isset($kode['nomaksimal']) ? (str_pad($kode['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $kode_baru;
    }
    
    public static function kodeSubSubKelompokBarang($subsubkelompok_id)
    {		
        $sql = "SELECT  subsubkelompok_kode 
				FROM subsubkelompok_m
				WHERE subsubkelompok_id = '$subsubkelompok_id' ";
        $kode = Yii::app()->db->createCommand($sql)->queryRow();                
        $kode_baru = $kode['subsubkelompok_kode'];
        return $kode_baru;
    }
    
    /**
     * Generate invbarang_no untuk invbarang_t
     * @return string 
     */
    public static function noInventarisasiBarang()
    {
		$default="0001";
        $prefix = 'INVBRG'.date('ymd');
		$sql = "SELECT CAST(MAX(SUBSTR(invbarang_no,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal 
				FROM invbarang_t 
				WHERE invbarang_no LIKE ('".$prefix."%')";
        $noInvBrg = Yii::app()->db->createCommand($sql)->queryRow();
        $noInvBrgBaru =$prefix.(isset($noInvBrg['nomaksimal']) ? (str_pad($noInvBrg['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $noInvBrgBaru;
    }
    
    /**
     * Generate forminvbarang_no untuk formulirinvbarang_r
     * @return string 
     */
    public static function noFormInventarisasiBarang()
    {
		$default="0001";
        $prefix = 'FORMINVBRG'.date('ymd');
		$sql = "SELECT CAST(MAX(SUBSTR(forminvbarang_no,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal 
				FROM formulirinvbarang_r 
				WHERE forminvbarang_no LIKE ('".$prefix."%')";
        $noFormInvBrg = Yii::app()->db->createCommand($sql)->queryRow();
        $noFormInvBrgBaru =$prefix.(isset($noFormInvBrg['nomaksimal']) ? (str_pad($noFormInvBrg['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
        return $noFormInvBrgBaru;
    }
}
?>
