<?php

class PemberhentianController extends MyAuthController
{
	public $layout='//layouts/column1';
	// public $defaultAction = 'admin';
	
	public function actionIndex($NoAnggota = null, $id = null)
	{
		if (isset($_POST['ajax'])) {
			if (isset($_POST['param'])) call_user_func(array($this, $_POST['f']), $_POST['param']);
			Yii::app()->end();
		}
		$insert_notifikasi = new CustomFunction();
		$anggota = new KeanggotaanV;
		$berhenti = new PermintaanberhentiT;		
		$berhenti->tglpermintaanberhenti = date('d/m/Y');

		$konfig = KonfigkoperasiK::model()->find('status_aktif = true');
		$berhenti->tgldibuatpermintaan = $berhenti->tgldiperiksaperm = $berhenti->tgldisetujuiperm = date('d/m/Y H:i');
                $berhenti->dibuatolehperm_id = Yii::app()->user->getState('pegawai_id');
                $berhenti->diperiksaprmint_id = $konfig->penguruskoperasi_id;
                $berhenti->disetuuiolehperm_id = $konfig->pimpinankoperasi_id;


		if (isset($_POST['PemintaanberhentiT'])) {
			// var_dump($_POST); die;
			$trans = Yii::app()->db->beginTransaction();
			$ok = true;

			$ok = $ok && $this->saveDataBerhenti($berhenti, $_POST);
		  $ok = $ok && $this->updateSimpananAngsuran($berhenti, $_POST);

			if (!empty($berhenti->tglberhenti_dipecat)) {
				$ok = $ok && KeanggotaanT::model()->updateByPk($berhenti->keanggotaan_id, array('tglberhentikeanggotaan'=>$berhenti->tglberhenti_dipecat));
				$ok = $ok && PegawaiM::model()->updateByPk($berhenti->pegawai_id, array(
					//'tglberhenti'=>$berhenti->tglberhenti_dipecat, // ????
					'isanggota'=>false,
				));
			}

			$anggota = KeanggotaanT::model()->findByPk($berhenti->keanggotaan_id);
			/*
			$simpanan = SimpananT::model()->findAllByAttributes(array('keanggotaan_id'=>$berhenti->keanggotaan_id));
			$totSimpanan = 0;
			foreach ($simpanan as $item=>$value){
				$totSimpanan += $value->jumlahsimpanan;
			}

			$pinjaman = PinjamanT::model()->findAllByAttributes(array('keanggotaan_id'=>$berhenti->keanggotaan_id));
			$totPinjaman = 0;
			foreach($pinjaman as $item=>$value){
				$totPinjaman += $value->jml_pinjaman + ($value->jml_pinjaman *($value->persen_jasa_pinjaman/100));
			}
			$angsuran = JmlangsuranT::model()->findAllByAttributes(array('keanggotaan_id'=>$berhenti->keanggotaan_id));
			$totSisaAngsuran = 0;
			foreach($angsuran as $value){
				$totSisaAngsuran += $value->sisa;
			} */
			//$totSisaAngsuran = $totPinjaman - $sisaAngsuran;
			//var_dump($totSisaAngsuran); die;
			//insert notifikasi
			$params['tglnotifikasi'] = date( 'Y-m-d H:i:s');
         $params['create_time'] = date( 'Y-m-d H:i:s');
         $params['create_loginpemakai_id'] = Yii::app()->user->id;
         $params['isinotifikasi'] = $anggota->pegawai->nama_pegawai . ', ' . $anggota->nokeanggotaan . '<br/> Rp' . MyFormatter::formatNumberForPrint($berhenti->jmlsimpanan_berhenti) . ', Rp' . MyFormatter::formatNumberForPrint($berhenti->jmltunggakan_berhenti) . '<br/> Dibuat Oleh : ' . Yii::app()->user->name;
         $params['judulnotifikasi'] = 'Pemberhentian Anggota';
         $nofitikasi = $insert_notifikasi->insertNotifikasi($params);

			if ($ok) {
				$trans->commit();
				$this->redirect(array('index', 'id'=>$berhenti->pemintaanberhenti_id, 'status'=>1));
			} else {
				$this->rollback();
				$this->redirect(array('index', 'status'=>0));
			}

			//var_dump($berhenti->attributes); die;
		}
		/*if (!empty($idAnggota)) {
			$anggota = KeanggotaanV::model()->findByAttributes(array('keanggotaan_id'=>$idAnggota));
			$anggota->photopegawai = Params::urlPegawaiGambar().$anggota->photopegawai;

			$anggota->tgl_lahirpegawai = date('d/m/Y', strtotime($anggota->tgl_lahirpegawai));
			$anggota->tglkeanggotaaan = date('d/m/Y', strtotime($anggota->tglkeanggotaaan));
		}*/
		if (!empty($id)) {
			$berhenti = PermintaanberhentiT::model()->findByPk($id);
			$anggota = KeanggotaanV::model()->findByAttributes(array('keanggotaan_id'=>$berhenti->keanggotaan_id));
			$anggota->photopegawai = Params::urlPegawaiGambar().$anggota->photopegawai;

			$anggota->tgl_lahirpegawai = date('d/m/Y', strtotime($anggota->tgl_lahirpegawai));
			$anggota->tglkeanggotaaan = date('d/m/Y', strtotime($anggota->tglkeanggotaaan));

			$berhenti->tglpermintaanberhenti = date('d/m/Y', strtotime($anggota->tglpermintaanberhenti));
			$berhenti->tglberhenti_dipecat = empty($berhenti->tglberhenti_dipecat)?null:date('d/m/Y', strtotime($anggota->tglberhenti_dipecat));

			$berhenti->tgldibuatpermintaan = date('d/m/Y', strtotime($berhenti->tgldibuatpermintaan));
			$berhenti->tgldiperiksaperm = empty($berhenti->tgldiperiksaperm)?null:date('d/m/Y', strtotime($berhenti->tgldiperiksaperm));
			$berhenti->tgldisetujuiperm = empty($berhenti->tgldisetujuiperm)?null:date('d/m/Y', strtotime($berhenti->tgldisetujuiperm));
		}

		$this->render('index', array('anggota' => $anggota, 'berhenti'=>$berhenti));
	}


