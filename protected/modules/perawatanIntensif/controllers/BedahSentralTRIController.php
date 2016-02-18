<?php
//Yii::import('rawatJalan.controllers.BedahSentralController');
//Yii::import('rawatJalan.models.*');
//class BedahSentralTRIController extends BedahSentralController
//{
//        
//}
class BedahSentralTRIController extends MyAuthController
{
        protected $statusSaveKirimkeUnitLain = false;
        protected $statusSavePermintaanPenunjang = false;
    
	public function actionIndex($pendaftaran_id,$pasienadmisi_id)
	{
            $this->layout='//layouts/iframe';
            $modPasienMasukPenunjang = array();
            $modAdmisi = (!empty($pasienadmisi_id)) ? PasienadmisiT::model()->findByAttributes(array('pendaftaran_id'=>$pendaftaran_id,'pasienadmisi_id'=>$pasienadmisi_id)) : array();
            $modPendaftaran = RIPendaftaranT::model()->with('jeniskasuspenyakit')->findByPk($pendaftaran_id);
            $modPasien = RIPasienM::model()->findByPk($modPendaftaran->pasien_id);
            $modKegiatanOperasi = RIKegiatanOperasiM::model()->findAllByAttributes(array('kegiatanoperasi_aktif'=>true),array('order'=>'kegiatanoperasi_nama'));
            $modOperasi = RIOperasiM::model()->findAllByAttributes(array('operasi_aktif'=>true),array('order'=>'operasi_nama'));
            $modKirimKeUnitLain = new RIPasienKirimKeUnitLainT;
            $modKirimKeUnitLain->tgl_kirimpasien = date('Y-m-d H:i:s');
            $modKirimKeUnitLain->pegawai_id = $modPendaftaran->pegawai_id;

            if(isset($_GET['idPasienKirimKeUnitLain'])){
                $modKirimKeUnitLain = RIPasienKirimKeUnitLainT::model()->findByPk($_GET['idPasienKirimKeUnitLain']);
                $modPasien = $modKirimKeUnitLain->pasien;
            }
            
            $modJenisTarif = JenistarifpenjaminM::model()->find('penjamin_id ='.$modAdmisi->penjamin_id);
            if(isset($_POST['RIPasienKirimKeUnitLainT'])) {
                $transaction = Yii::app()->db->beginTransaction();
                try {
                    $modKirimKeUnitLain = $this->savePasienKirimKeUnitLain($modAdmisi);
                    if(isset($_POST['permintaanPenunjang'])){
                        $this->savePermintaanPenunjang($_POST['permintaanPenunjang'],$modKirimKeUnitLain);
                    } else {
                        $this->statusSavePermintaanPenunjang = true;
                    }
                    
                    $judul = 'Pasien Rawat Intensif Rujuk ke Bedah Sentral';

                        $isi = $modPasien->no_rekam_medik.' - '.$modPasien->nama_pasien;
                        $mr = RuanganM::model()->findByPk($modKirimKeUnitLain->ruangan_id);

                        // var_dump($mr->attributes); die;


                        $ok = CustomFunction::broadcastNotif($judul, $isi, array(
                            array('instalasi_id'=>$mr->instalasi_id, 'ruangan_id'=>$mr->ruangan_id, 'modul_id'=>$mr->modul_id),
                            // array('instalasi_id'=>Params::INSTALASI_ID_FARMASI, 'ruangan_id'=>Params::RUANGAN_ID_APOTEK_RJ, 'modul_id'=>10),
                            array('instalasi_id'=>Params::INSTALASI_ID_KASIR, 'ruangan_id'=>Params::RUANGAN_ID_KASIR, 'modul_id'=>19),
                        ));
                    if($this->statusSaveKirimkeUnitLain && $this->statusSavePermintaanPenunjang){
                        $transaction->commit();
                        Yii::app()->user->setFlash('success',"Data Berhasil disimpan");
                        $this->redirect(array('index','pendaftaran_id'=>$pendaftaran_id,'pasienadmisi_id'=>$pasienadmisi_id, 'idPasienKirimKeUnitLain'=>$modKirimKeUnitLain->pasienkirimkeunitlain_id));
                    } else {
                        $transaction->rollback();
                        Yii::app()->user->setFlash('error',"Data tidak valid ");
                    }
                } catch (Exception $exc) {
                    $transaction->rollback();
                    Yii::app()->user->setFlash('error',"Data Gagal disimpan. ".MyExceptionMessage::getMessage($exc,true));
                }
                
            }
            		
            $modRiwayatKirimKeUnitLain = RIPasienKirimKeUnitLainT::model()->findAllByAttributes(array('pendaftaran_id'=>$pendaftaran_id,
                                                                                                      'ruangan_id'=>Params::RUANGAN_ID_BEDAH),
                                                                                                'pasienmasukpenunjang_id IS NULL');
            
			$modBayarUangMuka = RIBayaruangmukaT::model()->findAllByAttributes(array('pendaftaran_id'=>$pendaftaran_id));
			$total = 0;
			foreach ($modBayarUangMuka as $key => $value){
				$total += $modBayarUangMuka[$key]->jumlahuangmuka;
			}
			$modDeposit = (($modBayarUangMuka)?$total : null);
			
			$this->render('index',array('modPendaftaran'=>$modPendaftaran,
                                        'modPasien'=>$modPasien,
                                        'modKegiatanOperasi'=>$modKegiatanOperasi,
                                        'modOperasi'=>$modOperasi,
                                        'modKirimKeUnitLain'=>$modKirimKeUnitLain,
                                        'modRiwayatKirimKeUnitLain'=>$modRiwayatKirimKeUnitLain,
                                        'modAdmisi'=>$modAdmisi,
                                        'modPasienMasukPenunjang'=>$modPasienMasukPenunjang,
                                        'modJenisTarif'=>$modJenisTarif,
                                        'modDeposit'=>$modDeposit,
                                       ));
	}

