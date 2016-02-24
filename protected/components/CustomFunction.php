<?php
/**
 * Class CustomFunction untuk menyimpan function PHP yg digunakan umum (semua module)
 * - mencari nilai tertentu
 * - menentukan nilai dari parameter
 */
class CustomFunction
{
    /**
     * Menyebarkan notifikasi secara bersamaan.
     * 
     * @author Deni Hamdani <pii.deni.prg@gmail.com>        
     * @param string $judul Judul dari notifikasi
     * @param string $isi Isi/Konten dari notifikasi
     * @param mixed $tujuan Data tujuan yang tiap subarray-nya terdiri dari:
     * - instalasi_id
     * - ruangan_id (bisa dalam bentuk array maupun integer)
     * - modul_id
     * @return boolean Jika sukses menambahkan notifikasi ke tempat tujuan. False 
     * jika sebaliknya.
     * 
     */
    public static function broadcastNotif($judul, $isi, $tujuan) {
        $param = array();
        $param['tglnotifikasi'] = date('Y-m-d H:i:s');
        $param['create_time'] = date('Y-m-d H:i:s');
        $param['create_loginpemakai_id'] = Yii::app()->user->id;
        $param['judulnotifikasi'] = $judul;
        $param['isinotifikasi'] = $isi;
        
        $ok = true;
        foreach ($tujuan as $item) {
            $param['instalasi_id'] = $item['instalasi_id'];
            $param['modul_id'] = $item['modul_id'];
            
            if (is_array($item['ruangan_id'])) {
                foreach ($item['ruangan_id'] as $ruangan) {
                    $param['create_ruangan'] = $ruangan;
                    $ok = $ok && self::insertNotifikasi($param);
                }
            } else {
                $param['create_ruangan'] = $item['ruangan_id'];
                $ok = $ok && self::insertNotifikasi($param);
            }
        }
        
        return $ok;
    }
    
    
    /**
     * Untuk menambahkan notifikasi
     * digunakan juga di semua module
     * @param type $params
     * @return boolean
     */
    public static function insertNotifikasi($params){
        $is_simpan = false;
        $model = new NofitikasiR;
        $model->attributes = $params;

        $criteria = new CDbCriteria;
        $criteria->compare('instalasi_id',$params['instalasi_id']);
        $criteria->compare('modul_id',$params['modul_id']);
        $criteria->compare('LOWER(isinotifikasi)',strtolower($params['isinotifikasi']),true);
        $criteria->compare('LOWER(judulnotifikasi)',strtolower($params['judulnotifikasi']),true);
        $criteria->compare('create_ruangan',$params['create_ruangan']);
        $criteria->addCondition("DATE(tglnotifikasi) = DATE(NOW()) AND isread = false");
        $is_exist = NofitikasiR::model()->find($criteria);
        if(!$is_exist)
        {
            if($model->save()){
                $is_simpan = true;
            }
        }else{
            $attributes = array(
                'update_time' => date('Y-m-d H:i:s'),
                'update_loginpemakai_id' => Yii::app()->user->id,
            );
            $update = $model::model()->updateByPk($is_exist['nofitikasi_id'], $attributes);
            if($update){
                $is_simpan = true;
            }
        }
        return $is_simpan;
    }
    
    
    /**
     * Menghitung hari antara 2 tanggal
     * @param type $dateFrom
     * @param type $dateTo
     * @return type
     */
    public static function hitungHari($dateFrom,$dateTo=''){
        
        $dateTo = (!empty($dateTo)) ? date('Y-m-d', strtotime($dateTo)) : date('Y-m-d'); // or your date as well
        $dateFrom = date('Y-m-d', strtotime($dateFrom));
        
        // var_dump($dateFrom." - ".$dateTo);
        
        $d1 = new DateTime($dateFrom);
        $d2 = new DateTime($dateTo);
        
        $interval = $d1->diff($d2);
        
        return $interval->format('%a');
        
        //echo floor($dateFrom/(60*60*24))." - ".; die;
        //$datediff = $dateTo - $dateFrom;
        //var_dump($dateTo/(60*60*24)." - ".$dateFrom/(60*60*24));
        //$hari = ceil($dateTo/(60*60*24)) - floor($dateFrom/(60*60*24));
        // return 0; //$hari;
    }
	/**
	 * menghitung lama hari perawatan medis
	 * @param type $dateFrom
	 * @param type $dateTo
	 * @return type
	 */
	public static function hitungHariRawat($dateFrom,$dateTo=''){
        $dateTo = (!empty($dateTo)) ? strtotime($dateTo) : time(); // or your date as well
        $dateFrom = strtotime($dateFrom);
        $datediff = $dateTo - $dateFrom;
        $hari = floor($datediff/(60*60*24)) + 1;
        return $hari;
    }
    /**
     * Digunakan di konfigfarmasi_k.formulajasadokter
     * @param type $mathString
     * @return type
     */
    public static function calculate_string( $mathString ){
        $mathString = trim($mathString);     // trim white spaces
        $mathString = preg_replace('/[^0-9\-\+\/\*]/i', '', $mathString);    // remove any non-numbers chars; exception for math operators
        $mathString = (!empty($mathString)) ? $mathString : true;
        $compute = create_function("", "return (" . $mathString . ");" );
        return 0 + $compute();
    }
    
