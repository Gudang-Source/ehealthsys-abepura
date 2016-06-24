<?php
class KonsulMCUController extends MyAuthController
{
	public $layout='//layouts/iframe';
	public $defaultAction = 'index';
	public $path_view = 'rawatJalan.views.konsulMCU.';
	
	public $konsulpolitersimpan = true;
	public $permintaanmcutersimpan = true;
	public $pengambilansampletersimpan = true; //dilooping / boleh tanpa ini
	public $komponentindakantersimpan = true; //dilooping / boleh tanpa ini
	public $pasienpenunjangtersimpan = true; //dilooping
	public $hasilpemeriksaantersimpan = true; //dilooping
	public $tindakanpelayanantersimpan = true;
	public $karcistersimpan = false;
	
	public function actionIndex($pendaftaran_id,$idKonsulPoli=null)
	{
		$ruangan_id = isset($_GET['ruangan_id']) ? $_GET['ruangan_id'] : Yii::app()->user->getState('ruangan_id');
		$modPendaftaran = RJPendaftaranT::model()->with('jeniskasuspenyakit')->findByPk($pendaftaran_id);
		$modPasien = RJPasienM::model()->findByPk($modPendaftaran->pasien_id);
		$karcisTindakan = DaftartindakanM::model()->findAllByAttributes(array('daftartindakan_karcis'=>true));

		$modKonsul = new RJKonsulPoliT;
		$modKonsul->ruangan_id =  Params::RUANGAN_ID_KLINIK_MCU; // untuk default dropdown poliklinik tujuan
		$modelPendaftaran = new RJPendaftaranT;
		$modKonsul->pasien_id = $modPendaftaran->pasien_id;
		$modKonsul->pendaftaran_id = $pendaftaran_id;
		$modKonsul->pegawai_id = $modPendaftaran->pegawai_id;
		$modKonsul->statusperiksa = Params::STATUSPERIKSA_ANTRIAN;
		$modKonsul->asalpoliklinikkonsul_id = $ruangan_id;
		$modPaketPelayanan = new RJPaketpelayananM;
		$modPasienMasukPenunjang = new RJPasienMasukPenunjangT;
		$modPermintaanMcu = new RJPermintaanmcuT();
		$modPemeriksaanMcu = new PermintaanmcuT();
		$modJenisTarif = JenistarifpenjaminM::model()->find('penjamin_id ='.$modPendaftaran->penjamin_id);
		
		$modTindakan=new RJTindakanPelayananT;
		$modTindakanKarcis=new RJTindakanPelayananKarcisT;
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


		if(isset($_POST['RJKonsulPoliT'])) {
			$modKonsul->attributes = $_POST['RJKonsulPoliT'];
			$modelPendaftaran->pasienpulang_id = $modPendaftaran->pasienpulang_id;
			$modelPendaftaran->pasienbatalperiksa_id = $modPendaftaran->pasienbatalperiksa_id;
			if(empty($modelPendaftaran->penanggungjawab_id)){
			   $penanggungjawab = 1;
			}else{
				$penanggungjawab = $modPendaftaran->penanggungjawab_id;
			}
			$modKonsul->no_antriankonsul = MyGenerator::noAntrianKonsulPoli($modKonsul->ruangan_id);				
			$transaction = Yii::app()->db->beginTransaction();
			try {
				$modKonsul = $this->simpanKonsulPoli($modKonsul, $_POST['RJKonsulPoliT']);
				
				$tmpmcu = array();					
				if(isset($_POST['RJPermintaanmcuT'])){
					if(count($_POST['RJPermintaanmcuT']) > 0){
						foreach($_POST['RJPermintaanmcuT'] as $i=>$tindakanmcu){
							foreach($tindakanmcu as $ii=>$tindakans){
								$tmpmcu[$tindakans['ruangantujuan_id']][] = $tindakans['daftartindakan_id'];
							}
							foreach($tmpmcu as $ruangan => $daftartindakan)
							{
								if($ruangan == Params::RUANGAN_ID_LAB_ANATOMI || $ruangan == Params::RUANGAN_ID_LAB_KLINIK || $ruangan == Params::RUANGAN_ID_RAD || $ruangan == Params::RUANGAN_ID_LAB){
									$modPasienMasukPenunjangs[$ruangan] = $this->simpanPasienMasukPenunjang($modPasienMasukPenunjang,$model,$ruangan);									
									if(isset($_POST['RJPermintaanmcuT'][$i])){
										if(count($_POST['RJPermintaanmcuT'][$i]) > 0){
											if($ruangan == Params::RUANGAN_ID_LAB_KLINIK || $ruangan == Params::RUANGAN_ID_LAB){
												$modHasilPemeriksaan = $this->simpanHasilPemeriksaanLab($modPasien, $modPasienMasukPenunjangs[$ruangan]);
											}
											foreach($_POST['RJPermintaanmcuT'][$i] AS $iii => $tindakanPelayanan){
												if($modPasienMasukPenunjangs[$ruangan]['ruangan_id'] == $tindakanPelayanan['ruangantujuan_id'] ){
													$dataTindakans[$iii] = $this->simpanTindakanPelayanan($model,$modPasienMasukPenunjangs[$ruangan],$tindakanPelayanan);
													$dataPermintaans[$iii] = $this->simpanPermintaanMcu($model,$modPermintaanMcu,$tindakanPelayanan,$dataTindakans[$iii]);												

													if($tindakanPelayanan['ruangantujuan_id'] == Params::RUANGAN_ID_LAB_KLINIK || $tindakanPelayanan['ruangantujuan_id'] == Params::RUANGAN_ID_LAB){
														if(!empty($modHasilPemeriksaan->hasilpemeriksaanlab_id)){
															$this->simpanDetailHasilPemeriksaanLab($modHasilPemeriksaan, $dataTindakans[$iii],$tindakanPelayanan);
														}
													}else if($tindakanPelayanan['ruangantujuan_id'] == Params::RUANGAN_ID_LAB_ANATOMI){
														$modHasilPemeriksaanPA = $this->simpanHasilPemeriksaanPA($modPasienMasukPenunjangs[$i], $dataTindakans[$i][$ii], $tindakanPelayanan);
													}else if($tindakanPelayanan['ruangantujuan_id'] == Params::RUANGAN_ID_RAD){
														$this->simpanHasilPemeriksaanRad($modPasienMasukPenunjangs[$i], $dataTindakans[$iii],$tindakanPelayanan);
													}
												}

											}
										}
									}
								}else{
									foreach($_POST['RJPermintaanmcuT'][$i] AS $iii => $tindakanPelayanan){
										$modPasienMasukPenunjangs[$ruangan] = $this->simpanPasienMasukPenunjang($modPasienMasukPenunjang,$modPendaftaran,$ruangan);									
										$dataTindakans[$iii] = $this->simpanTindakanPelayanan($modPendaftaran,$modPasienMasukPenunjangs[$ruangan],$tindakanPelayanan);
										$dataPermintaans[$iii] = $this->simpanPermintaanMcu($modPendaftaran,$modPermintaanMcu,$tindakanPelayanan,$dataTindakans[$iii]);										
									}
								}
							}

						}
					}
				}

				$tmp = array();
				if(isset($_POST['RJTindakanPelayananT'])){
					if(count($_POST['RJTindakanPelayananT']) > 0){
						$this->permintaanmcutersimpan = true;
						foreach($_POST['RJTindakanPelayananT'] as $i=>$tindakan){	
							foreach($tindakan as $ii=>$tindakans){
								$tmp[$tindakans['ruangan_id']][] = $tindakans['daftartindakan_id'];
							}
							foreach($tmp as $ruangan => $daftartindakan)
							{
								$modPasienMasukPenunjangs[$ruangan] = $this->simpanPasienMasukPenunjang($modPasienMasukPenunjang,$modPendaftaran,$ruangan);									
								if(isset($_POST['RJTindakanPelayananT'][$i])){		
									if(count($_POST['RJTindakanPelayananT'][$i]) > 0){
										if($ruangan == Params::RUANGAN_ID_LAB_KLINIK){
											$modHasilPemeriksaan = $this->simpanHasilPemeriksaanLab($modPasien, $modPasienMasukPenunjangs[$ruangan]);
										}
										foreach($_POST['RJTindakanPelayananT'][$i] AS $iii => $tindakanPelayanan){
											if($modPasienMasukPenunjangs[$ruangan]['ruangan_id'] == $tindakanPelayanan['ruangan_id'] ){
												$dataTindakans[$iii] = $this->simpanTindakanPelayanan($modPendaftaran,$modPasienMasukPenunjangs[$ruangan],$tindakanPelayanan);

												if($tindakanPelayanan['ruangan_id'] == Params::RUANGAN_ID_LAB_KLINIK){
													if(!empty($modHasilPemeriksaan->hasilpemeriksaanlab_id)){
														$this->simpanDetailHasilPemeriksaanLab($modHasilPemeriksaan, $dataTindakans[$iii],$tindakanPelayanan);
													}
												}else if($tindakanPelayanan['ruangan_id'] == Params::RUANGAN_ID_LAB_ANATOMI){
													$modHasilPemeriksaanPA = $this->simpanHasilPemeriksaanPA($modPasienMasukPenunjangs[$i], $dataTindakans[$i][$ii], $tindakanPelayanan);
												}else if($tindakanPelayanan['ruangan_id'] == Params::RUANGAN_ID_RAD){
													$this->simpanHasilPemeriksaanRad($modPasienMasukPenunjangs[$ruangan], $dataTindakans[$iii],$tindakanPelayanan);
												}
											}

										}
									}
								}
							}

						}
					}
				}

				if($_POST['RJPendaftaranT']['is_adakarcis']){
					if(isset($_POST['RJKarcisV'])){
						if(count($_POST['RJKarcisV']) > 0){
							foreach($_POST['RJKarcisV'] as $i => $karcis){
								if($karcis['is_pilihtindakan']){
									$dataTindakans[$i] = $this->simpanKarcis($modTindakanKarcis, $modPendaftaran ,$karcis);
								}
							}
						}
						if(isset($_POST['RJPendaftaranT']['is_bayarkarcis'])){ //fitur belum ada >> RND-666
							if($_POST['RJPendaftaranT']['is_bayarkarcis']){ //jika di ceklis
							}
						}
					}
				}
				$this->karcistersimpan = true;
				$this->komponentindakantersimpan = true;
				if($_POST['RJPendaftaranT']['is_adakarcis']){
					if(isset($_POST['PPTindakanPelayananT'])){
						if(count($_POST['PPTindakanPelayananT']) > 0){
							foreach($_POST['PPTindakanPelayananT'] as $i => $karcis){
								if($karcis['is_pilihtindakan']){
									$dataTindakans[$i] = $this->simpanKarcis($modTindakan, $modPendaftaran ,$karcis);
								}
							}
						}
						if(isset($_POST['RJPendaftaranT']['is_bayarkarcis'])){ //fitur belum ada >> RND-666
							if($_POST['RJPendaftaranT']['is_bayarkarcis']){ //jika di ceklis
							}
						}
					}
				}

				if(!empty($_POST['RJPendaftaranT']['buatjanjipoli_id'])){
					$modJanjipoli = PPBuatJanjiPoliT::model()->findByPk($_POST['RJPendaftaranT']['buatjanjipoli_id']);
					$modJanjipoli->pendaftaran_id = $modPendaftaran->pendaftaran_id;
					$modJanjipoli->save();
				}

				if($this->konsulpolitersimpan && $this->permintaanmcutersimpan && $this->karcistersimpan && $this->komponentindakantersimpan){
					$transaction->commit();
					/* ================================================ */
					// SMS GATEWAY
					$modPegawai = $modPendaftaran->pegawai;
					$modRuangan = $modKonsul->politujuan;
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
						$attributes = $modKonsul->getAttributes();
						foreach($attributes as $attributes => $value){
							$isiPesan = str_replace("{{".$attributes."}}",$value,$isiPesan);
						}
						$attributes = $modRuangan->getAttributes();
						foreach($attributes as $attributes => $value){
							$isiPesan = str_replace("{{".$attributes."}}",$value,$isiPesan);
						}
						$isiPesan = str_replace("{{hari}}",MyFormatter::getDayName($modKonsul->tglkonsulpoli),$isiPesan);

						if($smsgateway->tujuansms == Params::TUJUANSMS_PASIEN && $smsgateway->statussms){
							if(!empty($modPasien->no_mobile_pasien)){
								$sms->kirim($modPasien->no_mobile_pasien,$isiPesan);
							}else{
								$smspasien = 0;
							}
						}
					}
					Yii::app()->user->setFlash('success',"Data berhasil disimpan");
					$this->redirect(array('index','pendaftaran_id'=>$pendaftaran_id, 'idKonsulPoli'=>$modKonsul->konsulpoli_id,'smspasien'=>$smspasien));
				}else{
					$transaction->rollback();
					Yii::app()->user->setFlash('error',"Data pasien gagal disimpan !");
				}
			} catch (Exception $exc) {
				$transaction->rollback();
				$btn_ulang = "<a class='btn btn-danger' href='javascript:document.location.reload();' rel='tooltip' title='Klik tombol ini lalu klik \"Resend\" '>"
						. "<i class='icon-refresh icon-white'></i> Simpan Ulang"
						. "</a>";
				Yii::app()->user->setFlash('error',"Data pasien gagal disimpan ! ".$btn_ulang." ".MyExceptionMessage::getMessage($exc,true));
			}
		}

