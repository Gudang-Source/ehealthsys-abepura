<?php

class SuratKeteranganController extends MyAuthController
{
    public $layout='//layouts/column1';
    public $defaultAction = 'Index';
    public $path_view = 'rekamMedis.views.suratKeterangan.';

	
    public function actionIndex()
    {
        $modJenisSurat=new RKJenisSuratM;
        $model = new RKSuratketeranganR;
        $modPendaftaran = new RKPendaftaranT;
        $modPasien = new RKPasienM;       

        if(isset($_POST['RKSuratketeranganR']))
        {
                $model->attributes=$_POST['RKSuratketeranganR'];
                if($model->save()){
                        Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
                        $this->redirect(array('index','id'=>$model->suratketerangan_id));
                }
        }

        $this->render($this->path_view.'index',array(
                'model'=>$model,
                'modJenisSurat'=>$modJenisSurat,
                'modPendaftaran'=>$modPendaftaran,
                'modPasien'=>$modPasien
        ));
    }

    // Tabular : Istirahat 
    public function actionIstirahat($pendaftaran_id = null){
        $this->layout = '//layouts/iframe';

        $format = new MyFormatter();
        $model = new RKSuratketeranganR;
        $modPasien = new RKPasienM;
        $modPendaftaran = new RKPendaftaranT;
        $model->nomorsurat = MyGenerator::noSurat(1);

        if(isset($_POST['RKSuratketeranganR']))
        {
            $pendaftaran_id = $_GET['pendaftaran_id'];
            $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
            $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
            $transaction = Yii::app()->db->beginTransaction();
            try {
                $model->attributes=$_POST['RKSuratketeranganR'];  
                $model->tglsurat= date('Y-m-d');
                $model->jenissurat_id = 1;
                $model->nourutsurat = 1;
                $model->pendaftaran_id = $pendaftaran_id;
                $model->pasien_id = $modPasien->pasien_id;
                $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
                $model->jmlprint_surat = 1;
                $model->mengetahui_surat = $_POST['RKSuratketeranganR']['mengetahui_surat'];
                $model->profilrs_id = 1;
                $model->judulsurat = "SURAT KETERANGAN ISTIRAHAT";
                $model->lamaistirahat = $_POST['RKSuratketeranganR']['lamaistirahat'];  
                $model->tglistirahat = $format->formatDateTimeForDb($_POST['RKSuratketeranganR']['tglistirahat']);

                $model->create_time = date('Y-m-d');
                $model->update_time = date('Y-m-d');
                $model->create_loginpemakai_id = Yii::app()->user->id;
                $model->update_loginpemakai_id = Yii::app()->user->id;
                $model->create_ruangan = Yii::app()->user->getState('ruangan_id');

                if($model->validate()){
                   if($model->save()){
                      $transaction->commit();
                      $model->isNewRecord = FALSE;
                      if(!empty($_GET['pendaftaran_id'])){
                          $model->suratketerangan_id = $model->suratketerangan_id;
                      }
                   }else{
                       echo "gagal Simpan";exit;
                   } 

                    Yii::app()->user->setFlash('success',"Surat Keterangan Istirahat berhasil disimpan");
                    $this->redirect(array('Istirahat','pendaftaran_id'=>$pendaftaran_id,
                                            'suratketerangan_id'=>$model->suratketerangan_id,'lama_hari'=>$_POST['RKSuratketeranganR']['lamaistirahat'])); 
                }  
            }
            catch (Exception $exc) 
            {
                $transaction->rollback();
                Yii::app()->user->setFlash('error',"Surat Keterangan Istirahat gagal disimpan ");
            }
        } 
        $this->render($this->path_view.'istirahat/index',array(
                'model'=>$model,
                'modPasien'=>$modPasien,
                'modPendaftaran'=>$modPendaftaran,
        ));
    }

    public function actionPrintIstirahat($pendaftaran_id = null,$suratketerangan_id = null,$lama_hari = null){
        $this->layout = '//layouts/iframe';

        $modPendaftaran = RKPendaftaranT::model()->findByPk($pendaftaran_id);
        $modPasien = RKPasienM::model()->findByPk($modPendaftaran->pasien_id);
        $model = RKSuratketeranganR::model()->findByPk($suratketerangan_id);           

        $judulLaporan = '';

        $caraPrint=$_REQUEST['caraPrint'];
        if($caraPrint=='PRINT') {
            $this->layout='//layouts/printWindows';
        }
        $this->render($this->path_view.'istirahat/printSuratIstirahat',array(
                'modPendaftaran'=>$modPendaftaran, 
                'modPasien'=>$modPasien,
                'model'=>$model, 
                'judulLaporan'=>$judulLaporan,
                'caraPrint'=>$caraPrint));
    }
    // end Tabular Istirahat
        
    // Tabular : Opname (Sudah Pulang)
    public function actionOpnameSP($pendaftaran_id = null){
        $this->layout='//layouts/iframe';

        $format = new MyFormatter();
        $model = new RKSuratketeranganR;
        $modPasien = new RKPasienM;
        $modPendaftaran = new RKPendaftaranT;
        $modAdmisi = new PasienadmisiT;

        $model->nomorsurat = MyGenerator::noSurat(1);
        $modAdmisi->tgladmisi = date("Y-m-d")." 00:00:00";
        $modAdmisi->tglpulang = date("Y-m-d")." 00:00:00";

        if(isset($_POST['RKSuratketeranganR']))
        {
            $pendaftaran_id = $_GET['pendaftaran_id'];
            $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
            $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
            $modAdmisi = PasienadmisiT::model()->findByPk($modPendaftaran->pasienadmisi_id);
            $transaction = Yii::app()->db->beginTransaction();
            try {
                $model->attributes=$_POST['RKSuratketeranganR']; 
                $model->tglsurat=date('Y-m-d');
                $model->jenissurat_id = 1;
                $model->nourutsurat = 1;
                $model->pendaftaran_id = $pendaftaran_id;
                $model->pasien_id = $modPasien->pasien_id;
                $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
                $model->jmlprint_surat = 1;
                $model->mengetahui_surat = $_POST['RKSuratketeranganR']['mengetahui_surat'];
                $model->profilrs_id = 1;
                $model->judulsurat = "SURAT KETERANGAN OPNAME (SUDAH PULANG)";

                $model->create_time = date('Y-m-d');
                $model->update_time = date('Y-m-d');
                $model->create_loginpemakai_id = Yii::app()->user->id;
                $model->update_loginpemakai_id = Yii::app()->user->id;
                $model->create_ruangan = Yii::app()->user->getState('ruangan_id');

//                    echo "<pre>";
//                    echo print_r($model->getAttributes());exit;
                if($model->validate()){
                   if($model->save()){
                      $transaction->commit();
                      $model->isNewRecord = FALSE;
                      if(!empty($_GET['pendaftaran_id'])){
                          $model->suratketerangan_id = $model->suratketerangan_id;
                      }
                   }else{
                       echo "gagal Simpan";exit;
                   } 

                    Yii::app()->user->setFlash('success',"Surat Keterangan Opname (Sudah Pulang) berhasil disimpan");
                    $this->redirect(array('OpnameSP','pendaftaran_id'=>$pendaftaran_id,
                                            'suratketerangan_id'=>$model->suratketerangan_id)); 
                }  
            }
            catch (Exception $exc) 
            {
                $transaction->rollback();
                Yii::app()->user->setFlash('error',"Surat Keterangan Opname (Sudah Pulang) gagal disimpan ".MyExceptionMessage::getMessage($exc,true));
            }
        } 
        $this->render($this->path_view.'opnameSP/index',array(
                'model'=>$model,
                'modPasien'=>$modPasien,
                'modPendaftaran'=>$modPendaftaran,
                'modAdmisi'=>$modAdmisi,
        ));
    }

    public function actionPrintOpnameSP($pendaftaran_id = null,$suratketerangan_id = null,$lama_hari = null){
        $this->layout = '//layouts/iframe';

        $modPendaftaran = RKPendaftaranT::model()->findByPk($pendaftaran_id);
        $modPasien = RKPasienM::model()->findByPk($modPendaftaran->pasien_id);
        $modAdmisi = PasienadmisiT::model()->findByPk($modPendaftaran->pasienadmisi_id);
//        if(!empty($modPendaftaran->pasienadmisi_id)){            
//            $modDokter = PegawaiM::model()->findByPk($modAdmisi->pegawai_id);
//            $mengetahui = $modDokter->gelardepan." ".$modDokter->nama_pegawai." .".$modDokter->gelarbelakang->gelarbelakang_nama;
//        }else{
//            $modDokter = PegawaiM::model()->findByPk($modPendaftaran->pegawai_id);
//            $mengetahui = $modDokter->gelardepan." ".$modDokter->nama_pegawai." .".$modDokter->gelarbelakang->gelarbelakang_nama;
//        }
        
        $model = RKSuratketeranganR::model()->findByPk($suratketerangan_id);           

        
        $judulLaporan = '';

        $caraPrint=$_REQUEST['caraPrint'];
        if($caraPrint=='PRINT') {
            $this->layout='//layouts/printWindows';
        }
        $this->render($this->path_view.'opnameSP/printSuratOpnameSP',array(
                'modPendaftaran'=>$modPendaftaran, 
                'modPasien'=>$modPasien,
                'modAdmisi'=>$modAdmisi,
                'model'=>$model, 
                'judulLaporan'=>$judulLaporan,
                'caraPrint'=>$caraPrint));
    }
    // end Tabular Opname (Sudah Pulang)
        
