<?php
class PegawaiMController extends MyAuthController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column1';
        public $defaultAction = 'admin';
//		public $path_view = 'kepegawaian.views.pencatatanRiwayat.';
        
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
        
	public function actionViewUser($id='')
	{
		$loginpemakai = Yii::app()->user->id;
		$criteria = new CDbCriteria;
		$criteria->compare('loginpemakai_id',$loginpemakai);
		$pegawai = LoginpemakaiK::model()->find($criteria);
//                                    echo $pegawai->pegawai_id;
		if(empty($id))
			$id = $pegawai->pegawai_id;
                                    
		$this->render('viewUser',array(
			'model'=>$this->loadModel($id),
		));
	}
        
	public function actionProfilKlinik()
	{
		$loginpemakai_id = Yii::app()->user->id;
		$criteria = new CDbCriteria;
		$criteria->compare('loginpemakai_id',$loginpemakai_id);
		$pegawai = LoginpemakaiK::model()->find($criteria);
		if(empty($idPegawai))
			$idPegawai = $pegawai->pegawai_id;
                                    
		$this->render('kepegawaian.views.pegawaiM._viewprofilKlinik',array(
			'model'=>$this->loadModel($idPegawai),
		));
	}    

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
        
	public function actionCreate()
	{
                //if(!Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
		$model=new KPPegawaiM;
		$modRuanganPegawai = new RuanganpegawaiM;
		// Uncomment the following line if AJAX validation is needed
		

		if(isset($_POST['KPPegawaiM']))
		{
			$model->attributes=$_POST['KPPegawaiM'];
			$model->profilrs_id=1;
				if($_POST['caraAmbilPhoto']=='file')//Jika User Mengambil photo pegawai dengan cara upload file
				{ 

					$model->pegawai_aktif=true;
				 //   $model->profilrs_id=Params::DEFAULT_PROFIL_RUMAH_SAKIT;
					$model->photopegawai = CUploadedFile::getInstance($model, 'photopegawai');
					$gambar = $model->photopegawai;
					$random = $model->nomorindukpegawai.'.'.$model->photopegawai->getExtensionName();                                        

					if(!empty($model->photopegawai))//Klo User Memasukan Logo
					{ 

						  $model->photopegawai =$random;//.$model->photopegawai

						  Yii::import("ext.EPhpThumb.EPhpThumb");

						   $thumb=new EPhpThumb();
						   $thumb->init(); //this is needed

						   $fullImgName =$model->photopegawai;   
						   $fullImgSource = Params::pathPegawaiDirectory().$fullImgName;
						   $fullThumbSource = Params::pathPegawaiTumbsDirectory().'kecil_'.$fullImgName;

					  }
				}   

				if ($model->validate()){
				  if ($model->save()){
					  if (!empty($model->photopegawai)){
							$gambar->saveAs($fullImgSource);

							 $thumb->create($fullImgSource)
								   ->resize(200,200)
								   ->save($fullThumbSource);

					  }

					  if ($model->validate()){
						  if($model->save()){
							  $jumlahRuanganPegawai=COUNT($_POST['ruangan_id']);
							  $pegawai_id=$model->pegawai_id;
   //                            $hapusRuanganPegawai =  RuanganpegawaiM::model()->deleteAll('pegawai_id='.$pegawai_id.'');
							  for($i=0; $i<=$jumlahRuanganPegawai; $i++)
								  {
									  $modRuanganPegawai = new RuanganpegawaiM;
									  $modRuanganPegawai->ruangan_id=$_POST['ruangan_id'][$i];
									  $modRuanganPegawai->pegawai_id=$pegawai_id;
									  $modRuanganPegawai->save();

								  }
								  Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
								  $this->redirect(array('admin','id'=>$model->pegawai_id));
						  }
					  }
				   }
			   } 
		}

		$this->render('create',array(
			'model'=>$model,'modRuanganPegawai'=>$modRuanganPegawai
		));
	}
  
        
	public function actionPencatatanpegawai($pegawai_id = null)
	{
            $format = new MyFormatter();
        $model = new KPPegawaiM;
        $modRuanganPegawai = new RuanganpegawaiM;
        $model->isNewRecord = TRUE;
		
		if(!empty($pegawai_id)){
			$model = KPPegawaiM::model()->findByPk($pegawai_id);
                    
                        $cekPegawaiR = RuanganpegawaiM::model()->findAll('pegawai_id='.$pegawai_id.'');
                        if (isset($cekPegawaiR)):
                            $modRuanganPegawai= $cekPegawaiR;
                        endif;
		}
                
                
        if(isset($_POST['KPPegawaiM'])){			
			$transaction = Yii::app()->db->beginTransaction();
			try {
					  $model=new KPPegawaiM;					  
					  $model->attributes=$_POST['KPPegawaiM'];
                                          $random = $model->nomorindukpegawai;
					  $model->profilrs_id=Params::DEFAULT_PROFIL_RUMAH_SAKIT;
					  $model->tgl_lahirpegawai = $format->formatDateTimeForDb($_POST['KPPegawaiM']['tgl_lahirpegawai']);
					  if (isset($model->tglditerima)){
					  $model->tglditerima = $format->formatDateTimeForDb($_POST['KPPegawaiM']['tglditerima']);
					  }else{
						  $model->tglditerima = date('Y-m-d') ;
					  }
					  $model->tglmasaaktifpeg=$format->formatDateTimeForDb($_POST['KPPegawaiM']['tglmasaaktifpeg']);
					  $model->tglmasaaktifpeg_sd=$format->formatDateTimeForDb($_POST['KPPegawaiM']['tglmasaaktifpeg_sd']);
					  $model->create_time = date('Y-m-d');
					  $model->create_loginpemakai_id = Yii::app()->user->id;
					  $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
					  $model->gajipokok = 0;
					  
//					  echo "<pre>";
//					  print_r($model->attributes);exit;
					  if($_POST['caraAmbilPhoto']=='file')//Jika User Mengambil photo pegawai dengan cara upload file
					  { 
						  $model->pegawai_aktif=true;
						  $model->photopegawai = CUploadedFile::getInstance($model, 'photopegawai');
						  $gambar=$model->photopegawai;
						  if(!empty($model->photopegawai))//Klo User Memasukan Logo
						  { 

								$model->photopegawai =$random.'.'.$model->photopegawai->getExtensionName();//.$model->photopegawai

								Yii::import("ext.EPhpThumb.EPhpThumb");

								 $thumb=new EPhpThumb();
								 $thumb->init(); //this is needed

								 $fullImgName =$model->photopegawai;   
								 $fullImgSource = Params::pathPegawaiDirectory().$fullImgName;
								 $fullThumbSource = Params::pathPegawaiTumbsDirectory().'kecil_'.$fullImgName;
								 $model->save();
								$gambar->saveAs($fullImgSource);
								$thumb->create($fullImgSource)
									  ->resize(200,200)
									  ->save($fullThumbSource);

								$model->isNewRecord = FALSE;
						 }
					  }   
					 else 
					  {
						 $model->photopegawai=$_POST['KPPegawaiM']['tempPhoto'];
						 if($model->validate())
							{

								$model->save();                                                                
								$model->isNewRecord = FALSE;                                                               
							}
						 else 
							{
								 unlink(Params::pathPegawaiDirectory().$_POST['KPPegawaiM']['tempPhoto']);
								 unlink(Params::pathPegawaiTumbsDirectory().$_POST['KPPegawaiM']['tempPhoto']);
							}
					   }

					$gajipokok=$model->gajipokok;
					$gajipokok= 0;
					if (empty($gajipokok)){
					$model->gajipokok = $gajipokok;
					}

					$ruanganPegawai=isset ($_POST['ruangan_id']) ? $_POST['ruangan_id'] : null ;
                                        
					/*$pegawai_id=$model->pegawai_id;
                                        
					if($pegawai_id!=null){
					  $hapusRuanganPegawai=  RuanganpegawaiM::model()->deleteAll('pegawai_id='.$pegawai_id.''); 
					}
                                        
					if (isset($ruanganPegawai)){                                            
						foreach($ruanganPegawai as $i => $rp)
						{                                                    
							$modRuanganPegawai = new RuanganpegawaiM;
                                                        var_dump($pegawai_id);
							$modRuanganPegawai->ruangan_id=$rp[$i];
							$modRuanganPegawai->pegawai_id=$pegawai_id;
							$modRuanganPegawai->save();
						}
					}
                                        var_dump($ruanganPegawai);die;*/
					if (!empty($model->gelardepan)){
					$gelardepan = LookupM::model()->findByPk($model->gelardepan);
					$model->gelardepan = $gelardepan->lookup_name;
					}
					$model->jenistenagamedis_id = !empty($_POST['KPPegawaiM']['jenistenagamedis_id'])?$_POST['KPPegawaiM']['jenistenagamedis_id']:null;
					$model->garis_latitude = !empty($_POST['KPPegawaiM']['garis_latitude'])?$_POST['KPPegawaiM']['garis_latitude']:null;
					$model->garis_longitude = !empty($_POST['KPPegawaiM']['garis_longitude'])?$_POST['KPPegawaiM']['garis_longitude']:null;
					$model->tglmasaaktifpeg = !empty($_POST['KPPegawaiM']['tglmasaaktifpeg'])?MyFormatter::formatDateTimeForDb($_POST['KPPegawaiM']['tglmasaaktifpeg']):null;
					$model->tglmasaaktifpeg_sd = !empty($_POST['KPPegawaiM']['tglmasaaktifpeg_sd'])?MyFormatter::formatDateTimeForDb($_POST['KPPegawaiM']['tglmasaaktifpeg_sd']):null;
					if($model->save()){
                                           $pegawai_id=$model->pegawai_id;
                                        
                                            if($pegawai_id!=null){
                                              $hapusRuanganPegawai=  RuanganpegawaiM::model()->deleteAll('pegawai_id='.$pegawai_id.''); 
                                            }

                                            if (isset($ruanganPegawai)){                                            
                                                    /*foreach($ruanganPegawai as $i => $rp)
                                                    {                                                    
                                                            $modRuanganPegawai = new RuanganpegawaiM;
                                                       
                                                            $modRuanganPegawai->ruangan_id=$rp[$i];
                                                            $modRuanganPegawai->pegawai_id=$pegawai_id;
                                                            $modRuanganPegawai->save();
                                                    }*/
                                                    for($i=0; $i < count($ruanganPegawai); $i++)
                                                    {
                                                            $modRuanganPegawai = new RuanganpegawaiM;
                                                            $modRuanganPegawai->ruangan_id=$_POST['ruangan_id'][$i];
                                                            $modRuanganPegawai->pegawai_id=$pegawai_id;
                                                            $modRuanganPegawai->save();

                                                    }
                                            }
                                           
					  $transaction->commit();
					  $model->isNewRecord = FALSE;
					  Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
					  $this->redirect(array('Pencatatanpegawai','pegawai_id'=>$model->pegawai_id));
	//                                $modRuanganPegawai = new RuanganpegawaiM;
	//                                 $model=new KPPegawaiM;
					} else{
					  $transaction->rollback();
					  Yii::app()->user->setFlash('error',"<strong>Gagal!</strong> Data Gagal Disimpan.");
					}
			 }
			catch (Exception $e)
			 {
				  $transaction->rollback();
				  Yii::app()->user->setFlash('error',"Data pencatatan pegawai gagal disimpan ! ".MyExceptionMessage::getMessage($e,true));
			 }
              
    }

		$this->render('pencatatanpegawai',array(
			'model'=>$model, 'modRuanganPegawai'=>$modRuanganPegawai,'format'=>$format
		));
	}
        

