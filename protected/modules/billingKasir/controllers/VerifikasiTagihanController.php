<?php

class VerifikasiTagihanController extends MyAuthController
{
    public $layout='//layouts/column1';
    
    public function actionIndex($id = null)
    {
        $successSave = false; 
        $format = new MyFormatter;
        $tandaBukti = new TandabuktibayarT;
        $tindakanPelayanan = new TindakanpelayananT;
        $tindakanPelayanan->tgl_tindakan = date('Y-m-d H:i:s');
        $obatalkes = new BKObatalkesPasienT;
        $cekSudahBayar = array();
        $modBayar = new BKPembayaranpelayananT();
        $modPendaftaran = new BKPendaftaranT();
        $modPasien = new BKPasienM();
        $modVerifikasi = new VerifikasitagihanT();
        $modVerifikasi->tglverifikasi = date('d M Y H:i:s'); 
        $modVerifikasi->noverifikasi = MyGenerator::noVerifikasi();
        $modVerifikasi->notemp = '- Otomatis -';
        $modTandaBukti = null;
        
        if(!empty($id)){
            $tindakanPelayanan = TindakanpelayananT::model()->find('verifikasitagihan_id = '.$id);
            if (count($tindakanPelayanan)>0) {
                $modVerifikasi = VerifikasitagihanT::model()->findByPk($id);
                $modPendaftaran = BKPendaftaranT::model()->findByPk($tindakanPelayanan->pendaftaran_id);
                $modPasien = PasienM::model()->findByPk($tindakanPelayanan->pasien_id);
            }else{ 
                $modVerifikasi = new VerifikasitagihanT;
                $modPendaftaran = new BKPendaftaranT;
                $modPasien = new PasienM;
            }
        }
        
        if(isset($_GET['pendaftaran_id'])){
            $modPendaftaran = PendaftaranT::model()->findByPk($_GET['pendaftaran_id']);
            $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
        }
        
        if(count($cekSudahBayar)>0)
        {
            Yii::app()->user->setFlash('info',"Sudah melakukan pembayaran");
        }
        
        if(isset($_POST['VerifikasitagihanT']))
        {
            $transaction = Yii::app()->db->beginTransaction();
            try{
                $modVerifikasi->attributes = $_POST['VerifikasitagihanT'];
                $modVerifikasi->create_time = date('Y-m-d H:i:s');
                $modVerifikasi->create_loginpemakai_id = Yii::app()->user->id;
                $modVerifikasi->verifikasioleh_id = Yii::app()->user->getState('pegawai_id');
                

                if($modVerifikasi->save())
                {
                    $sukses = true;
                    if(isset($_POST['pembayaran'])){
                        $discount_tindakan = 0;
                        foreach ($_POST['pembayaran'] as $key => $bayar) {
                            $tindakanPelayanan->attributes = $bayar;
                            $tindakanpelayananId = $bayar['tindakanpelayanan_id'];
                            $diskon = (isset($bayar['discount_tindakan']) ? $bayar['discount_tindakan'] : 0);
                            $tariftindakan = (isset($bayar['tarif_tindakan']) ? $bayar['tarif_tindakan'] : 0);
                            
                            if($diskon <= 0){
                                $persen_diskon = 0;
                            }else{
                                $persen_diskon = ($diskon / $tariftindakan) * 100;
                            }

                            TindakanpelayananT::model()->updateByPk($tindakanpelayananId, array(
                                'qty_tindakan'=>(isset($bayar['qty_tindakan']) ? $bayar['qty_tindakan'] : 0),
                                'tarif_satuan'=>(isset($bayar['tarif_satuan']) ? $bayar['tarif_satuan'] : 0),
                                'tarif_tindakan'=>(isset($bayar['tarif_tindakan']) ? $bayar['tarif_tindakan'] : 0),
                                'tarifcyto_tindakan'=>(isset($bayar['tarifcyto_tindakan']) ? $bayar['tarifcyto_tindakan'] : 0),
                                'discount_tindakan'=>(isset($persen_diskon) ? $persen_diskon : 0),
                                'pembebasan_tarif'=>(isset($bayar['pembebasan_tindakan']) ? $bayar['pembebasan_tindakan'] : 0),
                                'subsidiasuransi_tindakan'=>(isset($bayar['subsidiasuransi_tindakan']) ? $bayar['subsidiasuransi_tindakan'] : 0),
                                'subsisidirumahsakit_tindakan'=>(isset($bayar['subsisidirumahsakit_tindakan']) ? $bayar['subsisidirumahsakit_tindakan'] : 0),
                                'iurbiaya_tindakan'=>(isset($bayar['iurbiaya_tindakan']) ? $bayar['iurbiaya_tindakan'] : 0),
                                'verifikasitagihan_id'=>$modVerifikasi->verifikasitagihan_id
                            )); 
                            
                            $modTindakankomponen = TindakankomponenT::model()->findAllByAttributes(array('tindakanpelayanan_id'=>$tindakanpelayananId));

                            if(count($modTindakankomponen)>0){
                                foreach ($modTindakankomponen as $key => $komp) {
                                    $nilai = $_POST['komponen'][$key][$tindakanpelayananId];
                                    $tindakanKompId = $komp->tindakankomponen_id;
                                    
                                    $subsidi_rs = (isset($bayar['subsisidirumahsakit_tindakan']) ? $bayar['subsisidirumahsakit_tindakan'] : 0);
                                    $subsidi_asuransi = (isset($bayar['subsidiasuransi_tindakan']) ? $bayar['subsidiasuransi_tindakan'] : 0);
                                    $iur_biaya = (isset($bayar['iurbiaya_tindakan']) ? $bayar['iurbiaya_tindakan'] : 0);
                                    $tarif_cyto = (isset($bayar['tarifcyto_tindakan']) ? $bayar['tarifcyto_tindakan'] : 0);
                                    $pembagi = (isset($bayar['tarif_satuan']) ? $bayar['tarif_satuan'] : 0);
                                    $nilai = $nilai;
                                    if($pembagi>0){
                                        $satuan_subsidi_rs = round(($nilai / $pembagi) * $subsidi_rs);
                                        $satuan_subsidi_asu = round(($nilai / $pembagi) * $subsidi_asuransi);
                                        $satuan_iurbiaya = round(($nilai / $pembagi) * $iur_biaya);
                                        $satuan_tarifcyto = round(($nilai / $pembagi) * $tarif_cyto);
                                    }else{
                                        $satuan_subsidi_rs = 0;
                                        $satuan_subsidi_asu = 0;
                                        $satuan_iurbiaya = 0;
                                        $satuan_tarifcyto = 0;
                                    }

                                    TindakankomponenT::model()->updateByPk($tindakanKompId,array(
                                        'tarif_kompsatuan'=>$nilai,
                                        'tarif_tindakankomp'=>$nilai,
                                        'subsidirumahsakitkomp'=>$satuan_subsidi_rs,
                                        'subsidiasuransikomp'=>$satuan_subsidi_asu,
                                        'iurbiayakomp'=>$satuan_iurbiaya,
                                        'tarifcyto_tindakankomp'=>$satuan_tarifcyto
                                        ));

                                }
                            }
                            else
                            {
                                $tindakankomp = new TindakankomponenT;
                                $tindakankomp->komponentarif_id = Params::KOMPONENTARIF_ID_TOTAL;
                                $tindakankomp->tindakanpelayanan_id = $tindakanpelayananId;
                                $tindakankomp->tarif_kompsatuan = str_replace(",", "",$bayar['tarif_satuan']);
                                $tindakankomp->tarif_tindakankomp = str_replace(",", "",$bayar['tarif_tindakan']);
                                $tindakankomp->tarifcyto_tindakankomp = str_replace(",", "",$bayar['tarifcyto_tindakan']);
                                $tindakankomp->subsidiasuransikomp = str_replace(",", "",$bayar['subsidiasuransi_tindakan']);
                                $tindakankomp->subsidipemerintahkomp = 0;
                                $tindakankomp->subsidirumahsakitkomp = str_replace(",", "",$bayar['subsisidirumahsakit_tindakan']);
                                $tindakankomp->iurbiayakomp = str_replace(",", "",$bayar['iurbiaya_tindakan']);
                                $tindakankomp->pembayaranjasa_id = null;

                                $tindakankomp->save();
                            }
                            //else{

                            //     TindakankomponenT::model()->updateByPk($tindakanKompId,array(
                            //     'tarif_kompsatuan'=>str_replace(",", "",$bayar['tarif_satuan']),
                            //     'tarif_tindakankomp'=>str_replace(",", "",$bayar['tarif_tindakan'])
                            //     ));
                            // }

                            $sukses = true;
                        }
//                         exit();
                    }    

                    if(isset($_POST['pembayaranAlkes'])){
                        foreach ($_POST['pembayaranAlkes'] as $key => $alkes) {
                            $obatalkes->attributes = $alkes;
                            $obatalkespasienId = $alkes['obatalkespasien_id'];
                            $diskon_obat = str_replace(",", "",$alkes['discount']);
                            $hargajual = str_replace(",", "",$alkes['hargajual_oa']);
                            
                            if($diskon_obat <= 0){
                                $persen_diskonOA = 0;
                            }else{
                                $persen_diskonObat = ($diskon_obat / $hargajual) * 100;
                                $persen_diskonOA = round($persen_diskonObat,2);
                            }
                            
//                            echo ($persen_diskonOA);exit;

                            BKObatalkesPasienT::model()->updateByPk($obatalkespasienId, array(
                                'qty_oa'=>str_replace(",", "",$alkes['qty_oa']),
                                'hargasatuan_oa'=>str_replace(",", "",$alkes['hargasatuan']),
                                'hargajual_oa'=>str_replace(",", "",$alkes['hargajual_oa']),
                                'discount'=> number_format($persen_diskonOA,10),
                                'tarifcyto'=>str_replace(",", "",$alkes['tarifcyto']),
                                'biayaservice'=>str_replace(",", "",$alkes['tarifcyto']),
                                'subsidiasuransi'=>str_replace(",", "",$alkes['subsidiasuransi']),
                                'subsidirs'=>str_replace(",", "",$alkes['subsidirs']),
                                'iurbiaya'=>str_replace(",", "",$alkes['iurbiaya']),
                                'verifikasitagihan_id'=>$modVerifikasi->verifikasitagihan_id
                            ));

                            $modKomponenObatAlkes = ObatalkeskomponenT::model()->findByAttributes(array('obatalkespasien_id'=>$obatalkespasienId));

                            $modObat = new ObatalkeskomponenT;
                            if(count($modKomponenObatAlkes)==0){
                                $modObat->obatalkespasien_id    = $obatalkespasienId;
                                $modObat->komponentarif_id      = Params::KOMPONENTARIF_ID_TOTAL;
                                $modObat->hargasatuankomponen   = str_replace(",", "",$alkes['hargasatuan']);
                                $modObat->hargajualkomponen     = str_replace(",", "",$alkes['hargajual_oa']);
                                $modObat->tarifcytokomponen     = str_replace(",", "",$alkes['tarifcyto']);
                                $modObat->subsidiasuransi       = str_replace(",", "",$alkes['subsidiasuransi']);
                                $modObat->subsidirs             = str_replace(",", "",$alkes['subsidirs']);
                                $modObat->harganettokomponen    = 0;
                                $modObat->subsidipemerintah     = 0;
                                $modObat->iurbiaya              = str_replace(",", "",$alkes['iurbiaya']);
                                $modObat->save();
                            }
                            else{
                                $obatalkeskomponenId = $modKomponenObatAlkes->obatalkeskomponen_id;
                                ObatalkeskomponenT::model()->updateByPk($obatalkeskomponenId,array(
                                    'hargasatuankomponen'=>str_replace(",", "",$alkes['hargasatuan']),
                                    'hargajualkomponen'=>str_replace(",", "",$alkes['hargajual_oa']),
                                    'tarifcytokomponen'=>str_replace(",", "",$alkes['tarifcyto']),
                                    'subsidiasuransi'=>str_replace(",", "",$alkes['subsidiasuransi']),
                                    'subsidirs'=>str_replace(",", "",$alkes['subsidirs']),
                                    'iurbiaya'=>str_replace(",", "",$alkes['iurbiaya'])
                                ));
                            }
                        }
                        $sukses = true;
                    }

                    if($sukses)
                    {
                        $transaction->commit();
                        
                        $this->redirect(array('index','id'=>$modVerifikasi->verifikasitagihan_id));
                        Yii::app()->user->setFlash('success',"Data berhasil disimpan");
                    }else{
                        $transaction->rollback();
                        Yii::app()->user->setFlash('error',"Data gagal disimpan");
                    }
                }else{
                    $transaction->rollback();
                    Yii::app()->user->setFlash('error',"Data gagal disimpan");
                }

            } catch (Exception $exc) {
                Yii::app()->user->setFlash('error',"Data gagal disimpan ".MyExceptionMessage::getMessage($exc,true));
                $transaction->rollback();
            }
        }

        $this->render('create',
            array(
                'modPendaftaran'=>$modPendaftaran,
                'modPasien'=>$modPasien,
                'modTindPelayanan'=>$tindakanPelayanan,
                'modVerifikasi'=>$modVerifikasi,
                'modTandaBukti'=>$modTandaBukti,
            )
        );
    }
    
