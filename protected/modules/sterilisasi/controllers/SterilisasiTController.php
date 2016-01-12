<?php 
class SterilisasiTController extends MyAuthController{

	public $defaultAction = 'index';
    public $path_view = 'sterilisasi.views.sterilisasiT.';
    public $sterilisasitersimpan = false;
    public $sterilisasidetailtersimpan = true;
    public $sterilisasibahantersimpan = true;

    public function actionIndex($sterilisasi_id = null){
    	$format = new MyFormatter();
		$modPenerimaanSterilisasi = new STPenerimaansterilisasiT;		
		$modPenerimaanSterilisasiDetail = new STPenerimaansterilisasidetT('searchPenerimaanSteriliasi');
		$modPenerimaanSterilisasiDetail->tgl_awal = date('Y-m-d H:i:s');
		$modPenerimaanSterilisasiDetail->tgl_akhir = date('Y-m-d H:i:s');
		$modPenerimaanSterilisasiDetail->instalasi_id = Yii::app()->user->getState('instalasi_id');
    	$modSterilisasi = new STSterilisasiT;
    	$modSterilisasi->sterilisasi_tgl = date('Y-m-d H:i:s');
    	$modSterilisasi->sterilisasi_no = '-Otomatis-';
    	$modSterilisasiDetail = array();
		$modSterilisasiBahan = array();
        $instalasiTujuans = CHtml::listData(STInstalasiM::getInstalasiItems(),'instalasi_id','instalasi_nama');
        $ruanganTujuans = CHtml::listData(STRuanganM::getRuanganByInstalasi($modPenerimaanSterilisasiDetail->instalasi_id),'ruangan_id','ruangan_nama');

    	if(!empty($sterilisasi_id)){
            $modSterilisasi= STSterilisasiT::model()->findByPk($sterilisasi_id);
            $modSterilisasi->pegsterilisasi_nama = !empty($modSterilisasi->pegsterilisasi->NamaLengkap) ? $modSterilisasi->pegsterilisasi->NamaLengkap : "";
            $modSterilisasi->pegmengetahui_nama = !empty($modSterilisasi->pegmengetahui->NamaLengkap) ? $modSterilisasi->pegmengetahui->NamaLengkap : "";
            $modSterilisasiDetail = STSterilisasidetailT::model()->findAllByAttributes(array('sterilisasi_id'=>$modSterilisasi->sterilisasi_id));
        }

        if(isset($_POST['STSterilisasiT'])){
            $transaction = Yii::app()->db->beginTransaction();
            try {
				$modSterilisasi->attributes=$_POST['STSterilisasiT'];
				$modSterilisasi->sterilisasi_no = MyGenerator::noSterilisasi();
				$modSterilisasi->sterilisasi_tgl=$format->formatDateTimeForDb($_POST['STSterilisasiT']['sterilisasi_tgl']);
				$modSterilisasi->create_time = date('Y-m-d H:i:s');
				$modSterilisasi->create_loginpemakai_id = Yii::app()->user->id;
				$modSterilisasi->create_ruangan = Yii::app()->user->ruangan_id;
				
				if($modSterilisasi->save()){
					$this->sterilisasitersimpan = true;
					if (isset($_POST['STSterilisasidetailT'])) {
						if(count($_POST['STSterilisasidetailT']) > 0){
						   foreach($_POST['STSterilisasidetailT'] AS $i => $detail){
								if($detail['checklist'] == 1){
									$modSterilisasiDetail[$i] = $this->simpanSterilisasiDetail($modSterilisasi,$detail);								
								}
						   }
						}
					}
				}else{
					$this->sterilisasitersimpan = false;
				}
                if($this->sterilisasitersimpan && $this->sterilisasidetailtersimpan && $this->sterilisasibahantersimpan){
                    $transaction->commit();
                    $modSterilisasi->isNewRecord = FALSE;
                    $this->redirect(array('index','sterilisasi_id'=>$modSterilisasi->sterilisasi_id,'sukses'=>1));
                }else{
                    $transaction->rollback();
                    Yii::app()->user->setFlash('error',"Data Sterilisasi gagal disimpan !");
                }
            } catch (Exception $e) {
                $transaction->rollback();
                Yii::app()->user->setFlash('error',"Data Sterilisasi gagal disimpan ! ".MyExceptionMessage::getMessage($e,true));
            }
        }

    	$this->render($this->path_view.'index',array(
            'format'=>$format,
			'modPenerimaanSterilisasi'=>$modPenerimaanSterilisasi,
            'modPenerimaanSterilisasiDetail'=>$modPenerimaanSterilisasiDetail,
            'modSterilisasi'=>$modSterilisasi,
            'modSterilisasiDetail'=>$modSterilisasiDetail,
			'modSterilisasiBahan'=>$modSterilisasiBahan,
            'instalasiTujuans'=>$instalasiTujuans,
            'ruanganTujuans'=>$ruanganTujuans,
        ));
    }
	