    /**
     * Golongan Umur
     * @param float $umur 
     * @return array hasil query tabel golongan umur ($result['golonganumur_id'],$result['golonganumur_nama'])
     */
    public static function getGolonganUmur($tgl_lahir){
        $umur = self::hitungUmur($tgl_lahir);
        $sql = "select golonganumur_id, golonganumur_nama from golonganumur_m where '".ceil($umur)."' between golonganumur_minimal AND golonganumur_maksimal";
        $result = Yii::app()->db->createCommand($sql)->queryRow();
        return $result['golonganumur_id'];
    }
    /**
     * Kelompok Umur
     * @param type $umur
     * @return type
     */
    public static function getKelompokUmur($tgl_lahir){
        $umur = self::hitungUmur($tgl_lahir);
        $sql = "select kelompokumur_id, kelompokumur_nama from kelompokumur_m where '".ceil($umur)."' between kelompokumur_minimal AND kelompokumur_maksimal";
        $result = Yii::app()->db->createCommand($sql)->queryRow();
        return $result['kelompokumur_id'];
    }
    /**
     * menghtung umur dari tanggal lahir
     * @param type $tgl_lahir
     * @return type
     */
    public static function hitungUmur($tgl_lahir){
        $format = new MyFormatter();
        $tgl_lahir = $format->formatDateTimeForDb($tgl_lahir);
        $today=date("Y-m-d");
		$date1 = new DateTime($tgl_lahir);
		$date2 = new DateTime($today);
		$interval = $date1->diff($date2);
		$umur = str_pad($interval->y, 2, '0', STR_PAD_LEFT).' Thn '. str_pad($interval->m, 2, '0', STR_PAD_LEFT) .' Bln '. str_pad($interval->d, 2, '0', STR_PAD_LEFT).' Hr';
        
        return $umur;
    }
    /**
     * menentukan tanggal dari umur (format: 00 Thn 00 Bln 00 Hr)
     * @param type $umur
     * @return type Y-m-d
     */
    public static function getTanggalUmur($umur){
        $umur = explode(' ', $umur);
		$today = date('Y-m-d');
		if(isset($umur[0])&&isset($umur[2])&&isset($umur[4])){
			$thn = $umur[0];
			$bln = $umur[2];
			$hr = $umur[4];

			if($thn=='')$thn=0;if($bln=='')$bln=0;
			$date_calc = strtotime(date("Y-m-d", strtotime($today)) . "-$hr day");
			$date = date("Y-m-d",  $date_calc);
			$date_calc = strtotime(date("Y-m-d", strtotime($date)) . "-$bln month");
			$date = date('Y-m-d', $date_calc);
			$date_calc = strtotime(date("Y-m-d", strtotime($date)) . "-$thn year");
			$date = date('Y-m-d', $date_calc);
		} else {
			$date = date("Y-m-d",  strtotime($today));
		}
        
        return $date;
    }
    /**
     * statuspasien : pasien lama / baru 
     * @param type $modelPasien
     * @return type
     */
    public static function getStatusPasien($modelPasien)
    {
        $sql = "SELECT pendaftaran_id FROM pendaftaran_t WHERE pasien_id = ".$modelPasien->pasien_id;
        $result = Yii::app()->db->createCommand($sql)->queryRow();
        $status = (!empty($result)) ? Params::STATUSPASIEN_LAMA : Params::STATUSPASIEN_BARU;
        return $status;
    }
    /**
     * statuskunjungan : kunjungan Lama / Baru
     * @param type $modelPasien
     * @param type $ruangan_id
     * @return type
     */
    public static function getKunjungan($modelPasien, $ruangan_id)
    {
        if(!empty($ruangan_id)){
            $sql = "SELECT pendaftaran_id FROM pendaftaran_t WHERE pasien_id = ".$modelPasien->pasien_id.' AND ruangan_id = '.$ruangan_id;
            $result = Yii::app()->db->createCommand($sql)->queryRow();
            $status = (!empty($result)) ? Params::STATUSKUNJUNGAN_LAMA : Params::STATUSKUNJUNGAN_BARU;
            return $status;
        } else {
            return Params::STATUSKUNJUNGAN_BARU;
        }
    }
    /**
     * Menampilkan Umur 
     * @param type $tglLahir
     * @return string [23 Thn 02 Bln 15 Hr]
     */
    public static function getUmur($tglLahir)
    {
        $format = new MyFormatter;
        $tglLahir = $format->formatDateTimeForDb($tglLahir);
        $dob=$tglLahir; $today=date("Y-m-d");
        list($y,$m,$d)=explode('-',$dob);
        list($ty,$tm,$td)=explode('-',$today);
        if($td-$d<0){
            $day=($td+30)-$d;
            $tm--;
        }
        else{
            $day=$td-$d;
        }
        if($tm-$m<0){
            $month=($tm+12)-$m;
            $ty--;
        }
        else{
            $month=$tm-$m;
        }
        $year=$ty-$y;

        $umur = str_pad($year, 2, '0', STR_PAD_LEFT).' Thn '. str_pad($month, 2, '0', STR_PAD_LEFT) .' Bln '. str_pad($day, 2, '0', STR_PAD_LEFT).' Hr';
        
        return $umur;
    }

