
<?php

class StockOpnameObatAlkesController extends MyAuthController
{
    public $path_view = 'gudangFarmasi.views.stockOpnameObatAlkes.';
    public $stokobatalkestersimpan = true; //looping
    public $stokopnameobattersimpan = true; //looping
    public $updateformulirstokdetailtersimpan = true; //looping

    public function actionIndex($formuliropname_id = null,$stokopname_id = null)
    {
        $format = new MyFormatter();
        $modObat = new GFInformasistokobatalkesV('search');
        $model = new GFStokopnameT;
        $modFormulir = new GFFormuliropnameR;
        $instalasi_id = Yii::app()->user->getState('instalasi_id');
        $modDetailFormulir = array();
        $modDetails = array();

        if (!empty($formuliropname_id)){
            $modFormulir = GFFormuliropnameR::model()->find('formuliropname_id ='.$formuliropname_id.' and stokopname_id is null');
            if (count($modFormulir) == 1){
                $model->formuliropname_id = $modFormulir->formuliropname_id;
                $modDetailFormulir = GFFormstokopnameR::model()->findAll('formuliropname_id = '.$modFormulir->formuliropname_id.' and stokopnamedet_id is null');
            }
        }

		$modObat->jenisstokopname = Params::JENISSTOKOPNAME_PENYESUAIAN;
        $model->totalharga = 0;
        $model->totalnetto = 0;
        $model->tglstokopname = $format->formatDateTimeId(date('Y-m-d H:i:s'));
		$model->jenisstokopname = Params::JENISSTOKOPNAME_PENYESUAIAN;
        $model->nostokopname = "- Otomatis -";
        $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
        $model->petugas1_id = Yii::app()->user->getState('pegawai_id');
        $model->petugas1_nama = Yii::app()->user->getState('nama_pegawai'); 

        if (!empty($stokopname_id)){
            $model = GFStokopnameT::model()->findByPk($stokopname_id);
            if ($model){
                $modDetails = GFStokopnamedetT::model()->findAllByAttributes(array('stokopname_id'=>$model->stokopname_id));
				$model->mengetahui_nama = (isset($model->mengetahui) ? $model->mengetahui->NamaLengkap : "");
				$model->petugas2_nama = (isset($model->petugas2) ? $model->petugas2->NamaLengkap : "");
				$model->totalharga = $format->formatNumberForUser($model->totalharga);
				$model->totalnetto = $format->formatNumberForUser($model->totalnetto);
            }
        }
      
        if(isset($_POST['GFStokopnameT']))
        {                     
			$transaction = Yii::app()->db->beginTransaction();
			try{ 
				$model->attributes=$_POST['GFStokopnameT'];
				$model->tglstokopname = $format->formatDateTimeForDb($_POST['GFStokopnameT']['tglstokopname']);
				$model->create_time = date("Y-m-d H:i:s");
				$model->create_loginpemakai_id = Yii::app()->user->id;
				$model->create_ruangan = Yii::app()->user->getState('ruangan_id');
				$model->jenisstokopname = (empty($model->jenisstokopname) ? Params::JENISSTOKOPNAME_PENYESUAIAN : $model->jenisstokopname);
				$model->isstokawal = ($model->jenisstokopname == Params::JENISSTOKOPNAME_PENYESUAIAN ? false : true);
				$model->nostokopname = MyGenerator::noStokOpname(Params::INSTALASI_ID_FARMASI);
				if ($model->validate()){
					if($model->save()){ 
                        if(count($_POST['GFStokopnamedetT']) > 0){
                            foreach($_POST['GFStokopnamedetT'] AS $i => $postOa){
                                if(isset($postOa['cekList'])){
                                    $modDetails[$i] = $this->simpanObatAlkesOpname($model,$postOa);
                                    if (!empty($model->formuliropname_id)){ 
                                        $modFormulir = GFFormuliropnameR::model()->updateByPk($model->formuliropname_id, array('stokopname_id'=>$model->stokopname_id));
                                        $modDetailFormulir = GFFormstokopnameR::model()->find('formuliropname_id = '.$model->formuliropname_id.' and obatalkes_id = '.$modDetails[$i]->obatalkes_id)->formstokopname_id;
                                        $this->updateFormsStokOpname($model, $modDetails[$i]);
                                    }
                                    if ($model->isstokawal){
										$this->simpanStokObatAlkes($modDetails[$i],$modDetails[$i]->volume_fisik);
                                    }else{ //Penyesuaian
										//if($modDetails[$i]->volume_sistem <= 0){ //jika volume sistem 0 / minus maka nonaktifkan stok yg aktif
										//	StokobatalkesT::model()->updateAll(array( 'stokoa_aktif' => false ), "stokoa_aktif = TRUE AND obatalkes_id = ".$modDetails[$i]->obatalkes_id." AND ruangan_id = ".Yii::app()->user->getState('ruangan_id'));
										//}
                                                                                // $modDetails[$i]->jmlselisihstok = $modDetails[$i]->volume_fisik - $modDetails[$i]->volume_sistem;
										// $selisih = ($modDetails[$i]->volume_fisik - $modDetails[$i]->jmlselisihstok) - $modDetails[$i]->volume_sistem;
										$selisih = $modDetails[$i]->jmlselisihstok;
                                        if ($selisih > 0){
                                            $this->simpanStokObatAlkes($modDetails[$i], $selisih);
                                        } else { //jika selisih minus = tambah stok 
                                            $selisih = abs($selisih);
											//$modStokOAs = StokobatalkesT::getStokObatAlkesAktif($modDetails[$i]->obatalkes_id, $selisih, Yii::app()->user->getState('ruangan_id'));
											//if(count($modStokOAs) > 0){
											//	foreach($modStokOAs AS $i => $stok){
													//$this->simpanStokObatAlkesOut($stok['stokobatalkes_id'], $stok->qtystok_terpakai);
                                                                                                        $this->simpanStokObatAlkesOut2($modDetails[$i], $selisih);
											//	}
											//}
                                        }
                                    }
                                }
                                
                            }
                        }                        
                    }

                    if($this->stokopnameobattersimpan && $this->stokobatalkestersimpan && $this->updateformulirstokdetailtersimpan){
                        $transaction->commit();
                        Yii::app()->user->setFlash('success',"Data Berhasil Disimpan ");
                        $this->redirect(array('index', 'stokopname_id'=>$model->stokopname_id,'sukses'=>1));
                    }
                    else{
                        $transaction->rollback();
                        Yii::app()->user->setFlash('error',"Data Gagal Disimpan ");
                    }
				}
			}catch(Exception $ex){
                    $transaction->rollback();
                    Yii::app()->user->setFlash('error', '<strong>Gagal!</strong> Data gagal disimpan.'.MyExceptionMessage::getMessage($ex, true));
                }
        }

        if(isset($_GET['GFInformasistokobatalkesV']))
        {
                $modObat->unsetAttributes();
                $modObat->attributes=$_GET['GFInformasistokobatalkesV'];			
                $modObat->jenisstokopname=$_GET['GFInformasistokobatalkesV']['jenisstokopname'];			
        }

        $this->render($this->path_view.'index',array(
                'model'=>$model,
                'modObat'=>$modObat,
                'modDetails'=>$modDetails,
                'modFormulir'=>$modFormulir,
                'modDetailFormulir'=>$modDetailFormulir,
                'format'=>$format,
        ));
    }
        
