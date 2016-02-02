<?php

class PenjualanResepRSController extends MyAuthController
{

    public $path_view = 'farmasiApotek.views.penjualanResepRS.';
    public $penjualantersimpan = false;
    public $obatalkespasientersimpan = true; //looping
    public $stokobatalkestersimpan = true; //looping

    public function actionIndex($penjualanresep_id= null)
    {
        $sukses = false;
        $modPendaftaran = new FAPendaftaranT;
        $modInfoRI = new FAInfopasienmasukkamarV;
        $modPasien = new FAPasienM;
        $modReseptur = new FAResepturT;
        $modAntrian = new FAAntrianFarmasiT;
        $modObatAlkesPasien =array();
        $instalasi_id = Yii::app()->user->getState('instalasi_id');
        $modReseptur->noresep = MyGenerator::noResep($instalasi_id);
        $modReseptur->noresep_depan = $modReseptur->noresep.'/';
        $modReseptur->tglreseptur = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($modReseptur->tglreseptur, 'yyyy-MM-dd hh:mm:ss','medium',null)); 
        $modPenjualan = new FAPenjualanResepT;
        $modPenjualan->tglpenjualan = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($modPenjualan->tglpenjualan, 'yyyy-MM-dd hh:mm:ss','medium',null)); 
        $modPenjualan->tglresep = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($modPenjualan->tglresep, 'yyyy-MM-dd hh:mm:ss','medium',null)); 
        $modPenjualan->noresep = $modReseptur->noresep;

        $modPenjualan->totharganetto= 0;
        $modPenjualan->totalhargajual= 0;
        $modPenjualan->totaltarifservice= 0;
        $modPenjualan->biayaadministrasi= 0;
        $modPenjualan->biayakonseling= 0;
        $modPenjualan->pembulatanharga= 0;
        $modPenjualan->jasadokterresep= 0;
        $modPenjualan->discount= 0;
        $modPenjualan->subsidiasuransi= 0;
        $modPenjualan->subsidipemerintah= 0;
        $modPenjualan->subsidirs= 0;
        $modPenjualan->iurbiaya= 0;
		$modPenjualan->isresepperawatan = 1;
        
        $modObatAlkes = array();
        
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
        
        
        if(!empty($penjualanresep_id)){
            
            $modPenjualan = FAPenjualanResepT::model()->findByPk($penjualanresep_id);
            $modObatAlkesPasien = FAObatalkesPasienT::model()->findAllByAttributes(array('penjualanresep_id'=>$modPenjualan->penjualanresep_id));
            $modInfoDataRI = FAObatalkesPasienT::model()->findByAttributes(array('penjualanresep_id'=>$modPenjualan->penjualanresep_id));
            $modInfoRI->no_pendaftaran = $modInfoDataRI->pendaftaran->no_pendaftaran;
            $modInfoRI->tgl_pendaftaran = $modInfoDataRI->pendaftaran->tgl_pendaftaran;
            $modInfoRI->ruangan_nama = $modInfoDataRI->pendaftaran->ruangan->ruangan_nama;
            $modInfoRI->instalasi_id = $modInfoDataRI->pendaftaran->instalasi_id;
            $modInfoRI->kelaspelayanan_nama = $modInfoDataRI->pendaftaran->kelaspelayanan->kelaspelayanan_nama;
            $modInfoRI->jeniskasuspenyakit_id = $modInfoDataRI->pendaftaran->jeniskasuspenyakit->jeniskasuspenyakit_id;
            $modInfoRI->jeniskasuspenyakit_nama = $modInfoDataRI->pendaftaran->jeniskasuspenyakit->jeniskasuspenyakit_nama;
            $modInfoRI->carabayar_nama = $modInfoDataRI->pendaftaran->carabayar->carabayar_nama;
            $modInfoRI->penjamin_nama = $modInfoDataRI->pendaftaran->penjamin->penjamin_nama;
            $modInfoRI->no_rekam_medik = $modInfoDataRI->pendaftaran->pasien->no_rekam_medik;
            $modInfoRI->namadepan = $modInfoDataRI->pendaftaran->pasien->namadepan;
            $modInfoRI->nama_pasien = $modInfoDataRI->pendaftaran->pasien->nama_pasien;
            $modInfoRI->nama_bin = $modInfoDataRI->pendaftaran->pasien->nama_bin;
            $modInfoRI->tanggal_lahir = MyFormatter::formatDateTimeForUser($modInfoDataRI->pendaftaran->pasien->tanggal_lahir);
            $modInfoRI->umur = $modInfoDataRI->pendaftaran->umur;
            $modInfoRI->jeniskelamin = $modInfoDataRI->pendaftaran->pasien->jeniskelamin;
            $modInfoRI->penanggungjawab_id = $modInfoDataRI->pendaftaran->penanggungjawab_id;
            $modInfoRI->alamat_pasien = $modInfoDataRI->pendaftaran->pasien->alamat_pasien;
        }
        
        $pendaftaran_id = isset($_GET['pendaftaran_id']) ? $_GET['pendaftaran_id'] : null;
        if (!empty($pendaftaran_id)){
            $modPendaftaran = FAPendaftaranT::model()->findByPk($pendaftaran_id);
            $modPasien = FAPasienM::model()->findByPk($modPendaftaran->pasien_id);
        }

        $modAntrian->tglambilantrian= date('Y-m-d H:i:s');
        $racikan = RacikanM::model()->findByPk(Params::RACIKAN_ID_RACIKAN);
            $nonRacikan = RacikanM::model()->findByPk(Params::RACIKAN_ID_NONRACIKAN);
            $modRacikanDetail = RacikandetailM::model()->findAll(); //load semua data untuk perhitungan js & jquery
            $racikanDetail = array();
            foreach ($modRacikanDetail as $i => $mod){ //convert object to array
                $racikanDetail[$i]['racikandetail_id'] = $mod->racikandetail_id;
                $racikanDetail[$i]['racikan_id'] = $mod->racikan_id;
                $racikanDetail[$i]['qtymin'] = $mod->qtymin;
                $racikanDetail[$i]['qtymaks'] = $mod->qtymaks;
                $racikanDetail[$i]['tarifservice'] = $mod->tarifservice;
            }
        $transaction = Yii::app()->db->beginTransaction();
        if(isset($_POST['FAPenjualanResepT'])){

            $modPendaftaran = FAPendaftaranT::model()->findByPk($_POST['pendaftaran_id']);
            $modPenjualan = $this->savePenjualanResepRS($modPendaftaran,$_POST['FAPenjualanResepT']);

            if($this->penjualantersimpan){
                if(count($_POST['FAObatalkesPasienT']) > 0){
                    //PROSES GROUP DETAIL BERDASARKAN obatalkes_id & akumulasikan jmlmutasi
                    $detailGroups = array();
                    foreach($_POST['FAObatalkesPasienT'] AS $i => $postDetail){
                        $modDetails[$i] = new FAObatalkesPasienT;
                        $modDetails[$i]->attributes = $postDetail;
                        $modStok = StokobatalkesT::model()->findByPk($postDetail['stokobatalkes_id']);
                        $modDetails[$i]->stokobatalkes_id = $modStok->stokobatalkes_id;
                        $obatalkes_id = $postDetail['obatalkes_id'];
                        if(isset($detailGroups[$obatalkes_id])){
                            $detailGroups[$obatalkes_id]['qty_oa'] += $postDetail['qty_oa'];
                        }else{
                            $detailGroups[$obatalkes_id]['obatalkes_id'] = $postDetail['obatalkes_id'];
                            $detailGroups[$obatalkes_id]['qty_oa'] = $postDetail['qty_oa'];
                        }
                    }
                    //END GROUP
                }

                $obathabis = "";
                //PROSES PENGURAIAN OBAT DAN JUMLAH MENJADI STOKOBATALKES_T (METODE ANTRIAN)
                foreach($detailGroups AS $i => $detail){
                    $modStokOAs = StokobatalkesT::getStokObatAlkesAktif($detail['obatalkes_id'], $detail['qty_oa'], Yii::app()->user->getState('ruangan_id'));
                    if(count($modStokOAs) > 0){
                        foreach($modStokOAs AS $i => $stok){
                            $modDetails[$i] = $this->simpanObatAlkesPasien($modPendaftaran, $modPenjualan, $stok, $_POST['FAObatalkesPasienT'] );
                            $this->simpanStokObatAlkesOut($stok['stokobatalkes_id'], $modDetails[$i]);
                        }
                    }else{
                        $this->stokobatalkestersimpan &= false;
                        $obathabis .= "<br>- ".ObatalkesM::model()->findByPk($detail['obatalkes_id'])->obatalkes_nama;
                        
                    }
                }

                try {
                    if($this->obatalkespasientersimpan&&$this->stokobatalkestersimpan){
                         // SMS GATEWAY
                        $sms = new Sms();
                        $smspasien = 1;
                        foreach ($modSmsgateway as $i => $smsgateway) {
                            $isiPesan = $smsgateway->templatesms;

                            $attributes = $modPasien->getAttributes();
                            foreach($attributes as $attributes => $value){
                                $isiPesan = str_replace("{{".$attributes."}}",$value,$isiPesan);
                            }
                            $attributes = $modPenjualan->getAttributes();
                            foreach($attributes as $attributes => $value){
                                $isiPesan = str_replace("{{".$attributes."}}",$value,$isiPesan);
                            }
                           
                            $isiPesan = str_replace("{{hari}}",MyFormatter::getDayName($modPenjualan->tglpenjualan),$isiPesan);
                         
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
                        $sukses = 1;
                        $this->redirect(array('index','penjualanresep_id'=>$modPenjualan->penjualanresep_id, 'sukses'=>$sukses,'smspasien'=>$smspasien));
                    }else{
                        $transaction->rollback();
                        Yii::app()->user->setFlash('error',"Data detail penjualan resep gagal disimpan !");
                        if(!$this->stokobatalkestersimpan){
                            Yii::app()->user->setFlash('error',"Data ddetail penjualan resep gagal disimpan ! Stok obat berikut tidak mencukupi !:".$obathabis);
                        }
                    }
                } catch (Exception $e) {
                    $transaction->rollback();
                    Yii::app()->user->setFlash('error',"Data penjualan resep gagal disimpan ! ".MyExceptionMessage::getMessage($e,true));
                }
            }
        }
        

        $this->render($this->path_view.'index',array(
                                            'modReseptur'=>$modReseptur,
                                            'modPendaftaran'=>$modPendaftaran,
                                            'modInfoRI'=>$modInfoRI,
                                            'modPasien'=>$modPasien,
                                            'modPenjualan'=>$modPenjualan,
                                            'modAntrian'=>$modAntrian,
                                            'modObatAlkesPasien'=>$modObatAlkesPasien,
                                            'racikan'=>$racikan,
                                            'racikanDetail'=>$racikanDetail,
                                            'nonRacikan'=>$nonRacikan,
                                            'obatAlkes'=>$modObatAlkes,
                                            'sukses'=>$sukses,
                                            ));
    } 
	/**
	 * untuk melakukan penjualan dari reseptur (informasi pasien resep)
	 * @param type $reseptur_id
	 */
	
	
	// di komen karena dibuat controller baru
	// LNG-342
