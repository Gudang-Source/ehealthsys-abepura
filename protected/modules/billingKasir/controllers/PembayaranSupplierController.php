<?php

class PembayaranSupplierController extends MyAuthController {

	protected $successSave;

	/**
	 * pembayaran ke supplier
	 * di gunakan :
	 * 1. billingKasir -> informasi Faktur Pembelian -> bayar ke supplier 
	 */
	public function actionIndex() {
		if (isset($_GET['frame']) && !empty($_GET['idFakturPembelian'])) {
			$this->layout = "//layouts/iframe";
			$modelBayar = new BKBayarkeSupplierT;
			$modBuktiKeluar = new BKTandabuktikeluarT;
			$fakturpembelian_id = $_GET['idFakturPembelian'];
			$modFakturBeli = BKFakturPembelianT::model()->findByPk($fakturpembelian_id);
			$uangMuka = 0;
			$modUangMuka = new BKUangMukaBeliT();
			$sudahBayar = 0;
			if ((boolean) count($modFakturBeli)) {
				$modDetailBeli = BKFakturDetailT::model()->findAllByAttributes(array('fakturpembelian_id' => $fakturpembelian_id));
				if (isset($modFakturBeli->penerimaanbarang_id)) {
					$modUangMuka = BKUangMukaBeliT::model()->findByAttributes(array('penerimaanbarang_id' => $modFakturBeli->penerimaanbarang_id));
					if ((boolean) count($modUangMuka)) {
						$modelBayar->uangmukabeli_id = $modUangMuka->uangmukabeli_id;
						$modBuktiKeluar->uangmukabeli_id = $modUangMuka->uangmukabeli_id;
						$uangMuka = ((isset($modUangMuka->jumlahuang)) ? $modUangMuka->jumlahuang : 0);
					} else {
						$modUangMuka = new BKUangMukaBeliT();
					}
				}

				$modBayar = BKBayarkeSupplierT::model()->findAllByAttributes(array('fakturpembelian_id' => $fakturpembelian_id));
				if (count($modBayar) > 0) {
					foreach ($modBayar as $key => $value) {
						$sudahBayar += $value->jmldibayarkan;
					}
				}
			}
			$modelBayar->fakturpembelian_id = $fakturpembelian_id;
			$modelBayar->totaltagihan = $modFakturBeli->totalhargabruto - $sudahBayar;
			$modelBayar->jmldibayarkan = $modelBayar->totaltagihan - $uangMuka;
			$modBuktiKeluar->tahun = date('Y');
			$modBuktiKeluar->nokaskeluar = MyGenerator::noKasKeluar();
			$modBuktiKeluar->namapenerima = $modFakturBeli->supplier->supplier_nama;
			$modBuktiKeluar->alamatpenerima = $modFakturBeli->supplier->supplier_alamat;
			$modBuktiKeluar->untukpembayaran = 'Pembayaran Supplier';
			$modBuktiKeluar->biayaadministrasi = $modFakturBeli->biayamaterai;
			$modBuktiKeluar->jmlkaskeluar = $modelBayar->jmldibayarkan + $modBuktiKeluar->biayaadministrasi;
		} else {
			$modFakturBeli = new BKFakturPembelianT;
			$modDetailBeli = new BKFakturDetailT;
			$modUangMuka = new BKUangMukaBeliT;
			$modelBayar = new BKBayarkeSupplierT;
			$modBuktiKeluar = new BKTandabuktikeluarT;
			$modBuktiKeluar->tahun = date('Y');
		}

		if (isset($_POST['BKBayarkeSupplierT']) && (!isset($modFakturBeli->bayarkesupplier_id))) {
			$transaction = Yii::app()->db->beginTransaction();
			try {
				$modelBayar = $this->saveBayarSupplier($_POST['BKBayarkeSupplierT'], $modelBayar);
				$modBuktiKeluar = $this->saveBuktiKeluar($_POST['BKTandabuktikeluarT'], $modelBayar, $modBuktiKeluar);
				$this->updateBayarSupplier($modelBayar, $modBuktiKeluar);
				$sisa = ($modelBayar->totaltagihan - $modelBayar->jmldibayarkan - $uangMuka);
				if ($sisa < 1) {
					$update = FakturpembelianT::model()->updateByPk($fakturpembelian_id, array('bayarkesupplier_id' => $modelBayar->bayarkesupplier_id));
				}
				if ($this->successSave) {
					$transaction->commit();
					Yii::app()->user->setFlash('success', "Data berhasil disimpan");
//                        $this->redirect(array('index','id'=>$modelBayar->pembayaranpelayanan_id,'pendaftaran_id'=>$model->pendaftaran_id,'instalasi_id'=>$modKunjungan->instalasi_id,'sukses'=>1));
				} else {
					Yii::app()->user->setFlash('error', "Data gagal disimpan ");
					$transaction->rollback();
				}
			} catch (Exception $exc) {
				Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
				$transaction->rollback();
			}
		}

		$this->render('index', array('modFakturBeli' => $modFakturBeli,
			'modDetailBeli' => $modDetailBeli,
			'modelBayar' => $modelBayar,
			'modBuktiKeluar' => $modBuktiKeluar,
			'modUangMuka' => $modUangMuka,
		));
	}

