<?php

class PendaftaranAnggotaController extends MyAuthController
{
	public $layout='//layouts/main';
	// public $defaultAction = 'admin';
	public $menuActive = array(2,1); // Default. Harap diubah sesuai menu aktif yang ada.

	public function actionIndex($id = null)
	{
		$pegawai = new PegawaiM;
		$anggota = new KeanggotaanT;
		$simpanan = new SimpananT;
		$kasmasuk = new BuktikasmasukkopT;
		$konfig = KonfigkoperasiK::model()->find();
		// $insert_notifikasi = new MyFunction();
		// inisialisasi
		$anggota->tglkeanggotaaan = $anggota->tgldisetujui = $simpanan->tglsimpanan = MyFormatter::formatDateTimeForUser(date('Y-m-d H:i:s'));
		$anggota->nokeanggotaan = $anggota->generateNoAnggota();
		$anggota->disetujuioleh = $konfig->pimpinankoperasi_id; // default pimpinan koperasi
		$golongan = GolonganpegawaiM::model()->findByPk(1);
		$jenisSimpanan = JenissimpananM::model()->findByPk(Params::ID_SIMPANAN_POKOK);
		$simpanan->jumlahsimpanan = number_format($golongan->kopsimpananpokok, 0, ',', '.');
		$simpanan->jenissimpanan_id = $jenisSimpanan->jenissimpanan_id;

		$kasmasuk->jmlpembayaran = $kasmasuk->biayaadministrasi = $kasmasuk->biayamaterai = $kasmasuk->uangditerima = $kasmasuk->uangkembalian = 0;

		// check input
		if (!empty($id)) {
			$anggota = KeanggotaanT::model()->findByPk($id);
			$pegawai = PegawaiM::model()->findByPk($anggota->pegawai_id);
			$simpanan = SimpananT::model()->findByAttributes(array('keanggotaan_id'=>$id), array('order'=>'simpanan_id asc'));
			
			$pegawai->tgl_lahirpegawai = MyFormatter::formatDateTimeForUser($pegawai->tgl_lahirpegawai);
			if (!empty($pegawai->jabatan_id)) $pegawai->jabatan_id = $pegawai->jabatan->jabatan_nama;
			if (!empty($pegawai->pangkat_id)) $pegawai->pangkat_id = $pegawai->pangkat->pangkat_nama;
			if (!empty($pegawai->pendidikan_id)) $pegawai->pendidikan_id = $pegawai->pendidikan->pendidikan_nama;
			if (!empty($pegawai->kelompokpegawai_id)) $pegawai->kelompokpegawai_id = $pegawai->kelompokpegawai->kelompokpegawai_nama;
			
			$anggota->tglkeanggotaaan = MyFormatter::formatDateTimeForUser($anggota->tglkeanggotaaan);
			if (!empty($anggota->tgldisetujui)) $anggota->tgldisetujui = MyFormatter::formatDateTimeForUser($anggota->tgldisetujui);
			
			
			if (!empty($simpanan)) {
				$kasmasuk = BuktikasmasukkopT::model()->findByPk($simpanan->buktikasmasukkop_id);
				if (empty($kasmasuk)) $kasmasuk = $kasmasuk = new BuktikasmasukkopT;
				
				$simpanan->tglsimpanan = MyFormatter::formatDateTimeForUser($simpanan->tglsimpanan);
				$simpanan->jumlahsimpanan = MyFormatter::formatNumberForPrint($simpanan->jumlahsimpanan);
				
				$kasmasuk->jmlpembayaran = MyFormatter::formatNumberForPrint($kasmasuk->jmlpembayaran);
				$kasmasuk->biayaadministrasi = MyFormatter::formatNumberForPrint($kasmasuk->biayaadministrasi);
				$kasmasuk->biayamaterai = MyFormatter::formatNumberForPrint($kasmasuk->biayamaterai);
				$kasmasuk->uangditerima = MyFormatter::formatNumberForPrint($kasmasuk->uangditerima);
				$kasmasuk->uangkembalian = MyFormatter::formatNumberForPrint($kasmasuk->uangkembalian);
				
			} else $simpanan = new SimpananT;
		}

		if (isset($_POST['ajax'])) {
			call_user_func(array($this, $_POST['ajaxF']), $_POST['param']);
			Yii::app()->end();
		}
		if (isset($_POST['KeanggotaanT'])) {
			// var_dump($_POST);
		
			$pegawai = PegawaiM::model()->findByPk($_POST['KeanggotaanT']['pegawai_id']);
		
			$ok = true;
			$okUploadPegawai = true;
			$trans = Yii::app()->db->beginTransaction();
			// $ok = $ok && $this->savePegawai($pegawai, $_POST['PegawaiM'], $okUploadPegawai);
			$ok = $ok && $this->saveAnggota($anggota, $pegawai, $_POST['KeanggotaanT']);
			
			/*
			$params['tglnotifikasi'] = date( 'Y-m-d H:i:s');
                        $params['create_time'] = date( 'Y-m-d H:i:s');
                        $params['create_loginpemakai_id'] = Yii::app()->user->id;
                        $params['isinotifikasi'] = $pegawai->nama_pegawai . ', ' . $anggota->nokeanggotaan . ', ' . MyFormatter::formatDateTimeId($anggota->tglkeanggotaaan) . '<br/>' . (empty($pegawai->unit_id)?'-':$pegawai->unit->namaunit) . ', ' . (empty($pegawai->golonganpegawai_id)?"-":$pegawai->golonganpegawai->golonganpegawai_nama) . '<br/> Dibuat Oleh : ' . Yii::app()->user->name;
                        $params['judulnotifikasi'] = 'Pendaftaran Anggota';
                        $params['link'] = "/keanggotaan/pendaftaranAnggota/printAnggota&id=".$anggota->keanggotaan_id;
                        // $nofitikasi = $insert_notifikasi->insertNotifikasi($params);

                        // var_dump($ok);
                        */
                        
			if (isset($_POST['is_simpanan']) && $_POST['is_simpanan'] == 1) {
				// echo "Kick1"; die;
				if (isset($_POST['BuktikasmasukkopT'])) $ok = $ok && $this->saveBKM($kasmasuk, $pegawai, $_POST['SimpananT'], $_POST['BuktikasmasukkopT']);
				$ok = $ok && $this->saveSimpanan($simpanan, $kasmasuk, $anggota, $_POST['SimpananT']);
			}
		
            // var_dump($ok); die;
			if ($ok) {
				// if ($okUploadPegawai) $pegawai->photopegawai->saveAs(Params::pathPegawaiGambar().$pegawai->photopegawai); //.$model->photopegawai);
				$trans->commit();
                                Yii::app()->user->setFlash("success", "Data Keanggotaan berhasil disimpan");
				$this->redirect(array('index', 'id'=>$anggota->keanggotaan_id, 'status'=>1));
			} else {
				$trans->rollback();
                                Yii::app()->user->setFlash("error", "Data Keanggotaan gagal disimpan");
				$this->redirect(array('index', 'status'=>0));
			}

			//var_dump($_POST); die;
		}

		$this->render('index', array(
			'pegawai'=>$pegawai,
			'anggota'=>$anggota,
			'simpanan'=>$simpanan,
			'kasmasuk'=>$kasmasuk,
		));
	}

