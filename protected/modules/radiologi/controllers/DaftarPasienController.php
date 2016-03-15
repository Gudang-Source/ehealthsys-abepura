<?php

class DaftarPasienController extends MyAuthController
{
        public $successPengambilanSample = false;
        public $successKirimSample = false;
        public $path_view = 'laboratorium.views.daftarPasien.';
        
	public function actionIndex()
	{
                $modPasienMasukPenunjang = new ROPasienMasukPenunjangV;
                $format = new MyFormatter();
//                $modPasienMasukPenunjang->tgl_awal = date('d M Y').' 00:00:00';
                $modPasienMasukPenunjang->tgl_awal = date('d M Y', strtotime('-5 days')).' 00:00:00';
                $modPasienMasukPenunjang->tgl_akhir = date('d M Y H:i:s');
                if(isset($_GET['ROPasienMasukPenunjangV'])){
                    $modPasienMasukPenunjang->attributes = $_GET['ROPasienMasukPenunjangV'];
                    $modPasienMasukPenunjang->tgl_awal = $format->formatDateTimeForDb($_GET['ROPasienMasukPenunjangV']['tgl_awal']);
                    $modPasienMasukPenunjang->tgl_akhir = $format->formatDateTimeForDb($_GET['ROPasienMasukPenunjangV']['tgl_akhir']);
                }
		$this->render('index',array('modPasienMasukPenunjang'=>$modPasienMasukPenunjang));
	}
              
        
        public function actionHasilPemeriksaan($pendaftaran_id,$pasien_id,$pasienmasukpenunjang_id)
        {            
            $modPasienMasukPenunjang = ROPasienMasukPenunjangV::model()->findByAttributes(
                array(
                    'pasienmasukpenunjang_id'=>$pasienmasukpenunjang_id
                )
            );
            $modPendaftaran = ROPendaftaranMp::model()->findByPk($pendaftaran_id);
            $modRujukan = RORujukanT::model()->findByPk($modPendaftaran->rujukan_id);
            $modPasienMorbiditas = new ROPasienmorbiditasT();
            $modAnamnesa = array();
            $modPemeriksaan = array();
            if(!empty($pendaftaran_id)){
                $pendaftaran_id = $pendaftaran_id;
                $anamnesa = ROAnamnesaT::model()->find('pendaftaran_id = '.$pendaftaran_id);
                if(count($anamnesa) > 0){
                    $modAnamnesa= $anamnesa;
                }else{
                    $modAnamnesa= new ROAnamnesaT();
                    $modAnamnesa->pendaftaran_id = $pendaftaran_id;
                }
                $modAnamnesa->pendaftaran_id = $modAnamnesa->pendaftaran_id;

                $periksafisik = ROPemeriksaanfisikT::model()->find('pendaftaran_id = '.$pendaftaran_id);
                if(count($periksafisik) > 0){
                    $modPemeriksaan = $periksafisik;
                }else{
                    $modPemeriksaan= new ROPemeriksaanfisikT;
                    $modPemeriksaan->pendaftaran_id = $pendaftaran_id;
                }
            }
            if(isset($_POST['RORujukanT']))
            { // Update Dokter Perujuk pada RujukanT
                $modRujukan->rujukandari_id = $_POST['RORujukanT']['rujukandari_id'];
                $modRujukanDari = RujukandariM::model()->findByPk($modRujukan->rujukandari_id);
                $modRujukan->nama_perujuk = $modRujukanDari->namaperujuk;
                $modRujukan->update();
            }
            
            if(isset($_POST['ROHasilpemeriksaanradT']))
            {
                $transaction = Yii::app()->db->beginTransaction();
                try {
                    $this->saveHasilPemeriksaan($_POST['ROHasilpemeriksaanradT']);
                
                    //Update dokter pemeriksa (pegawai_id) pada pasien masuk penunjang
                    ROPasienmasukpenunjangT::model()->updateByPk(
                        $pasienmasukpenunjang_id,
                        array(
                            'pegawai_id'=>$_POST['ROPasienmasukpenunjangT']['pegawai_id']
                        )
                    );

                    $transaction->commit();
                    Yii::app()->user->setFlash('success',"Data berhasil Disimpan");
                    $this->redirect(array('index'));
//                    $this->redirect($this->createUrl("/radiologi/lihatHasil/HasilPeriksa", array('pendaftaran_id'=>$pendaftaran_id,'pasien_id'=>$pasien_id,'pasienmasukpenunjang_id'=>$pasienmasukpenunjang_id,'caraPrint'=>'PRINT')));
                } catch(Exception $exc) {
                    $transaction->rollback();
                    Yii::app()->user->setFlash('error',"Data gagal disimpan ".MyExceptionMessage::getMessage($exc,true));
                }
            }
            
            $modHasilpemeriksaanRad = ROHasilpemeriksaanradT::model()->with('pemeriksaanrad')->findAllByAttributes(
                array(
                    'pendaftaran_id'=>$pendaftaran_id,
                    'pasienmasukpenunjang_id'=>$pasienmasukpenunjang_id,
                    'pasien_id'=>$pasien_id,
                )
            );
            
            
            if(empty($modHasilpemeriksaanRad))
            {
                $this->redirect(
                    $this->createUrl('/radiologi/pemeriksaanPasienRadiologi/index',
                        array(
                            'pasienmasukpenunjang_id'=>$pasienmasukpenunjang_id
                        )
                    )
                );
            }
            $this->render('hasilPemeriksaan',
                array(
                    'modHasilpemeriksaanRad'=>$modHasilpemeriksaanRad,
                    'modPasienMasukPenunjang'=>$modPasienMasukPenunjang,
                    'modPendaftaran'=>$modPendaftaran,
                    'modRujukan'=>$modRujukan,
                    'modAnamnesa'=>$modAnamnesa,
                    'modPemeriksaan'=>$modPemeriksaan,
                    'modPasienMorbiditas'=>$modPasienMorbiditas
                )
            );

        }
        
