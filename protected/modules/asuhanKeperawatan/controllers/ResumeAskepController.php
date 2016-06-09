<?php

class ResumeAskepController extends MyAuthController {

	protected $successSave = true;
	public $path_view = "asuhanKeperawatan.views.resumeAskep.";

	public function actionIndex() {
		if (isset($_GET['frame'])) {
			$this->layout = "//layouts/iframe";
		}
		$modPendaftaran = new ASPendaftaranT;
		$modPasien = new ASPasienM;
		$model = new ASResumeaskepR;
		$modDiagnosa = new ASDiagnosaM;
		$modPulang = new ASPasienpulangT;

		$nama_modul = Yii::app()->controller->module->id;
		$nama_controller = Yii::app()->controller->id;
		$nama_action = Yii::app()->controller->action->id;
		$modul_id = ModulK::model()->findByAttributes(array('url_modul' => $nama_modul))->modul_id;

		$url_batal = Yii::app()->createAbsoluteUrl(
				Yii::app()->controller->module->id . '/' . Yii::app()->controller->id
		);
		if (isset($_GET['resumeaskep_id'])) {
			$model = ASResumeaskepR::model()->findByPk($_GET['resumeaskep_id']);
			
			$criteria = new CdbCriteria();
			$criteria->select = 't.*,pegawai.*';
			$criteria->join = 'JOIN pegawai_m AS pegawai ON pegawai.pegawai_id = t.pegawai_id';
			$criteria->addCondition('pendaftaran_id = '. $model->pendaftaran_id);
			$modPendaftaran = ASPendaftaranT::model()->find($criteria);
			$modPasien = ASPasienM::model()->findByPk($modPendaftaran->pasien_id);
			$modPasienMorb = ASPasienmorbiditasT::model()->findByAttributes(array('pasien_id' => $modPendaftaran->pasien_id));
			if (!empty($modPasienMorb->diagnosa_id)) {
				$modDiagnosa = ASDiagnosaM::model()->findByAttributes(array('diagnosa_id' => $modPasienMorb->diagnosa_id));
			} else {
				$modDiagnosa = new ASDiagnosaM;
			}
		}

		$successSave = false;
//		echo "<pre>";
//		print_r($_POST);
//		echo "</pre>";
//		exit;
		if (isset($_POST['ASResumeaskepR']) && !empty($_POST['ASPendaftaranT']['pendaftaran_id'])) {
			$modPendaftaran = ASPendaftaranT::model()->findByPk($_POST['ASPendaftaranT']['pendaftaran_id']);
			$modPasien = ASPasienM::model()->findByPk($_POST['ASPendaftaranT']['pasien_id']);

			$transaction = Yii::app()->db->beginTransaction();
			try {
				$model = $this->saveResume($_POST['ASResumeaskepR'], $_POST['ASPendaftaranT'], $_POST['ASPasienpulangT']);

				$successSave = $this->successSave;

				if ($successSave) {
					Yii::app()->user->setFlash('success', "Data berhasil disimpan");
					$transaction->commit();
                    $this->redirect(array('index','status'=>1,'resumeaskep_id'=>$model->resumeaskep_id)); 
				} else {
					Yii::app()->user->setFlash('error', "Data gagal disimpan ");
					$transaction->rollback();
				}
			} catch (Exception $exc) {
				Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
				$transaction->rollback();
			}
		}

		$this->render('index', array(
			'modPendaftaran' => $modPendaftaran,
			'modPasien' => $modPasien,
			'modPulang' => $modPulang,
			'modDiagnosa' => $modDiagnosa,
			'model' => $model,
			'successSave' => $successSave,
			'url_batal' => $url_batal
				)
		);
	}

