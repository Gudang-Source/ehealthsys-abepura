<?php

class DaftarTindakanMController extends MyAuthController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column1';
	public $defaultAction = 'admin';

	public function actionCreateRuangan()
	{
           //if(!Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}                                             
           $model=new TindakanruanganM; 
                if(isset($_POST['TindakanruanganM']))
                    {
                       
                        $transaction = Yii::app()->db->beginTransaction();
                            try {
                                    $jumlahRuangan=COUNT($_POST['ruangan_id']);
                                    $daftarTindakan_id=$_POST['TindakanruanganM']['daftartindakan_id'];
                                    $hapusTindakanRuangan=TindakanruanganM::model()->deleteAll('daftartindakan_id='.$daftarTindakan_id.''); 
                                    for($i=0; $i<=$jumlahRuangan; $i++)
                                        {
                                            $modTindakanRuangan = new TindakanruanganM;
                                            $modTindakanRuangan->ruangan_id=$_POST['ruangan_id'][$i];
                                            $modTindakanRuangan->daftartindakan_id=$daftarTindakan_id;
                                            $modTindakanRuangan->save();
                                            
                                        }
                                        
                                         Yii::app()->user->setFlash('success', "Data Ruangan Dan Daftar Tindakan Berhasil Disimpan");
                                         $transaction->commit();
                                         $this->redirect(array('admin'));
                                }   
                            catch (Exception $e)
                                {
                                    $transaction->rollback();
                                    Yii::app()->user->setFlash('error', "Data Ruangan Dan Daftar Tindakan Gagal Disimpan");
                                }     
                    }
           $this->render('createRuangan',array('model'=>$model
		));
	}

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
		$model=new SADaftarTindakanM;
        $modTarifTindakan = new SATarifTindakanM();
        $modDetailKomponen = array();
        $modDetail = array();
		// Uncomment the following line if AJAX validation is needed
		

		if(isset($_POST['SADaftarTindakanM']))
		{
                        $model->attributes=$_POST['SADaftarTindakanM'];
                        $model->daftartindakan_aktif=TRUE;
//                    echo "a";exit;
                    $transaction = Yii::app()->db->beginTransaction();
                    try{
//                        echo "b";exit; 
//                        echo "<pre>";
//                        echo print_r($_POST['SATarifTindakanM']);exit;
                        //$modDetailKomponen = $this->validasiTabular($_POST['SATarifTindakanM'],$model);
                        $ok = true;
                        
                        $jumlahDetailKomponen = COUNT($modDetailKomponen);
//                        echo $jumlahDetailKomponen;exit;
                        $jumlahDetail = 0;
                        if($model->validate()){
                            $ok &= $model->save();
                            //$modDetailKomponen = $this->validasiTabular($_POST['SATarifTindakanM'],$model);
//                            echo "c";exit;
                            /*
                            if(isset($_POST['cekTarifTindakan'])){
                                if($jumlahDetailKomponen > 0){
//                                        echo "d";exit;
                                    foreach($modDetailKomponen as $key=>$modDetail){
//                                            echo "e"; exit;
//                                            $modDetail->daftartindakan_id = $model->daftartindakan_id; 
                                       $modDetail->save();
//                                                echo "f";exit;
                                            $jumlahDetail++;
//                                            }
//                                            echo print_r($modDetail->attributes());
//                                            echo print_r($jumlahDetail);exit;
//                                            echo print_r($jumlahDetailKomponen);exit;
                                    }
//                                       exit;
                                }
                            }
                             * 
                             */
                        }else{
                            $ok = false;
//                            echo "g";exit;
//                          
                            //$transaction->rollback();
                            //Yii::app()->user->setFlash('error',"Data gagal disimpan");
                        }
                        
                        if ($ok){
//                            echo "h";exit;
                            $transaction->commit();
                            Yii::app()->user->setFlash('success','<strong>Berhasil</strong>Data Berhasil disimpan');
                            $this->redirect(array('admin','id'=>$model->daftartindakan_id));
                        }
                        else{
//                            echo "i";exit;
                            $transaction->rollback();
                          Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($ex, true));
                        }
                    }
                    catch(Exception $ex){
//                        echo "j";exit;
                        $transaction->rollback();
                       Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($ex, true));
                    }