    /**
        * simpan GFStockopnamedetT
        * @param type $model
        * @param type $post
        * @return \GFStockopnamedetT
    */
    public function simpanObatAlkesOpname($model ,$post){
        $format = new MyFormatter();
        $obatAlkes = GFObatalkesM::model()->findByPk($post['obatalkes_id']);
        $modDetailOpname = new GFStokopnamedetT;

        $modDetailOpname->attributes = $post;
        $modDetailOpname->stokopname_id = $model->stokopname_id;
		//AGAR STOK REALTIME
        $modDetailOpname->volume_sistem = StokobatalkesT::getJumlahStok($modDetailOpname->obatalkes_id, $modDetailOpname->stokopname->ruangan_id);
        $modDetailOpname->jumlahharga = $modDetailOpname->hargasatuan*$modDetailOpname->volume_fisik;
        $modDetailOpname->jumlahnetto = $modDetailOpname->harganetto*$modDetailOpname->volume_fisik;
        $modDetailOpname->satuankecil_id = $obatAlkes->satuankecil_id;
        $modDetailOpname->sumberdana_id = $obatAlkes->sumberdana_id;
        $modDetailOpname->tglkadaluarsa = $format->formatDateTimeForDb($obatAlkes->tglkadaluarsa);
        $modDetailOpname->tglperiksafisik = $format->formatDateTimeForDb($modDetailOpname->tglperiksafisik);
        $modDetailOpname->jmlselisihstok = $modDetailOpname->volume_fisik - $modDetailOpname->volume_sistem; //$modDetailOpname->getJmlSelisihStok($modDetailOpname->stokopname->ruangan_id);
        
        // var_dump($modDetailOpname->attributes); die;
        
       if($modDetailOpname->validate()) {
           $modDetailOpname->save();
       } else {
           $this->stokopnameobattersimpan  &= false;
       }
       return $modDetailOpname;
    }
    
