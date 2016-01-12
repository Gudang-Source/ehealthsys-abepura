<?php 
class PerawatanLinenController extends MyAuthController{

	public $defaultAction = 'index';
    public $path_view = 'laundry.views.perawatanLinen.';
    public $perawatanlinentersimpan = false;
    public $perawatanlinendetailtersimpan = true;
    public $perawatanbahantersimpan = true;

    public function actionIndex($perawatanlinen_id = null){
    	$format = new MyFormatter();
		$modPenerimaanLinen = new LAPenerimaanlinenT;		
		$modPenerimaanLinenDetail = new LAPenerimaanlinendetailT('searchPenerimaanLinenDetail');
		$modPenerimaanLinenDetail->tgl_awal = date('Y-m-d H:i:s');
		$modPenerimaanLinenDetail->tgl_akhir = date('Y-m-d H:i:s');
		$modPenerimaanLinenDetail->instalasi_id = Yii::app()->user->getState('instalasi_id');
    	$modPerawatanLinen = new LAPerawatanlinenT;
    	$modPerawatanLinen->tglperawatanlinen = date('Y-m-d H:i:s');
    	$modPerawatanLinen->noperawatan = '-Otomatis-';
    	$modPerawatanLinenDetail = array();
		$modPerawatanBahan = array();
        $instalasiTujuans = CHtml::listData(LAInstalasiM::getInstalasiItems(),'instalasi_id','instalasi_nama');
        $ruanganTujuans = CHtml::listData(LARuanganM::getRuanganByInstalasi($modPenerimaanLinenDetail->instalasi_id),'ruangan_id','ruangan_nama');

    	if(!empty($perawatanlinen_id)){
            $modPerawatanLinen= LAPerawatanlinenT::model()->findByPk($perawatanlinen_id);
            $modPerawatanLinen->pegperawat_nama = !empty($modPerawatanLinen->pegperawatan->NamaLengkap) ? $modPerawatanLinen->pegperawatan->NamaLengkap : "";
            $modPerawatanLinen->pegmengetahui_nama = !empty($modPerawatanLinen->pegmengetahui->NamaLengkap) ? $modPerawatanLinen->pegmengetahui->NamaLengkap : "";
            $modPerawatanLinenDetail = LAPerawatanlinendetailT::model()->findAllByAttributes(array('perawatanlinen_id'=>$modPerawatanLinen->perawatanlinen_id));
        }

        if(isset($_POST['LAPerawatanlinenT'])){
            $transaction = Yii::app()->db->beginTransaction();
            try {

				$modPerawatanLinen->attributes=$_POST['LAPerawatanlinenT'];
				$modPerawatanLinen->noperawatan = MyGenerator::noPerawatanLinen();
				$modPerawatanLinen->tglperawatanlinen=$format->formatDateTimeForDb($_POST['LAPerawatanlinenT']['tglperawatanlinen']);
				$modPerawatanLinen->pegperawatan_id=Yii::app()->user->id;
				$modPerawatanLinen->create_time = date('Y-m-d H:i:s');
				$modPerawatanLinen->create_loginpemakai_id = Yii::app()->user->id;
				$modPerawatanLinen->create_ruangan = Yii::app()->user->ruangan_id;

				if($modPerawatanLinen->save()){
					$this->perawatanlinentersimpan = true;
					if (isset($_POST['LAPerawatanlinendetailT'])) {
						if(count($_POST['LAPerawatanlinendetailT']) > 0){
						   foreach($_POST['LAPerawatanlinendetailT'] AS $i => $detail){
								if($detail['checklist'] == 1){
									$modPerawatanLinenDetail[$i] = $this->simpanPerawatanDetail($modPerawatanLinen,$detail);
								}
						   }
						}
					}
					
					if (isset($_POST['LAPerawatanbahanT'])) {
						if(count($_POST['LAPerawatanbahanT']) > 0){
						   foreach($_POST['LAPerawatanbahanT'] AS $i => $bahan){
							   $modPerawatanBahan[$i] = $this->simpanPerawatanBahan($modPerawatanLinen,$bahan);
						   }
						}
					}
					
				}else{
					echo "b";exit;
					$this->perawatanlinentersimpan = false;
				}
                if($this->perawatanlinentersimpan && $this->perawatanlinendetailtersimpan && $this->perawatanbahantersimpan){
                    $transaction->commit();
                    $modPerawatanLinen->isNewRecord = FALSE;
                    $this->redirect(array('index','perawatanlinen_id'=>$modPerawatanLinen->perawatanlinen_id,'sukses'=>1));
                }else{
                    $transaction->rollback();
                    Yii::app()->user->setFlash('error',"Data Perawatan Linen gagal disimpan !");
                }
            } catch (Exception $e) {
                $transaction->rollback();
                Yii::app()->user->setFlash('error',"Data Perawatan Linen gagal disimpan ! ".MyExceptionMessage::getMessage($e,true));
            }
        }

		if(isset($_GET['LAPenerimaanlinendetailT']))
        {
                $modPenerimaanLinenDetail->unsetAttributes();
                $modPenerimaanLinenDetail->attributes	= $_GET['LAPenerimaanlinendetailT'];			
                $modPenerimaanLinenDetail->tgl_awal		= $format->formatDateTimeForDb($_GET['LAPenerimaanlinendetailT']['tgl_awal']);			
                $modPenerimaanLinenDetail->tgl_akhir	= $format->formatDateTimeForDb($_GET['LAPenerimaanlinendetailT']['tgl_akhir']);			
                $modPenerimaanLinenDetail->nopenerimaanlinen	= $_GET['LAPenerimaanlinendetailT']['nopenerimaanlinen'];			
        }
    	$this->render($this->path_view.'index',array(
            'format'=>$format,
			'modPenerimaanLinen'=>$modPenerimaanLinen,
            'modPenerimaanLinenDetail'=>$modPenerimaanLinenDetail,
            'modPerawatanLinen'=>$modPerawatanLinen,
            'modPerawatanLinenDetail'=>$modPerawatanLinenDetail,
			'modPerawatanBahan'=>$modPerawatanBahan,
            'instalasiTujuans'=>$instalasiTujuans,
            'ruanganTujuans'=>$ruanganTujuans,
        ));
    }
	