// RND-4450
	//DIGANTIKAN DENGAN : kepegawaian/pencatatanRiwayat/index
/* ========================= Pencatatan riwayat ============================================== */        
//                  public function actionPencatatanriwayat($id = null){
//                     $modPendidikanpegawai = new KPPendidikanpegawaiR;
//                     $modPegawaidiklat = new KPPegawaidiklatT;
//                     $modPengalamankerja = new KPPengalamankerjaR;
//                     $modPegawaijabatan = new KPPegawaijabatanR;
//                     $modPegmutasi = new KPPegmutasiR;
//                     $modPegawaicuti = new KPPegawaicutiT;
//                     $modIzintugasbelajar = new KPIzintugasbelajarR;
//                     $modHukdisiplin = new KPHukdisiplinR;
//                     $detailPengalamankerja = array();
//                     $detailPegawaidiklat = array();
//                     $model = new KPPegawaiM;
                    
//                     if (!empty($id)) {
//                         $model = KPPegawaiM::model()->findByPk($id);
//                         $detailPegawaidiklat = KPPegawaidiklatT::model()->findAllByAttributes(
//                             array('pegawai_id'=>$id)
//                         );
//                         $detailPengalamankerja = KPPengalamankerjaR::model()->findAllByAttributes(
//                             array('pegawai_id'=>$id)
//                         );
//                     }
                    
