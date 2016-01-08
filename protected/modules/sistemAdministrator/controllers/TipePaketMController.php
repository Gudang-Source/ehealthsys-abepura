
<?php

class TipePaketMController extends MyAuthController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column1';
	public $defaultAction = 'admin';
	public $path_view = 'sistemAdministrator.views.tipePaketM.';

	
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
//                if(!Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
		$model=new SATipePaketM;
                $model->tglkesepakatantarif = date('d M Y');
                $model->tarifpaket = 0;
                $model->paketiurbiaya=0;
                $model->paketsubsidiasuransi=0;
                $model->paketsubsidipemerintah= 0;
                $model->paketsubsidirs =0;
                        
		// Uncomment the following line if AJAX validation is needed
		

		if(isset($_POST['SATipePaketM']))
		{
			$format = new MyFormatter();
			$model->attributes=$_POST['SATipePaketM'];
			$model->tglkesepakatantarif = $format->formatDateTimeForDb($_POST['SATipePaketM']['tglkesepakatantarif']);
                        if($model->validate()) {
                            if($model->save()){
                                    Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
                                    $this->redirect(array('admin','id'=>$model->tipepaket_id));
                            }

                        }
            $model->tglkesepakatantarif = $_POST['SATipePaketM']['tglkesepakatantarif'];
		}

		$this->render($this->path_view.'create',array(
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
//                if(!Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		

		if(isset($_POST['SATipePaketM']))
		{
			$model->attributes=$_POST['SATipePaketM'];
                        $format = new MyFormatter();
                        $model->tglkesepakatantarif = $format->formatDateTimeForDb($model->tglkesepakatantarif);
                        if($model->save()){
                                Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');

                                
				$this->redirect(array('admin','id'=>$model->tipepaket_id));

                        }
            $model->tglkesepakatantarif = $_POST['SATipePaketM']['tglkesepakatantarif'];
		}

		$this->render($this->path_view.'update',array(
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
//                        if(!Yii::app()->user->checkAccess(Params::DEFAULT_DELETE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
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
		$dataProvider=new CActiveDataProvider('SATipePaketM');
		$this->render($this->path_view.'index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
//                if(!Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
		$model=new SATipePaketM('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['SATipePaketM']))
			$model->attributes=$_GET['SATipePaketM'];

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
		$model=SATipePaketM::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='satipe-paket-m-form')
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
		if(Yii::app()->request->isAjaxRequest)
		{
			$data['sukses']=0;
			$model = $this->loadModel($id);
			$model->tipepaket_aktif = false;
			if($model->save()){
			   $data['sukses'] = 1;
			}
			echo CJSON::encode($data); 
		}
//		if(!Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
//		SATipePaketM::model()->updateByPk($id, array('tipepaket_aktif'=>false));
//		$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}
        
	public function actionPrint()
	{
//             if(!Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}                         
		$model= new SATipePaketM();
		$model->attributes=$_REQUEST['SATipePaketM'];
		$judulLaporan='Data Paket';
		$caraPrint=$_REQUEST['caraPrint'];
		if($caraPrint=='PRINT')
		{
			$this->layout='//layouts/printWindows';
			$this->render($this->path_view.'Print',array('model'=>$model,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint));
		}
		else if($caraPrint=='EXCEL')    
		{
			$this->layout='//layouts/printExcel';
			$this->render($this->path_view.'Print',array('model'=>$model,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint));
		}
		else if($_REQUEST['caraPrint']=='PDF')
		{

			$ukuranKertasPDF=Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
			$posisi=Yii::app()->user->getState('posisi_kertas');                            //Posisi L->Landscape,P->Portait
			$mpdf=new MyPDF('',$ukuranKertasPDF); 
			$mpdf->useOddEven = 2;  
			$stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
			$mpdf->WriteHTML($stylesheet,1);  
			$mpdf->AddPage($posisi,'','','','',15,15,15,15,15,15);
			$mpdf->WriteHTML($this->renderPartial($this->path_view.'Print',array('model'=>$model,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint),true));
			$mpdf->Output();
		}                       
	}
}
