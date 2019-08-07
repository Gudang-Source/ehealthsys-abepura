<?php
Yii::import('laboratorium.controllers.PemakaianBahanController');
Yii::import('laboratorium.models.LBObatalkespasienT');
Yii::import('laboratorium.models.LBObatalkesM');
Yii::import('laboratorium.models.LBHasilPemeriksaanLabT');
Yii::import('laboratorium.models.LBPasienmasukpenunjangT');
Yii::import('laboratorium.models.LBPasienMasukPenunjangV');
class PemakaianBahanRIController extends PemakaianBahanController
{
    public $path_view = "rawatInap.views.pemakaianBahanRI.";
    public $path_view_bmhp = "laboratorium.views.pemakaianBmhp.";
    public $path_view_bahan = "laboratorium.views.pemakaianBmhp.";
    
    // dicopy dari laboratorium.controller.pemakaianBmhp
    public function actionIndex($pasienadmisi_id=null)
    {
        $format = new MyFormatter();
        $modKunjungan= new RIInfopasienmasukkamarV;
        $modKunjungan->ruangan_id = Yii::app()->user->getState("ruangan_id");
        $modObatAlkesPasien = new LBObatalkespasienT;
        $dataOas = array();

        if(!empty($pasienadmisi_id)){
            $modKunjungan= RIInfopasienmasukkamarV::model()->findByAttributes(array('pasienadmisi_id'=>$pasienadmisi_id));
            $modKunjungan->tgl_pendaftaran = MyFormatter::formatDateTimeForUser($modKunjungan->tgl_pendaftaran);
            $modKunjungan->tgladmisi = MyFormatter::formatDateTimeForUser($modKunjungan->tgladmisi);
            $modKunjungan->tanggal_lahir = MyFormatter::formatDateTimeForUser($modKunjungan->tanggal_lahir);
        }
        
        if(isset($_POST['LBObatalkespasienT'])){
            if(isset($_POST['pasienadmisi_id'])){
                $modPasienAdmisi = RIPasienAdmisiT::model()->findByPk($_POST['pasienadmisi_id']);
                $transaction = Yii::app()->db->beginTransaction();
                try {
                    if(count($_POST['LBObatalkespasienT']) > 0){
                        //PROSES GROUP DETAIL BERDASARKAN obatalkes_id & akumulasikan jmlmutasi
                        $detailGroups = array();
                        foreach($_POST['LBObatalkespasienT'] AS $i => $postDetail){
                            $modDetails[$i] = new LBObatalkespasienT;
                            $modDetails[$i]->attributes = $postDetail;
                            $modDetails[$i] = $this->simpanObatAlkesPasien2($modPasienAdmisi, $modDetails[$i]);
                            $this->simpanStokObatAlkesOut2($modDetails[$i]);
                            /*
                            $modStok = StokobatalkesT::model()->findByPk($postDetail['stokobatalkes_id']);
                            $modDetails[$i]->stokobatalkes_id = $modStok->stokobatalkes_id;
                            $obatalkes_id = $postDetail['obatalkes_id'];
                            if(isset($detailGroups[$obatalkes_id])){
                                $detailGroups[$obatalkes_id]['qty_oa'] += $postDetail['qty_oa'];
                            }else{
                                $detailGroups[$obatalkes_id]['obatalkes_id'] = $postDetail['obatalkes_id'];
                                $detailGroups[$obatalkes_id]['qty_oa'] = $postDetail['qty_oa'];
                            }
                             * 
                             */
                        }
                        //END GROUP
                    }
                    /*
                    $obathabis = "";
                    //PROSES PENGURAIAN OBAT DAN JUMLAH MENJADI STOKOBATALKES_T (METODE ANTRIAN)
                    foreach($detailGroups AS $i => $detail){
                        $modStokOAs = StokobatalkesT::getStokObatAlkesAktif($detail['obatalkes_id'], $detail['qty_oa'], Yii::app()->user->getState('ruangan_id'));
                        if(count($modStokOAs) > 0){
                            foreach($modStokOAs AS $i => $stok){
                                $modDetails[$i] = $this->simpanObatAlkesPasien($modPasienAdmisi,$stok, $_POST['LBObatalkespasienT']);
                                $this->simpanStokObatAlkesOut($stok['stokobatalkes_id'], $modDetails[$i]);
                            }
                        }else{
                            $this->stokobatalkestersimpan &= false;
                            $obathabis .= "<br>- ".ObatalkesM::model()->findByPk($detail['obatalkes_id'])->obatalkes_nama;

                        }
                    }
                     * 
                     */

//                    if(count($_POST['LBObatalkespasienT']) > 0){
//                        foreach($_POST['LBObatalkespasienT'] AS $i => $postOa){
//                            $dataOas[$i] = $this->simpanObatAlkesPasien($modPasienAdmisi,$postOa);
//                        }
//                    }
                    // var_dump($this->obatalkespasientersimpan&&$this->stokobatalkestersimpan); die;
                    if($this->obatalkespasientersimpan&&$this->stokobatalkestersimpan){
                        $transaction->commit();
                        $this->redirect(array('index','pasienadmisi_id'=>$modPasienAdmisi->pasienadmisi_id,'sukses'=>1));
                    }else{
                        $transaction->rollback();
                        Yii::app()->user->setFlash('error',"Data pemakaian BMHP gagal disimpan !");
                    }
                } catch (Exception $e) {
                    $transaction->rollback();
                    Yii::app()->user->setFlash('error',"Data pemakaian BMHP gagal disimpan ! ".MyExceptionMessage::getMessage($e,true));
                }
            }
            

        }
            
        $this->render($this->path_view.'index',array(
            'modKunjungan'=>$modKunjungan,
            'modObatAlkesPasien'=>$modObatAlkesPasien,
            'dataOas'=>$dataOas,
        ));
    }
    
