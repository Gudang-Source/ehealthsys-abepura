<?php
//Yii::import('sistemAdministrator.controllers.NotifikasiRController'); //RND-6398
class BedahSentralController extends MyAuthController
{
    public $layout='//layouts/iframe';
    public $defaultAction = 'index';
    protected $statusSaveKirimkeUnitLain = false;
    protected $statusSavePermintaanPenunjang = false;
    protected $path_view = 'rawatJalan.views.bedahSentral.';
    
	public function actionIndex($pendaftaran_id,$idPasienKirimKeUnitLain=null)
	{
	    $ruangan_id = isset($_GET['ruangan_id']) ? $_GET['ruangan_id'] : Yii::app()->user->getState('ruangan_id');
            $modPendaftaran = RJPendaftaranT::model()->with('jeniskasuspenyakit')->findByPk($pendaftaran_id);
            $modPasien = RJPasienM::model()->findByPk($modPendaftaran->pasien_id);
            $modKegiatanOperasi = RJKegiatanOperasiM::model()->findAllByAttributes(array('kegiatanoperasi_aktif'=>true),array('order'=>'kegiatanoperasi_nama'));
            $modOperasi = RJOperasiM::model()->findAllByAttributes(array('operasi_aktif'=>true),array('order'=>'operasi_nama'));
            $modKirimKeUnitLain = new RJPasienKirimKeUnitLainT;
            $modKirimKeUnitLain->tgl_kirimpasien = date('Y-m-d H:i:s');
            $modKirimKeUnitLain->pegawai_id = $modPendaftaran->pegawai_id;
            $modJenisTarif = JenistarifpenjaminM::model()->find('penjamin_id ='.$modPendaftaran->penjamin_id);

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

            if(isset($idPasienKirimKeUnitLain)){
                $modKirimKeUnitLain = RJPasienKirimKeUnitLainT::model()->findByPk($idPasienKirimKeUnitLain);
                $modPasien = $modKirimKeUnitLain->pasien;
            }

            if(isset($_POST['RJPasienKirimKeUnitLainT'])) {
                $transaction = Yii::app()->db->beginTransaction();
                try {
                    $modKirimKeUnitLain = $this->savePasienKirimKeUnitLain($modPendaftaran);
                    if(isset($_POST['permintaanPenunjang'])){
                        $this->savePermintaanPenunjang($_POST['permintaanPenunjang'],$modKirimKeUnitLain);
                        
                        PendaftaranT::model()->updateByPk($pendaftaran_id,
                            array(
                                'pembayaranpelayanan_id'=>null
                            )
                        );
                        
//                        RND-6398
//                        $params['tglnotifikasi'] = date( 'Y-m-d H:i:s');
//                        $params['create_time'] = date( 'Y-m-d H:i:s');
//                        $params['create_loginpemakai_id'] = Yii::app()->user->id;
//                        $params['instalasi_id'] = Params::INSTALASI_ID_IBS;
//                        $params['modul_id'] = 11;
//                        $ruangan = RuanganM::model()->findByPk($ruangan_id);
//                        $params['isinotifikasi'] = $modPasien->no_rekam_medik . '-' . $modPendaftaran->no_pendaftaran . '-' . $modPasien->nama_pasien . '-' . $ruangan->ruangan_nama;
//                        $params['create_ruangan'] = Params::RUANGAN_ID_BEDAH;
//                        $params['judulnotifikasi'] = 'Rujukan Rawat Jalan';                        
//                        $nofitikasi = NotifikasiRController::insertNotifikasi($params);
                        
                    } else {
                        $this->statusSavePermintaanPenunjang = true;
                    }
                        $judul = 'Pasien Rawat Inap Rujuk ke Bedah Sentral';

                        $isi = $modPasien->no_rekam_medik.' - '.$modPasien->nama_pasien;
                        $mr = RuanganM::model()->findByPk($modKirimKeUnitLain->ruangan_id);

                        // var_dump($mr->attributes); die;


                        $ok = CustomFunction::broadcastNotif($judul, $isi, array(
                            array('instalasi_id'=>$mr->instalasi_id, 'ruangan_id'=>$mr->ruangan_id, 'modul_id'=>$mr->modul_id),
                            // array('instalasi_id'=>Params::INSTALASI_ID_FARMASI, 'ruangan_id'=>Params::RUANGAN_ID_APOTEK_RJ, 'modul_id'=>10),
                            array('instalasi_id'=>Params::INSTALASI_ID_KASIR, 'ruangan_id'=>Params::RUANGAN_ID_KASIR, 'modul_id'=>19),
                        ));
                        if($this->statusSaveKirimkeUnitLain && $this->statusSavePermintaanPenunjang){

                        // SMS GATEWAY
                        $modPegawai = $modPendaftaran->pegawai;
                        $sms = new Sms();
                        $smspasien = 1;
                        foreach ($modSmsgateway as $i => $smsgateway) {
                            if (isset($_POST['tujuansms']) && in_array($smsgateway->tujuansms, $_POST['tujuansms'])) {
                                $isiPesan = $smsgateway->templatesms;

                                $attributes = $modPasien->getAttributes();
                                foreach($attributes as $attributes => $value){
                                    $isiPesan = str_replace("{{".$attributes."}}",$value,$isiPesan);
                                }
                                $attributes = $modPendaftaran->getAttributes();
                                foreach($attributes as $attributes => $value){
                                    $isiPesan = str_replace("{{".$attributes."}}",$value,$isiPesan);
                                }
                                $attributes = $modPegawai->getAttributes();
                                foreach($attributes as $attributes => $value){
                                    $isiPesan = str_replace("{{".$attributes."}}",$value,$isiPesan);
                                }
                                $attributes = $modKirimKeUnitLain->getAttributes();
                                foreach($attributes as $attributes => $value){
                                    $isiPesan = str_replace("{{".$attributes."}}",$value,$isiPesan);
                                }
                                $isiPesan = str_replace("{{hari}}",MyFormatter::getDayName($modKirimKeUnitLain->tgl_kirimpasien),$isiPesan);

                                if($smsgateway->tujuansms == Params::TUJUANSMS_PASIEN && $smsgateway->statussms){
                                    if(!empty($modPasien->no_mobile_pasien)){
                                        $sms->kirim($modPasien->no_mobile_pasien,$isiPesan);
                                    }else{
                                        $smspasien = 0;
                                    }
                                }
                            }
                        }
                        // END SMS GATEWAY
                        
                        $transaction->commit();
                        Yii::app()->user->setFlash('success',"Data Berhasil disimpan");
                        $this->redirect(array('index','pendaftaran_id'=>$pendaftaran_id, 'idPasienKirimKeUnitLain'=>$modKirimKeUnitLain->pasienkirimkeunitlain_id,'smspasien'=>$smspasien));
                    } else {
                        $transaction->rollback();
                        Yii::app()->user->setFlash('error',"Data tidak valid ");
                    }
                } catch (Exception $exc) {
                    $transaction->rollback();
                    Yii::app()->user->setFlash('error',"Data Gagal disimpan. ".MyExceptionMessage::getMessage($exc,true));
                }
                
            }
            		
            $modRiwayatKirimKeUnitLain = RJPasienKirimKeUnitLainT::model()->findAllByAttributes(array('pendaftaran_id'=>$pendaftaran_id,
                                                                                                      'ruangan_id'=>Params::RUANGAN_ID_BEDAH),
                                                                                                'pasienmasukpenunjang_id IS NULL');
            $this->render($this->path_view.'index',array('modPendaftaran'=>$modPendaftaran,
                                        'modPasien'=>$modPasien,
                                        'modKegiatanOperasi'=>$modKegiatanOperasi,
                                        'modOperasi'=>$modOperasi,
                                        'modKirimKeUnitLain'=>$modKirimKeUnitLain,
                                        'modRiwayatKirimKeUnitLain'=>$modRiwayatKirimKeUnitLain,
                                        'modJenisTarif'=>$modJenisTarif,
                                       ));
	}

