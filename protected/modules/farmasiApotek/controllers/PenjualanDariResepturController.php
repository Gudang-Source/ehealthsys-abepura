<?php
Yii::import('farmasiApotek.controllers.PenjualanResepRSController');
class PenjualanDariResepturController extends PenjualanResepRSController
{
	public $obatalkespasientersimpan = true;
	public $is_trracikan = false;
	public $ada_penjualan = false;
    public function actionIndex($reseptur_id=null,$penjualanresep_id=null)
    {
		$modReseptur = FAResepturT::model()->findByPk($reseptur_id);
		$modDetailReseptur = FAResepturDetailT::model()->findAllByAttributes(array('reseptur_id'=>$reseptur_id), array('order'=>'rke ASC, resepturdetail_id ASC'));
		$ruangan_id = Yii::app()->user->getState('ruangan_id');
		$instalasi_id = $modReseptur->ruanganreseptur->instalasi_id;
		// load obatalkes_m, ambil data harga. untuk detailreseptur yang baru
		foreach($modDetailReseptur as $ii => $detail){
			$modOA = FAObatalkesM::model()->findByPk($detail->obatalkes_id);
			$modDetailReseptur[$ii]->hargasatuan_reseptur = !empty($modDetailReseptur[$ii]->hargasatuan_reseptur)?$modDetailReseptur[$ii]->hargasatuan_reseptur:0;
			$modDetailReseptur[$ii]->hargajual_reseptur = $modOA->hargajual;
			$modDetailReseptur[$ii]->harganetto_reseptur = $modOA->harganetto;
			$modDetailReseptur[$ii]->jasadokterresep = $modOA->jasadokter;
			$modDetailReseptur[$ii]->discount = $modOA->discount;
			$modDetailReseptur[$ii]->iurbiaya = $modDetailReseptur[$ii]->hargasatuan_reseptur * $modDetailReseptur[$ii]->qty_reseptur;
			$ruangan_id = Yii::app()->user->getState('ruangan_id');
                        $modStokOAs = StokobatalkesT::getStokObatAlkesAktif($modDetailReseptur[$ii]->obatalkes_id, $modDetailReseptur[$ii]->qty_reseptur, $ruangan_id);
//			foreach($modStokOAs AS $i => $stok){
//				$modDetailReseptur[$ii]->stokobatalkes_id = $stok->stokobatalkes_id;
//			}
		}
		
		$modInfoRI = new FAInfopasienmasukkamarV;
		$modPendaftaran = FAPendaftaranT::model()->findByPk($modReseptur->pendaftaran_id);
		$modObatAlkesPasien = new FAObatalkesPasienT();
		
		// load penjualan resep berdasarkan reseptur_id (bisa ada data bisa juga tidak)
		$modPenjualan =  FAPenjualanResepT::model()->findByAttributes(array('reseptur_id'=>$reseptur_id));
		if (!empty($modPenjualan->tglpenjualan)) $modPenjualan->tglpenjualan = MyFormatter::formatDateTimeForUser($modPenjualan->tglpenjualan);
                if (!empty($modPenjualan->tglresep)) $modPenjualan->tglresep = MyFormatter::formatDateTimeForUser($modPenjualan->tglresep);
                // var_dump($modPenjualan->attributes); die;
                if(count($modPenjualan)>0){
			$this->ada_penjualan = true;
		}else{
			$modPenjualan = new FAPenjualanResepT;
			$modPenjualan->tglpenjualan = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($modPenjualan->tglpenjualan, 'yyyy-MM-dd hh:mm:ss','medium',null)); 
			$modPenjualan->tglresep = MyFormatter::formatDateTimeForUser($modReseptur->tglreseptur);
			$modPenjualan->noresep = MyGenerator::noResep($instalasi_id);
			$modPenjualan->pegawai_id = $modReseptur->pegawai_id;
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
			$modPenjualan->iter = $modDetailReseptur[0]->iter;
		}
		
