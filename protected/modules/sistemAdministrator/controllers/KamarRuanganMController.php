
<?php

class KamarRuanganMController extends MyAuthController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column1';
	public $defaultAction = 'admin';
        
	public function actionDynamicRuangan()
        {
            if(!empty($_POST['PasienM']['propinsi_id'])){$propinsi = $_POST['PasienM']['propinsi_id'];}else{$propinsi =  $_POST['PendaftaranadmisiV']['propinsi_id'];}
            if(isset($_POST['propinsi_nama']))
            {
                $data=KabupatenM::model()->findAll('propinsi_id=:prop_id ORDER BY kabupaten_nama', 
                      array(':prop_id'=>(int) $_POST['KecamatanM']['propinsi_id'],));
            } else {
                $data=KabupatenM::model()->findAll('propinsi_id=:prop_id ORDER BY kabupaten_nama', 
                      array(':prop_id'=>(int) $propinsi,));
            }
            
            $data=CHtml::listData($data,'kabupaten_id','kabupaten_nama');
            
            if(empty($data)){
                echo CHtml::tag('option',array('value'=>''),CHtml::encode('-Pilih-'),true);
            }else{
                echo CHtml::tag('option',array('value'=>''),CHtml::encode('-Pilih-'),true);
                foreach($data as $value=>$name)
                {
                    echo CHtml::tag('option',array('value'=>$value),CHtml::encode($name),true);
                }
            }
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
		$model=new SAKamarRuanganM;
                $modRiwayatRuanganR = new SARiwayatRuanganR;
                $modRiwayatRuanganR->tglpenetapanruangan=date('Y-m-d');
		// Uncomment the following line if AJAX validation is needed
		

		if(isset($_POST['SAKamarRuanganM']))
		{
                    
                     
                      $transaction=Yii::app()->db->beginTransaction();
                      try
                        {
                            $photo = CUploadedFile::getInstance($model, 'kamarruangan_image'); 
                            $random=rand(000000,999999);
                            $gambar=$photo;
                            if(!empty($photo))//Klo User Memasukan Logo
                              {        

                                     Yii::import("ext.EPhpThumb.EPhpThumb");
                                     $thumb=new EPhpThumb();
                                     $thumb->init(); //this is needed
                                     $fullImgName = $random.$photo;
                                    echo $photo;exit;
                                     $fullImgSource = Params::pathKamarRuanganDirectory().$fullImgName;
                                     $fullThumbSource = Params::pathKamarRuanganTumbsDirectory().'kecil_'.$fullImgName;
                                        
                                     
                                      $gambar->saveAs($fullImgSource);
                                      $thumb->create($fullImgSource)
                                            ->resize(200,200)
                                            ->save($fullThumbSource);
                                }
                       for($i=0; $i<count($_POST['SAKamarRuanganM']['kamarruangan_nobed']); $i++)
                           {
                               
                                    
                                    
                               $model=new SAKamarRuanganM;
                               $modRiwayatRuanganR = new SARiwayatRuanganR; 
                               
                               $modRiwayatRuanganR->attributes=$_POST['SARiwayatRuanganR'];
                               $modRiwayatRuanganR->save();
                               $model->attributes=$_POST['SAKamarRuanganM'];
                               if(!empty($photo)){
                               		$model->kamarruangan_image = $fullImgName;
                               }
                               $model->kamarruangan_nobed=$_POST['SAKamarRuanganM']['kamarruangan_nobed'][$i];
                               $model->riwayatruangan_id=$modRiwayatRuanganR->riwayatruangan_id;
                               $model->kamarruangan_aktif=TRUE;
//                               $model->kamarruangan_status=FALSE;
                               //modifi 20 Feb 2013 //
                               $model->kamarruangan_status = TRUE;
                               // end modifi //
                               $model->save();

                           }
                               $transaction->commit();   

                               Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
  			       $this->redirect(array('admin'));

                        }
                        catch (Exception $exc)
                        {
                            $transaction->rollback();                                      
                            Yii::app()->user->setFlash('error',"Data gagal disimpan ".MyExceptionMessage::getMessage($exc,true));
                        }
			
			
		}

		$this->render('create',array(
			'model'=>$model,'modRiwayatRuanganR'=>$modRiwayatRuanganR
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

		// Uncomment the following line if AJAX validation is needed
		
                $model->kamarTerpakai = ($model->kamarruangan_status == true) ? false : true;
                
		if(isset($_POST['SAKamarRuanganM']))
		{
			$model->attributes=$_POST['SAKamarRuanganM'];
			$model->kamarruangan_status=($_POST['SAKamarRuanganM']['kamarTerpakai'] == true) ? false : true; //status dibalik
                        
                        //DIINPUT DARI FORM >>> $model->kamarruangan_status = TRUE;
			if($model->save()){
                                Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
				$this->redirect(array('admin','id'=>$model->kamarruangan_id));
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
		$dataProvider=new CActiveDataProvider('SAKamarRuanganM');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
                
		$model=new SAKamarRuanganM('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['SAKamarRuanganM']))
			$model->attributes=$_GET['SAKamarRuanganM'];

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
		$model=SAKamarRuanganM::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='sakamar-ruangan-m-form')
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
                       $update = SAKamarRuanganM::model()->updateByPk($id,array('kamarruangan_aktif'=>false));
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
            
            $model= new SAKamarRuanganM;
            $model->attributes=$_REQUEST['SAKamarRuanganM'];
            $judulLaporan='Data Kamar Ruangan';
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
                $mpdf->Output();
            }                       
        }
}
