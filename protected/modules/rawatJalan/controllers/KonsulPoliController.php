<?php
//Yii::import('sistemAdministrator.controllers.NotifikasiRController'); //RND-6398
class KonsulPoliController extends MyAuthController
{
        public $layout='//layouts/iframe';
        public $defaultAction = 'index';
        protected $path_view = 'rawatJalan.views.konsulPoli.';
	public function actionIndex($pendaftaran_id,$idPasienKirimKeUnitLain=null)
	{
			$ruangan_id = isset($_GET['ruangan_id']) ? $_GET['ruangan_id'] : Yii::app()->user->getState('ruangan_id');
            $modPendaftaran = RJPendaftaranT::model()->with('jeniskasuspenyakit')->findByPk($pendaftaran_id);
            $modPasien = RJPasienM::model()->findByPk($modPendaftaran->pasien_id);
            $karcisTindakan = DaftartindakanM::model()->findAllByAttributes(array('daftartindakan_karcis'=>true));
            
            $modKonsul = new RJKonsulPoliT;
            $modelPendaftaran = new RJPendaftaranT;
            $modKonsul->pasien_id = $modPendaftaran->pasien_id;
            $modKonsul->pendaftaran_id = $pendaftaran_id;
            $modKonsul->pegawai_id = $modPendaftaran->pegawai_id;
            $modKonsul->statusperiksa = Params::STATUSPERIKSA_ANTRIAN;
            $modKonsul->asalpoliklinikkonsul_id = $ruangan_id;
            
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

            if(isset($_POST['RJKonsulPoliT'])) {
                $modKonsul->attributes = $_POST['RJKonsulPoliT'];
                $modelPendaftaran->pasienpulang_id = $modPendaftaran->pasienpulang_id;
                $modelPendaftaran->pasienbatalperiksa_id = $modPendaftaran->pasienbatalperiksa_id;
                if(empty($modelPendaftaran->penanggungjawab_id)){
                   $penanggungjawab = 1;
                }else{
                    $penanggungjawab = $modPendaftaran->penanggungjawab_id;
                }
				$modKonsul->no_antriankonsul = MyGenerator::noAntrianKonsulPoli($modKonsul->ruangan_id);
                if($modKonsul->validate()){
                    if($modKonsul->save()){
                        
                        $p = PendaftaranT::model()->findByPk($pendaftaran_id);
                        $updateStatusPeriksa = $p->setStatusPeriksa(Params::STATUSPERIKSA_SEDANG_PERIKSA);
                        
                        /* ================================================ */
                        /* Proses update status periksa KonsulPoli EHS-179  */
                        /* ================================================ */
                        $konsulPoli = KonsulpoliT::model()->findByAttributes(array('pendaftaran_id'=>$pendaftaran_id, 'ruangan_id'=>$ruangan_id));
                        if(count($konsulPoli)>0){
                            $updateStatusPeriksa=KonsulpoliT::model()->updateByPk($konsulPoli->konsulpoli_id,array('statusperiksa'=>Params::STATUSPERIKSA_SEDANG_PERIKSA));
                        }
                        /* ================================================ */

                        PendaftaranT::model()->updateByPk($pendaftaran_id,
                            array(
                                'pembayaranpelayanan_id'=>null
                            )
                        );

                        $jenistarif = JenistarifpenjaminM::model()->find('penjamin_id ='.$modPendaftaran->penjamin_id)->jenistarif_id;
                        
                        $criteria = new CDbCriteria();            
                        $criteria->addCondition('t.komponentarif_id ='.Params::KOMPONENTARIF_ID_TOTAL);
                        $criteria->addCondition('d.daftartindakan_konsul = true and d.daftartindakan_karcis = true');
                        $criteria->join = "join daftartindakan_m d on t.daftartindakan_id = d.daftartindakan_id";
                        $criteria->addCondition("kelaspelayanan_id = ".$modPendaftaran->kelaspelayanan_id);						
                        $criteria->addCondition("jenistarif_id = ".$jenistarif);						
			
                        $modTarif = RJTariftindakanM::model()->find($criteria);
						if(count($modTarif) > 0){
							$modTindakanPelayanan =  New RJTindakanPelayananT;
							$modTindakanPelayanan->konsulpoli_id = $modKonsul->konsulpoli_id;
							$modTindakanPelayanan->pasien_id = $modPendaftaran->pasien_id;
							$modTindakanPelayanan->pendaftaran_id = $modPendaftaran->pendaftaran_id;
							$modTindakanPelayanan->kelaspelayanan_id = $modPendaftaran->kelaspelayanan_id;
							$modTindakanPelayanan->shift_id     = $modPendaftaran->shift_id;
							$modTindakanPelayanan->carabayar_id = $modPendaftaran->carabayar_id;
							$modTindakanPelayanan->penjamin_id = $modPendaftaran->penjamin_id;
							$modTindakanPelayanan->jeniskasuspenyakit_id = $modPendaftaran->jeniskasuspenyakit_id;
							$modTindakanPelayanan->ruangan_id   = $modKonsul->ruangan_id;
							$modTindakanPelayanan->instalasi_id = $modTindakanPelayanan->ruangan->instalasi_id;
							$modTindakanPelayanan->cyto_tindakan=0;
							$modTindakanPelayanan->tarifcyto_tindakan = 0;
							$modTindakanPelayanan->discount_tindakan = 0;
							$modTindakanPelayanan->subsidiasuransi_tindakan = 0;
							$modTindakanPelayanan->subsidipemerintah_tindakan = 0;
							$modTindakanPelayanan->subsisidirumahsakit_tindakan = 0;
							$modTindakanPelayanan->iurbiaya_tindakan = 0;
							$modTindakanPelayanan->create_loginpemakai_id = Yii::app()->user->id;
							$modTindakanPelayanan->create_ruangan = $modKonsul->ruangan_id;
							$modTindakanPelayanan->create_time =  date( 'Y-m-d H:i:s');
							$modTindakanPelayanan->satuantindakan = "Hari";

							$modTindakanPelayanan->daftartindakan_id = $modTarif->daftartindakan_id;
							$modTindakanPelayanan->tgl_tindakan = date( 'Y-m-d H:i:s');

							$modTindakanPelayanan->tarif_satuan = (isset($modTarif->harga_tariftindakan) ? $modTarif->harga_tariftindakan : 0);
							$modTindakanPelayanan->tarif_tindakan = $modTindakanPelayanan->qty_tindakan * $modTindakanPelayanan->tarif_satuan;
                                                        
							if($modTindakanPelayanan->validate()){
								if($modTindakanPelayanan->save()){
									$valid = true;
									$modTindakanPelayanan->saveTindakanKomponen();
								}
							}
                        }
                        /* ================================================ */

//                        RND-6398
//                        $params['tglnotifikasi'] = date( 'Y-m-d H:i:s');
//                        $params['create_time'] = date( 'Y-m-d H:i:s');
//                        $params['create_loginpemakai_id'] = Yii::app()->user->id;
//                        $params['instalasi_id'] = Yii::app()->user->getState('instalasi_id');
//                        $params['modul_id'] = 5;
//                        $ruangan = RuanganM::model()->findByPk($ruangan_id);
//                        $params['isinotifikasi'] = $modPasien->no_rekam_medik . '-' . $modPendaftaran->no_pendaftaran . '-' . $modPasien->nama_pasien . '-' . $ruangan->ruangan_nama;
//                        $params['create_ruangan'] = $modKonsul->ruangan_id;
//                        $params['judulnotifikasi'] = 'Rujukan Rawat Jalan';                        
//                        $nofitikasi = NotifikasiRController::insertNotifikasi($params);

                        // SMS GATEWAY
                        $modPegawai = $modPendaftaran->pegawai;
                        $modRuangan = $modKonsul->politujuan;
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
                            $attributes = $modPegawai->getAttributes();
                            foreach($attributes as $attributes => $value){
                                $isiPesan = str_replace("{{".$attributes."}}",$value,$isiPesan);
                            }
                            $attributes = $modKonsul->getAttributes();
                            foreach($attributes as $attributes => $value){
                                $isiPesan = str_replace("{{".$attributes."}}",$value,$isiPesan);
                            }
                            $attributes = $modRuangan->getAttributes();
                            foreach($attributes as $attributes => $value){
                                $isiPesan = str_replace("{{".$attributes."}}",$value,$isiPesan);
                            }
                            $isiPesan = str_replace("{{hari}}",MyFormatter::getDayName($modKonsul->tglkonsulpoli),$isiPesan);
                            
                            if($smsgateway->tujuansms == Params::TUJUANSMS_PASIEN && $smsgateway->statussms){
                                if(!empty($modPasien->no_mobile_pasien)){
                                    $sms->kirim($modPasien->no_mobile_pasien,$isiPesan);
                                }else{
                                    $smspasien = 0;
                                }
                            }
                        }
                        
                        Yii::app()->user->setFlash('success',"Data berhasil disimpan");
                        $this->redirect(array('index','pendaftaran_id'=>$pendaftaran_id, 'idKonsulPoli'=>$modKonsul->konsulpoli_id,'smspasien'=>$smspasien));
                    }
                }
            }
            
