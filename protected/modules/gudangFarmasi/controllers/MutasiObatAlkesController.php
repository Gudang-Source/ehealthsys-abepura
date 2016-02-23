
<?php

class MutasiObatAlkesController extends MyAuthController
{
    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout='//layouts/column1';
    public $defaultAction = 'index';
    public $path_view = 'gudangFarmasi.views.mutasiObatAlkes.';
    
    public $mutasidetailtersimpan = true; //looping
    public $stokobatalkestersimpan = true; //looping

    /**
     * Membuat dan menyimpan data baru.
     */
    public function actionIndex($mutasioaruangan_id = null,$pesanobatalkes_id = null)
    {
        $model=new GFMutasioaruanganT;
        $format = new MyFormatter;
        $model->instalasitujuan_id = Params::INSTALASI_ID_FARMASI;
        $modDetails = array();
        $modStoks = array();
        $modelPesanObat = array();
        $pesan = '';
        $instalasiTujuans = CHtml::listData(GFInstalasiM::getInstalasiTujuanMutasis(),'instalasi_id','instalasi_nama');
        $ruanganTujuans = CHtml::listData(GFRuanganM::getRuanganTujuanMutasis($model->instalasitujuan_id),'ruangan_id','ruangan_nama');
        // Uncomment the following line if AJAX validation is needed
       
        // Error :Array to String
        if(!empty($mutasioaruangan_id)){
            $model = GFMutasioaruanganT::model()->findByPk($mutasioaruangan_id);
            $model->instalasitujuan_id = $model->ruangantujuan->instalasi_id;
            $model->pegawaimengetahui_nama = (isset($model->pegawaimengetahui->NamaLengkap) ? $model->pegawaimengetahui->NamaLengkap : "");
            $ruanganTujuans = CHtml::listData(GFRuanganM::getRuanganTujuanMutasis($model->instalasitujuan_id),'ruangan_id','ruangan_nama');
            $modDetails = $this->loadModelDetails($model->mutasioaruangan_id);
        }
        if(!empty($pesanobatalkes_id) && empty($mutasioaruangan_id)){
            $modelPesanObat = GFPesanobatalkesT::model()->findByPk($pesanobatalkes_id);
            if (count($modelPesanObat) == 1){
                $model->ruangantujuan_id = $modelPesanObat->ruanganpemesan_id;
                $modDetailPesan = GFPesanoadetailT::model()->findAllByAttributes(array('pesanobatalkes_id'=>$pesanobatalkes_id));
                $ruangan_id = Yii::app()->user->getState('ruangan_id');
                $totalharganetto = 0;
                $totalhargajual = 0;
                if (count($modDetailPesan) > 0){
					$ii = 0;
                    foreach ($modDetailPesan as $a => $detail) {
                        $modStokOAs = StokobatalkesT::getStokObatAlkesAktif($detail->obatalkes_id, $detail->jmlpesan, $ruangan_id);
                        if(count($modStokOAs) > 0){
                            foreach($modStokOAs AS $i => $stok){
                                $modDetails[$ii] = new GFMutasioadetailT();
                                $modDetails[$ii]->stokobatalkes_id = $stok->stokobatalkes_id;
                                $modDetails[$ii]->jmlmutasi = $stok->qtystok_terpakai;
				$modDetails[$ii]->jmlpesan = $stok->qtystok_terpakai; 
                                $modDetails[$ii]->harganetto = $stok->HPP;
                                $modDetails[$ii]->hargajualsatuan = $stok->HargaJualSatuan;
                                $modDetails[$ii]->sumberdana_id = (isset($stok->penerimaandetail->sumberdana_id) ? $stok->penerimaandetail->sumberdana_id : $stok->obatalkes->sumberdana_id);
                                $modDetails[$ii]->obatalkes_id = $stok->obatalkes_id;
                                $modDetails[$ii]->satuankecil_id = $stok->satuankecil_id;
                                $modDetails[$ii]->satuankecil_nama = $stok->satuankecil->satuankecil_nama;
                                $modDetails[$ii]->tglkadaluarsa = $format->formatDateTimeForUser($stok->tglkadaluarsa);
                                $modDetails[$ii]->jmlstok = $stok->qtystok;
                                $modDetails[$ii]->tglterima = $format->formatDateTimeForUser($stok->tglterima);
                                $modDetails[$ii]->pesanoadetail_id = $detail->pesanoadetail_id;
                                $totalharganetto += $modDetails[$ii]->harganetto;
                                $totalhargajual += $modDetails[$ii]->hargajualsatuan;	
								$ii ++;
                            }
                        }else{
                            $pesan = "Stok obat ".$detail->obatalkes->obatalkes_nama." tidak mencukupi!";
                        }
                    }
                }

                $model->pesanobatalkes_id = $modelPesanObat->pesanobatalkes_id;
                $model->totalharganettomutasi = $totalharganetto;
                $model->totalhargajual = $totalhargajual;
            }
        }
        
        if(isset($_POST['GFMutasioaruanganT']))
        {
            $transaction = Yii::app()->db->beginTransaction();
            try {
                $model->attributes=$_POST['GFMutasioaruanganT'];
                $model->tglmutasioa=date("Y-m-d H:i:s");
                $model->nomutasioa=MyGenerator::noMutasi();
                $model->create_time=date("Y-m-d H:i:s");
                $model->create_loginpemakai_id=Yii::app()->user->id;
                $model->create_ruangan=Yii::app()->user->getState('ruangan_id');
                $model->pegawaimutasi_id=Yii::app()->user->getState('pegawai_id');
                $model->ruanganasal_id=Yii::app()->user->getState('ruangan_id');
                
                if($model->save()){
                    if (!empty($model->pesanobatalkes_id)){
                        PesanobatalkesT::model()->updateByPk($model->pesanobatalkes_id, array('mutasioaruangan_id'=>$model->mutasioaruangan_id));
                                
                    }
                    if(isset($_POST['GFMutasioadetailT'])){
                        if(count($_POST['GFMutasioadetailT']) > 0){
                            //PROSES GROUP DETAIL BERDASARKAN obatalkes_id & akumulasikan jmlmutasi
                            $detailGroups = array();
                            foreach($_POST['GFMutasioadetailT'] AS $i => $postDetail){
                                $modDetails[$i] = new GFMutasioadetailT;
                                $modDetails[$i]->attributes = $postDetail;
                                //$modStok = StokobatalkesT::model()->findByPk($postDetail['stokobatalkes_id']);
                                $modDetails[$i]->stokobatalkes_id = null; //$modStok->stokobatalkes_id;
                                //$modDetails[$i]->tglterima = $modStok->tglterima;
                                $modDetails[$i]->pesanoadetail_id = $postDetail['pesanoadetail_id'];
                                //$obatalkes_id = $postDetail['obatalkes_id'];
                                $modDetails[$i] = $this->simpanMutasiDetail2($model, $postDetail);
                                $this->simpanStokObatAlkesOut2($modDetails[$i]);
                                /*
                                if(isset($detailGroups[$obatalkes_id])){
                                    $detailGroups[$obatalkes_id]['jmlmutasi'] += $postDetail['jmlmutasi'];
                                }else{
                                    $detailGroups[$obatalkes_id]['obatalkes_id'] = $postDetail['obatalkes_id'];
                                    $detailGroups[$obatalkes_id]['jmlmutasi'] = $postDetail['jmlmutasi'];
                                }*/
                            }
                            //END GROUP
                        } /*
                        $obathabis = "";
                        //PROSES PENGURAIAN OBAT DAN JUMLAH MENJADI STOKOBATALKES_T (METODE ANTRIAN)
                        foreach($detailGroups AS $i => $detail){
                            $modStokOAs = StokobatalkesT::getStokObatAlkesAktif($detail['obatalkes_id'], $detail['jmlmutasi'], Yii::app()->user->getState('ruangan_id'));
                            if(count($modStokOAs) > 0){
                                foreach($modStokOAs AS $i => $stok){
                                    $modDetails[$i] = $this->simpanMutasiDetail($model, $stok);
                                    $this->simpanStokObatAlkesOut($stok['stokobatalkes_id'], $modDetails[$i]);
                                }
                            }else{
                                $this->stokobatalkestersimpan &= false;
                                $obathabis .= "<br>- ".ObatalkesM::model()->findByPk($detail['obatalkes_id'])->obatalkes_nama;
                            }
                        } */
                        
                        //var_dump($this->mutasidetailtersimpan && $this->stokobatalkestersimpan);
                        //die;
                        if($this->mutasidetailtersimpan && $this->stokobatalkestersimpan){
                            $transaction->commit();
                            $sukses = 1;
                            $this->redirect(array('index','mutasioaruangan_id'=>$model->mutasioaruangan_id, 'sukses'=>$sukses));
                        }else{
                            $transaction->rollback();
                            $model->mutasioaruangan_id = null;
                            Yii::app()->user->setFlash('error',"Data detail mutasi obat alkes gagal disimpan !");
                            if(!$this->stokobatalkestersimpan){
                                Yii::app()->user->setFlash('error',"Data detail mutasi obat alkes gagal disimpan ! Stok obat berikut tidak mencukupi !:".$obathabis);
                            }
//                            echo "-".$this->mutasidetailtersimpan."<br>";
//                            echo "-".$this->stokobatalkestersimpan."<br>";
//                            exit;
                        } 
                    }
                }
            } catch (Exception $e) {
                $transaction->rollback();
                Yii::app()->user->setFlash('error',"Data mutasi obat alkes gagal disimpan ! ".MyExceptionMessage::getMessage($e,true));
            }
        }
		
        $this->render($this->path_view.'index',array(
            'format'=>$format,
            'model'=>$model,
            'modDetails'=>$modDetails,
            'instalasiTujuans'=>$instalasiTujuans,
            'ruanganTujuans'=>$ruanganTujuans,
            'pesan'=>$pesan,
            'modelPesanObat'=>$modelPesanObat
        ));
    }
    
