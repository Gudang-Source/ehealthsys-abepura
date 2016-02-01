<?php
//untuk actionDetailHasilLab
Yii::import('application.modules.laboratorium.models.LBPasienMasukPenunjangV');
//untuk actionDetailHasilRab
Yii::import('application.modules.radiologi.models.ROPasienMasukPenunjangV');
Yii::import('application.modules.rawatDarurat.models.RDPasienPulangT');
class DaftarPasienController extends MyAuthController
{
		public $path_view = 'rawatJalan.views.daftarPasien.';
	
		public $defaultAction = 'index';
        public $pasientersimpan = false;
        public $penanggungjawabtersimpan = false;
        public $rujukantersimpan = false;
        public $rujukrisukses = false;
        public $successSaveMasukKamar = false;
        public $admisitersimpan = false;
        public $masukkamartersimpan = false;
        public $pasienpulangtersimpan = false;
        public $asuransipasientersimpan = false;
        
	public function actionIndex()
	{
            $model = new RJInfokunjunganrjV('searchDaftarPasien');
            $model->unsetAttributes();
            $model->tgl_awal = date('d M Y');
            $model->tgl_akhir = date('d M Y');
            $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
            if(isset($_GET['RJInfokunjunganrjV'])){
                $model->attributes = $_GET['RJInfokunjunganrjV'];
                $format = new MyFormatter();
                $model->tgl_awal  = $format->formatDateTimeForDb($_REQUEST['RJInfokunjunganrjV']['tgl_awal']);
                $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['RJInfokunjunganrjV']['tgl_akhir']);
                $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
            }

