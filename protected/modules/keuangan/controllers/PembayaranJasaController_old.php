
<?php

class PembayaranJasaController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column1';
        public $defaultAction = 'create';
        public $suksesSimpanDetail = false;

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate($id = null)
	{
//                if(!Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
		$format = new MyFormatter;
                $model=new KUPembayaranjasaT;
                $modTandabukti=new KUTandabuktikeluarT;
		$model->tglbayarjasa = date('d M Y H:i:s');
                $model->nobayarjasa = MyGenerator::noBayarJasa();
                $modDetails= new KUPembjasadetailT;
                $dataDetails=array();
                if(!empty($id)){
                    $model=KUPembayaranjasaT::model()->findByPk($id);
                    if(!empty($model->rujukandari_id)){
                        $model->pilihDokter = 'rujukan';
                        $model->rujukandariNama = $model->rujukandari->namaperujuk;
                        $model->tgl_awalPenunjang = date('d M Y', strtotime($model->periodejasa));
                        $model->tgl_akhirPenunjang = date('d M Y', strtotime($model->sampaidgn));
                    }else{
                        $model->pilihDokter = 'rs';
                        $model->pegawaiNama = $model->pegawai->NamaLengkap;
                        $model->tgl_awalPendaftaran = date('d M Y', strtotime($model->periodejasa));
                        $model->tgl_akhirPendaftaran = date('d M Y', strtotime($model->sampaidgn));
                    }
                    $modDetailsLoad=KUPembjasadetailT::model()->findAllByAttributes(array('pembayaranjasa_id'=>$model->pembayaranjasa_id));
                    foreach($modDetailsLoad AS $i => $data){
                        $attributes = $data->attributeNames();
                        foreach($attributes as $j=>$attribute) {
                            $dataDetails[$i]["$attribute"] = $data->$attribute;
                            $dataDetails[$i]["penjaminId"] = $data->pendaftaran->penjamin_id;
                        }
                    }
                }
		if(isset($_POST['KUPembayaranjasaT']) && isset($_POST['KUPembjasadetailT']))
		{
                    $transaction = Yii::app()->db->beginTransaction();
                    try {
			$model->attributes=$_POST['KUPembayaranjasaT'];
			$model->pilihDokter=$_POST['KUPembayaranjasaT']['pilihDokter'];
			$model->pegawaiNama=$_POST['KUPembayaranjasaT']['pegawaiNama'];
			$model->rujukandariNama=$_POST['KUPembayaranjasaT']['rujukandariNama'];
                        $model->tglbayarjasa = date('Y-m-d H:i:s');
                        $model->nobayarjasa = MyGenerator::noBayarJasa();
                        if($model->pilihDokter == "rujukan"){
                            $model->tgl_awalPenunjang = $_POST['KUPembayaranjasaT']['tgl_awalPenunjang'];
                            $model->tgl_akhirPenunjang = $_POST['KUPembayaranjasaT']['tgl_akhirPenunjang'];
                            $model->periodejasa = $format->formatDateTimeForDb($_POST['KUPembayaranjasaT']['tgl_awalPenunjang']);
                            $model->sampaidgn = $format->formatDateTimeForDb($_POST['KUPembayaranjasaT']['tgl_akhirPenunjang']);
                        }else if($model->pilihDokter == "rs"){
                            $model->tgl_awalPendaftaran = $_POST['KUPembayaranjasaT']['tgl_awalPendaftaran'];
                            $model->tgl_akhirPendaftaran = $_POST['KUPembayaranjasaT']['tgl_akhirPendaftaran'];
                            $model->periodejasa = $format->formatDateTimeForDb($_POST['KUPembayaranjasaT']['tgl_awalPendaftaran']);
                            $model->sampaidgn = $format->formatDateTimeForDb($_POST['KUPembayaranjasaT']['tgl_akhirPendaftaran']);
                        }
                        $model->create_time = date('Y-m-d H:i:s');
                        $model->create_loginpemakai_id = Yii::app()->user->id;
                        $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
                        foreach($_POST['KUPembjasadetailT'] AS $i => $post){
                            $dataDetails[$i] = new $modDetails;
                            $dataDetails[$i] = $post;
                        }
                        //Tanda Bukti Keluar
                        $modTandabukti->attributes = NULL;
                        $modTandabukti->tglkaskeluar = date('d M Y H:i:s');
                        $modTandabukti->nokaskeluar = MyGenerator::noKasKeluar();
                        $modTandabukti->namapenerima = (empty($model->rujukandari_id)) ? $model->pegawai->NamaLengkap : $model->rujukandari->namaperujuk;
                        $modTandabukti->shift_id = Yii::app()->user->getState('shift_id');
                        $modTandabukti->ruangan_id = Yii::app()->user->getState('ruangan_id');
                        $modTandabukti->tahun = date('Y');
                        $modTandabukti->jmlkaskeluar = $model->totalbayarjasa;
                        $modTandabukti->biayaadministrasi = 0;
                        $modTandabukti->carabayarkeluar = "TUNAI";
                        $modTandabukti->untukpembayaran = "Jasa Dokter";
                        $modTandabukti->alamatpenerima = (empty($model->rujukandari_id)) ? $model->pegawai->alamat_pegawai : $model->rujukandari->alamatlengkap;
                        if(empty($modTandabukti->alamatpenerima)){
                            $modTandabukti->alamatpenerima = (empty($model->rujukandari_id)) ? "Dokter RS " : "Rujukan Luar";
                        }
                        if($model->validate() && $modTandabukti->save()){
                            $penjaminId = '';
                            $model->tandabuktikeluar_id = $modTandabukti->tandabuktikeluar_id;
                            $model->save();
                            $dataDetails = $this->simpanDetail($model, $modDetails, $_POST['KUPembjasadetailT']);
                            $updateKomponen = $this->updateTindakankomponen($model, $dataDetails);
                            if($this->suksesSimpanDetail == true){ // && $updateKomponen == true BELUM TERUJI
                                $transaction->commit();
                                Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
                                $this->redirect(array('create','id'=>$model->pembayaranjasa_id,'sukses'=>1));
                            }else{
                                $transaction->rollback();
                                Yii::app()->user->setFlash('error', '<strong>Gagal!</strong> Data gagal disimpan. Silahkan cek kembali tabel detail.');
                            }
                        }else{
                            $transaction->rollback();
                            Yii::app()->user->setFlash('error', '<strong>Gagal!</strong> Data gagal disimpan!');
                        }
                    }catch (Exception $exc) {
                        Yii::app()->user->setFlash('error',"Data gagal disimpan ".MyExceptionMessage::getMessage($exc,true));
                        $transaction->rollback();
                    }
		}
		$this->render('create',array(
			'model'=>$model,
			'modDetails'=>$modDetails,
			'dataDetails'=>$dataDetails,
		));
	}
        
        protected function simpanDetail($model, $modDetails, $posts){

            if(count($posts) > 0){
                $saveDetails = array();
                $this->suksesSimpanDetail = true;
                
                foreach($posts AS $i => $post){
                    if($post['pilihDetail'] == true){
                        $saveDetails[$i] = new $modDetails;
                        $saveDetails[$i]->attributes = $post;
                        $saveDetails[$i]->pembayaranjasa_id = $model->pembayaranjasa_id;
                        $saveDetails[$i]->penjaminId = (isset($post['penjaminId']) ? $saveDetails[$i]->penjaminId:null) ;
                        if($saveDetails[$i]->save()){
                            $this->suksesSimpanDetail = $this->suksesSimpanDetail && true;
                        }else{
                            $this->suksesSimpanDetail = false;
                        }
                    }
                }
            }
            return $saveDetails;
        }
        protected function updateTindakankomponen($model, $dataDetails){
            $sukses = true;
            if(count($dataDetails) > 0){
                if($model->rujukandari_id){ //jika rujukan
                    foreach($dataDetails AS $i => $data){
                        $criteria = new CDbCriteria();
                        $criteria->with = array('tindakanpelayanan');
                        $criteria->addCondition('tindakanpelayanan.pasien_id = '.$data['pasien_id']);
                        $criteria->addCondition('tindakanpelayanan.pendaftaran_id = '.$data['pendaftaran_id']);
                        $criteria->addCondition('tindakanpelayanan.pasienmasukpenunjang_id = '.$data['pasienmasukpenunjang_id']);
                        $criteria->addCondition('tindakanpelayanan.tindakansudahbayar_id IS NOT NULL');
                        $modKomponens = TindakankomponenT::model()->findAll($criteria);
                        if(count($modKomponens) > 0){
                            foreach($modKomponens AS $i => $komponen){
                                $komponen->pembayaranjasa_id = $model->pembayaranjasa_id;
                                if($komponen->save())
                                    $sukses = $sukses && true;
                                else
                                    $sukses = false;
                            }
                        }
                    }
                }else{
                    foreach($dataDetails AS $i => $data){
                        $criteria = new CDbCriteria();
                        $criteria->with = array('tindakanpelayanan');
                        $criteria->addCondition('tindakanpelayanan.pasien_id = '.$data['pasien_id']);
                        $criteria->addCondition('tindakanpelayanan.pendaftaran_id = '.$data['pendaftaran_id']);
                        $criteria->addCondition('tindakanpelayanan.tindakansudahbayar_id IS NOT NULL');
                        $modKomponens = TindakankomponenT::model()->findAll($criteria);
                        if(count($modKomponens) > 0){
                            foreach($modKomponens AS $i => $komponen){
                                $komponen->pembayaranjasa_id = $model->pembayaranjasa_id;
                                if($komponen->save())
                                    $sukses = $sukses && true;
                                else
                                    $sukses = false;
                            }
                        }
                    }
                }
            }
            return $sukses;
        }
        
	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$this->redirect(array('create'));
	}

	/**
	 * Manages all models.
	 */
	public function actionInformasi()
	{
//                if(!Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
		$format = new MyFormatter();
                $model=new KUPembayaranjasaT('searchInformasi');
		$model->unsetAttributes();  // clear any default values
                $model->tgl_awal=date('d M Y');
                $model->tgl_akhir=date('d M Y');
		if(isset($_GET['KUPembayaranjasaT'])){
			$model->attributes=$_GET['KUPembayaranjasaT'];
			$model->noKasKeluar=$_GET['KUPembayaranjasaT']['noKasKeluar'];
			$model->namaPerujuk=$_GET['KUPembayaranjasaT']['namaPerujuk'];
			$model->namaDokter=$_GET['KUPembayaranjasaT']['namaDokter'];
			$model->tgl_awal=$format->formatDateTimeForDb($_GET['KUPembayaranjasaT']['tgl_awal']);
			$model->tgl_akhir=$format->formatDateTimeForDb($_GET['KUPembayaranjasaT']['tgl_akhir']);
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
		$model=KUPembayaranjasaT::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='kupembayaranjasa-t-form')
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
                if(!Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
//                SAKabupatenM::model()->updateByPk($id, array('kabupaten_aktif'=>false));
//                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}
        
        /**
         * untuk :
         * - Transaksi Pembayaran Jasa
         */
        public function actionAddDetailPembayaranJasa()
        {
            if(Yii::app()->request->isAjaxRequest) { 
                $format = new MyFormatter();
                $komponentarifIds = null;

                $pegawaiId= (isset($_POST['pegawai_id']) ? $_POST['pegawai_id'] : null);
                $rujukandariId = (isset($_POST['rujukandari_id']) ? $_POST['rujukandari_id'] : null);
                $komponentarifIds= (isset($_POST['komponentarifId']) ? $_POST['komponentarifId'] : null);
                $data =  array();
                $tr =  "";
                $jasaPerujuk[] = 0;
                $jasaDokter[] = 0;
                $tgl_awal = $format->formatDateTimeForDb($_POST['tgl_awal'])." 00:00:00";
                $tgl_akhir = $format->formatDateTimeForDb($_POST['tgl_akhir'])." 23:59:59";
                $dataDetails = array();
                if(!empty($rujukandariId)){
                    $criteria = new CdbCriteria();
                    $criteria->addBetweenCondition('tglmasukpenunjang', $tgl_awal, $tgl_akhir);
                    $criteria->addCondition('rujukandari_id = '.$rujukandariId);
                    $criteria->group = "pasienmasukpenunjang_id, tglmasukpenunjang, rujukandari_id, pendaftaran_id, no_pendaftaran, no_rekam_medik, no_masukpenunjang, pasien_id, nama_pasien, jeniskelamin, alamat_pasien, penjamin_nama";
                    $criteria->select = $criteria->group;
                    $criteria->order = 'tglmasukpenunjang';
                    $dataDetails = KUPasienrujukanluardokterV::model()->findAll($criteria);
                    $criteria1 = $criteria;
                    $criteria1->group .= ', daftartindakan_id, daftartindakan_kode, daftartindakan_nama, tarif_tindakan';
                    $criteria1->select = $criteria1->group;
                    $dataTindakans = KUPasienrujukanluardokterV::model()->findAll($criteria1);
                    $criteria2 = $criteria;
                    $criteria2->select .= ", SUM(tarif_tindakankomp) AS tarif_tindakankomp";
                    $criteria2->addInCondition('komponentarif_id', $komponentarifIds); 
                    $dataKomponen = KUPasienrujukanluardokterV::model()->findAll($criteria2);
                    foreach($dataDetails AS $i => $dataDetail){
                        //hitung tarif_tindakankomp per pasienmasukpenunjang_id
                        foreach($dataKomponen AS $j => $dataKom){
                            if($dataDetail->pasienmasukpenunjang_id == $dataKom->pasienmasukpenunjang_id){
                                $dataDetail->tarif_tindakankomp += $dataKom->tarif_tindakankomp;
							}
                        }
                        //hitung tarif_tindakan per pasienmasukpenunjang_id
                        foreach($dataTindakans AS $k=>$tindakan){
                            if($dataDetail->pasienmasukpenunjang_id == $tindakan->pasienmasukpenunjang_id){
                                $dataDetail->tarif_tindakan += $tindakan->tarif_tindakan;
							}
                        }
                    }
                }else if(!empty($pegawaiId)){
                    $criteria = new CdbCriteria();
                    $criteria->addBetweenCondition('tgl_pendaftaran', $tgl_awal, $tgl_akhir);
                    $criteria->addCondition('pegawai_id = '.$pegawaiId);
					$criteria->addCondition('tarif_tindakan > 0');
                    $criteria->group = "pendaftaran_id, tgl_pendaftaran, pegawai_id, no_pendaftaran, no_rekam_medik, pasien_id, nama_pasien, jeniskelamin, alamat_pasien, penjamin_nama";
                    $criteria->select = $criteria->group;
                    $criteria->order = 'tgl_pendaftaran, pendaftaran_id';
                    $dataDetails = KUPasienpelayanandokterrsV::model()->findAll($criteria);
                    $criteria1 = $criteria;
					$criteria1->group .= ', daftartindakan_id, daftartindakan_kode, daftartindakan_nama, tarif_tindakan';
                    $criteria1->select = $criteria1->group;
					$criteria1->order .= ', daftartindakan_id';
                    $dataTindakans = KUPasienpelayanandokterrsV::model()->findAll($criteria1);
                    $criteria2 = $criteria;
                    $criteria2->select .= ", SUM(tarif_tindakankomp) AS tarif_tindakankomp";
                    $criteria2->addInCondition('komponentarif_id', $komponentarifIds);
                    $dataKomponen = KUPasienpelayanandokterrsV::model()->findAll($criteria2);
                    foreach($dataDetails AS $i => $dataDetail){
                        //hitung tarif_tindakankomp per pendaftaran_id
                        foreach($dataKomponen AS $j => $dataKom){
                            if($dataDetail->pendaftaran_id == $dataKom->pendaftaran_id){
                                $dataDetail->tarif_tindakankomp += $dataKom->tarif_tindakankomp;
							}
                        }
                        //hitung tarif_tindakan per pendaftaran_id
                        foreach($dataTindakans AS $k=>$tindakan){
                            if($dataDetail->pendaftaran_id == $tindakan->pendaftaran_id){
                                $dataDetail->tarif_tindakan += $tindakan->tarif_tindakan;
							}
                        }
                    }
                }
				
                if(count($dataDetails)>0){
                    foreach ($dataDetails as $i => $detail){
                        $modDetails = new KUPembjasadetailT;
                        $modDetails->attributes = $detail->attributes;
                        if($detail->tarif_tindakankomp!=0)
							$modDetails->jumahtarif = $detail->tarif_tindakan;
						else
							$modDetails->jumahtarif = 0;
                        $modDetails->jumlahjasa = $detail->tarif_tindakankomp;
                        $modDetails->jumlahbayar = $modDetails->jumlahjasa;
                        $modDetails->sisajasa = 0;
                        $modDetails->pilihDetail = true;
                        $tr .= "<tr>";
                        $tr .= "<td>".($i+1).
                                CHtml::activeHiddenField($modDetails,'['.$i.']pendaftaran_id',array('value'=>$detail->pendaftaran_id)).
                                CHtml::activeHiddenField($modDetails,'['.$i.']pembayaranjasa_id',array('value'=>null)).
                                CHtml::activeHiddenField($modDetails,'['.$i.']pasien_id',array('value'=>$detail->pasien_id));
                                CHtml::activeHiddenField($modDetails,'['.$i.']penjaminId',array('value'=>$detail->penjamin_id));
                                //tidak ada pasienadmisi_id >> CHtml::activeHiddenField($modDetails,'['.$i.']pasienadmisi_id',array('value'=>$detail->pasienadmisi_id));
                        if(!empty($rujukandariId)) {
                            $tr .= CHtml::activeHiddenField($modDetails,'['.$i.']pasienmasukpenunjang_id',array('value'=>$detail->pasienmasukpenunjang_id));
                        }
                        $tr .= "</td>";
                        $tr .= "<td>".$detail->no_rekam_medik."<br>".$detail->no_pendaftaran."</td>";
                        if(!empty($rujukandariId)){
                            $tr .= "<td>".$detail->no_masukpenunjang."</td>";
                        }else{
                            $tr .= "<td><center>-</center></td>";
                        }
                        $tr .= "<td>".$detail->nama_pasien."</td>";
                        $tr .= "<td>".$detail->alamat_pasien."</td>";
                        $tr .= "<td>".$detail->penjamin_nama."</td>";
                        $tr .= "<td>".CHtml::activeTextField($modDetails,'['.$i.']jumahtarif', array('readonly'=>true, 'class'=>'inputFormTabel integer', 'onkeypress'=>"return $(this).focusNextInputField(event);"))."</td>";
                        $tr .= "<td>".CHtml::activeTextField($modDetails,'['.$i.']jumlahjasa', array('readonly'=>true, 'class'=>'inputFormTabel integer', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'onkeyup'=>'hitungSemua();'))."</td>";
                        $tr .= "<td>".CHtml::activeTextField($modDetails,'['.$i.']jumlahbayar', array('readonly'=>false, 'class'=>'inputFormTabel integer', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'onkeyup'=>'hitungSemua();'))."</td>";
                        $tr .= "<td>".CHtml::activeTextField($modDetails,'['.$i.']sisajasa', array('readonly'=>true, 'class'=>'inputFormTabel integer', 'onkeypress'=>"return $(this).focusNextInputField(event);"))."</td>";
                        $tr .= "<td>".CHtml::activeCheckBox($modDetails,'['.$i.']pilihDetail', array('onclick'=>'checkIni(this);'))."</td>";
                        $tr .= "</tr>";
                    }
                }
               $data['tr']=$tr;
               echo json_encode($data);
             Yii::app()->end();
            }
        }
        
        public function actionLihatDetail($id){
            $this->layout='//layouts/iframe';
            $model=KUPembayaranjasaT::model()->findByPk($id);
            $modDetail = new KUPembjasadetailT;
            $modDetail->unsetAttributes();
            $modDetail->pembayaranjasa_id = $model->pembayaranjasa_id;
            $judulLaporan = null;
            $this->render('Print',array('model'=>$model, 'modDetail'=>$modDetail,'judulLaporan'=>$judulLaporan,'frame'=>true));
        }
        public function actionPrint($id, $caraPrint = null)
        {
            $model=KUPembayaranjasaT::model()->findByPk($id);
            $modDetail = new KUPembjasadetailT;
            $modDetail->unsetAttributes();
            $modDetail->pembayaranjasa_id = $model->pembayaranjasa_id;
            $judulLaporan='Bukti Pembayaran Jasa Dokter';
            if($caraPrint=='PRINT') {
                $this->layout='//layouts/printWindows';
                $this->render('Print',array('model'=>$model, 'modDetail'=>$modDetail,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint));
            }
            else if($caraPrint=='EXCEL') {
                $this->layout='//layouts/printExcel';
                $this->render('Print',array('model'=>$model, 'modDetail'=>$modDetail,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint));
            }
            else if($_REQUEST['caraPrint']=='PDF') {
                $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
                $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
                $mpdf = new MyPDF('',$ukuranKertasPDF); 
                $mpdf->useOddEven = 2;  
                $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
                $mpdf->WriteHTML($stylesheet,1);  
                $mpdf->AddPage($posisi,'','','','',15,15,15,15,15,15);
                $mpdf->WriteHTML($this->renderPartial('Print',array('model'=>$model, 'modDetail'=>$modDetail,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint),true));
                $mpdf->Output();
            }                       
        }
        
        /* digunakan pada:
         * - Pembayaran Jasa dokter
         * Description  : untuk mencari dokter rujukan dari luar
         */
        public function actionRujukanDari()
	{
            if(Yii::app()->request->isAjaxRequest) {
                $criteria = new CDbCriteria();
                $asalRujukanId = ((!empty($_GET['asalRujukanId'])) ? $_GET['asalRujukanId'] : 1);
				if(!empty($asalRujukanId)){
					$criteria->addCondition("asalrujukan_id = ".$asalRujukanId);					
				}
                $criteria->compare('LOWER(namaperujuk)', strtolower($_GET['term']), true);
                $criteria->order = 'namaperujuk';
                $criteria->limit=10;
                $returnVal = array();
                $models = RujukandariM::model()->findAll($criteria);                
                foreach($models as $i=>$model)
                {
                    $attributes = $model->attributeNames();
                    foreach($attributes as $j=>$attribute) {
                        $returnVal[$i]["$attribute"] = $model->$attribute;
                    }
                    $returnVal[$i]['label'] = $model->namaperujuk.' - '.$model->spesialis;
                    $returnVal[$i]['value'] = $model->namaperujuk;
                }

                echo CJSON::encode($returnVal);
            }
            Yii::app()->end();
	}
        
        /**
         * untuk mencari data dokter RS
         */
        public function actionGetDokter()
	{
            if(Yii::app()->request->isAjaxRequest) {
                $criteria = new CDbCriteria();
                if (isset($_GET['term'])){
                    $criteria->compare('LOWER(nama_pegawai)', strtolower($_GET['term']), true);
                }
                $criteria->order = 'nama_pegawai';
                if (isset($_GET['idPegawai'])){
					if(!empty($_GET['idPegawai'])){
						$criteria->addCondition("pegawai_id = ".$_GET['idPegawai']);					
					}
                }
                $models = DokterpegawaiV::model()->findAll($criteria);
                $returnVal = array();
                foreach($models as $i=>$model)
                {
                    $attributes = $model->attributeNames();
                    foreach($attributes as $j=>$attribute) {
                        $returnVal[$i]["$attribute"] = $model->$attribute;
                    }
                    $returnVal[$i]['label'] = $model->gelardepan." ".$model->nama_pegawai.", ".$model->gelarbelakang_nama;
                    $returnVal[$i]['value'] = $model->pegawai_id;
                }

                echo CJSON::encode($returnVal);
            }
            Yii::app()->end();
	}
}