	/**
     * simpan LAPerawatanlinendetailT
     * @param type $modPerawatanLinenDetail
     * @param type $detail
     * @return \LAPerawatanlinendetailT
     */
    public function simpanPerawatanDetail($modPerawatanLinen ,$detail){
        $format = new MyFormatter();
        $modPerawatanDetail = new LAPerawatanlinendetailT;
        $modPerawatanDetail->attributes = $detail;
        $modPerawatanDetail->perawatanlinen_id = $modPerawatanLinen->perawatanlinen_id;
		$modPerawatanDetail->ruangan_id = Yii::app()->user->getState('ruangan_id');
		$modPerawatanDetail->jenisperawatan = Yii::app()->user->getState('ruangan_id');

        if($modPerawatanDetail->validate()) { 
            $modPerawatanDetail->save();
			$this->perawatanlinendetailtersimpan &= true;
        } else {
            $this->perawatanlinentersimpan &= false;
        }
        return $modPerawatanDetail;
    }
	
	/**
     * simpan LAPerawatanbahanT
     * @param type $modPerawatanBahan
     * @param type $bahan
     * @return \LAPerawatanbahanT
     */
    public function simpanPerawatanBahan($modPerawatanLinen ,$bahan){
        $format = new MyFormatter();
        $modPerawatanBahan = new LAPerawatanbahanT;
        $modPerawatanBahan->attributes = $bahan;
        $modPerawatanBahan->perawatanlinen_id = $modPerawatanLinen->perawatanlinen_id;

        if($modPerawatanBahan->validate()) { 
            $modPerawatanBahan->save();
			$this->perawatanbahantersimpan &= true;
        } else {
            $this->perawatanbahantersimpan &= false;
        }
        return $modPerawatanBahan;
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
			$modPerawatanbahan = array();
			if($modBahanPerawatan){
				$modPerawatanbahan = new LAPerawatanbahanT;
				$modPerawatanbahan->bahanperawatan_id = $modBahanPerawatan->bahanperawatan_id;
				$modPerawatanbahan->jmlbahanpemakaian = $jumlah;
				$modPerawatanbahan->satuanpemakaian = $satuan;
				$modPerawatanbahan->bahanperawatan_nama = $modBahanPerawatan->bahanperawatan_nama;
				$form = $this->renderPartial($this->path_view.'_rowBahanLinen', array('modDetail'=>$modPerawatanbahan), true);
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
    public function actionPrint($perawatanlinen_id,$caraprint = null) 
    {
        $this->layout='//layouts/printWindows';
        if (isset($_GET['frame'])){
            $this->layout='//layouts/iframe';
        }else if($caraprint=='EXCEL') {
            $this->layout='//layouts/printExcel';
        }
        $format = new MyFormatter;    
        $modPerawatan = LAPerawatanlinenT::model()->findByPk($perawatanlinen_id);     
        $modPerawatanDetail = LAPerawatanlinendetailT::model()->findAllByAttributes(array('perawatanlinen_id'=>$perawatanlinen_id));
        $modPerawatanBahan = LAPerawatanbahanT::model()->findAllByAttributes(array('perawatanlinen_id'=>$perawatanlinen_id));

        $judul_print = 'Perawatan Linen';
        
        $this->render($this->path_view.'Print', array(
			'format'=>$format,
			'judul_print'=>$judul_print,
			'modPerawatan'=>$modPerawatan,
			'modPerawatanDetail'=>$modPerawatanDetail,
			'modPerawatanBahan'=>$modPerawatanBahan,
			'caraprint'=>$caraprint
        ));
    } 
}