//    public function actionPenjualanDariReseptur($reseptur_id= null)
//    {
//        $sukses = false;
//        $modPendaftaran = new FAPendaftaranT;
//        $modInfoRI = new FAInfopasienmasukkamarV;
//        $modPasien = new FAPasienM;
//        $modReseptur = new FAResepturT;
//        $modAntrian = new FAAntrianFarmasiT;
//        $modDetailReseptur = array();
//        $modObatAlkesPasien =array();
//        $instalasi_id = Yii::app()->user->getState('instalasi_id');
//        $modReseptur->noresep = MyGenerator::noResep($instalasi_id);
//        $modReseptur->noresep_depan = $modReseptur->noresep.'/';
//        $modReseptur->tglreseptur = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($modReseptur->tglreseptur, 'yyyy-MM-dd hh:mm:ss','medium',null)); 
//        $modPenjualan = new FAPenjualanResepT;
//        $modPenjualan->tglpenjualan = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($modPenjualan->tglpenjualan, 'yyyy-MM-dd hh:mm:ss','medium',null)); 
//        $modPenjualan->tglresep = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($modPenjualan->tglresep, 'yyyy-MM-dd hh:mm:ss','medium',null)); 
//        $modPenjualan->noresep = $modReseptur->noresep;
//
//        $modPenjualan->totharganetto= 0;
//        $modPenjualan->totalhargajual= 0;
//        $modPenjualan->totaltarifservice= 0;
//        $modPenjualan->biayaadministrasi= 0;
//        $modPenjualan->biayakonseling= 0;
//        $modPenjualan->pembulatanharga= 0;
//        $modPenjualan->jasadokterresep= 0;
//        $modPenjualan->discount= 0;
//        $modPenjualan->subsidiasuransi= 0;
//        $modPenjualan->subsidipemerintah= 0;
//        $modPenjualan->subsidirs= 0;
//        $modPenjualan->iurbiaya= 0;
//        
//        $modObatAlkes = array();
//
//
//
//        if (!empty($reseptur_id)) {
//            $modReseptur = FAResepturT::model()->findByPk($reseptur_id);
//            $modDetailReseptur = FAResepturDetailT::model()->findAllByAttributes(array('reseptur_id'=>$reseptur_id));
//        }
//
//        $modAntrian->tglambilantrian= date('Y-m-d H:i:s');
//        $racikan = RacikanM::model()->findByPk(Params::RACIKAN_ID_RACIKAN);
//            $nonRacikan = RacikanM::model()->findByPk(Params::RACIKAN_ID_NONRACIKAN);
//            $modRacikanDetail = RacikandetailM::model()->findAll(); //load semua data untuk perhitungan js & jquery
//            $racikanDetail = array();
//            foreach ($modRacikanDetail as $i => $mod){ //convert object to array
//                $racikanDetail[$i]['racikandetail_id'] = $mod->racikandetail_id;
//                $racikanDetail[$i]['racikan_id'] = $mod->racikan_id;
//                $racikanDetail[$i]['qtymin'] = $mod->qtymin;
//                $racikanDetail[$i]['qtymaks'] = $mod->qtymaks;
//                $racikanDetail[$i]['tarifservice'] = $mod->tarifservice;
//            }
//        $transaction = Yii::app()->db->beginTransaction();
//        if(isset($_POST['FAPenjualanResepT'])){
//
//            $modPendaftaran = FAPendaftaranT::model()->findByPk($_POST['pendaftaran_id']);
//            $modPenjualan = $this->savePenjualanResepRS($modPendaftaran,$_POST['FAPenjualanResepT'],$modReseptur);
//
//            if($this->penjualantersimpan){
//                if(count($_POST['FAObatalkesPasienT']) > 0){
//                    //PROSES GROUP DETAIL BERDASARKAN obatalkes_id & akumulasikan jmlmutasi
//                    $detailGroups = array();
//                    foreach($_POST['FAObatalkesPasienT'] AS $i => $postDetail){
//                        $modDetails[$i] = new FAObatalkesPasienT;
//                        $modDetails[$i]->attributes = $postDetail;
//                        $modStok = StokobatalkesT::model()->findByPk($postDetail['stokobatalkes_id']);
//                        $modDetails[$i]->stokobatalkes_id = $modStok->stokobatalkes_id;
//                        $obatalkes_id = $postDetail['obatalkes_id'];
//                        if(isset($detailGroups[$obatalkes_id])){
//                            $detailGroups[$obatalkes_id]['qty_oa'] += $postDetail['qty_oa'];
//                        }else{
//                            $detailGroups[$obatalkes_id]['obatalkes_id'] = $postDetail['obatalkes_id'];
//                            $detailGroups[$obatalkes_id]['qty_oa'] = $postDetail['qty_oa'];
//                        }
//                    }
//                    //END GROUP
//                }
//
//                $obathabis = "";
//                //PROSES PENGURAIAN OBAT DAN JUMLAH MENJADI STOKOBATALKES_T (METODE ANTRIAN)
//                foreach($detailGroups AS $i => $detail){
//                    $modStokOAs = StokobatalkesT::getStokObatAlkesAktif($detail['obatalkes_id'], $detail['qty_oa'], Yii::app()->user->getState('ruangan_id'));
//                    if(count($modStokOAs) > 0){
//                        foreach($modStokOAs AS $i => $stok){
//                            $modDetails[$i] = $this->simpanObatAlkesPasien($modPendaftaran, $modPenjualan, $stok, $_POST['FAObatalkesPasienT'] );
//                            $this->simpanStokObatAlkesOut($stok['stokobatalkes_id'], $modDetails[$i]);
//                        }
//                    }else{
//                        $this->stokobatalkestersimpan &= false;
//                        $obathabis .= "<br>- ".ObatalkesM::model()->findByPk($detail['obatalkes_id'])->obatalkes_nama;
//                        
//                    }
//                }
//
//                try {
//                    if($this->obatalkespasientersimpan&&$this->stokobatalkestersimpan){
//                        $transaction->commit();
//                        $sukses = 1;
//                        $this->redirect(array('index','penjualanresep_id'=>$modPenjualan->penjualanresep_id, 'sukses'=>$sukses));
//                    }else{
//                        $transaction->rollback();
//                        Yii::app()->user->setFlash('error',"Data detail penjualan resep gagal disimpan !");
//                        if(!$this->stokobatalkestersimpan){
//                            Yii::app()->user->setFlash('error',"Data ddetail penjualan resep gagal disimpan ! Stok obat berikut tidak mencukupi !:".$obathabis);
//                        }
//                    }
//                } catch (Exception $e) {
//                    $transaction->rollback();
//                    Yii::app()->user->setFlash('error',"Data penjualan resep gagal disimpan ! ".MyExceptionMessage::getMessage($e,true));
//                }
//            }
//        }
//        $this->render($this->path_view.'index',array(
//                                            'modReseptur'=>$modReseptur,
//                                            'modPendaftaran'=>$modPendaftaran,
//                                            'modInfoRI'=>$modInfoRI,
//                                            'modPasien'=>$modPasien,
//                                            'modPenjualan'=>$modPenjualan,
//                                            'modAntrian'=>$modAntrian,
//                                            'modObatAlkesPasien'=>$modObatAlkesPasien,
//                                            'racikan'=>$racikan,
//                                            'racikanDetail'=>$racikanDetail,
//                                            'nonRacikan'=>$nonRacikan,
//                                            'obatAlkes'=>$modObatAlkes,
//                                            'sukses'=>$sukses,
//                                            'modDetailReseptur'=>$modDetailReseptur,
//                                            ));
//    } 

    protected function savePenjualanResepRS($modPendaftaran,$penjualanResep,$modReseptur=null)
	{
		$format = new MyFormatter();
		$modPenjualan = new FAPenjualanResepT;
		$modPenjualan->attributes = $penjualanResep;
		$modPenjualan->pendaftaran_id = $modPendaftaran->pendaftaran_id;
		$modPenjualan->penjamin_id = $modPendaftaran->penjamin_id;
		$modPenjualan->carabayar_id = $modPendaftaran->carabayar_id; 
		$modPenjualan->antrianfarmasi_id = isset($penjualanResep['antrianfarmasi_id']) ? $penjualanResep['antrianfarmasi_id'] : null ;   
		$modPenjualan->pegawai_id = isset($_POST['FAPenjualanResepT']['pegawai_id']) ? $_POST['FAPenjualanResepT']['pegawai_id'] : $_POST['FAResepturT']['pegawai_id'] ;
		$modPenjualan->kelaspelayanan_id = $modPendaftaran->kelaspelayanan_id;
		$modPenjualan->pasien_id = $modPendaftaran->pasien_id;
		$modPasienAdmisi = PasienadmisiT::model()->findByAttributes(array("pendaftaran_id"=>$modPendaftaran->pendaftaran_id, "pasien_id"=>$modPendaftaran->pasien_id));
		$modPenjualan->pasienadmisi_id = (empty($modPasienAdmisi->pasienadmisi_id)) ? null : $modPasienAdmisi->pasienadmisi_id;
		$modPenjualan->tglpenjualan = $format->formatDateTimeForDb($_POST['FAPenjualanResepT']['tglpenjualan']);
		$modPenjualan->tglresep = date('Y-m-d H:i:s');
		$modPenjualan->ruanganasal_nama = Yii::app()->user->getState('ruangan_nama');
		$modPenjualan->instalasiasal_nama = Yii::app()->user->getState('instalasi_nama');
		$modPenjualan->reseptur_id = (!empty($modReseptur->reseptur_id) ? $modReseptur->reseptur_id : null);
		if(isset($_POST['ruangan_id'])){ //dari form
			$ruangan = RuanganM::model()->findByPk($_POST['ruangan_id']);
			$modPenjualan->ruanganasal_nama = $ruangan->ruangan_nama;
			$modPenjualan->instalasiasal_nama = $ruangan->instalasi->instalasi_nama;
		}
		$modPenjualan->ruangan_id = Yii::app()->user->getState('ruangan_id');
		$modPenjualan->pembulatanharga = Yii::app()->user->getState('pembulatanharga');
		$modPenjualan->noresep = isset($_POST['FAPenjualanResepT']['noresep']) ? $_POST['FAPenjualanResepT']['noresep'] : $_POST['FAResepturT']['noresep'] ;
		$modPenjualan->subsidiasuransi = 0;
		$modPenjualan->subsidipemerintah = 0;
		$modPenjualan->subsidirs = 0;
		$modPenjualan->iurbiaya = 0;
		$modPenjualan->discount = 0; 
		$modPenjualan->create_time = date("Y-m-d H:i:s");
		$modPenjualan->create_loginpemakai_id = Yii::app()->user->id;
		$modPenjualan->create_ruangan = Yii::app()->user->getState('ruangan_id');
		
		if($modPenjualan->validate()){
			$modPenjualan->save();
			PendaftaranT::model()->updateByPk($modPenjualan->pendaftaran_id, array('pembayaranpelayanan_id'=>null));
			if(!empty($modReseptur->reseptur_id))
				ResepturT::model()->updateByPk($modReseptur->reseptur_id, array('penjualanresep_id'=>$modPenjualan->penjualanresep_id));
			$this->penjualantersimpan = true;
		} else {
			$this->penjualantersimpan = false;
			Yii::app()->user->setFlash('error',"Data Penjualan Resep Tidak valid");
		}

		return $modPenjualan;
	}

    /**
     * simpan ObatalkesPasienT Jumlah Out
     * @param type $modPenjualan
     * @param type $postObatAlkesPasien
     * @return \ObatalkesPasienT
     */
    protected function simpanObatAlkesPasien($modPendaftaran,$modPenjualan,$stokOa,$postObatAlkesPasien){
        $format = new MyFormatter;
        $modObatAlkes = new FAObatalkesPasienT;
        $modObatAlkes->attributes = $stokOa->attributes;
        $modObatAlkes->tglpelayanan = date("Y-m-d H:i:s");
        $modObatAlkes->tipepaket_id = Params::TIPEPAKET_ID_NONPAKET;
        $modObatAlkes->ruangan_id = Yii::app()->user->getState('ruangan_id');
        $modObatAlkes->carabayar_id = $modPendaftaran->carabayar_id;
        $modObatAlkes->pegawai_id = Yii::app()->user->getState('pegawai_id');
        $modObatAlkes->shift_id = Yii::app()->user->getState('shift_id');
        $modObatAlkes->pendaftaran_id = $modPendaftaran->pendaftaran_id;
        $modObatAlkes->pasien_id = $modPendaftaran->pasien_id;
        $modObatAlkes->penjamin_id = $modPendaftaran->penjamin_id;
        $modObatAlkes->create_time = date("Y-m-d H:i:s");
        $modObatAlkes->create_loginpemakai_id = Yii::app()->user->id;
        $modObatAlkes->create_ruangan = Yii::app()->user->getState('ruangan_id');
        $modObatAlkes->penjualanresep_id = $modPenjualan->penjualanresep_id;
        $modObatAlkes->qty_oa = $stokOa->qtystok_terpakai;
        $modObatAlkes->jmlstok = $stokOa->qtystok;
        $modObatAlkes->harganetto_oa = $stokOa->HPP;
        $modObatAlkes->hargasatuan_oa = $stokOa->HargaJualSatuan;
        $modObatAlkes->hargajual_oa = $modObatAlkes->hargasatuan_oa * $modObatAlkes->qty_oa;
         foreach ($postObatAlkesPasien AS $i => $postDetail) {
            if ($stokOa->obatalkes_id==$postDetail['obatalkes_id']) {
                $modObatAlkes->sumberdana_id = $postDetail['sumberdana_id'];                
                $modObatAlkes->jmlstok = $postDetail['jmlstok'];
                $modObatAlkes->r = $postDetail['r'];
                $modObatAlkes->rke = $postDetail['rke'];
                $modObatAlkes->permintaan_oa = $postDetail['permintaan_oa'];
                $modObatAlkes->kekuatan_oa = $postDetail['kekuatan_oa'];
                $modObatAlkes->jmlkemasan_oa = $postDetail['jmlkemasan_oa'];                
//                $modObatAlkes->biayaservice = $postDetail['biayaservice'];
//                $modObatAlkes->biayakonseling = $postDetail['biayakonseling'];
//                $modObatAlkes->jasadokterresep = $postDetail['jasadokterresep'];
//                $modObatAlkes->biayakemasan = $postDetail['biayakemasan'];
//                $modObatAlkes->biayaadministrasi = $postDetail['biayaadministrasi'];
//                $modObatAlkes->tarifcyto = $postDetail['tarifcyto'];
//                $modObatAlkes->subsidiasuransi = $postDetail['subsidiasuransi'];
//                $modObatAlkes->subsidipemerintah = $postDetail['subsidipemerintah'];
//                $modObatAlkes->subsidirs = $postDetail['subsidirs'];
//                $modObatAlkes->iurbiaya = $postDetail['iurbiaya'];
//                $modObatAlkes->discount = $postDetail['discount'];                
                $modObatAlkes->signa_oa = $postDetail['signa_oa'];  
                $modObatAlkes->etiket = $postDetail['etiket'];  
            }
        }
		
        if($modObatAlkes->save()){
            $this->obatalkespasientersimpan &= true;
        }else{
            $this->obatalkespasientersimpan &= false;
        }
        return $modObatAlkes;



    }

    /**
     * simpan StokobatalkesT Jumlah Out
     * @param type $stokobatalkesasal_id
     * @param type $modObatAlkesPasien
     * @return \StokobatalkesT
     */
    protected function simpanStokObatAlkesOut($stokobatalkesasal_id,$modObatAlkesPasien){
        $format = new MyFormatter;
        $modStokOa = StokobatalkesT::model()->findByPk($stokobatalkesasal_id);
        $modStokOaNew = new StokobatalkesT;
        $modStokOaNew->attributes = $modStokOa->attributes; //duplicate
        $modStokOaNew->unsetIdTransaksi();
        $modStokOaNew->qtystok_in = 0;
        $modStokOaNew->qtystok_out = ceil($modObatAlkesPasien->qty_oa); // LNG Ceil (Pembulatan keatas request pak tito)
        $modStokOaNew->obatalkespasien_id = $modObatAlkesPasien->obatalkespasien_id;
        $modStokOaNew->stokobatalkesasal_id = $stokobatalkesasal_id;
        $modStokOaNew->create_time = date('Y-m-d H:i:s');
        $modStokOaNew->update_time = date('Y-m-d H:i:s');
        $modStokOaNew->create_loginpemakai_id = Yii::app()->user->id;
        $modStokOaNew->update_loginpemakai_id = Yii::app()->user->id;
        $modStokOaNew->create_ruangan = Yii::app()->user->ruangan_id;
		
        if($modStokOaNew->validateStok()){ 
            $modStokOaNew->save();
            $modStokOaNew->setStokOaAktifBerdasarkanStok();
        } else {
            $this->stokobatalkestersimpan &= false;
        }
        return $modStokOaNew;      
    }
    
    protected function simpanStokObatAlkesOut2($modObatAlkesPasien){
        $format = new MyFormatter;
        //$modStokOa = StokobatalkesT::model()->findByPk($stokobatalkesasal_id);
        $oa = ObatalkesM::model()->findByPk($modObatAlkesPasien->obatalkes_id);
        //var_dump($oa->attributes);
        $modStokOaNew = new StokobatalkesT;
        $modStokOaNew->attributes = $oa->attributes;
        $modStokOaNew->attributes = $modObatAlkesPasien->attributes; //duplicate
        $modStokOaNew->unsetIdTransaksi();
        $modStokOaNew->qtystok_in = 0;
        $modStokOaNew->qtystok_out = ceil($modObatAlkesPasien->qty_oa); // LNG Ceil (Pembulatan keatas request pak tito)
        $modStokOaNew->obatalkespasien_id = $modObatAlkesPasien->obatalkespasien_id;
        //$modStokOaNew->stokobatalkesasal_id = $stokobatalkesasal_id;
        $modStokOaNew->create_time = date('Y-m-d H:i:s');
        $modStokOaNew->update_time = $modStokOaNew->tglterima = date('Y-m-d H:i:s');
        $modStokOaNew->create_loginpemakai_id = Yii::app()->user->id;
        $modStokOaNew->update_loginpemakai_id = Yii::app()->user->id;
        $modStokOaNew->create_ruangan = Yii::app()->user->ruangan_id;
	
        //$modStokOaNew->validate();
        //var_dump($modStokOaNew->errors); 
        
        // var_dump($modStokOaNew->attributes); die;
        
        if($modStokOaNew->validate()){ 
            $this->stokobatalkestersimpan &= $modStokOaNew->save();
            // $modStokOaNew->setStokOaAktifBerdasarkanStok();
        } else {
            $this->stokobatalkestersimpan &= false;
        }
        
        // var_dump($this->stokobatalkestersimpan);
        
        return $modStokOaNew;      
    }


    /**
     * Mengurai data pasien berdasarkan:
     * - instalasi_id
     * - pendaftaran_id
     * - pasienadmisi_id
     * - no_pendaftaran
     * - no_rekam_medik
     * @throws CHttpException
     */
    public function actionGetDataInfoPasien()
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
            if($instalasi_id == Params::INSTALASI_ID_RD){
                $model = FAInfoKunjunganRDV::model()->find($criteria);
            }else if($instalasi_id == Params::INSTALASI_ID_RJ){
                $model = FAInfoKunjunganRJV::model()->find($criteria);
            }else if($instalasi_id == Params::INSTALASI_ID_RI){
                $model = FAInfopasienmasukkamarV::model()->find($criteria);
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
    * menampilkan obat
    * @return row table 
    */
    public function actionSetFormObatAlkesPasien()
    {
        if(Yii::app()->request->isAjaxRequest) { 
            $obatalkes_id = $_POST['obatalkes_id'];
            $jumlah = $_POST['jumlah'];
			$therapiobat_id = isset($_POST['therapiobat_id'])?$_POST['therapiobat_id']:null;
            $form = "";
            $pesan = "";
            $format = new MyFormatter();
            $modObatAlkesPasien = new FAObatalkesPasienT;
            $ruangan_id = Yii::app()->user->getState('ruangan_id');
            $modStokOAs = StokobatalkesT::getStokObatAlkesAktif($obatalkes_id, $jumlah, $ruangan_id);
            if(count($modStokOAs) > 0){

                foreach($modStokOAs AS $i => $stok){
                    $modObatAlkesPasien->sumberdana_id = (isset($stok->penerimaandetail->sumberdana_id) ? $stok->penerimaandetail->sumberdana_id : $stok->obatalkes->sumberdana_id);
                    $modObatAlkesPasien->obatalkes_id = $stok->obatalkes_id;
                    $modObatAlkesPasien->qty_oa = ceil($stok->qtystok_terpakai); // LNG Ceil (Pembulatan keatas request pak tito)
                    $modObatAlkesPasien->harganetto_oa = $stok->HPP;
                    $modObatAlkesPasien->hargasatuan_oa = $stok->HargaJualSatuan;
                    $modObatAlkesPasien->jmlstok = $stok->qtystok;
                    $modObatAlkesPasien->r = 'R/';
                    $modObatAlkesPasien->hargajual_oa = $modObatAlkesPasien->qty_oa * $modObatAlkesPasien->hargasatuan_oa;
                    $modObatAlkesPasien->stokobatalkes_id = $stok->stokobatalkes_id;
                    $modObatAlkesPasien->biayaservice = 0;
                    $modObatAlkesPasien->biayakonseling = 0;
                    $modObatAlkesPasien->jasadokterresep = 0;
                    $modObatAlkesPasien->biayakemasan = 0;
                    $modObatAlkesPasien->biayaadministrasi = 0;
                    $modObatAlkesPasien->tarifcyto = 0;
                    $modObatAlkesPasien->discount = 0;
                    $modObatAlkesPasien->subsidiasuransi = 0;
                    $modObatAlkesPasien->subsidipemerintah = 0;
                    $modObatAlkesPasien->subsidirs = 0;
                    $modObatAlkesPasien->iurbiaya = $modObatAlkesPasien->qty_oa * $modObatAlkesPasien->hargasatuan_oa;
					$modObatAlkesPasien->therapiobat_id = $therapiobat_id;
                    $form .= $this->renderPartial($this->path_view.'_rowDetail', array('modObatAlkesPasien'=>$modObatAlkesPasien), true);
                }
            }else{
                $pesan = "Stok tidak mencukupi!";
            }
            
            echo CJSON::encode(array('form'=>$form, 'pesan'=>$pesan));
            Yii::app()->end(); 
        }
    }

    /**
    * untuk menampilkan data kunjungan dari autocomplete
    * - no_pendaftaran
    * - no_rekam_medik
    * - nama_pasien
    */
    public function actionAutocompleteInfoPasien()
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
            if($instalasi_id == Params::INSTALASI_ID_RD){
                $models = FAInfoKunjunganRDV::model()->findAll($criteria);
            }else if($instalasi_id == Params::INSTALASI_ID_RJ){
                $models = FAInfoKunjunganRJV::model()->findAll($criteria);
            }else if($instalasi_id == Params::INSTALASI_ID_RI){
                $models = FAInfopasienmasukkamarV::model()->findAll($criteria);
            }else{
                $models = FAInfopasienmasukkamarV::model()->findAll($criteria); //default
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

    public function actionAutocompleteObatReseptur()
    {
            if(Yii::app()->request->isAjaxRequest)
            {
                $term = explode(';',$_GET['term']);
                $obatalkes_nama = isset($term[0])?$term[0]:'';
                $hargajual = isset($term[1])?$term[1]:'';
                $criteria = new CDbCriteria();
                $criteria->compare('LOWER(obatalkes_nama)', strtolower($obatalkes_nama), true);
                if($hargajual!=''){
                    $criteria->addCondition('hargajual ='.$hargajual,'or');
                }
                $criteria->addCondition('obatalkes_farmasi = TRUE');
                $criteria->addCondition('obatalkes_aktif = true');
                $criteria->order = 'obatalkes_nama';
                $criteria->limit = 5;
                $models = ObatalkesM::model()->with('sumberdana','satuankecil')->findAll($criteria);
                $persenjual = $this->persenJualRuangan();
                $format = new MyFormatter();
                foreach($models as $i=>$model)
                {
                    $attributes = $model->attributeNames();
                    
                    foreach($attributes as $j=>$attribute) {
                        $returnVal[$i]["$attribute"] = $model->$attribute;
                    }
                    $qtyStok = StokobatalkesT::getJumlahStok($model->obatalkes_id, Yii::app()->user->getState('ruangan_id'));
                    $returnVal[$i]['label'] = $model->obatalkes_kode." - ".$model->obatalkes_nama." - Jumlah Stok ".$qtyStok;
                    $returnVal[$i]['value'] = $model->obatalkes_nama;
                    $returnVal[$i]['obatalkes_id'] = $model->obatalkes_id;
                    $returnVal[$i]['sumberdana_nama'] = $model->sumberdana->sumberdana_nama;
                    $returnVal[$i]['qtyStok'] = $qtyStok;
                    $returnVal[$i]['hargajual'] = floor(($persenjual + 100 ) / 100 * $model->hargajual);
                    $returnVal[$i]['satuankecil'] = $model->satuankecil->satuankecil_nama;
                    $returnVal[$i]['idsatuankecil'] = $model->satuankecil_id;
                    $returnVal[$i]['diskonJual'] = empty($model->diskonJual) ? 0 : $model->diskonJual;
                    $returnVal[$i]['kadaluarsa'] = ((strtotime($format->formatDateTimeForDb($model->tglkadaluarsa)) - strtotime(date('Y-m-d'))) > 0) ? 0 : 1 ;
                }
                echo CJSON::encode($returnVal);
            }
            Yii::app()->end();
    }

    protected function persenJualRuangan()
    {
        switch(Yii::app()->user->getState('instalasi_id')){
            case Params::INSTALASI_ID_RI : $persen = Yii::app()->user->getState('ri_persjual');
                                            break;
            case Params::INSTALASI_ID_RJ : $persen = Yii::app()->user->getState('rj_persjual');
                                            break;
            case Params::INSTALASI_ID_RD : $persen = Yii::app()->user->getState('rd_persjual');
                                            break;
            default : $persen = 0; break;
        }

        return $persen;
    }
    
    /**
     * untuk print data penjualan dokter
     */
    public function actionPrint($penjualanresep_id,$caraPrint = null) 
    {
		$this->layout='//layouts/iframe';
        $format = new MyFormatter;    
        $modPenjualan = FAPenjualanResepT::model()->findByPk($penjualanresep_id);     
        $modPenjualanDetail = FAObatalkesPasienT::model()->findAllByAttributes(array('penjualanresep_id'=>$penjualanresep_id));

        $judul_print = 'Penjualan Resep Rumah Sakit';
        $caraPrint = isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null;
        if($caraPrint=='PRINT') {
            $this->layout='//layouts/printWindows';
        }
        else if($caraPrint=='EXCEL') {
            $this->layout='//layouts/printExcel';
        }
        
        $this->render($this->path_view.'Print', array(
                'format'=>$format,
                'judul_print'=>$judul_print,
                'modPenjualan'=>$modPenjualan,
                'modPenjualanDetail'=>$modPenjualanDetail,
                'caraPrint'=>$caraPrint
        ));
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
	 * menghitung proporsi obat
	 */
	public function actionSetProporsiTakaranResep(){
		if(Yii::app()->getRequest()->getIsAjaxRequest()) {
			$takaran = $_POST['takaran'];
			parse_str($_POST['data'], $dataOAs);
			//PROSES GROUP DETAIL BERDASARKAN obatalkes_id & akumulasikan jml jika obat sama
			$detailGroups = array();
			foreach($dataOAs['FAObatalkesPasienT'] AS $i => $postDetail){
				$obatalkes_id = $postDetail['obatalkes_id'];
				if(isset($detailGroups[$obatalkes_id])){
					$detailGroups[$obatalkes_id]['qty_oa'] += $postDetail['qty_oa'];
				}else{
					$detailGroups[$obatalkes_id] = $postDetail;
					$detailGroups[$obatalkes_id]['qty_oa'] = $postDetail['qty_oa'];
				}
			}
			//END GROUP
			//PROSES PENGURAIAN OBAT DAN JUMLAH MENJADI STOKOBATALKES_T (METODE ANTRIAN)
			$form= "";
			foreach($detailGroups AS $i => $detail){
				$qtyoa = round(($detail['qty_oa'] * $takaran), 2);
				$modStokOAs = StokobatalkesT::getStokObatAlkesAktif($detail['obatalkes_id'], $qtyoa, Yii::app()->user->getState('ruangan_id'));
				if(count($modStokOAs) > 0){
					foreach($modStokOAs AS $i => $stok){ //copy dari function actionSetFormObatAlkesPasien
						$modObatAlkesPasien = new FAObatalkesPasienT;
						$modObatAlkesPasien->sumberdana_id = (isset($stok->penerimaandetail->sumberdana_id) ? $stok->penerimaandetail->sumberdana_id : $stok->obatalkes->sumberdana_id);
						$modObatAlkesPasien->obatalkes_id = $stok->obatalkes_id;
						$modObatAlkesPasien->qty_oa = $stok->qtystok_terpakai;
						$modObatAlkesPasien->harganetto_oa = $stok->HPP;
						$modObatAlkesPasien->hargasatuan_oa = $stok->HargaJualSatuan;
						$modObatAlkesPasien->jmlstok = $stok->qtystok;
						$modObatAlkesPasien->r = 'R/';
						$modObatAlkesPasien->rke = $detail['rke'];
						$modObatAlkesPasien->hargajual_oa = $modObatAlkesPasien->qty_oa * $modObatAlkesPasien->hargasatuan_oa;
						$modObatAlkesPasien->stokobatalkes_id = $stok->stokobatalkes_id;
						$modObatAlkesPasien->biayaservice = 0;
						$modObatAlkesPasien->biayakonseling = 0;
						$modObatAlkesPasien->jasadokterresep = 0;
						$modObatAlkesPasien->biayakemasan = 0;
						$modObatAlkesPasien->biayaadministrasi = 0;
						$modObatAlkesPasien->tarifcyto = 0;
						$modObatAlkesPasien->discount = 0;
						$modObatAlkesPasien->subsidiasuransi = 0;
						$modObatAlkesPasien->subsidipemerintah = 0;
						$modObatAlkesPasien->subsidirs = 0;
						$modObatAlkesPasien->iurbiaya = $modObatAlkesPasien->qty_oa * $modObatAlkesPasien->hargasatuan_oa;

						$form .= $this->renderPartial($this->path_view.'_rowDetail', array('modObatAlkesPasien'=>$modObatAlkesPasien), true);
					}
				}
			}
			$data['form'] = $form;
			echo json_encode($data);
		}
		Yii::app()->end();
	}
	
	/**
	* method to get Therapi Obat
	* made for : LNG Projects
	* LNG-321
	*/
	public function actionAutoCompleteTherapiObat()
	{
		if(Yii::app()->request->isAjaxRequest)
		{
			$term = $_GET['term'];
			$criteria = new CDbCriteria();
			$criteria->addCondition("therapiobat_nama ILIKE '%".$term."%'");
			$criteria->addCondition('therapiobat_aktif = true');          
			$models = FATherapiobatM::model()->findAll($criteria);
			$returnVal = array();
			foreach($models as $i=>$model)
			{
				$attributes = $model->attributeNames();

				foreach($attributes as $j=>$attribute) {
					$returnVal[$i]["$attribute"] = $model->$attribute;
				}
				$returnVal[$i]['label'] = $model->therapiobat_nama;
				$returnVal[$i]['value'] = $model->therapiobat_id;
			}
			echo CJSON::encode($returnVal);
		}
		Yii::app()->end();
	}
	
	public function actionSetTherapiobatid(){
		if(Yii::app()->request->isAjaxRequest) {
			$obatalkes_id = $_POST['obatalkes_id'];
			$modTherapi = FATherapimapobatM::model()->findByAttributes(array('obatalkes_id'=>$obatalkes_id));
			if(count($modTherapi)>0){
				$data = $modTherapi->therapiobat_id;
			}else{
				$data = null;
			}
			echo CJSON::encode($data);
		}
		Yii::app()->end();
	}
	
	public function actionSetDropdownRke()
	{
		if(Yii::app()->request->isAjaxRequest) {
			$data = '';
			$rmax = isset($_POST['rmax'])?$_POST['rmax']:null;
			if(!empty($rmax)){
				for ($i = $rmax+1; $i <= 20; $i++) {
					$data .=  CHtml::tag('option', array('value'=>$i),CHtml::encode($i),true);
				}
			}
			echo CJSON::encode($data);
		}
		Yii::app()->end();
	}

	public function actionListDokter()
	{
		if(Yii::app()->request->isAjaxRequest) {
			$criteria = new CDbCriteria();
			if (isset($_GET['term'])){
				$criteria->compare('LOWER(nama_pegawai)', strtolower($_GET['term']), true);
			}
			//$criteria->compare('ruangan_id', Yii::app()->user->getState('ruangan_id'));
			$criteria->order = 'nama_pegawai';
			if (isset($_GET['idPegawai'])){
				$criteria->compare('pegawai_id', $_GET['idPegawai']);
			}
			$criteria->addCondition('kelompokpegawai_id = 1');
			$criteria->select = 'gelardepan, nama_pegawai, gelarbelakang_nama';
			$criteria->group = 'gelardepan, nama_pegawai, gelarbelakang_nama';
			$models = DokterV::model()->findAll($criteria);
			foreach($models as $i=>$model)
			{
				$attributes = $model->attributeNames();
				foreach($attributes as $j=>$attribute) {
					$returnVal[$i]["$attribute"] = $model->$attribute;
				}
				$returnVal[$i]['label'] = $model->gelardepan." ".$model->nama_pegawai.", ".$model->gelarbelakang_nama;
				$returnVal[$i]['value'] = $model->gelardepan." ".$model->nama_pegawai.", ".$model->gelarbelakang_nama;
			}

			echo CJSON::encode($returnVal);
		}
		Yii::app()->end();
	}
        
}