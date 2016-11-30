
<?php

class JurnalRekPengeluaranController extends MyAuthController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column1';
	public $defaultAction = 'admin';

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
            $this->layout='//layouts/iframe';
        $model= AKJenispengeluaranM::model()->findByAttributes(array('jenispengeluaran_id'=>$id));
                
		$this->render('view',array(
			'model'=>$model,
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
            $this->layout='//layouts/iframe';
                //if(!Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
		$model=new AKJenispengeluaranM;

		// Uncomment the following line if AJAX validation is needed
		

		if(isset($_POST['AKJenispengeluaranM']))
		{
                        $trans = Yii::app()->db->beginTransaction();
			$ok = true;
			$model->attributes=$_POST['AKJenispengeluaranM'];
                        
                        if ($model->validate()) $ok = $ok && $model->save();
                        else $ok = false;
                        
                        if (isset($_POST['AKJnsPengeluaranRekM'])) {
                            foreach ($_POST['AKJnsPengeluaranRekM']['rekening'] as $item) {
                                $det = new AKJnsPengeluaranRekM;
                                $det->attributes = $item;
                                $det->jenispengeluaran_id = $model->jenispengeluaran_id;
                                $det->debitkredit = $item['rekening5_nb'];
                                
                                if ($det->debitkredit == "D") $model->rekeningdebit_id = $det->rekening5_id;
                                else $model->rekeningkredit_id = $det->rekening5_id;
                                
                                
                                if ($det->validate()) $ok = $ok && $det->save();
                                else $ok = false;
                            }
                            $model->save();
                        }
                        
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

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
            $this->layout='//layouts/iframe';
                //if(!Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		

		if(isset($_POST['AKJenispengeluaranM']))
		{
                        $trans = Yii::app()->db->beginTransaction();
			$ok = true;
			$model->attributes=$_POST['AKJenispengeluaranM'];
                        
                        if ($model->validate()) $ok = $ok && $model->save();
                        else $ok = false;
                        
                        AKJnsPengeluaranRekM::model()->deleteAllByAttributes(array(
                            'jenispengeluaran_id'=>$model->jenispengeluaran_id,
                        ));
                        
                        if (isset($_POST['AKJnsPengeluaranRekM'])) {
                            foreach ($_POST['AKJnsPengeluaranRekM']['rekening'] as $item) {
                                $det = new AKJnsPengeluaranRekM;
                                $det->attributes = $item;
                                $det->jenispengeluaran_id = $model->jenispengeluaran_id;
                                $det->debitkredit = $item['rekening5_nb'];
                                
                                if ($det->debitkredit == "D") $model->rekeningdebit_id = $det->rekening5_id;
                                else $model->rekeningkredit_id = $det->rekening5_id;
                                
                                
                                if ($det->validate()) $ok = $ok && $det->save();
                                else $ok = false;
                            }
                            $model->save();
                        }
                        
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
			if($model->save()){
                                Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
				$this->redirect(array('admin','id'=>1));
                        }
                         * 
                         */
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}
        
        public function actionUbahRekeningDebitKredit($id)
	{
                //if(!Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
				$this->layout = '//layouts/iframe';
                $model= AKJenispengeluaranM::model()->findByPk($id);

		// Uncomment the following line if AJAX validation is needed
		

		if(isset($_POST['AKJenispengeluaranM']))
		{
                        $model->attributes=$_POST['AKJenispengeluaranM'];
                        $view = 'UbahRekeningDebitKredit';
                           
                        $update = AKJenispengeluaranM::model()->updateByPk($id,array('rekeningdebit_id'=>$_POST['AKJenispengeluaranM']['rekeningdebit_id'],'rekeningkredit_id'=>$_POST['AKJenispengeluaranM']['rekeningkredit_id']));
			if($update){
                                Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
				if (isset($_GET['frame']) && !empty($_GET['idPengeluaran'])){
                                    $this->redirect(array(((isset($view)) ? $view : 'UbahRekeningDebitKredit'),'id'=>$model->jenispengeluaran_id, 'frame'=>$_GET['frame'], 'idPengeluaran'=>$_GET['idPengeluaran']));
                                }else{
                                    $this->redirect(array(((isset($view)) ? $view : 'admin'),'id'=>$model->jenispengeluaran_id));
                                }
                        }
                }

		$this->render(((isset($view)) ? $view : '_ubahRekeningDebitKredit'),array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
                        //if(!Yii::app()->user->checkAccess(Params::DEFAULT_DELETE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
			
                        $model = AKJnsPengeluaranRekM::model()->deleteAllByAttributes(array('jenispengeluaran_id'=>$id));
                        AKJenispengeluaranM::model()->deleteByPk($id);
                        
			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('AKJenispengeluaranM');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin($id = '')
	{
            $this->layout='//layouts/iframe';
                if ($id == 1):
                   Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.'); 
                endif;
                
		$model=new JenispengeluaranM('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['JenispengeluaranM'])){
			$model->attributes=$_GET['JenispengeluaranM'];
		}

		$this->render('admin',array(
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
		$model=AKJenispengeluaranM::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='jenispengeluaran-m-form')
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
		$model= new JenispengeluaranM;//AKJnsPengeluaranRekM
		if(isset($_REQUEST['JenispengeluaranM'])){
			$model->attributes=$_REQUEST['JenispengeluaranM'];
		}
		$judulLaporan='Data Jurnal Rekening Pengeluaran';
		$caraPrint=$_REQUEST['caraPrint'];
		if($caraPrint=='PRINT') {
			$this->layout='//layouts/printWindows';
			$this->render('Print',array('model'=>$model,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint));
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
			$mpdf->Output($judulLaporan.'-'.date('Y/m/d').'.pdf','I');
		}                       
	}
}
