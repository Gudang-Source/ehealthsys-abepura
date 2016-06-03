<?php
class PengirimanBerkasRekamMedisController extends MyAuthController
{
	public $layout='//layouts/column1';
	public $defaultAction = 'index';
	public $path_view = 'rekamMedis.views.pengirimanBerkasRekamMedis.';
	public $pengirimanberkastersimpan = false;

	public function actionIndex()
	{
		$format = new MyFormatter();
		
		$modDetails = array();
		$model=new RKPengirimanrmT;
		$model->tglpengirimanrm = date('Y-m-d H:i:s');
		$model->petugaspengirim = Yii::app()->user->name;
		
		$modPengiriman=new RKDokumenpasienrmlamaV();
		$modPengiriman->tgl_rekam_medik = date('Y-m-d');
		$modPengiriman->tgl_rekam_medik_akhir = date('Y-m-d');
//		$modPengiriman->unsetAttributes();  // clear any default values
		
		if(isset($_GET['RKDokumenpasienrmlamaV'])){
			$modPengiriman->attributes = $_GET['RKDokumenpasienrmlamaV'];			
			$modPengiriman->tgl_rekam_medik = $format->formatDateTimeForDb($_GET['RKDokumenpasienrmlamaV']['tgl_rekam_medik']);
			$modPengiriman->tgl_rekam_medik_akhir = $format->formatDateTimeForDb($_GET['RKDokumenpasienrmlamaV']['tgl_rekam_medik_akhir']);
		}
		
		
		if(isset($_POST['RKPengirimanrmT']))
		{   
			$transaction = Yii::app()->db->beginTransaction();
			try {
				$model->attributes = $_POST['RKPengirimanrmT'];
				$model->tglpengirimanrm = isset($_POST['RKPengirimanrmT']['tglpengirimanrm']) ? $format->formatDateTimeForDb($_POST['RKPengirimanrmT']['tglpengirimanrm']) : date('Y-m-d H:i:s');
					
				if(count($_POST['Dokumen']) > 0){
					foreach($_POST['Dokumen'] as $i=>$details){
						if(isset($details['cekList'])){
							if($details['cekList'] == 1){
								$modDetails[$i] = $this->simpanPengirimanDokumen($model, $_POST['RKPengirimanrmT'], $details);
							}
						}
					}
				}
                                // die;
				if($this->pengirimanberkastersimpan){
					$transaction->commit();
						$this->redirect(array('index','sukses'=>1));
				}else{
					$transaction->rollback();
					Yii::app()->user->setFlash('error',"Data Pengiriman Dokumen Rekam Medis gagal disimpan !");
				}
			} catch (Exception $exc) {
				$transaction->rollback();
				$btn_ulang = "<a class='btn btn-danger' href='javascript:document.location.reload();' rel='tooltip' title='Klik tombol ini lalu klik \"Resend\" '>"
						. "<i class='icon-refresh icon-white'></i> Simpan Ulang"
						. "</a>";
				Yii::app()->user->setFlash('error',"Data Pengiriman Dokumen Rekam Medis gagal disimpan ! ".$btn_ulang." ".MyExceptionMessage::getMessage($exc,true));
			}
		}
		
		if (empty($models)){
			$models = null;
		}
		
		$this->render($this->path_view.'index',array(
			'model'=>$model,
			'models'=>$models,
			'modPengiriman'=>$modPengiriman,
		));
	}

	/**
	 * proses simpan data pengiriman dokumen
	 * @param type $model
	 * @param type $post
	 * @return type
	 */
	public function simpanPengirimanDokumen($model, $post , $detail){
		$format = new MyFormatter();
		$modPengiriman = new RKPengirimanrmT;
			
		$modPengiriman->attributes = $detail;
               // var_dump($modPengiriman->ruanganpenerima_id[1]);die;
		if ($modPengiriman->kelengkapan == 1){
			$modPengiriman->kelengkapandokumen = true;
		} else {
			$modPengiriman->kelengkapandokumen = false;
		}   
                $modPengiriman->petugaspengirim = Yii::app()->user->name;
		$modPengiriman->pasien_id = $modPengiriman->pasien_id;
		$modPengiriman->pendaftaran_id = $modPengiriman->pendaftaran_id;
		$modPengiriman->dokrekammedis_id = $modPengiriman->dokrekammedis_id;
		$modPengiriman->ruangan_id = $modPengiriman->ruangan_id;
		$modPengiriman->nourut_keluar = MyGenerator::noUrutKeluarRM();
		$modPengiriman->ruanganpengirim_id = Yii::app()->user->getState('ruangan_id');
                $modPengiriman->ruanganpenerima_id = $modPengiriman->ruangan_id;
		$modPengiriman->peminjamanrm_id = $modPengiriman->peminjamanrm_id;
		$modPengiriman->create_ruangan = Yii::app()->user->getState('ruangan_id');
		$modPengiriman->tglpengirimanrm = MyFormatter::formatDateTimeForDb($model->tglpengirimanrm);
		$modPengiriman->create_time = date('Y-m-d H:i:s');
		$modPengiriman->update_time = date('Y-m-d H:i:s');
		$modPengiriman->create_loginpemakai_id = Yii::app()->user->id;
		$modPengiriman->update_loginpemakai_id = Yii::app()->user->id;

                // var_dump($modPengiriman->attributes); die;
                
		if($modPengiriman->validate()){
			$modPengiriman->save();
			PendaftaranT::model()->updateByPK($modPengiriman->pendaftaran_id, array('pengirimanrm_id'=>$modPengiriman->pengirimanrm_id));
			PeminjamanrmT::model()->updateByPk($modPengiriman->peminjamanrm_id, array('pengirimanrm_id'=>$modPengiriman->pengirimanrm_id));
			$this->pengirimanberkastersimpan = true;
		}
		
		return $modPengiriman;
	}
	
