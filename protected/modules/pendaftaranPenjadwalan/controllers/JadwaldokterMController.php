<?php

class JadwaldokterMController extends MyAuthController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column1';
	public $defaultAction = 'penjadwalan';
	public $path_view = 'pendaftaranPenjadwalan.views.jadwaldokterM.';

	

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render($this->path_view.'view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
                //if(!Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
		$model=new PPJadwaldokterM;
                $listHari = array( 'Senin'=> 'Senin',
                                   'Selasa'=> 'Selasa',
                                   'Rabu'=> 'Rabu',
                                   'Kamis'=> 'Kamis',
                                   'Jumat'=> 'Jumat',
                                   'Sabtu'=> 'Sabtu',
                                   'Minggu'=> 'Minggu',
                                );

		// Uncomment the following line if AJAX validation is needed
		

		if(isset($_POST['PPJadwaldokterM']))
		{
			$model->attributes=$_POST['PPJadwaldokterM'];
			$model->jadwaldokter_buka = $model->jadwaldokter_mulai.' S/d '.$model->jadwaldokter_tutup;
			if($model->save()){
                                Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
				$this->redirect(array('admin','id'=>$model->jadwaldokter_id,'sukses'=>1));
                        }
		}

		$this->render($this->path_view.'create',array(
			'model'=>$model,
                        'listHari'=>$listHari
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
                //if(!Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
		$model=$this->loadModel($id);
                $listHari = array( 'Senin'=> 'Senin',
                                   'Selasa'=> 'Selasa',
                                   'Rabu'=> 'Rabu',
                                   'Kamis'=> 'Kamis',
                                   'Jumat'=> 'Jumat',
                                   'Sabtu'=> 'Sabtu',
                                   'Minggu'=> 'Minggu',
                                );

		// Uncomment the following line if AJAX validation is needed
		

		if(isset($_POST['PPJadwaldokterM']))
		{
			$model->attributes=$_POST['PPJadwaldokterM'];
                        $model->jadwaldokter_buka = $model->jadwaldokter_mulai.' S/d '.$model->jadwaldokter_tutup;
			if($model->save()){
                                Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
				$this->redirect(array('admin','id'=>$model->jadwaldokter_id,'sukses'=>1));
                        }
		}

		$this->render($this->path_view.'update',array(
			'model'=>$model,
                        'listHari'=>$listHari
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
                        //if(!Yii::app()->user->checkAccess(Params::DEFAULT_DELETE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
			$this->loadModel($id)->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('PPJadwaldokterM');
		$this->render($this->path_view.'index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin($sukses='')
	{
            if ($sukses == 1){
                Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
            }
                
		$model=new PPJadwaldokterM('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['PPJadwaldokterM'])){
			$model->attributes=$_GET['PPJadwaldokterM'];
                        $model->bulan = $_GET['PPJadwaldokterM']['bulan'];
                }

		$this->render($this->path_view.'admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=PPJadwaldokterM::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='rdjadwaldokter-m-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
        
        /**
         *Mengubah status aktif
         * @param type $id 
         */
        public function actionRemoveTemporary($id)
	{
                //if(!Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
                //SAKabupatenM::model()->updateByPk($id, array('kabupaten_aktif'=>false));
                //$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}
        
        public function actionPrint()
        {
            // $model= new PPJadwaldokterM;
            // $model->attributes=$_REQUEST['PPJadwaldokterM'];
            $model=new PPJadwaldokterM('search');
            $model->unsetAttributes();  // clear any default values
            if(isset($_GET['PPJadwaldokterM'])){
                $model->attributes=$_GET['PPJadwaldokterM'];
            }
            $judulLaporan='Data PPJadwaldokterM';
            $caraPrint=$_REQUEST['caraPrint'];
            if($caraPrint=='PRINT') {
                $this->layout='//layouts/printWindows';
                $this->render($this->path_view.'Print',array('model'=>$model,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint));
            }
            else if($caraPrint=='EXCEL') {
                $this->layout='//layouts/printExcel';
                $this->render($this->path_view.'Print',array('model'=>$model,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint));
            }
            else if($_REQUEST['caraPrint']=='PDF') {
                $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
                $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
                $mpdf = new MyPDF('',$ukuranKertasPDF); 
                $mpdf->useOddEven = 2;  
                $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
                $mpdf->WriteHTML($stylesheet,1);  
                $mpdf->AddPage($posisi,'','','','',15,15,15,15,15,15);
                $mpdf->WriteHTML($this->renderPartial($this->path_view.'Print',array('model'=>$model,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint),true));
                $mpdf->Output();
            }                       
        }
        
        public function actionPenjadwalan()
        {
            $model = new JadwaldokterM();
            if(Yii::app()->getRequest()->getIsAjaxRequest()){
                $jadwal = $_POST['jadwalDokter'];
                $error = array();
                $error2 = array();
                $data = array();
                $allError = true;
                $error2[0] = '';
                $jumlahDokter = 0;
                foreach ($jadwal as $key => $value) {
                    if (empty($jadwal[$key])){
                        $error2[] = 'jadwalDokter['.$key.']';
                        $allError = false;
                    }
                }
                $dokter = null;
                if (count($jadwal['jadwal'])>0){
                    unset($error2[0]);
                    foreach ($jadwal['jadwal'] as $key => $value) {
                        foreach ($value['dokter'] as $i => $row) {
                            if (isset($row['cek']) && $row['cek'] == 1){
                                if (isset($row['dokter']) && count($row['dokter']) > 0){
                                    foreach ($row['dokter'] as $j => $row2) {
                                        $jadwalDokter = new JadwaldokterM();
                                        $jadwalDokter->attributes = $row2;
                                        $jadwalDokter->instalasi_id = (isset($_POST['jadwalDokter']['instalasi_id']) ? $_POST['jadwalDokter']['instalasi_id'] : null);
                                        $jadwalDokter->jadwaldokter_hari = $value['jadwaldokter_hari'];
                                        $jadwalDokter->jadwaldokter_tgl = $value['jadwaldokter_tgl'];
                                        $jadwalDokter->jadwaldokter_buka = $row2['jadwaldokter_mulai'].' s/d '.$row2['jadwaldokter_tutup'];
                                        $jadwalDokter->ruangan_id = $row['ruangan_id'];
                                        $jadwalDokter->instalasi_id = $jadwal['instalasi'];
                                        if (!$jadwalDokter->validate()){
                                            $allError = false;
                                            foreach ($jadwalDokter->getErrors() as $x => $y) {
                                                $error['jadwalDokter[jadwal]['.$key.'][dokter]['.$jadwalDokter->ruangan_id.'][dokter]['.$j.']['.$x.']'] = $y;
                                            }
                                        }else{
                                            $jumlahDokter += count($row['dokter']);
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
                if (count($jadwal['jadwal']) ==0 || $jumlahDokter == 0 ){
                    $error2[0] = 'Jadwal Dokter Detail Tidak Boleh Kosong.';
                    $allError = false;
                }
                $data['error']=($allError)?'no':$error;
                $data['error2']= $error2;
                echo json_encode($data);
                Yii::app()->end(); 
            }
            
            if (isset($_POST['jadwalDokter'])){
                $jadwal = $_POST['jadwalDokter'];
            
                $transaction = Yii::app()->db->beginTransaction();
                try {
                    $return = true;
                    $jumlah = 0;
                    $listUpdate = array();           
                    if (isset($jadwal['jadwal']) == 0){  
                        
                        Yii::app()->user->setFlash('error', '<strong>Gagal!</strong> Data gagal disimpan.');
                    }else{
                   
                    if ((count($jadwal['jadwal'])) > 0){
                        foreach ($jadwal['jadwal'] as $key => $value) {
                            foreach ($value['dokter'] as $i => $row) {
                                if (isset($row['cek']) && $row['cek'] == 1){
                                    if (isset($row['dokter']) && count($row['dokter']) > 0){
                                        foreach ($row['dokter'] as $j => $row2) {
                                            if (!empty($row2['jadwaldokter_id'])){
                                                $jadwalDokter = JadwaldokterM::model()->findByPk($row2['jadwaldokter_id']);
                                                $jadwalDokter->attributes = $row2;
                                                $jadwalDokter->instalasi_id = (isset($_POST['jadwalDokter']['instalasi_id']) ? $_POST['jadwalDokter']['instalasi_id'] : null);
                                                $jadwalDokter->jadwaldokter_hari = $value['jadwaldokter_hari'];
                                                $jadwalDokter->jadwaldokter_tgl = $value['jadwaldokter_tgl'];
                                                $jadwalDokter->jadwaldokter_buka = $row2['jadwaldokter_mulai'].' s/d '.$row2['jadwaldokter_tutup'];
                                                $jadwalDokter->ruangan_id = $row['ruangan_id'];
                                                $jadwalDokter->instalasi_id = $jadwal['instalasi'];
                                                if ($jadwalDokter->validate()){
                                                    if (!$jadwalDokter->save()){
                                                        $return = false;
                                                    }else{
                                                        $listUpdate[] = $jadwalDokter->jadwaldokter_id;
                                                        $jumlah ++;
                                                    }
                                                }
                                            }else{
                                                $jadwalDokter = new JadwaldokterM();
                                                $jadwalDokter->attributes = $row2;
                                                $jadwalDokter->instalasi_id = (isset($_POST['jadwalDokter']['instalasi_id']) ? $_POST['jadwalDokter']['instalasi_id'] : null);
                                                $jadwalDokter->jadwaldokter_hari = $value['jadwaldokter_hari'];
                                                $jadwalDokter->jadwaldokter_tgl = $value['jadwaldokter_tgl'];
                                                $jadwalDokter->jadwaldokter_buka = $row2['jadwaldokter_mulai'].' s/d '.$row2['jadwaldokter_tutup'];
                                                $jadwalDokter->ruangan_id = $row['ruangan_id'];
                                                $jadwalDokter->instalasi_id = $jadwal['instalasi'];
                                                if ($jadwalDokter->validate()){
                                                    if (!$jadwalDokter->save()){
                                                        $return = false;
                                                    }else{
                                                        $listUpdate[] = $jadwalDokter->jadwaldokter_id;
                                                        $jumlah ++;
                                                    }
                                                }
                                            }
                                            
                                        }
                                    }
                                }
                            }
                        }
                    }
                    $criteria = new CDbCriteria();
                    $criteria->addNotInCondition('jadwaldokter_id', $listUpdate);
                    $criteria->addBetweenCondition('jadwaldokter_tgl',$jadwal['txtStartDate'],$jadwal['txtEndDate']);
                    $criteria->addCondition('instalasi_id = '.$jadwal['instalasi']);
                    //JadwaldokterM::model()->deleteAll($criteria);
                    if ($jumlah > 0 && ($return)){
                        $transaction->commit();
                        Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
                        $this->redirect(array('admin','sukses'=>1));
                        //$this->refresh();
                    }
                    else{
                        $transaction->rollback();
                        Yii::app()->user->setFlash('error', '<strong>Gagal!</strong> Data gagal disimpan.');
                    }
                        $transaction->rollback();
                        Yii::app()->user->setFlash('error', '<strong>Gagal!</strong> Data gagal disimpan.');
                    }
                } catch (Exception $exc) {
                    $transaction->rollback();
                    Yii::app()->user->setFlash('error', '<strong>Gagal!</strong> Data gagal disimpan.', MyExceptionMessage::getMessage($exc));
                
                }
            }
            $this->render($this->path_view.'penjadwalan', array('model'=>$model));
        }
        
        public function actionAjaxListPoli()
        {
            if(Yii::app()->request->isAjaxRequest) {
                $instalasi = $_POST['jadwalDokter']['instalasi'];
                $criteria = new CDbCriteria;
				if(!empty($instalasi)){ $criteria->addCondition("instalasi_id = ".$instalasi); }
                $criteria->addCondition('ruangan_aktif = TRUE');
                
                $polis = RuanganM::model()->findAll($criteria);
//                echo CHtml::checkBoxList($name, $select, $data);
                echo CHtml::checkBox('pilih_semua_poli',true,array('onclick'=>'pilihSemua(this);'))."<label class='checkbox'>Pilih Semua</label><br/>";
                echo CHtml::checkBoxList('jadwalDokter[poliklinik]', CHtml::listData($polis, 'ruangan_id', 'ruangan_id'), CHtml::listData($polis, 'ruangan_id', 'ruangan_nama'), array('template'=>'<label class="checkbox">{input} {label}</label>','separator'=>''));
            }
        }
        
        public function actionAjaxGenerateInputForm()
        {
            if(Yii::app()->request->isAjaxRequest) {
                $periodeAwal = $_POST['jadwalDokter']['txtStartDate'];
                $periodeAkhir = $_POST['jadwalDokter']['txtEndDate'];
                $instalasi = $_POST['jadwalDokter']['instalasi'];
                $poli = $_POST['jadwalDokter']['poliklinik'];
                                
                $startTimeStamp = strtotime($periodeAwal);
                $endTimeStamp = strtotime($periodeAkhir);
                $timeDiff = $endTimeStamp - $startTimeStamp;

                $jumlahHari = $timeDiff/86400;  // 86400 seconds in one day

                // and you might want to convert to integer
                $jumlahHari = intval($jumlahHari) + 1;
                                
                $poliklinik = RuanganM::model()->findAllByAttributes(array('ruangan_id'=>$poli));
                $form = '';
                $submit = '';
                $data = array();
                for($i=0;$i<$jumlahHari;$i++){
                    $form .= $this->renderPartial($this->path_view.'formJadwalHari',array('i'=>$i,
                                                                                'startTimeStamp'=>$startTimeStamp,
                                                                                'endTimeStamp'=>$endTimeStamp,
                                                                                'poli_id'=>$poli,
                                                                                'poliklinik'=>$poliklinik),true);
                }
                $submit = CHtml::htmlButton(Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
                                                array('class'=>'btn btn-primary', 'type'=>'button', 'onClick'=>'clientValidationFunc(this);')); 
                $batal = CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                            Yii::app()->createUrl($this->module->id.'/jadwaldokterM/penjadwalan'), 
                                array('class'=>'btn btn-danger'));
                $data['form'] = $form;
                $data['submit'] = $submit;
                $data['batal'] = $batal;
                echo json_encode($data);
                
            }
        }
        
        public function actionAjaxListDokter()
        {
            if(Yii::app()->request->isAjaxRequest) {
                $ruangan_id = (isset($_POST['idRuangan']) ? $_POST['idRuangan'] : null);
                $criteria = new CDbCriteria;
				if(!empty($ruangan_id)){ $criteria->addCondition("ruangan_id = ".$ruangan_id); }
                
                $dokters = DokterV::model()->findAll($criteria);
                $data=array();
                $data['options'] = null;
                foreach($dokters as $dokter)
                {
                    $dokter_id = (isset($dokter->pegawai_id) ? $dokter->pegawai_id : null);
                    $dokter_nama = (isset($dokter->nama_pegawai) ? $dokter->namaLengkap : null);
                    $data['options'] .= CHtml::tag('option',array('value'=>$dokter_id),CHtml::encode($dokter_nama),true);
                }

                $data['ruangan_id'] = $ruangan_id;
                echo json_encode($data);
                Yii::app()->end();
            }
        }
}
