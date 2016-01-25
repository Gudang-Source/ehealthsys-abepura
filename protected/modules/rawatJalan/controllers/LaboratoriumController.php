<?php
//Yii::import('sistemAdministrator.controllers.NotifikasiRController'); RND-6398
class LaboratoriumController extends MyAuthController
{
    public $layout='//layouts/iframe';
    public $defaultAction = 'index';
    protected $statusSaveKirimkeUnitLain = false;
    protected $statusSavePermintaanPenunjang = false;
    protected $tindakanpelayanantersimpan = true;
    protected $komponentindakantersimpan = true;
    protected $path_view = 'rawatJalan.views.laboratorium.';

    /**
     * method untuk mengirimkan pasien ke unit lain
     * digunakan di :
     * 1. rawatJalan/laboratorium/index
     * @param int $pendaftaran_id pendaftaran_id
     */
    public function actionIndex($pendaftaran_id,$idPasienKirimKeUnitLain=null)
	{
            $params = array();
            $modPendaftaran = RJPendaftaranT::model()->with('jeniskasuspenyakit')->findByPk($pendaftaran_id);
            $modPasien = RJPasienM::model()->findByPk($modPendaftaran->pasien_id);
            $modKirimKeUnitLain = new RJPasienKirimKeUnitLainT;
            $modKirimKeUnitLain->tgl_kirimpasien = date('Y-m-d H:i:s');
            $modKirimKeUnitLain->pegawai_id = $modPendaftaran->pegawai_id;
			$modKirimKeUnitLain->kelaspelayanan_id = Params::KELASPELAYANAN_ID_TANPA_KELAS; 
			if ($modPendaftaran->carabayar_id == Params::CARABAYAR_ID_MEMBAYAR && $modPendaftaran->penjamin_id = Params::PENJAMIN_ID_UMUM) $modKirimKeUnitLain->isbayarkekasirpenunjang = Yii::app()->user->getState('isbayarkekasirpenunjang');
            $modJenisPeriksaLab = RJJenisPemeriksaanLabM::model()->findAllByAttributes(array('jenispemeriksaanlab_aktif'=>true),array('order'=>'jenispemeriksaanlab_urutan')); 
            $modPeriksaLab = RJPemeriksaanLabM::model()->findAllByAttributes(array('pemeriksaanlab_aktif'=>true),array('order'=>'pemeriksaanlab_id, pemeriksaanlab_urutan'));
            
            $modJenisTarif = JenistarifpenjaminM::model()->find('penjamin_id ='.$modPendaftaran->penjamin_id);

            $nama_modul = Yii::app()->controller->module->id;
            $nama_controller = Yii::app()->controller->id;
            $nama_action = Yii::app()->controller->action->id;
            $modul_id = ModulK::model()->findByAttributes(array('url_modul'=>$nama_modul))->modul_id;
            $criteria = new CDbCriteria;
            $criteria->compare('modul_id',$modul_id);
            $criteria->compare('LOWER(modcontroller)',strtolower($nama_controller),true);
            $criteria->compare('LOWER(modaction)',strtolower($nama_action),true);
            if(isset($_POST['tujuansms'])){
                $criteria->addInCondition('tujuansms',$_POST['tujuansms']);
            }
            $modSmsgateway = SmsgatewayM::model()->findAll($criteria);

            if(isset($idPasienKirimKeUnitLain)){
                $modKirimKeUnitLain = RJPasienKirimKeUnitLainT::model()->findByPk($idPasienKirimKeUnitLain);
                $modPasien = $modKirimKeUnitLain->pasien;
            }

            
            if(isset($_POST['RJPasienKirimKeUnitLainT'])) {
                $transaction = Yii::app()->db->beginTransaction();
                try {
                    if(isset($_POST['permintaanPenunjang'])){
                        $modKirimKeUnitLain = $this->savePasienKirimKeUnitLain($modPendaftaran, Params::RUANGAN_ID_LAB_KLINIK);
                    }
                    if(isset($_POST['permintaanPenunjangAnatomi'])){
                        $modKirimKeUnitLainAnatomi = $this->savePasienKirimKeUnitLain($modPendaftaran, Params::RUANGAN_ID_LAB_ANATOMI);                       
                    }

                    if(isset($_POST['permintaanPenunjang']) || isset($_POST['permintaanPenunjangAnatomi'])){
                        
                        if(isset($_POST['permintaanPenunjang'])){
                            $this->savePermintaanPenunjang($_POST['permintaanPenunjang'],$modKirimKeUnitLain);
                        }
                        if(isset($_POST['permintaanPenunjangAnatomi'])){
                            $this->savePermintaanPenunjang($_POST['permintaanPenunjangAnatomi'],$modKirimKeUnitLainAnatomi);
                        }

                        $updateStatusPeriksa=PendaftaranT::model()->updateByPk($pendaftaran_id,array('statusperiksa'=>Params::STATUSPERIKSA_SEDANG_PERIKSA));
                        /* ================================================ */
                        /* Proses update status periksa KonsulPoli EHS-179  */
                        /* ================================================ */
						$ruangan_id = isset($_GET['ruangan_id']) ? $_GET['ruangan_id'] : Yii::app()->user->getState('ruangan_id');
                        $konsulPoli = KonsulpoliT::model()->findByAttributes(array('pendaftaran_id'=>$pendaftaran_id, 'ruangan_id'=>$ruangan_id));
                        if(count($konsulPoli)>0){
                            $updateStatusPeriksa=KonsulpoliT::model()->updateByPk($konsulPoli->konsulpoli_id,array('statusperiksa'=>Params::STATUSPERIKSA_SEDANG_PERIKSA));
                        }
                        /* ================================================ */
                        
                        PendaftaranT::model()->updateByPk($pendaftaran_id,
                            array(
                                'pembayaranpelayanan_id'=>null
                            )
                        );
//                        $ruangan = RuanganM::model()->findByPk(Yii::app()->user->getState('ruangan_id'));
//                        $params['tglnotifikasi'] = date( 'Y-m-d H:i:s');
//                        $params['create_time'] = date( 'Y-m-d H:i:s');
//                        $params['create_loginpemakai_id'] = Yii::app()->user->id;
//                        $params['instalasi_id'] = $ruangan->instalasi_id;
//                        $params['modul_id'] = 8;
//                        $params['isinotifikasi'] = $modPasien->no_rekam_medik . '-' . $modPendaftaran->no_pendaftaran . '-' . $modPasien->nama_pasien . '-' . $ruangan->ruangan_nama;
//                        $params['create_ruangan'] = $ruangan->ruangan_id;
//                        $params['judulnotifikasi'] = 'Rujukan Rawat Jalan';                        
//                        $nofitikasi = NotifikasiRController::insertNotifikasi($params);
			//sudah di ganti menggunakan node js seperti di Farmasi Apotek - transaksi penjualan resep RS.
                    } else {
                        $this->statusSavePermintaanPenunjang = true;
                    }
                    
                    if($this->statusSaveKirimkeUnitLain && $this->statusSavePermintaanPenunjang && $this->tindakanpelayanantersimpan){
                        // SMS GATEWAY
                        $modPegawai = $modPendaftaran->pegawai;
                        $sms = new Sms();
                        $smspasien = 1;
                        foreach ($modSmsgateway as $i => $smsgateway) {
                            $isiPesan = $smsgateway->templatesms;

                            $attributes = $modPasien->getAttributes();
                            foreach($attributes as $attributes => $value){
                                $isiPesan = str_replace("{{".$attributes."}}",$value,$isiPesan);
                            }
                            $attributes = $modPendaftaran->getAttributes();
                            foreach($attributes as $attributes => $value){
                                $isiPesan = str_replace("{{".$attributes."}}",$value,$isiPesan);
                            }
                            $attributes = $modPegawai->getAttributes();
                            foreach($attributes as $attributes => $value){
                                $isiPesan = str_replace("{{".$attributes."}}",$value,$isiPesan);
                            }
                            $attributes = $modKirimKeUnitLain->getAttributes();
                            foreach($attributes as $attributes => $value){
                                $isiPesan = str_replace("{{".$attributes."}}",$value,$isiPesan);
                            }
                            $isiPesan = str_replace("{{hari}}",MyFormatter::getDayName($modKirimKeUnitLain->tgl_kirimpasien),$isiPesan);
    
                            if($smsgateway->tujuansms == Params::TUJUANSMS_PASIEN && $smsgateway->statussms){
                                if(!empty($modPasien->no_mobile_pasien)){
                                    $sms->kirim($modPasien->no_mobile_pasien,$isiPesan);
                                }else{
                                    $smspasien = 0;
                                }
                            }
                        }
                        // END SMS GATEWAY
                        $transaction->commit();
                        Yii::app()->user->setFlash('success',"Data Berhasil disimpan");
                        $this->redirect(array('index','pendaftaran_id'=>$pendaftaran_id, 'idPasienKirimKeUnitLain'=>$modKirimKeUnitLain->pasienkirimkeunitlain_id,'sukses'=>1,'smspasien'=>$smspasien));
                    } else {
                        $transaction->rollback();
                        Yii::app()->user->setFlash('error',"Data gagal disimpan! ");
                    }
                } catch (Exception $exc) {
                    $transaction->rollback();
                    Yii::app()->user->setFlash('error',"Data Gagal disimpan. ".MyExceptionMessage::getMessage($exc,true));
                }
            }
            
            $modRiwayatKirimKeUnitLain = RJPasienKirimKeUnitLainT::model()->findAllByAttributes(array('pendaftaran_id'=>$pendaftaran_id),
                'pasienmasukpenunjang_id IS NULL AND ruangan_id IN('.Params::RUANGAN_ID_LAB_KLINIK.','.Params::RUANGAN_ID_LAB_ANATOMI.')');
		
            $this->render($this->path_view.'index',array('modPendaftaran'=>$modPendaftaran,
                                        'modPasien'=>$modPasien,
                                        'modKirimKeUnitLain'=>$modKirimKeUnitLain,
                                        'modJenisPeriksaLab'=>$modJenisPeriksaLab,
                                        'modPeriksaLab'=>$modPeriksaLab,
                                        'modRiwayatKirimKeUnitLain'=>$modRiwayatKirimKeUnitLain,
                                        'modJenisTarif'=>$modJenisTarif
                                        ));
	}