    /**
     * menampilkan module-module yang ada
     * @return type
     */
    public static function getModules()
    {
        $moduls = Yii::app()->metadata->getModules();
        foreach($moduls as $i=>$modul){
            $result[$modul] = $modul;
        }
        
        return $result;
    }
    
    /**
     * menampilkan controller dari module
     * @param type $namaModul 
     */
    public static function getControllers($namaModul)
    {        
        $controllers = Yii::app()->metadata->getControllers($namaModul);
        foreach($controllers as $i=>$controller){
            $controller = str_replace('Controller', '', $controller);
            $result[$controller] = $controller;
        }
        
        return $result;
    }
    
    /**
     * manempilkan action dari controller dan module
     * @param type $contorllerId
     * @param type $namaModul 
     */
    public static function getActions($contorllerId, $namaModul)
    {
        $result = array();
        $actions = Yii::app()->metadata->getActions(ucfirst($contorllerId).'Controller', $namaModul);
        foreach($actions as $i=>$action){
            $result[$action] = $action;
        }
        
        return $result;
    }
    
    /**
     * menampilkan list ukuran kertas
     * @return array
     */
    public static function getUkuranKertas()
    {
        $daftar = array(
            'A3'=>'A3',
            'A4'=>'A4',
            'A5'=>'A5',
        );
        asort($daftar);
        return $daftar;
    }
    /**
     * menampilkan list posisi kertas
     * @return string
     */
    public static function getPosisiKertas()
    {
        $daftar = array(
            'L'=>'Landscape',
            'P'=>'Portrait',
        );
        asort($daftar);
        return $daftar;
    }
    
    
    /**
     * menampilkan list status konfirmasi booking
     * @return array
     */
    public static function getStatusKonfirmasiBooking()
    {
        $statuskonfirmbooking = array(
            Params::STATUSKONFIRMASI_BOOKING_SUDAH=>'SUDAH KONFIRMASI',
            Params::STATUSKONFIRMASI_BOOKING_BELUM=>'BELUM KONFIRMASI',
            Params::STATUSKONFIRMASI_BOOKING_BATAL=>'BATAL BOOKING',
        );
        asort($statuskonfirmbooking);
        return $statuskonfirmbooking;
    }
    
