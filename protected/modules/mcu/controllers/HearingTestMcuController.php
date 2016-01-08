<?php
Yii::import('rawatJalan.models.*');
class HearingTestMcuController extends MyAuthController
{
    public $layout='//layouts/iframe';
    public $defaultAction = 'index';
	public $hearingtesttersimpan = false;
    protected $path_view = 'mcu.views.hearingTestMcu.';
    
	public function actionIndex($pendaftaran_id, $id = null)
	{
		$ruangan_id = isset($_GET['ruangan_id']) ? $_GET['ruangan_id'] : Yii::app()->user->getState('ruangan_id');
		$modPendaftaran = RJPendaftaranT::model()->with('jeniskasuspenyakit')->findByPk($pendaftaran_id);
		$modPasien = MCPasienM::model()->findByPk($modPendaftaran->pasien_id);
		$modHearingTest = new MCHearingtestT();
		$modHearingTest->tglhearingtest = date('Y-m-d H:i:s');
		$modDetails = array();
		
		if(!empty($id)){
			$modHearingTest = MCHearingtestT::model()->findByPk($id);
		}		
		
		if(isset($_POST['MCHearingtestT'])){
			$transaction = Yii::app()->db->beginTransaction();
			try {
					$modHearingTest = $this->simpanHearingTest($modPendaftaran,$modHearingTest, $_POST['MCHearingtestT']);
					if($this->hearingtesttersimpan){
						$transaction->commit();
						$this->redirect(array('index','pendaftaran_id'=>$pendaftaran_id,'id'=>$modHearingTest->hearingtest_id,'sukses'=>1));       
					}else{
						$transaction->rollback();
						Yii::app()->user->setFlash('error',"Data Pemeriksaan Kacamata gagal disimpan !");
					}
			} catch (Exception $exc) {
				$transaction->rollback();
				$btn_ulang = "<a class='btn btn-danger' href='javascript:document.location.reload();' rel='tooltip' title='Klik tombol ini lalu klik \"Resend\" '>"
						. "<i class='icon-refresh icon-white'></i> Simpan Ulang"
						. "</a>";
				Yii::app()->user->setFlash('error',"Data Pemeriksaan Kacamata gagal disimpan ! ".$btn_ulang." ".MyExceptionMessage::getMessage($exc,true));
			}
		}
		
		$this->render($this->path_view.'index',array(
			'modPendaftaran'=>$modPendaftaran,
			'modPasien'=>$modPasien,
			'modHearingTest'=>$modHearingTest,
		));
	}
	