    // Tabular : Opname (Sedang Dirawat)
    public function actionOpnameRI($pendaftaran_id = null){
        $this->layout='//layouts/iframe';

        $format = new MyFormatter();
        $model = new RKSuratketeranganR;
        $modPasien = new RKPasienM;
        $modPendaftaran = new RKPendaftaranT;
        $modAdmisi = new PasienadmisiT();

        $model->nomorsurat = MyGenerator::noSurat(1);
        $modAdmisi->tgladmisi = date("Y-m-d")." 00:00:00";
        $modAdmisi->tglpulang = date("Y-m-d")." 00:00:00";

        if(isset($_POST['RKSuratketeranganR']))
        {
            $pendaftaran_id = $_GET['pendaftaran_id'];
            $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
            $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
            $modAdmisi = PasienadmisiT::model()->findByPk($modPendaftaran->pasienadmisi_id);
            $transaction = Yii::app()->db->beginTransaction();
            try {
                $model->attributes=$_POST['RKSuratketeranganR']; 
                $model->tglsurat=date('Y-m-d');
                $model->jenissurat_id = 1;
                $model->nourutsurat = 1;
                $model->pendaftaran_id = $pendaftaran_id;
                $model->pasien_id = $modPasien->pasien_id;
                $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
                $model->jmlprint_surat = 1;
                $model->mengetahui_surat = $_POST['RKSuratketeranganR']['mengetahui_surat'];
                $model->profilrs_id = 1;
                $model->judulsurat = "SURAT KETERANGAN OPNAME (SEDANG DIRAWAT)";

                $model->create_time = date('Y-m-d');
                $model->update_time = date('Y-m-d');
                $model->create_loginpemakai_id = Yii::app()->user->id;
                $model->update_loginpemakai_id = Yii::app()->user->id;
                $model->create_ruangan = Yii::app()->user->getState('ruangan_id');

//                    echo "<pre>";
//                    echo print_r($model->getAttributes());exit;
                if($model->validate()){
                   if($model->save()){
                      $transaction->commit();
                      $model->isNewRecord = FALSE;
                      if(!empty($_GET['pendaftaran_id'])){
                          $model->suratketerangan_id = $model->suratketerangan_id;
                      }
                   }else{
                       echo "gagal Simpan";exit;
                   } 

                    Yii::app()->user->setFlash('success',"Surat Keterangan Opname (Sedang Dirawat) berhasil disimpan");
                    $this->redirect(array('OpnameRI','pendaftaran_id'=>$pendaftaran_id,
                                            'suratketerangan_id'=>$model->suratketerangan_id)); 
                }  
            }
            catch (Exception $exc) 
            {
                $transaction->rollback();
                Yii::app()->user->setFlash('error',"Surat Keterangan Opname (Sedang Dirawat) gagal disimpan ".MyExceptionMessage::getMessage($exc,true));
            }
        } 
        $this->render($this->path_view.'opnameRI/index',array(
                'model'=>$model,
                'modPasien'=>$modPasien,
                'modPendaftaran'=>$modPendaftaran,
                'modAdmisi'=>$modAdmisi,
        ));
    }

    public function actionPrintOpnameRI($pendaftaran_id = null,$suratketerangan_id = null,$lama_hari = null){
        $this->layout = '//layouts/iframe';

        $modPendaftaran = RKPendaftaranT::model()->findByPk($pendaftaran_id);
        $modPasien = RKPasienM::model()->findByPk($modPendaftaran->pasien_id);
        $modAdmisi = PasienadmisiT::model()->findByPk($modPendaftaran->pasienadmisi_id);
//        if(!empty($modPendaftaran->pasienadmisi_id)){
//            $modDokter = PegawaiM::model()->findByPk($modAdmisi->pegawai_id);
//        }else{
//            $modDokter = PegawaiM::model()->findByPk($modPendaftaran->pegawai_id);
//        }
//        $mengetahui = $modDokter->gelardepan." ".$modDokter->nama_pegawai." .".$modDokter->gelarbelakang->gelarbelakang_nama;
        $model = RKSuratketeranganR::model()->findByPk($suratketerangan_id);                   
        $judulLaporan = '';

        $caraPrint=$_REQUEST['caraPrint'];
        if($caraPrint=='PRINT') {
            $this->layout='//layouts/printWindows';
        }
        $this->render($this->path_view.'opnameRI/printSuratOpnameRI',array(
                'modPendaftaran'=>$modPendaftaran, 
                'modPasien'=>$modPasien,
                'modAdmisi'=>$modAdmisi,
                'model'=>$model, 
                'judulLaporan'=>$judulLaporan,
                'caraPrint'=>$caraPrint));
    }
    // end Tabular Opname (Sedang Dirawat)
    // 
    // Tabular : Indikasi Rawat Inap
    public function actionIndikasiRI($pendaftaran_id = null){
        $this->layout = '//layouts/iframe';

        $format = new MyFormatter();
        $model = new RKSuratketeranganR;
        $modPasien = new RKPasienM;
        $modPendaftaran = new RKPendaftaranT;
        $model->nomorsurat = MyGenerator::noSurat(1);

        if(isset($_POST['RKSuratketeranganR']))
        {
            $pendaftaran_id = $_GET['pendaftaran_id'];
            $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
            $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
            $transaction = Yii::app()->db->beginTransaction();
            try {
                $model->attributes=$_POST['RKSuratketeranganR'];  
                $model->tglsurat= date('Y-m-d');
                $model->jenissurat_id = 1;
                $model->nourutsurat = 1;
                $model->pendaftaran_id = $pendaftaran_id;
                $model->pasien_id = $modPasien->pasien_id;
                $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
                $model->jmlprint_surat = 1;
                $model->mengetahui_surat = $_POST['RKSuratketeranganR']['mengetahui_surat'];
                $model->profilrs_id = 1;
                $model->judulsurat = "SURAT KETERANGAN INDIKASI RAWAT INAP"; 
                $model->tglistirahat = $format->formatDateTimeForDb($_POST['RKSuratketeranganR']['tglistirahat']);

                $model->create_time = date('Y-m-d');
                $model->update_time = date('Y-m-d');
                $model->create_loginpemakai_id = Yii::app()->user->id;
                $model->update_loginpemakai_id = Yii::app()->user->id;
                $model->create_ruangan = Yii::app()->user->getState('ruangan_id');

                if($model->validate()){
                   if($model->save()){
                      $transaction->commit();
                      $model->isNewRecord = FALSE;
                      if(!empty($_GET['pendaftaran_id'])){
                          $model->suratketerangan_id = $model->suratketerangan_id;
                      }
                   }else{
                       echo "gagal Simpan";exit;
                   } 

                    Yii::app()->user->setFlash('success',"Surat Keterangan Indikasi Rawat Inap berhasil disimpan");
                    $this->redirect(array('IndikasiRI','pendaftaran_id'=>$pendaftaran_id,
                                            'suratketerangan_id'=>$model->suratketerangan_id)); 
                }  
            }
            catch (Exception $exc) 
            {
                $transaction->rollback();
                Yii::app()->user->setFlash('error',"Surat Keterangan Indikasi Rawat Inap gagal disimpan ".MyExceptionMessage::getMessage($exc,true));
            }
        } 
        $this->render($this->path_view.'indikasiRI/index',array(
                'model'=>$model,
                'modPasien'=>$modPasien,
                'modPendaftaran'=>$modPendaftaran,
        ));
    }

    public function actionPrintIndikasiRI($pendaftaran_id = null,$suratketerangan_id = null){
        $this->layout = '//layouts/iframe';

        $modPendaftaran = RKPendaftaranT::model()->findByPk($pendaftaran_id);
        $modPasien = RKPasienM::model()->findByPk($modPendaftaran->pasien_id);
        $model = RKSuratketeranganR::model()->findByPk($suratketerangan_id);           

        $judulLaporan = '';

        $caraPrint=$_REQUEST['caraPrint'];
        if($caraPrint=='PRINT') {
            $this->layout='//layouts/printWindows';
        }
        $this->render($this->path_view.'indikasiRI/printSuratIndikasiRI',array(
                'modPendaftaran'=>$modPendaftaran, 
                'modPasien'=>$modPasien,
                'model'=>$model, 
                'judulLaporan'=>$judulLaporan,
                'caraPrint'=>$caraPrint));
    }
    // end Tabular Indikasi Rawat Inap
    
    // Tabular : Diagnosa
    public function actionDiagnosa($pendaftaran_id = null){
        $this->layout = '//layouts/iframe';

        $format = new MyFormatter();
        $model = new RKSuratketeranganR;
        $modPasien = new RKPasienM;
        $modPendaftaran = new RKPendaftaranT;
        $model->nomorsurat = MyGenerator::noSurat(1);

        if(isset($_POST['RKSuratketeranganR']))
        {
            $pendaftaran_id = $_GET['pendaftaran_id'];
            $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
            $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
            $transaction = Yii::app()->db->beginTransaction();
            try {
                $model->attributes=$_POST['RKSuratketeranganR'];  
                $model->tglsurat= date('Y-m-d');
                $model->jenissurat_id = 1;
                $model->nourutsurat = 1;
                $model->pendaftaran_id = $pendaftaran_id;
                $model->pasien_id = $modPasien->pasien_id;
                $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
                $model->jmlprint_surat = 1;
                $model->mengetahui_surat = $_POST['RKSuratketeranganR']['mengetahui_surat'];
                $model->profilrs_id = 1;
                $model->judulsurat = "SURAT KETERANGAN DIAGNOSA";

                $model->create_time = date('Y-m-d');
                $model->update_time = date('Y-m-d');
                $model->create_loginpemakai_id = Yii::app()->user->id;
                $model->update_loginpemakai_id = Yii::app()->user->id;
                $model->create_ruangan = Yii::app()->user->getState('ruangan_id');

                if($model->validate()){
                   if($model->save()){
                      $transaction->commit();
                      $model->isNewRecord = FALSE;
                      if(!empty($_GET['pendaftaran_id'])){
                          $model->suratketerangan_id = $model->suratketerangan_id;
                      }
                   }else{
                       echo "gagal Simpan";exit;
                   } 

                    Yii::app()->user->setFlash('success',"Surat Keterangan Diagnosa berhasil disimpan");
                    $this->redirect(array('Diagnosa','pendaftaran_id'=>$pendaftaran_id,
                                            'suratketerangan_id'=>$model->suratketerangan_id)); 
                }  
            }
            catch (Exception $exc) 
            {
                $transaction->rollback();
                Yii::app()->user->setFlash('error',"Surat Keterangan Diagnosa gagal disimpan ".MyExceptionMessage::getMessage($exc,true));
            }
        } 
        $this->render($this->path_view.'diagnosa/index',array(
                'model'=>$model,
                'modPasien'=>$modPasien,
                'modPendaftaran'=>$modPendaftaran,
        ));
    }

