<?php

class RuanganMController extends MyAuthController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column1';
                public $defaultAction = 'admin';

        
        
        public function actionCreatePegawaiRuangan()
	{
           $model=new RuanganpegawaiM; 
                if(isset($_POST['RuanganpegawaiM']))
                    {
                       
                        $transaction = Yii::app()->db->beginTransaction();
                            try {
                                    $jumlahRuanganPegawai=isset($_POST['pegawai_id'])?COUNT($_POST['pegawai_id']):0;
                                    $ruangan_id=$_POST['RuanganpegawaiM']['ruangan_id'];
                                    $hapusTindakanRuangan=RuanganpegawaiM::model()->deleteAll('ruangan_id='.$ruangan_id.''); 
                                    for($i=0; $i<$jumlahRuanganPegawai; $i++)
                                        {
                                            $modRuanganPegawai = new RuanganpegawaiM;
                                            $modRuanganPegawai->ruangan_id=$ruangan_id;
                                            $modRuanganPegawai->pegawai_id=$_POST['pegawai_id'][$i];
                                            $modRuanganPegawai->save();
                                            
                                        }
                                        
                                         Yii::app()->user->setFlash('success', "Data Ruangan Dan Pegawai Berhasil Disimpan");
                                         $transaction->commit();
                                         $this->redirect(array('admin'));
                                }   
                            catch (Exception $e)
                                {
                                    $transaction->rollback();
                                    Yii::app()->user->setFlash('error', "Data Ruangan Dan Pegawai Gagal Disimpan");
                                }     
                    }
           $this->render('createRuanganPegawai',array('model'=>$model
		));
	}
        
        public function actionCreateDaftarTindakan()
	{
           $model=new TindakanruanganM; 
                if(isset($_POST['TindakanruanganM']))
                    {
                       
                        $transaction = Yii::app()->db->beginTransaction();
                            try {
                                    $jumlahTindakanRuangan=isset($_POST['daftartindakan_id'])?COUNT($_POST['daftartindakan_id']):0;
                                    $ruangan_id=$_POST['TindakanruanganM']['ruangan_id'];
                                    $hapusTindakanRuangan=TindakanruanganM::model()->deleteAll('ruangan_id='.$ruangan_id.''); 
                                    for($i=0; $i<=$jumlahTindakanRuangan; $i++)
                                        {
                                            $modTindakanRuangan = new TindakanruanganM;
                                            $modTindakanRuangan->ruangan_id=$ruangan_id;
                                            $modTindakanRuangan->daftartindakan_id=$_POST['daftartindakan_id'][$i];
                                            $modTindakanRuangan->save();
                                            
                                        }
                                        
                                         Yii::app()->user->setFlash('success', "Data Ruangan Dan Kelas Ruangan Berhasil Disimpan");
                                         $transaction->commit();
                                         $this->redirect(array('admin'));
                                }   
                            catch (Exception $e)
                                {
                                    $transaction->rollback();
                                    Yii::app()->user->setFlash('error', "Data Ruangan Dan Kelas Ruangan Gagal Disimpan");
                                }     
                    }
           $this->render('createTindakanRuangan',array('model'=>$model
		));
	}
        
        public function actionCreateKelasRuangan()
	{
           $model=new KelasruanganM; 
                if(isset($_POST['KelasruanganM']))
                    {
                       
                        $transaction = Yii::app()->db->beginTransaction();
                            try {
                                    $jumlahKelasPelayanan=isset($_POST['kelaspelayanan_id'])?COUNT($_POST['kelaspelayanan_id']):0;
                                    $ruangan_id=$_POST['KelasruanganM']['ruangan_id'];
                                    $hapuskelasRuangan=KelasruanganM::model()->deleteAll('ruangan_id='.$ruangan_id.''); 
                                    for($i=0; $i<=$jumlahKelasPelayanan; $i++)
                                        {
                                            $modKasusRuangan = new KelasruanganM;
                                            $modKasusRuangan->ruangan_id=$ruangan_id;
                                            $modKasusRuangan->kelaspelayanan_id=$_POST['kelaspelayanan_id'][$i];
                                            $modKasusRuangan->save();
                                            
                                        }
                                        
                                         Yii::app()->user->setFlash('success', "Data Ruangan Dan Kelas Ruangan Berhasil Disimpan");
                                         $transaction->commit();
                                         $this->redirect(array('admin'));
                                }   
                            catch (Exception $e)
                                {
                                    $transaction->rollback();
                                    Yii::app()->user->setFlash('error', "Data Ruangan Dan Kelas Ruangan Gagal Disimpan");
                                }     
                    }
           $this->render('createKelasRuangan',array('model'=>$model
		));
	}
        
        public function actionCreateJenisKasusPenyakit()
	{
           $model=new KasuspenyakitruanganM; 
                if(isset($_POST['KasuspenyakitruanganM']))
                    {
                       
                        $transaction = Yii::app()->db->beginTransaction();
                            try {
                                    $jumlahJenisKasusPenyakit=isset($_POST['jeniskasuspenyakit_id'])?COUNT($_POST['jeniskasuspenyakit_id']):0;
                                    $ruangan_id=$_POST['KasuspenyakitruanganM']['ruangan_id'];
                                    $hapusKasusPenyakitRuangan=KasuspenyakitruanganM::model()->deleteAll('ruangan_id='.$ruangan_id.''); 
                                    for($i=0; $i<=$jumlahJenisKasusPenyakit; $i++)
                                        {
                                            $modKasusRuangan = new KasuspenyakitruanganM;
                                            $modKasusRuangan->ruangan_id=$ruangan_id;
                                            $modKasusRuangan->jeniskasuspenyakit_id=$_POST['jeniskasuspenyakit_id'][$i];
                                            $modKasusRuangan->save();
                                            
                                        }
                                        
                                         Yii::app()->user->setFlash('success', "Data Ruangan Dan Jenis Kasus Penyakit Berhasil Disimpan");
                                         $transaction->commit();
                                         $this->redirect(array('admin'));
                                }   
                            catch (Exception $e)
                                {
                                    $transaction->rollback();
                                    Yii::app()->user->setFlash('error', "Data Ruangan Dan Jenis Kasus Penyakit Gagal Disimpan");
                                }     
                    }
           $this->render('createJenisKasusPenyakit',array('model'=>$model
		));
	}
        
	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
    $modKasusPenyakitRuangan = array();
		$this->render('view',array(
			'model'=>$this->loadModel($id),
                        'modKasusPenyakitRuangan'=>$modKasusPenyakitRuangan,
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new SARuanganM;
                $modRiwayatRuangan=new SARiwayatRuanganR;

		// Uncomment the following line if AJAX validation is needed
		
                if(isset($_POST['SARuanganM']))
                {
                  $transaction = Yii::app()->db->beginTransaction();
                  try {
                        $modRiwayatRuangan=new SARiwayatRuanganR; 
                        $modRiwayatRuangan->attributes=$_POST['SARiwayatRuanganR'];
                        $modRiwayatRuangan->save();
                        $valid=true;
                        foreach($_POST['SARuanganM'] as $i=>$item):
                            if(is_integer($i)) {
                              $model=new SARuanganM;
                              $random=rand(0000000,9999999);
                              $model->attributes=$_POST['SARuanganM'][$i];
                              $model->instalasi_id=$_POST['instalasi_id'];
                              $model->ruangan_image = CUploadedFile::getInstance($model, '['.$i.']ruangan_image');
                              $model->riwayatruangan_id=$modRiwayatRuangan->riwayatruangan_id;
                              $gambar=$model->ruangan_image;
                              if(!empty($model->ruangan_image)){//Klo User Memasukan Logo

                                     $model->ruangan_image = $random.$model->ruangan_image;
                                     Yii::import("ext.EPhpThumb.EPhpThumb");
                                     $thumb=new EPhpThumb();
                                     $thumb->init(); //this is needed
                                     $fullImgName =$model->ruangan_image;   
                                     $fullImgSource = Params::pathRuanganDirectory().$fullImgName;
                                     $fullThumbSource = Params::pathRuanganTumbsDirectory().'kecil_'.$fullImgName;
                                     $model->ruangan_image = $fullImgName;
                                     if($model->save()){
                                               $gambar->saveAs($fullImgSource);
                                               $thumb->create($fullImgSource)
                                                     ->resize(200,200)
                                                     ->save($fullThumbSource);
                                     }
                              }else{//Klo User Tidak Memasukan Logo
                                  if($model->save()){
                                      $transaction->commit();
                                       Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
                                       $this->redirect(array('admin','id'=>$model->ruangan_id));
                                  }
                               }
                           }
                       endforeach;
                       
                       
                    } catch(Exception $exc){
                               $transaction->rollback();
                               Yii::app()->user->setFlash('error', '<strong>Gagal!</strong> Data Gagal disimpan'.MyExceptionMessage::getMessage($exc,true).'');

                      }
                }   
		

		$this->render('create',array(
			'model'=>$model,'modRiwayatRuangan'=>$modRiwayatRuangan
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);
                $modKasusPenyakitRuangan=KasuspenyakitruanganM::model()->findAll('ruangan_id='.$id.'');
                $modKelasRuangan=KelasruanganM::model()->findAll('ruangan_id='.$id.'');
                $modTindakanRuangan=TindakanruanganM::model()->findAll('ruangan_id='.$id.'');
                $modRuanganPegawai=RuanganpegawaiM::model()->findAll('ruangan_id='.$id.'');
                $modRiwayatRuangan=RiwayatruanganR::model()->findByPk($model->riwayatruangan_id);

		// Uncomment the following line if AJAX validation is needed
		
                  
		if(isset($_POST['SARuanganM']))
		{
                    
                        $transaction = Yii::app()->db->beginTransaction();
                            try {
                                    $model->attributes=$_POST['SARuanganM'];
                                    $model->save();
                                    $jumlahKelasPelayanan=isset($_POST['kelaspelayanan_id'])?COUNT($_POST['kelaspelayanan_id']):0;
                                    $jumlahJenisKasusPenyakit=isset($_POST['jeniskasuspenyakit_id'])?COUNT($_POST['jeniskasuspenyakit_id']):0;
                                    $jumlahDaftarTindakan=isset($_POST['daftartindakan_id'])?COUNT($_POST['daftartindakan_id']):0;
                                    $jumlahRuanganPegawai=isset($_POST['pegawai_id'])?COUNT($_POST['pegawai_id']):0;

    
                                    $ruangan_id=$model->ruangan_id;
                                    $hapusKasusPenyakitRuangan=KasuspenyakitruanganM::model()->deleteAll('ruangan_id='.$ruangan_id.''); 
                                    $hapuskelasRuangan=KelasruanganM::model()->deleteAll('ruangan_id='.$ruangan_id.''); 
                                    $hapusTindakanRuangan=TindakanruanganM::model()->deleteAll('ruangan_id='.$ruangan_id.''); 
                                    $hapusRuanganPegawai=RuanganpegawaiM::model()->deleteAll('ruangan_id='.$ruangan_id.''); 

                                    // print_r($_POST['jeniskasuspenyakit_id']); exit();

                                    $dataKelasPelayanan=isset($_POST['kelaspelayanan_id'])?$_POST['kelaspelayanan_id']:0;
                                    $dataJenisKasusPenyakit=isset($_POST['jeniskasuspenyakit_id'])?$_POST['jeniskasuspenyakit_id']:0;
                                    $dataDaftarTindakan=isset($_POST['daftartindakan_id'])?$_POST['daftartindakan_id']:0;
                                    $dataRuanganPegawai=isset($_POST['pegawai_id'])?$_POST['pegawai_id']:0;

                                    if($jumlahJenisKasusPenyakit>0)
                                        {
                                            // for($i=0; $i<$jumlahJenisKasusPenyakit; $i++)
                                            foreach ($dataJenisKasusPenyakit as $i => $jeniskasuspenyakit)
                                                {
                                                    $modKasusRuangan = new KasuspenyakitruanganM;
                                                    $modKasusRuangan->ruangan_id=$ruangan_id;
                                                    $modKasusRuangan->jeniskasuspenyakit_id=$jeniskasuspenyakit;
                                                    $modKasusRuangan->save(); 
                                                }
                                        }
                                        
                                    if($jumlahKelasPelayanan>0)
                                        {    
                                            // for($i=0; $i<$jumlahKelasPelayanan; $i++)
                                            foreach ($dataKelasPelayanan as $i => $kelaspelayanan)
                                                {
                                                    $modKasusRuangan = new KelasruanganM;
                                                    $modKasusRuangan->ruangan_id=$ruangan_id;
                                                    $modKasusRuangan->kelaspelayanan_id=$kelaspelayanan;
                                                    $modKasusRuangan->save();
                                                }
                                        }
                                        
                                      if($jumlahDaftarTindakan>0)
                                        {    
                                        
                                              // for($j=0; $j<$jumlahDaftarTindakan; $j++)
                                            foreach ($dataDaftarTindakan as $i => $daftartindakan)
                                                {
                                                    $modTindakanRuangan = new TindakanruanganM;
                                                    $modTindakanRuangan->ruangan_id=$ruangan_id;
                                                    $modTindakanRuangan->daftartindakan_id=$daftartindakan;
                                                    $modTindakanRuangan->save();
                                                }
                                        }
                                        
                                      if($jumlahRuanganPegawai>0)
                                        {    
                                        
                                              // for($j=0; $j<$jumlahRuanganPegawai; $j++)
                                            foreach ($dataRuanganPegawai as $i => $ruangan)
                                                {
                                                    $modRuanganPegawai = new RuanganpegawaiM;
                                                    $modRuanganPegawai->ruangan_id=$ruangan_id;
                                                    $modRuanganPegawai->pegawai_id=$ruangan;
                                                    $modRuanganPegawai->save();
                                                }
                                        }
                                        
                                        
                                        
                                        
                                         Yii::app()->user->setFlash('success', "Data Ruangan Dan Jenis Kasus Penyakit Berhasil Disimpan");
                                         $transaction->commit();
                                         $this->redirect(array('admin'));
                                }   
                            catch (Exception $e)
                                {
                                    $transaction->rollback();
                                    Yii::app()->user->setFlash('error', "Data Ruangan Dan Jenis Kasus Penyakit Gagal Disimpan");
                                }   
			
		}

		$this->render('update',array(
			'model'=>$model,
                        'modKasusPenyakitRuangan'=>$modKasusPenyakitRuangan,
                        'modKelasRuangan'=>$modKelasRuangan,
                        'modTindakanRuangan'=>$modTindakanRuangan,
                        'modRuanganPegawai'=>$modRuanganPegawai,
                        'modRiwayatRuangan'=>$modRiwayatRuangan
		));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('SARuanganM');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new SARuanganM('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['SARuanganM']))
			$model->attributes=$_GET['SARuanganM'];

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
		if(isset($_POST['ajax']) && $_POST['ajax']==='saruangan-m-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
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
                       $update = SARuanganM::model()->updateByPk($id,array('ruangan_aktif'=>false));
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
            $model= new SARuanganM();
            $model->attributes=$_REQUEST['SARuanganM'];
            $judulLaporan='Laporan Ruangan';
            $caraPrint=$_REQUEST['caraPrint'];
            if($caraPrint=='PRINT') {
                $this->layout='//layouts/printWindows';
                $this->render('Print',array('model'=>$model,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint));
            }
            else if($caraPrint=='EXCEL') {
                Yii::app()->bootstrap->coreCss = false;
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
		
		public function actionGetRiwayatRuangan() {
			if(Yii::app()->request->isAjaxRequest) {
		   $instalasi_id=$_POST['instalasi_id'];
		   $sql="SELECT 
				 riwayatruangan_r.tglpenetapanruangan, 
				 riwayatruangan_r.nopenetapanruangan, 
				 riwayatruangan_r.tentangpenetapan, 
				 instalasi_m.instalasi_id, 
				 instalasi_m.instalasi_nama
			   FROM 
				 public.instalasi_m, 
				 public.riwayatruangan_r
			   WHERE 
				 instalasi_m.riwayatruangan_id = riwayatruangan_r.riwayatruangan_id
				 AND instalasi_m.instalasi_id=".$instalasi_id."";
		   $riwayatRuangan=Yii::app()->db->createCommand($sql)->query();
		   foreach($riwayatRuangan AS $tampil):
			   $data['tglpenetapanruangan']=$tampil['tglpenetapanruangan'];
			   $data['nopenetapanruangan']=$tampil['nopenetapanruangan'];
			   $data['tentangpenetapan']=$tampil['tentangpenetapan'];

		   endforeach;

		   echo json_encode($data);
			Yii::app()->end();
		   }
	   }
}
