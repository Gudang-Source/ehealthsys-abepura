<?php

class PembayaranAngsuranController extends MyAuthController
{
	public $layout='//layouts/column1';
        public $path_view = 'koperasi.views.pembayaranAngsuran.';
	// public $defaultAction = 'admin';
	//public $menuActive = array(3,2); // Default. Harap diubah sesuai menu aktif yang ada.
	public function actionIndex($ke = null, $id = null, $no = null, $idAngsuran = null)
	{
            
		if (isset($_POST['ajax'])) {
			if (isset($_POST['param'])) call_user_func(array($this, $_POST['f']), $_POST['param']);
			else call_user_func(array($this, $_POST['f']));
			Yii::app()->end();
		}
		//$this->pageTitle = 'ecoopsys - Transaksi Pembayaran Angsuran';
		$insert_notifikasi = new CustomFunction();
		$konfig = KonfigkoperasiK::model()->find('status_aktif = true');

		$anggota = new KeanggotaanV;
		$pinjaman = new PinjamanT;
		$angsuran = new JmlangsuranT;
		$bayar = new PembayaranangsuranT;
		$kasmasuk = new BuktikasmasukkopT;
		$kasmasuk->tglbuktibayar = date('d/m/Y H:i');
		$kasmasuk->nobuktimasuk = $kasmasuk->generateNoBukti();
		$kasmasuk->preparedby = Yii::app()->user->getState('pegawai_id');
		if (!empty($konfig)) {
			$kasmasuk->reviewedby = $konfig->bendaharakoperasi_id;
			$kasmasuk->approvedby = $konfig->pimpinankoperasi_id;
		}
		$kasmasuk->prepareddate = $kasmasuk->revieweddate = $kasmasuk->approveddate = date('d/m/Y H:i');

		$ok = true;
		if (isset($_POST['angsuran'])) {

			//var_dump($_POST); die;
			$trans = Yii::app()->db->beginTransaction();
			$ok = $ok && $this->saveBKM($kasmasuk, $_POST);

			foreach ($_POST['angsuran'] as $idx=>$item) {
				if (isset($item['check']) && $item['check'] == 1) $ok = $ok && $this->saveBayarAngsuran($idx, $item, $_POST, $kasmasuk);
			}
			if ($ok) {
				$trans->commit();
				$this->redirect(array('index', 'status'=>1, 'id'=>$kasmasuk->buktikasmasuk_id));
			} else {
				$trans->rollback();
			}
			//var_dump($ok); die;
			//var_dump($_POST); die;
		}

		if (!empty($id)) {
			$kasmasuk = BuktikasmasukT::model()->findByPk($id);

			$kasmasuk->tglbuktibayar = date('d/m/Y H:i', strtotime($kasmasuk->tglbuktibayar));
			$kasmasuk->jmlpembayaran = MyFormatter::formatNumberForPrint($kasmasuk->jmlpembayaran);
			$kasmasuk->uangditerima = MyFormatter::formatNumberForPrint($kasmasuk->uangditerima);
			$kasmasuk->uangkembalian = MyFormatter::formatNumberForPrint($kasmasuk->uangkembalian);

			$kasmasuk->prepareddate = date('d/m/Y H:i', strtotime($kasmasuk->prepareddate));
			$kasmasuk->revieweddate = date('d/m/Y H:i', strtotime($kasmasuk->revieweddate));
			$kasmasuk->approveddate = date('d/m/Y H:i', strtotime($kasmasuk->approveddate));

			$bayar = PembayaranangsuranT::model()->findByAttributes(array('buktikasmasuk_id'=>$kasmasuk->buktikasmasuk_id));
			$angsuran = JmlangsuranT::model()->findByAttributes(array('jmlangsuran_id'=>$bayar->jmlangsuran_id));
			$pinjaman = PinjamanT::model()->findByPk($angsuran->pinjaman_id);
			$anggota = KeanggotaanV::model()->findByAttributes(array('keanggotaan_id'=>$angsuran->keanggotaan_id));

			//var_dump($kasmasuk->attributes); die;
			//insert notifikasi
			$params['tglnotifikasi'] = date( 'Y-m-d H:i:s');
         $params['create_time'] = date( 'Y-m-d H:i:s');
         $params['create_loginpemakai_id'] = Yii::app()->user->id;
         $params['isinotifikasi'] = $anggota->nama_pegawai . ', ' . $anggota->nokeanggotaan . '<br/> Angsuran Ke-' . $angsuran->angsuran_ke . ', Rp' . MyFormatter::formatNumberForPrint($bayar->jmlpokok_byrangsuran) . ', Rp' . $kasmasuk->jmlpembayaran . '<br/> Dibuat Oleh : ' . Yii::app()->user->name;
         $params['judulnotifikasi'] = 'Pembayaran Angsuran';
         $params['link'] = "/pinjaman/InfromasiKartuAngsuran&no=".$pinjaman->no_pinjaman;
         $nofitikasi = $insert_notifikasi->insertNotifikasi($params);
		}


		$this->render($this->path_view.'index', array('anggota'=>$anggota, 'pinjaman'=>$pinjaman, 'angsuran'=>$angsuran, 'kasmasuk'=>$kasmasuk, 'bayar'=>$bayar, 'ke'=>$ke, 'no'=>$no, 'idAngsuran'=>$idAngsuran));
	}

	public function actionInformasi()
	{
		$this->render('informasi');
	}

	// ==========================================