	public function actionInformasi()
	{
		$format = new MyFormatter();
		$model=new InformasipengirimanrmV('search');
		$model->unsetAttributes();
		$model->tgl_awal = date('Y-m-d');
		$model->tgl_akhir = date('Y-m-d');
		if(isset($_GET['InformasipengirimanrmV'])){ 
			$model->attributes = $_GET['InformasipengirimanrmV'];
			$model->tgl_awal  = $format->formatDateTimeForDb($_GET['InformasipengirimanrmV']['tgl_awal']);
			$model->tgl_akhir = $format->formatDateTimeForDb($_GET['InformasipengirimanrmV']['tgl_akhir']);   
		}
		$this->render($this->path_view.'informasi',array(
				'model'=>$model,
		));
	}
	
	public function actionGetPetugasPengirim()
	{
		if(Yii::app()->request->isAjaxRequest) {
			$criteria = new CDbCriteria();
			$criteria->compare('LOWER(nama_pegawai)', strtolower($_GET['term']), true);
			$criteria->addCondition('pegawai_aktif is true');
			$criteria->order = 'nama_pegawai';
			$models = PegawaiV::model()->findAll($criteria);
			foreach($models as $i=>$model)
			{
				$attributes = $model->attributeNames();
				foreach($attributes as $j=>$attribute) {
					$returnVal[$i]["$attribute"] = $model->$attribute;
				}
				$returnVal[$i]['label'] = $model->nama_pegawai;
				$returnVal[$i]['value'] = $model->nama_pegawai;
			}

			echo CJSON::encode($returnVal);
		}
		Yii::app()->end();
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='rkpengirimanrm-t-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
        
        
	public function actionGetRuanganTujuanForCheckBox($encode=false,$namaModel='')
	{
		if(Yii::app()->request->isAjaxRequest) {
		   $instalasi_id = $_POST["$namaModel"]['instalasitujuan_id'];

		   if($encode) {
				echo CJSON::encode($ruangan);
		   } else {
				if(empty($instalasi_id)){
				} else {
					$ruangan = RuanganM::model()->findAll('instalasi_id='.$instalasi_id.'');
				}
				$ruangan = CHtml::listData($ruangan,'ruangan_id','ruangan_nama');
				echo CHtml::hiddenField(''.$namaModel.'[ruangan_id]');
				$i = 0;
				if (count($ruangan) > 0){
					foreach($ruangan as $value=>$name) {
						$selects[] = $value;
						$i++;
					}
					echo CHtml::checkBoxList(''.$namaModel."[ruangantujuan_id]", $selects, $ruangan);
				}
				else{
					echo '<label>Data Tidak Ditemukan</label>';
				}
		   }
		}
		Yii::app()->end();
	}

	public function actionGetRuanganPasien()
	{
		if (Yii::app()->getRequest()->getIsAjaxRequest())
		{
			$instalasi_id= isset($_POST['instalasi_id']) ? $_POST['instalasi_id'] : null;
			$dropDown = '';
			$dataRuangan =RuanganM::model()->findAll('instalasi_id='.$instalasi_id.' AND ruangan_aktif=TRUE ORDER BY ruangan_nama');
                        $total = count($dataRuangan);
			foreach ($dataRuangan AS $tampilRuangan)
			{
				$dropDown .='<option value="'.$tampilRuangan['ruangan_id'].'">'.$tampilRuangan['ruangan_nama'].'</option>';

			}

			$data['dropDown']=$dropDown;    
                        $data['total']=$total;
			echo json_encode($data);
			Yii::app()->end();    
		}
	}
	
	public function actionPrint()
	{
		$model= new RKDokumenpasienrmlamaV();
		if(isset($_REQUEST['RKDokumenpasienrmlamaV'])){
			$model->attributes=$_REQUEST['RKDokumenpasienrmlamaV'];      
			$model->pendaftaran_id = explode(',',$_REQUEST['RKDokumenpasienrmlamaV']['printArray']);
		}
		

		$judulLaporan='Data Dokumen Rekam Medis';
		$caraPrint=$_REQUEST['caraPrint'];
		if($caraPrint=='PRINT') {
			$this->layout='//layouts/printWindows';
			$this->render('Print',array('model'=>$model,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint));
		}
		else if($caraPrint=='EXCEL') {
			$this->layout='//layouts/printExcel';
			$this->render('Print',array('model'=>$model,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint));
		}
		else if($_REQUEST['caraPrint']=='PDF') {
			$ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
			$posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
			$mpdf = new MyPDF('',$ukuranKertasPDF); 
			$mpdf->useOddEven = 2;  
			$stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
			$mpdf->WriteHTML($stylesheet,1);  
			$mpdf->AddPage($posisi,'','','','',15,15,15,15,15,15);
			$mpdf->WriteHTML($this->renderPartial('Print',array('model'=>$model,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint),true));
			$mpdf->Output();
		}                       

		$this->updatePrint($model->pendaftaran_id);
	}
	
	protected function updatePrint($data = null){
		if (isset($data)){
			$jumlah = count($data);
			for($i=0;$i<$jumlah;$i++){
				RKPeminjamanrmT::model()->updateAll(array('printpeminjaman'=>TRUE), 'pendaftaran_id = '.$data[$i]);
			}
		}
	}
}
