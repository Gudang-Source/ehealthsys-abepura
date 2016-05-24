<?php
class SiteController extends Controller
{       
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
              
                if(Yii::app()->user->isGuest){
                  $this->redirect(array('login'));
                }
                $this->layout = '//layouts/column1';


                $kelompokModuls = KelompokmodulK::model()->findAll('kelompokmodul_aktif = true');
                $moduls = ModulK::model()->findAllByAttributes(array('modul_aktif'=>true),array('order'=>'modul_urutan ASC, modul_nama'));//modul_kategori , t.kelompokmodul_id, 
                $kategoriModuls = LookupM::getItems('kategorimodul');

		$this->render('index', array(
                    'kelompokModuls'=>$kelompokModuls,
                    'moduls'=>$moduls,
                    'kategoriModuls'=>$kategoriModuls,
                    ));
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
            $this->layout = "//layouts/iframe";
	    if($error=Yii::app()->errorHandler->error)
	    {
	    	if(Yii::app()->request->isAjaxRequest)
	    		echo $error['message'];
	    	else
	        	$this->render('error', $error);
	    }
	}

	/**
	 * Displays the contact page
	 */
	public function actionContact()
	{
		$model=new ContactForm;
		if(isset($_POST['ContactForm']))
		{
			$model->attributes=$_POST['ContactForm'];
			if($model->validate())
			{
				$headers="From: {$model->email}\r\nReply-To: {$model->email}";
				mail(Yii::app()->params['adminEmail'],$model->subject,$model->body,$headers);
				Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
				$this->refresh();
			}
		}
		$this->render('contact',array('model'=>$model));
	}

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
                
		$this->layout = '//layouts/login';
