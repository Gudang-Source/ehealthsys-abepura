<?php

class DaftarPasienController extends MyAuthController
{
        /**
	 * @return array action filters
	 */
        public $successSave = false;
        public $successSavePA = true; //variabel untuk validasi data opsional (pasien anastesi) diisi ketika dokter anastesi not empty
        public $isAnastesi = false; //variabel untuk validasi data opsional (pasien anastesi) diisi ketika dokter anastesi not empty
        public $isAdaTarif = true;
        
//	FILTER DENGAN SRBAC
//	public function filters()
//	{
//		return array(
//			'accessControl', // perform access control for CRUD operations
//		);
//	}
        
	public function actionIndex()
	{
               $this->pageTitle = Yii::app()->name." - Daftar Pasien";
               $modPasienMasukPenunjang = new BSMasukPenunjangV;
               $format = new MyFormatter();
               $modPasienMasukPenunjang->tgl_awal = date("Y-m-d");
               $modPasienMasukPenunjang->tgl_akhir = date('Y-m-d');
               $modPasienMasukPenunjang->ceklis = true;
               if(isset ($_REQUEST['BSMasukPenunjangV'])){
                    $modPasienMasukPenunjang->attributes=$_REQUEST['BSMasukPenunjangV'];
                    $modPasienMasukPenunjang->tgl_awal = $format->formatDateTimeForDb($_REQUEST['BSMasukPenunjangV']['tgl_awal']);
                    $modPasienMasukPenunjang->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['BSMasukPenunjangV']['tgl_akhir']);
               
                    //$modPasienMasukPenunjang->ceklis = $_REQUEST['BSMasukPenunjangV']['ceklis'];
               }
               $this->render('index',array(
                                 'modPasienMasukPenunjang'=>$modPasienMasukPenunjang                                 
                ));
	}
        /**
         * menggunakan perhitungan baru berdasarkan typeanastesis_m
         * 20-Jan-2014
         * @param type $id
         */
        public function actionUpdateRencana($id)
        {
            
            $format = new MyFormatter();
            $this->pageTitle = Yii::app()->name." - Operasi";
            $modRencanaOperasi = $this->loadAllByPasienMasukPenunjang($id);
            $modRencanaOperasiAttrib = $this->loadByPasienMasukPenunjang($id);
            // echo "<pre>"; echo count($modRencanaOperasiAttrib);exit();
            //JANGAN KE VIEW KARENA SERING DATANYA TIDAK ADA
            $modPasienPenunjang = BSMasukPenunjangV::model()->findByAttributes(
                array('pasienmasukpenunjang_id'=>$id)
            ); //data pasien penunjang
            $modPenunjang = new BSMasukPenunjangV; //untuk mengenerate isi dropdownlist
            $modKegiatanOperasi = BSKegiatanOperasiM::model()->findAllByAttributes(
                array('kegiatanoperasi_aktif'=>true),
                array('order'=>'kegiatanoperasi_nama')
            );
            $modOperasi = BSOperasiM::model()->findAllByAttributes(
                array('operasi_aktif'=>true),
                array('order'=>'operasi_nama')
            );
            if(count($modRencanaOperasiAttrib)<=0){
            $modAnastesi = new PasienanastesiT;
            $modRO = new BSRencanaOperasiT;
            $modRencanaOperasiAttrib = new BSRencanaOperasiT;
            }else{
            $modAnastesi = $this->loadAnastesi($modRencanaOperasiAttrib->pasienanastesi_id);
            $modAnastesi->pakeAnastesi = (!empty($modRencanaOperasiAttrib->dokteranastesi_id)? true : false);
            $modAnastesi->dokteranastesi_id = (!empty($modRencanaOperasiAttrib->dokteranastesi_id)? $modRencanaOperasiAttrib->dokteranastesi_id : '');
            $modAnastesi->perawatanastesi_id = $modRencanaOperasiAttrib->suster_id;
            $modRO = $modRencanaOperasiAttrib;
            }
            $modTindakanPelayanan = new BSTindakanPelayananT;
            $modTindakanKomponen = new BSTindakanKomponenT;
            
            
            $attrOperasi = '';
            $attrCeklis = '';
             
            if (isset($_POST['BSRencanaOperasiT']))
            {
                /* Looping dari data grid */
                $transaction = Yii::app()->db->beginTransaction();
                try{
                    // if(isset($_POST['BSTindakanPelayananT']))
                    $dataGrid = $_POST['BSTindakanPelayananT'];
                    $is_succes = true;
                    $msg_error = '';
                    //set null pembayaran supaya muncul di informasi belum bayar
                    PendaftaranT::model()->updateByPk($modPasienPenunjang->pendaftaran_id, 
                        array('pembayaranpelayanan_id'=>null)
                    );$total_seluruh = 0;

                    $jenistarif_id = JenistarifpenjaminM::model()->findByAttributes(array('penjamin_id'=>$modPasienPenunjang->penjamin_id))->jenistarif_id;
                    foreach ($dataGrid AS $i => $data){
                        if(strlen($data['ceklis']) > 0){ //jika di ceklis
                            
                            /* proses simpan / update rencana operasi*/
                            if(strlen(trim($dataGrid[$i]['rencanaoperasi_id'])) > 0)
                            {
                                /* proses jika sudah ada rencana_opereasi_id = update data*/
                                $modRencana = $this->loadById($dataGrid[$i]['rencanaoperasi_id']);
                                $modRencana->update_time = date('Y-m-d H:i:s');
                                $modRencana->update_loginpemakai_id = Yii::app()->user->id;
                            }else{
                                $modRencana = new BSRencanaOperasiT();
                                $modRencana->create_time = date('Y-m-d H:i:s');
                                $modRencana->create_loginpemakai_id = Yii::app()->user->id;
                                $modRencana->create_ruangan = Yii::app()->user->getState('ruangan_id');
                                $modRencana->update_time = null;
                                $modRencana->update_loginpemakai_id = null;
                            }

                            $modRencana->attributes = $dataGrid[$i];
                            $modRencana->pasienmasukpenunjang_id = $modPasienPenunjang->pasienmasukpenunjang_id;
                            $modRencana->pasienadmisi_id = $modPasienPenunjang->pasienadmisi_id;
                            $modRencana->golonganoperasi_id = empty($dataGrid[$i]['golonganoperasi_id']) ? NULL : $dataGrid[$i]['golonganoperasi_id'];
                            $modRencana->jenis_penyulit = empty($dataGrid[$i]['jenis_penyulit']) ? NULL : $dataGrid[$i]['jenis_penyulit'];
                            $modRencana->pendaftaran_id = empty($modPasienPenunjang->pendaftaran_id) ? NULL : $modPasienPenunjang->pendaftaran_id;
                            $modRencana->pasien_id = empty($modPasienPenunjang->pasien_id) ? NULL : $modPasienPenunjang->pasien_id;
                            $modRencana->norencanaoperasi = $_POST['BSRencanaOperasiT']['norencanaoperasi'];
                            $modRencana->tglrencanaoperasi = empty($_POST['BSRencanaOperasiT']['tglrencanaoperasi']) ? NULL : $format->formatDateTimeForDb($_POST['BSRencanaOperasiT']['tglrencanaoperasi']);
                            $modRencana->kamarruangan_id = empty($_POST['BSRencanaOperasiT']['kamarruangan_id']) ? NULL : $_POST['BSRencanaOperasiT']['kamarruangan_id'];
                            $modRencana->dokterpelaksana1_id = empty($_POST['BSRencanaOperasiT']['dokterpelaksana1_id']) ? NULL : $_POST['BSRencanaOperasiT']['dokterpelaksana1_id'];
                            $modRencana->dokterpelaksana2_id = empty($_POST['BSRencanaOperasiT']['dokterpelaksana2_id']) ? NULL : $_POST['BSRencanaOperasiT']['dokterpelaksana2_id'];
                            $modRencana->paramedis_id = empty($_POST['BSRencanaOperasiT']['paramedis_id']) ? NULL : $_POST['BSRencanaOperasiT']['paramedis_id'];
                            $modRencana->bidan_id = empty($_POST['BSRencanaOperasiT']['bidan_id']) ? NULL : $_POST['BSRencanaOperasiT']['bidan_id'];
                            $modRencana->suster_id = empty($_POST['BSRencanaOperasiT']['suster_id']) ? NULL : $_POST['BSRencanaOperasiT']['suster_id'];
                            $modRencana->keterangan_rencana = $_POST['BSRencanaOperasiT']['keterangan_rencana'];
							$modRencana->statusoperasi = 'MULAI';
                            $modRencana->is_operasibersama = ($dataGrid[$i]['is_operasibersama'] > 0) ? true : false;

                            if($modRencana->validate())
                            {
                                $modRencana->save();

                                /* proses simpan tindakanpelayanan */
                                if(strlen(trim($dataGrid[$i]['tindakanpelayanan_id'])) > 0)
                                {
                                    /* proses jika sudah ada rencana_opereasi_id = update data*/
                                    $modTindakanPelayanan= BSTindakanPelayananT::model()->findByPk($dataGrid[$i]['tindakanpelayanan_id']);
                                }else{
                                    $modTindakanPelayanan = new BSTindakanPelayananT;
                                }
                                $modTindakanPelayanan->attributes = $dataGrid[$i];
                                $modTindakanPelayanan->rencanaoperasi_id = $modRencana->rencanaoperasi_id;
                                $modTindakanPelayanan->pasienmasukpenunjang_id = $modPasienPenunjang->pasienmasukpenunjang_id;
                                $modTindakanPelayanan->pasienadmisi_id = $modPasienPenunjang->pasienadmisi_id;
                                $modTindakanPelayanan->penjamin_id = $modPasienPenunjang->penjamin_id;
                                $modTindakanPelayanan->pasien_id = $modPasienPenunjang->pasien_id;
                                $modTindakanPelayanan->kelaspelayanan_id = $modPasienPenunjang->kelaspelayanan_id;
                                $modTindakanPelayanan->pendaftaran_id = $modPasienPenunjang->pendaftaran_id;
                                $modTindakanPelayanan->carabayar_id = $modPasienPenunjang->carabayar_id;
                                $modTindakanPelayanan->jeniskasuspenyakit_id = $modPasienPenunjang->jeniskasuspenyakit_id;
                                $modTindakanPelayanan->shift_id = Yii::app()->user->getState('shift_id');
                                $modTindakanPelayanan->tipepaket_id = 1;
                                $modTindakanPelayanan->tgl_tindakan = $format->formatDateTimeForDb($dataGrid[$i]['mulaioperasi']);
                                $modTindakanPelayanan->satuantindakan = 'KALI';
//                                $modTindakanPelayanan->qty_tindakan = 1;
                                $modTindakanPelayanan->qty_tindakan = $dataGrid[$i]['qty_tindakan'];
                                $modTindakanPelayanan->discount_tindakan = 0;
                                $modTindakanPelayanan->subsidiasuransi_tindakan = 0;
                                $modTindakanPelayanan->subsidipemerintah_tindakan = 0;
                                $modTindakanPelayanan->subsisidirumahsakit_tindakan = 0;
                                $modTindakanPelayanan->iurbiaya_tindakan = 0;
                                $modTindakanPelayanan->ruangan_id =  Yii::app()->user->getState('ruangan_id');
                                $modTindakanPelayanan->instalasi_id = Yii::app()->user->getState('instalasi_id');
                                $modTindakanPelayanan->dokterpemeriksa1_id = $_POST['BSRencanaOperasiT']['dokterpelaksana1_id'];
                                $modTindakanPelayanan->dokterpemeriksa2_id = $_POST['BSRencanaOperasiT']['dokterpelaksana2_id'];
                                $modTindakanPelayanan->perawat_id = $_POST['BSRencanaOperasiT']['paramedis_id'];
                                $modTindakanPelayanan->bidan_id = $_POST['BSRencanaOperasiT']['bidan_id'];
                                $modTindakanPelayanan->perawat2_id = $_POST['BSRencanaOperasiT']['perawatsirkuler_id'];
                                $modTindakanPelayanan->suster_id = $_POST['BSRencanaOperasiT']['suster_id'];
//                                $modTindakanPelayanan->tarifcyto_tindakan = 0;
                                $modTindakanPelayanan->tarif_satuan = str_replace(",", "", $dataGrid[$i]['tarif_satuan']);
//                                $modTindakanPelayanan->tarif_tindakan = $modTindakanPelayanan->tarif_satuan * $modTindakanPelayanan->qty_tindakan;
								$modTindakanPelayanan->tarif_tindakan = $dataGrid[$i]['tarif_tindakan'];
								$modTindakanPelayanan->tarifcyto_tindakan = $modTindakanPelayanan->qty_tindakan * $modTindakanPelayanan->tarif_satuan * $dataGrid[$i]['persencyto_tind'] / 100;
								$modTindakanPelayanan->cyto_tindakan = (($dataGrid[$i]['cyto_tindakan'] == TRUE)? 1 : 0);
                                
                                // var_dump($modTindakanPelayanan->attributes); die;
                                if($modTindakanPelayanan->validate())
                                {
                                    if(isset($_POST['pakeAnastesi'])) 
                                    {
                                        $modAnastesi->pakeAnastesi = true;
                                        $tipeAnastesi = empty($dataGrid[$i]['typeanastesi_id']) ? NULL : $dataGrid[$i]['typeanastesi_id'];
                                        $modAnastesi = $this->saveAnastesi($_POST['PasienanastesiT'], $modRencana, $tipeAnastesi);
                                    }

                                    if(isset($_POST['paketBmhp']))
                                    {
                                        $modObatPasiens = $this->savePaketBmhp($modPasienPenunjang, $_POST['paketBmhp'], $modTindakanPelayanan);
                                    }

                                    if(isset($_POST['pemakaianBahan']))
                                    {
                                        $modPemakainBahans = $this->savePemakaianBahan($modPasienPenunjang, $_POST['pemakaianBahan'], $modTindakanPelayanan);
                                    }

                                    if($modTindakanPelayanan->save()){
										$this->isAdaTarif = $modTindakanPelayanan->saveTindakanKomponen();
									}

                                    $total_jasa_medis = 0;
                                    $total_jasa_paramedis = 0;
                                    $total_jasa_bhp = 0;
                                    $total_jasa_rs = 0;
                                    $total_tarif_satuan = 0;
                                    $total_lokal = 0;
                                    $jasaDokterAnastesi = 0;
                                    
                                    /* update tindakanpelayanan_id DI Rencana Operasi */
                                    $updateRencanaOperasi = BSRencanaOperasiT::model()->findByPk($modRencana->rencanaoperasi_id);
                                    $updateRencanaOperasi->tindakanpelayanan_id = $modTindakanPelayanan->tindakanpelayanan_id;
                                    $updateRencanaOperasi->save();
                                    /*update komponentarif_id = 6 (Total)*/
    //                              ADA KOMPONEN YG GAK KE TOTAL >>  $total_tarif_satuan = $total_jasa_rs + $total_jasa_medis + $total_jasa_paramedis + $total_jasa_bhp;
                                    $updateKomponenTotal = BSTindakanKomponenT::model()->findByAttributes(array('tindakanpelayanan_id' =>$modTindakanPelayanan->tindakanpelayanan_id, 'komponentarif_id' =>Params::KOMPONENTARIF_ID_TOTAL));
                                    if($total_lokal > 0){
                                        $total_tarif_satuan = $total_lokal; //replace
                                    }
                                    if(isset($updateKomponenTotal)){
                                        $updateKomponenTotal->tarif_kompsatuan = $total_tarif_satuan;
                                        $updateKomponenTotal->tarif_tindakankomp = $updateKomponenTotal->tarif_kompsatuan * $modTindakanPelayanan->qty_tindakan;
                                        $updateKomponenTotal->save();

                                    }
                                }else{
                                    foreach($modTindakanPelayanan->getErrors() as $key=>$val)
                                    {
                                        $msg_error .= $key . ' => ' . implode($val, ',') . '<br>';
                                    }
                                    $is_succes = false;
                                }
                                
                            }else{
                                foreach($modRencana->getErrors() as $key=>$val)
                                {
                                    $msg_error .= $key . ' => ' . implode($val, ',') . '<br>';
                                }
                                $is_succes = false;                            
                            }
                            
                        }else{
                            /* proses hapus rencana */
                            $is_succes = true;
                            if(isset($dataGrid[$i]['rencanaoperasi_id'])){
                                $updateRencana = $this->loadById($dataGrid[$i]['rencanaoperasi_id']);
                                $pasienanastesiId = $updateRencana->pasienanastesi_id;
                                $tindakanId = $updateRencana->tindakanpelayanan_id;
                                $updateRencana->tindakanpelayanan_id = null;
                                $updateRencana->pasienanastesi_id = null;
                                $updateRencana->save();
                                $deleteAnastesi = PasienanastesiT::model()->deleteByPk($pasienanastesiId);
                                if(!$deleteAnastesi){
                                    $is_succes = false;
                                }
                                $findTindakanPelayanan= BSTindakanPelayananT::model()->findByPk($tindakanId);
                                if($findTindakanPelayanan){
                                        $deleteTarifKomponen = BSTindakanKomponenT::model()->deleteAllByAttributes(array('tindakanpelayanan_id'=>$findTindakanPelayanan->tindakanpelayanan_id));
                                        if($deleteTarifKomponen){
                                            $deleteTindakanPelayanan = BSTindakanPelayananT::model()->deleteByPk($findTindakanPelayanan->tindakanpelayanan_id);
                                        }else{
                                            $is_succes = false;
                                        }
                                }
                                $deleteRencana = BSRencanaOperasiT::model()->deleteByPk($updateRencana->rencanaoperasi_id);
                                if(!$deleteRencana){
                                    $is_succes = false;
                                }
                            }
                        }
                    }
                    if($is_succes && ($this->isAdaTarif))
                    {
                        $transaction->commit();
                        
                        $this->redirect(array('updateRencana','id'=>$modPasienPenunjang->pasienmasukpenunjang_id,'sukses'=>1));
                    }else{
                        $transaction->rollback();
                        Yii::app()->user->setFlash('error',"Data gagal disimpan <br>".$msg_error);
                    }
                }catch(Exception $exc)
                {
                    Yii::app()->user->setFlash('error',"Data gagal disimpan ".MyExceptionMessage::getMessage($exc,true));
                    $transaction->rollback();
                    
                }
            }
            $modViewBahan = ObatalkespasienT::model()->with('obatalkes')->findAllByAttributes(
                array(
                    'pendaftaran_id'=>$modPasienPenunjang->pendaftaran_id,
                    'oa'=>'OA',
                    'ruangan_id'=>Yii::app()->user->getState('ruangan_id'),
                )
            );
            $modViewBmhp = ObatalkespasienT::model()->with('obatalkes')->findAllByAttributes(
                array(
                    'pendaftaran_id'=>$modPasienPenunjang->pendaftaran_id,
                    'oa'=>'OA',
                    'ruangan_id'=>Yii::app()->user->getState('ruangan_id'),
                )
            );
            
            $this->render('updateRencanaOperasi',
                array(
                    'modRencanaOperasi'=>$modRencanaOperasi,
                    'modRencanaOperasiAttrib'=>$modRencanaOperasiAttrib,
                    'modPenunjang'=>$modPenunjang,
                    'modPasienPenunjang'=>$modPasienPenunjang,
                    'modKegiatanOperasi'=>$modKegiatanOperasi,
                    'modOperasi'=>$modOperasi,
                    'modAnastesi'=>$modAnastesi,
                    'modRO'=>$modRO,
                    'modTindakanPelayanan'=>$modTindakanPelayanan,
                    'modTindakanKomponen'=>$modTindakanKomponen,
                    'modViewBahan'=>$modViewBahan,
                    'modViewBmhp'=>$modViewBmhp,
					'format'=>$format
                )
            );
        }
        
        public function saveTindakanPelayanT($attrPenunjang,$attrRencanaOperasi,$attrTindakanPelayanan,$attrOperasi)
        {
            $validTindakanPelayanan = 'true';
            $arrSave = array();
            
            $daftar_tindakan = $attrTindakanPelayanan['daftartindakan_id'][$attrOperasi];
            
            $kelaspelayanan_id = $attrTindakanPelayanan['kelaspelayanan_id'][$attrOperasi];
            
            $tarifTotal = 0;
                
            $tarifRS = 0;

            $tarifBHP = 0;

            $tarifParamedis = 0;

            $tarifMedis = 0;
                
                $modTindakanPelayanan = new BSTindakanPelayananT;
                $modTindakanPelayanan->rencanaoperasi_id = $attrRencanaOperasi->rencanaoperasi_id;
                $modTindakanPelayanan->penjamin_id = $attrPenunjang->penjamin_id;
                $modTindakanPelayanan->pasien_id = $attrPenunjang->pasien_id;
                $modTindakanPelayanan->kelaspelayanan_id = $kelaspelayanan_id;
                $modTindakanPelayanan->tipepaket_id = 1;
                $modTindakanPelayanan->instalasi_id = Params::INSTALASI_ID_IBS;
                $modTindakanPelayanan->pendaftaran_id = $attrPenunjang->pendaftaran_id;
                $modTindakanPelayanan->shift_id = Yii::app()->user->getState('shift_id');
                $modTindakanPelayanan->pasienmasukpenunjang_id = $attrPenunjang->pasienmasukpenunjang_id;
                $modTindakanPelayanan->daftartindakan_id = $daftar_tindakan;
                $modTindakanPelayanan->carabayar_id = $attrPenunjang->carabayar_id;
                $modTindakanPelayanan->jeniskasuspenyakit_id = $attrPenunjang->jeniskasuspenyakit_id;
                $modTindakanPelayanan->tgl_tindakan = date('Y-m-d H:i:s');
                $modTindakanPelayanan->qty_tindakan = $attrTindakanPelayanan['qty_tindakan'][$attrOperasi];
                $modTindakanPelayanan->tarif_tindakan = $attrTindakanPelayanan['tarif_tindakan'][$attrOperasi] * $modTindakanPelayanan->qty_tindakan;
                $modTindakanPelayanan->tarif_satuan = $modTindakanPelayanan->tarif_satuan;
                $modTindakanPelayanan->tarif_rsakomodasi = (!empty($tarifRS)) ? $tarifRS->harga_tariftindakan : 0 ;
                $modTindakanPelayanan->tarif_medis = (!empty($tarifMedis)) ? $tarifMedis->harga_tariftindakan : 0 ;
                $modTindakanPelayanan->tarif_paramedis = (!empty($tarifParamedis)) ? $tarifParamedis->harga_tariftindakan : 0 ;
                $modTindakanPelayanan->tarif_bhp = (!empty($tarifBHP)) ? $tarifBHP->harga_tariftindakan : 0 ;
                $modTindakanPelayanan->satuantindakan = $attrTindakanPelayanan['satuantindakan'][$attrOperasi];
                $modTindakanPelayanan->cyto_tindakan = $attrTindakanPelayanan['cyto_tindakan'][$attrOperasi];
                
                if($modTindakanPelayanan->cyto_tindakan){
                    $modTindakanPelayanan->tarifcyto_tindakan = $modTindakanPelayanan->tarif_tindakan * ($attrTindakanPelayanan['persencyto_tind'][$attrOperasi]/100);
                } else {
                    $modTindakanPelayanan->tarifcyto_tindakan = 0;
                }
                
                $modTindakanPelayanan->discount_tindakan = 0;
                $modTindakanPelayanan->dokterpemeriksa1_id = $attrRencanaOperasi->dokterpelaksana1_id;
                $modTindakanPelayanan->dokterpemeriksa2_id = (!empty($attrRencanaOperasi->dokterpelaksana2_id)) ? $attrRencanaOperasi->dokterpelaksana2_id : null;
                $modTindakanPelayanan->dokteranastesi_id = (!empty($attrRencanaOperasi->dokteranastesi_id)) ? $attrRencanaOperasi->dokteranastesi_id : null;
                $modTindakanPelayanan->dokterdelegasi_id = (!empty($attrRencanaOperasi->dokterdelegasi_id)) ? $attrRencanaOperasi->dokterdelegasi_id : null;
                $modTindakanPelayanan->perawat_id = (!empty($attrRencanaOperasi->perawat_id)) ? $attrRencanaOperasi->perawat_id : null;
                $modTindakanPelayanan->bidan_id = (!empty($attrRencanaOperasi->bidan_id)) ? $attrRencanaOperasi->bidan_id : null;
                $modTindakanPelayanan->suster_id = (!empty($attrRencanaOperasi->bidan_id)) ? $attrRencanaOperasi->suster_id : null;
                $modTindakanPelayanan->subsidiasuransi_tindakan=0;
                $modTindakanPelayanan->subsidipemerintah_tindakan=0;
                $modTindakanPelayanan->subsisidirumahsakit_tindakan=0;
                $modTindakanPelayanan->iurbiaya_tindakan=0;
                $modTindakanPelayanan->ruangan_id =  Yii::app()->user->getState('ruangan_id');
                
                if ($modTindakanPelayanan->validate()){
                    $arrSave[$i] = $modTindakanPelayanan; // menyimpan objek BSRencanaOperasiT ke dalam sebuah array dan siap untuk disave

                }else
                {   
                    $validTindakanPelayanan = 'false';
                }
            if($validTindakanPelayanan == 'true') //kondisi apabila semua rencana operasi valid dan siap untuk di save
            {
                foreach ($arrSave as $x => $simpan) {
                    if($simpan->save()){
						$simpan->saveTindakanKomponen();
					}
                    $this->upadateRencanaOperasi($simpan);
                }
                $this->successSave = true;
            }
            else
            {
                $this->successSave = false;
            }

            return $modTindakanPelayanan;
        }
        
