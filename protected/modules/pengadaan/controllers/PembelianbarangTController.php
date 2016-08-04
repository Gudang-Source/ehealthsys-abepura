<?php

class PembelianbarangTController extends MyAuthController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column1';
	public $defaultAction = 'admin';
	public $path_view = 'pengadaan.views.pembelianbarangT.';

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
	public function actionIndex($id = null, $rencana_id = null)
	{
//                //if(!Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
		$model=new ADPembelianbarangT;
		$renc = new RenkebbarangT;
		
		$model->tglpembelian = date('Y-m-d');

		$modDetails = array();
		$modPesan = array();
		$modBeli = array();
		$model->tglpembelian = date('Y-m-d');

		$instalasi_id = Yii::app()->user->getState('instalasi_id');
		$model->nopembelian = MyGenerator::noPembelianBarang();
		$modLogin = LoginpemakaiK::model()->findByAttributes(array('loginpemakai_id' => Yii::app()->user->id));
		$model->peg_pemesanan_id = $modLogin->pegawai_id;
		if (!empty($modLogin->pegawai_id)) $model->peg_pemesan_nama = $modLogin->pegawai->nama_pegawai;
           
		
		if (!empty($rencana_id)) {
			$renc = RenkebbarangT::model()->findByPk($rencana_id);
			$model->renkebbarang_id = $rencana_id;
			$renc->renkebbarang_tgl = MyFormatter::formatDateTimeForUser($renc->renkebbarang_tgl);
			//var_dump($renc->attributes, $model->attributes);
			
			$rencdet = RenkebbarangdetT::model()->findAllByAttributes(array(
				'renkebbarang_id'=>$rencana_id,
			));
			
			foreach ($rencdet as $item) {
				$det = new BelibrgdetailT();
				$det->barang_id = $item->barang_id;
				$det->hargasatuan = MyFormatter::formatNumberForPrint($item->harga_barangdet);
				$det->jmlbeli = $item->jmlpermintaanbarangdet;
				$det->hargabeli = MyFormatter::formatNumberForPrint($det->jmlbeli * $item->harga_barangdet);
				$det->satuanbeli = $item->satuanbarangdet;
				// var_dump($item->attributes, $det->attributes); die;
				
				array_push($modDetails, $det);
			}
			
		}
		
		if (isset($id)){
			$model = ADPembelianbarangT::model()->findByPk($id);
			$model->nopembelian = MyGenerator::noPembelianBarang();
			$renc = RenkebbarangT::model()->findByPk($model->renkebbarang_id);
			if (!empty($renc)) $renc->renkebbarang_tgl = MyFormatter::formatDateTimeForUser($renc->renkebbarang_tgl);
			if (count($model) > 0){
				$model = $model;
				$model->peg_pemesan_nama = $model->pemesan->nama_pegawai;
				$model->peg_mengetahui_nama = isset($model->mengetahui->nama_pegawai)?$model->mengetahui->nama_pegawai:null;
				$model->peg_menyetujui_nama = isset($model->menyetujui->nama_pegawai)?$model->menyetujui->nama_pegawai:null;
				$modDetails = ADBelibrgdetailT::model()->findAll('pembelianbarang_id = '.$id);
			}
		}
                
                $model->tglpembelian = MyFormatter::formatDateTimeForUser($model->tglpembelian);
		// Uncomment the following line if AJAX validation is needed
		
                
		if(isset($_POST['ADPembelianbarangT']))
		{
			$model->attributes=$_POST['ADPembelianbarangT'];
			$model->renkebbarang_id = $_POST['ADPembelianbarangT']['renkebbarang_id'];
			$model->tglpembelian = MyFormatter::formatDateTimeForDb($model->tglpembelian);
			// var_dump($model->attributes); die;
			
                        if (count($_POST['BelibrgdetailT']) > 0){
                            if ($model->validate()){
                                $transaction = Yii::app()->db->beginTransaction();
                                try{
                                    $success = true;
                                    if($model->save()){
                                        $modDetails = $this->validasiTabular($model, $_POST['BelibrgdetailT']);
                                        foreach ($modDetails as $i=>$data){
                                            if ($data->jmlbeli > 0){
                                                if ($data->save()){
                                                    $success = true;
                                                }
                                                else{
                                                    $success = false;
                                                }
                                            }
                                        }
                                    }
                                    else{
                                        $success = false;
                                    }
                                    
                                    // var_dump($success); die;
                                    
                                    if ($success == true){
                                        $transaction->commit();
                                        Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
                                        $this->redirect(array('index','id'=>$model->pembelianbarang_id,'sukses'=>1));
                                    }
                                    else{
                                        $transaction->rollback();
                                        Yii::app()->user->setFlash('error',"Data gagal disimpan ");
                                    }
                                }
                                catch (Exception $ex){
                                     $transaction->rollback();
                                     Yii::app()->user->setFlash('error',"Data gagal disimpan ".MyExceptionMessage::getMessage($ex,true));
                                }
                            }
                        }else{
                            $model->validate();
                            Yii::app()->user->setFlash('error', '<strong>Gagal!</strong> Data detail barang harus diisi.');
                        }
		}

		$this->render($this->path_view.'index',array(
			'model'=>$model, 'modDetails'=>$modDetails, 'modPesan'=>$modPesan, 'modBeli'=>$modBeli, 'renc'=>$renc,
		));
	}
	
	public function actionAutoCompleteRencana($term) {
		if(Yii::app()->request->isAjaxRequest) {
			$cr = new CDbCriteria;
			$cr->compare('lower(renkebbarang_no)', strtolower($term), true);
			$cr->order = 'renkebbarang_no';
			$rencana = RenkebbarangT::model()->findAll($cr);

			$res = array();
			foreach ($rencana as $item) {
				array_push($res, array(
					'dat'=>$item->attributes,
					'label'=>$item->renkebbarang_no,
					'value'=>$item->renkebbarang_id
				));
			}
			
			echo CJSON::encode($res);
		}
		Yii::app()->end();
		
	}
	
	public function actionLoadRencana() {
		if(Yii::app()->request->isAjaxRequest) {
			$rencana_id = $_POST['id'];
			$renc = RenkebbarangT::model()->findByPk($rencana_id);
			$renc->renkebbarang_tgl = MyFormatter::formatDateTimeForUser($renc->renkebbarang_tgl);
			//var_dump($renc->attributes, $model->attributes);
			$modDetails = array();
			$res = array(
				'rencana'=>"",
				'html'=>"",
			);
			
			$rencdet = RenkebbarangdetT::model()->findAllByAttributes(array(
				'renkebbarang_id'=>$rencana_id,
			));
			
			foreach ($rencdet as $item) {
				$det = new BelibrgdetailT();
				$det->barang_id = $item->barang_id;
				$det->hargasatuan = MyFormatter::formatNumberForPrint($item->harga_barangdet);
				$det->jmlbeli = $item->jmlpermintaanbarangdet;
				$det->hargabeli = MyFormatter::formatNumberForPrint($det->jmlbeli * $item->harga_barangdet);
				$det->satuanbeli = $item->satuanbarangdet;
				// var_dump($item->attributes, $det->attributes); die;
				
				array_push($modDetails, $det);
			}
			
			$res['rencana'] = $renc->attributes;
			foreach ($modDetails as $item) {
				$modBarang = BarangM::model()->findByPk($item->barang_id);
				$res['html'] .= $this->renderPartial($this->path_view.'_detailPembelianBarang', array('modBarang'=>$modBarang, 'modDetail'=>$item), true);
			}
			
			echo CJSON::encode($res);
		}
		Yii::app()->end();
	}
        
        protected function validasiTabular($model, $data){
            $valid = true;
            //var_dump($data); die;
            
            foreach ($data as $i=>$row){
                $modDetails[$i] = new BelibrgdetailT();
                $modDetails[$i]->attributes = $row;
                $modDetails[$i]->pembelianbarang_id = $model->pembelianbarang_id;
                $valid = $modDetails[$i]->validate() && $valid;
                //var_dump($modDetails[$i]->attributes);
            }
            
            return $modDetails;
        }
		
	/**
	 * menampilkan barang yang akan di beli (detail)
	 */
    public function actionGetPembelianBarang(){
        if (Yii::app()->request->isAjaxRequest){
            $idBarang = $_POST['idBarang'];
            $jumlah = $_POST['jumlah'];
            $satuan = $_POST['satuan'];
            
            $modBarang = BarangM::model()->with('subsubkelompok')->findByPk($idBarang);
            // var_dump($modBarang->attributes); die;
            $modDetail = new BelibrgdetailT();
            $modDetail->barang_id = $idBarang;
            $modDetail->satuanbeli = $satuan;
            $modDetail->jmlbeli = $jumlah;
            $modDetail->hargabeli= MyFormatter::formatNumberForPrint($modBarang->barang_harganetto * $jumlah);
            $modDetail->hargasatuan = MyFormatter::formatNumberForPrint($modBarang->barang_harganetto);
            $modDetail->jmldlmkemasan = $modBarang->barang_jmldlmkemasan;
            
            $tr = $this->renderPartial($this->path_view.'_detailPembelianBarang', array('modBarang'=>$modBarang, 'modDetail'=>$modDetail), true);
            echo json_encode($tr);
            Yii::app()->end();
        }
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
		

		if(isset($_POST['ADPembelianbarangT']))
		{
			$model->attributes=$_POST['ADPembelianbarangT'];
			if($model->save()){
                                Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
				$this->redirect(array('view','id'=>$model->pembelianbarang_id));
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
//		$dataProvider=new CActiveDataProvider('ADPembelianbarangT');
//		$this->render('index',array(
//			'dataProvider'=>$dataProvider,
//		));
//	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
                
		$model=new ADPembelianbarangT('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['ADPembelianbarangT']))
			$model->attributes=$_GET['ADPembelianbarangT'];

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
		$model=ADPembelianbarangT::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='gupembelianbarang-t-form')
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
        
//        public function actionPrint()
//        {
//            $model= new ADPembelianbarangT;
//            $model->attributes=$_REQUEST['ADPembelianbarangT'];
//            $judulLaporan='Data ADPembelianbarangT';
//            $caraPrint=$_REQUEST['caraPrint'];
//            if($caraPrint=='PRINT') {
//                $this->layout='//layouts/printWindows';
//                $this->render('Print',array('model'=>$model,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint));
//            }
//            else if($caraPrint=='EXCEL') {
//                $this->layout='//layouts/printExcel';
//                $this->render('Print',array('model'=>$model,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint));
//            }
//            else if($_REQUEST['caraPrint']=='PDF') {
//                $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
//                $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
//                $mpdf = new MyPDF('',$ukuranKertasPDF); 
//                $mpdf->useOddEven = 2;  
//                $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
//                $mpdf->WriteHTML($stylesheet,1);  
//                $mpdf->AddPage($posisi,'','','','',15,15,15,15,15,15);
//                $mpdf->WriteHTML($this->renderPartial('Print',array('model'=>$model,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint),true));
//                $mpdf->Output();
//            }                       
//        }
        
        public function actionInformasi()
	{
//                
		$model=new ADPembelianbarangT('search');
                $format= new MyFormatter;
		$model->unsetAttributes();  // clear any default values
                $model->tgl_awal = date('Y-m-d');
                $model->tgl_akhir = date('Y-m-d');
		if(isset($_GET['ADPembelianbarangT'])){
                     $model->attributes=$_GET['ADPembelianbarangT'];
                     $model->tgl_awal = $format->formatDateTimeForDb($_GET['ADPembelianbarangT']['tgl_awal']);
                     $model->tgl_akhir = $format->formatDateTimeForDb($_GET['ADPembelianbarangT']['tgl_akhir']);
                }

		$this->render($this->path_view.'informasi',array(
			'model'=>$model,'format'=>$format
		));
	}
        
        public function actionDetailPembelianBarang($id){
            $this->layout ='//layouts/iframe';
            $modBeli = PembelianbarangT::model()->findByPk($id);
            $modDetailBeli = BelibrgdetailT::model()->findAllByAttributes(array('pembelianbarang_id'=>$modBeli->pembelianbarang_id));
            $this->render($this->path_view.'detailInformasi', array(
                'modBeli'=>$modBeli,
                'modDetailBeli'=>$modDetailBeli,
            ));
        }
        
        public function actionPrint($id){
            $this->layout='//layouts/printWindows';
            $judulLaporan='Data Pembelian Barang';
            $modBeli = PembelianbarangT::model()->findByPk($id);
            $modDetailBeli = BelibrgdetailT::model()->findAllByAttributes(array('pembelianbarang_id'=>$modBeli->pembelianbarang_id));
            $this->render($this->path_view.'detailInformasi', array(
                'judulLaporan'=>$judulLaporan,
                'modBeli'=>$modBeli,
                'modDetailBeli'=>$modDetailBeli,
            ));
        }
}