	/**
     * simpan STSterilisasidetailT
     * @param type $modSterilisasiDetail
     * @param type $detail
     * @return \STSterilisasidetailT
     */
    public function simpanSterilisasiDetail($modSterilisasi ,$detail){
        $format = new MyFormatter();
        $modSterilisasiDetail = new STSterilisasidetailT;
        $modSterilisasiDetail->attributes = $detail;
        $modSterilisasiDetail->sterilisasi_id = $modSterilisasi->sterilisasi_id;
        $modSterilisasiDetail->waktukadaluarsa = $format->formatDateTimeForDb($detail['waktukadaluarsa']);

        if($modSterilisasiDetail->validate()) { 
            $modSterilisasiDetail->save();
			$modPenerimaanSterilisasi = STPenerimaansterilisasiT::model()->findByPk($detail['penerimaansterilisasi_id']);
			$modPenerimaanSterilisasi->issterilisasi = TRUE;
			$modPenerimaanSterilisasi->update();
			if(isset($detail['bahansterilisasi_nama'])){
				if(count($detail['bahansterilisasi_nama']) > 0){
					foreach($detail['bahansterilisasi_nama'] AS $j => $bahan){
						$modSterilisasiBahan[$j] = $this->simpanSterilisasiBahan($modSterilisasiDetail,$bahan,$detail);
					}
				}
			}
			$this->sterilisasidetailtersimpan &= true;
        } else {
            $this->sterilisasidetailtersimpan &= false;
        }
        return $modSterilisasiDetail;
    }
	
