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
        $model->cbTglMasuk = true;
        
        if(isset($_GET['LBPasienKirimKeUnitLainV'])){
            $model->attributes = $_GET['LBPasienKirimKeUnitLainV'];
            
            //$model->cbTglMasuk = $_GET['LBPasienKirimKeUnitLainV']['cbTglMasuk'];
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['LBPasienKirimKeUnitLainV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['LBPasienKirimKeUnitLainV']['tgl_akhir']);
        }
        $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
        $this->render('index',array('model'=>$model,'format'=>$format));
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
            $judul = 'Pasien Batal Rujuk Laboratorium';

            $isi = $modPasien->no_rekam_medik.' - '.$modPasien->nama_pasien
                    .'<br/>Tgl Rujuk : '.MyFormatter::formatDateTimeForUser($modKirimKeunitlain->tgl_kirimpasien);
            
            //var_dump($judul." , ".$isi);
            
            $ok = CustomFunction::broadcastNotif($judul, $isi, array(
                array('instalasi_id'=>$modRuangan->instalasi_id, 'ruangan_id'=>$modRuangan->ruangan_id, 'modul_id'=>$modRuangan->modul_id),
            )); 
        }
}