    public function actionPrintDiagnosa($pendaftaran_id = null,$suratketerangan_id = null,$lama_hari = null){
        $this->layout = '//layouts/iframe';

        $modPendaftaran = RKPendaftaranT::model()->findByPk($pendaftaran_id);
        $modPasien = RKPasienM::model()->findByPk($modPendaftaran->pasien_id);
        $model = RKSuratketeranganR::model()->findByPk($suratketerangan_id);           

        $judulLaporan = '';

        $caraPrint=$_REQUEST['caraPrint'];
        if($caraPrint=='PRINT') {
            $this->layout='//layouts/printWindows';
        }
        $this->render($this->path_view.'diagnosa/printSuratDiagnosa',array(
                'modPendaftaran'=>$modPendaftaran, 
                'modPasien'=>$modPasien,
                'model'=>$model, 
                'judulLaporan'=>$judulLaporan,
                'caraPrint'=>$caraPrint));
    }
    // end Tabular Surat Diagnosa
        
    // Tabular : Surat Meninggal
    public function actionSuratMeninggal($pendaftaran_id = null){
        $this->layout = '//layouts/iframe';

        $format = new MyFormatter();
        $model = new RKSuratketeranganR;
        $modPasien = new RKPasienM;
        $modPendaftaran = new RKPendaftaranT;
        $modAdmisi = new PasienadmisiT;
        $model->nomorsurat = MyGenerator::noSurat(1);
        $modAdmisi->tgladmisi = date("Y-m-d")." 00:00:00";
        $modAdmisi->tglpulang = date("Y-m-d")." 00:00:00";
		
        if(isset($_POST['RKSuratketeranganR']))
        {
            $pendaftaran_id = $_GET['pendaftaran_id'];
            $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
            $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
            $transaction = Yii::app()->db->beginTransaction();
            try {
                $model->attributes=$_POST['RKSuratketeranganR'];  
                $model->tglsurat= date('Y-m-d');
                $model->jenissurat_id = 1;
                $model->nourutsurat = 1;
                $model->pendaftaran_id = $pendaftaran_id;
                $model->pasien_id = $modPasien->pasien_id;
                $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
                $model->jmlprint_surat = 1;
                $model->mengetahui_surat = $_POST['RKSuratketeranganR']['mengetahui_surat'];
                $model->profilrs_id = 1;
                $model->judulsurat = "SURAT KETERANGAN MENINGGAL";
                $model->penyebabkematian = $_POST['penyebabkematian'];
				
                $model->create_time = date('Y-m-d');
                $model->update_time = date('Y-m-d');
                $model->create_loginpemakai_id = Yii::app()->user->id;
                $model->update_loginpemakai_id = Yii::app()->user->id;
                $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
				
                if($model->validate()){
                   if($model->save()){
                      $transaction->commit();
                      $model->isNewRecord = FALSE;
                      if(!empty($_GET['pendaftaran_id'])){
                          $model->suratketerangan_id = $model->suratketerangan_id;
                      }
                   }else{
                       echo "gagal Simpan";exit;
                   } 

                    Yii::app()->user->setFlash('success',"Surat Keterangan Meninggal berhasil disimpan");
                    $this->redirect(array('SuratMeninggal','pendaftaran_id'=>$pendaftaran_id,
                                            'suratketerangan_id'=>$model->suratketerangan_id)); 
                }  
            }
            catch (Exception $exc) 
            {
                $transaction->rollback();
                Yii::app()->user->setFlash('error',"Surat Keterangan Meninggal gagal disimpan ".MyExceptionMessage::getMessage($exc,true));
            }
        } 
        $this->render($this->path_view.'meninggal/index',array(
                'model'=>$model,
                'modPasien'=>$modPasien,
                'modPendaftaran'=>$modPendaftaran,
                'modAdmisi'=>$modAdmisi
        ));
    }

    public function actionPrintSuratMeninggal($pendaftaran_id = null,$suratketerangan_id = null,$lama_hari = null){
        $this->layout = '//layouts/iframe';

        $modPendaftaran = RKPendaftaranT::model()->findByPk($pendaftaran_id);
        $modPasien = RKPasienM::model()->findByPk($modPendaftaran->pasien_id);
        $modAdmisi = PasienadmisiT::model()->findByPk($modPendaftaran->pasienadmisi_id);
//        $modDokter = PegawaiM::model()->findByPk($modAdmisi->pegawai_id);
        $model = RKSuratketeranganR::model()->findByPk($suratketerangan_id);           
  
//        $mengetahui = $modDokter->gelardepan." ".$modDokter->nama_pegawai." .".$modDokter->gelarbelakang->gelarbelakang_nama;
        $judulLaporan = '';

        $caraPrint=$_REQUEST['caraPrint'];
        if($caraPrint=='PRINT') {
            $this->layout='//layouts/printWindows';
        }
        $this->render($this->path_view.'meninggal/printSuratMeninggal',array(
                'modPendaftaran'=>$modPendaftaran, 
                'modPasien'=>$modPasien,
                'modAdmisi'=>$modAdmisi,
                'model'=>$model, 
                'judulLaporan'=>$judulLaporan,
                'caraPrint'=>$caraPrint));
    }
    // end Tabular Surat Meninggal
	
    // Tabular : Surat Lahir
    public function actionSuratLahir($pendaftaran_id = null){
        $this->layout = '//layouts/iframe';

        $format = new MyFormatter();
        $model = new RKSuratketeranganR;
        $modPasien = new RKPasienM;
        $modPendaftaran = new RKPendaftaranT;
		$model->nomorsurat = MyGenerator::noSurat(1);
		
        if(isset($_POST['RKSuratketeranganR']))
        {
            $pendaftaran_id = $_GET['pendaftaran_id'];
            $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
            $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
            $transaction = Yii::app()->db->beginTransaction();
            try {
                $model->attributes=$_POST['RKSuratketeranganR'];  
                $model->tglsurat= date('Y-m-d');
                $model->jenissurat_id = 1;
                $model->nourutsurat = 1;
                $model->pendaftaran_id = $pendaftaran_id;
                $model->pasien_id = $modPasien->pasien_id;
                $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
                $model->jmlprint_surat = 1;
                $model->mengetahui_surat = $_POST['RKSuratketeranganR']['mengetahui_surat'];
                $model->profilrs_id = 1;
                $model->judulsurat = "SURAT KETERANGAN LAHIR";
                $model->lahir_panjangbadan_cm = $_POST['RKSuratketeranganR']['lahir_panjangbadan_cm'];
                $model->lahir_beratbadan_gram = $_POST['RKSuratketeranganR']['lahir_beratbadan_gram'];
                $model->lahir_namaibu = $_POST['RKSuratketeranganR']['lahir_namaibu'];
                $model->lahir_namaayah = $_POST['RKSuratketeranganR']['lahir_namaayah'];
                $model->lahir_pekerjaan_ayah = $_POST['RKSuratketeranganR']['lahir_pekerjaan_ayah'];
                $model->no_pekerja_badge = $_POST['RKSuratketeranganR']['no_pekerja_badge'];
                $model->no_ktp_ayah = $_POST['RKSuratketeranganR']['no_ktp_ayah'];
                $model->lahir_alamat = $_POST['RKSuratketeranganR']['lahir_alamat'];
                $model->dokter_persalinan_id = $_POST['RKSuratketeranganR']['dokter_persalinan_id'];
                $model->lahir_tgllahir = $format->formatDateTimeForDb($_POST['lahir_tgllahir']);
				
                $model->create_time = date('Y-m-d');
                $model->update_time = date('Y-m-d');
                $model->create_loginpemakai_id = Yii::app()->user->id;
                $model->update_loginpemakai_id = Yii::app()->user->id;
                $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
				
                if($model->validate()){
                   if($model->save()){
                      $transaction->commit();
                      $model->isNewRecord = FALSE;
                      if(!empty($_GET['pendaftaran_id'])){
                          $model->suratketerangan_id = $model->suratketerangan_id;
                      }
                   }else{
                       echo "gagal Simpan";exit;
                   } 

                    Yii::app()->user->setFlash('success',"Surat Keterangan Lahir berhasil disimpan");
                    $this->redirect(array('SuratLahir','pendaftaran_id'=>$pendaftaran_id,
                                            'suratketerangan_id'=>$model->suratketerangan_id)); 
                }  
            }
            catch (Exception $exc) 
            {
                $transaction->rollback();
                Yii::app()->user->setFlash('error',"Surat Keterangan Lahir gagal disimpan ".MyExceptionMessage::getMessage($exc,true));
            }
        } 
        $this->render($this->path_view.'lahir/index',array(
                'model'=>$model,
                'modPasien'=>$modPasien,
                'modPendaftaran'=>$modPendaftaran
        ));
    }

