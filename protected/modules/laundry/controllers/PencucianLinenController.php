<?php 
class PencucianLinenController extends MyAuthController{

	public $defaultAction = 'index';
    public $path_view = 'laundry.views.pencucianLinen.';
    public $pencucianlinendetailtersimpan = true;
    public $pencucianlinentersimpan = true;
	public $pencucianbahantersimpan = true;

    public function actionIndex($pencucianlinen_id = null, $perawatanlinen_id = null, $penerimaanlinen_id = null){
    	$format = new MyFormatter();
		$modPencucianLinen = new LAPencucianlinenT;
		$modPencucianLinen->tglpencucianlinen = date('Y-m-d H:i:s');
		$modPencucianLinen->nopencucianlinen = "-Otomatis-";
		$modPencucianLinenDetail = array();
                $modPencucianLinen->pegpenerima_id = Yii::app()->user->getState('pegawai_id');
                $modPencucianLinen->pegpenerima_nama = Yii::app()->user->getState('nama_pegawai');
    	$modPencucianBahan = array();
		$modInfoPencucian = new LAPenerimaanpencucianlinenV();
		$modInfoPencucian->instalasi_id = Yii::app()->user->getState('instalasi_id');
		$modInfoPencucian->tgl_awal = date('Y-m-d H:i:s');
		$modInfoPencucian->tgl_akhir = date('Y-m-d H:i:s');
        $instalasiTujuans = CHtml::listData(LAInstalasiM::getInstalasiItems(),'instalasi_id','instalasi_nama');
        $ruanganTujuans = CHtml::listData(LARuanganM::getRuanganByInstalasi($modInfoPencucian->instalasi_id),'ruangan_id','ruangan_nama');
		
        if (!empty($perawatanlinen_id)) {
            $modInfoPencucian->tgl_awal = $modInfoPencucian->tgl_akhir = null;
            $modInfoPencucian->instalasi_id = null;
            $modInfoPencucian->perawatanlinen_id = $perawatanlinen_id;
        }
        
        if (!empty($penerimaanlinen_id)) {
            $modInfoPencucian->tgl_awal = $modInfoPencucian->tgl_akhir = null;
            $modInfoPencucian->instalasi_id = null;
            $modInfoPencucian->penerimaanlinen_id = $penerimaanlinen_id;
        }
        
    	if(!empty($pencucianlinen_id)){
            $modPencucianLinen= LAPencucianlinenT::model()->findByPk($pencucianlinen_id);
            $modPencucianLinen->pegmengetahui_nama = !empty($modPencucianLinen->pegpenerima->NamaLengkap) ? $modPencucianLinen->pegpenerima->NamaLengkap : "";
            $modPencucianLinenDetail = LAPencuciandetailT::model()->findAllByAttributes(array('pencucianlinen_id'=>$modPencucianLinen->pencucianlinen_id));
            $modPencucianBahan = LAPencucianbahanT::model()->findAllByAttributes(array('pencucianlinen_id'=>$modPencucianLinen->pencucianlinen_id));
        }

        if(isset($_POST['LAPencucianlinenT'])){
            // var_dump($_POST);
            $transaction = Yii::app()->db->beginTransaction();
            try {

                    $modPencucianLinen->attributes=$_POST['LAPencucianlinenT'];
                    $modPencucianLinen->nopencucianlinen = MyGenerator::noPencucianLinen(Yii::app()->user->getState('instalasi_id'));
                    $modPencucianLinen->tglpencucianlinen=$format->formatDateTimeForDb($_POST['LAPencucianlinenT']['tglpencucianlinen']);
                    $modPencucianLinen->petugas_id = Yii::app()->user->getState('pegawai_id');
                    $modPencucianLinen->create_time = date('Y-m-d H:i:s');
                    $modPencucianLinen->update_time = date('Y-m-d H:i:s');
                    $modPencucianLinen->create_loginpemakai_id = Yii::app()->user->id;
                    $modPencucianLinen->update_loginpemakai_id = Yii::app()->user->id;
                    $modPencucianLinen->create_ruangan = Yii::app()->user->ruangan_id;
                    // var_dump($modPencucianLinen->attributes);
					
                    if($modPencucianLinen->save()){
						$this->pencucianlinentersimpan = true;
                        if (isset($_POST['LAPencuciandetailT'])) {
                            if(count($_POST['LAPencuciandetailT']) > 0){
                                foreach($_POST['LAPencuciandetailT'] AS $i => $post){
                                    foreach ($post as $j=>$post2) {
                                        if (isset($post2['checklist'])) {
                                            $modPencucianLinenDetail[$i] = $this->simpanPencucianLinenDetail($modPencucianLinen,$post2);
                                        }   
                                    }
                                }
                            }
                        }else{
                            $this->pencucianlinendetailtersimpan = false;
                        }
						
                        if (isset($_POST['LAPencucianbahanT'])) {
                            if(count($_POST['LAPencucianbahanT']) > 0){
                               foreach($_POST['LAPencucianbahanT'] AS $i => $bahan){
                                   $modPencucianBahan[$i] = $this->simpanPencucianBahan($modPencucianLinen,$bahan);
                               }
                            }
                        }else{
                            $this->pencucianbahantersimpan = false;
                        }
                    }
                // var_dump($this->pencucianlinentersimpan && $this->pencucianlinendetailtersimpan && $this->pencucianbahantersimpan);
                // die;
                if($this->pencucianlinentersimpan && $this->pencucianlinendetailtersimpan && $this->pencucianbahantersimpan){
                    $transaction->commit();
                    $modPencucianLinen->isNewRecord = FALSE;
                    $this->redirect(array('index','pencucianlinen_id'=>$modPencucianLinen->pencucianlinen_id,'sukses'=>1));
                }else{
                    $transaction->rollback();
                    Yii::app()->user->setFlash('error',"Data Pencucian Linen gagal disimpan !");
                }
            } catch (Exception $e) {
                $transaction->rollback();
                Yii::app()->user->setFlash('error',"Data Pencucian Linen gagal disimpan ! ".MyExceptionMessage::getMessage($e,true));
            }
        }

		if(isset($_GET['LAPenerimaanpencucianlinenV']))
        {
			$modInfoPencucian->unsetAttributes();
			$modInfoPencucian->attributes	= $_GET['LAPenerimaanpencucianlinenV'];			
			$modInfoPencucian->tgl_awal		= $format->formatDateTimeForDb($_GET['LAPenerimaanpencucianlinenV']['tgl_awal']);			
			$modInfoPencucian->tgl_akhir	= $format->formatDateTimeForDb($_GET['LAPenerimaanpencucianlinenV']['tgl_akhir']);			
			$modInfoPencucian->nopenerimaanlinen	= $_GET['LAPenerimaanpencucianlinenV']['nopenerimaanlinen'];			
        }
		
    	$this->render($this->path_view.'index',array(
            'format'=>$format,
			'modPencucianLinen'=>$modPencucianLinen,
            'modPencucianLinenDetail'=>$modPencucianLinenDetail,
            'modPencucianBahan'=>$modPencucianBahan,
			'modInfoPencucian'=>$modInfoPencucian,
            'instalasiTujuans'=>$instalasiTujuans,
            'ruanganTujuans'=>$ruanganTujuans,
            'perawatanlinen_id'=>$perawatanlinen_id,
            'penerimaanlinen_id'=>$penerimaanlinen_id,
        ));
    }
	
