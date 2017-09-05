<?php
/**
 * class ini digunakan untuk bridging mobile apps dengan sistem utama
 */
ini_set('memory_limit', '128M');
class MPasienBridgingController extends MyMobileAuthController
{
    public $defaultAction = "Index";
    public $layout = "//layouts/iframe";

    public function actionIndex()
    {
        $this->render('index');
    }
    
    /**
     * menampilkan riwayat kunjungan pasien
     * Issue: MA-4
     * @param : $_GET['pasien_id']
     * @return json array
     */
    public function actionGetRiwayatKunjunganPasien()
    {
        header("content-type:application/json");
        $format = new MyFormatter();
        $data = array();
        if(isset($_GET['pasien_id'])){
            $pasien_id = $_GET['pasien_id'];
            $sql = "SELECT pasien_m.no_rekam_medik, pasien_m.namadepan, pasien_m.nama_pasien, pasien_m.tempat_lahir, pasien_m.tanggal_lahir, pasien_m.jeniskelamin,pasien_m.statusperkawinan, pasien_m.alamat_pasien, pasien_m.no_telepon_pasien,pasien_m.photopasien,pekerjaan_m.pekerjaan_nama, 
                    pendaftaran_t.tgl_pendaftaran, ruangan_m.ruangan_id, ruangan_m.ruangan_nama, pegawai_m.gelardepan AS gelardepan_dokter, pegawai_m.nama_pegawai AS nama_dokter,
                    pasienmasukpenunjang_t.pasienmasukpenunjang_id, pasienmasukpenunjang_t.tglmasukpenunjang, ruanganpenunjang_m.ruangan_id AS ruanganpenunjang_id, ruanganpenunjang_m.ruangan_nama AS ruanganpenunjang_nama,  pasienadmisi_t.pasienadmisi_id, pasienadmisi_t.tgladmisi, ruanganadmisi_m.ruangan_id AS ruanganadmisi_id, ruanganadmisi_m.ruangan_nama AS ruanganadmisi_nama, dokteradmisi_m.gelardepan AS gelardepan_dokteradmisi, dokteradmisi_m.nama_pegawai AS nama_dokteradmisi, dokterpenunjang_m.gelardepan AS gelardepan_dokterpenunjang, dokterpenunjang_m.nama_pegawai AS nama_dokterpenunjang 
                    FROM pendaftaran_t
                    JOIN pasien_m ON pasien_m.pasien_id = pendaftaran_t.pasien_id 
                    LEFT JOIN pekerjaan_m ON pekerjaan_m.pekerjaan_id = pasien_m.pekerjaan_id 
                    LEFT JOIN pasienmasukpenunjang_t ON pasienmasukpenunjang_t.pendaftaran_id = pendaftaran_t.pendaftaran_id 
                    LEFT JOIN pasienadmisi_t ON pasienadmisi_t.pasienadmisi_id = pendaftaran_t.pasienadmisi_id
                    JOIN ruangan_m ON ruangan_m.ruangan_id = pendaftaran_t.ruangan_id 
                    LEFT JOIN ruangan_m ruanganpenunjang_m ON ruanganpenunjang_m.ruangan_id = pasienmasukpenunjang_t.ruangan_id 
                    LEFT JOIN ruangan_m ruanganadmisi_m ON ruanganadmisi_m.ruangan_id = pasienadmisi_t.ruangan_id 
                    JOIN pegawai_m ON pegawai_m.pegawai_id = pendaftaran_t.pegawai_id
                    LEFT JOIN pegawai_m dokterpenunjang_m ON dokterpenunjang_m.pegawai_id = pasienmasukpenunjang_t.pegawai_id 
                    LEFT JOIN pegawai_m dokteradmisi_m ON dokteradmisi_m.pegawai_id = pasienadmisi_t.pegawai_id 
                    LEFT JOIN pasienbatalperiksa_r pasienbatalpenunjang_r ON pasienbatalpenunjang_r.pasienmasukpenunjang_id = pasienmasukpenunjang_t.pasienmasukpenunjang_id 
                    WHERE pasienbatalpenunjang_r.pasienbatalperiksa_id IS NULL AND pendaftaran_t.pasienbatalperiksa_id IS NULL AND pendaftaran_t.pasien_id = ".$pasien_id."
                    ORDER BY pendaftaran_t.tgl_pendaftaran DESC, pasienmasukpenunjang_t.tglmasukpenunjang DESC, pasienadmisi_t.tgladmisi DESC 
                    LIMIT 3";
            $loadDatas = Yii::app()->db->createCommand($sql)->queryAll();

            if(count($loadDatas) > 0){
                //echo "a";exit;
                $data['nama_pasien'] = $loadDatas[0]['namadepan']." ".$loadDatas[0]['nama_pasien'];
                $data['no_rekam_medik'] = $loadDatas[0]['no_rekam_medik'];
                $data['tempat_lahir'] = $loadDatas[0]['tempat_lahir'];
                $data['tanggal_lahir'] = $format->formatDateTimeId($loadDatas[0]['tanggal_lahir']);
                $data['jeniskelamin'] = $loadDatas[0]['jeniskelamin'];
                $data['pekerjaan_nama'] = $loadDatas[0]['jeniskelamin'];
                $data['statusperkawinan'] = $loadDatas[0]['statusperkawinan'];
                $data['alamat_pasien'] = $loadDatas[0]['alamat_pasien'];
                $data['no_telepon_pasien'] = $loadDatas[0]['no_telepon_pasien'];
                $data['photopasien'] = $loadDatas[0]['photopasien'];
                $data['pekerjaan_nama'] = $loadDatas[0]['pekerjaan_nama'];
                foreach($loadDatas AS $i => $val){
                    if(!empty($val['pasienmasukpenunjang_id'])){
                        $data['riwayatkunjungan'][$i]['tanggal'] = $format->formatDateTimeId($val['tglmasukpenunjang']);
                        $data['riwayatkunjungan'][$i]['ruangan_id'] = $val['ruanganpenunjang_id'];
                        $data['riwayatkunjungan'][$i]['ruangan_nama'] = $val['ruanganpenunjang_nama'];
                        $data['riwayatkunjungan'][$i]['nama_dokter'] = $val['gelardepan_dokterpenunjang']." ".$val['nama_dokterpenunjang'];
                    }else if(!empty($val['pasienadmisi_id'])){
                        $data['riwayatkunjungan'][$i]['tanggal'] = $format->formatDateTimeId($val['tgladmisi']);
                        $data['riwayatkunjungan'][$i]['ruangan_id'] = $val['ruanganadmisi_id'];
                        $data['riwayatkunjungan'][$i]['ruangan_nama'] = $val['ruanganadmisi_nama'];
                        $data['riwayatkunjungan'][$i]['nama_dokter'] = $val['gelardepan_dokteradmisi']." ".$val['nama_dokteradmisi'];
                    }else{
                        $data['riwayatkunjungan'][$i]['tanggal'] = $format->formatDateTimeId($val['tgl_pendaftaran']);
                        $data['riwayatkunjungan'][$i]['ruangan_id'] = $val['ruangan_id'];
                        $data['riwayatkunjungan'][$i]['ruangan_nama'] = $val['ruangan_nama'];
                        $data['riwayatkunjungan'][$i]['nama_dokter'] = $val['gelardepan_dokter']." ".$val['nama_dokter'];
                    }
                }
            }else{

                $sql1 = "SELECT pasien_m.no_rekam_medik, 
                pasien_m.namadepan, pasien_m.nama_pasien, 
                pasien_m.tempat_lahir, pasien_m.tanggal_lahir, 
                pasien_m.jeniskelamin, pasien_m.statusperkawinan, 
                pasien_m.alamat_pasien, pasien_m.no_telepon_pasien,
                pasien_m.photopasien, pekerjaan_m.pekerjaan_nama
                FROM  pasien_m 
                LEFT JOIN pekerjaan_m ON pekerjaan_m.pekerjaan_id = pasien_m.pekerjaan_id 
                WHERE  pasien_m.pasien_id = ".$pasien_id."
                ";
                $loadDatas1 = Yii::app()->db->createCommand($sql1)->queryRow();
                $data['nama_pasien'] = $loadDatas1['namadepan']." ".$loadDatas1['nama_pasien'];
                $data['tempat_lahir'] = $loadDatas1['tempat_lahir'];
                $data['tanggal_lahir'] = $format->formatDateTimeId($loadDatas1['tanggal_lahir']);
                $data['jeniskelamin'] = $loadDatas1['jeniskelamin'];
                $data['pekerjaan_nama'] = $loadDatas1['jeniskelamin'];
                $data['statusperkawinan'] = $loadDatas1['statusperkawinan'];
                $data['alamat_pasien'] = $loadDatas1['alamat_pasien'];
                $data['no_telepon_pasien'] = $loadDatas1['no_telepon_pasien'];
                $data['photopasien'] = "jsonCallback(".Params::urlPhotoPasienDirectory().$loadDatas1['photopasien'].")";
                $data['pekerjaan_nama'] = $loadDatas1['pekerjaan_nama'];
            }
        }else{
            $data['pesan'] = "Error 404. Request tidak valid!";
        }
        $encode = CJSON::encode($data);
        echo "jsonCallback(".$encode.")";
        Yii::app()->end();
    }
    /**
     * menampilkan data ruangan, kamar dan tarif
     * @param $_GET['q']
     * @return json
     */
    public function actionGetInfoRuangan(){
        header("content-type:application/json");
        $format = new MyFormatter();
        $data = array();
        $req = (isset($_GET['q']) ? str_replace('"','',str_replace("'","",strtolower(trim($_GET['q'])))) : "");
        $sql = "SELECT ruangan_m.ruangan_id, ruangan_m.ruangan_nama, 
                kamarruangan_m.kamarruangan_id, kamarruangan_m.kamarruangan_nokamar, kamarruangan_m.kamarruangan_nobed, kamarruangan_m.kamarruangan_jmlbed, kamarruangan_m.kamarruangan_image, kamarruangan_m.keterangan_kamar, 
                kelaspelayanan_m.kelaspelayanan_id, kelaspelayanan_m.kelaspelayanan_nama, daftartindakan_m.daftartindakan_id, daftartindakan_m.daftartindakan_nama, daftartindakan_m.daftartindakan_namalainnya, tariftindakan_m.harga_tariftindakan AS tarif
                FROM tariftindakan_m
                JOIN daftartindakan_m ON daftartindakan_m.daftartindakan_id = tariftindakan_m.daftartindakan_id
                JOIN tindakanruangan_m ON tindakanruangan_m.daftartindakan_id = tariftindakan_m.daftartindakan_id
                JOIN ruangan_m ON ruangan_m.ruangan_id = tindakanruangan_m.ruangan_id
                JOIN kamarruangan_m ON kamarruangan_m.ruangan_id = ruangan_m.ruangan_id AND kamarruangan_m.kelaspelayanan_id = tariftindakan_m.kelaspelayanan_id
                JOIN kelaspelayanan_m ON kelaspelayanan_m.kelaspelayanan_id = tariftindakan_m.kelaspelayanan_id
                JOIN jenistarifpenjamin_m ON jenistarifpenjamin_m.jenistarif_id = tariftindakan_m.jenistarif_id
                WHERE daftartindakan_m.daftartindakan_aktif = TRUE 
                AND daftartindakan_m.daftartindakan_akomodasi = TRUE 
                AND ruangan_m.ruangan_aktif = TRUE 
                AND kamarruangan_m.kamarruangan_aktif = TRUE
                AND jenistarifpenjamin_m.penjamin_id = 1
                AND
                (LOWER(ruangan_m.ruangan_nama) like '%".$req."%'
                OR LOWER(kamarruangan_m.kamarruangan_nokamar) like '%".$req."%'
                OR LOWER(kamarruangan_m.kamarruangan_nobed) like '%".$req."%'
                OR LOWER(kamarruangan_m.keterangan_kamar) like '%".$req."%'
                OR LOWER(daftartindakan_m.daftartindakan_nama) like '%".$req."%')
                ORDER BY kamarruangan_m.keterangan_kamar DESC
                LIMIT 5";
        $loadDatas = Yii::app()->db->createCommand($sql)->queryAll();
        if(count($loadDatas) > 0){
            foreach($loadDatas AS $i => $val){
                $data[$i] = $val;
            }
        }
        $encode = CJSON::encode($data);
        echo "jsonCallback(".$encode.")";
        Yii::app()->end();
    } 
    
    /**
     * transaksi booking kamar
     * @param $_GET['pasien_id']
     * @param $_GET['ruangan_id']
     * @param $_GET['kamarruangan_id']
     * @param $_GET['kelaspelayanan_id']
     * @return json
     */
    public function actionBookingKamar(){
        header("content-type:application/json");
        $data = array();
        $data['sukses'] = 0;
        $data['pesan'] = 'Error 404 : Request tidak valid. Cek parameter';
        if(isset($_GET['pasien_id']) && isset($_GET['ruangan_id']) && isset($_GET['kamarruangan_id']) && isset($_GET['kelaspelayanan_id'])){
            $transaction = Yii::app()->db->beginTransaction();
            try{
                $model = new MOBookingkamarT;
                $model->tglbookingkamar = date('Y-m-d H:i:s');
                $model->tgltransaksibooking = date('Y-m-d H:i:s');
                $model->pasien_id = $_GET['pasien_id'];
                $model->ruangan_id = $_GET['ruangan_id'];
                $model->kamarruangan_id = $_GET['kamarruangan_id'];
                $model->kelaspelayanan_id = $_GET['kelaspelayanan_id'];
                $model->statuskonfirmasi = Params::STATUSKONFIRMASI_BOOKING_BELUM;
                $model->keteranganbooking = "Booking kamar via m-Pasien";
                $model->statusbooking = Params::STATUSBOOKING_NON_ANTRI;
                $model->create_time = date('Y-m-d H:i:s');
                $model->create_loginpemakai_id = 1;
                $model->bookingkamar_no = MyGenerator::noBookingKamar();
                
                if($model->save()){
                    KamarruanganM::model()->updateByPk($model->kamarruangan_id,array('keterangan_kamar'=>  Params::KETERANGANKAMAR_DIPESAN));
                    $transaction->commit();
                    $data['sukses'] = 1;
                    $data['pesan'] = 'Data booking kamar berhasil disimpan!';
                }else{
                    $transaction->rollback();
                    $data['sukses'] = 0;
                    $data['pesan'] = 'Data booking kamar gagal disimpan!';
                }
            }catch (Exception $exc) {
                $transaction->rollback();
                $data['sukses'] = 0;
                $data['pesan'] = 'Data booking kamar gagal disimpan!'.MyExceptionMessage::getMessage($exc,true);
            }
            
        }
        $encode = CJSON::encode($data);
        echo "jsonCallback(".$encode.")";
        Yii::app()->end();
    }
    
    /**
     * menampilkan data tarif atau paket checkup
     * Issue: MA-15
     * @param : $_GET['r']
     * @param : $_GET['is_paket'] 0 = bukan paket | 1 = paket
     * @return json array
     */
    public function actionGetInfoTarifTindakan()
    {
        header("content-type:application/json");
        $format = new MyFormatter();
        $data = array();
        $req = (isset($_GET['q']) ? str_replace('"','',str_replace("'","",strtolower(trim($_GET['q'])))) : "");
        $is_paket = (isset($_GET['is_paket']) ? $_GET['is_paket'] : null);
        if($is_paket){ // paket
			$sql = "SELECT tipepaket_m.tipepaket_id, tipepaket_m.tipepaket_nama FROM tipepaket_m";
			$loadDatas = Yii::app()->db->createCommand($sql)->queryAll();
//			if(count($loadDatas) > 0){
//				foreach($loadDatas AS $i => $val){
//					$sql = "SELECT paketpelayanan_m.namatindakan, paketpelayanan_m.tarifpaketpel, 
//						daftartindakan_m.daftartindakan_nama, daftartindakan_m.daftartindakan_namalainnya FROM tipepaket_m 
//					JOIN daftartindakan_m ON paketpelayanan_m.daftartindakan_id=daftartindakan_m.daftartindakan_id
//					WHERE LOWER(daftartindakan_m.daftartindakan_nama) like '%".$req."%'
//                    OR LOWER(daftartindakan_m.daftartindakan_namalainnya) like '%".$req."%' 
//                    OR LOWER(tipepaket_m.tipepaket_nama) like '%".$req."%' ORDER BY tipepaket_id ASC";
//					
//					$data[$i] = $val;
//					$loadDatas = Yii::app()->db->createCommand($sql)->queryAll();
//					
//				}
//				print_r($data);
//					exit;
//			}
			$sql = "SELECT tipepaket_m.tarifpaket, tipepaket_m.tipepaket_id, tipepaket_m.tipepaket_nama, 
						paketpelayanan_m.namatindakan, paketpelayanan_m.tarifpaketpel, 
						daftartindakan_m.daftartindakan_nama, daftartindakan_m.daftartindakan_namalainnya FROM tipepaket_m 
					JOIN paketpelayanan_m ON tipepaket_m.tipepaket_id=paketpelayanan_m.tipepaket_id
					JOIN daftartindakan_m ON paketpelayanan_m.daftartindakan_id=daftartindakan_m.daftartindakan_id
					WHERE LOWER(daftartindakan_m.daftartindakan_nama) like '%".$req."%'
                    OR LOWER(daftartindakan_m.daftartindakan_namalainnya) like '%".$req."%' 
                    OR LOWER(tipepaket_m.tipepaket_nama) like '%".$req."%' ORDER BY tipepaket_id ASC";
			$loadDatas = Yii::app()->db->createCommand($sql)->queryAll();
			if(count($loadDatas) > 0){
				foreach($loadDatas AS $i => $val){
					$data[$i] = $val;
				}
			}
//			$sql = "SELECT daftartindakan_m.daftartindakan_nama, daftartindakan_m.daftartindakan_namalainnya, daftartindakan_m.daftartindakan_katakunci, 
//                kelaspelayanan_m.kelaspelayanan_nama,
//                tipepaket_m.tarifpaket AS harga_tariftindakan, (tipepaket_m.paketsubsidiasuransi + tipepaket_m.paketsubsidipemerintah + tipepaket_m.paketsubsidirs) AS hargadiskon_tind
//                FROM daftartindakan_m
//                JOIN paketpelayanan_m ON daftartindakan_m.daftartindakan_id = paketpelayanan_m.daftartindakan_id
//                JOIN tipepaket_m ON tipepaket_m.tipepaket_id = paketpelayanan_m.tipepaket_id
//                JOIN kelaspelayanan_m ON tipepaket_m.kelaspelayanan_id = kelaspelayanan_m.kelaspelayanan_id
//                JOIN carabayar_m ON tipepaket_m.carabayar_id = carabayar_m.carabayar_id
//                JOIN penjaminpasien_m ON tipepaket_m.penjamin_id = penjaminpasien_m.penjamin_id
//                WHERE tipepaket_m.tipepaket_aktif = true AND daftartindakan_m.daftartindakan_aktif = true
//                    AND 
//                    (LOWER(daftartindakan_m.daftartindakan_nama) like '%".$req."%'
//                    OR LOWER(daftartindakan_m.daftartindakan_namalainnya) like '%".$req."%' 
//                    OR LOWER(daftartindakan_m.daftartindakan_katakunci) like '%".$req."%')
//                ORDER BY daftartindakan_m.daftartindakan_nama 
//                LIMIT 5";
        }else{ // non-paket
            $sql = "SELECT daftartindakan_m.daftartindakan_nama, daftartindakan_m.daftartindakan_namalainnya, daftartindakan_m.daftartindakan_katakunci, 
                jenistarif_m.jenistarif_nama, 
                komponentarif_m.komponentarif_nama, tariftindakan_m.harga_tariftindakan, 
                CASE
                    WHEN tariftindakan_m.persendiskon_tind > 0::double precision THEN tariftindakan_m.harga_tariftindakan * tariftindakan_m.persendiskon_tind / 100
                    ELSE tariftindakan_m.hargadiskon_tind 
                    END AS hargadiskon_tind,
                tariftindakan_m.persencyto_tind, 
                jeniskelas_m.jeniskelas_nama, 
                kelaspelayanan_m.kelaspelayanan_nama, kelaspelayanan_m.kelaspelayanan_namalainnya
                FROM daftartindakan_m
                JOIN tariftindakan_m ON daftartindakan_m.daftartindakan_id = tariftindakan_m.daftartindakan_id
                JOIN perdatarif_m ON tariftindakan_m.perdatarif_id = perdatarif_m.perdatarif_id
                JOIN jenistarif_m ON tariftindakan_m.jenistarif_id = jenistarif_m.jenistarif_id
                JOIN komponentarif_m ON tariftindakan_m.komponentarif_id = komponentarif_m.komponentarif_id
                JOIN kelaspelayanan_m ON tariftindakan_m.kelaspelayanan_id = kelaspelayanan_m.kelaspelayanan_id
                JOIN jeniskelas_m ON kelaspelayanan_m.jeniskelas_id = jeniskelas_m.jeniskelas_id
                WHERE komponentarif_m.komponentarif_id = ".Params::KOMPONENTARIF_ID_TOTAL." 
                    AND perdatarif_m.perda_aktif = true 
                    AND jenistarif_m.jenistarif_id = ".Params::JENISTARIF_ID_PELAYANAN."
                AND 
                (LOWER(daftartindakan_m.daftartindakan_nama) like '%".$req."%'
                OR LOWER(daftartindakan_m.daftartindakan_namalainnya) like '%".$req."%' 
                OR LOWER(daftartindakan_m.daftartindakan_katakunci) like '%".$req."%')
                ORDER BY daftartindakan_m.daftartindakan_nama 
                LIMIT 5";
			
			$loadDatas = Yii::app()->db->createCommand($sql)->queryAll();
			if(count($loadDatas) > 0){
				foreach($loadDatas AS $i => $val){
					$data[$i] = $val;
				}
			}
        }
        
        
        
        
        
        $encode = CJSON::encode($data);
        echo "jsonCallback(".$encode.")";
        Yii::app()->end();
    }
    