	protected function saveBKM(&$kasmasuk, $post) {
		//var_dump($post); die;

		$anggota = KeanggotaanV::model()->findByAttributes(array('keanggotaan_id' =>$post['KeanggotaanV']['keanggotaan_id']));
		//var_dump($anggota->attributes); die;

		$kasmasuk->attributes = $post['BuktikasmasukT'];
		$kasmasuk->jenistransaksi_id = 13; // default = Angsuran
		$kasmasuk->tglbuktibayar = MyFormatter::formatDateTimeForDb($kasmasuk->tglbuktibayar.":00");
		$kasmasuk->prepareddate = (empty($kasmasuk->prepareddate))?null:MyFormatter::formatDateTimeForDb($kasmasuk->prepareddate.":00");
		$kasmasuk->revieweddate = (empty($kasmasuk->revieweddate))?null:MyFormatter::formatDateTimeForDb($kasmasuk->revieweddate.":00");
		$kasmasuk->approveddate = (empty($kasmasuk->approveddate))?null:MyFormatter::formatDateTimeForDb($kasmasuk->approveddate.":00");
		$kasmasuk->biayaadministrasi = str_replace('.', '', $kasmasuk->biayaadministrasi);
		$kasmasuk->biayaadministrasi += str_replace('.', '', $post['BuktikasmasukT']['biayadenda']);
		$kasmasuk->jmlpembayaran = str_replace('.', '', $kasmasuk->jmlpembayaran);
		$kasmasuk->uangditerima = str_replace('.', '', $kasmasuk->uangditerima);
		$kasmasuk->uangkembalian = str_replace('.', '', $kasmasuk->uangkembalian);
		$kasmasuk->jenistransaksi_id = 1;
		$kasmasuk->jmlbayarkartu = 0;
		$kasmasuk->darinama_bkm = $anggota->nama_pegawai;
		$kasmasuk->alamat_bkm = $anggota->alamat_pegawai;
		$kasmasuk->sebagaipembayaran_bkm = 'Pembayaran Angsuran';
		$kasmasuk->biayamaterai = 0;
		$kasmasuk->keterangan_pembayaran = 0;
		$kasmasuk->create_time = date('Y-m-d H:i:s');
		$kasmasuk->create_login = Yii::app()->user->name;

		//var_dump($kasmasuk->attributes); die;

		if ($kasmasuk->validate()) return $kasmasuk->save();
		return false;
		//var_dump($kasmasuk->errors); die;
		//var_dump($kasmasuk->attributes); die;
	}

	protected function saveBayarAngsuran($id, $postBayar, $post, $kasmasuk) {
		// var_dump($postBayar); die;
		$ok = true;
		$bayar = new PembayaranangsuranT;
		$bayar->attributes = $postBayar;
		// $bayar->potongansumber_id = $postBayar['potongansumber_id'];
		$bayar->jmlangsuran_id = $id;
		$bayar->buktikasmasuk_id = $kasmasuk->buktikasmasuk_id;
		$bayar->lamahari_sdhjthtempo = 0; // sementara...
		$bayar->pembangs_create_time = date('Y-m-d H:i:s');
		$bayar->pembangs_create_login = Yii::app()->user->id;
		$bayar->tglpembayaranangsuran = MyFormatter::formatDateForDb($bayar->tglpembayaranangsuran);
		$bayar->jmlpokok_byrangsuran = str_replace('.', '', $bayar->jmlpokok_byrangsuran);
		$bayar->jmljasa_byrangsuran = str_replace('.', '', $bayar->jmljasa_byrangsuran);
		$bayar->jmldenda_byrangsuran = str_replace('.', '', $bayar->jmldenda_byrangsuran);
		$bayar->jmlsisa_pembangsuran = str_replace('.', '', $bayar->jmlsisa_pembangsuran);
		$bayar->jmlbayar_pembangsuran = str_replace('.', '', $postBayar['jml_bayar']);
		$bayar->jmlbayar_pembangsuran += $bayar->jmldenda_byrangsuran;

		// var_dump($bayar->attributes); die;

		$ok = $ok && $bayar->validate();
		$ok = $ok && $bayar->save();

		$angsuran = JmlangsuranT::model()->findByPk($id);
		$ok = $ok && JmlangsuranT::model()->updateByPk($id, array('jmldenda_angsuran'=>(empty($angsuran->jmldenda_angsuran)?0:$angsuran->jmldenda_angsuran) + $bayar->jmldenda_byrangsuran));

		if ($bayar->jmlsisa_pembangsuran == 0) $ok = $ok && JmlangsuranT::model()->updateByPk($id, array('isudahbayar'=>true));

		//var_dump($ok); die;


		return $ok;

		//var_dump($bayar->attributes); die;
	}

	// ==========================================

	protected function loadAngsuran($param) {
		$criteria = new CDbCriteria;
		$criteria->order = 'angsuran_ke asc';
		$criteria->compare('pinjaman_id', $param['id']);
		if ($param['idAngsuran'] != 0) $criteria->compare('jmlangsuran_id', $param['idAngsuran']);

		$angsuran = JmlangsuranT::model()->findAll($criteria);

		//$angsuran = JmlangsuranT::model()->findAllByAttributes(array('pinjaman_id'=>$param['id']), array('order'=>'angsuran_ke asc'));
		echo CJSON::encode(array('tab'=>$this->renderPartial('subview/_rowAngsuran', array('angsuran'=>$angsuran), true)));
	}
}
