<?php
Yii::import('pendaftaranPenjadwalan.models.*');
Yii::import('pendaftaranPenjadwalan.views.pendaftaranRawatJalan');
class PendaftaranRadiologiController extends MyAuthController
{
        /**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column1';
	public $defaultAction = 'index';
	public $path_view = 'radiologi.views.pendaftaranRadiologi.';
	public $path_viewPPRJ = 'pendaftaranPenjadwalan.views.pendaftaranRawatJalan.';

	public $pasientersimpan = false;
	public $pendaftarantersimpan = false;
	public $penanggungjawabtersimpan = false;
	public $tindakanpelayanantersimpan = true; //dilooping / boleh tanpa ini
	public $karcistersimpan = true; //dilooping / boleh tanpa ini
	public $komponentindakantersimpan = true; //di looping
	public $rujukantersimpan = false;
	public $pengambilansampletersimpan = true; //dilooping / boleh tanpa ini
	public $pasienpenunjangtersimpan = true; //dilooping
	public $hasilpemeriksaantersimpan = true; //dilooping
	public $asuransipasientersimpan = false;
        
	/**
	 * Index transaksi pendaftaran
	 */
	public function actionIndex($id = null)
	{
            $format = new MyFormatter();
            $model=new ROPendaftaranT;
            $model->pendaftaran_id = null; //new record
            $modPasien=new ROPasienM;
			$modPegawai=new PPPegawaiM;
			$modAsuransiPasienBadak =new PPAsuransipasienbadakM();
            $modAsuransiPasienDepartemen =new PPAsuransipasiendepartemenM();
            $modAsuransiPasienPekerja =new PPAsuransipasienpegawaiM();
            $modPenanggungJawab=new ROPenanggungJawabM;
            $modPasienMasukPenunjang = new ROPasienmasukpenunjangT;
            $modPasienMasukPenunjang->ruangan_id = Params::RUANGAN_ID_RAD;
            $modPasienMasukPenunjang->is_adakarcis = Yii::app()->user->getState('iskarcis'); //RND-7737
            $modPemeriksaanRad = new ROTarifpemeriksaanradruanganV;
            $modRujukan=new RORujukanT;
            $modTindakan=new ROTindakanpelayananT;
            $modHasilPemeriksaan= new ROHasilpemeriksaanradT;
			$modAsuransiPasien=new ROAsuransipasienM;
            $dataTindakans = array();  
            $modKarcis = array();  
            $modPasien->propinsi_id = Yii::app()->user->getState('propinsi_id');
            $modPasien->kabupaten_id = Yii::app()->user->getState('kabupaten_id');
            $modPasien->kecamatan_id = Yii::app()->user->getState('kecamatan_id');
            $modPasien->warga_negara = Params::DEFAULT_WARGANEGARA;
            $modPasien->agama = Params::DEFAULT_AGAMA;
            
            //==load data
            if(isset($id)){
                $model = $this->loadModel($id);
                $modPasien=ROPasienM::model()->findByPk($model->pasien_id);
                $criteria = new CdbCriteria();
                $criteria->addCondition('pendaftaran_id = '.$model->pendaftaran_id);
                $criteria->order = "pendaftaran_id DESC, pasienmasukpenunjang_id ASC";
                $criteria->limit = 2;
                $criteria1 = $criteria;
                $criteria1->addCondition('ruangan_id = '.Params::RUANGAN_ID_RAD);
                $loadPasienMasukPenunjang = ROPasienmasukpenunjangT::model()->find($criteria1);
                if(isset($loadPasienMasukPenunjang)){
                    $modPasienMasukPenunjang = $loadPasienMasukPenunjang;
                    $modPasienMasukPenunjang->is_adakarcis = 1;
                }
                
                if(!empty($model->penanggungjawab_id)){
                    $modPenanggungJawab=ROPenanggungJawabM::model()->findByPk($model->penanggungjawab_id);
                }
                if(!empty($model->rujukan_id)){
                    $modRujukan=RORujukanT::model()->findByPk($model->rujukan_id);
                }
                $dataKarcis = ROTindakanpelayananT::model()->findByAttributes(array('ruangan_id'=>Params::RUANGAN_ID_RAD,'pendaftaran_id'=>$model->pendaftaran_id),"karcis_id is not null");
                if(isset($dataKarcis->karcis_id)){
                    $modKarcis[0] =  ROKarcisV::model()->findByAttributes(array('karcis_id'=>$dataKarcis->karcis_id));
					$modKarcis[0]->harga_tariftindakan = $dataKarcis->tarif_tindakan;
                }
                
                $dataTindakans=ROTindakanpelayananT::model()->findAllByAttributes(array('ruangan_id'=>Params::RUANGAN_ID_RAD,'pendaftaran_id'=>$model->pendaftaran_id),"karcis_id is null");
            }
            
            if(isset($_POST['ROPendaftaranT']))
            {
                $transaction = Yii::app()->db->beginTransaction();
                try {
                    $modPasien = $this->simpanPasien($modPasien, $_POST['ROPasienM']);

                    if($_POST['ROPendaftaranT']['is_adapjpasien']){
                        if(isset($_POST['ROPenanggungJawabM'])){
                            $modPenanggungJawab = $this->simpanPenanggungjawab($modPenanggungJawab, $_POST['ROPenanggungJawabM']);
                        }
                    }else{
                        $this->penanggungjawabtersimpan = true; 
                    }
                    
                    if($_POST['ROPendaftaranT']['is_pasienrujukan']){
                        if(isset($_POST['RORujukanT'])){
                            $modRujukan = $this->simpanRujukan($modRujukan, $_POST['RORujukanT']);
                        }
                    }else{
                        $this->rujukantersimpan = true; 
                    }
                    
					if(isset($_POST['ROAsuransipasienM'])){
                        if(isset($_POST['ROAsuransipasienM']['asuransipasien_id'])){
                            if(!empty($_POST['ROAsuransipasienM']['asuransipasien_id'])){
                                $modAsuransiPasien = ROAsuransipasienM::model()->findByPk($_POST['ROAsuransipasienM']['asuransipasien_id']);
                            }
                        }
						$modAsuransiPasien = $this->simpanAsuransiPasien($modAsuransiPasien, $_POST['ROPendaftaranT'], $modPasien, $_POST['ROAsuransipasienM']);
                    }else{
                        $this->asuransipasientersimpan = true;
                    }
					
                    $model = $this->simpanPendaftaran($model,$modPasien,$modRujukan,$modPenanggungJawab, $_POST['ROPendaftaranT'], $_POST['ROPasienM'], $_POST['ROPasienmasukpenunjangT'], $modAsuransiPasien);
                    
                    $postPenunjang = $_POST['ROPasienmasukpenunjangT'];
                    $modPasienMasukPenunjang = $this->simpanPasienMasukPenunjang($modPasienMasukPenunjang,$model,$postPenunjang);

                    if(isset($_POST['ROTindakanpelayananT'])){
                        if(count($_POST['ROTindakanpelayananT']) > 0){
                            foreach($_POST['ROTindakanpelayananT'] AS $ii => $tindakan){
                                $dataTindakans[$ii] = $this->simpanTindakanPelayanan($model,$modPasienMasukPenunjang,$tindakan);
                                $dataTindakans[$ii]->pemeriksaanrad_id = $tindakan['pemeriksaanrad_id'];
                                $dataTindakans[$ii]->jenistarif_id = $tindakan['jenistarif_id'];
                                $modHasilPemeriksaan = $this->simpanHasilPemeriksaanRad($modPasienMasukPenunjang, $dataTindakans[$ii], $tindakan);
                                $dataTindakans[$ii]->tarif_tindakan = $format->formatNumberForUser($tindakan['tarif_tindakan']);

                            }
                        }
                    }
                    if($postPenunjang['is_adakarcis']){
                        if(isset($_POST['ROKarcisV'])){
                            if(count($_POST['ROKarcisV']) > 0){
                                foreach($_POST['ROKarcisV'] AS $ii=>$karcis){
                                    if($karcis['is_pilihkarcis']){
                                        $modKarcis[$ii] = new ROKarcisV;
                                        $modKarcis[$ii]->attributes = $karcis;
                                        $this->simpanTindakanPelayanan($model,$modPasienMasukPenunjang,$karcis);
                                    }
                                }
                            }
                        }
                    }
					
					if(isset($_POST['PPAsuransipasienbadakM'])){
						if(isset($_POST['PPAsuransipasienbadakM']['asuransipasien_id'])){
							if(!empty($_POST['PPAsuransipasienbadakM']['asuransipasien_id'])){
								$modAsuransiPasienBadak = PPAsuransipasienM::model()->findByPk($_POST['PPAsuransipasienbadakM']['asuransipasien_id']);
							}
						}
						$modAsuransiPasienBadak = $this->simpanAsuransiPasien($modAsuransiPasienBadak, $_POST['ROPendaftaranT'], $modPasien, $_POST['PPAsuransipasienbadakM']);
					}else{
						$this->asuransipasientersimpan = true;
					}
					
					if(isset($_POST['PPAsuransipasiendepartemenM'])){
						if(isset($_POST['PPAsuransipasiendepartemenM']['asuransipasien_id'])){
							if(!empty($_POST['PPAsuransipasiendepartemenM']['asuransipasien_id'])){
								$modAsuransiPasienDepartemen = PPAsuransipasienM::model()->findByPk($_POST['PPAsuransipasiendepartemenM']['asuransipasien_id']);
							}
						}
						$modAsuransiPasienDepartemen = $this->simpanAsuransiPasien($modAsuransiPasienDepartemen, $_POST['ROPendaftaranT'], $modPasien, $_POST['PPAsuransipasiendepartemenM']);
					}else{
						$this->asuransipasientersimpan = true;
					}
					
					if(isset($_POST['PPAsuransipasienpegawaiM'])){
						if(isset($_POST['PPAsuransipasienpegawaiM']['asuransipasien_id'])){
							if(!empty($_POST['PPAsuransipasienpegawaiM']['asuransipasien_id'])){
								$modAsuransiPasienPekerja = PPAsuransipasienM::model()->findByPk($_POST['PPAsuransipasienpegawaiM']['asuransipasien_id']);
							}
						}
						$modAsuransiPasienPekerja = $this->simpanAsuransiPasien($modAsuransiPasienPekerja, $_POST['ROPendaftaranT'], $modPasien, $_POST['PPAsuransipasienpegawaiM']);
					}else{
						$this->asuransipasientersimpan = true;
					}
                                       
                    if($this->pasientersimpan && $this->pendaftarantersimpan && $this->penanggungjawabtersimpan && $this->rujukantersimpan && $this->tindakanpelayanantersimpan && $this->karcistersimpan && $this->komponentindakantersimpan && $this->pasienpenunjangtersimpan && $this->hasilpemeriksaantersimpan && $this->pengambilansampletersimpan && $this->asuransipasientersimpan){
                        $transaction->commit();
                        Yii::app()->user->setFlash('success', "Data pendaftaran berhasil disimpan !");
                        $this->redirect(array('index','id'=>$model->pendaftaran_id,'sukses'=>1));
                    }else{
                        $transaction->rollback();
                        Yii::app()->user->setFlash('error',"Data pendaftaran gagal disimpan !");
//                        echo "-".$this->pasientersimpan."<br>";
//                        echo "-".$this->pendaftarantersimpan."<br>";
//                        echo "-".$this->penanggungjawabtersimpan."<br>";
//                        echo "-".$this->rujukantersimpan."<br>";
//                        echo "-".$this->karcistersimpan."<br>";
//                        echo "-".$this->tindakanpelayanantersimpan."<br>";
//                        echo "-".$this->komponentindakantersimpan."<br>";
//                        echo "-".$this->hasilpemeriksaantersimpan."<br>";
//                        echo "-".$this->pengambilansampletersimpan."<br>";
//                        exit;
                    }
                } catch (Exception $exc) {
                    $transaction->rollback();
                    Yii::app()->user->setFlash('error',"Data pendaftaran gagal disimpan !"." ".MyExceptionMessage::getMessage($exc,true));
                }
            }
            
            

            $this->render($this->path_view.'index',array(
                'model'=>$model,
                'modPasien'=>$modPasien,
				'modPegawai'=>$modPegawai,
                'modPenanggungJawab'=>$modPenanggungJawab,
                'modPasienMasukPenunjang'=>$modPasienMasukPenunjang,
                'modPemeriksaanRad'=>$modPemeriksaanRad,
				'modAsuransiPasien'=>$modAsuransiPasien,
                'modRujukan'=>$modRujukan,
                'modTindakan'=>$modTindakan,
                'dataTindakans'=>$dataTindakans,
                'modKarcis'=>$modKarcis,
				'modAsuransiPasienBadak'=>$modAsuransiPasienBadak,
                'modAsuransiPasienPekerja'=>$modAsuransiPasienPekerja,
                'modAsuransiPasienDepartemen'=>$modAsuransiPasienDepartemen,
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
                if(isset($_POST['ROPendaftaranT'])){
                    $format = new MyFormatter();
                    $model=new ROPendaftaranT;                    
                    $modPasien=new ROPasienM;
                    $modPenanggungJawab = null;
                    $modRujukan=null;
                    $modTindakans=array();
                    $modKarcis=array();

                    $model->attributes = $_POST['ROPendaftaranT'];
                    $modPasien->attributes = $_POST['ROPasienM'];
                    if($_POST['ROPendaftaranT']['is_adapjpasien']){
                        if(isset($_POST['ROPenanggungJawabM'])){
                            $modPenanggungJawab=new ROPenanggungJawabM;
                            $modPenanggungJawab->attributes = $_POST['ROPenanggungJawabM'];
                        }
                    }

                    if($_POST['ROPendaftaranT']['is_pasienrujukan']){
                        if(isset($_POST['RORujukanT'])){
                            $modRujukan=new RORujukanT;
                            $modRujukan->attributes = $_POST['RORujukanT'];
                            $modRujukan->rujukandari_id = !empty($modRujukan->rujukandari_id) ? $modRujukan->rujukandari_id : null;
                        }
                    }
                    
                    $modPasienMasukPenunjang = new ROPasienmasukpenunjangT;
                    $postPenunjang = $_POST['ROPasienmasukpenunjangT'];
                    $modPasienMasukPenunjang->attributes = $postPenunjang;
                    $modPasienMasukPenunjang->tglmasukpenunjang = date('Y-m-d H:i:s');
                    if(isset($_POST['ROTindakanpelayananT'])){
                        if(count($_POST['ROTindakanpelayananT']) > 0){
                            foreach($_POST['ROTindakanpelayananT'] AS $ii => $tindakan){
                                $modTindakans[$ii] = new ROTindakanpelayananT;
                                $modTindakans[$ii]->attributes = $tindakan;
                            }
                        }
                    }
                    if($postPenunjang['is_adakarcis']){
                        if(isset($_POST['ROKarcisV'])){
                            if(count($_POST['ROKarcisV']) > 0){
                                foreach($_POST['ROKarcisV'] AS $ii=>$karcis){
                                    if($karcis['is_pilihkarcis']){
                                        $modKarcis[$ii] = new ROKarcisV;
                                        $modKarcis[$ii]->attributes = $karcis;
                                    }
                                }
                            }
                        }
                    }
                }
                //var_dump($model->carabayar_id);die;
                echo CJSON::encode(array(
                    'content'=>$this->renderPartial($this->path_view.'verifikasi',array(
                        'model'=>$model,
                        'modPasienMasukPenunjang'=>$modPasienMasukPenunjang,
                        'modPasien'=>$modPasien,
                        'modPenanggungJawab'=>$modPenanggungJawab,
                        'modRujukan'=>$modRujukan,
                        'modTindakans'=>$modTindakans,
                        'modKarcis'=>$modKarcis,
                        'format'=>$format,
                ), true)));
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
                $modPasien->ispasienluar = TRUE;
                $modPasien->create_ruangan = Yii::app()->user->getState('ruangan_id');
                $modPasien->create_loginpemakai_id = Yii::app()->user->id;
                $modPasien->create_time = date('Y-m-d H:i:s');
                $modPasien->no_rekam_medik = MyGenerator::noRekamMedikPenunjang(Yii::app()->user->getState('mr_rad'));
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
            $modRujukan->tanggal_rujukan = $format->formatDateTimeForDb($modRujukan->tanggal_rujukan);
            
            if($modRujukan->save()){
                $this->rujukantersimpan = true;
            }
            return $modRujukan;
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
            $modAsuransiPasien->hubkeluarga = isset($postAsuransiPasien['hubkeluarga'])?$postAsuransiPasien['hubkeluarga']:'';
			if(empty($postAsuransiPasien['nokartuasuransi'])){
				$modAsuransiPasien->nokartuasuransi = $modAsuransiPasien->nopeserta;
			}
			
            if($modAsuransiPasien->save()){
                $this->asuransipasientersimpan = true;
            }
            return $modAsuransiPasien;
        }
		
        /**
         * proses simpan / ubah data pendaftaran
         * @return type
         */
        public function simpanPendaftaran($model,$modPasien,$modRujukan,$modPenanggungJawab,$post, $postPasien, $postPenunjang, $modAsuransiPasien){
            $format = new MyFormatter();
            $model->attributes = $post;
            $model->pendaftaran_id = null;
            $model->pasien_id = $modPasien->pasien_id;
            $model->penanggungjawab_id = $modPenanggungJawab->penanggungjawab_id;
            $model->rujukan_id = $modRujukan->rujukan_id;
            $model->kelompokumur_id = CustomFunction::getKelompokUmur($modPasien->tanggal_lahir);
			$model->ruangan_id = Yii::app()->user->getState('ruangan_id');
            if(!empty($postPenunjang['pegawai_id'])){
				$model->pegawai_id = $postPenunjang['pegawai_id'];
			}
			if(!empty($postPenunjang['jeniskasuspenyakit_id'])){
				$model->jeniskasuspenyakit_id = $postPenunjang['jeniskasuspenyakit_id'];
			}
			if(!empty($postPenunjang['kelaspelayanan_id'])){
				$model->kelaspelayanan_id = $postPenunjang['kelaspelayanan_id'];
			}
			if(!empty($postPenunjang['ruangan_id'])){
				$model->ruangan_id = $postPenunjang['ruangan_id'];
			}
            $model->instalasi_id = (isset($model->ruangan_id) ? RuanganM::model()->findByPk($model->ruangan_id)->instalasi_id : null);
            $model->no_pendaftaran = MyGenerator::noPendaftaran($model->instalasi_id);
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
            
            if($model->save()){
                $this->pendaftarantersimpan = true;
            }
            return $model;
        }
        
         /**
         * Fungsi untuk menyimpan data ke model ROPasienmasukpenunjangT
         * @param type $modPendaftaran
         * @param type $modPasien
         * @return ROPasienmasukpenunjangT 
         */
        public function simpanPasienMasukPenunjang($modPasienMasukPenunjang,$modPendaftaran,$post){
            $modPasienMasukPenunjang = new $modPasienMasukPenunjang;
            $modPasienMasukPenunjang->attributes = $modPendaftaran->attributes;
            $modPasienMasukPenunjang->attributes = $post;
			$modPasienMasukPenunjang->perawat_id = (isset($post['perawat_id']) ? $post['perawat_id'] : null);
            $modPasienMasukPenunjang->pendaftaran_id = $modPendaftaran->pendaftaran_id;
            $instalasi_id = $modPasienMasukPenunjang->ruangan->instalasi_id;
            $kode_instalasi = InstalasiM::model()->findByPk($instalasi_id)->instalasi_singkatan;
            $modPasienMasukPenunjang->no_masukpenunjang = MyGenerator::noMasukPenunjang($kode_instalasi);
            $modPasienMasukPenunjang->tglmasukpenunjang = date("Y-m-d H:i:s");
            $modPasienMasukPenunjang->no_urutperiksa =  MyGenerator::noAntrianPenunjang($modPasienMasukPenunjang->ruangan_id);
            $modPasienMasukPenunjang->ruanganasal_id = $modPendaftaran->ruangan_id;
            $modPasienMasukPenunjang->create_ruangan = Yii::app()->user->getState('ruangan_id');
            $modPasienMasukPenunjang->create_loginpemakai_id = Yii::app()->user->id;
            $modPasienMasukPenunjang->create_time = date('Y-m-d H:i:s');

            if ($modPasienMasukPenunjang->validate()){
                $modPasienMasukPenunjang->save();
                $this->pasienpenunjangtersimpan &= true;
            }else{
                $this->pasienpenunjangtersimpan &= false;
            }
                    
            return $modPasienMasukPenunjang;
        }
         
        /**
         * proses simpan ROTindakanpelayananT dan ROTindakankomponenT
         */
        public function simpanTindakanPelayanan($modPendaftaran, $modPasienMasukPenunjang, $post){
            $modTindakan = new ROTindakanpelayananT;
            
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
            $modTindakan->create_ruangan = Yii::app()->user->getState('ruangan_id');
            $modTindakan->shift_id =Yii::app()->user->getState('shift_id');
            $modTindakan->dokterpemeriksa1_id=$modPasienMasukPenunjang->pegawai_id;
			$modTindakan->perawat_id = (!empty($modPasienMasukPenunjang->perawat_id) ? $modPasienMasukPenunjang->perawat_id : null);
            $modTindakan->tarif_tindakan=$modTindakan->tarif_satuan * $modTindakan->qty_tindakan;
            if(!empty($_POST['tgl_tindakan_semua'])){
                $modTindakan->tgl_tindakan = MyFormatter::formatDateTimeForDb($_POST['tgl_tindakan_semua']);
            }else{
                $modTindakan->tgl_tindakan=date('Y-m-d H:i:s');
            }
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
					$this->komponentindakantersimpan = $modTindakan->saveTindakanKomponen();
				}
            }else{
                $this->tindakanpelayanantersimpan &= false;
            }
                
            return $modTindakan;
        }
        