    /**
     * menampilkan data tindakan pelayanan dan Obat Alkes pasien
     * Issue: MA-16
     * @param : $_GET['pasien_id']
     * @return json array
     */
    public function actionGetTindakanObatPasien()
    {
        header("content-type:application/json");
        $format = new MyFormatter();
        $data = array();
		$data['tindakan'] = array();
		$data['obatalkes'] = array();
		$data['pembayaran'] = array();
        if(isset($_GET['pasien_id'])){
            $pasien_id = $_GET['pasien_id'];
            $sql = "SELECT pendaftaran_id, pasien_id FROM pendaftaran_t WHERE pasien_id = ".$pasien_id." ORDER BY pendaftaran_id DESC LIMIT 1";
            $loadData = Yii::app()->db->createCommand($sql)->queryRow();
            $pendaftaran_id = (isset($loadData['pendaftaran_id']) ? $loadData['pendaftaran_id'] : null);
            //TINDAKAN
			if(!empty($pendaftaran_id)){
				$sql = "SELECT 
					daftartindakan_m.daftartindakan_nama, tindakanpelayanan_t.tgl_tindakan, tindakanpelayanan_t.tarif_satuan, tindakanpelayanan_t.qty_tindakan, tindakanpelayanan_t.discount_tindakan, (tindakanpelayanan_t.pembebasan_tindakan + tindakanpelayanan_t.subsidiasuransi_tindakan + tindakanpelayanan_t.subsidipemerintah_tindakan + tindakanpelayanan_t.subsisidirumahsakit_tindakan) AS subsidi,tindakanpelayanan_t.tindakansudahbayar_id
					FROM tindakanpelayanan_t
					JOIN daftartindakan_m ON daftartindakan_m.daftartindakan_id = tindakanpelayanan_t.daftartindakan_id
					WHERE tindakanpelayanan_t.pendaftaran_id = ".$pendaftaran_id;
				$loadDatas = Yii::app()->db->createCommand($sql)->queryAll();

				if(count($loadDatas) > 0){
					$data['tindakan']['totalsudahbayar'] = 0;
					$data['tindakan']['totalbelumbayar'] = 0;
					$data['tindakan']['total'] = 0;
					$data['tindakan']['totaldiscount'] = 0;
					$data['tindakan']['totalsubsidi'] = 0;
					foreach($loadDatas AS $i => $val){
						$data['tindakan']['items'][$i] = $val;
						if($val['tindakansudahbayar_id']){
							$data['tindakan']['totalsudahbayar'] += ($val['tarif_satuan'] * $val['qty_tindakan']);
						}else{
							$data['tindakan']['totalbelumbayar'] += ($val['tarif_satuan'] * $val['qty_tindakan']);
						}
						$data['tindakan']['totaldiscount'] += $val['discount_tindakan'];
						$data['tindakan']['totalsubsidi'] += $val['subsidi'];
					}
					$data['tindakan']['total'] = $data['tindakan']['totalsudahbayar'] + $data['tindakan']['totalbelumbayar'];
				}
				//OBATALKES PASIEN
				$sql = "SELECT 
					obatalkes_m.obatalkes_nama, obatalkespasien_t.tglpelayanan, obatalkespasien_t.qty_oa, obatalkespasien_t.hargasatuan_oa, (obatalkespasien_t.biayaservice + obatalkespasien_t.biayakonseling + obatalkespasien_t.jasadokterresep + obatalkespasien_t.biayakemasan + obatalkespasien_t.biayaadministrasi + obatalkespasien_t.tarifcyto) AS biayalain, obatalkespasien_t.discount, (obatalkespasien_t.subsidiasuransi + obatalkespasien_t.subsidipemerintah + obatalkespasien_t.subsidirs) AS subsidi , obatalkespasien_t.oasudahbayar_id
					FROM obatalkespasien_t
					JOIN obatalkes_m ON obatalkes_m.obatalkes_id = obatalkespasien_t.obatalkes_id
					WHERE obatalkespasien_t.pendaftaran_id = ".$pendaftaran_id;
				$loadDatas = Yii::app()->db->createCommand($sql)->queryAll();

				if(count($loadDatas) > 0){
					$data['obatalkes']['totalsudahbayar'] = 0;
					$data['obatalkes']['totalbelumbayar'] = 0;
					$data['obatalkes']['total'] = 0;
					$data['obatalkes']['totalbiayalain'] = 0;
					$data['obatalkes']['totaldiscount'] = 0;
					$data['obatalkes']['totalsubsidi'] = 0;
					foreach($loadDatas AS $i => $val){
						$data['obatalkes']['items'][$i] = $val;
						if($val['oasudahbayar_id']){
							$data['obatalkes']['totalsudahbayar'] += ($val['qty_oa'] * $val['hargasatuan_oa']);
						}else{
							$data['obatalkes']['totalbelumbayar'] += ($val['qty_oa'] * $val['hargasatuan_oa']);
						}
						$data['obatalkes']['totalbiayalain'] += $val['biayalain'];
						$data['obatalkes']['totaldiscount'] += $val['discount'];
						$data['obatalkes']['totalsubsidi'] += $val['subsidi'];
					}
					$data['obatalkes']['total'] = $data['obatalkes']['totalsudahbayar'] + $data['obatalkes']['totalbelumbayar'];
				}
				//PEMBAYARAN
				$sql = "SELECT SUM(tandabuktibayar_t.biayaadministrasi) AS biayaadministrasi, SUM(tandabuktibayar_t.biayamaterai) AS biayamaterai, SUM(tandabuktibayar_t.jmlpembulatan) AS jmlpembulatan, SUM(pembayaranpelayanan_t.totalbayartindakan) AS totalbayartindakan, SUM(pembayaranpelayanan_t.totalsisatagihan) AS totalsisatagihan
					FROM pembayaranpelayanan_t
					JOIN tandabuktibayar_t ON tandabuktibayar_t.pembayaranpelayanan_id = pembayaranpelayanan_t.pembayaranpelayanan_id
					WHERE pembayaranpelayanan_t.pendaftaran_id = ".$pendaftaran_id."
					GROUP BY pembayaranpelayanan_t.pendaftaran_id";
				$loadData = Yii::app()->db->createCommand($sql)->queryRow();
				$data['pembayaran'] = $loadData;
			}
        }else{
            $data['pesan'] = "Error 404. Request tidak valid!";
        }
        $encode = CJSON::encode($data);
        echo "jsonCallback(".$encode.")";
        Yii::app()->end();
    }
    
    
    /**
     * menampilkan riwayat penunjang pasien
     * Issue: MA-24
     * @param : $_GET['bulan'] format: yyyy-mm
     * @param : $_GET['pasien_id']
     * @return json array
     */
    public function actionGetRiwayatPenunjang()
    {
        header("content-type:application/json");
        $format = new MyFormatter();
        $data = array();
        if(isset($_GET['pasien_id']) && isset($_GET['bulan'])){
            $pasien_id = $_GET['pasien_id'];
            $bulan = $_GET['bulan'];
            if(empty($bulan)){ //DEFAULT NILAI JIKA TIDAK ADA BULAN MA-129
                $sql_terakhir = "SELECT pasienmasukpenunjang_t.tglmasukpenunjang
                    FROM tindakanpelayanan_t
                    JOIN pasienmasukpenunjang_t ON pasienmasukpenunjang_t.pasienmasukpenunjang_id = tindakanpelayanan_t.pasienmasukpenunjang_id
                    JOIN pendaftaran_t ON pendaftaran_t.pendaftaran_id = tindakanpelayanan_t.pendaftaran_id
                    JOIN ruangan_m ruanganpenunjang_m ON ruanganpenunjang_m.ruangan_id = pasienmasukpenunjang_t.ruangan_id
                    WHERE pendaftaran_t.pasienbatalperiksa_id IS NULL
                        AND pasienmasukpenunjang_t.pasien_id = ".$pasien_id."
                    ORDER BY pendaftaran_t.tgl_pendaftaran DESC, pasienmasukpenunjang_t.tglmasukpenunjang DESC, ruanganpenunjang_m.ruangan_nama ASC
                    LIMIT 1";
                $loadData = Yii::app()->db->createCommand($sql_terakhir)->queryRow();
                if($loadData){
                    $bulan = substr($loadData['tglmasukpenunjang'], 0, 7);
                }
            }
            $sql = "SELECT pendaftaran_t.no_pendaftaran,pasienmasukpenunjang_t.pasienmasukpenunjang_id,ruanganpenunjang_m.ruangan_id,ruanganpenunjang_m.ruangan_nama,pasienmasukpenunjang_t.no_masukpenunjang,pasienmasukpenunjang_t.tglmasukpenunjang,kelaspelayanan_m.kelaspelayanan_nama,dokterpenunjang_m.gelardepan, dokterpenunjang_m.nama_pegawai, gelarbelakang_m.gelarbelakang_nama,daftartindakan_m.daftartindakan_nama,tindakanpelayanan_t.qty_tindakan
                FROM tindakanpelayanan_t
                JOIN daftartindakan_m ON daftartindakan_m.daftartindakan_id = tindakanpelayanan_t.daftartindakan_id
                JOIN pasienmasukpenunjang_t ON pasienmasukpenunjang_t.pasienmasukpenunjang_id = tindakanpelayanan_t.pasienmasukpenunjang_id
                JOIN kelaspelayanan_m ON kelaspelayanan_m.kelaspelayanan_id = pasienmasukpenunjang_t.kelaspelayanan_id
                JOIN pegawai_m dokterpenunjang_m ON dokterpenunjang_m.pegawai_id = pasienmasukpenunjang_t.pegawai_id
                LEFT JOIN gelarbelakang_m ON gelarbelakang_m.gelarbelakang_id = dokterpenunjang_m.gelarbelakang_id
                JOIN pendaftaran_t ON pendaftaran_t.pendaftaran_id = tindakanpelayanan_t.pendaftaran_id
                JOIN ruangan_m ruanganpenunjang_m ON ruanganpenunjang_m.ruangan_id = pasienmasukpenunjang_t.ruangan_id
                WHERE 
                    pendaftaran_t.pasienbatalperiksa_id IS NULL
                    AND pasienmasukpenunjang_t.pasien_id = ".$pasien_id."
                    AND TO_CHAR(pasienmasukpenunjang_t.tglmasukpenunjang,'YYYY-MM') = '".$bulan."'
                ORDER BY pendaftaran_t.tgl_pendaftaran DESC, pasienmasukpenunjang_t.tglmasukpenunjang DESC, ruanganpenunjang_m.ruangan_nama ASC
                LIMIT 5
                ";
            $loadDatas = Yii::app()->db->createCommand($sql)->queryAll();

            if(count($loadDatas) > 0){
                foreach($loadDatas AS $i => $val){
                    $data['riwayatpenunjang'][$val['pasienmasukpenunjang_id']]['pasienmasukpenunjang_id'] = $val['pasienmasukpenunjang_id'];
                    $data['riwayatpenunjang'][$val['pasienmasukpenunjang_id']]['no_masukpenunjang'] = $val['no_masukpenunjang'];
                    $data['riwayatpenunjang'][$val['pasienmasukpenunjang_id']]['ruangan_id'] = $val['ruangan_id'];
                    $data['riwayatpenunjang'][$val['pasienmasukpenunjang_id']]['ruangan_nama'] = $val['ruangan_nama'];
                    $data['riwayatpenunjang'][$val['pasienmasukpenunjang_id']]['tglmasukpenunjang'] = $val['tglmasukpenunjang'];
                    $data['riwayatpenunjang'][$val['pasienmasukpenunjang_id']]['kelaspelayanan_nama'] = $val['kelaspelayanan_nama'];
                    $data['riwayatpenunjang'][$val['pasienmasukpenunjang_id']]['nama_dokter'] = $val['gelardepan']." ".$val['nama_pegawai']." ".$val['gelarbelakang_nama'];
                    $data['riwayatpenunjang'][$val['pasienmasukpenunjang_id']]['pemeriksaan'][$i] = $val['daftartindakan_nama'];
                }
            }
        }else{
            $data['pesan'] = "Error 404. Request tidak valid!";
        }
        $encode = CJSON::encode($data);
        echo "jsonCallback(".$encode.")";
        Yii::app()->end();
    }
    
    /**
     * menampilkan data menu diet (makanan)
     * MA-26
     * @param $_GET['q']
     * @return json
     */
    public function actionGetInfoMenuMakanan(){
        header("content-type:application/json");
        $format = new MyFormatter();
        $data = array();
        $req = (isset($_GET['q']) ? str_replace('"','',str_replace("'","",strtolower(trim($_GET['q'])))) : "");
        $sql = "SELECT jenisdiet_m.jenisdiet_id, jenisdiet_m.jenisdiet_nama, jenisdiet_m.jenisdiet_namalainnya, menudiet_m.menudiet_id, menudiet_m.menudiet_nama, menudiet_m.menudiet_namalain, menudiet_m.jml_porsi, menudiet_m.ukuranrumahtangga, tariftindakan_m.harga_tariftindakan, tariftindakan_m.persendiskon_tind, tariftindakan_m.hargadiskon_tind, penjaminpasien_m.penjamin_nama, kelaspelayanan_m.kelaspelayanan_nama
            FROM menudiet_m
            JOIN jenisdiet_m ON jenisdiet_m.jenisdiet_id = menudiet_m.jenisdiet_id
            LEFT JOIN tariftindakan_m ON tariftindakan_m.daftartindakan_id = menudiet_m.daftartindakan_id
            LEFT JOIN jenistarifpenjamin_m ON jenistarifpenjamin_m.jenistarif_id = tariftindakan_m.jenistarif_id
            LEFT JOIN penjaminpasien_m ON penjaminpasien_m.penjamin_id = jenistarifpenjamin_m.penjamin_id
            LEFT JOIN kelaspelayanan_m ON kelaspelayanan_m.kelaspelayanan_id = tariftindakan_m.kelaspelayanan_id
            WHERE jenisdiet_m.jenisdiet_aktif = TRUE 
                AND tariftindakan_m.kelaspelayanan_id = ".Params::KELASPELAYANAN_ID_TANPA_KELAS." 
                AND jenistarifpenjamin_m.penjamin_id = ".Params::PENJAMIN_ID_UMUM."
                AND(
                    LOWER(jenisdiet_m.jenisdiet_nama) like '%".$req."%'
                    OR LOWER(jenisdiet_m.jenisdiet_namalainnya) like '%".$req."%' 
                    OR LOWER(menudiet_m.menudiet_nama) like '%".$req."%' 
                    OR LOWER(menudiet_m.menudiet_namalain) like '%".$req."%' 
                    OR TO_CHAR(tariftindakan_m.harga_tariftindakan,'999999999999999999') like '%".str_replace(".", "", $req)."%'
                )
            ORDER BY jenisdiet_nama ASC, menudiet_nama ASC, harga_tariftindakan DESC
            LIMIT 5";
        $loadDatas = Yii::app()->db->createCommand($sql)->queryAll();
        if(count($loadDatas) > 0){
            $sql_jeniswaktu = "SELECT * 
                FROM jeniswaktu_m
                WHERE jeniswaktu_aktif = TRUE";
            $loadDataJenisWaktus = Yii::app()->db->createCommand($sql_jeniswaktu)->queryAll();
            foreach($loadDatas AS $i => $val){
                $data[$i] = $val;
                $data[$i]['jeniswaktu'] = $loadDataJenisWaktus;
            }
        }
        $encode = CJSON::encode($data);
        echo "jsonCallback(".$encode.")";
        Yii::app()->end();
    } 
    
