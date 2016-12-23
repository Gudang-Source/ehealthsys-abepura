<?php

class PermohonanPinjamanController extends MyAuthController
{
	public $layout='//layouts/column1';
	// public $defaultAction = 'admin';
	//public $menuActive = array(3,0); // Default. Harap diubah sesuai menu aktif yang ada.

	public function actionIndex($id=null){

		$insert_notifikasi = new CustomFunction();
		$anggota = new KeanggotaanV;
		$pegawai = new PegawaiM;
		$golongan = new GolonganpegawaiM;
		$permintaan = new PermohonanpinjamanT;
		$potongan = new PotonganpinjamandariT;		
		$konfig = KonfigkoperasiK::model()->find('status_aktif = true');

		$permintaan->tglpermohonanpinjaman = date('d/m/Y H:i');
		$permintaan->nopermohonan = MyGenerator::generateNoPermohonan();
		$permintaan->jasapinjaman_bln = number_format($konfig->persjasapinjaman, 2, ",", ".");
		$permintaan->jenispinjaman_permohonan = "UANG";

		CustomFunction::runAjaxF($this, $_POST);

		if (isset($_POST['PermohonanpinjamanT'])) {
			$ok = true;
			$trans = Yii::app()->db->beginTransaction();
			//var_dump($_POST); die;
			$permintaan->attributes = $_POST['PermohonanpinjamanT'];
			$permintaan->tglpermohonanpinjaman = MyFormatter::formatDateTimeForDb($permintaan->tglpermohonanpinjaman).":00";
			//$permintaan->nopermohonan = $permintaan->generateNoPermohonan();
			$permintaan->jmlgaji = str_replace(".", "", $permintaan->jmlgaji);
			$permintaan->jmlinsentif = str_replace(".", "", $permintaan->jmlinsentif);
			$permintaan->jmlsimpanan = str_replace(".", "", $permintaan->jmlsimpanan);
			$permintaan->jmlpenghasilanlain = str_replace(".", "", $permintaan->jmlpenghasilanlain);
			$permintaan->jmltunggakanuangpinj = str_replace(".", "", $permintaan->jmltunggakanuangpinj);
			$permintaan->jmltunggakanbrgpinj = str_replace(".", "", $permintaan->jmltunggakanbrgpinj);
			$permintaan->jmlpinjaman = str_replace(".", "", $permintaan->jmlpinjaman);

			$permintaan->jasapinjaman_bln = str_replace(",", ".", $permintaan->jasapinjaman_bln);

			if (isset($_POST['GolonganpegawaiM'])) $permintaan->batasplafon = str_replace(".", "", $_POST['GolonganpegawaiM']['jmlmaksimalplafon']);
			$permintaan->petugas_id = 1;
			$permintaan->per_create_time = date('Y-m-d H:i:s');
			$permintaan->per_create_login = Yii::app()->user->id;
			$ok = $ok && $permintaan->validate();

			// var_dump($permintaan->errors); die;

			$ok = $ok && $permintaan->save();
			$ok = $ok && $this->savePotonganSumber($permintaan, $_POST['potongansumber_id']);
			//var_dump($permintaan->attributes); die;
			$anggota = KeanggotaanT::model()->findByPk($permintaan->keanggotaan_id);
			//insert notifikasi
			$params['tglnotifikasi'] = date( 'Y-m-d H:i:s');
         $params['create_time'] = date( 'Y-m-d H:i:s');
         $params['create_loginpemakai_id'] = Yii::app()->user->id;
         $params['isinotifikasi'] = $permintaan->nopermohonan . ', ' . MyFormatter::formatDateTimeId($permintaan->tglpermohonanpinjaman) . ', Rp' . MyFormatter::formatNumberForPrint($permintaan->jmlpinjaman) . '<br/>' . $anggota->pegawai->nama_pegawai . ' - ' . $anggota->nokeanggotaan . '<br/> Dibuat Oleh : ' . Yii::app()->user->name;
         $params['judulnotifikasi'] = 'Permohonan Pinjaman';
         $params['link'] = "/pinjaman/permohonanPinjaman/informasi&no=".$permintaan->nopermohonan;
         $nofitikasi = $insert_notifikasi->insertNotifikasi($params);

         //var_dump($ok); die;
			if ($ok) {
				$trans->commit();
                                Yii::app()->user->setFlash("success", "Permohonan Peminjaman berhasil Di Simpan");
				$this->redirect(array('index', 'id'=>$permintaan->permohonanpinjaman_id, 'status'=>1));
			} else {
				$trans->rollback();
                                Yii::app()->user->setFlash("error", "Permohonan Peminjaman gagal Di Simpan");
				$this->redirect(array('index', 'status'=>0));
			}
			//var_dump($permintaan->errors); die;
			//var_dump($permintaan->attributes); die;
			//var_dump($_POST); die;
		}

		if (!empty($id)) {
			$permintaan = PermohonanpinjamanT::model()->findByPk($id);
			$anggota = KeanggotaanT::model()->findByPk($permintaan->keanggotaan_id);
			$pegawai = PegawaiM::model()->findByPk($anggota->pegawai_id);
			$golongan = GolonganpegawaiM::model()->findByPk($pegawai->golonganpegawai_id);
			if (!empty($pegawai->unit_id)) $pegawai->unit_id = $pegawai->unit->namaunit;
			if (!empty($pegawai->photopegawai)) $pegawai->photopegawai = Params::urlPegawaiGambar().$pegawai->photopegawai;
			$potongan = PotonganpinjamandariT::model()->findAllByAttributes(array('permohonanpinjaman_id'=>$id));

			$apotongan = array();

			if (count($potongan) != 0) foreach($potongan as $item) {
				$apotongan[$item->potongansumber_id] = $item;
			}
			$potongan = $apotongan;

			if (!empty($golongan)) $golongan->jmlmaksimalplafon = MyFormatter::formatNumberForPrint($golongan->jmlmaksimalplafon);
			else $golongan = new GolonganpegawaiM;
			$permintaan->jmltunggakanuangpinj = MyFormatter::formatNumberForPrint($permintaan->jmltunggakanuangpinj);
			$permintaan->jmltunggakanbrgpinj = MyFormatter::formatNumberForPrint($permintaan->jmltunggakanbrgpinj);
			$permintaan->jmlpinjaman = MyFormatter::formatNumberForPrint($permintaan->jmlpinjaman);
			$permintaan->jmlgaji = MyFormatter::formatNumberForPrint($permintaan->jmlgaji);
			$permintaan->jmlinsentif = MyFormatter::formatNumberForPrint($permintaan->jmlinsentif);
			$permintaan->jmlsimpanan = MyFormatter::formatNumberForPrint($permintaan->jmlsimpanan);
			$permintaan->jmlpenghasilanlain = MyFormatter::formatNumberForPrint($permintaan->jmlpenghasilanlain);

			$permintaan->tglpermohonanpinjaman = date('d/m/Y H:i:s', strtotime($permintaan->tglpermohonanpinjaman));
			$pegawai->tgl_lahirpegawai = date('d/m/Y', strtotime($pegawai->tgl_lahirpegawai));
		}

		$this->render('index', array(
			'anggota'=>$anggota, 'pegawai'=>$pegawai, 'golongan'=>$golongan, 'permintaan'=>$permintaan, 'potongan'=>$potongan
		));
	}