    /**
     * menampilkan list status konfirmasi berdasarkan pendaftaran_t
     * @return array
     */
    public static function getStatusKonfirmasi()
    {
        $statusKonfirmasi = array(
            Params::STATUSKONFIRMASI_SUDAH=>'SUDAH DIKONFIRMASI',
            Params::STATUSKONFIRMASI_BELUM=>'BELUM DIKONFIRMASI',
        );
        asort($statusKonfirmasi);
        return $statusKonfirmasi;
    }
    
    /**
     * Menampilkan list nama hari
     * @return string
     */
    public static function getNamaHari()
    {
        $namaHari = array(
            'SENIN'=>'Senin',
            'SELASA'=>'Selasa',
            'RABU'=>'Rabu',
            'KAMIS'=>'Kamis',
            'JUMAT'=>'Jumat',
            'SABTU'=>'Sabtu',
            'MINGGU'=>'Minggu',
        );
        return $namaHari;
    }
    
    /**
     * menampilkan semua tahun dari $sebelumthn tahun sampai $setelahthn tahun dari tahun sekarang
     * @param type $sebelumthn
     * @param type $setelahthn
     */
    public static function getTahun($sebelumthn = null, $setelahthn = null){
        $rangeArr = range(2000,date("Y"));
        if(isset($sebelumthn) && empty($setelahthn))
            $rangeArr = range(date("Y", strtotime("-".$sebelumthn." years")),date("Y"));
        else if(empty($sebelumthn) && isset($setelahthn))
            $rangeArr = range(date("Y"),date("Y", strtotime("+".$setelahthn." years")));
        else if(isset($setelahthn) && isset($setelahthn))
            $rangeArr = range(date("Y", strtotime("-".$sebelumthn." years")),date("Y", strtotime("+".$setelahthn." years")));
        
        $tahunArr = array();
        foreach($rangeArr as $value){
            $tahunArr[$value] = $value;
        }
        return $tahunArr;
    }

     /**
     * menampilkan semua bulan
     */
    public static function getBulan(){
        $bulan = array(
                        '01' => 'Januari',
                        '02' => 'Februari',
                        '03' => 'Maret',
                        '04' => 'April',
                        '05' => 'Mei',
                        '06' => 'Juni',
                        '07' => 'Juli',
                        '08' => 'Agustus',
                        '09' => 'September',
                        '10' => 'Oktober',
                        '11' => 'November',
                        '12' => 'Desember'
            );
        return $bulan;
    }

    /**
     * menampilkan list angka dari $dari sampai $sampai
     * @param type $dari
     * @param type $sampai
     * @return array
     */
    public static function getDaftarAngka($dari = 1, $sampai = 20)
    {
        for ($i = $dari; $i <= $sampai; $i++) {
            $angka[$i] = $i;
        } 
        return $angka;
    }
    /**
     * menampilkan urutan dari angka kedalam text
     * @param type $dari
     * @param type $sampai
     * @return array | ex: [3]=>"ketiga"
     */
    public static function getNomorUrutText($dari = 1, $sampai = 20){
        $format = new MyFormatter();
        for ($i = $dari; $i <= $sampai; $i++) {
            $angka[$i] = "Ke".$format->kataTerbilang($i);
        } 
        return $angka;       
    }
    /**
     * menampilkan list status bayar
     * @return array | sudah = true, belum = false
     */
    public static function getStatusBayar(){
        return array(
            false=>'Belum Bayar',
            true=>'Sudah Bayar',
        );
    }
    
