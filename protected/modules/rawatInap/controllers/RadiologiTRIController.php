<?php
class RadiologiTRIController extends MyAuthController
{
        protected $statusSaveKirimkeUnitLain = false;
        protected $statusSavePermintaanPenunjang = false;
		protected $tindakanpelayanantersimpan = true;
		protected $komponentindakantersimpan = true;
    
	public function actionIndex($pendaftaran_id,$pasienadmisi_id)
	{
            $this->layout='//layouts/iframe';
            $modPasienMasukPenunjang = array();
            $modAdmisi = (!empty($pasienadmisi_id)) ? PasienadmisiT::model()->findByAttributes(array('pendaftaran_id'=>$pendaftaran_id,'pasienadmisi_id'=>$pasienadmisi_id)) : array();
            $modPendaftaran = RIPendaftaranT::model()->with('jeniskasuspenyakit')->findByPk($pendaftaran_id);
            $modPasien = RIPasienM::model()->findByPk($modPendaftaran->pasien_id);
            $modKirimKeUnitLain = new RIPasienKirimKeUnitLainT;
            $modKirimKeUnitLain->tgl_kirimpasien = date('Y-m-d H:i:s');
            $modKirimKeUnitLain->pegawai_id = $modPendaftaran->pegawai_id;
			$modKirimKeUnitLain->kelaspelayanan_id = $modAdmisi->kelaspelayanan_id; //RND-8117
			$modKirimKeUnitLain->isbayarkekasirpenunjang = Yii::app()->user->getState('isbayarkekasirpenunjang');
            $modPeriksaRad = RIPemeriksaanRadM::model()->with('jenispemeriksaanrad')->findAllByAttributes(array('pemeriksaanrad_aktif'=>true),array('order'=>'jenispemeriksaanrad.jenispemeriksaanrad_urutan, pemeriksaanrad_urutan ASC'));
            
            $modJenisTarif = JenistarifpenjaminM::model()->find('penjamin_id ='.$modAdmisi->penjamin_id);

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

            if(isset($_GET['idPasienKirimKeUnitLain'])){
                $modKirimKeUnitLain = RIPasienKirimKeUnitLainT::model()->findByPk($_GET['idPasienKirimKeUnitLain']);
                $modPasien = $modKirimKeUnitLain->pasien;
            }

            if(isset($_POST['RIPasienKirimKeUnitLainT'])) {
                $transaction = Yii::app()->db->beginTransaction();
                try {
                    $modKirimKeUnitLain = $this->savePasienKirimKeUnitLain($modAdmisi);
                    if(isset($_POST['permintaanPenunjang'])){
                        $this->savePermintaanPenunjang($_POST['permintaanPenunjang'],$modKirimKeUnitLain);
                    } else {
                        $this->statusSavePermintaanPenunjang = true;
                    }
                    
                    if($this->statusSaveKirimkeUnitLain && $this->statusSavePermintaanPenunjang){
                        
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
                        $this->redirect(array('index','pendaftaran_id'=>$pendaftaran_id, 'pasienadmisi_id'=>$pasienadmisi_id, 'idPasienKirimKeUnitLain'=>$modKirimKeUnitLain->pasienkirimkeunitlain_id, 'smspasien'=>$smspasien));
                    } else {
                        $transaction->rollback();
                        Yii::app()->user->setFlash('error',"Data tidak valid ");
                    }
                } catch (Exception $exc) {
                    $transaction->rollback();
                    Yii::app()->user->setFlash('error',"Data Gagal disimpan. ".MyExceptionMessage::getMessage($exc,true));
                }
                
            }
		
            $modRiwayatKirimKeUnitLain = RIPasienKirimKeUnitLainT::model()->findAllByAttributes(array('pendaftaran_id'=>$pendaftaran_id,
                                                                                                      'instalasi_id'=>Params::INSTALASI_ID_RAD),
                                                                                                'pasienmasukpenunjang_id IS NULL');
            
			$modBayarUangMuka = RIBayaruangmukaT::model()->findAllByAttributes(array('pendaftaran_id'=>$pendaftaran_id));
			$total = 0;
			foreach ($modBayarUangMuka as $key => $value){
				$total += $modBayarUangMuka[$key]->jumlahuangmuka;
			}
			$modDeposit = (($modBayarUangMuka)?$total : null);
			
			$this->render('index',array('modPendaftaran'=>$modPendaftaran,
                                        'modPasien'=>$modPasien,
                                        'modKirimKeUnitLain'=>$modKirimKeUnitLain,
                                        'modPeriksaRad'=>$modPeriksaRad,
                                        'modRiwayatKirimKeUnitLain'=>$modRiwayatKirimKeUnitLain,
                                        'modAdmisi'=>$modAdmisi,
                                        'modPasienMasukPenunjang'=>$modPasienMasukPenunjang,
                                        'modJenisTarif'=>$modJenisTarif,
                                        'modDeposit'=>$modDeposit,
                                       ));
	}