        /**
         * method untuk menyimpan data pasien ke unit lain RJPasienKirimkeUnitLainT
         * digunakan di :
         * 1. rawatJalan/laboratorium/index
         * @param object $modPendaftaran model PendaftaranT
         * @return \RJPasienKirimKeUnitLainT 
         */
        protected function savePasienKirimKeUnitLain($modPendaftaran, $ruangan_lab)
        {
            $modKirimKeUnitLain = new RJPasienKirimKeUnitLainT;
            $modKirimKeUnitLain->attributes = $_POST['RJPasienKirimKeUnitLainT'];
            $modKirimKeUnitLain->pasien_id = $modPendaftaran->pasien_id;
            $modKirimKeUnitLain->pendaftaran_id = $modPendaftaran->pendaftaran_id;
            $modKirimKeUnitLain->instalasi_id = Params::INSTALASI_ID_LAB;
            $modKirimKeUnitLain->ruangan_id = $ruangan_lab;
			$modKirimKeUnitLain->tgl_kirimpasien = MyFormatter::formatDateTimeForDb($modKirimKeUnitLain->tgl_kirimpasien);
			$modKirimKeUnitLain->create_loginpemakai_id = Yii::app()->user->id;
			$modKirimKeUnitLain->update_loginpemakai_id = Yii::app()->user->id;
			$modKirimKeUnitLain->create_ruangan = isset($_GET['ruangan_id']) ? $_GET['ruangan_id'] : Yii::app()->user->getState('ruangan_id');
			$modKirimKeUnitLain->create_time = date( 'Y-m-d H:i:s');
			$modKirimKeUnitLain->update_time = date( 'Y-m-d H:i:s');
			$modKirimKeUnitLain->isbayarkekasirpenunjang = isset($_POST['RJPasienKirimKeUnitLainT']['isbayarkekasirpenunjang']) ? $_POST['RJPasienKirimKeUnitLainT']['isbayarkekasirpenunjang'] : 0;
            $modKirimKeUnitLain->nourut = MyGenerator::noUrutPasienKirimKeUnitLain($modKirimKeUnitLain->ruangan_id);
		
            if($modKirimKeUnitLain->validate()){
                if ($modKirimKeUnitLain->save()){
                    $this->statusSaveKirimkeUnitLain = true;
				}
            }
            
            return $modKirimKeUnitLain;
        }
        
