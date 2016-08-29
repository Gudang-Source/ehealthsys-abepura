<?php

Yii::import('keuangan.models.*');
class PembayaranSupplierController extends MyAuthController {

	protected $successSave;
        public $path_view = "billingKasir.views.pembayaranSupplier.";

	/**
	 * pembayaran ke supplier
	 * di gunakan :
	 * 1. billingKasir -> informasi Faktur Pembelian -> bayar ke supplier 
	 */
	public function actionIndex($frame = null, $idFakturPembelian = null, $id = null) {
            
		if (!empty($frame) && !empty($idFakturPembelian)) {
                        
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
		} else if (!empty($id)) {
                        $modelBayar = BKBayarkeSupplierT::model()->findByPk($id);
                        $modFakturBeli = BKFakturPembelianT::model()->findByPk($modelBayar->fakturpembelian_id);
                        $modDetailBeli = BKFakturDetailT::model()->findAllByAttributes(array('fakturpembelian_id'=>$modelBayar->fakturpembelian_id));
                        $modBuktiKeluar = BKTandabuktikeluarT::model()->findByPk($modelBayar->tandabuktikeluar_id);
                        $modUangMuka = new BKUangMukaBeliT;
                } else {
			$modFakturBeli = new BKFakturPembelianT;
			$modDetailBeli = array();
			$modUangMuka = new BKUangMukaBeliT;
			$modelBayar = new BKBayarkeSupplierT;
			$modBuktiKeluar = new BKTandabuktikeluarT;
			$modBuktiKeluar->tahun = date('Y');
		}

		if (isset($_POST['BKBayarkeSupplierT']) && (!isset($modFakturBeli->bayarkesupplier_id))) {
			$transaction = Yii::app()->db->beginTransaction();
			try {
                                $uangMuka = $_POST['BKUangMukaBeliT']['jumlahuang'];
				$modelBayar = $this->saveBayarSupplier($_POST['BKBayarkeSupplierT'], $modelBayar);
				$modBuktiKeluar = $this->saveBuktiKeluar($_POST['BKTandabuktikeluarT'], $modelBayar, $modBuktiKeluar);
				$this->updateBayarSupplier($modelBayar, $modBuktiKeluar);
				$sisa = ($modelBayar->totaltagihan - $modelBayar->jmldibayarkan - $uangMuka);
				if ($sisa < 1) {
					$update = FakturpembelianT::model()->updateByPk($modelBayar->fakturpembelian_id, array('bayarkesupplier_id' => $modelBayar->bayarkesupplier_id));
				}
                                
				if ($this->successSave) {
					$transaction->commit();
					Yii::app()->user->setFlash('success', "Data berhasil disimpan");
                                        if (empty($frame)){
                                            $this->redirect(array('index', 'id'=>$modelBayar->bayarkesupplier_id));                                            
                                        }else{
                                            $this->redirect(array('index','frame'=>1,'idFakturPembelian'=>$modelBayar->fakturpembelian_id ,'id'=>$modelBayar->bayarkesupplier_id));
                                        }
				} else {
					Yii::app()->user->setFlash('error', "Data gagal disimpan ");
					$transaction->rollback();
				}
			} catch (Exception $exc) {
				Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
				$transaction->rollback();
			}
		}

		$this->render($this->path_view.'index', array(
                        'modFakturBeli' => $modFakturBeli,
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

	public function actionPrint($id) {
		$judulKuitansi = '----- Tanda Bukti Bayar Hutang -----';
		$format = new MyFormatter();
                $modelBayar = BKBayarkeSupplierT::model()->findByPk($id);
		$modFakturBeli = BKFakturPembelianT::model()->findByPk($modelBayar->fakturpembelian_id);
		$modDetailBeli = BKFakturDetailT::model()->findAllByAttributes(array('fakturpembelian_id' => $modelBayar->fakturpembelian_id));
		$modelBayar = BKBayarkeSupplierT::model()->findByAttributes(array('fakturpembelian_id' => $modelBayar->fakturpembelian_id));
		$modBuktiKeluar = BKTandabuktikeluarT::model()->findByPk($modelBayar->tandabuktikeluar_id);
		$modUangMuka = BKUangMukaBeliT::model()->findByAttributes(array('penerimaanbarang_id' => $modFakturBeli->penerimaanbarang_id));

		$caraPrint = isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null;
		if ($caraPrint == 'PRINT') {
			$this->layout = '//layouts/printWindows';
			$this->render($this->path_view.'Print', array(
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
        
        
        public function actionAutocompleteFakturFarmasi($no_faktur)
        {
            if(Yii::app()->request->isAjaxRequest) {
                $dat = new BKInformasifakturpembelianV;
                $dat->nofaktur = $no_faktur;
                $prov = $dat->searchInformasiUmum();
                
                $returnVal = array();
                foreach($prov->data as $i=>$item) {
                    $returnVal[$i]['label'] = $item->nofaktur.' - '.$item->supplier_nama.' - '.  MyFormatter::formatDateTimeForUser($item->tglfaktur);
                    $returnVal[$i]['value'] = $item->fakturpembelian_id;
                    $returnVal[$i]['label2'] = $item->nofaktur;
                }
                
                echo CJSON::encode($returnVal);
            }
            Yii::app()->end();
        }
        
        public function actionLoadFakturFarmasi()
        {
            if(Yii::app()->request->isAjaxRequest) {
                $fakturpembelian_id = $_POST['id'];
                $modelBayar = new BKBayarkeSupplierT;
		$modBuktiKeluar = new BKTandabuktikeluarT;
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
                
                $uangMuka = MyFormatter::formatNumberForPrint($uangMuka);
                
                $modFakturBeli->tglfaktur = MyFormatter::formatDateTimeForUser($modFakturBeli->tglfaktur);
                $modFakturBeli->tgljatuhtempo = MyFormatter::formatDateTimeForUser($modFakturBeli->tgljatuhtempo);
                $modFakturBeli->totalhargabruto = MyFormatter::formatNumberForPrint($modFakturBeli->totalhargabruto);
                
                $modelBayar->totaltagihan = MyFormatter::formatNumberForPrint($modelBayar->totaltagihan);
                $modelBayar->jmldibayarkan = MyFormatter::formatNumberForPrint($modelBayar->jmldibayarkan);
                
                $modBuktiKeluar->jmlkaskeluar = MyFormatter::formatNumberForPrint($modBuktiKeluar->jmlkaskeluar);
                
                $penerimaan = PenerimaanbarangT::model()->findByPk($modFakturBeli->penerimaanbarang_id);
                
                $res = array(
                    'modelBayar'=>$modelBayar->attributes,
                    'buktiKeluar'=>$modBuktiKeluar->attributes,
                    'uangMukaDat'=>$modUangMuka->attributes,
                    'uangMuka'=>$uangMuka,
                    'penerimaan'=>$penerimaan->attributes,
                    'fakturBeli'=>$modFakturBeli->attributes,
                    'tabFaktur'=>$this->renderPartial($this->path_view.'_rowFaktur', array('modDetailBeli'=>$modDetailBeli), true),
                );
                
                if (!empty($modFakturBeli->supplier_id)) {
                    $res['supplier'] = $modFakturBeli->supplier->attributes;
                } else {
                    $res['supplier'] = '';
                }
                
                if (isset($modFakturBeli->penerimaanbarang->permintaanpembelian->nopermintaan)) {
                    $res['nopermintaan'] = $modFakturBeli->penerimaanbarang->permintaanpembelian->nopermintaan;
                } else {
                    $res['nopermintaan'] = '';
                }
                echo CJSON::encode($res);
            }
            Yii::app()->end();
        }

}
