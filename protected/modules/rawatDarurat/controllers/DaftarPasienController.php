<?php

class DaftarPasienController extends MyAuthController {

    public $validRujukan = false;
    public $validPulang = false;

    public function actionRincian($id) {
        $this->layout = '//layouts/iframe';
        $data['judulLaporan'] = 'Rincian Tagihan Pasien';
        $modPendaftaran = RDPendaftaranT::model()->findByPk($id);
        $modRincian = RDRinciantagihanpasienV::model()->findAllByAttributes(array('pendaftaran_id' => $id), array('order' => 'ruangan_id'));
        $data['nama_pegawai'] = LoginpemakaiK::model()->findByPK(Yii::app()->user->id)->pegawai->nama_pegawai;
//            $modRincian->pendaftaran_id = $id;
        $this->render('/rinciantagihanpasienV/rincian', array('modPendaftaran' => $modPendaftaran, 'modRincian' => $modRincian, 'data' => $data));
    }

    public function actionPrint($id = null) {
        //$this->layout='//layouts/iframe';
        //  $modPendaftaran = RDPendaftaranT::model()->with('carabayar','penjamin')->findByPk($id);
        $modPendaftaran = RDPendaftaranT::model()->findByPk($id);
        $modRincian = RDRinciantagihanpasienV::model()->findAllByAttributes(array('pendaftaran_id' => $id), array('order' => 'ruangan_id'));
        $data['nama_pegawai'] = LoginpemakaiK::model()->findByPK(Yii::app()->user->id)->pegawai->nama_pegawai;


        $judulLaporan = 'Data Rincian';
        $caraPrint = $_REQUEST['caraPrint'];

        if ($caraPrint == 'PRINT') {
            $this->layout = '//layouts/printWindows';
            $this->render('/rinciantagihanpasienV/detailRincian', array('modPendaftaran' => $modPendaftaran,
                'modRincian' => $modRincian,
                // 'modPasien'=>$modPasien, 
                'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint
            ));
        } else if ($caraPrint == 'EXCEL') {
            $this->layout = '//layouts/printExcel';
            $this->render('/rinciantagihanpasienV/detailRincian', array('modPendaftaran' => $modPendaftaran,
                'modRincian' => $modRincian,
                //  'modPasien'=>$modPasien,
                'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint
            ));
        } else if ($_REQUEST['caraPrint'] == 'PDF') {

            $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
            $posisi = Yii::app()->user->getState('posisi_kertas');                            //Posisi L->Landscape,P->Portait
            $mpdf = new MyPDF('', $ukuranKertasPDF);
            $mpdf->useOddEven = 2;
            $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
            $mpdf->WriteHTML($stylesheet, 1);
            $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
            $mpdf->WriteHTML($this->renderPartial('/rinciantagihanpasienV/detailRincian', array('modPendaftaran' => $modPendaftaran, 'modRincian' => $modRincian,
                        // 'modPasien'=>$modPasien,
                        'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
            $mpdf->Output();
        }
    }

    public function actionIndex() {
        $format = new MyFormatter();
        $this->pageTitle = Yii::app()->name . " - Daftar Pasien Rawat Darurat";
        $model = new RDInfoKunjunganRDV;
        $model->tgl_awal = date('Y-m-d');
        $model->tgl_akhir = date('Y-m-d');
        $model->ceklis = true;
        if (isset($_REQUEST['RDInfoKunjunganRDV'])) {
            $model->attributes = $_REQUEST['RDInfoKunjunganRDV'];
            $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['RDInfoKunjunganRDV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['RDInfoKunjunganRDV']['tgl_akhir']);
            $model->prefix_pendaftaran = $_REQUEST['RDInfoKunjunganRDV']['prefix_pendaftaran'];
            //$model->ceklis = $_REQUEST['RDInfoKunjunganRDV']['ceklis'];
        }
        if (Yii::app()->request->isAjaxRequest) {
            echo $this->renderPartial('_tablePasien', array('model' => $model));
        } else {
            $this->render('index', array('format' => $format, 'model' => $model));
        }
    }

    public function actionBatalRawatInap($pendaftaran_id) {
        $this->layout = '//layouts/iframe';
        $modPendaftaran = RDPendaftaranT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id));
        $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);

        $modPasienBatalPulang = new PasienbatalpulangT;
        $tersimpan = 'tidak';

        if (!empty($_POST['PasienbatalpulangT'])) {
        
        
            $pasienPulangId = $_POST['pasienpulang_id'];
            $pendaftaran_id = $_POST['pendaftaran_id'];
            $format = new MyFormatter();
            $modPasienBatalPulang->attributes = $_POST['PasienbatalpulangT'];
            $modPasienBatalPulang->create_time = date('Y-m-d H:i:s');
            $modPasienBatalPulang->update_time = date('Y-m-d H:i:s');
            $modPasienBatalPulang->tglpembatalan = $format->formatDateTimeForDb($modPasienBatalPulang->tglpembatalan);
            $modPasienBatalPulang->namauser_otorisasi = Yii::app()->user->name;
            $modPasienBatalPulang->iduser_otorisasi = Yii::app()->user->id;
            $modPasienBatalPulang->create_loginpemakai_id = Yii::app()->user->id;
            $modPasienBatalPulang->update_loginpemakai_id = Yii::app()->user->id;
            $modPasienBatalPulang->create_ruangan = Yii::app()->user->getState('ruangan_id');
            $modPasienBatalPulang->pasienpulang_id = $pasienPulangId;
            if ($modPasienBatalPulang->validate()) {
                $transaction = Yii::app()->db->beginTransaction();
                try {
                    if ($modPasienBatalPulang->save()) {
                        $pulang = RDPasienPulangT::model()->updateByPk($pasienPulangId, array('pasienbatalpulang_id' => $modPasienBatalPulang->pasienbatalpulang_id));
                        $pendaftaran = PendaftaranT::model()->updateByPk($pendaftaran_id, array('pasienpulang_id' => null, 'statusperiksa' => "SUDAH DI PERIKSA"));
                        
                        if ($pulang && $pendaftaran) {
                            $transaction->commit();
                            Yii::app()->user->setFlash('success', "Data berhasil disimpan");
                            $tersimpan = 'Ya';
                            //                          
                        } else {
                            $transaction->rollback();
                            Yii::app()->user->setFlash('error', "Data gagal disimpan");
                        }
                    } else {
                        $transaction->rollback();
                        Yii::app()->user->setFlash('error', "Data gagal disimpanx");
                    }
                } catch (Exception $exc) {
                    $transaction->rollback();
                    Yii::app()->user->setFlash('error', "Data gagal disimpan", MyExceptionMessage::getMessage($exc, false));
                }
            } else {
                Yii::app()->user->setFlash('error', "Data gagal disimpan");
            }
        }
        $this->render('formBatalRawatInap', array('modPasien' => $modPasien, 'modPendaftaran' => $modPendaftaran, 'modPasienBatalPulang' => $modPasienBatalPulang, 'tersimpan' => $tersimpan));
    }

    /**
     * actionPasienPulang = transaksi - pasien pulang
     */
    public function actionPasienPulang($pendaftaran_id = null, $dialog = false) {
        $nama_modul = Yii::app()->controller->module->id;
        $nama_controller = Yii::app()->controller->id;
        $nama_action = Yii::app()->controller->action->id;
        $modul_id = ModulK::model()->findByAttributes(array('url_modul' => $nama_modul))->modul_id;
        $smspasien = 1;
        $criteria = new CDbCriteria;
        $criteria->compare('modul_id', $modul_id);
        $criteria->compare('LOWER(modcontroller)', strtolower($nama_controller), true);
        $criteria->compare('LOWER(modaction)', strtolower($nama_action), true);
        if (isset($_POST['tujuansms'])) {
            $criteria->addInCondition('tujuansms', $_POST['tujuansms']);
        }
        $modSmsgateway = SmsgatewayM::model()->findAll($criteria);

        if ($dialog)
            $this->layout = '//layouts/iframe';
        $tersimpan = false;
        if (!empty($pendaftaran_id)) {
            $modPendaftaran = RDPendaftaranT::model()->findByPk($pendaftaran_id);
            if (!$modPendaftaran) {
                Yii::app()->user->setFlash('error', 'Pendaftaran Tidak Ditemukan !');
            } else {
                $modPasien = RDPasienM::model()->findByPk($modPendaftaran->pasien_id);
            }
//                if(!empty($modPendaftaran->pasienpulang_id)){
//                    echo "Pasien Telah Ditindaklanjut Dari Rawat Darurat !";
//                    exit;
//                }
        } else {
            $modPendaftaran = new RDPendaftaranT;
            $modPasien = new RDPasienM;
        }
        $modelPulang = new RDPasienPulangT;
        $modRujukanKeluar = new PasiendirujukkeluarT;

        $modelPulang->tglpasienpulang = date('d M Y H:i:s');
        $modelPulang->pendaftaran_id = $modPendaftaran->pendaftaran_id;
        $modelPulang->pasien_id = $modPasien->pasien_id;

        $modRujukanKeluar->pegawai_id = PendaftaranT::model()->findByPk($pendaftaran_id)->pegawai_id;
        $modRujukanKeluar->ruanganasal_id = Yii::app()->user->getState('ruangan_id'); //ruangan asal itu diasumsikan ruangan terakhir dia dari mana
        $modRujukanKeluar->tgldirujuk = date('d M Y H:i:s');
        $modRujukanKeluar->tglberlakusurat = date('d M Y H:i:s');
        $format = new MyFormatter();
        $date1 = $format->formatDateTimeForDb($modPendaftaran->tgl_pendaftaran);
        $date2 = date('Y-m-d H:i:s');
        $diff = abs(strtotime($date2) - strtotime($date1));
        $hours = floor(($diff) / 3600);
        $selisihHariRawat = CustomFunction::hitungHariRawat($date1);

        $modelPulang->lamarawat = $hours;
        $modelPulang->hariperawatan = $selisihHariRawat;

        if (isset($_POST['RDPasienPulangT'])) {
            if (!empty($_POST['RDPendaftaranT']['pendaftaran_id']))
                $modPendaftaran = $modPendaftaran->findByPk($_POST['RDPendaftaranT']['pendaftaran_id']);
            if (!empty($_POST['RDPasienM']['pasien_id']))
                $modPasien = $modPasien->findByPk($_POST['RDPasienM']['pasien_id']);
            $transaction = Yii::app()->db->beginTransaction();
            try {
                $modelPulang = $this->savePasienPulang($modelPulang, $_POST['RDPasienPulangT']);

                if (isset($_POST['pakeRujukan'])) {
                    $modelPulang->pakeRujukan = true;
                    $modRujukanKeluar = $this->saveRujukanKeluar($modRujukanKeluar, $modelPulang, $_POST['PasiendirujukkeluarT']);
                } else {
                    $this->validRujukan = true;
                }

                if (isset($_POST['isDead'])) {
                    // $modPasien = PasienM::model()->findByPk(Yii::app()->session['pasien_id']);
                    $modPasien = PasienM::model()->findByPk($_POST['RDPasienPulangT']['pasien_id']);
                    $modPasien->tgl_meninggal = $format->formatDateTimeForDb($_POST['RDPasienPulangT']['tgl_meninggal']);
                    $modPasien->save();
                }
                //var_dump($this->validPulang && $this->validRujukan);
                //var_dump($modPasien->attributes); die;
                if ($this->validPulang && $this->validRujukan) {
                    
                    PendaftaranT::model()->updateByPk($modelPulang->pendaftaran_id, array('tglselesaiperiksa' => date('Y-m-d H:i:s'), 'pasienpulang_id' => $modelPulang->pasienpulang_id));
                    
                    if ($modelPulang->carakeluar_id != Params::CARAKELUAR_ID_RAWATINAP) {
                        PendaftaranT::model()->updateByPk($modelPulang->pendaftaran_id, array('tglselesaiperiksa' => date('Y-m-d H:i:s'), 'statusperiksa' => 'SUDAH PULANG'));
                    } else {
                        PendaftaranT::model()->updateByPk($modelPulang->pendaftaran_id, array('tglselesaiperiksa' => date('Y-m-d H:i:s'), 'statusperiksa' => Params::STATUSPERIKSA_NUNGGU_DAFTAR_SO));
                        $this->notifPasienRujukKeRawatInap($modPendaftaran);
                    }
                    
                    // SMS GATEWAY

                    $sms = new Sms();
                    $modCaraKeluar = $modelPulang->carakeluar;
                    $modKondisiKeluar = $modelPulang->kondisikeluar;
                    foreach ($modSmsgateway as $i => $smsgateway) {
                        if(isset($_POST['tujuansms']) && in_array($smsgateway->tujuansms, $_POST['tujuansms'])) {
                            $isiPesan = $smsgateway->templatesms;

                            $attributes = $modPasien->getAttributes();
                            foreach ($attributes as $attributes => $value) {
                                $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
                            }
                            $attributes = $modelPulang->getAttributes();
                            foreach ($attributes as $attributes => $value) {
                                $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
                            }
                            $attributes = $modKondisiKeluar->getAttributes();
                            foreach ($attributes as $attributes => $value) {
                                $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
                            }
                            $attributes = $modCaraKeluar->getAttributes();
                            foreach ($attributes as $attributes => $value) {
                                $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
                            }
                            $isiPesan = str_replace("{{hari}}", MyFormatter::getDayName($modelPulang->tglpasienpulang), $isiPesan);

                            if ($smsgateway->tujuansms == Params::TUJUANSMS_PASIEN && $smsgateway->statussms) {
                                if (!empty($modPasien->no_mobile_pasien)) {
                                    $sms->kirim($modPasien->no_mobile_pasien, $isiPesan);
                                } else {
                                    $smspasien = 0;
                                }
                            }
                        }
                    }
                    // END SMS GATEWAY
                   // die; 
                    $transaction->commit();
                    Yii::app()->user->setFlash('success', 'Data berhasil disimpan !');
                    if ($dialog) {
                        $tersimpan = true;
                    } else
                        $this->redirect(Yii::app()->createUrl($this->route)); //refresh dgn menghilangkan $_get
                }
            } catch (Exception $exc) {
                $transaction->rollback();
                Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
            }
        }

        $this->render('formPasienPulang', array(
            'modPendaftaran' => $modPendaftaran,
            'modPasien' => $modPasien,
            'modelPulang' => $modelPulang,
            'modRujukanKeluar' => $modRujukanKeluar,
            'smspasien' => $smspasien,
            'tersimpan' => $tersimpan,
        ));
    }

    protected function notifPasienRujukKeRawatInap($modPendaftaran) {
        $modRuangan = RuanganM::model()->findByPk($modPendaftaran->ruangan_id);
        $modInstalasi = InstalasiM::model()->findByPk($modRuangan->instalasi_id);
        $pasien_id = $modPendaftaran->pasien_id;
        $modPasien = PasienM::model()->findByPk($pasien_id);
        
        $judul = 'Pasien Rujuk ke Rawat Inap';

        $isi = $modPasien->no_rekam_medik.' - '.$modPasien->nama_pasien
                .' - '.$modInstalasi->instalasi_nama.' - '.$modRuangan->ruangan_nama;
        
        $ok = CustomFunction::broadcastNotif($judul, $isi, array(
            array('instalasi_id'=>Params::INSTALASI_ID_RM, 'ruangan_id'=>Params::RUANGAN_ID_LOKET, 'modul_id'=>Params::MODUL_ID_PENDAFTARAN),
        )); 
    }
    
    protected function savePasienPulang($modPasienPulang, $attrPasienPulang, $pasienadmisi_id = '') {
        $modelPulangNew = new RDPasienPulangT;
        $modelPulangNew->attributes = $attrPasienPulang;
        $modelPulangNew->satuanlamarawat = (Yii::app()->user->getState('instalasi_id') == Params::INSTALASI_ID_RD) ? Params::SATUAN_LAMARAWAT_RD : Params::SATUAN_LAMARAWAT_RI;
        $modelPulangNew->ruanganakhir_id = Yii::app()->user->getState('ruangan_id');
        $modelPulangNew->create_time = date('Y-m-d H:i:s');
        $modelPulangNew->create_ruangan = Yii::app()->user->getState('ruangan_id');
        $modelPulangNew->create_loginpemakai_id = Yii::app()->user->id;
        $modelPulangNew->pasienadmisi_id = (Yii::app()->user->getState('instalasi_id') == Params::INSTALASI_ID_RD) ? null : $pasienadmisi_id;
        
        if ($modelPulangNew->save()) {
            $this->validPulang = true;
        }

        return $modelPulangNew;
    }

    protected function saveRujukanKeluar($modRujukanKeluar, $modelPulang, $attrRujukanKeluar) {
        $modRujukanKeluarNew = new PasiendirujukkeluarT;
        $modRujukanKeluarNew->attributes = $attrRujukanKeluar;
        $modRujukanKeluarNew->pendaftaran_id = $modelPulang->pendaftaran_id;
        $modRujukanKeluarNew->pasien_id = $modelPulang->pasien_id;
        $modRujukanKeluarNew->create_time = date('Y-m-d H:i:s');
        $modRujukanKeluarNew->create_loginpemakai_id = Yii::app()->user->id;
        $modRujukanKeluarNew->tglberlakusurat = date('Y-m-d H:i:s');
        $modRujukanKeluarNew->sampaidengan = date('Y-m-d H:i:s', strtotime("+30 days"));
        if ($modRujukanKeluarNew->save()) {
            $this->validRujukan = true;
        } else {
            $this->validRujukan = false;
        }
        return $modRujukanKeluarNew;
    }

    /**
     * Mengatur dropdown kabupaten
     * @param type $encode jika = true maka return array jika false maka set Dropdown 
     * @param type $model_nama
     * @param type $attr
     */
    public function actionSetDropDownKondisiKeluar($encode = false, $model_nama = '', $attr = '') {
        if (Yii::app()->request->isAjaxRequest) {
            $model = new RDPasienPulangT;
            if ($model_nama !== '' && $attr == '') {
                $carakeluar_id = $_POST["$model_nama"]['carakeluar_id'];
            } elseif ($model_nama == '' && $attr !== '') {
                $carakeluar_id = $_POST["$attr"];
            } elseif ($model_nama !== '' && $attr !== '') {
                $carakeluar_id = $_POST["$model_nama"]["$attr"];
            }
            $kondisikeluar = null;
            if ($carakeluar_id) {
                $kondisikeluar = $model->getKondisikeluarItems($carakeluar_id);
                $kondisikeluar = CHtml::listData($kondisikeluar, 'kondisikeluar_id', 'kondisikeluar_nama');
            }
            if ($encode) {
                echo CJSON::encode($kondisikeluar);
            } else {
                if (empty($kondisikeluar)) {
                    echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
                } else {
                    if (count($kondisikeluar) != 1) echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
                    foreach ($kondisikeluar as $value => $name) {
                        echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
                    }
                }
            }
        }
        Yii::app()->end();
    }

    /**
     * batal periksa pasien RND-5542
     */
    public function actionBatalPeriksa() {
        if (Yii::app()->request->isAjaxRequest) {
            $transaction = Yii::app()->db->beginTransaction();
            try {
                $pendaftaran_id = isset($_POST['pendaftaran_id']) ? $_POST['pendaftaran_id'] : null;
                $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);

                $tindakan = TindakanpelayananT::model()->findByAttributes(array(
                    'pendaftaran_id'=>$pendaftaran_id,
                ), array(
                    'condition'=>'tindakansudahbayar_id is not null'
                ));
                $oa = ObatalkespasienT::model()->findByAttributes(array(
                    'pendaftaran_id'=>$pendaftaran_id,
                ), array(
                    'condition'=>'oasudahbayar_id is not null'
                ));
                
                $ada = false;
                
                if (!empty($tindakan) || !empty($oa)) {
                    $ada = true;
                    $pesan = "Pasien sudah melakukan pembayaran. "
                            . "Mohon pembayaran sebelumnya dibatalkan terlebih dahulu sebelum melakukan pembatalan pemeriksaan.";
                    $status = false;
                    goto onco; // loncat ke label 'onco'
                }
                
                /*
                 * cek data pendaftaran pasien masuk penunjang
                 */
                $criteria = new CDbCriteria();
                if (!empty($pendaftaran_id)) {
                    $criteria->addCondition("pendaftaran_id = " . $pendaftaran_id);
                }

                $pasienMasukPenunjang = PasienmasukpenunjangT::model()->find($criteria);

                $pesan = '';
                $status = false;
                $model = new PasienbatalperiksaR();
                $model->pendaftaran_id = $pendaftaran_id;
                $model->pasien_id = $modPendaftaran->pasien_id;
                $model->tglbatal = date('Y-m-d');
                $model->keterangan_batal = "Batal Rawat Jalan";
                $model->create_ruangan = Yii::app()->user->getState('ruangan_id');

                if ($model->save()) {
                    $status = true;
                    $pesan = "Pemeriksaan pasien berhasil dibatalkan!";
                } else {
                    $status = false;
                    $pesan = "Pemeriksaan gagal dibatalkan! " . CHtml::errorSummary($model);
                }

                $attributes = array(
                    'pasienbatalperiksa_id' => $model->pasienbatalperiksa_id,
                    'update_time' => date('Y-m-d H:i:s'),
                    'update_loginpemakai_id' => Yii::app()->user->id
                );
                $pendaftaran = PendaftaranT::model()->updateByPk($pendaftaran_id, $attributes);

                
                /*
                if (count($pasienMasukPenunjang) > 0) {
                    if ($pasienMasukPenunjang->pasienkirimkeunitlain_id == null) {
                        $attributes = array(
                            'pasienkirimkeunitlain_id' => $pasienMasukPenunjang->pasienkirimkeunitlain_id
                        );
                        $Perminataan_penunjang = PermintaankepenunjangT::model()->deleteAllByAttributes($attributes);
                    }

                    $attributes = array(
                        'statusperiksa' => 'BATAL PERIKSA',
                        'update_time' => date('Y-m-d H:i:s'),
                        'update_loginpemakai_id' => Yii::app()->user->id
                    );
                    $penunjang = PasienmasukpenunjangT::model()->updateByPk($pasienMasukPenunjang->pasienmasukpenunjang_id, $attributes);
                    if (!$penunjang) {
                        $status = false;
                    }
                    /*
                     * cek data tindakan_pelayanan
                     */ /*
                    $attributes = array(
                        'pasienmasukpenunjang_id' => $pasienMasukPenunjang->pasienmasukpenunjang_id,
                        'tindakansudahbayar_id' => null
                    );

                    $criteria2 = new CDbCriteria();
                    $criteria2->addCondition('pasienmasukpenunjang_id = ' . $pasienMasukPenunjang->pasienmasukpenunjang_id);
                    $criteria2->addCondition('tindakansudahbayar_id is null');
                    $tindakan = TindakanpelayananT::model()->findAll($criteria2);

                    if (count($tindakan) > 0) {

                        foreach ($tindakan as $val => $key) {
                            $attributes = array(
                                'tindakanpelayanan_id' => $key->tindakanpelayanan_id
                            );
                            $hapus_komponen = TindakankomponenT::model()->deleteAllByAttributes($attributes);
                        }

                        $attributes = array(
                            'pasienmasukpenunjang_id' => $pasienMasukPenunjang->pasienmasukpenunjang_id
                        );

                        $hapus_tindakan = TindakanPelayananT::model()->deleteAllByAttributes($attributes);
                        if (!$hapus_tindakan) {
                            $status = false;
                            $pesan = "exist";
                        }
                    } else {
                        $pesan = "exist";
                    }
                }
                      * 
                      */
                
                onco:
                
                /*
                 * kondisi_commit
                 */
                if ($status == true && $ada == false) {
                    $transaction->commit();
                } else {
                    $transaction->rollback();
                }
            } catch (Exception $ex) {
                var_dump($ex); die;
//					print_r($ex);
                $status = false;
                $pesan = "exist";
                $transaction->rollback();
            }

            $data = array(
                'pesan' => $pesan,
                'status' => $status
            );
            echo json_encode($data);
            Yii::app()->end();
        }
    }