	/**
     * simpan STSterilisasibahanT
     * @param type $modSterilisasiBahan
     * @param type $bahan
     * @return \STSterilisasibahanT
     */
    public function simpanSterilisasiBahan($modSterilisasiDetail ,$bahan, $detail){
        $format = new MyFormatter();
		$criteria = new CDbCriteria();
		$criteria->addCondition("bahansterilisasi_nama ='".$bahan."'");
		$modBahanSterilisasi = STBahansterilisasiM::model()->find($criteria);
		
        $modSterilisasiBahan = new STSterilisasibahanT;
        $modSterilisasiBahan->attributes = $bahan;
        $modSterilisasiBahan->sterilisasidetail_id = $modSterilisasiDetail->sterilisasidetail_id;
        $modSterilisasiBahan->bahansterilisasi_id = $modBahanSterilisasi->bahansterilisasi_id;
        $modSterilisasiBahan->jmlbahanygdigunakan = $detail['sterilisasidetail_jml'];
        $modSterilisasiBahan->satuanbahan = $modBahanSterilisasi->bahansterilisasi_satuan;

        if($modSterilisasiBahan->validate()) {
            $modSterilisasiBahan->save();
			$this->sterilisasibahantersimpan &= true;
        } else {
            $this->sterilisasibahantersimpan &= false;
        }
        return $modSterilisasiBahan;
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
            $models = CHtml::listData(STRuanganM::getRuanganByInstalasi($instalasi_id),'ruangan_id','ruangan_nama');

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
	
	public function actionAutocompletePegawai()
    {
        if(Yii::app()->request->isAjaxRequest) {
	    $returnVal = array();
            $criteria = new CDbCriteria();
            $criteria->compare('LOWER(nama_pegawai)', strtolower($_GET['term']), true);
            $criteria->order = 'nama_pegawai';
            $criteria->limit = 5;
            $models = STPegawaiV::model()->findAll($criteria);
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
	
	public function actionAutocompletePeralatan()
    {
        if(Yii::app()->request->isAjaxRequest) {
	    $returnVal = array();
            $criteria = new CDbCriteria();
            $criteria->compare('LOWER(barang_nama)', strtolower($_GET['term']), true);
            $criteria->order = 'barang_nama';
            $criteria->limit = 5;
            $models = STBarangM::model()->findAll($criteria);
            foreach($models as $i=>$model)
            {
                $attributes = $model->attributeNames();
                foreach($attributes as $j=>$attribute) {
                    $returnVal[$i]["$attribute"] = $model->$attribute;
                }
                $returnVal[$i]['label'] = $model->barang_type."-".$model->barang_kode."-".$model->barang_nama;
                $returnVal[$i]['value'] = $model->barang_id;
            }

            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }
	
	public function actionPencarianPenerimaan()
    {
        if(Yii::app()->request->isAjaxRequest) { 
            parse_str($_REQUEST['data'],$data_parsing);
			$form = "";
            $pesan = "";
            $format = new MyFormatter();
			
			if(isset($data_parsing['STPenerimaansterilisasidetT'])){
				$tgl_awal = $format->formatDateTimeForDb($data_parsing['STPenerimaansterilisasidetT']['tgl_awal']);
				$tgl_akhir = $format->formatDateTimeForDb($data_parsing['STPenerimaansterilisasidetT']['tgl_akhir']);
				$penerimaansterilisasi_no = $data_parsing['STPenerimaansterilisasidetT']['penerimaansterilisasi_no'];
				$barang_id = $data_parsing['STPenerimaansterilisasidetT']['barang_id'];
				$barang_nama = $data_parsing['STPenerimaansterilisasidetT']['barang_nama'];
				$instalasi_id = $data_parsing['STPenerimaansterilisasidetT']['instalasi_id'];
				$ruangan_id = $data_parsing['STPenerimaansterilisasidetT']['ruangan_id'];
			}
            $criteria = new CDbCriteria();
			$criteria->select = 'penerimaansterilisasi_t.*,t.*,barang_m.*,ruangan_m.*,instalasi_m.*';		
			$criteria->addBetweenCondition('DATE(penerimaansterilisasi_t.penerimaansterilisasi_tgl)', $tgl_awal, $tgl_akhir,true);
			if(!empty($penerimaansterilisasi_no)){
				$criteria->compare('LOWER(penerimaansterilisasi_t.penerimaansterilisasi_no',strtolower($penerimaansterilisasi_no),true);
			}
			if(!empty($barang_id)){
				$criteria->addCondition('t.barang_id = '.$barang_id);
			}
			if(!empty($barang_nama)){
				$criteria->compare('LOWER(barang_m.barang_nama)',strtolower($barang_nama),true);
			}
			$criteria->join = 'JOIN penerimaansterilisasi_t ON penerimaansterilisasi_t.penerimaansterilisasi_id = t.penerimaansterilisasi_id'
					. ' JOIN barang_m ON barang_m.barang_id = t.barang_id'
					. ' JOIN ruangan_m ON ruangan_m.ruangan_id=penerimaansterilisasi_t.ruangan_id '
					. ' JOIN instalasi_m ON instalasi_m.instalasi_id=ruangan_m.instalasi_id ';
		
            $modPenerimaanSterilisasi = STPenerimaansterilisasidetT::model()->findAll($criteria);
            $ruangan_id = Yii::app()->user->getState('ruangan_id');
			$modSterilisasidetail = array();
			if(count($modPenerimaanSterilisasi) > 0 ){
				foreach($modPenerimaanSterilisasi as $i=>$penerimaan){
					$modSterilisasidetail = new STSterilisasidetailT;
					$modSterilisasidetail->penerimaansterilisasi_id = $penerimaan->penerimaansterilisasi_id;
					$modSterilisasidetail->ruangan_id = $penerimaan->ruangan_id;
					$modSterilisasidetail->ruangan_nama = $penerimaan->ruangan_nama;
					$modSterilisasidetail->barang_id = $penerimaan->barang_id;
					$modSterilisasidetail->barang_nama = $penerimaan->barang_nama;
					$modSterilisasidetail->penerimaansterilisasi_tgl = $penerimaan->penerimaansterilisasi->penerimaansterilisasi_tgl;
					$modSterilisasidetail->penerimaansterilisasi_no = $penerimaan->penerimaansterilisasi->penerimaansterilisasi_no;
					$modSterilisasidetail->sterilisasidetail_jml = $penerimaan->penerimaansterilisasidet_jml;
					$modSterilisasidetail->kemasanygdigunakan = $penerimaan->barang->barang_satuan;
					$modSterilisasidetail->waktukadaluarsa = '';
					$modSterilisasidetail->checklist = 1;
					$form .= $this->renderPartial($this->path_view.'_rowPenerimaanSterilisasi', array('penerimaan'=>$modSterilisasidetail), true);
				}
			}else{
				$pesan = "Data Penerimaan tidak ada!";
			}
            echo CJSON::encode(array('form'=>$form, 'pesan'=>$pesan));
            Yii::app()->end(); 
        }
    }
	
	public function actionMasterBahanSterilisasi() 
    {
        if (Yii::app()->request->isAjaxRequest){
            $criteria = new CDbCriteria;
            $criteria->compare('LOWER(bahansterilisasi_nama)', strtolower($_GET['tag']),true);
            $bahans = STBahansterilisasiM::model()->findAll($criteria);
            $data = array();
            foreach ($bahans as $i => $bahan) {
                $data[$i] = array('key'=>$bahan->bahansterilisasi_nama,
                                  'value'=>$bahan->bahansterilisasi_nama);
            }

            echo CJSON::encode($data);
        }
        Yii::app()->end();
    }
	
	/**
     * untuk print data perawatan linen
     */
    public function actionPrint($sterilisasi_id,$caraprint = null) 
    {
        $this->layout='//layouts/printWindows';
        if (isset($_GET['frame'])){
            $this->layout='//layouts/iframe';
        }else if($caraprint=='EXCEL') {
            $this->layout='//layouts/printExcel';
        }
        $format = new MyFormatter;    
        $modSterilisasi = STSterilisasiT::model()->findByPk($sterilisasi_id);     
        $modSterilisasiDetail = STSterilisasidetailT::model()->findAllByAttributes(array('sterilisasi_id'=>$sterilisasi_id));

        $judul_print = 'Sterilisasi';
        
        $this->render($this->path_view.'Print', array(
			'format'=>$format,
			'judul_print'=>$judul_print,
			'modSterilisasi'=>$modSterilisasi,
			'modSterilisasiDetail'=>$modSterilisasiDetail,
			'caraprint'=>$caraprint
        ));
    } 
}
