<?php
Yii::import('laboratorium.controllers.PendaftaranLaboratoriumController');
class PendaftaranLaboratoriumRujukanRSController extends PendaftaranLaboratoriumController
{
    
	public $layout='//layouts/column1';
	public $defaultAction = 'index';
	public $path_view = "laboratorium.views.pendaftaranLaboratoriumRujukanRS.";
	public $path_view_pendaftaran = "laboratorium.views.pendaftaranLaboratorium.";
	public $obatalkespasientersimpan = true; //di looping
	public $stokobatalkestersimpan = true; //looping
	/**
	 * Tambah / Ubah Pemeriksaan Laboratorium.
	 */
	public function actionIndex($pasienmasukpenunjang_id=null,$pendaftaran_id = null, $instalasi_id = null)
	{
		$format = new MyFormatter();
		$modKunjungan=new LBPasienKirimKeUnitLainV;
		$modKunjungan->ruangan_id = Yii::app()->user->getState("ruangan_id");
		$modPemeriksaanLab = new LBTarifpemeriksaanlabruanganV;
		$modPasienMasukPenunjang = new LBPasienmasukpenunjangT;
		$modPasienMasukPenunjang->ruangan_id = Yii::app()->user->getState("ruangan_id");
		$modTindakan=new LBTindakanPelayananT;
		$modObatAlkesPasien = new LBObatalkespasienT;
		$dataTindakans = array(); 

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

		if(isset($_GET['pasienkirimkeunitlain_id'])){
			$modKunjungan = LBPasienKirimKeUnitLainV::model()->findByAttributes(array('pasienkirimkeunitlain_id'=>$_GET['pasienkirimkeunitlain_id']));
			$modPasienMasukPenunjang->pasienkirimkeunitlain_id = $modKunjungan->pasienkirimkeunitlain_id;
			$modPasienMasukPenunjang->jeniskasuspenyakit_id = $modKunjungan->jeniskasuspenyakit_id;
			$modPasienMasukPenunjang->kelaspelayanan_id = $modKunjungan->kelaspelayanan_id;
		}
		if(isset($_GET['pendaftaran_id'])){
			$modKunjungan = LBInfokunjunganrjrdriV::model()->findByAttributes(array('pendaftaran_id'=>$_GET['pendaftaran_id'],'instalasi_id'=>$_GET['instalasi_id']));
			$modKunjungan->instalasiasal_id = $modKunjungan->instalasi_id;
			$modKunjungan->instalasiasal_nama = $modKunjungan->instalasi_nama;
			$modKunjungan->ruanganasal_id = $modKunjungan->ruangan_id;
			$modKunjungan->ruanganasal_nama = $modKunjungan->ruangan_nama;
			$modKunjungan->nama_bin = $modKunjungan->alias;
			$modPasienMasukPenunjang->pasienkirimkeunitlain_id = isset($modKunjungan->pasienkirimkeunitlain_id) ? $modKunjungan->pasienkirimkeunitlain_id : null;
			$modPasienMasukPenunjang->jeniskasuspenyakit_id = isset($modKunjungan->jeniskasuspenyakit_id) ? $modKunjungan->jeniskasuspenyakit_id : null;
			$modPasienMasukPenunjang->kelaspelayanan_id = isset($modKunjungan->kelaspelayanan_id) ? $modKunjungan->kelaspelayanan_id : null;
		}
		if(!empty($pasienmasukpenunjang_id)){
			$modPasienMasukPenunjang = LBPasienmasukpenunjangT::model()->findByPk($pasienmasukpenunjang_id);
			$loadModKunjungan = LBPasienMasukPenunjangV::model()->findByAttributes(array('pasienmasukpenunjang_id'=>$pasienmasukpenunjang_id));
			if(isset($loadModKunjungan)){
				$modKunjungan = $loadModKunjungan;
			}
		}

		if(isset($_POST['LBPasienmasukpenunjangT']))
		{
			if(!empty($_POST['LBPasienmasukpenunjangT']['pasienkirimkeunitlain_id'])){
				$modKunjungan = LBPasienKirimKeUnitLainV::model()->findByAttributes(array('pasienkirimkeunitlain_id'=>$_POST['LBPasienmasukpenunjangT']['pasienkirimkeunitlain_id']));
			}else{
				$modKunjungan = LBInfokunjunganrjrdriV::model()->findByAttributes(array('pendaftaran_id'=>$_GET['pendaftaran_id'],'instalasi_id'=>$_GET['instalasi_id']));
			}            
			$modPendaftaran = LBPendaftaranT::model()->findByPk($_POST['pendaftaran_id']);
			$transaction = Yii::app()->db->beginTransaction();
			try {
				$modPasienMasukPenunjang = $this->simpanPasienMasukPenunjang($modPasienMasukPenunjang,$modPendaftaran,$_POST['LBPasienmasukpenunjangT']);
				if(!empty($_POST['LBPasienmasukpenunjangT']['pasienkirimkeunitlain_id'])){
					$pasienkirimterupdate = PasienkirimkeunitlainT::model()->updateByPk($modPasienMasukPenunjang->pasienkirimkeunitlain_id,array('pasienmasukpenunjang_id'=>$modPasienMasukPenunjang->pasienmasukpenunjang_id));
				}else{
					$pasienkirimterupdate = true;
				}
				if($_POST['LBPasienmasukpenunjangT']['ruangan_id'] == Params::RUANGAN_ID_LAB_KLINIK){
					$modHasilPemeriksaan = $this->simpanHasilPemeriksaanLab($modPendaftaran->pasien, $modPasienMasukPenunjang);
				}
				if(isset($_POST['LBTindakanPelayananT'][0])){
					if(count($_POST['LBTindakanPelayananT'][0]) > 0){
						foreach($_POST['LBTindakanPelayananT'][0] AS $ii => $tindakan){
							if(!empty($tindakan['tindakanpelayanan_id'])){
								$dataTindakans[$ii] = LBTindakanPelayananT::model()->findByPk($tindakan['tindakanpelayanan_id']);
								$dataTindakans[$ii]->attributes = $modPasienMasukPenunjang->attributes;
								$dataTindakans[$ii]->dokterpemeriksa1_id=$modPasienMasukPenunjang->pegawai_id;
								$dataTindakans[$ii]->perawat_id = (!empty($modPasienMasukPenunjang->perawat_id) ? $modPasienMasukPenunjang->perawat_id : null);
								$dataTindakans[$ii]->qty_tindakan = $tindakan['qty_tindakan'];
								$dataTindakans[$ii]->tarif_tindakan = ($tindakan['tarif_tindakan']);
								
								if (isset($tindakan['dokterpemeriksa1_id']) && !empty($tindakan['dokterpemeriksa1_id'])) 
									$dataTindakans[$ii]->dokterpemeriksa1_id = $tindakan['dokterpemeriksa1_id'];

								if (isset($tindakan['perawat_id']) && !empty($tindakan['perawat_id']))
									$dataTindakans[$ii]->perawat_id = $tindakan['perawat_id'];
								
								$dataTindakans[$ii]->update();

								if($_POST['LBPasienmasukpenunjangT']['ruangan_id'] == Params::RUANGAN_ID_LAB_KLINIK){ 
									$this->simpanDetailHasilPemeriksaanLab($modHasilPemeriksaan, $dataTindakans[$ii],$tindakan);
								} else if($_POST['LBPasienmasukpenunjangT']['ruangan_id'] == Params::RUANGAN_ID_LAB_ANATOMI){
									$modHasilPemeriksaanPA = $this->simpanHasilPemeriksaanPA($modPasienMasukPenunjang, $dataTindakans[$ii], $tindakan);
								}                            
							}else{
								$dataTindakans[$ii] = $this->simpanTindakanPelayanan($modPendaftaran,$modPasienMasukPenunjang,$tindakan);
								if($_POST['LBPasienmasukpenunjangT']['ruangan_id'] == Params::RUANGAN_ID_LAB_KLINIK){
									if(!empty($modHasilPemeriksaan->hasilpemeriksaanlab_id)){
										if(empty($tindakan['tindakanpelayanan_id'])){ //jika tindakan baru
											$this->simpanDetailHasilPemeriksaanLab($modHasilPemeriksaan, $dataTindakans[$ii],$tindakan);
										}
									}
								}else if($_POST['LBPasienmasukpenunjangT']['ruangan_id'] == Params::RUANGAN_ID_LAB_ANATOMI){
									$modHasilPemeriksaanPA = $this->simpanHasilPemeriksaanPA($modPasienMasukPenunjang, $dataTindakans[$ii], $tindakan);
								}
							}
							//untuk ditampilkan di form
							$dataTindakans[$ii]->pemeriksaanlab_id = $tindakan['pemeriksaanlab_id'];
							$dataTindakans[$ii]->jenistarif_id = $tindakan['jenistarif_id'];
							$dataTindakans[$ii]->tarif_tindakan = $format->formatNumberForUser($tindakan['tarif_tindakan']);
						}
					}
				}

				if(isset($_POST['ROObatalkespasienT']) OR isset($_POST['LBObatalkespasienT'])){
					if(count($_POST['LBObatalkespasienT']) > 0){
						//PROSES GROUP DETAIL BERDASARKAN obatalkes_id & akumulasikan jmlmutasi
						$detailGroups = array();
						foreach($_POST['LBObatalkespasienT'] AS $i => $postDetail){
							$modDetails[$i] = new LBObatalkespasienT;
							$modDetails[$i]->attributes = $postDetail;

							$modDetails[$i] = $this->simpanObatAlkesPasien2($modPasienMasukPenunjang,$postDetail);
							$this->simpanStokObatAlkesOut2($modDetails[$i]);
						}
					}
				}
				// var_dump($this->pasienpenunjangtersimpan, $this->tindakanpelayanantersimpan, $this->komponentindakantersimpan, $this->hasilpemeriksaantersimpan, $pasienkirimterupdate, $this->obatalkespasientersimpan, $this->stokobatalkestersimpan);
				// die;

				if($this->pasienpenunjangtersimpan && $this->tindakanpelayanantersimpan && $this->komponentindakantersimpan && $this->hasilpemeriksaantersimpan && $pasienkirimterupdate && $this->obatalkespasientersimpan && $this->stokobatalkestersimpan){

					// SMS GATEWAY
					$smspasien = 1;
					if(Yii::app()->user->getState('issmsgateway')){
						$modPasien = $modPasienMasukPenunjang->pasien;
						$modPendaftaran = $modPasienMasukPenunjang->pendaftaran;
						$modRuangan = $modPasienMasukPenunjang->ruangan;
						$sms = new Sms();
						foreach ($modSmsgateway as $i => $smsgateway) {
													if (isset($_POST['tujuansms']) && in_array($smsgateway->tujuansms, $_POST['tujuansms'])) {
							$isiPesan = $smsgateway->templatesms;

							$attributes = $modPasienMasukPenunjang->getAttributes();
							foreach($attributes as $attributes => $value){
								$isiPesan = str_replace("{{".$attributes."}}",$value,$isiPesan);
							}
							$attributes = $modPasien->getAttributes();
							foreach($attributes as $attributes => $value){
								$isiPesan = str_replace("{{".$attributes."}}",$value,$isiPesan);
							}
							$attributes = $modPendaftaran->getAttributes();
							foreach($attributes as $attributes => $value){
								$isiPesan = str_replace("{{".$attributes."}}",$value,$isiPesan);
							}
							$attributes = $modRuangan->getAttributes();
							foreach($attributes as $attributes => $value){
								$isiPesan = str_replace("{{".$attributes."}}",$value,$isiPesan);
							}

							$isiPesan = str_replace("{{hari}}",MyFormatter::getDayName($modPasienMasukPenunjang->tglmasukpenunjang),$isiPesan);

							if($smsgateway->tujuansms == Params::TUJUANSMS_PASIEN && $smsgateway->statussms){
								if(!empty($modPasien->no_mobile_pasien)){
									$sms->kirim($modPasien->no_mobile_pasien,$isiPesan);
								}else{
									$smspasien = 0;
								}
							}
													}
						}
					}
					// END SMS GATEWAY

					$transaction->commit();
					Yii::app()->user->setFlash('success', "Data pemeriksaan laboratorium berhasil disimpan !");
					$this->redirect(array('index','pasienmasukpenunjang_id'=>$modPasienMasukPenunjang->pasienmasukpenunjang_id,'sukses'=>1,'smspasien'=>$smspasien));
				}else{
					$transaction->rollback();
					Yii::app()->user->setFlash('error',"Data pemeriksaan laboratorium gagal disimpan !");
//                        echo "-".$this->pasienpenunjangtersimpan."<br>";
//                        echo "-".$this->tindakanpelayanantersimpan."<br>";
//                        echo "-".$this->komponentindakantersimpan."<br>";
//                        echo "-".$this->hasilpemeriksaantersimpan."<br>";
//                        echo "-".$this->obatalkespasientersimpan."<br>";
//                        exit;
				}
			} catch (Exception $exc) {
				$transaction->rollback();
				Yii::app()->user->setFlash('error',"Data pemeriksaan laboratorium gagal disimpan !"." ".MyExceptionMessage::getMessage($exc,true));
			}
		}

		$modKunjungan->tgl_pendaftaran = $format->formatDateTimeForUser($modKunjungan->tgl_pendaftaran);
		$modKunjungan->tanggal_lahir = $format->formatDateTimeForUser($modKunjungan->tanggal_lahir);

		$this->render('index',array(
			'modKunjungan'=>$modKunjungan,
			'modPemeriksaanLab'=>$modPemeriksaanLab,
			'modPasienMasukPenunjang'=>$modPasienMasukPenunjang,
			'modTindakan'=>$modTindakan,
			'modObatAlkesPasien'=>$modObatAlkesPasien,
			'dataTindakans'=>$dataTindakans,
			'modSmsgateway'=>$modSmsgateway,
		));
	}