    /**
     * transaksi pemesanan menu makanan
     * MA-27
     * @param $_GET['pasien_id']
     * @param $_GET['menus'][] array (jenisdiet_id,menudiet_id, jeniswaktu_id)
     * @return ['sukses'] = 0/1
     * @return ['pesan'] = string
     */
    public function actionPesanMenuMakanan(){
        header("content-type:application/json");
        $data = array();
        $data['sukses'] = 0;
        $data['pesan'] = 'Error 404 : Request tidak valid. Cek parameter';
        $menus = array();
        
        if(isset($_GET['pasien_id']) && count($_GET['menus']) > 0){
            $transaction = Yii::app()->db->beginTransaction();
            try{
                $sql = "SELECT pendaftaran_t.pendaftaran_id, pasienadmisi_t.pasienadmisi_id, pasien_m.pasien_id, pasien_m.namadepan, pasien_m.nama_pasien, pendaftaran_t.ruangan_id, pasienadmisi_t.ruangan_id AS ruanganadmisi_id
                    FROM pendaftaran_t
                    JOIN pasien_m ON pasien_m.pasien_id = pendaftaran_t.pasien_id
                    LEFT JOIN pasienadmisi_t ON pasienadmisi_t.pasienadmisi_id = pendaftaran_t.pasienadmisi_id
                    WHERE pendaftaran_t.pasien_id = ".$_GET['pasien_id']."
                    LIMIT 1";
                $loadData = Yii::app()->db->createCommand($sql)->queryRow();
                if(empty($loadData)){
                    $data['sukses'] = 0;
                    $data['pesan'] = 'Data gagal disimpan! Pasien tidak sedang melakukan kunjungan RS';
                }else{
                    $model = new MOPesanmenudietT;
                    $model->tglpesanmenu = date('Y-m-d H:i:s');
                    $model->ruangan_id = (!empty($loadData['ruanganadmisi_id']) ? $loadData['ruanganadmisi_id'] : $loadData['ruangan_id']);
                    $model->jenispesanmenu = Params::JENISPESANMENU_PASIEN;
                    $model->nama_pemesan = $loadData['namadepan']." ".$loadData['nama_pasien'];
                    $model->keterangan_pesan = "via m-Pasien";
                    $model->create_time = date("Y-m-d H:i:s");
                    $model->create_loginpemakai_id = 1;
                    $model->create_ruangan = Params::RUANGAN_ID_GIZI;
                    $model->nopesanmenu = MyGenerator::noPesanMenuDiet();
                    $model->bahandiet_id = 1; //sementara
                    $model->totalpesan_org = 1; //sementara
                    $model->jenisdiet_id = 82; 
                    
                    if($model->validate()){
                        $model->save();
                        $detailtersimpan = true;
                        foreach($_GET['menus'] AS $i => $menu){
                            $modDetails[$i] = new MOPesanmenudetailT;
                            $modDetails[$i]->pesanmenudiet_id = $model->pesanmenudiet_id;
                            $modDetails[$i]->pasien_id = $loadData['pasien_id'];
                            $modDetails[$i]->pendaftaran_id = $loadData['pendaftaran_id'];
                            $modDetails[$i]->pasienadmisi_id = (!empty($loadData['pasienadmisi_id']) ? $loadData['pasienadmisi_id'] : null);
                            $modDetails[$i]->menudiet_id = $menu['menudiet_id'];
                            $modDetails[$i]->jeniswaktu_id = $menu['jeniswaktu_id'];
                            $modDetails[$i]->jml_pesan_porsi = $menu['jml_pesan_porsi'];
                            $modDetails[$i]->satuanjml_urt = Params::SATUANJML_URT;
                            if($modDetails[$i]->save()){
                                $detailtersimpan &= true;
                            }else{
                                $detailtersimpan = false;
                            }
                        }
                        if($detailtersimpan){
                            $transaction->commit();
                            $data['sukses'] = 1;
                            $data['pesan'] = 'Data pemesanan menu makanan berhasil disimpan!';
                        }else{
                            $transaction->rollback();
                            $data['sukses'] = 0;
                            $data['pesan'] = 'Data detail pemesanan menu makanan gagal disimpan! <br>'.CHtml::errorSummary($model);
                        }
                    }else{
                        $transaction->rollback();
                        $data['sukses'] = 0;
                        $data['pesan'] = 'Data pemesanan menu makanan gagal disimpan';
                    }
                }
            }catch (Exception $exc) {
                $transaction->rollback();
                $data['sukses'] = 0;
                $data['pesan'] = 'Data pemesanan menu makanan gagal disimpan!'.MyExceptionMessage::getMessage($exc,true);
            }
        }
        $encode = CJSON::encode($data);
        echo "jsonCallback(".$encode.")";
        Yii::app()->end();
    }
    
    /**
     * menampilkan hasil pemeriksaan:
     * - Laboratorium Klinik
     * - Laboratorium Patologi Anatomi
     * - Radiologi
     * - Rehabilitasi Medis
     * @param int $_GET['pasienmasukpenunjang_id']
     * @param int $_GET['ruangan_id']
     * @return json
     */
    public function actionGetHasilPemeriksaan(){
        header("content-type:application/json");
        $data = array();
        if(isset($_GET['pasienmasukpenunjang_id']) && isset($_GET['ruangan_id'])){
            $pasienmasukpenunjang_id = $_GET['pasienmasukpenunjang_id'];
            $ruangan_id = $_GET['ruangan_id'];
            if($ruangan_id == Params::RUANGAN_ID_LAB_KLINIK){
                $data = $this->getHasilLabKliniks($pasienmasukpenunjang_id);
            }else if($ruangan_id == Params::RUANGAN_ID_LAB_ANATOMI){
                $data = $this->getHasilLabPatologis($pasienmasukpenunjang_id);
            }else if($ruangan_id == Params::RUANGAN_ID_RAD){
                $data = $this->getHasilRadiologis($pasienmasukpenunjang_id);
            }else if($ruangan_id == Params::RUANGAN_ID_FISIOTERAPI){
                $data = $this->getHasilRehabMedis($pasienmasukpenunjang_id);
            }
        }
        $encode = CJSON::encode($data);
        echo "jsonCallback(".$encode.")";
        Yii::app()->end();
    }
    /**
     * data hasil laboratorium klinik
     * @param type $pasienmasukpenunjang_id
     * @return type
     */
    protected function getHasilLabKliniks($pasienmasukpenunjang_id){
        $data = array();
        $sql = "SELECT pendaftaran_t.no_pendaftaran, pendaftaran_t.tgl_pendaftaran, 
            pasienmasukpenunjang_t.no_masukpenunjang, pasienmasukpenunjang_t.tglmasukpenunjang, ruangan_m.ruangan_id, ruangan_m.ruangan_nama, 
            hasilpemeriksaanlab_t.nohasilperiksalab, hasilpemeriksaanlab_t.tglhasilpemeriksaanlab, hasilpemeriksaanlab_t.catatanlabklinik, hasilpemeriksaanlab_t.kesimpulan, hasilpemeriksaanlab_t.printhasillab, 
            pasien_m.no_rekam_medik, pasien_m.namadepan, pasien_m.nama_pasien, pasien_m.tanggal_lahir, pasien_m.jeniskelamin, pasien_m.alamat_pasien,
            jenispemeriksaanlab_m.jenispemeriksaanlab_nama,
            pemeriksaanlab_m.pemeriksaanlab_id, pemeriksaanlab_m.pemeriksaanlab_nama,
            nilairujukan_m.kelompokdet, nilairujukan_m.namapemeriksaandet,
            detailhasilpemeriksaanlab_t.hasilpemeriksaan, detailhasilpemeriksaanlab_t.nilairujukan, detailhasilpemeriksaanlab_t.hasilpemeriksaan_satuan, detailhasilpemeriksaanlab_t.hasilpemeriksaan_metode,
            pegawai_m.gelardepan, pegawai_m.nama_pegawai, gelarbelakang_m.gelarbelakang_nama
            FROM detailhasilpemeriksaanlab_t
            JOIN pemeriksaanlab_m ON pemeriksaanlab_m.pemeriksaanlab_id = detailhasilpemeriksaanlab_t.pemeriksaanlab_id
            JOIN jenispemeriksaanlab_m ON jenispemeriksaanlab_m.jenispemeriksaanlab_id = pemeriksaanlab_m.jenispemeriksaanlab_id
            JOIN pemeriksaanlabdet_m ON pemeriksaanlabdet_m.pemeriksaanlabdet_id = detailhasilpemeriksaanlab_t.pemeriksaanlabdet_id 
            JOIN nilairujukan_m ON nilairujukan_m.nilairujukan_id = pemeriksaanlabdet_m.nilairujukan_id
            JOIN hasilpemeriksaanlab_t ON hasilpemeriksaanlab_t.hasilpemeriksaanlab_id = detailhasilpemeriksaanlab_t.hasilpemeriksaanlab_id
            JOIN pasienmasukpenunjang_t ON pasienmasukpenunjang_t.pasienmasukpenunjang_id = hasilpemeriksaanlab_t.pasienmasukpenunjang_id
            JOIN pegawai_m ON pegawai_m.pegawai_id = pasienmasukpenunjang_t.pegawai_id
            LEFT JOIN gelarbelakang_m ON gelarbelakang_m.gelarbelakang_id = pegawai_m.gelarbelakang_id
            JOIN ruangan_m ON ruangan_m.ruangan_id = pasienmasukpenunjang_t.ruangan_id
            JOIN pendaftaran_t ON pendaftaran_t.pendaftaran_id = pasienmasukpenunjang_t.pendaftaran_id
            JOIN pasien_m ON pasien_m.pasien_id = pasienmasukpenunjang_t.pasien_id
            WHERE pasienmasukpenunjang_t.pasienmasukpenunjang_id = ".$pasienmasukpenunjang_id."
            ORDER BY jenispemeriksaanlab_m.jenispemeriksaanlab_urutan ASC, pemeriksaanlab_m.pemeriksaanlab_urutan ASC, pemeriksaanlabdet_m.pemeriksaanlabdet_nourut";
        $loadDatas = Yii::app()->db->createCommand($sql)->queryAll();
        if(count($loadDatas) > 0){
            $data['header']['no_pendaftaran'] = $loadDatas[0]['no_pendaftaran'];
            $data['header']['tgl_pendaftaran'] = $loadDatas[0]['tgl_pendaftaran'];
            $data['header']['no_masukpenunjang'] = $loadDatas[0]['no_masukpenunjang'];
            $data['header']['tglmasukpenunjang'] = $loadDatas[0]['tglmasukpenunjang'];
            $data['header']['ruangan_id'] = $loadDatas[0]['ruangan_id'];
            $data['header']['ruangan_nama'] = $loadDatas[0]['ruangan_nama'];
            $data['header']['no_rekam_medik'] = $loadDatas[0]['no_rekam_medik'];
            $data['header']['nama_pasien'] = $loadDatas[0]['namadepan']." ".$loadDatas[0]['nama_pasien'];
            $data['header']['tanggal_lahir'] = $loadDatas[0]['tanggal_lahir'];
            $data['header']['jeniskelamin'] = $loadDatas[0]['jeniskelamin'];
            $data['header']['alamat_pasien'] = $loadDatas[0]['alamat_pasien'];
            $data['header']['nohasil'] = $loadDatas[0]['nohasilperiksalab'];
            $data['header']['printhasil'] = $loadDatas[0]['printhasillab'];
            foreach($loadDatas AS $i => $val){
                $data['detail'][$val['pemeriksaanlab_id']]['pemeriksaanlab_nama'] = $val['pemeriksaanlab_nama'];
                $data['detail'][$val['pemeriksaanlab_id']]['kelompokdet'] = $val['kelompokdet'];
                $data['detail'][$val['pemeriksaanlab_id']]['pemeriksaanlabdet'][$i]['namapemeriksaandet'] = $val['namapemeriksaandet'];
                $data['detail'][$val['pemeriksaanlab_id']]['pemeriksaanlabdet'][$i]['hasilpemeriksaan'] = $val['hasilpemeriksaan'];
                $data['detail'][$val['pemeriksaanlab_id']]['pemeriksaanlabdet'][$i]['nilairujukan'] = $val['nilairujukan'];
                $data['detail'][$val['pemeriksaanlab_id']]['pemeriksaanlabdet'][$i]['hasilpemeriksaan_satuan'] = $val['hasilpemeriksaan_satuan'];
                $data['detail'][$val['pemeriksaanlab_id']]['pemeriksaanlabdet'][$i]['hasilpemeriksaan_metode'] = $val['hasilpemeriksaan_metode'];
            }
            $data['footer']['catatan'] = $loadDatas[0]['catatanlabklinik'];
            $data['footer']['kesimpulan'] = $loadDatas[0]['kesimpulan'];
            $data['footer']['nama_dokter'] = $loadDatas[0]['gelardepan']." ".$loadDatas[0]['nama_pegawai']." ".$loadDatas[0]['gelarbelakang_nama'];
        }
        return $data;
    }
    