    /**
     * untuk menyimpan MutasioadetailT
     * @param type $modMutasi
     * @param type $postDetail
     */
    protected function simpanMutasiDetail2($modMutasi, $postDetail){
        $modMutasiDetail = new GFMutasioadetailT;
        $modMutasiDetail->attributes = $postDetail;
        $modMutasiDetail->mutasioaruangan_id = $modMutasi->mutasioaruangan_id;
        //$modMutasiDetail->stokobatalkes_id = $modStokOa->stokobatalkes_id;
        //$modMutasiDetail->jmlmutasi = $modStokOa->qtystok_terpakai;
        //$modMutasiDetail->harganetto = $modStokOa->HPP;
        //$modMutasiDetail->hargajualsatuan = $modStokOa->HargaJualSatuan;
        //$modMutasiDetail->sumberdana_id = (isset($modStokOa->penerimaandetail->sumberdana_id) ? $modStokOa->penerimaandetail->sumberdana_id : $modStokOa->obatalkes->sumberdana_id);
        //$modMutasiDetail->obatalkes_id = $modStokOa->obatalkes_id;
        //$modMutasiDetail->tglkadaluarsa = $modStokOa->tglkadaluarsa;
        //$modMutasiDetail->jmlstok = $modStokOa->qtystok;
        //$modMutasiDetail->tglterima = MyFormatter::formatDateTimeForDb($modStokOa->tglterima);
        $modMutasiDetail->tglkadaluarsa = MyFormatter::formatDateTimeForDb($modMutasiDetail->tglkadaluarsa);
        $modMutasiDetail->jmlpesan = (empty($modMutasiDetail->jmlpesan) ? 0 : $modMutasiDetail->jmlpesan);
        $modMutasiDetail->persendiscount = (empty($modMutasiDetail->persendiscount) ? 0 : $modMutasiDetail->persendiscount);
        $modMutasiDetail->totalharga = ($modMutasiDetail->harganetto * $modMutasiDetail->jmlmutasi);
        //$modMutasiDetail->satuankecil_id = $modStokOa->satuankecil_id;
        
        // var_dump($modMutasiDetail->attributes);
        
        if($modMutasiDetail->save()){
            $this->mutasidetailtersimpan &= true;
        }else{
            $this->mutasidetailtersimpan &= false;
        }
        return $modMutasiDetail;
    }
    