	public function simpanObatAlkesPasien2($modPasienMasukPenunjang ,$postDetail){        
		$modObatAlkesPasien = new LBObatalkespasienT;
				// var_dump($postDetail);
				$oa = ObatalkesM::model()->findByPk($postDetail['obatalkes_id']);
		$modObatAlkesPasien->attributes = $postDetail;
		$modObatAlkesPasien->tglpelayanan = date("Y-m-d H:i:s");
		$modObatAlkesPasien->tipepaket_id = Params::TIPEPAKET_ID_NONPAKET;
		$modObatAlkesPasien->ruangan_id = Yii::app()->user->getState('ruangan_id');
		$modObatAlkesPasien->pendaftaran_id = $modPasienMasukPenunjang->pendaftaran_id;
		$modObatAlkesPasien->pasienmasukpenunjang_id = $modPasienMasukPenunjang->pasienmasukpenunjang_id;
		$modObatAlkesPasien->pasienadmisi_id = $modPasienMasukPenunjang->pasienadmisi_id;
		$modObatAlkesPasien->carabayar_id = $modPasienMasukPenunjang->pendaftaran->carabayar_id;
		$modObatAlkesPasien->penjamin_id = $modPasienMasukPenunjang->pendaftaran->penjamin_id;
		$modObatAlkesPasien->pegawai_id = $modPasienMasukPenunjang->pegawai_id;
		$modObatAlkesPasien->shift_id = Yii::app()->user->getState('shift_id');
		$modObatAlkesPasien->pasien_id = $modPasienMasukPenunjang->pasien_id;
		$modObatAlkesPasien->kelaspelayanan_id = $modPasienMasukPenunjang->kelaspelayanan_id;
		$modObatAlkesPasien->tglpelayanan = date ('Y-m-d H:i:s');
		$modObatAlkesPasien->create_loginpemakai_id = Yii::app()->user->id;
		$modObatAlkesPasien->create_ruangan = Yii::app()->user->getState('ruangan_id');
		$modObatAlkesPasien->create_time = date ('Y-m-d H:i:s');
		$modObatAlkesPasien->qty_oa = $postDetail['qty_oa']; //$stokOa->qtystok_terpakai;
		//$modObatAlkesPasien->qty_stok = $stokOa->qtystok;
		$modObatAlkesPasien->harganetto_oa = $oa->harganetto; //$stokOa->HPP;
		$modObatAlkesPasien->hargasatuan_oa = $oa->hargajual; //$stokOa->HargaJualSatuan;
		$modObatAlkesPasien->hargajual_oa = $modObatAlkesPasien->hargasatuan_oa * $modObatAlkesPasien->qty_oa;
		$modObatAlkesPasien->iurbiaya = $modObatAlkesPasien->hargajual_oa;
		 //foreach ($postObatAlkesPasien AS $i => $postDetail) {
			//if ($stokOa->obatalkes_id==$postDetail['obatalkes_id']) {
				$modObatAlkesPasien->sumberdana_id = $postDetail['sumberdana_id'];                
				$modObatAlkesPasien->satuankecil_id = $postDetail['satuankecil_id'];                
				// $modObatAlkesPasien->qty_stok = $postDetail['qty_stok'];                
			//}
		//}
				//var_dump($modObatAlkesPasien->validate());         
				//var_dump($modObatAlkesPasien->errors);
				//var_dump($modObatAlkesPasien->attributes); die;

		if($modObatAlkesPasien->save()){
			$this->obatalkespasientersimpan &= true;
		}else{
			$this->obatalkespasientersimpan &= false;
		}

//        old
//        $modObatAlkesPasien = new ROObatalkespasienT;
//        $modObatAlkesPasien->attributes = $post;
//        $modObatAlkesPasien->tipepaket_id = Params::TIPEPAKET_ID_NONPAKET;
//        $modObatAlkesPasien->ruangan_id = Yii::app()->user->getState('ruangan_id');
//        $modObatAlkesPasien->pendaftaran_id = $modPasienMasukPenunjang->pendaftaran_id;
//        $modObatAlkesPasien->pasienmasukpenunjang_id = $modPasienMasukPenunjang->pasienmasukpenunjang_id;
//        $modObatAlkesPasien->pasienadmisi_id = $modPasienMasukPenunjang->pasienadmisi_id;
//        $modObatAlkesPasien->carabayar_id = $modPasienMasukPenunjang->pendaftaran->carabayar_id;
//        $modObatAlkesPasien->penjamin_id = $modPasienMasukPenunjang->pendaftaran->penjamin_id;
//        $modObatAlkesPasien->pegawai_id = $modPasienMasukPenunjang->pegawai_id;
//        $modObatAlkesPasien->shift_id = Yii::app()->user->getState('shift_id');
//        $modObatAlkesPasien->pasien_id = $modPasienMasukPenunjang->pasien_id;
//        $modObatAlkesPasien->kelaspelayanan_id = $modPasienMasukPenunjang->kelaspelayanan_id;
//        $modObatAlkesPasien->tglpelayanan = date ('Y-m-d H:i:s');
//        $modObatAlkesPasien->create_loginpemakai_id = Yii::app()->user->id;
//        $modObatAlkesPasien->create_ruangan = Yii::app()->user->getState('ruangan_id');
//        $modObatAlkesPasien->create_time = date ('Y-m-d H:i:s');
//        
//        if($modObatAlkesPasien->validate()) {
//            $modObatAlkesPasien->save();
//            StokobatalkesT::kurangiStok($modObatAlkesPasien->qty_oa, $modObatAlkesPasien->obatalkes_id);
//        } else {
//            $this->obatalkespasientersimpan &= false;
//        }
		return $modObatAlkesPasien;
	}


