<?php

class PemakaianMobilController extends MyAuthController
{
    protected $successSavePemakaianBahan = true;
    protected $successSaveTindakanPelayanan = true;

	public function actionIndex($idPemesanan='',$pendaftaran_id='')
	{
            $modPemakaian = new PJPemakaianambulansT;
            $modPemakaian->tglpemakaianambulans = date('d M Y H:i:s');
            $modKunjungan=new PJInfokunjunganrjV;
            $modPasien = new PasienM;
            $modInstalasi = InstalasiM::model()->findAllByAttributes(array('instalasi_aktif'=>true),array('order'=>'instalasi_nama'));
            $instalasi = '';
            $tarif = array();
            $tarif['tarifAmbulans'][] = null;
			$format = new MyFormatter();

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
		
            if(!empty($idPemesanan)){
                $modPemakaian = $this->setDataPemakaianFromPemesanan($idPemesanan);
                $instalasi = RuanganM::model()->findByPk($modPemakaian->ruangan_id)->instalasi_id;
            }
            
            if(!empty($pendaftaran_id)){
                $modPemakaian = $this->setDataPemakaianFromPendaftaran($pendaftaran_id);
                $instalasi = RuanganM::model()->findByPk($modPemakaian->ruangan_id)->instalasi_id;
            }
            
            if(isset($_POST['PJPemakaianambulansT'])){
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
							
							$modPasien = PasienM::model()->findByPk($_POST['PJPemakaianambulansT']['pasien_id']);
                            //=== set attribute pemakaian ambulans ===//
                            $save = true;
                            $modPemakaian = new PJPemakaianambulansT;
                            $modPemakaian->attributes = $_POST['PJPemakaianambulansT'];
                            $modPemakaian->namapasien = $modPasien->nama_pasien;
                            $modPemakaian->norekammedis = $modPasien->no_rekam_medik;
                            $modPemakaian->noidentitas = $modPasien->no_identitas_pasien;
                            $modPemakaian->nomobile = !empty($modPasien->no_mobile_pasien)?$modPasien->no_mobile_pasien:'-';
                            $modPemakaian->rt_rw = $_POST['PJPemakaianambulansT']['rt'].'/'.$_POST['PJPemakaianambulansT']['rw'];
                            $modPemakaian->tarifperkm = $tarif['tarifKM'][$i];
                            $modPemakaian->jumlahkm = $tarif['jmlKM'][$i];
                            $modPemakaian->totaltarifambulans = $tarif['tarifAmbulans'][$i];
                            $modPemakaian->daftartindakanId = $tarif['daftartindakanId'][$i];
                            $instalasi = $_POST['instalasi'];
                            $format = new MyFormatter();
                            $modPemakaian->tglpemakaianambulans = $format->formatDateTimeForDb($_POST['PJPemakaianambulansT']['tglpemakaianambulans']);
                            $modPemakaian->tglkembaliambulans = $format->formatDateTimeForDb($_POST['PJPemakaianambulansT']['tglkembaliambulans']);
                            //=== save pemakaian ambulans ===//
//							echo '<pre>';
//							print_r($_POST);
//							print_r($modPasien->attributes);
//							print_r($modPemakaian->attributes);
//							$modPemakaian->validate();
//							echo CHtml::errorSummary($modPemakaian);
//							exit;
                            if($modPemakaian->validate()){
                                $save = $save && $modPemakaian->save();
                                if(!empty($modPemakaian->pendaftaran_id) && $save){
                                    $modPendaftaran = PendaftaranT::model()->findByPk($modPemakaian->pendaftaran_id);
                                    $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
                                    $tindakanPel = $this->saveTindakanPelayanan($modPasien, $modPendaftaran, $modPemakaian);
                                }
                                if(!empty($idPemesanan)){
                                    PJPesanambulansT::model()->updateByPk($idPemesanan, array('pemakaianambulans_id'=>$modPemakaian->pemakaianambulans_id));
                                }
                            } else {
                                $save = false;
                            }
                        }
                        //=== simpan pemakaian obat alkes ===//
                        if(!empty($modPemakaian->pendaftaran_id)){
                            $modPendaftaran = PendaftaranT::model()->findByPk($modPemakaian->pendaftaran_id);
                            $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
                            if(isset($_POST['pemakaianBahan']))
                                $pemakaianObat = $this->savePemakaianBahan($modPendaftaran, $_POST['pemakaianBahan']);
                        }
                        //=== commit or rollback ===//
                        if($save && $this->successSavePemakaianBahan && $this->successSaveTindakanPelayanan){

                            // SMS GATEWAY
                            $modPenanggungJawab = $modPendaftaran->penanggungjawab;
                            $sms = new Sms();

                            foreach ($modSmsgateway as $i => $smsgateway) {

                                $isiPesan = $smsgateway->templatesms;
                                $attributes = $modPemakaian->getAttributes();
                                foreach($attributes as $attributes => $value){
                                    $isiPesan = str_replace("{{".$attributes."}}",$value,$isiPesan);
                                }
                                $isiPesan = str_replace("{{hari}}",MyFormatter::getDayName($modPemakaian->tglpemakaianambulans),$isiPesan);
                                $isiPesan = str_replace("{{nama_rumahsakit}}",Yii::app()->user->getState('nama_rumahsakit'),$isiPesan);
                                
                                if($smsgateway->tujuansms == Params::TUJUANSMS_PENANGGUNGJAWAB && $smsgateway->statussms){
                                    if(!empty($modPemakaian->nomobile)){
                                        $sms->kirim($modPemakaian->nomobile,$isiPesan);
                                    }
                                }
                                
                            }
                            // END SMS GATEWAY
                            
                            $transaction->commit();
                            Yii::app()->user->setFlash('success',"Data Berhasil disimpan");
                            //=== mengosongkan nilai attribute pemakaian ambulans ===//
//                            $modPemakaian = new PJPemakaianambulansT;
//                            $modPemakaian->tglpemakaianambulans = date('d M Y H:i:s');
//                            $tarif = array();
//                            $tarif['tarifAmbulans'][] = null;
                            $sukses = 1;
                            $this->redirect(array('Index', 'sukses'=>$sukses));
                        } else {
                            $transaction->rollback();
                            Yii::app()->user->setFlash('error',"Data Gagal disimpan");
                        }
                    } catch (Exception $exc) {
                        $transaction->rollback();
                        Yii::app()->user->setFlash('error',"Data Gagal disimpan. ".MyExceptionMessage::getMessage($exc,true));
                    }
                }
                
            }
            
            $this->render('index',array('modPemakaian'=>$modPemakaian,
                                            'modPasien'=>$modPasien,
                                            'modInstalasi'=>$modInstalasi,
                                            'instalasi'=>$instalasi,
				'modKunjungan'=>$modKunjungan,
				'format'=>$format,
                                            'tarif'=>$tarif));
	}
        
        protected function setDataPemakaianFromPendaftaran($pendaftaran_id)
        {
            $modPemakaian = new PJPemakaianambulansT;
            $modPendaftaran = PendaftaranT::model()->with('pasien')->findByPk($pendaftaran_id);
            $modPemakaian->tglpemakaianambulans = date('d M Y H:i:s');
            $modPemakaian->pasien_id = $modPendaftaran->pasien_id;
            $modPemakaian->namapasien = $modPendaftaran->pasien->nama_pasien;
            $modPemakaian->nomobile = $modPendaftaran->pasien->no_mobile_pasien;
            $modPemakaian->notelepon = $modPendaftaran->pasien->no_telepon_pasien;
            $modPemakaian->norekammedis = $modPendaftaran->pasien->no_rekam_medik;
            $modPemakaian->noidentitas = $modPendaftaran->pasien->no_identitas_pasien;
            $modPemakaian->tempattujuan = '';
            $modPemakaian->alamattujuan = $modPendaftaran->pasien->alamat_pasien;
            if (isset($modPendaftaran->pasien->kelurahan)){
                $modPemakaian->kelurahan_nama = $modPendaftaran->pasien->kelurahan->kelurahan_nama;
            } else {
                $modPemakaian->kelurahan_nama = "";
            }
            $modPemakaian->rt_rw = $modPendaftaran->pasien->rt.'/'.$modPendaftaran->pasien->rw;
            $modPemakaian->rt = $modPendaftaran->pasien->rt;
            $modPemakaian->rw = $modPendaftaran->pasien->rw;
            $modPemakaian->tglpemakaianambulans = null;
            $modPemakaian->pesanambulans_t = null;
            $modPemakaian->pendaftaran_id = $pendaftaran_id;
            $modPemakaian->ruangan_id = $modPendaftaran->ruangan_id;
            
            return $modPemakaian;
        }
        
        protected function setDataPemakaianFromPemesanan($idPemesanan)
        {
            $modPemakaian = new PJPemakaianambulansT;
            $modPemesanan = PJPesanambulansT::model()->findByPk($idPemesanan);
            $modPemakaian->pasien_id = $modPemesanan->pasien_id;
            $modPemakaian->namapasien = $modPemesanan->namapasien;
            $modPemakaian->nomobile = $modPemesanan->nomobile;
            $modPemakaian->notelepon = $modPemesanan->notelepon;
            $modPemakaian->norekammedis = $modPemesanan->norekammedis;
            $modPemakaian->noidentitas = PasienM::model()->findByPk($modPemesanan->pasien_id)->no_identitas_pasien;
            $modPemakaian->tempattujuan = $modPemesanan->tempattujuan;
            $modPemakaian->alamattujuan = $modPemesanan->alamattujuan;
            $modPemakaian->kelurahan_nama = $modPemesanan->kelurahan_nama;
            $modPemakaian->rt_rw = $modPemesanan->rt_rw;
            $modPemakaian->tglpemakaianambulans = $modPemesanan->tglpemakaianambulans;
            $modPemakaian->pesanambulans_t = $idPemesanan;
            $modPemakaian->pendaftaran_id = $modPemesanan->pendaftaran_id;
            $modPemakaian->ruangan_id = $modPemesanan->ruangan_id;
            
            return $modPemakaian;
        }
        
        protected function savePemakaianBahan($modPendaftaran,$pemakaianBahan)
        {
            $valid = true;
            foreach ($pemakaianBahan as $i => $bmhp) {
                $modPakaiBahan[$i] = new PJObatalkesPasienT;
                $modPakaiBahan[$i]->pendaftaran_id = $modPendaftaran->pendaftaran_id;
                $modPakaiBahan[$i]->penjamin_id = $modPendaftaran->penjamin_id;
                $modPakaiBahan[$i]->carabayar_id = $modPendaftaran->carabayar_id;
                $modPakaiBahan[$i]->daftartindakan_id = $bmhp['daftartindakan_id'];
                $modPakaiBahan[$i]->sumberdana_id = $bmhp['sumberdana_id'];
                $modPakaiBahan[$i]->pasien_id = $modPendaftaran->pasien_id;
                $modPakaiBahan[$i]->satuankecil_id = $bmhp['satuankecil_id'];
                $modPakaiBahan[$i]->ruangan_id = Yii::app()->user->getState('ruangan_id');
                $modPakaiBahan[$i]->tipepaket_id = Params::TIPEPAKET_ID_NONPAKET;
                $modPakaiBahan[$i]->obatalkes_id = $bmhp['obatalkes_id'];
                $modPakaiBahan[$i]->pegawai_id = $modPendaftaran->pegawai_id;
                $modPakaiBahan[$i]->kelaspelayanan_id = $modPendaftaran->kelaspelayanan_id;
                $modPakaiBahan[$i]->shift_id = Yii::app()->user->getState('shift_id');
                $modPakaiBahan[$i]->tglpelayanan = date('Y-m-d H:i:s');
                $modPakaiBahan[$i]->qty_oa = $bmhp['qty'];
                $modPakaiBahan[$i]->hargajual_oa = $bmhp['subtotal'];
                $modPakaiBahan[$i]->harganetto_oa = $bmhp['harganetto'];
                $modPakaiBahan[$i]->hargasatuan_oa = $bmhp['hargasatuan'];

                $valid = $modPakaiBahan[$i]->validate() && $valid;
                if($valid) {
                    $modPakaiBahan[$i]->save();
                    $this->kurangiStok($modPakaiBahan[$i]->qty_oa, $modPakaiBahan[$i]->obatalkes_id);
                    $this->successSavePemakaianBahan = true;
                } else {
                    $this->successSavePemakaianBahan = false;
                }
            }
            
            return $modPakaiBahan;
        }
        
        protected function kurangiStok($qty,$idobatAlkes)
        {
            $sql = "SELECT stokobatalkes_id,qtystok_in,qtystok_out,qtystok_current FROM stokobatalkes_t WHERE obatalkes_id = $idobatAlkes ORDER BY tglstok_in";
            $stoks = Yii::app()->db->createCommand($sql)->queryAll();
            $selesai = false;
                foreach ($stoks as $i => $stok) {
                    if($qty <= $stok['qtystok_current']) {
                        $stok_current = $stok['qtystok_current'] - $qty;
                        $stok_out = $stok['qtystok_out'] + $qty;
                        StokobatalkesT::model()->updateByPk($stok['stokobatalkes_id'], array('qtystok_current'=>$stok_current,'qtystok_out'=>$stok_out));
                        $selesai = true;
                        break;
                    } else {
                        $qty = $qty - $stok['qtystok_current'];
                        $stok_current = 0;
                        $stok_out = $stok['qtystok_out'] + $stok['qtystok_current'];
                        StokobatalkesT::model()->updateByPk($stok['stokobatalkes_id'], array('stok_current'=>$stok_current,'qtystok_out'=>$stok_out));
                    }
                }
        }
        
        protected function kembalikanStok($obatAlkesT)
        {
            foreach ($obatAlkesT as $i => $obatAlkes) {
                $stok = new StokObatalkesT;
				$stok->unsetIdTransaksi();
                $stok->obatalkes_id = $obatAlkes->obatalkes_id;
                $stok->sumberdana_id = $obatAlkes->sumberdana_id;
                $stok->ruangan_id = Yii::app()->user->getState('ruangan_id');
                $stok->tglstok_in = date('Y-m-d H:i:s');
                $stok->tglstok_out = date('Y-m-d H:i:s');
                $stok->qtystok_in = $obatAlkes->qty_oa;
                $stok->qtystok_out = 0;
                $stok->harganetto_oa = $obatAlkes->harganetto_oa;
                $stok->hargajual_oa = $obatAlkes->hargasatuan_oa;
                $stok->discount = $obatAlkes->discount;
                $stok->satuankecil_id = $obatAlkes->satuankecil_id;
                $stok->save();
            }
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
            
            if($modTindakan->save()){
                $this->successSaveTindakanPelayanan &= $modTindakan->saveTindakanKomponen();
            } else {
                $this->successSaveTindakanPelayanan = false;
                Yii::app()->user->setFlash('info','<pre>'.print_r($modTindakan->getErrors(),1).'</pre>');
            }
            
            return $this->successSaveTindakanPelayanan;
        }
                
        public function actionDynamicRuangan()
        {
            $data = RuanganM::model()->findAll('instalasi_id=:instalasi_id AND ruangan_aktif = TRUE order by ruangan_nama', 
                  array(':instalasi_id'=>(int) $_POST['instalasi']));

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
		
		public function actionAddFormPemakaianBahan()
		{
			if (Yii::app()->request->isAjaxRequest)
			{
				$pendaftaran_id = (isset($_POST['pendaftaran_id']) ? $_POST['pendaftaran_id'] : null);
				$idObatAlkes = (isset($_POST['idObatAlkes']) ? $_POST['idObatAlkes'] : null);
				$idDaftartindakan = (isset($_POST['idDaftartindakan']) ? $_POST['idDaftartindakan'] : "");
				$modObatAlkes = ObatalkesM::model()->findByPk($idObatAlkes);
				$modDaftartindakan = DaftartindakanM::model()->findByPk($idDaftartindakan);
				$modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);

				echo CJSON::encode(array(
					'pendaftaran_id'=>$pendaftaran_id,
					'namaObat'=>$modObatAlkes->obatalkes_nama,
					'form'=>$this->renderPartial('_formAddPemakaianBahan', array('modObatAlkes'=>$modObatAlkes,'modDaftartindakan'=>$modDaftartindakan,
						'modPendaftaran'=>$modPendaftaran,
						), true),
					));
				exit;               
			}
		}
		
		public function actionPasienJenazah()
        {
            if(Yii::app()->request->isAjaxRequest) { 
                $criteria = new CDbCriteria();
                $criteria->compare('LOWER(no_rekam_medik)', strtolower($_GET['term']), true);
                $criteria->order = 'no_rekam_medik';
                $criteria->compare('ruangan_id', Yii::app()->user->getState('ruangan_id'));
                $criteria->limit=10;
                $models = PasienmasukpenunjangV::model()->findAll($criteria);

                foreach($models as $i=>$model)
                {
                    $attributes = $model->attributeNames();
                    foreach($attributes as $j=>$attribute) {
                        $returnVal[$i]["$attribute"] = $model->$attribute;
                    }
                    $returnVal[$i]['label'] = $model->no_rekam_medik.' - '.$model->no_pendaftaran;
                    $returnVal[$i]['value'] = $model->no_rekam_medik;
                }

                echo CJSON::encode($returnVal);
            }
            Yii::app()->end();
        }
		
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
            if($instalasi_id == Params::INSTALASI_ID_RJ){
                $model = PJInfokunjunganrjV::model()->find($criteria);
            }else if($instalasi_id == Params::INSTALASI_ID_RD){
                $model = PJInfoKunjunganRDV::model()->find($criteria);
            }else if($instalasi_id == Params::INSTALASI_ID_RI){
                $model = PJPasienrawatinapV::model()->find($criteria);
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
}