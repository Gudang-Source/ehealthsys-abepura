<?php

class JurnalPiutangSupplierController extends MyAuthController
{
    public $success = true; //true karena di looping
    
    public function actionIndex(){
      $model = new AKRincianfakturhutangsupplierV();
      $format = new MyFormatter();
      $model->tglAwal = date('d M Y 00:00:00');
      $model->tglAkhir = date('d M Y H:i:s');
      $modJurnalRekening = new JurnalrekeningT;
      $modRekenings = array();
      if(isset($_POST['AKRincianfakturhutangsupplierV'])){
        $transaction = Yii::app()->db->beginTransaction();
        try {
            $noUrut = 1;
            foreach($_POST['AKRincianfakturhutangsupplierV'] AS $i => $post){
                if(isset($post['pilihRekening'])){
                    $cekFaktur = FakturpembelianT::model()->findByPk($post['fakturpembelian_id']);
                    if(isset($cekFaktur)){
                        if(empty($cekFaktur->jurnalrekening_id)){
                            $modJurnalRekening = $this->saveJurnalRekening();
                        }else{
                            $modJurnalRekening = JurnalrekeningT::model()->findByPk($cekFaktur->jurnalrekening_id);
                        }
                        $modJurnalDetail = $this->saveJurnalDetail($modJurnalRekening, $post, $noUrut, true);
                        $cekFaktur->jurnalrekening_id = $modJurnalRekening->jurnalrekening_id;
                        $cekFaktur->update();
                        $noUrut ++;
                    }
                    
                    if($modJurnalRekening && $modJurnalDetail && $cekFaktur){
                        $this->success = $this->success && true;
                    }else{
                        $this->success = false;
                    }
                    //kembalikan nilai jika gagal disimpan
                    $modRekenings[$i] = new AKRincianfakturhutangsupplierV;
                    $modRekenings[$i]->attributes = $post;
                    $modRekenings[$i]->nmrekening5 = $post['nama_rekening'];
                    $modSupplier = SupplierM::model()->findByPk($modRekenings[$i]->supplier_id);
                    $modRekenings[$i]->supplier_nama = $modSupplier->supplier_nama;
                    $modRekenings[$i]->supplier_kode = $modSupplier->supplier_kode;
                }
            }
            if($this->success){
                $transaction->commit();
                Yii::app()->user->setFlash('success',"Posting Jurnal Berhasil");
                $this->refresh();
            }else{
                $transaction->rollback();
            }

            }catch (Exception $exc) {
                $transaction->rollback();
                Yii::app()->user->setFlash('error',"Data Gagal disimpan. ".MyExceptionMessage::getMessage($exc,true));
            }
            Yii::app()->user->setFlash('error',"Data Gagal disimpan. Silahkan pilih rekening dengan benar !");
        }
        
      $this->render('index', array('model'=>$model, 'modRekenings'=>$modRekenings));
    }
    
