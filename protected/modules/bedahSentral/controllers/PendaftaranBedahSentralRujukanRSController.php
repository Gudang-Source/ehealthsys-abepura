<?php

class PendaftaranBedahSentralRujukanRSController extends MyAuthController
{
    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout='//layouts/column1';
    public $defaultAction = 'index';
    public $path_view = "bedahSentral.views.pendaftaranBedahSentralRujukanRS.";
	
	public $rencanaoperasitersimpan = false;
	public $pasienpenunjangtersimpan = false;
	public $pasienkirimunitlain = false;
    /**
     * Tambah / Ubah Pemeriksaan Bedah.
     */
    public function actionIndex($pasienmasukpenunjang_id=null,$pendaftaran_id = null,$instalasi_id = null)
    {
        $format = new MyFormatter();
        $modKunjungan=new BSPasienKirimKeUnitLainV;
        $modKunjungan->ruangan_id = Yii::app()->user->getState("ruangan_id");
        $modPemeriksaanBedah = new BSTarifoperasiruanganV;
        $modPasienMasukPenunjang = new BSPasienmasukpenunjangT;
        $modPasienMasukPenunjang->ruangan_id = Yii::app()->user->getState("ruangan_id");
        $modTindakan=new BSTindakanPelayananT;
		
        $dataTindakans = array(); 
        $modRencanaOperasi = new BSRencanaOperasiT;
		$modRencanaOperasi->norencanaoperasi = MyGenerator::noRencanaOperasi();
		$modRencanaOperasi->statusoperasi = Params::DEFAULT_STATUS_OPERASI;
		$modRencanaOperasi->tglrencanaoperasi = date('Y-m-d h:i:s');
		$modRencanaOperasi->qty_tindakan = 1;

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
            $modKunjungan = BSPasienKirimKeUnitLainV::model()->findByAttributes(array('pasienkirimkeunitlain_id'=>$_GET['pasienkirimkeunitlain_id']));
            $modPasienMasukPenunjang->pasienkirimkeunitlain_id = isset($modKunjungan->pasienkirimkeunitlain_id) ? $modKunjungan->pasienkirimkeunitlain_id:"";
            $modPasienMasukPenunjang->jeniskasuspenyakit_id = isset($modKunjungan->jeniskasuspenyakit_id) ? $modKunjungan->jeniskasuspenyakit_id:"";
            $modPasienMasukPenunjang->kelaspelayanan_id = isset($modKunjungan->kelaspelayanan_id) ? $modKunjungan->kelaspelayanan_id:"";
        }
		
        if(isset($_GET['pendaftaran_id'])){
            $modKunjungan = BSInfokunjunganrjrdriV::model()->findByAttributes(array('pendaftaran_id'=>$_GET['pendaftaran_id'],'instalasi_id'=>$_GET['instalasi_id']));
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
            $modPasienMasukPenunjang = BSPasienmasukpenunjangT::model()->findByPk($pasienmasukpenunjang_id);
            $loadModKunjungan = BSPasienMasukPenunjangV::model()->findByAttributes(array('pasienmasukpenunjang_id'=>$pasienmasukpenunjang_id));
            if(isset($loadModKunjungan)){
                $modKunjungan = $loadModKunjungan;
            }
			$loadRencanaOperasi = BSRencanaOperasiT::model()->findByAttributes(array('pasienmasukpenunjang_id'=>$pasienmasukpenunjang_id));
			if(count($loadRencanaOperasi) > 0){
				$modRencanaOperasi=$loadRencanaOperasi;
			}
			$modTindakan = new BSRencanaOperasiT();
        }
		
		
		