//                     if (isset($_POST['KPPegawaiM'])) {
//                         $model->attributes = $_POST['KPPegawaiM'];
//                         $model->nama_pegawai = $_POST['namapegawai'];
//                         $model->pegawai_id = $_POST['KPPegawaiM']['pegawai_id'];
//                         $transaction = Yii::app()->db->beginTransaction();
// /* ========================= Proses simpan Pendidikan pegawai===================================== */
// //                    if (Yii::app()->request->isAjaxRequest) {
//                         if (isset($_POST['submitpendidikan'])) {
//                             $jmlhsavependidikan = 0;
//                             foreach ($_POST['KPPendidikanpegawaiR'] as $i=>$row)
//                             {
//                                 $modPendidikanpegawai = new KPPendidikanpegawaiR;
//                                 $modPendidikanpegawai->pegawai_id = $_POST['KPPegawaiM']['pegawai_id'];
//                                 $modPendidikanpegawai->attributes = $row;
//                                 if (empty($row['tglmasuk'])) {
//                                     $modPendidikanpegawai->tglmasuk = null;
//                                 }
//                                 if (empty($row['tgl_ijazah_sert'])) {
//                                     $modPendidikanpegawai->tgl_ijazah_sert = null;
//                                 }
//                                 $modPendidikanpegawai->create_time = date('Y-m-d');
//                                 $modPendidikanpegawai->jenispendidikan = $_POST['KPPegawaiM']['jenispendidikan'];
//                                 $modPendidikanpegawai->create_loginpemakai_id = Yii::app()->user->id;
//                                 $modPendidikanpegawai->create_ruangan = Yii::app()->user->ruangan_id;
//                                 if ($modPendidikanpegawai->validate()) {
//                                     if ($modPendidikanpegawai->save()) {
//                                         $jmlhsavependidikan++;
//                                     }
//                                 }
//                             }
//                           if ($jmlhsavependidikan==COUNT($_POST['KPPendidikanpegawaiR'])) {
//                               $transaction->commit();
//                               Yii::app()->user->setFlash('success','<strong>Berhasil </strong> Data berhasil disimpan');
//                               $modPendidikanpegawai->unsetAttributes();
//                           } else {
//                               $transaction->rollback();
//                               Yii::app()->user->setFlash('error','<strong>Gagal</strong> Data gagal disimpan');
//                           }
//                         }
// /* ========================= Akhir simpan Pendidikan pegawai===================================== */
// /* ========================= Proses simpan Pegawai diklat======================================= */
//                         else if (isset($_POST['submitdiklat'])){
//                             $details = $this->validasiTabularDiklat($_POST['KPPegawaidiklatT'], $model);
//                             $jumlah = count($details);
//                             $tersimpan = 0;
//                             foreach ($details as $i=>$row){
//                                 $pegawaidiklat_lamanyasatuan = $_POST['KPPegawaidiklatT'][$i]['pegawaidiklat_lamanyasatuan'];
//                                 $row->pegawaidiklat_lamanya = $row['pegawaidiklat_lamanya'] .' '. $pegawaidiklat_lamanyasatuan;
//                                 $row->create_loginpemakai_id = Yii::app()->user->id;
//                                 $row->create_ruangan = Yii::app()->user->ruangan_id;
//                                 $row->pegawaidiklat_tahun = date('Y-m-d H:i:s');
//                                 if($row->save()){
//                                     $tersimpan++;
//                                 }
//                             }
//                             if (($tersimpan > 0) && ($tersimpan == $jumlah)){
//                                     $transaction->commit();
//                                     Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
//                                     $module = '/'.$this->module->id.'/';
//                                     $id_pegawai = (is_null($id) ? '' : '&id='.$id);
//                                     $urlDiklat = $module.'PegawaiM/Pencatatanriwayat'.$id_pegawai;
//                                     $this->redirect(array($urlDiklat));
//                             }else{
//                                 $transaction->rollback();
//                                 Yii::app()->user->setFlash('error','<strong>Gagal</strong> Data gagal disimpan');
//                             }
//                         }

