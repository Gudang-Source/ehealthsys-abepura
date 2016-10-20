<?php

class VerifikasiAskepController extends MyAuthController {

	protected $successSave = true;
	public $path_view = "asuhanKeperawatan.views.verifikasiAskep.";

	public function actionIndex() {
		if (isset($_GET['frame'])) {
			$this->layout = "//layouts/iframe";
		}
		$model = new ASVerifikasiaskepT;
		$modPengkajian = new ASPengkajianaskepT;
		$modPenunjang = new ASDatapenunjangT;
		$modRencana = new ASRencanaaskepT;
		$modRencanaDet = new ASRencanaaskepdetT;
		$modPilihRencana = new ASPilihrencanaaskepT;
		$modImplementasi = new ASImplementasiaskepT;
		$modImplementasiDet = new ASImplementasiaskepdetT;
		$modPilihImpl = new ASPilihimplementasiaskepT;
		$modEvaluasi = new ASEvaluasiaskepT;
		$modEvaluasiDet = new ASEvaluasiaskepdetT;
		$modPendaftaran = new ASPendaftaranT;
		$modPenanggungJawab = new ASPenanggungjawabM;
		$modRiwayatAnemnesa = new ASAnamnesaT;
		$modPeriksaFisik = new ASPemeriksaanfisikT;
		$modPasien = new ASInfopengkajianaskepV;
		$model->verifikasiaskep_tgl = MyFormatter::formatDateTimeForUser(date('Y-m-d H:i:s'));
		$model->verifikasiaskep_no = "- Otomatis -";
                $model->ruangan_id = Yii::app()->user->getState('ruangan_id');

		$nama_modul = Yii::app()->controller->module->id;
		$nama_controller = Yii::app()->controller->id;
		$nama_action = Yii::app()->controller->action->id;
		$modul_id = ModulK::model()->findByAttributes(array('url_modul' => $nama_modul))->modul_id;

		$url_batal = Yii::app()->createAbsoluteUrl(
				Yii::app()->controller->module->id . '/' . Yii::app()->controller->id
		);
		$successSave = false;

		if (isset($_GET['verifikasiaskep_id'])) {
			$model = ASVerifikasiaskepT::model()->findByPk($_GET['verifikasiaskep_id']);
			$modPengkajian = ASPengkajianaskepT::model()->findByPk($model->pengkajianaskep_id);
//			$modPenunjang = new ASDatapenunjangT;
//			$modRencana = new ASRencanaaskepT;
//			$modRencanaDet = new ASRencanaaskepdetT;
//			$modPilihRencana = new ASPilihrencanaaskepT;
//			$modImplementasi = new ASImplementasiaskepT;
//			$modImplementasiDet = new ASImplementasiaskepdetT;
//			$modPilihImpl = new ASPilihimplementasiaskepT;
//			$modEvaluasi = new ASEvaluasiaskepT;
//			$modEvaluasiDet = new ASEvaluasiaskepdetT;
			$modPendaftaran = ASPendaftaranT::model()->findByPk($modPengkajian->pendaftaran_id);
//			$modPenanggungJawab = new ASPenanggungjawabM;
//			$modRiwayatAnemnesa = new ASAnamnesaT;
//			$modPeriksaFisik = new ASPemeriksaanfisikT;
			if ($modPengkajian->iskeperawatan == 1) {
				$modPasien = ASInfopengkajianaskepV::model()->findByAttributes(array('pengkajianaskep_id' => $model->pengkajianaskep_id));
			} else {
				$modPasien = ASInfopengkajiankebidananV::model()->findByAttributes(array('pengkajianaskep_id' => $model->pengkajianaskep_id));
			}
		}
//		echo "<pre>";
//		print_r($_POST);
//		echo "</pre>";
//		exit;
		if (isset($_POST['ASVerifikasiaskepT']) && !empty($_POST['ASPengkajianaskepT']['pengkajianaskep_id'])) {
			$transaction = Yii::app()->db->beginTransaction();
			try {

				$model = new ASVerifikasiaskepT;
				$model->attributes = $_POST['ASVerifikasiaskepT'];
				$model->verifikasiaskep_tgl = MyFormatter::formatDateTimeForDb($_POST['ASVerifikasiaskepT']['verifikasiaskep_tgl']);
				$model->verifikasiaskep_no = MyGenerator::noVerifikasiKeperawatan();
				$model->pendaftaran_id = $_POST['ASPengkajianaskepT']['pendaftaran_id'];
				$model->pengkajianaskep_id = $_POST['ASPengkajianaskepT']['pengkajianaskep_id'];
				$model->rencanaaskep_id = !empty($_POST['ASRencanaaskepT']['rencanaaskep_id']) ? $_POST['ASRencanaaskepT']['rencanaaskep_id'] : null;
				$model->implementasiaskep_id = !empty($_POST['ASImplementasiaskepT']['implementasiaskep_id']) ? $_POST['ASImplementasiaskepT']['implementasiaskep_id'] : null;
				$model->evaluasiaskep_id = !empty($_POST['ASEvaluasiaskepT']['evaluasiaskep_id']) ? $_POST['ASEvaluasiaskepT']['evaluasiaskep_id'] : null;
				$model->create_ruangan = Yii::app()->user->ruangan_id;
				$model->create_time = date('Y-m-d');
				$model->create_loginpemakai_id = Yii::app()->user->id;
				$model->ruangan_id = Yii::app()->user->ruangan_id;
                              //  var_dump($model->pengkajianaskep_id);die;
				if ($model->save()) {
					$this->successSave = $this->successSave && true;

					if (isset($_POST['ASPengkajianaskepT'])) {

						$modPengkajian = ASPengkajianaskepT::model()->findByPk($_POST['ASPengkajianaskepT']['pengkajianaskep_id']);
						$modPengkajian->attributes = $_POST['ASPengkajianaskepT'];
						$modPengkajian->pegawai_id = $_POST['ASPengkajianaskepT']['pegawai_id'];
						
						if(!empty($_POST['ASPengkajianaskepT']['no_pengkajian'])){
							$modPengkajian->no_pengkajian = $_POST['ASPengkajianaskepT']['no_pengkajian'];
						}
						
						if(!empty($_POST['ASPengkajianaskepT']['no_pengkajian_keb'])){
							$modPengkajian->no_pengkajian = $_POST['ASPengkajianaskepT']['no_pengkajian_keb'];
						}
						
						$modPengkajian->pengkajianaskep_tgl = MyFormatter::formatDateTimeForDb($_POST['ASPengkajianaskepT']['pengkajianaskep_tgl']);
						if ($_POST['iskeperawatan'] == 0) {
							$modPengkajian->iskeperawatan = 1;
						} else {
							$modPengkajian->iskeperawatan = 0;
						}
						$modPengkajian->update_time = date('Y-m-d');
						$modPengkajian->update_loginpemakai_id = Yii::app()->user->id;

						if ($modPengkajian->save()) {
							$this->successSave = $this->successSave && true;
						} else {
							$this->successSave = false;
						}

						if (isset($_POST['ASDatapenunjangT'])) {

							//save rencana detail

							foreach ($_POST['ASDatapenunjangT'] as $i => $row) {
								if (!empty($row['datapenunjang_id'])) {
									$modPenunjang = ASDatapenunjangT::model()->findByPk($row['datapenunjang_id']);
									$modPenunjang->attributes = $row;
									$modPenunjang->datapenunjang_tgl = MyFormatter::formatDateTimeForDb($row['datapenunjang_tgl']);
									$modPenunjang->datapenunjang_nama = $row['datapenunjang_nama'];
								} else {
									$modPenunjang = new ASDatapenunjangT;
									$modPenunjang->attributes = $row;
									$modPenunjang->pengkajianaskep_id = $_POST['ASPengkajianaskepT']['pengkajianaskep_id'];
									$modPenunjang->datapenunjang_tgl = MyFormatter::formatDateTimeForDb($row['datapenunjang_tgl']);
									$modPenunjang->datapenunjang_nama = $row['datapenunjang_nama'];
								}
								
								if ($modPenunjang->validate()) {
									$modPenunjang->save();
									$this->successSave = $this->successSave && true;
								} else {
									$this->successSave = false;
								}
							}
						}
					}

					if (isset($_POST['ASRencanaaskepT'])) {
						//save rencana
						if (!empty($_POST['ASRencanaaskepT']['rencanaaskep_id'])) {
							$modRencana = ASRencanaaskepT::model()->findByPk($_POST['ASRencanaaskepT']['rencanaaskep_id']);
							$modRencana->attributes = $_POST['ASRencanaaskepT'];
							$modRencana->pegawai_id = $_POST['ASRencanaaskepT']['pegawai_id'];
							$modRencana->rencanaaskep_tgl = MyFormatter::formatDateTimeForDb($_POST['ASRencanaaskepT']['rencanaaskep_tgl']);
							$modRencana->update_time = date('Y-m-d');
							$modRencana->update_loginpemakai_id = Yii::app()->user->id;
						} else {
							$modRencana = new ASRencanaaskepT;
							$modRencana->attributes = $_POST['ASRencanaaskepT'];
							$modRencana->no_rencana = MyGenerator::noRencanaKeperawatan();
							$modRencana->rencanaaskep_tgl = MyFormatter::FormatDateTimeForDb($_POST['ASRencanaaskepT']['rencanaaskep_tgl']);
							$modRencana->pengkajianaskep_id = $_POST['ASPengkajianaskepT']['pengkajianaskep_id'];
							$modRencana->create_ruangan = Yii::app()->user->ruangan_id;
							$modRencana->create_time = date('Y-m-d');
							$modRencana->create_loginpemakai_id = Yii::app()->user->id;
							$modRencana->ruangan_id = Yii::app()->user->ruangan_id;
							$modRencana->pegawai_id = $_POST['ASRencanaaskepT']['pegawai_id'];
						}
						
						if ($modRencana->save()) {
							$this->successSave = $this->successSave && true;
						} else {
							$this->successSave = false;
						}

						if (isset($_POST['ASRencanaaskepdetT'])) {
							$implementasi = $this->saveImplementasi($_POST['ASImplementasiaskepT'], $modRencana);
							$evaluasi = $this->saveEvaluasi($_POST['ASEvaluasiaskepT'], $implementasi);
							//save rencana detail
							foreach ($_POST['ASRencanaaskepdetT'] as $i => $rencanadet) {
								//var_dump($rencanadet);die;
								if (!empty($rencanadet['rencanaaskepdet_id'])) {

									$modRencanaDet = ASRencanaaskepdetT::model()->findByPk($rencanadet['rencanaaskepdet_id']);
									$modRencanaDet->attributes = $rencanadet;
								} else {

									$modRencanaDet = new ASRencanaaskepdetT;
									$modRencanaDet->attributes = $rencanadet;
									$modRencanaDet->rencanaaskep_id = $modRencana->rencanaaskep_id;
									$modRencanaDet->diagnosakep_id = $rencanadet['diagnosakep_id'];
								}
//								$modRencanaDet = $modRencanaDet->save();
								if ($modRencanaDet->save()) {
									$this->successSave = $this->successSave && true;

									if (isset($rencanadet['alternatifdx_id'])) {
										foreach ($rencanadet['alternatifdx_id'] as $w => $row) {
											$modPilihRencana = new ASPilihrencanaaskepT;
											$modPilihRencana->rencanaaskepdet_id = isset($modRencanaDet->rencanaaskepdet_id) ? $modRencanaDet->rencanaaskepdet_id : $modRencanaDet['rencanaaskepdet_id'];
											$modPilihRencana->alternatifdx_id = $row;

											$check = ASPilihrencanaaskepT::model()->findByAttributes(array('rencanaaskepdet_id' => $modPilihRencana->rencanaaskepdet_id, 'alternatifdx_id' => $modPilihRencana->alternatifdx_id));
											if (count($check) == 0) {

												if ($modPilihRencana->save()) {
													$this->successSave = $this->successSave && true;
												} else {
													$this->successSave = false;
												}
											}
										}
									}

									if ($rencanadet['tandagejala_id']) {
										foreach ($rencanadet['tandagejala_id'] as $x => $row) {
											$modPilihRencana = new ASPilihrencanaaskepT;
											$modPilihRencana->rencanaaskepdet_id = isset($modRencanaDet->rencanaaskepdet_id) ? $modRencanaDet->rencanaaskepdet_id : $modRencanaDet['rencanaaskepdet_id'];
											$modPilihRencana->tandagejala_id = $row;

											$check = ASPilihrencanaaskepT::model()->findByAttributes(array('rencanaaskepdet_id' => $modPilihRencana->rencanaaskepdet_id, 'tandagejala_id' => $modPilihRencana->tandagejala_id));
											if (count($check) == 0) {
												if ($modPilihRencana->save()) {
													$this->successSave = $this->successSave && true;
												} else {
													$this->successSave = false;
												}
											}
										}
									}

									if ($rencanadet['kriteriahasildet_id']) {
										foreach ($rencanadet['kriteriahasildet_id'] as $y => $row) {
											if ($row > 0) {
												$modPilihRencana = new ASPilihrencanaaskepT;
												$modPilihRencana->rencanaaskepdet_id = isset($modRencanaDet->rencanaaskepdet_id) ? $modRencanaDet->rencanaaskepdet_id : $modRencanaDet['rencanaaskepdet_id'];
												$modPilihRencana->kriteriahasildet_id = $row;
												$modPilihRencana->rencanaaskep_ir = isset($rencanadet['rencanaaskep_ir'][$y]['rencanaaskep_ir']) ? $rencanadet['rencanaaskep_ir'][$y]['rencanaaskep_ir'] : NULL;
												$modPilihRencana->rencanaaskep_er = isset($rencanadet['rencanaaskep_er'][$y]['rencanaaskep_er']) ? $rencanadet['rencanaaskep_er'][$y]['rencanaaskep_er'] : NULL;

												$check = ASPilihrencanaaskepT::model()->findByAttributes(array('rencanaaskepdet_id' => $modPilihRencana->rencanaaskepdet_id, 'kriteriahasildet_id' => $modPilihRencana->kriteriahasildet_id));

												if (count($check) == 0) {

													if ($modPilihRencana->save()) {
														$this->successSave = $this->successSave && true;
													} else {
														$this->successSave = false;
													}
												}
											}
										}
									}

									if ($rencanadet['intervensidet_id']) {
										foreach ($rencanadet['intervensidet_id'] as $z => $row) {
											$modPilihRencana = new ASPilihrencanaaskepT;
											$modPilihRencana->rencanaaskepdet_id = isset($modRencanaDet->rencanaaskepdet_id) ? $modRencanaDet->rencanaaskepdet_id : $modRencanaDet['rencanaaskepdet_id'];
											$modPilihRencana->intervensidet_id = $row;

											$check = ASPilihrencanaaskepT::model()->findByAttributes(array('rencanaaskepdet_id' => $modPilihRencana->rencanaaskepdet_id, 'intervensidet_id' => $modPilihRencana->intervensidet_id));
											if (count($check) == 0) {

												if ($modPilihRencana->save()) {
													$this->successSave = $this->successSave && true;
												} else {
													$this->successSave = false;
												}
											}
										}
									}


									if (isset($_POST['ASImplementasiaskepT'])) {

										if (isset($_POST['ASImplementasiaskepdetT'])) {
											$this->saveImplementasiDetail($_POST['ASImplementasiaskepdetT'][$i], $implementasi, $modRencanaDet);
										}
									}

									if (isset($_POST['ASEvaluasiaskepT'])) {


										if (isset($_POST['ASEvaluasiaskepdetT'])) {
											$this->saveEvaluasiDetail($_POST['ASEvaluasiaskepdetT'][$i], $evaluasi);
										}
									}
								}
							}
						}
					}
				} else {
					$this->successSave = false;
				}

				$successSave = $this->successSave;

				if ($successSave) {
					Yii::app()->user->setFlash('success', "Data berhasil disimpan");
					$transaction->commit();
					$this->redirect(array('index', 'status' => 1, 'verifikasiaskep_id' => $model->verifikasiaskep_id));
				} else {
					Yii::app()->user->setFlash('error', "Data gagal disimpan ");
					$transaction->rollback();
				}
			} catch (Exception $exc) {
				Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
				$transaction->rollback();
			}
		}

		$this->render('index', array(
			'model' => $model,
			'modPengkajian' => $modPengkajian,
			'modPenunjang' => $modPenunjang,
			'modRencana' => $modRencana,
			'modRencanaDet' => $modRencanaDet,
			'modPilihRencana' => $modPilihRencana,
			'modImplementasi' => $modImplementasi,
			'modImplementasiDet' => $modImplementasiDet,
			'modPilihImpl' => $modPilihImpl,
			'modEvaluasi' => $modEvaluasi,
			'modEvaluasiDet' => $modEvaluasiDet,
			'modPendaftaran' => $modPendaftaran,
			'modPenanggungJawab' => $modPenanggungJawab,
			'modRiwayatAnemnesa' => $modRiwayatAnemnesa,
			'modPeriksaFisik' => $modPeriksaFisik,
			'modPasien' => $modPasien,
			'successSave' => $successSave,
			'url_batal' => $url_batal
				)
		);
	}
	
