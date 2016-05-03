<?php

class PemakaianObatController extends MyAuthController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column1';
        public $defaultAction = 'index';
        public $path_view = 'farmasiApotek.views.pemakaianObat.';
	public $pemakaianobatsimpan = false;
	public $pemakaianobatdetailsimpan = true; //looping
	public $stokobatalkestersimpan = true; //looping
	
	public function actionIndex($pemakaianobat_id= null)
	{
		$model = new FAPemakaianobatT();
		$model->nopemakaian_obat = '-Otomatis-';
		$modDetails = array();
				
		if(!empty($pemakaianobat_id)){
			$model = FAPemakaianobatT::model()->findByPk($pemakaianobat_id);
			$modDetails = FAPemakaianobatdetailT::model()->findAllByAttributes(array('pemakaianobat_id'=>$pemakaianobat_id));
		}
		
		$transaction = Yii::app()->db->beginTransaction();
		if(isset($_POST['FAPemakaianobatT'])){
			$model = $this->savePemakaianObat($_POST['FAPemakaianobatT']);
			if($this->pemakaianobatsimpan){
				if(count($_POST['FAPemakaianobatdetailT']) > 0){
					//PROSES GROUP DETAIL BERDASARKAN obatalkes_id & akumulasikan jmlmutasi
					$detailGroups = array();
					foreach($_POST['FAPemakaianobatdetailT'] AS $i => $postDetail){
						$modDetails[$i] = new FAPemakaianobatdetailT;
						$modDetails[$i]->attributes = $postDetail;
                                                $modDetails[$i] = $this->savePemakaianObatDetail2($model, $postDetail );
						$this->simpanStokObatAlkesOut2($modDetails[$i]);
                                                /*
                                                $modStok = StokobatalkesT::model()->findByPk($postDetail['stokobatalkes_id']);
						$modDetails[$i]->stokobatalkes_id = $modStok->stokobatalkes_id;
						$obatalkes_id = $postDetail['obatalkes_id'];
						if(isset($detailGroups[$obatalkes_id])){
							$detailGroups[$obatalkes_id]['qty_satuanpakai'] += $postDetail['qty_satuanpakai'];
						}else{
							$detailGroups[$obatalkes_id]['obatalkes_id'] = $postDetail['obatalkes_id'];
							$detailGroups[$obatalkes_id]['qty_satuanpakai'] = $postDetail['qty_satuanpakai'];
						} */
					}
					//END GROUP
				}
                                /*
				$obathabis = "";
                //PROSES PENGURAIAN OBAT DAN JUMLAH MENJADI STOKOBATALKES_T (METODE ANTRIAN)
                foreach($detailGroups AS $i => $detail){
                    $modStokOAs = StokobatalkesT::getStokObatAlkesAktif($detail['obatalkes_id'], $detail['qty_satuanpakai'], Yii::app()->user->getState('ruangan_id'));
                    if(count($modStokOAs) > 0){
                        foreach($modStokOAs AS $i => $stok){
                            $modDetails[$i] = $this->savePemakaianObatDetail($model, $stok, $_POST['FAPemakaianobatdetailT'] );
                            $this->simpanStokObatAlkesOut($stok['stokobatalkes_id'], $modDetails[$i]);
                        }
                    }else{
                        $this->stokobatalkestersimpan &= false;
                        $obathabis .= "<br>- ".ObatalkesM::model()->findByPk($detail['obatalkes_id'])->obatalkes_nama;
                    }
                } */
				//die;
				try {
					if($this->pemakaianobatdetailsimpan&&$this->stokobatalkestersimpan){
						$transaction->commit();
                        $sukses = 1;
                        $this->redirect(array('index','pemakaianobat_id'=>$model->pemakaianobat_id, 'sukses'=>$sukses));
					}else{
                        $transaction->rollback();
                        Yii::app()->user->setFlash('error',"Data detail pemakaian obat gagal disimpan !");
                        if(!$this->stokobatalkestersimpan){
                            Yii::app()->user->setFlash('error',"Data detail pemakaian obat gagal disimpan ! Stok obat berikut tidak mencukupi !:".$obathabis);
                        }
                    }
				} catch (Exception $e) {
                    $transaction->rollback();
                    Yii::app()->user->setFlash('error',"Data pemakaian obat gagal disimpan ! ".MyExceptionMessage::getMessage($e,true));
                }
				
			}
		}
		
		$this->render($this->path_view.'index',array(
			'model'=>$model, 'modDetails'=>$modDetails
		));
	}
        
        public function actionInformasi() {
            $model = new PemakaianobatT;
            $model->unsetAttributes();
            $model->tglAwal = date('Y-m-d', time() - (3600 * 24 * 10));
            $model->tglAkhir = date('Y-m-d');
            $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
            if (isset($_GET['PemakaianobatT'])) {
                $model->attributes = $_GET['PemakaianobatT'];
                $model->tglAwal = MyFormatter::formatDateTimeForDb($_GET['PemakaianobatT']['tglAwal']);
                $model->tglAkhir = MyFormatter::formatDateTimeForDb($_GET['PemakaianobatT']['tglAkhir']);

            }

            $this->render($this->path_view.'informasi', array('model' => $model));
        }
        
        public function actionDetail($id) {
		$this->layout='//layouts/iframe';
		$model = FAPemakaianobatT::model()->findByPk($id);
		$modDetails = FAPemakaianobatdetailT::model()->findAllByAttributes(array('pemakaianobat_id'=>$id));
		$this->render($this->path_view.'detail', array(
			'model'=>$model,
			'modDetails'=>$modDetails,
		));
        }
	
	protected function savePemakaianObat($postpemakaian)
	{
		$format = new MyFormatter();
		$model = new FAPemakaianobatT();
		$model->attributes = $postpemakaian;
		$model->nopemakaian_obat = MyGenerator::noPemakaianObat();
		$model->create_time = date("Y-m-d H:i:s");
		$model->pegawai_id = Yii::app()->user->getState('pegawai_id'); //Yii::app()->user->id;
		$model->ruangan_id = Yii::app()->user->getState('ruangan_id');
		$model->create_loginpemakai_id = Yii::app()->user->id;
		$model->create_ruangan = Yii::app()->user->getState('ruangan_id');
		if($model->validate()){
			$model->save();
			$this->pemakaianobatsimpan = true;
		} else {
			$this->pemakaianobatsimpan = false;
			Yii::app()->user->setFlash('error',"Data Pemakaian Obat Tidak valid");
		}
		return $model;
	}
	
        protected function savePemakaianObatDetail2($model,$postPemakaianObatDetail){
            $format = new MyFormatter;
            $oa = ObatalkesM::model()->findByPk($postPemakaianObatDetail['obatalkes_id']);
            $modPemakaianObatDetail = new FAPemakaianobatdetailT();
            $modPemakaianObatDetail->attributes = $postPemakaianObatDetail;
            $modPemakaianObatDetail->pemakaianobat_id = $model->pemakaianobat_id;
            //$modPemakaianObatDetail->qty_satuanpakai = $stokOa->qtystok_terpakai;
            //$modPemakaianObatDetail->harga_satuanpakai = $stokOa->HargaJualSatuan;
            //$modPemakaianObatDetail->harganetto_satuanpakai = $stokOa->HPP;
            $modPemakaianObatDetail->ket_obatpakai = $model->ket_pemakaianobat;
            $modPemakaianObatDetail->satuankecil_id = $oa->satuankecil_id;
            if($modPemakaianObatDetail->save()){
                $this->pemakaianobatdetailsimpan &= true;
            }else{
                $this->pemakaianobatdetailsimpan &= false;
            }
            return $modPemakaianObatDetail;
        }
        
	protected function savePemakaianObatDetail($model,$stokOa,$postPemakaianObatDetail){
            $format = new MyFormatter;
            $modPemakaianObatDetail = new FAPemakaianobatdetailT();
            $modPemakaianObatDetail->attributes = $stokOa->attributes;
            $modPemakaianObatDetail->pemakaianobat_id = $model->pemakaianobat_id;
            $modPemakaianObatDetail->qty_satuanpakai = $stokOa->qtystok_terpakai;
            $modPemakaianObatDetail->harga_satuanpakai = $stokOa->HargaJualSatuan;
            $modPemakaianObatDetail->harganetto_satuanpakai = $stokOa->HPP;
            $modPemakaianObatDetail->ket_obatpakai = $model->ket_pemakaianobat;
            if($modPemakaianObatDetail->save()){
                $this->pemakaianobatdetailsimpan &= true;
            }else{
                $this->pemakaianobatdetailsimpan &= false;
            }
            return $modPemakaianObatDetail;
        }
	
    protected function simpanStokObatAlkesOut2($modPemakaianObatDetail){
        $format = new MyFormatter;
        //$modStokOa = StokobatalkesT::model()->findByPk($stokobatalkesasal_id);
	$oa = ObatalkesM::model()->findByPk($modPemakaianObatDetail->obatalkes_id);	
        $modStokOaNew = new StokobatalkesT;
        $modStokOaNew->attributes = $modPemakaianObatDetail->attributes; //duplicate
        $modStokOaNew->attributes = $oa->attributes;
        //$modStokOaNew->unsetIdTransaksi(); //new / autoincrement pk
        $modStokOaNew->qtystok_in = 0;
        $modStokOaNew->qtystok_out = $modPemakaianObatDetail->qty_satuanpakai;
        $modStokOaNew->pemakaianobatdetail_id = $modPemakaianObatDetail->pemakaianobatdetail_id;
        //$modStokOaNew->stokobatalkesasal_id = $stokobatalkesasal_id;
        $modStokOaNew->create_time = $modStokOaNew->tglterima = date('Y-m-d H:i:s');
        $modStokOaNew->update_time = date('Y-m-d H:i:s');
        $modStokOaNew->create_loginpemakai_id = Yii::app()->user->id;
        $modStokOaNew->update_loginpemakai_id = Yii::app()->user->id;
        $modStokOaNew->create_ruangan = $modStokOaNew->ruangan_id = Yii::app()->user->ruangan_id;
        $modStokOaNew->validate();
        //var_dump($modStokOaNew->errors); die;
        
        if($modStokOaNew->validate()){ 
            $modStokOaNew->save();
            //$modStokOaNew->setStokOaAktifBerdasarkanStok();
        } else {
            $this->stokobatalkestersimpan &= false;
        }
        return $modStokOaNew;      
    }
    
    protected function simpanStokObatAlkesOut($stokobatalkesasal_id,$modPemakaianObatDetail){
        $format = new MyFormatter;
        $modStokOa = StokobatalkesT::model()->findByPk($stokobatalkesasal_id);
		
        $modStokOaNew = new StokobatalkesT;
        $modStokOaNew->attributes = $modStokOa->attributes; //duplicate
        $modStokOaNew->unsetIdTransaksi(); //new / autoincrement pk
        $modStokOaNew->qtystok_in = 0;
        $modStokOaNew->qtystok_out = $modPemakaianObatDetail->qty_satuanpakai;
        $modStokOaNew->pemakaianobatdetail_id = $modPemakaianObatDetail->pemakaianobatdetail_id;
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
	
	public function actionAutocompleteObatReseptur()
    {
            if(Yii::app()->request->isAjaxRequest)
            {
                $term = explode(';',$_GET['term']);
                $obatalkes_nama = isset($term[0])?$term[0]:'';
                $hargajual = isset($term[1])?$term[1]:'';
                $criteria = new CDbCriteria();
                $criteria->compare('LOWER(obatalkes_nama)', strtolower($obatalkes_nama), true);
                if($hargajual!=''){
                    $criteria->addCondition('hargajual ='.$hargajual,'or');
                }
                $criteria->addCondition('obatalkes_farmasi = TRUE');
                $criteria->addCondition('obatalkes_aktif = true');
                $criteria->order = 'obatalkes_nama';
                $criteria->limit = 5;
                $models = ObatalkesM::model()->with('sumberdana','satuankecil')->findAll($criteria);
                $persenjual = $this->persenJualRuangan();
                $format = new MyFormatter();
				if(count($models)>0){
					foreach($models as $i=>$model)
					{
						$attributes = $model->attributeNames();

						foreach($attributes as $j=>$attribute) {
							$returnVal[$i]["$attribute"] = $model->$attribute;
						}
						$qtyStok = StokobatalkesT::getJumlahStok($model->obatalkes_id, Yii::app()->user->getState('ruangan_id'));
						$returnVal[$i]['label'] = $model->obatalkes_kode." - ".$model->obatalkes_nama." - Jumlah Stok ".$qtyStok;
						$returnVal[$i]['value'] = $model->obatalkes_nama;
						$returnVal[$i]['obatalkes_id'] = $model->obatalkes_id;
						$returnVal[$i]['sumberdana_nama'] = $model->sumberdana->sumberdana_nama;
						$returnVal[$i]['qtyStok'] = $qtyStok;
						$returnVal[$i]['hargajual'] = floor(($persenjual + 100 ) / 100 * $model->hargajual);
						$returnVal[$i]['satuankecil'] = $model->satuankecil->satuankecil_nama;
						$returnVal[$i]['idsatuankecil'] = $model->satuankecil_id;
						$returnVal[$i]['diskonJual'] = empty($model->diskonJual) ? 0 : $model->diskonJual;
						$returnVal[$i]['kadaluarsa'] = ((strtotime($format->formatDateTimeForDb($model->tglkadaluarsa)) - strtotime(date('Y-m-d'))) > 0) ? 0 : 1 ;
					}
				}else{
					$returnVal =null;
				}
                
                echo CJSON::encode($returnVal);
            }
            Yii::app()->end();
    }
	
	protected function persenJualRuangan()
    {
        switch(Yii::app()->user->getState('instalasi_id')){
            case Params::INSTALASI_ID_RI : $persen = Yii::app()->user->getState('ri_persjual');
                                            break;
            case Params::INSTALASI_ID_RJ : $persen = Yii::app()->user->getState('rj_persjual');
                                            break;
            case Params::INSTALASI_ID_RD : $persen = Yii::app()->user->getState('rd_persjual');
                                            break;
            default : $persen = 0; break;
        }

        return $persen;
    }
	
	public function actionSetFormObatAlkesPasien()
    {
        if(Yii::app()->request->isAjaxRequest) { 
            $obatalkes_id = $_POST['obatalkes_id'];
            $jumlah = $_POST['jumlah'];
            $form = "";
            $pesan = "";
            $format = new MyFormatter();
			$modPemakaianObatDetail = new FAPemakaianobatdetailT();
            $ruangan_id = Yii::app()->user->getState('ruangan_id');
            $modStokOAs = StokobatalkesT::getStokObatAlkesAktif($obatalkes_id, $jumlah, $ruangan_id);
            $oa = ObatalkesM::model()->findByPk($obatalkes_id);
            //if(count($modStokOAs) > 0){

                //foreach($modStokOAs AS $i => $stok){
					$modPemakaianObatDetail->satuankecil_id = $oa->satuankecil_id; //$stok->satuankecil_id;
					$modPemakaianObatDetail->obatalkes_id = $oa->obatalkes_id; //$stok->obatalkes_id;
					$modPemakaianObatDetail->stokobatalkes_id = null; //$stok->stokobatalkes_id;
					$modPemakaianObatDetail->qty_satuanpakai = $jumlah; //$stok->qtystok_terpakai;
					$modPemakaianObatDetail->harga_satuanpakai = $oa->hargajual; //$stok->HargaJualSatuan;
					$modPemakaianObatDetail->harganetto_satuanpakai = $oa->harganetto; //$stok->HPP;
					$modPemakaianObatDetail->jmlstok = 0; //$stok->qtystok;
					$modPemakaianObatDetail->subtotal = $modPemakaianObatDetail->qty_satuanpakai*$modPemakaianObatDetail->harga_satuanpakai;
                    $form .= $this->renderPartial($this->path_view.'_rowDetail', array('modPemakaianObatDetail'=>$modPemakaianObatDetail), true);
                //}
            //}else{
            //    $pesan = "Stok tidak mencukupi!";
            //}
            
            echo CJSON::encode(array('form'=>$form, 'pesan'=>$pesan));
            Yii::app()->end(); 
        }
    }
	
	public function actionPrint($id){
		$this->layout='//layouts/printWindows'; 
		$caraPrint = $_REQUEST['caraPrint'];
		$judulLaporan='Data Pemakaian Obat';
		$model = FAPemakaianobatT::model()->findByPk($id);
		$modDetails = FAPemakaianobatdetailT::model()->findAllByAttributes(array('pemakaianobat_id'=>$id));
		$this->render($this->path_view.'print', array(
			'judulLaporan'=>$judulLaporan,
			'model'=>$model,
			'modDetails'=>$modDetails,
			'caraPrint'=>$caraPrint,
		));
	}
        
}
