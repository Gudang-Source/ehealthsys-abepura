<?php

class PenerimaanSimpananController extends MyAuthController
{
	public $layout='//layouts/admin/default';
	// public $defaultAction = 'admin';
	public $menuActive = array(4,0); // Default. Harap diubah sesuai menu aktif yang ada.
	public function actionDeposit($id = null)
	{
		$simpanan = new SimpananT;
		$anggota = new KeanggotaanT;
		$kasmasuk = new BuktikasmasukT;
		$pegawai = new PegawaiM;
		$insert_notifikasi = new MyFunction();
		$this->menuActive = array(4,2);
		$this->pageTitle = 'ecoopsys - Transaksi Simpanan Deposito';
		$jenis = JenissimpananM::model()->findByPk(Params::ID_SIMPANAN_DEPOSITO);

		$konfig = KonfigurasikoperasiK::model()->find(array('order'=>'kofigurasikoperasi_id asc', 'condition'=>'isberlaku = true'));

		$simpanan->tglsimpanan = date('d/m/Y H:i');
		$simpanan->jenissimpanan_id = $jenis->jenissimpanan_id;
		$simpanan->persenjasa_thn = $jenis->persenjasathn;

		$kasmasuk->preparedby = Yii::app()->user->getState('pegawai_id');
		$kasmasuk->reviewedby = $konfig->penguruskoperasi_id;
		$kasmasuk->approvedby = $konfig->pimpiankoperasi_id;
		$kasmasuk->prepareddate = $kasmasuk->revieweddate = $kasmasuk->approveddate = date('d/m/Y H:i');

		$ok = true;
		if (isset($_POST['BuktikasmasukT'])) {
			$trans = Yii::app()->db->beginTransaction();
			// var_dump($_POST); die;
			$ok = $ok && $this->saveBKM($kasmasuk, $_POST['BuktikasmasukT'], $_POST['SimpananT']); // var_dump($ok); die;
			$ok = $ok && $this->saveSimpanan($simpanan, $kasmasuk, $_POST['SimpananT'], Params::ID_SIMPANAN_DEPOSITO);

			$anggota = KeanggotaanT::model()->findByPk($simpanan->keanggotaan_id);
			//insert notifikasi
			$params['tglnotifikasi'] = date( 'Y-m-d H:i:s');
         $params['create_time'] = date( 'Y-m-d H:i:s');
         $params['create_loginpemakai_id'] = Yii::app()->user->id;
         $params['isinotifikasi'] = $anggota->pegawai->nama_pegawai . ', ' . $anggota->nokeanggotaan . '<br/>' . $simpanan->nosimpanan . ', ' . MyFormatter::formatDateTimeId($simpanan->tglsimpanan) . ', Rp' . MyFormatter::formatNumberForPrint($simpanan->jumlahsimpanan) . '<br/> Dibuat Oleh : ' . Yii::app()->user->name;
         $params['judulnotifikasi'] = 'Simpanan Deposito';
         $params['link'] = '/simpanan/informasiSimpanan&no='.$simpanan->nosimpanan;
         $nofitikasi = $insert_notifikasi->insertNotifikasi($params);

			if ($ok) {
				$trans->commit();
				$this->redirect(array('deposit', 'status'=>1, 'id'=>$kasmasuk->buktikasmasuk_id));
			} else {
				$trans->rollback();
				$this->redirect(array('deposit', 'status'=>0));
			}
		}

		if (!empty($id)) {
			$kasmasuk = BuktikasmasukT::model()->findByPk($id);
			$simpanan = SimpananT::model()->findByAttributes(array('buktikasmasuk_id'=>$id));
			$simpanan->persenjasa_thn = number_format($simpanan->persenjasa_thn, 2, ",", ".");
			$anggota = KeanggotaanT::model()->findByPk($simpanan->keanggotaan_id);
			$pegawai = PegawaiM::model()->findByPk($anggota->pegawai_id);
			$pegawai->umur = Params::getUmur($pegawai->tgl_lahirpegawai)." Tahun";
			if (!empty($pegawai->golonganpegawai_id)) $pegawai->golonganpegawai_id = $pegawai->golonganpegawai->golonganpegawai_nama;
		}

		$this->render('deposit', array(
			'simpanan'=>$simpanan, 'anggota'=>$anggota, 'pegawai'=>$pegawai, 'kasmasuk'=>$kasmasuk,
		));
	}

