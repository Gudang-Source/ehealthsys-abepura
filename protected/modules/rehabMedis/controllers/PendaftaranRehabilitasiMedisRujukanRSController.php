<?php
Yii::import('rehabMedis.controllers.PendaftaranRehabilitasiMedisController');
class PendaftaranRehabilitasiMedisRujukanRSController extends PendaftaranRehabilitasiMedisController
{
    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout='//layouts/column1';
    public $defaultAction = 'index';
    public $path_view = 'rehabMedis.views.pendaftaranRehabilitasiMedisRujukanRS.';
    public $path_view_pendaftaran = 'rehabMedis.views.pendaftaranRehabilitasiMedis.';

    /**
     * Tambah / ubah pemeriksaan Rehabilitasi Medis
     */
    public function actionIndex($pasienmasukpenunjang_id = null)
    {
        $format = new MyFormatter();
        $modKunjungan = new RMPasienKirimKeUnitLainV;
        $modKunjungan->ruangan_id = Yii::app()->user->getState("ruangan_id");
        $modPemeriksaanRm = new RMTarifpemeriksaanrmruanganV;
        $modPasienMasukPenunjang = new RMPasienmasukpenunjangT;
        $modPasienMasukPenunjang->ruangan_id = Yii::app()->user->getState("ruangan_id");
        $modTindakan=new RMTindakanpelayananT;
        $modTindakan->tgl_tindakan=$format->formatDateTimeForUser(date('Y-m-d H:i:s'));
        $dataTindakans = array(); 

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
            $modKunjungan = RMPasienKirimKeUnitLainV::model()->findByAttributes(array('pasienkirimkeunitlain_id'=>$_GET['pasienkirimkeunitlain_id']));
            $modPasienMasukPenunjang->pasienkirimkeunitlain_id = $modKunjungan->pasienkirimkeunitlain_id;
            $modPasienMasukPenunjang->jeniskasuspenyakit_id = $modKunjungan->jeniskasuspenyakit_id;
            $modPasienMasukPenunjang->kelaspelayanan_id = $modKunjungan->kelaspelayanan_id;
        }

        if(!empty($pasienmasukpenunjang_id)){
            $modPasienMasukPenunjang = RMPasienmasukpenunjangT::model()->findByPk($pasienmasukpenunjang_id);
            $loadModKunjungan = RMPasienMasukPenunjangV::model()->findByAttributes(array('pasienmasukpenunjang_id'=>$pasienmasukpenunjang_id));
            if(isset($loadModKunjungan)){
                $modKunjungan = $loadModKunjungan;
            }
        }

