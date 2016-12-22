<?php

class PenerimaanPengajuanController extends MyAuthController
{
	public $layout='//layouts/column1';
	// public $defaultAction = 'admin';
	//public $menuActive = array(3,4); // Default. Harap diubah sesuai menu aktif yang ada.

	public function actionIndex($no = null, $bkm = null)
	{

		$insert_notifikasi = new CustomFunction();
		$konfig = KonfigkoperasiK::model()->find('status_aktif = true');
		$permintaanv = new PenerimaanangsuranV;
		$angsuran = new PembayaranangsuranT;
		$kasmasuk = new BuktikasmasukkopT;
	//	$this->pageTitle = 'ecoopsys - Transaksi Penerimaan Pengajuan Pemotongan';
		$kasmasuk->tglbuktibayar = date('d/m/Y H:i');
		$kasmasuk->nobuktimasuk = $kasmasuk->generateNoBukti();

		$kasmasuk->preparedby = Yii::app()->user->getState('pegawai_id');
		$kasmasuk->reviewedby = $konfig->bendaharakoperasi_id;
		$kasmasuk->approvedby = $konfig->pimpinankoperasi_id;
		$kasmasuk->carapembayaran = "TABUNGAN";

		$kasmasuk->prepareddate = $kasmasuk->revieweddate = $kasmasuk->approveddate = date('d/m/Y H:i');

		/*
		if (!empty($no)) {
			$pengajuan = PengajuanpembayaranT::model()->findByAttributes(array('nopengajuan'=>$no));
			$permintaanv->nopengajuan = $no;
			$permintaanv->potongansumber_id = $pengajuan->potongansumber_id;
		}*/

		if (isset($_GET['PengajuanpenerimaanangsuranV'])) {
			$permintaanv->attributes = $_GET['PengajuanpenerimaanangsuranV'];
			//if (isset($_GET['PengajuanpenerimaanangsuranV']['tglAwal']) && $_GET['PengajuanpenerimaanangsuranV']['tglAkhir']) {
			$permintaanv->nopengajuan =$_GET['PengajuanpenerimaanangsuranV']['nopengajuan'];
				//$permintaanv->tglAwal = MyFormatter::formatDateForDb($_GET['PengajuanpenerimaanangsuranV']['tglAwal']);
				//$permintaanv->tglAkhir = MyFormatter::formatDateForDb($_GET['PengajuanpenerimaanangsuranV']['tglAkhir']);
			//}
		}

		if (isset($_POST['BuktikasmasukT'])) {
			$trans = Yii::app()->db->beginTransaction();
			$ok = true;
			// var_dump($_POST); die;
			$ok = $ok && $this->saveBKM($kasmasuk, $_POST);
			$ok = $ok && $this->saveAngsuran($_POST, $kasmasuk); // var_dump($ok); die;
			$ok = $ok && $this->saveSimpanan($_POST, $kasmasuk); //var_dump($ok); die;

			//insert notifikasi
			$params['tglnotifikasi'] = date( 'Y-m-d H:i:s');
         $params['create_time'] = date( 'Y-m-d H:i:s');
         $params['create_loginpemakai_id'] = Yii::app()->user->id;
         $params['isinotifikasi'] = $kasmasuk->nobuktimasuk . ', ' . MyFormatter::formatDateTimeId($kasmasuk->tglbuktibayar) . ', Rp' . MyFormatter::formatNumberForPrint($kasmasuk->uangditerima - $kasmasuk->uangkembalian) . '<br/> Dibuat Oleh : ' . Yii::app()->user->name;
         $params['judulnotifikasi'] = 'Penerimaan Pengajuan';
         $params['link'] = "/pinjaman/penerimaanPengajuan/informasi&bkm=".$kasmasuk->nobuktimasuk;
         $nofitikasi = $insert_notifikasi->insertNotifikasi($params);

			if ($ok) {
				$trans->commit();
				$this->redirect(array('index', 'status'=>1, 'bkm'=>$kasmasuk->buktikasmasuk_id));
			} else {
				$trans->rollback();
				$this->redirect(array('index', 'status'=>0));
			}
			//var_dump($kasmasuk->attributes); die;

			//var_dump($_POST); die;
		}

		if (!empty($bkm)) {
			$kasmasuk = BuktikasmasukT::model()->findByPk($bkm);
		}

		$this->render('index', array('permintaanv'=>$permintaanv, 'angsuran'=>$angsuran, 'kasmasuk'=>$kasmasuk));
	}

