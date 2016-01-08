<?php
Yii::import('application.modules.rawatJalan.models.*');

class DaftarPasienController extends MyAuthController
{
        public $successPengambilanSample = false;
        public $successKirimSample = false;
	public function actionIndex()
	{
                $modPasienMasukPenunjang = new GZPasienMasukPenunjangV;
                $format = new MyFormatter();
                $modPasienMasukPenunjang->tgl_awal=date('d M Y');
                $modPasienMasukPenunjang->tgl_akhir=date('d M Y');
                if(isset ($_REQUEST['GZPasienMasukPenunjangV'])){
                    $modPasienMasukPenunjang->attributes=$_REQUEST['GZPasienMasukPenunjangV'];
                    $modPasienMasukPenunjang->tgl_awal = $format->formatDateTimeForDb($_REQUEST['GZPasienMasukPenunjangV']['tgl_awal']);
                    $modPasienMasukPenunjang->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['GZPasienMasukPenunjangV']['tgl_akhir']);
                }
		$this->render('index',array('modPasienMasukPenunjang'=>$modPasienMasukPenunjang));
	}
        
	public function actionDetails($pendaftaran_id,$pasien_id,$pasienmasukpenunjang_id)
	{
            $this->layout = '//layouts/printWindows';
            
            $masukpenunjang = PasienmasukpenunjangT::model()->findByPk($pasienmasukpenunjang_id);  
            $pemeriksa = PegawaiM::model()->findByPk($masukpenunjang->pegawai_id);
            
            $modHasilPeriksa = HasilpemeriksaanlabV::model()->findByAttributes(array('pasienmasukpenunjang_id'=>$pasienmasukpenunjang_id));
            $detailHasil = DetailhasilpemeriksaanlabT::model()->findAllByAttributes(array('hasilpemeriksaanlab_id'=>$modHasilPeriksa->hasilpemeriksaanlab_id),array('order'=>'detailhasilpemeriksaanlab_id'));
            $hasil = array();
            foreach ($detailHasil as $i => $detail) {
                $jenisPeriksa = $detail->pemeriksaanlab->jenispemeriksaan->jenispemeriksaanlab_nama;
                $kelompokDet = $detail->pemeriksaandetail->nilairujukan->kelompokdet;
                $hasil[$jenisPeriksa][$kelompokDet][$i]['namapemeriksaan'] = $detail->pemeriksaandetail->nilairujukan->namapemeriksaandet;
                $hasil[$jenisPeriksa][$kelompokDet][$i]['hasil'] = $detail->hasilpemeriksaan;
                $hasil[$jenisPeriksa][$kelompokDet][$i]['nilairujukan'] = $detail->nilairujukan;
                $hasil[$jenisPeriksa][$kelompokDet][$i]['satuan'] = $detail->hasilpemeriksaan_satuan;
                $hasil[$jenisPeriksa][$kelompokDet][$i]['keterangan'] = $detail->pemeriksaandetail->nilairujukan->nilairujukan_keterangan;
            }
            
            $this->render('details',array('modHasilPeriksa'=>$modHasilPeriksa,
                                               'detailHasil'=>$detailHasil,
                                               'hasil'=>$hasil, 
                                               'masukpenunjang'=>$masukpenunjang,
                                               'pemeriksa'=>$pemeriksa));
	}
        
        public function actionPrint($pasienmasukpenunjang_id,$caraPrint){
            $judulLaporan = 'Laporan Detail Permintaan Penawaran';
            $masukpenunjang = PasienmasukpenunjangT::model()->findByPk($pasienmasukpenunjang_id);  
            $pemeriksa = PegawaiM::model()->findByPk($masukpenunjang->pegawai_id);            
            $modHasilPeriksa = HasilpemeriksaanlabV::model()->findByAttributes(array('pasienmasukpenunjang_id'=>$pasienmasukpenunjang_id));
            $detailHasil = DetailhasilpemeriksaanlabT::model()->findAllByAttributes(array('hasilpemeriksaanlab_id'=>$modHasilPeriksa->hasilpemeriksaanlab_id),array('order'=>'detailhasilpemeriksaanlab_id'));
            $hasil = array();
            foreach ($detailHasil as $i => $detail) {
                $jenisPeriksa = $detail->pemeriksaanlab->jenispemeriksaan->jenispemeriksaanlab_nama;
                $kelompokDet = $detail->pemeriksaandetail->nilairujukan->kelompokdet;
                $hasil[$jenisPeriksa][$kelompokDet][$i]['namapemeriksaan'] = $detail->pemeriksaandetail->nilairujukan->namapemeriksaandet;
                $hasil[$jenisPeriksa][$kelompokDet][$i]['hasil'] = $detail->hasilpemeriksaan;
                $hasil[$jenisPeriksa][$kelompokDet][$i]['nilairujukan'] = $detail->nilairujukan;
                $hasil[$jenisPeriksa][$kelompokDet][$i]['satuan'] = $detail->hasilpemeriksaan_satuan;
                $hasil[$jenisPeriksa][$kelompokDet][$i]['keterangan'] = $detail->pemeriksaandetail->nilairujukan->nilairujukan_keterangan;
            }
            
            if($caraPrint=='PRINT') {
                $this->layout='//layouts/printWindows';
//                $this->render('Print',array('judulLaporan'=>$judulLaporan,
//                                            'caraPrint'=>$caraPrint,
//                                            'modPermintaanPenawaran'=>$modPermintaanPenawaran,
//                                            'modPermintaanPenawaranDetails'=>$modPermintaanPenawaranDetails));
                $this->render('Print',array('judulLaporan'=>$judulLaporan,
                                            'caraPrint'=>$caraPrint,
                                                'modHasilPeriksa'=>$modHasilPeriksa,
                                               'detailHasil'=>$detailHasil,
                                               'hasil'=>$hasil, 
                                               'masukpenunjang'=>$masukpenunjang,
                                               'pemeriksa'=>$pemeriksa));
            }
            else if($caraPrint=='EXCEL') {
                $this->layout='//layouts/printExcel';
                $this->render('Print',array('judulLaporan'=>$judulLaporan,
                                            'caraPrint'=>$caraPrint,
                                                'modHasilPeriksa'=>$modHasilPeriksa,
                                               'detailHasil'=>$detailHasil,
                                               'hasil'=>$hasil, 
                                               'masukpenunjang'=>$masukpenunjang,
                                               'pemeriksa'=>$pemeriksa));
            }
            else if($_REQUEST['caraPrint']=='PDF') {
                $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
                $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
                $mpdf = new MyPDF('',$ukuranKertasPDF); 
                $mpdf->useOddEven = 2;  
                $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
                $mpdf->WriteHTML($stylesheet,1);  
                $mpdf->AddPage($posisi,'','','','',15,15,15,15,15,15);
                $mpdf->WriteHTML($this->renderPartial('Print',array('judulLaporan'=>$judulLaporan,
                                            'caraPrint'=>$caraPrint,
                                                'modHasilPeriksa'=>$modHasilPeriksa,
                                               'detailHasil'=>$detailHasil,
                                               'hasil'=>$hasil, 
                                               'masukpenunjang'=>$masukpenunjang,
                                               'pemeriksa'=>$pemeriksa),true));
                
                $mpdf->Output();
            }   
        }
        
        public function actionBatalPeriksaPasienLuar()
        {            
            $ajax = Yii::app()->request->isAjaxRequest;
            if($ajax){
                $idpendaftaran  = $_POST['idpendaftaran'];
                $pendaftaran    = PendaftaranT::model()->findByPk($idpendaftaran);
                $pasien         = PasienM::model()->findByPk($pendaftaran->pasien_id);
                $pasienMasukPenunjang   = PasienmasukpenunjangT::model()->findByAttributes(array('pasien_id'=>$pendaftaran->pasien_id));
                $hasilPemeriksaanLab    = HasilpemeriksaanlabT::model()->findByAttributes(array('pendaftaran_id'=>$idpendaftaran));
                
                $pasienKirimKeUnitLain  = PasienkirimkeunitlainT::model()->findByAttributes(array('pendaftaran_id'=>$idpendaftaran, 'instalasi_id'=>5));
                $detailHasilPemeriksaanLab = DetailhasilpemeriksaanlabT::model()->findAllByAttributes(array('hasilpemeriksaanlab_id'=>$hasilPemeriksaanLab->hasilpemeriksaanlab_id));
                
                $cekPasien = substr($pendaftaran->no_pendaftaran, 0,2);
//                jika pasien berasal dari pendaftaran pasien luar
                if($cekPasien=='LB'){
                    $transaction = Yii::app()->db->beginTransaction();
                    try{
    //                   update rujuakan_id = null terlebih dahulu di pendaftaran_t
                        $updateRujuakan             = PendaftaranT::model()->updateByPk($idpendaftaran, array('rujukan_id'=>null));
    //                    delete tabel rujukan sesuai dengan id_rujuan yang berada di pendaftaran_t
                        $deletePasienRujukan        = RujukanT::model()->deleteByPk($pendaftaran->rujukan_id); 
    //                    delete penagambilan sampel berdasarkan pasienmasukpenunjang_id di pasienmasukpenunjang_t
                        $deletePengambilanSample    = PengambilansampleT::model()->deleteAllByAttributes(array('pasienmasukpenunjang_id'=>$pasienMasukPenunjang->pasienmasukpenunjang_id));                    
    //                    delete detailhasilpemeriksaanlab_t berdasarkan dengan hasilpemeriksaanlab_id
                        $deleteDetailPemerriksaanLab= DetailhasilpemeriksaanlabT::model()->deleteAllByAttributes(array('hasilpemeriksaanlab_id'=>$hasilPemeriksaanLab->hasilpemeriksaanlab_id));
    //                    delete hasilpemeriksaanlab_t berdasarkan pendaftaran_id
                        $deleteHasilPemeriksaanLab  = HasilpemeriksaanlabT::model()->deleteAllByAttributes(array('pendaftaran_id'=>$idpendaftaran));
    //                    delete uabahcarabayar_t berdasarkan pendaftaran_id
                        $deleteUbahCarabayar        = UbahcarabayarR::model()->deleteAll('pendaftaran_id = '.$idpendaftaran);
    //                    delete tindakanpelayanan_t berdasarkan pendaftaran_id
                        $deleteTindakanPelayanan    = TindakanpelayananT::model()->deleteAll('pendaftaran_id = '.$idpendaftaran);
    //                    delete pasienmasuk penunjang berdasarkan pendaftaran_t
                        $deletePasienMasukPenunjang = PasienmasukpenunjangT::model()->deleteAllByAttributes(array('pendaftaran_id'=>$idpendaftaran));   
    //                    delete pendaftaran berdasarkan id_pendaftaran
                        $deletePendaftaran          = PendaftaranT::model()->deleteByPk($idpendaftaran);
    //                    delete pasie_m berdasarkan pasien_id
                        $deletePasien               = PasienM::model()->deleteByPk($pasien->pasien_id);
    //                    
    //                    $delete = $deletePasienRujukan && $deletePengambilanSample && $deleteUbahCarabayar && $deleteHasilPemeriksaanLab && $deleteTindakanPelayanan && $deletePasien && $deletePendaftaran;

                        if($deletePasien && $pendaftaran){
                            $data['status'] = 'success';
                            $transaction->commit();
                        }else{
                            $data['status'] = 'gagal';
                            $transaction->rollback();
                            throw new Exception("Pasien tidak bisa dibatalkan");
                        }

                    }catch(Exception $ex){
                         $transaction->rollback();
                         $data['status'] = 'gagal';
                         $data['info'] = $ex;
                     }      
                    
                }else{
                    $transaction = Yii::app()->db->beginTransaction();
                    try{
//                        echo "pasienkirimke unit lain->".$pasienKirimKeUnitLain->pasienmasukpenunjang_id;
//                        echo "----pasien masuk penunjang ->".$pasienKirimKeUnitLain->pasienmasukpenunjang_id;
                        $updatePasienKirimKeUnitLain = PasienkirimkeunitlainT::model()->updateByPk($pasienKirimKeUnitLain->pasienkirimkeunitlain_id, array('pasienmasukpenunjang_id'=>null));
                       
                        $deleteDetailPemerriksaanLab    = DetailhasilpemeriksaanlabT::model()->deleteAllByAttributes(array('hasilpemeriksaanlab_id'=>$hasilPemeriksaanLab->hasilpemeriksaanlab_id));
                            
                            foreach ($detailHasilPemeriksaanLab as $key => $deleteDetailHasil) {
                                $deleteTindakanPelayanan        = TindakanpelayananT::model()->deleteByPk($deleteDetailHasil->tindakanpelayanan_id);
                            }
                        
                        $deleteHasilPemeriksaanLab  = HasilpemeriksaanlabT::model()->deleteAllByAttributes(array('pendaftaran_id'=>$idpendaftaran));
//                        $deletePasienMasukPenunjang = PasienmasukpenunjangT::model()->deleteAllByAttributes(array('pendaftaran_id'=>$idpendaftaran)); 
                        $deletePasienMasukPenunjang = PasienmasukpenunjangT::model()->deleteByPk($pasienKirimKeUnitLain->pasienmasukpenunjang_id); 
                        if($deletePasienMasukPenunjang){
                            $data['status'] = 'success';
                                $transaction->commit();
                        }else{
                            $data['status'] = 'gagal';
                            $transaction->rollback();
                            throw new Exception("Pasien tidak bisa dibatalkan");
                        }

                    }catch(Exception $ex){
                         $transaction->rollback();
                         $data['status'] = 'gagal';
                         $data['info'] = $ex;
                     }              
                    
                }
                 
                echo json_encode($data);
                Yii::app()->end();
            }
        }
        
        public function actionGetRiwayatPasien($id){
            $this->layout='//layouts/iframe';
            $criteria = new CDbCriteria(array(
                    'condition' => 't.pasien_id = '.$id,
                //.'
                  //      and t.ruangan_id ='.Yii::app()->user->getState('ruangan_id'),
                    'order'=>'tgl_pendaftaran DESC',
                ));

            $pages = new CPagination(GZPendaftaranT::model()->count($criteria));
            $pages->pageSize = Params::JUMLAH_PERHALAMAN; //Yii::app()->params['postsPerPage'];
            $pages->applyLimit($criteria);
            
            $modKunjungan = GZPendaftaranT::model()->with('hasilpemeriksaanlab','anamnesa','pemeriksaanfisik','pasienmasukpenunjang','diagnosa')->
                    findAll($criteria);
            
           
            $this->render('/_periksaDataPasien/_riwayatPasien', array(
                    'pages'=>$pages,
                    'modKunjungan'=>$modKunjungan,
            ));
        }
        
        public function actionDetailKonsulGizi($id){
            $this->layout='//layouts/iframe';
            $modPendaftaran = GZPendaftaranT::model()->with('carabayar','penjamin')->findByPk($id);

			$modTindakan = GZTindakanpelayananT::model()->with('daftartindakan')->findAllByAttributes(array('pendaftaran_id'=>$id));
            $format = new MyFormatter;
            $modTindakanSearch = new GZTindakanpelayananT('search');
            $modPasien = GZPasienM::model()->findByPK($modPendaftaran->pasien_id);
//            $this->render('/_periksaDataPasien/_konsultasiGizi', //RND-7185
            $this->render('_detailKonsultasiGizi', 
                    array('modPendaftaran'=>$modPendaftaran, 
                        'modTindakan'=>$modTindakan,
                        'modTindakanSearch'=>$modTindakanSearch,
                        'modPasien'=>$modPasien));
        }
        
        public function actionDetailAnamnesaDiet($id){
            $this->layout='//layouts/iframe';
            $modPendaftaran = GZPendaftaranT::model()->with('carabayar','penjamin')->findByPk($id);

            // var_dump($id);exit();

            $modTindakan = GZAnamnesaDietT::model()->with('bahanmakanan','menudiet')->findAllByAttributes(array('pendaftaran_id'=>$id));
            $format = new MyFormatter;
            $modTindakanSearch = new GZAnamnesaDietT('search');
            $modPasien = GZPasienM::model()->findByPK($modPendaftaran->pasien_id);
            $this->render('/_periksaDataPasien/_anamnesaDiet', 
                    array('modPendaftaran'=>$modPendaftaran, 
                        'modTindakan'=>$modTindakan,
                        'modTindakanSearch'=>$modTindakanSearch,
                        'modPasien'=>$modPasien));
        }
		
		public function actionDetailPeriksaFisik($id){
            $this->layout='//layouts/iframe';
            $modPendaftaran = RJPendaftaranT::model()->with('carabayar','penjamin')->findByPk($id);
            $modPemeriksaanFisik = RJPemeriksaanFisikT::model()->findAllByAttributes(array('pendaftaran_id'=>$id),array('order'=>'create_time DESC'));
            $format = new MyFormatter;
            $modPemeriksaanFisikSearch = new RJPemeriksaanFisikT('search');
            $modPasien = RJPasienM::model()->findByPK($modPendaftaran->pasien_id);
            $this->render('/_periksaDataPasien/_periksafisik', 
                    array('modPendaftaran'=>$modPendaftaran, 
                        'modPemeriksaanFisik'=>$modPemeriksaanFisik,
                        'modPemeriksaanFisikSearch'=>$modPemeriksaanFisikSearch,
                        'modPasien'=>$modPasien));
        }
		
		public function actionDetailAnamnesa($id){
            $this->layout='//layouts/iframe';
            $modPendaftaran = RJPendaftaranT::model()->with('carabayar','penjamin')->findByPk($id);
            $modAnamnesa = RJAnamnesaT::model()->findAllByAttributes(array('pendaftaran_id'=>$id));
            $format = new MyFormatter;
            $modAnamnesaSearch = new RJAnamnesaT('search');
            $modPasien = RJPasienM::model()->findByPK($modPendaftaran->pasien_id);
            $this->render('/_periksaDataPasien/_anamnesa', 
                    array('modPendaftaran'=>$modPendaftaran, 
                        'modAnamnesa'=>$modAnamnesa,
                        'modAnamnesaSearch'=>$modAnamnesaSearch,
                        'modPasien'=>$modPasien));
        }
		
		public function actionDetailHasilLab($pendaftaran_id, $pasien_id, $pasienmasukpenunjang_id)
       {
           $this->layout = '//layouts/iframe';

           $cek_penunjang = LBPasienMasukPenunjangV::model()->findAllByAttributes(
               array('pendaftaran_id'=>$pendaftaran_id)
           );

           $data_rad = array();
           if(count($cek_penunjang) > 1)
           {
               $masukpenunjangRad = LBPasienMasukPenunjangV::model()->findByAttributes(
                   array(
                       'pendaftaran_id'=>$pendaftaran_id,                        
                       'ruangan_id'=>Params::RUANGAN_ID_RAD
                   )
               );

               $modHasilPeriksaRad = HasilpemeriksaanradV::model()->findAllByAttributes(
                   array(
                       'pasienmasukpenunjang_id'=>(isset($masukpenunjangRad->pasienmasukpenunjang_id)?$masukpenunjangRad->pasienmasukpenunjang_id:null)
                   ),
                   array(
                       'order'=>'pemeriksaanrad_urutan'
                   )
               );

               foreach($modHasilPeriksaRad as $i=>$val)
               {
                   $data_rad[] = array(
                       'pemeriksaan'=>$val['pemeriksaanrad_nama'],
   //                        'hasil'=>'Hasil Pemeriksaan ' . $val['pemeriksaanrad_nama'] . ' terlampir',
                       'hasil'=>'Hasil terlampir'
                   );
               }

           }

           $masukpenunjang = LBPasienMasukPenunjangV::model()->findByAttributes(
               array('pasienmasukpenunjang_id'=>$pasienmasukpenunjang_id)
           );

           $pemeriksa = PegawaiM::model()->findByPk($masukpenunjang->pegawai_id);

           $modHasilPeriksa = HasilpemeriksaanlabV::model()->findByAttributes(
               array(
                   'pasienmasukpenunjang_id'=>$pasienmasukpenunjang_id
               )
           );
           $kelompokUmur = (strtolower($masukpenunjang->golonganumur_nama)) == 'bayi' ? 'dewasa' : 'dewasa';   
           $query = "
               SELECT * FROM detailhasilpemeriksaanlab_t 
               JOIN pemeriksaanlab_m ON detailhasilpemeriksaanlab_t.pemeriksaanlab_id = pemeriksaanlab_m.pemeriksaanlab_id 
               JOIN pemeriksaanlabdet_m ON detailhasilpemeriksaanlab_t.pemeriksaanlabdet_id = pemeriksaanlabdet_m.pemeriksaanlabdet_id 
               JOIN jenispemeriksaanlab_m ON jenispemeriksaanlab_m.jenispemeriksaanlab_id = pemeriksaanlab_m.jenispemeriksaanlab_id
               JOIN nilairujukan_m ON nilairujukan_m.nilairujukan_id = pemeriksaanlabdet_m.nilairujukan_id
			   JOIN kelkumurhasillab_m ON kelkumurhasillab_m.kelkumurhasillab_id = nilairujukan_m.kelkumurhasillab_id
               WHERE detailhasilpemeriksaanlab_t.hasilpemeriksaanlab_id = '". $modHasilPeriksa->hasilpemeriksaanlab_id ."'
                   AND LOWER(nilairujukan_m.nilairujukan_jeniskelamin) = '".strtolower(trim($masukpenunjang->jeniskelamin))."'
                AND LOWER(kelkumurhasillab_m.kelkumurhasillabnama) = '".$kelompokUmur."'
               ORDER BY jenispemeriksaanlab_m.jenispemeriksaanlab_urutan, pemeriksaanlab_urutan, pemeriksaanlabdet_nourut
           ";
           $detailHasil = Yii::app()->db->createCommand($query)->queryAll();

           $data = array();
           $kelompokDet = null;
           $idx = 0;
           $temp = '';

           foreach ($detailHasil as $i => $detail)
           {
               $id_jenisPeriksa = $detail['jenispemeriksaanlab_id'];
               $jenisPeriksa = $detail['jenispemeriksaanlab_nama'];
               $kelompokDet = $detail['kelompokdet'];
               if($id_jenisPeriksa == '72')
               {
                   $query = "
                       SELECT jenispemeriksaanlab_m.* FROM pemeriksaanlabdet_m
                       JOIN pemeriksaanlab_m ON pemeriksaanlabdet_m.pemeriksaanlab_id = pemeriksaanlab_m.pemeriksaanlab_id
                       JOIN jenispemeriksaanlab_m ON jenispemeriksaanlab_m.jenispemeriksaanlab_id = pemeriksaanlab_m.jenispemeriksaanlab_id
                       WHERE nilairujukan_id = ". $detail['nilairujukan_id'] ." AND pemeriksaanlab_m.jenispemeriksaanlab_id <> ". $id_jenisPeriksa ."
                   ";
                   $rec = Yii::app()->db->createCommand($query)->queryRow();
                   $id_jenisPeriksa = $rec['jenispemeriksaanlab_id'];
                   $jenisPeriksa = $rec['jenispemeriksaanlab_nama'];
               }

               if($temp != $kelompokDet)
               {
                   $idx = 0;
               }

               $data[$id_jenisPeriksa]['tittle'] = $jenisPeriksa;
               $data[$id_jenisPeriksa]['grid'][$kelompokDet]['id'] = $id_jenisPeriksa;
               $data[$id_jenisPeriksa]['grid'][$kelompokDet]['nama'] = $jenisPeriksa;
               $data[$id_jenisPeriksa]['grid'][$kelompokDet]['kelompok'] = $kelompokDet;                
               $data[$id_jenisPeriksa]['grid'][$kelompokDet]['pemeriksaan'][$idx]['kelompok'] = $kelompokDet;
               $data[$id_jenisPeriksa]['grid'][$kelompokDet]['pemeriksaan'][$idx]['namapemeriksaan_det'] = $detail['pemeriksaanlab_nama'];
               $data[$id_jenisPeriksa]['grid'][$kelompokDet]['pemeriksaan'][$idx]['namapemeriksaan'] = $detail['namapemeriksaandet'];
               $data[$id_jenisPeriksa]['grid'][$kelompokDet]['pemeriksaan'][$idx]['id_pemeriksaan'] = $detail['nilairujukan_id'];
               $data[$id_jenisPeriksa]['grid'][$kelompokDet]['pemeriksaan'][$idx]['normal'] = $detail['nilairujukan_nama'];
               $data[$id_jenisPeriksa]['grid'][$kelompokDet]['pemeriksaan'][$idx]['metode'] = $detail['nilairujukan_metode'];
               $data[$id_jenisPeriksa]['grid'][$kelompokDet]['pemeriksaan'][$idx]['hasil'] = $detail['hasilpemeriksaan'];
               $data[$id_jenisPeriksa]['grid'][$kelompokDet]['pemeriksaan'][$idx]['nilairujukan'] = $detail['nilairujukan'];
               $data[$id_jenisPeriksa]['grid'][$kelompokDet]['pemeriksaan'][$idx]['satuan'] = $detail['hasilpemeriksaan_satuan'];
               $data[$id_jenisPeriksa]['grid'][$kelompokDet]['pemeriksaan'][$idx]['keterangan'] = $detail['nilairujukan_keterangan'];
               $temp = $kelompokDet;
               $idx++;
           }
           $this->render('/_periksaDataPasien/detailHasilLab', 
               array(
                  'modHasilPeriksa'=>$modHasilPeriksa,
                  'masukpenunjang'=>$masukpenunjang,
                  'pemeriksa'=>$pemeriksa,
                  'data'=>$data,
                  'data_rad'=>$data_rad
               )
           );
       }

       /**
        * actionDetailHasilRad = menampilkan hasil radiologi sesuai dengan rad
        * @param type $pendaftaran_id
        * @param type $pasien_id
        * @param type $pasienmasukpenunjang_id
        * @param type $caraPrint
        */
       public function actionDetailHasilRad($pendaftaran_id,$pasien_id,$pasienmasukpenunjang_id,$caraPrint='')
       {   
           $this->layout = '//layouts/iframe';
           $modPasienMasukPenunjang = ROPasienMasukPenunjangV::model()->findByAttributes(array('pasienmasukpenunjang_id'=>$pasienmasukpenunjang_id));
           $pemeriksa = PegawaiM::model()->findByAttributes(array('pegawai_id'=>$modPasienMasukPenunjang->pegawai_id));
           $detailHasil = HasilpemeriksaanradT::model()->findAllByAttributes(array('pasienmasukpenunjang_id'=>$pasienmasukpenunjang_id));

           $this->render('rawatInap.views.riwayatPasien.detailHasilRad',array('detailHasil'=>$detailHasil,
                                              'masukpenunjang'=>$modPasienMasukPenunjang,
                                              'pemeriksa'=>$pemeriksa,
                                              'caraPrint'=>$caraPrint,
                                               ));
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
                $pasienmasukpenunjang_id = ($_POST['pasienmasukpenunjang_id']);
                $keterangan = (isset($_POST['keterangan']) ? $_POST['keterangan'] : null);
                $pasienMasukPenunjang =  PasienmasukpenunjangT::model()->findByPk($pasienmasukpenunjang_id);

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
                
                if(isset($pasienMasukPenunjang)){
                    if($pasienMasukPenunjang->panggilantrian == true){
                        if($keterangan == "batal"){
                            $pasienMasukPenunjang->panggilantrian = false;
                            if($pasienMasukPenunjang->update()){
                                // SMS GATEWAY
                                $modPasien = $pasienMasukPenunjang->pasien;
                                $sms = new Sms();
                                $smspasien = 1;
                                foreach ($modSmsgateway as $i => $smsgateway) {
                                    $isiPesan = $smsgateway->templatesms;

                                    $attributes = $modPasien->getAttributes();
                                    foreach($attributes as $attributes => $value){
                                        $isiPesan = str_replace("{{".$attributes."}}",$value,$isiPesan);
                                    }
                                    $attributes = $pasienMasukPenunjang->getAttributes();
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
                                $data['nama_pasien'] = $modPasien->nama_pasien;
                                $data['pesan'] = "Pemanggilan no. antrian ".$pasienMasukPenunjang->no_urutperiksa." dibatalkan !";
                            }
                        }else{
                            $data['pesan'] = "No. antrian ".$pasienMasukPenunjang->no_urutperiksa." sudah dipanggil sebelumnya !";
                        }
                    }else{
                        $pasienMasukPenunjang->panggilantrian = true;
                        if($pasienMasukPenunjang->update()){
                            $data['pesan'] = "No. antrian ".$pasienMasukPenunjang->no_urutperiksa." dipanggil !";
              // $data_telnet = $pasienMasukPenunjang->ruangan->ruangan_nama.", ".$pasienMasukPenunjang->ruangan->ruangan_singkatan."-".$pasienMasukPenunjang->no_urutperiksa;
//              AKAN DIGANTI MENGGUNAKAN NODE JS
                // self::postTelnet($data_telnet);
                        }
                    }
                }

                $attributes = $pasienMasukPenunjang->attributeNames();
                foreach($attributes as $i=>$attribute) {
                    $data["$attribute"] = $pasienMasukPenunjang->$attribute;
                }
                echo CJSON::encode($data);
                Yii::app()->end();
            }
            else
                throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
        }

        public function actionGetAntrianTerakhir(){
            if(Yii::app()->request->isAjaxRequest)
            {

                $data['pesan'] = "";
                $criteria=new CDbCriteria;
                $criteria->addCondition('panggilantrian != TRUE');
                $criteria->addCondition('date(tglmasukpenunjang) BETWEEN \''.date('d M Y').'\' AND \''.date('d M Y').'\'');
                $criteria->order = 'no_urutperiksa ASC';

                $model = GZPasienMasukPenunjangV::model()->find($criteria);
                if(count($model)>0){
                  $data['pasienmasukpenunjang_id'] = $model->pasienmasukpenunjang_id;
                  $data['ruangan_singkatan'] = $model->ruangan_singkatan;
                  $data['no_urutperiksa'] = $model->no_urutperiksa;
                  $data['ruangan_id'] = $model->ruangan_id;
                }else{
                  $data['pesan'] = "Tidak ada antrian!";
                }
                echo CJSON::encode($data);
                Yii::app()->end();
            }
            else
                throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
        }
}