        /**
         * method untuk menyimpan dan validasi permintaan penunjang
         * digunakan di :
         * 1. rawatJalan/laboratorium/index
         * @param array $permintaan berupa post request berisi data permintaan penunjang
         * @param object $modKirimKeUnitLain model PasienkirimkeunitlainT
         */
        protected function savePermintaanPenunjang($permintaan,$modKirimKeUnitLain)
        {
            foreach ($permintaan['inputpemeriksaanlab'] as $i => $value) {
                $modPermintaan = new RJPermintaanPenunjangT;
				$modPermintaan->daftartindakan_id = isset($permintaan['idDaftarTindakan'][$i]) ? $permintaan['idDaftarTindakan'][$i] : null;
                $modPermintaan->pemeriksaanlab_id = $permintaan['inputpemeriksaanlab'][$i];
                $modPermintaan->pemeriksaanrad_id = '';
                $modPermintaan->pasienkirimkeunitlain_id = $modKirimKeUnitLain->pasienkirimkeunitlain_id;
                $modPermintaan->noperminatanpenujang = MyGenerator::noPermintaanPenunjang('PL');
                $modPermintaan->qtypermintaan = $permintaan['inputqty'][$i];
                $modPermintaan->tarif_pelayananan = $permintaan['inputtarifpemeriksaanlab'][$i];
                $modPermintaan->tglpermintaankepenunjang = MyFormatter::formatDateTimeForDb($modKirimKeUnitLain->tgl_kirimpasien);
                if($modPermintaan->validate()){
                    if ($modPermintaan->save()){
                        $this->statusSavePermintaanPenunjang = true;
						if($modKirimKeUnitLain->isbayarkekasirpenunjang){ 
							$modPendaftaran = $modKirimKeUnitLain->pendaftaran;
							$modTindakan = $this->simpanTindakanPelayanan($modPendaftaran,$modKirimKeUnitLain,$modPermintaan); //AGAR BISA DI BAYAR DI KASIR
							$modPermintaan->tindakanpelayanan_id = $modTindakan->tindakanpelayanan_id;
							$modPermintaan->update();
						}
					}
                }
            }
        }
		
