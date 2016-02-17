<?php
//Yii::import('rawatJalan.controllers.PemakaianBahanController');
//Yii::import('rawatJalan.models.*');
//class PemakaianBahanTRIController extends PemakaianBahanController
//{
//        
//}
class PemakaianBahanTRIController extends MyAuthController
{
    protected	$successSavePemakaianBahan = true;
	public		$obatalkespasientersimpan = true; //dilooping
    public		$stokobatalkestersimpan = true; //looping
    
	public function actionIndex($pendaftaran_id,$pasienadmisi_id)
	{
            $this->layout='//layouts/iframe';
            $modAdmisi = (!empty($pasienadmisi_id)) ? PasienadmisiT::model()->findByAttributes(array('pendaftaran_id'=>$pendaftaran_id,'pasienadmisi_id'=>$pasienadmisi_id)) : array();
            $modPendaftaran = RIPendaftaranT::model()->with('jeniskasuspenyakit')->findByPk($pendaftaran_id);
            $modPasien = RIPasienM::model()->findByPk($modPendaftaran->pasien_id);
		
            if(isset($_POST['pemakaianBahan'])){
				$transaction = Yii::app()->db->beginTransaction();
				try {
					if(count($_POST['pemakaianBahan']) > 0){
						//PROSES GROUP DETAIL BERDASARKAN obatalkes_id & akumulasikan jmlmutasi
						$detailGroups = array();
						foreach($_POST['pemakaianBahan'] AS $i => $postDetail){
							$modDetails[$i] = new RIObatalkespasienT;
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
								$modDetails[$i] = $this->simpanObatAlkesPasien($modPendaftaran,$stok, $_POST['pemakaianBahan']);
								$this->simpanStokObatAlkesOut($stok['stokobatalkes_id'], $modDetails[$i]);
							}
						}else{
							$this->stokobatalkestersimpan &= false;
							$obathabis .= "<br>- ".ObatalkesM::model()->findByPk($detail['obatalkes_id'])->obatalkes_nama;

						}
					}

					if($this->obatalkespasientersimpan&&$this->stokobatalkestersimpan){
						$transaction->commit();
						Yii::app()->user->setFlash('success',"Data Berhasil disimpan");
						$this->refresh();
					}else{
						$transaction->rollback();
						Yii::app()->user->setFlash('error',"Data Pemakaian Bahan gagal disimpan !");
					}
				} catch (Exception $e) {
					$transaction->rollback();
					Yii::app()->user->setFlash('error',"Data pemakaian Bahan gagal disimpan ! ".MyExceptionMessage::getMessage($e,true));
				}
            }
            
            $modViewBmhp = RIObatalkespasienT::model()->with('obatalkes')->findAllByAttributes(array('pendaftaran_id'=>$pendaftaran_id));

