<?php

class TindakanController extends MyAuthController
{
    public $layout='//layouts/iframe';
    public $defaultAction = 'index';
    public $succesSave = false;
    protected $successSaveBmhp = true;
    protected $successSavePemakaianBahan = true;
    protected $stokobatalkestersimpan = true;
    protected $path_view = 'rawatJalan.views.tindakan.';
	
	public function actionIndex($pendaftaran_id)
	{
            $ruangan_id = isset($_GET['ruangan_id']) ? $_GET['ruangan_id'] : Yii::app()->user->getState('ruangan_id'); //RND-6244
            $modPendaftaran = RJPendaftaranT::model()->with('jeniskasuspenyakit')->findByPk($pendaftaran_id);
            
            $konsul = ($modPendaftaran->ruangan_id == Yii::app()->user->getState('ruangan_id'))?null:KonsulpoliT::model()->findByAttributes(array(
                'pendaftaran_id'=>$modPendaftaran->pendaftaran_id,
                'ruangan_id'=>Yii::app()->user->getState('ruangan_id'),
            ), array(
                'order'=>'tglkonsulpoli desc',
            ));
            
            if (!empty($konsul)) {
                $modPendaftaran->pegawai_id = $konsul->pegawai_id;
                $modPendaftaran->ruangan_id = $konsul->ruangan_id;
            }
            
            $modPasien = RJPasienM::model()->findByPk($modPendaftaran->pasien_id);
            $modViewTindakans = RJTindakanPelayananT::model()
                                ->with('daftartindakan','dokter1','dokter2','dokterPendamping','dokterAnastesi',
                                       'dokterDelegasi','bidan','suster','perawat','tipePaket')
                                ->findAllByAttributes(array('pendaftaran_id'=>$pendaftaran_id, 'ruangan_id'=>$ruangan_id));
            $modTindakans = null;
            $modTindakan = new RJTindakanPelayananT;
            $modTindakan->tarifcyto_tindakan = 0;
            $modTindakan->dokterpemeriksa1_id = $modPendaftaran->pegawai_id;
            $modTindakan->dokterpemeriksa1Nama = $modPendaftaran->pegawai->NamaLengkap;
           
            $modJenisTarif = JenistarifpenjaminM::model()->find('penjamin_id = '.$modPendaftaran->penjamin_id);
            $models= new RJPaketpelayananV();
            
            if(isset($_POST['RJTindakanPelayananT']) || isset($_POST['TindakanpelayananT']))
            {
//                $post = (isset($_POST['TindakanpelayananT'])) ? $_POST['TindakanpelayananT'] : $_POST['RJTindakanPelayananT'];
//                echo '<pre>'.print_r($post,1).'</pre>'; exit;
                $modTindakans = $this->saveTindakan($modPasien, $modPendaftaran);
               
                if($this->succesSave)
                    $this->redirect(array($this->id.'/','pendaftaran_id'=>$pendaftaran_id));
            }
                        
            $modViewBmhp = RJObatalkesPasienT::model()->with('obatalkes')->findAllByAttributes(array('pendaftaran_id'=>$pendaftaran_id));
            
            $this->render($this->path_view.'index',array('modPendaftaran'=>$modPendaftaran,
                                        'modPasien'=>$modPasien,
                                        'modTindakans'=>$modTindakans,
                                        'modTindakan'=>$modTindakan,
                                        'modViewTindakans'=>$modViewTindakans,
                                        'modViewBmhp'=>$modViewBmhp,'models'=>$models,
                                        'modJenisTarif'=>$modJenisTarif));
	}
        