	public function actionInformasi($bkm=null)
	{
		
		$penerimaanPemotongan = new KOInfopenerimaanpotonganV;
		//$penerimaanPemotongan->nobuktimasuk = $bkm;
		$penerimaanPemotongan->tgl_awal = date('Y-m-d');
		$penerimaanPemotongan->tgl_akhir = date('Y-m-d');
		if (isset($_GET['KOInfopenerimaanpotonganV'])) {
			$penerimaanPemotongan->attributes = $_GET['KOInfopenerimaanpotonganV'];
			$penerimaanPemotongan->tgl_awal = MyFormatter::formatDateTimeForDb($_GET['KOInfopenerimaanpotonganV']['tgl_awal']);
                        $penerimaanPemotongan->tgl_akhir = MyFormatter::formatDateTimeForDb($_GET['KOInfopenerimaanpotonganV']['tgl_akhir']);
			//$penerimaanPemotongan->nobuktimasuk = $_GET['InfopenerimaanpemotonganV']['nobuktimasuk'];
		}
                
		//$periode = MyFormatter::formatDateTimeId($penerimaanPemotongan->tglAwal).' s/d '.MyFormatter::formatDateTimeId($penerimaanPemotongan->tglAkhir);
		$this->render('informasi',array('penerimaanPemotongan'=>$penerimaanPemotongan));
                
	}

	public function actionPrint($id=null)
	{
		$this->layout = '//layouts/print';
		$model= KOInfopenerimaanpotonganV::model()->findAllByAttributes(array('buktikasmasuk_id'=>$id));
		$profil = ProfilS::model()->find();

		$content = array(
			'total' => 0,
			'data' => array(),
		);

		$tot = 0;
		foreach ($model as $idx=>$item) {
			$tot += $item->jmlbayar_pembangsuran;
			$header = array(
				'tglbuktibayar' => $item->tglbuktibayar,
				'tglpengajuanpemb' => $item->tglpengajuanpemb,
				'nobuktimasuk' => $item->nobuktimasuk,
				'nopengajuan' => $item->nopengajuan,
				'namapotongan' => $item->namapotongan,
				'jmlbayar_pembangsuran' => $tot,
			);
		}

		$model = new KOInfopenerimaanpotonganV;
		$model->buktikasmasuk_id = $id;

		$this->render('print', array(
			'model'=>$model,
			'profil'=>$profil,
			'header'=>$header,
			'content'=>$content,
			//'bkm'=>$kasmasuk,
		));
	}

	public function actionPrintInformasi() {
		$this->layout = '//layouts/print';
		$this->pageTitle = 'ecoopsys - Print Informasi Pengajuan Pemotongan';
		$penerimaanPemotongan = new KOInfopenerimaanpotonganV;
		$profil = ProfilS::model()->find();

		if (isset($_GET['InfopenerimaanpemotonganV'])) {
			$penerimaanPemotongan->attributes = $_GET['InfopenerimaanpemotonganV'];
			if (!empty($_GET['InfopenerimaanpemotonganV']['tglAwal'])) $penerimaanPemotongan->tglAwal = MyFormatter::formatDateForDB(($_GET['InfopenerimaanpemotonganV']['tglAwal']));
			if (!empty($_GET['InfopenerimaanpemotonganV']['tglAkhir'])) $penerimaanPemotongan->tglAkhir = MyFormatter::formatDateForDB(($_GET['InfopenerimaanpemotonganV']['tglAkhir']));
			//$penerimaanPemotongan->nobuktimasuk = $_GET['InfopenerimaanpemotonganV']['nobuktimasuk'];
		}
		$periode = null;
		if (!empty($penerimaanPemotongan->tglAwal) && !empty($penerimaanPemotongan->tglAkhir))
		{
			$periode = MyFormatter::formatDateTimeId($penerimaanPemotongan->tglAwal).' s/d '.MyFormatter::formatDateTimeId($penerimaanPemotongan->tglAkhir);
		}

		$this->render('printInformasi',array(
							'penerimaanPemotongan'=>$penerimaanPemotongan,
							'profil'=>$profil,
							'periode'=>$periode
							));
	}