	public function actionSukarela($id = null)
	{
		$simpanan = new SimpananT;
		$anggota = new KeanggotaanT;
		$kasmasuk = new BuktikasmasukT;
		$pegawai = new PegawaiM;
		$insert_notifikasi = new MyFunction();
		$this->menuActive = array(4,1);
		$this->pageTitle = 'ecoopsys - Transaksi Simpanan Sukarela';
		$jenis = JenissimpananM::model()->findByPk(Params::ID_SIMPANAN_SUKARELA);

		$konfig = KonfigurasikoperasiK::model()->find(array('order'=>'kofigurasikoperasi_id asc', 'condition'=>'isberlaku = true'));

		$simpanan->tglsimpanan = date('d/m/Y H:i');
		$simpanan->jenissimpanan_id = $jenis->jenissimpanan_id;
		$simpanan->persenjasa_thn = number_format($konfig->persjasasimpanan, 2, ",", ".");

		$kasmasuk->preparedby = Yii::app()->user->getState('pegawai_id');
		$kasmasuk->reviewedby = $konfig->penguruskoperasi_id;
		$kasmasuk->approvedby = $konfig->pimpiankoperasi_id;
		$kasmasuk->prepareddate = $kasmasuk->revieweddate = $kasmasuk->approveddate = date('d/m/Y H:i');


		$ok = true;
		if (isset($_POST['BuktikasmasukT'])) {
			$trans = Yii::app()->db->beginTransaction();
			// var_dump($_POST); die;
			$ok = $ok && $this->saveBKM($kasmasuk, $_POST['BuktikasmasukT'], $_POST['SimpananT']);
			$ok = $ok && $this->saveSimpanan($simpanan, $kasmasuk, $_POST['SimpananT'], Params::ID_SIMPANAN_SUKARELA);

			$anggota = KeanggotaanT::model()->findByPk($simpanan->keanggotaan_id);
			//insert notifikasi
			$params['tglnotifikasi'] = date( 'Y-m-d H:i:s');
         $params['create_time'] = date( 'Y-m-d H:i:s');
         $params['create_loginpemakai_id'] = Yii::app()->user->id;
         $params['isinotifikasi'] = $anggota->pegawai->nama_pegawai . ', ' . $anggota->nokeanggotaan . '<br/>' . $simpanan->nosimpanan . ', ' . MyFormatter::formatDateTimeId($simpanan->tglsimpanan) . ', Rp' . MyFormatter::formatNumberForPrint($simpanan->jumlahsimpanan) . '<br/> Dibuat Oleh : ' . Yii::app()->user->name;
         $params['judulnotifikasi'] = 'Simpanan Sukarela';
         $params['link'] = '/simpanan/informasiSimpanan&no='.$simpanan->nosimpanan;
         $nofitikasi = $insert_notifikasi->insertNotifikasi($params);

			if ($ok) {
				$trans->commit();
				$this->redirect(array('sukarela', 'status'=>1, 'id'=>$kasmasuk->buktikasmasuk_id));
			} else {
				$trans->rollback();
				$this->redirect(array('sukarela', 'status'=>0));
			}



		}

		if (!empty($id)) {
			$kasmasuk = BuktikasmasukT::model()->findByPk($id);
			$simpanan = SimpananT::model()->findByAttributes(array('buktikasmasuk_id'=>$id));
			$simpanan->persenjasa_thn = number_format($simpanan->persenjasa_thn, 2, ",", ".");
			$anggota = KeanggotaanT::model()->findByPk($simpanan->keanggotaan_id);
			$pegawai = PegawaiM::model()->findByPk($anggota->pegawai_id);
			$pegawai->umur = Params::getUmur($pegawai->tgl_lahirpegawai)." Tahun";
			if (!empty($pegawai->golonganpegawai_id)) $pegawai->golonganpegawai_id = $pegawai->golonganpegawai->golonganpegawai_nama;
		}

		$this->render('sukarela', array(
			'simpanan'=>$simpanan, 'anggota'=>$anggota, 'pegawai'=>$pegawai, 'kasmasuk'=>$kasmasuk,
		));
	}

