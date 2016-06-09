<?php

class FaktorRisikoController extends MyAuthController {

	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout = '//layouts/iframe';
	public $defaultAction = 'admin';
	public $simpan = true;
	public $path_view = 'sistemAdministrator.views.faktorRisiko.';

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id) {
		$this->render($this->path_view. 'view', array(
			'model' => $this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate() {
		$model = new SAFaktorrisikoM;
		$modDetail = new SAFaktorrisikodetM;
		if (isset($_POST['SAFaktorrisikoM'])) {
			$transaction = Yii::app()->db->beginTransaction();
			try {
				$model->attributes = $_POST['SAFaktorrisikoM'];
				$model->faktorrisiko_nama = $_POST['SAFaktorrisikoM']['faktorrisiko_nama'];

				$batkar = SAFaktorrisikoM::model()->findByAttributes(array('diagnosakep_id' => $_POST['SAFaktorrisikoM']['diagnosakep_id'], 'faktorrisiko_nama' => $_POST['SAFaktorrisikoM']['faktorrisiko_nama']));
				if (count($batkar)) {
					$this->simpanBatasDetail($batkar->faktorrisiko_id, $_POST['SAFaktorrisikodetM']);
				} else {
					if ($model->save()) {
						$this->simpanBatasDetail($model->faktorrisiko_id, $_POST['SAFaktorrisikodetM']);
					}
				}

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
		$this->render($this->path_view. 'create', array(
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
		$modDetail = new SAFaktorrisikodetM;
		if (isset($_POST['SAFaktorrisikoM'])) {
			$transaction = Yii::app()->db->beginTransaction();
			try {
				$model->updateByPk($id, array('diagnosakep_id' => $_POST['SAFaktorrisikoM']['diagnosakep_id'], 'faktorrisiko_nama' => $_POST['SAFaktorrisikoM']['faktorrisiko_nama']));
				$this->simpanBatasDetail($id, $_POST['SAFaktorrisikodetM']);
//                echo "<pre>";
//				print_r($_POST['SALookupM']);exit;
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

		$this->render($this->path_view. 'update', array(
			'model' => $model,
			'modDetail' => $modDetail
		));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex() {
		$dataProvider = new CActiveDataProvider('SAFaktorrisikoM');
		$this->render($this->path_view. 'index', array(
			'dataProvider' => $dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin() {
		$model = new SAFaktorrisikodetM('search');
		$model->unsetAttributes();  // clear any default values
		if (isset($_GET['SAFaktorrisikodetM'])) {
			$model->attributes = $_GET['SAFaktorrisikodetM'];
			$model->diagnosakep_nama = isset($_GET['SAFaktorrisikodetM']['diagnosakep_nama']) ? $_GET['SAFaktorrisikodetM']['diagnosakep_nama'] : "";
			$model->faktorrisiko_nama = isset($_GET['SAFaktorrisikodetM']['faktorrisiko_nama']) ? $_GET['SAFaktorrisikodetM']['faktorrisiko_nama'] : "";
			$model->aktif = isset($_GET['aktif']) ? $_GET['aktif'] : NULL;
			
		}
		$this->render($this->path_view. 'admin', array(
			'model' => $model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id) {

		$model = SAFaktorrisikoM::model()->findBySql('SELECT faktorrisiko_m.*,diagnosakep_m.diagnosakep_nama
			FROM faktorrisiko_m
			JOIN diagnosakep_m ON diagnosakep_m.diagnosakep_id = faktorrisiko_m.diagnosakep_id
			WHERE faktorrisiko_m.faktorrisiko_id ='.$id);

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
		$model = new SAFaktorrisikoM;
		$model->attributes = $post;
		$model->faktorrisiko_nama = $post['faktorrisiko_nama'];

		if (!$model->save()) {
			$this->simpan &= false;
		}
	}

	public function simpanBatasDetail($faktorrisiko_id, $post) {
		foreach ($post as $i => $row) {
			
			if (!empty($row['faktorrisikodet_id'])) {
				SAFaktorrisikodetM::model()->updateByPk($row['faktorrisikodet_id'], array('faktorrisikodet_indikator' => $row['faktorrisikodet_indikator'],
					'faktorrisikodet_aktif' => $row['faktorrisikodet_aktif']));
				$this->simpan &= true;
			} else {
				$model = new SAFaktorrisikodetM;
				$model->attributes = $row;
				$model->faktorrisiko_id = $faktorrisiko_id;
				$model->faktorrisikodet_indikator = $row['faktorrisikodet_indikator'];
				$model->faktorrisikodet_aktif = $row['faktorrisikodet_aktif'];
				if (!$model->save()) {
					$this->simpan &= false;
				}
			}
		}
	}


	public function actionPrint() {
		$model = new SAFaktorrisikodetM;
		$model->attributes = $_REQUEST['SAFaktorrisikodetM'];
		$judulLaporan = 'Data Faktor Risiko';
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

	public function actionGetLookup($diagnosakep_id, $faktorrisiko_nama) {
		if (Yii::app()->getRequest()->getIsAjaxRequest()) {
			$model = new SAFaktorrisikodetM();
			$batkar = SAFaktorrisikoM::model()->findByAttributes(array('diagnosakep_id' => $diagnosakep_id, 'faktorrisiko_nama' => $faktorrisiko_nama));
			$data['form'] = "";
			if (isset($batkar->faktorrisiko_id)) {
				$models = $this->loadModelByType($batkar->faktorrisiko_id);
			} else if (isset($_POST['faktorrisiko_id'])) {
				$models = $this->loadModelByType($_POST['faktorrisiko_id']);
			} else {
				$models = array();
			}
			if (count($models) > 0) {
				foreach ($models AS $i => $model) {
					$data['form'] .= $this->renderPartial($this->path_view. '_rowLookup', array('model' => $model), true);
				}
			} else {
				$data['form'] .= $this->renderPartial($this->path_view. '_rowLookup', array('model' => $model), true);
			}
			echo CJSON::encode($data);
			Yii::app()->end();
		}
	}

	private function loadModelByType($faktorrisiko_id) {
		$model = SAFaktorrisikodetM::model()->findAllByAttributes(array('faktorrisiko_id' => $faktorrisiko_id), array('order' => 'faktorrisiko_id'));
		if ($model === null)
			throw new CHttpException(404, 'The requested page does not exist.');
		return $model;
	}

	public function actionDelete() {
		if (Yii::app()->request->isPostRequest) {
			$id = $_POST['id'];
			SAFaktorrisikodetM::model()->deleteByPk($id);
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
			$update = SAFaktorrisikodetM::model()->updateByPk($id, array('faktorrisikodet_aktif' => false));
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
