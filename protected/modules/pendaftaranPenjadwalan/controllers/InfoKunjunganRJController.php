<?php

class InfoKunjunganRJController extends MyAuthController
{
    
		public $path_view = 'pendaftaranPenjadwalan.views.infoKunjunganRJ.';
		public $rujukantersimpan = false;
		public $asuransipasientersimpan = false;
		public $septersimpan = false;

		public function actionIndex()
		{
			$format = new MyFormatter();
			$modPPInfoKunjunganRJV = new PPInfoKunjunganRJV;
			$modPPInfoKunjunganRJV->tgl_awal  = date('Y-m-d');
			$modPPInfoKunjunganRJV->tgl_akhir = date('Y-m-d');
			if(isset($_REQUEST['PPInfoKunjunganRJV']))
			{
				$modPPInfoKunjunganRJV->attributes=$_REQUEST['PPInfoKunjunganRJV'];
				$modPPInfoKunjunganRJV->tgl_awal = $format->formatDateTimeForDb($_REQUEST['PPInfoKunjunganRJV']['tgl_awal']);
				$modPPInfoKunjunganRJV->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['PPInfoKunjunganRJV']['tgl_akhir']);
                                $modPPInfoKunjunganRJV->rujukandari_id = $_GET['PPInfoKunjunganRJV']['rujukandari_id'];
				$modPPInfoKunjunganRJV->tgl_awal = $modPPInfoKunjunganRJV->tgl_awal." 00:00:00";
				$modPPInfoKunjunganRJV->tgl_akhir = $modPPInfoKunjunganRJV->tgl_akhir." 23:59:59";
			}
			$this->render($this->path_view.'index',array('format'=>$format,'modPPInfoKunjunganRJV'=>$modPPInfoKunjunganRJV));
		}
        /**
		 * untuk merubah ruangan / poliklinik
		 */
        public function actionUbahRuangan()
        {
            $updatetindakan = false;
			parse_str($_POST['post'],$post);
            $model = PendaftaranT::model()->findByPk($post['pendaftaran_id']);
            $data = array();
			$data['sukses'] = 0;
			$data['pesan'] = "Data perubahan ruangan / poliklinik gagal disimpan! ";
            $transaction = Yii::app()->db->beginTransaction();
            try {
				$sukses = false;
				$modRiwayat = new UbahruanganR;
				$modRiwayat->ruanganawal_id = $model->ruangan_id;
				$modRiwayat->menjadiruangan_id = $post['ruangan_id_ganti'];
				$modRiwayat->alasanperubahan = $post['alasanperubahan'];
				$modRiwayat->pendaftaran_id = $model->pendaftaran_id;
				$modRiwayat->tglperubahan = date('Y-m-d H:i:s');
				$modRiwayat->pasien_id = $model->pasien_id;
                if($modRiwayat->validate()){
					if($modRiwayat->save()){
						$sukses = true;
					}
					$model->ruangan_id = $post['ruangan_id_ganti'];
					$model->jeniskasuspenyakit_id = $post['jeniskasuspenyakit_id_ganti'];
					$model->pegawai_id = $post['pegawai_id_ganti'];
					$model->no_urutantri = MyGenerator::noAntrianJanjiPoli($model->ruangan_id);
					if($model->update()){
						$sukses &= true;
						if(isset($post['is_ubahkarcis'])){ //checked
							$tindakanpelayanan = TindakanpelayananT::model()->findAllByAttributes(array('pendaftaran_id'=>$model->pendaftaran_id),"karcis_id IS NULL");
							if(count($tindakanpelayanan) > 0){
								$data['pesan'] = "Data perubahan ruangan / poliklinik gagal disimpan! Pendaftaran ini sudah pernah input tindakan!";
							}else{
								if(!empty($model->karcis_id)){
									$karcis_id_hapus = $model->karcis_id;
									$model->karcis_id = null;
									$model->update();
									TindakanpelayananT::model()->deleteAllByAttributes(array('pendaftaran_id'=>$model->pendaftaran_id,'karcis_id'=>$karcis_id_hapus));
								}
								$modTindakan = new TindakanpelayananT;
								$modTindakan->attributes = $model->attributes;
								$modTindakan->tgl_tindakan = date("Y-m-d H:i:s");
								$modTindakan->karcis_id = $post['TindakanpelayananT']['idKarcis'];
								$modTindakan->daftartindakan_id = $post['TindakanpelayananT']['idTindakan'];
								$modTindakan->tarif_satuan = $post['TindakanpelayananT']['tarifSatuan'];
								$modTindakan->qty_tindakan = 1;
								$modTindakan->tarif_tindakan = $modTindakan->tarif_satuan * $modTindakan->qty_tindakan;
								$modTindakan->satuantindakan = Params::SATUAN_TINDAKAN_PENDAFTARAN;
								$modTindakan->cyto_tindakan = (!empty($modTindakan->cyto_tindakan) ? $modTindakan->cyto_tindakan : 0);
								$modTindakan->tarifcyto_tindakan = ($modTindakan->cyto_tindakan ? ($modTindakan->tarifcyto_tindakan > 0 ? $modTindakan->tarifcyto_tindakan : 0) : 0);
								$modTindakan->discount_tindakan = 0;
								$modTindakan->subsidiasuransi_tindakan = 0;
								$modTindakan->subsidipemerintah_tindakan = 0;
								$modTindakan->subsisidirumahsakit_tindakan = 0;
								$modTindakan->iurbiaya_tindakan = 0;
								$modTindakan->tipepaket_id = $this->tipePaketKarcis($model,$modTindakan);
								$modTindakan->create_time = date("Y-m-d H:i:s");
								$modTindakan->create_loginpemakai_id = Yii::app()->user->id;
								$modTindakan->validate();
								if($modTindakan->validate()){
									$modTindakan->save();
									$model->karcis_id = $modTindakan->karcis_id;
									$model->update();
									$sukses &= true;
								}else{
									$data['pesan'] = "Data karcis gagal disimpan!";
									$sukses &= false;
								}
							}
							
								
						}
					}else{
						$sukses &= false;
					}
				}

                if ($sukses){
					$data['sukses'] = 1;
					$data['pesan'] = "Data perubahan ruangan / poliklinik berhasil disimpan!";
                    $transaction->commit();
                }else{
                    $transaction->rollback();
                }

            } catch (Exception $exc) {
                $data['pesan'] = 'Gagal Disimpan! '.$exc;
                $transaction->rollback();
            }

            echo CJSON::encode($data);
            Yii::app()->end();

        }
        
        /**
         * method to get type of paket with parameter daftar tindakan, kelaspelayanan, 
         * digunakan di :
         * 1. ActionAjaxController/saveTindakanPelayanan
         * @param object $model PendaftaranT
         * @param object $karcis KarcisM
         * @return int
         */
        public function tipePaketKarcis($model,$karcis)
        {
            $criteria = new CDbCriteria;
            
            $daftartindakan_id = (isset($karcis->daftartindakan_id) ? $karcis->daftartindakan_id : null);
            $criteria->with = array('tipepaket');
			if(!empty($daftartindakan_id)){ $criteria->addCondition("daftartindakan_id = ".$daftartindakan_id); }
			if(!empty($model->carabayar_id)){ $criteria->addCondition("tipepaket.carabayar_id = ".$model->carabayar_id); }
			if(!empty($model->penjamin_id)){ $criteria->addCondition("tipepaket.penjamin_id = ".$model->penjamin_id); }
			if(!empty($model->kelaspelayanan_id)){ $criteria->addCondition("tipepaket.kelaspelayanan_id = ".$model->kelaspelayanan_id); }
            $result = Params::TIPEPAKET_ID_NONPAKET;
            $paket = PaketpelayananM::model()->find($criteria);
                if(isset($paket->tipepaket_id)) $result = $paket->tipepaket_id;

            return $result;
        }
        
        public function actionAjaxGetPenjaminItems()
        {
            if(Yii::app()->request->isAjaxRequest) {
                $idCaraBayar = $_POST['carabayar_id'];
                $idPenjamin = '';
            
                $modPenjamins = PenjaminpasienM::model()->findAllByAttributes(array('carabayar_id'=>$idCaraBayar,'penjamin_aktif'=>true),array('order'=>'penjamin_nama ASC'));

                if(isset($_POST['penjamin_id'])) {
                    $idPenjamin = $_POST['penjamin_id'];
                } 

                $Penjamins=CHtml::listData($modPenjamins,'penjamin_id','penjamin_nama');

                if(empty($Penjamins)){
                    $option = CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
                }else{
                    $option = CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
                    foreach($Penjamins as $value=>$name)
                    {
                        if($value == $idPenjamin)
                            $option .= CHtml::tag('option', array('value'=>$value,'selected'=>true),CHtml::encode($name),true);
                        else
                            $option .= CHtml::tag('option', array('value'=>$value),CHtml::encode($name),true);
                    }
                }
                
                $data['penjamin'] = $option;
                echo CJSON::encode($data);
            }
            Yii::app()->end();
            
        }
        
        public function actionUbahCaraBayar($id = null, $idSep = null)
        {
            $this->layout = '//layouts/iframe';
            $model = new UbahcarabayarR;
            $modPendaftaran = PPPendaftaranT::model()->findByPk($id);
			$modPasien = PPPasienM::model()->findByPk($modPendaftaran->pasien_id);
            $modRujukanBpjs=new PPRujukanbpjsT;
            $modAsuransiPasien=new PPAsuransipasienM;
            $modAsuransiPasienBpjs =new PPAsuransipasienbpjsM;
            $modSep=new PPSepT;

            if(isset($idSep)){
                $modRujukanBpjs= PPRujukanbpjsT::model()->findByPk($modPendaftaran->rujukan_id);
                $modAsuransiPasienBpjs = PPAsuransipasienbpjsM::model()->findByPk($modPendaftaran->asuransipasien_id);
                $modSep = PPSepT::model()->findByPk($idSep);
            }

            if(isset($_POST['UbahcarabayarR']))
            {
                // var_dump($_POST); die;
                $pendaftaran_id = $_POST['pendaftaran_id'];
                $model->attributes = $_POST['UbahcarabayarR'];
                $model->pendaftaran_id = $_POST['pendaftaran_id'];
                $model->carabayar_id = $_POST['PPPendaftaranT']['carabayar_id'];
                $modPendaftaran = PPPendaftaranT::model()->findByPk($pendaftaran_id);
                $model->tglubahcarabayar = date('Y-m-d H:i:s');

                // echo "<pre>"; print_r($model->attributes);exit();
                $transaction = Yii::app()->db->beginTransaction();
                $ok = true;
                try {

                    $modPendaftaran = PPPendaftaranT::model()->findByPk(
                        $model->pendaftaran_id
                    );

                    if(isset($_POST['PPPendaftaranT'])){
                        $modPendaftaran->attributes = $_POST['PPPendaftaranT'];
                    }

                    $modPendaftaran->carabayar_id = $model->carabayar_id;
                    $modPendaftaran->penjamin_id = $model->penjamin_id;
                    $modPendaftaran->status_konfirmasi = "-";
                    $modPendaftaran->asuransipasien_id = null;
                    if($model->save() ){
                            $modPendaftaran->save();
                            $ok = $ok && $this->updateKarcis($modPendaftaran);
                            
                        
                            if(isset($_POST['PPRujukanbpjsT'])){
                                $modRujukanBpjs = $this->simpanRujukanBpjs($modRujukanBpjs, $_POST['PPRujukanbpjsT']);
                            }else{
                                $this->rujukantersimpan = true; 
                            }
                            if(isset($_POST['PPAsuransipasienM'])){
                                if(isset($_POST['PPAsuransipasienM']['asuransipasien_id'])){
                                    if($_POST['PPAsuransipasienM']['asuransipasien_id']==""){
                                        $modAsuransiPasien = PPAsuransipasienM::model()->findByPk($_POST['PPAsuransipasienM']['asuransipasien_id']);
                                    }
                                }
				$modAsuransiPasien = $this->simpanAsuransiPasien($modAsuransiPasien, $modPendaftaran, $modPasien, $_POST['PPAsuransipasienM']);
                                $modPendaftaran->status_konfirmasi = $modAsuransiPasien->status_konfirmasi;
                                $modPendaftaran->tgl_konfirmasi = $modAsuransiPasien->tgl_konfirmasi;
                                $modPendaftaran->asuransipasien_id = $modAsuransiPasien->asuransipasien_id;
                                
                                //var_dump($modPendaftaran->attributes); die;
                                $modPendaftaran->save();
                                
                            }else{
                                $this->asuransipasientersimpan = true;
                                // $modPendaftaran->status_konfirmasi = $modAsuransiPasien->status_konfirmasi;
                                // $modPendaftaran->tgl_konfirmasi = $modAsuransiPasien->tgl_konfirmasi;
                                // $modPendaftaran->asuransipasien_id = $modAsuransiPasien->asuransipasien_id;
                            }
                            if(isset($_POST['PPAsuransipasienbpjsM'])){
                                if(isset($_POST['PPAsuransipasienbpjsM']['asuransipasien_id'])){
                                    if($_POST['PPAsuransipasienbpjsM']['asuransipasien_id']==""){
                                        $modAsuransiPasienBpjs = PPAsuransipasienM::model()->findByPk($_POST['PPAsuransipasienbpjsM']['asuransipasien_id']);
                                    }
                                }
				$modAsuransiPasienBpjs = $this->simpanAsuransiPasien($modAsuransiPasienBpjs, $modPendaftaran, $modPasien, $_POST['PPAsuransipasienbpjsM']);
                                
                                }else{
                                $this->asuransipasientersimpan = true;
                            }
                            
                            
                            
                            if(!empty($modRujukanBpjs->rujukan_id) && !empty($modAsuransiPasienBpjs->asuransipasien_id)){
                                PPPendaftaranT::model()->updateByPk($pendaftaran_id,array('carabayar_id'=>$modPendaftaran->carabayar_id,'penjamin_id'=>$modPendaftaran->penjamin_id,'rujukan_id'=>$modRujukanBpjs->rujukan_id,'asuransipasien_id'=>$modAsuransiPasienBpjs->asuransipasien_id));
                            }else if(!empty($modAsuransiPasien->asuransipasien_id)){
                                PPPendaftaranT::model()->updateByPk($pendaftaran_id,array('carabayar_id'=>$modPendaftaran->carabayar_id,'penjamin_id'=>$modPendaftaran->penjamin_id,'asuransipasien_id'=>$modAsuransiPasien->asuransipasien_id));
                            }else{
                                PPPendaftaranT::model()->updateByPk($pendaftaran_id,array('carabayar_id'=>$modPendaftaran->carabayar_id,'penjamin_id'=>$modPendaftaran->penjamin_id));
                            }

                            if (isset($_POST['PPSepT'])) {
                                $modSep = $this->simpanSep($modPendaftaran,$modPasien,$modRujukanBpjs,$modAsuransiPasienBpjs,$_POST['PPSepT']);								
                            }
                                                        
                            
                        // var_dump($ok); die;
                        //die;
                        if ($ok) {
                            $transaction->commit();
                            if(isset($modSep->nosep)){
                                $this->redirect(array('ubahCaraBayar','id'=>$model->pendaftaran_id,'idSep'=>$modSep->sep_id,'sukses'=>1));
                            }else{
                                $this->redirect(array('ubahCaraBayar','id'=>$model->pendaftaran_id,'sukses'=>1));
                            }
                        } else {
                            $transaction->rollback();
                            Yii::app()->user->setFlash('error',"Data pasien gagal disimpan !");
                        }

                    } else {                
                        $transaction->rollback();
                        Yii::app()->user->setFlash('error',"Data pasien gagal disimpan !");
                    }
                } catch (Exception $exc) {
                    $transaction->rollback();
                    Yii::app()->user->setFlash('error',"Data pasien gagal disimpan !");
                }
            }

            $this->render($this->path_view.'_formUbahCaraBayar',
                array(
                    'model'=>$model,
                    'modPendaftaran'=>$modPendaftaran,
                    'modAsuransiPasien'=>$modAsuransiPasien,
                    'modAsuransiPasienBpjs'=>$modAsuransiPasienBpjs,
                    'modRujukanBpjs'=>$modRujukanBpjs,
                    'modSep'=>$modSep,
                )
            );       
        }        
        
        
        private function updateKarcis($modPendaftaran) {
            
            $ok = true;
            
            $isBaru = $modPendaftaran->statuspasien == 'PENGUNJUNG BARU';
            
            $karcis = KarcisV::model()->findByAttributes(array(
                'penjamin_id'=>$modPendaftaran->penjamin_id,
                'kelaspelayanan_id'=>$modPendaftaran->kelaspelayanan_id,
                'ruangan_id'=>$modPendaftaran->ruangan_id,
                'pasienbaru_karcis'=>$isBaru
            ));
            
            
            $kdat = TindakanpelayananT::model()->findByAttributes(array(
                'pendaftaran_id'=>$modPendaftaran->pendaftaran_id,
                'karcis_id'=>$modPendaftaran->karcis_id,
            ));
            
            // cek tindakan yang sudah bayar, hapus kalo belum dibayar
            // jika pasien yang sudah bayar berpenjamin BPJS/KPS maka tidak bisa mengubah cara bayar
            if (!empty($kdat)) {
                if (!empty($kdat->tindakansudahbayar_id)) {
                    if (!in_array($kdat->carabayar_id, array(Params::CARABAYAR_ID_BPJS, Params::CARABAYAR_ID_JAMKESPA))) {
                        $kdat->carabayar_id = $modPendaftaran->carabayar_id;
                        $kdat->penjamin_id = $modPendaftaran->penjamin_id;
                        return true;
                    } else {
                        return false;
                    }
                }
                
                $ok = $ok && TindakanpelayananT::model()->deleteByPk($kdat->tindakanpelayanan_id);
            }
            
            if (!empty($karcis)) {
            
                $knew = new TindakanpelayananT;
                if (!empty($kdat)) $knew->attributes = $kdat->attributes;
                else {
                    
                    $knew->qty_tindakan = 1;
                    $knew->satuantindakan = Params::SATUAN_TINDAKAN_PENDAFTARAN;
                    $knew->discount_tindakan = 0;
                    $knew->subsidiasuransi_tindakan = 0;
                    $knew->subsidipemerintah_tindakan = 0;
                    $knew->subsisidirumahsakit_tindakan = 0;
                }
                $knew->cyto_tindakan = (!empty($knew->cyto_tindakan) ? $knew->cyto_tindakan : 0);
                $knew->tarifcyto_tindakan = ($knew->cyto_tindakan ? ($knew->tarifcyto_tindakan > 0 ? $knew->tarifcyto_tindakan : 0) : 0);
                $knew->tgl_tindakan = date("Y-m-d H:i:s");
                $knew->tindakanpelayanan_id = null;
                $knew->daftartindakan_id = $karcis->daftartindakan_id;
                $knew->karcis_id = $karcis->karcis_id;
                $knew->tarif_satuan = $knew->tarif_tindakan = $karcis->harga_tariftindakan;
                $knew->tipepaket_id = $this->tipePaketKarcis($modPendaftaran,$knew);
                $knew->iurbiaya_tindakan = $knew->tarif_tindakan;
                $knew->create_time =  $knew->update_time = date("Y-m-d H:i:s");
                $knew->create_loginpemakai_id = $knew->update_loginpemakai_id = Yii::app()->user->id;
                
                if ($knew->validate()) {
                    $ok = $ok && $knew->save();
                    $modPendaftaran->karcis_id = $karcis->karcis_id;
                    $ok = $ok && $modPendaftaran->save();
                } else {
                    //var_dump($knew->errors);
                    $ok = false;
                }
                
                //var_dump($ok);
            }
            
            //var_dump($ok);
            // var_dump($ok, $modPendaftaran->attributes, $isBaru, $karcis->attributes, $kdat->attributes, $knew->attributes);
            //die;
            return $ok;
        }
        
        //==================================Awal batal Periksa============================================================================        
        public function actionUbahPeriksa()
        {
            if (Yii::app()->getRequest()->getIsAjaxRequest()) 
             { 
                $statusperiksa=$_POST['statusperiksa'];
                $pendaftaran_id=$_POST['pendaftaran_id']; 
                $tglbatal = $_POST['tglbatal'];
                $keterangan_batal = $_POST['keterangan_batal'];
//                $data['message']='Masih Dalam Pengembangan Karena TAbel dan View Belum Ada';
                $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
                $modBatalPeriksa = new PasienbatalperiksaR;
                $modBatalPeriksa->pasien_id = $modPendaftaran->pasien_id;
                $modBatalPeriksa->pendaftaran_id = $pendaftaran_id;
                $modBatalPeriksa->tglbatal = $tglbatal;
                $modBatalPeriksa->keterangan_batal = $keterangan_batal;
                $transaction = Yii::app()->db->beginTransaction();
                try {
                    $updatePendaftaran = PendaftaranT::model()->updateByPk($pendaftaran_id, array('statusperiksa'=>Params::STATUSPERIKSA_BATAL_PERIKSA));
                    if($modBatalPeriksa->save() && $updatePendaftaran){
                        PendaftaranT::model()->updateByPk($pendaftaran_id, array('pasienbatalperiksa_id'=>$modBatalPeriksa->pasienbatalperiksa_id));
                        $transaction->commit();
                        $data['message']='Batal periksa berhasil dilakukan.';
                        $data['success']=true;
                    } else {
                        $transaction->rollback();
                        $data['message']='Gagal Batal Periksa! Data tidak valid.';
                        $data['success']=false;
                    }
                } catch (Exception $exc) {
                    $transaction->rollback();
                    $data['message']='Gagal Batal Periksa!';
                }

                
              echo json_encode($data);
                Yii::app()->end();
            }
           
//             Dikomen dulu Bisi Prosesnya Beda N Karena Ada Tabel atwpun view yang Belum Ada
//           $dataTindakanPelID = TindakanpelayananT::model()->findAllByAttributes(array('no_pendaftaran'=>$nopend));
//            if(count($dataTindakanPelID)>0)
//            {    //Jika Tindakan Sudah Dilakukan
//                    if(count($dataTindakanPelID)>0)
//                     {
//                        foreach ($dataTindakanPelID AS $tampilTindakanPelID)
//                        {  
//                            $dataTindakanSudahBayar = TindakansudahbayarT::model()->findAllByAttributes(array('tindakanpel_id'=>$tampilTindakanPelID->tindakanpel_id));
//                            if(count($dataTindakanSudahBayar)>0)
//                            {  //Jika Ada Tindakan Sudah Dibayar
//                                Yii::app()->user->setFlash('error',"No. Pendaftaran ".$nopend." Sudah Melakukan Pembayan Tindakan"); 
//                                $this->redirect(''.bu().'/index.php/pendaftaran/informasiAntrianPasien/index');
////                                $this->redirect($url);
//                            }
//                            else
//                            {   //JIka Tindakab Belum Dibayar
//                                $transaction = Yii::app()->db->beginTransaction();
//                                try
//                                    {
//                                         foreach ($dataTindakanPelID AS $tampilTindakanPelID)
//                                         {  
//                                             $sqlHapusDokterTindakan = "DELETE FROM doktertindakan_t WHERE tindakanpel_id=".$tampilTindakanPelID['tindakanpel_id']."";
//                                             $hapusDokterTindakan = Yii::app()->db->createCommand($sqlHapusDokterTindakan)->queryAll();
//                                             $sqlHapusTindakanKomponen = "DELETE FROM tindakankomponen_t WHERE tindakanpel_id=".$tampilTindakanPelID['tindakanpel_id']."";
//                                             $hapusTindakanKomponen = Yii::app()->db->createCommand($sqlHapusTindakanKomponen)->queryAll();
//                                             $sqlHapusVerifikasiTindakan = "DELETE FROM verifikasitindakan_t WHERE tindakanpel_id=".$tampilTindakanPelID['tindakanpel_id']."";
//                                             $hapusVerifikasiTindakan = Yii::app()->db->createCommand($sqlHapusVerifikasiTindakan)->queryAll(); 
//                                             $sqlHapusParamedisNonParamedis= "DELETE FROM paramedisnonparamedis_t WHERE tindakanpel_id=".$tampilTindakanPelID['tindakanpel_id']."";
//                                             $hapusHapusParamedisNonParamedis = Yii::app()->db->createCommand($sqlHapusParamedisNonParamedis)->queryAll(); 
//                                             $hapusTindakanPelayan = TindakanpelayananT::model()->deleteByPk($tampilTindakanPelID['tindakanpel_id']);
//                                             $updatePendaftaran = PendaftaranT::model()->updateByPK($nopend,array('statusperiksa_id'=>Yii::app()->params['STATUSPERIKSA_BATAL_PERIKSA']));
//                                             $transaction->commit();
//                                             Yii::app()->user->setFlash('success',"Status Periksa No. Pendaftaran ".$nopend." Berhasil Diperbaharui"); 
//                                             header("Location:".bu()."/index.php/pendaftaran/informasiAntrianPasien/index");           
//                                          }
//                                       }
//                                catch (Exception $e)
//                                       {
//                                               $transaction->rollback();
//                                               Yii::app()->user->setFlash('error',"Proses Transaksi No. Pendaftaran ".$nopend." Gagal Diperbaharuiccdc"); 
//                                                header("Location:".bu()."/index.php/pendaftaran/informasiAntrianPasien/index");                                   
//                                       }     
//                            }    
//                        }
//
//                     }
//                    else
//                     { //Hapus Karcis
//                       $transaction = Yii::app()->db->beginTransaction();
//                        try
//                            { 
//                               foreach ($dataTindakanPelID AS $tampilTindakanPelID)
//                                {  
//                                    $sqlHapusDokterTindakan = "DELETE FROM doktertindakan_t WHERE tindakanpel_id=".$tampilTindakanPelID['tindakanpel_id']."";
//                                    $hapusDokterTindakan = Yii::app()->db->createCommand($sqlHapusDokterTindakan)->queryAll();
//                                    $sqlHapusTindakanKomponen = "DELETE FROM tindakankomponen_t WHERE tindakanpel_id=".$tampilTindakanPelID['tindakanpel_id']."";
//                                    $hapusTindakanKomponen = Yii::app()->db->createCommand($sqlHapusTindakanKomponen)->queryAll();
//                                    $sqlHapusVerifikasiTindakan = "DELETE FROM verifikasitindakan_t WHERE tindakanpel_id=".$tampilTindakanPelID['tindakanpel_id']."";
//                                    $hapusVerifikasiTindakan = Yii::app()->db->createCommand($sqlHapusVerifikasiTindakan)->queryAll(); 
//                                    $sqlHapusParamedisNonParamedis= "DELETE FROM paramedisnonparamedis_t WHERE tindakanpel_id=".$tampilTindakanPelID['tindakanpel_id']."";
//                                    $hapusHapusParamedisNonParamedis = Yii::app()->db->createCommand($sqlHapusParamedisNonParamedis)->queryAll(); 
//                                    $hapusTindakanPelayan = TindakanpelayananT::model()->deleteByPk($tampilTindakanPelID['tindakanpel_id']);
//                                    $updatePendaftaran = PendaftaranT::model()->updateByPK($nopend,array('statusperiksa_id'=>Yii::app()->params['STATUSPERIKSA_BATAL_PERIKSA']));
//                                    $transaction->commit();
//                                    Yii::app()->user->setFlash('success',"Status Periksa No. Pendaftaran ".$nopend." Berhasil Diperbaharui"); 
//                                    header("Location:".bu()."/index.php/pendaftaran/informasiAntrianPasien/index");           
//                                }
//                            }
//                         catch (Exception $e)
//                            {
//                             
//                                     $transaction->rollback();
//                                     Yii::app()->user->setFlash('error',"Proses Transaksi No. Pendaftaran ".$nopend." Gagal Diperbaharui zzz"); 
//                                     header("Location:".bu()."/index.php/pendaftaran/informasiAntrianPasien/index");           
//                            
//                             }  
//                    }  
//              } 
//              else
//              {   //Jika BVelum melakukan Tindakan
//                  $updatePendaftaran = PendaftaranT::model()->updateByPK($nopend,array('statusperiksa_id'=>Yii::app()->params['STATUSPERIKSA_BATAL_PERIKSA']));
//                  if($updatePendaftaran)
//                     { //Jika Update Berhasil
//                         Yii::app()->user->setFlash('success',"Status Periksa No. Pendaftaran ".$nopend." Berhasil Diperbaharui"); 
//                          header("Location:".bu()."/index.php/pendaftaran/informasiAntrianPasien/index");           
//                     }
//                  else
//                      { //Jika Updfate Gagal
//                         Yii::app()->user->setFlash('error',"Status Periksa No. Pendaftaran ".$nopend." Gagal Diperbaharui"); 
//                          header("Location:".bu()."/index.php/pendaftaran/informasiAntrianPasien/index");
//                      }  
//              }    
        }
