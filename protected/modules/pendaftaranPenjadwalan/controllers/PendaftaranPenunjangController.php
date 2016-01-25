<?php
Yii::import('pendaftaranPenjadwalan.controllers.PendaftaranRawatJalanController');
Yii::import('laboratorium.models.LBHasilPemeriksaanLabT');
class PendaftaranPenunjangController extends PendaftaranRawatJalanController
{
        /**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column1';
        public $defaultAction = 'index';
        public $path_view = "pendaftaranPenjadwalan.views.pendaftaranRawatJalan.";
        
        public $pasienpenunjangtersimpan = false;
        public $tindakanpelayanantersimpan = true;
        public $hasilpemeriksaantersimpan = true; //dilooping / khusus lab klinik
	/**
	 * Index transaksi pendaftaran
	 */
	public function actionIndex($id = null, $idSep = null, $idAntrian = null)
	{
            $format = new MyFormatter();
            $model=new PPPendaftaranT;
            $modPasien=new PPPasienM;
            $modPegawai=new PPPegawaiM;
            $modPenanggungJawab=new PPPenanggungJawabM;
            $modPasienPenunjang = new PPPasienMasukPenunjangT;
            $modTindakan = new TindakanpelayananT;
            $modAsuransiPasien=new PPAsuransipasienM;
            $modAsuransiPasienBpjs =new PPAsuransipasienbpjsM;
			$modAsuransiPasienBadak =new PPAsuransipasienbadakM();
            $modAsuransiPasienDepartemen =new PPAsuransipasiendepartemenM();
            $modAsuransiPasienPekerja =new PPAsuransipasienpegawaiM();
            $modSep=new PPSepT;
            $modAntrian = new PPAntrianT;
			$model->is_pasienrujukan = 1;
			$model->is_asubadak = 0;
            $model->is_asudepartemen = 0;
            $model->is_asupekerja = 0;
			
            $criteria = new CDbCriteria();
            $criteria->with = array('instalasi');
            $criteria->addCondition('instalasi.instalasirujukaninternal = TRUE');
            $criteria->addCondition('ruangan_aktif = TRUE');
            $criteria->order = "instalasi.instalasi_id";
            $ruanganpenunjangs = RuanganM::model()->findAll($criteria);
            if(count($ruanganpenunjangs) > 0){
                foreach($ruanganpenunjangs AS $i=>$ruangan){
                    if ($ruangan->ruangan_id != Params::RUANGAN_ID_LAB_KLINIK && $ruangan->ruangan_id != Params::RUANGAN_ID_RAD) continue;
                    $modPasienMasukPenunjangs[$i] = new PPPasienMasukPenunjangT;
                    $modPasienMasukPenunjangs[$i]->is_pilihpenunjang = 0;
                    $modPasienMasukPenunjangs[$i]->ruangan_id = $ruangan->ruangan_id;
                    $modKarcis[$i] = array();
                }
            }
            $modRujukan=new PPRujukanT;
            $modRujukanBpjs=new PPRujukanbpjsT;
            $modPembayaran = new PPPembayaranpelayananT();
            $modPasien->propinsi_id = Yii::app()->user->getState('propinsi_id');
            $modPasien->kabupaten_id = Yii::app()->user->getState('kabupaten_id');
            $modPasien->kecamatan_id = Yii::app()->user->getState('kecamatan_id');
            $modPasien->kelurahan_id = Yii::app()->user->getState('kelurahan_id');
            $modPasien->warga_negara = Params::DEFAULT_WARGANEGARA;
            $modPasien->agama = Params::DEFAULT_AGAMA;

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
                $modPasien=PPPasienM::model()->findByPk($model->pasien_id);
                if(isset($idSep)){
                    $model->is_bpjs = 1; 
                    $modRujukanBpjs= PPRujukanbpjsT::model()->findByPk($model->rujukan_id);
                    $modAsuransiPasienBpjs = PPAsuransipasienbpjsM::model()->findByPk($model->asuransipasien_id);
                }
                if(!empty($model->penanggungjawab_id)){
                    $modPenanggungJawab=PPPenanggungJawabM::model()->findByPk($model->penanggungjawab_id);
                }
                if(!empty($model->rujukan_id)){
                    $modRujukan=PPRujukanT::model()->findByPk($model->rujukan_id);
                }
                if(count($ruanganpenunjangs) > 0){
                foreach($ruanganpenunjangs AS $i=>$ruangan){
                        $loadPasienMasukPenunjangs = PPPasienMasukPenunjangT::model()->findByAttributes(array('pendaftaran_id'=>$model->pendaftaran_id,'ruangan_id'=>$ruangan->ruangan_id));
                        if(isset($loadPasienMasukPenunjangs)){
                            $modPasienMasukPenunjangs[$i] = $loadPasienMasukPenunjangs;
                            $modPasienMasukPenunjangs[$i]->is_pilihpenunjang = 1;
                            $loadTindakans = PPTindakanPelayananT::model()->findAllByAttributes(array('pendaftaran_id'=>$model->pendaftaran_id, 'pasienmasukpenunjang_id'=>$modPasienMasukPenunjangs[$i]->pasienmasukpenunjang_id),"karcis_id is not null");
                            if(isset($loadTindakans)){
                                if(count($loadTindakans) > 0){
                                    foreach($loadTindakans AS $ii => $tindakan){
                                        $modKarcis[$i][$ii] = PPKarcisV::model()->findByAttributes(array('karcis_id'=>$tindakan->karcis_id));
										$modKarcis[$i][$ii]->harga_tariftindakan = $tindakan->tarif_tindakan;
                                    }
                                }
                            }
                        }
                    }
                }
            }
			if(!empty($modPasien->pegawai_id)){
				$modPegawai->attributes = $modPasien->pegawai->attributes;
			}
            if(isset($idSep)){
                $modSep= PPSepT::model()->findByPk($idSep);
            }
            