    public function actionUpdate()
    {
        echo "Fitur Belum Tersedia";
    }
    
    public function actionLoadDataPembayaran()
    {
        if (Yii::app()->request->isAjaxRequest)
        {
            $pendaftaran_id = $_POST['pendaftaran_id'];
            $model = TindakanpelayananT::model()->findAllByAttributes(
                array(
                    'pendaftaran_id'=>$pendaftaran_id
                )
            );
            $data = '';
            $i = 0;
            foreach($model as $key=>$val)
            {
                $data .= $this->renderPartial('_formTindakan',
                    array(
                        'is_load'=>true,
                        'i'=>$i,
                        'model'=>$val
                    ), true
                );
                $i++;
            }
            
            $modelObat = BKObatalkesPasienT::model()->findAllByAttributes(
                array(
                    'pendaftaran_id'=>$pendaftaran_id
                )
            );
            $idx = 0;
            if($modelObat)
            {
                $data_obat = '';
                foreach($modelObat as $key=>$val)
                {
                    $data_obat .= $this->renderPartial('_formObatAlkes',
                        array(
                            'is_load'=>true,
                            'i'=>$idx,
                            'model'=>$val
                        ), true
                    );
                    $idx++;
                }                
            }
            
            $result = array(
                'tindakan'=>$data,
                'alkes'=>$data_obat,
            );
            echo json_encode($result);
            Yii::app()->end();
        }
    }
    
