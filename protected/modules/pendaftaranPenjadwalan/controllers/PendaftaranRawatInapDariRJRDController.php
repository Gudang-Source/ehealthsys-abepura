
<?php
Yii::import('pendaftaranPenjadwalan.controllers.PendaftaranRawatInapController');
class PendaftaranRawatInapDariRJRDController extends PendaftaranRawatInapController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column1';
        public $defaultAction = 'index';
        public $path_view_rj = "pendaftaranPenjadwalan.views.pendaftaranRawatJalan.";
        public $path_view_ri = "pendaftaranPenjadwalan.views.pendaftaranRawatInap.";
        
        public $pasientersimpan = false;
        public $pendaftarantersimpan = true; //bypass karena tidak ada proses simpan pendaftaran
        public $penanggungjawabtersimpan = false;
        public $karcistersimpan = false;
        public $komponentindakantersimpan = false;
        public $rujukantersimpan = false;
        public $successSaveMasukKamar = false;
        public $admisitersimpan = false;
        public $langsung = false;
        
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
            $modAsuransiPasien=new PPAsuransipasienM;
            $modAsuransiPasienBpjs =new PPAsuransipasienbpjsM;
			$modAsuransiPasienBadak =new PPAsuransipasienbadakM();
            $modAsuransiPasienDepartemen =new PPAsuransipasiendepartemenM();
            $modAsuransiPasienPekerja =new PPAsuransipasienpegawaiM();
            $modSep=new PPSepT;
			$modKarcisV =array();
            $dataTindakans = array();
            $modPasien->propinsi_id = Yii::app()->user->getState('propinsi_id');
            $modPasien->kabupaten_id = Yii::app()->user->getState('kabupaten_id');
            $modPasien->kecamatan_id = Yii::app()->user->getState('kecamatan_id');
            $modPasien->kelurahan_id = Yii::app()->user->getState('kelurahan_id');
            $modPasien->warga_negara = Params::DEFAULT_WARGANEGARA;
            $modPasien->agama = Params::DEFAULT_AGAMA;
            $model->is_adakarcis = Yii::app()->user->getState('iskarcis'); //RND-7737
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
            if(isset($id)){
                $model = $this->loadModel($id);
                if($idSep){
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
                $dataTindakans=PPTindakanPelayananT::model()->findAllByAttributes(array('pendaftaran_id'=>$model->pendaftaran_id, 'pasienadmisi_id'=>$model->pasienadmisi_id),"karcis_id is not null");
            }

            if(isset($idSep)){
                $modSep= PPSepT::model()->findByPk($idSep);
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
						$modAsuransiPasien = $this->simpanAsuransiPasien($modAsuransiPasien, $_POST['PPPendaftaranT'], $modPasien, $_POST['PPAsuransipasienM']);
                    }else{
                        $this->asuransipasientersimpan = true;
                    }
                    //var_dump($_POST); die;
                    if(isset($_POST['PPAsuransipasienbpjsM'])){
                        if(isset($_POST['PPAsuransipasienbpjsM']['asuransipasien_id'])){
                            if(!empty($_POST['PPAsuransipasienbpjsM']['asuransipasien_id'])){
                                $modAsuransiPasienBpjs = PPAsuransipasienM::model()->findByPk($_POST['PPAsuransipasienbpjsM']['asuransipasien_id']);
                            }
                        }
						$modAsuransiPasienBpjs = $this->simpanAsuransiPasien($modAsuransiPasienBpjs, $_POST['PPPendaftaranT'], $modPasien, $_POST['PPAsuransipasienbpjsM'], $_POST['PPPasienAdmisiT']);
                    }else{
                        $this->asuransipasientersimpan = true;
                    }
                    
                    $modLoadPendaftaran = PPPendaftaranT::model()->findByPk($_POST['PPPendaftaranT']['pendaftaran_id']);
					$modLoadPendaftaran->keterangan_pendaftaran = $_POST['PPPendaftaranT']['keterangan_pendaftaran'];
					if(isset($modLoadPendaftaran)){
                        $model = $modLoadPendaftaran;
                    }
                    if($_POST['PPPendaftaranT']['is_bpjs']){
                        $this->cekSepHariIniDanHapus($modAsuransiPasienBpjs);
                        $modSep = $this->simpanSep($model,$modPasien,$modRujukanBpjs,$modAsuransiPasienBpjs,$_POST['PPSepT'], true);
                        if (!empty($modSep->sep_id)) $model->sep_id = $modSep->sep_id;
                        if (!empty($modRujukanBpjs->rujukan_id)) $model->rujukan_id = $modRujukanBpjs->rujukan_id;
                        $model->update();
                    }
                    $modPasienAdmisi = $this->simpanPasienAdmisi($model,$modPasien,$modPasienAdmisi,$_POST['PPPasienAdmisiT']);
                    $model->pasienadmisi_id = $modPasienAdmisi->pasienadmisi_id;
					
					$this->simpanMasukKamar($model, $modPasien, $modPasienAdmisi);
                    
					if(!empty($modPasienAdmisi->kamarruangan_id)){
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

                    $this->karcistersimpan = true;
                    $this->komponentindakantersimpan = true;
                    if($_POST['PPPendaftaranT']['is_adakarcis']){
                        if(isset($_POST['PPTindakanPelayananT'])){
                            if(count($_POST['PPTindakanPelayananT']) > 0){
                                foreach($_POST['PPTindakanPelayananT'] as $i => $karcis){
                                    if($karcis['is_pilihtindakan']){
                                        $dataTindakans[$i] = $this->simpanKarcisRI($modTindakan, $model ,$karcis);
                                    }
                                }
                            }
                            if(isset($_POST['PPPendaftaranT']['is_bayarkarcis'])){ //fitur belum ada >> RND-666
                                if($_POST['PPPendaftaranT']['is_bayarkarcis']){ //jika di ceklis
                                }
                            }
                        }
                    }
                    
                    $judul = 'Pendaftaran Pasien Rujuk Rawat Inap';
                    
                    $isi = $modPasien->no_rekam_medik.' - '.$modPasien->nama_pasien;
                    
                    
                    
                    $ok = CustomFunction::broadcastNotif($judul, $isi, array(
                        array('instalasi_id'=>Params::INSTALASI_ID_RI, 'ruangan_id'=>$model->ruangan_id, 'modul_id'=>7),
                        array('instalasi_id'=>Params::INSTALASI_ID_FARMASI, 'ruangan_id'=>Params::RUANGAN_ID_APOTEK_1, 'modul_id'=>10),
                        array('instalasi_id'=>Params::INSTALASI_ID_KASIR, 'ruangan_id'=>Params::RUANGAN_ID_KASIR, 'modul_id'=>19),
                    ));     
                    
                    if($this->pasientersimpan && $this->pendaftarantersimpan && $this->penanggungjawabtersimpan && $this->rujukantersimpan && $this->karcistersimpan && $this->komponentindakantersimpan && $this->admisitersimpan && $this->masukkamartersimpan && $this->asuransipasientersimpan){
                        $model->statusperiksa = Params::STATUSPERIKSA_SEDANG_DIRAWATINAP;
                        $model->alihstatus = true;
						$model->save();

                        // SMS GATEWAY
                        $modPegawai = $model->pegawai;
                        $modRuangan = $model->ruangan;
                        // $modKamarRuangan = $modPasienAdmisi->kamarruangan;
                        $sms = new Sms();
                        $smspasien = 1;
                        $smsdokter = 1;
                        $smspenanggungjawab = 1;
                        foreach ($modSmsgateway as $i => $smsgateway) {
                            if (isset($_POST['tujuansms']) && in_array($smsgateway->tujuansms, $_POST['tujuansms'])) {
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
                                $attributes = $modPasienAdmisi->getAttributes();
                                foreach($attributes as $attributes => $value){
                                    $isiPesan = str_replace("{{".$attributes."}}",$value,$isiPesan);
                                } /*
                                $attributes = $modKamarRuangan->getAttributes();
                                foreach($attributes as $attributes => $value){
                                    $isiPesan = str_replace("{{".$attributes."}}",$value,$isiPesan);
                                }
                                 * 
                                 */
                                $attributes = $modRuangan->getAttributes();
                                foreach($attributes as $attributes => $value){
                                    $isiPesan = str_replace("{{".$attributes."}}",$value,$isiPesan);
                                }
                                $isiPesan = str_replace("{{hari}}",MyFormatter::getDayName($modPasienAdmisi->tgladmisi),$isiPesan);
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
                        $model->isNewRecord = true;
//                        echo "-".$this->pasientersimpan."<br>";
//                        echo "-".$this->pendaftarantersimpan."<br>";
//                        echo "-".$this->penanggungjawabtersimpan."<br>";
//                        echo "-".$this->rujukantersimpan."<br>";
//                        echo "-".$this->karcistersimpan."<br>";
//                        echo "-".$this->komponentindakantersimpan."<br>";
//                        echo "-".$this->admisitersimpan."<br>";
//                        echo "-".$this->masukkamartersimpan."<br>";
//                        exit;
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
                    $modPasienAdmisi = new PPPasienAdmisiT;
                    $modPenanggungJawab = null;
                    $modRujukan=null;
                    $modTindakan = null;

                    $model = PendaftaranT::model()->findByAttributes(array(
                        'pendaftaran_id'=>$_POST['PPPendaftaranT']['pendaftaran_id']
                    ));
                    $model->attributes = $_POST['PPPendaftaranT'];
					$model->keterangan_pendaftaran = $_POST['PPPendaftaranT']['keterangan_pendaftaran'];
                    $model->no_pendaftaran = $_POST['cari_no_pendaftaran'];
                    if (isset($_POST['instalasi_id'])) $model->instalasi_id = $_POST['instalasi_id'];
                    $modPasien->attributes = $_POST['PPPasienM'];
                    $modPasien->no_rekam_medik = $_POST['cari_no_rekam_medik'];
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
         * Mengurai data pasien (kunjungan) berdasarkan:
         * - instalasi_id (RJ / RD)
         * - pendaftaran_id
         * - no_pendaftaran
         * - pasien_id
         * - no_rekam_medik
         * @throws CHttpException
         */
        public function actionGetDataPasienRJRD()
        {
            if(Yii::app()->request->isAjaxRequest) {
                $format = new MyFormatter();
                $instalasi_id = isset($_GET['instalasi_id'])?$_GET['instalasi_id']:null;
                $pendaftaran_id = isset($_POST['pendaftaran_id']) ? $_POST['pendaftaran_id'] : null;
                $no_pendaftaran = isset($_POST['no_pendaftaran']) ? $_POST['no_pendaftaran'] : null;
                $pasien_id = isset($_POST['pasien_id']) ? $_POST['pasien_id'] : null;
                $no_rekam_medik = isset($_POST['no_rekam_medik']) ? $_POST['no_rekam_medik'] : null;
                $returnVal = array();
                $criteria = new CDbCriteria();
				if(!empty($instalasi_id)){$criteria->addCondition("instalasi_id = ".$instalasi_id); }
				if(!empty($pendaftaran_id)){$criteria->addCondition("pendaftaran_id = ".$pendaftaran_id); }
				if(!empty($pasien_id)){$criteria->addCondition("pasien_id = ".$pasien_id); }
                $criteria->compare('no_pendaftaran',$no_pendaftaran);
                $criteria->compare('no_rekam_medik',$no_rekam_medik);
                
                $model = PPPasientindaklanjutkeriV::model()->find($criteria);
				
                $attributes = $model->attributeNames();
                foreach($attributes as $j=>$attribute) {
                    $returnVal["$attribute"] = $model->$attribute;
                }
                $returnVal["tgl_pendaftaran"] = $format->formatDateTimeForUser($model->tgl_pendaftaran);
                $returnVal["tanggal_lahir"] = date("d/m/Y",strtotime($model->tanggal_lahir));
				if(!empty($model->pasien_id)){
					$modPasien = PasienM::model()->findByPk($model->pasien_id);
					$returnVal['pegawai_id'] = $modPasien->pegawai_id;
					$returnVal['nomorindukpegawai'] = isset($modPasien->pegawai_id)?$modPasien->pegawai->nomorindukpegawai:'';
					$returnVal['nama_pegawai'] = isset($modPasien->pegawai_id)?$modPasien->pegawai->nama_pegawai:'';
					$returnVal['gelardepan'] = isset($modPasien->pegawai_id)?$modPasien->pegawai->gelardepan:'';
					$returnVal['unit_perusahaan'] = isset($modPasien->pegawai_id)?$modPasien->pegawai->unit_perusahaan:'';
					$returnVal['gelarbelakang_nama'] = isset($modPasien->pegawai->gelarbelakang->gelarbelakang_nama) ? $modPasien->pegawai->gelarbelakang->gelarbelakang_nama : "";
					$returnVal['jabatan_nama'] = isset($modPasien->pegawai->jabatan->jabatan_nama) ? $modPasien->pegawai->jabatan->jabatan_nama : "";
				}
                echo CJSON::encode($returnVal);
            }
            Yii::app()->end();
        }
        
        /**
         * untuk menampilkan pasien lama dari autocomplete
         * - instalasi_id
         * - no_pendaftaran
         * - no_rekam_medik
         * - no_identitas_pasien
         * - nama_pasien
         * - nama_bin (alias)
         */
        public function actionAutocompletePasienRJRD()
	{
            if(Yii::app()->request->isAjaxRequest) {
                $format = new MyFormatter();
                $returnVal = array();
                $instalasi_id = isset($_GET['instalasi_id'])?$_GET['instalasi_id']:null;
                $no_pendaftaran = isset($_GET['no_pendaftaran']) ? $_GET['no_pendaftaran'] : null;
                $no_rekam_medik = isset($_GET['no_rekam_medik']) ? $_GET['no_rekam_medik'] : null;
                $no_identitas_pasien = isset($_GET['no_identitas_pasien']) ? $_GET['no_identitas_pasien'] : null;
                $nama_pasien = isset($_GET['nama_pasien']) ? $_GET['nama_pasien'] : null;
				$no_badge = isset($_GET['nomorindukpegawai']) ? $_GET['nomorindukpegawai'] : null;
				
				if(empty($no_badge)){
					$criteria = new CDbCriteria();
					if(!empty($instalasi_id)){
						$criteria->addCondition("instalasi_id = ".$instalasi_id); 				
					}
					$criteria->compare('LOWER(no_pendaftaran)', strtolower($no_pendaftaran), true);
					$criteria->compare('LOWER(no_rekam_medik)', strtolower($no_rekam_medik), true);
					$criteria->compare('LOWER(no_identitas_pasien)', strtolower($no_identitas_pasien), true);
					$criteria->compare('LOWER(nama_pasien)', strtolower($nama_pasien), true);
                                        $criteria->addCondition('pasienpulang_id is not null');
					$criteria->order = 'no_rekam_medik, nama_pasien';
					$criteria->limit = 50;
					$models = PPPasientindaklanjutkeriV::model()->findAll($criteria);

					foreach($models as $i=>$model)
					{
						$attributes = $model->attributeNames();
						foreach($attributes as $j=>$attribute) {
							$returnVal[$i]["$attribute"] = $model->$attribute;
						}
						$returnVal[$i]['label'] = $model->no_pendaftaran.' - '.$model->no_rekam_medik.' - '.$model->namadepan.$model->nama_pasien;
						$returnVal[$i]['value'] = $model->no_pendaftaran;
					}
				}else{
					$criteria = new CDbCriteria();
					$criteria->compare('LOWER(pegawai_m.nomorindukpegawai)', strtolower($no_badge), true);
					$criteria->join = "JOIN pegawai_m ON t.pegawai_id = pegawai_m.pegawai_id";
					$criteria->order = 'pegawai_m.nomorindukpegawai, t.nama_pasien'; 
					$criteria->limit = 50;
					$models = PPPasienM::model()->findAll($criteria);
					foreach($models as $i=>$model)
					{
						$attributes = $model->attributeNames();
						foreach($attributes as $j=>$attribute) {
							$returnVal[$i]["$attribute"] = $model->$attribute;
						}
						$returnVal[$i]['label'] = $model->pegawai->nomorindukpegawai.
											' - '.$model->no_rekam_medik.	
											' - '.$model->nama_pasien.	
											' - ('.$model->pegawai->nama_pegawai.
											') - '.$format->formatDateTimeForUser($model->tanggal_lahir);
						$returnVal[$i]['value'] = $model->no_rekam_medik;
					}
				}
			
                

                echo CJSON::encode($returnVal);
            }else
                throw new CHttpException(403,'Tidak dapat mengurai data');
            Yii::app()->end();
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
        
        
        public function actionCekCaraBayarBPJS() {
            if(Yii::app()->request->isAjaxRequest) {
                $cr = new CDbCriteria();
                $cr->compare("pasien_id", $_POST['pasien_id']);
                $cr->order = "asuransipasien_id desc";
                $cr->limit = 1;
                $asuransi = AsuransipasienM::model()->find($cr);
                $pendaftaran = PendaftaranT::model()->findByPk($_POST['pendaftaran_id']);
                $pp = PasienpulangT::model()->findByAttributes(array(
                    'pendaftaran_id'=>$pendaftaran->pendaftaran_id,
                ));
                $profil = ProfilrumahsakitM::model()->find();
                
                $ruangan = CHtml::listData(RuanganM::model()->findAllByAttributes(array(
                    'instalasi_id'=>array(Params::INSTALASI_ID_RJ, Params::INSTALASI_ID_RD),
                )), 'ruangan_id', 'ruangan_id');
                
                $morbid = PasienmorbiditasT::model()->findByAttributes(array(
                    'pendaftaran_id'=>$pendaftaran->pendaftaran_id,
                    'ruangan_id'=>$ruangan,
                ), array(
                    'order'=>'kelompokdiagnosa_id asc',
                ));
                
                $res = array(
                    "dat"=>null, 
                    "diag"=>array(
                        "kode"=>null,
                        "nama"=>null,
                    ),
                );
                if (!empty($asuransi)) {
                    $res["dat"] = $asuransi->attributes;
                }
                
                $res["ppk"] = $profil->ppkpelayanan;
                $res["ruj"] = date('dmY');
                $res["tglruj"] = date("d/m/Y H:i:s", strtotime($pp->tglpasienpulang));
                
                if (!empty($morbid)) {
                    $diag = DiagnosaM::model()->findByPk($morbid->diagnosa_id);
                    $res["diag"]["kode"] = $diag->diagnosa_kode;
                    $res["diag"]["nama"] = $diag->diagnosa_nama;
                }
                echo CJSON::encode($res);
            }
            Yii::app()->end();
        }
        
        protected function cekSepHariIniDanHapus($modAsuransiPasienBpjs) {
            $bpjs = new Bpjs();
            $dat = json_decode($bpjs->riwayat_terakhir($modAsuransiPasienBpjs->nokartuasuransi));
            
            // var_dump($dat); die;
            
            if ($dat->metadata->code != 200) return false;
            
            $last = $dat->response->list[0];
            if ($last->tglSEP != date('Y-m-d')) return false;
            $sep = $last->noSEP;
            $ppk = substr($sep, 0, 8);
            
            $str = "<request><data><t_sep>";
            $str .= "<noSep>".$sep."</noSep>";
            $str .= "<ppkPelayanan>".$ppk."</ppkPelayanan>";
            $str .= "</t_sep></data></request>";
            
            $dat = json_decode($bpjs->delete_transaksi($str));
            
            // var_dump($dat);
            
            //die;
        }
}