//================================================Akhir batal Periksa===============================================================

        
        //================================================Awal Print Lembar Poli============================================================
        public function actionPrintLembarPoli($pendaftaran_id)
        {
            $this->layout = '//layouts/printLembarPoli';
            $sql = "SELECT pendaftaran_t.no_pendaftaran,
                           pendaftaran_t.no_urutantri,
                           pendaftaran_t.tgl_pendaftaran,
                           pendaftaran_t.umur,
                           ruangan_m.ruangan_nama,
                           pasien_m.no_rekam_medik, 
                           penjaminpasien_m.penjamin_nama, 
                           carabayar_m.carabayar_nama, 
                           pasien_m.jeniskelamin, 
                           pasien_m.nama_pasien, 
                           pasien_m.nama_bin,
                           pasien_m.alamat_pasien, 
                           pasien_m.tanggal_lahir  
                    FROM pendaftaran_t
                    JOIN ruangan_m ON pendaftaran_t.ruangan_id = ruangan_m.ruangan_id
                    JOIN pasien_m ON pendaftaran_t.pasien_id = pasien_m.pasien_id 
                    JOIN carabayar_m ON carabayar_m.carabayar_id = pendaftaran_t.carabayar_id
                    JOIN penjaminpasien_m ON penjaminpasien_m.penjamin_id = pendaftaran_t.penjamin_id
                    
                    WHERE pendaftaran_t.pendaftaran_id ='$pendaftaran_id'";
            $result = Yii::app()->db->createCommand($sql)->queryRow();
//            daftartindakan_m.daftartindakan_nama
//                                       tindakanpelayanan_t.tarif_tindakan

//             tipepaket_m.tipepaket_nama,
//                                LEFT JOIN pegawai_m ON pendaftaran_t.pegawai_id = pegawai_m.pegawai_id
//            LEFT JOIN tindakanpelayanan_t ON tindakanpelayanan_t.no_pendaftaran = pendaftaran_t.no_pendaftaran 
//                    LEFT JOIN daftartindakan_m ON daftartindakan_m.daftartindakan_id = tindakanpelayanan_t.daftartindakan_id
//                    LEFT JOIN tipepaket_m ON tipepaket_m.tipepaket_id = tindakanpelayanan_t.tipepaket_id
// pegawai_m.nama_pegawai,
            $this->render('printLembarPoli',array(
			//'model'=>$model,
                        //'noPendaftaran'=>$idx,
                        'data'=>$result,
		));
        }