        protected function savePasienKirimKeUnitLain($modAdmisi)
        {
            $modKirimKeUnitLain = new RIPasienKirimKeUnitLainT;
            $modKirimKeUnitLain->attributes = $_POST['RIPasienKirimKeUnitLainT'];
            $modKirimKeUnitLain->pasien_id = $modAdmisi->pasien_id;
            $modKirimKeUnitLain->pendaftaran_id = $modAdmisi->pendaftaran_id;
            $modKirimKeUnitLain->pegawai_id = $modAdmisi->pegawai_id;
            $modKirimKeUnitLain->kelaspelayanan_id = $modAdmisi->kelaspelayanan_id;
            $modKirimKeUnitLain->instalasi_id = Params::INSTALASI_ID_IBS;
            $modKirimKeUnitLain->ruangan_id = Params::RUANGAN_ID_BEDAH;
            $modKirimKeUnitLain->create_time = date("Y-m-d H:i:s");
            $modKirimKeUnitLain->update_time = date("Y-m-d H:i:s");
            $modKirimKeUnitLain->create_loginpemakai_id = Yii::app()->user->id;
            $modKirimKeUnitLain->update_loginpemakai_id = Yii::app()->user->id;
            $modKirimKeUnitLain->create_ruangan = Yii::app()->user->getState('ruangan_id');
			$modKirimKeUnitLain->tgl_kirimpasien = MyFormatter::formatDateTimeForDb($modKirimKeUnitLain->tgl_kirimpasien);
            $modKirimKeUnitLain->nourut = MyGenerator::noUrutPasienKirimKeUnitLain($modKirimKeUnitLain->ruangan_id);
            if($modKirimKeUnitLain->validate()){
                $modKirimKeUnitLain->save();
                $this->statusSaveKirimkeUnitLain = true;
            }
            
            return $modKirimKeUnitLain;
        }
        