	/**
	 * method untuk save pembayaran ke supplier 
	 * digunakan di
	 * 1. PembayaranSupplier/index
	 * @param array $postBayarSupplier post request $_POST['BKBayarkeSupplierT']
	 * @param obj $modBayar BKBayarkeSupplierT
	 * @return object BKBayarkeSupplierT
	 */
	protected function saveBayarSupplier($postBayarSupplier, $modBayar) {
		$format = new MyFormatter();
		$modBayar->attributes = $postBayarSupplier;
		$modBayar->tglbayarkesupplier = $format->formatDateTimeForDb($postBayarSupplier['tglbayarkesupplier']);
		if ($modBayar->validate()) {
			$modBayar->save();
			$this->successSave = true;
		} else {
			$this->successSave = false;
		}
		return $modBayar;
	}

	/**
	 * method untuk save tanda bukti keluar ke supplier 
	 * digunakan di
	 * 1. PembayaranSupplier/index
	 * @param array $postBuktiKeluar post request $_POST['BKTandaBuktiKeluarT']
	 * @param object $modBayarSupplier BKBayarSupplierT
	 * @param object $modBuktiKeluar BKTandaBuktiKeluarT
	 * @return object BKTandaBuktiKeluarT
	 */
	protected function saveBuktiKeluar($postBuktiKeluar, $modBayarSupplier, $modBuktiKeluar) {
				$format = new MyFormatter();

		$modBuktiKeluar->attributes = $postBuktiKeluar;
		$modBuktiKeluar->bayarkesupplier_id = $modBayarSupplier->bayarkesupplier_id;
		$modBuktiKeluar->tglkaskeluar = $format->formatDateTimeForDB($postBuktiKeluar['tglkaskeluar']);
		$modBuktiKeluar->ruangan_id = Yii::app()->user->getState('ruangan_id');
		$modBuktiKeluar->shift_id = Yii::app()->user->getState('shift_id');
		$modBuktiKeluar->create_time = date('Y-m-d H:i:s');
		$modBuktiKeluar->create_loginpemakai_id = Yii::app()->user->id;
		$modBuktiKeluar->create_ruangan = Yii::app()->user->getState('ruangan_id');
		$modBuktiKeluar->tahun = date('Y');
		if ($modBuktiKeluar->validate()) {
			$modBuktiKeluar->save();
			$this->successSave = $this->successSave && true;
		} else {
			$this->successSave = false;
		}

		return $modBuktiKeluar;
	}

	protected function updateBayarSupplier($modBayarSupplier, $modBuktiKeluar) {
		BKBayarkeSupplierT::model()->updateByPk($modBayarSupplier->bayarkesupplier_id, array('tandabuktikeluar_id' => $modBuktiKeluar->tandabuktikeluar_id));
	}

	public function actionPrint($fakturpembelian_id) {
		$judulKuitansi = '----- Tanda Bukti Bayar Hutang -----';
		$format = new MyFormatter();
		$modFakturBeli = BKFakturPembelianT::model()->findByPk($fakturpembelian_id);
		$modDetailBeli = BKFakturDetailT::model()->findAllByAttributes(array('fakturpembelian_id' => $fakturpembelian_id));
		$modelBayar = BKBayarkeSupplierT::model()->findByAttributes(array('fakturpembelian_id' => $fakturpembelian_id));
		$modBuktiKeluar = BKTandabuktikeluarT::model()->findByPk($modelBayar->tandabuktikeluar_id);
		$modUangMuka = BKUangMukaBeliT::model()->findByAttributes(array('penerimaanbarang_id' => $modFakturBeli->penerimaanbarang_id));

		$caraPrint = isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null;
		if ($caraPrint == 'PRINT') {
			$this->layout = '//layouts/printWindows';
			$this->render('Print', array(
				'judulKuitansi' => $judulKuitansi,
				'caraPrint' => $caraPrint,
				'modBuktiKeluar' => $modBuktiKeluar,
				'modFakturBeli' => $modFakturBeli,
				'modDetailBeli' => $modDetailBeli,
				'modelBayar' => $modelBayar,
				'modUangMuka' => $modUangMuka,
			));
		}
	}

}
