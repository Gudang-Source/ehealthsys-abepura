<?php

class ProduksiController extends MyAuthController
{
        public $layout='//layouts/column1';
	public function actionIndex($id = null, $sukses='')
	{
            if ($sukses == 1){
                Yii::app()->user->setFlash("success", "Data Produksi berhasil disimpan.");
            }
            
                $produksi = new ProduksigasmedisT;
                $det_produksi = array();
                $produksi->no_produksi = $this->generateNoProduksi();                
                $nama = LoginpemakaiK::model()->findByPk(Yii::app()->user->id);
                $produksi->petugasgasmedis_id = isset($nama)?$nama->pegawai_id:null;
                if (count($nama) > 0){
                    $produksi->petugasgasmedis_nama = $nama->pegawai->namaLengkap;                    
                }
                if (!empty($id)) {
                    $produksi = ProduksigasmedisT::model()->findByPk($id);
                    $produksi->petugasgasmedis_nama = $produksi->petugas->nama_pegawai;
                    $produksi->mengetahui_nama = $produksi->mengetahui->nama_pegawai;
                    
                    $det_produksi = ProduksigasmedisdetT::model()->findAllByAttributes(array(
                        'produksigasmedis_id'=>$id,
                    ));
                }
                
                if (isset($_POST['ProduksigasmedisT'])) {
                    // var_dump($_POST);
                    
                    $trans = Yii::app()->db->beginTransaction();
                    $ok = true;
                    $produksi->attributes = $_POST['ProduksigasmedisT'];
                    if ($produksi->validate()) {
                        $ok = $ok && $produksi->save();
                        $ok = $ok && $this->simpanDetail($produksi, $_POST['ProduksigasmedisdetT']);
                    } else $ok = false;
                    
                    if ($ok) {
                        $trans->commit();
                        Yii::app()->user->setFlash("success", "Data Produksi berhasil disimpan.");
                        $this->redirect(array('index', 'id'=>$produksi->produksigasmedis_id, 'sukses'=>1));
                    } else {
                        $trans->rollback();
                        Yii::app()->user->setFlash("error", "Data Produksi gagal disimpan.");
                    }
                    
                    //var_dump($ok); die;
                }
                
		$this->render('index', array(
                    'produksi'=>$produksi,
                    'det_produksi'=>$det_produksi,
                    'id'=>$id,
                ));
	}

        protected function simpanDetail($produksi, $postdet) {
            $ok = true;
            foreach ($postdet['waktu_awal'] as $idx=>$item) {
                $mod = new ProduksigasmedisdetT;
                $mod->produksigasmedis_id = $produksi->produksigasmedis_id;
                $mod->obatalkes_id = $postdet['obatalkes_id'][$idx];
                $mod->satuankecil_id = $postdet['satuankecil_id'][$idx];
                $mod->kapasitas = $postdet['kapasitas'][$idx];
                $mod->waktu_awal = $postdet['waktu_awal'][$idx];
                $mod->waktu_selesai = $postdet['waktu_selesai'][$idx];
                $mod->qty_gasmedis = $postdet['qty_gasmedis'][$idx];
                
                if ($mod->validate()) {
                    $ok = $ok && $mod->save();
                    $ok = $ok && $this->simpanStokGasMedis($mod);
                } else $ok = false;
                //var_dump($mod->attributes); die;
            }
            
            return $ok;
        }
        
        public function simpanStokGasMedis($mod) {
            $stok = new StokobatalkesT();
            $stok->attributes = $mod->attributes;
            $stok->ruangan_id = Yii::app()->user->getState('ruangan_id');
            $stok->tglkadaluarsa = date('Y-m-d', time() + (2 * 365.25 * 24 * 3600));
            $stok->tglstok_in = $stok->tglterima = date('Y-m-d H:i:s');
            $stok->produksigasmedisdet_id = $mod->produksigasmedisdet_id;
            $stok->qtystok_in = $mod->qty_gasmedis;
            //var_dump($stok->attributes); 
            //$stok->validate();
            //var_dump($stok->errors); die;
            
            if ($stok->validate()) {
                return $stok->save();
            } return false;
        }
        