    /**
     * simpan StokobatalkesT Jumlah Out
     * @param type $stokobatalkesasal_id
     * @param type $modMutasi
     * @param type $modMutasiDetail
     * @return \StokobatalkesT
     */
    protected function simpanStokObatAlkesOut2($modMutasiDetail){
        $format = new MyFormatter;
        $oa = ObatalkesM::model()->findByPk($modMutasiDetail->obatalkes_id);
        //$modStokOa = StokobatalkesT::model()->findByPk($stokobatalkesasal_id);
        $modStokOaNew = new StokobatalkesT;
        $modStokOaNew->attributes = $modMutasiDetail->attributes; //$modStokOa->attributes; //duplicate
        $modStokOaNew->attributes = $oa->attributes; //$modStokOa->attributes; //duplicate
        //$modStokOaNew->unsetIdTransaksi(); //new / autoincrement pk
        $modStokOaNew->qtystok_in = 0;
        $modStokOaNew->qtystok_out = $modMutasiDetail->jmlmutasi;
        $modStokOaNew->mutasioadetail_id = $modMutasiDetail->mutasioadetail_id;
        // $modStokOaNew->stokobatalkesasal_id = $stokobatalkesasal_id;
        $modStokOaNew->create_time = date('Y-m-d H:i:s');
        $modStokOaNew->update_time = $modStokOaNew->tglterima = date('Y-m-d H:i:s');
        $modStokOaNew->create_loginpemakai_id = Yii::app()->user->id;
        $modStokOaNew->update_loginpemakai_id = Yii::app()->user->id;
        $modStokOaNew->create_ruangan = $modStokOaNew->ruangan_id = Yii::app()->user->ruangan_id;
        
        // $modStokOaNew->validate();
        // var_dump($modStokOaNew->errors); die;
        
        if($modStokOaNew->validate()){ 
            $modStokOaNew->save();
            // $modStokOaNew->setStokOaAktifBerdasarkanStok();
        } else {
            $this->stokobatalkestersimpan &= false;
        }
        return $modStokOaNew;      
    }
    
