<?php

class RujukanPenunjangController extends MyAuthController
{
	/**
	 * @return array action filters
	 */
    
	public $successSave = false;
         
	public function actionIndex()
	{
            $this->pageTitle = Yii::app()->name." - Pasien Rujukan";
            $model = new PasienkirimkeunitlainV;
            $model->tgl_awal = date('Y-m-d', strtotime('-5 days'));
            $model->tgl_akhir = date('Y-m-d');
            $model->ruangan_id = 12; //Yii::app()->user->getState('ruangan_id');
            
            if (isset($_GET['PasienkirimkeunitlainV'])) {
                $model->attributes = $_GET['PasienkirimkeunitlainV'];
                $model->tgl_awal = MyFormatter::formatDateTimeForDb($_GET['PasienkirimkeunitlainV']['tgl_awal']);
                $model->tgl_akhir = MyFormatter::formatDateTimeForDb($_GET['PasienkirimkeunitlainV']['tgl_akhir']);
            }
            
            $dataProvider = $model->searchRujukBedah();
            /*
            $criteria = new CDbCriteria;
            if(isset($_GET['ajax']) && $_GET['ajax']=='pasienpenunjangrujukan-m-grid') {
                $format = new MyFormatter;
                echo $format->formatDateTimeForDb($_GET['tgl_akhir']);
                $criteria->compare('LOWER(no_pendaftaran)', strtolower($_GET['noPendaftaran']),true);
                $criteria->compare('LOWER(nama_pasien)', strtolower($_GET['namaPasien']),true);
                $criteria->compare('LOWER(no_rekam_medik)', strtolower($_GET['noRekamMedik']),true);
                if (isset($_GET['PasienkirimkeunitlainV'])) {
                    $criteria->compare();
                }
                //if($_GET['cbTglMasuk'])
                    $criteria->addBetweenCondition('DATE(tgl_kirimpasien)', "'".$format->formatDateTimeForDb($_GET['tgl_awal'])."'", "'".$format->formatDateTimeForDb($_GET['tgl_akhir'])."'");
            } else {
                //$criteria->addBetweenCondition('tgl_pendaftaran', date('Y-m-d').' 00:00:00', date('Y-m-d').' 23:59:59');
            }
            $criteria->addCondition('instalasi_id = '.Params::INSTALASI_ID_IBS); //NANTI DIGANTI AMA SESSION, SEMENTARA PAKE PARAM DL
            $criteria->order='tgl_kirimpasien DESC';
            
            $dataProvider = new CActiveDataProvider(PasienkirimkeunitlainV::model(), array(
			'criteria'=>$criteria,
		));
             * 
             */
            $this->render('index',array('dataProvider'=>$dataProvider, 'model'=>$model));
	}
        