//              RND-4611 >>  $modRegistrasi = new RegistrasidemoS;
//                $modKomen = new KomentarS;
                
		$model=new LoginForm;
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

                
                if (isset($_POST["forgot"])) {
                    if(isset($_POST['LoginForm'])) {
                        $model->attributes=$_POST['LoginForm'];
                        $lp = LoginpemakaiK::model()->findByAttributes(array(
                            'nama_pemakai' => $model->username,
                        ));
                        if (!empty($lp->pegawai_id)) {
                            $pegawai = PegawaiM::model()->findByPk($lp->pegawai_id);
                            $m = new LupaPasswordForm();
                            $m->no_hp = $pegawai->nomobile_pegawai;
                            $m->loginpemakai_id = $lp->loginpemakai_id;
                            $this->setPassword($m);
                            Yii::app()->user->setFlash('success', 'Segera <strong>login</strong> jika pesan sudah diterima di HP Anda.');
                            $this->redirect(array('site/login'));
                        }
                    }
                }
                
                
                
		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
                                                 
			// validate user input and redirect to the previous page if valid
                                  
			if($model->validate() && $model->login()){
				$login_pemakai = LoginpemakaiK::model()->findByPk(Yii::app()->user->id);
                            Yii::app()->session['timeout'] = time();
                            Yii::app()->session['inactive'] = Params::DEFAULT_SESSION_INACTIVE * 60;
                            
                            Yii::app()->user->setFlash('info', '<strong>Selamat Datang</strong> '.Yii::app()->user->name);
                            if(isset($_POST['LoginForm']['modul']) && $_POST['LoginForm']['modul'] != "")
                            {
                                $modModulK = ModulK::model()->findByPk($_POST['LoginForm']['modul'],'modul_aktif = TRUE');
                                $url = Yii::app()->createUrl($modModulK->url_modul,array('modul_id'=>$_POST['LoginForm']['modul']));
                            }else{
								
									$url = Yii::app()->user->returnUrl;                            
                            }
							if(empty($login_pemakai->loginpemakai_update)){
								$url = Yii::app()->createUrl('sistemAdministrator/loginpemakaiK/GantiPassword',array('id'=>$login_pemakai->loginpemakai_id,'modul_id'=>$_POST['LoginForm']['modul']));
							}
                            $this->redirect($url);
                        }
			}
		// display the login form
		$this->render('login',array('model'=>$model,
//                                          RND-4611 >>  'modRegistrasi'=>$modRegistrasi,
//                                            'modKomen'=>$modKomen
                        ));
	}
        
        /**
         * ===========================================================
         * Lupa password
         * ===========================================================
         */ /*
        public function actionLupaPassword()
        {
            $this->layout = '//layouts/login';
            
            $model = new LupaPasswordForm;
            
            if (isset($_POST['LupaPasswordForm'])) {
                $model->attributes = $_POST['LupaPasswordForm'];
                if ($model->validate()) {
                    $this->setPassword($model);
                    Yii::app()->user->setFlash('success', 'Segera <strong>login</strong> jika pesan sudah diterima di HP Anda.');
                    $this->redirect(array('site/login'));
                }
            }
            //die;
            
            
            $this->render('lupaPassword',array('model'=>$model));
        } */
        
        public function setPassword($model)
        {
            $char = str_split("abcdefghijklmnopqrstuvwxyz1234567890");
            $str = "";
            for ($i = 0; $i < 8; $i++) {
                $str .= $char[rand(0,count($char) - 1)];
            }
            
            $this->kirimSMS($model, $str);
            
            LoginpemakaiK::model()->updateByPk($model->loginpemakai_id, array(
                'katakunci_pemakai'=>LoginpemakaiK::model()->encrypt($str),
                'loginpemakai_update'=>null,
            ));
            
            // var_dump($str, md5($str), $model->attributes); die;
        }
        
        public function kirimSMS($model, $str)
        {
            $lp = LoginpemakaiK::model()->findByPk($model->loginpemakai_id);
            $no_hp = $model->no_hp;
            $dat = "Password untuk user '".$lp->nama_pemakai."' adalah '$str'. "
                    . "Segera login untuk mengubah password.";
            
            $model = new Outbox;
            $model->CreatorID = Yii::app()->user->name;
            
            $model->UDH = "";
            $model->DestinationNumber = $no_hp;
            $model->TextDecoded = $dat;
            
            $model->save();
        }
        
        /**
         * ===========================================================
         * End Lupa password
         * ===========================================================
         */

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{               
            LoginpemakaiK::model()->updateByPk(Yii::app()->user->id, array('lastlogin'=>date( 'Y-m-d H:i:s'),'statuslogin'=>FALSE));
            Yii::app()->user->logout();
			Yii::app()->session->destroy();
            $this->redirect(Yii::app()->homeUrl);
	}
        
        /**
         * ajax untuk mengambil loginpemakai_id berdasarkan username
         * digunakan di site/login handling after blur input username
         */
        public function actionAjaxCekUsername()
        {   
            if (Yii::app()->request->isAjaxRequest){
                $data = array();
                $username = (isset($_POST['username'])) ? $_POST['username'] : null;
                $is_exist = LoginpemakaiK::model()->findByAttributes(array('nama_pemakai'=>$username));
                if($is_exist)
                {
                    $data['id'] = $is_exist->loginpemakai_id;
                    $ruangan = RuanganpemakaiK::model()->findAllByAttributes(array('loginpemakai_id'=>$data['id']));
                }else{
                    $data['ruangan'] = CHtml::dropdownlist('LoginForm_ruangan','ruangan_id',array('empty'=>'-- Pilih --'));
                    $data['modul'] = CHtml::dropdownlist('LoginForm_modul','modul_id',array('empty'=>'-- Pilih --'));
                    $data['instalasi'] = CHtml::dropdownlist('LoginForm_instalasi','instalasi_id',array('empty'=>'-- Pilih --'));
                    echo json_encode($data);
                    exit;
                }
                
                $arrInstalasi = array();
                $valInstalasi = array();
                $x = 0;
                
                if (count($ruangan) > 0){
                    foreach ($ruangan as $i=>$ruanganNya) {
                        $ruang = RuanganM::model()->findByPk($ruanganNya->ruangan_id,'ruangan_aktif =TRUE');
                        if((boolean)count($ruang)){
                            if(isset ($ruang->instalasi_id))
                            {
                            $arrInstalasi[$ruang->instalasi_id] = $ruang->instalasi->instalasi_nama;
                            $valInstalasi[$x] = $ruang->instalasi_id;                                
                            }

                        }
                        $x++;
                    }
                }
                
                if(count($arrInstalasi) > 0)
                {
                    asort($arrInstalasi);
                    if(count($arrInstalasi) == 1)
                    {
                        $data['instalasi'] = CHtml::dropdownlist('LoginForm_instalasi','instalasi_id',$arrInstalasi,
                            array(
                                'ajax'=>array(
                                    'type'=>'POST',
                                    'url'=>  CController::createUrl('site/dynamicRuangan'),
                                    'update'=>'#LoginForm_ruangan',
                                )
                            )
                        );
                    }else{
                        $data['instalasi'] = CHtml::dropdownlist('LoginForm_instalasi','instalasi_id',$arrInstalasi,
                            array(
                                'empty'=>'-- Pilih --',
                                'ajax'=>array(
                                    'type'=>'POST',
                                    'url'=>  CController::createUrl('site/dynamicRuangan'),
                                    'update'=>'#LoginForm_ruangan',
                                )
                            )
                        );                        
                    }
                }
                
                $arrRuangan = array();
                $dataRuangan = $ruangan;
                if(count($dataRuangan) > 0){
                    foreach ($dataRuangan as $i=>$ruanganNya){
                        $arrRuangan[$ruanganNya->ruangan_id] = $ruanganNya->ruangan->ruangan_nama;
                    }
                }
                
                if(count($arrRuangan) > 0){
                    asort($arrRuangan);
                    if(count($arrRuangan) == 1)
                    {
                        $data['ruangan'] = CHtml::dropdownlist('LoginForm_ruangan','ruangan_id',$arrRuangan);
                    }else{
                        $data['ruangan'] = CHtml::dropdownlist('LoginForm_ruangan','ruangan_id',$arrRuangan,array('empty'=>'-- Pilih --'));
                    }
                }

                if (!empty($data['id'])){
                    $modul = ModuluserK::model()->findAllByAttributes(array('loginpemakai_id'=>$data['id']));
                }
                
                $arrModul = array();
                if (count($modul) > 0){
                    foreach ($modul as $i=>$modulNya) {
                        $modModulK = ModulK::model()->findByPk($modulNya->modul_id,'modul_aktif = TRUE');
                        if ((boolean)count($modModulK)){
                            $arrModul[$modModulK->modul_id] = $modModulK->modul_nama;
                        }
                    }
                }
                
                if (count($arrModul) > 0){
                    if(count($arrModul) == 1)
                    {
                        $data['modul'] = CHtml::dropdownlist('LoginForm_modul','modul_id',$arrModul);
                    }else{
                        $data['modul'] = CHtml::dropdownlist('LoginForm_modul','modul_id',$arrModul,array('empty'=>'-- Pilih --',));
                    }                    
                }
                
                echo json_encode($data);
                Yii::app()->end();
                
            }
        }
		
		public function actionDynamicInstalasi()
        {
            $data = array();
                $username = (isset($_POST['username'])) ? $_POST['username'] : null;
                $instalasi_id = (isset($_POST['instalasi'])) ? $_POST['instalasi'] : null;
                $ruangan_id = (isset($_POST['ruangan'])) ? $_POST['ruangan'] : null;
                $modul_id = (isset($_POST['modul'])) ? $_POST['modul'] : null;
				
                $is_exist = LoginpemakaiK::model()->findByAttributes(array('nama_pemakai'=>$username));
                if($is_exist)
                {
                    $data['id'] = $is_exist->loginpemakai_id;
                    $ruangan = RuanganpemakaiK::model()->findAllByAttributes(array('loginpemakai_id'=>$data['id']));
                }else{
                    $data['ruangan'] = CHtml::dropdownlist('LoginForm_ruangan','ruangan_id',array('empty'=>'-- Pilih --'));
                    $data['modul'] = CHtml::dropdownlist('LoginForm_modul','modul_id',array('empty'=>'-- Pilih --'));
                    $data['instalasi'] = CHtml::dropdownlist('LoginForm_instalasi','instalasi_id',array('empty'=>'-- Pilih --'));
                    echo json_encode($data);
                    exit;
                }
                
                $arrInstalasi = array();
                $valInstalasi = array();
                $x = 0;
                
                if (count($ruangan) > 0){
                    foreach ($ruangan as $i=>$ruanganNya) {
                        $ruang = RuanganM::model()->findByPk($ruanganNya->ruangan_id,'ruangan_aktif =TRUE');
                        if((boolean)count($ruang)){
                            if(isset ($ruang->instalasi_id))
                            {
                            $arrInstalasi[$ruang->instalasi_id] = $ruang->instalasi->instalasi_nama;
                            $valInstalasi[$x] = $ruang->instalasi_id;                                
                            }

                        }
                        $x++;
                    }
                }
                
                if(count($arrInstalasi) > 0)
                {
                    asort($arrInstalasi);
                    if(count($arrInstalasi) == 1)
                    {
                        $data['instalasi'] = CHtml::dropdownlist('LoginForm_instalasi','instalasi_id',$arrInstalasi,
                            array(
                                'ajax'=>array(
                                    'type'=>'POST',
                                    'url'=>  CController::createUrl('site/dynamicRuangan'),
                                    'update'=>'#LoginForm_ruangan',
                                ),
								"options" => array($instalasi_id=>array("selected"=>true))
                            )
                        );
                    }else{
                        $data['instalasi'] = CHtml::dropdownlist('LoginForm_instalasi','instalasi_id',$arrInstalasi,
                            array(
                                'empty'=>'-- Pilih --',
                                'ajax'=>array(
                                    'type'=>'POST',
                                    'url'=>  CController::createUrl('site/dynamicRuangan'),
                                    'update'=>'#LoginForm_ruangan',
                                ),
								"options" => array($instalasi_id=>array("selected"=>true))
                            )
                        );                        
                    }
                }
                
                $arrRuangan = array();
                $dataRuangan = $ruangan;
                if(count($dataRuangan) > 0){
                    foreach ($dataRuangan as $i=>$ruanganNya){
                        $arrRuangan[$ruanganNya->ruangan_id] = $ruanganNya->ruangan->ruangan_nama;
                    }
                }
                
                if(count($arrRuangan) > 0){
                    asort($arrRuangan);
                    if(count($arrRuangan) == 1)
                    {
                        $data['ruangan'] = CHtml::dropdownlist('LoginForm_ruangan','ruangan_id',$arrRuangan,array("options" => array($ruangan_id=>array("selected"=>true))));
                    }else{
                        $data['ruangan'] = CHtml::dropdownlist('LoginForm_ruangan','ruangan_id',$arrRuangan,array('empty'=>'-- Pilih --'));
                    }
                }

                if (!empty($data['id'])){
                    $modul = ModuluserK::model()->findAllByAttributes(array('loginpemakai_id'=>$data['id']));
                }
                
                $arrModul = array();
                if (count($modul) > 0){
                    foreach ($modul as $i=>$modulNya) {
                        $modModulK = ModulK::model()->findByPk($modulNya->modul_id,'modul_aktif = TRUE');
                        if ((boolean)count($modModulK)){
                            $arrModul[$modModulK->modul_id] = $modModulK->modul_nama;
                        }
                    }
                }
                
                if (count($arrModul) > 0){
                    if(count($arrModul) == 1)
                    {
                        $data['modul'] = CHtml::dropdownlist('LoginForm_modul','modul_id',$arrModul,array("options" => array($modul_id=>array("selected"=>true))));
                    }else{
                        $data['modul'] = CHtml::dropdownlist('LoginForm_modul','modul_id',$arrModul,array('empty'=>'-- Pilih --','options' => array($modul_id=>array("selected"=>true))));
                    }                    
                }
                
                echo json_encode($data);
                Yii::app()->end();
                
        }
		
        public function actionDynamicRuangan()
        {
            $dataRuangan = array();
            if (isset($_POST['LoginForm']['instalasi'])){
                $instalasi = (int)$_POST['LoginForm']['instalasi'];
                $dataRuangan = RuanganM::model()->findAll('instalasi_id=:instalasi_id AND ruangan_aktif = TRUE order by ruangan_nama', 
                        array(':instalasi_id'=>$instalasi));
            }
            
            $data = CHtml::listData($dataRuangan,'ruangan_id','ruangan_nama');
            
            if(count($data) > 0){
                if(count($data) > 1){
                    echo CHtml::tag('option',array('value'=>''),CHtml::encode('-- Pilih --'),true);
                }
                
                foreach($data as $value=>$name)
                {
                    echo CHtml::tag('option', array('value'=>$value),CHtml::encode($name),true);
                }
            }
        }

        public function actionDynamicPropinsi()
        {
            $criteria = new CDbCriteria;
            $criteria->with = array('propinsi');
            $criteria->compare('propinsi.propinsi_nama',$_POST['RegistrasidemoS']['propinsi']);
            $criteria->order = 'kabupaten_nama';

            $data= KabupatenM::model()->findAll($criteria);

            $data=CHtml::listData($data,'kabupaten_nama','kabupaten_nama');

            if(empty($data))
            {
                echo CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
            }
            else
            {
                echo CHtml::tag('option',array('value'=>''),CHtml::encode('-- Pilih --'),true);
                foreach($data as $value=>$name)
                {
                    echo CHtml::tag('option', array('value'=>$value),CHtml::encode($name),true);
                }
            }
        }

        public function actionSetKertas()
        {
          if(Yii::app()->getRequest()->getIsAjaxRequest())
            {
               if(isset ($_POST['ukuranKertas']))
                 {
                    $session=new CHttpSession;
                    $session->open();
                    $_SESSION['ukuran_kertas'] = $_POST['ukuranKertas'];
                    $_SESSION['posisi_kertas'] = $_POST['posisiKertas'];
                    $data['pesan']='Ukuran '.$_POST['ukuranKertas'].' dan posisi '.$_POST['posisiNama'].' Berhasil Diset';
                 }
                echo json_encode($data);
                Yii::app()->end();
            }   
        }