    /**
     * untuk menyimpan MutasioadetailT
     * @param type $modMutasi
     * @param type $postDetail
     */
    protected function simpanMutasiDetail($modMutasi, $modStokOa){
        $modMutasiDetail = new GFMutasioadetailT;
        $modMutasiDetail->mutasioaruangan_id = $modMutasi->mutasioaruangan_id;
        $modMutasiDetail->stokobatalkes_id = $modStokOa->stokobatalkes_id;
        $modMutasiDetail->jmlmutasi = $modStokOa->qtystok_terpakai;
        $modMutasiDetail->harganetto = $modStokOa->HPP;
        $modMutasiDetail->hargajualsatuan = $modStokOa->HargaJualSatuan;
        $modMutasiDetail->sumberdana_id = (isset($modStokOa->penerimaandetail->sumberdana_id) ? $modStokOa->penerimaandetail->sumberdana_id : $modStokOa->obatalkes->sumberdana_id);
        $modMutasiDetail->obatalkes_id = $modStokOa->obatalkes_id;
        $modMutasiDetail->tglkadaluarsa = $modStokOa->tglkadaluarsa;
        $modMutasiDetail->jmlstok = $modStokOa->qtystok;
        $modMutasiDetail->tglterima = MyFormatter::formatDateTimeForDb($modStokOa->tglterima);
        $modMutasiDetail->tglkadaluarsa = MyFormatter::formatDateTimeForDb($modMutasiDetail->tglkadaluarsa);
        $modMutasiDetail->jmlpesan = (empty($modMutasiDetail->jmlpesan) ? 0 : $modMutasiDetail->jmlpesan);
        $modMutasiDetail->persendiscount = (empty($modMutasiDetail->persendiscount) ? 0 : $modMutasiDetail->persendiscount);
        $modMutasiDetail->totalharga = ($modMutasiDetail->harganetto * $modMutasiDetail->jmlmutasi);
        $modMutasiDetail->satuankecil_id = $modStokOa->satuankecil_id;
        
        if($modMutasiDetail->save()){
            $this->mutasidetailtersimpan &= true;
        }else{
            $this->mutasidetailtersimpan &= false;
        }
        return $modMutasiDetail;
    }
    /**
     * simpan StokobatalkesT Jumlah Out
     * @param type $stokobatalkesasal_id
     * @param type $modMutasi
     * @param type $modMutasiDetail
     * @return \StokobatalkesT
     */
    protected function simpanStokObatAlkesOut($stokobatalkesasal_id,$modMutasiDetail){
        $format = new MyFormatter;
        $modStokOa = StokobatalkesT::model()->findByPk($stokobatalkesasal_id);
        $modStokOaNew = new StokobatalkesT;
        $modStokOaNew->attributes = $modStokOa->attributes; //duplicate
        $modStokOaNew->unsetIdTransaksi(); //new / autoincrement pk
        $modStokOaNew->qtystok_in = 0;
        $modStokOaNew->qtystok_out = $modMutasiDetail->jmlmutasi;
        $modStokOaNew->mutasioadetail_id = $modMutasiDetail->mutasioadetail_id;
        $modStokOaNew->stokobatalkesasal_id = $stokobatalkesasal_id;
        $modStokOaNew->create_time = date('Y-m-d H:i:s');
        $modStokOaNew->update_time = date('Y-m-d H:i:s');
        $modStokOaNew->create_loginpemakai_id = Yii::app()->user->id;
        $modStokOaNew->update_loginpemakai_id = Yii::app()->user->id;
        $modStokOaNew->create_ruangan = Yii::app()->user->ruangan_id;
        
        if($modStokOaNew->validateStok()){ 
            $modStokOaNew->save();
            $modStokOaNew->setStokOaAktifBerdasarkanStok();
        } else {
            $this->stokobatalkestersimpan &= false;
        }
        return $modStokOaNew;      
    }
            
