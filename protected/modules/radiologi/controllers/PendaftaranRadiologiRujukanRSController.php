

<?php
Yii::import('radiologi.controllers.PendaftaranRadiologiController');
class PendaftaranRadiologiRujukanRSController extends PendaftaranRadiologiController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column1';
	public $defaultAction = 'index';
	public $path_view = "radiologi.views.pendaftaranRadiologiRujukanRS.";
	public $path_view_pendaftaran = "radiologi.views.pendaftaranRadiologi.";
	public $obatalkespasientersimpan = true; //di looping
	public $stokobatalkestersimpan = true; //looping

	/**
	 * Tambah / Ubah Pemeriksaan Radiologi.
	 */
	public function actionIndex($pasienmasukpenunjang_id=null,$pendaftaran_id = null,$instalasi_id = null)
	{
		$format = new MyFormatter();
		$modKunjungan=new ROPasienKirimKeUnitLainV;
		$modKunjungan->ruangan_id = Yii::app()->user->getState("ruangan_id");
		$modPemeriksaanRad = new ROTarifpemeriksaanradruanganV;
		$modPasienMasukPenunjang = new ROPasienmasukpenunjangT;
		$modPasienMasukPenunjang->ruangan_id = Yii::app()->user->getState("ruangan_id");
		$modTindakan=new ROTindakanpelayananT;
		$modObatAlkesPasien = new ROObatalkespasienT;
		$dataTindakans = array(); 
		
		$nama_modul = Yii::app()->controller->module->id;
		$nama_controller = Yii::app()->controller->id;
		$nama_action = Yii::app()->controller->action->id;
		$modul_id = ModulK::model()->findByAttributes(array('url_modul'=>$nama_modul))->modul_id;
		$criteria = new CDbCriteria;
		$criteria->compare('modul_id',$modul_id);
		$criteria->compare('LOWER(modcontroller)',strtolower($nama_controller),true);
		$criteria->compare('LOWER(modaction)',strtolower($nama_action),true);
		
               // var_dump($_POST); die;
                
                if(isset($_POST['tujuansms'])){
			$criteria->addInCondition('tujuansms',$_POST['tujuansms']);
		}
                
		$modSmsgateway = SmsgatewayM::model()->findAll($criteria);
                
                $modPemeriksaanRad->kelaspelayanan_id = Params::KELASPELAYANAN_ID_TANPA_KELAS;
		
		if(isset($_GET['pasienkirimkeunitlain_id'])){
			$modKunjungan = ROPasienKirimKeUnitLainV::model()->findByAttributes(array('pasienkirimkeunitlain_id'=>$_GET['pasienkirimkeunitlain_id']));
			$modPasienMasukPenunjang->pasienkirimkeunitlain_id = isset($modKunjungan->pasienkirimkeunitlain_id) ? $modKunjungan->pasienkirimkeunitlain_id:"";
			$modPasienMasukPenunjang->jeniskasuspenyakit_id = isset($modKunjungan->jeniskasuspenyakit_id) ? $modKunjungan->jeniskasuspenyakit_id:"";
			$modPasienMasukPenunjang->kelaspelayanan_id = isset($modKunjungan->kelaspelayanan_id) ? $modKunjungan->kelaspelayanan_id:"";
		}
		if(isset($_GET['pendaftaran_id'])){
			$modKunjungan = ROInfokunjunganrjrdriV::model()->findByAttributes(array('pendaftaran_id'=>$_GET['pendaftaran_id'],'instalasi_id'=>$_GET['instalasi_id']));
			$modKunjungan->instalasiasal_id = $modKunjungan->instalasi_id;
			$modKunjungan->instalasiasal_nama = $modKunjungan->instalasi_nama;
			$modKunjungan->ruanganasal_id = $modKunjungan->ruangan_id;
			$modKunjungan->ruanganasal_nama = $modKunjungan->ruangan_nama;
			$modKunjungan->nama_bin = $modKunjungan->alias;
			$modPasienMasukPenunjang->pasienkirimkeunitlain_id = isset($modKunjungan->pasienkirimkeunitlain_id) ? $modKunjungan->pasienkirimkeunitlain_id : null;
			$modPasienMasukPenunjang->jeniskasuspenyakit_id = isset($modKunjungan->jeniskasuspenyakit_id) ? $modKunjungan->jeniskasuspenyakit_id : null;
			$modPasienMasukPenunjang->kelaspelayanan_id = isset($modKunjungan->kelaspelayanan_id) ? $modKunjungan->kelaspelayanan_id : null;
		}
		
		if(!empty($pasienmasukpenunjang_id)){
			$modPasienMasukPenunjang = ROPasienmasukpenunjangT::model()->findByPk($pasienmasukpenunjang_id);
			$loadModKunjungan = ROPasienMasukPenunjangV::model()->findByAttributes(array('pasienmasukpenunjang_id'=>$pasienmasukpenunjang_id));
			if(isset($loadModKunjungan)){
				$modKunjungan = $loadModKunjungan;
			}
		}

		if(isset($_POST['ROPasienmasukpenunjangT']))
		{
                        //var_dump($_POST);
			if(!empty($_POST['ROPasienmasukpenunjangT']['pasienkirimkeunitlain_id'])){
				$modKunjungan = ROPasienKirimKeUnitLainV::model()->findByAttributes(array('pasienkirimkeunitlain_id'=>$_POST['ROPasienmasukpenunjangT']['pasienkirimkeunitlain_id']));
			}else{
				$modKunjungan = ROInfokunjunganrjrdriV::model()->findByAttributes(array('pendaftaran_id'=>$_GET['pendaftaran_id'],'instalasi_id'=>$_GET['instalasi_id']));
			}    
			$modPendaftaran = ROPendaftaranT::model()->findByPk($_POST['pendaftaran_id']);
			$transaction = Yii::app()->db->beginTransaction();
			
			try {
				
				$modPasienMasukPenunjang = $this->simpanPasienMasukPenunjang($modPasienMasukPenunjang,$modPendaftaran,$_POST['ROPasienmasukpenunjangT']);
				if(!empty($_POST['ROPasienmasukpenunjangT']['pasienkirimkeunitlain_id'])){
					$pasienkirimterupdate = PasienkirimkeunitlainT::model()->updateByPk($modPasienMasukPenunjang->pasienkirimkeunitlain_id,array('pasienmasukpenunjang_id'=>$modPasienMasukPenunjang->pasienmasukpenunjang_id));
				}else{
					$pasienkirimterupdate = true;
				}
                                
                                //var_dump($modPasienMasukPenunjang->attributes); die;
				
				if(isset($_POST['ROTindakanpelayananT'])){
					if(count($_POST['ROTindakanpelayananT']) > 0){
						
						foreach($_POST['ROTindakanpelayananT'] AS $ii => $tindakan){
							if(!empty($tindakan['tindakanpelayanan_id'])){ 
								$dataTindakans[$ii] = ROTindakanpelayananT::model()->findByPk($tindakan['tindakanpelayanan_id']);
								$dataTindakans[$ii]->attributes = $modPasienMasukPenunjang->attributes;
								$dataTindakans[$ii]->qty_tindakan = $tindakan['qty_tindakan'];
								$dataTindakans[$ii]->tarif_tindakan = ($tindakan['tarif_tindakan']);
								$dataTindakans[$ii]->dokterpemeriksa1_id=$modPasienMasukPenunjang->pegawai_id;
								$dataTindakans[$ii]->perawat_id = (!empty($modPasienMasukPenunjang->perawat_id) ? $modPasienMasukPenunjang->perawat_id : null);
								$dataTindakans[$ii]->update();
                                                                $modHasilPemeriksaan = $this->simpanHasilPemeriksaanRad($modPasienMasukPenunjang, $dataTindakans[$ii], $tindakan);
							}else{ 
								$dataTindakans[$ii] = $this->simpanTindakanPelayanan($modPendaftaran,$modPasienMasukPenunjang,$tindakan);
								$modHasilPemeriksaan = $this->simpanHasilPemeriksaanRad($modPasienMasukPenunjang, $dataTindakans[$ii], $tindakan);
							}
							//untuk ditampilkan di form
							$dataTindakans[$ii]->pemeriksaanrad_id = $tindakan['pemeriksaanrad_id'];
							$dataTindakans[$ii]->jenistarif_id = $tindakan['jenistarif_id'];
							$dataTindakans[$ii]->tarif_tindakan = $format->formatNumberForUser($tindakan['tarif_tindakan']);
						}
					}
				}

			   if(isset($_POST['ROObatalkespasienT'])){
				 if(count($_POST['ROObatalkespasienT']) > 0){
					//PROSES GROUP DETAIL BERDASARKAN obatalkes_id & akumulasikan jmlmutasi
					$detailGroups = array();
					foreach($_POST['ROObatalkespasienT'] AS $i => $postDetail){
						$modDetails[$i] = new ROObatalkespasienT;
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
					$obathabis = "";
					//PROSES PENGURAIAN OBAT DAN JUMLAH MENJADI STOKOBATALKES_T (METODE ANTRIAN)
					foreach($detailGroups AS $i => $detail){
						$modStokOAs = StokobatalkesT::getStokObatAlkesAktif($detail['obatalkes_id'], $detail['qty_oa'], Yii::app()->user->getState('ruangan_id'));
						if(count($modStokOAs) > 0){
							foreach($modStokOAs AS $i => $stok){
								$modDetails[$i] = $this->simpanObatAlkesPasien($modPasienMasukPenunjang,$stok, $_POST['ROObatalkespasienT']);
								$this->simpanStokObatAlkesOut($stok['stokobatalkes_id'], $modDetails[$i]);
							}
						}else{
							$this->stokobatalkestersimpan &= false;
							$obathabis .= "<br>- ".ObatalkesM::model()->findByPk($detail['obatalkes_id'])->obatalkes_nama;

						}
					}
					//END GROUP
				  }
			   }
				
//                if(isset($_POST['ROObatalkespasienT'])){
//                    if(count($_POST['ROObatalkespasienT']) > 0){
//                        foreach($_POST['ROObatalkespasienT'] AS $ii => $postOa){
//                            $dataOas[$ii] = $this->simpanObatAlkesPasien($modPasienMasukPenunjang,$postOa);
//                        }
//                    }
//                }
				// die;
				if($this->pasienpenunjangtersimpan && $this->tindakanpelayanantersimpan && $this->komponentindakantersimpan && $this->hasilpemeriksaantersimpan && $pasienkirimterupdate && $this->obatalkespasientersimpan && $this->stokobatalkestersimpan){
					
					// SMS GATEWAY
					$modPasien = $modPasienMasukPenunjang->pasien;
					$modPendaftaran = $modPasienMasukPenunjang->pendaftaran;
					$modRuangan = $modPasienMasukPenunjang->ruangan;
					$sms = new Sms();
					$smspasien = 1;
                                        
                                        // var_dump(count($modSmsgateway)); die;
                                        
                                        //var_dump($_POST['tujuansms']); // die;
                                        
					foreach ($modSmsgateway as $i => $smsgateway) {
                                                if (isset($_POST['tujuansms']) && in_array($smsgateway->tujuansms, $_POST['tujuansms'])) {
                                                    
                                                    $isiPesan = $smsgateway->templatesms;

                                                    $attributes = $modPasienMasukPenunjang->getAttributes();
                                                    foreach($attributes as $attributes => $value){
                                                            $isiPesan = str_replace("{{".$attributes."}}",$value,$isiPesan);
                                                    }
                                                    $attributes = $modPasien->getAttributes();
                                                    foreach($attributes as $attributes => $value){
                                                            $isiPesan = str_replace("{{".$attributes."}}",$value,$isiPesan);
                                                    }
                                                    $attributes = $modPendaftaran->getAttributes();
                                                    foreach($attributes as $attributes => $value){
                                                            $isiPesan = str_replace("{{".$attributes."}}",$value,$isiPesan);
                                                    }
                                                    $attributes = $modRuangan->getAttributes();
                                                    foreach($attributes as $attributes => $value){
                                                            $isiPesan = str_replace("{{".$attributes."}}",$value,$isiPesan);
                                                    }

                                                    $isiPesan = str_replace("{{hari}}",MyFormatter::getDayName($modPasienMasukPenunjang->tglmasukpenunjang),$isiPesan);

                                                    if($smsgateway->tujuansms == Params::TUJUANSMS_PASIEN && $smsgateway->statussms){
                                                            if(!empty($modPasien->no_mobile_pasien)){
                                                                    $sms->kirim($modPasien->no_mobile_pasien,$isiPesan);
                                                            }else{
                                                                    $smspasien = 0;
                                                            }
                                                    }
                                                }
					}
					// END SMS GATEWAY
					$transaction->commit();
					Yii::app()->user->setFlash('success', "Data pemeriksaan radiologi berhasil disimpan !");
					$this->redirect(array('index','pasienmasukpenunjang_id'=>$modPasienMasukPenunjang->pasienmasukpenunjang_id,'smspasien'=>$smspasien,'sukses'=>1));
				}else{
					$transaction->rollback();
					Yii::app()->user->setFlash('error',"Data pemeriksaan radiologi gagal disimpan !");
//                        echo "-".$this->pasienpenunjangtersimpan."<br>";
//                        echo "-".$this->tindakanpelayanantersimpan."<br>";
//                        echo "-".$this->komponentindakantersimpan."<br>";
//                        echo "-".$this->hasilpemeriksaantersimpan."<br>";
//                        exit;
				}
			} catch (Exception $exc) {
				$transaction->rollback();
				Yii::app()->user->setFlash('error',"Data pemeriksaan radiologi gagal disimpan !"." ".MyExceptionMessage::getMessage($exc,true));
			}
		}
		
		$modKunjungan->tgl_pendaftaran = $format->formatDateTimeForUser($modKunjungan->tgl_pendaftaran);
		$modKunjungan->tanggal_lahir = $format->formatDateTimeForUser($modKunjungan->tanggal_lahir);

		$this->render('index',array(
			'modKunjungan'=>$modKunjungan,
			'modPemeriksaanRad'=>$modPemeriksaanRad,
			'modPasienMasukPenunjang'=>$modPasienMasukPenunjang,
			'modTindakan'=>$modTindakan,
			'modObatAlkesPasien'=>$modObatAlkesPasien,
			'dataTindakans'=>$dataTindakans,
			'modSmsgateway'=>$modSmsgateway
		));
	}

	
	/**
	 * simpan ROObatalkespasienT
	 * @param type $modPasienMasukPenunjang
	 * @param type $stokOa
	 * @param type $postObatAlkesPasien
	 * @return \ROObatalkespasienT
	 * copy dari : PemakaianBmhpController
	 */
	public function simpanObatAlkesPasien($modPasienMasukPenunjang ,$stokOa, $postObatAlkesPasien){        
		$modObatAlkesPasien = new ROObatalkespasienT;
		$modObatAlkesPasien->attributes = $stokOa->attributes;
		$modObatAlkesPasien->tglpelayanan = date("Y-m-d H:i:s");
		$modObatAlkesPasien->tipepaket_id = Params::TIPEPAKET_ID_NONPAKET;
		$modObatAlkesPasien->ruangan_id = Yii::app()->user->getState('ruangan_id');
		$modObatAlkesPasien->pendaftaran_id = $modPasienMasukPenunjang->pendaftaran_id;
		$modObatAlkesPasien->pasienmasukpenunjang_id = $modPasienMasukPenunjang->pasienmasukpenunjang_id;
		$modObatAlkesPasien->pasienadmisi_id = $modPasienMasukPenunjang->pasienadmisi_id;
		$modObatAlkesPasien->carabayar_id = $modPasienMasukPenunjang->pendaftaran->carabayar_id;
		$modObatAlkesPasien->penjamin_id = $modPasienMasukPenunjang->pendaftaran->penjamin_id;
		$modObatAlkesPasien->pegawai_id = $modPasienMasukPenunjang->pegawai_id;
		$modObatAlkesPasien->shift_id = Yii::app()->user->getState('shift_id');
		$modObatAlkesPasien->pasien_id = $modPasienMasukPenunjang->pasien_id;
		$modObatAlkesPasien->kelaspelayanan_id = $modPasienMasukPenunjang->kelaspelayanan_id;
		$modObatAlkesPasien->tglpelayanan = date ('Y-m-d H:i:s');
		$modObatAlkesPasien->create_loginpemakai_id = Yii::app()->user->id;
		$modObatAlkesPasien->create_ruangan = Yii::app()->user->getState('ruangan_id');
		$modObatAlkesPasien->create_time = date ('Y-m-d H:i:s');
		$modObatAlkesPasien->qty_oa = $stokOa->qtystok_terpakai;
		$modObatAlkesPasien->qty_stok = $stokOa->qtystok;
		$modObatAlkesPasien->harganetto_oa = $stokOa->HPP;
		$modObatAlkesPasien->hargasatuan_oa = $stokOa->HargaJualSatuan;
		$modObatAlkesPasien->hargajual_oa = $modObatAlkesPasien->hargasatuan_oa * $modObatAlkesPasien->qty_oa;
		$modObatAlkesPasien->iurbiaya = $modObatAlkesPasien->hargajual_oa;
		 foreach ($postObatAlkesPasien AS $i => $postDetail) {
			if ($stokOa->obatalkes_id==$postDetail['obatalkes_id']) {
				$modObatAlkesPasien->sumberdana_id = $postDetail['sumberdana_id'];                
				$modObatAlkesPasien->satuankecil_id = $postDetail['satuankecil_id'];                
				$modObatAlkesPasien->qty_stok = $postDetail['qty_stok'];                
			}
		}

		if($modObatAlkesPasien->save()){
			$this->obatalkespasientersimpan &= true;
		}else{
			$this->obatalkespasientersimpan &= false;
		}
		
//        old
//        $modObatAlkesPasien = new ROObatalkespasienT;
//        $modObatAlkesPasien->attributes = $post;
//        $modObatAlkesPasien->tipepaket_id = Params::TIPEPAKET_ID_NONPAKET;
//        $modObatAlkesPasien->ruangan_id = Yii::app()->user->getState('ruangan_id');
//        $modObatAlkesPasien->pendaftaran_id = $modPasienMasukPenunjang->pendaftaran_id;
//        $modObatAlkesPasien->pasienmasukpenunjang_id = $modPasienMasukPenunjang->pasienmasukpenunjang_id;
//        $modObatAlkesPasien->pasienadmisi_id = $modPasienMasukPenunjang->pasienadmisi_id;
//        $modObatAlkesPasien->carabayar_id = $modPasienMasukPenunjang->pendaftaran->carabayar_id;
//        $modObatAlkesPasien->penjamin_id = $modPasienMasukPenunjang->pendaftaran->penjamin_id;
//        $modObatAlkesPasien->pegawai_id = $modPasienMasukPenunjang->pegawai_id;
//        $modObatAlkesPasien->shift_id = Yii::app()->user->getState('shift_id');
//        $modObatAlkesPasien->pasien_id = $modPasienMasukPenunjang->pasien_id;
//        $modObatAlkesPasien->kelaspelayanan_id = $modPasienMasukPenunjang->kelaspelayanan_id;
//        $modObatAlkesPasien->tglpelayanan = date ('Y-m-d H:i:s');
//        $modObatAlkesPasien->create_loginpemakai_id = Yii::app()->user->id;
//        $modObatAlkesPasien->create_ruangan = Yii::app()->user->getState('ruangan_id');
//        $modObatAlkesPasien->create_time = date ('Y-m-d H:i:s');
//        
//        if($modObatAlkesPasien->validate()) {
//            $modObatAlkesPasien->save();
//            StokobatalkesT::kurangiStok($modObatAlkesPasien->qty_oa, $modObatAlkesPasien->obatalkes_id);
//        } else {
//            $this->obatalkespasientersimpan &= false;
//        }
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
	
	/**
	* untuk menampilkan data kunjungan dari autocomplete
	* - no_pendaftaran
	* - no_rekam_medik
	* - nama_pasien
	*/
	public function actionAutocompleteKunjungan()
	{
		if(Yii::app()->request->isAjaxRequest) {
			$format = new MyFormatter();
			$returnVal = array();
			$no_pendaftaran = isset($_GET['no_pendaftaran']) ? $_GET['no_pendaftaran'] : null;
			$no_rekam_medik = isset($_GET['no_rekam_medik']) ? $_GET['no_rekam_medik'] : null;
			$nama_pasien = isset($_GET['nama_pasien']) ? $_GET['nama_pasien'] : null;
			$criteria = new CDbCriteria();
			$criteria->compare('LOWER(no_pendaftaran)', strtolower($no_pendaftaran), true);
			$criteria->compare('LOWER(no_rekam_medik)', strtolower($no_rekam_medik), true);
			$criteria->compare('LOWER(nama_pasien)', strtolower($nama_pasien), true);
			$criteria->order = 'no_pendaftaran, no_rekam_medik, nama_pasien';
			$criteria->limit = 5;
			$models = ROPasienKirimKeUnitLainV::model()->findAll($criteria);
			foreach($models as $i=>$model)
			{
				$attributes = $model->attributeNames();
				foreach($attributes as $j=>$attribute) {
					$returnVal[$i]["$attribute"] = $model->$attribute;
				}
				$returnVal[$i]['label'] = $model->no_pendaftaran.'-'.$model->no_rekam_medik.'-'.$model->nama_pasien.(!empty($model->nama_bin) ? "(".$model->nama_bin.")" : "");
			}

			echo CJSON::encode($returnVal);
		}
		Yii::app()->end();
	}
	
	/**
	 * Mengurai data kunjungan berdasarkan:
	 * - pasienkirimkeunitlain_id
	 * @throws CHttpException
	 */
	public function actionGetDataKunjungan()
	{
		if(Yii::app()->request->isAjaxRequest) {
			$format = new MyFormatter();
			$returnVal = array();
			$model = ROPasienKirimKeUnitLainV::model()->findByAttributes(array('pasienkirimkeunitlain_id'=>$_POST['pasienkirimkeunitlain_id']));
			$attributes = $model->attributeNames();
			foreach($attributes as $j=>$attribute) {
				$returnVal["$attribute"] = $model->$attribute;
			}
			$returnVal["tanggal_lahir"] = $format->formatDateTimeForUser($model->tanggal_lahir);
			$returnVal["tgl_pendaftaran"] = $format->formatDateTimeForUser($model->tgl_pendaftaran);
			$returnVal["namalengkapdokter"] = $model->gelardepan." ".$model->nama_pegawai." ".$model->gelarbelakang_nama;
			echo CJSON::encode($returnVal);
		}
		Yii::app()->end();
	}
	/**
	 * set ROPermintaanKePenunjangT yang sudah ada di database
	 * @params pasienmasukpenunjang_id
	 */
	public function actionSetPermintaanKePenunjang(){
		if(Yii::app()->request->isAjaxRequest) {
			$format = new MyFormatter();
			$rows = "";
			$modPermintaans = ROPermintaanKePenunjangT::model()->findAllByAttributes(array('pasienkirimkeunitlain_id'=>$_POST['pasienkirimkeunitlain_id']));
			if(count($modPermintaans) > 0){
				foreach($modPermintaans AS $i => $modPermintaan){
					$modPemeriksaan = PemeriksaanradM::model()->findByAttributes(array('pemeriksaanrad_id'=>$modPermintaan->pemeriksaanrad_id));
					if(isset($modPemeriksaan->daftartindakan_id)){
						$modPermintaan->daftartindakan_id = $modPemeriksaan->daftartindakan_id;
						$rows .= $this->renderPartial($this->path_view."_rowPermintaanKePenunjang",array('i'=>0,'modPermintaan'=>$modPermintaan), true);
					}
				}
			}
			echo CJSON::encode(array(
					'rows'=>$rows));
		}
		Yii::app()->end();
	}
	
	/**
	 * set ROTindakanpelayananT yang sudah ada di database
	 * @params pasienmasukpenunjang_id
	 */
	public function actionSetTindakanPelayanan(){
		if(Yii::app()->request->isAjaxRequest) {
			$format = new MyFormatter();
			$rows = "";
			$modTindakans = ROTindakanpelayananT::model()->findAllByAttributes(array('pasienmasukpenunjang_id'=>$_POST['pasienmasukpenunjang_id']), 'karcis_id IS NULL');
			if(count($modTindakans) > 0){
				foreach($modTindakans AS $i => $modTindakan){
					$modTindakan->pemeriksaanrad_id = PemeriksaanradM::model()->findByAttributes(array('daftartindakan_id'=>$modTindakan->daftartindakan_id))->pemeriksaanrad_id;
					$modTindakan->jenistarif_id = JenistarifpenjaminM::model()->findByAttributes(array('penjamin_id'=>$modTindakan->pendaftaran->penjamin_id))->jenistarif_id;
					$modTindakan->tarif_tindakan = $format->formatNumberForUser($modTindakan->tarif_tindakan);
					$rows .= $this->renderPartial($this->path_view_pendaftaran."_rowTindakanPemeriksaan",array('i'=>0, 'modTindakan'=>$modTindakan), true);
				}
			}
			echo CJSON::encode(array(
					'rows'=>$rows));
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
			$obatalkes_id = isset($_POST['obatalkes_id']) ? $_POST['obatalkes_id'] : null;
			$jumlah = isset($_POST['jumlah']) ? $_POST['jumlah'] : 1;
			$form = "";
			$pesan = "";
			$format = new MyFormatter();
			$modObatAlkesPasien = new ROObatalkespasienT;
			$ruangan_id = Yii::app()->user->getState('ruangan_id');
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
					
					$form .= $this->renderPartial($this->path_view.'_rowObatAlkesPasien', array('modObatAlkesPasien'=>$modObatAlkesPasien), true);
				}
			}else{
				$pesan = "Stok tidak mencukupi!";
			}
			
			echo CJSON::encode(array('form'=>$form, 'pesan'=>$pesan));
			Yii::app()->end(); 
		}
	}
	
	/**
		 * simpan ROHasilpemeriksaanradT
		 */
		public function simpanHasilPemeriksaanRad($modPasienMasukPenunjang, $modTindakan, $post){
			$modHasilPemeriksaan = new ROHasilpemeriksaanradT;
			$modHasilPemeriksaan->attributes = $modPasienMasukPenunjang->attributes;
			$modHasilPemeriksaan->tindakanpelayanan_id = $modTindakan->tindakanpelayanan_id;
			$modHasilPemeriksaan->pemeriksaanrad_id = $post['pemeriksaanrad_id'];
			$modHasilPemeriksaan->tglpemeriksaanrad = $modPasienMasukPenunjang->tglmasukpenunjang;
			$modHasilPemeriksaan->create_time = date("Y-m-d H:i:s");
			$modHasilPemeriksaan->create_loginpemakai_id = Yii::app()->user->id;
			$modHasilPemeriksaan->create_ruangan = $modPasienMasukPenunjang->ruangan_id;
			if(empty($modTindakan->tgl_tindakan)){ 
				$modTindakan->tgl_tindakan=date('Y-m-d H:i:s');
			}
			
			if($modHasilPemeriksaan->validate()){
				$modHasilPemeriksaan->save();
				//RND-8272
				$dataBroker = $modHasilPemeriksaan->getDataBroker();
				if(!empty($dataBroker)){
					CustomFunction::postHL7Broker("ADD",$dataBroker);
				}
			
				$modTindakan->hasilpemeriksaanrad_id = $modHasilPemeriksaan->hasilpemeriksaanrad_id;
				$modTindakan->update();
			}else{
				$this->hasilpemeriksaantersimpan = false;
			}
			
		}
		
		
		/**
		 * proses simpan ROTindakanpelayananT dan ROTindakankomponenT
		 */
		public function simpanTindakanPelayanan($modPendaftaran, $modPasienMasukPenunjang, $post){
			$modTindakan = new ROTindakanpelayananT;
			
			$modTindakan->attributes = $modPendaftaran->attributes;
			$modTindakan->attributes = $modPasienMasukPenunjang->attributes;
			$modTindakan->pendaftaran_id = $modPendaftaran->pendaftaran_id;
			$modTindakan->attributes = $post;
			$modTindakan->instalasi_id = $modTindakan->ruangan->instalasi_id;
			$modTindakan->tarif_satuan = $modTindakan->getTarifSatuan(); //RND-7248
			$modTindakan->karcis_id = (isset($post['karcis_id']) ? $post['karcis_id'] : null);
			if(!empty($modTindakan->karcis_id)){
				$this->karcistersimpan = true;
				if(isset($post['harga_tariftindakan'])){ //jika dari form karcis
					if(!empty($post['harga_tariftindakan'])){
						$modTindakan->tarif_satuan = $post['harga_tariftindakan'];
					}
				}
				$modTindakan->tipepaket_id = $this->tipePaketKarcis($modPendaftaran, $modTindakan->karcis_id, $modTindakan->daftartindakan_id);
			}
			$modTindakan->create_time = date("Y-m-d H:i:s");
			$modTindakan->create_loginpemakai_id = Yii::app()->user->id;
			$modTindakan->create_ruangan = Yii::app()->user->getState('ruangan_id');
			$modTindakan->shift_id =Yii::app()->user->getState('shift_id');
			$modTindakan->dokterpemeriksa1_id=$modPasienMasukPenunjang->pegawai_id;
			$modTindakan->tarif_tindakan=$modTindakan->tarif_satuan * $modTindakan->qty_tindakan;
			if(!empty($_POST['tgl_tindakan_semua'])){
				$modTindakan->tgl_tindakan = MyFormatter::formatDateTimeForDb($_POST['tgl_tindakan_semua']);
			}else{
				$modTindakan->tgl_tindakan=date('Y-m-d H:i:s');
			}
			$modTindakan->cyto_tindakan=0;
			$modTindakan->tarifcyto_tindakan=0;
			$modTindakan->discount_tindakan=0;
			$modTindakan->subsidiasuransi_tindakan=0;
			$modTindakan->subsidipemerintah_tindakan=0;
			$modTindakan->subsisidirumahsakit_tindakan=0;
			$modTindakan->iurbiaya_tindakan=0;
			$modTindakan->tarif_rsakomodasi=0;
			$modTindakan->tarif_medis=0;
			$modTindakan->tarif_paramedis=0;
			$modTindakan->tarif_bhp=0;
			
			if($modTindakan->validate()){ 
				if($modTindakan->save()){
					$this->komponentindakantersimpan &= $modTindakan->saveTindakanKomponen();
				}
			}else{ 
				$this->tindakanpelayanantersimpan &= false;
			}
				
			return $modTindakan;
		}
		
		public function actionSetChecklistPemeriksaanRad(){
            if (Yii::app()->request->isAjaxRequest){
                $content = "";
                parse_str($_POST['data'], $post);
                $postPemeriksaan = $post['ROTarifpemeriksaanradruanganV'];
                if(!empty($postPemeriksaan['ruangan_id']) && !empty($postPemeriksaan['kelaspelayanan_id']) && !empty($postPemeriksaan['penjamin_id'])){
                    $criteria = new CdbCriteria();
                    $criteria->addCondition('ruangan_id = '.$postPemeriksaan['ruangan_id']);
                    $criteria->addCondition('kelaspelayanan_id = '.$postPemeriksaan['kelaspelayanan_id']);
                    $criteria->addCondition('penjamin_id = '.$postPemeriksaan['penjamin_id']);
                    $criteria->compare('LOWER(jenispemeriksaanrad_nama)',strtolower($postPemeriksaan['jenispemeriksaanrad_nama']), true);
                    $criteria->compare('LOWER(pemeriksaanrad_nama)',strtolower($postPemeriksaan['pemeriksaanrad_nama']), true);
                    $criteria->order = "jenispemeriksaanrad_id, pemeriksaanrad_urutan";
                    $modPemeriksaanRads = ROTarifpemeriksaanradruanganV::model()->findAll($criteria);
                    $content = $this->renderPartial($this->path_view_pendaftaran.'_checklistPemeriksaanRad',array('modPemeriksaanRads'=>$modPemeriksaanRads), true);
                }
                echo CJSON::encode(array(
                    'content'=>$content));
                Yii::app()->end();
            }
        }
	
}
