<?php

class PesanmenudietTController extends MyAuthController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column1';
	public $defaultAction = 'admin';
	protected $path_view = 'gizi.views.pesanmenudietT.';

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
	public function actionIndex($id = null)
	{
                
		$model=new GZPesanmenudietT;
		$model->tglpesanmenu = date('d M Y H:i:s');
		$model->nopesanmenu = MyGenerator::noPesanMenuDiet();
		
                //$p = PegawaiM::model()->findByPK(LoginpemakaiK::model()->findByPk(Yii::app()->user->id);
                $pegawai_nama = ""; //PegawaiM::model()->findByPK(LoginpemakaiK::model()->findByPk(Yii::app()->user->id)->pegawai_id)->nama_pegawai;
		$model->jenispesanmenu = Params::JENISPESANMENU_PASIEN;
		$model->kelaspelayanan_id = Params::KELASPELAYANAN_ID_TANPA_KELAS;
		$model->carabayar_id = Params::CARABAYAR_ID_MEMBAYAR;
		$model->penjamin_id = Params::PENJAMIN_ID_UMUM;
		$model->instalasi_id = Yii::app()->user->getState('instalasi_id');
		$model->ruangan_id = Yii::app()->user->getState('ruangan_id');
                $model->nama_pemesan = Yii::app()->user->getState('nama_pegawai');

		$nama_modul = Yii::app()->controller->module->id;
                $nama_controller = Yii::app()->controller->id;
                $nama_action = Yii::app()->controller->action->id;
                $modul_id = ModulK::model()->findByAttributes(array('url_modul'=>$nama_modul))->modul_id;
                $criteria = new CDbCriteria;
                $criteria->compare('modul_id',$modul_id);
                $criteria->compare('LOWER(modcontroller)',strtolower($nama_controller),true);
                $criteria->compare('LOWER(modaction)',strtolower($nama_action),true);
                if(isset($_POST['tujuansms'])){
                    $criteria->addInCondition('tujuansms',$_POST['tujuansms']);
                }
                $modSmsgateway = SmsgatewayM::model()->findAll($criteria);

                if(isset($id)){
                        if(!empty($id))
                                $model = GZPesanmenudietT::model()->findByPk($id);
                }

                        if(isset($_POST['GZPesanmenudietT']))
                        {
                                $model->attributes=$_POST['GZPesanmenudietT'];
                                $model->jenispesanmenu = Params::JENISPESANMENU_PASIEN;
                                // $model->nama_pemesan = $pegawai_nama;
                                $model->nopesanmenu = MyGenerator::noPesanMenuDiet();
                                $model->create_loginpemakai_id = Yii::app()->user->id;
                                $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
                                $model->create_time = date('Y-m-d');
                                $transaction = Yii::app()->db->beginTransaction();
                                try{
                                        $success = true;
                                        if($model->validate() && $model->save()){
                                                foreach($_POST['PesanmenudetailT'] as $i=>$v){
                                                        if ($v['checkList'] == 1){
                                                                foreach($v['menudiet_id'] as $j=>$x){
                                                                        if (!empty($x)){
                                                                                $modDetail = new GZPesanmenudetailT();
                                                                                $modDetail->attributes = $v;
                                                                                $modDetail->pesanmenudiet_id = $model->pesanmenudiet_id;
                                                                                $modDetail->jeniswaktu_id = $j;
                                                                                $modDetail->menudiet_id = $x;
                                                                                if ($modDetail->save()){
                                                                                        // SMS GATEWAY
                                                $modPasien = $modDetail->pasien;
                                                $modRuangan = $model->ruangan;
                                                $sms = new Sms();
                                                /*
                                                foreach ($modSmsgateway as $i => $smsgateway) {
                                                    $isiPesan = $smsgateway->templatesms;

                                                    $attributes = $modPasien->getAttributes();
                                                    foreach($attributes as $attributes => $value){
                                                        $isiPesan = str_replace("{{".$attributes."}}",$value,$isiPesan);
                                                    }
                                                    $attributes = $modDetail->getAttributes();
                                                    foreach($attributes as $attributes => $value){
                                                        $isiPesan = str_replace("{{".$attributes."}}",$value,$isiPesan);
                                                    }
                                                    $attributes = $model->getAttributes();
                                                    foreach($attributes as $attributes => $value){
                                                        $isiPesan = str_replace("{{".$attributes."}}",$value,$isiPesan);
                                                    }
                                                    $attributes = $modRuangan->getAttributes();
                                                    foreach($attributes as $attributes => $value){
                                                        $isiPesan = str_replace("{{".$attributes."}}",$value,$isiPesan);
                                                    }
                                                    $isiPesan = str_replace("{{hari}}",MyFormatter::getDayName($model->tglpesanmenu),$isiPesan);
                                                    $isiPesan = str_replace("{{nama_rumahsakit}}",Yii::app()->user->getState('nama_rumahsakit'),$isiPesan);

                                                    if($smsgateway->tujuansms == Params::TUJUANSMS_PASIEN && $smsgateway->statussms){
                                                        if(!empty($modPasien->no_mobile_pasien)){
                                                            $sms->kirim($modPasien->no_mobile_pasien,$isiPesan);
                                                        }
                                                    }

                                                }
                                                 * 
                                                 */
                                                // END SMS GATEWAY
                                                                                }
                                                                                else{
                                                                                        $success=false;
                                                                                }
                                                                        }
                                                                }
                                                        }
                                                }
                                        }
                                        else{
                                                $success = false;
                                        }
                                        if ($success == TRUE){
                                                $transaction->commit();
                                                $this->redirect(array('index','id'=>$model->pesanmenudiet_id));
                                                $this->refresh();
                                        }else{
                                                $transaction->rollback();
                                                Yii::app()->user->setFlash('error',"Data gagal disimpan ");
                                        }
                                }
                                catch(Exception $ex){
                                        $transaction->rollback();
                                        Yii::app()->user->setFlash('error',"Data gagal disimpan ".MyExceptionMessage::getMessage($ex,true));
                                }
                        }

                        $this->render($this->path_view.'index',array(
                                'model'=>$model,
                        ));
	}
	
	public function actionIndexPegawai($id = null)
	{                
		$model=new GZPesanmenudietT;
		$model->tglpesanmenu = date('d M Y H:i:s');
		$model->nopesanmenu = MyGenerator::noPesanMenuDiet();
		$pegawai_nama = ""; //PegawaiM::model()->findByPK(LoginpemakaiK::model()->findByPk(Yii::app()->user->id)->pegawai_id)->nama_pegawai;
		$model->nama_pemesan = $pegawai_nama;
		$model->kelaspelayanan_id = Params::KELASPELAYANAN_ID_TANPA_KELAS;
		$model->carabayar_id = Params::CARABAYAR_ID_MEMBAYAR;
		$model->penjamin_id = Params::PENJAMIN_ID_UMUM;
		$model->instalasi_id = Yii::app()->user->getState('instalasi_id');
		$model->ruangan_id = Yii::app()->user->getState('ruangan_id');

		$nama_modul = Yii::app()->controller->module->id;
        $nama_controller = Yii::app()->controller->id;
        $nama_action = Yii::app()->controller->action->id;
        $modul_id = ModulK::model()->findByAttributes(array('url_modul'=>$nama_modul))->modul_id;
        $criteria = new CDbCriteria;
        $criteria->compare('modul_id',$modul_id);
        $criteria->compare('LOWER(modcontroller)',strtolower($nama_controller),true);
        $criteria->compare('LOWER(modaction)',strtolower($nama_action),true);
        if(isset($_POST['tujuansms'])){
            $criteria->addInCondition('tujuansms',$_POST['tujuansms']);
        }
        $modSmsgateway = SmsgatewayM::model()->findAll($criteria);

        if(isset($id)){
        	if(!empty($id))
        		$model = GZPesanmenudietT::model()->findByPk($id);
        }
		
		if(isset($_POST['GZPesanmenudietT']))
		{    
			$model->attributes=$_POST['GZPesanmenudietT'];
			$model->jenispesanmenu = $_POST['jenisPesan'];			
			$model->create_loginpemakai_id = Yii::app()->user->getState('pegawai_id');
			$model->create_ruangan = Yii::app()->user->getState('ruangan_id');
			$model->create_time = date('Y-m-d');
			$transaction = Yii::app()->db->beginTransaction();
			try{
				$success = true;
				$jumlah = count($_POST['PesanmenupegawaiT']);  
				$ruangan = array();
				$tempRuangan = array();
				for ($i = 0; $i < $jumlah; $i++) {       
					foreach ($_POST['PesanmenupegawaiT'][$i] as $x=>$v){
						if (in_array($x, $ruangan)){
							array_push($tempRuangan[$x], $v);
						}else{
							$ruangan[] = $x;
							$tempRuangan[$x] = array($v);
						}
					}
				}
				foreach($tempRuangan as $i=>$baris){
					$models = new GZPesanmenudietT();
					$models->attributes = $model->attributes;
					$models->create_loginpemakai_id = Yii::app()->user->getState('pegawai_id');
					$models->create_ruangan = Yii::app()->user->getState('ruangan_id');
					$models->create_time = date('Y-m-d');
					$models->nopesanmenu = MyGenerator::noPesanMenuDiet();
					$models->totalpesan_org = count($baris);
					$models->ruangan_id = $i;
					if ($models->save()){
						foreach ($baris as $row){
							foreach ($row['menudiet_id'] as $j=>$v){
								if ($row['checkList'] == 1){
									if (!empty($v)){
										$modDetail = new PesanmenupegawaiT();
										$modDetail->attributes = $row;
										$modDetail->pesanmenudiet_id = $models->pesanmenudiet_id;
										$modDetail->jeniswaktu_id = $j;
										$modDetail->menudiet_id = $v;
										if ($modDetail->save()){
											// SMS GATEWAY
                                            $modPegawai = $modDetail->pegawai;
                                            $modRuangan = $model->ruangan;
                                            $sms = new Sms();
                                            foreach ($modSmsgateway as $i => $smsgateway) {
                                                $isiPesan = $smsgateway->templatesms;

                                                $attributes = $modPegawai->getAttributes();
                                                foreach($attributes as $attributes => $value){
                                                    $isiPesan = str_replace("{{".$attributes."}}",$value,$isiPesan);
                                                }
                                                $attributes = $modDetail->getAttributes();
                                                foreach($attributes as $attributes => $value){
                                                    $isiPesan = str_replace("{{".$attributes."}}",$value,$isiPesan);
                                                }
                                                $attributes = $model->getAttributes();
                                                foreach($attributes as $attributes => $value){
                                                    $isiPesan = str_replace("{{".$attributes."}}",$value,$isiPesan);
                                                }
                                                $attributes = $modRuangan->getAttributes();
                                                foreach($attributes as $attributes => $value){
                                                    $isiPesan = str_replace("{{".$attributes."}}",$value,$isiPesan);
                                                }
                                                $isiPesan = str_replace("{{hari}}",MyFormatter::getDayName($model->tglpesanmenu),$isiPesan);
                                                $isiPesan = str_replace("{{nama_rumahsakit}}",Yii::app()->user->getState('nama_rumahsakit'),$isiPesan);
                                                
                                                if($smsgateway->tujuansms == Params::TUJUANSMS_PEGAWAI && $smsgateway->statussms){
                                                    if(!empty($modPegawai->nomobile_pegawai)){
                                                        $sms->kirim($modPegawai->nomobile_pegawai,$isiPesan);
                                                    }
                                                }
                                                
                                            }
                                            // END SMS GATEWAY
										}
										else{
											$success=false;
										}
									}
								}
							}
						}                             
					}
					else{
						 $success = FALSE;
					}
				}
				if ($success == TRUE){
					$transaction->commit();
//					Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
					 $this->redirect(array('indexPegawai','id'=>$model->pesanmenudiet_id));
					$this->refresh();
				}else{
					$transaction->rollback();
					Yii::app()->user->setFlash('error',"Data gagal disimpan ");
				}
			}
			catch(Exception $ex){
				$transaction->rollback();
				Yii::app()->user->setFlash('error',"Data gagal disimpan ".MyExceptionMessage::getMessage($ex,true));
			}
		}

		$this->render($this->path_view.'indexPegawai',array(
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
                //if(!Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		

		if(isset($_POST['GZPesanmenudietT']))
		{
			$model->attributes=$_POST['GZPesanmenudietT'];
			if($model->save()){
                                Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
				$this->redirect(array('view','id'=>$model->pesanmenudiet_id));
                        }
		}

		$this->render($this->path_view.'update',array(
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
	 * Manages all models.
	 */
	public function actionAdmin()
	{
                
		$model=new GZPesanmenudietT('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['GZPesanmenudietT']))
			$model->attributes=$_GET['GZPesanmenudietT'];

		$this->render($this->path_view.'admin',array(
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
		$model=GZPesanmenudietT::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='gzpesanmenudiet-t-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	public function actionPrint($id, $caraprint=null)
	{
		$modPesan= new GZPesanmenudietT;
		
		$modPesan = PesanmenudietT::model()->findByPk($id);
		if ($modPesan->jenispesanmenu == Params::JENISPESANMENU_PASIEN){
			$criteria = new CDbCriteria();
			$criteria->select = 'pasienadmisi_id, pendaftaran_id, pasien_id,  pesanmenudiet_id, jml_pesan_porsi, satuanjml_urt,menudiet_id';
			$criteria->group = 'pasienadmisi_id, pendaftaran_id, pasien_id, pesanmenudiet_id, jml_pesan_porsi, satuanjml_urt,menudiet_id';
			$criteria->compare('pesanmenudiet_id', $id);
			$modDetailPesan = PesanmenudetailT::model()->findAll($criteria);
		}
		else{
			$criteria = new CDbCriteria();
			$criteria->select = 'pegawai_id,  pesanmenudiet_id, jml_pesan_porsi, satuanjml_urt,menudiet_id';
			$criteria->group = 'pegawai_id, pesanmenudiet_id, jml_pesan_porsi, satuanjml_urt,menudiet_id';
			$criteria->compare('pesanmenudiet_id', $id);
			$modDetailPesan = PesanmenupegawaiT::model()->findAll($criteria);
		}
		
		$judulLaporan='Pemesanan Menu Diet';
		$caraprint=$caraprint;
		if($caraprint=='PRINT') {
			$this->layout='//layouts/printWindows';
			$this->render($this->path_view.'detailInformasi',array('modPesan'=>$modPesan,'modDetailPesan'=>$modDetailPesan,'judulLaporan'=>$judulLaporan,'caraprint'=>$caraprint));
		}
		else if($caraprint=='EXCEL') {
			$this->layout='//layouts/printExcel';
			$this->render($this->path_view.'detailInformasi',array('modPesan'=>$modPesan,'modDetailPesan'=>$modDetailPesan,'judulLaporan'=>$judulLaporan,'caraprint'=>$caraprint));
		}
		else if($caraprint=='PDF') {
			$ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
			$posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
			$mpdf = new MyPDF('',$ukuranKertasPDF); 
			$mpdf->useOddEven = 2;  
			$stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
			$mpdf->WriteHTML($stylesheet,1);  
			$mpdf->AddPage($posisi,'','','','',15,15,15,15,15,15);
			$mpdf->WriteHTML($this->renderPartial($this->path_view.'detailInformasi',array('modPesan'=>$modPesan,'modDetailPesan'=>$modDetailPesan,'judulLaporan'=>$judulLaporan,'caraprint'=>$caraprint),true));
			$mpdf->Output();
		}                       
	}
        
	public function actionInformasi()
	{
		$model=new GZPesanmenudietT('searchInformasi');
		$model->tgl_awal = date('d M Y');
		$model->tgl_akhir = date('d M Y');
		
		if (Yii::app()->user->getState('ruangan_id') != Params::RUANGAN_ID_GIZI) {
			$model->ruangan_id = Yii::app()->user->getState('ruangan_id');
		}
		
		if(isset($_GET['GZPesanmenudietT'])){
			$model->attributes=$_GET['GZPesanmenudietT'];
			$format = new MyFormatter();
			$model->tgl_awal = $format->formatDateTimeForDb($_GET['GZPesanmenudietT']['tgl_awal']);
			$model->tgl_akhir = $format->formatDateTimeForDb($_GET['GZPesanmenudietT']['tgl_akhir']);
			if (isset($_GET['GZPesanmenudietT']['ruangan_id'])) $model->ruangan_id = $_GET['GZPesanmenudietT']['ruangan_id'];
		}

		$this->render($this->path_view.'informasi',array(
			'model'=>$model,
		));
	}
        
	public function actionDetailPesanMenuDiet($id){
		$this->layout = '//layouts/iframe';
		
		$modPesan = PesanmenudietT::model()->findByPk($id);
		if ($modPesan->jenispesanmenu == Params::JENISPESANMENU_PASIEN){
			$criteria = new CDbCriteria();
			$criteria->select = 'pasienadmisi_id, pendaftaran_id, pasien_id,  pesanmenudiet_id, jml_pesan_porsi, satuanjml_urt,menudiet_id';
			$criteria->group = 'pasienadmisi_id, pendaftaran_id, pasien_id, pesanmenudiet_id, jml_pesan_porsi, satuanjml_urt,menudiet_id';
			$criteria->compare('pesanmenudiet_id', $id);
			$modDetailPesan = PesanmenudetailT::model()->findAll($criteria);
		}
		else{
			$criteria = new CDbCriteria();
			$criteria->select = 'pegawai_id,  pesanmenudiet_id, jml_pesan_porsi, satuanjml_urt,menudiet_id';
			$criteria->group = 'pegawai_id, pesanmenudiet_id, jml_pesan_porsi, satuanjml_urt,menudiet_id';
			$criteria->compare('pesanmenudiet_id', $id);
			$modDetailPesan = PesanmenupegawaiT::model()->findAll($criteria);
		}
		$this->render($this->path_view.'detailInformasi', array(
			'modPesan'=>$modPesan,
			'modDetailPesan'=>$modDetailPesan,
		));
	}
        
	/**
	 * actionAjax untuk mengambil menudiet
	 */
	public function actionGetMenuDietDetail(){
		if (Yii::app()->request->isAjaxRequest){
			$pasien_id = (isset($_POST['pasien_id']) ? $_POST['pasien_id'] : null);
			$pendaftaran_id = (isset($_POST['pendaftaran_id']) ? $_POST['pendaftaran_id'] : null);
			$pasienadmisi_id =  (isset($_POST['pasienadmisi_id']) ? $_POST['pasienadmisi_id'] : null);
			$menudiet_id =  (isset($_POST['menudiet_id']) ? $_POST['menudiet_id'] : null);
			$ruangan_id = (isset($_POST['ruangan_id']) ? $_POST['ruangan_id'] : null);
			$instalasi_id = (isset($_POST['instalasi_id']) ? $_POST['instalasi_id'] : null);
			$kelaspelayanan_id = (isset($_POST['kelaspelayanan_id']) ? $_POST['kelaspelayanan_id'] : null);

			$urt = $_POST['urt'];
			$jumlah = $_POST['jumlah'];
			$jeniswaktu = $_POST['jeniswaktu'];
			$pendaftaranId =  (isset($_POST['pendaftaranId']) ? $_POST['pendaftaranId'] : null);
			$pasienAdmisi =  (isset($_POST['pasienAdmisi']) ? $_POST['pasienAdmisi'] : null);
			$modDetail = new PesanmenudetailT();
			$modJenisWaktu = JeniswaktuM::model()->findAll('jeniswaktu_aktif = true');
			$diet = MenuDietM::model()->findByPK($menudiet_id);
			$jumlahPasien = count($pasienAdmisi);
			if ($jumlahPasien == 0){
				$jumlahPasien = 1;
			}
			$tr = '';
			for($i = 0; $i < $jumlahPasien; $i++) {
			$modDetail = new PesanmenudetailT();
				if (empty($pasienAdmisi)) {
					$model = InfokunjunganriV::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id, 'ruangan_id' => $ruangan_id, 'pasienadmisi_id' => $pasienadmisi_id));
				} else {
					$model = InfokunjunganriV::model()->findByAttributes(array('pendaftaran_id' => $pendaftaranId[$i], 'ruangan_id' => $ruangan_id, 'pasienadmisi_id' => $pasienAdmisi[$i]));
	//                    echo print_r($model->attributes);
	//                    exit();
				}
				$tr .= '<tr>
						<td>'
	//                            .CHtml::activeHiddenField($modDetail, '[]ruangan_id',array('value'=>$model->ruangan_id))
							.CHtml::checkBox('PesanmenudetailT[][checkList]',true, array('class'=>'cekList','onclick'=>'hitungSemua()'))
							.CHtml::activeHiddenField($modDetail, '[]pendaftaran_id', array('value'=>$model->pendaftaran_id))
							.CHtml::activeHiddenField($modDetail, '[]pasien_id', array('value'=>$model->pasien_id))
							.CHtml::activeHiddenField($modDetail, '[]pasienadmisi_id', array('value'=>$model->pasienadmisi_id))
						.'</td>
						<td>'.RuanganM::model()->with('instalasi')->findByPk($ruangan_id)->instalasi->instalasi_nama.'</td>
						<td>'.$model->ruangan_nama.'/<br/>'.$model->no_pendaftaran.'</td>
						<td>'.$model->no_rekam_medik.'/<br/>'.$model->nama_pasien.'</td>
						<td>'.$model->umur.'</td>
						<td>'.$model->jeniskelamin.'</td>';
				foreach ($modJenisWaktu as $v){
					if (in_array($v->jeniswaktu_id, $jeniswaktu)){
						$tr .='<td>'.CHtml::hiddenField('PesanmenudetailT[][jeniswaktu_id]['.$v->jeniswaktu_id.']', $v->jeniswaktu_id )
					   .CHtml::dropDownList('PesanmenudetailT[][menudiet_id]['.$v->jeniswaktu_id.']', '', Chtml::listData(MenuDietM::model()->findAll(), 'menudiet_id', 'menudiet_nama'), array('empty'=>'-- Pilih --', 'class'=>'span2 menudiet', 'options'=>array("$menudiet_id"=>array("selected"=>"selected")))).'</td>';
					}else{
						$tr .='<td>'.CHtml::hiddenField('PesanmenudetailT[][jeniswaktu_id]['.$v->jeniswaktu_id.']', $v->jeniswaktu_id )
					   .CHtml::dropDownList('PesanmenudetailT[][menudiet_id]['.$v->jeniswaktu_id.']', '', Chtml::listData(MenuDietM::model()->findAll(), 'menudiet_id', 'menudiet_nama'), array('empty'=>'-- Pilih --', 'class'=>'span2 menudiet', )).'</td>';
					}
				}
				 $tr .='<td>'.CHtml::activeTextField($modDetail, '[]jml_pesan_porsi', array('value'=>$jumlah, 'class'=>' span1 numbersOnly', 'style'=>'text-align: right;')).'</td>
						<td>'.CHtml::activeDropDownList($modDetail, '[]satuanjml_urt', LookupM::getItems('ukuranrumahtangga'), array('empty'=>'-- Pilih --', 'class'=>'span2 urt', 'options'=>array("$urt"=>array("selected"=>"selected")))).'</td>
						</tr>';
			}

			echo json_encode($tr);
			Yii::app()->end();
		}
	}
        
	//-- Gizi -- 
	//Get List Jenis Diet untuk Pemesanan Menu Diet
	public function actionJenisDiet()
	{
		if(Yii::app()->request->isAjaxRequest) {
			$criteria = new CDbCriteria();
			$criteria->compare('LOWER(jenisdiet_nama)', strtolower($_GET['term']), true);
			$criteria->order = 'jenisdiet_id';
			$models = JenisdietM::model()->findAll($criteria);
			$returnVal = array();
			foreach($models as $i=>$model)
			{
				$attributes = $model->attributeNames();
				foreach($attributes as $j=>$attribute) {
					$returnVal[$i]["$attribute"] = $model->$attribute;
				}
				$returnVal[$i]['label'] = $model->jenisdiet_nama;
				$returnVal[$i]['value'] = $model->jenisdiet_id;
			}

			echo CJSON::encode($returnVal);
		}
		Yii::app()->end();
	}
        
	//-- Gizi -- 
	//Get List Pasien untuk Pemesanan Menu Diet
	public function actionPasienUntukMenuDiet()
	{
		if(Yii::app()->request->isAjaxRequest) {
			$ruangan_id = $_GET['ruangan_id'];
			if (!empty($ruangan_id)){
				$criteria = new CDbCriteria();
//                $criteria->with =array('pasien', 'ruangan');  
				$criteria->compare('LOWER(nama_pasien)', strtolower($_GET['term']), true);
				if (!empty($ruangan_id)){
					$criteria->compare('ruangan_id',$ruangan_id);
				}
				$criteria->order = 'nama_pasien';
				$models = InfokunjunganriV::model()->findAll($criteria);
				$returnVal = array();
				foreach($models as $i=>$model)
				{
					$attributes = $model->attributeNames();
					foreach($attributes as $j=>$attribute) {
						$returnVal[$i]["$attribute"] = $model->$attribute;
					}
					$modJenisTarif = JenistarifpenjaminM::model()->find('penjamin_id = '.$model->penjamin_id);
					$returnVal[$i]['label'] = $model->no_rekam_medik.' - '.$model->nama_pasien.' - '.$model->ruangan_nama;
					$returnVal[$i]['value'] = $model->pasien_id;
					$returnVal[$i]['jenistarif_id'] = isset($modJenisTarif->jenistarif_id) ? $modJenisTarif->jenistarif_id : null;
				}

				echo CJSON::encode($returnVal);
			}
		}
		Yii::app()->end();
	}
	//-- Gizi -- 
	//Get List Menu Diet untuk Pemesanan Menu Diet
	public function actionMenuDiet()
	{
		if(Yii::app()->request->isAjaxRequest) {
                        $penjamin_id;
                        if (isset($_GET['penjamin_id'])) {
                            $penjamin_id = $_GET['penjamin_id'];
                        }
                        
                        $jt = JenistarifpenjaminM::model()->findByAttributes(array(
                            'penjamin_id'=>$penjamin_id
                        ));
                    
			$criteria = new CDbCriteria();
			$criteria->compare('LOWER(t.menudiet_nama)', strtolower($_GET['term']), true);
			if(!empty($_GET['kelaspelayanan_id'])){
				$criteria->compare('tariftindakan_m.kelaspelayanan_id', $_GET['kelaspelayanan_id']);
			}
                        if (!empty($_GET['jenisdiet_id'])) {
                                $criteria->compare('t.jenisdiet_id', $_GET['jenisdiet_id']);
                        }
                        if (!empty($penjamin_id)) {
                                $criteria->compare('tariftindakan_m.jenistarif_id', $jt->jenistarif_id);
                        }
			$criteria->order = 't.menudiet_nama';
			$criteria->join = 'JOIN tariftindakan_m on tariftindakan_m.daftartindakan_id = t.daftartindakan_id
							   JOIN kelaspelayanan_m on kelaspelayanan_m.kelaspelayanan_id = tariftindakan_m.kelaspelayanan_id'; 
			$criteria->addCondition('tariftindakan_m.komponentarif_id = 6');
                        $criteria->limit = 5;
			$models = MenuDietM::model()->findAll($criteria);
			$returnVal = array();
			foreach($models as $i=>$model)
			{
				$attributes = $model->attributeNames();
				foreach($attributes as $j=>$attribute) {
					$returnVal[$i]["$attribute"] = $model->$attribute;
				}
				$returnVal[$i]['label'] = $model->menudiet_nama;
				$returnVal[$i]['value'] = $model->menudiet_id;
			}

			echo CJSON::encode($returnVal);
		}
		Yii::app()->end();
	}
        
	//-- Gizi -- 
	//Get List Bahan Diet untuk Pemesanan Menu Diet
	public function actionBahanDiet()
	{
		if(Yii::app()->request->isAjaxRequest) {
			$criteria = new CDbCriteria();
			$criteria->compare('LOWER(bahandiet_nama)', strtolower($_GET['term']), true);
			$criteria->order = 'bahandiet_id';
			$models = BahandietM::model()->findAll($criteria);
			$returnVal = array();
			foreach($models as $i=>$model)
			{
				$attributes = $model->attributeNames();
				foreach($attributes as $j=>$attribute) {
					$returnVal[$i]["$attribute"] = $model->$attribute;
				}
				$returnVal[$i]['label'] = $model->bahandiet_nama;
				$returnVal[$i]['value'] = $model->bahandiet_id;
			}

			echo CJSON::encode($returnVal);
		}
		Yii::app()->end();
	}
	
	// ajax untuk mengambil menu diet pegawai
	public function actionGetMenuDietPegawai(){
        if (Yii::app()->request->isAjaxRequest){
			$modDetail = new PesanmenupegawaiT();
			
            $pegawai_id = (isset($_POST['pegawai_id']) ? $_POST['pegawai_id'] : Yii::app()->user->getState('pegawai_id'));
            $menudiet_id = (isset($_POST['menudiet_id']) ? $_POST['menudiet_id'] : null);
            $ruangan_id = (isset($_POST['ruangan_id']) ? $_POST['ruangan_id'] : null);
            $instalasi_id = (isset($_POST['instalasi_id']) ? $_POST['instalasi_id'] : null);
            
            $urt = $_POST['urt'];
            $jumlah = $_POST['jumlah'];
            $jeniswaktu = $_POST['jeniswaktu'];            
            $pegawaiId = (isset($_POST['pegawaiId']) ? $_POST['pegawaiId'] : null);
            
            $jumlahPesan = count($pegawaiId);
            if ($jumlahPesan < 1) {
                $pegawaiId = array($pegawai_id);
            }
            $tr = '';
            foreach ($pegawaiId as $i=>$pegawai_id) {                
                $model = PegawaiM::model()->findByPk($pegawai_id);
                $nama = $model->nama_pegawai;
                $jeniskelamin = $model->jeniskelamin;
                $tr .= '<tr>
                        <td>'
                        . CHtml::checkBox('PesanmenupegawaiT[][' . $ruangan_id . '][checkList]', true, array('class' => 'cekList', 'onclick' => 'hitungSemua()'))
                        . CHtml::activeHiddenField($modDetail, '[][' . $ruangan_id . ']pegawai_id', array('value' => $model->pegawai_id))
                        . CHtml::hiddenField('PesanmenupegawaiT[][' . $ruangan_id . '][ruangan_id]', $ruangan_id)
                        . '</td>
                        <td>' . RuanganM::model()->with('instalasi')->findByPk($ruangan_id)->instalasi->instalasi_nama . '/<br/>' . RuanganM::model()->findByPk($ruangan_id)->ruangan_nama . '</td>
                        <td>' . CHtml::textField('nama', $nama, array('readonly' => true, 'class' => 'span2 nama')) . '</td>
                        <td>' . $jeniskelamin . '</td>';
					foreach (JeniswaktuM::getJenisWaktu() as $v) {
						if (in_array($v->jeniswaktu_id, $jeniswaktu)) {
							$tr .='<td>' . CHtml::hiddenField('PesanmenupegawaiT[][' . $ruangan_id . '][jeniswaktu_id][' . $v->jeniswaktu_id . ']', $v->jeniswaktu_id)
									. CHtml::dropDownList('PesanmenupegawaiT[][' . $ruangan_id . '][menudiet_id][' . $v->jeniswaktu_id . ']', '', Chtml::listData(MenuDietM::model()->findAll(), 'menudiet_id', 'menudiet_nama'), array('empty' => '-- Pilih --', 'class' => 'span2 menudiet', 'options' => array($menudiet_id => array("selected" => "selected")))) . '</td>';
						} else {
							$tr .='<td>' . CHtml::hiddenField('PesanmenupegawaiT[][' . $ruangan_id . '][jeniswaktu_id][' . $v->jeniswaktu_id . ']', $v->jeniswaktu_id)
									. CHtml::dropDownList('PesanmenupegawaiT[][' . $ruangan_id . '][menudiet_id][' . $v->jeniswaktu_id . ']', '', Chtml::listData(MenuDietM::model()->findAll(), 'menudiet_id', 'menudiet_nama'), array('empty' => '-- Pilih --', 'class' => 'span2 menudiet',)) . '</td>';
						}
					}
                $tr .= '<td>' . CHtml::activeTextField($modDetail, '[][' . $ruangan_id . ']jml_pesan_porsi', array('value' => $jumlah, 'class' => ' span1 numbersOnly',)) . '</td>
                        <td>' . CHtml::activeDropDownList($modDetail, '[][' . $ruangan_id . ']satuanjml_urt', LookupM::getItems('ukuranrumahtangga'), array('empty' => '-- Pilih --', 'class' => 'span2 urt', 'options' => array($urt => array("selected" => "selected")))) . '</td>
                        </tr>';
            }
            echo json_encode($tr);
            Yii::app()->end();
        }
    }
	
	/**
	* set dropdown penjamin dari carabayar_id
	* @param type $encode
	* @param type $namaModel
	*/
	public function actionSetDropdownPenjamin($encode=false,$namaModel='')
	{
	   if(Yii::app()->request->isAjaxRequest) {
		   $carabayar_id = $_POST["$namaModel"]['carabayar_id'];
		  if($encode)
		  {
			   echo CJSON::encode($penjamin);
		  } else {
			   if(empty($carabayar_id)){
				   echo CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
			   } else {
				   $penjamin = PenjaminpasienM::model()->findAllByAttributes(array('carabayar_id'=>$carabayar_id), array('order'=>'penjamin_nama ASC'));
				   if(count($penjamin) > 1)
				   {
					   echo CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
				   }
				   $penjamin = CHtml::listData($penjamin,'penjamin_id','penjamin_nama');
				   foreach($penjamin as $value=>$name) {
					   echo CHtml::tag('option', array('value'=>$value),CHtml::encode($name),true);
				   }
			   }
		  }
	   }
	   Yii::app()->end();
	}
	/**
	* set dropdown ruangan dari instalasi_id
	* @param type $encode
	* @param type $namaModel
	*/
   public function actionSetDropdownRuangan($encode=false,$namaModel='')
   {
	   if(Yii::app()->request->isAjaxRequest) {
		   $instalasi_id = $_POST["$namaModel"]['instalasi_id'];
		  if($encode)
		  {
			   echo CJSON::encode($ruangan);
		  } else {
			   if(empty($instalasi_id)){
				   echo CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
			   } else {
				   $ruangan = RuanganM::model()->findAllByAttributes(array('instalasi_id'=>$instalasi_id, 'ruangan_aktif'=>true), array('order'=>'ruangan_nama ASC'));
				   if(count($ruangan) > 1)
				   {
					   echo CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
				   }
				   $ruangan = CHtml::listData($ruangan,'ruangan_id','ruangan_nama');
				   foreach($ruangan as $value=>$name) {
					   echo CHtml::tag('option', array('value'=>$value),CHtml::encode($name),true);
				   }
			   }
		  }
	   }
	   Yii::app()->end();
   }

   /*
    * untuk pembatalan pemesanan menu diet 
    */
	public function actionBatalMenuDiet(){
       if (Yii::app()->request->isAjaxRequest)
       {
        $idPesanDiet = $_POST['idPesanDiet'];
        $modelPesan = new PesanmenudietT;
        $model = PesanmenudietT::model()->findByPk($idPesanDiet);  
        $modDetail = PesanmenudetailT::model()->findAllByAttributes(array('pesanmenudiet_id'=>$model->pesanmenudiet_id));
        $modPegawai = PesanmenupegawaiT::model()->findAllByAttributes(array('pesanmenudiet_id'=>$model->pesanmenudiet_id));

        $totDet = count($modDetail);
        $totPeg = count($modPegawai);

         if(isset($_POST['PesanmenupegawaiT']) || isset($_POST['PesanmenudetailT'])){
           if(count($modDetail) > 0 || count($modPegawai) > 0){        
                   if(count($modPegawai) > 0){
                       // Untuk Menghapus Pesan Menu Diet untuk Pegawai
                    if (count($_POST['PesanmenupegawaiT']) > 0){
                       foreach($_POST['PesanmenupegawaiT'] as $i=>$v){
                       if (isset($v['checkList'])){
                               if(empty($v['kirimmenupegawai_id'])){
                                   $detail = false;
                               }else{
                                   $detail = true;
                                   $updatePesanPegawai = PesanmenupegawaiT::model()->updateByPk($v['pesanmenupegawai_id'],array('kirimmenupegawai_id'=>null));
                                   $updateKirimPegawai = KirimmenupegawaiT::model()->updateByPk($v['kirimmenupegawai_id'],array('pesanmenupegawai_id'=>null));
                                   if(count($modPegawai) <= 1){
                                       $updatePesanDiet = KirimmenudietT::model()->updateByPk($V['kirimmenudiet_id'],array('pesanmenudiet_id'=>null));
                                       $updateKirimDiet = PesanmenudietT::model()->updateByPk($idPesanDiet,array('kirimmenudiet_id'=>null));
                                   }
                               }

                           if($detail == true){
                               $deletePegawai = PesanmenupegawaiT::model()->deleteByPk($v['pesanmenupegawai_id']);                                                                          
                               if($updatePesanPegawai && $updatePesanDiet && $updateKirimPegawai && $updateKirimDiet){                                            
                                  $delete = true;
                               }else{
                                   $delete = false; 
                               }
                           }else{
                               $deletePegawai = PesanmenupegawaiT::model()->deleteByPk($v['pesanmenupegawai_id']);
                               if($deletePegawai){
                                   $delete = true;
                               }else{
                                   $delete = false;
                               }
                           }
                       $totPeg = count(PesanmenupegawaiT::model()->findAllByAttributes(array('pesanmenudiet_id'=>$idPesanDiet)));
                   }                
                  }
                  if($delete == true){
                       if($totPeg < 1){
                          PesanmenudietT::model()->deleteByPk($idPesanDiet);
                       }
                       echo CJSON::encode(array(
                           'status'=>'proses_form', 
                           'pesan'=>'Berhasil',
                           'keterangan'=>'',
                           'total'=>$totPeg,
                           'div'=>"<div class='flash-success'>Pemesanan Menu Diet <b></b> berhasil dibatalkan </div>",
                           ));
                       exit;  
                   }else{
                       echo CJSON::encode(array(
                           'status'=>'proses_form', 
                           'pesan'=>'Gagal',
                           'keterangan'=>'',
                           'total'=>$totPeg,
                           'div'=>"<div class='flash-success'>Pemesanan Menu Diet <b></b> gagal dibatalkan </div>",
                           ));
                       exit;  
                   }
                }
               }else{
                   if(count($_POST['PesanmenudetailT']) > 0){
                       $jml = 0;
                       foreach($_POST['PesanmenudetailT'] as $i=>$v){
                           if(isset($v['checkList'])){
   //                            foreach($modDetail as $i=>$detail){
                                   if(empty($v['kirimmenupasien_id'])){
                                       $details = false;
                                   }else{
                                       $details = true;
                                       $updatePesanPasien = PesanmenudetailT::model()->updateByPk($v['pesanmenudetail_id'],array('kirimmenupasien_id'=>null));                                            
                                       $updateKirimPasien = KirimmenupasienT::model()->updateByPk($v['kirimmenupasien_id'],array('pesanmenudetail_id'=>null));

                                       if(count($modDetail) <= 1){
                                            $updatePesanDiet = KirimmenudietT::model()->updateByPk($v['kirimenudiet_id'],array('pesanmenudiet_id'=>null));
                                            $updateKirimDiet = PesanmenudietT::model()->updateByPk($idPesanDiet,array('kirimmenudiet_id'=>null));
                                       }
                                   }
   //                            }
                       // Untuk Menghapus menu Gizi dari PesanmenudetailT                    
                       if($details == true){
                           $deleteDetail = PesanmenudetailT::model()->deleteByPk($v['pesanmenudetail_id']);
                           if($updatePesanPasien && $updatePesanDiet && $updateKirimPasien && $updateKirimDiet && $deleteDetail){
                               $tindakan = true;
                           }else{
                             $tindakan = false;
                           }
                       }else{
                           $deleteDetail = PesanmenudetailT::model()->deleteByPk($v['pesanmenudetail_id']);
                           if($deleteDetail){
                               $tindakan = true;
                           }else{
                             $tindakan = false;
                           }
                       } 
                           $jml++;
                           $totDet = count(PesanmenudetailT::model()->findAllByAttributes(array('pesanmenudiet_id'=>$idPesanDiet)));
                     }
                   }
                   if($tindakan == true){
                       if($totDet < 1){
                           PesanmenudietT::model()->deleteByPk($idPesanDiet);
                       }
                       // Untuk Menghapus Data Kirim Menu Diet dari PesanmenudietT
                       echo CJSON::encode(array(
                           'status'=>'proses_form', 
                           'pesan'=>'Berhasil',
                           'keterangan'=>'',
                           'total'=>$totDet,
                           'div'=>"<div class='flash-success'>Pemesanan Menu Diet <b></b> berhasil dibatalkan </div>",
                           ));
                       exit;
                   }else{
                       echo CJSON::encode(array(
                           'status'=>'proses_form', 
                           'pesan'=>'Gagal',
                           'keterangan'=>'',
                           'total'=>$totDet,
                           'div'=>"<div class='flash-success'>Pemesanan Menu Diet <b></b> gagal dibatalkan </div>",
                           ));
                       exit;
                   }
               }
             }
           }
       }
           echo CJSON::encode(array(
               'status'=>'create_form', 
               'idPesan'=>$idPesanDiet,
               'total'=>$totDet,
               'div'=>$this->renderPartial($this->path_view.'_formBatalPesanDiet', array('modelPesan'=>$modelPesan,'modDetail'=>$modDetail,'modPegawai'=>$modPegawai,'model'=>$model), true)));             
           exit;
     }
   }
}
