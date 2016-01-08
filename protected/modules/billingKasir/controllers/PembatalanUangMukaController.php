<?php

class PembatalanUangMukaController extends MyAuthController {

	protected $successSave = true;

	public function actionIndex() {
		$frame = array();
		if (!empty($_GET['frame'])) {
//                $this->layout = 'iframe';
			$this->layout = '//layouts/iframe';
			$frame['frame'] = '1';
		}

		$modBatal = new BKPembatalanUangmukaT;
		$modPendaftaran = new BKPendaftaranT;
		$modPasien = new BKPasienM;
		$modBuktiKeluar = new BKTandabuktikeluarT;
		$modBuktiKeluar->tahun = date('Y');
		$modBuktiKeluar->untukpembayaran = 'Pembatalan Uang Muka';
		$modBuktiKeluar->nokaskeluar = MyGenerator::noKasKeluar();
		$modBuktiKeluar->biayaadministrasi = 0;
		$pemakaianUangMuka = new BKPemakaianuangmukaT;
		$successSave = true;

		$is_dialog = false;
		// pengecekan jika request dari iframe
		if (!empty($_GET['idBayarUangMuka']) && !isset($_POST['BKPembatalanUangmukaT'])) {
			$modUangMuka = BKBayaruangmukaT::model()->findByPk($_GET['idBayarUangMuka']);
			if (!empty($modUangMuka->pembatalanuangmuka_id)) {
				$modBatal = BKPembatalanUangmukaT::model()->findByPk($modUangMuka->pembatalanuangmuka_id);
			}
			$modPendaftaran = BKPendaftaranT::model()->findByPk($modUangMuka->pendaftaran_id);
			$modPasien = BKPasienM::model()->findByPk($modUangMuka->pasien_id);

			$modBuktiKeluar->jmlkaskeluar = $modUangMuka->jumlahuangmuka;
			$modBuktiKeluar->namapenerima = $modPasien->nama_pasien;
			$modBuktiKeluar->alamatpenerima = $modPasien->alamat_pasien;
			$modBatal->tandabuktibayar_id = $modUangMuka->tandabuktibayar_id;
			$cekPemakaianUangMuka = BKPemakaianuangmukaT::model()->findByPk($modUangMuka->pemakaianuangmuka_id);

			if ($cekPemakaianUangMuka) {
				$pemakaianUangMuka = $cekPemakaianUangMuka;
				$modBuktiKeluar->jmlkaskeluar = $pemakaianUangMuka->sisauangmuka;
				$modBuktiKeluar->untukpembayaran = 'Pengembalian Uang Muka';
				$modBatal->keterangan_batal = 'Kelebihan uang muka dipembayaran kasir';
			}
			$is_dialog = true;
		}
		if (isset($_POST['BKPembatalanUangmukaT']) && !empty($_POST['BKPendaftaranT']['pendaftaran_id'])) {

			$modPendaftaran = BKPendaftaranT::model()->findByPk($_POST['BKPendaftaranT']['pendaftaran_id']);
			$modPasien = BKPasienM::model()->findByPk($_POST['BKPendaftaranT']['pasien_id']);

			$transaction = Yii::app()->db->beginTransaction();
			try {
				$cekUangMuka = BKBayaruangmukaT::model()->findByPk(
						$_POST['BKPembatalanUangmukaT']['bayaruangmuka_id']
				);

				$is_pengembalian = true;
				if ($cekUangMuka) {
					$modUangMuka = $cekUangMuka;
				}
				if ($cekUangMuka) {
					if (empty($cekUangMuka->pemakaianuangmuka_id) || !empty($cekUangMuka->pemakaianuangmuka_id)) {
						$is_pengembalian = true;
					}
				}

				if ($is_pengembalian == true) {
					$format = new MyFormatter();
					$this->successSave = false;
					$modBuktiKeluar = new BKTandabuktikeluarT;
					$modBuktiKeluar->attributes = $_POST['BKTandabuktikeluarT'];
					$modBuktiKeluar->tglkaskeluar = $format->formatDateTimeForDb($_POST['BKPembatalanUangmukaT']['tglpembatalan']);
					$modBuktiKeluar->keterangan_pengeluaran = $_POST['BKPembatalanUangmukaT']['keterangan_batal'];
					$modBuktiKeluar->ruangan_id = Yii::app()->user->getState('ruangan_id');
					$modBuktiKeluar->tahun = date('Y');
					$modBuktiKeluar->jmlkaskeluar = $_POST['BKTandabuktikeluarT']['jmlkaskeluar'];
					$modBuktiKeluar->shift_id = Yii::app()->user->getState('shift_id');
					$modBuktiKeluar->create_loginpemakai_id = Yii::app()->user->getState('pegawai_id');
					$modBuktiKeluar->create_ruangan = Yii::app()->user->getState('ruangan_id');
					$modBuktiKeluar->create_time = date('Y-m-d');
					if ($modBuktiKeluar->save()) {
						if (count(isset($cekUangMuka->jumlahuangmuka) ? $cekUangMuka->jumlahuangmuka : null) > 0) {
							$cekUangMuka->jumlahuangmuka = $_POST['BKTandabuktikeluarT']['jmlkaskeluar'];
						}
						if ((isset($cekUangMuka->keteranganuangmuka) ? $cekUangMuka->keteranganuangmuka : '') != '') {
							$cekUangMuka->keteranganuangmuka = $_POST['BKTandabuktikeluarT']['keterangan_batal'];
						}
						// $cekUangMuka->keteranganuangmuka = $_POST['BKTandabuktikeluarT']['keterangan_batal'];		

						if ($cekUangMuka->save()) {
							if (empty($cekUangMuka->pemakaianuangmuka_id)) {
								$modBatal = $this->savePembatalanUangMuka($_POST['BKPembatalanUangmukaT']);
								$modBuktiKeluar = $this->saveTandaBuktiKeluar($modBatal, $_POST['BKTandabuktikeluarT']);

								$this->updateBayarUangMuka($modBatal);
								$this->updateTandaBuktiBayar($modBatal);
								$this->successSave = true;
							} else {
								$pemakaianUangMuka = BKPemakaianuangmukaT::model()->findByPk(
										$cekUangMuka->pemakaianuangmuka_id
								);
								$pemakaianUangMuka->tandabuktikeluar_id = $modBuktiKeluar->tandabuktikeluar_id;
								if ($pemakaianUangMuka->save()) {
									$modBatal = $this->savePembatalanUangMuka($_POST['BKPembatalanUangmukaT']);
									$modBuktiKeluar = $this->saveTandaBuktiKeluar($modBatal, $_POST['BKTandabuktikeluarT']);

									$this->updateBayarUangMuka($modBatal);
									$this->updateTandaBuktiBayar($modBatal);
									$this->successSave = true;
								}
							}
						}
					}
				} else {

					$modBatal = $this->savePembatalanUangMuka($_POST['BKPembatalanUangmukaT']);
					$modBuktiKeluar = $this->saveTandaBuktiKeluar($modBatal, $_POST['BKTandabuktikeluarT']);

					$this->updateBayarUangMuka($modBatal);
					$this->updateTandaBuktiBayar($modBatal);
				}

				$successSave = $this->successSave;
				if ($successSave) {
					$transaction->commit();
					Yii::app()->user->setFlash('success', "Data berhasil disimpan");
//						$this->redirect(array('index','idBayarUangMuka'=>$modUangMuka->bayaruangmuka_id,'sukses'=>'1',$frame));
				} else {
					$transaction->rollback();
					Yii::app()->user->setFlash('error', "Data gagal disimpan ");
				}
			} catch (Exception $exc) {
				$transaction->rollback();
				Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
			}
		}

		$this->render('index', array(
			'modPendaftaran' => $modPendaftaran,
			'modPasien' => $modPasien,
			'modBuktiKeluar' => $modBuktiKeluar,
			'modBatal' => $modBatal,
			'successSave' => $successSave,
			'is_dialog' => $is_dialog
				)
		);
	}

