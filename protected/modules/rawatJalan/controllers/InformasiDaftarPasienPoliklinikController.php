<?php
class InformasiDaftarPasienPoliklinikController extends MyAuthController
{
	public $defaultAction = 'index';
        
	public function actionIndex()
	{
		$model = new RJInfokunjunganrjV('searchDaftarPasienPoliklinik');
		$model->unsetAttributes();
		$model->tgl_awal = date('d M Y');
		$model->tgl_akhir = date('d M Y');
		if(isset($_GET['RJInfokunjunganrjV'])){
			$model->attributes = $_GET['RJInfokunjunganrjV'];
			$format = new MyFormatter();
			$model->tgl_awal  = $format->formatDateTimeForDb($_GET['RJInfokunjunganrjV']['tgl_awal']);
			$model->tgl_akhir = $format->formatDateTimeForDb($_GET['RJInfokunjunganrjV']['tgl_akhir']);
		}

		if (Yii::app()->request->isAjaxRequest) {
			echo $this->renderPartial('_tablePasien', array('model'=>$model));
		}else{
			$this->render('index',array('model'=>$model));
		}
	}
	
	/**
	* Mengatur dropdown kasus penyakit
	*/
	public function actionSetDropdownKasusPenyakit()
	{
		if(Yii::app()->getRequest()->getIsAjaxRequest()) {
			$pendaftaran_id = isset($_POST['pendaftaran_id']) ? $_POST['pendaftaran_id'] : null;
			$jeniskasuspenyakit_id = isset($_POST['jeniskasuspenyakit_id']) ? $_POST['jeniskasuspenyakit_id'] : null;

			$jeniskasuspenyakit = JeniskasuspenyakitM::model()->findAll('jeniskasuspenyakit_aktif = TRUE');
			$jeniskasuspenyakit = CHtml::listData($jeniskasuspenyakit,'jeniskasuspenyakit_id','jeniskasuspenyakit_nama');
			
			$jeniskasuspenyakitOptions = CHtml::dropDownList('jeniskasuspenyakit_id','', $jeniskasuspenyakit, array("onchange"=>"saveKasusPenyakit(this,$pendaftaran_id)","style"=>"width:140px;","options" => array($jeniskasuspenyakit_id=>array("selected"=>true))));
			
			$dataList['kasusPenyakit'] = $jeniskasuspenyakitOptions;

			echo json_encode($dataList);
			Yii::app()->end();
		}
	}
	/**
	* Mengatur dropdown kasus penyakit
	*/
	public function actionSaveKasusPenyakit()
	{
		if(Yii::app()->getRequest()->getIsAjaxRequest()) {
			$pendaftaran_id = isset($_POST['pendaftaran_id']) ? $_POST['pendaftaran_id'] : null;
			$jeniskasuspenyakit_id = isset($_POST['jeniskasuspenyakit_id']) ? $_POST['jeniskasuspenyakit_id'] : null;
			$pesan = 'gagal';
			
			$update = RJPendaftaranT::model()->updateByPk($pendaftaran_id,array('jeniskasuspenyakit_id'=>$jeniskasuspenyakit_id));
			if($update){
				$pesan = 'berhasil';
			}else{
				$pesan = 'gagal';
			}
			$data['pesan'] = $pesan;

			echo json_encode($data);
			Yii::app()->end();
		}
	}

	
		/**
		 * untuk Ubah Dokter
		 */
		public function actionUbahDokterPeriksa()
		{
			$model = new RJPendaftaranT;
			$menu = (isset($_REQUEST['menu']) ? $_REQUEST['menu'] : "");
			if(isset($_POST['RJPendaftaranT']))
			{
				if($_POST['RJPendaftaranT']['pegawai_id'] != "")
				{
					$model->attributes = $_POST['RJPendaftaranT'];
					$transaction = Yii::app()->db->beginTransaction();
					try {
						$attributes = array('pegawai_id'=>$_POST['RJPendaftaranT']['pegawai_id']);
						$save = $model::model()->updateByPk($_POST['RJPendaftaranT']['pendaftaran_id'], $attributes);
						if($save)
						{
							$transaction->commit();
							echo CJSON::encode(array(
								'status'=>'proses_form', 
								'div'=>"<div class='flash-success'>Berhasil merubah Dokter Periksa.</div>",
								));
						}else{
							echo CJSON::encode(array(
								'status'=>'proses_form', 
								'div'=>"<div class='flash-error'>Data gagal disimpan.</div>",
								));                    
						}
						exit;
					}catch(Exception $exc) {
						$transaction->rollback();
					}                
				}else{
					echo CJSON::encode(
						array(
							'status'=>'proses_form',
							'div'=>"<div class='flash-success'>Berhasil merubah Dokter Periksa.</div>",
						)
					);
					exit;
				}
			}

			if (Yii::app()->request->isAjaxRequest)
			{
				echo CJSON::encode(array(
					'status'=>'create_form', 
					'div'=>$this->renderPartial('_formUbahDokterPeriksa', array('model'=>$model,'menu'=>$menu), true)));
				exit;               
			}
		}
		
