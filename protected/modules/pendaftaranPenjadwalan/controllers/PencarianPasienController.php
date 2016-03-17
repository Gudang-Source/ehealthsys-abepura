<?php

class PencarianPasienController extends MyAuthController
{
                
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column1';
        public $defaultAction = 'cariPasien';
        public $path_view = 'pendaftaranPenjadwalan.views.pencarianPasien.';

        public function actions()
        {
                return array(
                        'myBarcode'=>array(
                            'class'=>'MyBarcodeAction',
                            'canvasWidth'=>'300',
                            'type'=>'code128',
                        ),
                );
        }
        
	public function actionCariPasien()
	{
                $cek = null;
                $format = new MyFormatter();
                $modProp = PropinsiM::model()->findAll("propinsi_aktif = TRUE ORDER BY propinsi_nama ASC");
                $modKab =  KabupatenM::model()->findAll("kabupaten_aktif = TRUE ORDER BY kabupaten_nama ASC");
                $modKec =  KecamatanM::model()->findAll("kecamatan_aktif = TRUE ORDER BY kecamatan_nama ASC");
                $modKel =  KelurahanM::model()->findAll("kelurahan_aktif = TRUE ORDER BY kelurahan_nama ASC");
                $model = new PPPasienM;
                $model->tgl_rm_awal=date('Y-m-d');
                $model->tgl_rm_akhir =date('Y-m-d');
                $modPendaftaran = new PendaftaranT();
                $modPendaftaran->pasien_id = 0;
                /*
                 * Proses Pencarian
                 */
                if (isset($_GET['PendaftaranT']) && $_GET['ajax'] == 'pencarianlistkunjungan-grid'){
                    $modPendaftaran->pasien_id = $_GET['PendaftaranT']['pasien_id'];
                    $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
                    $this->render($this->path_view.'_gridListKunjungan', array('modPendaftaran'=>$modPendaftaran, 'modPasien'=>$modPasien));
                    Yii::app()->end();
                }
                
                if(isset($_GET['PPPasienM'])){
                    $model->attributes = $_GET['PPPasienM'];
                    $model->tgl_rm_awal  = isset($_REQUEST['PPPasienM']['tgl_rm_awal'])?$format->formatDateTimeForDb($_REQUEST['PPPasienM']['tgl_rm_awal']):null;
                    $model->tgl_rm_akhir = isset($_REQUEST['PPPasienM']['tgl_rm_akhir'])?$format->formatDateTimeForDb($_REQUEST['PPPasienM']['tgl_rm_akhir']):null;
                    $model->ceklis = isset($_REQUEST['PPPasienM']['ceklis'])?$_REQUEST['PPPasienM']['ceklis']:0;
                    // print_r($model->ceklis);
                    // exit();
                }
                // if(isset($_REQUEST['PPPasienM'])){
                //     $model->attributes = $_REQUEST['PPPasienM'];
                //     $model->tgl_rm_awal  = $format->formatDateTimeForDb($_REQUEST['PPPasienM']['tgl_rm_awal']);
                //     $model->tgl_rm_akhir = $format->formatDateTimeForDb($_REQUEST['PPPasienM']['tgl_rm_akhir']);
                //     $model->ceklis = $_REQUEST['PPPasienM']['ceklis'];

                // }
                
                
//                                        $model->tgl_rm_awal = Yii::app()->dateFormatter->formatDateTime(
//                                                                CDateTimeParser::parse($model->tgl_rm_awal, 'yyyy-MM-dd hh:mm:ss'));
//                                        $model->tgl_rm_akhir = Yii::app()->dateFormatter->formatDateTime(
//                                                                CDateTimeParser::parse($model->tgl_rm_akhir, 'yyyy-MM-dd hh:mm:ss'));

		$this->render($this->path_view.'cariPasien',array(
                                                                'cek'=>$cek,
                                                                'model'=>$model,
                                                                'modProp'=>$modProp,
                                                                'modKab'=>$modKab,
                                                                'modKec'=>$modKec,
                                                                'modPendaftaran'=>$modPendaftaran,
                                                                'modKel'=>$modKel,
                                                      ));
	}

	public function actionPrintKartu($id,$umur)
	{   
                $this->layout='//layouts/printWindows';
                $model = PasienM::model()->findByPk($id);
		$this->render($this->path_view.'printKartu',array('model'=>$model,'umur'=>$umur));
	}