             if (Yii::app()->request->isAjaxRequest) {
                    echo $this->renderPartial('_tablePasien', array('model'=>$model));
                }else{
                     $this->render('index',array('model'=>$model));
                }
	}


  public function actionRincian($id){
            $this->layout = '//layouts/iframe';
            $data['judulLaporan'] = 'Rincian Tagihan Pasien';
            $modPendaftaran = RJPendaftaranT::model()->findByPk($id);
            $modRincian = RJRinciantagihanpasienV::model()->findAllByAttributes(array('pendaftaran_id' => $id), array('order'=>'ruangan_id'));
            $data['nama_pegawai'] = LoginpemakaiK::model()->findByPK(Yii::app()->user->id)->pegawai->nama_pegawai;
//            $modRincian->pendaftaran_id = $id;
            $this->render('rawatJalan.views.rinciantagihanpasienV.rincian', array('modPendaftaran'=>$modPendaftaran, 'modRincian'=>$modRincian, 'data'=>$data));
        }

  public function actionInfoPasien($id){
      $this->layout = '//layouts/iframe';
      
      $modPendaftaran = RJPendaftaranT::model()->findByPk($id);
      $modRincian = RJInfokunjunganrjV::model()->findByAttributes(array('pendaftaran_id'=>$id));
      if($modPendaftaran->alihstatus)
      {
        $data['judulLaporan'] = 'Pasien Sedang di Rawat Inap';
      }
      elseif(!empty($modPendaftaran->pembayaranpelayanan_id) && $modPendaftaran->alihstatus==FALSE)
      {
        $data['judulLaporan'] = 'Pasien Sudah Melakukan Pembayaran';
      }else{
        $data['judulLaporan'] = 'Pasien Sudah Melakukan Pembatalan Pemeriksaan';
      }

      $this->render('infoPasien', array('modPendaftaran'=>$modPendaftaran, 'modRincian'=>$modRincian, 'data'=>$data));
      // $this->redirect(array('/rawatJalan/anamnesa','pendaftaran_id'=>$id));
  }

        /**
        * actionDetailHasilLab = mnampilkan hasil lab sesuai dengan yang dilab
        * @param type $pendaftaran_id
        * @param type $pasien_id
        * @param type $pasienmasukpenunjang_id
        */
       public function actionDetailHasilLab_old($pendaftaran_id, $pasien_id, $pasienmasukpenunjang_id)
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
		   
           $this->render('rawatInap.views.riwayatPasien.detailHasilLab',
               array(
                  'modHasilPeriksa'=>$modHasilPeriksa,
                  'masukpenunjang'=>$masukpenunjang,
                  'pemeriksa'=>$pemeriksa,
                  'data'=>$data,
                  'data_rad'=>$data_rad
               )
           );
       }
	   
	   public function actionDetailHasilLab($pasienmasukpenunjang_id)
       {
			$this->layout = '//layouts/iframe';
			$format = new MyFormatter();
			$judulLaporan = "Hasil Pemeriksaan Laboratorium";
			$modKunjungan = RJPasienMasukPenunjangV::model()->findByAttributes(array('pasienmasukpenunjang_id'=>$pasienmasukpenunjang_id));
			$modHasilPemeriksaan = RJHasilpemeriksaanlabT::model()->findByAttributes(array('pasienmasukpenunjang_id'=>$pasienmasukpenunjang_id));
			$criteria = new CDbCriteria();
			$criteria->join = "
							JOIN pemeriksaanlab_m ON pemeriksaanlab_m.pemeriksaanlab_id = t.pemeriksaanlab_id 
							JOIN pemeriksaanlabdet_m ON pemeriksaanlabdet_m.pemeriksaanlabdet_id = t.pemeriksaanlabdet_id 
							JOIN nilairujukan_m ON nilairujukan_m.nilairujukan_id = pemeriksaanlabdet_m.nilairujukan_id";
			$criteria->addCondition('t.hasilpemeriksaanlab_id = '.$modHasilPemeriksaan->hasilpemeriksaanlab_id);
			$criteria->order = "pemeriksaanlab_m.pemeriksaanlab_urutan ASC, pemeriksaanlabdet_m.pemeriksaanlabdet_nourut ASC";
			$modDetailHasilPemeriksaans = RJDetailhasilpemeriksaanlabT::model()->findAll($criteria);
			$this->render('rawatInap.views.riwayatPasien.detailHasilLab',array(
				'format'=>$format,
				'modKunjungan'=>$modKunjungan,
				'modHasilPemeriksaan'=>$modHasilPemeriksaan,
				'modDetailHasilPemeriksaans'=>$modDetailHasilPemeriksaans,
				'judulLaporan'=>$judulLaporan,
			));
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
        
        public function actionDetailKonsul($id){
            $this->layout='//layouts/iframe';
            $modPendaftaran = RJPendaftaranT::model()->with('carabayar','penjamin')->findByPk($id);
            $modRiwayatKonsulSearch = new RJKonsulPoliT('search');
            $format = new MyFormatter;
            $this->render('/_periksaDataPasien/_detailkonsulpoli', 
                    array('modPendaftaran'=>$modPendaftaran,
                        'modRiwayatKonsulSearch'=>$modRiwayatKonsulSearch));
        }
		
        public function actionDetailTindakan($id){
            $this->layout='//layouts/iframe';
            $modPendaftaran = RJPendaftaranT::model()->with('carabayar','penjamin')->findByPk($id);

            // var_dump($id);exit();

            $modTindakan = RJTindakanPelayananT::model()->with('daftartindakan')->findAllByAttributes(array('pendaftaran_id'=>$id));
            $format = new MyFormatter;
            $modTindakanSearch = new RJTindakanPelayananT('search');
            $modPasien = RJPasienM::model()->findByPK($modPendaftaran->pasien_id);
            $this->render('/_periksaDataPasien/_tindakan', 
                    array('modPendaftaran'=>$modPendaftaran, 
                        'modTindakan'=>$modTindakan,
                        'modTindakanSearch'=>$modTindakanSearch,
                        'modPasien'=>$modPasien));
        }
        
        /**
        * actionDetailPersalinan = menampilkan detail riwayat persalinan pasien
        * RSN-289
        */
        public function actionDetailPersalinan($id){
            $this->layout='//layouts/iframe';
            $modPendaftaran = RJPendaftaranT::model()->with('carabayar','penjamin')->findByPk($id);
            $modPersalinan = PersalinanT::model()->findAllByAttributes(array('pendaftaran_id'=>$id));
            $format = new MyFormatter;
            $modPersalinanSearch = new PersalinanT('search');
            $modPasien = RJPasienM::model()->findByPK($modPendaftaran->pasien_id);
            $this->render('/_periksaDataPasien/_persalinan', 
                    array('modPendaftaran'=>$modPendaftaran, 
                        'modPersalinan'=>$modPersalinan,
                        'modPersalinanSearch'=>$modPersalinanSearch,
                        'modPasien'=>$modPasien));
        }
	
        /**
        * actionDetailKelahiran = menampilkan detail riwayat kelahiran bayi pasien
        * RSN-289
        */
        public function actionDetailKelahiran($id){
            $this->layout='//layouts/iframe';
			$modKelahiran = array();
            $modPendaftaran = RJPendaftaranT::model()->with('carabayar','penjamin')->findByPk($id);
            $modPersalinan = PersalinanT::model()->findAllByAttributes(array('pendaftaran_id'=>$id));
			foreach($modPersalinan as $persalinan){
				$modKelahiran = KelahiranbayiT::model()->findByAttributes(array('persalinan_id'=>$persalinan->persalinan_id));
			}
            $format = new MyFormatter;
            $modKelahiranSearch = new KelahiranbayiT('search');
            $modPasien = RJPasienM::model()->findByPK($modPendaftaran->pasien_id);
            $this->render('/_periksaDataPasien/_kelahiran', 
                    array('modPendaftaran'=>$modPendaftaran, 
                        'modKelahiran'=>$modKelahiran,
                        'modKelahiranSearch'=>$modKelahiranSearch,
                        'modPasien'=>$modPasien));
        }
	
        /**
        * actionDetailAnamnesa = menampilkan detail hasil pemeriksaan pada tab_Anamnesa untuk riwayat pasien
        * RND-4100 
        */
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
        
        /**
        * actionDetailPeriksaFisik = menampilkan detail hasil pemeriksaan pada tab_Periksa Fisik untuk riwayat pasien
        * RND-4100 
        */
        public function actionDetailPeriksaFisik($id){
            $this->layout='//layouts/iframe';
            $modPendaftaran = RJPendaftaranT::model()->with('carabayar','penjamin')->findByPk($id);
            $modPemeriksaanFisik = RJPemeriksaanFisikT::model()->findAllByAttributes(array('pendaftaran_id'=>$id),array('order'=>'create_time DESC'));
            $format = new MyFormatter;
            $modPemeriksaanFisikSearch = new RJPemeriksaanFisikT('search');
            $modPasien = RJPasienM::model()->findByPK($modPendaftaran->pasien_id);
			$modPemeriksaanGambar = RJPemeriksaangambarT::model()->findAllByAttributes(array('pendaftaran_id'=>$id));
            $this->render('/_periksaDataPasien/_periksafisik', 
                    array('modPendaftaran'=>$modPendaftaran, 
                        'modPemeriksaanFisik'=>$modPemeriksaanFisik,
                        'modPemeriksaanFisikSearch'=>$modPemeriksaanFisikSearch,
                        'modPasien'=>$modPasien,
						'modPemeriksaanGambar'=>$modPemeriksaanGambar));
        }
        
        public function actionDetailTerapi($id){
            $this->layout='//layouts/iframe';
            $modPendaftaran = RJPendaftaranT::model()->with('carabayar','penjamin')->findByPk($id);
//            $modTerapi = RJPenjualanresepT::model()->with('reseptur')->findAllByAttributes(array('pendaftaran_id'=>$id));
            $modTerapi = ResepturT::model()->findAllByAttributes(array('pendaftaran_id'=>$id));
            $modDetailTerapi = new RJResepturDetailT('searchDetailTerapi');
            $format = new MyFormatter;
            $modPasien = RJPasienM::model()->findByPK($modPendaftaran->pasien_id);
            $this->render('/_periksaDataPasien/_terapi', 
                    array('modPendaftaran'=>$modPendaftaran, 
                        'modTerapi'=>$modTerapi,
                        'modDetailTerapi'=>$modDetailTerapi,
                        'modPasien'=>$modPasien));
        }
        
        public function actionDetailPemakaianBahan($id){
            $this->layout='//layouts/iframe';
            $modPendaftaran = RJPendaftaranT::model()->with('carabayar','penjamin')->findByPk($id);
            $modBahan = RJObatalkesPasienT::model()->with('obatalkes')->findAllByAttributes(array('pendaftaran_id'=>$id));
            $format = new MyFormatter;
            $modPemakaianBahan = new RJObatalkesPasienT;
            $modPasien = RJPasienM::model()->findByPK($modPendaftaran->pasien_id);
            $this->render('/_periksaDataPasien/_pemakaianBahan', 
                    array('modPendaftaran'=>$modPendaftaran, 
                        'modBahan'=>$modBahan,
                        'modPemakaianBahan'=>$modPemakaianBahan,
                        'modPasien'=>$modPasien));
        }
        
        public function actionGetRiwayatPasien($id){
            $this->layout='//layouts/iframe';
            $criteria = new CDbCriteria(array(
                    'condition' => 't.pasien_id = '.$id,
                //.'
                  //      and t.ruangan_id ='.Yii::app()->user->getState('ruangan_id'),
                    'order'=>'tgl_pendaftaran DESC',
                ));

            $pages = new CPagination(RJPendaftaranT::model()->count($criteria));
            $pages->pageSize = Params::JUMLAH_PERHALAMAN; //Yii::app()->params['postsPerPage'];
            $pages->applyLimit($criteria);
            
            $modKunjungan = RJPendaftaranT::model()->with('hasilpemeriksaanlab','anamnesa','pemeriksaanfisik','pasienmasukpenunjang','diagnosa')->
                    findAll($criteria);
            
           
            $this->render('/_periksaDataPasien/_riwayatPasien', array(
                    'pages'=>$pages,
                    'modKunjungan'=>$modKunjungan,
            ));
        }
        
        public function actionPrint($id = null)
         {
            //$this->layout='//layouts/iframe';
                                                              
            $modPendaftaran = RJPendaftaranT::model()->with('carabayar','penjamin')->findByPk($id);
            $modHasilLab = RJHasilpemeriksaanlabT::model()->findByAttributes(array('pendaftaran_id'=>$id));
            $modDetailHasilLab = RJDetailhasilpemeriksaanlabT::model()->with('pemeriksaanlab')->findAllByAttributes(array('hasilpemeriksaanlab_id'=>$modHasilLab->hasilpemeriksaanlab_id));
            $modDetailHasil = new RJDetailhasilpemeriksaanlabT();
            $format = new MyFormatter;
            $modHasilLab->tglhasilpemeriksaanlab = $format->formatDateTimeId($modHasilLab->tglhasilpemeriksaanlab);
           
            $modPasien = RJPasienM::model()->findByPK($modPendaftaran->pasien_id);
      
             $judulLaporan='Data Hasil Pemeriksaan Lab';
             $caraPrint=$_REQUEST['caraPrint'];
             
            if($caraPrint=='PRINT')
                {
                    $this->layout='//layouts/printWindows';
                    $this->render('/_periksaDataPasien/detailHasilLab', array('modPendaftaran'=>$modPendaftaran, 
                        'modHasilLab'=>$modHasilLab, 
                        'modDetailHasilLab'=>$modDetailHasilLab,
                        'modDetailHasil'=>$modDetailHasil,
                        'modPasien'=>$modPasien, 'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint));
                }
            else if($caraPrint=='EXCEL')    
                {
                    $this->layout='//layouts/printExcel';
                    $this->render('/_periksaDataPasien/detailHasilLab', array('modPendaftaran'=>$modPendaftaran, 
                        'modHasilLab'=>$modHasilLab, 
                        'modDetailHasilLab'=>$modDetailHasilLab,
                        'modDetailHasil'=>$modDetailHasil,
                        'modPasien'=>$modPasien,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint));
                }
            else if($_REQUEST['caraPrint']=='PDF')
                {
                   
                    $ukuranKertasPDF=Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
                    $posisi=Yii::app()->user->getState('posisi_kertas');                            //Posisi L->Landscape,P->Portait
                    $mpdf=new MyPDF('',$ukuranKertasPDF); 
                    $mpdf->useOddEven = 2;  
                    $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
                    $mpdf->WriteHTML($stylesheet,1);  
                    $mpdf->AddPage($posisi,'','','','',15,15,15,15,15,15);
                    $mpdf->WriteHTML($this->renderPartial('/_periksaDataPasien/detailHasilLab', array('modPendaftaran'=>$modPendaftaran, 
                        'modHasilLab'=>$modHasilLab, 
                        'modDetailHasilLab'=>$modDetailHasilLab,
                        'modDetailHasil'=>$modDetailHasil,
                        'modPasien'=>$modPasien,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint),true));
                    $mpdf->Output();
                }                       
         }
         
         public function actionPrint2($id = null)
         {
            //$this->layout='//layouts/iframe';
                
    //  $modPendaftaran = RJPendaftaranT::model()->with('carabayar','penjamin')->findByPk($id);
            $modPendaftaran = RJPendaftaranT::model()->findByPk($id);
                   $modRincian = RJRinciantagihanpasienV::model()->findAllByAttributes(array('pendaftaran_id' => $id), array('order'=>'ruangan_id'));
            $data['nama_pegawai'] = LoginpemakaiK::model()->findByPK(Yii::app()->user->id)->pegawai->nama_pegawai;
             
           
             $judulLaporan='Data Rincian';
             $caraPrint=$_REQUEST['caraPrint'];
             
            if($caraPrint=='PRINT')
                {
                    $this->layout='//layouts/printWindows';
                    $this->render('rawatJalan.views._periksaDataPasien/detailRincian', array('modPendaftaran'=>$modPendaftaran, 
                        'modRincian'=>$modRincian, 
                        
                       // 'modPasien'=>$modPasien, 
                        'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint
                        ));
                }
            else if($caraPrint=='EXCEL')    
                {
                    $this->layout='//layouts/printExcel';
                    $this->render('rawatJalan.views._periksaDataPasien/detailRincian', array('modPendaftaran'=>$modPendaftaran, 
                       'modRincian'=>$modRincian, 
                      //  'modPasien'=>$modPasien,
                        'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint
                       ));
                }
            else if($_REQUEST['caraPrint']=='PDF')
                {
                   
                    $ukuranKertasPDF=Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
                    $posisi=Yii::app()->user->getState('posisi_kertas');                            //Posisi L->Landscape,P->Portait
                    $mpdf=new MyPDF('',$ukuranKertasPDF); 
                    $mpdf->useOddEven = 2;  
                    $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
                    $mpdf->WriteHTML($stylesheet,1);  
                    $mpdf->AddPage($posisi,'','','','',15,15,15,15,15,15);
                    $mpdf->WriteHTML($this->renderPartial('rawatJalan.views._periksaDataPasien/detailRincian', array('modPendaftaran'=>$modPendaftaran,  'modRincian'=>$modRincian, 
                      
                       // 'modPasien'=>$modPasien,
                        'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint),true));
                    $mpdf->Output();
                }                       
         }
         
         public function actionGetRiwayat(){
            if (Yii::app()->request->isAjaxRequest)
            {
                $pasien_id = $_GET['pasien_id'];
                $page = $_GET['page'];
                if (empty($page)){
                    $page = 1;
                }
                //$modPendaftaran=RJPendaftaranT::model()->findByPk($pendaftaran_id);
            
                $modPasien = RJPasienM::model()->findByPk($pasien_id);
                echo CJSON::encode(array(
                    'status'=>'create_form', 
                    'div'=>$this->renderPartial('/_periksaDataPasien/_riwayatPasien', array('modPasien' => $modPasien, 'page'=>$page), true)));
                exit;               
            }
         }
         
//         public function actionBatalRawatInap()
//        {
//             if(Yii::app()->request->isAjaxRequest) {
//                $idOtoritas = $_POST['idOtoritas'];
//                $namaOtoritas = $_POST['namaOtoritas'];
//                $idPasienPulang=$_POST['idPasienPulang'];
//                $alasanPembatalan=$_POST['Alasan'];
//                $pendaftaran_id = $_POST['pendaftaran_id'];
//                
//                
//                $modPasienBatalPulang = new PasienbatalpulangT;    
//                $modPasienBatalPulang->namauser_otorisasi=$namaOtoritas;
//                $modPasienBatalPulang->iduser_otorisasi=$idOtoritas;
//                $modPasienBatalPulang->pasienpulang_id=$idPasienPulang;
//                $modPasienBatalPulang->tglpembatalan=date('Y-m-d H:i:s');
//                $modPasienBatalPulang->alasanpembatalan=$alasanPembatalan;
//                 $transaction = Yii::app()->db->beginTransaction();
//                 try{
//                    if($modPasienBatalPulang->save()){
//                        $pulang =  PasienpulangT::model()->updateByPk($idPasienPulang,array('pasienbatalpulang_id'=>$modPasienBatalPulang->pasienbatalpulang_id));
//                        $pendaftaran =  PendaftaranT::model()->updateByPk($pendaftaran_id,array('pasienpulang_id'=>null,'pasienadmisi_id'=>null));   
//                        if ($pulang && $pendaftaran){
//                            $data['status'] = 'success';
//                            $transaction->commit();
////                          
//                        }
//                        else{
//                            throw new Exception("Update Data Gagal");
//                        }
//                    }
//                    else{
//                        Throw new Exception("Pasien Batal Rawat Inap Gagal Disimpan");
//                    }
//                 }catch(Exception $ex){
//                     $transaction->rollback();
//                     $data['status'] = $ex;
//                 }
//
//                echo json_encode($data);
//                Yii::app()->end();
//                }
//        }
            
         
         public function actionBatalRawatInap($pendaftaran_id){
            $this->layout='//layouts/iframe';
			
			$ruangan_id = isset($_GET['ruangan_id']) ? $_GET['ruangan_id'] : Yii::app()->user->getState('ruangan_id');
            $modPendaftaran = RJPendaftaranT::model()->findByAttributes(array('pendaftaran_id'=>$pendaftaran_id));
            $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
            
            $modPasienBatalPulang = new PasienbatalpulangT; 
            $tersimpan='tidak';
            
            if(!empty($_POST['PasienbatalpulangT'])){
                $pasienPulangId = $_POST['pasienpulang_id'];
                $pendaftaran_id = $_POST['pendaftaran_id'];
                $format = new MyFormatter();
                $modPasienBatalPulang->attributes = $_POST['PasienbatalpulangT'];
                $modPasienBatalPulang->create_time = date('Y-m-d H:i:s');
                $modPasienBatalPulang->update_time = date('Y-m-d H:i:s');
                $modPasienBatalPulang->tglpembatalan = $format->formatDateTimeForDb($modPasienBatalPulang->tglpembatalan);
                $modPasienBatalPulang->namauser_otorisasi = Yii::app()->user->name;
                $modPasienBatalPulang->iduser_otorisasi = Yii::app()->user->id;
                $modPasienBatalPulang->create_loginpemakai_id = Yii::app()->user->id;
                $modPasienBatalPulang->update_loginpemakai_id = Yii::app()->user->id;
                $modPasienBatalPulang->create_ruangan = isset($_GET['ruangan_id']) ? $_GET['ruangan_id'] : Yii::app()->user->getState('ruangan_id');
                $modPasienBatalPulang->pasienpulang_id = $pasienPulangId;
                if($modPasienBatalPulang->validate()){
                    $transaction = Yii::app()->db->beginTransaction();
                    try {
                        if($modPasienBatalPulang->save()){
                            $pulang =  PasienpulangT::model()->updateByPk($pasienPulangId,array('pasienbatalpulang_id'=>$modPasienBatalPulang->pasienbatalpulang_id));
                            $pendaftaran =  PendaftaranT::model()->updateByPk($pendaftaran_id,array('pasienpulang_id'=>null,'statusperiksa'=>Params::STATUSPERIKSA_SEDANG_PERIKSA));   
                            if ($pulang && $pendaftaran){
                                $transaction->commit();
                                Yii::app()->user->setFlash('success',"Data berhasil disimpan");
                                $tersimpan='Ya';              
    //                          
                            }
                            else{
                                $transaction->rollback();
                                Yii::app()->user->setFlash('error',"Data gagal disimpan");
                            }
                        } else {
                            $transaction->rollback();
                            Yii::app()->user->setFlash('error',"Data gagal disimpanx");
                        }
                    } catch (Exception $exc) {
                        $transaction->rollback();
                        Yii::app()->user->setFlash('error',"Data gagal disimpan", MyExceptionMessage::getMessage($exc,false));
                    }
                } else{ 
                     Yii::app()->user->setFlash('error',"Data gagal disimpan");
                }
                
            }
            $this->render('formBatalRawatInap',array('modPasien'=>$modPasien,'modPendaftaran'=>$modPendaftaran, 'modPasienBatalPulang'=>$modPasienBatalPulang, 'tersimpan'=>$tersimpan));
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
         public function actionUbahStatusPeriksaRJ($id){
            $this->layout='//layouts/iframe';
            
            $format = new MyFormatter();
            $model = PendaftaranT::model()->findByPk($id);
            $model->tglselesaiperiksa = date('Y-m-d H:i:s');            
            if(isset($_POST['PendaftaranT'])){
                $update = PendaftaranT::model()->updateByPk($id,array('statusperiksa'=>$_POST['PendaftaranT']['statusperiksa'],'tglselesaiperiksa'=>$format->formatDateTimeForDb($_POST['PendaftaranT']['tglselesaiperiksa'])));
                    if($update){
                        Yii::app()->user->setFlash('success',"Data berhasil disimpan");
                        $this->refresh();
//                        echo CHtml::script("window.parent.$('#dialogUbahStatus').dialog('close');window.parent.$('#dialogUbahStatus').attr('src',,'');window.parent.$.fn.yiiGridView.update('{$_GET['id']}');");
//                        $this->redirect(array('index',array('id'=>$id)));
                    }else{
                        Yii::app()->user->setFlash('error',"Data Gagal Disimpan");
                    }
            }
            $this->render('_ubahStatusPeriksa', array(
                    'model'=>$model,
            ));
        }
        
        // -- Detail Hasil Diagnosa -- //
        
            public function actionDetailHasilDiagnosa($id){
             
            $this->layout='//layouts/iframe';
            
            $modPasienMasukPenunjang = RJPasienMasukPenunjangT::model()->findByAttributes(array('pendaftaran_id'=>$id));
            $modPendaftaran = PendaftaranT::model()->findByPk($id);
            $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
            $detailHasil = PasienmorbiditasT::model()->findAllByAttributes(array('pendaftaran_id'=>$id));
            
            $this->render('/_periksaDataPasien/detailHasilDiagnosa',array('detailHasil'=>$detailHasil,
                                               'modPasienMasukPenunjang'=>$modPasienMasukPenunjang,
                                               'modPendaftaran'=>$modPendaftaran,
                                               'modPasien'=>$modPasien,
                                                ));
        }
        // -- End Detail Hasil Diagnosa -- //
        
        // -- Detail Hasil Anamnesa -- //
        
            public function actionDetailHasilAnamnesa($id){
             
            $this->layout='//layouts/iframe';
            
            $modPasienMasukPenunjang = RJPasienMasukPenunjangT::model()->findByAttributes(array('pendaftaran_id'=>$id));
            $modPendaftaran = PendaftaranT::model()->findByPk($id);
            $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
            $detailHasil = AnamnesaT::model()->findAllByAttributes(array('pendaftaran_id'=>$id));
            
            $this->render('/_periksaDataPasien/detailHasilAnamnesa',array('detailHasil'=>$detailHasil,
                                               'modPasienMasukPenunjang'=>$modPasienMasukPenunjang,
                                               'modPendaftaran'=>$modPendaftaran,
                                               'modPasien'=>$modPasien,
                                                ));
        }
        // -- End Detail Hasil Anamnesas -- //
        
        // -- Detail Hasil Anamnesa -- //
        
            public function actionDetailHasilOperasi($id){
             
            $this->layout='//layouts/iframe';
            
            $modPasienMasukPenunjang = RJPasienMasukPenunjangT::model()->findByAttributes(array('pendaftaran_id'=>$id));
            $modPendaftaran = PendaftaranT::model()->findByPk($id);
            $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
            $detailHasil = AnamnesaT::model()->findAllByAttributes(array('pendaftaran_id'=>$id));
            
            $this->render('/_periksaDataPasien/detailHasilAnamnesa',array('detailHasil'=>$detailHasil,
                                               'modPasienMasukPenunjang'=>$modPasienMasukPenunjang,
                                               'modPendaftaran'=>$modPendaftaran,
                                               'modPasien'=>$modPasien,
                                                ));
        }
        // -- End Detail Hasil Anamnesas -- //
        
        public function actionRencanaKontrolPasienRJ($pendaftaran_id)
	{
             $this->layout='//layouts/iframe';
             $format = new MyFormatter;
             $model = new PendaftaranT;
             $model->tglrenkontrol = date('Y-m-d H:i:s');
             $tersimpan = 'Tidak';
             
             $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
             $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);

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
             
             if(isset($_POST['PendaftaranT'])){
                    $renKontrol = $format->formatDateTimeForDb($_POST['PendaftaranT']['tglrenkontrol']);
                    $pasien_id = $_POST['PendaftaranT']['pendaftaran_id'];
                    $transaction = Yii::app()->db->beginTransaction();
                  try {
                        $update = PendaftaranT::model()->updateByPk($pasien_id,array('tglrenkontrol'=>$renKontrol));

                        if($update){
                          // SMS GATEWAY
                            $modPegawai = $modPendaftaran->pegawai;
                            $modRuangan = $modPendaftaran->ruangan;
                            $modInstalasi = $modPendaftaran->instalasi;
                            $sms = new Sms();
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
                                $attributes = $modRuangan->getAttributes();
                                foreach($attributes as $attributes => $value){
                                    $isiPesan = str_replace("{{".$attributes."}}",$value,$isiPesan);
                                }
                                $attributes = $modInstalasi->getAttributes();
                                foreach($attributes as $attributes => $value){
                                    $isiPesan = str_replace("{{".$attributes."}}",$value,$isiPesan);
                                }
                                $isiPesan = str_replace("{{hari}}",MyFormatter::getDayName($modPendaftaran->tglrenkontrol),$isiPesan);
                                
                                if($smsgateway->tujuansms == Params::TUJUANSMS_PASIEN && $smsgateway->statussms){
                                    if(!empty($modPasien->no_mobile_pasien)){
                                        $sms->kirim($modPasien->no_mobile_pasien,$isiPesan);
                                    }else{
                                        $smspasien = 0;
                                    }
                                }
                            }
                            // END SMS GATEWAY

                            $transaction->commit();
                            Yii::app()->user->setFlash('success',"Data berhasil disimpan");
                            $tersimpan='Ya';   
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
//                        $params['create_ruangan'] = $modPendaftaran->ruangan_id;
//                        $params['judulnotifikasi'] = ($modPendaftaran->tglrenkontrol != null ? 'Rencana Kontrol Pasien' : 'Rencana Kontrol Pasien' );
//                        $nofitikasi = NotifikasiRController::insertNotifikasi($params);
                    
                   } catch (Exception $exc){
                        $transaction->rollback();
                        Yii::app()->user->setFlash('error',"Data gagal disimpan", MyExceptionMessage::getMessage($exc,false));
                   }
             }
             
             $model->tglrenkontrol = Yii::app()->dateFormatter->formatDateTime(
                                        CDateTimeParser::parse($model->tglrenkontrol, 'yyyy-MM-dd hh:mm:ss'));
             
             $this->render('formRencanaKontrol',array(
                                'modPasien'=>$modPasien,
                                'modPendaftaran'=>$modPendaftaran,
                                'model'=>$model,
                                'tersimpan'=>$tersimpan,
                                'smspasien'=>$smspasien
                          ));
	}
        
        public function actionPasienRujukRI()
        {
              if(Yii::app()->request->isAjaxRequest) {
              $pendaftaran_id= (isset($_POST['pendaftaran_id']) ? $_POST['pendaftaran_id'] : null);
              $pasien_id=  PendaftaranT::model()->findByPk($pendaftaran_id)->pasien_id;
                $modPasienPulang = new PasienpulangT;
                $modPasienPulang->pendaftaran_id=$pendaftaran_id;
                $modPasienPulang->pasien_id=$pasien_id;
                $modPasienPulang->tglpasienpulang=date('Y-m-d H:i:s');
                $modPasienPulang->carakeluar_id = Params::CARAKELUAR_ID_RAWATINAP;
                $modPasienPulang->kondisikeluar_id =Params::KONDISIKELUAR_ID_RAWATINAP;
                $modPasienPulang->ruanganakhir_id=Yii::app()->user->getState('ruangan_id');
                $modPasienPulang->lamarawat=0;
                $modPasienPulang->satuanlamarawat='lamarawat';
                if($modPasienPulang->save()){
                    PendaftaranT::model()->updateByPk($pendaftaran_id, array('pasienpulang_id'=>$modPasienPulang->pasienpulang_id,'statusperiksa'=>Params::STATUSPERIKSA_SEDANG_DIRAWATINAP));
                    $data['pesan']='Berhasil';
                }else{
                    $data['pesan']='Gagal';
                }
                    echo json_encode($data);
               Yii::app()->end();
              }
        }
		
        public function actionAlergiObat()
        {
			$this->layout='//layouts/iframe';
            $format = new MyFormatter();
			$datatable = '';
			$pendaftaran_id = $_GET['pendaftaran_id'];
			$modPendaftaran = RJPendaftaranT::model()->findByPk($pendaftaran_id);
            $modPasien = RJPasienM::model()->findByPk($modPendaftaran->pasien_id);
            $modAnamnesa = RJAnamnesaT::model()->findByAttributes(array('pendaftaran_id'=>$modPendaftaran->pendaftaran_id));
			if(!empty($modAnamnesa)){
				$modAnamnesa->riwayatalergiobat = preg_replace('/\s+/', '', $modAnamnesa->riwayatalergiobat);
				$datatable = explode(',', trim($modAnamnesa->riwayatalergiobat));
			}
			$this->render('_alergiObat', array(
                'modPendaftaran'=>$modPendaftaran,
                'modPasien'=>$modPasien,
				'modAnamnesa'=>$modAnamnesa,
				'datatable'=>$datatable
            ));
        }
        /**
		 * tindak lanjut pasien ke Instalasi Rawat Inap
		 * di extend ke rawat darurat (TindakLanjutRIDariRDController) (jika ada perubahan cek keduanya)
		 * @param type $instalasi_id
		 * @param type $pendaftaran_id
		 * @param type $pasienadmisi_id
		 */
		public function actionTindakLanjutRI($instalasi_id,$pendaftaran_id,$pasienadmisi_id=null){
            $this->layout='//layouts/iframe';
            $format = new MyFormatter();
			$ruangan_id = isset($_GET['ruangan_id']) ? $_GET['ruangan_id'] : Yii::app()->user->getState('ruangan_id');
            $modPendaftaran = RJPendaftaranT::model()->with('jeniskasuspenyakit')->findByPk($pendaftaran_id);
            $modPasien = RJPasienM::model()->findByPk($modPendaftaran->pasien_id);
            $modRujukan=new RJRujukanT;
            $modRujukanBpjs=new RJRujukanbpjsT;
            $modPasienAdmisi = new RJPasienAdmisiT;
            $modAsuransiPasien=new RJAsuransipasienM;
            $modAsuransiPasienBpjs =new RJAsuransipasienbpjsM;
            $modSep=new RJSepT;
            $status =0;

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

            if ($instalasi_id == Params::INSTALASI_ID_RD){
                $modPasienPulang = new RDPasienPulangT;
                $modPasienPulang->tglpasienpulang = date('d M Y H:i:s');
                $modPasienPulang->pendaftaran_id = $modPendaftaran->pendaftaran_id;
                $modPasienPulang->pasien_id = $modPasien->pasien_id;
                
                $date1 = $format->formatDateTimeForDb($modPendaftaran->tgl_pendaftaran);
                $date2 = date('Y-m-d H:i:s');
                $diff = abs(strtotime($date2) - strtotime($date1));
                $hours   = floor(($diff)/3600); 

                $modPasienPulang->lamarawat = $hours;
            }else{
                $modPasienPulang = array();
            }
            if (isset($_POST['RJPendaftaranT'])){
                $transaction = Yii::app()->db->beginTransaction();
                try {
					if (isset($_POST['RDPasienPulangT'])){ // Proses khusus dari rawat darurat
						$modPasienPulang = $this->savePasienPulang($modPasienPulang,$_POST['RDPasienPulangT']);
						$this->rujukrisukses = true;
					}else{
						$this->pasienpulangtersimpan = true;
						$modRujuk = $this->pulangRujukRI();
					}
                    if ($this->rujukrisukses == true){
						
						if(isset($_POST['RJPasienM'])){
							$modPasien = $this->simpanPasien($modPasien, $_POST['RJPasienM']);
						}else{
							$this->pasientersimpan = true;
						}
                        if($_POST['RJPendaftaranT']['is_bpjs']){
                            if(isset($_POST['RJRujukanbpjsT'])){
                                $modRujukanBpjs = $this->simpanRujukanBpjs($modRujukanBpjs, $_POST['RJRujukanbpjsT']);
                            } else {
                                $this->rujukantersimpan = true; 
                            }
                        }else{
                            $this->rujukantersimpan = true; 
                        }

                        if(isset($_POST['RJAsuransipasienM'])){
                            if(isset($_POST['RJAsuransipasienM']['asuransipasien_id'])){
                                if(!empty($_POST['RJAsuransipasienM']['asuransipasien_id'])){
                                    $modAsuransiPasien = RJAsuransipasienM::model()->findByPk($_POST['RJAsuransipasienM']['asuransipasien_id']);
                                }
                            }
							$modAsuransiPasien = $this->simpanAsuransiPasien($modAsuransiPasien, $_POST['RJPendaftaranT'], $modPasien, $_POST['RJAsuransipasienM']);
                        }else{
                            $this->asuransipasientersimpan = true;
                        }

                        if(isset($_POST['RJAsuransipasienbpjsM'])){
                            if(isset($_POST['RJAsuransipasienbpjsM']['asuransipasien_id'])){
                                if(!empty($_POST['RJAsuransipasienbpjsM']['asuransipasien_id'])){
                                    $modAsuransiPasienBpjs = RJAsuransipasienM::model()->findByPk($_POST['PPAsuransipasienbpjsM']['asuransipasien_id']);
                                }
                            }
							$modAsuransiPasienBpjs = $this->simpanAsuransiPasien($modAsuransiPasienBpjs, $_POST['PPPendaftaranT'], $modPasien, $_POST['PPAsuransipasienbpjsM']);
                        }else{
                            $this->asuransipasientersimpan = true;
                        }

                        if($_POST['RJPendaftaranT']['is_bpjs'] == true){
                            $modSep = $this->simpanSep($modPendaftaran,$modPasien,$modRujukanBpjs,$modAsuransiPasienBpjs,$_POST['RJSepT']);
                        }
                        $modPasienAdmisi = $this->simpanPasienAdmisi($modPendaftaran,$modPasien,$modPasienAdmisi,$_POST['RJPasienAdmisiT']);
						
						$this->simpanMasukKamar($modPendaftaran, $modPasien, $modPasienAdmisi);
                        
                        if($this->pasienpulangtersimpan && $this->pasientersimpan && $this->rujukantersimpan && $this->admisitersimpan && $this->masukkamartersimpan){
                            // SMS GATEWAY
                            $modPegawai = $modPendaftaran->pegawai;
                            $sms = new Sms();
                            
                            foreach ($modSmsgateway as $i => $smsgateway) {
                                $isiPesan = $smsgateway->templatesms;

                                $attributes = $modPegawai->getAttributes();
                                foreach($attributes as $attributes => $value){
                                    $isiPesan = str_replace("{{".$attributes."}}",$value,$isiPesan);
                                }
                                $attributes = $modPasien->getAttributes();
                                foreach($attributes as $attributes => $value){
                                    $isiPesan = str_replace("{{".$attributes."}}",$value,$isiPesan);
                                }
                                $attributes = $modPasienAdmisi->getAttributes();
                                foreach($attributes as $attributes => $value){
                                    $isiPesan = str_replace("{{".$attributes."}}",$value,$isiPesan);
                                }
                                $isiPesan = str_replace("{{hari}}",MyFormatter::getDayName($modPasienAdmisi->tgladmisi),$isiPesan);
                                
                                if($smsgateway->tujuansms == Params::TUJUANSMS_PASIEN && $smsgateway->statussms){
                                    if(!empty($modPasien->no_mobile_pasien)){
                                        $sms->kirim($modPasien->no_mobile_pasien,$isiPesan);
                                    }else{
                                        $smspasien = 0;
                                    }
                                }
                            }
                            // END SMS GATEWAY
                            $transaction->commit();
                            Yii::app()->user->setFlash('success', "Data pasien berhasil disimpan !");
                            $status = 1;
                        }else{
                            $transaction->rollback();
                            Yii::app()->user->setFlash('error', '<strong>Gagal</strong> Data Gagal disimpan');
                        }
                    } else {
                        $transaction->rollback();
                        Yii::app()->user->setFlash('error', '<strong>Gagal</strong> Data Gagal disimpan');
                    }
                    
                } catch (Exception $ex) {
                    $transaction->rollback();
                     Yii::app()->user->setFlash('error', '<strong>Gagal</strong> Data Gagal disimpan'.MyExceptionMessage::getMessage($ex));
                }
            }
            $this->render($this->path_view.'_tindakLanjutRI', array(
                'modPendaftaran'=>$modPendaftaran,
                'modPasien'=>$modPasien,
                'modPasienAdmisi'=>$modPasienAdmisi,
                'modPasienPulang'=>$modPasienPulang,
                'modAsuransiPasien'=>$modAsuransiPasien,
                'modAsuransiPasienBpjs'=>$modAsuransiPasienBpjs,
                'modRujukan'=>$modRujukan,
                'modRujukanBpjs'=>$modRujukanBpjs,
                'modSep'=>$modSep,
                'status'=>$status,
                'smspasien'=>$smspasien
            ));
            
        }
        
        protected function savePasienPulang($modPasienPulang,$attrPasienPulang,$pasienadmisi_id='')
        {
            $modelPulangNew = new RDPasienPulangT;
            $modelPulangNew->attributes = $attrPasienPulang;
            $modelPulangNew->satuanlamarawat = (Yii::app()->user->getState('instalasi_id') == Params::INSTALASI_ID_RD) ? Params::SATUAN_LAMARAWAT_RD : Params::SATUAN_LAMARAWAT_RI;
            $modelPulangNew->ruanganakhir_id = isset($_GET['ruangan_id']) ? $_GET['ruangan_id'] : Yii::app()->user->getState('ruangan_id');
            $modelPulangNew->create_time = date( 'Y-m-d H:i:s');
            $modelPulangNew->create_ruangan = isset($_GET['ruangan_id']) ? $_GET['ruangan_id'] : Yii::app()->user->getState('ruangan_id');
            $modelPulangNew->create_loginpemakai_id = Yii::app()->user->id;
            $modelPulangNew->pasienadmisi_id = (Yii::app()->user->getState('instalasi_id') == Params::INSTALASI_ID_RD) ? null : $pasienadmisi_id;

            if($modelPulangNew->save())
            {
                $this->pasienpulangtersimpan = true;
            }

            return $modelPulangNew;
        }
        
        public function pulangRujukRI()
        {
                $pendaftaran_id= (isset($_POST['RJPendaftaranT']['pendaftaran_id']) ? $_POST['RJPendaftaranT']['pendaftaran_id'] : isset($_GET['pendaftaran_id']) ? $_GET['pendaftaran_id'] : null);
                $pasien_id=  PendaftaranT::model()->findByPk($pendaftaran_id)->pasien_id;
                $modPasienPulang = new PasienpulangT;
                $modPasienPulang->pendaftaran_id=$pendaftaran_id;
                $modPasienPulang->pasien_id=$pasien_id;
                $modPasienPulang->tglpasienpulang=date('Y-m-d H:i:s');
                $modPasienPulang->carakeluar_id = Params::CARAKELUAR_ID_RAWATINAP;
                $modPasienPulang->kondisikeluar_id =Params::KONDISIKELUAR_ID_RAWATINAP;
                $modPasienPulang->ruanganakhir_id=isset($_GET['ruangan_id']) ? $_GET['ruangan_id'] : Yii::app()->user->getState('ruangan_id');
                $modPasienPulang->lamarawat=0;
                $modPasienPulang->satuanlamarawat='lamarawat';
                if($modPasienPulang->save()){
                    PendaftaranT::model()->updateByPk($pendaftaran_id, array('pasienpulang_id'=>$modPasienPulang->pasienpulang_id,'statusperiksa'=>Params::STATUSPERIKSA_SEDANG_DIRAWATINAP,'alihstatus'=>TRUE));
                    $this->rujukrisukses = true;
                }

                return $modPasienPulang;
              
        }
        
        /**
         * proses simpan / ubah data pasien
         * @param type $modPasien
         * @param type $post
         * @return type
         */
        public function simpanPasien($modPasien, $post){            
            $format = new MyFormatter();
            
            if(isset($post['pasien_id']) && (!empty($post['pasien_id']))){
                $load = new $modPasien;
                $modPasien = $load->findByPk($post['pasien_id']);
            }            
            $modPasien->attributes = $post;
            $modPasien->tanggal_lahir = $format->formatDateTimeForDb($modPasien->tanggal_lahir);
            $modPasien->kelompokumur_id = CustomFunction::getKelompokUmur($modPasien->tanggal_lahir);
            if(isset($post['tempPhoto'])){
                $modPasien->photopasien = $post['tempPhoto'];
            }
            if(empty($modPasien->pasien_id)){
                $modPasien->tgl_rekam_medik = date('Y-m-d H:i:s');
                $modPasien->profilrs_id = Params::DEFAULT_PROFIL_RUMAH_SAKIT;
                $modPasien->statusrekammedis = Params::STATUSREKAMMEDIS_AKTIF;
                $modPasien->ispasienluar = FALSE;
                $modPasien->create_ruangan = isset($_GET['ruangan_id']) ? $_GET['ruangan_id'] : Yii::app()->user->getState('ruangan_id');
                $modPasien->create_loginpemakai_id = Yii::app()->user->id;
                $modPasien->create_time = date('Y-m-d H:i:s');
                $modPasien->no_rekam_medik = MyGenerator::noRekamMedik();
            }else{
                $modPasien->update_loginpemakai_id = Yii::app()->user->id;
                $modPasien->update_time = date('Y-m-d H:i:s');
            }
            
            $modPasien->kelurahan_id = (!empty($modPasien->kelurahan_id) ? $modPasien->kelurahan_id : null);
            $modPasien->statusrekammedis = Params::STATUSREKAMMEDIS_AKTIF;
        
            if($modPasien->save()){
                $this->pasientersimpan = true;
            }
            
            return $modPasien;
        }
        
        /**
         * simpan MasukkamarT
         * ubah : KamarruanganM.kamarruangan_status, KamarruanganM.keterangan_kamar
		 * INI COPY DARI MODUL PP - PendaftaranRawatInapController
         * @param type $model
         * @param type $modPasien
         * @param type $modPasienAdmisi
         */
        public function simpanMasukKamar($model, $modPasien, $modPasienAdmisi)
        {
            $modMasukKamar = new MasukkamarT;
            $modMasukKamar->carabayar_id=$model->carabayar_id;
            $modMasukKamar->kamarruangan_id= (!empty($modPasienAdmisi->kamarruangan_id)) ? $modPasienAdmisi->kamarruangan_id : null;
            $modMasukKamar->kelaspelayanan_id = $modPasienAdmisi->kelaspelayanan_id;
            $modMasukKamar->ruangan_id= $modPasienAdmisi->ruangan_id;
            $modMasukKamar->pasienadmisi_id=$modPasienAdmisi->pasienadmisi_id;
            $modMasukKamar->pegawai_id=$model->pegawai_id;
            $modMasukKamar->penjamin_id=$model->penjamin_id;
            $modMasukKamar->shift_id=Yii::app()->user->getState('shift_id');
            $modMasukKamar->tglmasukkamar=date('Y-m-d H:i:s');
            $modMasukKamar->nomasukkamar=MyGenerator::noMasukKamar($modMasukKamar->ruangan_id);
            $modMasukKamar->jammasukkamar=date('H:i:s');
            $modMasukKamar->tglkeluarkamar=null;
            $modMasukKamar->jamkeluarkamar=null;
            $modMasukKamar->lamadirawat_kamar=null;
            $modMasukKamar->create_time = date("Y-m-d H:i:s");
            $modMasukKamar->create_loginpemakai_id = Yii::app()->user->id;
            $modMasukKamar->create_ruangan = Yii::app()->user->getState('ruangan_id');
			
            if($modMasukKamar->save()){
				if(!empty($modMasukKamar->kamarruangan_id)){
					KamarruanganM::model()->updateByPk($modMasukKamar->kamarruangan_id,array('kamarruangan_status'=>false, 'keterangan_kamar'=>'IN USE'));
				}
                $this->masukkamartersimpan=true;
            }else{
                $this->masukkamartersimpan=false;
            }
        }  
        
        /**
         * proses simpan data rujukan
         * @param type $modRujukan
         * @param type $post
         * @return type
         */
        public function simpanRujukanBpjs($modRujukanBpjs, $post){
            $format = new MyFormatter();
            $modRujukanBpjs->attributes = $post;
            $modRujukanBpjs->kddiagnosa_rujukan = isset($post['kddiagnosa_rujukan']) ? ((count($post['kddiagnosa_rujukan'])>0) ? implode(', ', $post['kddiagnosa_rujukan']) : '') : '';
            $modRujukanBpjs->diagnosa_rujukan = isset($post['diagnosa_rujukan']) ? ((count($post['diagnosa_rujukan'])>0) ? implode(', ', $post['diagnosa_rujukan']) : '') : '';
            $modRujukanBpjs->tanggal_rujukan = $format->formatDateTimeForDb($modRujukanBpjs->tanggal_rujukan);
            
            if($modRujukanBpjs->save()){
                $this->rujukantersimpan = true;
            }
            return $modRujukanBpjs;
        }
        /**
		 * simpan asuransi pasien
		 * @param type $modAsuransiPasien
		 * @param type $postPendaftaran
		 * @param type $postPasien
		 * @param type $postAsuransiPasien
		 * @return type
		 */
        public function simpanAsuransiPasien($modAsuransiPasien, $postPendaftaran, $postPasien, $postAsuransiPasien){
            $format = new MyFormatter();
            $modAsuransiPasien->attributes = $postAsuransiPasien;
            $modAsuransiPasien->pasien_id = isset($postPasien['pasien_id'])?$postPasien['pasien_id']:null;
            $modAsuransiPasien->penjamin_id = isset($postPendaftaran['penjamin_id'])?$postPendaftaran['penjamin_id']:null;
            $modAsuransiPasien->carabayar_id = isset($postPendaftaran['carabayar_id'])?$postPendaftaran['carabayar_id']:null;
            $modAsuransiPasien->create_loginpemakai_id = Yii::app()->user->id;
            $modAsuransiPasien->create_time = date("Y-m-d H:i:s");
            $modAsuransiPasien->tgl_konfirmasi = $format->formatDateTimeForDb($modAsuransiPasien->tgl_konfirmasi);
            if($modAsuransiPasien->save()){
                $this->asuransipasientersimpan = true;
            }
            return $modAsuransiPasien;
        }
        
        public function simpanSep($model,$modPasien,$modRujukanBpjs,$modAsuransiPasienBpjs,$postSep){
            $reqSep = null;
            $modSep = new RJSepT;
            $bpjs = new Bpjs();

            $modSep->tglsep = date('Y-m-d H:i:s');
            $modSep->nokartuasuransi = $modAsuransiPasienBpjs->nopeserta;
            $modSep->tglrujukan = $modRujukanBpjs->tanggal_rujukan;
            $modSep->norujukan = $modRujukanBpjs->no_rujukan;
            $modSep->ppkrujukan = $postSep['ppkrujukan']; 
            $modSep->ppkpelayanan = Yii::app()->user->getState('ppkpelayanan');
            $modSep->jnspelayanan = ($model->instalasi_id==Params::INSTALASI_ID_RI)?Params::JENISPELAYANAN_RI:Params::JENISPELAYANAN_RJ;
            $modSep->catatansep = $postSep['catatansep'];
            $data_diagnosa = explode(', ', $modRujukanBpjs->diagnosa_rujukan);
            $modSep->diagnosaawal = isset($data_diagnosa[0])?$data_diagnosa[0]:'';
            $modSep->politujuan = $model->ruangan_id;
            $modSep->klsrawat = $modAsuransiPasienBpjs->kelastanggunganasuransi_id;
            $modSep->tglpulang = date('Y-m-d H:i:s');
            $modSep->create_time = date('Y-m-d H:i:s');
            $modSep->create_loginpemakai_id = Yii::app()->user->id;
            $modSep->create_ruangan =isset($_GET['ruangan_id']) ? $_GET['ruangan_id'] : Yii::app()->user->getState('ruangan_id');
            
            $reqSep = json_decode($bpjs->create_sep($modSep->nokartuasuransi, $modSep->tglsep, $modSep->tglrujukan, $modSep->norujukan, $modSep->ppkrujukan, $modSep->ppkpelayanan, $modSep->jnspelayanan, $modSep->catatansep, $modSep->diagnosaawal, $modSep->politujuan, $modSep->klsrawat, Yii::app()->user->id, $modPasien->no_rekam_medik, $model->pendaftaran_id),true);
           
            if ($reqSep['metadata']['code']==200) {
                $modSep->nosep = $reqSep['response'];
                if($modSep->save()){
                    $this->septersimpan = true;
                }
            }
            
            return $modSep;
        }
        
        /**
         * simpan PPPasienAdmisiT
         * @param modPasienAdmisi $modPasienAdmisi
         * @param type $model
         * @param type $modPasien
         * @param type $post
         * @return \modPasienAdmisi
         */
        public function simpanPasienAdmisi($model,$modPasien,$modPasienAdmisi,$post)
        {
            $format = new MyFormatter();
            $modPasienAdmisi = new $modPasienAdmisi;
            $modPasienAdmisi->attributes = $post;
            if($model->instalasi_id == Params::INSTALASI_ID_RJ){
                $caramasuk_id = Params::CARAMASUK_ID_RJ;
            }else if($model->instalasi_id == Params::INSTALASI_ID_RD){
                $caramasuk_id = Params::CARAMASUK_ID_RD;
            }else{
                $caramasuk_id = Params::CARAMASUK_ID_LANGSUNG_RI;
            }
            $modPasienAdmisi->caramasuk_id = $caramasuk_id;
            $modPasienAdmisi->pendaftaran_id = $model->pendaftaran_id;
            $modPasienAdmisi->tglpendaftaran = $model->tgl_pendaftaran;
            $modPasienAdmisi->tgladmisi = date('Y-m-d H:i:s');
            $modPasienAdmisi->pasien_id = $model->pasien_id;
            $modPasienAdmisi->shift_id = Yii::app()->user->getState('shift_id');
            $modPasienAdmisi->kunjungan = CustomFunction::getKunjungan($modPasien, $modPasienAdmisi->ruangan_id);
            $modPasienAdmisi->create_ruangan = isset($_GET['ruangan_id']) ? $_GET['ruangan_id'] : Yii::app()->user->getState('ruangan_id');
            $modPasienAdmisi->tglpulang = null;
            $modPasienAdmisi->rencanapulang = null;
            $modPasienAdmisi->create_time = date("Y-m-d H:i:s");
            $modPasienAdmisi->create_loginpemakai_id = Yii::app()->user->id;
            
            if($modPasienAdmisi->save()) {
                //jika ada booking kamar (BELUM INTEGRASI)
//                BookingkamarT::model()->updateByPk($modPasienAdmisi->bookingkamar_id,array('pasienadmisi_id'=>$modPasienAdmisi->pasienadmisi_id,'pendaftaran_id'=>$modPasienAdmisi->pendaftaran_id));
                if(PendaftaranT::model()->updateByPk($modPasienAdmisi->pendaftaran_id,array('pasienadmisi_id'=>$modPasienAdmisi->pasienadmisi_id,'statusperiksa'=>Params::STATUSPERIKSA_SEDANG_DIRAWATINAP))){
                    $this->admisitersimpan = true;
                }else{
                    $this->admisitersimpan = false;
                }
            } else {
                $this->admisitersimpan = false;
            }
            return $modPasienAdmisi;
        }
        
        /**
         * set dropdown dokter
         */
        public function actionSetDropdownDokter()
        {
            if(Yii::app()->getRequest()->getIsAjaxRequest()) {
                $model = new RJPendaftaranT;
                $option = CHtml::tag('option',array('value'=>''),CHtml::encode('-- Pilih --'),true);
                if(!empty($_POST['ruangan_id'])){
                    $data = $model->getDokterItems($_POST['ruangan_id']);
                    $data = CHtml::listData($data,'pegawai_id','NamaLengkap');
                    foreach($data as $value=>$name){
                            $option .= CHtml::tag('option',array('value'=>$value),CHtml::encode($name),true);
                    }
                } 
                $dataList['listDokter'] = $option;
                echo json_encode($dataList);
                Yii::app()->end();
            }
        }
        
        /**
         * set antrian ruangan
         */
        public function actionSetAntrianRuangan(){
            if(Yii::app()->request->isAjaxRequest) { 
                $ruangan_id = $_POST['ruangan_id'];
                $data = array();
                $data['maxantrianruangan'] = null;
                $data['no_urutantri'] = '001';
                if(!empty($ruangan_id)){
                    $data['no_urutantri'] = MyGenerator::noAntrian($ruangan_id);
                    $criteria=new CDbCriteria;
					if(!empty($ruangan_id)){
						$criteria->addCondition("ruangan_id = ".$ruangan_id);						
					}
                    $modJadwalBukaPoli= JadwalbukapoliM::model()->findAll($criteria);
                    if (count($modJadwalBukaPoli) > 0){
                        foreach($modJadwalBukaPoli as $key=>$antrian){
                            $data['maxantrianruangan'] = $antrian->maxantiranpoli;     
                        }
                    }
                }
                echo json_encode($data);
             Yii::app()->end();
            }
        }
        
        /**
         * set dropdown jenis kasus penyakit
         */
        public function actionSetDropdownJeniskasuspenyakit()
        {
            if(Yii::app()->getRequest()->getIsAjaxRequest()) {
                $model = new RJPendaftaranT;
                $option = CHtml::tag('option',array('value'=>''),CHtml::encode('-- Pilih --'),true);
                if(!empty($_POST['ruangan_id'])){
                    $data = $model->getJenisKasusPenyakitItems($_POST['ruangan_id']);
                    $data = CHtml::listData($data,'jeniskasuspenyakit_id', 'jeniskasuspenyakit_nama');
                    foreach($data as $value=>$name){
                            $option .= CHtml::tag('option',array('value'=>$value),CHtml::encode($name),true);
                    }
                } 
                $dataList['listKasuspenyakit'] = $option;
                echo json_encode($dataList);
                Yii::app()->end();
            }
        }
        
        /**
         *penggunaannya
         * 1. digunakan di pendaftaran rawat inap
         * @param type $encode
         * @param type $namaModel
         * @param type $attr 
         */
        public function actionSetDropdownKamarKosong($encode=false,$namaModel='',$attr='')
        {
            if(Yii::app()->request->isAjaxRequest) {
                $ruangan_id = (isset($_POST['ruangan_id']) ? $_POST['ruangan_id'] : null);
                if (empty($ruangan_id) && isset($_POST[$namaModel]['ruangan_id']))
                    $ruangan_id = $_POST[$namaModel]['ruangan_id'];

                $bookingkamar_id = (isset($_POST['bookingkamar_id']) ? $_POST['bookingkamar_id'] : null);
                if (empty($bookingkamar_id) && isset($_POST[$namaModel]['bookingkamar_id']))
                    $bookingkamar_id = $_POST[$namaModel]['bookingkamar_id'];

                $kamarKosong = array();
                if(!empty($ruangan_id)) {
                    if(!empty($bookingkamar_id)){
                        $kamarKosong = KamarruanganM::model()->findAllByAttributes(array('ruangan_id'=>$ruangan_id,'kamarruangan_status'=>true));

                        $modBookingKamar = BookingkamarT::model()->findByPk($bookingkamar_id);
                    }else{
                        $kamarKosong = KamarruanganM::model()->findAllByAttributes(array('ruangan_id'=>$ruangan_id,'kamarruangan_status'=>true));
                    }
                    $kamarKosong = CHtml::listData($kamarKosong,'kamarruangan_id','KamarDanTempatTidur');
                }

                if($encode){
                    echo CJSON::encode($kamarKosong);
                } else {
                    if(empty($kamarKosong)){
                        echo CHtml::tag('option', array('value'=>''),CHtml::encode("-- Pilih --"),true);
                    }else{
                        echo CHtml::tag('option', array('value'=>''),CHtml::encode("-- Pilih --"),true);
                        foreach($kamarKosong as $value=>$name)
                        {
                            echo CHtml::tag('option', array('value'=>$value),CHtml::encode($name),true);
                        }
                    }
                }
            }
            Yii::app()->end();
        }
        
        /**
         * set dropdown penjamin pasien dari carabayar_id
         * @param type $encode
         * @param type $namaModel
         */
        public function actionSetDropdownPenjaminPasien($encode=false,$namaModel='')
        {
            if(Yii::app()->request->isAjaxRequest) {
                $carabayar_id = $_POST["$namaModel"]['carabayar_id'];
               if($encode)
               {
                    echo CJSON::encode($penjamin);
               } else {
                    if(empty($carabayar_id)){
                        echo CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
                    } else {
                        $penjamin = PenjaminpasienM::model()->findAllByAttributes(array('carabayar_id'=>$carabayar_id), array('order'=>'penjamin_nama ASC'));
                        if(count($penjamin) > 1)
                        {
                            echo CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
                        }
                        $penjamin = CHtml::listData($penjamin,'penjamin_id','penjamin_nama');
                        foreach($penjamin as $value=>$name) {
                            echo CHtml::tag('option', array('value'=>$value),CHtml::encode($name),true);
                        }
                    }
               }
            }
            Yii::app()->end();
        }
        
        /*
         * Mencari kelas pelayanan berdasarkan kamarruangan_id di tabel kamarruanganM
         * and open the template in the editor.
         */
        public function actionSetDropdownKelasPelayanan($encode=false,$namaModel='')
        {
            if(Yii::app()->request->isAjaxRequest) {
                $kamarruangan_id = $_POST["$namaModel"]['kamarruangan_id'];
                $kelasPelayanan = null;
                if($kamarruangan_id){
                    $kelasPelayanan = KamarruanganM::model()->with('kelaspelayanan')->findAll('kamarruangan_id='.$kamarruangan_id.'');
                    $kelasPelayanan=CHtml::listData($kelasPelayanan,'kelaspelayanan_id','kelaspelayanan.kelaspelayanan_nama');
                }
                if(empty($kelasPelayanan)){
                    echo CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
                }else{
                    echo CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
                    foreach($kelasPelayanan as $value=>$name)
                    {
                        echo CHtml::tag('option', array('value'=>$value),CHtml::encode($name),true);
                    }
                }
            }
            Yii::app()->end();
        }
        
        /**
         * set antrian dokter
         */
        public function actionSetAntrianDokter(){
            if(Yii::app()->request->isAjaxRequest) { 
                $ruangan_id = $_POST['ruangan_id'];
                $pegawai_id = $_POST['pegawai_id'];
                $data = array();
                $data['maxantriandokter'] = 0;
                if(!empty($ruangan_id) && !empty($pegawai_id)){
                    $criteria=new CDbCriteria;
					if(!empty($ruangan_id)){
						$criteria->addCondition("ruangan_id = ".$ruangan_id);						
					}
					if(!empty($pegawai_id)){
						$criteria->addCondition("pegawai_id = ".$pegawai_id);						
					}
                    $modJadwalDokter= JadwaldokterM::model()->findAll($criteria);
                    if (count($modJadwalDokter) > 0){
                        foreach($modJadwalDokter as $key=>$antrian){
                            $data['maxantriandokter'] = $antrian->maximumantrian;     
                        }

                    }
                }
                echo json_encode($data);
             Yii::app()->end();
            }
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
                $pendaftaran_id = ($_POST['pendaftaran_id']);
                $keterangan = (isset($_POST['keterangan']) ? $_POST['keterangan'] : null);
                $modPendaftaran =  PendaftaranT::model()->findByPk($pendaftaran_id);

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

                if(isset($modPendaftaran)){
                    if($modPendaftaran->panggilantrian == true){
                        if($keterangan == "batal"){
                            $modPendaftaran->panggilantrian = false;
                            if($modPendaftaran->update()){
                             
                              $data['pesan'] = "Pemanggilan no. antrian ".$modPendaftaran->no_urutantri." dibatalkan !";
                            }
                        }else{
                            
                            $data['pesan'] = "No. antrian ".$modPendaftaran->no_urutantri." dipanggil !";
                        }
                        $data['smspasien'] = 1;
                    }else{
                        $modPendaftaran->panggilantrian = true;
                        if($modPendaftaran->update()){
                            // SMS GATEWAY
                            $modPasien = $modPendaftaran->pasien;
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
                            $data['nama_pasien'] = $modPendaftaran->pasien->nama_pasien;
                            $data['pesan'] = "No. antrian ".$modPendaftaran->no_urutantri." dipanggil !";
							$data_telnet = $modPendaftaran->ruangan->ruangan_nama.", ".$modPendaftaran->ruangan->ruangan_singkatan."-".$modPendaftaran->no_urutantri;
							CustomFunction::postTelnet($data_telnet);
                        }
                    }
                }
                $attributes = $modPendaftaran->attributeNames();
                foreach($attributes as $i=>$attribute) {
                    $data["$attribute"] = $modPendaftaran->$attribute;
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
                $criteria->addCondition('date(tgl_pendaftaran) BETWEEN \''.date('d M Y').'\' AND \''.date('d M Y').'\'');
                $criteria->order = 'no_urutantri ASC';

                $model = RJInfokunjunganrjV::model()->find($criteria);
                if(count($model)>0){
                  $data['pendaftaran_id'] = $model->pendaftaran_id;
                  $data['ruangan_singkatan'] = $model->ruangan_singkatan;
                  $data['no_urutantri'] = $model->no_urutantri;
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
		
		/**
		 * batal periksa pasien RND-5542
		 */
		public function actionBatalPeriksa(){
      $nama_modul = Yii::app()->controller->module->id;
      $nama_controller = Yii::app()->controller->id;
      $nama_action = Yii::app()->controller->action->id;
      $modul_id = ModulK::model()->findByAttributes(array('url_modul'=>$nama_modul))->modul_id;
      $smspasien = 1;
      $smsdokter = 1;
      $criteria = new CDbCriteria;
      $criteria->compare('modul_id',$modul_id);
      $criteria->compare('LOWER(modcontroller)',strtolower($nama_controller),true);
      $criteria->compare('LOWER(modaction)',strtolower($nama_action),true);
      if(isset($_POST['tujuansms'])){
          $criteria->addInCondition('tujuansms',$_POST['tujuansms']);
      }
      $modSmsgateway = SmsgatewayM::model()->findAll($criteria);

			if(Yii::app()->request->isAjaxRequest)
			{ 
				$transaction = Yii::app()->db->beginTransaction();
				try{
					$pendaftaran_id = isset($_POST['pendaftaran_id']) ? $_POST['pendaftaran_id'] : null;
					$ruangan_id = isset($_POST['ruangan_id']) ? $_POST['ruangan_id'] : Yii::app()->user->getState('ruangan_id');
					$modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
					
					/*
					* cek data pendaftaran pasien masuk penunjang
					*/
					$criteria = new CDbCriteria();
					if(!empty($pendaftaran_id)){
						$criteria->addCondition("pendaftaran_id = ".$pendaftaran_id);						
					}

					$pasienMasukPenunjang = PasienmasukpenunjangT::model()->find($criteria);
					
					$pesan = '';
					$status = false;
					$model = new PasienbatalperiksaR();
					$model->pendaftaran_id = $pendaftaran_id;
					$model->pasien_id = $modPendaftaran->pasien_id;
					$model->tglbatal = date('Y-m-d');
					$model->keterangan_batal = "Batal Rawat Jalan";
					$model->create_ruangan = isset($_POST['ruangan_id']) ? $_POST['ruangan_id'] : Yii::app()->user->getState('ruangan_id');

					if($model->save())
					{
						$status = true;
						$pesan = "Pemeriksaan pasien berhasil dibatalkan!";
					}else{
						$status = false;
						$pesan = "Pemeriksaan gagal dibatalkan! ".CHtml::errorSummary($model);
					}
					
					$attributes = array(
						'pasienbatalperiksa_id' => $model->pasienbatalperiksa_id,
						'update_time' => date('Y-m-d H:i:s'),
						'update_loginpemakai_id' => Yii::app()->user->id
					);
					$pendaftaran = PendaftaranT::model()->updateByPk($pendaftaran_id, $attributes);
							
					if(count($pasienMasukPenunjang) > 0){
						if($pasienMasukPenunjang->pasienkirimkeunitlain_id == null)
						{
							$attributes = array(
								'pasienkirimkeunitlain_id' => $pasienMasukPenunjang->pasienkirimkeunitlain_id
							);
							$Perminataan_penunjang = PermintaankepenunjangT::model()->deleteAllByAttributes($attributes);
						}
					
						$attributes = array(
							'statusperiksa' => Params::STATUSPERIKSA_BATAL_PERIKSA,
							'update_time' => date('Y-m-d H:i:s'),
							'update_loginpemakai_id' => Yii::app()->user->id
						);
						$penunjang = PasienmasukpenunjangT::model()->updateByPk($pasienMasukPenunjang->pasienmasukpenunjang_id, $attributes);
						if(!$penunjang)
						{
							$status = false;
						}
						/*
						* cek data tindakan_pelayanan
						*/
					   $attributes = array(
						   'pasienmasukpenunjang_id' => $pasienMasukPenunjang->pasienmasukpenunjang_id,
						   'tindakansudahbayar_id' => null
					   );

					   $criteria2 = new CDbCriteria();
					   $criteria2->addCondition('pasienmasukpenunjang_id = '.$pasienMasukPenunjang->pasienmasukpenunjang_id);
					   $criteria2->addCondition('tindakansudahbayar_id is null');
					   $tindakan = TindakanpelayananT::model()->findAll($criteria2);

					   if(count($tindakan) > 0)
					   {

						   foreach($tindakan as $val=>$key)
						   {
							   $attributes = array(
								   'tindakanpelayanan_id' => $key->tindakanpelayanan_id
							   );
							   $hapus_komponen= TindakankomponenT::model()->deleteAllByAttributes($attributes);
						   }

						   $attributes = array(
							   'pasienmasukpenunjang_id' => $pasienMasukPenunjang->pasienmasukpenunjang_id
						   );

						   $hapus_tindakan = TindakanPelayananT::model()->deleteAllByAttributes($attributes);
						   if(!$hapus_tindakan)
						   {
							   $status = false;
							   $pesan = "exist";
						   }
					   }else{
						   $pesan = "exist";
					   }
					}
				   
				    /*
					* kondisi_commit
					*/
				   if($status == true)
				   {
            // SMS GATEWAY
            $modPegawai = $modPendaftaran->pegawai;
            $modPasien = $modPendaftaran->pasien;
            $sms = new Sms();
            foreach ($modSmsgateway as $i => $smsgateway) {
                $isiPesan = $smsgateway->templatesms;

                $attributes = $modPasien->getAttributes();
                foreach($attributes as $attributes => $value){
                    $isiPesan = str_replace("{{".$attributes."}}",$value,$isiPesan);
                }
                $attributes = $model->getAttributes();
                foreach($attributes as $attributes => $value){
                    $isiPesan = str_replace("{{".$attributes."}}",$value,$isiPesan);
                }
                $isiPesan = str_replace("{{hari}}",MyFormatter::getDayName($model->tglbatal),$isiPesan);

                if($smsgateway->tujuansms == Params::TUJUANSMS_PASIEN && $smsgateway->statussms){
                    if(!empty($modPasien->no_mobile_pasien)){
                        $sms->kirim($modPasien->no_mobile_pasien,$isiPesan);
                    }else{
                        $smspasien = 0;
                    }
                }elseif($smsgateway->tujuansms == Params::TUJUANSMS_DOKTER && $smsgateway->statussms){
                    if(!empty($modPegawai->nomobile_pegawai)){
                        $sms->kirim($modPegawai->nomobile_pegawai,$isiPesan);
                    }else{
                        $smsdokter = 0;
                    }
                }
                
            }
            // END SMS GATEWAY
					   $transaction->commit();
				   }else{
					   $transaction->rollback();

				   }
					
				}catch(Exception $ex){
					$status = false;
					$pesan = "exist";
					$transaction->rollback();
				}  
				
				$data = array(
					'pesan'=>$pesan,
					'status'=>$status,
          'smspasien'=>$smspasien,
          'smsdokter'=>$smsdokter,
          'nama_pasien'=>$modPasien->nama_pasien,
          'nama_pegawai'=>$modPegawai->nama_pegawai,
				);
				echo json_encode($data);
				Yii::app()->end();            
			}
		}
		
		/**
		 * untuk Ubah Dokter
		 */
		public function actionUbahDokterPeriksa()
		{
			$model = new RJPendaftaranT;
			$modUbahDokter = new RJUbahdokterR;
			$menu = (isset($_REQUEST['menu']) ? $_REQUEST['menu'] : "");
			if(isset($_POST['RJPendaftaranT']))
			{
				if($_POST['RJPendaftaranT']['pegawai_id'] != "")
				{
					$model->attributes = $_POST['RJPendaftaranT'];
					$modUbahDokter->attributes = $_POST['RJUbahdokterR'];
					$modUbahDokter->pendaftaran_id = $_POST['RJPendaftaranT']['pendaftaran_id'];
					$modUbahDokter->dokterbaru_id = $_POST['RJPendaftaranT']['pegawai_id'];
					$modUbahDokter->tglubahdokter = date('Y-m-d H:i:s');
					$modUbahDokter->create_time = date('Y-m-d H:i:s');
					$modUbahDokter->create_loginpemakai_id = Yii::app()->user->id;
					$modUbahDokter->create_ruangan = Yii::app()->user->getState('ruangan_id');
					$transaction = Yii::app()->db->beginTransaction();
					try {
						$attributes = array('pegawai_id'=>$_POST['RJPendaftaranT']['pegawai_id']);
						$save = $model::model()->updateByPk($_POST['RJPendaftaranT']['pendaftaran_id'], $attributes);
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
					'div'=>$this->renderPartial('_formUbahDokterPeriksa', array('model'=>$model,'modUbahDokter'=>$modUbahDokter,'menu'=>$menu), true)));
				exit;               
			}
		}
		
		public function actionGetDataPendaftaranRJ()
		{
			if (Yii::app()->request->isAjaxRequest){
				$id_pendaftaran = $_POST['pendaftaran_id'];
				$model = InfokunjunganrjV::model()->findByAttributes(array('pendaftaran_id'=>$id_pendaftaran));
				$attributes = $model->attributeNames();
				foreach($attributes as $j=>$attribute) {
					$returnVal["$attribute"] = $model->$attribute;
					$returnVal["gelarbelakang_nama"] = isset($model->gelarbelakang_nama) ? $model->gelarbelakang_nama : "";
					$returnVal["gelardepan"] = isset($model->gelardepan) ? $model->gelardepan : "";
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
                                        $idPegawai = $_POST['idPegawai'];
                                        
					$data = DokterV::model()->findAllByAttributes(array('ruangan_id'=>$idRuangan),array('order'=>'nama_pegawai',
                                            'condition'=>'pegawai_id <> '.$idPegawai,
                                        ));
					$data = CHtml::listData($data,'pegawai_id','namaLengkap');

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
		 * untuk Ubah Poliklinik
		 */
		public function actionUbahPoliklinik($pendaftaran_id)
		{
			$this->layout='//layouts/iframe';
			$modPendaftaran = RJPendaftaranT::model()->findByPk($pendaftaran_id);
			$modPasien = RJPasienM::model()->findByPk($modPendaftaran->pasien_id);
			if(isset($_POST['RJPendaftaranT']))
			{
				$modPendaftaran->attributes = $_POST['RJPendaftaranT'];
				$format = new MyFormatter();
				$transaction = Yii::app()->db->beginTransaction();
				try {
					$attributes = array(
							'ruangan_id'=>$modPendaftaran->ruangan_id, 
							'no_urutantri'=>MyGenerator::noAntrian($modPendaftaran->ruangan_id),
					  );
					
					$save = $modPendaftaran::model()->updateByPk($_POST['RJPendaftaranT']['pendaftaran_id'],$attributes);
					
					if($save)
					{
						$transaction->commit();
						Yii::app()->user->setFlash('success',"Data berhasil disimpan");              
						$this->redirect(array('ubahPoliklinik','pendaftaran_id'=>$modPendaftaran->pendaftaran_id,'sukses'=>1));
					}else{
						$transaction->rollback();
						Yii::app()->user->setFlash('error',"Data gagal disimpan");               
					}
					
				}catch(Exception $exc) {
					$transaction->rollback();
					Yii::app()->user->setFlash('error',"Data gagal disimpan");
				}

			}
			$this->render('_formUbahPoliklinik',array('modPasien'=>$modPasien,'modPendaftaran'=>$modPendaftaran));
		}
		
	/**
	 * ubah status dokumen
	 */
	public function actionStatusDokumenTerima()
	{
		if (Yii::app()->request->isAjaxRequest)
		{
			$pendaftaran_id = $_POST['pendaftaran_id'];
			$pengirimanrm_id = $_POST['pengirimanrm_id'];
			$statusdok = $_POST['status'];
			$update = false;
			$status = '';
			$div = '';
			$model = PendaftaranT::model()->findByPk($pendaftaran_id);
			if(!empty($pengirimanrm_id)){
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
   
   /**
	* Pengiriman Dokumen RM
	*/
   
   public function actionStatusDokumenKirim($pengirimanrm_id,$pendaftaran_id){
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
		
		$this->render($this->path_view.'_formStatusDokumen', array(
			'modPendaftaran'=>$modPendaftaran,
			'modPasien'=>$modPasien,
			'modPengirimanRm'=>$modPengirimanRm,
			'modUbahStatus'=>$modUbahStatus,
			'status'=>$status
		));            
	}
		
	/**
	 * penghapusan dokumen RM
	 */
	/**
	 * ubah status dokumen
	 */
	public function actionHapusDokumenPengiriman()
	{
		if (Yii::app()->request->isAjaxRequest)
		{
			$pendaftaran_id = $_POST['pendaftaran_id'];
			$pengirimanrm_id = $_POST['pengirimanrm_id'];
			$statusdok = $_POST['status'];
			$delete = false;
			$status = '';
			$div = '';
			$model = PendaftaranT::model()->findByPk($pendaftaran_id);
			if(!empty($pengirimanrm_id)){
				$model->pengirimanrm_id = null;
				$modPenerimaanRm = PengirimanrmT::model()->findByPk($pengirimanrm_id);      
				if($model->save()){
					$modPenerimaanRm->delete();
					$delete = true;
				}else{
					$delete = false;
				}
			}
			
			if($delete == true)
			{
				$status = 'proses_form';
				$div = "<div class='flash-success'>Data Dokumen Pasien <b></b> berhasil dihapus </div>";
			}else{
				$status = 'proses_form';
				$div = "<div class='flash-error'>Data Dokumen Pasien <b></b> gagal dihapus </div>";
			}
			
			echo CJSON::encode(array(
				'status'=>$status, 
				'div'=>$div,
				));
			exit;   
		}
   }
   /**
    * ambil status penerimaan dokumen
    */
	public function actionGetStatusPenerimaan()
	{
		if (Yii::app()->request->isAjaxRequest)
		{
			$pendaftaran_id = $_POST['pendaftaran_id'];
			$pengirimanrm_id = $_POST['pengirimanrm_id'];
			$ruanganpenerimaan_id = $_POST['ruanganpenerimaan_id'];
			$statusdok = $_POST['status'];
			$penerimaan = false;
			$div = '';
			$ruangan = '';
			$model = PendaftaranT::model()->findByPk($pendaftaran_id);
			if(!empty($pengirimanrm_id)){
				$modPenerimaanRm = PengirimanrmT::model()->findByPk($pengirimanrm_id);      
				if($modPenerimaanRm->ruanganpenerimaan_id == $ruanganpenerimaan_id){
					$penerimaan = true;
				}
			}
			
			if($penerimaan == true)
			{
				$div = "<div class='flash-success'>Dokumen Sudah Diterima Oleh Ruangan  <b>".$ruangan."</b></div>";
			}else{
				$div = "<div class='flash-error'>Dokumen Belum Diterima Oleh Ruangan  <b>".$ruangan."</b></div>";
			}
			
			echo CJSON::encode(array(
				'div'=>$div, 
				));
			exit;   
		}
   }
	/**
     * Mengatur dropdown ruangan
     * @param type $encode jika = true maka return array jika false maka set Dropdown 
     * @param type $model_nama
     * @param type $attr
     */
    public function actionSetDropdownRuangan($encode=false,$model_nama='',$attr='')
    {
        if(Yii::app()->request->isAjaxRequest) {
            $instalasi_id = null;
            if($model_nama !=='' && $attr == ''){
                $instalasi_id = $_POST["$model_nama"]['instalasi_id'];
            }
             else if ($model_nama == '' && $attr !== '') {
                $instalasi_id = $_POST["$attr"];
            }
             else if ($model_nama !== '' && $attr !== '') {
                $instalasi_id = $_POST["$model_nama"]["$attr"];
            }
            $models = null;
            $models = CHtml::listData(RuanganM::getRuanganByInstalasi($instalasi_id),'ruangan_id','ruangan_nama');

            if($encode){
                echo CJSON::encode($models);
            } else {
                echo CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
                if(count($models) > 0){
                    foreach($models as $value=>$name){
                        echo CHtml::tag('option', array('value'=>$value),CHtml::encode($name),true);
                    }
                }
            }
        }
        Yii::app()->end();
    }
	
	public function actionAutocompletePetugas()
    {
        if(Yii::app()->request->isAjaxRequest) {
            $criteria = new CDbCriteria();
            $criteria->compare('LOWER(nama_pegawai)', strtolower($_GET['term']), true);
            $criteria->order = 'nama_pegawai';
            $criteria->limit = 5;
            $models = PegawaiV::model()->findAll($criteria);
            foreach($models as $i=>$model)
            {
                $attributes = $model->attributeNames();
                foreach($attributes as $j=>$attribute) {
                    $returnVal[$i]["$attribute"] = $model->$attribute;
                }
                $returnVal[$i]['label'] = $model->gelardepan." ".$model->nama_pegawai." ".$model->gelarbelakang_nama;
                $returnVal[$i]['value'] = $model->pegawai_id;
                $returnVal[$i]['nama_pegawai'] = $model->NamaLengkap;
            }

            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }
	
	public function actionSetSedangPeriksa()
	{
		if(Yii::app()->request->isAjaxRequest) {
			$pendaftaran_id = $_POST['pendaftaran_id'];
			$update = PendaftaranT::model()->updateByPk($pendaftaran_id,array('statusperiksa'=>Params::STATUSPERIKSA_SUDAH_DIPERIKSA));
			echo CJSON::encode($update);
		}
	}
	
	/*
     * Ubah Status Periksa Pasien Baru -- Yang Pake Button
     */
	public function actionUbahStatusPeriksaPasien()
	{
	   $pendaftaran_id = isset($_POST['pendaftaran_id']) ? $_POST['pendaftaran_id'] : null;
	   $status = isset($_POST['status']) ? $_POST['status'] : null;
	   $model = PendaftaranT::model()->findByPk($pendaftaran_id);
	   $modBatalPeriksa = new PasienbatalperiksaR;
	   $model->tglselesaiperiksa = date('Y-m-d H:i:s');       
	   if(isset($_POST['status']))
	   {
			if($status == "ANTRIAN"){
				$update = PendaftaranT::model()->updateByPk($pendaftaran_id,array('statusperiksa'=>Params::STATUSPERIKSA_SEDANG_PERIKSA));
			}else{
			if($status == "SEDANG PERIKSA"){
				$update = PendaftaranT::model()->updateByPk($pendaftaran_id,array('statusperiksa'=>Params::STATUSPERIKSA_SUDAH_DIPERIKSA));
			}else if($status == "SEDANG DIRAWAT INAP"){
				$update = PendaftaranT::model()->updateByPk($pendaftaran_id,array('statusperiksa'=>Params::STATUSPERIKSA_SUDAH_PULANG));
			}
		  }
		  if($update)
		  {
				if (Yii::app()->request->isAjaxRequest)
				{
					echo CJSON::encode(array(
						'status'=>'proses_form', 
						'div'=>"<div class='flash-success'>Data Pasien <b></b> berhasil disimpan </div>",
						));
					exit;               
				}
		  }else{

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
	}
    /*
     * end Ubah Status Periksa Pasien Baru -- Yang Pake Button
     */
}