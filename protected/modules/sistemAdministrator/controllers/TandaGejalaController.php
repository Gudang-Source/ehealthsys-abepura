<?php

class TandaGejalaController extends MyAuthController {

	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout = '//layouts/iframe';
	public $defaultAction = 'admin';
	public $simpan = true;
	public $path_view = 'sistemAdministrator.views.tandaGejala.';

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
		$model = new SATandagejalaM();
		$modDetail = new SATandagejalaM;
		if (isset($_POST['SATandagejalaM'])) {
			$transaction = Yii::app()->db->beginTransaction();
			try {
				$model->attributes = $_POST['SATandagejalaM'];

				$this->simpanBatasDetail($_POST['SATandagejalaM']['diagnosakep_id'], $_POST['SATandagejalaM']);

				if ($this->simpan) {
					$transaction->commit();
					$this->redirect(array('admin', 'sukses' => 1));
				} else {
					$transaction->rollback();
					Yii::app()->user->setFlash('error', '<strong>Gagal!</strong> Data gagal disimpan!');
				}
			} catch (Exception $exc) {
				$transaction->rollback();
				Yii::app()->user->setFlash('error', '<strong>Gagal!</strong> Data gagal disimpan!' . MyExceptionMessage::getMessage($exc));
			}
		}
		$this->render($this->path_view . 'create', array(
			'model' => $model,
			'modDetail' => $modDetail
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id) {
		$model = $this->loadModel($id);
		$modDetail = new SATandagejalaM;
		if (isset($_POST['SATandagejalaM'])) {
			$transaction = Yii::app()->db->beginTransaction();
			try {
				$this->simpanBatasDetail($_POST['SATandagejalaM']['diagnosakep_id'], $_POST['SATandagejalaM']);

				if ($this->simpan) {
					$transaction->commit();
					$this->redirect(array('admin', 'sukses' => 1));
				} else {
					$transaction->rollback();
					Yii::app()->user->setFlash('error', '<strong>Gagal!</strong> Data gagal disimpan!');
				}
			} catch (Exception $exc) {
				$transaction->rollback();
				Yii::app()->user->setFlash('error', '<strong>Gagal!</strong> Data gagal disimpan!' . MyExceptionMessage::getMessage($exc));
			}
		}

		$this->render($this->path_view . 'update', array(
			'model' => $model,
			'modDetail' => $modDetail
		));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex() {
		$dataProvider = new CActiveDataProvider('SATandagejalaM');
		$this->render($this->path_view . 'index', array(
			'dataProvider' => $dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin() {
		$model = new SATandagejalaM('search');
		$model->unsetAttributes();  // clear any default values
		if (isset($_GET['SATandagejalaM'])) {
			$model->attributes = $_GET['SATandagejalaM'];
			$model->diagnosakep_nama = isset($_GET['SATandagejalaM']['diagnosakep_nama']) ? $_GET['SATandagejalaM']['diagnosakep_nama'] : NULL;
			$model->aktif = isset($_GET['aktif']) ? $_GET['aktif'] : NULL;
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

		$model = SATandagejalaM::model()->findBySql('SELECT tandagejala_m.*,diagnosakep_m.diagnosakep_nama
			FROM tandagejala_m
			JOIN diagnosakep_m ON diagnosakep_m.diagnosakep_id = tandagejala_m.diagnosakep_id
			WHERE tandagejala_m.tandagejala_id =' . $id);

		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model) {
		if (isset($_POST['ajax']) && $_POST['ajax'] === 'salookup-m-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	public function simpanBatas($post) {
		$model = new SATandagejalaM;
		$model->attributes = $post;

		if (!$model->save()) {
			$this->simpan &= false;
		}
	}

	public function simpanBatasDetail($diagnosakep_id, $post) {
		foreach ($post as $i => $row) {
			if (is_numeric($i)) {
				$batkar = SATandagejalaM::model()->findByAttributes(array('diagnosakep_id' => $diagnosakep_id, 'tandagejala_indikator' => $row['tandagejala_indikator']));
				if (count($batkar) || !empty($row['tandagejala_id'])) {
					SATandagejalaM::model()->updateByPk($row['tandagejala_id'], array('tandagejala_indikator' => $row['tandagejala_indikator'],
						'tandagejala_aktif' => $row['tandagejala_aktif']));
					$this->simpan &= true;
				} else {
					$model = new SATandagejalaM;
					$model->attributes = $row;
					$model->diagnosakep_id = $diagnosakep_id;
					$model->tandagejala_indikator = $row['tandagejala_indikator'];
					$model->tandagejala_aktif = $row['tandagejala_aktif'];
					if (!$model->save()) {
						$this->simpan &= false;
					}
				}
			}
		}
	}

	public function actionPrint() {
		$model = new SATandagejalaM;
		$model->attributes = $_REQUEST['SATandagejalaM'];
		$judulLaporan = 'Data Tanda dan Gejala';
		$caraPrint = $_REQUEST['caraPrint'];
		if ($caraPrint == 'PRINT') {
			$this->layout = '//layouts/printWindows';
			$this->render($this->path_view . 'Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
		} else if ($caraPrint == 'EXCEL') {
			$this->layout = '//layouts/printExcel';
			$this->render($this->path_view . 'Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
		} else if ($_REQUEST['caraPrint'] == 'PDF') {
			$ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');   //Ukuran Kertas Pdf
			$posisi = Yii::app()->user->getState('posisi_kertas');   //Posisi L->Landscape,P->Portait
			$mpdf = new MyPDF('', $ukuranKertasPDF);
			$mpdf->useOddEven = 2;
			$stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
			$mpdf->WriteHTML($stylesheet, 1);
			$mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
			$mpdf->WriteHTML($this->renderPartial($this->path_view . 'Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
			$mpdf->Output();
		}
	}

	public function actionGetLookup($diagnosakep_id) {
		if (Yii::app()->getRequest()->getIsAjaxRequest()) {
			$model = new SATandagejalaM();
			$data['form'] = "";
			$models = $this->loadModelByType($diagnosakep_id);
			if (count($models) > 0) {
				foreach ($models AS $i => $model) {
					$data['form'] .= $this->renderPartial($this->path_view . '_rowLookup', array('model' => $model), true);
				}
			} else {
				$data['form'] .= $this->renderPartial($this->path_view . '_rowLookup', array('model' => $model), true);
			}
			echo CJSON::encode($data);
			Yii::app()->end();
		}
	}

	private function loadModelByType($diagnosakep_id) {
		$model = SATandagejalaM::model()->findAllByAttributes(array('diagnosakep_id' => $diagnosakep_id), array('order' => 'tandagejala_id'));
		if ($model === null){
			throw new CHttpException(404, 'The requested page does not exist.');
		}
		return $model;
	}

	public function actionDelete() {
		if (Yii::app()->request->isPostRequest) {
			$id = $_POST['id'];
			SATandagejalaM::model()->deleteByPk($id);
			if (Yii::app()->request->isAjaxRequest) {
				echo CJSON::encode(array(
					'status' => 'proses_form',
					'div' => "<div class='flash-success'>Data berhasil dihapus.</div>",
				));
				exit;
			}
			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if (!isset($_GET['ajax'])) {
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
			}
		} else {
			throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
		}
	}

	/**
	 * Mengubah status aktif
	 * @param type $id 
	 */
	public function actionremoveTemporary() {
		$id = $_POST['id'];
		if (isset($_POST['id'])) {
			$update = SATandagejalaM::model()->updateByPk($id, array('tandagejala_aktif' => false));
			if ($update) {
				if (Yii::app()->request->isAjaxRequest) {
					echo CJSON::encode(array(
						'status' => 'proses_form',
					));
					exit;
				}
			}
		} else {
			if (Yii::app()->request->isAjaxRequest) {
				echo CJSON::encode(array(
					'status' => 'proses_form',
				));
				exit;
			}
		}
	}

}
