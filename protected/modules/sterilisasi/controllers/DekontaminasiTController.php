<?php 
class DekontaminasiTController extends MyAuthController{

	public $defaultAction = 'index';
    public $path_view = 'sterilisasi.views.dekontaminasiT.';
    public $dekontaminasitersimpan = false;
    public $dekontaminasidetailtersimpan = true;
    public $dekontaminasibahantersimpan = true;

    public function actionIndex($dekontaminasi_id = null){
    	$format = new MyFormatter();
		$modPenerimaanSterilisasi = new STPenerimaansterilisasiT;		
		$modPenerimaanSterilisasiDetail = new STPenerimaansterilisasidetT('searchPenerimaanSteriliasi');
		$modPenerimaanSterilisasiDetail->tgl_awal = date('Y-m-d H:i:s');
		$modPenerimaanSterilisasiDetail->tgl_akhir = date('Y-m-d H:i:s');
		$modPenerimaanSterilisasiDetail->instalasi_id = Yii::app()->user->getState('instalasi_id');
    	$modDekontaminasi = new STDekontaminasiT;
    	$modDekontaminasi->dekontaminasi_tgl = date('Y-m-d H:i:s');
    	$modDekontaminasi->dekontaminasi_no = '-Otomatis-';
    	$modDekontaminasiDetail = array();
		$modDekontaminasiBahan = array();
        $instalasiTujuans = CHtml::listData(STInstalasiM::getInstalasiItems(),'instalasi_id','instalasi_nama');
        $ruanganTujuans = CHtml::listData(STRuanganM::getRuanganByInstalasi($modPenerimaanSterilisasiDetail->instalasi_id),'ruangan_id','ruangan_nama');

    	if(!empty($dekontaminasi_id)){
            $modDekontaminasi= STDekontaminasiT::model()->findByPk($dekontaminasi_id);
            $modDekontaminasi->pegpetugas_nama = !empty($modDekontaminasi->pegpetugas->NamaLengkap) ? $modDekontaminasi->pegpetugas->NamaLengkap : "";
            $modDekontaminasi->pegmengetahui_nama = !empty($modDekontaminasi->pegmengetahui->NamaLengkap) ? $modDekontaminasi->pegmengetahui->NamaLengkap : "";
            $modDekontaminasiDetail = STDekontaminasidetailT::model()->findAllByAttributes(array('dekontaminasi_id'=>$modDekontaminasi->dekontaminasi_id));
        }

        if(isset($_POST['STDekontaminasiT'])){
            $transaction = Yii::app()->db->beginTransaction();
            try {
				$modDekontaminasi->attributes=$_POST['STDekontaminasiT'];
				$modDekontaminasi->dekontaminasi_no = MyGenerator::noDekontaminasi();
				$modDekontaminasi->dekontaminasi_tgl=$format->formatDateTimeForDb($_POST['STDekontaminasiT']['dekontaminasi_tgl']);
				$modDekontaminasi->create_time = date('Y-m-d H:i:s');
				$modDekontaminasi->create_loginpemakai_id = Yii::app()->user->id;
				$modDekontaminasi->create_ruangan = Yii::app()->user->ruangan_id;
				
				if($modDekontaminasi->save()){
					$this->dekontaminasitersimpan = true;
					if (isset($_POST['STDekontaminasidetailT'])) {
						if(count($_POST['STDekontaminasidetailT']) > 0){
						   foreach($_POST['STDekontaminasidetailT'] AS $i => $detail){
								if($detail['checklist'] == 1){
									$modDekontaminasiDetail[$i] = $this->simpanDekontaminasiDetail($modDekontaminasi,$detail);								
								}
						   }
						}
					}
				}else{
					$this->dekontaminasitersimpan = false;
				}
                if($this->dekontaminasitersimpan && $this->dekontaminasidetailtersimpan && $this->dekontaminasibahantersimpan){
                    $transaction->commit();
                    $modDekontaminasi->isNewRecord = FALSE;
                    $this->redirect(array('index','dekontaminasi_id'=>$modDekontaminasi->dekontaminasi_id,'sukses'=>1));
                }else{
                    $transaction->rollback();
                    Yii::app()->user->setFlash('error',"Data Dekontaminasi gagal disimpan !");
                }
            } catch (Exception $e) {
                $transaction->rollback();
                Yii::app()->user->setFlash('error',"Data Dekontaminasi gagal disimpan ! ".MyExceptionMessage::getMessage($e,true));
            }
        }

    	$this->render($this->path_view.'index',array(
            'format'=>$format,
			'modPenerimaanSterilisasi'=>$modPenerimaanSterilisasi,
            'modPenerimaanSterilisasiDetail'=>$modPenerimaanSterilisasiDetail,
            'modDekontaminasi'=>$modDekontaminasi,
            'modDekontaminasiDetail'=>$modDekontaminasiDetail,
			'modDekontaminasiBahan'=>$modDekontaminasiBahan,
            'instalasiTujuans'=>$instalasiTujuans,
            'ruanganTujuans'=>$ruanganTujuans,
        ));
    }
	