		public function actionGetDataPendaftaranRJ()
		{
			if (Yii::app()->request->isAjaxRequest){
				$id_pendaftaran = $_POST['pendaftaran_id'];
				$model = InfokunjunganrjV::model()->findByAttributes(array('pendaftaran_id'=>$id_pendaftaran));
				$attributes = $model->attributeNames();
				foreach($attributes as $j=>$attribute) {
					$returnVal["$attribute"] = $model->$attribute;
					$returnVal["gelarbelakang_nama"] = isset($model->gelarbelakang_nama) ? $model->gelarbelakang_nama : "";
					$returnVal["gelardepan"] = isset($model->gelardepan) ? $model->gelardepan : "";
				}
				echo json_encode($returnVal);
				Yii::app()->end();
			}
		}
		
		public function actionListDokterRuangan()
		{
			if(Yii::app()->getRequest()->getIsAjaxRequest()) {
				if(!empty($_POST['idRuangan'])){
					$idRuangan = $_POST['idRuangan'];
					$data = DokterV::model()->findAllByAttributes(array('ruangan_id'=>$idRuangan),array('order'=>'nama_pegawai'));
					$data = CHtml::listData($data,'pegawai_id','nama_pegawai');

					if(empty($data)){
						$option = CHtml::tag('option',array('value'=>''),CHtml::encode('-- Pilih --'),true);
					}else{
						$option = CHtml::tag('option',array('value'=>''),CHtml::encode('-- Pilih --'),true);
						foreach($data as $value=>$name) {
								$option .= CHtml::tag('option',array('value'=>$value),CHtml::encode($name),true);
						}
					}

					$dataList['listDokter'] = $option;
				} else {
					$dataList['listDokter'] = $option = CHtml::tag('option',array('value'=>''),CHtml::encode('-- Pilih --'),true);
				}

				echo json_encode($dataList);
				Yii::app()->end();
			}
		}