// /* ========================= Akhir simpan Pegawai diklat===================================== */
// /* ========================= Proses simpan Pengalaman kerja===================================== */
//                         else if (isset($_POST['submitPengalamankerja'])){
//                             $jmlhsavepengalamankerja = 0;
//                             $submitPengalamankerja = $this->validasiTabularPengalamanKerja($_POST['KPPengalamankerjaR'], $model);
//                             $jumlah = count($submitPengalamankerja);
//                             $tersimpan = 0;
//                             foreach ($submitPengalamankerja as $i=>$row){
//                                 if (empty($row['tglmasuk'])) {
//                                     $row->tglmasuk = null;
//                                 }
//                                 if (empty($row['tglkeluar'])) {
//                                     $row->tglkeluar = null;
//                                 }
//                                 $row->create_time = date('Y-m-d');
//                                 $row->create_loginpemakai_id = Yii::app()->user->id;
//                                 $row->create_ruangan = Yii::app()->user->ruangan_id;                                
//                                 if($row->save()){
//                                     $tersimpan++;
//                                 }
//                             }
//                             if (($tersimpan > 0) && ($tersimpan == $jumlah)){
//                                     $transaction->commit();
//                                     Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
//                                     $module = '/'.$this->module->id.'/';
//                                     $id_pegawai = (is_null($id) ? '' : '&id='.$id);
//                                     $urlDiklat = $module.'PegawaiM/Pencatatanriwayat'.$id_pegawai;
//                                     $this->redirect(array($urlDiklat));
//                             }else{
//                                 $transaction->rollback();
//                                 Yii::app()->user->setFlash('error','<strong>Gagal</strong> Data gagal disimpan');
//                             }
//                         }
// /* ========================= Akhir simpan Pengalaman kerja===================================== */
// /* ========================= Proses simpan Pegawai jabatan ==================================== */
//                         else if (isset($_POST['submitPegawaijabatan'])) {
//                             $modPegawaijabatan = new KPPegawaijabatanR;
//                             $modPegawaijabatan->pegawai_id = $_POST['KPPegawaiM']['pegawai_id'];
//                             $modPegawaijabatan->attributes = $_POST['KPPegawaijabatanR'];
//                             if (empty($_POST['KPPegawaijabatanR']['tglditetapkanjabatan'])) {
//                                 $modPegawaijabatan->tglditetapkanjabatan = null;
//                             }
//                             if (empty($_POST['KPPegawaijabatanR']['tmtjabatan'])) {
//                                 $modPegawaijabatan->tmtjabatan = null;
//                             }
//                             if (empty($_POST['KPPegawaijabatanR']['tglakhirjabatan'])) {
//                                 $modPegawaijabatan->tglakhirjabatan = null;
//                             }
//                             $modPegawaijabatan->create_time = date('Ymd');
//                             $modPegawaijabatan->create_loginpemakai_id = Yii::app()->user->id;
//                             $modPegawaijabatan->create_ruangan = Yii::app()->user->ruangan_id;
//                             if ($modPegawaijabatan->validate()) {
//                                 if ($modPegawaijabatan->save()) {
//                                     $transaction->commit();
//                                     Yii::app()->user->setFlash('success','<strong>Berhasil </strong> Data berhasil disimpan');
//                                     $modPegawaijabatan->unsetAttributes();
//                                 } else {
//                                     $transaction->rollback();
//                                     Yii::app()->user->setFlash('error','<strong>Gagal </strong> Data gagal disimpan');
//                                 }
//                             }
//                         }
// /* ========================= Akhir simpan Pegawai jabatan ===================================== */
// /* ========================= Proses simpan Pegawai mutasi =====================================*/
//                         else if (isset($_POST['submitPegmutasi'])) {
//                             $modPegmutasi = new KPPegmutasiR;
//                             $modPegmutasi->attributes = $_POST['KPPegmutasiR'];
//                             if (empty($_POST['KPPegmutasiR']['tglsk'])) {
//                                 $modPegmutasi->tglsk = null;
//                             }
//                             if (empty($_POST['KPPegmutasiR']['tmtsk'])) {
//                                 $modPegmutasi->tmtsk = null;
//                             }
//                             $modPegmutasi->pegawai_id = $_POST['KPPegawaiM']['pegawai_id'];
//                             if ($modPegmutasi->validate()) {
//                                 if ($modPegmutasi->save()) {
//                                     $transaction->commit();
//                                     Yii::app()->user->setFlash('success','<strong>Berhasil </strong> Data berhasil disimpan');
//                                     $modPegmutasi->unsetAttributes();
//                                 } else {
//                                     $transaction->rollback();
//                                     Yii::app()->user->setFlash('error','<strong>Gagal </strong> Data gagal disimpan');
//                                 }
//                             }
//                         }
// /* ========================= Akhir simpan Pegawai mutasi =====================================*/
// /* ========================= Proses simpan Pegawai cuti ====================================== */
//                         else if (isset($_POST['submitPegawaicuti'])) {
//                             $modPegawaicuti = new KPPegawaicutiT;
//                             $modPegawaicuti->pegawai_id = $_POST['KPPegawaiM']['pegawai_id'];
//                             $modPegawaicuti->attributes = $_POST['KPPegawaicutiT'];
//                             if (empty($_POST['KPPegawaicutiT']['tglakhircuti'])) {
//                                 $modPegawaicuti->tglakhircuti = null;
//                             }
//                             if ($modPegawaicuti->validate()) {
//                                 if ($modPegawaicuti->save()) {
//                                     $transaction->commit();
//                                     Yii::app()->user->setFlash('success','<strong>Berhasil </strong> Data berhasil disimpan');
//                                     $modPegawaicuti->unsetAttributes();
//                                 } else {
//                                     $transaction->rollback();
//                                     Yii::app()->user->setFlash('error','<strong>Gagal </strong> Data gagal disimpan');
//                                 }
//                             }
//                         }
// /* ========================= Akhir simpan Pegawai cuti ======================================= */
// /* ========================= Proses simpan Izin tugas belajar =================================== */
//                         else if (isset($_POST['submitIzintugasbelajar'])) {
//                             $modIzintugasbelajar = new KPIzintugasbelajarR;
//                             $modIzintugasbelajar->pegawai_id = $_POST['KPPegawaiM']['pegawai_id'];
//                             $modIzintugasbelajar->attributes = $_POST['KPIzintugasbelajarR'];
//                             if (empty($_POST['KPIzintugasbelajarR']['tglditetapkan'])) {
//                                 $modIzintugasbelajar->tglditetapkan = null;
//                             }
//                             $modIzintugasbelajar->create_time = date('Ymd');
//                             $modIzintugasbelajar->create_loginpemakai_id = Yii::app()->user->id;
//                             $modIzintugasbelajar->create_ruangan = Yii::app()->user->ruangan_id;
//                             if ($modIzintugasbelajar->validate()) {
//                                 if ($modIzintugasbelajar->save()) {
//                                     $transaction->commit();
//                                     Yii::app()->user->setFlash('success','<strong>Berhasil </strong> Data berhasil disimpan');
//                                     $modIzintugasbelajar->unsetAttributes();
//                                 } else {
//                                     $transaction->rollback();
//                                     Yii::app()->user->setFlash('error','<strong>Gagal </strong> Data gagal disimpan');
//                                 }
//                             }
//                         }
// /* ========================= Akhir simpan izin tugas belajar ==================================== */
// /* ========================= Proses simpan Hukuman disiplin =====================================*/
//                         else if (isset($_POST['submitHukdisiplin'])) {
//                             $modHukdisiplin = new KPHukdisiplinR;
//                             $modHukdisiplin->pegawai_id = $_POST['KPPegawaiM']['pegawai_id'];
//                             $modHukdisiplin->attributes = $_POST['KPHukdisiplinR'];
//                             $modHukdisiplin->create_time = date('Ymd');
//                             $modHukdisiplin->create_loginpemakai_id = Yii::app()->user->id;
//                             $modHukdisiplin->create_ruangan = Yii::app()->user->ruangan_id;
//                             if ($modHukdisiplin->validate()) {
//                                 if ($modHukdisiplin->save()) {
//                                     $transaction->commit();
//                                     Yii::app()->user->setFlash('success','<strong>Berhasil </strong> Data berhasil disimpan');
//                                     $modHukdisiplin->unsetAttributes();
//                                 } else {
//                                     $transaction->rollback();
//                                     Yii::app()->user->setFlash('error','<strong>Gagal </strong> Data gagal disimpan');
//                                 }
//                             }
//                         }
// //                    }
// /* ========================= Akhir simpan Hukuman disiplin =====================================*/
//                     }
//                     $this->render(
//                             'pencatatanriwayat'
//                             ,array(
//                                 'model'=>$model,
//                                 'modPendidikanpegawai'=>$modPendidikanpegawai,
//                                 'modPegawaidiklat'=>$modPegawaidiklat,
//                                 'modPengalamankerja'=>$modPengalamankerja,
//                                 'modPegawaijabatan'=>$modPegawaijabatan,
//                                 'modPegmutasi'=>$modPegmutasi,
//                                 'modPegawaicuti'=>$modPegawaicuti,
//                                 'modIzintugasbelajar'=>$modIzintugasbelajar,
//                                 'modHukdisiplin'=>$modHukdisiplin,
//                                 'namapegawai'=> (isset($model->nama_pegawai) ? $model->nama_pegawai : ''),
//                                 'detailPegawaidiklat'=>$detailPegawaidiklat,
//                                 'detailPengalamankerja'=>$detailPengalamankerja
//                             )
//                     );
//                 }
/* ======================= Akhir Pencatatan riwayat ============================================== */

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);
		$modRuanganPegawai=RuanganpegawaiM::model()->findAll('pegawai_id='.$id.'');
		$temLogo=$model->photopegawai;
		$format = new MyFormatter();
		if(isset($_POST['KPPegawaiM']))
		{
			$transaction = Yii::app()->db->beginTransaction();
			try {					  
					  $model->attributes=$_POST['KPPegawaiM'];
                                          $random = $model->nomorindukpegawai;
					  $model->profilrs_id=Params::DEFAULT_PROFIL_RUMAH_SAKIT;
					  $model->update_time = date('Y-m-d');
					  $model->update_loginpemakai_id = Yii::app()->user->id;
					  if(!empty($_POST['KPPegawaiM']['tgl_lahirpegawai'])){
							$model->tgl_lahirpegawai = $format->formatDateTimeForDb($model->tgl_lahirpegawai);
					  }else{
						  $model->tgl_lahirpegawai = null;
					  }

					  if(!empty($_POST['KPPegawaiM']['tglditerima'])){
							$model->tglditerima = $format->formatDateTimeForDb($model->tglditerima);
					  }else{
						  $model->tglditerima = null;
					  }

					$model->pegawai_aktif=true;
					$model->photopegawai = CUploadedFile::getInstance($model, 'photopegawai');
					$gambar=$model->photopegawai;
					if(isset($model->photopegawai)){ 
						if($_POST['caraAmbilPhoto']=='file')//Jika User Mengambil photo pegawai dengan cara upload file
						{ 
							if(!empty($model->photopegawai))//Klo User Memasukan Logo
							{                                                             
								$model->photopegawai =$random.'.'.$model->photopegawai->getExtensionName();//.$model->photopegawai
								Yii::import("ext.EPhpThumb.EPhpThumb");
								$thumb=new EPhpThumb();
								$thumb->init(); //this is needed
								$fullImgName =$model->photopegawai;   
								$fullImgSource = Params::pathPegawaiDirectory().$fullImgName;
								$fullThumbSource = Params::pathPegawaiTumbsDirectory().'kecil_'.$fullImgName;
//                                    if($model->save())
								if($model->update())
								{ 
									if(!empty($temLogo))
									{ 
										if(file_exists(Params::pathPegawaiDirectory().$temLogo))
										{
											unlink(Params::pathPegawaiDirectory().$temLogo);
										}
										if(file_exists(Params::pathIconModulThumbsDirectory().'kecil_'.$temLogo))
										{
											unlink(Params::pathIconModulThumbsDirectory().'kecil_'.$temLogo);
										}
									}
									$gambar->saveAs($fullImgSource);
									$thumb->create($fullImgSource)
										->resize(200,200)
										->save($fullThumbSource);
								}
								else
								{
									Yii::app()->user->setFlash('error', 'Data <strong>Gagal!</strong>  disimpan.');
								}
							}else{
							   $model->photopegawai = $model->photopegawai;
							}

						}   
						else 
						{
							////Jika user Memasukan Photo Dari Webcam
							if(!empty($temLogo))
							{                        
								if(!empty($temLogo))
								{ 
									if(file_exists(Params::pathPegawaiDirectory().$temLogo))
									{
										unlink(Params::pathPegawaiDirectory().$temLogo);
									}
									if(file_exists(Params::pathIconModulThumbsDirectory().'kecil_'.$temLogo))
									{
										unlink(Params::pathIconModulThumbsDirectory().'kecil_'.$temLogo);
									}                                        
								}
							}
							$model->update();
						}
					}else{
						$model->photopegawai = $temLogo;
					}

					if(!empty($_POST['ruangan_id']))
						$jumlahRuanganPegawai = COUNT($_POST['ruangan_id']);
					else
						$jumlahRuanganPegawai = 0;
						$pegawai_id=$model->pegawai_id;
						$hapusRuanganPegawai=  RuanganpegawaiM::model()->deleteAll('pegawai_id='.$pegawai_id.''); 
						for($i=0; $i<$jumlahRuanganPegawai; $i++)
						{
							$modRuanganPegawai = new RuanganpegawaiM;
							$modRuanganPegawai->ruangan_id=isset($_POST['ruangan_id'][$i]) ? $_POST['ruangan_id'][$i] : null;
							$modRuanganPegawai->pegawai_id=$pegawai_id;
							$modRuanganPegawai->save();
						}
						// $gelardepan = LookupM::model()->findByPk($model->gelardepan);
						// $model->gelardepan = $gelardepan->lookup_name;
						$model->update(); // update data 
						$transaction->commit();
				 Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan !');    
				 $this->redirect(array('Informasi', 'id'=>$model->pegawai_id));  
			 }
			catch (Exception $e)
			{
				 $transaction->rollback();
				 Yii::app()->user->setFlash('error',"Data gagal disimpan ".MyExceptionMessage::getMessage($e,true));
			}                 
		}
                
			$this->render('update',array(
			'model'=>$model,'modRuanganPegawai'=>$modRuanganPegawai,'format'=>$format
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
/* ============================ Proses delete riwayat ========================================= */
                public function actiondeletePegawaidiklat($pegawaidiklat_id,$pegawai_id)
                {
                    $modPegawaidiklat = new KPPegawaidiklatT;
                    if ($modPegawaidiklat->deleteByPK($pegawaidiklat_id)) {
						Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil dihapus !');    
                        $this->redirect(array('Riwayat','id'=>$pegawai_id));
                    }
                }
        
                public function actiondeletePegawaijabatan($pegawaijabatan_id,$pegawai_id)
                {
                    $modPegawaijabatan = new KPPegawaijabatanR;
                    if ($modPegawaijabatan->deleteByPK($pegawaijabatan_id)) {
						Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil dihapus !');    
                        $this->redirect(array('Riwayat','id'=>$pegawai_id));
                    }
                }
        
                public function actiondeletePegmutasi($pegmutasi_id,$pegawai_id)
                {
                    $modPegmutasi = new KPPegmutasiR;
                    if ($modPegmutasi->deleteByPK($pegmutasi_id)) {
						Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil dihapus !');    
                        $this->redirect(array('Riwayat','id'=>$pegawai_id));
                    }
                }
        
                public function actiondeletePegawaicuti($pegawaicuti_id,$pegawai_id)
                {
                    $modPegawaicuti = new KPPegawaicutiT;
                    if ($modPegawaicuti->deleteByPK($pegawaicuti_id)) {
						Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil dihapus !');    
                        $this->redirect(array('Riwayat','id'=>$pegawai_id));
                    }
                }
                
                public function actiondeleteIzintugasbelajar($izintugasbelajar_id,$pegawai_id)
                {
                    $modIzintugasbelajar = new KPIzintugasbelajarR;
                    if ($modIzintugasbelajar->deleteByPK($izintugasbelajar_id)) { 
						Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil dihapus !');  
                        $this->redirect(array('Riwayat','id'=>$pegawai_id));
                    }
                }
                
                public function actiondeleteHukdisiplin($hukdisiplin_id,$pegawai_id)
                {
                    $modHukdisiplin = new KPHukdisiplinR;
                    if ($modHukdisiplin->deleteByPK($hukdisiplin_id)) {
						Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil dihapus !');    
                        $this->redirect(array('Riwayat','id'=>$pegawai_id));
                    }
                }
/* =========================== Akhir proses delete riwayat ======================================= */
	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('KPPegawaiM');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
                
		$model=new KPPegawaiM('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['KPPegawaiM']))
			$model->attributes=$_GET['KPPegawaiM'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}
        
	public function actionInformasi()
	{
		//if(!Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
		// Uncomment the following line if AJAX validation is needed
		$model=new KPPegawaiM('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['KPPegawaiM']))
			$model->attributes=$_GET['KPPegawaiM'];

		$this->render('informasi',array(
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
		$model=KPPegawaiM::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='sapegawai-m-form')
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
		KPPegawaiM::model()->updateByPk($id, array('pegawai_aktif'=>false));
		$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}
        
	public function actionPrint()
	{
		$model = new KPPegawaiM;
		$model->attributes=$_REQUEST['KPPegawaiM'];
		$judulLaporan='Data Pegawai';
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
        
         
	public function actionRiwayat($id) {


		$this->render('riwayat',array(
			'model'=>$this->loadModel($id),
	));
	}
                
	public function actionPenilaian($id) {
		if (!empty($id)) {
			$modelpegawai = KPPegawaiM::model()->find('pegawai_id = ' . $id . '');
			$modelpegawai->jabatan_id = $modelpegawai->jabatan->jabatan_nama;
			$model = PenilaianpegawaiT::model()->find('pegawai_id = ' . $modelpegawai->pegawai_id . ' ');

		} 

		if(empty($model)){
			$model = new PenilaianpegawaiT;
		}

		$this->render('penilaian',array(
			'modelpegawai'=>$modelpegawai,
			'model'=>$model,
		));
	}
        
	public function actionPrintDetailPenilaian($id) {
	$modelpegawai = PegawaiM::model()->findByPk($id);
	$model = PenilaianpegawaiT::model()->find('pegawai_id = ' . $modelpegawai->pegawai_id . ' ');
	$modelpegawai->attributes = $_REQUEST['KPPegawaiM'];
	if(empty($model)){
		$model = new PenilaianpegawaiT;
	}
	$judulLaporan = 'Penilaian Pegawai';
	$caraPrint = $_REQUEST['caraPrint'];
	if ($caraPrint == 'PRINT') {
		$this->layout = '//layouts/printWindows';
		$this->render('PrintPenilaian', array('model' => $model, 'modelpegawai'=>$modelpegawai, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
	} else if ($caraPrint == 'EXCEL') {
		$this->layout = '//layouts/printExcel';
		$this->render('PrintPenilaian', array('model' => $model, 'modelpegawai'=>$modelpegawai, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
	} else if ($_REQUEST['caraPrint'] == 'PDF') {
		$ukuranKertasPDF = Yii::app()->session['ukuran_kertas'];                  // Ukuran Kertas Pdf
		$posisi = Yii::app()->session['posisi_kertas'];                                      // Posisi L->Landscape,P->Portait
		$mpdf = new MyPDF('', $ukuranKertasPDF);
		$mpdf->useOddEven = 2;
		$mpdf->WriteHTML($stylesheet, 1);
		$mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
		$mpdf->WriteHTML($this->render('PrintPenilaian', array('model' => $model, 'modelpegawai'=>$modelpegawai, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
		$mpdf->Output();
	 }
	}
        
       public function actionPrintRiwayat($id) {
        $model = PegawaiM::model()->findByPk($id);
        $modOrganisasi = PengorganisasiR::model()->findAllByAttributes(array('pegawai_id'=>$model->pegawai_id),array('order'=>'pengorganisasi_tahun'));
		$modPendidikanpegawai = PendidikanpegawaiR::model()->findAllByAttributes(array('pegawai_id'=>$model->pegawai_id),array('order'=>'tglmasuk'));
		$modSusunanKel = SusunankelM::model()->findAllByAttributes(array('pegawai_id'=>$model->pegawai_id),array('order'=>'susunankel_id'));
		$modKenaikanPangkat = KenaikanpangkatT::model()->findAllByAttributes(array('pegawai_id'=>$model->pegawai_id));
		$modPegawaidiklat = PegawaidiklatT::model()->findAllByAttributes(array('pegawai_id'=>$model->pegawai_id),array('order'=>'tglditetapkandiklat'));
		$modPengalamankerja = PengalamankerjaR::model()->findAllByAttributes(array('pegawai_id'=>$model->pegawai_id),array('order'=>'pengalamankerja_nourut'));
		$modPrestasi = PrestasikerjaR::model()->findAllByAttributes(array('pegawai_id'=>$model->pegawai_id),array('order'=>'tglprestasidiperoleh'));
		$modPegawaijabatan = PegawaijabatanR::model()->findAllByAttributes(array('pegawai_id'=>$model->pegawai_id),array('order'=>'tglditetapkanjabatan'));
		$modPegmutasi = PegmutasiR::model()->findAllByAttributes(array('pegawai_id'=>$model->pegawai_id),array('order'=>'pegmutasi_id'));
		$modDinas = PerjalanandinasR::model()->findAllByAttributes(array('pegawai_id'=>$model->pegawai_id),array('order'=>'perjalanandinas_id'));
		$modPegawaicuti = PegawaicutiT::model()->findAllByAttributes(array('pegawai_id'=>$model->pegawai_id),array('order'=>'tglmulaicuti'));
		$modIzintugasbelajar = IzintugasbelajarR::model()->findAllByAttributes(array('pegawai_id'=>$model->pegawai_id),array('order'=>'izintugasbelajar_id'));
		$modHukdisiplin = HukdisiplinR::model()->findAllByAttributes(array('pegawai_id'=>$model->pegawai_id),array('order'=>'hukdisiplin_id'));
		$modPenggajian = PenggajianpegawaiV::model()->findAllByAttributes(array('pegawai_id'=>$model->pegawai_id),array('order'=>'penggajianpeg_id'));
		
				
        if(isset($_REQUEST['KPPegawaiM'])){
			$model->attributes = $_REQUEST['KPPegawaiM'];
		}
        $judulLaporan = 'Riwayat Pegawai';
        $caraPrint = $_REQUEST['caraPrint'];
        if ($caraPrint == 'PRINT') {
            $this->layout = '//layouts/printWindows';
            $this->render('PrintRiwayat', array('model' => $model, 
				'judulLaporan' => $judulLaporan, 
				'caraPrint' => $caraPrint,
				'modOrganisasi'=>$modOrganisasi,
				'modPendidikanpegawai'=>$modPendidikanpegawai,
				'modSusunanKel'=>$modSusunanKel,
				'modKenaikanPangkat'=>$modKenaikanPangkat,
				'modPegawaidiklat'=>$modPegawaidiklat,
				'modPengalamankerja'=>$modPengalamankerja,
				'modPrestasi'=>$modPrestasi,
				'modPegawaijabatan'=>$modPegawaijabatan,
				'modPegmutasi'=>$modPegmutasi,
				'modDinas'=>$modDinas,
				'modPegawaicuti'=>$modPegawaicuti,
				'modIzintugasbelajar'=>$modIzintugasbelajar,
				'modHukdisiplin'=>$modHukdisiplin,
				'modPenggajian'=>$modPenggajian));
        } else if ($caraPrint == 'EXCEL') {
            $this->layout = '//layouts/printExcel';
            $this->render('PrintRiwayat', array('model' => $model, 
				'judulLaporan' => $judulLaporan, 
				'caraPrint' => $caraPrint,
				'modOrganisasi'=>$modOrganisasi,
				'modPendidikanpegawai'=>$modPendidikanpegawai,
				'modSusunanKel'=>$modSusunanKel,
				'modKenaikanPangkat'=>$modKenaikanPangkat,
				'modPegawaidiklat'=>$modPegawaidiklat,
				'modPengalamankerja'=>$modPengalamankerja,
				'modPrestasi'=>$modPrestasi,
				'modPegawaijabatan'=>$modPegawaijabatan,
				'modPegmutasi'=>$modPegmutasi,
				'modDinas'=>$modDinas,
				'modPegawaicuti'=>$modPegawaicuti,
				'modIzintugasbelajar'=>$modIzintugasbelajar,
				'modHukdisiplin'=>$modHukdisiplin,
				'modPenggajian'=>$modPenggajian));
        } else if ($_REQUEST['caraPrint'] == 'PDF') {
			$ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
			$posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
			$mpdf = new MyPDF('',$ukuranKertasPDF); 
			$mpdf->useOddEven = 2;  
			$stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
			$mpdf->WriteHTML($stylesheet,1);  
			$mpdf->AddPage($posisi,'','','','',15,15,15,15,15,15);
            $mpdf->WriteHTML($this->renderPartial('PrintRiwayat',array(
				'model' => $model, 
				'judulLaporan' => $judulLaporan, 
				'caraPrint' => $caraPrint,
				'modOrganisasi'=>$modOrganisasi,
				'modPendidikanpegawai'=>$modPendidikanpegawai,
				'modSusunanKel'=>$modSusunanKel,
				'modKenaikanPangkat'=>$modKenaikanPangkat,
				'modPegawaidiklat'=>$modPegawaidiklat,
				'modPengalamankerja'=>$modPengalamankerja,
				'modPrestasi'=>$modPrestasi,
				'modPegawaijabatan'=>$modPegawaijabatan,
				'modPegmutasi'=>$modPegmutasi,
				'modDinas'=>$modDinas,
				'modPegawaicuti'=>$modPegawaicuti,
				'modIzintugasbelajar'=>$modIzintugasbelajar,
				'modHukdisiplin'=>$modHukdisiplin,
				'modPenggajian'=>$modPenggajian),true));
            $mpdf->Output();
         }
    }

	protected function validasiTabularDiklat($datas, $model){
		 $pegawai = 0;
		 $details = array();
		 foreach ($datas as $i=>$data){
			 $data = array_filter($data, 'strlen');
			 if (is_array($data)){
				 if (!empty($data['pegawaidiklat_id'])){
					 $details[$i] = KPPegawaidiklatT::model()->findByPk($data['pegawaidiklat_id']);
					 $details[$i]->attributes = $data;
					 $pegawai = $data['pegawai_id'];
				 }else{
					 if(!empty($data['pegawaidiklat_nama']))
					 {
						 $details[$i] = new KPPegawaidiklatT();
						 $details[$i]->attributes = $data;
						 $details[$i]->pegawai_id = $model->pegawai_id;
					 }
				 }
			 }
			 else{
				 if (empty($data)){

				 }else{
					 $pegawai = $data;
				 }
			 }
		 }

		 $rows = array();
		 foreach ($details as $i=>$data){
			 $rows[$i] = $data;
			 $rows[$i]->validate();
		 }

		 return $rows;
	 }
        
	protected function validasiTabularPengalamanKerja($datas, $model){
		 $pegawai = 0;
		 $details = array();
		 foreach ($datas as $i=>$data){
			 $data = array_filter($data, 'strlen');
			 if (is_array($data)){
				 if (!empty($data['pengalamankerja_id'])){
					 $details[$i] = KPPengalamankerjaR::model()->findByPk($data['pengalamankerja_id']);
					 $details[$i]->attributes = $data;
					 $pegawai = $data['pegawai_id'];
				 }else{
					 if (!empty($data['namaperusahaan'])){
						 $details[$i] = new KPPengalamankerjaR();
						 $details[$i]->attributes = $data;
						 $details[$i]->pegawai_id = $model->pegawai_id;
					 }
				 }
			 }
		 }
		 $rows = array();
		 foreach ($details as $i=>$data){
			 $rows[$i] = $data;
			 $rows[$i]->validate();
		 }
		 return $rows;
	 }

        /**
         * menampilkan penggajian pegawai
         * @return rows table
         */
        public function actionGetPenggajian()
        {
            if (Yii::app()->request->isAjaxRequest) {
                $pegawai_id = $_POST['pegawai_id'];
                $modPenggajian = PenggajianpegawaiV::model()->findAllByAttributes(array('pegawai_id'=>$pegawai_id),array('order'=>'penggajianpeg_id'));
				$login_id = Yii::app()->user->id;
				
				if ($login_id == $pegawai_id){
					$i=1;
					$tr = '';
					foreach ($modPenggajian as $row)
					{
						$tr .= '<tr>';

							$tr .= '<td>'.$i.' </td>';
							$tr .= '<td>'.(isset($row->periodegaji) ? $row->periodegaji : '-').'</td>';
							$tr .= '<td>'.(isset($row->gelardepan) ? $row->gelardepan.$row->nama_pegawai : $row->nama_pegawai).'</td>';
							$tr .= '<td>'.(isset($row->nama_keluarga) ? $row->nama_keluarga : '-').'</td>';
							$tr .= '<td>'.MyFormatter::formatDateTimeForUser($row->tglpenggajian).'</td>';
							$tr .= '<td>'.$row->nopenggajian.'</td>';
							$tr .= '<td>'.$row->penerimaanbersih.'</td>';
							$tr .= '<td>'.$row->totalpajak.'</td>';

						$tr .= '</tr>';
						$i++;
					}
				}else{
					$tr = '';
					$tr .= '<tr>';
					$tr .= '<td> Data Tidak Ditemukan </td>';
					$tr .= '</tr>';
				}
                   $data['tr']=$tr;

                   echo json_encode($data);
                 Yii::app()->end();
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
                $modPegawai = new KPPegawaiM;
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
                    $kabupaten = $modPegawai->getKabupatenItems($propinsi_id);
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
                $modPegawai = new KPPegawaiM;
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
                    $kecamatan = $modPegawai->getKecamatanItems($kabupaten_id);
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
                $modPegawai = new KPPegawaiM;
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
                    $kelurahan = $modPegawai->getKelurahanItems($kecamatan_id);
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
        /**
         * set dropdown daerah pasien berdasarkan
         * propinsi_id
         * kabupaten_id
         * kecamatan_id
         * kelurahan_id
         * pasien_id
         */
        public function actionSetDropdownDaerahPasien()
        {
            if(Yii::app()->getRequest()->getIsAjaxRequest()) {
                $modPegawai = new KPPegawaiM;
                $propinsi_id = $_POST['propinsi_id'];
                $kabupaten_id = $_POST['kabupaten_id'];
                $kecamatan_id = $_POST['kecamatan_id'];
                $kelurahan_id = (isset($_POST['kelurahan_id']) ? $_POST['kelurahan_id'] : null);

                $propinsis = PropinsiM::model()->findAll('propinsi_aktif = TRUE order by propinsi_nama asc');
                $propinsis = CHtml::listData($propinsis,'propinsi_id','propinsi_nama');
                $propinsiOption = CHtml::tag('option',array('value'=>''),"-- Pilih --",true);
                foreach($propinsis as $value=>$name)
                {
                    if($value==$propinsi_id)
                        $propinsiOption .= CHtml::tag('option',array('value'=>$value,'selected'=>true),CHtml::encode($name),true);
                    else
                        $propinsiOption .= CHtml::tag('option',array('value'=>$value),CHtml::encode($name),true);
                }
                $kabupatens = $modPegawai->getKabupatenItems($propinsi_id);
//                $kabupatens = KabupatenM::model()->findAllByAttributes(array('propinsi_id'=>$propinsi_id,'kabupaten_aktif'=>true,));
                $kabupatens = CHtml::listData($kabupatens,'kabupaten_id','kabupaten_nama');
                $kabupatenOption = CHtml::tag('option',array('value'=>''),"-- Pilih --",true);
                foreach($kabupatens as $value=>$name)
                {
                    if($value==$kabupaten_id)
                        $kabupatenOption .= CHtml::tag('option',array('value'=>$value,'selected'=>true),CHtml::encode($name),true);
                    else
                        $kabupatenOption .= CHtml::tag('option',array('value'=>$value),CHtml::encode($name),true);
                }
                $kecamatans = $modPegawai->getKecamatanItems($kabupaten_id);
//                $kecamatans = KecamatanM::model()->findAllByAttributes(array('kabupaten_id'=>$kabupaten_id,'kecamatan_aktif'=>true,));
                $kecamatans = CHtml::listData($kecamatans,'kecamatan_id','kecamatan_nama');
                $kecamatanOption = CHtml::tag('option',array('value'=>''),"-- Pilih --",true);
                foreach($kecamatans as $value=>$name)
                {
                    if($value==$kecamatan_id)
                        $kecamatanOption .= CHtml::tag('option',array('value'=>$value,'selected'=>true),CHtml::encode($name),true);
                    else
                        $kecamatanOption .= CHtml::tag('option',array('value'=>$value),CHtml::encode($name),true);
                }
                $kelurahans = $modPegawai->getKelurahanItems($kecamatan_id);
                $kelurahans = CHtml::listData($kelurahans,'kelurahan_id','kelurahan_nama');
                $kelurahanOption = CHtml::tag('option',array('value'=>''),"-- Pilih --",true);
                foreach($kelurahans as $value=>$name)
                {
                    if($value==$kelurahan_id)
                        $kelurahanOption .= CHtml::tag('option',array('value'=>$value,'selected'=>true),CHtml::encode($name),true);
                    else
                        $kelurahanOption .= CHtml::tag('option',array('value'=>$value),CHtml::encode($name),true);
                }
                
                $dataList['listPropinsi'] = $propinsiOption;
                $dataList['listKabupaten'] = $kabupatenOption;
                $dataList['listKecamatan'] = $kecamatanOption;
                $dataList['listKelurahan'] = $kelurahanOption;

                echo json_encode($dataList);
                Yii::app()->end();
            }
        }
		
		public function actionGetTahun()
		{
			if(Yii::app()->getRequest()->getIsAjaxRequest()) {
				if (!empty($_POST['tahun'])){
				$format = new MyFormatter;
				$tahun = $format->formatDateTimeForDb($_POST['tahun']);
				$dob=$tahun; $today=date("Y-m-d");
				list($y,$m,$d)=explode('-',$dob);
				list($ty,$tm,$td)=explode('-',$today);
				if($td-$d<0){
					$day=($td+30)-$d;
					$tm--;
				}
				else{
					$day=$td-$d;
				}
				if($tm-$m<0){
					$month=($tm+12)-$m;
					$ty--;
				}
				else{
					$month=$tm-$m;
				}
				$year=$ty-$y;

				$data['tahun'] = str_pad($year, 2, '0', STR_PAD_LEFT);
				$data['bulan'] = str_pad($month, 2, '0', STR_PAD_LEFT);
				echo json_encode($data);

				}
							Yii::app()->end();
			}
		}
        
	public function actionKartuPegawai($idPegawai)
    {
        $this->layout='//layouts/printWindows';
        $model = PegawaiM::model()->findByPk($idPegawai);
        $judulLaporan = 'Kartu Pegawai';
        $this->render('kartuPegawai', array('model'=>$model,
                                           'judulLaporan'=>$judulLaporan));
    }
	
	
	
	public function actionSetDropdownPendKualifikasi($encode=false,$model_nama='',$attr='')
	{
		if(Yii::app()->request->isAjaxRequest) {
			$modPegawai = new KPPegawaiM;
			if($model_nama !=='' && $attr == ''){
				$pendidikan_id = $_POST["$model_nama"]['pendidikan_id'];
			}
			 elseif ($model_nama == '' && $attr !== '') {
				$pendidikan_id = $_POST["$attr"];
			}
			 elseif ($model_nama !== '' && $attr !== '') {
				$pendidikan_id = $_POST["$model_nama"]["$attr"];
			}
			$pendKualifikasi = null;
			if($pendidikan_id){
				$pendKualifikasi = $modPegawai->getPendKualifikasiItems($pendidikan_id);
				$pendKualifikasi = CHtml::listData($pendKualifikasi,'pendkualifikasi_id','pendkualifikasi_nama');
			}
			if($encode){
				echo CJSON::encode($pendKualifikasi);
			} else {
				if(empty($pendKualifikasi)){
					echo CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
				} else {
					echo CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
					foreach($pendKualifikasi as $value=>$name) {
						echo CHtml::tag('option', array('value'=>$value),CHtml::encode($name),true);
					}
				}
			}
		}
		Yii::app()->end();
	}
	
	public function actionSetDropdownKelompokPegawai($encode=false,$model_nama='',$attr='')
	{
		if(Yii::app()->request->isAjaxRequest) {
			$modPegawai = new KPPegawaiM;
			if($model_nama !=='' && $attr == ''){
				$pendKualifikasi = $_POST["$model_nama"]['pendkualifikasi_id'];
			}
			 elseif ($model_nama == '' && $attr !== '') {
				$pendKualifikasi = $_POST["$attr"];
			}
			 elseif ($model_nama !== '' && $attr !== '') {
				$pendKualifikasi = $_POST["$model_nama"]["$attr"];
			}
			$kelpegawai = null;
			if($pendKualifikasi){
				$kelpegawai = $modPegawai->getKelompokPegawaiItems($pendKualifikasi);
				$kelpegawai = CHtml::listData($kelpegawai,'kelompokpegawai_id','kelompokpegawai_nama');
			}
			if($encode){
				echo CJSON::encode($kelpegawai);
			} else {
				if(empty($kelpegawai)){
					echo CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
				} else {
					if(count($kelpegawai) > 1){
						echo CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
					}
					foreach($kelpegawai as $value=>$name) {
						echo CHtml::tag('option', array('value'=>$value),CHtml::encode($name),true);
					}
				}
			}
		}
		Yii::app()->end();
	}
}
