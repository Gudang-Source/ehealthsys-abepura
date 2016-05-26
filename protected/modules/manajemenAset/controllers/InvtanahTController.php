
<?php

class InvtanahTController extends MyAuthController
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
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
                //if(!Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
		$model=new MAInvtanahT;
        $modBarang = new MABarangM;
		$format = new MyFormatter();

		// Uncomment the following line if AJAX validation is needed
		

		if(isset($_POST['MAInvtanahT'])){
			$transaction = Yii::app()->db->beginTransaction();
			try{
				$model->attributes=$_POST['MAInvtanahT'];
				$model->create_time = date('Y-m-d H:i:s');
				$model->update_time = null;
				$model->create_loginpemakai_id = Yii::app()->user->id;
				$model->create_ruangan = Yii::app()->user->getState('ruangan_id');
				$model->invtanah_tglguna = !empty($_POST['MAInvtanahT']['invtanah_tglguna'])?$format->formatDateTimeForDb($_POST['MAInvtanahT']['invtanah_tglguna']):null;
				$model->invtanah_tglsertifikat = !empty($_POST['MAInvtanahT']['invtanah_tglsertifikat'])?$format->formatDateTimeForDb($_POST['MAInvtanahT']['invtanah_tglsertifikat']):null;
				
                                if (!empty($model->invtanah_harga) && !empty($model->invtanah_luas)) $model->invtanah_harga *= $model->invtanah_luas;
                                
                                // var_dump($model->attributes); die;
                                
				if($model->validate()){
					$model->save();
					$transaction->commit();
					BarangM::model()->updateByPk($model->barang_id, array('barang_statusregister'=>true));
					Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
				
                                        if (!empty($model->invtanah_harga) && !empty($model->invtanah_luas)) $model->invtanah_harga /= $model->invtanah_luas;
                                }else{
					$transaction->rollback();
					Yii::app()->user->setFlash('error',"Data gagal disimpan !");
				}
			}catch(Exception $exc){
				$transaction->rollback();
				Yii::app()->user->setFlash('error',"Data gagal disimpan ".MyExceptionMessage::getMessage($exc,true));
			}
		}

		$this->render('create',array(
			'model'=>$model,'modBarang'=>$modBarang,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$format = new MyFormatter();
                //if(!Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
		$model=$this->loadModel($id);
                $modBarang = $this->loadModelBarang($model->barang_id);
                if (!empty($model->invtanah_harga) && !empty($model->invtanah_luas)) $model->invtanah_harga /= $model->invtanah_luas;
                
                $data['pemilikbarang_nama'] = $model->pemilik->pemilikbarang_nama;
                $dataAsalAset['asalaset_nama'] = $model->asal->asalaset_nama;
                $dataLokasi['lokasiaset_namalokasi'] = $model->lokasi->lokasiaset_namalokasi;
//                $modBarang->pemilikbarang_nama = $model->pemilik->pemilikbarang_nama;

		// Uncomment the following line if AJAX validation is needed
		

		if(isset($_POST['MAInvtanahT']))
		{
			$model->attributes=$_POST['MAInvtanahT'];
                        $model->invtanah_tglguna = !empty($_POST['MAInvtanahT']['invtanah_tglguna'])?$format->formatDateTimeForDb($_POST['MAInvtanahT']['invtanah_tglguna']):null;
                        $model->invtanah_tglsertifikat = !empty($_POST['MAInvtanahT']['invtanah_tglsertifikat'])?$format->formatDateTimeForDb($_POST['MAInvtanahT']['invtanah_tglsertifikat']):null;
			
                        if (!empty($model->invtanah_harga) && !empty($model->invtanah_luas)) $model->invtanah_harga *= $model->invtanah_luas;
                        
                        if($model->save()){
                                 BarangM::model()->updateByPk($model->barang_id, array('barang_statusregister'=>true));
                                Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
				//$this->redirect(array('admin','id'=>$model->invtanah_id));
                                if (!empty($model->invtanah_harga) && !empty($model->invtanah_luas)) $model->invtanah_harga /= $model->invtanah_luas;
                        }
		}
                
                $model->invtanah_harga = MyFormatter::formatNumberForPrint($model->invtanah_harga);

		$this->render('update',array(
			'model'=>$model,'modBarang'=>$modBarang, 'data'=>$data ,'dataAsalAset'=>$dataAsalAset ,'dataLokasi'=>$dataLokasi
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
                        $model = $this->loadModel($id);
                        BarangM::model()->updateByPk($model->barang_id, array('barang_statusregister'=>false));
                        $this->loadModel($id)->delete();
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
		$dataProvider=new CActiveDataProvider('MAInvtanahT');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
                
		$model=new MAInvtanahT('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['MAInvtanahT']))
			$model->attributes=$_GET['MAInvtanahT'];

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
		$model=MAInvtanahT::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
        
        public function loadModelBarang($id){
            $model=BarangM::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='guinvtanah-t-form')
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
                //$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}
        
        public function actionPrint()
        {
            $model= new MAInvtanahT;
            $model->attributes=$_REQUEST['MAInvtanahT'];
            $judulLaporan='Data Inventarisasi Tanah';
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
                $mpdf->Output();
            }                       
        }
}
