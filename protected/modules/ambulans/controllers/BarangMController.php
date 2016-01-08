
<?php

class BarangMController extends MyAuthController
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
		$model=new SABarangM;
                 $model->barang_aktif = true;
                 $model->barang_kode = MyGenerator::kodeBarang();


		// Uncomment the following line if AJAX validation is needed
		

		if(isset($_POST['SABarangM']))
		{
                      $transaction = Yii::app()->db->beginTransaction();
                      $model=new SABarangM;
                      $model->attributes=$_POST['SABarangM'];
                      if ($model->validate()) {
                        try {
                            $random = rand(0000000, 9999999);
                            $model->barang_image = CUploadedFile::getInstance($model, 'barang_image');
                            $gambar = $model->barang_image;
                            if (!empty($model->barang_image)) {//Klo User Memasukan Logo
//                                $model->path_logorumahsakit = $random . $model->barang_image;
                                //                   $model->path_logorumahsakit =Params::pathProfilRSDirectory().$random.$model->barang_image;
                                $model->barang_image = $random . $model->barang_image;

                                Yii::import("ext.EPhpThumb.EPhpThumb");

                                $thumb = new EPhpThumb();
                                $thumb->init(); //this is needed

                                $fullImgName = $model->barang_image;
                                $fullImgSource = Params::pathBarangDirectory() . $fullImgName;
                                $fullThumbSource = Params::pathBarangTumbsDirectory() . 'kecil_' . $fullImgName;

                                $model->barang_image = $fullImgName;

                                if ($model->save()) {
//                                    Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
                                    $gambar->saveAs($fullImgSource);
                                    $thumb->create($fullImgSource)
                                            ->resize(200, 200)
                                            ->save($fullThumbSource);
                                } else {
//                                    Yii::app()->user->setFlash('error', 'Logo <strong>Gagal!</strong>  disimpan.');
                                }
                            }
                            else{
                                $model->save();
                            }
                            $transaction->commit();
                            Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
                            $this->redirect(array('admin'));
                        } catch (Exception $e) {
                            $transaction->rollback();
                            Yii::app()->user->setFlash('error', '<strong>Gagal!</strong> Data gagal disimpan.');
                        }
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
                //if(!Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}                                                        
		$model=$this->loadModel($id);
                $temLogo = $model->barang_image;
                $model->bidang_nama = BidangM::model()->findByPk($model->bidang_id)->bidang_nama;
		// Uncomment the following line if AJAX validation is needed
		

		if(isset($_POST['SABarangM']))
		{
                    $transaction = Yii::app()->db->beginTransaction();
                      $model=$this->loadModel($id);
                      $model->attributes=$_POST['SABarangM'];
                      if ($model->validate()) {
                        try {
                            $random = rand(0000000, 9999999);
                            $model->barang_image = CUploadedFile::getInstance($model, 'barang_image');
                            $gambar = $model->barang_image;
                            if (!empty($model->barang_image)) {
                                $model->barang_image = $random . $model->barang_image;
                                $model->barang_image = $random . $model->barang_image;

                                Yii::import("ext.EPhpThumb.EPhpThumb");

                                $thumb = new EPhpThumb();
                                $thumb->init(); //this is needed

                                $fullImgName = $model->barang_image;
                                $fullImgSource = Params::pathBarangDirectory() . $fullImgName;
                                $fullThumbSource = Params::pathBarangTumbsDirectory() . 'kecil_' . $fullImgName;

                                $model->barang_image = $fullImgName;

                                if ($model->save()) {
                                    if (!empty($temLogo)) {
                                        unlink(Params::pathBarangDirectory() . $temLogo);
                                        unlink(Params::pathBarangTumbsDirectory() . 'kecil_' . $temLogo);
                                    }
                                    $gambar->saveAs($fullImgSource);
                                    $thumb->create($fullImgSource)
                                            ->resize(200, 200)
                                            ->save($fullThumbSource);
                                }    
                            } 
                            
                            $transaction->commit();
                            Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
                            $this->redirect(array('admin'));
                        } catch (Exception $e) {
                            $transaction->rollback();
                            Yii::app()->user->setFlash('error', '<strong>Gagal!</strong> Data gagal disimpan.');
                        }
                    }
		}

		$this->render('update',array(
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
                         //if(!Yii::app()->user->checkAccess(Params::DEFAULT_DELETE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}                                         
			 $transaction = Yii::app()->db->beginTransaction();
                         try {
                                
                                $model=$this->loadModel($id)->delete();
                                $temLogo=$model->barang_image;
                                 if(!empty($temLogo))
                                        { 
                                           unlink(Params::urlPhotoBarangDirectory().$temLogo);
                                           unlink(Params::urlPhotoBarangDirectory().$temLogo);
                                        }
                                $transaction->commit();
                                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
                                
                                       
                            } 
                        catch (Exception $e)
                            {
                                $transaction->rollback();
                                Yii::app()->user->setFlash('error', '<strong>Gagal!</strong> Data gagal dihapus.');
                            }   

		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('SABarangM');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
                
		$model=new SABarangM('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['SABarangM']))
			$model->attributes=$_GET['SABarangM'];

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
		$model=SABarangM::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='sabarang-m-form')
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
                SABarangM::model()->updateByPk($id, array('barang_aktif'=>false));
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}
        
        public function actionPrint()
        {
            $model= new BarangM;
            $model->attributes=$_REQUEST['BarangM'];
            $judulLaporan='Data BarangM';
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
