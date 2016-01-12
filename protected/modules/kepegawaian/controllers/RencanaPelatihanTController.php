<?php

class RencanaPelatihanTController extends MyAuthController 
{
	public $rencDiklat = false;
	public function actionIndex(){
		$format = new MyFormatter();
		$model = new KPRencanadiklatT;
		$model->norencanadiklat = MyGenerator::noRencanaDiklat();
		$model->tglrencanadiklat = $format->formatDateTimeForUser(date("Y-m-d"));
		if (isset($_POST['KPRencanadiklatT'])){
			$transaction = Yii::app()->db->beginTransaction();
			try {
					$jumlahRow = $_POST['KPRencanadiklatT']['jmlRow'];
					for ($i=0; $i < $jumlahRow; $i++){
						$modRencdiklat =  new KPRencanadiklatT;
						$modRencdiklat->pegawai_id = $_POST['KPRencanadiklatT'][$i]['pegawai_id'];
						$modRencdiklat->jenisdiklat_id = $_POST['KPRencanadiklatT'][$i]['jenisdiklat_id'];
						$modRencdiklat->norencanadiklat = $_POST['KPRencanadiklatT']['norencanadiklat'];
						$modRencdiklat->tglrencanadiklat = $format->formatDateTimeForDb($_POST['KPRencanadiklatT']['tglrencanadiklat']);
						$modRencdiklat->rencanadiklat_periode = $format->formatDateTimeForDb($_POST['KPRencanadiklatT'][$i]['rencanadiklat_periode']);
						$modRencdiklat->rencanadiklat_sampaidgn = $format->formatDateTimeForDb($_POST['KPRencanadiklatT'][$i]['rencanadiklat_sampaidgn']);
						$modRencdiklat->lamadiklat = $_POST['KPRencanadiklatT'][$i]['lamadiklat'];
						$modRencdiklat->satuan_lama = $_POST['KPRencanadiklatT'][$i]['satuan_lama'];
						$modRencdiklat->tempat_diklat = $_POST['KPRencanadiklatT'][$i]['tempat_diklat'];
						$modRencdiklat->alamat_diklat = $_POST['KPRencanadiklatT'][$i]['alamat_diklat'];
						$modRencdiklat->namadiklat = $_POST['KPRencanadiklatT'][$i]['namadiklat'];
						$modRencdiklat->keterangan_diklat = $_POST['KPRencanadiklatT']['keterangan_diklat'];
						$modRencdiklat->pemberitugas_id = $_POST['KPRencanadiklatT']['pemberitugas_id'];
						$modRencdiklat->mengetahui_id = $_POST['KPRencanadiklatT']['mengetahui_id'];
						$modRencdiklat->menyetujui_id = $_POST['KPRencanadiklatT']['menyetujui_id'];
						$modRencdiklat->tglmengetahui = $format->formatDateTimeForDb($_POST['KPRencanadiklatT']['tglmengetahui']);
						$modRencdiklat->tglmenyetujui = $format->formatDateTimeForDb($_POST['KPRencanadiklatT']['tglmenyetujui']);
						$modRencdiklat->create_time = date("Y-m-d H:i:s");
						$modRencdiklat->create_loginpemakai_id = Yii::app()->user->id;
						$modRencdiklat->create_ruangan = Yii::app()->user->ruangan_id;
						$modRencdiklat->save();
						$this->rencDiklat = true;
					}
//					}
//				}
					if($this->rencDiklat){
						$transaction->commit();
						$this->redirect(array('index','rencanadiklat_id'=>$model->rencanadiklat_id,'sukses'=>1));
					}else{
						$transaction->rollback();
						Yii::app()->user->setFlash('error',"Update Data Rencana Pelatihan gagal disimpan !");
					}
			} catch (Exception $ex) {
				$transaction->rollback();
                Yii::app()->user->setFlash('error',"Data Rencana Pelatihan gagal disimpan ! ".MyExceptionMessage::getMessage($e,true));
			}
		}
		
		$this->render('index',array(
			'format'=>$format,
			'model'=>$model
		));
	}
	
    public function actionPrintApproval($approverenanggpen_id)
    {
		$format = new MyFormatter();
		$modPenerimaan = AGRenanggpenerimaanT::model()->findByAttributes(array('approverenanggpen_id'=>$approverenanggpen_id)); 
		$modDetails = AGRenanggaranpenerimaandetT::model()->findAllByAttributes(array('renanggpenerimaan_id'=>$modPenerimaan->renanggpenerimaan_id));
		$judulLaporan = 'Anggaran Penerimaan';
		$deskripsi = $modPenerimaan->konfiganggaran->deskripsiperiode;
        $caraPrint = (isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null);
		if($caraPrint=='PRINT') {
			$this->layout='//layouts/printWindows';
			$this->render('printApproval',array('format'=>$format,'modPenerimaan'=>$modPenerimaan,'modDetails'=>$modDetails,'deskripsi'=>$deskripsi,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint));
		}
    }
	
    public function actionAutocompletePegawai()
    {
        if(Yii::app()->request->isAjaxRequest) {
            if (!isset($_GET['term'])){
                $_GET['term'] = null;
            }
			$returnVal = array();
            $criteria = new CDbCriteria();
			if (isset($_GET['pegawai_id'])){
				if(!empty($_GET['pegawai_id'])){
					$criteria->addCondition("pegawai_id = ".$_GET['pegawai_id']);						
				}
			}
            $criteria->compare('LOWER(nama_pegawai)', strtolower($_GET['term']), true);
            $criteria->order = 'nama_pegawai';
            $criteria->limit = 5;
            $models = KPPegawaiV::model()->findAll($criteria);
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
	
    public function actionAutocompletePemberiTugas()
    {
        if(Yii::app()->request->isAjaxRequest) {
			$returnVal = array();
            $criteria = new CDbCriteria();
            $criteria->compare('LOWER(nama_pegawai)', strtolower($_GET['term']), true);
            $criteria->order = 'nama_pegawai';
            $criteria->limit = 5;
            $models = KPPegawaiV::model()->findAll($criteria);
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
            $models = KPPegawaiV::model()->findAll($criteria);
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
			$returnVal = array();
            $criteria = new CDbCriteria();
			$criteria->group = 'nomorindukpegawai,nama_pegawai,gelardepan,gelarbelakang_nama,alamat_pegawai,pegawai_id';
			$criteria->select = $criteria->group;
            $criteria->compare('LOWER(nama_pegawai)', strtolower($_GET['term']), true);
            $criteria->order = 'nama_pegawai';
            $criteria->limit = 5;
            $models = KPPegawairuanganV::model()->findAll($criteria);
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
}