//==========================================================Akhir Print Lembar Poli===================================================        
	
        public function actionUbahPasien($id)
	{
                //if(!Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
                $model = $this->loadModel($id);
                $temLogo=$model->photopasien;

                if($_GET['menu'] == 'RJ')
                {
                    $url = $this->module->id.'/'.Yii::app()->controller->id;
                }else if($_GET['menu'] == 'RD')
                {
                    $url = $this->module->id.'/InfoKunjunganRD';
//                    $url = Yii::app()->createUrl($this->module->id.'/InfoKunjunganRD');
                }else if($_GET['menu'] == 'RI')
                {
                    $url = $this->module->id.'/InfoKunjunganRI';
//                    $url = Yii::app()->createUrl($this->module->id.'/InfoKunjunganRI');
                }                
                
                if(isset($_POST['PPPasienM'])) {                   
                    $random=rand(0000000,9999999);
                    $format = new MyFormatter();
                    $model->attributes = $_POST['PPPasienM'];
                    $model->kelompokumur_id = CustomFunction::getKelompokUmur($model->tanggal_lahir);
                    $model->photopasien = CUploadedFile::getInstance($model, 'photopasien');
                    $gambar=$model->photopasien;
                    
                    if(!empty($model->photopasien)) { //if user input the photo of patient
                        $model->photopasien =$random.$model->photopasien;

                         Yii::import("ext.EPhpThumb.EPhpThumb");

                         $thumb=new EPhpThumb();
                         $thumb->init(); //this is needed

                         $fullImgName =$model->photopasien;   
                         $fullImgSource = Params::pathPasienDirectory().$fullImgName;
                         $fullThumbSource = Params::pathPasienTumbsDirectory().'kecil_'.$fullImgName;

                         if($model->save())
                         {
                            if(!empty($temLogo)) { 
                               if(file_exists(Params::pathPasienDirectory().$temLogo))
                                    unlink(Params::pathPasienDirectory().$temLogo);
                               if(file_exists(Params::pathPasienTumbsDirectory().'kecil_'.$temLogo))
                                    unlink(Params::pathPasienTumbsDirectory().'kecil_'.$temLogo);
                            }
                            $gambar->saveAs($fullImgSource);
                            $thumb->create($fullImgSource)
                                 ->resize(200,200)
                                 ->save($fullThumbSource);
//                            $model->tgl_rekam_medik  = $format->formatDateTimeForDb($_POST['PPPasienM']['tgl_rekam_medik']);
                            $model->updateByPk($id, array('tgl_rekam_medik'=>$model->tgl_rekam_medik));
                            Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
                            $this->redirect(array('index'));
                          } else {
                               Yii::app()->user->setFlash('error', 'Data <strong>Gagal!</strong>  disimpan.');
                          }
                    } else { //if user not input the photo
                       $model->photopasien=$temLogo;
                       if($model->save())
                       {
//                            $model->tgl_rekam_medik  = $format->formatDateTimeForDb($_POST['PPPasienM']['tgl_rekam_medik']);
                            $model->updateByPk($id, array('tgl_rekam_medik'=>$model->tgl_rekam_medik));
                            Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
//                            $this->redirect(array('index'));
                            $this->redirect(
                                array('/' . $url . '/index')
                            );
                       }
                    }
                }
                
                $url = Yii::app()->createUrl($url);
		$this->render($this->path_view.'ubahPasien',array('model'=>$model,'url'=>$url));
	}
        
	public function loadModel($id)
	{
            $model=  PPPasienM::model()->findByPk($id);
            if($model===null)
                    throw new CHttpException(404,'The requested page does not exist.');
            return $model;
	}        

        /**
         * untuk mengubah status periksa pasin
         */
        public function actionUbahStatusPeriksaRJ()
        {
           $pendaftaran_id = Yii::app()->session['pendaftaran_id'];
           $format = new MyFormatter();
           $model = PPPendaftaranT::model()->findByPk($pendaftaran_id);
           $model->statusperiksa = Params::STATUSPERIKSA_BATAL_PERIKSA;
           $modBatalPeriksa = new PasienbatalperiksaR;
           $model->tglselesaiperiksa = date('Y-m-d h:i:s');       
           if(isset($_POST['PPPendaftaranT']))
           {
              $update = PPPendaftaranT::model()->updateByPk($pendaftaran_id,array('statusperiksa'=>$_POST['PPPendaftaranT']['statusperiksa'],'tglselesaiperiksa'=>($_POST['PPPendaftaranT']['tglselesaiperiksa'])));
              if(isset($_POST['PendaftaranT']['statusperiksa']) == "BATAL PERIKSA"){
                  $modBatalPeriksa = new PasienbatalperiksaR;
                  $modBatalPeriksa->pendaftaran_id = $pendaftaran_id;
                  $modBatalPeriksa->pasien_id = $model->pasien_id;
                  $modBatalPeriksa->tglbatal = $format->formatDateTimeForDb($_POST['PasienbatalperiksaR']['tglbatal']);
                  $modBatalPeriksa->keterangan_batal = $_POST['PasienbatalperiksaR']['keterangan_batal'];
                  $modBatalPeriksa->create_time = date('Y-m-d');
                  $modBatalPeriksa->update_time = date('Y-m-d');
                  $modBatalPeriksa->create_loginpemakai_id = Yii::app()->user->id;
                  $modBatalPeriksa->update_loginpemakai_id = Yii::app()->user->id;
                  $modBatalPeriksa->create_ruangan = Yii::app()->user->getState('ruangan_id');

                  if($modBatalPeriksa->validate()){
                      if($modBatalPeriksa->save()){
                          PPPendaftaranT::model()->updateByPk($pendaftaran_id,array('pasienbatalperiksa_id'=>$modBatalPeriksa->pasienbatalperiksa_id));

                      }
                  }
                   if (Yii::app()->request->isAjaxRequest)
                   {
                       echo CJSON::encode(array(
                           'status'=>'proses_form', 
                           'div'=>"<div class='flash-success'>Data Pasien <b></b> berhasil disimpan </div>",
                           ));
                       exit;               
                   }
              }

              if($update)
               {
                  if (Yii::app()->request->isAjaxRequest)
                   {
                       echo CJSON::encode(array(
                           'status'=>'proses_form', 
                           'div'=>"<div class='flash-success'>Data Pasien <b></b> berhasil disimpan </div>",
                           ));
                       exit;               
                   }
               }
               else
               {

                   if (Yii::app()->request->isAjaxRequest)
                   {
                       echo CJSON::encode(array(
                           'status'=>'proses_form', 
                           'div'=>"<div class='flash-error'>Data Pasien <b></b> gagal disimpan </div>",
                           ));
                       exit;               
                   }
               }
           }

           if (Yii::app()->request->isAjaxRequest)
           {   
               echo CJSON::encode(array(
                   'status'=>'create_form', 
                   'div'=>$this->renderPartial('_ubahStatusPeriksa', array('model'=>$model,'modBatalPeriksa'=>$modBatalPeriksa),true)));
               exit;               
           }
       }
       
	   public function actionUbahKeteranganPendaftaran()
		{
			$model = new PendaftaranT;
			if(isset($_POST['PendaftaranT']))
			{
				if($_POST['PendaftaranT']['keterangan_pendaftaran'] != "")
				{
					$model->attributes = $_POST['PendaftaranT'];
					$transaction = Yii::app()->db->beginTransaction();
					try {
						$attributes = array('keterangan_pendaftaran'=>$_POST['PendaftaranT']['keterangan_pendaftaran']);
						$save = $model::model()->updateByPk($_POST['PendaftaranT']['pendaftaran_id'], $attributes);
						if($save)
						{
							$transaction->commit();
							echo CJSON::encode(array(
								'status'=>'proses_form', 
								'div'=>"<div class='flash-success'>Berhasil merubah Keterangan Pendaftaran.</div>",
								));
						}else{
							echo CJSON::encode(array(
								'status'=>'proses_form', 
								'div'=>"<div class='flash-error'>Data gagal disimpan.</div>",
								));                    
						}
						exit;
					}catch(Exception $exc) {
						$transaction->rollback();
					}
				}else{
					echo CJSON::encode(
						array(
							'status'=>'proses_form',
							'div'=>"<div class='flash-success'>Berhasil merubah data Keterangan Pendaftaran.</div>",
						)
					);
					exit;
				}
			}

			if (Yii::app()->request->isAjaxRequest)
			{
				echo CJSON::encode(array(
					'status'=>'create_form', 
					'div'=>$this->renderPartial($this->path_view.'_formUbahKeterangan', array('model'=>$model), true)));
				exit;               
			}
		}
	   
       /**
        * untuk load data dokter di Informasi Kunjungan Rawat Jalan
        */
        public function actionGetDataPendaftaranRJ()
        {
            if (Yii::app()->request->isAjaxRequest){
                $id_pendaftaran = $_POST['pendaftaran_id'];
                $model = InfokunjunganrjV::model()->findByAttributes(array('pendaftaran_id'=>$id_pendaftaran));
                $attributes = $model->attributeNames();
                foreach($attributes as $j=>$attribute) {
                    $returnVal["$attribute"] = $model->$attribute;
                }
                $returnVal["no_pendaftaran"] = $model->no_pendaftaran;
                $returnVal["pendaftaran_id"] = $model->pendaftaran_id;
                $returnVal["gelardepan"] = (isset($model->gelardepan) ? $model->gelardepan : "");
                $returnVal["gelarbelakang_nama"] = (isset($model->gelarbelakang_nama) ? $model->gelarbelakang_nama : "");
                echo json_encode($returnVal);
                Yii::app()->end();
            }
        }
        
         /**
         * menampilkan karcis
         */
        public function actionListKarcis(){
            if(Yii::app()->request->isAjaxRequest) { 
                $kelasPelayanan=$_POST['kelasPelayanan'];
                $ruangan = $_POST['ruangan'];
                $pendaftaran_id= isset($_POST['pendaftaran_id']) ? $_POST['pendaftaran_id']:null;
                $modPendaftaran=  PendaftaranT::model()->findByPk($pendaftaran_id);
                $penjamin_id=$modPendaftaran->penjamin_id;
                $modelKarcis = null;
                $form='';
                if(!empty($ruangan)){
                    $karcis = Yii::app()->user->getState('karcisbarulama');
                    if ($karcis){
                        $pasienLama = (isset($_POST['pasienLama']) ? (($_POST['pasienLama'] > 0) ? false : true) : false);
						$modelKarcis = KarcisV::model()->findByAttributes(array('penjamin_id'=>$penjamin_id,"kelaspelayanan_id"=>$kelasPelayanan,"ruangan_id"=>$ruangan, 'pasienbaru_karcis'=>$pasienLama));        
                    }else{
						$modelKarcis = KarcisV::model()->findByAttributes(array('penjamin_id'=>$penjamin_id,"kelaspelayanan_id"=>$kelasPelayanan,"ruangan_id"=>$ruangan));        
					}
					$modKarcisV=KarcisV::model()->findAll('kelaspelayanan_id='.$kelasPelayanan.' AND ruangan_id='.$ruangan.' AND penjamin_id='.$penjamin_id.'');
                    foreach($modKarcisV AS $tampil){
                        if ($karcis){
                            if($ruangan == Params::RUANGAN_ID_LAB)
                            {
                                $form .='<tr>
                                        <td><a data-karcis="'.$tampil['karcis_id'].'"id="selectPasien" class="btn-small" href="javascript:void(0);" onclick="changeBackground(this,'.$tampil['daftartindakan_id'].','.$tampil['harga_tariftindakan'].','.$tampil['karcis_id'].');return false;">
                                            <i class="icon-form-check"></i>
                                            </a></td>                                    
                                        <td>'.$tampil['karcis_nama'].'</td>
                                        <td>'.CHtml::hiddenField('tarifKarcis', $tampil['harga_tariftindakan']).$tampil['harga_tariftindakan'].'</td>
                                     </tr>';                                
                            }else if($ruangan == Params::RUANGAN_ID_RAD){
                                $form .='<tr>
                                        <td><a data-karcis="'.$tampil['karcis_id'].'"id="selectPasien" class="btn-small" href="javascript:void(0);" onclick="changeBackground(this,'.$tampil['daftartindakan_id'].','.$tampil['harga_tariftindakan'].','.$tampil['karcis_id'].');return false;">
                                            <i class="icon-form-check"></i>
                                            </a></td>                                    
                                        <td>'.$tampil['karcis_nama'].'</td>
                                        <td>'.CHtml::hiddenField('tarifKarcis', $tampil['harga_tariftindakan']).$tampil['harga_tariftindakan'].'</td>
                                     </tr>';
                            }else{
                                    $form .='<tr>
                                            <td>'.$tampil['karcis_nama'].'</td>
                                            <td>'.CHtml::hiddenField('tarifKarcis', $tampil['harga_tariftindakan']).$tampil['harga_tariftindakan'].'</td>
                                            <td><a data-karcis="'.$tampil['karcis_id'].'"id="selectPasien" class="btn-small" href="javascript:void(0);" onclick="changeBackground(this,'.$tampil['daftartindakan_id'].','.$tampil['harga_tariftindakan'].','.$tampil['karcis_id'].');return false;">
                                                <i class="icon-form-check"></i>
                                                </a></td>    
                                         </tr>';
                            }
                        }
                        else{
                            $form .='<tr>
                                    <td>'.$tampil['karcis_nama'].'</td>
                                    <td>'.$tampil['harga_tariftindakan'].'</td>
                                    <td><a data-karcis="'.$tampil['karcis_id'].'"id="selectPasien" class="btn-small" href="javascript:void(0);" onclick="changeBackground(this,'.$tampil['daftartindakan_id'].','.$tampil['harga_tariftindakan'].','.$tampil['karcis_id'].');return false;">
                                        <i class="icon-form-check"></i>
                                        </a></td>    
                                 </tr>';
                        }

                    }
                }
                $data['karcis']=(count($modelKarcis) == true) ? ((isset($modelKarcis->attributes))? $modelKarcis->attributes : 0 ) : 0;
                $data['form']=$form;
                echo json_encode($data);
                Yii::app()->end();
            }
        }
        public function simpanRujukanBpjs($modRujukanBpjs, $post){
            $format = new MyFormatter();
            $modRujukanBpjs->attributes = $post;
            $modRujukanBpjs->kddiagnosa_rujukan = isset($post['kddiagnosa_rujukan']) ? ((count($post['kddiagnosa_rujukan'])>0) ? implode(', ', $post['kddiagnosa_rujukan']) : '') : '';
            $modRujukanBpjs->diagnosa_rujukan = isset($post['diagnosa_rujukan']) ? ((count($post['diagnosa_rujukan'])>0) ? implode(', ', $post['diagnosa_rujukan']) : '') : '';
            $modRujukanBpjs->tanggal_rujukan = $format->formatDateTimeForDb($modRujukanBpjs->tanggal_rujukan);
            
            if($modRujukanBpjs->save()){
                $this->rujukantersimpan = true;
            }
            return $modRujukanBpjs;
        }
        public function simpanAsuransiPasien($modAsuransiPasien, $postPendaftaran, $postPasien, $postAsuransiPasien){
            $format = new MyFormatter();
            $modAsuransiPasien->attributes = $postAsuransiPasien;
            $modAsuransiPasien->pasien_id = isset($postPasien['pasien_id'])?$postPasien['pasien_id']:null;
            $modAsuransiPasien->penjamin_id = isset($postPendaftaran['penjamin_id'])?$postPendaftaran['penjamin_id']:null;
            $modAsuransiPasien->carabayar_id = isset($postPendaftaran['carabayar_id'])?$postPendaftaran['carabayar_id']:null;
            $modAsuransiPasien->create_loginpemakai_id = Yii::app()->user->id;
            $modAsuransiPasien->create_time = date("Y-m-d H:i:s");
            $modAsuransiPasien->tgl_konfirmasi = $format->formatDateTimeForDb($modAsuransiPasien->tgl_konfirmasi);
            
            if (empty($modAsuransiPasien->nopeserta)) $modAsuransiPasien->nopeserta = $modAsuransiPasien->nokartuasuransi;
            
            //var_dump($modAsuransiPasien->attributes);
            
            //$modAsuransiPasien->validate();
            
            //var_dump($modAsuransiPasien->errors);
            
            //die;
            
            if($modAsuransiPasien->save()){
                $this->asuransipasientersimpan = true;
            }
            return $modAsuransiPasien;
        }

        public function simpanSep($model,$modPasien,$modRujukanBpjs,$modAsuransiPasienBpjs,$postSep){
            $reqSep = null;
            $modSep = new PPSepT;
            $bpjs = new Bpjs();

            $modSep->tglsep = date('Y-m-d H:i:s');
            $modSep->nokartuasuransi = $modAsuransiPasienBpjs->nopeserta;
            $modSep->tglrujukan = $modRujukanBpjs->tanggal_rujukan;
            $modSep->norujukan = $modRujukanBpjs->no_rujukan;
            $modSep->ppkrujukan = $postSep['ppkrujukan']; 
            $modSep->ppkpelayanan = Yii::app()->user->getState('ppkpelayanan');
            $modSep->jnspelayanan = ($model->instalasi_id==Params::INSTALASI_ID_RI)?Params::JENISPELAYANAN_RI:Params::JENISPELAYANAN_RJ;
            $modSep->catatansep = $postSep['catatansep'];
            $data_diagnosa = explode(', ', $modRujukanBpjs->diagnosa_rujukan);
            $modSep->diagnosaawal = isset($data_diagnosa[0])?$data_diagnosa[0]:'';
            $modSep->politujuan = $model->ruangan_id;
            $modSep->klsrawat = $modAsuransiPasienBpjs->kelastanggunganasuransi_id;
            $modSep->tglpulang = date('Y-m-d H:i:s');
            $modSep->create_time = date('Y-m-d H:i:s');
            $modSep->create_loginpemakai_id = Yii::app()->user->id;
            $modSep->create_ruangan = Yii::app()->user->getState('ruangan_id');
            
            $reqSep = json_decode($bpjs->create_sep($modSep->nokartuasuransi, $modSep->tglsep, $modSep->tglrujukan, $modSep->norujukan, $modSep->ppkrujukan, $modSep->ppkpelayanan, $modSep->jnspelayanan, $modSep->catatansep, $modSep->diagnosaawal, $modSep->politujuan, $modSep->klsrawat, Yii::app()->user->id, $modPasien->no_rekam_medik, $model->pendaftaran_id),true);
           
            if ($reqSep['metadata']['code']==200) {
                $modSep->nosep = $reqSep['response'];
                if($modSep->save()){
                    $this->septersimpan = true;
                }
            }

            return $modSep;
        }

        public function actionAutocompleteAsuransi()
        {
            if(Yii::app()->request->isAjaxRequest) {
                $format = new MyFormatter();
                $returnVal = array();
                $nopeserta = isset($_GET['nopeserta']) ? $_GET['nopeserta'] : '';
                $penjamin_id = isset($_GET['penjamin_id']) ? $_GET['penjamin_id'] : null;
                $pasien_id = isset($_GET['pasien_id']) ? $_GET['pasien_id'] : null;
                $criteria = new CDbCriteria();
                $criteria->compare('LOWER(nopeserta)', strtolower($nopeserta),true);
                $criteria->addCondition('penjamin_id='.$penjamin_id);
				$criteria->addCondition('asuransipasien_aktif is true');
                if($_GET['pasien_id'] == ""){
                    $criteria->addCondition('pasien_id is null');
                    
                }else{
                    $criteria->addCondition('pasien_id='.$pasien_id);
                }
                $criteria->order = 'namapemilikasuransi';
                $criteria->limit = 5;
                $models = PPAsuransipasienM::model()->findAll($criteria);
                foreach($models as $i=>$model)
                {
                    $attributes = $model->attributeNames();
                    foreach($attributes as $j=>$attribute) {
                        $returnVal[$i]["$attribute"] = $model->$attribute;
                    }
                    $returnVal[$i]['label'] = $model->nopeserta.' - '.$model->namapemilikasuransi;
                    $returnVal[$i]['value'] = $model->nopeserta;
                    $returnVal[$i]['asuransipasien_id'] = $model->asuransipasien_id;
                    $returnVal[$i]['nokartuasuransi'] = $model->nokartuasuransi;
                    $returnVal[$i]['namapemilikasuransi'] = $model->namapemilikasuransi;
                    $returnVal[$i]['jenispeserta_id'] = $model->jenispeserta_id;
                    $returnVal[$i]['nomorpokokperusahaan'] = $model->nomorpokokperusahaan;
                    $returnVal[$i]['namaperusahaan'] = $model->namaperusahaan;
                    $returnVal[$i]['kelastanggunganasuransi_id'] = $model->kelastanggunganasuransi_id;
                }

                             
                echo CJSON::encode($returnVal);
            }else
                throw new CHttpException(403,'Tidak dapat mengurai data');
            Yii::app()->end();
        }

        public function actionUbahKelasPelayanan()
        {
            $model = new PendaftaranT;
            $menu = (isset($_REQUEST['menu']) ? $_REQUEST['menu'] : "");
            if(isset($_POST['PendaftaranT']))
            {
                if($_POST['PendaftaranT']['kelaspelayanan_id'] != "")
                {
                    $model->attributes = $_POST['PendaftaranT'];
                    $transaction = Yii::app()->db->beginTransaction();
                    try {
                        $attributes = array('kelaspelayanan_id'=>$_POST['PendaftaranT']['kelaspelayanan_id']);
                        $save = $model::model()->updateByPk($_POST['PendaftaranT']['pendaftaran_id'], $attributes);
                        if($save)
                        {
                            $transaction->commit();
                            echo CJSON::encode(array(
                                'status'=>'proses_form', 
                                'div'=>"<div class='flash-success'>Berhasil merubah Kelas Pelayanan.</div>",
                                ));
                        }else{
                            echo CJSON::encode(array(
                                'status'=>'proses_form', 
                                'div'=>"<div class='flash-error'>Data gagal disimpan.</div>",
                                ));                    
                        }
                        exit;
                    }catch(Exception $exc) {
                        $transaction->rollback();
                    }
                }else{
                    echo CJSON::encode(
                        array(
                            'status'=>'proses_form',
                            'div'=>"<div class='flash-success'>Berhasil merubah data Kelas Pelayanan.</div>",
                        )
                    );
                    exit;
                }
            }
            
            if (Yii::app()->request->isAjaxRequest)
            {
                echo CJSON::encode(array(
                    'status'=>'create_form', 
                    'div'=>$this->renderPartial($this->path_view.'_formUbahKelasPelayananRJ', array('model'=>$model,'menu'=>$menu), true)));
                exit;               
            }
        }

        /*
         * Mencari kelas pelayanan berdasarkan ruangan_id di tabel KelasruanganM
         * and open the template in the editor.
         */
        public function actionSetDropdownKelasPelayanan()
        {
            if(Yii::app()->request->isAjaxRequest) {
                $ruangan_id = $_POST['ruangan_id'];
                if($ruangan_id){
                    $kelasPelayanan = KelasruanganM::model()->with('kelaspelayanan')->findAll('ruangan_id='.$ruangan_id.' and kelaspelayanan_aktif = true');
                    $kelasPelayanan=CHtml::listData($kelasPelayanan,'kelaspelayanan_id','kelaspelayanan.kelaspelayanan_nama');
                }
                if(empty($kelasPelayanan)){
                    echo CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
                }else{
                    echo CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
                    foreach($kelasPelayanan as $value=>$name)
                    {
                        echo CHtml::tag('option', array('value'=>$value),CHtml::encode($name),true);
                    }
                }
            }
            Yii::app()->end();
        }
		
		/**
         * untuk drop down rujukan
         */
        public function actionGetRujukanDari($encode=false,$namaModel='')
        {
            if(Yii::app()->request->isAjaxRequest) {
                $asalrujukan_id = $_POST["$namaModel"]['asalrujukan_id'];

               if($encode) {
                    echo CJSON::encode($rujukandari);
               } else {
                    if(empty($asalrujukan_id)){
                        echo CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
                    } else {
                            echo CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
                            $rujukandari = RujukandariM::model()->findAllByAttributes(array('asalrujukan_id'=>$asalrujukan_id), array('order'=>'namaperujuk'));
                            $rujukandari = CHtml::listData($rujukandari,'rujukandari_id','namaperujuk');
                            foreach($rujukandari as $value=>$name) {
                                echo CHtml::tag('option', array('value'=>$value),CHtml::encode($name),true);
                            }

                    }
               }
            }
            Yii::app()->end();
        }
		
		/**
         * Mengatur dropdown kabupaten
         * @param type $encode jika = true maka return array jika false maka set Dropdown 
         * @param type $model_nama
         * @param type $attr
         */
        public function actionSetDropdownKabupaten($encode=false,$model_nama='',$attr='')
        {
            if(Yii::app()->request->isAjaxRequest) {
                $modPasien = new PPPasienM;
                if($model_nama !=='' && $attr == ''){
                    $propinsi_id = $_POST["$model_nama"]['propinsi_id'];
                }
                 elseif ($model_nama == '' && $attr !== '') {
                    $propinsi_id = $_POST["$attr"];
                }
                 elseif ($model_nama !== '' && $attr !== '') {
                    $propinsi_id = $_POST["$model_nama"]["$attr"];
                }
                $kabupaten = null;
                if($propinsi_id){
                    $kabupaten = $modPasien->getKabupatenItems($propinsi_id);
                    $kabupaten = CHtml::listData($kabupaten,'kabupaten_id','kabupaten_nama');
                }
                if($encode){
                    echo CJSON::encode($kabupaten);
                } else {
                    if(empty($kabupaten)){
                        echo CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
                    } else {
                        echo CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
                        foreach($kabupaten as $value=>$name) {
                            echo CHtml::tag('option', array('value'=>$value),CHtml::encode($name),true);
                        }
                    }
                }
            }
            Yii::app()->end();
        }
        /**
         * Mengatur dropdown kecamatan
         * @param type $encode jika = true maka return array jika false maka set Dropdown 
         * @param type $model_nama
         * @param type $attr
         */
        public function actionSetDropdownKecamatan($encode=false,$model_nama='',$attr='')
        {
            if(Yii::app()->request->isAjaxRequest) {
                $modPasien = new PPPasienM;
                if($model_nama !=='' && $attr == ''){
                    $kabupaten_id = $_POST["$model_nama"]['kabupaten_id'];
                }
                 elseif ($model_nama == '' && $attr !== '') {
                    $kabupaten_id = $_POST["$attr"];
                }
                 elseif ($model_nama !== '' && $attr !== '') {
                    $kabupaten_id = $_POST["$model_nama"]["$attr"];
                }
                $kecamatan = null;
                if($kabupaten_id){
                    $kecamatan = $modPasien->getKecamatanItems($kabupaten_id);
                    $kecamatan = CHtml::listData($kecamatan,'kecamatan_id','kecamatan_nama');
                }

                if($encode){
                    echo CJSON::encode($kecamatan);
                } else {
                    if(empty($kecamatan)){
                        echo CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
                    }else{
                        echo CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
                        foreach($kecamatan as $value=>$name)
                        {
                            echo CHtml::tag('option', array('value'=>$value),CHtml::encode($name),true);
                        }
                    }
                }
            }
            Yii::app()->end();
        }
        /**
         * Mengatur dropdown kelurahan
         * @param type $encode jika = true maka return array jika false maka set Dropdown 
         * @param type $model_nama
         * @param type $attr
         */
        public function actionSetDropdownKelurahan($encode=false,$model_nama='',$attr='')
        {
            if(Yii::app()->request->isAjaxRequest) {
                $modPasien = new PPPasienM;
                if($model_nama !=='' && $attr == ''){
                    $kecamatan_id = $_POST["$model_nama"]['kecamatan_id'];
                }
                 elseif ($model_nama == '' && $attr !== '') {
                    $kecamatan_id = $_POST["$attr"];
                }
                elseif ($model_nama !== '' && $attr !== '') {
                    $kecamatan_id = $_POST["$model_nama"]["$attr"];
                }
                $kelurahan = null;
                if($kecamatan_id){
                    $kelurahan = $modPasien->getKelurahanItems($kecamatan_id);
//                    $kelurahan = KelurahanM::model()->findAll('kecamatan_id='.$kecamatan_id.'');
                    $kelurahan = CHtml::listData($kelurahan,'kelurahan_id','kelurahan_nama');
                }

                if($encode){
                    echo CJSON::encode($kelurahan);
                } else {
                    if(empty($kelurahan)){
                        echo CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
                    }else{
                        echo CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
                        foreach($kelurahan as $value=>$name)
                        {
                            echo CHtml::tag('option', array('value'=>$value),CHtml::encode($name),true);
                        }
                    }
                }
            }
            Yii::app()->end();
        }
        /**
         * set dropdown daerah pasien berdasarkan
         * propinsi_id
         * kabupaten_id
         * kecamatan_id
         * kelurahan_id
         * pasien_id
         */
        public function actionSetDropdownDaerahPasien()
        {
            if(Yii::app()->getRequest()->getIsAjaxRequest()) {
                $modPasien = new PPPasienM;
                $propinsi_id = $_POST['propinsi_id'];
                $kabupaten_id = $_POST['kabupaten_id'];
                $kecamatan_id = $_POST['kecamatan_id'];
                $kelurahan_id = (isset($_POST['kelurahan_id']) ? $_POST['kelurahan_id'] : null);

                $propinsis = PropinsiM::model()->findAll('propinsi_aktif = TRUE');
                $propinsis = CHtml::listData($propinsis,'propinsi_id','propinsi_nama');
                $propinsiOption = CHtml::tag('option',array('value'=>''),"-- Pilih --",true);
                foreach($propinsis as $value=>$name)
                {
                    if($value==$propinsi_id)
                        $propinsiOption .= CHtml::tag('option',array('value'=>$value,'selected'=>true),CHtml::encode($name),true);
                    else
                        $propinsiOption .= CHtml::tag('option',array('value'=>$value),CHtml::encode($name),true);
                }
                $kabupatens = $modPasien->getKabupatenItems($propinsi_id);
//                $kabupatens = KabupatenM::model()->findAllByAttributes(array('propinsi_id'=>$propinsi_id,'kabupaten_aktif'=>true,));
                $kabupatens = CHtml::listData($kabupatens,'kabupaten_id','kabupaten_nama');
                $kabupatenOption = CHtml::tag('option',array('value'=>''),"-- Pilih --",true);
                foreach($kabupatens as $value=>$name)
                {
                    if($value==$kabupaten_id)
                        $kabupatenOption .= CHtml::tag('option',array('value'=>$value,'selected'=>true),CHtml::encode($name),true);
                    else
                        $kabupatenOption .= CHtml::tag('option',array('value'=>$value),CHtml::encode($name),true);
                }
                $kecamatans = $modPasien->getKecamatanItems($kabupaten_id);
//                $kecamatans = KecamatanM::model()->findAllByAttributes(array('kabupaten_id'=>$kabupaten_id,'kecamatan_aktif'=>true,));
                $kecamatans = CHtml::listData($kecamatans,'kecamatan_id','kecamatan_nama');
                $kecamatanOption = CHtml::tag('option',array('value'=>''),"-- Pilih --",true);
                foreach($kecamatans as $value=>$name)
                {
                    if($value==$kecamatan_id)
                        $kecamatanOption .= CHtml::tag('option',array('value'=>$value,'selected'=>true),CHtml::encode($name),true);
                    else
                        $kecamatanOption .= CHtml::tag('option',array('value'=>$value),CHtml::encode($name),true);
                }
                $kelurahans = $modPasien->getKelurahanItems($kecamatan_id);
                $kelurahans = CHtml::listData($kelurahans,'kelurahan_id','kelurahan_nama');
                $kelurahanOption = CHtml::tag('option',array('value'=>''),"-- Pilih --",true);
                foreach($kelurahans as $value=>$name)
                {
                    if($value==$kelurahan_id)
                        $kelurahanOption .= CHtml::tag('option',array('value'=>$value,'selected'=>true),CHtml::encode($name),true);
                    else
                        $kelurahanOption .= CHtml::tag('option',array('value'=>$value),CHtml::encode($name),true);
                }
                
                $dataList['listPropinsi'] = $propinsiOption;
                $dataList['listKabupaten'] = $kabupatenOption;
                $dataList['listKecamatan'] = $kecamatanOption;
                $dataList['listKelurahan'] = $kelurahanOption;

                echo json_encode($dataList);
                Yii::app()->end();
            }
        }
		
		public function actionGetPenjaminPasien($encode=false,$namaModel='')
		{
			if(Yii::app()->request->isAjaxRequest) {
				$carabayar_id = $_POST["$namaModel"]['carabayar_id'];

			   if($encode)
			   {
					echo CJSON::encode($penjamin);
			   } else {
					if(empty($carabayar_id)){
						echo CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
					} else {
						$penjamin = PenjaminpasienM::model()->findAllByAttributes(array('carabayar_id'=>$carabayar_id), array('order'=>'penjamin_nama ASC'));
						if(count($penjamin) > 1)
						{
							echo CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
						}
						$penjamin = CHtml::listData($penjamin,'penjamin_id','penjamin_nama');
						foreach($penjamin as $value=>$name) {
							echo CHtml::tag('option', array('value'=>$value),CHtml::encode($name),true);
						}
					}
			   }
			}
			Yii::app()->end();
		}
		
		public function actionListDokterRuangan()
		{
			if(Yii::app()->getRequest()->getIsAjaxRequest()) {
                                $idPegawai = null;
                                if(isset($_POST['idPegawai'])) $idPegawai = $_POST['idPegawai'];
				if(!empty($_POST['idRuangan'])){
					$idRuangan = $_POST['idRuangan'];
					$data = DokterV::model()->findAllByAttributes(array('ruangan_id'=>$idRuangan),array('order'=>'nama_pegawai'));
					$data = CHtml::listData($data,'pegawai_id','namaLengkap');

					if(empty($data)){
						$option = CHtml::tag('option',array('value'=>''),CHtml::encode('-- Pilih --'),true);
					}else{
						$option = CHtml::tag('option',array('value'=>''),CHtml::encode('-- Pilih --'),true);
						foreach($data as $value=>$name) {
                                                                if ($value == $idPegawai) continue;
								$option .= CHtml::tag('option',array('value'=>$value),CHtml::encode($name),true);
						}
					}

					$dataList['listDokter'] = $option;
				} else {
					$dataList['listDokter'] = $option = CHtml::tag('option',array('value'=>''),CHtml::encode('-- Pilih --'),true);
				}

				echo json_encode($dataList);
				Yii::app()->end();
			}
		}
		
		public function actionGetListPenjamin()
		{
			if(Yii::app()->getRequest()->getIsAjaxRequest()) {
				$idCaraBayar = $_POST['idCaraBayar'];
				$idPenjamin = (isset($_POST['idPenjamin'])) ? $_POST['idPenjamin'] : '';

				$penjamins = PenjaminpasienM::model()->findAllByAttributes(array('carabayar_id'=>$idCaraBayar,'penjamin_aktif'=>true),array('order'=>'penjamin_nama'));
				$penjamins = CHtml::listData($penjamins,'penjamin_id','penjamin_nama');
				$Option = "";
				foreach($penjamins as $value=>$name)
				{
					if($value==$idPenjamin)
						$Option .= CHtml::tag('option',array('value'=>$value,'selected'=>true),CHtml::encode($name),true);
					else
						$Option .= CHtml::tag('option',array('value'=>$value),CHtml::encode($name),true);
				}

				$dataList['listPenjamin'] = $Option;

				echo json_encode($dataList);
				Yii::app()->end();
			}
		}
		
		public function actionGetDataPendaftaranRD()
		{
			if (Yii::app()->request->isAjaxRequest){
				$id_pendaftaran = $_POST['pendaftaran_id'];
				$model = InfokunjunganrdV::model()->findByAttributes(array('pendaftaran_id'=>$id_pendaftaran));
				$attributes = $model->attributeNames();
				foreach($attributes as $j=>$attribute) {
					$returnVal["$attribute"] = $model->$attribute;
				}
				$returnVal['gelardepan'] = (empty($model->gelardepan) ? "":$model->gelardepan);
				$returnVal['dokter'] = $model->nama_pegawai;
				$returnVal['gelarbelakang_nama'] = (empty($model->gelarbelakang_nama) ? "":$model->gelarbelakang_nama);
				echo json_encode($returnVal);
				Yii::app()->end();
			}
		}
		
		public function actionUbahJenisKelamin()
		{
			$model = new PasienM;
			if(isset($_POST['PasienM']))
			{
				$model->attributes = $_POST['PasienM'];
				$transaction = Yii::app()->db->beginTransaction();
				try {
					$attributes = array('jeniskelamin'=>$_POST['PasienM']['jeniskelamin']);
					$save = PasienM::model()->updateByPk($_POST['PasienM']['pasien_id'], $attributes);
					if($save)
					{
						$transaction->commit();
						echo CJSON::encode(array(
							'status'=>'proses_form', 
							'div'=>"<div class='flash-success'>Berhasil merubah data Jenis Kelamin Pasien.</div>",
							));                    
					}else{
						echo CJSON::encode(array(
							'status'=>'proses_form', 
							'div'=>"<div class='flash-error'>Data gagal disimpan.</div>",
							));                    
					}
					exit;
				}catch(Exception $exc) {
					$transaction->rollback();
				}
			}

			if (Yii::app()->request->isAjaxRequest)
			{
				echo CJSON::encode(array(
					'status'=>'create_form', 
					'div'=>$this->renderPartial($this->path_view.'_formUbahJenisKelamin', array('model'=>$model), true)));
				exit;               
			}
		}
		
		public function actionCariPasien()
		{
			if (Yii::app()->request->isAjaxRequest){
				$noRM = (isset($_POST['norekammedik']) ? $_POST['norekammedik'] : null);

				$model = PasienM::model()->findByAttributes(array('no_rekam_medik'=>$noRM));
				$attributes = $model->attributeNames();
				foreach($attributes as $j=>$attribute) {
					$returnVal["$attribute"] = $model->$attribute;
				}

				echo json_encode($returnVal);
				Yii::app()->end();
			}
		}
		
		public function actionGetKasusPenyakit()
		{
			if (Yii::app()->request->isAjaxRequest){
				$ruangan_id = $_POST['id_ruangan'];
				$jenisKasusPenyakit = array();
				if(!empty($ruangan_id)) {
					$sql = "SELECT jeniskasuspenyakit_m.jeniskasuspenyakit_id, jeniskasuspenyakit_m.jeniskasuspenyakit_nama 
							FROM jeniskasuspenyakit_m
							JOIN kasuspenyakitruangan_m ON jeniskasuspenyakit_m.jeniskasuspenyakit_id = kasuspenyakitruangan_m.jeniskasuspenyakit_id
							JOIN ruangan_m ON kasuspenyakitruangan_m.ruangan_id = ruangan_m.ruangan_id
							WHERE ruangan_m.ruangan_id = '$ruangan_id'
							ORDER BY jeniskasuspenyakit_m.jeniskasuspenyakit_id";
					$modJenKasusPenyakit = JeniskasuspenyakitM::model()->findAllBySql($sql);

					$jenisKasusPenyakit = CHtml::listData($modJenKasusPenyakit,'jeniskasuspenyakit_id','jeniskasuspenyakit_nama');
				}
				if(empty($jenisKasusPenyakit)){
					$option = CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
				}else{
					$option = CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
					foreach($jenisKasusPenyakit as $value=>$name)
					{
						$option .= CHtml::tag('option', array('value'=>$value),CHtml::encode($name),true);
					}
				}
				$dataList['listPenyakit'] = $option;
				echo json_encode($dataList);            
				Yii::app()->end();
			}        
		}
		
		public function actionUbahPasienAjax_old()
		{
			$model = new PPPasienM;

			if(isset($_POST['PasienM']))
			{
				$model->attributes = $_POST['PasienM'];
				$transaction = Yii::app()->db->beginTransaction();
				try {
					$attributes = array('nama_pasien'=>$model->nama_pasien, 
							//'no_identitas_pasien'=>$model->no_identitas_pasien,
						   // 'no_identitas'=>$model->no_identitas,
							'nama_bin'=>$model->nama_bin,

							'tempat_lahir'=>$model->tempat_lahir,
							'statusperkawinan'=>$model->statusperkawinan,
							'jenisidentitas'=>$model->jenisidentitas,
							'golongandarah'=>$model->golongandarah,
							'nama_ayah'=>$model->nama_ayah,
							'nama_ibu'=>$model->nama_ibu,
							'alamat_pasien'=>$model->alamat_pasien,
							'rt'=>$model->rt,
							'rw'=>$model->rw,
							'no_telepon_pasien'=>$model->no_telepon_pasien,
							'no_mobile_pasien'=>$model->no_mobile_pasien,
							'jeniskelamin'=>$model->jeniskelamin

					  );

					$save = $model::model()->updateByPk($_POST['PasienM']['pasien_id'], $attributes);

					if($save)
					{
						   //echo"<pre>";print_r($attributes); exit();
						$transaction->commit();
						echo CJSON::encode(array(
							'status'=>'proses_form', 
							'div'=>"<div class='flash-success'>Berhasil merubah data Pasien.</div>",
							));                    
					}else{
						echo CJSON::encode(array(
							'status'=>'proses_form', 
							'div'=>"<div class='flash-error'>Data gagal disimpan.</div>",
							));                    
					}
					exit;
				}catch(Exception $exc) {
					$transaction->rollback();
				}

			}

			if (Yii::app()->request->isAjaxRequest)
			{
				echo CJSON::encode(array(
					'status'=>'create_form', 
					'div'=>$this->renderPartial('_formUbahPasienAjax_old', array('model'=>$model), true)));
				exit;               
		}
		}
		
		public function actionUbahPasienAjax($pendaftaran_id)
		{
			$this->layout='//layouts/iframe';
			$modPendaftaran = PPPendaftaranT::model()->findByPk($pendaftaran_id);
			$modPasien = $this->loadModel($modPendaftaran->pasien_id);
			$modPegawai=new PPPegawaiM;
			if(!empty($modPasien->pegawai_id)){
				$modPegawai = PPPegawaiM::model()->findByPk($modPasien->pegawai_id);
			}
			if(isset($_POST['PPPasienM']))
			{
				$modPasien->attributes = $_POST['PPPasienM'];
				$format = new MyFormatter();
				$transaction = Yii::app()->db->beginTransaction();
				try {
					$attributes = array(
							'nama_pasien'=>$modPasien->nama_pasien, 
							'nama_bin'=>$modPasien->nama_bin,
							'tempat_lahir'=>$modPasien->tempat_lahir,
							'statusperkawinan'=>$modPasien->statusperkawinan,
							'jenisidentitas'=>$modPasien->jenisidentitas,
							'no_identitas_pasien'=>$modPasien->no_identitas_pasien, 
							'golongandarah'=>$modPasien->golongandarah,
							'rhesus'=>$modPasien->rhesus,
							'nama_ayah'=>$modPasien->nama_ayah,
							'nama_ibu'=>$modPasien->nama_ibu,
							'alamat_pasien'=>$modPasien->alamat_pasien,
							'rt'=>$modPasien->rt,
							'rw'=>$modPasien->rw,
							'no_telepon_pasien'=>$modPasien->no_telepon_pasien,
							'no_mobile_pasien'=>$modPasien->no_mobile_pasien,
							'jeniskelamin'=>$modPasien->jeniskelamin,
							'namadepan'=>$modPasien->namadepan,
							'tanggal_lahir'=>$format->formatDateTimeForDb($modPasien->tanggal_lahir),
							'suku_id'=>$modPasien->suku_id,
							'pendidikan_id'=>$modPasien->pendidikan_id,
							'anakke'=>$modPasien->anakke,
							'jumlah_bersaudara'=>$modPasien->jumlah_bersaudara,
							'alamatemail'=>$modPasien->alamatemail,
							'pekerjaan_id'=>$modPasien->pekerjaan_id,
							'pegawai_id'=>$_POST['PPPegawaiM']['pegawai_id']
					  );
					$save = $modPasien::model()->updateByPk($_POST['PPPasienM']['pasien_id'],$attributes);
					
					if($save)
					{
						$transaction->commit();
						Yii::app()->user->setFlash('success',"Data berhasil disimpan");
						$this->redirect(array('ubahPasienAjax','pendaftaran_id'=>$pendaftaran_id,'sukses'=>1));
					}else{
						$transaction->rollback();
						Yii::app()->user->setFlash('error',"Data gagal disimpan");               
					}
					
				}catch(Exception $exc) {
					$transaction->rollback();
					Yii::app()->user->setFlash('error',"Data gagal disimpan");
				}

			}
			$this->render('_formUbahPasienAjax',array('modPasien'=>$modPasien,'modPendaftaran'=>$modPendaftaran,'modPegawai'=>$modPegawai));
		}
		
		public function actionUbahDokterPeriksa()
		{
			$model = new PPPendaftaranT;
			$modUbahDokter = new PPUbahdokterR;
			$menu = (isset($_REQUEST['menu']) ? $_REQUEST['menu'] : "");
			if(isset($_POST['PPPendaftaranT']))
			{
				if($_POST['PPPendaftaranT']['pegawai_id'] != "")
				{
					$model->attributes = $_POST['PPPendaftaranT'];
					$modUbahDokter->attributes = $_POST['PPUbahdokterR'];
					$modUbahDokter->pendaftaran_id = $_POST['PPPendaftaranT']['pendaftaran_id'];
					$modUbahDokter->dokterbaru_id = $_POST['PPPendaftaranT']['pegawai_id'];
					$modUbahDokter->tglubahdokter = date('Y-m-d H:i:s');
					$modUbahDokter->create_time = date('Y-m-d H:i:s');
					$modUbahDokter->create_loginpemakai_id = Yii::app()->user->id;
					$modUbahDokter->create_ruangan = Yii::app()->user->getState('ruangan_id');
					$transaction = Yii::app()->db->beginTransaction();
					try {
						$attributes = array('pegawai_id'=>$_POST['PPPendaftaranT']['pegawai_id']);
						$save = $model::model()->updateByPk($_POST['PPPendaftaranT']['pendaftaran_id'], $attributes);
						if($save)
						{
							$modUbahDokter->save();
							$transaction->commit();
							echo CJSON::encode(array(
								'status'=>'proses_form', 
								'div'=>"<div class='flash-success'>Berhasil merubah Dokter Periksa.</div>",
								));
						}else{
							echo CJSON::encode(array(
								'status'=>'proses_form', 
								'div'=>"<div class='flash-error'>Data gagal disimpan.</div>",
								));                    
						}
						exit;
					}catch(Exception $exc) {
						$transaction->rollback();
					}                
				}else{
					echo CJSON::encode(
						array(
							'status'=>'proses_form',
							'div'=>"<div class='flash-success'>Berhasil merubah Dokter Periksa.</div>",
						)
					);
					exit;
				}
			}

			if (Yii::app()->request->isAjaxRequest)
			{
				echo CJSON::encode(array(
					'status'=>'create_form', 
					'div'=>$this->renderPartial($this->path_view.'_formUbahDokterPeriksa', array('model'=>$model,'modUbahDokter'=>$modUbahDokter,'menu'=>$menu), true)));
				exit;               
			}
		}
		
		public function actionGetRuanganPasien()
		{
			if (Yii::app()->getRequest()->getIsAjaxRequest())
			 {
				$pendaftaran_id= (isset($_POST['pendaftaran_id']) ? $_POST['pendaftaran_id'] : null);
				$ruangan_id= (isset($_POST['ruangan_id']) ? $_POST['ruangan_id'] : null);
				$instalasi_id= (isset($_POST['instalasi_id']) ? $_POST['instalasi_id'] : null);
				$pegawai_id = (isset($_POST['pegawai_id']) ? $_POST['pegawai_id'] : null);

				if(isset($_POST['jeniskasuspenyakit_id'])){
					$jeniskasuspenyakit_id= (isset($_POST['jeniskasuspenyakit_id']) ? $_POST['jeniskasuspenyakit_id'] : null);
					$jenisKasusPenyakit = '';
					$criteria=new CDbCriteria;
					$criteria->select ='t.ruangan_id, t.jeniskasuspenyakit_id, ruangan_m.ruangan_nama, jeniskasuspenyakit_m.jeniskasuspenyakit_nama,
										jeniskasuspenyakit_aktif';
					$criteria->addCondition("t.ruangan_id = ".$ruangan_id);
					if(!empty($jeniskasuspenyakit_id)){
						$criteria->addCondition("t.jeniskasuspenyakit_id = ".$jeniskasuspenyakit_id);
					}
					$criteria->addCondition('jeniskasuspenyakit_m.jeniskasuspenyakit_aktif is true');
					$criteria->join = 'LEFT JOIN ruangan_m on t.ruangan_id = ruangan_m.ruangan_id
									   LEFT JOIN jeniskasuspenyakit_m on t.jeniskasuspenyakit_id = jeniskasuspenyakit_m.jeniskasuspenyakit_id
										';
					$dataJenisPenyakit =KasuspenyakitruanganM::model()->findAll($criteria);
	//                $dataJenisPenyakit =KasuspenyakitruanganM::model()->findAll('jeniskasuspenyakit_id='.$jeniskasuspenyakit_id.' AND jeniskasuspenyakit_aktif=TRUE ORDER BY jeniskasuspenyakit_nama');

					  foreach($dataJenisPenyakit AS $jenisPenyakit){
						  if($jenisPenyakit['jeniskasuspenyakit_id']==$jeniskasuspenyakit_id)
							 {
								   $jenisKasusPenyakit .='<option value="'.$jenisPenyakit['jeniskasuspenyakit_id'].'" selected="selected">'.$jenisPenyakit['jeniskasuspenyakit_nama'].'</option>';
							 }
						 else
							  {
								   $jenisKasusPenyakit .='<option value="'.$jenisPenyakit['jeniskasuspenyakit_id'].'">'.$jenisPenyakit['jeniskasuspenyakit_nama'].'</option>';
							  }

					  } 
					$data['jenisKasusPenyakit']=$jenisKasusPenyakit;    
				}


				if(isset($_POST['pegawai_id'])){
					$pegawai_id=$_POST['pegawai_id'];
					$ruangan_id = $_POST['ruangan_id'];
					$criteria=new CDbCriteria;
					$criteria->select ='t.ruangan_id, t.pegawai_id, t.nama_pegawai, t.gelardepan, t.gelarbelakang_nama';
					$criteria->addCondition("t.ruangan_id = ".$ruangan_id);
                                        $criteria->addCondition("t.pegawai_aktif = TRUE");
                                        $criteria->order = "t.nama_pegawai, t.gelardepan ASC";
					if(!empty($jeniskasuspenyakit_id)){
						$criteria->addCondition("t.pegawai_id = ".$pegawai_id);
					}
					$dataDokter = DokterV::model()->findAll($criteria);
	//                $dataJenisPenyakit =KasuspenyakitruanganM::model()->findAll('jeniskasuspenyakit_id='.$jeniskasuspenyakit_id.' AND jeniskasuspenyakit_aktif=TRUE ORDER BY jeniskasuspenyakit_nama');
					$dokter = '';
					  foreach($dataDokter AS $dokters){
						  if($dokters['pegawai_id']==$pegawai_id)
							 {
								   $dokter .='<option value="'.$dokters['pegawai_id'].'" selected="selected">'.$dokters->namaLengkap.'</option>';
							 }
						 else
							  {
								   $dokter .='<option value="'.$dokters['pegawai_id'].'">'.$dokters->namaLengkap.'</option>';
							  }
					  } 
					$data['dokter']=$dokter;    
				}

				$dropDown='';
				$dataRuangan =RuanganM::model()->findAll('instalasi_id='.$instalasi_id.' AND ruangan_aktif=TRUE ORDER BY ruangan_nama');
				foreach ($dataRuangan AS $tampilRuangan)
				{
				   if($tampilRuangan['ruangan_id']==$ruangan_id)
					   {
							 $dropDown .='<option value="'.$tampilRuangan['ruangan_id'].'" selected="selected" onchange="getKasusPenyakit('.$ruangan_id.')">'.$tampilRuangan['ruangan_nama'].'</option>';
					   }
				   else
						{
							 $dropDown .='<option value="'.$tampilRuangan['ruangan_id'].'" onchange="return getKasusPenyakit('.$ruangan_id.')">'.$tampilRuangan['ruangan_nama'].'</option>';
						}

				}
				   $data['dropDown']=$dropDown;    
				   echo json_encode($data);
				   Yii::app()->end();    
			 }
		}
		
		public function actionBuatSessionUbahStatus()
		{
			$pendaftaran_id = $_POST['pendaftaran_id'];
			if(!empty($_POST['pendaftaran_id']))
			{
				$pendaftaran_id = $_POST['pendaftaran_id'];
				Yii::app()->session['pendaftaran_id'] = $pendaftaran_id;
			}
			Yii::app()->session['pendaftaran_id'] =  $pendaftaran_id;
			echo CJSON::encode(array(
				'pendaftaran_id'=>Yii::app()->session['pendaftaran_id']));

		}
		
		

        public function actionBpjsInterface()
        {
            if(Yii::app()->getRequest()->getIsAjaxRequest()) {
                if(empty( $_GET['param'] ) OR $_GET['param'] === ''){
                    die('param can\'not empty value');
                }else{
                    $param = $_GET['param'];
                }

//                if(empty( $_GET['server'] ) OR $_GET['server'] === ''){
//                    
//                }else{
//                    $server = 'http://'.$_GET['server'];
//                }

                $bpjs = new Bpjs();

                switch ($param) {
                    case '1':
                        $query = $_GET['query'];
                        print_r( $bpjs->search_kartu($query) );
                        break;
                    case '2':
                        $query = $_GET['query'];
                        print_r( $bpjs->search_nik($query) );
                        break;
                    case '3':
                        $query = $_GET['query'];
                        print_r( $bpjs->search_rujukan_no_rujukan($query) );
                        break;
                    case '4':
                        $query = $_GET['query'];
                        print_r( $bpjs->search_rujukan_no_bpjs($query) );
                        break;
                    case '5':
                        $query = $_GET['query'];
                        $start = $_GET['start'];
                        $limit = $_GET['limit'];
                        print_r( $bpjs->list_rujukan_tanggal($query, $start, $limit) );
                        break;
                    case '6':
                        $nokartu = $_GET['no_kartu'];
                        $tglsep = $_GET['tgl_sep'];
                        $tglrujukan = $_GET['tgl_rujukan'];
                        $norujukan = $_GET['no_rujukan'];
                        $ppkrujukan = $_GET['ppk_rujukan'];
                        $ppkpelayanan = $_GET['ppk_pelayanan'];
                        $jnspelayanan = $_GET['jns_pelayanan'];
                        $catatan = $_GET['catatan'];
                        $diagawal = $_GET['diag_awal'];
                        $politujuan = $_GET['poli_tujuan'];
                        $klsrawat = $_GET['kls_rawat'];
                        $user = $_GET['user'];
                        $nomr = $_GET['no_mr'];
                        $notrans = $_GET['no_trans'];
                        print_r( $bpjs->create_sep($nokartu, $tglsep, $tglrujukan, $norujukan, $ppkrujukan, $ppkpelayanan, $jnspelayanan, $catatan, $diagawal, $politujuan, $klsrawat, $user, $nomr, $notrans) );
                        break;
                    case '7':
                        $nosep = $_GET['nosep'];
                        $tglpulang = $_GET['tglpulang'];
                        $ppkpelayanan = $_GET['ppkpelayanan'];
                        print_r( $bpjs->update_tanggal_pulang_sep($nosep, $tglpulang, $ppkpelayanan) );
                        break;
                    case '8':
                        $nosep = $_GET['nosep'];
                        $notrans = $_GET['notrans'];
                        $ppkpelayanan = $_GET['ppkpelayanan'];
                        print_r( $bpjs->mapping_trans($nosep, $notrans, $ppkpelayanan) );
                        break;
                    case '9':
                        $nosep = $_GET['nosep'];
                        $ppkpelayanan = $_GET['ppkpelayanan'];
                        print_r( $bpjs->delete_transaksi($nosep, $ppkpelayanan) );
                        break;
                    case '10':
                        $nokartu = $_GET['nokartu'];
                        print_r( $bpjs->riwayat_terakhir($nokartu) );
                        break;
                    case '11':
                        $nosep = $_GET['nosep'];
                        print_r( $bpjs->detail_sep($nosep) );
                        break;
                    case '12':
                        $ppkpelayanan = $_GET['ppkrujukan'];
                        $start = $_GET['start'];
                        $limit = $_GET['limit'];
                        print_r( $bpjs->detail_ppk_rujukan($ppkpelayanan, $start, $limit) );
                        break;
                    case '99':
                        $bpjs->identity_magic();
                        break;
                    case '100':
                        print_r( $bpjs->help() );
                        break;
                    default:
                        die('error number, please check your parameter option');
                        break;
                }
                Yii::app()->end();
            }
        }

        public function actionPrintSep($sep_id,$pendaftaran_id) 
        {
            $this->layout='//layouts/printWindows';
            $format = new MyFormatter;
            $modRujukanBpjs = new PPRujukanbpjsT;
            $modSep = PPSepT::model()->findByPk($sep_id);
            $modAsuransiPasienBpjs = PPAsuransipasienbpjsM::model()->findByAttributes(array('nopeserta'=>$modSep->nokartuasuransi)); 
            $modJenisPeserta = PPJenisPesertaM::model()->findByPk($modAsuransiPasienBpjs->jenispeserta_id);
            if (isset($modSep->norujukan)) {
                $modRujukanBpjs = PPRujukanbpjsT::model()->findByAttributes(array('no_rujukan'=>$modSep->norujukan));
            }
            $modPendaftaran = PPPendaftaranT::model()->findByPk($pendaftaran_id);
            $modPasien = PPPasienM::model()->findByPk($modPendaftaran->pasien_id);
            $judul_print = 'SURAT ELEGIBILITAS PESERTA';
            $this->render($this->path_view.'printSep', array(
                                'format'=>$format,
                                'modSep'=>$modSep,
                                'judul_print'=>$judul_print,
                                'modAsuransiPasienBpjs'=>$modAsuransiPasienBpjs,
                                'modRujukanBpjs'=>$modRujukanBpjs,
                                'modPendaftaran'=>$modPendaftaran,
                                'modPasien'=>$modPasien,
                                'modJenisPeserta'=>$modJenisPeserta,
            ));
        } 
		
		/**
         * set umur dari tanggal lahir (date)
         */
        public function actionSetUmur()
        {
            if(Yii::app()->getRequest()->getIsAjaxRequest()) {
                $data['umur'] = null;
                if(isset($_POST['tanggal_lahir']) && !empty($_POST['tanggal_lahir'])){
                    $data['umur'] = CustomFunction::hitungUmur($_POST['tanggal_lahir']);
                }
                echo json_encode($data);
                Yii::app()->end();
            }
        }
		
		public function actionAutocompleteNobadge()
		{
				if(Yii::app()->request->isAjaxRequest) {
					$format = new MyFormatter();
					$returnVal = array();
					$no_badge = isset($_GET['nomorindukpegawai']) ? $_GET['nomorindukpegawai'] : null;
					$criteria = new CDbCriteria();
					$criteria->compare('LOWER(pegawai_m.nomorindukpegawai)', strtolower($no_badge), true);
					$criteria->join = "JOIN pegawai_m ON t.pegawai_id = pegawai_m.pegawai_id";
					$criteria->order = 'pegawai_m.nomorindukpegawai, t.nama_pasien';
					$criteria->limit = 50;
					$models = PPPasienM::model()->findAll($criteria);
					foreach($models as $i=>$model)
					{
						$attributes = $model->attributeNames();
						foreach($attributes as $j=>$attribute) {
							$returnVal[$i]["$attribute"] = $model->$attribute;
						}
						$returnVal[$i]['label'] = $model->pegawai->nomorindukpegawai.
											' - '.$model->no_rekam_medik.	
											' - '.$model->nama_pasien.	
											' - ('.$model->pegawai->nama_pegawai.
											') - '.$format->formatDateTimeForUser($model->tanggal_lahir);
						$returnVal[$i]['value'] = $model->pegawai->nomorindukpegawai;
					}

					echo CJSON::encode($returnVal);
				}else
					throw new CHttpException(403,'Tidak dapat mengurai data');
				Yii::app()->end();
		}
		
		public function actionSetNobadge()
		{
			if(Yii::app()->request->isAjaxRequest) {
				$nip = null;
				$pegawai_id = isset($_POST['pegawai_id']) ? $_POST['pegawai_id'] : null;
				$models = PPPegawaiM::model()->findByPk($pegawai_id);
				if(count($models)>0){
					$nip = $models->nomorindukpegawai;
				}
				echo CJSON::encode($nip);
			}else
				throw new CHttpException(403,'Tidak dapat mengurai data');
			Yii::app()->end();
		}
		
		/**
         * @param type $pendaftaran_id
         */
        public function actionPrintKarcis() 
        {
            $this->layout='//layouts/printWindows';
			$pendaftaran_id = $_GET['pendaftaran_id'];
            $format = new MyFormatter;
            $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
            $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
            $modPegawai = PegawaiM::model()->findByPk(Yii::app()->user->id);

            $karcis_id = null;
            $modTindakan =  TindakanpelayananT::model()->findByAttributes(array('pendaftaran_id'=>$modPendaftaran->pendaftaran_id), "karcis_id IS NOT NULL");
            $judul_print = 'Karcis '.$modPendaftaran->ruangan->instalasi->instalasi_nama;
            $this->render($this->path_view.'printKarcis', array(
                                'format'=>$format,
                                'modPendaftaran'=>$modPendaftaran,
                                'judul_print'=>$judul_print,
                                'modPasien'=>$modPasien,
                                'modTindakan'=>$modTindakan,
                                'modPegawai'=>$modPegawai,
            ));
        }

}