<?php

class TerimabahanmakanController extends MyAuthController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column1';
        public $defaultAction = 'admin';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
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
	public function actionIndex($idPengajuan = null,$id=null, $sukses=null)
	{
            if ($sukses == 1){
                Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
            }
                //if(!Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
                
		$model=new GZTerimabahanmakan;
        $model->nopenerimaanbahan = MyGenerator::noPenerimaanBahan();
        $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
        $model->tglterimabahan = date('d M Y H:i:s');
        $model->totaldiscount = 0;
        $model->biayapajak = 0;
        $model->biayapengiriman = 0;
        $model->biayatransportasi = 0;
        if (isset($idPengajuan)){
            $modPengajuan = PengajuanbahanmknT::model()->find('pengajuanbahanmkn_id = '.$idPengajuan.' and terimabahanmakan_id is null');
            if (count($modPengajuan) == 1){
                $model->supplier_id = $modPengajuan->supplier_id;
                $model->sumberdanabhn = $modPengajuan->sumberdanabhn;
                $model->totalharganetto = $modPengajuan->totalharganetto;
                $model->pengajuanbahanmkn_id = $modPengajuan->pengajuanbahanmkn_id;
                $modDetailPengajuan = PengajuanbahandetailT::model()->with('golbahanmakanan')->findAllByAttributes(array('pengajuanbahanmkn_id'=>$idPengajuan));
            }
//                  $model->totaldiscount = $modPengajuan->totalharganetto;
        }
        if(isset($id)){
            $model = GZTerimabahanmakan::model()->findByPk($_GET['id']);
        }
		// Uncomment the following line if AJAX validation is needed
		

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
		
		if(isset($_POST['GZTerimabahanmakan']))
		{
                    $model->attributes=$_POST['GZTerimabahanmakan'];
                    $transaction = Yii::app()->db->beginTransaction();
                    $stokgizi = Yii::app()->user->getState('krngistokgizi');
					
                    try{    
                        $success = true;
                        if($model->save()) {
                            if (isset($modPengajuan->pengajuanbahanmkn_id)){
                                PengajuanbahanmknT::model()->updateByPk($model->pengajuanbahanmkn_id, array('terimabahanmakan_id'=>$model->terimabahanmakan_id));
                            }
                            //var_dump($_POST['TerimabahandetailT']);
                            $jumlah = count($_POST['TerimabahandetailT']);
                            $terimaDet = $_POST['TerimabahandetailT'];
                            $u = 0;
                            foreach ($terimaDet as $i => $bahanDetail) {
									// var_dump($bahanDetail); 
                                //if ($_POST['checkList'] == 1) {
                                    $modDetail = new GZTerimabahandetailT();
                                    $modDetail->attributes = $bahanDetail;
                                    $modDetail->terimabahanmakan_id = $model->terimabahanmakan_id;                                    
                                    $modDetail->golbahanmakanan_id = $bahanDetail['golbahanmakanan_id'];
                                    $modDetail->bahanmakanan_id = $bahanDetail['bahanmakanan_id'];
                                    $modDetail->nourutbahan = $u;
                                    $modDetail->ukuran_bahanterima = $bahanDetail['ukuran_bahanterima'];
                                    $modDetail->merk_bahanterima = $bahanDetail['merk_bahanterima'];
                                    $modDetail->jmlkemasan = $bahanDetail['jmlkemasan'];
                                    if (isset($modPengajuan->pengajuanbahanmkn_id)){
                                        $modDetail->pengajuanbahandetail_id = $bahanDetail['pengajuanbahandetail_id'];
                                    }
                                    if (!is_numeric($modDetail->jmlkemasan)){
                                        $modDetail->jmlkemasan = 0;
                                    }
                                    if (!is_numeric($bahanDetail['qty_terima'])) {
                                        $bahanDetail['qty_terima'] = 0;
                                    }
                                    $modDetail->qty_terima = $bahanDetail['qty_terima'];
                                    $modDetail->satuanbahan = $bahanDetail['satuanbahan'];
                                    $modDetail->hargajualbhn = $bahanDetail['hargajualbahan'];
                                    $modDetail->harganettobhn = $bahanDetail['harganettobahan'];
									$modDetail->tglkadaluarsabahan = MyFormatter::formatDateTimeForDb($bahanDetail['tglkadaluarsabahan']);
                                    //var_dump($bahanDetail);
                                    // var_dump($modDetail->attributes, $modDetail->validate(), $modDetail->errors);
                                    
                                    if ($modDetail->save()){
										/* Ubah harga netto bahan makanan dan tanggal kadaluarsa dengan data penerimaan */ 
										BahanmakananM::model()->updateByPk($modDetail->bahanmakanan_id, array(
											'harganettobahan'=>$modDetail->harganettobhn,
											'tglkadaluarsabahan'=>$modDetail->tglkadaluarsabahan,
										));
										if ($stokgizi) {
											/* 
											 * Jika stok gizi dicentang di konfig sistem maka 
											 * akan ditambahkan stok-nya + penyesuaian jml persediaan 
											 * di master 
											 */
											$this->tambahStokBahanMakanan($modDetail);
											
											$tot = 0;
											$sto = StokbahanmakananT::model()->findAllByAttributes(array(
												'bahanmakanan_id'=>$modDetail->bahanmakanan_id,
											));
											foreach ($sto as $item) {
												$tot += $item->qty_current;
											}
											BahanmakananM::model()->updateByPk($modDetail->bahanmakanan_id, array(
												'jmlpersediaan'=>$tot,
											));
										} else {
											/* Jika tidak maka hanya menambah jumlah persediaan yang ada di master bahan makanan */
											$bhn = BahanmakananM::model()->findByPk($modDetail->bahanmakanan_id);
											if (empty($bhn->jmlpersediaan)) $bhn->jmlpersediaan = 0;
											$bhn->jmlpersediaan += $modDetail->qty_terima;
											$bhn->save();
										}
										
										/* Update id terima bahan pada pengajuan bahan makanan */
                                        if (isset($modPengajuan->pengajuanbahanmkn_id)){
                                            PengajuanbahandetailT::model()->updateByPk($modDetail->pengajuanbahandetail_id, array('terimabahandetail_id'=>$modDetail->terimabahandetail_id));
                                        }
                                    }else{
                                        $success = false;
                                    }
                                    $u++;
                                //}
                            }
                        }
                        else{
                            $success = false;
                        }
                        // var_dump($success); die;
                        
                        if ($success == TRUE){

                            // SMS GATEWAY
                            /*
                            $modSupplier = $model->supplier;
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
                                $isiPesan = str_replace("{{hari}}",MyFormatter::getDayName($model->tglterimabahan),$isiPesan);
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
                             * 
                             */
                            // END SMS GATEWAY
                            $transaction->commit();
                            $this->redirect(array('index', 'sukses'=>1, 'modul_id'=>Yii::app()->session['modul_id']));
                            //$transaction->commit();
                            Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
                             //$this->redirect(array('index', 'id' =>$model->terimabahanmakan_id,'smscp1'=>$smscp1,'smscp2'=>$smscp2));
                            // $this->redirect(array('index', 'sukses'=>1, 'modul_id'=>Yii::app()->session->modul_id));
                            //$this->refresh();
                        }else{
                            $transaction->rollback();
                            Yii::app()->user->setFlash('error',"Data gagal disimpan ");
                        }
                    }
                    catch (Exception $exc) {
                        $transaction->rollback();
                        $successSave = false;
                        Yii::app()->user->setFlash('error',"Data gagal disimpan ".MyExceptionMessage::getMessage($exc,true));
                    }
		}
                if (empty($modDetailPengajuan)) {
                    $modDetailPengajuan = null;
                }
                if (empty($modPengajuan)){
                    $modPengajuan = null;
                }
		$this->render('index',array(
			'model'=>$model, 'modDetailPengajuan'=>$modDetailPengajuan, 'modPengajuan'=>$modPengajuan,
		));
	}
        
        public function actionGetBahanMakananDariPenerimaan(){
        if (Yii::app()->request->isAjaxRequest){
			Yii::app()->clientScript->scriptMap['*.js'] = false;
            Yii::app()->clientScript->scriptMap['*.css'] = false;
			
            $idBahan = $_POST['id'];
            $qty = $_POST['qty'];
            $ukuran = $_POST['ukuran'];
            $merk = $_POST['merk'];
            $satuanbahan = $_POST['satuanbahan'];
            if (!is_numeric($qty)){
                $qty = 0;
            }
            $model = BahanmakananM::model()->with('golbahanmakanan')->findByPk($idBahan);
            $modDetail = new TerimabahandetailT();
            $subNetto = $qty*$model->harganettobahan;
			
//            $modDetail->satuanbahan[] = $satuanbahan;
            $tr = $this->renderPartial('_rowMakanan', array(
				'modDetail'=>$modDetail,
				'model'=>$model,
				'subNetto'=>$subNetto,
				'qty'=>$qty,
				'ukuran'=>$ukuran,
				'merk'=>$merk,
				'satuanbahan'=>$satuanbahan,
			), true, true);
            echo $tr;
            Yii::app()->end();
        }
    }
        
        protected function tambahStokBahanMakanan($detail){
			
            $modStokBahan = new GZStokbahanmakananT();
            $modStokBahan->terimabahandetail_id = $detail->terimabahandetail_id;
            $modStokBahan->bahanmakanan_id = $detail->bahanmakanan_id;
            $modStokBahan->tgltransaksi = date('Y-m-d');
            $modStokBahan->qty_masuk = $detail->qty_terima;
            $modStokBahan->qty_current = $detail->qty_terima;
            $modStokBahan->qty_keluar = 0;
            $modStokBahan->save();
			
			$detail->stokbahanmakanan_id = $modStokBahan->stokbahanmakanan_id;
			$detail->save();
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
		

		if(isset($_POST['GZTerimabahanmakan']))
		{
			$model->attributes=$_POST['GZTerimabahanmakan'];
			if($model->save()){
                                Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
				$this->redirect(array('view','id'=>$model->terimabahanmakan_id));
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
//		$dataProvider=new CActiveDataProvider('GZTerimabahanmakan');
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
		$model=new GZTerimabahanmakan('search');
                $model->tgl_awal = date('d M Y');
                $model->tgl_akhir = date('d M Y');
//		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['GZTerimabahanmakan'])){
                    $model->attributes=$_GET['GZTerimabahanmakan'];
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
		$model=GZTerimabahanmakan::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='gzterimabahanmakan-form')
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
            $model= new GZTerimabahanmakan;
            $model->attributes=$_REQUEST['GZTerimabahanmakan'];
            $judulLaporan='Data GZTerimabahanmakan';
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
        
        public function actionDetailPenerimaan($id){
            
            $this->layout = '//layouts/iframe';
            
            $modTerima = TerimabahanmakanT::model()->findByPk($id);
            $modDetailTerima = TerimabahandetailT::model()->with('bahanmakanan', 'golbahanmakanan')->findAllByAttributes(array('terimabahanmakan_id'=>$modTerima->terimabahanmakan_id), array('order'=>'nourutbahan ASC'));
            $this->render('detailInformasi', array(
                'modTerima'=>$modTerima,
                'modDetailTerima'=>$modDetailTerima,
            ));
        }
}
