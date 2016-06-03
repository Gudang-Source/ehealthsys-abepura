<?php
/**
 * Params berisi:
 * 1. Nilai default
 * 2. Nilai id yang di sesuaikan dengan tabel di database
 * 3. Nilai konstant
 * 4. Nilai konstant yang disesuaikan dengan lookup_m
 */
Class Params
{
	//=== NILAI DEFAULT ===
	//Merupakan konstanta yang diubah disesuaikan dengan kebutuhan di klien

	// DEFAULT CONST AUTHENTICATION 
	const DEFAULT_UPDATE = 'Update';
	const DEFAULT_CREATE = 'Create';
	const DEFAULT_DELETE = 'Delete';
	const DEFAULT_ADMIN = 'Admin';

	const DEFAULT_PROFIL_RUMAH_SAKIT = 1; //profilrumahsakit_m         

	const DEFAULT_RUANGAN_KIOSK= 2;           //pendaftaran rawat jalan
	const DEFAULT_RUANGAN_KIOSK_KASIR= 146;   //kasir sentral

	const DEFAULT_SESSION_INACTIVE = 1440;   //batas session (menit)                  

	const DEFAULT_KERTAS_UKURAN = 'A4';
	const DEFAULT_KERTAS_POSISI = 'P';

	const DEFAULT_KELASPELAYANAN_PENUNJANG = 6; //6 = Tanpa Kelas
	const DEFAULT_JENISKASUSPENYAKIT_PENUNJANG = 2; //2= Bedah
	
	const DEFAULT_WARGANEGARA = 'INDONESIA';
	const DEFAULT_AGAMA = 'ISLAM';

	const DEFAULT_PERDA_TARIF = 1;           

	const DEFAULT_STATUS_OPERASI = 'RENCANA';          

	const DEFAULT_KATEGORITINDAKAN_GIZI = 9; //ID KATEGORI TINDAKAN = MAKANAN GIZI;
        const DEFAULT_KELOMPOKTINDAKAN_GIZI = 23;

	const DEFAULT_PASIEN_APOTEK_UMUM = 2;//id pasien untuk apotek - penjualan umum NOREKAM: AP000002
	const DEFAULT_PASIEN_APOTEK_KARYAWAN = 3;//id pasien untuk apotek - penjualan karyawan NOREKAM: AP000003
	const DEFAULT_PASIEN_APOTEK_DOKTER = 4;//id pasien untuk apotek - penjualan dokter NOREKAM: AP000004
	const DEFAULT_PASIEN_APOTEK_UNIT = 5;//id pasien untuk apotek - penjualan unit NOREKAM: AP000005
	const DEFAULT_PASIEN_APOTEK_SOSIAL = 6;//id pasien untuk apotek - penjualan unit NOREKAM: AP000005
	
	const DEFAULT_SATUANBESAR_ID = 4; //4 = BOX

	//=== END DEFAULT ===

	//=== KONSTANTA ===
	//Merupakan konstanta yang diubah disesuaikan dengan data yang di database atau yang digunakan pada aplikasi tertentu

	const LOGINPEMAKAI_ID_ADMIN = 1; // loginpemakai_id admin
	const PERANPENGGUNA_ID_ADMIN = 1; // peranpengguna_k administrator
	
	const DATE_FORMAT = 'dd M yy';      //format default date untuk datepicker
	const TIME_FORMAT = 'H:i:s';        //format default time untuk datepicker
	const MONTH_FORMAT = 'M yy';		//format untuk monthpicker

	const TOOLTIP_PLACEMENT = 'bottom';                 //nilai konstanta tooltip placement untuk bootstrap tooltip
	const TOOLTIP_SELECTOR = 'a[rel="tooltip"],button[rel="tooltip"],input[rel="tooltip"]';        //nilai konstanta tooltip selector untuk bootstrap tooltip

	const CARABAYAR_ID_MEMBAYAR = 1; 
	const CARABAYAR_ID_BPJS = 4; 
	const CARABAYAR_ID_BADAK = 5; 
	const CARABAYAR_ID_DEP_BADAK = 6; 
	const CARABAYAR_ID_PEKERJA = 7; 
	const CARABAYAR_ID_GRATIS = 8; 
	const CARABAYAR_ID_PERUSAHAAN = 9; 
        const CARABAYAR_ID_JAMKESPA = 18;

	
	const MODUL_ID_SISADMIN = 1;
        const MODUL_ID_PENDAFTARAN = 2;
	const MODUL_ID_RJ = 5;
	const MODUL_ID_RD = 6;
	const MODUL_ID_RI = 7;
	const MODUL_ID_LAB = 8;
	const MODUL_ID_RAD = 9;
	const MODUL_ID_APOTEK = 10;
	const MODUL_ID_BEDAHSENTRAL = 11;
	const MODUL_ID_REHABMEDIS = 13;
	const MODUL_ID_JENAZAH = 14;
	const MODUL_ID_GIZI = 15;
	const MODUL_ID_GUDANGFARMASI = 16;
	const MODUL_ID_GUDANGUMUM = 17;
	const MODUL_ID_AMBULANS = 18;
	const MODUL_ID_AKUNTANSI = 26;
	const MODUL_ID_KEUANGAN = 44;
        const MODUL_ID_PENGGAJIAN = 61;

        const INSTALASI_ID_RM = 1;
	const INSTALASI_ID_RJ = 2;
	const INSTALASI_ID_RD = 3;
	const INSTALASI_ID_RI = 4;
	const INSTALASI_ID_LAB = 5;           
	const INSTALASI_ID_RAD = 6;           
	const INSTALASI_ID_IBS = 7;           
	const INSTALASI_ID_REHAB = 8;           
	const INSTALASI_ID_FARMASI = 9;
	const INSTALASI_ID_GIZI = 10;          
	const INSTALASI_ID_JZ = 17; 
	const INSTALASI_ID_AMBULAN = 40;     
	const INSTALASI_ID_KASIR = 41;     
	const INSTALASI_ID_LOGISTIK = 44;     
        const INSTALASI_ID_ICU = 20;

	const KASUSDIAGNOSA_KASUS_LAMA = "KASUS LAMA";
	const KASUSDIAGNOSA_KASUS_BARU = "KASUS BARU";
	 
	const HARGAYGDIGUNAKAN_PENYESUAIAN = 'PENYESUAIAN'; //lookup_m lookup_type = 'hargaygdigunakan'
	const HARGAYGDIGUNAKAN_MAX = 'MAKSIMUM'; //lookup_m lookup_type = 'hargaygdigunakan'
	const HARGAYGDIGUNAKAN_MIN = 'MINIMUM'; //lookup_m lookup_type = 'hargaygdigunakan'
	const HARGAYGDIGUNAKAN_AVG = 'RATA-RATA'; //lookup_m lookup_type = 'hargaygdigunakan'
	const HARGAYGDIGUNAKAN_TERAKHIR = 'TERAKHIR'; //lookup_m lookup_type = 'hargaygdigunakan'

	const KOMPONENTARIF_ID_TOTAL = 6;  
        const KOMPONENTARIF_ID_PELAYANAN = 24;
	
	const KOMPONENUNIT_ID_GIZI = 23; // komponenunit_id untuk konsultasi gizi 

	const RUANGAN_ID_AMBULANCE = 64;
	const RUANGAN_ID_APOTEK_1 = 59; 
        const RUANGAN_ID_APOTEK_RJ = 60;
	const RUANGAN_ID_BEDAH = 57;               
	const RUANGAN_ID_FISIOTERAPI = 90;      
	const RUANGAN_ID_GIZI = 62;         
	const RUANGAN_ID_GUDANG_FARMASI = 58;
        const RUANGAN_ID_GUDANG_UMUM = 222;
	const RUANGAN_ID_KLINIK_MCU = 25;		//Ruangan Klinik MCU
	const RUANGAN_ID_LAB = 52;         //digunakan jika ruangan lab klinik & anatomi di non-aktifkan
	const RUANGAN_ID_LAB_KLINIK = 53;  
	const RUANGAN_ID_LAB_ANATOMI = 54; 
	const RUANGAN_ID_PERINATOLOGI = 157;   
	const RUANGAN_ID_RAD = 56;         
	const RUANGAN_ID_STERILISASI = 223;     
	const RUANGAN_ID_LAUNDRY = 226;     
        const RUANGAN_ID_KASIR = 66;
        const RUANGAN_ID_LOKET = 2;
        const RUANGAN_ID_KEBIDANAN = 13;

	const KELASPELAYANAN_ID_TANPA_KELAS = 6;
        const KELASPELAYANAN_ID_KELAS_III = 4;
        const KELASPELAYANAN_ID_VIP = 2;
        
	const PENJAMIN_ID_UMUM = 1;
	const PENJAMIN_ID_GRATIS = 96;
	
	const PENJAMIN_ID_PISA = 34; // LNG-3
	const PENJAMIN_ID_PROKESPEN = 100; // LNG-3

	const DAFTARTINDAKAN_ID_KONSUL = 101; //id untuk karcis tindakan konsul

	const JENISJURNAL_ID_PENERIMAAN_KAS= 1;
	const JENISJURNAL_ID_PENGELUARAN_KAS = 2;
	const JENISJURNAL_ID_PEMBELIAN = 3;
	const JENISJURNAL_ID_PELAYANAN = 4;
	const JENISJURNAL_ID_PENJUALAN = 5;
	const JENISJURNAL_ID_UMUM = 6;
	const JENISJURNAL_ID_PENYUSUTAN = 12;
	
	const JENISPENGELUARAN_ID_PENGGAJIAN = 2; //id untuk jenispengeluaran penggajian pegawai

        const JENISOBATALKES_ID_GASMEDIS = 11;
        
	const KOMPONENGAJI_ID_PINJAMAN = 9;

	const CARAMASUK_ID_LANGSUNG_RI = 1;          //id untuk cara masuk langsung rawat inap
	const CARAMASUK_ID_RD = 2;          //id untuk cara masuk melalui rawat darurat
	const CARAMASUK_ID_RJ = 3;          //id untuk cara masuk melalui rawat jalan

	const TIPEPAKET_ID_NONPAKET = 1;       //id tipe paket non paket
	const TIPEPAKET_ID_LUARPAKET = 2;       //id tipe paket luar paket
	
	const PATOLOGI_KLINIK = 'PATOLOGI KLINIK';
	const PATOLOGI_ANATOMI = 'PATOLOGI ANATOMI';
	const JUMLAH_PERHALAMAN = 5;

	const RACIKAN_ID_RACIKAN = 1;           
	const RACIKAN_ID_NONRACIKAN = 2;       

	const SUPPLIER_JENIS_FARMASI = 'Farmasi';
	const SUPPLIER_JENIS_GIZI = 'Gizi';

	const JENISSTOKOPNAME_PENYESUAIAN = 'Penyesuaian';

	const IP_FINGER_PRINT = '192.168.1.201';

	const KEY_FINGER_PRINT ='123';
	
	const KONFIG_FIFO = TRUE; //jika false = LIFO (Last In First Out)

	const ALIAS = ' alias ';

	/*
	 * Konstanta Yang Disesuaikan dengan lookup_m
	 * format params: LOOKUPTYPE_LOOKUPVALUE
	 */
	const CARAKELUAR_DIRUJUK = 'DIRUJUK';  //disesuaikan dengan lookup_m.lookup_type = carakeluar         
	const CARAKELUAR_RAWATINAP = 'DIRAWAT INAP'; //disesuaikan dengan lookup_m.lookup_type = carakeluar
	const CARAKELUAR_MENINGGAL = 'MENINGGAL'; //disesuaikan dengan lookup_m.lookup_type = carakeluar

	const CARAKELUAR_ID_DIPULANGKAN     = 1;  //carakeluar_m
	const CARAKELUAR_ID_DIRUJUK         = 2;  //carakeluar_m
	const CARAKELUAR_ID_PULANGPAKSA     = 3;  //carakeluar_m
	const CARAKELUAR_ID_MENINGGAL       = 4;  //carakeluar_m
	const CARAKELUAR_ID_RAWATINAP       = 5;  //carakeluar_m
	const CARAKELUAR_ID_LAINLAIN        = 6;  //carakeluar_m
	const CARAKELUAR_ID_MELARIKANDIRI   = 7;  //carakeluar_m



	const CARAPEMBAYARAN_TUNAI = "TUNAI"; //disesuaikan dengan lookup_m.lookup_type = carapembayaran
	const CARAPEMBAYARAN_CICILAN = "CICILAN"; //disesuaikan dengan lookup_m.lookup_type = carapembayaran
	const CARAPEMBAYARAN_HUTANG = "HUTANG"; //disesuaikan dengan lookup_m.lookup_type = carapembayaran
	const CARAPEMBAYARAN_PIUTANG = "PIUTANG"; //disesuaikan dengan lookup_m.lookup_type = carapembayaran

	const STATUSBOOKING_NON_ANTRI = 'NON ANTRI'; //disesuaikan dengan lookup_m.lookup_type = statusbooking

	const KETERANGANKAMAR_DIPESAN = 'DIPESAN'; //disesuaikan dengan lookup_m.lookup_type = keterangankamar

	const STATUSPERIKSA_RUJUKAN = 'RUJUKAN'; //disesuaikan dengan lookup_m.lookup_type = statusperiksa
	const STATUSPERIKSA_ANTRIAN = 'ANTRIAN'; //disesuaikan dengan lookup_m.lookup_type = statusperiksa
	const STATUSPERIKSA_SEDANG_PERIKSA = 'SEDANG PERIKSA'; //disesuaikan dengan lookup_m.lookup_type = statusperiksa
	const STATUSPERIKSA_SEDANG_DIRAWATINAP = 'SEDANG DIRAWAT INAP'; //disesuaikan dengan lookup_m.lookup_type = statusperiksa
	const STATUSPERIKSA_BATAL_PERIKSA = 'BATAL PERIKSA'; //disesuaikan dengan lookup_m.lookup_type = statusperiksa     
	const STATUSPERIKSA_SUDAH_DIPERIKSA = 'SUDAH DI PERIKSA'; //disesuaikan dengan lookup_m.lookup_type = statusperiksa
	const STATUSPERIKSA_SUDAH_PULANG = 'SUDAH PULANG'; //disesuaikan dengan lookup_m.lookup_type = statusperiksa
        const STATUSPERIKSA_NUNGGU_DAFTAR_SO = 'MENUNGGU DAFTAR DI LOKET SO';
        
	const STATUSPERIKSAHASIL_SUDAH = 'SUDAH'; //disesuaikan dengan lookup_m.lookup_type = statusperiksahasil
	const STATUSPERIKSAHASIL_BELUM = 'BELUM'; //disesuaikan dengan lookup_m.lookup_type = statusperiksahasil
	const STATUSPERIKSAHASIL_SEDANG = 'SEDANG'; //disesuaikan dengan lookup_m.lookup_type = statusperiksahasil

	const STATUSPASIEN_BARU = "PENGUNJUNG BARU"; //disesuaikan dengan lookup_m.lookup_type = statuspasien
	const STATUSPASIEN_LAMA = "PENGUNJUNG LAMA"; //disesuaikan dengan lookup_m.lookup_type = statuspasien

	const STATUSPASIEN_BARU_ANTRIAN = "BARU"; // untuk antrian pasien baru
	const STATUSPASIEN_LAMA_ANTRIAN = "LAMA"; // untuk antrian pasien lama

	const STATUSKUNJUNGAN_BARU = "KUNJUNGAN BARU";
	const STATUSKUNJUNGAN_LAMA = "KUNJUNGAN LAMA";

	const STATUSMASUK_RUJUKAN = "RUJUKAN"; //disesuaikan dengan lookup_m.lookup_type = statusmasuk
	const STATUSMASUK_NONRUJUKAN = "NON RUJUKAN"; //disesuaikan dengan lookup_m.lookup_type = statusmasuk

	const STATUSREKAMMEDIS_AKTIF = 'AKTIF'; //disesuaikan dengan lookup_m.lookup_type = statusrekamedis
	const STATUSREKAMMEDIS_NON_AKTIF = 'NON AKTIF'; //disesuaikan dengan lookup_m.lookup_type = statusrekamedis

	const STATUSPESAN_BIASA = 'BIASA'; //disesuaikan dengan lookup_m.lookup_type = statuspesan

	const STATUSKONFIRMASI_SUDAH = 'SUDAH DIKONFIRMASI'; 
	const STATUSKONFIRMASI_BELUM = 'BELUM DIKONFIRMASI'; 

	const STATUSKONFIRMASI_BOOKING_SUDAH = 'SUDAH KONFIRMASI'; //disesuaikan dengan lookup_m.lookup_type = statuskonfirmasi
	const STATUSKONFIRMASI_BOOKING_BELUM = 'BELUM KONFIRMASI'; //disesuaikan dengan lookup_m.lookup_type = statuskonfirmasi
	const STATUSKONFIRMASI_BOOKING_BATAL = 'BATAL BOOKING'; //disesuaikan dengan lookup_m.lookup_type = statuskonfirmasi

	const STATUSBAYAR_LUNAS = 'LUNAS'; 
	const STATUSBAYAR_BELUM_LUNAS = 'BELUM LUNAS'; 

	const STATUS_KEPUASAN_PUAS = "PUAS";                //untuk msurveypelayanan_t.status_kepuasan
	const STATUS_KEPUASAN_TIDAK_PUAS = "TIDAK PUAS";    //untuk msurveypelayanan_t.status_kepuasan

	const JENISSURVEY_WEBSITE = "WEBSITE";  //untuk msurveypelayanan_t.jenissurvey
	const JENISSURVEY_MOBILE = "MOBILE";    //untuk msurveypelayanan_t.jenissurvey
	const JENISSURVEY_SIMRS = "SIMRS";      //untuk msurveypelayanan_t.jenissurvey

	const KONDISIPULANG_MENINGGAL_1 = 'MENINGGAL < 48 JAM'; //disesuaikan dengan lookup_m.lookup_type = kondisipulang
	const KONDISIPULANG_MENINGGAL_2 = 'MENINGGAL > 48 JAM'; //disesuaikan dengan lookup_m.lookup_type = kondisipulang
	const KONDISIPULANG_RAWATINAP = 'RAWAT INAP'; //disesuaikan dengan lookup_m.lookup_type = kondisipulang

	const KONDISIKELUAR_ID_MENINGGAL_1 = 3; //kondisikeluar_m
	const KONDISIKELUAR_ID_MENINGGAL_2 = 4; //kondisikeluar_m
	const KONDISIKELUAR_ID_RAWATINAP = 2; //kondisikeluar_m

	const JENIS_KELAMIN_PEREMPUAN = 'PEREMPUAN';    //disesuaikan dengan lookup_m.lookup_type = jeniskelamin
	const JENIS_KELAMIN_LAKI_LAKI = 'LAKI-LAKI';    //disesuaikan dengan lookup_m.lookup_type = jeniskelamin

	const KELOMPOKDIAGNOSA_UTAMA = 2;   //nilai diagnosa utama pada kelompok diagnosa
	const KELOMPOKDIAGNOSA_MASUK = 1;   //nilai diagnosa utama pada kelompok diagnosa
	const KELOMPOKDIAGNOSA_TAMBAH = 3;   //nilai diagnosa utama pada kelompok diagnosa

	const KELOMPOKPEGAWAI_ID_TENAGA_MEDIK = 1; //kelompokpegawai_m ahli gizi
	const KELOMPOKPEGAWAI_ID_PARAMEDIS_KEPERAWATAN = 3; //kelompokpegawai_m ahli gizi
	const KELOMPOKPEGAWAI_ID_TENAGA_KEPERAWATAN = 2; //kelompokpegawai_m tenaga keperawatan
	const KELOMPOKPEGAWAI_ID_AHLI_GIZI = 16; //kelompokpegawai_m ahli gizi
	const KELOMPOKPEGAWAI_ID_TENAGA_LAB = 18; //kelompokpegawai_m tenaga lab (analis lab)
	const KELOMPOKPEGAWAI_ID_TENAGA_RAD = 22; //kelompokpegawai_m tenaga rad (radiografer)
	const KELOMPOKPEGAWAI_ID_BIDAN = 20; //kelompokpegawai_m bidan
	
	const KELOMPOKTINDAKAN_ID_GIZI	= 24; //kelompoktindakan_m gizi
	const KELOMPOKTINDAKAN_ID_RAD	= 10; //kelompoktindakan_m radiodiagnostik
	const KELOMPOKTINDAKAN_ID_LAB	= 25; //kelompoktindakan_m laboratorium
	const KELOMPOKTINDAKAN_ID_MCU	= 26; //kelompoktindakan_m mcu
        const KELOMPOKTINDAKAN_ID_AKOMODASI = 14;

	const SATUAN_TINDAKAN_PENDAFTARAN = 'KALI';  //disesuaikan dengan lookup_m.lookup_type = satuantindakan
	const SATUAN_TINDAKAN_VISITE = 'KALI';  //disesuaikan dengan lookup_m.lookup_type = satuantindakan
	const SATUAN_TINDAKAN_LABORATORIUM = 'KALI';  //disesuaikan dengan lookup_m.lookup_type = satuantindakan
	const SATUAN_TINDAKAN_REHAB_MEDIS = 'KALI';  //disesuaikan dengan lookup_m.lookup_type = satuantindakan
	const SATUAN_LAMARAWAT_RD = 'JAM';              
	const SATUAN_LAMARAWAT_RI = 'HARI'; 
	const SATUAN_LAMARAWAT_RJ = 'HARI'; 
	const SATUAN_KECIL = 'SATUANKECIL';
	
	const SATUANJML_URT = "Buah"; //berdasarkan lookup_m.lookup_type = ukuranrumahtangga

	const LOOKUPTYPE_TRANSPORTASI = 'transportasi'; //tipe dari tabel lookup_m untuk transportasi
	const LOOKUPTYPE_KEADAAN_MASUK = 'keadaanmasuk'; //tipe dari tabel lookup_m untuk keadaan masuk
	const LOOKUPTYPE_KONDISI_PULANG = 'kondisipulang'; //tipe dari tabel lookup_m untuk kondisi pulang
	const LOOKUPTYPE_CARA_KELUAR = 'carakeluar'; //tipe dari tabel lookup_m untuk cara keluar
	const LOOKUPTYPE_JENISPEMERIKSAANLAB_KELOMPOK = 'jenispemeriksaanlab_kelompok'; //tipe dari tabel lookup_m untuk kelompok pemeriksaan lab    
	const LOOKUPTYPE_SATUAN_HASIL_LAB = 'satuanhasillab'; //tipe dari tabel lookup_m untuk satuan hasil lab
	const LOOKUPTYPE_STATUS_PERIKSA_HASIL = 'statusperiksahasil'; // tipe dari tabel lookup_m untuk status periksa hasil
	const LOOKUPTYPE_OBATALKES_KADAROBAT = 'obatalkes_kadarobat'; // tipe dari tabel lookup_m untuk status kadar obat
	const LOOKUPTYPE_DENYUTJANTUNG = 'denyutjantung'; // tipe dari tabel lookup_m untuk denyut jantung
	const LOOKUPTYPE_SATUAN_KELOMPOK_UMUR = 'satuankelumur'; //tipe dari tabel lookup_m untuk satuan kelompok umur
	const LOOKUPTYPE_SEDIAANOBATRACIKAN = 'sediaanobatracikan'; //tipe dari tabel lookup_m untuk sediaan obat racikan
	const LOOKUPTYPE_SIGNA_OA = 'signa_oa'; //tipe dari tabel lookup_m untuk signa obat
	const LOOKUPTYPE_JENIS_KELAMIN = 'jeniskelamin'; //tipe dari tabel lookup_m untuk jenis kelamin
        const LOOKUPTYPE_OBATALKES_KATEGORI = 'obatalkes_kategori';
        const LOOKUPTYPE_OBATALKES_GOLONGAN = 'obatalkes_golongan';
        
	const JENISPESANMENU_PASIEN = 'Pasien'; //disesuaikan dengan lookup_m.lookup_type = jenispesanmenu
	const JENISPESANMENU_PEGAWAI = 'Pegawai'; //disesuaikan dengan lookup_m.lookup_type = jenispesanmenu

	const JENISPENJUALAN_RESEP = "PENJUALAN RESEP"; //disesuaikan dengan lookup_m.lookup_type = jenispenjualan
	const JENISPENJUALAN_RESEP_LUAR = "PENJUALAN RESEP LUAR"; //disesuaikan dengan lookup_m.lookup_type = jenispenjualan
	const JENISPENJUALAN_BEBAS = "PENJUALAN BEBAS"; //disesuaikan dengan lookup_m.lookup_type = jenispenjualan
	const JENISPENJUALAN_DOKTER = "PENJUALAN DOKTER"; //disesuaikan dengan lookup_m.lookup_type = jenispenjualan
	const JENISPENJUALAN_KARYAWAN = "PENJUALAN PEGAWAI"; //disesuaikan dengan lookup_m.lookup_type = jenispenjualan

	const JENISPELAYANAN_RJ = 2; //di ambil dari lookup_m.lookup_type = jenispelayanan
	const JENISPELAYANAN_RI = 1; //di ambil dari lookup_m.lookup_type = jenispelayanan
	
	const OBATALKESPASIEN_BMHP = "BM"; //disesuaikan dengan lookup_m.lookup_type = 'jnspelayanan'

	const METODEANTRIAN_FIFO = "FIFO"; //disesuaikan dengan lookup_m.lookup_type = 'metodeantrian'
	const METODEANTRIAN_FEFO = "FEFO"; //disesuaikan dengan lookup_m.lookup_type = 'metodeantrian'
	const METODEANTRIAN_LIFO = "LIFO"; //disesuaikan dengan lookup_m.lookup_type = 'metodeantrian'

	const JENISTARIF_ID_PELAYANAN = 1; //dari jenistarif_m

	const KELMENU_ID_DASHBOARD = 62;

	//JENIS LAYAR ANTRIAN
	const LAYARANTRIAN_JENIS_POLIKLINIK = 'POLIKLINIK'; //disesuaikan dengan lookup_m.lookup_type = 'layarantrian_jenis'
	const LAYARANTRIAN_JENIS_PENUNJANG = 'PENUNJANG'; //disesuaikan dengan lookup_m.lookup_type = 'layarantrian_jenis'
	const LAYARANTRIAN_JENIS_KASIR = 'KASIR'; //disesuaikan dengan lookup_m.lookup_type = 'layarantrian_jenis'
    
	const STATUSOPERASI_SELESAI = 'SELESAI'; //disesuaikan dengan lookup_m.lookup_type = 'statusoperasi'

	const KETERANGANBATAL_BEDAH_SENTRAL = 'Batal Bedah Sentral'; //untuk filter pasienbatalperiksa_r.keterangan_batal
	

	// TUJUAN SMS (smsgateway_m.tujuansms)
	const TUJUANSMS_PASIEN = "pasien";
	const TUJUANSMS_DOKTER = "dokter";
	const TUJUANSMS_PENANGGUNGJAWAB = "penanggungjawab";
	const TUJUANSMS_SUPPLIER = "supplier";
	const TUJUANSMS_ASURANSI = "asuransi";
	const TUJUANSMS_PEMESAN = "pemesan";
	const TUJUANSMS_PEGAWAI = "pegawai";
	const TUJUANSMS_PEGAWAI_PEMESAN = "pegawaipemesan";
	const TUJUANSMS_PEGAWAI_PEMINJAM = "pegawaipeminjam";
	const TUJUANSMS_PEMOHON = "pemohon";

	//ID smsgateway static (smsgateway_m.smsgateway_id)
	const SMSGATEWAY_PEMBERITAHUAN_JANJI_POLIKLINIK_PASIEN = 130;
	const SMSGATEWAY_PEMBERITAHUAN_JANJI_POLIKLINIK_DOKTER = 131;
	const SMSGATEWAY_STATUS_KONFIMASI_PESAN_KAMAR = 132;
	const SMSGATEWAY_RENCANAKONTROL_PASIEN = 133;
	const SMSGATEWAY_RENCANAKONTROL_DOKTER = 134;
	const SMSGATEWAY_ULANGTAHUN_PASIEN = 135;
	const SMSGATEWAY_ULANGTAHUN_PEGAWAI = 136;
	const SMSGATEWAY_JATUHTEMPO_HUTANG = 156;
	const SMSGATEWAY_JATUHTEMPO_PINJAMAN = 157;

	const KATEGORICATATAN_ID_AGENDA = 2; //disesuaikan dengan mkategoricatatan_m
	const KATEGORICATATAN_ID_UMUM = 1; //disesuaikan dengan mkategoricatatan_m
	
	const JENISPERAWATAN_PENCUCIAN = 'PENCUCIAN'; //disesuaikan dengan lookup_m.lookup_type = 'jenisperawatan'
	const JENISPERAWATAN_DEKONTAMINASI= 'DEKONTAMINASI'; //disesuaikan dengan lookup_m.lookup_type = 'jenisperawatan'
	
	const STATUSPERAWATAN_SELESAI = 'SELESAI'; //disesuaikan dengan lookup_m.lookup_type = 'statusperawatan'
	
	const JENISKELOMPOK_OB = 'OB'; //disesuaikan dengan lookup_m.lookup_type = 'jnskelompok'
	const JENISKELOMPOK_AL = 'AL'; //disesuaikan dengan lookup_m.lookup_type = 'jnskelompok'
	const JENISKELOMPOK_GM = 'GM'; //disesuaikan dengan lookup_m.lookup_type = 'jnskelompok'
	const JENISKELOMPOK_XY = 'XY'; //disesuaikan dengan lookup_m.lookup_type = 'jnskelompok'
        
        const REKENING1_LEN = 2;
        const REKENING2_LEN = 4;
        const REKENING3_LEN = 6;
        const REKENING4_LEN = 8;
        const REKENING5_LEN = 10;
        
        const STATUSKEHADIRAN_HADIR = 1;
        const STATUSKEHADIRAN_SAKIT = 2;
        const STATUSKEHADIRAN_IZIN = 3;
        const STATUSKEHADIRAN_DINAS = 4;
        const STATUSKEHADIRAN_ALPHA = 5;
        
        const STATUSSCAN_MASUK = 1;
        const STATUSSCAN_PULANG = 2;
        const STATUSSCAN_DATANG = 4;
        const STATUSSCAN_KELUAR = 3;
        const STATUSSCAN_TIDAKTAHU = 5;
        
        const SURAT_KETERANGAN_KONTROL = 2;
        

        const SHIFT_PAGI = 1;

        const DEFAULT_JENISINVENTARISASI = 'Penyesuaian';
        
        
	//===   END KONSTANTA ===
        
        /* Hardcode status periksa */
        public static function statusPeriksa() {
            return array(
                'ANTRIAN'=>'ANTRIAN',
                'SEDANG DIRAWAT INAP'=>'SEDANG DIRAWAT INAP',
                'SEDANG PERIKSA'=>'SEDANG PERIKSA',
                'SUDAH DI PERIKSA'=>'SUDAH DI PERIKSA',    
                'MENUNGGU DAFTAR DI LOKET SO'=>'MENUNGGU DAFTAR DI LOKET SO',
                'SUDAH PULANG'=>'SUDAH PULANG',
            );
        }
        public static function statusPeriksaPT() {
            return array(
                'ANTRIAN'=>'ANTRIAN',
                'SEDANG PERIKSA'=>'SEDANG PERIKSA',
                'SUDAH DI PERIKSA'=>'SUDAH DI PERIKSA',
            );
        }
        
        public static function sys2bpjsKelas($id=null) {
            $arr = array(
                '3'=>1,
                '5'=>2,
                '4'=>3,
            );
            if (!empty($id)) return $arr[$id];
            return $arr;
        }
	
	//=== PATH & URL ===
	//Merupakan inisialisasi path dan url yang digunakan untuk menyimpan dan mengakses file

	/**
	 * untuk mengambil path direktori gambar untuk slider Antrian
	 * @return string path contoh: /var/www/simrs/data/images/slideantrian/
	 */
	public static function pathAntrianSliderGambar()
	{
		return Yii::getPathOfAlias('webroot').'/data/images/slideantrian/';
	}

	public static function pathAntrianSliderGambarThumbs()
	{
		return Yii::getPathOfAlias('webroot').'/data/images/slideantrian/thumbs/';
	}

	public static function urlAntrianSliderGambar()
	{
		return Yii::app()->getBaseUrl('webroot').'/data/images/slideantrian/';
	}

	public static function urlAntrianSliderGambarThumbs()
	{
		return Yii::app()->getBaseUrl('webroot').'/data/images/slideantrian/thumbs/';
	}

	/**
	 * untuk mengambil path direktori latar belakang layar antrian
	 * @return string path contoh: /var/www/simrs/data/images/antrian/
	 */
	public static function pathBackgroundAntrian()
	{
		return Yii::getPathOfAlias('webroot').'/data/images/antrian/';
	}
	public static function pathBackgroundAntrianThumbs()
	{
		return Yii::getPathOfAlias('webroot').'/data/images/antrian/thumbs/';
	}
	public static function urlBackgroundAntrian()
	{
		return Yii::app()->getBaseUrl('webroot').'/data/images/antrian/';
	}
	public static function urlBackgroundAntrianThumbs()
	{
		return Yii::app()->getBaseUrl('webroot').'/data/images/antrian/thumbs/';
	}

	/**
	 * untuk mengambil path direktori icon modul
	 * @return string path contoh: /var/www/simrs/images/icon_modul
	 */
	public static function pathIconModulDirectory()
	{
		return Yii::getPathOfAlias('webroot').'/images/icon_modul/';
	}

	/**
	 * untuk mengambil path direktori thumbnail icon modul
	 * @return string path contoh: /var/www/simrs/images/icon_modul
	 */
	public static function pathIconModulThumbsDirectory()
	{
		return Yii::getPathOfAlias('webroot').'/images/icon_modul/thumbs/';
	}

	/**
	 * untuk mengambil url direktori thumbnail icon modul
	 * @return string path contoh: /var/www/simrs/images/icon_modul
	 */
	public static function urlIconModulThumbsDirectory()
	{
		return Yii::app()->getBaseUrl('webroot').'/images/icon_modul/thumbs/';
	}

	/**
	 * untuk mengambil path direktori icon menu
	 * @return string path contoh: /var/www/simrs/images/icon_menu
	 */
	public static function pathIconMenuDirectory()
	{
		return Yii::getPathOfAlias('webroot').'/images/icon_menu/';
	}

	/**
	 * untuk mengambil path direktori thumbnail icon menu
	 * @return string path contoh: /var/www/simrs/images/icon_menu
	 */
	public static function pathIconMenuThumbsDirectory()
	{
		return Yii::getPathOfAlias('webroot').'/images/icon_menu/thumbs/';
	}

	/**
	 * untuk mengambil url direktori thumbnail icon modul
	 * @return string path contoh: /var/www/simrs/images/icon_modul
	 */
	public static function urlIconModulDirectory()
	{
		return Yii::app()->getBaseUrl('webroot').'/images/icon_modul/';
	}
	public static function urlIconMenuDirectory()
	{
		return Yii::app()->getBaseUrl('webroot').'/images/icon_menu/';
	}
	public static function urlBarangDirectory()
	{
		return Yii::app()->getBaseUrl('webroot').'/images/barang/';
	}

	public static function pathProfilRSDirectory()
	{
		return Yii::getPathOfAlias('webroot').'/data/images/profil_rs/';
	}
	public static function pathBarangDirectory()
	{
		return Yii::getPathOfAlias('webroot').'/images/barang/';
	}

	public static function pathProfilRSTumbsDirectory()
	{
		return Yii::getPathOfAlias('webroot').'/data/images/profil_rs/tumbs/';
	}
	public static function pathBarangTumbsDirectory()
	{
		return Yii::getPathOfAlias('webroot').'/images/barang/tumbs/';
	}

	//======================================Path Instalasi==============================================    
	public static function pathRuanganDirectory()
	{
		return Yii::getPathOfAlias('webroot').'/data/images/ruangan/';
	}

	public static function pathRuanganTumbsDirectory()
	{
		return Yii::getPathOfAlias('webroot').'/data/images/ruangan/tumbs/';
	}

	public static function urlRuanganDirectory()
	{
		return Yii::app()->getBaseUrl('webroot').'/data/images/ruangan/';          //Untuk Menampilkan Gambar Asli
	}

	public static function urlRuanganTumbsDirectory()
	{
		return Yii::app()->getBaseUrl('webroot').'/data/images/ruangan/tumbs/';    //Untuk Menampilkan Gambar Tumbs
	}  
	//====================================Akhir Path dan UrlInstalasi=====================================

	//======================================Path Kamr Ruangan==============================================    
	public static function pathKamarRuanganDirectory()
	{
		return Yii::getPathOfAlias('webroot').'/data/images/kamarruangan/';
	}

	public static function pathKamarRuanganTumbsDirectory()
	{
		return Yii::getPathOfAlias('webroot').'/data/images/kamarruangan/tumbs/';
	}

	public static function urlKamarRuanganDirectory()
	{
		return Yii::app()->getBaseUrl('webroot').'/data/images/kamarruangan/';          //Untuk Menampilkan Gambar Asli
	}

	public static function urlKamarRuanganTumbsDirectory()
	{
		return Yii::app()->getBaseUrl('webroot').'/data/images/kamarruangan/tumbs/';    //Untuk Menampilkan Gambar Tumbs
	}  
	//====================================Akhir Path dan UrlKamarRuangan=====================================

	//======================================Path Instalasi==============================================    
	public static function pathInstalasiDirectory()
	{
		return Yii::getPathOfAlias('webroot').'/data/images/instalasi/';
	}

	public static function pathInstalasiTumbsDirectory()
	{
		return Yii::getPathOfAlias('webroot').'/data/images/instalasi/tumbs/';
	}

	public static function urlInstalasiDirectory()
	{
		return Yii::app()->getBaseUrl('webroot').'/data/images/instalasi/';          //Untuk Menampilkan Gambar Asli
	}

	public static function urlInstalasiTumbsDirectory()
	{
		return Yii::app()->getBaseUrl('webroot').'/data/images/instalasi/tumbs/';    //Untuk Menampilkan Gambar Tumbs
	}  
	//====================================Akhir Path dan UrlInstalasi=====================================    

	//======================================Path USG==============================================    
	public static function pathUSGDirectory()
	{
		return Yii::getPathOfAlias('webroot').'/data/images/fotousg/';
	}

	public static function pathUSGTumbsDirectory()
	{
		return Yii::getPathOfAlias('webroot').'/data/images/fotousg/tumbs/';
	}

	public static function urlUSGDirectory()
	{
		return Yii::app()->getBaseUrl('webroot').'/data/images/fotousg/';          //Untuk Menampilkan Gambar Asli
	}

	public static function urlUSGTumbsDirectory()
	{
		return Yii::app()->getBaseUrl('webroot').'/data/images/fotousg/tumbs/';    //Untuk Menampilkan Gambar Tumbs
	}  
	//====================================Akhir Path dan Url USG=====================================     

	public static function urlProfilRSDirectory()
	{
		return Yii::app()->getBaseUrl('webroot').'/data/images/profil_rs/';          //Untuk Menampilkan Gambar Asli
	}

	public static function urlProfilRSTumbsDirectory()
	{
		return Yii::app()->getBaseUrl('webroot').'/data/images/profil_rs/tumbs/';    //Untuk Menampilkan Gambar Tumbs
	}  

	public static function pathPegawaiDirectory()
	{
			return Yii::getPathOfAlias('webroot').'/data/images/pegawai/';
	}

	public static function pathPegawaiTumbsDirectory()
	{
		return Yii::getPathOfAlias('webroot').'/data/images/pegawai/tumbs/';
	}

	public static function urlPegawaiDirectory()
	{
		return Yii::app()->getBaseUrl('webroot').'/data/images/pegawai/';          //Untuk Menampilkan Gambar Asli Pegawai
	}

	public static function urlPegawaiTumbsDirectory()
	{
		return Yii::app()->getBaseUrl('webroot').'/data/images/pegawai/tumbs/';    //Untuk Menampilkan Gambar Tumbs Pegawai
	}  

	public static function urlPhotoPasienDirectory()
	{
		return Yii::app()->getBaseUrl('webroot').'/data/images/pasien/';    //Untuk Menampilkan photo pasien
	}
	
	public static function urlPhotoBarangDirectory()
	{
		return Yii::app()->getBaseUrl('webroot').'/data/images/barang/';    //Untuk Menampilkan photo barang
	}

	public static function pathPasienTumbsDirectory()
	{
		return Yii::getPathOfAlias('webroot').'/data/images/pasien/tumbs/';
	}

	public static function urlPasienTumbsDirectory()
	{
		return Yii::app()->getBaseUrl('webroot').'/data/images/pasien/tumbs/';    //Untuk Menampilkan Gambar Tumbs Pasien
	}  

	public static function pathPasienDirectory()
	{
		return Yii::getPathOfAlias('webroot').'/data/images/pasien/';
	}

	public static function urlKendaraanDirectory()
	{
		return Yii::app()->getBaseUrl('webroot').'/data/images/kendaraan/';    //Untuk Menampilkan Gambar Kendaraan
	}

	public static function pathKendaraanDirectory()
	{
		return Yii::getPathOfAlias('webroot').'/data/images/kendaraan/';
	}

	public static function urlKendaraanTumbsDirectory()
	{
		return Yii::app()->getBaseUrl('webroot').'/data/images/kendaraan/tumbs/';    //Untuk Menampilkan Gambar Tumbs Kendaraan
	}

	public static function pathKendaraanTumbsDirectory()
	{
		return Yii::getPathOfAlias('webroot').'/data/images/kendaraan/tumbs/';
	}
	//======== path dan url photo dan file pelamar ========
	public static function pathPelamarThumbsDirectory()
	{
		return Yii::getPathOfAlias('webroot').'/data/images/pelamar/photos/thumbs/';
	}
	public static function pathPelamarPhotosDirectory()
	{
		return Yii::getPathOfAlias('webroot').'/data/images/pelamar/photos/';
	}
	public static function pathPelamarFilesDirectory()
	{
		return Yii::getPathOfAlias('webroot').'/data/images/pelamar/files/';
	}
	public static function urlPelamarThumbsDirectory()
	{
		return Yii::app()->getBaseUrl('webroot').'/data/images/pelamar/photos/thumbs/';
	}
	public static function urlPelamarPhotosDirectory()
	{
		return Yii::app()->getBaseUrl('webroot').'/data/images/pelamar/photos/';
	}
	public static function urlPelamarFilesDirectory()
	{
		return Yii::app()->getBaseUrl('webroot').'/data/images/pelamar/files/';
	}

	//======== End path dan url photo pelamar ========

	public static function pathImagePengumumanUploaded()
	{
		return Yii::getPathOfAlias('webroot').'/data/images/pengumuman/';
	}

	public static function pathImagePengumumanUploadedThumb()
	{
		return Yii::getPathOfAlias('webroot').'/data/images/pengumuman/thumbs/';
	}

	public static function urlImagePengumumanUploaded()
	{
		return Yii::app()->getBaseUrl('webroot').'/data/images/pengumuman/';
	}

	public static function urlExcel()
	{
		return Yii::app()->getBaseUrl('webroot').'/data/excel/template/';
	}

	public static function urlImagePengumumanUploadedThumb()
	{
		return Yii::app()->getBaseUrl('webroot').'/data/images/pengumuman/thumbs/';
	}

	 public static function urliconmenu()
	{
		return Yii::app()->getBaseUrl('webroot').'/css/images/';
	}

	public static function pathImageErrorAdmin()
	{
		return Yii::app()->getBaseUrl('webroot').'/data/images/';
	}

	public static function pathBerita()
	{
		return Yii::getPathOfAlias('webroot').'/data/images/berita/';
	}

	public static function urlBerita()
	{
		return Yii::app()->getBaseUrl('webroot').'/data/images/berita/';      
	}

	//======== path dan url photo pemeriksaan pasien ========
	public static function pathPemeriksaanPasienThumbsDirectory()
	{
		return Yii::getPathOfAlias('webroot').'/data/images/pemeriksaanpasien/photos/thumbs/';
	}
	public static function pathPemeriksaanPasienPhotosDirectory()
	{
		return Yii::getPathOfAlias('webroot').'/data/images/pemeriksaanpasien/photos/';
	}
	public static function urlPemeriksaanPasienThumbsDirectory()
	{
		return Yii::app()->getBaseUrl('webroot').'/data/images/pemeriksaanpasien/photos/thumbs/';
	}
	public static function urlPemeriksaanPasienPhotosDirectory()
	{
		return Yii::app()->getBaseUrl('webroot').'/data/images/pemeriksaanpasien/photos/';
	}
	//======== End path dan url pemeriksaan pasien ========
	
	//======== Start path dan url Anatomi Tubuh Manusia ========

	public static function urlPhotoAnatomiTubuh()
	{
		return Yii::app()->getBaseUrl('webroot').'/data/images/anatomi/';
	}
	public static function pathAnatomiTubuhDirectory()
	{
		return Yii::getPathOfAlias('webroot').'/data/images/anatomi/';
	}
	public static function pathAnatomiTubuhThumbsDirectory()
	{
		return Yii::getPathOfAlias('webroot').'/data/images/anatomi/thumbs/';
	}

	//======== End path dan url Anatomi Tubuh Manusia ========
	
	//======== Start path dan url Linen ========

	public static function urlLinen()
	{
		return Yii::app()->getBaseUrl('webroot').'/data/images/linen/';
	}
        public static function urlLinenThumbs()
	{
		return Yii::app()->getBaseUrl('webroot').'/data/images/linen/thumbs/';
	}
	public static function pathLinenDirectory()
	{
		return Yii::getPathOfAlias('webroot').'/data/images/linen/';
	}
	public static function pathLinenThumbsDirectory()
	{
		return Yii::getPathOfAlias('webroot').'/data/images/linen/thumbs/';
	}

	//======== End path dan url Anatomi Tubuh Manusia ========
	
	//======== Start path dan url File CALK ========

	public static function urlCALK()
	{
		return Yii::app()->getBaseUrl('webroot').'/data/files/calk/';
	}
	public static function pathCALKDirectory()
	{
		return Yii::getPathOfAlias('webroot').'/data/files/calk/';
	}

	//======== End path dan url File CALK ========
	
        
        public function getLoketRJP() {
            return array(1, 2);
        }
        
}
?>