	public function actionPrint($id)
	{
		$this->layout='//layouts/print';
		$this->pageTitle = 'ecoopsys - Print Surat Permohonan Pinjaman';
		$permintaan = PermohonanpinjamanT::model()->findByPk($id);
		$anggota = KeanggotaanV::model()->findByAttributes(array('keanggotaan_id'=>$permintaan->keanggotaan_id));
		$pegawai = PegawaiM::model()->findByPk($anggota->pegawai_id);
		$golongan = GolonganpegawaiM::model()->findByPk($pegawai->golonganpegawai_id);
		$profil = ProfilS::model()->find(array('order'=>'profilperusahaan_id asc'));
		if (!empty($pegawai->unit_id)) $pegawai->unit_id = $pegawai->unit->namaunit;
		$pegawai->photopegawai = empty($pegawai->photopegawai)?'':Params::urlPegawaiGambar().$pegawai->photopegawai;
		$this->render('print',
			array('profil'=>$profil,'permintaan'=>$permintaan, 'anggota'=>$anggota, 'pegawai'=>$pegawai, 'golongan'=>$golongan, 'btnPrint'=>true)
		);
	}

	public function actionInformasi($no=null)
	{
		//MyFunction::runAjaxF($this, $_POST);

		
		$model = new KOInfomohonpinjamanV('search');
		$model->tgl_awal = date('Y-m-d');
		$model->tgl_akhir = date('Y-m-d');
		$model->unsetAttributes();  // clear any default values
		$model->nopermohonan = $no;

		if(isset($_GET['KOInfomohonpinjamanV'])) {
			$model->attributes=$_GET['KOInfomohonpinjamanV'];
                        $model->tgl_awal = MyFormatter::formatDateTimeForDb($_GET['KOInfomohonpinjamanV']['tgl_awal']);
                        $model->tgl_akhir = MyFormatter::formatDateTimeForDb($_GET['KOInfomohonpinjamanV']['tgl_akhir']);
                        //if (isset($_GET['KOInfomohonpinjamanV']['surat_peminjaman'])) $model->surat_peminjaman = $_GET['InformasipermohonanpinjamanV']['surat_peminjaman'];
			//if (isset($_GET['KOInfomohonpinjamanV']['cair'])) $model->cair = $_GET['InformasipermohonanpinjamanV']['cair'];
			//if (isset($_GET['KOInfomohonpinjamanV']['potongansumber_id'])) $model->potongansumber_id = $_GET['InformasipermohonanpinjamanV']['potongansumber_id'];
			//if (!empty($_GET['KOInfomohonpinjamanV']['tglAwal'])) $model->tglAwal = MyFormatter::formatDateTimeForDb($_GET['InformasipermohonanpinjamanV']['tglAwal']." 00:00:00");
			//if (!empty($_GET['KOInfomohonpinjamanV']['tglAkhir'])) $model->tglAkhir = MyFormatter::formatDateTimeForDb($_GET['InformasipermohonanpinjamanV']['tglAkhir']." 23:59:59");
		}

		$this->render('informasi', array(
			'model'=>$model,
		));
	}