	/**
	 * simpan LBObatalkespasienT
	 * @param type $modPasienMasukPenunjang
	 * @param type $stokOa
	 * @param type $postObatAlkesPasien
	 * @return \LBObatalkespasienT
	 * copy dari : PemakaianBmhpController
	 */
	public function simpanObatAlkesPasien($modPasienMasukPenunjang ,$stokOa, $postObatAlkesPasien){        
		$modObatAlkesPasien = new LBObatalkespasienT;
		$modObatAlkesPasien->attributes = $stokOa->attributes;
		$modObatAlkesPasien->tglpelayanan = date("Y-m-d H:i:s");
		$modObatAlkesPasien->tipepaket_id = Params::TIPEPAKET_ID_NONPAKET;
		$modObatAlkesPasien->ruangan_id = Yii::app()->user->getState('ruangan_id');
		$modObatAlkesPasien->pendaftaran_id = $modPasienMasukPenunjang->pendaftaran_id;
		$modObatAlkesPasien->pasienmasukpenunjang_id = $modPasienMasukPenunjang->pasienmasukpenunjang_id;
		$modObatAlkesPasien->pasienadmisi_id = $modPasienMasukPenunjang->pasienadmisi_id;
		$modObatAlkesPasien->carabayar_id = $modPasienMasukPenunjang->pendaftaran->carabayar_id;
		$modObatAlkesPasien->penjamin_id = $modPasienMasukPenunjang->pendaftaran->penjamin_id;
		$modObatAlkesPasien->pegawai_id = $modPasienMasukPenunjang->pegawai_id;
		$modObatAlkesPasien->shift_id = Yii::app()->user->getState('shift_id');
		$modObatAlkesPasien->pasien_id = $modPasienMasukPenunjang->pasien_id;
		$modObatAlkesPasien->kelaspelayanan_id = $modPasienMasukPenunjang->kelaspelayanan_id;
		$modObatAlkesPasien->tglpelayanan = date ('Y-m-d H:i:s');
		$modObatAlkesPasien->create_loginpemakai_id = Yii::app()->user->id;
		$modObatAlkesPasien->create_ruangan = Yii::app()->user->getState('ruangan_id');
		$modObatAlkesPasien->create_time = date ('Y-m-d H:i:s');
		$modObatAlkesPasien->qty_oa = $stokOa->qtystok_terpakai;
		$modObatAlkesPasien->qty_stok = $stokOa->qtystok;
		$modObatAlkesPasien->harganetto_oa = $stokOa->HPP;
		$modObatAlkesPasien->hargasatuan_oa = $stokOa->HargaJualSatuan;
		$modObatAlkesPasien->hargajual_oa = $modObatAlkesPasien->hargasatuan_oa * $modObatAlkesPasien->qty_oa;
		$modObatAlkesPasien->iurbiaya = $modObatAlkesPasien->hargajual_oa;
		 foreach ($postObatAlkesPasien AS $i => $postDetail) {
			if ($stokOa->obatalkes_id==$postDetail['obatalkes_id']) {
				$modObatAlkesPasien->sumberdana_id = $postDetail['sumberdana_id'];                
				$modObatAlkesPasien->satuankecil_id = $postDetail['satuankecil_id'];                
				$modObatAlkesPasien->qty_stok = $postDetail['qty_stok'];                
			}
		}

		if($modObatAlkesPasien->save()){
			$this->obatalkespasientersimpan &= true;
		}else{
			echo "c";exit;
			$this->obatalkespasientersimpan &= false;
		}

//        old
//        $modObatAlkesPasien = new LBObatalkespasienT;
//        $modObatAlkesPasien->attributes = $post;
//        $modObatAlkesPasien->tipepaket_id = Params::TIPEPAKET_ID_NONPAKET;
//        $modObatAlkesPasien->ruangan_id = Yii::app()->user->getState('ruangan_id');
//        $modObatAlkesPasien->pendaftaran_id = $modPasienMasukPenunjang->pendaftaran_id;
//        $modObatAlkesPasien->pasienmasukpenunjang_id = $modPasienMasukPenunjang->pasienmasukpenunjang_id;
//        $modObatAlkesPasien->pasienadmisi_id = $modPasienMasukPenunjang->pasienadmisi_id;
//        $modObatAlkesPasien->carabayar_id = $modPasienMasukPenunjang->pendaftaran->carabayar_id;
//        $modObatAlkesPasien->penjamin_id = $modPasienMasukPenunjang->pendaftaran->penjamin_id;
//        $modObatAlkesPasien->pegawai_id = $modPasienMasukPenunjang->pegawai_id;
//        $modObatAlkesPasien->shift_id = Yii::app()->user->getState('shift_id');
//        $modObatAlkesPasien->pasien_id = $modPasienMasukPenunjang->pasien_id;
//        $modObatAlkesPasien->kelaspelayanan_id = $modPasienMasukPenunjang->kelaspelayanan_id;
//        $modObatAlkesPasien->tglpelayanan = date ('Y-m-d H:i:s');
//        $modObatAlkesPasien->create_loginpemakai_id = Yii::app()->user->id;
//        $modObatAlkesPasien->create_ruangan = Yii::app()->user->getState('ruangan_id');
//        $modObatAlkesPasien->create_time = date ('Y-m-d H:i:s');
//        
//        if($modObatAlkesPasien->validate()) {
//            $modObatAlkesPasien->save();
//            StokobatalkesT::kurangiStok($modObatAlkesPasien->qty_oa, $modObatAlkesPasien->obatalkes_id);
//        } else {
//            $this->obatalkespasientersimpan &= false;
//        }
		return $modObatAlkesPasien;
	}

