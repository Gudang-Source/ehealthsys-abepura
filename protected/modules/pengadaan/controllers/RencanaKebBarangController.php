
<?php

class RencanaKebBarangController extends MyAuthController
{

	public $layout = '//layouts/column1';
	public $defaultAction = 'index';
    public $path_view = 'pengadaan.views.rencanaKebBarang.';
    public $rencanakebutuhantersimpan = true;

	
    public function actionIndex($renkebbarang_id = null){
        $format = new MyFormatter();
        $modRencanaKebBarang = new ADRenkebbarangT;
        $modRencanaKebBarang->renkebbarang_tgl = date('Y-m-d H:i:s');
		$modRencanaKebBarang->renkebbarang_no ='-Otomatis-';
        $modDetails = array();
        if(!empty($rencanakebfarmasi_id)){
            $modRencanaKebBarang= ADRenkebbarangT::model()->findByPk($renkebbarang_id);
            $modRencanaKebBarang->pegmengetahui_id = !empty($modRencanaKebBarang->pegmengetahui_id) ? $modRencanaKebBarang->pegmengetahui_id : "";
            $modRencanaKebBarang->pegmenyetujui_id = !empty($modRencanaKebBarang->pegmenyetujui_id) ? $modRencanaKebBarang->pegmenyetujui_id : "";
            
            $modDetails = ADRenkebbarangdetT::model()->findAllByAttributes(array('renkebbarang_id'=>$modRencanaKebBarang->renkebbarang_id));
        }
        if(isset($_POST['ADRenkebbarangT'])){
            $transaction = Yii::app()->db->beginTransaction();
            try {
                    $modRencanaKebBarang->attributes=$_POST['ADRenkebbarangT'];
					
						$modRencanaKebBarang->renkebbarang_no = MyGenerator::noPerencanaanKebutuhanBarang();
						$modRencanaKebBarang->ruangan_id = Yii::app()->user->getState('ruangan_id');
						$modRencanaKebBarang->pegawai_id = Yii::app()->user->getState('pegawai_id');
						$modRencanaKebBarang->renkebbarang_tgl=$format->formatDateTimeForDb($_POST['ADRenkebbarangT']['renkebbarang_tgl']);
						$modRencanaKebBarang->ro_barang_bulan = $_POST['ADRenkebbarangT']['ro_barang_bulan'];
					
						$modRencanaKebBarang->create_time = date('Y-m-d H:i:s');
						$modRencanaKebBarang->create_loginpemekai_id = Yii::app()->user->id;
						$modRencanaKebBarang->create_ruangan = Yii::app()->user->ruangan_id;

					if($modRencanaKebBarang->save()){
						if(count($_POST['ADRenkebbarangdetT']) > 0){
						   foreach($_POST['ADRenkebbarangdetT'] AS $i => $post){
							   $modDetails[$i] = $this->simpanRencanaKebutuhan($modRencanaKebBarang,$post);
						   }
						}
                    }
                if($this->rencanakebutuhantersimpan){
                    $transaction->commit();
                    $modRencanaKebBarang->isNewRecord = FALSE;
                    $this->redirect(array('index','renkebbarang_id'=>$modRencanaKebBarang->renkebbarang_id,'sukses'=>1));
                }else{
                    $transaction->rollback();
                    Yii::app()->user->setFlash('error',"Data Rencana Kebutuhan gagal disimpan !");
                }
            } catch (Exception $e) {
                $transaction->rollback();
                Yii::app()->user->setFlash('error',"Data Rencana Kebutuhan gagal disimpan ! ".MyExceptionMessage::getMessage($e,true));
            }
        }
        
        $this->render($this->path_view.'index',array(
            'format'=>$format,
            'modRencanaKebBarang'=>$modRencanaKebBarang,
            'modDetails'=>$modDetails,
        ));
    }

    public function simpanRencanaKebutuhan($modRencanaKebBarang ,$post){
        $format = new MyFormatter();
        $modRencanaDetailKebBarang = new ADRenkebbarangdetT;
        $modRencanaDetailKebBarang->attributes = $post;
        $modRencanaDetailKebBarang->barang_id = $post['barang_id'];
		$modRencanaDetailKebBarang->renkebbarang_id = $modRencanaKebBarang->renkebbarang_id; //fake id
        $modRencanaDetailKebBarang->satuanbarangdet =$post['satuanbarangdet'];
		$modRencanaDetailKebBarang->jmlpermintaanbarangdet=$post['jmlpermintaanbarangdet'];;
		$modRencanaDetailKebBarang->harga_barangdet = $post['harga_barang'];
        $modRencanaDetailKebBarang->stokakhir_barangdet = 0; 
        $modRencanaDetailKebBarang->minstok_barangdet = 0; 
        $modRencanaDetailKebBarang->makstok_barangdet = 0; 
        
        
        //$modRencanaDetailKeb->hargatotalrenc = $modRencanaDetailKeb->jmlpermintaan * $modRencanaDetailKeb->harganettorenc;
        
        if($modRencanaDetailKebBarang->validate()) { 
            $modRencanaDetailKebBarang->save();
        } else {
            $this->rencanakebutuhantersimpan &= false;
        }
        return $modRencanaDetailKebBarang;
    }
	