	public function actionUpdate($id) {
		$anggota = KeanggotaanT::model()->findByPk($id);
		$pegawai = PegawaiM::model()->findByPk($anggota->pegawai_id);

		$pegawai->tgl_lahirpegawai = date('d/m/Y', strtotime($pegawai->tgl_lahirpegawai));
		if (!empty($pegawai->tglmulaibekerja))$pegawai->tglmulaibekerja = date('d/m/Y', strtotime($pegawai->tglmulaibekerja));

		$anggota->tglkeanggotaaan = date('d/m/Y H:i', strtotime($anggota->tglkeanggotaaan));
		$anggota->tgldisetujui = date('d/m/Y H:i', strtotime($anggota->tgldisetujui));

		$pegawai->gajipokok = MyFormatter::formatNumberForPrint($pegawai->gajipokok);
		$pegawai->insentifpegawai = MyFormatter::formatNumberForPrint($pegawai->insentifpegawai);

		//var_dump($_POST); die;

		if (isset($_POST['KeanggotaanT'])) {
			$ok = true;
			$okUploadPegawai = true;
			//var_dump($_POST['PegawaiM']); die;
			$anggota = KeanggotaanT::model()->findByPk($_POST['KeanggotaanT']['keanggotaan_id']);
			$pegawai = PegawaiM::model()->findByPk($_POST['PegawaiM']['pegawai_id']);

			$trans = Yii::app()->db->beginTransaction();
			$ok = $ok && $this->savePegawai($pegawai, $_POST['PegawaiM'], $okUploadPegawai);
			$ok = $ok && $this->saveAnggota($anggota, $pegawai, $_POST['KeanggotaanT']);

			//var_dump($ok); die;

			//var_dump(Params::pathPegawaiGambar().$pegawai->photopegawai); die;

			//var_dump($okUploadPegawai); die;

			if ($ok) {
				if ($okUploadPegawai) $pegawai->photopegawai->saveAs(Params::pathPegawaiGambar().$pegawai->photopegawai); //.$model->photopegawai);
				$trans->commit();
                                Yii::app()->user->setFlash("success", "Data Keanggotaan berhasil disimpan");
				$this->redirect(array('informasi', 'status'=>1));
			} else {
				$trans->rollback();
                                Yii::app()->user->setFlash("error", "Data Keanggotaan gagal disimpan");
				$this->redirect(array('update', 'status'=>0));
			}
		}

		$this->render('update', array('pegawai'=>$pegawai, 'anggota'=>$anggota));
	}

