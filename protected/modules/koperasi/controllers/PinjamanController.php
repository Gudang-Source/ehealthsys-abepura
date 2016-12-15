<?php

class PinjamanController extends MyAuthController
{
	public $layout='//layouts/column1';
	// public $defaultAction = 'admin';
	//public $menuActive = array(3,1); // Default. Harap diubah sesuai menu aktif yang ada.
	public function actionIndex($id = null, $permohonanId = null)
	{
		$permil = 0;

		if (isset($_POST['ajax'])) {
			if (isset($_POST['param'])) call_user_func(array($this, $_POST['f']), $_POST['param']);
			else call_user_func(array($this, $_POST['f']));
			Yii::app()->end();
		}		
		$konfig = KonfigkoperasiK::model()->find('status_aktif = true');
		$insert_notifikasi = new CustomFunction();
		$pinjaman = new PinjamanT;
		$permintaan = new InformasipermohonanpinjamanV;
		$kaskeluar = new BuktikaskeluarkopT;
		$poasuransi = new PotonganasuransiT;

		$pinjaman->tglpinjaman = date('d/m/Y');
		$pinjaman->no_pinjaman = MyGenerator::generateNoPinjaman($pinjaman->jenispinjaman);
		$pinjaman->persen_jasa_pinjaman = number_format($konfig->persjasapinjaman, 2, ',', '.');
		$pinjaman->biaya_materai = '7.000';

		$kaskeluar->preparedby = Yii::app()->user->getState('pegawai_id');
		$kaskeluar->prepareddate = date('d/m/Y H:i');
		$kaskeluar->reviewedby = $konfig->bendaharakoperasi_id;
		$kaskeluar->revieweddate = date('d/m/Y H:i');
		$kaskeluar->approvedby = $konfig->pimpinankoperasi_id;
		$kaskeluar->approveddate = date('d/m/Y H:i');

		$asuransi = PremiasuransiM::model()->findAll();
		$arrAs = array();
		foreach ($asuransi as $item) {
			$arrAs[$item->umur][$item->tahun] = $item->persen;
		}

		if (isset($_POST['PinjamanT'])) {

			$ok = true;
			$trans = Yii::app()->db->beginTransaction();

			$ok = $ok && $this->savePinjaman($pinjaman, $_POST);
			$ok = $ok && $this->saveKasKeluar($kaskeluar, $_POST);
			$ok = $ok && $this->saveAngsuran($pinjaman, $kaskeluar, $_POST);
			$ok = $ok && $this->savePotongan($pinjaman, $_POST);
			$ok = $ok && $this->saveAsuransi($poasuransi, $pinjaman, $_POST);
			$ok = $ok && BukitkaskeluarT::model()->updateByPk($kaskeluar->bukitkaskeluar_id, array(
				'untuk_pengeluaran' => 'Pinjaman Anggota <br/>-- '.$pinjaman->no_pinjaman." : ".date("d/m/Y", strtotime($pinjaman->tglpinjaman)),
			));
			//$ok = $
			//var_dump($ok); die;

			$anggota = KeanggotaanT::model()->findByPk($pinjaman->keanggotaan_id);
			//insert notifikasi
			$params['tglnotifikasi'] = date( 'Y-m-d H:i:s');
	        $params['create_time'] = date( 'Y-m-d H:i:s');
	        $params['create_loginpemakai_id'] = Yii::app()->user->id;
	        $params['isinotifikasi'] = $pinjaman->no_pinjaman . ', ' . MyFormatter::formatDateTimeId($pinjaman->tglpinjaman) . ', Rp' . MyFormatter::formatNumberForPrint($pinjaman->jml_pinjaman) . '<br/>' . $anggota->pegawai->nama_pegawai . ' - ' . $anggota->nokeanggotaan . '<br/> Dibuat Oleh : ' . Yii::app()->user->name;
	        $params['judulnotifikasi'] = 'Pencairan Pinjaman';
	        $params['link'] = "/pinjaman/pinjaman/print&id=".$pinjaman->pinjaman_id;
	        $nofitikasi = $insert_notifikasi->insertNotifikasi($params);

			if ($ok) {
				$trans->commit();
                                Yii::app()->user->setFlash("success", "Pencairan Peminjaman berhasil ditransaksikan");
				$this->redirect(array('index', 'id'=>$pinjaman->pinjaman_id, 'status'=>1));
			} else {
				$trans->rollback();
				Yii::app()->user->setFlash("error", "Pencairan Peminjaman gagal ditransaksikan");
				$this->redirect(array('index', 'status'=>0));
			}
		}

		if (!empty($id)) {
			$pinjaman = PinjamanT::model()->findByPk($id);

			$p = $pinjaman->jml_pinjaman;

			$pinjaman->jml_pinjaman = MyFormatter::formatNumberForPrint($pinjaman->jml_pinjaman);
			$pinjaman->tglpinjaman = date('d/m/Y', strtotime($pinjaman->tglpinjaman));
			$pinjaman->jatuh_tempo = date('d/m/Y', strtotime($pinjaman->jatuh_tempo));

			$poasuransi = PotonganasuransiT::model()->findByAttributes(array('pinjaman_id' => $pinjaman->pinjaman_id));
			$poasuransi->premi_asuransi_persen = number_format($poasuransi->premi_asuransi_persen, 2, ",", ".");
			$poasuransi->jml_biayaasuransi = MyFormatter::formatNumberForPrint($poasuransi->jml_biayaasuransi);

			$permintaan = InformasipermohonanpinjamanV::model()->findByAttributes(array('permohonanpinjaman_id' => $pinjaman->permohonanpinjaman_id));
			$permintaan->jmlpinjaman = MyFormatter::formatNumberForPrint($permintaan->jmlpinjaman);
			$permintaan->batasplafon = MyFormatter::formatNumberForPrint($permintaan->batasplafon);
			$permintaan->jmltunggakanuangpinj = MyFormatter::formatNumberForPrint($permintaan->jmltunggakanuangpinj);
			$permintaan->jmltunggakanbrgpinj = MyFormatter::formatNumberForPrint($permintaan->jmltunggakanbrgpinj);
			$permintaan->appr_disetujuioleh_id = PegawaiM::model()->findByPk($permintaan->appr_disetujuioleh_id)->nama_pegawai;
			if ($permintaan->status_disetujui == 1){
				$permintaan->status_disetujui = "DITERIMA";
			}
			$permintaan->tgl_lahirpegawai = date('d/m/Y', strtotime($permintaan->tgl_lahirpegawai));


			$angsuran = JmlangsuranT::model()->findByAttributes(array('pinjaman_id'=>$pinjaman->pinjaman_id));

			$kaskeluar = BukitkaskeluarT::model()->findByPk($angsuran->bukitkaskeluar_id);

			//$k = $kaskeluar->biayaasuransi;

			if (empty($kaskeluar)) $kaskeluar = new BukitkaskeluarT;
			$pinjaman->biaya_administrasi = MyFormatter::formatNumberForPrint($pinjaman->biaya_administrasi);
			$pinjaman->biaya_materai = MyFormatter::formatNumberForPrint($pinjaman->biaya_materai);
			$kaskeluar->jmlkaskeluar = MyFormatter::formatNumberForPrint($kaskeluar->jmlkaskeluar);
			//$kaskeluar->biayaasuransi = MyFormatter::formatNumberForPrint($kaskeluar->biayaasuransi);

			$kaskeluar->prepareddate = date('d/m/Y H:i', strtotime($kaskeluar->prepareddate));
			$kaskeluar->revieweddate = date('d/m/Y H:i', strtotime($kaskeluar->revieweddate));
			$kaskeluar->approveddate = date('d/m/Y H:i', strtotime($kaskeluar->approveddate));

			//$permil = number_format(($k*1000/$p), 2, ',', '.');

		}

		if (!empty($permohonanId)) {
			$permintaan = InformasipermohonanpinjamanV::model()->findByAttributes(array('permohonanpinjaman_id' => $permohonanId));
			$permintaan->jmlpinjaman = MyFormatter::formatNumberForPrint($permintaan->jmlpinjaman);
			$permintaan->batasplafon = MyFormatter::formatNumberForPrint($permintaan->batasplafon);
			$permintaan->jmltunggakanuangpinj = MyFormatter::formatNumberForPrint($permintaan->jmltunggakanuangpinj);
			$permintaan->jmltunggakanbrgpinj = MyFormatter::formatNumberForPrint($permintaan->jmltunggakanbrgpinj);
			$permintaan->tgl_lahirpegawai = date('d/m/Y', strtotime($permintaan->tgl_lahirpegawai));

			//$penyetuju = PegawaiM::model()->findByPk($permintaan->);
		}

		$this->render('index', array(
			'permintaan'=>$permintaan,
			'pinjaman'=>$pinjaman,
			'kaskeluar'=>$kaskeluar,
			'permohonanId'=>$permohonanId,
			'konfig'=>$konfig,
			'arrAs'=>CJSON::encode($arrAs),
			'permil'=>$permil,
			'poasuransi'=>$poasuransi,
		));
	}