    /**
     * simpan RIObatalkespasienT
     * @param type $modPasienAdmisi
     * @param type $post
     * @return \RIObatalkespasienT
     */
    public function simpanObatAlkesPasien2($modPasienAdmisi, $postObatAlkesPasien){   
        $oa = ObatalkesM::model()->findByPk($postObatAlkesPasien->obatalkes_id);
        $modObatAlkesPasien = new RIObatalkespasienT();
        $modObatAlkesPasien->attributes = $postObatAlkesPasien->attributes;
        $modObatAlkesPasien->tglpelayanan = date("Y-m-d H:i:s");
        $modObatAlkesPasien->tipepaket_id = Params::TIPEPAKET_ID_NONPAKET;
        $modObatAlkesPasien->ruangan_id = Yii::app()->user->getState('ruangan_id');
        $modObatAlkesPasien->pendaftaran_id = $modPasienAdmisi->pendaftaran_id;
        $modObatAlkesPasien->pasienmasukpenunjang_id = null;
        $modObatAlkesPasien->pasienadmisi_id = $modPasienAdmisi->pasienadmisi_id;
        $modObatAlkesPasien->carabayar_id = $modPasienAdmisi->pendaftaran->carabayar_id;
        $modObatAlkesPasien->penjamin_id = $modPasienAdmisi->pendaftaran->penjamin_id;
        $modObatAlkesPasien->pegawai_id = $modPasienAdmisi->pegawai_id;
        $modObatAlkesPasien->shift_id = Yii::app()->user->getState('shift_id');
        $modObatAlkesPasien->pasien_id = $modPasienAdmisi->pasien_id;
        $modObatAlkesPasien->kelaspelayanan_id = $modPasienAdmisi->kelaspelayanan_id;
        $modObatAlkesPasien->tglpelayanan = date ('Y-m-d H:i:s');
        $modObatAlkesPasien->create_loginpemakai_id = Yii::app()->user->id;
        $modObatAlkesPasien->create_ruangan = Yii::app()->user->getState('ruangan_id');
        $modObatAlkesPasien->create_time = date ('Y-m-d H:i:s');
        //$modObatAlkesPasien->qty_oa = $stokOa->qtystok_terpakai;
        //$modObatAlkesPasien->qty_stok = $stokOa->qtystok;
        $modObatAlkesPasien->harganetto_oa = $oa->harganetto; //$stokOa->HPP;
        $modObatAlkesPasien->hargasatuan_oa = $oa->hargajual; //$stokOa->HargaJualSatuan;
        $modObatAlkesPasien->hargajual_oa = $modObatAlkesPasien->hargasatuan_oa * $modObatAlkesPasien->qty_oa;
        $modObatAlkesPasien->iurbiaya = $modObatAlkesPasien->hargajual_oa;
        /*
        foreach ($postObatAlkesPasien AS $i => $postDetail) {
            if ($stokOa->obatalkes_id==$postDetail['obatalkes_id']) {
                $modObatAlkesPasien->sumberdana_id = $postDetail['sumberdana_id'];                
                $modObatAlkesPasien->satuankecil_id = $postDetail['satuankecil_id'];                
                $modObatAlkesPasien->qty_stok = $postDetail['qty_stok'];
                $modObatAlkesPasien->iurbiaya = $postDetail['iurbiaya'];
            }
        }
         * 
         */

        if($modObatAlkesPasien->save()){
            $this->obatalkespasientersimpan &= true;
        }else{
            $this->obatalkespasientersimpan &= false;
        }
        return $modObatAlkesPasien;
    }
    
