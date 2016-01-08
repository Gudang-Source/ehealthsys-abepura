<?php
class PendaftaranPasienController extends MyAuthController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column1';
	public $defaultAction = 'index';
	public $path_view = "mcu.views.pendaftaranPasien.";
        
	public $pasientersimpan = false;
	public $pendaftarantersimpan = false;
	public $karcistersimpan = false;
	public $komponentindakantersimpan = false;
	public $asuransipasientersimpan = false;
	public $septersimpan = false;
	public $permintaanmcutersimpan = false;
	public $rujukantersimpan = false;
	public $rujukankeluartersimpan = false;
	public $pengambilansampletersimpan = true; //dilooping / boleh tanpa ini
	public $pasienpenunjangtersimpan = true; //dilooping
	public $hasilpemeriksaantersimpan = true; //dilooping
	
        
	/**
	 * Index transaksi pendaftaran
	 */
	public function actionIndex($id = null, $idSep = null)
	{
            $format = new MyFormatter();
            $model=new MCPendaftaranT;
            $modPasien=new MCPasienM;
            $modRujukan=new MCRujukanT;
            $modRujukanBpjs=new MCRujukanbpjsT;
            $modTindakan=new MCTindakanPelayananT;
            $modTindakanKarcis=new MCTindakanPelayananKarcisT;
            $modPembayaran = new MCPembayaranpelayananT();
            $modAntrian=new MCAntrianT;
            $modAsuransiPasien=new MCAsuransipasienM;
            $modAsuransiPasienBpjs =new MCAsuransipasienbpjsM;
			$modAsuransiPasienBadak =new MCAsuransipasienbadakM();
            $modAsuransiPasienDepartemen =new MCAsuransipasiendepartemenM();
            $modAsuransiPasienPekerja =new MCAsuransipasienpegawaiM();
            $modSep=new MCSepT;
			$modPaketPelayanan = new MCPaketpelayananM;
			$modPasienMasukPenunjang = new MCPasienmasukpenunjangT;
			$modPermintaanMcu = new MCPermintaanmcuT();
			$modPemeriksaanMcu = new PermintaanmcuT();
			$modPegawai = new MCPegawaiM;
			
			$modHasilPemeriksaan= new MCHasilPemeriksaanLabT;
            $modHasilPemeriksaanPA= new MCHasilPemeriksaanPAT;
            $modDetailHasilPemeriksaan = new MCDetailHasilPemeriksaanLabT;
            $modPengambilanSample = new MCPengambilanSampleT;
			$modHasilPemeriksaanRad= new MCHasilpemeriksaanradT;
            $dataTindakans = array();
            $modPasien->propinsi_id = Yii::app()->user->getState('propinsi_id');
            $modPasien->kabupaten_id = Yii::app()->user->getState('kabupaten_id');
            $modPasien->kecamatan_id = Yii::app()->user->getState('kecamatan_id');
            $modPasien->warga_negara = Params::DEFAULT_WARGANEGARA;
            $modPasien->agama = Params::DEFAULT_AGAMA;
            $model->is_adakarcis = Yii::app()->user->getState('iskarcis'); //RND-7737
            $model->is_bpjs = 0;
			$modPemeriksaanMcu->tglrencanaperiksa = date('Y-m-d H:i:s');
            
            if(isset($_POST['buatjanjipoli_id'])){
                if(!empty($_POST['buatjanjipoli_id'])){
                    $modJanjipoli = MCBuatJanjiPoliT::model()->findByPk($_POST['buatjanjipoli_id']);
                    if(!empty($modJanjipoli->pasien_id)){
                        $modPasien = MCPasienM::model()->findByPk($modJanjipoli->pasien_id);
                        $modPasien->tanggal_lahir = date('d/m/Y',strtotime($modPasien->tanggal_lahir));
                        $modPasien->no_rekam_medik = null;
                        $modPasien->pasien_id = null;
                    }
                    if(!empty($modJanjipoli->ruangan_id))
                        $model->ruangan_id = $modJanjipoli->ruangan_id;
                    if(!empty($modJanjipoli->pegawai_id))
                        $model->pegawai_id = $modJanjipoli->pegawai_id;
                }
            }
            
            //==load data
            if(isset($id)){
                $model = $this->loadModel($id);
                if(isset($idSep)){
                    $model->is_bpjs = 1; 
                    $modRujukanBpjs= MCRujukanbpjsT::model()->findByPk($model->rujukan_id);
                    $modAsuransiPasienBpjs = MCAsuransipasienbpjsM::model()->findByPk($model->asuransipasien_id);
                }
                $modPasien = MCPasienM::model()->findByPk($model->pasien_id);
//                if(!empty($model->penanggungjawab_id)){
//                    $modPenanggungJawab=MCPenanggungJawabM::model()->findByPk($model->penanggungjawab_id);
//                }
//                if(!empty($model->rujukan_id)){
//                    $modRujukan=MCRujukanT::model()->findByPk($model->rujukan_id);
//                }
                $dataTindakans=MCTindakanPelayananT::model()->findByAttributes(array('pendaftaran_id'=>$model->pendaftaran_id),"karcis_id is not null");
                $modAntrian->tglantrian = $format->formatDateTimeForUser($modAntrian->tglantrian);
				$modPermintaanMcu = MCPermintaanmcuT::model()->findByAttributes(array('pendaftaran_id'=>$model->pendaftaran_id));
            }

            if(isset($idSep)){
                $modSep= MCSepT::model()->findByPk($idSep);
            }

            $pasien_id = (isset($_GET['pasien_id']) ? $_GET['pasien_id'] : null);
            if(!empty($pasien_id)){
                $modPasien = MCPasienM::model()->findByPk($pasien_id);
                $modPasien->tanggal_lahir = date('d/m/Y',strtotime($modPasien->tanggal_lahir));
            }

            if(isset($_POST['MCPendaftaranT']))
            {   
                $transaction = Yii::app()->db->beginTransaction();
                try {
                    $modPasien = $this->simpanPasien($modPasien, $_POST['MCPasienM']);

                    if($_POST['MCPendaftaranT']['is_bpjs']){
                        if(isset($_POST['MCRujukanbpjsT'])){
                            $modRujukanBpjs = $this->simpanRujukanBpjs($modRujukanBpjs, $_POST['MCRujukanbpjsT']);
                        }
                    }else{
                        $this->rujukantersimpan = true; 
                    }
                    
                    if(isset($_POST['MCAsuransipasienM'])){
                        if(isset($_POST['MCAsuransipasienM']['asuransipasien_id'])){
                            if(!empty($_POST['MCAsuransipasienM']['asuransipasien_id'])){
                                $modAsuransiPasien = MCAsuransipasienM::model()->findByPk($_POST['MCAsuransipasienM']['asuransipasien_id']);
                            }
                        }
						$modAsuransiPasien = $this->simpanAsuransiPasien($modAsuransiPasien, $_POST['MCPendaftaranT'], $modPasien, $_POST['MCAsuransipasienM']);
                    }else{
                        $this->asuransipasientersimpan = true;
                    }
					
                    if(isset($_POST['MCAsuransipasienbpjsM'])){
						if(isset($_POST['MCAsuransipasienbpjsM']['asuransipasien_id'])){
							if(!empty($_POST['MCAsuransipasienbpjsM']['asuransipasien_id'])){
								$modAsuransiPasienBpjs = MCAsuransipasienM::model()->findByPk($_POST['MCAsuransipasienbpjsM']['asuransipasien_id']);
							}
						}
						$modAsuransiPasienBpjs = $this->simpanAsuransiPasien($modAsuransiPasienBpjs, $_POST['MCPendaftaranT'], $modPasien, $_POST['MCAsuransipasienbpjsM']);
					}else{
						$this->asuransipasientersimpan = true;
					}
					
                    if(isset($_POST['MCAsuransipasienbadakM'])){
						if(isset($_POST['MCAsuransipasienbadakM']['asuransipasien_id'])){
							if(!empty($_POST['MCAsuransipasienbadakM']['asuransipasien_id'])){
								$modAsuransiPasienBadak = MCAsuransipasienM::model()->findByPk($_POST['MCAsuransipasienbadakM']['asuransipasien_id']);
							}
						}
						$modAsuransiPasienBadak = $this->simpanAsuransiPasien($modAsuransiPasienBadak, $_POST['MCPendaftaranT'], $modPasien, $_POST['MCAsuransipasienbadakM']);
					}else{
						$this->asuransipasientersimpan = true;
					}
					
                    if(isset($_POST['MCAsuransipasiendepartemenM'])){
						if(isset($_POST['MCAsuransipasiendepartemenM']['asuransipasien_id'])){
							if(!empty($_POST['MCAsuransipasiendepartemenM']['asuransipasien_id'])){
								$modAsuransiPasienDepartemen = MCAsuransipasienM::model()->findByPk($_POST['MCAsuransipasiendepartemenM']['asuransipasien_id']);
							}
						}
						$modAsuransiPasienDepartemen = $this->simpanAsuransiPasien($modAsuransiPasienDepartemen, $_POST['MCPendaftaranT'], $modPasien, $_POST['MCAsuransipasiendepartemenM']);
					}else{
						$this->asuransipasientersimpan = true;
					}
					
                    if(isset($_POST['MCAsuransipasienpegawaiM'])){
						if(isset($_POST['MCAsuransipasienpegawaiM']['asuransipasien_id'])){
							if(!empty($_POST['MCAsuransipasienpegawaiM']['asuransipasien_id'])){
								$modAsuransiPasienPekerja = MCAsuransipasienM::model()->findByPk($_POST['MCAsuransipasienpegawaiM']['asuransipasien_id']);
							}
						}
						$modAsuransiPasienPekerja = $this->simpanAsuransiPasien($modAsuransiPasienPekerja, $_POST['MCPendaftaranT'], $modPasien, $_POST['MCAsuransipasienpegawaiM']);
					}else{
						$this->asuransipasientersimpan = true;
					}
                    

                    if($_POST['MCPendaftaranT']['is_bpjs']){
                        $model = $this->simpanPendaftaran($model,$modPasien,$modRujukanBpjs,$_POST['MCPendaftaranT'], $_POST['MCPasienM'],$modAsuransiPasienBpjs);
                        $modSep = $this->simpanSep($model,$modPasien,$modRujukanBpjs,$modAsuransiPasienBpjs,$_POST['MCSepT']);
                    }else{
                        $model = $this->simpanPendaftaran($model,$modPasien,$modRujukan,$_POST['MCPendaftaranT'], $_POST['MCPasienM'],$modAsuransiPasien);
                    }
					
					$tmpmcu = array();					
					if(isset($_POST['MCPermintaanmcuT'])){
						if(count($_POST['MCPermintaanmcuT']) > 0){
							foreach($_POST['MCPermintaanmcuT'] as $i=>$tindakanmcu){
								foreach($tindakanmcu as $ii=>$tindakans){
									$tmpmcu[$tindakans['ruangantujuan_id']][] = $tindakans['daftartindakan_id'];
								}
								foreach($tmpmcu as $ruangan => $daftartindakan)
								{
									if($ruangan == Params::RUANGAN_ID_LAB_ANATOMI || $ruangan == Params::RUANGAN_ID_LAB_KLINIK || $ruangan == Params::RUANGAN_ID_RAD || $ruangan == Params::RUANGAN_ID_LAB){
										$modPasienMasukPenunjangs[$ruangan] = $this->simpanPasienMasukPenunjang($modPasienMasukPenunjang,$model,$ruangan);									
										if(isset($_POST['MCPermintaanmcuT'][$i])){
											if(count($_POST['MCPermintaanmcuT'][$i]) > 0){
												if($ruangan == Params::RUANGAN_ID_LAB_KLINIK || $ruangan == Params::RUANGAN_ID_LAB){
													$modHasilPemeriksaan = $this->simpanHasilPemeriksaanLab($modPasien, $modPasienMasukPenunjangs[$ruangan]);
												}
												foreach($_POST['MCPermintaanmcuT'][$i] AS $iii => $tindakanPelayanan){
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
										foreach($_POST['MCPermintaanmcuT'][$i] AS $iii => $tindakanPelayanan){
											$modPasienMasukPenunjangs[$ruangan] = $this->simpanPasienMasukPenunjang($modPasienMasukPenunjang,$model,$ruangan);									
											$dataTindakans[$iii] = $this->simpanTindakanPelayanan($model,$modPasienMasukPenunjangs[$ruangan],$tindakanPelayanan);
											$dataPermintaans[$iii] = $this->simpanPermintaanMcu($model,$modPermintaanMcu,$tindakanPelayanan,$dataTindakans[$iii]);										
										}
									}
								}

							}
						}
					}
					
					
					$tmp = array();
					if(isset($_POST['MCTindakanPelayananT'])){
						if(count($_POST['MCTindakanPelayananT']) > 0){
							$this->permintaanmcutersimpan = true;
							foreach($_POST['MCTindakanPelayananT'] as $i=>$tindakan){	
								foreach($tindakan as $ii=>$tindakans){
									$tmp[$tindakans['ruangan_id']][] = $tindakans['daftartindakan_id'];
								}
								foreach($tmp as $ruangan => $daftartindakan)
								{
									$modPasienMasukPenunjangs[$ruangan] = $this->simpanPasienMasukPenunjang($modPasienMasukPenunjang,$model,$ruangan);									
									if(isset($_POST['MCTindakanPelayananT'][$i])){		
										if(count($_POST['MCTindakanPelayananT'][$i]) > 0){
											if($ruangan == Params::RUANGAN_ID_LAB_KLINIK){
												$modHasilPemeriksaan = $this->simpanHasilPemeriksaanLab($modPasien, $modPasienMasukPenunjangs[$ruangan]);
											}
											foreach($_POST['MCTindakanPelayananT'][$i] AS $iii => $tindakanPelayanan){
												if($modPasienMasukPenunjangs[$ruangan]['ruangan_id'] == $tindakanPelayanan['ruangan_id'] ){
													$dataTindakans[$iii] = $this->simpanTindakanPelayanan($model,$modPasienMasukPenunjangs[$ruangan],$tindakanPelayanan);

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
						
                    if($_POST['MCPendaftaranT']['is_adakarcis']){
                        if(isset($_POST['MCKarcisV'])){
                            if(count($_POST['MCKarcisV']) > 0){
                                foreach($_POST['MCKarcisV'] as $i => $karcis){
                                    if($karcis['is_pilihtindakan']){
                                        $dataTindakans[$i] = $this->simpanKarcis($modTindakanKarcis, $model ,$karcis);
                                    }
                                }
                            }
                            if(isset($_POST['MCPendaftaranT']['is_bayarkarcis'])){ //fitur belum ada >> RND-666
                                if($_POST['MCPendaftaranT']['is_bayarkarcis']){ //jika di ceklis
                                }
                            }
                        }
                    }
                    
					$this->karcistersimpan = true;
                    $this->komponentindakantersimpan = true;
                    if($this->pasientersimpan && $this->pendaftarantersimpan && $this->karcistersimpan && $this->komponentindakantersimpan && $this->asuransipasientersimpan && $this->permintaanmcutersimpan){
                        $transaction->commit();
                        //Di set di form >> Yii::app()->user->setFlash('success', "Data pasien berhasil disimpan !");
//                      RND-666 >>>  $this->redirect(array('view','id'=>$model->pendaftaran_id,'sukses'=>1));
                        if($this->septersimpan){
                            $this->redirect(array('index','id'=>$model->pendaftaran_id,'idSep'=>$modSep->sep_id,'sukses'=>1));
                        }else{
                            $this->redirect(array('index','id'=>$model->pendaftaran_id,'sukses'=>1));
                        }
                        
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
            
            $this->render('index',array(
                'model'=>$model,
                'modPasien'=>$modPasien,
                'modRujukan'=>$modRujukan,
                'modRujukanBpjs'=>$modRujukanBpjs,
                'modTindakan'=>$modTindakan,
                'modAntrian'=>$modAntrian,
                'modAsuransiPasien'=>$modAsuransiPasien,
                'modAsuransiPasienBpjs'=>$modAsuransiPasienBpjs,
                'dataTindakans'=>$dataTindakans,
                'modSep'=>$modSep,
				'modPaketPelayanan'=>$modPaketPelayanan,
				'modPasienMasukPenunjang'=>$modPasienMasukPenunjang,
				'modPermintaanMcu'=>$modPermintaanMcu,
				'modPegawai'=>$modPegawai,
				'modAsuransiPasienBadak'=>$modAsuransiPasienBadak,
				'modAsuransiPasienDepartemen'=>$modAsuransiPasienDepartemen,
				'modAsuransiPasienPekerja'=>$modAsuransiPasienPekerja,
				'modPemeriksaanMcu'=>$modPemeriksaanMcu,
				'modTindakanKarcis'=>$modTindakanKarcis
            ));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=MCPendaftaranT::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
            if(isset($_POST['ajax']) && $_POST['ajax']==='pppendaftaran-t-form')
            {
                echo CActiveForm::validate($model);
                Yii::app()->end();
            }
	}
        
	/**
	 * proses simpan / ubah data pasien
	 * @param type $modPasien
	 * @param type $post
	 * @return type
	 */
	public function simpanPasien($modPasien, $post){
		$format = new MyFormatter();
		if(isset($post['pasien_id']) && (!empty($post['pasien_id']))){
			$load = new $modPasien;
			$modPasien = $load->findByPk($post['pasien_id']);
		}
		$modPasien->attributes = $post;
		$modPasien->tanggal_lahir = $format->formatDateTimeForDb($modPasien->tanggal_lahir);
		$modPasien->kelompokumur_id = CustomFunction::getKelompokUmur($modPasien->tanggal_lahir);
		if(isset($post['tempPhoto'])){
			$modPasien->photopasien = $post['tempPhoto'];
		}
		if(empty($modPasien->pasien_id)){
			$modPasien->tgl_rekam_medik = date('Y-m-d H:i:s');
			$modPasien->profilrs_id = Params::DEFAULT_PROFIL_RUMAH_SAKIT;
			$modPasien->statusrekammedis = Params::STATUSREKAMMEDIS_AKTIF;
			$modPasien->ispasienluar = FALSE;
			$modPasien->create_ruangan = Yii::app()->user->getState('ruangan_id');
			$modPasien->create_loginpemakai_id = Yii::app()->user->id;
			$modPasien->create_time = date('Y-m-d H:i:s');
			$modPasien->no_rekam_medik = MyGenerator::noRekamMedik();
		}else{
			$modPasien->update_loginpemakai_id = Yii::app()->user->id;
			$modPasien->update_time = date('Y-m-d H:i:s');
		}
		$modPasien->kelurahan_id = (!empty($modPasien->kelurahan_id) ? $modPasien->kelurahan_id : null);
		$modPasien->statusrekammedis = Params::STATUSREKAMMEDIS_AKTIF;
		
		if($modPasien->save()){
			$this->pasientersimpan = true;
		}

		return $modPasien;
	}
	/**
	 * proses simpan / ubah data pendaftaran
	 * @return type
	 */
	public function simpanPendaftaran($model,$modPasien,$modRujukan,$post, $postPasien, $modAsuransiPasien){
		$format = new MyFormatter();
		$model->attributes = $post;
		$model->pasien_id = $modPasien->pasien_id;
		$model->rujukan_id = $modRujukan->rujukan_id;
		$model->instalasi_id = (isset($model->ruangan_id) ? $model->ruangan->instalasi_id : null);
		$model->no_urutantri = MyGenerator::noAntrian($model->ruangan_id);
		$model->golonganumur_id = CustomFunction::getGolonganUmur($modPasien->tanggal_lahir);
		$model->umur = CustomFunction::getUmur($modPasien->tanggal_lahir);
		$model->statusperiksa = Params::STATUSPERIKSA_ANTRIAN;
		$model->statuspasien = (empty($postPasien['pasien_id']) ? Params::STATUSPASIEN_BARU : Params::STATUSPASIEN_LAMA);
		$model->kunjungan = CustomFunction::getKunjungan($modPasien, $model->ruangan_id);
		$model->shift_id = Yii::app()->user->getState('shift_id');
		$model->create_ruangan = Yii::app()->user->getState('ruangan_id');
		$model->create_loginpemakai_id = Yii::app()->user->id;
		$model->create_time = date("Y-m-d H:i:s");
		if(Yii::app()->user->getState('tgltransaksimundur') && !empty($model->tgl_pendaftaran)){
			$model->tgl_pendaftaran = $format->formatDateTimeForDb($model->tgl_pendaftaran);
		}else{
			$model->tgl_pendaftaran = date("Y-m-d H:i:s");
		}
		$model->no_pendaftaran = MyGenerator::noPendaftaran($model->instalasi_id, $model->tgl_pendaftaran);
		$model->kelompokumur_id = (!empty($modPasien->kelompokumur_id) ? $modPasien->kelompokumur_id : CustomFunction::getKelompokUmur($modPasien->tanggal_lahir));
		$model->statusmasuk = (!empty($model->rujukan_id) ? Params::STATUSMASUK_RUJUKAN : Params::STATUSMASUK_NONRUJUKAN);
		$model->tgl_konfirmasi = $format->formatDateTimeForDb($model->tgl_konfirmasi);
		$model->tglselesaiperiksa = $format->formatDateTimeForDb($model->tglselesaiperiksa);
		$model->tglrenkontrol = $format->formatDateTimeForDb($model->tglrenkontrol);
		$model->asuransipasien_id = $modAsuransiPasien->asuransipasien_id;

		$modRuangan = MCRuanganM::model()->findByPk($model->ruangan_id);
		$estimasipelayanan = isset($modRuangan->estimasipelayanan) ? $modRuangan->estimasipelayanan : 15;

		$tgl_awal = date('Y-m-d');
		$tgl_akhir = date('Y-m-d');
		$criteria = new CDbCriteria();
		$criteria->addCondition('ruangan_id = '.$model->ruangan_id);
		$criteria->addBetweenCondition('DATE(tgl_pendaftaran)', $tgl_awal, $tgl_akhir);
		$criteria->order = 'tgl_pendaftaran DESC';
		$dataPendaftaran = MCPendaftaranT::model()->find($criteria);

		if(count($dataPendaftaran) > 0 && $dataPendaftaran->tglakandilayani != null){
			$tanggal = strtotime($dataPendaftaran->tglakandilayani.' + '.$estimasipelayanan.' minute');
			$tglakandilayani = date('Y-m-d H:i:s', $tanggal);

			if( $tglakandilayani < $model->tgl_pendaftaran){
				$tglakandilayani = strtotime($tglakandilayani.' + '.$estimasipelayanan.' minute');
				$tglakandilayani = date('Y-m-d H:i:s', $tglakandilayani);
				$model->tglakandilayani = $tglakandilayani;
			}else{
				$tglakandilayani = strtotime($model->tgl_pendaftaran.' + '.$estimasipelayanan.' minute');
				$tglakandilayani = date('Y-m-d H:i:s', $tglakandilayani);
				$model->tglakandilayani = $tglakandilayani;
			}
		}else{
			$tanggal = strtotime($model->tgl_pendaftaran.' + '.$estimasipelayanan.' minute');
			$tglakandilayani = date('Y-m-d H:i:s', $tanggal);
			$model->tglakandilayani = $tglakandilayani;
		}
		
		$model->tglrenkontrol = $format->formatDateTimeForDb($model->tgl_pendaftaran);
		$model->tglrenkontrol = strtotime($model->tglrenkontrol.' + 1 years');
		$model->tglrenkontrol = date('Y-m-d H:i:s',$model->tglrenkontrol);
		if($model->save()){
			if(!empty($model->antrian_id)){
				MCAntrianT::model()->updateByPk($model->antrian_id,array('pendaftaran_id'=>$model->pendaftaran_id));
			}
			$this->pendaftarantersimpan = true;
		}else{
			$this->pendaftarantersimpan = false;
		}
		return $model;
	}
		
	/**
	 * proses simpan / ubah data permintaan mcu
	 * @return type
	 */
	public function simpanPermintaanMcu($model,$modPermintaanMcu,$post,$postTindakan){
		$format = new MyFormatter();
		$modPermintaanMcu = new MCPermintaanmcuT;
		$modPermintaanMcu->attributes = $post;
		$modPermintaanMcu->tindakanpelayanan_id = $postTindakan->tindakanpelayanan_id;
		$modPermintaanMcu->pendaftaran_id = $model->pendaftaran_id;
		$modPermintaanMcu->daftartindakan_id = $post['daftartindakan_id'];
		$modPermintaanMcu->tipepaket_id = $post['tipepaket_id'];
		$modPermintaanMcu->paketpelayanan_id = $post['paketpelayanan_id'];
		$modPermintaanMcu->tglpermintaan = date('Y-m-d H:i:s');
		$modPermintaanMcu->tglrencanaperiksa = isset($_POST['PermintaanmcuT']['tglrencanaperiksa']) ? $format->formatDateTimeForDb($_POST['PermintaanmcuT']['tglrencanaperiksa']) : date('Y-m-d H:i:s');
		$modPermintaanMcu->noantrianperm = MyGenerator::noAntrian($model->ruangan_id);
		$modPermintaanMcu->pernahmcu = isset($_POST['PermintaanmcuT']['pernahmcu']) ? $_POST['PermintaanmcuT']['pernahmcu'] : false;
		$modPermintaanMcu->keteranganpermintaan = isset($_POST['PermintaanmcuT']['keteranganpermintaan']) ? $_POST['PermintaanmcuT']['keteranganpermintaan'] : "";
		$modPermintaanMcu->ruangantujuan_id = $post['ruangantujuan_id'];
		$modPermintaanMcu->tarifperpaketmcu = $post['tarif_satuan'];
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
	 * proses simpan data penanggungjawab pasien
	 * @param type $modPenanggungjawab
	 * @param type $post
	 * @return type
	 */
	public function simpanPenanggungjawab($modPenanggungjawab, $post){
		$format = new MyFormatter;
		$modPenanggungjawab->attributes = $post;
		$modPenanggungjawab->tgllahir_pj = $format->formatDateTimeForDb($modPenanggungjawab->tgllahir_pj);

		if($modPenanggungjawab->save()){
			$this->penanggungjawabtersimpan = true;
		}
		return $modPenanggungjawab;
	}
	
	/**
	 * proses simpan data rujukan
	 * @param type $modRujukan
	 * @param type $post
	 * @return type
	 */
	public function simpanRujukan($modRujukan, $post){
		$format = new MyFormatter();
		$modRujukan->attributes = $post;
		$modRujukan->kddiagnosa_rujukan = isset($post['kddiagnosa_rujukan']) ? ((count($post['kddiagnosa_rujukan'])>0) ? implode(', ', $post['kddiagnosa_rujukan']) : '') : '';
		$modRujukan->diagnosa_rujukan = isset($post['diagnosa_rujukan']) ? ((count($post['diagnosa_rujukan'])>0) ? implode(', ', $post['diagnosa_rujukan']) : '') : '';
		$modRujukan->tanggal_rujukan = $format->formatDateTimeForDb($modRujukan->tanggal_rujukan);

		if($modRujukan->save()){
			$this->rujukantersimpan = true;
		}
		return $modRujukan;
	}
	
	/**
	 * proses simpan data rujukan
	 * @param type $modRujukan
	 * @param type $post
	 * @return type
	 */
	public function simpanRujukanBpjs($modRujukanBpjs, $post){
		$format = new MyFormatter();
		$modRujukanBpjs->attributes = $post;
		$modRujukanBpjs->kddiagnosa_rujukan = isset($post['kddiagnosa_rujukan']) ? ((count($post['kddiagnosa_rujukan'])>0) ? implode(', ', $post['kddiagnosa_rujukan']) : '') : '';
		$modRujukanBpjs->diagnosa_rujukan = isset($post['diagnosa_rujukan']) ? ((count($post['diagnosa_rujukan'])>0) ? implode(', ', $post['diagnosa_rujukan']) : '') : '';
		$modRujukanBpjs->tanggal_rujukan = $format->formatDateTimeForDb($modRujukanBpjs->tanggal_rujukan);

		if($modRujukanBpjs->save()){
			$this->rujukantersimpan = true;
		}
		return $modRujukanBpjs;
	}
	
	
	/**
	 * proses simpan karcis
	 * @param type $modTindakan
	 * @param type $post
	 * @return type
	 */
	public function simpanKarcis($modTindakan, $model, $post){
		$modTindakan->attributes = $post;
		$modTindakan->create_time = date("Y-m-d H:i:s");
		$modTindakan->create_loginpemakai_id = Yii::app()->user->id;
		$modTindakan->instalasi_id=Yii::app()->user->getState("instalasi_id");
		$modTindakan->ruangan_id = Yii::app()->user->getState('ruangan_id');
		$modTindakan->pendaftaran_id=$model->pendaftaran_id;
		$modTindakan->kelaspelayanan_id=$model->kelaspelayanan_id;
		$modTindakan->shift_id =Yii::app()->user->getState('shift_id');
		$modTindakan->carabayar_id=$model->carabayar_id;
		$modTindakan->penjamin_id=$model->penjamin_id;
		$modTindakan->jeniskasuspenyakit_id=$model->jeniskasuspenyakit_id;
		$modTindakan->pasien_id=$model->pasien_id;
		$modTindakan->dokterpemeriksa1_id=$model->pegawai_id;
		$modTindakan->karcis_id=$post['karcis_id'];
		$modTindakan->tgl_tindakan=date('Y-m-d H:i:s');
		$modTindakan->qty_tindakan=1;
		$modTindakan->tarif_satuan = $modTindakan->getTarifSatuan(); //RND-7250
		$modTindakan->tarif_tindakan=$modTindakan->tarif_satuan * $modTindakan->qty_tindakan;
		$modTindakan->satuantindakan=Params::SATUAN_TINDAKAN_PENDAFTARAN;
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

		if(!empty($modTindakan->karcis_id)){
			$modTindakan->tipepaket_id = $this->tipePaketKarcis($model, $modTindakan->karcis_id, $modTindakan->daftartindakan_id);
		}

		if($modTindakan->save()){
			$this->komponentindakantersimpan &= $modTindakan->saveTindakanKomponen();
			$this->karcistersimpan = true;
		}else{
			$this->karcistersimpan = false;
		}

		return $modTindakan;
	}

	/**
	 * simpan asuransi pasien
	 * @param type $modAsuransiPasien
	 * @param type $postPendaftaran
	 * @param type $postPasien
	 * @param type $postAsuransiPasien
	 * @return type
	 */
	public function simpanAsuransiPasien($modAsuransiPasien, $postPendaftaran, $postPasien, $postAsuransiPasien){
		$format = new MyFormatter();
		$modAsuransiPasien->attributes = $postAsuransiPasien;
		$modAsuransiPasien->pasien_id = isset($postPasien['pasien_id'])?$postPasien['pasien_id']:null;
		$modAsuransiPasien->penjamin_id = isset($postPendaftaran['penjamin_id'])?$postPendaftaran['penjamin_id']:null;
		$modAsuransiPasien->carabayar_id = isset($postPendaftaran['carabayar_id'])?$postPendaftaran['carabayar_id']:null;
		$modAsuransiPasien->create_loginpemakai_id = Yii::app()->user->id;
		$modAsuransiPasien->create_time = date("Y-m-d H:i:s");
		$modAsuransiPasien->tgl_konfirmasi = $format->formatDateTimeForDb($modAsuransiPasien->tgl_konfirmasi);
		if($modAsuransiPasien->save()){
			$this->asuransipasientersimpan = true;
		}
		return $modAsuransiPasien;
	}

	public function simpanSep($model,$modPasien,$modRujukanBpjs,$modAsuransiPasienBpjs,$postSep){
		$reqSep = null;
		$modSep = new MCSepT;
		$bpjs = new Bpjs();

		$modSep->tglsep = date('Y-m-d H:i:s');
		$modSep->nokartuasuransi = $modAsuransiPasienBpjs->nopeserta;
		$modSep->tglrujukan = $modRujukanBpjs->tanggal_rujukan;
		$modSep->norujukan = $modRujukanBpjs->no_rujukan;
		$modSep->ppkrujukan = $postSep['ppkrujukan']; 
		$modSep->ppkpelayanan = Yii::app()->user->getState('ppkpelayanan');
		$modSep->jnspelayanan = ($model->instalasi_id==Params::INSTALASI_ID_RI)?Params::JENISPELAYANAN_RI:Params::JENISPELAYANAN_RJ;
		$modSep->catatansep = $postSep['catatansep'];
		$data_diagnosa = explode(', ', $modRujukanBpjs->diagnosa_rujukan);
		$modSep->diagnosaawal = isset($data_diagnosa[0])?$data_diagnosa[0]:'';
		$modSep->politujuan = $model->ruangan_id;
		$modSep->klsrawat = $modAsuransiPasienBpjs->kelastanggunganasuransi_id;
		$modSep->tglpulang = date('Y-m-d H:i:s');
		$modSep->create_time = date('Y-m-d H:i:s');
		$modSep->create_loginpemakai_id = Yii::app()->user->id;
		$modSep->create_ruangan = Yii::app()->user->getState('ruangan_id');

		$reqSep = json_decode($bpjs->create_sep($modSep->nokartuasuransi, $modSep->tglsep, $modSep->tglrujukan, $modSep->norujukan, $modSep->ppkrujukan, $modSep->ppkpelayanan, $modSep->jnspelayanan, $modSep->catatansep, $modSep->diagnosaawal, $modSep->politujuan, $modSep->klsrawat, Yii::app()->user->id, $modPasien->no_rekam_medik, $model->pendaftaran_id),true);

		if ($reqSep['metadata']['code']==200) {
			$modSep->nosep = $reqSep['response'];
			if($modSep->save()){
				$this->septersimpan = true;
			}
		}

		return $modSep;
	}
        
	/**
	 * menentukan tipepaket_id
	 * @param type $modPendaftaran
	 * @param type $karcis_id
	 * @param type $idTindakan
	 * @return type
	 */
	public function tipePaketKarcis($modPendaftaran,$karcis_id,$tindakan_id)
	{
		$criteria = new CDbCriteria;
		$criteria->with = array('tipepaket');
		$criteria->addCondition("daftartindakan_id = ".$tindakan_id);
		$criteria->addCondition("tipepaket.carabayar_id = ".$modPendaftaran->carabayar_id);
		$criteria->addCondition("tipepaket.penjamin_id = ".$modPendaftaran->penjamin_id);
		$criteria->addCondition("tipepaket.kelaspelayanan_id = ".$modPendaftaran->kelaspelayanan_id);
		$paket = PaketpelayananM::model()->find($criteria);
		$result = Params::TIPEPAKET_ID_NONPAKET;
		if(isset($paket)) $result = $paket->tipepaket_id;

		return $result;
	}
        
	/**
	 * untuk menampilkan pasien lama dari autocomplete
	 * 1. no_rekam_medik
	 * 2. no_identitas_pasien
	 * 3. nama_pasien
	 * 4. nama_bin (alias)
	 */
	public function actionAutocompletePasienLama()
    {
		if(Yii::app()->request->isAjaxRequest) {
			$format = new MyFormatter();
			$returnVal = array();
			$no_rekam_medik = isset($_GET['no_rekam_medik']) ? $_GET['no_rekam_medik'] : null;
			$no_identitas_pasien = isset($_GET['no_identitas_pasien']) ? $_GET['no_identitas_pasien'] : null;
			$nama_pasien = isset($_GET['nama_pasien']) ? $_GET['nama_pasien'] : null;
			$tanggal_lahir = isset($_GET['tanggal_lahir']) ? $format->formatDateTimeForDb($_GET['tanggal_lahir']) : null;
			$criteria = new CDbCriteria();
			$criteria->compare('LOWER(no_rekam_medik)', strtolower($no_rekam_medik), true);
			$criteria->compare('LOWER(no_identitas_pasien)', strtolower($no_identitas_pasien), true);
			$criteria->compare('LOWER(nama_pasien)', strtolower($nama_pasien), true);
			$criteria->compare('tanggal_lahir', $tanggal_lahir);
			$criteria->addCondition('ispasienluar = FALSE');
			$criteria->order = 'no_rekam_medik, nama_pasien';
			$criteria->limit = 50;
			$models = PasienM::model()->findAll($criteria);
			foreach($models as $i=>$model)
			{
				$attributes = $model->attributeNames();
				foreach($attributes as $j=>$attribute) {
					$returnVal[$i]["$attribute"] = $model->$attribute;
				}
				$returnVal[$i]['label'] = $model->no_rekam_medik.' - '.$model->nama_pasien.(!empty($model->nama_bin) ? "(".$model->nama_bin.")" : "")." - ".(!empty($model->nama_ayah) ? $model->nama_ayah : "(nama ayah tidak ada)")." - ".$format->formatDateTimeForUser($model->tanggal_lahir);
				$returnVal[$i]['value'] = $model->no_rekam_medik;
			}

			echo CJSON::encode($returnVal);
		}else
			throw new CHttpException(403,'Tidak dapat mengurai data');
		Yii::app()->end();
    }
	
	public function actionAutocompleteAsuransi()
    {
		if(Yii::app()->request->isAjaxRequest) {
			$format = new MyFormatter();
			$returnVal = array();
			$nopeserta = isset($_GET['nopeserta']) ? $_GET['nopeserta'] : '';
			$penjamin_id = isset($_GET['penjamin_id']) ? $_GET['penjamin_id'] : null;
			$pasien_id = isset($_GET['pasien_id']) ? $_GET['pasien_id'] : null;
			$criteria = new CDbCriteria();
			$criteria->compare('LOWER(nopeserta)', strtolower($nopeserta),true);
			$criteria->addCondition('penjamin_id='.$penjamin_id);
			$criteria->addCondition('asuransipasien_aktif is true');
			if($_GET['pasien_id'] == ""){
				$criteria->addCondition('pasien_id is null');
			}else{
				$criteria->addCondition('pasien_id='.$pasien_id);
			}
			$criteria->order = 'namapemilikasuransi';
			$criteria->limit = 5;
			$models = MCAsuransipasienM::model()->findAll($criteria);
			foreach($models as $i=>$model)
			{
				$attributes = $model->attributeNames();
				foreach($attributes as $j=>$attribute) {
					$returnVal[$i]["$attribute"] = $model->$attribute;
				}
				$returnVal[$i]['label'] = $model->nopeserta.' - '.$model->namapemilikasuransi;
				$returnVal[$i]['value'] = $model->nopeserta;
				$returnVal[$i]['asuransipasien_id'] = $model->asuransipasien_id;
				$returnVal[$i]['nokartuasuransi'] = $model->nokartuasuransi;
				$returnVal[$i]['namapemilikasuransi'] = $model->namapemilikasuransi;
				$returnVal[$i]['jenispeserta_id'] = $model->jenispeserta_id;
				$returnVal[$i]['nomorpokokperusahaan'] = $model->nomorpokokperusahaan;
				$returnVal[$i]['namaperusahaan'] = $model->namaperusahaan;
				$returnVal[$i]['kelastanggunganasuransi_id'] = $model->kelastanggunganasuransi_id;
			}
			echo CJSON::encode($returnVal);
		}else
			throw new CHttpException(403,'Tidak dapat mengurai data');
		Yii::app()->end();
    }

    public function actionAutocompleteAsuransiKartu()
    {
		if(Yii::app()->request->isAjaxRequest) {
			$format = new MyFormatter();
			$returnVal = array();
			$nokartuasuransi = isset($_GET['nokartuasuransi']) ? $_GET['nokartuasuransi'] : '';
			$penjamin_id = isset($_GET['penjamin_id']) ? $_GET['penjamin_id'] : null;
			$pasien_id = isset($_GET['pasien_id']) ? $_GET['pasien_id'] : null;
			$criteria = new CDbCriteria();
			$criteria->compare('LOWER(nokartuasuransi)', strtolower($nokartuasuransi),true);
			$criteria->addCondition('penjamin_id='.$penjamin_id);
			if($_GET['pasien_id'] == ""){
				$criteria->addCondition('pasien_id is null');
			}else{
				$criteria->addCondition('pasien_id='.$pasien_id);
			}
			$criteria->order = 'namapemilikasuransi';
			$criteria->limit = 5;
			$models = MCAsuransipasienM::model()->findAll($criteria);
			foreach($models as $i=>$model)
			{
				$attributes = $model->attributeNames();
				foreach($attributes as $j=>$attribute) {
					$returnVal[$i]["$attribute"] = $model->$attribute;
				}
				$returnVal[$i]['label'] = $model->nokartuasuransi.' - '.$model->namapemilikasuransi;
				$returnVal[$i]['value'] = $model->nokartuasuransi;
				$returnVal[$i]['asuransipasien_id'] = $model->asuransipasien_id;
				$returnVal[$i]['nopeserta'] = $model->nopeserta;
				$returnVal[$i]['namapemilikasuransi'] = $model->namapemilikasuransi;
				$returnVal[$i]['jenispeserta_id'] = $model->jenispeserta_id;
				$returnVal[$i]['nomorpokokperusahaan'] = $model->nomorpokokperusahaan;
				$returnVal[$i]['namaperusahaan'] = $model->namaperusahaan;
				$returnVal[$i]['kelastanggunganasuransi_id'] = $model->kelastanggunganasuransi_id;
			}
			echo CJSON::encode($returnVal);
		}else
			throw new CHttpException(403,'Tidak dapat mengurai data');
		Yii::app()->end();
    }
	
	/**
	* menampilkan data asuransi terakhir pasien
	* @throws CHttpException
	*/
	public function actionSetAsuransiPasienLama(){
	   if(Yii::app()->getRequest()->getIsAjaxRequest()) {
		   $data = array();
		   $criteria = new CDbCriteria();
		   $criteria->addCondition("pasien_id = ".$_POST['pasien_id']);
		   $criteria->order = 'asuransipasien_id DESC';
		   $model = AsuransipasienM::model()->find($criteria);
		   $attributes = $model->attributeNames();
		   foreach($attributes as $j=>$attribute) {
			   $data["$attribute"] = $model->$attribute;
		   }
		   $data["penjamin_nama"] = $model->penjamin->penjamin_nama;
		   $data['listPenjamin'] = "";
		   $penjamin = PenjaminpasienM::model()->findAllByAttributes(array('carabayar_id'=>$model->carabayar_id, 'penjamin_aktif'=>true), array('order'=>'penjamin_nama ASC'));
		   if(count($penjamin) > 1)
		   {
			   $data['listPenjamin'] .= CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
		   }
		   $penjamin = CHtml::listData($penjamin,'penjamin_id','penjamin_nama');
		   foreach($penjamin as $value=>$name) {
			   $data['listPenjamin'] .= CHtml::tag('option', array('value'=>$value),CHtml::encode($name),true);
		   }
		   echo CJSON::encode($data);
	   }else
		   throw new CHttpException(403,'Tidak dapat mengurai data');
	   Yii::app()->end();
	}

	/**
	 * Ngeset data asuransi badak jika pasien telah memiliki data di asuransipasien_m
	 * @param type $encode
	 * @param type $namaModel
	 */
	public function actionSetAsuransiBadak()
        {
            if(Yii::app()->getRequest()->getIsAjaxRequest()) {
				$data = array();
				if((!empty($_POST['pasien_id']))&&(!empty($_POST['penjamin_id']))){
					$criteria = new CDbCriteria();
					$criteria->addCondition("pasien_id = ".$_POST['pasien_id']);
					$criteria->addCondition("penjamin_id = ".$_POST['penjamin_id']);
					$criteria->order = 'asuransipasien_id DESC';
					$model = AsuransipasienM::model()->find($criteria);
					if(count($model)>0){
						$attributes = $model->attributeNames();
						foreach($attributes as $j=>$attribute) {
							$data["$attribute"] = $model->$attribute;
						}
						$data['listPenjamin'] = "";
						$penjamin = PenjaminpasienM::model()->findAllByAttributes(array('carabayar_id'=>$model->carabayar_id, 'penjamin_aktif'=>true), array('order'=>'penjamin_nama ASC'));
						if(count($penjamin) > 1)
						{
							$data['listPenjamin'] .= CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
						}
						$penjamin = CHtml::listData($penjamin,'penjamin_id','penjamin_nama');
						foreach($penjamin as $value=>$name) {
							$data['listPenjamin'] .= CHtml::tag('option', array('value'=>$value),CHtml::encode($name),true);
						}
					}else{
						$data=null;
						$pegawai_id = isset($_POST['pegawai_id'])?$_POST['pegawai_id']:'';
						if(!empty($pegawai_id)){
							$modPegawai = PegawaiM::model()->findByPk($pegawai_id);
							$data['nopeserta'] = $modPegawai->nomorindukpegawai;
							$data['namaperusahaan'] = $modPegawai->unit_perusahaan;
							$data['namapemilikasuransi'] = $modPegawai->nama_pegawai;
							$data['namaperusahaan'] = 'PT. Badak LNG';
						}
					}
				}else{
					$pegawai_id = isset($_POST['pegawai_id'])?$_POST['pegawai_id']:'';
					if(!empty($pegawai_id)){
						$modPegawai = PegawaiM::model()->findByPk($pegawai_id);
						$data['nopeserta'] = $modPegawai->nomorindukpegawai;
						$data['namaperusahaan'] = $modPegawai->unit_perusahaan;
						$data['namapemilikasuransi'] = $modPegawai->nama_pegawai;
						$data['namaperusahaan'] = 'PT. Badak LNG';
					}
				}
				echo CJSON::encode($data);
			}else
				throw new CHttpException(403,'Tidak dapat mengurai data');
			Yii::app()->end();
        }
	/**
	 * Mengurai data pasien berdasarkan pasien_id
	 * @throws CHttpException
	 */
	public function actionGetDataPasien()
	{
		if(Yii::app()->request->isAjaxRequest) {
			$format = new MyFormatter();
			$pasien_id = isset($_POST['pasien_id']) ? $_POST['pasien_id'] : null;
			$no_rekam_medik = isset($_POST['no_rekam_medik']) ? $_POST['no_rekam_medik'] : null;
			$returnVal = array();
			$criteria = new CDbCriteria();
			if(!empty($pasien_id)){$criteria->addCondition("pasien_id = ".$pasien_id); }
			if(!empty($no_rekam_medik)){$criteria->addCondition("no_rekam_medik = '".$no_rekam_medik."'"); }
			$criteria->addCondition('ispasienluar = FALSE');
			$model = PasienM::model()->find($criteria);
			$attributes = $model->attributeNames();
			foreach($attributes as $j=>$attribute) {
				$returnVal["$attribute"] = $model->$attribute;
			}
			$returnVal["tanggal_lahir"] = date("d/m/Y",strtotime($model->tanggal_lahir));
			if(!empty($model->pegawai_id)){
				$returnVal['nomorindukpegawai'] = $model->pegawai->nomorindukpegawai;
				$returnVal['nama_pegawai'] = $model->pegawai->nama_pegawai;
				$returnVal['gelardepan'] = $model->pegawai->gelardepan;
				$returnVal['unit_perusahaan'] = $model->pegawai->unit_perusahaan;
				$returnVal['gelarbelakang_nama'] = isset($model->pegawai->gelarbelakang->gelarbelakang_nama) ? $model->pegawai->gelarbelakang->gelarbelakang_nama : "";
				$returnVal['jabatan_nama'] = isset($model->pegawai->jabatan->jabatan_nama) ? $model->pegawai->jabatan->jabatan_nama : "";
				$returnVal["nomorindukpegawai"] = $model->pegawai->nomorindukpegawai;
			}
			echo CJSON::encode($returnVal);
		}
		Yii::app()->end();
	}
	/**
	 * Mengatur dropdown kabupaten
	 * @param type $encode jika = true maka return array jika false maka set Dropdown 
	 * @param type $model_nama
	 * @param type $attr
	 */
	public function actionSetDropdownKabupaten($encode=false,$model_nama='',$attr='')
	{
		if(Yii::app()->request->isAjaxRequest) {
			$modPasien = new MCPasienM;
			if($model_nama !=='' && $attr == ''){
				$propinsi_id = $_POST["$model_nama"]['propinsi_id'];
			}
			 elseif ($model_nama == '' && $attr !== '') {
				$propinsi_id = $_POST["$attr"];
			}
			 elseif ($model_nama !== '' && $attr !== '') {
				$propinsi_id = $_POST["$model_nama"]["$attr"];
			}
			$kabupaten = null;
			if($propinsi_id){
				$kabupaten = $modPasien->getKabupatenItems($propinsi_id);
				$kabupaten = CHtml::listData($kabupaten,'kabupaten_id','kabupaten_nama');
			}
			if($encode){
				echo CJSON::encode($kabupaten);
			} else {
				if(empty($kabupaten)){
					echo CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
				} else {
					echo CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
					foreach($kabupaten as $value=>$name) {
						echo CHtml::tag('option', array('value'=>$value),CHtml::encode($name),true);
					}
				}
			}
		}
		Yii::app()->end();
	}
	
	/**
	 * Mengatur dropdown kecamatan
	 * @param type $encode jika = true maka return array jika false maka set Dropdown 
	 * @param type $model_nama
	 * @param type $attr
	 */
	public function actionSetDropdownKecamatan($encode=false,$model_nama='',$attr='')
	{
		if(Yii::app()->request->isAjaxRequest) {
			$modPasien = new MCPasienM;
			if($model_nama !=='' && $attr == ''){
				$kabupaten_id = $_POST["$model_nama"]['kabupaten_id'];
			}
			 elseif ($model_nama == '' && $attr !== '') {
				$kabupaten_id = $_POST["$attr"];
			}
			 elseif ($model_nama !== '' && $attr !== '') {
				$kabupaten_id = $_POST["$model_nama"]["$attr"];
			}
			$kecamatan = null;
			if($kabupaten_id){
				$kecamatan = $modPasien->getKecamatanItems($kabupaten_id);
				$kecamatan = CHtml::listData($kecamatan,'kecamatan_id','kecamatan_nama');
			}

			if($encode){
				echo CJSON::encode($kecamatan);
			} else {
				if(empty($kecamatan)){
					echo CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
				}else{
					echo CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
					foreach($kecamatan as $value=>$name)
					{
						echo CHtml::tag('option', array('value'=>$value),CHtml::encode($name),true);
					}
				}
			}
		}
		Yii::app()->end();
	}
	
	/**
	 * Mengatur dropdown kelurahan
	 * @param type $encode jika = true maka return array jika false maka set Dropdown 
	 * @param type $model_nama
	 * @param type $attr
	 */
	public function actionSetDropdownKelurahan($encode=false,$model_nama='',$attr='')
	{
		if(Yii::app()->request->isAjaxRequest) {
			$modPasien = new MCPasienM;
			if($model_nama !=='' && $attr == ''){
				$kecamatan_id = $_POST["$model_nama"]['kecamatan_id'];
			}
			 elseif ($model_nama == '' && $attr !== '') {
				$kecamatan_id = $_POST["$attr"];
			}
			elseif ($model_nama !== '' && $attr !== '') {
				$kecamatan_id = $_POST["$model_nama"]["$attr"];
			}
			$kelurahan = null;
			if($kecamatan_id){
				$kelurahan = $modPasien->getKelurahanItems($kecamatan_id);
				$kelurahan = CHtml::listData($kelurahan,'kelurahan_id','kelurahan_nama');
			}

			if($encode){
				echo CJSON::encode($kelurahan);
			} else {
				if(empty($kelurahan)){
					echo CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
				}else{
					echo CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
					foreach($kelurahan as $value=>$name)
					{
						echo CHtml::tag('option', array('value'=>$value),CHtml::encode($name),true);
					}
				}
			}
		}
		Yii::app()->end();
	}
	
	/**
	 * set dropdown daerah pasien berdasarkan
	 * propinsi_id
	 * kabupaten_id
	 * kecamatan_id
	 * kelurahan_id
	 * pasien_id
	 */
	public function actionSetDropdownDaerahPasien()
	{
		if(Yii::app()->getRequest()->getIsAjaxRequest()) {
			$modPasien = new MCPasienM;
			$propinsi_id = $_POST['propinsi_id'];
			$kabupaten_id = $_POST['kabupaten_id'];
			$kecamatan_id = $_POST['kecamatan_id'];
			$kelurahan_id = (isset($_POST['kelurahan_id']) ? $_POST['kelurahan_id'] : null);

			$propinsis = PropinsiM::model()->findAll('propinsi_aktif = TRUE');
			$propinsis = CHtml::listData($propinsis,'propinsi_id','propinsi_nama');
			$propinsiOption = CHtml::tag('option',array('value'=>''),"-- Pilih --",true);
			
			foreach($propinsis as $value=>$name)
			{
				if($value==$propinsi_id)
					$propinsiOption .= CHtml::tag('option',array('value'=>$value,'selected'=>true),CHtml::encode($name),true);
				else
					$propinsiOption .= CHtml::tag('option',array('value'=>$value),CHtml::encode($name),true);
			}
			$kabupatens = $modPasien->getKabupatenItems($propinsi_id);
			$kabupatens = CHtml::listData($kabupatens,'kabupaten_id','kabupaten_nama');
			$kabupatenOption = CHtml::tag('option',array('value'=>''),"-- Pilih --",true);
			foreach($kabupatens as $value=>$name)
			{
				if($value==$kabupaten_id)
					$kabupatenOption .= CHtml::tag('option',array('value'=>$value,'selected'=>true),CHtml::encode($name),true);
				else
					$kabupatenOption .= CHtml::tag('option',array('value'=>$value),CHtml::encode($name),true);
			}
			$kecamatans = $modPasien->getKecamatanItems($kabupaten_id);
			$kecamatans = CHtml::listData($kecamatans,'kecamatan_id','kecamatan_nama');
			$kecamatanOption = CHtml::tag('option',array('value'=>''),"-- Pilih --",true);
			foreach($kecamatans as $value=>$name)
			{
				if($value==$kecamatan_id)
					$kecamatanOption .= CHtml::tag('option',array('value'=>$value,'selected'=>true),CHtml::encode($name),true);
				else
					$kecamatanOption .= CHtml::tag('option',array('value'=>$value),CHtml::encode($name),true);
			}
			$kelurahans = $modPasien->getKelurahanItems($kecamatan_id);
			$kelurahans = CHtml::listData($kelurahans,'kelurahan_id','kelurahan_nama');
			$kelurahanOption = CHtml::tag('option',array('value'=>''),"-- Pilih --",true);
			foreach($kelurahans as $value=>$name)
			{
				if($value==$kelurahan_id)
					$kelurahanOption .= CHtml::tag('option',array('value'=>$value,'selected'=>true),CHtml::encode($name),true);
				else
					$kelurahanOption .= CHtml::tag('option',array('value'=>$value),CHtml::encode($name),true);
			}

			$dataList['listPropinsi'] = $propinsiOption;
			$dataList['listKabupaten'] = $kabupatenOption;
			$dataList['listKecamatan'] = $kecamatanOption;
			$dataList['listKelurahan'] = $kelurahanOption;

			echo json_encode($dataList);
			Yii::app()->end();
		}
	}
	
	/**
	 * set tanggal lahir dari umur (__ Thn __ Bln __ Hr)
	 */
	public function actionSetTanggalLahir()
	{
		if(Yii::app()->getRequest()->getIsAjaxRequest()) {
			$data['tanggal_lahir'] = date("d/m/Y",strtotime(CustomFunction::getTanggalUmur($_POST['umur'])));   
                }
                echo json_encode($data);
             Yii::app()->end();
        }
        
	/**
	 * menampilkan karcis
	 */
	public function actionSetKarcis(){
		if(Yii::app()->request->isAjaxRequest) { 
			$format = new MyFormatter();
			$modTindakan = new MCTindakanPelayananKarcisT;
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
	 * set tabel riwayat kunjungan pasien
	 */
	public function actionSetRiwayatKunjunganPasien(){
		if(Yii::app()->request->isAjaxRequest) { 
			$data['table'] = "";
			$modPasien = new MCPasienM;
			$modPasien->pasien_id = $_POST['pasien_id'];
			$data['table'] = $this->renderPartial($this->path_view.'_tableRiwayatPasien',array(
									'modPasien'=>$modPasien,
									),true);
			echo json_encode($data);
			Yii::app()->end();
		}
	}
	
	/**
	 * set umur dari tanggal lahir (date)
	 */
	public function actionSetUmur()
	{
		if(Yii::app()->getRequest()->getIsAjaxRequest()) {
			$data['umur'] = null;
			if(isset($_POST['tanggal_lahir']) && !empty($_POST['tanggal_lahir'])){
				$data['umur'] = CustomFunction::hitungUmur($_POST['tanggal_lahir']);
			}
			echo json_encode($data);
			Yii::app()->end();
		}
	}
	
	/**
	 * set dropdown dokter
	 */
	public function actionSetDropdownDokter()
	{
		if(Yii::app()->getRequest()->getIsAjaxRequest()) {
			$model = new MCPendaftaranT;
			$option = CHtml::tag('option',array('value'=>''),CHtml::encode('-- Pilih --'),true);
			if(!empty($_POST['ruangan_id'])){
				$data = $model->getDokterItems($_POST['ruangan_id']);
				$data = CHtml::listData($data,'pegawai_id','NamaLengkap');
				foreach($data as $value=>$name){
					$option .= CHtml::tag('option',array('value'=>$value),CHtml::encode($name),true);
				}
			} 
			$dataList['listDokter'] = $option;
			echo json_encode($dataList);
			Yii::app()->end();
		}
	}
        
	/**
	 * set dropdown jenis kasus penyakit
	 */
	public function actionSetDropdownJeniskasuspenyakit()
	{
		if(Yii::app()->getRequest()->getIsAjaxRequest()) {
			$model = new MCPendaftaranT;
			$option = CHtml::tag('option',array('value'=>''),CHtml::encode('-- Pilih --'),true);
			if(!empty($_POST['ruangan_id'])){
				$data = $model->getJenisKasusPenyakitItems($_POST['ruangan_id']);
				$data = CHtml::listData($data,'jeniskasuspenyakit_id', 'jeniskasuspenyakit_nama');
				foreach($data as $value=>$name){
					$option .= CHtml::tag('option',array('value'=>$value),CHtml::encode($name),true);
				}
			} 
			$dataList['listKasuspenyakit'] = $option;
			echo json_encode($dataList);
			Yii::app()->end();
		}
	}
	
	/**
	 * set dropdown penjamin pasien dari carabayar_id
	 * @param type $encode
	 * @param type $namaModel
	 */
	public function actionSetDropdownPenjaminPasien($encode=false,$namaModel='')
	{
		if(Yii::app()->request->isAjaxRequest) {
			$carabayar_id = $_POST["$namaModel"]['carabayar_id'];
			if($encode)
			{
				echo CJSON::encode($penjamin);
			}else{
				if(empty($carabayar_id)){
					echo CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
				} else {
					$penjamin = PenjaminpasienM::model()->findAllByAttributes(array('carabayar_id'=>$carabayar_id,'penjamin_aktif'=>true), array('order'=>'penjamin_nama ASC'));
					if(count($penjamin) > 1)
					{
						echo CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
					}
					$penjamin = CHtml::listData($penjamin,'penjamin_id','penjamin_nama');
					foreach($penjamin as $value=>$name) {
						echo CHtml::tag('option', array('value'=>$value),CHtml::encode($name),true);
					}
				}
			}
		}
		Yii::app()->end();
	}

	/*
	 * Mencari kelas pelayanan berdasarkan ruangan_id di tabel KelasruanganM
	 * and open the template in the editor.
	 */
	public function actionSetDropdownKelasPelayanan($encode=false,$namaModel='')
	{
		if(Yii::app()->request->isAjaxRequest) {
			$ruangan_id = $_POST["$namaModel"]['ruangan_id'];
			$kelasPelayanan = null;
			if($ruangan_id){
				$kelasPelayanan = KelasruanganM::model()->with('kelaspelayanan')->findAll('ruangan_id='.$ruangan_id.' and kelaspelayanan_aktif = true');
				$kelasPelayanan=CHtml::listData($kelasPelayanan,'kelaspelayanan_id','kelaspelayanan.kelaspelayanan_nama');
			}
			if(empty($kelasPelayanan)){
				echo CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
			}else{
				echo CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
				foreach($kelasPelayanan as $value=>$name)
				{
					echo CHtml::tag('option', array('value'=>$value),CHtml::encode($name),true);
				}
			}
		}
		Yii::app()->end();
	}

	/**
	 * set antrian ruangan
	 */
	public function actionSetAntrianRuangan(){
		if(Yii::app()->request->isAjaxRequest) { 
			$ruangan_id = $_POST['ruangan_id'];
			$data = array();
			$data['maxantrianruangan'] = null;
			$data['no_urutantri'] = '001';
			if(!empty($ruangan_id)){
				$data['no_urutantri'] = MyGenerator::noAntrian($ruangan_id);
				$criteria=new CDbCriteria;
				$criteria->addCondition("ruangan_id = ".$ruangan_id);
				$modJadwalBukaPoli= JadwalbukapoliM::model()->findAll($criteria);
				if (count($modJadwalBukaPoli) > 0){
					foreach($modJadwalBukaPoli as $key=>$antrian){
						$data['maxantrianruangan'] = $antrian->maxantiranpoli;     
					}
				}
			}
			echo json_encode($data);
		 Yii::app()->end();
		}
	}
	
	/**
	 * set antrian dokter
	 */
	public function actionSetAntrianDokter(){
		if(Yii::app()->request->isAjaxRequest) { 
			$ruangan_id = $_POST['ruangan_id'];
			$pegawai_id = $_POST['pegawai_id'];
			$data = array();
			$data['maxantriandokter'] = 0;
			if(!empty($ruangan_id) && !empty($pegawai_id)){
				$criteria=new CDbCriteria;
				$criteria->addCondition("ruangan_id = ".$ruangan_id);
				$criteria->addCondition("pegawai_id = ".$pegawai_id);
				$modJadwalDokter= JadwaldokterM::model()->findAll($criteria);
				if (count($modJadwalDokter) > 0){
					foreach($modJadwalDokter as $key=>$antrian){
						$data['maxantriandokter'] = $antrian->maximumantrian;     
					}
				}
			}
			echo json_encode($data);
		 Yii::app()->end();
		}
	}
        
	/**
	 * @param type $pendaftaran_id
	 */
	public function actionPrintStatus($pendaftaran_id) 
	{
		$this->layout='//layouts/printWindows';
		$format = new MyFormatter;
		$modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
		$modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
		$modPenanggungjawab = array();
		if(!empty($modPendaftaran->penanggungjawab_id)){
			$modPenanggungjawab=MCPenanggungJawabM::model()->findByPk($modPendaftaran->penanggungjawab_id);
		}
		$karcis_id = null;
		$modTindakan =  TindakanpelayananT::model()->findByAttributes(array('pendaftaran_id'=>$modPendaftaran->pendaftaran_id), "karcis_id IS NOT NULL");
		$judul_print = 'Kunjungan Rawat Jalan';
		$this->render($this->path_view.'printStatus', array(
							'format'=>$format,
							'modPendaftaran'=>$modPendaftaran,
							'modPenanggungjawab'=>$modPenanggungjawab,
							'judul_print'=>$judul_print,
							'modPasien'=>$modPasien,
							'modTindakan'=>$modTindakan,
		));
	}
	/**
	 * @param type $pendaftaran_id
	 */
	public function actionPrintKarcis($pendaftaran_id) 
	{
		$this->layout='//layouts/printWindows';
		$format = new MyFormatter;
		$modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
		$modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
		$modPegawai = PegawaiM::model()->findByPk(Yii::app()->user->id);

		$karcis_id = null;
		$modTindakan =  TindakanpelayananT::model()->findByAttributes(array('pendaftaran_id'=>$modPendaftaran->pendaftaran_id), "karcis_id IS NOT NULL");
		$judul_print = 'Karcis '.$modPendaftaran->ruangan->instalasi->instalasi_nama;
		$this->render($this->path_view.'printKarcis', array(
							'format'=>$format,
							'modPendaftaran'=>$modPendaftaran,
							'judul_print'=>$judul_print,
							'modPasien'=>$modPasien,
							'modTindakan'=>$modTindakan,
							'modPegawai'=>$modPegawai,
		));
	} 
	
	/**
	 * print kartu pasien
	 * @param type $pasien_id
	 */
	public function actionPrintKartuPasien($pasien_id)
	{
		$this->layout='//layouts/printWindows';
		$modPasien = PasienM::model()->findByPk($pasien_id);
		$judul_print = 'Kartu Pasien';
		$this->render($this->path_view.'printKartuPasien',
			array(
				'modPasien'=>$modPasien,
				'judul_print'=>$judul_print
			)
		);
	}

	/**
	 * @param type $sep_id
	 */
	public function actionPrintSep($sep_id,$pendaftaran_id) 
	{
		$this->layout='//layouts/printWindows';
		$format = new MyFormatter;
		$modRujukanBpjs = new MCRujukanbpjsT;
		$modSep = MCSepT::model()->findByPk($sep_id);
		$modAsuransiPasienBpjs = MCAsuransipasienbpjsM::model()->findByAttributes(array('nopeserta'=>$modSep->nokartuasuransi)); 
		$modJenisPeserta = MCJenisPesertaM::model()->findByPk($modAsuransiPasienBpjs->jenispeserta_id);
		if (isset($modSep->norujukan)) {
			$modRujukanBpjs = MCRujukanbpjsT::model()->findByAttributes(array('no_rujukan'=>$modSep->norujukan));
		}
		$modPendaftaran = MCPendaftaranT::model()->findByPk($pendaftaran_id);
		$modPasien = MCPasienM::model()->findByPk($modPendaftaran->pasien_id);
		$judul_print = 'SURAT ELIGIBILITAS PESERTA';
		$this->render($this->path_view.'printSep', array(
							'format'=>$format,
							'modSep'=>$modSep,
							'judul_print'=>$judul_print,
							'modAsuransiPasienBpjs'=>$modAsuransiPasienBpjs,
							'modRujukanBpjs'=>$modRujukanBpjs,
							'modPendaftaran'=>$modPendaftaran,
							'modPasien'=>$modPasien,
							'modJenisPeserta'=>$modJenisPeserta,
		));
	} 
        
	/**
	 * action ketika tombol panggil di klik
	 */
	public function actionPanggil($antrian_id,$ket=null){
		if(Yii::app()->request->isAjaxRequest)
		{
			$format = new MyFormatter();
			$data = array();
			$data['pesan']="";
			$modAntrian =  MCAntrianT::model()->findByPk($antrian_id);
			if(isset($modAntrian)){
				if($modAntrian->panggil_flaq == true){
					if($ket == "batal"){
						$modAntrian->panggil_flaq = false;
						if($modAntrian->update()){
	//                            $data['pesan'] = "Pemanggilan no. antrian ".$modAntrian->noantrian." dibatalkan !";
						}
					}else{
						$data['pesan'] = "No. antrian ".$modAntrian->noantrian." sudah dipanggil sebelumnya !";
					}
				}else{
					$modAntrian->panggil_flaq = true;
					if($modAntrian->update()){
	//                        $data['pesan'] = "No. antrian ".$modAntrian->noantrian." dipanggil !";
					}
				}
			}
			$attributes = $modAntrian->attributeNames();
			foreach($attributes as $i=>$attribute) {
				$data["$attribute"] = $modAntrian->$attribute;
			}
			echo CJSON::encode($data);
			Yii::app()->end();
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * menampilkan form antrian dari request ajax
	 * @param type $record
	 * @param type $noantrian
	 * @throws CHttpException
	 */
	public function actionSetFormAntrian(){
		if(Yii::app()->request->isAjaxRequest)
		{
			$format = new MyFormatter();
			$data = array();
			$data['pesan'] = "";
			$record = (isset($_POST['record']) ? $_POST['record'] : "");
			$noantrian = (isset($_POST['noantrian']) ? $_POST['noantrian'] : "");
			$loket_id = (isset($_POST['loket_id']) ? $_POST['loket_id'] : null);
			if(empty($noantrian)){ //antrian baru
				$criteria = new CDbCriteria();
				$criteria->compare('DATE(tglantrian)', date("Y-m-d"));
				$criteria->addCondition("pendaftaran_id IS NULL");
				if($record == "reset"){
					$criteria->addCondition("panggil_flaq = false");
				}
				if(!empty($loket_id)){$criteria->addCondition("loket_id = ".$loket_id); }
				$criteria->order = "noantrian ASC";
				$criteria->limit = 1;
				$modAntrian =  MCAntrianT::model()->find($criteria);
			}else{
				$criteria = new CDbCriteria();
				$criteria->compare('DATE(tglantrian)', date("Y-m-d"));
				$criteria->compare("noantrian",trim($noantrian));
				if(!empty($loket_id)){$criteria->addCondition("loket_id = ".$loket_id); }
				$cari =  MCAntrianT::model()->find($criteria);
				if($record == 'next'){
					$cari->loket_id = $loket_id;
					$modAntrian = $cari->AntrianBerikut;
				}else if($record == 'prev'){
					$cari->loket_id = $loket_id;
					$modAntrian = $cari->AntrianSebelum;
				}else{
					$modAntrian = $cari;
				}
			}

			if(!isset($modAntrian)){
				$modAntrian = new MCAntrianT;
				$data['pesan'] = "Antrian Habis !";
			}
			$modAntrian->tglantrian = $format->formatDateTimeForUser($modAntrian->tglantrian);
			$data['form_antrian'] = $this->renderPartial($this->path_view.'_formPanggilAntrian',array('modAntrian'=>$modAntrian),true);
			echo CJSON::encode($data);
			Yii::app()->end();
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}
        
	/**
	* untuk menampilkan data diagnosa dari autocomplete
	* 1. diagnosa_kode
	* 2. diagnosa_nama
	*/
	public function actionAutocompleteDiagnosaRujukan()
	{
		if(Yii::app()->request->isAjaxRequest) {
			$returnVal = array();
			$diagnosa_nama = isset($_GET['diagnosa_rujukan']) ? $_GET['diagnosa_rujukan'] : null;
			$criteria = new CDbCriteria();
			$criteria->compare('LOWER(diagnosa_nama)', strtolower($diagnosa_nama), true);
			$criteria->order = 'diagnosa_nama';
			$criteria->limit = 5;
			$models = DiagnosaM::model()->findAll($criteria);
			$data = array();
			foreach ($models as $i => $model) {
				$data[$i] = array('key'=>$model->diagnosa_kode,
								  'value'=>$model->diagnosa_nama);
			}
			echo CJSON::encode($data);
		}else
			throw new CHttpException(403,'Tidak dapat mengurai data');
		Yii::app()->end();
	}

	/**
	* set bpjs Interface
	*/
	public function actionBpjsInterface()
	{
	   if(Yii::app()->getRequest()->getIsAjaxRequest()) {
		   if(empty( $_GET['param'] ) OR $_GET['param'] === ''){
			   die('param can\'not empty value');
		   }else{
			   $param = $_GET['param'];
		   }

//                if(empty( $_GET['server'] ) OR $_GET['server'] === ''){
//                    
//                }else{
//                    $server = 'http://'.$_GET['server'];
//                }

		   $bpjs = new Bpjs();

		   switch ($param) {
			   case '1':
				   $query = $_GET['query'];
				   print_r( $bpjs->search_kartu($query) );
				   break;
			   case '2':
				   $query = $_GET['query'];
				   print_r( $bpjs->search_nik($query) );
				   break;
			   case '3':
				   $query = $_GET['query'];
				   print_r( $bpjs->search_rujukan_no_rujukan($query) );
				   break;
			   case '4':
				   $query = $_GET['query'];
				   print_r( $bpjs->search_rujukan_no_bpjs($query) );
				   break;
			   case '5':
				   $query = $_GET['query'];
				   $start = $_GET['start'];
				   $limit = $_GET['limit'];
				   print_r( $bpjs->list_rujukan_tanggal($query, $start, $limit) );
				   break;
			   case '6':
				   $nokartu = $_GET['no_kartu'];
				   $tglsep = $_GET['tgl_sep'];
				   $tglrujukan = $_GET['tgl_rujukan'];
				   $norujukan = $_GET['no_rujukan'];
				   $ppkrujukan = $_GET['ppk_rujukan'];
				   $ppkpelayanan = $_GET['ppk_pelayanan'];
				   $jnspelayanan = $_GET['jns_pelayanan'];
				   $catatan = $_GET['catatan'];
				   $diagawal = $_GET['diag_awal'];
				   $politujuan = $_GET['poli_tujuan'];
				   $klsrawat = $_GET['kls_rawat'];
				   $user = $_GET['user'];
				   $nomr = $_GET['no_mr'];
				   $notrans = $_GET['no_trans'];
				   print_r( $bpjs->create_sep($nokartu, $tglsep, $tglrujukan, $norujukan, $ppkrujukan, $ppkpelayanan, $jnspelayanan, $catatan, $diagawal, $politujuan, $klsrawat, $user, $nomr, $notrans) );
				   break;
			   case '7':
				   $nosep = $_GET['nosep'];
				   $tglpulang = $_GET['tglpulang'];
				   $ppkpelayanan = $_GET['ppkpelayanan'];
				   print_r( $bpjs->update_tanggal_pulang_sep($nosep, $tglpulang, $ppkpelayanan) );
				   break;
			   case '8':
				   $nosep = $_GET['nosep'];
				   $notrans = $_GET['notrans'];
				   $ppkpelayanan = $_GET['ppkpelayanan'];
				   print_r( $bpjs->mapping_trans($nosep, $notrans, $ppkpelayanan) );
				   break;
			   case '9':
				   $nosep = $_GET['nosep'];
				   $ppkpelayanan = $_GET['ppkpelayanan'];
				   print_r( $bpjs->delete_transaksi($nosep, $ppkpelayanan) );
				   break;
			   case '10':
				   $nokartu = $_GET['nokartu'];
				   print_r( $bpjs->riwayat_terakhir($nokartu) );
				   break;
			   case '11':
				   $nosep = $_GET['nosep'];
				   print_r( $bpjs->detail_sep($nosep) );
				   break;
			   case '12':
				   $ppkpelayanan = $_GET['ppkrujukan'];
				   $start = $_GET['start'];
				   $limit = $_GET['limit'];
				   print_r( $bpjs->detail_ppk_rujukan($ppkpelayanan, $start, $limit) );
				   break;
			   case '99':
				   $bpjs->identity_magic();
				   break;
			   case '100':
				   print_r( $bpjs->help() );
				   break;
			   default:
				   die('error number, please check your parameter option');
				   break;
		   }
		   Yii::app()->end();
	   }
	}
		
	public function actionGetRujukanDari($encode=false,$namaModel='')
    {
        if(Yii::app()->request->isAjaxRequest) {
            $asalrujukan_id = $_POST["$namaModel"]['asalrujukan_id'];
            
			if($encode) {
                echo CJSON::encode($rujukandari);
			} else {
                if(empty($asalrujukan_id)){
                    echo CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
                } else {
					echo CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
					$rujukandari = RujukandariM::model()->findAllByAttributes(array('asalrujukan_id'=>$asalrujukan_id), array('order'=>'namaperujuk'));
					$rujukandari = CHtml::listData($rujukandari,'rujukandari_id','namaperujuk');
					foreach($rujukandari as $value=>$name) {
						echo CHtml::tag('option', array('value'=>$value),CHtml::encode($name),true);
					}                        
                }
           }
        }
        Yii::app()->end();
    }
	
	/**
		* form verifikasi sebelum submit
		* @param type $id
	*/
	public function actionVerifikasi()
	{
		if (Yii::app()->request->isAjaxRequest){
			$this->layout = '//layouts/iframe';
			if(isset($_POST['MCPendaftaranT'])){
				$format = new MyFormatter();
				$model=new MCPendaftaranT();
				$modPasien=new MCPasienM;
				$modPenanggungJawab = null;
				$modRujukan=null;
				$modTindakan = null;

				$model->attributes = $_POST['MCPendaftaranT'];
				$modPasien->attributes = $_POST['MCPasienM'];

				if($_POST['MCPendaftaranT']['is_adakarcis']){
					if(isset($_POST['MCKarcisV'])){
						if(count($_POST['MCKarcisV']) > 0){
							foreach($_POST['MCKarcisV'] as $i => $karcis){
								if($karcis['is_pilihtindakan']){
									$modTindakan=new MCTindakanPelayananT;
									$modTindakan->attributes = $karcis;
									$modTindakan->karcis_id = $karcis['karcis_id'];
								}
							}
						}
					}
				}

			}
			echo CJSON::encode(array(
				'content'=>$this->renderPartial('verifikasi',array(
					'model'=>$model,
					'modPasien'=>$modPasien,
					'modPenanggungJawab'=>$modPenanggungJawab,
					'modTindakan'=>$modTindakan,
					'format'=>$format,
			), true)));
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
			$postPemeriksaan = $post['MCPaketpelayananM'];
			$criteria = new CdbCriteria();
			$criteria->compare('LOWER(namatindakan)',strtolower($postPemeriksaan['namatindakan']), true);
			$criteria->order = "tipepaket_id, namatindakan";
			$modPemeriksaanmcus = MCPaketpelayananM::model()->findAll($criteria);
			$content = $this->renderPartial('mcu.views.pendaftaranPasien._checklistPemeriksaanMcu',array('modPemeriksaanmcus'=>$modPemeriksaanmcus), true);
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
			$postPemeriksaan = $post['MCPaketpelayananM'];
			
            $kelaspelayanan_id = (isset($_GET['kelaspelayanan_id']) ? $_GET['kelaspelayanan_id'] : Params::KELASPELAYANAN_ID_TANPA_KELAS);
            $tipepaket_id = (isset($_GET['tipepaket_id']) ? $_GET['tipepaket_id'] : Params::TIPEPAKET_ID_NONPAKET);
            $penjamin_id = (isset($_GET['penjamin_id']) ? $_GET['penjamin_id'] : Params::PENJAMIN_ID_UMUM);
            $modJenisTarif = JenistarifpenjaminM::model()->find('penjamin_id ='.$penjamin_id);
			$jenistarif_id = $modJenisTarif->jenistarif_id;
//			$ruangan_id = Yii::app()->user->getState('ruangan_id');
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
//                    $criteria->addCondition('ruangan_id = '.$ruangan_id);
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
//				$criteria->limit = 100;
                $models = PaketpelayananV::model()->findAll($criteria);                    
                
				$content = $this->renderPartial('mcu.views.pendaftaranPasien._checklistPemeriksaanMcuDiluarPaket',array('modPemeriksaan'=>$modPemeriksaan), true);
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

//				$criteria->limit = 100;
				
                if(Yii::app()->user->getState('tindakanruangan'))
                {
                    $criteria->addInCondition('ruangan_id',$ruangan_id);
//					$criteria->addCondition('ruangan_id = '.$ruangan_id);
                    $modPemeriksaan = MCTariftindakanperdaruanganV::model()->findAll($criteria);
                } else {
                    $modPemeriksaan = TariftindakanperdaV::model()->findAll($criteria);
                }
                $content = $this->renderPartial('mcu.views.pendaftaranPasien._checklistPemeriksaanMcuDiluarPaket',array('modPemeriksaan'=>$modPemeriksaan), true);
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
//				$criteria->limit = 100;
                $modPemeriksaan = PaketpelayananV::model()->find($criteria);
				
				$content = $this->renderPartial('mcu.views.pendaftaranPasien._checklistPemeriksaanMcuDiluarPaket',array('modPemeriksaan'=>$modPemeriksaan), true);
				echo CJSON::encode(array(
					'content'=>$content));
				Yii::app()->end();
			}
		}  
	}
	
	/**
	* Fungsi untuk menyimpan data ke model MCPasienmasukpenunjangT
	* @param type $modPendaftaran
	* @param type $modPasien
	* @return MCPasienmasukpenunjangT 
	*/
   public function simpanPasienMasukPenunjang($modPasienMasukPenunjang,$modPendaftaran,$ruangan_id){
		$modPasien = MCPasienM::model()->findByPk($modPendaftaran->pasien_id);
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
		$modTindakan = new MCTindakanPelayananT();
		$modPemeriksaanLab = MCPemeriksaanlabM::model()->find('daftartindakan_id = '.$post['daftartindakan_id']);
		$modPemeriksaanRad = MCPemeriksaanRadM::model()->find('daftartindakan_id = '.$post['daftartindakan_id']);
		
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
		$modHasilPemeriksaan = new MCHasilPemeriksaanLabT;
		$modHasilPemeriksaan->attributes = $modPasienMasukPenunjang->attributes;
		$modHasilPemeriksaan->nohasilperiksalab = MyGenerator::noHasilPemeriksaanLK();
		$modHasilPemeriksaan->tglhasilpemeriksaanlab = $modPasienMasukPenunjang->tglmasukpenunjang;
		$modHasilPemeriksaan->hasil_kelompokumur = CustomFunction::getKelompokUmur($modPasien->tanggal_lahir);
		$modHasilPemeriksaan->hasil_jeniskelamin = $modPasien->jeniskelamin;
		$modHasilPemeriksaan->statusperiksahasil = Params::STATUSPERIKSAHASIL_BELUM;
//		$modHasilPemeriksaan->create_ruangan = $modPasienMasukPenunjang->ruangan_id;
		$modHasilPemeriksaan->create_ruangan = Yii::app()->user->getState('ruangan_id');
		if($modHasilPemeriksaan->validate()){
			$modHasilPemeriksaan->save();
		}else{
			$this->hasilpemeriksaantersimpan &= false;
		}
		return $modHasilPemeriksaan;
	}
		
	/**
	* simpan MCDetailHasilPemeriksaanLabT
	*/
	 public function simpanDetailHasilPemeriksaanLab($modHasilPemeriksaan, $modTindakan, $post){
	   $modDetailHasilPemeriksaans = array();
	   $modPemeriksaanLab = MCPemeriksaanlabM::model()->find('daftartindakan_id = '.$post['daftartindakan_id']);
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
			   $modDetailHasilPemeriksaans[$i] = new MCDetailHasilPemeriksaanLabT;
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
//			   $modDetailHasilPemeriksaans[$i]->create_ruangan = $modHasilPemeriksaan->create_ruangan;
			   
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
		$modHasilPemeriksaanPA = new MCHasilPemeriksaanPAT;
		$modHasilPemeriksaanPA->attributes = $modPasienMasukPenunjang->attributes;
		$modHasilPemeriksaanPA->tindakanpelayanan_id = $modTindakan->tindakanpelayanan_id;
		$modHasilPemeriksaanPA->pemeriksaanlab_id = $post['pemeriksaanlab_id'];
		$modHasilPemeriksaanPA->nosediaanpa = MyGenerator::noSediaanPA();
		$modHasilPemeriksaanPA->tglperiksapa = $modPasienMasukPenunjang->tglmasukpenunjang;
		$modHasilPemeriksaanPA->create_time = date("Y-m-d H:i:s");
		$modHasilPemeriksaanPA->create_loginpemakai_id = Yii::app()->user->id;
		$modHasilPemeriksaanPA->create_ruangan = Yii::app()->user->getState('ruangan_id');
//		$modHasilPemeriksaanPA->create_ruangan = $modPasienMasukPenunjang->ruangan_id;

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
		$modPengambilanSample = new MCPengambilanSampleT;
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
	* simpan MCHasilpemeriksaanradT
	*/
	public function simpanHasilPemeriksaanRad($modPasienMasukPenunjang, $modTindakan, $post){
		$modHasilPemeriksaan = new MCHasilpemeriksaanradT;
		$modPemeriksaanRad = MCPemeriksaanRadM::model()->find('daftartindakan_id = '.$post['daftartindakan_id']);
		$modHasilPemeriksaan->attributes = $modPasienMasukPenunjang->attributes;
		$modHasilPemeriksaan->tindakanpelayanan_id = $modTindakan->tindakanpelayanan_id;
		$modHasilPemeriksaan->pemeriksaanrad_id = $modPemeriksaanRad->pemeriksaanrad_id;
		$modHasilPemeriksaan->tglpemeriksaanrad = $modPasienMasukPenunjang->tglmasukpenunjang;
		$modHasilPemeriksaan->create_time = date("Y-m-d H:i:s");
		$modHasilPemeriksaan->create_loginpemakai_id = Yii::app()->user->id;
		$modHasilPemeriksaan->create_ruangan = Yii::app()->user->getState('ruangan_id');;
//		$modHasilPemeriksaan->create_ruangan = $modPasienMasukPenunjang->ruangan_id;

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
	
	public function actionAutocompleteAsuransiBadak()
    {
		if(Yii::app()->request->isAjaxRequest) {
			$format = new MyFormatter();
			$returnVal = array();
			$nopeserta = isset($_GET['nomorindukpegawai']) ? $_GET['nomorindukpegawai'] : '';
			$penjamin_id = isset($_GET['penjamin_id']) ? $_GET['penjamin_id'] : null;
			$pasien_id = isset($_GET['pasien_id']) ? $_GET['pasien_id'] : null;
			$criteria = new CDbCriteria();
			$criteria->compare('LOWER(nopeserta)', strtolower($nopeserta),true);
			if(!empty($pasien_id)){
				$criteria->addCondition('pasien_id='.$pasien_id);
			}
			if(!empty($penjamin_id)){
				$criteria->addCondition('penjamin_id='.$penjamin_id);
			}
			$criteria->order = 'namapemilikasuransi';
			$criteria->limit = 5;
			$models = MCAsuransipasienM::model()->findAll($criteria);
			
			foreach($models as $i=>$model)
			{
				$attributes = $model->attributeNames();
				foreach($attributes as $j=>$attribute) {
					$returnVal[$i]["$attribute"] = $model->$attribute;
				}
				$returnVal[$i]['label'] = $model->nopeserta.' - '.$model->namapemilikasuransi;
				$returnVal[$i]['value'] = $model->nopeserta;
				$returnVal[$i]['asuransipasien_id'] = $model->asuransipasien_id;
//				$returnVal[$i]['nopeserta'] = $model->nopeserta;
				$returnVal[$i]['namapemilikasuransi'] = $model->namapemilikasuransi;
				$returnVal[$i]['jenispeserta_id'] = $model->jenispeserta_id;
				$returnVal[$i]['nomorpokokperusahaan'] = $model->nomorpokokperusahaan;
				$returnVal[$i]['namaperusahaan'] = $model->namaperusahaan;
				$returnVal[$i]['kelastanggunganasuransi_id'] = $model->kelastanggunganasuransi_id;
				
				$modPegawai = '';
				$modPegawai = MCPegawaiM::model()->findByPk($model->pasien->pegawai_id);
				$returnVal[$i]['alamat_pegawai'] = !empty($modPegawai)?$modPegawai->alamat_pegawai:'';
				$returnVal[$i]['notelp_pegawai'] = !empty($modPegawai)?$modPegawai->notelp_pegawai:'';
			}
			echo CJSON::encode($returnVal);
		}else
			throw new CHttpException(403,'Tidak dapat mengurai data');
		Yii::app()->end();
    }
	
	public function actionCekCaraBayarBadak()
        {
            if(Yii::app()->request->isAjaxRequest) {
				$pasien_id = $_POST['pasien_id'];
				$pegawai_id = $_POST['pegawai_id'];
				$pesan = '';
				$status = false;
				$modPegawai = MCPegawaiM::model()->findByPk($pegawai_id);
				if(count($modPegawai)>0){
					if($modPegawai->pegawai_aktif){
						$status = true;
					}else{
						$status = false;
						$pesan = 'Data Pegawai tidak aktif';
					}
				}else{
					$status = false;
					$pesan = 'Data tidak ditemukan';
				}
				echo CJSON::encode(array('status'=>$status,'pesan'=>$pesan));
            }
            Yii::app()->end();
        }
	
	public function actionAutocompletePegawai()
	{
		if(Yii::app()->request->isAjaxRequest) {
			$returnVal = array();
			$nomorindukpegawai = isset($_GET['nomorindukpegawai']) ? $_GET['nomorindukpegawai'] : null;
			$nama_pegawai = isset($_GET['nama_pegawai']) ? $_GET['nama_pegawai'] : null;
			$criteria = new CDbCriteria();
			$criteria->compare('LOWER(nomorindukpegawai)', strtolower($nomorindukpegawai), true);
			$criteria->compare('LOWER(nama_pegawai)', strtolower($nama_pegawai), true);
			$criteria->order = 'nomorindukpegawai, nama_pegawai';
			$criteria->limit = 5;
			$models = MCPegawaiM::model()->findAll($criteria);
			if(count($models) > 0){
				foreach ($models as $i => $model) {
					$returnVal[$i] = $model->attributes;
					if(!empty($nomorindukpegawai)){
						$returnVal[$i]['label'] = $model->nomorindukpegawai.' - '.$model->nama_pegawai;
					}else{
						$returnVal[$i]['label'] = $model->nama_pegawai;
					}
					$returnVal[$i]['value'] = $model->pegawai_id;
					$returnVal[$i]['jabatan_nama'] = !empty($model->jabatan_id) ? $model->jabatan->jabatan_nama : "";
					$returnVal[$i]['gelarbelakang_nama'] = !empty($model->gelarbelakang_id) ? $model->gelarbelakang->gelarbelakang_nama : "";
				}
			}
			echo CJSON::encode($returnVal);
		}else
			throw new CHttpException(403,'Tidak dapat mengurai data');
		Yii::app()->end();
	}
	
	public function actionCekValiditasPenjamin()
	{
		if(Yii::app()->request->isAjaxRequest) {
			$pasien_id = isset($_POST['pasien_id'])?$_POST['pasien_id']:'';
			$penjamin_id =  isset($_POST['penjamin_id'])?$_POST['penjamin_id']:'';
			$pegawai_id = isset($_POST['pegawai_id'])?$_POST['pegawai_id']:'';
			$penj = '';
			$pesan = '';
			$status = '';
			$html = '';
			$data = null;
			switch ($_POST['type']) {     
				case "badak":

					$modPegawai = MCPegawaiM::model()->findByPk($pegawai_id);
					$penjamin = PenjaminpasienM::model()->findAllByAttributes(array('carabayar_id'=>Params::CARABAYAR_ID_BADAK,'penjamin_aktif'=>true), array('order'=>'penjamin_nama ASC'));
					$penjamin = CHtml::listData($penjamin,'penjamin_id','penjamin_nama');
					$html .= CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
					foreach($penjamin as $value=>$name) {
						$html .= CHtml::tag('option', array('value'=>$value),CHtml::encode($name),true);
					}

					if(count($modPegawai)>0){
						if($modPegawai->kategoripegawai == ""){
							$status = "Empty";
							$pesan = 'Data Kategori pegawai penanggung jawab pasien tidak ditemukan!<br>Lakukan pengaturan kategori pegawai di modul kepegawaian';
						}else{
							if($penjamin_id == Params::PENJAMIN_ID_PISA){
								$penj = Params::PENJAMIN_ID_PISA;
								if($modPegawai->kategoripegawai == "Tidak Tetap"){
									$status = "Tidak Tetap";
									$pesan = 'Tidak dapat memilih penjamin PISA. <br> Karena pegawai penanggung jawab pasien adalah pegawai tidak tetap / telah pensiun';
								}
							}else if($penjamin_id == Params::PENJAMIN_ID_PROKESPEN){
								$penj = Params::PENJAMIN_ID_PROKESPEN;
							}
						}
					}else{
						$status = "Fail";
						$pesan = 'Data tidak ditemukan';
					}
					break;      

				case "departemen":        

					$modPenjamin = PenjaminpasienM::model()->findByPk($penjamin_id);
					$data['penjamin_nama'] = $modPenjamin->penjamin_nama;
					break;
			}

			echo CJSON::encode(array('status'=>$status,'pesan'=>$pesan, 'html'=>$html, 'penj'=>$penj,'data'=>$data));
		}
		Yii::app()->end();
	}
	
	public function actionSetDropdownStatushubungankeluarga()
	{
		if(Yii::app()->getRequest()->getIsAjaxRequest()) {
			$penjamin_id = $_POST['penjamin_id'];
			$modAsuransiPasienBadak = new MCAsuransipasienbadakM();
			$option = CHtml::tag('option',array('value'=>''),CHtml::encode('-- Pilih --'),true);
			if(!empty($penjamin_id)){
				$data = $modAsuransiPasienBadak->getDropdownStatushubungankeluarga($penjamin_id);
				$data = CHtml::listData($data,'lookup_value', 'lookup_name');
				foreach($data as $value=>$name){
						$option .= CHtml::tag('option',array('value'=>$value),CHtml::encode($name),true);
				}
			} 
			$dataList['statushubungankeluarga'] = $option;
			echo json_encode($dataList);
			Yii::app()->end();
		}
	}
	
	public function actionCekTanggalKontrol()
	{
		if(Yii::app()->request->isAjaxRequest) {
			$pasien_id = $_POST['pasien_id'];
			$modPendaftaran = PendaftaranT::model()->findByAttributes(array('pasien_id'=>$pasien_id),array('order'=>'pendaftaran_id DESC'));
			$return = '';
			$status = false;
			if(!empty($modPendaftaran->tglrenkontrol)){
				$tglpendaftaran = new DateTime(MyFormatter::formatDateTimeForDb($modPendaftaran->tgl_pendaftaran));
				$tglrenkontrol = new DateTime($modPendaftaran->tglrenkontrol);
				
				if($tglrenkontrol >= $tglpendaftaran){
					$status = true;
					$return['tgl_pendaftaran'] = MyFormatter::formatDateTimeForUser($modPendaftaran->tgl_pendaftaran);
					$return['tglrenkontrol_next'] = MyFormatter::formatDateTimeForUser($modPendaftaran->tglrenkontrol);
					$return['pesan'] = "Pasien ini sudah melakukan pendaftarn MCU pada ".$return['tgl_pendaftaran']." dan pemeriksaan MCU yg akan datang normalnya lebih dari tanggal ".$return['tglrenkontrol_next']." Apakah ingin tetap mendaftarkan ?";
				}
				
			}
			echo CJSON::encode(array('status'=>$status,'return'=>$return));
		}
		Yii::app()->end();
	}
        
}