	public function actionKasMasuk($id = null, $bkm = null) {
		$anggota = KeanggotaanV::model()->findByAttributes(array('keanggotaan_id'=>$id));
		$berhenti = PermintaanberhentiT::model()->findByAttributes(array('keanggotaan_id'=>$id));
		$konfig = KonfigkoperasiK::model()->find('isberlaku = true');

		$anggota->unit_id = $anggota->namaunit;
		$anggota->umur = Params::getUmur($anggota->tgl_lahirpegawai)." Tahun";
		$anggota->tgl_lahirpegawai = date('d/m/Y', strtotime($anggota->tgl_lahirpegawai));
		$anggota->tglkeanggotaaan = date('d/m/Y H:i', strtotime($anggota->tglkeanggotaaan));

		if (empty($bkm)) {
			$kasmasuk = new BuktikasmasukkopT;
			$angsuran = JmlangsuranT::model()->findAllByAttributes(array('pemintaanberhenti_id'=>$berhenti->pemintaanberhenti_id, 'isudahbayar'=>false));
			$konfig = KonfigurasikoperasiK::model()->find('isberlaku = true');

			$kasmasuk->tglbuktibayar = date('d/m/Y H:i');
			$kasmasuk->nobuktimasuk = $kasmasuk->generateNoBukti();
			$kasmasuk->jmlpembayaran = 0;
			//$kasmasuk->biayamaterai = 7000;
			foreach($angsuran as $item) $kasmasuk->jmlpembayaran += $item->sisa;
			$kasmasuk->jmlpembayaran = MyFormatter::formatNumberForPrint($kasmasuk->jmlpembayaran);

			$kasmasuk->preparedby = Yii::app()->user->getState('pegawai_id');
			if (!empty($konfig)) {
				$kasmasuk->reviewedby = $konfig->bendahara_id;
				$kasmasuk->approvedby = $konfig->pimpiankoperasi_id;
			}
			$kasmasuk->prepareddate = $kasmasuk->revieweddate = $kasmasuk->approveddate = date('d/m/Y H:i');
		} else {
			$angsuran = JmlangsuranT::model()->findAllByAttributes(array('pemintaanberhenti_id'=>$berhenti->pemintaanberhenti_id,));
			$kasmasuk = BuktikasmasukT::model()->findByPk($bkm);
			$kasmasuk->tglbuktibayar = date('d/m/Y H:i', strtotime($kasmasuk->tglbuktibayar));
			$kasmasuk->prepareddate = date('d/m/Y H:i', strtotime($kasmasuk->prepareddate));
			$kasmasuk->revieweddate = date('d/m/Y H:i', strtotime($kasmasuk->revieweddate));
			$kasmasuk->approveddate = date('d/m/Y H:i', strtotime($kasmasuk->approveddate));

			$kasmasuk->jmlpembayaran = MyFormatter::formatNumberForPrint($kasmasuk->jmlpembayaran);
			$kasmasuk->biayaadministrasi = MyFormatter::formatNumberForPrint($kasmasuk->biayaadministrasi);
			$kasmasuk->biayamaterai = MyFormatter::formatNumberForPrint($kasmasuk->biayamaterai);
			$kasmasuk->uangditerima = MyFormatter::formatNumberForPrint($kasmasuk->uangditerima);
			$kasmasuk->uangkembalian = MyFormatter::formatNumberForPrint($kasmasuk->uangkembalian);

			//var_dump($kasmasuk->attributes); die;

		}


		if (isset($_POST['BuktikasmasukT'])) {
			$ok = true;
			$trans = Yii::app()->db->beginTransaction();

			$ok = $ok && $this->saveBKM($kasmasuk, $_POST);// var_dump($ok); die;
			$ok = $ok && $this->saveAngsuran($kasmasuk, $_POST); //var_dump($ok); die;

			if ($ok) {
				$trans->commit();
				$this->redirect(array('kasmasuk', 'id'=>$id, 'bkm'=>$kasmasuk->buktikasmasuk_id, 'status'=>1));
			} else {
				$this->rollback();
				$this->redirect(array('kasmasuk', 'id'=>$id, 'status'=>0));
			}
		}

		$this->render('kasmasuk', array('kasmasuk'=>$kasmasuk, 'anggota'=>$anggota, 'berhenti'=>$berhenti, 'angsuran'=>$angsuran));
	}

