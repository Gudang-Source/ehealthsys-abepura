
<?php

class PembayaranTagihanPasienController extends MyAuthController
{
    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout='//layouts/column1';
    public $defaultAction = 'index';
    public $path_view = 'billingKasir.views.pembayaranTagihanPasien.';
    
    public $pembayaranpelayanan_tersimpan = false;
    public $tandabuktibayar_tersimpan = false;
    public $tindakansudahbayar_tersimpan = false;
    public $oasudahbayar_tersimpan = false;
    public $pemakaianuangmuka_tersimpan = false;
    public $bayarangsuran_tersimpan = false;
    public $bayarsemuatindakanoa = false;
    
    public $isbayarkarcis = false;

    /**
     * Membuat dan menyimpan data baru.
     * jika dari informasi menggunakan @params:
     * - $_GET['instalasi_id']
     * - $_GET['pendaftaran_id']
     * - $_GET['pasienadmisi_id'] (untuk RI saja)
     * layout frame=1 -> frameDialog
     */
    public function actionIndex($id=null)
    {
        $format = new MyFormatter();
        $modKunjungan=new BKInformasikasirinappulangV;
        $modKunjungan->instalasi_id = Params::INSTALASI_ID_RJ;
        $model=new BKPembayaranpelayananT;
        $modTandabukti = new BKTandabuktibayarT;
        $modTandabukti->is_menggunakankartu = 0;
        $modTindakansudahbayar = new BKTindakansudahbayarT;
        $modOasudahbayar = new BKOasudahbayarT;
		$modBayaruangmuka = new BKBayaruangmukaT;
        $modPemakaianuangmuka = new BKPemakaianuangmukaT;
        $modBayarangsuran = new BKBayarangsuranpelayananT;
        $modAntrian=new BKAntrianT;
        $dataTindakans = array();
        $dataOas = array();

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
               
        if(isset($_GET['instalasi_id'])){
            if($_GET['instalasi_id'] == Params::INSTALASI_ID_RJ){
                $loadKunjungan = BKInformasikasirrawatjalanV::model()->findByAttributes(array('pendaftaran_id'=>$_GET['pendaftaran_id']));
            }else if($_GET['instalasi_id'] == Params::INSTALASI_ID_RD){
                $loadKunjungan = BKInformasikasirrdpulangV::model()->findByAttributes(array('pendaftaran_id'=>$_GET['pendaftaran_id']));;
            }else if($_GET['instalasi_id'] == Params::INSTALASI_ID_RI){
                $loadKunjungan = BKInformasikasirinappulangV::model()->findByAttributes(array('pendaftaran_id'=>$_GET['pendaftaran_id'],'pasienadmisi_id'=> isset($_GET['pasienadmisi_id']) ? $_GET['pasienadmisi_id'] : $model->pasienadmisi_id));
            }
            if(isset($loadKunjungan)){
                $modKunjungan = $loadKunjungan;
            }
        }
        
        if(isset($_GET['frame'])){
            $this->layout = "//layouts/iframe";
        }
        
        if(isset($_POST['pendaftaran_id']) && isset($_POST['BKPembayaranpelayananT']) && (isset($_POST['BKTindakanPelayananT']) || isset($_POST['BKObatalkesPasienT'])))
        {
            $transaction = Yii::app()->db->beginTransaction();
            try {
                $modKunjungan->attributes = $_POST;
				$modBayaruangmuka = BKBayaruangmukaT::model()->findByAttributes(array('pendaftaran_id'=>$_POST['pendaftaran_id'])); //RSN-1195
                $model=$this->simpanPembayaranPelayanan($model,$_POST['BKPembayaranpelayananT']);
                $modTandabukti=$this->simpanTandaBuktiBayar($model,$modTandabukti,$_POST['BKTandabuktibayarT']);
                if($_POST['BKPemakaianuangmukaT']['pemakaianuangmuka'] > 0){ //jika ada pemakaian uang muka
                    $modPemakaianuangmuka=$this->simpanPemakaianUangMuka($model,$modPemakaianuangmuka,$_POST['BKPemakaianuangmukaT'],$modBayaruangmuka);
                }else{
                    $this->pemakaianuangmuka_tersimpan = true; //bypass uang muka
                }
                if($modTandabukti->carapembayaran == Params::CARAPEMBAYARAN_CICILAN || $modTandabukti->carapembayaran == Params::CARAPEMBAYARAN_HUTANG){
                    $modBayarangsuran=$this->simpanBayarAngsuran($model,$modTandabukti,$modBayarangsuran);
                }else{
                    $this->bayarangsuran_tersimpan = true; //bypass bayar angsuran = LUNAS / PIUTANG
                }
                if(isset($_POST['BKTindakanPelayananT'])){
                    $dataTindakans = $this->simpanBayarTindakans($model, $modTindakansudahbayar, $_POST['BKTindakanPelayananT']);
                }else{
                    $this->tindakansudahbayar_tersimpan = true; //bypass tindakan jika tidak ada
                    $this->bayarsemuatindakanoa = true;
                }
                if(isset($_POST['BKObatalkesPasienT'])){
                    $dataOas = $this->simpanBayarOas($model, $modOasudahbayar, $_POST['BKObatalkesPasienT']);
                }else{
                    $this->oasudahbayar_tersimpan = true; //bypass oa jika tidak ada
                }
                if($this->bayarsemuatindakanoa){//jika semua terbayar
//                    BELUM JELAS AKHIR DARI PEMBAYARAN KARENA PEMBAYARAN BISA LEBIH DARI 1 KALI
					// LNG-2450
                    if($_POST['instalasi_id'] == Params::INSTALASI_ID_RI){
                        $modUpdateAdmisi = PasienadmisiT::model()->updateByPk($model->pasienadmisi_id,array('pembayaranpelayanan_id'=>$model->pembayaranpelayanan_id));
                    }else{ 
                        $modUpdatePendaftaran = PendaftaranT::model()->updateByPk($model->pendaftaran_id,array('pembayaranpelayanan_id'=>$model->pembayaranpelayanan_id));
                    }
                }
                
                $this->broadcastNotifBayarKarcisUmum($modKunjungan, $model);
                if (!$this->isbayarkarcis) $this->broadcastNotifBayarTagihanPasien($modKunjungan, $model);
                
                // die;
                
                if($this->pembayaranpelayanan_tersimpan && $this->tandabuktibayar_tersimpan && $this->tindakansudahbayar_tersimpan && $this->oasudahbayar_tersimpan && $this->pemakaianuangmuka_tersimpan && $this->bayarangsuran_tersimpan){
                    //Di set di form >> Yii::app()->user->setFlash('success', 'Data pembayaran berhasil disimpan !');
		          
                    // SMS GATEWAY
                    $modPasien = $model->pasien;
                    $sms = new Sms();
                    $smspasien = 1;
                    foreach ($modSmsgateway as $i => $smsgateway) {
                        if (isset($_POST['tujuansms']) && in_array($smsgateway->tujuansms, $_POST['tujuansms'])) {
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
                        
                    }
                    // END SMS GATEWAY
                        
                    $transaction->commit();
					if(isset($_GET['frame'])){
						$this->redirect(array('index','id'=>$model->pembayaranpelayanan_id,'pendaftaran_id'=>$model->pendaftaran_id,'instalasi_id'=>$modKunjungan->instalasi_id,'sukses'=>1,'frame'=>1,'smspasien'=>$smspasien));
					}else{
						$this->redirect(array('index','id'=>$model->pembayaranpelayanan_id,'pendaftaran_id'=>$model->pendaftaran_id,'instalasi_id'=>$modKunjungan->instalasi_id,'sukses'=>1,'smspasien'=>$smspasien));
					}
                }else{
                    Yii::app()->user->setFlash('error', 'Data pembayaran gagal disimpan !');
                    $model->isNewRecord = true;
                    $model->pembayaranpelayanan_id = null;
                    $transaction->rollback();
//                    echo "1.". $this->pembayaranpelayanan_tersimpan."<br>";
//                    echo "2.". $this->tandabuktibayar_tersimpan."<br>";
//                    echo "3.". $this->tindakansudahbayar_tersimpan."<br>";
//                    echo "4.". $this->oasudahbayar_tersimpan."<br>";
//                    echo "5.". $this->pemakaianuangmuka_tersimpan."<br>";
//                    echo "6.". $this->bayarangsuran_tersimpan."<br>";
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
        }
        
        $modKunjungan->tgl_pendaftaran = $format->formatDateTimeForUser($modKunjungan->tgl_pendaftaran);
        $modKunjungan->tanggal_lahir = $format->formatDateTimeForUser($modKunjungan->tanggal_lahir);

        $this->render('index',array(
            'model'=>$model,
            'modTandabukti'=>$modTandabukti,
            'modKunjungan'=>$modKunjungan,
            'dataTindakans'=>$dataTindakans,
            'dataOas'=>$dataOas,
            'modPemakaianuangmuka'=>$modPemakaianuangmuka,
            'modAntrian'=>$modAntrian,
        ));
    }
    
    protected function broadcastNotifBayarTagihanPasien($modKunjungan, $model) {
        //$judul = "Pembayaran Tagihan Pasien";
        //$isi = $isi = $modKunjungan->no_rekam_medik." - ".$modKunjungan->namadepan.$modKunjungan->nama_pasien." - ".MyFormatter::formatNumberForPrint($model->totalbiayapelayanan);
        
        //var_dump($modKunjungan->attributes); die;
        
        
        //$cur = array(
        //    array('instalasi_id'=>Params::INSTALASI_ID_RJ, 'ruangan_id'=>$pendaftaran->ruangan_id, 'modul_id'=>5),
        //);
    }
    
    protected function broadcastNotifBayarKarcisUmum($modKunjungan, $model) {
        $judul = "Pembayaran Karcis Pasien Umum";
        $isi = "";
        
        if ($modKunjungan->penjamin_id == Params::PENJAMIN_ID_UMUM && $modKunjungan->instalasi_id == Params::INSTALASI_ID_RJ) {
            $pendaftaran = PendaftaranT::model()->findByPk($modKunjungan->pendaftaran_id);
            if (!empty($pendaftaran->karcis_id)) {
                $tindakan = TindakanpelayananT::model()->findByAttributes(array(
                    'pendaftaran_id'=>$pendaftaran->pendaftaran_id,
                    'karcis_id'=>$pendaftaran->karcis_id,
                ));
            } else {
                if (empty($tindakan)) {
                    $tindakan = TindakanpelayananT::model()->findByAttributes(array(
                        'pendaftaran_id'=>$pendaftaran->pendaftaran_id,
                        'ruangan_id'=>2,
                    ), array(
                        'condition'=>'karcis_id is not null'
                    ));
                }
            }
            
            if (!empty($tindakan)) {
                if (!empty($tindakan->tindakansudahbayar_id)) {
                    $sb = TindakansudahbayarT::model()->findByPk($tindakan->tindakansudahbayar_id);
                    if ($sb->pembayaranpelayanan_id == $model->pembayaranpelayanan_id) {
                        $isi = $modKunjungan->no_rekam_medik." - ".$modKunjungan->namadepan.$modKunjungan->nama_pasien." - ".MyFormatter::formatNumberForPrint($model->totalbiayapelayanan);
                        // echo $isi;
                    
                        CustomFunction::broadcastNotif($judul, $isi, array(
                            array('instalasi_id'=>Params::INSTALASI_ID_RJ, 'ruangan_id'=>$pendaftaran->ruangan_id, 'modul_id'=>5),
                        ));
                        
                        $this->isbayarkarcis = true;
                    }
                   
                   // return CHtml::link("<i class='icon-form-periksa'></i> ", '#', array("id"=>$this->no_pendaftaran,"rel"=>"tooltip","title"=>"Klik untuk Pemeriksaan Pasien", "onclick"=>"myAlert('Pasien belum membayar karcis.'); return false;"));
                }
            }
        }
    }
    
    /**
     * simpan BKPembayaranpelayananT
     * @param type $model
     * @param type $post
     * @return type
     */
    protected function simpanPembayaranPelayanan($model, $post){
        $model = new $model;
        $model->attributes=$post;
        $model->tglpembayaran=date("Y-m-d H:i:s");
        $model->nopembayaran=MyGenerator::noPembayaran();
        $model->ruanganpelakhir_id=$_POST['ruangan_id'];
        $model->carabayar_id=$_POST['carabayar_id'];
        $model->penjamin_id=$_POST['penjamin_id'];
        $model->pendaftaran_id=$_POST['pendaftaran_id'];
        $model->pasien_id=$_POST['pasien_id'];
        $model->pasienadmisi_id=isset($_POST['pasienadmisi_id']) ? $_POST['pasienadmisi_id'] : null;
        $model->create_time=date('Y-m-d H:i:s');
        $model->create_loginpemakai_id=Yii::app()->user->id;
        $model->create_ruangan=Yii::app()->user->getState('ruangan_id');
        $model->ruangan_id=Yii::app()->user->getState('ruangan_id');
        // var_dump($model->attributes); die;
        if($model->totalsisatagihan == 0){
            $model->statusbayar = Params::STATUSBAYAR_LUNAS;
        }else{
            $model->statusbayar = Params::STATUSBAYAR_BELUM_LUNAS;
        }
        if($model->save()){
            $this->pembayaranpelayanan_tersimpan = true;
        }
        return $model;
    }
    /**
     * simpan BKTandabuktibayarT
     * ubah BKPembayaranpelayananT.tandabuktibayar_id
     * @param type $model
     * @param type $modTandabukti
     * @param type $post
     * @return type
     */
    protected function simpanTandaBuktiBayar($model, $modTandabukti, $post){
        $modTandabukti->attributes=$model->attributes;
        $modTandabukti->attributes=$post;
        $modTandabukti->ruangan_id = Yii::app()->user->getState('ruangan_id');
        $modTandabukti->nourutkasir = MyGenerator::noUrutKasir($modTandabukti->ruangan_id);
        $modTandabukti->nobuktibayar = MyGenerator::noBuktiBayar();
        $modTandabukti->shift_id=Yii::app()->user->getState('shift_id');
		$modTandabukti->tglbuktibayar = date("Y-m-d H:i:s");
        $modTandabukti->create_time=date('Y-m-d H:i:s');
        $modTandabukti->create_loginpemakai_id=Yii::app()->user->id;
        $modTandabukti->create_ruangan=Yii::app()->user->getState('ruangan_id');
        if(!$post['is_menggunakankartu']){//jika tidak menggunakan kartu
            $modTandabukti->dengankartu = null;
            $modTandabukti->bankkartu = null;
            $modTandabukti->nokartu = null;
            $modTandabukti->nostrukkartu = null;
        }
        if($modTandabukti->save()){
            $model->tandabuktibayar_id = $modTandabukti->tandabuktibayar_id;
            if($model->save()){
                $this->tandabuktibayar_tersimpan = true;
            }
        }
        return $modTandabukti;
    }
    /**
     * simpan BKPemakaianuangmukaT
     * @param type $model
     * @param type $modTandabukti
     * @param type $post
     * @return type
     */
    protected function simpanPemakaianUangMuka($model, $modPemakaianuangmuka, $post,$bayaruangmuka){
        $modPemakaianuangmuka->attributes=$model->attributes;
        $modPemakaianuangmuka->attributes=$post;
		$modPemakaianuangmuka->pendaftaran_id=$model->pendaftaran_id; //RSN-1195
        $modPemakaianuangmuka->bayaruangmuka_id=$bayaruangmuka->bayaruangmuka_id; //RSN-1195
        $modPemakaianuangmuka->tglpemakaian=date("Y-m-d H:i:s");
        $modPemakaianuangmuka->create_time=date('Y-m-d H:i:s');
        $modPemakaianuangmuka->create_loginpemakai_id=Yii::app()->user->id;
        $modPemakaianuangmuka->create_ruangan=Yii::app()->user->getState('ruangan_id');
        if($modPemakaianuangmuka->save()){
            $crit_uangmuka = new CDbCriteria();
			if(!empty($model->pendaftaran_id)){
				$crit_uangmuka->addCondition("pendaftaran_id = ".$model->pendaftaran_id);					
			}
			if(!empty($model->pasienadmisi_id)){
				$crit_uangmuka->addCondition("pasienadmisi_id = ".$model->pasienadmisi_id);					
			}
            $crit_uangmuka->addCondition("pemakaianuangmuka_id IS NULL");
            BayaruangmukaT::model()->updateAll(array('pemakaianuangmuka_id'=>$modPemakaianuangmuka->pemakaianuangmuka_id),$crit_uangmuka);
            $this->pemakaianuangmuka_tersimpan = true;
        }
        return $modPemakaianuangmuka;
    }
    /**
     * simpan BKBayarangsuranpelayananT
     * ubah BKPembayaranpelayananT.statusbayar
     * @param type $model
     * @param type $modTandabukti
     * @param modBayarangsuran $modBayarangsuran
     */
    protected function simpanBayarAngsuran($model,$modTandabukti,$modBayarangsuran){
        $modBayarangsuran = new $modBayarangsuran;
        $modBayarangsuran->tandabuktibayar_id = $modTandabukti->tandabuktibayar_id;
        $modBayarangsuran->pembayaranpelayanan_id = $model->pembayaranpelayanan_id;
        $modBayarangsuran->tglbayarangsuran = date("Y-m-d H:i:s");
        $modBayarangsuran->bayarke = 1;
        $modBayarangsuran->jmlbayarangsuran = $modTandabukti->uangditerima;
        $modBayarangsuran->sisaangsuran = $model->totalsisatagihan;
        $modBayarangsuran->create_time=date('Y-m-d H:i:s');
        $modBayarangsuran->create_loginpemakai_id=Yii::app()->user->id;
        $modBayarangsuran->create_ruangan=Yii::app()->user->getState('ruangan_id');
        
        if($modBayarangsuran->save()){
            $model->statusbayar = Params::STATUSBAYAR_BELUM_LUNAS;
            if($model->save()){
                $this->bayarangsuran_tersimpan = true;
            }
        }
    }
    /**
     * simpan BKTindakansudahbayarT
     * ubah BKTindakanpelayananT.tindakansudahbayar_id
     * @param type $model
     * @param type $modTindakansudahbayar
     * @param type $dataTindakans
     * @return array $dataTindakans (BKTindakanpelayananT)
     */
    protected function simpanBayarTindakans($model, $modTindakansudahbayar, $posts){
        $dataTindakans = array();
        $this->bayarsemuatindakanoa = true;
        if(count($posts) > 0){
            $this->tindakansudahbayar_tersimpan = true; //set true karna akan di looping
            foreach($posts AS $i => $post){
                $modTindakan = BKTindakanPelayananT::model()->findByPk($post['tindakanpelayanan_id']);
                $dataTindakans[$i] = $modTindakan;
                $dataTindakans[$i]->attributes = $post;
                $this->ubahTindakanPelayanan($post);
                if($post['is_pilihtindakan']){ //jika di ceklis
                    $modTindakansudahbayar = new $modTindakansudahbayar;
                    $modTindakansudahbayar->attributes=$post;
                    $modTindakansudahbayar->pembayaranpelayanan_id=$model->pembayaranpelayanan_id;
                    $modTindakansudahbayar->ruangan_id=Yii::app()->user->getState('ruangan_id');
                    $modTindakansudahbayar->jmlbiaya_tindakan=($post['qty_tindakan'] * $post['tarif_satuan']) +  $post['tarifcyto_tindakan'];
                    $modTindakansudahbayar->jmlpembebasan=$post['pembebasan_tindakan'];
                    $modTindakansudahbayar->jmlsubsidi_asuransi=$post['subsidiasuransi_tindakan'];
                    $modTindakansudahbayar->jmlsubsidi_pemerintah=0; //tidak digunakan lagi
                    $modTindakansudahbayar->jmlsubsidi_rs=$post['subsisidirumahsakit_tindakan']; 
                    $modTindakansudahbayar->jmliurbiaya=$post['iurbiaya_tindakan']; 
                    $modTindakansudahbayar->jmlbayar_tindakan=$post['subtotal'];
                    $modTindakansudahbayar->jmlsisabayar_tindakan=0; 
                    if($modTindakansudahbayar->save()){
                        if(TindakanpelayananT::model()->updateByPk($post['tindakanpelayanan_id'],array('tindakansudahbayar_id'=>$modTindakansudahbayar->tindakansudahbayar_id))){ 
                            $this->tindakansudahbayar_tersimpan = $this->tindakansudahbayar_tersimpan && true;
                        }else{
                            $this->tindakansudahbayar_tersimpan = false;
                        }
                    }
                }else{
                    $this->bayarsemuatindakanoa = false; //ada yg di uncheck berarti belum lunas
                }
            }
        }
        return $dataTindakans;
    }

    protected function ubahTindakanPelayanan($post){
        $modTindakan = BKTindakanPelayananT::model()->findByPk($post['tindakanpelayanan_id']);
        $modTindakan->attributes = $post;
        $modTindakan->tgl_tindakan = MyFormatter::formatDateTimeForDb($modTindakan->tgl_tindakan);
        if($modTindakan->update()){
            $this->ubahTindakanKomponen($modTindakan);
        }
    }

    protected function ubahTindakanKomponen($modTindakan){
        $dataTarif = $this->getDataTarifTindakanKomponen($modTindakan);
        $modKomponens = BKTindakankomponenT::model()->findAllByAttributes(array('tindakanpelayanan_id'=>$modTindakan->tindakanpelayanan_id));
        if(count($dataTarif)>0){
            if($dataTarif[Params::KOMPONENTARIF_ID_TOTAL]['harga_tariftindakan']==$modTindakan->subsidiasuransi_tindakan){
                foreach ($modKomponens as $i => $komponen){
                    $komponen->subsidiasuransikomp =  $dataTarif[$komponen->komponentarif_id]['harga_tariftindakan'];
                    $komponen->update();
                }
            }else{
                foreach ($modKomponens as $i => $komponen){
                    $komponen->subsidiasuransikomp = ($modKomponen->tarif_kompsatuan * $modTindakan->subsidiasuransi_tindakan)/($modTindakan->qty_tindakan*$modTindakan->tarif_satuan);
                    $komponen->update();
                }
            }
        }
    }

    protected function getDataTarifTindakanKomponen($modTindakan){
        $modPendaftaran = PendaftaranT::model()->findByPk($modTindakan->pendaftaran_id);
        $modAsuransipasien = AsuransipasienM::model()->findByPk($modPendaftaran->asuransipasien_id);
        $tarif = array();
        if($modAsuransipasien){
            $modTanggungan = TanggunganpenjaminM::model()->findByAttributes(array('kelaspelayanan_id'=>$modAsuransipasien->kelastanggunganasuransi_id,'penjamin_id'=>$modAsuransipasien->penjamin_id));
            if($modTanggungan){
                $sql_tarif = "SELECT tariftindakan_m.* 
                        FROM tariftindakan_m 
                        JOIN jenistarifpenjamin_m ON jenistarifpenjamin_m.jenistarif_id = tariftindakan_m.jenistarif_id
                        WHERE daftartindakan_id = ".$modTindakan->daftartindakan_id."
                        AND tariftindakan_m.kelaspelayanan_id = ".$modTanggungan->kelaspelayanan_id."
                        AND jenistarifpenjamin_m.penjamin_id = ".$modTanggungan->penjamin_id;
                $dataTarifs = Yii::app()->db->createCommand($sql_tarif)->queryAll();
                if(count($dataTarifs)>0){
                    foreach ($dataTarifs as $i => $data){
                       $tarif[$data['komponentarif_id']] = $data;
                    }
                }
            }
        }

        return $tarif;
    }
    
    /**
     * simpan BKOasudahbayarT
     * ubah BKObatalkesPasienT.oasudahbayar_id
     * @param type $model
     * @param $modOasudahbayar $modOasudahbayar
     * @param type $posts
     * @return type
     */
    protected function simpanBayarOas($model, $modOasudahbayar, $posts){
        $dataOas = array();
        $this->bayarsemuatindakanoa = true;
        if(count($posts) > 0){
            $dataTindakans = $posts;
            $this->oasudahbayar_tersimpan = true; //set true karna akan di looping
            foreach($posts AS $i => $post){
                $modOaPasien = BKObatalkesPasienT::model()->findByPk($post['obatalkespasien_id']);
                $dataOas[$i] = $modOaPasien;
                $dataOas[$i]->attributes = $post;
                if($post['is_pilihoa']){ //jika di ceklis
                    $modOasudahbayar = new $modOasudahbayar;
                    $modOasudahbayar->attributes=$post;
                    $modOasudahbayar->pembayaranpelayanan_id=$model->pembayaranpelayanan_id;
                    $modOasudahbayar->ruangan_id=Yii::app()->user->getState('ruangan_id');
                    $modOasudahbayar->qty_oa=$post['qty_oa'];
                    $modOasudahbayar->hargasatuan=$post['hargasatuan_oa'];
                    $modOasudahbayar->jmlsubsidi_asuransi=$post['subsidiasuransi'];
                    $modOasudahbayar->jmlsubsidi_pemerintah=0; //tidak digunakan lagi
                    $modOasudahbayar->jmlsubsidi_rs=$post['subsidirs']; 
                    $modOasudahbayar->jmliurbiaya=$post['iurbiaya']; 
                    $modOasudahbayar->jmlbayar_oa=$post['subtotaloa'];
                    $modOasudahbayar->jmlsisabayar_oa=0;
                    if($modOasudahbayar->save()){
                        if(ObatalkespasienT::model()->updateByPk($post['obatalkespasien_id'],array('oasudahbayar_id'=>$modOasudahbayar->oasudahbayar_id))){
                            $this->oasudahbayar_tersimpan = $this->oasudahbayar_tersimpan && true;
                        }else{
                            $this->oasudahbayar_tersimpan = false;
                        }
                    }
                }else{
                    $this->bayarsemuatindakanoa = false; //ada yg di uncheck berarti belum lunas
                }
            }
        }
        return $dataOas;
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
                $pendaftaran_id = (isset($_POST['pendaftaran_id']) ? $_POST['pendaftaran_id'] : null);
                $pasienadmisi_id = (isset($_POST['pasienadmisi_id']) ? $_POST['pasienadmisi_id'] : null);
				if(!empty($pendaftaran_id)){
					$criteria->addCondition("pendaftaran_id = ".$pendaftaran_id);					
				}
				if(!empty($pasienadmisi_id)){
					$criteria->addCondition("pasienadmisi_id = ".$pasienadmisi_id);					
				}
                if($_POST['instalasi_id'] == Params::INSTALASI_ID_RJ){
                    $modKunjungan = BKInformasikasirrawatjalanV::model()->find($criteria);
                }else if($_POST['instalasi_id'] == Params::INSTALASI_ID_RD){
                    $modKunjungan = BKInformasikasirrdpulangV::model()->find($criteria);
                }else if($_POST['instalasi_id'] == Params::INSTALASI_ID_RI){
                    $modKunjungan = BKInformasikasirinappulangV::model()->find($criteria);
                }
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
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if(isset($_POST['ajax']) && $_POST['ajax']==='bkpembayaranpelayanan-t-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
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
            $criteria = new CDbCriteria();
            $criteria->compare('LOWER(no_pendaftaran)', strtolower($no_pendaftaran), true);
            $criteria->compare('LOWER(no_rekam_medik)', strtolower($no_rekam_medik), true);
            $criteria->compare('LOWER(nama_pasien)', strtolower($nama_pasien), true);
            $criteria->order = 'no_pendaftaran, no_rekam_medik, nama_pasien';
            $criteria->limit = 5;
            if($instalasi_id == Params::INSTALASI_ID_RJ){
                $models = BKInformasikasirrawatjalanV::model()->findAll($criteria);
            }else if($instalasi_id == Params::INSTALASI_ID_RD){
                $models = BKInformasikasirrdpulangV::model()->findAll($criteria);
            }else if($instalasi_id == Params::INSTALASI_ID_RI){
                $models = BKInformasikasirinappulangV::model()->findAll($criteria);
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
			if(!empty($pendaftaran_id)){
				$criteria->addCondition("pendaftaran_id = ".$pendaftaran_id);					
			}
			if(!empty($pasienadmisi_id)){
				$criteria->addCondition("pasienadmisi_id = ".$pasienadmisi_id);					
			}
			if(!empty($instalasi_id)){
				$criteria->addCondition("instalasi_id = ".$instalasi_id);					
			}
            $criteria->compare('LOWER(no_pendaftaran)',strtolower(trim($no_pendaftaran)));
            $criteria->compare('LOWER(no_rekam_medik)',strtolower(trim($no_rekam_medik)));
            if($instalasi_id == Params::INSTALASI_ID_RJ){
                $model = BKInformasikasirrawatjalanV::model()->find($criteria);
            }else if($instalasi_id == Params::INSTALASI_ID_RD){
                $model = BKInformasikasirrdpulangV::model()->find($criteria);
            }else if($instalasi_id == Params::INSTALASI_ID_RI){
                $model = BKInformasikasirinappulangV::model()->find($criteria);
            }
            
            $attributes = $model->attributeNames();
            foreach($attributes as $j=>$attribute) {
                $returnVal["$attribute"] = $model->$attribute;
            }
            
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
            //perubahan pengambilan uang muka (RSN-1195)
			$modBayarUangMuka = BKBayaruangmukaT::model()->findByAttributes(array('pendaftaran_id'=>$pendaftaran_id));
			if(count($modBayarUangMuka) > 0){
				$modPemakaianUangMuka = PemakaianuangmukaT::model()->findByAttributes(array('bayaruangmuka_id'=>$modBayarUangMuka->bayaruangmuka_id),array('order'=>'pemakaianuangmuka_id DESC','limit'=>1));
				if(count($modPemakaianUangMuka) > 0){
					$returnVal["jumlahuangmuka"] = (isset($modPemakaianUangMuka->sisauangmuka) ? $modPemakaianUangMuka->sisauangmuka : 0);
				}else{
					$crit_uangmuka->addCondition("pemakaianuangmuka_id IS NULL");
					$crit_uangmuka->addCondition("pembatalanuangmuka_id IS NULL");
					$crit_uangmuka->select = "sum(jumlahuangmuka) as jumlahuangmuka";
					$modUangMuka = BKBayaruangmukaT::model()->find($crit_uangmuka);
					$returnVal["jumlahuangmuka"] = (isset($modUangMuka->jumlahuangmuka) ? $modUangMuka->jumlahuangmuka : 0);
				}
			}
			echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }
    
    /**
     * menampilkan form rincian tagihan tindakan
     */
    public function actionSetRincianTindakan(){
        if(Yii::app()->request->isAjaxRequest) { 
            $format = new MyFormatter();
            $pendaftaran_id=(isset($_POST['pendaftaran_id']) ? $_POST['pendaftaran_id'] : null);
            $pasienadmisi_id=(isset($_POST['pasienadmisi_id']) ? $_POST['pasienadmisi_id'] : null);
            $kelaspelayanan_id=(isset($_POST['kelaspelayanan_id']) ? $_POST['kelaspelayanan_id'] : null);
            $pasien_id = (isset($_POST['pasien_id']) ? $_POST['pasien_id'] : null);
            $penjamin_id = (isset($_POST['penjamin_id']) ? $_POST['penjamin_id'] : null);
            $modPendaftaran = new PendaftaranT;
            $modAsuransiPasien = new AsuransipasienM;
            $modTanggungan = new TanggunganpenjaminM;
            $form='';
            if(isset($pendaftaran_id)){
                $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
                if(isset($modPendaftaran->asuransipasien_id)){
                    $modAsuransiPasien = AsuransipasienM::model()->findByPk($modPendaftaran->asuransipasien_id);
                    if(isset($modAsuransiPasien->kelastanggunganasuransi_id)&&isset($penjamin_id)){
                        $modTanggungan = TanggunganpenjaminM::model()->findByAttributes(array('kelaspelayanan_id'=>$modAsuransiPasien->kelastanggunganasuransi_id,'penjamin_id'=>$penjamin_id));
                    }
                }
            }
            $dataTindakans = array();
            if(!empty($pendaftaran_id)){
                $criteria = new CdbCriteria();
                $criteria->addCondition("pendaftaran_id = ".$pendaftaran_id);
//                ADA BEBERAPA TINDAKAN YG TIDAK TERBAYAR >> RND-3592
//                TINDAKAN SELAIN ADMISI JUGA BOLEH DI BAYARKAN DISINI
//                if(!empty($pasienadmisi_id)){
//                    $criteria->addCondition("pasienadmisi_id = ".$pasienadmisi_id);
//                }else{
//                    $criteria->addCondition("pasienadmisi_id IS NULL");
//                }
                $criteria->addCondition("tindakansudahbayar_id IS NULL");
                $criteria->order = "ruangan_id, tgl_tindakan";
                $dataTindakans=BKTindakanPelayananT::model()->findAll($criteria);
            }
            $form = $this->renderPartial($this->path_view.'_formRincianTindakan',array('dataTindakans'=>$dataTindakans,'modTanggungan'=>$modTanggungan),true);
            $data['form']=$form;
            echo json_encode($data);
            Yii::app()->end();
        }
    }
    
    /**
     * menampilkan form rincian tagihan obat alkes
     */
    public function actionSetRincianObatalkes(){
        if(Yii::app()->request->isAjaxRequest) { 
            $format = new MyFormatter();
            $pendaftaran_id=(isset($_POST['pendaftaran_id']) ? $_POST['pendaftaran_id'] : null);
            $pasienadmisi_id=(isset($_POST['pasienadmisi_id']) ? $_POST['pasienadmisi_id'] : null);
            $kelaspelayanan_id=(isset($_POST['kelaspelayanan_id']) ? $_POST['kelaspelayanan_id'] : null);
            $pasien_id = (isset($_POST['pasien_id']) ? $_POST['pasien_id'] : null);
            $penjamin_id = (isset($_POST['penjamin_id']) ? $_POST['penjamin_id'] : null);
            $form='';
            $dataOas = array();
            if(!empty($pendaftaran_id)){
                $criteria = new CdbCriteria();
                $criteria->addCondition("pendaftaran_id = ".$pendaftaran_id);
//                ADA BEBERAPA TINDAKAN YG TIDAK TERBAYAR >> RND-3592
//                TINDAKAN SELAIN ADMISI JUGA BOLEH DI BAYARKAN DISINI
//                if(!empty($pasienadmisi_id)){
//                    $criteria->addCondition("pasienadmisi_id = ".$pasienadmisi_id);
//                }else{
//                    $criteria->addCondition("pasienadmisi_id IS NULL");
//                }
                $criteria->addCondition("oasudahbayar_id IS NULL");
                $criteria->order = "tglpelayanan";
                $dataOas=BKObatalkesPasienT::model()->findAll($criteria);
            }
            $form = $this->renderPartial($this->path_view.'_formRincianObatalkes',array('dataOas'=>$dataOas),true);
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
    public function actionPrintRincianBelumBayar($instalasi_id,$pendaftaran_id,$pasienadmisi_id=null){
        $this->layout='//layouts/printWindows';
        if (isset($_GET['frame'])){
            $this->layout='//layouts/iframe';
        }
        $modRincians = null;
        if($instalasi_id == Params::INSTALASI_ID_RJ){
            $criteria = new CDbCriteria();
            $criteria->addCondition('pendaftaran_id = '.$pendaftaran_id);
            $criteria->order = 'unitlayanan_nama, tgl_tindakan';
            $modRincians = BKRincianbelumbayarrjV::model()->findAll($criteria);
			$modPendaftaran=PendaftaranT::model()->findByPk($pendaftaran_id);
        }else if($instalasi_id == Params::INSTALASI_ID_RD){
            $criteria = new CDbCriteria();
            $criteria->addCondition('pendaftaran_id = '.$pendaftaran_id);
            $criteria->order = 'ruangantindakan_id';
            $modRincians = BKRincianbelumbayarrdV::model()->findAll($criteria);
            $modPendaftaran=PendaftaranT::model()->findByPk($pendaftaran_id);
        }else if($instalasi_id == Params::INSTALASI_ID_RI || $instalasi_id == Params::INSTALASI_ID_ICU){
            $criteria = new CDbCriteria();
            $criteria->addCondition('pendaftaran_id = '.$pendaftaran_id);
            $criteria->addCondition('pasienadmisi_id = '.$pasienadmisi_id);
            $criteria->order = 'ruangantindakan_id';
            $criteria->order = 'tgl_tindakan';
            $modRincians = BKRincianbelumbayarrawatinapV::model()->findAll($criteria);
            $modPendaftaran=PendaftaranT::model()->findByPk($pendaftaran_id);
        }
        
        $modInstalasi = InstalasiM::model()->findByPk($instalasi_id);
        $this->render($this->path_view.'printRincianBelumBayar', array('modRincians'=>$modRincians,'modPendaftaran'=>$modPendaftaran, 'modInstalasi'=>$modInstalasi));
    }
    /**
     * actionPrintDetailRincianBelumBayar 
     * @params $instalasi_id = RJ / RD / RI
     * @params $pendaftaran_id
     * @params $pasienadmisi_id (RI saja)
     */
    public function actionPrintDetailRincianBelumBayar($instalasi_id,$pendaftaran_id,$pasienadmisi_id=null){
        $this->layout='//layouts/printWindows';
        if (isset($_GET['frame'])){
            $this->layout='//layouts/iframe';
        }
        $modRincians = null;
        if($instalasi_id == Params::INSTALASI_ID_RJ){
            $criteria = new CDbCriteria();
            $criteria->addCondition('pendaftaran_id = '.$pendaftaran_id);
            $criteria->order = 'unitlayanan_nama, tgl_tindakan';
            $modRincians = BKRincianbelumbayarrjV::model()->findAll($criteria);
        }else if($instalasi_id == Params::INSTALASI_ID_RD){
            $criteria = new CDbCriteria();
            $criteria->addCondition('pendaftaran_id = '.$pendaftaran_id);
            $criteria->order = 'ruangantindakan_id';
            $modRincians = BKRincianbelumbayarrdV::model()->findAll($criteria);
            $modPendaftaran=PendaftaranT::model()->findByPk($pendaftaran_id);
        }else if($instalasi_id == Params::INSTALASI_ID_RI || $instalasi_id == Params::INSTALASI_ID_ICU){
            $criteria = new CDbCriteria();
            $criteria->addCondition('pendaftaran_id = '.$pendaftaran_id);
            $criteria->addCondition('pasienadmisi_id = '.$pasienadmisi_id);
            $criteria->order = 'ruangantindakan_id';
            $modRincians = BKRincianbelumbayarrawatinapV::model()->findAll($criteria);
        }
		$modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
        $this->render($this->path_view.'printDetailRincianBelumBayar', array('modRincians'=>$modRincians,'modPendaftaran'=>$modPendaftaran));
    }
    
    /**
     * actionPrintRincianSudahBayar = menampilkan rincian yang sudah lunas /bayar
     * @params $instalasi_id = RJ / RD / RI
     * @params $pembayaran_id
     */
    public function actionPrintRincianSudahBayar($pembayaranpelayanan_id){
        $this->layout='//layouts/printWindows';
        if (isset($_GET['frame'])){
            $this->layout='//layouts/iframe';
        }
        $modRincians = null;
        $modPembayaran = BKPembayaranpelayananT::model()->findByPk($pembayaranpelayanan_id);
        $criteria = new CDbCriteria();
        $criteria->addCondition('pendaftaran_id = '.$modPembayaran->pendaftaran_id);
        $criteria->addCondition('pembayaranpelayanan_id = '.$pembayaranpelayanan_id);
        $criteria->addCondition('tindakansudahbayar_id IS NOT NULL'); //sudah lunas
        $criteria->order = 'instalasi_id, ruangan_id, tgl_tindakan';
        $modRincians = BKRinciantagihanpasiensudahbayarV::model()->findAll($criteria);
		$modPendaftaran = PendaftaranT::model()->findByPk($modPembayaran->pendaftaran_id);
        $this->render($this->path_view.'printRincianSudahBayar', array('modRincians'=>$modRincians,'modPendaftaran'=>$modPendaftaran));
    }
    /**
     * actionPrintRincianSudahBayar = menampilkan rincian yang sudah lunas /bayar
     * @params $instalasi_id = RJ / RD / RI
     * @params $pembayaran_id
     */
    public function actionPrintRincianRSSudahBayar($pembayaranpelayanan_id){
        $this->layout='//layouts/printWindows';
        if (isset($_GET['frame'])){
            $this->layout='//layouts/iframe';
        }
        $modRincians = null;
        $modPembayaran = BKPembayaranpelayananT::model()->findByPk($pembayaranpelayanan_id);
        $criteria = new CDbCriteria();
        $criteria->addCondition('pendaftaran_id = '.$modPembayaran->pendaftaran_id);
        $criteria->addCondition('pembayaranpelayanan_id = '.$pembayaranpelayanan_id);
        $criteria->addCondition('tindakansudahbayar_id IS NOT NULL'); //sudah lunas
        $criteria->order = 'instalasi_id, ruangan_id, tgl_tindakan';
        $modRincians = BKRinciantagihanpasiensudahbayarV::model()->findAll($criteria);
		$modPendaftaran = PendaftaranT::model()->findByPk($modPembayaran->pendaftaran_id);
        $this->render($this->path_view.'printRincianRSSudahBayar', array('modRincians'=>$modRincians,'modPendaftaran'=>$modPendaftaran));
    }
    
    /**
     * method untuk print kwitansi
     * @param int $pembayaranpelayanan_id pembayaranpelayanan_id
     */
    public function actionPrintKuitansi($pembayaranpelayanan_id)
    {
        $judulKuitansi = '----- KUITANSI -----';
        $format = new MyFormatter();
        $modBayar = PembayaranpelayananT::model()->findByPk($pembayaranpelayanan_id);
        $modTandaBukti = TandabuktibayarT::model()->findByPk($modBayar->tandabuktibayar_id);
        $criteria = new CdbCriteria();
        $criteria->addCondition('pembayaranpelayanan_id = '.$pembayaranpelayanan_id);
        $tindakanSudahBayar = TindakansudahbayarT::model()->findAll($criteria);
        if(!empty($modBayar->pendaftaran_id)){
            $modPendaftaran = PendaftaranT::model()->findByPk($modBayar->pendaftaran_id);
            $modPendaftaran->tgl_pendaftaran = $format->formatDateTimeForDb($modBayar->pendaftaran->tgl_pendaftaran);
        }else{
            $modPendaftaran = new PendaftaranT;
        }
        $rincianpembayaran = array();
        $tindakan = array();
        $harga = 0;
		$discount = 0;
		$totalsemua = 0;
        if (count($tindakanSudahBayar) > 0){
            $totalTindakan=0;
            foreach ($tindakanSudahBayar as $key => $value) {
                $tindakan[$value->daftartindakan->kelompoktindakan_id]['kelompoktindakan'] = $value->daftartindakan->kelompoktindakan->kelompoktindakan_nama;
                $harga += $value->jmlbiaya_tindakan;
                $tindakan[$value->daftartindakan->kelompoktindakan_id]['harga'] = $harga;
                $discount += $value->tindakanpelayanan->discount_tindakan;
                $tindakan[$value->daftartindakan->kelompoktindakan_id]['discount'] = $discount;
                $totalTindakan += ($value->jmlbiaya_tindakan - $value->tindakanpelayanan->discount_tindakan);
            }
            $rincianpembayaran['tindakan'] = $tindakan;
            $rincianpembayaran['tindakan']['totalTindakan'] = $totalTindakan;
			$totalsemua += $totalTindakan;
        }
        $oaSudahBayar = OasudahbayarT::model()->findAll($criteria);
        $oa = array();
        if (count($oaSudahBayar) > 0 ){
            $totalOa=0;
            $oa[0]['harga'] = 0;
            $oa[0]['discount'] = 0;
            $oa[0]['biayaadministrasi'] = 0;
            $oa[0]['biayaservice'] = 0;
            $oa[0]['biayakonseling'] = 0;
            foreach ($oaSudahBayar as $key => $value) {
                    $oa[0]['kelompoktindakan'] = ($value->obatalkes->jenisobatalkes) ? $value->obatalkes->jenisobatalkes->jenisobatalkes_nama : "-";
                    $oa[0]['harga'] += ($value->obatalkespasien->hargasatuan_oa * $value->obatalkespasien->qty_oa);
                    $discount = ($value->obatalkespasien->discount > 0 ) ? $value->obatalkespasien->discount/100 : 0 ;
                    $oa[0]['discount'] += ($discount*$value->obatalkespasien->hargasatuan_oa * $value->obatalkespasien->qty_oa);
                    $oa[0]['biayaadministrasi'] += $value->obatalkespasien->biayaadministrasi;
                    $oa[0]['biayaservice'] += $value->obatalkespasien->biayaservice;
                    $oa[0]['biayakonseling'] += $value->obatalkespasien->biayakonseling;
                    $totalOa += (($value->obatalkespasien->hargasatuan_oa * $value->obatalkespasien->qty_oa) - $oa[0]['discount'] + $oa[0]['biayaadministrasi'] + $oa[0]['biayaservice'] + $oa[0]['biayakonseling']);
            }
            $rincianpembayaran['oa'] = $oa;
            $rincianpembayaran['oa']['totalOa'] = $totalOa;
			$totalsemua += $totalOa;
        }

        if($modTandaBukti->jmlpembayaran == 0 && $modBayar->carabayar_id != 2)
        { //jika jmlpembayaran nol
            $modTandaBukti->jmlpembayaran = $totalsemua;
        }

        $caraPrint=$_REQUEST['caraPrint'];
        if($caraPrint=='PRINT') {
            $this->layout='//layouts/printWindows';
            $this->render($this->path_view.'printKuitansi', array( 'modPendaftaran'=>$modPendaftaran, 'judulKuitansi'=>$judulKuitansi, 'caraPrint'=>$caraPrint, 'rincianpembayaran'=>$rincianpembayaran,
                                   'modTandaBukti'=>$modTandaBukti,
                                   'modBayar'=>$modBayar));
            //$this->render('rincian',array('model'=>$model,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint));
        }
        else if($caraPrint=='EXCEL') {
            $this->layout='//layouts/printExcel';
            $this->render($this->path_view.'printKuitansi',array( 'modPendaftaran'=>$modPendaftaran, 'judulKuitansi'=>$judulKuitansi, 'caraPrint'=>$caraPrint,'rincianpembayaran'=>$rincianpembayaran,
                                   'modTandaBukti'=>$modTandaBukti,
                                   'modBayar'=>$modBayar));
        }
        else if($_REQUEST['caraPrint']=='PDF') {
//                $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
            //$ukuranKertasPDF = 'KW';                  //Ukuran Kertas Pdf
            $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
            //$mpdf = new MyPDF('',$ukuranKertasPDF); 
            //$mpdf = new MyPDF('','B5-L');
            $mpdf = new MyPDF('','','15', '', 15, 15, 16, 16, 9, 9, 'B5');                
            $mpdf->useOddEven = 2;  
            $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
            $mpdf->WriteHTML($stylesheet,1); 
            /*
             * cara ambil margin
             * tinggi_header * 72 / (72/25.4)
             *  tinggi_header = inchi
             */

            /*font-family: tahoma;*/
            // $header = 0.50 * 72 / (72/25.4);
            $header = 0.3 * 72 / (72/25.4);
            $mpdf->AddPage($posisi,'','','','',3,8,$header,5,0,0);
            $mpdf->WriteHTML(
                $this->renderPartial(
                    $this->path_view.'printKuitansiPdf',
                    array(
                        'model'=>$model,
                        'pembayarans'=>$pembayarans,
                        'modPendaftaran'=>$modPendaftaran,
                        'judulKuitansi'=>$judulKuitansi,
                        'caraPrint'=>$caraPrint,
                        'rincianpembayaran'=>$rincianpembayaran,
                                   'modTandaBukti'=>$modTandaBukti,
                                   'modBayar'=>$modBayar
                    ),true
                )
            );
            $mpdf->Output();
        }                       
    }

    /**
     * menampilkan form antrian dari request ajax
     * @param type $record
     * @param type $noantrian
     * @throws CHttpException
     */
    public function actionSetFormAntrian(){
        if(Yii::app()->request->isAjaxRequest)
        {
            $format = new MyFormatter();
            $data = array();
            $data['pesan'] = "";
            $record = (isset($_POST['record']) ? $_POST['record'] : "");
            $noantrian = (isset($_POST['noantrian']) ? $_POST['noantrian'] : "");
            $antrian_id = (isset($_POST['antrian_id']) ? $_POST['antrian_id'] : "");
            $loket_id = (isset($_POST['loket_id']) ? $_POST['loket_id'] : null);
            if(empty($antrian_id)){ //antrian baru
                $criteria = new CDbCriteria();
                $criteria->compare('DATE(tglantrian)', date("Y-m-d"));
                $criteria->addCondition("pendaftaran_id IS NOT NULL");
                $criteria->addCondition("ruangan_id =". Yii::app()->user->getState('ruangan_id'));
                if($record == "reset"){
                    $criteria->addCondition("panggil_flaq = false");
                }
                $criteria->order = "noantrian ASC";
                $criteria->limit = 1;
                $modAntrian =  BKAntrianT::model()->find($criteria);
            }else{
                $criteria = new CDbCriteria();
                $criteria->compare('DATE(tglantrian)', date("Y-m-d"));
                $criteria->addCondition("ruangan_id =". Yii::app()->user->getState('ruangan_id'));
                if(!empty($antrian_id)){$criteria->addCondition("antrian_id = ".$antrian_id); }
                $cari =  BKAntrianT::model()->find($criteria);
                if($record == 'next'){
                    $modAntrian = $cari->AntrianBerikut;
                }else if($record == 'prev'){
                    $modAntrian = $cari->AntrianSebelum;
                }else{
                    $modAntrian = $cari;
                }
            }

            if(!isset($modAntrian)){
                $modAntrian = new BKAntrianT;
                $data['pesan'] = "Antrian Habis !";
            }
            $modAntrian->tglantrian = $format->formatDateTimeForUser($modAntrian->tglantrian);
            $modAntrian->loket_id = $loket_id;
            $data['form_antrian'] = $this->renderPartial($this->path_view.'_formPanggilAntrian',array('modAntrian'=>$modAntrian),true);
            echo CJSON::encode($data);
            Yii::app()->end();
        }
        else
            throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
    }

    /**
     * action ketika tombol panggil di klik
     */
    public function actionPanggil($antrian_id,$loket_id,$ket=null){
        if(Yii::app()->request->isAjaxRequest)
        {
            $format = new MyFormatter();
            $data = array();
            $data['pesan']="";
            $modAntrian =  BKAntrianT::model()->findByPk($antrian_id);
            if(isset($modAntrian)){
                if($modAntrian->panggil_flaq == true){
                    if($ket == "batal"){
                        $modAntrian->panggil_flaq = false;
                        if($modAntrian->update()){
    //                            $data['pesan'] = "Pemanggilan no. antrian ".$modAntrian->noantrian." dibatalkan !";
                        }
                    }else{
                        $data['pesan'] = "No. antrian ".$modAntrian->noantrian." sudah dipanggil sebelumnya !";
                    }
                }else{
                    $modAntrian->panggil_flaq = true;
                    $modAntrian->loket_id = $loket_id;
                    if($modAntrian->update()){
    //                        $data['pesan'] = "No. antrian ".$modAntrian->noantrian." dipanggil !";
                    }
                }
            }
            $attributes = $modAntrian->attributeNames();
            foreach($attributes as $i=>$attribute) {
                $data["$attribute"] = $modAntrian->$attribute;
            }
            echo CJSON::encode($data);
            Yii::app()->end();
        }
        else
            throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
    }


    
}