	public function actionInformasi()
	{
		$this->render('informasi');
	}

	public function actionPrint($id,$p = null)
	{
		$this->layout='//layouts/print';
		$this->pageTitle = 'ecoopsys - Surat Perjanjian Pinjaman';
		$pinjaman = PinjamanT::model()->findByPk($id);
		$permintaan = InformasipermohonanpinjamanV::model()->findByAttributes(array('permohonanpinjaman_id'=>$pinjaman->permohonanpinjaman_id));
		$angsuran = JmlangsuranT::model()->findAllByAttributes(array('pinjaman_id'=>$pinjaman->pinjaman_id), array('order'=>'angsuran_ke asc'));
		$profil = ProfilS::model()->find(array('order'=>'profilperusahaan_id asc'));
		$this->render('print', array(
			'pinjaman'=>$pinjaman,
			'permintaan'=>$permintaan,
			'angsuran'=>$angsuran,
			'profil'=>$profil
		));
	}

	// ==========================================================

	protected function hitungCicilan($param) {
		// var_dump($param); die;
		$tglPinjam = new DateTime(date('Y-m-d', strtotime(MyFormatter::formatDateTimeForDb($param['tglPinjam'])." 00:00:00")));
		$tglJatuh = new DateTime(date('Y-m-d', strtotime(MyFormatter::formatDateTimeForDb($param['jatuhTempo'])." 00:00:00")));
		$jmlPinjaman = $param['jmlpinjaman'];
		$jasa = $param['jasaPinjaman'];
		$jangka = $param['jangkaWaktu'];
		$cicil = $param['cicil'];

		//echo $tglPinjam->format('d/m/Y'); die;

		$interval = $tglPinjam->diff($tglJatuh)->format("%a");
		$intervalCicil = $interval / ($cicil + 1);

		$hari = floor($intervalCicil);
		$jam = ($intervalCicil - floor($intervalCicil)) * 24;
		$menit = ($jam - floor($jam)) * 60;
		$detik = floor(($menit - floor($menit)) * 60);

		$intervalCicil = new DateInterval("P".$hari."DT".floor($jam)."H".floor($menit)."M".$detik."S");

		$jmlCicil = $jmlPinjaman / $cicil;
		$jasaCicil = ($jasa/100) * $jmlPinjaman; // $cicil;

		echo CJSON::encode(array(
			'tabel'=>$this->renderPartial('subview/_rowCicilan', array(
				'cicil'=>$cicil,
				'intervalCicil'=>$intervalCicil,
				'jmlCicil' => $jmlCicil,
				'jasaCicil' => $jasaCicil,
				'tglPinjam' => $tglPinjam,
				'tglJatuh' => $tglJatuh,
			), true),
		));

	}

