<?php

class PengajuanbahanmknController extends MyAuthController
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
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionIndex()
	{
                //if(!Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
		$model=new GZPengajuanbahanmkn;
		$modDetailPengajuan = new PengajuanbahandetailT;

		$model->alamatpengiriman = ProfilrumahsakitM::model()->find()->alamatlokasi_rumahsakit;
		$model->nopengajuan = "Otomatis";
		$model->tglpengajuanbahan = date('d M Y H:i:s');
		$model->ruangan_id = Yii::app()->user->getState('ruangan_id');
		$pegawai_id = LoginpemakaiK::model()->findByPk(Yii::app()->user->id)->pegawai_id;
		$model->idpegawai_mengajukan = $pegawai_id;
		$modSupplier = new SupplierM;

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


		if (isset($_POST['GZPengajuanbahanmkn'])) {
			$model->attributes = $_POST['GZPengajuanbahanmkn'];
			$model->nopengajuan = MyGenerator::noPengajuanBahan();
			$model->create_loginpemakai_id = Yii::app()->user->id;
			$model->create_time = date('Y-m-d H:i:s');
			$model->tglpengajuanbahan = MyFormatter::formatDateTimeForDb($model->tglpengajuanbahan);
			$model->tglmintadikirim = MyFormatter::formatDateTimeForDb($model->tglmintadikirim);
          
			if ($model->validate()) {
				$transaction = Yii::app()->db->beginTransaction();
				try {
					$success = true;

					if ($model->save()) {
					  foreach ($_POST['PengajuanbahandetailT'] as $i => $data) {
							  if($data['checkList']){
								$modDetails = new PengajuanbahandetailT();
								$modDetails->attributes = $data;
								$modDetails->pengajuanbahanmkn_id = $model->pengajuanbahanmkn_id;
								$modDetails->nourutbahan = 1;

								if (!is_numeric($modDetails->jmlkemasan)){
								   $modDetails->jmlkemasan = 0;
								}
								if (!is_numeric($modDetails->qty_pengajuan)) {
									$modDetails->qty_pengajuan = 0;
								}echo "<pre>"; 
								if ($modDetails->validate()) {
									$modDetails->save();
								} else {
									$success = false;
								}
							  }
					  }
					}

					if ($success == true) {
                                                $smscp1 = 0;
                                                $smscp2 = 0;
						// SMS GATEWAY
						if(Yii::app()->user->getState('issmsgateway')){
							$modSupplier = SupplierM::model()->findByPk($model->supplier_id);
							$sms = new Sms();
							$smscp1 = 1;
							$smscp2 = 1;
							foreach ($modSmsgateway as $i => $smsgateway) {
								$isiPesan = $smsgateway->templatesms;

								$attributes = $model->getAttributes();
								foreach($attributes as $attributes => $value){
									$isiPesan = str_replace("{{".$attributes."}}",$value,$isiPesan);
								}
								$attributes = $modSupplier->getAttributes();
								foreach($attributes as $attributes => $value){
									$isiPesan = str_replace("{{".$attributes."}}",$value,$isiPesan);
								}
								$isiPesan = str_replace("{{hari}}",MyFormatter::getDayName($model->tglpengajuanbahan),$isiPesan);
								$isiPesan = str_replace("{{nama_rumahsakit}}",Yii::app()->user->getState('nama_rumahsakit'),$isiPesan);
								if($smsgateway->tujuansms == Params::TUJUANSMS_SUPPLIER && $smsgateway->statussms){
									if(!empty($modSupplier->supplier_cp_hp)){
										$sms->kirim($modSupplier->supplier_cp_hp,$isiPesan);
									}else{
										$smscp1 = 0;
										if(!empty($modSupplier->supplier_cp2_hp)){
											$sms->kirim($modSupplier->supplier_cp2_hp,$isiPesan);
										}else{
											$smscp2 = 0;
										}
									}

								}

							}
						}
						// END SMS GATEWAY

						$transaction->commit();
						Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
						$this->redirect(array('index', 'id' => $model->pengajuanbahanmkn_id,'smscp1'=>$smscp1,'smscp2'=>$smscp2));
					} else {
						$transaction->rollback();
						Yii::app()->user->setFlash('error', "Data gagal disimpan ");
					}
				} catch (Exception $ex) {
					$transaction->rollback();
					Yii::app()->user->setFlash('error', "Data gagal disimpan ".$ex->getMessage());
				}
			} else {
				Yii::app()->user->setFlash('error', '<strong>Gagal!</strong> Data detail barang harus diisi.');
			}
		}
		if (empty($modDetails)){
			$modDetails = null;
		}
		if(isset($_GET['id'])){
		  $model= GZPengajuanbahanmkn::model()->findByPk($_GET['id']);
		  $modSupplier = SupplierM::model()->findByPk($model->supplier_id);
		}

		$this->render('index',array(
			'model'=>$model, 'modDetails'=>$modDetails,'modDetailPengajuan'=>$modDetailPengajuan, 'modSupplier'=>$modSupplier
		));
	}
	/**
	 * untuk autocomplete menampilkan bahan makanan
	 */
	public function actionAutocompleteBahanMakanan()
	{
		if(Yii::app()->request->isAjaxRequest) {
			$criteria = new CDbCriteria();
			$criteria->compare('LOWER(namabahanmakanan)', strtolower($_GET['term']), true);
			$criteria->order = 'namabahanmakanan';
			$models = BahanmakananM::model()->findAll($criteria);
			foreach($models as $i=>$model)
			{
				$attributes = $model->attributeNames();
				foreach($attributes as $j=>$attribute) {
					$returnVal[$i]["$attribute"] = $model->$attribute;
				}
				$returnVal[$i]['label'] = $model->jenisbahanmakanan.' - '.$model->namabahanmakanan.' - '.$model->jmlpersediaan;
				$returnVal[$i]['value'] = $model->bahanmakanan_id;
			}

			echo CJSON::encode($returnVal);
		}
		Yii::app()->end();
	}
	
	public function actionGetBahanMakanan(){

        if (Yii::app()->request->isAjaxRequest){

              $idBahan = $_POST['id'];
              $qty = $_POST['qty'];
              $ukuran = $_POST['ukuran'];
              $merk = $_POST['merk'];
              if (isset($_POST['satuanbahan'])){
                  $satuanbahan = $_POST['satuanbahan'];
              } else {
                  $satuanbahan = null;
              }
              
              if (!is_numeric($qty)){
                  $qty = 0;
              }

              $model = BahanmakananM::model()->with('golbahanmakanan')->findByPk($idBahan);
              if ($satuanbahan != $model->satuanbahan){
                  $model->satuanbahan = $satuanbahan;
              }

              $modDetail = new PengajuanbahandetailT;
	      $format = new MyFormatter();
              $subNetto = $format->formatNumber($qty*$model->harganettobahan);

              $nourut = 1;
                  $tr ="<tr>
                          <td>".CHtml::activeCheckBox($modDetail,'[i]checkList',array('class'=>'cekList','onclick'=>'hitungSemua();','checked'=>true)).                              
                                CHtml::activeHiddenField($modDetail,'[i]golbahanmakanan_id',array('value'=>$model->golbahanmakanan_id, 'class'=>'golbahanmakanan_id')).
                                CHtml::activeHiddenField($modDetail,'[i]bahanmakanan_id',array('value'=>$model->bahanmakanan_id, 'class'=>'bahanmakanan_id')).
                                CHtml::activeHiddenField($modDetail,'[i]jmlkemasan',array('value'=>$model->jmldlmkemasan, 'class'=>'jmldlmkemasan')).
                                CHtml::activeHiddenField($modDetail,'[i]harganettobhn',array('value'=>$model->harganettobahan, 'class'=>'harganettobhn')).
                                CHtml::activeHiddenField($modDetail,'[i]ukuranbahan',array('value'=>$ukuran, 'class'=>'ukuranbahan')).
                                CHtml::activeHiddenField($modDetail,'[i]merkbahan',array('value'=>$merk, 'class'=>'merkbahan')).
                         "</td>
                          <td>".CHtml::TextField('noUrut','',array('class'=>'span1 noUrut','readonly'=>TRUE))."</td>
                          <td>".$model->golbahanmakanan->golbahanmakanan_nama."</td>
                          <td>".$model->jenisbahanmakanan."</td>
                          <td>".$model->kelbahanmakanan."</td>
                          <td>".$model->namabahanmakanan."</td>
                          <td>".number_format($model->jmlpersediaan)."</td>
                          <td>".CHtml::activeDropDownList($modDetail,'[i]satuanbahan', LookupM::getItems('satuanbahanmakanan'), array('class'=>'satuanbahan span1'))."</td>
                          <td>".number_format($model->harganettobahan)."</td>
                          <td>".number_format($model->hargajualbahan)."</td>
                          <td>".number_format($model->discount)."</td>
                          <td>".$model->tglkadaluarsabahan."</td>
                          <td>".CHtml::activetextField($modDetail,'[i]qtypengajuan',array('value'=>$qty,'class'=>'span1 numbersOnly qty','onkeyup'=>'hitung(this);'))."</td>
                          <td>".CHtml::activetextField($modDetail,'[i]subNetto',array('value'=>$subNetto,'class'=>'span1 numbersOnly subNetto','readonly'=>true))."</td>
                          <td>".CHtml::link("<span class='icon-remove'>&nbsp;</span>",'',array('href'=>'','onclick'=>'hapus(this);return false;','style'=>'text-decoration:none;', 'class'=>'cancel'))."</td>
                        </tr>";
                 $data['tr']=$tr;
              echo json_encode($data);
              Yii::app()->end();
          }
      }

        protected function validasiTabular($model,$data){
            foreach ($data as $i=>$row){
                $modDetails[$i] = new PengajuanbahandetailT();
                $modDetails[$i]->attributes = $row;
                $modDetails[$i]->pengajuanbahanmkn_id = $model->pengajuanbahanmkn_id;
                $modDetails[$i]->golbahanmakanan_id = $row['golbahanmakanan_id'];
                $modDetails[$i]->bahanmakanan_id = $row['bahanmakanan_id'];
                $modDetails[$i]->nourutbahan = 1;
                $modDetails[$i]->ukuranbahan =$row['ukuranbahan'];
                $modDetails[$i]->merkbahan = $row['merkbahan'];
                $modDetails[$i]->jmlkemasan = $row['jmlkemasan'];
                if (!is_numeric($modDetails[$i]->jmlkemasan)){
                   $modDetails[$i]->jmlkemasan = 0;
                }
                if (!is_numeric($modDetails[$i]->qty_pengajuan)) {
                    $modDetails[$i]->qty_pengajuan = 0;
                }
                $modDetails[$i]->qty_pengajuan = $row['qtypengajuan'];
                $modDetails[$i]->satuanbahan = $row['satuanbahan'];
                $modDetails[$i]->harganettobhn = $row['harganettobhn'];
                $modDetails[$i]->validate();
            }

            return $modDetails;
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
		

		if(isset($_POST['GZPengajuanbahanmkn']))
		{
			$model->attributes=$_POST['GZPengajuanbahanmkn'];
			if($model->save()){
                                Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
				$this->redirect(array('view','id'=>$model->pengajuanbahanmkn_id));
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
//	public function actionIndex()
//	{
//		$dataProvider=new CActiveDataProvider('GZPengajuanbahanmkn');
//		$this->render('index',array(
//			'dataProvider'=>$dataProvider,
//		));
//	}

	/**
	 * Manages all models.
	 */
	public function actionInformasi()
	{
//                
		$model=new GZPengajuanbahanmkn('search');
//		$model->unsetAttributes();  // clear any default values
                $model->tgl_awal = date('d M Y');
                $model->tgl_akhir = date('d M Y');
		if(isset($_GET['GZPengajuanbahanmkn'])){
                    $model->attributes=$_GET['GZPengajuanbahanmkn'];
                    $format = new MyFormatter();
                    $model->tgl_awal = $format->formatDateTimeForDb($model->tgl_awal);
                    $model->tgl_akhir = $format->formatDateTimeForDb($model->tgl_akhir);
                }

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
		$model=GZPengajuanbahanmkn::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='gzpengajuanbahanmkn-form')
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
            $model= new GZPengajuanbahanmkn;
            $model->attributes=$_REQUEST['GZPengajuanbahanmkn'];
            $judulLaporan='Data GZPengajuanbahanmkn';
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
        
        public function actionDetailPengajuan($id){
            $this->layout = '//layouts/iframe';
			
            $modPengajuan = PengajuanbahanmknT::model()->findByPk($id);
            $modDetailPengajuan = PengajuanbahandetailT::model()->with('bahanmakanan', 'golbahanmakanan')->findAllByAttributes(array('pengajuanbahanmkn_id'=>$modPengajuan->pengajuanbahanmkn_id), array('order'=>'nourutbahan'));
            $this->render('detailInformasi', array(
                'modPengajuan'=>$modPengajuan,
                'modDetailPengajuan'=>$modDetailPengajuan,
            ));
        }
}
