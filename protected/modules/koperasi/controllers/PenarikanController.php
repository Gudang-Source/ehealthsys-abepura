<?php

class PenarikanController extends MyAuthController
{
	public $layout='//layouts/column1';
	// public $defaultAction = 'admin';
	//public $menuActive = array(4,3);

	//private $dateUp = array('tgl_bkk','prepareddate','revieweddate','approveddate');

	public function actionIndex($id = null, $simpanan = null)
	{
                CustomFunction::runAjaxF($this, $_POST);

		$konfig = KonfigkoperasiK::model()->find(array('order'=>'konfigkoperasi_id asc', 'condition'=>'status_aktif = true'));

		$anggota = new KeanggotaanV;
		$penarikan = new PengambilansimpananT;
		$kaskeluar = new BuktikaskeluarkopT;

		$kaskeluar->preparedby = Yii::app()->user->getState('pegawai_id');
		$kaskeluar->reviewedby = $konfig->penguruskoperasi_id;
		$kaskeluar->approvedby = $konfig->pimpinankoperasi_id;
		$kaskeluar->prepareddate = $kaskeluar->revieweddate = $kaskeluar->approveddate = date('d/m/Y H:i');

		$sp = null;

		if (isset($_POST['PengambilansimpananT'])) {
			$trans = Yii::app()->db->beginTransaction();
			$ok = true;

			$ok = $ok && $this->saveBKK($kaskeluar, $_POST);
			$ok = $ok && $this->savePenarikan($penarikan, $kaskeluar, $_POST);
			$ok = $ok && SimpananT::model()->updateByPk($_POST['no_simpanan'], array('pengambilansimpanan_id' => $penarikan->pengambilansimpanan_id));

			if ($ok) {
				$trans->commit();
                                Yii::app()->user->setFlash("success", "Transaksi Penarikan Simpanan berhasil Di Simpan");
				$this->redirect(array('index', 'status'=>1, 'id'=>$penarikan->pengambilansimpanan_id));
			} else {
				$trans->rollback();
                                Yii::app()->user->setFlash("error", "Transaksi Penarikan Simpanan gagal Di Simpan");
				$this->redirect(array('index', 'status'=>0));
			}

			//var_dump($ok); die;
		}

		if (!empty($id)) {
			$penarikan = PengambilansimpananT::model()->findByPk($id);
			$kaskeluar = BukitkaskeluarT::model()->findByPk($penarikan->buktikaskeluar_id);
			$anggota = KeanggotaanV::model()->findByAttributes(array('keanggotaan_id' => $penarikan->keanggotaan_id));
			$anggota->umur = Params::getUmur($anggota->tgl_lahirpegawai)." Tahun";
			$anggota->unit_id = empty($anggota->unit_id)?'':UnitM::model()->findByPk($anggota->unit_id)->namaunit;
			$anggota->golonganpegawai_id = empty($anggota->golonganpegawai_id)?'':GolonganpegawaiM::model()->findByPk($anggota->golonganpegawai_id)->golonganpegawai_nama;

			$penarikan->jml_pokok_pengambilan = MyFormatter::formatNumberForPrint($penarikan->jml_pokok_pengambilan);
			$penarikan->jml_jasa_pengambilan = MyFormatter::formatNumberForPrint($penarikan->jml_jasa_pengambilan);
			$penarikan->jml_pengambilan = MyFormatter::formatNumberForPrint($penarikan->jml_pengambilan);

			$kaskeluar->prepareddate = date('d/m/Y H:i', strtotime($kaskeluar->prepareddate));
			$kaskeluar->revieweddate = date('d/m/Y H:i', strtotime($kaskeluar->revieweddate));
			$kaskeluar->approveddate = date('d/m/Y H:i', strtotime($kaskeluar->approveddate));
			$kaskeluar->tgl_bkk = date('d/m/Y H:i', strtotime($kaskeluar->tgl_bkk));

			$kaskeluar->biayaadministrasi = MyFormatter::formatNumberForPrint($kaskeluar->biayaadministrasi);
			$kaskeluar->biayaamaterai = MyFormatter::formatNumberForPrint($kaskeluar->biayaamaterai);
			$kaskeluar->jmlkaskeluar = MyFormatter::formatNumberForPrint($kaskeluar->jmlkaskeluar);
		}

		if (!empty($simpanan)) {
			$sp = SimpananT::model()->findByPk($simpanan);

			$penarikan->keanggotaan_id = $sp->keanggotaan_id;

			//var_dump($penarikan->attributes); die;

			$anggota = KeanggotaanV::model()->findByAttributes(array('keanggotaan_id'=>$sp->keanggotaan_id));
			$anggota->umur = Params::getUmur($anggota->tgl_lahirpegawai)." Tahun";
			$anggota->unit_id = empty($anggota->unit_id)?'':UnitM::model()->findByPk($anggota->unit_id)->namaunit;
			$anggota->golonganpegawai_id = empty($anggota->golonganpegawai_id)?'':GolonganpegawaiM::model()->findByPk($anggota->golonganpegawai_id)->golonganpegawai_nama;
		}

		$this->render('index', array('anggota'=>$anggota, 'penarikan'=>$penarikan, 'kaskeluar'=>$kaskeluar, 'sp'=>$sp));
	}