	public function actionKasKeluar($id = null, $bkk = null) {
		$kaskeluar = new BukitkaskeluarT;
		$konfig = KonfigurasikoperasiK::model()->find('isberlaku = true');
		$anggota = KeanggotaanV::model()->findByAttributes(array('keanggotaan_id'=>$id));
		$berhenti = PemintaanberhentiT::model()->findByAttributes(array('keanggotaan_id'=>$id));


		if (empty($bkk)) {
			$simpanan = SimpananT::model()->findAllByAttributes(array('pemintaanberhenti_id'=>$berhenti->pemintaanberhenti_id), array('condition'=>'pengambilansimpanan_id is null'));
			$kaskeluar = new BukitkaskeluarT;
			$kaskeluar->no_bkk = $kaskeluar->generateNoBKK();
			$kaskeluar->tgl_bkk = date('d/m/Y H:i');
			$kaskeluar->preparedby = Yii::app()->user->getState('pegawai_id');
			$kaskeluar->prepareddate = date('d/m/Y H:i');
			$kaskeluar->reviewedby = $konfig->bendahara_id;
			$kaskeluar->revieweddate = date('d/m/Y H:i');
			$kaskeluar->approvedby = $konfig->pimpiankoperasi_id;
			$kaskeluar->approveddate = date('d/m/Y H:i');
		} else {
			$simpanan = SimpananT::model()->findAllByAttributes(array('pemintaanberhenti_id'=>$berhenti->pemintaanberhenti_id));
			$kaskeluar = BukitkaskeluarT::model()->findByPk($bkk);
			$kaskeluar->tgl_bkk = date('d/m/Y H:i', strtotime($kaskeluar->tgl_bkk));
			$kaskeluar->prepareddate = date('d/m/Y H:i', strtotime($kaskeluar->prepareddate));
			$kaskeluar->revieweddate = date('d/m/Y H:i', strtotime($kaskeluar->revieweddate));
			$kaskeluar->approveddate = date('d/m/Y H:i', strtotime($kaskeluar->approveddate));
			$kaskeluar->biayaadministrasi = MyFormatter::formatNumberForPrint($kaskeluar->biayaadministrasi);
			$kaskeluar->biayaamaterai = MyFormatter::formatNumberForPrint($kaskeluar->biayaamaterai);
			$kaskeluar->jmlkaskeluar = MyFormatter::formatNumberForPrint($kaskeluar->jmlkaskeluar);
		}
		$anggota->umur = Params::getUmur($anggota->tgl_lahirpegawai)." Tahun";
		$anggota->tgl_lahirpegawai = date('d/m/Y', strtotime($anggota->tgl_lahirpegawai));
		$anggota->unit_id = $anggota->namaunit;

		if (isset($_POST['BukitkaskeluarT'])) {
			$ok = true;
			$trans = Yii::app()->db->beginTransaction();

			$ok = $ok && $this->saveBKK($kaskeluar, $_POST); // var_dump($ok); die;
			$ok = $ok && $this->savePenarikan($kaskeluar, $_POST); //var_dump($ok); die;

			if ($ok) {
				$trans->commit();
				$this->redirect(array('kaskeluar', 'id'=>$id, 'bkk'=>$kaskeluar->bukitkaskeluar_id, 'status'=>1));
			} else {
				$this->rollback();
				$this->redirect(array('kaskeluar', 'id'=>$id, 'status'=>0));
			}
		}

		$this->render('kaskeluar', array('kaskeluar'=>$kaskeluar, 'anggota'=>$anggota, 'berhenti'=>$berhenti, 'simpanan'=>$simpanan));
	}

