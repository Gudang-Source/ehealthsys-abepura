<?php

class EvaluasiAskepController extends MyAuthController {

	protected $successSave = true;
	public $path_view = "asuhanKeperawatan.views.evaluasiAskep.";

	public function actionIndex() {
		if (isset($_GET['frame'])) {
			$this->layout = "//layouts/iframe";
		}
		$model = new ASEvaluasiaskepT;
		$modDetail = new ASEvaluasiaskepdetT;
		$modImpl = new ASImplementasiaskepT;
		$modPasien = new ASInfoimplementasiaskepV;



		$nama_modul = Yii::app()->controller->module->id;
		$nama_controller = Yii::app()->controller->id;
		$nama_action = Yii::app()->controller->action->id;
		$modul_id = ModulK::model()->findByAttributes(array('url_modul' => $nama_modul))->modul_id;

		$url_batal = Yii::app()->createAbsoluteUrl(
				Yii::app()->controller->module->id . '/' . Yii::app()->controller->id
		);
		$successSave = false;
//		
		if (isset($_GET['evaluasiaskep_id'])) {
			$model = ASEvaluasiaskepT::model()->findByPk($_GET['evaluasiaskep_id']);

			$modImpl = ASInfoimplementasiaskepV::model()->findByAttributes(array('implementasiaskep_id' => $model->implementasiaskep_id));

			$modPasien = ASInfopasienmasukkamarV::model()->findByAttributes(array('no_pendaftaran' => $modImpl->no_pendaftaran));
		}

		if (isset($_POST['ASEvaluasiaskepT']) && !empty($_POST['ASImplementasiaskepT']['implementasiaskep_id'])) {
			$transaction = Yii::app()->db->beginTransaction();
			try {
				$model = $this->saveEvaluasi($_POST['ASEvaluasiaskepT'], $_POST['ASImplementasiaskepT']);
				if (isset($_POST['ASImplementasiaskepdetT'])) {
					$modDetail = $this->saveEvaluasiDetail($_POST['ASImplementasiaskepdetT'], $model);
				}

				$successSave = $this->successSave;

				if ($successSave) {
					Yii::app()->user->setFlash('success', "Data berhasil disimpan");
					$transaction->commit();
					$this->redirect(array('index', 'status' => 1, 'evaluasiaskep_id' => $model->evaluasiaskep_id));
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
			'modDetail' => $modDetail,
			'modImpl' => $modImpl,
			'modPasien' => $modPasien,
			'successSave' => $successSave,
			'url_batal' => $url_batal
				)
		);
	}

	public function actionLoadPasien($implementasiaskep_id) {
		if (Yii::app()->request->isAjaxRequest) {
			$data = '';
			if (isset($implementasiaskep_id)) {
				$data = ASInfoimplementasiaskepV::model()->findByAttributes(array('implementasiaskep_id' => $implementasiaskep_id));
			}
			echo CJSON::encode($data);
		}
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

	public function actionGetImplDet($implementasiaskep_id) {
		if (Yii::app()->getRequest()->getIsAjaxRequest()) {

			$impldet = ASImplementasiaskepdetT::model()->findAllBySql(
					'SELECT implementasiaskepdet_t.*,diagnosakep.*
					FROM implementasiaskepdet_t
					JOIN diagnosakep_m AS diagnosakep ON diagnosakep.diagnosakep_id = implementasiaskepdet_t.diagnosakep_id
					WHERE implementasiaskepdet_t.implementasiaskep_id=' . $implementasiaskep_id);
			$data['form'] = "";
			$impldet_jml = count($impldet);
			if ($impldet_jml > 0) {
				foreach ($impldet AS $i => $modDetail) {
					

					$data['form'] .= $this->renderPartial($this->path_view . '_rowEvaluasiDetail', array('modDetail' => $modDetail), true);
				}
			} else {
				$data['form'] .= $this->renderPartial($this->path_view . '_rowEvaluasiDetail', array('modDetail' => $modDetail), true);
			}
			echo CJSON::encode($data);
			Yii::app()->end();
		}
	}
	
	public function actionGetEvaluasiDet($evaluasiaskep_id) {
		if (Yii::app()->getRequest()->getIsAjaxRequest()) {

			$evdet = ASEvaluasiaskepdetT::model()->findAllBySql(
					'SELECT evaluasiaskepdet_t.*,diagnosakep.*
					FROM evaluasiaskepdet_t
					JOIN diagnosakep_m AS diagnosakep ON diagnosakep.diagnosakep_id = evaluasiaskepdet_t.diagnosakep_id
					WHERE evaluasiaskepdet_t.evaluasiaskep_id=' . $evaluasiaskep_id);
			$data['form'] = "";
			$evdet_jml = count($evdet);
			if ($evdet_jml > 0) {
				foreach ($evdet AS $i => $modDetail) {
					$data['form'] .= $this->renderPartial($this->path_view . '_rowEvaluasiDetail', array('modDetail' => $modDetail), true);
				}
			} else {
				$data['form'] .= $this->renderPartial($this->path_view . '_rowEvaluasiDetail', array('modDetail' => $modDetail), true);
			}
			echo CJSON::encode($data);
			Yii::app()->end();
		}
	}

	protected function saveEvaluasi($post, $implementasiaskep) {
		$modEvaluasi = new ASEvaluasiaskepT;
		$modEvaluasi->attributes = $post;
		$modEvaluasi->no_evaluasi = MyGenerator::noEvaluasiKeperawatan();
		$modEvaluasi->evaluasiaskep_tgl = MyFormatter::FormatDateTimeForDb($post['evaluasiaskep_tgl']);
		$modEvaluasi->implementasiaskep_id = $implementasiaskep['implementasiaskep_id'];
		$modEvaluasi->create_ruangan = Yii::app()->user->ruangan_id;
		$modEvaluasi->create_time = date('Y-m-d');
		$modEvaluasi->create_loginpemakai_id = Yii::app()->user->id;
		$modEvaluasi->ruangan_id = Yii::app()->user->ruangan_id;
		$modEvaluasi->pegawai_id = $post['pegawai_id'];
		if ($modEvaluasi->validate()) {
			$modEvaluasi->save();
			$this->successSave = $this->successSave && true;
		} else {
			$this->successSave = false;
		}

		return $modEvaluasi;
	}

	public function saveEvaluasiDetail($post, $ev) {
		foreach ($post as $i => $row) {
			$modEvDetail = new ASEvaluasiaskepdetT;
			$modEvDetail->attributes = $row;
			$modEvDetail->diagnosakep_id = $row['diagnosakep_id'];
			$modEvDetail->evaluasiaskep_id = $ev->evaluasiaskep_id;
			$modEvDetail->evaluasiaskepdet_subjektif = isset($row['evaluasiaskepdet_subjektif']) ? $row['evaluasiaskepdet_subjektif'] : "";
			$modEvDetail->evaluasiaskepdet_objektif = isset($row['evaluasiaskepdet_objektif']) ? $row['evaluasiaskepdet_objektif'] : "";
			$modEvDetail->evaluasiaskepdet_assessment = isset($row['evaluasiaskepdet_assessment']) ? $row['evaluasiaskepdet_assessment'] : "";
			$modEvDetail->evaluasiaskepdet_planning = isset($row['evaluasiaskepdet_planning']) ? $row['evaluasiaskepdet_planning'] : "";
			$modEvDetail->evaluasiaskepdet_hasil = isset($row['evaluasiaskepdet_hasil']) ? $row['evaluasiaskepdet_hasil'] : "";
			if ($row['isdiagnosa'] == 1) {				
				if ($modEvDetail->validate()) {
					$modEvDetail->save();
					$this->successSave = $this->successSave && true;
				} else {
					$this->successSave = false;
				}
			}
		}
		return $modEvDetail;
	}

	public function actionPrint() {
		$model = ASEvaluasiaskepT::model()->findByPk($_REQUEST['evaluasiaskep_id']);
		$model->attributes = $model;
		$modImplementasi = ASInfoimplementasiaskepV::model()->findByAttributes(array('implementasiaskep_id' => $model->implementasiaskep_id));
		$modPasien = ASInfopasienmasukkamarV::model()->findByAttributes(array('no_pendaftaran' => $modImplementasi->no_pendaftaran));

		$modDetail = new ASEvaluasiaskepdetT;
		$judulLaporan = 'Evaluasi Asuhan Keperawatan';
		$caraPrint = $_REQUEST['caraPrint'];
		if ($caraPrint == 'PRINT') {
			$this->layout = '//layouts/printWindows';
			$this->render($this->path_view . 'Print', array('model' => $model, 'modPasien' => $modPasien, 'modDetail' => $modDetail, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
		} else if ($caraPrint == 'EXCEL') {
			$this->layout = '//layouts/printExcel';
			$this->render($this->path_view . 'Print', array('model' => $model, 'modPasien' => $modPasien, 'modDetail' => $modDetail, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
		} else if ($_REQUEST['caraPrint'] == 'PDF') {
			$ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');   //Ukuran Kertas Pdf
			$posisi = Yii::app()->user->getState('posisi_kertas');   //Posisi L->Landscape,P->Portait
			$mpdf = new MyPDF('', $ukuranKertasPDF);
			$mpdf->useOddEven = 2;
			$stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
			$mpdf->WriteHTML($stylesheet, 1);
			$mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
			$mpdf->WriteHTML($this->renderPartial($this->path_view . 'Print', array('model' => $model, 'modPasien' => $modPasien, 'modDetail' => $modDetail, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
			$mpdf->Output();
		}
	}

	/**
	 * action ajax select tindakan ke form
	 */
	public function actionGetDiagnosa() {
		if (Yii::app()->request->isAjaxRequest) {
			if (!isset($_GET['term'])) {
				$_GET['term'] = null;
			}
			$returnVal = array();

			$criteria = new CDbCriteria();
			if (isset($_GET['diagnosakep_id'])) {
				if (!empty($_GET['diagnosakep_id'])) {
					$criteria->addCondition("diagnosakep_id = " . $_GET['diagnosakep_id']);
				}
			}
			$criteria->order = 'diagnosakep_nama';
			$models = ASDiagnosakepM::model()->findAll($criteria);
			if (isset($models)) {

				foreach ($models as $i => $model) {
					$attributes = $model->attributeNames();

					foreach ($attributes as $j => $attribute) {
						$returnVal[$i]["$attribute"] = $model->$attribute;
					}

					$returnVal[$i]['label'] = $model->diagnosakep_nama;
					$returnVal[$i]['value'] = $model->diagnosakep_id;
				}
			}

			echo CJSON::encode($returnVal);
		}
		Yii::app()->end();
	}

	public function actionDetailImpl($implementasiaskep_id = null) {
		$this->layout = "//layouts/iframe";

		$model = ASInfoimplementasiaskepV::model()->findByAttributes(array('implementasiaskep_id'=>$implementasiaskep_id));
		$model->attributes = $model;
		$modRencana = ASInforencanaaskepV::model()->findByAttributes(array('rencanaaskep_id'=>$model->rencanaaskep_id));
		$modPasien = ASInfopasienmasukkamarV::model()->findByAttributes(array('no_pendaftaran' => $model->no_pendaftaran));


		$this->render($this->path_view . '_detailImplementasi', array(
			'model' => $model, 
			'modRencana' => $modRencana,
			'modPasien' => $modPasien, 
		));
	}

}