	public function actionCekPengkajianId($pengkajianaskep_id) {
		if (Yii::app()->request->isAjaxRequest) {
			$data = '';
			if (isset($pengkajianaskep_id)) {
				$data = ASVerifikasiaskepT::model()->findByAttributes(array('pengkajianaskep_id'=>$pengkajianaskep_id));
			}
			echo CJSON::encode($data);
		}
		Yii::app()->end();
	}
	
	public function actionLoadPasien($pengkajianaskep_id, $iskeperawatan) {
		if (Yii::app()->request->isAjaxRequest) {
			$data = '';
			if (isset($pengkajianaskep_id)) {
				if ($iskeperawatan == 0) {
					$data = ASInfopengkajianaskepV::model()->findByAttributes(array('pengkajianaskep_id' => $pengkajianaskep_id));
				}
				if ($iskeperawatan == 1) {
					$data = ASInfopengkajiankebidananV::model()->findByAttributes(array('pengkajianaskep_id' => $pengkajianaskep_id));
				}
			}
			echo CJSON::encode($data);
		}
		Yii::app()->end();
	}

	public function actionLoadPenanggungJawab($penanggungjawab_id) {
		if (Yii::app()->request->isAjaxRequest) {
			$data = '';
			if (isset($penanggungjawab_id)) {
				$data = ASPenanggungjawabM::model()->findByPk($penanggungjawab_id);
			}
			echo CJSON::encode($data);
		}
		Yii::app()->end();
	}