	public function actionInformasi()
	{		
		$anggota = new KOPemberhentiananggotaV;
		$anggota->tgl_awal = date('Y-m-d');
		$anggota->tgl_akhir = date('Y-m-d');
		if (isset($_GET['KOPemberhentiananggotaV'])) {
			$anggota->attributes = $_GET['KOPemberhentiananggotaV'];
			$anggota->tgl_awal = MyFormatter::formatDateTimeForDb($_GET['KOPemberhentiananggotaV']['tgl_awal']);
                        $anggota->tgl_akhir = MyFormatter::formatDateTimeForDb($_GET['KOPemberhentiananggotaV']['tgl_akhir']);
		}
		$this->render('informasi', array('anggota'=>$anggota));
	}

	public function actionPrintInformasi() {
		$this->layout='//layouts/printWidnows';
		
		$anggota = new KOPemberhentiananggotaV;
		$profil = ProfilS::model()->find();
		if (isset($_GET['KOPemberhentiananggotaV'])) {
			$anggota->attributes = $_GET['KOPemberhentiananggotaV'];
			if (!empty($_GET['KOPemberhentiananggotaV']['tglAwal'])) $anggota->tglAwal = MyFormatter::formatDateTimeForDb($_GET['PemberhentiananggotaV']['tglAwal']).':00';
			if (!empty($_GET['KOPemberhentiananggotaV']['tglAkhir'])) $anggota->tglAkhir = MyFormatter::formatDateTimeForDb($_GET['PemberhentiananggotaV']['tglAkhir']).':00';
		}
				$periode = MyFormatter::formatDateTimeId($anggota->tglAwal).' s/d '.MyFormatter::formatDateTimeId($anggota->tglAkhir);
		$this->render('printInformasi', array('anggota'=>$anggota,'profil'=>$profil,'periode'=>$periode));
	}