    public function actionPrintSuratLahir($pendaftaran_id = null,$suratketerangan_id = null,$lama_hari = null){
        $this->layout = '//layouts/iframe';

        $modPendaftaran = RKPendaftaranT::model()->findByPk($pendaftaran_id);
        $modPasien = RKPasienM::model()->findByPk($modPendaftaran->pasien_id);
        $modAdmisi = PasienadmisiT::model()->findByPk($modPendaftaran->pasienadmisi_id);
//        $modDokter = PegawaiM::model()->findByPk($modAdmisi->pegawai_id);
        $model = RKSuratketeranganR::model()->findByPk($suratketerangan_id);           
  
//        $mengetahui = $modDokter->gelardepan." ".$modDokter->nama_pegawai." .".$modDokter->gelarbelakang->gelarbelakang_nama;
        $judulLaporan = '';

        $caraPrint=$_REQUEST['caraPrint'];
        if($caraPrint=='PRINT') {
            $this->layout='//layouts/printWindows';
        }
        $this->render($this->path_view.'lahir/printSuratLahir',array(
                'modPendaftaran'=>$modPendaftaran, 
                'modPasien'=>$modPasien,
                'modAdmisi'=>$modAdmisi,
                'model'=>$model, 
                'judulLaporan'=>$judulLaporan,
                'caraPrint'=>$caraPrint));
    }
    // end Tabular Surat Lahir
    
    // Tabular : Surat Berbadan Sehat
    public function actionSuratBadanSehat($pendaftaran_id = null){
        $this->layout = '//layouts/iframe';

        $format = new MyFormatter();
        $model = new RKSuratketeranganR;
        $modPasien = new RKPasienM;
        $modPendaftaran = new RKPendaftaranT;
        $modAdmisi = new PasienadmisiT();
        $model->nomorsurat = MyGenerator::noSurat(1);

        if(isset($_POST['RKSuratketeranganR']))
        {
            $pendaftaran_id = $_GET['pendaftaran_id'];
            $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
            $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
            $transaction = Yii::app()->db->beginTransaction();
            try {
                $model->attributes=$_POST['RKSuratketeranganR'];  
                $model->tglsurat= date('Y-m-d');
                $model->jenissurat_id = 1;
                $model->nourutsurat = 1;
                $model->pendaftaran_id = $pendaftaran_id;
                $model->pasien_id = $modPasien->pasien_id;
                $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
                $model->jmlprint_surat = 1;
                $model->mengetahui_surat = $_POST['RKSuratketeranganR']['mengetahui_surat'];
                $model->keterangan = $_POST['RKSuratketeranganR']['keterangan'];
                $model->profilrs_id = 1;
                $model->judulsurat = "SURAT KETERANGAN BERBADAN SEHAT";

                $model->create_time = date('Y-m-d');
                $model->update_time = date('Y-m-d');
                $model->create_loginpemakai_id = Yii::app()->user->id;
                $model->update_loginpemakai_id = Yii::app()->user->id;
                $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
				$model->butawarna = isset($_POST['RKSuratketeranganR']['butawarna']) ? $_POST['RKSuratketeranganR']['butawarna'] : "";
                if($model->validate()){
                   if($model->save()){
                      $transaction->commit();
                      $model->isNewRecord = FALSE;
                      if(!empty($_GET['pendaftaran_id'])){
                          $model->suratketerangan_id = $model->suratketerangan_id;
                      }
                   }else{
                       echo "gagal Simpan";exit;
                   } 

                    Yii::app()->user->setFlash('success',"Surat Keterangan Berbadan Sehat berhasil disimpan");
                    $this->redirect(array('SuratBadanSehat','pendaftaran_id'=>$pendaftaran_id,
                                            'suratketerangan_id'=>$model->suratketerangan_id)); 
                }  
            }
            catch (Exception $exc) 
            {
                $transaction->rollback();
                Yii::app()->user->setFlash('error',"Surat Keterangan Berbadan Sehat gagal disimpan ".MyExceptionMessage::getMessage($exc,true));
            }
        } 
        $this->render($this->path_view.'badanSehat/index',array(
                'model'=>$model,
                'modPasien'=>$modPasien,
                'modPendaftaran'=>$modPendaftaran,
                'modAdmisi'=>$modAdmisi
        ));
    }

    public function actionPrintSuratBadanSehat($pendaftaran_id = null,$suratketerangan_id = null,$lama_hari = null){
        $this->layout = '//layouts/iframe';

        $modPendaftaran = RKPendaftaranT::model()->findByPk($pendaftaran_id);
        $modPasien = RKPasienM::model()->findByPk($modPendaftaran->pasien_id);
        $model = RKSuratketeranganR::model()->findByPk($suratketerangan_id);           

        $judulLaporan = '';

        $caraPrint=$_REQUEST['caraPrint'];
        if($caraPrint=='PRINT') {
            $this->layout='//layouts/printWindows';
        }
        $this->render($this->path_view.'badanSehat/printSuratBadanSehat',array(
                'modPendaftaran'=>$modPendaftaran, 
                'modPasien'=>$modPasien,
                'model'=>$model, 
                'judulLaporan'=>$judulLaporan,
                'caraPrint'=>$caraPrint));
    }
    // end Tabular Surat Berbadan Sehat
    
    // Tabular : Penyakit Rawat Darurat Sehat
    public function actionPenyakitRD($pendaftaran_id = null){
        $this->layout = '//layouts/iframe';

        $format = new MyFormatter();
        $model = new RKSuratketeranganR;
        $modPasien = new RKPasienM;
        $modPendaftaran = new RKPendaftaranT;
        $modAdmisi = new PasienadmisiT();
        $model->nomorsurat = MyGenerator::noSurat(1);

        if(isset($_POST['RKSuratketeranganR']))
        {
            $pendaftaran_id = $_GET['pendaftaran_id'];
            $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
            $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
            
            $transaction = Yii::app()->db->beginTransaction();
            try {
                $model->attributes=$_POST['RKSuratketeranganR'];  
                $model->tglsurat= date('Y-m-d');
                $model->jenissurat_id = 1;
                $model->nourutsurat = 1;
                $model->pendaftaran_id = $pendaftaran_id;
                $model->pasien_id = $modPasien->pasien_id;
                $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
                $model->jmlprint_surat = 1;
                $model->mengetahui_surat = $_POST['RKSuratketeranganR']['mengetahui_surat'];
                $model->profilrs_id = 1;
                $model->judulsurat = "SURAT KETERANGAN PENYAKIT GAWAT DARURAT";
                $labrad = isset($_POST['RKSuratketeranganR']['lab_rad']) ? $_POST['RKSuratketeranganR']['lab_rad'] : null;  

                $model->create_time = date('Y-m-d');
                $model->update_time = date('Y-m-d');
                $model->create_loginpemakai_id = Yii::app()->user->id;
                $model->update_loginpemakai_id = Yii::app()->user->id;
                $model->create_ruangan = Yii::app()->user->getState('ruangan_id');

                if($model->validate()){
                   if($model->save()){
                      $transaction->commit();
                      $model->isNewRecord = FALSE;
                      if(!empty($_GET['pendaftaran_id'])){
                          $model->suratketerangan_id = $model->suratketerangan_id;
						  
                      }
                   }else{
                       echo "gagal Simpan";exit;
                   } 

                    Yii::app()->user->setFlash('success',"Surat Keterangan Penyakit Gawat Darurat berhasil disimpan");
                    $this->redirect(array('PenyakitRD','pendaftaran_id'=>$pendaftaran_id,
                                            'suratketerangan_id'=>$model->suratketerangan_id)); 
                }  
            }
            catch (Exception $exc) 
            {
                $transaction->rollback();
                Yii::app()->user->setFlash('error',"Surat Keterangan Penyakit Gawat Darurat gagal disimpan ".MyExceptionMessage::getMessage($exc,true));
            }
        } 
        $this->render($this->path_view.'penyakitRD/index',array(
                'model'=>$model,
                'modPasien'=>$modPasien,
                'modPendaftaran'=>$modPendaftaran,
                'modAdmisi'=>$modAdmisi
        ));
    }

    public function actionPrintPenyakitRD($pendaftaran_id = null,$suratketerangan_id = null,$lama_hari = null){
        $this->layout = '//layouts/iframe';

        $modPendaftaran = RKPendaftaranT::model()->findByPk($pendaftaran_id);
        $modPasien = RKPasienM::model()->findByPk($modPendaftaran->pasien_id);
        $model = RKSuratketeranganR::model()->findByPk($suratketerangan_id);           

        $judulLaporan = '';

        $caraPrint=$_REQUEST['caraPrint'];
        if($caraPrint=='PRINT') {
            $this->layout='//layouts/printWindows';
        }
        $this->render($this->path_view.'penyakitRD/printPenyakitRD',array(
                'modPendaftaran'=>$modPendaftaran, 
                'modPasien'=>$modPasien,
                'model'=>$model, 
                'judulLaporan'=>$judulLaporan,
                'caraPrint'=>$caraPrint));
    }
    // end Tabular Surat Berbadan Sehat
    