	public function actionJasaSukarela($id = null)
	{
		$simpanan = new SimpananT;
		$anggota = new KeanggotaanT;
		$kasmasuk = new BuktikasmasukT;
		$pegawai = new PegawaiM;
		$insert_notifikasi = new MyFunction();
		$this->menuActive = array(4,2);
		$this->pageTitle = 'ecoopsys - Transaksi Simpanan Jasa Sukarela';
		$jenis = JenissimpananM::model()->findByPk(Params::ID_SIMPANAN_JASA_SUKARELA);

		$konfig = KonfigurasikoperasiK::model()->find(array('order'=>'kofigurasikoperasi_id asc', 'condition'=>'isberlaku = true'));

		$simpanan->tglsimpanan = date('d/m/Y H:i');
		$simpanan->jenissimpanan_id = $jenis->jenissimpanan_id;
		$simpanan->persenjasa_thn = number_format($konfig->persjasasimpanan, 2, ",", ".");

		$kasmasuk->preparedby = Yii::app()->user->getState('pegawai_id');
		$kasmasuk->reviewedby = $konfig->penguruskoperasi_id;
		$kasmasuk->approvedby = $konfig->pimpiankoperasi_id;
		$kasmasuk->prepareddate = $kasmasuk->revieweddate = $kasmasuk->approveddate = date('d/m/Y H:i');


		$ok = true;
		if (isset($_POST['BuktikasmasukT'])) {
			$trans = Yii::app()->db->beginTransaction();
			// var_dump($_POST); die;
			$ok = $ok && $this->saveBKM($kasmasuk, $_POST['BuktikasmasukT'], $_POST['SimpananT']);
			$ok = $ok && $this->saveSimpanan($simpanan, $kasmasuk, $_POST['SimpananT'], Params::ID_SIMPANAN_JASA_SUKARELA);

			$anggota = KeanggotaanT::model()->findByPk($simpanan->keanggotaan_id);
			//insert notifikasi
			$params['tglnotifikasi'] = date( 'Y-m-d H:i:s');
         $params['create_time'] = date( 'Y-m-d H:i:s');
         $params['create_loginpemakai_id'] = Yii::app()->user->id;
         $params['isinotifikasi'] = $anggota->pegawai->nama_pegawai . ', ' . $anggota->nokeanggotaan . '<br/>' . $simpanan->nosimpanan . ', ' . MyFormatter::formatDateTimeId($simpanan->tglsimpanan) . ', Rp' . MyFormatter::formatNumberForPrint($simpanan->jumlahsimpanan) . '<br/> Dibuat Oleh : ' . Yii::app()->user->name;
         $params['judulnotifikasi'] = 'Simpanan Jasa Sukarela';
         $params['link'] = '/simpanan/informasiSimpanan&no='.$simpanan->nosimpanan;
         $nofitikasi = $insert_notifikasi->insertNotifikasi($params);

			if ($ok) {
				$trans->commit();
				$this->redirect(array('sukarela', 'status'=>1, 'id'=>$kasmasuk->buktikasmasuk_id));
			} else {
				$trans->rollback();
				$this->redirect(array('sukarela', 'status'=>0));
			}



		}

		if (!empty($id)) {
			$kasmasuk = BuktikasmasukT::model()->findByPk($id);
			$simpanan = SimpananT::model()->findByAttributes(array('buktikasmasuk_id'=>$id));
			$simpanan->persenjasa_thn = number_format($simpanan->persenjasa_thn, 2, ",", ".");
			$anggota = KeanggotaanT::model()->findByPk($simpanan->keanggotaan_id);
			$pegawai = PegawaiM::model()->findByPk($anggota->pegawai_id);
			$pegawai->umur = Params::getUmur($pegawai->tgl_lahirpegawai)." Tahun";
			if (!empty($pegawai->golonganpegawai_id)) $pegawai->golonganpegawai_id = $pegawai->golonganpegawai->golonganpegawai_nama;
		}

		$this->render('sukarela', array(
			'simpanan'=>$simpanan, 'anggota'=>$anggota, 'pegawai'=>$pegawai, 'kasmasuk'=>$kasmasuk,
		));
	}

