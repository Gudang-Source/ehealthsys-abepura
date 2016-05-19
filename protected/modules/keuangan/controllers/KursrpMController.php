
<?php

class KursrpMController extends MyAuthController
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
		$model=new KUKursrpM;
                $format = new MyFormatter();

		// Uncomment the following line if AJAX validation is needed
		

		if(isset($_POST['KUKursrpM']))
		{
			$model->attributes=$_POST['KUKursrpM'];
                        $model->tglkursrp = $format->formatDateTimeForDb($_POST['KUKursrpM']['tglkursrp']);                        
                        $model->kursrp_aktif = TRUE;
			if($model->save()){
                                Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
				$this->redirect(array('admin','sukses'=>1));
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
                $format = new MyFormatter();
                $model->nilai = number_format($model->nilai,0,'','.');
                $model->rupiah = number_format($model->rupiah,0,'','.');
		// Uncomment the following line if AJAX validation is needed
		

		if(isset($_POST['KUKursrpM']))
		{
			$model->attributes=$_POST['KUKursrpM'];
                        $model->tglkursrp = $format->formatDateTimeForDb($_POST['KUKursrpM']['tglkursrp']);
                        $model->nilai = str_replace('.', '', $model->nilai);
                        $model->rupiah = str_replace('.', '', $model->rupiah);
                        
			if($model->save()){
                                Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
				$this->redirect(array('admin','sukses'=>1));
                        }
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('KUKursrpM');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin($sukses = '')
	{
            if ($sukses == 1):
                Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
            endif;
                
		$model=new KUKursrpM('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['KUKursrpM'])){
			$model->attributes=$_GET['KUKursrpM'];
			$model->tglkursrp=isset($_GET['KUKursrpM']['tglkursrp'])?MyFormatter::formatDateTimeForDb($_GET['KUKursrpM']['tglkursrp']):null;
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
		$model=KUKursrpM::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='kursrp-m-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete()
	{
		$id = $_POST['id'];
		if(Yii::app()->request->isPostRequest)
		{
			$modSaldoAwal = SaldoawalT::model()->findAllByAttributes(array('kursrp_id'=>$id));
			if(count($modSaldoAwal)>0){
				if (Yii::app()->request->isAjaxRequest){
					echo CJSON::encode(array(
						'warning'=>true, 
						'pesan'=>"Data ini sedang digunakan di table : saldoawal_t",
						));
					exit;
				}
			}else{
				$this->loadModel($id)->delete();
				if (Yii::app()->request->isAjaxRequest){
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
           $update = KUKursrpM::model()->updateByPk($id,array('kursrp_aktif'=>false));
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
        
        public function actionPrint()
        {
            $model= new KUKursrpM;
			if(isset($_REQUEST['KUKursrpM'])){
				$model->attributes=$_REQUEST['KUKursrpM'];
			}			
            $judulLaporan='Data Master Kurs Rp.';
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
                $mpdf->Output($judulLaporan.'-'.date('Y-m-d').'.pdf','I');
            }                       
        }
}
