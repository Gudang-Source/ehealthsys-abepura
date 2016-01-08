<?php

class ReturPenerimaanKasController extends MyAuthController {

	protected $successSave = true;

	public function actionIndex() {
		if (!empty($_GET['frame']) && !empty($_GET['idPenerimaan'])) {

			$this->layout = '//layouts/iframe';
			$idPenerimaan = $_GET['idPenerimaan'];
			$modPenerimaan = KUPenerimaanUmumT::model()->findByPk($idPenerimaan);
			$modBuktiBayar = KUTandabuktibayarT::model()->findByPk($modPenerimaan->tandabuktibayar_id);

			$modBuktiKeluar = new KUTandabuktikeluarT;
			$modBuktiKeluar->tahun = date('Y');
			$modBuktiKeluar->namapenerima = isset($modBuktiBayar->darinama_bkm) ? $modBuktiBayar->darinama_bkm : "" ;
			$modBuktiKeluar->alamatpenerima = isset($modBuktiBayar->alamat_bkm) ? $modBuktiBayar->alamat_bkm : "";
			$modBuktiKeluar->untukpembayaran = 'Retur Tagihan Pasien';
			$modBuktiKeluar->nokaskeluar = MyGenerator::noKasKeluar();
			$modBuktiKeluar->jmlkaskeluar = $modPenerimaan->totalharga;
			$modRetur = new KUReturPenerimaanUmumT;
			$modRetur->penerimaanumum_id = $modPenerimaan->penerimaanumum_id;
			$modRetur->tandabuktibayar_id = $modPenerimaan->tandabuktibayar_id;
		} else {
			$modPenerimaan = new KUPenerimaanUmumT;
			$modBuktiBayar = new KUTandabuktibayarT;
		}

		if (isset($_POST['KUReturPenerimaanUmumT'])) {
			$idPenerimaan = $_POST['KUReturPenerimaanUmumT']['penerimaanumum_id'];
			$modPenerimaan = KUPenerimaanUmumT::model()->findByPk($idPenerimaan);
			$modBuktiBayar = KUTandabuktibayarT::model()->findByPk($modPenerimaan->tandabuktibayar_id);
			$transaction = Yii::app()->db->beginTransaction();
			try {
				$modRetur = $this->saveReturPenerimaan($_POST['KUReturPenerimaanUmumT']);
				$modBuktiKeluar = $this->saveBuktiKeluar($_POST['KUTandabuktikeluarT'], $modRetur);
				$this->updateTandaBuktiBayar($modPenerimaan->tandabuktibayar_id, $modRetur);

				$successSave = $this->successSave;
				if ($successSave) {
					$transaction->commit();
					Yii::app()->user->setFlash('success', "Data berhasil disimpan");
				} else {
					$transaction->rollback();
					Yii::app()->user->setFlash('error', "Data gagal disimpan ");
				}
			} catch (Exception $exc) {
				$transaction->rollback();
				Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
			}
		}

		$this->render('index', array('modPenerimaan' => $modPenerimaan,
			'modBuktiBayar' => $modBuktiBayar,
			'modBuktiKeluar' => $modBuktiKeluar,
			'modRetur' => $modRetur));
	}

	protected function saveReturPenerimaan($postRetur) {
		$format = new MyFormatter();
		$modRetur = new KUReturPenerimaanUmumT;
		$modRetur->attributes = $postRetur;
				

		$modRetur->tglreturumum = $format->formatDateTimeForDb($postRetur['tglreturumum']);

		$modRetur->ruangan_id = Yii::app()->user->getState('ruangan_id');
		if ($modRetur->validate()) {
			$modRetur->save();
			$this->successSave = $this->successSave && true;
		} else {
			$this->successSave = false;
		}

		return $modRetur;
	}

	protected function saveBuktiKeluar($postBuktiKeluar, $modRetur) {
		$modBuktiKeluar = new KUTandabuktikeluarT;
		$modBuktiKeluar->attributes = $postBuktiKeluar;

		$modBuktiKeluar->ruangan_id = Yii::app()->user->getState('ruangan_id');
		$modBuktiKeluar->tglkaskeluar = $modRetur->tglreturumum;
		$modBuktiKeluar->shift_id = Yii::app()->user->getState('shift_id');
		$modBuktiKeluar->create_time = date('Y-m-d H:i:s');
		$modBuktiKeluar->create_loginpemakai_id = Yii::app()->user->id;
		$modBuktiKeluar->create_ruangan = Yii::app()->user->getState('ruangan_id');

		if ($modBuktiKeluar->validate()) {
			$modBuktiKeluar->save();
			$this->successSave = $this->successSave && true;
		} else {
			$this->successSave = false;
		}

		return $modBuktiKeluar;
	}

	protected function updateTandaBuktiBayar($idBuktiBayar, $modRetur) {
		KUTandabuktibayarT::model()->updateByPk($idBuktiBayar, array('returpenerimaanumum_id' => $modRetur->returpenerimaanumum_id));
	}

	public function actionCekLogin($task = 'Retur') {
		if (Yii::app()->request->isAjaxRequest) {
			$username = $_POST['username'];
			$password = $_POST['password'];
			$idRuangan = Yii::app()->user->getState('ruangan_id');

			$user = LoginpemakaiK::model()->findByAttributes(array('nama_pemakai' => $username,
				'loginpemakai_aktif' => TRUE));
			if ($user === null) {
				$data['error'] = "Login Pemakai salah!";
				$data['cssError'] = 'username';
				$data['status'] = 'Gagal Login';
			} else {
				// cek password
				if ($user->katakunci_pemakai !== $user->encrypt($password)) {
					$data['error'] = 'password salah!';
					$data['cssError'] = 'password';
					$data['status'] = 'Gagal Login';
				} else {
					// cek ruangan
					$ruangan_user = RuanganpemakaiK::model()->findByAttributes(array('loginpemakai_id' => $user->loginpemakai_id,
						'ruangan_id' => $idRuangan));
					if ($ruangan_user === null) {
						$data['error'] = 'ruangan salah!';
						$data['status'] = 'Gagal Login';
					} else {
						$data['error'] = '';
						$cek = $this->checkAccess(array('loginpemakai_id' => $user->loginpemakai_id)); //dari myAuthController
						if ($cek) {
							$data['status'] = 'success';
							$data['userid'] = $user->loginpemakai_id;
							$data['username'] = $user->nama_pemakai;
						} else {
							$data['status'] = 'Anda tidak memiliki hak melakukan proses ini!';
						}
					}
				}
			}

			echo json_encode($data);
			Yii::app()->end();
		}
	}

}
