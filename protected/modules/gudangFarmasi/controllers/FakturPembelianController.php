<?php

class FakturPembelianController extends MyAuthController
{
    public $defaultAction = 'index';
    public $path_view = 'gudangFarmasi.views.fakturPembelian.';
    public $fakturpembeliantersimpan = true;
    public $fakturpembeliandetailtersimpan = true;
    
    public function actionIndex($penerimaanbarang_id = null, $fakturpembelian_id = null){
        $format = new MyFormatter();
        $modPenerimaanBarang = new GFPenerimaanBarangT;
        $modFakturPembelian = new GFFakturpembelianT;
        $modDetails = array();
        
        $modFakturPembelian->tglfaktur = date('Y-m-d H:i:s');
        $modFakturPembelian->tgljatuhtempo = date('Y-m-d H:i:s');
        $modFakturPembelian->biayamaterai = 0;        
        
        if(!empty($penerimaanbarang_id)){
            $modPenerimaanBarang= GFPenerimaanBarangT::model()->findByPk($penerimaanbarang_id);
            $modDetails = GFPenerimaanDetailT::model()->findAllByAttributes(array('penerimaanbarang_id'=>$penerimaanbarang_id));
        }
        
        if(!empty($fakturpembelian_id)){
            $modFakturPembelian = GFFakturpembelianT::model()->findByPk($fakturpembelian_id);
            $modFakturPembelianDetail = GFFakturDetailT::model()->findAllByAttributes(array('fakturpembelian_id'=>$fakturpembelian_id));
            $modDetails = GFPenerimaanDetailT::model()->findAllByAttributes(array('penerimaanbarang_id'=>$modFakturPembelian->penerimaanbarang_id));
        }
        
        if (isset($_POST['GFFakturpembelianT'])) {
            $transaction = Yii::app()->db->beginTransaction();
            try {
                
                $modFakturPembelian->attributes=$_POST['GFFakturpembelianT'];
                $modFakturPembelian->penerimaanbarang_id = $_POST['GFPenerimaanBarangT']['penerimaanbarang_id'];
                $modFakturPembelian->supplier_id = $_POST['GFPenerimaanBarangT']['supplier_id'];
                $modFakturPembelian->tglfaktur = $format->formatDateTimeForDb($modFakturPembelian->tglfaktur);
                $modFakturPembelian->tgljatuhtempo = $format->formatDateTimeForDb($modFakturPembelian->tgljatuhtempo);
                $modFakturPembelian->ruangan_id = Yii::app()->user->getState('ruangan_id');
                // $modFakturPembelian->ruangan_id = Yii::app()->user->id;

                if($modFakturPembelian->save()){
                    $updatePenerimaanBarang = GFPenerimaanBarangT::model()->updateByPk($_POST['GFPenerimaanBarangT']['penerimaanbarang_id'],array('fakturpembelian_id'=>$modFakturPembelian->fakturpembelian_id));
                    if(count($_POST['GFPenerimaanDetailT']) > 0){
                       foreach($_POST['GFPenerimaanDetailT'] AS $i => $postFakturDetail){
                           $modDetails[$i] = $this->simpanFakturDetail($postFakturDetail,$modFakturPembelian);
                       }
                    }
                }
				
                if($this->fakturpembeliantersimpan && $this->fakturpembeliandetailtersimpan){
                    $transaction->commit();
                    $modFakturPembelian->isNewRecord = FALSE;
                    $this->redirect(array('index','fakturpembelian_id'=>$modFakturPembelian->fakturpembelian_id,'sukses'=>1));
                }else{
                    $transaction->rollback();
                    Yii::app()->user->setFlash('error',"Data Faktur Pembelian gagal disimpan !");
                }
            } catch (Exception $e) {
                $transaction->rollback();
                Yii::app()->user->setFlash('error',"Data Faktur Pembelian gagal disimpan ! ".MyExceptionMessage::getMessage($e,true));
            }
        }
        
        $this->render($this->path_view.'index',array(
            'format'=>$format,
            'modPenerimaanBarang'=>$modPenerimaanBarang,
            'modFakturPembelian'=>$modFakturPembelian,
            'modDetails'=>$modDetails,
        ));
    }
    