        public function actionGetReferensiHasilRad()
        {
            if (Yii::app()->request->isAjaxRequest)
            {
				$data = array();
                $idPemeriksaanRad = $_POST['idPemeriksaanRad'];
                $modReferensi = ReferensihasilradM::model()->findByAttributes(array('pemeriksaanrad_id'=>$idPemeriksaanRad));
                if($modReferensi){
					$attributeRef = $modReferensi->attributeNames();
					foreach ($attributeRef as $attribute){
						$data[$attribute] = $modReferensi->$attribute;
					}
				}
                echo CJSON::encode($data);
                Yii::app()->end();               
            }
        }
	
        protected function saveHasilPemeriksaan($arrHasil)
        {
            $format = new MyFormatter();
            $tglpegambilanhasilrad = $format->formatDateTimeForDb($arrHasil[0]['tglpegambilanhasilrad']);
            if(trim($tglpegambilanhasilrad)=='') $tglpegambilanhasilrad = null;
            
            foreach($arrHasil as $i => $hasil) {
                ROHasilpemeriksaanradT::model()->updateByPk($hasil['hasilpemeriksaanrad_id'], 
                                                            array('hasilexpertise'=>$hasil['hasilexpertise'],
                                                                  'kesan_hasilrad'=>$hasil['kesan_hasilrad'],
                                                                  'kesimpulan_hasilrad'=>$hasil['kesimpulan_hasilrad'],
                                                                  'tglpegambilanhasilrad'=>$tglpegambilanhasilrad,));
            }
        }
        
