<?php

class InfoKunjunganRIController extends MyAuthController
{
        public $path_view = 'pendaftaranPenjadwalan.views.infoKunjunganRI.';
        public $rujukantersimpan = false;
        public $asuransipasientersimpan = false;
		public function actionIndex()
		{
		
            $format = new MyFormatter();
            $modPPInfoKunjunganRIV = new PPInfoKunjunganRIV;
            $modPPInfoKunjunganRIV->tgl_awal=date('Y-m-d');
            $modPPInfoKunjunganRIV->tgl_akhir=date('Y-m-d');
                if(isset($_REQUEST['PPInfoKunjunganRIV']))
                {
                    $modPPInfoKunjunganRIV->attributes=$_REQUEST['PPInfoKunjunganRIV'];
                    $modPPInfoKunjunganRIV->tgl_awal = $format->formatDateTimeForDb($_REQUEST['PPInfoKunjunganRIV']['tgl_awal']);
                    $modPPInfoKunjunganRIV->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['PPInfoKunjunganRIV']['tgl_akhir']);
                }                
            
                /*

             $this->render(
                'pendaftaranPenjadwalan.views.infoKunjunganRI.index',
                 array('modPPInfoKunjunganRIV'=>$modPPInfoKunjunganRIV)
             );
             */
             $this->render($this->path_view.'index',array('format'=>$format,'modPPInfoKunjunganRIV'=>$modPPInfoKunjunganRIV));
		}
        
        public function actionUbahDokterPeriksaRI($id,$ubahdokter_id=NULL)
        {
			$this->layout = "//layouts/iframe";
            $model = PPPasienAdmisiT::model()->findByAttributes(array('pendaftaran_id'=>$id));
			$modUbahDokter = new PPUbahdokterR;
			if(!empty($ubahdokter_id)){
				$modUbahDokter = PPUbahdokterR::model()->findByPk($ubahdokter_id);
			}
            if(isset($_POST['PPPasienAdmisiT']))
            {
                    $model->attributes = $_POST['PPPasienAdmisiT'];
					$modUbahDokter->attributes = $_POST['PPUbahdokterR'];
					$modUbahDokter->pendaftaran_id = $_POST['PPPasienAdmisiT']['pendaftaran_id'];
					$modUbahDokter->dokterbaru_id = $_POST['PPPasienAdmisiT']['pegawai_id'];
					$modUbahDokter->tglubahdokter = date('Y-m-d H:i:s');
					$modUbahDokter->create_time = date('Y-m-d H:i:s');
					$modUbahDokter->create_loginpemakai_id = Yii::app()->user->id;
					$modUbahDokter->create_ruangan = Yii::app()->user->getState('ruangan_id');
                    $transaction = Yii::app()->db->beginTransaction();
                    try {
                        $attributes = array('pendaftaran_id'=>$_POST['PPPasienAdmisiT']['pendaftaran_id']);
                        $data = $model::model()->findByAttributes($attributes);

                        $attributes = array('pegawai_id'=>$_POST['PPPasienAdmisiT']['pegawai_id']);
                        $save = $model::model()->updateByPk($data['pasienadmisi_id'], $attributes);
						
                        if($save)
                        {
							$modUbahDokter->save();
                            $transaction->commit();
                            $this->redirect(array('ubahDokterPeriksaRI','id'=>$model->pendaftaran_id,'ubahdokter_id'=>$modUbahDokter->ubahdokter_id,'sukses'=>1));
                        }else{
                            echo CJSON::encode(array(
                                'status'=>'proses_form', 
                                'div'=>"<div class='flash-error'>Data gagal disimpan.</div>",
                                ));                    
                        }
                        exit;
                    }catch(Exception $exc){
                        $transaction->rollback();
                    }                
            }
			$this->render($this->path_view.'_formUbahDokterPeriksaRI',
                 array('model'=>$model,'modUbahDokter'=>$modUbahDokter)
            );  
			
        }
        
        /**
         * untuk mengubah cara bayar
         */
        public function actionUbahCaraBayarRI($id = null, $idSep = null)
        {
            $this->layout = "//layouts/iframe";
			if ($id == null){
				if (isset($_POST['id'])){
					$id = $_POST['id'];
				}
			}
			
            $model = new UbahcarabayarR;
			if ($id != null){
				$modPendaftaran = PPPendaftaranT::model()->findByPk($id);
				if(!empty($modPendaftaran->pasienadmisi_id)){
					$modAdmisi = PPPasienAdmisiT::model()->findByPk($modPendaftaran->pasienadmisi_id);
				}
				if ($modPendaftaran != null){
					$modPasien = PPPasienM::model()->findByPk($modPendaftaran->pasien_id);
				}
			}
            $modRujukanBpjs=new PPRujukanbpjsT;
            $modAsuransiPasien=new PPAsuransipasienM;
            $modAsuransiPasienBpjs =new PPAsuransipasienbpjsM;
            $modSep=new PPSepT;
					
            if(isset($idSep)){
                $modRujukanBpjs= PPRujukanbpjsT::model()->findByPk($modPendaftaran->rujukan_id);
                $modAsuransiPasienBpjs = PPAsuransipasienbpjsM::model()->findByPk($modPendaftaran->asuransipasien_id);
                $modSep = PPSepT::model()->findByPk($idSep);
            }
			
            if(isset($_POST['UbahcarabayarR']))
            {
                $pendaftaran_id = $_POST['pendaftaran_id'];
                $model->attributes = $_POST['UbahcarabayarR'];
                $model->pendaftaran_id = $_POST['pendaftaran_id'];
                $model->carabayar_id = $_POST['PPPasienAdmisiT']['carabayar_id'];
                $modPendaftaran = PPPendaftaranT::model()->findByPk($pendaftaran_id);
				$modPasien = PPPasienM::model()->findByPk($modPendaftaran->pasien_id);
                $model->tglubahcarabayar = date('Y-m-d H:i:s');
				$model->create_time=date('Y-m-d H:i:s');
				$model->update_time=date('Y-m-d H:i:s');
				$model->update_loginpemakai_id=Yii::app()->user->id;
				$model->create_loginpemakai_id=Yii::app()->user->id;
				$model->create_ruangan= Yii::app()->user->getState('ruangan_id');
                $transaction = Yii::app()->db->beginTransaction();
                try {

                    $modPendaftaran = PPPendaftaranT::model()->findByPk(
                        $model->pendaftaran_id
                    );

                    if(isset($_POST['PPPendaftaranT'])){
                        $modPendaftaran->attributes = $_POST['PPPendaftaranT'];
                    }
                    $modPendaftaran->carabayar_id = $model->carabayar_id;
                    $modPendaftaran->penjamin_id = $model->penjamin_id;
                    $modAdmisi->carabayar_id = $model->carabayar_id;
                    $modAdmisi->penjamin_id = $model->penjamin_id;

                    if($model->save() ){
                            if(isset($_POST['PPRujukanbpjsT'])){
                                $modRujukanBpjs = $this->simpanRujukanBpjs($modRujukanBpjs, $_POST['PPRujukanbpjsT']);
                            }else{
                                $this->rujukantersimpan = true; 
                            }

                            if(isset($_POST['PPAsuransipasienM'])){
                                if(isset($_POST['PPAsuransipasienM']['asuransipasien_id'])){
                                    if(!empty($_POST['PPAsuransipasienM']['asuransipasien_id'])){
                                        $modAsuransiPasien = PPAsuransipasienM::model()->findByPk($_POST['PPAsuransipasienM']['asuransipasien_id']);
                                    }
                                }
								$modAsuransiPasien = $this->simpanAsuransiPasien($modAsuransiPasien, $modPendaftaran, $modPasien, $_POST['PPAsuransipasienM']);
                            }else{
                                $this->asuransipasientersimpan = true;
                            }
                            
                            if(isset($_POST['PPAsuransipasienbpjsM'])){
                                if(isset($_POST['PPAsuransipasienbpjsM']['asuransipasien_id'])){
                                    if(!empty($_POST['PPAsuransipasienbpjsM']['asuransipasien_id'])){
                                        $modAsuransiPasienBpjs = PPAsuransipasienM::model()->findByPk($_POST['PPAsuransipasienbpjsM']['asuransipasien_id']);
                                    }
                                }
								$modAsuransiPasienBpjs = $this->simpanAsuransiPasien($modAsuransiPasienBpjs, $modPendaftaran, $modPasien, $_POST['PPAsuransipasienbpjsM']);
                            }else{
                                $this->asuransipasientersimpan = true;
                            }
							$pasienadmisi_id = PPPendaftaranT::model()->findByPk($pendaftaran_id)->pasienadmisi_id;
							$masukkamar_id = PPMasukKamarT::model()->findByAttributes(array('pasienadmisi_id'=>$pasienadmisi_id),'pindahkamar_id is null')->masukkamar_id;
                            if(!empty($modRujukanBpjs->rujukan_id) && !empty($modAsuransiPasienBpjs->asuransipasien_id)){
                                PPPendaftaranT::model()->updateByPk($pendaftaran_id,array('rujukan_id'=>$modRujukanBpjs->rujukan_id,'asuransipasien_id'=>$modAsuransiPasienBpjs->asuransipasien_id));
								PPPasienAdmisiT::model()->updateByPk($pasienadmisi_id,array('carabayar_id'=>$modAdmisi->carabayar_id,'penjamin_id'=>$modAdmisi->penjamin_id));
								PPMasukKamarT::model()->updateByPk($masukkamar_id,array('carabayar_id'=>$modAdmisi->carabayar_id,'penjamin_id'=>$modAdmisi->penjamin_id));
                            }else if(!empty($modAsuransiPasien->asuransipasien_id)){
                                PPPendaftaranT::model()->updateByPk($pendaftaran_id,array('asuransipasien_id'=>$modAsuransiPasien->asuransipasien_id));
								PPPasienAdmisiT::model()->updateByPk($pasienadmisi_id,array('carabayar_id'=>$modAdmisi->carabayar_id,'penjamin_id'=>$modAdmisi->penjamin_id));
								PPMasukKamarT::model()->updateByPk($masukkamar_id,array('carabayar_id'=>$modAdmisi->carabayar_id,'penjamin_id'=>$modAdmisi->penjamin_id));
                            }else{
                                PPPasienAdmisiT::model()->updateByPk($pasienadmisi_id,array('carabayar_id'=>$modAdmisi->carabayar_id,'penjamin_id'=>$modAdmisi->penjamin_id));
                                PPMasukKamarT::model()->updateByPk($masukkamar_id,array('carabayar_id'=>$modAdmisi->carabayar_id,'penjamin_id'=>$modAdmisi->penjamin_id));
                            }

                            if (isset($_POST['PPSepT'])) {
                                $modSep = $this->simpanSep($modPendaftaran,$modPasien,$modRujukanBpjs,$modAsuransiPasienBpjs,$_POST['PPSepT']);
                            }

                        $transaction->commit();
                        if(isset($modSep->nosep)){
                            $this->redirect(array('ubahCaraBayarRI','id'=>$model->pendaftaran_id,'idSep'=>$modSep->sep_id,'sukses'=>1));
                        }else{
                            $this->redirect(array('ubahCaraBayarRI','id'=>$model->pendaftaran_id,'sukses'=>1));
                        }

                    } else {                
                        $transaction->rollback();
                        Yii::app()->user->setFlash('error',"Data pasien gagal disimpan !");
                    }
                } catch (Exception $exc) {
                    $transaction->rollback();
                    Yii::app()->user->setFlash('error',"Data pasien gagal disimpan !");
                }
            }
			

			$this->render('_formUbahCaraBayar',
                array(
                    'model'=>$model,
                    'modPendaftaran'=>$modPendaftaran,
                    'modAsuransiPasien'=>$modAsuransiPasien,
                    'modAsuransiPasienBpjs'=>$modAsuransiPasienBpjs,
                    'modRujukanBpjs'=>$modRujukanBpjs,
                    'modSep'=>$modSep,
                    'modAdmisi'=>$modAdmisi,
                )
            );  
        }
		
		public function actionUbahKeteranganPendaftaran()
		{
			$model = new PendaftaranT;
			if(isset($_POST['PendaftaranT']))
			{
				if($_POST['PendaftaranT']['keterangan_pendaftaran'] != "")
				{
					$model->attributes = $_POST['PendaftaranT'];
					$transaction = Yii::app()->db->beginTransaction();
					try {
						$attributes = array('keterangan_pendaftaran'=>$_POST['PendaftaranT']['keterangan_pendaftaran']);
						$save = $model::model()->updateByPk($_POST['PendaftaranT']['pendaftaran_id'], $attributes);
						if($save)
						{
							$transaction->commit();
							echo CJSON::encode(array(
								'status'=>'proses_form', 
								'div'=>"<div class='flash-success'>Berhasil merubah Keterangan Pendaftaran.</div>",
								));
						}else{
							echo CJSON::encode(array(
								'status'=>'proses_form', 
								'div'=>"<div class='flash-error'>Data gagal disimpan.</div>",
								));                    
						}
						exit;
					}catch(Exception $exc) {
						$transaction->rollback();
					}
				}else{
					echo CJSON::encode(
						array(
							'status'=>'proses_form',
							'div'=>"<div class='flash-success'>Berhasil merubah data Keterangan Pendaftaran.</div>",
						)
					);
					exit;
				}
			}

			if (Yii::app()->request->isAjaxRequest)
			{
				echo CJSON::encode(array(
					'status'=>'create_form', 
					'div'=>$this->renderPartial($this->path_view.'_formUbahKeterangan', array('model'=>$model), true)));
				exit;               
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
            $modSep = new PPSepT;
            $bpjs = new Bpjs('http://api.asterix.co.id/SepWebRest');

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
		
        public function actionUbahKelasPelayananRI()
        {
            $model = new PasienadmisiT;
            if(isset($_POST['PasienadmisiT']))
            {
                if($_POST['PasienadmisiT']['kelaspelayanan_id'] != "")
                {
                    $model->attributes = $_POST['PasienadmisiT'];
                    $transaction = Yii::app()->db->beginTransaction();
                    try {
                        $attributes = array('pendaftaran_id'=>$_POST['PasienadmisiT']['pendaftaran_id']);
                        $data = $model::model()->findByAttributes($attributes);
                        
                        $attributes = array('kelaspelayanan_id'=>$_POST['PasienadmisiT']['kelaspelayanan_id']);
                        $save = $model::model()->updateByPk($data['pasienadmisi_id'], $attributes);
                        
                        if($save)
                        {
                            $transaction->commit();
                            echo CJSON::encode(array(
                                'status'=>'proses_form', 
                                'div'=>"<div class='flash-success'>Berhasil merubah Kelas Pelayanan.</div>",
                                ));
                        }else{
                            echo CJSON::encode(array(
                                'status'=>'proses_form', 
                                'div'=>"<div class='flash-error'>Data gagal disimpan.</div>",
                                ));                    
                        }
                        exit;
                    }catch(Exception $exc) {
                        $transaction->rollback();
                    }
                }else{
                    echo CJSON::encode(
                        array(
                            'status'=>'proses_form',
                            'div'=>"<div class='flash-success'>Berhasil merubah data Kelas Pelayanan.</div>",
                        )
                    );
                    exit;
                }
            }
            
            if (Yii::app()->request->isAjaxRequest)
            {
                echo CJSON::encode(array(
                    'status'=>'create_form', 
                    'div'=>$this->renderPartial($this->path_view.'_formUbahKelasPelayananRI', array('model'=>$model), true)));
                exit;               
            }
        }

         /*
         * Mencari kelas pelayanan berdasarkan ruangan_id di tabel KelasruanganM
         * and open the template in the editor.
         */
        public function actionSetDropdownKelasPelayanan()
        {
            if(Yii::app()->request->isAjaxRequest) {
                $ruangan_id = $_POST['ruangan_id'];
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
         * Mengatur dropdown kabupaten
         * @param type $encode jika = true maka return array jika false maka set Dropdown 
         * @param type $model_nama
         * @param type $attr
         */
        public function actionSetDropdownKabupaten($encode=false,$model_nama='',$attr='')
        {
            if(Yii::app()->request->isAjaxRequest) {
                $modPasien = new PPPasienM;
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
                $modPasien = new PPPasienM;
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
                $modPasien = new PPPasienM;
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
                $modPasien = new PPPasienM;
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
		
		public function actionListDokterRuangan()
		{
			if(Yii::app()->getRequest()->getIsAjaxRequest()) {
				if(!empty($_POST['idRuangan'])){
					$idRuangan = $_POST['idRuangan'];
					$data = DokterV::model()->findAllByAttributes(array('ruangan_id'=>$idRuangan),array('order'=>'nama_pegawai'));
					$data = CHtml::listData($data,'pegawai_id','NamaLengkap');

					if(empty($data)){
						$option = CHtml::tag('option',array('value'=>''),CHtml::encode('-- Pilih --'),true);
					}else{
						$option = CHtml::tag('option',array('value'=>''),CHtml::encode('-- Pilih --'),true);
						foreach($data as $value=>$name) {
								$option .= CHtml::tag('option',array('value'=>$value),CHtml::encode($name),true);
						}
					}

					$dataList['listDokter'] = $option;
				} else {
					$dataList['listDokter'] = $option = CHtml::tag('option',array('value'=>''),CHtml::encode('-- Pilih --'),true);
				}

				echo json_encode($dataList);
				Yii::app()->end();
			}
		}
		
		public function actionGetPenjaminPasien($encode=false,$namaModel='')
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
						$penjamin = PenjaminpasienM::model()->findAllByAttributes(array('carabayar_id'=>$carabayar_id), array('order'=>'penjamin_nama ASC'));
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
		
//		public function actionGetListCaraBayar()
//		{
//			if(Yii::app()->getRequest()->getIsAjaxRequest()) {
//				$idCaraBayar = $_POST['idCaraBayar'];
//
//				$carabayars = CarabayarM::model()->findAllByAttributes(array('carabayar_aktif'=>true),array('order'=>'carabayar_nama'));
//				$carabayars = CHtml::listData($carabayars,'carabayar_id','carabayar_nama');
//				$Option = "";
//				foreach($carabayars as $value=>$name)
//				{
//					if($value==$idCaraBayar)
//						$Option .= CHtml::tag('option',array('value'=>$value,'selected'=>true),CHtml::encode($name),true);
//					else
//						$Option .= CHtml::tag('option',array('value'=>$value),CHtml::encode($name),true);
//				}
//
//				$dataList['listCaraBayar'] = $Option;
//
//				$penjamins = PenjaminpasienM::model()->findAllByAttributes(array('carabayar_id'=>$idCaraBayar,'penjamin_aktif'=>true),array('order'=>'penjamin_nama'));
//				$penjamins = CHtml::listData($penjamins,'penjamin_id','penjamin_nama');
//				$Option = CHtml::tag('option',array('value'=>''),CHtml::encode('-- Pilih --'),true);
//				foreach($penjamins as $value=>$name)
//				{
//					if($value==$idCaraBayar)
//						$Option .= CHtml::tag('option',array('value'=>$value,'selected'=>true),CHtml::encode($name),true);
//					else
//						$Option .= CHtml::tag('option',array('value'=>$value),CHtml::encode($name),true);
//				}
//
//				$dataList['listPenjamin'] = $Option;
//
//				echo json_encode($dataList);
//				Yii::app()->end();
//			}
//		}
		
		public function actionGetDataPendaftaranRI()
		{
			if (Yii::app()->request->isAjaxRequest){
				$id_pendaftaran = (isset($_POST['pendaftaran_id']) ? $_POST['pendaftaran_id'] : null);
				$model = InfokunjunganriV::model()->findByAttributes(array('pendaftaran_id'=>$id_pendaftaran));
				$attributes = $model->attributeNames();
				foreach($attributes as $j=>$attribute) {
					$returnVal["$attribute"] = $model->$attribute;
				}
				echo json_encode($returnVal);
				Yii::app()->end();
			}
		}
		
		public function actionGetListPenjamin()
		{
			if(Yii::app()->getRequest()->getIsAjaxRequest()) {
				$idCaraBayar = $_POST['idCaraBayar'];
				$idPenjamin = (isset($_POST['idPenjamin'])) ? $_POST['idPenjamin'] : '';

				$penjamins = PenjaminpasienM::model()->findAllByAttributes(array('carabayar_id'=>$idCaraBayar,'penjamin_aktif'=>true),array('order'=>'penjamin_nama'));
				$penjamins = CHtml::listData($penjamins,'penjamin_id','penjamin_nama');
				$Option = "";
				foreach($penjamins as $value=>$name)
				{
					if($value==$idPenjamin)
						$Option .= CHtml::tag('option',array('value'=>$value,'selected'=>true),CHtml::encode($name),true);
					else
						$Option .= CHtml::tag('option',array('value'=>$value),CHtml::encode($name),true);
				}

				$dataList['listPenjamin'] = $Option;

				echo json_encode($dataList);
				Yii::app()->end();
			}
		}
		
		public function actionGetRuanganPasien()
		{
			if (Yii::app()->getRequest()->getIsAjaxRequest())
			 {
				$pendaftaran_id= (isset($_POST['pendaftaran_id']) ? $_POST['pendaftaran_id'] : null);
				$ruangan_id= (isset($_POST['ruangan_id']) ? $_POST['ruangan_id'] : null);
				$instalasi_id= (isset($_POST['instalasi_id']) ? $_POST['instalasi_id'] : null);
				$pegawai_id = (isset($_POST['pegawai_id']) ? $_POST['pegawai_id'] : null);

				if(isset($_POST['jeniskasuspenyakit_id'])){
					$jeniskasuspenyakit_id= (isset($_POST['jeniskasuspenyakit_id']) ? $_POST['jeniskasuspenyakit_id'] : null);
					$jenisKasusPenyakit = '';
					$criteria=new CDbCriteria;
					$criteria->select ='t.ruangan_id, t.jeniskasuspenyakit_id, ruangan_m.ruangan_nama, jeniskasuspenyakit_m.jeniskasuspenyakit_nama,
										jeniskasuspenyakit_aktif';
					if(!empty($ruangan_id)){$criteria->addCondition("t.ruangan_id = ".$ruangan_id); }
					if(!empty($jeniskasuspenyakit_id)){
						$criteria->addCondition('t.jeniskasuspenyakit_id = '.$jeniskasuspenyakit_id);
					}
					$criteria->addCondition('jeniskasuspenyakit_m.jeniskasuspenyakit_aktif is true');
					$criteria->join = 'LEFT JOIN ruangan_m on t.ruangan_id = ruangan_m.ruangan_id
									   LEFT JOIN jeniskasuspenyakit_m on t.jeniskasuspenyakit_id = jeniskasuspenyakit_m.jeniskasuspenyakit_id
										';
					$dataJenisPenyakit =KasuspenyakitruanganM::model()->findAll($criteria);
	//                $dataJenisPenyakit =KasuspenyakitruanganM::model()->findAll('jeniskasuspenyakit_id='.$jeniskasuspenyakit_id.' AND jeniskasuspenyakit_aktif=TRUE ORDER BY jeniskasuspenyakit_nama');

					  foreach($dataJenisPenyakit AS $jenisPenyakit){
						  if($jenisPenyakit['jeniskasuspenyakit_id']==$jeniskasuspenyakit_id)
							 {
								   $jenisKasusPenyakit .='<option value="'.$jenisPenyakit['jeniskasuspenyakit_id'].'" selected="selected">'.$jenisPenyakit['jeniskasuspenyakit_nama'].'</option>';
							 }
						 else
							  {
								   $jenisKasusPenyakit .='<option value="'.$jenisPenyakit['jeniskasuspenyakit_id'].'">'.$jenisPenyakit['jeniskasuspenyakit_nama'].'</option>';
							  }

					  } 
					$data['jenisKasusPenyakit']=$jenisKasusPenyakit;    
				}


				if(isset($_POST['pegawai_id'])){
					$pegawai_id=$_POST['pegawai_id'];
					$ruangan_id = $_POST['ruangan_id'];
					$criteria=new CDbCriteria;
					$criteria->select ='t.ruangan_id, t.pegawai_id, t.nama_pegawai';
					if(!empty($ruangan_id)){$criteria->addCondition("t.ruangan_id = ".$ruangan_id); }
					if(!empty($jeniskasuspenyakit_id)){
						$criteria->addCondition("t.pegawai_id = ".$pegawai_id);
					}
					$dataDokter = DokterV::model()->findAll($criteria);
	//                $dataJenisPenyakit =KasuspenyakitruanganM::model()->findAll('jeniskasuspenyakit_id='.$jeniskasuspenyakit_id.' AND jeniskasuspenyakit_aktif=TRUE ORDER BY jeniskasuspenyakit_nama');
					$dokter = '';
					  foreach($dataDokter AS $dokters){
						  if($dokters['pegawai_id']==$pegawai_id)
							 {
								   $dokter .='<option value="'.$dokters['pegawai_id'].'" selected="selected">'.$dokters['nama_pegawai'].'</option>';
							 }
						 else
							  {
								   $dokter .='<option value="'.$dokters['pegawai_id'].'">'.$dokters['nama_pegawai'].'</option>';
							  }
					  } 
					$data['dokter']=$dokter;    
				}

				$dropDown='';
				$dataRuangan =RuanganM::model()->findAll('instalasi_id='.$instalasi_id.' AND ruangan_aktif=TRUE ORDER BY ruangan_nama');
				foreach ($dataRuangan AS $tampilRuangan)
				{
				   if($tampilRuangan['ruangan_id']==$ruangan_id)
					   {
							 $dropDown .='<option value="'.$tampilRuangan['ruangan_id'].'" selected="selected" onchange="getKasusPenyakit('.$ruangan_id.')">'.$tampilRuangan['ruangan_nama'].'</option>';
					   }
				   else
						{
							 $dropDown .='<option value="'.$tampilRuangan['ruangan_id'].'" onchange="return getKasusPenyakit('.$ruangan_id.')">'.$tampilRuangan['ruangan_nama'].'</option>';
						}

				}
				   $data['dropDown']=$dropDown;    
				   echo json_encode($data);
				   Yii::app()->end();    
			 }
		}
		
		public function actionSaveRuanganBaru()
        {
            $updatetindakan = false;
            $pendaftaran_id = $_POST['pendaftaran_id'];
            $pasien_id = $_POST['pasien_id'];
            $ruangan_id = $_POST['ruangan_id'];
            $jeniskasuspenyakit_id = (isset($_POST['jeniskasuspenyakit_id']) ? $_POST['jeniskasuspenyakit_id'] : null);
            $alasan = $_POST['alasan'];
            $ruangan_awal = $_POST['ruangan_awal'];
            $idTindakan = (isset($_POST['idTindakan']) ? $_POST['idTindakan'] : null);
            $tarifSatuan = (isset($_POST['tarifSatuan']) ? $_POST['tarifSatuan'] : null);
            $idKarcis = (isset($_POST['idKarcis']) ? $_POST['idKarcis'] : null);
            $tarifkarcis = (isset($_POST['tarifkarcis']) ? $_POST['tarifkarcis'] : null);
            $kelas = (isset($_POST['kelaspelayanan_id']) ? $_POST['kelaspelayanan_id'] : null);
            $karcisTindakan = (isset($_POST['karcisTindakan']) ? $_POST['karcisTindakan'] : null);
            $modPasien = PasienM::model()->findByPk($pasien_id);
            $model = PendaftaranT::model()->findByPk($pendaftaran_id);
            if(!empty($model->pegawai_id)){
                $pegawai_id = (isset($_POST['pegawai_id']) ? $_POST['pegawai_id'] : null);
            }else{
                $pegawai_id = (isset($_POST['pegawai_id']) ? $_POST['pegawai_id'] : $model->pegawai_id);
            }

//            $pegawai_id = (!isset($_POST['pegawai_id']) && ($_POST['pegawai_id'] == 'null') ? $model->pegawai_id : $_POST['pegawai_id']);
            $modRiwayat = new UbahruanganR;
            $modRiwayat->ruanganawal_id = $ruangan_awal;
            $modRiwayat->menjadiruangan_id = $ruangan_id;
            $modRiwayat->alasanperubahan = $alasan;
            $modRiwayat->pendaftaran_id = $pendaftaran_id;
            $modRiwayat->tglperubahan = date('Y-m-d');
            $modRiwayat->pasien_id = $pasien_id;

            $data = array();
            $transaction = Yii::app()->db->beginTransaction();
            try {
                $success = false;
                if($modRiwayat->validate()){
                    if(isset($_POST['pasienadmisi_id'])){
                        if(PasienadmisiT::model()->updateByPk ($_POST['pasienadmisi_id'], array('ruangan_id'=>$ruangan_id))){
                            $update = true;
                            $success = true;
                                $data['status'] = 'OK';
                        }
                    }

                    if($update && $success){
                        if($modRiwayat->save()){
                            $data['status'] = 'OK';
                        }else{
                            $success = false;
                            $data['status'] = 'Gagal';
                        }
                    } else {
                        $success = false;
                        $data['status'] = 'Gagal';
                    }

                } else {
                    $data['status'] = 'Gagal';
                    echo print_r($modRiwayat->errors,1);
                }

                if ($success){
                    $transaction->commit();
                }else{
                    $transaction->rollback();
                }

            } catch (Exception $exc) {
                $data['status'] = 'Gagal'.$exc;
                $transaction->rollback();
            }

            echo CJSON::encode($data);
            Yii::app()->end();

        }
		
		public function actionUbahJenisKelamin()
		{
			$model = new PasienM;
			if(isset($_POST['PasienM']))
			{
				$model->attributes = $_POST['PasienM'];
				$transaction = Yii::app()->db->beginTransaction();
				try {
					$attributes = array('jeniskelamin'=>$_POST['PasienM']['jeniskelamin']);
					$save = PasienM::model()->updateByPk($_POST['PasienM']['pasien_id'], $attributes);
					if($save)
					{
						$transaction->commit();
						echo CJSON::encode(array(
							'status'=>'proses_form', 
							'div'=>"<div class='flash-success'>Berhasil merubah data Jenis Kelamin Pasien.</div>",
							));                    
					}else{
						echo CJSON::encode(array(
							'status'=>'proses_form', 
							'div'=>"<div class='flash-error'>Data gagal disimpan.</div>",
							));                    
					}
					exit;
				}catch(Exception $exc) {
					$transaction->rollback();
				}
			}

			if (Yii::app()->request->isAjaxRequest)
			{
				echo CJSON::encode(array(
					'status'=>'create_form', 
					'div'=>$this->renderPartial($this->path_view.'_formUbahJenisKelamin', array('model'=>$model), true)));
				exit;               
			}
		}
		
		public function actionCariPasien()
		{
			if (Yii::app()->request->isAjaxRequest){
				$noRM = (isset($_POST['norekammedik']) ? $_POST['norekammedik'] : null);

				$model = PasienM::model()->findByAttributes(array('no_rekam_medik'=>$noRM));
				$attributes = $model->attributeNames();
				foreach($attributes as $j=>$attribute) {
					$returnVal["$attribute"] = $model->$attribute;
				}

				echo json_encode($returnVal);
				Yii::app()->end();
			}
		}
		
		
}