<?php

class InacbgController extends MyAuthController{
	
	public $path_view = 'asuransi.views.cbgCmgBpjs.';
	public $path_view_inacbg = 'asuransi.views.inacbg.';
	public $path_view_billingkasir = 'billingKasir.views.';
	public $inacbgtersimpan = false;
	public $bridgingfinalisasiberhasil = true;
	public $updatefinalisasitersimpan = true;
	
	public function actionIndex(){
		$model = new ARInacbgT();
		$modSEP = new ARSepT();
		$modPendaftaran = new ARPendaftaranT();
		$modPasien = new ARPasienM();
		$modPasienAdmisi = new ARPasienadmisiT();
		$modPasienPulang = new ARPasienpulangT();
		$modPasienMorbiditas = new ARPasienmorbiditasT();
		$modInasisCbg = new ARInasiscbgT();
		$modInasisCmg = new ARInasiscmgT();
		
		if(!empty($_GET['inacbg_id'])){
			$model = ARInacbgT::model()->findByPk($_GET['inacbg_id']);
			$modSEP = ARSepT::model()->findByPK($model->sep_id);
			$modPendaftaran = ARPendaftaranT::model()->findByPK($model->pendaftaran_id);
			$modPasien = ARPasienM::model()->findByPK($model->pasien_id);
			$modPasienAdmisi = ARPasienadmisiT::model()->findByPK($model->pasienadmisi_id);
			$modPasienPulang = ARPasienpulangT::model()->findByPK($model->pasienpulang_id);
			$modPasienMorbiditas = ARPasienmorbiditasT::model()->findAllByAttributes(array('pendaftaran_id'=>$model->pendaftaran_id));
		}
		
		if(isset($_POST['ARInacbgT'])){
			$transaction = Yii::app()->db->beginTransaction();
			try {
				$model->attributes = $_POST['ARInacbgT'];
				$model = $this->simpanInacbg($model,$_POST['ARInacbgT'],$_POST['ARSepT'],$_POST['ARPendaftaranT'],$_POST['ARPasienM'],$_POST['ARPasienadmisiT'],$_POST['ARPasienpulangT']);
				
				if($this->inacbgtersimpan){                        
					$transaction->commit();
					Yii::app()->user->setFlash('success',"Data berhasil disimpan");
					$this->redirect(array('index','inacbg_id'=>$model->inacbg_id,'sukses'=>1));
				} else {
					$transaction->rollback();
					Yii::app()->user->setFlash('error',"Data gagal disimpan ");
				}
			} catch (Exception $ex) {
				$transaction->rollback();
				Yii::app()->user->setFlash('error',"Data gagal disimpan ".MyExceptionMessage::getMessage($ex,true));
			}
		}
		
		$this->render($this->path_view_inacbg.'index',array(
			'model'=>$model,
			'modSEP'=>$modSEP,
			'modPendaftaran'=>$modPendaftaran,
			'modPasien'=>$modPasien,
			'modPasienAdmisi'=>$modPasienAdmisi,
			'modPasienPulang'=>$modPasienPulang,
			'modPasienMorbiditas'=>$modPasienMorbiditas,
			'modInasisCbg'=>$modInasisCbg,
			'modInasisCmg'=>$modInasisCmg
		));
	}	
	
	/**
	* untuk menampilkan data sep dari autocomplete
	* 1. nosep
	*/
	public function actionAutocompleteSEP()
    {
		if(Yii::app()->request->isAjaxRequest) {
			$format = new MyFormatter();
			$returnVal = array();
			$nosep = isset($_GET['nosep']) ? $_GET['nosep'] : null;

			$criteria = new CDbCriteria();
			$criteria->compare('LOWER(nosep)', strtolower($nosep), true);
			$criteria->order = 'nosep';
			$criteria->join = 'JOIN pendaftaran_t ON pendaftaran_t.sep_id = t.sep_id';
			$criteria->limit = 50;
			$models = ARSepT::model()->findAll($criteria);
			foreach($models as $i=>$model)
			{
				$attributes = $model->attributeNames();
				foreach($attributes as $j=>$attribute) {
					$returnVal[$i]["$attribute"] = $model->$attribute;
				}
				$returnVal[$i]['label'] = $model->nosep;
				$returnVal[$i]['value'] = $model->nosep;
			}
			echo CJSON::encode($returnVal);
		}else
			throw new CHttpException(403,'Tidak dapat mengurai data');
		Yii::app()->end();
    }
	
