<?php
class KelasRuanganMController extends MyAuthController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column1';
	public $defaultAction = 'admin';
    public $path_view='sistemAdministrator.views.kelasRuanganM.';

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render($this->path_view.'view',array(
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
		$model=new SAKelasruanganM;
		$modPelayanan = KelaspelayananM::model()->findAll();
		$model->ruangan_id=Yii::app()->user->ruangan_id;
		// Uncomment the following line if AJAX validation is needed
		if(isset($_POST['SAKelasruanganM']))
		{
                   
                    $transaction = Yii::app()->db->beginTransaction();
					try {
							$jumlahRuangan=COUNT($_POST['kelaspelayanan_id']);
							$ruangan_id=$_POST['SAKelasruanganM']['ruangan_id'];
							$hapuskelasRuangan=KelasruanganM::model()->deleteAll('ruangan_id='.$ruangan_id.'');
							for($i=0; $i<$jumlahRuangan; $i++)
								{
									$modKasusRuangan = new KelasruanganM;
									$modKasusRuangan->ruangan_id=$ruangan_id;
									$modKasusRuangan->kelaspelayanan_id=$_POST['kelaspelayanan_id'][$i];
									$modKasusRuangan->save();

								}

								 Yii::app()->user->setFlash('success', "Data Kelas Ruangan Berhasil Disimpan");
								 $transaction->commit();
								 $this->redirect(array('admin'));
						}   
					catch (Exception $e)
						{
							$transaction->rollback();
							Yii::app()->user->setFlash('error', "Data Kelas Ruangan Gagal Disimpan");
						}   
		}

		$this->render($this->path_view.'create',array(
			'model'=>$model, 'modPelayanan'=>$modPelayanan,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete()
	{
		if(Yii::app()->request->isAjaxRequest)
		{
			$id = $_GET['id'];
			$transaction = Yii::app()->db->beginTransaction();
			try {
				// we only allow deletion via POST request
				$hapuskelasRuangan=KelasruanganM::model()->deleteAll('ruangan_id='.$id['ruangan_id'].' AND kelaspelayanan_id='.$id['kelaspelayanan_id'].''); 
				if($hapuskelasRuangan){
					$transaction->commit();
				}
				// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			}catch (Exception $exc){
				$transaction->rollback();
				echo "Data Kelas Ruangan Gagal Dihapus".$exc;
				exit;
			} 
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
		$dataProvider=new CActiveDataProvider('SARuanganM');
		$this->render($this->path_view.'index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
                
		$model=new SAKelasruanganM('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['SAKelasruanganM'])){
			$model->attributes=$_GET['SAKelasruanganM'];
			$model->ruangan_nama=isset($_GET['SAKelasruanganM']['ruangan_nama']) ? $_GET['SAKelasruanganM']['ruangan_nama'] : null;
			$model->instalasi_nama=isset($_GET['SAKelasruanganM']['instalasi_nama']) ? $_GET['SAKelasruanganM']['instalasi_nama'] : null;
		}

		$this->render($this->path_view.'admin',array(
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
		$model=SARuanganM::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='ppruangan-m-form')
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
            $model= new SAKelasruanganM();
            $model->attributes=$_REQUEST['SAKelasruanganM'];
            $judulLaporan='Data Ruangan';
            $caraPrint=$_REQUEST['caraPrint'];
            if($caraPrint=='PRINT') {
                $this->layout='//layouts/printWindows';
                $this->render($this->path_view.'Print',array('model'=>$model,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint));
            }
            else if($caraPrint=='EXCEL') {
                $this->layout='//layouts/printExcel';
                $this->render($this->path_view.'Print',array('model'=>$model,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint));
            }
            else if($_REQUEST['caraPrint']=='PDF') {
                $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
                $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
                $mpdf = new MyPDF('',$ukuranKertasPDF); 
                $mpdf->useOddEven = 2;  
                $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
                $mpdf->WriteHTML($stylesheet,1);  
                $mpdf->AddPage($posisi,'','','','',15,15,15,15,15,15);
                $mpdf->WriteHTML($this->renderPartial($this->path_view.'Print',array('model'=>$model,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint),true));
                $mpdf->Output();
            }                       
        }
}
