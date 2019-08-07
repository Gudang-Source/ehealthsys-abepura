<?php

class PengajuanPemotonganController extends MyAuthController
{
	public $layout='//layouts/column1';
	// public $defaultAction = 'admin';
	//public $menuActive = array(3,3); // Default. Harap diubah sesuai menu aktif yang ada.
	public function actionIndex($no = null)
	{
		if (isset($_POST['ajax'])) {
			if (isset($_POST['param'])) call_user_func(array($this, $_POST['f']), $_POST['param']);
			else call_user_func(array($this, $_POST['f']));
			Yii::app()->end();
		}
		//$this->pageTitle = 'ecoopsys - Transaksi Pengajuan Pemotongan Pinjaman';
		$insert_notifikasi = new CustomFunction();
		$permintaan = new PengajuanpembayaranT;
		$permintaanv = new PengajuanangsuranV;

		$permintaan->tgldibuat_pengpemb = date('d/m/Y');
		$permintaan->tgldiperiksa_pengpemb = date('d/m/Y');
		$permintaan->tgldisetujui_pengpemb = date('d/m/Y');
		$permintaanv->tglAwal = date('01/m/Y');
		$permintaanv->tglAkhir = date('t/m/Y');

		$konfig = KonfigkoperasiK::model()->find('status_aktif = true');
		$permintaan->diperiksaoleh_id_pengpemb = $konfig->bendaharakoperasi_id;
		$permintaan->disetujuioleh_id_pengpemb = $konfig->pimpinankoperasi_id;
		$permintaan->dibuatoleh_id_pengpemb = Yii::app()->user->getState('pegawai_id');
		// login pemakai yang login belum beres... XP
		if (isset($_GET['PengajuanangsuranV'])) {
			$permintaanv->attributes = $_GET['PengajuanangsuranV'];
			if (!empty($_GET['PengajuanangsuranV']['tglAwal'])) $permintaanv->tglAwal = MyFormatter::formatDateForDb($_GET['PengajuanpembangsuranV']['tglAwal']);
			if (!empty($_GET['PengajuanangsuranV']['tglAkhir'])) $permintaanv->tglAkhir = MyFormatter::formatDateForDb($_GET['PengajuanpembangsuranV']['tglAkhir']);
		}


		if (isset($_POST['PengajuanpembayaranT'])) {

			$tot = 0;

			$gen = PengajuanpembayaranT::model()->generateNoPengajuan();
			//echo $gen; die;
			$trans = Yii::app()->db->beginTransaction();
			$ok = true;
			$id_link = array();
			foreach ($_POST['PengajuanpembayaranT']['angsuran'] as $idx=>$item) {
				$angsuran = JmlangsuranT::model()->findByPk($idx);
				if (!isset($item['check'])) continue;

				//var_dump($item); die;
			//	echo $item; die;


				$permintaan = new PengajuanpembayaranT;
				$permintaan->attributes = $item;

				$permintaan->jmlpotongan_sumber = str_replace(".","",$permintaan->jmlpotongan_sumber);
				$permintaan->simpananwajib = str_replace(".","",$item['simpananwajib']);
				$permintaan->simpanansukarela = str_replace(".","",$item['simpanansukarela']);

				$permintaan->jmlangsuran_id = $idx;
				$permintaan->tglpengajuanpemb = MyFormatter::formatDateForDb($_POST['PengajuanpembayaranT']['tgldibuat_pengpemb']);
				$permintaan->tglpembjthtempo = MyFormatter::formatDateForDb($_POST['PengajuanpembangsuranV']['tglAwal']);
				$permintaan->sampaidgntgljthtempo = MyFormatter::formatDateForDb($_POST['PengajuanpembangsuranV']['tglAkhir']);


				$permintaan->tgldibuat_pengpemb = MyFormatter::formatDateForDb($_POST['PengajuanpembayaranT']['tgldibuat_pengpemb']);
				if (!empty($_POST['PengajuanpembayaranT']['tgldiperiksa_pengpemb'])) $permintaan->tgldiperiksa_pengpemb = MyFormatter::formatDateForDb($_POST['PengajuanpembayaranT']['tgldiperiksa_pengpemb']);
				if (!empty($_POST['PengajuanpembayaranT']['tgldisetujui_pengpemb'])) $permintaan->tgldisetujui_pengpemb = MyFormatter::formatDateForDb($_POST['PengajuanpembayaranT']['tgldisetujui_pengpemb']);

				$permintaan->dibuatoleh_id_pengpemb = $_POST['PengajuanpembayaranT']['dibuatoleh_id_pengpemb'];
				if (!empty($_POST['PengajuanpembayaranT']['diperiksaoleh_id_pengpemb'])) $permintaan->diperiksaoleh_id_pengpemb = $_POST['PengajuanpembayaranT']['diperiksaoleh_id_pengpemb'];
				if (!empty($_POST['PengajuanpembayaranT']['disetujuioleh_id_pengpemb'])) $permintaan->disetujuioleh_id_pengpemb = $_POST['PengajuanpembayaranT']['disetujuioleh_id_pengpemb'];
				$permintaan->nopengajuan = $gen;

				$permintaan->pengjpot_create_time = date('Y-m-d H:i:s');
				$permintaan->pengjpot_create_login = Yii::app()->user->id;



				$permintaan->jmlpokok_pengangs = $angsuran->jmlpokok_angsuran;
				$permintaan->jmljasaangs_pengangs = $angsuran->jmljasa_angsuran;
				$permintaan->jmldendaangs_pengangs = 0; //$angsuran->jmldenda_angsuran;
				$permintaan->jmlpengajuan_pengangsuran = str_replace(".","",$item['jmlpengajuan_pengangsuran']); //$permintaan->simpananwajib + $permintaan->simpanansukarela + $_POST['mull']['angsuran'][$idx]['jmlsisa_angsuran'];

				$tot += $permintaan->jmlpengajuan_pengangsuran;

				//var_dump($permintaan->attributes); die;

				// sisa yang belum diajukan
				//var_dump($_POST['mull']['angsuran'][$idx]['jmlsisa_angsuran']); die;

				$permintaan->jmlsisapeng_pengangs =
				($_POST['mull']['angsuran'][$idx]['jmlsisa_angsuran'] + $permintaan->simpananwajib + $permintaan->simpanansukarela)
				- $permintaan->jmlpengajuan_pengangsuran;

				//var_dump($_POST['mull']['angsuran'][$idx]['jmlsisa_angsuran']); die;
				//var_dump($permintaan->jmlsisapeng_pengangs); die;
				//var_dump($_POST); die;
				//var_dump($permintaan->attributes); die;

				$ok = $ok && $permintaan->validate();
				$ok = $ok && $permintaan->save();
				$ok = $ok && $angsuran->cekSisaPengajuan();
			}
			//die;

			if ($ok) {


				$pengajuan = InfopengajuanpemotonganV::model()->findByAttributes(array('nopengajuan'=>$gen));
				//var_dump($pengajuan->attributes); die;
				//insert notifikasi
				$params['tglnotifikasi'] = date( 'Y-m-d H:i:s');
         	$params['create_time'] = date( 'Y-m-d H:i:s');
         	$params['create_loginpemakai_id'] = Yii::app()->user->id;
         	$params['isinotifikasi'] = $permintaan->nopengajuan . ', ' . MyFormatter::formatDateTimeId($permintaan->tglpengajuanpemb) . '<br/> Rp' . MyFormatter::formatNumberForPrint($tot) . ' - ' . $permintaan->potongansumber->namapotongan . '<br/> Dibuat Oleh : ' . Yii::app()->user->name;
         	$params['judulnotifikasi'] = 'Pengajuan Pemotongan';
				$params['link'] = "/pinjaman/pengajuanPemotongan/informasi&no=".$permintaan->nopengajuan;
         	$nofitikasi = $insert_notifikasi->insertNotifikasi($params);

				$trans->commit();

				$this->redirect(array('index', 'status'=>1, 'no'=>$gen));
			} else {
				$trans->rollback();
				$this->redirect(array('index', 'status'=>0));
			}
		}

		$this->render('index', array('permintaan' => $permintaan, 'permintaanv' => $permintaanv, 'no'=>$no));
	}