	/**
		* Mengurai data SEP berdasarkan sep_id
		* @throws CHttpException
	*/
	public function actionGetDataSEP()
	{
	   if(Yii::app()->request->isAjaxRequest) {
		   $format = new MyFormatter();
		   $sep_id = isset($_POST['sep_id']) ? $_POST['sep_id'] : null;
		   $returnVal = array();
		   $criteria = new CDbCriteria();
		   if(!empty($sep_id)){$criteria->addCondition("t.sep_id = ".$sep_id); }
		   $criteria->select = 't.*,pendaftaran_t.*,pasien_m.*';
		   $criteria->join = 'JOIN pendaftaran_t ON pendaftaran_t.sep_id = t.sep_id'
				   . ' JOIN pasien_m ON pasien_m.pasien_id = pendaftaran_t.pasien_id';
		   $model = ARSepT::model()->find($criteria);
		   $attributes = $model->attributeNames();
		   foreach($attributes as $j=>$attribute) {
			   $returnVal["$attribute"] = $model->$attribute;
		   }
		   $returnVal["tglsep"] = date("d/m/Y",strtotime($model->tglsep));
		   $returnVal["tglrujukan"] = date("d/m/Y",strtotime($model->tglrujukan));
		   $returnVal["tglpulang"] = date("d/m/Y",strtotime($model->tglpulang));
		   $returnVal["nama_peserta"] = $model->nama_pasien;
		   $returnVal["jeniskelamin"] = $model->jeniskelamin;
		   $returnVal["pendaftaran_id"] = $model->pendaftaran_id;
		   $returnVal["sep_id"] = $model->sep_id;
		   
		   echo CJSON::encode($returnVal);
	   }
	   Yii::app()->end();
	}
	
	public function actionUpdateFinalisasi()
	{
	   if(Yii::app()->request->isAjaxRequest) {
		   $bpjs = new Bpjs();
		   $format = new MyFormatter();
		   $sep_id = isset($_POST['sep_id']) ? $_POST['sep_id'] : null;
		   $pesan = '';
		   $status = '';
		   $returnVal = '';
		   
		   $model = ARSepT::model()->findByPk($sep_id);
		   $reqSep = json_decode($bpjs->create_finalisasi_grouper($model->nosep),true);
		   echo "<pre>";
		   print_r($bpjs->create_finalisasi_grouper($model->nosep));exit;
			if ($reqSep['metadata']['code']==200) {
				$this->bridgingfinalisasiberhasil = true;
				$model->nosep = $reqSep['response'];
				if($this->bridgingfinalisasiberhasil = true){
					$model->pegfinalisasi_id = Yii::app()->user->id;
					$model->tglfinalisasi = date('Y-m-d');
					$model->statusfinalisasi = true;
					$model->ketfinalisasi = '';
					$model->update_time = date('Y-m-d H:i:s');
					$model->update_loginpemakai_id = Yii::app()->user->id;
					$model->update();
					$this->updatefinalisasitesimpan = true;
				}else{
					$this->updatefinalisasitesimpan = false;
				}
			}else{
				$this->bridgingfinalisasiberhasil = false;
			}
			
			if($this->bridgingfinalisasiberhasil == true || $this->updatefinalisasitersimpan == true){
				$pesan = 'berhasil';
				$status = 'Finalisasi berhasil disimpan';
			}else if($this->bridgingfinalisasiberhasil == false){
				$pesan = 'gagal';
				$status = 'Data gagal disimpan karena koneksi server BPJS terputus! Silahkan hubungi admin SIMRS';
			}else{
				$pesan = 'gagal';
				$status = 'Data gagal disimpan';
			}
			
			$returnVal['pesan'] = $pesan;
			$returnVal['status'] = $status;
			echo CJSON::encode($returnVal);
	   }
	   Yii::app()->end();
	}
		