	public function actionInformasi()
	{
		$this->render('informasi');
	}

	public function actionPrint()
	{
		$this->render('print');
	}

	public function actionPrintInformasi()
	{
		$this->render('printInformasi');
	}

	// ==========================================================================

	public function loadSimpananAnggota($param) {
		$simpanan = SimpananT::model()->findAllByAttributes(array('keanggotaan_id'=>$param['id'], 'jenissimpanan_id'=>$param['jenis']), array('condition'=>'pengambilansimpanan_id is null', 'order'=>'tglsimpanan asc'));
		$res = '<option value>-- Pilih --</option>';
		foreach ($simpanan as $item) {
			$res .= CHtml::tag('option', array('value'=>$item->simpanan_id), $item->nosimpanan." - ".date("d/m/Y H:i", strtotime($item->tglsimpanan)));
		}
		echo $res;
	}

	public function loadSimpananPilihan($param) {
		$simpanan = SimpananT::model()->findByPk($param['id']);

		$attr = array();

		//echo $interval->d; die;
		if (!empty($simpanan)) {

			$tglsimpan = new DateTime($simpanan->tglsimpanan);
			$tglsekarang = new DateTime(date('Y-m-d H:i:s'));
			$interval = $tglsimpan->diff($tglsekarang);

			$m = $interval->m + ($interval->y*12);
			if ($interval->d > 0 || $interval->h > 0 || $interval->i > 0) $m += 1;

			$attr = $simpanan->attributes;
			$attr['lama_simpanan'] = $m;
			$attr['lama_simpanan_tahun'] = ceil($m/12);
			$attr['jumlahsimpanan'] = ceil($attr['jumlahsimpanan']);
			$attr['tglsimpanan'] = date('d/m/Y H:i', strtotime($simpanan->tglsimpanan));

		} else {

			$attr['simpanan_id'] = 0;

		}
		echo CJSON::encode($attr);
	}

	// ==========================================================================

	protected function saveBKK(&$kaskeluar, $post) {
		//var_dump($post); die;
		$anggota = KeanggotaanV::model()->findByAttributes(array('keanggotaan_id'=>$post['PengambilansimpananT']['keanggotaan_id']));

		$kaskeluar->attributes = $post['BukitkaskeluarT'];
		$kaskeluar->biayaadministrasi = str_replace(".","", $kaskeluar->biayaadministrasi);
		$kaskeluar->biayaamaterai = str_replace(".","", $kaskeluar->biayaamaterai);
		$kaskeluar->jmlkaskeluar = str_replace(".","", $kaskeluar->jmlkaskeluar);

		$kaskeluar->no_bkk = $kaskeluar->generateNoBKK();
		$kaskeluar->jenistransaksi_id = 11;
		$kaskeluar->namapenerima = $anggota->nama_pegawai;
		$kaskeluar->alamatpenerima = $anggota->alamat_pegawai;
		$kaskeluar->untuk_pengeluaran = "Penarikan Simpanan Anggota";

		$kaskeluar->tgl_bkk = $kaskeluar->prepareddate;
		foreach ($this->dateUp as $item) {
			$kaskeluar[$item] = MyFormatter::formatDateTimeForDb($kaskeluar[$item].":00");
		}

		$kaskeluar->bkk_create_time = date('Y-m-d H:i:s');
		$kaskeluar->bkk_create_login = Yii::app()->user->name;

		//var_dump($kaskeluar->validate); die;
		//var_dump($kaskeluar->errors); die;

		//var_dump($kaskeluar->attributes); die;

		if ($kaskeluar->validate()) return $kaskeluar->save();
		return false;
	}

	protected function savePenarikan(&$penarikan, $kaskeluar, $post) {
		//var_dump($post); die;

		$penarikan->attributes = $post['PengambilansimpananT'];

		$penarikan->nopengambilan = $penarikan->generatePenarikanSimpanan();

		$penarikan->jml_pokok_pengambilan = str_replace(".", "", $penarikan->jml_pokok_pengambilan);
		$penarikan->jml_jasa_pengambilan = str_replace(".", "", $penarikan->jml_jasa_pengambilan);
		$penarikan->jml_pengambilan = str_replace(".", "", $penarikan->jml_pengambilan);
		$penarikan->buktikaskeluar_id = $kaskeluar->bukitkaskeluar_id;
		$penarikan->tglpengambilan = $kaskeluar->tgl_bkk;
		$penarikan->biaya_materai_peng = $kaskeluar->biayaamaterai;
		$penarikan->biaya_administrasi_peng = $kaskeluar->biayaadministrasi;
		$penarikan->ambil_diperiksaoleh_id = $kaskeluar->reviewedby;
		$penarikan->ambil_disetujuioleh_id = $kaskeluar->approvedby;
		$penarikan->ambil_diperiksa_tgl = $kaskeluar->revieweddate;
		$penarikan->ambil_disetujui_tgl = $kaskeluar->approveddate;

		$penarikan->amb_create_time = date('Y-m-d H:i:s');
		$penarikan->amb_create_login = Yii::app()->user->name;

		//$penarikan->validate();
		//var_dump($penarikan->errors); die;

		//var_dump($penarikan->attributes); die;

		if ($penarikan->validate()) return $penarikan->save();
		return false;
	}
}