    /**
     * Memanggil data dari model.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id)
    {
            $model=GFMutasioaruanganT::model()->findByPk($id);
            if($model===null)
                    throw new CHttpException(404,'The requested page does not exist.');
            return $model;
    }
    /**
     * Memanggil data dari model detail.
     * @param integer the ID of the model to be loaded
     */
    public function loadModelDetails($id)
    {
        $criteria = new CdbCriteria();
        $criteria->addCondition('mutasioaruangan_id = '.$id);
        $criteria->join = "LEFT JOIN stokobatalkes_t ON stokobatalkes_t.mutasioadetail_id = t.mutasioadetail_id";
        $criteria->select = "*, stokobatalkes_t.stokobatalkes_id AS stokobatalkes_id";
        $models = GFMutasioadetailT::model()->findAll($criteria);
        if($models===null)
                throw new CHttpException(404,'The requested page does not exist.');
        return $models;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if(isset($_POST['ajax']) && $_POST['ajax']==='gfmutasioaruangan-t-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
    
    public function actionAutocompletePegawaiMengetahui()
    {
        if(Yii::app()->request->isAjaxRequest) {
            $criteria = new CDbCriteria();
            $criteria->compare('LOWER(nama_pegawai)', strtolower($_GET['term']), true);
            $criteria->order = 'nama_pegawai';
            $criteria->limit = 5;
            $models = GFPegawaiV::model()->findAll($criteria);
            foreach($models as $i=>$model)
            {
                $attributes = $model->attributeNames();
                foreach($attributes as $j=>$attribute) {
                    $returnVal[$i]["$attribute"] = $model->$attribute;
                }
                $returnVal[$i]['label'] = $model->gelardepan." ".$model->nama_pegawai." ".$model->gelarbelakang_nama;
                $returnVal[$i]['value'] = $model->pegawai_id;
            }

            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }
    
    /**
    * menampilkan obat
    * @return row table 
    */
    public function actionSetFormMutasiDetail()
    {
        if(Yii::app()->request->isAjaxRequest) { 
            $obatalkes_id = $_POST['obatalkes_id'];
            $jumlah = $_POST['jumlah'];
            $ruangan_id = Yii::app()->user->getState('ruangan_id');
			$pesanobatalkes_id = $_POST['pesanobatalkes_id'];
            if(isset($_POST['pesanobatalkes_id'])){
				if(!empty($_POST['pesanobatalkes_id'])){
					$modInfoOa = GFInformasipesanobatalkesV::model()->findByAttributes(array('pesanobatalkes_id'=>$pesanobatalkes_id));
					$ruangan_id = $modInfoOa->ruanganpemesan_id; //RSN-332
				}
			}
			
            $form = "";
            $pesan = "";
            $format = new MyFormatter();
            $modMutasiDetail = new GFMutasioadetailT;
            $oa = ObatalkesM::model()->findByPk($obatalkes_id);
            //$modStokOAs = StokobatalkesT::getStokObatAlkesAktif($obatalkes_id, $jumlah, $ruangan_id);
            //if(count($modStokOAs) > 0){
                $totalharganetto = 0;
                $totalhargajual = 0;
            //    foreach($modStokOAs AS $i => $stok){
                    $modMutasiDetail->stokobatalkes_id = null; //$stok->stokobatalkes_id;
                    $modMutasiDetail->jmlmutasi = $jumlah; //$stok->qtystok_terpakai;
                    $modMutasiDetail->harganetto = $oa->harganetto; //$stok->HPP;
                    $modMutasiDetail->hargajualsatuan = $oa->hargajual; //$stok->HargaJualSatuan;
                    $modMutasiDetail->sumberdana_id = $oa->sumberdana_id; //(isset($stok->penerimaandetail->sumberdana_id) ? $stok->penerimaandetail->sumberdana_id : $stok->obatalkes->sumberdana_id);
                    $modMutasiDetail->obatalkes_id = $oa->obatalkes_id; //$stok->obatalkes_id;
                    $modMutasiDetail->satuankecil_id = $oa->satuankecil_id; //$stok->satuankecil_id;
                    $modMutasiDetail->satuankecil_nama = $oa->satuankecil->satuankecil_nama; //$stok->satuankecil->satuankecil_nama;
                    $modMutasiDetail->tglkadaluarsa = $oa->tglkadaluarsa; //$format->formatDateTimeForUser($stok->tglkadaluarsa);
                    $modMutasiDetail->jmlstok = 0; //$stok->qtystok;
                    $modMutasiDetail->tglterima = $format->formatDateTimeForUser(date('Y-m-d H:i:s')); //$format->formatDateTimeForUser($stok->tglterima);
                    $totalharganetto += $modMutasiDetail->harganetto;
                    $totalhargajual += $modMutasiDetail->hargajualsatuan;
                    $form .= $this->renderPartial($this->path_view.'_rowMutasiDetail', array('modMutasiDetail'=>$modMutasiDetail), true);
                //}
            //}else{
            //    $pesan = "Stok tidak mencukupi!";
            //}
            
            echo CJSON::encode(array('form'=>$form, 'pesan'=>$pesan));
            Yii::app()->end(); 
        }
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
                $instalasi_id = $_POST["$model_nama"]['instalasitujuan_id'];
            }
             else if ($model_nama == '' && $attr !== '') {
                $instalasi_id = $_POST["$attr"];
            }
             else if ($model_nama !== '' && $attr !== '') {
                $instalasi_id = $_POST["$model_nama"]["$attr"];
            }
            $models = null;
            $models = CHtml::listData(GFRuanganM::getRuanganTujuanMutasis($instalasi_id),'ruangan_id','ruangan_nama');

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
    
    public function actionAutocompleteObatAlkes()
    {
        if(Yii::app()->request->isAjaxRequest) {
			$is_nobatch_tglkadaluarsa = isset($_GET['is_nobatch_tglkadaluarsa']) ? $_GET['is_nobatch_tglkadaluarsa'] : null;
            $criteria = new CDbCriteria();
            $criteria->compare('LOWER(obatalkes_nama)', strtolower($_GET['term']), true);
			$criteria->addCondition('ruangan_id = '.Yii::app()->user->getState('ruangan_id'));
            $criteria->order = 'obatalkes_nama';
            $criteria->limit = 5;
			if($is_nobatch_tglkadaluarsa == 1){
				$models = GFInformasistokobatalkesV::model()->findAll($criteria);
				foreach($models as $i=>$model)
				{
					$attributes = $model->attributeNames();
					foreach($attributes as $j=>$attribute) {
						$returnVal[$i]["$attribute"] = $model->$attribute;
					}
					$returnVal[$i]['label'] = $model->obatalkes_nama." (Stok=".$model->qtystok.")";
					$returnVal[$i]['value'] = $model->obatalkes_id;
				}
			}else{
				$models = ObatalkesM::model()->findAll($criteria);
				foreach($models as $i=>$model)
				{
					$attributes = $model->attributeNames();
					foreach($attributes as $j=>$attribute) {
						$returnVal[$i]["$attribute"] = $model->$attribute;
					}
					$returnVal[$i]['label'] = $model->obatalkes_nama." (Stok=".$model->StokObatRuangan.")";
					$returnVal[$i]['value'] = $model->obatalkes_id;
				}
			}
            

            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }
    
    /**
     * untuk print data rencana kebutuhan farmasi
     */
    public function actionPrint($mutasioaruangan_id,$caraprint = null) 
    {
        $this->layout='//layouts/printWindows';
        if (isset($_GET['frame'])){
            $this->layout='//layouts/iframe';
        }
        else if($caraprint=='EXCEL') {
            $this->layout='//layouts/printExcel';
        }
        $format = new MyFormatter;    
        $model = GFMutasioaruanganT::model()->findByPk($mutasioaruangan_id);     
        $modDetails = GFMutasioadetailT::model()->findAllByAttributes(array('mutasioaruangan_id'=>$mutasioaruangan_id));

        $judul_print = 'Mutasi Obat Alkes';
        
        $this->render($this->path_view.'print', array(
                'format'=>$format,
                'judul_print'=>$judul_print,
                'model'=>$model,
                'modDetails'=>$modDetails,
                'caraprint'=>$caraprint
        ));
    } 
}