	public function actionPrintInformasi()
	{
		//var_dump($_GET); die;
		$this->layout='//layouts/print';
		$this->pageTitle = 'ecoopsys - Print Informasi Permohonan Pinjaman Anggota';
		$model=new KOInfomohonpinjamanV('search');
		$profil = ProfilS::model()->find();
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['InformasipermohonanpinjamanV'])) {
			$model->attributes=$_GET['InformasipermohonanpinjamanV'];
			if (isset($_GET['InformasipermohonanpinjamanV']['cair'])) $model->cair = $_GET['InformasipermohonanpinjamanV']['cair'];
			if (isset($_GET['InformasipermohonanpinjamanV']['potongansumber_id'])) $model->potongansumber_id = $_GET['InformasipermohonanpinjamanV']['potongansumber_id'];
			if (!empty($_GET['InformasipermohonanpinjamanV']['tglAwal'])) $model->tglAwal = MyFormatter::formatDateTimeForDb($_GET['InformasipermohonanpinjamanV']['tglAwal']." 00:00:00");
			if (!empty($_GET['InformasipermohonanpinjamanV']['tglAkhir'])) $model->tglAkhir = MyFormatter::formatDateTimeForDb($_GET['InformasipermohonanpinjamanV']['tglAkhir']." 23:59:59");
			//var_dump($model->potongansumber_id); die;
		}

		$this->render('printInformasi', array(
			'model'=>$model,
			'profil'=>$profil
		));
	}

	//print surat permohonan pinjaman (SPP)
	public function actionPrintSPP($id)
	{
		$this->layout='//layouts/print';
		$this->pageTitle = 'ecoopsys - Print Surat Persetujuan Pinjaman';
		$model = InformasipermohonanpinjamanV::model()->findByAttributes(array('permohonanpinjaman_id'=>$id));
		$pinjaman = PinjamanT::model()->findByAttributes(array('permohonanpinjaman_id'=>$id));
		$profil = ProfilS::model()->find();
		$this->render('printSPP',
				array('model'=>$model,'profil'=>$profil, 'pinjaman'=>$pinjaman, 'btnPrint'=>true)
		);
	}
	/*
	public function actionDetailSPP($id)
	{
		$model = InformasipermohonanpinjamanV::model()->findByAttributes(array('permohonanpinjaman_id'=>$id));
		$pinjaman = PinjamanT::model()->findByAttributes(array('permohonanpinjaman_id'=>$id));
		$profil = ProfilS::model()->find();
		$this->layout='//layouts/blank';
		$this->render('printSPP',
				array('model'=>$model,'profil'=>$profil, 'pinjaman'=>$pinjaman, 'btnPrint'=>true)
		);
	}*/

	// ======================================================================


	public function savePotonganSumber($permintaan, $potongan) {
		//var_dump($potongan); die;
		$ok = true;
		foreach ($potongan as $item) {
			$potong = new PotonganpinjamandariT;
			$potong->permohonanpinjaman_id = $permintaan->permohonanpinjaman_id;
			$potong->potongansumber_id = $item;
			$potong->pp_create_time = date('Y-m-d H:i:s');
			$potong->pp_create_login = 1; //default.. XP
			if ($potong->validate()) $ok = $ok && $potong->save();
			//var_dump($potong->errors); die;
		}
		return $ok;
	}

	// ======================================================================
	public function loadPermohonan($param) {
		$res = array();
		$id = $param['id'];

		// data utama
		$permintaan = InformasipermohonanpinjamanV::model()->findByAttributes(array('permohonanpinjaman_id'=>$id));
		$permintaan->tglpermohonanpinjaman = date('d/m/Y H:i', strtotime($permintaan->tglpermohonanpinjaman));
		$permintaan->jasapinjaman_bln = number_format($permintaan->jasapinjaman_bln, 2, ",", ".")." %";
		$permintaan->jangkawaktu_pinj_bln .= " Bulan";
		$res['attr'] = $permintaan->attributes;
		$res['tgl'] = date('d/m/Y H:i');

		$konfig = KonfigurasikoperasiK::model()->find(array('condition'=>'isberlaku = true', 'order'=>'kofigurasikoperasi_id asc'));
		$periksa = PegawaiM::model()->findByPk(Yii::app()->user->getState('pegawai_id')); // default login belum siap... XP
		$setujui = PegawaiM::model()->findByPk($konfig->pimpiankoperasi_id);

                $res['periksa'] = array('id'=>null, 'nama'=>null);
                $res['setujui'] = array('id'=>null, 'nama'=>null);
                
		if (!empty($perikisa)) {
                    $res['periksa']['id'] = $periksa->pegawai_id;
                    $res['periksa']['nama'] = $periksa->nama_pegawai;
                }
                if (!empty($setujui)) {
                    $res['setujui']['id'] = $setujui->pegawai_id;
                    $res['setujui']['nama'] = $setujui->nama_pegawai;
                }
		

		// pegawai
		echo CJSON::encode($res);
	}

	function submitPersetujuan() {
		$insert_notifikasi = new MyFunction();
		$approval = new ApprovalT;

		$ok = true;
		if (isset($_POST['ApprovalT'])) {
			$trans = Yii::app()->db->beginTransaction();
			$idPermintaan = $_POST['InformasipermohonanpinjamanV']['permohonanpinjaman_id'];
			// var_dump($_POST); die;
			$approval->attributes = $_POST['ApprovalT'];
			$approval->tglapproval = MyFormatter::formatDateTimeForDb($approval->tglapproval).":00";
			$approval->appr_tgldiperiksa = MyFormatter::formatDateTimeForDb($approval->appr_tgldiperiksa).":00";
			$approval->appr_tgldisetujui = MyFormatter::formatDateTimeForDb($approval->appr_tgldisetujui).":00";
			$approval->appr_create_time = date('Y-m-d H:i:s');
			$approval->appr_create_login = Yii::app()->user->name;

			$persetujuan = InformasipermohonanpinjamanV::model()->findByAttributes(array('approval_id'=>$approval->approval_id));
				if (isset($persetujuan))
					{
						if($persetujuan->status_disetujui == true)
						{
							$status = "DiSetujui";
						}
						else {
							$status = "Tidak Disetujui";
						}
					}
				$approved = PegawaiM::model()->findByPk($approval->appr_disetujuioleh_id);
				//insert notifikasi
				$params['tglnotifikasi'] = date( 'Y-m-d H:i:s');
        		$params['create_time'] = date( 'Y-m-d H:i:s');
        		$params['create_loginpemakai_id'] = Yii::app()->user->id;
         	$params['isinotifikasi'] = $status . ', Rp' . MyFormatter::formatNumberForPrint($persetujuan->jmlpinjaman) . '<br/>' . $persetujuan->nopermohonan . ', ' . MyFormatter::formatDateTimeId($persetujuan->tglpermohonanpinjaman) . '<br/> Disetujui Oleh : ' . $approved->nama_pegawai;
         	$params['judulnotifikasi'] = 'Persetujuan Pinjaman';
         	$nofitikasi = $insert_notifikasi->insertNotifikasi($params);

			if ($approval->validate()) $ok = $ok && $approval->save();
			$ok = $ok && PermohonanpinjamanT::model()->updateByPk($idPermintaan, array('approval_id'=>$approval->approval_id, 'per_update_time'=>date('Y-m-d H:i:s'), 'per_update_login'=>Yii::app()->user->id));

			$res = array();
			if ($ok) {
				$res['ok'] = 1;
				$trans->commit();
			} else {
				$res['ok'] = 0;
				$trans->rollback();
			}

			echo CJSON::encode($res);

			//var_dump($ok); die;
			//$ok = $ok && PermohonanpinjamanT::model()->updateByPk();

			//var_dump($approval->attributes); die;
		}
	}

	public function loadSumberPotongan($param) {
		$potongan = PotonganpinjamandariT::model()->findAllByAttributes(array('permohonanpinjaman_id'=>$param['id']));

		$res = array();

		foreach ($potongan as $item) {
			array_push($res, array('id'=>$item->potongansumber_id, 'val'=>$item->jumlahpotongan));
		}

		echo CJSON::encode(array('id'=>$param['id'], 'res'=>$res));
	}

	public function submitSumber() {
		$ok = true;
		$savedIdx = array();
		$res = array();
		//var_dump($_POST); die;

		$trans = Yii::app()->db->beginTransaction();
		$pinjaman = PinjamanT::model()->findByAttributes(array('permohonanpinjaman_id'=>$_POST['id_potongan']));
		//var_dump($pinjaman->attributes); die;
		if(!empty($pinjaman)) {
		foreach ($_POST['potongan'] as $i=>$val) {

			$potongan = PotonganpinjamandariT::model()->findByAttributes(array('permohonanpinjaman_id' => $_POST['id_potongan'], 'potongansumber_id'=>$i));
				if (!isset($val['check'])) continue;
				if (empty($potongan)) {
					$potongan = new PotonganpinjamandariT;
					$potongan->pinjaman_id = $pinjaman->pinjaman_id;
					$potongan->permohonanpinjaman_id = $_POST['id_potongan'];
					$potongan->jumlahpotongan = str_replace(".","",$val['text']);
					$potongan->potongansumber_id = $i;
					$potongan->pp_create_time = date('Y-m-d H:i:s');
					$potongan->pp_create_login = 1;
					//$potongan->validate();
					//var_dump($potongan->errors); die;
					if ($potongan->validate()) {
						$ok = $ok && $potongan->save();
						array_push($savedIdx, $i);
					}
					//var_dump($potongan->attributes); die;
				} else {
					$potongan->pinjaman_id = $pinjaman->pinjaman_id;
					$potongan->jumlahpotongan = str_replace(".","",$val['text']);
					$potongan->pp_update_time = date('Y-m-d H:i:s');
					$potongan->pp_update_login = 1;
					$ok = $ok && $potongan->update(array('pinjaman_id', 'jumlahpotongan', 'pp_update_time', 'pp_update_login'));
					array_push($savedIdx, $i);
				}
		}
		// hapus data yang tidak di ceklis
		$delc = new CDbCriteria;
		$delc->addNotInCondition('potongansumber_id', $savedIdx);
		$delc->compare('permohonanpinjaman_id', $_POST['id_potongan']);

		PotonganpinjamandariT::model()->deleteAll($delc);
		if ($ok) {
			$res['ok'] = 1;
			$trans->commit();
		} else {
			$res['ok'] = 0;
			$trans->rollback();
		}


		}
			echo CJSON::encode($res);
		//return $ok;
	}
	// ======================================================================

	public function loadTunggakanAnggota($param = null) {
		$pinjaman = PinjamanT::model()->findAllByAttributes(array('keanggotaan_id'=>$param['id']));
		$anggota = KeanggotaanV::model()->findByAttributes(array('keanggotaan_id'=>$param['id']));
		$pegawai = PegawaiM::model()->findByPk($anggota->pegawai_id);
		//var_dump($pegawai->attributes); die;
		$simpanan = SimpananT::model()->findAllByAttributes(array('keanggotaan_id'=>$anggota->keanggotaan_id));
		$res = 	array(
					'pinjaman'=>array('uang'=>0, 'barang'=>0),
					'sumber'=>array('gaji'=>$pegawai->gajipokok, 'insentif'=>$pegawai->insentifpegawai, 'simpanan'=>0),
				);
		foreach ($pinjaman as $item) {
			$res['pinjaman'][strtolower($item->jenispinjaman)] += $item->jml_pinjaman;
		}

		foreach ($simpanan as $item) {
			$res['sumber']['simpanan'] += floor($item->jumlahsimpanan);
		}

		echo CJSON::encode($res);
	}
        
        public function batalPersetujuan($param = null) {
            $id = $param['id'];
            $alasan = $param['alasan'];
            $trans = Yii::app()->db->beginTransaction();
            
            $ok = true && ApprovalT::model()->updateByPk($id, array('keteranganapproval' => $alasan, 'status_disetujui'=>false));

            $stat = 0;
            if ($ok) {
                $trans->commit();
                $stat = 1;
            } else {
                $trans->rollback();
            }
            
            echo CJSON::encode(array('status'=>$stat));
        }

}