        protected function savePasienKirimKeUnitLain($modAdmisi)
        {
            $modKirimKeUnitLain = new RIPasienKirimKeUnitLainT;
            $modKirimKeUnitLain->attributes = $_POST['RIPasienKirimKeUnitLainT'];
            $modKirimKeUnitLain->pasien_id = $modAdmisi->pasien_id;
            $modKirimKeUnitLain->pendaftaran_id = $modAdmisi->pendaftaran_id;
            $modKirimKeUnitLain->kelaspelayanan_id = $modAdmisi->kelaspelayanan_id;
            $modKirimKeUnitLain->instalasi_id = Params::INSTALASI_ID_RAD;
            $modKirimKeUnitLain->ruangan_id = Params::RUANGAN_ID_RAD;
            $modKirimKeUnitLain->create_time = date("Y-m-d H:i:s");
            $modKirimKeUnitLain->update_time = date("Y-m-d H:i:s");
            $modKirimKeUnitLain->create_loginpemakai_id = Yii::app()->user->id;
            $modKirimKeUnitLain->update_loginpemakai_id = Yii::app()->user->id;
            $modKirimKeUnitLain->create_ruangan = Yii::app()->user->getState('ruangan_id');
			$modKirimKeUnitLain->tgl_kirimpasien = MyFormatter::formatDateTimeForDb($modKirimKeUnitLain->tgl_kirimpasien);
			$modKirimKeUnitLain->isbayarkekasirpenunjang = isset($_POST['RIPasienKirimKeUnitLainT']['isbayarkekasirpenunjang']) ? $_POST['RIPasienKirimKeUnitLainT']['isbayarkekasirpenunjang'] : 0;
            $modKirimKeUnitLain->nourut = MyGenerator::noUrutPasienKirimKeUnitLain($modKirimKeUnitLain->ruangan_id);
            if($modKirimKeUnitLain->validate()){
                $modKirimKeUnitLain->save();
                $this->statusSaveKirimkeUnitLain = true;
            }
            
            return $modKirimKeUnitLain;
        }
        