	/**
	 * simpan StokobatalkesT Jumlah Out
	 * @param type $stokobatalkesasal_id
	 * @param type $modObatAlkesPasien
	 * @return \StokobatalkesT
	 */
	protected function simpanStokObatAlkesOut2($modObatAlkesPasien){
			$format = new MyFormatter;
			$oa = ObatalkesM::model()->findByPk($modObatAlkesPasien->obatalkes_id);
			//$modStokOa = StokobatalkesT::model()->findByPk($stokobatalkesasal_id);
			$modStokOaNew = new StokobatalkesT;
			$modStokOaNew->attributes = $oa->attributes;
			$modStokOaNew->attributes = $modObatAlkesPasien->attributes; //duplicate
			// $modStokOaNew->unsetIdTransaksi(); //new / autoincrement pk
			$modStokOaNew->qtystok_in = 0;
			$modStokOaNew->qtystok_out = $modObatAlkesPasien->qty_oa;
			$modStokOaNew->obatalkespasien_id = $modObatAlkesPasien->obatalkespasien_id;
			//$modStokOaNew->stokobatalkesasal_id = $stokobatalkesasal_id;
			$modStokOaNew->create_time = date('Y-m-d H:i:s');
			$modStokOaNew->update_time = $modStokOaNew->tglterima = date('Y-m-d H:i:s');
			$modStokOaNew->create_loginpemakai_id = Yii::app()->user->id;
			$modStokOaNew->update_loginpemakai_id = Yii::app()->user->id;
			$modStokOaNew->create_ruangan = Yii::app()->user->ruangan_id;

			//var_dump($modStokOaNew->validate());
			//var_dump($modStokOaNew->errors);
			//var_dump($modStokOaNew->attributes); die;

			if($modStokOaNew->validate()){ 
					$modStokOaNew->save();
					//$modStokOaNew->setStokOaAktifBerdasarkanStok();
			} else {
					$this->stokobatalkestersimpan &= false;
			}
			return $modStokOaNew;      
	}


