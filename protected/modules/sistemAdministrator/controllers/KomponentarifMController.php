
<?php

class KomponentarifMController extends MyAuthController {

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
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    public function actionCreateKomponenTarifInstalasi() {
        $model = new SAKomponentarifinstalasiM;
        if (isset($_POST['SAKomponentarifinstalasiM'])) {

            $transaction = Yii::app()->db->beginTransaction();
            try {
                $jumlahInstalasi = count($_POST['instalasi_id']);
                $komponentarif_id = $_POST['SAKomponentarifinstalasiM']['komponentarif_id'];
                $hapusKomponenTarif = SAKomponentarifinstalasiM::model()->deleteAll('komponentarif_id=' . $komponentarif_id . '');
                for ($i = 0; $i <= $jumlahInstalasi; $i++) {
                    $modKomponenTarifInstalasi = new SAKomponentarifinstalasiM;
                    $modKomponenTarifInstalasi->komponentarif_id = $komponentarif_id;
                    $modKomponenTarifInstalasi->instalasi_id = $_POST['instalasi_id'][$i];
                    $modKomponenTarifInstalasi->save();
                }

                Yii::app()->user->setFlash('success', "Data Komponen Tarif Dan Instalasi Berhasil Disimpan");
                $transaction->commit();
                $this->redirect(array('admin'));
            } catch (Exception $e) {
                $transaction->rollback();
                Yii::app()->user->setFlash('error', "Data Komponen Tarif Dan Instalasi Gagal Disimpan");
            }
        }

        $this->render('createKomponenTarifInstalasi', array('model' => $model
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $model = new SAKomponentarifM;

        // Uncomment the following line if AJAX validation is needed
        

        if (isset($_POST['SAKomponentarifM'])) {
           
            $transaction = Yii::app()->db->beginTransaction();
            try {
                $model->attributes = $_POST['SAKomponentarifM'];
                $model->save();
                $jumlahInstalasi = isset($_POST['instalasi_id'])?COUNT($_POST['instalasi_id']):0;
                $komponentarif_id = $model->komponentarif_id;
				
                if ($jumlahInstalasi > 0) {
                    for ($i = 0; $i <= $jumlahInstalasi-1; $i++) {
                        $modKomponenTarifInstalasi = new SAKomponentarifinstalasiM;
                        $modKomponenTarifInstalasi->komponentarif_id = $komponentarif_id;
                        $modKomponenTarifInstalasi->instalasi_id = $_POST['instalasi_id'][$i];
                        $modKomponenTarifInstalasi->save();
                    }
                }


                Yii::app()->user->setFlash('success', "Data Komponen Tarif dan Instalasi Berhasil Disimpan");
                $transaction->commit();
                $this->redirect(array('admin', 'id' => $model->komponentarif_id));
            } catch (Exception $e) {
                $transaction->rollback();
                Yii::app()->user->setFlash('error', "Data Komponen Tarif dan Instalasi Gagal Disimpan");
            }
        }

        $this->render('create', array(
            'model' => $model, //'modKomponenTarifInstalasi' => $modKomponenTarifInstalasi,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);
        $modKomponenTarifInstalasi = SAKomponentarifinstalasiM::model()->findAll('komponentarif_id=' . $id . '');
        // Uncomment the following line if AJAX validation is needed
        

        if (isset($_POST['SAKomponentarifM'])) {
            $transaction = Yii::app()->db->beginTransaction();
            try {
                $model->attributes = $_POST['SAKomponentarifM'];
                $model->save();
                $jumlahInstalasi = COUNT($_POST['instalasi_id']);
                $komponentarif_id = $model->komponentarif_id;

                $hapusKomponenTarifInstalasi = SAKomponentarifinstalasiM::model()->deleteAll('komponentarif_id=' . $komponentarif_id . '');

                if ($jumlahInstalasi > 0) {
                    for ($i = 0; $i <= $jumlahInstalasi; $i++) {
                        $modKomponenTarifInstalasi = new SAKomponentarifinstalasiM;
                        $modKomponenTarifInstalasi->komponentarif_id = $komponentarif_id;
                        $modKomponenTarifInstalasi->instalasi_id = $_POST['instalasi_id'][$i];
                        $modKomponenTarifInstalasi->save();
                    }
                }


                Yii::app()->user->setFlash('success', "Data Komponen Tarif dan Instalasi Berhasil Disimpan");
                $transaction->commit();
                $this->redirect(array('admin', 'id' => $model->komponentarif_id));
            } catch (Exception $e) {
                $transaction->rollback();
                Yii::app()->user->setFlash('error', "Data Komponen Tarif dan Instalasi Gagal Disimpan");
            }
        }

        $this->render('update', array(
            'model' => $model, 'modKomponenTarifInstalasi' => $modKomponenTarifInstalasi,
        ));
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $dataProvider = new CActiveDataProvider('SAKomponentarifM');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new SAKomponentarifM('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['SAKomponentarifM']))
            $model->attributes = $_GET['SAKomponentarifM'];

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
        $model = SAKomponentarifM::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'sakomponentarif-m-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

   public function actionDelete()
				{              
					//if(!Yii::app()->user->checkAccess(Params::DEFAULT_DELETE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
					if(Yii::app()->request->isPostRequest)
					{
						$id = $_POST['id'];
						$jmlTarifInst = KomponentarifinstalasiM::model()->findAllByAttributes(array('komponentarif_id'=>$id));
						if(count($jmlTarifInst)>0){
							$modKompTarifInst = new KomponentarifinstalasiM();
							if($modKompTarifInst->deleteAllByAttributes(array('komponentarif_id'=>$id))){
								$this->loadModel($id)->delete();
								if (Yii::app()->request->isAjaxRequest)
									{
										echo CJSON::encode(array(
											'status'=>'proses_form', 
											'div'=>"<div class='flash-success'>Data berhasil dihapus.</div>",
											));
										exit;               
									}
							}
						}else{
							$this->loadModel($id)->delete();
							if (Yii::app()->request->isAjaxRequest)
								{
									echo CJSON::encode(array(
										'status'=>'proses_form', 
										'div'=>"<div class='flash-success'>Data berhasil dihapus.</div>",
										));
									exit;               
								}
						}
						
						// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
						if(!isset($_GET['ajax']))
							$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
					}
					else
						throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
				}
        
                 /**
                 *Mengubah status aktif
                 * @param type $id 
                 */
                public function actionRemoveTemporary()
                {
                            //if(!Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
        //                    SAPropinsiM::model()->updateByPk($id, array('propinsi_aktif'=>false));
        //                    $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
                          
                    
                    $id = $_POST['id'];   
                    if(isset($_POST['id']))
                    {
                       $update = SAKomponentarifM::model()->updateByPk($id,array('komponentarif_aktif'=>false));
                       if($update)
                        {
                            if (Yii::app()->request->isAjaxRequest)
                            {
                                echo CJSON::encode(array(
                                    'status'=>'proses_form', 
                                    ));
                                exit;               
                            }
                         }
                    } else {
                            if (Yii::app()->request->isAjaxRequest)
                            {
                                echo CJSON::encode(array(
                                    'status'=>'proses_form', 
                                    ));
                                exit;               
                            }
                    }

               }

    public function actionPrint() {
        $model = new SAKomponentarifM;
        $model->attributes = $_REQUEST['SAKomponentarifM'];
        $judulLaporan = 'Data SAKomponentarifM';
        $caraPrint = $_REQUEST['caraPrint'];
        if ($caraPrint == 'PRINT') {
            $this->layout = '//layouts/printWindows';
            $this->render('Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
        } else if ($caraPrint == 'EXCEL') {
            $this->layout = '//layouts/printExcel';
            $this->render('Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
        } else if ($_REQUEST['caraPrint'] == 'PDF') {
            $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
            $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
            $mpdf = new MyPDF('', $ukuranKertasPDF);
            $mpdf->useOddEven = 2;
            $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
            $mpdf->WriteHTML($stylesheet, 1);
            $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
            $mpdf->WriteHTML($this->renderPartial('Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
            $mpdf->Output();
        }
    }


}
