<?php

class PresensiTController extends MyAuthController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column1';
        public $defaultAction = 'admin';
        public $IP = Params::IP_FINGER_PRINT;
        public $Key = Params::KEY_FINGER_PRINT;

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
	public function actionCreate($presensi_id = null)
	{
                //if(!Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
                $format = new MyFormatter();
		$model=new KPPresensiT;
                $model->tglpresensi = date('d M Y');
                $modPegawai = new KPRegistrasifingerprint();

		// Uncomment the following line if AJAX validation is needed
		

                if(!empty($presensi_id)){
                    $model = KPPresensiT::model()->findByPk($presensi_id);
                    $modPegawai = KPRegistrasifingerprint::model()->findByAttributes(array('pegawai_id'=>$model->pegawai_id));
                }
		if(isset($_POST['KPPresensiT']))
		{
                    $model->attributes=$_POST['KPPresensiT'];
                    
                    $modPegawai = KPRegistrasifingerprint::model()->findByPk($_POST['KPRegistrasifingerprint']['pegawai_id']);                    
                    $modPegawai->jabatan_id = isset($modPegawai->jabatan_id)?$modPegawai->jabatan->jabatan_nama:'-';
                    $modPegawai->tgl_lahirpegawai = $format->formatDateTimeForUser($modPegawai->tgl_lahirpegawai);
                    
                    
                    $model->pegawai_id = $_POST['KPRegistrasifingerprint']['pegawai_id'];
                    $model->no_fingerprint = $_POST['KPRegistrasifingerprint']['nofingerprint'];
                    $model->statusscan_id = null;                    
                    $shift = $model->getShiftId($model->pegawai_id);
                                                            
                                       
                    $tgl = $format->formatDateTimeForDb(date('Y-m-d', strtotime($model->tglpresensi)));
                                      //  var_dump($shift);die;
                  
                    $model->statusscan_id = $_POST['KPPresensiT']['statusscan_id'];                        
                    if ($model->statusscan_id == Params::STATUSSCAN_MASUK){                                                    
                        //$model->jamkerjamasuk = $_POST['KPPresensiT']['jamkerjamasuk'];
                        $model->tglpresensi = $tgl.' '.$_POST['KPPresensiT']['jamkerjamasuk'];
                        $model->jamkerjamasuk = ($shift != '-')?$shift->shift_jamawal:'08:15:00';
                        $model->terlambat_mnt = $model->getTerlambat($model->tglpresensi, $model->jamkerjamasuk);
                        $model->pulangawal_mnt = '';  
                        
                        $jammasuk = date('H:is',strtotime($model->tglpresensi));
                        if ($shift != '-'){
                            if ( ($shift->shift_id == Params::SHIFT_PAGI)):
                                if ($jammasuk > '09:00:00'):
                                    $model->statuskehadiran_id = Params::STATUSKEHADIRAN_ALPHA;
                                endif;
                            endif;
                        }else{
                           // if ($shift==null){
                            //    if ($jammasuk > '09:00:00'):
                            //        $model->statuskehadiran_id = Params::STATUSKEHADIRAN_ALPHA;
                            //    endif;
                          //  }
                        }
                        

                    }elseif($model->statusscan_id == Params::STATUSSCAN_PULANG){
                        $model->tglpresensi = $tgl.' '.$_POST['KPPresensiT']['jamkerjapulang'];
                        //$model->jamkerjapulang = (count($shift)>0)?$shift->shift_jamakhir:'15:00:00';
                        //$model->pulangawal_mnt = $model->getPulangAwal($model->tglpresensi, $model->jamkerjapulang);
                        $model->terlambat_mnt = '';                                                
                        //$model->jamkerjapulang = $_POST['KPPresensiT']['jamkerjapulang'];                        
                    }elseif($model->statusscan_id == Params::STATUSSCAN_DATANG){
                        $model->tglpresensi = $tgl.' '.$_POST['KPPresensiT']['jamkerjamasuk'];                                                                        
                        $model->terlambat_mnt = '';
                        $model->pulangawal_mnt = '';
                    }elseif($model->statusscan_id == Params::STATUSSCAN_KELUAR){
                        $model->tglpresensi = $tgl.' '.$_POST['KPPresensiT']['jamkerjapulang'];                        
                        $model->terlambat_mnt = '';
                        $model->pulangawal_mnt = '';
                    }else{
                        $model->tglpresensi =$tgl.' '.date('H:i:s');  
                    }
                   
                    
                    $cr = new CDbCriteria();                                        
                     if ($model->statuskehadiran_id == Params::STATUSKEHADIRAN_IZIN){                           
                         $cr->addCondition("pegawai_id = '$model->pegawai_id' ");
                     }else{                         
                         $cr->addCondition("statusscan_id = ".$model->statusscan_id);                    
                         $cr->addCondition("statuskehadiran_id = '".Params::STATUSKEHADIRAN_HADIR."' AND pegawai_id = '$model->pegawai_id' ");
                     }                    
                    $cr->addBetweenCondition('tglpresensi', $tgl.' 00:00:00', $tgl.' 23:59:59');
                    $cek = PresensiT::model()->find($cr);
                                                                                
                    $valid = $model->validate();
                    
                    if (count($cek) > 0){
                        if ($model->statuskehadiran_id == Params::STATUSKEHADIRAN_IZIN)
                        {
                            $jam = (count($shift)>0)?$shift->shift_jamakhir:'15:00:00';
                            $tanggal = $tgl.' '.$jam;
                            
                            if ($tanggal <= $model->tglpresensi){
                                Yii::app()->user->setFlash('error', 'Maaf, pegawai '.$modPegawai->nama_pegawai.' jam kerjanya berakhir pada pukul '.date('H:i:s',strtotime($tanggal)));
                            }else{                                
                                if($valid){
                                        $model->save();
                                        Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
                                        $this->redirect(array('create','presensi_id'=>$model->presensi_id,'sukses'=>1));
                                } else {
                                    Yii::app()->user->setFlash('error', '<strong>Gagal!</strong> Data gagal disimpan.');
                                }
                            }
                        }elseif ($model->statuskehadiran_id == Params::STATUSKEHADIRAN_ALPHA){
                            if ($cek->statuskehadiran_id == Params::STATUSKEHADIRAN_HADIR){
                                Yii::app()->user->setFlash('error', 'Maaf, pegawai '.$modPegawai->nama_pegawai.' sudah '.$cek->statusscan->statusscan_nama.' pada jam '.date('H:i:s',strtotime($cek->tglpresensi)));
                            }else{
                                $model->save();
                                Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
                                $this->redirect(array('create','presensi_id'=>$model->presensi_id,'sukses'=>1));
                            }
                        }else{                                                    
                            if ($cek->statusscan_id == $model->statusscan_id){                            
                                Yii::app()->user->setFlash('error', 'Maaf, pegawai '.$modPegawai->nama_pegawai.' pada tanggal '.date('d M Y',strtotime($tgl)).' sudah melakukan absensi '.$model->statusscan->statusscan_nama);
                            }else{                                                       
                                if($valid){
                                        $model->save();
                                        Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
                                        $this->redirect(array('create','presensi_id'=>$model->presensi_id,'sukses'=>1));
                                } else {
                                    Yii::app()->user->setFlash('error', '<strong>Gagal!</strong> Data gagal disimpan.');
                                }
                            }
                        }    
                        //Yii::app()->user->setFlash('error', 'Sudah Ada.');
                    }else{        
                        $cr1 = new CDbCriteria();                                                                                              
                        $cr1->addCondition("statuskehadiran_id = '".Params::STATUSKEHADIRAN_ALPHA."' AND pegawai_id = '$model->pegawai_id' ");                                               
                        $cr1->addBetweenCondition('tglpresensi', $tgl.' 00:00:00', $tgl.' 23:59:59');
                        $cek1 = PresensiT::model()->find($cr1);
                        
                          if ($shift != '-'){
                            if ($shift->shift_id == Params::SHIFT_PAGI ):                               
                                if (count($cek1) > 0){
                                    //$model->statuskehadiran_id = Params::STATUSKEHADIRAN_ALPHA;
                                }
                            endif;
                        }else{
                           if ($shift == null ):                               
                            //if (count($cek1) > 0){
                              //  $model->statuskehadiran_id = Params::STATUSKEHADIRAN_ALPHA;
                          //  }
                            endif;
                        }   
                        
                        if ($model->statusscan_id != Params::STATUSSCAN_MASUK){
                            $cr2 = new CDbCriteria(); 
                            $cr->addCondition("statusscan_id = ".Params::STATUSSCAN_MASUK);    
                            $cr2->addCondition("statuskehadiran_id = '".Params::STATUSKEHADIRAN_ALPHA."' AND pegawai_id = '$model->pegawai_id' ");                                               
                            $cr2->addBetweenCondition('tglpresensi', $tgl.' 00:00:00', $tgl.' 23:59:59');
                            $cek2 = PresensiT::model()->find($cr2);
                            
                            if (count($cek2)==0):
                              //  $model->statuskehadiran_id = Params::STATUSKEHADIRAN_ALPHA;
                            endif;
                        }
                        
                        
                        if($valid){
                                $model->save();
                                Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
                                $this->redirect(array('create','presensi_id'=>$model->presensi_id,'sukses'=>1));
                        } else {
                            Yii::app()->user->setFlash('error', '<strong>Gagal!</strong> Data gagal disimpan.');
                        }
                    }
                    
		}

		$this->render('create',array(
			'model'=>$model, 'modPegawai'=>$modPegawai,
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
		

		if(isset($_POST['KPPresensiT']))
		{
			$model->attributes=$_POST['KPPresensiT'];
			if($model->save()){
                                Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
				$this->redirect(array('view','id'=>$model->presensi_id));
                        }
		}

		$this->render('update',array(
			'model'=>$model,
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

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('KPPresensiT');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
        
        
	public function actionAdmin()
	{
                
                
                if (Yii::app()->request->isAjaxRequest){
                    if (isset($_GET['idAlat']) && !isset($_GET['disconnect'])){
                        AlatfingerM::model()->updateAll(array('alat_aktif'=>false));
                        $idAlat = $_GET['idAlat'];
                        $value = AlatfingerM::model()->updateByPk($idAlat, array('alat_aktif'=>true));
                        $result['success'] = $value;
                        $result['data'] = AlatfingerM::model()->findByPk($idAlat)->attributes;
                        $result['connection'] = $this->connection($result['data']['ipfinger']);
                        $result['time'] = date('d M Y');
                        echo json_encode($result);
                        Yii::app()->end();
                    } else if (isset($_GET['idAlat']) && isset($_GET['disconnect'])){
                        $value = AlatfingerM::model()->updateAll(array('alat_aktif'=>false));
                        $result['success'] = true;
                        echo json_encode($result);
                        Yii::app()->end();
                    }
                }
                
		$model=new KPPresensiT('search');
                $model->tglpresensi = date('Y-m-d 00:00:00');
                $model->tglpresensi_akhir = date('Y-m-d 23:59:59');
//		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['KPPresensiT'])){
			$model->attributes=$_GET['KPPresensiT'];
                        $format = new MyFormatter();
                        $model->tglpresensi = $format->formatDateTimeForDb($model->tglpresensi);
                        $model->tglpresensi_akhir = $format->formatDateTimeForDb($model->tglpresensi_akhir);
                }

		$this->render('admin',array(
			'model'=>$model,
		));
	}
        
        public function actionInformasiPresensi()
	{
                
        if(!Yii::app()->user->getState('isotomatispresensi')){  //RND-7741
			if (Yii::app()->request->isAjaxRequest){
				if (isset($_GET['idAlat']) && !isset($_GET['disconnect'])){
					AlatfingerM::model()->updateAll(array('alat_aktif'=>false));
					$idAlat = $_GET['idAlat'];
					$value = AlatfingerM::model()->updateByPk($idAlat, array('alat_aktif'=>true));
					$result['success'] = $value;
					$result['data'] = AlatfingerM::model()->findByPk($idAlat)->attributes;                        
					$result['connection'] = ($this->connection($result['data']['ipfinger']) == false ? $this->connection($result['data']['ipfinger']) : true);
					$result['time'] = date('d M Y');
					echo json_encode($result);
					Yii::app()->end();
				} else if (isset($_GET['idAlat']) && isset($_GET['disconnect'])){
					$value = AlatfingerM::model()->updateAll(array('alat_aktif'=>false));
					$result['success'] = true;
					echo json_encode($result);
					Yii::app()->end();
				}
			}
		}
		$model=new KPPresensiT('search');
                $model->tglpresensi = date('Y-m-d');
                $model->tglpresensi_akhir = date('Y-m-d');
//		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['KPPresensiT'])){
			$model->attributes=$_GET['KPPresensiT'];
                        $format = new MyFormatter();
                        $model->tglpresensi = $format->formatDateTimeForDb($model->tglpresensi);
                        $model->tglpresensi_akhir = $format->formatDateTimeForDb($model->tglpresensi_akhir);
                        $model->kelompokpegawai_id = $_GET['KPPresensiT']['kelompokpegawai_id'];
                        $model->jabatan_id = $_GET['KPPresensiT']['jabatan_id'];
                }

		$this->render('informasi',array(
			'model'=>$model,
		));
	}
        
        
        public function actionAmbilData(){
            if (Yii::app()->request->isAjaxRequest){
                if (isset($_POST['ip'],$_POST['key'])){
                    $key = $_POST['key'];
                    $ip = $_POST['ip'];
                }
                $result = $this->retrieveData($ip,$key);
                if (is_array($result)){
                    $insert = $this->insertPerdetik($result);
                    if($insert == true){
                        $this->deleteAllData($ip,$key);
                    }
                    echo $insert;
                }
                else{
                    echo true;
                }
                Yii::app()->end();
            }
        }
        
        private function connection($ip){
            $result = false;
            if (fsockopen($ip, "80", $errno, $errstr, 1)){
                $result = fsockopen($ip, "80", $errno, $errstr, 1);
            }
            return $result;
        }
        
        protected function retrieveData($ip, $key){
            //110.136.158.153 224 192.168.1.150 SUPERUSERBSS
            
            $Connect = $this->connection($ip);
            if($Connect){
                $soap_request="<GetAttLog><ArgComKey xsi:type=\"xsd:integer\">".$key."</ArgComKey><Arg><PIN xsi:type=\"xsd:integer\">All</PIN></Arg></GetAttLog>";
                $newLine="\r\n";
                fputs($Connect, "POST /iWsService HTTP/1.0".$newLine);
                fputs($Connect, "Content-Type: text/xml".$newLine);
                fputs($Connect, "Content-Length: ".strlen($soap_request).$newLine.$newLine);
                fputs($Connect, $soap_request.$newLine);
                $buffer="";
                while($Response=fgets($Connect, 1024)){
                        $buffer=$buffer.$Response;
                }
                $buffer=$this->ParseData($buffer,"<GetAttLogResponse>","</GetAttLogResponse>");
                $buffer=explode("\r\n",$buffer);

                
                $result = array();
                for($a=0;$a<count($buffer);$a++){
                    $data=$this->ParseData($buffer[$a],"<Row>","</Row>");
                    $hasil = $this->ParseData($data,"<PIN>","</PIN>");
                    if (!empty($hasil)){
                        $result[$a]['pin']=$this->ParseData($data,"<PIN>","</PIN>");
                        $result[$a]['date']=$this->ParseData($data,"<DateTime>","</DateTime>");
                        $result[$a]['verified']=$this->ParseData($data,"<Verified>","</Verified>");
                        $result[$a]['status']=$this->ParseData($data,"<Status>","</Status>");
                    }
                }
                if (count($result) == 0){
                    $result = false;
                }
                return $result;
            }else{
                return false;
            }
        }
        
        protected function insertPerdetik($result){
//            $data = $this->retrieveData();
            if (count($result) > 0){
                $transaction = Yii::app()->db->beginTransaction();
                $user_id = Yii::app()->user->id;
                try{
                    $counter = 0;
                    $jumlah = 0;
                    foreach ($result as $i=>$row){
                        $pegawai = PegawaiM::model()->findByAttributes(array('nofingerprint'=>$row['pin']));
                        if (count($pegawai) == 1){

                            $jumlah++;
                            $model = new PresensiT();
                            $model->tglpresensi = $row['date'];
                            $model->no_fingerprint = $row['pin'];
                            $model->statusscan_id = $row['status'];
                            if($row['status'] == 0)
                            {
                                $model->statusscan_id = 5;
                            }
//                            $model->verifikasi = $row['verified'];
                            $model->pegawai_id = $pegawai->pegawai_id;
                            $model->create_time = date('Y-m-d H:i:s');
                            $model->statuskehadiran_id = 1;
                            $model->create_loginpemakai_id = $user_id;
                            if ($model->save()){
                                $counter++;
                            }
                            else{
                                throw new Exception('Presensi '. $row['pin'] . ' - ' . $row['date'] .' gagal disimpan');
                            }
                        }
                        else{
                            throw new Exception('Pegawai dengan no finger print '. $row['pin'] . ' - ' . $row['date'] .' tidak ditemukan');
                        }
                    }
                    if (($jumlah == $counter) && ($counter != 0)){
                        $transaction->commit();
                        return true;
                    }
                    else{
                        throw new Exception("Jumlah yang di save tidak sesuai");
                    }
                } catch(Exception $ex){
                    echo $ex->getMessage();
                }
            }
        }
        
        protected function deleteAllData($ip, $key)
        {
            $Connect = $this->connection($ip);
            if ($Connect) {
                $soap_request = "<ClearData><ArgComKey xsi:type=\"xsd:integer\">" . $key . "</ArgComKey><Arg><Value xsi:type=\"xsd:integer\">3</Value></Arg></ClearData>";
                $newLine = "\r\n";
                fputs($Connect, "POST /iWsService HTTP/1.0" . $newLine);
                fputs($Connect, "Content-Type: text/xml" . $newLine);
                fputs($Connect, "Content-Length: " . strlen($soap_request) . $newLine . $newLine);
                fputs($Connect, $soap_request . $newLine);
                $buffer = "";
                while ($Response = fgets($Connect, 1024)) {
                    $buffer = $buffer . $Response;
                }
            }else
                echo "Koneksi Gagal";
            $buffer = $this->ParseData($buffer, "<Information>", "</Information>");
//            echo $buffer;
        }

        protected function ParseData($data,$p1,$p2){
            $data=" ".$data;
            $hasil="";
            $awal=strpos($data,$p1);
            if($awal!=""){
                    $akhir=strpos(strstr($data,$p1),$p2);
                    if($akhir!=""){
                            $hasil=substr($data,$awal+strlen($p1),$akhir-strlen($p1));
                    }
            }
            return $hasil;	
        }

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=KPPresensiT::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='kppresensi-t-form')
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
                //SAKabupatenM::model()->updateByPk($id, array('kabupaten_aktif'=>false));
                //$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}
        
        public function actionPrint()
        {
            $model= new KPPresensiT;
            $model->attributes=$_REQUEST['KPPresensiT'];
            $judulLaporan='Data Presensi';
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
        
        public function actionGetDataPegawai()
        {
            if(Yii::app()->request->isAjaxRequest){
                $format = new MyFormatter();
                $data = PegawaiM::model()->findByAttributes(array('pegawai_id'=>$_POST['idPegawai']));
                if(file_exists(Params::urlPegawaiTumbsDirectory().'kecil_'.$data->photopegawai)){
                    $photopegawai= Params::urlPegawaiTumbsDirectory().'kecil_'.$data->photopegawai;
                } else {
                    $photopegawai=  Params::urlPegawaiTumbsDirectory().'no_photo.jpeg';
                }
                $post = array(
                    'nomorindukpegawai'=>$data->nomorindukpegawai,
                    'nofingerprint'=>$data->nofingerprint,
                    'pegawai_id'=>$data->pegawai_id,
                    'nama_pegawai'=>$data->nama_pegawai,
                    'tempatlahir_pegawai'=>$data->tempatlahir_pegawai,
                    'tgl_lahirpegawai' => $format->formatDateTimeForUser($data->tgl_lahirpegawai),
                    'jabatan_nama'=> (isset($data->jabatan->jabatan_nama) ? $data->jabatan->jabatan_nama : ''),
                    'pangkat_nama'=> (isset($data->pangkat->pangkat_nama) ? $data->pangkat->pangkat_nama : ''),
                    'kategoripegawai'=>$data->kategoripegawai,
                    'kategoripegawaiasal'=>$data->kategoripegawaiasal,
                    'kelompokpegawai_nama'=> (isset($data->kelompokpegawai->kelompokpegawai_nama) ? $data->kelompokpegawai->kelompokpegawai_nama : ''),
                    'pendidikan_nama'=> (isset($data->pendidikan->pendidikan_nama) ? $data->pendidikan->pendidikan_nama : ''),
                    'jeniskelamin'=>$data->jeniskelamin,
                    'statusperkawinan'=>$data->statusperkawinan,
                    'alamat_pegawai'=>$data->alamat_pegawai,
                    'photopegawai'=>$photopegawai,
                );
                echo CJSON::encode($post);
                Yii::app()->end();
            }
        }
        
        /**
        * untuk print data penjualan dokter
        */
       public function actionPrintPresensi($presensi_id,$caraPrint = null) 
       {
           $format = new MyFormatter;    
           $model = KPPresensiT::model()->findByPk($presensi_id);     
           $modPegawai = KPRegistrasifingerprint::model()->findByAttributes(array('pegawai_id'=>$model->pegawai_id));

           $judul_print = 'Presensi Pegawai';
           $caraPrint = isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null;
           if (isset($_GET['frame'])){
               $this->layout='//layouts/iframe';
           }
           if($caraPrint=='PRINT') {
               $this->layout='//layouts/printWindows';
           }
           else if($caraPrint=='EXCEL') {
               $this->layout='//layouts/printExcel';
           }

           $this->render('_print', array(
                   'format'=>$format,
                   'judul_print'=>$judul_print,
                   'model'=>$model,
                   'modPegawai'=>$modPegawai,
                   'caraPrint'=>$caraPrint
           ));
       }     
}
