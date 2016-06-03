<?php

Yii::import('farmasiApotek.controllers.PenjualanResepRSController');
Yii::import('farmasiApotek.views.penjualanResepRS.*');

class PenjualanKaryawanController extends PenjualanResepRSController {

    public $defaultAction = 'index';
    public $path_view = 'farmasiApotek.views.penjualanResepRS.';
    public $path_view_karyawan = 'farmasiApotek.views.penjualanKaryawan.';
    public $obatalkespasientersimpan = true; //looping
    public $stokobatalkestersimpan = true; //looping

    public function actionIndex($penjualanresep_id = null) {
        $format = new MyFormatter();
        $sukses = false;
        $modPendaftaran = new FAPendaftaranT;
        $modInfoPegawai = new FAPegawaiV;
        $modInfoDokter = new FADokterV;
        $modPasien = new FAPasienM;
        $modReseptur = new FAResepturT;
        $modAntrian = new FAAntrianFarmasiT;
        $modObatAlkesPasien = array();
        $instalasi_id = Yii::app()->user->getState('instalasi_id');
        $modReseptur->noresep = MyGenerator::noResep($instalasi_id);
        $modReseptur->noresep_depan = $modReseptur->noresep . '/';
        $modReseptur->tglreseptur = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($modReseptur->tglreseptur, 'yyyy-MM-dd hh:mm:ss', 'medium', null));
        $modPenjualan = new FAPenjualanResepT;
        $modPenjualan->tglpenjualan = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($modPenjualan->tglpenjualan, 'yyyy-MM-dd hh:mm:ss', 'medium', null));
        $modPenjualan->tglresep = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($modPenjualan->tglresep, 'yyyy-MM-dd hh:mm:ss', 'medium', null));
        $modPenjualan->noresep = MyGenerator::noResep($instalasi_id);
        ;
        $modPenjualan->jenispenjualan = 'PENJUALAN PEGAWAI';
        $modPenjualan->carabayar_id = Params::CARABAYAR_ID_MEMBAYAR;
        $modPenjualan->penjamin_id = Params::PENJAMIN_ID_UMUM;
        $modPenjualan->totharganetto = 0;
        $modPenjualan->totalhargajual = 0;
        $modPenjualan->totaltarifservice = 0;
        $modPenjualan->biayaadministrasi = 0;
        $modPenjualan->biayakonseling = 0;
        $modPenjualan->pembulatanharga = 0;
        $modPenjualan->jasadokterresep = 0;
        $modPenjualan->discount = 0;
        $modPenjualan->subsidiasuransi = 0;
        $modPenjualan->subsidipemerintah = 0;
        $modPenjualan->subsidirs = 0;
        $modPenjualan->iurbiaya = 0;

        $modObatAlkes = array();

        $nama_modul = Yii::app()->controller->module->id;
        $nama_controller = Yii::app()->controller->id;
        $nama_action = Yii::app()->controller->action->id;
        $modul_id = ModulK::model()->findByAttributes(array('url_modul' => $nama_modul))->modul_id;
        $criteria = new CDbCriteria;
        $criteria->compare('modul_id', $modul_id);
        $criteria->compare('LOWER(modcontroller)', strtolower($nama_controller), true);
        $criteria->compare('LOWER(modaction)', strtolower($nama_action), true);
        if (isset($_POST['tujuansms'])) {
            $criteria->addInCondition('tujuansms', $_POST['tujuansms']);
        }
        $modSmsgateway = SmsgatewayM::model()->findAll($criteria);

        if (!empty($penjualanresep_id)) {
            $modPenjualan = FAPenjualanResepT::model()->findByPk($penjualanresep_id);
            $modObatAlkesPasien = FAObatalkesPasienT::model()->findAllByAttributes(array('penjualanresep_id' => $modPenjualan->penjualanresep_id));
            $modPenjualan->pegawai_id = (isset($modPenjualan->pegawai_id) ? NULL : $modPenjualan->pegawai_id);
//            $modPenjualan->pegawai_id = isset($modPenjualan->pegawai->NamaLengkap) ? $modPenjualan->pegawai->NamaLengkap : "";
            $modInfoPegawai->nomorindukpegawai = $modPenjualan->pasienpegawai->nomorindukpegawai;
            $modInfoPegawai->nama_pegawai = isset($modPenjualan->pasienpegawai->NamaLengkap) ? $modPenjualan->pasienpegawai->NamaLengkap : "";
            $modInfoPegawai->jeniskelamin = $modPenjualan->pasienpegawai->jeniskelamin;
            $modInfoPegawai->alamat_pegawai = $modPenjualan->pasienpegawai->alamat_pegawai;
        }

        $modAntrian->tglambilantrian = date('Y-m-d H:i:s');
        $racikan = RacikanM::model()->findByPk(Params::RACIKAN_ID_RACIKAN);
        $nonRacikan = RacikanM::model()->findByPk(Params::RACIKAN_ID_NONRACIKAN);
        $modRacikanDetail = RacikandetailM::model()->findAll(); //load semua data untuk perhitungan js & jquery
        $racikanDetail = array();
        foreach ($modRacikanDetail as $i => $mod) { //convert object to array
            $racikanDetail[$i]['racikandetail_id'] = $mod->racikandetail_id;
            $racikanDetail[$i]['racikan_id'] = $mod->racikan_id;
            $racikanDetail[$i]['qtymin'] = $mod->qtymin;
            $racikanDetail[$i]['qtymaks'] = $mod->qtymaks;
            $racikanDetail[$i]['tarifservice'] = $mod->tarifservice;
        }

        $transaction = Yii::app()->db->beginTransaction();
        if (isset($_POST['FAPenjualanResepT'])) {
            //var_dump($_POST); die;
            $modPasien = FAPasienM::model()->findByPk($_POST['pasien_id']);
            //var_dump($modPasien->attributes); die;
            $modPenjualan = $this->savePenjualanResep($modPasien, $_POST['FAPenjualanResepT']);
            if ($this->penjualantersimpan) {

                if (count($_POST['FAObatalkesPasienT']) > 0) {
                    //PROSES GROUP DETAIL BERDASARKAN obatalkes_id & akumulasikan jmlmutasi
                    $detailGroups = array();
                    foreach ($_POST['FAObatalkesPasienT'] AS $i => $postDetail) {
                        $modDetails[$i] = new FAObatalkesPasienT;
                        $modDetails[$i]->attributes = $postDetail;
                        if (empty($modDetails[$i]->pegawai_id) || $modDetails[$i]->pegawai_id == 0) {
                            $modDetails[$i]->pegawai_id = Yii::app()->user->getState('pegawai_id');
                        }
                        
                        $modDetails[$i] = $this->simpanObatAlkesPasien2($modPasien, $modPenjualan, $postDetail);
                        
                        
                        
                        $this->simpanStokObatAlkesOut2($modDetails[$i]);
                        /*
                        $modStok = StokobatalkesT::model()->findByPk($postDetail['stokobatalkes_id']);
                        $modDetails[$i]->stokobatalkes_id = $modStok->stokobatalkes_id;
                        $obatalkes_id = $postDetail['obatalkes_id'];
                        if (isset($detailGroups[$obatalkes_id])) {
                            $detailGroups[$obatalkes_id]['qty_oa'] += $postDetail['qty_oa'];
                        } else {
                            $detailGroups[$obatalkes_id]['obatalkes_id'] = $postDetail['obatalkes_id'];
                            $detailGroups[$obatalkes_id]['qty_oa'] = $postDetail['qty_oa'];
                        }*/
                    }
                    //END GROUP
                }

                /*
                $obathabis = "";
                //PROSES PENGURAIAN OBAT DAN JUMLAH MENJADI STOKOBATALKES_T (METODE ANTRIAN)
                foreach ($detailGroups AS $i => $detail) {
                    $modStokOAs = StokobatalkesT::getStokObatAlkesAktif($detail['obatalkes_id'], $detail['qty_oa'], Yii::app()->user->getState('ruangan_id'));

                    if (count($modStokOAs) > 0) {
                        foreach ($modStokOAs AS $i => $stok) {
                            $modDetails[$i] = $this->simpanObatAlkesPasien($modPasien, $modPenjualan, $stok, $_POST['FAObatalkesPasienT']);
                            $this->simpanStokObatAlkesOut($stok['stokobatalkes_id'], $modDetails[$i]);
                        }
                    } else {
                        $this->stokobatalkestersimpan &= false;
                        $obathabis .= "<br>- " . ObatalkesM::model()->findByPk($detail['obatalkes_id'])->obatalkes_nama;
                    }
                }
                 * 
                 */
                //var_dump($this->obatalkespasientersimpan && $this->stokobatalkestersimpan);
                //die;
                try {
                    if ($this->obatalkespasientersimpan && $this->stokobatalkestersimpan) {
                        if (isset($modPenjualan->pegawai_id) && !empty($modPenjualan->pegawai_id)) {
                            // SMS GATEWAY
                            $sms = new Sms();
                            $smspegawai = 1;
                            $modPegawai = $modPenjualan->pegawai;
                            foreach ($modSmsgateway as $i => $smsgateway) {
                                $isiPesan = $smsgateway->templatesms;

                                $attributes = $modPegawai->getAttributes();
                                foreach ($attributes as $attributes => $value) {
                                    $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
                                }
                                $attributes = $modPenjualan->getAttributes();
                                foreach ($attributes as $attributes => $value) {
                                    $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
                                }

                                $isiPesan = str_replace("{{hari}}", MyFormatter::getDayName($modPenjualan->tglpenjualan), $isiPesan);

                                if ($smsgateway->tujuansms == Params::TUJUANSMS_PEGAWAI && $smsgateway->statussms) {
                                    if (!empty($modPegawai->nomobile_pegawai)) {
                                        $sms->kirim($modPegawai->nomobile_pegawai, $isiPesan);
                                    } else {
                                        $smspegawai = 0;
                                    }
                                }
                            }
                            // END SMS GATEWAY
                        }
                        $transaction->commit();
                        $sukses = 1;
                        if (isset($modPenjualan->pegawai_id) && !empty($modPenjualan->pegawai_id)) {
                            $this->redirect(array('index', 'penjualanresep_id' => $modPenjualan->penjualanresep_id, 'sukses' => $sukses, 'smspegawai' => $smspegawai));
                        } else {
                            $this->redirect(array('index', 'penjualanresep_id' => $modPenjualan->penjualanresep_id, 'sukses' => $sukses));
                        }
                    } else {
                        $transaction->rollback();
                        Yii::app()->user->setFlash('error', "Data detail penjualan resep gagal disimpan !");
                        if (!$this->stokobatalkestersimpan) {
                            Yii::app()->user->setFlash('error', "Data ddetail penjualan resep gagal disimpan ! Stok obat berikut tidak mencukupi !:" . $obathabis);
                        }
                    }
                } catch (Exception $e) {
                    $transaction->rollback();
                    Yii::app()->user->setFlash('error', "Data penjualan resep gagal disimpan ! " . MyExceptionMessage::getMessage($e, true));
                }
            }
        }

        $this->render('index', array(
            'modReseptur' => $modReseptur,
            'modPendaftaran' => $modPendaftaran,
            'modInfoPegawai' => $modInfoPegawai,
            'modInfoDokter' => $modInfoDokter,
            'modPasien' => $modPasien,
            'modPenjualan' => $modPenjualan,
            'modAntrian' => $modAntrian,
            'modObatAlkesPasien' => $modObatAlkesPasien,
            'racikan' => $racikan,
            'racikanDetail' => $racikanDetail,
            'nonRacikan' => $nonRacikan,
            'obatAlkes' => $modObatAlkes,
            'sukses' => $sukses,
        ));
    }

    protected function savePenjualanResep($modPasien, $penjualanResep) {
        $format = new MyFormatter();
        $modPenjualan = new FAPenjualanResepT;
        $modPenjualan->attributes = $penjualanResep;
        $modPenjualan->pendaftaran_id = null;
        $modPenjualan->penjamin_id = $penjualanResep['penjamin_id'];
        $modPenjualan->carabayar_id = $penjualanResep['carabayar_id'];
        $modPenjualan->antrianfarmasi_id = isset($penjualanResep['antrianfarmasi_id']) ? $penjualanResep['antrianfarmasi_id'] : null;
        $modPenjualan->pegawai_id = $penjualanResep['pegawai_id'];
        $modPenjualan->kelaspelayanan_id = null;
        $modPenjualan->pasien_id = $modPasien->pasien_id;
        $modPenjualan->pasienpegawai_id = $penjualanResep['pasienpegawai_id'];
        $modPenjualan->pasienadmisi_id = null;
        $modPenjualan->tglpenjualan = $format->formatDateTimeForDb($_POST['FAPenjualanResepT']['tglpenjualan']);
        $modPenjualan->tglresep = date('Y-m-d H:i:s');
        $modPenjualan->ruanganasal_nama = '-';
        $modPenjualan->ruangan_id = Yii::app()->user->getState('ruangan_id');
        $modPenjualan->pembulatanharga = Yii::app()->user->getState('pembulatanharga');
        $modPenjualan->noresep = isset($_POST['FAPenjualanResepT']['noresep']) ? $_POST['FAPenjualanResepT']['noresep'] : $_POST['FAResepturT']['noresep'];
        $modPenjualan->subsidiasuransi = 0;
        $modPenjualan->subsidipemerintah = 0;
        $modPenjualan->subsidirs = 0;
        $modPenjualan->iurbiaya = 0;
        $modPenjualan->discount = 0;
        $modPenjualan->create_time = date("Y-m-d H:i:s");
        $modPenjualan->create_loginpemakai_id = Yii::app()->user->id;
        $modPenjualan->create_ruangan = Yii::app()->user->getState('ruangan_id');
        if ($modPenjualan->validate()) {
            $modPenjualan->save();
            $this->penjualantersimpan = true;
        } else {
            $this->penjualantersimpan = false;
            Yii::app()->user->setFlash('error', "Data Penjualan Resep Tidak valid");
        }

        return $modPenjualan;
    }

    /**
     * simpan ObatalkesPasienT Jumlah Out
     * @param type $modPenjualan
     * @param type $postObatAlkesPasien
     * @return \ObatalkesPasienT
     */
    protected function simpanObatAlkesPasien2($modPasien, $modPenjualan, $postObatAlkesPasien) {
        //var_dump($postObatAlkesPasien);
        $oa = ObatalkesM::model()->findByPk($postObatAlkesPasien['obatalkes_id']);
        $format = new MyFormatter;
        $modObatAlkes = new FAObatalkesPasienT;
        $modObatAlkes->attributes = $oa->attributes;
        $modObatAlkes->attributes = $postObatAlkesPasien;
        $modObatAlkes->tglpelayanan = date("Y-m-d H:i:s");
        $modObatAlkes->tipepaket_id = Params::TIPEPAKET_ID_NONPAKET;
        $modObatAlkes->ruangan_id = Yii::app()->user->getState('ruangan_id');
        $modObatAlkes->carabayar_id = $modPenjualan->carabayar_id;
        $modObatAlkes->pegawai_id = Yii::app()->user->getState('pegawai_id');
        if (empty($modObatAlkes->pegawai_id)) $modObatAlkes->pegawai_id = $modPenjualan->pegawai_id; 
        $modObatAlkes->shift_id = Yii::app()->user->getState('shift_id');
        $modObatAlkes->pendaftaran_id = null;
        $modObatAlkes->pasien_id = $modPasien->pasien_id;
        $modObatAlkes->penjamin_id = $modPenjualan->penjamin_id;
        $modObatAlkes->create_time = date("Y-m-d H:i:s");
        $modObatAlkes->create_loginpemakai_id = Yii::app()->user->id;
        $modObatAlkes->create_ruangan = Yii::app()->user->getState('ruangan_id');
        $modObatAlkes->penjualanresep_id = $modPenjualan->penjualanresep_id;
        $modObatAlkes->permintaan_oa = MyFormatter::formatNumberForDb($modObatAlkes->permintaan_oa);
        //$modObatAlkes->qty_oa = $stokOa->qtystok_terpakai;
        //$modObatAlkes->jmlstok = $stokOa->qtystok;
        //$modObatAlkes->harganetto_oa = $stokOa->HPP;
        //$modObatAlkes->hargasatuan_oa = $stokOa->HargaJualSatuan;
        $modObatAlkes->hargajual_oa = $modObatAlkes->hargasatuan_oa * $modObatAlkes->qty_oa;
        //foreach ($postObatAlkesPasien AS $i => $postDetail) {
            //if ($stokOa->obatalkes_id == $postDetail['obatalkes_id']) {
                $modObatAlkes->sumberdana_id = $postObatAlkesPasien['sumberdana_id'];
                $modObatAlkes->r = $postObatAlkesPasien['r'];
                $modObatAlkes->rke = $postObatAlkesPasien['rke'];
                // $modObatAlkes->permintaan_oa = $postObatAlkesPasien['permintaan_oa'];
                $modObatAlkes->kekuatan_oa = $postObatAlkesPasien['kekuatan_oa'];
                $modObatAlkes->jmlkemasan_oa = $postObatAlkesPasien['jmlkemasan_oa'];
//                $modObatAlkes->biayaservice = $postDetail['biayaservice'];
//                $modObatAlkes->biayakonseling = $postDetail['biayakonseling'];
//                $modObatAlkes->jasadokterresep = $postDetail['jasadokterresep'];
//                $modObatAlkes->biayakemasan = $postDetail['biayakemasan'];
//                $modObatAlkes->biayaadministrasi = $postDetail['biayaadministrasi'];
//                $modObatAlkes->tarifcyto = $postDetail['tarifcyto'];
//                $modObatAlkes->subsidiasuransi = $postDetail['subsidiasuransi'];
//                $modObatAlkes->subsidipemerintah = $postDetail['subsidipemerintah'];
//                $modObatAlkes->subsidirs = $postDetail['subsidirs'];
//                $modObatAlkes->discount = $postDetail['discount'];
                $modObatAlkes->signa_oa = $postObatAlkesPasien['signa_oa'];
                $modObatAlkes->etiket = $postObatAlkesPasien['etiket'];
            //}
            //$modObatAlkes->iurbiaya = $modObatAlkes->hargajual_oa;
        //}
                
        // var_dump($modObatAlkes->attributes); die;

        if ($modObatAlkes->save()) {
            $this->obatalkespasientersimpan &= true;
        } else {
            $this->obatalkespasientersimpan &= false;
        }
        return $modObatAlkes;
    }
    
    /**
     * simpan ObatalkesPasienT Jumlah Out
     * @param type $modPenjualan
     * @param type $postObatAlkesPasien
     * @return \ObatalkesPasienT
     */
    protected function simpanObatAlkesPasien($modPasien, $modPenjualan, $stokOa, $postObatAlkesPasien) {
        $format = new MyFormatter;
        $modObatAlkes = new FAObatalkesPasienT;
        $modObatAlkes->attributes = $stokOa->attributes;
        $modObatAlkes->tglpelayanan = date("Y-m-d H:i:s");
        $modObatAlkes->tipepaket_id = Params::TIPEPAKET_ID_NONPAKET;
        $modObatAlkes->ruangan_id = Yii::app()->user->getState('ruangan_id');
        $modObatAlkes->carabayar_id = $modPenjualan->carabayar_id;
        $modObatAlkes->pegawai_id = Yii::app()->user->getState('pegawai_id');
        $modObatAlkes->shift_id = Yii::app()->user->getState('shift_id');
        $modObatAlkes->pendaftaran_id = null;
        $modObatAlkes->pasien_id = $modPasien->pasien_id;
        $modObatAlkes->penjamin_id = $modPenjualan->penjamin_id;
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
            if ($stokOa->obatalkes_id == $postDetail['obatalkes_id']) {
                $modObatAlkes->sumberdana_id = $postDetail['sumberdana_id'];
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
//                $modObatAlkes->discount = $postDetail['discount'];
                $modObatAlkes->signa_oa = $postDetail['signa_oa'];
                $modObatAlkes->etiket = $postDetail['etiket'];
            }
            $modObatAlkes->iurbiaya = $modObatAlkes->hargajual_oa;
        }

        if ($modObatAlkes->save()) {
            $this->obatalkespasientersimpan &= true;
        } else {
            $this->obatalkespasientersimpan &= false;
        }
        return $modObatAlkes;
    }

    /**
     * Mengurai data pasien berdasarkan:
     * - pegawai_id
     * - nomorindukpegawai
     * - nama_pegawai
     * @throws CHttpException
     */
    public function actionGetDataInfoPegawai() {
        if (Yii::app()->request->isAjaxRequest) {
            $format = new MyFormatter();
            $pegawai_id = isset($_POST['pegawai_id']) ? $_POST['pegawai_id'] : null;
            $nama_pegawai = isset($_POST['$nama_pegawai']) ? $_POST['$nama_pegawai'] : null;
            $returnVal = array();

            $criteria = new CDbCriteria();
            if (!empty($pegawai_id)) {
                $criteria->addCondition("pegawai_id = " . $pegawai_id);
            }
            $criteria->compare('LOWER(nama_pegawai)', strtolower($nama_pegawai));
            $model = FAPegawaiV::model()->find($criteria);
            $attributes = $model->attributeNames();
            foreach ($attributes as $j => $attribute) {
                $returnVal["$attribute"] = $model->$attribute;
                if (file_exists(Params::urlPegawaiTumbsDirectory() . 'kecil_' . $model->photopegawai)) {
                    $photopegawai = $model->photopegawai;
                } else {
                    $photopegawai = '';
                }
            }

            $returnVal["pasien_id"] = PARAMS::DEFAULT_PASIEN_APOTEK_KARYAWAN;
            $returnVal["photopegawai"] = $photopegawai;
            $returnVal["nama_pegawai_lengkap"] = $model->NamaLengkap;
            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }

    /**
     * set dropdown penjamin pasien dari carabayar_id
     * @param type $encode
     * @param type $namaModel
     */
    public function actionSetDropdownPenjaminPasien($encode = false, $namaModel = '') {
        if (Yii::app()->request->isAjaxRequest) {
            $carabayar_id = $_POST["$namaModel"]['carabayar_id'];
            if ($encode) {
                echo CJSON::encode($penjamin);
            } else {
                if (empty($carabayar_id)) {
                    echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
                } else {
                    $penjamin = PenjaminpasienM::model()->findAllByAttributes(array('carabayar_id' => $carabayar_id), array('order' => 'penjamin_nama ASC'));
                    if (count($penjamin) > 1) {
                        echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
                    }
                    $penjamin = CHtml::listData($penjamin, 'penjamin_id', 'penjamin_nama');
                    foreach ($penjamin as $value => $name) {
                        echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
                    }
                }
            }
        }
        Yii::app()->end();
    }

    /**
     * untuk menampilkan data kunjungan dari autocomplete
     * - nomorindukpegawai
     * - nama_pasien
     * - jeniskelamin
     * - alamat_pegawai
     */
    public function actionAutocompleteInfoPegawai() {
        if (Yii::app()->request->isAjaxRequest) {
            $format = new MyFormatter();
            $returnVal = array();
            $nomorindukpegawai = isset($_GET['nomorindukpegawai']) ? $_GET['nomorindukpegawai'] : null;
            $nama_pegawai = isset($_GET['nama_pegawai']) ? $_GET['nama_pegawai'] : null;
            $criteria = new CDbCriteria();
            $criteria->group = 'pegawai_id,nomorindukpegawai,nama_pegawai,gelardepan,gelarbelakang_nama,alamat_pegawai,jeniskelamin';
            $criteria->select = $criteria->group;
            $criteria->compare('LOWER(nomorindukpegawai)', strtolower($nomorindukpegawai), true);
            $criteria->compare('LOWER(nama_pegawai)', strtolower($nama_pegawai), true);
            $criteria->order = 'nomorindukpegawai, nama_pegawai';
            $criteria->limit = 5;
            $models = FAPegawaiV::model()->findAll($criteria);
            foreach ($models as $i => $model) {
                $attributes = $model->attributeNames();
                foreach ($attributes as $j => $attribute) {
                    $returnVal[$i]["$attribute"] = $model->$attribute;
                }
                $returnVal[$i]['label'] = $model->nomorindukpegawai . ' - ' . $model->NamaLengkap;
                $returnVal[$i]['value'] = $model->nomorindukpegawai;
            }

            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }

    /**
     * untuk print data penjualan pegawai
     */
    public function actionPrint($penjualanresep_id, $caraPrint = null) {
        $this->layout = '//layouts/iframe';
        $format = new MyFormatter;
        $modPenjualan = FAPenjualanResepT::model()->findByPk($penjualanresep_id);
        $modPenjualanDetail = FAObatalkesPasienT::model()->findAllByAttributes(array('penjualanresep_id' => $penjualanresep_id));

        $judul_print = isset($modPenjualan->jenispenjualan) ? $modPenjualan->jenispenjualan : "";
        $caraPrint = isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null;
        if ($caraPrint == 'PRINT') {
            $this->layout = '//layouts/printWindows';
        } else if ($caraPrint == 'EXCEL') {
            $this->layout = '//layouts/printExcel';
        }

        $this->render($this->path_view_karyawan . 'Print', array(
            'format' => $format,
            'judul_print' => $judul_print,
            'modPenjualan' => $modPenjualan,
            'modPenjualanDetail' => $modPenjualanDetail,
            'caraPrint' => $caraPrint
        ));
    }

    /**
     * untuk menampilkan data kunjungan dari autocomplete
     * - nomorindukpegawai
     * - nama_pasien
     * - jeniskelamin
     * - alamat_pegawai
     */
    public function actionAutocompleteInfoDokter() {
        if (Yii::app()->request->isAjaxRequest) {
            $format = new MyFormatter();
            $returnVal = array();
            $nomorindukpegawai = isset($_GET['nomorindukpegawai']) ? $_GET['nomorindukpegawai'] : null;
            $nama_pegawai = isset($_GET['nama_pegawai']) ? $_GET['nama_pegawai'] : null;
            $criteria = new CDbCriteria();
            $criteria->group = 'pegawai_id,nomorindukpegawai,nama_pegawai,gelardepan,gelarbelakang_nama,alamat_pegawai,jeniskelamin';
            $criteria->select = $criteria->group;
            $criteria->compare('LOWER(nomorindukpegawai)', strtolower($nomorindukpegawai), true);
            $criteria->compare('LOWER(nama_pegawai)', strtolower($nama_pegawai), true);
            $criteria->order = 'nomorindukpegawai, nama_pegawai';
            $criteria->limit = 5;
            $models = FADokterV::model()->findAll($criteria);
            foreach ($models as $i => $model) {
                $attributes = $model->attributeNames();
                foreach ($attributes as $j => $attribute) {
                    $returnVal[$i]["$attribute"] = $model->$attribute;
                }
                $returnVal[$i]['label'] = $model->nomorindukpegawai . ' - ' . $model->NamaLengkap;
                $returnVal[$i]['value'] = $model->nomorindukpegawai;
            }

            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }

    /**
     * Mengurai data pasien berdasarkan:
     * - pegawai_id
     * - nomorindukpegawai
     * - nama_pegawai
     * @throws CHttpException
     */
    public function actionGetDataInfoDokter() {
        if (Yii::app()->request->isAjaxRequest) {
            $format = new MyFormatter();
            $pegawai_id = isset($_POST['pegawai_id']) ? $_POST['pegawai_id'] : null;
            $nama_pegawai = isset($_POST['$nama_pegawai']) ? $_POST['$nama_pegawai'] : null;
            $returnVal = array();

            $criteria = new CDbCriteria();
            if (!empty($pegawai_id)) {
                $criteria->addCondition("pegawai_id = " . $pegawai_id);
            }
            $criteria->compare('LOWER(nama_pegawai)', strtolower($nama_pegawai));
            $model = FADokterV::model()->find($criteria);
            $attributes = $model->attributeNames();
            foreach ($attributes as $j => $attribute) {
                $returnVal["$attribute"] = $model->$attribute;
            }
            foreach ($attributes as $j => $attribute) {
                $returnVal["$attribute"] = $model->$attribute;
                if (file_exists(Params::urlPegawaiTumbsDirectory() . 'kecil_' . $model->photopegawai)) {
                    $photopegawai = $model->photopegawai;
                } else {
                    $photopegawai = '';
                }
            }
            $returnVal["pasien_id"] = PARAMS::DEFAULT_PASIEN_APOTEK_DOKTER;
            $returnVal["photopegawai"] = $photopegawai;
            $returnVal["nama_pegawai_lengkap"] = $model->NamaLengkap;
            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }

}
?>