		/**
         * proses simpan TindakanPelayananT dan TindakanKomponenT
		 * khusus untuk permintaan penunjang
         */
        public function simpanTindakanPelayanan($modPendaftaran, $modKirimKeUnitLain, $modPermintaan){
            $modTindakan = new RJTindakanPelayananT;
            
            $modTindakan->attributes = $modPendaftaran->attributes;
            $modTindakan->ruangan_id = $modKirimKeUnitLain->ruangan_id;
            $modTindakan->instalasi_id = $modTindakan->ruangan->instalasi_id;
            $modTindakan->pendaftaran_id = $modPendaftaran->pendaftaran_id;
            $modTindakan->daftartindakan_id = $modPermintaan->daftartindakan_id;
            $modTindakan->tarif_satuan = $modPermintaan->tarif_pelayananan;
            $modTindakan->qty_tindakan = $modPermintaan->qtypermintaan;
            $modTindakan->satuantindakan = Params::SATUAN_TINDAKAN_LABORATORIUM;
            $modTindakan->create_time = date("Y-m-d H:i:s");
            $modTindakan->create_loginpemakai_id = Yii::app()->user->id;
			$modTindakan->create_ruangan = Yii::app()->user->getState('ruangan_id');
            $modTindakan->shift_id =Yii::app()->user->getState('shift_id');
            $modTindakan->dokterpemeriksa1_id=$modKirimKeUnitLain->pegawai_id;
			$modTindakan->perawat_id = (!empty($modKirimKeUnitLain->perawat_id) ? $modKirimKeUnitLain->perawat_id : null);
            $modTindakan->tgl_tindakan=$modPermintaan->tglpermintaankepenunjang;
			$modTindakan->instalasi_id = $modTindakan->ruangan->instalasi_id;
			$modTindakan->tarif_satuan = $modTindakan->getTarifSatuan(); //RND-7248
            $modTindakan->tarif_tindakan=$modTindakan->tarif_satuan * $modTindakan->qty_tindakan;
            $modTindakan->cyto_tindakan=0;
            $modTindakan->tarifcyto_tindakan=0;
            $modTindakan->discount_tindakan=0;
            $modTindakan->subsidiasuransi_tindakan=0;
            $modTindakan->subsidipemerintah_tindakan=0;
            $modTindakan->subsisidirumahsakit_tindakan=0;
            $modTindakan->iurbiaya_tindakan=0;
            $modTindakan->tarif_rsakomodasi=0;
            $modTindakan->tarif_medis=0;
            $modTindakan->tarif_paramedis=0;
            $modTindakan->tarif_bhp=0;
            
            if($modTindakan->validate()){
                if($modTindakan->save()){
					$this->komponentindakantersimpan &= $modTindakan->saveTindakanKomponen();
				}
            }else{
                $this->tindakanpelayanantersimpan &= false;
            }
                
            return $modTindakan;
        }
        