	protected function savePembatalanUangMuka($postPembatalan) {
		$modBatal = new BKPembatalanUangmukaT;
		$modBatal->attributes = $postPembatalan;
		$modBatal->ruangan_id = Yii::app()->user->ruangan_id;
		$modBatal->create_ruangan = Yii::app()->user->ruangan_id;
		$modBatal->create_time = date('Y-m-d');
		if ($modBatal->validate()) {
			$modBatal->save();
			$this->successSave = $this->successSave && true;
		} else {
			$this->successSave = false;
		}

		return $modBatal;
	}

	protected function saveTandaBuktiKeluar($modPembatalan, $postBuktiKeluar) {
		$modBuktiKeluar = new BKTandabuktikeluarT;
		$modBuktiKeluar->tglkaskeluar = $modPembatalan->tglpembatalan;
		$modBuktiKeluar->keterangan_pengeluaran = $modPembatalan->keterangan_batal;
		$modBuktiKeluar->attributes = $postBuktiKeluar;
		$modBuktiKeluar->ruangan_id = Yii::app()->user->getState('ruangan_id');
		$modBuktiKeluar->tahun = date('Y');
		$modBuktiKeluar->jmlkaskeluar = str_replace(',', '', $_POST['BKTandabuktikeluarT']['jmlkaskeluar']);
		if ($modBuktiKeluar->validate()) {
			$modBuktiKeluar->save();
			$this->updatePembatalan($modPembatalan->pembatalanuangmuka_id, $modBuktiKeluar);
			$this->successSave = $this->successSave && true;
		} else {
			$this->successSave = false;
		}

		return $modBuktiKeluar;
	}

