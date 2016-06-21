<?php

class PasienRawatInapController extends MyAuthController
{
	/**
   * @return array action filters
   */
	public $successSave; 
	public $successUpdateMasukKamar= false; 
	public $successPasienPulang= false; 
	public $successUpdatePendaftaran= false; 
	public $successUpdatePasienAdmisi= false; 
	public $successRujukanKeluar= true; 
	public $successPaseinM= true; 
	public $successSaveTindakanKomponen = true;
	public $successSaveTindakan;
        
  public function actionIndex()
  {
           
        $this->pageTitle = Yii::app()->name." - Pasien Rawat Inap";
        $format = new MyFormatter();
        $model = new RIInfopasienmasukkamarV;
        $model->tgl_awal  = date('Y-m-d', time() - (3600 * 24 * 60));
        $model->tgl_akhir = date('Y-m-d');
        $model->ceklis = true;

        if(isset ($_REQUEST['RIInfopasienmasukkamarV'])){
            $model->attributes=$_REQUEST['RIInfopasienmasukkamarV'];
            $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['RIInfopasienmasukkamarV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['RIInfopasienmasukkamarV']['tgl_akhir']);
            //$model->ceklis = $_REQUEST['RIInfopasienmasukkamarV']['ceklis'];
       }
       
        $this->render('index',array('model'=>$model,'format'=>$format));
  }

public function actionTerimaDokumen() {
    if (Yii::app()->request->isAjaxRequest) {
        $pendaftaran = $_POST['pendaftaran_id'];
        $pengirimanrm_id = $_POST['pengirimanrm_id'];
      
        $model = PendaftaranT::model()->findByPk($pendaftaran);
        if(!empty($pengirimanrm_id)) {
            $modPenerimaanRm = PengirimanrmT::model()->findByPk($pengirimanrm_id);      
            $modPenerimaanRm->tglterimadokrm = date('Y-m-d H:i:s');
            $modPenerimaanRm->petugaspenerima_id = Yii::app()->user->id;
            $modPenerimaanRm->ruanganpenerima_id = Yii::app()->user->getState('ruangan_id');
            if($modPenerimaanRm->save()){
                    $model->statusdokrm = 'SUDAH DITERIMA';
                    $model->save();
                    $update = true;
            }else{
                    $update = false;
            }
        }
        
        if($update == true)
        {
                $status = 'proses_form';
                $div = "<div class='flash-success'>Data Dokumen Pasien <b></b> berhasil diterima </div>";
        }else{
                $status = 'proses_form';
                $div = "<div class='flash-error'>Data Dokumen Pasien <b></b> gagal diterima </div>";
        }

        echo CJSON::encode(array(
                'status'=>$status, 
                'div'=>$div,
                ));
        exit;   
    }
}

public function actionKirimDokumen($pengirimanrm_id,$pendaftaran_id){
        $this->layout='//layouts/iframe';
        $format = new MyFormatter();
        $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
        $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
        $status = false;
        if(!empty($pengirimanrm_id)){
                $modPengirimanRm = PengirimanrmT::model()->findByPk($pengirimanrm_id);
        }else{
                $modPengirimanRm = new PengirimanrmT();
        }			

        $modUbahStatus = new PengirimanrmT;
        $modUbahStatus->tglpengirimanrm = date('d/m/Y H:i:s');

        if(isset($_POST['PengirimanrmT']))
        {
                $transaction = Yii::app()->db->beginTransaction();
                try 
                {
                        $modUbahStatus->attributes = $_POST['PengirimanrmT'];
                        $modUbahStatus->pendaftaran_id = $modPendaftaran->pendaftaran_id;
                        $modUbahStatus->pasien_id = $modPendaftaran->pasien_id;
                        $modUbahStatus->dokrekammedis_id = isset($modPengirimanRm) ? $modPengirimanRm->dokrekammedis_id : null;
                        $modUbahStatus->nourut_keluar = MyGenerator::noUrutKeluarRM();
                        $modUbahStatus->tglpengirimanrm = $format->formatDateTimeForDb($_POST['PengirimanrmT']['tglpengirimanrm']);
                        $modUbahStatus->kelengkapandokumen = TRUE;
                        $modUbahStatus->petugaspengirim_id = $_POST['PengirimanrmT']['petugaspengirim_id'];
                        $modUbahStatus->create_time = date('Y-m-d H:i:s');
                        $modUbahStatus->create_loginpemakai_id = Yii::app()->user->id;
                        $modUbahStatus->create_ruangan = Yii::app()->user->getState('ruangan_id');
                        $modUbahStatus->ruanganpengirim_id = Yii::app()->user->getState('ruangan_id');

                        if($modUbahStatus->save())
                        {
                                $modPendaftaran->statusdokrm = 'SUDAH DIKIRIM';
                                $modPendaftaran->save();

                                $transaction->commit();
                                $status = true;
                                Yii::app()->user->setFlash('success', "Data pengiriman dokumen pasien berhasil disimpan !");
                        }else{
                                $status = false;
                                Yii::app()->user->setFlash('error', '<strong>Gagal</strong> Data pengiriman dokumen pasien gagal disimpan');
                        }
                }catch(Exception $exc) {
                        $transaction->rollback();
                        $status = false;
                        Yii::app()->user->setFlash('error', '<strong>Gagal</strong> Data Gagal disimpan'.MyExceptionMessage::getMessage($exc));
                }                  
        }

        $this->render('_formStatusDokumen', array(
                'modPendaftaran'=>$modPendaftaran,
                'modPasien'=>$modPasien,
                'modPengirimanRm'=>$modPengirimanRm,
                'modUbahStatus'=>$modUbahStatus,
                'status'=>$status
        ));            
}
  
  public function actionPrint($id = null)
         {
            //$this->layout='//layouts/iframe';
                
    //  $modPendaftaran = RJPendaftaranT::model()->with('carabayar','penjamin')->findByPk($id);
            $modPendaftaran = PendaftaranT::model()->findByPk($id);
                   $modRincian = RIRinciantagihanpasienriV::model()->findAllByAttributes(array('pendaftaran_id' => $id), array('order'=>'ruangan_id'));
           
             
              $modAdmisi = PasienadmisiT::model()->findByPk($modPendaftaran->pasienadmisi_id);
//            $modPendaftaran->tgl_admisi = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($modPendaftaran->tgl_admisi, 'yyyy-MM-dd hh:mm:ss'));
          //  $modRincian = RIRinciantagihanpasienriV::model()->findAllByAttributes(array('pendaftaran_id' => $id), array('order'=>'ruangan_id'));
            $data['nama_pegawai'] = LoginpemakaiK::model()->findByPK(Yii::app()->user->id)->pegawai->nama_pegawai;
           
             $judulLaporan='Data Rincian';
             $caraPrint=$_REQUEST['caraPrint'];
             
            if($caraPrint=='PRINT')
                {
                    $this->layout='//layouts/printWindows';
                    $this->render('rawatInap.views.pasienRawatInap/detailRincian', array('modPendaftaran'=>$modPendaftaran, 
                        'modRincian'=>$modRincian, 
                        
                       // 'modPasien'=>$modPasien, 
                        'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint
                        ));
                }
            else if($caraPrint=='EXCEL')    
                {
                    $this->layout='//layouts/printExcel';
                    $this->render('rawatInap.views.pasienRawatInap/detailRincian', array('modPendaftaran'=>$modPendaftaran, 
                       'modRincian'=>$modRincian, 
                      //  'modPasien'=>$modPasien,
                        'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint
                       ));
                }
            else if($_REQUEST['caraPrint']=='PDF')
                {
                   
                    $ukuranKertasPDF=Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
                    $posisi=Yii::app()->user->getState('rawatInap.views.daftarPasien/detailRincian');                            //Posisi L->Landscape,P->Portait
                    $mpdf=new MyPDF('',$ukuranKertasPDF); 
                    $mpdf->useOddEven = 2;  
                    $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
                    $mpdf->WriteHTML($stylesheet,1);  
                    $mpdf->AddPage($posisi,'','','','',15,15,15,15,15,15);
                    $mpdf->WriteHTML($this->renderPartial('pasienRawatInap/detailRincian', array('modPendaftaran'=>$modPendaftaran,  'modRincian'=>$modRincian, 
                      
                       // 'modPasien'=>$modPasien,
                        'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint),true));
                    $mpdf->Output();
                }                       
         }

  public function actionRincian($id){
      $this->layout = '//layouts/iframe';
      $data['judulLaporan'] = 'Rincian Tagihan Pasien';
      $modPendaftaran = PendaftaranT::model()->findByPk($id);
      $modAdmisi = PasienadmisiT::model()->findByPk($modPendaftaran->pasienadmisi_id);
//            $modPendaftaran->tgl_admisi = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($modPendaftaran->tgl_admisi, 'yyyy-MM-dd hh:mm:ss'));
      $modRincian = RIRinciantagihanpasienriV::model()->findAllByAttributes(array('pendaftaran_id' => $id), array('order'=>'ruangan_id'));
      $data['nama_pegawai'] = LoginpemakaiK::model()->findByPK(Yii::app()->user->id)->pegawai->nama_pegawai;
//            $modRincian->pendaftaran_id = $id;
      $this->render('rincian', array('modPendaftaran'=>$modPendaftaran, 'modAdmisi'=>$modAdmisi, 'modRincian'=>$modRincian, 'data'=>$data));
     }
//        public function actionRincian($id){
//            $this->layout = '//layouts/iframe';
//            $data['judulLaporan'] = 'Rincian Tagihan Pasien';
//            $modPendaftaran = RJPendaftaranT::model()->findByPk($id);
//            $modRincian = RJRinciantagihanpasienV::model()->findAllByAttributes(array('pendaftaran_id' => $id), array('order'=>'ruangan_id'));
//            $data['nama_pegawai'] = LoginpemakaiK::model()->findByPK(Yii::app()->user->id)->pegawai->nama_pegawai;
////            $modRincian->pendaftaran_id = $id;
//            $this->render('/rinciantagihanpasienV.rincian', array('modPendaftaran'=>$modPendaftaran, 'modRincian'=>$modRincian, 'data'=>$data));
//        }
       
        public function actionTindakLanjutDariPasienRI($pendaftaran_id)
  {
                $this->layout='//layouts/iframe';
               
                $modelPulang = new RIPasienPulangT;
                $modRujukanKeluar = new RIPasienDirujukKeluarT;
                $modPendaftaran = RIPendaftaranT::model()->findByAttributes(array('pendaftaran_id'=>$pendaftaran_id));
                $modPasienRIV = RIInfopasienmasukkamarV::model()->findByAttributes(array('pendaftaran_id'=>$pendaftaran_id));
                $modTariftindakan = TariftindakanM::model()->findByAttributes(array('kelaspelayanan_id'=>$modPasienRIV->kelaspelayanan_id));
                $modMasukKamar = RIMasukKamarT::model()->findByPk($modPasienRIV->masukkamar_id);
                $modPasienKirimUnit = PasienkirimkeunitlainT::model()->findAllByAttributes(array('pendaftaran_id'=>$pendaftaran_id,'pasienmasukpenunjang_id'=>null));
                $modelPulang->pendaftaran_id=$modPasienRIV->pendaftaran_id;
                $modelPulang->pasien_id=$modPasienRIV->pasien_id;
                $modelPulang->pasienadmisi_id=$modPasienRIV->pasienadmisi_id;
                $modMasukKamar->tglkeluarkamar = date('Y-m-d');
                $modMasukKamar->jamkeluarkamar = date('H:i:s');
                $modelPulang->tglpasienpulang = date('Y-m-d H:i:s');
                $modRujukanKeluar->ruanganasal_id = Yii::app()->user->getState('ruangan_id');
                $modRujukanKeluar->tgldirujuk=date('Y-m-d H:i:s');
                $tersimpan='Tidak';
                $modelPulang->keterangankeluar = null;

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
                $smspasien = 1;

                $format = new MyFormatter();
                //Hitung lama rawat                
                $modMasukKamar->tglmasukkamar = $format->formatDateTimeForDb($modMasukKamar->tglmasukkamar);
                $selisihHari = CustomFunction::hitungHari($modMasukKamar->tglmasukkamar);
				
				//Hitung hari rawat
                $selisihHariRawat = CustomFunction::hitungHariRawat($modMasukKamar->tglmasukkamar);
                
                $modMasukKamar->lamadirawat_kamar=$selisihHari;
                $modelPulang->hariperawatan=$selisihHariRawat;
                
                 
//                if(empty($modPasienRIV->kamarruangan_nokamar)){ 
////                    echo "kamarruangan tidak  ada";
////                              myAlert('Silahkan Isi No. Kamar Terlebih Dahulu');
//                    echo "<script>
//                                window.top.location.href='".Yii::app()->createUrl('rawatInap/PasienRawatInap/index')."';
//                            </script>";
//                }else{
////                    echo "kamarruangan ada";
//                }
                if(isset($_POST['RIPasienPulangT'])) 
                {
                    $transaction = Yii::app()->db->beginTransaction();
                    try{
                          $modMasukKamar = RIMasukKamarT::model()->findByPk($_POST['RIMasukKamarT']['masukkamar_id']);
                          $this->updateMasukKamar($modMasukKamar,$_POST['RIMasukKamarT']);
                          if(!isset($modTariftindakan->harga_tariftindakan)){
                            echo "<script>
                                        myAlert('Maaf, Harga Tarif Kamar Rawat Inap Belum Ada. Silahkan Hubungi Bagian Administrasi');
                                        window.location.href('".Yii::app()->createUrl('/PasienRawatInap/index')."');
                                    </script>";
                            }else{
//                                echo "<script>
//                                            myAlert('Harga Tarif Kamar Rawat Inap Ada');
//                                        </script>";
                                $modelPulang = $this->savePasienPulang($modMasukKamar,$modelPulang,$_POST['RIPasienPulangT'],$_POST['RIPasienPulangT']['pasienadmisi_id']);
                            }
							
							
                          $modPendaftaran = RIPendaftaranT::model()->findByPk($modelPulang->pendaftaran_id);
                          $this->updatePendaftaran($modPendaftaran,$modelPulang);
                      
                          $modPasienAdmisi = RIPasienAdmisiT::model()->findByPk($modelPulang->pasienadmisi_id);
                          $this->updatePasienAdmisi($modPasienAdmisi, $modelPulang);
                          /*
                          if(Yii::app()->user->getState('akomodasiotomatis') == true){ 
								if(PasienRawatInapController::cekAkomodasiHariIni($modPendaftaran, $modPasienAdmisi, $modMasukKamar)){  
									  $this->saveAkomodasi($modPendaftaran, $modPasienAdmisi, $modMasukKamar->lamadirawat_kamar);
								}else{
									Yii::app()->user->setFlash('error',"Biaya akomodasi pasien gagal tersimpan. Silahkan cek tarif akomodasi!");
								}
                          }          
                           * 
                           */           
                          
                            if(isset($_POST['pakeRujukan']) && $_POST['pakeRujukan']=='1')//Jika Pake Rujukan
                            {
                                $this->successRujukanKeluar=false;
                                $modelPulang->pakeRujukan = true;
                                $modRujukanKeluar = $this->saveRujukanKeluar($modRujukanKeluar,$modelPulang,$_POST['RIPasienDirujukKeluarT']);
                            }
							
                            if(isset($_POST['isDead']) && $_POST['isDead']=='1')//Jika Pasien Meninggal
                            {
                                $modelPulang->isDead;
                                $this->successPaseinM=false;
                                $modPasien = RIPasienM::model()->findByPk($modelPulang->pasien_id);
                                $modPasien->tgl_meninggal = $format->formatDateTimeForDb($_POST['RIPasienPulangT']['tgl_meninggal']);
                                 
                                if($modPasien->save()){
                                    $this->successPaseinM=true;
                                }else{
                                    $this->successPaseinM=false;
                                }
                            }
                            
                            $this->updateSEPPulang($modPendaftaran, $modelPulang);
				
                            // die;
                            
                         if($this->successUpdateMasukKamar && $this->successPasienPulang
                            && $this->successUpdatePendaftaran && $this->successUpdatePasienAdmisi
                            && $this->successRujukanKeluar && $this->successPaseinM){
                             // SMS GATEWAY
                            $modPasien = $modPendaftaran->pasien;
                            $modCaraKeluar = $modelPulang->carakeluar;
                            $modKondisiKeluar = $modelPulang->kondisikeluar;
                            /*
                            $sms = new Sms();
                            foreach ($modSmsgateway as $i => $smsgateway) {
                                $isiPesan = $smsgateway->templatesms;

                                $attributes = $modPasien->getAttributes();
                                foreach($attributes as $attributes => $value){
                                    $isiPesan = str_replace("{{".$attributes."}}",$value,$isiPesan);
                                }
                                $attributes = $modCaraKeluar->getAttributes();
                                foreach($attributes as $attributes => $value){
                                    $isiPesan = str_replace("{{".$attributes."}}",$value,$isiPesan);
                                }
                                $attributes = $modKondisiKeluar->getAttributes();
                                foreach($attributes as $attributes => $value){
                                    $isiPesan = str_replace("{{".$attributes."}}",$value,$isiPesan);
                                }
                                $attributes = $modelPulang->getAttributes();
                                foreach($attributes as $attributes => $value){
                                    $isiPesan = str_replace("{{".$attributes."}}",$value,$isiPesan);
                                }
                                $isiPesan = str_replace("{{hari}}",MyFormatter::getDayName($modelPulang->tglpasienpulang),$isiPesan);
                                
                                if($smsgateway->tujuansms == Params::TUJUANSMS_PASIEN && $smsgateway->statussms){
                                    if(!empty($modPasien->no_mobile_pasien)){
                                        $sms->kirim($modPasien->no_mobile_pasien,$isiPesan);
                                    }else{
                                        $smspasien = 0;
                                    }
                                }
                            }
                             * 
                             */
                            // END SMS GATEWAY

                             $transaction->commit();
//                             echo "berhasil9";exit;
                             Yii::app()->user->setFlash('success',"Data Berhasil disimpan");
                              $tersimpan='Ya';
                            } else {
                                    if($this->successUpdateMasukKamar==false){
                                       Yii::app()->user->setFlash('error',"Data Masuk Kamar gagal disimpan");
                                    }else if($this->successPasienPulang==false){
                                       Yii::app()->user->setFlash('error',"Data Pasien Pulang gagal disimpan");
                                    }else if($this->successUpdatePendaftaran==false){
                                       Yii::app()->user->setFlash('error',"Data pendaftaran gagal disimpan");
                                    }else if($this->successUpdatePasienAdmisi==false){
                                       Yii::app()->user->setFlash('error',"Data Pasien Admisi gagal disimpan");
                                    }else if($this->successRujukanKeluar==false){
                                       Yii::app()->user->setFlash('error',"Data Rujukan Keluar gagal disimpan");
                                    }else if($this->successPaseinM==false){
                                       Yii::app()->user->setFlash('error',"Data Pasien disimpan");
                                    }
                            }  
                            
                     
                    }
                    catch(Exception $exc){
                        $transaction->rollback();
                        Yii::app()->user->setFlash('error',"Data gagal disimpan ".MyExceptionMessage::getMessage($exc,true));
                    }
                }
                
                 $modMasukKamar->tglmasukkamar = Yii::app()->dateFormatter->formatDateTime(
                                        CDateTimeParser::parse($modMasukKamar->tglmasukkamar, 'yyyy-MM-dd hh:mm:ss'));
                 $modMasukKamar->tglkeluarkamar = Yii::app()->dateFormatter->formatDateTime(
                                        CDateTimeParser::parse($modMasukKamar->tglkeluarkamar, 'yyyy-MM-dd'),'medium',false);
                 $modelPulang->tglpasienpulang = Yii::app()->dateFormatter->formatDateTime(
                                        CDateTimeParser::parse($modelPulang->tglpasienpulang, 'yyyy-MM-dd hh:mm:ss'));
                  $modRujukanKeluar->tgldirujuk = Yii::app()->dateFormatter->formatDateTime(
                                        CDateTimeParser::parse($modRujukanKeluar->tgldirujuk, 'yyyy-MM-dd hh:mm:ss'));
                  
                 $this->render('formTindakLanjutDariPasienRI',array(
                                            'modelPulang'=>$modelPulang,
                                            'modRujukanKeluar'=>$modRujukanKeluar,   
                                            'modPasienRIV'=>$modPasienRIV,
                                            'modMasukKamar'=>$modMasukKamar,
                                            'modTariftindakan'=>$modTariftindakan,
                                            'tersimpan'=>$tersimpan,
                                            'smspasien'=>$smspasien,
                                            'modPendaftaran'=>$modPendaftaran));
  }
        
    public function updateSEPPulang($modPendaftaran, $modelPulang) {
        $bpjs = new Bpjs;
        $sep = SepT::model()->findByPk($modPendaftaran->sep_id);
        
        if (empty($sep)) return false;
        
        $noSep = $sep->nosep;
        $ppk = substr($noSep, 0, 8);
        $tglPulang = $modelPulang->tglpasienpulang;
             
        // var_dump(json_decode($bpjs->update_tanggal_pulang_sep($noSep, $tglPulang, $ppk)));
        
        // var_dump($noSep, $ppk, $tglPulang, $modelPulang->attributes);
        // var_dump($modPendaftaran->attributes);
    }
  
    public function actionTindakLanjutDrTransaksi($id = null)
    {
       $modelPulang = new RIPasienPulangT;
       $modRujukanKeluar = new RIPasienDirujukKeluarT;
       // $modPasienRIV = new RIPasienRawatInapV;
       //$modInfoPasien = new RIInfopasienmasukkamarV;
       $modPasienRIV = new RIInfopasienmasukkamarV;
       $modMasukKamar = new RIMasukKamarT;
       $modelPulang->keterangankeluar = null;
       $modMasukKamar->tglkeluarkamar = date('Y-m-d');
       $modMasukKamar->jamkeluarkamar = date('H:i:s');
       $modelPulang->tglpasienpulang = date('Y-m-d H:i:s');
       $modRujukanKeluar->ruanganasal_id = Yii::app()->user->getState('ruangan_id');
       $tersimpan='Tidak';
       $modPendaftaran = new RIPendaftaranT;

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
			 
			$modPasienRIV->unsetAttributes();  
			if(isset($_GET['RIInfopasienmasukkamarV'])){
               $modPasienRIV->attributes = $_GET['RIInfopasienmasukkamarV'];
			}
			
			if(!empty($id)){
				$modelPulang = RIPasienPulangT::model()->findByPk($id);
				$modMasukKamar = RIMasukKamarT::model()->findByAttributes(array('pasienadmisi_id'=>$modelPulang->pasienadmisi_id));
			}
			 
             
             
		if(isset($_POST['RIPasienPulangT'])) 
		{
			$transaction = Yii::app()->db->beginTransaction();
			try{
				  $modMasukKamar = RIMasukKamarT::model()->findByPk($_POST['RIMasukKamarT']['masukkamar_id']);
				  $this->updateMasukKamar($modMasukKamar,$_POST['RIMasukKamarT']);

					$modelPulang = $this->savePasienPulang(
						$modMasukKamar, $modelPulang, $_POST['RIPasienPulangT'], $_POST['RIPasienPulangT']['pasienadmisi_id']
					);

				  $modPendaftaran = RIPendaftaranT::model()->findByPk($modelPulang->pendaftaran_id);
				  $this->updatePendaftaran($modPendaftaran,$modelPulang);

				  $modPasienAdmisi = RIPasienAdmisiT::model()->findByPk($modelPulang->pasienadmisi_id);
				  $this->updatePasienAdmisi($modPasienAdmisi, $modelPulang);


					if(isset($_POST['pakeRujukan']) && $_POST['pakeRujukan']=='1')//Jika Pake Rujukan
					{
						$this->successRujukanKeluar=false;
						$modelPulang->pakeRujukan = true;
						$modRujukanKeluar = $this->saveRujukanKeluar($modRujukanKeluar,$modelPulang,$_POST['RIPasienDirujukKeluarT']);
					}

					if(isset($_POST['isDead']) && $_POST['isDead']=='1')//Jika Pasien Meninggal
					{
						$modelPulang->isDead;
						$this->successPaseinM=false;
						$modPasien = RIPasienM::model()->findByPk($modelPulang->pasien_id);
						$modPasien->tgl_meninggal = $modelPulang->tgl_meninggal;
						if($modPasien->save()){
							$this->successPaseinM=true;
						}else{
							$this->successPaseinM=false;
						}
					}
                                 $this->updateSEPPulang($modPendaftaran, $modelPulang);
				 if($this->successUpdateMasukKamar && $this->successPasienPulang
					&& $this->successUpdatePendaftaran && $this->successUpdatePasienAdmisi
					&& $this->successRujukanKeluar ){

          // SMS GATEWAY
          $modPasien = $modPendaftaran->pasien;
          $modCaraKeluar = $modelPulang->carakeluar;
          $modKondisiKeluar = $modelPulang->kondisikeluar;
          $sms = new Sms();
          $smspasien = 1;
          /*
          foreach ($modSmsgateway as $i => $smsgateway) {
              $isiPesan = $smsgateway->templatesms;

              $attributes = $modPasien->getAttributes();
              foreach($attributes as $attributes => $value){
                  $isiPesan = str_replace("{{".$attributes."}}",$value,$isiPesan);
              }
              $attributes = $modCaraKeluar->getAttributes();
              foreach($attributes as $attributes => $value){
                  $isiPesan = str_replace("{{".$attributes."}}",$value,$isiPesan);
              }
              $attributes = $modKondisiKeluar->getAttributes();
              foreach($attributes as $attributes => $value){
                  $isiPesan = str_replace("{{".$attributes."}}",$value,$isiPesan);
              }
              $attributes = $modelPulang->getAttributes();
              foreach($attributes as $attributes => $value){
                  $isiPesan = str_replace("{{".$attributes."}}",$value,$isiPesan);
              }
              $isiPesan = str_replace("{{hari}}",MyFormatter::getDayName($modelPulang->tglpasienpulang),$isiPesan);
              
              if($smsgateway->tujuansms == Params::TUJUANSMS_PASIEN && $smsgateway->statussms){
                  if(!empty($modPasien->no_mobile_pasien)){
                      $sms->kirim($modPasien->no_mobile_pasien,$isiPesan);
                  }else{
                      $smspasien = 0;
                  }
              }
          }
           * 
           */
          // END SMS GATEWAY

					$transaction->commit();
					$tersimpan='Ya';
					Yii::app()->user->setFlash('success',"Data Berhasil disimpan");                            
					$this->redirect(array('TindakLanjutDrTransaksi','id'=>$modelPulang->pasienpulang_id,'sukses'=>$tersimpan,'smspasien'=>$smspasien));
				}else{
					if($this->successUpdateMasukKamar==false){
					   Yii::app()->user->setFlash('error',"Data Masuk Kamar gagal disimpan");
					}else if($this->successPasienPulang==false){
					   Yii::app()->user->setFlash('error',"Data Pasien Pulang gagal disimpan");
					}else if($this->successUpdatePendaftaran==false){
					   Yii::app()->user->setFlash('error',"Data pendaftaran gagal disimpan");
					}else if($this->successUpdatePasienAdmisi==false){
					   Yii::app()->user->setFlash('error',"Data Pasien Admisi gagal disimpan");
					}else if($this->successRujukanKeluar==false){
					   Yii::app()->user->setFlash('error',"Data Rujukan Keluar gagal disimpan");
					}else if($this->successPaseinM==false){
					   Yii::app()->user->setFlash('error',"Data Pasien disimpan");
					}
				}  
			}
			catch(Exception $exc){
				$transaction->rollback();
				Yii::app()->user->setFlash('error',"Data gagal disimpan ".MyExceptionMessage::getMessage($exc,true));
			}
		}


		 $modMasukKamar->tglmasukkamar = Yii::app()->dateFormatter->formatDateTime(
								CDateTimeParser::parse($modMasukKamar->tglmasukkamar, 'yyyy-MM-dd hh:mm:ss'));
		 $modMasukKamar->tglkeluarkamar = Yii::app()->dateFormatter->formatDateTime(
								CDateTimeParser::parse($modMasukKamar->tglkeluarkamar, 'yyyy-MM-dd'),'medium',false);
		 $modelPulang->tglpasienpulang = Yii::app()->dateFormatter->formatDateTime(
								CDateTimeParser::parse($modelPulang->tglpasienpulang, 'yyyy-MM-dd hh:mm:ss'));
		 $modRujukanKeluar->tgldirujuk = Yii::app()->dateFormatter->formatDateTime(
                                        CDateTimeParser::parse($modRujukanKeluar->tgldirujuk, 'yyyy-MM-dd hh:mm:ss'));
		$this->render('formTindakLanjutDariPasienRI',array(
					'modelPulang'=>$modelPulang,
					'modRujukanKeluar'=>$modRujukanKeluar,   
					'modPasienRIV'=>$modPasienRIV,
					'modMasukKamar'=>$modMasukKamar,
					'tersimpan'=>$tersimpan,
					'modPendaftaran'=>$modPendaftaran));
  }
        
        protected function saveRujukanKeluar($modRujukanKeluar,$modelPulang,$attrRujukanKeluar)
        {
            $format = new MyFormatter();
            $modRujukanKeluarNew = new RIPasienDirujukKeluarT;
            $modRujukanKeluarNew->attributes = $attrRujukanKeluar;
            $modMasukKamar->tgldirujuk = $format->formatDateTimeForDb(trim($attrRujukanKeluar['tgldirujuk']));
            $modRujukanKeluarNew->pendaftaran_id = $modelPulang->pendaftaran_id;
            $modRujukanKeluarNew->pasien_id = $modelPulang->pasien_id;
            $modRujukanKeluarNew->create_time = date( 'Y-m-d H:i:s');
            $modRujukanKeluarNew->create_ruangan = Yii::app()->user->getState('ruangan_id');
            $modRujukanKeluarNew->create_loginpemakai_id = Yii::app()->user->id;
            if($modRujukanKeluarNew->save()){
                $this->successRujukanKeluar = true;
            }else{
                $this->successRujukanKeluar = false;
            }
            return $modRujukanKeluarNew;
        }
        
        protected function updateMasukKamar($modMasukKamar,$attrMasukKamar)
        {
            $format = new MyFormatter();
            $modMasukKamar->attributes = $attrMasukKamar;
            $modMasukKamar->tglmasukkamar = $format->formatDateTimeForDb(trim($attrMasukKamar['tglmasukkamar']));
            $modMasukKamar->tglkeluarkamar  = $format->formatDateTimeForDb(trim($attrMasukKamar['tglkeluarkamar']).' '.$attrMasukKamar['jamkeluarkamar']);
            if($modMasukKamar->save()){
                $this->successUpdateMasukKamar= true; 
            }else{
                $this->successUpdateMasukKamar= false; 
            }
        }
            
        protected function updatePendaftaran($modPendaftaran,$modelPulang)
        {
            if(isset($_POST['RIPendaftaranT']['tglrenkontrol']) && $_POST['RIPendaftaranT']['tglrenkontrol'] != null ){
                $format = new MyFormatter();
                $tglrenkontrol = $format->formatDateTimeForDb($_POST['RIPendaftaranT']['tglrenkontrol']);
                $kontrolruangan = $_POST['RIPendaftaranT']['ruangankontrol_id'];
            }else{
                $tglrenkontrol = null;
                $kontrolruangan = null;
            }
            
            $daftar = PendaftaranT::model()->updateByPk(
                $modelPulang->pendaftaran_id,
                array(
                    'tglselesaiperiksa'=>date('Y-m-d H:i:s'),
                    'pasienpulang_id'=>$modelPulang->pasienpulang_id,
                    'tglrenkontrol'=>$tglrenkontrol,
                    'statusperiksa'=>Params::STATUSPERIKSA_SUDAH_PULANG,
                    'ruangankontrol_id'=>$kontrolruangan,
                )
            );
            
            if (!empty($kontrolruangan)) {
                $this->simpanSKKontrol($modPendaftaran, $kontrolruangan);
            }
            
//            $modPendaftaran->tglselesaiperiksa = date( 'Y-m-d H:i:s');
//            $modPendaftaran->pasienpulang_id = $modelPulang->pasienpulang_id;
            if($daftar){
                $this->successUpdatePendaftaran = true; 
                return $modPendaftaran;
            }else{
                $this->successUpdatePendaftaran = false; 
            }
            
        }    
        
         protected function updatePasienAdmisi($modPasienAdmisi,$modelPulang)
        {
            $modPasienAdmisi->pasienpulang_id = $modelPulang->pasienpulang_id;
            $modPasienAdmisi->tglpulang = $modelPulang->tglpasienpulang;
            $admisi = PasienadmisiT::model()->updateByPk($modPasienAdmisi->pasienadmisi_id, array("tglpulang"=>$modPasienAdmisi->tglpulang, "pasienpulang_id"=>$modPasienAdmisi->pasienpulang_id));
            if($admisi){
                $this->successUpdatePasienAdmisi = true; 
            }else{
                $this->successUpdatePasienAdmisi = false; 
            }
            
            return $modPasienAdmisi;
        }
        
        protected function simpanSKKontrol($modPendaftaran, $kontrolruangan) {
            $admisi = PasienadmisiT::model()->findByPk($modPendaftaran->pasienadmisi_id);
            
            $sk = new SuratketeranganR();
            $sk->pendaftaran_id = $modPendaftaran->pendaftaran_id;
            $sk->jenissurat_id = Params::SURAT_KETERANGAN_KONTROL;
            $sk->pasien_id = $modPendaftaran->pasien_id;
            $sk->ruangan_id = $kontrolruangan;
            $sk->profilrs_id = Yii::app()->user->getState('profilrs_id');
            $sk->tglsurat = date('Y-m-d');
            $sk->judulsurat = "SURAT RENCANA KONTROL PASIEN";
            $sk->nourutsurat = 1;
            $sk->nomorsurat = MyGenerator::noSurat(Params::SURAT_KETERANGAN_KONTROL);
            $sk->mengetahui_surat = $admisi->pegawai->namaLengkap;
            
            $sk->save();
        }
    
        protected function savePasienPulang($modMasukKamar,$modPasienPulang,$attrPasienPulang,$pasienadmisi_id='')
        {
            $format = new MyFormatter();
            $modelPulangNew = new RIPasienPulangT;
            $modelPulangNew->attributes = $attrPasienPulang;
            $modelPulangNew->carakeluar_id = $attrPasienPulang['carakeluar_id'];
            $modelPulangNew->kondisikeluar_id = $attrPasienPulang['kondisikeluar_id'];
            $modelPulangNew->tglpasienpulang = $format->formatDateTimeForDb(trim($attrPasienPulang['tglpasienpulang']));
            $modelPulangNew->tgl_meninggal = (isset($attrPasienPulang['tgl_meninggal']) ? $format->formatDateTimeForDb(trim($attrPasienPulang['tgl_meninggal'])) : null);
            $modelPulangNew->lamarawat=$modMasukKamar->lamadirawat_kamar;
            $modelPulangNew->satuanlamarawat =Params::SATUAN_LAMARAWAT_RI;
            $modelPulangNew->ruanganakhir_id = Yii::app()->user->getState('ruangan_id');
            $modelPulangNew->create_time = date( 'Y-m-d H:i:s');
            $modelPulangNew->update_time = date( 'Y-m-d H:i:s');
            $modelPulangNew->create_ruangan = Yii::app()->user->getState('ruangan_id');
            $modelPulangNew->create_loginpemakai_id = Yii::app()->user->id;
            $modelPulangNew->update_loginpemakai_id = Yii::app()->user->id;
            $modelPulangNew->pasienadmisi_id =$pasienadmisi_id;
            
            if(isset($attrPasienPulang['tgl_meninggal'])){
                $modelPulangNew->ismeninggal = true;
            }else{
                $modelPulangNew->ismeninggal = false;
            }
            
            $masukKamar = MasukkamarT::model()->findByAttributes(
                array(
                    'pasienadmisi_id'=>$pasienadmisi_id,
                    'pindahkamar_id'=>null
                )
            );
            
            // die;
           if($modelPulangNew->validate()){
               if($modelPulangNew->save()){      
//                   ini digunakan untuk mengupdate masukkamar ruangan_id=>menjadi null dan kamarruangan_m  status menjadi true
                $kamarruangan_status = true;
                $keterangan_kamar = 'OPEN';
                $modBookingkamar = BookingkamarT::model()->findByAttributes(array('kamarruangan_id'=>$masukKamar->kamarruangan_id, 'statuskonfirmasi'=>'SUDAH KONFIRMASI', 'pasienadmisi_id'=>null));
                if(count($modBookingkamar)>0){ 
                  $kamarruangan_status = false;
                  $keterangan_kamar = 'BOOKING';
                }
				$ukamarruangan = true;
                if(!empty($masukKamar->kamarruangan_id)){
					$ukamarruangan = KamarruanganM::model()->updateByPk(
						$masukKamar->kamarruangan_id,
						array(
							'kamarruangan_status'=>$kamarruangan_status,
							'keterangan_kamar'=>$keterangan_kamar
						)
					);
				}
                // $umasukkamar = MasukkamarT::model()->updateByPk($masukKamar->masukkamar_id, array('kamarruangan_id'=>null));
                if($ukamarruangan || $umasukkamar){
                    $this->successPasienPulang = true;
                }
                
                
            }else{ 
                $this->successPasienPulang = false;
            }
        }
        
            return $modelPulangNew;
        }

        public function actionPindahKamarDariTransaksi()
  {
            
            $format = new MyFormatter;
            $modPindahKamar = new RIPindahkamarT;
            $modPasienRIV = new RIPasienRawatInapV;
            $modMasukKamar = new RIMasukKamarT;

            $modPindahKamar->tglpindahkamar = date('Y-m-d');
            $modPindahKamar->jampindahkamar = date('H:i:s');
            $tersimpan = 'Tidak';

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
            $smspasien = 1;

            $modPasienRIV->unsetAttributes();  
             if(isset($_GET['RIPasienRawatInapV'])){
               $modPasienRIV->attributes = $_GET['RIPasienRawatInapV'];
             }

            if(isset($_POST['RIPindahkamarT']))
            {
                if($_POST['RIPindahkamarT']['pendaftaran_id'] == '')
                {
                    Yii::app()->user->setFlash('error',"Pendaftaran masih kosong coba cek lagi");
                    $this->refresh();
                }else{
                    $modPindahKamar->attributes = $_POST['RIPindahkamarT'];
                    $pendaftaran_id = ((isset($_POST['RIPindahkamarT']['pendaftaran_id'])) ? $_POST['RIPindahkamarT']['pendaftaran_id'] : null);
                    $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);

                    $modPasienRIV = RIPasienRawatInapV::model()->findByAttributes(
                        array(
                            'pasienadmisi_id'=>$modPendaftaran->pasienadmisi_id
                        )
                    );

                    /* PASIEN MASUK KAMAR LAMA*/
                    $modMasukKamar = RIMasukKamarT::model()->findByPk(
                        $modPindahKamar->masukkamar_id
                    );

                    /* PASIEN ADMISI*/
                    $modPasienAdmisi = RIPasienAdmisiT::model()->findByPK(
                        $modPindahKamar->pasienadmisi_id
                    );

                    /* END PASIEN ADMISI*/

                    $modPindahKamar->pasien_id = $modPasienRIV->pasien_id;
                    $modPindahKamar->pendaftaran_id = $modPasienRIV->pendaftaran_id;
                    $modPindahKamar->pasienadmisi_id = $modPasienRIV->pasienadmisi_id;
                    $modPindahKamar->masukkamar_id = null;
                    $modPindahKamar->shift_id = Yii::app()->user->getState('shift_id'); 
                    $modPindahKamar->nopindahkamar = MyGenerator::noMasukKamar($modPindahKamar->ruangan_id);
                    $modPindahKamar->carabayar_id = $modPasienAdmisi->carabayar_id;
                    $modPindahKamar->penjamin_id = $modPasienAdmisi->penjamin_id;
                    $modPindahKamar->pegawai_id = $modPasienAdmisi->pegawai_id;


                    /* PROSES SIMPAN DAN UPDATE */
                    $transaction = Yii::app()->db->beginTransaction();
                    $is_simpan = false;
                    $errors = array();
                    $pesan = array(
                        'status'=>'success',
                        'text'=>'Data Berhasil Disimpan'
                    );
                    try {
                        /* simpan_pindah_kamar */
                        
                        $isSimpanPindahKamar=false;
                        if($modPindahKamar->save()){
                          $isSimpanPindahKamar=true;
                        };
						if(!empty($modPasienAdmisi->kamarruangan_id)){
							KamarruanganM::model()->updateByPk(
								$modPasienAdmisi->kamarruangan_id, array('kamarruangan_status'=>true,'keterangan_kamar'=>'OPEN')
							);
						}
                        
                        /* update_masuk_kamar lama*/
                        $modMasukKamar->pindahkamar_id = $modPindahKamar->pindahkamar_id;
                        if($modMasukKamar->save())
                        {
                            /* update_pasien_admisi */
                            $is_simpan = true;
                            $modPasienAdmisi->ruangan_id = $modPindahKamar->ruangan_id;
                            $modPasienAdmisi->kelaspelayanan_id = $modPindahKamar->kelaspelayanan_id;
                            $modPasienAdmisi->kamarruangan_id = !empty($modPindahKamar->kamarruangan_id) ? $modPindahKamar->kamarruangan_id : null;
							if($modPasienAdmisi->save())
							{
								/* simpan_masuk_kamar_new */
								$is_simpan = true;
								$mod_masuk_kamar = new RIMasukKamarT();
								$mod_masuk_kamar->attributes = $modPindahKamar->attributes; //mengambil nilai ruangan_id, 
								$mod_masuk_kamar->pindahkamar_id = null; //karena record baru asumsi belum pernah pindah
								$mod_masuk_kamar->masukkamar_id = null; //record baru
								$mod_masuk_kamar->nomasukkamar = MyGenerator::noMasukKamar(Yii::app()->user->getState('ruangan_id')); 
								$mod_masuk_kamar->tglmasukkamar = $modPindahKamar->tglpindahkamar; 
								$mod_masuk_kamar->jammasukkamar = $modPindahKamar->jampindahkamar; 
								$mod_masuk_kamar->kelaspelayanan_id = empty($modPindahKamar->kelaspelayanan_id) ?  $modMasukKamar->kelaspelayanan_id : $modPindahKamar->kelaspelayanan_id; 
								$mod_masuk_kamar->create_time = date('Y-m-d H:i:s'); 
								$mod_masuk_kamar->create_loginpemakai_id = Yii::app()->user->id; 
								$mod_masuk_kamar->create_ruangan = Yii::app()->user->getState('ruangan_id'); 
								$mod_masuk_kamar->kamarruangan_id = !empty($modPindahKamar->kamarruangan_id) ? $modPindahKamar->kamarruangan_id : null;
								if($mod_masuk_kamar->save())
								{
									$is_simpan = true;

									/* update_kamar_ruangan */
									if(!empty($modPindahKamar->kamarruangan_id)){
										KamarruanganM::model()->updateByPk(
											$modPindahKamar->kamarruangan_id, array('kamarruangan_status'=>false,'keterangan_kamar'=>'IN USE')
										);
									}
								}else{
									$is_simpan = false;
									$pesan = array(
										'status'=>'error',
										'text'=>'Data Masuk Kamar Gagal Disimpan'
									);
									$errors[] = $pesan;
								}
							}else{
								$is_simpan = false;
								$pesan = array(
									'status'=>'error',
									'text'=>'Data Admisi Gagal Disimpan'
								);
								$errors[] = $pesan;                                    
							}
                        }else{
                            $is_simpan = false;
                            $pesan = array(
                                'status'=>'error',
                                'text'=>'Data Masuk Kamar Gagal Disimpan'
                            );
                            $errors[] = $pesan;                                
                        }

                        if($is_simpan&&$isSimpanPindahKamar)
                        {

                            // SMS GATEWAY
                            $modPasien = $modPasienAdmisi->pasien;
                            $modRuangan = $modPasienAdmisi->ruangan;
                            $modKamarRuangan = $modPasienAdmisi->kamarruangan;
                            $modKelaspelayanan = $modPasienAdmisi->kelaspelayanan;
                            $sms = new Sms();
                            foreach ($modSmsgateway as $i => $smsgateway) {
                                $isiPesan = $smsgateway->templatesms;

                                $attributes = $modPasien->getAttributes();
                                foreach($attributes as $attributes => $value){
                                    $isiPesan = str_replace("{{".$attributes."}}",$value,$isiPesan);
                                }
                                $attributes = $modRuangan->getAttributes();
                                foreach($attributes as $attributes => $value){
                                    $isiPesan = str_replace("{{".$attributes."}}",$value,$isiPesan);
                                }
                                $attributes = $modKelaspelayanan->getAttributes();
                                foreach($attributes as $attributes => $value){
                                    $isiPesan = str_replace("{{".$attributes."}}",$value,$isiPesan);
                                }
                                $attributes = $modKamarRuangan->getAttributes();
                                foreach($attributes as $attributes => $value){
                                    $isiPesan = str_replace("{{".$attributes."}}",$value,$isiPesan);
                                }
                                $attributes = $modPindahKamar->getAttributes();
                                foreach($attributes as $attributes => $value){
                                    $isiPesan = str_replace("{{".$attributes."}}",$value,$isiPesan);
                                }
                                $isiPesan = str_replace("{{hari}}",MyFormatter::getDayName($modPindahKamar->tglpindahkamar),$isiPesan);

        
                                if($smsgateway->tujuansms == Params::TUJUANSMS_PASIEN && $smsgateway->statussms){
                                    if(!empty($modPasien->no_mobile_pasien)){
                                        $sms->kirim($modPasien->no_mobile_pasien,$isiPesan);
                                    }else{
                                        $smspasien = 0;
                                    }
                                }
                            }
                            // END SMS GATEWAY

                            $tersimpan = 'Ya';
                            $transaction->commit();
                            Yii::app()->user->setFlash($pesan['status'],$pesan['text']);
                        }else{
                            foreach($errors as $val)
                            {
                                Yii::app()->user->setFlash($val['status'],$val['text']);
                            }
                            $transaction->rollback();
                        }

                    } catch (Exception $exc)
                    {
                        $transaction->rollback();
                        Yii::app()->user->setFlash('error',"Data gagal disimpan" . MyExceptionMessage::getMessage($exc,true));
                    }
                }
             }

             $this->render(
                'formPindahKamar',
                 array(
                    'modPindahKamar'=>$modPindahKamar,
                    'modPasienRIV'=>$modPasienRIV,
                    'tersimpan'=>$tersimpan,
                    'modMasukKamar'=>$modMasukKamar,
                    'smspasien'=>$smspasien
                 )
             );
  }
        
	public function actionPindahKamarPasienRI($pendaftaran_id)
	{
            $this->layout='//layouts/iframe';
            $format = new MyFormatter();
            $modPindahKamar = new RIPindahkamarT;
            $modPasienAdmisi = new RIPasienAdmisiT;
            $modPasienPulang = new RIPasienPulangT;
			$modMasukKamar = new RIMasukKamarT;
            $modTindakan = null;

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
            $smspasien = 1;
            
            $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
            $modPasienRIV = RIPasienRawatInapV::model()->findByAttributes(
                array('pasienadmisi_id'=>$modPendaftaran->pasienadmisi_id)
            );
            $modMasukKamar = RIMasukKamarT::model()->findByPk(
                $modPasienRIV->masukkamar_id
            );
            
            $modPindahKamar->pasien_id=$modPasienRIV->pasien_id;
            $modPindahKamar->pendaftaran_id=$modPasienRIV->pendaftaran_id;
            $modPindahKamar->pasienadmisi_id=$modPasienRIV->pasienadmisi_id;
            $modPindahKamar->masukkamar_id=$modPasienRIV->masukkamar_id;
            $modPindahKamar->kamarruangan_id = !empty($modPasienRIV->kamarruangan_id) ? $modPasienRIV->kamarruangan_id : null;
            $modPindahKamar->pegawai_id = $modPendaftaran->pegawai_id;
            $modPindahKamar->carabayar_id = $modPendaftaran->carabayar_id;
            $modPindahKamar->ruangan_id = $modPendaftaran->ruangan_id;
            $modPindahKamar->penjamin_id = $modPendaftaran->penjamin_id;
            $modPindahKamar->kelaspelayanan_id = $modPasienRIV->kelaspelayanan_id;
            $modPindahKamar->jampindahkamar=date('H:i:s');
            $modPindahKamar->shift_id = Yii::app()->user->getState('shift_id'); 
            $modPindahKamar->nopindahkamar = MyGenerator::noMasukKamar($modPindahKamar->ruangan_id);
            $modPindahKamar->tglpindahkamar = date('d M Y');
            
            $tersimpan = 'Tidak';
            if(isset($_POST['RIPindahkamarT']))
            {
                if($_POST['RIPindahkamarT']['pendaftaran_id'] == '')
                {
                    Yii::app()->user->setFlash('error',"Pendaftaran masih kosong coba cek lagi");
                    $this->refresh();
                }else{
                    $modPindahKamar->attributes = $_POST['RIPindahkamarT'];
                    $modPindahKamar->tglpindahkamar = $format->formatDateTimeForDb($_POST['RIPindahkamarT']['tglpindahkamar'])." ".$modPindahKamar->jampindahkamar;
                    $pendaftaran_id = ((isset($_POST['RIPindahkamarT']['pendaftaran_id'])) ? $_POST['RIPindahkamarT']['pendaftaran_id'] : null);
                    $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);

                    $modPasienRIV = RIPasienRawatInapV::model()->findByAttributes(
                        array(
                            'pasienadmisi_id'=>$modPendaftaran->pasienadmisi_id
                        )
                    );

                    /* PASIEN MASUK KAMAR LAMA*/
                    $modMasukKamar = RIMasukKamarT::model()->findByPk(
                        $modPindahKamar->masukkamar_id
                    );

                    /* PASIEN ADMISI*/
                    $modPasienAdmisi = RIPasienAdmisiT::model()->findByPK(
                        $modPindahKamar->pasienadmisi_id
                    );

                    /* END PASIEN ADMISI*/

                    $modPindahKamar->pasien_id = $modPasienRIV->pasien_id;
                    $modPindahKamar->pendaftaran_id = $modPasienRIV->pendaftaran_id;
                    $modPindahKamar->pasienadmisi_id = $modPasienRIV->pasienadmisi_id;
                    $modPindahKamar->shift_id = Yii::app()->user->getState('shift_id'); 
                    $modPindahKamar->nopindahkamar = MyGenerator::noPindahKamar($modPindahKamar->ruangan_id);
                    $modPindahKamar->carabayar_id = $modPasienAdmisi->carabayar_id;
                    $modPindahKamar->penjamin_id = $modPasienAdmisi->penjamin_id;
                    $modPindahKamar->pegawai_id = $modPasienAdmisi->pegawai_id;
                    
                    //die;

                    /* PROSES SIMPAN DAN UPDATE */
                    $transaction = Yii::app()->db->beginTransaction();
                    $is_simpan = false;
                    $errors = array();
                    $pesan = array(
                        'status'=>'success',
                        'text'=>'Data Berhasil Disimpan'
                    );
                    
                    
                    /* PROSES PINDAH DOKUMEN RM */
                    $dokrm = PengirimanrmT::model()->findByAttributes(array(
                        'pendaftaran_id'=>$modPasienRIV->pendaftaran_id,
                        'ruangan_id'=>Yii::app()->user->getState('ruangan_id'),
                    ), array(
                        'order'=>'pengirimanrm_id desc',
                    ));
                    if (!empty($dokrm)) {
                        $doknew = new PengirimanrmT();
                        //$doknew->attributes = $dokrm->attributes;
                        $doknew->pengirimanrm_id = null;
                        $doknew->pasien_id = $dokrm->pasien_id;
                        $doknew->pendaftaran_id = $dokrm->pendaftaran_id;
                        $doknew->ruanganpengirim_id = $dokrm->ruangan_id;
                        $doknew->dokrekammedis_id = $dokrm->dokrekammedis_id;
                        $doknew->ruangan_id = $modPindahKamar->ruangan_id;
                        $doknew->nourut_keluar = MyGenerator::noUrutKeluarRM();
                        $doknew->tglpengirimanrm = $modPindahKamar->tglpindahkamar;
                        $doknew->kelengkapandokumen = true;
                    
                        $lp = LoginpemakaiK::model()->findByPk(Yii::app()->user->id);
                        if (!empty($lp->pegawai_id)) {
                            $pegawai = PegawaiM::model()->findByPk($lp->pegawai_id);
                            $doknew->petugaspengirim = $pegawai->nama_pegawai;
                        }


                        $doknew->validate();
                    }
                    
                    try {
                        /* simpan_pindah_kamar */
                        // var_dump($modPindahKamar->attributes); die;
                        $modPindahKamar->masukkamar_id = null; //ini di isi masukkamar baru nanti
                        if($modPindahKamar->save()){
                            $modMasukKamar->pindahkamar_id = $modPindahKamar->pindahkamar_id;
                        }else{
                            $modMasukKamar->pindahkamar_id = null;
                        }
						
                        if(!empty($modPasienAdmisi->kamarruangan_id)){
							KamarruanganM::model()->updateByPk(
								$modPasienAdmisi->kamarruangan_id, array('kamarruangan_status'=>true,'keterangan_kamar'=>'OPEN')
							);
						}

                        /* update_masuk_kamar lama*/
                        if($modMasukKamar->save())
                        {
                            /* update_pasien_admisi */
                            $is_simpan = true;
                            $modPasienAdmisi->ruangan_id = $modPindahKamar->ruangan_id;
                            $modPasienAdmisi->kelaspelayanan_id = $modPindahKamar->kelaspelayanan_id;
                            $modPasienAdmisi->kamarruangan_id = !empty($modPindahKamar->kamarruangan_id) ? $modPindahKamar->kamarruangan_id : null;
                            if($modPasienAdmisi->save())
                            {
                                /* simpan_masuk_kamar_new */
                                $is_simpan = true;
								$mod_masuk_kamar = new RIMasukKamarT();
								$mod_masuk_kamar->attributes = $modPindahKamar->attributes; //mengambil nilai ruangan_id, 
								$mod_masuk_kamar->pindahkamar_id = null; //karena record baru asumsi belum pernah pindah
								$mod_masuk_kamar->masukkamar_id = null; //record baru
								$mod_masuk_kamar->nomasukkamar = MyGenerator::noMasukKamar(Yii::app()->user->getState('ruangan_id')); 
								$mod_masuk_kamar->tglmasukkamar = $modPindahKamar->tglpindahkamar; 
								$mod_masuk_kamar->jammasukkamar = $modPindahKamar->jampindahkamar; 
								$mod_masuk_kamar->kelaspelayanan_id = empty($modPindahKamar->kelaspelayanan_id) ?  $modMasukKamar->kelaspelayanan_id : $modPindahKamar->kelaspelayanan_id; 
								$mod_masuk_kamar->create_time = date('Y-m-d H:i:s'); 
								$mod_masuk_kamar->create_loginpemakai_id = Yii::app()->user->id; 
								$mod_masuk_kamar->create_ruangan = Yii::app()->user->getState('ruangan_id'); 
								$mod_masuk_kamar->kamarruangan_id = !empty($modPindahKamar->kamarruangan_id) ? $modPindahKamar->kamarruangan_id : null;

								if($mod_masuk_kamar->save())
								{
									$is_simpan = true;
                                                                        if (!empty($dokrm)) {
                                                                            $doknew->save();
                                                                        }
                                                                        //var_dump($doknew->save()); die;
									//update masukkamar_id (baru) pada pindahkamar_t
									$modPindahKamar->updateByPk($modPindahKamar->pindahkamar_id, array('masukkamar_id'=>$mod_masuk_kamar->masukkamar_id)); 
									if(!empty($modPindahKamar->kamarruangan_id)){
										/* update_kamar_ruangan */
										KamarruanganM::model()->updateByPk(
											$modPindahKamar->kamarruangan_id, array('kamarruangan_status'=>false,'keterangan_kamar'=>'IN USE')
										);
									}
                                                                        
								}else{
									$is_simpan = false;
									$pesan = array(
										'status'=>'error',
										'text'=>'Data Masuk Kamar Gagal Disimpan'
									);
									$errors[] = $pesan;
								}
                            }else{
                                $is_simpan = false;
                                $pesan = array(
                                    'status'=>'error',
                                    'text'=>'Data Admisi Gagal Disimpan'
                                );
                                $errors[] = $pesan;                                    
                            }
                        }else{
                            $is_simpan = false;
                            $pesan = array(
                                'status'=>'error',
                                'text'=>'Data Masuk Kamar Gagal Disimpan'
                            );
                            $errors[] = $pesan;                                
                        }
                        
                        self::saveAkomodasi($modPendaftaran, $modPasienAdmisi);

                        if($is_simpan)
                        {
                            $tersimpan = 'Ya';

                            // SMS GATEWAY
                            /*
                            $modPasien = $modPasienAdmisi->pasien;
                            $modRuangan = $modPasienAdmisi->ruangan;
                            $modKamarRuangan = $modPasienAdmisi->kamarruangan;
                            $modKelaspelayanan = $modPasienAdmisi->kelaspelayanan;
                            $sms = new Sms();
                            foreach ($modSmsgateway as $i => $smsgateway) {
                                $isiPesan = $smsgateway->templatesms;

                                $attributes = $modPasien->getAttributes();
                                foreach($attributes as $attributes => $value){
                                    $isiPesan = str_replace("{{".$attributes."}}",$value,$isiPesan);
                                }
                                $attributes = $modRuangan->getAttributes();
                                foreach($attributes as $attributes => $value){
                                    $isiPesan = str_replace("{{".$attributes."}}",$value,$isiPesan);
                                }
                                $attributes = $modKelaspelayanan->getAttributes();
                                foreach($attributes as $attributes => $value){
                                    $isiPesan = str_replace("{{".$attributes."}}",$value,$isiPesan);
                                }
								if($modKamarRuangan){
									$attributes = $modKamarRuangan->getAttributes();
									foreach($attributes as $attributes => $value){
										$isiPesan = str_replace("{{".$attributes."}}",$value,$isiPesan);
									}
								}
                                $attributes = $modPindahKamar->getAttributes();
                                foreach($attributes as $attributes => $value){
                                    $isiPesan = str_replace("{{".$attributes."}}",$value,$isiPesan);
                                }
                                $isiPesan = str_replace("{{hari}}",MyFormatter::getDayName($modPindahKamar->tglpindahkamar),$isiPesan);

        
                                if($smsgateway->tujuansms == Params::TUJUANSMS_PASIEN && $smsgateway->statussms){
                                    if(!empty($modPasien->no_mobile_pasien)){
                                        $sms->kirim($modPasien->no_mobile_pasien,$isiPesan);
                                    }else{
                                        $smspasien = 0;
                                    }
                                }
                            }
                             * 
                             */
                            // END SMS GATEWAY

                            $transaction->commit();
                            Yii::app()->user->setFlash($pesan['status'],$pesan['text']);
                        }else{
                            foreach($errors as $val)
                            {
                                Yii::app()->user->setFlash($val['status'],$val['text']);
                            }
                            $transaction->rollback();
                        }

                    } catch (Exception $exc)
                    {
                        $transaction->rollback();
                        Yii::app()->user->setFlash('error',"Data gagal disimpan" . MyExceptionMessage::getMessage($exc,true));
                    }
                }
             }            
            $this->render(
                'formPindahKamar',
                array(
                    'modPindahKamar'=>$modPindahKamar,
                    'modPasienRIV'=>$modPasienRIV,
                    'modMasukKamar'=>$modMasukKamar,
                    'modTindakan'=>$modTindakan,
                    'tersimpan'=>$tersimpan,
                    'is_grid'=>true,
                    'smspasien'=>$smspasien
                )
            );
  }
        
        public static function cekAkomodasiHariIni($modPendaftaran, $modPasienAdmisi, $modMasukKamar){
            $akomodasi = PasienRawatInapController::tindakanAkomodasi($modMasukKamar->kelaspelayanan_id,$modMasukKamar->penjamin_id,$modPasienAdmisi->ruangan_id);
            if($akomodasi){
				$tipePaket = PasienRawatInapController::tipePaketAkomodasi($modPendaftaran, $modPasienAdmisi, $akomodasi->daftartindakan_id);
				$criteria = new CdbCriteria();
				$criteria->addCondition('pendaftaran_id = '.$modPasienAdmisi->pendaftaran_id);
				$criteria->addCondition('pasienadmisi_id = '.$modPasienAdmisi->pasienadmisi_id);
				$criteria->addCondition('ruangan_id = '.Yii::app()->user->getState('ruangan_id'));
				$criteria->addCondition('kelaspelayanan_id = '.$modMasukKamar->kelaspelayanan_id);
				$criteria->addCondition('tipepaket_id = '.$tipePaket);
				$criteria->addBetweenCondition('tgl_tindakan',date('Y-m-d')." 00:00:00",date('Y-m-d')." 23:59:59");
				$modAkomodasi = TindakanpelayananT::model()->findAll($criteria);
				if(count($modAkomodasi) == 0){
					return true;
				}else{
					return false;
				}
			}else{
				return false;
			}
        }
        
        public static function saveAkomodasi($modPendaftaran, $modPasienAdmisi)
        {
            $ok = self::hapusTindakanAkomodasiTanpaMasukKamar($modPasienAdmisi);
            $masuk = MasukkamarT::model()->findAllByAttributes(array(
                'pasienadmisi_id'=>$modPasienAdmisi->pasienadmisi_id,
            ), array(
                'order'=>'masukkamar_id asc',
            ));
            
            $downer = 0;
            foreach ($masuk as $idx=>$item) {
                //var_dump($item->tglmasukkamar." ".$item->kelaspelayanan->kelaspelayanan_nama." ".$item->kelaspelayanan->urutankelas);
                $next = !empty($masuk[$idx+1])?$masuk[$idx+1]:null;
                $selisih = 0;
                if (!empty($next)) {
                    if ($item->kelaspelayanan->urutankelas > $next->kelaspelayanan->urutankelas) {
                        $selisih = (CustomFunction::hitungHari($item->tglmasukkamar, $next->tglmasukkamar) + 1);
                        $downer = -1;
                    } else {
                        $selisih = (CustomFunction::hitungHari($item->tglmasukkamar, $next->tglmasukkamar) - 1);
                        $downer = 0;
                    }
                } else {
                    $selisih = (CustomFunction::hitungHari($item->tglmasukkamar) + 1 + $downer);
                }
                
                //var_dump($selisih);
                
                // var_dump($item->attributes);
                //$next = !empty($masuk[$idx+1])?$masuk[$idx+1]:null;
                if ($selisih > 0) $ok = $ok && self::simpanAkomodasiInap($modPasienAdmisi, $masuk[$idx], $selisih);
            }
            
            // var_dump($ok); die;
            
            return $ok;
            
            
            /*
            //echo $lamaRawat; die;
            $cekTindakanKomponen=0;
            $modMasukKamar = InfopasienmasukkamarV::model()->findByAttributes(array(
                'pendaftaran_id'=>$modPasienAdmisi->pendaftaran_id,
                'pasienadmisi_id'=>$modPasienAdmisi->pasienadmisi_id,
                'ruangan_id'=>Yii::app()->user->getState('ruangan_id'),
            ));
            if($modMasukKamar){ //REPLACE kelaspelayanan_id
                $modPasienAdmisi->kelaspelayanan_id = $modMasukKamar->kelaspelayanan_id;
            }
            $akomodasi = PasienRawatInapController::tindakanAkomodasi($modPasienAdmisi->kelaspelayanan_id,$modPasienAdmisi->penjamin_id,$modPasienAdmisi->ruangan_id); 
            
             $modTindakanPelayan = TindakanpelayananT::model()->findByAttributes(array('pendaftaran_id'=>$modPasienAdmisi->pendaftaran_id,'pasienadmisi_id'=>$modPasienAdmisi->pasienadmisi_id, 'ruangan_id'=>Yii::app()->user->getState('ruangan_id'),'kelaspelayanan_id'=>$modPasienAdmisi->kelaspelayanan_id));
             
            if (empty($modTindakanPelayan)){
                         $modTindakanPelayan = New TindakanpelayananT;
                         $modTindakanPelayan->tgl_tindakan = date('Y-m-d H:i:s');
            }
            else {          
                         $modTindakanPelayan = TindakanpelayananT::model()->findByAttributes(array('pendaftaran_id'=>$modPasienAdmisi->pendaftaran_id,'pasienadmisi_id'=>$modPasienAdmisi->pasienadmisi_id, 'ruangan_id'=>Yii::app()->user->getState('ruangan_id'),'kelaspelayanan_id'=>$modPasienAdmisi->kelaspelayanan_id));
                             
            }
                             
            $modTindakanPelayan->penjamin_id = $modPasienAdmisi->penjamin_id;
            $modTindakanPelayan->pasien_id = $modPasienAdmisi->pasien_id;
            $modTindakanPelayan->pasienadmisi_id = $modPasienAdmisi->pasienadmisi_id;
            $modTindakanPelayan->kelaspelayanan_id = $modPasienAdmisi->kelaspelayanan_id;
            $modTindakanPelayan->instalasi_id = Yii::app()->user->getState('instalasi_id');
            $modTindakanPelayan->pendaftaran_id = $modPasienAdmisi->pendaftaran_id;
            $modTindakanPelayan->shift_id = Yii::app()->user->getState('shift_id');
            $modTindakanPelayan->daftartindakan_id = (isset($akomodasi->daftartindakan_id) ? $akomodasi->daftartindakan_id:"");
            $modTindakanPelayan->carabayar_id = $modPasienAdmisi->carabayar_id;
            $modTindakanPelayan->jeniskasuspenyakit_id = $modPendaftaran->jeniskasuspenyakit_id;
            
            $modTindakanPelayan->tarif_satuan = (isset($akomodasi->harga_tariftindakan) ? $akomodasi->harga_tariftindakan:"");
            $modTindakanPelayan->qty_tindakan = $lamaRawat;
            $modTindakanPelayan->tarif_tindakan = $modTindakanPelayan->tarif_satuan * $modTindakanPelayan->qty_tindakan;
            $modTindakanPelayan->satuantindakan = Params::SATUAN_TINDAKAN_PENDAFTARAN;
            $modTindakanPelayan->cyto_tindakan = 0;
            $modTindakanPelayan->tarifcyto_tindakan = 0;
            $modTindakanPelayan->dokterpemeriksa1_id = NULL;
            $modTindakanPelayan->discount_tindakan = 0;
            $modTindakanPelayan->subsidiasuransi_tindakan = 0;
            $modTindakanPelayan->subsidipemerintah_tindakan = 0;
            $modTindakanPelayan->subsisidirumahsakit_tindakan = 0;
            $modTindakanPelayan->iurbiaya_tindakan=0;
            $modTindakanPelayan->pembebasan_tindakan=0;
            $modTindakanPelayan->ruangan_id = Yii::app()->user->getState('ruangan_id');
            $modTindakanPelayan->tipepaket_id = PasienRawatInapController::tipePaketAkomodasi($modPendaftaran, $modPasienAdmisi, $modTindakanPelayan->daftartindakan_id);
            $modTindakanPelayan->create_time = date('Y-m-d H:i:s');
            $modTindakanPelayan->create_loginpemakai_id = Yii::app()->user->id;
            $modTindakanPelayan->create_ruangan = Yii::app()->user->getState('ruangan_id');
			$modTindakanPelayan->tarif_rsakomodasi = 0;
			$modTindakanPelayan->tarif_medis = 0;
			$modTindakanPelayan->tarif_paramedis = 0;
			$modTindakanPelayan->tarif_bhp = 0;
           
            if(empty($modTindakanPelayan->daftartindakan_id)){
                $kelas = KelaspelayananM::model()->findByPk($modTindakanPelayan->kelaspelayanan_id);
                    echo "<script>
                        myAlert('Tarif Akomodasi Berdasarkan Kelas ".$kelas->kelaspelayanan_nama." tidak ada ,silahkan hub administrator');
                        window.top.location.href='".Yii::app()->createUrl('rawatInap/PasienRawatInap/index')."';
                    </script>";
            }

            if($modTindakanPelayan->validate()){                   
				if($modTindakanPelayan->save()){
					if($modTindakanPelayan->saveTindakanKomponen()){
//						$this di function static tidak berfungsi / error >> $this->successSaveTindakanKomponen &= true;
					}else{
//						$this di function static tidak berfungsi / error >> $this->successSaveTindakanKomponen = false;
						echo "<script>
									myAlert('Tarif Akomodasi tidak ditemukan, silahkan input terlebih dahulu tarifnya');
									window.top.location.href='".Yii::app()->createUrl('rawatInap/PasienRawatInap/index')."';
								</script>"; 
					}
				}else{
					if (empty($akomodasi->daftartindakan_id)){
						$modTindakanPelayan->addError('error', 'Daftar Tindakan akomodasi untuk Ruangan dan Kelas Pelayanan ini tidak ditemukan');
					}
					$this->successSaveTindakan = false;
				}                    
            }
            return $modTindakanPelayan;
             * 
             */
        }
        
        public static function simpanAkomodasiInap($modPasienAdmisi, $masukkamar, $selisih) {
            // periksa tindakan pelayanan
            
            $ok = true;
            /*
            if (!empty($next)) {
                $selisih = CustomFunction::hitungHari($masukkamar->tglmasukkamar, $next->tglmasukkamar) - 1;
            } else {
                $selisih = CustomFunction::hitungHari($masukkamar->tglmasukkamar, null);
            }
             * 
             */
            
            $tindakan = TindakanpelayananT::model()->findAllByAttributes(array(
                'masukkamar_id'=>$masukkamar->masukkamar_id,
            ));
            if (empty($tindakan)) {
                $ok = $ok && self::simpanTindakanAkomodasi($modPasienAdmisi, $masukkamar, $selisih);
            } else {
                $qty = 0;
                foreach ($tindakan as $item) {
                    $qty += $item->qty_tindakan;
                }
                
                $selisih -= $qty;
                if ($selisih > 0) {
                    $ok = $ok && self::simpanTindakanAkomodasi($modPasienAdmisi, $masukkamar, $selisih);
                }
            }
            
            return $ok;
        }
        
        public static function simpanTindakanAkomodasi($modPasienAdmisi, $masukkamar, $selisih) {
            $akomodasi = PasienRawatInapController::tindakanAkomodasi($masukkamar->kelaspelayanan_id,$masukkamar->penjamin_id,$masukkamar->ruangan_id); 
            
            if(empty($akomodasi)) {
                return true;
            }
            
            $tindakan = new TindakanpelayananT;
            
            $tindakan->penjamin_id = $masukkamar->penjamin_id;
            $tindakan->pasien_id = $modPasienAdmisi->pasien_id;
            $tindakan->pasienadmisi_id = $modPasienAdmisi->pasienadmisi_id;
            $tindakan->kelaspelayanan_id = $modPasienAdmisi->kelaspelayanan_id;
            $tindakan->instalasi_id = Yii::app()->user->getState('instalasi_id');
            $tindakan->pendaftaran_id = $modPasienAdmisi->pendaftaran_id;
            $tindakan->shift_id = Yii::app()->user->getState('shift_id');
            $tindakan->daftartindakan_id = (isset($akomodasi->daftartindakan_id) ? $akomodasi->daftartindakan_id:"");
            $tindakan->carabayar_id = $modPasienAdmisi->carabayar_id;
            $tindakan->jeniskasuspenyakit_id = $modPasienAdmisi->pendaftaran->jeniskasuspenyakit_id;
            
            $tindakan->tarif_satuan = (isset($akomodasi->harga_tariftindakan) ? $akomodasi->harga_tariftindakan:"");
            $tindakan->qty_tindakan = $selisih;
            $tindakan->tarif_tindakan = $tindakan->tarif_satuan * $tindakan->qty_tindakan;
            $tindakan->satuantindakan = Params::SATUAN_TINDAKAN_PENDAFTARAN;
            $tindakan->cyto_tindakan = 0;
            $tindakan->tarifcyto_tindakan = 0;
            $tindakan->dokterpemeriksa1_id = NULL;
            $tindakan->discount_tindakan = 0;
            $tindakan->subsidiasuransi_tindakan = 0;
            $tindakan->subsidipemerintah_tindakan = 0;
            $tindakan->subsisidirumahsakit_tindakan = 0;
            $tindakan->iurbiaya_tindakan=0;
            $tindakan->pembebasan_tindakan=0;
            $tindakan->ruangan_id = Yii::app()->user->getState('ruangan_id');
            $tindakan->tipepaket_id = PasienRawatInapController::tipePaketAkomodasi($modPasienAdmisi->pendaftaran, $modPasienAdmisi, $tindakan->daftartindakan_id);
            $tindakan->create_time = date('Y-m-d H:i:s');
            $tindakan->create_loginpemakai_id = Yii::app()->user->id;
            $tindakan->create_ruangan = Yii::app()->user->getState('ruangan_id');
            $tindakan->tarif_rsakomodasi = 0;
            $tindakan->tarif_medis = 0;
            $tindakan->tarif_paramedis = 0;
            $tindakan->tarif_bhp = 0;
            $tindakan->tgl_tindakan = $masukkamar->tglmasukkamar;
            $tindakan->masukkamar_id = $masukkamar->masukkamar_id;
            
            $ok = true;
            
            if ($tindakan->validate()) {
                $ok = $ok && $tindakan->save();
                $tindakan->saveTindakanKomponen();
                
                //$komponen = TindakankomponenT::model()->findAllByAttributes(array(
                //    'tindakanpelayanan_id'=>$tindakan->tindakanpelayanan_id,
                //));
                //var_dump(count($komponen));
            } else {
                $ok = false;
            }
            
            return $ok;
            // var_dump($tindakan->attributes);
        }
        
        public static function hapusTindakanAkomodasiTanpaMasukKamar($modPasienAdmisi) {
            $dt = DaftartindakanM::model()->findAllByAttributes(array(
                'kelompoktindakan_id'=>Params::KELOMPOKTINDAKAN_ID_AKOMODASI,
                'daftartindakan_akomodasi'=>true,
                'daftartindakan_aktif'=>true,
            ), array(
                'select'=>'daftartindakan_id',
            ));
            
            $ok = true;
            // var_dump($ok);
            foreach ($dt as $item) {
                $tindakan = TindakanpelayananT::model()->findAllByAttributes(array(
                    'pendaftaran_id'=>$modPasienAdmisi->pendaftaran_id,
                    'daftartindakan_id'=>$item->daftartindakan_id,
                ), array(
                    'select'=>'tindakanpelayanan_id',
                    'condition'=>'tindakansudahbayar_id is null',
                ));
                
                foreach ($tindakan as $dat) {
                    $komponen = TindakankomponenT::model()->findAllByAttributes(array(
                        'tindakanpelayanan_id'=>$dat->tindakanpelayanan_id,
                    ));
                    if (count($komponen) != 0) {
                        $ok = $ok && TindakankomponenT::model()->deleteAllByAttributes(array(
                            'tindakanpelayanan_id'=>$dat->tindakanpelayanan_id,
                        ));
                    }
                    $ok = $ok && TindakanpelayananT::model()->deleteByPk($dat->tindakanpelayanan_id);
                }
            }
            return $ok;
        }
        
		public static function tindakanAkomodasi($kelaspelayanan_id,$penjamin_id,$ruangan_id=null)
		{
			$criteria = new CDbCriteria;
			if(!empty($ruangan_id)){
				$criteria->addCondition('ruangan_id='.$ruangan_id);
			}else{
				$criteria->addCondition('ruangan_id = '.Yii::app()->user->getState('ruangan_id'));
			}
			$criteria->addCondition('penjamin_id = '.$penjamin_id);
			$criteria->addCondition('daftartindakan_akomodasi is true');
			if(!empty($kelaspelayanan_id)){
				$criteria->addCondition("kelaspelayanan_id = ".$kelaspelayanan_id); 	
			}
			$daftarTindakan = TariftindakanperdaruanganV::model()->find($criteria);

			return $daftarTindakan;
		}

        public static function tipePaketAkomodasi($modPendaftaran, $modPasienAdmisi, $idTindakan)
        {
            $criteria = new CDbCriteria;
            $criteria->with = array('tipepaket');
			if(!empty($idTindakan)){
				$criteria->addCondition("daftartindakan_id = ".$idTindakan); 	
			}
			if(!empty($modPasienAdmisi->carabayar_id)){
				$criteria->addCondition("tipepaket.carabayar_id = ".$modPasienAdmisi->carabayar_id); 	
			}
			if(!empty($modPasienAdmisi->penjamin_id)){
				$criteria->addCondition("tipepaket.penjamin_id = ".$modPasienAdmisi->penjamin_id); 	
			}
			if(!empty($modPasienAdmisi->kelaspelayanan_id)){
				$criteria->addCondition("tipepaket.kelaspelayanan_id = ".$modPasienAdmisi->kelaspelayanan_id); 	
			}
            $modPaket = PaketpelayananM::model()->find($criteria);
            $paket = Params::TIPEPAKET_ID_NONPAKET;
            if (isset($modPaket->paket_id)){
                $paket = $modPaket->tipepaket_id;
            }
            
            return $paket;
        }
        /**
         * digunakan untuk membatalkan pasien rawat inap
         * tabel yang digunakan 
         * pendaftaran_t; pasien_m; pasienadmisi_t; jeniskasuspenyakit_m, pasienbatalrawat_r
         * @param type $pendaftaran_id type = integer  
         */
        public function actionBatalRawatInap($pendaftaran_id)
        {
             $this->layout='//layouts/iframe';
             
             $modPasienBatalRawat = new PasienbatalrawatR;
             
             $modPendaftaran    = RIPendaftaranT::model()->findByPk($pendaftaran_id); 
             $modPasien         = PasienM::model()->findByPk($modPendaftaran->pasien_id);
             $modAdmisi         = PasienadmisiT::model()->findByAttributes(array('pendaftaran_id'=>$modPendaftaran->pendaftaran_id));
             $jenisPenyakit     = JeniskasuspenyakitM::model()->findByPk($modPendaftaran->jeniskasuspenyakit_id);
//             digunakan untuk merefresh jika data berhasil di simpan
             $tersimpan='Tidak';
               
             $modPendaftaran->jeniskasuspenyakit_nama   = $jenisPenyakit->jeniskasuspenyakit_nama;
             $modPasienBatalRawat->pasienadmisi_id      = $modAdmisi->pasienadmisi_id;
             $modPasienBatalRawat->create_time          = date('Y-m-d H:i:s');
             $modPasienBatalRawat->update_time          = date('Y-m-d H:i:s');
             $modPasienBatalRawat->create_ruangan       = Yii::app()->user->getState('ruangan_id');             
             $modPasienBatalRawat->create_loginpemakai_id   = Yii::app()->user->id;
             $modPasienBatalRawat->update_loginpemakai_id   = Yii::app()->user->id;
            
             if(!empty($_REQUEST['PasienbatalrawatR'])){
                 
                 $format = new MyFormatter();
                 $modPasienBatalRawat->attributes = $_REQUEST['PasienbatalrawatR'];
                 $modPasienBatalRawat->tglbatalrawat = $format->formatDateTimeForDb($modPasienBatalRawat->tglbatalrawat);
                 $pendaftaran_id = $_POST['pendaftaran_id'];
                 $cek = PasienbatalrawatR::model()->findByAttributes(array('pasienadmisi_id'=>$modPasienBatalRawat->pasienadmisi_id));
                 $kamarRuangan = PasienadmisiT::model()->findByPk($modPasienBatalRawat->pasienadmisi_id);
                 
                 if(!empty($cek->update_time) || !empty($cek->update_loginpemakaian_id)){
                     $modPasienBatalRawat->update_time              = date('Y-m-d H:i:s');
                     $modPasienBatalRawat->update_loginpemakai_id   = date('Y-m-d H:i:s');
                 }
                 
                 if($modPasienBatalRawat->validate()){
                     $admisi_id = $modPasienBatalRawat->pasienadmisi_id;;
                     $transaction = Yii::app()->db->beginTransaction();
                     try {
                         if($modPasienBatalRawat->save()){
//                          update null terlebih dahulu kamarruangan_id di pasienadmisi                
                            
                            $modA = PasienadmisiT::model()->updateByPk($admisi_id, array('bookingkamar_id'=>null, 'kamarruangan_id'=>null, 'pendaftaran_id'=>null));       

                            // TindakanpelayananT::model()->deleteAllByAttributes(array('pendaftaran_id'=>$pendaftaran_id));
                            
                            $bookingKamar = BookingkamarT::model()->findByAttributes(array('pasienadmisi_id'=>$admisi_id));

                            $keterangan_kamar = 'OPEN';
                            $kamarruangan_status = true;
                            if($bookingKamar){
                              BookingkamarT::model()->updateByPk($bookingKamar->bookingkamar_id, array('pasienadmisi_id'=>null));
                              $keterangan_kamar = 'BOOKING';
                              $kamarruangan_status = false;
                            }

                            $ok = $this->hapusTindakanDanUpdate($modAdmisi);
                            
                            //$masukKamar = MasukkamarT::model()->findByAttributes(array('pasienadmisi_id'=>$admisi_id));
                            //if($masukKamar){
                            //   MasukkamarT::model()->deleteByPk($masukKamar->masukkamar_id);
                            //}
							if(!empty($kamarRuangan->kamarruangan_id)){
								KamarruanganM::model()->updateByPk($kamarRuangan->kamarruangan_id, array('kamarruangan_status'=>$kamarruangan_status,'keterangan_kamar'=>$keterangan_kamar));
							}
                            $pendaftaran = PendaftaranT::model()->updateByPk($pendaftaran_id, array('pasienadmisi_id'=>null,'alihstatus'=>false));
                            // $deleteAdmisi = PasienadmisiT::model()->deleteByPk($admisi_id); //RND-1592
                            
                            // hapus tindakan
                            
                            if($pendaftaran && $ok){                               
                                $transaction->commit();
                                Yii::app()->user->setFlash('success',"Data berhasil disimpan");
                                $tersimpan='Ya';                            
                            } else {
                                $transaction->rollback();
                                if (!$ok) {
                                    Yii::app()->user->setFlash('error',"Rawat Inap tidak bisa dibatalkan karena ada tindakan yang sudah dibayarkan!");
                                } else {
                                    Yii::app()->user->setFlash('error',"Data gagal disimpan");
                                }
                            }
                         }else{
                            $transaction->rollback();
                            Yii::app()->user->setFlash('error',"Data gagal disimpan");
                         }
                     } catch (Exception $exc){
                        $transaction->rollback();
                        Yii::app()->user->setFlash('error',"Data gagal disimpan", MyExceptionMessage::getMessage($exc,false));
                     }
                     
                 }else{ 
                     Yii::app()->user->setFlash('error',"Data gagal disimpan");
                 }
             }
             
             $this->render('formBatalRawatInap', array('modPendaftaran'=>$modPendaftaran, 'modPasien'=>$modPasien, 'modPasienBatalRawat'=>$modPasienBatalRawat, 'tersimpan'=>$tersimpan));
        }
        
        public function hapusTindakanDanUpdate($admisi) {
            $cr = new CDbCriteria();
            $cr->select = "count(*) as tindakanpelayanan_id";
            $cr->addCondition("tindakansudahbayar_id is not null and pasienadmisi_id = ".$admisi->pasienadmisi_id);
            $dat = TindakanpelayananT::model()->find($cr);
            $ok = true;
            if ($dat->tindakanpelayanan_id > 0) {
                echo "MK"; die;
                return false;
            } else {
                $ok = $ok && TindakanpelayananT::model()->deleteAllByAttributes(array(
                    'pasienadmisi_id'=>$admisi->pasienadmisi_id
                ));
                //var_dump($ok);
                $ok = $ok && PendaftaranT::model()->updateByPk($admisi->pendaftaran_id, array(
                    'statusperiksa'=>Params::STATUSPERIKSA_SUDAH_PULANG,
                    'pasienadmisi_id'=>null,
                )); 
                //var_dump($ok); 
                
                $pk = PindahkamarT::model()->findAllByAttributes(array(
                    'pasienadmisi_id'=>$admisi->pasienadmisi_id,
                ));
                
                if (count($pk) > 0) {
                    $ok = $ok && PindahkamarT::model()->updateAll(array(
                        'masukkamar_id'=>null,
                    ), array(
                        'condition'=>'pasienadmisi_id = '.$admisi->pasienadmisi_id,
                    )); 
                }
                //var_dump($ok);
                
                $ok = $ok && MasukkamarT::model()->deleteAllByAttributes(array(
                    'pasienadmisi_id'=>$admisi->pasienadmisi_id,
                ));
                if (count($pk) > 0) {
                    $ok = $ok && PindahkamarT::model()->deleteAllByAttributes(array(
                        'pasienadmisi_id'=>$admisi->pasienadmisi_id,
                    ));
                }
                //var_dump($ok);
                //$ok = $ok && PasienadmisiT::model()->deleteByPk($admisi->pasienadmisi_id);
                
                //var_dump($ok); die;
                return $ok;
            }
            // echo 'Kick';
            die;
        }
        
        public function actionRencanaPulangPasienRI($idPasienadmisi)
  {
             $this->layout='//layouts/iframe';
             $format = new MyFormatter;
             $model = new RIPasienAdmisiT;
             $model->rencanapulang = date('Y-m-d H:i:s');
             $tersimpan = 'Tidak';
             
             $modelAdmisi = RIPasienAdmisiT::model()->findByPk($idPasienadmisi);
             $modPasien = RIPasienM::model()->findByPk($modelAdmisi->pasien_id);
             $modPendaftaran = RIPendaftaranT::model()->findByPk($modelAdmisi->pendaftaran_id);
             
             if(isset($_POST['RIPasienAdmisiT'])){
                    $rencanapulang = $format->formatDateTimeForDb($_POST['RIPasienAdmisiT']['rencanapulang']);
                    $pasien_id = $_POST['RIPasienAdmisiT']['pasienadmisi_id'];
                    $transaction = Yii::app()->db->beginTransaction();
                  try {
                        $update = RIPasienAdmisiT::model()->updateByPk($pasien_id,array('rencanapulang'=>$rencanapulang));

                        if($update){
							$kamarUpdate = true;
                            if(!empty($modelAdmisi->kamarruangan_id)){
                                $kamarUpdate = KamarruanganM::model()->updateByPk($modelAdmisi->kamarruangan_id,array('keterangan_kamar'=>'RENCANA PULANG'));
                            }
                            if($kamarUpdate){
                                $transaction->commit();
                                Yii::app()->user->setFlash('success',"Data berhasil disimpan");
                                $tersimpan='Ya'; 
                            }else{
                                $transaction->rollback();
                                Yii::app()->user->setFlash('error',"Data gagal disimpan"); 
                                $tersimpan='Tidak'; 
                            }
                        }else{
                           $transaction->rollback();
                           Yii::app()->user->setFlash('error',"Data gagal disimpan");   
                        }
                        
//                        RND-6398
//                        $params['tglnotifikasi'] = date( 'Y-m-d H:i:s');
//                        $params['create_time'] = date( 'Y-m-d H:i:s');
//                        $params['create_loginpemakai_id'] = Yii::app()->user->id;
//                        $params['instalasi_id'] = Yii::app()->user->getState('instalasi_id');
//                        $params['modul_id'] = Yii::app()->session['modul_id'];
//                        $params['isinotifikasi'] = $modPasien->no_rekam_medik . '-' . $modPendaftaran->no_pendaftaran . '-' . $modPasien->nama_pasien;
//                        $params['create_ruangan'] = $modelAdmisi->ruangan_id;
//                        $params['judulnotifikasi'] = ($modelAdmisi->rencanapulang != null ? 'Rencana Pulang Pasien' : 'Rencana Pulang Pasien' );
//                        $nofitikasi = NotifikasiRController::insertNotifikasi($params);
                    
                   } catch (Exception $exc){
                        $transaction->rollback();
                        Yii::app()->user->setFlash('error',"Data gagal disimpan", MyExceptionMessage::getMessage($exc,false));
                   }
             }
             
             $model->rencanapulang = Yii::app()->dateFormatter->formatDateTime(
                                        CDateTimeParser::parse($model->rencanapulang, 'yyyy-MM-dd hh:mm:ss'));
             
             $this->render('formRencanaPulang',array(
                                'modelAdmisi'=>$modelAdmisi,
                                'modPasien'=>$modPasien,
                                'modPendaftaran'=>$modPendaftaran,
                                'model'=>$model,
                                'tersimpan'=>$tersimpan,
                          ));
  }
  
    /**
     * untuk load form masuk kamar pasien
     * Issue  : RND-2717
     * Date   : 24 September 2014
     */
    public function actionAddMasukKamarRI()
    {
        $pendaftaran_id = (isset(Yii::app()->session['pendaftaran_id']) ? Yii::app()->session['pendaftaran_id'] : null);
        $kamarruangan_id = (isset($_POST['kamarruangan_id']) ? $_POST['kamarruangan_id'] : null);
        $masukkamar_id = (isset(Yii::app()->session['masukkamar_id']) ? Yii::app()->session['masukkamar_id'] : null);
        $kelaspelayanan_id = (isset(Yii::app()->session['kelaspelayanan_id']) ? Yii::app()->session['kelaspelayanan_id'] : null);
        $ruangan_id = Yii::app()->user->getState('ruangan_id');
        if(isset($masukkamar_id)){
            $modMasukKamar = MasukkamarT::model()->findByPk($masukkamar_id);
        }else{
            $modMasukKamar = new MasukkamarT();
        }
        $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
        $modPasienAdmisi = PasienadmisiT::model()->findByPk($modPendaftaran->pasienadmisi_id);

        $modMasukKamar->ruangan_id = (isset($kamarruangan_id) ? $modMasukKamar->ruangan_id : $ruangan_id);
        $modMasukKamar->tglmasukkamar = date('Y-m-d H:i:s');
        $modMasukKamar->jammasukkamar = date('H:i:s');

        $modDataPasien = PasienrawatinapV::model()->findByAttributes(array('pendaftaran_id'=>$pendaftaran_id));        
        
        if(isset($_POST['MasukkamarT']))
        {
            $modMasukKamar->attributes =  $_POST['MasukkamarT'];
            $modMasukKamar->pasienadmisi_id = $modPasienAdmisi->pasienadmisi_id;
            $modMasukKamar->carabayar_id = $modPasienAdmisi->carabayar_id;
            $modMasukKamar->penjamin_id = $modPasienAdmisi->penjamin_id;
            $modMasukKamar->pegawai_id = $modPasienAdmisi->pegawai_id;
            $modMasukKamar->kelaspelayanan_id = $modPasienAdmisi->kelaspelayanan_id;
            $modMasukKamar->nomasukkamar = MyGenerator::noMasukKamar($modMasukKamar->ruangan_id);
            $modMasukKamar->shift_id = Yii::app()->user->getState('shift_id');
            $modMasukKamar->create_time = date('Y-m-d H:i:s');
            $modMasukKamar->create_loginpemakai_id = Yii::app()->user->id;
            $modMasukKamar->create_ruangan = Yii::app()->user->getState('ruangan_id');

            $kamarruanganidupdate = isset($_POST['MasukkamarT']['kamarruangan_id']) ? $_POST['MasukkamarT']['kamarruangan_id'] : null;
//            $cekidkamar = PasienadmisiT::model()->findByAttributes(array('pendaftaran_id'=>$pendaftaran_id));
            $cekidkamar = PendaftaranT::model()->findByAttributes(array('pendaftaran_id'=>$pendaftaran_id));
           if(empty($kamarruanganidupdate)){ 
                   PasienadmisiT::model()->updateByPk($cekidkamar->pasienadmisi_id, array('kamarruangan_id'=>$kamarruanganidupdate));
                   if(!empty($modDataPasien->kamarruangan_id)){
						KamarruanganM::model()->updateByPk($modDataPasien->kamarruangan_id,array('kamarruangan_status'=>true));
				   }
            } 
            if($modMasukKamar->save())
            {
				if(!empty($kamarruanganidupdate)){
					KamarruanganM::model()->updateByPk($kamarruanganidupdate, array('kamarruangan_status'=>false));
				}
                
                if (Yii::app()->request->isAjaxRequest)
                {
                    echo CJSON::encode(array(
                        'status'=>'proses_form', 
                        'div'=>"<div class='flash-success'>Data Pasien <b></b> berhasil disimpan </div>",
                        ));
                    exit;               
                }
            }
            else
            {
                
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
        if (Yii::app()->request->isAjaxRequest)
        {   

            echo CJSON::encode(array(
                'status'=>'create_form', 
                'div'=>$this->renderPartial('_formMasukKamar', array('modMasukKamar'=>$modMasukKamar,'modDataPasien'=>$modDataPasien), true)));
            exit;               
        }
    }
    
    /**
     * untuk load session masuk kamar
     */
    public function actionBuatSessionMasukKamar()
    {
        
        $kelaspelayanan_id = (isset($_POST['kelaspelayanan_id']) ? $_POST['kelaspelayanan_id'] : null);
        $pendaftaran_id = (isset($_POST['pendaftaran_id']) ? $_POST['pendaftaran_id'] : null);
        if(!empty($_POST['masukkamar_id']))
        {
            $masukkamar_id = (isset($_POST['masukkamar_id']) ? $_POST['masukkamar_id'] : null);
            Yii::app()->session['masukkamar_id'] = $masukkamar_id;
        }
        Yii::app()->session['kelaspelayanan_id'] =  $kelaspelayanan_id;
        Yii::app()->session['pendaftaran_id'] =  $pendaftaran_id;
        Yii::app()->session['masukkamar_id'] = $masukkamar_id;
        
        echo CJSON::encode(array(
                'kelaspelayanan_id'=>Yii::app()->session['kelaspelayanan_id'], 
                'pendaftaran_id'=>Yii::app()->session['pendaftaran_id'],
                'masukkamar_id'=>Yii::app()->session['masukkamar_id']));
        
    }
    
    /**
    * Mengatur dropdown kabupaten
    * @param type $encode jika = true maka return array jika false maka set Dropdown 
    * @param type $model_nama
    * @param type $attr
    */
   public function actionSetDropDownKondisiKeluar($encode=false,$model_nama='',$attr='')
   {
       if(Yii::app()->request->isAjaxRequest) {
           $model = new RIPasienPulangT;
           if($model_nama !=='' && $attr == ''){
               $carakeluar_id = $_POST["$model_nama"]['carakeluar_id'];
           }
            elseif ($model_nama == '' && $attr !== '') {
               $carakeluar_id = $_POST["$attr"];
           }
            elseif ($model_nama !== '' && $attr !== '') {
               $carakeluar_id = $_POST["$model_nama"]["$attr"];
           }
           $kondisikeluar = null;
           if($carakeluar_id){
               $kondisikeluar = $model->getKondisikeluarItems($carakeluar_id);
               $kondisikeluar = CHtml::listData($kondisikeluar,'kondisikeluar_id','kondisikeluar_nama');
           }
           if($encode){
               echo CJSON::encode($kondisikeluar);
           } else {
               if(empty($kondisikeluar)){
                   echo CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
               } else {
                   echo CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
                   foreach($kondisikeluar as $value=>$name) {
                       echo CHtml::tag('option', array('value'=>$value),CHtml::encode($name),true);
                   }
               }
           }
       }
       Yii::app()->end();
   }
   
   public function actionGetKelasPelayanan($encode=false)
    {
        if(Yii::app()->request->isAjaxRequest) {
            $ruangan_id = $_POST['ruangan_id'];
            $kelaspelayanan = array();
            if(!empty($ruangan_id)) {
                $kelasRuangan = KelasruanganM::model()->findAllByAttributes(array('ruangan_id'=>$ruangan_id));
                
                foreach ($kelasRuangan as $key => $value) {
                     $kelaspelayanan[$key] = KelaspelayananM::model()->findByPk($value->kelaspelayanan_id);
                }
                $kelaspelayanan = CHtml::listData($kelaspelayanan,'kelaspelayanan_id','kelaspelayanan_nama');
            }
            
            if($encode){
                echo CJSON::encode($kelaspelayanan);
            } else {
                if(empty($kelaspelayanan)){
                    echo CHtml::tag('option', array('value'=>''),CHtml::encode("-- Pilih --"),true);
                }else{
                    echo CHtml::tag('option', array('value'=>''),CHtml::encode("-- Pilih --"),true);
                    foreach($kelaspelayanan as $value=>$name)
                    {
                        echo CHtml::tag('option', array('value'=>$value),CHtml::encode($name),true);
                    }
                }
            }
        }
        Yii::app()->end();
    }
	
	/**
	* Mengatur dropdown kasus penyakit
	*/
	public function actionSetDropdownKasusPenyakit()
	{
		if(Yii::app()->getRequest()->getIsAjaxRequest()) {
			$pendaftaran_id = isset($_POST['pendaftaran_id']) ? $_POST['pendaftaran_id'] : null;
			$pasienadmisi_id = isset($_POST['pasienadmisi_id']) ? $_POST['pasienadmisi_id'] : null;
			$jeniskasuspenyakit_id = isset($_POST['jeniskasuspenyakit_id']) ? $_POST['jeniskasuspenyakit_id'] : null;

			$jeniskasuspenyakit = JeniskasuspenyakitM::model()->findAll('jeniskasuspenyakit_aktif = TRUE');
			$jeniskasuspenyakit = CHtml::listData($jeniskasuspenyakit,'jeniskasuspenyakit_id','jeniskasuspenyakit_nama');
			
			$jeniskasuspenyakitOptions = CHtml::dropDownList('jeniskasuspenyakit_id','', $jeniskasuspenyakit, array("onchange"=>"saveKasusPenyakit(this,$pendaftaran_id,$pasienadmisi_id)","style"=>"width:140px;","options" => array($jeniskasuspenyakit_id=>array("selected"=>true))));
			
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
			$pasienadmisi_id = isset($_POST['pasienadmisi_id']) ? $_POST['pasienadmisi_id'] : null;
			$jeniskasuspenyakit_id = isset($_POST['jeniskasuspenyakit_id']) ? $_POST['jeniskasuspenyakit_id'] : null;
			$pesan = 'gagal';
			
			$update = RIPendaftaranT::model()->updateByPk($pendaftaran_id,array('jeniskasuspenyakit_id'=>$jeniskasuspenyakit_id));
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
	   $model = new RIPendaftaranT();
	   $modAdmisi = new RIPasienAdmisiT();
	   $modUbahDokter = new RIUbahdokterR;
	   $menu = (isset($_REQUEST['menu']) ? $_REQUEST['menu'] : "");
	   if(isset($_POST['RIPendaftaranT']))
	   {
		   if($_POST['RIPendaftaranT']['pegawai_id'] != "")
		   {
				$model->attributes = $_POST['RIPendaftaranT'];
				$modUbahDokter->attributes = $_POST['RIUbahdokterR'];
				$modUbahDokter->pendaftaran_id = $_POST['RIPendaftaranT']['pendaftaran_id'];
				$modUbahDokter->dokterbaru_id = $_POST['RIPendaftaranT']['pegawai_id'];
				$modUbahDokter->tglubahdokter = date('Y-m-d H:i:s');
				$modUbahDokter->create_time = date('Y-m-d H:i:s');
				$modUbahDokter->create_loginpemakai_id = Yii::app()->user->id;
				$modUbahDokter->create_ruangan = Yii::app()->user->getState('ruangan_id');
			   $transaction = Yii::app()->db->beginTransaction();
			   try {
				   $attributes = array('pegawai_id'=>$_POST['RIPendaftaranT']['pegawai_id']);
				   $masukkamar = RIMasukKamarT::model()->findByAttributes(array('pasienadmisi_id'=>$_POST['RIPendaftaranT']['pasienadmisi_id']));
				   if(count($masukkamar) > 0){
						$save = RIMasukKamarT::model()->updateByPk($masukkamar->masukkamar_id, $attributes);
				   }else{
					   $save = $modAdmisi::model()->updateByPk($_POST['RIPendaftaranT']['pasienadmisi_id'], $attributes);
				   }
				   if($save)
				   {
					   $modUbahDokter->save();
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
			   'div'=>$this->renderPartial('_formUbahDokterPeriksa', array('model'=>$model,'modAdmisi'=>$modAdmisi,'modUbahDokter'=>$modUbahDokter,'menu'=>$menu), true)));
		   exit;               
	   }
   }

   public function actionGetDataPendaftaranRI()
   {
	   if (Yii::app()->request->isAjaxRequest){
		   $id_pendaftaran = $_POST['pendaftaran_id'];
		   $pasienadmisi_id = isset($_POST['pasienadmisi_id']) ? $_POST['pasienadmisi_id'] : null;
		   $model = InfopasienmasukkamarV::model()->findByAttributes(array('pendaftaran_id'=>$id_pendaftaran,'pasienadmisi_id'=>$pasienadmisi_id));
		   $modPasienAdmisi = PasienadmisiT::model()->findByPk($pasienadmisi_id);
		   $attributes = $model->attributeNames();
		   foreach($attributes as $j=>$attribute) {
			   $returnVal["$attribute"] = $model->$attribute;
			   $returnVal["gelarbelakang_nama"] = isset($model->gelarbelakang_nama) ? $model->gelarbelakang_nama : "";
			   $returnVal["gelardepan"] = isset($model->gelardepan) ? $model->gelardepan : "";
			   $returnVal["pegawai_id"] = isset($modPasienAdmisi->pegawai_id) ? $modPasienAdmisi->pegawai_id : null;
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
     * untuk print data penjualan dokter
     */
    public function actionPrintPasienPulang($pasienpulang_id,$caraPrint = null) 
    {
        $format = new MyFormatter;    
        $modPulang = RIPasienPulangT::model()->findByPk($pasienpulang_id);     
        $modMasukKamar = RIMasukKamarT::model()->findByAttributes(array('pasienadmisi_id'=>$modPulang->pasienadmisi_id));
        $modPasien = RIPendaftaranT::model()->findByAttributes(array('pasienadmisi_id'=>$modPulang->pasienadmisi_id));

        $judul_print = 'Pasien Pulang';
        $caraPrint = isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null;
        if (isset($_GET['frame'])){
            $this->layout='//layouts/iframe';
        }
        if($caraPrint=='PRINT') {
            $this->layout='//layouts/printWindows';
        }
        else if($caraPrint=='EXCEL') {
            $this->layout='//layouts/printExcel';
        }
        
        $this->render('Print', array(
                'format'=>$format,
                'judul_print'=>$judul_print,
                'modPulang'=>$modPulang,
                'modMasukKamar'=>$modMasukKamar,
                'modPasien'=>$modPasien
        ));
    }
    
    public function actionPrintPasienKontrol($pasienpulang_id,$caraPrint = null)
    {
        $format = new MyFormatter;    
        $modPulang = RIPasienPulangT::model()->findByPk($pasienpulang_id);     
        $modMasukKamar = RIMasukKamarT::model()->findByAttributes(array('pasienadmisi_id'=>$modPulang->pasienadmisi_id));
        $modPendaftaran = RIPendaftaranT::model()->findByAttributes(array('pasienadmisi_id'=>$modPulang->pasienadmisi_id));
        $modPasien = RIPasienM::model()->findByPk($modPendaftaran->pasien_id);
        $modAdmisi = RIPasienAdmisiT::model()->findByPk($modPendaftaran->pasienadmisi_id);
        $sk = SuratketeranganR::model()->findByAttributes(array(
            'pendaftaran_id'=>$modPendaftaran->pendaftaran_id,
            'jenissurat_id'=>Params::SURAT_KETERANGAN_KONTROL,
        ));
        
        $judul_print = 'Pasien Kontrol';
        $caraPrint = isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null;
        if (isset($_GET['frame'])){
            $this->layout='//layouts/iframe';
        }
        if($caraPrint=='PRINT') {
            $this->layout='//layouts/printWindows';
        }
        else if($caraPrint=='EXCEL') {
            $this->layout='//layouts/printExcel';
        }
        
        $this->render('printKontrol', array(
                'format'=>$format,
                'judul_print'=>$judul_print,
                'modPulang'=>$modPulang,
                'modMasukKamar'=>$modMasukKamar,
                'modPasien'=>$modPasien,
                'modAdmisi'=>$modAdmisi,
                'modPendaftaran'=>$modPendaftaran,
                'sk'=>$sk,
        ));
    }
	
	/**
     * Tampil dialog label gelang pasien
     */
	public function actionLabelGelang()
	{
		$this->layout='//layouts/iframe';
		$format = new MyFormatter();
		$datatable = '';
		$pendaftaran_id = $_GET['pendaftaran_id'];
		$modPendaftaran = RIPendaftaranT::model()->findByPk($pendaftaran_id);
		$this->render('_labelGelang', array(
			'modPendaftaran'=>$modPendaftaran,
		));
	}
	
	public function actionPrintLabelGelang($pendaftaran_id) 
    {
        $this->layout='//layouts/printWindows';
        $format = new MyFormatter;
        $modPendaftaran = RIPendaftaranT::model()->findByPk($pendaftaran_id);
        
        $judul_print = 'Label Gelang';
        $this->render('printLabelGelang', array(
                            'modPendaftaran'=>$modPendaftaran
        ));
    }
	
	public function actionGetKamarKosong($encode=false)
    {
        if(Yii::app()->request->isAjaxRequest)
        {
            if(isset($_POST['kelaspelayanan_id']))
            {
                $ruangan_id = $_POST['ruangan_id'];
                $kelaspelayanan_id = ($_POST['kelaspelayanan_id'] == '' ? 0 : $_POST['kelaspelayanan_id']);
                
                $kamarKosong = array();
                if(!empty($ruangan_id)) {
                    $kamarKosong = KamarruanganM::model()->findAllByAttributes(
                        array(
                            'ruangan_id'=>$ruangan_id,
                            'kelaspelayanan_id'=>$kelaspelayanan_id,
                            'kamarruangan_status'=>(isset($_POST['is_status']) ? $_POST['is_status'] : true),
                            'kamarruangan_aktif'=>true,
                        )
                    );
                    $kamarKosong = CHtml::listData($kamarKosong,'kamarruangan_id','KamarDanTempatTidur');
                }                
            }else{
                $ruangan_id = $_POST['ruangan_id'];
                $kamarKosong = array();
                if(!empty($ruangan_id))
                {
                    $kamarKosong = KamarruanganM::model()->findAllByAttributes(array('ruangan_id'=>$ruangan_id,'kamarruangan_status'=>true));
                    $kamarKosong = CHtml::listData($kamarKosong,'kamarruangan_id','KamarDanTempatTidur');
                }
            }
            
            if($encode){
                echo CJSON::encode($kamarKosong);
            } else {
                if(empty($kamarKosong)){
                    echo CHtml::tag('option', array('value'=>''),CHtml::encode("-- Pilih --"),true);
                }else{
                    if(count($kamarKosong) > 1)
                    {
                        echo CHtml::tag('option', array('value'=>''),CHtml::encode("-- Pilih --"),true);
                    }
                    foreach($kamarKosong as $value=>$name)
                    {
                        echo CHtml::tag('option', array('value'=>$value),CHtml::encode($name),true);
                    }
                }
            }
        }
        Yii::app()->end();
    }
	
	public function actionVerifikasiRencanaPulang()
   {
	   if (Yii::app()->request->isAjaxRequest){
			$pendaftaran_id = $_POST['pendaftaran_id'];
			$data['pesan'] = '';
			$data['verifikasinull']='';
			$modRencanaTindakan = RencanatindakanT::model()->findByAttributes(array('pendaftaran_id'=>$pendaftaran_id),array('order'=>'rencanatindakan_id DESC'));
			if(count($modRencanaTindakan)>0){
				$data['status'] = true;
				$data['pesan']="";
				if(empty($modRencanaTindakan->verifrenctindakan_id)){
					$data['verifikasinull']='ya';
					$data['pesan']="Tindakan Pasien Belum Di-Verifikasi";
				}
			}else{
				$data['status'] = false;
				$data['pesan']="Pasien tidak memiliki rencana tindakan yang perlu diverifikasi, apakah akan melanjutkan untuk memulangkan pasien?";
			}
		   echo json_encode($data);
		   Yii::app()->end();
	   }
   }
  
}
