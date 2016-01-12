<?php
Yii::import('rawatJalan.controllers.PemeriksaanPasienController');
Yii::import('rawatJalan.models.*');
Yii::import('rawatJalan.views.*');
class PemeriksaanPasienMCController extends PemeriksaanPasienController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column1';
	public $defaultAction = 'index';
	public $path_view = 'rawatJalan.views.pemeriksaanPasien.';
	public $path_view_mcu = 'mcu.views.pemeriksaanPasienMC.';
	
	/**
	 * Lists all models.
	 */
	public function actionIndex($pendaftaran_id)
	{
		$modPendaftaran = RJPendaftaranT::model()->with('jeniskasuspenyakit')->findByPk($pendaftaran_id);
		$modPasien = RJPasienM::model()->findByPk($modPendaftaran->pasien_id);
		$this->render($this->path_view_mcu.'index',array(
			'modPendaftaran'=>$modPendaftaran,
			'modPasien'=>$modPasien,
		));
	}
	
	public function actionGetRiwayatPasien($pendaftaran_id){
		$this->layout='//layouts/iframe';
		$modKunjungan = MCPendaftaranT::model()->findByPk($pendaftaran_id);
		$modPasien = MCPasienM::model()->findByPk($modKunjungan->pasien_id);

		$this->render('_riwayatPasien', array(
				'modKunjungan'=>$modKunjungan,
				'modPasien'=>$modPasien,
		));
	}
	
	/**
	* actionDetailAnamnesa = menampilkan detail hasil pemeriksaan pada tab_Anamnesa untuk riwayat pasien
	* LNG-551
	*/
	public function actionDetailAnamnesa($id){
		$this->layout='//layouts/iframe';
		$modPendaftaran = RJPendaftaranT::model()->with('carabayar','penjamin')->findByPk($id);
		$modAnamnesa = AnamnesaT::model()->findAllByAttributes(array('pendaftaran_id'=>$id));
		$format = new MyFormatter;
		$modAnamnesaSearch = new AnamnesaT('search');
		$modPasien = RJPasienM::model()->findByPK($modPendaftaran->pasien_id);
		$this->render('_anamnesa', 
				array('modPendaftaran'=>$modPendaftaran, 
					'modAnamnesa'=>$modAnamnesa,
					'modAnamnesaSearch'=>$modAnamnesaSearch,
					'modPasien'=>$modPasien));
	}
	
	/**
	* actionDetailPeriksaFisik = menampilkan detail hasil pemeriksaan pada tab_Periksa Fisik untuk riwayat pasien
	* LNG-551
	*/
	public function actionDetailPeriksaFisik($id){
		$this->layout='//layouts/iframe';
		$modPendaftaran = RJPendaftaranT::model()->with('carabayar','penjamin')->findByPk($id);
		$modPemeriksaanFisik = PemeriksaanfisikT::model()->findAllByAttributes(array('pendaftaran_id'=>$id),array('order'=>'create_time DESC'));
		$format = new MyFormatter;
		$modPemeriksaanFisikSearch = new PemeriksaanfisikT('search');
		$modPasien = RJPasienM::model()->findByPK($modPendaftaran->pasien_id);
		$this->render('_periksafisik', 
				array('modPendaftaran'=>$modPendaftaran, 
					'modPemeriksaanFisik'=>$modPemeriksaanFisik,
					'modPemeriksaanFisikSearch'=>$modPemeriksaanFisikSearch,
					'modPasien'=>$modPasien));
	}
	
	/**
	* actionDetailTreadmill = menampilkan detail hasil pemeriksaan pada tab_Treadmill untuk riwayat pasien
	* LNG-551
	*/
	public function actionDetailTreadmill($id){
		$this->layout='//layouts/iframe';
		$modPendaftaran = RJPendaftaranT::model()->with('carabayar','penjamin')->findByPk($id);
		$modTreadmill = MCTreadmillT::model()->findAllByAttributes(array('pendaftaran_id'=>$id),array('order'=>'create_time DESC'));
		$format = new MyFormatter;
		$modTreadmillSearch = new MCTreadmillT('search');
		$modPasien = RJPasienM::model()->findByPK($modPendaftaran->pasien_id);
		$this->render('_treadmill', 
				array('modPendaftaran'=>$modPendaftaran, 
					'modTreadmill'=>$modTreadmill,
					'modTreadmillSearch'=>$modTreadmillSearch,
					'modPasien'=>$modPasien));
	}
	
	/**
	* actionDetailHearingTest = menampilkan detail hasil pemeriksaan pada tab_Hearing Test untuk riwayat pasien
	* LNG-551
	*/
	public function actionDetailHearingTest($id){
		$this->layout='//layouts/iframe';
		$modPendaftaran = RJPendaftaranT::model()->with('carabayar','penjamin')->findByPk($id);
		$modHearingtest = MCHearingtestT::model()->findAllByAttributes(array('pendaftaran_id'=>$id),array('order'=>'create_time DESC'));
		$format = new MyFormatter;
		$modHearingtestSearch = new MCHearingtestT('search');
		$modPasien = RJPasienM::model()->findByPK($modPendaftaran->pasien_id);
		$this->render('_hearingtest', 
				array('modPendaftaran'=>$modPendaftaran, 
					'modHearingtest'=>$modHearingtest,
					'modHearingtestSearch'=>$modHearingtestSearch,
					'modPasien'=>$modPasien));
	}
	
	/**
	* actionDetailKacamata = menampilkan detail hasil pemeriksaan pada tab_Kacamata Test untuk riwayat pasien
	* LNG-551
	*/
	public function actionDetailKacamata($id){
		$this->layout='//layouts/iframe';
		$modPendaftaran = RJPendaftaranT::model()->with('carabayar','penjamin')->findByPk($id);
		$modPeriksakacamata = MCPeriksakacamataT::model()->findAllByAttributes(array('pendaftaran_id'=>$id),array('order'=>'create_time DESC'));
		$format = new MyFormatter;
		$modPeriksakacamataSearch = new MCPeriksakacamataT('search');
		$modPasien = RJPasienM::model()->findByPK($modPendaftaran->pasien_id);
		$this->render('_periksakacamata', 
				array('modPendaftaran'=>$modPendaftaran, 
					'modPeriksakacamata'=>$modPeriksakacamata,
					'modPeriksakacamataSearch'=>$modPeriksakacamataSearch,
					'modPasien'=>$modPasien));
	}
	
	/**
	* actionDetailJantungKoroner = menampilkan detail hasil pemeriksaan pada tab_Jantung Koroner untuk riwayat pasien
	* LNG-551
	*/
	public function actionDetailJantungKoroner($id){
		$this->layout='//layouts/iframe';
		$modPendaftaran = RJPendaftaranT::model()->with('carabayar','penjamin')->findByPk($id);
		$modJantungKoroner = MCJantungkoronerT::model()->findAllByAttributes(array('pendaftaran_id'=>$id),array('order'=>'create_time DESC'));
		$format = new MyFormatter;
		$modJantungKoronerSearch = new MCJantungkoronerT('search');
		$modPasien = RJPasienM::model()->findByPK($modPendaftaran->pasien_id);
		$this->render('_jantungkoroner', 
				array('modPendaftaran'=>$modPendaftaran, 
					'modJantungKoroner'=>$modJantungKoroner,
					'modJantungKoronerSearch'=>$modJantungKoronerSearch,
					'modPasien'=>$modPasien));
	}
	
	/**
	* actionDetailKesimpulanSaran = menampilkan detail hasil pemeriksaan pada tab_Kesimpulan dan Saran untuk riwayat pasien
	* LNG-551
	*/
	public function actionDetailKesimpulanSaran($id){
		$this->layout='//layouts/iframe';
		$modPendaftaran = RJPendaftaranT::model()->with('carabayar','penjamin')->findByPk($id);
		$modKesimpulanSaran = MCKesimpulanmcuT::model()->findAllByAttributes(array('pendaftaran_id'=>$id),array('order'=>'create_time DESC'));
		$format = new MyFormatter;
		$modKesimpulanSaranSearch = new MCKesimpulanmcuT('search');
		$modPasien = RJPasienM::model()->findByPK($modPendaftaran->pasien_id);
		$this->render('_kesimpulansaran', 
				array('modPendaftaran'=>$modPendaftaran, 
					'modKesimpulanSaran'=>$modKesimpulanSaran,
					'modKesimpulanSaranSearch'=>$modKesimpulanSaranSearch,
					'modPasien'=>$modPasien));
	}
	
	/**
	* actionDetailHasilDiagnosa = menampilkan detail hasil pemeriksaan pada tab_diagnosis untuk riwayat pasien
	* LNG-551
	*/
	public function actionDetailHasilDiagnosa($id){
             
		$this->layout='//layouts/iframe';

		$modPendaftaran = PendaftaranT::model()->findByPk($id);
		$modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
		$detailHasil = PasienmorbiditasT::model()->findAllByAttributes(array('pendaftaran_id'=>$id));

		$this->render('_detailhasildiagnosa',
			array('detailHasil'=>$detailHasil,
				'modPendaftaran'=>$modPendaftaran,
				'modPasien'=>$modPasien,
			));
	}
	
	/**
	* actionDetailHasilLab = mnampilkan hasil lab sesuai dengan yang dilab
	* @param type $pendaftaran_id
	* @param type $pasien_id
	* @param type $pasienmasukpenunjang_id
	*/
   public function actionDetailHasilLab($id)
   {
	   $this->layout = '//layouts/iframe';

	   $modPendaftaran = MCPendaftaranT::model()->findByPk($id);
	   $modPasien = MCPasienM::model()->findByPk($modPendaftaran->pasien_id);
	   
	   $cek_penunjang = PasienmasukpenunjangV::model()->findAllByAttributes(
		   array('pendaftaran_id'=>$id)
	   );

	   $data_rad = array();
	   if(count($cek_penunjang) > 1)
	   {
		   $masukpenunjangRad = PasienmasukpenunjangV::model()->findByAttributes(
			   array(
				   'pendaftaran_id'=>$id,                        
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

	   $masukpenunjang = PasienmasukpenunjangV::model()->findByAttributes(
		   array('pendaftaran_id'=>$id)
	   );

	   $pemeriksa = PegawaiM::model()->findByPk($masukpenunjang->pegawai_id);

	   $modHasilPeriksa = HasilpemeriksaanlabV::model()->findByAttributes(
		   array(
			   'pasienmasukpenunjang_id'=>$masukpenunjang->pasienmasukpenunjang_id
		   )
	   );
	   
	   
	   $kelompokUmur = (strtolower($masukpenunjang->golonganumur_nama)) == 'bayi' ? 'dewasa' : 'dewasa';   
	   
	   $detailHasil = array();
		if(count($modHasilPeriksa) > 0){
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
		}
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

	   $this->render('_detailhasillab',
		   array(
			  'modHasilPeriksa'=>$modHasilPeriksa,
			  'masukpenunjang'=>$masukpenunjang,
			  'pemeriksa'=>$pemeriksa,
			  'data'=>$data,
			  'data_rad'=>$data_rad,
			   'modPendaftaran'=>$modPendaftaran,
			   'modPasien'=>$modPasien
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
	public function actionDetailHasilRad($id)
	{   
		$this->layout = '//layouts/iframe';
		$modPasienMasukPenunjang = PasienmasukpenunjangV::model()->findByAttributes(array('pendaftaran_id'=>$id));
		$pemeriksa = PegawaiM::model()->findByAttributes(array('pegawai_id'=>$modPasienMasukPenunjang->pegawai_id));
		$detailHasil = HasilpemeriksaanradT::model()->findAllByAttributes(array('pasienmasukpenunjang_id'=>$modPasienMasukPenunjang->pasienmasukpenunjang_id));

		$this->render('_detailhasilrad',
			array('detailHasil'=>$detailHasil,
				'masukpenunjang'=>$modPasienMasukPenunjang,
				'pemeriksa'=>$pemeriksa,
			));
	}
}