	protected function updateTandaBuktiBayar($modPembatalan) {
		TandabuktibayarT::model()->updateByPk(
				$modPembatalan->tandabuktibayar_id, array(
			'pembatalanuangmuka_id' => $modPembatalan->pembatalanuangmuka_id
				)
		);
	}

	protected function updateBayarUangMuka($modPembatalan) {
		BKBayaruangmukaT::model()->updateByPk(
				$modPembatalan->bayaruangmuka_id, array(
			'pembatalanuangmuka_id' => $modPembatalan->pembatalanuangmuka_id
				)
		);
	}

	protected function updatePembatalan($idPembatalan, $modBuktiKeluar) {
		BKPembatalanUangmukaT::model()->updateByPk(
				$idPembatalan, array(
			'tandabuktikeluar_id' => $modBuktiKeluar->tandabuktikeluar_id
				)
		);
	}

	public function actionDaftarPasienBatalUangMuka($nama = false) {
		if (Yii::app()->request->isAjaxRequest) {
			$criteria = new CDbCriteria();
			$criteria->with = array('pasien', 'pendaftaran', 'ruangan');
			if ($nama) {
				$criteria->compare('LOWER(pasien.nama_pasien)', strtolower($_GET['term']), true);
			} else {
				$criteria->compare('LOWER(pasien.no_rekam_medik)', strtolower($_GET['term']), true);
			}
			$criteria->addCondition('pembatalanuangmuka_id IS NULL');
			$criteria->order = 'tgluangmuka DESC';
			$models = BayaruangmukaT::model()->findAll($criteria);
			$returnVal = array();
			foreach ($models as $i => $model) {
				$attributes = $model->attributeNames();
				foreach ($attributes as $j => $attribute) {
					$returnVal[$i]["$attribute"] = $model->$attribute;
				}
				if ($nama) {
					$returnVal[$i]['label'] = $model->pasien->nama_pasien . ' - ' . $model->ruangan->ruangan_nama . ' - ' . $model->tgluangmuka;
					$returnVal[$i]['value'] = $model->pasien->nama_pasien;
					$returnVal[$i]['norekammedik'] = $model->pasien->no_rekam_medik;
				} else {
					$returnVal[$i]['label'] = $model->pasien->no_rekam_medik . ' - ' . $model->ruangan->ruangan_nama . ' - ' . $model->tgluangmuka;
					$returnVal[$i]['value'] = $model->pasien->no_rekam_medik;
				}
				$returnVal[$i]['jeniskelamin'] = $model->pasien->jeniskelamin;
				$returnVal[$i]['namapasien'] = $model->pasien->nama_pasien;
				$returnVal[$i]['namabin'] = $model->pasien->nama_bin;
				$returnVal[$i]['alamatpasien'] = $model->pasien->alamat_pasien;
				$returnVal[$i]['jeniskasuspenyakit'] = $model->pendaftaran->jeniskasuspenyakit->jeniskasuspenyakit_nama;
				$returnVal[$i]['namainstalasi'] = $model->pendaftaran->instalasi->instalasi_nama;
				$returnVal[$i]['namaruangan'] = $model->ruangan->ruangan_nama;
				$returnVal[$i]['tglpendaftaran'] = $model->pendaftaran->tgl_pendaftaran;
				$returnVal[$i]['nopendaftaran'] = $model->pendaftaran->no_pendaftaran;
				$returnVal[$i]['umur'] = $model->pendaftaran->umur;
				$returnVal[$i]['tandabuktibayar_id'] = $model->tandabuktibayar_id;
				$returnVal[$i]['bayaruangmuka_id'] = $model->bayaruangmuka_id;
				$returnVal[$i]['carabayar_nama'] = $model->pendaftaran->carabayar->carabayar_nama;
				$returnVal[$i]['penjamin_nama'] = $model->pendaftaran->penjamin->penjamin_nama;
				$returnVal[$i]['norekammedik'] = $model->pasien->no_rekam_medik;
			}

			echo CJSON::encode($returnVal);
		}
		Yii::app()->end();
	}

	// Uncomment the following methods and override them if needed
	/*
	  public function filters()
	  {
	  // return the filter configuration for this controller, e.g.:
	  return array(
	  'inlineFilterName',
	  array(
	  'class'=>'path.to.FilterClass',
	  'propertyName'=>'propertyValue',
	  ),
	  );
	  }

	  public function actions()
	  {
	  // return external action classes, e.g.:
	  return array(
	  'action1'=>'path.to.ActionClass',
	  'action2'=>array(
	  'class'=>'path.to.AnotherActionClass',
	  'propertyName'=>'propertyValue',
	  ),
	  );
	  }
	 */
}