	public function actionInformasi($no = null)
	{
                //CustomFunction::runAjaxF($this, $_POST);
		
		$pengajuanPemotongan = new KOInfopengajuanpemotonganV;
		//$pengajuanPemotongan->nopengajuan = $no;

		$pengajuanPemotongan->tgl_awal = date('Y-m-d');
		$pengajuanPemotongan->tgl_akhir = date('Y-m-d');

		if (isset($_GET['KOInfopengajuanpemotonganV'])) {
			$pengajuanPemotongan->attributes = $_GET['KOInfopengajuanpemotonganV'];			
                        $pengajuanPemotongan->tgl_awal = MyFormatter::formatDateTimeForDb($_GET['KOInfopengajuanpemotonganV']['tgl_awal']);
                        $pengajuanPemotongan->tgl_akhir = MyFormatter::formatDateTimeForDb($_GET['KOInfopengajuanpemotonganV']['tgl_akhir']);
			//$pengajuanPemotongan->nopengajuan = $_GET['InfopengajuanpemotonganV']['nopengajuan'];

			//var_dump($pengajuanPemotongan->attributes); die;
		}

		$this->render('informasi',array('pengajuanPemotongan'=>$pengajuanPemotongan));
	}

	public function actionPrint($no)
	{
		$this->layout = '//layouts/print';
		$this->pageTitle = 'ecoopsys - Print Pengajuan Pemotongan';
		$model = PengajuanpotongananggotaV::model()->findAllByAttributes(array('nopengajuan'=>$no),array('order'=>'nama_pegawai asc'));
		$profil = ProfilS::model()->find();
		$this->render('print',array('profil'=>$profil,'model'=>$model));
	}

