<?php

class PengirimanPeralatanSterilTController extends MyAuthController {
	public $layout='//layouts/column1';
	public $pengirimanSteril = false;
	public $pengirimanSterilDet = true;
	
	public function actionIndex(){
		$format = new MyFormatter;
		$model = new STKirimperlinensterilT; 
		$model->kirimperlinensteril_no = MyGenerator::noKirimSterilisasi();

		// data untuk pencarian
		$modCari = new STPenyimpanansterilT;
		$modCari->tgl_awal = $format->formatDateTimeForUser(date("Y m d"), strtotime($modCari->tgl_awal));
		$modCari->tgl_akhir = $format->formatDateTimeForUser(date("Y m d"), strtotime($modCari->tgl_akhir));
		$modCariDetail = new STPenyimpanansterildetT;
		$modPenyimpananDetails = array();
		if (isset($_POST['STPenyimpanansterilT'])){
			$tgl_awal = $format->formatDateTimeForDb($_POST['STPenyimpanansterilT']['tgl_awal']);
			$tgl_akhir = $format->formatDateTimeForDb($_POST['STPenyimpanansterilT']['tgl_akhir']);
			$penyimpanansteril_no = $_POST['STPenyimpanansterilT']['penyimpanansteril_no'];
			$rakpenyimpanan_id = $_POST['STPenyimpanansterilT']['rakpenyimpanan_id'];
			$lokasipenyimpanan_id = $_POST['STPenyimpanansterilT']['lokasipenyimpanan_id']; 
			$criteria = new CDbCriteria();
			$criteria->addBetweenCondition('DATE(penyimpanansteril_tgl)', $tgl_awal, $tgl_akhir);
			$criteria->compare('LOWER(penyimpanansteril_no)',strtolower($penyimpanansteril_no),true);
			$modPenyimpanan = STPenyimpanansterilT::model()->findAll($criteria);
			foreach ($modPenyimpanan as $i => $modPenyimpananDetail){
				$criteriaDet = new CDbCriteria();
				if (!empty($modPenyimpananDetail->penyimpanansteril_id)){
					$criteriaDet->addCondition('penyimpanansteril_id = '.$modPenyimpananDetail->penyimpanansteril_id);
				}
				if (!empty($rakpenyimpanan_id)){
					$criteriaDet->addCondition('rakpenyimpanan_id = '.$rakpenyimpanan_id);
				}
				if (!empty($lokasipenyimpanan_id)){
					$criteriaDet->addCondition('lokasipenyimpanan_id = '.$lokasipenyimpanan_id);
				}
				$modPenyimpananDetails = STPenyimpanansterildetT::model()->findAll($criteriaDet);
			}
		}
		
		// data untuk proses simpan
		$modDetails = array();
		$modDetail = new STKirimperlinensterildetT;
		if (isset($_POST['STPenyimpanansterildetT'])){
            $transaction = Yii::app()->db->beginTransaction();
            try {
				$model->attributes = $_POST['STKirimperlinensterilT'];
				$model->ruangan_id = Yii::app()->user->ruangan_id;
//				$model->pengajuansterlilisasi_id = $_POST['STPenyimpanansterildetT'][0]['penyimpanansteril_id'];
				$model->kirimperlinensteril_tgl = $format->formatDateTimeForDb($_POST['STKirimperlinensterilT']['kirimperlinensteril_tgl']);
				$model->create_time = date("Y-m-d H:i:s");
				$model->create_loginpemakai_id = Yii::app()->user->id;
				$model->create_ruangan = Yii::app()->user->ruangan_id;
					if($model->save()){
						$this->pengirimanSteril = true;
							if(count($_POST['STPenyimpanansterildetT']) > 0){
							   foreach($_POST['STPenyimpanansterildetT'] AS $i => $postPenyimpananSteril){
									if($_POST['STPenyimpanansterildetT'][$i]['checklist']){
										$modDetail = new STKirimperlinensterildetT;
										$modDetail->attributes = $postPenyimpananSteril;
										$modDetail->kirimperlinensteril_id = $model->kirimperlinensteril_id;
//										$modDetail->linen_id = $postPenyimpananSteril['linen_id'];
										$modDetail->barang_id = $postPenyimpananSteril['barang_id'];
										$modDetail->kirimperlinensterildet_jml = $postPenyimpananSteril['penyimpanansterildet_jml'];
										$modDetail->kirimperlinensterildet_ket = $postPenyimpananSteril['penyimpanansterildet_ket'];
										if($modDetail->save()) {
											$this->pengirimanSterilDet &= true;
										} else {
											$this->pengirimanSterilDet &= false;
										}
								   }
							   }
							}
					}
				if($this->pengirimanSteril && $this->pengirimanSterilDet){
					$transaction->commit();
					$this->redirect(array('index','kirimperlinensteril_id'=>$model->kirimperlinensteril_id,'sukses'=>1));
				}else{
					$transaction->rollback();
					Yii::app()->user->setFlash('error',"Data Pengiriman Peralatan Steril gagal disimpan !");
				}
            } catch (Exception $e) {
                $transaction->rollback();
                Yii::app()->user->setFlash('error',"Data Pengiriman Peralatan Steril gagal disimpan ! ".MyExceptionMessage::getMessage($e,true));
            }
				
		}
		
		$this->render('index',array(
			'model'=>$model, 'format'=>$format, 'modCari'=>$modCari, 'modPenyimpananDetails'=>$modPenyimpananDetails
		));
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
	
	public function actionAutocompletePegawaiMengirim()
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
	
	public function actionAutocompleteRakPenyimpanan()
    {
        if(Yii::app()->request->isAjaxRequest) {
			$returnVal = array();
            $criteria = new CDbCriteria();
            $criteria->compare('LOWER(rakpenyimpanan_nama)', strtolower($_GET['term']), true);
            $criteria->order = 'rakpenyimpanan_nama';
            $criteria->limit = 5;
            $models = STRakpenyimpananM::model()->findAll($criteria);
            foreach($models as $i=>$model)
            {
                $attributes = $model->attributeNames();
                foreach($attributes as $j=>$attribute) {
                    $returnVal[$i]["$attribute"] = $model->$attribute;
                }
                $returnVal[$i]['label'] = $model->rakpenyimpanan_nama;
                $returnVal[$i]['value'] = $model->rakpenyimpanan_id;
            }

            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }
	
	public function actionAutocompleteLokasiPenyimpanan()
    {
        if(Yii::app()->request->isAjaxRequest) {
			$returnVal = array();
            $criteria = new CDbCriteria();
            $criteria->compare('LOWER(lokasipenyimpanan_nama)', strtolower($_GET['term']), true);
            $criteria->order = 'lokasipenyimpanan_nama';
            $criteria->limit = 5;
            $models = STLokasipenyimpananM::model()->findAll($criteria);
            foreach($models as $i=>$model)
            {
                $attributes = $model->attributeNames();
                foreach($attributes as $j=>$attribute) {
                    $returnVal[$i]["$attribute"] = $model->$attribute;
                }
                $returnVal[$i]['label'] = $model->lokasipenyimpanan_nama;
                $returnVal[$i]['value'] = $model->lokasipenyimpanan_id;
            }

            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }
	
	/**
     * untuk print data pengajuan perawatan
     */
    public function actionPrint($kirimperlinensteril_id,$caraPrint = null) 
    {
        $format = new MyFormatter;    
        $modPengiriman = STKirimperlinensterilT::model()->findByPk($kirimperlinensteril_id);     
        $modPengirimanDetail = STKirimperlinensterildetT::model()->findAllByAttributes(array('kirimperlinensteril_id'=>$kirimperlinensteril_id));
 
        $judul_print = 'Pengiriman Peralatan Steril';
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
        
        $this->render('Print', array(
			'format'=>$format,
			'judul_print'=>$judul_print,
			'modPengiriman'=>$modPengiriman,
			'modPengirimanDetail'=>$modPengirimanDetail,
			'caraPrint'=>$caraPrint
        ));
    }
}