	public function actionPrint($id) {
		$this->layout = '//layouts/print';
		$this->pageTitle = 'ecoopsys - Print Permintaan Berhenti Menjadi Anggota Koperasi';
		$berhenti = PemintaanberhentiT::model()->findByPk($id);
		$anggota = KeanggotaanT::model()->findByPk($berhenti->keanggotaan_id);
		$profil = ProfilS::model()->find(array('order'=>'profilperusahaan_id asc'));
		$konfig = KonfigurasikoperasiK::model()->find('isberlaku = true');
		$pengurus = PegawaiM::model()->findByPk($konfig->penguruskoperasi_id);
		$this->render('print', array('pengurus'=>$pengurus,'profil'=>$profil,'konfig'=>$konfig, 'berhenti'=>$berhenti, 'anggota'=>$anggota));
	}

	public function actionPrintDetailSimpanPinjam($id) {
		$this->layout = '//layouts/print';
		$anggota = KeanggotaanV::model()->findByAttributes(array('keanggotaan_id'=>$id));
		$pegawai = PegawaiM::model()->findByPk($anggota->pegawai_id);
		$golongan = GolonganpegawaiM::model()->findByPk($pegawai->golonganpegawai_id);
		$res = $this->loadAngsuran(array('id'=>$id), true);
		$this->render('subview/_printSimpanPinjam', array('anggota'=>$anggota, 'golongan'=>$golongan, 'res'=>$res));
		//var_dump($res); die;
	}

	//===================================================================

	public function saveDataBerhenti(&$berhenti, $post) {
		$berhenti->attributes = $post['PemintaanberhentiT'];
		$berhenti->tglpermintaanberhenti = MyFormatter::formatDateForDb($berhenti->tglpermintaanberhenti);
		$berhenti->tgldibuatpermintaan = MyFormatter::formatDateForDb($berhenti->tgldibuatpermintaan);
		$berhenti->jmlsimpanan_berhenti = $post['PemintaanberhentiT']['jmlsimpanan_berhenti'];
		$berhenti->jmltunggakan_berhenti = $post['PemintaanberhentiT']['jmltunggakan_berhenti'];
		$berhenti->jmlkasmasuk_keluar = $post['PemintaanberhentiT']['jmlkasmasuk_keluar'];
		$berhenti->tglberhenti_dipecat = empty($berhenti->tglberhenti_dipecat)?null:MyFormatter::formatDateForDb($berhenti->tglberhenti_dipecat);
		$berhenti->tgldiperiksaperm = empty($berhenti->tgldiperiksaperm)?null:MyFormatter::formatDateForDb($berhenti->tgldiperiksaperm);
		$berhenti->tgldisetujuiperm = empty($berhenti->tgldisetujuiperm)?null:MyFormatter::formatDateForDb($berhenti->tgldisetujuiperm);

		if (!empty($berhenti->tglberhenti_dipecat)) {
			$berhenti->lamamenjadi_anggota = Params::getUmurLengkap($berhenti->tglberhenti_dipecat);
		}

		if ($berhenti->validate()) return $berhenti->save();
		return false;
	}

	public function updateSimpananAngsuran($berhenti, $post) {
		$ok = true;
		if (isset($post['simpanan'])) foreach ($post['simpanan'] as $item)
			$ok = $ok && SimpananT::model()->updateByPk($item, array('pemintaanberhenti_id'=>$berhenti->pemintaanberhenti_id));

		if (isset($post['angsuran'])) foreach ($post['angsuran'] as $item)
			$ok = $ok && JmlangsuranT::model()->updateByPk($item, array('pemintaanberhenti_id'=>$berhenti->pemintaanberhenti_id));

		return $ok;
	}