	public function actionWajibPokok($id = null)
	{
		$simpanan = new SimpananT;
		$anggota = new KeanggotaanT;
		$kasmasuk = new BuktikasmasukT;
		$pegawai = new PegawaiM;
		$insert_notifikasi = new MyFunction();
		$konfig = KonfigurasikoperasiK::model()->find(array('order'=>'kofigurasikoperasi_id asc', 'condition'=>'isberlaku = true'));
		$this->pageTitle = 'ecoopsys - Transaksi Simpanan Wajib / Pokok';
		$simpanan->tglsimpanan = date('d/m/Y H:i');
		$simpanan->jenissimpanan_id = array(
			Params::ID_SIMPANAN_POKOK,
			Params::ID_SIMPANAN_WAJIB,
		);
		$kasmasuk->preparedby = Yii::app()->user->getState('pegawai_id');
		$kasmasuk->reviewedby = $konfig->penguruskoperasi_id;
		$kasmasuk->approvedby = $konfig->pimpiankoperasi_id;

		$kasmasuk->prepareddate = $kasmasuk->revieweddate = $kasmasuk->approveddate = date('d/m/Y H:i');

		$ok = true;
		if (isset($_POST['BuktikasmasukT'])) {
			$trans = Yii::app()->db->beginTransaction();
			// var_dump($_POST); die;
			$ok = $ok && $this->saveBKM($kasmasuk, $_POST['BuktikasmasukT'], $_POST['SimpananT']);
			if (isset($_POST['cek_simpanan'])) {
				foreach ($_POST['cek_simpanan'] as $idx=>$cek) {
					if ($cek == 1) $ok = $ok && $this->saveSimpanan($simpanan, $kasmasuk, $_POST['SimpananT'], $idx);
				}
			}

			$anggota = KeanggotaanT::model()->findByPk($simpanan->keanggotaan_id);
			//insert notifikasi
			$params['tglnotifikasi'] = date( 'Y-m-d H:i:s');
         $params['create_time'] = date( 'Y-m-d H:i:s');
         $params['create_loginpemakai_id'] = Yii::app()->user->id;
         $params['isinotifikasi'] = $anggota->pegawai->nama_pegawai . ', ' . $anggota->nokeanggotaan . '<br/>' . $simpanan->nosimpanan . ', ' . MyFormatter::formatDateTimeId($simpanan->tglsimpanan) . ', Rp' . MyFormatter::formatNumberForPrint($simpanan->jumlahsimpanan) . '<br/> Dibuat Oleh : ' . Yii::app()->user->name;
         $params['judulnotifikasi'] = 'Simpanan Pokok/Wajib';
         $params['link'] = '/simpanan/informasiSimpanan&no='.$simpanan->nosimpanan;
         $nofitikasi = $insert_notifikasi->insertNotifikasi($params);

         if ($ok) {
				$trans->commit();
				$this->redirect(array('wajibPokok', 'status'=>1, 'id'=>$kasmasuk->buktikasmasuk_id));
			} else {
				$trans->rollback();
				$this->redirect(array('wajibPokok', 'status'=>0));
			}
			//var_dump($ok); die;
		}

		if (!empty($id)) {
			$kasmasuk = BuktikasmasukT::model()->findByPk($id);
			$simpanan = SimpananT::model()->findByAttributes(array('buktikasmasuk_id'=>$id));
			$anggota = KeanggotaanT::model()->findByPk($simpanan->keanggotaan_id);
			$pegawai = PegawaiM::model()->findByPk($anggota->pegawai_id);
			$pegawai->umur = Params::getUmur($pegawai->tgl_lahirpegawai)." Tahun";
			if (!empty($pegawai->golonganpegawai_id)) $pegawai->golonganpegawai_id = $pegawai->golonganpegawai->golonganpegawai_nama;
		}

		$this->render('wajibPokok', array(
			'simpanan'=>$simpanan, 'anggota'=>$anggota, 'pegawai'=>$pegawai, 'kasmasuk'=>$kasmasuk,
		));
	}

