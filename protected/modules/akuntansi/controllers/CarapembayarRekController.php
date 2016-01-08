<?php

class CarapembayarRekController extends MyAuthController {

	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout = '//layouts/column1';
	public $defaultAction = 'admin';

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id) {
		$model = CarapembrekM::model()->findByAttributes(array('carapembayaran' => $id));
		$this->render('view', array(
			'model' => $model,
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate() {
		//if(!Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
		$model = new AKCarapembayarRekM();

		// $modCarabayar = new CarabayarM();
		// if (isset($_GET['CarabayarM'])){
		//         $modCarabayar->unsetAttributes();
		//         $modCarabayar->attributes=$_GET['CarabayarM'];
		//         $modCarabayar->carabayar_id = $_GET['CarabayarM']['carabayar_id'];
		// }

		$modCarabayar = new AKLookupM();
		$modDetails = array();

		if (isset($_GET['AKLookupM'])) {
			$modCarabayar->unsetAttributes();
			$modCarabayar->attributes = $_GET['AKLookupM'];
			//$modCarabayar->carabayar_id = $_GET['CarabayarM']['carabayar_id'];
		}

		if (isset($_POST['AKCarapembayarRekM'])) {

			$transaction = Yii::app()->db->beginTransaction();
			try {
				$success = true;
				$modDetails = $this->validasiTabular($_POST['AKCarapembayarRekM']);
				// var_dump(count($modDetails));
				// exit;
				foreach ($modDetails as $i => $data) {
					// echo '<pre>';
					// echo print_r($data->carabayar_id);                                       
					if (isset($data)) {
						// if ($data->update()) {
						//     $success = true;
						// } else {
						//     $success = false;
						// }
						// echo '<pre>';
						// echo print_r($data->getErrors());
						// echo '</pre>';
						// exit();
						$data->save();
						// print_r($data->getErrors());
					} else {
						$data->save();
					}
				}
				// exit();

				if ($success == true) {
					$transaction->commit();
					Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
					$this->redirect(array('admin'));
				} else {
					$transaction->rollback();
					Yii::app()->user->setFlash('error', "Data gagal disimpan ");
				}
			} catch (Exception $ex) {
				$transaction->rollback();
				Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($ex, true));
			}
		}

		$this->render('create', array(
			'model' => $model, 'modCarabayar' => $modCarabayar, 'modDetails' => $modDetails
		));
	}

	protected function validasiTabular($data) {

		$x = 0;
		foreach ($data['rekening'] as $j => $row) {
			foreach ($data['bayar'] as $i => $row2) {
				$modDetails[$x] = new AKCarapembayarRekM;
				$modDetails[$x]->attributes = $row;
				//$modDetails[$x]->carabayar_id = $i;
				$modDetails[$x]->rekening5_id = $row['rekening5_id'];
				$modDetails[$x]->debitkredit = $row['rekening5_nb'];
//	                $modDetails[$x]->rekening4_id = $row['rekening4_id'];
//	                $modDetails[$x]->rekening3_id = $row['rekening3_id'];
//	                $modDetails[$x]->rekening2_id = $row['rekening2_id'];
//	                $modDetails[$x]->rekening1_id = $row['rekening1_id'];
//	                $modDetails[$x]->saldonormal = $row['saldonormal'];
				$modDetails[$x]->carapembayaran = $i;

				$modDetails[$x]->validate();
				$x++;
			}
			// echo '<pre>';
			// echo print_r($modDetails[$i]->getErrors());
			// echo '</pre>';
			//print_r($data['bayar']);
			// exit;
		}
		//print_r(count($modDetails));
		//exit;

		return $modDetails;
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id) {
		//if(!Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
		$model = AKCarapembayarRekM::model()->findByPk($id);

		// Uncomment the following line if AJAX validation is needed


		if (isset($_POST['AKCarapembayarRekM'])) {
			$model->attributes = $_POST['AKCarapembayarRekM'];
			if ($model->save()) {
				Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
				$this->redirect(array('admin', 'id' => $model->carabayar_id));
			}
		}

		$this->render('update', array(
			'model' => $model,
		));
	}

	public function actionUbahRekeningDebit($id) {
		$debet = 'D';
		//if(!Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
		$this->layout = '//layouts/iframe';
		//$model= AKCarapembayarRekM::model()->findByPk($id);
		$model = AKCarapembayarRekM::model()->findByAttributes(array('carapembayaran' => $id));

		// Uncomment the following line if AJAX validation is needed


		if (isset($_POST['AKCarapembayarRekM'])) {
			$model->attributes = $_POST['AKCarapembayarRekM'];
			$view = 'UbahRekeningDebit';

			$update = AKCarapembayarRekM::model()->updateByPk($id, array('rekening5_id' => $_POST['AKCarapembayarRekM']['rekening5_id']));
			if ($update) {
				Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
				if (isset($_GET['frame']) && !empty($_GET['idCarabayar'])) {
					$this->redirect(array(((isset($view)) ? $view : 'UbahRekeningDebitKredit'), 'id' => $model->carapembrek_id, 'frame' => $_GET['frame'], 'idCarabayar' => $_GET['idCarabayar']));
				} else {
					$this->redirect(array(((isset($view)) ? $view : 'admin'), 'id' => $model->carabayar_id));
				}
			}
		}

		$this->render(((isset($view)) ? $view : '_ubahRekeningDebit'), array(
			'model' => $model,
		));
	}

	public function actionUbahRekeningKredit($id) {
		$debet = 'K';
		//if(!Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
		$this->layout = '//layouts/iframe';
		//$model= AKCarapembayarRekM::model()->findByPk($id);
		$model = AKCarapembayarRekM::model()->findByAttributes(array('carapembayaran' => $id));

		// Uncomment the following line if AJAX validation is needed


		if (isset($_POST['AKCarapembayarRekM'])) {
			$model->attributes = $_POST['AKCarapembayarRekM'];
			$view = 'UbahRekeningKredit';

			$update = AKCarapembayarRekM::model()->updateByPk($id, array('rekening5_id' => $_POST['AKCarapembayarRekM']['rekening5_id']));
			if ($update) {
				Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
				if (isset($_GET['frame']) && !empty($_GET['idCarabayar'])) {
					$this->redirect(array(((isset($view)) ? $view : 'UbahRekeningDebitKredit'), 'id' => $model->carapembrek_id, 'frame' => $_GET['frame'], 'idCarabayar' => $_GET['idCarabayar']));
				} else {
					$this->redirect(array(((isset($view)) ? $view : 'admin'), 'id' => $model->carabayar_id));
				}
			}
		}

		$this->render(((isset($view)) ? $view : '_ubahRekeningKredit'), array(
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
			$model = AKCarapembayarRekM::model()->deleteAll('carapembayaran=:carapembayaran', array(':carapembayaran' => $id));

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
		$dataProvider = new CActiveDataProvider('AKCarapembayarRekM');
		$this->render('index', array(
			'dataProvider' => $dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin() {

		$model = new AKCarapembayarRekM('search');
		$model->unsetAttributes();

		if (isset($_GET['AKCarapembayarRekM'])) {
			$model->attributes = $_GET['AKCarapembayarRekM'];
			$model->rekDebit = $_GET['AKCarapembayarRekM']['rekDebit'];
			$model->rekKredit = $_GET['AKCarapembayarRekM']['rekKredit'];
		}

		$this->render('admin', array(
			'model' => $model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id) {
		$model = CarabayarM::model()->findByPk($id);
		if ($model === null)
			throw new CHttpException(404, 'The requested page does not exist.');
		return $model;
	}

	public function loadDelete($id) {
		$model = CarabayarM::model()->findByPk($id);
		if ($model === null)
			throw new CHttpException(404, 'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model) {
		if (isset($_POST['ajax']) && $_POST['ajax'] === 'carabayarrek-m-form') {
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
		AKCarapembayarRekM::model()->updateByPk($id, array('carabayar_aktif ' => false));
		$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	public function actionPrint() {
		$model = new AKCarapembayarRekM;
		if (isset($_REQUEST['AKCarapembayarRekM'])) {
			$model->attributes = $_REQUEST['AKCarapembayarRekM'];
		}
		$judulLaporan = 'Data Cara Bayar Rekening ';
		$caraPrint = $_REQUEST['caraPrint'];
		if ($caraPrint == 'PRINT') {
			$this->layout = '//layouts/printWindows';
			$this->render('Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
		} else if ($caraPrint == 'EXCEL') {
			$this->layout = '//layouts/printExcel';
			$this->render('Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
		} else if ($_REQUEST['caraPrint'] == 'PDF') {
			$ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');				  //Ukuran Kertas Pdf
			$posisi = Yii::app()->user->getState('posisi_kertas');						   //Posisi L->Landscape,P->Portait
			$mpdf = new MyPDF('', $ukuranKertasPDF);
			$mpdf->useOddEven = 2;
			$stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
			$mpdf->WriteHTML($stylesheet, 1);
			$mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
			$mpdf->WriteHTML($this->renderPartial('Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
			$mpdf->Output();
		}
	}

	public function actionGetRekeningEditDebitKreditCarabayar() {
		if (Yii::app()->request->isAjaxRequest) {
//          $rekening1_id     = $_POST['rekening1_id'];
//          $rekening2_id     = $_POST['rekening2_id'];
//          $rekening3_id     = $_POST['rekening3_id'];
//          $rekening4_id     = $_POST['rekening4_id'];
			$rekening5_id = $_POST['rekening5_id'];
//          $carabayar_id     = $_POST['carabayar_id'];
			$carapembrek_id = $_POST['carapembrek_id'];
//          $saldonormal      = $_POST['saldonormal'];

			$update = AKCarapembayarRekM::model()->updateByPk($carapembrek_id, array('rekening5_id' => $rekening5_id));
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