		if($this->ada_penjualan){
			if(!empty($penjualanresep_id)){
				$modPenjualan = FAPenjualanResepT::model()->findByPk($penjualanresep_id);
			}
//            $modPenjualan = FAPenjualanResepT::model()->findByPk($modPenjualan->penjualanresep_id);
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
		
//		$modPenjualan->noresep = MyGenerator::noResep($instalasi_id);
		$modPenjualan->noresep = "-Otomatis-";
		
		$transaction = Yii::app()->db->beginTransaction();
		if(isset($_POST['FAResepturDetailT'])){
			$modPenjualan = $this->savePenjualanResepRS($modPendaftaran,$_POST['FAPenjualanResepT'],$modReseptur);
			$modPendaftaran = $modReseptur->pendaftaran;
                        $isP = $modPendaftaran->carabayar_id == Params::CARABAYAR_ID_MEMBAYAR && empty($modPendaftaran->pasienpulang_id) && $modPendaftaran->instalasi_id == Params::INSTALASI_ID_RJ;
                        
                        if($this->penjualantersimpan){
				if(count($_POST['FAResepturDetailT']) > 0){
                    //PROSES GROUP DETAIL BERDASARKAN obatalkes_id & akumulasikan jmlmutasi
                    $detailGroups = array();
                    foreach($_POST['FAResepturDetailT'] AS $i => $postDetail){
                        $modDetails[$i] = new FAObatalkesPasienT;
                        $modDetails[$i]->attributes = $postDetail;
                        $modDetails[$i]->penjualanresep_id = $modPenjualan->penjualanresep_id;
                        $modDetails[$i]->tipepaket_id = Params::TIPEPAKET_ID_NONPAKET;
                        $modDetails[$i]->ruangan_id = Yii::app()->user->getState('ruangan_id');
                        $modDetails[$i]->shift_id = Yii::app()->user->getState('shift_id');
                        $modDetails[$i]->pendaftaran_id = $modPenjualan->pendaftaran_id;
                        $modDetails[$i]->pasien_id = $modPenjualan->pasien_id;
                        $modDetails[$i]->carabayar_id = $modPenjualan->carabayar_id;
                        $modDetails[$i]->penjamin_id = $modPenjualan->penjamin_id;
                        $modDetails[$i]->pegawai_id = $modPenjualan->pegawai_id;
                        $modDetails[$i]->tglpelayanan = date("Y-m-d H:i:s");
                        $modDetails[$i]->r = "R/";
                        $modDetails[$i]->qty_oa = $postDetail['qty_dilayani'];
			$modDetails[$i]->hargajual_oa = $postDetail['hargajual_reseptur'];
			$modDetails[$i]->harganetto_oa = $postDetail['harganetto_reseptur'];
			$modDetails[$i]->hargasatuan_oa = $postDetail['hargasatuan_reseptur'];
                        $modDetails[$i]->signa_oa = $postDetail['signa_reseptur'];
			$modDetails[$i]->create_time = date("Y-m-d H:i:s");
			$modDetails[$i]->create_loginpemakai_id = Yii::app()->user->id;
			$modDetails[$i]->create_ruangan = Yii::app()->user->getState('ruangan_id');
                        $modDetails[$i]->kelaspelayanan_id = $modPenjualan->kelaspelayanan_id;
                        $modDetails[$i]->pasienadmisi_id = $modPenjualan->pasienadmisi_id;
                        //var_dump($postDetail);
                        // var_dump($modDetails[$i]->attributes); die;
                        //var_dump($modDetails[$i]->attributes);
                        if ($modDetails[$i]->validate()) {
                            $this->obatalkespasientersimpan &= $modDetails[$i]->save();
                        } else {
                            $this->obatalkespasientersimpan &= false;
                        }
                        
                        if (!$isP) {
                            $this->simpanStokObatAlkesOut2($modDetails[$i]);
                        }
                        
                        //var_dump($modDetails[$i]->errors);
                        
                        
                        
                        //$modStok = StokobatalkesT::model()->findByPk($postDetail['stokobatalkes_id']);
//                        $modDetails[$i]->stokobatalkes_id = $modStok->stokobatalkes_id;
                        /*
                        $obatalkes_id = $postDetail['obatalkes_id'];
                        if(isset($detailGroups[$obatalkes_id])){
                            $detailGroups[$obatalkes_id]['qty_oa'] += $postDetail['qty_dilayani'];
                        }else{
                            $detailGroups[$obatalkes_id]['obatalkes_id'] = $postDetail['obatalkes_id'];
                            $detailGroups[$obatalkes_id]['qty_oa'] = $postDetail['qty_dilayani'];
                        }
                         * 
                         */	
                    }
                    //END GROUP
                }

                //$obathabis = "";
                //PROSES PENGURAIAN OBAT DAN JUMLAH MENJADI STOKOBATALKES_T (METODE ANTRIAN)
				$ii = 0;
                /*
                foreach($detailGroups AS $i => $detail){
                    $modStokOAs = StokobatalkesT::getStokObatAlkesAktif($detail['obatalkes_id'], $detail['qty_oa'], Yii::app()->user->getState('ruangan_id'));
                    if(count($modStokOAs) > 0){
                        foreach($modStokOAs AS $i => $stok){
							$post_resepturdetail = $_POST['FAResepturDetailT'][$ii];
							if(!empty($post_resepturdetail['obatalkes_id'])){
								$modObatAlkesPasien = new FAObatalkesPasienT();
								$modObatAlkesPasien->attributes = $post_resepturdetail;
								$modObatAlkesPasien->penjualanresep_id = $modPenjualan->penjualanresep_id;
								$modObatAlkesPasien->resepturdetail_id = $post_resepturdetail['resepturdetail_id'];
								$modObatAlkesPasien->tipepaket_id = Params::TIPEPAKET_ID_NONPAKET;
								$modObatAlkesPasien->ruangan_id = Yii::app()->user->getState('ruangan_id');
								$modObatAlkesPasien->carabayar_id = $_POST['carabayar_id'];
								$modObatAlkesPasien->pegawai_id = Yii::app()->user->getState('pegawai_id');
								$modObatAlkesPasien->shift_id = Yii::app()->user->getState('shift_id');
								$modObatAlkesPasien->pendaftaran_id = $_POST['pendaftaran_id'];
								$modObatAlkesPasien->pasien_id = $_POST['pasien_id'];
								$modObatAlkesPasien->penjamin_id = $_POST['penjamin_id'];
								$modObatAlkesPasien->kelaspelayanan_id = $_POST['kelaspelayanan_id'];
								$modObatAlkesPasien->pasienadmisi_id = $_POST['pasienadmisi_id'];
								$modObatAlkesPasien->tglpelayanan = date("Y-m-d H:i:s");
								$modObatAlkesPasien->r = "R/";
								$modObatAlkesPasien->qty_oa = $post_resepturdetail['qty_dilayani'];
								$modObatAlkesPasien->hargajual_oa = $post_resepturdetail['hargajual_reseptur'];
								$modObatAlkesPasien->harganetto_oa = $post_resepturdetail['harganetto_reseptur'];
								$modObatAlkesPasien->hargasatuan_oa = $post_resepturdetail['hargasatuan_reseptur'];
								$modObatAlkesPasien->signa_oa = $post_resepturdetail['signa_reseptur'];
								$modObatAlkesPasien->create_time = date("Y-m-d H:i:s");
								$modObatAlkesPasien->create_loginpemakai_id = Yii::app()->user->id;
								$modObatAlkesPasien->create_ruangan = Yii::app()->user->getState('ruangan_id');
								if($modObatAlkesPasien->validate()){
									if($modObatAlkesPasien->save()){
										$this->obatalkespasientersimpan &= true;
									}else{
										$this->obatalkespasientersimpan &= false;
									}
								}
							}
                            $this->simpanStokObatAlkesOut($stok['stokobatalkes_id'], $modObatAlkesPasien);
                        }
                    }else{
                        $this->stokobatalkestersimpan &= false;
                        $obathabis .= "<br>- ".ObatalkesM::model()->findByPk($detail['obatalkes_id'])->obatalkes_nama;
                        
                    }
					$ii++;
                }
                 * 
                 */
                                
                                $this->broadcastPenjualanKeKasir($modPenjualan);
				try{
					if($this->obatalkespasientersimpan&&$this->stokobatalkestersimpan){
						$transaction->commit();
						Yii::app()->user->setFlash('success',"Data Berhasil disimpan !");
						$this->redirect(array('index','reseptur_id'=>$reseptur_id,'penjualanresep_id'=>$modPenjualan->penjualanresep_id, 'sukses'=>1));
					}else{
						$transaction->rollback();
						Yii::app()->user->setFlash('error',"Data gagal disimpan 1!");
					}
				}catch (Exception $e) {
					$transaction->rollback();
					Yii::app()->user->setFlash('error',"Data gagal disimpan 2! ".MyExceptionMessage::getMessage($e,true));
				}
			
			}
			
		}
		
		 $this->render('index',array(
						'modReseptur'=>$modReseptur,
						'modDetailReseptur'=>$modDetailReseptur,
						'modInfoRI'=>$modInfoRI,
						'modPenjualan'=>$modPenjualan,
						'modObatAlkesPasien'=>$modObatAlkesPasien,
						'instalasi_id'=>$instalasi_id
						));
	}
        