	/**
	 * proses simpan data periksa kacamata
	 * @param type $model
	 * @param type $post
	 * @return type
	 */
	public function simpanHearingTest($modPendaftaran, $post , $modHearingTest){
		$format = new MyFormatter();
		$modHearingTest = new MCHearingtestT;
		$modHearingTest->attributes = $_POST['MCHearingtestT'];
		$modHearingTest->pasien_id = $modPendaftaran->pasien_id;
		$modHearingTest->ruangan_id = $modPendaftaran->ruangan_id;
		$modHearingTest->pendaftaran_id = $modPendaftaran->pendaftaran_id;
		$modHearingTest->pegawai_id = $modPendaftaran->pegawai_id;
		$modHearingTest->tglhearingtest = date('Y-m-d H:i:s');
		$modHearingTest->create_time = date('Y-m-d H:i:s');
		$modHearingTest->create_loginpemakai_id = Yii::app()->user->id;
		$modHearingTest->create_ruangan = Yii::app()->user->getState('ruangan_id');
		
		$modHearingTest->tkn_500 = !empty($_POST['MCHearingtestT']['tkn_500'])?$_POST['MCHearingtestT']['tkn_500']:null;
		$modHearingTest->tkn_1k = !empty($_POST['MCHearingtestT']['tkn_1k'])?$_POST['MCHearingtestT']['tkn_1k']:null;
		$modHearingTest->tkn_2k = !empty($_POST['MCHearingtestT']['tkn_2k'])?$_POST['MCHearingtestT']['tkn_2k']:null;
		$modHearingTest->tkn_3k = !empty($_POST['MCHearingtestT']['tkn_3k'])?$_POST['MCHearingtestT']['tkn_3k']:null;
		$modHearingTest->tkn_4k = !empty($_POST['MCHearingtestT']['tkn_4k'])?$_POST['MCHearingtestT']['tkn_4k']:null;
		$modHearingTest->tkn_6k = !empty($_POST['MCHearingtestT']['tkn_6k'])?$_POST['MCHearingtestT']['tkn_6k']:null;
		$modHearingTest->tkn_8k = !empty($_POST['MCHearingtestT']['tkn_8k'])?$_POST['MCHearingtestT']['tkn_8k']:null;
		$modHearingTest->tkr_500 = !empty($_POST['MCHearingtestT']['tkr_500'])?$_POST['MCHearingtestT']['tkr_500']:null;
		$modHearingTest->tkr_1k = !empty($_POST['MCHearingtestT']['tkr_1k'])?$_POST['MCHearingtestT']['tkr_1k']:null;
		$modHearingTest->tkr_2k = !empty($_POST['MCHearingtestT']['tkr_2k'])?$_POST['MCHearingtestT']['tkr_2k']:null;
		$modHearingTest->tkr_3k = !empty($_POST['MCHearingtestT']['tkr_3k'])?$_POST['MCHearingtestT']['tkr_3k']:null;
		$modHearingTest->tkr_4k = !empty($_POST['MCHearingtestT']['tkr_4k'])?$_POST['MCHearingtestT']['tkr_4k']:null;
		$modHearingTest->tkr_6k = !empty($_POST['MCHearingtestT']['tkr_6k'])?$_POST['MCHearingtestT']['tkr_6k']:null;
		$modHearingTest->tkr_8k = !empty($_POST['MCHearingtestT']['tkr_8k'])?$_POST['MCHearingtestT']['tkr_8k']:null;
		if($modHearingTest->validate()){
			$modHearingTest->save();
			$this->hearingtesttersimpan = true;
		}

		return $modHearingTest;
	}
	
	/**
     * untuk print data treadmill
     */
    public function actionPrint($hearingtest_id,$pendaftaran_id,$caraPrint = null) 
    {
		$this->layout='//layouts/iframe';
        $format = new MyFormatter;    
        $modHearingTest = MCHearingtestT::model()->findByPk($hearingtest_id);     
		$modPendaftaran = MCPendaftaranT::model()->findByPk($modHearingTest->pendaftaran_id);
		$modPasien = MCPasienM::model()->findByPk($modPendaftaran->pasien_id);

        $judul_print = 'FORMULIR PEMERIKSAAN AUDIOMETRI';
        $caraPrint = isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null;
        if($caraPrint=='PRINT') {
            $this->layout='//layouts/printWindows';
        }
        else if($caraPrint=='EXCEL') {
            $this->layout='//layouts/printExcel';
        }else if($caraPrint=='GRAFIK') {
            $this->layout='//layouts/iframeNeon';
        }
        
        $this->render($this->path_view.'Print', array(
                'format'=>$format,
                'judul_print'=>$judul_print,
                'modHearingTest'=>$modHearingTest,
				'modPasien'=>$modPasien,
				'modPendaftaran'=>$modPendaftaran,
                'caraPrint'=>$caraPrint
        ));
    }
	
	public function actionAutocompletePemeriksa()
    {
        if(Yii::app()->request->isAjaxRequest) {
            $criteria = new CDbCriteria();
            $criteria->compare('LOWER(nama_pegawai)', strtolower($_GET['term']), true);
            $criteria->order = 'nama_pegawai';
            $criteria->limit=10;
            $models = PegawaiM::model()->findAll($criteria);
             foreach ($models as $item) {
                 $arr[] = $item->NamaLengkap;                 
             }		 

            echo CJSON::encode($arr);
        }
        Yii::app()->end();
    }
	
