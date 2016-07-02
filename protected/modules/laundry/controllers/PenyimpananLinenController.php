<?php 
class PenyimpananLinenController extends MyAuthController{

	public $defaultAction = 'index';
    public $path_view = 'laundry.views.penyimpananLinen.';
    public $penyimpananlinentersimpan = true;
    public $penyimpananlinendetailtersimpan = true;

    public function actionIndex($penyimpananlinen_id = null){
    	$format = new MyFormatter();
		$modPenyimpananLinen = new LAPenyimpananlinenT;
		$modPenyimpananLinen->tglpenyimpananlinen = date('Y-m-d H:i:s');
		$modPenyimpananLinen->nopenyimpamanlinen = "-Otomatis-";
		$modPenyimpananLinenDetail = array();
		$modInfoPencucian = new LAPencuciandetailT('searchPencucianLinen');
		$modInfoPencucian->instalasi_id = Yii::app()->user->getState('instalasi_id');
		$modInfoPencucian->tgl_awal = date('Y-m-d');
		$modInfoPencucian->tgl_akhir = date('Y-m-d');
        $instalasiTujuans = CHtml::listData(LAInstalasiM::getInstalasiItems(),'instalasi_id','instalasi_nama');
        $ruanganTujuans = CHtml::listData(LARuanganM::getRuanganByInstalasi($modInfoPencucian->instalasi_id),'ruangan_id','ruangan_nama');
		
    	if(!empty($penyimpananlinen_id)){
            $modPenyimpananLinen= LAPenyimpananlinenT::model()->findByPk($penyimpananlinen_id);
            $modPenyimpananLinen->pegmengetahui_nama = !empty($modPenyimpananLinen->pegmengetahui->NamaLengkap) ? $modPenyimpananLinen->pegmengetahui->NamaLengkap : "";
            $modPenyimpananLinenDetail = LAPenyimpananlinendetT::model()->findAllByAttributes(array('penyimpananlinen_id'=>$modPenyimpananLinen->penyimpananlinen_id));
        }

        if(isset($_POST['LAPenyimpananlinenT'])){
            $transaction = Yii::app()->db->beginTransaction();
            try {

                    $modPenyimpananLinen->attributes=$_POST['LAPenyimpananlinenT'];
                    $modPenyimpananLinen->nopenyimpamanlinen = MyGenerator::noPenyimpananLinen();
                    $modPenyimpananLinen->tglpenyimpananlinen=$format->formatDateTimeForDb($_POST['LAPenyimpananlinenT']['tglpenyimpananlinen']);
					$modPenyimpananLinen->petugas_id = Yii::app()->user->id;
                    $modPenyimpananLinen->create_time = date('Y-m-d H:i:s');
                    $modPenyimpananLinen->update_time = date('Y-m-d H:i:s');
                    $modPenyimpananLinen->create_loginpemakai_id = Yii::app()->user->id;
                    $modPenyimpananLinen->update_loginpemakai_id = Yii::app()->user->id;
                    $modPenyimpananLinen->create_ruangan = Yii::app()->user->ruangan_id;
					
                    if($modPenyimpananLinen->save()){
						$this->penyimpananlinentersimpan = true;
                        if (isset($_POST['LAPenyimpananlinendetT'])) {
                            if(count($_POST['LAPenyimpananlinendetT']) > 0){
                               foreach($_POST['LAPenyimpananlinendetT'] AS $i => $post){
									if($post['checklist'] == 1){
										$modPenyimpananLinenDetail[$i] = $this->simpanPenyimpananLinenDetail($modPenyimpananLinen,$post);
									}
                               }
                            }
                        }else{
                            $this->penyimpananlinendetailtersimpan = false;
                        }
                    }
					
                if($this->penyimpananlinentersimpan && $this->penyimpananlinendetailtersimpan){
                    $transaction->commit();
                    $modPenyimpananLinen->isNewRecord = FALSE;
                    $this->redirect(array('index','penyimpananlinen_id'=>$modPenyimpananLinen->penyimpananlinen_id,'sukses'=>1));
                }else{
                    $transaction->rollback();
                    Yii::app()->user->setFlash('error',"Data Penyimpanan Linen gagal disimpan !");
                }
            } catch (Exception $e) {
                $transaction->rollback();
                Yii::app()->user->setFlash('error',"Data Penyimpanan Linen gagal disimpan ! ".MyExceptionMessage::getMessage($e,true));
            }
        }

		if(isset($_GET['LAPencuciandetailT']))
        {
                $modInfoPencucian->unsetAttributes();
                $modInfoPencucian->attributes	= $_GET['LAPencuciandetailT'];			
                $modInfoPencucian->tgl_awal		= $format->formatDateTimeForDb($_GET['LAPencuciandetailT']['tgl_awal']);			
                $modInfoPencucian->tgl_akhir	= $format->formatDateTimeForDb($_GET['LAPencuciandetailT']['tgl_akhir']);			
                $modInfoPencucian->nopencucianlinen	= $_GET['LAPencuciandetailT']['nopencucianlinen'];			
        }
		
    	$this->render($this->path_view.'index',array(
            'format'=>$format,
			'modPenyimpananLinen'=>$modPenyimpananLinen,
            'modPenyimpananLinenDetail'=>$modPenyimpananLinenDetail,
			'modInfoPencucian'=>$modInfoPencucian,
            'instalasiTujuans'=>$instalasiTujuans,
            'ruanganTujuans'=>$ruanganTujuans,
        ));
    }
	
	/**
     * simpan LAPenyimpananlinendetT
     * @param type $modPenyimpananLinenDetail
     * @param type $detail
     * @return \LAPenyimpananlinendetT
     */
    public function simpanPenyimpananLinenDetail($modPenyimpananLinen ,$detail){
        $format = new MyFormatter();
        $modPenyimpananLinenDetail = new LAPenyimpananlinendetT();
        $modPenyimpananLinenDetail->attributes = $detail;
        $modPenyimpananLinenDetail->penyimpananlinen_id = $modPenyimpananLinen->penyimpananlinen_id;
        $modPenyimpananLinenDetail->ruangan_id = Yii::app()->user->getState('ruangan_id');
		
        if($modPenyimpananLinenDetail->validate()) { 
            $modPenyimpananLinenDetail->save();
			$this->penyimpananlinendetailtersimpan &= true;
        } else {
            $this->penyimpananlinendetailtersimpan &= false;
        }
		
        return $modPenyimpananLinenDetail;
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
	
	/**
     * untuk print data perawatan linen
     */
    public function actionPrint($penyimpananlinen_id,$caraprint = null) 
    {
        $this->layout='//layouts/printWindows';
        if (isset($_GET['frame'])){
            $this->layout='//layouts/iframe';
        }else if($caraprint=='EXCEL') {
            $this->layout='//layouts/printExcel';
        }
        $format = new MyFormatter;    
        $modPenyimpananLinen = LAPenyimpananlinenT::model()->findByPk($penyimpananlinen_id);     
        $modPenyimpananLinenDetail = LAPenyimpananlinendetT::model()->findAllByAttributes(array('penyimpananlinen_id'=>$modPenyimpananLinen->penyimpananlinen_id));
		
        $judul_print = 'Penyimpanan Linen';
        
        $this->render($this->path_view.'Print', array(
                'format'=>$format,
                'judul_print'=>$judul_print,
                'modPenyimpananLinen'=>$modPenyimpananLinen,
                'modPenyimpananLinenDetail'=>$modPenyimpananLinenDetail,
                'caraprint'=>$caraprint
        ));
    } 
}
