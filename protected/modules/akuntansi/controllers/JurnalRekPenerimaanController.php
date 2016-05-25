
<?php

class JurnalRekPenerimaanController extends MyAuthController {

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
		$model = AKJnsPenerimaanRekM::model()->findByAttributes(array('jenispenerimaan_id' => $id));

		$this->render('view', array(
			'model' => $model,
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate($id='') {
		//if(!Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
                if ($id == 1):
                    Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
                endif;
                
		$model = new AKJenispenerimaanM;

		// Uncomment the following line if AJAX validation is needed


		if (isset($_POST['AKJenispenerimaanM'])) {
                        // var_dump($_POST);
                        $trans = Yii::app()->db->beginTransaction();
			$ok = true;
                        $model->attributes = $_POST['AKJenispenerimaanM'];
                        
                        if ($model->validate()) $ok = $ok && $model->save();
                        else $ok = false;
                        
                        if (isset($_POST['AKJnsPenerimaanRekM'])) {
                            foreach ($_POST['AKJnsPenerimaanRekM']['rekening'] as $item) {
                                $det = new AKJnsPenerimaanRekM;
                                $det->attributes = $item;
                                $det->jenispenerimaan_id = $model->jenispenerimaan_id;
                                $det->debitkredit = $item['rekening5_nb'];
                                
                                if ($det->debitkredit == "D") $model->rekeningdebit_id = $det->rekening5_id;
                                else $model->rekeningkredit_id = $det->rekening5_id;
                                
                                
                                if ($det->validate()) $ok = $ok && $det->save();
                                else $ok = false;
                            }
                            $model->save();
                        }
                        
                        
                        
                        // var_dump($ok); die;
                        
			if ($ok) {
                                $trans->commit();
				Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
				$this->redirect(array('admin'));
			} else {
                                $trans->rollback();
                                Yii::app()->user->setFlash('error', '<strong>Gagal!</strong> Data gagal disimpan.');
                                $this->redirect(array('create'));
                        }
		}

		$this->render('create', array(
			'model' => $model,
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


		if (isset($_POST['AKJenispenerimaanM'])) {
                        //var_dump($_POST);
                        $trans = Yii::app()->db->beginTransaction();
			$ok = true;
			$model->attributes = $_POST['AKJenispenerimaanM'];
			
                        if ($model->validate()) $ok = $ok && $model->save();
                        else $ok = false;
                        
                        AKJnsPenerimaanRekM::model()->deleteAllByAttributes(array(
                            'jenispenerimaan_id'=>$model->jenispenerimaan_id,
                        ));
                        
                        if (isset($_POST['AKJnsPenerimaanRekM'])) {
                            foreach ($_POST['AKJnsPenerimaanRekM']['rekening'] as $item) {
                                $det = new AKJnsPenerimaanRekM;
                                $det->attributes = $item;
                                $det->jenispenerimaan_id = $model->jenispenerimaan_id;
                                $det->debitkredit = $item['rekening5_nb'];
                                
                                if ($det->debitkredit == "D") $model->rekeningdebit_id = $det->rekening5_id;
                                else $model->rekeningkredit_id = $det->rekening5_id;
                                
                                
                                if ($det->validate()) $ok = $ok && $det->save();
                                else $ok = false;
                            }
                            $model->save();
                        }
                        
                        //var_dump($ok); die;
                        
                        if ($ok) {
                                $trans->commit();
				Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
				$this->redirect(array('admin'));
			} else {
                                $trans->rollback();
                                Yii::app()->user->setFlash('error', '<strong>Gagal!</strong> Data gagal disimpan.');
                                $this->redirect(array('admin'));
                        }
                        
                        /*
                        if ($model->save()) {
				Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
				$this->redirect(array('admin', 'id' => 1));
			} */
		}

		$this->render('update', array(
			'model' => $model,
		));
	}

	public function actionUbahRekeningDebitKredit($view = null, $id = null) {
		//if(!Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
		$this->layout = '//layouts/iframe';

		$model = AKJenispenerimaanM::model()->findByPk($id);

		// Uncomment the following line if AJAX validation is needed


		if (isset($_POST['AKJenispenerimaanM'])) {
			$model->attributes = $_POST['AKJenispenerimaanM'];

			$view = 'UbahRekeningDebitKredit';
			$update = AKJenispenerimaanM::model()->updateByPk($id, array('rekeningdebit_id' => $_POST['AKJenispenerimaanM']['rekeningdebit_id'], 'rekeningkredit_id' => $_POST['AKJenispenerimaanM']['rekeningkredit_id']));
			if ($update) {
				Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
				if (isset($_GET['frame']) && !empty($_GET['idPenerimaan'])) {
					$this->redirect(array(((isset($view)) ? $view : 'UbahRekeningDebitKredit'), 'id' => $model->jenispenerimaan_id, 'frame' => $_GET['frame'], 'idPenerimaan' => $_GET['idPenerimaan']));
				} else {
					$this->redirect(array(((isset($view)) ? $view : 'admin'), 'id' => $model->jenispenerimaan_id));
				}
			}
		}

		$this->render(((isset($view)) ? $view : '_ubahRekeningDebitKredit'), array(
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
			$model = AKJnsPenerimaanRekM::model()->deleteAllByAttributes(array('jenispenerimaan_id' => $id));
                        AKJenispenerimaanM::model()->deleteByPk($id);

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
		$dataProvider = new CActiveDataProvider('AKJenispenerimaanM');
		$this->render('index', array(
			'dataProvider' => $dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin($id='') {
             if ($id == 1):
                    Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
                endif;
                
		$model = new AKJenispenerimaanM('searchJenisPenerimaan');
		$model->unsetAttributes();
		if (isset($_GET['AKJenispenerimaanM'])) {
			$model->attributes = $_GET['AKJenispenerimaanM'];
			$model->jenispenerimaan_nama = $_GET['AKJenispenerimaanM']['jenispenerimaan_nama'];
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
		$model = AKJenispenerimaanM::model()->findByPk($id);
		if ($model === null)
			throw new CHttpException(404, 'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model) {
		if (isset($_POST['ajax']) && $_POST['ajax'] === 'jenispenerimaan-m-form') {
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
		$model = new AKJnsPenerimaanRekM;
		if (isset($_REQUEST['AKJnsPenerimaanRekM'])) {
			$model->attributes = $_REQUEST['AKJnsPenerimaanRekM'];
		}
		$judulLaporan = 'Data Jurnal Rekening Penerimaan';
		$caraPrint = $_REQUEST['caraPrint'];
		if ($caraPrint == 'PRINT') {
			$this->layout = '//layouts/printWindows';
			$this->render('Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
		} else if ($caraPrint == 'EXCEL') {
			$this->layout = '//layouts/printExcel';
			$this->render('Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
		} else if ($_REQUEST['caraPrint'] == 'PDF') {
			$ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');	  //Ukuran Kertas Pdf
			$posisi = Yii::app()->user->getState('posisi_kertas');		 //Posisi L->Landscape,P->Portait
			$mpdf = new MyPDF('', $ukuranKertasPDF);
			$mpdf->useOddEven = 2;
			$stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
			$mpdf->WriteHTML($stylesheet, 1);
			$mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
			$mpdf->WriteHTML($this->renderPartial('Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
			$mpdf->Output($judulLaporan.'-'.date('Y/m/d').'.pdf','I');
		}
	}

}