    /**
     * simpan RIObatalkespasienT
     * @param type $modPasienAdmisi
     * @param type $post
     * @return \RIObatalkespasienT
     */
    public function simpanObatAlkesPasien($modPasienAdmisi ,$stokOa, $postObatAlkesPasien){        
        $modObatAlkesPasien = new RIObatalkespasienT();
        $modObatAlkesPasien->attributes = $stokOa->attributes;
        $modObatAlkesPasien->tglpelayanan = date("Y-m-d H:i:s");
        $modObatAlkesPasien->tipepaket_id = Params::TIPEPAKET_ID_NONPAKET;
        $modObatAlkesPasien->ruangan_id = Yii::app()->user->getState('ruangan_id');
        $modObatAlkesPasien->pendaftaran_id = $modPasienAdmisi->pendaftaran_id;
        $modObatAlkesPasien->pasienmasukpenunjang_id = null;
        $modObatAlkesPasien->pasienadmisi_id = $modPasienAdmisi->pasienadmisi_id;
        $modObatAlkesPasien->carabayar_id = $modPasienAdmisi->pendaftaran->carabayar_id;
        $modObatAlkesPasien->penjamin_id = $modPasienAdmisi->pendaftaran->penjamin_id;
        $modObatAlkesPasien->pegawai_id = $modPasienAdmisi->pegawai_id;
        $modObatAlkesPasien->shift_id = Yii::app()->user->getState('shift_id');
        $modObatAlkesPasien->pasien_id = $modPasienAdmisi->pasien_id;
        $modObatAlkesPasien->kelaspelayanan_id = $modPasienAdmisi->kelaspelayanan_id;
        $modObatAlkesPasien->tglpelayanan = date ('Y-m-d H:i:s');
        $modObatAlkesPasien->create_loginpemakai_id = Yii::app()->user->id;
        $modObatAlkesPasien->create_ruangan = Yii::app()->user->getState('ruangan_id');
        $modObatAlkesPasien->create_time = date ('Y-m-d H:i:s');
        $modObatAlkesPasien->qty_oa = $stokOa->qtystok_terpakai;
        $modObatAlkesPasien->qty_stok = $stokOa->qtystok;
        $modObatAlkesPasien->harganetto_oa = $stokOa->HPP;
        $modObatAlkesPasien->hargasatuan_oa = $stokOa->HargaJualSatuan;
        $modObatAlkesPasien->hargajual_oa = $modObatAlkesPasien->hargasatuan_oa * $modObatAlkesPasien->qty_oa;
         foreach ($postObatAlkesPasien AS $i => $postDetail) {
            if ($stokOa->obatalkes_id==$postDetail['obatalkes_id']) {
                $modObatAlkesPasien->sumberdana_id = $postDetail['sumberdana_id'];                
                $modObatAlkesPasien->satuankecil_id = $postDetail['satuankecil_id'];                
                $modObatAlkesPasien->qty_stok = $postDetail['qty_stok'];
                $modObatAlkesPasien->iurbiaya = $postDetail['iurbiaya'];
            }
        }

        if($modObatAlkesPasien->save()){
            $this->obatalkespasientersimpan &= true;
        }else{
            $this->obatalkespasientersimpan &= false;
        }
        return $modObatAlkesPasien;
    }
    