     /**
    * simpan jurnalrekening_t
    * @return \JurnalrekeningT
    */
    public function saveJurnalRekening()
    {
        $modJurnalRekening = new JurnalrekeningT;
        $modJurnalRekening->tglbuktijurnal = date('Y-m-d H:i:s');
        $modJurnalRekening->nobuktijurnal = MyGenerator::noBuktiJurnalRek();
        $modJurnalRekening->kodejurnal = MyGenerator::kodeJurnalRek();
        $modJurnalRekening->noreferensi = 0;
        $modJurnalRekening->tglreferensi = date('Y-m-d H:i:s');
        $modJurnalRekening->nobku = "";
        $modJurnalRekening->urianjurnal = "";
        $modJurnalRekening->jenisjurnal_id = Params::JENISJURNAL_ID_PENERIMAAN_KAS;
        $modJurnalRekening->rekperiod_id = $modJurnalRekening->rekperiod_id = RekperiodM::model()->findByAttributes(array('isclosing'=>false))->rekperiod_id;
        $modJurnalRekening->create_time = date('Y-m-d H:i:s');
        $modJurnalRekening->create_loginpemakai_id = Yii::app()->user->id;
        $modJurnalRekening->create_ruangan = Yii::app()->user->getState('ruangan_id');
        if($modJurnalRekening->validate()){
            $modJurnalRekening->save();
        } else {
            $modJurnalRekening['errorMsg'] = $modJurnalRekening->getErrors();
        }
        return $modJurnalRekening;
    }
    /**
     * simpan jurnaldetail_t dan jurnalposting_t digunakan di:
     * - akuntansi/JurnalPiutangSupplier
     */
    public function saveJurnalDetail($modJurnalRekening, $post, $noUrut=0, $isPosting = false){
        $modJurnalPosting = null;
        if($isPosting == true){
            $modJurnalPosting = new JurnalpostingT;
            $modJurnalPosting->tgljurnalpost = date('Y-m-d H:i:s');
            $modJurnalPosting->keterangan = "Posting automatis";
            $modJurnalPosting->create_time = date('Y-m-d H:i:s');
            $modJurnalPosting->create_loginpemekai_id = Yii::app()->user->id;
            $modJurnalPosting->create_ruangan = Yii::app()->user->getState('ruangan_id');
            if($modJurnalPosting->validate()){
                $modJurnalPosting->save();
            }
        }
        $modJurnalDetail = new JurnaldetailT();
        $modJurnalDetail->jurnalposting_id = ($modJurnalPosting == null ? null : $modJurnalPosting->jurnalposting_id);
        $modJurnalDetail->rekperiod_id = $modJurnalRekening->rekperiod_id;
        $modJurnalDetail->jurnalrekening_id = $modJurnalRekening->jurnalrekening_id;
        $modJurnalDetail->uraiantransaksi = $post['nama_rekening'];
        $modJurnalDetail->saldodebit = $post['saldodebit'];
        $modJurnalDetail->saldokredit = $post['saldokredit'];
        $modJurnalDetail->nourut = $noUrut;
        $modJurnalDetail->rekening1_id = $post['rekening1_id'];
        $modJurnalDetail->rekening2_id = $post['rekening2_id'];
        $modJurnalDetail->rekening3_id = $post['rekening3_id'];
        $modJurnalDetail->rekening4_id = $post['rekening4_id'];
        $modJurnalDetail->rekening5_id = $post['rekening5_id'];
        $modJurnalDetail->catatan = "";
        if($modJurnalDetail->validate()){
            $modJurnalDetail->save();
        }
        return $modJurnalDetail;        
    }
	
	/**
     * actionGetRekeningPiutangSupplier digunakan di :
     * akuntansi/views/jurnalPiutangSupplier/_jsFunctions
     */
    public function actionGetRekeningPiutangSupplier()
    {
        if(Yii::app()->request->isAjaxRequest) {
            $model = new AKRincianfakturhutangsupplierV;
            $format = new MyFormatter();
            if(isset($_POST['AKRincianfakturhutangsupplierV'])){
                $model->attributes = $_POST['AKRincianfakturhutangsupplierV'];
                $model->tglAwal = $format->formatDateTimeForDB($_POST['AKRincianfakturhutangsupplierV']['tglAwal']);
                $model->tglAkhir = $format->formatDateTimeForDB($_POST['AKRincianfakturhutangsupplierV']['tglAkhir']);
            }
            $criteria = new CDbCriteria;
            $criteria = $model->criteriaFunction();
            $models = AKRincianfakturhutangsupplierV::model()->findAll($criteria);
            foreach($models AS $i => $model){ //untuk membedakan tindakan / obat di form jurnal
                $models[$i]['saldodebit'] = 0;    
                $models[$i]['saldokredit'] = 0;    
                if($models[$i]['saldonormal'] == "D"){
                    $models[$i]['saldodebit'] = $model->saldotransaksi;
                }else{
                    $models[$i]['saldokredit'] = $model->saldotransaksi;
                }
            }
            if(count($models)>0){
                echo CJSON::encode(
                    $this->renderPartial('akuntansi.views.jurnalPiutangSupplier._rowRekening', array('modRekenings'=>$models), true)
                );                
            }else{
                echo "Data tidak ditemukan !";
            }
            Yii::app()->end();
        }        
    }
    
}
?>