	/**
		* Mengurai data Kunjungan Pasien berdasarkan pendaftaran_id
		* @throws CHttpException
	*/
	public function actionGetDataKunjunganPasien()
	{
	   if(Yii::app()->request->isAjaxRequest) {
		   $format = new MyFormatter();
		   $pendaftaran_id = isset($_POST['pendaftaran_id']) ? $_POST['pendaftaran_id'] : null;
		   $returnVal = array();
		   $tr = array();
		   $criteria = new CDbCriteria();
		   if(!empty($pendaftaran_id)){$criteria->addCondition("t.pendaftaran_id = ".$pendaftaran_id); }
		   $criteria->select = 't.*,pasien_m.*';
		   $criteria->join = 'JOIN pasien_m ON pasien_m.pasien_id = t.pasien_id';
		   $model = ARPendaftaranT::model()->find($criteria);
		   $attributes = $model->attributeNames();
		   foreach($attributes as $j=>$attribute) {
			   $returnVal["$attribute"] = $model->$attribute;
		   }
		   // pencarian data pasien admisi
		   if(!empty($model->pasienadmisi_id)){
			   $modPasienAdmisi = ARPasienadmisiT::model()->findByPk($model->pasienadmisi_id);
		   }
		   // pencarian data pasien pulang
		   if(!empty($model->pasienpulang_id)){
			   $modPasienPulang = ARPasienpulangT::model()->findByPk($model->pasienpulang_id);
		   }
		   // pencarian data morbiditas pasien
		   $pasienMorbiditas = ARPasienmorbiditasT::model()->findAllByAttributes(array('pendaftaran_id'=>$model->pendaftaran_id));
		   foreach($pasienMorbiditas as $i=>$diagnosa){
			   $modPasienMorbiditas = new ARPasienmorbiditasT;
			   $modPasienMorbiditas->pasienmorbiditas_id = $diagnosa->pasienmorbiditas_id;
			   $modPasienMorbiditas->diagnosa_id = isset($diagnosa->diagnosa_id) ? $diagnosa->diagnosa_id : "";
			   $modPasienMorbiditas->diagnosa_kode = isset($diagnosa->diagnosa_id) ? $diagnosa->diagnosa->diagnosa_kode : "";
			   $modPasienMorbiditas->diagnosa_nama = isset($diagnosa->diagnosa_id) ? $diagnosa->diagnosa->diagnosa_nama : "";
			   $modPasienMorbiditas->kelompokdiagnosa_nama = isset($diagnosa->kelompokdiagnosa_id) ? $diagnosa->kelompokdiagnosa->kelompokdiagnosa_nama : "";
			   $modPasienMorbiditas->level = "";
			   $modPasienMorbiditas->checklist=1;
			   $tr .= $this->renderPartial($this->path_view_inacbg.'_rowDiagnosa', array('modPasienMorbiditas'=>$modPasienMorbiditas), true);
		   }
		   // pencarian rincian tagihan pasien
		   $modRincianTagihanPasien = ARRinciantagihanpasienV::model()->findAllByAttributes(array('pendaftaran_id'=>$pendaftaran_id));
		   $total_tagihan = 0;
		   foreach($modRincianTagihanPasien as $a=>$rincian){
			   $total_tagihan = $total_tagihan + $rincian->tarif_tindakan;
		   }
		   $returnVal["pasien_id"] = isset($model->pasien_id) ? $model->pasien_id : "";
		   $returnVal["pasienadmisi_id"] = isset($model->pasienadmisi_id) ? $model->pasienadmisi_id : "";
		   $returnVal["pasienpulang_id"] = isset($model->pasienpulang_id) ? $model->pasienpulang_id : "";
		   $returnVal["tgl_pendaftaran"] = date("d/m/Y",strtotime($model->tgl_pendaftaran));
		   $returnVal["tanggal_lahir"] = date("d/m/Y",strtotime($model->tanggal_lahir));
		   $returnVal["tgladmisi"] = isset($modPasienAdmisi->tgladmisi) ? date("d/m/Y",strtotime($modPasienAdmisi->tgladmisi)) : "";
		   $returnVal["tglpulang"] = isset($modPasienPulang->tglpasienpulang) ? date("d/m/Y",strtotime($modPasienPulang->tglpasienpulang)) : "";
		   $returnVal["nama_pasien"] = $model->nama_pasien;
		   $returnVal["no_rekam_medik"] = $model->no_rekam_medik;
		   $returnVal["jeniskelamin"] = $model->jeniskelamin;
		   $returnVal["instalasi_nama"] = isset($model->instalasi_id) ? $model->instalasi->instalasi_nama : "";
		   $returnVal["ruangan_nama"] = isset($model->ruangan_id) ? $model->ruangan->ruangan_nama : "";
		   $returnVal["ruangan_admisi"] = isset($modPasienAdmisi->ruangan_id) ? $modPasienAdmisi->ruangan->ruangan_nama : "";		   
		   $returnVal["kamarruangan_nama"] = isset($modPasienAdmisi->kamarruangan_id) ? "Kamar : ".$modPasienAdmisi->kamarruangan->kamarruangan_nokamar." No. Bed: ".$modPasienAdmisi->kamarruangan->kamarruangan_nobed : "";
		   $returnVal["kelaspelayanan_nama"] = isset($model->kelaspelayanan_id) ? $model->kelaspelayanan->kelaspelayanan_nama : "";
		   $returnVal["carakeluar_nama"] = isset($modPasienPulang->carakeluar_id) ? $modPasienPulang->carakeluar->carakeluar_nama : "";
		   $returnVal["kondisikeluar_nama"] = isset($modPasienPulang->kondisikeluar_id) ? $modPasienPulang->kondisikeluar->kondisikeluar_nama : "";
		   $returnVal["tarif_tindakan"] = isset($total_tagihan) ? $total_tagihan : 0;
		   $returnVal["tr"] = $tr;
		   
		   echo CJSON::encode($returnVal);
	   }
	   Yii::app()->end();
	}
	