	public function actionSetObatAlkesPasien()
    {
        if(Yii::app()->request->isAjaxRequest) { 
            $obatalkes_id = $_POST['obatalkes_id'];
            $jumlah = $_POST['jumlah'];
			$therapiobat_id = isset($_POST['therapiobat_id'])?$_POST['therapiobat_id']:null;
            $form = "";
            $pesan = "";
            $format = new MyFormatter();
            $modObatAlkesPasien = new FAObatalkesPasienT;
			$otherdata = array();
            $ruangan_id = Yii::app()->user->getState('ruangan_id');
            $modStokOAs = StokobatalkesT::getStokObatAlkesAktif($obatalkes_id, $jumlah, $ruangan_id);
            $oa = ObatalkesM::model()->findByPk($obatalkes_id);
            $otherdata = array();
            //if(count($modStokOAs) > 0){

                //foreach($modStokOAs AS $i => $stok){
                    $modObatAlkesPasien->sumberdana_id = $oa->sumberdana_id; //(isset($stok->penerimaandetail->sumberdana_id) ? $stok->penerimaandetail->sumberdana_id : $stok->obatalkes->sumberdana_id);
                    $modObatAlkesPasien->obatalkes_id = $oa->obatalkes_id; //$stok->obatalkes_id;
                    $modObatAlkesPasien->qty_oa = $jumlah; //$stok->qtystok_terpakai;
                    $modObatAlkesPasien->harganetto_oa = $oa->harganetto; //$stok->HPP;
                    $modObatAlkesPasien->hargasatuan_oa = $oa->hargajual; //$stok->HargaJualSatuan;
                    $modObatAlkesPasien->jmlstok = 0; //$stok->qtystok;
                    $modObatAlkesPasien->r = 'R/';
                    $modObatAlkesPasien->hargajual_oa = $modObatAlkesPasien->qty_oa * $modObatAlkesPasien->hargasatuan_oa;
                    $modObatAlkesPasien->stokobatalkes_id = null; //$stok->stokobatalkes_id;
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
					//$otherdata['stok'] = $stok->qtystok;
					//$otherdata['stokobatalkes_id'] = $stok->stokobatalkes_id;
                //}
            //}else{
            //    $pesan = "Stok tidak mencukupi!";
            //}
            
            echo CJSON::encode(array('modObatAlkesPasien'=>$modObatAlkesPasien, 'pesan'=>$pesan,'otherdata'=>$otherdata));
            Yii::app()->end(); 
        }
    }
	