    /**
     * menampilkan hasil laboratorium patologi anatomi
     * @param type $pasienmasukpenunjang_id
     * @return type
     */
    protected function getHasilLabPatologis($pasienmasukpenunjang_id){
        $data = array();
        $sql = "SELECT pendaftaran_t.no_pendaftaran, pendaftaran_t.tgl_pendaftaran, 
            pasienmasukpenunjang_t.no_masukpenunjang, pasienmasukpenunjang_t.tglmasukpenunjang, ruangan_m.ruangan_id, ruangan_m.ruangan_nama, 
            pasien_m.no_rekam_medik, pasien_m.namadepan, pasien_m.nama_pasien, pasien_m.tanggal_lahir, pasien_m.jeniskelamin, pasien_m.alamat_pasien,
            jenispemeriksaanlab_m.jenispemeriksaanlab_nama,
            pemeriksaanlab_m.pemeriksaanlab_id, pemeriksaanlab_m.pemeriksaanlab_nama,
            hasilpemeriksaanpa_t.nosediaanpa, hasilpemeriksaanpa_t.tglperiksapa, hasilpemeriksaanpa_t.makroskopis, hasilpemeriksaanpa_t.mikroskopis, hasilpemeriksaanpa_t.kesimpulanpa, hasilpemeriksaanpa_t.saranpa, hasilpemeriksaanpa_t.catatanpa, hasilpemeriksaanpa_t.printhasilpa,
            pegawai_m.gelardepan, pegawai_m.nama_pegawai, gelarbelakang_m.gelarbelakang_nama
            FROM hasilpemeriksaanpa_t
            JOIN pemeriksaanlab_m ON pemeriksaanlab_m.pemeriksaanlab_id = hasilpemeriksaanpa_t.pemeriksaanlab_id
            JOIN jenispemeriksaanlab_m ON jenispemeriksaanlab_m.jenispemeriksaanlab_id = pemeriksaanlab_m.jenispemeriksaanlab_id
            JOIN pasienmasukpenunjang_t ON pasienmasukpenunjang_t.pasienmasukpenunjang_id = hasilpemeriksaanpa_t.pasienmasukpenunjang_id
            JOIN pegawai_m ON pegawai_m.pegawai_id = pasienmasukpenunjang_t.pegawai_id
            LEFT JOIN gelarbelakang_m ON gelarbelakang_m.gelarbelakang_id = pegawai_m.gelarbelakang_id
            JOIN ruangan_m ON ruangan_m.ruangan_id = pasienmasukpenunjang_t.ruangan_id
            JOIN pendaftaran_t ON pendaftaran_t.pendaftaran_id = pasienmasukpenunjang_t.pendaftaran_id
            JOIN pasien_m ON pasien_m.pasien_id = hasilpemeriksaanpa_t.pasien_id
            WHERE pasienmasukpenunjang_t.pasienmasukpenunjang_id = ".$pasienmasukpenunjang_id."
            ORDER BY jenispemeriksaanlab_m.jenispemeriksaanlab_urutan ASC, pemeriksaanlab_m.pemeriksaanlab_urutan ASC
            ";
        $loadDatas = Yii::app()->db->createCommand($sql)->queryAll();
        if(count($loadDatas) > 0){
            $data['header']['no_pendaftaran'] = $loadDatas[0]['no_pendaftaran'];
            $data['header']['tgl_pendaftaran'] = $loadDatas[0]['tgl_pendaftaran'];
            $data['header']['no_masukpenunjang'] = $loadDatas[0]['no_masukpenunjang'];
            $data['header']['tglmasukpenunjang'] = $loadDatas[0]['tglmasukpenunjang'];
            $data['header']['ruangan_id'] = $loadDatas[0]['ruangan_id'];
            $data['header']['ruangan_nama'] = $loadDatas[0]['ruangan_nama'];
            $data['header']['no_rekam_medik'] = $loadDatas[0]['no_rekam_medik'];
            $data['header']['nama_pasien'] = $loadDatas[0]['namadepan']." ".$loadDatas[0]['nama_pasien'];
            $data['header']['tanggal_lahir'] = $loadDatas[0]['tanggal_lahir'];
            $data['header']['jeniskelamin'] = $loadDatas[0]['jeniskelamin'];
            $data['header']['alamat_pasien'] = $loadDatas[0]['alamat_pasien'];
            $data['header']['nohasil'] = $loadDatas[0]['nosediaanpa'];
            $data['header']['printhasil'] = $loadDatas[0]['printhasilpa'];
            foreach($loadDatas AS $i => $val){
                $data['detail'][$i]['jenispemeriksaanlab_nama'] = $val['jenispemeriksaanlab_nama'];
                $data['detail'][$i]['pemeriksaanlab_nama'] = $val['pemeriksaanlab_nama'];
                $data['detail'][$i]['makroskopis'] = $val['makroskopis'];
                $data['detail'][$i]['mikroskopis'] = $val['mikroskopis'];
                $data['detail'][$i]['kesimpulanpa'] = $val['kesimpulanpa'];
                $data['detail'][$i]['saranpa'] = $val['saranpa'];
                $data['detail'][$i]['catatanpa'] = $val['catatanpa'];
            }
            $data['footer']['catatan'] = "";
            $data['footer']['kesimpulan'] = "";
            $data['footer']['nama_dokter'] = $loadDatas[0]['gelardepan']." ".$loadDatas[0]['nama_pegawai']." ".$loadDatas[0]['gelarbelakang_nama'];
        }
        return $data;
    }
    /**
     * menampilkan hasil radiologi
     * @param type $pasienmasukpenunjang_id
     * @return string
     */
    protected function getHasilRadiologis($pasienmasukpenunjang_id){
        $data = array();
        $sql = "SELECT pasienmasukpenunjang_t.pasienmasukpenunjang_id, pasienmasukpenunjang_t.ruangan_id,pendaftaran_t.no_pendaftaran, pendaftaran_t.tgl_pendaftaran, 
            pasienmasukpenunjang_t.no_masukpenunjang, pasienmasukpenunjang_t.tglmasukpenunjang, ruangan_m.ruangan_nama, 
            pasien_m.no_rekam_medik, pasien_m.namadepan, pasien_m.nama_pasien, pasien_m.tanggal_lahir, pasien_m.jeniskelamin, pasien_m.alamat_pasien,
            jenispemeriksaanrad_m.jenispemeriksaanrad_nama,
            pemeriksaanrad_m.pemeriksaanrad_id, pemeriksaanrad_m.pemeriksaanrad_nama,
            hasilpemeriksaanrad_t.tglpemeriksaanrad, hasilpemeriksaanrad_t.hasilexpertise, hasilpemeriksaanrad_t.kesan_hasilrad, hasilpemeriksaanrad_t.kesimpulan_hasilrad, hasilpemeriksaanrad_t.printhasilrad,
            pegawai_m.gelardepan, pegawai_m.nama_pegawai, gelarbelakang_m.gelarbelakang_nama
            FROM hasilpemeriksaanrad_t
            JOIN pemeriksaanrad_m ON pemeriksaanrad_m.pemeriksaanrad_id = hasilpemeriksaanrad_t.pemeriksaanrad_id
            JOIN jenispemeriksaanrad_m ON jenispemeriksaanrad_m.jenispemeriksaanrad_id = pemeriksaanrad_m.jenispemeriksaanrad_id
            JOIN pasienmasukpenunjang_t ON pasienmasukpenunjang_t.pasienmasukpenunjang_id = hasilpemeriksaanrad_t.pasienmasukpenunjang_id
            JOIN pegawai_m ON pegawai_m.pegawai_id = pasienmasukpenunjang_t.pegawai_id
            LEFT JOIN gelarbelakang_m ON gelarbelakang_m.gelarbelakang_id = pegawai_m.gelarbelakang_id
            JOIN ruangan_m ON ruangan_m.ruangan_id = pasienmasukpenunjang_t.ruangan_id
            JOIN pendaftaran_t ON pendaftaran_t.pendaftaran_id = pasienmasukpenunjang_t.pendaftaran_id
            JOIN pasien_m ON pasien_m.pasien_id = hasilpemeriksaanrad_t.pasien_id
            WHERE pasienmasukpenunjang_t.pasienmasukpenunjang_id = ".$pasienmasukpenunjang_id."
            ORDER BY jenispemeriksaanrad_m.jenispemeriksaanrad_urutan ASC, pemeriksaanrad_m.pemeriksaanrad_urutan ASC";
        $loadDatas = Yii::app()->db->createCommand($sql)->queryAll();
        if(count($loadDatas) > 0){
            $data['header']['no_pendaftaran'] = $loadDatas[0]['no_pendaftaran'];
            $data['header']['tgl_pendaftaran'] = $loadDatas[0]['tgl_pendaftaran'];
            $data['header']['no_masukpenunjang'] = $loadDatas[0]['no_masukpenunjang'];
            $data['header']['tglmasukpenunjang'] = $loadDatas[0]['tglmasukpenunjang'];
            $data['header']['ruangan_id'] = $loadDatas[0]['ruangan_id'];
            $data['header']['ruangan_nama'] = $loadDatas[0]['ruangan_nama'];
            $data['header']['no_rekam_medik'] = $loadDatas[0]['no_rekam_medik'];
            $data['header']['nama_pasien'] = $loadDatas[0]['namadepan']." ".$loadDatas[0]['nama_pasien'];
            $data['header']['tanggal_lahir'] = $loadDatas[0]['tanggal_lahir'];
            $data['header']['jeniskelamin'] = $loadDatas[0]['jeniskelamin'];
            $data['header']['alamat_pasien'] = $loadDatas[0]['alamat_pasien'];
            $data['header']['nohasil'] = "-";
            $data['header']['printhasil'] = $loadDatas[0]['printhasilrad'];
            foreach($loadDatas AS $i => $val){
                $data['detail'][$i]['jenispemeriksaanrad_nama'] = $val['jenispemeriksaanrad_nama'];
                $data['detail'][$i]['pemeriksaanrad_nama'] = $val['pemeriksaanrad_nama'];
                $data['detail'][$i]['hasilexpertise'] = $val['hasilexpertise'];
                $data['detail'][$i]['kesan_hasilrad'] = $val['kesan_hasilrad'];
                $data['detail'][$i]['kesimpulan_hasilrad'] = $val['kesimpulan_hasilrad'];
            }
            $data['footer']['catatan'] = "";
            $data['footer']['kesimpulan'] = "";
            $data['footer']['nama_dokter'] = $loadDatas[0]['gelardepan']." ".$loadDatas[0]['nama_pegawai']." ".$loadDatas[0]['gelarbelakang_nama'];
        }
        return $data;
    }
    /**
     * menampilkan hasil pemeriksaan rehabilitasi medis
     * @param type $pasienmasukpenunjang_id
     * @return string
     */
    protected function getHasilRehabMedis($pasienmasukpenunjang_id){
        $data = array();
        $sql = "SELECT pasienmasukpenunjang_t.pasienmasukpenunjang_id, pasienmasukpenunjang_t.ruangan_id,pendaftaran_t.no_pendaftaran, pendaftaran_t.tgl_pendaftaran, 
            pasienmasukpenunjang_t.no_masukpenunjang, pasienmasukpenunjang_t.tglmasukpenunjang, ruangan_m.ruangan_nama, 
            pasien_m.no_rekam_medik, pasien_m.namadepan, pasien_m.nama_pasien, pasien_m.tanggal_lahir, pasien_m.jeniskelamin, pasien_m.alamat_pasien,
            jenistindakanrm_m.jenistindakanrm_nama,
            tindakanrm_m.tindakanrm_id, tindakanrm_m.tindakanrm_nama,
            hasilpemeriksaanrm_t.tglpemeriksaanrm, hasilpemeriksaanrm_t.nohasilrm, hasilpemeriksaanrm_t.kunjunganke, hasilpemeriksaanrm_t.hasilpemeriksaanrm, hasilpemeriksaanrm_t.keteranganhasilrm, hasilpemeriksaanrm_t.peralatandigunakan,
            paramedis1_m.gelardepan AS gelardepan_paramedis1 , paramedis1_m.nama_pegawai AS nama_paramedis1, gelarbelakangpm1_m.gelarbelakang_nama AS gelarbelakang_paramedis1,
            paramedis2_m.gelardepan AS gelardepan_paramedis2 , paramedis2_m.nama_pegawai AS nama_paramedis2, gelarbelakangpm2_m.gelarbelakang_nama AS gelarbelakang_paramedis2,
            pegawai_m.gelardepan, pegawai_m.nama_pegawai, gelarbelakang_m.gelarbelakang_nama
            FROM hasilpemeriksaanrm_t
            LEFT JOIN jadwalkunjunganrm_t ON jadwalkunjunganrm_t.jadwalkunjunganrm_id = hasilpemeriksaanrm_t.jadwalkunjunganrm_id
            JOIN tindakanrm_m ON tindakanrm_m.tindakanrm_id = hasilpemeriksaanrm_t.tindakanrm_id
            JOIN jenistindakanrm_m ON jenistindakanrm_m.jenistindakanrm_id = tindakanrm_m.jenistindakanrm_id
            JOIN pasienmasukpenunjang_t ON pasienmasukpenunjang_t.pasienmasukpenunjang_id = hasilpemeriksaanrm_t.pasienmasukpenunjang_id
            JOIN pegawai_m ON pegawai_m.pegawai_id = pasienmasukpenunjang_t.pegawai_id
            LEFT JOIN gelarbelakang_m ON gelarbelakang_m.gelarbelakang_id = pegawai_m.gelarbelakang_id
            LEFT JOIN pegawai_m paramedis1_m ON paramedis1_m.pegawai_id = hasilpemeriksaanrm_t.paramedis1_id
            LEFT JOIN gelarbelakang_m gelarbelakangpm1_m ON gelarbelakangpm1_m.gelarbelakang_id = paramedis1_m.gelarbelakang_id
            LEFT JOIN pegawai_m paramedis2_m ON paramedis2_m.pegawai_id = hasilpemeriksaanrm_t.paramedis2_id
            LEFT JOIN gelarbelakang_m gelarbelakangpm2_m ON gelarbelakangpm2_m.gelarbelakang_id = paramedis2_m.gelarbelakang_id
            JOIN ruangan_m ON ruangan_m.ruangan_id = pasienmasukpenunjang_t.ruangan_id
            JOIN pendaftaran_t ON pendaftaran_t.pendaftaran_id = pasienmasukpenunjang_t.pendaftaran_id
            JOIN pasien_m ON pasien_m.pasien_id = hasilpemeriksaanrm_t.pasien_id
            WHERE pasienmasukpenunjang_t.pasienmasukpenunjang_id = ".$pasienmasukpenunjang_id."
            ORDER BY jenistindakanrm_m.jenistindakanrm_urutan ASC, tindakanrm_m.tindakanrm_urutan ASC";
        $loadDatas = Yii::app()->db->createCommand($sql)->queryAll();
        if(count($loadDatas) > 0){
            $data['header']['no_pendaftaran'] = $loadDatas[0]['no_pendaftaran'];
            $data['header']['tgl_pendaftaran'] = $loadDatas[0]['tgl_pendaftaran'];
            $data['header']['no_masukpenunjang'] = $loadDatas[0]['no_masukpenunjang'];
            $data['header']['tglmasukpenunjang'] = $loadDatas[0]['tglmasukpenunjang'];
            $data['header']['ruangan_id'] = $loadDatas[0]['ruangan_id'];
            $data['header']['ruangan_nama'] = $loadDatas[0]['ruangan_nama'];
            $data['header']['no_rekam_medik'] = $loadDatas[0]['no_rekam_medik'];
            $data['header']['nama_pasien'] = $loadDatas[0]['namadepan']." ".$loadDatas[0]['nama_pasien'];
            $data['header']['tanggal_lahir'] = $loadDatas[0]['tanggal_lahir'];
            $data['header']['jeniskelamin'] = $loadDatas[0]['jeniskelamin'];
            $data['header']['alamat_pasien'] = $loadDatas[0]['alamat_pasien'];
            $data['header']['nohasilrm'] = $loadDatas[0]['nohasilrm'];
            $data['header']['printhasil'] = "";
            foreach($loadDatas AS $i => $val){
                $data['detail'][$i]['jenistindakanrm_nama'] = $val['jenistindakanrm_nama'];
                $data['detail'][$i]['tindakanrm_nama'] = $val['tindakanrm_nama'];
                $data['detail'][$i]['kunjunganke'] = $val['kunjunganke'];
                $data['detail'][$i]['hasilpemeriksaanrm'] = $val['hasilpemeriksaanrm'];
                $data['detail'][$i]['keteranganhasilrm'] = $val['keteranganhasilrm'];
                $data['detail'][$i]['peralatandigunakan'] = $val['peralatandigunakan'];
                $data['detail'][$i]['nama_paramedis1'] = $val['gelardepan_paramedis1']." ".$val['nama_paramedis1']." ".$val['gelarbelakang_paramedis1'];
                $data['detail'][$i]['nama_paramedis2'] = $val['gelardepan_paramedis2']." ".$val['nama_paramedis2']." ".$val['gelarbelakang_paramedis2'];
            }
            $data['footer']['catatan'] = "";
            $data['footer']['kesimpulan'] = "";
            $data['footer']['nama_dokter'] = $loadDatas[0]['gelardepan']." ".$loadDatas[0]['nama_pegawai']." ".$loadDatas[0]['gelarbelakang_nama'];
        }
        return $data;
    }
    
    /**
     * menampilkan riwayat pemeriksaan
     * @param $_GET['pasien_id']
     * @param $_GET['bulan'] (yyyy-mm)
     * @return json
     */
    public function actionGetRiwayatPemeriksaan(){
        header("content-type:application/json");
        $format = new MyFormatter();
        $data = array();
        if(isset($_GET['pasien_id']) && isset($_GET['bulan'])){
            $pasien_id = $_GET['pasien_id'];
            $bulan = $_GET['bulan'];
            if(empty($bulan)){ //DEFAULT NILAI JIKA TIDAK ADA BULAN MA-129
                $sql_terakhir = "SELECT pendaftaran_t.tgl_pendaftaran
                    FROM pendaftaran_t
                    WHERE 
                        pendaftaran_t.pasienbatalperiksa_id IS NULL
                        AND pendaftaran_t.pasien_id = ".$pasien_id."
                    ORDER BY pendaftaran_t.tgl_pendaftaran DESC
                    LIMIT 1";
                $loadData = Yii::app()->db->createCommand($sql_terakhir)->queryRow();
                if($loadData){
                    $bulan = substr($loadData['tgl_pendaftaran'], 0, 7);
                }
            }
            $sql = "SELECT pendaftaran_t.pendaftaran_id, pendaftaran_t.no_pendaftaran, pendaftaran_t.tgl_pendaftaran
                FROM pendaftaran_t
                WHERE 
                    pendaftaran_t.pasienbatalperiksa_id IS NULL
                    AND pendaftaran_t.pasien_id = ".$pasien_id."
                    AND TO_CHAR(pendaftaran_t.tgl_pendaftaran,'YYYY-MM') = '".$bulan."'
                ORDER BY pendaftaran_t.tgl_pendaftaran DESC
                LIMIT 5
                ";
            $loadDatas = Yii::app()->db->createCommand($sql)->queryAll();
            if(count($loadDatas) > 0){
                foreach($loadDatas AS $i => $val){
                    $data[$i]= $val;
                    $data[$i]['anamnesa'] = $this->getRiwayatAnamnesa($val['pendaftaran_id']);
                    $data[$i]['pemeriksaanfisik'] = $this->getRiwayatPemeriksaanFisik($val['pendaftaran_id']);
                    $data[$i]['tindakan'] = $this->getRiwayatTindakan($val['pendaftaran_id']);
                    $data[$i]['konsulpoli'] = $this->getRiwayatKonsultasiPoli($val['pendaftaran_id']);
                    $data[$i]['rujukankeluar'] = $this->getRiwayatRujukanKeluar($val['pendaftaran_id']);
                    $data[$i]['rujukankeluar'] = $this->getRiwayatRujukanKeluar($val['pendaftaran_id']);
                    $data[$i]['reseptur'] = $this->getRiwayatReseptur($val['pendaftaran_id']);
                    $data[$i]['diagnosis'] = $this->getRiwayatMorbiditas($val['pendaftaran_id']);
                }
            }
        }
        $encode = CJSON::encode($data);
        echo "jsonCallback(".$encode.")";
        Yii::app()->end();
    }
    /**
     * menampilkan data riwayat anamnesa
     * MA-36
     * @param type $pendaftaran_id
     * @return array
     */
    protected function getRiwayatAnamnesa($pendaftaran_id){
        $format = new MyFormatter();
        $data = array();
        $sql = "SELECT anamnesa_t.tglanamnesis, anamnesa_t.keluhanutama, anamnesa_t.keluhantambahan, anamnesa_t.riwayatpenyakitterdahulu, anamnesa_t.riwayatpenyakitkeluarga, anamnesa_t.lamasakit, anamnesa_t.pengobatanygsudahdilakukan, anamnesa_t.riwayatalergiobat, anamnesa_t.riwayatkelahiran, anamnesa_t.riwayatmakanan, anamnesa_t.riwayatimunisasi, anamnesa_t.paramedis_nama, anamnesa_t.keterangananamesa,
            pegawai_m.gelardepan, pegawai_m.nama_pegawai, gelarbelakang_m.gelarbelakang_nama, 
            triase_m.triase_nama,triase_m.warna_triase, triase_m.kode_warnatriase, triase_m.keterangan_triase
            FROM anamnesa_t
            LEFT JOIN triase_m ON triase_m.triase_id = anamnesa_t.triase_id
            JOIN pegawai_m ON pegawai_m.pegawai_id = anamnesa_t.pegawai_id
            LEFT JOIN gelarbelakang_m ON gelarbelakang_m.gelarbelakang_id = pegawai_m.gelarbelakang_id
            WHERE anamnesa_t.pendaftaran_id = ".$pendaftaran_id." 
            LIMIT 1";
        $loadData = Yii::app()->db->createCommand($sql)->queryRow();
        if(!empty($loadData)){
            $data = $loadData;
            $data['tglanamnesis'] = $format->formatDateTimeForUser($loadData['tglanamnesis']);
        }
        return $data;
    }
    /**
     * menampilkan data riwayat pemeriksaan fisik
     * MA-37
     * @param type $pendaftaran_id
     * @return array
     */
    protected function getRiwayatPemeriksaanFisik($pendaftaran_id){
        $format = new MyFormatter();
        $data = array();
        $sql = "SELECT gcs_m.gcs_nama, gcs_m.gcs_nilaimin, gcs_nilaimax, 
            pemeriksaanfisik_t.tglperiksafisik, pemeriksaanfisik_t.keadaanumum, pemeriksaanfisik_t.inspeksi, 
			pemeriksaanfisik_t.palpasi, pemeriksaanfisik_t.perkusi, pemeriksaanfisik_t.auskultasi, 
			pemeriksaanfisik_t.tekanandarah, pemeriksaanfisik_t.td_systolic, pemeriksaanfisik_t.td_diastolic, 
			pemeriksaanfisik_t.meanarteripressure, pemeriksaanfisik_t.detaknadi, pemeriksaanfisik_t.heartindex_i1, 
			pemeriksaanfisik_t.heartindex_i2, pemeriksaanfisik_t.heartindex_i3, pemeriksaanfisik_t.suhutubuh, 
			pemeriksaanfisik_t.beratbadan_kg, pemeriksaanfisik_t.tinggibadan_cm, pemeriksaanfisik_t.bb_ideal, 
			pemeriksaanfisik_t.pernapasan, pemeriksaanfisik_t.paramedis_nama, pemeriksaanfisik_t.kelainanpadabagtubuh, 
			pemeriksaanfisik_t.gcs_eye, pemeriksaanfisik_t.gcs_verbal, pemeriksaanfisik_t.gcs_motorik,
            pegawai_m.gelardepan, pegawai_m.nama_pegawai, gelarbelakang_m.gelarbelakang_nama
            FROM pemeriksaanfisik_t
            JOIN pegawai_m ON pegawai_m.pegawai_id = pemeriksaanfisik_t.pegawai_id
            LEFT JOIN gelarbelakang_m ON gelarbelakang_m.gelarbelakang_id = pegawai_m.gelarbelakang_id
            LEFT JOIN gcs_m ON gcs_m.gcs_id = pemeriksaanfisik_t.gcs_id 
            WHERE pemeriksaanfisik_t.pendaftaran_id = ".$pendaftaran_id." 
            LIMIT 1";
        $loadData = Yii::app()->db->createCommand($sql)->queryRow();
        if(!empty($loadData)){
			foreach ($loadData as $ld => $val){								
				$dt[$ld] =  (!empty($val))?$val:"";
			}
			
            $data = $dt;
            $data['tglperiksafisik'] = $format->formatDateTimeForUser($loadData['tglperiksafisik']);
        }
        return $data;
    }
    