    /**
     * Mengatur dropdown kasus penyakit
     */
    public function actionSetDropdownKasusPenyakit() {
        if (Yii::app()->getRequest()->getIsAjaxRequest()) {
            $pendaftaran_id = isset($_POST['pendaftaran_id']) ? $_POST['pendaftaran_id'] : null;
            $jeniskasuspenyakit_id = isset($_POST['jeniskasuspenyakit_id']) ? $_POST['jeniskasuspenyakit_id'] : null;

            $jeniskasuspenyakit = JeniskasuspenyakitM::model()->findAll('jeniskasuspenyakit_aktif = TRUE ORDER BY jeniskasuspenyakit_nama ASC');
            $jeniskasuspenyakit = CHtml::listData($jeniskasuspenyakit, 'jeniskasuspenyakit_id', 'jeniskasuspenyakit_nama');

            $jeniskasuspenyakitOptions = CHtml::dropDownList('jeniskasuspenyakit_id', '', $jeniskasuspenyakit, array("onchange" => "saveKasusPenyakit(this,$pendaftaran_id)", "style" => "width:140px;", "options" => array($jeniskasuspenyakit_id => array("selected" => true))));

            $dataList['kasusPenyakit'] = $jeniskasuspenyakitOptions;

            echo json_encode($dataList);
            Yii::app()->end();
        }
    }