	/**
     * simpan LAPencuciandetailT
     * @param type $modPencucianLinenDetail
     * @param type $detail
     * @return \LAPencuciandetailT
     */
    public function simpanPencucianLinenDetail($modPencucianLinen ,$detail){
        $format = new MyFormatter();
        $modPencucianLinenDetail = new LAPencuciandetailT;
        $modPencucianLinenDetail->attributes = $detail;
        $modPencucianLinenDetail->pencucianlinen_id = $modPencucianLinen->pencucianlinen_id;
        $modPencucianLinenDetail->statuspencucian = $detail['jenisperawatanlinen'];

        // var_dump($modPencucianLinenDetail->attributes, $modPencucianLinenDetail->validate(), $modPencucianLinenDetail->errors);
        
        if($modPencucianLinenDetail->validate()) { 
            $modPencucianLinenDetail->save();
			// $this->updatePencucianLinen($modPencucianLinen,$detail);
			$this->pencucianlinendetailtersimpan &= true;
        } else {
            $this->pencucianlinendetailtersimpan &= false;
        }
        return $modPencucianLinenDetail;
    }
	
	public function updatePencucianLinen($modPencucianLinen,$detail){
		$modPencucianLinen = LAPencucianlinenT::model()->findByPk($modPencucianLinen->pencucianlinen_id);
		// $modPencucianLinen->penerimaanlinen_id = $detail['penerimaanlinen_id'];
		$modPencucianLinen->save();
	}
	/**
     * simpan LAPencucianbahanT
     * @param type $modPencucianBahan
     * @param type $bahan
     * @return \LAPencucianbahanT
     */
    public function simpanPencucianBahan($modPencucianLinen ,$bahan){
        $format = new MyFormatter();
        $modPencucianBahan = new LAPencucianbahanT;
        $modPencucianBahan->attributes = $bahan;
        $modPencucianBahan->pencucianlinen_id = $modPencucianLinen->pencucianlinen_id;

        $s = SatuankecilM::model()->findByPk($modPencucianBahan->satuanpemakaian);
        $modPencucianBahan->satuanpemakaian = $s->satuankecil_nama;
        
        // var_dump($modPencucianBahan->attributes); die;
        
        if($modPencucianBahan->validate()) { 
            $modPencucianBahan->save();
			$this->pencucianbahantersimpan &= true;
        } else {
            $this->pencucianbahantersimpan &= false;
        }
        return $modPencucianBahan;
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
	
	public function actionAutocompleteBahanPerawatan()
    {
        if(Yii::app()->request->isAjaxRequest) {
	    $returnVal = array();
            $criteria = new CDbCriteria();
            $criteria->compare('LOWER(bahanperawatan_nama)', strtolower($_GET['term']), true);
            $criteria->order = 'bahanperawatan_nama';
            $criteria->limit = 5;
            $models = LABahanperawatanM::model()->findAll($criteria);
            foreach($models as $i=>$model)
            {
                $attributes = $model->attributeNames();
                foreach($attributes as $j=>$attribute) {
                    $returnVal[$i]["$attribute"] = $model->$attribute;
                }
                $returnVal[$i]['label'] = $model->bahanperawatan_jenis."-".$model->bahanperawatan_nama;
                $returnVal[$i]['value'] = $model->bahanperawatan_id;
            }

            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }
	
	public function actionSetFormDetailBahanPerawatan()
    {
        if(Yii::app()->request->isAjaxRequest) { 
            $bahanperawatan_id = isset($_POST['bahanperawatan_id']) ? $_POST['bahanperawatan_id'] : null;
            $jumlah = isset($_POST['jumlah']) ? $_POST['jumlah'] : null;
            $satuan = isset($_POST['satuan']) ? $_POST['satuan'] : null;
            $form = "";
            $pesan = "";
            $format = new MyFormatter();
            $modBahanPerawatan = LABahanperawatanM::model()->findByPk($bahanperawatan_id);
            $ruangan_id = Yii::app()->user->getState('ruangan_id');
			$modPencucianLinenbahan = array();
			if($modBahanPerawatan){
				$modPencucianLinenbahan = new LAPencucianbahanT;
				$modPencucianLinenbahan->bahanperawatan_id = $modBahanPerawatan->bahanperawatan_id;
				$modPencucianLinenbahan->jmlpemakaian = $jumlah;
				$modPencucianLinenbahan->satuanpemakaian = $satuan;
				$modPencucianLinenbahan->bahanperawatan_nama = $modBahanPerawatan->bahanperawatan_nama;
				$form = $this->renderPartial($this->path_view.'_rowBahanLinen', array('modDetail'=>$modPencucianLinenbahan), true);
			}else{
				$pesan = "Obat alkes tidak ada!";
			}
            echo CJSON::encode(array('form'=>$form, 'pesan'=>$pesan));
            Yii::app()->end(); 
        }
    }
	
	/**
     * untuk print data perawatan linen
     */
    public function actionPrint($pencucianlinen_id,$caraprint = null) 
    {
        $this->layout='//layouts/printWindows';
        if (isset($_GET['frame'])){
            $this->layout='//layouts/iframe';
        }else if($caraprint=='EXCEL') {
            $this->layout='//layouts/printExcel';
        }
        $format = new MyFormatter;    
        $modPencucianLinen = LAPencucianlinenT::model()->findByPk($pencucianlinen_id);     
        $modPencucianLinenDetail = LAPencuciandetailT::model()->findAllByAttributes(array('pencucianlinen_id'=>$modPencucianLinen->pencucianlinen_id));
        $modPencucianBahan = LAPencucianbahanT::model()->findAllByAttributes(array('pencucianlinen_id'=>$pencucianlinen_id));
		
        $judul_print = 'Pencucian Linen';
        
        $this->render($this->path_view.'Print', array(
                'format'=>$format,
                'judul_print'=>$judul_print,
                'modPencucianLinen'=>$modPencucianLinen,
                'modPencucianLinenDetail'=>$modPencucianLinenDetail,
                'modPencucianBahan'=>$modPencucianBahan,
                'caraprint'=>$caraprint
        ));
    } 
}