	/**
	 * simpan StokobatalkesT Jumlah Out
	 * @param type $stokobatalkesasal_id
	 * @param type $modObatAlkesPasien
	 * @return \StokobatalkesT
	 */
	protected function simpanStokObatAlkesOut($stokobatalkesasal_id,$modObatAlkesPasien){
		$format = new MyFormatter;
		$modStokOa = StokobatalkesT::model()->findByPk($stokobatalkesasal_id);
		$modStokOaNew = new StokobatalkesT;
		$modStokOaNew->attributes = $modStokOa->attributes; //duplicate
		$modStokOaNew->unsetIdTransaksi(); //new / autoincrement pk
		$modStokOaNew->qtystok_in = 0;
		$modStokOaNew->qtystok_out = $modObatAlkesPasien->qty_oa;
		$modStokOaNew->obatalkespasien_id = $modObatAlkesPasien->obatalkespasien_id;
		$modStokOaNew->stokobatalkesasal_id = $stokobatalkesasal_id;
		$modStokOaNew->create_time = date('Y-m-d H:i:s');
		$modStokOaNew->update_time = date('Y-m-d H:i:s');
		$modStokOaNew->create_loginpemakai_id = Yii::app()->user->id;
		$modStokOaNew->update_loginpemakai_id = Yii::app()->user->id;
		$modStokOaNew->create_ruangan = Yii::app()->user->ruangan_id;

		if($modStokOaNew->validateStok()){ 
			$modStokOaNew->save();
			$modStokOaNew->setStokOaAktifBerdasarkanStok();
		} else {
			$this->stokobatalkestersimpan &= false;
		}
		return $modStokOaNew;      
	}