	public function actionView()
	{
		$this->render('view');
	}

	protected function cariDataPegawai($param) {
		$criteria = new CDbCriteria;
		$criteria->join = "left join keanggotaan_t k on k.pegawai_id = t.pegawai_id";
		$criteria->addCondition('k.keanggotaan_id is null');
		$criteria->compare('t.pegawai_id', $param['id']);

		$pegawai = PegawaiM::model()->find($criteria);
		$res = array();

		if (!empty($pegawai)) {
			$data;
			foreach ($pegawai->attributes as $idx=>$val) {
				$data[$idx] = $val;
			}
			$data['photopegawai'] = Params::urlPegawaiGambar().$data['photopegawai'];
			$data['tgl_lahirpegawai'] = date('d/m/Y', strtotime($data['tgl_lahirpegawai']));
			if (!empty($data['tglmulaibekerja'])) $data['tglmulaibekerja'] = date('d/m/Y', strtotime($data['tglmulaibekerja']));
			$res['data'] = $data;
			$res['status'] = true;
		} else {
			$res['status'] = false;
		}

		echo CJSON::encode($res);
	}


	public function actionInformasi() {
		$this->menuActive = array(5,0);
		$this->pageTitle = 'ecoopsys - Informasi Pendaftaran Anggota';
		$anggota = new KeanggotaanV;
		if (isset($_GET['KeanggotaanV'])) {
			$anggota->attributes = $_GET['KeanggotaanV'];
			$anggota->golonganpegawai_id = $_GET['KeanggotaanV']['golonganpegawai_id'];
		}
		$this->render('informasi', array('anggota'=>$anggota));
	}

	public function actionPrint() {
		$this->layout='//layouts/print';
		$this->pageTitle = 'ecoopsys - Print Informasi Anggota Koperasi';
		$anggota = new KeanggotaanV;
		$profil = ProfilS::model()->find();
		if (isset($_GET['KeanggotaanV'])) {
			$anggota->attributes = $_GET['KeanggotaanV'];
		}
		$this->render('print', array('anggota'=>$anggota,'profil'=>$profil));
	}

	public function actionPrintAnggota($id,$p = null) {
		$this->layout = '//layouts/print';
		$this->pageTitle = 'ecoopsys - Print Data Anggota';
		$anggota = KeanggotaanV::model()->findByAttributes(array('keanggotaan_id'=>$id));
		$profil = ProfilS::model()->find();
		$this->render('printAnggota', array('anggota'=>$anggota,'profil'=>$profil));
	}

	// ===================================================

	public function cariSimpananGolongan($param) {
		$golongan = GolonganpegawaiM::model()->findByPk($param['id']);
		if (empty($golongan)) GolonganpegawaiM::model()->findByPk(1);

		echo CJSON::encode(array('simpanan'=>number_format($golongan->simpananpokok, 0, ',', '.')));
	}
	// ===================================================


	protected function savePegawai(&$pegawai, $postPegawai, &$cond) {
		if (!empty($postPegawai['pegawai_id'])) {
			$pegawai = PegawaiM::model()->findByPk($postPegawai['pegawai_id']);
			$pegawai->peg_update_time = date('Y-m-d H:i:s');
			$pegawai->peg_update_login = Yii::app()->user->name;
		} else {
			$pegawai->peg_create_time = date('Y-m-d H:i:s');
			$pegawai->peg_create_login = Yii::app()->user->name;
		}
		$pegawai->isanggota = true;
		$photoPath = $pegawai->photopegawai;
		$pegawai->attributes = $postPegawai;
		$pegawai->tgl_lahirpegawai = MyFormatter::formatDateForDb($pegawai->tgl_lahirpegawai);

		$pegawai->gajipokok = str_replace(".","",$pegawai->gajipokok);
		$pegawai->insentifpegawai = str_replace(".","",$pegawai->insentifpegawai);

		if (!empty($pegawai->tglmulaibekerja) || $pegawai->tglmulaibekerja != '') $pegawai->tglmulaibekerja = MyFormatter::formatDateForDb($pegawai->tglmulaibekerja);
		else $pegawai->tglmulaibekerja = null;

		$pegawai->photopegawai=CUploadedFile::getInstance($pegawai,'photopegawai');

		if (empty($pegawai->photopegawai)) {
			$pegawai->photopegawai = $photoPath;
			$cond = false;
		}
                
                if ($pegawai->jeniskelamin == 'LAKI-LAKI') {
                    $pegawai->gelardepan = "Tn.";
                } else {
                    if ($pegawai->statusperkawinan == "BELUM KAWIN") {
                        $pegawai->gelardepan = "Nn.";
                    } else {
                        $pegawai->gelardepan = "Ny.";
                    }
                }
                // var_dump($pegawai->attributes); die;
		if ($pegawai->validate()) {
			return $pegawai->save();
		} return false;

		//var_dump ($pegawai->attributes); die;

	}