        protected function savePasienKirimKeUnitLain($modPendaftaran)
        {
	    $format = new MyFormatter();
            $modKirimKeUnitLain = new RJPasienKirimKeUnitLainT;
            $modKirimKeUnitLain->attributes = $_POST['RJPasienKirimKeUnitLainT'];
            $modKirimKeUnitLain->pasien_id = $modPendaftaran->pasien_id;
            $modKirimKeUnitLain->pendaftaran_id = $modPendaftaran->pendaftaran_id;
            $modKirimKeUnitLain->pegawai_id = $modPendaftaran->pegawai_id;
            $modKirimKeUnitLain->kelaspelayanan_id = $modPendaftaran->kelaspelayanan_id;
            $modKirimKeUnitLain->instalasi_id = Params::INSTALASI_ID_IBS;
            $modKirimKeUnitLain->ruangan_id = Params::RUANGAN_ID_BEDAH;
            $modKirimKeUnitLain->tgl_kirimpasien = $format->formatDateTimeForDb($_POST['RJPasienKirimKeUnitLainT']['tgl_kirimpasien']);
            $modKirimKeUnitLain->create_time = date("Y-m-d H:i:s");
            $modKirimKeUnitLain->update_time = date("Y-m-d H:i:s");
            $modKirimKeUnitLain->create_loginpemakai_id = Yii::app()->user->id;
            $modKirimKeUnitLain->update_loginpemakai_id = Yii::app()->user->id;
            $modKirimKeUnitLain->create_ruangan = Yii::app()->user->getState('ruangan_id');
			$modKirimKeUnitLain->tgl_kirimpasien = MyFormatter::formatDateTimeForDb($modKirimKeUnitLain->tgl_kirimpasien);
            $modKirimKeUnitLain->nourut = MyGenerator::noUrutPasienKirimKeUnitLain($modKirimKeUnitLain->ruangan_id);
            if($modKirimKeUnitLain->validate()){
                $modKirimKeUnitLain->save();
                $dat = PasienpulangT::model()->findByAttributes(array(
                    // 'carakeluar_id'=>Params::CARAKELUAR_ID_RAWATINAP,
                    'pendaftaran_id'=>$modPendaftaran->pendaftaran_id,
                ));
                if (empty($dat)) $updateStatusPeriksa=PendaftaranT::model()->updateByPk($modPendaftaran->pendaftaran_id,array('statusperiksa'=>Params::STATUSPERIKSA_SEDANG_PERIKSA));
                /* ================================================ */
                /* Proses update status periksa KonsulPoli EHS-179  */
                /* ================================================ */
		$ruangan_id = isset($_GET['ruangan_id']) ? $_GET['ruangan_id'] : Yii::app()->user->getState('ruangan_id');
                $konsulPoli = KonsulpoliT::model()->findByAttributes(array('pendaftaran_id'=>$modPendaftaran->pendaftaran_id, 'ruangan_id'=>$ruangan_id));
                if(count($konsulPoli)>0){
                    $updateStatusPeriksa=KonsulpoliT::model()->updateByPk($konsulPoli->konsulpoli_id,array('statusperiksa'=>Params::STATUSPERIKSA_SEDANG_PERIKSA));
                }
                /* ================================================ */
                PendaftaranT::model()->updateByPk($modPendaftaran->pendaftaran_id,
                    array(
                        'pembayaranpelayanan_id'=>null
                    )
                );
                $this->statusSaveKirimkeUnitLain = true;
            }
            
            return $modKirimKeUnitLain;
        }
        