	protected function saveBKM(&$kasmasuk, $postKasmasuk, $postSimpanan) {
		$anggota = KeanggotaanT::model()->findByPk($postSimpanan['keanggotaan_id']);
		foreach ($postKasmasuk as $idx => $item) {
			$postKasmasuk[$idx] = str_replace(".", "", $item);
		}
		$kasmasuk->attributes = $postKasmasuk;
		$kasmasuk->jenistransaksi_id = 11; // default = Simpanan
		$kasmasuk->nobuktimasuk = $kasmasuk->generateNoBukti();
		$kasmasuk->tglbuktibayar = MyFormatter::formatDateTimeForDb($postSimpanan['tglsimpanan']).":00";
		$kasmasuk->prepareddate = MyFormatter::formatDateTimeForDb($kasmasuk->prepareddate).":00";
		$kasmasuk->revieweddate = MyFormatter::formatDateTimeForDb($kasmasuk->revieweddate).":00";
		$kasmasuk->approveddate = MyFormatter::formatDateTimeForDb($kasmasuk->approveddate).":00";
		$kasmasuk->keterangan_pembayaran = $postSimpanan['keterangansimpanan'];
		$kasmasuk->carapembayaran = 'TUNAI';
		$kasmasuk->jmlbayarkartu = 0;
		$kasmasuk->darinama_bkm = $anggota->pegawai->gelardepan." ".$anggota->pegawai->nama_pegawai;
		$kasmasuk->alamat_bkm = $anggota->pegawai->alamat_pegawai;
		$kasmasuk->create_time = date('Y-m-d H:i:s');
		$kasmasuk->create_login = Yii::app()->user->name;
		$sebagai = "Simpanan ";
		$cnt = 0;
		foreach ($postSimpanan['jumlahsimpanan'] as $idx=>$item) {
			if ($item != 0) {
				if ($cnt != 0) $sebagai .= '/ ';
				$sebagai .= JenissimpananM::model()->findByPk($idx)->jenissimpanan." ";
				$cnt++;
			}
		}

		$kasmasuk->sebagaipembayaran_bkm = $sebagai;
		//var_dump($kasmasuk->validate()); die;
		//var_dump($kasmasuk->attributes); die;
		//var_dump($postSimpanan); die;
		if ($kasmasuk->validate()) {
			return $kasmasuk->save();
		} return false;
	}

	protected function saveSimpanan(&$simpanan, $kasmasuk, $postSimpanan, $idx) {
		$simpanan = new SimpananT;
		$simpanan->attributes = $postSimpanan;
		// var_dump($postSimpanan); die;
		$jenis = JenissimpananM::model()->findByPk($idx);
		$simpanan->nosimpanan = $simpanan->generateNoSimpanan($jenis->jenissimpanan_singkatan);
		$simpanan->jumlahsimpanan = $postSimpanan['jumlahsimpanan'][$idx];
		$simpanan->jumlahsimpanan = str_replace(".", "", $simpanan->jumlahsimpanan);
		$simpanan->jenissimpanan_id = $idx;
		$simpanan->tglsimpanan = MyFormatter::formatDateTimeForDb($simpanan->tglsimpanan).":00";
		$simpanan->buktikasmasuk_id = $kasmasuk->buktikasmasuk_id;
		$simpanan->satuan = empty($simpanan->satuan)?'-':$simpanan->satuan;
		$simpanan->persenjasa_thn = empty($simpanan->persenjasa_thn)?0:str_replace(",",".",$simpanan->persenjasa_thn);
		$simpanan->persenpajak_thn = empty($simpanan->persenpajak_thn)?0:$simpanan->persenpajak_thn;
		$simpanan->simp_create_time = date('Y-m-d H:i:s');
		$simpanan->simp_create_login = Yii::app()->user->name;
		$simpanan->jangkawaktusimpanan = empty($simpanan->jangkawaktusimpanan)?0:$simpanan->jangkawaktusimpanan;

		//var_dump($simpanan->attributes); die;
		// var_dump($simpanan->errors); die;
		if ($simpanan->validate()) {
			return $simpanan->save();
		} return false;
	}
}
