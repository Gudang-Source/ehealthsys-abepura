<?php

class PemakaianAmbulanPasienRSController extends MyAuthController
{
    protected $obatalkespasientersimpan = true;
    protected $tindakanpelayanantersimpan = true;
    public $path_view = 'ambulans.views.pemakaianAmbulanPasienRS.';    
    public $inisial_modul = '';

    public function actionIndex($pemakaian_id = '', $pendaftaran_id='', $pemesanan_id='')
    {
        $format = new MyFormatter();        
        $modPasien = new PasienM;
        $modKunjungan=new AMInfokunjunganrjV;
        $modObatAlkesPasien = new AMObatalkesPasienT;
        $modPemakaian = new AMPemakaianambulansT;
        $modPemakaian->inisial_modul = $this->inisial_modul;
        $modPemakaian->tglpemakaianambulans = date('Y-m-d H:i:s');
        $modInstalasi = InstalasiM::model()->findAllByAttributes(array('instalasi_aktif'=>true),array('order'=>'instalasi_nama'));
        $instalasi = Yii::app()->user->getState('instalasi_id');
        $modPemakaian->ruangan_id = Yii::app()->user->getState('ruangan_id');
//        $instalasi = '';
        $tarif = array();
        $tarif['tarifAmbulans'][] = null;

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

        
        if(!empty($pemesanan_id)){
            $modPemakaian = $this->setDataPemakaianFromPemesanan($pemesanan_id);
            $instalasi = RuanganM::model()->findByPk($modPemakaian->ruangan_id)->instalasi_id;
        }

        if(!empty($pendaftaran_id)){
            $modKunjungan->pendaftaran_id = $pendaftaran_id;
            if(isset($_GET['instalasi_id'])){
                $modKunjungan->instalasi_id = $_GET['instalasi_id'];
            }
            $modPemakaian = $this->setDataPemakaianFromPendaftaran($pendaftaran_id);
                if(!empty($modPemakaian->ruangan_id)){
                    $instalasi = RuanganM::model()->findByPk($modPemakaian->ruangan_id)->instalasi_id;
                }else{
                    $instalasi = null;
                }
        }
        
        if(!empty($pemakaian_id)){
            $modPemakaian = $this->setDataPemakaianFromPemakaian($pemakaian_id);
            $instalasi = RuanganM::model()->findByPk($modPemakaian->ruangan_id)->instalasi_id;            
            $modPemakaian->paramedis1_nama = isset($modPemakaian->paramedis1_id) ? $modPemakaian->paramedis1->NamaLengkap : "";
            $modPemakaian->paramedis2_nama = isset($modPemakaian->paramedis2_id) ? $modPemakaian->paramedis2->NamaLengkap : "";
        }

        if(isset($_POST['AMPemakaianambulansT'])){
            if(isset($_POST['tarif'])){
                $transaction = Yii::app()->db->beginTransaction();
                try {
                    foreach($_POST['tarif']['tarifAmbulans'] as $i=>$tarifAmbulans){
                        $tarif['tarifAmbulans'][$i] = $tarifAmbulans;
                        $tarif['tarifKM'][$i] = $_POST['tarif']['tarifKM'][$i];
                        $tarif['jmlKM'][$i] = $_POST['tarif']['jmlKM'][$i];
                        $tarif['kelurahan'][$i] = $_POST['tarif']['kelurahan'][$i];
                        $tarif['kecamatan'][$i] = $_POST['tarif']['kecamatan'][$i];
                        $tarif['kabupaten'][$i] = $_POST['tarif']['kabupaten'][$i];
                        $tarif['propinsi'][$i] = $_POST['tarif']['propinsi'][$i];
                        $tarif['daftartindakanId'][$i] = $_POST['tarif']['daftartindakanId'][$i];
                        //=== set attribute pemakaian ambulans ===//
                        $save = true;
                        $modPemakaian = new AMPemakaianambulansT;
                        $modPemakaian->attributes = $_POST['AMPemakaianambulansT'];
                        $modPemakaian->rt_rw = $_POST['AMPemakaianambulansT']['rt'].'/'.$_POST['AMPemakaianambulansT']['rw'];
                        $modPemakaian->tarifperkm = $tarif['tarifKM'][$i];
                        $modPemakaian->jumlahkm = $tarif['jmlKM'][$i];
                        $modPemakaian->totaltarifambulans = $tarif['tarifAmbulans'][$i];
                        $modPemakaian->daftartindakanId = $tarif['daftartindakanId'][$i];
                        $modPemakaian->create_time = date('Y-m-d H:i:s');
                        $modPemakaian->create_loginpemakai_id = Yii::app()->user->id;
                        $modPemakaian->create_ruangan = Yii::app()->user->getState('ruangan_id');
                        $modPemakaian->noidentitas = Yii::app()->user->getState('ruangan_id');
                        $instalasi = $_POST['instalasi'];
                        $format = new MyFormatter();
                        $modPemakaian->tglpemakaianambulans = $format->formatDateTimeForDb($_POST['AMPemakaianambulansT']['tglpemakaianambulans']);
                        $modPemakaian->tglkembaliambulans = $format->formatDateTimeForDb($_POST['AMPemakaianambulansT']['tglkembaliambulans']);

                        //=== save pemakaian ambulans ===//
                        if($modPemakaian->validate()){
                            $save = $save && $modPemakaian->save();
                            if(!empty($modPemakaian->pendaftaran_id) && $save){
                                $modPendaftaran = PendaftaranT::model()->findByPk($modPemakaian->pendaftaran_id);
                                $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
                                $tindakanPel = $this->saveTindakanPelayanan($modPasien, $modPendaftaran, $modPemakaian);
                            }
                            if(!empty($pemesanan_id)){
                                AMPesanambulansT::model()->updateByPk($pemesanan_id, array('pemakaianambulans_id'=>$modPemakaian->pemakaianambulans_id));
                            }
                        } else {
                            $save = false;
                        }
                    }
                    //=== simpan pemakaian obat alkes ===//
                    if(!empty($modPemakaian->pendaftaran_id)){
                        $modPendaftaran = PendaftaranT::model()->findByPk($modPemakaian->pendaftaran_id);
                        $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
                        if(isset($_POST['AMObatalkesPasienT'])){
                            if(count($_POST['AMObatalkesPasienT']) > 0){
                                foreach($_POST['AMObatalkesPasienT'] AS $ii => $postOa){
                                    $dataOas[$ii] = $this->simpanObatAlkesPasien($modPendaftaran,$postOa);
                                }
                            }
                        }                        
                    }                   
                    //=== commit or rollback ===//
                    if($save && $this->obatalkespasientersimpan && $this->tindakanpelayanantersimpan){
                        // SMS GATEWAY
                        $sms = new Sms();
                        $smspasien = 1;
                        foreach ($modSmsgateway as $i => $smsgateway) {
                            $isiPesan = $smsgateway->templatesms;
                            $attributes = $modPemakaian->getAttributes();
                            foreach($attributes as $attributes => $value){
                                $isiPesan = str_replace("{{".$attributes."}}",$value,$isiPesan);
                            }
                            $attributes = $modPemakaian->getAttributes();
                            foreach($attributes as $attributes => $value){
                                $isiPesan = str_replace("{{".$attributes."}}",$value,$isiPesan);
                            }
                            $isiPesan = str_replace("{{hari}}",MyFormatter::getDayName($modPemakaian->tglpemakaianambulans),$isiPesan);
                            $isiPesan = str_replace("{{nama_rumahsakit}}",Yii::app()->user->getState('nama_rumahsakit'),$isiPesan);
                            
                            if($smsgateway->tujuansms == Params::TUJUANSMS_PASIEN && $smsgateway->statussms){
                                if(!empty($modPemakaian->nomobile)){
                                    $sms->kirim($modPemakaian->nomobile,$isiPesan);
                                }else{
                                    $smspasien = 0;
                                }
                            }
                            
                        }
                        // END SMS GATEWAY
                        $transaction->commit();
                        Yii::app()->user->setFlash('success',"Data Berhasil disimpan");
                        $sukses = 1;
                        $modPemakaian->isNewRecord = FALSE;
                        $this->redirect(array('index','pemakaian_id'=>$modPemakaian->pemakaianambulans_id,'pendaftaran_id'=>$modPemakaian->pendaftaran_id,'sukses'=>$sukses, 'smspasien'=>$smspasien));
                    } else {
                        $transaction->rollback();
                        Yii::app()->user->setFlash('error',"Data Gagal disimpan");
                    }
                } catch (Exception $exc) {
                    $transaction->rollback();
                    Yii::app()->user->setFlash('error',"Data Gagal disimpan. ".MyExceptionMessage::getMessage($exc,true));
                }
            }else{
               Yii::app()->user->setFlash('error',"Pilih terlebih dahulu tarif ambulans !"); 
            }
        }

		$modPropinsi = PropinsiM::model()->findByPk(Yii::app()->user->getState('propinsi_id'));
		$latitude = $modPropinsi->latitude;
		$longitude = $modPropinsi->longitude;
		
        $this->render($this->path_view.'index',array('modPemakaian'=>$modPemakaian,
                                        'modPasien'=>$modPasien,
                                        'modInstalasi'=>$modInstalasi,
                                        'instalasi'=>$instalasi,
                                        'tarif'=>$tarif,
                                        'modKunjungan'=>$modKunjungan,
                                        'format'=>$format,
                                        'modObatAlkesPasien'=>$modObatAlkesPasien,
										'latitude'=>$latitude,
										'longitude'=>$longitude));
    }
    