    // Tabular : Layak Naik Pesawat
    public function actionLayakNaikPesawat($pendaftaran_id = null){
        $this->layout = '//layouts/iframe';

        $format = new MyFormatter();
        $model = new RKSuratketeranganR;
        $modPasien = new RKPasienM;
        $modPendaftaran = new RKPendaftaranT;
        $model->nomorsurat = MyGenerator::noSurat(1);

        if(isset($_POST['RKSuratketeranganR']))
        {
            $pendaftaran_id = $_GET['pendaftaran_id'];
            $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
            $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
            $transaction = Yii::app()->db->beginTransaction();
            try {
                $model->attributes=$_POST['RKSuratketeranganR'];  
                $model->tglsurat= date('Y-m-d');
                $model->jenissurat_id = 1;
                $model->nourutsurat = 1;
                $model->pendaftaran_id = $pendaftaran_id;
                $model->pasien_id = $modPasien->pasien_id;
                $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
                $model->jmlprint_surat = 1;
                $model->mengetahui_surat = $_POST['RKSuratketeranganR']['mengetahui_surat'];
                $model->profilrs_id = 1;
                $model->judulsurat = "SURAT KETERANGAN LAYAK NAIK PESAWAT TERBANG";

                $model->create_time = date('Y-m-d');
                $model->update_time = date('Y-m-d');
                $model->create_loginpemakai_id = Yii::app()->user->id;
                $model->update_loginpemakai_id = Yii::app()->user->id;
                $model->create_ruangan = Yii::app()->user->getState('ruangan_id');

                if($model->validate()){
                   if($model->save()){
                      $transaction->commit();
                      $model->isNewRecord = FALSE;
                      if(!empty($_GET['pendaftaran_id'])){
                          $model->suratketerangan_id = $model->suratketerangan_id;
                      }
                   }else{
                       echo "gagal Simpan";exit;
                   } 

                    Yii::app()->user->setFlash('success',"Surat Keterangan Layak Naik Pesawat Terbang berhasil disimpan");
                    $this->redirect(array('LayakNaikPesawat','pendaftaran_id'=>$pendaftaran_id,
                                            'suratketerangan_id'=>$model->suratketerangan_id)); 
                }  
            }
            catch (Exception $exc) 
            {
                $transaction->rollback();
                Yii::app()->user->setFlash('error',"Surat Keterangan Layak Naik Pesawat Terbang gagal disimpan ".MyExceptionMessage::getMessage($exc,true));
            }
        } 
        $this->render($this->path_view.'layakNaikPesawat/index',array(
                'model'=>$model,
                'modPasien'=>$modPasien,
                'modPendaftaran'=>$modPendaftaran,
        ));
    }

    public function actionPrintLayakNaikPesawat($pendaftaran_id = null,$suratketerangan_id = null,$lama_hari = null){
        $this->layout = '//layouts/iframe';

        $modPendaftaran = RKPendaftaranT::model()->findByPk($pendaftaran_id);
        $modPasien = RKPasienM::model()->findByPk($modPendaftaran->pasien_id);
        $model = RKSuratketeranganR::model()->findByPk($suratketerangan_id);           

        $judulLaporan = '';

        $caraPrint=$_REQUEST['caraPrint'];
        if($caraPrint=='PRINT') {
            $this->layout='//layouts/printWindows';
        }
        $this->render($this->path_view.'layakNaikPesawat/printLayakNaikPesawat',array(
                'modPendaftaran'=>$modPendaftaran, 
                'modPasien'=>$modPasien,
                'model'=>$model, 
                'judulLaporan'=>$judulLaporan,
                'caraPrint'=>$caraPrint));
    }
    // end Tabular Layak Naik Pesawat
    
    // Tabular : Cuti Hamil
    public function actionCutiHamil($pendaftaran_id = null){
        $this->layout = '//layouts/iframe';

        $format = new MyFormatter();
        $model = new RKSuratketeranganR;
        $modPasien = new RKPasienM;
        $modPendaftaran = new RKPendaftaranT;
        $model->nomorsurat = MyGenerator::noSurat(1);

        if(isset($_POST['RKSuratketeranganR']))
        {
            $pendaftaran_id = $_GET['pendaftaran_id'];
            $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
            $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
            $transaction = Yii::app()->db->beginTransaction();
            try {
                $model->attributes=$_POST['RKSuratketeranganR'];  
                $model->tglsurat= date('Y-m-d');
                $model->jenissurat_id = 1;
                $model->nourutsurat = 1;
                $model->pendaftaran_id = $pendaftaran_id;
                $model->pasien_id = $modPasien->pasien_id;
                $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
                $model->jmlprint_surat = 1;
                $model->mengetahui_surat = $_POST['RKSuratketeranganR']['mengetahui_surat'];
                $model->profilrs_id = 1;
                $model->judulsurat = "SURAT KETERANGAN CUTI HAMIL";
                $model->tglistirahat = $format->formatDateTimeForDb($_POST['RKSuratketeranganR']['tglistirahat']);
                $model->tglperkiraanpartus = $format->formatDateTimeForDb($_POST['RKSuratketeranganR']['tglperkiraanpartus']);

                $model->create_time = date('Y-m-d');
                $model->update_time = date('Y-m-d');
                $model->create_loginpemakai_id = Yii::app()->user->id;
                $model->update_loginpemakai_id = Yii::app()->user->id;
                $model->create_ruangan = Yii::app()->user->getState('ruangan_id');

                if($model->validate()){
                   if($model->save()){
                      $transaction->commit();
                      $model->isNewRecord = FALSE;
                      if(!empty($_GET['pendaftaran_id'])){
                          $model->suratketerangan_id = $model->suratketerangan_id;
                      }
                   }else{
                       echo "gagal Simpan";exit;
                   } 

                    Yii::app()->user->setFlash('success',"Surat Keterangan Cuti Hamil berhasil disimpan");
                    $this->redirect(array('CutiHamil','pendaftaran_id'=>$pendaftaran_id,
                                            'suratketerangan_id'=>$model->suratketerangan_id)); 
                }  
            }
            catch (Exception $exc) 
            {
                $transaction->rollback();
                Yii::app()->user->setFlash('error',"Surat Keterangan Cuti Hamil gagal disimpan ".MyExceptionMessage::getMessage($exc,true));
            }
        } 
        $this->render($this->path_view.'cutiHamil/index',array(
                'model'=>$model,
                'modPasien'=>$modPasien,
                'modPendaftaran'=>$modPendaftaran,
        ));
    }

    public function actionPrintCutiHamil($pendaftaran_id = null,$suratketerangan_id = null,$lama_hari = null){
        $this->layout = '//layouts/iframe';

        $modPendaftaran = RKPendaftaranT::model()->findByPk($pendaftaran_id);
        $modPasien = RKPasienM::model()->findByPk($modPendaftaran->pasien_id);
        $model = RKSuratketeranganR::model()->findByPk($suratketerangan_id);           

        $judulLaporan = '';

        $caraPrint=$_REQUEST['caraPrint'];
        if($caraPrint=='PRINT') {
            $this->layout='//layouts/printWindows';
        }
        $this->render($this->path_view.'cutiHamil/printCutiHamil',array(
                'modPendaftaran'=>$modPendaftaran, 
                'modPasien'=>$modPasien,
                'model'=>$model, 
                'judulLaporan'=>$judulLaporan,
                'caraPrint'=>$caraPrint));
    }
    // end Tabular Cuti Hamil
    
    // Tabular : Cuti Melahirkan
    public function actionCutiMelahirkan($pendaftaran_id = null){
        $this->layout = '//layouts/iframe';

        $format = new MyFormatter();
        $model = new RKSuratketeranganR;
        $modPasien = new RKPasienM;
        $modPendaftaran = new RKPendaftaranT;
        $model->nomorsurat = MyGenerator::noSurat(1);

        if(isset($_POST['RKSuratketeranganR']))
        {
            $pendaftaran_id = $_GET['pendaftaran_id'];
            $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
            $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
            $transaction = Yii::app()->db->beginTransaction();
            try {
                $model->attributes=$_POST['RKSuratketeranganR'];  
                $model->tglsurat= date('Y-m-d');
                $model->jenissurat_id = 1;
                $model->nourutsurat = 1;
                $model->pendaftaran_id = $pendaftaran_id;
                $model->pasien_id = $modPasien->pasien_id;
                $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
                $model->jmlprint_surat = 1;
                $model->mengetahui_surat = $_POST['RKSuratketeranganR']['mengetahui_surat'];
                $model->profilrs_id = 1;
                $model->judulsurat = "SURAT KETERANGAN CUTI PASCA MELAHIRKAN";
                $model->lamaistirahat = $_POST['RKSuratketeranganR']['lamaistirahat'];  

                $model->create_time = date('Y-m-d');
                $model->update_time = date('Y-m-d');
                $model->create_loginpemakai_id = Yii::app()->user->id;
                $model->update_loginpemakai_id = Yii::app()->user->id;
                $model->create_ruangan = Yii::app()->user->getState('ruangan_id');

                if($model->validate()){
                   if($model->save()){
                      $transaction->commit();
                      $model->isNewRecord = FALSE;
                      if(!empty($_GET['pendaftaran_id'])){
                          $model->suratketerangan_id = $model->suratketerangan_id;
                      }
                   }else{
                       echo "gagal Simpan";exit;
                   } 

                    Yii::app()->user->setFlash('success',"Surat Keterangan Cuti Melahirkan berhasil disimpan");
                    $this->redirect(array('CutiMelahirkan','pendaftaran_id'=>$pendaftaran_id,
                                            'suratketerangan_id'=>$model->suratketerangan_id,'lama_hari'=>$_POST['RKSuratketeranganR']['lamaistirahat'])); 
                }  
            }
            catch (Exception $exc) 
            {
                $transaction->rollback();
                Yii::app()->user->setFlash('error',"Surat Keterangan Cuti Melahirkan gagal disimpan ".MyExceptionMessage::getMessage($exc,true));
            }
        } 
        $this->render($this->path_view.'cutiMelahirkan/index',array(
                'model'=>$model,
                'modPasien'=>$modPasien,
                'modPendaftaran'=>$modPendaftaran,
        ));
    }