    public function actionGetTarifTindakan()
    {
        if (Yii::app()->request->isAjaxRequest)
        {
            $daftartindakan_id = $_POST['daftartindakan_id'];
            $ruangan_id = $_POST['ruangan_id'];
            $kelaspelayanan_id = $_POST['kelaspelayanan_id'];
            
            $model = TariftindakanperdaruanganV::model()->findAllByAttributes(
                array(
                    'daftartindakan_id'=>$daftartindakan_id,
                    'ruangan_id'=>$ruangan_id,
                    'kelaspelayanan_id'=>$kelaspelayanan_id
                )
            );
            
            $data = array();
            $data['tarif_tindakan'] = 0;
            $data['tarifcyto_tindakan'] = 0;
            
            $data['tarif_medis'] = 0;
            $data['tarif_rsakomodasi'] = 0;
            $data['tarif_paramedis'] = 0;
            $data['tarif_bhp'] = 0;
            
            foreach($model as $key=>$val)
            {
                if($val->komponentarif_id == Params::KOMPONENTARIF_ID_TOTAL)
                {
                    $data['tarif_tindakan'] = $val->harga_tariftindakan;
                    $data['tarifcyto_tindakan'] = $val->harga_tariftindakan * ($val->persencyto_tind / 100);
                }
            }
            
            $data['discount_tindakan'] = 0;
            $data['subsidiasuransi_tindakan'] = 0;
            $data['subsidipemerintah_tindakan'] = 0;
            $data['subsisidirumahsakit_tindakan'] = 0;
            $data['iurbiaya_tindakan'] = 0;
            $data['total_biaya'] = $data['tarif_tindakan'];
            
            /*
             * tarif_tindakan
             * tarif_rsakomodasi
             * tarif_medis
             * tarif_paramedis
             * tarif_bhp
             * tarif_satuan
             * tarifcyto_tindakan
             * 
             * discount_tindakan
             * subsidiasuransi_tindakan
             * subsidipemerintah_tindakan
             * subsisidirumahsakit_tindakan
             * iurbiaya_tindakan
             * total_biaya
             */
            
            echo json_encode($data);
            Yii::app()->end();
        }
    }
    