        public function actionUbahPasien($id)
	{
                Yii::import('application.modules.laboratorium.models.ROPasienM');
                //if(!Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
                $model = ROPasienM::model()->findByPk($id);
                $format = new MyFormatter();
                $temLogo=$model->photopasien;
                $model->update_time = date ('Y-m-d');
                $model->update_loginpemakai_id = Yii::app()->user->id;
                $model->tgl_rekam_medik = $format->formatDateTimeForUser($model->tgl_rekam_medik);
                if(isset($_POST['ROPasienM'])) {                   
                    $random=rand(0000000,9999999);
                    $model->attributes = $_POST['ROPasienM'];
                    $model->tanggal_lahir = $format->formatDateTimeForDb($model->tanggal_lahir);
                    $model->kelompokumur_id = CustomFunction::getKelompokUmur($model->tanggal_lahir);
                    $model->photopasien = CUploadedFile::getInstance($model, 'photopasien');
                    $gambar=$model->photopasien;
                    $model->tgl_rekam_medik  = $format->formatDateTimeForDb($model->tgl_rekam_medik);
                    
                    if(!empty($model->photopasien)) { //if user input the photo of patient
                        $model->photopasien =$random.$model->photopasien;

                         Yii::import("ext.EPhpThumb.EPhpThumb");

                         $thumb=new EPhpThumb();
                         $thumb->init(); //this is needed

                         $fullImgName =$model->photopasien;   
                         $fullImgSource = Params::pathPasienDirectory().$fullImgName;
                         $fullThumbSource = Params::pathPasienTumbsDirectory().'kecil_'.$fullImgName;

                         if($model->save()) {
                            if(!empty($temLogo)) { 
                               if(file_exists(Params::pathPasienDirectory().$temLogo))
                                    unlink(Params::pathPasienDirectory().$temLogo);
                               if(file_exists(Params::pathPasienTumbsDirectory().'kecil_'.$temLogo))
                                    unlink(Params::pathPasienTumbsDirectory().'kecil_'.$temLogo);
                            }
                            $gambar->saveAs($fullImgSource);
                            $thumb->create($fullImgSource)
                                 ->resize(200,200)
                                 ->save($fullThumbSource);

                            Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
                          } else {
                               Yii::app()->user->setFlash('error', 'Data <strong>Gagal!</strong>  disimpan.');
                          }
                    } else { //if user not input the photo
                       $model->photopasien=$temLogo;
                       if($model->save()) {
                            Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
                       }
                    }

                }
		$this->render($this->path_view.'ubahPasien',array('model'=>$model));
	}
        
