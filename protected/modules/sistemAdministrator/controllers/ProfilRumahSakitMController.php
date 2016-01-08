<?php

class ProfilRumahSakitMController extends MyAuthController
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
                $modMisiRS=SAMisirsM::model()->findAllByAttributes(array('profilrs_id'=>$id));
		$this->render('view',array(
			'model'=>$this->loadModel($id),'modMisiRS'=>$modMisiRS
		));
	}
        
        /**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionPrintRS($id)
	{
                                                                             
                     $modMisiRS=SAMisirsM::model()->findAllByAttributes(array('profilrs_id'=>$id));
                     $judulLaporan='';
                     $caraPrint=$_REQUEST['caraPrint'];
                        if($caraPrint=='PRINT')
                            {
                                $this->layout='//layouts/printWindows';
                                $this->render('view',array(
                                                        'model'=>$this->loadModel($id),'modMisiRS'=>$modMisiRS
                                ));         
                            }
                        else if($caraPrint=='EXCEL')    
                            {
                                $this->layout='//layouts/printExcel';
                                $this->render('PrintRS',array(
                                              'model'=>$this->loadModel($id),'modMisiRS'=>$modMisiRS
                                ));                             
                            }
                        else if($_REQUEST['caraPrint']=='PDF')
                            {

                                $ukuranKertasPDF=Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
                                $posisi=Yii::app()->user->getState('posisi_kertas');                            //Posisi L->Landscape,P->Portait
                                $mpdf=new MyPDF('',$ukuranKertasPDF); 
                                $mpdf->useOddEven = 2;  
                                $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/protected/extensions');
                                $mpdf->WriteHTML($stylesheet,1);  
                                $mpdf->AddPage($posisi,'','','','',15,15,15,15,15,15);
                                $mpdf->WriteHTML($this->render('PrintRS',array(
                                              'model'=>$this->loadModel($id),'modMisiRS'=>$modMisiRS)),true);
                                $mpdf->Output();
                            } 
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
                //if(!Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}                                             
		$model=new SAProfilRumahSakitM;
                $modMisiRS = new SAMisirsM;
                $modProfilPict = new SAProfilpictureM;
                
                
		// Uncomment the following line if AJAX validation is needed
		

		if(isset($_POST['SAProfilRumahSakitM']))
		{
                      $transaction = Yii::app()->db->beginTransaction();
                      $model=new SAProfilRumahSakitM;
                      $model->attributes=$_POST['SAProfilRumahSakitM'];
                      if ($model->validate()) {
                        try {
                            $random = rand(0000000, 9999999);
                            $model->logo_rumahsakit = CUploadedFile::getInstance($model, 'logo_rumahsakit');
                            $gambar = $model->logo_rumahsakit;
                            if (!empty($model->logo_rumahsakit)) {//Klo User Memasukan Logo
                                $model->path_logorumahsakit = $random . $model->logo_rumahsakit;
                                //                   $model->path_logorumahsakit =Params::pathProfilRSDirectory().$random.$model->logo_rumahsakit;
                                $model->logo_rumahsakit = $random . $model->logo_rumahsakit;

                                Yii::import("ext.EPhpThumb.EPhpThumb");

                                $thumb = new EPhpThumb();
                                $thumb->init(); //this is needed

                                $fullImgName = $model->logo_rumahsakit;
                                $fullImgSource = Params::pathProfilRSDirectory() . $fullImgName;
                                $fullThumbSource = Params::pathProfilRSTumbsDirectory() . 'kecil_' . $fullImgName;

                                $model->logo_rumahsakit = $fullImgName;

                                if ($model->save()) {
                                    Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
                                    $gambar->saveAs($fullImgSource);
                                    $thumb->create($fullImgSource)
                                            ->resize(200, 200)
                                            ->save($fullThumbSource);
                                } else {
                                    Yii::app()->user->setFlash('error', 'Logo <strong>Gagal!</strong>  disimpan.');
                                }
                            } else { //Klo User Tidak Memasukan Logo
                                $model->save();
                            }


                            if (isset($_POST['SAMisirsM'])) {  //Jika Misi Diisi
                                $valid = true;
                                foreach ($_POST['SAMisirsM'] as $i => $item) {
                                    if (is_integer($i)) {
                                        $modMisiRS = new SAMisirsM;
                                        if (isset($_POST['SAMisirsM'][$i]))
                                            $modMisiRS->attributes = $_POST['SAMisirsM'][$i];
                                        $modMisiRS->profilrs_id = $model->profilrs_id;
                                        $modMisiRS->misi = $_POST['SAMisirsM'][$i]['misi'];
                                        $valid = $modMisiRS->validate();
                                        
                                        if ($valid) {
                                            $modMisiRS->save();
                                        }
                                    }
                                }
                            }
                            
                            if(isset($_POST['SAProfilpictureM']))
                            {
                                Yii::import("ext.EPhpThumb.EPhpThumb");
                                
                                foreach ($_POST['SAProfilpictureM'] as $i=>$item){
                                    $tempProfil = true;
                                    $thumb = new EPhpThumb();
                                    $thumb->init(); //this is needed
                                    
                                    $modProfil = new SAProfilpictureM();  
                                                                        
                                    $modProfil->attributes=$_POST['SAProfilpictureM'][$i];

                                    $modProfil->profilpicture_path = CUploadedFile::getInstance($modProfil, '['.$i.']profilpicture_path'); 
                                    if (empty($modProfil->profilpicture_path)){
                                        $modProfil->profilpicture_path = '1';
                                        $tempProfil =false;
                                    }
                                    $rand = rand(0000000,9999999);
                                    $fullImgName =$rand.$modProfil->profilpicture_path;   
                                                                        
                                    $modProfil->profilrs_id = $model->profilrs_id;
                                    $modProfil->profilpicture_tgl = date('Y-m-d');
                                    $gambar = $modProfil->profilpicture_path;
                                    $modProfil->profilpicture_path = $fullImgName;
                                    
                                    if($modProfil->save()){    
                                         if (!empty($gambar)){
                                             if ($tempProfil == true){
                                                $fullImgSource = Params::pathAntrianSliderGambar().$fullImgName;
                                                $fullThumbSource = Params::pathAntrianSliderGambarThumbs().'kecil_' . $fullImgName;
                                                $gambar->saveAs($fullImgSource);
                                                $thumb->create($fullImgSource)
                                                      ->resize(200, 200)
                                                      ->save($fullThumbSource);
                                             }
                                         }
                                    }
                                }
                            }
                            $transaction->commit();
                            Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
                            $this->redirect(array('admin'));
                        } catch (Exception $e) {
                            $transaction->rollback();
                            Yii::app()->user->setFlash('error', '<strong>Gagal!</strong> Data gagal disimpan.');
                        }
                    }
                                
		}
		$this->render('create',array(
			'model'=>$model,'modMisiRS'=>$modMisiRS, 'modProfilPict'=>$modProfilPict
		));
	}
	
	public function actionGallery()
    {
        $this->layout = '//layouts/iframe';
        $model = new SAProfilpictureM();
        
        $this->render('gallery',array('model'=>$model));
    }

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id = Params::DEFAULT_PROFIL_RUMAH_SAKIT)
	{
                //if(!Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}                                                        
                $model=$this->loadModel($id);
                $modMisiRS=SAMisirsM::model()->findAllByAttributes(array('profilrs_id'=>$id));
                $modProfilPict = SAProfilpictureM::model()->findAllByAttributes(array("profilrs_id"=>$id), array('order'=>'profilpicture_tgl'));
                $temLogo = $model->logo_rumahsakit;

		// Uncomment the following line if AJAX validation is needed
		

		if(isset($_POST['SAProfilRumahSakitM']))
		{
                    $transaction = Yii::app()->db->beginTransaction();
                      $model=$this->loadModel($id);
                      $model->attributes=$_POST['SAProfilRumahSakitM'];
                      $model->tglregistrasi= !empty($_POST['SAProfilRumahSakitM']['tglregistrasi'])?MyFormatter::formatDateTimeForDb($_POST['SAProfilRumahSakitM']['tglregistrasi']):null;
					  $model->notelphumas=$_POST['SAProfilRumahSakitM']['notelphumas'];
					  $model->luastanah=$_POST['SAProfilRumahSakitM']['luastanah'];
					  $model->luasbangunan=$_POST['SAProfilRumahSakitM']['luasbangunan'];
					  $model->tglakreditasi= !empty($_POST['SAProfilRumahSakitM']['tglakreditasi'])?MyFormatter::formatDateTimeForDb($_POST['SAProfilRumahSakitM']['tglakreditasi']):null;
					  
					  $hapusMisiRS = SAMisirsM::model()->deleteAll('profilrs_id=' . $id . '');
					  if (isset($_POST['SAMisirsM'])) {  //Jika Misi Diisi
							$valid = true;
							foreach ($_POST['SAMisirsM'] as $i => $item) {
								if (is_integer($i)) {
									$modMisiRS = new SAMisirsM;
									if (isset($_POST['SAMisirsM'][$i]))
										$modMisiRS->attributes = $_POST['SAMisirsM'][$i];
									$modMisiRS->profilrs_id = $model->profilrs_id;
									$modMisiRS->misi = $_POST['SAMisirsM'][$i]['misi'];

									$valid = $modMisiRS->validate() && $valid;

									if ($valid) {
										$modMisiRS->save();
									}
								}
							}
						}
						
                      if ($model->validate()) {
                        try {
                            
                            $random = rand(0000000, 9999999);
                            $model->logo_rumahsakit = CUploadedFile::getInstance($model, 'logo_rumahsakit');
                            $gambar = $model->logo_rumahsakit;
							
							if (isset($model->logo_rumahsakit) && ($model->logo_rumahsakit != $temLogo)) {
                                $model->path_logorumahsakit = $random . $model->logo_rumahsakit;
                                $model->logo_rumahsakit = $random . $model->logo_rumahsakit;

                                Yii::import("ext.EPhpThumb.EPhpThumb");

                                $thumb = new EPhpThumb();
                                $thumb->init(); //this is needed

                                $fullImgName = $model->logo_rumahsakit;
                                $fullImgSource = Params::pathProfilRSDirectory().$fullImgName;
                                $fullThumbSource = Params::pathProfilRSTumbsDirectory() . 'kecil_' . $fullImgName;

								if(!isset($model->logo_rumahsakit)){
									$model->logo_rumahsakit = $temLogo;
								}else {
									$model->logo_rumahsakit = $fullImgName;
								}
								
                                if ($model->save()) {
                                    if (!empty($temLogo)) {
//                                        unlink(Params::pathProfilRSDirectory().$temLogo);
//                                        unlink(Params::pathProfilRSTumbsDirectory().'kecil_'.$temLogo);
                                    }
                                    $gambar->saveAs($fullImgSource);
                                    $thumb->create($fullImgSource)
                                            ->resize(200, 200)
                                            ->save($fullThumbSource);
                                }
                            } else {		
								$model->logo_rumahsakit = $temLogo;
                                $model->save();
                                
                            }
                            
                            if(isset($_POST['SAProfilpictureM']))
                            {
                                Yii::import("ext.EPhpThumb.EPhpThumb");

                                SAProfilpictureM::model()->deleteAllByAttributes(array('profilrs_id'=>$model->profilrs_id));
                                foreach ($_POST['SAProfilpictureM'] as $i=>$item){
                                    $tempProfil = '';
                                    $dataGambar = true;
                                    $thumb = new EPhpThumb();
                                    $thumb->init(); //this is needed
                                    
                                    $modProfil = new SAProfilpictureM();  
                                    $modProfil->attributes=$_POST['SAProfilpictureM'][$i];
                                    
                                    if (!empty($_POST['SAProfilpictureM'][$i]['profilpicture_id'])){
                                        $tempProfil = $_POST['SAProfilpictureM'][$i]['temp_gambar'];
                                        $modProfil->profilpicture_id = $_POST['SAProfilpictureM'][$i]['profilpicture_id'];
                                    }
//                                     echo 'a'.$_POST['SAProfilpictureM'][$i]['temp_gambar'].$modProfil->temp_gambar;
                                    $modProfil->profilpicture_path = CUploadedFile::getInstance($modProfil, '['.$i.']profilpicture_path'); 
                                    if (empty($modProfil->profilpicture_path)){
                                        $dataGambar = false;
                                    }
                                    $rand = rand(0000000,9999999);
                                    $fullImgName =$rand.$modProfil->profilpicture_path;   
                                    
                                    if (empty($modProfil->profilpicture_path)){
                                        if(empty($tempProfil)){
                                            $tempProfil = '1';
                                        }
                                        $modProfil->profilpicture_path = $tempProfil;
                                        $fullImgName = $tempProfil;
                                    }
                                    
                                    $modProfil->profilrs_id = $model->profilrs_id;
                                    $gambar = $modProfil->profilpicture_path;
                                    $modProfil->profilpicture_tgl = date('Y-m-d H:i:s');
                                    $modProfil->profilpicture_path = $fullImgName;
                                    
                                    if($modProfil->save()){    
                                         if (!empty($gambar)){
                                             if (!empty($tempProfil)){
                                                 if ($dataGambar == true){
                                                     if (file_exists(Params::pathAntrianSliderGambar().$tempProfil)){
                                                        unlink(Params::pathAntrianSliderGambar() . $tempProfil);
                                                     }
                                                     if (file_exists(Params::pathAntrianSliderGambarThumbs().'kecil_'.$tempProfil)){
                                                        unlink(Params::pathAntrianSliderGambarThumbs(). 'kecil_' . $tempProfil);
                                                     }
                                                 }
                                             }
                                             if ($fullImgName != $tempProfil){
                                                $fullImgSource = Params::pathAntrianSliderGambar().$fullImgName;
                                                $fullThumbSource = Params::pathAntrianSliderGambarThumbs().'kecil_' . $fullImgName;
                                                $gambar->saveAs($fullImgSource);
                                                $thumb->create($fullImgSource)
                                                      ->resize(200, 200)
                                                      ->save($fullThumbSource);
                                             }
                                         }
                                    }
                                }
                            }

                            $transaction->commit();
                            Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
                            $this->redirect(array('update','sukses'=>1));
                        } catch (Exception $e) {
                            $transaction->rollback();
                            Yii::app()->user->setFlash('error', '<strong>Gagal!</strong> Data gagal disimpan.');
                        }
                    }
		}

		$this->render('update',array(
			'model'=>$model,'modMisiRS'=>$modMisiRS, 'modProfilPict'=>$modProfilPict,
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
			 $transaction = Yii::app()->db->beginTransaction();
                         try {
                                $hapusMisiRS = SAMisirsM::model()->deleteAll('profilrs_id='.$id.'');
                                $hapusMisiRS = SAProfilpictureM::model()->deleteAll('profilrs_id='.$id.'');
                                $model = $this->loadModel($id)->delete();
                                $temLogo = $model->logo_rumahsakit;
                             
                                 if(!empty($temLogo))
                                        { 
                                           unlink(Params::urlProfilRSDirectory().$temLogo);
                                           unlink(Params::urlProfilRSDirectory().$temLogo);
                                        }
                                      
                                $transaction->commit();
                                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
                                
                                       
                            } 
                        catch (Exception $e)
                            {
                                $transaction->rollback();
                                echo 'error'.$e->getMessage();
                                
                            }   

		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('SAProfilRumahSakitM');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
                                                     
		$model=new SAProfilRumahSakitM('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['SAProfilRumahSakitM']))
			$model->attributes=$_GET['SAProfilRumahSakitM'];

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
		$model=SAProfilRumahSakitM::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='saprofil-rumah-sakit-m-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
        
         public function actionPrint()
         {
                                                                           
             $model= new SAProfilRumahSakitM;
             $model->attributes=$_REQUEST['SAProfilRumahSakitM'];
             $judulLaporan='';
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
         * Mengatur dropdown kabupaten
         * @param type $encode jika = true maka return array jika false maka set Dropdown 
         * @param type $model_nama
         * @param type $attr
         */
        public function actionSetDropdownKabupaten($encode=false,$model_nama='',$attr='')
        {
            if(Yii::app()->request->isAjaxRequest) {
                $model = new SAProfilRumahSakitM;
                if($model_nama !=='' && $attr == ''){
                    $propinsi_id = $_POST["$model_nama"]['propinsi_id'];
                }
                 elseif ($model_nama == '' && $attr !== '') {
                    $propinsi_id = $_POST["$attr"];
                }
                 elseif ($model_nama !== '' && $attr !== '') {
                    $propinsi_id = $_POST["$model_nama"]["$attr"];
                }
                $kabupaten = null;
                if($propinsi_id){
                    $kabupaten = $model->getKabupatenItems($propinsi_id);
                    $kabupaten = CHtml::listData($kabupaten,'kabupaten_id','kabupaten_nama');
                }
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
		
        /**
         * Mengatur dropdown kecamatan
         * @param type $encode jika = true maka return array jika false maka set Dropdown 
         * @param type $model_nama
         * @param type $attr
         */
        public function actionSetDropdownKecamatan($encode=false,$model_nama='',$attr='')
        {
            if(Yii::app()->request->isAjaxRequest) {
                $model = new SAProfilRumahSakitM;
                if($model_nama !=='' && $attr == ''){
                    $kabupaten_id = $_POST["$model_nama"]['kabupaten_id'];
                }
                 elseif ($model_nama == '' && $attr !== '') {
                    $kabupaten_id = $_POST["$attr"];
                }
                 elseif ($model_nama !== '' && $attr !== '') {
                    $kabupaten_id = $_POST["$model_nama"]["$attr"];
                }
                $kecamatan = null;
                if($kabupaten_id){
                    $kecamatan = $model->getKecamatanItems($kabupaten_id);
                    $kecamatan = CHtml::listData($kecamatan,'kecamatan_id','kecamatan_nama');
                }

                if($encode){
                    echo CJSON::encode($kecamatan);
                } else {
                    if(empty($kecamatan)){
                        echo CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
                    }else{
                        echo CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
                        foreach($kecamatan as $value=>$name)
                        {
                            echo CHtml::tag('option', array('value'=>$value),CHtml::encode($name),true);
                        }
                    }
                }
            }
            Yii::app()->end();
        }
		
		
		
        /**
         * Mengatur dropdown kelurahan
         * @param type $encode jika = true maka return array jika false maka set Dropdown 
         * @param type $model_nama
         * @param type $attr
         */
        public function actionSetDropdownKelurahan($encode=false,$model_nama='',$attr='')
        {
            if(Yii::app()->request->isAjaxRequest) {
                $model = new SAProfilRumahSakitM;
                if($model_nama !=='' && $attr == ''){
                    $kecamatan_id = $_POST["$model_nama"]['kecamatan_id'];
                }
                 elseif ($model_nama == '' && $attr !== '') {
                    $kecamatan_id = $_POST["$attr"];
                }
                elseif ($model_nama !== '' && $attr !== '') {
                    $kecamatan_id = $_POST["$model_nama"]["$attr"];
                }
                $kelurahan = null;
                if($kecamatan_id){
                    $kelurahan = $model->getKelurahanItems($kecamatan_id);
//                    $kelurahan = KelurahanM::model()->findAll('kecamatan_id='.$kecamatan_id.'');
                    $kelurahan = CHtml::listData($kelurahan,'kelurahan_id','kelurahan_nama');
                }

                if($encode){
                    echo CJSON::encode($kelurahan);
                } else {
                    if(empty($kelurahan)){
                        echo CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
                    }else{
                        echo CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
                        foreach($kelurahan as $value=>$name)
                        {
                            echo CHtml::tag('option', array('value'=>$value),CHtml::encode($name),true);
                        }
                    }
                }
            }
            Yii::app()->end();
        }
		
		
		public function actionSetKodeJenisRs()
        {
            if(Yii::app()->getRequest()->getIsAjaxRequest()) {
                $modLookup = SALookupM::model()->findByAttributes(array('lookup_type'=>'jenisrs_profilrs','lookup_value'=>$_POST['jenisrs']));
				if(!empty($modLookup->lookup_kode)){
					$res = $modLookup->lookup_kode;
				}else{
					$res = ' - ';
				}
                echo json_encode($res);
                Yii::app()->end();
            }
        }
		
		public function actionSetKodePemilikRs()
        {
            if(Yii::app()->getRequest()->getIsAjaxRequest()) {
                $modLookup = SALookupM::model()->findByAttributes(array('lookup_type'=>'namakepemilikanrs','lookup_value'=>$_POST['pemilikrs']));
				if(!empty($modLookup->lookup_kode)){
					$res = $modLookup->lookup_kode;
				}else{
					$res = ' - ';
				}
                echo json_encode($res);
                Yii::app()->end();
            }
        }
		
		public function actionSetKodeStatusSwasta()
        {
            if(Yii::app()->getRequest()->getIsAjaxRequest()) {
                $modLookup = SALookupM::model()->findByAttributes(array('lookup_type'=>'statusrsswasta','lookup_value'=>$_POST['statusswasta']));
				if(!empty($modLookup->lookup_kode)){
					$res = $modLookup->lookup_kode;
				}else{
					$res = ' - ';
				}
                echo json_encode($res);
                Yii::app()->end();
            }
        }
		
		public function actionAutocompleteNamaDirektur()
		{
			if(Yii::app()->request->isAjaxRequest) {
				$format = new MyFormatter();
				$returnVal = array();
				$nama_pegawai = isset($_GET['nama_pegawai']) ? $_GET['nama_pegawai'] : null;
				
				$criteria = new CDbCriteria();
				$criteria->compare('LOWER(nama_pegawai)', strtolower($nama_pegawai), true);
				$criteria->addCondition('pegawai_aktif = TRUE');
				$criteria->order = 'nama_pegawai';
				$criteria->limit = 10;
				$models = PegawaiM::model()->findAll($criteria);
				if(count($models)>0){
					foreach($models as $i=>$model)
					{
						$attributes = $model->attributeNames();
						foreach($attributes as $j=>$attribute) {
							$returnVal[$i]["$attribute"] = $model->$attribute;
						}
						$returnVal[$i]['label'] = $model->nama_pegawai.' - '.$model->nomorindukpegawai;
						$returnVal[$i]['value'] = $model->nama_pegawai;
					}
				}else{
					$returnVal = null;
				}
				
				
				echo CJSON::encode($returnVal);
			}else
				throw new CHttpException(403,'Tidak dapat mengurai data');
			Yii::app()->end();
		}
		
		public function actionsetDropdownKelasRS()
        {
            if(Yii::app()->getRequest()->getIsAjaxRequest()) {
                $option = '';
                if(!empty($_POST['pemilik'])){
					$criteria = new CDbCriteria();
					$criteria->addCondition("lookup_type = 'kelas_rumahsakit'");
					$criteria->addCondition("lookup_value = "."'$_POST[pemilik]'");
					$criteria->order = "lookup_urutan";
					$criteria->addCondition("lookup_aktif IS TRUE");
					$data = LookupM::model()->findAll($criteria);
                    $data = CHtml::listData($data,'lookup_name','lookup_name');
                    foreach($data as $value=>$name){
						$option .= CHtml::tag('option',array('value'=>$value),CHtml::encode($name),true);
                    }
                }
                $dataList['listKelas'] = $option;
                echo json_encode($dataList);
                Yii::app()->end();
            }
        }
		
}