	/**
	* untuk menampilkan data kunjungan dari autocomplete
	* - no_pendaftaran
	* - no_rekam_medik
	* - nama_pasien
	*/
	public function actionAutocompleteKunjungan()
	{
		if(Yii::app()->request->isAjaxRequest) {
			$format = new MyFormatter();
			$returnVal = array();
			$no_pendaftaran = isset($_GET['no_pendaftaran']) ? $_GET['no_pendaftaran'] : null;
			$no_rekam_medik = isset($_GET['no_rekam_medik']) ? $_GET['no_rekam_medik'] : null;
			$nama_pasien = isset($_GET['nama_pasien']) ? $_GET['nama_pasien'] : null;
			$criteria = new CDbCriteria();
			$criteria->compare('LOWER(no_pendaftaran)', strtolower($no_pendaftaran), true);
			$criteria->compare('LOWER(no_rekam_medik)', strtolower($no_rekam_medik), true);
			$criteria->compare('LOWER(nama_pasien)', strtolower($nama_pasien), true);
			$criteria->addCondition('ruangan_id = '.Yii::app()->user->getState('ruangan_id'));
			$criteria->order = 'no_pendaftaran, no_rekam_medik, nama_pasien';
			$criteria->limit = 5;
			$models = LBPasienKirimKeUnitLainV::model()->findAll($criteria);
			foreach($models as $i=>$model)
			{
				$attributes = $model->attributeNames();
				foreach($attributes as $j=>$attribute) {
					$returnVal[$i]["$attribute"] = $model->$attribute;
				}
				$returnVal[$i]['label'] = $model->no_pendaftaran.'-'.$model->no_rekam_medik.'-'.$model->nama_pasien.(!empty($model->nama_bin) ? "(".$model->nama_bin.")" : "");
			}

			echo CJSON::encode($returnVal);
		}
		Yii::app()->end();
	}