        public function actionBatalPemeriksaan() {
                $idKirimUnit = null;
                $keterangan = "";
                $nama_pasien = "";
                
		if (Yii::app()->request->isAjaxRequest) {
			$transaction = Yii::app()->db->beginTransaction();
			$pesan = 'success';
			$status = 'ok';
                        $ok = true;
                        try {
                            $id = $_POST['pendaftaran_id'];
                            $idPenunjang = $_POST['idPenunjang'];
                            
                            $pendaftaran = PendaftaranT::model()->findByPk($id);
                            $penunjang = PasienmasukpenunjangT::model()->findByPk($idPenunjang);
                            $nama_pasien = $pendaftaran->pasien->nama_pasien;
                            
                            // periksa tindakan
                            $criteria = new CDbCriteria();
                            $criteria->select = "count(tindakanpelayanan_id) as tindakanpelayanan_id";
                            $criteria->addCondition("pasienmasukpenunjang_id = ".$idPenunjang." and tindakansudahbayar_id is not null");
                            $tindakan = TindakanpelayananT::model()->find($criteria);
                            
                            if ($tindakan->tindakanpelayanan_id > 0) {
                                $pesan = 'exist';
				$keterangan = "<div class='flash-success'>Pasien <b> " . $pendaftaran->pasien->nama_pasien . " 
                                </b> sudah melakukan pembayaran pemeriksaan </div>";
                                $ok = false;
                            } else {
                                $ok = $ok && TindakanpelayananT::model()->updateAll(array(
                                    'detailhasilpemeriksaanlab_id'=>null,
                                    'hasilpemeriksaanrm_id'=>null,
                                    'hasilpemeriksaanrad_id'=>null,
                                    'hasilpemeriksaanpa_id'=>null,
                                ), 'pasienmasukpenunjang_id = '.$idPenunjang);
                                $ok = $ok && TindakanpelayananT::model()->deleteAllByAttributes(array(
                                    'pasienmasukpenunjang_id' => $idPenunjang,
                                ));
                                // $ok = $ok && PasienmasukpenunjangT::model()->deleteByPk();
                            }
                            
                            //var_dump($ok);
                            
                            // simpan batal periksa penunjang
                            $model = new PasienbatalperiksaR();
                            $model->pendaftaran_id = $id;
                            $model->pasien_id = $pendaftaran->pasien_id;
                            $model->pasienmasukpenunjang_id = $penunjang->pasienmasukpenunjang_id;
                            $model->pasienkirimkeunitlain_id = $penunjang->pasienkirimkeunitlain_id;
                            $model->tglbatal = date('Y-m-d');
                            $model->keterangan_batal = "Batal Laboratorium";
                            $model->create_time = date('Y-m-d H:i:s');
                            $model->update_time = null;
                            $model->create_loginpemakai_id = Yii::app()->user->id;
                            $model->create_ruangan = Yii::app()->user->getState('ruangan_id');

                            if ($model->validate()) {
                                $ok = $ok && $model->save();
                            } else $ok = false;
                            
                            //var_dump($ok);
                            
                            if (empty($penunjang->pasienkirimkeunitlain_id)) {
                                $attributes = array(
                                    'statusperiksa' => 'BATAL PERIKSA',
                                    'pasienbatalperiksa_id' => $model->pasienbatalperiksa_id,
                                    'update_time' => date('Y-m-d H:i:s'),
                                    'update_loginpemakai_id' => Yii::app()->user->id
				);
                                $ok = $ok && PendaftaranT::model()->updateByPk($id, $attributes);
                            } else {
                                $attributes = array(
                                    'statusperiksa' => 'BATAL PERIKSA',
                                    'update_time' => date('Y-m-d H:i:s'),
                                    'update_loginpemakai_id' => Yii::app()->user->id
                                );
                                $this->notifPasienBatalPemeriksaan($penunjang);
                                $ok = $ok && PasienmasukpenunjangT::model()->updateByPk($idPenunjang, $attributes);
                            }
                            
                            $oa = ObatalkespasienT::model()->findAllByAttributes(array(
                                'pasienmasukpenunjang_id'=>$idPenunjang,
                            ));
                            foreach ($oa as $item) {
                                $ok = $ok && StokobatalkesT::model()->deleteAllByAttributes(array(
                                    'obatalkespasien_id'=>$item->obatalkespasien_id,
                                ));
                                $ok = $ok && ObatalkespasienT::model()->deleteByPk($item->obatalkespasien_id);
                            }
                            
                            //var_dump($ok);die;
                            if ($ok) {
                                $transaction->commit();
                            } else {
                                $transaction->rollback();
                            }
                            
                        } catch (Exception $ex) {
                            print_r($ex);
                            $status = 'not';
                            $transaction->rollback();
                        }
                        
                        $data['pesan'] = $pesan;
			$data['status'] = $status;
			$data['keterangan'] = $keterangan;
			//$data['smspasien'] = $smspasien;
			$data['nama_pasien'] = $nama_pasien;
                        
                        echo json_encode($data);
                        
			Yii::app()->end();
		}
        }
        