    public function actionAddFormPemakaianBahan()
    {
//        if (Yii::app()->request->isAjaxRequest)
//        {
            $idObatAlkes = $_GET['idObatAlkes'];
            $idDaftartindakan = (isset($_GET['idDaftartindakan']) ? $_GET['idDaftartindakan'] : "");
            $idTindPelayanan = (isset($_GET['idTindPelayanan']) ? $_GET['idTindPelayanan'] : "");
            $ruangan_id = (isset($_GET['ruangan_id']) ? $_GET['ruangan_id'] : "");
            
            $model = new BKObatalkesPasienT();
            $model->tglpelayanan = date('Y-m-d H:i:s');
            
            $modObatAlkes = ObatalkesM::model()->findByPk($idObatAlkes);
            $modDaftartindakan = DaftartindakanM::model()->findByPk($idDaftartindakan);
            $persenjual = $this->persenJualRuangan();
            
            $model->tindakanpelayanan_id = $idTindPelayanan;
            $model->daftartindakan_id = $idDaftartindakan;
            $model->hargasatuan_oa = floor(($persenjual + 100 ) / 100 * $modObatAlkes->hargajual);
            $model->obatalkes_nama = $modObatAlkes->obatalkes_nama;
            $model->obatalkes_id = $modObatAlkes->obatalkes_id;
            $model->sumberdana_id = $modObatAlkes->sumberdana_id;
            $model->satuankecil_id = $modObatAlkes->satuankecil_id;
            $model->ruangan_id = $ruangan_id;
            $model->tipepaket_id = 1;
            
            $model->qty_oa = 1;
            $model->tarifcyto = 0;
            $model->iurbiaya = 0;
            $model->discount = 0;
            $model->subsidiasuransi = 0;
            $model->subsidipemerintah = 0;
            $model->subsidirs = 0;
            
            echo CJSON::encode(
                array(
                    'form'=>$this->renderPartial('_formObatAlkes', 
                        array(
                            'is_load'=>true,
                            'i'=>99,                            
                            'model'=>$model
                        ), true
                    ),
                )
            );                         
//            Yii::app()->end();
//        }
    }
    
