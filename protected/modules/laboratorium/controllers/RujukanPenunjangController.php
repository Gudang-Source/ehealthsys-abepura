<?php

class RujukanPenunjangController extends MyAuthController
{
    public $instalasi_ruangan, $nama_pasien_panggilan, $cara_bayar_penjamin, $kasus_pelayanan;
    public function actionIndex()
    {
        $format = new MyFormatter;
        $model = new LBPasienKirimKeUnitLainV();
        $model->tgl_awal = date('Y-m-d', strtotime('-5 days'));
        $model->tgl_akhir = date('Y-m-d');
        
        if(isset($_GET['LBPasienKirimKeUnitLainV'])){
            $model->attributes = $_GET['LBPasienKirimKeUnitLainV'];
            
            $model->cbTglMasuk = $_GET['LBPasienKirimKeUnitLainV']['cbTglMasuk'];
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['LBPasienKirimKeUnitLainV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['LBPasienKirimKeUnitLainV']['tgl_akhir']);
        }
        $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
        $this->render('index',array('model'=>$model,'format'=>$format));
    }
    
    public function actionBatalPemeriksaan()
    {
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

        if(Yii::app()->request->isAjaxRequest)
        {
            $transaction = Yii::app()->db->beginTransaction();
            $pesan = 'success';
            $status = 'ok';

            try{
                $pendaftaran_id = $_POST['pendaftaran_id'];

                /*
                 * cek data pendaftaran pasien masuk penunjang
                 */
                $pasienMasukPenunjang = PasienmasukpenunjangT::model()->findByAttributes(
                    array(
                        'pendaftaran_id'=>$pendaftaran_id
                    )
                );

                $model = new PasienbatalperiksaR();
                $model->pendaftaran_id = $pendaftaran_id;
                $model->pasien_id = $pasienMasukPenunjang->pasien_id;
                $model->tglbatal = date('Y-m-d');
                $model->keterangan_batal = "Batal Laboratorium";
                $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
                if(!$model->save())
                {
                    $status = 'not';
                }

                if($pasienMasukPenunjang->pasienkirimkeunitlain_id == null)
                {
                    $attributes = array(
                        'pasienbatalperiksa_id' => $model->pasienbatalperiksa_id,
                        'update_time' => date('Y-m-d H:i:s'),
                        'update_loginpemakai_id' => Yii::app()->user->id
                    );
                    $pendaftaran = LBPendaftaranT::model()->updateByPk($pendaftaran_id, $attributes);
                    
                    $attributes = array(
                        'pasienkirimkeunitlain_id' => $pasienMasukPenunjang->pasienkirimkeunitlain_id
                    );
                    $Perminataan_penunjang = PermintaankepenunjangT::model()->deleteAllByAttributes($attributes);
                }

                $attributes = array(
                    'statusperiksa' => 'BATAL PERIKSA',
                    'update_time' => date('Y-m-d H:i:s'),
                    'update_loginpemakai_id' => Yii::app()->user->id
                );
                $penunjang = PasienmasukpenunjangT::model()->updateByPk($pasienMasukPenunjang->pasienmasukpenunjang_id, $attributes);
                if(!$penunjang)
                {
                    $status = 'not';
                }
                

                /*
                 * cek data tindakan_pelayanan
                 */
                $attributes = array(
                    'pasienmasukpenunjang_id' => $pasienMasukPenunjang->pasienmasukpenunjang_id,
                    'tindakansudahbayar_id' => null
                );
                $tindakan = LBTindakanPelayananT::model()->findAllByAttributes($attributes);
                if(count($tindakan) > 0)
                {
                    foreach($tindakan as $val=>$key)
                    {
                        $attributes = array(
                            'tindakanpelayanan_id' => $key->tindakanpelayanan_id
                        );
                        $hapus_det_tindakan = LBDetailHasilPemeriksaanLabT::model()->deleteAllByAttributes($attributes);
                    }
                    
                    $attributes = array(
                        'pasienmasukpenunjang_id' => $pasienMasukPenunjang->pasienmasukpenunjang_id
                    );
                    $hapus_tindakan = LBTindakanPelayananT::model()->deleteAllByAttributes($attributes);
                    if(!$hapus_tindakan)
                    {
                        $status = 'not';
                    }
                }else{
                    $pesan = 'exist';
                }

                /*
                 * kondisi_commit
                 */
                if($status == 'ok')
                {
    //                        $transaction->commit();
                }else{
                    $transaction->rollback();
                }

            }catch(Exception $ex){
                print_r($ex);
                $status = 'not';
                $transaction->rollback();
            }            
            $data = array(
                'pesan'=>'succes',
                'status'=>'ok'
            );
            echo json_encode($data);
            Yii::app()->end();            
        }
    }

    /**
	 * Date		: 12 Juni 2015
	 * Issue	: RND-7153
	 */
	public function actionbatalRujuk()
	{
		if(Yii::app()->request->isAjaxRequest) {
		$pendaftaran_id = $_POST['pendaftaran_id'];
		$idKirimUnit = $_POST['idKirimUnit'];

		$transaction = Yii::app()->db->beginTransaction();
		$status = 'ok';
		$status_bayar = 'ok';

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
			$modPermintaanPenunjang = LBPermintaanKePenunjangT::model()->findAllByAttributes(array('pasienkirimkeunitlain_id'=>$idKirimUnit));
			$modPasienKirimUnit = LBPasienKirimKeUnitLainT::model()->findByPk($idKirimUnit);

			foreach($modPermintaanPenunjang as $i=>$permintaan){
				$modTindakanPelayanan = LBTindakanPelayananT::model()->findByPk($permintaan->tindakanpelayanan_id);
				if(!empty($modTindakanPelayanan->tindakansudahbayar_id)){
					$status_bayar = 'ok';
				}else{
					$status_bayar = 'not';
					TindakanpelayananT::model()->deleteByPk($permintaan->tindakanpelayanan_id);
					TindakankomponenT::model()->deleteAllByAttributes(array('tindakanpelayanan_id'=>$permintaan->tindakanpelayanan_id));
				}
			}

			if($status_bayar == 'ok'){
				$keterangan = "Pemeriksaan tidak bisa dibatalkan karena ada pemeriksaan yang sudah dibayarkan";
//					$keterangan = "<div class='flash-success'>Pemeriksaan tidak bisa dibatalkan karena ada pemeriksaan yang sudah dibayarkan</div>";
			}else{
                // SMS GATEWAY
                $modKirimKeunitlain = PasienkirimkeunitlainT::model()->findByPk($idKirimUnit);
                $modPasien = $modKirimKeunitlain->pasien;
                $nama_pasien = $modPasien->nama_pasien;
                $sms = new Sms();
                foreach ($modSmsgateway as $i => $smsgateway) {
                    $isiPesan = $smsgateway->templatesms;

                    $attributes = $modPasien->getAttributes();
                    foreach($attributes as $attributes => $value){
                        $isiPesan = str_replace("{{".$attributes."}}",$value,$isiPesan);
                    }
               
                    $isiPesan = str_replace("{{hari}}",MyFormatter::getDayName(date('Y-m-d')),$isiPesan);
                    $isiPesan = str_replace("{{sekarang}}",MyFormatter::formatDateTimeForUser(date('Y-m-d')),$isiPesan);
                    
                    if($smsgateway->tujuansms == Params::TUJUANSMS_PASIEN && $smsgateway->statussms){
                        if(!empty($modPasien->no_mobile_pasien)){
                            $sms->kirim($modPasien->no_mobile_pasien,$isiPesan);
                        }
                        else{
                            $smspasien = 0;
                        }
                    }
                    
                }
                // END SMS GATEWAY
				PermintaankepenunjangT::model()->deleteAllByAttributes(array('pasienkirimkeunitlain_id'=>$idKirimUnit));
				PasienkirimkeunitlainT::model()->deleteByPk($idKirimUnit);
				
                $status = 'ok';	
				$keterangan = "pasien berhasil dibatalkan";
			}

			/*
			 * kondisi_commit
			 */
			if($status == 'ok')
			{
				$transaction->commit();
			}else{
				$transaction->rollback();
			}

		}catch(Exception $ex){
			print_r($ex);
			$status = 'not';
			$transaction->rollback();
		}            
		$data = array(
			'status'=>$status,
            'keterangan'=>$keterangan,
            'smspasien'=>$smspasien,
            'nama_pasien'=>$nama_pasien,

		);
		echo json_encode($data);
		 Yii::app()->end();
		}
	}
}