<?php

class MutasibrgTController extends MyAuthController {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column1';
    public $defaultAction = 'admin';
    public $path_view = 'gudangUmum.views.mutasibrgT.';

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {
        $this->render($this->path_view.'view', array(
            'model' => $this->loadModel($id),
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionIndex($id = null) {
        $model = new GUMutasibrgT;
        $modDetails = null;
        $modPesan = null;
        if (isset($id)){
            $modPesan = PesanbarangT::model()->find('pesanbarang_id = '.$id.' and mutasibrg_id is null');
            $model->pesanbarang_id = $modPesan->pesanbarang_id;
            $model->ruangantujuan_id = $modPesan->ruanganpemesan_id;
            $model->instalasi_id = $model->ruangantujuan->instalasi_id;
            if (count($modPesan) == 1){
                $modDetailPesan = PesanbarangdetailT::model()->findAll('pesanbarang_id ='.$id);
                foreach ($modDetailPesan as $i=>$row){
                    $modDetails[$i] = new MutasibrgdetailT();
                    $modDetails[$i]->attributes = $row->attributes;
                    $modDetails[$i]->barang_id = $row->barang_id;
                    $modDetails[$i]->satuanbrg = $row->satuanbarang;
                    $modDetails[$i]->qty_mutasi = $row->qty_pesan;
                    if (Yii::app()->user->getState('krngistokumum') == true){
                        if (InventarisasiruanganT::validasiStok($modDetails[$i]->qty_mutasi, $modDetails[$i]->barang_id) == false){
                            $modDetails[$i]->qty_mutasi = 0;
                        }
                    }
                }
            }
        }
        $model->tglmutasibrg = date('Y-m-d H:i:s');
        $instalasi_id = Yii::app()->user->getState('instalasi_id');
        $model->nomutasibrg = MyGenerator::noMutasiBarang();
        $model->totalhargamutasi = 0;
        $modLogin = LoginpemakaiK::model()->findByAttributes(array('loginpemakai_id' => Yii::app()->user->id));
        $model->pegpengirim_id = $modLogin->pegawai_id;        
        if (!empty($model->pegpengirim_id)) $model->pegpengirim_nama = $modLogin->pegawai->nama_pegawai;
        if (isset($_GET['idMutasi'])){
            $idMutasi = $_GET['idMutasi'];
            $modelMutasi = GUMutasibrgT::model()->findByPk($idMutasi);
            if (count($modelMutasi) == 1){
                $model = $modelMutasi;
                $model->pegpengirim_nama = (isset($model->pegawaipengirim)?$model->pegawaipengirim->nama_pegawai:"");
                $model->pegmengetahui_nama = (isset($model->pegawaimengetahui)?$model->pegawaimengetahui->nama_pegawai:"");
                $model->instalasi_id = $model->ruangantujuan->instalasi_id;
                $modDetails = MutasibrgdetailT::model()->findAll('mutasibrg_id = '.$model->mutasibrg_id);
            }
        }
        // Uncomment the following line if AJAX validation is needed
        

        if (isset($_POST['GUMutasibrgT'])) {
            $model->attributes = $_POST['GUMutasibrgT'];
            if (count($_POST['MutasibrgdetailT']) > 0) {
                $modDetails = $this->validateTable($_POST['MutasibrgdetailT'], $model);
                if ($model->validate()) {
                    $transaction = Yii::app()->db->beginTransaction();
                    try {
                        $total = 0;
                        $success = true;
                        if ($model->save()) {
                            if (!empty($modPesan->pesanbarang_id)){
                                PesanbarangT::model()->updateByPk($modPesan->pesanbarang_id, array('mutasibrg_id'=>$model->mutasibrg_id));
                            }
                            $modDetails = $this->validateTable($_POST['MutasibrgdetailT'], $model);
                            foreach ($modDetails as $i => $data) {
                                if ($data->qty_mutasi > 0){
                                    $modInventaris = InventarisasiruanganT::model()->findByAttributes(array('barang_id'=>$data->barang_id), array('order'=>'tgltransaksi', 'limit'=>1));
                                    $data->inventarisasi_id = (isset($modInventaris->inventarisasi_id) ? $modInventaris->inventarisasi_id : null);
                                    $harga = (isset($modInventaris->inventarisasi_hargasatuan) ? $modInventaris->inventarisasi_hargasatuan : 0);
                                    $total += $harga*$data->qty_mutasi;
                                    
                                    // var_dump($data->attributes, $data->validate(), $data->errors); die;
                                    
                                    if ($data->save()) {
                                        if(isset($modInventaris->inventarisasi_id)){
                                            //InventarisasiruanganT::model()->updateByPk($modInventaris->inventarisasi_id, array('mutasibrgdetail_id'=>$data->mutasibrgdetail_id));
                                            // Update / Insert Inventarisasiruangan Ruangan tujuan											
                                            //$cekInvRuangTujuan = InventarisasiruanganT::model()->findByAttributes(array('barang_id'=>$data->barang_id,'ruangan_id'=>$model->ruangantujuan_id,'inventarisasi_kode'=>$modInventaris->inventarisasi_kode));
                                            /*
                                            if(count($cekInvRuangTujuan)){
                                                    $qty_in = $cekInvRuangTujuan->inventarisasi_qty_in + $data->qty_mutasi;
                                                    $qty_skrg = $cekInvRuangTujuan->inventarisasi_qty_skrg + $data->qty_mutasi;
                                                    InventarisasiruanganT::model()->updateByPk($cekInvRuangTujuan->inventarisasi_id, array(
                                                            'mutasibrgdetail_id'=>$data->mutasibrgdetail_id,
                                                            'inventarisasi_qty_in'=>$qty_in,
                                                            'inventarisasi_qty_skrg'=>$qty_skrg,
                                                            //'inventarisasi_keadaan'=>Params::INVENTA,
                                                            'update_time'=>date('Y-m-d H:i:s'),
                                                            'update_loginpemakai_id'=>Yii::app()->user->id));
                                            }else{ */
                                            $this->simpanInvRuanganTujuan($data,$model,$modInventaris);
                                            //}
                                        }
                                        if (Yii::app()->user->getState('krngistokumum') == true){
                                            if (InventarisasiruanganT::validasiStok($data->qty_mutasi, $data->barang_id) == true){
                                                InventarisasiruanganT::kurangiStok($data->qty_mutasi, $data->barang_id);
                                            }
                                            else{
                                                $success = false;
                                            }
                                        }
                                    } else {
                                        $success = false;
                                    }
                                }
                            }
                            if ($total != 0){
                                MutasibrgT::model()->updateByPk($model->mutasibrg_id, array('totalhargamutasi'=>$total));
                            }
                        }
                        
                        // var_dump($success); die;
                        
                        $this->simpanNotifMutasiBarang($model);
                        if ($success == true) {
                            $transaction->commit();                            
                            $this->redirect(array('index', 'idMutasi'=>$model->mutasibrg_id,'sukses'=>1));
							Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
                        } else {
                            // echo "Kick"; die;
                            $transaction->rollback();
                            Yii::app()->user->setFlash('error', "Data gagal disimpan ");
                        }
                    } catch (Exception $ex) {
                        // var_dump($ex); die;
                        $transaction->rollback();
                        Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($ex, true));
                    }
                }
            } else {
                $model->validate();
                Yii::app()->user->setFlash('error', '<strong>Gagal!</strong> Data detail barang harus diisi.');
            }
        }

        $this->render($this->path_view.'index', array(
            'model' => $model, 'modDetails' => $modDetails, 'modPesan'=>$modPesan,
        ));
    }
    
    public function simpanNotifMutasiBarang($model) {

        $asal = RuanganM::model()->findByPk(Params::RUANGAN_ID_GUDANG_UMUM);
        $ruangan = RuanganM::model()->findByPk($model->ruangantujuan_id);
        $judul = 'Mutasi Barang';

        $isi = "Mutasi Asal : ".$asal->ruangan_nama."<br/>No. Mutasi : ";
        $isi .= CHtml::link($model->nomutasibrg, Yii::app()->createUrl('/gudangUmum/MutasibrgT/detailMutasiBarang', array(
            'id'=>$model->mutasibrg_id,
        )), array('target'=>'_blank'));

        //var_dump($isi); die;
        //var_dump($ruangan->attributes); die;
        $ok = CustomFunction::broadcastNotif($judul, $isi, array(
            array('instalasi_id'=>$ruangan->instalasi_id, 'ruangan_id'=>$ruangan->ruangan_id, 'modul_id'=>$ruangan->modul_id),
            // array('instalasi_id'=>Params::INSTALASI_ID_FARMASI, 'ruangan_id'=>Params::RUANGAN_ID_APOTEK_RJ, 'modul_id'=>10),
            // array('instalasi_id'=>Params::INSTALASI_ID_KASIR, 'ruangan_id'=>Params::RUANGAN_ID_KASIR, 'modul_id'=>19),
        ));

        //var_dump($ok); die;
    }
    
    
    protected function validateTable($datas, $model) {
        $valid = true;
        foreach ($datas as $i => $data) {
            $modDetails[$i] = new MutasibrgdetailT();
            $modDetails[$i]->attributes = $data;
            $modDetails[$i]->mutasibrg_id = $model->mutasibrg_id;

            // var_dump($modDetails[$i]->attributes);
            
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
            $models = CHtml::listData(RuanganM::getRuanganByInstalasi($instalasi_id),'ruangan_id','ruangan_nama');

            if($encode){
                echo CJSON::encode($models);
            } else {
				if(empty($models)){
					echo CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
				} else {
					if(count($models) > 1)
					{
						echo CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
					}
					foreach($models as $value=>$name){
                        echo CHtml::tag('option', array('value'=>$value),CHtml::encode($name),true);
                    }
				}
            }
        }
        Yii::app()->end();
    }
	
	/**
	 * mengecek stok barang
	 */
	public function actionGetStokBarang(){
        if (Yii::app()->request->isAjaxRequest){
            $idBarang = $_POST['idBarang'];
            $jumlah = $_POST['qty'];
            if (Yii::app()->user->getState('krngistokumum') == true){
                if (InventarisasiruanganT::validasiStok($jumlah, $idBarang) == false){
                    echo json_encode('kosong');
                    Yii::app()->end();
                }
            }
            echo json_encode($jumlah);
            Yii::app()->end();
        }
    }
	
	/**
	 * menampilkan mutasi barang + cek stok
	 */
	public function actionGetMutasiBarang(){
        if (Yii::app()->request->isAjaxRequest){
            $idBarang = $_POST['idBarang'];
            $jumlah = $_POST['jumlah'];
            $satuan = $_POST['satuan'];
            if (Yii::app()->user->getState('krngistokumum') == true){
                if (InventarisasiruanganT::validasiStok($jumlah, $idBarang) == false){
                    echo json_encode('kosong');
                    Yii::app()->end();
                }
            }
            $modBarang = BarangM::model()->with('subsubkelompok')->findByPk($idBarang);
            $modDetail = new MutasibrgdetailT();
            $modDetail->barang_id = $idBarang;
            $modDetail->satuanbrg = $satuan;
            $modDetail->qty_mutasi = $jumlah;
            
            $tr = $this->renderPartial($this->path_view.'_detailMutasiBarang', array('modBarang'=>$modBarang, 'modDetail'=>$modDetail), true);
            echo json_encode($tr);
            Yii::app()->end();
        }
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        

        if (isset($_POST['GUMutasibrgT'])) {
            $model->attributes = $_POST['GUMutasibrgT'];
            if ($model->save()) {
                Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
                $this->redirect(array('view', 'id' => $model->mutasibrg_id));
            }
        }

        $this->render($this->path_view.'update', array(
            'model' => $model,
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        if (Yii::app()->request->isPostRequest) {
            // we only allow deletion via POST request
            $this->loadModel($id)->delete();

            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        }
        else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new GUMutasibrgT('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['GUMutasibrgT']))
            $model->attributes = $_GET['GUMutasibrgT'];

        $this->render($this->path_view.'admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id) {
        $model = GUMutasibrgT::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'gumutasibrg-t-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    /**
     * Mengubah status aktif
     * @param type $id 
     */
    public function actionRemoveTemporary($id) {
        if (!Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)) {
            throw new CHttpException(401, Yii::t('mds', 'You are prohibited to access this page. Contact Super Administrator'));
        }
    }

    public function actionInformasi() {
        $model = new GUMutasibrgT('search');
        $format = new MyFormatter();
        $model->tgl_awal = date('Y-m-d');
        $model->tgl_akhir = date('Y-m-d');
        //$model->ruangantujuan_id = Yii::app()->user->getState('ruangan_id');
        if (isset($_GET['GUMutasibrgT'])) {
            $model->attributes = $_GET['GUMutasibrgT'];            
            $model->tgl_awal = $format->formatDateTimeForDb($model->tgl_awal);
            $model->tgl_akhir = $format->formatDateTimeForDb($model->tgl_akhir);
            if($model->ruangantujuan_id == ""){
                //$model->ruangantujuan_id = Yii::app()->user->getState('ruangan_id');
            }
        }

        if (Yii::app()->request->isAjaxRequest) {
                    echo $this->renderPartial($this->path_view.'_table', array('model'=>$model,'format'=>$format),true);
                }else{
                   $this->render($this->path_view.'informasi', array(
                    'model' => $model,'format'=>$format
                    ));
                }
       
    }
    
    public function actionInformasiGudang() {
        $model = new GUMutasibrgT('search');
        $format = new MyFormatter();
        $model->tgl_awal = date('Y-m-d H:i:s');
        $model->tgl_akhir = date('Y-m-d H:i:s');
        if (isset($_GET['GUMutasibrgT'])) {
            $model->attributes = $_GET['GUMutasibrgT'];            
            $model->tgl_awal = $format->formatDateTimeForDb($model->tgl_awal);
            $model->tgl_akhir = $format->formatDateTimeForDb($model->tgl_akhir);
        }

        $this->render($this->path_view.'informasiGudang', array(
            'model' => $model,'format'=>$format
        ));
    }

    public function actionDetailMutasiBarang($id) {
        $this->layout = '//layouts/iframe';
        $modMutasi = MutasibrgT::model()->findByPk($id);
        if (count($modMutasi) == 1){
            $modDetailMutasi = MutasibrgdetailT::model()->findAllByAttributes(array('mutasibrg_id' => $modMutasi->mutasibrg_id));
            $this->render($this->path_view.'detailInformasi', array(
                'modMutasi' => $modMutasi,
                'modDetailMutasi' => $modDetailMutasi,
            ));
        }
    }
    
    public function actionPrint($id) {
        $this->layout='//layouts/printWindows';
        $judulLaporan='Data Mutasi Barang';
        $caraPrint = $_REQUEST['caraPrint'];
        $modMutasi = MutasibrgT::model()->findByPk($id);
        if (count($modMutasi) == 1){
            $modDetailMutasi = MutasibrgdetailT::model()->findAllByAttributes(array('mutasibrg_id' => $modMutasi->mutasibrg_id));
            $this->render($this->path_view.'detailInformasi', array(
                'judulLaporan'=>$judulLaporan,
                'modMutasi' => $modMutasi,
                'modDetailMutasi' => $modDetailMutasi,
                'caraPrint'=>$caraPrint,
            ));
        }
    }
    
    public function actionBatalMutasiBarang($id){
        $this->layout = '//layouts/iframe';
        $modBatals = array();
        $model = new BatalmutasibrgT();
        $model->tglbatalmutasibrg = date('Y-m-d H:i:s');
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
        $modMutasi = MutasibrgT::model()->find('mutasibrg_id  = '.$id);
        $modDetailMutasi = BatalmutasibrgT::model()->findAll('mutasibrg_id = '.$id);
        if ((count($modMutasi) == 1) && (count($modDetailMutasi) < 1)){          
            $modDetailMutasi = MutasibrgdetailT::model()->findAllByAttributes(array('mutasibrg_id' => $modMutasi->mutasibrg_id));
            $modMutasi->ruangan_nama = $modMutasi->ruangantujuan->ruangan_nama;
            $model->mutasibrg_id = $modMutasi->mutasibrg_id;
            $this->render($this->path_view.'batalMutasi', array(
                'modBatals'=>$modBatals,
                'model'=>$model,
                'modMutasi' => $modMutasi,
                'modDetailMutasi' => $modDetailMutasi,
            ));
        } else {
            $this->render($this->path_view.'batalMutasi', array(
                'modBatals'=>$modBatals,
                'model'=>$model,
                'modMutasi' => $modMutasi,
                'modDetailMutasi' => $modDetailMutasi,
            ));
        }
    }
    
    protected function validateTableBatal($datas){
        $valid = true;
        foreach ($datas['barang_id'] as $i=>$data){
            $modDetails[$i] = new BatalmutasibrgT();
            $modDetails[$i]->attributes = $data;
            $modDetails[$i]->alasan_pembatalan = $datas['alasan_pembatalan'];
            $modDetails[$i]->mutasibrg_id = $datas['mutasibrg_id'];
            $modDetails[$i]->tglbatalmutasibrg = $datas['tglbatalmutasibrg'];
            $valid = $modDetails[$i]->validate() && $valid;
        }
        return $modDetails;
    }
    
    /**
     * simpan GUInvbarangdetT
     * @param type $model
     * @param type $detail
     * @return \GUInvbarangdetT
     */
    public function simpanInvRuanganTujuan($data,$model,$modInventaris) {
            $format = new MyFormatter();
            $modInvRuanganTujuan = new GUInventarisasiruanganT;
            $modInvRuanganTujuan->inventarisasi_kode = MyGenerator::kodeTerimaMutasi();
            $modInvRuanganTujuan->mutasibrgdetail_id = $data->mutasibrgdetail_id;
            $modInvRuanganTujuan->barang_id = $data->barang_id;
            $modInvRuanganTujuan->inventarisasi_qty_in = $data->qty_mutasi;
            $modInvRuanganTujuan->inventarisasi_keadaan = isset($modInventaris->inventarisasi_keadaan) ? $modInventaris->inventarisasi_keadaan : "";
            $modInvRuanganTujuan->inventarisasi_hargasatuan = $modInventaris->inventarisasi_hargasatuan;
            $modInvRuanganTujuan->ruangan_id = $model->ruangantujuan_id;
            $modInvRuanganTujuan->tgltransaksi = date('Y-m-d H:i:s');
            $modInvRuanganTujuan->inventarisasi_hargabeli = 0;
            $modInvRuanganTujuan->inventarisasi_qty_out = 0;
            $modInvRuanganTujuan->inventarisasi_qty_skrg = $data->qty_mutasi;
            $modInvRuanganTujuan->create_time = date('Y-m-d H:i:s');
            $modInvRuanganTujuan->create_loginpemakai_id = Yii::app()->user->id;
            $modInvRuanganTujuan->create_ruangan = Yii::app()->user->getState('ruangan_id');
            // var_dump($modInventaris->attributes, $modInvRuanganTujuan->attributes, $modInvRuanganTujuan->validate(), $modInvRuanganTujuan->errors); die;
            if ($modInvRuanganTujuan->validate()) {
                    $modInvRuanganTujuan->save();
            }
            return $modInvRuanganTujuan;
    }
}