//        RND-6260
//        public function saveTindakanKomponenT($attrTindakanPelayanan)
//        {
//            $arrSave = array();
//            $validTindakanKomponen = 'true';
//            $daftarTindakan_id = $attrTindakanPelayanan->daftartindakan_id;
//            $kelaspelayanan_id = $attrTindakanPelayanan->kelaspelayanan_id;
//            
//            $arrTarifTindakan = "
//                select * 
//                from tariftindakan_m 
//                where daftartindakan_id = ".$daftarTindakan_id." and 
//                kelaspelayanan_id = ".$kelaspelayanan_id." and 
//                komponentarif_id <> ".Params::KOMPONENTARIF_ID_TOTAL."
//            ";
//            $query = Yii::app()->db->createCommand($arrTarifTindakan)->queryAll();
//            foreach ($query as $i => $tarifKomponen) {
//                $modTarifKomponen = new BSTindakanKomponenT;
//                $modTarifKomponen->tindakanpelayanan_id = $attrTindakanPelayanan->tindakanpelayanan_id;
//                $modTarifKomponen->komponentarif_id = $tarifKomponen['komponentarif_id'];
//                $modTarifKomponen->tarif_tindakankomp = $tarifKomponen['harga_tariftindakan'] * $attrTindakanPelayanan->qty_tindakan;
//                $modTarifKomponen->tarif_kompsatuan = $modTarifKomponen->tarif_tindakankomp;
//                if($attrTindakanPelayanan->cyto_tindakan){
//                    $modTarifKomponen->tarifcyto_tindakankomp = $tarifKomponen['harga_tariftindakan'] * ($tarifKomponen['persencyto_tind']/100);
//                } else {
//                    $modTarifKomponen->tarifcyto_tindakankomp = 0;
//                }
//                $modTarifKomponen->subsidiasuransikomp = 0;
//                $modTarifKomponen->subsidipemerintahkomp = 0;
//                $modTarifKomponen->subsidirumahsakitkomp = 0;
//                $modTarifKomponen->iurbiayakomp = 0;
//                if ($modTarifKomponen->validate()){
//                    $arrSave[$i] = $modTarifKomponen; // menyimpan objek tarif komponen ke dalam sebuah array dan siap untuk disave
//
//                }else
//                {
//                    $validTindakanKomponen = 'false';
//                }
//            } // ending foreach
//            if($validTindakanKomponen == 'true') //kondisi apabila semua rencana operasi valid dan siap untuk di save
//            {
//                foreach ($arrSave as $f => $simpan) {
//                    $simpan->save();
//                }
//                $this->successSave = true;
//            }
//            else
//            {
//                $this->successSave = false;
//            }
//            return $modTarifKomponen;
//        }
        
        public function saveRencanaOperasi($attrPenunjang,$attrRencana,$attrOperasi,$attrCeklis,
                                            $attrTindakanPelayanan,$attrTambahan,$modAnastesi)
        {
            $format = new MyFormatter;
            $arrSave = array();
            $validRencana = 'true';
            $arrOperasi = array(); // array untuk menampung operasi yg nantinnya digunakan pada proses saveTindakanPelayanan
            for ($i = 0; $i < count($attrCeklis); $i++) {
                    $patokan = $attrCeklis[$i];
                        $modRencana = $this->loadById($attrTambahan['rencanaoperasi_id'][$patokan]);
                        $modRencana->attributes = $attrRencana->attributes;
                        
                        $modRencana->kamarruangan_id = (!empty($modRencana->kamarruangan_id)) ? $modRencana->kamarruangan_id : null ;
                        $modRencana->dokterpelaksana2_id = (!empty($modRencana->dokterpelaksana2_id)) ? $modRencana->dokterpelaksana2_id : null ;
                        $modRencana->perawat_id = (!empty($modRencana->perawat_id)) ? $modRencana->perawat_id : null ;
                        $modRencana->dokteranastesi_id = (!empty($modRencana->dokteranastesi_id)) ? $modRencana->dokteranastesi_id : null ;
                        $modRencana->dokterdelegasi_id = (!empty($modRencana->dokterdelegasi_id)) ? $modRencana->dokterdelegasi_id : null ;
                        $modRencana->bidan_id = (!empty($modRencana->bidan_id)) ? $modRencana->bidan_id : null ;
                        $modRencana->suster_id = (!empty($modRencana->suster_id)) ? $modRencana->suster_id : null ;
                        
                        $modRencana->selesaioperasi = $format->formatDateTimeForDb($attrTambahan['selesaioperasi'][$patokan]); 
                        $modRencana->mulaioperasi = $format->formatDateTimeForDb($attrTambahan['mulaioperasi'][$patokan]); 
                        $modRencana->golonganoperasi_id = (!empty($attrTambahan['golonganoperasi_id'][$patokan])) ? $attrTambahan['golonganoperasi_id'][$patokan] : null ;
                        
                        $modRencana->statusoperasi = $attrTambahan['statusoperasi'][$patokan]; 
                        
                        $modRencana->operasi_id = $attrOperasi[$patokan];
                        
                        $arrOperasi[$i]=array(
                                            'operasi'=> $attrOperasi[$patokan]
                                        );
                        
                        $modRencana->update_time=date('Y-m-d H:i:s');
                        $modRencana->update_loginpemakai_id=Yii::app()->user->id;
                                                
                        if ($modRencana->validate()){
                            $arrSave[$i] = $modRencana; // menyimpan objek BSRencanaOperasiT ke dalam sebuah array dan siap untuk disave
                            $validRencana = 'true'; // variabel untuk menentukan rencana operasi valid

                        }else{
                            $modRencana->tglrencanaoperasi = Yii::app()->dateFormatter->formatDateTime(
                                    CDateTimeParser::parse($modRencana->tglrencanaoperasi, 'yyyy-MM-dd'), 'medium', null);

                            $validRencana = $validRencana.'false';
                        }
                } //ENDING FOR 
                if($validRencana == 'true') //kondisi apabila semua rencana operasi valid dan siap untuk di save
                {
                    foreach ($arrOperasi as $x => $hasilOperasi) {
                        $operasiNya[$x] = $hasilOperasi['operasi'];
                    }
                    foreach ($arrSave as $f => $simpan) {
                        $simpan->save();
                        $this->saveTindakanPelayanT($attrPenunjang,$simpan,$attrTindakanPelayanan,$operasiNya[$f]);
                        
                        if($this->isAnastesi) {
                                $modAnastesi = $this->saveAnastesi($modAnastesi,$simpan);
                           }
                           
                        $this->successSave = true;
                    }
                }
                else
                {
                    $this->successSave = false;
                }
            return $modRencana;
        }
        
        public function saveAnastesi($attrAnastesi, $modRencana, $tipeAnastesi = null)
        {
            $arrSave = array();
            $validAnastesi = 'true';
//            $modUpdateRencana = $this->loadAllByPasienMasukPenunjang($modRencana->pasienmasukpenunjang_id);
            $attributes = array(
                'pendaftaran_id' => $modRencana->pendaftaran_id,
                'rencanaoperasi_id' => $modRencana->rencanaoperasi_id
            );
            $is_empty = PasienanastesiT::model()->findByAttributes($attributes);
            if(!$is_empty)
            {
                $modAnastesi = new PasienanastesiT;
            }else{
                $modAnastesi = $is_empty;
            }
            $modAnastesi->attributes = $attrAnastesi;
            $modAnastesi->jenisanastesi_id = (!empty($attrAnastesi['jenisanastesi_id'])) ? $attrAnastesi['jenisanastesi_id'] : null;
            $modAnastesi->anastesi_id = (!empty($attrAnastesi['anastesi_id'])) ? $attrAnastesi['anastesi_id'] : null;
//          UNTUK TIPE GUNAKAN YANG DI TABEL DETAIL OPERASI >>  $modAnastesi->typeanastesi_id = (!empty($attrAnastesi['typeanastesi_id'])) ? $attrAnastesi['typeanastesi_id'] : null;
            $modAnastesi->typeanastesi_id = $tipeAnastesi;
            $modAnastesi->perawatanastesi_id = (!empty($attrAnastesi['perawatanastesi_id'])) ? $attrAnastesi['perawatanastesi_id'] : null;
            $modAnastesi->pendaftaran_id = $modRencana->pendaftaran_id;
            $modAnastesi->pasien_id = $modRencana->pasien_id;
            $modAnastesi->pasienmasukpenunjang_id = $modRencana->pasienmasukpenunjang_id;
            $modAnastesi->rencanaoperasi_id = $modRencana->rencanaoperasi_id;
            $modAnastesi->tglanastesi = date('Y-m-d h:i:s');
            $modAnastesi->create_time=date('Y-m-d H:i:s');
            $modAnastesi->create_loginpemakai_id=Yii::app()->user->id;
            $modAnastesi->create_ruangan=Yii::app()->user->getState('ruangan_id');
            if($modAnastesi->validate())
            {
                $modAnastesi->save();
                $updateRencana = $this->loadById($modRencana->rencanaoperasi_id);
                $updateRencana->pasienanastesi_id = $modAnastesi->pasienanastesi_id;
                $updateRencana->dokteranastesi_id = $modAnastesi->dokteranastesi_id;
                $updateRencana->save();
                
                /*
                foreach ($modUpdateRencana as $rencana)
                {
                    $updateRencana = $this->loadById($rencana->rencanaoperasi_id); //update pasienanastesi_id ke rencanaoperasi_t
                    $updateRencana->pasienanastesi_id = $modAnastesi->pasienanastesi_id;
                    $updateRencana->save();
                }
                 * 
                 */
                
                if($modAnastesi->save() && $updateRencana->save())
                {
                    $this->successSavePA = true;
                }
                else{
                    $this->successSavePA = false;
                }
            }
            else{
                $this->successSavePA = false;
            }
            return $modAnastesi;
        }
        
        /**
         * Fungsi untuk mengembalikan object $model dengan method findAllByAttributes yang nanti digunakan untuk mendeskripsikan operasi_id
         * @param type $id
         * @return type 
         */
        public function loadAllByPasienMasukPenunjang($id)
        {
                $model= BSRencanaOperasiT::model()->findAllByAttributes(
                    array(
                        'pasienmasukpenunjang_id'=>$id
                    )
                );
	
		return $model;
        }
        /**
         * Fungsi untuk mengembalikan object $model dengan method findByAttributes yang nanti digunakan untuk mendeskripsikan data-data rencanaOperasiT
         * @param type $id
         * @return type 
         */
        public function loadByPasienMasukPenunjang($id)
        {
                $model= BSRencanaOperasiT::model()->findByAttributes(
                    array(
                        'pasienmasukpenunjang_id'=>$id
                    )
                );
		return $model;
        }
        /**
         * Fungsi untuk mengembalikan object $model dengan method findByPk yang nanti digunakan untuk menyimpan data-data rencanaOperasiT
         * @param type $id
         * @return type 
         */
        public function loadById($id)
        {
                $model= BSRencanaOperasiT::model()->findByPk($id);
		if($model===null)
                    throw new CHttpException(404,'The requested page does not exist.');
		return $model;
        }
        
        /*
         * Fungsi untuk mengembalikan object pasienanastesiT yg dicari berdasarkan rencanaoperasi_id
         */
        public function loadAnastesi($id)
        {
             $model= PasienanastesiT::model()->findByPk($id);
             if(!empty($model))
             {
                return $model;
             }
             else
             {
                 return new PasienanastesiT;
             }
        }
        
        /**
         * Fungsi untuk mengupadte rencana operasi menset tindakanpelayanan id
         * @param type $modTindPelayanan model object
         */
        protected function upadateRencanaOperasi($modTindPelayanan)
        {
            $modRencana = $this->loadById($modTindPelayanan->rencanaoperasi_id);
            $modRencana->tindakanpelayanan_id = $modTindPelayanan->tindakanpelayanan_id;
            $modRencana->save();
        }
        
        public function actionGetDataOperasi()
        {
            if(Yii::app()->request->isAjaxRequest)
            {
                $id_operasi = $_POST['idOperasi'];
                $is_operasi = $_POST['is_operasi'];
                $is_operasibersama = $_POST['is_operasibersama'];
                $kelaspelayanan_id = $_POST['kelaspelayanan_id'];
                
                $criteria = new CDbCriteria;
				if(!empty($id_operasi)){
					$criteria->addCondition('operasi_id = '.$id_operasi);
				}
                $criteria->with = array('kegiatanoperasi');
                $data = new CActiveDataProvider('BSOperasiM',
                    array(
                        'criteria' => $criteria,
                    )
                );
                
                $rec = array();
                foreach($data->getData() as $idx=>$val)
                {
                    $rec['nama_operasi'] = $val['kegiatanoperasi']['kegiatanoperasi_nama'] . ' - ' . $val['operasi_nama'];
                    $rec['label'] = $val['operasi_nama'];
                    $rec['daftartindakan_id'] = $val['daftartindakan_id'];
                    $rec['tarif_tindakan'] = 0;
                    $rec['tarifcyto_tindakan'] = 0;
                    		
                    $criteria = new CDbCriteria();
                    $criteria->addCondition("daftartindakan_id = ".$val['daftartindakan_id']);
                    $criteria->addCondition("kelaspelayanan_id = ".$kelaspelayanan_id);
                    $criteria->addCondition("komponentarif_id = ".Params::KOMPONENTARIF_ID_TOTAL);
                    $record = TariftindakanM::model()->findAll($criteria);
                    
                    
                    foreach($record as $idx=>$values)
                    {
                        if($values['komponentarif_id'] == Params::KOMPONENTARIF_ID_TOTAL)
                        {
                            $rec['tarif_tindakan'] = $values['harga_tariftindakan'];
                            $rec['tarif_satuan'] = $values['harga_tariftindakan'];
                        }
//                    PERHITUNGAN TARIF CYTO DINONAKTIFKAN KARENA DIBUAT TINDAKAN YANG BERBEDA
                        $rec['tarifcyto_tindakan'] = 0;
                    }
                    
                    foreach($val as $key=>$value)
                    {
                        $rec[$key] = $value;
                    }
                }
                $rec['is_operasi'] = $is_operasi;
                $tindakanPelayananT = new BSTindakanPelayananT;
                $tindakanPelayananT->attributes = $rec;
                
                $rencanaOperasi = new BSRencanaOperasiT;
                $rencanaOperasi->attributes = $rec;
                $rencanaOperasi->statusoperasi = 'MULAI';
                $rencanaOperasi->mulaioperasi = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse(date("Y-m-d H:i:s"), 'yyyy-MM-dd hh:mm:ss','medium', null));
                $rencanaOperasi->selesaioperasi = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse(date("Y-m-d H:i:s"), 'yyyy-MM-dd hh:mm:ss','medium', null));
                $rencanaOperasi->is_operasibersama = $is_operasibersama;
                
                $form = $this->renderPartial('_gridRencanaOperasi',
                    array(
                        'data'=>$rec,
                        'tindakanPelayananT'=>$tindakanPelayananT,                                 
                        'rencanaOperasi'=>$rencanaOperasi,
                    ), true
                );
                
                $return = array(
                    'success'=>true,
                    'item'=>$rec['daftartindakan_id'],
                    'label'=>$rec['nama_operasi'],
                    'rec'=>$form
                );
                echo json_encode($return);
                Yii::app()->end();
            }            
        }
        
        protected function savePemakaianBahan($modPendaftaran, $pemakaianBahan, $tindakan)
        {
            $valid = true;
            foreach ($pemakaianBahan as $i => $bmhp)
            {
                if($tindakan->daftartindakan_id == $bmhp['daftartindakan_id'])
                {
                    $modPakaiBahan[$i] = new ObatalkespasienT();
                    $modPakaiBahan[$i]->pendaftaran_id = $modPendaftaran->pendaftaran_id;
                    $modPakaiBahan[$i]->penjamin_id = $modPendaftaran->penjamin_id;
                    $modPakaiBahan[$i]->carabayar_id = $modPendaftaran->carabayar_id;
                    if(!empty($modPendaftaran->pasienadmisi_id)){
                        $modPakaiBahan[$i]->pasienadmisi_id = $modPendaftaran->pasienadmisi_id;
                    }
                    $modPakaiBahan[$i]->daftartindakan_id = $bmhp['daftartindakan_id'];
                    $modPakaiBahan[$i]->sumberdana_id = $bmhp['sumberdana_id'];
                    $modPakaiBahan[$i]->pasien_id = $modPendaftaran->pasien_id;
                    $modPakaiBahan[$i]->satuankecil_id = $bmhp['satuankecil_id'];
                    $modPakaiBahan[$i]->ruangan_id = Yii::app()->user->getState('ruangan_id');
                    $modPakaiBahan[$i]->tindakanpelayanan_id = $tindakan->tindakanpelayanan_id;
                    $modPakaiBahan[$i]->tipepaket_id = $tindakan->tipepaket_id;
                    $modPakaiBahan[$i]->obatalkes_id = $bmhp['obatalkes_id'];
                    $modPakaiBahan[$i]->pegawai_id = $modPendaftaran->pegawai_id;
                    $modPakaiBahan[$i]->kelaspelayanan_id = $modPendaftaran->kelaspelayanan_id;
                    $modPakaiBahan[$i]->shift_id = Yii::app()->user->getState('shift_id');
                    $modPakaiBahan[$i]->tglpelayanan = date('Y-m-d H:i:s');
                    $modPakaiBahan[$i]->qty_oa = $bmhp['qty'];
                    $modPakaiBahan[$i]->hargajual_oa = $bmhp['subtotal'];
                    $modPakaiBahan[$i]->harganetto_oa = $bmhp['harganetto'];
                    $modPakaiBahan[$i]->hargasatuan_oa = $bmhp['hargasatuan'];
                    $modPakaiBahan[$i]->oa = Params::OBATALKESPASIEN_BMHP;
                    $valid = $modPakaiBahan[$i]->validate() && $valid;
                    if($valid)
                    {
                        $modPakaiBahan[$i]->save();
                        $this->simpanStokKeluar($modPakaiBahan[$i]);
                        /*
                        StokObatAlkesT::kurangiStok(
                            $modPakaiBahan[$i]->qty_oa,
                            $modPakaiBahan[$i]->obatalkes_id
                        );
                         * 
                         */
                    }
                }
            }
        }
        
        function simpanStokKeluar($modPemakaianBahan) {
            $format = new MyFormatter;
            //$modStokOa = StokobatalkesT::model()->findByPk($stokobatalkesasal_id);
            $oa = ObatalkesM::model()->findByPk($modPemakaianBahan->obatalkes_id);
            //var_dump($oa->attributes);
            $modStokOaNew = new StokobatalkesT;
            $modStokOaNew->attributes = $oa->attributes;
            $modStokOaNew->attributes = $modPemakaianBahan->attributes; //duplicate
            //$modStokOaNew->unsetIdTransaksi();
            $modStokOaNew->qtystok_in = 0;
            $modStokOaNew->qtystok_out = ceil($modPemakaianBahan->qty_oa); // LNG Ceil (Pembulatan keatas request pak tito)
            $modStokOaNew->obatalkespasien_id = $modPemakaianBahan->obatalkespasien_id;
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
                $modStokOaNew->save();
                // $modStokOaNew->setStokOaAktifBerdasarkanStok();
            }

            // var_dump($this->stokobatalkestersimpan);

            return $modStokOaNew;
        }
        
        protected function savePaketBmhp($modPendaftaran,$paketBmhp,$tindakan)
        {
            $valid = true; $totalBmhp = 0;
            foreach ($paketBmhp as $i => $bmhp) {
                if($tindakan->daftartindakan_id == $bmhp['daftartindakan_id']){
                    $modObatPasien[$i] = new RJObatalkesPasienT;
                    $modObatPasien[$i]->pendaftaran_id = $modPendaftaran->pendaftaran_id;
                    $modObatPasien[$i]->penjamin_id = $modPendaftaran->penjamin_id;
                    $modObatPasien[$i]->carabayar_id = $modPendaftaran->carabayar_id;
                    if(!empty($modPendaftaran->pasienadmisi_id)){
                        $modObatPasien[$i]->pasienadmisi_id = $modPendaftaran->pasienadmisi_id;
                    }
                    $modObatPasien[$i]->daftartindakan_id = $bmhp['daftartindakan_id'];
                    $modObatPasien[$i]->sumberdana_id = $bmhp['sumberdana_id'];
                    $modObatPasien[$i]->pasien_id = $modPendaftaran->pasien_id;
                    $modObatPasien[$i]->satuankecil_id = $bmhp['satuankecil_id'];
                    $modObatPasien[$i]->ruangan_id = Yii::app()->user->getState('ruangan_id');
                    $modObatPasien[$i]->tindakanpelayanan_id = $tindakan->tindakanpelayanan_id;
                    $modObatPasien[$i]->tipepaket_id = Params::TIPEPAKET_ID_NONPAKET;
                    $modObatPasien[$i]->obatalkes_id = $bmhp['obatalkes_id'];
                    $modObatPasien[$i]->pegawai_id = $modPendaftaran->pegawai_id;
                    $modObatPasien[$i]->kelaspelayanan_id = $modPendaftaran->kelaspelayanan_id;
                    $modObatPasien[$i]->shift_id = Yii::app()->user->getState('shift_id');
                    $modObatPasien[$i]->tglpelayanan = date('Y-m-d H:i:s');
                    $modObatPasien[$i]->qty_oa = $bmhp['qtypemakaian'];
                    $modObatPasien[$i]->hargajual_oa = $bmhp['hargapemakaian'];
                    $modObatPasien[$i]->harganetto_oa = $bmhp['harganetto'];
                    $modObatPasien[$i]->hargasatuan_oa = $bmhp['hargapemakaian'];
                    $totalBmhp = $totalBmhp + $bmhp['hargapemakaian'];
                    $valid = $modObatPasien[$i]->validate() && $valid;
                    if($valid) {
                        $modObatPasien[$i]->save();
//                        StokObatAlkesT::kurangiStok($modObatPasien[$i]->qty_oa, $modObatPasien[$i]->obatalkes_id);
                    }
                }
            }
            
            $totalBmhp = $totalBmhp + $tindakan->tarif_bhp;
            $tindakan->tarif_bhp = $totalBmhp;
            $tindakan->update();
            return $modObatPasien;
        }
        /**
         * membatalkan pemeriksaan penunjang IBS
         */
        public function actionBatalPeriksa()
        {
            if(Yii::app()->request->isAjaxRequest)
            {
                $transaction = Yii::app()->db->beginTransaction();
                $pesan = 'success';
                $status = 'ok';

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
                $smspasien = 1;
                $nama_pasien = '';

                try{
                    $idPenunjang = $_POST['idPenunjang'];
                    if($idPenunjang){
                        $pasienMasukPenunjang = PasienmasukpenunjangT::model()->findByPk($idPenunjang);
                        $modPendaftaran = PendaftaranT::model()->findByPk($pasienMasukPenunjang->pendaftaran_id);
                        if($modPendaftaran->pembayaranpelayanan_id){ // sudah lunas semua
                            $status = 'not';
                            $pesan = 'exist';
                            $keterangan = "<div class='flash-success'>Pasien <b> ".$pasienMasukPenunjang->pendaftaran->pasien->nama_pasien." 
                                                </b> sudah melakukan pembayaran pemeriksaan </div>";
                        }else{
                            $criteria = new CdbCriteria;
                            $criteria->addCondition('pasienmasukpenunjang_id = '.$pasienMasukPenunjang->pasienmasukpenunjang_id);
                            $criteria->addCondition('tindakansudahbayar_id > 0');
                            $tindakan = TindakanpelayananT::model()->findAll($criteria);
                            if(count($tindakan) > 0){
                                $status = 'not';
                                $pesan = 'exist';
                                $keterangan = "<div class='flash-success'>Pasien <b> ".$pasienMasukPenunjang->pendaftaran->pasien->nama_pasien." 
                                                    </b> sudah melakukan pembayaran pemeriksaan </div>";
                            }else{
                                $model = new PasienbatalperiksaR();
                                $model->pendaftaran_id = $pasienMasukPenunjang->pendaftaran_id;
                                $model->pasien_id = $pasienMasukPenunjang->pasien_id;
                                $model->pasienmasukpenunjang_id = $pasienMasukPenunjang->pasienmasukpenunjang_id;
                                $model->pasienkirimkeunitlain_id = $pasienMasukPenunjang->pasienkirimkeunitlain_id;
                                $model->tglbatal = date('Y-m-d');
                                $model->keterangan_batal = Params::KETERANGANBATAL_BEDAH_SENTRAL;
                                $model->create_time = date('Y-m-d H:i:s');
                                $model->update_time = null;
                                $model->create_loginpemakai_id = Yii::app()->user->id;
                                $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
                                if($model->save()){
                                    $status = 'ok';
                                    $pesan = 'exist';
                                    $keterangan = "<div class='flash-success'>Pemeriksaan Berhasil dibatalkan ! </div>";
                                }
                            }
                        }
                    }

                    /*
                     * kondisi_commit
                     */
                    if($status == 'ok')
                    {
                         // SMS GATEWAY
                        $sms = new Sms();
                        $modPasien = PasienM::model()->findByPk($model->pasien_id);
                        $nama_pasien = $modPasien->nama_pasien;
                        foreach ($modSmsgateway as $i => $smsgateway) {
                            $isiPesan = $smsgateway->templatesms;

                            $attributes = $model->getAttributes();
                            foreach($attributes as $attributes => $value){
                                $isiPesan = str_replace("{{".$attributes."}}",$value,$isiPesan);
                            }
                            $attributes = $modPasien->getAttributes();
                            foreach($attributes as $attributes => $value){
                                $isiPesan = str_replace("{{".$attributes."}}",$value,$isiPesan);
                            }
                           
                            $isiPesan = str_replace("{{hari}}",MyFormatter::getDayName($model->tglbatal),$isiPesan);
                         
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
                    }else{
                        $transaction->rollback();
                    }   
                }catch(Exception $ex){
                    print_r($ex);
                    $status = 'not';
                    $transaction->rollback();
                }

                $data['pesan'] = $pesan;
                $data['status'] = $status;
                $data['keterangan'] = $keterangan;
                $data['smspasien'] = $smspasien;
                $data['nama_pasien'] = $nama_pasien;

                echo json_encode($data);
                Yii::app()->end();
            }
        }

        /**
         * action ketika tombol panggil di klik
         */
        public function actionPanggil(){
            if(Yii::app()->request->isAjaxRequest)
            {
                $format = new MyFormatter();
                $data = array();
                $data['pesan']="";
                $pasienmasukpenunjang_id = ($_POST['pasienmasukpenunjang_id']);
                $keterangan = (isset($_POST['keterangan']) ? $_POST['keterangan'] : null);
                $pasienMasukPenunjang =  PasienmasukpenunjangT::model()->findByPk($pasienmasukpenunjang_id);
                if(isset($pasienMasukPenunjang)){
                    if($pasienMasukPenunjang->panggilantrian == true){
                        if($keterangan == "batal"){
                            $pasienMasukPenunjang->panggilantrian = false;
                            if($pasienMasukPenunjang->update()){
                                $data['pesan'] = "Pemanggilan no. antrian ".$pasienMasukPenunjang->no_urutperiksa." dibatalkan !";
                            }
                        }else{
                            $data['pesan'] = "No. antrian ".$pasienMasukPenunjang->no_urutperiksa." sudah dipanggil sebelumnya !";
                        }
                    }else{
                        $pasienMasukPenunjang->panggilantrian = true;
                        if($pasienMasukPenunjang->update()){
                            $data['pesan'] = "No. antrian ".$pasienMasukPenunjang->no_urutperiksa." dipanggil !";
              // $data_telnet = $pasienMasukPenunjang->ruangan->ruangan_nama.", ".$pasienMasukPenunjang->ruangan->ruangan_singkatan."-".$pasienMasukPenunjang->no_urutperiksa;
//              AKAN DIGANTI MENGGUNAKAN NODE JS
                // self::postTelnet($data_telnet);
                        }
                    }
                }

                $attributes = $pasienMasukPenunjang->attributeNames();
                foreach($attributes as $i=>$attribute) {
                    $data["$attribute"] = $pasienMasukPenunjang->$attribute;
                }
                echo CJSON::encode($data);
                Yii::app()->end();
            }
            else
                throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
        }

        public function actionGetAntrianTerakhir(){
            if(Yii::app()->request->isAjaxRequest)
            {

                $data['pesan'] = "";
                $criteria=new CDbCriteria;
                $criteria->addCondition('panggilantrian != TRUE');
                $criteria->addCondition('date(tglmasukpenunjang) BETWEEN \''.date('d M Y').'\' AND \''.date('d M Y').'\'');
                $criteria->order = 'no_urutperiksa ASC';

                $model = BSMasukPenunjangV::model()->find($criteria);
                if(count($model)>0){
                  $data['pasienmasukpenunjang_id'] = $model->pasienmasukpenunjang_id;
                  $data['ruangan_singkatan'] = $model->ruangan_singkatan;
                  $data['no_urutperiksa'] = $model->no_urutperiksa;
                  $data['ruangan_id'] = $model->ruangan_id;
                }else{
                  $data['pesan'] = "Tidak ada antrian!";
                }
                echo CJSON::encode($data);
                Yii::app()->end();
            }
            else
                throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
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
				$persenjual = $this->persenJualRuangan();
				$modObatAlkes->hargajual = floor(($persenjual + 100 ) / 100 * $modObatAlkes->hargajual);

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
		
		public function actionAddFormPemakaianAlat()
		{
			if (Yii::app()->request->isAjaxRequest)
			{
				$idAlat = $_POST['idAlat'];
				$idDaftartindakan = $_POST['idDaftartindakan'];
				$modAlat = AlatmedisM::model()->findByPk($idAlat);
				$modDaftartindakan = DaftartindakanM::model()->findByPk($idDaftartindakan);
				$modObatAlkes = new ObatalkesM;
				echo CJSON::encode(array(
					'namaAlat'=>$modAlat->alatmedis_nama,
					'form'=>$this->renderPartial('_formAddPemakaianAlat', array('modAlat'=>$modAlat,'modDaftartindakan'=>$modDaftartindakan,'modObatAlkes'=>$modObatAlkes
						), true),
					));
				exit;               
			}
		}
		
		public function actionAddFormPaketBmhp()
		{
			if (Yii::app()->request->isAjaxRequest)
			{
				$idKelUmur = (isset($_POST['idKelUmur']) ? $_POST['idKelUmur'] : null);
				$id = (isset($_POST['id']) ? $_POST['id'] : null);
				$idDaftarTindakan = (isset($_POST['idDaftarTindakan']) ? $_POST['idDaftarTindakan'] : null);            
				$modPaketBmhp = PaketbmhpM::model()->with('daftartindakan','obatalkes')->findAllByAttributes(array('daftartindakan_id'=>$idDaftarTindakan,
																			'kelompokumur_id'=>$idKelUmur,));
                $modPasienPenunjang = $this->loadByPasienMasukPenunjang($id);
				$modPendaftaran = PendaftaranT::model()->findByPk($modPasienPenunjang->pendaftaran_id);

				echo CJSON::encode(array(
					'form'=>$this->renderPartial('_formAddPaketBmhp', array('modPaketBmhp'=>$modPaketBmhp,'modPendaftaran'=>$modPendaftaran,
						), true),
					));
				exit;               
			}
		}
		
		public function actionSelesaiOperasi($pasienmasukpenunjang_id)
		{
			$this->layout='//layouts/iframe';
			$operasiselesai = false;
			$modRencanaOperasi = BSRencanaOperasiT::model()->findAllByAttributes(array('pasienmasukpenunjang_id'=>$pasienmasukpenunjang_id));
			
			if(isset($_POST['BSRencanaOperasiT']))
			{
				$format = new MyFormatter();
				$transaction = Yii::app()->db->beginTransaction();
				try {
					
					if(count($modRencanaOperasi) > 0){
						foreach($modRencanaOperasi as $i => $value){
							$modRencanaOperasi[$i]->selesaioperasi = $_POST['BSRencanaOperasiT']['selesaioperasi'];
							$modRencanaOperasi[$i]->statusoperasi = $_POST['statusoperasi'];
							if($modRencanaOperasi[$i]->validate()){
								$modRencanaOperasi[$i]->update();
								$operasiselesai = true;
							}
						}
					}
					
					if($operasiselesai)
					{
						$transaction->commit();
						Yii::app()->user->setFlash('success',"Data berhasil disimpan");     
					}else{
						$transaction->rollback();
						Yii::app()->user->setFlash('error',"Data gagal disimpan");               
					}
				}catch(Exception $exc) {
					$transaction->rollback();
					Yii::app()->user->setFlash('error',"Data gagal disimpan");
				}

			}
			$this->render('_formSelesaiOperasi',array('modRencanaOperasi'=>$modRencanaOperasi,'sukses'=>1));
		}
		
		// copas dari ActionDynamicController
		public function actionGetTypeAnastesi($encode=false,$namaModel='',$attr='')
		{
			if(Yii::app()->request->isAjaxRequest) {
				if($namaModel !=='' && $attr == ''){
					$anastesi_id = $_POST["$namaModel"]['anastesi_id'];
				}
				 elseif ($namaModel == '' && $attr !== '') {
					$anastesi_id = $_POST["$attr"];
				}
				 elseif ($namaModel !== '' && $attr !== '') {
					$anastesi_id = $_POST["$namaModel"]["$attr"];
				}
				if (!empty($anastesi_id)){
					$typeanastesi = TypeAnastesiM::model()->findAllByAttributes(array('typeanastesi_id'=>$anastesi_id),array('order'=>'typeanastesi_nama'));
				}else{
					$typeanastesi = TypeAnastesiM::model()->findAll();
				}
				$typeanastesi = CHtml::listData($typeanastesi,'typeanastesi_id','typeanastesi_nama');

				if($encode){
					echo CJSON::encode($typeanastesi);
				} else {
					if(empty($typeanastesi)){
						echo CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
					}else{
						echo CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
						foreach($typeanastesi as $value=>$name)
						{
							echo CHtml::tag('option', array('value'=>$value),CHtml::encode($name),true);
						}
					}
				}
			}
			Yii::app()->end();
		}
        	
}