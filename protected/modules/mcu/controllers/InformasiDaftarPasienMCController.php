<?php
Yii::import('rawatJalan.models.*');
class InformasiDaftarPasienMCController extends MyAuthController
{
	public $defaultAction = 'index';
        
	public function actionIndex()
	{
		$model = new RJInfokunjunganrjV('searchDaftarPasienMcu');
		$model->unsetAttributes();
		$model->tgl_awal = date('d M Y');
		$model->tgl_akhir = date('d M Y');
		$model->ruangan_id = Yii::app()->user->getState('ruangan_id');
		if(isset($_GET['RJInfokunjunganrjV'])){
			$model->attributes = $_GET['RJInfokunjunganrjV'];
			$format = new MyFormatter();
			$model->tgl_awal  = $format->formatDateTimeForDb($_REQUEST['RJInfokunjunganrjV']['tgl_awal']);
			$model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['RJInfokunjunganrjV']['tgl_akhir']);
			$model->ruangan_id = Yii::app()->user->getState('ruangan_id');
		}

		 if (Yii::app()->request->isAjaxRequest) {
				echo $this->renderPartial('_tablePasien', array('model'=>$model));
			}else{
				 $this->render('index',array('model'=>$model));
			}
	}
	
	public function actionRencanaKontrolPasienRJ($pendaftaran_id)
	{
             $this->layout='//layouts/iframe';
             $format = new MyFormatter;
             $model = new PendaftaranT;
             $tersimpan = 'Tidak';
             
             $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
             $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
			 
			$model->tglrenkontrol = $format->formatDateTimeForDb($modPendaftaran->tgl_pendaftaran);
			$model->tglrenkontrol = strtotime($model->tglrenkontrol.' + 1 years');
			$model->tglrenkontrol = date('Y-m-d H:i:s',$model->tglrenkontrol);
			 
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
             
             if(isset($_POST['PendaftaranT'])){
                    $renKontrol = $format->formatDateTimeForDb($_POST['PendaftaranT']['tglrenkontrol']);
                    $pasien_id = $_POST['PendaftaranT']['pendaftaran_id'];
                    $transaction = Yii::app()->db->beginTransaction();
                  try {
                        $update = PendaftaranT::model()->updateByPk($pasien_id,array('tglrenkontrol'=>$renKontrol));

                        if($update){
                          // SMS GATEWAY
                            $modPegawai = $modPendaftaran->pegawai;
                            $modRuangan = $modPendaftaran->ruangan;
                            $modInstalasi = $modPendaftaran->instalasi;
                            $sms = new Sms();
                            foreach ($modSmsgateway as $i => $smsgateway) {
                                $isiPesan = $smsgateway->templatesms;

                                $attributes = $modPasien->getAttributes();
                                foreach($attributes as $attributes => $value){
                                    $isiPesan = str_replace("{{".$attributes."}}",$value,$isiPesan);
                                }
                                $attributes = $modPendaftaran->getAttributes();
                                foreach($attributes as $attributes => $value){
                                    $isiPesan = str_replace("{{".$attributes."}}",$value,$isiPesan);
                                }
                                $attributes = $modPegawai->getAttributes();
                                foreach($attributes as $attributes => $value){
                                    $isiPesan = str_replace("{{".$attributes."}}",$value,$isiPesan);
                                }
                                $attributes = $modRuangan->getAttributes();
                                foreach($attributes as $attributes => $value){
                                    $isiPesan = str_replace("{{".$attributes."}}",$value,$isiPesan);
                                }
                                $attributes = $modInstalasi->getAttributes();
                                foreach($attributes as $attributes => $value){
                                    $isiPesan = str_replace("{{".$attributes."}}",$value,$isiPesan);
                                }
                                $isiPesan = str_replace("{{hari}}",MyFormatter::getDayName($modPendaftaran->tglrenkontrol),$isiPesan);
                                
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
                            Yii::app()->user->setFlash('success',"Data berhasil disimpan");
                            $tersimpan='Ya';   
                        }else{
                           $transaction->rollback();
                           Yii::app()->user->setFlash('error',"Data gagal disimpan");   
                        }
                        
//                        RND-6398
//                        $params['tglnotifikasi'] = date( 'Y-m-d H:i:s');
//                        $params['create_time'] = date( 'Y-m-d H:i:s');
//                        $params['create_loginpemakai_id'] = Yii::app()->user->id;
//                        $params['instalasi_id'] = Yii::app()->user->getState('instalasi_id');
//                        $params['modul_id'] = Yii::app()->session['modul_id'];
//                        $params['isinotifikasi'] = $modPasien->no_rekam_medik . '-' . $modPendaftaran->no_pendaftaran . '-' . $modPasien->nama_pasien;
//                        $params['create_ruangan'] = $modPendaftaran->ruangan_id;
//                        $params['judulnotifikasi'] = ($modPendaftaran->tglrenkontrol != null ? 'Rencana Kontrol Pasien' : 'Rencana Kontrol Pasien' );
//                        $nofitikasi = NotifikasiRController::insertNotifikasi($params);
                    
                   } catch (Exception $exc){
                        $transaction->rollback();
                        Yii::app()->user->setFlash('error',"Data gagal disimpan", MyExceptionMessage::getMessage($exc,false));
                   }
             }
             
             $model->tglrenkontrol = Yii::app()->dateFormatter->formatDateTime(
                                        CDateTimeParser::parse($model->tglrenkontrol, 'yyyy-MM-dd hh:mm:ss'));
             
             $this->render('formRencanaKontrol',array(
                                'modPasien'=>$modPasien,
                                'modPendaftaran'=>$modPendaftaran,
                                'model'=>$model,
                                'tersimpan'=>$tersimpan,
                                'smspasien'=>$smspasien
                          ));
	}
	
	public function actionUbahDokterPeriksa()
	{
		$model = new RJPendaftaranT;
		$modUbahDokter = new RJUbahdokterR;
		$menu = (isset($_REQUEST['menu']) ? $_REQUEST['menu'] : "");
		if(isset($_POST['RJPendaftaranT']))
		{
			if($_POST['RJPendaftaranT']['pegawai_id'] != "")
			{
				$model->attributes = $_POST['RJPendaftaranT'];
				$modUbahDokter->attributes = $_POST['RJUbahdokterR'];
				$modUbahDokter->pendaftaran_id = $_POST['RJPendaftaranT']['pendaftaran_id'];
				$modUbahDokter->dokterbaru_id = $_POST['RJPendaftaranT']['pegawai_id'];
				$modUbahDokter->tglubahdokter = date('Y-m-d H:i:s');
				$modUbahDokter->create_time = date('Y-m-d H:i:s');
				$modUbahDokter->create_loginpemakai_id = Yii::app()->user->id;
				$modUbahDokter->create_ruangan = Yii::app()->user->getState('ruangan_id');
				$transaction = Yii::app()->db->beginTransaction();
				try {
					$attributes = array('pegawai_id'=>$_POST['RJPendaftaranT']['pegawai_id']);
					$save = $model::model()->updateByPk($_POST['RJPendaftaranT']['pendaftaran_id'], $attributes);
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
				'div'=>$this->renderPartial('_formUbahDokterPeriksa', array('model'=>$model,'menu'=>$menu,'modUbahDokter'=>$modUbahDokter), true)));
			exit;               
		}
	}
	
	public function actionGetDataPendaftaranMCU()
	{
		if (Yii::app()->request->isAjaxRequest){
			$id_pendaftaran = $_POST['pendaftaran_id'];
			$model = RJInfokunjunganrjV::model()->findByAttributes(array('pendaftaran_id'=>$id_pendaftaran));
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
	
	public function actionListDokterRuangan()
	{
		if(Yii::app()->getRequest()->getIsAjaxRequest()) {
			if(!empty($_POST['idRuangan'])){
				$idRuangan = $_POST['idRuangan'];
				$data = DokterV::model()->findAllByAttributes(array('ruangan_id'=>$idRuangan),array('order'=>'nama_pegawai'));
				$data = CHtml::listData($data,'pegawai_id','NamaLengkap');

				if(empty($data)){
					$option = CHtml::tag('option',array('value'=>''),CHtml::encode('-- Pilih --'),true);
				}else{
					$option = CHtml::tag('option',array('value'=>''),CHtml::encode('-- Pilih --'),true);
					foreach($data as $value=>$name) {
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
	
	public function actionBatalPeriksa(){
      $nama_modul = Yii::app()->controller->module->id;
      $nama_controller = Yii::app()->controller->id;
      $nama_action = Yii::app()->controller->action->id;
      $modul_id = ModulK::model()->findByAttributes(array('url_modul'=>$nama_modul))->modul_id;
      $smspasien = 1;
      $smsdokter = 1;
      $criteria = new CDbCriteria;
      $criteria->compare('modul_id',$modul_id);
      $criteria->compare('LOWER(modcontroller)',strtolower($nama_controller),true);
      $criteria->compare('LOWER(modaction)',strtolower($nama_action),true);
      if(isset($_POST['tujuansms'])){
          $criteria->addInCondition('tujuansms',$_POST['tujuansms']);
      }
      $modSmsgateway = SmsgatewayM::model()->findAll($criteria);

			if(Yii::app()->request->isAjaxRequest)
			{ 
				$transaction = Yii::app()->db->beginTransaction();
				try{
					$pendaftaran_id = isset($_POST['pendaftaran_id']) ? $_POST['pendaftaran_id'] : null;
					$ruangan_id = isset($_POST['ruangan_id']) ? $_POST['ruangan_id'] : Yii::app()->user->getState('ruangan_id');
					$modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
					$modPasien = new PasienM();
					$modPegawai = new PegawaiM();
					/*
					* cek data pendaftaran pasien masuk penunjang
					*/
					$criteria = new CDbCriteria();
					if(!empty($pendaftaran_id)){
						$criteria->addCondition("pendaftaran_id = ".$pendaftaran_id);						
					}

					$pasienMasukPenunjang = PasienmasukpenunjangT::model()->find($criteria);
					
					$pesan = '';
					$status = false;
					$model = new PasienbatalperiksaR();
					$model->pendaftaran_id = $pendaftaran_id;
					$model->pasien_id = $modPendaftaran->pasien_id;
					$model->tglbatal = date('Y-m-d');
					$model->keterangan_batal = "Batal Rawat Jalan";
					$model->create_ruangan = isset($_POST['ruangan_id']) ? $_POST['ruangan_id'] : Yii::app()->user->getState('ruangan_id');
					
					if($model->save())
					{
						$status = true;
						$pesan = "Pemeriksaan pasien berhasil dibatalkan!";
					}else{
						$status = false;
						$pesan = "Pemeriksaan gagal dibatalkan! ".CHtml::errorSummary($model);
					}
					
					$attributes = array(
						'pasienbatalperiksa_id' => $model->pasienbatalperiksa_id,
						'update_time' => date('Y-m-d H:i:s'),
						'update_loginpemakai_id' => Yii::app()->user->id
					);
					$pendaftaran = PendaftaranT::model()->updateByPk($pendaftaran_id, $attributes);
					
					if(count($pasienMasukPenunjang) > 0){
						if($pasienMasukPenunjang->pasienkirimkeunitlain_id == null)
						{
							$attributes = array(
								'pasienkirimkeunitlain_id' => $pasienMasukPenunjang->pasienkirimkeunitlain_id
							);
							$Perminataan_penunjang = PermintaankepenunjangT::model()->deleteAllByAttributes($attributes);
						}
					
						$attributes = array(
							'statusperiksa' => Params::STATUSPERIKSA_BATAL_PERIKSA,
							'update_time' => date('Y-m-d H:i:s'),
							'update_loginpemakai_id' => Yii::app()->user->id
						);
						
						$penunjang = PasienmasukpenunjangT::model()->updateByPk($pasienMasukPenunjang->pasienmasukpenunjang_id, $attributes);
						if(!$penunjang)
						{
							$status = false;
						}
						/*
						* cek data tindakan_pelayanan
						*/
					   $attributes = array(
						   'pasienmasukpenunjang_id' => $pasienMasukPenunjang->pasienmasukpenunjang_id,
						   'tindakansudahbayar_id' => null
					   );

					   $criteria2 = new CDbCriteria();
					   $criteria2->addCondition('pasienmasukpenunjang_id = '.$pasienMasukPenunjang->pasienmasukpenunjang_id);
					   $criteria2->addCondition('tindakansudahbayar_id is null');
					   $tindakan = TindakanpelayananT::model()->findAll($criteria2);

					   if(count($tindakan) > 0)
					   {

						   foreach($tindakan as $val=>$key)
						   {
							   $attributes = array(
								   'tindakanpelayanan_id' => $key->tindakanpelayanan_id
							   );
							   $hapus_komponen= TindakankomponenT::model()->deleteAllByAttributes($attributes);
						   }

						   $attributes = array(
							   'pasienmasukpenunjang_id' => $pasienMasukPenunjang->pasienmasukpenunjang_id
						   );

						   $hapus_tindakan = TindakanPelayananT::model()->deleteAllByAttributes($attributes);
						   if(!$hapus_tindakan)
						   {
							   $status = false;
							   $pesan = "exist";
						   }
					   }else{
						   $pesan = "exist";
					   }
					}
				    /*
					* kondisi_commit
					*/
				   if($status == true)
				   {
            // SMS GATEWAY
            $modPegawai = $modPendaftaran->pegawai;
            $modPasien = $modPendaftaran->pasien;
            $sms = new Sms();
            foreach ($modSmsgateway as $i => $smsgateway) {
                $isiPesan = $smsgateway->templatesms;

                $attributes = $modPasien->getAttributes();
                foreach($attributes as $attributes => $value){
                    $isiPesan = str_replace("{{".$attributes."}}",$value,$isiPesan);
                }
                $attributes = $model->getAttributes();
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
                }elseif($smsgateway->tujuansms == Params::TUJUANSMS_DOKTER && $smsgateway->statussms){
                    if(!empty($modPegawai->nomobile_pegawai)){
                        $sms->kirim($modPegawai->nomobile_pegawai,$isiPesan);
                    }else{
                        $smsdokter = 0;
                    }
                }
                
            }
            // END SMS GATEWAY
					   $transaction->commit();
				   }else{
					   $transaction->rollback();

				   }
					
				}catch(Exception $ex){
					$status = false;
					$pesan = "exist";
					$transaction->rollback();
				}  
				
				$data = array(
					'pesan'=>$pesan,
					'status'=>$status,
          'smspasien'=>$smspasien,
          'smsdokter'=>$smsdokter,
          'nama_pasien'=>$modPasien->nama_pasien,
          'nama_pegawai'=>$modPegawai->nama_pegawai,
				);
				echo json_encode($data);
				Yii::app()->end();            
			}
		}
	
}
?>