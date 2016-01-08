<?php

class PengangkatanpnsTController extends MyAuthController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column1';
	public $defaultAction = 'index';

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionIndex()
	{
		$model=new KPPengangkatanpnsT;
                $modPegawai = new KPPegawaiM;
                $modUsulan = new UsulanpnsR();
                $modPers = new PerspengpnsR();
                $modRealisasi = new RealisasipnsR();
                if (isset($_GET['id'])){
                    $id = $_GET['id'];
                    $model = KPPengangkatanpnsT::model()->findByPk($id);
                    if (count($model) == 1){
                        $crit = new CDbCriteria();
                        $crit->compare('pengangkatanpns_id', $model->pengangkatanpns_id);
                        $modPegawai = KPPegawaiM::model()->findByPk($model->pegawai_id);
                        $modPegawai->jabatan_id = $modPegawai->jabatan->jabatan_nama;
                        $modPegawai->pangkat_id = $modPegawai->pangkat->pangkat_nama;
                        $modPegawai->pendidikan_id = $modPegawai->pendidikan->pendidikan_nama;
                        $modUsulan = UsulanpnsR::model()->find($crit);
                        $modPers = PerspengpnsR::model()->find($crit);
                        if (count($modPers) == 1){
                            $model->cekPersetujuan = 1;
                        }
                        $modRealisasi = RealisasipnsR::model()->find($crit);
                        if (count($modRealisasi) == 1){
                            $model->cekRealisasi = 1;
                        }
                    }
                }
		// Uncomment the following line if AJAX validation is needed
		

		if((isset($_POST['KPPengangkatanpnsT'])) && (!isset($_GET['id'])))
		{
//                    $modPegawai->attributes = $_POST['KPPegawaiM'];
                        if (isset($_POST['KPPengangkatanpnsT']['cekPersetujuan'])){
                            $modPers->attributes = $_POST['PerspengpnsR'];
                        }
                        if (isset($_POST['KPPengangkatanpnsT']['cekRealisasi'])){
                            $modRealisasi->attributes = $_POST['RealisasipnsR'];
                        }
			$model->attributes = $_POST['KPPengangkatanpnsT'];
                        $modUsulan->attributes = $_POST['UsulanpnsR'];
                        $model->pegawai_id = $_POST['KPPegawaiM']['pegawai_id'];
                        $model->pimpinannama = $modUsulan->usulanpns_pejabatygberwenang;
                        if (!empty($model->pegawai_id)){
                            $modPegawai = KPPegawaiM::model()->findByPk($model->pegawai_id);
                            $modPegawai->jabatan_id = $modPegawai->jabatan->jabatan_nama;
                        }

                        $transaction = Yii::app()->db->beginTransaction();
                        try{
                            if($model->save()){
                                $modUsulan->pengangkatanpns_id = $model->pengangkatanpns_id;
                                if ($modUsulan->save()){
                                    $model->usulanpns_id = $modUsulan->usulanpns_id;
                                    $model->save();
                                    if (isset($_POST['KPPengangkatanpnsT']['cekPersetujuan'])){
                                        $modPers->pengangkatanpns_id = $model->pengangkatanpns_id;
                                        if ($modPers->save()){
                                            $model->perspeng_id = $modPers->perspeng_id;
                                            $model->save();
                                            if (isset($_POST['KPPengangkatanpnsT']['cekRealisasi'])){
                                                $modRealisasi->pengangkatanpns_id = $model->pengangkatanpns_id;
                                                if ($modRealisasi->save()){
                                                    $model->realisasipns_id = $modRealisasi->realisasipns_id;
                                                    $model->save();
                                                    $transaction->commit();
                                                    Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
                                                    $this->redirect(array('create','id'=>$model->pengangkatanpns_id));
                                                }
                                            }
                                            else{
                                                $transaction->commit();
                                                Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
                                                $this->redirect(array('create','id'=>$model->pengangkatanpns_id));
                                            }
                                        }
                                    }
                                    else{
                                        $transaction->commit();
                                        Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
                                        $this->redirect(array('create','id'=>$model->pengangkatanpns_id));
                                    }
                                    
                                    
                                }
                            }
                        }
                        catch(Exception $ex){
                            $transaction->rollback();
                            Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($ex, true));
                        }
		}
		$this->render('index',array(
			'model'=>$model, 'modPegawai'=>$modPegawai, 'modUsulan'=>$modUsulan,
			'modPers'=>$modPers, 'modRealisasi'=>$modRealisasi
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
                //if(!Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		

		if(isset($_POST['KPPengangkatanpnsT']))
		{
			$model->attributes=$_POST['KPPengangkatanpnsT'];
			if($model->save()){
                                Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
				$this->redirect(array('view','id'=>$model->pengangkatanpns_id));
                        }
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	public function actionInformasi()
	{
                
		$model=new KPPengangkatanpnsT('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['KPPengangkatanpnsT']))
			$model->attributes=$_GET['KPPengangkatanpnsT'];

		$this->render('informasi',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=KPPengangkatanpnsT::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='kppengangkatanpns-t-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
        
        /**
         *Mengubah status aktif
         * @param type $id 
         */
        public function actionRemoveTemporary($id)
	{
                //if(!Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
                //SAKabupatenM::model()->updateByPk($id, array('kabupaten_aktif'=>false));
                //$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}
        
        public function actionPrint()
        {
            $model= KPPengangkatanpnsT::model()->findByPk($_GET['id']);
//            $model->attributes=$_REQUEST['KPPengangkatanpnsT'];
            $judulLaporan='Data Pengangkatan Pegawai Negeri Sipil';
            $modPegawai = PegawaiM::model()->findByPk($model->pegawai_id);
            $modUsulan = UsulanpnsR::model()->findByPk($model->usulanpns_id);
            if (!empty($model->perspeng_id)){
                $modPersetujuan = PerspengpnsR::model()->findByPk($model->perspeng_id);
            }
            if (!empty($model->realisasipns_id)){
                $modRealisasi = RealisasipnsR::model()->findByPk($model->realisasipns_id);
            }
            $caraPrint=$_REQUEST['caraPrint'];
            if($caraPrint=='PRINT') {
                $this->layout='//layouts/printWindows';
                $this->render('_print',array('model'=>$model, 'modPegawai'=>$modPegawai,'modUsulan'=>$modUsulan, 'modPersetujuan'=>$modPersetujuan, 'modRealisasi'=>$modRealisasi,  'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint));
            }
            else if($caraPrint=='EXCEL') {
                $this->layout='//layouts/printExcel';
                $this->render('Print',array('model'=>$model,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint));
            }
            else if($_REQUEST['caraPrint']=='PDF') {
                $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
                $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
                $mpdf = new MyPDF('',$ukuranKertasPDF); 
                $mpdf->useOddEven = 2;  
                $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
                $mpdf->WriteHTML($stylesheet,1);  
                $mpdf->AddPage($posisi,'','','','',15,15,15,15,15,15);
                $mpdf->WriteHTML($this->renderPartial('Print',array('model'=>$model,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint),true));
                $mpdf->Output();
            }                       
        }
}