	public function actionLoadDiagnosaMedis($pasien_id) {
		if (Yii::app()->getRequest()->getIsAjaxRequest()) {
			$data['diagnosa_id'] = "";
			$data['diagnosa_nama'] = "";

			$modPasienMorb = ASPasienmorbiditasT::model()->findByAttributes(array('pasien_id' => $pasien_id));
			if (!empty($modPasienMorb->diagnosa_id)) {
				$modDiagnosa = ASDiagnosaM::model()->findByAttributes(array('diagnosa_id' => $modPasienMorb->diagnosa_id));
			} else {
				$modDiagnosa = array();
			}



			if (count($modDiagnosa) > 0) {
				echo "test";
				exit;
				$data['diagnosa_id'] = $modDiagnosa->diagnosa_id;
				$data['diagnosa_nama'] = $modDiagnosa->diagnosa_nama;
			}

			echo CJSON::encode($data);
			Yii::app()->end();
		}
	}

	public function actionLoadDiagnosaTindakanKeperawatan($pendaftaran_id) {
		if (Yii::app()->getRequest()->getIsAjaxRequest()) {
			$data['tindakankeperawatan'] = "";
			$data['diagnosakeperawatan'] = "";
			$modPengkajian = ASPengkajianaskepT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id));
			$modRencana = ASRencanaaskepT::model()->findByAttributes(array('pengkajianaskep_id' => $modPengkajian->pengkajianaskep_id));
			$modImplementasi = ASImplementasiaskepT::model()->findByAttributes(array('rencanaaskep_id' => $modRencana->rencanaaskep_id));
			$modImplementasiDet = ASImplementasiaskepdetT::model()->findAllByAttributes(array('implementasiaskep_id' => $modImplementasi->implementasiaskep_id));
			if (count($modImplementasiDet)) {
				foreach ($modImplementasiDet as $i => $detail) {
					$modDiagnosa = ASDiagnosakepM::model()->findByPk($detail->diagnosakep_id);
					if ($i == 0) {
						$data['diagnosakeperawatan'] = $modDiagnosa->diagnosakep_nama;
					} else {
						$data['diagnosakeperawatan'] .= ',' . $modDiagnosa->diagnosakep_nama;
					}

					$modPilih = ASPilihimplementasiaskepT::model()->findAllByAttributes(array('implementasiaskepdet_id' => $detail->implementasiaskepdet_id));
					if (count($modPilih)) {
						foreach ($modPilih as $j => $pilih) {
							$indikator = ASIndikatorimplkepdetM::model()->findByPk($pilih->indikatorimplkepdet_id);
							if ($j == 0) {
								$data['tindakankeperawatan'] = $indikator->indikatorimplkepdet_indikator;
							} else {
								$data['tindakankeperawatan'] .= ',' . $indikator->indikatorimplkepdet_indikator;
							}
						}
					}
				}
			}

