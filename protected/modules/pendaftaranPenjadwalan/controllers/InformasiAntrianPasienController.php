<?php

class InformasiAntrianPasienController extends MyAuthController
{
    
	public function actionIndex()
	{
            $format = new MyFormatter();
            $modInfoKunjunganV = new PPInfoKunjunganV;
            $modInfoKunjunganV->tgl_awal=date("Y-m-d");
            $modInfoKunjunganV->tgl_akhir=date("Y-m-d");
            if(isset($_REQUEST['PPInfoKunjunganV']))
            {
               $modInfoKunjunganV->attributes=$_REQUEST['PPInfoKunjunganV'];
               $modInfoKunjunganV->tgl_awal = $format->formatDateTimeForDb($_REQUEST['PPInfoKunjunganV']['tgl_awal']);
               $modInfoKunjunganV->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['PPInfoKunjunganV']['tgl_akhir']);  

            }
            $this->render('index',array('modInfoKunjunganV'=>$modInfoKunjunganV,'format'=>$format));
	}
        
        
//========================================================Awal Ubah Cara Bayar===========================================================        
        public function actionAjaxGetPenjamin()
        {
            if (Yii::app()->getRequest()->getIsAjaxRequest())
            {
               $penjamin = $_POST['penjamin_id'];
               $carabayar = $_POST['carabayar_id'];

               $dataPenjamin=PenjaminpasienM::model()->findAllByAttributes(array('carabayar_id'=>(int)$carabayar),array('order'=>'penjamin_nama'));
               foreach($dataPenjamin AS $tampilDataPenjamin):
                    if($tampilDataPenjamin['penjamin_id']==$penjamin)
                         {
                             $dropPenjamin=$dropPenjamin.'<option value="'.$tampilDataPenjamin['penjamin_id'].'" selected="selected">'.$tampilDataPenjamin['penjamin_nama'].'</option>';
                         }
                    else
                         {
                             $dropPenjamin=$dropPenjamin.'<option value="'.$tampilDataPenjamin['penjamin_id'].'">'.$tampilDataPenjamin['penjamin_nama'].'</option>';
                         }
                    endforeach;

               $data['penjamin']=$dropPenjamin;
               echo json_encode($data);
               Yii::app()->end();
            }
        }
        
        public function actionAjaxUpdateCaraBayarAntrian()
        {
            if (Yii::app()->getRequest()->getIsAjaxRequest()) 
             {
                $pendaftaran_id = $_POST['pendaftaran_id'];
                $penjamin = $_POST['penjamin_id'];
                $carabayar = $_POST['carabayar_id'];

                $transaction = Yii::app()->db->beginTransaction();
                try
                    {
                        $updatePendaftaran=PendaftaranT::model()->updateByPK($pendaftaran_id,array('carabayar_id' => $carabayar, 'penjamin_id' => $penjamin));
//                      $updateTindakanPelayanT=TindakanpelayananT::model()->updateAll(array('penjamin_id'=>$penjamin),"no_pendaftaran = '".$nopend."'"); 
                        $transaction->commit();
                        $data["message"]='Ubah Cara Bayar Untuk Pasien '.$nopend.' Berhasil';
                    }
               catch (Exception $e)
                    {
                        $transaction->rollback();
                        $data["message"]='Ubah Cara Bayar Untuk Pasien '.$nopend.' Gagal';
                    }

                echo json_encode($data);
                Yii::app()->end();
            }
        }
//==================================Akhir Ubah Cara Bayar=================================================================================

