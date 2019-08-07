<?php

class PenangguhanAngsuranController extends MyAuthController
{
	public $layout='//layouts/column1';
	// public $defaultAction = 'admin';
	//public $menuActive = array(5,7); // Default. Harap diubah sesuai menu aktif yang ada.
	public function actionIndex($id = null, $idTanggungan = null)
	{
		$penangguhan = new PermohonanpenangguhanT;
		$pengajuan = PengajuanpembayaranT::model()->findByPk($id);
		$kaskeluar = new BukitkaskeluarT;
		$pembayaranan = PembayaranangsuranT::model()->findByAttributes(array('pengajuanpembayaran_id'=>$id));

		$konfig = KonfigurasikoperasiK::model()->find('isberlaku = true');
		$kaskeluar->preparedby = Yii::app()->user->getState('pegawai_id');
		$kaskeluar->reviewedby = $konfig->bendahara_id;
		$kaskeluar->approvedby = $konfig->pimpiankoperasi_id;
		$kaskeluar->prepareddate = $kaskeluar->revieweddate = $kaskeluar->approveddate = date('d/m/Y');

		if (!empty($idTanggungan)) {
			$penangguhan = PermohonanpenangguhanT::model()->findByPk($idTanggungan);
			$pengajuan = PengajuanpembayaranT::model()->findByPk($penangguhan->pengajuanpembayaran_id);
			//$kaskeluar = BukitkaskeluarT::model()->findByPk($penangguhan->buktikaskeluar_id);
			$kaskeluar->reviewedby = $penangguhan->pen_diperiksaoleh;
			$kaskeluar->approvedby = $penangguhan->pen_disetujuioleh;
			$kaskeluar->revieweddate = date("d/m/Y", strtotime($penangguhan->pen_tgldiperiksa));
			$kaskeluar->approveddate = date("d/m/Y", strtotime($penangguhan->pen_tgldisetujui));
			$pembayaranan = PembayaranangsuranT::model()->findByAttributes(array('pengajuanpembayaran_id'=>$pengajuan->pengajuanpembayaran_id));
		}


		$anggota = KeanggotaanV::model()->findByAttributes(array('keanggotaan_id'=>$pengajuan->keanggotaan_id));
		$pegawai = PegawaiM::model()->findByPk($anggota->pegawai_id);
		$angsuran = JmlangsuranT::model()->findByPk($pengajuan->jmlangsuran_id);
		$pinjaman = PinjamanT::model()->findByPk($angsuran->pinjaman_id);


		/*
		$total = 0;
		foreach ($pembayaranan as $item) {
			$total += $item->jmlbayar_pembangsuran;
		}*/

		$anggota->umur = Params::getUmur($anggota->tgl_lahirpegawai)." Tahun";
		$anggota->tgl_lahirpegawai = date("d/m/Y", strtotime($anggota->tgl_lahirpegawai));
		if (!empty($pegawai->golonganpegawai_id)) $anggota->golonganpegawai_id = $pegawai->golonganpegawai->golonganpegawai_nama;
		if (!empty($anggota->photopegawai)) $anggota->photopegawai = Params::urlPegawaiGambar().$anggota->photopegawai;

		$penangguhan->tglpermpenangguhan = date('d/m/Y');
		$penangguhan->jumlahpinjaman = MyFormatter::formatNumberForPrint($angsuran->jmlpokok_angsuran + $angsuran->jmljasa_angsuran);
		$penangguhan->kesanggupanbayar = $penangguhan->jumlahpinjaman;

		$pinjaman->tglpinjaman = date('d/m/Y', strtotime($pinjaman->tglpinjaman));

		//var_dump($_POST); die;
		if (isset($_POST['PermohonanpenangguhanT'])) {
			$trans = Yii::app()->db->beginTransaction();
			$ok = true;

			//$ok = $ok && $this->saveBKK($kaskeluar, $_POST);
			$ok = $ok && $this->savePenangguhan($penangguhan, $_POST);
			//$ok = $ok && $this->updateAngsuran($penangguhan);
			//var_dump($ok); die;
			if ($ok) {
				$trans->commit();
				$this->redirect(array('index', 'status'=>1, 'idTanggungan'=>$penangguhan->permohonanpenangguhan_id));
			}
			//var_dump($ok); die;
			//die;
		}

		$this->render('index', array(
			'penangguhan'=>$penangguhan,
			'pengajuan'=>$pengajuan,
			'anggota'=>$anggota,
			'angsuran'=>$angsuran,
			'pembayaranan'=>$pembayaranan,
			'pinjaman'=>$pinjaman,
			'kaskeluar'=>$kaskeluar,
			'id'=>$id,
		));
	}

	public function actionInformasi() {
		$penangguhan = new KOInfomohonpenangguhanV;
		$penangguhan->tgl_awal = date('Y-m-d');
		$penangguhan->tgl_akhir = date('Y-m-d');
		if (isset($_GET['KOInfomohonpenangguhanV'])) {
			$penangguhan->attributes = $_GET['KOInfomohonpenangguhanV'];
			$penangguhan->tgl_awal = MyFormatter::formatDateTimeForDb($_GET['KOInfomohonpenangguhanV']['tgl_awal']);
                        $penangguhan->tgl_akhir = MyFormatter::formatDateTimeForDb($_GET['KOInfomohonpenangguhanV']['tgl_akhir']);
		}
		$this->render('informasi', array('penangguhan'=>$penangguhan));
	}