	// ================================================================================

	protected function savePinjaman(&$pinjaman, $post) {
		$permintaan = InformasipermohonanpinjamanV::model()->findByAttributes(array('permohonanpinjaman_id' => $post['PinjamanT']['permohonanpinjaman_id']));
		//var_dump($permintaan->attributes); die;
		$pinjaman->attributes = $post['PinjamanT'];
		// var_dump($pinjaman->attributes); die;
		$pinjaman->persen_jasa_pinjaman = str_replace(",",".",$pinjaman->persen_jasa_pinjaman);
		$pinjaman->jenispinjaman = $post['InformasipermohonanpinjamanV']['jenispinjaman_permohonan'];
		$pinjaman->tglpinjaman = MyFormatter::formatDateForDb($pinjaman->tglpinjaman);
		$pinjaman->jatuh_tempo = MyFormatter::formatDateForDb($pinjaman->jatuh_tempo);
		$pinjaman->pinj_tgldiperiksa = $permintaan->appr_tgldiperiksa;
		$pinjaman->pinj_diperiksaoleh_id = $permintaan->appr_diperiksaoleh_id;
		$pinjaman->pinj_tgldisetujui = $permintaan->appr_tgldisetujui;
		$pinjaman->pinj_disetujuioleh_id = $permintaan->appr_disetujuioleh_id;
		$pinjaman->pinj_create_time = date('Y-m-d H:i:s');
		$pinjaman->pinj_create_login = Yii::app()->user->name;
		$pinjaman->no_pinjaman = $pinjaman->generateNoPinjaman($pinjaman->jenispinjaman);

		$pinjaman->jml_pinjaman = str_replace(".", "", $pinjaman->jml_pinjaman);
		$pinjaman->biaya_materai = str_replace(".", "", $pinjaman->biaya_materai);
		$pinjaman->biaya_administrasi = str_replace(".", "", $pinjaman->biaya_administrasi);

		// $pinjaman->validate();
		// var_dump($pinjaman->errors); die;
		// var_dump($pinjaman->attributes); die;

		if ($pinjaman->validate()) return $pinjaman->save();
		return false;

		//$pinjaman

	}