    public function actionAddFormPemakaianAlat()
    {
//        if (Yii::app()->request->isAjaxRequest)
//        {
            $idAlat = $_GET['idAlat'];
            $idDaftartindakan = (isset($_GET['idDaftartindakan']) ? $_GET['idDaftartindakan'] : "");
            $idTindPelayanan = (isset($_GET['idTindPelayanan']) ? $_GET['idTindPelayanan'] : "");
            $ruangan_id = (isset($_GET['ruangan_id']) ? $_GET['ruangan_id'] : "");
            
            $model = new BKObatalkesPasienT();
            $model->tglpelayanan = date('Y-m-d H:i:s');
           
            $modAlat = AlatmedisM::model()->findByPk($idAlat);
            $modDaftartindakan = DaftartindakanM::model()->findByPk($idDaftartindakan);
            
            $model->tindakanpelayanan_id = $idTindPelayanan;
            $model->daftartindakan_id = $idDaftartindakan;
            $model->obatalkes_nama = $modAlat->alatmedis_nama;
            $model->obatalkes_id = $modAlat->alatmedis_id;
            $model->ruangan_id = $ruangan_id;
            $model->sumberdana_id = 0;
            $model->satuankecil_id = 0;
            $model->tipepaket_id = 2;
            
            $model->hargasatuan_oa = 0;
            $model->qty_oa = 1;
            $model->tarifcyto = 0;
            $model->iurbiaya = 0;
            $model->discount = 0;
            $model->subsidiasuransi = 0;
            $model->subsidipemerintah = 0;
            $model->subsidirs = 0;
            
            echo CJSON::encode(
                array(
                    'form'=>$this->renderPartial('_formObatAlkes', 
                        array(
                            'is_load'=>true,
                            'i'=>99,                            
                            'model'=>$model
                        ), true
                    ),
                )
            );                         
//            Yii::app()->end();
//        }
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
 
    
}