//        Registrasi Demo sudah tidak digunakan lagi
//        RND-4611
//        public function actionRegistrasi()
//        {
//            $this->layout = '//layouts/login';
//
//            $modRegistrasi = new RegistrasidemoS;
//            $modKomen = new KomentarS;
//
//            $model=new LoginForm;
//
//            // collect user input data
//            if(isset($_POST['RegistrasidemoS']))
//            {
//                    $modRegistrasi->attributes=$_POST['RegistrasidemoS'];
//                    $modRegistrasi->tglregisterdemo = date('Y-m-d');
//                    // validate user input and redirect to the previous page if valid
//
//                    if($modRegistrasi->validate()){
//                        $modRegistrasi->save();
//                        Yii::app()->user->setFlash('info', '<strong>Registrasi</strong> berhasil.');
//                        $this->redirect(array('login'));  
//                    } else {
//                        Yii::app()->user->setFlash('error', '<strong>Registrasi</strong> gagal.');
//                    }
//
//            }
//            // display the login form
//            $this->render('login',array('model'=>$model,
//                                        'modRegistrasi'=>$modRegistrasi,
//                                        'modRegistrasi'=>$modRegistrasi));
//        }

        public function actionTestimonial()
        {
            //echo '<pre>'.print_r($_POST['RegistrasidemoS'],1).'</pre>';
            $this->layout = '//layouts/login';

//          RND-4611 >>  $modRegistrasi = new RegistrasidemoS;
            $modKomen = new KomentarS;

            $model=new LoginForm;
            if(isset($_POST['ajax']) && $_POST['ajax']==='testimonial-form') {
                    echo CActiveForm::validate($modKomen);
                    Yii::app()->end();
            }
            // collect user input data
            if(isset($_POST['KomentarS']))
            {
                    $modKomen->attributes=$_POST['KomentarS'];
                    $modKomen->tglkomentar = date('Y-m-d');
                    $modKomen->komentar_tampilkan = false;
                    // validate user input and redirect to the previous page if valid

                    if($modKomen->validate()){
                        $modKomen->save();
                        Yii::app()->user->setFlash('info', '<strong>Terimakasih</strong> Anda telah memberi testimoni.');
                        $this->redirect(array('login'));  
                    } else {
                        Yii::app()->user->setFlash('error', '<strong>Testimoni</strong> gagal disimpan.');
                    }

            }
            // display the login form
            $this->render('login',array('model'=>$model,
//                                      RND-4611 >>  'modRegistrasi'=>$modRegistrasi,
                                        'modKomen'=>$modKomen));
        }
        
        public function actionViewTestimoni()
        {
            $this->layout = '//framedialog';
            $criteria = new CDbCriteria;
            $criteria->addCondition('komentar_tampilkan = TRUE');
            $criteria->order = 'komentar_id DESC';
            $criteria->limit = 10;
            $modTestimonis = KomentarS::model()->findAll($criteria);
            
            $this->render('viewTestimoni',array('modTestimonis'=>$modTestimonis));
        }
        
        public function actionAjaxViewTestimoni()
        {
            if(Yii::app()->getRequest()->getIsAjaxRequest()) {
                $this->layout = '//framedialog';
                $criteria = new CDbCriteria;
                $criteria->addCondition('komentar_tampilkan = TRUE');
                $criteria->order = 'komentar_id DESC';
                $criteria->limit = 10;
                $modTestimonis = KomentarS::model()->findAll($criteria);

                $data = '';
                foreach ($modTestimonis as $i=>$testimoni) {
                    $data .= '<div class="alert alert-info">';
                    $data .= '<b>'.$testimoni->namakomentar.' - '.$testimoni->instanasi.'</b><br/>';
                    $data .= ''.$testimoni->deskripsikomentat.'';
                    $data .= '<span class="author-pengumuman">'.$testimoni->emailkomentar.' - '.$testimoni->websitekomentar.'</span><br/>';
                    $data .= '</div>';
                }
                echo CJSON::encode($data);
                Yii::app()->end();
            }
        }
                
        public function actionDetailModul()
        {
            if(Yii::app()->getRequest()->getIsAjaxRequest())
            {
                if(isset ($_GET['idModul']))
                {
                    $idModul = $_GET['idModul'];
                    $modul = ModulK::model()->findByPk($idModul);
                    $data['modul_nama'] = $modul->modul_namalainnya;
                    $data['modul_fungsi'] = $modul->modul_fungsi;
                    $data['content'] = $this->renderPartial('modul/detail', array('modul'=>$modul), true);
                    
                    echo CJSON::encode($data);
                }
                Yii::app()->end();
            } 
        }
        public function actionInsertNotifikasi(){
            $model = new NofitikasiR;
            $model->attributes = $_POST['NofitikasiR'];
            $model->tglnotifikasi = date( 'Y-m-d H:i:s');
            $model->create_time = date( 'Y-m-d H:i:s');
            $model->create_loginpemakai_id = Yii::app()->user->id;
            $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
            $is_simpan = false;
            $data = array();
            $transaction = Yii::app()->db->beginTransaction();
            try{
                if(Yii::app()->getRequest()->getIsAjaxRequest())
                {
                    $criteria = new CDbCriteria;
                    $criteria->compare('instalasi_id',$model->instalasi_id);
                    $criteria->compare('modul_id',$model->modul_id);
                    $criteria->compare('LOWER(isinotifikasi)',strtolower($model->isinotifikasi),true);
                    $criteria->compare('create_ruangan',$model->create_ruangan);
                    $criteria->addCondition("DATE(tglnotifikasi) = DATE(NOW()) AND isread = false");
                    $is_exist = NofitikasiR::model()->find($criteria);
                    
                    if(!$is_exist)
                    {
                        if($model->save()){
                            $is_simpan = true;
                        }
                    }else{
                        $attributes = array(
                            'update_time' => date('Y-m-d H:i:s'),
                            'update_loginpemakai_id' => Yii::app()->user->id,
                        );
                        $update = $model::model()->updateByPk($is_exist['nofitikasi_id'], $attributes);
                        if($update){
                            $is_simpan = true;
                        }
                    }
                    
                    $attributes = array(
                        'instalasi_id'=>Yii::app()->user->getState('instalasi_id'),
                        'modul_id'=>Yii::app()->session['modul_id'],
                        'isread'=> false
                    );
                    $data_notif = NofitikasiR::model()->findAllByAttributes($attributes);
                    $isi_notif = "";
                    if(count($data_notif) > 0)
                    {
                        foreach($data_notif as $value)
                        {
                            $isi_notif .= '<li class="read">';
                            $isi_notif .= '<a href="index.php?r=sistemAdministrator/comment/update&id=12">';
                            $isi_notif .= '<span class="sender">'. $value['judulnotifikasi'] .'</span>';
                            $isi_notif .= '<span class="message">'. $value['isinotifikasi'] .'</span>';
                            $isi_notif .= '<span class="time">'. $value['tglnotifikasi'] .'</span>';
                            $isi_notif .= '</a>';
                            $isi_notif .= '</li>';
                        }
                    }
                    $data['template'] = $isi_notif;
                    $data['count_notif'] = count(NofitikasiR::model()->findAllByAttributes($attributes,array('order'=>'create_time desc', 'limit'=>6)));
                    $data['modul_id'] = $model->modul_id;
                    
                    if($is_simpan){
                        $data['pesan'] = 'ok';
                        $transaction->commit();
                    }else{
                        $data['pesan'] = 'gagal';
                        $transaction->rollback();
                    }
                    echo CJSON::encode($data);
                    Yii::app()->end();
                }else{

                }
            }catch(Exception $exc){
                $transaction->rollback();
            }
        }
        
        public function actionPilihModul() {
            if(Yii::app()->getRequest()->getIsAjaxRequest()) {
                $res = null;
                if (isset($_POST['ruangan_id'])) {
                    $ruangan = RuanganM::model()->findByPk($_POST['ruangan_id']);
                    if (!empty($ruangan)) $res = $ruangan->modul_id;
                }
                
                echo CJSON::encode(array('modul_id'=>$res));
            }
            
        }
        
        public function actionGetNotifikasi(){
            if(Yii::app()->getRequest()->getIsAjaxRequest())
            {
                if(!isset(Yii::app()->user->id) || !isset(Yii::app()->session['modul_id'])){
                    echo "Session habis!";
                    Yii::app()->end();
                }

                $attributes = array(
                    'modul_id'=>Yii::app()->session['modul_id'],
                    'isread'=> false,
                    'create_ruangan'=>Yii::app()->user->getState('ruangan_id'),
                );
                $data['count_notif'] = count(NofitikasiR::model()->findAllByAttributes($attributes,array('order'=>'create_time desc', 'limit'=>11)));

                echo CJSON::encode($data);
                Yii::app()->end();
            }
        }
        
        public function actionSetReadNotifikasi()
        {
            if(Yii::app()->getRequest()->getIsAjaxRequest())
            {
                $id_pesan = $_GET['id_pesan'];
                $attributes = array(
                    'update_time' => date('Y-m-d H:i:s'),
                    'update_loginpemakai_id' => Yii::app()->user->id,
                    'isread' => true
                );
                $update = NofitikasiR::model()->updateByPk($id_pesan, $attributes);
                $data = array(
                    'pesan' => ($update == true ? 'ok' : 'not' )
                );
                echo CJSON::encode($data);
                Yii::app()->end();
            }            
        }
        
        public function actionGetDetailNotifikasi()        
        {
            $notifikasi_id = isset($_GET['notifikasi_id']) ? $_GET['notifikasi_id'] : 99999999999;
            $notifikasi = NofitikasiR::model()->findByPk($notifikasi_id);
            
            $data = '<table>';
            $data .= '<tr>';
            $data .= '<td width="90">Judul Pesan</td>';
            $data .= '<td width="5">:</td>';
            $data .= '<td>'. $notifikasi->judulnotifikasi .'</td>';
            $data .= '</tr>';
            $data .= '<tr>';
            $data .= '<td>Isi Pesan</td>';
            $data .= '<td>:</td>';
            $data .= '<td>'. $notifikasi->isinotifikasi .'</td>';
            $data .= '</tr>';
            $data .= '<tr>';
            $data .= '<td>Tgl</td>';
            $data .= '<td>:</td>';
            $data .= '<td>'. date("d-m-Y h:m:s", strtotime($notifikasi->create_time)) .'</td>';
            $data .= '</tr>';
            $data .= '<tr>';
            $data .= '</table>';
            echo($data);
        }
}