	/*
	* Menyimpan data kas keluar
	*/
	protected function saveKasKeluar(&$kaskeluar, $post) {
		//var_dump($post); die;
		$permintaan = InformasipermohonanpinjamanV::model()->findByAttributes(array('permohonanpinjaman_id' => $post['PinjamanT']['permohonanpinjaman_id']));

		$kaskeluar->attributes = $post['BukitkaskeluarT'];
		$kaskeluar->tgl_bkk = MyFormatter::formatDateForDb($post['PinjamanT']['tglpinjaman']);
		$kaskeluar->namapenerima = $post['InformasipermohonanpinjamanV']['nama_pegawai'];
		$kaskeluar->untuk_pengeluaran = 'Pinjam Anggota';

		$kaskeluar->biayaadministrasi = $post['PinjamanT']['biaya_administrasi'];
		$kaskeluar->biayaamaterai = $post['PinjamanT']['biaya_materai'];

		$kaskeluar->bkk_create_time = date('Y-m-d H:i:s');
		$kaskeluar->bkk_create_login = Yii::app()->user->name;

		$kaskeluar->no_bkk = $kaskeluar->generateNoBKK();
		$kaskeluar->alamatpenerima = $permintaan->alamat_pegawai;
		$kaskeluar->jenistransaksi_id = 12; // default = Pinjaman

		$kaskeluar->jmlkaskeluar = str_replace(".", "", $kaskeluar->jmlkaskeluar);
		$kaskeluar->biayaamaterai = str_replace(".", "", $kaskeluar->biayaamaterai);
		$kaskeluar->biayaadministrasi = str_replace(".", "", $kaskeluar->biayaadministrasi);

		$kaskeluar->prepareddate = (empty($kaskeluar->prepareddate))?null:MyFormatter::formatDateTimeForDb($kaskeluar->prepareddate.":00");
		$kaskeluar->revieweddate = (empty($kaskeluar->revieweddate))?null:MyFormatter::formatDateTimeForDb($kaskeluar->revieweddate.":00");
		$kaskeluar->approveddate = (empty($kaskeluar->approveddate))?null:MyFormatter::formatDateTimeForDb($kaskeluar->approveddate.":00");

		//var_dump($kaskeluar->attributes); die;

		if ($kaskeluar->validate()) return $kaskeluar->save();
		return false;

		//var_dump($kaskeluar->errors); die;
	}