	public function saveTindakan($modPasien,$modPendaftaran)
	{
		$post = (isset($_POST['TindakanpelayananT'])) ? $_POST['TindakanpelayananT'] : $_POST['RJTindakanPelayananT'];
		$valid=true; //echo $_POST['RJTindakanPelayananT'][0]['tipepaket_id'];exit;
		foreach($post as $i=>$item)
		{
			if(!empty($item) && (!empty($item['daftartindakan_id']))){
				$modTindakans[$i] = new RJTindakanPelayananT;
				$modTindakans[$i]->attributes=$item;
				$modTindakans[$i]->tipepaket_id = $_POST['RJTindakanPelayananT'][0]['tipepaket_id'];
				$modTindakans[$i]->pasien_id = $modPasien->pasien_id;
				$modTindakans[$i]->kelaspelayanan_id = $modPendaftaran->kelaspelayanan_id;
				$modTindakans[$i]->carabayar_id = $modPendaftaran->carabayar_id;
				$modTindakans[$i]->penjamin_id = $modPendaftaran->penjamin_id;
				$modTindakans[$i]->jeniskasuspenyakit_id = $modPendaftaran->jeniskasuspenyakit_id;
				$modTindakans[$i]->pendaftaran_id = $modPendaftaran->pendaftaran_id;
				$modTindakans[$i]->keterangantindakan = $item['keterangantindakan'];
//                    $modTindakans[$i]->tgl_tindakan = $item['tgl_tindakan'];
				$modTindakans[$i]->tgl_tindakan = $modTindakans[0]->tgl_tindakan;
				$modTindakans[$i]->shift_id = Yii::app()->user->getState('shift_id');
				$modTindakans[$i]->tarif_satuan = $modTindakans[$i]->getTarifSatuan(); //RND-7250
				$modTindakans[$i]->tarif_tindakan = $modTindakans[$i]->tarif_satuan * $modTindakans[$i]->qty_tindakan;
				if($item['cyto_tindakan'])
					$modTindakans[$i]->tarifcyto_tindakan = ($item['persenCyto'] / 100) * $modTindakans[$i]->tarif_tindakan;
				else
					$modTindakans[$i]->tarifcyto_tindakan = 0;
					$modTindakans[$i]->discount_tindakan = 0;
					$modTindakans[$i]->subsidiasuransi_tindakan = 0;
					$modTindakans[$i]->subsidipemerintah_tindakan = 0;
					$modTindakans[$i]->subsisidirumahsakit_tindakan = 0;
					$modTindakans[$i]->iurbiaya_tindakan = 0;
					$modTindakans[$i]->instalasi_id = $modPendaftaran->instalasi_id;
					$modTindakans[$i]->ruangan_id =  isset($_GET['ruangan_id']) ? $_GET['ruangan_id'] : Yii::app()->user->getState('ruangan_id'); // RND-6244
					$modTindakans[$i]->alatmedis_id = $this->cekAlatmedis($modTindakans[$i]->daftartindakan_id);

				$valid = $modTindakans[$i]->validate() && $valid;

			}
		}

		$transaction = Yii::app()->db->beginTransaction();
		try {
			if($valid && (count($modTindakans) > 0)){
				foreach($modTindakans as $i=>$tindakan){
					if($tindakan->save()){
						$statusSaveKomponen = $tindakan->saveTindakanKomponen();
					}
					if(isset($_POST['paketBmhp'])){
						if(count($_POST['paketBmhp']) > 0){
                        //PROSES GROUP DETAIL BERDASARKAN obatalkes_id & akumulasikan jumlah pesan
							$detailGroups = array();
							foreach($_POST['paketBmhp'] AS $i => $postDetail){
								$modDetails[$i] = new RJObatalkesPasienT();
								$modDetails[$i]->attributes = $postDetail;
                                                                $modDetails[$i] = $this->savePaketBmhp2($modPendaftaran, $postDetail, $tindakan);
                                                                $this->simpanStokObatAlkesOut2($modDetails[$i]);
                                                                
                                                                /*
								$modStok = StokobatalkesT::model()->findByPk($postDetail['stokobatalkes_id']);
								$modDetails[$i]->stokobatalkes_id = $modStok->stokobatalkes_id;
								$obatalkes_id = $postDetail['obatalkes_id'];
								if(isset($detailGroups[$obatalkes_id])){
									$detailGroups[$obatalkes_id]['qtypemakaian'] += $postDetail['qtypemakaian'];
								}else{
									$detailGroups[$obatalkes_id]['obatalkes_id'] = $postDetail['obatalkes_id'];
									$detailGroups[$obatalkes_id]['qtypemakaian'] = $postDetail['qtypemakaian'];
								} */
							}
							//END GROUP
						}
                                                /*
						$obathabis = "";
						//PROSES PENGURAIAN OBAT DAN JUMLAH MENJADI STOKOBATALKES_T (METODE ANTRIAN)
						foreach($detailGroups AS $i => $detail){
							$modStokOAs = StokobatalkesT::getStokObatAlkesAktif($detail['obatalkes_id'], $detail['qtypemakaian'], Yii::app()->user->getState('ruangan_id'));
							if(count($modStokOAs) > 0){
								foreach($modStokOAs AS $i => $stok){
									$modDetails[$i] = $this->savePaketBmhp($modPendaftaran,$stok, $_POST['paketBmhp'],$tindakan);
									$this->simpanStokObatAlkesOut($stok['stokobatalkes_id'], $modDetails[$i]);
								}
							}else{
								$this->stokobatalkestersimpan &= false;
								$obathabis .= "<br>- ".ObatalkesM::model()->findByPk($detail['obatalkes_id'])->obatalkes_nama;

							}
						} */
//						$modObatPasiens = $this->savePaketBmhp($modPendaftaran, $_POST['paketBmhp'],$tindakan);
					}
                                        //var_dump($this->stokobatalkestersimpan);
                                        //die;
					if(isset($_POST['pemakaianBahan'])){
						if(count($_POST['pemakaianBahan']) > 0){
                        //PROSES GROUP DETAIL BERDASARKAN obatalkes_id & akumulasikan jumlah pesan
							$detailGroups = array();
							foreach($_POST['pemakaianBahan'] AS $i => $postDetail){
								$modDetails[$i] = new RJObatalkesPasienT();
								$modDetails[$i]->attributes = $postDetail;
                                                                $modDetails[$i] = $this->savePemakaianBahan2($modPendaftaran, $postDetail, $tindakan);
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
								}*/
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
									$modDetails[$i] = $this->savePemakaianBahan($modPendaftaran,$stok, $_POST['pemakaianBahan'],$tindakan);
									$this->simpanStokObatAlkesOut($stok['stokobatalkes_id'], $modDetails[$i]);
								}
							}else{
								$this->stokobatalkestersimpan &= false;
								$obathabis .= "<br>- ".ObatalkesM::model()->findByPk($detail['obatalkes_id'])->obatalkes_nama;

							}
						}
                                                 * 
                                                 */
//						$modPemakainBahans = $this->savePemakaianBahan($modPendaftaran, $_POST['pemakaianBahan'],$tindakan);
					}
				}
                                //var_dump($this->stokobatalkestersimpan);
                                // die;
				if($statusSaveKomponen && $this->successSaveBmhp && $this->successSavePemakaianBahan && $this->stokobatalkestersimpan) {
					$p = PendaftaranT::model()->findByPk($modPendaftaran->pendaftaran_id);
                                        $updateStatusPeriksa = $p->setStatusPeriksa(Params::STATUSPERIKSA_SEDANG_PERIKSA);
					
                                        /* ================================================ */
					/* Proses update status periksa KonsulPoli EHS-179  */
					/* ================================================ */
					$konsulPoli = KonsulpoliT::model()->findByAttributes(array('pendaftaran_id'=>$modPendaftaran->pendaftaran_id, 'ruangan_id'=>isset($_GET['ruangan_id']) ? $_GET['ruangan_id'] : Yii::app()->user->getState('ruangan_id'))); // RND-6244
					if(count($konsulPoli)>0){
						$updateStatusPeriksa=KonsulpoliT::model()->updateByPk($konsulPoli->konsulpoli_id,array('statusperiksa'=>Params::STATUSPERIKSA_SEDANG_PERIKSA));
					}
					/* ================================================ */

					PendaftaranT::model()->updateByPk($modPendaftaran->pendaftaran_id,
						array(
							'pembayaranpelayanan_id'=>null
						)
					);

					$transaction->commit();
					$this->succesSave = true;
					Yii::app()->user->setFlash('success',"Data Tindakan Pasien berhasil disimpan");
					//Yii::app()->user->setFlash('error',"Data valid ".$this->traceObatAlkesPasien($modPemakainBahans));
				} else {
					$transaction->rollback();
					Yii::app()->user->setFlash('error',"Data tidak valid 1");
					//Yii::app()->user->setFlash('error',"Data tidak valid ".$this->traceObatAlkesPasien($modPemakainBahans));
				}
			} else {
				$transaction->rollback();
				Yii::app()->user->setFlash('error',"Data tidak valid 2");
				//Yii::app()->user->setFlash('error',"Data tidak valid ".$this->traceTindakan($modTindakans));
			}
		} catch (Exception $exc) {
			$transaction->rollback();
			Yii::app()->user->setFlash('error',"Data Tindakan Pasien Gagal disimpan. ".MyExceptionMessage::getMessage($exc,true));
		}

		return $modTindakans;
	}
        
	protected function cekAlatmedis($idDaftartindakan)
	{
		$idAlatmedis = null;
		if(!empty($_POST['pemakaianAlat'])){
			foreach($_POST['pemakaianAlat'] as $k=>$item){
				if($item['daftartindakan_id']==$idDaftartindakan){
					$idAlatmedis = $item['alatmedis_id'];
				}
			}
		}

		return $idAlatmedis;
	}

	private function traceTindakan($modTindakans)
	{
		foreach ($modTindakans as $key => $modTindakan) {
			$echo .= "<pre>".print_r($modTindakan->attributes,1)."</pre>";
		}
		return $echo;
	}
        
	public function actionAjaxDeleteTindakanPelayanan()
	{
                $data = array();
		if(Yii::app()->request->isAjaxRequest) {
		$idTindakanpelayanan = $_POST['idTindakanpelayanan'];
		$transaction = Yii::app()->db->beginTransaction();
		try {
			$obatAlkesT = RJObatalkesPasienT::model()->findAllByAttributes(
				array(
					'tindakanpelayanan_id'=>$idTindakanpelayanan
				)
			);
			$data['success'] = true;
			if(count($obatAlkesT) > 0){
				$this->kembalikanStok2($obatAlkesT);
				$deleteObatPasien = RJObatalkesPasienT::model()->deleteAllByAttributes(
					array(
						'tindakanpelayanan_id'=>$idTindakanpelayanan
					)
				);
				$deleteTindakan = RJTindakanPelayananT::model()->deleteByPk($idTindakanpelayanan);
				if(!$deleteObatPasien)
				{
					$data['success'] = false;
				}
			}else{
				$deleteTindakan = RJTindakanPelayananT::model()->deleteByPk($idTindakanpelayanan);
			}
                        // var_dump($data['success']); die;
			if ($deleteTindakan && $data['success']){
				$data['success'] = true;
				$transaction->commit();
			}else{
				$data['success'] = false;
				$transaction->rollback();
			}
		} catch (Exception $exc) {
			$transaction->rollback();
			echo MyExceptionMessage::getMessage($exc,true);
			$data['success'] = false;
		}



		echo json_encode($data);
		 Yii::app()->end();
		}
	}
        
        protected function savePaketBmhp2($modPendaftaran,$paketBmhp,$tindakan)
	{
                // var_dump($paketBmhp);
		$modObatAlkesPasien = new RJObatalkesPasienT();
                $modObatAlkesPasien->attributes = $paketBmhp;
                $modObatAlkesPasien->tglpelayanan = date("Y-m-d H:i:s");
                $modObatAlkesPasien->tipepaket_id = Params::TIPEPAKET_ID_NONPAKET; //$tindakan->tipepaket_id;
                $modObatAlkesPasien->ruangan_id = Yii::app()->user->getState('ruangan_id');
                $modObatAlkesPasien->pendaftaran_id = $modPendaftaran->pendaftaran_id;
                $modObatAlkesPasien->pasienadmisi_id = $modPendaftaran->pasienadmisi_id;
                $modObatAlkesPasien->carabayar_id = $modPendaftaran->carabayar_id;
                $modObatAlkesPasien->penjamin_id = $modPendaftaran->penjamin_id;
                $modObatAlkesPasien->pegawai_id = $modPendaftaran->pegawai_id;
                $modObatAlkesPasien->shift_id = Yii::app()->user->getState('shift_id');
                $modObatAlkesPasien->pasien_id = $modPendaftaran->pasien_id;
                $modObatAlkesPasien->kelaspelayanan_id = $modPendaftaran->kelaspelayanan_id;
                $modObatAlkesPasien->tglpelayanan = date ('Y-m-d H:i:s');
                $modObatAlkesPasien->create_loginpemakai_id = Yii::app()->user->id;
                $modObatAlkesPasien->create_ruangan = Yii::app()->user->getState('ruangan_id');
                $modObatAlkesPasien->create_time = date ('Y-m-d H:i:s');
                
                //$modObatAlkesPasien->qty_oa = $paketBmhp['qtypemakaian']; //$stokOa->qtystok_terpakai;
                // $modObatAlkesPasien->qty_stok = //$stokOa->qtystok;
                //$modObatAlkesPasien->harganetto_oa = $paketBmhp['harganetto']; //$stokOa->HPP;
                //$modObatAlkesPasien->hargasatuan_oa = $paketBmhp['hargasatuan']; //$stokOa->HargaJualSatuan;
                //$modObatAlkesPasien->hargajual_oa = $modObatAlkesPasien->hargasatuan_oa * $modObatAlkesPasien->qty_oa;
		$totalBmhp = 0;
		
                
                
                //foreach ($paketBmhp AS $i => $bmhp) {
		//	 if ($stokOa->obatalkes_id==$bmhp['obatalkes_id']) {
                                $modObatAlkesPasien->sumberdana_id = $paketBmhp['sumberdana_id'];                
                                $modObatAlkesPasien->satuankecil_id = $paketBmhp['satuankecil_id'];                
                                $modObatAlkesPasien->qty_stok = $paketBmhp['qty_stok'];
                                $modObatAlkesPasien->iurbiaya = $paketBmhp['subtotal'];
				$modObatAlkesPasien->qty_oa = $paketBmhp['qtypemakaian'];
				$modObatAlkesPasien->hargajual_oa = $paketBmhp['hargapemakaian'];
				$modObatAlkesPasien->harganetto_oa = $paketBmhp['harganetto'];
				$modObatAlkesPasien->hargasatuan_oa = $paketBmhp['hargasatuan']; //$bmhp['hargasatuan'];
				$modObatAlkesPasien->daftartindakan_id = $paketBmhp['daftartindakan_id'];				
				$modObatAlkesPasien->tindakanpelayanan_id = $tindakan->tindakanpelayanan_id;
				$totalBmhp = $totalBmhp + $paketBmhp['hargapemakaian'];		
		//	 }
                //}
		
                //var_dump($modObatAlkesPasien->attributes);      
                
                //var_dump($modObatAlkesPasien->validate());
                
                //var_dump($modObatAlkesPasien->errors);


                //die;
		if($modObatAlkesPasien->save()){
			$this->successSaveBmhp &= true;
			$totalBmhp = $totalBmhp + $tindakan->tarif_bhp;
			$tindakan->tarif_bhp = $totalBmhp;
			$tindakan->update();
		}else{
			$this->successSaveBmhp &= false;
		}
                
                // var_dump($this->successSaveBmhp); die;
                
		return $modObatAlkesPasien;
	}
        
        protected function savePemakaianBahan2($modPendaftaran,$pemakaianBahan,$tindakan)
	{
                // var_dump($pemakaianBahan);
		$modObatAlkesPasien = new RJObatalkesPasienT();
                $modObatAlkesPasien->attributes = $pemakaianBahan;
                $modObatAlkesPasien->tglpelayanan = date("Y-m-d H:i:s");
                $modObatAlkesPasien->tipepaket_id = Params::TIPEPAKET_ID_NONPAKET;
                $modObatAlkesPasien->ruangan_id = Yii::app()->user->getState('ruangan_id');
                $modObatAlkesPasien->pendaftaran_id = $modPendaftaran->pendaftaran_id;
                $modObatAlkesPasien->pasienadmisi_id = $modPendaftaran->pasienadmisi_id;
                $modObatAlkesPasien->carabayar_id = $modPendaftaran->carabayar_id;
                $modObatAlkesPasien->penjamin_id = $modPendaftaran->penjamin_id;
                $modObatAlkesPasien->pegawai_id = $modPendaftaran->pegawai_id;
                $modObatAlkesPasien->shift_id = Yii::app()->user->getState('shift_id');
                $modObatAlkesPasien->pasien_id = $modPendaftaran->pasien_id;
                $modObatAlkesPasien->kelaspelayanan_id = $modPendaftaran->kelaspelayanan_id;
                $modObatAlkesPasien->tglpelayanan = date ('Y-m-d H:i:s');
                $modObatAlkesPasien->create_loginpemakai_id = Yii::app()->user->id;
                $modObatAlkesPasien->create_ruangan = Yii::app()->user->getState('ruangan_id');
                $modObatAlkesPasien->create_time = date ('Y-m-d H:i:s');
                
                
                //$modObatAlkesPasien->qty_oa = $stokOa->qtystok_terpakai;
                //$modObatAlkesPasien->qty_stok = $stokOa->qtystok;
                //$modObatAlkesPasien->harganetto_oa = $stokOa->HPP;
                $modObatAlkesPasien->hargasatuan_oa = floor($modObatAlkesPasien->hargajual_oa / $modObatAlkesPasien->qty_oa);
                //$modObatAlkesPasien->hargajual_oa = $modObatAlkesPasien->hargasatuan_oa * $modObatAlkesPasien->qty_oa;
                $modObatAlkesPasien->oa = Params::OBATALKESPASIEN_BMHP;
                
                //foreach ($pemakaianBahan AS $i => $postDetail) {
                //   if ($stokOa->obatalkes_id==$postDetail['obatalkes_id']) {
                       //$modObatAlkesPasien->tindakanpelayanan_id = $tindakan->tindakanpelayanan_id;
                       $modObatAlkesPasien->sumberdana_id = $pemakaianBahan['sumberdana_id'];                
                       $modObatAlkesPasien->satuankecil_id = $pemakaianBahan['satuankecil_id'];                
                       $modObatAlkesPasien->daftartindakan_id = $pemakaianBahan['daftartindakan_id'];                
                       $modObatAlkesPasien->qty_stok = $pemakaianBahan['qty_stok'];
                       $modObatAlkesPasien->iurbiaya = $pemakaianBahan['subtotal'];
                   //}
                //}
                //echo "Kick";
                       
                // var_dump($modObatAlkesPasien->attributes);
                
                //var_dump($modObatAlkesPasien->validate());
                //var_dump($modObatAlkesPasien->errors);
                
                // die;
                       
                
                
                if($modObatAlkesPasien->save()){
                    $this->successSavePemakaianBahan &= true;
                }else{
                    $this->successSavePemakaianBahan &= false;
                }
                return $modObatAlkesPasien;
	}
        
        
	protected function savePaketBmhp($modPendaftaran,$stokOa,$paketBmhp,$tindakan)
	{
		$modObatAlkesPasien = new RJObatalkesPasienT();
        $modObatAlkesPasien->attributes = $stokOa->attributes;
        $modObatAlkesPasien->tglpelayanan = date("Y-m-d H:i:s");
        $modObatAlkesPasien->tipepaket_id = Params::TIPEPAKET_ID_NONPAKET; //$tindakan->tipepaket_id;
        $modObatAlkesPasien->ruangan_id = Yii::app()->user->getState('ruangan_id');
        $modObatAlkesPasien->pendaftaran_id = $modPendaftaran->pendaftaran_id;
        $modObatAlkesPasien->pasienadmisi_id = $modPendaftaran->pasienadmisi_id;
        $modObatAlkesPasien->carabayar_id = $modPendaftaran->carabayar_id;
        $modObatAlkesPasien->penjamin_id = $modPendaftaran->penjamin_id;
        $modObatAlkesPasien->pegawai_id = $modPendaftaran->pegawai_id;
        $modObatAlkesPasien->shift_id = Yii::app()->user->getState('shift_id');
        $modObatAlkesPasien->pasien_id = $modPendaftaran->pasien_id;
        $modObatAlkesPasien->kelaspelayanan_id = $modPendaftaran->kelaspelayanan_id;
        $modObatAlkesPasien->tglpelayanan = date ('Y-m-d H:i:s');
        $modObatAlkesPasien->create_loginpemakai_id = Yii::app()->user->id;
        $modObatAlkesPasien->create_ruangan = Yii::app()->user->getState('ruangan_id');
        $modObatAlkesPasien->create_time = date ('Y-m-d H:i:s');
        $modObatAlkesPasien->qty_oa = $stokOa->qtystok_terpakai;
        $modObatAlkesPasien->qty_stok = $stokOa->qtystok;
        $modObatAlkesPasien->harganetto_oa = $stokOa->HPP;
        $modObatAlkesPasien->hargasatuan_oa = $stokOa->HargaJualSatuan;
        $modObatAlkesPasien->hargajual_oa = $modObatAlkesPasien->hargasatuan_oa * $modObatAlkesPasien->qty_oa;
		$totalBmhp = 0;
		
         foreach ($paketBmhp AS $i => $bmhp) {
			 if ($stokOa->obatalkes_id==$bmhp['obatalkes_id']) {
                $modObatAlkesPasien->sumberdana_id = $bmhp['sumberdana_id'];                
                $modObatAlkesPasien->satuankecil_id = $bmhp['satuankecil_id'];                
                $modObatAlkesPasien->qty_stok = $bmhp['qty_stok'];
                $modObatAlkesPasien->iurbiaya = $bmhp['subtotal'];
				$modObatAlkesPasien->qty_oa = $bmhp['qtypemakaian'];
				$modObatAlkesPasien->hargajual_oa = $bmhp['hargapemakaian'];
				$modObatAlkesPasien->harganetto_oa = $bmhp['harganetto'];
				$modObatAlkesPasien->hargasatuan_oa = $bmhp['hargasatuan']; //$bmhp['hargasatuan'];
				$modObatAlkesPasien->daftartindakan_id = $bmhp['daftartindakan_id'];				
				$modObatAlkesPasien->tindakanpelayanan_id = $tindakan->tindakanpelayanan_id;
				$totalBmhp = $totalBmhp + $bmhp['hargapemakaian'];		
			 }
        }
		
		if($modObatAlkesPasien->save()){
			$this->successSaveBmhp &= true;
			$totalBmhp = $totalBmhp + $tindakan->tarif_bhp;
			$tindakan->tarif_bhp = $totalBmhp;
			$tindakan->update();
		}else{
			$this->successSaveBmhp &= false;
		}
		return $modObatAlkesPasien;
	}
        
	protected function savePemakaianBahan($modPendaftaran,$stokOa,$pemakaianBahan,$tindakan)
	{
		$modObatAlkesPasien = new RJObatalkesPasienT();
        $modObatAlkesPasien->attributes = $stokOa->attributes;
        $modObatAlkesPasien->tglpelayanan = date("Y-m-d H:i:s");
        $modObatAlkesPasien->tipepaket_id = Params::TIPEPAKET_ID_NONPAKET;
        $modObatAlkesPasien->ruangan_id = Yii::app()->user->getState('ruangan_id');
        $modObatAlkesPasien->pendaftaran_id = $modPendaftaran->pendaftaran_id;
        $modObatAlkesPasien->pasienadmisi_id = $modPendaftaran->pasienadmisi_id;
        $modObatAlkesPasien->carabayar_id = $modPendaftaran->carabayar_id;
        $modObatAlkesPasien->penjamin_id = $modPendaftaran->penjamin_id;
        $modObatAlkesPasien->pegawai_id = $modPendaftaran->pegawai_id;
        $modObatAlkesPasien->shift_id = Yii::app()->user->getState('shift_id');
        $modObatAlkesPasien->pasien_id = $modPendaftaran->pasien_id;
        $modObatAlkesPasien->kelaspelayanan_id = $modPendaftaran->kelaspelayanan_id;
        $modObatAlkesPasien->tglpelayanan = date ('Y-m-d H:i:s');
        $modObatAlkesPasien->create_loginpemakai_id = Yii::app()->user->id;
        $modObatAlkesPasien->create_ruangan = Yii::app()->user->getState('ruangan_id');
        $modObatAlkesPasien->create_time = date ('Y-m-d H:i:s');
        $modObatAlkesPasien->qty_oa = $stokOa->qtystok_terpakai;
        $modObatAlkesPasien->qty_stok = $stokOa->qtystok;
        $modObatAlkesPasien->harganetto_oa = $stokOa->HPP;
        $modObatAlkesPasien->hargasatuan_oa = $stokOa->HargaJualSatuan;
        $modObatAlkesPasien->hargajual_oa = $modObatAlkesPasien->hargasatuan_oa * $modObatAlkesPasien->qty_oa;
        $modObatAlkesPasien->oa = Params::OBATALKESPASIEN_BMHP;
         foreach ($pemakaianBahan AS $i => $postDetail) {
            if ($stokOa->obatalkes_id==$postDetail['obatalkes_id']) {
                $modObatAlkesPasien->sumberdana_id = $postDetail['sumberdana_id'];                
                $modObatAlkesPasien->satuankecil_id = $postDetail['satuankecil_id'];                
                $modObatAlkesPasien->daftartindakan_id = $postDetail['daftartindakan_id'];                
                $modObatAlkesPasien->qty_stok = $postDetail['qty_stok'];
                $modObatAlkesPasien->iurbiaya = $postDetail['subtotal'];
            }
        }

        if($modObatAlkesPasien->save()){
            $this->successSavePemakaianBahan &= true;
        }else{
            $this->successSavePemakaianBahan &= false;
        }
        return $modObatAlkesPasien;
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
        $modStokOaNew->unsetIdTransaksi(); //new / autoincrement pk
        $modStokOaNew->qtystok_in = 0;
        $modStokOaNew->qtystok_out = $modObatAlkesPasien->qty_oa;
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
        //$modStokOaNew->unsetIdTransaksi();
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
	
	private function traceObatAlkesPasien($modObatPasiens)
	{
		foreach ($modObatPasiens as $key => $modObatPasien) {
			$echo .= "<pre>".print_r($modObatPasien->attributes,1)."</pre>";
		}
		return $echo;
	}

	/**
	 * 
	 * @param ObatalkespasienT $modObatPasien 
	 */
	protected function saveObatAlkesKomponen($modObatPasien)
	{
		$modObatPasien = new ObatalkespasienT;
		$obat = ObatalkesM::model()->findByPk($modObatPasien->obatalkes_id);
		$obat = new ObatalkesM;
		$modObatPasienKomponen = new ObatalkeskomponenT;
		$modObatPasienKomponen->obatalkespasien_id = $modObatPasien->obatalkespasien_id;
		$modObatPasienKomponen->hargajualkomponen = $obat->hargajual;
		$modObatPasienKomponen->harganettokomponen = $obat->harganetto;
		$modObatPasienKomponen->hargasatuankomponen = $obat->hargajual;
		$modObatPasienKomponen->iurbiaya = 0;
		$modObatPasienKomponen->komponentarif_id = null;

	}
        
	protected function kurangiStok($qty,$idobatAlkes)
	{
		$sql = "SELECT stokobatalkes_id,qtystok_in,qtystok_out FROM stokobatalkes_t WHERE obatalkes_id = $idobatAlkes ORDER BY tglstok_in";
		$stoks = Yii::app()->db->createCommand($sql)->queryAll();
		$selesai = false;
//            while(!$selesai){
			foreach ($stoks as $i => $stok) {
				if($qty <= $stok['qtystok_current']) {
					$stok_current = $stok['qtystok_current'] - $qty;
					$stok_out = $stok['qtystok_out'] + $qty;
					StokobatalkesT::model()->updateByPk($stok['stokobatalkes_id'], array('qtystok_out'=>$stok_out));
					$selesai = true;
					break;
				} else {
					$qty = $qty - $stok['qtystok_current'];
					$stok_current = 0;
					$stok_out = $stok['qtystok_out'] + $stok['qtystok_current'];
					StokobatalkesT::model()->updateByPk($stok['stokobatalkes_id'], array('qtystok_out'=>$stok_out));
				}
			}
//            }
	}
        
	protected function kembalikanStok($obatAlkesT)
	{
		foreach ($obatAlkesT as $i => $obatAlkes) {
			$stok = new RJStokObatalkesT;
			$stok->obatalkes_id = $obatAlkes->obatalkes_id;
			$stok->ruangan_id = isset($_GET['ruangan_id']) ? $_GET['ruangan_id'] : Yii::app()->user->getState('ruangan_id'); // RND-6244
			$stok->tglstok_in = date('Y-m-d H:i:s');
			$stok->tglstok_out = date('Y-m-d H:i:s');
			$stok->qtystok_in = $obatAlkes->qty_oa;
			$stok->qtystok_out = 0;
			$stok->harganetto = $obatAlkes->harganetto_oa;
			$stok->satuankecil_id = $obatAlkes->satuankecil_id;
			$stok->save();
		}
	}
        
        protected function kembalikanStok2($obatAlkesT)
	{
		foreach ($obatAlkesT as $i => $obatAlkes) {
                    StokobatalkesT::model()->deleteAllByAttributes(array(
                        'obatalkespasien_id'=>$obatAlkes->obatalkespasien_id
                    ));
		}
	}

	public function actionLoadFormTindakanPaket()
	{
		if (Yii::app()->request->isAjaxRequest)
		{
			$idTipePaket = (isset($_POST['idTipePaket']) ? $_POST['idTipePaket'] : null);
			$idKelasPelayanan = (isset($_POST['idKelasPelayanan']) ? $_POST['idKelasPelayanan'] : null); 
			$idKelompokUmur = (isset($_POST['idKelompokUmur']) ? $_POST['idKelompokUmur'] : null);
			$idCarabayar = isset($_POST['idCarabayar']) ? $_POST['idCarabayar']:null;

			$modPaketTindakan = PaketpelayananV::model()->findAllByAttributes(array('tipepaket_id'=>$idTipePaket));
			$modTindakans = array();
			$optionDaftarttindakan = '';
			if(isset($modPaketTindakan)){
				if($idTipePaket!=Params::TIPEPAKET_ID_LUARPAKET){
					foreach ($modPaketTindakan as $i => $tindakan) {

						$modTindakans[$i] = new TindakanpelayananT;
						$modTindakans[$i]->daftartindakan_id = $tindakan->daftartindakan_id;
						$modTindakans[$i]->daftartindakanNama = $tindakan->daftartindakan_nama;
						$modTindakans[$i]->kategoriTindakanNama = $tindakan->kategoritindakan_nama;
						$modTindakans[$i]->qty_tindakan = 1;
						$modTindakans[$i]->persenCyto = 0;
	//                    $modTindakans[$i]->tarif_satuan = $tindakan->tarifpaketpel;
						$modTindakans[$i]->tarif_satuan = $tindakan->iurbiaya;
						$modTindakans[$i]->jumlahTarif = $modTindakans[$i]->qty_tindakan * $modTindakans[$i]->tarif_satuan;
						$modTindakans[$i]->subsidiasuransi_tindakan = 0;
						$modTindakans[$i]->subsidipemerintah_tindakan = 0;
						$modTindakans[$i]->subsisidirumahsakit_tindakan = 0;
						$modTindakans[$i]->iurbiaya_tindakan = 0;//$tindakan->iurbiaya;


						//buat option daftartindakanPemakaianBahan
						$optionDaftarttindakan .= CHtml::tag('option', array('value'=>$modTindakans[$i]->daftartindakan_id), $modTindakans[$i]->daftartindakanNama, true);
					}
				}
			}

			// ambil data untuk paket BMHP
			$totHargaBmhp = 0;
			$criteria = new CDbCriteria();
			if(!empty($idTipePaket)){
				$criteria->addCondition("tipepaket_id = ".$idTipePaket);						
			}
			if(!empty($idKelompokUmur)){
				$criteria->addCondition("kelompokumur_id = ".$idKelompokUmur);						
			}
			$criteria->with = array('obatalkes','daftartindakan');
			$modPaketBmhp = PaketbmhpM::model()->findAll($criteria);
//            $modPaketBmhp = PaketbmhpM::model()->with('obatalkes','daftartindakan')->findAllByAttributes(array('tipepaket_id'=>$idTipePaket,
//                                                                                                               'kelompokumur_id'=>$idKelompokUmur));
			if(isset($modPaketBmhp)){
				foreach ($modPaketBmhp as $i => $bmhp) { 
					$totHargaBmhp = $totHargaBmhp + $bmhp->hargapemakaian;
				}
			}
			// ---------------------------

			echo CJSON::encode(array(
				'form'=>$this->renderPartial($this->path_view.'_formLoadTindakanPaket', array('modPaketTindakan'=>$modPaketTindakan,
																			 'modTindakans'=>$modTindakans,
					), true),
				'formPaketBmhp'=>$this->renderPartial($this->path_view.'_formLoadPaketBmhp', array('modPaketBmhp'=>$modPaketBmhp,
					), true),
				'totHargaBmhp'=>$totHargaBmhp,
				'optionDaftarttindakan'=>$optionDaftarttindakan,
				));
			exit;               
		}
	}

	public function actionAddFormPaketBmhp()
	{
		if(Yii::app()->request->isAjaxRequest) { 
			$kelumur_id = (isset($_POST['kelumur_id']) ? $_POST['kelumur_id'] : null);
			$pendaftaran_id = (isset($_POST['pendaftaran_id']) ? $_POST['pendaftaran_id'] : null);
			$daftartindakan_id = (isset($_POST['daftartindakan_id']) ? $_POST['daftartindakan_id'] : null);            
			$modPaketBmhp = PaketbmhpM::model()->with('daftartindakan','obatalkes')->findAllByAttributes(array('daftartindakan_id'=>$daftartindakan_id,
																		'kelompokumur_id'=>$kelumur_id,));
			$form = "";
			$pesan = "";
			$format = new MyFormatter();
			$modObatAlkesPasien = new RJObatalkesPasienT;
			$ruangan_id = Yii::app()->user->getState('ruangan_id');
			$modDaftartindakan = DaftartindakanM::model()->findByPk($daftartindakan_id);
			$persenjual = $this->persenJualRuangan();
			$modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
			
                        
			foreach($modPaketBmhp AS $j => $paket){	
                                $oa = ObatalkesM::model()->findByPk($paket->obatalkes_id);
				$modStokOAs = StokobatalkesT::getStokObatAlkesAktif($paket->obatalkes_id, $paket->qtypemakaian, $ruangan_id);			
				//if(count($modStokOAs) > 0){
				//	foreach($modStokOAs AS $i => $stok){
						$modObatAlkesPasien->sumberdana_id = $oa->sumberdana_id; //(isset($stok->penerimaandetail->sumberdana_id) ? $stok->penerimaandetail->sumberdana_id : $stok->obatalkes->sumberdana_id);
						$modObatAlkesPasien->daftartindakan_id = $paket->daftartindakan_id;
						$modObatAlkesPasien->daftartindakan_nama = $paket->daftartindakan->daftartindakan_nama;
						$modObatAlkesPasien->obatalkes_id = $oa->obatalkes_id; //$stok->obatalkes_id;
						$modObatAlkesPasien->stokobatalkes_id = null; //$stok->stokobatalkes_id;
						$modObatAlkesPasien->obatalkes_nama = $oa->obatalkes_nama; //$stok->obatalkes->obatalkes_nama;
						$modObatAlkesPasien->qtypemakaian = $paket->qtypemakaian; //$stok->qtystok_terpakai;
						$modObatAlkesPasien->hargapemakaian = $paket->hargapemakaian;
						$modObatAlkesPasien->harganetto_oa = $oa->harganetto; //$stok->HPP;
						$modObatAlkesPasien->hargasatuan_oa = $oa->hargajual; //$stok->HargaJualSatuan;
						$modObatAlkesPasien->qty_stok = 0; //$stok->qtystok;
						$modObatAlkesPasien->hargajual_oa = $modObatAlkesPasien->qty_oa * $modObatAlkesPasien->hargasatuan_oa;
						$modObatAlkesPasien->stokobatalkes_id = null; //$stok->stokobatalkes_id;
						$modObatAlkesPasien->hargajual = floor(($persenjual + 100 ) / 100 * $modObatAlkesPasien->hargajual);
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
						$modObatAlkesPasien->satuankecil_id = $oa->satuankecil_id; //$stok->satuankecil_id;
						$modObatAlkesPasien->satuankecil_nama = $oa->satuankecil->satuankecil_nama; //$stok->satuankecil->satuankecil_nama;

						$form .= $this->renderPartial($this->path_view.'_formAddPaketBmhp', array('paketBmhp'=>$modObatAlkesPasien,'modDaftartindakan'=>$modDaftartindakan,
						'modPendaftaran'=>$modPendaftaran), true);
					//}
				//}else{
				//	$pesan = "Obat : ". $paket->obatalkes->obatalkes_nama." Stok tidak mencukupi!"	;
				//}
				
			}			
			echo CJSON::encode(array('form'=>$form, 'pesan'=>$pesan));
			Yii::app()->end(); 
		}
	}
        
	public function actionSetFormPemakaianBahan()
	{
		if(Yii::app()->request->isAjaxRequest) { 
			$pendaftaran_id = (isset($_POST['pendaftaran_id']) ? $_POST['pendaftaran_id'] : null);
			$obatalkes_id = (isset($_POST['obatalkes_id']) ? $_POST['obatalkes_id'] : null);
			$daftartindakan_id = (isset($_POST['daftartindakan_id']) ? $_POST['daftartindakan_id'] : "");
			$jumlah = isset($_POST['jumlah']) ? $_POST['jumlah'] : 1;
			$ruangan_id = Yii::app()->user->getState('ruangna_id');
			$form = "";
			$pesan = "";
			$format = new MyFormatter();
			$modObatAlkesPasien = new RJObatalkesPasienT;
			$ruangan_id = Yii::app()->user->getState('ruangan_id');
			$modStokOAs = StokobatalkesT::getStokObatAlkesAktif($obatalkes_id, $jumlah, $ruangan_id);
                        $oa = ObatalkesM::model()->findByPk($obatalkes_id);
			$modDaftartindakan = DaftartindakanM::model()->findByPk($daftartindakan_id);
			$modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
			$persenjual = $this->persenJualRuangan();
			//if(count($modStokOAs) > 0){

				//foreach($modStokOAs AS $i => $stok){
					$modObatAlkesPasien->sumberdana_id = $oa->sumberdana_id; //(isset($stok->penerimaandetail->sumberdana_id) ? $stok->penerimaandetail->sumberdana_id : $stok->obatalkes->sumberdana_id);
					$modObatAlkesPasien->obatalkes_id = $oa->obatalkes_id; //$stok->obatalkes_id;
					$modObatAlkesPasien->stokobatalkes_id = null; //$stok->stokobatalkes_id;
					$modObatAlkesPasien->obatalkes_nama = $oa->obatalkes_nama; // $stok->obatalkes->obatalkes_nama;
					$modObatAlkesPasien->qty_oa = $jumlah; //$stok->qtystok_terpakai;
					$modObatAlkesPasien->harganetto_oa = $oa->harganetto; //$stok->HPP;
					$modObatAlkesPasien->hargasatuan_oa = $oa->hargajual; //$stok->HargaJualSatuan;
					$modObatAlkesPasien->qty_stok = 0; //$stok->qtystok;
					$modObatAlkesPasien->hargajual_oa = $modObatAlkesPasien->qty_oa * $modObatAlkesPasien->hargasatuan_oa;
					$modObatAlkesPasien->stokobatalkes_id = null; //$stok->stokobatalkes_id;
					$modObatAlkesPasien->hargajual = floor(($persenjual + 100 ) / 100 * $modObatAlkesPasien->hargajual);
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
					$modObatAlkesPasien->satuankecil_id = $oa->satuankecil_id; //$stok->satuankecil_id;
					$modObatAlkesPasien->satuankecil_nama = $oa->satuankecil->satuankecil_nama; //$stok->satuankecil->satuankecil_nama;

					$form .= $this->renderPartial($this->path_view.'_formAddPemakaianBahan', array('modObatAlkesPasien'=>$modObatAlkesPasien,'modDaftartindakan'=>$modDaftartindakan,
					'modPendaftaran'=>$modPendaftaran,), true);
				//}
			//}else{
			//	$pesan = "Stok tidak mencukupi!"	;
			//}

			echo CJSON::encode(array('form'=>$form, 'pesan'=>$pesan));
			Yii::app()->end(); 
		}

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
					'form'=>$this->renderPartial($this->path_view.'_formAddPemakaianAlat', array('modAlat'=>$modAlat,'modDaftartindakan'=>$modDaftartindakan,'modObatAlkes'=>$modObatAlkes
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
        
          /**
     * action ajax select tindakan ke form
     */
    public function actionDaftarTindakan()
    {
        if(Yii::app()->request->isAjaxRequest) {
            if (!isset($_GET['term'])){
                $_GET['term'] = null;
            }
            $returnVal = array();
			$ruangan_id = isset($_GET['ruangan_id']) ? $_GET['ruangan_id'] : Yii::app()->user->getState('ruangan_id'); // RND-6244
            $kelaspelayanan_id = (isset($_GET['kelaspelayanan_id']) ? $_GET['kelaspelayanan_id'] : null);
            $tipepaket_id = (isset($_GET['tipepaket_id']) ? $_GET['tipepaket_id'] : null);
            $penjamin_id = (isset($_GET['penjamin_id']) ? $_GET['penjamin_id'] : null);
            $modJenisTarif = JenistarifpenjaminM::model()->find('penjamin_id ='.$penjamin_id);
            if($tipepaket_id == Params::TIPEPAKET_ID_LUARPAKET)
            {
                $criteria = new CDbCriteria();
                $criteria->compare('LOWER(daftartindakan_nama)', strtolower($_GET['term']), true);
                if(Yii::app()->user->getState('tindakanruangan')){
                    $criteria->addCondition('ruangan_id = '.$ruangan_id); // RND-6244
                }
                if(Yii::app()->user->getState('tindakankelas')){
					if(!empty($kelaspelayanan_id)){
						$criteria->addCondition("kelaspelayanan_id = ".$kelaspelayanan_id);						
					}
                    $criteria->addCondition('tipepaket_id', Params::TIPEPAKET_ID_LUARPAKET);
                }
                if (isset($_GET['daftartindakan_id'])){
					if(!empty($_GET['daftartindakan_id'])){
						$criteria->addCondition("daftartindakan_id = ".$_GET['daftartindakan_id']);						
					}
                }
				if(!empty($kelaspelayanan_id)){
					$criteria->addCondition("kelaspelayanan_id = ".$kelaspelayanan_id);						
				}
                $criteria->order = 'daftartindakan_nama';
                $models = PaketpelayananV::model()->findAll($criteria);                    
                foreach($models as $i=>$model)
                {
                    $attributes = $model->attributeNames();
                    foreach($attributes as $j=>$attribute) {
                        $returnVal[$i]["$attribute"] = $model->$attribute;
                    }
                    $returnVal[$i]['label'] = $model->daftartindakan_nama;
                    $returnVal[$i]['value'] = $model->daftartindakan_id;
                }

                echo CJSON::encode($returnVal);
            } else if($tipepaket_id == Params::TIPEPAKET_ID_NONPAKET) {
                $criteria = new CDbCriteria();
                $criteria->compare('LOWER(daftartindakan_nama)', strtolower($_GET['term']), true);
				if(!empty($kelaspelayanan_id)){
					$criteria->addCondition("kelaspelayanan_id = ".$kelaspelayanan_id);						
				}
				if(!empty($penjamin_id)){
					$criteria->addCondition("penjamin_id = ".$penjamin_id);						
				}
                $criteria->order = 'daftartindakan_nama';

                if (isset($_GET['daftartindakan_id'])){
					if(!empty($_GET['daftartindakan_id'])){
						$criteria->addCondition("daftartindakan_id = ".$_GET['daftartindakan_id']);						
					}
                }

                if(Yii::app()->user->getState('tindakankelas'))
                {
					if(!empty($kelaspelayanan_id)){
						$criteria->addCondition("kelaspelayanan_id = ".$kelaspelayanan_id);						
					}
                }

                if(Yii::app()->user->getState('tindakanruangan'))
                {
                    $criteria->addCondition('ruangan_id = '.$ruangan_id);
                    $models = TariftindakanperdaruanganV::model()->findAll($criteria);
                } else {
                    $models = TariftindakanperdaV::model()->findAll($criteria);
                }
                $returnVal = array();
                foreach($models as $i=>$model)
                {
                    $attributes = $model->attributeNames();
                    foreach($attributes as $j=>$attribute) {
                        $returnVal[$i]["$attribute"] = $model->$attribute;
                    }
                    $returnVal[$i]['label'] = $model->daftartindakan_nama;
                    $returnVal[$i]['value'] = $model->daftartindakan_id;
                }

                echo CJSON::encode($returnVal);
            } else {
                $criteria = new CDbCriteria();
                $criteria->compare('LOWER(daftartindakan_nama)', strtolower($_GET['term']), true);
                if (isset($_GET['daftartindakan_id'])){
					if(!empty($_GET['daftartindakan_id'])){
						$criteria->addCondition("daftartindakan_id = ".$_GET['daftartindakan_id']);						
					}
                }

                if(Yii::app()->user->getState('tindakanruangan')){
                    $criteria->addCondition('ruangan_id = '.$ruangan_id);
                }

                if(Yii::app()->user->getState('tindakankelas')){
					if(!empty($kelaspelayanan_id)){
						$criteria->addCondition("kelaspelayanan_id = ".$kelaspelayanan_id);						
					}
                }

				if(!empty($tipepaket_id)){
					$criteria->addCondition("tipepaket_id = ".$tipepaket_id);						
				}
				if(!empty($kelaspelayanan_id)){
					$criteria->addCondition("kelaspelayanan_id = ".$kelaspelayanan_id);						
				}
                $criteria->order = 'daftartindakan_nama';
                $models = PaketpelayananV::model()->find($criteria);
                if(isset($models)){
                    foreach($models as $i=>$model)
                    {
                        $attributes = $model->attributeNames();
                        foreach($attributes as $j=>$attribute) {
                            $returnVal[$i]["$attribute"] = $model->$attribute;
                        }
                        $returnVal[$i]['label'] = $model->daftartindakan_nama;
                        $returnVal[$i]['value'] = $model->daftartindakan_id;
                    }
                }

                echo CJSON::encode($returnVal);
            }
        }
        Yii::app()->end();
    }   
    
    /**
	* untuk mencari dokter di autocomplete
	*/
	public function actionGetDokter()
	{
		if(Yii::app()->request->isAjaxRequest) {
			$criteria = new CDbCriteria();
			if (isset($_GET['term'])){
				$criteria->compare('LOWER(nama_pegawai)', strtolower($_GET['term']), true);
			}
			$criteria->order = 'nama_pegawai';
			if (isset($_GET['idPegawai'])){
				if(!empty($_GET['idPegawai'])){
					$criteria->addCondition("pegawai_id = ".$_GET['idPegawai']);						
				}
			}
			$models = DokterpegawaiV::model()->findAll($criteria);
			foreach($models as $i=>$model)
			{
				$attributes = $model->attributeNames();
				foreach($attributes as $j=>$attribute) {
					$returnVal[$i]["$attribute"] = $model->$attribute;
				}
				$returnVal[$i]['label'] = $model->gelardepan." ".$model->nama_pegawai.", ".$model->gelarbelakang_nama;
				$returnVal[$i]['value'] = $model->pegawai_id;
			}

			echo CJSON::encode($returnVal);
		}
		Yii::app()->end();
	}

	/**
	 * untuk mencari bidan di autocomplete
	 */
	public function actionGetBidan()
	{
		if(Yii::app()->request->isAjaxRequest) {
			$criteria = new CDbCriteria();
			$criteria->compare('LOWER(nama_pegawai)', strtolower($_GET['term']), true);
			$criteria->order = 'nama_pegawai';
			$models = PegawaiM::model()->findAll($criteria);
			$returnVal = array();
			foreach($models as $i=>$model)
			{
				 $attributes = $model->attributeNames();
				 foreach($attributes as $j=>$attribute) {
					 $returnVal[$i]["$attribute"] = $model->$attribute;
				 }
				 $returnVal[$i]['label'] = $model->nama_pegawai;
				 $returnVal[$i]['value'] = $model->pegawai_id;
			}

			echo CJSON::encode($returnVal);
		}
		Yii::app()->end();
	}

	/**
	 * untuk mencari suster di autocomplete
	 */

	public function actionGetSuster()
	{
		if(Yii::app()->request->isAjaxRequest) {
			$criteria = new CDbCriteria();
			$criteria->compare('LOWER(nama_pegawai)', strtolower($_GET['term']), true);
			$criteria->order = 'nama_pegawai';
			$models = PegawaiM::model()->findAll($criteria);
			$returnVal = array();
			foreach($models as $i=>$model)
			{
				 $attributes = $model->attributeNames();
				 foreach($attributes as $j=>$attribute) {
					 $returnVal[$i]["$attribute"] = $model->$attribute;
				 }
				 $returnVal[$i]['label'] = $model->nama_pegawai;
				 $returnVal[$i]['value'] = $model->pegawai_id;
			}

			echo CJSON::encode($returnVal);
		}
		Yii::app()->end();
	}

	/**
	 * untuk mencari perawat di autocomplete
	 */
	public function actionGetPerawat()
	{
		if(Yii::app()->request->isAjaxRequest) {
			$criteria = new CDbCriteria();
			$criteria->compare('LOWER(nama_pegawai)', strtolower($_GET['term']), true);
			$criteria->order = 'nama_pegawai';
			$models = DokterpegawaiV::model()->findAll($criteria);
			$returnVal = array();
			foreach($models as $i=>$model)
			{
				 $attributes = $model->attributeNames();
				 foreach($attributes as $j=>$attribute) {
					 $returnVal[$i]["$attribute"] = $model->$attribute;
				 }
				 $returnVal[$i]['label'] = $model->gelardepan." ".$model->nama_pegawai.", ".$model->gelarbelakang_nama;
				 $returnVal[$i]['value'] = $model->pegawai_id;
			}

			echo CJSON::encode($returnVal);
		}
		Yii::app()->end();
	}

	/**
	 * untuk mencari paket bmhp di autocomplete
	 */
	public function actionPaketBMHP()
	{
		if(Yii::app()->request->isAjaxRequest) {
			$criteria = new CDbCriteria();
			$criteria->with = array('obatalkes','daftartindakan','kelompokumur');
			$criteria->compare('LOWER(obatalkes.obatalkes_nama)', strtolower($_GET['term']), true);
			$criteria->order = 'obatalkes.obatalkes_nama';
			$criteria->limit = 5;
			$models = PaketbmhpM::model()->findAll($criteria);
			$returnVal = array();
			foreach($models as $i=>$model)
			{
				 $attributes = $model->attributeNames();
				 foreach($attributes as $j=>$attribute) {
					 $returnVal[$i]["$attribute"] = $model->$attribute;
				 }
				 $returnVal[$i]['label'] = $model->obatalkes->obatalkes_nama.' - '.$model->daftartindakan->daftartindakan_nama.' ('.$model->kelompokumur->kelompokumur_nama.')';
				 $returnVal[$i]['value'] = $model->obatalkes->obatalkes_id;
			}

			echo CJSON::encode($returnVal);
		}
		Yii::app()->end();
	}

	/**
	 * untuk mencari pemakaian bahan di autocomplete
	 */
	public function actionPemakaianBahan()
	{
		if(Yii::app()->request->isAjaxRequest) {
			$criteria = new CDbCriteria();
			$criteria->compare('LOWER(obatalkes_nama)', strtolower($_GET['term']), true);
			$criteria->order = 'obatalkes_nama';
			$criteria->addCondition('obatalkes_farmasi is true');
			$criteria->limit = 5;
			$models = ObatalkesM::model()->findAll($criteria);
			$returnVal = array();
			foreach($models as $i=>$model)
			{
				 $attributes = $model->attributeNames();
				 foreach($attributes as $j=>$attribute) {
					 $returnVal[$i]["$attribute"] = $model->$attribute;
				 }
				 $returnVal[$i]['label'] = $model->obatalkes_nama;
				 $returnVal[$i]['value'] = $model->obatalkes_id;
			}

			echo CJSON::encode($returnVal);
		}
		Yii::app()->end();
	}

	/**
	* untuk mencari pemakaian alat medis di autocomplete
	*/
	public function actionPemakaianAlatMedis()
	{
	   if(Yii::app()->request->isAjaxRequest) {
		   $criteria = new CDbCriteria();
		   $criteria->compare('LOWER(alatmedis_nama)', strtolower($_GET['term']), true);
		   $criteria->addCondition('instalasi_id = '.Yii::app()->user->getState('instalasi_id'));
		   $criteria->order = 'alatmedis_nama';
		   $models = AlatmedisM::model()->findAll($criteria);
		   foreach($models as $i=>$model)
		   {
				$attributes = $model->attributeNames();
				foreach($attributes as $j=>$attribute) {
					$returnVal[$i]["$attribute"] = $model->$attribute;
				}
				$returnVal[$i]['label'] = $model->alatmedis_nama;
				$returnVal[$i]['value'] = $model->alatmedis_id;
		   }

		   echo CJSON::encode($returnVal);
	   }
	   Yii::app()->end();
   }
//        public function actionUpdateStok()
//        {
//            $qty = $_POST['qty'];
//            $idobatAlkes = $_POST['idObatAlkes'];
//            $sql = "select stokobatalkes_id,qtystok_in,qtystok_out from stokobatalkes_t order by tglstok_in";
//            $stoks = Yii::app()->db->createCommand($sql)->queryAll();
//            $selesai = false;
//            while(!$selesai){
//                foreach ($stoks as $i => $stok) {
//                    if($qty <= $stok['qtystok_in']) {
//                        $stok_in = $stok['qtystok_in'] - $qty;
//                        $stok_out = $stok['qtystok_out'] + $qty;
//                        StokobatalkesT::model()->updateByPk($stok['stokobatalkes_id'], array('qtystok_in'=>$stok_in,'qtystok_out'=>$stok_out));
//                        $selesai = true;
//                        break;
//                    } else {
//                        $qty = $qty - $stok['qtystok_in'];
//                        $stok_in = 0;
//                        $stok_out = $stok['qtystok_out'] + $stok['qtystok_in'];
//                        StokobatalkesT::model()->updateByPk($stok['stokobatalkes_id'], array('qtystok_in'=>$stok_in,'qtystok_out'=>$stok_out));
//                    }
//                }
//            }
//            $data['input'] = 'qty: '.$qty.' | ID Obat: '.$idobatAlkes;
//            echo CJSON::encode($data);
//            Yii::app()->end();
//        }


        // Uncomment the following methods and override them if needed
	/*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
    public function actionPrintTindakan($id){
        $this->layout='//layouts/printWindows';
        $format = new MyFormatter;    
        $modPendaftaran = RJPendaftaranT::model()->with('jeniskasuspenyakit')->findByPk($id);
        $modPasien = RJPasienM::model()->findByPk($modPendaftaran->pasien_id);
        $modViewTindakans = RJTindakanPelayananT::model()
                            ->with('daftartindakan','dokter1','dokter2','dokterPendamping','dokterAnastesi',
                                   'dokterDelegasi','bidan','suster','perawat','tipePaket')
                            ->findAllByAttributes(array('pendaftaran_id'=>$id, 'ruangan_id'=>isset($_GET['ruangan_id']) ? $_GET['ruangan_id'] : Yii::app()->user->getState('ruangan_id'))); // RND-6244
                    
        $modViewBmhp = RJObatalkesPasienT::model()->with('obatalkes')->findAllByAttributes(array('pendaftaran_id'=>$id));
        
        $judul_print = 'Tindakan Pasien '.$modPasien->nama_pasien;
        $this->render($this->path_view.'print', 
                array('format'=>$format,
                        'judul_print'=>$judul_print,
                        'modPendaftaran'=>$modPendaftaran, 
                        'modTindakans'=>$modViewTindakans,
                        'modViewBmhp'=>$modViewBmhp,
                        'modPasien'=>$modPasien));
    }
}