    public function updateFormsStokOpname($model ,$modStokOpnameDet){
        $format = new MyFormatter();
        $modFormulir = GFFormuliropnameR::model()->findByAttributes(array('stokopname_id'=>$model->stokopname_id));
        $modDetailFormulir = GFFormstokopnameR::model()->find('formuliropname_id = '.$modFormulir->formuliropname_id.' and obatalkes_id = '.$modStokOpnameDet->obatalkes_id.'');
        
        $modDetailFormulir->stokopnamedet_id = $modStokOpnameDet->stokopnamedet_id;
        
       if($modDetailFormulir->validate()) {
           $modDetailFormulir->save();
           GFStokopnamedetT::model()->updateByPk($modStokOpnameDet->stokopnamedet_id,array('formstokopname_id'=>$modDetailFormulir->formstokopname_id));
       } else {
           $this->updateformulirstokdetailtersimpan  &= false;
       }
       return $modDetailFormulir;
    }
    
    public function simpanStokObatAlkes($modDetailOpname,$selisih){
        
        $format = new MyFormatter;
        $modStok = new GFStokObatAlkesT;

        $loadObatAlkes = GFObatAlkesM::model()->findByPk($modDetailOpname->obatalkes_id);
        $modStok->ruangan_id = Yii::app()->user->getState('ruangan_id');
        $modStok->tglkadaluarsa = !empty($modDetailOpname->tglkadaluarsa) ? $format->formatDateTimeForDb($modDetailOpname->tglkadaluarsa) : null;
        $modStok->obatalkes_id = $modDetailOpname->obatalkes_id;
        $modStok->stokopnamedet_id = $modDetailOpname->stokopnamedet_id;
        $modStok->nobatch = "";
        $modStok->tglstok_in = date('Y-m-d H:i:s');
        $modStok->tglstok_out = NULL;
        if(!empty($modDetailOpname->satuanbesar_id)){
            $modStok->qtystok_in = $selisih;
            $modStok->harganetto = ($modDetailOpname->harganetto / $modStok->qtystok_in);
			$modStok->jmlmargin = ($modDetailOpname->hargasatuan - $modDetailOpname->harganetto) / $modStok->qtystok_in;
        }else{
            $modStok->qtystok_in = $selisih;
            $modStok->harganetto = $modDetailOpname->harganetto;
			$modStok->jmlmargin = $modDetailOpname->hargasatuan - $modDetailOpname->harganetto;
        }       

        $modStok->qtystok_out = 0;        
        $modStok->create_time = date('Y-m-d H:i:s');
        $modStok->update_time = date('Y-m-d H:i:s');
        $modStok->create_loginpemakai_id = Yii::app()->user->id;
        $modStok->update_loginpemakai_id = Yii::app()->user->id;
        $modStok->create_ruangan = Yii::app()->user->ruangan_id;
        $modStok->tglterima = date('Y-m-d H:i:s');
        $modStok->satuankecil_id = (isset($modDetailOpname->satuankecil_id) ? $modDetailOpname->satuankecil_id : $loadObatAlkes->satuankecil_id);

        if($modStok->validate()) { 
            $modStok->save();
            $loadObatAlkes->tglkadaluarsa = $modStok->tglkadaluarsa;
            $loadObatAlkes->harganetto = $modStok->harganetto;
            $loadObatAlkes->discount = (($modStok->jmldiscount > 0) ? $modStok->jmldiscount : $modStok->harganetto * $modStok->persendiscount / 100) ;
            $loadObatAlkes->ppn_persen = $modStok->persenppn;
			$loadObatAlkes->hpp = $modStok->HPP;
            $loadObatAlkes->satuankecil_id =$modStok->satuankecil_id;
			$loadObatAlkes->satuanbesar_id = (!empty($loadObatAlkes->satuanbesar_id) ? $loadObatAlkes->satuanbesar_id : Params::DEFAULT_SATUANBESAR_ID);
			$loadObatAlkes->satuanbesar_id = (!empty($modStok->satuanbesar_id) ? $modStok->satuanbesar_id : $loadObatAlkes->satuanbesar_id);

			if($modStok->persenmargin > 0){
				$hargajual = ($modStok->HPP + ($modStok->HPP * ($modStok->persenmargin / 100)));
			}else{
				$hargajual = $modStok->HPP + $modStok->jmlmargin;
			}
			if($hargajual > $loadObatAlkes->hargamaksimum){
				$loadObatAlkes->hargamaksimum = $hargajual;
			}
			if($loadObatAlkes->hargaminimum <= 0 || $hargajual < $loadObatAlkes->hargaminimum){
				$loadObatAlkes->hargaminimum = $hargajual;
			}
			if($loadObatAlkes->hargaaverage > 0 && $hargajual > 0){
				$loadObatAlkes->hargaaverage = ($loadObatAlkes->hargaaverage + $hargajual) / 2;
			}else{
				$loadObatAlkes->hargaaverage = $hargajual;
			}
			$loadObatAlkes->hargajual = $hargajual;
			
            if($loadObatAlkes->save()){
				
			}else{
				$this->stokobatalkestersimpan &= false;
			}

        } else {
            $this->stokobatalkestersimpan &= false;
        }

        return $modStok;      
    }
	