		if (isset($_POST['BSRencanaOperasiT'])){
			
			$modRencanaOperasi->attributes = $_POST['BSRencanaOperasiT'];
			
			
			$modPendaftaran = $this->loadModel($_POST['pendaftaran_id']);
			$transaction = Yii::app()->db->beginTransaction();
			try{
				
					if(isset($_POST['BSPasienmasukpenunjangT'])){
						$modPasienMasukPenunjang = $this->savePasienPenunjang($modPendaftaran,$_POST['BSPasienmasukpenunjangT'],$modRencanaOperasi);
						if(!empty($modPasienMasukPenunjang->pasienkirimkeunitlain_id)){
							$dataPasienKirimUnitLain = BSPasienKirimKeUnitLainT::model()->findByPk($modPasienMasukPenunjang->pasienkirimkeunitlain_id); 
							$dataPasienKirimUnitLain->pasienmasukpenunjang_id = $modPasienMasukPenunjang->pasienmasukpenunjang_id;
							if($dataPasienKirimUnitLain->validate()){
								$dataPasienKirimUnitLain->update();
								$this->pasienkirimunitlain = true;
							}else{
								$this->pasienkirimunitlain = false;
							}
						}
					}
					
						foreach($_POST['BSRencanaOperasiT'] as $k => $v){
							if(is_array($v)){
								$postRencanaTindakan[] = $v;
							}
						}
						if(count($postRencanaTindakan) > 0){
							foreach($postRencanaTindakan AS $ii => $rencana){
								if(!empty($rencana['rencanaoperasi_id'])){
									$dataTindakansa[$ii] = BSRencanaOperasiT::model()->findByPk($rencana['rencanaoperasi_id']);
									$dataTindakansa[$ii]->tglrencanaoperasi = $format->formatDateTimeForDb($_POST['BSRencanaOperasiT']['tglrencanaoperasi']);
									$dataTindakansa[$ii]->kamarruangan_id = !empty($_POST['BSRencanaOperasiT']['kamarruangan_id'])?$_POST['BSRencanaOperasiT']['kamarruangan_id']:null;
									$dataTindakansa[$ii]->dokterpelaksana1_id = !empty($_POST['BSRencanaOperasiT']['dokterpelaksana1_id'])?$_POST['BSRencanaOperasiT']['dokterpelaksana1_id']:null;
									$dataTindakansa[$ii]->dokterpelaksana2_id = !empty($_POST['BSRencanaOperasiT']['dokterpelaksana2_id'])?$_POST['BSRencanaOperasiT']['dokterpelaksana2_id']:null;
									$dataTindakansa[$ii]->dokteranastesi_id = !empty($_POST['BSRencanaOperasiT']['dokteranastesi_id'])?$_POST['BSRencanaOperasiT']['dokteranastesi_id']:null;
									$dataTindakansa[$ii]->paramedis_id = !empty($_POST['BSRencanaOperasiT']['paramedis_id'])?$_POST['BSRencanaOperasiT']['paramedis_id']:null;
									$dataTindakansa[$ii]->suster_id = !empty($_POST['BSRencanaOperasiT']['suster_id'])?$_POST['BSRencanaOperasiT']['suster_id']:null;
									$dataTindakansa[$ii]->bidan_id = !empty($_POST['BSRencanaOperasiT']['bidan_id'])?$_POST['BSRencanaOperasiT']['bidan_id']:null;
									$dataTindakansa[$ii]->keterangan_rencana = $_POST['BSRencanaOperasiT']['keterangan_rencana'];
									$dataTindakansa[$ii]->operasi_id = $rencana['operasi_id'];
									$dataTindakansa[$ii]->is_cyto = (($rencana['cyto_tindakan'] == 1 ) ? TRUE : FALSE );
									$dataTindakansa[$ii]->mulaioperasi = $format->formatDateTimeForDb($dataTindakansa[$ii]->mulaioperasi);
									$dataTindakansa[$ii]->selesaioperasi = $format->formatDateTimeForDb($dataTindakansa[$ii]->selesaioperasi);
									$dataTindakansa[$ii]->create_time = $format->formatDateTimeForDb($dataTindakansa[$ii]->create_time);
									$dataTindakansa[$ii]->update_time = $format->formatDateTimeForDb($dataTindakansa[$ii]->update_time);
									$dataTindakansa[$ii]->update();
									$this->rencanaoperasitersimpan = true;
								}else{
									$dataTindakansa[$ii] = $this->saveRencanaOperasi($modPendaftaran,$modPasienMasukPenunjang,$modRencanaOperasi,$rencana);
								}
							}
						}
					
				if ($this->pasienpenunjangtersimpan && $this->rencanaoperasitersimpan){
					// SMS GATEWAY

                    $sms = new Sms();
                    $smspasien = 1;
                    $modPasien = PasienM::model()->findByPk($modKunjungan->pasien_id);
                    $modKamarruangan = KamarruanganM::model()->findByPk($modRencanaOperasi->kamarruangan_id);
                    $modRuangan = isset($modKamarruangan->ruangan) ? $modKamarruangan->ruangan : $modPasienMasukPenunjang->ruangan;
                    $modKelaspelayanan = isset($modKamarruangan->kelaspelayanan) ? $modKamarruangan->kelaspelayanan : $modPasienMasukPenunjang->kelaspelayanan;
   

                    foreach ($modSmsgateway as $i => $smsgateway) {

                        $isiPesan = $smsgateway->templatesms;

                        $attributes = $modRencanaOperasi->getAttributes();
                        foreach($attributes as $attributes => $value){
                            $isiPesan = str_replace("{{".$attributes."}}",$value,$isiPesan);
                        }
                        $attributes = $modPasien->getAttributes();
                        foreach($attributes as $attributes => $value){
                            $isiPesan = str_replace("{{".$attributes."}}",$value,$isiPesan);
                        }
						if($modKamarruangan){
							$attributes = $modKamarruangan->getAttributes();
							foreach($attributes as $attributes => $value){
								$isiPesan = str_replace("{{".$attributes."}}",$value,$isiPesan);
							}
						}
                        $attributes = $modRuangan->getAttributes();
                        foreach($attributes as $attributes => $value){
                            $isiPesan = str_replace("{{".$attributes."}}",$value,$isiPesan);
                        }
                        $attributes = $modKelaspelayanan->getAttributes();
                        foreach($attributes as $attributes => $value){
                            $isiPesan = str_replace("{{".$attributes."}}",$value,$isiPesan);
                        }
                       
                        $isiPesan = str_replace("{{hari}}",MyFormatter::getDayName($modRencanaOperasi->tglrencanaoperasi),$isiPesan);
                     
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
//					Yii::app()->user->setFlash('success',"Data berhasil disimpan");
					$this->redirect(array('index','pasienmasukpenunjang_id'=>$modPasienMasukPenunjang->pasienmasukpenunjang_id,'sukses'=>1,'smspasien'=>$smspasien));
				}else{
					$transaction->rollback();
					Yii::app()->user->setFlash('error',"Data gagal disimpan ");
				}
			}
			catch(Exception $exc){
				$transaction->rollback();
				Yii::app()->user->setFlash('error',"Data gagal disimpan ".MyExceptionMessage::getMessage($exc,true));
			}
		}
		
		$modKunjungan->tgl_pendaftaran = $format->formatDateTimeForUser($modKunjungan->tgl_pendaftaran);
        $modKunjungan->tanggal_lahir = $format->formatDateTimeForUser($modKunjungan->tanggal_lahir);
        $modPasienMasukPenunjang->tglmasukpenunjang = $format->formatDateTimeForUser($modPasienMasukPenunjang->tglmasukpenunjang);
		
        $this->render('index',array(
            'modKunjungan'=>$modKunjungan,
            'modPemeriksaanBedah'=>$modPemeriksaanBedah,
            'modPasienMasukPenunjang'=>$modPasienMasukPenunjang,
            'modTindakan'=>$modTindakan,
            
            'dataTindakans'=>$dataTindakans,
			'modRencanaOperasi'=>$modRencanaOperasi
        ));
    }
    
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$modPendaftaran=  BSPendaftaranMp::model()->findByPk($id);
		if($modPendaftaran===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $modPendaftaran;
	}
	
