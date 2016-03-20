<?php
class SupplierRekController extends MyAuthController
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
        $model= SupplierrekM::model()->findByAttributes(array('supplier_id'=>$id));

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
		$model=new AKSupplierRekM();
                
                $modSupplier = new SupplierM();

                if (isset($_GET['SupplierM'])){
                        $modSupplier->unsetAttributes();
                        $modSupplier->attributes=$_GET['SupplierM'];
                        $modSupplier->supplier_nama = !empty($_GET['SupplierM']['supplier_nama'])?$_GET['SupplierM']['supplier_nama']:null;
                }
		if(isset($_POST['AKSupplierRekM']))
		{
                        
			$transaction = Yii::app()->db->beginTransaction();
			try{
				 $success = true;
				 $modDetails = $this->validasiTabular($_POST['AKSupplierRekM']);
				 //var_dump(count($modDetails));
				 //exit;
					foreach ($modDetails as $i => $data) {
//                                    echo '<pre>';
//                                    echo print_r($data->jmlsisapiutang);
//                                    echo exit();
						if ($data->supplier_id > 0) {
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
			'model'=>$model, 'modSupplier'=>$modSupplier,
		));
	}
        
        protected function validasiTabular($data){
        	$x = 0;
            foreach ($data['rekening'] as $j => $row) {
	        	foreach ($data['suplier'] as $i => $row2) {  
	        		$modDetails[$x] = new AKSupplierRekM;
	                $modDetails[$x]->attributes = $row;                
	                $modDetails[$x]->supplier_id = $i;
	                $modDetails[$x]->rekening5_id = $row['rekening5_id'];
//	                $modDetails[$x]->rekening4_id = $row['rekening4_id'];
//	                $modDetails[$x]->rekening3_id = $row['rekening3_id'];
//	                $modDetails[$x]->rekening2_id = $row['rekening2_id'];
//	                $modDetails[$x]->rekening1_id = $row['rekening1_id'];
//	                $modDetails[$x]->rekening5_nb = $row['rekening5_nb'];
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
		$model=AKSupplierRekM::model()->findByPk($id);

		// Uncomment the following line if AJAX validation is needed
		

		if(isset($_POST['AKSupplierRekM']))
		{
			$model->attributes=$_POST['AKSupplierRekM'];
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
            $model= AKSupplierRekM::model()->findByPk($id);
            $modSupplier = SupplierM::model()->findByPk($model->supplier_id);

		// Uncomment the following line if AJAX validation is needed
		

		if(isset($_POST['AKSupplierRekM']))
		{
            $model->attributes=$_POST['AKSupplierRekM'];
            $view = 'UbahRekeningDebit';
               
            $update = AKSupplierRekM::model()->updateByPk($id,array('rekening5_id'=>$_POST['AKSupplierRekM']['rekening5_id']));
			if($update){
	            Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
				if (isset($_GET['frame']) && !empty($_GET['idSupplier'])){
                    $this->redirect(array(((isset($view)) ? $view : 'UbahRekeningDebitKredit'),'id'=>$model->supplierrek_id, 'frame'=>$_GET['frame'], 'idSupplier'=>$_GET['idSupplier']));
                }else{
                    $this->redirect(array(((isset($view)) ? $view : 'admin'),'id'=>$model->supplier_id));
                }
            }
        }

		$this->render(((isset($view)) ? $view : '_ubahRekeningDebit'),array(
			'model'=>$model,
            'modSupplier'=>$modSupplier
		));
	}
    
    public function actionUbahRekeningKredit($id)
	{
        //if(!Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
		 	$this->layout = '//layouts/iframe';
            $model= AKSupplierRekM::model()->findByPk($id);
            $modSupplier = SupplierM::model()->findByPk($model->supplier_id);

		// Uncomment the following line if AJAX validation is needed
		

		if(isset($_POST['AKSupplierRekM']))
		{
            $model->attributes=$_POST['AKSupplierRekM'];
            $view = 'UbahRekeningKredit';
               
            $update = AKSupplierRekM::model()->updateByPk($id,array('rekening5_id'=>$_POST['AKSupplierRekM']['rekening5_id']));
			if($update){
                Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
				if (isset($_GET['frame']) && !empty($_GET['idSupplier'])){
                                    $this->redirect(array(((isset($view)) ? $view : 'UbahRekeningDebitKredit'),'id'=>$model->supplierrek_id, 'frame'=>$_GET['frame'], 'idSupplier'=>$_GET['idSupplier']));
                                }else{
                                    $this->redirect(array(((isset($view)) ? $view : 'admin'),'id'=>$model->supplier_id));
                                }
                        }
                }

		$this->render(((isset($view)) ? $view : '_ubahRekeningKredit'),array(
			'model'=>$model,
            'modSupplier'=>$modSupplier
		));
	}

	//Delete rekening supplierrek
	public function actionHapusRekening($id)
	{

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
			$model=AKSupplierRekM::model()->deleteAll('supplier_id=:supplier_id', array(':supplier_id'=>$id));

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
		$dataProvider=new CActiveDataProvider('AKSupplierRekM');
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
		$model=new AKSupplierRekM('search');
		$model->unsetAttributes(); 
                
		if(isset($_GET['AKSupplierRekM'])){
			$model->attributes 		= $_GET['AKSupplierRekM'];
			$model->supplier_nama	= $_GET['AKSupplierRekM']['supplier_nama'];
			$model->rekDebit 		= $_GET['AKSupplierRekM']['rekDebit'];
			$model->rekKredit 		= $_GET['AKSupplierRekM']['rekKredit'];
			// var_dump($_GET['AKSupplierRekM']['supplier_nama']);
			// exit;
		}

		if(isset($_POST['rekening5_id'])){
			$model->attributes=$_POST['rekening5_id'];
			$model->attributes=$_POST['supplier_id'];
			$data['pesan']='<div class="flash-success">Ubah Data Rekening <b></b> Berhasil  Disimpan </div>';
			echo json_encode($data);
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
		$model=SupplierM::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
        
        public function loadDelete($id)
	{
		$model=SupplierM::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='supplierrek-m-form')
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
                AKSupplierRekM::model()->updateByPk($id, array('supplier_aktif '=>false));
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}
        
        public function actionPrint()
        {
            $model= new AKSupplierRekM;
			if(isset($_REQUEST['AKSupplierRekM'])){
				$model->attributes=$_REQUEST['AKSupplierRekM'];
			}
            $judulLaporan='Data Supplier Rekening ';
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
		
	public function actionGetRekeningEditDebitKreditSupplier()
    {
      if(Yii::app()->request->isAjaxRequest) {
//          $rekening1_id   = $_POST['rekening1_id'];
//          $rekening2_id   = $_POST['rekening2_id'];
//          $rekening3_id   = $_POST['rekening3_id'];
//          $rekening4_id   = $_POST['rekening4_id'];
          $rekening5_id   = $_POST['rekening5_id'];
          $supplier_id    = $_POST['supplier_id'];
          $supplierrek_id = $_POST['supplierrek_id'];
//          $saldonormal    = $_POST['saldonormal'];
          
          $update = AKSupplierRekM::model()->updateByPk($supplierrek_id, array('rekening5_id'=>$rekening5_id));
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
