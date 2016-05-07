
<?php
Yii::import('billingKasir.controllers.PembayaranTagihanPasienController');
class PembayaranTagihanPasienPenunjangController extends PembayaranTagihanPasienController
{
    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout='//layouts/column1';
    public $defaultAction = 'index';
    public $path_view = 'billingKasir.views.pembayaranTagihanPasien.';

    /**
     * Membuat dan menyimpan data baru.
     * jika dari informasi menggunakan @params:
     * - $_GET['instalasi_id']
     * - $_GET['pendaftaran_id']
     * layout frame=1 -> frameDialog
     */
    public function actionIndex($id=null)
    {
        $format = new MyFormatter();
        $modKunjungan=new BKPasienmasukpenunjangV;
        $model=new BKPembayaranpelayananT;
        $modTandabukti = new BKTandabuktibayarT;
        $modTandabukti->is_menggunakankartu = 0;
        $modTindakansudahbayar = new BKTindakansudahbayarT;
        $modPemakaianuangmuka = new BKPemakaianuangmukaT;
        $modBayarangsuran = new BKBayarangsuranpelayananT;
        $dataTindakanPenunjangs = array();

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
        
        // Uncomment the following line if AJAX validation is needed
               
        if(isset($_GET['instalasi_id']) && isset($_GET['pendaftaran_id'])){
            $modKunjungan = BKPasienmasukpenunjangV::model()->findByAttributes(array('pendaftaran_id'=>$_GET['pendaftaran_id']));
            $modInstalasi = InstalasiM::model()->findByPk($_GET['instalasi_id']);
            $modKunjungan->instalasi_id = $modInstalasi->instalasi_id;
            $modKunjungan->instalasi_nama = $modInstalasi->instalasi_nama;
        }
        
        if(isset($_GET['frame'])){
            $this->layout = "//layouts/iframe";
        }
        
        
        if(isset($_POST['pendaftaran_id']) && isset($_POST['BKPembayaranpelayananT']) && (isset($_POST['BKTindakanPelayananT']) || isset($_POST['BKObatalkesPasienT'])))
        {
            $transaction = Yii::app()->db->beginTransaction();
            try {
                $modKunjungan->attributes = $_POST;
                $model=$this->simpanPembayaranPelayanan($model,$_POST['BKPembayaranpelayananT']);
                $modTandabukti=$this->simpanTandaBuktiBayar($model,$modTandabukti,$_POST['BKTandabuktibayarT']);
                if($_POST['BKPemakaianuangmukaT']['pemakaianuangmuka'] > 0){ //jika ada pemakaian uang muka
                    $modPemakaianuangmuka=$this->simpanPemakaianUangMuka($model,$modPemakaianuangmuka,$_POST['BKPemakaianuangmukaT']);
                }else{
                    $this->pemakaianuangmuka_tersimpan = true; //bypass uang muka
                }
                if($modTandabukti->carapembayaran == Params::CARAPEMBAYARAN_CICILAN || $modTandabukti->carapembayaran == Params::CARAPEMBAYARAN_HUTANG){
                    $modBayarangsuran=$this->simpanBayarAngsuran($model,$modTandabukti,$modBayarangsuran);
                }else{
                    $this->bayarangsuran_tersimpan = true; //bypass bayar angsuran = LUNAS / PIUTANG
                }
                if(isset($_POST['BKTindakanPelayananT'])){
                    if(count($_POST['BKTindakanPelayananT']) > 0){
                        foreach($_POST['BKTindakanPelayananT'] AS $i => $tindakanPenunjang){
                            $dataTindakanPenunjangs[$i] = $this->simpanBayarTindakans($model, $modTindakansudahbayar, $tindakanPenunjang);
                        }
                    }
                }else{
                    $this->tindakansudahbayar_tersimpan = true; //bypass tindakan jika tidak ada
                }
                if($this->bayarsemuatindakanoa){//jika semua terbayar
                    if(!empty($model->pasienadmisi_id)){
                      $modUpdateAdmisi = PasienadmisiT::model()->updateByPk($model->pasienadmisi_id,array('pembayaranpelayanan_id'=>$model->pembayaranpelayanan_id));
                    }else{ 
                      $modUpdatePendaftaran = PendaftaranT::model()->updateByPk($model->pendaftaran_id,array('pembayaranpelayanan_id'=>$model->pembayaranpelayanan_id));
                    }
                }
                if($this->pembayaranpelayanan_tersimpan && $this->tandabuktibayar_tersimpan && $this->tindakansudahbayar_tersimpan && $this->pemakaianuangmuka_tersimpan && $this->bayarangsuran_tersimpan){
                    //Di set di form >> Yii::app()->user->setFlash('success', 'Data pembayaran berhasil disimpan !');
                    
                    // SMS GATEWAY
                    $modPasien = $model->pasien;
                    $sms = new Sms();
                    $smspasien = 1;
                    foreach ($modSmsgateway as $i => $smsgateway) {
                        $isiPesan = $smsgateway->templatesms;

                        $attributes = $modPasien->getAttributes();
                        foreach($attributes as $attributes => $value){
                            $isiPesan = str_replace("{{".$attributes."}}",$value,$isiPesan);
                        }
                        $attributes = $modTandabukti->getAttributes();
                        foreach($attributes as $attributes => $value){
                            $isiPesan = str_replace("{{".$attributes."}}",$value,$isiPesan);
                        }
                        $attributes = $model->getAttributes();
                        foreach($attributes as $attributes => $value){
                            $isiPesan = str_replace("{{".$attributes."}}",$value,$isiPesan);
                        }
          
                        $isiPesan = str_replace("{{hari}}",MyFormatter::getDayName($modTandabukti->tglbuktibayar),$isiPesan);
                        
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
                    $this->redirect(array('index','id'=>$model->pembayaranpelayanan_id,'instalasi_id'=>$_POST['instalasi_id'],'pendaftaran_id'=>$_POST['pendaftaran_id'],'sukses'=>1,'smspasien'=>$smspasien));
                }else{
                    Yii::app()->user->setFlash('error', 'Data pembayaran gagal disimpan !');
                    $model->isNewRecord = true;
                    $model->pembayaranpelayanan_id = null;
                    $transaction->rollback();
//                    echo "1.". $this->pembayaranpelayanan_tersimpan."<br>";
//                    echo "2.". $this->tandabuktibayar_tersimpan."<br>";
//                    echo "3.". $this->tindakansudahbayar_tersimpan."<br>";
//                    echo "4.". $this->pemakaianuangmuka_tersimpan."<br>";
//                    echo "5.". $this->bayarangsuran_tersimpan."<br>";
//                    exit;
                }
            }catch (Exception $exc) {
                Yii::app()->user->setFlash('error',"Data pembayaran gagal disimpan ".MyExceptionMessage::getMessage($exc,true));
                $transaction->rollback();
            }
        }
        
        if(!empty($id)){
            $model = BKPembayaranpelayananT::model()->findByPk($id);
            $modTandabukti = BKTandabuktibayarT::model()->findByPk($model->tandabuktibayar_id);
            $modTandabukti->is_menggunakankartu = 0;
            $modPemakaianuangmuka = BKPemakaianuangmukaT::model()->findByPk($model->pembayaranpelayanan_id);
            if(!isset($modPemakaianuangmuka)){
                $modPemakaianuangmuka = new BKPemakaianuangmukaT;
            }
            $modBayarangsuran = new BKBayarangsuranpelayananT;
            $modBayarangsuran = new BKBayarangsuranpelayananT;
        }
        
        $modKunjungan->tgl_pendaftaran = $format->formatDateTimeForUser($modKunjungan->tgl_pendaftaran);
        $modKunjungan->tanggal_lahir = $format->formatDateTimeForUser($modKunjungan->tanggal_lahir);

        $this->render('index',array(
            'model'=>$model,
            'modTandabukti'=>$modTandabukti,
            'modKunjungan'=>$modKunjungan,
            'dataTindakanPenunjangs'=>$dataTindakanPenunjangs,
            'modPemakaianuangmuka'=>$modPemakaianuangmuka,
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
            if(isset($_POST['BKPembayaranpelayananT'])){
                $format = new MyFormatter();
                $criteria=new CdbCriteria();
                $instalasi_id = (isset($_POST['instalasi_id']) ? $_POST['instalasi_id'] : null);
                $pendaftaran_id = (isset($_POST['pendaftaran_id']) ? $_POST['pendaftaran_id'] : null);
                $model = new BKPasienmasukpenunjangV;
                $model->instalasi_id = $instalasi_id;
                $criteria = $model->criteriaGroupByPendaftaran();
				if(!empty($pendaftaran_id)){
					$criteria->addCondition("pendaftaran_id = ".$pendaftaran_id);					
				}
                $modKunjungan = $model->find($criteria);
                $modKunjungan->instalasi_nama = InstalasiM::model()->findByPk($instalasi_id)->instalasi_nama;
                $model = new BKPembayaranpelayananT;
                $modTandabukti = new BKTandabuktibayarT;
                $modPemakaianuangmuka = new BKPemakaianuangmukaT;

                $model->attributes = $_POST['BKPembayaranpelayananT'];
                $modTandabukti->attributes = $_POST['BKTandabuktibayarT'];
                $modTandabukti->is_menggunakankartu = $_POST['BKTandabuktibayarT']['is_menggunakankartu'];
                $modPemakaianuangmuka->attributes = $_POST['BKPemakaianuangmukaT'];

            }
            echo CJSON::encode(array(
                'content'=>$this->renderPartial($this->path_view.'verifikasi',array(
                    'format'=>$format,
                    'modKunjungan'=>$modKunjungan,
                    'model'=>$model,
                    'modTandabukti'=>$modTandabukti,
                    'modPemakaianuangmuka'=>$modPemakaianuangmuka,
            ), true)));
            exit;
        }
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
            $model = new BKPasienmasukpenunjangV;
            $model->instalasi_id = $instalasi_id;
            $criteria = $model->criteriaGroupByPendaftaran();
            $criteria->compare('LOWER(no_pendaftaran)', strtolower($no_pendaftaran), true);
            $criteria->compare('LOWER(no_rekam_medik)', strtolower($no_rekam_medik), true);
            $criteria->compare('LOWER(nama_pasien)', strtolower($nama_pasien), true);
            $criteria->order = 'no_pendaftaran, no_rekam_medik, nama_pasien';
            $criteria->limit = 5;
            $models = $model->findAll($criteria);
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
            $model = new BKPasienmasukpenunjangV;
            $model->instalasi_id = $instalasi_id;
            $criteria = $model->criteriaGroupByPendaftaran();
			if(!empty($pendaftaran_id)){
				$criteria->addCondition("pendaftaran_id = ".$pendaftaran_id);					
			}
			if(!empty($pasienadmisi_id)){
				$criteria->addCondition("pasienadmisi_id = ".$pasienadmisi_id);					
			}
            $criteria->compare('LOWER(no_pendaftaran)',strtolower($no_pendaftaran));
            $criteria->compare('LOWER(no_rekam_medik)',strtolower($no_rekam_medik));
            $model = $model->find($criteria);
            $attributes = $model->attributeNames();
            foreach($attributes as $j=>$attribute) {
                $returnVal["$attribute"] = $model->$attribute;
            }
            $returnVal["tanggal_lahir"] = $format->formatDateTimeForUser($model->tanggal_lahir);
            $returnVal["tgl_pendaftaran"] = $format->formatDateTimeForUser($model->tgl_pendaftaran);
            $modPenunjangAkhir = $model->getPenunjangAkhir();
            $returnVal["ruangan_id"] = $modPenunjangAkhir->ruangan_id;
            $returnVal["ruangan_nama"] = $modPenunjangAkhir->ruangan_nama;
            
            $carabayar = CarabayarM::model()->findByPk($model->carabayar_id);
            $returnVal["metode_pembayaran"] = strtoupper($carabayar->metode_pembayaran);

            $returnVal["tanggal_lahir"] = $format->formatDateTimeForUser($model->tanggal_lahir);
            $returnVal["tgl_pendaftaran"] = $format->formatDateTimeForUser($model->tgl_pendaftaran);
            
            //load uang muka
            $crit_uangmuka = new CDbCriteria();
			if(!empty($model->pendaftaran_id)){
				$crit_uangmuka->addCondition("pendaftaran_id = ".$model->pendaftaran_id);					
			}
			if(!empty($model->pasienadmisi_id)){
				$crit_uangmuka->addCondition("pasienadmisi_id = ".$model->pasienadmisi_id);					
			}
            $crit_uangmuka->addCondition("pemakaianuangmuka_id IS NULL");
            $crit_uangmuka->select = "sum(jumlahuangmuka) as jumlahuangmuka";
            $modUangMuka = BKBayaruangmukaT::model()->find($crit_uangmuka);
            $returnVal["jumlahuangmuka"] = (isset($modUangMuka->jumlahuangmuka) ? $modUangMuka->jumlahuangmuka : 0);
            
            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }
    
    /**
     * menampilkan form rincian tagihan tindakan penunjang
     */
    public function actionSetRincianTindakanPenunjang(){
        if(Yii::app()->request->isAjaxRequest) { 
            $format = new MyFormatter();
            $instalasi_id=(isset($_POST['instalasi_id']) ? $_POST['instalasi_id'] : null);
            $pendaftaran_id=(isset($_POST['pendaftaran_id']) ? $_POST['pendaftaran_id'] : null);
            $kelaspelayanan_id=(isset($_POST['kelaspelayanan_id']) ? $_POST['kelaspelayanan_id'] : null);
            $pasien_id = (isset($_POST['pasien_id']) ? $_POST['pasien_id'] : null);
            $penjamin_id = (isset($_POST['penjamin_id']) ? $_POST['penjamin_id'] : null);
            $form='';
            $dataTindakanPenunjangs = array();
            $dataPenunjangs = array();
            if(!empty($pendaftaran_id)){
                $criteria = new CDbCriteria();
                $criteria->addCondition("pendaftaran_id = ".$pendaftaran_id);
                if(!empty($instalasi_id)){
                    $ruangan_ids = array();
                    $modRuangans = RuanganM::model()->findAllByAttributes(array("instalasi_id"=>$instalasi_id), "ruangan_aktif = true");
                    if(count($modRuangans) > 0){
                        foreach($modRuangans AS $i => $ruangan){
                            $ruangan_ids[$i] = $ruangan->ruangan_id;
                        }
                        $criteria->addInCondition("ruangan_id", $ruangan_ids);
                    }
                }
                $modPasienMasukPenunjangs = BKPasienmasukpenunjangV::model()->findAll($criteria);
                if(count($modPasienMasukPenunjangs) > 0){
                    foreach ($modPasienMasukPenunjangs AS $i => $penunjang){
                            $criteria = new CdbCriteria();
                            $criteria->addCondition("pendaftaran_id = ".$pendaftaran_id);
                            $criteria->addCondition("pasienmasukpenunjang_id = ".$penunjang->pasienmasukpenunjang_id);
                            $criteria->addCondition("tindakansudahbayar_id IS NULL");
                            $dataTindakanPenunjangs[$i]=BKTindakanPelayananT::model()->findAll($criteria);
                            $dataPenunjangs[$i]['ruangan_nama'] = $penunjang->ruangan_nama;
                            $dataPenunjangs[$i]['no_masukpenunjang'] = $penunjang->no_masukpenunjang;
                            $dataPenunjangs[$i]['tglmasukpenunjang'] = $format->formatDateTimeForUser($penunjang->tglmasukpenunjang);
                            $dataPenunjangs[$i]['jeniskasuspenyakit_nama'] = $penunjang->jeniskasuspenyakit_nama;
                            $dataPenunjangs[$i]['kelaspelayanan_nama'] = $penunjang->kelaspelayanan_nama;
                    }
                }
            }
            $form = $this->renderPartial('_formRincianTindakanPenunjang',array('dataPenunjangs'=>$dataPenunjangs,'dataTindakanPenunjangs'=>$dataTindakanPenunjangs),true);
            $data['form']=$form;
            echo json_encode($data);
            Yii::app()->end();
        }
    }
    /**
     * actionPrintRincianBelumBayar 
     * @params $instalasi_id = RJ / RD / RI
     * @params $pendaftaran_id
     * @params $pasienadmisi_id (RI saja)
     */
    public function actionPrintRincianPenunjangBelumBayar($instalasi_id,$pendaftaran_id){
        $this->layout='//layouts/printWindows';
        $data['judulLaporan'] = 'RINCIAN BIAYA PELAYANAN';
        $data['nama_pegawai'] = LoginpemakaiK::model()->findByPK(Yii::app()->user->id)->pegawai->nama_pegawai;
        $dataUangmukas = BayaruangmukaT::model()->findAllByAttributes(array('pendaftaran_id'=>$pendaftaran_id));
        $uang_muka = 0;
        foreach($dataUangmukas as $uangmuka)
        {
            $uang_muka += $uangmuka->jumlahuangmuka;
        }
        $data['uang_muka'] = $uang_muka;
        $modPendaftaran=PendaftaranT::model()->findByPk($pendaftaran_id);
        $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
        $criteria = new CDbCriteria();
        $criteria->addCondition('pendaftaran_id = '.$pendaftaran_id);
        $criteria->addCondition('instalasi_id = '.$instalasi_id);
        $criteria->order = 'ruangan_id';
        $modRincian = BKRinciantagihanpasienpenunjangV::model()->findAll($criteria);
        $this->render('printRincianPenunjangBelumBayar', array('modPendaftaran'=>$modPendaftaran,'modPasien'=>$modPasien,'modRincian'=>$modRincian, 'data'=>$data));
        
    }
    
}