	/**
     * simpan STDekontaminasidetailT
     * @param type $modDekontaminasiDetail
     * @param type $detail
     * @return \STDekontaminasidetailT
     */
    public function simpanDekontaminasiDetail($modDekontaminasi ,$detail){
        $format = new MyFormatter();
        $modDekontaminasiDetail = new STDekontaminasidetailT;
        $modDekontaminasiDetail->attributes = $detail;
        $modDekontaminasiDetail->dekontaminasi_id = $modDekontaminasi->dekontaminasi_id;

        if($modDekontaminasiDetail->validate()) { 
            $modDekontaminasiDetail->save();
			$modPenerimaanSterilisasi = STPenerimaansterilisasiT::model()->findByPk($detail['penerimaansterilisasi_id']);
			$modPenerimaanSterilisasi->isdekontaminasi = TRUE;
			$modPenerimaanSterilisasi->update();
			if(isset($detail['bahansterilisasi_nama'])){
					if(count($detail['bahansterilisasi_nama']) > 0){
					foreach($detail['bahansterilisasi_nama'] AS $j => $bahan){
						$modDekontaminasiBahan[$j] = $this->simpanDekontaminasiBahan($modDekontaminasiDetail,$bahan,$detail);
					}
				}	
			}		
			$this->dekontaminasidetailtersimpan &= true;
        } else {
            $this->dekontaminasidetailtersimpan &= false;
        }
        return $modDekontaminasiDetail;
    }
	
	/**
     * simpan STDekontaminasibahanT
     * @param type $modDekontaminasiBahan
     * @param type $bahan
     * @return \STDekontaminasibahanT
     */
    public function simpanDekontaminasiBahan($modDekontaminasiDetail ,$bahan, $detail){
        $format = new MyFormatter();
		$criteria = new CDbCriteria();
		$criteria->addCondition("bahansterilisasi_nama ='".$bahan."'");
		$modBahanSterilisasi = STBahansterilisasiM::model()->find($criteria);
		
        $modDekontaminasiBahan = new STDekontaminasibahanT;
        $modDekontaminasiBahan->attributes = $bahan;
        $modDekontaminasiBahan->dekontaminasidetail_id = $modDekontaminasiDetail->dekontaminasidetail_id;
        $modDekontaminasiBahan->bahansterilisasi_id = $modBahanSterilisasi->bahansterilisasi_id;
        $modDekontaminasiBahan->jmlpemakaianbahan = $detail['dekontaminasidetail_jml'];
        $modDekontaminasiBahan->satuanpemakainbahan = $modBahanSterilisasi->bahansterilisasi_satuan;

        if($modDekontaminasiBahan->validate()) {
            $modDekontaminasiBahan->save();
			$this->dekontaminasibahantersimpan &= true;
        } else {
            $this->dekontaminasibahantersimpan &= false;
        }
        return $modDekontaminasiBahan;
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
			$modDekontaminasidetail = array();
			if(count($modPenerimaanSterilisasi) > 0 ){
				foreach($modPenerimaanSterilisasi as $i=>$penerimaan){
					$modDekontaminasidetail = new STDekontaminasidetailT;
					$modDekontaminasidetail->penerimaansterilisasi_id = $penerimaan->penerimaansterilisasi_id;
					$modDekontaminasidetail->ruangan_id = $penerimaan->ruangan_id;
					$modDekontaminasidetail->ruangan_nama = $penerimaan->ruangan_nama;
					$modDekontaminasidetail->barang_id = $penerimaan->barang_id;
					$modDekontaminasidetail->barang_nama = $penerimaan->barang_nama;
					$modDekontaminasidetail->penerimaansterilisasi_tgl = $penerimaan->penerimaansterilisasi->penerimaansterilisasi_tgl;
					$modDekontaminasidetail->penerimaansterilisasi_no = $penerimaan->penerimaansterilisasi->penerimaansterilisasi_no;
					$modDekontaminasidetail->dekontaminasidetail_jml = $penerimaan->penerimaansterilisasidet_jml;
					$modDekontaminasidetail->dekontaminasidetail_ket = $penerimaan->penerimaansterilisasidet_ket;
					$modDekontaminasidetail->dekontaminasidetail_lama = '';
					$modDekontaminasidetail->checklist = 1;
					$form .= $this->renderPartial($this->path_view.'_rowDetailDekontaminasi', array('penerimaan'=>$modDekontaminasidetail), true);
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
    public function actionPrint($dekontaminasi_id,$caraprint = null) 
    {
        $this->layout='//layouts/printWindows';
        if (isset($_GET['frame'])){
            $this->layout='//layouts/iframe';
        }else if($caraprint=='EXCEL') {
            $this->layout='//layouts/printExcel';
        }
        $format = new MyFormatter;    
        $modDekontaminasi = STDekontaminasiT::model()->findByPk($dekontaminasi_id);     
        $modDekontaminasiDetail = STDekontaminasidetailT::model()->findAllByAttributes(array('dekontaminasi_id'=>$dekontaminasi_id));

        $judul_print = 'Dekontaminasi';
        
        $this->render($this->path_view.'Print', array(
			'format'=>$format,
			'judul_print'=>$judul_print,
			'modDekontaminasi'=>$modDekontaminasi,
			'modDekontaminasiDetail'=>$modDekontaminasiDetail,
			'caraprint'=>$caraprint
        ));
    } 
}