    /**
     * Mengurai data kunjungan berdasarkan:
     * - pasienadmisi_id
     * @throws CHttpException
     */
    public function actionGetDataKunjungan()
    {
        if(Yii::app()->request->isAjaxRequest) {
            $format = new MyFormatter();
            $returnVal = array();
            $returnVal['pesan'] = "";
            $criteria = new CDbCriteria();
            $model = $this->loadModPasienRawatInap($_POST['pasienadmisi_id']);
            if(isset($model)){
                $loadHasilPemeriksaan = LBHasilPemeriksaanLabT::model()->findByAttributes(array('pasienadmisi_id'=>$model->pasienadmisi_id));
                if(isset($loadHasilPemeriksaan)){
                    if(strtolower(trim($loadHasilPemeriksaan->statusperiksahasil)) == strtolower(Params::STATUSPERIKSAHASIL_SUDAH)){
                        $returnVal['pesan'] = "Pasien dengan status sudah diperiksa tidak bisa menggunakan obat / alat kesehatan !";
                    }
                }
            }
            
            $attributes = $model->attributeNames();
            foreach($attributes as $j=>$attribute) {
                $returnVal["$attribute"] = $model->$attribute;
            }
            $returnVal["tanggal_lahir"] = $format->formatDateTimeForUser($model->tanggal_lahir);
            $returnVal["tgl_pendaftaran"] = $format->formatDateTimeForUser($model->tgl_pendaftaran);
            $returnVal["tgladmisi"] = $format->formatDateTimeForUser($model->tgladmisi);
            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }
    
    /**
     * @param type $pasienadmisi_id
     * @return RIInfopasienmasukkamarV
     */
    public function loadModPasienRawatInap($pasienadmisi_id){
            $criteria=new CDbCriteria;
            $criteria->addCondition("t.pasienadmisi_id = ".$pasienadmisi_id);
            $model = RIInfopasienmasukkamarV::model()->find($criteria);
            return $model;
    }
    
    /**
     * set LKTindakanpelayananT yang sudah ada di database
     * @params pasienmasukpenunjang_id
     */
    public function actionSetRiwayatObatAlkesPasien(){
        if(Yii::app()->request->isAjaxRequest) {
            $format = new MyFormatter();
            $rows = "";
            $loadOaPasiens = RIObatalkespasienT::model()->findAllByAttributes(array('pasienadmisi_id'=>$_POST['pasienadmisi_id']));
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
    
    public function actionPrint($pasienadmisi_id) 
    {
        $this->layout='//layouts/printWindows';
        $format = new MyFormatter;    
        $modPasienAdmisi = RIInfopasienmasukkamarV::model()->findByAttributes(array('pasienadmisi_id'=>$pasienadmisi_id));     
        $modObatAlkesPasien = RIObatalkespasienT::model()->findAllByAttributes(array('pasienadmisi_id'=>$pasienadmisi_id));

        $judul_print = 'Pemakaian Bahan '.$modPasienAdmisi->ruangan_nama;
        $this->render($this->path_view.'printPemakaianBahan', array(
                            'format'=>$format,
                            'judul_print'=>$judul_print,
                            'modPasienAdmisi'=>$modPasienAdmisi,
                            'modObatAlkesPasien'=>$modObatAlkesPasien,
        ));
    } 
    
    /**
     * mengembalikan stok jika ada pembatalan
     * @param type $obatAlkesT
     * di copy dari laboratorium/pemakaianBmhpController
     */
    protected function kembalikanStok($modObatAlkesPasien)
    {
        /*
        $stok = new StokobatalkesT;
        $stok->attributes = $modObatAlkesPasien->attributes;
        $modObatAlkes = ObatalkesM::model()->findByPk($modObatAlkesPasien->obatalkes_id); //sementara menggunakan harga terupdate
        $stok->harganetto_oa = $modObatAlkes->harganetto; 
        $stok->hargajual_oa = $modObatAlkes->hargajual; 
        $stok->jasadokter = $modObatAlkes->jasadokter; 
        $stok->discount = $modObatAlkes->discount; 
        $stok->marginresep = $modObatAlkes->marginresep; 
        $stok->marginnonresep = $modObatAlkes->marginnonresep; 
        $stok->hjaresep = $modObatAlkes->hjaresep; 
        $stok->hjanonresep = $modObatAlkes->hjanonresep; 
        $stok->hpp = $modObatAlkes->hpp; 
        $stok->tglstok_in = date('Y-m-d H:i:s');
        $stok->tglstok_out = null;
        $stok->qtystok_in = $modObatAlkesPasien->qty_oa;
        $stok->qtystok_out = 0;
        $stok->qtystok_current = $stok->qtystok_in;
        
        if($stok->save())
            return true;
         * 
         */
        StokobatalkesT::model()->deleteAllByAttributes(array(
            'obatalkespasien_id' => $modObatAlkesPasien->obatalkespasien_id,
        ));
        
        return true;
    }
    
}