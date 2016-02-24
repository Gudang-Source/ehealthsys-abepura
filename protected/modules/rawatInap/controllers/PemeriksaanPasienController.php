<?php
Yii::import('rawatInap.controllers.PasienRawatInapController'); //Untuk menggunakan function saveAkomodasi()
class PemeriksaanPasienController extends MyAuthController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column1';
	public $defaultAction = 'index';
	public $path_view = 'rawatInap.views.pemeriksaanPasien.';
	
	public function actionIndex($pendaftaran_id, $pasienadmisi_id)
	{
            $modPendaftaran = RIPendaftaranT::model()->with('jeniskasuspenyakit')->findByPk($pendaftaran_id);
            $modPasien = RIPasienM::model()->findByPk($modPendaftaran->pasien_id);
            $modAdmisi = RIPasienAdmisiT::model()->findByPk($pasienadmisi_id);
			$format = new MyFormatter();
			
			if(Yii::app()->user->getState('akomodasiotomatis') == true){ //RND-7757
                                $transaction_ako = Yii::app()->db->beginTransaction();
				$ok = PasienRawatInapController::saveAkomodasi($modPendaftaran, $modAdmisi);
                                //var_dump($ok); die;
                                //
                                
                                if ($ok) {
                                    $transaction_ako->commit();
                                    Yii::app()->user->setFlash('success',"Biaya akomodasi pasien otomatis diperbaharui!");
                                } else {
                                    $transaction_ako->rollback();
                                    Yii::app()->user->setFlash('error',"Biaya akomodasi pasien gagal tersimpan. Silahkan cek tarif akomodasi!");
                                }
                                
                                //die;
                                //$modMasukKamar = RIMasukKamarT::model()->findByAttributes(array('pasienadmisi_id'=>$modAdmisi->pasienadmisi_id),array("order"=>"masukkamar_id DESC"));
				/*
                                if(PasienRawatInapController::cekAkomodasiHariIni($modPendaftaran, $modAdmisi, $modMasukKamar)){
					$transaction_ako = Yii::app()->db->beginTransaction();
					try {
						$selisihHari = CustomFunction::hitungHari($format->formatDateTimeForDb($modMasukKamar->tglmasukkamar));
						if(PasienRawatInapController::saveAkomodasi($modPendaftaran, $modAdmisi, $selisihHari)){
							$transaction_ako->commit();
							Yii::app()->user->setFlash('success',"Biaya akomodasi pasien otomatis diperbaharui!");
						}else{
							$transaction_ako->rollback();
							Yii::app()->user->setFlash('error',"Biaya akomodasi pasien gagal tersimpan. Silahkan cek tarif akomodasi!");
						}
					}catch (Exception $exc) {
						$transaction_ako->rollback();
						Yii::app()->user->setFlash('error',"Data gagal disimpan ".MyExceptionMessage::getMessage($exc,true));
					}
				}else{
					//Yii::app()->user->setFlash('warning',"Tidak ada perubahan biaya akomodasi!");
				} */
			}

			
            $this->render('index',array(
                'modPendaftaran'=>$modPendaftaran,
                'modPasien'=>$modPasien,
                'modAdmisi'=>$modAdmisi,
            ));
	}
}