        public function actionMasukPenunjang($idPasienKirimKeUnitLain,$pendaftaran_id)
        {            
            $this->pageTitle = Yii::app()->name." - Rencana Operasi";
            $modPendaftaran = BSPendaftaranMp::model()->with('jeniskasuspenyakit')->findByPk($pendaftaran_id);
            $modPasien = BSPasienM::model()->findByPk($modPendaftaran->pasien_id);
            $modOperasi = BSOperasiM::model()->findAllByAttributes(array('operasi_aktif'=>true));
            $modKegiatanOperasi = BSKegiatanOperasiM::model()->findAllByAttributes(array('kegiatanoperasi_aktif'=>true));
            $modPermintaan = BSPermintaanKePenunjangT::model()->findAllByAttributes(array('pasienkirimkeunitlain_id'=>$idPasienKirimKeUnitLain));
            $modPasienKirimKeunitLain = PasienkirimkeunitlainT::model()->findByPk($idPasienKirimKeUnitLain);
            $modRencanaOperasi = new BSRencanaOperasiT;
            $modRencanaOperasi->norencanaoperasi = MyGenerator::noRencanaOperasi();
            $modRencanaOperasi->tglrencanaoperasi = date('Y-m-d h:i:s');
            $modRencanaOperasi->statusoperasi = Params::DEFAULT_STATUS_OPERASI;
            $modPenunjang = new BSMasukPenunjangV;
            $modPenunjangSave = new BSPasienMasukPenunjangT;
                            
            if(isset($_POST['BSRencanaOperasiT'])) {
				
                if(!empty($_POST['operasi_id']))
                {
                    $transaction = Yii::app()->db->beginTransaction();
                    try {
                        if(!empty($_POST['PasienkirimkeunitlainT']['kelaspelayanan_id'])){
                            $modPasienKirimKeunitLain->kelaspelayanan_id = $_POST['PasienkirimkeunitlainT']['kelaspelayanan_id'];
                            $modPasienKirimKeunitLain->update_time = date("Y-m-d H:i:s");
                            $modPasienKirimKeunitLain->update_loginpemakai_id = Yii::app()->user->id;
                            $modPasienKirimKeunitLain->save();
                        }
                        $modPenunjangSave = $this->savePasienPenunjang($modPendaftaran,$modPasienKirimKeunitLain);
                        $modRencanaOperasi = $this->saveRencanaOperasi($modPendaftaran,$modPenunjangSave,$_POST['BSRencanaOperasiT'],$_POST['operasi_id'],null,$_POST['BSTindakanPelayananT']);
                        if ($this->successSave){
                            $transaction->commit();
                            Yii::app()->user->setFlash('success',"Data berhasil disimpan");
                            $module = Yii::app()->controller->module->id.'/DaftarPasien';
                            $this->redirect(array('/'.$module));
                        } else {
                            $transaction->rollback();
                            Yii::app()->user->setFlash('error',"Data gagal disimpan ");
                        }
                    } catch (Exception $exc) {
                        $transaction->rollback();
                        Yii::app()->user->setFlash('error',"Data gagal disimpan ".MyExceptionMessage::getMessage($exc,true));
                    }
                }
                else{
                    Yii::app()->user->setFlash('error',"Data gagal disimpan, anda belum memilih operasi");
                }
            }
            
            
            $modRiwayatKirimKeUnitLain = BSPasienKirimKeUnitLainT::model()->findAllByAttributes(array('pendaftaran_id'=>$pendaftaran_id,
                                                                                                    'ruangan_id'=>Params::RUANGAN_ID_BEDAH,),
                                                                                                    'pasienmasukpenunjang_id IS NULL');
            $modRiwayatPenunjang = BSPasienMasukPenunjangT::model()->findAllByAttributes(array('pendaftaran_id'=>$pendaftaran_id,
                                                                                             'ruangan_id'=>Params::RUANGAN_ID_BEDAH,));
            
            $this->render('masukPenunjang',array('modPermintaan'=>$modPermintaan,
                                        'modRiwayatKirimKeUnitLain'=>$modRiwayatKirimKeUnitLain,
                                        'modKegiatanOperasi'=>$modKegiatanOperasi,
                                        'modOperasi'=>$modOperasi,
                                        'modPendaftaran'=>$modPendaftaran,
                                        'modPasien'=>$modPasien,
                                        'modRiwayatPenunjang'=>$modRiwayatPenunjang,
                                        'modRencanaOperasi'=>$modRencanaOperasi,
                                        'modPenunjang'=>$modPenunjang,
                                        'modPenunjangSave'=>$modPenunjangSave,
                                        'modPasienKirimKeunitLain'=>$modPasienKirimKeunitLain
                          ));
        }
        