        public function actionAjaxBatalKirim()
        {
            if(Yii::app()->request->isAjaxRequest) {
				$pasienkirimkeunitlain_id = $_POST['pasienkirimkeunitlain_id'];
				$pendaftaran_id = $_POST['pendaftaran_id'];
				$data['pesan'] = "Pasien kirim ke laboratorium gagal dibatalkan!";
				$data['sukses'] = 0;
				
				$transaction = Yii::app()->db->beginTransaction();
				try {
					$loadPermintaans = PermintaankepenunjangT::model()->findAllByAttributes(array('pasienkirimkeunitlain_id'=>$pasienkirimkeunitlain_id));
					if(count($loadPermintaans) > 0){
						foreach($loadPermintaans AS $i => $permintaan){
							$hapuspermintaan = true;
							if(!empty($permintaan->tindakanpelayanan_id)){
								if(!empty($permintaan->tindakanpelayanan->tindakansudahbayar_id)){
									$hapuspermintaan = false;
								}else{
									$permintaan->tindakanpelayanan->delete();
								}
							}
							if($hapuspermintaan){
								if($permintaan->delete()){
									$data['pesan'] = "Pasien kirim ke laboratorium berhasil dibatalkan!";
									$data['sukses'] = 1;
								}
							}else{
								$data['pesan'] = "Pasien kirim ke laboratorium tidak bisa dibatalkan karena tindakan sudah dibayarkan!";
								$data['sukses'] = 0;
							}
						}
					}
					PasienkirimkeunitlainT::model()->deleteByPk($pasienkirimkeunitlain_id);
					$transaction->commit();
				}catch (Exception $exc) {
					$transaction->rollback();
					$data['pesan'] = "Pasien kirim ke laboratorium gagal dibatalkan karena tindakan sudah dibayarkan!";
					$data['sukses'] = 0;
				}
				$modRiwayatKirimKeUnitLain = RJPasienKirimKeUnitLainT::model()->findAllByAttributes(array('pendaftaran_id'=>$pendaftaran_id),
						'pasienmasukpenunjang_id IS NULL AND ruangan_id IN('.Params::RUANGAN_ID_LAB_KLINIK.','.Params::RUANGAN_ID_LAB_ANATOMI.')');
				$data['result'] = $this->renderPartial($this->path_view.'_listKirimKeUnitLain', array('modRiwayatKirimKeUnitLain'=>$modRiwayatKirimKeUnitLain), true);

				echo json_encode($data);
				 Yii::app()->end();
            }
        }
        
        public function actionPrint()
        {
             $pendaftaran_id = $_GET['id'];
             $idPasienKirimKeUnitLain = $_GET['idPasienKirimKeUnitLain'];
             $modPendaftaran= PendaftaranT::model()->findByPk($pendaftaran_id);
             $modRiwayatKirimKeUnitLain = RJPasienKirimKeUnitLainT::model()->findAllByAttributes(array('pendaftaran_id'=>$pendaftaran_id,
                'pasienkirimkeunitlain_id'=>$idPasienKirimKeUnitLain),
                'pasienmasukpenunjang_id IS NULL');

            $judulLaporan='Permintaan Pemeriksaan Laboratorium';
            $caraPrint=$_REQUEST['caraPrint'];
            if($caraPrint=='PRINT') {
                $this->layout='//layouts/printWindows';
                $this->render($this->path_view.'Print',array('modPendaftaran'=>$modPendaftaran,'modRiwayatKirimKeUnitLain'=>$modRiwayatKirimKeUnitLain,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint));
            }
            else if($caraPrint=='EXCEL') {
                $this->layout='//layouts/printExcel';
                $this->render($this->path_view.'Print',array('modPendaftaran'=>$modPendaftaran,'modRiwayatKirimKeUnitLain'=>$modRiwayatKirimKeUnitLain,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint));
            }
            else if($_REQUEST['caraPrint']=='PDF') {
                $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
                $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
                $mpdf = new MyPDF('',$ukuranKertasPDF); 
                $mpdf->useOddEven = 2;  
                $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
                $mpdf->WriteHTML($stylesheet,1);  
                $mpdf->AddPage($posisi,'','','','',15,15,15,15,15,15);
                $mpdf->WriteHTML($this->renderPartial($this->path_view.'Print',array('modPendaftaran'=>$modPendaftaran,'modRiwayatKirimKeUnitLain'=>$modRiwayatKirimKeUnitLain,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint),true));
                $mpdf->Output();
            }                       
        }