	protected function saveAnggota(&$anggota, $pegawai, $postAnggota) {
		$anggota->attributes = $postAnggota;
		$anggota->pegawai_id = $postAnggota['pegawai_id'];
		$anggota->tgldisetujui = MyFormatter::formatDateTimeForDb($anggota->tgldisetujui);
		$anggota->tglkeanggotaaan = MyFormatter::formatDateTimeForDb($anggota->tglkeanggotaaan);
		$anggota->create_time = date('Y-m-d H:i:s');
		$anggota->create_loginpemakai_id = Yii::app()->user->name;
		$anggota->create_ruangan = Yii::app()->user->getState('ruangan_id');
		if ($anggota->validate()) {
			return $anggota->save();
			// return true;
		} return false;

	}
	protected function saveBKM(&$kasmasuk, $pegawai, $postSimpanan, $postKasmasuk) {
		if ($_POST['terima_kas'] != 1) return true;
		foreach ($postKasmasuk as $idx => $item) {
			$postKasmasuk[$idx] = str_replace(".", "", $item);
		}
		$jenis = JenistransaksiM::model()->find("namatransaksilainnnya ilike '%simpanan%'");
		// var_dump($jenis->attributes); die;
		$kasmasuk->attributes = $postKasmasuk;
		$kasmasuk->tglbuktibayar = $postSimpanan['tglsimpanan'];
		$kasmasuk->tglbuktibayar = MyFormatter::formatDateTimeForDb($kasmasuk->tglbuktibayar);
		$kasmasuk->sebagaipembayaran_bkm = "Simpanan Pokok";
		$kasmasuk->carapembayaran = "TUNAI";
		$kasmasuk->jmlbayarkartu = 0;
		$kasmasuk->darinama_bkm = $pegawai->nama_pegawai;
		$kasmasuk->alamat_bkm = trim($pegawai->alamat_pegawai) == ""?"-":$pegawai->alamat_pegawai;
		$kasmasuk->create_time = date('Y-m-d H:i:s');
		$kasmasuk->create_login = Yii::app()->user->name;
		$kasmasuk->nobuktimasuk = $kasmasuk->generateNoBukti('SP');
		$kasmasuk->keterangan_pembayaran = 'Simpanan Pokok';
		if (!empty($jenis)) $kasmasuk->jenistransaksi_id = $jenis->jenistransaksi_id; 
		
		// var_dump($kasmasuk->attributes, $kasmasuk->validate(), $kasmasuk->errors); die;
		
		if ($kasmasuk->validate()) {
			return $kasmasuk->save();
		} return false;
	}
	protected function saveSimpanan(&$simpanan, $kasmasuk, $anggota, $postSimpanan) {
		$jenis = JenissimpananM::model()->findByPk($postSimpanan['jenissimpanan_id']);

		$simpanan->attributes = $postSimpanan;
		$simpanan->jumlahsimpanan = str_replace(".", "", $postSimpanan['jumlahsimpanan']);
		$simpanan->satuan = '-';
		$simpanan->tglsimpanan = MyFormatter::formatDateTimeForDb($simpanan->tglsimpanan);
		$simpanan->keanggotaan_id = $anggota->keanggotaan_id;
		$simpanan->buktikasmasukkop_id = $kasmasuk->buktikasmasukkop_id;
		$simpanan->jangkawaktusimpanan = $jenis->jangkapenarikanbln;
		$simpanan->persenjasa_thn = $jenis->persenjasathn;
		$simpanan->persenpajak_thn = $jenis->persenpajakthn;
		// $simpanan->makstglpenarikan = date('Y-m-d', strtotime($simpanan->tglsimpanan." + ".$simpanan->jangkawaktusimpanan." months"));
		$simpanan->create_time = date('Y-m-d H:i:s');
		$simpanan->create_loginpemakai_id = Yii::app()->user->id;
		$simpanan->create_ruangan = Yii::app()->user->getState('ruangan_id');
		$simpanan->nosimpanan = $simpanan->generateNoSimpanan($jenis->jenissimpanan_singkatan);

		//$simpanan->validate();
		//var_dump($simpanan->attributes); die;

		if ($simpanan->validate()) {
			return $simpanan->save();
		} return false;
	}

}