   public function actionLoadFormRencanaKebutuhan()
    {
        if(Yii::app()->request->isAjaxRequest) { 
            $barang_id = $_POST['idBarang'];
            $jumlah = $_POST['jumlah'];
            
            //$format = new MyFormatter();
            $modRencanaKebBarang = new ADRenkebbarangT;
            $modRencanaDetailKebBarang = new ADRenkebbarangdetT;
            $modBarang = ADBarangM::model()->findByPk($barang_id);            
			$modRencanaDetailKebBarang->harga_barang = $modBarang->barang_harganetto;
			$modRencanaDetailKebBarang->barang_id = $modBarang->barang_id;
            $modRencanaDetailKebBarang->minstok_barangdet = 0;
            $modRencanaDetailKebBarang->makstok_barangdet = 0;
            $modRencanaDetailKebBarang->stokakhir_barangdet = 0;
            $modRencanaDetailKebBarang->jmlpermintaanbarangdet = $jumlah;			
            $modRencanaDetailKebBarang->barang_nama = $modBarang->barang_nama;						
            $modRencanaDetailKebBarang->satuanbarangdet = $modBarang->barang_satuan;
			
            echo CJSON::encode(array(
                'status'=>'create_form', 
                'form'=>$this->renderPartial($this->path_view.'_rowBarangRencanaKebutuhan', array(
                        'modRencanaKebBarang'=>$modRencanaKebBarang,
                        'modRencanaDetailKebBarang'=>$modRencanaDetailKebBarang,
                    ), 
                true))
            );
            exit;  
        }
    }

	public function actionAutocompletePegawaiMengetahui()
    {
        if(Yii::app()->request->isAjaxRequest) {
            $criteria = new CDbCriteria();
            $criteria->compare('LOWER(nama_pegawai)', strtolower($_GET['term']), true);
            $criteria->order = 'nama_pegawai';
            $criteria->limit = 5;
            $models = ADPegawaiV::model()->findAll($criteria);
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
    
    public function actionAutocompletePegawaiMenyetujui()
    {
        if(Yii::app()->request->isAjaxRequest) {
            $criteria = new CDbCriteria();
            $criteria->compare('LOWER(nama_pegawai)', strtolower($_GET['term']), true);
            $criteria->order = 'nama_pegawai';
            $criteria->limit = 5;
            $models = ADPegawaiV::model()->findAll($criteria);
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
	 * untuk menampilkan barang dari autocomplete
	 */
	public function actionAutoCompleteBarang()
	{
		if(Yii::app()->request->isAjaxRequest) {
			$criteria = new CDbCriteria();
			$criteria->compare('LOWER(t.barang_nama)', strtolower($_GET['term']), true);
			$criteria->order = 't.barang_id';
			$models = BarangM::model()->findAll($criteria);
			foreach($models as $i=>$model)
			{
				$attributes = $model->attributeNames();
				foreach($attributes as $j=>$attribute) {
					$returnVal[$i]["$attribute"] = $model->$attribute;
				}
				$returnVal[$i]['label'] = $model->barang_nama;
				$returnVal[$i]['value'] = $model->barang_id;
			}

			echo CJSON::encode($returnVal);
		}
		Yii::app()->end();
	}	
	
	/**
	 * Mencetak data rencana kebutuhan barang
	 * @param $renkebbarang
	 */
	public function actionPrint($renkebbarang_id,$caraprint = null) 
    {
        $this->layout='//layouts/printWindows';
        if (isset($_GET['frame'])){
            $this->layout='//layouts/iframe';
        }else if($caraprint=='EXCEL') {
            $this->layout='//layouts/printExcel';
        }
        $format = new MyFormatter;    
        $modRencanaKebBarang = ADRenkebbarangT::model()->findByPk($renkebbarang_id);     
        $criteria = new CDbCriteria();
		$criteria->addCondition('renkebbarang_id = '.$renkebbarang_id);		
		$modRencanaKebBarangDetail = ADRenkebbarangdetT::model()->findAll($criteria);

        $judul_print = 'Rencana Kebutuhan Barang';
        
        $this->render($this->path_view.'Print', array(
			'format'=>$format,
			'judul_print'=>$judul_print,
			'modRencanaKebBarang'=>$modRencanaKebBarang,
			'modRencanaKebBarangDetail'=>$modRencanaKebBarangDetail,
			'caraprint'=>$caraprint
        ));
    }	
	
}
