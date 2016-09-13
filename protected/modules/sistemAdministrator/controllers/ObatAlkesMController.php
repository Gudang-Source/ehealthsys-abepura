<?php

class ObatAlkesMController extends MyAuthController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
		public $layout='//layouts/column1';
		public $defaultAction = 'admin';
		public $path_view = 'sistemAdministrator.views.obatAlkesM.';
		
		public $successSaveObatAlkes=false;
		public $succesSaveModObatAlkesDetail=false;
		public $obatSupplierTersimpan=true;
		public $therapiObatTersimpan=true;
                
                public $lockJenis = false;
                public $defaultJenis;
		
		public function actionCekOtoritas()
		{
		   if(Yii::app()->request->isAjaxRequest) {
				$username=$_POST['username'];
				$password=md5($_POST['password']);
				$idLoginPemakai='null';
				$modLoginPemakai=  GFLoginPemakaiK::model()->find('nama_pemakai=\''.$username.'\' AND katakunci_pemakai=\''.$password.'\'');
				if($modLoginPemakai){//Jika Username dan Passwordnya Bnear
					if($this->checkAccess(array("loginpemakai_id"=>$modLoginPemakai->loginpemakai_id,"action"=>Params::DEFAULT_UPDATE))){
						$message = 'Supervisor';
						$idLoginPemakai=$modLoginPemakai->loginpemakai_id;
					}else{//Jika username yang dimasukan tidak mempunyai hak akses supervisor
						$message = 'Anda Tidak Diijinkan Untuk Mengubah Harga Obat';
					}
				}else{//Jika Usename atau password salah
						$message = 'Terjadi Kesalahan dan memasukan Username atau Password';
				}
				$data['message']=$message;
				$data['loginpemakai_id']=$idLoginPemakai;
				echo CJSON::encode($data);
			}
			Yii::app()->end();

		}
		
	  

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render($this->path_view.'view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new SAObatalkesM;
		$model->obatalkes_kode = '-Otomatis-';
		$model->harganetto = 0;
		$model->discount = 0;
		$model->ppn_persen = 10.00;
		$model->hargamaksimum = 0;
		$model->hargaminimum = 0;
		$model->hargaaverage = 0;
		$model->margin = 0;
		$model->hargajual = 0;
		$model->marginnonresep = 0;
		$model->hjanonresep = 0;
		$model->marginresep = 0;
		$model->jasadokter = 0;
		$model->hjaresep = 0;
                $model->ven = '';
                
                
                if (!empty($this->defaultJenis)) {
                    $model->jenisobatalkes_id = $this->defaultJenis;
                }

		$model->formObatAlkesDetail = true;
		$modObatAlkesDetail = new ObatalkesdetailM;
		$format = new MyFormatter();

				
		if(isset($_POST['SAObatalkesM']))
		{
			$transaction = Yii::app()->db->beginTransaction();
			try {
				$model->attributes=$_POST['SAObatalkesM'];
				$model->obatalkes_farmasi=TRUE;
				$model->activedate = date('Y-m-d');
				$model->create_ruangan = Yii::app()->user->getState('ruangan_id');
                $model->create_loginpemakai_id = Yii::app()->user->id;
                $model->create_time = date('Y-m-d H:i:s');
                $model->signa_obatalkes = $_POST['SAObatalkesM']['signa_obatalkes'];
				if(isset($_POST['SAObatalkesM']['tglkadaluarsa'])){
					$model->tglkadaluarsa  = $format->formatDateTimeForDb($_POST['SAObatalkesM']['tglkadaluarsa']);
				}else{
					$model->tglkadaluarsa = null;
				}
				switch($model->jnskelompok){
                    case Params::JENISKELOMPOK_OB : 
						$model->obatalkes_kode = MyGenerator::kodeObatAlkes(Params::JENISKELOMPOK_OB);
						break;
                    case Params::JENISKELOMPOK_AL : 
						$model->obatalkes_kode = MyGenerator::kodeObatAlkes(Params::JENISKELOMPOK_AL);
						break;
                    case Params::JENISKELOMPOK_GM : 
						$model->obatalkes_kode = MyGenerator::kodeObatAlkes(Params::JENISKELOMPOK_GM);
						break;
                    case Params::JENISKELOMPOK_XY : 
						$model->obatalkes_kode = MyGenerator::kodeObatAlkes(Params::JENISKELOMPOK_XY);
						break;
                    default : null;
                }

				if($model->validate()){
					if($model->save()){
						$modObatAlkesDetail->attributes=$_POST['ObatalkesdetailM'];
						$modObatAlkesDetail->obatalkes_id=$model->obatalkes_id;
						$modObatAlkesDetail->save();
						$this->successSaveObatAlkes=true;   
						$jumlahSupplier = 0;
						if(isset($_POST['supplier_id'])){
							$idObatAlkes=$model->obatalkes_id;

							foreach($_POST['supplier_id'] as $i => $supplier){
								$modObatSupplier = new SAObatsupplierM;
								$modObatSupplier->supplier_id=$supplier;
								$modObatSupplier->obatalkes_id=$idObatAlkes;
								$modObatSupplier->hargabelibesar=$_POST['hargabeli'];
								$modObatSupplier->hargabelikecil=$model->harganetto;
								$modObatSupplier->satuanbesar_id=$_POST['SAObatalkesM']['satuanbesar_id'];
								$modObatSupplier->satuankecil_id=$_POST['SAObatalkesM']['satuankecil_id'];
								if($modObatSupplier->validate()){
									if($modObatSupplier->save()){
										$this->obatSupplierTersimpan &= true;
									}else{
										$this->obatSupplierTersimpan &= false;
									}    
								}
							}
						}

						$jumlahTherapiObat = 0;
						if(isset($_POST['therapiobat_id'])){
							$idObatAlkes=$model->obatalkes_id;
							
							foreach($_POST['therapiobat_id'] as $i => $therapiobat){
								$modTherapiMapObat = new SATherapimapobatM;
								$modTherapiMapObat->obatalkes_id = $idObatAlkes;
								$modTherapiMapObat->therapiobat_id = $therapiobat;
								if ($modTherapiMapObat->validate()){
									if($modTherapiMapObat->save()){
										$this->therapiObatTersimpan &= true;
									}else{
										$this->therapiObatTersimpan &= false;
									}
								}
								
							}
							
						}

					}else{
						Yii::app()->user->setFlash('error', "Data Obat Alkes Gagal Disimpan");
					}  
				}else{
					Yii::app()->user->setFlash('error', "Data Obat Alkes Tidak Valid");
				}
						
				if($this->successSaveObatAlkes && $this->obatSupplierTersimpan && $this->therapiObatTersimpan){
					$transaction->commit();
					Yii::app()->user->setFlash('success', "Data Obat Akles dan Obat Supplier Berhasil Disimpan");
					$this->redirect(array('admin','id'=>$model->obatalkes_id));
				}else{
					Yii::app()->user->setFlash('error', "Data Obat Akles dan Obat Supplier Gagal Disimpan");
				}     

			}catch(Exception $exc){
				$transaction->rollback();
				Yii::app()->user->setFlash('error',"Data gagal disimpan ".MyExceptionMessage::getMessage($exc,true));
			}
		}

		$this->render($this->path_view.'create',array(
			'model'=>$model,
			'modObatAlkesDetail'=>$modObatAlkesDetail,
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
                $model->harganetto = MyFormatter::formatNumberForPrint($model->harganetto);
                $model->hargamaksimum = MyFormatter::formatNumberForPrint($model->hargamaksimum);
                $model->hargaminimum = MyFormatter::formatNumberForPrint($model->hargaminimum);
                $model->hargaaverage = MyFormatter::formatNumberForPrint($model->hargaaverage);
                
		$modObatAlkesDetails = ObatalkesdetailM::model()->findByAttributes(array('obatalkes_id'=>$id));
		$modObatSupplier = SAObatsupplierM::model()->findAll('obatalkes_id='.$id.'');
		$modTherapiObat = SATherapimapobatM::model()->findAllByAttributes(array('obatalkes_id'=>$id));
		if(count($modObatAlkesDetails) < 1){
			$modObatAlkesDetail = new ObatalkesdetailM;
		}else{
			$modObatAlkesDetail = ObatalkesdetailM::model()->findByAttributes(array('obatalkes_id'=>$id));
		}
		$format = new MyFormatter();
		$modObatSupplier = SAObatsupplierM::model()->findAll('obatalkes_id='.$id.'');
		$modUbahHarga = new SAUbahhargaobatR;
		$model->hjaresep=$model->hargajual;
		if(isset($_POST['SAObatalkesM'])){
			$transaction = Yii::app()->db->beginTransaction();
			try {
				$model->attributes=$_POST['SAObatalkesM'];
				$model->ppn_persen=$_POST['SAObatalkesM']['ppn_persen'];
                $model->update_loginpemakai_id = Yii::app()->user->id;
                $model->update_time = date('Y-m-d H:i:s');
				$model->activedate = $format->formatDateTimeForDb($model->activedate);
				$model->signa_obatalkes = $_POST['SAObatalkesM']['signa_obatalkes'];
//				if(!empty($_POST['SAObatalkesM']['tglkadaluarsa'])){//Jika User memasukan Tanggal Kadaluarsa
//					$model->tglkadaluarsa  = $format->formatDateTimeForDb($_POST['SAObatalkesM']['tglkadaluarsa']);
//				}
				
				if($model->validate()){
//					if($model->tglkadaluarsa == date('Y-m-d') OR $model->tglkadaluarsa <= date('Y-m-d')){
//							echo "<script>
//								myAlert('Obat Sudah Kadaluarsa, Data Tidak Dapat Diproses');
//								window.top.location.href='".Yii::app()->createUrl('gudangFarmasi/obatAlkesM/update&id='.$model->obatalkes_id)."';
//								</script>";
//					}else{
						
						if($model->save()){
							if(count($modObatAlkesDetails) > 0) {
								$modObatAlkesDetail->attributes=$_POST['ObatalkesdetailM'];
								$modObatAlkesDetail->obatalkesdetail_id = $modObatAlkesDetails->obatalkesdetail_id;
								$modObatAlkesDetail->save();
							}else{
								if(isset($_POST['ObatalkesdetailM'])){
									$modObatAlkesDetail = new ObatalkesdetailM;
									$modObatAlkesDetail->attributes = $_POST['ObatalkesdetailM'];
									$modObatAlkesDetail->obatalkes_id = $model->obatalkes_id;
									$modObatAlkesDetail->save();
								}
							}
							$this->successSaveObatAlkes=true;   

							$idObatAlkes=$model->obatalkes_id;
							$hapusObatSupplier=SAObatsupplierM::model()->deleteAll('obatalkes_id='.$idObatAlkes.''); 
							$jumlahObatSupplier=isset($_POST['supplier_id'])?COUNT($_POST['supplier_id']):0;
							$dataObatSupplier=isset($_POST['supplier_id'])?$_POST['supplier_id']:0;
							if($jumlahObatSupplier>0)
							{    
								foreach ($dataObatSupplier as $i => $supplier)
									{
										$modObatSupplier = new SAObatsupplierM;
										$modObatSupplier->supplier_id=$supplier;
										$modObatSupplier->obatalkes_id=$idObatAlkes;
										$modObatSupplier->hargabelibesar=$_POST['hargabeli'];
										$modObatSupplier->hargabelikecil=$model->harganetto;
										$modObatSupplier->satuanbesar_id=$_POST['SAObatalkesM']['satuanbesar_id'];
										$modObatSupplier->satuankecil_id=$_POST['SAObatalkesM']['satuankecil_id'];
										if($modObatSupplier->validate()){//Jika Data ObatSupplierM Valid
											if($modObatSupplier->save()){//Jika ObatSupplierM Sudah Berhasil Disimpan
												$this->obatSupplierTersimpan &= true;
											}else{
												$this->obatSupplierTersimpan &= false;
											}   
										}
									}
							}
							
							$idObatAlkes=$model->obatalkes_id;
							$hapusTherapisObat=SATherapimapobatM::model()->deleteAll('obatalkes_id='.$idObatAlkes.''); 
							$jumlahTherapisObat=isset($_POST['therapiobat_id'])?COUNT($_POST['therapiobat_id']):0;
							$dataTherapisObat=isset($_POST['therapiobat_id'])?$_POST['therapiobat_id']:0;
							if($jumlahTherapisObat>0)
							{    
								foreach ($dataTherapisObat as $i => $therapisObat)
									{
										$modTherapiObat = new SATherapimapobatM;
										$modTherapiObat->therapiobat_id=$therapisObat;
										$modTherapiObat->obatalkes_id=$idObatAlkes;
										if($modTherapiObat->validate()){
											if($modTherapiObat->save()){
												$this->therapiObatTersimpan &= true;
											}else{
												$this->therapiObatTersimpan &= false;
											}   
										}
									}
							}
						}else{
							Yii::app()->user->setFlash('error', "Data Obat Alkes Gagal Disimpan");
						} 
//					}
				}else{
					Yii::app()->user->setFlash('error', "Data Obat Alkes Tidak Valid");
				}
				
				if($this->successSaveObatAlkes && $this->obatSupplierTersimpan){
					$transaction->commit();
					Yii::app()->user->setFlash('success', "Data Obat Akles dan Obat Supplier Berhasil Disimpan");
					$this->redirect(array('admin','id'=>$model->obatalkes_id));
				}else{
					Yii::app()->user->setFlash('error', "Data Obat Akles dan Obat Supplier Gagal Disimpan");
				}
			
			}catch(Exception $exc){
				$transaction->rollback();
				Yii::app()->user->setFlash('error',"Data gagal disimpan ".MyExceptionMessage::getMessage($exc,true));
			}
		}
		
		$this->render($this->path_view.'update',array(
				'model'=>$model,
				'modObatAlkesDetail'=>$modObatAlkesDetail,
				'modObatSupplier'=>$modObatSupplier,
				'modTherapiObat'=>$modTherapiObat, 
				'modUbahHarga'=>$modUbahHarga,
		));
	}

	public function actionAutocompleteJenisObatAlkes()
	{
		if(Yii::app()->request->isAjaxRequest) {
			$criteria = new CDbCriteria();
			$criteria->compare('LOWER(jenisobatalkes_nama)', strtolower($_GET['term']), true);
			$criteria->order = 'jenisobatalkes_nama';
			$criteria->limit = 5;
			$models = JenisobatalkesM::model()->findAll($criteria);
			foreach($models as $i=>$model)
			{
				$attributes = $model->attributeNames();
				foreach($attributes as $j=>$attribute) {
					$returnVal[$i]["$attribute"] = $model->$attribute;
				}
				$returnVal[$i]['label'] = $model->jenisobatalkes_nama;
				$returnVal[$i]['value'] = $model->jenisobatalkes_id;
			}

			echo CJSON::encode($returnVal);
		}
		Yii::app()->end();
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('SAObatalkesM');
		$this->render($this->path_view.'index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
				
		$model=new SAObatalkesM('search');
		$model->unsetAttributes();  // clear any default values
                if (!empty($this->defaultJenis)) {
                    $model->jenisobatalkes_id = $this->defaultJenis;
                }
		if(isset($_GET['SAObatalkesM'])){
			$model->attributes=$_GET['SAObatalkesM'];
                }

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
		$model=SAObatalkesM::model()->findByPk($id);
				$obatdetail=ObatalkesdetailM::model()->findByAttributes(array('obatalkes_id'=>$id));
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='gfobat-alkes-m-form')
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
						$modDiagnosa = DiagnosaobatM::model()->findByAttributes(array('obatalkes_id'=>$id));
						if($modDiagnosa){
							if (Yii::app()->request->isAjaxRequest){
								echo CJSON::encode(array(
									'status'=>'warning', 
									'pesan'=>"Data tidak bisa dihapus karena data ini sedang digunakan di master diagnosa obat",
									));
								exit;               
							}
						}else{
							ObatalkesdetailM::model()->deleteAllByAttributes(array('obatalkes_id'=>$id));
							$this->loadModel($id)->delete();
							if (Yii::app()->request->isAjaxRequest){
								echo CJSON::encode(array(
									'status'=>'proses_form', 
									'div'=>"<div class='flash-success'>Data berhasil dihapus.</div>",
									));
								exit;               
							}
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
					   $update = ObatalkesM::model()->updateByPk($id,array('obatalkes_aktif'=>false));
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
		
		public function actionPrintInformasi()
		{
	
			$model= new GFInfostokobatalkesruanganV('searchPrintInformasi');
			$model->unsetAttributes();
			if(isset($_GET['GFInfostokobatalkesruanganV']))
			{
				$model->attributes=$_GET['GFInfostokobatalkesruanganV'];
			}
			$judulLaporan='Data Obat Alkes';
			$caraPrint=$_REQUEST['caraPrint'];
			if($caraPrint=='PRINT') {
				$this->layout='//layouts/printWindows';
				$this->render($this->path_view.'Print',array('model'=>$model,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint));
			}
			else if($caraPrint=='EXCEL') {
				$this->layout='//layouts/printExcel';
				$this->render($this->path_view.'Print',array('model'=>$model,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint));
			}
			else if($_REQUEST['caraPrint']=='PDF') {
				$ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
				$posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
				$mpdf = new MyPDF('',$ukuranKertasPDF); 
				$mpdf->useOddEven = 2;  
				$stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
				$mpdf->WriteHTML($stylesheet,1);  
				$mpdf->AddPage($posisi,'','','','',15,15,15,15,15,15);
				$mpdf->WriteHTML($this->renderPartial($this->path_view.'Print',array('model'=>$model,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint),true));
				$mpdf->Output();
			}                       
		}
		
		public function actionUbahHarga()
		{
			if(isset($_REQUEST['SAUbahhargaobatR'])){
				$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
				$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
				$transaction = Yii::app()->db->beginTransaction();
				  	try {
						$modUbahHarga= new SAUbahhargaobatR;
						$modUbahHarga->attributes=$_REQUEST['SAUbahhargaobatR'];
						$modUbahHarga->tglperubahan=date('Y-m-d H:i:s');
						if($modUbahHarga->save()){
						$updateObatAlkes=SAObatalkesM::model()->updateByPk($modUbahHarga->obatalkes_id,array('harganetto'=>$modUbahHarga->harganettoperubahan,
																											 'hargajual'=>$modUbahHarga->hargajualperubahan));
								Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data Ubah Harga Berhasil Disimpan.');
								$transaction->commit();
								$urlUbahHargaBerhasil= Yii::app()->controller->createUrl($controller.'/update',array('id'=>$modUbahHarga->obatalkes_id));
								$this->redirect($urlUbahHargaBerhasil);
						}        
				   	}catch(Exception $exc){
					$transaction->rollback();
					Yii::app()->user->setFlash('error',"Data gagal disimpan ".MyExceptionMessage::getMessage($exc,true));
					$urlUbahHargaGagal=  Yii::app()->createUrl($controller.'/update',array('id'=>$_REQUEST['SAUbahhargaobatR']['obatalkes_id']));

					}
			
			}
		}

		/**
         * form verifikasi sebelum submit
         * @param type $id
         */
        public function actionVerifikasi()
		{
	        if (Yii::app()->request->isAjaxRequest){
	            $this->layout = '//layouts/iframe';
	            if(isset($_POST['SAObatalkesM'])){
	                $format = new MyFormatter();
	                $model=new SAUbahhargaobatR;

	                 $model->obatalkes_id = $_POST['SAObatalkesM']['obatalkes_id'];
					 $model->sumberdana_id = $_POST['SAObatalkesM']['sumberdana_id'];
					 $model->loginpemakai_id= Yii::app()->user->id;
					 $model->tglperubahan= date('Y-m-d');
					 $model->harganettoasal= $_POST['SAObatalkesM']['harganetto'];
					 $model->hargajualasal= $_POST['SAObatalkesM']['hargajual'];
					 $model->harganettoperubahan= $_POST['harganettolama'];
					 $model->hargajualperubahan= $_POST['hargajuallama'];

	            }
	            echo CJSON::encode(array(
	                'content'=>$this->renderPartial($this->path_view.'verifikasi',array(
	                    'model'=>$model,
	            ), true)));
	            Yii::app()->end();
	        }
		}

		
		public function actionInformasi()
		{
			$model=new GFInfostokobatalkesruanganV('searchInformasi');
			$format = new MyFormatter();
			$model->unsetAttributes();
			$model->tgl_awal = date('Y-m-d');
			$model->tgl_akhir = date('Y-m-d');
			if(isset($_GET['GFInfostokobatalkesruanganV']))
			{
				$model->attributes=$_GET['GFInfostokobatalkesruanganV'];
//                $model->isGroupObat = $_GET['GFInfostokobatalkesruanganV']['isGroupObat'];
				if(!empty($_GET['GFInfostokobatalkesruanganV']['filterTanggal']))
					$model->filterTanggal = true;
				else 
					$model->filterTanggal = false;                
				$model->tgl_awal  = $format->formatDateTimeForDb($_REQUEST['GFInfostokobatalkesruanganV']['tgl_awal']);
				$model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['GFInfostokobatalkesruanganV']['tgl_akhir']);
			}
			$this->render($this->path_view.'informasi',array('format'=>$format,'model'=>$model));
		}
		
		/**
		 * actionInformasiStok = menampilkan informasi stok barang ruangan login
		 */
		public function actionInformasiStok()
		{
			$model=new GFInfostokobatalkesruanganV('searchInformasiStok');
			$format = new MyFormatter();
			$model->unsetAttributes();
			$model->tgl_awal = date('Y-m-d 00:00:00');
			$model->tgl_akhir = date('Y-m-d H:i:s');
			if(isset($_GET['GFInfostokobatalkesruanganV'])){
				$model->attributes = $_GET['GFInfostokobatalkesruanganV'];
			}
			$this->render($this->path_view.'informasiStok',array('model'=>$model));
		}
		 public function actionUpdateHarga($idObat, $status){
			$this->layout='//layouts/iframe';
			$model = SAObatalkesM::model()->findByPk($idObat);
			$tersimpan = 'Tidak';
			if(!empty($_POST['SAObatalkesM'])){
				$format = new MyFormatter();
				$model->attributes = $_POST['SAObatalkesM'];
				if($model->validate()){
					$transaction = Yii::app()->db->beginTransaction(); 
					try{

						// if($status == "harganetto"){
						// 	ObatalkesM::model()->updateByPk($model->obatalkes_id,array(
						// 					'harganetto'=>$model->harganetto, 
						// 					'discount'=>$model->discount,
						// 					'ppn_peersen'=>$model->ppn_persen,
						// 					'hpp'=>$model->hpp,
						// 	));
						// }else if($status == "hargajual"){
						// 	ObatalkesM::model()->updateByPk($model->obatalkes_id,array(
						// 					'hjaresep'=>$model->hjaresep, 
						// 					'hjanonresep'=>$model->hjanonresep,
						// 					'marginresep'=>$model->marginresep,
						// 					'marginnonresep'=>$model->marginnonresep,
						// 					'jasadokter'=>$model->jasadokter,
						// 	));
						// }
						// echo "<pre>"; print_r($model->attributes);exit();
						$model->save();
						$transaction->commit();                                
						Yii::app()->user->setFlash('success', '<strong>Berhasil</strong> Data Ubah Harga Berhasil Disimpan.');
						$tersimpan='Ya';
						
					} catch (Exception $exc){
						$transaction->rollback();
						Yii::app()->user->setFlash('error',"Data gagal disimpan ".MyExceptionMessage::getMessage($exc,true));
					}
				}else{
					 Yii::app()->user->setFlash('error', '<strong>Silahkan Lengkapi Field Yang Bertanda Bintang</strong> ');
				}
			}
			$this->render($this->path_view.'updateHargaObat', array('model'=>$model,'tersimpan'=>$tersimpan));
		}
		/**
		 * menghitung dan menampilkan jasa persen dokter dari harga netto
		 */
		public function actionGetPersenDokter(){
			if(Yii::app()->request->isAjaxRequest){
				$hargaNetto = $_POST['hargaNetto'];
				   
//                $jasaResep = JasaresepM::model()->find(' '.$hargaNetto.' between minharga AND maxharga');
//                $data['jasaResep'] = $jasaResep->persenjasa;
				$jasaResep = 0;
				$data['jasaResep'] = $jasaResep; //RND-4245 - jasa resep dokter dibuat nol presentasenya

				 echo CJSON::encode($data);
				 Yii::app()->end();
			}
		}
		/**
		 * Get kode obat alkes 
		 */
		public function actionGetKodeObatAlkes() {
			if(Yii::app()->request->isAjaxRequest) {
				$data['kodeObatBaru'] = MyGenerator::noKodeObatAlkes($hurufAwalObat);
				echo json_encode($data);
				Yii::app()->end();
			}
		}
		
		/**
		 * untuk print obat alkes pada menu master
		 */
		public function actionPrint()
		{
	
			$model= new SAObatalkesM('searchPrint');
			$model->unsetAttributes();
			if(isset($_GET['SAObatalkesM']))
			{
				$model->attributes=$_GET['SAObatalkesM'];
			}
			$judulLaporan='Data Obat Alkes';
			$caraPrint=$_REQUEST['caraPrint'];
			if($caraPrint=='PRINT') {
				$this->layout='//layouts/printWindows';
				$this->render($this->path_view.'PrintMaster',array('model'=>$model,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint));
			}
			else if($caraPrint=='EXCEL') {
				$this->layout='//layouts/printExcel';
				$this->render($this->path_view.'PrintMaster',array('model'=>$model,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint));
			}
			else if($_REQUEST['caraPrint']=='PDF') {
				$ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
				$posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
				$mpdf = new MyPDF('',$ukuranKertasPDF); 
				$mpdf->useOddEven = 2;  
				$stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
				$mpdf->WriteHTML($stylesheet,1);  
				$mpdf->AddPage($posisi,'','','','',15,15,15,15,15,15);
				$mpdf->WriteHTML($this->renderPartial($this->path_view.'PrintMaster',array('model'=>$model,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint),true));
				$mpdf->Output($judulLaporan.'-'.date("Y/m/d").'.pdf', 'I');
			}                       
		}
}