	public function actionInformasi()
	{
            $model = new GMProduksigasmedisT;
            $model->unsetAttributes();
            $model->tgl_awal = date('Y-m-d', time() - (7 * 24 * 3600));
            $model->tgl_akhir = date('Y-m-d');
            
            if (isset($_GET['GMProduksigasmedisT'])) {
                $model->attributes = $_GET['GMProduksigasmedisT'];
               // $model->petugas_nama = $_GET['GMProduksigasmedisT']['petugas_nama'];
               // $model->mengetahui_nama = $_GET['GMProduksigasmedisT']['mengetahui_nama'];
                $model->tgl_awal = MyFormatter::formatDateTimeForDb($_GET['GMProduksigasmedisT']['tgl_awal']);
                $model->tgl_akhir = MyFormatter::formatDateTimeForDb($_GET['GMProduksigasmedisT']['tgl_akhir']);
            }
            $this->render('informasi', array('model'=>$model));
	}
        
        public function actionDetail($id, $print = null) {
            switch ($print) {
                case 1: $this->layout = '//layouts/printWindows'; break;
                case 2: $this->layout = '//layouts/printExcel'; break;
                default: $this->layout = '//layouts/iframe';
            }
            
            
            $model = GMProduksigasmedisT::model()->findByPk($id);
            $det = ProduksigasmedisdetT::model()->findAllByAttributes(array(
                'produksigasmedis_id'=>$id
            ));
            
            $this->render('detail', array(
                'model'=>$model,
                'det'=>$det,
                'print'=>$print,
            ));
        }
        
        public function actionAutocompletePegawai()
        {
            if(Yii::app()->request->isAjaxRequest) {
                $criteria = new CDbCriteria();
                $criteria->compare('LOWER(nama_pegawai)', strtolower($_GET['term']), true);
                $criteria->order = 'nama_pegawai';
                $criteria->limit = 5;
                $criteria->compare('ruangan_id', Yii::app()->user->getState('ruangan_id'));
                $models = PegawairuanganV::model()->findAll($criteria);
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
        
        public function actionAutocompleteOA()
        {
            if(Yii::app()->request->isAjaxRequest) {
                $criteria = new CDbCriteria();
                $criteria->compare('LOWER(obatalkes_nama)', strtolower($_GET['term']), true);
                $criteria->order = 'obatalkes_nama';
                $criteria->compare('jenisobatalkes_id', Params::JENISOBATALKES_ID_GASMEDIS);
                $criteria->limit = 5;
                $models = ObatalkesM::model()->findAll($criteria);
                foreach($models as $i=>$model)
                {
                    $attributes = $model->attributeNames();
                    foreach($attributes as $j=>$attribute) {
                        $returnVal[$i]["$attribute"] = $model->$attribute;
                    }
                    $returnVal[$i]['label'] = $model->obatalkes_nama;
                    $returnVal[$i]['value'] = $model->obatalkes_id;
                }

                echo CJSON::encode($returnVal);
            }
            Yii::app()->end();
        }
        
        public function actionLoadDetGasMedis() {
            if(Yii::app()->request->isAjaxRequest) {
                $id = $_POST['id'];
                $jumlah = $_POST['jumlah'];
                $oa = ObatalkesM::model()->findByPk($id);
                
                $row = new ProduksigasmedisdetT;
                $row->obatalkes_id = $oa->obatalkes_id;
                $row->satuankecil_id = $oa->satuankecil_id;
                $row->kapasitas = $oa->kekuatan;
                $row->qty_gasmedis = $jumlah;
                $row->waktu_awal = $row->waktu_selesai = "00:00:00";
                
                echo $this->renderPartial('subIndex/_rowGasMedis', array('oa'=>$oa, 'row'=>$row), true);
            }
            Yii::app()->end();
        }
        
        public function generateNoProduksi() {
            	$default = '001';
                $tgl = date('Ymd');
                $prefix = 'GM'.$tgl;
                $sql = "SELECT CAST(MAX(SUBSTR(no_produksi,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
                                        FROM produksigasmedis_t
                                        WHERE no_produksi LIKE ('".$prefix."%')";
                $noProduksi = Yii::app()->db->createCommand($sql)->queryRow();
                $no_produksi_baru = $prefix.(isset($noProduksi['nomaksimal']) ? (str_pad($noProduksi['nomaksimal']+1, strlen($default), 0,STR_PAD_LEFT)) : $default);
		return $no_produksi_baru;
        }
        

	// Uncomment the following methods and override them if needed
	/*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
}