	public function actionUbahPasienOld($id)
	{
                //if(!Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
                $model = $this->loadModel($id);
                $temLogo=$model->photopasien;
                if(isset($_POST['PPPasienM'])) {                   
                    $random=rand(0000000,9999999);
                    $format = new MyFormatter();
                    $model->attributes = $_POST['PPPasienM'];
                    $model->kelompokumur_id = CustomFunction::getKelompokUmur($model->tanggal_lahir);
                    $model->photopasien = CUploadedFile::getInstance($model, 'photopasien');
                    $gambar=$model->photopasien;
                    if(!empty($model->photopasien)) { //if user input the photo of patient
                        $model->photopasien =$random.$model->photopasien;

                         Yii::import("ext.EPhpThumb.EPhpThumb");

                         $thumb=new EPhpThumb();
                         $thumb->init(); //this is needed

                         $fullImgName =$model->photopasien;   
                         $fullImgSource = Params::pathPasienDirectory().$fullImgName;
                         $fullThumbSource = Params::pathPasienTumbsDirectory().'kecil_'.$fullImgName;

                         if($model->save()) {
                            if(!empty($temLogo)) { 
                               if(file_exists(Params::pathPasienDirectory().$temLogo))
                                    unlink(Params::pathPasienDirectory().$temLogo);
                               if(file_exists(Params::pathPasienTumbsDirectory().'kecil_'.$temLogo))
                                    unlink(Params::pathPasienTumbsDirectory().'kecil_'.$temLogo);
                            }
                            $gambar->saveAs($fullImgSource);
                            $thumb->create($fullImgSource)
                                 ->resize(200,200)
                                 ->save($fullThumbSource);

                            //$model->tgl_rekam_medik  = $format->formatDateTimeForDb($_POST['PPPasienM']['tgl_rekam_medik']);
                            $model->updateByPk($id, array('tgl_rekam_medik'=>$model->tgl_rekam_medik));
                            Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
                            $this->redirect(array('cariPasien'));
                          } else {
                               Yii::app()->user->setFlash('error', 'Data <strong>Gagal!</strong>  disimpan.');
                          }
                    } else { //if user not input the photo
                       $model->photopasien=$temLogo;
                       if($model->save()) {
                            //$model->tgl_rekam_medik  = $format->formatDateTimeForDb($_POST['PPPasienM']['tgl_rekam_medik']);
                            $model->updateByPk($id, array('tgl_rekam_medik'=>$model->tgl_rekam_medik));
                            Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
                            $this->redirect(array('cariPasien'));
                       }
                    }

                }
		$this->render($this->path_view.'ubahPasien',array('model'=>$model));
	}
        