	public function savePasienPenunjang($attrPendaftaran,$penunjang,$modRencana){
		$modPasienPenunjang = new BSPasienmasukpenunjangT;
		if(isset($_GET['pasienmasukpenunjang_id'])){
			$modPasienPenunjang = BSPasienmasukpenunjangT::model()->findByPk($_GET['pasienmasukpenunjang_id']);
		}
		$modPasienPenunjang->attributes = $penunjang;
		$modPasienPenunjang->attributes = $attrPendaftaran->attributes;
		$modPasienPenunjang->pasienkirimkeunitlain_id = $penunjang['pasienkirimkeunitlain_id'];
		$modPasienPenunjang->pasien_id = $attrPendaftaran->pasien_id;
		$modPasienPenunjang->jeniskasuspenyakit_id = $penunjang['jeniskasuspenyakit_id'];
		$modPasienPenunjang->pendaftaran_id = $attrPendaftaran->pendaftaran_id;
		$modPasienPenunjang->pegawai_id = $modRencana->dokterpelaksana1_id;
		$modPasienPenunjang->kelaspelayanan_id = $penunjang['kelaspelayanan_id'];
		$modPasienPenunjang->ruangan_id = $penunjang['ruangan_id'];
		$instalasi_id = $modPasienPenunjang->ruangan->instalasi_id;
		$kode_instalasi = InstalasiM::model()->findByPk($instalasi_id)->instalasi_singkatan;
		$modPasienPenunjang->no_masukpenunjang = MyGenerator::noMasukPenunjang($kode_instalasi);
		$modPasienPenunjang->tglmasukpenunjang = $attrPendaftaran->tgl_pendaftaran;
		$modPasienPenunjang->no_urutperiksa =  MyGenerator::noAntrianPenunjang($modPasienPenunjang->ruangan_id);
		$modPasienPenunjang->kunjungan = $attrPendaftaran->kunjungan;
		$modPasienPenunjang->statusperiksa = $attrPendaftaran->statusperiksa;
		$modPasienPenunjang->ruanganasal_id = $attrPendaftaran->ruangan_id;
		$modPasienPenunjang->create_time=date('Y-m-d H:i:s');
		$modPasienPenunjang->create_loginpemakai_id=Yii::app()->user->id;
		$modPasienPenunjang->create_ruangan=Yii::app()->user->getState('ruangan_id');
		

		if($modPasienPenunjang->validate()){
			if ($modPasienPenunjang->save()){

				$this->pasienpenunjangtersimpan=true;
			} 
		}else{
			$this->pasienpenunjangtersimpan=false;
		}
		return $modPasienPenunjang;
	}
	