        public function actionPrintRiwayat()
        {
             $pendaftaran_id = $_GET['id'];
             $modPendaftaran= PendaftaranT::model()->findByPk($pendaftaran_id);
             $modKirimKeUnitLain = RJPasienKirimKeUnitLainT::model()->findAll('pendaftaran_id='.$pendaftaran_id);
             $modRiwayatKirimKeUnitLain = RJPasienKirimKeUnitLainT::model()->findAllByAttributes(array('pendaftaran_id'=>$pendaftaran_id,'instalasi_id'=>Params::INSTALASI_ID_LAB),
                'pasienmasukpenunjang_id IS NULL');
            
            $judulLaporan='Permintaan Pemeriksaan Laboratorium';
            $caraPrint=$_REQUEST['caraPrint'];
            if($caraPrint=='PRINT') {
                $this->layout='//layouts/printWindows';
                $this->render($this->path_view.'printRiwayat',array('modKirimKeUnitLain'=> $modKirimKeUnitLain,'modPendaftaran'=>$modPendaftaran,'modRiwayatKirimKeUnitLain'=>$modRiwayatKirimKeUnitLain,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint));
            }
            else if($caraPrint=='EXCEL') {
                $this->layout='//layouts/printExcel';
                $this->render($this->path_view.'printRiwayat',array('modKirimKeUnitLain'=> $modKirimKeUnitLain,'modPendaftaran'=>$modPendaftaran,'modRiwayatKirimKeUnitLain'=>$modRiwayatKirimKeUnitLain,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint));
            }
            else if($_REQUEST['caraPrint']=='PDF') {
                $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
                $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
                $mpdf = new MyPDF('',$ukuranKertasPDF); 
                $mpdf->useOddEven = 2;  
                $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
                $mpdf->WriteHTML($stylesheet,1);  
                $mpdf->AddPage($posisi,'','','','',15,15,15,15,15,15);
                $mpdf->WriteHTML($this->renderPartial($this->path_view.'printRiwayat',array('modKirimKeUnitLain'=> $modKirimKeUnitLain,'modPendaftaran'=>$modPendaftaran,'modRiwayatKirimKeUnitLain'=>$modRiwayatKirimKeUnitLain,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint),true));
                $mpdf->Output();
            }                       
        }

        /**
         * ajax untuk load pemeriksaan lab ketika di cekllist
         */
        public function actionLoadFormPemeriksaanLab()
        {
            if (Yii::app()->request->isAjaxRequest)
            {
                $pemeriksaanlab_id = (isset($_POST['pemeriksaanlab_id']) ? $_POST['pemeriksaanlab_id'] : null);
                $kelaspelayanan_id = (isset($_POST['kelaspelayanan_id']) ? $_POST['kelaspelayanan_id'] : null);
                $pendaftaran_id = (isset($_POST['pendaftaran_id']) ? $_POST['pendaftaran_id'] : null);
                $ruangan_id = (isset($_POST['ruangan_id']) ? $_POST['ruangan_id'] : Params::RUANGAN_ID_LAB_KLINIK);
                $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);        
                
                $criteria = new CDbCriteria();
                $criteria->addCondition('pemeriksaanlab_id = '.$pemeriksaanlab_id);
                $criteria->addCondition('kelaspelayanan_id = '.$kelaspelayanan_id);
                $criteria->addCondition('penjamin_id = '.$modPendaftaran->penjamin_id);
                $criteria->addCondition('ruangan_id = '.$ruangan_id);
                $modTarif = TarifpemeriksaanlabruanganV::model()->find($criteria);
                echo CJSON::encode(array(
                    'status'=>'create_form', 
                    'form'=>$this->renderPartial($this->path_view.'_formLoadPemeriksaanLab', array('modTarif'=>$modTarif), true)));
                exit;               
            }
        }

        // Uncomment the following methods and override them if needed
	/*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
}