	public function actionPrintResepDokter()
	{
		$reseptur_id = $_GET['id'];
		$modReseptur = FAResepturT::model()->findByPk($reseptur_id);
		$pendaftaran_id = $modReseptur->pendaftaran_id;
		$criteria=new CDbCriteria;
		$criteria->addCondition("create_time=(select max(create_time) from reseptur_t)");
		$maxtime = FAResepturT::model()->find($criteria);
		$modDetailResep = ResepturdetailT::model()->findAllByAttributes(array('reseptur_id'=>$maxtime->reseptur_id));
		$modPendaftaran = FAPendaftaranT::model()->with('jeniskasuspenyakit')->findByPk($pendaftaran_id);
		
		$judulLaporan='';
		
		$criteriakl=new CDbCriteria;
		$criteriakl->addCondition("reseptur_id = ". $reseptur_id);
		$criteriakl->select = 'racikan_id, rke, iter, reseptur_id';
		$criteriakl->group = 'racikan_id, rke, iter, reseptur_id';
		$criteriakl->order = 'rke';
		$kerangkaLooping = ResepturdetailT::model()->findAll($criteriakl);

		$caraPrint=$_REQUEST['caraPrint'];
		If(isset($_GET['idReseptur'])){
			$modDetailResep = ResepturdetailT::model()->findAllByAttributes(array('reseptur_id'=>$_GET['idReseptur']));
			if($caraPrint=='PRINT') {
				$this->layout='//layouts/printWindows';
				$this->render('_viewDetailResep',array('modPendaftaran'=>$modPendaftaran,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint,'modDetailResep'=>$modDetailResep));
			}
		}else{
			if($caraPrint=='PRINT') {
				$this->layout='//layouts/printWindows';
				$this->render('Print',array(
													'modPendaftaran'=>$modPendaftaran,
													'judulLaporan'=>$judulLaporan,
													'caraPrint'=>$caraPrint,
													"modDetailResep"=>$modDetailResep,
													'modReseptur'=>$modReseptur,
													'kerangkaLooping'=>$kerangkaLooping
														));
			}
		}
	}
	