    /**
     * Menampilkan riwayat konsultasi poliklinik
     * MA-38
     * @param type $pendaftaran_id
     * @return type
     */
    protected function getRiwayatKonsultasiPoli($pendaftaran_id){
        $format = new MyFormatter();
        $data = array();
        $sql = "SELECT konsulpoli_t.tglkonsulpoli, konsulpoli_t.statusperiksa, konsulpoli_t.catatan_dokter_konsul, konsulpoli_t.no_antriankonsul,
            asalruangan_m.ruangan_nama AS asalpoliklinik, ruangan_m.ruangan_nama AS tujuankonsul,
            daftartindakan_m.daftartindakan_nama
            FROM konsulpoli_t
            JOIN ruangan_m ON ruangan_m.ruangan_id = konsulpoli_t.ruangan_id
            JOIN ruangan_m asalruangan_m ON asalruangan_m.ruangan_id = konsulpoli_t.asalpoliklinikkonsul_id
            LEFT JOIN daftartindakan_m ON daftartindakan_m.daftartindakan_id = konsulpoli_t.daftartindakan_id
            WHERE konsulpoli_t.pendaftaran_id = ".$pendaftaran_id."
        ";
        $loadDatas = Yii::app()->db->createCommand($sql)->queryAll();
        if(count($loadDatas) > 0){
            foreach($loadDatas AS $i => $val){
                $data[$i] = $val;
                $data[$i]['tglkonsulpoli'] = $format->formatDateTimeForUser($val['tglkonsulpoli']);
            }
        }
        return $data;
    }
    
    /**
     * Menampilkan riwayat tindakan (selain karcis)
     * MA-39
     * @param type $pendaftaran_id
     * @return string
     */
    protected function getRiwayatTindakan($pendaftaran_id){
        $format = new MyFormatter();
        $data = array();
        $sql = "SELECT tindakanpelayanan_t.tgl_tindakan, daftartindakan_m.daftartindakan_nama, ruangan_m.ruangan_id, ruangan_m.ruangan_nama, tindakanpelayanan_t.keterangantindakan, 
            dokterpemeriksa1_m.gelardepan AS gelardepan_dokter1, dokterpemeriksa1_m.nama_pegawai AS nama_dokter1, gelarbelakangdokter1_m.gelarbelakang_nama AS gelarbelakang_dokter1,
            dokterpemeriksa2_m.gelardepan AS gelardepan_dokter2, dokterpemeriksa2_m.nama_pegawai AS nama_dokter2, gelarbelakangdokter2_m.gelarbelakang_nama AS gelarbelakang_dokter2,
            dokterpendamping_m.gelardepan AS gelardepan_dokterpendamping, dokterpendamping_m.nama_pegawai AS nama_dokterpendamping, gelarbelakangpendamping_m.gelarbelakang_nama AS gelarbelakang_dokterpendamping,
            dokteranastesi_m.gelardepan AS gelardepan_dokteranastesi, dokteranastesi_m.nama_pegawai AS nama_dokteranastesi, gelarbelakangdokteranastesi_m.gelarbelakang_nama AS gelarbelakang_dokteranastesi,
            dokterdelegasi_m.gelardepan AS gelardepan_dokterdelegasi, dokterdelegasi_m.nama_pegawai AS nama_dokterdelegasi, gelarbelakangdokterdelegasi_m.gelarbelakang_nama AS gelarbelakang_dokterdelegasi,
            bidan_m.gelardepan AS gelardepan_bidan, bidan_m.nama_pegawai AS nama_bidan, gelarbelakangbidan_m.gelarbelakang_nama AS gelarbelakang_bidan,
            suster_m.gelardepan AS gelardepan_suster, suster_m.nama_pegawai AS nama_suster, gelarbelakangsuster_m.gelarbelakang_nama AS gelarbelakang_suster,
            perawat_m.gelardepan AS gelardepan_perawat, perawat_m.nama_pegawai AS nama_perawat, gelarbelakangperawat_m.gelarbelakang_nama AS gelarbelakang_perawat
            FROM tindakanpelayanan_t
            JOIN daftartindakan_m ON daftartindakan_m.daftartindakan_id = tindakanpelayanan_t.daftartindakan_id
            JOIN ruangan_m ON ruangan_m.ruangan_id = tindakanpelayanan_t.ruangan_id
            LEFT JOIN pegawai_m dokterpemeriksa1_m ON dokterpemeriksa1_m.pegawai_id = tindakanpelayanan_t.dokterpemeriksa1_id
            LEFT JOIN gelarbelakang_m gelarbelakangdokter1_m ON gelarbelakangdokter1_m.gelarbelakang_id = dokterpemeriksa1_m.gelarbelakang_id
            LEFT JOIN pegawai_m dokterpemeriksa2_m ON dokterpemeriksa2_m.pegawai_id = tindakanpelayanan_t.dokterpemeriksa2_id
            LEFT JOIN gelarbelakang_m gelarbelakangdokter2_m ON gelarbelakangdokter2_m.gelarbelakang_id = dokterpemeriksa2_m.gelarbelakang_id
            LEFT JOIN pegawai_m dokterpendamping_m ON dokterpendamping_m.pegawai_id = tindakanpelayanan_t.dokterpendamping_id
            LEFT JOIN gelarbelakang_m gelarbelakangpendamping_m ON gelarbelakangpendamping_m.gelarbelakang_id = dokterpendamping_m.gelarbelakang_id
            LEFT JOIN pegawai_m dokteranastesi_m ON dokteranastesi_m.pegawai_id = tindakanpelayanan_t.dokteranastesi_id
            LEFT JOIN gelarbelakang_m gelarbelakangdokteranastesi_m ON gelarbelakangdokteranastesi_m.gelarbelakang_id = dokteranastesi_m.gelarbelakang_id
            LEFT JOIN pegawai_m dokterdelegasi_m ON dokterdelegasi_m.pegawai_id = tindakanpelayanan_t.dokterdelegasi_id
            LEFT JOIN gelarbelakang_m gelarbelakangdokterdelegasi_m ON gelarbelakangdokterdelegasi_m.gelarbelakang_id = dokterdelegasi_m.gelarbelakang_id
            LEFT JOIN pegawai_m bidan_m ON bidan_m.pegawai_id = tindakanpelayanan_t.bidan_id
            LEFT JOIN gelarbelakang_m gelarbelakangbidan_m ON gelarbelakangbidan_m.gelarbelakang_id = bidan_m.gelarbelakang_id
            LEFT JOIN pegawai_m suster_m ON suster_m.pegawai_id = tindakanpelayanan_t.suster_id
            LEFT JOIN gelarbelakang_m gelarbelakangsuster_m ON gelarbelakangsuster_m.gelarbelakang_id = suster_m.gelarbelakang_id
            LEFT JOIN pegawai_m perawat_m ON perawat_m.pegawai_id = tindakanpelayanan_t.perawat_id
            LEFT JOIN gelarbelakang_m gelarbelakangperawat_m ON gelarbelakangperawat_m.gelarbelakang_id = perawat_m.gelarbelakang_id
            WHERE tindakanpelayanan_t.karcis_id IS NULL
                AND tindakanpelayanan_t.pendaftaran_id = ".$pendaftaran_id."
            ORDER BY ruangan_m.ruangan_nourut ASC, ruangan_m.ruangan_nama ASC, tindakanpelayanan_t.tgl_tindakan ASC, daftartindakan_m.daftartindakan_nama ASC";
        $loadDatas = Yii::app()->db->createCommand($sql)->queryAll();
        if(count($loadDatas) > 0){
            foreach($loadDatas AS $i => $val){
                $data[$i] = $val;
                $data[$i]['tgl_tindakan'] = $format->formatDateTimeForUser($val['tgl_tindakan']);
                $data[$i]['nama_dokter1'] = $val['gelardepan_dokter1']." ".$val['nama_dokter1']." ".$val['gelarbelakang_dokter1'];
                $data[$i]['nama_dokter2'] = $val['gelardepan_dokter2']." ".$val['nama_dokter2']." ".$val['gelarbelakang_dokter2'];
                $data[$i]['nama_dokterpendamping'] = $val['gelardepan_dokterpendamping']." ".$val['nama_dokterpendamping']." ".$val['gelarbelakang_dokterpendamping'];
                $data[$i]['nama_dokteranastesi'] = $val['gelardepan_dokteranastesi']." ".$val['nama_dokteranastesi']." ".$val['gelarbelakang_dokteranastesi'];
                $data[$i]['nama_dokterdelegasi'] = $val['gelardepan_dokterdelegasi']." ".$val['nama_dokterdelegasi']." ".$val['gelarbelakang_dokterdelegasi'];
                $data[$i]['nama_bidan'] = $val['gelardepan_bidan']." ".$val['nama_bidan']." ".$val['gelarbelakang_bidan'];
                $data[$i]['nama_suster'] = $val['gelardepan_suster']." ".$val['nama_suster']." ".$val['gelarbelakang_suster'];
                $data[$i]['nama_perawat'] = $val['gelardepan_perawat']." ".$val['nama_perawat']." ".$val['gelarbelakang_perawat'];
            }
        }
        return $data;
    }
    
    /**
     * Menampilkan riwayat rujukan keluar
     * MA-50
     * @param type $pendaftaran_id
     * @return type
     */
    protected function getRiwayatRujukanKeluar($pendaftaran_id){
        $format = new MyFormatter();
        $data = array();
        $sql = "SELECT pasiendirujukkeluar_t.*, rujukankeluar_m.rumahsakitrujukan, instalasi_m.instalasi_nama AS instalasiasal_nama, ruangan_m.ruangan_nama AS ruanganasal_nama
            FROM pasiendirujukkeluar_t
            JOIN rujukankeluar_m ON rujukankeluar_m.rujukankeluar_id = pasiendirujukkeluar_t.rujukankeluar_id
            JOIN ruangan_m ON ruangan_m.ruangan_id = pasiendirujukkeluar_t.ruanganasal_id
            JOIN instalasi_m ON instalasi_m.instalasi_id = ruangan_m.instalasi_id
            WHERE pasiendirujukkeluar_t.pendaftaran_id = ".$pendaftaran_id."
        ";
        $loadDatas = Yii::app()->db->createCommand($sql)->queryAll();
        if(count($loadDatas) > 0){
            foreach($loadDatas AS $i => $val){
                $data[$i] = $val;
                $data[$i]['tgldirujuk'] = $format->formatDateTimeForUser($val['tgldirujuk']);
            }
        }
        return $data;
    }
    /**
     * Menampilkan riwayat rujukan keluar
     * MA-49
     * @param type $pendaftaran_id
     * @return type
     */
    protected function getRiwayatReseptur($pendaftaran_id){
        $format = new MyFormatter();
        $data = array();
        $sql = "SELECT ruangan_m.ruangan_nama, ruanganreseptur_m.ruangan_nama AS ruanganreseptur_nama, 
            pegawai_m.gelardepan, pegawai_m.nama_pegawai AS nama_dokterresep, gelarbelakang_m.gelarbelakang_nama ,
            reseptur_t.reseptur_id, reseptur_t.tglreseptur, reseptur_t.noresep, reseptur_t.fileresep,
            unitdosis_t.nounitdosis, unitdosis_t.tgluntidosis, unitdosis_t.beratbadan_kg, unitdosis_t.tinggibadan_cm, unitdosis_t.alergiobat, ruanganunitdosis_m.ruangan_nama AS ruanganunitdosis_nama
            FROM reseptur_t
            JOIN ruangan_m ON ruangan_m.ruangan_id = reseptur_t.ruangan_id
            JOIN ruangan_m ruanganreseptur_m ON ruanganreseptur_m.ruangan_id = reseptur_t.ruanganreseptur_id
            JOIN pegawai_m ON pegawai_m.pegawai_id = reseptur_t.pegawai_id
            LEFT JOIN unitdosis_t ON unitdosis_t.unitdosis_id = reseptur_t.unitdosis_id
            LEFT JOIN ruangan_m ruanganunitdosis_m ON ruanganunitdosis_m.ruangan_id = unitdosis_t.ruanganunitdosis_id
            LEFT JOIN gelarbelakang_m ON gelarbelakang_m.gelarbelakang_id = pegawai_m.gelarbelakang_id
            WHERE reseptur_t.pendaftaran_id = ".$pendaftaran_id."
        ";
        $loadDatas = Yii::app()->db->createCommand($sql)->queryAll();
        if(count($loadDatas) > 0){
            foreach($loadDatas AS $i => $val){
                $data[$i] = $val;
                $data[$i]['tglreseptur'] = $format->formatDateTimeForUser($val['tglreseptur']);
                $data[$i]['tgluntidosis'] = $format->formatDateTimeForUser($val['tgluntidosis']);
                $data[$i]['nama_dokterresep'] = $val['gelardepan']." ".$val['nama_dokterresep']." ".$val['gelarbelakang_nama'];
                $data[$i]['resepdetail'] = array();
                $sql_det = "SELECT 
                    resepturdetail_t.r, resepturdetail_t.rke, resepturdetail_t.permintaan_reseptur, resepturdetail_t.jmlkemasan_reseptur, resepturdetail_t.kekuatan_reseptur, resepturdetail_t.satuankekuatan, resepturdetail_t.signa_reseptur, resepturdetail_t.etiket, resepturdetail_t.qty_reseptur, resepturdetail_t.hargasatuan_reseptur, obatalkes_m.obatalkes_nama, satuankecil_m.satuankecil_nama
                    FROM resepturdetail_t
                    JOIN obatalkes_m ON obatalkes_m.obatalkes_id = resepturdetail_t.obatalkes_id
                    JOIN satuankecil_m ON satuankecil_m.satuankecil_id = resepturdetail_t.satuankecil_id
                    WHERE resepturdetail_t.reseptur_id = ".$val['reseptur_id'];
                $loadDataDets = Yii::app()->db->createCommand($sql_det)->queryAll();
                if(count($loadDataDets) > 0){
                    $data[$i]['resepdetail'] = $loadDataDets;
                }
            }
        }
        return $data;
    }
    
    /**
     * Menampilkan riwayat morbiditas (diagnosis)
     * MA-55
     * @param type $pendaftaran_id
     * @return type
     */
    protected function getRiwayatMorbiditas($pendaftaran_id){
        $format = new MyFormatter();
        $data = array();
        $sql = "SELECT morfologineoplasma_m.morfologineoplasma_nama, jeniskasuspenyakit_m.jeniskasuspenyakit_nama, ruangan_m.ruangan_nama, kamarruangan_m.kamarruangan_nokamar, kamarruangan_m.kamarruangan_nobed,
            diagnosaicdix_m.diagnosaicdix_kode, diagnosaicdix_m.diagnosaicdix_nama,
            sebabdiagnosa_m.sebabdiagnosa_nama,
            kelompokumur_m.kelompokumur_nama,
            golonganumur_m.golonganumur_nama,
            diagnosa_m.diagnosa_kode, diagnosa_m.diagnosa_nama,
            sebabin_m.sebabin_nama,
            penyebabluarcedera_m.penyebabluarcedera_nama,
            pasienmorbiditas_t.tglmorbiditas, pasienmorbiditas_t.kasusdiagnosa, pasienmorbiditas_t.infeksinosokomial,
            pegawai_m.gelardepan, pegawai_m.nama_pegawai, gelarbelakang_m.gelarbelakang_nama
            FROM pasienmorbiditas_t
            LEFT JOIN morfologineoplasma_m ON morfologineoplasma_m.morfologineoplasma_id = pasienmorbiditas_t.morfologineoplasma_id
            JOIN jeniskasuspenyakit_m ON jeniskasuspenyakit_m.jeniskasuspenyakit_id = pasienmorbiditas_t.jeniskasuspenyakit_id
            JOIN ruangan_m ON ruangan_m.ruangan_id = pasienmorbiditas_t.ruangan_id
            LEFT JOIN kamarruangan_m ON kamarruangan_m.kamarruangan_id = pasienmorbiditas_t.kamarruangan_id
            LEFT JOIN diagnosaicdix_m ON diagnosaicdix_m.diagnosaicdix_id = pasienmorbiditas_t.diagnosaicdix_id
            LEFT JOIN sebabdiagnosa_m ON sebabdiagnosa_m.sebabdiagnosa_id = pasienmorbiditas_t.sebabdiagnosa_id
            JOIN kelompokumur_m ON kelompokumur_m.kelompokumur_id = pasienmorbiditas_t.kelompokumur_id
            JOIN diagnosa_m ON diagnosa_m.diagnosa_id = pasienmorbiditas_t.diagnosa_id
            LEFT JOIN sebabin_m ON sebabin_m.sebabin_id = pasienmorbiditas_t.sebabin_id
            JOIN golonganumur_m ON golonganumur_m.golonganumur_id = pasienmorbiditas_t.golonganumur_id
            LEFT JOIN penyebabluarcedera_m ON penyebabluarcedera_m.penyebabluarcedera_id = pasienmorbiditas_t.penyebabluarcedera_id
            JOIN pegawai_m ON pegawai_m.pegawai_id = pasienmorbiditas_t.pegawai_id
            LEFT JOIN gelarbelakang_m ON gelarbelakang_m.gelarbelakang_id = pegawai_m.gelarbelakang_id
            WHERE pasienmorbiditas_t.pendaftaran_id = ".$pendaftaran_id."
        ";
        $loadDatas = Yii::app()->db->createCommand($sql)->queryAll();
        if(count($loadDatas) > 0){
            foreach($loadDatas AS $i => $val){
                $data[$i] = $val;
                $data[$i]['tglmorbiditas'] = $format->formatDateTimeForUser($val['tglmorbiditas']);
                $data[$i]['nama_pegawai'] = $val['gelardepan']." ".$val['nama_pegawai']." ".$val['gelarbelakang_nama'];
            }
        }
        return $data;
    }
    