        /**
         * Fungsi untuk menyimpan data ke model BSPasienMasukPenunjangT
         * @param type $modPendaftaran
         * @param type $modPasien
         * @return ROPasienMasukPenunjangT 
         */
        protected function savePasienPenunjang($modPendaftaran,$modPasienKirimKeunitLain){
            $modPasienPenunjang = new BSPasienMasukPenunjangT;
            $modPasienPenunjang->pasien_id = $modPendaftaran->pasien_id;
            $modPasienPenunjang->jeniskasuspenyakit_id = $modPendaftaran->jeniskasuspenyakit_id;
            $modPasienPenunjang->pendaftaran_id = $modPendaftaran->pendaftaran_id;
            $modPasienPenunjang->pasienadmisi_id = $modPendaftaran->pasienadmisi_id;
            $modPasienPenunjang->pegawai_id = $modPendaftaran->pegawai_id;
            $modPasienPenunjang->kelaspelayanan_id = $modPasienKirimKeunitLain->kelaspelayanan_id;
            $modPasienPenunjang->ruangan_id = Params::RUANGAN_ID_BEDAH;   //$modPendaftaran->ruangan_id;
            $modPasienPenunjang->no_masukpenunjang = MyGenerator::noMasukPenunjang('BS');
            $modPasienPenunjang->tglmasukpenunjang = date('Y-m-d H:i:s'); 
            $modPasienPenunjang->no_urutperiksa =  MyGenerator::noAntrianPenunjang($modPasienPenunjang->ruangan_id);
            $modPasienPenunjang->kunjungan = $modPendaftaran->kunjungan;
            $modPasienPenunjang->statusperiksa = $modPendaftaran->statusperiksa;
            $modPasienPenunjang->ruanganasal_id = $modPendaftaran->ruangan_id;
            $modPasienPenunjang->pasienkirimkeunitlain_id = $modPasienKirimKeunitLain->pasienkirimkeunitlain_id;

            if ($modPasienPenunjang->validate()){ 
                $modPasienPenunjang->Save();
                $this->successSave = true;
//                $this->updatePasienKirimKeUnitLain($modPasienPenunjang); << TIDAK MENGUPDATE
                $modPasienKirimKeunitLain->pasienmasukpenunjang_id = $modPasienPenunjang->pasienmasukpenunjang_id;
                $modPasienKirimKeunitLain->save();
            } else {
                $this->successSave = false;
            }
            
            return $modPasienPenunjang;
        }
        
        public function saveRencanaOperasi($attrPendaftaran,$attrPenunjang,$attrRencana,$attrOperasi,$attrCeklis,$attrTindakanPelayanan)
        {
            $arrSave = array();
            $validRencana = 'true';
            $arrOperasi = array(); // array untuk menampung operasi yg nantinnya digunakan pada proses saveTindakanPelayanan
            for ($i = 0; $i < count($attrOperasi); $i++) {
                        $format = new MyFormatter();
                        $modRencana = new BSRencanaOperasiT;
                        $modRencana->attributes = $attrRencana;
                        $modRencana->norencanaoperasi = MyGenerator::noRencanaOperasi();
                        $modRencana->pasienmasukpenunjang_id = $attrPenunjang->pasienmasukpenunjang_id;
                        $modRencana->pendaftaran_id = $attrPenunjang->pendaftaran_id;
                        $modRencana->pasien_id = $attrPenunjang->pasien_id;
                        $modRencana->pasienadmisi_id = $attrPenunjang->pasienadmisi_id;
                        
                        $modRencana->dokterpelaksana1_id = $attrRencana['dokterpelaksana1_id'];
                        $modRencana->kamarruangan_id = (!empty($modRencana->kamarruangan_id)) ? $modRencana->kamarruangan_id : null ;
                        $modRencana->dokterpelaksana2_id = (!empty($modRencana->dokterpelaksana2_id)) ? $modRencana->dokterpelaksana2_id : null ;
                        $modRencana->perawat_id = (!empty($modRencana->perawat_id)) ? $modRencana->perawat_id : null ;
                        $modRencana->dokteranastesi_id = (!empty($modRencana->dokteranastesi_id)) ? $modRencana->dokteranastesi_id : null ;
                        
                        
                        $modRencana->selesaioperasi = $format->formatDateTimeForDb($modRencana->tglrencanaoperasi); //sementara di set sama dl, nanti pas proses fix operasi baru di update lg
                        $modRencana->mulaioperasi = $format->formatDateTimeForDb($modRencana->tglrencanaoperasi); //sementara di set sama dl, nanti pas proses fix operasi baru di update lg
                        
                        $modRencana->operasi_id = $attrOperasi[$i];
                        $arrOperasi[$i]=array(
                                            'operasi'=> $attrOperasi[$i]
                                        );
                        
                        $modRencana->create_time=date('Y-m-d H:i:s');
                        $modRencana->create_loginpemakai_id=Yii::app()->user->id;
                        $modRencana->create_ruangan=Yii::app()->user->getState('ruangan_id');
                        
						if ($modRencana->validate()){
							if($modRencana->save()){
								$simpanTindakanPelayanan = $this->saveTindakanPelayanT($attrPendaftaran,$attrPenunjang,$modRencana,$attrTindakanPelayanan,$attrOperasi[$i]);
							}else{
								$this->successSave = TRUE;
							}
						}else{
							$this->successSave = FALSE;

						}
                } //ENDING FOR 
            return $modRencana;
        }
		