	public function saveBKM(&$kasmasuk, $post) {
		//var_dump($post); die;

		$bkmtgl = array('tglbuktibayar','approveddate','revieweddate','prepareddate');
		$bkmnum = array('biayaadministrasi', 'biayamaterai', 'uangditerima', 'uangkembalian', 'jmlpembayaran');

		$kasmasuk->attributes = $post['BuktikasmasukT'];
		$kasmasuk->jmlbayarkartu = 0;
		$kasmasuk->jenistransaksi_id = 1;
		$kasmasuk->darinama_bkm = $post['KeanggotaanV']['nama_pegawai'];
		$kasmasuk->alamat_bkm = $post['KeanggotaanV']['alamat_pegawai'];
		$kasmasuk->sebagaipembayaran_bkm = 'Pembayaran Pemberhentian.';
		$kasmasuk->keterangan_pembayaran = $post['BuktikasmasukT']['keterangan_pembayaran'];

		$kasmasuk->create_time = date('Y-m-d H:i:s');
		$kasmasuk->create_login = Yii::app()->user->name;

		//$kasmasuk->
		foreach ($bkmtgl as $item) $kasmasuk[$item] = MyFormatter::formatDateTimeForDb($kasmasuk[$item].":00");
		foreach ($bkmnum as $item) $kasmasuk[$item] = str_replace(".","",$kasmasuk[$item]);

		//$kasmasuk->validate();
		//var_dump($kasmasuk->errors); die;

		//var_dump($kasmasuk->attributes); die;

		if ($kasmasuk->validate()) return $kasmasuk->save();
		return false;
	}

	public function saveAngsuran($kasmasuk, $post) {
		$ok = true;
		foreach ($post['angsuran'] as $id=>$item) {
			$bayar = new PembayaranangsuranT;
			$bayar->jmlangsuran_id = $id;
			$bayar->buktikasmasuk_id = $kasmasuk->buktikasmasuk_id;
			$bayar->tglpembayaranangsuran = $kasmasuk->tglbuktibayar;
			$bayar->byrangsuranke = $item['byrangsuranke'];
			$bayar->jmlpokok_byrangsuran = $item['jmlpokok_angsuran'];
			$bayar->jmljasa_byrangsuran = $item['jmljasa_angsuran'];
			$bayar->jmlbayar_pembangsuran = $item['jmlbayar_pembangsuran'];
			$bayar->lamahari_sdhjthtempo = 0;

			$bayar->pembangs_create_time = date('Y-m-d H:i:s');
			$bayar->pembangs_create_login = Yii::app()->user->getState('pegawai_id');

			//$bayar->validate();
			//var_dump($bayar->errors); die;
			//var_dump($bayar->attributes); die;

			if ($bayar->validate()) {
				$ok = $ok && $bayar->save();
				$ok = $ok && JmlangsuranT::model()->updateByPk($id, array('isudahbayar'=>true, 'angs_update_time'=>date('Y-m-d'), 'angs_update_login'=>Yii::app()->user->name));
				//var_dump($ok); die;
				//var_dump($bayar->attributes); die;
			} else {
				$ok = false;
			}
		}
		return $ok;
	}
	//===================================================================

	public function saveBKK(&$kaskeluar, $post) {
		//var_dump($post); die;
		$bkktgl = array('tgl_bkk','prepareddate','revieweddate','approveddate');
		$bkknum = array('biayaadministrasi', 'biayaamaterai', 'jmlkaskeluar');

		$kaskeluar->attributes = $post['BukitkaskeluarT'];
		$kaskeluar->jenistransaksi_id = 2;
		$kaskeluar->namapenerima = $post['KeanggotaanV']['nama_pegawai'];
		$kaskeluar->alamatpenerima = $post['KeanggotaanV']['alamat_pegawai'];
		$kaskeluar->untuk_pengeluaran = "Penarikan Pemberhentian";

		foreach ($bkktgl as $item) $kaskeluar[$item] = MyFormatter::formatDateTimeForDb($kaskeluar[$item].":00");
		foreach ($bkknum as $item) $kaskeluar[$item] = str_replace(".","",$kaskeluar[$item]);

		$kaskeluar->bkk_create_time = date('Y-m-d H:i:s');
		$kaskeluar->bkk_create_login = Yii::app()->user->name;

		// $kaskeluar->validate();
		// var_dump($kaskeluar->errors); die;
		// var_dump($kaskeluar->attributes); die;

		if ($kaskeluar->validate()) return $kaskeluar->save();
		return false;
	}