	public function actionLoadRiwayatAnemnesa() {
		if (Yii::app()->request->isAjaxRequest) {
			$format = new MyFormatter();
			$rows = "";
			$loadPengkajian = ASPengkajianaskepT::model()->findByAttributes(array('pendaftaran_id' => $_GET['pendaftaran_id']));
			$modRiwayatAnemnesa = ASAnamnesaT::model()->findByPk($loadPengkajian->anamesa_id);
			if (count($modRiwayatAnemnesa) > 0) {
				$rows = $this->renderPartial($this->path_view . "_rowRiwayatAnemnesa", array('modRiwayatAnemnesa' => $modRiwayatAnemnesa), true);
			}
			echo CJSON::encode(array(
				'rows' => $rows));
		}
		Yii::app()->end();
	}

	public function actionLoadRiwayatPeriksaFisik() {
		if (Yii::app()->request->isAjaxRequest) {
			$format = new MyFormatter();
			$rows = "";
			$loadPengkajian = ASPengkajianaskepT::model()->findByAttributes(array('pendaftaran_id' => $_GET['pendaftaran_id']));
			$modRiwayatPeriksaFisik = ASPemeriksaanfisikT::model()->findByPk($loadPengkajian->pemeriksaanfisik_id);
			if (count($modRiwayatPeriksaFisik) > 0) {
				$rows = $this->renderPartial($this->path_view . "_rowRiwayatPemeriksaanFisik", array('modRiwayatPeriksaFisik' => $modRiwayatPeriksaFisik), true);
			}
			echo CJSON::encode(array(
				'rows' => $rows));
		}
		Yii::app()->end();
	}

	public function actionLoadPengkajian($pendaftaran_id) {
		if (Yii::app()->request->isAjaxRequest) {
			$data['form'] = "";
			$data['form2'] = "";
			$data['form3'] = "";
			if (isset($pendaftaran_id)) {
				$criteria = new CDbCriteria();
				$criteria->select = 't.*,pegawai.nama_pegawai';
				$criteria->join = 'JOIN pegawai_m AS pegawai ON pegawai.pegawai_id = t.pegawai_id';
				$criteria->addCondition('pendaftaran_id =' . $pendaftaran_id);
				$modPengkajian = ASPengkajianaskepT::model()->find($criteria);
				if (count($modPengkajian)) {

//					$data['form'] = $this->renderPartial($this->path_view . '_dataPengkajian', array('modPengkajian' => $modPengkajian), true);
//					$data['form2'] = $this->renderPartial($this->path_view . '_formPengkajian', array('modPengkajian' => $modPengkajian), true);
					$data['form3'] = '<fieldset class="box">
		<legend class="rim">Data Penunjang</legend>
		<div class="row-fluid block-tabel">
			<h6>Tabel <b>Data Penunjang</b></h6><table class="items table table-striped table-bordered table-condensed" id="table-penunjang">
            <thead>
				<th>Tanggal</th>
				<th>Data Penunjang</th>
				<th></th>
				</thead>
				<tbody>';
					$penunjang = ASDatapenunjangT::model()->findAllByAttributes(array('pengkajianaskep_id' => $modPengkajian->pengkajianaskep_id));
					if (count($penunjang) > 0) {
						foreach ($penunjang AS $i => $modPenunjang) {
							$data['form3'] .= '<tr>
	<td style="text-align: center;">
		' . CHtml::activeHiddenField($modPenunjang, '[ii]datapenunjang_id', array('readonly' => true)) . CHtml::activeHiddenField($modPenunjang, '[ii]pengkajianaskep_id', array('readonly' => true)) . CHtml::activeTextField($modPenunjang, '[ii]datapenunjang_tgl', array('class' => 'span2 datetimemask')) . '
	</td>
	<td style="text-align: center;">
		' . CHtml::activeTextField($modPenunjang, '[ii]datapenunjang_nama', array('class' => 'span12')) .
									'</td>
	<td style="text-align: center;" class="rowbutton">
		' . CHtml::link('<i class="icon-plus-sign icon-white"></i>', '#', array('class' => 'btn btn-primary', 'onclick' => 'tambahPenunjang()')) . CHtml::link('<i class="icon-minus-sign icon-white"></i>', '#', array('class' => 'btn btn-primary', 'onclick' => 'hapusPenunjang(this)')) .
									'</td>
</tr>';
						}
						$data['form3'] .= '</tbody>
			</table>
		</div>
	</fieldset>';
					} else {
						$modPenunjang = new ASDatapenunjangT;
						$data['form3'] .='<tr>
	<td style="text-align: center;">
		' . CHtml::activeHiddenField($modPenunjang, '[ii]datapenunjang_id', array('readonly' => true)) . CHtml::activeHiddenField($modPenunjang, '[ii]pengkajianaskep_id', array('readonly' => true)) . CHtml::activeTextField($modPenunjang, '[ii]datapenunjang_tgl', array('class' => 'span2 datetimemask', 'value' => date('d/m/Y H:i:s'))) . '
	</td>
	<td style="text-align: center;">
		' . CHtml::activeTextField($modPenunjang, '[ii]datapenunjang_nama', array('class' => 'span12')) .
								'</td>
	<td style="text-align: center;" class="rowbutton">
		' . CHtml::link('<i class="icon-plus-sign icon-white"></i>', '#', array('class' => 'btn btn-primary', 'onclick' => 'tambahPenunjang()')) . CHtml::link('<i class="icon-minus-sign icon-white"></i>', '#', array('class' => 'btn btn-primary', 'onclick' => 'hapusLookup(this)')) .
								'</td>
</tr></tbody>
			</table>
		</div>
	</fieldset>';
					}
				}
			}
			echo CJSON::encode($data);
		}
		Yii::app()->end();
	}

	public function actionDeletePenunjang($id = null) {
		if (Yii::app()->request->isAjaxRequest) {
			$transaction = Yii::app()->db->beginTransaction();
			try {

				$data['success'] = true;

				$deletePenunjang = ASDatapenunjangT::model()->deleteByPk($id);

				if ($deletePenunjang) {
					$data['success'] = true;
					$transaction->commit();
				} else {
					$data['success'] = false;
					$transaction->rollback();
				}
			} catch (Exception $exc) {
				$transaction->rollback();
				echo MyExceptionMessage::getMessage($exc, true);
				$data['success'] = false;
			}



			echo json_encode($data);
			Yii::app()->end();
		}
	}