        protected function savePermintaanPenunjang($permintaan,$modKirimKeUnitLain)
        {
            foreach ($permintaan['inputoperasi'] as $i => $value) {
                $modPermintaan = new RJPermintaanPenunjangT;
                $modPermintaan->daftartindakan_id = '';
                $modPermintaan->pemeriksaanlab_id = '';
                $modPermintaan->operasi_id = $permintaan['inputoperasi'][$i];
                $modPermintaan->pasienkirimkeunitlain_id = $modKirimKeUnitLain->pasienkirimkeunitlain_id;
                $modPermintaan->noperminatanpenujang = MyGenerator::noPermintaanPenunjang('PB');
                $modPermintaan->qtypermintaan = $permintaan['inputqty'][$i];
                $modPermintaan->tglpermintaankepenunjang = $modKirimKeUnitLain->tgl_kirimpasien; //date('Y-m-d H:i:s');
				if($modPermintaan->validate()){
                    $modPermintaan->save();
                    $this->statusSavePermintaanPenunjang = true;
                }
            }
        }
        
        /**
         * untuk ajax action load tindakan operasi
         */
        public function actionLoadFormPermintaanOperasi()
        {
            if (Yii::app()->request->isAjaxRequest)
            {
                $operasi_id = isset($_POST['operasi_id']) ? $_POST['operasi_id'] : null;
                $kelaspelayanan_id = isset($_POST['kelaspelayanan_id']) ? $_POST['kelaspelayanan_id'] : null;
                $pendaftaran_id = isset($_POST['pendaftaran_id']) ? $_POST['pendaftaran_id'] : null;
                $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
                $jenistarif = JenistarifpenjaminM::model()->find('penjamin_id ='.$modPendaftaran->penjamin_id)->jenistarif_id;
                $modOperasi = OperasiM::model()->with('kegiatanoperasi')->findByPk($operasi_id);
                $criteria = new CDbCriteria();
                $criteria->addCondition('daftartindakan_id ='.$modOperasi->daftartindakan_id);
                $criteria->addCondition('kelaspelayanan_id ='.$kelaspelayanan_id);
                $criteria->addCondition('jenistarif_id ='.$jenistarif);
                $criteria->addCondition('komponentarif_id ='.Params::KOMPONENTARIF_ID_TOTAL);
                
                $modTarif = TariftindakanM::model()->find($criteria);
                
                /**
                 * dicomment RND-3284
                 */
//                $modTarif = TariftindakanM::model()->findByAttributes(array('daftartindakan_id'=>$modOperasi->daftartindakan_id,
//                                                                            'kelaspelayanan_id'=>$kelaspelayanan_id,
//                                                                            'jenistarif_id'=>$jenistarif,
//                                                                            'komponentarif_id'=>Params::KOMPONENTARIF_ID_TOTAL));

                echo CJSON::encode(array(
                    'status'=>'create_form', 
                    'form'=>$this->renderPartial($this->path_view.'_formLoadPermintaanOperasi', array('modOperasi'=>$modOperasi,
                                                                                    'kelaspelayanan_id'=>$kelaspelayanan_id,
                                                                                    'modTarif'=>$modTarif), true)));
                exit;               
            }
        }
    
