<?php
Yii::import('billingKasir.controllers.PembayaranTagihanPasienController');
class PembayaranPenjualanApotekController extends PembayaranTagihanPasienController
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
     * layout frame=1 -> frameDialog
     */
    public function actionIndex($id=null)
    {
        $format = new MyFormatter();
        $modPenjualan=new BKInformasipenjualanaresepV;
        $model=new BKPembayaranpelayananT;
        $modTandabukti = new BKTandabuktibayarT;
        $modTandabukti->is_menggunakankartu = 0;
        $modOasudahbayar = new BKOasudahbayarT();
        $modPemakaianuangmuka = new BKPemakaianuangmukaT;
        $modBayarangsuran = new BKBayarangsuranpelayananT;
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
       
	if(isset($_GET['penjualanresep_id'])){
            $modPenjualan = BKInformasipenjualanaresepV::model()->findByAttributes(array('penjualanresep_id'=>$_GET['penjualanresep_id']));
            $model->noresep = $modPenjualan->noresep;
        }
        
        if(isset($_GET['frame'])){
            $this->layout = "//layouts/iframe";
        }
        
        
        if(isset($_POST['penjualanresep_id']) && isset($_POST['BKPembayaranpelayananT']) && (isset($_POST['BKTindakanPelayananT']) || isset($_POST['BKObatalkesPasienT'])))
        {
            $transaction = Yii::app()->db->beginTransaction();
            try {
                $modPenjualan->attributes = $_POST;
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
                if(isset($_POST['BKObatalkesPasienT'])){
                    $dataOas = $this->simpanBayarOas($model, $modOasudahbayar, $_POST['BKObatalkesPasienT']);
                }else{
                    $this->oasudahbayar_tersimpan = true; //bypass oa jika tidak ada
                }                
                
                if($this->pembayaranpelayanan_tersimpan && $this->tandabuktibayar_tersimpan && $this->oasudahbayar_tersimpan && $this->pemakaianuangmuka_tersimpan && $this->bayarangsuran_tersimpan){
                    //Di set di form >> Yii::app()->user->setFlash('success', 'Data pembayaran berhasil disimpan !');
                    
                    // SMS GATEWAY
                    $modPasien = $model->pasien;
                    $modPegawai = PegawaiM::model()->findByPk($modPenjualan->pegawai_id);
                    $sms = new Sms();
                    $smspasien = 1;
                    $smspegawai = 1;
                    // echo "<pre>";print_r($modPenjualan->attributes); exit();
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
                        if(isset($modPegawai)){
                            $attributes = $modPegawai->getAttributes();
                            foreach($attributes as $attributes => $value){
                                $isiPesan = str_replace("{{".$attributes."}}",$value,$isiPesan);
                            }  
                        }
                        $isiPesan = str_replace("{{hari}}",MyFormatter::getDayName($modTandabukti->tglbuktibayar),$isiPesan);
                        
                        if($smsgateway->tujuansms == Params::TUJUANSMS_PASIEN && $smsgateway->statussms){
                            if(!empty($modPasien->no_mobile_pasien)){
                                $sms->kirim($modPasien->no_mobile_pasien,$isiPesan);
                            }else{
                                $smspasien = 0;
                            }
                        }
                        if($smsgateway->tujuansms == Params::TUJUANSMS_PEGAWAI && $smsgateway->statussms){
                            if(!empty($modPasien->no_mobile_pasien)){
                                $sms->kirim($modPegawai->nomobile_pegawai,$isiPesan);
                            }else{
                                $smspegawai = 0;
                            }
                        }
                        
                    }
                    // END SMS GATEWAY

                    $transaction->commit();
                    $this->redirect(array('index','id'=>$model->pembayaranpelayanan_id,'penjualanresep_id'=>$modPenjualan->penjualanresep_id,'sukses'=>1,'smspasien'=>$smspasien,'smspegawai'=>$smspegawai));
                }else{
                    Yii::app()->user->setFlash('error', 'Data pembayaran gagal disimpan !');
                    $model->isNewRecord = true;
                    $model->pembayaranpelayanan_id = null;
                    $transaction->rollback();
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
        
        $modPenjualan->tglpenjualan = $format->formatDateTimeForUser($modPenjualan->tglpenjualan);
        $modPenjualan->tanggal_lahir = $format->formatDateTimeForUser($modPenjualan->tanggal_lahir);

        $this->render('index',array(
            'model'=>$model,
            'modTandabukti'=>$modTandabukti,
            'modPenjualan'=>$modPenjualan,
            'dataOas'=>$dataOas,
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
                $jenispenjualan = (isset($_POST['jenispenjualan']) ? $_POST['jenispenjualan'] : null);
                $pendaftaran_id = (isset($_POST['pendaftaran_id']) ? $_POST['pendaftaran_id'] : null);
                $model = new BKInformasipenjualanaresepV;
                $model->jenispenjualan = $jenispenjualan;
                
                $penjualanresep_id = $_POST['penjualanresep_id'];
                
                if (in_array($_POST['pasien_id'], array(3,4,5))) {
                    $criteria->addCondition("penjualanresep_id = ".$penjualanresep_id);
                } else {
                    $criteria = $model->criteriaGroupByPenjualan();
                                    if(!empty($pendaftaran_id)){
                                            $criteria->addCondition("pendaftaran_id = ".$pendaftaran_id);					
                                    }
                                    
                }
                $modPenjualan = $model->find($criteria);
                // var_dump($modPenjualan->attributes); die;
                
                if (!empty($modPenjualan->pasienpegawai_id)) {
                    $p = PegawaiM::model()->findBypk($modPenjualan->pasienpegawai_id);
                    $modPenjualan->nama_pasien = $p->namaLengkap;
                    $modPenjualan->tanggal_lahir = MyFormatter::formatDateTimeForUser($p->tgl_lahirpegawai);
                    $modPenjualan->jeniskelamin = $p->jeniskelamin;
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
                'content'=>$this->renderPartial('verifikasi',array(
                    'format'=>$format,
                    'modPenjualan'=>$modPenjualan,
                    'model'=>$model,
                    'modTandabukti'=>$modTandabukti,
                    'modPemakaianuangmuka'=>$modPemakaianuangmuka,
            ), true)));
            exit;
        }
    }
        
    
    /**
    * untuk menampilkan data penjualan dari autocomplete
    */
    public function actionAutocompletePenjualan()
    {
        if(Yii::app()->request->isAjaxRequest) {
            $format = new MyFormatter();
            $returnVal = array();
            $jenispenjualan = isset($_GET['jenispenjualan']) ? $_GET['jenispenjualan'] : null;
            $noresep = isset($_GET['noresep']) ? $_GET['noresep'] : null;
            $no_rekam_medik = isset($_GET['no_rekam_medik']) ? $_GET['no_rekam_medik'] : null;
            $nama_pasien = isset($_GET['nama_pasien']) ? $_GET['nama_pasien'] : null;
            $model = new BKInformasipenjualanaresepV();
            $model->jenispenjualan = $jenispenjualan;
            $criteria = $model->criteriaGroupByPenjualan();
            $criteria->compare('LOWER(noresep)', strtolower($noresep), true);
            $criteria->compare('LOWER(no_rekam_medik)', strtolower($no_rekam_medik), true);
            $criteria->compare('LOWER(nama_pasien)', strtolower($nama_pasien), true);
            $criteria->order = 'noresep, no_rekam_medik, nama_pasien';
            $criteria->limit = 5;
            $models = $model->findAll($criteria);
            foreach($models as $i=>$model)
            {
                $attributes = $model->attributeNames();
                foreach($attributes as $j=>$attribute) {
                    $returnVal[$i]["$attribute"] = $model->$attribute;
                }
                $returnVal[$i]['label'] = $model->noresep.' - '.$model->no_rekam_medik.' - '.$model->nama_pasien.(!empty($model->nama_bin) ? "(".$model->nama_bin.")" : "");
                $returnVal[$i]['value'] = $model->noresep;
            }
            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }
    
    /**
     * Mengurai data penjualan
     * @throws CHttpException
     */
    public function actionGetDataPenjualan()
    {
        if(Yii::app()->request->isAjaxRequest) {
            $format = new MyFormatter();
            $jenispenjualan = isset($_POST['jenispenjualan']) ? $_POST['jenispenjualan'] : null;
            $penjualanresep_id = isset($_POST['penjualanresep_id']) ? $_POST['penjualanresep_id'] : null;
            $pendaftaran_id = isset($_POST['pendaftaran_id']) ? $_POST['pendaftaran_id'] : null;
            $pasienadmisi_id = isset($_POST['pasienadmisi_id']) ? $_POST['pasienadmisi_id'] : null;
            $noresep = isset($_POST['noresep']) ? $_POST['noresep'] : null;
            $no_rekam_medik = isset($_POST['no_rekam_medik']) ? $_POST['no_rekam_medik'] : null;
            $returnVal = array();
            $criteria = new CDbCriteria();
            $model = new BKInformasipenjualanaresepV;
            $model->jenispenjualan = $jenispenjualan;
            $criteria = $model->criteriaGroupByPenjualan();
			if(!empty($penjualanresep_id)){
				$criteria->addCondition("penjualanresep_id = ".$penjualanresep_id);					
			}
			if(!empty($pasienadmisi_id)){
				$criteria->addCondition("pasienadmisi_id = ".$pasienadmisi_id);					
			}
            $criteria->compare('LOWER(noresep)',strtolower($noresep));
            $criteria->compare('LOWER(no_rekam_medik)',strtolower($no_rekam_medik));
            $model = $model->find($criteria);
            $modPendaftaran = BKPendaftaranT::model()->findByPk($pendaftaran_id);
            $attributes = $model->attributeNames();
            
            foreach($attributes as $j=>$attribute) {
                $returnVal["$attribute"] = $model->$attribute;
            }
            $returnVal["tanggal_lahir"] = $format->formatDateTimeForUser($model->tanggal_lahir);
            $returnVal["tglpenjualan"] = $format->formatDateTimeForUser($model->tglpenjualan);
            if (!empty($modPendaftaran)) $returnVal["umur"] = $modPendaftaran->umur;
            $modPenunjangAkhir = $model->getPenunjangAkhir();
            $returnVal["ruangan_id"] = $modPenunjangAkhir->ruangan_id;
            $returnVal["ruangan_nama"] = $modPenunjangAkhir->ruangan_nama;
            if(!empty($model->pasienpegawai_id)){
                $modPegawai = PegawaiM::model()->findByPk($model->pasienpegawai_id);
                $gelardepan = (isset($modPegawai->gelardepan) ? $modPegawai->gelardepan : "");
                $gelarbelakang = (isset($modPegawai->gelarbelakang_id) ? $modPegawai->gelarbelakang->gelarbelakang_nama : "");
                $returnVal["nama_pasien"] = $gelardepan." ".$modPegawai->nama_pegawai." ".$gelarbelakang;
                $returnVal["tanggal_lahir"] = $format->formatDateTimeForUser($modPegawai->tgl_lahirpegawai);
                $returnVal["jeniskelamin"] = $modPegawai->jeniskelamin;
            }
            if(isset($jenispenjualan) && $jenispenjualan =='PENJUALAN UNIT'){
                $returnVal["nama_pasien"] = $model->instalasiasal_nama;
            }
            //load uang muka
            $modUangMuka = new BKBayaruangmukaT;
            if(isset($model->pendaftaran_id)){
                $crit_uangmuka = new CDbCriteria();
				if(!empty($model->pendaftaran_id)){
					$crit_uangmuka->addCondition("pendaftaran_id = ".$model->pendaftaran_id);					
				}
				if(!empty($model->pasienadmisi_id)){
					$crit_uangmuka->addCondition("pasienadmisi_id = ".$model->pasienadmisi_id);					
				}
                $crit_uangmuka->select = "sum(jumlahuangmuka) as jumlahuangmuka";
                $modUangMuka = BKBayaruangmukaT::model()->find($crit_uangmuka);
                $returnVal["jumlahuangmuka"] = (isset($modUangMuka->jumlahuangmuka) ? $modUangMuka->jumlahuangmuka : 0);
            }else{
                $returnVal["jumlahuangmuka"] = 0;
            }
            
            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }
    
    /**
     * menampilkan form rincian tagihan farmasi apotek
     */
    public function actionSetRincianObatalkes(){
        if(Yii::app()->request->isAjaxRequest) { 
            $format = new MyFormatter();
            $jenispenjualan=(isset($_POST['jenispenjualan']) ? $_POST['jenispenjualan'] : null);
            $penjualanresep_id=(isset($_POST['penjualanresep_id']) ? $_POST['penjualanresep_id'] : null);
            $pendaftaran_id=(isset($_POST['pendaftaran_id']) ? $_POST['pendaftaran_id'] : null);
            $pasienadmisi_id=(isset($_POST['pasienadmisi_id']) ? $_POST['pasienadmisi_id'] : null);
            $kelaspelayanan_id=(isset($_POST['kelaspelayanan_id']) ? $_POST['kelaspelayanan_id'] : null);
            $pasien_id = (isset($_POST['pasien_id']) ? $_POST['pasien_id'] : null);
            $penjamin_id = (isset($_POST['penjamin_id']) ? $_POST['penjamin_id'] : null);
            $form='';
            $dataOas = array();
            $res = null;
            if(!empty($penjualanresep_id)){
                $criteria = new CdbCriteria();
                $criteria->addCondition("penjualanresep_id = ".$penjualanresep_id);
                $criteria->addCondition("oasudahbayar_id IS NULL");
                $dataOas= BKObatalkesPasienT::model()->findAll($criteria);
                $res = BKPenjualanresepT::model()->findByPk($penjualanresep_id);
            }
            $form = $this->renderPartial('_formRincianPenjualanApotek',array('dataOas'=>$dataOas, 'data'=>$res),true);
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
    public function actionPrintRincianApotekSudahBayar($pembayaranpelayanan_id){
        $this->layout='//layouts/printWindows';
        $modOasudahbayar = BKOasudahbayarT::model()->find('pembayaranpelayanan_id = '.$pembayaranpelayanan_id);
        $modObatAlkesPasien = BKObatalkesPasienT::model()->find('obatalkespasien_id = '.$modOasudahbayar->obatalkespasien_id);
        $modPenjualan = BKPenjualanresepT::model()->find('penjualanresep_id = ' . $modObatAlkesPasien->penjualanresep_id . '');
        $criteria = new CDbCriteria();
        $criteria->addCondition('penjualanresep_id = '.$modPenjualan->penjualanresep_id);
        $criteria->addCondition('oasudahbayar_id is NOT NULL');
        $obatAlkes = BKObatalkesPasienT::model()->findAll($criteria);
        $daftar = BKPendaftaranT::model()->findByAttributes(array('pendaftaran_id'=>$obatAlkes[0]->pendaftaran_id));
        $pasien = BKPasienM::model()->findByAttributes(array('pasien_id'=>$obatAlkes[0]->pasien_id));

         $judulLaporan='Laporan Penerimaan Kas';
             $this->render('PrintPenjualanApotekSudahBayar',array('modPenjualan'=>$modPenjualan, 'daftar'=>$daftar,'pasien'=>$pasien,'obatAlkes'=>$obatAlkes, 'judulLaporan'=>$judulLaporan));
        
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
    
    /**
     * actionPrintRincianSudahBayar = menampilkan rincian yang sudah lunas /bayar
     * @params $instalasi_id = RJ / RD / RI
     * @params $pembayaran_id
     */
    public function actionPrintRincianSudahBayar($pembayaranpelayanan_id){
        $this->layout='//layouts/printWindows';
        $modPembayaran = BKPembayaranpelayananT::model()->findByPk($pembayaranpelayanan_id);
        $modPendaftaran = BKPendaftaranT::model()->findByPk($modPembayaran->pendaftaran_id);
        if(isset($modPendaftaran->pasien_id)){
            $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
        }else{
            $modPasien = PasienM::model()->findByPk($modPembayaran->pasien_id);
        }
        $modPemakaianuangmuka = BKPemakaianuangmukaT::model()->findByAttributes(array('pembayaranpelayanan_id'=>$pembayaranpelayanan_id));
        $data['judulLaporan'] = 'RINCIAN BIAYA ('.$modPembayaran->statusbayar.")";
        $data['nama_pegawai'] = LoginpemakaiK::model()->findByPK(Yii::app()->user->id)->pegawai->nama_pegawai;
        $criteria = new CDbCriteria();
        if(isset($modPendaftaran->pasien_id)){
            $criteria->addCondition('pendaftaran_id = '.$modPembayaran->pendaftaran_id);
        }else{
            $criteria->addCondition('pasien_id = '.$modPembayaran->pasien_id);
        }
        $criteria->addCondition('pembayaranpelayanan_id = '.$pembayaranpelayanan_id);
        $criteria->addCondition('tindakansudahbayar_id IS NOT NULL'); //sudah lunas
        $criteria->order = 'ruangan_id';
        $modRincian = BKRinciantagihanpasiensudahbayarV::model()->findAll($criteria);
        $this->render('printRincianSudahBayar', array('modPendaftaran'=>$modPendaftaran, 'modPasien'=>$modPasien, 'modPembayaran'=>$modPembayaran, 'modPemakaianuangmuka'=>$modPemakaianuangmuka,'modRincian'=>$modRincian, 'data'=>$data));
    }
}
