<?php

class SepController extends MyAuthController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout = '//layouts/column1';
	public $defaultAction = 'admin';
	public $septersimpan = false;
	public $updatesep = false;
	public $deletesep = false;
	public $bridgingsep = true;
	public $bridginglaporansep = true;
	public $laporanseptersimpan = true;

	/**
	 * Menampilkan detail data.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$model = $this->loadModel($id);
		$bpjs = new Bpjs();
		
		$this->render('viewSep',array(
				'model'=>$model,
		));
	}

	/**
	 * Membuat dan menyimpan data baru.
	 */
	public function actionCreate($id = null)
	{
		$status = '';
		$model = new ARSepT;
		$modRujukanBpjs = new ARRujukanbpjsT;
		$modAsuransiPasien = new ARAsuransipasienM;
		$modAsuransiPasienBpjs =new ARAsuransipasienbpjsM;

		if(!empty($id)){
			$model = ARSepT::model()->findByPk($id);
			$modPendaftaran = ARPendaftaranT::model()->findByAttributes(array('sep_id'=>$model->sep_id));
			$modPasien = ARPasienM::model()->findByPk($modPendaftaran->pasien_id);
			$model->nopeserta = $model->nokartuasuransi;
			$model->no_rekam_medik = $modPasien->no_rekam_medik;
			$model->carabayar_id = $modPendaftaran->carabayar_id;
			$model->penjamin_id = $modPendaftaran->penjamin_id;
			$model->kelastanggungan_id = $model->klsrawat;
			$modAsuransiPasienBpjs = ARAsuransipasienbpjsM::model()->findByAttributes(array('nopeserta'=>$model->nokartuasuransi)); 
			$modAsuransiPasien = ARAsuransipasienM::model()->findByAttributes(array('nopeserta'=>$model->nokartuasuransi));
			$modJenisPeserta = ARJenisPesertaM::model()->findByPk($modAsuransiPasienBpjs->jenispeserta_id);
			$modRujukanBpjs->no_rujukan = $model->norujukan;
			$modRujukanBpjs->tanggal_rujukan = $model->tglrujukan;
			
		}
		if(isset($_POST['ARSepT']))
		{
			$transaction = Yii::app()->db->beginTransaction();
            try 
			{
				$model->attributes = $_POST['ARSepT'];
				$model = $this->simpanSep($model,$_POST['ARSepT'],$_POST['ARRujukanbpjsT'],$_POST['ARAsuransipasienM']);
				
				if($model){
					if($this->bridgingsep == false){
						$status = 'Data gagal disimpan karena koneksi server BPJS terputus! Silahkan hubungi admin SIMRS';
					}else if($this->septersimpan == false){
						$status = 'Data gagal disimpan karna kesalahan data / database!';
					}else{
						$status = 'Data SEP berhasil disimpan';
					}
					if($this->septersimpan && $this->bridgingsep){
						$transaction->commit();						
						Yii::app()->user->setFlash('success',$status);
						$this->redirect(array('create','id'=>$model->sep_id,'sukses'=>1));
					}else{
						$transaction->rollback();
						Yii::app()->user->setFlash('error',$status);
					}
				}
			}catch (Exception $e) {
                $transaction->rollback();
                Yii::app()->user->setFlash('error',"Data SEP gagal disimpan ! ".MyExceptionMessage::getMessage($e,true));
            }
		}

		$this->render('create',array(
			'model'=>$model,
			'modRujukanBpjs'=>$modRujukanBpjs,
			'modAsuransiPasien'=>$modAsuransiPasien,
			'modAsuransiPasienBpjs'=>$modAsuransiPasienBpjs
		));
	}

	/**
	 * Memanggil dan Mengubah sebagian data.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$format = new MyFormatter();
		$model = $this->loadModel($id);
		$modRujukanBpjs = new ARRujukanbpjsT;
		$modAsuransiPasien = new ARAsuransipasienM;
		$modAsuransiPasienBpjs =new ARAsuransipasienbpjsM;

		if(!empty($id)){
			$modPendaftaran = ARPendaftaranT::model()->findByAttributes(array('sep_id'=>$model->sep_id));
			if(isset($modPendaftaran)){
				$modPasien = ARPasienM::model()->findByPk($modPendaftaran->pasien_id);
				$model->no_rekam_medik = $modPasien->no_rekam_medik;
				$model->carabayar_id = $modPendaftaran->carabayar_id;
				$model->penjamin_id = $modPendaftaran->penjamin_id;
			}
			$model->nopeserta = $model->nokartuasuransi;			
			$model->kelastanggungan_id = $model->klsrawat;
			$modAsuransiPasienBpjs = ARAsuransipasienbpjsM::model()->findByAttributes(array('nopeserta'=>$model->nokartuasuransi)); 
			$modAsuransiPasien = ARAsuransipasienM::model()->findByAttributes(array('nopeserta'=>$model->nokartuasuransi));
			$modJenisPeserta = ARJenisPesertaM::model()->findByPk($modAsuransiPasienBpjs->jenispeserta_id);
			$modRujukanBpjs->no_rujukan = $model->norujukan;
			$modRujukanBpjs->tanggal_rujukan = $model->tglrujukan;
			
		}
		$bpjs = new Bpjs();
		// Uncomment the following line if AJAX validation is needed
		
		if(isset($_POST['ARSepT']))
		{
			$transaction = Yii::app()->db->beginTransaction();
            try 
			{
				$model->attributes = $_POST['ARSepT'];
				$model->tglpulang = isset($_POST['ARSepT']['tglpulang']) ? $format->formatDateTimeForDb($_POST['ARSepT']['tglpulang']) : null; 
				$reqSep = json_decode($bpjs->update_tanggal_pulang_sep($model->nosep, $model->tglpulang, $model->ppkpelayanan),true);
				if ($reqSep['metadata']['code']==200) {
					$this->bridgingsep = true;
					if($model->save()){
						$this->septersimpan = true;
					}
				}else{
					$this->bridgingsep = false;
				}
				
				if($this->septersimpan && $this->bridgingsep){
					$transaction->commit();
					Yii::app()->user->setFlash('success',"Data SEP berhasil disimpan !");
					$this->redirect(array('admin','id'=>$model->sep_id,'sukses'=>1));
				}else{
					$transaction->rollback();
					Yii::app()->user->setFlash('error',"Data SEP gagal disimpan !");
				}
			}catch (Exception $e) {
                $transaction->rollback();
                Yii::app()->user->setFlash('error',"Data SEP gagal disimpan ! ".MyExceptionMessage::getMessage($e,true));
            }
		}

		$this->render('update',array(
			'model'=>$model,
			'modRujukanBpjs'=>$modRujukanBpjs,
			'modAsuransiPasien'=>$modAsuransiPasien,
			'modAsuransiPasienBpjs'=>$modAsuransiPasienBpjs
		));
	}

	/**
	 * Memanggil dan Menghapus data.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$this->loadModel($id)->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}
	/**
	 * Memanggil dan menonaktifkan status 
	 */
	public function actionNonActive($id)
	{
		if(Yii::app()->request->isAjaxRequest)
		{
			$data['sukses'] = 0;
			$model = $this->loadModel($id);
			// set non-active this
			// example: 
			// $model->modelaktif = false;
			// if($model->save()){
			//	$data['sukses'] = 1;
			// }
			echo CJSON::encode($data); 
		}
	}

	/**
	 * Melihat daftar data.
	 */
	public function actionIndex()
	{
		$dataProvider = new CActiveDataProvider('ARSepT');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Pengaturan data.
	 */
	public function actionAdmin()
	{
		$format = new MyFormatter();
		$model = new ARSepT('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['ARSepT'])){
			$model->attributes = $_GET['ARSepT'];
			$model->tglsep = isset($_GET['ARSepT']['tglsep']) ? $format->formatDateTimeForDb($_GET['ARSepT']['tglsep']) : null;
			$model->tglrujukan = isset($_GET['ARSepT']['tglrujukan']) ? $format->formatDateTimeForDb($_GET['ARSepT']['tglrujukan']) : null; 
		}
		$this->render('admin',array(
				'model'=>$model,
		));
	}

	/**
	 * Memanggil data dari model.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model = ARSepT::model()->findByPk($id);
		if($model===null)
				throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='assep-t-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	/**
	 * Mencetak data
	 */
	public function actionPrint()
	{
		$model = new ARSepT;
		$model->attributes = $_REQUEST['ARSepT'];
		$judulLaporan='Data SEP';
		$caraPrint = $_REQUEST['caraPrint'];
		if($caraPrint=='PRINT') {
			$this->layout = '//layouts/printWindows';
			$this->render('Print',array('model'=>$model,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint));
		}
		else if($caraPrint=='EXCEL') {
			$this->layout = '//layouts/printExcel';
			$this->render('Print',array('model'=>$model,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint));
		}
		else if($_REQUEST['caraPrint']=='PDF') {
			$ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas'); //Ukuran Kertas Pdf
			$posisi = Yii::app()->user->getState('posisi_kertas'); //Posisi L->Landscape,P->Portait
			$mpdf = new MyPDF('',$ukuranKertasPDF); 
			$mpdf->useOddEven = 2;  
			$stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
			$mpdf->WriteHTML($stylesheet,1);  
			$mpdf->AddPage($posisi,'','','','',15,15,15,15,15,15);
			$mpdf->WriteHTML($this->renderPartial('Print',array('model'=>$model,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint),true));
			$mpdf->Output();
		}
	}
	
	/**
	* set bpjs Interface
	*/
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
				   $query = $_GET['query'];
				   print_r( $bpjs->search_rujukan_no_rujukan($query) );
				   break;
			   case '4':
				   $query = $_GET['query'];
				   print_r( $bpjs->search_rujukan_no_bpjs($query) );
				   break;
			   case '5':
				   $query = $_GET['query'];
				   $start = $_GET['start'];
				   $limit = $_GET['limit'];
				   print_r( $bpjs->list_rujukan_tanggal($query, $start, $limit) );
				   break;
			   case '6':
				   $nokartu = $_GET['no_kartu'];
				   $tglsep = $_GET['tgl_sep'];
				   $tglrujukan = $_GET['tgl_rujukan'];
				   $norujukan = $_GET['no_rujukan'];
				   $ppkrujukan = $_GET['ppk_rujukan'];
				   $ppkpelayanan = $_GET['ppk_pelayanan'];
				   $jnspelayanan = $_GET['jns_pelayanan'];
				   $catatan = $_GET['catatan'];
				   $diagawal = $_GET['diag_awal'];
				   $politujuan = $_GET['poli_tujuan'];
				   $klsrawat = $_GET['kls_rawat'];
				   $user = $_GET['user'];
				   $nomr = $_GET['no_mr'];
				   $notrans = $_GET['no_trans'];
				   print_r( $bpjs->create_sep($nokartu, $tglsep, $tglrujukan, $norujukan, $ppkrujukan, $ppkpelayanan, $jnspelayanan, $catatan, $diagawal, $politujuan, $klsrawat, $user, $nomr, $notrans) );
				   break;
			   case '7':
				   $nosep = $_GET['nosep'];
				   $tglpulang = $_GET['tglpulang'];
				   $ppkpelayanan = $_GET['ppkpelayanan'];
				   print_r( $bpjs->update_tanggal_pulang_sep($nosep, $tglpulang, $ppkpelayanan) );
				   break;
			   case '8':
				   $nosep = $_GET['nosep'];
				   $notrans = $_GET['notrans'];
				   $ppkpelayanan = $_GET['ppkpelayanan'];
				   print_r( $bpjs->mapping_trans($nosep, $notrans, $ppkpelayanan) );
				   break;
			   case '9':
				   $nosep = $_GET['nosep'];
				   $ppkpelayanan = $_GET['ppkpelayanan'];
				   print_r( $bpjs->delete_transaksi($nosep, $ppkpelayanan) );
				   break;
			   case '10':
				   $nokartu = $_GET['nokartu'];
				   print_r( $bpjs->riwayat_terakhir($nokartu) );
				   break;
			   case '11':
				   $nosep = $_GET['nosep'];
				   print_r( $bpjs->detail_sep($nosep) );
				   break;
			   case '12':
				   $ppkpelayanan = $_GET['ppkrujukan'];
				   $start = $_GET['start'];
				   $limit = $_GET['limit'];
				   print_r( $bpjs->detail_ppk_rujukan($ppkpelayanan, $start, $limit) );
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
		
	public function actionAutocompleteAsuransi()
    {
		if(Yii::app()->request->isAjaxRequest) {
			$format = new MyFormatter();
			$returnVal = array();
			$nopeserta = isset($_GET['nopeserta']) ? $_GET['nopeserta'] : '';
			$penjamin_id = isset($_GET['penjamin_id']) ? $_GET['penjamin_id'] : null;
			$pasien_id = isset($_GET['pasien_id']) ? $_GET['pasien_id'] : null;
			$criteria = new CDbCriteria();
			$criteria->compare('LOWER(nopeserta)', strtolower($nopeserta),true);
			$criteria->addCondition('penjamin_id='.$penjamin_id);
			$criteria->addCondition('asuransipasien_aktif is true');
			if($_GET['pasien_id'] == ""){
				$criteria->addCondition('pasien_id is null');

			}else{
				$criteria->addCondition('pasien_id='.$pasien_id);
			}
			$criteria->order = 'namapemilikasuransi';
			$criteria->limit = 5;
			$models = ARAsuransipasienM::model()->findAll($criteria);
			foreach($models as $i=>$model)
			{
				$attributes = $model->attributeNames();
				foreach($attributes as $j=>$attribute) {
					$returnVal[$i]["$attribute"] = $model->$attribute;
				}
				$returnVal[$i]['label'] = $model->nopeserta.' - '.$model->namapemilikasuransi;
				$returnVal[$i]['value'] = $model->nopeserta;
				$returnVal[$i]['asuransipasien_id'] = $model->asuransipasien_id;
				$returnVal[$i]['nokartuasuransi'] = $model->nokartuasuransi;
				$returnVal[$i]['namapemilikasuransi'] = $model->namapemilikasuransi;
				$returnVal[$i]['jenispeserta_id'] = $model->jenispeserta_id;
				$returnVal[$i]['nomorpokokperusahaan'] = $model->nomorpokokperusahaan;
				$returnVal[$i]['namaperusahaan'] = $model->namaperusahaan;
				$returnVal[$i]['kelastanggunganasuransi_id'] = $model->kelastanggunganasuransi_id;
			}
			echo CJSON::encode($returnVal);
		}else
			throw new CHttpException(403,'Tidak dapat mengurai data');
		Yii::app()->end();
    }

	public function simpanSep($model,$postSep,$modRujukanBpjs,$modAsuransiPasien){
		$jumlah_diagnosa = count($modRujukanBpjs['diagnosa_rujukan']);
		$diagnosa = '';
		for($i = 0;$i<$jumlah_diagnosa;$i++){
			$diagnosa[$i] = $modRujukanBpjs['diagnosa_rujukan'][$i];
		}
		
		$diagnosa = implode(',', $diagnosa);
		$format = new MyFormatter();
		$reqSep = null;
		$model = new ARSepT;
		$bpjs = new Bpjs();

		$model->attributes = $postSep;
		$model->tglsep = date('Y-m-d H:i:s');
		$model->nokartuasuransi = $postSep['nokartuasuransi'];
		$model->tglrujukan = $format->formatDateTimeForDb($modRujukanBpjs['tanggal_rujukan']);
		$model->norujukan = $modRujukanBpjs['no_rujukan'];
		$model->ppkrujukan = $postSep['ppkrujukan']; 
		$model->ppkpelayanan = Yii::app()->user->getState('ppkpelayanan');
//		$model->jnspelayanan = ($model->instalasi_id==Params::INSTALASI_ID_RI)?Params::JENISPELAYANAN_RI:Params::JENISPELAYANAN_RJ;
		$model->jnspelayanan = $postSep['jnspelayanan'];
		$model->catatansep = $postSep['catatansep'];
//		$data_diagnosa = explode(', ', $modRujukanBpjs['diagnosa_rujukan']);
		$model->diagnosaawal = isset($diagnosa)?$diagnosa:'';
		$model->politujuan = $model->politujuan;
		$criteria = new CDbCriteria();
		$criteria->compare('LOWER(kelaspelayanan_nama)',strtolower($postSep['klsrawat']));
		$kelastanggungan = KelaspelayananM::model()->find($criteria);
		$kelastanggungan = isset($kelastanggungan) ? $kelastanggungan->kelaspelayanan_id : null;
		$model->klsrawat = $kelastanggungan;
		$model->tglpulang = isset($modRujukanBpjs['tanggal_rujukan']) ? $format->formatDateTimeForDb($modRujukanBpjs['tanggal_rujukan']) : date('Y-m-d H:i:s)');
		$model->create_time = date('Y-m-d H:i:s');
		$model->create_loginpemakai_id = Yii::app()->user->id;
		$model->create_ruangan = Yii::app()->user->getState('ruangan_id');
		
		if(isset($_POST['isSepManual'])){
			if($_POST['isSepManual']==false){
			}else{
				$model->nosep = $_POST['ARSepT']['nosep'];
				if($model->save()){
					$modPasien = ARPasienM::model()->findByAttributes(array('no_rekam_medik'=>$postSep['no_rekam_medik']));
					if(isset($modPasien)){
						$pasien_id = $modPasien->pasien_id;
						$modPendaftaran = ARPendaftaranT::model()->findByAttributes(array('pasien_id'=>$pasien_id),array('order'=>'pendaftaran_id DESC'));
						$modPendaftaran->sep_id = $model->sep_id;
						$modPendaftaran->update();
					}
					$this->septersimpan = true;
				}
			}
		}else{
			$reqSep = json_decode($bpjs->create_sep($model->nokartuasuransi, $model->tglsep, $model->tglrujukan, $model->norujukan, $model->ppkrujukan, $model->ppkpelayanan, $model->jnspelayanan, $model->catatansep, $model->diagnosaawal, $model->politujuan, $model->klsrawat, Yii::app()->user->id, $model->no_rekam_medik, $model->pendaftaran_id),true);
			if ($reqSep['metadata']['code']==200) {
				$this->bridgingsep = true;
				$model->nosep = $reqSep['response'];
				if($model->save()){
					$modPasien = ARPasienM::model()->findByAttributes(array('no_rekam_medik'=>$postSep['no_rekam_medik']));
					if(isset($modPasien)){
						$pasien_id = $modPasien->pasien_id;
						$modPendaftaran = ARPendaftaranT::model()->findByAttributes(array('pasien_id'=>$pasien_id),array('order'=>'pendaftaran_id DESC'));
						$modPendaftaran->sep_id = $model->sep_id;
						$modPendaftaran->update();
					}
					$this->septersimpan = true;
				}else{
					$this->septersimpan = false;
				}
			}else{
				$this->bridgingsep = false;
			}
		}
		return $model;
	}
	
	/**
	* untuk menampilkan pasien lama dari autocomplete
	* 1. no_rekam_medik
	*/
	public function actionAutocompletePasien()
    {
		if(Yii::app()->request->isAjaxRequest) {
			$format = new MyFormatter();
			$returnVal = array();
			$no_rekam_medik = isset($_GET['no_rekam_medik']) ? $_GET['no_rekam_medik'] : null;

			$criteria = new CDbCriteria();
			$criteria->compare('LOWER(no_rekam_medik)', strtolower($no_rekam_medik), true);
			$criteria->addCondition('ispasienluar = FALSE');
			$criteria->order = 'no_rekam_medik, nama_pasien';
			$criteria->limit = 50;
			$models = PasienM::model()->findAll($criteria);
			foreach($models as $i=>$model)
			{
				$attributes = $model->attributeNames();
				foreach($attributes as $j=>$attribute) {
					$returnVal[$i]["$attribute"] = $model->$attribute;
				}
				$returnVal[$i]['label'] = $model->no_rekam_medik.' - '.$model->nama_pasien.(!empty($model->nama_bin) ? "(".$model->nama_bin.")" : "")." - ".(!empty($model->nama_ayah) ? $model->nama_ayah : "(nama ayah tidak ada)")." - ".$format->formatDateTimeForUser($model->tanggal_lahir);
				$returnVal[$i]['value'] = $model->no_rekam_medik;
			}
			echo CJSON::encode($returnVal);
		}else
			throw new CHttpException(403,'Tidak dapat mengurai data');
		Yii::app()->end();
    }
	
	/**
	* set dropdown penjamin pasien dari carabayar_id
	* @param type $encode
	* @param type $namaModel
	*/
	public function actionSetDropdownPenjaminPasien($encode=false,$namaModel='')
	{
		if(Yii::app()->request->isAjaxRequest) {
			$carabayar_id = $_POST["$namaModel"]['carabayar_id'];
		   if($encode)
		   {
				echo CJSON::encode($penjamin);
		   } else {
				if(empty($carabayar_id)){
					echo CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
				} else {
					$penjamin = PenjaminpasienM::model()->findAllByAttributes(array('carabayar_id'=>$carabayar_id,'penjamin_aktif'=>true), array('order'=>'penjamin_nama ASC'));
					if(count($penjamin) > 1)
					{
						echo CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
					}
					$penjamin = CHtml::listData($penjamin,'penjamin_id','penjamin_nama');
					foreach($penjamin as $value=>$name) {
						echo CHtml::tag('option', array('value'=>$value),CHtml::encode($name),true);
					}
				}
		   }
		}
		Yii::app()->end();
	}
	
	public function actionGetRujukanDari($encode=false,$namaModel='')
    {
        if(Yii::app()->request->isAjaxRequest) {
            $asalrujukan_id = $_POST["$namaModel"]['asalrujukan_id'];
            
           if($encode) {
                echo CJSON::encode($rujukandari);
           } else {
                if(empty($asalrujukan_id)){
                    echo CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
                } else {
					echo CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
					$rujukandari = RujukandariM::model()->findAllByAttributes(array('asalrujukan_id'=>$asalrujukan_id), array('order'=>'namaperujuk'));
					$rujukandari = CHtml::listData($rujukandari,'rujukandari_id','namaperujuk');
					foreach($rujukandari as $value=>$name) {
						echo CHtml::tag('option', array('value'=>$value),CHtml::encode($name),true);
					}
                        
                }
           }
        }
        Yii::app()->end();
    }
	
	/**
	* @param type $sep_id
	*/
	public function actionPrintSep($sep_id) 
	{
	   $this->layout='//layouts/printWindows';
	   $format = new MyFormatter;
	   $modRujukanBpjs = new ARRujukanbpjsT;
	   $modSep = ARSepT::model()->findByPk($sep_id);
	   $modAsuransiPasienBpjs = ARAsuransipasienbpjsM::model()->findByAttributes(array('nopeserta'=>$modSep->nokartuasuransi)); 
	   $modJenisPeserta = ARJenisPesertaM::model()->findByPk($modAsuransiPasienBpjs->jenispeserta_id);
	   if (isset($modSep->norujukan)) {
		   $modRujukanBpjs = ARRujukanbpjsT::model()->findByAttributes(array('no_rujukan'=>$modSep->norujukan));
	   }
	   $modPendaftaran = ARPendaftaranT::model()->findByAttributes(array('sep_id'=>$modSep->sep_id));
	   $modPasien = ARPasienM::model()->findByPk($modPendaftaran->pasien_id);
	   $judul_print = 'SURAT ELIGIBILITAS PESERTA';
	   $this->render('printSep', array(
			'format'=>$format,
			'modSep'=>$modSep,
			'judul_print'=>$judul_print,
			'modAsuransiPasienBpjs'=>$modAsuransiPasienBpjs,
			'modRujukanBpjs'=>$modRujukanBpjs,
			'modPendaftaran'=>$modPendaftaran,
			'modPasien'=>$modPasien,
			'modJenisPeserta'=>$modJenisPeserta,
	   ));
	} 
	
	/**
	* @param type $sep_id
	*/
	public function actionLihatLaporanSEP($sep_id) 
	{
		$this->layout='//layouts/printWindows';
		if(isset($_GET['frame'])){
			$this->layout = '//layouts/frame';
		}
		
		$format = new MyFormatter;
		$bpjs = new Bpjs();
		$modInacbg = new ARInacbgT();
		$modLaporanSep = new ARLaporansepR();
		$modSep = ARSepT::model()->findByPk($sep_id);
		$modPendaftaran = ARPendaftaranT::model()->findByAttributes(array('sep_id'=>$modSep->sep_id));
		$laporanSep = ARLaporansepR::model()->findByAttributes(array('sep_id'=>$modSep->sep_id));
		if(count($laporanSep) <= 0){
			$reqSep = json_decode($bpjs->create_laporan_sep($modSep->nosep),true);
			 if ($reqSep['metadata']['code']==200) {
				 $this->bridginglaporansep = true;
				 $modLaporanSep->inacbg_id = null;
				 $modLaporanSep->pendaftaran_id = isset($modPendaftaran->pendaftaran_id) ? $modPendaftaran->pendaftaran_id : null;
				 $modLaporanSep->sep_id = $modSep->sep_id;
				 $modLaporanSep->laporansep_tgl = date('Y-m-d');
				 $modLaporanSep->kdinacbg = 'A';
				 $modLaporanSep->kdseverity = 'B';
				 $modLaporanSep->nminacbg = 'C';
				 $modLaporanSep->bytagihan = 0;
				 $modLaporanSep->bytarifgruper = 0;
				 $modLaporanSep->bytarifrs = 0;
				 $modLaporanSep->bytopup = 0;
				 $modLaporanSep->jnspelayanan = $modSep->jnspelayanan;
				 $modLaporanSep->nomr = isset($modPendaftaran->pasien_id) ? $modPendaftaran->pasien->no_rekam_medik : "";
				 $modLaporanSep->nosep = $modSep->nosep;
				 $modLaporanSep->nama = isset($modPendaftaran->pasien_id) ? $modPendaftaran->pasien->nama_pasien : "";
				 $modLaporanSep->nokartu = $modSep->nokartuasuransi;
				 $modLaporanSep->kdstatsep = 'D';
				 $modLaporanSep->nmstatsep = 'E';
				 $modLaporanSep->tglpulang = $modSep->tglpulang;
				 $modLaporanSep->tglsep = $modSep->tglsep;
				 $modLaporanSep->create_time = date('Y-m-d H:i:s');
				 $modLaporanSep->login_pemakai_id = Yii::app()->user->id;
				 $modLaporanSep->create_ruangan = Yii::app()->user->getState('ruangan_id');
				 if($modLaporanSep->save()){
					 $this->laporanseptersimpan = true;
				 }else{
					 $this->laporanseptersimpan = false;
				 }
			 }else{
				 $this->bridgingsep = false;
			 }
		}
		$judulLaporan = 'LAPORAN SEP';

		$this->render('laporanSep', array(
			'format'=>$format,
			'modSep'=>$modSep,
			'laporanSep'=>$laporanSep,
			'judulLaporan'=>$judulLaporan
		));
	} 
	
	/**
	* Ubah Tanggal Pulang
	*/
   
   public function actionUbahTanggalPulang($sep_id){
		$this->layout='//layouts/iframe';
		$format = new MyFormatter();
		$modSep = ARSepT::model()->findByPk($sep_id);
		$bpjs = new Bpjs();
		$status ='';
		if(isset($_POST['ARSepT']))
		{
			$transaction = Yii::app()->db->beginTransaction();
			try 
			{
				$modSep->attributes = $_POST['ARSepT'];
				$modSep->tglpulang = $format->formatDateTimeForDb($_POST['ARSepT']['tglpulang']);
				$attributes = array('tglpulang'=>$modSep->tglpulang);
				$reqSep = json_decode($bpjs->update_tanggal_pulang_sep($modSep->nosep, $modSep->tglpulang, $modSep->ppkpelayanan),true);
				if ($reqSep['metadata']['code']==200) {
					$this->bridgingsep = true;
					if($modSep->update()){
						$this->updatesep = true;
					}
				}else{
					$this->bridgingsep = false;
				}
				
				if($this->bridgingsep == false){
					$status = 'Data gagal diubah karena koneksi server BPJS terputus! Silahkan hubungi admin SIMRS';
				}else if($this->updatesep == false){
					$status = 'Data gagal diubah karna kesalahan data / database!';
				}else{
					$status = 'Data SEP berhasil diubah';
				}
				if($this->updatesep && $this->bridgingsep)
				{
					$transaction->commit();
					Yii::app()->user->setFlash('success', "<strong>Berhasil</strong>".$status);
				}else{
					Yii::app()->user->setFlash('error', '<strong>Gagal</strong>'.$status);
				}
			}catch(Exception $exc) {
				$transaction->rollback();
				Yii::app()->user->setFlash('error', '<strong>Gagal</strong> Data Gagal disimpan'.MyExceptionMessage::getMessage($exc));
			}                  
		}
		
		$this->render('_formUbahTanggal', array(
			'modSep'=>$modSep,
		));            
	}
	
	public function actionGetDataSep()
	{
		if (Yii::app()->request->isAjaxRequest){
			$sep_id = $_POST['sep_id'];
			$model = ARSepT::model()->findByPk($sep_id);
			$attributes = $model->attributeNames();
			foreach($attributes as $j=>$attribute) {
				$returnVal["$attribute"] = $model->$attribute;
				$returnVal["tglpulang"] = (!empty($model->tglpulang) ? date("d/m/Y H:i:s",strtotime($model->tglpulang)) : null);
			}
			echo json_encode($returnVal);
			Yii::app()->end();
		}
	}
	
	/**
	 * Menghapus data SEP
	 */
	public function actionHapusSEP($id)
	{
		if(Yii::app()->request->isAjaxRequest)
		{
			$data['sukses'] = 0;
			$data['status'] = '';
			$model = $this->loadModel($id);
			$bpjs = new Bpjs();
			$reqSep = json_decode($bpjs->delete_transaksi($model->nosep, $model->ppkpelayanan),true);
			if ($reqSep['metadata']['code']==200) {
				$this->bridgingsep = true;
				if($model->delete()){
					$this->deletesep = true;
				}
			}else{
				$this->bridgingsep = false;
			}
			
			if($this->bridgingsep == false){
				$data['status'] = 'Data gagal dihapus karena koneksi server BPJS terputus! Silahkan hubungi admin SIMRS';
			}else if($this->updatesep == false){
				$data['status'] = 'Data gagal dihapus karna kesalahan data / database!';
			}else{
				$data['status'] = 'Data SEP berhasil dihapus';
			}

			echo CJSON::encode($data); 
		}
	}
	
	/**
	 * periksa SEP
	 */
	public function actionPeriksaSEP($id)
	{
		if(Yii::app()->request->isAjaxRequest)
		{
			$data['sukses'] = 0;
			$data['status'] = '';
			$model = $this->loadModel($id);
			$bpjs = new Bpjs();
			$modPendaftaran = ARPendaftaranT::model()->findByAttributes(array('sep_id'=>$model->sep_id));
			if(isset($modPendaftara)){
				$notrans = $modPendaftaran->no_pendaftaran;
			}else{
				$notrans = '';
			}
			$reqSep = json_decode($bpjs->mapping_trans($model->nosep, $notrans, $model->ppkpelayanan),true);
			if ($reqSep['metadata']['code']==200) {
				$this->bridgingsep = true;
			}else{
				$this->bridgingsep = false;
			}
			
			if($this->bridgingsep == false){
				$data['status'] = 'Data gagal dilakukan transaksi mapping karena koneksi server BPJS terputus! Silahkan hubungi admin SIMRS';
			}else{
				$data['status'] = 'Data SEP berhasil dilakukan transaksi maaping';
			}

			echo CJSON::encode($data); 
		}
	}
}