	protected function saveAngsuran($pinjaman, $kaskeluar, $post) {

		$ok = true;
		foreach ($post['JmlangsuranT'] as $item) {
			$angsuran = new JmlangsuranT();
			$angsuran->attributes = $item;
			$angsuran->tglangsuran = MyFormatter::formatDateForDb($angsuran->tglangsuran);
			$angsuran->tgljatuhtempoangs = MyFormatter::formatDateForDb($angsuran->tgljatuhtempoangs);
			$angsuran->pinjaman_id = $pinjaman->pinjaman_id;
			$angsuran->keanggotaan_id = $pinjaman->keanggotaan_id;
			$angsuran->bukitkaskeluar_id = $kaskeluar->bukitkaskeluar_id;

			$angsuran->angs_create_time = date('Y-m-d H:i:s');
			$angsuran->angs_create_login = Yii::app()->user->name;

			$angsuran->jmlpokok_angsuran = str_replace(".", "", $angsuran->jmlpokok_angsuran);
			$angsuran->jmljasa_angsuran = str_replace(".", "", $angsuran->jmljasa_angsuran);

			// var_dump($angsuran->attributes); die;

			if ($angsuran->validate()) $ok = $ok && $angsuran->save();
			else $ok = $ok && false;
		}

		return $ok;
	}

	protected function savePotongan($pinjaman, $post) {
		$ok = true;

		$savedIdx = array();
		foreach ($post['potongan'] as $i=>$val) {
			//var_dump($val); die;
			$potongan = PotonganpinjamandariT::model()->findByAttributes(array('permohonanpinjaman_id' => $pinjaman->permohonanpinjaman_id, 'potongansumber_id'=>$i));
			if (empty($potongan)) {
				$potongan = new PotonganpinjamandariT;
				$potongan->permohonanpinjaman_id = $pinjaman->permohonanpinjaman_id;
				$potongan->pinjaman_id = $pinjaman->pinjaman_id;
				$potongan->potongansumber_id = $i;
				$potongan->jumlahpotongan = str_replace(".","",$val['text']);
				$potongan->pp_create_time = date('Y-m-d H:i:s');
				$potongan->pp_create_login = 1;

				if ($potongan->validate()) {
					$ok = $ok && $potongan->save();
					array_push($savedIdx, $i);
				}
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
		$delc->compare('permohonanpinjaman_id', $pinjaman->permohonanpinjaman_id);

		PotonganpinjamandariT::model()->deleteAll($delc);

		//var_dump($ok);

		//die;
		return $ok;
	}

	public function saveAsuransi($poasuransi, $pinjaman, $post) {
		$poasuransi->attributes = $post['PotonganasuransiT'];
		$poasuransi->premi_asuransi_persen = str_replace(",",".",$poasuransi->premi_asuransi_persen);
		$poasuransi->jml_biayaasuransi = str_replace(".","",$poasuransi->jml_biayaasuransi);
		$poasuransi->pinjaman_id = $pinjaman->pinjaman_id;
		$poasuransi->tglpotonganasuransi = $pinjaman->tglpinjaman;
		$poasuransi->jml_pinjaman_asuransi = $pinjaman->jml_pinjaman;
		$poasuransi->lamaasuransi_thn = ceil($pinjaman->jangka_waktu_bln/12);

		if ($poasuransi->validate()) {
			return $poasuransi->save();
		} return false;
	}

}