        /**
         * simpan ROHasilpemeriksaanradT
         */
        public function simpanHasilPemeriksaanRad($modPasienMasukPenunjang, $modTindakan, $post){
            $modHasilPemeriksaan = new ROHasilpemeriksaanradT;
            $modHasilPemeriksaan->attributes = $modPasienMasukPenunjang->attributes;
            $modHasilPemeriksaan->tindakanpelayanan_id = $modTindakan->tindakanpelayanan_id;
            $modHasilPemeriksaan->pemeriksaanrad_id = $post['pemeriksaanrad_id'];
            $modHasilPemeriksaan->tglpemeriksaanrad = $modPasienMasukPenunjang->tglmasukpenunjang;
            $modHasilPemeriksaan->create_time = date("Y-m-d H:i:s");
            $modHasilPemeriksaan->create_loginpemakai_id = Yii::app()->user->id;
            $modHasilPemeriksaan->create_ruangan = $modPasienMasukPenunjang->ruangan_id;
            
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
			if(!empty($tindakan_id)){
				$criteria->addCondition("daftartindakan_id = ".$tindakan_id);					
			}
			if(!empty($modPendaftaran->carabayar_id)){
				$criteria->addCondition("tipepaket.carabayar_id = ".$modPendaftaran->carabayar_id);					
			}
			if(!empty($modPendaftaran->penjamin_id)){
				$criteria->addCondition("tipepaket.penjamin_id = ".$modPendaftaran->penjamin_id);					
			}
			if(!empty($modPendaftaran->kelaspelayanan_id)){
				$criteria->addCondition("tipepaket.kelaspelayanan_id = ".$modPendaftaran->kelaspelayanan_id);					
			}
            $paket = PaketpelayananM::model()->find($criteria);
            $result = Params::TIPEPAKET_ID_NONPAKET;
            if(isset($paket)) $result = $paket->tipepaket_id;
            
            return $result;
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
                $model = new ROPendaftaranT;
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
                $model = new ROPendaftaranT;
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
               } else {
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
					if(!empty($ruangan_id)){
						$criteria->addCondition("ruangan_id = ".$ruangan_id);					
					}
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
					if(!empty($ruangan_id)){
						$criteria->addCondition("ruangan_id = ".$ruangan_id);					
					}
					if(!empty($pegawai_id)){
						$criteria->addCondition("pegawai_id = ".$pegawai_id);					
					}
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
         * menampilkan karcis
         */
        public function actionSetKarcis(){
            if(Yii::app()->request->isAjaxRequest) { 
                $format = new MyFormatter();
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
                $modKarcis=ROKarcisV::model()->findAll($criteria);
                $form = $this->renderPartial($this->path_view.'_formKarcis',array('modKarcis'=>$modKarcis),true);
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
                $modPasien = new ROPasienM;
                $modPasien->pasien_id = $_POST['pasien_id'];
                $data['table'] = $this->renderPartial($this->path_view.'_tableRiwayatPasien',array(
                                        'modPasien'=>$modPasien,
                                        ),true);
                echo json_encode($data);
                Yii::app()->end();
            }
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
				$no_badge = isset($_GET['nomorindukpegawai']) ? $_GET['nomorindukpegawai'] : null;
				
				if(empty($no_badge)){
					
					$criteria = new CDbCriteria();
					$criteria->compare('LOWER(no_rekam_medik)', strtolower($no_rekam_medik), true);
					$criteria->compare('LOWER(no_identitas_pasien)', strtolower($no_identitas_pasien), true);
					$criteria->compare('LOWER(nama_pasien)', strtolower($nama_pasien), true);
					$criteria->compare('tanggal_lahir', $tanggal_lahir);
					$criteria->compare('ispasienluar',true);
					$criteria->order = 'no_rekam_medik, nama_pasien';
					$criteria->limit = 5;
					$models = PasienM::model()->findAll($criteria);
					foreach($models as $i=>$model)
					{
						$attributes = $model->attributeNames();
						foreach($attributes as $j=>$attribute) {
							$returnVal[$i]["$attribute"] = $model->$attribute;
						}
						$returnVal[$i]['label'] = $model->no_rekam_medik.' - '.$model->nama_pasien.(!empty($model->nama_bin) ? "(".$model->nama_bin.")" : "")." - ".$format->formatDateTimeForUser($model->tanggal_lahir);
						$returnVal[$i]['value'] = $model->no_rekam_medik;
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
     
	/**
	* Autocomplete Asuransi
	* @throws CHttpException
	*/
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
			$models = ROAsuransipasienM::model()->findAll($criteria);
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
			$models = ROAsuransipasienM::model()->findAll($criteria);
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
				$data["penjamin_nama"] = '';
				if($model){
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
				if(!empty($pasien_id)){
					$criteria->addCondition("pasien_id = ".$pasien_id);					
				}
                $criteria->compare('no_rekam_medik',$no_rekam_medik);
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
                $modPasien = new ROPasienM;
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
                $modPasien = new ROPasienM;
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
                $modPasien = new ROPasienM;
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
//                    $kelurahan = KelurahanM::model()->findAll('kecamatan_id='.$kecamatan_id.'');
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
                $modPasien = new ROPasienM;
                $propinsi_id = $_POST['propinsi_id'];
                $kabupaten_id = $_POST['kabupaten_id'];
                $kecamatan_id = $_POST['kecamatan_id'];
                $kelurahan_id = $_POST['kelurahan_id'];

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
//                $kabupatens = KabupatenM::model()->findAllByAttributes(array('propinsi_id'=>$propinsi_id,'kabupaten_aktif'=>true,));
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
//                $kecamatans = KecamatanM::model()->findAllByAttributes(array('kabupaten_id'=>$kabupaten_id,'kecamatan_aktif'=>true,));
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

                echo json_encode($data);
                Yii::app()->end();
            }
        }
        
        /**
         * untuk drop down rujukan
         */
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
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=  ROPendaftaranT::model()->findByPk($id);
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
            if(isset($_POST['ajax']) && $_POST['ajax']==='lkpendaftaran-t-form')
            {
                echo CActiveForm::validate($model);
                Yii::app()->end();
            }
	}
        /**
         * set checklist pemeriksaan rad
         */
        public function actionSetChecklistPemeriksaanRad(){
            if (Yii::app()->request->isAjaxRequest){
                $content = "";
                parse_str($_POST['data'], $post);
                $postPemeriksaan = $post['ROTarifpemeriksaanradruanganV'];
                if(!empty($postPemeriksaan['ruangan_id']) && !empty($postPemeriksaan['kelaspelayanan_id']) && !empty($postPemeriksaan['penjamin_id'])){
                    $criteria = new CdbCriteria();
                    $criteria->addCondition('ruangan_id = '.$postPemeriksaan['ruangan_id']);
                    $criteria->addCondition('kelaspelayanan_id = '.$postPemeriksaan['kelaspelayanan_id']);
                    $criteria->addCondition('penjamin_id = '.$postPemeriksaan['penjamin_id']);
                    $criteria->compare('LOWER(jenispemeriksaanrad_nama)',strtolower($postPemeriksaan['jenispemeriksaanrad_nama']));
					//$criteria->compare('jenispemeriksaanrad_id',$postPemeriksaan['jenispemeriksaanrad_id']);
                    $criteria->compare('LOWER(pemeriksaanrad_nama)',strtolower($postPemeriksaan['pemeriksaanrad_nama']), true);
                    $criteria->order = "jenispemeriksaanrad_urutan, pemeriksaanrad_urutan";
                    $modPemeriksaanRads = ROTarifpemeriksaanradruanganV::model()->findAll($criteria);
                    $content = $this->renderPartial($this->path_view.'_checklistPemeriksaanRad',array('modPemeriksaanRads'=>$modPemeriksaanRads), true);
                }
                echo CJSON::encode(array(
                    'content'=>$content));
                Yii::app()->end();
            }
        }  
        
        /**
         * @param type $pendaftaran_id
         */
        public function actionPrintStatusRad($pendaftaran_id) 
        {
            $this->layout='//layouts/printWindows';
            $format = new MyFormatter;
            $modPendaftaran = $this->loadModel($pendaftaran_id);
            $modPasien=ROPasienM::model()->findByPk($modPendaftaran->pasien_id);
            $modPasienMasukPenunjang = array();
            $daftartindakan = array();
            $modTindakans = array();
            $criteria1 = new CdbCriteria();
            $criteria1->addCondition('pendaftaran_id = '.$modPendaftaran->pendaftaran_id);
            $criteria1->order = "pendaftaran_id DESC, pasienmasukpenunjang_id ASC";
            $criteria1->addCondition('ruangan_id = '.Params::RUANGAN_ID_RAD);
            $loadPasienMasukPenunjang = ROPasienmasukpenunjangT::model()->find($criteria1);
            if(isset($loadPasienMasukPenunjang)){
                $modPasienMasukPenunjang = $loadPasienMasukPenunjang;
                $modTindakans = ROTindakanpelayananT::model()->findByAttributes(array('pasienmasukpenunjang_id'=>$modPasienMasukPenunjang->pasienmasukpenunjang_id),"karcis_id is not null");
                $criteria_tot = new CdbCriteria();
                $criteria_tot->addCondition("karcis_id IS NULL");
                $criteria_tot->addCondition("pasienmasukpenunjang_id = ".$modPasienMasukPenunjang->pasienmasukpenunjang_id);
                $daftartindakan = ROTindakanpelayananT::model()->findAll($criteria_tot);
            }
            
            $judul_print = 'Kunjungan Radiologi';
            $this->render($this->path_view.'printStatusRad', array(
                                'format'=>$format,
                                'modPendaftaran'=>$modPendaftaran,
                                'modPasienMasukPenunjang'=>$modPasienMasukPenunjang,
                                'judul_print'=>$judul_print,
                                'modPasien'=>$modPasien,
                                'modTindakans'=>$modTindakans,
                                'daftartindakan'=>$daftartindakan,
            ));
        } 
		
		
		/**
         * Cek keaktifan pegawai jika penjamin pt badak
         * @param type $encode
         * @param type $namaModel
         */
        public function actionCekCaraBayarBadak()
        {
            if(Yii::app()->request->isAjaxRequest) {
				$pasien_id = $_POST['pasien_id'];
				$pegawai_id = $_POST['pegawai_id'];
				$pesan = '';
				$status = false;
				$modPegawai = PPPegawaiM::model()->findByPk($pegawai_id);
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
         * Cek kategori pegawai untuk menentukan asuransi pasien
         * @param type $encode
         * @param type $namaModel
         */
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
						
						$modPegawai = PPPegawaiM::model()->findByPk($pegawai_id);
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
		
		/**
         * set dropdown jenis kasus penyakit
         */
        public function actionSetDropdownStatushubungankeluarga()
        {
            if(Yii::app()->getRequest()->getIsAjaxRequest()) {
				$penjamin_id = $_POST['penjamin_id'];
                $modAsuransiPasienBadak = new PPAsuransipasienbadakM();
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
			$models = PPAsuransipasienM::model()->findAll($criteria);
			
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
				$modPegawai = PPPegawaiM::model()->findByPk($model->pasien->pegawai_id);
				$returnVal[$i]['alamat_pegawai'] = !empty($modPegawai)?$modPegawai->alamat_pegawai:'';
				$returnVal[$i]['notelp_pegawai'] = !empty($modPegawai)?$modPegawai->notelp_pegawai:'';
			}
			echo CJSON::encode($returnVal);
		}else
			throw new CHttpException(403,'Tidak dapat mengurai data');
		Yii::app()->end();
    }
	
	/**
	* untuk menampilkan data pegawai 
	*/
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
		   $models = PPPegawaiM::model()->findAll($criteria);
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
}