	public function actionPenangguhan($id=null) {
		$penangguhan = new PermohonanpenangguhanT;
		$anggota = new KeanggotaanV;
		echo "Kick";
		die;
		$this->render('penangguhan');
	}

	// ===========================================================================================================================

	/**
	 * Menginput dan menyimpan bukti kas masuk. Untuk penerimaan pemotongan, default dari data sebagaipembayaran_bkm adalah 'Penerimaan
	 * Potongan dari Pengajuan'. Jumlah bayar kartu dan materai di-nolkan. Jika sumber potongannya baik gaji (1) maupun insentif (2)
	 * maka diterima dari dan alamat disesuaikan dengan sumber potongan tersebut, jika tidak maka di-stripkan (-).
	 *
	 * @param kasmasuk Model yang akan diinput (By Reference)
	 * @param post Data $_POST (menitikberatkan data BuktikasmasukT)
	 * @return boolean: Jika sukses dalam penyimpanannya maka hasilnya adalah true, false jika sebaliknya.
	**/
	public function saveBKM(&$kasmasuk, $post) {
		//var_dump($post); die;

		$darinama = array(
			1=>array(
				'darinama_bkm'=>'Bank Jabar',
				'alamat_bkm'=>'RSUD Karawang',
			),
			2=>array(
				'darinama_bkm'=>'Keuangan RS',
				'alamat_bkm'=>'RSUD Karawang',
			),
		);

		$kasmasuk->attributes = $post['BuktikasmasukT'];
		$kasmasuk->jenistransaksi_id = 14; //default = Potongan
		$kasmasuk->tglbuktibayar = MyFormatter::formatDateTimeForDb($kasmasuk->tglbuktibayar.":00");
		$kasmasuk->jmlpembayaran = str_replace(".", "", $kasmasuk->jmlpembayaran);
		$kasmasuk->biayaadministrasi = str_replace(".", "", $kasmasuk->biayaadministrasi);
		$kasmasuk->uangditerima = str_replace(".", "", $kasmasuk->uangditerima);
		$kasmasuk->uangkembalian = str_replace(".", "", $kasmasuk->uangkembalian);
		$kasmasuk->biayamaterai = 0;
		$kasmasuk->keterangan_pembayaran = $post['BuktikasmasukT']['keterangan_pembayaran'];

		$kasmasuk->prepareddate = (empty($kasmasuk->prepareddate))?null:MyFormatter::formatDateTimeForDb($kasmasuk->prepareddate.":00");
		$kasmasuk->revieweddate = (empty($kasmasuk->revieweddate))?null:MyFormatter::formatDateTimeForDb($kasmasuk->revieweddate.":00");
		$kasmasuk->approveddate = (empty($kasmasuk->approveddate))?null:MyFormatter::formatDateTimeForDb($kasmasuk->approveddate.":00");

		$kasmasuk->create_time = date('Y-m-d H:i:s');
		$kasmasuk->create_login = Yii::app()->user->name;

		$kasmasuk->darinama_bkm = $kasmasuk->alamat_bkm = '-';
		$kasmasuk->sebagaipembayaran_bkm = 'Penerimaan Potongan dari Pengajuan';
		$kasmasuk->jenistransaksi_id = 1;
		$kasmasuk->jmlbayarkartu = 0;


		$idSumber = $post['PengajuanpenerimaanangsuranV']['potongansumber_id'];
		if (in_array($idSumber, array(1,2))) {
			$kasmasuk->darinama_bkm = $darinama[$idSumber]['darinama_bkm'];
			$kasmasuk->alamat_bkm = $darinama[$idSumber]['alamat_bkm'];
		}

		//var_dump($kasmasuk->attributes); die;

		//var_dump($kasmasuk->validate()); die;

		if ($kasmasuk->validate()) return $kasmasuk->save();
		return false;

		//var_dump($kasmasuk->attributes); die;
	}