    /**
     * simpan StokobatalkesT Jumlah Out
     * @param type $stokobatalkesasal_id
     * @param type $jumlah = jumlah yang dikeluarkan untuk penyesuaian stok
     * @return \StokobatalkesT
     */
    protected function simpanStokObatAlkesOut2($opnamedet, $jumlah){
        $format = new MyFormatter;
        $oa = ObatalkesM::model()->findByPk($opnamedet->obatalkes_id);
        $modStokOaNew = new StokobatalkesT;
        $modStokOaNew->attributes = $oa->attributes; //duplicate
        $modStokOaNew->unsetIdTransaksi(); //new / autoincrement pk
        $modStokOaNew->qtystok_in = 0;
        $modStokOaNew->qtystok_out = $jumlah;
        $modStokOaNew->create_time = date('Y-m-d H:i:s');
        $modStokOaNew->update_time = date('Y-m-d H:i:s');
        $modStokOaNew->create_loginpemakai_id = Yii::app()->user->id;
        $modStokOaNew->update_loginpemakai_id = Yii::app()->user->id;
        $modStokOaNew->create_ruangan = $modStokOaNew->ruangan_id = Yii::app()->user->getState('ruangan_id');
        $modStokOaNew->tglterima = $opnamedet->tglperiksafisik;
        $modStokOaNew->stokopnamedet_id = $opnamedet->stokopnamedet_id;
        
        if($modStokOaNew->validate()){ 
            $modStokOaNew->save();
        } else {
            $this->stokobatalkestersimpan &= false;
        }
        return $modStokOaNew;      
    }
    
    /**
     * simpan StokobatalkesT Jumlah Out
     * @param type $stokobatalkesasal_id
     * @param type $jumlah = jumlah yang dikeluarkan untuk penyesuaian stok
     * @return \StokobatalkesT
     */
    protected function simpanStokObatAlkesOut($stokobatalkesasal_id,$jumlah){
        $format = new MyFormatter;
        $modStokOa = StokobatalkesT::model()->findByPk($stokobatalkesasal_id);
        $modStokOaNew = new StokobatalkesT;
        $modStokOaNew->attributes = $modStokOa->attributes; //duplicate
        $modStokOaNew->unsetIdTransaksi(); //new / autoincrement pk
        $modStokOaNew->qtystok_in = 0;
        $modStokOaNew->qtystok_out = $jumlah;
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
        
    public function actionPrint($stokopname_id = null)
    {
        $format = new MyFormatter();
        $model = GFStokopnameT::model()->findByPK($stokopname_id);
        $modDetails = GFStokopnamedetT::model()->findAllByAttributes(array('stokopname_id'=>$stokopname_id));
        
        $judulLaporan='Data Stok Obat Alkes Opname';
        $caraPrint=isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null;
        
            if (isset($_GET['frame'])){
                $this->layout='//layouts/iframe';
            }
            if($caraPrint=='PRINT') {
                $this->layout='//layouts/printWindows';
            }
            else if($caraPrint=='EXCEL') {
                $this->layout='//layouts/printExcel';
            }
        
            $this->render($this->path_view.'Print', array(
                    'model'=>$model,
                    'judulLaporan'=>$judulLaporan,
                    'caraPrint'=>$caraPrint,
                    'modDetails'=>$modDetails,
                    'format'=>$format
            ));
                            
    }
    
}