		public function saveTindakanPelayanT($attrPendaftaran,$attrPenunjang,$attrRencanaOperasi,$attrTindakanPelayanan,$attrOperasi)
	{

			$modTindakanPelayanan = new BSTindakanPelayananT;
			$modTindakanPelayanan->penjamin_id = $attrPendaftaran->penjamin_id;
			$modTindakanPelayanan->pasien_id = $attrPendaftaran->pasien_id;
			$modTindakanPelayanan->kelaspelayanan_id = $_POST['kelaspelayanan_id'];
			$modTindakanPelayanan->tipepaket_id = 1;
			$modTindakanPelayanan->pendaftaran_id = $attrPendaftaran->pendaftaran_id;
			$modTindakanPelayanan->shift_id = Yii::app()->user->getState('shift_id');
			$modTindakanPelayanan->pasienmasukpenunjang_id = $attrPenunjang->pasienmasukpenunjang_id;
			$modTindakanPelayanan->daftartindakan_id = $attrOperasi['daftartindakan_id'];
			$modTindakanPelayanan->carabayar_id = $attrPendaftaran->carabayar_id;
			$modTindakanPelayanan->jeniskasuspenyakit_id = $attrPendaftaran->jeniskasuspenyakit_id;
			$modTindakanPelayanan->tgl_tindakan = date('Y-m-d H:i:s');
			$modTindakanPelayanan->tarif_satuan = $attrOperasi['tarif_satuan'];
			$modTindakanPelayanan->tarif_tindakan = $attrOperasi['tarif_tindakan'];
			$modTindakanPelayanan->satuantindakan = $attrOperasi['satuantindakan'];
			$modTindakanPelayanan->qty_tindakan = $attrOperasi['qty_tindakan'];
			
			$modTindakanPelayanan->rencanaoperasi_id = $attrRencanaOperasi->rencanaoperasi_id;
			$modTindakanPelayanan->ruangan_id = Yii::app()->user->getState('ruangan_id');
			$modTindakanPelayanan->instalasi_id = Yii::app()->user->getState('instalasi_id');
			$modTindakanPelayanan->cyto_tindakan = 0; //FALSE
			$modTindakanPelayanan->create_time=date('Y-m-d H:i:s');
			$modTindakanPelayanan->update_time=date('Y-m-d H:i:s');
			$modTindakanPelayanan->create_loginpemakai_id=Yii::app()->user->id;
			$modTindakanPelayanan->update_loginpemakai_id=Yii::app()->user->id;
			$modTindakanPelayanan->create_ruangan=Yii::app()->user->getState('ruangan_id');
			
			if($modTindakanPelayanan->cyto_tindakan){
				$modTindakanPelayanan->tarifcyto_tindakan = $modTindakanPelayanan->tarif_tindakan * ($attrTindakanPelayanan['persencyto_tind'][$attrOperasi]/100);
			} else {
				$modTindakanPelayanan->tarifcyto_tindakan = 0;
			}
			$modTindakanPelayanan->discount_tindakan = 0;
			$modTindakanPelayanan->dokterpemeriksa1_id = $attrRencanaOperasi->dokterpelaksana1_id;
			$modTindakanPelayanan->dokterpemeriksa2_id = (!empty($attrRencanaOperasi->dokterpelaksana2)) ? $attrRencanaOperasi->dokterpelaksana2 : null;
			$modTindakanPelayanan->perawat_id = (!empty($attrRencanaOperasi->perawat_id)) ? $attrRencanaOperasi->perawat_id : null;
			$modTindakanPelayanan->subsidiasuransi_tindakan=0;
			$modTindakanPelayanan->subsidipemerintah_tindakan=0;
			$modTindakanPelayanan->subsisidirumahsakit_tindakan=0;
			$modTindakanPelayanan->iurbiaya_tindakan=0;
			if ($modTindakanPelayanan->validate()){
				if($modTindakanPelayanan->save()){
					$modTindakanPelayanan->saveTindakanKomponen();
				}
				$this->successSave = TRUE;

			}else{
				$this->successSave = FALSE;
			}

		return $modTindakanPelayanan;
	}
        