    /**
     * simpan GFFakturDetailT
     * @param type $modPenerimaanBarang
     * @param type $post
     * @return \GFPenerimaanDetailT
     */
    public function simpanFakturDetail($postFakturDetail,$modFakturPembelian){
        $format = new MyFormatter();        
        $modFakturDetail = new GFFakturDetailT;
        $modStok = GFStokObatAlkesT::model()->findByAttributes(array('penerimaandetail_id'=>$postFakturDetail['penerimaandetail_id']));
        
        $modFakturDetail->attributes = $postFakturDetail;
        $modFakturDetail->penerimaandetail_id = $postFakturDetail['penerimaandetail_id'];
        $modFakturDetail->fakturpembelian_id = $modFakturPembelian->fakturpembelian_id;
        $modFakturDetail->harganettofaktur = $postFakturDetail['harganettoper'];
        $modFakturDetail->persenppnfaktur = $postFakturDetail['persenppn'];
        $modFakturDetail->persenpphfaktur = $postFakturDetail['persenpph'];
        $modFakturDetail->persendiscount = $postFakturDetail['persendiscount'];
        $modFakturDetail->jmldiscount = $postFakturDetail['jmldiscount'];
        $modFakturDetail->hargasatuan = floor(($postFakturDetail['harganettoper'] - ($modFakturDetail->jmldiscount / $modFakturDetail->jmlterima)));
        $modFakturDetail->kemasanbesar = $postFakturDetail['kemasanbesar'];
        $modFakturDetail->tglkadaluarsa = $format->formatDateTimeForDb($modFakturDetail['tglkadaluarsa']);
        
        if($modFakturDetail->validate()) { 
            $modFakturDetail->save();
            $updatePenerimaan = GFPenerimaanDetailT::model()->updateByPk($modFakturDetail->penerimaandetail_id,array('fakturdetail_id'=>$modFakturDetail->fakturdetail_id));            
            $modStok->tglkadaluarsa = !empty($modFakturDetail->tglkadaluarsa) ? $format->formatDateTimeForDb($modFakturDetail->tglkadaluarsa) : null;
            $modStok->nobatch = "";
            $modStok->qtystok_in = $modFakturDetail->jmlterima;
            $modStok->qtystok_out = 0;
            $modStok->harganetto = $modFakturDetail->harganettofaktur;
            $modStok->persendiscount = $modFakturDetail->persendiscount;
            $modStok->jmldiscount = $modFakturDetail->jmldiscount;
            $modStok->persenppn = $modFakturDetail->persenppnfaktur;
            $modStok->persenpph = $modFakturDetail->persenpphfaktur;
            $modStok->jmlmargin = 0;
            $modStok->update_time = date('Y-m-d H:i:s');
            $modStok->update_loginpemakai_id = Yii::app()->user->id;
            $modStok->save();
        } else {
            $this->fakturpembeliandetailtersimpan &= false;
        }
        return $modFakturDetail;
    }
    
    /**
     * untuk print data penerimaan barang farmasi
     */
    public function actionPrint($fakturpembelian_id,$caraPrint = null) 
    {
        $format = new MyFormatter;    
        $modFakturPembelian = GFFakturpembelianT::model()->findByPk($fakturpembelian_id);     
        $modFakturPembelianDetail = GFFakturDetailT::model()->findAllByAttributes(array('fakturpembelian_id'=>$fakturpembelian_id));
        $modPenerimaanBarang = GFPenerimaanBarangT::model()->findByAttributes(array('fakturpembelian_id'=>$fakturpembelian_id));

        $judul_print = 'Faktur Pembelian';
                
        $caraPrint = isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null;
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
                'format'=>$format,
                'judul_print'=>$judul_print,
                'modFakturPembelian'=>$modFakturPembelian,
                'modFakturPembelianDetail'=>$modFakturPembelianDetail,
                'modPenerimaanBarang'=>$modPenerimaanBarang,
                'caraPrint'=>$caraPrint
        ));
    }
	
	public function actionLoadPenerimaanBarang()
    {
        if(Yii::app()->request->isAjaxRequest) { 
            $penerimaanbarang_id = $_POST['penerimaanbarang_id'];
			
            $form = "";
            $pesan = "";
            
            $modPenerimaanDetail = GFPenerimaanDetailT::model()->findAllByAttributes(array('penerimaanbarang_id'=>$penerimaanbarang_id));
            
            if(count($modPenerimaanDetail) > 0){
                foreach($modPenerimaanDetail AS $i => $penerimaandetail){
                    $form .= $this->renderPartial($this->path_view.'_rowObatFakturPembelian', array('modFakturDetail'=>$penerimaandetail), true);
                }
            }else{
                $pesan = "Tidak ditemukan data detail faktur obat alkes!";
            }
            echo CJSON::encode(array('form'=>$form, 'pesan'=>$pesan));
            Yii::app()->end(); 
        }
    }
	
	public function actionAutoCompletePenerimaanBarang(){
		if(Yii::app()->request->isAjaxRequest) {
            $criteria = new CDbCriteria();
            $criteria->compare('LOWER(noterima)', strtolower($_GET['term']), true);
            $criteria->order = 'noterima';
            $criteria->limit = 5;
            $models = GFInformasipenerimaanbarangV::model()->findAll($criteria);
            $returnVal = array();
            foreach($models as $i=>$model)
            {
                $attributes = $model->attributeNames();
                foreach($attributes as $j=>$attribute) {
                    $returnVal[$i]["$attribute"] = $model->$attribute;
                }
                $returnVal[$i]['label'] = $model->noterima." - ".MyFormatter::formatDateTimeForUser($model->tglterima);
                $returnVal[$i]['value'] = $model->noterima;
                $returnVal[$i]['tglterima'] = $model->tglterima;
                $returnVal[$i]['supplier_nama'] = $model->supplier_nama;
                $returnVal[$i]['supplier_id'] = $model->supplier_id;
                $returnVal[$i]['penerimaanbarang_id'] = $model->penerimaanbarang_id;
            }
            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
	}
	
}