	public function savePenarikan($kaskeluar, $post) {
		//var_dump($post); die;
		$ok = true;
		foreach ($post['simpanan'] as $id=>$item) {
			$penarikan = new PengambilansimpananT;
			$penarikan->attributes = $item;
			$penarikan->keanggotaan_id = $post['KeanggotaanV']['keanggotaan_id'];
			$penarikan->buktikaskeluar_id = $kaskeluar->bukitkaskeluar_id;
			$penarikan->tglpengambilan = $kaskeluar->tgl_bkk;
			$penarikan->nopengambilan = $penarikan->generatePenarikanSimpanan();
			$penarikan->keterangan_pengambilan = $kaskeluar->keterangan_bkk;
			$penarikan->ambil_diperiksaoleh_id = $kaskeluar->reviewedby;
			$penarikan->ambil_diperiksa_tgl = $kaskeluar->revieweddate;
			$penarikan->ambil_disetujuioleh_id = $kaskeluar->approvedby;
			$penarikan->ambil_disetujui_tgl = $kaskeluar->approveddate;
			$penarikan->biaya_materai_peng = $penarikan->biaya_administrasi_peng = 0;

			$penarikan->amb_create_time = date('Y-m-d H:i:s');
			$penarikan->amb_create_login = Yii::app()->user->name;

			// $penarikan->validate();
			// var_dump($penarikan->errors); die;
			// var_dump($penarikan->attributes); die;
			if ($penarikan->validate()) {
				$ok = $ok && $penarikan->save();
				$ok = $ok && SimpananT::model()->updateByPk($id, array(
					'pengambilansimpanan_id'=>$penarikan->pengambilansimpanan_id,
					'simp_update_time'=>date('Y-m-d H:i:s'),
					'simp_update_login'=>Yii::app()->user->name
				));
			} else $ok = false;
		}
		return $ok;
	}

	//===================================================================
	public function loadAngsuran($param, $direct=false) {
		$id = $param['id'];
		$simpanan = SimpananT::model()->findAllByAttributes(array('keanggotaan_id'=>$id), array('order'=>'tglsimpanan', 'condition'=>'pengambilansimpanan_id is null'));
		$angsuran = JmlangsuranT::model()->findAllByAttributes(array('keanggotaan_id'=>$id), array('condition'=>'isudahbayar = false','order'=>'tglangsuran'));

		$totSimpanan = 0;
		$totSisa = 0;
		foreach ($simpanan as $item) $totSimpanan += ($item->jumlahsimpanan + $item->jasa);
		foreach ($angsuran as $item) $totSisa += $item->sisa;


		$res = array(
			'simpanan'=>array(
				'tab'=>$this->renderPartial('subview/_tabSimpanan', array('simpanan'=>$simpanan), true),
				'total'=>$totSimpanan,
			),
			'angsuran'=>array(
				'tab'=>$this->renderPartial('subview/_tabAngsuran', array('angsuran'=>$angsuran), true),
				'total'=>$totSisa,
			),
			'print'=>CHtml::link('<i class="entypo-print"></i> Print Detail', $this->createUrl('printDetailSimpanPinjam', array('id'=>$id)), array('target'=>'_blank', 'class'=>'btn btn-blue')),
		);
		if ($direct) return $res;
		echo CJSON::encode($res);
	}

	public function getJasaSimpanan($simpanan) {
		$tglsimpan = new DateTime($simpanan->tglsimpanan);
		$tglsekarang = new DateTime(date('Y-m-d H:i:s'));
		$interval = $tglsimpan->diff($tglsekarang);

		$m = $interval->m + ($interval->y*12);
		if ($interval->d > 0 || $interval->h > 0 || $interval->i > 0) $m += 1;

		return $m;
	}
}