	/**
     * actionPrintRincianTagihanPasien 
     * @params $instalasi_id = RJ / RD / RI
     * @params $pendaftaran_id
     * @params $pasienadmisi_id (RI saja)
     */
    public function actionPrintRincianTagihanPasien(){
		if(Yii::app()->request->isAjaxRequest) {
        $this->layout='//layouts/printWindows';
        if (isset($_POST['frame'])){
            $this->layout='//layouts/iframe';
        }
		$returnVal = null;
        $modRincians = null;
		$instalasi_id = '';
		$pendaftaran_id = isset($_POST['pendaftaran_id']) ? $_POST['pendaftaran_id'] : null;
		$pasienadmisi_id = isset($_POST['pasienadmisi_id']) ? $_POST['pasienadmisi_id'] : null;
		$modPendaftaran = ARPendaftaranT::model()->findByPk($pendaftaran_id);
		if(isset($modPendaftaran)){
			if(!empty($modPendaftaran->instalasi_id)){
				$instalasi_id = $modPendaftaran->instalasi_id;
			}
		}
        if($instalasi_id == Params::INSTALASI_ID_RJ){
            $criteria = new CDbCriteria();
            $criteria->addCondition('pendaftaran_id = '.$pendaftaran_id);
            $criteria->order = 'unitlayanan_nama, tgl_tindakan';
            $modRincians = RincianbelumbayarrjV::model()->findAll($criteria);
			$modPendaftaran=PendaftaranT::model()->findByPk($pendaftaran_id);
        }else if($instalasi_id == Params::INSTALASI_ID_RD){
            $criteria = new CDbCriteria();
            $criteria->addCondition('pendaftaran_id = '.$pendaftaran_id);
            $criteria->order = 'ruangantindakan_id';
            $modRincians = RincianbelumbayarrdV::model()->findAll($criteria);
            $modPendaftaran=PendaftaranT::model()->findByPk($pendaftaran_id);
        }else if($instalasi_id == Params::INSTALASI_ID_RI){
            $criteria = new CDbCriteria();
            $criteria->addCondition('pendaftaran_id = '.$pendaftaran_id);
            $criteria->addCondition('pasienadmisi_id = '.$pasienadmisi_id);
            $criteria->order = 'ruangantindakan_id';
            $modRincians = RincianbelumbayarrawatinapV::model()->findAll($criteria);
			$modPendaftaran=PendaftaranT::model()->findByPk($pendaftaran_id);
        }
		
		echo CJSON::encode(array(
			'rincian'=>$this->renderPartial($this->path_view_billingkasir.'pembayaranTagihanPasien/printRincianBelumBayar', array('modRincians'=>$modRincians,'modPendaftaran'=>$modPendaftaran),true)));
		exit;
	   }
	   Yii::app()->end();
    }
	