    /**
     * Mengurai data kunjungan berdasarkan:
     * - instalasi_id
     * - pendaftaran_id
     * - pasienadmisi_id
     * - no_pendaftaran
     * - no_rekam_medik
     * @throws CHttpException
     */
    public function actionGetDataKunjungan()
    {
        if(Yii::app()->request->isAjaxRequest) {
            $format = new MyFormatter();
            $instalasi_id = isset($_POST['instalasi_id']) ? $_POST['instalasi_id'] : null;
            $pendaftaran_id = isset($_POST['pendaftaran_id']) ? $_POST['pendaftaran_id'] : null;
            $pasienadmisi_id = isset($_POST['pasienadmisi_id']) ? $_POST['pasienadmisi_id'] : null;
            $no_pendaftaran = isset($_POST['no_pendaftaran']) ? $_POST['no_pendaftaran'] : null;
            $no_rekam_medik = isset($_POST['no_rekam_medik']) ? $_POST['no_rekam_medik'] : null;
            $returnVal = array();
            $criteria = new CDbCriteria();
            $criteria->compare('pendaftaran_id',$pendaftaran_id);
            $criteria->compare('pasienadmisi_id',$pasienadmisi_id);
            $criteria->compare('instalasi_id',$instalasi_id);
            $criteria->compare('LOWER(no_pendaftaran)',strtolower(trim($no_pendaftaran)));
            $criteria->compare('LOWER(no_rekam_medik)',strtolower(trim($no_rekam_medik)));
            $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
            if(!empty($modPendaftaran)){
                $instalasi_id = $modPendaftaran->instalasi_id;
            }
            if($instalasi_id == Params::INSTALASI_ID_RJ){
                $model = AMInfokunjunganrjV::model()->find($criteria);
            }else if($instalasi_id == Params::INSTALASI_ID_RD){
                $model = AMInfoKunjunganRDV::model()->find($criteria);
            }else if($instalasi_id == Params::INSTALASI_ID_RI){
                $model = AMPasienrawatinapV::model()->find($criteria);
            }else{
                $model = AMPasienpulangrddanriV::model()->findByAttributes(array('pendaftaran_id'=>$pendaftaran_id));
            }
            
            $attributes = $model->attributeNames();
            foreach($attributes as $j=>$attribute) {
                $returnVal["$attribute"] = $model->$attribute;
            }
            $returnVal["tanggal_lahir"] = $format->formatDateTimeForUser($model->tanggal_lahir);
            $returnVal["tgl_pendaftaran"] = $format->formatDateTimeForUser($model->tgl_pendaftaran);            
            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
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
            $instalasi_id = isset($_GET['instalasi_id']) ? $_GET['instalasi_id'] : null;
            $no_pendaftaran = isset($_GET['no_pendaftaran']) ? $_GET['no_pendaftaran'] : null;
            $no_rekam_medik = isset($_GET['no_rekam_medik']) ? $_GET['no_rekam_medik'] : null;
            $nama_pasien = isset($_GET['nama_pasien']) ? $_GET['nama_pasien'] : null;
            $criteria = new CDbCriteria();
            $criteria->compare('LOWER(no_pendaftaran)', strtolower($no_pendaftaran), true);
            $criteria->compare('LOWER(no_rekam_medik)', strtolower($no_rekam_medik), true);
            $criteria->compare('LOWER(nama_pasien)', strtolower($nama_pasien), true);
            $criteria->order = 'no_pendaftaran, no_rekam_medik, nama_pasien';
            $criteria->limit = 5;
            if($instalasi_id == Params::INSTALASI_ID_RJ){
                $models = AMInfokunjunganrjV::model()->findAll($criteria);
            }else if($instalasi_id == Params::INSTALASI_ID_RD){
                $models = AMInfoKunjunganRDV::model()->findAll($criteria);
            }else if($instalasi_id == Params::INSTALASI_ID_RI){
                $models = AMPasienrawatinapV::model()->findAll($criteria);
            }
            foreach($models as $i=>$model)
            {
                $attributes = $model->attributeNames();
                foreach($attributes as $j=>$attribute) {
                    $returnVal[$i]["$attribute"] = $model->$attribute;
                }
                $returnVal[$i]['label'] = $model->no_pendaftaran.' - '.$model->no_rekam_medik.' - '.$model->nama_pasien.(!empty($model->nama_bin) ? "(".$model->nama_bin.")" : "");
                $returnVal[$i]['value'] = $model->no_pendaftaran;
            }

            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }
    
    protected function setDataPemakaianFromPendaftaran($pendaftaran_id)
        {
            $format = new MyFormatter();
            $modPemakaian = new AMPemakaianambulansT;
            $modPemakaian->tglpemakaianambulans = date('Y-m-d H:i:s');
            $modPendaftaran = PendaftaranT::model()->with('pasien')->findByPk($pendaftaran_id);            
            $modPemakaian->pasien_id = (isset($modPendaftaran->pasien_id)?$modPendaftaran->pasien_id:"");
            $modPemakaian->namapasien = (isset($modPendaftaran->pasien_id)?$modPendaftaran->pasien->nama_pasien:"");
            $modPemakaian->nomobile = (isset($modPendaftaran->pasien_id)?$modPendaftaran->pasien->no_mobile_pasien:"");
            $modPemakaian->notelepon = (isset($modPendaftaran->pasien_id)?$modPendaftaran->pasien->no_telepon_pasien:"");
            $modPemakaian->norekammedis = (isset($modPendaftaran->pasien_id)?$modPendaftaran->pasien->no_rekam_medik:"");
            $modPemakaian->noidentitas = (isset($modPendaftaran->pasien_id)?$modPendaftaran->pasien->no_identitas_pasien:"");
            $modPemakaian->tempattujuan = '';
            $modPemakaian->alamattujuan = (isset($modPendaftaran->pasien_id)?$modPendaftaran->pasien->alamat_pasien:"");
            $modPemakaian->kelurahan_nama = (isset($modPendaftaran->pasien->kelurahan->kelurahan_nama) ? $modPendaftaran->pasien->kelurahan->kelurahan_nama : "");
            $modPemakaian->rt_rw = (isset($modPendaftaran->pasien_id)?$modPendaftaran->pasien->rt:"").'/'.(isset($modPendaftaran->pasien_id)?$modPendaftaran->pasien->rw:"");
            $modPemakaian->rt = (isset($modPendaftaran->pasien_id)?$modPendaftaran->pasien->rt:"");
            $modPemakaian->rw = (isset($modPendaftaran->pasien_id)?$modPendaftaran->pasien->rw:"");
            $modPemakaian->tglpemakaianambulans = $format->formatDateTimeForDb($modPemakaian->tglpemakaianambulans);
            $modPemakaian->pesanambulans_t = null;
            $modPemakaian->pendaftaran_id = $pendaftaran_id;
            $modPemakaian->ruangan_id = (isset($modPendaftaran->ruangan_id)?$modPendaftaran->ruangan_id:"");
            
            return $modPemakaian;
        }
        
        protected function setDataPemakaianFromPemesanan($pemesanan_id)
        {
            $format = new MyFormatter();
            $modPemakaian = new AMPemakaianambulansT;
            $modPemesanan = AMPesanambulansT::model()->findByPk($pemesanan_id);
            $modPemakaian->tglpemakaianambulans = date('Y-m-d H:i:s');
            $modPasien = PasienM::model()->findByPk($modPemesanan->pasien_id);
            if(isset($modPasien)){
                $noidentitas = $modPasien->no_identitas_pasien;
            }else{
                $noidentitas = null;
            }
            $modPemakaian->pasien_id = $modPemesanan->pasien_id;
            $modPemakaian->namapasien = $modPemesanan->namapasien;
            $modPemakaian->nomobile = $modPemesanan->nomobile;
            $modPemakaian->notelepon = $modPemesanan->notelepon;
            $modPemakaian->norekammedis = $modPemesanan->norekammedis;
            $modPemakaian->noidentitas = $noidentitas;
            $modPemakaian->tempattujuan = $modPemesanan->tempattujuan;
            $modPemakaian->alamattujuan = $modPemesanan->alamattujuan;
            $modPemakaian->kelurahan_nama = $modPemesanan->kelurahan_nama;
            $modPemakaian->rt_rw = $modPemesanan->rt_rw;
            $modPemakaian->rt = substr($modPemesanan->rt_rw,0,2);
            $modPemakaian->rw = substr($modPemesanan->rt_rw,2,2);
            $modPemakaian->tglpemakaianambulans = (isset($modPemesanan->tglpemakaianambulans) ? $modPemesanan->tglpemakaianambulans : $format->formatDateTimeForUser($modPemakaian->tglpemakaianambulans));
            $modPemakaian->pesanambulans_t = $pemesanan_id;
            $modPemakaian->pendaftaran_id = $modPemesanan->pendaftaran_id;
            $modPemakaian->ruangan_id = $modPemesanan->ruangan_id;
            
            return $modPemakaian;
        }
        
        protected function setDataPemakaianFromPemakaian($pemakaian_id)
        {
            $format = new MyFormatter();
            $modPemakaian = AMPemakaianambulansT::model()->findByPk($pemakaian_id);
            $modPemakaian->tglpemakaianambulans = date('Y-m-d H:i:s');
            $modPasien = PasienM::model()->findByPk($modPemakaian->pasien_id);
            if(isset($modPasien)){
                $noidentitas = $modPasien->no_identitas_pasien;
            }else{
                $noidentitas = $modPemakaian->noidentitas;
            }
            $modPemakaian->pasien_id = $modPemakaian->pasien_id;
            $modPemakaian->namapasien = $modPemakaian->namapasien;
            $modPemakaian->nomobile = $modPemakaian->nomobile;
            $modPemakaian->notelepon = $modPemakaian->notelepon;
            $modPemakaian->norekammedis = $modPemakaian->norekammedis;
            $modPemakaian->noidentitas = $noidentitas;
            $modPemakaian->tempattujuan = $modPemakaian->tempattujuan;
            $modPemakaian->alamattujuan = $modPemakaian->alamattujuan;
            $modPemakaian->kelurahan_nama = $modPemakaian->kelurahan_nama;
            $modPemakaian->rt_rw = $modPemakaian->rt_rw;
            $modPemakaian->rt = substr($modPemakaian->rt_rw,0,2);
            $modPemakaian->rw = substr($modPemakaian->rt_rw,2,2);
            $modPemakaian->tglpemakaianambulans = (isset($modPemakaian->tglpemakaianambulans) ? $modPemakaian->tglpemakaianambulans : $format->formatDateTimeForUser($modPemakaian->tglpemakaianambulans));
            $modPemakaian->pendaftaran_id = $modPemakaian->pendaftaran_id;
            $modPemakaian->ruangan_id = $modPemakaian->ruangan_id;
            $modPemakaian->supir_nama = isset($modPemakaian->supir) ? $modPemakaian->supir->nama_pegawai : "";
            $modPemakaian->paramedis1_nama = isset($modPemakaian->paramedis1) ? $modPemakaian->paramedis1->nama_pegawai : "";
            $modPemakaian->paramedis2_nama = isset($modPemakaian->paramedis2) ? $modPemakaian->paramedis2->nama_pegawai : "";
            $modPemakaian->pelaksana_nama = isset($modPemakaian->pelaksana) ? $modPemakaian->pelaksana->nama_pegawai : "";
            $modPemakaian->mobilambulans_nama = isset($modPemakaian->mobil) ? $modPemakaian->mobil->jeniskendaraan : "";
            
            return $modPemakaian;
        }
        
        /**
        * simpan ObatalkespasienT
        * @param type $modPasienMasukPenunjang
        * @param type $post
        * @return \ObatalkespasienT
        * copy dari : PemakaianBmhpController
        */
        public function simpanObatAlkesPasien($modPendaftaran ,$post){
            $modObatAlkesPasien = new AMObatalkesPasienT;
            $modObatAlkesPasien->attributes = $post;
            $modObatAlkesPasien->tipepaket_id = Params::TIPEPAKET_ID_NONPAKET;
            $modObatAlkesPasien->ruangan_id = Yii::app()->user->getState('ruangan_id');
            $modObatAlkesPasien->pendaftaran_id = $modPendaftaran->pendaftaran_id;
            $modObatAlkesPasien->pasienadmisi_id = $modPendaftaran->pasienadmisi_id;
            $modObatAlkesPasien->carabayar_id = $modPendaftaran->carabayar_id;
            $modObatAlkesPasien->penjamin_id = $modPendaftaran->penjamin_id;
            $modObatAlkesPasien->pegawai_id = $modPendaftaran->pegawai_id;
            $modObatAlkesPasien->shift_id = Yii::app()->user->getState('shift_id');
            $modObatAlkesPasien->pasien_id = $modPendaftaran->pasien_id;
            $modObatAlkesPasien->kelaspelayanan_id = $modPendaftaran->kelaspelayanan_id;
            $modObatAlkesPasien->tglpelayanan = date ('Y-m-d H:i:s');
            $modObatAlkesPasien->create_loginpemakai_id = Yii::app()->user->id;
            $modObatAlkesPasien->create_ruangan = Yii::app()->user->getState('ruangan_id');
            $modObatAlkesPasien->create_time = date ('Y-m-d H:i:s');

            if($modObatAlkesPasien->validate()) {
                $modObatAlkesPasien->save();
                StokobatalkesT::kurangiStok($modObatAlkesPasien->qty_oa, $modObatAlkesPasien->obatalkes_id);
            } else {
                $this->obatalkespasientersimpan &= false;
            }
            return $modObatAlkesPasien;
        }
        
        protected function saveTindakanPelayanan($modPasien,$modPendaftaran,$modPemakaian)
        {
            $modTindakan = new TindakanpelayananT;
            $modTindakan->shift_id = Yii::app()->user->getState('shift_id');
            $modTindakan->kelaspelayanan_id = $modPendaftaran->kelaspelayanan_id;
            $modTindakan->pasien_id = $modPasien->pasien_id;
            $modTindakan->daftartindakan_id = $modPemakaian->daftartindakanId;
            $modTindakan->carabayar_id = $modPendaftaran->carabayar_id;
            $modTindakan->pendaftaran_id = $modPendaftaran->pendaftaran_id;
            $modTindakan->jeniskasuspenyakit_id = $modPendaftaran->jeniskasuspenyakit_id;
            $modTindakan->instalasi_id =  Yii::app()->user->getState('instalasi_id');
            $modTindakan->ruangan_id =  Yii::app()->user->getState('ruangan_id');
            $modTindakan->penjamin_id = $modPendaftaran->penjamin_id;
            $modTindakan->tgl_tindakan = date('Y-m-d H:i:s');

            $modTindakan->tarif_tindakan = $modPemakaian->totaltarifambulans;
            $modTindakan->satuantindakan = 'Km';
            $modTindakan->qty_tindakan = $modPemakaian->jumlahkm;
            $modTindakan->tarif_satuan = $modPemakaian->tarifperkm;

            $modTindakan->cyto_tindakan = 0;
            $modTindakan->tarifcyto_tindakan = 0;
            $modTindakan->discount_tindakan = 0;
            $modTindakan->subsidiasuransi_tindakan = 0;
            $modTindakan->subsidipemerintah_tindakan = 0;
            $modTindakan->subsisidirumahsakit_tindakan = 0;
            $modTindakan->iurbiaya_tindakan = 0;
            $modTindakan->create_loginpemakai_id = Yii::app()->user->id;
            $modTindakan->create_ruangan = Yii::app()->user->getState('ruangan_id');
            $modTindakan->create_time = date ('Y-m-d H:i:s');
            if($modTindakan->save()){
                $this->tindakanpelayanantersimpan &= $modTindakan->saveTindakanKomponen();

            } else {
                $this->tindakanpelayanantersimpan = false;
//                Yii::app()->user->setFlash('info','<pre>'.print_r($modTindakan->getErrors(),1).'</pre>');
            }

            return $this->tindakanpelayanantersimpan;
        }
                
        public function actionDynamicRuangan()
        {
            $instalasi_id = (isset($_POST['instalasi']) ? $_POST['instalasi'] : null);
            $data = RuanganM::model()->findAll('instalasi_id=:instalasi_id AND ruangan_aktif = TRUE order by ruangan_nama', 
                  array(':instalasi_id'=>$instalasi_id));

            $data=CHtml::listData($data,'ruangan_id','ruangan_nama');

            if(empty($data))
            {
                echo CHtml::tag('option', array('value'=>''),CHtml::encode('-- Ruangan --'),true);
            }
            else
            {
                echo CHtml::tag('option',array('value'=>''),CHtml::encode('-- Ruangan --'),true);
                foreach($data as $value=>$name)
                {
                    echo CHtml::tag('option', array('value'=>$value),CHtml::encode($name),true);
                }
            }
        }
        /**
        * set LKTindakanpelayananT yang sudah ada di database
        * @params pasienmasukpenunjang_id
        */
       public function actionSetRiwayatObatAlkesPasien(){
           if(Yii::app()->request->isAjaxRequest) {
               $format = new MyFormatter();
               $rows = "";
               $loadOaPasiens = AMObatalkesPasienT::model()->findAllByAttributes(array('pendaftaran_id'=>$_POST['pendaftaran_id'],'ruangan_id'=>Yii::app()->user->getState('ruangan_id')));
               if(count($loadOaPasiens) > 0){
                   foreach($loadOaPasiens AS $i => $modObatAlkesPasien){
                       $modObatAlkesPasien->tglpelayanan = $format->formatDateTimeForUser($modObatAlkesPasien->tglpelayanan);
                       $modObatAlkesPasien->hargajual_oa = $format->formatNumberForUser($modObatAlkesPasien->hargajual_oa);
                       $modObatAlkesPasien->qty_oa = $format->formatNumberForUser($modObatAlkesPasien->qty_oa);
                       $modObatAlkesPasien->iurbiaya = $format->formatNumberForUser($modObatAlkesPasien->iurbiaya);
                       $rows .= $this->renderPartial($this->path_view."_rowRiwayatObatAlkesPasien",array('modObatAlkesPasien'=>$modObatAlkesPasien), true);
                   }
               }
               echo CJSON::encode(array(
                       'rows'=>$rows));
           }
           Yii::app()->end();
       }
    
       /**
        * set AMTindakanpelayananT yang sudah ada di database
        * @params pendaftaran_id
        */
       public function actionSetTindakanPelayanan(){
           if(Yii::app()->request->isAjaxRequest) {
               $format = new MyFormatter();
               $rows = "";
               $modTindakans = AMTindakanpelayananT::model()->findAllByAttributes(array('pendaftaran_id'=>$_POST['pendaftaran_id'],'ruangan_id'=>Yii::app()->user->getState('ruangan_id')), 'karcis_id IS NULL');
               if(count($modTindakans) > 0){
                   foreach($modTindakans AS $i => $modTindakan){
                       $modTindakan->kepropinsi_nama = TarifAmbulansM::model()->findByAttributes(array('daftartindakan_id'=>$modTindakan->daftartindakan_id))->kepropinsi_nama;
                       $modTindakan->kekabupaten_nama = TarifAmbulansM::model()->findByAttributes(array('daftartindakan_id'=>$modTindakan->daftartindakan_id))->kekabupaten_nama;
                       $modTindakan->kekecamatan_nama = TarifAmbulansM::model()->findByAttributes(array('daftartindakan_id'=>$modTindakan->daftartindakan_id))->kekecamatan_nama;
                       $modTindakan->kekelurahan_nama = TarifAmbulansM::model()->findByAttributes(array('daftartindakan_id'=>$modTindakan->daftartindakan_id))->kekelurahan_nama;
                       $modTindakan->jmlkilometer = TarifAmbulansM::model()->findByAttributes(array('daftartindakan_id'=>$modTindakan->daftartindakan_id))->jmlkilometer;
                       $modTindakan->tarifperkm = TarifAmbulansM::model()->findByAttributes(array('daftartindakan_id'=>$modTindakan->daftartindakan_id))->tarifperkm;
                       $modTindakan->tarif_pelayanan = $modTindakan->jmlkilometer * $modTindakan->tarifperkm;
                       $rows .= $this->renderPartial($this->path_view."_rowTindakanPelayanan",array('i'=>0, 'modTindakan'=>$modTindakan), true);
                   }
               }
               echo CJSON::encode(array(
                       'rows'=>$rows));
           }
           Yii::app()->end();
       }
        /**
         * @param type $pemakaianambulans_id
         */
        public function actionPrintStatusAmbulans($pemakaianambulans_id) 
        {
            $this->layout='//layouts/printWindows';
            $format = new MyFormatter;
            $modPemakaian = AMPemakaianambulansT::model()->findByPk($pemakaianambulans_id);
            $modPendaftaran = AMPendaftaranT::model()->findByPk($modPemakaian->pendaftaran_id);
            $modPasien=AMPasienM::model()->findByPk($modPendaftaran->pasien_id);
            $modTindakans = array();
            $criteria1 = new CdbCriteria();
            $criteria1->addCondition('pendaftaran_id = '.$modPendaftaran->pendaftaran_id);
            $criteria1->order = "pendaftaran_id DESC, pemakaianambulans_id DESC";
            $loadPemakaianAmbulans = AMPemakaianambulansT::model()->find($criteria1);
            if(isset($loadPemakaianAmbulans)){
                $modPemakaian = $loadPemakaianAmbulans;
                $modTindakans = TindakanpelayananT::model()->findByAttributes(array('pendaftaran_id'=>$modPendaftaran->pendaftaran_id,'ruangan_id'=>Yii::app()->user->getState('ruangan_id')));
                $criteria_tot = new CdbCriteria();
                $criteria_tot->addCondition("karcis_id IS NULL");
                $criteria_tot->addCondition("pendaftaran_id = ".$modPendaftaran->pendaftaran_id);
                $criteria_tot->addCondition("ruangan_id = ".Yii::app()->user->getState('ruangan_id'));
                $daftartindakan = TindakanpelayananT::model()->findAll($criteria_tot);
            }
            
            $judul_print = 'Pemakaian Ambulance Pasien';
            $this->render($this->path_view.'printStatusAmbulan', array(
                                'format'=>$format,
                                'modPendaftaran'=>$modPendaftaran,
                                'modPemakaian'=>$modPemakaian,
                                'judul_print'=>$judul_print,
                                'modPasien'=>$modPasien,
                                'modTindakans'=>$modTindakans,
                                'daftartindakan'=>$daftartindakan,
            ));
        } 
        
        /*
         * untuk print pemakaian bahp
         */
         public function actionPrintPemakaianBmhp($pemakaian_id) 
        {
            $this->layout='//layouts/printWindows';
            $format = new MyFormatter;    
            $modPemakaian = AMPemakaianambulansT::model()->findByPk($pemakaian_id);
            $modPendaftaran = AMPendaftaranT::model()->findByPk($modPemakaian->pendaftaran_id);     
            $modObatAlkesPasien = AMObatalkesPasienT::model()->findAllByAttributes(array('pendaftaran_id'=>$modPendaftaran->pendaftaran_id,'ruangan_id'=>Yii::app()->user->getState('ruangan_id')));
            $ruangan_id  = AMObatalkesPasienT::model()->find('pendaftaran_id = '.$modPendaftaran->pendaftaran_id.' AND ruangan_id = '.Yii::app()->user->getState('ruangan_id').'');
            if(!isset($ruangan_id)){
                $ruangan = RuanganM::model()->findByPk(Yii::app()->user->getState('ruangan_id'));
            }else{
                $ruangan = RuanganM::model()->findByPk($ruangan_id);
            }
            $judul_print = 'Pemakaian BAHP '.$ruangan->ruangan_nama;
            $this->render($this->path_view.'printPemakaianBmhp', array(
                                'format'=>$format,
                                'judul_print'=>$judul_print,
                                'modPemakaian'=>$modPemakaian,
                                'modPendaftaran'=>$modPendaftaran,
                                'modObatAlkesPasien'=>$modObatAlkesPasien,
            ));
        }


    public function actionAutocompleteNamaSupir()
    {
            if(Yii::app()->request->isAjaxRequest) {
                $returnVal = array();
                $nama_supir = isset($_GET['supir_nama']) ? $_GET['supir_nama'] : null;
                $criteria = new CDbCriteria();
                $criteria->compare('LOWER(nama_pegawai)', strtolower($nama_supir), true);
                $criteria->order = 'nama_pegawai';
                $criteria->limit = 5;
                
                $models = SupirambulansV::model()->findAll($criteria);
                foreach($models as $i=>$model)
                {
                    $attributes = $model->attributeNames();
                    foreach($attributes as $j=>$attribute) {
                        $returnVal[$i]["$attribute"] = $model->$attribute;
                    }
                    $returnVal[$i]['label'] = $model->nama_pegawai;
                    $returnVal[$i]['value'] = $model->nama_pegawai;
                }

                echo CJSON::encode($returnVal);
            }
            Yii::app()->end();
    }


    public function actionAutocompleteParamedis()
    {
        if(Yii::app()->request->isAjaxRequest) {
            $returnVal = array();
            $nama_paramedis = isset($_GET['paramedis_nama']) ? $_GET['paramedis_nama'] : null;
            $criteria = new CDbCriteria();
            $criteria->compare('LOWER(nama_pegawai)', strtolower($nama_paramedis), true);
            $criteria->order = 'nama_pegawai';
            $criteria->limit = 5;
            $models = ParamedisV::model()->findAll($criteria);
            foreach($models as $i=>$model)
            {
                $attributes = $model->attributeNames();
                foreach($attributes as $j=>$attribute) {
                    $returnVal[$i]["$attribute"] = $model->$attribute;
                }
                $returnVal[$i]['label'] = $model->nama_pegawai;
                $returnVal[$i]['value'] = $model->nama_pegawai;
            }

            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }

    
    public function actionAutocompleteKendaraan()
    {
        if(Yii::app()->request->isAjaxRequest) {
            $returnVal = array();
            $mobilambulans_kode = isset($_GET['mobilambulans_kode']) ? $_GET['mobilambulans_kode'] : null;
            $criteria = new CDbCriteria();
            $criteria->compare('LOWER(mobilambulans_kode)', strtolower($mobilambulans_kode), true);
            $criteria->order = 'mobilambulans_kode';
            $criteria->limit = 5;
            $models = MobilambulansM::model()->findAll($criteria);
            foreach($models as $i=>$model)
            {
                $attributes = $model->attributeNames();
                foreach($attributes as $j=>$attribute) {
                    $returnVal[$i]["$attribute"] = $model->$attribute;
                }
                $returnVal[$i]['label'] = $model->mobilambulans_kode." - ".$model->nopolisi." - ".$model->jeniskendaraan;
                $returnVal[$i]['value'] = $model->mobilambulans_kode;
            }

            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }
    
}