        public function actionAjaxBatalKirim()
        {
            if(Yii::app()->request->isAjaxRequest) {
            $idPasienKirimKeUnitLain = $_POST['idPasienKirimKeUnitLain'];
            $pendaftaran_id = $_POST['pendaftaran_id'];
            
            PermintaankepenunjangT::model()->deleteAllByAttributes(array('pasienkirimkeunitlain_id'=>$idPasienKirimKeUnitLain));
            PasienkirimkeunitlainT::model()->deleteByPk($idPasienKirimKeUnitLain);
            $modRiwayatKirimKeUnitLain = RJPasienKirimKeUnitLainT::model()->findAllByAttributes(array('pendaftaran_id'=>$pendaftaran_id,
                                                                                                      'ruangan_id'=>Params::RUANGAN_ID_BEDAH));
            
            $data['result'] = $this->renderPartial($this->path_view.'_listKirimKeUnitLain', array('modRiwayatKirimKeUnitLain'=>$modRiwayatKirimKeUnitLain), true);

            echo json_encode($data);
             Yii::app()->end();
            }
        }

        public function actionPrint()
        {
             $pendaftaran_id = $_GET['id'];
             $idPasienKirimKeUnitLain = $_GET['idPasienKirimKeUnitLain'];
             $modPendaftaran= PendaftaranT::model()->findByPk($pendaftaran_id);
             $modRiwayatKirimKeUnitLain = RJPasienKirimKeUnitLainT::model()->findAllByAttributes(array('pendaftaran_id'=>$pendaftaran_id,
                'pasienkirimkeunitlain_id'=>$idPasienKirimKeUnitLain),
                'pasienmasukpenunjang_id IS NULL');

            $judulLaporan='Permintaan Operasi';
            $caraPrint=$_REQUEST['caraPrint'];
            if($caraPrint=='PRINT') {
                $this->layout='//layouts/printWindows';
                $this->render($this->path_view.'Print',array('modPendaftaran'=>$modPendaftaran,'modRiwayatKirimKeUnitLain'=>$modRiwayatKirimKeUnitLain,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint));
            }
            else if($caraPrint=='EXCEL') {
                $this->layout='//layouts/printExcel';
                $this->render($this->path_view.'Print',array('modPendaftaran'=>$modPendaftaran,'modRiwayatKirimKeUnitLain'=>$modRiwayatKirimKeUnitLain,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint));
            }
            else if($_REQUEST['caraPrint']=='PDF') {
                $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
                $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
                $mpdf = new MyPDF('',$ukuranKertasPDF); 
                $mpdf->useOddEven = 2;  
                $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
                $mpdf->WriteHTML($stylesheet,1);  
                $mpdf->AddPage($posisi,'','','','',15,15,15,15,15,15);
                $mpdf->WriteHTML($this->renderPartial($this->path_view.'Print',array('modPendaftaran'=>$modPendaftaran,'modRiwayatKirimKeUnitLain'=>$modRiwayatKirimKeUnitLain,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint),true));
                $mpdf->Output();
            }                       
        }

