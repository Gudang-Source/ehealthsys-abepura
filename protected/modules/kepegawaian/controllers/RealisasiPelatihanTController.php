<?php

class RealisasiPelatihanTController extends MyAuthController{
	public $layout='//layouts/column1';
	public $realisasiBaru = false;
	
	public function actionIndex(){
		$format = new MyFormatter;
		$model = new KPRencanadiklatT;
		$modPegawaiDiklat = new KPPegawaidiklatT;
		
		if(isset($_POST['KPPegawaidiklatT'])){
			$transaction = Yii::app()->db->beginTransaction();
			try {
				foreach($_POST['KPPegawaidiklatT'] as $i => $pegawaidiklat){
					if($_POST['KPRencanadiklatT'][$i]['ceklis']){
						$modPegawaiDiklat = new KPPegawaidiklatT;
						$modPegawaiDiklat->attributes = $pegawaidiklat;
						$modPegawaiDiklat->jenisdiklat_id = $_POST['KPRencanadiklatT'][$i]['jenisdiklat_id'];
						$modPegawaiDiklat->pegawai_id = $_POST['KPRencanadiklatT'][$i]['pegawai_id'];
						$modPegawaiDiklat->pegawaidiklat_nama = $_POST['KPRencanadiklatT'][$i]['nama_pegawai'];
						$modPegawaiDiklat->pegawaidiklat_lamanya = $_POST['KPRencanadiklatT'][$i]['lamadiklat'];
						$modPegawaiDiklat->pegawaidiklat_tahun = $format->formatDateTimeForUser($_POST['KPRencanadiklatT'][$i]['rencanadiklat_periode']);
						$modPegawaiDiklat->pegawaidiklat_tempat = $_POST['KPRencanadiklatT'][$i]['tempat_diklat'];
						$modPegawaiDiklat->rencanadiklat_id = $_POST['KPRencanadiklatT'][$i]['rencanadiklat_id'];
						$modPegawaiDiklat->create_time = date("Y-m-d H:i:s");
						$modPegawaiDiklat->create_loginpemakai_id = Yii::app()->user->id;
						$modPegawaiDiklat->create_ruangan = Yii::app()->user->ruangan_id;
						$modPegawaiDiklat->tglditetapkandiklat = !empty($pegawaidiklat['tglditetapkandiklat'])?MyFormatter::formatDateTimeForDb($pegawaidiklat['tglditetapkandiklat']):null;
						$modPegawaiDiklat->pegawaidiklat_tahun = !empty($pegawaidiklat['pegawaidiklat_tahun'])?MyFormatter::formatDateTimeForDb($pegawaidiklat['pegawaidiklat_tahun']):null;
						if ($modPegawaiDiklat->save()){
							$this->realisasiBaru = true;
						}else{
							$this->realisasiBaru = false;
						}
					}
				}
						if($this->realisasiBaru){
							$transaction->commit();
							$this->redirect(array('index','norencanadiklat'=>$_POST['KPRencanadiklatT']['norencanadiklat'],'sukses'=>1));
						}else{
							$transaction->rollback();
							Yii::app()->user->setFlash('error',"Update Data Realisasi Pelatihan gagal disimpan !");
						}
			} catch (Exception $ex) {
				$transaction->rollback();
                Yii::app()->user->setFlash('error',"Data Realisasi Pelatihan gagal disimpan ! ".MyExceptionMessage::getMessage($ex,true));
			}
			
		}
		$this->render('index',array('model'=>$model,'format'=>$format,'modPegawaiDiklat'=>$modPegawaiDiklat));
	}
	
    public function actionAutocompleteNoRencanaDiklat()
    {
        if(Yii::app()->request->isAjaxRequest) {
            if (!isset($_GET['term'])){
                $_GET['term'] = null;
            }
			$returnVal = array();
            $criteria = new CDbCriteria();
            $criteria->compare('LOWER(norencanadiklat)', strtolower($_GET['term']), true);
			$criteria->select ='norencanadiklat';
			$criteria->group = 'norencanadiklat';
            $criteria->order = 'norencanadiklat';
            $criteria->limit = 5;
            $models = KPRencanadiklatT::model()->findAll($criteria);
            foreach($models as $i=>$model)
            {
                $attributes = $model->attributeNames();
                foreach($attributes as $j=>$attribute) {
                    $returnVal[$i]["$attribute"] = $model->$attribute;
                }
                $returnVal[$i]['label'] = $model->norencanadiklat;
                $returnVal[$i]['value'] = $model->norencanadiklat;
            }

            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }
	
    public function actionLoadFormRencanaPelatihan()
    {
        if(Yii::app()->request->isAjaxRequest) { 
			$date = date("d");
            $norencanadiklat = $_POST['norencanadiklat'];
			
            $format = new MyFormatter();
			$criteria=new CDbCriteria;
			$criteria->join = "JOIN pegawai_m ON pegawai_m.pegawai_id = t.pegawai_id 
							   LEFT JOIN pegawaidiklat_t ON pegawaidiklat_t.rencanadiklat_id = t.rencanadiklat_id";
			if(!empty($this->rencanadiklat_id)){
				$criteria->addCondition('t.rencanadiklat_id = '.$this->rencanadiklat_id);
			}
			$criteria->compare('LOWER(norencanadiklat)',strtolower($norencanadiklat),true);
			$criteria->addCondition('pegawaidiklat_t.rencanadiklat_id IS NULL');
            $modRencanaDiklat = KPRencanadiklatT::model()->findAll($criteria);
			$modPegawaiDiklat = new KPPegawaidiklatT;
            echo CJSON::encode(array(
                'form'=>$this->renderPartial('_rowRealisasiPelatihan', array(
                        'format'=>$format,
                        'modRencanaDiklat'=>$modRencanaDiklat,
                        'modPegawaiDiklat'=>$modPegawaiDiklat,
                    ), 
                true))
            );
            exit;  
        }
    }
	
    public function actionPrint($norencanadiklat)
    {
		$details = array();
        $modPrograms = array();
		$format = new MyFormatter();
		$criteria=new CDbCriteria;
		$criteria->join = "JOIN pegawai_m ON pegawai_m.pegawai_id = t.pegawai_id 
						   LEFT JOIN pegawaidiklat_t ON pegawaidiklat_t.rencanadiklat_id = t.rencanadiklat_id";
		if(!empty($this->rencanadiklat_id)){
			$criteria->addCondition('t.rencanadiklat_id = '.$this->rencanadiklat_id);
		}
		$criteria->compare('LOWER(norencanadiklat)',strtolower($norencanadiklat),true);
		$criteria->addCondition('pegawaidiklat_t.rencanadiklat_id IS NOT NULL');
		$model = KPRencanadiklatT::model()->findAll($criteria);
		foreach ($model as $i => $modDetail){
			$details[$i] = KPPegawaidiklatT::model()->findByAttributes(array('rencanadiklat_id'=>$modDetail->rencanadiklat_id));
		}
        $judulLaporan = 'Realisasi Pelatihan Pegawai';
		$deskripsi = $norencanadiklat;
        $caraPrint = (isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null);
		if($caraPrint=='PRINT') {
			$this->layout='//layouts/printWindows';
			$this->render('Print',array('format'=>$format,'details'=>$details,'deskripsi'=>$deskripsi,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint));
		}
    }
}