    /**
     * Mengatur dropdown kasus penyakit
     */
    public function actionSaveKasusPenyakit() {
        if (Yii::app()->getRequest()->getIsAjaxRequest()) {
            $pendaftaran_id = isset($_POST['pendaftaran_id']) ? $_POST['pendaftaran_id'] : null;
            $jeniskasuspenyakit_id = isset($_POST['jeniskasuspenyakit_id']) ? $_POST['jeniskasuspenyakit_id'] : null;
            $pesan = 'gagal';

            $update = RDPendaftaranT::model()->updateByPk($pendaftaran_id, array('jeniskasuspenyakit_id' => $jeniskasuspenyakit_id));
            if ($update) {
                $pesan = 'berhasil';
            } else {
                $pesan = 'gagal';
            }
            $data['pesan'] = $pesan;

            echo json_encode($data);
            Yii::app()->end();
        }
    }

    /**
     * untuk Ubah Dokter
     */
    public function actionUbahDokterPeriksa() {
        $model = new RDPendaftaranT();
        $modUbahDokter = new RDUbahdokterR;
        $menu = (isset($_REQUEST['menu']) ? $_REQUEST['menu'] : "");
        if (isset($_POST['RDPendaftaranT'])) {
            if ($_POST['RDPendaftaranT']['pegawai_id'] != "") {
                $modUbahDokter->attributes = $_POST['RDUbahdokterR'];
                $modUbahDokter->pendaftaran_id = $_POST['RDPendaftaranT']['pendaftaran_id'];
                $modUbahDokter->dokterbaru_id = $_POST['RDPendaftaranT']['pegawai_id'];
                $modUbahDokter->tglubahdokter = date('Y-m-d H:i:s');
                $modUbahDokter->create_time = date('Y-m-d H:i:s');
                $modUbahDokter->create_loginpemakai_id = Yii::app()->user->id;
                $modUbahDokter->create_ruangan = Yii::app()->user->getState('ruangan_id');
                $transaction = Yii::app()->db->beginTransaction();
                try {
                    $attributes = array('pegawai_id' => $_POST['RDPendaftaranT']['pegawai_id']);

                    $save = RDPendaftaranT::model()->updateByPk($_POST['RDPendaftaranT']['pendaftaran_id'], $attributes);

                    if ($save) {
                        $modUbahDokter->save();
                        $transaction->commit();
                        echo CJSON::encode(array(
                            'status' => 'proses_form',
                            'div' => "<div class='flash-success'>Berhasil merubah Dokter Periksa.</div>",
                        ));
                    } else {
                        echo CJSON::encode(array(
                            'status' => 'proses_form',
                            'div' => "<div class='flash-error'>Data gagal disimpan.</div>",
                        ));
                    }
                    exit;
                } catch (Exception $exc) {
                    $transaction->rollback();
                }
            } else {
                echo CJSON::encode(
                        array(
                            'status' => 'proses_form',
                            'div' => "<div class='flash-success'>Berhasil merubah Dokter Periksa.</div>",
                        )
                );
                exit;
            }
        }

        if (Yii::app()->request->isAjaxRequest) {
            echo CJSON::encode(array(
                'status' => 'create_form',
                'div' => $this->renderPartial('_formUbahDokterPeriksa', array('model' => $model, 'modUbahDokter' => $modUbahDokter, 'menu' => $menu), true)));
            exit;
        }
    }

