<?php 
class PengirimanLinenController extends MyAuthController{

	public $defaultAction = 'index';
    public $path_view = 'laundry.views.pengirimanLinen.';
    public $pengirimanlinentersimpan = true;

    public function actionIndex($pengirimanlinen_id = null){
    	$format = new MyFormatter();
		$modPengirimanLinen = new LAPengirimanlinenT;		
		$modPengirimanLinen->tglpengirimanlinen = date('Y-m-d H:i:s');
    	$modPengirimanLinen->nopengirimanlinen = '-Otomatis-';
		$modPengirimanLinenDetail = array();		    	
        $ruanganTujuans = CHtml::listData(LARuanganM::getRuangan(),'ruangan_id','ruangan_nama');
		
    	if(!empty($pengirimanlinen_id)){
            $modPengirimanLinen= LAPengirimanlinenT::model()->findByPk($pengirimanlinen_id);
            $modPengirimanLinen->pegpengirim_nama = !empty($modPengirimanLinen->pegpengirim->NamaLengkap) ? $modPengirimanLinen->pegpengirim->NamaLengkap : "";
            $modPengirimanLinen->mengetahui_nama = !empty($modPengirimanLinen->pegmengetahui->NamaLengkap) ? $modPengirimanLinen->pegmengetahui->NamaLengkap : "";
            $modPengirimanLinenDetail = LAPengirimanlinendetailT::model()->findAllByAttributes(array('pengirimanlinen_id'=>$modPengirimanLinen->pengirimanlinen_id));
        }

        if(isset($_POST['LAPengirimanlinenT'])){
            $transaction = Yii::app()->db->beginTransaction();
            try {

				$modPengirimanLinen->attributes=$_POST['LAPengirimanlinenT'];
				$modPengirimanLinen->nopengirimanlinen = MyGenerator::noPengirimanLinen();
				$modPengirimanLinen->tglpengirimanlinen=$format->formatDateTimeForDb($_POST['LAPengirimanlinenT']['tglpengirimanlinen']);
				$modPengirimanLinen->create_time = date('Y-m-d H:i:s');
				$modPengirimanLinen->create_loginpemakai_id = Yii::app()->user->id;
				$modPengirimanLinen->create_ruangan = Yii::app()->user->ruangan_id;
				$modPengirimanLinen->issudahditerima = true;

				if($modPengirimanLinen->save()){
					if (isset($_POST['LAPengirimanlinendetailT'])) {
						if(count($_POST['LAPengirimanlinendetailT']) > 0){
						   foreach($_POST['LAPengirimanlinendetailT'] AS $i => $detail){
							   $modPengirimanLinenDetail[$i] = $this->simpanPengirimanDetail($modPengirimanLinen,$detail);
						   }
						}
					}else{
						$this->pengirimanlinentersimpan = false;
					}
				}
                if($this->pengirimanlinentersimpan){
                    $transaction->commit();
                    $modPengirimanLinen->isNewRecord = FALSE;
                    $this->redirect(array('index','pengirimanlinen_id'=>$modPengirimanLinen->pengirimanlinen_id,'sukses'=>1));
                }else{
                    $transaction->rollback();
                    Yii::app()->user->setFlash('error',"Data Pengiriman Linen gagal disimpan !");
                }
            } catch (Exception $e) {
                $transaction->rollback();
                Yii::app()->user->setFlash('error',"Data Pengiriman Linen gagal disimpan ! ".MyExceptionMessage::getMessage($e,true));
            }
        }

    	$this->render($this->path_view.'index',array(
            'format'=>$format,
			'modPengirimanLinen'=>$modPengirimanLinen,
            'modPengirimanLinenDetail'=>$modPengirimanLinenDetail,
            'ruanganTujuans'=>$ruanganTujuans,
        ));
    }
	