	public function simpanInacbg($model,$postInacbg,$postSep,$postPendaftaran,$postPasien,$postPasienAdmisi,$postPasienPulang){
//		echo "<pre>";
//		print_r($postInacbg['totaltarif']);
//		print_r($postSep);
//		print_r($postPendaftaran);
//		print_r($postPasien);
//		print_r($postPasienAdmisi);
//		print_r($postPasienPulang);
//		exit;
		$format = new MyFormatter();
		$model = new ARInacbgT();
		
		$model->attributes = $postInacbg;
		$model->sep_id = $postSep['sep_id'];		
		$model->pasienadmisi_id = $postPasienAdmisi['pasienadmisi_id'];		
		$model->pasien_id = $postPasien['pasien_id'];		
		$model->pasienpulang_id = $postPasienPulang['pasienpulang_id'];		
		$model->pendaftaran_id = $postPendaftaran['pendaftaran_id'];		
		$model->inacbg_tgl = date('Y-m-d');		
		$model->inacbg_deskripsi = '';		
		$model->kodeinacbg = 'AB';		
		$model->inacbg_nosep = $postSep['nosep'];		
		$model->tarifgruper = 0;		
		$model->totaltarif = $postInacbg['totaltarif'];		
		$model->drug_deskripsi = '';		
		$model->drug_kode = '';		
		$model->drug_tarif = 0;		
		$model->investigation_deskripsi = '';		
		$model->investigation_kode = '';		
		$model->investigation_tarif = 0;		
		$model->procedure_deskripsi = '';		
		$model->procedure_kode = '';		
		$model->procedure_tarif = 0;		
		$model->prosthesis_deskripsi = '';		
		$model->prosthesis_kode = '';		
		$model->prosthesis_tarif = 0;	
		$model->subccute_deskripsi = '';
		$model->subccute_kode = '';
		$model->subccute_tarif = 0;
		$model->ruanganakhir_id = Yii::app()->user->getState('ruangan_id');
		$model->pegfinalisasi_id = '';
		$model->tglfinalisasi = null;
		$model->statusfinalisasi = '';
		$model->ketfinalisasi = '';
		$model->create_time = date('Y-m-d H:i:s');
		$model->create_loginpemakai_id = Yii::app()->user->id;
		$model->create_ruangan = Yii::app()->user->getState('ruangan_id');
		
		if($model->save()){
			$this->inacbgtersimpan = true;
		}else{
			$this->inacbgtersimpan = false;
		}
		
		return $model;
	}
	
	public function actionBpjsInterface()
	{
		if(Yii::app()->getRequest()->getIsAjaxRequest()) {
			if(empty( $_GET['param'] ) OR $_GET['param'] === ''){
				die('param can\'not empty value');
			}else{
				$param = $_GET['param'];
			}
 //                if(empty( $_GET['server'] ) OR $_GET['server'] === ''){
 //                    
 //                }else{
 //                    $server = 'http://'.$_GET['server'];
 //                }

			$bpjs = new Bpjs();

			switch ($param) {
				case '1':
					$query = $_GET['query'];
					print_r( $bpjs->search_kartu($query) );
					break;
				case '2':
					$query = $_GET['query'];
					print_r( $bpjs->search_nik($query) );
					break;
				case '3':
					$nokartu = $_GET['nokartu'];
					print_r( $bpjs->riwayat_terakhir($nokartu) );
					break;
				case '4':
					$query = $_GET['query'];
					print_r( $bpjs->search_diagosa($query) );
					break;
				case '5':
					$query = $_GET['query'];
					print_r( $bpjs->search_cbg($query) );
					break;
				case '6':
					$query = $_GET['query'];
					print_r( $bpjs->search_cmg($query) );
					break;
				case '7':
					$query = $_GET['query'];
					print_r( $bpjs->create_grouper($query) );
					break;
				case '99':
					$bpjs->identity_magic();
					break;
				case '100':
					print_r( $bpjs->help() );
					break;
				default:
					die('error number, please check your parameter option');
					break;
			}
			Yii::app()->end();
		}
		
	}
}