    public function actionGetDataPendaftaranRD() {
        if (Yii::app()->request->isAjaxRequest) {
            $id_pendaftaran = $_POST['pendaftaran_id'];
            $model = RDInfoKunjunganRDV::model()->findByAttributes(array('pendaftaran_id' => $id_pendaftaran));
            $attributes = $model->attributeNames();
            foreach ($attributes as $j => $attribute) {
                $returnVal["$attribute"] = $model->$attribute;
                $returnVal["gelarbelakang_nama"] = isset($model->gelarbelakang_nama) ? $model->gelarbelakang_nama : "";
                $returnVal["gelardepan"] = isset($model->gelardepan) ? $model->gelardepan : "";
            }
            echo json_encode($returnVal);
            Yii::app()->end();
        }
    }

    public function actionListDokterRuangan() {
        if (Yii::app()->getRequest()->getIsAjaxRequest()) {
            if (!empty($_POST['idRuangan'])) {
                $idRuangan = $_POST['idRuangan'];
                $data = DokterV::model()->findAllByAttributes(array('ruangan_id' => $idRuangan), array('order' => 'nama_pegawai'));
                $data = CHtml::listData($data, 'pegawai_id', 'nama_pegawai');

                if (empty($data)) {
                    $option = CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
                } else {
                    $option = CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
                    foreach ($data as $value => $name) {
                        $option .= CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
                    }
                }

                $dataList['listDokter'] = $option;
            } else {
                $dataList['listDokter'] = $option = CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
            }

            echo json_encode($dataList);
            Yii::app()->end();
        }
    }
    
