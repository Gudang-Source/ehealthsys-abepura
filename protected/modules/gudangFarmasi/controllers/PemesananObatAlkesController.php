<?php 
class PemesananObatAlkesController extends MyAuthController{

	public $defaultAction = 'index';
    public $path_view = 'gudangFarmasi.views.pemesananObatAlkes.';
    public $pesanobatalkestersimpan = true;

    public function actionIndex($pesanobatalkes_id = null){
    	$format = new MyFormatter();
    	$modPesanObatalkes = new GFPesanobatalkesT;
    	$modPesanObatalkes->tglpemesanan = date('Y-m-d H:i:s');
    	$modPesanObatalkes->tglmintadikirim = date('Y-m-d H:i:s');
        $modPesanObatalkes->instalasitujuan_id = Params::INSTALASI_ID_FARMASI;
    	$modDetails = array();
        $instalasiTujuans = CHtml::listData(GFInstalasiM::getInstalasiTujuanMutasis(),'instalasi_id','instalasi_nama');
        $ruanganTujuans = CHtml::listData(GFRuanganM::getRuanganTujuanMutasis($modPesanObatalkes->instalasitujuan_id),'ruangan_id','ruangan_nama');

    	if(!empty($pesanobatalkes_id)){
            $modPesanObatalkes= GFPesanobatalkesT::model()->findByPk($pesanobatalkes_id);
            $modPesanObatalkes->pegawaimengetahui_nama = !empty($modPesanObatalkes->pegawaimengetahui->NamaLengkap) ? $modPesanObatalkes->pegawaimengetahui->NamaLengkap : "";
            $modPesanObatalkes->pegawaipemesan_nama = !empty($modPesanObatalkes->pegawaipemesan->NamaLengkap) ? $modPesanObatalkes->pegawaipemesan->NamaLengkap : "";
            $modDetails = GFPesanoadetailT::model()->findAllByAttributes(array('pesanobatalkes_id'=>$modPesanObatalkes->pesanobatalkes_id));
        }

        if(isset($_POST['GFPesanobatalkesT'])){
            $transaction = Yii::app()->db->beginTransaction();
            try {

                    $modPesanObatalkes->attributes=$_POST['GFPesanobatalkesT'];
                    $modPesanObatalkes->nopemesanan = MyGenerator::noPemesanan(Yii::app()->user->getState('instalasi_id'));
                    $modPesanObatalkes->tglpemesanan=$format->formatDateTimeForDb($_POST['GFPesanobatalkesT']['tglpemesanan']);
                    $modPesanObatalkes->tglmintadikirim=$format->formatDateTimeForDb($_POST['GFPesanobatalkesT']['tglmintadikirim']);
                    $modPesanObatalkes->ruanganpemesan_id = Yii::app()->user->getState('ruangan_id');
                    $modPesanObatalkes->create_time = date('Y-m-d H:i:s');
                    $modPesanObatalkes->update_time = date('Y-m-d H:i:s');
                    $modPesanObatalkes->create_loginpemakai_id = Yii::app()->user->id;
                    $modPesanObatalkes->update_loginpemakai_id = Yii::app()->user->id;
                    $modPesanObatalkes->create_ruangan = Yii::app()->user->ruangan_id;

                    if($modPesanObatalkes->save()){
                        if (isset($_POST['GFPesanoadetailT'])) {
                            if(count($_POST['GFPesanoadetailT']) > 0){
                               foreach($_POST['GFPesanoadetailT'] AS $i => $postOa){
                                   $modDetails[$i] = $this->simpanPesanObatalkes($modPesanObatalkes,$postOa);
                               }
                            }
                        }else{
                            $this->pesanobatalkestersimpan = false;
                        }
                    }
                if($this->pesanobatalkestersimpan){
                    $transaction->commit();
                    $modPesanObatalkes->isNewRecord = FALSE;
                    $this->redirect(array('index','pesanobatalkes_id'=>$modPesanObatalkes->pesanobatalkes_id,'sukses'=>1));
                }else{
                    $transaction->rollback();
                    Yii::app()->user->setFlash('error',"Data Pemesanan Obat Alkes gagal disimpan !");
                }
            } catch (Exception $e) {
                $transaction->rollback();
                Yii::app()->user->setFlash('error',"Data Pemesanan Obat Alkes gagal disimpan ! ".MyExceptionMessage::getMessage($e,true));
            }
        }

    	$this->render($this->path_view.'index',array(
            'format'=>$format,
            'modPesanObatalkes'=>$modPesanObatalkes,
            'modDetails'=>$modDetails,
            'instalasiTujuans'=>$instalasiTujuans,
            'ruanganTujuans'=>$ruanganTujuans,
        ));
    }

