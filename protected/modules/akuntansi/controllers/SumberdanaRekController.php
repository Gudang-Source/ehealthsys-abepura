<?php
class SumberdanaRekController extends MyAuthController
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
        $model= SumberdanarekM::model()->findByAttributes(array('sumberdana_id'=>$id));
                
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
                //if(!Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
		$model=new AKSumberdanaRekM();
                
		$modSumberdana = new SumberdanaM();
		$modDetails = array();
		
		if (isset($_GET['SumberdanaM'])){
				$modSumberdana->unsetAttributes();
				$modSumberdana->attributes=$_GET['SumberdanaM'];
				$modSumberdana->sumberdana_nama = isset($_GET['SumberdanaM']['sumberdana_nama'])?$_GET['SumberdanaM']['sumberdana_nama']:null;
		}
		if(isset($_POST['AKSumberdanaRekM']))
		{                        
			$transaction = Yii::app()->db->beginTransaction();
			try{
				 $success = true;
				 $modDetails = $this->validasiTabular($_POST['AKSumberdanaRekM']);
				 //var_dump(count($modDetails));
				 //exit;
					foreach ($modDetails as $i => $data) {
//                                    echo '<pre>';
//                                    echo print_r($data->jmlsisapiutang);
//                                    echo exit();
						if ($data->sumberdana_id > 0) {
							// if ($data->update()) {
							//     $success = true;

							// } else {
							//     $success = false;
							// }
							// echo '<pre>';
							// echo print_r($data->getErrors());
							// echo '</pre>';
//                                          exit();
							$data->save();
						}else{
							$data->save();
						}
					}

				if ($success == true) {
					$transaction->commit();
					Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
					$this->redirect(array('admin','id'=>1));
				} else {
					$transaction->rollback();
					Yii::app()->user->setFlash('error', "Data gagal disimpan ");
				}
			}
			catch(Exception $ex){
				$transaction->rollback();
				Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($ex, true));
			}

		}

		$this->render('create',array(
			'model'=>$model, 'modSumberdana'=>$modSumberdana,'modDetails'=>$modDetails
		));
	}
        
        protected function validasiTabular($data){
        	$x = 0;
            foreach ($data['rekening'] as $j => $row) {
	        	foreach ($data['sumberdana'] as $i => $row2) {  
	        		$modDetails[$x] = new AKSumberdanaRekM;
	                $modDetails[$x]->attributes = $row;                
	                $modDetails[$x]->sumberdana_id = $i;
	                $modDetails[$x]->rekening5_id = $row['rekening5_id'];
	                $modDetails[$x]->validate();
	                $x++;
		        }
    //            echo '<pre>';
    //            echo print_r($modDetails[$i]->getErrors());
    //            echo '</pre>';
                //print_r($data['suplier']);
    			//exit;
            }        	
			//print_r(count($modDetails));
	        //exit;

            return $modDetails;
        }
	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
                //if(!Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
		$model=AKSumberdanaRekM::model()->findByPk($id);

		// Uncomment the following line if AJAX validation is needed
		

		if(isset($_POST['AKSumberdanaRekM']))
		{
			$model->attributes=$_POST['AKSumberdanaRekM'];
			if($model->save()){
                                Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
				$this->redirect(array('admin','id'=>1));
                        }
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

    public function actionUbahRekeningDebit($id)
	{
        //if(!Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
		 	$this->layout = '//layouts/iframe';
            $model= AKSumberdanaRekM::model()->findByPk($id);
            $modSumberdana = SumberdanaM::model()->findByPk($model->sumberdana_id);

		// Uncomment the following line if AJAX validation is needed
		

		if(isset($_POST['AKSumberdanaRekM']))
		{
            $model->attributes=$_POST['AKSumberdanaRekM'];
            $view = 'UbahRekeningDebit';
               
            $update = AKSumberdanaRekM::model()->updateByPk($id,array('rekening5_id'=>$_POST['AKSumberdanaRekM']['rekening5_id']));
			if($update){
	            Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
				if (isset($_GET['frame']) && !empty($_GET['idSumberdana'])){
                    $this->redirect(array(((isset($view)) ? $view : 'UbahRekeningDebitKredit'),'id'=>$model->sumberdanarek_id, 'frame'=>$_GET['frame'], 'idSumberdana'=>$_GET['idSumberdana']));
                }else{
                    $this->redirect(array(((isset($view)) ? $view : 'admin'),'id'=>$model->sumberdana_id));
                }
            }
        }

		$this->render(((isset($view)) ? $view : '_ubahRekeningDebit'),array(
			'model'=>$model,
            'modSumberdana'=>$modSumberdana
		));
	}
    
    public function actionUbahRekeningKredit($id)
	{
        //if(!Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
		 	$this->layout = '//layouts/iframe';
            $model= AKSumberdanaRekM::model()->findByPk($id);
            $modSumberdana = SumberdanaM::model()->findByPk($model->sumberdana_id);

		// Uncomment the following line if AJAX validation is needed
		

		if(isset($_POST['AKSumberdanaRekM']))
		{
            $model->attributes=$_POST['AKSumberdanaRekM'];
            $view = 'UbahRekeningKredit';
               
            $update = AKSumberdanaRekM::model()->updateByPk($id,array('rekening5_id'=>$_POST['AKSumberdanaRekM']['rekening5_id']));
			if($update){
                Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
				if (isset($_GET['frame']) && !empty($_GET['idSumberdana'])){
                                    $this->redirect(array(((isset($view)) ? $view : 'UbahRekeningDebitKredit'),'id'=>$model->sumberdanarek_id, 'frame'=>$_GET['frame'], 'idSumberdana'=>$_GET['idSumberdana']));
                                }else{
                                    $this->redirect(array(((isset($view)) ? $view : 'admin'),'id'=>$model->sumberdana_id));
                                }
                        }
                }

		$this->render(((isset($view)) ? $view : '_ubahRekeningKredit'),array(
			'model'=>$model,
            'modSumberdana'=>$modSumberdana
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
			$model=AKSumberdanaRekM::model()->deleteAll('sumberdana_id=:sumberdana_id', array(':sumberdana_id'=>$id));

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
		$dataProvider=new CActiveDataProvider('AKSumberdanaRekM');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin($id='')
	{
                if ($id==1):
                    Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
                endif;    
		$model=new AKSumberdanaRekM('search');
		$model->unsetAttributes(); 
                
		if(isset($_GET['AKSumberdanaRekM'])){
			$model->attributes=$_GET['AKSumberdanaRekM'];
			$model->sumberdana_nama = $_GET['AKSumberdanaRekM']['sumberdana_nama'];
			$model->rekDebit 		= $_GET['AKSumberdanaRekM']['rekDebit'];
			$model->rekKredit 		= $_GET['AKSumberdanaRekM']['rekKredit'];
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
		$model=SumberdanaM::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
        
        public function loadDelete($id)
	{
		$model=SumberdanaM::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='sumberdanarek-m-form')
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
		AKSumberdanaRekM::model()->updateByPk($id, array('sumberdana_aktif '=>false));
		$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}
        
	public function actionPrint()
	{
		$model= new AKSumberdanaRekM;
		
		if(isset($_REQUEST['AKSumberdanaRekM'])){
			$model->attributes=$_REQUEST['AKSumberdanaRekM'];
		}		
		$judulLaporan='Data Sumber Dana Rekening ';
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
	
	public function actionGetRekeningEditDebitKreditSumberdana()
    {
      if(Yii::app()->request->isAjaxRequest) {
          
          $rekening5_id     = $_POST['rekening5_id'];
          $sumberdana_id    = $_POST['sumberdana_id'];
          $sumberdanarek_id = $_POST['sumberdanarek_id'];
          
          $update = AKSumberdanaRekM::model()->updateByPk($sumberdanarek_id, array('rekening5_id'=>$rekening5_id));
          if($update){
              $data['pesan']='<div class="flash-success">Ubah Data Rekening <b></b> Berhasil  Disimpan </div>';
          }else{
              $data['pesan']='<div class="flash-error">Ubah Data Rekening <b></b> Gagal  Disimpan </div>';
          }
          echo json_encode($data);
      Yii::app()->end();
      }
    }
        
}