	public function actionPrintInformasi() {
		$this->layout = '//layouts/print';
		$penangguhan = new InfopermohonanpenangguhanV;
		$profil = ProfilS::model()->find();
		$periode = null;
		if (isset($_GET['InfopermohonanpenangguhanV'])) {
			$penangguhan->attributes = $_GET['InfopermohonanpenangguhanV'];
			if (isset($_GET['InfopermohonanpenangguhanV']['tglAwal']) && isset($_GET['InfopermohonanpenangguhanV']['tglAkhir'])) {
				$penangguhan->tglAwal = MyFormatter::formatDateForDb($_GET['InfopermohonanpenangguhanV']['tglAwal']);
				$penangguhan->tglAkhir = MyFormatter::formatDateForDb($_GET['InfopermohonanpenangguhanV']['tglAkhir']);

				$periode = MyFormatter::formatDateTimeId($penangguhan->tglAwal)." - ".MyFormatter::formatDateTimeId($penangguhan->tglAkhir);
			}
		}
		$this->render('printInformasi', array('penangguhan'=>$penangguhan, 'periode'=>$periode, 'profil'=>$profil));
	}

	public function actionPrint($id)
	{
		$penangguhan = PermohonanpenangguhanT::model()->findByPk($id);
		$pengajuan = PengajuanpembayaranT::model()->findByPk($penangguhan->pengajuanpembayaran_id);
		$anggota = KeanggotaanV::model()->findByAttributes(array('keanggotaan_id'=>$penangguhan->keanggotaan_id));
		$pegawai = PegawaiM::model()->findByPk($anggota->pegawai_id);
		$angsuran = JmlangsuranT::model()->findByPk($pengajuan->jmlangsuran_id);
		$pinjaman = PinjamanT::model()->findByPk($angsuran->pinjaman_id);
		$profil = ProfilS::model()->find();
		$this->layout = '//layouts/print';
		$this->render('print', array('penangguhan'=>$penangguhan, 'anggota'=>$anggota, 'pinjaman'=>$pinjaman, 'profil'=>$profil));
	}

	protected function updateAngsuran($penangguhan) {
		$pengajuan = PengajuanpembayaranT::model()->findByPk($penangguhan->pengajuanpembayaran_id);

		return JmlangsuranT::model()->updateByPk($pengajuan->jmlangsuran_id, array('isudahbayar'=>false));
	}

	protected function savePenangguhan(&$penangguhan, $post) {
		// var_dump($post); die;
		$num = array('jumlahpinjaman', 'kesanggupanbayar', 'sisapinjaman');
		$penangguhan->attributes = $post['PermohonanpenangguhanT'];
		$penangguhan->tglpermpenangguhan = MyFormatter::formatDateForDb($penangguhan->tglpermpenangguhan);
		$penangguhan->pen_diperiksaoleh = $post['BukitkaskeluarT']['reviewedby'];
		$penangguhan->pen_tgldiperiksa = MyFormatter::formatDateForDb($post['BukitkaskeluarT']['revieweddate']);
		$penangguhan->pen_disetujuioleh = $post['BukitkaskeluarT']['approvedby'];
		$penangguhan->pen_tgldisetujui = MyFormatter::formatDateForDb($post['BukitkaskeluarT']['approveddate']);
		//$penangguhan->buktikaskeluar_id = $kaskeluar->bukitkaskeluar_id;
		//$penangguhan->pen_diperiksaoleh = $kaskeluar->reviewedby;
		//$penangguhan->pen_tgldiperiksa = $kaskeluar->revieweddate;
		//$penangguhan->pen_disetujuioleh = $kaskeluar->approvedby;
		//$penangguhan->pen_tgldisetujui = $kaskeluar->approveddate;
		$penangguhan->pen_create_time = date("Y-m-d H:i:s");
		$penangguhan->pen_create_login = Yii::app()->user->name;

		foreach ($num as $item) $penangguhan[$item] = str_replace(".", "", $penangguhan[$item]);

		//var_dump($penangguhan->attributes); die;

		if ($penangguhan->validate()) return $penangguhan->save();
		return false;


	}
	/*
	protected function saveBKK(&$kaskeluar, $post) {
		$pegawai = PegawaiM::model()->findByPk($post['PermohonanpenangguhanT']['pegawai_id']);
		$kaskeluar->attributes = $post['BukitkaskeluarT'];

		$kaskeluar->prepareddate = MyFormatter::formatDateTimeForDb($kaskeluar->prepareddate);
		$kaskeluar->revieweddate = MyFormatter::formatDateTimeForDb($kaskeluar->revieweddate);
		$kaskeluar->approveddate = MyFormatter::formatDateTimeForDb($kaskeluar->approveddate);

		$kaskeluar->tgl_bkk = MyFormatter::formatDateForDb($post['PermohonanpenangguhanT']['tglpermpenangguhan']);
		$kaskeluar->no_bkk = $kaskeluar->generateNoBKK();
		$kaskeluar->jenistransaksi_id = 2;
		$kaskeluar->namapenerima = $pegawai->nama_pegawai;
		$kaskeluar->alamatpenerima = $pegawai->alamat_pegawai;
		$kaskeluar->untuk_pengeluaran = "Penangguhan Potongan Angsuran";
		$kaskeluar->jmlkaskeluar = str_replace(".", "", $post['PermohonanpenangguhanT']['sisapinjaman']);
		$kaskeluar->keterangan_bkk = $post['PermohonanpenangguhanT']['ketpenangguhan'];
		$kaskeluar->bkk_create_time = date("Y-m-d H:i:s");
		$kaskeluar->bkk_create_login = Yii::app()->user->name;

		if ($kaskeluar->validate()) return $kaskeluar->save();
		return false;

		//var_dump($kaskeluar->errors); die;
		//die;
	} */
}