        protected function updatePasienKirimKeUnitLain($modPasienPenunjang) {
            
            if(!empty($_POST['permintaanPenunjang'])){
                foreach($_POST['permintaanPenunjang'] as $i => $item) {
                    PasienkirimkeunitlainT::model()->updateByPk($item['idPasienKirimKeUnitLain'], 
                                                                array('pasienmasukpenunjang_id'=>$modPasienPenunjang->pasienmasukpenunjang_id));
                }
            }
        }
        /**
         * membatalkan rujukan dari daftar pasien rujukan
         */
        public function actionBatalRujuk(){
            if(Yii::app()->request->isAjaxRequest) {
            $pendaftaran_id = $_POST['pendaftaran_id'];
            $idKirimUnit = $_POST['idKirimUnit'];
            PermintaankepenunjangT::model()->deleteAllByAttributes(array('pasienkirimkeunitlain_id'=>$idKirimUnit));
            PasienkirimkeunitlainT::model()->deleteByPk($idKirimUnit);
            $data['status'] = 'ok';
            $data['keterangan']= "<div class='flash-success'>pasien berhasil dibatalkan</div>";

            echo json_encode($data);
             Yii::app()->end();
            }
        }
		
		public function actionLoadFormOperasiMasuk()
		{
			if (Yii::app()->request->isAjaxRequest)
			{
				$idOperasi = $_POST['idOperasi'];
				$idKelasPelayanan = $_POST['idKelasPelayanan'];
	//            echo $idOperasi;exit;
	//            echo $idKelasPelayanan;exit;
				$modOperasi = OperasiM::model()->with('kegiatanoperasi')->findByPk($idOperasi);
				$modTarif = TariftindakanM::model()->findByAttributes(array('daftartindakan_id'=>$modOperasi->daftartindakan_id,
																			'kelaspelayanan_id'=>$idKelasPelayanan,
																			'komponentarif_id'=>Params::KOMPONENTARIF_ID_TOTAL));
				echo CJSON::encode(array(
					'status'=>'create_form', 
					'form'=>$this->renderPartial('_formLoadOperasiMasuk', array('modOperasi'=>$modOperasi,
																				  'modTarif'=>$modTarif,
																				  'idKelasPelayanan'=>$idKelasPelayanan), true)));

				exit;               
			}
		}

	
}