    /**
     * simpan GFPesanoadetailT
     * @param type $modPesanObatalkes
     * @param type $post
     * @return \GFPesanoadetailT
     */
    public function simpanPesanObatalkes($modPesanObatalkes ,$post){
        $format = new MyFormatter();
        $modDetailPesanOA = new GFPesanoadetailT;
        $modDetailPesanOA->attributes = $post;
        $modDetailPesanOA->pesanobatalkes_id = $modPesanObatalkes->pesanobatalkes_id;

        if($modDetailPesanOA->validate()) { 
            $modDetailPesanOA->save();
        } else {
            $this->pesanobatalkestersimpan &= false;
        }
        return $modDetailPesanOA;
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

    public function actionSetFormDetailPemesanan()
    {
        if(Yii::app()->request->isAjaxRequest) { 
            $obatalkes_id = $_POST['obatalkes_id'];
            $jumlah = $_POST['jumlah'];
            $form = "";
            $pesan = "";
            $format = new MyFormatter();
            $modObatAlkes = ObatalkesM::model()->findByPk($obatalkes_id);
            $ruangan_id = Yii::app()->user->getState('ruangan_id');
			if($modObatAlkes){
				$modDetailPesanOA = new GFPesanoadetailT;
				$modDetailPesanOA->obatalkes_id = $modObatAlkes->obatalkes_id;
				$modDetailPesanOA->jmlpesan = $jumlah;
				$modDetailPesanOA->satuankecil_id = $modObatAlkes->satuankecil_id;
				$modDetailPesanOA->sumberdana_id = $modObatAlkes->sumberdana_id;
				$form = $this->renderPartial($this->path_view.'_rowDetailPemesanan', array('modDetail'=>$modDetailPesanOA), true);
			}else{
				$pesan = "Obat alkes tidak ada!";
			}
            echo CJSON::encode(array('form'=>$form, 'pesan'=>$pesan));
            Yii::app()->end(); 
        }
    }

     /**
     * untuk print data pemesanan obat alkes
     */
    public function actionPrint($pesanobatalkes_id,$caraprint = null) 
    {
        $this->layout='//layouts/printWindows';
        if (isset($_GET['frame'])){
            $this->layout='//layouts/iframe';
        }else if($caraprint=='EXCEL') {
            $this->layout='//layouts/printExcel';
        }
        $format = new MyFormatter;    
        $model = GFPesanobatalkesT::model()->findByPk($pesanobatalkes_id);     
        $modDetails = GFPesanoadetailT::model()->findAllByAttributes(array('pesanobatalkes_id'=>$pesanobatalkes_id));

        $judul_print = 'Pemesanan Obat Alkes';
        
        $this->render($this->path_view.'Print', array(
                'format'=>$format,
                'judul_print'=>$judul_print,
                'model'=>$model,
                'modDetails'=>$modDetails,
                'caraprint'=>$caraprint
        ));
    } 

    public function actionAutocompletePegawai()
    {
        if(Yii::app()->request->isAjaxRequest) {
	    $returnVal = array();
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
     * untuk form tambah obat alkes
     * di copy dari laboratorium/pemakaianBmhpController
     */
    public function actionAutocompleteObatAlkes()
    {
        if(Yii::app()->request->isAjaxRequest)
        {
	    $returnVal = array();
            $criteria = new CDbCriteria();
            $criteria->join = "JOIN sumberdana_m ON sumberdana_m.sumberdana_id = t.sumberdana_id 
                            JOIN satuankecil_m ON satuankecil_m.satuankecil_id = t.satuankecil_id
                            LEFT JOIN jenisobatalkes_m ON jenisobatalkes_m.jenisobatalkes_id = t.jenisobatalkes_id
                            ";
            $criteria->compare('LOWER(t.obatalkes_nama)', strtolower($_GET['term']), true);
            $criteria->addCondition('obatalkes_farmasi = TRUE');
            $criteria->addCondition('obatalkes_aktif = true');
            $criteria->order = 'obatalkes_nama';
            $criteria->limit = 5;
            $models = ObatalkesM::model()->findAll($criteria);
            $format = new MyFormatter();
            foreach($models as $i=>$model)
            {
                $attributes = $model->attributeNames();

                foreach($attributes as $j=>$attribute) {
                    $returnVal[$i]["$attribute"] = $model->$attribute;
                }
                $qty_stok = StokobatalkesT::getJumlahStok($model->obatalkes_id, Yii::app()->user->getState('ruangan_id'));
                $returnVal[$i]['label'] = $model->obatalkes_kode." - ".$model->obatalkes_nama." - Harga ".$model->hargajual." - Jumlah Stok ".$qty_stok;
                $returnVal[$i]['value'] = $model->obatalkes_nama;
                $returnVal[$i]['qty_stok'] = $qty_stok;
                $returnVal[$i]['satuankecil_nama'] = $model->satuankecil->satuankecil_nama;
            }
            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }

}