            $modRiwayatKonsul = RJKonsulPoliT::model()->findAllByAttributes(array('pendaftaran_id'=>$pendaftaran_id, 'asalpoliklinikkonsul_id'=>$ruangan_id));
		
            $this->render($this->path_view.'index',array('modPendaftaran'=>$modPendaftaran,
                                        'modPasien'=>$modPasien,
                                        'modKonsul'=>$modKonsul,
                                        'karcisTindakan'=>$karcisTindakan,
                                        'modRiwayatKonsul'=>$modRiwayatKonsul,
                                        'modelPendaftaran'=>$modelPendaftaran,
                                        'modJenisTarif'=>$modJenisTarif));
	}
        
        public function actionAjaxDetailKonsul()
        {
            if(Yii::app()->request->isAjaxRequest) {
            $konsulantarpoli_id = $_POST['idKonsulAntarPoli'];
            $modKonsulPoli = RJKonsulPoliT::model()->findByPk($konsulantarpoli_id);
            $modPendaftaran = RJPendaftaranT::model()->findByPk($modKonsulPoli->pendaftaran_id);
            $data['result'] = $this->renderPartial($this->path_view.'_viewKonsulPoli', array('modKonsul'=>$modKonsulPoli, 'modPendaftaran'=>$modPendaftaran), true);

            echo json_encode($data);
             Yii::app()->end();
            }
        }
        
        public function actionAjaxBatalKonsul()
        {
            if(Yii::app()->request->isAjaxRequest) {
            $konsulantarpoli_id = (isset($_POST['idKonsulAntarPoli']) ? $_POST['idKonsulAntarPoli'] : null);
            $pendaftaran_id = (isset($_POST['pendaftaran_id']) ? $_POST['pendaftaran_id'] : null);
            
            $tindakanpelayanan = RJTindakanPelayananT::model()->findByAttributes(array('konsulpoli_id'=>$konsulantarpoli_id));
            if(count($tindakanpelayanan)){
                TindakankomponenT::model()->deleteAllByAttributes(array('tindakanpelayanan_id'=>$tindakanpelayanan->tindakanpelayanan_id));
                RJTindakanPelayananT::model()->deleteByPk($tindakanpelayanan->tindakanpelayanan_id);
            }

            RJKonsulPoliT::model()->deleteByPk($konsulantarpoli_id);
            $modRiwayatKonsul = RJKonsulPoliT::model()->findAllByAttributes(array('pendaftaran_id'=>$pendaftaran_id));
            
            $data['result'] = $this->renderPartial($this->path_view.'_listKonsulPoli', array('modRiwayatKonsul'=>$modRiwayatKonsul), true);

            echo json_encode($data);
             Yii::app()->end();
            }
        }
        
        /**
         * ajax untuk menampilkan tarif tindakan konsultasi poliklinik
         */
        public function actionAjaxSetTarif()
        {
            if(Yii::app()->request->isAjaxRequest) {
            $penjamin_id = (isset($_POST['penjamin_id']) ? $_POST['penjamin_id'] : null);
            $ruangan_id = (isset($_POST['ruangan_id']) ? $_POST['ruangan_id'] : null);
            $kelaspelayanan_id = (isset($_POST['kelaspelayanan_id']) ? $_POST['kelaspelayanan_id'] : null);
            $ruangan = RuanganM::model()->findByPk($ruangan_id);
            $ruangan_nama = $ruangan->ruangan_nama;
            $jenistarif = JenistarifpenjaminM::model()->find('penjamin_id ='.$penjamin_id)->jenistarif_id;
            
            $criteria = new CDbCriteria();            
            $criteria->addCondition('t.komponentarif_id ='.Params::KOMPONENTARIF_ID_TOTAL);
            $criteria->addCondition('d.daftartindakan_konsul = true and d.daftartindakan_karcis = true');
            $criteria->join = "join daftartindakan_m d on t.daftartindakan_id = d.daftartindakan_id";
            
            
            
			if(!empty($kelaspelayanan_id)){
				$criteria->addCondition("kelaspelayanan_id = ".$kelaspelayanan_id);						
			}
			if(!empty($jenistarif)){
				$criteria->addCondition("jenistarif_id = ".$jenistarif);						
			}
            // var_dump($criteria); die;
            $model = TariftindakanM::model()->findAll($criteria);
            
            $data['result'] = $this->renderPartial($this->path_view.'_listTarifKonsul', array('model'=>$model,'ruangan_nama'=>$ruangan_nama), true);
            $data['dokter'] = $this->loadDokterRuangan($ruangan_id);
            
            
            echo json_encode($data);
            Yii::app()->end();
            }
        }
        
        protected function loadDokterRuangan($ruangan_id) {
            $dokter = DokterV::model()->findAllByAttributes(array(
                'pegawai_aktif'=>true,
                'ruangan_id'=>$ruangan_id,
            ));
            $dat = CHtml::listData($dokter, 'pegawai_id', 'namaLengkap');
            $str = count($dat)>1?'<option value="">-- Pilih --</option>':'';
            foreach ($dat as $val=>$item) {
                $str .= '<option value="'.$val.'">'.$item.'</option>';
            }
            
            return $str;
        }
        
        public function actionPrint()
        {
            $modKonsul = new RJKonsulPoliT;
            $pendaftaran_id = (isset($_GET['id']) ? $_GET['id'] : null);
            $konsulpoli_id = (isset($_GET['idKonsulPoli']) ? $_GET['idKonsulPoli'] : null);
            $modPendaftaran = RJPendaftaranT::model()->findByPk($pendaftaran_id);

//            $modKonsulPoli = RJKonsulPoliT::model()->findByPk($idKonsulAntarPoli);
            $modRiwayatKonsul = RJKonsulPoliT::model()->findAllByAttributes(array('pendaftaran_id'=>$pendaftaran_id,'konsulpoli_id'=>$konsulpoli_id));
            
            $judulLaporan='Permintaan Konsultasi Poliklinik';
            $caraPrint=$_REQUEST['caraPrint'];
            if($caraPrint=='PRINT') {
                $this->layout='//layouts/printWindows';
                $this->render($this->path_view.'Print',array('modPendaftaran'=>$modPendaftaran,'modRiwayatKonsul'=>$modRiwayatKonsul,'modKonsul'=>$modKonsul,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint));
            }
            else if($caraPrint=='EXCEL') {
                $this->layout='//layouts/printExcel';
                $this->render($this->path_view.'Print',array('modPendaftaran'=>$modPendaftaran,'modRiwayatKonsul'=>$modRiwayatKonsul,'modKonsul'=>$modKonsul,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint));
            }
            else if($_REQUEST['caraPrint']=='PDF') {
                $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
                $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
                $mpdf = new MyPDF('',$ukuranKertasPDF); 
                $mpdf->useOddEven = 2;  
                $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
                $mpdf->WriteHTML($stylesheet,1);  
                $mpdf->AddPage($posisi,'','','','',15,15,15,15,15,15);
                $mpdf->WriteHTML($this->renderPartial($this->path_view.'Print',array('modPendaftaran'=>$modPendaftaran,'modRiwayatKonsul'=>$modRiwayatKonsul,'modKonsul'=>$modKonsul,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint),true));
                $mpdf->Output();
            }                       
        }

        public function actionPrintRiwayat()
        {
            $modKonsul = new RJKonsulPoliT;
            $pendaftaran_id = (isset($_GET['id']) ? $_GET['id'] : null);
            $modPendaftaran = RJPendaftaranT::model()->findByPk($pendaftaran_id);
            $modRiwayatKonsul = RJKonsulPoliT::model()->findAllByAttributes(array('pendaftaran_id'=>$pendaftaran_id));
            
            $judulLaporan='Permintaan Konsultasi Poliklinik';
            $caraPrint=$_REQUEST['caraPrint'];
            if($caraPrint=='PRINT') {
                $this->layout='//layouts/printWindows';
                $this->render($this->path_view.'printRiwayat',array('modPendaftaran'=>$modPendaftaran,'modRiwayatKonsul'=>$modRiwayatKonsul,'modKonsul'=>$modKonsul,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint));
            }
            else if($caraPrint=='EXCEL') {
                $this->layout='//layouts/printExcel';
                $this->render($this->path_view.'printRiwayat',array('modPendaftaran'=>$modPendaftaran,'modRiwayatKonsul'=>$modRiwayatKonsul,'modKonsul'=>$modKonsul,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint));
            }
            else if($_REQUEST['caraPrint']=='PDF') {
                $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
                $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
                $mpdf = new MyPDF('',$ukuranKertasPDF); 
                $mpdf->useOddEven = 2;  
                $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
                $mpdf->WriteHTML($stylesheet,1);  
                $mpdf->AddPage($posisi,'','','','',15,15,15,15,15,15);
                $mpdf->WriteHTML($this->renderPartial($this->path_view.'printRiwayat',array('modPendaftaran'=>$modPendaftaran,'modRiwayatKonsul'=>$modRiwayatKonsul,'modKonsul'=>$modKonsul,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint),true));
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