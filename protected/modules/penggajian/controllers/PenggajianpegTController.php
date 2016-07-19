<?php

class PenggajianpegTController extends MyAuthController {

	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout = '//layouts/column1';
	public $defaultAction = 'create';
	public $path_view = 'penggajian.views.penggajianpegT.';

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id) {
		$this->render($this->path_view . 'view', array(
			'model' => $this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate() {
		//if(!Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
		$format = new MyFormatter();
		$model = new GJPenggajianpegT;
		$model->tglpenggajian = date('Y-m-d H:i:s');

		$model->penerimaanbersih = 0;
		$model->totalpajak = 0;
		$model->totalpotongan = 0;
		$model->totalterima = 0;
		$modPegawai = new GJPegawaiM();
		$komponen = new PenggajiankompT();
		// Uncomment the following line if AJAX validation is needed

		if (isset($_GET['id'])) {
			$model = GJPenggajianpegT::model()->findByPk($_GET['id']);
			$modPegawai = GJPegawaiM::model()->findByPk($model->pegawai_id);
		}


		if (isset($_POST['GJPenggajianpegT'])) {
			$model->attributes = $_POST['GJPenggajianpegT'];
			$model->pegawai_id = $_POST['GJPegawaiM']['pegawai_id'];
			$model->tglpenggajian = $format->formatDateTimeForDb($model->tglpenggajian);
			$model->nopenggajian = MyGenerator::noPenggajian();
			$data = $_POST['PenggajiankompT']['komponengaji_id'];

			$transaction = Yii::app()->db->beginTransaction();
			try {
				if ($model->save()) {
					if (count($data) > 0) {
						$jumlah = 0;
						foreach ($data as $i => $v) {
							$row = new PenggajiankompT();
							$row->komponengaji_id = $i;
							$row->jumlah = $v;
							$row->penggajianpeg_id = $model->penggajianpeg_id;
							if ($row->save()) {
								$jumlah++;
							}
						}
					}
				}

				if ((count($data) > 0) && ($jumlah == count($data))) {
					$transaction->commit();

					if (isset($_POST['GJPegawaiM']['alamatemail'])) {
						// MAILER 
						// Sementara dicommnet supaya tidak error saat create penggajian
//                        $email = $_POST['KPPegawaiM']['alamatemail'];
//                        $name = $_POST['KPPegawaiM']['nama_pegawai'];
//                        // Mailer
//                        $mail = Yii::app()->mailer;
//
//                        $mail->IsSMTP(); // telling the class to use SMTP
//                        $mail->SMTPDebug = 2;                     // enables SMTP debug information (for testing)
//                        // 1 = errors and messages
//                        // 2 = messages only
//                        $mail->SMTPAuth = true;                  // enable SMTP authentication
//                        $mail->SMTPSecure = "tls";                 // sets the prefix to the servier
//                        $mail->Host = "smtp.gmail.com";      // sets GMAIL as the SMTP server
//                        $mail->Port = 587;                   // set the SMTP port for the GMAIL server
//                        $mail->Username = "account@domain.com";  // GMAIL username
//                        $mail->Password = "passwordhere";            // GMAIL password
//
//                        $mail->SetFrom('account@domain.com', 'First Last');
//
//                        $mail->AddReplyTo("account@domain.com", "First Last");
//
//                        $mail->Subject = "PHPMailer Test Subject via smtp (Gmail), basic";
//
//                        $mail->AltBody = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test
//
//                        $mail->Body = "Test";
//                        
//                        $mail->AddAddress($email, $name);
//                        if (!$mail->Send()) {
//                            echo "Mailer Error: " . $mail->ErrorInfo;
//                        } else {
//                            echo "Message sent!";
//                        }
					}

					Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
					$this->redirect(array('create', 'id' => $model->penggajianpeg_id, 'sukses' => 1));
				} else {
					$transaction->rollback();
					Yii::app()->user->setFlash('error', "Data gagal disimpan ");
				}
			} catch (Exception $ex) {
				$transaction->rollback();
				Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($ex, true));
			}
		}

		$this->render($this->path_view . 'create', array(
			'model' => $model, 'modPegawai' => $modPegawai, 'komponen' => $komponen
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id) {
		//if(!Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
		$model = $this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed


		if (isset($_POST['GJPenggajianpegT'])) {
			$model->attributes = $_POST['GJPenggajianpegT'];
			if ($model->save()) {
				Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
				$this->redirect(array('view', 'id' => $model->penggajianpeg_id));
			}
		}

		$this->render($this->path_view . 'update', array(
			'model' => $model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id) {
		if (Yii::app()->request->isPostRequest) {
			// we only allow deletion via POST request
			//if(!Yii::app()->user->checkAccess(Params::DEFAULT_DELETE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
			$this->loadModel($id)->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if (!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		} else
			throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex() {
		$dataProvider = new CActiveDataProvider('GJPenggajianpegT');
		$this->render($this->path_view . 'index', array(
			'dataProvider' => $dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin() {

		$model = new GJPenggajianpegT('search');
		$model->unsetAttributes();  // clear any default values
		if (isset($_GET['GJPenggajianpegT']))
			$model->attributes = $_GET['GJPenggajianpegT'];

		$this->render($this->path_view . 'admin', array(
			'model' => $model,
		));
	}

	public function actionInformasi() {

		$model = new GJPenggajianpegT('search');
		$model->unsetAttributes();  // clear any default values
		if (isset($_GET['GJPenggajianpegT'])) {
			$model->attributes = $_GET['GJPenggajianpegT'];
			$model->nomorindukpegawai = !empty($_GET['GJPenggajianpegT']['nomorindukpegawai']) ? $_GET['GJPenggajianpegT']['nomorindukpegawai'] : '';
			$model->nama_pegawai = !empty($_GET['GJPenggajianpegT']['nama_pegawai']) ? $_GET['GJPenggajianpegT']['nama_pegawai'] : '';
		}

		$this->render($this->path_view . 'informasi', array(
			'model' => $model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id) {
		$model = GJPenggajianpegT::model()->findByPk($id);
		if ($model === null)
			throw new CHttpException(404, 'The requested page does not exist.');
		return $model;
	}

	public function actionDetail($id) {
		$this->render($this->path_view . 'view', array(
			'model' => $this->loadModel($id),
		));
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model) {
		if (isset($_POST['ajax']) && $_POST['ajax'] === 'kppenggajianpeg-t-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	/**
	 * Mengubah status aktif
	 * @param type $id 
	 */
	public function actionRemoveTemporary($id) {
		//if(!Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
		//SAKabupatenM::model()->updateByPk($id, array('kabupaten_aktif'=>false));
		//$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	public function actionPrint($id, $pegawai_id) {
		$modelpegawai = GJPegawaiM::model()->findByPk($pegawai_id);
		$modDetail = PenggajiankompT::model()->findAll('penggajianpeg_id = ' . $id . '');
		$model = PenggajianpegT::model()->find('pegawai_id = ' . $modelpegawai->pegawai_id . ' ');

		$modelpegawai->attributes = (isset($_REQUEST['GJPegawaiM']) ? $_REQUEST['GJPegawaiM'] : null);
		$judulLaporan = '--- Detail Penggajian Pegawai ---';
		$caraPrint = $_REQUEST['caraPrint'];
		if ($caraPrint == 'PRINT') {
			$this->layout = '//layouts/printWindows';
			$this->render($this->path_view . 'Print', array('model' => $model, 'modelpegawai' => $modelpegawai, 'modDetail' => $modDetail, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
		} else if ($caraPrint == 'EXCEL') {
			$this->layout = '//layouts/printExcel';
			$this->render($this->path_view . 'Print', array('model' => $model, 'modelpegawai' => $modelpegawai, 'modDetail' => $modDetail, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
		} else if ($_REQUEST['caraPrint'] == 'PDF') {
			$ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');			  // Ukuran Kertas Pdf
			$posisi = Yii::app()->user->getState('posisi_kertas');										// Posisi L->Landscape,P->Portait
			$mpdf = new MyPDF('', $ukuranKertasPDF);
			$mpdf->useOddEven = 2;
			$mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
			$stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
			$mpdf->WriteHTML($stylesheet, 1);
			$mpdf->WriteHTML($this->renderPartial($this->path_view . 'Print', array('model' => $model, 'modelpegawai' => $modelpegawai, 'modDetail' => $modDetail, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
			$mpdf->Output();
		}
	}

	public function actionDetailPenggajian($id) {
		if (!empty($id)) {
			$modelpegawai = GJPegawaiM::model()->find('pegawai_id = ' . $id . '');
			$model = PenggajianpegT::model()->find('pegawai_id = ' . $modelpegawai->pegawai_id . ' ');
		}

		if (empty($model)) {
			$model = new PenggajianpegT;                        
		}
                $model->totalterima = number_format($model->totalterima,0,"",".");
                $model->totalpotongan = number_format($model->totalpotongan,0,"",".");
                $model->penerimaanbersih = number_format($model->penerimaanbersih,0,"",".");
                $model->totalpajak = number_format($model->totalpajak,0,"",".");
                
		$this->render($this->path_view . 'detailPenggajian', array(
			'modelpegawai' => $modelpegawai,
			'model' => $model,
		));
	}

	public function actionPrintPenggajian($id) {
		$modelpegawai = GJPegawaiM::model()->findByPk($id);
        $model = PenggajianpegT::model()->find('pegawai_id = ' . $modelpegawai->pegawai_id . ' ');
        $modelpegawai->attributes = (isset($_REQUEST['GJPegawaiM']) ? $_REQUEST['GJPegawaiM'] : null);
        if (empty($model)) {
            $model = new PenggajianpegT;
        }
        $judulLaporan = 'Penggajian Pegawai';
        $caraPrint = $_REQUEST['caraPrint'];
        if ($caraPrint == 'PRINT') {
            $this->layout = '//layouts/printWindows';
            $this->render($this->path_view. 'PrintPenggajian', array('model' => $model, 'modelpegawai' => $modelpegawai, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
        } else if ($caraPrint == 'EXCEL') {
            $this->layout = '//layouts/printExcel';
            $this->render($this->path_view. 'PrintPenggajian', array('model' => $model, 'modelpegawai' => $modelpegawai, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
        } else if ($_REQUEST['caraPrint'] == 'PDF') {
            $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');              // Ukuran Kertas Pdf
            $posisi = Yii::app()->user->getState('posisi_kertas');                                        // Posisi L->Landscape,P->Portait
            $mpdf = new MyPDF('', $ukuranKertasPDF);
            $mpdf->useOddEven = 2;
            $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
            $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
            $mpdf->WriteHTML($stylesheet, 1);
            $mpdf->WriteHTML($this->renderPartial($this->path_view. 'PrintPenggajian', array('model' => $model, 'modelpegawai' => $modelpegawai, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
            $mpdf->Output($judulLaporan.'_'.date('Y-m-d').'.pdf','I');
        }
	}

	public function actionAmbilPph() {
		if (Yii::app()->getRequest()->getIsAjaxRequest()) {
			$pkp = $_POST['pkp'];
			// $sql = "SELECT persentarifpenghsl FROM potonganpph21_m WHERE penghasilandari >= $pkp AND sampaidgn_thn <=$pkp ";
			// $persen_pph = Yii::app()->db->createCommand($sql)->queryAll();

			$conditions = "penghasilandari <= " . $pkp . " AND sampaidgn_thn >=" . $pkp . " ";
			$criteria = new CDbCriteria;
			$criteria->addCondition($conditions);
			$modpph = Potonganpph21M::model()->findAll($criteria);

			foreach ($modpph as $key => $pph) {
				$data['percent'] = $pph->persentarifpenghsl;
			}

			echo json_encode($data);
			Yii::app()->end();
		}
	}

	public function actionSetPinjamanKoperasi() {
		if (Yii::app()->getRequest()->getIsAjaxRequest()) {
			$data = array();
			$data['status'] = '';
			$data['jmlcicilan'] = '0';
			$pegawai_id = $_POST['pegawai_id'];
			$sql = "select pinjampegdet_t.jmlcicilan
					from pinjamanpeg_t 
					JOIN pinjampegdet_t ON pinjamanpeg_t.pinjamanpeg_id = pinjampegdet_t.pinjamanpeg_id
					WHERE pinjampegdet_t.bulan = " . date('m') . " AND pinjampegdet_t.tahun ='" . date('Y') . "' AND pegawai_id =" . $pegawai_id;
			$jmlcicilan = Yii::app()->db->createCommand($sql)->queryRow();
			if (isset($jmlcicilan)) {
				if ($jmlcicilan > 0) {
					$data['status'] = 'ada';
					$data['jmlcicilan'] = $jmlcicilan['jmlcicilan'];
				}
			}
			echo json_encode($data);
			Yii::app()->end();
		}
	}

	public function actionSetPtkp() {
		if (Yii::app()->getRequest()->getIsAjaxRequest()) {
			$data = array();
			$data['status'] = '';
			$data['ptkp'] = '0';
			$pegawai_id = $_POST['pegawai_id'];
			$modPegawai = PegawaiM::model()->findByPk($pegawai_id);
			$modSusunan = SusunankelM::model()->findAllByAttributes(array('pegawai_id' => $pegawai_id));
			$sql = "select wajibpajak_thn
					from ptkp_m 
					WHERE LOWER(statusperkawinan) = '" . strtolower($modPegawai->statusperkawinan) . "' AND jmltanggunan ='" . count($modSusunan) . "'";
			$ptkp = Yii::app()->db->createCommand($sql)->queryRow();
			if (isset($ptkp)) {
				if ($ptkp > 0) {
					$data['status'] = 'ada';
					$data['ptkp'] = $ptkp['wajibpajak_thn'];
				}
			}
			echo json_encode($data);
			Yii::app()->end();
		}
	}

}