        public function notifPasienBatalPemeriksaan($pasienMasukPenunjang) {
            // var_dump($pasienMasukPenunjang->attributes); die;
            
            if (!empty($pasienMasukPenunjang->pasienkirimkeunitlain_id)) {
                $ki = PasienkirimkeunitlainT::model()->findByPk($pasienMasukPenunjang->pasienkirimkeunitlain_id);
                $modRuangan = RuanganM::model()->findByPk($ki->create_ruangan);
            } else {
                $modRuangan = RuanganM::model()->findByPk(Params::RUANGAN_ID_LOKET);
            }
            
            // var_dump($modRuangan->attributes); die;
            
            //$modRuangan = RuanganM::model()->findByPk($modKirimKeunitlain->create_ruangan);
            $pasien_id = $pasienMasukPenunjang->pasien_id;
            $modPasien = PasienM::model()->findByPk($pasien_id);
            $judul = 'Pasien Batal Pemeriksaan Laboratorium';

            $isi = $modPasien->no_rekam_medik.' - '.$modPasien->nama_pasien;
            
            //var_dump($judul." , ".$isi);
            
            $ok = CustomFunction::broadcastNotif($judul, $isi, array(
                array('instalasi_id'=>$modRuangan->instalasi_id, 'ruangan_id'=>$modRuangan->ruangan_id, 'modul_id'=>$modRuangan->modul_id),
            )); 
        }

    protected function hapusTindakanDanOa($pasienMasukPenunjang, &$status, &$pesan) {
        $ok = true;
        $isbayar = false;
        $tindakan = TindakanpelayananT::model()->findAllByAttributes(array(
            'pasienmasukpenunjang_id'=>$pasienMasukPenunjang->pasienmasukpenunjang_id
        ));
        $hasilpemeriksaan = HasilpemeriksaanradT::model()->findAllByAttributes(array(
            'pasienmasukpenunjang_id'=>$pasienMasukPenunjang->pasienmasukpenunjang_id
        ));
        
        $oa = ObatalkespasienT::model()->findAllByAttributes(array(
            'pasienmasukpenunjang_id'=>$pasienMasukPenunjang->pasienmasukpenunjang_id,
        ));
        
        
        foreach ($tindakan as $item) {
            if (!empty($item->tindakansudahbayar_id)) {
                $isbayar = true;
                break;
            }
        }
        
        if (!$isbayar) {
            foreach ($tindakan as $item) {
                $ok = $ok && TindakanpelayananT::model()->updateByPk($item->tindakanpelayanan_id, array(
                    'hasilpemeriksaanrad_id'=>null,
                ));
            }
            
            foreach ($hasilpemeriksaan as $item) {
                $ok = $ok && HasilpemeriksaanradT::model()->deleteByPk($item->hasilpemeriksaanrad_id);
            }
            
            foreach ($tindakan as $item) {
                $ok = $ok && TindakankomponenT::model()->deleteAllByAttributes(array(
                    'tindakanpelayanan_id'=>$item->tindakanpelayanan_id,
                ));
                $ok = $ok && TindakanpelayananT::model()->deleteByPk($item->tindakanpelayanan_id);
            }
            
            // farmasi
            foreach ($oa as $item) {
                $ok = $ok && StokobatalkesT::model()->deleteAllByAttributes(array(
                    'obatalkespasien_id'=>$item->obatalkespasien_id
                ));
                $ok = $ok && ObatalkespasienT::model()->deleteByPk($item->obatalkespasien_id);
            }
            
            if ($ok) {
                $status = "ok";
            } else {
                $pesan = "exist";
            }
            
        } else {
            $ok = false;
            $status = "exist";
            $pesan = "exist";
        }
    }


