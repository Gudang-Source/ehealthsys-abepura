<?php

class RujukanPenunjangController extends MyAuthController
{
	public function actionIndex()
	{
			$criteria = new CDbCriteria;
			if(isset($_GET['ajax']) && $_GET['ajax']=='pasienpenunjangrujukan-m-grid') {
				$format = new MyFormatter;
				echo $format->formatDateTimeForDb($_GET['tgl_akhir']);
				$criteria->compare('LOWER(t.no_pendaftaran)', strtolower($_GET['noPendaftaran']),true);
				$criteria->compare('LOWER(t.nama_pasien)', strtolower($_GET['namaPasien']),true);
				$criteria->compare('LOWER(t.no_rekam_medik)', strtolower($_GET['noRekamMedik']),true);
				$criteria->addBetweenCondition('t.tgl_kirimpasien::date', $format->formatDateTimeForDb($_GET['tgl_awal']), $format->formatDateTimeForDb($_GET['tgl_akhir']));
			} else {
//                $criteria->addBetweenCondition('tgl_pendaftaran', date('Y-m-d'), date('Y-m-d'));
				$criteria->addBetweenCondition('date(t.tgl_pendaftaran)', date('Y-m-d', strtotime('-5 days')).' 00:00:00', date('Y-m-d H:i:s'));
			}
			$criteria->addCondition('t.instalasi_id = '.Yii::app()->user->getState('instalasi_id'));
			$criteria->order='t.tgl_kirimpasien DESC';
			
                        $criteria->join = "join pendaftaran_t p on p.pendaftaran_id = t.pendaftaran_id";
                        $criteria->addCondition('p.pasienbatalperiksa_id is null');
                        
			$dataProvider = new CActiveDataProvider(PasienkirimkeunitlainV::model(), array(
			'criteria'=>$criteria,
		));
			$this->render('index',array('dataProvider'=>$dataProvider));
	}

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
	
	/**
	 * Date		: 12 Juni 2015
	 * Issue	: RND-7153
	 */
	public function actionbatalRujuk()
	{
		if(Yii::app()->request->isAjaxRequest) {
		$pendaftaran_id = $_POST['pendaftaran_id'];
		$idKirimUnit = $_POST['idKirimUnit'];

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

		$transaction = Yii::app()->db->beginTransaction();
		$status = 'ok';
		$status_bayar = 'ok';

		try{			
			$modPermintaanPenunjang = ROPermintaanKePenunjangT::model()->findAllByAttributes(array('pasienkirimkeunitlain_id'=>$idKirimUnit));
			$modPasienKirimUnit = ROPasienKirimKeUnitLainT::model()->findByPk($idKirimUnit);

			foreach($modPermintaanPenunjang as $i=>$permintaan){
				$modTindakanPelayanan = ROTindakanpelayananT::model()->findByPk($permintaan->tindakanpelayanan_id);
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
		                }else{
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
			'nama_pasien'=>$nama_pasien
		);
		echo json_encode($data);
		 Yii::app()->end();
		}
	}
}