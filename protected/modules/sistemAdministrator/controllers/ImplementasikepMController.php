<?php

class ImplementasikepMController extends MyAuthController {

	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout = '//layouts/column1';
	public $defaultAction = 'admin';
	public $simpan = true;
	public $path_view = 'sistemAdministrator.views.implementasiKep.';

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
		$model = new SAImplementasikepM;
		$modDetail = new SAIndikatorimplkepdetM;
		if (isset($_POST['SAImplementasikepM'])) {
			$transaction = Yii::app()->db->beginTransaction();
			try {
				$model->attributes = $_POST['SAImplementasikepM'];
				
				$batkar = SAImplementasikepM::model()->findByAttributes(array('diagnosakep_id' => $_POST['SAImplementasikepM']['diagnosakep_id']));
				if (count($batkar)) {
                                        SAIndikatorimplkepdetM::model()->deleteAllByAttributes(array('implementasikep_id'=>$batkar->implementasikep_id));
					$this->simpanBatasDetail($batkar->implementasikep_id, $_POST['SAIndikatorimplkepdetM']);
				} else {
					if ($model->save()) {
						$this->simpanBatasDetail($model->implementasikep_id, $_POST['SAIndikatorimplkepdetM']);
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
		$modDetail = new SAIndikatorimplkepdetM;
		if (isset($_POST['SAImplementasikepM'])) {
			$transaction = Yii::app()->db->beginTransaction();
			try {
				$model->updateByPk($id, array('diagnosakep_id' => $_POST['SAImplementasikepM']['diagnosakep_id']));
                                SAIndikatorimplkepdetM::model()->deleteAllByAttributes(array('implementasikep_id'=>$id));
				$this->simpanBatasDetail($id, $_POST['SAIndikatorimplkepdetM']);
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

		$this->render($this->path_view . 'update', array(
			'model' => $model,
			'modDetail' => $modDetail
		));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex() {
		$dataProvider = new CActiveDataProvider('SAImplementasikepM');
		$this->render($this->path_view . 'index', array(
			'dataProvider' => $dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin() {
		$model = new SAIndikatorimplkepdetM('search');
		$model->unsetAttributes();  // clear any default values
		if (isset($_GET['SAIndikatorimplkepdetM'])) {
			$model->attributes = $_GET['SAIndikatorimplkepdetM'];
                        $model->diagnosakep_id = isset($_GET['SAIndikatorimplkepdetM']['diagnosakep_id']) ? $_GET['SAIndikatorimplkepdetM']['diagnosakep_id'] : "" ;
			$model->diagnosakep_nama = isset($_GET['SAIndikatorimplkepdetM']['diagnosakep_nama']) ? $_GET['SAIndikatorimplkepdetM']['diagnosakep_nama'] : "" ;
			$model->aktif = isset($_GET['aktif']) ? $_GET['aktif'] : NULL ;
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

		$model = SAImplementasikepM::model()->findBySql('SELECT implementasikep_m.*,diagnosakep_m.diagnosakep_nama
			FROM implementasikep_m
			JOIN diagnosakep_m ON diagnosakep_m.diagnosakep_id = implementasikep_m.diagnosakep_id
			WHERE implementasikep_m.implementasikep_id =' . $id);

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
		$model = new SAImplementasikepM;
		$model->attributes = $post;
		if (!$model->save()) {
			$this->simpan &= false;
		}
	}

	public function simpanBatasDetail($implementasikep_id, $post) {
		foreach ($post as $i => $row) {
			/*if (!empty($row['implementasikep_id'])) {
				
				SAIndikatorimplkepdetM::model()->updateByPk($row['indikatorimplkepdet_id'], array('indikatorimplkepdet_indikator' => $row['indikatorimplkepdet_indikator'],
					'indikatorimplkepdet_aktif' => $row['indikatorimplkepdet_aktif']));
				$this->simpan &= true;
			} else {*/
				$model = new SAIndikatorimplkepdetM;
				$model->attributes = $row;
				$model->implementasikep_id = $implementasikep_id;
				$model->indikatorimplkepdet_indikator = $row['indikatorimplkepdet_indikator'];
				$model->indikatorimplkepdet_aktif = $row['indikatorimplkepdet_aktif'];
				if (!$model->save()) {
					$this->simpan &= false;
				}
			//}
		}
	}

	public function updateBatasDetail($lookup_type, $post) {
		foreach ($post as $i => $lookup) {

			if (!empty($lookup['lookup_id'])) {
				$model = new SAIndikatorimplkepdetM;
				$model->attributes = $lookup;
				$model->lookup_type = $lookup_type;
				SALookupM::model()->updateByPk($lookup['lookup_id'], array('lookup_name' => $model->lookup_name,
					'lookup_value' => $model->lookup_value,
					'lookup_kode' => $model->lookup_kode,
					'lookup_urutan' => $model->lookup_urutan));
			}
		}
	}

	public function actionPrint() {
		$model = new SAIndikatorimplkepdetM;
		$model->attributes = $_REQUEST['SAIndikatorimplkepdetM'];
                if (isset($_GET['SAIndikatorimplkepdetM'])) {
			$model->attributes = $_GET['SAIndikatorimplkepdetM'];
                        $model->diagnosakep_id = isset($_GET['SAIndikatorimplkepdetM']['diagnosakep_id']) ? $_GET['SAIndikatorimplkepdetM']['diagnosakep_id'] : "" ;
			$model->diagnosakep_nama = isset($_GET['SAIndikatorimplkepdetM']['diagnosakep_nama']) ? $_GET['SAIndikatorimplkepdetM']['diagnosakep_nama'] : "" ;			
		}
                
		$judulLaporan = 'Data Implementasi Keperawatan';
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
			$model = new SAIndikatorimplkepdetM;
			$batkar = SAImplementasikepM::model()->findByAttributes(array('diagnosakep_id' => $diagnosakep_id));
			$data['form'] = "";
			if (isset($batkar->implementasikep_id)) {
				$models = $this->loadModelByType($batkar->implementasikep_id);
			} else if (isset($_POST['implementasikep_id'])) {
				$models = $this->loadModelByType($_POST['implementasikep_id']);
			} else {
				$models = array();
			}
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

	private function loadModelByType($implkep_id) {
		$model = SAIndikatorimplkepdetM::model()->findAllByAttributes(array('implementasikep_id' => $implkep_id), array('order' => 'implementasikep_id'));
		if ($model === null)
			throw new CHttpException(404, 'The requested page does not exist.');
		return $model;
	}

	public function actionDelete() {
		if (Yii::app()->request->isPostRequest) {
			$id = $_POST['id'];
			SAIndikatorimplkepdetM::model()->deleteByPk($id);
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
	public function actionRemoveTemporary() {
		$id = $_POST['id'];
		if (isset($_POST['id'])) {
			$update = SAIndikatorimplkepdetM::model()->updateByPk($id, array('indikatorimplkepdet_aktif' => 0));
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

	public function actionAutoCompleteDiagnosaKeperawatan() {
		if (Yii::app()->request->isAjaxRequest) {
			$returnVal = array();
			$term = isset($_GET['term']) ? $_GET['term'] : null;
			$criteria = new CDbCriteria();
			$criteria = new CDbCriteria();
//                $criteria->compare('LOWER(nmrincianobyek)', strtolower($_GET['term']), true);
			$term = strtolower(trim($_GET['term']));

			$condition = "LOWER(diagnosakep_kode) LIKE '%" . $term . "%' OR LOWER(diagnosakep_nama) LIKE '%" . $term . "%' AND diagnosakep_aktif = TRUE";
			$criteria->addCondition($condition);
			$criteria->order = 'diagnosakep_nama';
			$criteria->limit = 5;

			$models = SADiagnosakepM::model()->findAll($criteria);
			foreach ($models as $i => $model) {
				$attributes = $model->attributeNames();
				foreach ($attributes as $j => $attribute) {
					$returnVal[$i]["$attribute"] = $model->$attribute;
				}
				$returnVal[$i]['label'] = $model->diagnosakep_kode;
				$returnVal[$i]['value'] = $model->diagnosakep_nama;
			}

			echo CJSON::encode($returnVal);
		}
		Yii::app()->end();
	}

}