//==================================Awal batal Periksa============================================================================        
        public function actionUbahPeriksa()
        {
            if (Yii::app()->getRequest()->getIsAjaxRequest()) 
             { 
                $statusperiksa=$_POST['statusperiksa'];
                $pendaftaran_id=$_POST['pendaftaran_id']; 
                $data['message']='Masih Dalam Pengembangan Karena TAbel dan View Belum Ada';
                
              echo json_encode($data);
                Yii::app()->end();
            }
           
//             Dikomen dulu Bisi Prosesnya Beda N Karena Ada Tabel atwpun view yang Belum Ada
//           $dataTindakanPelID = TindakanpelayananT::model()->findAllByAttributes(array('no_pendaftaran'=>$nopend));
//            if(count($dataTindakanPelID)>0)
//            {    //Jika Tindakan Sudah Dilakukan
//                    if(count($dataTindakanPelID)>0)
//                     {
//                        foreach ($dataTindakanPelID AS $tampilTindakanPelID)
//                        {  
//                            $dataTindakanSudahBayar = TindakansudahbayarT::model()->findAllByAttributes(array('tindakanpel_id'=>$tampilTindakanPelID->tindakanpel_id));
//                            if(count($dataTindakanSudahBayar)>0)
//                            {  //Jika Ada Tindakan Sudah Dibayar
//                                Yii::app()->user->setFlash('error',"No. Pendaftaran ".$nopend." Sudah Melakukan Pembayan Tindakan"); 
//                                $this->redirect(''.bu().'/index.php/pendaftaran/informasiAntrianPasien/index');
////                                $this->redirect($url);
//                            }
//                            else
//                            {   //JIka Tindakab Belum Dibayar
//                                $transaction = Yii::app()->db->beginTransaction();
//                                try
//                                    {
//                                         foreach ($dataTindakanPelID AS $tampilTindakanPelID)
//                                         {  
//                                             $sqlHapusDokterTindakan = "DELETE FROM doktertindakan_t WHERE tindakanpel_id=".$tampilTindakanPelID['tindakanpel_id']."";
//                                             $hapusDokterTindakan = Yii::app()->db->createCommand($sqlHapusDokterTindakan)->queryAll();
//                                             $sqlHapusTindakanKomponen = "DELETE FROM tindakankomponen_t WHERE tindakanpel_id=".$tampilTindakanPelID['tindakanpel_id']."";
//                                             $hapusTindakanKomponen = Yii::app()->db->createCommand($sqlHapusTindakanKomponen)->queryAll();
//                                             $sqlHapusVerifikasiTindakan = "DELETE FROM verifikasitindakan_t WHERE tindakanpel_id=".$tampilTindakanPelID['tindakanpel_id']."";
//                                             $hapusVerifikasiTindakan = Yii::app()->db->createCommand($sqlHapusVerifikasiTindakan)->queryAll(); 
//                                             $sqlHapusParamedisNonParamedis= "DELETE FROM paramedisnonparamedis_t WHERE tindakanpel_id=".$tampilTindakanPelID['tindakanpel_id']."";
//                                             $hapusHapusParamedisNonParamedis = Yii::app()->db->createCommand($sqlHapusParamedisNonParamedis)->queryAll(); 
//                                             $hapusTindakanPelayan = TindakanpelayananT::model()->deleteByPk($tampilTindakanPelID['tindakanpel_id']);
//                                             $updatePendaftaran = PendaftaranT::model()->updateByPK($nopend,array('statusperiksa_id'=>Yii::app()->params['STATUSPERIKSA_BATAL_PERIKSA']));
//                                             $transaction->commit();
//                                             Yii::app()->user->setFlash('success',"Status Periksa No. Pendaftaran ".$nopend." Berhasil Diperbaharui"); 
//                                             header("Location:".bu()."/index.php/pendaftaran/informasiAntrianPasien/index");           
//                                          }
//                                       }
//                                catch (Exception $e)
//                                       {
//                                               $transaction->rollback();
//                                               Yii::app()->user->setFlash('error',"Proses Transaksi No. Pendaftaran ".$nopend." Gagal Diperbaharuiccdc"); 
//                                                header("Location:".bu()."/index.php/pendaftaran/informasiAntrianPasien/index");                                   
//                                       }     
//                            }    
//                        }
//
//                     }
//                    else
//                     { //Hapus Karcis
//                       $transaction = Yii::app()->db->beginTransaction();
//                        try
//                            { 
//                               foreach ($dataTindakanPelID AS $tampilTindakanPelID)
//                                {  
//                                    $sqlHapusDokterTindakan = "DELETE FROM doktertindakan_t WHERE tindakanpel_id=".$tampilTindakanPelID['tindakanpel_id']."";
//                                    $hapusDokterTindakan = Yii::app()->db->createCommand($sqlHapusDokterTindakan)->queryAll();
//                                    $sqlHapusTindakanKomponen = "DELETE FROM tindakankomponen_t WHERE tindakanpel_id=".$tampilTindakanPelID['tindakanpel_id']."";
//                                    $hapusTindakanKomponen = Yii::app()->db->createCommand($sqlHapusTindakanKomponen)->queryAll();
//                                    $sqlHapusVerifikasiTindakan = "DELETE FROM verifikasitindakan_t WHERE tindakanpel_id=".$tampilTindakanPelID['tindakanpel_id']."";
//                                    $hapusVerifikasiTindakan = Yii::app()->db->createCommand($sqlHapusVerifikasiTindakan)->queryAll(); 
//                                    $sqlHapusParamedisNonParamedis= "DELETE FROM paramedisnonparamedis_t WHERE tindakanpel_id=".$tampilTindakanPelID['tindakanpel_id']."";
//                                    $hapusHapusParamedisNonParamedis = Yii::app()->db->createCommand($sqlHapusParamedisNonParamedis)->queryAll(); 
//                                    $hapusTindakanPelayan = TindakanpelayananT::model()->deleteByPk($tampilTindakanPelID['tindakanpel_id']);
//                                    $updatePendaftaran = PendaftaranT::model()->updateByPK($nopend,array('statusperiksa_id'=>Yii::app()->params['STATUSPERIKSA_BATAL_PERIKSA']));
//                                    $transaction->commit();
//                                    Yii::app()->user->setFlash('success',"Status Periksa No. Pendaftaran ".$nopend." Berhasil Diperbaharui"); 
//                                    header("Location:".bu()."/index.php/pendaftaran/informasiAntrianPasien/index");           
//                                }
//                            }
//                         catch (Exception $e)
//                            {
//                             
//                                     $transaction->rollback();
//                                     Yii::app()->user->setFlash('error',"Proses Transaksi No. Pendaftaran ".$nopend." Gagal Diperbaharui zzz"); 
//                                     header("Location:".bu()."/index.php/pendaftaran/informasiAntrianPasien/index");           
//                            
//                             }  
//                    }  
//              } 
//              else
//              {   //Jika BVelum melakukan Tindakan
//                  $updatePendaftaran = PendaftaranT::model()->updateByPK($nopend,array('statusperiksa_id'=>Yii::app()->params['STATUSPERIKSA_BATAL_PERIKSA']));
//                  if($updatePendaftaran)
//                     { //Jika Update Berhasil
//                         Yii::app()->user->setFlash('success',"Status Periksa No. Pendaftaran ".$nopend." Berhasil Diperbaharui"); 
//                          header("Location:".bu()."/index.php/pendaftaran/informasiAntrianPasien/index");           
//                     }
//                  else
//                      { //Jika Updfate Gagal
//                         Yii::app()->user->setFlash('error',"Status Periksa No. Pendaftaran ".$nopend." Gagal Diperbaharui"); 
//                          header("Location:".bu()."/index.php/pendaftaran/informasiAntrianPasien/index");
//                      }  
//              }    
        }