	public function actionCopyResep($penjualanresep_id,$pasien_id,$sukses=null)
	{
            $this->layout='//layouts/iframe';     
            $modObatAlkesPasien = array();
			
			$model = FACopyResepR::model()->findByAttributes(array('penjualanresep_id'=>$penjualanresep_id));
			if(count($model)==0){
				$model = new FACopyResepR();
			}
             $tersimpan = 'Tidak';
             
             $modelPenjualanResep = FAPenjualanResepT::model()->findByPk($penjualanresep_id);
             $modObatAlkesPasien = FAObatalkesPasienT::model()->findAllByAttributes(array('penjualanresep_id'=>$penjualanresep_id, 'pasien_id'=>$pasien_id));
             $modPasien = FAPasienM::model()->findByPk($pasien_id);
			 $modDetailReseptur = FAResepturDetailT::model()->findAllByAttributes(array('reseptur_id'=>$modelPenjualanResep->reseptur_id), array('order'=>'rke ASC'));
             $modCopy = CopyresepR::model()->findAll('penjualanresep_id='.$penjualanresep_id.' order by copyresep_id desc limit 1');
			 
             foreach($modCopy as $i=>$data){
                 $copy = $data->jmlcopy;
                 $penjualanresep = $data->penjualanresep_id;
                 $copyresep = $data->copyresep_id;
             }
             if(isset($_POST['FACopyResepR'])){
                 if($modCopy == null){
                     $copy = 1;
                        $jmlCopy = $copy;
                        $model->attributes = $_POST['FACopyResepR'];
                        $model->tglcopy = date('Y-m-d');
                        $model->penjualanresep_id = $_POST['FAPenjualanResepT']['penjualanresep_id'];
                        $model->keterangancopy = $_POST['FACopyResepR']['keterangancopy'];
                        $model->jmlcopy = $jmlCopy;
                        $model->create_time = date('Y-m-d');
                        $model->update_time = date('Y-m-d');
                        $model->create_loginpemakai_id = Yii::app()->user->id;
                        $model->update_loginpemakai_id = Yii::app()->user->id;
                        $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
                        if(!empty($modelPenjualanResep->reseptur_id)){
                            $model->reseptur_id = $modelPenjualanResep->reseptur_id;
                        }else{
                            $model->reseptur_id = null;
                        }
                 }else{
                    $copy = $copy + 1;
                 }          
                 
                $penjualanresep = (isset($penjualanresep) ? $penjualanresep : null);   
                if($penjualanresep == $penjualanresep_id){
                    $update = CopyresepR::model()->UpdateAll(array(
                                                        'jmlcopy' =>$copy,
                                                        'tglcopy'=>date('Y-m-d'),
                                                        'keterangancopy' => $_POST['FACopyResepR']['keterangancopy'],
                                                        'create_time'=>date('Y-m-d'),
                                                        'update_time'=>date('Y-m-d'),
                                                        'create_loginpemakai_id'=>Yii::app()->user->id,
                                                        'update_loginpemakai_id'=>Yii::app()->user->id,
                                                        'create_ruangan'=>Yii::app()->user->getState('ruangan_id')
                    ),'penjualanresep_id=:penjualanresep_id and copyresep_id=:copyresep_id',array(':penjualanresep_id'=>$_POST['FAPenjualanResepT']['penjualanresep_id'],':copyresep_id'=>$copyresep));

                    if($update){
                        Yii::app()->user->setFlash('success',"Data berhasil disimpan");
						$tersimpan='Ya';
						$model = FACopyResepR::model()->findByAttributes(array('penjualanresep_id'=>$penjualanresep_id));
                    }else{
//                            $transaction->rollback();
                        Yii::app()->user->setFlash('error',"Data gagal disimpan");  
                    }

                }else{
                     if($model->save()){
                        Yii::app()->user->setFlash('success',"Data berhasil disimpan");
                        $tersimpan='Ya';
                    }else{
                        $transaction->rollback();
                        Yii::app()->user->setFlash('error',"Data gagal disimpan"); 
                    }
                }
             }
			 
             $model->tglcopy = Yii::app()->dateFormatter->formatDateTime(
                                        CDateTimeParser::parse($model->tglcopy, 'yyyy-MM-dd'));
             
             $this->render('formCopyResep',array(
                                'modelPenjualanResep'=>$modelPenjualanResep,
                                'modPasien'=>$modPasien,
                                'model'=>$model,
                                'modCopy'=>$modCopy,
                                'modObatAlkesPasien'=>$modObatAlkesPasien,
                                'tersimpan'=>$tersimpan,
								'modDetailReseptur'=>$modDetailReseptur
                          ));
	}
	
