<?php

class RujukanPenunjangController extends MyAuthController
{
	public function actionIndex()
	{
            $model = new PasienkirimkeunitlainV;
            $model->tgl_awal = date('Y-m-d', strtotime('-5 days'));
            $model->tgl_akhir = date('Y-m-d');
            
            if (isset($_GET['PasienkirimkeunitlainV'])) {
                $model->attributes = $_GET['PasienkirimkeunitlainV'];
                $model->tgl_awal = MyFormatter::formatDateTimeForDb($_GET['PasienkirimkeunitlainV']['tgl_awal']);
                $model->tgl_akhir = MyFormatter::formatDateTimeForDb($_GET['PasienkirimkeunitlainV']['tgl_akhir']);
            }
            
            $dataProvider = $model->searchRujukRad();
            /*
			$criteria = new CDbCriteria;
			if(isset($_GET['ajax']) && $_GET['ajax']=='pasienpenunjangrujukan-m-grid') {
				$format = new MyFormatter;
				//echo $format->formatDateTimeForDb($_GET['tgl_akhir']);
				if (isset($_GET['no_pendaftaran'])) $criteria->compare('LOWER(t.no_pendaftaran)', strtolower($_GET['noPendaftaran']),true);
				if (isset($_GET['nama_pasien'])) $criteria->compare('LOWER(t.nama_pasien)', strtolower($_GET['namaPasien']),true);
				if (isset($_GET['noRekamMedik'])) $criteria->compare('LOWER(t.no_rekam_medik)', strtolower($_GET['noRekamMedik']),true);
				if (isset($_GET['tgl_awal']) && isset($_GET['tgl_akhir'])) $criteria->addBetweenCondition('t.tgl_kirimpasien::date', $format->formatDateTimeForDb($_GET['tgl_awal']), $format->formatDateTimeForDb($_GET['tgl_akhir']));
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
             * 
             */
			$this->render('index',array('dataProvider'=>$dataProvider, 'model'=>$model));
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

		try {
                    $criteria = new CDbCriteria();
                    $criteria->select = "count(t.permintaankepenunjang_id) as permintaankepenunjang_id";
                    $criteria->join = "join tindakanpelayanan_t tp on tp.tindakanpelayanan_id = t.tindakanpelayanan_id ";
                    $criteria->addCondition("t.pasienkirimkeunitlain_id = ".$idKirimUnit." and tp.tindakansudahbayar_id is not null");
                    $permintaan = PermintaankepenunjangT::model()->find($criteria);
                    if ($permintaan->permintaankepenunjang_id > 0) {
                        $keterangan = "Pemeriksaan tidak bisa dibatalkan karena ada pemeriksaan yang sudah dibayarkan";
                    } else {
                        $ok = true;
                        $kirim = PasienkirimkeunitlainT::model()->findByPk($idKirimUnit);
                        $permintaan = PermintaankepenunjangT::model()->findAllByAttributes(array(
                            'pasienkirimkeunitlain_id'=>$idKirimUnit
                        ));
                        foreach ($permintaan as $item) {
                            if (!empty($item->tindakanpelayanan_id)) {
                                $ok = $ok && TindakanpelayananT::model()->deleteByPk($item->tindakanpelayanan_id);
                            }
                        }
                        $ok = $ok && PermintaankepenunjangT::model()->deleteAllByAttributes(array('pasienkirimkeunitlain_id'=>$idKirimUnit));
                        $ok = $ok && PasienkirimkeunitlainT::model()->deleteByPk($idKirimUnit);
                        $keterangan = "Pasien berhasil dibatalkan";
                        //var_dump($ok);
                        //die;
                        if($status == 'ok') {
                                $this->notifBatalRujuk($kirim);
                                $transaction->commit();
                        } else {
                                $transaction->rollback();
                        }
                    }
                } catch (Exception $ex) {
                    print_r($ex);
                    $status = 'not';
                    $transaction->rollback();
                }
                $data = array(
                    'status'=>$status,
                    'keterangan'=>$keterangan,
                    //'smspasien'=>$smspasien,
                    //'nama_pasien'=>$nama_pasien,
                );
                echo json_encode($data);
                Yii::app()->end(); 
            }
	}
        
        protected function notifBatalRujuk($modKirimKeunitlain) {
            
            $modRuangan = RuanganM::model()->findByPk($modKirimKeunitlain->create_ruangan);
            $pasien_id = $modKirimKeunitlain->pasien_id;
            $modPasien = PasienM::model()->findByPk($pasien_id);
            $judul = 'Pasien Batal Rujuk Radiologi';

            $isi = $modPasien->no_rekam_medik.' - '.$modPasien->nama_pasien
                    .'<br/>Tgl Rujuk : '.MyFormatter::formatDateTimeForUser($modKirimKeunitlain->tgl_kirimpasien);
            
            //var_dump($judul." , ".$isi);
            
            $ok = CustomFunction::broadcastNotif($judul, $isi, array(
                array('instalasi_id'=>$modRuangan->instalasi_id, 'ruangan_id'=>$modRuangan->ruangan_id, 'modul_id'=>$modRuangan->modul_id),
            )); 
        }
}