	/**
     * simpan LAPengirimanlinendetailT
     * @param type $modPengirimanLinenDetail
     * @param type $detail
     * @return \LAPengirimanlinendetailT
     */
    public function simpanPengirimanDetail($modPengirimanLinen ,$detail){
        $format = new MyFormatter();
        $modPengirimanLinenDetail = new LAPengirimanlinendetailT;
        $modPengirimanLinenDetail->attributes = $detail;
        $modPengirimanLinenDetail->pengirimanlinen_id = $modPengirimanLinen->pengirimanlinen_id;

        if($modPengirimanLinenDetail->validate()) { 
            $modPengirimanLinenDetail->save();
        } else {
            $this->perawatanlinentersimpan &= false;
        }
        return $modPengirimanLinenDetail;
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
            $models = CHtml::listData(LARuanganM::getRuanganByInstalasi($instalasi_id),'ruangan_id','ruangan_nama');

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
            $models = LAPegawaiV::model()->findAll($criteria);
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
	
	public function actionAutocompleteLinen()
    {
        if(Yii::app()->request->isAjaxRequest) {
			$returnVal = array();
			$namalinen = isset($_GET['namalinen']) ? $_GET['namalinen'] : null;
			$kodelinen = isset($_GET['kodelinen']) ? $_GET['kodelinen'] : null;
            $criteria = new CDbCriteria();
			
            $criteria->compare('LOWER(namalinen)', strtolower($namalinen), true);
            $criteria->compare('LOWER(kodelinen)', strtolower($kodelinen), true);
            $criteria->order = 'kodelinen,namalinen';
            $criteria->limit = 5;
            $models = LALinenM::model()->findAll($criteria);
            foreach($models as $i=>$model)
            {
                $attributes = $model->attributeNames();
                foreach($attributes as $j=>$attribute) {
                    $returnVal[$i]["$attribute"] = $model->$attribute;
                }
                $returnVal[$i]['label'] = $model->kodelinen."-".$model->namalinen;
                $returnVal[$i]['value'] = $model->linen_id;
            }

            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }
	
	public function actionSetFormDetailLinen()
    {
        if(Yii::app()->request->isAjaxRequest) { 
            $linen_id = isset($_POST['linen_id']) ? $_POST['linen_id'] : null;
            $keterangan = isset($_POST['keterangan']) ? $_POST['keterangan'] : null;
            $form = "";
            $pesan = "";
            $format = new MyFormatter();
            $modLinen = LALinenM::model()->findByPk($linen_id);
            $ruangan_id = Yii::app()->user->getState('ruangan_id');
			$modPengirimanLinenDetail = array();
			if($modLinen){
				$modPengirimanLinenDetail = new LAPengirimanlinendetailT;
				$modPengirimanLinenDetail->linen_id = $modLinen->linen_id;
				$modPengirimanLinenDetail->keterangan_linen = $keterangan;
				$modPengirimanLinenDetail->namalinen = $modLinen->namalinen;
				$modPengirimanLinenDetail->kodelinen = $modLinen->kodelinen;
				$form = $this->renderPartial($this->path_view.'_rowPengirimanLinen', array('modDetail'=>$modPengirimanLinenDetail), true);
			}else{
				$pesan = "data linen tidak ada!";
			}
            echo CJSON::encode(array('form'=>$form, 'pesan'=>$pesan));
            Yii::app()->end(); 
        }
    }
	
	/**
     * untuk print data perawatan linen
     */
    public function actionPrint($pengirimanlinen_id,$caraprint = null) 
    {
        $this->layout='//layouts/printWindows';
        if (isset($_GET['frame'])){
            $this->layout='//layouts/iframe';
        }else if($caraprint=='EXCEL') {
            $this->layout='//layouts/printExcel';
        }
        $format = new MyFormatter;    
        $modPengirimanLinen = LAPengirimanlinenT::model()->findByPk($pengirimanlinen_id);     
        $modPengirimanLinenDetail = LAPengirimanlinendetailT::model()->findAllByAttributes(array('pengirimanlinen_id'=>$pengirimanlinen_id));

        $judul_print = 'Pengiriman Linen';
        
        $this->render($this->path_view.'Print', array(
                'format'=>$format,
                'judul_print'=>$judul_print,
                'modPengirimanLinen'=>$modPengirimanLinen,
                'modPengirimanLinenDetail'=>$modPengirimanLinenDetail,
                'caraprint'=>$caraprint
        ));
    } 
}