    /**
     * menampilkan berita terbaru
     * MA-17
     * @param $_GET['q']
     * @return json
     */
    public function actionGetBeritaTerbaru(){
        header("content-type:application/json");
        $format = new MyFormatter();
        $data = array();
        $req = (isset($_GET['q']) ? str_replace('"','',str_replace("'","",strtolower(trim($_GET['q'])))) : "");
        $sql = "SELECT mkategoriberita_m.* , mberita_m.*
            FROM mberita_m
            JOIN mkategoriberita_m ON mkategoriberita_m.mkategoriberita_id = mberita_m.mkategoriberita_id
            WHERE
            LOWER(mberita_m.judulberita) like '%".$req."%'
            OR LOWER(mberita_m.ringkasanberita) like '%".$req."%'
            OR LOWER(mberita_m.isiberita) like '%".$req."%'
            OR LOWER(mkategoriberita_m.kategoriberita) like '%".$req."%'
            OR LOWER(mkategoriberita_m.ketkategoriberita) like '%".$req."%'
            AND (mberita_m.waktutampilberita > '".date("Y-m-d H:i:s")."')
            ORDER BY mberita_m.waktutampilberita DESC
            LIMIT 10
            ";
        $loadDatas = Yii::app()->db->createCommand($sql)->queryAll();
        if(count($loadDatas) > 0){
            foreach($loadDatas AS $i => $val){
                $data[$i]= $val;
                $data[$i]['gambarberita_path']= (!empty($val['gambarberita_path']) ? Params::urlBerita().$val['gambarberita_path'] : "");
                $data[$i]['komentarberita'] = array();
                $sql_det = "SELECT *
                    FROM mberitakomentar_t
                    WHERE mberitakomentar_t.mberita_id = ".$val['mberita_id']."
                    ORDER BY mberitakomentar_t.tglkomentar DESC
                    LIMIT 5
                    ";
                $loadDataDets = Yii::app()->db->createCommand($sql_det)->queryAll();
                if(count($loadDataDets) > 0){
                    foreach($loadDataDets AS $ii => $komentar){
                        $data[$i]['komentarberita'][$ii] = $komentar;
                        $data[$i]['komentarberita'][$ii]['tglkomentar'] = $format->formatDateTimeForUser($komentar['tglkomentar']);
                    }
                }
            }
        }
        $encode = CJSON::encode($data);
        echo "jsonCallback(".$encode.")";
        Yii::app()->end();
    }
    /**
     * menampilkan profil dokter berdasarkan pencarian
     * @params $_GET['q']
     * MA-56
     */
    public function actionGetProfilDokter(){
        header("content-type:application/json");
        $req = (isset($_GET['q']) ? str_replace('"','',str_replace("'","",strtolower(trim($_GET['q'])))) : "");
        $data = array();
        $sql = "SELECT pegawai_m.pegawai_id, pegawai_m.gelardepan, pegawai_m.nama_pegawai, gelarbelakang_m.gelarbelakang_nama, pegawai_m.nomorindukpegawai, pegawai_m.tempatlahir_pegawai, pegawai_m.tgl_lahirpegawai, pegawai_m.jeniskelamin, pegawai_m.statusperkawinan, 
            pegawai_m.alamat_pegawai, kelurahan_m.kelurahan_nama, kecamatan_m.kecamatan_nama, kabupaten_m.kabupaten_nama, propinsi_m.propinsi_nama, 
            pegawai_m.alamatemail, pegawai_m.nomobile_pegawai, pegawai_m.notelp_pegawai, pegawai_m.photopegawai, pegawai_m.suratizinpraktek, pegawai_m.deskripsi
            FROM pegawai_m 
            LEFT JOIN gelarbelakang_m ON gelarbelakang_m.gelarbelakang_id = pegawai_m.gelarbelakang_id
            LEFT JOIN propinsi_m ON propinsi_m.propinsi_id =  pegawai_m.propinsi_id
            LEFT JOIN kabupaten_m ON kabupaten_m.kabupaten_id =  pegawai_m.kabupaten_id
            LEFT JOIN kecamatan_m ON kecamatan_m.kecamatan_id =  pegawai_m.kecamatan_id
            LEFT JOIN kelurahan_m ON kelurahan_m.kelurahan_id =  pegawai_m.kelurahan_id
            WHERE
                LOWER(pegawai_m.nama_pegawai) LIKE '%".$req."%'
                OR LOWER(pegawai_m.nomorindukpegawai) LIKE '%".$req."%'
                OR LOWER(pegawai_m.alamat_pegawai) LIKE '%".$req."%'
                OR LOWER(kelurahan_m.kelurahan_nama) LIKE '%".$req."%'
                OR LOWER(kecamatan_m.kecamatan_nama) LIKE '%".$req."%'
                OR LOWER(kabupaten_m.kabupaten_nama) LIKE '%".$req."%'
                OR LOWER(propinsi_m.propinsi_nama) LIKE '%".$req."%'
                OR LOWER(pegawai_m.alamatemail) LIKE '%".$req."%'
                OR LOWER(pegawai_m.nomobile_pegawai) LIKE '%".$req."%'
                OR LOWER(pegawai_m.notelp_pegawai) LIKE '%".$req."%'
                OR LOWER(pegawai_m.suratizinpraktek) LIKE '%".$req."%'
            LIMIT 5
            ";
        $loadDatas = Yii::app()->db->createCommand($sql)->queryAll();
        if(count($loadDatas) > 0){
            foreach($loadDatas AS $i => $val){
                $data[$i] = $val;
                $data[$i]['url_photopegawai'] = Params::urlPegawaiDirectory().$val['photopegawai'];
                $data[$i]['url_thumb_photopegawai'] = Params::urlPegawaiTumbsDirectory()."kecil_".$val['photopegawai'];
                $data[$i]['poliklinik'] = "";
                $sql_poli = "SELECT instalasi_m.instalasi_id, instalasi_m.instalasi_nama, ruangan_m.ruangan_id, ruangan_m.ruangan_nama 
                    FROM ruanganpegawai_m 
                    JOIN ruangan_m ON ruangan_m.ruangan_id = ruanganpegawai_m.ruangan_id
                    JOIN instalasi_m ON instalasi_m.instalasi_id = ruangan_m.instalasi_id
                    WHERE 
                        ruangan_m.instalasi_id = ".Params::INSTALASI_ID_RJ."
                        AND ruanganpegawai_m.pegawai_id = ".$val['pegawai_id']."
                    ORDER BY ruangan_m.ruangan_nama ASC
                ";
                $loadDataPolis = Yii::app()->db->createCommand($sql_poli)->queryAll();
                if(count($loadDataPolis > 0)){
                    $data[$i]['poliklinik'] = $loadDataPolis;
                }
                $data[$i]['pendidikan'] = "";
                $sql_pendidikan = "SELECT pendidikanpegawai_r.nourut_pend, pendidikan_m.pendidikan_nama, pendidikanpegawai_r.jenispendidikan, pendidikanpegawai_r.namasek_univ, pendidikanpegawai_r.almtsek_univ, kabupaten_m.kabupaten_nama, propinsi_m.propinsi_nama, 
                    pendidikanpegawai_r.tglmasuk, pendidikanpegawai_r.tgllulus, pendidikanpegawai_r.lamapendidikan_bln, pendidikanpegawai_r.keteranganpend
                    FROM pendidikanpegawai_r 
                    LEFT JOIN pendidikan_m ON pendidikan_m.pendidikan_id = pendidikanpegawai_r.pendidikan_id
                    LEFT JOIN kabupaten_m ON kabupaten_m.kabupaten_id = pendidikanpegawai_r.kabupaten_id
                    LEFT JOIN propinsi_m ON propinsi_m.propinsi_id = pendidikanpegawai_r.propinsi_id
                    WHERE pendidikanpegawai_r.pegawai_id = ".$val['pegawai_id']."
                    ORDER BY pendidikanpegawai_r.nourut_pend ASC
                ";
                $loadDataPendidikans = Yii::app()->db->createCommand($sql_pendidikan)->queryAll();
                if(count($loadDataPendidikans > 0)){
                    $data[$i]['pendidikan'] = $loadDataPendidikans;
                }
                $data[$i]['pengalamankerja'] = "";
                $sql_kerja = "SELECT pengalamankerja_r.pengalamankerja_nourut,pengalamankerja_r.namaperusahaan, pengalamankerja_r.bidangperusahaan, pengalamankerja_r.jabatanterahkir, pengalamankerja_r.tglmasuk, pengalamankerja_r.tglkeluar, pengalamankerja_r.lama_tahun, pengalamankerja_r.lama_bulan, pengalamankerja_r.keterangan
                    FROM pengalamankerja_r
                    WHERE pengalamankerja_r.pegawai_id = ".$val['pegawai_id']."
                    ORDER BY pengalamankerja_r.pengalamankerja_nourut ASC
                ";
                $loadDataKerjas = Yii::app()->db->createCommand($sql_kerja)->queryAll();
                if(count($loadDataPendidikans > 0)){
                    $data[$i]['pengalamankerja'] = $loadDataKerjas;
                }
                $data[$i]['rateaverage'] = 0;
                $sql_rate = "SELECT ratedokter_t.pegawai_id, AVG(ratedokter) AS rateaverage
                    FROM ratedokter_t
                    WHERE ratedokter_t.pegawai_id = ".$val['pegawai_id']."
                    GROUP BY ratedokter_t.pegawai_id
                ";
                $loadDataRate = Yii::app()->db->createCommand($sql_rate)->queryRow();
                if(isset($loadDataRate['rateaverage'])){
                    $data[$i]['rateaverage'] = $loadDataRate['rateaverage'];
                }
            }
        }
        $encode = CJSON::encode($data);
        echo "jsonCallback(".$encode.")";
        Yii::app()->end();
        
    }
    
    /**
     * menampilkan jadwal pasien
     * MA-62
     * @params $_GET['pasien_id']
     * @params $_GET['bulan'] : yyyy-mm
     */
    public function actionGetJadwalPasien(){
        header("content-type:application/json");
        $format = new MyFormatter();
        $data = array();
        if(isset($_GET['pasien_id']) && isset($_GET['bulan'])){
            $pasien_id = $_GET['pasien_id'];
            $bulan = $_GET['bulan'];
            $sql = "
                (
                    SELECT 
                    buatjanjipoli_t.tgljadwal AS tgljadwal,pegawai_m.gelardepan, pegawai_m.nama_pegawai, gelarbelakang_m.gelarbelakang_nama,
                    ruangan_m.ruangan_nama, 'Janji Poliklinik' AS keterangan
                    FROM buatjanjipoli_t
                    LEFT JOIN pegawai_m ON pegawai_m.pegawai_id = buatjanjipoli_t.pegawai_id
                    LEFT JOIN gelarbelakang_m ON gelarbelakang_m.gelarbelakang_id = pegawai_m.gelarbelakang_id
                    JOIN ruangan_m ON ruangan_m.ruangan_id = buatjanjipoli_t.ruangan_id
                    WHERE buatjanjipoli_t.pasien_id = ".$pasien_id."
                        ".(!empty($_GET['bulan']) ? " AND TO_CHAR(buatjanjipoli_t.tgljadwal,'YYYY-MM') = '".$bulan : "")."'
                        AND DATE(buatjanjipoli_t.tgljadwal) >= '".date("Y-m-d")."'
                    UNION ALL
                    SELECT 
                    pendaftaran_t.tglrenkontrol AS tgljadwal, dokterpenunjang_m.gelardepan, dokterpenunjang_m.nama_pegawai, gelarbelakang_m.gelarbelakang_nama, 
                    ruanganpenunjang_m.ruangan_nama, 'Rencana Kontrol' AS keterangan
                    FROM pendaftaran_t
                    JOIN pasienmasukpenunjang_t ON pasienmasukpenunjang_t.pendaftaran_id = pendaftaran_t.pendaftaran_id
                    JOIN ruangan_m ON ruangan_m.ruangan_id = pendaftaran_t.ruangan_id
                    JOIN ruangan_m ruanganpenunjang_m ON ruanganpenunjang_m.ruangan_id = pasienmasukpenunjang_t.ruangan_id 
                    LEFT JOIN pegawai_m dokterpenunjang_m ON dokterpenunjang_m.pegawai_id = pasienmasukpenunjang_t.pegawai_id
                    LEFT JOIN gelarbelakang_m ON gelarbelakang_m.gelarbelakang_id = dokterpenunjang_m.gelarbelakang_id      
                    WHERE pendaftaran_t.tglrenkontrol IS NOT NULL
                        AND pendaftaran_t.pasien_id = ".$pasien_id."
                        AND TO_CHAR(pendaftaran_t.tglrenkontrol,'YYYY-MM') = '".$bulan."'
                        AND DATE(pendaftaran_t.tglrenkontrol) >= '".date("Y-m-d")."'
                )
                ORDER BY tgljadwal ASC
                ";
            $loadDatas = Yii::app()->db->createCommand($sql)->queryAll();
            if(count($loadDatas) > 0){
                foreach($loadDatas AS $i => $val){
                    $data[$i] = $val;
                    $data[$i]['nama_pegawai'] = $val['gelardepan']." ".$val['nama_pegawai']." ".$val['gelarbelakang_nama'];
                    $data[$i]['tgljadwal'] = $format->formatDateTimeForUser($val['tgljadwal']);
                }
            }
        }
        $encode = CJSON::encode($data);
        echo "jsonCallback(".$encode.")";
        Yii::app()->end();
    }
    
    /**
     * transaksi pesan ambulan
     * MA-60
     * @param $_GET['pasien_id']
     * @param $_GET['longitude']
     * @param $_GET['latitude']
     * @param $_GET['alamattujuan']
     * @param $_GET['nomobile']
     * @return json
     */
    public function actionPesanAmbulan(){
        header("content-type:application/json");
        $data = array();
        $data['sukses'] = 0;
        $data['pesan'] = 'Error 404 : Request tidak valid. Cek parameter';
        if(isset($_GET['pasien_id'])){
            $transaction = Yii::app()->db->beginTransaction();
            try{
                $model = new MOPesanambulansT;
                $model->tglpemesananambulans = date('Y-m-d H:i:s');
                $model->pesanambulans_no = MyGenerator::noPesanAmbulans(Params::INSTALASI_ID_AMBULAN);
                $modPasien = PasienM::model()->findByPk($_GET['pasien_id']);
                $model->pasien_id = $modPasien->pasien_id;
                $model->norekammedis = $modPasien->no_rekam_medik;
                $model->namapasien = $modPasien->namadepan." ".$modPasien->nama_pasien;
                $model->ruangan_id = Params::RUANGAN_ID_AMBULANCE;
                $model->keteranganpesan = "Pesan ambulan via m-Pasien";
                $model->longitude = (isset($_GET['longitude']) ? $_GET['longitude'] : "");
                $model->latitude = (isset($_GET['latitude']) ? $_GET['latitude'] : "");
                $model->alamattujuan = (isset($_GET['alamattujuan']) ? $_GET['alamattujuan'] : "");
                $model->nomobile = (isset($_GET['nomobile']) ? $_GET['nomobile'] : "");
                $model->create_time = date('Y-m-d H:i:s');
                $model->create_loginpemakai_id = 1;
                $model->create_ruangan = Params::RUANGAN_ID_AMBULANCE;
                
                if($model->save()){
                    $transaction->commit();
                    $data['sukses'] = 1;
                    $data['pesan'] = 'Pemesanan ambulan berhasil dilakukan!';
                }else{
                    $transaction->rollback();
                    $data['sukses'] = 0;
                    $data['pesan'] = 'Pemesanan ambulan gagal dilakukan!';
                }
            }catch (Exception $exc) {
                $transaction->rollback();
                $data['sukses'] = 0;
                $data['pesan'] = 'Pemesanan ambulan gagal dilakukan!'.MyExceptionMessage::getMessage($exc,true);
            }
            
        }
        $encode = CJSON::encode($data);
        echo "jsonCallback(".$encode.")";
        Yii::app()->end();
    }
    
    
    /**
     * transaksi rate dokter
     * MA-67
     * @param $_GET['pasien_id']
     * @param $_GET['pegawai_id']
     * @param $_GET['ratedokter']
     * @return json
     */
    public function actionRateDokter(){
        header("content-type:application/json");
        $data = array();
        $data['sukses'] = 0;
        $data['pesan'] = 'Error 404 : Request tidak valid. Cek parameter';
        if(isset($_GET['pasien_id']) && isset($_GET['pegawai_id']) && isset($_GET['ratedokter'])){
            $transaction = Yii::app()->db->beginTransaction();
            try{
                $model = MORatedokterT::model()->findByAttributes(array('pasien_id'=>$_GET['pasien_id'],'pegawai_id'=>$_GET['pegawai_id']));
                if(empty($model)){
                    $model = new MORatedokterT;
                }
                $model->pasien_id = $_GET['pasien_id'];
                $model->pegawai_id = $_GET['pegawai_id'];
                $model->ratedokter = $_GET['ratedokter'];
                $model->tglratedokter = date('Y-m-d H:i:s');
                if($model->save()){
                    $transaction->commit();
                    $data['sukses'] = 1;
                    $data['pesan'] = 'Rate dokter '.$model->NamaDokter.' berhasil dilakukan!';
                }else{
                    $transaction->rollback();
                    $data['sukses'] = 0;
                    $data['pesan'] = 'Rate dokter '.$model->NamaDokter.' gagal dilakukan!';
                }
            }catch (Exception $exc) {
                $transaction->rollback();
                $data['sukses'] = 0;
                $data['pesan'] = 'Rate dokter '.$model->NamaDokter.' gagal dilakukan!'.MyExceptionMessage::getMessage($exc,true);
            }
            
        }
        $encode = CJSON::encode($data);
        echo "jsonCallback(".$encode.")";
        Yii::app()->end();
    }
    
    /**
     * transaksi survei pelayanan (kepuasan)
     * 
     * @param $_GET['pasien_id'] Boleh Kosong
     * @param $_GET['status_kepuasan'] | 0 = TIDAK PUAS, 1 = PUAS , 2 =  BIASA, 3 = SANGAT PUAS
     * @return json
     */
    public function actionSurveiPelayanan(){
        header("content-type:application/json");
        $data = array();
        $data['sukses'] = 0;
        $data['pesan'] = 'Error 404 : Request tidak valid. Cek parameter';
        if(isset($_GET['pasien_id']) && isset($_GET['status_kepuasan'])){
            $transaction = Yii::app()->db->beginTransaction();
            try{
				$status_kep = isset($_GET['status_kepuasan'])?$_GET['status_kepuasan']:null;
								
				
                $model = new MOMsurveypelayananT;
                $model->pasien_id = $_GET['pasien_id'];
                $model->status_kepuasan = Params::getSurveiKepuasan($status_kep);
                $model->jenissurvey = Params::JENISSURVEY_MOBILE;
                $model->tglsurveypelayanan = date('Y-m-d H:i:s');
                if($model->save()){
                    $transaction->commit();
                    $data['sukses'] = 1;
                    $data['pesan'] = 'Survei berhasil dilakukan!';
                }else{
                    $transaction->rollback();
                    $data['sukses'] = 0;
                    $data['pesan'] = 'Survei gagal dilakukan!';
                }
            }catch (Exception $exc) {
                $transaction->rollback();
                $data['sukses'] = 0;
                $data['pesan'] = 'Survei gagal dilakukan!'.MyExceptionMessage::getMessage($exc,true);
            }
            
        }
        $encode = CJSON::encode($data);
        echo "jsonCallback(".$encode.")";
        Yii::app()->end();
    }
    