	/**
	 * Mengurai data kunjungan berdasarkan:
	 * - pasienkirimkeunitlain_id
	 * @throws CHttpException
	 */
	public function actionGetDataKunjungan()
	{
		if(Yii::app()->request->isAjaxRequest) {
			$format = new MyFormatter();
			$returnVal = array();
			$model = LBPasienKirimKeUnitLainV::model()->findByAttributes(array('pasienkirimkeunitlain_id'=>$_POST['pasienkirimkeunitlain_id']));
			$attributes = $model->attributeNames();
			foreach($attributes as $j=>$attribute) {
				$returnVal["$attribute"] = $model->$attribute;
			}
			$returnVal["tanggal_lahir"] = $format->formatDateTimeForUser($model->tanggal_lahir);
			$returnVal["tgl_pendaftaran"] = $format->formatDateTimeForUser($model->tgl_pendaftaran);
			$returnVal["namalengkapdokter"] = $model->gelardepan." ".$model->nama_pegawai." ".$model->gelarbelakang_nama;
			echo CJSON::encode($returnVal);
		}
		Yii::app()->end();
	}
	/**
	 * set LBPermintaanKePenunjangT yang sudah ada di database
	 * @params pasienmasukpenunjang_id
	 */
	public function actionSetPermintaanKePenunjang(){
		if(Yii::app()->request->isAjaxRequest) {
			$format = new MyFormatter();
			$rows = "";
			$modPermintaans = LBPermintaanKePenunjangT::model()->findAllByAttributes(array('pasienkirimkeunitlain_id'=>$_POST['pasienkirimkeunitlain_id']));
			if(count($modPermintaans) > 0){
				foreach($modPermintaans AS $i => $modPermintaan){
					$modPemeriksaan = PemeriksaanlabM::model()->findByAttributes(array('pemeriksaanlab_id'=>$modPermintaan->pemeriksaanlab_id));
					if(isset($modPemeriksaan->daftartindakan_id)){
						$modPermintaan->daftartindakan_id = $modPemeriksaan->daftartindakan_id;
						$rows .= $this->renderPartial($this->path_view."_rowPermintaanKePenunjang",array('i'=>0,'modPermintaan'=>$modPermintaan), true);
					}
				}
			}
			echo CJSON::encode(array(
					'rows'=>$rows));
		}
		Yii::app()->end();
	}

	/**
	 * set LKTindakanpelayananT yang sudah ada di database
	 * @params pasienmasukpenunjang_id
	 */
	public function actionSetTindakanPelayanan(){
		if(Yii::app()->request->isAjaxRequest) {
			$format = new MyFormatter();
			$rows = "";
			$modTindakans = LBTindakanPelayananT::model()->findAllByAttributes(array('pasienmasukpenunjang_id'=>$_POST['pasienmasukpenunjang_id']), 'karcis_id IS NULL');
			if(count($modTindakans) > 0){
				foreach($modTindakans AS $i => $modTindakan){
					$modTindakan->pemeriksaanlab_id = PemeriksaanlabM::model()->findByAttributes(array('daftartindakan_id'=>$modTindakan->daftartindakan_id))->pemeriksaanlab_id;
					$modTindakan->jenistarif_id = JenistarifpenjaminM::model()->findByAttributes(array('penjamin_id'=>$modTindakan->pendaftaran->penjamin_id))->jenistarif_id;
					$modTindakan->tarif_tindakan = $format->formatNumberForPrint($modTindakan->tarif_tindakan);
					$modTindakan->tarif_satuan = $format->formatNumberForPrint($modTindakan->tarif_satuan);
					$rows .= $this->renderPartial($this->path_view_pendaftaran."_rowTindakanPemeriksaan",array('i'=>0, 'modTindakan'=>$modTindakan), true);
				}
			}
			echo CJSON::encode(array(
					'rows'=>$rows));
		}
		Yii::app()->end();
	}

