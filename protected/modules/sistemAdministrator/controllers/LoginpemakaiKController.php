
<?php

class LoginpemakaiKController extends Controller
{
	public $ruangantersimpan = true; //looping
	public $modultersimpan = true; //looping
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column1';

	
	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
                                $sqlRuangan  = "SELECT 
                                                          ruangan_m.ruangan_id, 
                                                          ruangan_m.instalasi_id, 
                                                          ruangan_m.ruangan_nama, 
                                                          instalasi_m.instalasi_nama ,
                                                          instalasi_m.instalasi_aktif,
                                                          ruangan_m.ruangan_aktif
                                                        FROM 
                                                          public.instalasi_m, 
                                                          public.ruangan_m, 
                                                          public.ruanganpemakai_k
                                                        WHERE 
                                                          ruangan_m.instalasi_id = instalasi_m.instalasi_id AND
                                                          ruanganpemakai_k.ruangan_id = ruangan_m.ruangan_id AND ruanganpemakai_k.loginpemakai_id = $id 
                                                        ORDER BY instalasi_m.instalasi_nama asc";
                                $sqlModul  = "SELECT 
                                                          moduluser_k.modul_id, 
                                                          moduluser_k.loginpemakai_id, 
                                                          modul_k.modul_nama
                                                        FROM 
                                                          public.modul_k, 
                                                          public.moduluser_k
                                                        WHERE 
                                                          moduluser_k.modul_id = modul_k.modul_id AND moduluser_k.loginpemakai_id = $id
                                                        ORDER BY modul_k.modul_nama asc";
		$this->render('view',array(
			'model'=>$this->loadModel($id),
                                                'modRuanganPemakai'=> Yii::app()->db->createCommand($sqlRuangan)->queryAll(),
                                                'modModulPemakai'=>Yii::app()->db->createCommand($sqlModul)->queryAll(),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
                                //if(!Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
		$format = new MyFormatter();
		$model=new LoginpemakaiK;
		$model->jenispemakai = 'pegawai';
		$model->nama_pemakai = '';
		$simpanRuangan = '';
		$simpanModul = '';
		// Uncomment the following line if AJAX validation is needed
		

		if(isset($_POST['LoginpemakaiK']))
		{
                    $transaction = Yii::app()->db->beginTransaction();
                    try{
						$model->attributes=$_POST['LoginpemakaiK'];
						$model->katakunci_pemakai = $model->new_password;
						$model->ruangan= (isset($_POST['ruangan_id']) ? $_POST['ruangan_id'] : null);
						$model->modul=(isset($_POST['modul_id']) ? $_POST['modul_id'] : null);
						$model->jenispemakai=(isset($_POST['LoginpemakaiK']['jenispemakai']) ? $_POST['LoginpemakaiK']['jenispemakai'] : null);
						$model->loginpemakai_aktif = TRUE;
						$model->statuslogin = FALSE;
						$model->lastlogin = $format->formatDateTimeForDb($model->lastlogin);
						$model->tglpembuatanlogin = $format->formatDateTimeForDb($model->tglpembuatanlogin);
						$model->tglupdatelogin = $format->formatDateTimeForDb($model->tglupdatelogin);
						$model->waktuterakhiraktifitas = $format->formatDateTimeForDb($model->waktuterakhiraktifitas);
						if($_POST['LoginpemakaiK']['jenispemakai'] == 'pegawai'){
							$model->pasien_id = null;
						}else{ 
							$model->pegawai_id = null;
						}

						$model->setScenario('insert');

                        if($model->save()){
                            if($_POST['LoginpemakaiK']['jenispemakai'] == 'pegawai'){
                                $simpanRuangan = $this->insertRuanganPemakai($model);
                                $simpanModul = $this->insertModulPemakai($model);
                            }
                            $transaction->commit();
                            Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
                            $this->redirect(array('admin','id'=>$model->loginpemakai_id, 'modul_id'=>Params::MODUL_ID_SISADMIN));
                        }
                    }catch (Exception $e) {
                        $transaction->rollback();
                        Yii::app()->user->setFlash('error', '<strong>Gagal!</strong> Data gagal disimpan.');
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
		$format = new MyFormatter();
		$model=$this->loadModel($id);
		$model->jenispemakai = 'pegawai';

		$modRuanganPemakai = $this->loadRuanganLogin($id);
		$modModulPemakai = $this->loadModulLogin($id);

		$model->nama_pegawai = isset($model->pegawai_id) ? $model->pegawai->NamaLengkap  : null;
		$model->nama_pasien = isset($model->pasien_id) ? $model->pasien->nama_pasien  : null;
                                
		if(isset($_POST['LoginpemakaiK']))
		{
                    $transaction = Yii::app()->db->beginTransaction();
                    try{
                        $model->attributes=$_POST['LoginpemakaiK'];
                        $model->lastlogin = $format->formatDateTimeForDb($model->lastlogin);
                        $model->tglpembuatanlogin = $format->formatDateTimeForDb($model->tglpembuatanlogin);
                        $model->tglupdatelogin = $format->formatDateTimeForDb($model->tglupdatelogin);
                        $model->waktuterakhiraktifitas = $format->formatDateTimeForDb($model->waktuterakhiraktifitas);
                        $model->old_password = $model->katakunci_pemakai;
                        if($_POST['LoginpemakaiK']['jenispemakai'] == 'pegawai'){
                            $model->pasien_id = null;
                        }else{ 
                            $model->pegawai_id = null;
                        }
                      // if a new password has been entered
                      if (!empty ($model->new_password) || !empty ($model->new_password_repeat) || !empty($model->old_password)) {
                          $model->setScenario('changePassword2');
                      }
                      else{
                          $model->setScenario('update');
                      }
                      if ($model->validate())
                      {
                          $model->lastlogin = date('Y-m-d h:i:s');
                          $model->tglpembuatanlogin = date('Y-m-d h:i:s');
                          if ($model->new_password !== '' && $model->old_password !=='')
                          {
                                if($model->katakunci_pemakai == $model->old_password){
                                   $model->katakunci_pemakai = $model->encrypt($model->new_password);
                                }else{
                                    Yii::app()->user->setFlash('error', '<strong>Gagal!</strong> Password yang anda inputkan tidak sesuai dengan database.');
                                    $this->redirect(array('update','id'=>$model->loginpemakai_id));
                                }
                           }
                          $this->deleteRuanganLogin($id);
                          $this->deleteModulLogin($id);
						  $this->insertRuanganPemakai($model);
						  $this->insertModulPemakai($model);
                          if($model->update() && $this->ruangantersimpan && $this->modultersimpan)
                          {
                              Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
                            // $this->redirect(array('view','id'=>$model->loginpemakai_id)
                              $transaction->commit();
                               $this->redirect(array('admin','id'=>$model->loginpemakai_id, 'modul_id'=>Params::MODUL_ID_SISADMIN));

                          }
                          else
                          {
                              Yii::app()->user->setFlash('error', '<strong>Gagal!</strong> Data Gagal Disimpan.'.CHtml::errorSummary($model));
                               //$this->redirect(array('admin','id'=>$model->loginpemakai_id));
                          }
                      }
                    }catch (Exception $exc) {
						$transaction->rollback();
						Yii::app()->user->setFlash('error',"Data gagal disimpan ".MyExceptionMessage::getMessage($exc,true));
					}
		}

		$this->render('update',array(
			'model'=>$model,
                        'modRuanganPemakai'=>$modRuanganPemakai,
                        'modModulPemakai'=>$modModulPemakai,
                                  ));
	}
	/**
	 * klon data pemakai
	 */
	public function actionKlon($id)
	{
		$this->layout='//layouts/iframe';
		$model=$this->loadModel($id);
		$models = new LoginpemakaiK();
		if(empty($model->pegawai_id)){
			$nama = PasienM::model()->findByAttributes(array('pasien_id'=>$model->pasien_id));
			if(isset($_POST['LoginpemakaiK'])){
				$models->attributes=$_POST['LoginpemakaiK'];
				$models->pasien_id = $model->pasien_id;
				$models->nama_pemakai=$_POST['LoginpemakaiK']['nama_pemakai'];
				$models->katakunci_pemakai=  $_POST['LoginpemakaiK']['new_password'];
				$models->new_password_repeat=$_POST['LoginpemakaiK']['new_password'];
				$models->lastlogin=$model->lastlogin;
				$models->tglpembuatanlogin=date('Y-m-d');
				$models->tglupdatelogin=$model->tglupdatelogin;
				$models->statuslogin=$model->statuslogin;
				$models->loginpemakai_create = Yii::app()->user->id;
				$models->loginpemakai_aktif=$model->loginpemakai_aktif;
				$models->waktuterakhiraktifitas=$model->waktuterakhiraktifitas;
				if($models->save()){
					Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
				}
			}
		}else{
			$nama = PegawaiM::model()->findByAttributes(array('pegawai_id'=>$model->pegawai_id));	
			if(isset($_POST['LoginpemakaiK'])){
				$models->attributes=$_POST['LoginpemakaiK'];
				$models->pegawai_id = $model->pegawai_id;
				$models->nama_pemakai=$_POST['LoginpemakaiK']['nama_pemakai'];
				$models->katakunci_pemakai=  $_POST['LoginpemakaiK']['new_password'];
				$models->new_password_repeat=$_POST['LoginpemakaiK']['new_password'];
				$models->lastlogin=$model->lastlogin;
				$models->tglpembuatanlogin=date('Y-m-d');
				$models->tglupdatelogin=$model->tglupdatelogin;
				$models->statuslogin=$model->statuslogin;
				$models->loginpemakai_create = Yii::app()->user->id;
				$models->loginpemakai_aktif=$model->loginpemakai_aktif;
				$models->waktuterakhiraktifitas=$model->waktuterakhiraktifitas;
				if($models->save()){
					Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
				}				
			}			
		}
		
		$this->render('_formklon',array(
			'model'=>$model,
			'nama'=>$nama,
			'models'=>$models
            ));
	}
	
	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('LoginpemakaiK');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
                                
		$model=new LoginpemakaiK('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['LoginpemakaiK']))
                                {  
                                    $model->attributes=$_GET['LoginpemakaiK'];  
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
		$model=LoginpemakaiK::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='loginpemakai-k-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
        
          
                /**
                 * Menghapus ruangan-ruangan berdasarkan loginpemakai_id di ruanganpemakai_k
                 * @param type $loginId 
                 */
                public function deleteRuanganLogin($loginId)
                {
                    $result = RuanganpemakaiK::model()->deleteAllByAttributes(array('loginpemakai_id'=>$loginId));

                }
                
                /**
                 *Mengambil nilai dari ruanganpemakai_k berdasarkan loginpemakai_id
                 * @param type $loginId
                 * @return $result array() 
                 */
                public function loadRuanganLogin($loginId)
                {
                    $result = RuanganpemakaiK::model()->findAllByAttributes(array('loginpemakai_id'=>$loginId));
                    return $result;

                }
                
                /**
                 * Menyimpan data ke tabel ruanganpemakai_k
                 * @param type $status
                 */
                 
                public function insertRuanganPemakai($model)
                {
                    $ruangan = new RuanganpemakaiK;
                    if(isset($_POST['ruangan_id'])){
                       $hitung = count($_POST['ruangan_id']);
                       if($hitung < 1){return $status = TRUE;} //kondisi apabila tidak ada inputan di emultiselect
                       for($i=0;$i<$hitung;$i++){  
                          $ruangan = new RuanganpemakaiK;
                          $ruangan->loginpemakai_id = $model->loginpemakai_id;
                          $ruangan->ruangan_id = $_POST['ruangan_id'][$i];
                          if($ruangan->save()){
                              $this->ruangantersimpan &= true;
                          }else{
                              $this->ruangantersimpan &= false;
                          }
                       }
                    }

                     return $ruangan;
                    
                }
                
                /**
                 * Menghapus modul-modul berdasarkan loginpemakai_id di moduluser_k
                 * @param type $loginId 
                 */
                public function deleteModulLogin($loginId)
                {
                    $result = ModuluserK::model()->deleteAllByAttributes(array('loginpemakai_id'=>$loginId));

                }
                
                /**
                 *Mengambil nilai dari moduluser_k berdasarkan loginpemakai_id
                 * @param type $loginId
                 * @return $result array() 
                 */
                public function loadModulLogin($loginId)
                {
                    $result = ModuluserK::model()->findAllByAttributes(array('loginpemakai_id'=>$loginId));
                    return $result;

                }
                
                /**
                 * Menyimpan data ke tabel moduluser_k
                 * @param type $status
                 */
                 
                public function insertModulPemakai($model)
                {
                    $modul = new ModuluserK;
                    if(isset($_POST['modul_id'])){
                       $hitung = count($_POST['modul_id']);
                       if($hitung < 1){return $status = TRUE;} //kondisi apabila tidak ada inputan di emultiselect
                       for($i=0;$i<$hitung;$i++){                               
                          $modul = new ModuluserK;
                          $modul->loginpemakai_id = $model->loginpemakai_id;
                          $modul->modul_id = $_POST['modul_id'][$i];
                          if($modul->save()){
                              $this->modultersimpan &= true;
                          }else{
                              $this->modultersimpan &= false;
                          }
                       }
                    }

                   return $modul;
                    
                }
                public function actionDelete()
				{              
					//if(!Yii::app()->user->checkAccess(Params::DEFAULT_DELETE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
					if(Yii::app()->request->isPostRequest)
					{
                                                $id = $_POST['id'];
                                                $this->loadModel($id)->delete();
                                                if (Yii::app()->request->isAjaxRequest)
                                                    {
                                                        echo CJSON::encode(array(
                                                            'status'=>'proses_form', 
                                                            'div'=>"<div class='flash-success'>Data berhasil dihapus.</div>",
                                                            ));
                                                        exit;               
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
                       $update = LoginpemakaiK::model()->updateByPk($id,array('loginpemakai_aktif'=>false));
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
                 $model= new LoginpemakaiK;
                 $model->attributes=$_REQUEST['LoginpemakaiK'];
                 if(isset($_GET['LoginpemakaiK']))
                                {  
                                    $model->attributes=$_GET['LoginpemakaiK'];  
                                }
                 $judulLaporan=' Data Pemakai';
                 $caraPrint=$_REQUEST['caraPrint'];
                if($caraPrint=='PRINT')
                    {
                        $this->layout='//layouts/printWindows';
                        $this->render('Print',array('model'=>$model,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint));
                    }
                else if($caraPrint=='EXCEL')    
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
                
                /**
                 * fungsi untuk mengganti password login pemakai
                 * @param type $id integer
                 */
               /* public function actionGantiPassword($id){
                    $model = $this->loadModel($id);
                    $prevUrl = Yii::app()->request->getUrlReferrer();
                    $format = new MyFormatter();
                    if(isset ($_POST['LoginpemakaiK'])){
                        $model->attributes=$_POST['LoginpemakaiK'];
                        $model->old_password = $_POST['LoginpemakaiK']['old_password'];
                        $model->setScenario('changePassword');
                        $model->lastlogin = date('Y-m-d');
                        $model->tglupdatelogin = date('Y-m-d');
                        $model->loginpemakai_update = 1;
                        $model->tglpembuatanlogin = empty($model->tglpembuatanlogin) ? null : $format->formatDateTimeForDb($model->tglpembuatanlogin);
                        if ($model->validate())
                        {
                            if ($model->new_password !== '' && $model->old_password !=='')
                            {
                                  if($model->katakunci_pemakai == $model->encrypt($model->old_password)){
                                     $model->katakunci_pemakai = $model->encrypt($model->new_password);
                                  }else{
                                      Yii::app()->user->setFlash('error', '<strong>Gagal!</strong> Password yang anda inputkan tidak sesuai dengan database.');
                                      $this->redirect(array('GantiPassword','id'=>$model->loginpemakai_id));
                                  }
                             }
                            if($model->update())
                            {
                                Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Password berhasil disimpan.');
                                $this->redirect($_POST['prevUrl']);  
                            }
                            else
                            {
                                Yii::app()->user->setFlash('error', '<strong>Gagal!</strong> Data Gagal Disimpan.');
                                 $this->redirect(array('GantiPassword','id'=>$model->loginpemakai_id));
                            }
                        }
                    }
                        $this->render('gantiPassword',array(
                            'model'=>$model,'prevUrl'=>$prevUrl,
                    ));
                    
                    
                }*/
                public function actionGantiPassword($id=''){
                    if(empty ($id))
                        $id = Yii::app()->user->id;
                    
                    //echo $_SESSION['username'];
                    //echo Yii::app()->user->name;
                    //echo Yii::app()->session['instalasi_id'];
                    //echo Yii::app()->user->getState('instalasi_id');
                    $model = $this->loadModel($id);
                    $prevUrl = Yii::app()->request->getUrlReferrer();
                    if(isset ($_POST['LoginpemakaiK'])){
                        $model->attributes=$_POST['LoginpemakaiK'];
                        $model->old_password = $_POST['LoginpemakaiK']['old_password'];
                        $model->setScenario('changePassword');
                        if ($model->validate())
                        {
                            if ($model->new_password !== '' && $model->old_password !=='')
                            {
                                  if($model->katakunci_pemakai == $model->encrypt($model->old_password)){
                                     $model->katakunci_pemakai = $model->encrypt($model->new_password);
                                     $model->loginpemakai_update = 1;
                                  }else{
                                      Yii::app()->user->setFlash('error', '<strong>Gagal!</strong> Password yang anda inputkan tidak sesuai dengan database.');
                                      $this->redirect(array('GantiPassword','id'=>$model->loginpemakai_id));
                                  }
                             }
                            if($model->update())
                            {
                                Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Password berhasil disimpan.');
                                $this->redirect($_POST['prevUrl']);  
                            }
                            else
                            {
                                Yii::app()->user->setFlash('error', '<strong>Gagal!</strong> Data Gagal Disimpan.');
                                 $this->redirect(array('GantiPassword','id'=>$model->loginpemakai_id));
                            }
                        }
                    }
                        $this->render('gantiPassword',array(
                            'model'=>$model,'prevUrl'=>$prevUrl,
                    ));
                    
                    
                }

    public function actionAutoCompletePegawai()
    {
        if(Yii::app()->request->isAjaxRequest) {
            $criteria = new CDbCriteria();
            $criteria->compare('LOWER(nama_pegawai)', strtolower($_GET['term']), true);
            $criteria->order = 'nama_pegawai';
            $criteria->limit=5;
            $models = PegawaiM::model()->findAll($criteria);
            $returnVal = array();
            foreach($models as $i=>$model)
            {
                $attributes = $model->attributeNames();
                foreach($attributes as $j=>$attribute) {
                    $returnVal[$i]["$attribute"] = $model->$attribute;
                }
                $returnVal[$i]['label'] = $model->namaLengkap;
                $returnVal[$i]['value'] = $model->pegawai_id;
            }

            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }
    
    public function actionAutocompletePasien()
    {
        if(Yii::app()->request->isAjaxRequest) {
            $criteria = new CDbCriteria();
            $criteria->compare('LOWER(no_rekam_medik)', strtolower($_GET['term']), true);
            $criteria->order = 'nama_pasien';
            $criteria->limit=5;
            $models = PasienM::model()->findAll($criteria);
            $returnVal = array();
            foreach($models as $i=>$model)
            {
                $attributes = $model->attributeNames();
                foreach($attributes as $j=>$attribute) {
                    $returnVal[$i]["$attribute"] = $model->$attribute;
                }
                $returnVal[$i]['label'] = $model->no_rekam_medik.' - '.$model->nama_pasien;
                $returnVal[$i]['value'] = $model->nama_pasien;
            }

            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }
}
