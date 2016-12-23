<?php

Yii::import("billingKasir.controllers.PembayaranTagihanPasienController");

class PembayaranUangMukaController extends PembayaranTagihanPasienController
{
    public $path_view = 'billingKasir.views.pembayaranUangMuka.';
    public function actionIndex($id=null)
    {
        $format = new MyFormatter();
        $modKunjungan=new BKInfokunjunganrjV;
        $model=new BKBayaruangmukaT;
        $modTandabukti = new BKTandabuktibayarT;
        $modPemakaianuangmuka = new BKPemakaianuangmukaT;
        $modTandabukti->tglbuktibayar = $format->formatDateTimeForUser(date('Y-m-d H:m:s'));
		//$modKunjungan->tglselesaiperiksa=date('Y-m-d H:m:s');
		
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
                $loadKunjungan = BKInfokunjunganrjV::model()->findByAttributes(array('pendaftaran_id'=>$_GET['pendaftaran_id']));
            }else if($_GET['instalasi_id'] == Params::INSTALASI_ID_RD){
                $loadKunjungan = BKInfokunjunganrdV::model()->findByAttributes(array('pendaftaran_id'=>$_GET['pendaftaran_id']));;
            }else if($_GET['instalasi_id'] == Params::INSTALASI_ID_RI){
				//$loadKunjungan = BKInfopasienmasukkamarV::model()->findByAttributes(array('pendaftaran_id'=>$_GET['pendaftaran_id'],'pasienadmisi_id'=>@$_POST['pasienadmisi_id']));;
				$loadKunjungan = BKInformasikasirinappulangV::model()->findByAttributes(array('pendaftaran_id'=>$_GET['pendaftaran_id']));;
			}
            if(isset($loadKunjungan)){
                $modKunjungan = $loadKunjungan;
            }
        }
        
        if(isset($_GET['frame'])){
            $this->layout = "//layouts/iframe";
        }
        
        
        if(isset($_POST['BKTandabuktibayarT']))
        {
            $modPendaftaran = BKPendaftaranT::model()->findByPk($_POST['pendaftaran_id']);
            $modPasien = BKPasienM::model()->findByPk($modPendaftaran->pasien_id);
            $tandaBuktiBayarUangMuka = $_POST['BKTandabuktibayarT'];

            $transaction = Yii::app()->db->beginTransaction();
            try {
                if(!empty($_GET['frame']))
                {
                    $modBayaruangmuka = $this->updateBayarUangMuka($modBayaruangmuka, $_POST);
                }else{
                    $modTandabukti = $this->saveTandaBuktiBayar(
                        $tandaBuktiBayarUangMuka,$modPendaftaran,$modPasien
                    );                        
                }

                // SMS GATEWAY
                
				
                $sms = new Sms();
                $smspasien = 1;
				/*
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
				 * 
				 */
                // END SMS GATEWAY
				// die;
                $transaction->commit();
                Yii::app()->user->setFlash('success',"Data berhasil disimpan");
                if(empty($modBayaruangmuka->bayaruangmuka_id))
                    $modBayaruangmuka = BKBayaruangmukaT::model()->findByAttributes(array('tandabuktibayar_id'=>$modTandabukti->tandabuktibayar_id));
                $this->redirect(array('index','id'=>$modBayaruangmuka->bayaruangmuka_id,'pendaftaran_id'=>$modBayaruangmuka->pendaftaran_id,'instalasi_id'=>$modPendaftaran->instalasi_id,'sukses'=>1,'smspasien'=>$smspasien));
            }catch(Exception $exc){
                Yii::app()->user->setFlash('error',"Data gagal disimpan ".MyExceptionMessage::getMessage($exc,true));
                $transaction->rollback();
            }
        }
        
        if(!empty($id)){
            $model = BKBayaruangmukaT::model()->findByPk($id);
            $modTandabukti = BKTandabuktibayarT::model()->findByPk($model->tandabuktibayar_id);
            $modTandabukti->is_menggunakankartu = 0;
        }
        
        $modKunjungan->tgl_pendaftaran = $format->formatDateTimeForUser($modKunjungan->tgl_pendaftaran);
        $modKunjungan->tanggal_lahir = $format->formatDateTimeForUser($modKunjungan->tanggal_lahir);
        //$modKunjungan->tglselesaiperiksa = $format->formatDateTimeForUser($_POST['tglselesaiperiksa']);
        $this->render('index',array(
            'model'=>$model,
            'modTandabukti'=>$modTandabukti,
            'modKunjungan'=>$modKunjungan,
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
            if(isset($_POST['BKBayaruangmukaT'])){
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
                    $modKunjungan = BKInfokunjunganrjV::model()->find($criteria);
                }else if($_POST['instalasi_id'] == Params::INSTALASI_ID_RD){
                    $modKunjungan = BKInfokunjunganrdV::model()->find($criteria);
                }else if($_POST['instalasi_id'] == Params::INSTALASI_ID_RI){
                    $modKunjungan = BKInformasikasirinappulangV::model()->find($criteria);
                }
                $model = new BKBayaruangmukaT;
                $modTandabukti = new BKTandabuktibayarT;
                
                $model->attributes = $_POST['BKBayaruangmukaT'];
                $model->totbiayasementara = $_POST['BKBayaruangmukaT']['totbiayasementara'];
                $modTandabukti->attributes = $_POST['BKTandabuktibayarT'];
                $modTandabukti->is_menggunakankartu = $_POST['BKTandabuktibayarT']['is_menggunakankartu'];

            }
            echo CJSON::encode(array(
                'content'=>$this->renderPartial($this->path_view.'verifikasi',array(
                    'format'=>$format,
                    'modKunjungan'=>$modKunjungan,
                    'model'=>$model,
                    'modTandabukti'=>$modTandabukti,
            ), true)));
            exit;
        }
    }
    
    protected function updateBayarUangMuka($model_bayar_muka,$post)
        {
            $update = BKBayaruangmukaT::model()->updateByPk(
                $model_bayar_muka->bayaruangmuka_id,
                array(
                    'jumlahuangmuka'=>$post['BKTandabuktibayarUangMukaT']['jmlpembayaran']
                )
            );
            
            $update_bukti_bayar = TandabuktibayarT::model()->updateByPk(
                $model_bayar_muka->tandabuktibayar_id,
                array(
                    'jmlpembayaran'=>$post['BKTandabuktibayarUangMukaT']['jmlpembayaran'],
                    'uangditerima'=>$post['BKTandabuktibayarUangMukaT']['uangditerima'],
                )
            );
            return $update;
        }
   
        
    protected function saveTandaBuktiBayar($postTandaBukti,$modPendaftaran,$modPasien)
    {
        $format = new MyFormatter;
        $modTandaBukti = new BKTandabuktibayarT;
        $modTandaBukti->attributes = $postTandaBukti;
        $modTandaBukti->tglbuktibayar = $format->formatDateTimeForDb($modTandaBukti->tglbuktibayar);
        $modTandaBukti->ruangan_id = Yii::app()->user->getState('ruangan_id');
        $modTandaBukti->nourutkasir = MyGenerator::noUrutKasir($modTandaBukti->ruangan_id);
        $modTandaBukti->nobuktibayar = MyGenerator::noBuktiBayar();
        $modTandaBukti->alamat_bkm = isset($modTandaBukti->alamat_bkm)?$modTandaBukti->alamat_bkm:'-';
		$modTandaBukti->create_ruangan = Yii::app()->user->getState('ruangan_id');
		$modTandaBukti->create_time = date("Y-m-d H:i:s");
		$modTandaBukti->create_loginpemakai_id = Yii::app()->user->id;
		$modTandaBukti->shift_id= Yii::app()->user->getState('shift_id');
        if($modTandaBukti->validate())
        {
            $modTandaBukti->save();
            $this->saveBayarUangMuka($modTandaBukti, $modPendaftaran, $modPasien);
        }else{
            throw new Exception('Data Tanda Bukti Bayar tidak valid');
        }

        return $modTandaBukti;
    }

    protected function saveBayarUangMuka($modTandaBukti,$modPendaftaran,$modPasien)
    {
		// var_dump($modPendaftaran->attributes); die;
		
		$admisi = PasienadmisiT::model()->findByPk($modPendaftaran->pasienadmisi_id);
		
        $modUangMuka = new BayaruangmukaT;
        $modUangMuka->tandabuktibayar_id = $modTandaBukti->tandabuktibayar_id;
        $modUangMuka->tgluangmuka = $modTandaBukti->tglbuktibayar;
        $modUangMuka->jumlahuangmuka = $modTandaBukti->jmlpembayaran;
        $modUangMuka->pendaftaran_id = $modPendaftaran->pendaftaran_id;
        $modUangMuka->pasien_id = $modPendaftaran->pasien_id;
        $modUangMuka->pasienadmisi_id = $modPendaftaran->pasienadmisi_id;
//      --RND-9743  $modUangMuka->ruangan_id = Yii::app()->user->getState('ruangan_id');
        $modUangMuka->ruangan_id = empty($admisi)?$modPendaftaran->ruangan_id:$admisi->ruangan_id;
		$modUangMuka->create_ruangan = Yii::app()->user->getState('ruangan_id');
		$modUangMuka->create_time = date("Y-m-d H:i:s");
		$modUangMuka->create_loginpemakai_id = Yii::app()->user->id;
		
		// var_dump($modUangMuka->attributes); die;
		
        if($modUangMuka->validate())
        {
            $modUangMuka->save();
            $this->updateTandaBukti($modTandaBukti, $modUangMuka);
        }else{
            throw new Exception('Data Uang Muka tidak valid');
        }

    }
    
    protected function updateTandaBukti($modTandaBukti,$modUangMuka)
    {
        TandabuktibayarT::model()->updateByPk($modTandaBukti->tandabuktibayar_id, array('bayaruangmuka_id'=>$modUangMuka->bayaruangmuka_id));
    }
    
    /**
     * menghitung rincian tagihan tindakan
     */
    public function actionSetRincianTindakan(){
        if(Yii::app()->request->isAjaxRequest) { 
            $format = new MyFormatter();
            $pendaftaran_id=(isset($_POST['pendaftaran_id']) ? $_POST['pendaftaran_id'] : null);
            $pasienadmisi_id=(isset($_POST['pasienadmisi_id']) ? $_POST['pasienadmisi_id'] : null);
            $kelaspelayanan_id=(isset($_POST['kelaspelayanan_id']) ? $_POST['kelaspelayanan_id'] : null);
            $pasien_id = (isset($_POST['pasien_id']) ? $_POST['pasien_id'] : null);
            $penjamin_id = (isset($_POST['penjamin_id']) ? $_POST['penjamin_id'] : null);
            $dataTindakans = array();
            $dataOas = array();
            if(!empty($pendaftaran_id)){
                $criteria = new CdbCriteria();
                $criteria->select = "sum((tarif_satuan * qty_tindakan) + tarifcyto_tindakan - discount_tindakan - pembebasan_tindakan - subsidiasuransi_tindakan - subsisidirumahsakit_tindakan) as total";
                $criteria->addCondition("pendaftaran_id = ".$pendaftaran_id);
                $criteria->addCondition("tindakansudahbayar_id IS NULL");
                $dataTindakan=BKTindakanPelayananT::model()->find($criteria);

                $criteria = new CdbCriteria();
                $criteria->select = "sum((hargasatuan_oa * qty_oa) + tarifcyto-discount + (biayaservice + biayakonseling + biayakemasan + biayaadministrasi) - subsidiasuransi - subsidirs) as total";
                $criteria->addCondition("pendaftaran_id = ".$pendaftaran_id);
                $criteria->addCondition("oasudahbayar_id IS NULL");
                $dataOa=BKObatalkesPasienT::model()->find($criteria);

                $jumlah_tagihan = $dataTindakan->total + $dataOa->total;
            }
            $data['tagihan']=$jumlah_tagihan;
            echo CJSON::encode($data);
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
                $models = BKInfokunjunganrjV::model()->findAll($criteria);
            }else if($instalasi_id == Params::INSTALASI_ID_RD){
                $models = BKInfokunjunganrdV::model()->findAll($criteria);
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
				// $criteria->addCondition("instalasi_id = ".$instalasi_id);					
			}
			
			// var_dump($pendaftaran_id); die;
            $criteria->compare('LOWER(no_pendaftaran)',strtolower(trim($no_pendaftaran)));
            $criteria->compare('LOWER(no_rekam_medik)',strtolower(trim($no_rekam_medik)));
			// var_dump($criteria); die;
            if($instalasi_id == Params::INSTALASI_ID_RJ){
                $model = BKInfokunjunganrjV::model()->find($criteria);
            }else if($instalasi_id == Params::INSTALASI_ID_RD){
                $model = BKInfokunjunganrdV::model()->find($criteria);
            }else if($instalasi_id == Params::INSTALASI_ID_RI){
                $model = BKInformasikasirinappulangV::model()->find($criteria);
            }
            
            $attributes = $model->attributeNames();
            foreach($attributes as $j=>$attribute) {
                $returnVal["$attribute"] = $model->$attribute;
            }
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

    public function actionPrintDetailKasMasuk($idPembayaran, $caraPrint)
    {
            if (!isset($caraPrint)){
                    $caraPrint=null;
            }
            $format = new MyFormatter;
            $criteria = new CDbCriteria();
//            $criteria->addCondition('pendaftaran_id = '.$pendaftaran_id);
            $criteria->addCondition('bayaruangmuka_id = '.$idPembayaran);
//		$criteria->addCondition('tindakansudahbayar_id IS NOT NULL'); //sudah lunas
            $criteria->order = 'ruangan_id';
            $detail = BKBayaruangmukaT::model()->findAll($criteria);

            $no_bkm = '';
            $tgl_bkm = '';
            $pembayar = '';
            $total_bayar = '';
            $total_bayar_huruf = '';		
            $rec = array();
            foreach($detail as $key=>$val)
            {
                    $data[] = null;
                    $data['tglpembayaran'] = date('d-m-Y', strtotime($format->formatDateTimeForDb($val->getTandaBukti("tglbuktibayar"))));
                    $data['keterangan'] = 'Pembayaran uang muka';
                    $data['jumlah'] = $val->jumlahuangmuka;
//
                    $total_bayar += $val->jumlahuangmuka;
                    $no_bkm = $val->getTandaBukti("nobuktibayar");
                    $tgl_bkm = $val->getTandaBukti("tglbuktibayar");
                    $pembayar = $val->getTandaBukti("darinama_bkm");
//
                    $rec[] = $data;
            }

            $data = array(
                    'header'=>array(
                            'no_bkm'=>$no_bkm,
                            'tgl_bkm'=>$tgl_bkm,
                            'total_bayar'=>$format->formatUang($total_bayar, "Rp. "),
                            'total_bayar_huruf'=>$format->formatNumberTerbilang($total_bayar),
                            'pembayar'=>$pembayar,
                    ),
                    'detail'=>$rec,
                    'footer'=>123,
            );
            if($caraPrint == 'PRINT')
            {
                    $this->layout='//layouts/printWindows';
                    $this->render('detailKasMasuk',
                            array(
                                    'data'=>$data,
                                    'caraPrint'=>$caraPrint,
                                    'format'=>$format
                            )
                    );
            }else{
                    $this->layout = '//layouts/iframe';
                    $ukuranKertasPDF = 'RBK';                  //Ukuran Kertas Pdf
                    $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
                    $mpdf = new MyPDF('',$ukuranKertasPDF); 
                    $mpdf->useOddEven = 2;  
//                $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
                    $mpdf->WriteHTML($stylesheet,1);  
                    $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
                    $mpdf->WriteHTML($stylesheet, 1);  
                    $mpdf->AddPage($posisi,'','','','',5,5,5,5);
                    $mpdf->WriteHTML(
                            $this->render('detailKasMasuk',
                                    array(
                                            'format'=>$format,
                                            'data'=>$data,
                                            'caraPrint'=>$caraPrint
                                    ),true
                            )
                    );
                    $mpdf->Output();                
            }
    }
    
	/**
     * method untuk print kwitansi
     * @param int $bayaruangmuka_id bayaruangmuka_id
     */
    public function actionPrintKuitansi($bayaruangmuka_id)
    {
        $judulKuitansi = '----- KUITANSI -----';
        $format = new MyFormatter();
        $modBayar = BKBayaruangmukaT::model()->findByPk($bayaruangmuka_id);
        $modTandaBukti = BKTandabuktibayarT::model()->findByPk($modBayar->tandabuktibayar_id);
        $criteria = new CdbCriteria();
		
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

        $caraPrint=$_REQUEST['caraPrint'];
        if($caraPrint=='PRINT') {
            $this->layout='//layouts/printWindows';
            $this->render($this->path_view.'printKuitansi', array( 'modPendaftaran'=>$modPendaftaran, 'judulKuitansi'=>$judulKuitansi, 'caraPrint'=>$caraPrint, 'rincianpembayaran'=>$rincianpembayaran,
                                   'modTandaBukti'=>$modTandaBukti,
                                   'modBayar'=>$modBayar));
        }
        else if($caraPrint=='EXCEL') {
            $this->layout='//layouts/printExcel';
            $this->render($this->path_view.'printKuitansi',array( 'modPendaftaran'=>$modPendaftaran, 'judulKuitansi'=>$judulKuitansi, 'caraPrint'=>$caraPrint,'rincianpembayaran'=>$rincianpembayaran,
                                   'modTandaBukti'=>$modTandaBukti,
                                   'modBayar'=>$modBayar));
        }
        else if($_REQUEST['caraPrint']=='PDF') {
//			$ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
//            $ukuranKertasPDF = 'KW';                  //Ukuran Kertas Pdf
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
}