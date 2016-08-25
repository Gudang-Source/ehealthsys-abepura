<?php

class PembayaranKeSupplierUmumController extends MyAuthController {

	protected $successSave;

	/**
	 * pembayaran ke supplier
	 * di gunakan :
	 * 1. keuangan -> informasi Faktur UMum -> bayar ke supplier 
	 */
	public function actionIndex() {
		if (isset($_GET['frame'])) {
			$this->layout = '//layouts/iframe';
		}
		$modelBayar = new KUBayarkesupplierT;
		$modBuktiKeluar = new KUTandabuktikeluarT;
		$modTerimaPersediaan = new KUTerimapersediaanT;
		$modDetailPersediaan = new KUTerimapersdetailT;
		$modBuktiKeluar->tahun = date('Y');

		if (!empty($_GET['terimapersediaan_id'])) {
			$terimapersediaan_id = $_GET['terimapersediaan_id'];
			$modTerimaPersediaan = KUTerimapersediaanT::model()->findByPk($terimapersediaan_id);
			$sudahBayar = 0;
                       
			if ((boolean) count($modTerimaPersediaan)) {
				$modDetailPersediaan = KUTerimapersdetailT::model()->findAllByAttributes(array('terimapersediaan_id' => $terimapersediaan_id));

				$modBayar = KUBayarkesupplierT::model()->findAllByAttributes(array('terimapersediaan_id' => $terimapersediaan_id));
				if (count($modBayar) > 0) {
					foreach ($modBayar as $key => $value) {
						$sudahBayar += $value->jmldibayarkan;
					}
				}
			}
			$modelBayar->terimapersediaan_id = $terimapersediaan_id;
                        $modelBayar->totaltagihan = $modTerimaPersediaan->totalharga - $sudahBayar;
			//$modelBayar->jmldibayarkan = $modelBayar->totaltagihan - $uangMuka;
			$modBuktiKeluar->nokaskeluar = "Otomatis";
			$modBuktiKeluar->namapenerima = $modTerimaPersediaan->pembelianbarang->supplier->supplier_nama;
			$modBuktiKeluar->alamatpenerima = $modTerimaPersediaan->pembelianbarang->supplier->supplier_alamat;
			$modBuktiKeluar->untukpembayaran = 'Pembayaran Supplier';
                        
                      
                         $modelBayar->totaltagihan = $modTerimaPersediaan->totalharga - $sudahBayar;
                         $modelBayar->jmldibayarkan =  $modelBayar->totaltagihan;
                       
		}
                 
		if (!empty($_GET['bayarkesupplier_id'])) {

			$modelBayar = KUBayarkesupplierT::model()->findByPk($_GET['bayarkesupplier_id']);
			$modBuktiKeluar = KUTandabuktikeluarT::model()->findByAttributes(array('bayarkesupplier_id' => $_GET['bayarkesupplier_id']));
		}
		if (isset($_POST['KUBayarkesupplierT']) && (!isset($modTerimaPersediaan->bayarkesupplier_id))) {
			$transaction = Yii::app()->db->beginTransaction();
			try {
				$modelBayar = $this->saveBayarSupplier($_POST['KUBayarkesupplierT'], $modelBayar);
				$modBuktiKeluar = $this->saveBuktiKeluar($_POST['KUTandabuktikeluarT'], $modelBayar, $modBuktiKeluar);

				if ($this->successSave) {
					//echo "test";
					$transaction->commit();
                                        Yii::app()->user->setFlash("success", "Pembayaran berhasil disimpan.");
					$this->redirect(array('index', 'terimapersediaan_id' => $terimapersediaan_id, 'bayarkesupplier_id' => $modelBayar->bayarkesupplier_id, 'frame' => 1,'sukses'=>1));
					Yii::app()->user->setFlash('success', "Data berhasil disimpan");
				} else {
					Yii::app()->user->setFlash('error', "Data gagal disimpan ");
					$transaction->rollback();
				}
			} catch (Exception $exc) {
				Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
				$transaction->rollback();
			}
		}

		$this->render('index', array('modTerimaPersediaan' => $modTerimaPersediaan,
			'modDetailPersediaan' => $modDetailPersediaan,
			'modelBayar' => $modelBayar,
			'modBuktiKeluar' => $modBuktiKeluar,
		));
	}

	/**
	 * method untuk save pembayaran ke supplier 
	 * digunakan di
	 * 1. keuangan/PembayaranKeSupplierUmum/index
	 * @param array $postBayarSupplier post request $_POST['KUBayarkesupplierT']
	 * @param obj $modBayar KUBayarkesupplierT
	 * @return object KUBayarkesupplierT
	 */
	protected function saveBayarSupplier($postBayarSupplier, $modBayar) {
		$format = new MyFormatter();
		$modBayar->attributes = $postBayarSupplier;
		$modBayar->tglbayarkesupplier = $format->formatDateTimeForDB($postBayarSupplier['tglbayarkesupplier']);
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
	 * 1. keuangan/PembayaranKeSupplierUmum/index
	 * @param array $postBuktiKeluar post request $_POST['KUTandaBuktiKeluarT']
	 * @param object $modBayarSupplier KUBayarSupplierT
	 * @param object $modBuktiKeluar KUTandaBuktiKeluarT
	 * @return object KUTandaBuktiKeluarT
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
		$modBuktiKeluar->nokaskeluar = MyGenerator::noKasKeluar();
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
		KUBayarkesupplierT::model()->updateByPk($modBayarSupplier->bayarkesupplier_id, array('tandabuktikeluar_id' => $modBuktiKeluar->tandabuktikeluar_id));
	}

	public function actionPrint($terimapersediaan_id) {
		$judulKuitansi = '----- Tanda Bukti Bayar Supplier -----';
		$format = new MyFormatter();
		$modTerimaPersediaan = KUTerimapersediaanT::model()->findByPk($terimapersediaan_id);
		$modDetailPersediaan = KUTerimapersdetailT::model()->findAllByAttributes(array('terimapersediaan_id' => $terimapersediaan_id));
		$modelBayar = KUBayarkesupplierT::model()->findByAttributes(array('terimapersediaan_id' => $terimapersediaan_id));
		$modBuktiKeluar = KUTandabuktikeluarT::model()->findByAttributes(array('bayarkesupplier_id' => $modelBayar->tandabuktikeluar_id));

		$caraPrint = isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null;
		if ($caraPrint == 'PRINT') {
			$this->layout = '//layouts/printWindows';
			$this->render('Print', array(
				'judulKuitansi' => $judulKuitansi,
				'caraPrint' => $caraPrint,
				'modBuktiKeluar' => $modBuktiKeluar,
				'modTerimaPersediaan' => $modTerimaPersediaan,
				'modDetailPersediaan' => $modDetailPersediaan,
				'modelBayar' => $modelBayar,
			));
		}
	}

}