            if(isset($_POST['PPPendaftaranT']) && isset($_POST['PPPasienMasukPenunjangT']))
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
						$modAsuransiPasien = $this->simpanAsuransiPasien($modAsuransiPasien, $_POST['PPPendaftaranT'], $modPasien, $_POST['PPAsuransipasienM']);
                    }else{
                        $this->asuransipasientersimpan = true;
                    }
                    
                    if(isset($_POST['PPAsuransipasienbpjsM'])){
                        if(isset($_POST['PPAsuransipasienbpjsM']['asuransipasien_id'])){
                            if($_POST['PPAsuransipasienbpjsM']['asuransipasien_id']==""){
                                $modAsuransiPasienBpjs = PPAsuransipasienM::model()->findByPk($_POST['PPAsuransipasienbpjsM']['asuransipasien_id']);
                            }
                        }
						$modAsuransiPasienBpjs = $this->simpanAsuransiPasien($modAsuransiPasienBpjs, $_POST['PPPendaftaranT'], $modPasien, $_POST['PPAsuransipasienbpjsM']);
                    }else{
                        $this->asuransipasientersimpan = true;
                    }

                    // var_dump($_POST);
                    
                    // ambil dokter pasien punjang
                    if(isset($_POST['PPPasienMasukPenunjangT'])){
                        foreach ($_POST['PPPasienMasukPenunjangT'] as $item) {
                            if ($item['is_pilihpenunjang'] == 1) {
                                $model->pegawai_id = $item['pegawai_id'];
                                break;
                            }
                        }
                    }
                    
                    if($_POST['PPPendaftaranT']['is_bpjs']){
                        $model = $this->simpanPendaftaranPenunjang($model,$modPasien,$modRujukanBpjs,$modPenanggungJawab, $_POST['PPPendaftaranT'], $_POST['PPPasienM'],$modAsuransiPasienBpjs);
                        $modSep = $this->simpanSep($model,$modPasien,$modRujukanBpjs,$modAsuransiPasienBpjs,$_POST['PPSepT']);
                    }else{
                        $model = $this->simpanPendaftaranPenunjang($model,$modPasien,$modRujukan,$modPenanggungJawab, $_POST['PPPendaftaranT'], $_POST['PPPasienM'],$modAsuransiPasien);
                    }
                    
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
					
                    if(count($_POST['PPPasienMasukPenunjangT']) > 0){
                        foreach ($_POST['PPPasienMasukPenunjangT'] AS $i => $postPenunjang){
                            if($postPenunjang['is_pilihpenunjang']){
                                $modPasienMasukPenunjang = $this->simpanPasienPenunjang($model,$modPasien,$postPenunjang);
                                if($postPenunjang['ruangan_id'] == Params::RUANGAN_ID_LAB_KLINIK){
                                    $modHasilPemeriksaan = $this->simpanHasilPemeriksaanLab($modPasien, $modPasienMasukPenunjang);
                                }
                                $this->karcistersimpan = true;
                                $this->komponentindakantersimpan = true;
                                if(isset($postPenunjang['is_adakarcis']) && $postPenunjang['is_adakarcis']){
                                    if(isset($_POST['PPKarcisV'][$i])){
                                        if(count($_POST['PPKarcisV'][$i]) > 0){
                                            foreach($_POST['PPKarcisV'][$i] as $ii => $postkarcis){
                                                if($postkarcis['is_pilihkarcis']){
                                                    $modKarcis[$i][$ii] = $this->simpanTindakanPelayanan($model,$modPasienMasukPenunjang,$postkarcis);
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                    
                    if($this->pasientersimpan && $this->pendaftarantersimpan && $this->penanggungjawabtersimpan && $this->rujukantersimpan && $this->karcistersimpan && $this->tindakanpelayanantersimpan && $this->komponentindakantersimpan && $this->pasienpenunjangtersimpan && $this->asuransipasientersimpan){
                        
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
                        Yii::app()->user->setFlash('success', "Data pasien berhasil disimpan !");
//                      RND-666 >>>  $this->redirect(array('view','id'=>$model->pendaftaran_id,'sukses'=>1));
                        if($this->septersimpan){
                            $this->redirect(array('index','id'=>$model->pendaftaran_id,'idSep'=>$modSep->sep_id,'sukses'=>1,'smspasien'=>$smspasien,'smsdokter'=>$smsdokter,'smspenanggungjawab'=>$smspenanggungjawab));
                        }else{
                            $this->redirect(array('index','id'=>$model->pendaftaran_id,'sukses'=>1,'smspasien'=>$smspasien,'smsdokter'=>$smsdokter,'smspenanggungjawab'=>$smspenanggungjawab));
                        }
                    }else{
                        $transaction->rollback();
                        Yii::app()->user->setFlash('error',"Data pasien gagal disimpan !");
//                        echo "-".$this->pasientersimpan."<br>";
//                        echo "-".$this->pendaftarantersimpan."<br>";
//                        echo "-".$this->pasienpenunjangtersimpan."<br>";
//                        echo "-".$this->penanggungjawabtersimpan."<br>";
//                        echo "-".$this->rujukantersimpan."<br>";
//                        echo "-".$this->karcistersimpan."<br>";
//                        echo "-".$this->tindakanpelayanantersimpan."<br>";
//                        echo "-".$this->komponentindakantersimpan."<br>";
//                        exit;
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
                'modPegawai'=>$modPegawai,
                'modPenanggungJawab'=>$modPenanggungJawab,
                'modRujukan'=>$modRujukan,
                'modRujukanBpjs'=>$modRujukanBpjs,
                'ruanganpenunjangs'=>$ruanganpenunjangs,
                'modPasienMasukPenunjangs'=>$modPasienMasukPenunjangs,
                'modAsuransiPasien'=>$modAsuransiPasien,
                'modAsuransiPasienBpjs'=>$modAsuransiPasienBpjs,
				'modAsuransiPasienBadak'=>$modAsuransiPasienBadak,
                'modAsuransiPasienPekerja'=>$modAsuransiPasienPekerja,
                'modAsuransiPasienDepartemen'=>$modAsuransiPasienDepartemen,
                'modKarcis'=>$modKarcis,
                'modSep'=>$modSep,
                'modSmsgateway'=>$modSmsgateway,
                'modAntrian'=>$modAntrian,
            ));
	}
        
        /**
         * simpan LBHasilPemeriksaanLabT
         * copy dari: PendaftaranLaboratoriumController
         */
        public function simpanHasilPemeriksaanLab($modPasien, $modPasienMasukPenunjang){
            $modHasilPemeriksaan = new LBHasilPemeriksaanLabT;
            $modHasilPemeriksaan->attributes = $modPasienMasukPenunjang->attributes;
            $modHasilPemeriksaan->nohasilperiksalab = MyGenerator::noHasilPemeriksaanLK();
            $modHasilPemeriksaan->tglhasilpemeriksaanlab = $modPasienMasukPenunjang->tglmasukpenunjang;
            $modHasilPemeriksaan->hasil_kelompokumur = CustomFunction::getKelompokUmur($modPasien->tanggal_lahir);
            $modHasilPemeriksaan->hasil_jeniskelamin = $modPasien->jeniskelamin;
            $modHasilPemeriksaan->statusperiksahasil = Params::STATUSPERIKSAHASIL_BELUM;
            $modHasilPemeriksaan->create_ruangan = $modPasienMasukPenunjang->ruangan_id;

            if($modHasilPemeriksaan->validate()){
                $modHasilPemeriksaan->save();
            }else{
                $this->hasilpemeriksaantersimpan &= false;
            }
            return $modHasilPemeriksaan;
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
                    $modPenanggungJawab = null;
                    $modRujukan=null;
                    $modPasienMasukPenunjangs = array();
                    $modKarcis = array();
                    $modPengambilanSample = null;

                    $model->attributes = $_POST['PPPendaftaranT'];
					$model->keterangan_pendaftaran = $_POST['PPPendaftaranT']['keterangan_pendaftaran'];
                    $modPasien->attributes = $_POST['PPPasienM'];
					if(!empty($modPasien->pegawai_id)){
	                    $modPegawai->attributes = $modPasien->pegawai->attributes;
					}
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
                    
                    if(isset($_POST['PPPasienMasukPenunjangT'])){
                        foreach ($_POST['PPPasienMasukPenunjangT'] AS $i => $postPenunjang){
                            if($postPenunjang['is_pilihpenunjang']){
                                $modPasienMasukPenunjangs[$i] = new PPPasienMasukPenunjangT;
                                $modPasienMasukPenunjangs[$i] = $postPenunjang;
                                $modPasienMasukPenunjangs[$i]['ruangan'] = RuanganM::model()->findByPk($postPenunjang['ruangan_id']);
                                $modPasienMasukPenunjangs[$i]['kelaspelayanan'] = KelaspelayananM::model()->findByPk($postPenunjang['kelaspelayanan_id']);
                                $modPasienMasukPenunjangs[$i]['pegawai'] = PegawaiM::model()->findByPk($postPenunjang['pegawai_id']);
                            }
                            if(isset($_POST['PPKarcisV'][$i])){
                                foreach ($_POST['PPKarcisV'][$i] AS $ii => $postkarcis){
                                    if($postkarcis['is_pilihkarcis']){
                                        $modKarcis[$i] = PPKarcisV::model()->findByAttributes(array('karcis_id'=>$postkarcis['karcis_id'],'jenistarif_id'=>$postkarcis['jenistarif_id'])); //$i karena karcis digabung
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
                        'modRujukan'=>$modRujukan,
                        'modPasienMasukPenunjangs'=>$modPasienMasukPenunjangs,
                        'modKarcis'=>$modKarcis,
                        'format'=>$format,
                ), true)));
                exit;
            }
	}       
        /**
         * proses simpan / ubah data pendaftaran
         * @return type
         */
        public function simpanPendaftaranPenunjang($model,$modPasien,$modRujukan,$modPenanggungJawab,$post, $postPasien, $modAsuransiPasien){
            $format = new MyFormatter();
            $model->attributes = $post;
            $model->pasien_id = $modPasien->pasien_id;
            $model->penanggungjawab_id = $modPenanggungJawab->penanggungjawab_id;
            $model->rujukan_id = $modRujukan->rujukan_id;
            $model->kelompokumur_id = CustomFunction::getKelompokUmur($modPasien->tanggal_lahir);
            $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
            $model->instalasi_id = Yii::app()->user->getState('instalasi_id');
            // if ($model->pegawai_id = Yii::app()->user->getState('pegawai_id'));
            $model->jeniskasuspenyakit_id = Params::DEFAULT_JENISKASUSPENYAKIT_PENUNJANG;
            $model->kelaspelayanan_id = Params::DEFAULT_KELASPELAYANAN_PENUNJANG;
            $model->no_urutantri = MyGenerator::noAntrian($model->ruangan_id);
            $model->golonganumur_id = CustomFunction::getGolonganUmur($modPasien->tanggal_lahir);
            $model->umur = CustomFunction::getUmur($modPasien->tanggal_lahir);            
            $model->kunjungan = CustomFunction::getKunjungan($modPasien, $model->ruangan_id);
            $model->shift_id = Yii::app()->user->getState('shift_id');
            $model->statusmasuk = (!empty($model->rujukan_id) ? Params::STATUSMASUK_RUJUKAN : Params::STATUSMASUK_NONRUJUKAN);
            $model->statuspasien = (empty($postPasien['pasien_id']) ? Params::STATUSPASIEN_BARU : Params::STATUSPASIEN_LAMA);
            $model->statusperiksa = Params::STATUSPERIKSA_ANTRIAN;
            $model->kelompokumur_id = CustomFunction::getKelompokUmur($modPasien->tanggal_lahir);
            $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
            $model->create_loginpemakai_id = Yii::app()->user->id;
            $model->create_time = date("Y-m-d H:i:s");
			if(Yii::app()->user->getState('tgltransaksimundur') && !empty($model->tgl_pendaftaran)){
				$model->tgl_pendaftaran = $format->formatDateTimeForDb($model->tgl_pendaftaran);
			}else{
				$model->tgl_pendaftaran = date("Y-m-d H:i:s");
			}
            $model->no_pendaftaran = MyGenerator::noPendaftaran($model->instalasi_id, $model->tgl_pendaftaran);
            $model->tgl_konfirmasi = $format->formatDateTimeForDb($model->tgl_konfirmasi);
            $model->tglselesaiperiksa = $format->formatDateTimeForDb($model->tglselesaiperiksa);
            $model->tglrenkontrol = $format->formatDateTimeForDb($model->tglrenkontrol);
            $model->asuransipasien_id = $modAsuransiPasien->asuransipasien_id;
            $model->keterangan_pendaftaran = $post['keterangan_pendaftaran'];
            
            // var_dump($model->validate()); die;

            if($model->save()){
                if(!empty($model->antrian_id)){
                    PPAntrianT::model()->updateByPk($model->antrian_id,array('pendaftaran_id'=>$model->pendaftaran_id));
                }
                $this->pendaftarantersimpan = true;
            }
            return $model;
        }
        
         /**
         * Fungsi untuk menyimpan data ke model PPPasienMasukPenunjangT
         * @param type $modPendaftaran
         * @param type $modPasien
         * @return PPPasienMasukPenunjangT 
         */
        public function simpanPasienPenunjang($modPendaftaran,$modPasien,$post){
            
            $modPasienPenunjang = new PPPasienMasukPenunjangT;
            $modPasienPenunjang->pasien_id = $modPasien->pasien_id;
            $modPasienPenunjang->pendaftaran_id = $modPendaftaran->pendaftaran_id;
            $modPasienPenunjang->jeniskasuspenyakit_id = $post['jeniskasuspenyakit_id'];
            $modPasienPenunjang->pegawai_id = $post['pegawai_id'];
            $modPasienPenunjang->kelaspelayanan_id = $post['kelaspelayanan_id'];
            $modPasienPenunjang->ruangan_id = $post['ruangan_id'];            
            $inisial_instalasi = (isset($modPasienPenunjang->ruangan_id) ? $modPasienPenunjang->ruangan->instalasi->instalasi_singkatan : null);
            $modPasienPenunjang->no_masukpenunjang = MyGenerator::noMasukPenunjang($inisial_instalasi);
            $modPasienPenunjang->tglmasukpenunjang = $modPendaftaran->tgl_pendaftaran;
            $modPasienPenunjang->no_urutperiksa =  MyGenerator::noAntrianPenunjang($modPasienPenunjang->ruangan_id);
            $modPasienPenunjang->kunjungan = $modPendaftaran->kunjungan;
            $modPasienPenunjang->statusperiksa = $modPendaftaran->statusperiksa;
            $modPasienPenunjang->ruanganasal_id = $modPendaftaran->ruangan_id;            
            
            if ($modPasienPenunjang->validate()){
                $modPasienPenunjang->Save();
                $this->pasienpenunjangtersimpan = true;
            }
            
            return $modPasienPenunjang;
        }
        
        /**
         * proses simpan PPTindakanPelayananT dan PPTindakanKomponenT
         */
        public function simpanTindakanPelayanan($modPendaftaran, $modPasienMasukPenunjang, $post){
            $modTindakan = new PPTindakanPelayananT;
            $modTindakan->attributes = $modPendaftaran->attributes;
            $modTindakan->attributes = $modPasienMasukPenunjang->attributes;
            $modTindakan->pendaftaran_id = $modPendaftaran->pendaftaran_id;
            $modTindakan->attributes = $post;
			$modTindakan->instalasi_id = $modTindakan->ruangan->instalasi_id;
			$modTindakan->tarif_satuan = $modTindakan->getTarifSatuan(); //RND-7248
            $modTindakan->karcis_id = (isset($post['karcis_id']) ? $post['karcis_id'] : null);
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
            $modTindakan->shift_id =Yii::app()->user->getState('shift_id');
            $modTindakan->dokterpemeriksa1_id=$modPasienMasukPenunjang->pegawai_id;
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
         * menampilkan karcis
         */
        public function actionSetKarcis(){
            if(Yii::app()->request->isAjaxRequest) { 
                $format = new MyFormatter();
                $form_index=$_POST['form_index'];
                $kelaspelayanan_id=$_POST['kelaspelayanan_id'];
                $ruangan_id = $_POST['ruangan_id'];
                $pasien_id = $_POST['pasien_id'];
                $penjamin_id = $_POST['penjamin_id'];
                $form='';
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
                $modKarcis=PPKarcisV::model()->findAll($criteria);
                $form = $this->renderPartial('_formKarcis',array('i'=>$form_index,'modKarcis'=>$modKarcis),true);
                $data['listKarcis'][$form_index]=$form;
                echo json_encode($data);
                Yii::app()->end();
            }
        }
		
		/**
         * @param type $pendaftaran_id
         */
        public function actionPrintKarcisPenunjang($pendaftaran_id) 
        {
            $this->layout='//layouts/printWindows';
            $format = new MyFormatter;
            $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
            $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
            $modPegawai = PegawaiM::model()->findByPk(Yii::app()->user->id);

            $karcis_id = null;
            $modTindakans =  TindakanpelayananT::model()->findAllByAttributes(array('pendaftaran_id'=>$modPendaftaran->pendaftaran_id), "karcis_id IS NOT NULL");
            $judul_print = 'Karcis '.$modPendaftaran->ruangan->instalasi->instalasi_nama;
            $this->render('printKarcisPenunjang', array(
                                'format'=>$format,
                                'modPendaftaran'=>$modPendaftaran,
                                'judul_print'=>$judul_print,
                                'modPasien'=>$modPasien,
                                'modTindakans'=>$modTindakans,
                                'modPegawai'=>$modPegawai,
            ));
        }
        
}
