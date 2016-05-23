<?php

class FakturPembelianGUController extends MyAuthController {

	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout = '//layouts/column1';
	public $defaultAction = 'admin';
	protected $successSave = true;
	protected $pesan = "succes";

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id) {
		$this->render('view', array(
			'model' => $this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionIndex() {
		//if(!Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
		$model = new KUTerimapersediaanT;
		$modDetails = new TerimapersdetailT;
		$modFakturPembelian = new FakturpembelianT;

		$instalasi_id = Yii::app()->user->getState('instalasi_id');
		$modLogin = LoginpemakaiK::model()->findByAttributes(array('loginpemakai_id' => Yii::app()->user->id));
		$model->peg_penerima_id = $modLogin->pegawai_id;
		if (!empty($peg_penerima_id)) $model->peg_penerima_nama = $modLogin->pegawai->nama_pegawai;
		$model->ruanganpenerima_id = Yii::app()->user->getState('ruangan_id');
		$model->instalasi_id = $model->ruangan->instalasi_id;
		$model->tglterima = date('Y-m-d H:i:s');
		$model->tglsuratjalan = date('Y-m-d H:i:s');
		$model->tglfaktur = date('Y-m-d H:i:s');
		$model->tgljatuhtempo = date('Y-m-d H:i:s');
		$model->totalharga = 0;
		$model->discount = 0;
		$model->biayaadministrasi = 0;
		$model->pajakpph = 0;
		$model->pajakppn = 0;
		$model->supplier_id = isset($model->pembelianbarang->supplier_id) ? $model->pembelianbarang->supplier_id : null;
//        if(isset($model->supplier_id)){ echo "isset";exit; }else{ echo'else';exit; }
		if (isset($_POST['KUTerimapersediaanT'])) {

			$format = new MyFormatter();
			$model->attributes = $_POST['KUTerimapersediaanT'];
			$model->update_loginpemakai_id = $modLogin->loginpemakai_id;
			$model->update_time = date('Y-m-d H:i:s');
			$model->tglfaktur = $format->formatDateTimeForDB($model->tglfaktur);
			$model->tgljatuhtempo = $format->formatDateTimeForDB($model->tgljatuhtempo);
			$model->terimapersediaan_id = $_POST['terimapersediaan_id'];
			if ($model->validate()) {
				$transaction = Yii::app()->db->beginTransaction();
				try {
					$success = true;

					TerimapersediaanT::model()->updateByPk($model->terimapersediaan_id, array(
						'tglfaktur' => $model->tglfaktur,
						'nofaktur' => $model->nofaktur,
						'tgljatuhtempo' => $model->tgljatuhtempo,
						'totalharga' => $model->totalharga,
						'discount' => $model->discount,
						'biayaadministrasi' => $model->biayaadministrasi,
						'pajakpph' => $model->pajakpph,
						'pajakppn' => $model->pajakppn,
						'update_loginpemakai_id' => $model->update_loginpemakai_id,
						'update_time' => $model->update_time,
					));

					$modPembelianbarang = PembelianbarangT::model()->findByAttributes(array('terimapersediaan_id' => $model->terimapersediaan_id));
					$supplier_id = $modPembelianbarang->supplier_id;
//							  RND-9646
//                            $modFakturPembelian->terimapersediaan_id = $model->terimapersediaan_id;
//                            $modFakturPembelian->supplier_id    = $supplier_id;
//                            $modFakturPembelian->ruangan_id = Yii::app()->user->getState('ruangan_id');
//                            $modFakturPembelian->nofaktur   = $model->nofaktur;
//                            $modFakturPembelian->tglfaktur  = $model->tglfaktur;
//                            $modFakturPembelian->tgljatuhtempo  = $model->tgljatuhtempo;
//                            $modFakturPembelian->totharganetto  = $model->totalharga;
//                            $modFakturPembelian->persendiscount = $model->discount;
//                            $modFakturPembelian->jmldiscount    = ($model->discount/100) * $model->totalharga;
//                            $modFakturPembelian->biayamaterai   = $model->biayaadministrasi;
//                            $modFakturPembelian->totalpajakpph  = $model->pajakpph;
//                            $modFakturPembelian->totalpajakppn  = $model->pajakppn;
//                            $modFakturPembelian->totalhargabruto  = $modFakturPembelian->totharganetto - $modFakturPembelian->jmldiscount + $modFakturPembelian->biayamaterai + $modFakturPembelian->totalpajakpph + $modFakturPembelian->totalpajakppn;
//                            $modFakturPembelian->create_time = date('Y-m-d H:i:s');
//                            $modFakturPembelian->create_loginpemakai_id = Yii::app()->user->id;
//                            $modFakturPembelian->create_ruangan = Yii::app()->user->getState('ruangan_id');
//                            $modFakturPembelian->syaratbayar_id = 1;
//							echo json_encode($modFakturPembelian->validate());exit;
//
//                            $modFakturPembelian->save();

					$modDetails = $_POST['TerimapersdetailT'];

					foreach ($modDetails as $i => $data) {

						TerimapersdetailT::model()->updateByPk($data['terimapersdetail_id'], array(
							'hargabeli' => $data['hargabeli'],
							'hargasatuan' => $data['hargasatuan']
						));

//                                $modInven = new InventarisasiruanganT;
//                                $modInven->inventarisasi_id = $data['inventarisasi_id'];
//                                $modInven->inventarisasi_hargabeli = $data['hargabeli'];
//                                $modInven->inventarisasi_hargasatuan = $data['hargasatuan'];
//
//                                InventarisasiruanganT::model()->updateByPk($modInven->inventarisasi_id, array(
//                                    'inventarisasi_hargabeli'=>$modInven->inventarisasi_hargabeli,
//                                    'inventarisasi_hargasatuan'=>$modInven->inventarisasi_hargasatuan 
//                                ));
					}

//                            $modJurnalRekening = $this->saveJurnalRekening($model, $_POST['KUTerimapersediaanT']);
//                            $noUrut = 0;
//                            foreach($_POST['RekeningsupplierV'] AS $i => $post){
//                                $modJurnalDetail = $this->saveJurnalDetail($modJurnalRekening, $post, $noUrut, null);
//                                $noUrut ++;
//                            }

					if ($success == true) {
						$transaction->commit();
						Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
						if (isset($model->terimapersediaan_id)) {
							$this->redirect(array('index', 'id' => $model->terimapersediaan_id));
						} else {
							$this->refresh();
						}
					} else {
						$transaction->rollback();
						Yii::app()->user->setFlash('error', "Data gagal disimpan ");
					}
				} catch (Exception $ex) {
					$transaction->rollback();
					Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($ex, true));
				}
			}
		}


		$this->render('index', array(
			'model' => $model, 'modDetails' => $modDetails, 'modFakturPembelian' => $modFakturPembelian
		));
	}

	public function actionDynamicSupplier() {

		$supplier_id = (isset($_POST['KUTerimapersediaanT']['supplier_id']) ? $_POST['KUTerimapersediaanT']['supplier_id'] : null);
		$data = SupplierrekM::model()->findAllByAttributes(array('supplier_id' => $supplier_id));
		echo $supplier_id;
		echo $data[0]->saldonormal;
		exit;
	}

	protected function validasiTabular($model, $data) {
		$valid = true;
		foreach ($data as $i => $row) {
			$modDetails[$i] = new TerimapersdetailT();
			$modDetails[$i]->attributes = $row;
			$modDetails[$i]->terimapersediaan_id = $model->terimapersediaan_id;
			// if (isset($beli)){
			//     $modDetails[$i]->jmlbeli = $beli[$i]->jmlbeli;
			// }
			echo"<pre>";
			print_r($modDetails[$i]->attributes);

			$valid = $modDetails[$i]->validate() && $valid;
		}
		exit();
		return $modDetails;
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id) {
		//if(!Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
		$model = $this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed


		if (isset($_POST['GUTerimapersediaanT'])) {
			$model->attributes = $_POST['GUTerimapersediaanT'];
			if ($model->save()) {
				Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
				$this->redirect(array('view', 'id' => $model->terimapersediaan_id));
			}
		}

		$this->render('update', array(
			'model' => $model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id) {
		if (Yii::app()->request->isPostRequest) {
			// we only allow deletion via POST request
			//if(!Yii::app()->user->checkAccess(Params::DEFAULT_DELETE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
			$this->loadModel($id)->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if (!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		} else
			throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Lists all models.
	 */
//  public function actionIndex()
//  {
//      $dataProvider=new CActiveDataProvider('GUTerimapersediaanT');
//      $this->render('index',array(
//          'dataProvider'=>$dataProvider,
//      ));
//  }

	/**
	 * Manages all models.
	 */
	public function actionAdmin() {

		$model = new GUTerimapersediaanT('search');
		$model->unsetAttributes();  // clear any default values
		if (isset($_GET['GUTerimapersediaanT']))
			$model->attributes = $_GET['GUTerimapersediaanT'];

		$this->render('admin', array(
			'model' => $model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id) {
		$model = GUTerimapersediaanT::model()->findByPk($id);
		if ($model === null)
			throw new CHttpException(404, 'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model) {
		if (isset($_POST['ajax']) && $_POST['ajax'] === 'guterimapersediaan-t-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	/**
	 * Mengubah status aktif
	 * @param type $id 
	 */
	public function actionRemoveTemporary($id) {
		//if(!Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
		//SAKabupatenM::model()->updateByPk($id, array('kabupaten_aktif'=>false));
		//$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	public function actionInformasi() {
//                
		$model = new GUTerimapersediaanT('search');
//      $model->unsetAttributes();  // clear any default values
		$model->tglAwal = date('Y-m-d H:i:s');
		$model->tglAkhir = date('Y-m-d H:i:s');
		if (isset($_GET['GUTerimapersediaanT'])) {
			$model->attributes = $_GET['GUTerimapersediaanT'];
			$format = new MyFormatter();
			$model->tglAwal = $format->formatDateTimeForDB($model->tglAwal);
			$model->tglAkhir = $format->formatDateTimeForDB($model->tglAkhir);
		}

		$this->render('informasi', array(
			'model' => $model,
		));
	}

	public function actionDetailTerimaPersediaan($id) {
		$this->layout = 'frameDialog';
		$modTerima = TerimapersediaanT::model()->findByPk($id);
		$modDetailTerima = TerimapersdetailT::model()->findAllByAttributes(array('terimapersediaan_id' => $modTerima->terimapersediaan_id));
		$this->render('detailInformasi', array(
			'modTerima' => $modTerima,
			'modDetailTerima' => $modDetailTerima,
		));
	}

	public function actionPrint($id) {
		$this->layout = '//layouts/printWindows';
		$judulLaporan = 'Data Pembelian Barang';
		$modTerima = TerimapersediaanT::model()->findByPk($id);
		$modDetailTerima = TerimapersdetailT::model()->findAllByAttributes(array('terimapersediaan_id' => $modTerima->terimapersediaan_id));
		$this->render('detailInformasi', array(
			'judulLaporan' => $judulLaporan,
			'modTerima' => $modTerima,
			'modDetailTerima' => $modDetailTerima,
		));
	}

	public function actionReturPenerimaan($id) {
		$this->layout = 'frameDialog';
		$model = new ReturpenerimaanT();
		$modTerima = TerimapersediaanT::model()->find('terimapersediaan_id  = ' . $id . ' and returpenerimaan_id is null');
		$modDetailTerima = TerimapersdetailT::model()->findAll('terimapersediaan_id = ' . $id . ' and retpendetail_id is null');
		if ((count($modTerima) == 1) && (count($modDetailTerima) > 0)) {
			$model->tglreturterima = date('Y-m-d H:i:s');
			$model->terimapersediaan_id = $modTerima->terimapersediaan_id;
			$model->noreturterima = Generator::noReturTerima();
			$this->render('returPenerimaan', array(
				'model' => $model,
			));
		} else {
			echo 'Barang telah dibatal mutasikan';
		}
		if (isset($_POST['BatalmutasibrgT'])) {
			$modBatals = $this->validateTableBatal($_POST['BatalmutasibrgT']);
			$transaction = Yii::app()->db->beginTransaction();
			try {
				$success = true;
				$modBatals = $this->validateTableBatal($_POST['BatalmutasibrgT']);
				foreach ($modBatals as $i => $data) {
					if ($data->qty_batal > 0) {
						$modInventaris = InventarisasiruanganT::model()->findByAttributes(array('barang_id' => $data->barang_id), array('order' => 'tgltransaksi', 'limit' => 1));
						if ($data->save()) {
							InventarisasiruanganT::kembalikanStok($data->qty_batal, $data->barang_id);
							MutasibrgdetailT::model()->updateByPk($_POST['BatalmutasibrgT']['barang_id'][$i]['mutasibrgdetail_id'], array('batalmutasibrg_id' => $data->batalmutasibrg_id));
							InventarisasiruanganT::model()->updateAll(array('batalmutasibrg_id' => $data->batalmutasibrg_id), 'mutasibrgdetail_id = ' . $_POST['BatalmutasibrgT']['barang_id'][$i]['mutasibrgdetail_id'] . ' and barang_id = ' . $data->barang_id);
						} else {
							$success = false;
						}
					}
				}

				if ($success == true) {
					$transaction->commit();
					Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
					$this->refresh();
				} else {
					$transaction->rollback();
					Yii::app()->user->setFlash('error', "Data gagal disimpan ");
				}
			} catch (Exception $ex) {
				$transaction->rollback();
				Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($ex, true));
			}
		}
	}

	protected function saveJurnalRekening($modRetur, $postPenUmum) {
		$modJurnalRekening = new JurnalrekeningT;
		$modJurnalRekening->tglbuktijurnal = $modRetur->tglfaktur;
		$modJurnalRekening->nobuktijurnal = MyGenerator::noBuktiJurnalRek();
		$modJurnalRekening->kodejurnal = MyGenerator::kodeJurnalRek();
		$modJurnalRekening->noreferensi = 0;
		$modJurnalRekening->tglreferensi = $modRetur->tglfaktur;
		$modJurnalRekening->nobku = "";
		$modJurnalRekening->urianjurnal = "Pembelian " . $modRetur->nofaktur;
		$modJurnalRekening->jenisjurnal_id = Params::JURNAL_PENGELUARAN_KAS;
		$periodeID = Yii::app()->session['periodeID'];
		$modJurnalRekening->rekperiod_id = $periodeID[0];
		$modJurnalRekening->create_time = $modRetur->tglfaktur;
		$modJurnalRekening->create_loginpemakai_id = Yii::app()->user->id;
		$modJurnalRekening->create_ruangan = Yii::app()->user->getState('ruangan_id');

		if ($modJurnalRekening->validate()) {
			$modJurnalRekening->save();
			$this->successSave = true;
		} else {
			$this->successSave = false;
			$this->pesan = $modJurnalRekening->getErrors();
		}

		return $modJurnalRekening;
	}

	public function saveJurnalDetail($modJurnalRekening, $post, $noUrut = 0, $modJurnalPosting) {
		$modJurnalDetail = new JurnaldetailT();
		$modJurnalDetail->jurnalposting_id = ($modJurnalPosting == null ? null : $modJurnalPosting->jurnalposting_id);
		$modJurnalDetail->rekperiod_id = $modJurnalRekening->rekperiod_id;
		$modJurnalDetail->jurnalrekening_id = $modJurnalRekening->jurnalrekening_id;
		$modJurnalDetail->uraiantransaksi = $modJurnalRekening->urianjurnal;
		$modJurnalDetail->saldodebit = $post['saldodebit'];
		$modJurnalDetail->saldokredit = $post['saldokredit'];
		$modJurnalDetail->nourut = $noUrut;
		$modJurnalDetail->rekening1_id = $post['struktur_id'];
		$modJurnalDetail->rekening2_id = $post['kelompok_id'];
		$modJurnalDetail->rekening3_id = $post['jenis_id'];
		$modJurnalDetail->rekening4_id = $post['obyek_id'];
		$modJurnalDetail->rekening5_id = $post['rincianobyek_id'];
		$modJurnalDetail->catatan = "";

		if ($modJurnalDetail->validate()) {
			$modJurnalDetail->save();
		}
		return $modJurnalDetail;
	}

	//Pencarian Penerimaan Persediaan barang 
	public function actionGetPenerimaanPersediaan() {
		if (Yii::app()->request->isAjaxRequest) {
			$idTerimaPers = $_POST['idTerimaPers'];
			$modTerimaDetail = TerimapersdetailT::model()->findAllByAttributes(array('terimapersediaan_id' => $idTerimaPers));
			$tr = '';
			foreach ($modTerimaDetail as $key => $TerimaDetail) {
				$modBarang = BarangM::model()->with('bidang')->findByPk($TerimaDetail->barang_id);
				$modDetail = new TerimapersdetailT();
				$modDetail->barang_id = $TerimaDetail->barang_id;
				$modDetail->hargabeli = 0;
				$modDetail->hargasatuan = 0;
				$modDetail->jmldalamkemasan = $modBarang->barang_jmldlmkemasan;

				$tr .= $this->renderPartial('_detailPenerimaanPersediaanBarang', array('modBarang' => $modBarang, 'key' => $key, 'modDetail' => $modDetail), true);
			}

			echo json_encode($tr);
			Yii::app()->end();
		}
	}

}
