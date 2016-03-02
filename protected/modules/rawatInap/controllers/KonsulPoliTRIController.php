<?php
//Yii::import('rawatJalan.controllers.KonsulPoliController');
//Yii::import('rawatJalan.models.*');
//class KonsulPoliTRIController extends KonsulPoliController
//{
//        
//}
class KonsulPoliTRIController extends MyAuthController
{
	public function actionIndex($pendaftaran_id,$pasienadmisi_id)
	{
            $this->layout='//layouts/iframe';
            $modAdmisi = (!empty($pasienadmisi_id)) ? PasienadmisiT::model()->findByAttributes(array('pendaftaran_id'=>$pendaftaran_id,'pasienadmisi_id'=>$pasienadmisi_id)) : array();
            $modPendaftaran = RIPendaftaranT::model()->with('jeniskasuspenyakit')->findByPk($pendaftaran_id);
            $modPasien = RIPasienM::model()->findByPk($modPendaftaran->pasien_id);
            $karcisTindakan = DaftartindakanM::model()->findAllByAttributes(array('daftartindakan_karcis'=>true));
            
            $modKonsul = new RIKonsulPoliT;
            $modelPendaftaran = new RIPendaftaranT;
            $modKonsul->pasien_id = $modPendaftaran->pasien_id;
            $modKonsul->pendaftaran_id = $pendaftaran_id;
            $modKonsul->pegawai_id = $modPendaftaran->pegawai_id;
            $modKonsul->statusperiksa = Params::STATUSPERIKSA_ANTRIAN;
            $modKonsul->asalpoliklinikkonsul_id = Yii::app()->user->getState('ruangan_id');
            $modKonsul->pasienadmisi_id = $_GET['pasienadmisi_id'];
            $modJenisTarif = JenistarifpenjaminM::model()->find('penjamin_id ='.$modAdmisi->penjamin_id);
            
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

            if(isset($_GET['idPasienKirimKeUnitLain'])){
                $modKirimKeUnitLain = RIPasienKirimKeUnitLainT::model()->findByPk($_GET['idPasienKirimKeUnitLain']);
                $modPasien = $modKirimKeUnitLain->pasien;
            }

            if(isset($_POST['RIKonsulPoliT'])) {
                $modKonsul->attributes = $_POST['RIKonsulPoliT'];
                
                if($modKonsul->validate()){
                    if($modKonsul->save()){
                         /* ================================================ */
                        /* Penambahan Tarif Konsul Poli EHS-188             */
                        /* ================================================ */
                        $modTindakanPelayanan =  New TindakanpelayananT;
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

                        $modTindakanPelayanan->daftartindakan_id = Params::DAFTARTINDAKAN_ID_KONSUL;
                        $modTindakanPelayanan->tgl_tindakan = date( 'Y-m-d H:i:s');
                        $modTindakanPelayanan->tarif_satuan = $modTindakanPelayanan->getTarifSatuan(); //RND-7250
                        $modTindakanPelayanan->tarif_tindakan = $modTindakanPelayanan->qty_tindakan * $modTindakanPelayanan->tarif_satuan;
                        $modTindakanPelayanan->pasienadmisi_id = $_GET['pasienadmisi_id'];
                        if($modTindakanPelayanan->validate()){
                            if($modTindakanPelayanan->save()){
                                $valid = true;
                                $modTindakanPelayanan->saveTindakanKomponen();
                            }
                        }
                        /* ================================================ */

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
                        $this->redirect(array('index','pendaftaran_id'=>$pendaftaran_id, 'pasienadmisi_id'=>$pasienadmisi_id, 'idKonsulPoli'=>$modKonsul->konsulpoli_id,'smspasien'=>$smspasien));
                    }
                }
            }


            
            $modRiwayatKonsul = RIKonsulPoliT::model()->findAllByAttributes(array('pendaftaran_id'=>$pendaftaran_id));
			
			$modBayarUangMuka = RIBayaruangmukaT::model()->findAllByAttributes(array('pendaftaran_id'=>$pendaftaran_id));
			$total = 0;
			foreach ($modBayarUangMuka as $key => $value){
				$total += $modBayarUangMuka[$key]->jumlahuangmuka;
			}
			$modDeposit = (($modBayarUangMuka)?$total : null);
            
			$this->render('index',array('modPendaftaran'=>$modPendaftaran,
                                        'modPasien'=>$modPasien,
                                        'modKonsul'=>$modKonsul,
                                        'karcisTindakan'=>$karcisTindakan,
                                        'modRiwayatKonsul'=>$modRiwayatKonsul,
                                        'modAdmisi'=>$modAdmisi,
                                        'modelPendaftaran'=>$modelPendaftaran,
                                        'modJenisTarif'=>$modJenisTarif,
                                        'modDeposit'=>$modDeposit));
	}
        
        public function actionAjaxDetailKonsul()
        {
            if(Yii::app()->request->isAjaxRequest) {
            $idKonsulAntarPoli = $_POST['idKonsulAntarPoli'];
            $modKonsulPoli = RIKonsulPoliT::model()->findByPk($idKonsulAntarPoli);
            $data['result'] = $this->renderPartial('_viewKonsulPoli', array('modKonsul'=>$modKonsulPoli), true);

            echo json_encode($data);
             Yii::app()->end();
            }
        }
        