	public function saveRencanaOperasi($pendaftaran,$penunjang,$rencanaOperasi,$rencana)
	{
		$modRencana = new BSRencanaOperasiT;
		$modRencana->attributes = $rencanaOperasi->attributes;
		$modRencana->norencanaoperasi = $rencanaOperasi['norencanaoperasi'];
		$modRencana->pasienmasukpenunjang_id = $penunjang->pasienmasukpenunjang_id;
		$modRencana->pendaftaran_id = $pendaftaran->pendaftaran_id;
		$modRencana->pasien_id = $pendaftaran->pasien_id;
		$modRencana->pasienadmisi_id = (!empty($pendaftaran->pasienadmisi_id)) ? $pendaftaran->pasienadmisi_id : null ;
		$modRencana->kamarruangan_id = (!empty($modRencana->kamarruangan_id)) ? $modRencana->kamarruangan_id : null ;
		$modRencana->dokterpelaksana2_id = (!empty($modRencana->dokterpelaksana2_id)) ? $modRencana->dokterpelaksana2_id : null ;
		
		$modRencana->paramedis_id = !empty($modRencana->paramedis_id)?$modRencana->paramedis_id:null;
		$modRencana->suster_id = !empty($modRencana->suster_id)?$modRencana->suster_id:null;
		$modRencana->bidan_id = !empty($modRencana->bidan_id)?$modRencana->bidan_id:null;
		$modRencana->keterangan_rencana = $modRencana->keterangan_rencana;
		
		$modRencana->dokteranastesi_id = (!empty($modRencana->dokteranastesi_id)) ? $modRencana->dokteranastesi_id : null ;
		$modRencana->selesaioperasi = $modRencana->tglrencanaoperasi; //sementara di set sama dl, nanti pas proses fix operasi baru di update lg
		$modRencana->mulaioperasi = $modRencana->tglrencanaoperasi; //sementara di set sama dl, nanti pas proses fix operasi baru di update lg
		$modRencana->operasi_id = $rencana['operasi_id'];
		$modRencana->is_cyto = (($rencana['cyto_tindakan'] == 1 ) ? TRUE : FALSE );
		$modRencana->create_time=date('Y-m-d H:i:s');
		$modRencana->create_loginpemakai_id=Yii::app()->user->id;
		$modRencana->create_ruangan=Yii::app()->user->getState('ruangan_id');
		if($modRencana->validate()){ 
			if($modRencana->save()){
				$this->rencanaoperasitersimpan = true;
			}
		}else{ 
			$this->rencanaoperasitersimpan = false;
		}
		
		return $modRencana;
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
            $criteria->order = 'no_pendaftaran, no_rekam_medik, nama_pasien';
            $criteria->limit = 5;
            $models = BSInfokunjunganrjrdriV::model()->findAll($criteria);
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
            $model = BSInfokunjunganrjrdriV::model()->findByAttributes(array('pasienkirimkeunitlain_id'=>$_POST['pasienkirimkeunitlain_id']));
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
         * set checklist pemeriksaan bedah
         */
        public function actionSetChecklistPemeriksaanBedah(){
            if (Yii::app()->request->isAjaxRequest){
                $content = "";
                parse_str($_POST['data'], $post);
                
                $disabled = $_POST['sukses'];
                $postPemeriksaan = $post['BSTarifoperasiruanganV'];
                
                if(!empty($postPemeriksaan['ruangan_id']) && !empty($postPemeriksaan['kelaspelayanan_id']) && !empty($postPemeriksaan['penjamin_id'])){
                    $criteria = new CdbCriteria();
                    $criteria->addCondition('ruangan_id = '.$postPemeriksaan['ruangan_id']);
                    $criteria->addCondition('kelaspelayanan_id = '.$postPemeriksaan['kelaspelayanan_id']);
                    $criteria->addCondition('penjamin_id = '.$postPemeriksaan['penjamin_id']);
                    $criteria->compare('LOWER(kegiatanoperasi_nama)',strtolower($postPemeriksaan['kegiatanoperasi_nama']), true);
                    $criteria->compare('LOWER(operasi_nama)',strtolower($postPemeriksaan['operasi_nama']), true);
                    $criteria->order = "kegiatanoperasi_nama, operasi_nama";
                    $modPemeriksaanBedahs = BSTarifoperasiruanganV::model()->findAll($criteria);
                    $content = $this->renderPartial('_checklistPemeriksaanBedah',array('modPemeriksaanBedahs'=>$modPemeriksaanBedahs,'disabled'=>$disabled), true);
                }
                echo CJSON::encode(array(
                    'content'=>$content));
                Yii::app()->end();
            }
        }
		
	public function actionSetPermintaanKePenunjang(){
        if(Yii::app()->request->isAjaxRequest) {
            $format = new MyFormatter();
            $rows = "";
            $modPermintaans = BSPermintaanKePenunjangT::model()->findAllByAttributes(array('pasienkirimkeunitlain_id'=>$_POST['pasienkirimkeunitlain_id']));
            if(count($modPermintaans) > 0){
                foreach($modPermintaans AS $i => $modPermintaan){
                    $modPemeriksaan = OperasiM::model()->findByAttributes(array('operasi_id'=>$modPermintaan->operasi_id));
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
	
    public function actionSetRencanaTindakanOperasi(){
        if(Yii::app()->request->isAjaxRequest) {
            $format = new MyFormatter();
            $rows = "";
            $modRencanaOperasis = BSRencanaOperasiT::model()->findAllByAttributes(array('pasienmasukpenunjang_id'=>$_POST['pasienmasukpenunjang_id']));
            if(count($modRencanaOperasis) > 0){
                foreach($modRencanaOperasis AS $i => $modRencanaOperasi){
					$criteria = null;
					$criteria = new CdbCriteria();
					$criteria->addCondition('kelaspelayanan_id = '.$modRencanaOperasi->pasienmasukpenunjang->kelaspelayanan_id);
					$criteria->addCondition('penjamin_id = '.$modRencanaOperasi->pendaftaran->penjamin_id);
					$criteria->addCondition('operasi_id = '.$modRencanaOperasi->operasi_id);
					$modPemeriksaanBedahs = BSTarifoperasiruanganV::model()->find($criteria);
					$modTarifTindakan = BSTariftindakanM::model()->findByAttributes(array('daftartindakan_id'=>$modRencanaOperasi->operasi->daftartindakan_id));
                    $modRencanaOperasi->operasi_id = $modRencanaOperasi->operasi_id;
                    $modRencanaOperasi->daftartindakan_id = $modRencanaOperasi->operasi->daftartindakan_id;
                    $modRencanaOperasi->operasi_nama = $modRencanaOperasi->operasi->operasi_nama;
                    $modRencanaOperasi->jenistarif_id = JenistarifpenjaminM::model()->findByAttributes(array('penjamin_id'=>$modRencanaOperasi->pendaftaran->penjamin_id))->jenistarif_id;
                    $modRencanaOperasi->tarif_satuan = $format->formatNumberForUser(isset($modPemeriksaanBedahs) ? $modPemeriksaanBedahs->hargaoperasi : 0);
                    $modRencanaOperasi->tarif_tindakan = $format->formatNumberForUser(isset($modPemeriksaanBedahs) ? $modPemeriksaanBedahs->hargaoperasi : 0);
                    $modRencanaOperasi->satuantindakan = Params::SATUAN_TINDAKAN_LABORATORIUM;;
                    $modRencanaOperasi->qty_tindakan = 1;
					$modRencanaOperasi->cyto_tindakan = (($modRencanaOperasi->is_cyto == TRUE)? 1 : 0);
					$modRencanaOperasi->persencyto_tind = $modTarifTindakan->persencyto_tind;
					$modRencanaOperasi->tarif_cyto = (($modRencanaOperasi->is_cyto == TRUE)? (isset($modPemeriksaanBedahs) ? $modPemeriksaanBedahs->hargaoperasi + ($modPemeriksaanBedahs->hargaoperasi  * ($modTarifTindakan->persencyto_tind/100)) : 0) : 0);
					$modRencanaOperasi->tarif_cyto = $format->formatNumberForUser($modRencanaOperasi->tarif_cyto);
                    $rows .= $this->renderPartial("_rowTindakanPemeriksaan",array('i'=>0, 'modRencanaOperasi'=>$modRencanaOperasi), true);
                }
            }
            echo CJSON::encode(array(
                    'rows'=>$rows));
        }
        Yii::app()->end();
    }
    
}