        protected function savePermintaanPenunjang($permintaan,$modKirimKeUnitLain)
        {
            foreach ($permintaan['inputpemeriksaanrad'] as $i => $value) {
                $modPermintaan = new RIPermintaanPenunjangT;
                $modPermintaan->daftartindakan_id = $permintaan['idDaftarTindakan'][$i];
                $modPermintaan->pemeriksaanlab_id = '';
                $modPermintaan->pemeriksaanrad_id = $permintaan['inputpemeriksaanrad'][$i];
                $modPermintaan->pasienkirimkeunitlain_id = $modKirimKeUnitLain->pasienkirimkeunitlain_id;
                $modPermintaan->noperminatanpenujang = MyGenerator::noPermintaanPenunjang('PR');
                $modPermintaan->qtypermintaan = $permintaan['inputqty'][$i];
                $modPermintaan->tarif_pelayananan = $permintaan['inputtarifpemeriksaanrad'][$i];
                $modPermintaan->tglpermintaankepenunjang = $modKirimKeUnitLain->tgl_kirimpasien; //date('Y-m-d H:i:s');
                if($modPermintaan->validate()){
                    if($modPermintaan->save()){
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
            $modTindakan = new RITindakanPelayananT;
            
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
        
		
		//copy dari RJ - LaboratoriumController penyesuaian di $modRiwayatKirimKeUnitLain
        public function actionAjaxBatalKirim()
        {
            if(Yii::app()->request->isAjaxRequest) {
				$pasienkirimkeunitlain_id = $_POST['pasienkirimkeunitlain_id'];
				$pendaftaran_id = $_POST['pendaftaran_id'];
				$data['pesan'] = "Pasien kirim ke radiologi gagal dibatalkan!";
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
									$data['pesan'] = "Pasien kirim ke radiologi berhasil dibatalkan!";
									$data['sukses'] = 1;
								}
							}else{
								$data['pesan'] = "Pasien kirim ke radiologi tidak bisa dibatalkan karena tindakan sudah dibayarkan!";
								$data['sukses'] = 0;
							}
						}
					}
					PasienkirimkeunitlainT::model()->deleteByPk($pasienkirimkeunitlain_id);
					$transaction->commit();
				}catch (Exception $exc) {
					$transaction->rollback();
					$data['pesan'] = "Pasien kirim ke radiologi gagal dibatalkan karena tindakan sudah dibayarkan!";
					$data['sukses'] = 0;
				}
				$modRiwayatKirimKeUnitLain = RIPasienKirimKeUnitLainT::model()->findAllByAttributes(array('pendaftaran_id'=>$pendaftaran_id,
                                                                                                      'instalasi_id'=>Params::INSTALASI_ID_RAD),
                                                                                                'pasienmasukpenunjang_id IS NULL');
            
				$data['result'] = $this->renderPartial('_listKirimKeUnitLain', array('modRiwayatKirimKeUnitLain'=>$modRiwayatKirimKeUnitLain), true);
			
				echo json_encode($data);
				 Yii::app()->end();
            }
        }
		
		/**
         * UNTUK LOAD DAFTAR PEMERIKSAAN RADIOLOGI
         */
        public function actionLoadFormPemeriksaanRad()
        {
            if (Yii::app()->request->isAjaxRequest)
            {
                $pemeriksaanrad_id = (isset($_POST['pemeriksaanrad_id']) ? $_POST['pemeriksaanrad_id'] : null);
                $kelaspelayanan_id = (isset($_POST['kelaspelayanan_id']) ? $_POST['kelaspelayanan_id'] : null);
                $pendaftaran_id = (isset($_POST['pendaftaran_id']) ? $_POST['pendaftaran_id'] : null);
                $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);        
                $modPasienAdmisi = PasienadmisiT::model()->findByPk($modPendaftaran->pasienadmisi_id);
                
                //$modTindakanRuangan = TindakanruanganV::model()->findByAttributes(array('daftartindakan_id'=>$modPeriksaRad->daftartindakan_id));
                $criteria = new CDbCriteria();
                $criteria->addCondition('pemeriksaanrad_id = '.$pemeriksaanrad_id);
                $criteria->addCondition('kelaspelayanan_id = '.$kelaspelayanan_id);
                $criteria->addCondition('penjamin_id = '.$modPasienAdmisi->penjamin_id);
                $modTarif = TarifpemeriksaanradruanganV::model()->find($criteria);
                
                /**
                 * dicomment RND-3288
                 */
//                $jenistarif = JenistarifpenjaminM::model()->find('penjamin_id = '.$modPasienAdmisi->penjamin_id)->jenistarif_id;
//                $modPeriksaRad = PemeriksaanradM::model()->findByPk($pemeriksaanrad_id);
//                $modTarif = TariftindakanM::model()->findByAttributes(array('daftartindakan_id'=>$modPeriksaRad->daftartindakan_id,
//                                                                            'kelaspelayanan_id'=>$kelaspelayanan_id,
//                                                                            'jenistarif_id'=>$jenistarif,
//                                                                            'komponentarif_id'=>Params::KOMPONENTARIF_ID_TOTAL));
                echo CJSON::encode(array(
                    'status'=>'create_form', 
                    'form'=>$this->renderPartial('_formLoadPemeriksaanRad', array(
//                                                                                'modPeriksaRad'=>$modPeriksaRad,
                                                                                  //'modTindakanRuangan'=>$modTindakanRuangan,
                                                                                  'modTarif'=>$modTarif), true)));
                exit;               
            }
        }
        public function actionPrint()
        {
             $pendaftaran_id = $_GET['id'];
             $idPasienKirimKeUnitLain = $_GET['idPasienKirimKeUnitLain'];
             $modPendaftaran= PendaftaranT::model()->findByPk($pendaftaran_id);
             $modRiwayatKirimKeUnitLain = RIPasienKirimKeUnitLainT::model()->findAllByAttributes(array('pendaftaran_id'=>$pendaftaran_id,
                'pasienkirimkeunitlain_id'=>$idPasienKirimKeUnitLain),
                'pasienmasukpenunjang_id IS NULL');

            $judulLaporan='Permintaan Pemeriksaan Radiologi';
            $caraPrint=$_REQUEST['caraPrint'];
            if($caraPrint=='PRINT') {
                $this->layout='//layouts/printWindows';
                $this->render('Print',array('modPendaftaran'=>$modPendaftaran,'modRiwayatKirimKeUnitLain'=>$modRiwayatKirimKeUnitLain,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint));
            }
            else if($caraPrint=='EXCEL') {
                $this->layout='//layouts/printExcel';
                $this->render('Print',array('modPendaftaran'=>$modPendaftaran,'modRiwayatKirimKeUnitLain'=>$modRiwayatKirimKeUnitLain,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint));
            }
            else if($_REQUEST['caraPrint']=='PDF') {
                $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
                $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
                $mpdf = new MyPDF('',$ukuranKertasPDF); 
                $mpdf->useOddEven = 2;  
                $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
                $mpdf->WriteHTML($stylesheet,1);  
                $mpdf->AddPage($posisi,'','','','',15,15,15,15,15,15);
                $mpdf->WriteHTML($this->renderPartial('Print',array('modPendaftaran'=>$modPendaftaran,'modRiwayatKirimKeUnitLain'=>$modRiwayatKirimKeUnitLain,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint),true));
                $mpdf->Output();
            }                       
        }

        public function actionPrintRiwayat()
        {
             $pendaftaran_id = $_GET['id'];
             $modPendaftaran= PendaftaranT::model()->findByPk($pendaftaran_id);
             $modKirimKeUnitLain = RIPasienKirimKeUnitLainT::model()->findAll('pendaftaran_id='.$pendaftaran_id);

             $modRiwayatKirimKeUnitLain = RIPasienKirimKeUnitLainT::model()->findAllByAttributes(array('pendaftaran_id'=>$pendaftaran_id,
                                                                                                      'instalasi_id'=>Params::INSTALASI_ID_RAD),
                                                                                                'pasienmasukpenunjang_id IS NULL');
            
            $judulLaporan='Permintaan Pemeriksaan Radiologi';
            $caraPrint=$_REQUEST['caraPrint'];
            if($caraPrint=='PRINT') {
                $this->layout='//layouts/printWindows';
                $this->render('printRiwayat',array('modKirimKeUnitLain'=> $modKirimKeUnitLain,'modPendaftaran'=>$modPendaftaran,'modRiwayatKirimKeUnitLain'=>$modRiwayatKirimKeUnitLain,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint));
            }
            else if($caraPrint=='EXCEL') {
                $this->layout='//layouts/printExcel';
                $this->render('printRiwayat',array('modKirimKeUnitLain'=> $modKirimKeUnitLain,'modPendaftaran'=>$modPendaftaran,'modRiwayatKirimKeUnitLain'=>$modRiwayatKirimKeUnitLain,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint));
            }
            else if($_REQUEST['caraPrint']=='PDF') {
                $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
                $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
                $mpdf = new MyPDF('',$ukuranKertasPDF); 
                $mpdf->useOddEven = 2;  
                $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
                $mpdf->WriteHTML($stylesheet,1);  
                $mpdf->AddPage($posisi,'','','','',15,15,15,15,15,15);
                $mpdf->WriteHTML($this->renderPartial('printRiwayat',array('modKirimKeUnitLain'=> $modKirimKeUnitLain,'modPendaftaran'=>$modPendaftaran,'modRiwayatKirimKeUnitLain'=>$modRiwayatKirimKeUnitLain,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint),true));
                $mpdf->Output();
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