        public function actionPrintRiwayat()
        {
            $pendaftaran_id = $_GET['id'];
            $modPendaftaran= PendaftaranT::model()->findByPk($pendaftaran_id);
            $modKirimKeUnitLain = RJPasienKirimKeUnitLainT::model()->findAll('pendaftaran_id='.$pendaftaran_id);
            $modRiwayatKirimKeUnitLain = RJPasienKirimKeUnitLainT::model()->findAllByAttributes(array('pendaftaran_id'=>$pendaftaran_id,'ruangan_id'=>Params::RUANGAN_ID_BEDAH),'pasienmasukpenunjang_id IS NULL');
            $judulLaporan='Permintaan Operasi';
            $caraPrint=$_REQUEST['caraPrint'];
            if($caraPrint=='PRINT') {
                $this->layout='//layouts/printWindows';
                $this->render($this->path_view.'printRiwayat',array('modKirimKeUnitLain'=> $modKirimKeUnitLain,'modPendaftaran'=>$modPendaftaran,'modRiwayatKirimKeUnitLain'=>$modRiwayatKirimKeUnitLain,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint));
            }
            else if($caraPrint=='EXCEL') {
                $this->layout='//layouts/printExcel';
                $this->render($this->path_view.'printRiwayat',array('modKirimKeUnitLain'=> $modKirimKeUnitLain,'modPendaftaran'=>$modPendaftaran,'modRiwayatKirimKeUnitLain'=>$modRiwayatKirimKeUnitLain,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint));
            }
            else if($_REQUEST['caraPrint']=='PDF') {
                $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
                $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
                $mpdf = new MyPDF('',$ukuranKertasPDF); 
                $mpdf->useOddEven = 2;  
                $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
                $mpdf->WriteHTML($stylesheet,1);  
                $mpdf->AddPage($posisi,'','','','',15,15,15,15,15,15);
                $mpdf->WriteHTML($this->renderPartial($this->path_view.'printRiwayat',array('modKirimKeUnitLain'=> $modKirimKeUnitLain,'modPendaftaran'=>$modPendaftaran,'modRiwayatKirimKeUnitLain'=>$modRiwayatKirimKeUnitLain,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint),true));
                $mpdf->Output();
            }                       
        }



	// Uncomment the following methods and override them if needed
	/*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
}