        if(isset($_POST['RMPasienmasukpenunjangT'])){
            $modKunjungan = RMPasienKirimKeUnitLainV::model()->findByAttributes(array('pasienkirimkeunitlain_id'=>$_POST['RMPasienmasukpenunjangT']['pasienkirimkeunitlain_id']));
            $modPendaftaran = RMPendaftaranT::model()->findByPk($_POST['pendaftaran_id']);
            $transaction = Yii::app()->db->beginTransaction();

            try {
                $modPasienMasukPenunjang = $this->simpanPasienMasukPenunjang($modPasienMasukPenunjang,$modPendaftaran,$_POST['RMPasienmasukpenunjangT']);
                $pasienkirimterupdate = PasienkirimkeunitlainT::model()->updateByPk($modPasienMasukPenunjang->pasienkirimkeunitlain_id,array('pasienmasukpenunjang_id'=>$modPasienMasukPenunjang->pasienmasukpenunjang_id, 'update_time'=>date("Y-m-d H:i:s"),'update_loginpemakai_id'=>Yii::app()->user->id));
                
                if(isset($_POST['RMTindakanpelayananT'])){
                    if(count($_POST['RMTindakanpelayananT']) > 0){
                        foreach($_POST['RMTindakanpelayananT'] AS $ii => $tindakan){
                            if(!empty($tindakan['tindakanpelayanan_id'])){
                                $dataTindakans[$ii] = RMTindakanpelayananT::model()->findByPk($tindakan['tindakanpelayanan_id']);
                            }else{
                                $dataTindakans[$ii] = $this->simpanTindakanPelayanan($modPendaftaran,$modPasienMasukPenunjang,$tindakan);
                                $modHasilPemeriksaan = $this->simpanHasilPemeriksaan($modPasienMasukPenunjang, $dataTindakans[$ii], $tindakan);
                            }
                            if (!empty($dataTindakans[$ii])){
                                $dataTindakans[$ii]->tindakanrm_id = $tindakan['tindakanrm_id'];
                                $dataTindakans[$ii]->daftartindakan_id = $tindakan['daftartindakan_id'];
                                $dataTindakans[$ii]->jenistarif_id = $tindakan['jenistarif_id'];
                                $dataTindakans[$ii]->tarif_tindakan = $format->formatNumberForUser($tindakan['tarif_tindakan']);
                            }                    
                        }
                    }
                }

                if($this->pasienpenunjangtersimpan && $this->tindakanpelayanantersimpan && $this->komponentindakantersimpan && $this->hasilpemeriksaantersimpan && $pasienkirimterupdate){
                    // SMS GATEWAY
                    $modPegawai = $modPasienMasukPenunjang->pegawai;
                    $modPasien = $modPasienMasukPenunjang->pasien;
                    $modRuangan = $modPasienMasukPenunjang->ruangan;
                    $modPendaftaran = $modPasienMasukPenunjang->pendaftaran;
                    if(isset($modPendaftaran->penanggungjawab)){
                        $modPenanggungJawab = $modPendaftaran->penanggungjawab;
                    }
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
                        if(isset($modPendaftaran->penanggungjawab)){
                            $attributes = $modPenanggungJawab->getAttributes();
                            foreach($attributes as $attributes => $value){
                                $isiPesan = str_replace("{{".$attributes."}}",$value,$isiPesan);
                            }
                        }
                        $attributes = $modPegawai->getAttributes();
                        foreach($attributes as $attributes => $value){
                            $isiPesan = str_replace("{{".$attributes."}}",$value,$isiPesan);
                        }
                        $attributes = $modPasienMasukPenunjang->getAttributes();
                        foreach($attributes as $attributes => $value){
                            $isiPesan = str_replace("{{".$attributes."}}",$value,$isiPesan);
                        }
                        $attributes = $modRuangan->getAttributes();
                        foreach($attributes as $attributes => $value){
                            $isiPesan = str_replace("{{".$attributes."}}",$value,$isiPesan);
                        }
                        $isiPesan = str_replace("{{hari}}",MyFormatter::getDayName($modPasienMasukPenunjang->tglmasukpenunjang),$isiPesan);
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
                    Yii::app()->user->setFlash('success', "Data pemeriksaan rehabilitasi medis berhasil disimpan !");
                    $this->redirect(array('index','pasienmasukpenunjang_id'=>$modPasienMasukPenunjang->pasienmasukpenunjang_id,'sukses'=>1,'smspasien'=>$smspasien,'smsdokter'=>$smsdokter,'smspenanggungjawab'=>$smspenanggungjawab));
                }else{
                    $transaction->rollback();
//                    echo "-".$this->pasienpenunjangtersimpan."<br>";
//                    echo "-".$this->tindakanpelayanantersimpan."<br>";
//                    echo "-".$this->komponentindakantersimpan."<br>";
//                    echo "-".$this->hasilpemeriksaantersimpan."<br>";
//                    echo "-".$pasienkirimterupdate."<br>";
//                    exit;
                    Yii::app()->user->setFlash('error',"Data pemeriksaan rehabilitasi medis gagal disimpan !<br>");
                }
            } catch (Exception $exc) {
                $transaction->rollback();
                Yii::app()->user->setFlash('error',"Data pemeriksaan rehabilitasi medis gagal disimpan !"." ".MyExceptionMessage::getMessage($exc,true));
            }
        }

