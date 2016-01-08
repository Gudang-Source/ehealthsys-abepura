<?php

class DaftarPasienController extends MyAuthController
{
	public $successSave = false;
	public $successSaveJadwal = true;
	public $successSaveHasil = true;
      
	public function actionIndex()
	{
		$this->pageTitle = Yii::app()->name." - Daftar Pasien";
		$modPasienMasukPenunjang = new RMMasukPenunjangV;
		$format = new MyFormatter();
		$modPasienMasukPenunjang->tgl_awal = date("d M Y");
		$modPasienMasukPenunjang->tgl_akhir = date('d M Y');
		if(isset ($_REQUEST['RMMasukPenunjangV'])){
			 $modPasienMasukPenunjang->attributes=$_REQUEST['RMMasukPenunjangV'];
			 $modPasienMasukPenunjang->tgl_awal = $format->formatDateTimeForDb($_REQUEST['RMMasukPenunjangV']['tgl_awal']);
			 $modPasienMasukPenunjang->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['RMMasukPenunjangV']['tgl_akhir']);
			 $modPasienMasukPenunjang->ceklis = $_REQUEST['RMMasukPenunjangV']['ceklis'];
		}
		$this->render('index',array(
			'modPasienMasukPenunjang'=>$modPasienMasukPenunjang                                 
		));
	}

	Public function actionLihatHasil($id,$caraPrint=''){
		$this->layout = '//layouts/iframe';
		$judulLaporan = 'HASIL PEMERIKSAAN REHAB MEDIS';
		$modPasienMasukPenunjang = RMMasukPenunjangV::model()->findByAttributes(array('pendaftaran_id'=>$id));
		$detailHasil = HasilpemeriksaanrmT::model()->findAll('pendaftaran_id = '.$id);
		$this->render('/rinciantagihanpasienV/lihatHasil', 
			array('masukpenunjang'=>$modPasienMasukPenunjang,
				'judulLaporan'=>$judulLaporan,
				'detailHasil'=>$detailHasil,
				'caraPrint'=>$caraPrint,
			));
	}
	Public function actionRincian($id){
		$this->layout = '//layouts/iframe';
		$data['judulLaporan'] = 'Rincian Tagihan Pasien';
		$modPendaftaran = RMPendaftaranT::model()->findByPk($id);
		$modRincian = RMRinciantagihanpasienV::model()->findAllByAttributes(array('pendaftaran_id' => $id), array('order'=>'ruangan_id'));
		$data['nama_pegawai'] = LoginpemakaiK::model()->findByPK(Yii::app()->user->id)->pegawai->nama_pegawai;
//            $modRincian->pendaftaran_id = $id;
		$this->render('/rinciantagihanpasienV/rincian', array('modPendaftaran'=>$modPendaftaran, 'modRincian'=>$modRincian, 'data'=>$data));
	}
	Public function actionPrint($id){
		$this->layout = '//layouts/iframe';
		$data['judulLaporan'] = 'Rincian Tagihan Pasien';
		$caraPrint = isset($_GET['caraPrint']) ? $_GET['caraPrint'] : null;
		$modPendaftaran = RMPendaftaranT::model()->findByPk($id);
		$modRincian = RMRinciantagihanpasienV::model()->findAllByAttributes(array('pendaftaran_id' => $id), array('order'=>'ruangan_id'));
		$data['nama_pegawai'] = LoginpemakaiK::model()->findByPK(Yii::app()->user->id)->pegawai->nama_pegawai;

		 if($caraPrint=='PRINT')
		{
			$this->layout='//layouts/printWindows';
			$this->render('/rinciantagihanpasienV/rincian', array('modPendaftaran'=>$modPendaftaran, 'modRincian'=>$modRincian, 'data'=>$data, 'caraPrint'=>$caraPrint));
		}else
		if ($caraPrint == 'EXCEL') 
		{
			$this->layout='//layouts/printExcel';
			$this->render('/rinciantagihanpasienV/rincian', array('modPendaftaran'=>$modPendaftaran, 'modRincian'=>$modRincian, 'data'=>$data, 'caraPrint'=>$caraPrint));
		} else
		if($caraPrint == 'PDF')
		{
			$ukuranKertasPDF = 'RBK';                  //Ukuran Kertas Pdf
			$posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
			$mpdf = new MyPDF('c',$ukuranKertasPDF); 
			$stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
			$mpdf->WriteHTML($stylesheet,1);                
			$footer = '
			<table width="100%" style="vertical-align: top; font-family:tahoma;font-size: 8pt;"><tr>
			<td width="50%"></td>
			<td width="50%" align="right">{PAGENO} / {nb}</td>
			</tr></table>
			';
			$mpdf->SetHTMLFooter($footer);

			$header = 0.75 * 72 / (72/25.4);                    
			$mpdf->AddPage($posisi,'','','','',5,5,$header+4,8,0,0);
			$mpdf->WriteHTML(
				$this->renderPartial('/rinciantagihanpasienV/rincian', array('modPendaftaran'=>$modPendaftaran, 'modRincian'=>$modRincian, 'data'=>$data, 'caraPrint'=>$caraPrint), true)
			);
			$mpdf->Output();
			exit;
		}

	}
        
	public function actionBuatJadwal($id)
	{
		$this->pageTitle = Yii::app()->name." - Buat Jadwal";
		$modHasilPemeriksaan = $this->loadAllByPasienMasukPenunjang($id);
		$modPasienPenunjang = RMMasukPenunjangV::model()->findByAttributes(array('pasienmasukpenunjang_id'=>$id)); //data pasien penunjang
		$modTindakanPelayanan = new RMTindakanpelayananT;
		$modTindakanKomponen = new RMTindakanKomponenT;
		$modJadwalKunjungan = new JadwalkunjunganrmT;
		$modNewHasil = new HasilpemeriksaanrmT;
		$listJadwalKunjungan = JadwalkunjunganrmT::model()->findAllByAttributes(array('pasienmasukpenunjang_id'=>$id));

		if(isset ($_POST['JadwalKunjungan']))
		{
			$transaction = Yii::app()->db->beginTransaction();
//			try
//			{
			$modJadwalKunjungan = $this->saveJadwalKunjungan($_POST['JadwalKunjungan'],$modPasienPenunjang);

			if ($this->successSave && $this->successSaveJadwal && $this->successSaveHasil){
				$transaction->commit();
				Yii::app()->user->setFlash('success',"Data berhasil disimpan");
			}
			else{
				$transaction->rollback();
				Yii::app()->user->setFlash('error',"Data gagal disimpan ");
			}
//			}
//			catch(Exception $exc){
//				$transaction->rollback();
//				Yii::app()->user->setFlash('error',"Data gagal disimpan ".MyExceptionMessage::getMessage($exc,true));
//			}
		}

		$this->render('buatJadwal',array(
			'modPasienPenunjang'=>$modPasienPenunjang,                                 
			'modTindakanPelayanan'=>$modTindakanPelayanan,                                 
			'modTindakanKomponen'=>$modTindakanKomponen,                                 
			'modJadwalKunjungan'=>$modJadwalKunjungan,                                 
			'modNewHasil'=>$modNewHasil,  
			'listJadwalKunjungan'=>$listJadwalKunjungan,
			'id'=>$id
		));
	}
        
	public function actionPrintJadwal(){
		$id = $_REQUEST['id'];
		$judulLaporan='Jadwal Kunjungan Rehab Medis';
		$modHasilPemeriksaan = $this->loadAllByPasienMasukPenunjang($id);
		$modPasienPenunjang = RMMasukPenunjangV::model()->findByAttributes(array('pasienmasukpenunjang_id'=>$id)); //data pasien penunjang
		$modTindakanPelayanan = new RMTindakanpelayananT;
		$modTindakanKomponen = new RMTindakanKomponenT;
		$modJadwalKunjungan = new JadwalkunjunganrmT;
		$modNewHasil = new HasilpemeriksaanrmT;
		$listJadwalKunjungan = JadwalkunjunganrmT::model()->findAllByAttributes(array('pasienmasukpenunjang_id'=>$id));

		$this->layout = '//layouts/printWindows';
		$this->render('printJadwal',array(
			'modPasienPenunjang'=>$modPasienPenunjang,                                 
			'modTindakanPelayanan'=>$modTindakanPelayanan,                                 
			'modTindakanKomponen'=>$modTindakanKomponen,                                 
			'modJadwalKunjungan'=>$modJadwalKunjungan,                                 
			'modNewHasil'=>$modNewHasil,  
			'listJadwalKunjungan'=>$listJadwalKunjungan,
			'id'=>$id,
			'judulLaporan'=>$judulLaporan,
		));

	}
        
        
	/**
	 * Fungsi untuk menyimpan ke tabel jadwalkunjungan_t
	 * @param type $attrJadwal
	 * @param type $modPasienPenunjang 
	 */
	protected function saveJadwalKunjungan($attrJadwal,$modPasienPenunjang)
	{
		$format = new MyFormatter();
		$arrSave = array();
		$validJadwal = true;
		$arrTindakan= array(); // array untuk menampung tindakan yg nantinnya digunakan pada proses saveHasilpemeriksaan
		$arrIdHasilPemeriksaan= array(); // array untuk menampung hasilpemeriksaan_id yg nantinnya digunakan pada proses saveHasilpemeriksaan
		for ($f = 0; $f < $_POST['lamaterapi']; $f++) 
		{
			$modJadwalKunjungan = new JadwalkunjunganrmT;
			$modJadwalKunjungan->pegawai_id = (!empty($attrJadwal['pegawai_id'][$f])) ? $attrJadwal['pegawai_id'][$f] : null ;
			$modJadwalKunjungan->pasien_id = $modPasienPenunjang->pasien_id ;
			$modJadwalKunjungan->pasienmasukpenunjang_id = $modPasienPenunjang->pasienmasukpenunjang_id ;
			$modJadwalKunjungan->pendaftaran_id = $modPasienPenunjang->pendaftaran_id ;
			$modJadwalKunjungan->nojadwal = MyGenerator::noUrutJadwalRencanaRM();
			$modJadwalKunjungan->nourutjadwal = $f + 1;
			$modJadwalKunjungan->tgljadwalrm = $attrJadwal['tgljadwalrm'][$f] ;
			$modJadwalKunjungan->harijadwalrm = $this->getNamaHari($attrJadwal['tgljadwalrm'][$f]) ;
			$modJadwalKunjungan->lamaterapikunjungan = $_POST['lamaterapi'];
			$modJadwalKunjungan->paramedis1_id = (!empty($attrJadwal['paramedis1_id'][$f])) ? $attrJadwal['paramedis1_id'][$f] : null ;
			$modJadwalKunjungan->paramedis2_id = (!empty($attrJadwal['paramedis2_id'][$f])) ? $attrJadwal['paramedis2_id'][$f] : null ;

			$modJadwalKunjungan->create_loginpemakai_id = Yii::app()->user->id;
			$modJadwalKunjungan->create_ruangan = Yii::app()->user->getState('ruangan_id');
			$modJadwalKunjungan->create_time = date('Y-m-d H:i:s');

			$modJadwalKunjungan->validate();
			$arrIdHasilPemeriksaan[$f] =array(
				'hasilpemeriksaanrm_id'=> isset($attrJadwal['hasilpemeriksaanrm_id'][$f]) ? $attrJadwal['hasilpemeriksaanrm_id'][$f] : null
			);

			if ($modJadwalKunjungan->validate()){
				$validJadwal = true;
				$arrSave[$f] = $modJadwalKunjungan; // menyimpan objek JadwalkunjunganrmT ke dalam sebuah array dan siap untuk disave *kaya masak ya :p

			}else{
				$validJadwal = false;
			}

		} //ENDING FOR
		if($validJadwal) //kondisi apabila semua Jadwal tindakan valid dan siap untuk di save
		{   
			$arrIdHasil = array(); //membuang nilai array yg empty . . 

			foreach ($arrIdHasilPemeriksaan as $z=>$idHasil)
			{
				if ($idHasil['hasilpemeriksaanrm_id'] == '')
				{
					unset($idHasil[$z]);
				}
				else
				{
					$arrIdHasil[$z] = array(
						'hasilpemeriksaanrm_id'=> $idHasil['hasilpemeriksaanrm_id']
					);
				}
			}

			foreach ($arrSave as $x => $simpan) 
			{
				$simpan->save();
				$this->successSave = true;
				if($x < 1) // kondisi dimana proses save pada baris pertama, yang asumsinya bahwa jadwal pertama sudah pasti mempunyai hasilpemeriksaanrm_t maka akan diupdate
				{
					if(isset($idHasil['hasilpemeriksaanrm_id'])){
						$this->updateHasilPemeriksaan($simpan,$arrIdHasil);
					}
				}
				else
				{
					if(isset($attrJadwal['tindakanrm_id'][$f])){
						$this->saveHasilPemeriksaan($modPasienPenunjang,$attrJadwal,$simpan,$x);
					}
				}
			} //ENDING FOREACH
		}

		else
		{
			$this->successSave = false;
		}
		return $modJadwalKunjungan;
	}
        
	protected function saveHasilPemeriksaan($attrPenunjang,$attrTindakan,$modJadwal,$index)
	{
		$arrSave = array();
		$validTindakan = true;
		$arrTindakan = array(); // array untuk menampung tindakan yg nantinnya digunakan pada proses saveTindakanPelayanan
		for ($i = 0; $i < count($attrTindakan['tindakanrm_id'][$index]); $i++) {

			$modHasil = new HasilpemeriksaanrmT;
			$modHasil->jadwalkunjunganrm_id = $modJadwal->jadwalkunjunganrm_id;
			$modHasil->pasienmasukpenunjang_id = $attrPenunjang->pasienmasukpenunjang_id;
			$modHasil->pendaftaran_id = $attrPenunjang->pendaftaran_id;
			$modHasil->pasien_id = $attrPenunjang->pasien_id;
			$modHasil->ruangan_id = $attrPenunjang->ruangan_id;
			$modHasil->pegawai_id = $attrPenunjang->pegawai_id;
			$modHasil->tglpemeriksaanrm = date('Y-m-d H:i:s');
			$modHasil->kunjunganke = $modJadwal->nourutjadwal; //di default untuk kunjungan pertama

			$modHasil->tindakanrm_id = $attrTindakan['tindakanrm_id'][$index][$i];
			$modHasil->jenistindakanrm_id = RMTindakanrmM::model()->findByPk($modHasil->tindakanrm_id)->jenistindakanrm_id;

			$modHasil->create_time=date('Y-m-d H:i:s');
			$modHasil->create_loginpemakai_id=Yii::app()->user->id;
			$modHasil->create_ruangan=Yii::app()->user->getState('ruangan_id');
			$modHasil->nohasilrm = MyGenerator::noHasilPemeriksaanRM();

			if ($modHasil->validate()){
				$arrSave[$i] = $modHasil; // menyimpan objek BSRencanaOperasiT ke dalam sebuah array dan siap untuk disave

			}else{
				$validTindakan = false;
			}
		} //ENDING FOR 

		if($validTindakan) //kondisi apabila semua rencana operasi valid dan siap untuk di save
		{
			foreach ($arrSave as $f => $simpan) 
			{
				$simpan->save();
//                        $this->saveTindakanPelayanT($attrPendaftaran,$attrPenunjang,$simpan,$attrTindakanPelayanan,$f);
			}
			$this->successSave = true;
		}
		else
		{
			$this->successSave = false;
		}
		return $modHasil;
	}
        
	/**
	 * Fungsi untuk mengupdate hasilpemeriksaanrm_t pada saat kunjungan pertama yg asumsinya dia sudah punya hasil pemeriksaan
	 * @param type $attrHasil 
	 */
	protected function updateHasilPemeriksaan($modJadwal,$attrHasil)    
	{   
		$arrSave =array();
		$validHasil = true;
		$modHasil = array();
		for ($i = 0; $i < count($attrHasil); $i++) 
		{
			$modHasil = $this->loadHasilPemeriksaan($attrHasil[$i]['hasilpemeriksaanrm_id']);
			$modHasil->jadwalkunjunganrm_id = $modJadwal->jadwalkunjunganrm_id;
			$modHasil->pegawai_id = (!empty($modJadwal->pegawai_id)) ? $modJadwal->pegawai_id : null ;
			$modHasil->paramedis1_id = (!empty($modJadwal->paramedis1_id)) ? $modJadwal->paramedis1_id : null ;
			$modHasil->paramedis2_id = (!empty($modJadwal->paramedis2_id)) ? $modJadwal->paramedis2_id : null ;
			if($modHasil->validate())
			{
			   $arrSave[$i] = $modHasil; // menyimpan objek 
			}else{
			   $validHasil = false;
			}
		} //ENDING FOR

		if($validHasil) //kondisi apabila semua hasil valid dan siap untuk di save
			{
				foreach ($arrSave as $f => $simpan) 
				{
					$simpan->save();
					$this->successSave = true;
				}
			}
			else
			{
				$this->successSave = false;
			}
		return $modHasil;

	}
        
	public function actionHasilPemeriksaan($pendaftaran_id,$pasien_id,$pasienmasukpenunjang_id,$caraPrint='')
	{
		$modPasienMasukPenunjang = RMMasukPenunjangV::model()->findByAttributes(array('pasienmasukpenunjang_id'=>$pasienmasukpenunjang_id));

//            $modJadwalKunjungan = JadwalkunjunganrmT::model()->findAll('pendaftaran_id = '.$pendaftaran_id.' and 
//                                                                        pasienmasukpenunjang_id = '.$pasienmasukpenunjang_id.' and
//                                                                        pasien_id = '.$pasien_id.' and
//                                                                        tglkunjunganrm is not null
//                                                                        order by nourutjadwal');
		$modHasilPemeriksaanrm = HasilpemeriksaanrmT::model()->findAll('pendaftaran_id = '.$pendaftaran_id.' and 
																	pasienmasukpenunjang_id = '.$pasienmasukpenunjang_id.' and
																	pasien_id = '.$pasien_id);


//            if(isset($_POST['hasilpemeriksaanrm']))
//            {
//               $transaction = Yii::app()->db->beginTransaction();
//                try
//                { 
//                    
//                    for ($i = 0; $i < count($_POST['hasilpemeriksaanrm']['hasilpemeriksaanrm_id']); $i++) {
//                        $modHasil = $this->loadHasilPemeriksaan($_POST['hasilpemeriksaanrm']['hasilpemeriksaanrm_id'][$i]);
//                        $modHasil->hasilpemeriksaanrm = $_POST['hasilpemeriksaanrm']['hasilpemeriksaanrm'][$i];
//                        $modHasil->keteranganhasilrm = $_POST['hasilpemeriksaanrm']['keteranganhasilrm'][$i];
//                        $modHasil->peralatandigunakan = $_POST['hasilpemeriksaanrm']['peralatandigunakan'][$i];
//                        if($_POST['hasilpemeriksaanrm']['hasilpemeriksaanrm'][$i] == '' && 
//                           $_POST['hasilpemeriksaanrm']['keteranganhasilrm'][$i]  == '' && 
//                           $_POST['hasilpemeriksaanrm']['peralatandigunakan'][$i]  == '')
//                        {
//                            $update = TRUE;
//                        }
//                        else
//                        {
//                            $update = JadwalkunjunganrmT::model()->updateByPk($modHasil->jadwalkunjunganrm_id, array('statusterapi'=>1));
//                        }
//                        if($modHasil->save() && $update)
//                        {
//                             $this->successSaveHasil = TRUE;
//                        }
//                        else{
//                            $this->successSaveHasil = FALSE;
//                        }
//                    }
//                    if ($this->successSaveHasil){
//                        $transaction->commit();
//                        Yii::app()->user->setFlash('success',"Data berhasil disimpan");
//                    }
//                    else{
//                        $transaction->rollback();
//                        Yii::app()->user->setFlash('error',"Data gagal disimpan ");
//                    }
//                }
//                catch(Exception $exc){
//                    $transaction->rollback();
//                    Yii::app()->user->setFlash('error',"Data gagal disimpan ".MyExceptionMessage::getMessage($exc,true));
//                }
//            }

		if(isset($_POST['HasilpemeriksaanrmT']))
		{
		   $transaction = Yii::app()->db->beginTransaction();
			try
			{ 
				$id_pendaftaran = $_POST['RMMasukPenunjangV']['pendaftaran_id'];
				$id_pasien = $_POST['RMMasukPenunjangV']['pasien_id'];
				$id_pasienmasukpenunjang = $_POST['RMMasukPenunjangV']['pasienmasukpenunjang_id'];
				for ($i = 0; $i < count($_POST['HasilpemeriksaanrmT']['hasilpemeriksaanrm_id']); $i++) {
					$modHasil = $this->loadHasilPemeriksaan($_POST['HasilpemeriksaanrmT']['hasilpemeriksaanrm_id'][$i]);
					$modHasil->hasilpemeriksaanrm = $_POST['HasilpemeriksaanrmT'][$i]['hasilpemeriksaanrm'];
					$modHasil->keteranganhasilrm = $_POST['HasilpemeriksaanrmT'][$i]['keteranganhasilrm'];
					$modHasil->evaluasi = $_POST['HasilpemeriksaanrmT'][$i]['evaluasi'];
					if($modHasil->save())
					{
						 $this->successSaveHasil = TRUE;
					}
					else{
						$this->successSaveHasil = FALSE;
					}  
				}
				if ($this->successSaveHasil){
					$transaction->commit();
					Yii::app()->user->setFlash('success',"Data berhasil disimpan");
					$this->redirect(array('hasilPemeriksaan',
						'pendaftaran_id'=>$id_pendaftaran,
						'pasien_id'=>$id_pasien,
						'pasienmasukpenunjang_id'=>$id_pasienmasukpenunjang,
						'sukses'=>1));
				}
				else{
					$transaction->rollback();
					Yii::app()->user->setFlash('error',"Data gagal disimpan ");
				}
			}
			catch(Exception $exc){
				$transaction->rollback();
				Yii::app()->user->setFlash('error',"Data gagal disimpan ".MyExceptionMessage::getMessage($exc,true));
			}
		}

		$this->render('hasilPemeriksaanNew',array(/*'modJadwalKunjungan'=>$modJadwalKunjungan,*/
											   'modPasienPenunjang'=>$modPasienMasukPenunjang,
											   'modHasilPemeriksaanrm'=>$modHasilPemeriksaanrm,
											   'caraPrint'=>$caraPrint,
												));
	}
        
	public function actionHasilPeriksaPrint($pendaftaran_id,$pasien_id,$pasienmasukpenunjang_id,$caraPrint='')
	{   
		$this->layout = '//layouts/printWindows';
		$judulLaporan = 'HASIL PEMERIKSAAN REHAB MEDIS';
		$modPasienMasukPenunjang = RMMasukPenunjangV::model()->findByAttributes(array('pasienmasukpenunjang_id'=>$pasienmasukpenunjang_id));
		$detailHasil = HasilpemeriksaanrmT::model()->findAll('pendaftaran_id = '.$pendaftaran_id);
		$this->render('hasilPrint',array(
			'judulLaporan'=>$judulLaporan,
			'masukpenunjang'=>$modPasienMasukPenunjang,
			'detailHasil'=>$detailHasil,
		));
	}
        
	/**
	 * Fungsi untuk mengembalikan object $model dengan method findAllByAttributes yang nanti digunakan untuk mendeskripsikan operasi_id
	 * @param type $id
	 * @return type 
	 */
	protected function loadAllByPasienMasukPenunjang($id)
	{
		$model= HasilpemeriksaanrmT::model()->findAllByAttributes(array('pasienmasukpenunjang_id'=>$id));
		if($model===null)
					throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
        
	/**
	 * Fungsi untuk mengembalikan object $model dengan method findByAttributes yang nanti digunakan untuk mendeskripsikan hasilpemeriksanrm_t
	 * @param type $id
	 * @return type 
	 */
	protected function loadHasilPemeriksaan($id)
	{
			$model= HasilpemeriksaanrmT::model()->findByPk($id);
		if($model===null)
					throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
        
	public function actionLoadFormJadwalKunjunganAwal()
    {
        if (Yii::app()->request->isAjaxRequest)
        {
            $pasienmasukpenunjang_id = isset($_POST['pasienmasukpenunjang_id']) ? $_POST['pasienmasukpenunjang_id'] : null ;
            $lamaTerapi = isset ($_POST['lamaTerapi']) ? $_POST['lamaTerapi'] : null;
            $tindakan = array();
            $idHasil = array();
            $modHasilPemeriksaan = array();
            
//            $sql = "select * from hasilpemeriksaanrm_t where pasienmasukpenunjang_id = $pasienmasukpenunjang_id";
//            //echo count($sql);
//            $modHasil = Yii::app()->db->createCommand($sql)->queryAll();
            $modHasil = HasilpemeriksaanrmT::model()->findAllByAttributes(array('pasienmasukpenunjang_id'=>$pasienmasukpenunjang_id));
            foreach ($modHasil as $i=>$hasilPeriksa) {
                $tindakan[$i] = $hasilPeriksa['tindakanrm_id'];
                $idHasil[$i] = $hasilPeriksa['hasilpemeriksaanrm_id'];
//                echo $hasilPeriksa['hasilpemeriksaanrm_id'].'<br/>';
//                echo $hasilPeriksa['tindakanrm_id'].'<br/>';
            }
			if(count($modHasil) > 0){
//            exit;
				echo CJSON::encode(array(
					'status'=>'create_form', 
					'pesan'=>'',
					'form'=>$this->renderPartial('_formLoadJadwalKunjunganAwal', array('modHasilPemeriksaan'=>$modHasilPemeriksaan,
							'pasienmasukpenunjang_id'=>$pasienmasukpenunjang_id,
							'lamaTerapi'=>$lamaTerapi,
							'tindakan'=>$tindakan,
							'idHasil'=>$idHasil
					), true)));
				exit;               
			}else{
				echo CJSON::encode(array(
					'status'=>'create_form', 
					'pesan'=>'Tindakan Rehabilitasi Medis belum dipilih!', 
					'form'=>'',
					));
				exit;  
			}
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

			$model = RMMasukPenunjangV::model()->find($criteria);
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