//================================================Akhir batal Periksa===============================================================
        
//================================================Awal Print Lembar Poli============================================================
        public function actionPrintLembarPoli($pendaftaran_id)
        {
            $this->layout = '//layouts/printLembarPoli';
            $sql = "SELECT pendaftaran_t.no_pendaftaran,
                           pendaftaran_t.no_urutantri,
                           pendaftaran_t.tgl_pendaftaran,
                           pendaftaran_t.umur,
                           ruangan_m.ruangan_nama,
                           pasien_m.no_rekam_medik, 
                           penjaminpasien_m.penjamin_nama, 
                           carabayar_m.carabayar_nama, 
                           pasien_m.jeniskelamin, 
                           pasien_m.nama_pasien, 
                           pasien_m.nama_bin,
                           pasien_m.alamat_pasien, 
                           pasien_m.tanggal_lahir  
                    FROM pendaftaran_t
                    JOIN ruangan_m ON pendaftaran_t.ruangan_id = ruangan_m.ruangan_id
                    JOIN pasien_m ON pendaftaran_t.pasien_id = pasien_m.pasien_id 
                    JOIN carabayar_m ON carabayar_m.carabayar_id = pendaftaran_t.carabayar_id
                    JOIN penjaminpasien_m ON penjaminpasien_m.penjamin_id = pendaftaran_t.penjamin_id
                    
                    WHERE pendaftaran_t.pendaftaran_id ='$pendaftaran_id'";
            $result = Yii::app()->db->createCommand($sql)->queryRow();
//            daftartindakan_m.daftartindakan_nama
//                                       tindakanpelayanan_t.tarif_tindakan

//             tipepaket_m.tipepaket_nama,
//                                LEFT JOIN pegawai_m ON pendaftaran_t.pegawai_id = pegawai_m.pegawai_id
//            LEFT JOIN tindakanpelayanan_t ON tindakanpelayanan_t.no_pendaftaran = pendaftaran_t.no_pendaftaran 
//                    LEFT JOIN daftartindakan_m ON daftartindakan_m.daftartindakan_id = tindakanpelayanan_t.daftartindakan_id
//                    LEFT JOIN tipepaket_m ON tipepaket_m.tipepaket_id = tindakanpelayanan_t.tipepaket_id
// pegawai_m.nama_pegawai,
            $this->render('printLembarPoli',array(
			//'model'=>$model,
                        //'noPendaftaran'=>$idx,
                        'data'=>$result,
		));
        }
//==========================================================Akhir Print Lembar Poli===================================================        
    
}