    public function actionPrintCutiMelahirkan($pendaftaran_id = null,$suratketerangan_id = null,$lama_hari = null){
        $this->layout = '//layouts/iframe';

        $modPendaftaran = RKPendaftaranT::model()->findByPk($pendaftaran_id);
        $modPasien = RKPasienM::model()->findByPk($modPendaftaran->pasien_id);
        $model = RKSuratketeranganR::model()->findByPk($suratketerangan_id);           

        $judulLaporan = '';

        $caraPrint=$_REQUEST['caraPrint'];
        if($caraPrint=='PRINT') {
            $this->layout='//layouts/printWindows';
        }
        $this->render($this->path_view.'cutiMelahirkan/printCutiMelahirkan',array(
                'modPendaftaran'=>$modPendaftaran, 
                'modPasien'=>$modPasien,
                'model'=>$model, 
                'judulLaporan'=>$judulLaporan,
                'caraPrint'=>$caraPrint));
    }
    // end Tabular Cuti Melahirkan
    
    // Tabular : Ambulans Antar Jenazah
    public function actionAntarJenazah($pendaftaran_id = null){
        $this->layout = '//layouts/iframe';

        $format = new MyFormatter();
        $model = new RKSuratketeranganR;
        $modPasien = new RKPasienM;
        $modPendaftaran = new RKPendaftaranT;
        $model->nomorsurat = MyGenerator::noSurat(1);

        if(isset($_POST['RKSuratketeranganR']))
        {
            $pendaftaran_id = $_GET['pendaftaran_id'];
            $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
            $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
            $transaction = Yii::app()->db->beginTransaction();
            try {
                $model->attributes=$_POST['RKSuratketeranganR'];  
                $model->tglsurat= date('Y-m-d');
                $model->jenissurat_id = 1;
                $model->nourutsurat = 1;
                $model->pendaftaran_id = $pendaftaran_id;
                $model->pasien_id = $modPasien->pasien_id;
                $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
                $model->jmlprint_surat = 1;
                $model->mengetahui_surat = $_POST['RKSuratketeranganR']['mengetahui_surat'];
                $model->profilrs_id = 1;
                $model->judulsurat = "SURAT JALAN AMBULANCE ANTAR JENAZAH";

                // untuk kendaraan
                $model->mobilambulans_id = $_POST['RKSuratketeranganR']['mobilambulans_id'];
                $model->supirambulans_id = $_POST['RKSuratketeranganR']['supirambulans_id'];
                $model->keterangan = $_POST['RKSuratketeranganR']['keterangan']; // untuk no_sim
                
                $model->create_time = date('Y-m-d');
                $model->update_time = date('Y-m-d');
                $model->create_loginpemakai_id = Yii::app()->user->id;
                $model->update_loginpemakai_id = Yii::app()->user->id;
                $model->create_ruangan = Yii::app()->user->getState('ruangan_id');

                if($model->validate()){
                   if($model->save()){
                      $transaction->commit();
                      $model->isNewRecord = FALSE;
                      if(!empty($_GET['pendaftaran_id'])){
                          $model->suratketerangan_id = $model->suratketerangan_id;
                      }
                   }else{
                       echo "gagal Simpan";exit;
                   } 

                    Yii::app()->user->setFlash('success'," Surat Jalan Ambulance Antar Jenazah  berhasil disimpan");
                    $this->redirect(array('AntarJenazah','pendaftaran_id'=>$pendaftaran_id,
                                            'suratketerangan_id'=>$model->suratketerangan_id)); 
                }  
            }
            catch (Exception $exc) 
            {
                $transaction->rollback();
                Yii::app()->user->setFlash('error'," Surat Jalan Ambulance Antar Jenazah gagal disimpan ".MyExceptionMessage::getMessage($exc,true));
            }
        } 
        $this->render($this->path_view.'antarJenazah/index',array(
                'model'=>$model,
                'modPasien'=>$modPasien,
                'modPendaftaran'=>$modPendaftaran,
        ));
    }

    public function actionPrintAntarJenazah($pendaftaran_id = null,$suratketerangan_id = null,$lama_hari = null){
        $this->layout = '//layouts/iframe';

        $modPendaftaran = RKPendaftaranT::model()->findByPk($pendaftaran_id);
        $modPasien = RKPasienM::model()->findByPk($modPendaftaran->pasien_id);
        $model = RKSuratketeranganR::model()->findByPk($suratketerangan_id);           

        $judulLaporan = '';

        $caraPrint=$_REQUEST['caraPrint'];
        if($caraPrint=='PRINT') {
            $this->layout='//layouts/printWindows';
        }
        $this->render($this->path_view.'antarJenazah/printAntarJenazah',array(
                'modPendaftaran'=>$modPendaftaran, 
                'modPasien'=>$modPasien,
                'model'=>$model, 
                'judulLaporan'=>$judulLaporan,
                'caraPrint'=>$caraPrint));
    }
    // end Tabular Ambulans Antar Jenazah
    
    // Tabular : Ambulans Jemput Pasien
    public function actionJemputPasien($pendaftaran_id = null){
        $this->layout = '//layouts/iframe';

        $format = new MyFormatter();
        $model = new RKSuratketeranganR;
        $modPasien = new RKPasienM;
        $modPendaftaran = new RKPendaftaranT;
        $model->nomorsurat = MyGenerator::noSurat(1);

        if(isset($_POST['RKSuratketeranganR']))
        {
            $pendaftaran_id = $_GET['pendaftaran_id'];
            $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
            $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
            $transaction = Yii::app()->db->beginTransaction();
            try {
                $model->attributes=$_POST['RKSuratketeranganR'];  
                $model->tglsurat= date('Y-m-d');
                $model->jenissurat_id = 1;
                $model->nourutsurat = 1;
                $model->pendaftaran_id = $pendaftaran_id;
                $model->pasien_id = $modPasien->pasien_id;
                $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
                $model->jmlprint_surat = 1;
                $model->mengetahui_surat = $_POST['RKSuratketeranganR']['mengetahui_surat'];
                $model->profilrs_id = 1;
                $model->judulsurat = " SURAT JALAN AMBULANCE JEMPUT PASIEN";
                $model->dari_ke = $_POST['RKSuratketeranganR']['dari_ke'];
                $model->kepadayth = $_POST['RKSuratketeranganR']['kepadayth'];
                $model->namapesawat = $_POST['RKSuratketeranganR']['namapesawat'];
                $tgl = $format->formatDateTimeForDb($_POST['tgl_berangkat']);
                $waktu = $_POST['waktu'];
                $model->tglberangkatpst = $tgl." ".$waktu;
                
                // untuk kendaraan
                $model->mobilambulans_id = $_POST['RKSuratketeranganR']['mobilambulans_id'];
                $model->supirambulans_id = $_POST['RKSuratketeranganR']['supirambulans_id'];
                $model->keterangan = $_POST['RKSuratketeranganR']['keterangan']; // untuk no_sim
                
                // yang bertandatangan
                $model->ygbertandatangan_id = $_POST['RKSuratketeranganR']['ygbertandatangan_id'];
                
                $model->create_time = date('Y-m-d');
                $model->update_time = date('Y-m-d');
                $model->create_loginpemakai_id = Yii::app()->user->id;
                $model->update_loginpemakai_id = Yii::app()->user->id;
                $model->create_ruangan = Yii::app()->user->getState('ruangan_id');

                if($model->validate()){
                   if($model->save()){
                      $transaction->commit();
                      $model->isNewRecord = FALSE;
                      if(!empty($_GET['pendaftaran_id'])){
                          $model->suratketerangan_id = $model->suratketerangan_id;
                      }
                   }else{
                       echo "gagal Simpan";exit;
                   } 

                    Yii::app()->user->setFlash('success'," Surat Jalan Ambulance Jemput Pasien Di Bandara  berhasil disimpan");
                    $this->redirect(array('JemputPasien','pendaftaran_id'=>$pendaftaran_id,
                                            'suratketerangan_id'=>$model->suratketerangan_id)); 
                }  
            }
            catch (Exception $exc) 
            {
                $transaction->rollback();
                Yii::app()->user->setFlash('error',"Surat Keterangan Surat Jalan Ambulance Jemput Pasien Di Bandara gagal disimpan ".MyExceptionMessage::getMessage($exc,true));
            }
        } 
        $this->render($this->path_view.'jemputPasien/index',array(
                'model'=>$model,
                'modPasien'=>$modPasien,
                'modPendaftaran'=>$modPendaftaran,
        ));
    }

    public function actionPrintJemputPasien($pendaftaran_id = null,$suratketerangan_id = null,$lama_hari = null){
        $this->layout = '//layouts/iframe';

        $modPendaftaran = RKPendaftaranT::model()->findByPk($pendaftaran_id);
        $modPasien = RKPasienM::model()->findByPk($modPendaftaran->pasien_id);
        $model = RKSuratketeranganR::model()->findByPk($suratketerangan_id);           

        $judulLaporan = '';

        $caraPrint=$_REQUEST['caraPrint'];
        if($caraPrint=='PRINT') {
            $this->layout='//layouts/printWindows';
        }
        $this->render($this->path_view.'jemputPasien/printJemputPasien',array(
                'modPendaftaran'=>$modPendaftaran, 
                'modPasien'=>$modPasien,
                'model'=>$model, 
                'judulLaporan'=>$judulLaporan,
                'caraPrint'=>$caraPrint));
    }
    // end Tabular Ambulans Jemput Pasien
    