			echo CJSON::encode($data);
			Yii::app()->end();
		}
	}

	public function actionLoadRiwayatAnemnesa() {
		if (Yii::app()->request->isAjaxRequest) {
			$format = new MyFormatter();
			$rows = "";
			$loadRiwayat = ASAnamnesaT::model()->findAllByAttributes(array('pendaftaran_id' => $_GET['pendaftaran_id']), array('order' => 'tglanamnesis DESC'));
			if (count($loadRiwayat) > 0) {
				foreach ($loadRiwayat AS $i => $modRiwayatAnemnesa) {
					$rows .= $this->renderPartial($this->path_view . "_rowRiwayatAnemnesa", array('modRiwayatAnemnesa' => $modRiwayatAnemnesa), true);
				}
			}
			echo CJSON::encode(array(
				'rows' => $rows));
		}
		Yii::app()->end();
	}

	public function actionLoadRiwayatPeriksaFisik() {
		if (Yii::app()->request->isAjaxRequest) {
			$format = new MyFormatter();
			$rows = "";
			$loadRiwayat = ASPemeriksaanfisikT::model()->findAllByAttributes(array('pendaftaran_id' => $_GET['pendaftaran_id']), array('order' => 'tglperiksafisik DESC'));
			if (count($loadRiwayat) > 0) {
				foreach ($loadRiwayat AS $i => $modRiwayatPeriksaFisik) {
					$rows .= $this->renderPartial($this->path_view . "_rowRiwayatPemeriksaanFisik", array('modRiwayatPeriksaFisik' => $modRiwayatPeriksaFisik), true);
				}
			}
			echo CJSON::encode(array(
				'rows' => $rows));
		}
		Yii::app()->end();
	}

	protected function saveResume($post, $pendaftaran, $pulang) {
		$model = new ASResumeaskepR;
		$model->attributes = $post;
		$model->pasien_id = $pendaftaran['pasien_id'];
		$model->pendaftaran_id = $pendaftaran['pendaftaran_id'];
		$model->pegawai_id = $post['pegawai_id'];
		$model->namaperawat = $post['nama_pegawai'];
		$model->ruangan_id = Yii::app()->user->ruangan_id;
		$model->noresume = MyGenerator::noResumeAskep();
		$model->tglresume = MyFormatter::formatDateTimeForDb($post['tglresume']);
		$model->tglmasukrs = MyFormatter::formatDateTimeForDb($pendaftaran['tgl_pendaftaran']);
		$model->tglkeluarrs = !empty($pulang['tglpasienpulang']) ? MyFormatter::formatDateTimeForDb($pulang['tglpasienpulang']) : date('Y-m-d H:i:s');
		$model->create_ruangan = Yii::app()->user->ruangan_id;
		$model->create_time = date('Y-m-d');
		$model->create_loginpemakai_id = Yii::app()->user->id;
		
		if ($model->validate()) {
			$model->save();
			$this->successSave = $this->successSave && true;
		} else {
			$this->successSave = false;
		}

		return $model;
	}

	public function actionPrint() {
		$model = ASResumeaskepR::model()->findByPk($_REQUEST['resumeaskep_id']);
		$modPasien = ASInfopasienmasukkamarV::model()->findByAttributes(array('pendaftaran_id'=>$model->pendaftaran_id));
		$modPasienMorb = ASPasienmorbiditasT::model()->findByAttributes(array('pasien_id' => $modPasien->pasien_id));
		if (!empty($modPasienMorb->diagnosa_id)) {
			$modDiagnosa = ASDiagnosaM::model()->findByAttributes(array('diagnosa_id' => $modPasienMorb->diagnosa_id));
		} else {
			$modDiagnosa = new ASDiagnosaM();
		}
		$modProfile = ProfilrumahsakitM::model()->findByPk(Params::DEFAULT_PROFIL_RUMAH_SAKIT);
		$judulLaporan = 'Resume Keperawatan';
		$caraPrint = $_REQUEST['caraPrint'];
		if ($caraPrint == 'PRINT') {
			$this->layout = '//layouts/printWindows';
			$this->render($this->path_view . 'Print', array('model' => $model, 'modPasien' => $modPasien, 'modDiagnosa' => $modDiagnosa, 'modProfile'=>$modProfile, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
		} else if ($caraPrint == 'EXCEL') {
			$this->layout = '//layouts/printExcel';
			$this->render($this->path_view . 'Print', array('model' => $model, 'modPasien' => $modPasien, 'modDiagnosa' => $modDiagnosa, 'modProfile'=>$modProfile,'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
		} else if ($_REQUEST['caraPrint'] == 'PDF') {
			$ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');   //Ukuran Kertas Pdf
			$posisi = Yii::app()->user->getState('posisi_kertas');   //Posisi L->Landscape,P->Portait
			$mpdf = new MyPDF('', $ukuranKertasPDF);
			$mpdf->useOddEven = 2;
			$stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
			$mpdf->WriteHTML($stylesheet, 1);
			$mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
			$mpdf->WriteHTML($this->renderPartial($this->path_view . 'Print', array('model' => $model, 'modPasien' => $modPasien, 'modProfile'=>$modProfile,'modDiagnosa' => $modDiagnosa, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
			$mpdf->Output();
		}
	}
}