	public function actionPrintCopyResep($idPenjualanResep)
	{
			
			$modPenjualan = FAPenjualanResepT::model()->findByPk($idPenjualanResep);
			$reseptur_id = $modPenjualan->reseptur_id;
			$modReseptur = FAResepturT::model()->findByPk($reseptur_id);
			$pendaftaran_id = $modPenjualan->pendaftaran_id;
			$modPendaftaran = FAPendaftaranT::model()->with('jeniskasuspenyakit')->findByPk($pendaftaran_id);
			$modDetailResep = FAResepturDetailT::model()->findAllByAttributes(array('reseptur_id'=>$reseptur_id), array('order'=>'rke ASC, resepturdetail_id ASC'));
			
			$criteria=new CDbCriteria;
			$criteria->addCondition("resepturdetail_id IS NOT NULL");
			$criteria->addCondition("penjualanresep_id = ".$modPenjualan->penjualanresep_id);
			$criteria->order = "resepturdetail_id ASC";
			$modObatAlkes = FAObatalkesPasienT::model()->findAll($criteria);
			
			$judulLaporan='';
			
			$criteriakeliter=new CDbCriteria;
			$criteriakeliter->addCondition("reseptur_id = ". $reseptur_id);
			$criteriakeliter->select = 'iter';
			$criteriakeliter->group = 'iter';
			$criteriakeliter->order = 'iter DESC';
			$kelompokiter = ResepturdetailT::model()->findAll($criteriakeliter);
			
			$caraPrint = $_REQUEST['caraPrint'];
			
			if ($caraPrint == 'PRINT') {
				$this->layout='//layouts/printWindows';
			} else if ($caraPrint == 'EXCEL') {
				$this->layout = '//layouts/printExcel';
			} else if ($caraPrint == 'PDF') {
				$ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
				$posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
				$mpdf = new MyPDF('', $ukuranKertasPDF);
				$mpdf->useOddEven = 2;
				$stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
				$mpdf->WriteHTML($stylesheet, 1);
				$mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
				$mpdf->WriteHTML($this->renderPartial('PrintCopyResep',array(
												'modPendaftaran'=>$modPendaftaran,
												'judulLaporan'=>$judulLaporan,
												"modDetailResep"=>$modDetailResep,
												'modReseptur'=>$modReseptur,
												'modPenjualan'=>$modPenjualan,
												'modObatAlkes'=>$modObatAlkes,
												'kelompokiter'=>$kelompokiter,
												'caraPrint'=>$caraPrint
												), true));
				$mpdf->Output();exit;
			}
			$this->render('PrintCopyResep',array(
												'modPendaftaran'=>$modPendaftaran,
												'judulLaporan'=>$judulLaporan,
												"modDetailResep"=>$modDetailResep,
												'modReseptur'=>$modReseptur,
												'modPenjualan'=>$modPenjualan,
												'modObatAlkes'=>$modObatAlkes,
												'kelompokiter'=>$kelompokiter,
												'caraPrint'=>$caraPrint
												));
	}
	