    // Tabular : Ambulans Jemput Jenazah ke Bandara
    public function actionJemputJenazah($pendaftaran_id = null){
        $this->layout = '//layouts/iframe';

        $format = new MyFormatter();
        $model = new RKSuratketeranganR;
        $modPasien = new RKPasienM;
        $modPendaftaran = new RKPendaftaranT;
        $model->nomorsurat = MyGenerator::noSurat(1);

        if(isset($_POST['RKSuratketeranganR']))
        {
            $pendaftaran_id = $_GET['pendaftaran_id'];
            $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
            $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
            $transaction = Yii::app()->db->beginTransaction();
            try {
                $model->attributes=$_POST['RKSuratketeranganR'];  
                $model->tglsurat= date('Y-m-d');
                $model->jenissurat_id = 1;
                $model->nourutsurat = 1;
                $model->pendaftaran_id = $pendaftaran_id;
                $model->pasien_id = $modPasien->pasien_id;
                $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
                $model->jmlprint_surat = 1;
                $model->profilrs_id = 1;
                $model->mengetahui_surat = $_POST['RKSuratketeranganR']['mengetahui_surat'];
                $model->dari_ke = $_POST['RKSuratketeranganR']['dari_ke'];
                $model->kepadayth = $_POST['RKSuratketeranganR']['kepadayth'];
                $model->namapesawat = $_POST['RKSuratketeranganR']['namapesawat'];
                $tgl = $format->formatDateTimeForDb($_POST['tgl_berangkat']);
                $waktu = $_POST['waktu'];
                $model->tglberangkatpst = $tgl." ".$waktu;                
                $model->judulsurat = " SURAT JALAN AMBULANCE JEMPUT JENAZAH ";

                // untuk kendaraan
                $model->mobilambulans_id = $_POST['RKSuratketeranganR']['mobilambulans_id'];
                $model->supirambulans_id = $_POST['RKSuratketeranganR']['supirambulans_id'];
                $model->keterangan = $_POST['RKSuratketeranganR']['keterangan']; // untuk no_sim
                
                // yang bertandatangan
                $model->ygbertandatangan_id = $_POST['RKSuratketeranganR']['ygbertandatangan_id'];
                
                $model->create_time = date('Y-m-d');
                $model->update_time = date('Y-m-d');
                $model->create_loginpemakai_id = Yii::app()->user->id;
                $model->update_loginpemakai_id = Yii::app()->user->id;
                $model->create_ruangan = Yii::app()->user->getState('ruangan_id');

                if($model->validate()){
                   if($model->save()){
                      $transaction->commit();
                      $model->isNewRecord = FALSE;
                      if(!empty($_GET['pendaftaran_id'])){
                          $model->suratketerangan_id = $model->suratketerangan_id;
                      }
                   }else{
                       echo "gagal Simpan";exit;
                   } 

                    Yii::app()->user->setFlash('success',"Surat Jalan Ambulance Jemput Jenazah Di Bandara berhasil disimpan");
                    $this->redirect(array('JemputJenazah','pendaftaran_id'=>$pendaftaran_id,
                                            'suratketerangan_id'=>$model->suratketerangan_id)); 
                }  
            }
            catch (Exception $exc) 
            {
                $transaction->rollback();
                Yii::app()->user->setFlash('error',"Surat Jalan Ambulance Jemput Jenazah Di Bandara gagal disimpan ".MyExceptionMessage::getMessage($exc,true));
            }
        } 
        $this->render($this->path_view.'jemputJenazah/index',array(
                'model'=>$model,
                'modPasien'=>$modPasien,
                'modPendaftaran'=>$modPendaftaran,
        ));
    }

    public function actionPrintJemputJenazah($pendaftaran_id = null,$suratketerangan_id = null,$lama_hari = null){
        $this->layout = '//layouts/iframe';

        $modPendaftaran = RKPendaftaranT::model()->findByPk($pendaftaran_id);
        $modPasien = RKPasienM::model()->findByPk($modPendaftaran->pasien_id);
        $model = RKSuratketeranganR::model()->findByPk($suratketerangan_id);           

        $judulLaporan = '';

        $caraPrint=$_REQUEST['caraPrint'];
        if($caraPrint=='PRINT') {
            $this->layout='//layouts/printWindows';
        }
        $this->render($this->path_view.'jemputJenazah/printJemputJenazah',array(
                'modPendaftaran'=>$modPendaftaran, 
                'modPasien'=>$modPasien,
                'model'=>$model, 
                'judulLaporan'=>$judulLaporan,
                'caraPrint'=>$caraPrint));
    }
    // end Tabular Ambulans Jemput Jenazah ke Bandara
    
    // Tabular : Refraksi Mata
    public function actionRefraksiMata($pendaftaran_id = null){
        $this->layout = '//layouts/iframe';

        $format = new MyFormatter();
        $model = new RKSuratketeranganR;
        $modPasien = new RKPasienM;
        $modPendaftaran = new RKPendaftaranT;
        $model->nomorsurat = MyGenerator::noSurat(1);

        if(isset($_POST['RKSuratketeranganR']))
        {
            $pendaftaran_id = $_GET['pendaftaran_id'];
            $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
            $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
            $transaction = Yii::app()->db->beginTransaction();
            try {
                $model->attributes=$_POST['RKSuratketeranganR'];  
                $model->tglsurat= date('Y-m-d');
                $model->jenissurat_id = 1;
                $model->nourutsurat = 1;
                $model->pendaftaran_id = $pendaftaran_id;
                $model->pasien_id = $modPasien->pasien_id;
                $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
                $model->jmlprint_surat = 1;
                $model->mengetahui_surat = $_POST['RKSuratketeranganR']['mengetahui_surat'];
                $model->visummtkanan = $_POST['RKSuratketeranganR']['visummtkanan'];
                $model->visummatakiri = $_POST['RKSuratketeranganR']['visummatakiri'];
                $model->fundcopy = $_POST['RKSuratketeranganR']['fundcopy'];
                $model->butawarna = $_POST['RKSuratketeranganR']['butawarna'];
                $model->profilrs_id = 1;
                $model->judulsurat = " SURAT KETERANGAN REFRAKSI MATA ";

                $model->create_time = date('Y-m-d');
                $model->update_time = date('Y-m-d');
                $model->create_loginpemakai_id = Yii::app()->user->id;
                $model->update_loginpemakai_id = Yii::app()->user->id;
                $model->create_ruangan = Yii::app()->user->getState('ruangan_id');

                if($model->validate()){
                   if($model->save()){
                      $transaction->commit();
                      $model->isNewRecord = FALSE;
                      if(!empty($_GET['pendaftaran_id'])){
                          $model->suratketerangan_id = $model->suratketerangan_id;
                      }
                   }else{
                       echo "gagal Simpan";exit;
                   } 

                    Yii::app()->user->setFlash('success',"Surat Keterangan Refraksi Mata berhasil disimpan");
                    $this->redirect(array('RefraksiMata','pendaftaran_id'=>$pendaftaran_id,
                                            'suratketerangan_id'=>$model->suratketerangan_id)); 
                }  
            }
            catch (Exception $exc) 
            {
                $transaction->rollback();
                Yii::app()->user->setFlash('error',"Surat Keterangan Refraksi Mata gagal disimpan ".MyExceptionMessage::getMessage($exc,true));
            }
        } 
        $this->render($this->path_view.'refraksiMata/index',array(
                'model'=>$model,
                'modPasien'=>$modPasien,
                'modPendaftaran'=>$modPendaftaran,
        ));
    }

    public function actionPrintRefraksiMata($pendaftaran_id = null,$suratketerangan_id = null,$lama_hari = null){
        $this->layout = '//layouts/iframe';

        $modPendaftaran = RKPendaftaranT::model()->findByPk($pendaftaran_id);
        $modPasien = RKPasienM::model()->findByPk($modPendaftaran->pasien_id);
        $model = RKSuratketeranganR::model()->findByPk($suratketerangan_id);           

        $judulLaporan = '';

        $caraPrint=$_REQUEST['caraPrint'];
        if($caraPrint=='PRINT') {
            $this->layout='//layouts/printWindows';
        }
        $this->render($this->path_view.'refraksiMata/printRefraksiMata',array(
                'modPendaftaran'=>$modPendaftaran, 
                'modPasien'=>$modPasien,
                'model'=>$model, 
                'judulLaporan'=>$judulLaporan,
                'caraPrint'=>$caraPrint));
    }
    // end Tabular Refraksi Mata
    