        public function actionAjaxBatalKonsul()
        {
            if(Yii::app()->request->isAjaxRequest) {
            $idKonsulAntarPoli = $_POST['idKonsulAntarPoli'];
            $pendaftaran_id = $_POST['pendaftaran_id'];
            
            $tindakanpelayanan = RITindakanPelayananT::model()->findByAttributes(array('konsulpoli_id'=>$idKonsulAntarPoli));
            if(count($tindakanpelayanan) > 0){
                TindakankomponenT::model()->deleteAllByAttributes(array('tindakanpelayanan_id'=>$tindakanpelayanan->tindakanpelayanan_id));
                 RITindakanPelayananT::model()->deleteByPk($tindakanpelayanan->tindakanpelayanan_id);
            }
            

            RIKonsulPoliT::model()->deleteByPk($idKonsulAntarPoli);
            $modRiwayatKonsul = RIKonsulPoliT::model()->findAllByAttributes(array('pendaftaran_id'=>$pendaftaran_id));
            
            $data['result'] = $this->renderPartial('_listKonsulPoli', array('modRiwayatKonsul'=>$modRiwayatKonsul), true);

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
            $criteria->addCondition('komponentarif_id ='.Params::KOMPONENTARIF_ID_TOTAL);
            $criteria->addCondition('daftartindakan_id = '.Params::DAFTARTINDAKAN_ID_KONSUL);
			if(!empty($kelaspelayanan_id)){
				$criteria->addCondition("kelaspelayanan_id = ".$kelaspelayanan_id); 	
			}
			if(!empty($jenistarif)){
				$criteria->addCondition("jenistarif_id = ".$jenistarif); 	
			}
            $model = TariftindakanM::model()->findAll($criteria);
            
            $data['result'] = $this->renderPartial('_listTarifKonsul', array('model'=>$model,'ruangan_nama'=>$ruangan_nama), true);
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
            $modKonsul = new RIKonsulPoliT;
            $pendaftaran_id = (isset($_GET['id']) ? $_GET['id'] : null);
            $konsulpoli_id = (isset($_GET['idKonsulPoli']) ? $_GET['idKonsulPoli'] : null);
            $modPendaftaran = RIPendaftaranT::model()->findByPk($pendaftaran_id);

//            $modKonsulPoli = RJKonsulPoliT::model()->findByPk($idKonsulAntarPoli);
            $modRiwayatKonsul = RIKonsulPoliT::model()->findAllByAttributes(array('pendaftaran_id'=>$pendaftaran_id,'konsulpoli_id'=>$konsulpoli_id));
            
            $judulLaporan='Permintaan Konsultasi Poliklinik';
            $caraPrint=$_REQUEST['caraPrint'];
            if($caraPrint=='PRINT') {
                $this->layout='//layouts/printWindows';
                $this->render('Print',array('modPendaftaran'=>$modPendaftaran,'modRiwayatKonsul'=>$modRiwayatKonsul,'modKonsul'=>$modKonsul,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint));
            }
            else if($caraPrint=='EXCEL') {
                $this->layout='//layouts/printExcel';
                $this->render('Print',array('modPendaftaran'=>$modPendaftaran,'modRiwayatKonsul'=>$modRiwayatKonsul,'modKonsul'=>$modKonsul,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint));
            }
            else if($_REQUEST['caraPrint']=='PDF') {
                $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
                $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
                $mpdf = new MyPDF('',$ukuranKertasPDF); 
                $mpdf->useOddEven = 2;  
                $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
                $mpdf->WriteHTML($stylesheet,1);  
                $mpdf->AddPage($posisi,'','','','',15,15,15,15,15,15);
                $mpdf->WriteHTML($this->renderPartial('Print',array('modPendaftaran'=>$modPendaftaran,'modRiwayatKonsul'=>$modRiwayatKonsul,'modKonsul'=>$modKonsul,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint),true));
                $mpdf->Output();
            }                       
        }

        public function actionPrintRiwayat()
        {
            $modKonsul = new RIKonsulPoliT;
            $pendaftaran_id = (isset($_GET['id']) ? $_GET['id'] : null);
            $modPendaftaran = RIPendaftaranT::model()->findByPk($pendaftaran_id);
            $modRiwayatKonsul = RIKonsulPoliT::model()->findAllByAttributes(array('pendaftaran_id'=>$pendaftaran_id));
            
            $judulLaporan='Permintaan Konsultasi Poliklinik';
            $caraPrint=$_REQUEST['caraPrint'];
            if($caraPrint=='PRINT') {
                $this->layout='//layouts/printWindows';
                $this->render('printRiwayat',array('modPendaftaran'=>$modPendaftaran,'modRiwayatKonsul'=>$modRiwayatKonsul,'modKonsul'=>$modKonsul,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint));
            }
            else if($caraPrint=='EXCEL') {
                $this->layout='//layouts/printExcel';
                $this->render('printRiwayat',array('modPendaftaran'=>$modPendaftaran,'modRiwayatKonsul'=>$modRiwayatKonsul,'modKonsul'=>$modKonsul,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint));
            }
            else if($_REQUEST['caraPrint']=='PDF') {
                $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
                $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
                $mpdf = new MyPDF('',$ukuranKertasPDF); 
                $mpdf->useOddEven = 2;  
                $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
                $mpdf->WriteHTML($stylesheet,1);  
                $mpdf->AddPage($posisi,'','','','',15,15,15,15,15,15);
                $mpdf->WriteHTML($this->renderPartial('printRiwayat',array('modPendaftaran'=>$modPendaftaran,'modRiwayatKonsul'=>$modRiwayatKonsul,'modKonsul'=>$modKonsul,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint),true));
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