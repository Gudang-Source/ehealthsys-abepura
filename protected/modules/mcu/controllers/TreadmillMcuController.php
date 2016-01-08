<?php
Yii::import('rawatJalan.models.*');
class TreadmillMcuController extends MyAuthController
{
    public $layout='//layouts/iframe';
    public $defaultAction = 'index';
	public $treadmilltersimpan = false;
	public $treadmilldetailtersimpan = false;
    protected $path_view = 'mcu.views.treadmillMcu.';
    
	public function actionIndex($pendaftaran_id, $id = null)
	{
		$ruangan_id = isset($_GET['ruangan_id']) ? $_GET['ruangan_id'] : Yii::app()->user->getState('ruangan_id');
		$modPendaftaran = RJPendaftaranT::model()->with('jeniskasuspenyakit')->findByPk($pendaftaran_id);
		$modPasien = MCPasienM::model()->findByPk($modPendaftaran->pasien_id);
		$modTreadmill = new MCTreadmillT;
		$modTreadmillDetail = new MCTreadmilldetailT;
		$modDetails = array();
		
		if(!empty($id)){
			$modTreadmill = MCTreadmillT::model()->findByPk($id);
		}
		
		
		if(isset($_POST['MCTreadmillT'])){
			$transaction = Yii::app()->db->beginTransaction();
			try {
					$modTreadmill = $this->simpanTreadmill($modPendaftaran,$modTreadmill, $_POST['MCTreadmillT']);
					if(count($_POST['MCTreadmilldetailT']) > 0){
						foreach($_POST['MCTreadmilldetailT'] as $i=>$details){
							$modDetails[$i] = $this->simpanTreadmillDetail($_POST['MCTreadmilldetailT'], $details, $modTreadmill);
						}
					}
				
					if($this->treadmilltersimpan && $this->treadmilldetailtersimpan){
						$transaction->commit();
						$this->redirect(array('index','pendaftaran_id'=>$pendaftaran_id,'id'=>$modTreadmill->treadmill_id,'sukses'=>1));       
					}else{
						$transaction->rollback();
						Yii::app()->user->setFlash('error',"Data Treadmill gagal disimpan !");
					}
			} catch (Exception $exc) {
				$transaction->rollback();
				$btn_ulang = "<a class='btn btn-danger' href='javascript:document.location.reload();' rel='tooltip' title='Klik tombol ini lalu klik \"Resend\" '>"
						. "<i class='icon-refresh icon-white'></i> Simpan Ulang"
						. "</a>";
				Yii::app()->user->setFlash('error',"Data Treadmill gagal disimpan ! ".$btn_ulang." ".MyExceptionMessage::getMessage($exc,true));
			}
		}
		
		$this->render($this->path_view.'index',array(
			'modPendaftaran'=>$modPendaftaran,
			'modPasien'=>$modPasien,
			'modTreadmill'=>$modTreadmill,
			'modTreadmillDetail'=>$modTreadmillDetail
		));
	}
	