    public function actionTerimaDokumen() {
    if (Yii::app()->request->isAjaxRequest) {
        $pendaftaran = $_POST['pendaftaran_id'];
        $pengirimanrm_id = $_POST['pengirimanrm_id'];
      
        $model = PendaftaranT::model()->findByPk($pendaftaran);
        if(!empty($pengirimanrm_id)) {            
            $modPenerimaanRm = PengirimanrmT::model()->findByPk($pengirimanrm_id);      
            $modPenerimaanRm->tglterimadokrm = date('Y-m-d H:i:s');
            $modPenerimaanRm->petugaspenerima_id = Yii::app()->user->id;
            $modPenerimaanRm->ruanganpenerima_id = Yii::app()->user->getState('ruangan_id');
            
            if($modPenerimaanRm->save()){
                    $model->statusdokrm = 'SUDAH DITERIMA';
                    $model->save();
                    $update = true;
            }else{
                    $update = false;
            }
        }
        
        if($update == true)
        {
                $status = 'proses_form';
                $div = "<div class='flash-success'>Data Dokumen Pasien <b></b> berhasil diterima </div>";
        }else{
                $status = 'proses_form';
                $div = "<div class='flash-error'>Data Dokumen Pasien <b></b> gagal diterima </div>";
        }

        echo CJSON::encode(array(
                'status'=>$status, 
                'div'=>$div,
                ));
        exit;   
    }
}

public function actionKirimDokumen($pengirimanrm_id,$pendaftaran_id){
        $this->layout='//layouts/iframe';
        $format = new MyFormatter();
        $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
        $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
        $status = false;
        if(!empty($pengirimanrm_id)){
                $modPengirimanRm = PengirimanrmT::model()->findByPk($pengirimanrm_id);
        }else{
                $modPengirimanRm = new PengirimanrmT();
        }			

        $modUbahStatus = new PengirimanrmT;
        $modUbahStatus->tglpengirimanrm = date('d/m/Y H:i:s');

        if(isset($_POST['PengirimanrmT']))
        {
                $transaction = Yii::app()->db->beginTransaction();
                try 
                {
                        $modUbahStatus->attributes = $_POST['PengirimanrmT'];
                        $modUbahStatus->pendaftaran_id = $modPendaftaran->pendaftaran_id;
                        $modUbahStatus->pasien_id = $modPendaftaran->pasien_id;
                        $modUbahStatus->dokrekammedis_id = isset($modPengirimanRm) ? $modPengirimanRm->dokrekammedis_id : null;
                        $modUbahStatus->nourut_keluar = MyGenerator::noUrutKeluarRM();
                        $modUbahStatus->tglpengirimanrm = $format->formatDateTimeForDb($_POST['PengirimanrmT']['tglpengirimanrm']);
                        $modUbahStatus->kelengkapandokumen = TRUE;
                        $modUbahStatus->petugaspengirim_id = $_POST['PengirimanrmT']['petugaspengirim_id'];
                        $modUbahStatus->create_time = date('Y-m-d H:i:s');
                        $modUbahStatus->create_loginpemakai_id = Yii::app()->user->id;
                        $modUbahStatus->create_ruangan = Yii::app()->user->getState('ruangan_id');
                        $modUbahStatus->ruanganpengirim_id = Yii::app()->user->getState('ruangan_id');

                        if($modUbahStatus->save())
                        {
                                $modPendaftaran->statusdokrm = 'SUDAH DIKIRIM';
                                $modPendaftaran->save();

                                $transaction->commit();
                                $status = true;
                                Yii::app()->user->setFlash('success', "Data pengiriman dokumen pasien berhasil disimpan !");
                        }else{
                                $status = false;
                                Yii::app()->user->setFlash('error', '<strong>Gagal</strong> Data pengiriman dokumen pasien gagal disimpan');
                        }
                }catch(Exception $exc) {
                        $transaction->rollback();
                        $status = false;
                        Yii::app()->user->setFlash('error', '<strong>Gagal</strong> Data Gagal disimpan'.MyExceptionMessage::getMessage($exc));
                }                  
        }

        $this->render('_formStatusDokumen', array(
                'modPendaftaran'=>$modPendaftaran,
                'modPasien'=>$modPasien,
                'modPengirimanRm'=>$modPengirimanRm,
                'modUbahStatus'=>$modUbahStatus,
                'status'=>$status
        ));            
    }
    