    /**
     * set form janji ketika load di mobile
     * MA-79
     * @param $_GET['pasien_id']
     * @return json
     */
    public function actionSetFormJanjiPoli(){
        header("content-type:application/json");
        $data = array();
        if(isset($_GET['pasien_id'])){
            $sql = "SELECT ruangan_id, ruangan_nama
                    FROM ruangan_m
                    WHERE ruangan_aktif = TRUE 
                        AND instalasi_id = ".Params::INSTALASI_ID_RJ."
                    ORDER BY ruangan_nourut";
            $loadDatas = Yii::app()->db->createCommand($sql)->queryAll();
            $data['ruangans'] = array();
            if(count($loadDatas) > 0){
                $data['ruangans'] = $loadDatas;
            }
            $data['dokters'] = array();
        }
        
        $encode = CJSON::encode($data);
        echo "jsonCallback(".$encode.")";
        Yii::app()->end();
    }
    
    /**
     * menampilkan dokter untuk janji poliklinik
     * MA-79
     * @param $_GET['ruangan_id']
     * @return json
     */
    public function actionGetDokterJanjiPoli(){
        header("content-type:application/json");
        $data = array();
        if(isset($_GET['ruangan_id'])){
            $sql = "SELECT pegawai_m.pegawai_id, pegawai_m.gelardepan, pegawai_m.nama_pegawai, gelarbelakang_m.gelarbelakang_nama, pegawai_m.jeniskelamin
                        FROM ruanganpegawai_m
                        JOIN pegawai_m ON ruanganpegawai_m.pegawai_id = pegawai_m.pegawai_id
                        LEFT JOIN gelarbelakang_m ON pegawai_m.gelarbelakang_id = gelarbelakang_m.gelarbelakang_id
                    WHERE (pegawai_m.kelompokpegawai_id IN (".Params::KELOMPOKPEGAWAI_ID_TENAGA_MEDIK.")) 
                        AND pegawai_m.pegawai_aktif = true
                        AND ruanganpegawai_m.ruangan_id = ".$_GET['ruangan_id']."
                    ORDER BY pegawai_m.nama_pegawai";
            $loadDatas = Yii::app()->db->createCommand($sql)->queryAll();
            $data['dokters'] = array();
            if(count($loadDatas) > 0){
                foreach($loadDatas AS $i => $val){
                    $data['dokters'][$i] = $val;
                    $data['dokters'][$i]['nama_pegawai'] = $val['gelardepan']." ".$val['nama_pegawai'].", ".$val['gelarbelakang_nama'];
                }
            }
        }
        
        $encode = CJSON::encode($data);
        echo "jsonCallback(".$encode.")";
        Yii::app()->end();
    }
    
    /**
     * transaksi janji poliklinik
     * MA-79
     * @param $_GET['pasien_id'] 
     * @param $_GET['buatjanjipoli'] array() / serialize
     * @return json
     */
    public function actionJanjiPoli(){
        header("content-type:application/json");
        $data = array();
        $data['sukses'] = 0;
        $data['pesan'] = 'Error 404 : Request tidak valid. Cek parameter';
        if(isset($_GET['pasien_id']) && isset($_GET['buatjanjipoli'])){
            $transaction = Yii::app()->db->beginTransaction();
            try{
                $model = new MOBuatjanjipoliT;
                $model->pasien_id = $_GET['pasien_id'];
                $model->attributes = $_GET['buatjanjipoli'];
                $model->keteranganbuatjanji = $_GET['buatjanjipoli']['keteranganbuatjanji']." via m-Pasien";
                $model->create_time = date("Y-m-d H:i:s");
                $model->create_loginpemakai_id = 1;
				$ruangan_id = $model->ruangan_id;
                $model->no_antrianjanji = MyGenerator::noAntrianJanjiPoli($ruangan_id, "000");
                if($model->save()){
                    $transaction->commit();
                    $data['sukses'] = 1;
                    $data['pesan'] = 'Janji poliklinik berhasil!';
                }else{
                    $transaction->rollback();
                    $data['sukses'] = 0;
                    $data['pesan'] = 'Janji poliklinik gagal!<br>'.CHtml::errorSummary($model);
                }
            }catch (Exception $exc) {
                $transaction->rollback();
                $data['sukses'] = 0;
                $data['pesan'] = 'Janji poliklinik gagal!'.MyExceptionMessage::getMessage($exc,true);
            }
            
        }
        $encode = CJSON::encode($data);
        echo "jsonCallback(".$encode.")";
        Yii::app()->end();
    }
    
    /**
     * transaksi komentar berita pasien
     * MA-124
     * @param $_GET['pasien_id'] 
     * @param $_GET['mberita_id'] 
     * @param $_GET['isikomentar'] text
     * @return json
     */
    public function actionKomentariBerita(){
        header("content-type:application/json");
        $data = array();
        $data['sukses'] = 0;
        $data['pesan'] = 'Error 404 : Request tidak valid. Cek parameter';
        if(isset($_GET['pasien_id']) && isset($_GET['mberita_id']) && isset($_GET['isikomentar'])){
            $pasien_id = $_GET['pasien_id'];
            $transaction = Yii::app()->db->beginTransaction();
            try{
                $sql = "SELECT * 
                        FROM pasien_m 
                        WHERE pasien_id = ".$pasien_id;
                $loadDatas = Yii::app()->db->createCommand($sql)->queryRow();
                $model = new MOMberitakomentarT();
                $model->mberita_id = $_GET['mberita_id'];
                $model->tglkomentar = date("Y-m-d H:i:s");
                $model->isikomentar = str_replace('"','',str_replace("'","",$_GET['isikomentar']));
                if($loadDatas){
                    $model->namakomentar = $loadDatas['nama_pasien'].", ".$loadDatas['namadepan']." / No.RM: ".$loadDatas['no_rekam_medik'];
                    $model->emailkomentar = (empty($loadDatas['alamatemail']) ? "-" : $loadDatas['alamatemail']);
                    $model->tampilkankomentar = TRUE;
                }else{
                    $model->namakomentar = "Tidak dikenal";
                    $model->emailkomentar = "-";
                    $model->tampilkankomentar = FALSE;
                }
                
                if($model->save()){
                    $transaction->commit();
                    $data['sukses'] = 1;
                    $data['pesan'] = 'Komentar berita berhasil dikirim!';
                }else{
                    $transaction->rollback();
                    $data['sukses'] = 0;
                    $data['pesan'] = 'Komentar berita gagal dikirim!<br>'.CHtml::errorSummary($model);
                }
            }catch (Exception $exc) {
                $transaction->rollback();
                $data['sukses'] = 0;
                $data['pesan'] = 'Komentar berita gagal dikirim!'.MyExceptionMessage::getMessage($exc,true);
            }
            
        }
        $encode = CJSON::encode($data);
        echo "jsonCallback(".$encode.")";
        Yii::app()->end();
    }
    
    
    /**
     * Set form dashboard pasien
     * MA-145
     */
    public function actionSetDashboardPasien(){
        header("content-type:application/json");
        $data = array();
        if(isset($_GET['pasien_id'])){
            $pasien_id = $_GET['pasien_id'];
            $sql = "SELECT pendaftaran_id
                    FROM pendaftaran_t
                    ORDER BY tgl_pendaftaran DESC
                    LIMIT 1";
            $loadDatas = Yii::app()->db->createCommand($sql)->queryRow();
            if($loadDatas){
                $data['anamnesa'] = $this->getRiwayatAnamnesa($loadDatas['pendaftaran_id']);
                $data['pemeriksaanfisik'] = $this->getRiwayatPemeriksaanFisik($loadDatas['pendaftaran_id']);
                $data['janjipoli'] = $this->getJanjiPoliPasien($pasien_id);
                $data['rencanakontrol'] = $this->getRencanaKontrolPasien($pasien_id);
                $data['bookingkamar'] = $this->getBookingKamarPasien($pasien_id);
            }
        }
        $encode = CJSON::encode($data);
        echo "jsonCallback(".$encode.")";
        Yii::app()->end();
    }
    
    /**
     * Menampilkan janji poliklinik
     * MA-145
     * @param type $pasien_id
     * @return type
     */
    protected function getJanjiPoliPasien($pasien_id){
        $format = new MyFormatter();
        $data = array();
        $sql = "
            SELECT 
            buatjanjipoli_t.buatjanjipoli_id,buatjanjipoli_t.tgljadwal,pegawai_m.gelardepan, pegawai_m.nama_pegawai, gelarbelakang_m.gelarbelakang_nama,
            ruangan_m.ruangan_nama
            FROM buatjanjipoli_t
            LEFT JOIN pegawai_m ON pegawai_m.pegawai_id = buatjanjipoli_t.pegawai_id
            LEFT JOIN gelarbelakang_m ON gelarbelakang_m.gelarbelakang_id = pegawai_m.gelarbelakang_id
            JOIN ruangan_m ON ruangan_m.ruangan_id = buatjanjipoli_t.ruangan_id
            WHERE buatjanjipoli_t.pasien_id = ".$pasien_id."
                AND DATE(buatjanjipoli_t.tgljadwal) >= '".date("Y-m-d")."'
            ORDER BY tgljadwal ASC
            LIMIT 5
            ";
        $loadDatas = Yii::app()->db->createCommand($sql)->queryAll();
        if(count($loadDatas) > 0){
            foreach($loadDatas AS $i => $val){
                $data[$i] = $val;
                $data[$i]['tgljadwal'] = $format->formatDateTimeId($val['tgljadwal']);
				$data[$i]['gelardepan'] = !empty($val['gelardepan'])?$val['gelardepan']:'';
				$data[$i]['gelarbelakang_nama'] = !empty($val['gelarbelakang_nama'])?$val['gelarbelakang_nama']:'';
				
				$cekTgl = date('Y-m-d',strtotime($val['tgljadwal']));
				
				if (date('Y-m-d') == $cekTgl){
					$data[$i]['hari_ini'] = true;
				}else{
					$data[$i]['hari_ini'] = false;
				}
            }
        }
        return $data;
    }
    /**
     * Menampilkan rencana kontrol
     * MA-145
     * @param type $pasien_id
     * @return type
     */
    protected function getRencanaKontrolPasien($pasien_id){
        $format = new MyFormatter();
        $data = array();
        /*$sql = "
            SELECT 
            pendaftaran_t.pendaftaran_id, pendaftaran_t.no_pendaftaran, pendaftaran_t.tglrenkontrol, dokterpenunjang_m.gelardepan, dokterpenunjang_m.nama_pegawai, gelarbelakang_m.gelarbelakang_nama, 
            ruanganpenunjang_m.ruangan_nama
            FROM pendaftaran_t
            JOIN pasienmasukpenunjang_t ON pasienmasukpenunjang_t.pendaftaran_id = pendaftaran_t.pendaftaran_id
            JOIN ruangan_m ON ruangan_m.ruangan_id = pendaftaran_t.ruangan_id
            JOIN ruangan_m ruanganpenunjang_m ON ruanganpenunjang_m.ruangan_id = pasienmasukpenunjang_t.ruangan_id 
            LEFT JOIN pegawai_m dokterpenunjang_m ON dokterpenunjang_m.pegawai_id = pasienmasukpenunjang_t.pegawai_id
            LEFT JOIN gelarbelakang_m ON gelarbelakang_m.gelarbelakang_id = dokterpenunjang_m.gelarbelakang_id      
            WHERE pendaftaran_t.tglrenkontrol IS NOT NULL
                AND pendaftaran_t.pasien_id = ".$pasien_id."
                AND DATE(pendaftaran_t.tglrenkontrol) >= '".date("Y-m-d")."'
            ORDER BY tglrenkontrol ASC
            LIMIT 5
            ";*/
		
		$sql = "
            SELECT 
            pendaftaran_t.pendaftaran_id, pendaftaran_t.no_pendaftaran, pendaftaran_t.tglrenkontrol, pegawai_m.gelardepan, pegawai_m.nama_pegawai, gelarbelakang_m.gelarbelakang_nama, 
            ruangan_m.ruangan_nama
            FROM pendaftaran_t            
            JOIN ruangan_m ON ruangan_m.ruangan_id = pendaftaran_t.ruangan_id            
            LEFT JOIN pegawai_m pegawai_m ON pegawai_m.pegawai_id = pendaftaran_t.pegawai_id
            LEFT JOIN gelarbelakang_m ON gelarbelakang_m.gelarbelakang_id = pegawai_m.gelarbelakang_id      
            WHERE pendaftaran_t.tglrenkontrol IS NOT NULL
                AND pendaftaran_t.pasien_id = ".$pasien_id."
                AND DATE(pendaftaran_t.tglrenkontrol) >= '".date("Y-m-d")."'
            ORDER BY tglrenkontrol ASC
            LIMIT 5
            ";
        $loadDatas = Yii::app()->db->createCommand($sql)->queryAll();
        if(count($loadDatas) > 0){
            foreach($loadDatas AS $i => $val){
                $data[$i] = $val;
                $data[$i]['tglrenkontrol'] = $format->formatDateTimeId($val['tglrenkontrol']);
				$data[$i]['gelardepan'] = !empty($val['gelardepan'])?$val['gelardepan']:'';
				$data[$i]['gelarbelakang_nama'] = !empty($val['gelarbelakang_nama'])?$val['gelarbelakang_nama']:'';
            }
        }
        return $data;
    }
    /**
     * Menampilkan rencana kontrol
     * MA-145
     * @param type $pasien_id
     * @return type
     */
    protected function getBookingKamarPasien($pasien_id){
        $format = new MyFormatter();
        $data = array();
        $sql = "
            SELECT bookingkamar_t.bookingkamar_id, bookingkamar_t.bookingkamar_no, bookingkamar_t.tgltransaksibooking, bookingkamar_t.tglbookingkamar, bookingkamar_t.statusbooking, bookingkamar_t.keteranganbooking, bookingkamar_t.statuskonfirmasi,
            kelaspelayanan_m.kelaspelayanan_nama, 
            ruangan_m.ruangan_nama, 
            kamarruangan_m.kamarruangan_nokamar, kamarruangan_m.kamarruangan_nobed
            FROM bookingkamar_t
            JOIN ruangan_m ON ruangan_m.ruangan_id = bookingkamar_t.ruangan_id
            JOIN kamarruangan_m ON kamarruangan_m.kamarruangan_id = bookingkamar_t.kamarruangan_id
            JOIN kelaspelayanan_m ON kelaspelayanan_m.kelaspelayanan_id = bookingkamar_t.kelaspelayanan_id      
            WHERE bookingkamar_t.pasien_id = ".$pasien_id."
                AND DATE(bookingkamar_t.tglbookingkamar) >= '".date("Y-m-d")."'
            ORDER BY tglbookingkamar ASC
            LIMIT 5
            ";
        $loadDatas = Yii::app()->db->createCommand($sql)->queryAll();
        if(count($loadDatas) > 0){
            foreach($loadDatas AS $i => $val){
                $data[$i] = $val;
                $data[$i]['tgltransaksibooking'] = $format->formatDateTimeId($val['tgltransaksibooking']);
            }
        }
        return $data;
    }
    