        /**
         * module pendaftaranPenjadwalan/pencarianPasien/ubahPasien&id=1
         * date     : 07-May-2014
         * issue    : EHS-1101
         * desc     : pada saat ubah pasien disamakan dengan yang di aplikasi JK
         * action   : actionUbahPasien($id)
         */
        public function actionUbahPasien($id)
	{
            $model = $this->loadModel($id);
            $modPendaftaran = new PendaftaranT;
            $format = new MyFormatter();
            $temLogo=$model->photopasien;              
            $modPegawai=new PPPegawaiM;
			
			if(!empty($model->pegawai_id)){
				$modPegawai = PPPegawaiM::model()->findByPk($model->pegawai_id);
			}
			
            if(isset($_POST['PPPasienM']) && isset($_POST['PendaftaranT'])) {
                $random=rand(0000000,9999999);
                $model->attributes = $_POST['PPPasienM'];
                $modPendaftaran->attributes = $_POST['PendaftaranT'];
                $model->kelompokumur_id = CustomFunction::getKelompokUmur($model->tanggal_lahir);
                $model->photopasien = CUploadedFile::getInstance($model, 'photopasien');
                $gambar=$model->photopasien;
                $pendaftaran=array();
                $umurBaru = isset($_POST['PendaftaranT']['umur'])?$_POST['PendaftaranT']['umur']:null;
                $model->tanggal_lahir = $format->formatDateTimeForDb($model->tanggal_lahir);
				
				if(isset($_POST['PPPegawaiM'])){
					$model->pegawai_id = $_POST['PPPegawaiM']['pegawai_id'];
				}
				
                if(!empty($model->photopasien)) { //if user input the photo of patient
                    $model->photopasien =$random.$model->photopasien;

                     Yii::import("ext.EPhpThumb.EPhpThumb");

                     $thumb=new EPhpThumb();
                     $thumb->init(); //this is needed

                     $fullImgName =$model->photopasien;   
                     $fullImgSource = Params::pathPasienDirectory().$fullImgName;
                     $fullThumbSource = Params::pathPasienTumbsDirectory().'kecil_'.$fullImgName;

                     $pendaftaran = PendaftaranT::model()->findAllByAttributes(array('pasien_id'=>$id),array('order'=>'pendaftaran_id desc'));

                     if($model->save()) {
                        if (count($pendaftaran)>0) {
                            PendaftaranT::model()->updateByPk($pendaftaran[0]->pendaftaran_id,array('umur'=>$umurBaru));
                        }
                        if(!empty($temLogo)) { 
                           if(file_exists(Params::pathPasienDirectory().$temLogo))
                                unlink(Params::pathPasienDirectory().$temLogo);
                           if(file_exists(Params::pathPasienTumbsDirectory().'kecil_'.$temLogo))
                                unlink(Params::pathPasienTumbsDirectory().'kecil_'.$temLogo);
                        }
                        $gambar->saveAs($fullImgSource);
                        $thumb->create($fullImgSource)
                             ->resize(200,200)
                             ->save($fullThumbSource);

//                            $model->tgl_rekam_medik  = $format->formatDateTimeForDb($_POST['PPPasienM']['tgl_rekam_medik']);
                        $model->updateByPk($id, array('tgl_rekam_medik'=>$model->tgl_rekam_medik));                            
                        Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
                        $this->redirect(array('cariPasien'));
                      } else {
                           Yii::app()->user->setFlash('error', 'Data <strong>Gagal!</strong>  disimpan.');
                      }
                } else { //if user not input the photo
                   $model->photopasien=$temLogo;
                   if($model->save()) {
//                            $model->tgl_rekam_medik  = $format->formatDateTimeForDb($_POST['PPPasienM']['tgl_rekam_medik']);
                        $model->updateByPk($id, array('tgl_rekam_medik'=>$model->tgl_rekam_medik));
                        if (count($pendaftaran)>0) {
                            PendaftaranT::model()->updateByPk($pendaftaran[0]->pendaftaran_id,array('umur'=>$umurBaru));
                        }


                        Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
                        $this->redirect(array('cariPasien'));
                   }
                }

            }
                $model->tanggal_lahir = date('d/m/Y',strtotime($model->tanggal_lahir));
		$this->render($this->path_view.'ubahPasien',array('format'=>$format,'model'=>$model,'modPendaftaran'=>$modPendaftaran,'modPegawai'=>$modPegawai));
	}
        
	public function actionUbahPenanggungJawab($id)
	{               
                                //if(!Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
                                /*
                                 * GET penanggungjawab_id berdasarkan no_rekam_medik dari tabel pendaftaran_t
                                 */
                                $model = PenanggungjawabM::model()->findByPk($id);
                                 if(isset($_POST['PenanggungjawabM']))
		{
                                     $model->attributes=$_POST['PenanggungjawabM'];
                                     if($model->save())
                                     {
                                        Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
				$this->redirect(array('cariPasien'));
                                      }
                                 }
		$this->render($this->path_view.'ubahPenanggungJawab',array('model'=>$model));
	}
        
