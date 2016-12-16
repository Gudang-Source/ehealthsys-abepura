<?php

class KoreksiAngsuranController extends MyAuthController
{
	public $layout='//layouts/column1';
	// public $defaultAction = 'admin';
	//public $menuActive = array(3,5);

	private $dateUp = array('tgl_bkk','prepareddate','revieweddate','approveddate');

	public function actionIndex($bkk = null)
	{
		$kaskeluar = new BuktikaskeluarkopT;
		$pinjaman = new InfopinjamanV;//InfopinjamananggotaV;

		$konfig = KonfigkoperasiK::model()->find('status_aktif = true');

		$pinjaman->tglAwal = $pinjaman->tglAkhir = date('Y-m-d');

		// searching....

		if (isset($_GET['InfopinjamananggotaV'])) {
			//echo "Kick"; die;
			$pinjaman->attributes = $_GET['InfopinjamananggotaV'];
			//var_dump(empty($_GET['InfopinjamananggotaV']['tglAwal'])); die;
			if (
				isset($_GET['InfopinjamananggotaV']['tglAwal']) && isset($_GET['InfopinjamananggotaV']['tglAkhir']) &&
				!empty($_GET['InfopinjamananggotaV']['tglAwal']) && !empty($_GET['InfopinjamananggotaV']['tglAkhir'])
			) {
				$pinjaman->tglAwal = MyFormatter::formatDateForDb($_GET['InfopinjamananggotaV']['tglAwal']);
				$pinjaman->tglAkhir = MyFormatter::formatDateForDb($_GET['InfopinjamananggotaV']['tglAkhir']);
			}
		}

		// end searching....

		$kaskeluar->tgl_bkk = date('d/m/Y H:i');
		$kaskeluar->no_bkk = MyGenerator::generateNoBKK();
		$kaskeluar->untuk_pengeluaran = 'Pembayaran Potongan Asuransi';

		$kaskeluar->preparedby = Yii::app()->user->getState('pegawai_id');
		$kaskeluar->prepareddate = date('d/m/Y H:i');
		$kaskeluar->reviewedby = $konfig->bendaharakoperasi_id;
		$kaskeluar->revieweddate = date('d/m/Y H:i');
		$kaskeluar->approvedby = $konfig->pimpinankoperasi_id;
		$kaskeluar->approveddate = date('d/m/Y H:i');

		if (isset($_POST['BukitkaskeluarT'])) {
			$ok = true;
			$trans = Yii::app()->db->beginTransaction();

			$ok = $ok && $this->saveBKK($kaskeluar, $_POST);
			if (isset($_POST['asuransi'])) {
				foreach ($_POST['asuransi'] as $idx=>$item) $ok = $ok && PotonganasuransiT::model()->updateByPk($idx, array('buktikaskeluar_id'=>$kaskeluar->bukitkaskeluar_id));
			}

			if ($ok) {
				$trans->commit();
				$this->redirect(array('index', 'status'=>1, 'bkk'=>$kaskeluar->bukitkaskeluar_id));
			} else {
				$trans->rollback();
				$this->redirect(array('index', 'status'=>0));
			}
		}

		if (!empty($bkk)) {
			$kaskeluar = BukitkaskeluarT::model()->findByPk($bkk);
			$kaskeluar->prepareddate = date('d/m/Y H:i', strtotime($kaskeluar->prepareddate));
			$kaskeluar->revieweddate = date('d/m/Y H:i', strtotime($kaskeluar->revieweddate));
			$kaskeluar->approveddate = date('d/m/Y H:i', strtotime($kaskeluar->approveddate));
			$kaskeluar->tgl_bkk = date('d/m/Y H:i', strtotime($kaskeluar->tgl_bkk));
			$kaskeluar->jmlkaskeluar = MyFormatter::formatNumberForPrint($kaskeluar->jmlkaskeluar);
		}

		//var_dump($kaskeluar->attributes); die;

		$this->render('index', array(
			'kaskeluar'=>$kaskeluar,
			'pinjaman'=>$pinjaman,
		));
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




	protected function saveBKK(&$kaskeluar, $post) {
		$kaskeluar->attributes = $post['BukitkaskeluarT'];
		$kaskeluar->jmlkaskeluar = str_replace(".", "", $kaskeluar->jmlkaskeluar);
		$kaskeluar->jenistransaksi_id = 10;
		$kaskeluar->bkk_create_time = date('Y-m-d H:i:s');
		$kaskeluar->bkk_create_login = Yii::app()->user->name;

		foreach ($this->dateUp as $item) {
			$kaskeluar[$item] = MyFormatter::formatDateTimeForDb($kaskeluar[$item].":00");
		}

		//$kaskeluar->validate();
		//var_dump($kaskeluar->errors); die;

		if($kaskeluar->validate()) return $kaskeluar->save();
		return false;
	}
}