//                                        Yii::app()->user->setFlash('success','<strong>Berhasil</strong>Data Berhasil disimpan');
			
			
		}
                
                /* untuk pencarian dialog */
                
                if (isset($_GET['FilterForm'])){
                    $_GET['test'] = true;
                    $_GET['term'] = $_GET['FilterForm'];
                }
                if (isset($_GET['test'])){
                    $_GET['term'] = (isset($_GET['term'])) ? $_GET['term'] : null;
                    if(Yii::app()->request->isAjaxRequest) {
                        
                    $criteria = new CDbCriteria();
                    $criteria->compare('LOWER(komponentarif_nama)', strtolower($_GET['term']), true);
//                    $criteria->compare('komponentarif_id', Params::KOMPONENTARIF_ID_TOTAL);
//                    $criteria->order = 'komponentarif_nama';
                    $models = 'KomponentarifM';
                    

                    $dataProvider = new CActiveDataProvider($models, array(
                            'criteria'=>$criteria,
                    ));
                        $route = Yii::app()->createUrl($this->route);
                        $this->renderPartial('_daftarDialog', array('dataProvider'=>$dataProvider, 'models'=>$models, 'route'=>$route));
                        Yii::app()->end();
                    }
                }
                
		$this->render('create',array(
			'model'=>$model,
                        'modTarifTindakan'=>$modTarifTindakan,
                        'modDetailKomponen'=>$modDetailKomponen,
                        'modDetail'=>$modDetail,
		));
	}

        protected function validasiTabular($datas,$modDaftar){
            $modDetails = array();
            if(count($datas) > 0){
                foreach ($datas as $key => $data) {
                $modDetails[$key] = new SATarifTindakanM();
                if(empty($data['komponentarif_id'])){
                    $komponentarif_id = Params::KOMPONENTARIF_ID_TOTAL;
                }else{
                    $komponentarif_id = $data['komponentarif_id'];
                }
                $modDetails[$key]->attributes = $data;
                $modDetails[$key]->komponentarif_id = $komponentarif_id;
                $modDetails[$key]->jenistarif_id = $_POST['SATarifTindakanM']['jenistarif_id'];
                $modDetails[$key]->persendiskon_tind = $_POST['SATarifTindakanM']['persendiskon_tind'];
                $modDetails[$key]->hargadiskon_tind = $_POST['SATarifTindakanM']['hargadiskon_tind'];
                $modDetails[$key]->persencyto_tind = $_POST['SATarifTindakanM']['persencyto_tind'];
                $modDetails[$key]->perdatarif_id =  Params::DEFAULT_PERDA_TARIF;
                $modDetails[$key]->daftartindakan_id = $modDaftar->daftartindakan_id;
                $modDetails[$key]->validate();
//                echo '<pre>';
////                        echo print_r($datas[$key]);
//                        echo print_r($modDetails[$key]->attributes);
                }
//                
//                echo '<pre>';
////                        echo print_r($datas[0]['kelaspelayanan_id']);
//                        echo print_r($modDetails[0]->attributes);
//                        echo print_r($modDetails[1]->attributes);
//                        echo print_r($modDetails[2]->attributes);
//                         exit();
            }
            
//            echo print_r($modDetails[$key]->attributes);exit;
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
		$model=$this->loadModel($id);
                  $modRuangan=TindakanruanganM::model()->findAll('daftartindakan_id='.$id.'');

		// Uncomment the following line if AJAX validation is needed
		
//
//		if(isset($_POST['SADaftarTindakanM']))
//		{
//			$model->attributes=$_POST['SADaftarTindakanM'];
//			if($model->save()){
//                                Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
//				$this->redirect(array('view','id'=>$model->daftartindakan_id));
//                        }
//		}
//                
                
		if(isset($_POST['SADaftarTindakanM']))
		{
                    $transaction = Yii::app()->db->beginTransaction();
                    $model->attributes=$_POST['SADaftarTindakanM'];
                    
                    try {
                    
                        if ($model->save()) {
                            
                            $success = true;
                            $daftarTindakan_id=$model->daftartindakan_id;
                            $hapusTindakanRuangan=TindakanruanganM::model()->deleteAll('daftartindakan_id='.$daftarTindakan_id.''); 
                            
                            if (isset($_POST['ruangan_id'])) {
                                $jumlahRuangan=COUNT($_POST['ruangan_id']);
                                

                                if($jumlahRuangan>0)
                                {
                                    for($i=0; $i<$jumlahRuangan; $i++)
                                    {
                                        $modTindakanRuangan = new TindakanruanganM;
                                        $modTindakanRuangan->ruangan_id=$_POST['ruangan_id'][$i];
                                        $modTindakanRuangan->daftartindakan_id=$daftarTindakan_id;
                                        if (!$modTindakanRuangan->save()){
                                            $success = false;
                                        }
                                    }                
                                }
                            }
                            if ($success && $model->save()){
                                Yii::app()->user->setFlash('success', "Data Ruangan Dan Daftar Tindakan Berhasil Disimpan");
                                $transaction->commit();
                                $this->redirect(array('admin')); 
                            }else{
                                $transaction->rollback();
                                Yii::app()->user->setFlash('error', "Data Ruangan Dan Daftar Tindakan Gagal Disimpan");
                            }
                        } else{
                            $transaction->rollback();
                            Yii::app()->user->setFlash('error', "Data Ruangan Dan Daftar Tindakan Gagal Disimpan");
                        }

                         
                         
                         
                            
                                
                                 

                        
                    } catch (Exception $e)
                    {
                        $transaction->rollback();
                        Yii::app()->user->setFlash('error', "Data Ruangan Dan Daftar Tindakan Gagal Disimpan");
                    }         
		}  

		$this->render('update',array(
			'model'=>$model,'modRuangan'=>$modRuangan
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

			// we only allow deletion via POST request
                        $transaction=Yii::app()->db->beginTransaction();
                        try
                            {
                                $hapusTindakanRuangan=TindakanruanganM::model()->deleteAll('daftartindakan_id='.$id.''); 
                                $this->loadModel($id)->delete();
                                $transaction->commit();
                            }
                         catch (Exception $e)
                                {
                                    $transaction->rollback();
                                    Yii::app()->user->setFlash('error', "Data Ruangan Dan Daftar Tindakan Gagal Dihapus");
                                }     
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
		$dataProvider=new CActiveDataProvider('SADaftarTindakanM');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
                
		$model=new SADaftarTindakanM('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['SADaftarTindakanM'])){
			$model->attributes=$_GET['SADaftarTindakanM'];
                                                // $model->komponenunit_nama = $_GET['SADaftarTindakanM']['komponenunit_nama'];
                                                // $model->kategoritindakan_nama = $_GET['SADaftarTindakanM']['kategoritindakan_nama'];
                                                // $model->kelompoktindakan_nama = $_GET['SADaftarTindakanM']['kelompoktindakan_nama'];
                                                $model->komponenunit_id = $_GET['SADaftarTindakanM']['komponenunit_id'];
                                                $model->kategoritindakan_id = $_GET['SADaftarTindakanM']['kategoritindakan_id'];
                                                $model->kelompoktindakan_id = $_GET['SADaftarTindakanM']['kelompoktindakan_id'];
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
		$model=SADaftarTindakanM::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='sadaftar-tindakan-m-form')
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
			$model->daftartindakan_aktif = false;
			if($model->save()){
			   $data['sukses'] = 1;
			}
			echo CJSON::encode($data); 
		}
                //if(!Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
//                SADaftarTindakanM::model()->updateByPk($id, array('daftartindakan_aktif'=>false));
//                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}
        public function actionPrint()
         {
                                      
             $model= new SADaftarTindakanM();
             $model->attributes=$_REQUEST['SADaftarTindakanM'];
             $judulLaporan = 'Daftar Tindakan';
             $caraPrint= isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null;
            if($caraPrint=='PRINT')
            {
                $this->layout='//layouts/printWindows';
                $this->render('Print',array('model'=>$model,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint));
            }
            else if($caraPrint == 'EXCEL')    
            {
                $this->layout='//layouts/printExcel';
                $this->render('Print',array('model'=>$model,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint));
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
                $mpdf->WriteHTML($this->renderPartial('Print',array('model'=>$model,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint),true));
                $mpdf->Output();
            }                       
         }
}