	public function actionLoadRencana($pengkajianaskep_id = null) {
		if (Yii::app()->request->isAjaxRequest) {

			if ($pengkajianaskep_id != null) {
				$modRencana = ASRencanaaskepT::model()->findByAttributes(array('pengkajianaskep_id' => $pengkajianaskep_id));
			} else {
				$modRencana = array();
			}

			if (count($modRencana)) {
				$data['form'] = $this->renderPartial($this->path_view . '_dataRencana', array('modRencana' => $modRencana), true);

				$rencanadet = ASRencanaaskepdetT::model()->findAllBySql(
						'SELECT rencanaaskepdet_t.*,diagnosakep.*,tujuan.*,kriteriahasil.*,intervensi.*
					FROM rencanaaskepdet_t
					JOIN diagnosakep_m AS diagnosakep ON diagnosakep.diagnosakep_id = rencanaaskepdet_t.diagnosakep_id
					JOIN tujuan_m AS tujuan ON tujuan.tujuan_id = rencanaaskepdet_t.tujuan_id
					JOIN kriteriahasil_m AS kriteriahasil ON kriteriahasil.kriteriahasil_id = rencanaaskepdet_t.kriteriahasil_id
					JOIN intervensi_m AS intervensi ON intervensi.intervensi_id = rencanaaskepdet_t.intervensi_id
					WHERE rencanaaskepdet_t.rencanaaskep_id=' . $modRencana->rencanaaskep_id);
				$data['form1'] = '
		<div class="row-fluid block-tabel">
			<table id="table-rencana" class="table table-striped table-bordered table-condensed">
				<thead>
				<th>Diagnosa Keperawatan</th>
				<th>Tanda dan Gejala</th>
				<th>Tujuan</th>
				<th>Kriteria Hasil</th>
				<th>Intervensi</th>
				<th>Kolaborasi</th>
				<th></th>
				</thead>
				<tbody>';
				$data['modPilih'] = "";
				if (count($rencanadet) > 0) {
					foreach ($rencanadet AS $i => $modRencanaDet) {
						$pilih = ASPilihrencanaaskepT::model()->findAllBySql(
								'SELECT pilihrencanaaskep_t.*
							FROM pilihrencanaaskep_t
							WHERE pilihrencanaaskep_t.rencanaaskepdet_id =' . $modRencanaDet->rencanaaskepdet_id);
						foreach ($pilih AS $x => $Pilih) {
							$modPilih[$i][$x]['pilihrencanaaskep_id'] = $Pilih->pilihrencanaaskep_id;
							$modPilih[$i][$x]['rencanaaskepdet_id'] = $Pilih->rencanaaskepdet_id;
							$modPilih[$i][$x]['tandagejala_id'] = $Pilih->tandagejala_id;
							$modPilih[$i][$x]['intervensidet_id'] = $Pilih->intervensidet_id;
							$modPilih[$i][$x]['kriteriahasildet_id'] = $Pilih->kriteriahasildet_id;
							$modPilih[$i][$x]['rencanaaskep_ir'] = $Pilih->rencanaaskep_ir;
							$modPilih[$i][$x]['rencanaaskep_er'] = $Pilih->rencanaaskep_er;
							$modPilih[$i][$x]['alternatifdx_id'] = $Pilih->alternatifdx_id;
						}

						$data['modPilih'] = $modPilih;
						$data['form1'] .= $this->renderPartial($this->path_view . '_rowRencanaDetail', array('modRencanaDet' => $modRencanaDet), true);
					}
					$data['form1'] .= '</tbody>
								</table>
								';
				} else {
					$modRencanaDet = new ASRencanaaskepdetT;
					$data['form1'] .= $this->renderPartial($this->path_view . '_rowRencanaDetail', array('modRencanaDet' => $modRencanaDet), true);
				}
			} else {
				$modRencana = new ASRencanaaskepT;
				$modRencanaDet = new ASRencanaaskepdetT;
				$modPilihRencana = new ASPilihrencanaaskepT;

				$data['form'] = $this->renderPartial($this->path_view . '_dataRencana', array('modRencana' => $modRencana), true);

				$data['form1'] = '
		<div class="row-fluid block-tabel">
			<table id="table-rencana" class="table table-striped table-bordered table-condensed">
				<thead>
				<th>Diagnosa Keperawatan</th>
				<th>Tanda dan Gejala</th>
				<th>Tujuan</th>
				<th>Kriteria Hasil</th>
				<th>Intervensi</th>
				<th>Kolaborasi</th>
				<th></th>
				</thead>
				<tbody>';
				$data['form1'] .= $this->renderPartial($this->path_view . '_rowRencanaDetail', array('modRencanaDet' => $modRencanaDet), true);
				$data['form1'] .= '</tbody>
								</table>
								';
			}
		}
		echo CJSON::encode($data);
		Yii::app()->end();
	}

	public function actionGetTandaGejala($diagnosakep_id) {
		if (Yii::app()->request->isAjaxRequest) {
//           $diagnosakep_id = $_POST["$namaModel"]['diagnosakep_id'];
			$namaModel = new ASRencanaaskepdetT;
			$data['form'] = "";
			if (empty($diagnosakep_id)) {
//                    $penjamin = PenjaminpasienM::model()->findAll();
				echo '<label>Data Tidak Ditemukan</label>';
			} else {
				$data['form'] .= CHtml::activeCheckBoxList($namaModel, '[0]tandagejala_id', CHtml::listData(TandagejalaM::model()->findAllByAttributes(array('tandagejala_aktif' => true, 'diagnosakep_id' => $diagnosakep_id)), 'tandagejala_id', 'tandagejala_indikator'), array('onkeyup' => "return $(this).focusNextInputField(event);"));
			}
		}
		echo CJSON::encode($data);
		Yii::app()->end();
	}

	public function actionGetTujuan($diagnosakep_id) {
		if (Yii::app()->request->isAjaxRequest) {
//           $diagnosakep_id = $_POST["$namaModel"]['diagnosakep_id'];
			$namaModel = new ASRencanaaskepdetT;
			$data['form'] = "";
			if (empty($diagnosakep_id)) {
//                    $penjamin = PenjaminpasienM::model()->findAll();
				echo '<label>Data Tidak Ditemukan</label>';
			} else {
				$tujuan = TujuanM::model()->findByAttributes(array('diagnosakep_id' => $diagnosakep_id));
				$data['form'] = CHtml::activeTextField($namaModel, '[0]rencanaaskepdet_hari', array('class' => 'span1')) . ' x 24 Jam <br>' . $tujuan['tujuan_nama'];
				$data['form'] .= CHtml::activeHiddenField($namaModel, '[0]tujuan_id', array('value' => $tujuan['tujuan_id']));
			}
		}
		echo CJSON::encode($data);
		Yii::app()->end();
	}

	public function actionGetKriteriaHasil($diagnosakep_id) {
		if (Yii::app()->request->isAjaxRequest) {
//           $diagnosakep_id = $_POST["$namaModel"]['diagnosakep_id'];
			$namaModel = new ASRencanaaskepdetT;
			$kriteria = new ASKriteriahasildetM;
			$data['form'] = "";
			if (empty($diagnosakep_id)) {
//                    $penjamin = PenjaminpasienM::model()->findAll();
				echo '<label>Data Tidak Ditemukan</label>';
			} else {
				$head = KriteriahasilM::model()->findByAttributes(array('diagnosakep_id' => $diagnosakep_id));
				$data['form'] = CHtml::activeHiddenField($namaModel, '[0]kriteriahasil_id', array('value' => $head['kriteriahasil_id']));
				$data['form'] .= CHtml::activeTextField($namaModel, '[0]kriteriahasil_nama', array('value' => $head['kriteriahasil_nama'], 'class' => 'span2', 'readonly' => true));
				$tail = ASKriteriahasildetM::model()->findAllByAttributes(array('kriteriahasil_id' => $head['kriteriahasil_id']));
				$data['table_id'] = 'table-kriteria-' . $head['kriteriahasil_id'];
				$data['form'] .= '<table class="items table table-striped table-bordered table-condensed kriteria" id="' . $data['table_id'] . '">
            <thead>
                <tr>
					<th></th>
                    <th>Kriteria Hasil</th>
                    <th>IR</th>
					<th>ER</th>
                </tr>
            </thead>
			<tbody>';
				foreach ($tail as $i => $row) {

					$data['form'] .= '<tr class="criteria">
						<td>
							<span name="ASRencanaaskepdetT[0][kriteriahasildet_id]">
							' . CHtml::activeCheckBox($namaModel, '[0]kriteriahasildet_id', array('onkeyup' => "return $(this).focusNextInputField(event);", 'value' => $row['kriteriahasildet_id']))
							. '</span>
						</td>
						<td>
						' . $row['kriteriahasildet_indikator'] . '
						</td>
						<td>
						' . CHtml::dropDownList(
									'ASRencanaaskepdetT[0][rencanaaskep_ir]', $namaModel->rencanaaskep_ir, array('1' => '1',
								'2' => '2', '3' => '3', '4' => '4', '5' => '5',), array('class' => 'span1', 'empty' => '--Pilih--')) . '
						</td>
						<td>
						' . CHtml::dropDownList(
									'ASRencanaaskepdetT[0][rencanaaskep_er]', $namaModel->rencanaaskep_er, array('1' => '1',
								'2' => '2', '3' => '3', '4' => '4', '5' => '5',), array('class' => 'span1', 'empty' => '--Pilih--')) . '
						</td>
						</tr>';
				}
//            <?php 
//                $trTindakan = $this->renderPartial($this->path_view.'_rowTindakanPasien',array('modTindakan'=>$modTindakan,'modTindakans'=>$modTindakans,'kelaspelayanan_id'=>$modPendaftaran->kelaspelayanan_id),true); 
//                echo $trTindakan;
				$data['form'] .= '</tbody></table>';
			}
		}
		echo CJSON::encode($data);
		Yii::app()->end();
	}

	public function actionGetIntervensi($diagnosakep_id) {
		if (Yii::app()->request->isAjaxRequest) {
//           $diagnosakep_id = $_POST["$namaModel"]['diagnosakep_id'];
			$namaModel = new ASRencanaaskepdetT;
			$data['form'] = "";
			if (empty($diagnosakep_id)) {
//                    $penjamin = PenjaminpasienM::model()->findAll();
				echo '<label>Data Tidak Ditemukan</label>';
			} else {
				$head = IntervensiM::model()->findByAttributes(array('diagnosakep_id' => $diagnosakep_id));
				$data['form'] = CHtml::activeHiddenField($namaModel, '[0]intervensi_id', array('value' => $head['intervensi_id']));
				$data['form'] .= CHtml::activeTextField($namaModel, '[0]intervensi_nama', array('value' => $head['intervensi_nama'], 'class' => 'span2', 'readonly' => true));
				$data['form'] .= '<br>';
				$data['form'] .= CHtml::activeCheckBoxList($namaModel, '[0]intervensidet_id', CHtml::listData(IntervensidetM::model()->findAllByAttributes(array('intervensidet_aktif' => true, 'intervensi_id' => $head['intervensi_id'])), 'intervensidet_id', 'intervensidet_indikator'), (array('onkeyup' => "return $(this).focusNextInputField(event);")));
			}
		}
		echo CJSON::encode($data);
		Yii::app()->end();
	}