	public function saveAngsuran($post, $kasmasuk) {
		$ok = true;
		//var_dump($_POST); die;
		foreach ($post['PembayaranangsuranT'] as $idx=>$item) {
			//var_dump($item);

			if (!isset($item['check'])) continue;
			if ($item['check'] != 1) continue;

			$angsuran = JmlangsuranT::model()->findByPk($idx);
			$wajib = $_POST['SimpananT'][2][$angsuran->keanggotaan_id][$idx];
			$sukarela = $_POST['SimpananT'][3][$angsuran->keanggotaan_id][$idx];
			$dibayar = str_replace(".", "", $item['sub_total']);
			$denda = str_replace(".", "", $item['jmldenda_byrangsuran']);

			$bayarBersih = $dibayar - ($wajib + $sukarela + $denda);

			//echo $bayarBersih; die;

			// var_dump($item); die;
			$bayar = new PembayaranangsuranT;
			$bayar->attributes = $item;
			$bayar->jmlpokok_byrangsuran = $item['jmlpokok_byangsuran'];
			$bayar->jmljasa_byrangsuran = $item['jmljasa_byangsuran'];
			$bayar->jmldenda_byrangsuran = $item['jmldenda_byrangsuran'];
			$bayar->buktikasmasuk_id = $kasmasuk->buktikasmasuk_id;
			$bayar->jmlangsuran_id = $idx;
			$bayar->pengajuanpembayaran_id = $item['pengajuanpembayaran_id'];
			$bayar->potongansumber_id = $post['PengajuanpenerimaanangsuranV']['potongansumber_id'];
			$bayar->tglpembayaranangsuran = date('Y-m-d', strtotime($kasmasuk->tglbuktibayar));
			$bayar->byrangsuranke = $item['byangsuranke'];
			$bayar->lamahari_sdhjthtempo = 0;
			$bayar->pembangs_create_time = date('Y-m-d H:i:s');
			$bayar->pembangs_create_login = Yii::app()->user->id;
			$bayar->jmlbayar_pembangsuran = $bayarBersih;
			$bayar->jmlsisa_pembangsuran = $angsuran->sisa - ($bayarBersih);

			//var_dump($bayar->attributes); die;

			if($bayar->validate()) $ok = $ok && $bayar->save();
			else $ok = false;

			if ($bayar->jmlsisa_pembangsuran == 0) $ok = $ok && JmlangsuranT::model()->updateByPk($idx, array('isudahbayar'=>true));
			//else
			//if ($item['jml_bayar'] != $bayarBersih) $ok = $ok && JmlangsuranT::model()->updateByPk($idx, array('isdiajukanjmlangsuran'=>false));
			//var_dump($ok); die;
			//var_dump($bayar->errors); die;

			//var_dump($bayar->attributes); die;


		}
		//echo "Kick"; die;

		return $ok;
	}

	public function saveSimpanan($post, $kasmasuk) {
		$ok = true;
		foreach ($post['SimpananT'] as $jenis_id => $item) {
			//var_dump($post['SimpananT']); die;
			$master = JenissimpananM::model()->findByPk($jenis_id);
			//var_dump($master->attributes); die;
			foreach ($item as $anggota_id => $item2) {
				$jml = 0;
				foreach ($item2 as $ans_id=>$ans) {
					if (isset($post['PembayaranangsuranT'][$ans_id]['check']) && $post['PembayaranangsuranT'][$ans_id]['check'] == 1) $jml += $ans;
				}
				if ($jml == 0) continue;

				$jenis = JenissimpananM::model()->findByPk(jenis_id);

				$simpanan = new SimpananT;
				$simpanan->jumlahsimpanan = $jml;
				$simpanan->keanggotaan_id = $anggota_id;
				$simpanan->jenissimpanan_id = $jenis_id;
				$simpanan->buktikasmasuk_id = $kasmasuk->buktikasmasuk_id;
				$simpanan->persenjasa_thn = $jenis->persenjasathn;
				$simpanan->nosimpanan = $simpanan->generateNoSimpanan($master->jenissimpanan_singkatan);
				$simpanan->tglsimpanan = $kasmasuk->tglbuktibayar;
				$simpanan->satuan = '-';
				$simpanan->keterangansimpanan = 'Bagian dari penerimaan potongan anggota.';
				$simpanan->persenjasa_thn = 0;
				$simpanan->persenpajak_thn = 0;

				//if ($simpanan->jenissimpanan_id == 3) {
				$simpanan->persenjasa_thn = JenissimpananM::model()->findByPk($simpanan->jenissimpanan_id)->persenjasathn;
				//}

				$simpanan->simp_create_time = date('Y-m-d H:i:s');
				$simpanan->simp_create_login = Yii::app()->user->name;
				if ($simpanan->validate()) $ok = $ok && $simpanan->save();
				else $ok = false;
				//var_dump($simpanan->errors); die;
			}
		}

		return $ok;
	}

}
