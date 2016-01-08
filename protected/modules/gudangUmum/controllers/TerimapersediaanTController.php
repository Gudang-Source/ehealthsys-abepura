<?php

class TerimapersediaanTController extends MyAuthController
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
		$model=new GUTerimapersediaanT;
		$format= new MyFormatter;
		$instalasi_id = Yii::app()->user->getState('instalasi_id');
		$model->nopenerimaan = 'Otomatis';				
		$modLogin = LoginpemakaiK::model()->findByAttributes(array('loginpemakai_id' => Yii::app()->user->id));
		$model->peg_penerima_id = $modLogin->pegawai_id;
		$model->peg_penerima_nama = $modLogin->pegawai->nama_pegawai;
		$model->ruanganpenerima_id = Yii::app()->user->getState('ruangan_id');
		$model->instalasi_id = $model->ruangan->instalasi_id;
		$model->tglterima = date('Y-m-d');
		$model->tglsuratjalan = date('Y-m-d');
		$model->tglfaktur = date('Y-m-d');
		$model->totalharga = 0 ;
		$model->discount = 0;
		$model->biayaadministrasi = 0;
		$model->pajakpph = 0;
		$model->pajakppn =0;
		$modDetails = array();
		$modPesan = array();
		$modBeli = new PembelianbarangT;
		$modDetailBeli = array();
                
                if (isset($_GET['id'])){
                    $id = $_GET['id'];
                    $modBeli = PembelianbarangT::model()->find('pembelianbarang_id = '.$id.' and terimapersediaan_id is null');
                    if (count($modBeli) == 1){
                        $modDetailBeli = BelibrgdetailT::model()->findAllByAttributes(array('pembelianbarang_id'=>$id));
                        $model->pembelianbarang_id = $id;
                        $model->sumberdana_id = $modBeli->sumberdana_id;
                        foreach ($modDetailBeli as $i=>$row){
                            $modDetails[$i] = new TerimapersdetailT();
                            $modDetails[$i]->attributes = $row->attributes;
                            $modDetails[$i]->jmlterima = $row->jmlbeli;
                            $modDetails[$i]->jmlbeli = $row->jmlbeli;
                            $modDetails[$i]->jmldalamkemasan = $row->barang->barang_jmldlmkemasan;
                        }
                    }
                }

		// Uncomment the following line if AJAX validation is needed
		

		if(isset($_POST['GUTerimapersediaanT']))
		{
			$format= new MyFormatter;
			$model->attributes=$_POST['GUTerimapersediaanT'];
			$model->nopenerimaan = MyGenerator::noPenerimaanPersediaan($instalasi_id);
			$model->tglterima=$format->formatDateTimeForDb($_POST['GUTerimapersediaanT']['tglterima']);
			$model->tglsuratjalan=$format->formatDateTimeForDb($_POST['GUTerimapersediaanT']['tglsuratjalan']);
			$model->tglfaktur=$format->formatDateTimeForDb($_POST['GUTerimapersediaanT']['tglfaktur']);
			$model->tgljatuhtempo=$format->formatDateTimeForDb($_POST['GUTerimapersediaanT']['tgljatuhtempo']);
			$model->create_time=date("Y-m-d");
			$model->create_loginpemakai_id = Yii::app()->user->id;
			$model->create_ruangan = Yii::app()->user->getState('ruangan_id');
			$model->pembelianbarang_id = $id;
			if (count($_POST['TerimapersdetailT']) > 0){
                            if ($model->validate()){
                                $transaction = Yii::app()->db->beginTransaction();
								$success = true;
                                try{
                                    if($model->save()){
										$modDetailBeli = BelibrgdetailT::model()->findAllByAttributes(array('pembelianbarang_id'=>$id));
										$modDetails = $this->validasiTabular($model, $_POST['TerimapersdetailT'], $modDetailBeli);
                                        if (!empty($model->pembelianbarang_id)){
                                            PembelianbarangT::model()->updateByPk($model->pembelianbarang_id, array('terimapersediaan_id'=>$model->terimapersediaan_id));
                                        }
                                        $modDetails = $this->validasiTabular($model, $_POST['TerimapersdetailT'], $modDetailBeli);
                                        foreach ($modDetails as $i=>$data){
                                            if ($data->jmlterima > 0){
                                                $modInven = new InventarisasiruanganT();
                                                $modInven->ruangan_id = $model->ruanganpenerima_id;
                                                $modInven->barang_id = $data->barang_id;
                                                $modInven->tgltransaksi = date('Y-m-d');
                                                $modInven->inventarisasi_kode = MyGenerator::kodeTerimaPersediaan();
                                                $modInven->inventarisasi_hargabeli = $data->hargabeli;
                                                $modInven->inventarisasi_hargasatuan = $data->hargasatuan;
                                                $modInven->inventarisasi_qty_in = $data->jmlterima;
                                                $modInven->inventarisasi_qty_out = 0;
                                                $modInven->inventarisasi_qty_skrg = $data->jmlterima;
                                                $modInven->inventarisasi_keadaan = $data->kondisibarang;
                                                if ($modInven->save()){
                                                    $data->inventarisasi_id = $modInven->inventarisasi_id;
                                                    if ($data->save()){
                                                        InventarisasiruanganT::model()->updateByPk($modInven->inventarisasi_id, array('terimapersdetail_id'=>$data->terimapersdetail_id));
                                                    }
                                                    else{
                                                        $success = false;
                                                    }
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
                                    if ($success == true){
										$sukses = 1;
                                        $transaction->commit();
                                        Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
//                                        if (isset($model->pembelianbarang_id)){
                                            $this->redirect(array('index','id'=>$model->pembelianbarang_id,'sukses'=>$sukses));
//                                        }
//                                        else{
//                                            $this->refresh();
//                                        }
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
                if (!isset($modDetails)){
                    $modDetails = null;
                }
                if (!isset($modDetailBeli)){
                    $modDetailBeli = null;
                }

		$this->render('index',array(
			'model'=>$model, 'modDetails'=>$modDetails, 'modBeli'=>$modBeli, 'modDetailBeli'=>$modDetailBeli,
		));
	}
        
        protected function validasiTabular($model, $data, $beli){
            $valid = true;
            foreach ($data as $i=>$row){
                $modDetails[$i] = new TerimapersdetailT();
                $modDetails[$i]->attributes = $row;
                $modDetails[$i]->terimapersediaan_id = $model->terimapersediaan_id;
                if (isset($beli)){
                    $modDetails[$i]->jmlbeli = $beli[$i]->jmlbeli;
                }
                $valid = $modDetails[$i]->validate() && $valid;
            }
            
            return $modDetails;
        }
	/**
     * Mengatur dropdown ruangan
     * @param type $encode jika = true maka return array jika false maka set Dropdown 
     * @param type $model_nama
     * @param type $attr
     */
    public function actionSetDropdownRuangan($encode=false,$model_nama='',$attr='')
    {
        if(Yii::app()->request->isAjaxRequest) {
            $instalasi_id = null;
            if($model_nama !=='' && $attr == ''){
                $instalasi_id = $_POST["$model_nama"]['instalasi_id'];
            }
             else if ($model_nama == '' && $attr !== '') {
                $instalasi_id = $_POST["$attr"];
            }
             else if ($model_nama !== '' && $attr !== '') {
                $instalasi_id = $_POST["$model_nama"]["$attr"];
            }
            $models = null;
            $models = CHtml::listData(GURuanganM::getRuanganPenerimas($instalasi_id),'ruangan_id','ruangan_nama');

            if($encode){
                echo CJSON::encode($models);
            } else {
                echo CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
                if(count($models) > 0){
                    foreach($models as $value=>$name){
                        echo CHtml::tag('option', array('value'=>$value),CHtml::encode($name),true);
                    }
                }
            }
        }
        Yii::app()->end();
    }
	
	//Pencarian Penerimaan Persediaan barang 
    public function actionGetPenerimaanPersediaanBarang(){
        if (Yii::app()->request->isAjaxRequest){
            $idBarang = $_POST['idBarang'];
            $jumlah = $_POST['jumlah'];
            $satuan = $_POST['satuan'];
            
            $modBarang = BarangM::model()->with('bidang')->findByPk($idBarang);
            $modDetail = new TerimapersdetailT();
            $modDetail->barang_id = $idBarang;
            $modDetail->satuanbeli = $satuan;
            $modDetail->jmlterima = $jumlah;
            $modDetail->hargabeli=0;
            $modDetail->hargasatuan = 0;
            $modDetail->jmldalamkemasan = $modBarang->barang_jmldlmkemasan;
            
            $tr = $this->renderPartial('_detailPenerimaanPersediaanBarang', array('modBarang'=>$modBarang, 'modDetail'=>$modDetail), true);
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
		

		if(isset($_POST['GUTerimapersediaanT']))
		{
			$model->attributes=$_POST['GUTerimapersediaanT'];
			if($model->save()){
                                Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
				$this->redirect(array('view','id'=>$model->terimapersediaan_id));
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
//		$dataProvider=new CActiveDataProvider('GUTerimapersediaanT');
//		$this->render('index',array(
//			'dataProvider'=>$dataProvider,
//		));
//	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
                
		$model=new GUTerimapersediaanT('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['GUTerimapersediaanT']))
			$model->attributes=$_GET['GUTerimapersediaanT'];

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
		$model=GUTerimapersediaanT::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='guterimapersediaan-t-form')
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
        
        public function actionInformasi()
	{
//                
		$model=new GUTerimapersediaanT('search');
//		$model->unsetAttributes();  // clear any default values
                $model->tgl_awal = date('Y-m-d');
                $model->tgl_akhir = date('Y-m-d');
		if(isset($_GET['GUTerimapersediaanT'])){
                    $model->attributes=$_GET['GUTerimapersediaanT'];
                    $format = new MyFormatter();
                    $model->tgl_awal = $format->formatDateTimeForDb($model->tgl_awal);
                    $model->tgl_akhir = $format->formatDateTimeForDb($model->tgl_akhir);
                }

		$this->render('informasi',array(
			'model'=>$model,
		));
	}
        
        public function actionDetailTerimaPersediaan($id){
            $this->layout ='//layouts/iframe';
            $modTerima = TerimapersediaanT::model()->findByPk($id);
            $modDetailTerima = TerimapersdetailT::model()->findAllByAttributes(array('terimapersediaan_id'=>$modTerima->terimapersediaan_id));
            $this->render('detailInformasi', array(
                'modTerima'=>$modTerima,
                'modDetailTerima'=>$modDetailTerima,
            ));
        }
        
        public function actionPrint($id){
            $this->layout='//layouts/printWindows';
            $judulLaporan='Data Pembelian Barang';
            $modTerima = TerimapersediaanT::model()->findByPk($id);
            $modDetailTerima = TerimapersdetailT::model()->findAllByAttributes(array('terimapersediaan_id'=>$modTerima->terimapersediaan_id));
            $this->render('detailInformasi', array(
                'judulLaporan'=>$judulLaporan, 
                'modTerima'=>$modTerima,
                'modDetailTerima'=>$modDetailTerima,
            ));
        }
        
    public function actionReturPenerimaan($id){
        $this->layout = 'iframe';
        $model = new ReturpenerimaanT();
        $modTerima = TerimapersediaanT::model()->find('terimapersediaan_id  = '.$id.' and returpenerimaan_id is null');
        $modDetailTerima = TerimapersdetailT::model()->findAll('terimapersediaan_id = '.$id.' and retpendetail_id is null');
        if ((count($modTerima) == 1) && (count($modDetailTerima) > 0)){
            $model->tglreturterima = date('Y-m-d H:i:s');
            $model->terimapersediaan_id = $modTerima->terimapersediaan_id;
            $model->noreturterima = MyGenerator::noReturTerima();
            $this->render('returPenerimaan', array(
                'model'=>$model,
            ));
        }
        else{
            echo 'Barang telah dibatal mutasikan';
        }
        if (isset($_POST['BatalmutasibrgT'])){
            $modBatals = $this->validateTableBatal($_POST['BatalmutasibrgT']);
            $transaction = Yii::app()->db->beginTransaction();
            try {
                $success = true;
                $modBatals = $this->validateTableBatal($_POST['BatalmutasibrgT']);
                foreach ($modBatals as $i => $data) {
                    if ($data->qty_batal > 0){
                        $modInventaris = InventarisasiruanganT::model()->findByAttributes(array('barang_id'=>$data->barang_id),array('order'=>'tgltransaksi', 'limit'=>1));
                        if ($data->save()) {
                            InventarisasiruanganT::kembalikanStok($data->qty_batal, $data->barang_id);
                            MutasibrgdetailT::model()->updateByPk($_POST['BatalmutasibrgT']['barang_id'][$i]['mutasibrgdetail_id'], array('batalmutasibrg_id'=>$data->batalmutasibrg_id));
                            InventarisasiruanganT::model()->updateAll(array('batalmutasibrg_id'=>$data->batalmutasibrg_id),'mutasibrgdetail_id = '.$_POST['BatalmutasibrgT']['barang_id'][$i]['mutasibrgdetail_id'].' and barang_id = '.$data->barang_id);
                        } else {
                            $success = false;
                        }
                    }
                }

                if ($success == true) {
                    $transaction->commit();
                    Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
                    $this->refresh();
                } else {
                    $transaction->rollback();
                    Yii::app()->user->setFlash('error', "Data gagal disimpan ");
                }
            } catch (Exception $ex) {
                $transaction->rollback();
                Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($ex, true));
            }
        }
        
        
    }
        
        
}
