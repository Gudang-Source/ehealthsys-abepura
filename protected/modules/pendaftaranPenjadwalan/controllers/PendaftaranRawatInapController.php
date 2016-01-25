
<?php
Yii::import('pendaftaranPenjadwalan.controllers.PendaftaranRawatJalanController');
class PendaftaranRawatInapController extends PendaftaranRawatJalanController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column1';
        public $defaultAction = 'index';
        public $path_view = "pendaftaranPenjadwalan.views.pendaftaranRawatJalan.";
        
        public $pasientersimpan = false;
        public $pendaftarantersimpan = false;
        public $penanggungjawabtersimpan = false;
        public $karcistersimpan = false;
        public $komponentindakantersimpan = false;
        public $rujukantersimpan = false;
        public $masukkamartersimpan = false;
        public $admisitersimpan = false;
        public $asuransipasientersimpan = false;
        
	/**
	 * Index transaksi pendaftaran
	 */
	public function actionIndex($id = null, $idSep = null, $idAntrian = null)
	{
            $format = new MyFormatter();
            $model=new PPPendaftaranT;
            $modPasien=new PPPasienM;
			$modPegawai=new PPPegawaiM;
            $modPasienAdmisi = new PPPasienAdmisiT;
            $modPenanggungJawab=new PPPenanggungJawabM;
            $modRujukan=new PPRujukanT;
            $modRujukanBpjs=new PPRujukanbpjsT;
            $modTindakan=new PPTindakanPelayananT;
            $modPembayaran = new PPPembayaranpelayananT();
            $modAntrian=new PPAntrianT;
            $modAsuransiPasien=new PPAsuransipasienM;
            $modAsuransiPasienBpjs =new PPAsuransipasienbpjsM;
			$modAsuransiPasienBadak =new PPAsuransipasienbadakM();
            $modAsuransiPasienDepartemen =new PPAsuransipasiendepartemenM();
            $modAsuransiPasienPekerja =new PPAsuransipasienpegawaiM();
            $modSep=new PPSepT;
            $dataTindakans = array();
			$modKarcisV =array();
            $modPasien->propinsi_id = Yii::app()->user->getState('propinsi_id');
            $modPasien->kabupaten_id = Yii::app()->user->getState('kabupaten_id');
            $modPasien->kecamatan_id = Yii::app()->user->getState('kecamatan_id');
            $modPasien->kelurahan_id = Yii::app()->user->getState('kelurahan_id');
            $modPasien->warga_negara = Params::DEFAULT_WARGANEGARA;
            $modPasien->agama = Params::DEFAULT_AGAMA;
            $model->is_adakarcis = Yii::app()->user->getState('iskarcis'); //RND-7737
			$model->is_pasienrujukan = 1;
			$model->is_asubadak = 0;
            $model->is_asudepartemen = 0;
            $model->is_asupekerja = 0;

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

            //==load data
            
            if (!empty($idAntrian)) {
                $modAntrian = PPAntrianT::model()->findByPk($idAntrian, array(
                    'condition'=>'pendaftaran_id is null',
                ));
                if (empty($modAntrian)) {
                    $modAntrian = new PPAntrianT;
                } else {
                    $model->antrian_id = $modAntrian->antrian_id;
                }
            }
            
            if(isset($id)){
                $model = $this->loadModel($id);
                if(isset($idSep)){
                    $model->is_bpjs = 1; 
                    $modRujukanBpjs= PPRujukanbpjsT::model()->findByPk($model->rujukan_id);
                    $modAsuransiPasienBpjs = PPAsuransipasienbpjsM::model()->findByPk($model->asuransipasien_id);

                }
                $modPasien=PPPasienM::model()->findByPk($model->pasien_id);
                $modPasienAdmisi=PPPasienAdmisiT::model()->findByPk($model->pasienadmisi_id);
                if(!empty($model->penanggungjawab_id)){
                    $modPenanggungJawab=PPPenanggungJawabM::model()->findByPk($model->penanggungjawab_id);
                }
                if(!empty($model->rujukan_id)){
                    $modRujukan=PPRujukanT::model()->findByPk($model->rujukan_id);
                }
                $dataTindakans=PPTindakanPelayananT::model()->findAllByAttributes(array('pendaftaran_id'=>$model->pendaftaran_id),"karcis_id is not null");
                $modAntrian->tglantrian = $format->formatDateTimeForUser($modAntrian->tglantrian);
            }

            if(isset($idSep)){
                $modSep= PPSepT::model()->findByPk($idSep);
            }
			
			if(isset($_POST['bookingkamar_id'])){ //dari informasi booking kamar
				if(!empty($_POST['bookingkamar_id'])){
					$modBookingKamar = PPBookingKamarT::model()->findByPk($_POST['bookingkamar_id']);
					$modPasien = PPPasienM::model()->findByPk($modBookingKamar->pasien_id);
					if($modPasien->ispasienluar == TRUE){
						$modPasien->no_rekam_medik = null;
						$modPasien->pasien_id = null;
					}
					if(!empty($modBookingKamar->ruangan_id))
                        $modPasienAdmisi->ruangan_id = $modBookingKamar->ruangan_id;
					if(!empty($modBookingKamar->kamarruangan_id))
                        $modPasienAdmisi->kamarruangan_id = $modBookingKamar->kamarruangan_id;
                    if(!empty($modBookingKamar->kamarruangan_id))
                        $modPasienAdmisi->kelaspelayanan_id = $modBookingKamar->kelaspelayanan_id;
                    if(!empty($modBookingKamar->pegawai_id))
                        $modPasienAdmisi->pegawai_id = $modBookingKamar->pegawai_id;
				}
			}
			if(!empty($modPasien->pegawai_id)){
				$modPegawai->attributes = $modPasien->pegawai->attributes;
			}
            
            if(isset($_POST['PPPendaftaranT']))
            {
                $transaction = Yii::app()->db->beginTransaction();
                try {
                    $modPasien = $this->simpanPasien($modPasien, $_POST['PPPasienM']);

                    if($_POST['PPPendaftaranT']['is_adapjpasien']){
                        if(isset($_POST['PPPenanggungJawabM'])){
                            $modPenanggungJawab = $this->simpanPenanggungjawab($modPenanggungJawab, $_POST['PPPenanggungJawabM']);
                        }
                    }else{
                        $this->penanggungjawabtersimpan = true; 
                    }
                    
                    if($_POST['PPPendaftaranT']['is_pasienrujukan']){
                        if(isset($_POST['PPRujukanT'])){
                            $modRujukan = $this->simpanRujukan($modRujukan, $_POST['PPRujukanT']);
                        }
                    }else{
                        $this->rujukantersimpan = true; 
                    }

                    if($_POST['PPPendaftaranT']['is_bpjs']){
                        if(isset($_POST['PPRujukanbpjsT'])){
                            $modRujukanBpjs = $this->simpanRujukanBpjs($modRujukanBpjs, $_POST['PPRujukanbpjsT']);
                        }
                    }else{
                        $this->rujukantersimpan = true; 
                    }
                    
                    if(isset($_POST['PPAsuransipasienM'])){
                        if(isset($_POST['PPAsuransipasienM']['asuransipasien_id'])){
                            if(!empty($_POST['PPAsuransipasienM']['asuransipasien_id'])){
                                $modAsuransiPasien = PPAsuransipasienM::model()->findByPk($_POST['PPAsuransipasienM']['asuransipasien_id']);
                            }
                        }
						$modAsuransiPasien = $this->simpanAsuransiPasien($modAsuransiPasien, $_POST['PPPasienAdmisiT'], $modPasien, $_POST['PPAsuransipasienM']);
                    }else{
                        $this->asuransipasientersimpan = true;
                    }
                    
                    if(isset($_POST['PPAsuransipasienbpjsM'])){
                        if(isset($_POST['PPAsuransipasienbpjsM']['asuransipasien_id'])){
                            if(!empty($_POST['PPAsuransipasienbpjsM']['asuransipasien_id'])){
                                $modAsuransiPasienBpjs = PPAsuransipasienM::model()->findByPk($_POST['PPAsuransipasienbpjsM']['asuransipasien_id']);
                            }
                        }
						$modAsuransiPasienBpjs = $this->simpanAsuransiPasien($modAsuransiPasienBpjs, $_POST['PPPasienAdmisiT'], $modPasien, $_POST['PPAsuransipasienbpjsM']);
                    }else{
                        $this->asuransipasientersimpan = true;
                    }
                    
                    $model->ruangan_id = $modPasienAdmisi->ruangan_id;
                    $model->kelaspelayanan_id = $modPasienAdmisi->kelaspelayanan_id;
                    $model->pegawai_id = $modPasienAdmisi->pegawai_id;
                    $model->carabayar_id = $modPasienAdmisi->carabayar_id;
                    $model->penjamin_id = $modPasienAdmisi->penjamin_id;

                    if($_POST['PPPendaftaranT']['is_bpjs']){
                        $model = $this->simpanPendaftaranRI($model,$modPasien,$modRujukanBpjs,$modPenanggungJawab, $_POST['PPPendaftaranT'], $_POST['PPPasienM'], $_POST['PPPasienAdmisiT'], $modAsuransiPasienBpjs);
                        $modSep = $this->simpanSep($model,$modPasien,$modRujukanBpjs,$modAsuransiPasienBpjs,$_POST['PPSepT']);
                    }else{
                        $model = $this->simpanPendaftaranRI($model,$modPasien,$modRujukan,$modPenanggungJawab, $_POST['PPPendaftaranT'], $_POST['PPPasienM'], $_POST['PPPasienAdmisiT'], $modAsuransiPasien);
                    }

                    $modPasienAdmisi = $this->simpanPasienAdmisi($model,$modPasien,$modPasienAdmisi,$_POST['PPPasienAdmisiT']);
					
					$this->simpanMasukKamar($model, $modPasien, $modPasienAdmisi);
                    
					if(isset($_POST['PPAsuransipasienbadakM'])){
						if(isset($_POST['PPAsuransipasienbadakM']['asuransipasien_id'])){
							if(!empty($_POST['PPAsuransipasienbadakM']['asuransipasien_id'])){
								$modAsuransiPasienBadak = PPAsuransipasienM::model()->findByPk($_POST['PPAsuransipasienbadakM']['asuransipasien_id']);
							}
						}
						$modAsuransiPasienBadak = $this->simpanAsuransiPasien($modAsuransiPasienBadak, $_POST['PPPendaftaranT'], $modPasien, $_POST['PPAsuransipasienbadakM']);
					}else{
						$this->asuransipasientersimpan = true;
					}
					
					if(isset($_POST['PPAsuransipasiendepartemenM'])){
						if(isset($_POST['PPAsuransipasiendepartemenM']['asuransipasien_id'])){
							if(!empty($_POST['PPAsuransipasiendepartemenM']['asuransipasien_id'])){
								$modAsuransiPasienDepartemen = PPAsuransipasienM::model()->findByPk($_POST['PPAsuransipasiendepartemenM']['asuransipasien_id']);
							}
						}
						$modAsuransiPasienDepartemen = $this->simpanAsuransiPasien($modAsuransiPasienDepartemen, $_POST['PPPendaftaranT'], $modPasien, $_POST['PPAsuransipasiendepartemenM']);
					}else{
						$this->asuransipasientersimpan = true;
					}
					
					if(isset($_POST['PPAsuransipasienpegawaiM'])){
						if(isset($_POST['PPAsuransipasienpegawaiM']['asuransipasien_id'])){
							if(!empty($_POST['PPAsuransipasienpegawaiM']['asuransipasien_id'])){
								$modAsuransiPasienPekerja = PPAsuransipasienM::model()->findByPk($_POST['PPAsuransipasienpegawaiM']['asuransipasien_id']);
							}
						}
						$modAsuransiPasienPekerja = $this->simpanAsuransiPasien($modAsuransiPasienPekerja, $_POST['PPPendaftaranT'], $modPasien, $_POST['PPAsuransipasienpegawaiM']);
					}else{
						$this->asuransipasientersimpan = true;
					}

                    $this->karcistersimpan = true;
                    $this->komponentindakantersimpan = true;
                    if($_POST['PPPendaftaranT']['is_adakarcis']){
                        if(isset($_POST['PPTindakanPelayananT'])){
                            if(count($_POST['PPTindakanPelayananT']) > 0){
                                foreach($_POST['PPTindakanPelayananT'] as $i => $karcis){
                                    if($karcis['is_pilihtindakan']){
                                        $dataTindakans[$i] = $this->simpanKarcisRI($modTindakan, $model , $modPasienAdmisi, $karcis);
                                    }
                                }
                            }
                            if(isset($_POST['PPPendaftaranT']['is_bayarkarcis'])){ //fitur belum ada >> RND-666
                                if($_POST['PPPendaftaranT']['is_bayarkarcis']){ //jika di ceklis
                                }
                            }
                        }
                    }
                    
                    if($this->pasientersimpan && $this->pendaftarantersimpan && $this->penanggungjawabtersimpan && $this->rujukantersimpan && $this->karcistersimpan && $this->komponentindakantersimpan && $this->admisitersimpan && $this->masukkamartersimpan && $this->asuransipasientersimpan){
                        
                        // SMS GATEWAY
                        $modPegawai = $model->pegawai;
                        $modRuangan = $model->ruangan;
                        $sms = new Sms();
                        $smspasien = 1;
                        $smsdokter = 1;
                        $smspenanggungjawab = 1;
                        foreach ($modSmsgateway as $i => $smsgateway) {
                            $isiPesan = $smsgateway->templatesms;

                            $attributes = $modPasien->getAttributes();
                            foreach($attributes as $attributes => $value){
                                $isiPesan = str_replace("{{".$attributes."}}",$value,$isiPesan);
                            }
                            $attributes = $modPenanggungJawab->getAttributes();
                            foreach($attributes as $attributes => $value){
                                $isiPesan = str_replace("{{".$attributes."}}",$value,$isiPesan);
                            }
                            $attributes = $modPegawai->getAttributes();
                            foreach($attributes as $attributes => $value){
                                $isiPesan = str_replace("{{".$attributes."}}",$value,$isiPesan);
                            }
                            $attributes = $model->getAttributes();
                            foreach($attributes as $attributes => $value){
                                $isiPesan = str_replace("{{".$attributes."}}",$value,$isiPesan);
                            }
                            $attributes = $modRuangan->getAttributes();
                            foreach($attributes as $attributes => $value){
                                $isiPesan = str_replace("{{".$attributes."}}",$value,$isiPesan);
                            }
                            $isiPesan = str_replace("{{hari}}",MyFormatter::getDayName($model->tgl_pendaftaran),$isiPesan);
                            $isiPesan = str_replace("{{nama_rumahsakit}}",Yii::app()->user->getState('nama_rumahsakit'),$isiPesan);
                            
                            if($smsgateway->tujuansms == Params::TUJUANSMS_PASIEN && $smsgateway->statussms){
                                if(!empty($modPasien->no_mobile_pasien)){
                                    $sms->kirim($modPasien->no_mobile_pasien,$isiPesan);
                                }else{
                                    $smspasien = 0;
                                }
                            }elseif($smsgateway->tujuansms == Params::TUJUANSMS_DOKTER && $smsgateway->statussms){
                                if(!empty($modPegawai->nomobile_pegawai)){
                                    $sms->kirim($modPegawai->nomobile_pegawai,$isiPesan);
                                }else{
                                    $smsdokter = 0;
                                }
                            }elseif($smsgateway->tujuansms == Params::TUJUANSMS_PENANGGUNGJAWAB && $smsgateway->statussms){
                                if(!empty($modPenanggungJawab->no_mobilepj)){
                                    $sms->kirim($modPenanggungJawab->no_mobilepj,$isiPesan);
                                }else{
                                    $smspenanggungjawab = 0;
                                }
                            }
                            
                        }
                        // END SMS GATEWAY

                        $transaction->commit();
                        Yii::app()->user->setFlash('success', "Data pasien berhasil disimpan!");
                        // RND-666 >>>  $this->redirect(array('view','id'=>$model->pendaftaran_id,'sukses'=>1));
                        if($this->septersimpan){
                            $this->redirect(array('index','id'=>$model->pendaftaran_id,'idSep'=>$modSep->sep_id,'sukses'=>1,'smspasien'=>$smspasien,'smsdokter'=>$smsdokter,'smspenanggungjawab'=>$smspenanggungjawab));
                        }else{
                            $this->redirect(array('index','id'=>$model->pendaftaran_id,'sukses'=>1,'smspasien'=>$smspasien,'smsdokter'=>$smsdokter,'smspenanggungjawab'=>$smspenanggungjawab));
                        }
                    }else{
                        $transaction->rollback();
                        $model->isNewRecord = true;
                        Yii::app()->user->setFlash('error',"Data pasien gagal disimpan !");
                    }
                } catch (Exception $exc) {
                    $transaction->rollback();
                    $model->isNewRecord = true;
                    $btn_ulang = "<a class='btn btn-danger' href='javascript:document.location.reload();' rel='tooltip' title='Klik tombol ini lalu klik \"Resend\" '>"
                            . "<i class='icon-refresh icon-white'></i> Simpan Ulang"
                            . "</a>";
                    Yii::app()->user->setFlash('error',"Data pasien gagal disimpan ! ".$btn_ulang." ".MyExceptionMessage::getMessage($exc,true));
                }
            }
    
            $this->render('index',array(
                'model'=>$model,
                'modPasien'=>$modPasien,
				'modPegawai'=>$modPegawai,
                'modPasienAdmisi'=>$modPasienAdmisi,
                'modPenanggungJawab'=>$modPenanggungJawab,
                'modRujukan'=>$modRujukan,
                'modRujukanBpjs'=>$modRujukanBpjs,
                'modTindakan'=>$modTindakan,
                'modAntrian'=>$modAntrian,
                'dataTindakans'=>$dataTindakans,
                'modAsuransiPasien'=>$modAsuransiPasien,
                'modAsuransiPasienBpjs'=>$modAsuransiPasienBpjs,
				'modAsuransiPasienBadak'=>$modAsuransiPasienBadak,
                'modAsuransiPasienPekerja'=>$modAsuransiPasienPekerja,
                'modAsuransiPasienDepartemen'=>$modAsuransiPasienDepartemen,
                'modSep'=>$modSep,
                'modSmsgateway'=>$modSmsgateway,
				'modKarcisV'=>$modKarcisV
            ));
	}
        
        /**
         * proses simpan pendaftaran
         * @return type
         */
        public function simpanPendaftaranRI($model,$modPasien,$modRujukan,$modPenanggungJawab,$post, $postPasien, $postAdmisi, $modAsuransiPasien){
            $format = new MyFormatter();
            $model->attributes = $post;
            $model->attributes = $postAdmisi;
            $model->pasien_id = $modPasien->pasien_id;
            $model->penanggungjawab_id = $modPenanggungJawab->penanggungjawab_id;
            $model->rujukan_id = $modRujukan->rujukan_id;
            $model->kelompokumur_id = CustomFunction::getKelompokUmur($modPasien->tanggal_lahir);
            $model->instalasi_id = (isset($model->ruangan_id) ? RuanganM::model()->findByPk($model->ruangan_id)->instalasi_id : null);
            $model->no_urutantri = MyGenerator::noAntrian($model->ruangan_id);
            $model->golonganumur_id = CustomFunction::getGolonganUmur($modPasien->tanggal_lahir);
            $model->umur = CustomFunction::getUmur($modPasien->tanggal_lahir);
            $model->statusperiksa = Params::STATUSPERIKSA_SEDANG_DIRAWATINAP;
            $model->statuspasien = (empty($postPasien['pasien_id']) ? Params::STATUSPASIEN_BARU : Params::STATUSPASIEN_LAMA);
            $model->kunjungan = CustomFunction::getKunjungan($modPasien, $model->ruangan_id);
            $model->shift_id = Yii::app()->user->getState('shift_id');
            $model->kelompokumur_id = $modPasien->kelompokumur_id;
            $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
            $model->create_loginpemakai_id = Yii::app()->user->id;
            $model->create_time = date("Y-m-d H:i:s");
			if(Yii::app()->user->getState('tgltransaksimundur') && !empty($postAdmisi['tgladmisi'])){
				$model->tgl_pendaftaran = $format->formatDateTimeForDb($postAdmisi['tgladmisi']);
			}else{
				$model->tgl_pendaftaran = date("Y-m-d H:i:s");
			}
            $model->no_pendaftaran = MyGenerator::noPendaftaran($model->instalasi_id, $model->tgl_pendaftaran);
            $model->kelompokumur_id = CustomFunction::getKelompokUmur($modPasien->tanggal_lahir);
            $model->statusmasuk = (!empty($model->rujukan_id) ? Params::STATUSMASUK_RUJUKAN : Params::STATUSMASUK_NONRUJUKAN);
            $model->tgl_konfirmasi = $format->formatDateTimeForDb($model->tgl_konfirmasi);
            $model->tglselesaiperiksa = $format->formatDateTimeForDb($model->tglselesaiperiksa);
            $model->tglrenkontrol = $format->formatDateTimeForDb($model->tglrenkontrol);
            $model->asuransipasien_id = $modAsuransiPasien->asuransipasien_id;
            $model->alihstatus = TRUE; //RND-6114
            $model->keterangan_pendaftaran = $post['keterangan_pendaftaran'];
			
            if($model->save()){
                if(!empty($model->antrian_id)){
                    PPAntrianT::model()->updateByPk($model->antrian_id,array('pendaftaran_id'=>$model->pendaftaran_id));
                }
                $this->pendaftarantersimpan = true;
            }
            return $model;
        }
        /**
         * simpan PPPasienAdmisiT
         * @param modPasienAdmisi $modPasienAdmisi
         * @param type $model
         * @param type $modPasien
         * @param type $post
         * @return \modPasienAdmisi
         */
        public function simpanPasienAdmisi($model,$modPasien,$modPasienAdmisi,$post)
        {
            $format = new MyFormatter();
            $modPasienAdmisi = new $modPasienAdmisi;
            $modPasienAdmisi->attributes = $post;
            if($model->instalasi_id == Params::INSTALASI_ID_RJ){
                $caramasuk_id = Params::CARAMASUK_ID_RJ;
            }else if($model->instalasi_id == Params::INSTALASI_ID_RD){
                $caramasuk_id = Params::CARAMASUK_ID_RD;
            }else{
                $caramasuk_id = Params::CARAMASUK_ID_LANGSUNG_RI;
            }
            $modPasienAdmisi->caramasuk_id = $caramasuk_id;
            $modPasienAdmisi->pendaftaran_id = $model->pendaftaran_id;
            $modPasienAdmisi->tglpendaftaran = $model->tgl_pendaftaran;
			if(Yii::app()->user->getState('tgltransaksimundur') && !empty($modPasienAdmisi->tgladmisi)){
				$modPasienAdmisi->tgladmisi = $format->formatDateTimeForDb($modPasienAdmisi->tgladmisi);
			}else{
				$modPasienAdmisi->tgladmisi = date("Y-m-d H:i:s");
			}
            $modPasienAdmisi->pasien_id = $model->pasien_id;
            $modPasienAdmisi->shift_id = Yii::app()->user->getState('shift_id');
            $modPasienAdmisi->kunjungan = CustomFunction::getKunjungan($modPasien, $modPasienAdmisi->ruangan_id);
            $modPasienAdmisi->create_ruangan = Yii::app()->user->getState('ruangan_id');
            $modPasienAdmisi->tglpulang = null;
            $modPasienAdmisi->rencanapulang = null;
            $modPasienAdmisi->create_time = date("Y-m-d H:i:s");
            $modPasienAdmisi->create_loginpemakai_id = Yii::app()->user->id;
            
            if($modPasienAdmisi->save()) {
                //jika ada booking kamar (BELUM INTEGRASI)
//                BookingkamarT::model()->updateByPk($modPasienAdmisi->bookingkamar_id,array('pasienadmisi_id'=>$modPasienAdmisi->pasienadmisi_id,'pendaftaran_id'=>$modPasienAdmisi->pendaftaran_id));
                if(PendaftaranT::model()->updateByPk($modPasienAdmisi->pendaftaran_id,array('pasienadmisi_id'=>$modPasienAdmisi->pasienadmisi_id))){
                    $this->admisitersimpan = true;
                }else{
                    $this->admisitersimpan = false;
                }
            } else {
                $this->admisitersimpan = false;
            }
            return $modPasienAdmisi;
        }
        
        /**
         * simpan MasukkamarT
         * ubah : KamarruanganM.kamarruangan_status, KamarruanganM.keterangan_kamar
         * @param type $model
         * @param type $modPasien
         * @param type $modPasienAdmisi
         */
        public function simpanMasukKamar($model, $modPasien, $modPasienAdmisi)
        {
            $modMasukKamar = new MasukkamarT;
            $modMasukKamar->carabayar_id=$model->carabayar_id;
            $modMasukKamar->kamarruangan_id= (!empty($modPasienAdmisi->kamarruangan_id)) ? $modPasienAdmisi->kamarruangan_id : null;
            $modMasukKamar->kelaspelayanan_id = $modPasienAdmisi->kelaspelayanan_id;
            $modMasukKamar->ruangan_id= $modPasienAdmisi->ruangan_id;
            $modMasukKamar->pasienadmisi_id=$modPasienAdmisi->pasienadmisi_id;
            $modMasukKamar->pegawai_id=$model->pegawai_id;
            $modMasukKamar->penjamin_id=$model->penjamin_id;
            $modMasukKamar->shift_id=Yii::app()->user->getState('shift_id');
            $modMasukKamar->tglmasukkamar=date('Y-m-d H:i:s');
            $modMasukKamar->nomasukkamar=MyGenerator::noMasukKamar($modMasukKamar->ruangan_id);
            $modMasukKamar->jammasukkamar=date('H:i:s');
            $modMasukKamar->tglkeluarkamar=null;
            $modMasukKamar->jamkeluarkamar=null;
            $modMasukKamar->lamadirawat_kamar=null;
            $modMasukKamar->create_time = date("Y-m-d H:i:s");
            $modMasukKamar->create_loginpemakai_id = Yii::app()->user->id;
            $modMasukKamar->create_ruangan = Yii::app()->user->getState('ruangan_id');
			
            if($modMasukKamar->save()){
				if(!empty($modMasukKamar->kamarruangan_id)){
					KamarruanganM::model()->updateByPk($modMasukKamar->kamarruangan_id,array('kamarruangan_status'=>false, 'keterangan_kamar'=>'IN USE'));
				}
                $this->masukkamartersimpan=true;
            }else{
                $this->masukkamartersimpan=false;
            }
        }  
        
        /**
         * proses simpan karcis
         * @param type $modTindakan
         * @param type $post
         * @return type
         */
        public function simpanKarcisRI($modTindakan, $model, $modPasienAdmisi ,$post){
            $modTindakan->attributes = $post;
            $modTindakan->create_time = date("Y-m-d H:i:s");
            $modTindakan->create_loginpemakai_id = Yii::app()->user->id;
            $modTindakan->instalasi_id=Yii::app()->user->getState("instalasi_id");
            $modTindakan->ruangan_id = Yii::app()->user->getState('ruangan_id');
            $modTindakan->pendaftaran_id=$model->pendaftaran_id;
            $modTindakan->pasienadmisi_id = $modPasienAdmisi->pasienadmisi_id;
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
                $cekTindakanKomponen = 0;
				$this->komponentindakantersimpan= true; //SIMPAN KOMPONEN DILAKUKAN DI TRIGGER DB
                $this->karcistersimpan = true;
            }else{
                $this->karcistersimpan = false;
            }
                
            return $modTindakan;
        }

        /**
         *penggunaannya
         * 1. digunakan di pendaftaran rawat inap
         * @param type $encode
         * @param type $namaModel
         * @param type $attr 
         */
        public function actionSetDropdownKamarKosong($encode=false,$namaModel='',$attr='')
        {
            if(Yii::app()->request->isAjaxRequest) {
                $ruangan_id = (isset($_POST['ruangan_id']) ? $_POST['ruangan_id'] : null);
                if (empty($ruangan_id) && isset($_POST[$namaModel]['ruangan_id']))
                    $ruangan_id = $_POST[$namaModel]['ruangan_id'];

                $bookingkamar_id = (isset($_POST['bookingkamar_id']) ? $_POST['bookingkamar_id'] : null);
                if (empty($bookingkamar_id) && isset($_POST[$namaModel]['bookingkamar_id']))
                    $bookingkamar_id = $_POST[$namaModel]['bookingkamar_id'];

                $kamarKosong = array();
                if(!empty($ruangan_id)) {
                    if(!empty($bookingkamar_id)){
                        $kamarKosong = KamarruanganM::model()->findAllByAttributes(array('ruangan_id'=>$ruangan_id,'kamarruangan_status'=>true));

                        $modBookingKamar = BookingkamarT::model()->findByPk($bookingkamar_id);
                    }else{
                        $kamarKosong = KamarruanganM::model()->findAllByAttributes(array('ruangan_id'=>$ruangan_id,'kamarruangan_status'=>true));
                    }
                    $kamarKosong = CHtml::listData($kamarKosong,'kamarruangan_id','KamarDanTempatTidur');
                }

                if($encode){
                    echo CJSON::encode($kamarKosong);
                } else {
                    if(empty($kamarKosong)){
                        echo CHtml::tag('option', array('value'=>''),CHtml::encode("-- Pilih --"),true);
                    }else{
                        echo CHtml::tag('option', array('value'=>''),CHtml::encode("-- Pilih --"),true);
                        foreach($kamarKosong as $value=>$name)
                        {
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
                if(isset($_POST['PPPendaftaranT'])){
                    $format = new MyFormatter();
                    $model=new PPPendaftaranT;
                    $modPasien=new PPPasienM;
					$modPegawai=new PPPegawaiM;
                    $modPasienAdmisi = new PPPasienAdmisiT;
                    $modPenanggungJawab = null;
                    $modRujukan=null;
                    $modTindakan = null;

                    $model->attributes = $_POST['PPPendaftaranT'];
					$model->keterangan_pendaftaran = $_POST['PPPendaftaranT']['keterangan_pendaftaran'];
                    $modPasien->attributes = $_POST['PPPasienM'];
					if(!empty($modPasien->pegawai_id)){
	                    $modPegawai->attributes = $modPasien->pegawai->attributes;
					}
                    $modPasienAdmisi->attributes = $_POST['PPPasienAdmisiT'];
                    if($_POST['PPPendaftaranT']['is_adapjpasien']){
                        if(isset($_POST['PPPenanggungJawabM'])){
                            $modPenanggungJawab=new PPPenanggungJawabM;
                            $modPenanggungJawab->attributes = $_POST['PPPenanggungJawabM'];
                        }
                    }

                    if($_POST['PPPendaftaranT']['is_pasienrujukan']){
                        if(isset($_POST['PPRujukanT'])){
                            $modRujukan=new PPRujukanT;
                            $modRujukan->attributes = $_POST['PPRujukanT'];
                            $modRujukan->rujukandari_id = !empty($modRujukan->rujukandari_id) ? $modRujukan->rujukandari_id : null;
                        }
                    }
                    if($_POST['PPPendaftaranT']['is_adakarcis']){
                        if(isset($_POST['PPTindakanPelayananT'])){
                            if(count($_POST['PPTindakanPelayananT']) > 0){
                                foreach($_POST['PPTindakanPelayananT'] as $i => $karcis){
                                    if($karcis['is_pilihtindakan']){
                                        $modTindakan=new PPTindakanPelayananT;
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
                        'modPasienAdmisi'=>$modPasienAdmisi,
                        'modPenanggungJawab'=>$modPenanggungJawab,
                        'modRujukan'=>$modRujukan,
                        'modTindakan'=>$modTindakan,
                        'format'=>$format,
                ), true)));
                exit;
            }
        }
        
        /**
         * @param type $pendaftaran_id
         */
        public function actionPrintStatusRI($pendaftaran_id = null, $pasienadmisi_id = null) 
        {
            
            $this->layout='//layouts/printWindows';
            $format = new MyFormatter;
            if (!empty($pasienadmisi_id)) {
                $modPendaftaran = PendaftaranT::model()->findByAttributes(array("pasienadmisi_id"=>$pasienadmisi_id));
                $pendaftaran_id = $modPendaftaran->pendaftaran_id;
            } else {
                $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
            }
            $modPasienAdmisi = PasienadmisiT::model()->findByAttributes(array('pendaftaran_id'=>$pendaftaran_id));
			$modPasien=  PasienM::model()->findByPk($modPendaftaran->pasien_id);
            $karcis_id = null;
            $modTindakan =  TindakanpelayananT::model()->findByAttributes(array('pasienadmisi_id'=>$modPasienAdmisi->pasienadmisi_id, 'pendaftaran_id'=>$modPendaftaran->pendaftaran_id),"karcis_id IS NOT NULL");
            $judul_print = 'Kunjungan Rawat Inap';
            $this->render('pendaftaranPenjadwalan.views.pendaftaranRawatInap.printStatusRI', array(
                                'format'=>$format,
                                'modPasienAdmisi'=>$modPasienAdmisi,
                                'modPendaftaran'=>$modPendaftaran,
                                'judul_print'=>$judul_print,
                                'modPasien'=>$modPasien,
                                'modTindakan'=>$modTindakan,
            ));
        } 
        
        /**
         * @param type $pendaftaran_id
         */
        public function actionPrintKarcisRI($pasienadmisi_id) 
        {
            $this->layout='//layouts/printWindows';
            $format = new MyFormatter;
            $modPasienAdmisi = PasienadmisiT::model()->findByPk($pasienadmisi_id);
            $modPendaftaran = PendaftaranT::model()->findByPk($modPasienAdmisi->pendaftaran_id);
            $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
            $modPegawai = PPPegawaiM::model()->findByPk(Yii::app()->user->id);

            $karcis_id = null;
            $modTindakan =  TindakanpelayananT::model()->findByAttributes(array('pasienadmisi_id'=>$modPasienAdmisi->pasienadmisi_id, 'pendaftaran_id'=>$modPendaftaran->pendaftaran_id),"karcis_id IS NOT NULL");
            $judul_print = 'Karcis '.$modPasienAdmisi->ruangan->instalasi->instalasi_nama;
            $this->render('pendaftaranPenjadwalan.views.pendaftaranRawatInap.printKarcisRI', array(
                                'format'=>$format,
                                'modPendaftaran'=>$modPendaftaran,
                                'judul_print'=>$judul_print,
                                'modPasien'=>$modPasien,
                                'modTindakan'=>$modTindakan,
                                'modPegawai'=>$modPegawai,
            ));
        } 
		
		/*
         * Mencari kelas pelayanan berdasarkan ruangan_id di tabel KelasruanganM
         * and open the template in the editor.
         */
        public function actionSetDropdownKelasPelayananRI()
        {
            if(Yii::app()->request->isAjaxRequest) {
                $ruangan_id = $_POST['ruangan_id'];
                $kelasPelayanan = null;
				$option = null;
                if($ruangan_id){
                    $kelasPelayanan = KelasruanganM::model()->with('kelaspelayanan')->findAll('ruangan_id='.$ruangan_id.' and kelaspelayanan_aktif = true');
                    $kelasPelayanan=CHtml::listData($kelasPelayanan,'kelaspelayanan_id','kelaspelayanan.kelaspelayanan_nama');
                }
                if(empty($kelasPelayanan)){
                    $option .= CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
                }else{
                    $option .= CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
                    foreach($kelasPelayanan as $value=>$name)
                    {
                        $option .= CHtml::tag('option', array('value'=>$value),CHtml::encode($name),true);
                    }
                }
				$dataList['listKelas'] = $option;
                echo json_encode($dataList);
                Yii::app()->end();
            }
        }
		
		public function actionPrintLabelGelang($pendaftaran_id) 
		{
			$this->layout='//layouts/printWindows';
			$format = new MyFormatter;
			$modPendaftaran = PPPendaftaranT::model()->findByPk($pendaftaran_id);

			$judul_print = 'Label Gelang';
			$this->render('printLabelGelang', array(
								'modPendaftaran'=>$modPendaftaran
			));
		}

}