    /**
     * Set get jumlah antrian ke pendaftaran untuk dashboard pasien
     * MA-152
     * @params $_GET['pasien_id']
     * @return
     * $data['totalantrian'] = array(array());
     * $data['sisaantrian'] = array(array());
     */
    public function actionGetAntrianKePendaftaran(){
        header("content-type:application/json");
        $data = array();
        $data['totalantrian']=array();
        $data['sisaantrian']=array(); 
        if(isset($_GET['pasien_id'])){
						
             
            $sql = "SELECT loket_m.loket_id, loket_m.loket_nama, COUNT(antrian_t.loket_id) AS jumlah
                    FROM antrian_t
                    LEFT JOIN loket_m ON loket_m.loket_id = antrian_t.loket_id
                    JOIN ruangan_m ON ruangan_m.ruangan_id = antrian_t.ruangan_id
                    JOIN carabayar_m ON carabayar_m.carabayar_id = antrian_t.carabayar_id
                    WHERE DATE(antrian_t.tglantrian) = '".date("Y-m-d")."'
                        AND ruangan_m.ruangan_id = ".Params::DEFAULT_RUANGAN_KIOSK."
                    GROUP BY antrian_t.loket_id, loket_m.loket_id, loket_m.loket_nama";
            $loadDatas = Yii::app()->db->createCommand($sql)->queryAll();
            if($loadDatas){
                $data['totalantrian'] = $loadDatas;
            }
            
            $sql = "SELECT loket_m.loket_id, loket_m.loket_nama, COUNT(antrian_t.loket_id) AS jumlah
			
           FROM antrian_t
                    LEFT JOIN loket_m ON loket_m.loket_id = antrian_t.loket_id
                    JOIN ruangan_m ON ruangan_m.ruangan_id = antrian_t.ruangan_id
                    JOIN carabayar_m ON carabayar_m.carabayar_id = antrian_t.carabayar_id
                    WHERE DATE(antrian_t.tglantrian) = '".date("Y-m-d")."'
                        AND ruangan_m.ruangan_id = ".Params::DEFAULT_RUANGAN_KIOSK."
                        AND (antrian_t.pendaftaran_id IS NULL OR antrian_t.panggil_flaq = FALSE)
                    GROUP BY antrian_t.loket_id, loket_m.loket_id, loket_m.loket_nama";
            $loadDatas = Yii::app()->db->createCommand($sql)->queryAll();
            if($loadDatas){
                $data['sisaantrian'] = $loadDatas;
            }
			
			
			$sql = "SELECT loket_m.loket_id, loket_m.loket_nama, COUNT(antrian_t.loket_id) AS jumlah
			
           FROM antrian_t
                    LEFT JOIN loket_m ON loket_m.loket_id = antrian_t.loket_id
                    JOIN ruangan_m ON ruangan_m.ruangan_id = antrian_t.ruangan_id
                    JOIN carabayar_m ON carabayar_m.carabayar_id = antrian_t.carabayar_id
                    WHERE DATE(antrian_t.tglantrian) = '".date("Y-m-d")."'
                        AND ruangan_m.ruangan_id = ".Params::DEFAULT_RUANGAN_KIOSK."
                        AND (antrian_t.pendaftaran_id IS NOT NULL OR antrian_t.panggil_flaq = TRUE)
                    GROUP BY antrian_t.loket_id, loket_m.loket_id, loket_m.loket_nama";
			
			$loadDatas = Yii::app()->db->createCommand($sql)->queryAll();
            if($loadDatas){
                $data['sisatotal'] = $loadDatas;
            }
        }
        $encode = CJSON::encode($data);
        echo "jsonCallback(".$encode.")";
        Yii::app()->end();
    }
    /**
     * Set get jumlah antrian ke poliklinik untuk dashboard pasien
     * MA-152
     * @params $_GET['pasien_id']
     * @return
     * $data['antrianpasien']=array();
     * $data['antriandipanggil']=array();
     * $data['totalantrian']=0;
     * $data['sisaantrian']=0;
     */
    public function actionGetAntrianKePoliklinik(){
        //header("content-type:application/json");
        $data = array();
        $data['antrianpasien']=array();
        $data['antriandipanggil']=array();
        $data['totalantrian']=0;
        $data['sisaantrian']=0;
        if(isset($_GET['pasien_id'])){
            $pasien_id = $_GET['pasien_id'];
            $sql = "SELECT pendaftaran_t.pendaftaran_id, pendaftaran_t.tgl_pendaftaran, 
                        pegawai_m.gelardepan, pegawai_m.nama_pegawai, gelarbelakang_m.gelarbelakang_nama,
                        ruangan_m.ruangan_id, ruangan_m.ruangan_nama, ruangan_m.ruangan_singkatan, 
                        pendaftaran_t.no_urutantri, pendaftaran_t.statusperiksa
                    FROM pendaftaran_t
                    JOIN ruangan_m ON ruangan_m.ruangan_id = pendaftaran_t.ruangan_id
                    JOIN pegawai_m ON pegawai_m.pegawai_id = pendaftaran_t.pegawai_id
                    LEFT JOIN gelarbelakang_m ON gelarbelakang_m.gelarbelakang_id = pegawai_m.gelarbelakang_id
                    WHERE pendaftaran_t.pasien_id = ".$pasien_id."
                    AND DATE(pendaftaran_t.tgl_pendaftaran) = '".date('Y-m-d')."'
                    ORDER BY pendaftaran_t.tgl_pendaftaran DESC
                    LIMIT 1
                    ";
            $loadDataAntrian = Yii::app()->db->createCommand($sql)->queryRow();
            if(isset($loadDataAntrian['ruangan_id'])){
                $data['antrianpasien'] = $loadDataAntrian;
                 
                $sql = "SELECT pendaftaran_t.pendaftaran_id, pendaftaran_t.tgl_pendaftaran, 
                            pegawai_m.gelardepan, pegawai_m.nama_pegawai, gelarbelakang_m.gelarbelakang_nama,
                            ruangan_m.ruangan_id, ruangan_m.ruangan_nama, ruangan_m.ruangan_singkatan, 
                            pendaftaran_t.no_urutantri, pendaftaran_t.statusperiksa
                        FROM pendaftaran_t
                        JOIN ruangan_m ON ruangan_m.ruangan_id = pendaftaran_t.ruangan_id
                        JOIN pegawai_m ON pegawai_m.pegawai_id = pendaftaran_t.pegawai_id
                        LEFT JOIN gelarbelakang_m ON gelarbelakang_m.gelarbelakang_id = pegawai_m.gelarbelakang_id
                        WHERE DATE(pendaftaran_t.tgl_pendaftaran) = '".date("Y-m-d")."'
                            AND ruangan_m.ruangan_id = ".$loadDataAntrian['ruangan_id']."
                            AND pendaftaran_t.panggilantrian = FALSE
                        ORDER BY pendaftaran_t.no_urutantri DESC
                        LIMIT 1";
                $loadData = Yii::app()->db->createCommand($sql)->queryRow();
                if($loadData){
                    $data['antriandipanggil'] = $loadData;
                }
				
				$data['antrianpasien'] = $loadDataAntrian;
                 
                $sql = "SELECT pendaftaran_t.no_urutantri
                        FROM pendaftaran_t                        
                        WHERE DATE(tgl_pendaftaran) = '".date("Y-m-d")."'
                            AND ruangan_id = ".$loadDataAntrian['ruangan_id']."
                            AND panggilantrian = FALSE
                        ORDER BY no_urutantri ASC
                        ";
                $loadData = Yii::app()->db->createCommand($sql)->queryAll();
                if($loadData){
                    $data['sisadipanggil'] = $loadData;
                }
                
                $sql = "SELECT ruangan_m.ruangan_id, ruangan_m.ruangan_nama, COUNT(pendaftaran_t.pendaftaran_id) AS jumlah
                        FROM pendaftaran_t
                        JOIN ruangan_m ON ruangan_m.ruangan_id = pendaftaran_t.ruangan_id
                        WHERE DATE(pendaftaran_t.tgl_pendaftaran) = '".date("Y-m-d")."'
                            AND ruangan_m.ruangan_id = ".$loadDataAntrian['ruangan_id']."
                        GROUP BY ruangan_m.ruangan_id, ruangan_m.ruangan_nama
                        LIMIT 1";
                $loadData = Yii::app()->db->createCommand($sql)->queryRow();
                if($loadData){
                    $data['totalantrian'] = $loadData['jumlah'];
                }
				
                $sql = "SELECT ruangan_m.ruangan_id, ruangan_m.ruangan_nama, COUNT(pendaftaran_t.pendaftaran_id) AS jumlah
                        FROM pendaftaran_t
                        JOIN ruangan_m ON ruangan_m.ruangan_id = pendaftaran_t.ruangan_id
                        WHERE DATE(pendaftaran_t.tgl_pendaftaran) = '".date("Y-m-d")."'
                            AND ruangan_m.ruangan_id = ".$loadDataAntrian['ruangan_id']."
                            AND (pendaftaran_t.panggilantrian = FALSE OR pendaftaran_t.statusperiksa <> '".Params::STATUSPERIKSA_ANTRIAN."')
                        GROUP BY ruangan_m.ruangan_id, ruangan_m.ruangan_nama
                        LIMIT 1";
                $loadData = Yii::app()->db->createCommand($sql)->queryRow();
                if($loadData){
                    $data['sisaantrian'] = $loadData['jumlah'];
                }
            }
        }
        $encode = CJSON::encode($data);
        echo "jsonCallback(".$encode.")";
        Yii::app()->end();
    }
    
    /**
     * Set get jumlah antrian ke farmasi apotek (pengambilan obat) untuk dashboard pasien
     * MA-156
     * @params $_GET['pasien_id']
     * @return
     * $data['antrianpasien']=array();
     * $data['antriandipanggil']=array();
     * $data['totalantrian'] = array(array());
     * $data['sisaantrian'] = array(array());
     */
    public function actionGetAntrianKeFarmasi(){
        header("content-type:application/json");
        $data = array();
        $data['antrianpasien']=array();
        $data['antriandipanggil']=array();
        $data['totalantrian']=0;
        $data['sisaantrian']=0;
        if(isset($_GET['pasien_id'])){
            $pasien_id = $_GET['pasien_id'];
            $sql = "SELECT antrianfarmasi_t.antrianfarmasi_id, antrianfarmasi_t.tglambilantrian, antrianfarmasi_t.noantrian,
                    racikan_m.racikan_id, racikan_m.racikan_nama, racikan_m.racikan_singkatan,
                    penjualanresep_t.noresep, pasien_m.namadepan, pasien_m.nama_pasien
                    FROM antrianfarmasi_t
                    JOIN racikan_m ON racikan_m.racikan_id = antrianfarmasi_t.racikan_id
                    LEFT JOIN penjualanresep_t ON penjualanresep_t.antrianfarmasi_id = antrianfarmasi_t.antrianfarmasi_id
                    LEFT JOIN pasien_m ON pasien_m.pasien_id = penjualanresep_t.pasien_id
                    WHERE DATE(antrianfarmasi_t.tglambilantrian) = '".date("Y-m-d")."'
                        AND penjualanresep_t.pasien_id = ".$pasien_id."
                    ORDER BY antrianfarmasi_t.noantrian DESC
                    LIMIT 1
                    ";
            $loadData = Yii::app()->db->createCommand($sql)->queryRow();
            if(isset($loadData['antrianfarmasi_id'])){
                $data['antrianpasien'] = $loadData;
            }
            //TETAP TAMPILKAN ANTRIAN FARMASI MESKI BELUM MENGANTRI
            $sql = "SELECT antrianfarmasi_t.antrianfarmasi_id, antrianfarmasi_t.tglambilantrian, antrianfarmasi_t.noantrian,
                    racikan_m.racikan_id, racikan_m.racikan_nama, racikan_m.racikan_singkatan,
                    penjualanresep_t.noresep, pasien_m.namadepan, pasien_m.nama_pasien
                    FROM antrianfarmasi_t
                    JOIN racikan_m ON racikan_m.racikan_id = antrianfarmasi_t.racikan_id
                    LEFT JOIN penjualanresep_t ON penjualanresep_t.antrianfarmasi_id = antrianfarmasi_t.antrianfarmasi_id
                    LEFT JOIN pasien_m ON pasien_m.pasien_id = penjualanresep_t.pasien_id
                    WHERE antrianfarmasi_t.panggilantrian = TRUE
                        AND DATE(antrianfarmasi_t.tglambilantrian) = '".date("Y-m-d")."'
                        ".(isset($loadData['racikan_id']) ? " AND racikan_m.racikan_id = ".$loadData['racikan_id'] : "")."
                    ORDER BY antrianfarmasi_t.noantrian DESC
                    LIMIT 1";
            $loadData = Yii::app()->db->createCommand($sql)->queryRow();
            if($loadData){
                $data['antriandipanggil'] = $loadData;
            }

            $sql = "SELECT racikan_m.racikan_id, racikan_m.racikan_nama, racikan_m.racikan_singkatan,
                    COUNT(antrianfarmasi_t.antrianfarmasi_id) AS jumlah
                    FROM antrianfarmasi_t
                    JOIN racikan_m ON racikan_m.racikan_id = antrianfarmasi_t.racikan_id
                    LEFT JOIN penjualanresep_t ON penjualanresep_t.antrianfarmasi_id = antrianfarmasi_t.antrianfarmasi_id
                    LEFT JOIN pasien_m ON pasien_m.pasien_id = penjualanresep_t.pasien_id
                    WHERE DATE(antrianfarmasi_t.tglambilantrian) = '".date("Y-m-d")."'
                    GROUP BY racikan_m.racikan_id, racikan_m.racikan_nama, racikan_m.racikan_singkatan";
            $loadDatas = Yii::app()->db->createCommand($sql)->queryAll();
            if($loadDatas){
                $data['totalantrian'] = $loadDatas;
            }
            $sql = "SELECT racikan_m.racikan_id, racikan_m.racikan_nama, racikan_m.racikan_singkatan,
                    COUNT(antrianfarmasi_t.antrianfarmasi_id) AS jumlah
                    FROM antrianfarmasi_t
                    JOIN racikan_m ON racikan_m.racikan_id = antrianfarmasi_t.racikan_id
                    LEFT JOIN penjualanresep_t ON penjualanresep_t.antrianfarmasi_id = antrianfarmasi_t.antrianfarmasi_id
                    LEFT JOIN pasien_m ON pasien_m.pasien_id = penjualanresep_t.pasien_id
                    WHERE DATE(antrianfarmasi_t.tglambilantrian) = '".date("Y-m-d")."'
                        AND antrianfarmasi_t.panggilantrian = FALSE
                    GROUP BY racikan_m.racikan_id, racikan_m.racikan_nama, racikan_m.racikan_singkatan";
            $loadDatas = Yii::app()->db->createCommand($sql)->queryAll();
            if($loadDatas){
                $data['sisaantrian'] = $loadDatas;
            }
        }
        $encode = CJSON::encode($data);
        echo "jsonCallback(".$encode.")";
        Yii::app()->end();
    }
    
    /**
     * Set get jumlah antrian ke penunjang (pasien luar rs) untuk dashboard pasien
     * MA-156
     * @params $_GET['pasien_id']
     * @return
     * $data['antrianpasien']=array();
     * $data['antriandipanggil']=array();
     * $data['totalantrian'] = 0;
     * $data['sisaantrian'] = 0;
     */
    public function actionGetAntrianKePenunjang(){
        header("content-type:application/json");
        $data = array();
        $data['antrianpasien']=array();
        $data['antriandipanggil']=array();
        $data['totalantrian']=0;
        $data['sisaantrian']=0;
        if(isset($_GET['pasien_id'])){
            $pasien_id = $_GET['pasien_id'];
            $sql = "SELECT pendaftaran_t.pendaftaran_id, pendaftaran_t.tgl_pendaftaran, ruangan_m.ruangan_id, ruangan_m.ruangan_nama, ruangan_m.ruangan_singkatan, pendaftaran_t.no_urutantri, pendaftaran_t.statusperiksa
                    FROM pendaftaran_t
                    JOIN ruangan_m ON ruangan_m.ruangan_id = pendaftaran_t.ruangan_id
                    WHERE pendaftaran_t.pasien_id = ".$pasien_id."
                    AND DATE(pendaftaran_t.tgl_pendaftaran) = '".date('Y-m-d')."'
                    ORDER BY pendaftaran_t.tgl_pendaftaran DESC
                    LIMIT 1
                    ";
            $loadData = Yii::app()->db->createCommand($sql)->queryRow();
            if(isset($loadData['ruangan_id'])){
                $data['antrianpasien'] = $loadData;
                 
                $sql = "SELECT pendaftaran_t.pendaftaran_id, pendaftaran_t.tgl_pendaftaran, ruangan_m.ruangan_id, ruangan_m.ruangan_nama, ruangan_m.ruangan_singkatan, pendaftaran_t.no_urutantri, pendaftaran_t.statusperiksa
                        FROM pendaftaran_t
                        JOIN ruangan_m ON ruangan_m.ruangan_id = pendaftaran_t.ruangan_id
                        WHERE DATE(pendaftaran_t.tgl_pendaftaran) = '".date("Y-m-d")."'
                            AND ruangan_m.ruangan_id = ".$loadData['ruangan_id']."
                        ORDER BY pendaftaran_t.no_urutantri DESC
                        LIMIT 1";
                $loadData = Yii::app()->db->createCommand($sql)->queryRow();
                if($loadData){
                    $data['antriandipanggil'] = $loadData;
                }
                
                $sql = "SELECT ruangan_m.ruangan_id, ruangan_m.ruangan_nama, COUNT(pendaftaran_t.pendaftaran_id) AS jumlah
                        FROM pendaftaran_t
                        JOIN ruangan_m ON ruangan_m.ruangan_id = pendaftaran_t.ruangan_id
                        WHERE DATE(pendaftaran_t.tgl_pendaftaran) = '".date("Y-m-d")."'
                            AND ruangan_m.ruangan_id = ".$loadData['ruangan_id']."
                        GROUP BY ruangan_m.ruangan_id, ruangan_m.ruangan_nama
                        LIMIT 1";
                $loadData = Yii::app()->db->createCommand($sql)->queryRow();
                if($loadData){
                    $data['totalantrian'] = $loadData['jumlah'];
                }
                $sql = "SELECT ruangan_m.ruangan_id, ruangan_m.ruangan_nama, COUNT(pendaftaran_t.pendaftaran_id) AS jumlah
                        FROM pendaftaran_t
                        JOIN ruangan_m ON ruangan_m.ruangan_id = pendaftaran_t.ruangan_id
                        WHERE DATE(pendaftaran_t.tgl_pendaftaran) = '".date("Y-m-d")."'
                            AND ruangan_m.ruangan_id = ".$loadData['ruangan_id']."
                            AND (pendaftaran_t.panggilantrian = TRUE OR pendaftaran_t.statusperiksa = '".Params::STATUSPERIKSA_ANTRIAN."')
                        GROUP BY ruangan_m.ruangan_id, ruangan_m.ruangan_nama
                        LIMIT 1";
                $loadData = Yii::app()->db->createCommand($sql)->queryRow();
                if($loadData){
                    $data['sisaantrian'] = $loadData['jumlah'];
                }
            }
        }
        $encode = CJSON::encode($data);
        echo "jsonCallback(".$encode.")";
        Yii::app()->end();
    }
    
    /**
     * Set get jumlah antrian ke penunjang (pasien luar rs) untuk dashboard pasien
     * MA-156
     * @params $_GET['pasien_id']
     * @return
     * $data['antrianpasien']=array();
     * $data['antriandipanggil']=array();
     * $data['totalantrian'] = array(array());
     * $data['sisaantrian'] = array(array());
     */
    public function actionGetAntrianKeKasir(){
        header("content-type:application/json");
        $data = array();
        $data['totalantrian']=array();
        $data['sisaantrian']=array(); 
        if(isset($_GET['pasien_id'])){
             
            $sql = "SELECT loket_m.loket_id, loket_m.loket_nama, COUNT(antrian_t.loket_id) AS jumlah
                    FROM antrian_t
                    LEFT JOIN loket_m ON loket_m.loket_id = antrian_t.loket_id
                    JOIN ruangan_m ON ruangan_m.ruangan_id = antrian_t.ruangan_id
                    JOIN carabayar_m ON carabayar_m.carabayar_id = antrian_t.carabayar_id
                    WHERE DATE(antrian_t.tglantrian) = '".date("Y-m-d")."'
                        AND ruangan_m.ruangan_id = ".Params::DEFAULT_RUANGAN_KIOSK_KASIR."
                    GROUP BY antrian_t.loket_id, loket_m.loket_id, loket_m.loket_nama";
            $loadDatas = Yii::app()->db->createCommand($sql)->queryAll();
            if($loadDatas){
                $data['totalantrian'] = $loadDatas;
            }
            
            $sql = "SELECT loket_m.loket_id, loket_m.loket_nama, COUNT(antrian_t.loket_id) AS jumlah
                    FROM antrian_t
                    LEFT JOIN loket_m ON loket_m.loket_id = antrian_t.loket_id
                    JOIN ruangan_m ON ruangan_m.ruangan_id = antrian_t.ruangan_id
                    JOIN carabayar_m ON carabayar_m.carabayar_id = antrian_t.carabayar_id
                    WHERE DATE(antrian_t.tglantrian) = '".date("Y-m-d")."'
                        AND ruangan_m.ruangan_id = ".Params::DEFAULT_RUANGAN_KIOSK_KASIR."
                        AND (antrian_t.panggil_flaq = FALSE)
                    GROUP BY antrian_t.loket_id, loket_m.loket_id, loket_m.loket_nama";
            $loadDatas = Yii::app()->db->createCommand($sql)->queryAll();
            if($loadDatas){
                $data['sisaantrian'] = $loadDatas;
            }
        }
        $encode = CJSON::encode($data);
        echo "jsonCallback(".$encode.")";
        Yii::app()->end();
    }
}