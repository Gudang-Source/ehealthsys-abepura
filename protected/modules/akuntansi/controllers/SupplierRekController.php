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

                
		if(isset($_POST['AKSupplierRekM']))
		{
                        // var_dump($_POST); die;
			$transaction = Yii::app()->db->beginTransaction();
			try{
				 $success = true;
                                 
                                 if (isset($_POST['SupplierM'])){
                                        $modSupplier->attributes=$_POST['SupplierM'];
                                        if ($modSupplier->validate()) {
                                            $modSupplier->save();
                                        } else {
                                            $success = false;
                                        }
                                       
                                }
                                 
				 $modDetails = $this->validasiTabular($_POST['AKSupplierRekM'], $modSupplier);
                                foreach ($modDetails as $i => $data) {
                                        $data->save();
                                }
                                //var_dump($success);
                                //die;
				if ($success == true) {
					$transaction->commit();
					Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
					$this->redirect(array('admin'));
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
                
                $modPropinsi = PropinsiM::model()->findByPk(Yii::app()->user->getState('propinsi_id'));
		$latitude = $modPropinsi->latitude;
		$longitude = $modPropinsi->longitude;

		$this->render('create',array(
			'model'=>$model, 'modSupplier'=>$modSupplier, 'latitude'=>$latitude, 'longitude'=>$longitude
		));
	}
        
        protected function validasiTabular($data, $modSupplier){
            $x = 0;
            foreach ($data['rekening'] as $j => $row) {
                $modDetails[$j] = new AKSupplierRekM;
                $modDetails[$j]->attributes = $row;                
                $modDetails[$j]->supplier_id = $modSupplier->supplier_id;
                $modDetails[$j]->rekening5_id = $row['rekening5_id'];
                $modDetails[$j]->debitkredit = $row['rekening5_nb'];
                $modDetails[$j]->validate();
                // var_dump($modDetails[$j]->attributes, $modDetails[$j]->errors);
                $x++;
            }     
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
                $modSupplier = SupplierM::model()->findByPk($id);
                $modeld = AKSupplierRekM::model()->findByAttributes(array('supplier_id'=>$id, 'debitkredit'=>'D'));
                $modelk = AKSupplierRekM::model()->findByAttributes(array('supplier_id'=>$id, 'debitkredit'=>'K'));
                
                if (empty($modeld)) $modeld = new AKSupplierRekM ();
                if (empty($modelk)) $modelk = new AKSupplierRekM ();
                
                
                /*
                $cnt = 0;
                $dk = ['D', 'K'];
                foreach ($amodel as $item) {
                    if (!empty($item->debitkredit)) {
                        $model[$item->debitkredit] = $item;
                    } else {
                        $model[$dk[$cnt]] = $item;
                        $cnt++;
                    }
                }
                
                foreach ($model as $k=>$item) {
                    if (empty($item)) {
                        $model[$k] = new AKSupplierRekM;
                    }
                }
                // var_dump($model); die;
		// Uncomment the following line if AJAX validation is needed
		
                 * 
                 */

		if(isset($_POST['SupplierM'])) {
                    
                    
                    
                    AKSupplierRekM::model()->deleteAllByAttributes(array(
                        'supplier_id'=>$modSupplier->supplier_id,
                    ));
                    
                    if (isset($_POST['SupplierM']['rekening_debit']) && !empty($_POST['SupplierM']['rekening_debit'])) {
                        $deb = new SupplierrekM();
                        $deb->debitkredit = 'D';
                        $deb->supplier_id = $id;
                        $deb->rekening5_id = $_POST['SupplierM']['rekening_debit'];
                    
                        $deb->save();
                    }
                    
                    if (isset($_POST['SupplierM']['rekening_kredit']) && !empty($_POST['SupplierM']['rekening_kredit'])) {
                        $kre = new SupplierrekM();
                        $kre->debitkredit = 'K';
                        $kre->supplier_id = $id;
                        $kre->rekening5_id = $_POST['SupplierM']['rekening_kredit'];
                        $kre->save();
                    }
                    
                    //var_dump($modPenjamin->attributes, $_POST); die; /*
			//$model->attributes=$_POST['AKPenjaminpasienM'];
			//if($model->save()){
                                Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
				$this->redirect(array('admin'));
                        //} */
		}

		$this->render('update',array(
                        'modSupplier'=>$modSupplier,
			'modeld'=>$modeld, 'modelk'=>$modelk,
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
		$model=new SupplierM('search');
		$model->unsetAttributes(); 
                $model->supplier_aktif = true;
                
		if(isset($_GET['SupplierM'])){
			$model->attributes 		= $_GET['SupplierM'];
                        /*
			$model->supplier_nama	= $_GET['AKSupplierRekM']['supplier_nama'];
			$model->rekDebit 		= $_GET['AKSupplierRekM']['rekDebit'];
			$model->rekKredit 		= $_GET['AKSupplierRekM']['rekKredit'];
			// var_dump($_GET['AKSupplierRekM']['supplier_nama']);
			// exit;
                         * 
                         */
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
    
        public function actionGetKabupatendrNamaPropinsi($encode=false,$namaModel='',$attr='')
        {
            if(Yii::app()->request->isAjaxRequest) {
                if ($namaModel == '' && $attr !== '') {
                    $propinsi_nama = $_POST["$attr"];
                }
                 elseif ($namaModel !== '' && $attr !== '') {
                    $propinsi_nama = $_POST["$namaModel"]["$attr"];
                }
                $propinsi = PropinsiM::model()->findByAttributes(array('propinsi_nama'=>$propinsi_nama));
                $propinsi_id = $propinsi->propinsi_id;
                if (COUNT($propinsi)<1) {$propinsi_id=$propinsi_nama;}
                $kabupaten = KabupatenM::model()->findAll("propinsi_id='$propinsi_id' ORDER BY kabupaten_nama asc");
                $kabupaten = CHtml::listData($kabupaten,'kabupaten_nama','kabupaten_nama');

                if($encode){
                    echo CJSON::encode($kabupaten);
                } else {
                    if(empty($kabupaten)){
                        echo CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
                    } else {
                        echo CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
                        foreach($kabupaten as $value=>$name) {
                            echo CHtml::tag('option', array('value'=>$value),CHtml::encode($name),true);
                        }
                    }
                }
            }
            Yii::app()->end();
        }
        
}