	public function actionLoadImplementasi($rencanaaskep_id = null) {
		if (Yii::app()->request->isAjaxRequest) {
			$data['form'] = "";
			if (!empty($rencanaaskep_id)) {
				$modImplementasi = ASImplementasiaskepT::model()->findByAttributes(array('rencanaaskep_id' => $rencanaaskep_id));
			} else {
				$modImplementasi = array();
			}

			if (count($modImplementasi)) {
				$data['form'] = $this->renderPartial($this->path_view . '_dataImplementasi', array('modImplementasi' => $modImplementasi), true);
				$impldet = ASImplementasiaskepdetT::model()->findAllBySql(
						'SELECT implementasiaskepdet_t.*,diagnosakep.*
					FROM implementasiaskepdet_t
					JOIN diagnosakep_m AS diagnosakep ON diagnosakep.diagnosakep_id = implementasiaskepdet_t.diagnosakep_id
					WHERE implementasiaskepdet_t.implementasiaskep_id=' . $modImplementasi->implementasiaskep_id);
				$data['form1'] = '
		<div class="row-fluid block-tabel">
			<table id="table-implementasi" class="table table-striped table-bordered table-condensed">
				<thead>
				<th>Diagnosa Keperawatan</th>
				<th>Rencana Intervensi</th>
				<th>Implementasi</th>
				<th>Kolaborasi</th>
				</thead>
				<tbody>';
				$data['modPilih'] = "";
				$impldet_jml = count($impldet);

				if ($impldet_jml > 0) {
					foreach ($impldet AS $i => $modImplementasiDet) {
						$pilih = ASPilihimplementasiaskepT::model()->findAllBySql(
								'SELECT pilihimplementasiaskep_t.*
							FROM pilihimplementasiaskep_t
							WHERE pilihimplementasiaskep_t.implementasiaskepdet_id =' . $modImplementasiDet->implementasiaskepdet_id);
						foreach ($pilih AS $x => $Pilih) {
							$modPilih[$i][$x]['pilihimplementasiaskep_id'] = $Pilih->pilihimplementasiaskep_id;
							$modPilih[$i][$x]['implementasiaskepdet_id'] = $Pilih->implementasiaskepdet_id;
							$modPilih[$i][$x]['indikatorimplkepdet_id'] = $Pilih->indikatorimplkepdet_id;
							$modPilih[$i][$x]['alternatifdx_id'] = $Pilih->alternatifdx_id;
						}

						$data['modPilih'] = $modPilih;
						$data['form1'] .= $this->renderPartial($this->path_view . '_rowImplementasiDetail', array('modImplementasiDet' => $modImplementasiDet), true);
					}
					$data['form1'] .= '</tbody></table></div>';
				} else {
					$data['form1'] .= $this->renderPartial($this->path_view . '_rowImplementasiDetail', array('modImplementasiDet' => $modImplementasiDet), true);
				}
			} else {
				$modImplementasi = new ASImplementasiaskepT;
				$modImplementasiDet = new ASImplementasiaskepdetT;
				$modPilihImpl = new ASPilihimplementasiaskepT;

				$data['form'] = $this->renderPartial($this->path_view . '_dataImplementasi', array('modImplementasi' => $modImplementasi), true);

				$data['form1'] = '
		<div class="row-fluid block-tabel">
			<table id="table-implementasi" class="table table-striped table-bordered table-condensed">
				<thead>
				<th>Diagnosa Keperawatan</th>
				<th>Rencana Intervensi</th>
				<th>Implementasi</th>
				<th>Kolaborasi</th>
				</thead>
				<tbody>';

//				$data['form1'] .= $this->renderPartial($this->path_view . '_rowImplementasiDetail', array('modImplementasiDet' => $modImplementasiDet), true);
				$data['form1'] .= '</tbody></table></div>';
			}
		}
		echo CJSON::encode($data);
		Yii::app()->end();
	}

	public function actionGetDiagnosaImplementasi($diagnosakep_id = null) {
		if (Yii::app()->request->isAjaxRequest) {
			$modImplementasiDet = new ASImplementasiaskepdetT;
			$data['form'] = "";
			$diagnosa = ASDiagnosakepM::model()->findByPk($diagnosakep_id);
			$data['form'] = CHtml::activeHiddenField($modImplementasiDet, '[0]rencanaaskepdet_id', array('readonly' => true, 'class' => 'inputFormTabel')) .
					CHtml::activeHiddenField($modImplementasiDet, '[0]diagnosakep_id', array('value' => $diagnosa->diagnosakep_id, 'readonly' => true, 'class' => 'inputFormTabel')) .
					CHtml::activeHiddenField($modImplementasiDet, '[0]isdiagnosa', array('value' => 1, 'onkeyup' => "return $(this).focusNextInputField(event);")) .
					CHtml::activeTextField($modImplementasiDet, '[0]diagnosakep_nama', array('value' => $diagnosa->diagnosakep_nama, 'readonly' => true));

			$data['form'] .= "<br>";
			$data['form'] .= "<br>";
			$data['form'] .= '<strong>Batasan Karakteristik</strong>';
			$data['form'] .= "<br>";
			$bk_head = BataskarakteristikM::model()->findAllByAttributes(array('diagnosakep_id' => $diagnosakep_id));
			if (count($bk_head)) {
				foreach ($bk_head as $i => $bk) {
					$data['form'] .= "<ul class='spasi1'>";
					$data['form'] .= '<li >' . $bk->bataskarakteristik_nama . '</li>';
					$bk_tail = BataskarakteristikdetM::model()->findAllByAttributes(array('bataskarakteristikdet_aktif' => true, 'bataskarakteristik_id' => $bk->bataskarakteristik_id));
					if (count($bk_tail)) {
						foreach ($bk_tail as $i => $bkd) {
							$data['form'] .= '<li >' . $bkd->bataskarakteristikdet_indikator . '</li>';
						}
					} else {
						$data['form'] .= "<ul class='spasi1'>";
						$data['form'] .= '<li> Data tidak ditemukan. </li>';
						$data['form'] .= "</ul>";
					}
					$data['form'] .= "</ul>";
				}
			} else {
				$data['form'] .= "<ul class='spasi1'>";
				$data['form'] .= '<li> Data tidak ditemukan. </li>';
				$data['form'] .= "</ul>";
			}

			$data['form'] .= "<br>";

			$data['form'] .= '<strong>Faktor Risiko</strong>';
			$data['form'] .= "<br>";
			$bk_head = FaktorrisikoM::model()->findAllByAttributes(array('diagnosakep_id' => $diagnosakep_id));
			if (count($bk_head)) {
				foreach ($bk_head as $i => $bk) {
					$data['form'] .= "<ul class='spasi1'>";
					$data['form'] .= '<li >' . $bk->faktorrisiko_nama . '</li>';
					$bk_tail = FaktorrisikodetM::model()->findAllByAttributes(array('faktorrisikodet_aktif' => true, 'faktorrisiko_id' => $bk->faktorrisiko_id));
					if (count($bk_tail)) {
						foreach ($bk_tail as $i => $bkd) {
							$data['form'] .= '<li >' . $bkd->faktorrisikodet_indikator . '</li>';
						}
					} else {
						$data['form'] .= "<ul class='spasi1'>";
						$data['form'] .= '<li> Data tidak ditemukan. </li>';
						$data['form'] .= "</ul>";
					}
					$data['form'] .= "</ul>";
				}
			} else {
				$data['form'] .= "<ul class='spasi1'>";
				$data['form'] .= '<li> Data tidak ditemukan. </li>';
				$data['form'] .= "</ul>";
			}

			$data['form'] .= "<br>";

			$data['form'] .= '<strong>Faktor Yang Berhubungan</strong>';
			$data['form'] .= "<br>";
			$bk_head = FaktorhubM::model()->findAllByAttributes(array('diagnosakep_id' => $diagnosakep_id));
			if (count($bk_head)) {
				foreach ($bk_head as $i => $bk) {
					$data['form'] .= "<ul class='spasi1'>";
					$data['form'] .= '<li >' . $bk->faktorhub_nama . '</li>';
					$bk_tail = FaktorhubdetM::model()->findAllByAttributes(array('faktorhubdet_aktif' => true, 'faktorhub_id' => $bk->faktorhub_id));
					if (count($bk_tail)) {
						foreach ($bk_tail as $i => $bkd) {
							$data['form'] .= '<li >' . $bkd->faktorhubdet_indikator . '</li>';
						}
					} else {
						$data['form'] .= "<ul class='spasi1'>";
						$data['form'] .= '<li> Data tidak ditemukan. </li>';
						$data['form'] .= "</ul>";
					}
					$data['form'] .= "</ul>";
				}
			} else {
				$data['form'] .= "<ul class='spasi1'>";
				$data['form'] .= '<li> Data tidak ditemukan. </li>';
				$data['form'] .= "</ul>";
			}
			$data['form'] .= "<br>";

			$data['form'] .= '<strong>Diagnosa Alternatif</strong>';
			$data['form'] .= "<br>";
			$data['form'] .= CHtml::activeCheckBoxList($modImplementasiDet, '[0]alternatifdx_id', CHtml::listData(AlternatifdxM::model()->findAllByAttributes(array('alternatifdx_aktif' => true, 'diagnosakep_id' => $diagnosakep_id)), 'alternatifdx_id', 'alternatifdx_nama'));
			$data['form'] .= "</div>";
		}
		echo CJSON::encode($data);
		Yii::app()->end();
	}

	public function actionGetRencanaIntervensi($diagnosakep_id = null) {
		if (Yii::app()->request->isAjaxRequest) {
			$modImplementasiDet = new ASImplementasiaskepdetT;
			$data['form'] = "";
//			$tail = ASPilihrencanaaskepT::model()->findAllBySql('
//									SELECT pilihrencanaaskep_t.*,intervensidet.*
//									FROM pilihrencanaaskep_t
//									JOIN intervensidet_m AS intervensidet ON intervensidet.intervensidet_id = pilihrencanaaskep_t.intervensidet_id
//									WHERE rencanaaskepdet_id =' . $modImplementasiDet->rencanaaskepdet_id . ' AND pilihrencanaaskep_t.intervensidet_id IS NOT NULL');
			$modInv = IntervensiM::model()->findByAttributes(array('diagnosakep_id' => $diagnosakep_id));
			$data['table_id'] = 'table-intervensi-' . $modInv->intervensi_id;
			$data['form'] = '<table class="items table table-striped table-bordered table-condensed intervensi" id="' . $data['table_id'] . '">
            <thead>
                    <th>Intervensi</th>
                    <th>Indikator Intervensi</th>
            </thead>
			<tbody>';
			$data['form'] .= '<tr>';
			$data['form'] .= '<td>' . (!empty($modInv->intervensi_nama) ? $modInv->intervensi_nama : $modInv->intervensi_nama) . '</td>';
			$data['form'] .= '<td class="intervensiindikator>';

			$data['form'] .= '</td>';
			$data['form'] .= '</tr>';
			$data['form'] .= '</tbody></table>';
		}
		echo CJSON::encode($data);
		Yii::app()->end();
	}

	public function actionGetImplementasiDetail($diagnosakep_id = null) {
		if (Yii::app()->request->isAjaxRequest) {
			$modImplementasiDet = new ASImplementasiaskepdetT;
			$data['form'] = '';
			$impl = ImplementasikepM::model()->findByAttributes(array('diagnosakep_id' => $diagnosakep_id));
			$data['form'] = CHtml::activeHiddenField($modImplementasiDet, '[0]implementasikep_id', array('value' => $impl->implementasikep_id)) .
					CHtml::activeCheckBoxList($modImplementasiDet, '[0]indikatorimplkepdet_id', CHtml::listData(IndikatorimplkepdetM::model()->findAllByAttributes(array('indikatorimplkepdet_aktif' => true, 'implementasikep_id' => $impl->implementasikep_id)), 'indikatorimplkepdet_id', 'indikatorimplkepdet_indikator'), (array('onclick' => 'cekListImplementasiDetail(this);', 'onkeyup' => "return $(this).focusNextInputField(event);")));
		}
		echo CJSON::encode($data);
		Yii::app()->end();
	}

	public function actionLoadEvaluasi($implementasiaskep_id = null) {
		if (Yii::app()->getRequest()->getIsAjaxRequest()) {
			$data['form'] = "";

			if (!empty($implementasiaskep_id)) {
				$modEvaluasi = ASEvaluasiaskepT::model()->findByAttributes(array('implementasiaskep_id' => $implementasiaskep_id));
			} else {
				$modEvaluasi = array();
			}


			if (count($modEvaluasi)) {
				$data['form'] = $this->renderPartial($this->path_view . '_dataEvaluasi', array('modEvaluasi' => $modEvaluasi), true);
				$evdet = ASEvaluasiaskepdetT::model()->findAllBySql(
						'SELECT evaluasiaskepdet_t.*,diagnosakep.*
					FROM evaluasiaskepdet_t
					JOIN diagnosakep_m AS diagnosakep ON diagnosakep.diagnosakep_id = evaluasiaskepdet_t.diagnosakep_id
					WHERE evaluasiaskepdet_t.evaluasiaskep_id=' . $modEvaluasi->evaluasiaskep_id);
				$data['form1'] = '<table class="items table table-striped table-bordered table-condensed" id="table-evaluasi">
            <thead>
                    <th>Diagnosa Keperawatan</th>
                    <th>Subjektif</th>
					<th>Objektif</th>
					<th>Assessment</th>
					<th>Planning</th>
					<th>Hasil Evaluasi</th>
            </thead>
			<tbody>';
				$evdet_jml = count($evdet);
				if ($evdet_jml > 0) {
					foreach ($evdet AS $i => $modEvaluasiDet) {
						$data['form1'] .= $this->renderPartial($this->path_view . '_rowEvaluasiDetail', array('modEvaluasiDet' => $modEvaluasiDet), true);
					}
				} else {
					$data['form1'] .= $this->renderPartial($this->path_view . '_rowEvaluasiDetail', array('modEvaluasiDet' => $modEvaluasiDet), true);
				}
				$data['form1'] .= '</tbody></table>';
			} else {
				$modEvaluasi = new ASEvaluasiaskepT;
				$modEvaluasiDet = new ASEvaluasiaskepdetT;
				$data['form'] = $this->renderPartial($this->path_view . '_dataEvaluasi', array('modEvaluasi' => $modEvaluasi), true);

				$data['form1'] = '<table class="items table table-striped table-bordered table-condensed" id="table-evaluasi">
            <thead>
                    <th>Diagnosa Keperawatan</th>
                    <th>Subjektif</th>
					<th>Objektif</th>
					<th>Assessment</th>
					<th>Planning</th>
					<th>Hasil Evaluasi</th>
            </thead>
			<tbody>';

				$data['form1'] .= '</tbody></table>';
			}

			echo CJSON::encode($data);
			Yii::app()->end();
		}
	}

	public function actionDeleteTandaGejalaRencana() {
		if (Yii::app()->request->isAjaxRequest) {
			$transaction = Yii::app()->db->beginTransaction();
			try {
				$data['success'] = true;
				$pilih = ASPilihrencanaaskepT::model()->findByAttributes(array('rencanaaskepdet_id' => $_POST['rencanaaskepdet_id'], 'tandagejala_id' => $_POST['tandagejala_id']));

				if (count($pilih) > 0) {
					$deletePilih = ASPilihrencanaaskepT::model()->deleteByPk($pilih->pilihrencanaaskep_id);
				}

				if ($deletePilih) {
					$data['success'] = true;
					$transaction->commit();
				} else {
					$data['success'] = false;
					$transaction->rollback();
				}
			} catch (Exception $exc) {
				$transaction->rollback();
				echo MyExceptionMessage::getMessage($exc, true);
				$data['success'] = false;
			}

			echo json_encode($data);
			Yii::app()->end();
		}
	}

	public function actionDeleteKriteriaHasilRencana() {
		if (Yii::app()->request->isAjaxRequest) {
			$transaction = Yii::app()->db->beginTransaction();
			try {
				$data['success'] = true;
				$pilih = ASPilihrencanaaskepT::model()->findByAttributes(array('rencanaaskepdet_id' => $_POST['rencanaaskepdet_id'], 'kriteriahasildet_id' => $_POST['kriteriahasildet_id']));

				if (count($pilih) > 0) {
					$deletePilih = ASPilihrencanaaskepT::model()->deleteByPk($pilih->pilihrencanaaskep_id);
				}

				if ($deletePilih) {
					$data['success'] = true;
					$transaction->commit();
				} else {
					$data['success'] = false;
					$transaction->rollback();
				}
			} catch (Exception $exc) {
				$transaction->rollback();
				echo MyExceptionMessage::getMessage($exc, true);
				$data['success'] = false;
			}

			echo json_encode($data);
			Yii::app()->end();
		}
	}

	public function actionDeleteIntervensiRencana() {
		if (Yii::app()->request->isAjaxRequest) {
			$transaction = Yii::app()->db->beginTransaction();
			try {
				$data['success'] = true;
				$pilih = ASPilihrencanaaskepT::model()->findByAttributes(array('rencanaaskepdet_id' => $_POST['rencanaaskepdet_id'], 'intervensidet_id' => $_POST['intervensidet_id']));

				if (count($pilih) > 0) {
					$deletePilih = ASPilihrencanaaskepT::model()->deleteByPk($pilih->pilihrencanaaskep_id);
				}

				if ($deletePilih) {
					$data['success'] = true;
					$transaction->commit();
				} else {
					$data['success'] = false;
					$transaction->rollback();
				}
			} catch (Exception $exc) {
				$transaction->rollback();
				echo MyExceptionMessage::getMessage($exc, true);
				$data['success'] = false;
			}

			echo json_encode($data);
			Yii::app()->end();
		}
	}

	public function actionDeletePilihImplementasi() {
		if (Yii::app()->request->isAjaxRequest) {
			$transaction = Yii::app()->db->beginTransaction();
			try {
				$data['success'] = true;
				$pilih = ASPilihimplementasiaskepT::model()->findByAttributes(array('indikatorimplkepdet_id' => $_POST['indikatorimplkepdet_id'], 'implementasiaskepdet_id' => $_POST['implementasiaskepdet_id']));

				if (count($pilih) > 0) {
					$deletePilih = ASPilihimplementasiaskepT::model()->deleteByPk($pilih->pilihrencanaaskep_id);
				}

				if ($deletePilih) {
					$data['success'] = true;
					$transaction->commit();
				} else {
					$data['success'] = false;
					$transaction->rollback();
				}
			} catch (Exception $exc) {
				$transaction->rollback();
				echo MyExceptionMessage::getMessage($exc, true);
				$data['success'] = false;
			}

			echo json_encode($data);
			Yii::app()->end();
		}
	}

	public function actionDeleteRencana() {
		if (Yii::app()->request->isAjaxRequest) {
			$transaction = Yii::app()->db->beginTransaction();
			try {
				$data['success'] = true;
				$delete = false;
				$rencanadet = ASRencanaaskepdetT::model()->findByPk($_POST['id']);
				$implementasi = ASImplementasiaskepT::model()->findByAttributes(array('rencanaaskep_id' => $rencanadet->rencanaaskep_id));
				$evaluasi = ASEvaluasiaskepT::model()->findByAttributes(array('implementasiaskep_id' => $implementasi->implementasiaskep_id));
				$evaluasidet = ASEvaluasiaskepdetT::model()->findAllByAttributes(array('evaluasiaskep_id' => $evaluasi->evaluasiaskep_id, 'diagnosakep_id' => $rencanadet->diagnosakep_id));
				$implementasiaskepdet = ASImplementasiaskepdetT::model()->findAllByAttributes(array('rencanaaskepdet_id' => $_POST['id']));
				if (count($evaluasidet) > 0) {
					foreach ($evaluasidet as $i => $detail) {
						$deleteEvaluasiDetail = ASEvaluasiaskepdetT::model()->deleteByPk($detail->evaluasiaskepdet_id);

						if ($deleteEvaluasiDetail) {
							$delete = true;
						} else {
							$delete = false;
						}
					}
				}

				if ($delete == true) {
					if (count($implementasiaskepdet) > 0) {
						foreach ($implementasiaskepdet as $i => $detail) {
							$deletepilih = ASPilihimplementasiaskepT::model()->deleteAllByAttributes(array('implementasiaskepdet_id' => $detail->implementasiaskepdet_id));

							if ($deletepilih) {
								$deleteimpldet = ASImplementasiaskepdetT::model()->deleteByPk($detail->implementasiaskepdet_id);

								if ($deleteimpldet) {
									$delete = true;
								} else {
									$delete = false;
								}
							}
						}
					}
				}

				if ($delete == true) {

					$deletepilih = ASPilihrencanaaskepT::model()->deleteAllByAttributes(array('rencanaaskepdet_id' => $_POST['id']));

					if ($deletepilih) {
						$deleterencanadet = ASRencanaaskepdetT::model()->deleteByPk($_POST['id']);

						if ($deleterencanadet) {
							$delete = true;
						} else {
							$delete = false;
						}
					}
				}


				if ($delete) {
					$data['success'] = true;
					$transaction->commit();
				} else {
					$data['success'] = false;
					$transaction->rollback();
				}
			} catch (Exception $exc) {
				$transaction->rollback();
				echo MyExceptionMessage::getMessage($exc, true);
				$data['success'] = false;
			}

			echo json_encode($data);
			Yii::app()->end();
		}
	}

	public function saveImplementasi($post, $rencanaaskep) {

		if (!empty($post['implementasiaskep_id'])) {
			$modImplementasi = ASImplementasiaskepT::model()->findByPk($post['implementasiaskep_id']);
			$modImplementasi->attributes = $post;
			$modImplementasi->pegawai_id = $post['pegawai_id'];
			$modImplementasi->implementasiaskep_tgl = MyFormatter::formatDateTimeForDb($post['implementasiaskep_tgl']);
			$modImplementasi->update_time = date('Y-m-d');
			$modImplementasi->update_loginpemakai_id = Yii::app()->user->id;
		} else {
			$modImplementasi = new ASImplementasiaskepT;
			$modImplementasi->attributes = $post;
			$modImplementasi->no_implementasi = MyGenerator::noImplementasiKeperawatan();
			$modImplementasi->implementasiaskep_tgl = MyFormatter::FormatDateTimeForDb($post['implementasiaskep_tgl']);
			$modImplementasi->rencanaaskep_id = $rencanaaskep['rencanaaskep_id'];
			$modImplementasi->create_ruangan = Yii::app()->user->ruangan_id;
			$modImplementasi->create_time = date('Y-m-d');
			$modImplementasi->create_loginpemakai_id = Yii::app()->user->id;
			$modImplementasi->ruangan_id = Yii::app()->user->ruangan_id;
			$modImplementasi->pegawai_id = $post['pegawai_id'];
		}




		if ($modImplementasi->save()) {
			$this->successSave = $this->successSave && true;
		} else {
			$this->successSave = false;
		}

		return $modImplementasi;
	}

	public function saveImplementasiDetail($post, $implementasi, $modRencanaDet) {
		if (isset($post['implementasiaskepdet_id'])) {
			$modImplementasiDet = ASImplementasiaskepdetT::model()->findByPk($post['implementasiaskepdet_id']);
			$modImplementasiDet->attributes = $post;
		} else {
			$modImplementasiDet = new ASImplementasiaskepdetT;
			$modImplementasiDet->attributes = $post;
			$modImplementasiDet->implementasiaskep_id = $implementasi->implementasiaskep_id;
			$modImplementasiDet->rencanaaskepdet_id = $modRencanaDet->rencanaaskepdet_id;
		}

		if ($modImplementasiDet->save()) {
			if (isset($post['alternatifdx_id'])) {
				foreach ($post['alternatifdx_id'] as $i => $row) {
					$modPilihImpl = new ASPilihimplementasiaskepT;
					$modPilihImpl->implementasiaskepdet_id = isset($modImplementasiDet->implementasiaskepdet_id) ? $modImplementasiDet->implementasiaskepdet_id : $modImplementasiDet['implementasiaskepdet_id'];
					$modPilihImpl->alternatifdx_id = $row;

					$check = ASPilihimplementasiaskepT::model()->findByAttributes(array('implementasiaskepdet_id' => $modPilihImpl->implementasiaskepdet_id, 'alternatifdx_id' => $modPilihImpl->alternatifdx_id));
					if (count($check) == 0) {

						if ($modPilihImpl->save()) {
							$this->successSave = $this->successSave && true;
						} else {
							$this->successSave = false;
						}
					}
				}
			}

			if (isset($post['indikatorimplkepdet_id'])) {
				foreach ($post['indikatorimplkepdet_id'] as $i => $row) {
					$modPilihImpl = new ASPilihimplementasiaskepT;
					$modPilihImpl->implementasiaskepdet_id = isset($modImplementasiDet->implementasiaskepdet_id) ? $modImplementasiDet->implementasiaskepdet_id : $modImplementasiDet['implementasiaskepdet_id'];
					$modPilihImpl->indikatorimplkepdet_id = $row;

					$check = ASPilihimplementasiaskepT::model()->findByAttributes(array('implementasiaskepdet_id' => $modPilihImpl->implementasiaskepdet_id, 'indikatorimplkepdet_id' => $modPilihImpl->indikatorimplkepdet_id));
					if (count($check) == 0) {

						if ($modPilihImpl->save()) {
							$this->successSave = $this->successSave && true;
						} else {
							$this->successSave = false;
						}
					}
				}
			}
		} else {
			$this->successSave = false;
		}
		return $modImplementasiDet;
	}

	public function saveEvaluasi($post, $implementasiaskep) {
		if (!empty($post['evaluasiaskep_id'])) {
			$modEvaluasi = ASEvaluasiaskepT::model()->findByPk($post['evaluasiaskep_id']);
			$modEvaluasi->attributes = $post;
			$modEvaluasi->pegawai_id = $post['pegawai_id'];
			$modEvaluasi->evaluasiaskep_tgl = MyFormatter::formatDateTimeForDb($post['evaluasiaskep_tgl']);
			$modEvaluasi->update_time = date('Y-m-d');
			$modEvaluasi->update_loginpemakai_id = Yii::app()->user->id;
		} else {
			$modEvaluasi = new ASEvaluasiaskepT;
			$modEvaluasi->attributes = $post;
			$modEvaluasi->no_evaluasi = MyGenerator::noEvaluasiKeperawatan();
			$modEvaluasi->evaluasiaskep_tgl = MyFormatter::FormatDateTimeForDb($post['evaluasiaskep_tgl']);
			$modEvaluasi->implementasiaskep_id = $implementasiaskep->implementasiaskep_id;
			$modEvaluasi->create_ruangan = Yii::app()->user->ruangan_id;
			$modEvaluasi->create_time = date('Y-m-d');
			$modEvaluasi->create_loginpemakai_id = Yii::app()->user->id;
			$modEvaluasi->ruangan_id = Yii::app()->user->ruangan_id;
			$modEvaluasi->pegawai_id = $post['pegawai_id'];
		}

		if ($modEvaluasi->save()) {
			$this->successSave = $this->successSave && true;
		} else {
			$this->successSave = false;
		}

		return $modEvaluasi;
	}

	public function saveEvaluasiDetail($post, $evaluasi) {
		if (isset($post['evaluasiaskepdet_id']) && !empty($post['evaluasiaskepdet_id'])) {
			$modEvaluasiDet = ASEvaluasiaskepdetT::model()->findByPk($post['evaluasiaskepdet_id']);
			$modEvaluasiDet->attributes = $post;
		} else {
			$modEvaluasiDet = new ASEvaluasiaskepdetT;
			$modEvaluasiDet->attributes = $post;
			$modEvaluasiDet->diagnosakep_id = $post['diagnosakep_id'];
			$modEvaluasiDet->evaluasiaskep_id = $evaluasi['evaluasiaskep_id'];
			$modEvaluasiDet->evaluasiaskepdet_subjektif = isset($post['evaluasiaskepdet_subjektif']) ? $post['evaluasiaskepdet_subjektif'] : "";
			$modEvaluasiDet->evaluasiaskepdet_objektif = isset($post['evaluasiaskepdet_objektif']) ? $post['evaluasiaskepdet_objektif'] : "";
			$modEvaluasiDet->evaluasiaskepdet_assessment = isset($post['evaluasiaskepdet_assessment']) ? $post['evaluasiaskepdet_assessment'] : "";
			$modEvaluasiDet->evaluasiaskepdet_planning = isset($post['evaluasiaskepdet_planning']) ? $post['evaluasiaskepdet_planning'] : "";
			$modEvaluasiDet->evaluasiaskepdet_hasil = isset($post['evaluasiaskepdet_hasil']) ? $post['evaluasiaskepdet_hasil'] : "";
		}

		if ($modEvaluasiDet->save()) {
			$this->successSave = $this->successSave && true;
		} else {
			$this->successSave = false;
		}
		return $modEvaluasiDet;
	}

	public function actionAutocompletepengkajiankep() {
		if (Yii::app()->request->isAjaxRequest) {
			$format = new MyFormatter();
			$returnVal = array();

			$criteria = new CDbCriteria();
			$criteria->join = " LEFT JOIN rencanaaskep_t renc ON renc.pengkajianaskep_id = t.pengkajianaskep_id "
                                . " JOIN pendaftaran_t p ON p.pendaftaran_id = t.pendaftaran_id "
                                . " JOIN pegawai_m peg ON peg.pegawai_id = t.pegawai_id";		                
                       // $criteria->addCondition(' renc.pengkajianaskep_id IS NULL');		
                        $criteria->addCondition(' t.iskeperawatan IS TRUE');	
                        $criteria->addCondition("t.ruangan_id  = '".Yii::app()->user->getState('ruangan_id')."' ");
			$criteria->compare('LOWER(t.no_pengkajian)', strtolower($_GET['term']), true);
			$criteria->limit = 5;
			//$models = ASInfopengkajianaskepV::model()->findAll($criteria);
                        $models = ASPengkajianaskepT::model()->findAll($criteria);
			foreach ($models as $i => $model) {
				$attributes = $model->attributeNames();
				foreach ($attributes as $j => $attribute) {
					$returnVal[$i]["$attribute"] = $model->$attribute;
				}
				$returnVal[$i]['label'] = $model->no_pengkajian . ' - ' . $model->pendaftaran->pasien->no_rekam_medik . ' - ' . $model->pendaftaran->pasien->nama_pasien . (!empty($model->pendaftaran->pasien->nama_bin) ? "(" . $model->pendaftaran->pasien->nama_bin . ")" : "");
				$returnVal[$i]['value'] = $model->no_pengkajian;
			}

			echo CJSON::encode($returnVal);
		}
		Yii::app()->end();
	}

	public function actionAutocompletepengkajiankeb() {
		if (Yii::app()->request->isAjaxRequest) {
			$format = new MyFormatter();
			$returnVal = array();

			$criteria = new CDbCriteria();
                        $criteria->join = " LEFT JOIN rencanaaskep_t renc ON renc.pengkajianaskep_id = t.pengkajianaskep_id "
			        . " JOIN pendaftaran_t p ON p.pendaftaran_id = t.pendaftaran_id "
                                . " JOIN pegawai_m peg ON peg.pegawai_id = t.pegawai_id";		                
                       // $criteria->addCondition(' renc.pengkajianaskep_id IS NULL');		
                        $criteria->addCondition(' t.iskeperawatan IS FALSE');		
			$criteria->compare('LOWER(t.no_pengkajian)', strtolower($_GET['term']), true);
			$criteria->limit = 5;
			//$models = ASInfopengkajiankebidananV::model()->findAll($criteria);
                        $models = ASPengkajianaskepT::model()->findAll($criteria);
			foreach ($models as $i => $model) {
				$attributes = $model->attributeNames();
				foreach ($attributes as $j => $attribute) {
					$returnVal[$i]["$attribute"] = $model->$attribute;
				}
				$returnVal[$i]['label'] = $model->no_pengkajian . ' - ' . $model->pendaftaran->pasien->no_rekam_medik . ' - ' . $model->pendaftaran->pasien->nama_pasien . (!empty($model->pendaftaran->pasien->nama_bin) ? "(" . $model->pendaftaran->pasien->nama_bin . ")" : "");
				$returnVal[$i]['value'] = $model->no_pengkajian;
			}

			echo CJSON::encode($returnVal);
		}
		Yii::app()->end();
	}

	public function actionPrint() {
		$model = ASVerifikasiaskepT::model()->findByPk($_REQUEST['verifikasiaskep_id']);
		$model->attributes = $model;
//		$modPengkajian = ASPengkajianaskepT::model()->findByPk($model->pengkajianaskep_id);
		$modPasien = ASInfopasienmasukkamarV::model()->findByAttributes(array('pendaftaran_id' => $model->pendaftaran_id));
		
		if(count($modPasien) == 0){
			$modPasien = ASPasienpulangrddanriV::model()->findByAttributes(array('pendaftaran_id' => $model->pendaftaran_id));
		}

		$judulLaporan = 'Verifikasi Keperawatan';
		$caraPrint = $_REQUEST['caraPrint'];
		if ($caraPrint == 'PRINT') {
			$this->layout = '//layouts/printWindows';
			$this->render($this->path_view . 'Print', array('model' => $model, 'modPasien' => $modPasien, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
		} else if ($caraPrint == 'EXCEL') {
			$this->layout = '//layouts/printExcel';
			$this->render($this->path_view . 'Print', array('model' => $model, 'modPasien' => $modPasien, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
		} else if ($_REQUEST['caraPrint'] == 'PDF') {
			$ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');   //Ukuran Kertas Pdf
			$posisi = Yii::app()->user->getState('posisi_kertas');   //Posisi L->Landscape,P->Portait
			$mpdf = new MyPDF('', $ukuranKertasPDF);
			$mpdf->mirrorMargins = 2;
			$stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
			$mpdf->WriteHTML($stylesheet, 1);
			$mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
			$mpdf->WriteHTML($this->renderPartial($this->path_view . 'Print', array('model' => $model, 'modPasien' => $modPasien, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
			$mpdf->Output();
		}
	}

	public function actionPegawairiwayat() {
		if (Yii::app()->request->isAjaxRequest) {
			$criteria = new CDbCriteria();
			$criteria->compare('LOWER(nama_pegawai)', strtolower($_GET['term']), true);
			$criteria->limit = 5;
			$models = PegawaiM::model()->findAll($criteria);
			$returnVal = array();
			foreach ($models as $i => $model) {
				$attributes = $model->attributeNames();
				foreach ($attributes as $j => $attribute) {
					$returnVal[$i]["$attribute"] = $model->$attribute;
				}
				$returnVal[$i]['label'] = $model->nomorindukpegawai . ' - ' . $model->nama_pegawai . ' - ' . $model->jeniskelamin;
				$returnVal[$i]['nama_pegawai'] = $model->nama_pegawai;
				$returnVal[$i]['value'] = $model->pegawai_id;
				$returnVal[$i]['jabatan_nama'] = (isset($model->jabatan->jabatan_nama) ? $model->jabatan->jabatan_nama : '-');
			}

			echo CJSON::encode($returnVal);
		}
		Yii::app()->end();
	}

	public function actionAutocompleteDiagnosa() {
		if (Yii::app()->request->isAjaxRequest) {
			$criteria = new CDbCriteria();
			$term = strtolower(trim($_GET['term']));
			$condition = "LOWER(diagnosakep_kode) LIKE '%" . $term . "%' OR LOWER(diagnosakep_nama) LIKE '%" . $term . "%' ";
			$criteria->addCondition($condition);
			$criteria->limit = 5;
			$models = ASDiagnosakepM::model()->findAll($criteria);
			$returnVal = array();

			foreach ($models as $i => $model) {
				$attributes = $model->attributeNames();
				foreach ($attributes as $j => $attribute) {
					$returnVal[$i]["$attribute"] = $model->$attribute;
				}
				$returnVal[$i]['label'] = $model->diagnosakep_kode . ' - ' . $model->diagnosakep_nama;
				$returnVal[$i]['value'] = $model->diagnosakep_id;
			}

			echo CJSON::encode($returnVal);
		}
		Yii::app()->end();
	}

}