	protected function printFunction($model, $data, $caraPrint, $judulLaporan, $target){
        $format = new MyFormatter();
        $periode = $format->formatDateTimeForUser($model->tgl_awal).' s/d '.$format->formatDateTimeForUser($model->tgl_akhir);
        if ($caraPrint == 'PRINT' || $caraPrint == 'GRAFIK') {
            $this->layout = '//layouts/printWindows';
            $this->render($target, array('model' => $model, 'periode'=>$periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
        } else if ($caraPrint == 'EXCEL') {
            $this->layout = '//layouts/printExcel';
            $this->render($target, array('model' => $model, 'periode'=>$periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
        } else if ($_REQUEST['caraPrint'] == 'PDF') {
            $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
            $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
            $mpdf = new MyPDF('', $ukuranKertasPDF);
            $mpdf->useOddEven = 2;
            $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
            $mpdf->WriteHTML($stylesheet, 1);
            $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
            $mpdf->WriteHTML($this->renderPartial($target, array('model' => $model, 'periode'=>$periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
            $mpdf->Output();
        }
    }
	
	public function GetJumlahDilayani($resepturdetail_id){
		$return = 0;
		$modObatAlkesPasiens = FAObatalkesPasienT::model()->findAllByAttributes(array('resepturdetail_id'=>$resepturdetail_id));
		foreach($modObatAlkesPasiens as $i => $modObatAlkesPasien){
			$return += $modObatAlkesPasien->qty_oa;
		}
		return $return;
	}
	
	protected function savePenjualanResepRS($modPendaftaran,$penjualanResep,$modReseptur=null)
	{
                //var_dump($modReseptur->attributes);
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
		$modPenjualan->tglresep = !empty($modReseptur)?$format->formatDateTimeForDb($modReseptur->tglreseptur):date('Y-m-d H:i:s');
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
		$modPenjualan->noresep = !empty($modReseptur)?$modReseptur->noresep:MyGenerator::noResep($_POST['instalasi_id']);
		$modPenjualan->subsidiasuransi = 0;
		$modPenjualan->subsidipemerintah = 0;
		$modPenjualan->subsidirs = 0;
		$modPenjualan->iurbiaya = 0;
		$modPenjualan->discount = 0; 
		$modPenjualan->create_time = date("Y-m-d H:i:s");
		$modPenjualan->create_loginpemakai_id = Yii::app()->user->id;
		$modPenjualan->create_ruangan = Yii::app()->user->getState('ruangan_id');
		
                // var_dump($modPenjualan->attributes);
                
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
	 * menghitung proporsi obat
	 */
	public function actionSetProporsiTakaranResep(){
		if(Yii::app()->getRequest()->getIsAjaxRequest()) {
			$takaran = $_POST['takaran'];
			parse_str($_POST['data'], $dataOAs);
			$data['pesan'] = '';
			//PROSES GROUP DETAIL BERDASARKAN obatalkes_id & akumulasikan jml jika obat sama
			$detailGroups = array();
			foreach($dataOAs['FAResepturDetailT'] AS $i => $postDetail){
				$obatalkes_id = $postDetail['obatalkes_id'];
				if(isset($detailGroups[$obatalkes_id])){
					$detailGroups[$obatalkes_id]['qty_reseptur'] += $postDetail['qty_reseptur'];
				}else{
					$detailGroups[$obatalkes_id] = $postDetail;
					$detailGroups[$obatalkes_id]['qty_reseptur'] = $postDetail['qty_reseptur'];
				}
			}
			//END GROUP
			//PROSES PENGURAIAN OBAT DAN JUMLAH MENJADI STOKOBATALKES_T (METODE ANTRIAN)
			$form= "";
			foreach($detailGroups AS $i => $detail){
				$qtyoa = round(($detail['qty_reseptur'] * $takaran), 2);
				$modStokOAs = StokobatalkesT::getStokObatAlkesAktif($detail['obatalkes_id'], $qtyoa, Yii::app()->user->getState('ruangan_id'));
				if(count($modStokOAs) > 0){
					foreach($modStokOAs AS $i => $stok){ //copy dari function actionSetFormObatAlkesPasien
						$modResepturDetail = new FAResepturDetailT();
						$modResepturDetail->attributes = $detail;
						$modResepturDetail->jmlstok = $stok->qtystok;
						$modResepturDetail->qty_dilayani = ceil($qtyoa);
						$form .= $this->renderPartial('_rowDetail', array('modResepturDetail'=> $modResepturDetail,'takaranresep'=>true), true);
					}
				}else{
					$data['pesan'] .= 'Jumlah Stok '.$detail['obatalkes_nama'].' tidak mencukupi.<br>';
				}
			}
			$data['form'] = $form;
			echo json_encode($data);
		}
		Yii::app()->end();
	}
	
}