	public function actionPrintInformasi() {
		$this->layout = '//layouts/print';
		$this->pageTitle = 'ecoopsys - Print Informasi Pengajuan Pemotongan';
		$pengajuanPemotongan = new InfopengajuanpemotonganV;
		$profil = ProfilS::model()->find();
		if (isset($_GET['InfopengajuanpemotonganV'])) {
			$pengajuanPemotongan->attributes = $_GET['InfopengajuanpemotonganV'];
			if (!empty($_GET['InfopengajuanpemotonganV']['tglAwal'])) $pengajuanPemotongan->tglAwal = MyFormatter::formatDateForDb(($_GET['InfopengajuanpemotonganV']['tglAwal']));
			if (!empty($_GET['InfopengajuanpemotonganV']['tglAkhir'])) $pengajuanPemotongan->tglAkhir = MyFormatter::formatDateForDb(($_GET['InfopengajuanpemotonganV']['tglAkhir']));
			$pengajuanPemotongan->nopengajuan = $_GET['InfopengajuanpemotonganV']['nopengajuan'];

			//var_dump($pengajuanPemotongan->attributes); die;
		}

		$this->render('printInformasi',array('pengajuanPemotongan'=>$pengajuanPemotongan, 'profil'=>$profil));
	}

	protected function loadInformasi($param) {
		$pinjaman = PinjamanT::model()->findByAttributes(array('no_pinjaman'=>$param['id']));
		$anggota = KeanggotaanT::model()->findByPk($pinjaman->keanggotaan_id);
		$pegawai = PegawaiM::model()->findByPk($anggota->pegawai_id);
		$sisaPinjaman = InfopinjamananggotaV::model()->findByAttributes(array('pegawai_id'=>$anggota->pegawai_id,'no_pinjaman'=>$param['id']));
		//var_dump($sisaPinjaman); die;
		$res = array();
		$res['nama'] = $pegawai->nama_pegawai;
		$res['nokeanggotaan'] = $anggota->nokeanggotaan;
		$res['namaunit'] = $pegawai->unit->namaunit;
		$res['golonganpegawai_nama'] = $pegawai->golonganpegawai->golonganpegawai_nama;
		$res['tglpinjaman'] = date('d/m/Y', strtotime($pinjaman->tglpinjaman));
		$res['jml_pinjaman'] = MyFormatter::formatNumberForPrint($pinjaman->jml_pinjaman);
		$res['jasapinjaman'] = MyFormatter::formatNumberForPrint($sisaPinjaman->jasapinjaman);

		echo CJSON::encode($res);
	}

	public function gantiSumber($param) {
		$criteria = new CDbCriteria;
		$criteria->compare('lower(nopengajuan)', strtolower($param['id']));
		PengajuanpembayaranT::model()->updateAll(array('potongansumber_id'=>$param['val']), $criteria);
	}
}
