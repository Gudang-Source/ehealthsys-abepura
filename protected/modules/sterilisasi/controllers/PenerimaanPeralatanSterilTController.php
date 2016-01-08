<?php

class PenerimaanPeralatanSterilTController extends MyAuthController {
	public $layout='//layouts/column1';
	public $path_view = 'sterilisasi.views.penerimaanPeralatanSteril.';
	public $penerimaanSteril = false;
	public $pengajuanSterilUpdate = false;
	public $penerimaanSterilDet = true;
	
	public function actionIndex(){
		if(isset($_GET['frame'])){
			$this->layout = '//layouts/iframe';
		}
		$format = new MyFormatter;
		$model = new STPenerimaansterilisasiT; 
		$model->penerimaansterilisasi_no = MyGenerator::noPenerimaanSteril();
		
		// data untuk pencarian
		$modCari = new STPengajuansterlilisasiT;
		$modCari->tgl_awal = $format->formatDateTimeForUser(date("Y m d"), strtotime($modCari->tgl_awal));
		$modCari->tgl_akhir = $format->formatDateTimeForUser(date("Y m d"), strtotime($modCari->tgl_akhir));
		$modCariDetail = new STPengajuansterlilisasidetT;
		$modPengDetails = array();
		
		// data dari pengajuan sterilisasi
		if(!empty($_GET['pengajuansterlilisasi_id'])){
			$modCari = STPengajuansterlilisasiT::model()->findByPk($_GET['pengajuansterlilisasi_id']);
			$modPengDetails = STPengajuansterlilisasidetT::model()->findAllByAttributes(array('pengajuansterlilisasi_id'=>$_GET['pengajuansterlilisasi_id']));
		}
		if (isset($_POST['STPengajuansterlilisasiT'])){
			$tgl_awal = $format->formatDateTimeForDb($_POST['STPengajuansterlilisasiT']['tgl_awal']);
			$tgl_akhir = $format->formatDateTimeForDb($_POST['STPengajuansterlilisasiT']['tgl_akhir']);
			$pengajuansterlilisasi_no = $_POST['STPengajuansterlilisasiT']['pengajuansterlilisasi_no'];
			$ruangan_id = $_POST['STPengajuansterlilisasiT']['ruangan_id'];
			$criteria = new CDbCriteria();
			$criteria->addBetweenCondition('DATE(pengajuansterlilisasi_tgl)', $tgl_awal, $tgl_akhir);
			if(!empty($ruangan_id)){
				$criteria->addCondition('ruangan_id = '.$ruangan_id);
			}
			$criteria->compare('LOWER(pengajuansterlilisasi_no)',strtolower($pengajuansterlilisasi_no),true);
			$modPengajuan = STPengajuansterlilisasiT::model()->findAll($criteria);
			foreach ($modPengajuan as $i => $modPengajuanDetail){
				$modPengDetails = STPengajuansterlilisasidetT::model()->findAllByAttributes(array('pengajuansterlilisasi_id'=>$modPengajuanDetail->pengajuansterlilisasi_id));
			}
		}
		
		// data untuk proses simpan
		$modDetails = array();
		$modDetail = new STPenerimaansterilisasidetT;
		if (isset($_POST['STPengajuansterlilisasidetT'])){
            $transaction = Yii::app()->db->beginTransaction();
            try {
				$model->attributes = $_POST['STPenerimaansterilisasiT'];
				$model->ruangan_id = Yii::app()->user->ruangan_id;
				$model->pengajuansterlilisasi_id = $_POST['STPengajuansterlilisasidetT'][0]['pengajuansterlilisasi_id'];
				$model->penerimaansterilisasi_tgl = $format->formatDateTimeForDb($_POST['STPenerimaansterilisasiT']['penerimaansterilisasi_tgl']);
				$model->create_time = date("Y-m-d H:i:s");
				$model->create_loginpemakai_id = Yii::app()->user->id;
				$model->create_ruangan = Yii::app()->user->ruangan_id;
						if($model->save()){
							$this->penerimaanSteril = true;
								// update ke tabel pengajuansterlilisasi_t untuk field issudahditerima menjadi true
								$modUpdatePengajuan = STPengajuansterlilisasiT::model()->updateByPk($model->pengajuansterlilisasi_id,array('issudahditerima'=>true));
								if($modUpdatePengajuan){
								$this->pengajuanSterilUpdate = true;
									if(count($_POST['STPengajuansterlilisasidetT']) > 0){
									   foreach($_POST['STPengajuansterlilisasidetT'] AS $i => $postPengajuanSteril){
											if($_POST['STPengajuansterlilisasidetT'][$i]['checklist']){
												$modDetail = new STPenerimaansterilisasidetT;
												$modDetail->attributes = $postPengajuanSteril;
												$modDetail->penerimaansterilisasi_id = $model->penerimaansterilisasi_id;
												$modDetail->linen_id = $postPengajuanSteril['linen_id'];
												$modDetail->barang_id = $postPengajuanSteril['barang_id'];
												$modDetail->penerimaansterilisasidet_jml = $postPengajuanSteril['pengajuansterlilisasidet_jml'];
												$modDetail->penerimaansterilisasidet_ket = $postPengajuanSteril['pengajuansterlilisasidet_ket'];
												if($modDetail->save()) {
													$this->penerimaanSterilDet &= true;
												} else {
													$this->penerimaanSterilDet &= false;
												}
										   }
									   }
									}
								}
						}
					if($this->penerimaanSteril && $this->penerimaanSterilDet){
						$transaction->commit();
						$this->redirect(array('index','penerimaansterilisasi_id'=>$model->penerimaansterilisasi_id,'sukses'=>1));
					}else{
						$transaction->rollback();
						Yii::app()->user->setFlash('error',"Data Penerimaan Peralatan Steril gagal disimpan !");
					}
            } catch (Exception $e) {
                $transaction->rollback();
                Yii::app()->user->setFlash('error',"Data Penerimaan Peralatan Steril gagal disimpan ! ".MyExceptionMessage::getMessage($e,true));
            }
				
		}
		
		
		
		$this->render($this->path_view.'index',array(
			'model'=>$model, 'format'=>$format, 'modCari'=>$modCari, 'modPengDetails'=>$modPengDetails
		));
	}
	
	public function actionAutocompletePegawaiPenerima()
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
	
	public function actionAutocompletePegawaiMengetahui()
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
            $models = CHtml::listData(RuanganM::model()->findAllByAttributes(array("instalasi_id"=>$instalasi_id), "ruangan_aktif = true"),'ruangan_id','ruangan_nama');
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
	
	/**
     * untuk print data pengajuan perawatan
     */
    public function actionPrint($penerimaansterilisasi_id,$caraPrint = null) 
    {
        $format = new MyFormatter;    
        $modPenerimaan = STPenerimaansterilisasiT::model()->findByPk($penerimaansterilisasi_id);     
        $modPenerimaanDetail = STPenerimaansterilisasidetT::model()->findAllByAttributes(array('penerimaansterilisasi_id'=>$penerimaansterilisasi_id));

        $judul_print = 'Penerimaan Peralatan Steril';
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
			'modPenerimaan'=>$modPenerimaan,
			'modPenerimaanDetail'=>$modPenerimaanDetail,
			'caraPrint'=>$caraPrint
        ));
    } 
}