        $this->render('index',array(
            'modKunjungan'=>$modKunjungan,
            'modPemeriksaanRm'=>$modPemeriksaanRm,
            'modPasienMasukPenunjang'=>$modPasienMasukPenunjang,
            'modTindakan'=>$modTindakan,
            'dataTindakans'=>$dataTindakans,
            'modSmsgateway'=>$modSmsgateway
        ));
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
            $models = RMPasienKirimKeUnitLainV::model()->findAll($criteria);
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
     * Mengurai data kunjungan berdasarkan :
     * - pasienkirimkeunitlain_id
     * @throws CHttpException
     */
    public function actionGetDataKunjungan(){
        if(Yii::app()->request->isAjaxRequest) {
            $format = new MyFormatter;
            $returnVal = array();
            $model = RMPasienKirimKeUnitLainV::model()->findByAttributes(array('pasienkirimkeunitlain_id'=>$_POST['pasienkirimkeunitlain_id']));
            $attributes = $model->attributeNames();
            foreach($attributes as $j=>$attribute) {
                $returnVal["$attribute"] = $model->$attribute;
            }
            $gelardepan = (isset($model->gelardepan) ? $model->gelardepan : "");
            $gelarbelakang = (isset($model->gelarbelakang_nama) ? $model->gelarbelakang_nama : "");
            $returnVal["tanggal_lahir"] = $format->formatDateTimeForUser($model->tanggal_lahir);
            $returnVal["tgl_pendaftaran"] = $format->formatDateTimeForUser($model->tgl_pendaftaran);
            $returnVal["nama_pegawai"] = $gelardepan." ".$model->nama_pegawai." ".$gelarbelakang;
            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }
    
    /**
     * set RMPermintaanKePenunjangT yang sudah ada di database
     * @params pasienmasukpenunjang_id
     */
    public function actionSetPermintaanKePenunjang(){
        if(Yii::app()->request->isAjaxRequest) {
            $format = new MyFormatter();
            $rows = "";
            $modPermintaans = RMPermintaanKePenunjangT::model()->findAllByAttributes(array('pasienkirimkeunitlain_id'=>$_POST['pasienkirimkeunitlain_id']));
            if(count($modPermintaans) > 0){
                foreach($modPermintaans AS $i => $modPermintaan){
                    $modPemeriksaan = TindakanrmM::model()->findByAttributes(array('tindakanrm_id'=>$modPermintaan->tindakanrm_id));
                    
                    if(isset($modPemeriksaan->tindakanrm_id)){
                        $modPermintaan->tindakanrm_id = $modPemeriksaan->tindakanrm_id;
                        $modPermintaan->jenistindakanrm_id = $modPemeriksaan->jenistindakanrm_id;
                        $modPermintaan->tindakanrm_nama = $modPemeriksaan->tindakanrm_nama;
                        $rows .= $this->renderPartial($this->path_view."_rowPermintaanKePenunjang",array('i'=>0,'modPermintaan'=>$modPermintaan), true);
                    }
                }
            }
            echo CJSON::encode(array(
                    'rows'=>$rows));
        }
        Yii::app()->end();
    }
    
    /**
     * set RMTindakanpelayananT yang sudah ada di database
     * @params pasienmasukpenunjang_id
     */
    public function actionSetTindakanPelayanan(){
        if(Yii::app()->request->isAjaxRequest) {
            $format = new MyFormatter();
            $rows = "";
            $modTindakans = RMTindakanpelayananT::model()->findAllByAttributes(array('pasienmasukpenunjang_id'=>$_POST['pasienmasukpenunjang_id']), 'karcis_id IS NULL');
            if(count($modTindakans) > 0){
                foreach($modTindakans AS $i => $modTindakan){
                    $modTindakan->tindakanrm_id = TindakanrmM::model()->findByAttributes(array('daftartindakan_id'=>$modTindakan->daftartindakan_id))->tindakanrm_id;
                    $modTindakan->jenistindakanrm_id = TindakanrmM::model()->findByAttributes(array('daftartindakan_id'=>$modTindakan->daftartindakan_id))->jenistindakanrm_id;
                    $modTindakan->jenistarif_id = JenistarifpenjaminM::model()->findByAttributes(array('penjamin_id'=>$modTindakan->pendaftaran->penjamin_id))->jenistarif_id;
                    $modTindakan->tarif_tindakan = $format->formatNumberForUser($modTindakan->tarif_tindakan);
                    $rows .= $this->renderPartial($this->path_view_pendaftaran."_rowTindakanPemeriksaan",array('i'=>0, 'modTindakan'=>$modTindakan), true);
                }
            }
            echo CJSON::encode(array(
                    'rows'=>$rows));
        }
        Yii::app()->end();
    }
        
}
