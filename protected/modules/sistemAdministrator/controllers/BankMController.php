
<?php

class BankMController extends MyAuthController {

	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout = '//layouts/column1';
	public $defaultAction = 'admin';
	public $path_view = 'sistemAdministrator.views.bankM.';
        public $link_bank = 'sistemAdministrator/bankM';
        public $link_rekening = 'sistemAdministrator/rekeningBank';

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id) {
		$model = SABankRekM::model()->findByAttributes(array('bank_id' => $id));

		$this->render($this->path_view . 'view', array(
			'model' => $model,
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate($sukses='') {
            if ($sukses == 1):
                Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
            endif;
		//if(!Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
		$model = new SABankM;

		// Uncomment the following line if AJAX validation is needed


		if (isset($_POST['SABankM'])) {
			$model->attributes = $_POST['SABankM'];
			$model->bank_aktif = TRUE;
			if ($model->save()) {
				Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
				$this->redirect(array('create', 'sukses' => 1));
			}
		}

		$this->render($this->path_view . 'create', array(
			'model' => $model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id, $sukses='') {
		//if(!Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
		$model = $this->loadModel($id);
                 if ($sukses == 1):
                     Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
                 endif;
		// Uncomment the following line if AJAX validation is needed


		if (isset($_POST['SABankM'])) {
			$model->attributes = $_POST['SABankM'];
			if ($model->save()) {
				Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
				$this->redirect(array($this->path_view . 'admin', 'id' => $model->bank_id));
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
			$model = SABankRekM::model()->deleteAllByAttributes(array('bank_id' => $id));

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if (!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array($this->path_view . 'admin'));
		} else
			throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex() {
		$dataProvider = new CActiveDataProvider('SABankM');
		$this->render('index', array(
			'dataProvider' => $dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin() {
		$model = new SABankRekM('search');
		$model->unsetAttributes();  // clear any default values
		if (isset($_GET['SABankRekM'])) {
			$model->attributes = $_GET['SABankRekM'];
		}
		$this->render($this->path_view . 'admin', array(
			'model' => $model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id) {
		$model = SABankM::model()->findByPk($id);
		if ($model === null)
			throw new CHttpException(404, 'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model) {
		if (isset($_POST['ajax']) && $_POST['ajax'] === 'bank-m-form') {
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

	public function actionPrint() {
		$model = new SABankRekM;
		if (isset($_REQUEST['SABankRekM'])) {
			$model->attributes = $_REQUEST['SABankRekM'];
		}
		$judulLaporan = 'Data Rekening Bank';
		$caraPrint = $_REQUEST['caraPrint'];
		if ($caraPrint == 'PRINT') {
			$this->layout = '//layouts/printWindows';
			$this->render($this->path_view. 'Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
		} else if ($caraPrint == 'EXCEL') {
			$this->layout = '//layouts/printExcel';
			$this->render($this->path_view. 'Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
		} else if ($_REQUEST['caraPrint'] == 'PDF') {
			$ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');				  //Ukuran Kertas Pdf
			$posisi = Yii::app()->user->getState('posisi_kertas');						   //Posisi L->Landscape,P->Portait
			$mpdf = new MyPDF('', $ukuranKertasPDF);
			$mpdf->useOddEven = 2;
			$stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
			$mpdf->WriteHTML($stylesheet, 1);
			$mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
			$mpdf->WriteHTML($this->renderPartial($this->path_view. 'Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
			$mpdf->Output($judulLaporan.'_'.date('Y-m-d').'.pdf','I');
		}
	}

	public function actionSetDropdownKabupaten($encode = false, $model_nama = '', $attr = '') {
		if (Yii::app()->request->isAjaxRequest) {
			$model = new SAPasienM;
			if ($model_nama !== '' && $attr == '') {
				$propinsi_id = $_POST["$model_nama"]['propinsi_id'];
			} elseif ($model_nama == '' && $attr !== '') {
				$propinsi_id = $_POST["$attr"];
			} elseif ($model_nama !== '' && $attr !== '') {
				$propinsi_id = $_POST["$model_nama"]["$attr"];
			}
			$kabupaten = null;
			if ($propinsi_id) {
				$kabupaten = $model->getKabupatenItems($propinsi_id);
				$kabupaten = CHtml::listData($kabupaten, 'kabupaten_id', 'kabupaten_nama');
			}
			if ($encode) {
				echo CJSON::encode($kabupaten);
			} else {
				if (empty($kabupaten)) {
					echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
				} else {
					echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
					foreach ($kabupaten as $value => $name) {
						echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
					}
				}
			}
		}
		Yii::app()->end();
	}
	
	public function actionUbahRekeningDebit($id) {
		//if(!Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
		$this->layout = '//layouts/iframe';
		$model = SABankRekM::model()->findByPk($id);
		$modBank = SABankM::model()->findByPk($model->bank_id);

		// Uncomment the following line if AJAX validation is needed


		if (isset($_POST['SAJnsPenerimaanRekM'])) {
			$model->attributes = $_POST['SAJnsPenerimaanRekM'];
			$view = 'UbahRekeningDebit';

			$update = SABankRekM::model()->updateByPk($id, array('rekening5_id' => $_POST['SABankRekM']['rekening5_id']));
			if ($update) {
				Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
				if (isset($_GET['frame']) && !empty($_GET['idBank'])) {
					$this->redirect(array(((isset($view)) ? $view : $this->path_view . 'UbahRekeningKredit'), 'id' => $model->bankrek_id, 'frame' => $_GET['frame'], 'idBank' => $_GET['idBank']));
				} else {
					$this->redirect(array(((isset($view)) ? $view : $this->path_view . 'admin'), 'id' => $model->bank_id));
				}
			}
		}

		$this->render($this->path_view . ((isset($view)) ? $view : '_ubahRekeningDebit'), array(
			'model' => $model,
			'modBank' => $modBank
		));
	}

	public function actionUbahRekeningKredit($id) {
		//if(!Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
		$this->layout = '//layouts/iframe';
		$model = SABankRekM::model()->findByPk($id);
		$modBank = SABankM::model()->findByPk($model->bank_id);

		// Uncomment the following line if AJAX validation is needed


		if (isset($_POST['SAJnsPenerimaanRekM'])) {
			$model->attributes = $_POST['SAJnsPenerimaanRekM'];
			$view = 'UbahRekeningKredit';

			$update = SABankRekM::model()->updateByPk($id, array('rekening5_id' => $_POST['SABankRekM']['rekening5_id']));
			if ($update) {
				Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
				if (isset($_GET['frame']) && !empty($_GET['idBank'])) {
					$this->redirect(array(((isset($view)) ? $view : $this->path_view . 'UbahRekeningKredit'), 'id' => $model->bankrek_id, 'frame' => $_GET['frame'], 'idBank' => $_GET['idBank']));
				} else {
					$this->redirect(array(((isset($view)) ? $view : $this->path_view . 'admin'), 'id' => $model->bank_id));
				}
			}
		}

		$this->render($this->path_view . ((isset($view)) ? $view : '_ubahRekeningKredit'), array(
			'model' => $model,
			'modBank' => $modBank
		));
	}
	
	public function actionGetRekeningEditKreditBank() {
		if (Yii::app()->request->isAjaxRequest) {

			$rekening5_id = $_POST['rekening5_id'];
			$bank_id = $_POST['bank_id'];
			$bankrek_id = $_POST['bankrek_id'];

			$update = SABankRekM::model()->updateByPk($bankrek_id, array('rekening5_id' => $rekening5_id));
			if ($update) {
				$data['pesan'] = '<div class="flash-success">Ubah Data Rekening <b></b> Berhasil  Disimpan </div>';
			} else {
				$data['pesan'] = '<div class="flash-error">Ubah Data Rekening <b></b> Gagal  Disimpan </div>';
			}
			echo json_encode($data);
			Yii::app()->end();
		}
	}
        
        public function actionGetRekeningEditDebitBank() {
		if (Yii::app()->request->isAjaxRequest) {

			$rekening5_id = $_POST['rekening5_id'];
			$bank_id = $_POST['bank_id'];
			$bankrek_id = $_POST['bankrek_id'];

			$update = SABankRekM::model()->updateByPk($bankrek_id, array('rekening5_id' => $rekening5_id));
			if ($update) {
				$data['pesan'] = '<div class="flash-success">Ubah Data Rekening <b></b> Berhasil  Disimpan </div>';
			} else {
				$data['pesan'] = '<div class="flash-error">Ubah Data Rekening <b></b> Gagal  Disimpan </div>';
			}
			echo json_encode($data);
			Yii::app()->end();
		}
	}

}