	 /**
	* menampilkan obat
	* @return row table 
	*/
	public function actionSetFormObatAlkesPasien()
	{
		if(Yii::app()->request->isAjaxRequest) { 
			$obatalkes_id = isset($_POST['obatalkes_id']) ? $_POST['obatalkes_id'] : null;
			$jumlah = isset($_POST['jumlah']) ? $_POST['jumlah'] : 1;
			$form = "";
			$pesan = "";
			$format = new MyFormatter();
			$modObatAlkesPasien = new LBObatalkespasienT;
			$ruangan_id = Yii::app()->user->getState('ruangan_id');
			$modStokOAs = StokobatalkesT::getStokObatAlkesAktif($obatalkes_id, $jumlah, $ruangan_id);
			$oa = ObatalkesM::model()->findByPk($obatalkes_id);
			//if(count($modStokOAs) > 0){

			//    foreach($modStokOAs AS $i => $stok){
					$modObatAlkesPasien->sumberdana_id = $oa->sumberdana_id; //(isset($stok->penerimaandetail->sumberdana_id) ? $stok->penerimaandetail->sumberdana_id : $stok->obatalkes->sumberdana_id);
					$modObatAlkesPasien->obatalkes_id = $oa->obatalkes_id; //$stok->obatalkes_id;
					$modObatAlkesPasien->qty_oa = $jumlah; //$stok->qtystok_terpakai;
					$modObatAlkesPasien->harganetto_oa = $oa->harganetto; //$stok->HPP;
					$modObatAlkesPasien->hargasatuan_oa = $oa->hargajual; //$stok->HargaJualSatuan;
					$modObatAlkesPasien->qty_stok = 0; //$stok->qtystok;
					$modObatAlkesPasien->hargajual_oa = $modObatAlkesPasien->qty_oa * $modObatAlkesPasien->hargasatuan_oa;
					$modObatAlkesPasien->stokobatalkes_id = null; //$stok->stokobatalkes_id;
					$modObatAlkesPasien->biayaservice = 0;
					$modObatAlkesPasien->biayakonseling = 0;
					$modObatAlkesPasien->jasadokterresep = 0;
					$modObatAlkesPasien->biayakemasan = 0;
					$modObatAlkesPasien->biayaadministrasi = 0;
					$modObatAlkesPasien->tarifcyto = 0;
					$modObatAlkesPasien->discount = 0;
					$modObatAlkesPasien->subsidiasuransi = 0;
					$modObatAlkesPasien->subsidipemerintah = 0;
					$modObatAlkesPasien->subsidirs = 0;
					$modObatAlkesPasien->iurbiaya = $modObatAlkesPasien->qty_oa * $modObatAlkesPasien->hargasatuan_oa;
					$modObatAlkesPasien->satuankecil_id = $oa->satuankecil_id; //$stok->satuankecil_id;
					$modObatAlkesPasien->satuankecil_nama = $oa->satuankecil->satuankecil_nama; //$stok->satuankecil->satuankecil_nama;

					$form .= $this->renderPartial($this->path_view.'_rowObatAlkesPasien', array('modObatAlkesPasien'=>$modObatAlkesPasien), true);
			//    }
			//}else{
			//    $pesan = "Stok tidak mencukupi!";
			//}

			echo CJSON::encode(array('form'=>$form, 'pesan'=>$pesan));
			Yii::app()->end(); 
		}
	}

	/**
		* untuk mencari dokter di autocomplete
		*/
	public function actionGetDokter()
	{
		if(Yii::app()->request->isAjaxRequest) {
			$criteria = new CDbCriteria();
			if (isset($_GET['term'])){
				$criteria->compare('LOWER(nama_pegawai)', strtolower($_GET['term']), true);
			} else if (isset($_POST['id'])) {
				$criteria->compare('pegawai_id', $_POST['id']);
			}
			$criteria->order = 'nama_pegawai';
			if (isset($_GET['idPegawai'])){
				if(!empty($_GET['idPegawai'])){
					$criteria->addCondition("pegawai_id = ".$_GET['idPegawai']); 	
				}
			}
			$models = DokterpegawaiV::model()->findAll($criteria);
			foreach($models as $i=>$model)
			{
				$attributes = $model->attributeNames();
				foreach($attributes as $j=>$attribute) {
					$returnVal[$i]["$attribute"] = $model->$attribute;
				}
				$returnVal[$i]['label'] = $model->gelardepan." ".$model->nama_pegawai.", ".$model->gelarbelakang_nama;
				$returnVal[$i]['value'] = $model->pegawai_id;
				$returnVal[$i]['nama_pegawai'] = $model->gelardepan." ".$model->nama_pegawai.", ".$model->gelarbelakang_nama;
			}

			echo CJSON::encode($returnVal);
		}
		Yii::app()->end();
	}

	/**
		* untuk mencari perawat di autocomplete
		*/
	public function actionGetPerawat()
	{
		if(Yii::app()->request->isAjaxRequest) {
			$criteria = new CDbCriteria();
			$criteria->compare('LOWER(nama_pegawai)', strtolower($_GET['term']), true);
			$criteria->order = 'nama_pegawai';
			$models = ParamedisV::model()->findAll($criteria);
			$returnVal = array();
			foreach($models as $i=>$model)
			{
				 $attributes = $model->attributeNames();
				 foreach($attributes as $j=>$attribute) {
					 $returnVal[$i]["$attribute"] = $model->$attribute;
				 }
				 $returnVal[$i]['label'] = $model->gelardepan." ".$model->nama_pegawai.", ".$model->gelarbelakang_nama;
				 $returnVal[$i]['value'] = $model->pegawai_id;
				 $returnVal[$i]['nama_pegawai'] = $model->gelardepan." ".$model->nama_pegawai.", ".$model->gelarbelakang_nama;
			}

			echo CJSON::encode($returnVal);
		}
		Yii::app()->end();
	}
    
}