            $this->render('index',array('modPendaftaran'=>$modPendaftaran,
                                        'modPasien'=>$modPasien,
                                        'modViewBmhp'=>$modViewBmhp,
                                        'modAdmisi'=>$modAdmisi
                                    ));
	}
        
        protected function savePemakaianBahan($modPendaftaran,$pemakaianBahan)
        {
            $valid = true;
            foreach ($pemakaianBahan as $i => $bmhp) {
                $modPakaiBahan[$i] = new RIObatalkespasienT;
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
                $modPakaiBahan[$i]->pasienadmisi_id = $_GET['pasienadmisi_id'];

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

        private function traceObatAlkesPasien($modObatPasiens)
        {
            foreach ($modObatPasiens as $key => $modObatPasien) {
                $echo .= "<pre>".print_r($modObatPasien->attributes,1)."</pre>";
            }
            return $echo;
        }
        
        protected function kurangiStok($qty,$idobatAlkes)
        {
            $sql = "SELECT stokobatalkes_id,qtystok_in,qtystok_out FROM stokobatalkes_t WHERE obatalkes_id = $idobatAlkes ORDER BY tglstok_in";
            $stoks = Yii::app()->db->createCommand($sql)->queryAll();
            $selesai = false;
                foreach ($stoks as $i => $stok) {
                    if($qty <= $stok['qtystok_in']-$stok['qtystok_out']) {
                        $stok_current = ($stok['qtystok_in']-$stok['qtystok_out']) - $qty;
                        $stok_out = $stok['qtystok_out'] + $qty;
                        StokobatalkesT::model()->updateByPk($stok['stokobatalkes_id'], array('qtystok_out'=>$stok_out));
                        $selesai = true;
                        break;
                    } else {
                        $qty = $qty - ($stok['qtystok_in']-$stok['qtystok_out']);
                        $stok_current = 0;
                        $stok_out = $stok['qtystok_out'] + ($stok['qtystok_in']-$stok['qtystok_out']);
                        StokobatalkesT::model()->updateByPk($stok['stokobatalkes_id'], array('stok_current'=>$stok_current,'qtystok_out'=>$stok_out));
                    }
                }
        }
        
        // protected function kembalikanStok($obatAlkesT)
        // {
        //     foreach ($obatAlkesT as $i => $obatAlkes) {
        //         $stok = new RIStokObatalkesT;
        //         $stok->obatalkes_id = $obatAlkes->obatalkes_id;
        //         $stok->sumberdana_id = $obatAlkes->sumberdana_id;
        //         $stok->ruangan_id = Yii::app()->user->getState('ruangan_id');
        //         $stok->tglstok_in = date('Y-m-d H:i:s');
        //         $stok->tglstok_out = date('Y-m-d H:i:s');
        //         $stok->qtystok_in = $obatAlkes->qty_oa;
        //         $stok->qtystok_out = 0;
        //         $stok->harganetto_oa = $obatAlkes->harganetto_oa;
        //         $stok->hargajual_oa = $obatAlkes->hargasatuan_oa;
        //         $stok->discount = $obatAlkes->discount;
        //         $stok->satuankecil_id = $obatAlkes->satuankecil_id;
        //         $stok->save();
        //     }
        // }

        protected function kembalikanStok($modObatAlkesPasien)
        {
            $format = new MyFormatter();
            $stok = new StokobatalkesT;
            $stok->attributes = $modObatAlkesPasien->attributes;
            $modObatAlkes = ObatalkesM::model()->findByPk($modObatAlkesPasien->obatalkes_id); //sementara menggunakan harga terupdate
            $stok->tglkadaluarsa = $format->formatDateTimeForDb($modObatAlkes->tglkadaluarsa); 
            $stok->harganetto = $modObatAlkes->harganetto; 
            $stok->persendiscount = $modObatAlkes->discount; 
            $stok->persenmargin = $modObatAlkes->margin; 
            $stok->satuankecil_id = $modObatAlkes->satuankecil_id; 
            $stok->jmlmargin = 0; 
            $stok->jmldiscount = 0; 
            $stok->persenppn = $modObatAlkes->ppn_persen; 
            $stok->persenpph = 0; 
            $stok->tglstok_in = date('Y-m-d H:i:s');
            $stok->tglterima = date('Y-m-d H:i:s');
            $stok->tglstok_out = null;
            $stok->qtystok_in = $modObatAlkesPasien->qty_oa;
            $stok->qtystok_out = 0;
            
            $stok->create_time = date('Y-m-d H:i:s');
            $stok->update_time = date('Y-m-d H:i:s');
            $stok->create_loginpemakai_id = Yii::app()->user->getState('pegawai_id');
            $stok->create_ruangan = Yii::app()->user->getState('ruangan_id');

            if($stok->save())
                return true;
        }

        public function actionHapusObatAlkesPasien(){
            if(Yii::app()->request->isAjaxRequest) {
                $data['pesan'] = "";
                $data['sukses'] = 0;
                $transaction = Yii::app()->db->beginTransaction();
                try {
                    $loadObatAlkesPasien = ObatalkespasienT::model()->findByPk($_POST['obatalkespasien_id']);
                    $kembalikanstok = $this->kembalikanStok($loadObatAlkesPasien);
                    if($kembalikanstok){
                        if($loadObatAlkesPasien->delete()){
                            $transaction->commit();
                            $data['pesan'] = "Obat / Alat Kesehatan berhasil dihapus!";
                            $data['sukses'] = 1;
                        }else{
                            $transaction->rollback();
                            $data['pesan'] = "Stok Obat / Alat Kesehatan gagal dikembalikan!";
                            $data['sukses'] = 0;
                        }
                    }else{
                        $transaction->rollback();
                        $data['pesan'] = "Obat / Alat Kesehatan gagal dihapus!";
                        $data['sukses'] = 0;
                    }    
                }catch (Exception $exc) {
                    $transaction->rollback();
                    $data['pesan'] = "Obat / Alat Kesehatan gagal dihapus! :".MyExceptionMessage::getMessage($exc,true);
                }
                echo CJSON::encode($data);
            }
            Yii::app()->end();
        }

        public function actionPrint($pendaftaran_id) 
        {
            $this->layout='//layouts/printWindows';
            $format = new MyFormatter;    

            $modPendaftaran = RIPendaftaranT::model()->with('jeniskasuspenyakit')->findByPk($pendaftaran_id);
            $modPasien = RIPasienM::model()->findByPk($modPendaftaran->pasien_id);
            $modViewBmhp = RIObatalkespasienT::model()->with('obatalkes')->findAllByAttributes(array('pendaftaran_id'=>$pendaftaran_id));

            $judul_print = 'Pemakaian Bahan '.$modPasien->nama_pasien;
            $this->render('print', array(
                                'format'=>$format,
                                'judul_print'=>$judul_print,
                                'modPendaftaran'=>$modPendaftaran,
                                'modPasien'=>$modPasien,
                                'modViewBmhp'=>$modViewBmhp,
            ));
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
		
	/**
	* simpan RIObatalkespasienT
	* @param type $modPendaftaran
	* @param type $post
	* @return \RIObatalkespasienT
	*/
	public function simpanObatAlkesPasien($modPendaftaran ,$stokOa, $postObatAlkesPasien){        
	   $modObatAlkesPasien = new RIObatalkespasienT();
	   $modObatAlkesPasien->attributes = $stokOa->attributes;
	   $modObatAlkesPasien->tglpelayanan = date("Y-m-d H:i:s");
	   $modObatAlkesPasien->tipepaket_id = Params::TIPEPAKET_ID_NONPAKET;
	   $modObatAlkesPasien->ruangan_id = Yii::app()->user->getState('ruangan_id');
	   $modObatAlkesPasien->pendaftaran_id = $modPendaftaran->pendaftaran_id;
	   $modObatAlkesPasien->pasienmasukpenunjang_id = null;
	   $modObatAlkesPasien->pendaftaran_id = $modPendaftaran->pendaftaran_id;
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
	* menampilkan obat
	* @return row table 
	*/
	public function actionSetFormObatAlkesPasien()
	{
		if(Yii::app()->request->isAjaxRequest) { 
			$pendaftaran_id = (isset($_POST['pendaftaran_id']) ? $_POST['pendaftaran_id'] : null);
//			$daftartindakan_id = (isset($_POST['daftartindakan_id']) ? $_POST['daftartindakan_id'] : "");
			$obatalkes_id = isset($_POST['obatalkes_id']) ? $_POST['obatalkes_id'] : null;
			$jumlah = isset($_POST['jumlah']) ? $_POST['jumlah'] : 1;
			$form = "";
			$pesan = "";
			$format = new MyFormatter();
			$modObatAlkesPasien = new RIObatalkespasienT;
//			$modDaftartindakan = DaftartindakanM::model()->findByPk($daftartindakan_id);
			$modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
			$ruangan_id = isset($_POST['ruangan_id']) ? $_POST['ruangan_id'] : Yii::app()->user->getState('ruangan_id');
			$modStokOAs = StokobatalkesT::getStokObatAlkesAktif($obatalkes_id, $jumlah, $ruangan_id);

			if(count($modStokOAs) > 0){
				foreach($modStokOAs AS $i => $stok){
					$modObatAlkesPasien->sumberdana_id = (isset($stok->penerimaandetail->sumberdana_id) ? $stok->penerimaandetail->sumberdana_id : $stok->obatalkes->sumberdana_id);
					$modObatAlkesPasien->obatalkes_id = $stok->obatalkes_id;
					$modObatAlkesPasien->qty_oa = $stok->qtystok_terpakai;
					$modObatAlkesPasien->harganetto_oa = $stok->HPP;
					$modObatAlkesPasien->hargasatuan_oa = $stok->HargaJualSatuan;
					$modObatAlkesPasien->qty_stok = $stok->qtystok;
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
					$modObatAlkesPasien->satuankecil_id = $stok->satuankecil_id;
					$modObatAlkesPasien->satuankecil_nama = $stok->satuankecil->satuankecil_nama;
					$modObatAlkesPasien->obatalkes_nama = $stok->obatalkes->obatalkes_nama;
					$modObatAlkesPasien->ruangan_id = $ruangan_id;

					$form .= $this->renderPartial('_formAddPemakaianBahan', array('modObatAlkesPasien'=>$modObatAlkesPasien,
					'modPendaftaran'=>$modPendaftaran), true);
				}
			}else{
				$pesan = "Stok tidak mencukupi!";
			}

			echo CJSON::encode(array('form'=>$form, 'pesan'=>$pesan));
			Yii::app()->end(); 
		}
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
	   $modStokOaNew->create_ruangan = Yii::app()->user->getState('ruangan_id');

	   if($modStokOaNew->validateStok()){ 
		   $modStokOaNew->save();
		   $modStokOaNew->setStokOaAktifBerdasarkanStok();
	   } else {
		   $this->stokobatalkestersimpan &= false;
	   }
	   return $modStokOaNew;      
   }
   
   /**
	* untuk form tambah obat alkes
	* di copy dari laboratorium/pemakaianBmhpController
	*/
   public function actionAutocompleteObatAlkes()
   {
	   if(Yii::app()->request->isAjaxRequest)
	   {
		   $criteria = new CDbCriteria();
		   $criteria->join = "JOIN sumberdana_m ON sumberdana_m.sumberdana_id = t.sumberdana_id 
						   JOIN satuankecil_m ON satuankecil_m.satuankecil_id = t.satuankecil_id
						   LEFT JOIN jenisobatalkes_m ON jenisobatalkes_m.jenisobatalkes_id = t.jenisobatalkes_id
						   ";
		   $criteria->compare('LOWER(t.obatalkes_nama)', strtolower($_GET['term']), true);
		   $criteria->addCondition('obatalkes_farmasi = TRUE');
		   $criteria->addCondition('obatalkes_aktif = true');
		   $criteria->order = 'obatalkes_nama';
		   $criteria->limit = 5;
		   $models = ObatalkesM::model()->findAll($criteria);
		   $format = new MyFormatter();
		   foreach($models as $i=>$model)
		   {
			   $attributes = $model->attributeNames();

			   foreach($attributes as $j=>$attribute) {
				   $returnVal[$i]["$attribute"] = $model->$attribute;
			   }
			   $qty_stok = StokobatalkesT::getJumlahStok($model->obatalkes_id, Yii::app()->user->getState('ruangan_id'));
			   $returnVal[$i]['label'] = $model->obatalkes_kode." - ".$model->obatalkes_nama." - Jumlah Stok ".$qty_stok;
			   $returnVal[$i]['value'] = $model->obatalkes_nama;
			   $returnVal[$i]['qty_stok'] = $qty_stok;
			   $returnVal[$i]['satuankecil_nama'] = $model->satuankecil->satuankecil_nama;
		   }
		   echo CJSON::encode($returnVal);
	   }
	   Yii::app()->end();
   }

}