	/**
	 * action ketika tombol panggil di klik
	 */
	public function actionPanggil(){
		if(Yii::app()->request->isAjaxRequest)
		{
			$format = new MyFormatter();
			$data = array();
			$data['pesan']="";
			$pendaftaran_id = ($_POST['pendaftaran_id']);
			$keterangan = (isset($_POST['keterangan']) ? $_POST['keterangan'] : null);
			$modPendaftaran =  PendaftaranT::model()->findByPk($pendaftaran_id);

			$nama_modul = Yii::app()->controller->module->id;
			$nama_controller = Yii::app()->controller->id;
			$nama_action = Yii::app()->controller->action->id;
			$modul_id = ModulK::model()->findByAttributes(array('url_modul'=>$nama_modul))->modul_id;
			$criteria = new CDbCriteria;
			$criteria->compare('modul_id',$modul_id);
			$criteria->compare('LOWER(modcontroller)',strtolower($nama_controller),true);
			$criteria->compare('LOWER(modaction)',strtolower($nama_action),true);
			if(isset($_POST['tujuansms'])){
				$criteria->addInCondition('tujuansms',$_POST['tujuansms']);
			}
			$modSmsgateway = SmsgatewayM::model()->findAll($criteria);
			$data['smspasien'] = 1;
			$data['nama_pasien'] = '';

			if(isset($modPendaftaran)){
				if($modPendaftaran->panggilantrian == true){
					if($keterangan == "batal"){
						$modPendaftaran->panggilantrian = false;
						if($modPendaftaran->update()){

						  $data['pesan'] = "Pemanggilan no. antrian ".$modPendaftaran->no_urutantri." dibatalkan !";
						}
					}else{

						$data['pesan'] = "No. antrian ".$modPendaftaran->no_urutantri." sudah dipanggil sebelumnya !";
					}
					$data['smspasien'] = 1;
				}else{
					$modPendaftaran->panggilantrian = true;
					if($modPendaftaran->update()){
						// SMS GATEWAY
						$modPasien = $modPendaftaran->pasien;
						$sms = new Sms();
						$smspasien = 1;
						foreach ($modSmsgateway as $i => $smsgateway) {
							$isiPesan = $smsgateway->templatesms;

							$attributes = $modPasien->getAttributes();
							foreach($attributes as $attributes => $value){
								$isiPesan = str_replace("{{".$attributes."}}",$value,$isiPesan);
							}
							$attributes = $modPendaftaran->getAttributes();
							foreach($attributes as $attributes => $value){
								$isiPesan = str_replace("{{".$attributes."}}",$value,$isiPesan);
							}

							if($smsgateway->tujuansms == Params::TUJUANSMS_PASIEN && $smsgateway->statussms){
								if(!empty($modPasien->no_mobile_pasien)){
									$sms->kirim($modPasien->no_mobile_pasien,$isiPesan);
								}else{
								  $smspasien = 0;
								}
							}
						}
						// END SMS GATEWAY
						$data['smspasien'] = $smspasien;
						$data['nama_pasien'] = $modPendaftaran->pasien->nama_pasien;
						$data['pesan'] = "No. antrian ".$modPendaftaran->no_urutantri." dipanggil !";
		  // $data_telnet = $modPendaftaran->ruangan->ruangan_nama.", ".$modPendaftaran->ruangan->ruangan_singkatan."-".$modPendaftaran->no_urutantri;
//              AKAN DIGANTI MENGGUNAKAN NODE JS
			// self::postTelnet($data_telnet);
					}
				}
			}
			$attributes = $modPendaftaran->attributeNames();
			foreach($attributes as $i=>$attribute) {
				$data["$attribute"] = $modPendaftaran->$attribute;
			}
			echo CJSON::encode($data);
			Yii::app()->end();
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}
	
	/*
     * Ubah Status Periksa Pasien Baru -- Yang Pake Button
     */
	public function actionUbahStatusPeriksaPasien()
	{
	   $pendaftaran_id = isset($_POST['pendaftaran_id']) ? $_POST['pendaftaran_id'] : null;
	   $status = isset($_POST['status']) ? $_POST['status'] : null;
	   $model = PendaftaranT::model()->findByPk($pendaftaran_id);
	   $modBatalPeriksa = new PasienbatalperiksaR;
	   $model->tglselesaiperiksa = date('Y-m-d H:i:s');       
	   if(isset($_POST['status']))
	   {
			if($status == "ANTRIAN"){
				$update = PendaftaranT::model()->updateByPk($pendaftaran_id,array('statusperiksa'=>Params::STATUSPERIKSA_SEDANG_PERIKSA));
			}else{
			if($status == "SEDANG PERIKSA"){
				$update = PendaftaranT::model()->updateByPk($pendaftaran_id,array('statusperiksa'=>Params::STATUSPERIKSA_SUDAH_DIPERIKSA));
			}else if($status == "SEDANG DIRAWAT INAP"){
				$update = PendaftaranT::model()->updateByPk($pendaftaran_id,array('statusperiksa'=>Params::STATUSPERIKSA_SUDAH_PULANG));
			}
		  }
		  if($update)
		  {
				if (Yii::app()->request->isAjaxRequest)
				{
					echo CJSON::encode(array(
						'status'=>'proses_form', 
						'div'=>"<div class='flash-success'>Data Pasien <b></b> berhasil disimpan </div>",
						));
					exit;               
				}
		  }else{

			   if (Yii::app()->request->isAjaxRequest)
			   {
				   echo CJSON::encode(array(
					   'status'=>'proses_form', 
					   'div'=>"<div class='flash-error'>Data Pasien <b></b> gagal disimpan </div>",
					   ));
				   exit;               
			   }
		   }
	   }
	}
    /*
     * end Ubah Status Periksa Pasien Baru -- Yang Pake Button
     */

}
?>