	/**
     * untuk print data grafik telinga kiri
     */
    public function actionGrafikTelingaKiri($hearingtest_id,$pendaftaran_id,$caraPrint = null) 
    {
		$this->layout='//layouts/iframeNeon';
        $format = new MyFormatter;    
        $modHearingTest = MCHearingtestT::model()->findByPk($hearingtest_id);     
		$modPendaftaran = MCPendaftaranT::model()->findByPk($modHearingTest->pendaftaran_id);
		$modPasien = MCPasienM::model()->findByPk($modPendaftaran->pasien_id);

        $judul_print = 'AUDIOMETRY (SPLIT VIEW, TONE, AND SPEECH)';
        $caraPrint = isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null;
        $type = isset($_REQUEST['type']) ? $_REQUEST['type'] : null;
        if($caraPrint=='PRINT' || $caraPrint == "GRAFIK") {
            $this->layout='//layouts/printWindows';
			$this->render($this->path_view.'PrintDiagramTelingaKiri', array(
					'format'=>$format,
					'judul_print'=>$judul_print,
					'modHearingTest'=>$modHearingTest,
					'modPasien'=>$modPasien,
					'modPendaftaran'=>$modPendaftaran,
					'caraPrint'=>$caraPrint,
					'type'=>$type,
			));
        }
        else if($caraPrint=='EXCEL') {
            $this->layout='//layouts/printExcel';
			$this->render($this->path_view.'PrintDiagramTelingaKiri', array(
					'format'=>$format,
					'judul_print'=>$judul_print,
					'modHearingTest'=>$modHearingTest,
					'modPasien'=>$modPasien,
					'modPendaftaran'=>$modPendaftaran,
					'caraPrint'=>$caraPrint,
					'type'=>$type,
			));
        }else{
			$this->render($this->path_view.'_diagramTelingaKiri', array(
					'format'=>$format,
					'judul_print'=>$judul_print,
					'modHearingTest'=>$modHearingTest,
					'modPasien'=>$modPasien,
					'modPendaftaran'=>$modPendaftaran,
					'caraPrint'=>$caraPrint,
			));
		}      
        
    }
	
	/**
     * untuk print data grafik telinga kanan
     */
    public function actionGrafikTelingaKanan($hearingtest_id,$pendaftaran_id,$caraPrint = null) 
    {
		$this->layout='//layouts/iframeNeon';
        $format = new MyFormatter;    
        $modHearingTest = MCHearingtestT::model()->findByPk($hearingtest_id);     
		$modPendaftaran = MCPendaftaranT::model()->findByPk($modHearingTest->pendaftaran_id);
		$modPasien = MCPasienM::model()->findByPk($modPendaftaran->pasien_id);

        $judul_print = 'AUDIOMETRY (SPLIT VIEW, TONE, AND SPEECH)';
        $caraPrint = isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null;
        $type = isset($_REQUEST['type']) ? $_REQUEST['type'] : null;
        if($caraPrint=='PRINT' || $caraPrint == "GRAFIK") {
            $this->layout='//layouts/printWindows';
			$this->render($this->path_view.'PrintDiagramTelingaKanan', array(
					'format'=>$format,
					'judul_print'=>$judul_print,
					'modHearingTest'=>$modHearingTest,
					'modPasien'=>$modPasien,
					'modPendaftaran'=>$modPendaftaran,
					'caraPrint'=>$caraPrint,
					'type'=>$type,
			));
        }
        else if($caraPrint=='EXCEL') {
            $this->layout='//layouts/printExcel';
			$this->render($this->path_view.'PrintDiagramTelingaKanan', array(
					'format'=>$format,
					'judul_print'=>$judul_print,
					'modHearingTest'=>$modHearingTest,
					'modPasien'=>$modPasien,
					'modPendaftaran'=>$modPendaftaran,
					'caraPrint'=>$caraPrint,
					'type'=>$type,
			));
        }else{
			$this->render($this->path_view.'_diagramTelingaKanan', array(
					'format'=>$format,
					'judul_print'=>$judul_print,
					'modHearingTest'=>$modHearingTest,
					'modPasien'=>$modPasien,
					'modPendaftaran'=>$modPendaftaran,
					'caraPrint'=>$caraPrint,
			));
		}      
        
    }
}