		$modRiwayatKonsul = RJKonsulPoliT::model()->findAllByAttributes(array('pendaftaran_id'=>$pendaftaran_id, 'asalpoliklinikkonsul_id'=>$ruangan_id));

		$this->render($this->path_view.'index',array(
			'modPendaftaran'=>$modPendaftaran,
			'modPasien'=>$modPasien,
			'modKonsul'=>$modKonsul,
			'karcisTindakan'=>$karcisTindakan,
			'modRiwayatKonsul'=>$modRiwayatKonsul,
			'modelPendaftaran'=>$modelPendaftaran,
			'modJenisTarif'=>$modJenisTarif,
			'modPasienMasukPenunjang'=>$modPasienMasukPenunjang,
			'modPaketPelayanan'=>$modPaketPelayanan,
			'modPermintaanMcu'=>$modPermintaanMcu,
			'modPemeriksaanMcu'=>$modPemeriksaanMcu,
			'modTindakan'=>$modTindakan,
			'modTindakanKarcis'=>$modTindakanKarcis,
			'dataTindakans'=>$dataTindakans
		));
	}
        
	public function actionAjaxDetailKonsul()
	{
		if(Yii::app()->request->isAjaxRequest) {
		$konsulantarpoli_id = $_POST['idKonsulAntarPoli'];
		$modKonsulPoli = RJKonsulPoliT::model()->findByPk($konsulantarpoli_id);
		$data['result'] = $this->renderPartial($this->path_view.'_viewKonsulMCU', array('modKonsul'=>$modKonsulPoli), true);

		echo json_encode($data);
		 Yii::app()->end();
		}
	}
        
	public function actionAjaxBatalKonsul()
	{
		if(Yii::app()->request->isAjaxRequest) {
		$konsulantarpoli_id = (isset($_POST['idKonsulAntarPoli']) ? $_POST['idKonsulAntarPoli'] : null);
		$pendaftaran_id = (isset($_POST['pendaftaran_id']) ? $_POST['pendaftaran_id'] : null);

		$tindakanpelayanan = RJTindakanPelayananT::model()->findByAttributes(array('konsulpoli_id'=>$konsulantarpoli_id));
		if(count($tindakanpelayanan)){
			TindakankomponenT::model()->deleteAllByAttributes(array('tindakanpelayanan_id'=>$tindakanpelayanan->tindakanpelayanan_id));
			RJTindakanPelayananT::model()->deleteByPk($tindakanpelayanan->tindakanpelayanan_id);
		}

		RJKonsulPoliT::model()->deleteByPk($konsulantarpoli_id);
		$modRiwayatKonsul = RJKonsulPoliT::model()->findAllByAttributes(array('pendaftaran_id'=>$pendaftaran_id));

		$data['result'] = $this->renderPartial($this->path_view.'_listKonsulMCU', array('modRiwayatKonsul'=>$modRiwayatKonsul), true);

		echo json_encode($data);
		 Yii::app()->end();
		}
	}
        
	/**
	 * Function untuk pemeriksaan MCU (set checklist tindakan mcu)
	 */
	public function actionSetChecklistTindakanMcu(){
		if (Yii::app()->request->isAjaxRequest){
			$content = "";
			parse_str($_POST['data'], $post);
			$postPemeriksaan = $post['RJPaketpelayananM'];
			$criteria = new CdbCriteria();
			$criteria->compare('LOWER(namatindakan)',strtolower($postPemeriksaan['namatindakan']), true);
			$criteria->order = "tipepaket_id, namatindakan";
			$modPemeriksaanmcus = RJPaketpelayananM::model()->findAll($criteria);
			$content = $this->renderPartial($this->path_view.'_checklistPemeriksaanMcu',array('modPemeriksaanmcus'=>$modPemeriksaanmcus), true);
			echo CJSON::encode(array(
				'content'=>$content));
			Yii::app()->end();
		}
	}  
	
	/**
	 * Function untuk pemeriksaan MCU (set checklist tindakan mcu) diluar paket
	 */
	public function actionSetChecklistTindakanMcuDiluarPaket(){
		if (Yii::app()->request->isAjaxRequest){
			
			$content = "";
			$modPemeriksaan = array();
			parse_str($_POST['data'], $post);
			$postPemeriksaan = $post['RJPaketpelayananM'];
			
            $kelaspelayanan_id = (isset($_GET['kelaspelayanan_id']) ? $_GET['kelaspelayanan_id'] : Params::KELASPELAYANAN_ID_TANPA_KELAS);
            $tipepaket_id = (isset($_GET['tipepaket_id']) ? $_GET['tipepaket_id'] : Params::TIPEPAKET_ID_NONPAKET);
            $penjamin_id = (isset($_GET['penjamin_id']) ? $_GET['penjamin_id'] : Params::PENJAMIN_ID_UMUM);
            $modJenisTarif = JenistarifpenjaminM::model()->find('penjamin_id ='.$penjamin_id);
			$jenistarif_id = $modJenisTarif->jenistarif_id;
			$ruangan_id = array(Params::RUANGAN_ID_LAB_KLINIK,  Params::RUANGAN_ID_RAD, Params::RUANGAN_ID_KLINIK_MCU);
			$kelompoktindakan_id = array(Params::KELOMPOKTINDAKAN_ID_RAD,  Params::KELOMPOKTINDAKAN_ID_LAB, Params::KELOMPOKTINDAKAN_ID_MCU);
			
            if($tipepaket_id == Params::TIPEPAKET_ID_LUARPAKET)
            {
                $criteria = new CDbCriteria();
                $criteria->compare('LOWER(daftartindakan_nama)', strtolower($postPemeriksaan['namatindakan']), true);
                if(!empty($kelompoktindakan_id)){
					$criteria->addInCondition('kelompoktindakan_id',$kelompoktindakan_id);						
				}
                if(Yii::app()->user->getState('tindakanruangan')){
                    $criteria->addInCondition('ruangan_id',$ruangan_id);
                }
                if(Yii::app()->user->getState('tindakankelas')){
					if(!empty($kelaspelayanan_id)){
						$criteria->addCondition("kelaspelayanan_id = ".$kelaspelayanan_id);						
					}
                    $criteria->addCondition('tipepaket_id', Params::TIPEPAKET_ID_LUARPAKET);
                }
                if (isset($_GET['daftartindakan_id'])){
					if(!empty($_GET['daftartindakan_id'])){
						$criteria->addCondition("daftartindakan_id = ".$_GET['daftartindakan_id']);						
					}
                }
				if(!empty($kelaspelayanan_id)){
					$criteria->addCondition("kelaspelayanan_id = ".$kelaspelayanan_id);						
				}
                $criteria->order = 'ruangan_nama,daftartindakan_nama';
                $models = PaketpelayananV::model()->findAll($criteria);                    
                
				$content = $this->renderPartial($this->path_view.'_checklistPemeriksaanMcuDiluarPaket',array('modPemeriksaan'=>$modPemeriksaan), true);
				echo CJSON::encode(array(
					'content'=>$content));
				Yii::app()->end();
            } else if($tipepaket_id == Params::TIPEPAKET_ID_NONPAKET) {
                $criteria = new CDbCriteria();
                $criteria->compare('LOWER(daftartindakan_nama)', strtolower($postPemeriksaan['namatindakan']), true);
				if(!empty($kelaspelayanan_id)){
					$criteria->addCondition("kelaspelayanan_id = ".$kelaspelayanan_id);						
				}
				if(!empty($penjamin_id)){
					$criteria->addCondition("penjamin_id = ".$penjamin_id);						
				}
				if(!empty($kelompoktindakan_id)){
					$criteria->addInCondition("kelompoktindakan_id",$kelompoktindakan_id);						
				}
                $criteria->order = 'ruangan_nama,daftartindakan_nama';

                if (isset($_GET['daftartindakan_id'])){
					if(!empty($_GET['daftartindakan_id'])){
						$criteria->addCondition("daftartindakan_id = ".$_GET['daftartindakan_id']);						
					}
                }

                if(Yii::app()->user->getState('tindakankelas'))
                {
					if(!empty($kelaspelayanan_id)){
						$criteria->addCondition("kelaspelayanan_id = ".$kelaspelayanan_id);						
					}
                }
				
                if(Yii::app()->user->getState('tindakanruangan'))
                {
                    $criteria->addInCondition('ruangan_id',$ruangan_id);
                    $modPemeriksaan = RJTariftindakanperdaruanganV::model()->findAll($criteria);
                } else {
                    $modPemeriksaan = TariftindakanperdaV::model()->findAll($criteria);
                }
                $content = $this->renderPartial($this->path_view.'_checklistPemeriksaanMcuDiluarPaket',array('modPemeriksaan'=>$modPemeriksaan), true);
				echo CJSON::encode(array(
					'content'=>$content));
				Yii::app()->end();
            } else {
                $criteria = new CDbCriteria();
                $criteria->compare('LOWER(daftartindakan_nama)', strtolower($postPemeriksaan['namatindakan']), true);
                if (isset($_GET['daftartindakan_id'])){
					if(!empty($_GET['daftartindakan_id'])){
						$criteria->addCondition("daftartindakan_id = ".$_GET['daftartindakan_id']);						
					}
                }

                if(Yii::app()->user->getState('tindakanruangan')){
                    $criteria->addInCondition('ruangan_id',$ruangan_id);
                }

                if(Yii::app()->user->getState('tindakankelas')){
					if(!empty($kelaspelayanan_id)){
						$criteria->addCondition("kelaspelayanan_id = ".$kelaspelayanan_id);						
					}
                }

				if(!empty($tipepaket_id)){
					$criteria->addCondition("tipepaket_id = ".$tipepaket_id);						
				}
				if(!empty($kelaspelayanan_id)){
					$criteria->addCondition("kelaspelayanan_id = ".$kelaspelayanan_id);						
				}
                $criteria->order = 'ruangan_nama,daftartindakan_nama';
                $modPemeriksaan = PaketpelayananV::model()->find($criteria);				
				$content = $this->renderPartial($this->path_view.'_checklistPemeriksaanMcuDiluarPaket',array('modPemeriksaan'=>$modPemeriksaan), true);
				echo CJSON::encode(array(
					'content'=>$content));
				Yii::app()->end();
			}
		}  
	}
	
	
		
	/**
	 * proses simpan / ubah data permintaan mcu
	 * @return type
	 */
	public function simpanPermintaanMcu($modPendaftaran,$model,$post,$postTindakan){
		$format = new MyFormatter();
		$modPermintaanMcu = new RJPermintaanmcuT;
		$modPermintaanMcu->tindakanpelayanan_id = $postTindakan->tindakanpelayanan_id;
		$modPermintaanMcu->pendaftaran_id = $postTindakan->pendaftaran_id;
		$modPermintaanMcu->daftartindakan_id = $post['daftartindakan_id'];
		$modPermintaanMcu->tipepaket_id = $postTindakan->tipepaket_id;
		$modPermintaanMcu->paketpelayanan_id = $post['paketpelayanan_id'];
		$modPermintaanMcu->tglpermintaan = date('Y-m-d H:i:s');
		$modPermintaanMcu->tglrencanaperiksa = date('Y-m-d H:i:s');
		$modPermintaanMcu->noantrianperm = MyGenerator::noAntrian($postTindakan->ruangan_id);
		$modPermintaanMcu->pernahmcu = false;
		$modPermintaanMcu->keteranganpermintaan = "";
		$modPermintaanMcu->ruangantujuan_id = $post['ruangantujuan_id'];
		$modPermintaanMcu->tarifperpaketmcu = $post['tarif_tindakan'];
		$modPermintaanMcu->create_time = date('Y-m-d H:i:s');
		$modPermintaanMcu->update_time = date('Y-m-d H:i:s');
		$modPermintaanMcu->create_loginpemakai_id = Yii::app()->user->id;
		$modPermintaanMcu->update_loginpemakai_id = Yii::app()->user->id;
		$modPermintaanMcu->create_ruangan = Yii::app()->user->getState('ruangan_id');

		if($modPermintaanMcu->save()){
			$this->permintaanmcutersimpan = true;
		}else{
			$this->permintaanmcutersimpan = false;
		}
		return $modPermintaanMcu;
	}
	
	/**
	* Fungsi untuk menyimpan data ke model RJPasienMasukPenunjangT
	* @param type $modPendaftaran
	* @param type $modPasien
	* @return RJPasienMasukPenunjangT 
	*/
   public function simpanPasienMasukPenunjang($modPasienMasukPenunjang,$modPendaftaran,$ruangan_id){
		$modPasien = RJPasienM::model()->findByPk($modPendaftaran->pasien_id);
		$modPasienMasukPenunjang = new $modPasienMasukPenunjang;
		$modPasienMasukPenunjang->pendaftaran_id = $modPendaftaran->pendaftaran_id;
		$modPasienMasukPenunjang->kelaspelayanan_id = $modPendaftaran->kelaspelayanan_id;
		$modPasienMasukPenunjang->jeniskasuspenyakit_id = $modPendaftaran->jeniskasuspenyakit_id;
		$modPasienMasukPenunjang->pasienadmisi_id = $modPendaftaran->pasienadmisi_id;
		$modPasienMasukPenunjang->pegawai_id = $modPendaftaran->pegawai_id;
		$modPasienMasukPenunjang->pasien_id = $modPendaftaran->pasien_id;
		$modPasienMasukPenunjang->ruangan_id = $ruangan_id;
		$modPasienMasukPenunjang->ruanganasal_id = Yii::app()->user->getState('ruangan_id');
		$instalasi_id = $modPasienMasukPenunjang->ruangan->instalasi_id;
		$kode_instalasi = InstalasiM::model()->findByPk($instalasi_id)->instalasi_singkatan;
		$modPasienMasukPenunjang->kunjungan = CustomFunction::getKunjungan($modPasien, $modPasienMasukPenunjang->ruangan_id);
		$modPasienMasukPenunjang->statusperiksa = $modPendaftaran->statusperiksa;
		$modPasienMasukPenunjang->no_masukpenunjang = MyGenerator::noMasukPenunjang($kode_instalasi);
		$modPasienMasukPenunjang->tglmasukpenunjang = date("Y-m-d H:i:s");
		$modPasienMasukPenunjang->no_urutperiksa =  MyGenerator::noAntrianPenunjang($modPasienMasukPenunjang->ruangan_id);
		$modPasienMasukPenunjang->ruanganasal_id = $modPendaftaran->ruangan_id;
		$modPasienMasukPenunjang->create_ruangan = Yii::app()->user->getState('ruangan_id');
		$modPasienMasukPenunjang->create_loginpemakai_id = Yii::app()->user->id;
		$modPasienMasukPenunjang->create_time = date('Y-m-d H:i:s');
		$modPasienMasukPenunjang->panggilantrian = false;

		if ($modPasienMasukPenunjang->validate()){
			$modPasienMasukPenunjang->save();
			$this->pasienpenunjangtersimpan &= true;
		}else{
			$this->pasienpenunjangtersimpan &= false;
		}
		return $modPasienMasukPenunjang;
	}
   
   
	/**
	* proses simpan LKTindakanPelayananT dan LKTindakanKomponenT
	*/
	public function simpanTindakanPelayanan($modPendaftaran, $modPasienMasukPenunjang, $post){
		$modTindakan = new RJTindakanPelayananT();
		$modPemeriksaanLab = RJPemeriksaanLabM::model()->find('daftartindakan_id = '.$post['daftartindakan_id']);
		$modPemeriksaanRad = RJPemeriksaanRadM::model()->find('daftartindakan_id = '.$post['daftartindakan_id']);
		
		$modTindakan->attributes = $modPendaftaran->attributes;
		$modTindakan->attributes = $modPasienMasukPenunjang->attributes;
		$modTindakan->pendaftaran_id = $modPendaftaran->pendaftaran_id;
		$modTindakan->attributes = $post;
		$modTindakan->instalasi_id = $modTindakan->ruangan->instalasi_id;
		//RND-9000
		if(empty($modTindakan->tipepaket_id) || ($modTindakan->tipepaket_id == Params::TIPEPAKET_ID_NONPAKET)){
			$modTindakan->tarif_satuan = $modTindakan->getTarifSatuan(); 
		}
		$modTindakan->karcis_id = (isset($post['karcis_id']) ? $post['karcis_id'] : null);
		$modTindakan->jenistarif_id = Params::JENISTARIF_ID_PELAYANAN;
		if(!empty($modTindakan->karcis_id)){
			$this->karcistersimpan = true;
			if(isset($post['harga_tariftindakan'])){ //jika dari form karcis
				if(!empty($post['harga_tariftindakan'])){
					$modTindakan->tarif_satuan = $post['harga_tariftindakan'];
				}
			}
			$modTindakan->tipepaket_id = $this->tipePaketKarcis($modPendaftaran, $modTindakan->karcis_id, $modTindakan->daftartindakan_id);
		}
		$modTindakan->create_time = date("Y-m-d H:i:s");
		$modTindakan->create_loginpemakai_id = Yii::app()->user->id;
		$modTindakan->create_ruangan = Yii::app()->user->getState('ruangan_id');
		$modTindakan->shift_id =Yii::app()->user->getState('shift_id');
		$modTindakan->dokterpemeriksa1_id=$modPasienMasukPenunjang->pegawai_id;
		$modTindakan->perawat_id = (!empty($modPasienMasukPenunjang->perawat_id) ? $modPasienMasukPenunjang->perawat_id : null);
		$modTindakan->tgl_tindakan=date('Y-m-d H:i:s');
		$modTindakan->satuantindakan='Kali';
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
		
	
	 /**
	* simpan LBHasilPemeriksaanLabT
	*/
	public function simpanHasilPemeriksaanLab($modPasien, $modPasienMasukPenunjang){
		$modHasilPemeriksaan = new RJHasilPemeriksaanLabT;
		$modHasilPemeriksaan->attributes = $modPasienMasukPenunjang->attributes;
		$modHasilPemeriksaan->nohasilperiksalab = MyGenerator::noHasilPemeriksaanLK();
		$modHasilPemeriksaan->tglhasilpemeriksaanlab = $modPasienMasukPenunjang->tglmasukpenunjang;
		$modHasilPemeriksaan->hasil_kelompokumur = CustomFunction::getKelompokUmur($modPasien->tanggal_lahir);
		$modHasilPemeriksaan->hasil_jeniskelamin = $modPasien->jeniskelamin;
		$modHasilPemeriksaan->statusperiksahasil = Params::STATUSPERIKSAHASIL_BELUM;
		$modHasilPemeriksaan->create_ruangan = Yii::app()->user->getState('ruangan_id');
		if($modHasilPemeriksaan->validate()){
			$modHasilPemeriksaan->save();
		}else{
			$this->hasilpemeriksaantersimpan &= false;
		}
		return $modHasilPemeriksaan;
	}
		
	/**
	* simpan RJDetailHasilPemeriksaanLabT
	*/
	 public function simpanDetailHasilPemeriksaanLab($modHasilPemeriksaan, $modTindakan, $post){
	   $modDetailHasilPemeriksaans = array();
	   $modPemeriksaanLab = RJPemeriksaanLabM::model()->find('daftartindakan_id = '.$post['daftartindakan_id']);
	   $pemeriksaanlab_id = isset($modPemeriksaanLab->pemeriksaanlab_id) ? $modPemeriksaanLab->pemeriksaanlab_id : null;
	   $date1 = new DateTime($modTindakan->pendaftaran->tgl_pendaftaran);
	   $date2 = new DateTime($modTindakan->pasien->tanggal_lahir);
	   $umurhari = $date2->diff($date1)->format("%a");
	   $criteria = new CDbCriteria();
		if(!empty($pemeriksaanlab_id)){
			$criteria->addCondition('pemeriksaanlab_id = '.$pemeriksaanlab_id);
		}
	   $criteria->addCondition("'".$umurhari."' BETWEEN hariminlab AND harimakslab");
	   $criteria->compare('LOWER(nilairujukan_jeniskelamin)',strtolower($modHasilPemeriksaan->pasien->jeniskelamin), true);
	   $criteria->order = 'pemeriksaanlabdet_nourut ASC';
	   
	   $modPemeriksaanLadDet = PemeriksaanlabdetV::model()->findAll($criteria);

	   if(count($modPemeriksaanLadDet) > 0){
		   foreach($modPemeriksaanLadDet AS $i=>$pemeriksaanDet){
			   $modDetailHasilPemeriksaans[$i] = new RJDetailHasilPemeriksaanLabT;
			   $modDetailHasilPemeriksaans[$i]->tindakanpelayanan_id = $modTindakan->tindakanpelayanan_id;
			   $modDetailHasilPemeriksaans[$i]->pemeriksaanlabdet_id = $pemeriksaanDet->pemeriksaanlabdet_id;
			   $modDetailHasilPemeriksaans[$i]->pemeriksaanlab_id = $pemeriksaanDet->pemeriksaanlab_id;
			   $modDetailHasilPemeriksaans[$i]->hasilpemeriksaanlab_id = $modHasilPemeriksaan->hasilpemeriksaanlab_id;
			   $modDetailHasilPemeriksaans[$i]->nilairujukan = $pemeriksaanDet->nilairujukan_nama;
			   $modDetailHasilPemeriksaans[$i]->hasilpemeriksaan_satuan = $pemeriksaanDet->nilairujukan_satuan;
			   $modDetailHasilPemeriksaans[$i]->hasilpemeriksaan_metode = $pemeriksaanDet->nilairujukan_metode;
			   $modDetailHasilPemeriksaans[$i]->create_time = date("Y-m-d H:i:s");
			   $modDetailHasilPemeriksaans[$i]->create_loginpemakai_id = Yii::app()->user->id;
			   $modDetailHasilPemeriksaans[$i]->create_ruangan = Yii::app()->user->getState('ruangan_id');
			   
			   if($modDetailHasilPemeriksaans[$i]->validate()){
					$modDetailHasilPemeriksaans[$i]->save();
					$modTindakan->detailhasilpemeriksaanlab_id = $modDetailHasilPemeriksaans[$i]->detailhasilpemeriksaanlab_id;
					$modTindakan->update();
			   }else{
				   $this->hasilpemeriksaantersimpan &= false;
			   }
		   }
	   }
	   return $modDetailHasilPemeriksaans;
   }

	/**
	 * simpan LBHasilPemeriksaanPAT
	 */
	public function simpanHasilPemeriksaanPA($modPasienMasukPenunjang, $modTindakan, $post){
		$modHasilPemeriksaanPA = new RJHasilPemeriksaanPAT;
		$modHasilPemeriksaanPA->attributes = $modPasienMasukPenunjang->attributes;
		$modHasilPemeriksaanPA->tindakanpelayanan_id = $modTindakan->tindakanpelayanan_id;
		$modHasilPemeriksaanPA->pemeriksaanlab_id = $post['pemeriksaanlab_id'];
		$modHasilPemeriksaanPA->nosediaanpa = MyGenerator::noSediaanPA();
		$modHasilPemeriksaanPA->tglperiksapa = $modPasienMasukPenunjang->tglmasukpenunjang;
		$modHasilPemeriksaanPA->create_time = date("Y-m-d H:i:s");
		$modHasilPemeriksaanPA->create_loginpemakai_id = Yii::app()->user->id;
		$modHasilPemeriksaanPA->create_ruangan = Yii::app()->user->getState('ruangan_id');

		if($modHasilPemeriksaanPA->validate()){
			$modHasilPemeriksaanPA->save();
			$modTindakan->hasilpemeriksaanpa_id = $modHasilPemeriksaanPA->hasilpemeriksaanpa_id;
			$modTindakan->update();
		}else{
			$this->hasilpemeriksaantersimpan = false;
		}

	}

	/**
	 * Fungsi untuk menyimpan data ke model LBPengambilanSampleT
	 */
	public function simpanPengambilanSample($modPasienMasukPenunjang, $post){
		$modPengambilanSample = new RJPengambilanSampleT;
		$modPengambilanSample->attributes = $post;
		$modPengambilanSample->tglpengambilansample = $modPasienMasukPenunjang->tglmasukpenunjang;
		$modPengambilanSample->pasienmasukpenunjang_id = $modPasienMasukPenunjang->pasienmasukpenunjang_id;            
		if ($modPengambilanSample->validate()){
			$modPengambilanSample->save();
			$this->pengambilansampletersimpan &= true;
		}else{
			$this->pengambilansampletersimpan &= false;
		}

		return $modPengambilanSample;
	}
        
	/**
	* simpan RJHasilpemeriksaanradT
	*/
	public function simpanHasilPemeriksaanRad($modPasienMasukPenunjang, $modTindakan, $post){
		$modHasilPemeriksaan = new RJHasilpemeriksaanradT;
		$modPemeriksaanRad = RJPemeriksaanRadM::model()->find('daftartindakan_id = '.$post['daftartindakan_id']);
		$modHasilPemeriksaan->attributes = $modPasienMasukPenunjang->attributes;
		$modHasilPemeriksaan->tindakanpelayanan_id = $modTindakan->tindakanpelayanan_id;
		$modHasilPemeriksaan->pemeriksaanrad_id = $modPemeriksaanRad->pemeriksaanrad_id;
		$modHasilPemeriksaan->tglpemeriksaanrad = $modPasienMasukPenunjang->tglmasukpenunjang;
		$modHasilPemeriksaan->create_time = date("Y-m-d H:i:s");
		$modHasilPemeriksaan->create_loginpemakai_id = Yii::app()->user->id;
		$modHasilPemeriksaan->create_ruangan = Yii::app()->user->getState('ruangan_id');;

		if($modHasilPemeriksaan->validate()){
			$modHasilPemeriksaan->save();
			//RND-8272
			$dataBroker = $modHasilPemeriksaan->getDataBroker();
			if(!empty($dataBroker)){
				CustomFunction::postHL7Broker("ADD",$dataBroker);
			}
			
			$modTindakan->hasilpemeriksaanrad_id = $modHasilPemeriksaan->hasilpemeriksaanrad_id;
			$modTindakan->update();
		}else{
			$this->hasilpemeriksaantersimpan = false;
		}

	}
	
	/**
	 * menampilkan karcis
	 */
	public function actionSetKarcis(){
		if(Yii::app()->request->isAjaxRequest) { 
			$format = new MyFormatter();
			$modTindakan = new RJTindakanPelayananKarcisT;
			$kelaspelayanan_id=$_POST['kelaspelayanan_id'];
			$ruangan_id = $_POST['ruangan_id'];
			$pasien_id = $_POST['pasien_id'];
			$penjamin_id = $_POST['penjamin_id'];
			$form='';
			if(!empty($ruangan_id)){
				$is_pasienbaru = 'true';
				if(!empty($pasien_id)){
					$modPasien = PasienM::model()->findByPk($pasien_id);
					if(isset($modPasien)){
						$is_pasienbaru = ($modPasien->statusrekammedis == Params::STATUSREKAMMEDIS_AKTIF) ? 'false' : 'true';
					}
				}
				$criteria = new CdbCriteria();
				$criteria->addCondition("kelaspelayanan_id = ".$kelaspelayanan_id);
				$criteria->addCondition("ruangan_id = ".$ruangan_id);
				$criteria->addCondition("penjamin_id = ".$penjamin_id);
				if(Yii::app()->user->getState('karcisbarulama')){ //RND-7737
					$criteria->addCondition("pasienbaru_karcis = $is_pasienbaru");
				}
				$modKarcisV=KarcisV::model()->findAll($criteria);
				if(count($modKarcisV) > 0){
					$form = "<table width='100%'>";
					$form .= "<thead>";
					$form .= "<th>Karcis</th>";
					$form .= "<th>Harga</th>";
					$form .= "<th>Pilih</th>";
					$form .= "</thead>";
					foreach($modKarcisV AS $i =>$karcis){
						$modTindakan->attributes = $karcis->attributes;
						if ($i == 0 ){
						$modTindakan->is_pilihtindakan = 1;
						$modTindakan->karcis_id = $karcis->karcis_id;
						$modTindakan->jenistarif_id = $karcis->jenistarif_id;
						$modTindakan->tarif_satuan = $format->formatNumberForUser($karcis->harga_tariftindakan);
						$form .='<tr class="checked">
								<td>'.CHtml::label($karcis['karcis_nama'],$karcis['karcis_nama']).'</td>
								<td style="text-align:right;">'.CHtml::activeTextField($modTindakan, '['.$i.']tarif_satuan',array('readonly'=>true, 'class'=>'span1 integer', 'style'=>'width:96px;text-align:right;')).'</td>
								<td><a data-karcis="'.$karcis['karcis_id'].'"id="selectPasien" class="btn-small" href="javascript:void(0);" onclick="pilihKarcis(this);return false;">
									<i class="icon-form-check"></i>
									</a>'
								.CHtml::activeHiddenField($modTindakan, '['.$i.']is_pilihtindakan',array('readonly'=>true, 'class'=>'span1'))  
								.CHtml::activeHiddenField($modTindakan, '['.$i.']daftartindakan_id',array('readonly'=>true, 'class'=>'span1'))  
								.CHtml::activeHiddenField($modTindakan, '['.$i.']karcis_id',array('readonly'=>true, 'class'=>'span1'))  
								.CHtml::activeHiddenField($modTindakan, '['.$i.']jenistarif_id',array('readonly'=>true, 'class'=>'span1'))  
							.'</td>'
							.'</tr>';
						}
					}
					$form .= "</table>";
				}
			}
			$data['listKarcis']=$form;
			echo json_encode($data);
			Yii::app()->end();
		}
	}
	
	/**
	 * proses simpan konsultasi Poli
	 * @param type $modKonsul
	 * @param type $post
	 * @return type
	 */
	public function simpanKonsulPoli($modKonsul, $post){
		$pendaftaran_id = isset($_GET['pendaftaran_id']) ? $_GET['pendaftaran_id'] : null;
		$format = new MyFormatter();
		$modKonsul->attributes = $post;
		$modKonsul->tglkonsulpoli = $format->formatDateTimeForDb($modKonsul->tglkonsulpoli);		
		$modKonsul->create_ruangan = Yii::app()->user->getState('ruangan_id');
		$modKonsul->create_loginpemakai_id = Yii::app()->user->id;
		$modKonsul->create_time = date('Y-m-d H:i:s');
		
		$ruangan_id = $modKonsul->ruangan_id;
		if($modKonsul->save()){
			$this->konsulpolitersimpan = true;
			$dat = PasienpulangT::model()->findByAttributes(array(
                            // 'carakeluar_id'=>Params::CARAKELUAR_ID_RAWATINAP,
                            'pendaftaran_id'=>$pendaftaran_id
                        ));
                        $adm = PasienadmisiT::model()->findByAttributes(array(
                            // 'carakeluar_id'=>Params::CARAKELUAR_ID_RAWATINAP,
                            'pendaftaran_id'=>$pendaftaran_id
                        ));
                        if (!(!empty($adm) || !empty($dat))) $updateStatusPeriksa=PendaftaranT::model()->updateByPk($pendaftaran_id,array('statusperiksa'=>Params::STATUSPERIKSA_SEDANG_PERIKSA));
			/* ================================================ */
			/* Proses update status periksa KonsulPoli EHS-179  */
			/* ================================================ */
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
		}else{
			$this->konsulpolitersimpan = false;
		}

		return $modKonsul;
	}
	
	public function actionPrint()
	{
		$modKonsul = new RJKonsulPoliT;
		$pendaftaran_id = (isset($_GET['id']) ? $_GET['id'] : null);
		$konsulpoli_id = (isset($_GET['idKonsulPoli']) ? $_GET['idKonsulPoli'] : null);
		$modPendaftaran = RJPendaftaranT::model()->findByPk($pendaftaran_id);

		$modRiwayatKonsul = RJKonsulPoliT::model()->findAllByAttributes(array('pendaftaran_id'=>$pendaftaran_id,'konsulpoli_id'=>$konsulpoli_id));

		$judulLaporan='Permintaan Konsultasi Poliklinik';
		$caraPrint=$_REQUEST['caraPrint'];
		if($caraPrint=='PRINT') {
			$this->layout='//layouts/printWindows';
			$this->render($this->path_view.'Print',array('modPendaftaran'=>$modPendaftaran,'modRiwayatKonsul'=>$modRiwayatKonsul,'modKonsul'=>$modKonsul,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint));
		}
		else if($caraPrint=='EXCEL') {
			$this->layout='//layouts/printExcel';
			$this->render($this->path_view.'Print',array('modPendaftaran'=>$modPendaftaran,'modRiwayatKonsul'=>$modRiwayatKonsul,'modKonsul'=>$modKonsul,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint));
		}
		else if($_REQUEST['caraPrint']=='PDF') {
			$ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
			$posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
			$mpdf = new MyPDF('',$ukuranKertasPDF); 
			$mpdf->useOddEven = 2;  
			$stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
			$mpdf->WriteHTML($stylesheet,1);  
			$mpdf->AddPage($posisi,'','','','',15,15,15,15,15,15);
			$mpdf->WriteHTML($this->renderPartial($this->path_view.'Print',array('modPendaftaran'=>$modPendaftaran,'modRiwayatKonsul'=>$modRiwayatKonsul,'modKonsul'=>$modKonsul,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint),true));
			$mpdf->Output();
		}                       
	}

	public function actionPrintRiwayat()
	{
		$modKonsul = new RJKonsulPoliT;
		$pendaftaran_id = (isset($_GET['id']) ? $_GET['id'] : null);
		$modPendaftaran = RJPendaftaranT::model()->findByPk($pendaftaran_id);
		$modRiwayatKonsul = RJKonsulPoliT::model()->findAllByAttributes(array('pendaftaran_id'=>$pendaftaran_id));

		$judulLaporan='Permintaan Konsultasi Poliklinik';
		$caraPrint=$_REQUEST['caraPrint'];
		if($caraPrint=='PRINT') {
			$this->layout='//layouts/printWindows';
			$this->render($this->path_view.'printRiwayat',array('modPendaftaran'=>$modPendaftaran,'modRiwayatKonsul'=>$modRiwayatKonsul,'modKonsul'=>$modKonsul,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint));
		}
		else if($caraPrint=='EXCEL') {
			$this->layout='//layouts/printExcel';
			$this->render($this->path_view.'printRiwayat',array('modPendaftaran'=>$modPendaftaran,'modRiwayatKonsul'=>$modRiwayatKonsul,'modKonsul'=>$modKonsul,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint));
		}
		else if($_REQUEST['caraPrint']=='PDF') {
			$ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
			$posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
			$mpdf = new MyPDF('',$ukuranKertasPDF); 
			$mpdf->useOddEven = 2;  
			$stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
			$mpdf->WriteHTML($stylesheet,1);  
			$mpdf->AddPage($posisi,'','','','',15,15,15,15,15,15);
			$mpdf->WriteHTML($this->renderPartial($this->path_view.'printRiwayat',array('modPendaftaran'=>$modPendaftaran,'modRiwayatKonsul'=>$modRiwayatKonsul,'modKonsul'=>$modKonsul,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint),true));
			$mpdf->Output();
		}                       
	}
}