    /*
     * Params ubah angka ke Romawi 
     */
    public static function Romawi($n){
		$n=(int)$n;
        $hasil = "";
        $iromawi =
        array("","I","II","III","IV","V","VI","VII","VIII","IX","X",
        20=>"XX",30=>"XXX",40=>"XL",50=>"L",60=>"LX",70=>"LXX",80=>"LXXX",
        90=>"XC",100=>"C",200=>"CC",300=>"CCC",400=>"CD",500=>"D",
        600=>"DC",700=>"DCC",800=>"DCCC",900=>"CM",1000=>"M",
        2000=>"MM",3000=>"MMM");

            if(array_key_exists($n,$iromawi)){
            $hasil = $iromawi[$n];
            }elseif($n >= 11 && $n <= 99){
            $i = $n % 10;
            $hasil = $iromawi[$n-$i] . self::Romawi($n % 10);
            }elseif($n >= 101 && $n <= 999){
            $i = $n % 100;
            $hasil = $iromawi[$n-$i] . self::Romawi($n % 100);
            }else{
            $i = $n % 1000;
            $hasil = $iromawi[$n-$i] . self::Romawi($n % 1000);
        }
        return $hasil;
    }
    
	/**
	 * Menggabungkan 2 array
	 * @param type $array_a : format([i]=>array([key]=>value))
	 * @param type $array_b : format([i]=>array([key]=>value))
	 * @param type $fkey = foreign key (acuan dalam penggabungan array)
	 * @return type
	 */
	public static function joinTwo2DArrays($array_a, $array_b, $fkey){
		//switch ke array yg lebih lengkap nilainya untuk dijadikan acuan
		if(count($array_b) > count($array_a)){
			$array_temp = $array_a;
			$array_a = $array_b;
			$array_b = $array_temp;
		}
		if(count($array_a) > 0 && count($array_b) > 0){
			foreach($array_a AS $i => $data_a){
				foreach($array_b AS $ii => $data_b){
					if($array_a[$i][$fkey] == $array_b[$ii][$fkey]){
						if(count($array_b[$ii]) > 1){
							foreach($array_b[$ii] AS $iii => $attr){
								$array_a[$i][$iii] = $array_b[$ii][$iii];
							}
						}
					}
				}
			}
		}
		
		return $array_a;
	}
	/**
	 * konversi character tertentu ke simbol yang diinginkan
	 * @param type $string
	 * @return type
	 */
	public static function symbolsConverter($string){
		//== 1. replace ^($string) to <sup>($string)</sup> ==
		$value = preg_replace("/\^(\w*)/", "<sup>$1</sup>", $string);
		
		return $value;
	}
	
	/**
	 * kirim data php socket ke telnet (untuk dimasukkan ke led matrix)
	 * MIC-91
	 */
	public static function postTelnet($data){
		if(Yii::app()->user->getState('is_telnetaktif')){
			$address = Yii::app()->user->getState('telnet_host');
			$port = Yii::app()->user->getState('telnet_port');
			$socket = socket_create(AF_INET, SOCK_STREAM, 0) OR FALSE;
			if($socket){
				if(socket_connect($socket, $address, $port)){
					socket_write($socket, $data);
					socket_close($socket);
				}
			}
		}
	}
		
	/**
	 * kirim php socket untuk HL-7 Broker
	 * RND-8272
	 * $data = string
	 * $prefix = 'ADD' (untuk menambahkan) / 'DEL' (untuk menghapus)
	 */
	public static function postHL7Broker($prefix="ADD", $data){
		$data = $prefix."+".$data."\n";
		if(Yii::app()->user->getState('hl7broker_aktif')){
			$address = Yii::app()->user->getState('hl7broker_host');
			$port = Yii::app()->user->getState('hl7broker_port');
			$socket = socket_create(AF_INET, SOCK_STREAM, 0) OR FALSE;
			if($socket){
				if(socket_connect($socket, $address, $port)){
					socket_write($socket, $data);
					socket_close($socket);
				}
			}
		}
	}
    
}
?>
