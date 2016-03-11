
<?php

class DiagnosaMController extends MyAuthController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/iframe';
	public $defaultAction = 'admin';
	public $path_view = 'sistemAdministrator.views.diagnosaM.';

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
		$model=new SADiagnosaM;
//                $modDTDDiagnosaM=new SADTDDiagnosaM; 

		// Uncomment the following line if AJAX validation is needed
		

		if(isset($_POST['SADiagnosaM']))
		{
                    $transaction = Yii::app()->db->beginTransaction();
                    try 
                    {
                        $model->attributes=$_POST['SADiagnosaM'];
                        $model->diagnosa_aktif=TRUE;
                        $model->save();
                        if(isset($_POST['dtd_id'])){
                            $jumlahDTD=COUNT($_POST['dtd_id']);
                            $diagnosa_id=$model->diagnosa_id;
                            $hapusDTDDiagnosaM=SADTDDiagnosaM::model()->deleteAll('diagnosa_id='.$diagnosa_id.''); 
                                for($i=0; $i<=$jumlahDTD; $i++)
                                    {
                                        $modDTDDiagnosaM=new SADTDDiagnosaM; 
                                        $modDTDDiagnosaM->diagnosa_id=$diagnosa_id;
					$modDTDDiagnosaM->dtd_id=$_POST['dtd_id'];
                                        $modDTDDiagnosaM->save();
                                    }
                        }
                        $transaction->commit();
                        Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');    
                        $this->redirect(array('admin'));  
                    }
                    catch (Exception $e)
                     {
                          $transaction->rollback();
                          Yii::app()->user->setFlash('error',"Data gagal disimpan ".MyExceptionMessage::getMessage($e,true));
                     }     
                    
                    
		}

		$this->render($this->path_view.'create',array(
			'model'=>$model
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
//                $modDTDDiagnosaM=SADTDDiagnosaM::model()->findAll('diagnosa_id='.$id.'');
		// Uncomment the following line if AJAX validation is needed
		

		if(isset($_POST['SADiagnosaM']))
		{
                    $transaction = Yii::app()->db->beginTransaction();
                    try 
                    {
                        $model->attributes=$_POST['SADiagnosaM'];
                        $model->diagnosa_aktif=TRUE;
                        $model->save();
                        if(isset($_POST['dtd_id'])){
                            $jumlahDTD=COUNT($_POST['dtd_id']);
                            $diagnosa_id=$model->diagnosa_id;
                            $hapusDTDDiagnosaM=SADTDDiagnosaM::model()->deleteAll('diagnosa_id='.$diagnosa_id.''); 
                                for($i=0; $i<=$jumlahDTD; $i++)
                                    {
                                        $modDTDDiagnosaM=new SADTDDiagnosaM; 
                                        $modDTDDiagnosaM->diagnosa_id=$diagnosa_id;
                                        $modDTDDiagnosaM->dtd_id=$_POST['dtd_id'][$i];
                                        $modDTDDiagnosaM->save();
                                    }
                        }
                        $transaction->commit();
                        Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');    
                        $this->redirect(array('admin'));  
                     }
                    catch (Exception $e)
                     {
                          $transaction->rollback();
                          Yii::app()->user->setFlash('error',"Data gagal disimpan ".MyExceptionMessage::getMessage($e,true));
                     }     
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
                        //if(!Yii::app()->user->checkAccess(Params::DEFAULT_DELETE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
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
		$dataProvider=new CActiveDataProvider('SADiagnosaM');
		$this->render($this->path_view.'index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
                
		$model=new SADiagnosaM('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['SADiagnosaM']))
			$model->attributes=$_GET['SADiagnosaM'];

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
		$model=SADiagnosaM::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='sadiagnosa-m-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
        
        /**
         *Mengubah status aktif
         * @param type $id 
         */
        public function actionRemoveTemporary()
	{
                //if(!Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
//                SADiagnosaM::model()->updateByPk($id, array('diagnosa_aktif'=>false));
//                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
            $id = $_GET['id'];   
            if(isset($_GET['id']))
            {
               
               if (isset($_GET['add'])):
                    $update = SADiagnosaM::model()->updateByPk($id,array('diagnosa_aktif'=>true));
                else:    
                    $update = SADiagnosaM::model()->updateByPk($id,array('diagnosa_aktif'=>false));                       
                endif;
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
            $model= new SADiagnosaM('search');
            $model->unsetAttributes(); 
            if(isset($_REQUEST['SADiagnosaM'])){
                $model->attributes=$_REQUEST['SADiagnosaM'];
            }
            $judulLaporan='Data Diagnosa';
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
                $mpdf->Output($judulLaporan.'-'.date("Y/m/d").'.pdf', 'I');
            }                       
        }
}