    // Tabular : Pengurusan Paspor
    public function actionPengurusanPaspor($pendaftaran_id = null){
        $this->layout = '//layouts/iframe';

        $format = new MyFormatter();
        $model = new RKSuratketeranganR;
        $modPasien = new RKPasienM;
        $modPendaftaran = new RKPendaftaranT;
        $modAdmisi = new PasienadmisiT;
        $model->nomorsurat = MyGenerator::noSurat(1);

        if(isset($_POST['RKSuratketeranganR']))
        {
            $pendaftaran_id = $_GET['pendaftaran_id'];
            $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
            $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
            $transaction = Yii::app()->db->beginTransaction();
            try {
                $model->attributes=$_POST['RKSuratketeranganR'];  
                $model->tglsurat= date('Y-m-d');
                $model->jenissurat_id = 1;
                $model->nourutsurat = 1;
                $model->pendaftaran_id = $pendaftaran_id;
                $model->pasien_id = $modPasien->pasien_id;
                $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
                $model->jmlprint_surat = 1;
                $model->mengetahui_surat = $_POST['RKSuratketeranganR']['mengetahui_surat'];
                $model->tujuan_negara = $_POST['RKSuratketeranganR']['tujuan_negara'];
                $model->profilrs_id = 1;
                $model->judulsurat = " SURAT KETERANGAN PENGURUSAN PASPOR ";

                $model->create_time = date('Y-m-d');
                $model->update_time = date('Y-m-d');
                $model->create_loginpemakai_id = Yii::app()->user->id;
                $model->update_loginpemakai_id = Yii::app()->user->id;
                $model->create_ruangan = Yii::app()->user->getState('ruangan_id');

                if($model->validate()){
                   if($model->save()){
                      $transaction->commit();
                      $model->isNewRecord = FALSE;
                      if(!empty($_GET['pendaftaran_id'])){
                          $model->suratketerangan_id = $model->suratketerangan_id;
                      }
                   }else{
                       echo "gagal Simpan";exit;
                   } 

                    Yii::app()->user->setFlash('success',"Surat Keterangan Pengurusan Paspor berhasil disimpan");
                    $this->redirect(array('PengurusanPaspor','pendaftaran_id'=>$pendaftaran_id,
                                            'suratketerangan_id'=>$model->suratketerangan_id)); 
                }  
            }
            catch (Exception $exc) 
            {
                $transaction->rollback();
                Yii::app()->user->setFlash('error',"Surat Keterangan Pengurusan Paspor gagal disimpan ".MyExceptionMessage::getMessage($exc,true));
            }
        } 
        $this->render($this->path_view.'pengurusanPaspor/index',array(
                'model'=>$model,
                'modPasien'=>$modPasien,
                'modPendaftaran'=>$modPendaftaran,
                'modAdmisi'=>$modAdmisi,
        ));
    }

    public function actionPrintPengurusanPaspor($pendaftaran_id = null,$suratketerangan_id = null,$lama_hari = null){
        $this->layout = '//layouts/iframe';

        $modPendaftaran = RKPendaftaranT::model()->findByPk($pendaftaran_id);
        $modPasien = RKPasienM::model()->findByPk($modPendaftaran->pasien_id);
        $model = RKSuratketeranganR::model()->findByPk($suratketerangan_id);           

        $judulLaporan = '';

        $caraPrint=$_REQUEST['caraPrint'];
        if($caraPrint=='PRINT') {
            $this->layout='//layouts/printWindows';
        }
        $this->render($this->path_view.'pengurusanPaspor/printPengurusanPaspor',array(
                'modPendaftaran'=>$modPendaftaran, 
                'modPasien'=>$modPasien,
                'model'=>$model, 
                'judulLaporan'=>$judulLaporan,
                'caraPrint'=>$caraPrint));
    }
    // end Tabular Pengurusan Paspor
    
    public function actionDaftarPasien()
    {
        if(Yii::app()->request->isAjaxRequest) {
            $criteria = new CDbCriteria();
            $format = new MyFormatter();
            $criteria->select = 'pendaftaran_t.pendaftaran_id, pasienadmisi_t.caramasuk_id, t.pasien_id, pendaftaran_t.pasienadmisi_id, t.nama_pasien,
                                     pendaftaran_t.no_pendaftaran, pendaftaran_t.tgl_pendaftaran,jeniskelamin,no_rekam_medik,
                                     carabayar_m.carabayar_id,carabayar_m.carabayar_nama,penjaminpasien_m.penjamin_id,penjaminpasien_m.penjamin_nama,
                                     umur,jeniskasuspenyakit_m.jeniskasuspenyakit_nama,ruangan_m.ruangan_nama';
            $criteria->compare('LOWER(t.no_rekam_medik)', strtolower($_GET['term']), true);
            $criteria->limit = 5;
            
            $criteria->join ='JOIN pendaftaran_t ON t.pasien_id = pendaftaran_t.pasien_id
                            LEFT JOIN pasienadmisi_t ON pendaftaran_t.pasienadmisi_id = pasienadmisi_t.pasienadmisi_id
                            LEFT JOIN carabayar_m ON pendaftaran_t.carabayar_id = carabayar_m.carabayar_id
                            LEFT JOIN penjaminpasien_m ON pendaftaran_t.penjamin_id = penjaminpasien_m.penjamin_id
                            LEFT JOIN ruangan_m ON pendaftaran_t.ruangan_id = ruangan_m.ruangan_id
                            LEFT JOIN instalasi_m ON pendaftaran_t.instalasi_id = instalasi_m.instalasi_id
                            LEFT JOIN jeniskasuspenyakit_m ON pendaftaran_t.jeniskasuspenyakit_id = jeniskasuspenyakit_m.jeniskasuspenyakit_id';
            $criteria->order = 'pendaftaran_t.tgl_pendaftaran DESC';
            //kembalikan format
            
                $models = RKPasienM::model()->findAll($criteria);
            foreach($models as $i=>$model)
            {
                $attributes = $model->attributeNames();
                foreach($attributes as $j=>$attribute) {
                    $returnVal[$i]["$attribute"] = $model->$attribute;
                    
                }
                $returnVal[$i]['label'] = $model->no_rekam_medik.' - '.$model->nama_pasien.' - '.$model->no_pendaftaran.' - '.$model->tgl_pendaftaran; //.' - '.$model->statusperiksa
                $returnVal[$i]['value'] = $model->no_rekam_medik;
                $returnVal[$i]['jeniskelamin'] = $model->jeniskelamin;
                $returnVal[$i]['namapasien'] = $model->nama_pasien;
                $returnVal[$i]['namabin'] = $model->nama_bin;
                $returnVal[$i]['jeniskasuspenyakit'] = $model->jeniskasuspenyakit_nama;
                $returnVal[$i]['namainstalasi'] = $model->instalasi_nama;
                $returnVal[$i]['namaruangan'] = $model->ruangan_nama;
                $returnVal[$i]['carabayar_nama'] = $model->carabayar_nama;
                $returnVal[$i]['penjamin_nama'] = $model->penjamin_nama;
                $returnVal[$i]['no_pendaftaran'] = $model->no_pendaftaran;
                $returnVal[$i]['tgl_pendaftaran'] = $format->formatDateTimeForUser($model->tgl_pendaftaran);
                $returnVal[$i]['pendaftaran_id'] = $model->pendaftaran_id;
                $returnVal[$i]['pasienadmisi_id'] = $model->pasienadmisi_id;
                $returnVal[$i]['caramasuk_id'] = $model->caramasuk_id;
                $returnVal[$i]['umur'] = $model->umur;
                $returnVal[$i]['jeniskasuspenyakit_nama'] = $model->jeniskasuspenyakit_nama;
                //cari tanggungan penjamin
                $criteria = new CDbCriteria();
				if(!empty($model->penjamin_id)){
					$criteria->addCondition("pendaftaran_t.penjamin_id = ".$model->penjamin_id);			
				}
				if(!empty($model->kelaspelayanan_id)){
					$criteria->addCondition("pendaftaran_t.kelaspelayanan_id = ".$model->kelaspelayanan_id);			
				}
				if(!empty($model->carabayar_id)){
					$criteria->addCondition("pendaftaran_t.carabayar_id = ".$model->carabayar_id);			
				}
            }

            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }
    
    public function terbilang($x, $style=4, $strcomma=",") {
        if ($x < 0) {
            $result = "minus " . trim($this->ctword($x));
        } else {
            $arrnum = explode("$strcomma", $x);
            $arrcount = count($arrnum);
            if ($arrcount == 1) {
                $result = trim($this->ctword($x));
            } else if ($arrcount > 1) {
                $result = trim($this->ctword($arrnum[0])) . " koma " . trim($this->ctword($arrnum[1]));
            }
        }
        switch ($style) {
            case 1: //1=uppercase  dan
                $result = strtoupper($result);
                break;
            case 2: //2= lowercase
                $result = strtolower($result);
                break;
            case 3: //3= uppercase on first letter for each word
                $result = ucwords($result);
                break;
            default: //4= uppercase on first letter
                $result = ucfirst($result);
                break;
        }
        return $result;
    }

    public function ctword($x) {
        $x = abs($x);
        $number = array("", "satu", "dua", "tiga", "empat", "lima",
            "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
        $temp = "";

        if ($x < 12) {
            $temp = " " . $number[$x];
        } else if ($x < 20) {
            $temp = $this->ctword($x - 10) . " belas";
        } else if ($x < 100) {
            $temp = $this->ctword($x / 10) . " puluh" . $this->ctword($x % 10);
        } else if ($x < 200) {
            $temp = " seratus" . $this->ctword($x - 100);
        } else if ($x < 1000) {
            $temp = $this->ctword($x / 100) . " ratus" . $this->ctword($x % 100);
        } else if ($x < 2000) {
            $temp = " seribu" . $this->ctword($x - 1000);
        } else if ($x < 1000000) {
            $temp = $this->ctword($x / 1000) . " ribu" . $this->ctword($x % 1000);
        } else if ($x < 1000000000) {
            $temp = $this->ctword($x / 1000000) . " juta" . $this->ctword($x % 1000000);
        } else if ($x < 1000000000000) {
            $temp = $this->ctword($x / 1000000000) . " milyar" . $this->ctword(fmod($x, 1000000000));
        } else if ($x < 1000000000000000) {
            $temp = $this->ctword($x / 1000000000000) . " trilyun" . $this->ctword(fmod($x, 1000000000000));
        }
        return $temp;
    }
}
?>
