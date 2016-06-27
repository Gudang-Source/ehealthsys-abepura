<?php
Yii::import('pendaftaranPenjadwalan.controllers.PendaftaranRawatJalanController');
class PendaftaranRawatDaruratController extends PendaftaranRawatJalanController
{
        /**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column1';
	public $defaultAction = 'index';
	public $path_view = "pendaftaranPenjadwalan.views.pendaftaranRawatJalan.";

	public $kecelakaantersimpan = false;
	/**
	 * Index transaksi pendaftaran
	 */
	public function actionIndex($id = null, $idSep = null, $idAntrian = null, $sk_id = null)
	{
            $modAntrian=new PPAntrianT;
            $format = new MyFormatter();
            $model=new PPPendaftaranT;
            $modPasien=new PPPasienM;
			$modPegawai=new PPPegawaiM;
            $modPenanggungJawab=new PPPenanggungJawabM;
            $modRujukan=new PPRujukanT;
            $modRujukanBpjs=new PPRujukanbpjsT;
            $modKecelakaan=new PPPasienkecelakaanT;
            $modTindakan=new PPTindakanPelayananT;
            $modPembayaran = new PPPembayaranpelayananT();
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
            $model->is_pasienrujukan = 0;
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

			// LNG-1578 untuk notif pemberitahuan sbelum simpan, jika pasien yang sudah terdaftar	201410001 
			$criteria=new CDbCriteria;
			$criteria->addBetweenCondition('tgl_pendaftaran', date('Y-m-d 00:00:00'), date('Y-m-d 23:59:59'));
			$criteria->order = 'tgl_pendaftaran DESC';
			$criteria->limit = 10;
			$modPasienTerakhir = PPInfoKunjunganRDV::model()->findAll($criteria);
			
            $model->kelaspelayanan_id = Params::KELASPELAYANAN_ID_TANPA_KELAS;            
            
            //==load data
            if(isset($id)){
                $model = $this->loadModel($id);
                if(isset($idSep)){
                    $model->is_bpjs = 1; 
                    $modRujukanBpjs= PPRujukanbpjsT::model()->findByPk($model->rujukan_id);
                    $modAsuransiPasienBpjs = PPAsuransipasienbpjsM::model()->findByPk($model->asuransipasien_id);
                }
                $modPasien=PPPasienM::model()->findByPk($model->pasien_id);
                if(!empty($model->penanggungjawab_id)){
                    $modPenanggungJawab=PPPenanggungJawabM::model()->findByPk($model->penanggungjawab_id);
                }
                if(!empty($model->rujukan_id)){
                    $modRujukan=PPRujukanT::model()->findByPk($model->rujukan_id);
                }
                $dataTindakans=PPTindakanPelayananT::model()->findAllByAttributes(array('pendaftaran_id'=>$model->pendaftaran_id),"karcis_id is not null");
            }

            if(isset($idSep)){
                $modSep= PPSepT::model()->findByPk($idSep);
            }
            
            $pasien_id = (isset($_GET['pasien_id']) ? $_GET['pasien_id'] : null);
            if(isset($pasien_id)){
                $modPasien = PPPasienM::model()->findByPk($pasien_id);
                $modPasien->tanggal_lahir = date('d/m/Y',strtotime($modPasien->tanggal_lahir));
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
						$modAsuransiPasien = $this->simpanAsuransiPasien($modAsuransiPasien, $_POST['PPPendaftaranT'], $modPasien, $_POST['PPAsuransipasienM']);
                    }else{
                        $asuransipasientersimpan = true;
                    }
                    
                    if(isset($_POST['PPAsuransipasienbpjsM'])){
                        if(isset($_POST['PPAsuransipasienbpjsM']['asuransipasien_id'])){
                            if(!empty($_POST['PPAsuransipasienbpjsM']['asuransipasien_id'])){
                                $modAsuransiPasienBpjs = PPAsuransipasienM::model()->findByPk($_POST['PPAsuransipasienbpjsM']['asuransipasien_id']);
                            }
                        }
						$modAsuransiPasienBpjs = $this->simpanAsuransiPasien($modAsuransiPasienBpjs, $_POST['PPPendaftaranT'], $modPasien, $_POST['PPAsuransipasienbpjsM']);
                    }else{
                        $asuransipasientersimpan = true;
                    }
                    if($_POST['PPPendaftaranT']['is_bpjs']){
                        $model = $this->simpanPendaftaran($model,$modPasien,$modRujukanBpjs,$modPenanggungJawab, $_POST['PPPendaftaranT'], $_POST['PPPasienM'],$modAsuransiPasienBpjs);
                        $modSep = $this->simpanSep($model,$modPasien,$modRujukanBpjs,$modAsuransiPasienBpjs,$_POST['PPSepT']);
                        $model->sep_id = $modSep->sep_id;
                        $model->update();
                    }else{
                        $model = $this->simpanPendaftaran($model,$modPasien,$modRujukan,$modPenanggungJawab, $_POST['PPPendaftaranT'], $_POST['PPPasienM'],$modAsuransiPasien);
                    }
					if($_POST['PPPendaftaranT']['is_pasienkecelakaan']){                        
						if(isset($_POST['PPPasienkecelakaanT'])){
							$modKecelakaan = $this->simpanKecelakaan($modKecelakaan, $model, $_POST['PPPasienkecelakaanT']);
						}
					}else{
						$this->kecelakaantersimpan = true; 
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
                                        $dataTindakans[$i] = $this->simpanKarcis($modTindakan, $model ,$karcis);
                                        $model->karcis_id = $dataTindakans[$i]->karcis_id;
                                        $model->save();
                                    }
                                }
                            }
                            if(isset($_POST['PPPendaftaranT']['is_bayarkarcis'])){ //fitur belum ada >> RND-666
                                if($_POST['PPPendaftaranT']['is_bayarkarcis']){ //jika di ceklis
                                }
                            }
                        }
                    }
                    
                    
                    $judul = 'Pendaftaran Pasien';
                    
                    if ($model->statuspasien == 'PENGUNJUNG LAMA') {
                        $judul .= " Lama";
                    } else $judul .= " Baru";
                    
                    $judul .= " Rawat Darurat";
                    
                    $isi = $modPasien->no_rekam_medik.' - '.$modPasien->nama_pasien;
                    
                    
                    
                    $ok = CustomFunction::broadcastNotif($judul, $isi, array(
                        array('instalasi_id'=>Params::INSTALASI_ID_RD, 'ruangan_id'=>$model->ruangan_id, 'modul_id'=>6),
                        array('instalasi_id'=>Params::INSTALASI_ID_FARMASI, 'ruangan_id'=>Params::RUANGAN_ID_APOTEK_RJ, 'modul_id'=>10),
                        array('instalasi_id'=>Params::INSTALASI_ID_KASIR, 'ruangan_id'=>Params::RUANGAN_ID_KASIR, 'modul_id'=>19),
                    ));     
                    
                    if($this->pasientersimpan && $this->pendaftarantersimpan && $this->penanggungjawabtersimpan && $this->rujukantersimpan && $this->karcistersimpan && $this->komponentindakantersimpan){
                        // SMS GATEWAY
                        $modPegawai = $model->pegawai;
                        $modRuangan = $model->ruangan;
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
                        }
                        // END SMS GATEWAY
                        $transaction->commit();
                        Yii::app()->user->setFlash('success', "Data pasien berhasil disimpan !");

                      //RND-666 >>>  $this->redirect(array('view','id'=>$model->pendaftaran_id,'sukses'=>1));
                        if($this->septersimpan){
                            $this->redirect(array('index','id'=>$model->pendaftaran_id,'idSep'=>$modSep->sep_id,'sukses'=>1,'smspasien'=>$smspasien,'smsdokter'=>$smsdokter,'smspenanggungjawab'=>$smspenanggungjawab));
                        }else{
                            $this->redirect(array('index','id'=>$model->pendaftaran_id,'sukses'=>1,'smspasien'=>$smspasien,'smsdokter'=>$smsdokter,'smspenanggungjawab'=>$smspenanggungjawab));
                        }
                    }else{
                        $transaction->rollback();
                        Yii::app()->user->setFlash('error',"Data pasien gagal disimpan !");
//						echo "-".$this->pasientersimpan."<br>";
//                        echo "-".$this->pendaftarantersimpan."<br>";
//                        echo "-".$this->penanggungjawabtersimpan."<br>";
//                        echo "-".$this->rujukantersimpan."<br>";
//                        echo "-".$this->karcistersimpan."<br>";
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
                'modKecelakaan'=>$modKecelakaan,
                'modTindakan'=>$modTindakan,
                'dataTindakans'=>$dataTindakans,
                'modAntrian'=>$modAntrian,
                'modAsuransiPasien'=>$modAsuransiPasien,
                'modAsuransiPasienBpjs'=>$modAsuransiPasienBpjs,
				'modAsuransiPasienBadak'=>$modAsuransiPasienBadak,
                'modAsuransiPasienPekerja'=>$modAsuransiPasienPekerja,
                'modAsuransiPasienDepartemen'=>$modAsuransiPasienDepartemen,
                'modSep'=>$modSep,
                'modSmsgateway'=>$modSmsgateway,
				'modKarcisV'=>$modKarcisV,
				'modPasienTerakhir'=>$modPasienTerakhir
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
					$modPegawai = new PPPegawaiM;
                    $modPenanggungJawab = null;
                    $modRujukan=null;
                    $modTindakan = null;
                    $modKecelakaan = null;

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
                    if($_POST['PPPendaftaranT']['is_pasienkecelakaan']){
                        if(isset($_POST['PPPasienkecelakaanT'])){
                            $modKecelakaan=new PPPasienkecelakaanT;
                            $modKecelakaan->attributes = $_POST['PPPasienkecelakaanT'];
                        }
                    }

                }
                echo CJSON::encode(array(
                    'content'=>$this->renderPartial('verifikasi',array(
                        'model'=>$model,
                        'modPasien'=>$modPasien,
						'modPegawai'=>$modPegawai,
                        'modPenanggungJawab'=>$modPenanggungJawab,
                        'modRujukan'=>$modRujukan,
                        'modTindakan'=>$modTindakan,
                        'modKecelakaan'=>$modKecelakaan,
                        'format'=>$format,
                ), true)));
                exit;
            }
	}        
        /**
         * proses simpan data kecelakaan
         * @param type $modKecelakaan
         * @param type $post
         * @return type
         */
        public function simpanKecelakaan($modKecelakaan, $model, $post){
            $format = new MyFormatter();
            $modKecelakaan->attributes = $post;
            $modKecelakaan->pendaftaran_id = $model->pendaftaran_id;
            $modKecelakaan->tglkecelakaan = $format->formatDateTimeForDb($modKecelakaan->tglkecelakaan);
            
            if($modKecelakaan->save()){
                $this->kecelakaantersimpan = true;
            }
            return $modKecelakaan;
        }
        
        
        /**
         * @param type $pendaftaran_id
         */
        public function actionPrintStatusRD($pendaftaran_id) 
        {
            $this->layout='//layouts/printWindows';
            $format = new MyFormatter;
            $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
            $modPasien=  PasienM::model()->findByPk($modPendaftaran->pasien_id);
            $karcis_id = null;
            $modTindakan =  TindakanpelayananT::model()->findByAttributes(array('pasien_id'=>$modPasien->pasien_id, 'pendaftaran_id'=>$modPendaftaran->pendaftaran_id));
            $judul_print = 'Kunjungan Rawat Darurat';
            $this->render('pendaftaranPenjadwalan.views.pendaftaranRawatDarurat.printStatusRD', array(
                                'format'=>$format,
                                'modPendaftaran'=>$modPendaftaran,
                                'judul_print'=>$judul_print,
                                'modPasien'=>$modPasien,
                                'modTindakan'=>$modTindakan,
            ));
        }
		
		public function actionAutocompleteDokter()
		{
            if(Yii::app()->request->isAjaxRequest) {
                $format = new MyFormatter();
                $returnVal = array();
                $nama_pegawai = isset($_GET['nama_pegawai']) ? $_GET['nama_pegawai'] : '';
                $ruangan_id = isset($_GET['ruangan_id']) ? $_GET['ruangan_id'] : null;
                $criteria = new CDbCriteria();
                $criteria->compare('LOWER(nama_pegawai)', strtolower($nama_pegawai),true);
                $criteria->addCondition('ruangan_id='.$ruangan_id);
				
                $criteria->order = 'nama_pegawai';
                $criteria->limit = 5;
                $models = PPDokterV::model()->findAll($criteria);
                foreach($models as $i=>$model)
                {
                    $attributes = $model->attributeNames();
                    foreach($attributes as $j=>$attribute) {
                        $returnVal[$i]["$attribute"] = $model->$attribute;
                    }
                    $returnVal[$i]['label'] = $model->NamaLengkap;
                    $returnVal[$i]['value'] = $model->NamaLengkap;
                    $returnVal[$i]['pegawai_id'] = $model->pegawai_id;
                    $returnVal[$i]['nama_pegawai'] = $model->nama_pegawai;
                }
                             
                echo CJSON::encode($returnVal);
            }else
                throw new CHttpException(403,'Tidak dapat mengurai data');
            Yii::app()->end();
		}

	
}