	/**
    * menampilkan obat
    * @return row table 
    */
    public function actionSetFormTreadmill()
    {
        if(Yii::app()->request->isAjaxRequest) { 
            $duration = isset($_POST['duration']) ? $_POST['duration'] : null;
            $td_systolic = isset($_POST['td_systolic']) ? $_POST['td_systolic'] : null;
			$td_diastolic = isset($_POST['td_diastolic']) ? $_POST['td_diastolic'] : null;
			$heart_rate = isset($_POST['heart_rate']) ? $_POST['heart_rate'] : null;
            $form = "";
            $pesan = "";
            $format = new MyFormatter();
			$modKlasifikasi = KlasifikasifitnesM::model()->findByPk($duration);
            $modTreadmillDetail = new MCTreadmilldetailT;
            if(!empty($duration)){
				$modTreadmillDetail->duration_treadmill = $modKlasifikasi->lama_menit;
				$modTreadmillDetail->age_elev = $modKlasifikasi->age_elev;
				$modTreadmillDetail->workload_kph = $modKlasifikasi->workload_kph;
				$modTreadmillDetail->est02_rate_min = $modKlasifikasi->estimasirate;
				$modTreadmillDetail->max02_intake = $modKlasifikasi->max_intake;
				$modTreadmillDetail->mets_treadmill = $modKlasifikasi->mets;
				$modTreadmillDetail->fitnessclassification = $modKlasifikasi->klasifikasifitnes;
				$modTreadmillDetail->functional_class_treadmill = $modKlasifikasi->functional_class;
				$modTreadmillDetail->walking_kmhr_treadmill = $modKlasifikasi->walking_kmhr;
				$modTreadmillDetail->jogging_kmhr_treadmill = $modKlasifikasi->jogging_kmhr;
				$modTreadmillDetail->bicycling_kmhr_treadmill = $modKlasifikasi->bicycling_kmhr;
				$modTreadmillDetail->sports_kmhr_treadmill = $modKlasifikasi->other_sports;
				$modTreadmillDetail->td_systolic = $td_systolic;
				$modTreadmillDetail->td_diastolic = $td_diastolic;
				$modTreadmillDetail->heartrate_treadmill = $heart_rate;
				$form .= $this->renderPartial($this->path_view.'_rowTreadmill', array('modTreadmillDetail'=>$modTreadmillDetail), true);
            }else{
                $pesan = "Data Treadmill tidak ditemukan!";
            }
            
            echo CJSON::encode(array('form'=>$form, 'pesan'=>$pesan));
            Yii::app()->end(); 
        }
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
	 * proses simpan data treadmill
	 * @param type $model
	 * @param type $post
	 * @return type
	 */
	public function simpanTreadmill($modPendaftaran, $post , $modTreadmill){
		$format = new MyFormatter();
		$modTreadmill = new MCTreadmillT;
		$modTreadmill->attributes = $_POST['MCTreadmillT'];
		$modTreadmill->pasien_id = $modPendaftaran->pasien_id;
		$modTreadmill->ruangan_id = $modPendaftaran->ruangan_id;
		$modTreadmill->pendaftaran_id = $modPendaftaran->pendaftaran_id;
		$modTreadmill->pegawai_id = $modPendaftaran->pegawai_id;
		$modTreadmill->tgltreadmill = date('Y-m-d H:i:s');
		$modTreadmill->create_time = date('Y-m-d H:i:s');
		$modTreadmill->create_loginpemakai_id = Yii::app()->user->id;
		$modTreadmill->create_ruangan = Yii::app()->user->getState('ruangan_id');
		$modTreadmill->resttime_menit = !empty($_POST['MCTreadmillT']['resttime_menit'])?$_POST['MCTreadmillT']['resttime_menit']:0;
		$modTreadmill->worktime_menit = !empty($_POST['MCTreadmillT']['worktime_menit'])?$_POST['MCTreadmillT']['worktime_menit']:0;
		$modTreadmill->recoverytime_menit = !empty($_POST['MCTreadmillT']['recoverytime_menit'])?$_POST['MCTreadmillT']['recoverytime_menit']:0;
		$modTreadmill->totaltime_menit = !empty($_POST['MCTreadmillT']['totaltime_menit'])?$_POST['MCTreadmillT']['totaltime_menit']:0;
		
		if($modTreadmill->validate()){
			$modTreadmill->save();
			$this->treadmilltersimpan = true;
		}

		return $modTreadmill;
	}
	
	/**
     * simpan TreadmilldetailT
     * @param type $model
     * @param type $postKacamata
     * @return \TreadmilldetailT
     */
    protected function simpanTreadmillDetail($postTreadmillDetail,$details,$postTreadmill){
		
        $format = new MyFormatter;
        $modTreadmillDetail = new MCTreadmilldetailT;
        $modTreadmillDetail->attributes = $details;
        $modTreadmillDetail->treadmill_id = $postTreadmill->treadmill_id;	

        if($modTreadmillDetail->validate()){
			$modTreadmillDetail->save();            
			$this->treadmilldetailtersimpan = true;
        }else{
            $this->treadmilldetailtersimpan = false;
        }
        return $modTreadmillDetail;
    }
	
	/**
     * untuk print data treadmill
     */
    public function actionPrint($treadmill_id,$pendaftaran_id,$caraPrint = null) 
    {
		$this->layout='//layouts/iframe';
        $format = new MyFormatter;    
        $modTreadmill = MCTreadmillT::model()->findByPk($treadmill_id);     
        $modTreadmillDetail = MCTreadmilldetailT::model()->findAllByAttributes(array('treadmill_id'=>$treadmill_id));
		$modPendaftaran = MCPendaftaranT::model()->findByPk($modTreadmill->pendaftaran_id);
		$modPasien = MCPasienM::model()->findByPk($modPendaftaran->pasien_id);

        $judul_print = 'TREADMILL EXCERCISE TEST ('.$modTreadmill->pasien->jeniskelamin.')';
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
                'modTreadmill'=>$modTreadmill,
                'modTreadmillDetail'=>$modTreadmillDetail,
				'modPasien'=>$modPasien,
				'modPendaftaran'=>$modPendaftaran,
                'caraPrint'=>$caraPrint
        ));
    }
	
	/**
     * untuk print data treadmill
     */
    public function actionGrafik($treadmill_id,$pendaftaran_id,$caraPrint = null) 
    {
		$this->layout='//layouts/iframeNeon';
        $format = new MyFormatter;    
        $modTreadmill = MCTreadmillT::model()->findByPk($treadmill_id);     
        $modTreadmillDetail = MCTreadmilldetailT::model()->findAllByAttributes(array('treadmill_id'=>$treadmill_id),array('order'=>'treadmilldetail_id asc'));
        $modTreadmillDetailMax = MCTreadmilldetailT::model()->findByAttributes(array('treadmill_id'=>$treadmill_id),array('order'=>'treadmilldetail_id desc'));
		$modPendaftaran = MCPendaftaranT::model()->findByPk($modTreadmill->pendaftaran_id);
		$modPasien = MCPasienM::model()->findByPk($modPendaftaran->pasien_id);

        $judul_print = 'TREADMILL EXCERCISE TEST ('.$modTreadmill->pasien->jeniskelamin.')';
        $caraPrint = isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null;
        $type = isset($_REQUEST['type']) ? $_REQUEST['type'] : null;
        if($caraPrint=='PRINT' || $caraPrint == "GRAFIK") {
            $this->layout='//layouts/printWindows';
			$this->render($this->path_view.'PrintDiagram', array(
					'format'=>$format,
					'judul_print'=>$judul_print,
					'modTreadmill'=>$modTreadmill,
					'modTreadmillDetail'=>$modTreadmillDetail,
					'modPasien'=>$modPasien,
					'modPendaftaran'=>$modPendaftaran,
					'caraPrint'=>$caraPrint,
					'type'=>$type,
					'modTreadmillDetailMax'=>$modTreadmillDetailMax
			));
        }
        else if($caraPrint=='EXCEL') {
            $this->layout='//layouts/printExcel';
			$this->render($this->path_view.'PrintDiagram', array(
					'format'=>$format,
					'judul_print'=>$judul_print,
					'modTreadmill'=>$modTreadmill,
					'modTreadmillDetail'=>$modTreadmillDetail,
					'modPasien'=>$modPasien,
					'modPendaftaran'=>$modPendaftaran,
					'caraPrint'=>$caraPrint,
					'type'=>$type,
					'modTreadmillDetailMax'=>$modTreadmillDetailMax
			));
        }else{
			$this->render($this->path_view.'Diagram', array(
					'format'=>$format,
					'judul_print'=>$judul_print,
					'modTreadmill'=>$modTreadmill,
					'modTreadmillDetail'=>$modTreadmillDetail,
					'modPasien'=>$modPasien,
					'modPendaftaran'=>$modPendaftaran,
					'caraPrint'=>$caraPrint,
					'modTreadmillDetailMax'=>$modTreadmillDetailMax
			));
		}      
        
    }
}