    /**
     * action ketika tombol panggil di klik
     */
    public function actionPanggil(){
        if(Yii::app()->request->isAjaxRequest)
        {
            $format = new MyFormatter();
            $data = array();
            $data['pesan']="";
            $pasienmasukpenunjang_id = ($_POST['pasienmasukpenunjang_id']);
            $keterangan = (isset($_POST['keterangan']) ? $_POST['keterangan'] : null);
            $pasienMasukPenunjang =  PasienmasukpenunjangT::model()->findByPk($pasienmasukpenunjang_id);

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
            $data['smspasien'] = 1;
            $data['nama_pasien'] = '';

            if(isset($pasienMasukPenunjang)){
                if($pasienMasukPenunjang->panggilantrian == true){
                    if($keterangan == "batal"){
                        $pasienMasukPenunjang->panggilantrian = false;
                        if($pasienMasukPenunjang->update()){
                            // SMS GATEWAY
                            $modPasien = $pasienMasukPenunjang->pasien;
                            $sms = new Sms();
                            $smspasien = 1;
                            foreach ($modSmsgateway as $i => $smsgateway) {
                                $isiPesan = $smsgateway->templatesms;

                                $attributes = $modPasien->getAttributes();
                                foreach($attributes as $attributes => $value){
                                    $isiPesan = str_replace("{{".$attributes."}}",$value,$isiPesan);
                                }
                                $attributes = $pasienMasukPenunjang->getAttributes();
                                foreach($attributes as $attributes => $value){
                                    $isiPesan = str_replace("{{".$attributes."}}",$value,$isiPesan);
                                }
        
                                if($smsgateway->tujuansms == Params::TUJUANSMS_PASIEN && $smsgateway->statussms){
                                    if(!empty($modPasien->no_mobile_pasien)){
                                        $sms->kirim($modPasien->no_mobile_pasien,$isiPesan);
                                    }else{
                                      $smspasien = 0;
                                    }
                                }
                            }
                            // END SMS GATEWAY
                            $data['smspasien'] = $smspasien;
                            $data['nama_pasien'] = $modPasien->nama_pasien;
                            $data['pesan'] = "Pemanggilan no. antrian ".$pasienMasukPenunjang->no_urutperiksa." dibatalkan !";
                        }
                    }else{
                        $data['pesan'] = "No. antrian ".$pasienMasukPenunjang->no_urutperiksa." dipanggil !";
                    }
                }else{
                    $pasienMasukPenunjang->panggilantrian = true;
                    if($pasienMasukPenunjang->update()){
                        $data['pesan'] = "No. antrian ".$pasienMasukPenunjang->no_urutperiksa." dipanggil !";
          // $data_telnet = $pasienMasukPenunjang->ruangan->ruangan_nama.", ".$pasienMasukPenunjang->ruangan->ruangan_singkatan."-".$pasienMasukPenunjang->no_urutperiksa;
//              AKAN DIGANTI MENGGUNAKAN NODE JS
            // self::postTelnet($data_telnet);
                    }
                }
            }

            $attributes = $pasienMasukPenunjang->attributeNames();
            foreach($attributes as $i=>$attribute) {
                $data["$attribute"] = $pasienMasukPenunjang->$attribute;
            }
            echo CJSON::encode($data);
            Yii::app()->end();
        }
        else
            throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
    }

    public function actionGetAntrianTerakhir(){
        if(Yii::app()->request->isAjaxRequest)
        {

            $data['pesan'] = "";
            $criteria=new CDbCriteria;
            $criteria->addCondition('panggilantrian != TRUE');
            $criteria->addCondition('date(tglmasukpenunjang) BETWEEN \''.date('d M Y').'\' AND \''.date('d M Y').'\'');
            $criteria->order = 'no_urutperiksa ASC';

            $model = ROPasienMasukPenunjangV::model()->find($criteria);
            if(count($model)>0){
              $data['pasienmasukpenunjang_id'] = $model->pasienmasukpenunjang_id;
              $data['ruangan_singkatan'] = $model->ruangan_singkatan;
              $data['no_urutperiksa'] = $model->no_urutperiksa;
              $data['ruangan_id'] = $model->ruangan_id;
            }else{
              $data['pesan'] = "Tidak ada antrian!";
            }
            echo CJSON::encode($data);
            Yii::app()->end();
        }
        else
            throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
    }
}