        protected function savePermintaanPenunjang($permintaan,$modKirimKeUnitLain)
        {
            foreach ($permintaan['inputoperasi'] as $i => $value) {
                $modPermintaan = new RIPermintaanPenunjangT;
                $modPermintaan->daftartindakan_id = '';     //$permintaan['idDaftarTindakan'][$i];
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
                $modPasienAdmisi = PasienadmisiT::model()->findByPk($modPendaftaran->pasienadmisi_id);
                $jenistarif = JenistarifpenjaminM::model()->find('penjamin_id ='.$modPasienAdmisi->penjamin_id)->jenistarif_id;
                $modOperasi = OperasiM::model()->with('kegiatanoperasi')->findByPk($operasi_id);
                
                // var_dump($modOperasi->attributes); die;
                
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
                    'form'=>$this->renderPartial('_formLoadPermintaanOperasi', array('modOperasi'=>$modOperasi,
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
            $modRiwayatKirimKeUnitLain = RIPasienKirimKeUnitLainT::model()->findAllByAttributes(array('pendaftaran_id'=>$pendaftaran_id,
                                                                                                      'ruangan_id'=>Params::RUANGAN_ID_BEDAH));
            
            $data['result'] = $this->renderPartial('_listKirimKeUnitLain', array('modRiwayatKirimKeUnitLain'=>$modRiwayatKirimKeUnitLain), true);

            echo json_encode($data);
             Yii::app()->end();
            }
        }

        public function actionPrint()
        {
             $pendaftaran_id = $_GET['id'];
             $idPasienKirimKeUnitLain = $_GET['idPasienKirimKeUnitLain'];
             $modPendaftaran= PendaftaranT::model()->findByPk($pendaftaran_id);
             $modRiwayatKirimKeUnitLain = RIPasienKirimKeUnitLainT::model()->findAllByAttributes(array('pendaftaran_id'=>$pendaftaran_id,
                'pasienkirimkeunitlain_id'=>$idPasienKirimKeUnitLain),
                'pasienmasukpenunjang_id IS NULL');

            $judulLaporan='Permintaan Operasi';
            $caraPrint=$_REQUEST['caraPrint'];
            if($caraPrint=='PRINT') {
                $this->layout='//layouts/printWindows';
                $this->render('Print',array('modPendaftaran'=>$modPendaftaran,'modRiwayatKirimKeUnitLain'=>$modRiwayatKirimKeUnitLain,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint));
            }
            else if($caraPrint=='EXCEL') {
                $this->layout='//layouts/printExcel';
                $this->render('Print',array('modPendaftaran'=>$modPendaftaran,'modRiwayatKirimKeUnitLain'=>$modRiwayatKirimKeUnitLain,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint));
            }
            else if($_REQUEST['caraPrint']=='PDF') {
                $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
                $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
                $mpdf = new MyPDF('',$ukuranKertasPDF); 
                $mpdf->useOddEven = 2;  
                $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
                $mpdf->WriteHTML($stylesheet,1);  
                $mpdf->AddPage($posisi,'','','','',15,15,15,15,15,15);
                $mpdf->WriteHTML($this->renderPartial('Print',array('modPendaftaran'=>$modPendaftaran,'modRiwayatKirimKeUnitLain'=>$modRiwayatKirimKeUnitLain,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint),true));
                $mpdf->Output();
            }                       
        }

        public function actionPrintRiwayat()
        {
            $pendaftaran_id = $_GET['id'];
            $modPendaftaran= PendaftaranT::model()->findByPk($pendaftaran_id);
            $modKirimKeUnitLain = RIPasienKirimKeUnitLainT::model()->findAll('pendaftaran_id='.$pendaftaran_id);
            $modRiwayatKirimKeUnitLain = RIPasienKirimKeUnitLainT::model()->findAllByAttributes(array('pendaftaran_id'=>$pendaftaran_id,'ruangan_id'=>Params::RUANGAN_ID_BEDAH),'pasienmasukpenunjang_id IS NULL');
            $judulLaporan='Permintaan Operasi';
            $caraPrint=$_REQUEST['caraPrint'];
            if($caraPrint=='PRINT') {
                $this->layout='//layouts/printWindows';
                $this->render('printRiwayat',array('modKirimKeUnitLain'=> $modKirimKeUnitLain,'modPendaftaran'=>$modPendaftaran,'modRiwayatKirimKeUnitLain'=>$modRiwayatKirimKeUnitLain,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint));
            }
            else if($caraPrint=='EXCEL') {
                $this->layout='//layouts/printExcel';
                $this->render('printRiwayat',array('modKirimKeUnitLain'=> $modKirimKeUnitLain,'modPendaftaran'=>$modPendaftaran,'modRiwayatKirimKeUnitLain'=>$modRiwayatKirimKeUnitLain,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint));
            }
            else if($_REQUEST['caraPrint']=='PDF') {
                $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
                $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
                $mpdf = new MyPDF('',$ukuranKertasPDF); 
                $mpdf->useOddEven = 2;  
                $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
                $mpdf->WriteHTML($stylesheet,1);  
                $mpdf->AddPage($posisi,'','','','',15,15,15,15,15,15);
                $mpdf->WriteHTML($this->renderPartial('printRiwayat',array('modKirimKeUnitLain'=> $modKirimKeUnitLain,'modPendaftaran'=>$modPendaftaran,'modRiwayatKirimKeUnitLain'=>$modRiwayatKirimKeUnitLain,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint),true));
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