                /**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=  PPPasienM::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
        
        public function actionRiwayatKunjungan($pasien_id = null)
	{
                $this->layout='//layouts/iframe';
                $modPendaftaran = new PPPendaftaranT();
                $modPendaftaran->pasien_id = $pasien_id;
                $modPasien = PPPasienM::model()->findByPk($modPendaftaran->pasien_id);
                $this->render($this->path_view.'_gridListKunjungan', array('modPendaftaran'=>$modPendaftaran, 'modPasien'=>$modPasien));
	}

     /**
         * set tanggal lahir dari umur (__ Thn __ Bln __ Hr)
         */
        public function actionSetTanggalLahir()
        {
            if(Yii::app()->getRequest()->getIsAjaxRequest()) {
                $data['tanggal_lahir'] = date("d/m/Y",strtotime(CustomFunction::getTanggalUmur($_POST['umur'])));

                echo json_encode($data);
                Yii::app()->end();
            }
        }
        /**
         * set umur dari tanggal lahir (date)
         */
        public function actionSetUmur()
        {
            if(Yii::app()->getRequest()->getIsAjaxRequest()) {
                $data['umur'] = null;
                if(isset($_POST['tanggal_lahir']) && !empty($_POST['tanggal_lahir'])){
                    $data['umur'] = CustomFunction::hitungUmur($_POST['tanggal_lahir']);
                }
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
                $modPasien = new PPPasienM;
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
                    $kabupaten = $modPasien->getKabupatenItems($propinsi_id);
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
                $modPasien = new PPPasienM;
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
                    $kecamatan = $modPasien->getKecamatanItems($kabupaten_id);
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
                $modPasien = new PPPasienM;
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
                    $kelurahan = $modPasien->getKelurahanItems($kecamatan_id);
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
                $modPasien = new PPPasienM;
                $propinsi_id = $_POST['propinsi_id'];
                $kabupaten_id = $_POST['kabupaten_id'];
                $kecamatan_id = $_POST['kecamatan_id'];
                $kelurahan_id = (isset($_POST['kelurahan_id']) ? $_POST['kelurahan_id'] : null);

                $propinsis = PropinsiM::model()->findAll('propinsi_aktif = TRUE');
                $propinsis = CHtml::listData($propinsis,'propinsi_id','propinsi_nama');
                $propinsiOption = CHtml::tag('option',array('value'=>''),"-- Pilih --",true);
                foreach($propinsis as $value=>$name)
                {
                    if($value==$propinsi_id)
                        $propinsiOption .= CHtml::tag('option',array('value'=>$value,'selected'=>true),CHtml::encode($name),true);
                    else
                        $propinsiOption .= CHtml::tag('option',array('value'=>$value),CHtml::encode($name),true);
                }
                $kabupatens = $modPasien->getKabupatenItems($propinsi_id);
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
                $kecamatans = $modPasien->getKecamatanItems($kabupaten_id);
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
                $kelurahans = $modPasien->getKelurahanItems($kecamatan_id);
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
		
		
		public function actionAutocompleteNobadge()
		{
				if(Yii::app()->request->isAjaxRequest) {
					$format = new MyFormatter();
					$returnVal = array();
					$no_badge = isset($_GET['nomorindukpegawai']) ? $_GET['nomorindukpegawai'] : null;
					$criteria = new CDbCriteria();
					$criteria->compare('LOWER(pegawai_m.nomorindukpegawai)', strtolower($no_badge), true);
					$criteria->join = "JOIN pegawai_m ON t.pegawai_id = pegawai_m.pegawai_id";
					$criteria->order = 'pegawai_m.nomorindukpegawai, t.nama_pasien';
					$criteria->limit = 50;
					$models = PPPasienM::model()->findAll($criteria);
					foreach($models as $i=>$model)
					{
						$attributes = $model->attributeNames();
						foreach($attributes as $j=>$attribute) {
							$returnVal[$i]["$attribute"] = $model->$attribute;
						}
						$returnVal[$i]['label'] = $model->pegawai->nomorindukpegawai.
											' - '.$model->no_rekam_medik.	
											' - '.$model->nama_pasien.	
											' - ('.$model->pegawai->nama_pegawai.
											') - '.$format->formatDateTimeForUser($model->tanggal_lahir);
						$returnVal[$i]['value'] = $model->pegawai->nomorindukpegawai;
					}

					echo CJSON::encode($returnVal);
				}else
					throw new CHttpException(403,'Tidak dapat mengurai data');
				Yii::app()->end();
		}
		
		public function actionSetNobadge()
		{
			if(Yii::app()->request->isAjaxRequest) {
				$nip = null;
				$pegawai_id = isset($_POST['pegawai_id']) ? $_POST['pegawai_id'] : null;
				$models = PPPegawaiM::model()->findByPk($pegawai_id);
				if(count($models)>0){
					$nip = $models->nomorindukpegawai;
				}
				echo CJSON::encode($nip);
			}else
				throw new CHttpException(403,'Tidak dapat mengurai data');
			Yii::app()->end();
		}
                
                
                public function actionNonAktifPasien() {
                    if(Yii::app()->request->isAjaxRequest) {
                        if (isset($_POST['id'])) {
                            PasienM::model()->updateByPk($_POST['id'], array(
                                'statusrekammedis'=>  Params::STATUSREKAMMEDIS_NON_AKTIF,
                            ));
                        }
                    }
                    Yii::app()->end();
                }

}