    public function actionStatusDokumenKirim($pengirimanrm_id,$pendaftaran_id){
		$this->layout='//layouts/iframe';
		$format = new MyFormatter();
		$modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
		$modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
		$status = false;
		if(!empty($pengirimanrm_id)){
			$modPengirimanRm = PengirimanrmT::model()->findByPk($pengirimanrm_id);
		}else{
			$modPengirimanRm = new PengirimanrmT();
		}			

                $pegawai_id = LoginpemakaiK::model()->findByPk(Yii::app()->user->id)->pegawai_id;                
		$modUbahStatus = new PengirimanrmT;
                $modUbahStatus->tglpengirimanrm = date('d/m/Y H:i:s');                
                $modUbahStatus->petugaspengirim = Yii::app()->user->name;
                $modUbahStatus->petugaspengirim_id = $pegawai_id;
                
		if(isset($_POST['PengirimanrmT']))
		{
			$transaction = Yii::app()->db->beginTransaction();
			try 
			{
				$modUbahStatus->attributes = $_POST['PengirimanrmT'];
                                //var_dump($_POST);die;
				$modUbahStatus->pendaftaran_id = $modPendaftaran->pendaftaran_id;
				$modUbahStatus->pasien_id = $modPendaftaran->pasien_id;
				$modUbahStatus->dokrekammedis_id = isset($modPengirimanRm) ? $modPengirimanRm->dokrekammedis_id : null;
				$modUbahStatus->nourut_keluar = MyGenerator::noUrutKeluarRM();
				$modUbahStatus->tglpengirimanrm = $format->formatDateTimeForDb($_POST['PengirimanrmT']['tglpengirimanrm']);
				$modUbahStatus->kelengkapandokumen = TRUE;
				$modUbahStatus->petugaspengirim_id = $_POST['PengirimanrmT']['petugaspengirim_id'];                                
				$modUbahStatus->create_time = date('Y-m-d H:i:s');
				$modUbahStatus->create_loginpemakai_id = Yii::app()->user->id;
				$modUbahStatus->create_ruangan = Yii::app()->user->getState('ruangan_id');
				$modUbahStatus->ruanganpengirim_id = Yii::app()->user->getState('ruangan_id');
                                $modUbahStatus->ruanganpenerima_id = $_POST['PengirimanrmT']['ruangan_id'];
				
				if($modUbahStatus->save())
				{
					$modPendaftaran->statusdokrm = 'SUDAH DIKIRIM';
					$modPendaftaran->save();

					$transaction->commit();
					$status = true;
					Yii::app()->user->setFlash('success', "Data pengiriman dokumen pasien berhasil disimpan !");
				}else{
					$status = false;
					Yii::app()->user->setFlash('error', '<strong>Gagal</strong> Data pengiriman dokumen pasien gagal disimpan');
				}
			}catch(Exception $exc) {
				$transaction->rollback();
				$status = false;
				Yii::app()->user->setFlash('error', '<strong>Gagal</strong> Data Gagal disimpan'.MyExceptionMessage::getMessage($exc));
			}                  
		}
		
		$this->render('_formStatusDokumen', array(
			'modPendaftaran'=>$modPendaftaran,
			'modPasien'=>$modPasien,
			'modPengirimanRm'=>$modPengirimanRm,
			'modUbahStatus'=>$modUbahStatus,
			'status'=>$status
		));            
	}
        
    public function actionSetDropdownRuangan($encode=false,$model_nama='',$attr='')
    {
        if(Yii::app()->request->isAjaxRequest) {
            $instalasi_id = null;
            if($model_nama !=='' && $attr == ''){
                $instalasi_id = $_POST["$model_nama"]['instalasi_id'];
            }
             else if ($model_nama == '' && $attr !== '') {
                $instalasi_id = $_POST["$attr"];
            }
             else if ($model_nama !== '' && $attr !== '') {
                $instalasi_id = $_POST["$model_nama"]["$attr"];
            }
            $models = null;
            $models = CHtml::listData(RuanganM::getRuanganByInstalasi($instalasi_id),'ruangan_id','ruangan_nama');

            if($encode){
                echo CJSON::encode($models);
            } else {
                if (count($models) > 1){
                    echo CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
                }elseif (count($models) == 0){
                    echo CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
                }
                
                if(count($models) > 0){
                    foreach($models as $value=>$name){
                        echo CHtml::tag('option', array('value'=>$value),CHtml::encode($name),true);
                    }
                }
            }
        }
        Yii::app()->end();
    }

}

?>
