<?php

class RencanaKeperawatanController extends MyAuthController {

	protected $successSave = true;
	public $path_view = "asuhanKeperawatan.views.rencanaKeperawatan.";

	public function actionIndex() {
		if (isset($_GET['frame'])) {
			$this->layout = "//layouts/iframe";
		}
		$model = new ASRencanaaskepT;
		$modDetail = new ASRencanaaskepdetT;
		$modPilih = new ASPilihrencanaaskepT;
		$modPengkajian = new ASPengkajianaskepT;
		$modPasien = new ASInfopengkajianaskepV;



		$nama_modul = Yii::app()->controller->module->id;
		$nama_controller = Yii::app()->controller->id;
		$nama_action = Yii::app()->controller->action->id;
		$modul_id = ModulK::model()->findByAttributes(array('url_modul' => $nama_modul))->modul_id;

		$url_batal = Yii::app()->createAbsoluteUrl(
				Yii::app()->controller->module->id . '/' . Yii::app()->controller->id
		);
		$successSave = false;
//		
		if (isset($_GET['rencanaaskep_id'])) {
			$model = ASRencanaaskepT::model()->findByPk($_GET['rencanaaskep_id']);

			$modPengkajian = ASPengkajianaskepT::model()->findBySql('SELECT pengkajianaskep_t.*,pegawai.nama_pegawai 
			FROM pengkajianaskep_t
			JOIN pegawai_m AS pegawai ON pegawai.pegawai_id = pengkajianaskep_t.pegawai_id
			WHERE pengkajianaskep_id =' . $model->pengkajianaskep_id);
			if($modPengkajian->iskeperawatan == 1){
				$modPasien = ASInfopengkajianaskepV::model()->findByAttributes(array('pengkajianaskep_id' => $model->pengkajianaskep_id));
			}
			if($modPengkajian->iskeperawatan == 0){
				$modPasien = ASInfopengkajiankebidananV::model()->findByAttributes(array('pengkajianaskep_id' => $model->pengkajianaskep_id));
			}
		}

		if (isset($_POST['ASRencanaaskepT']) && !empty($_POST['ASPengkajianaskepT']['pengkajianaskep_id'])) {
			$transaction = Yii::app()->db->beginTransaction();
			try {
				$model = $this->saveRencana($_POST['ASRencanaaskepT'], $_POST['ASPengkajianaskepT']);
				if (isset($_POST['ASRencanaaskepdetT'])) {
					$modRencanaDetail = $this->saveRencanaDetail($_POST['ASRencanaaskepdetT'], $model);
				}
						

				$successSave = $this->successSave;
				
				if ($successSave) {
					Yii::app()->user->setFlash('success', "Data berhasil disimpan");
					$transaction->commit();
					$this->redirect(array('index', 'status' => 1, 'rencanaaskep_id' => $model->rencanaaskep_id, 'iskeperawatan'=>$modPengkajian->iskeperawatan));
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
			'modPilih' => $modPilih,
			'modPengkajian' => $modPengkajian,
			'modPasien' => $modPasien,
			'successSave' => $successSave,
			'url_batal' => $url_batal
				)
		);
	}

	public function actionLoadPasien($pendaftaran_id,$iskeperawatan) {
		if (Yii::app()->request->isAjaxRequest) {
			$data = '';
			if (isset($pendaftaran_id)) {
				if($iskeperawatan == 0){
					$data = ASInfopengkajianaskepV::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id));
				}
				if($iskeperawatan == 1){
					$data = ASInfopengkajiankebidananV::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id));
				}
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

	public function actionGetRencanaDet($rencanaaskep_id) {
		if (Yii::app()->getRequest()->getIsAjaxRequest()) {

			$rencanadet = ASRencanaaskepdetT::model()->findAllBySql(
					'SELECT rencanaaskepdet_t.*,diagnosakep.*,tujuan.*,kriteriahasil.*,intervensi.*
					FROM rencanaaskepdet_t
					JOIN diagnosakep_m AS diagnosakep ON diagnosakep.diagnosakep_id = rencanaaskepdet_t.diagnosakep_id
					JOIN tujuan_m AS tujuan ON tujuan.tujuan_id = rencanaaskepdet_t.tujuan_id
					JOIN kriteriahasil_m AS kriteriahasil ON kriteriahasil.kriteriahasil_id = rencanaaskepdet_t.kriteriahasil_id
					JOIN intervensi_m AS intervensi ON intervensi.intervensi_id = rencanaaskepdet_t.intervensi_id
					WHERE rencanaaskepdet_t.rencanaaskep_id=' . $rencanaaskep_id);
			$data['form'] = "";
			$data['modPilih'] = "";
			if (count($rencanadet) > 0) {
				foreach ($rencanadet AS $i => $modDetail) {
					$pilih = ASPilihrencanaaskepT::model()->findAllBySql(
							'SELECT pilihrencanaaskep_t.*
							FROM pilihrencanaaskep_t
							WHERE pilihrencanaaskep_t.rencanaaskepdet_id =' . $modDetail->rencanaaskepdet_id);
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
					$data['form'] .= $this->renderPartial($this->path_view . '_rowRencanaDetail', array('modDetail' => $modDetail), true);
				}
			} else {
				$data['form'] .= $this->renderPartial($this->path_view . '_rowRencanaDetail', array('modDetail' => $modDetail), true);
			}
			echo CJSON::encode($data);
			Yii::app()->end();
		}
	}

	protected function saveRencana($post, $pengkajianaskep) {

		$modRencana = new ASRencanaaskepT;
		$modRencana->attributes = $post;
		$modRencana->no_rencana = MyGenerator::noRencanaKeperawatan();
		$modRencana->rencanaaskep_tgl = MyFormatter::FormatDateTimeForDb($post['rencanaaskep_tgl']);
		$modRencana->pengkajianaskep_id = $pengkajianaskep['pengkajianaskep_id'];
		$modRencana->create_ruangan = Yii::app()->user->ruangan_id;
		$modRencana->create_time = date('Y-m-d');
		$modRencana->create_loginpemakai_id = Yii::app()->user->id;
		$modRencana->ruangan_id = Yii::app()->user->ruangan_id;
		$modRencana->pegawai_id = $post['pegawai_id'];
		
		if ($modRencana->validate()) {
			$modRencana->save();
			$this->successSave = $this->successSave && true;
		} else {
			$this->successSave = false;
		}

		return $modRencana;
	}

	public function saveRencanaDetail($post, $rencanaaskep) {
		foreach ($post as $i => $row) {
			$modRencanaDetail = new ASRencanaaskepdetT;
			$modRencanaDetail->attributes = $row;
			$modRencanaDetail->rencanaaskep_id = $rencanaaskep->rencanaaskep_id;
			$modRencanaDetail->diagnosakep_id = $row['diagnosakep_id'];
			$modRencanaDetail->tujuan_id = isset($row['tujuan_id']) ? $row['tujuan_id'] : NULL;
			$modRencanaDetail->kriteriahasil_id = isset($row['kriteriahasil_id']) ? $row['kriteriahasil_id'] : NULL;
			$modRencanaDetail->intervensi_id = isset($row['intervensi_id']) ? $row['intervensi_id'] : NULL;
			$modRencanaDetail->iskolaborasi = isset($row['iskolaborasi']) ? $row['iskolaborasi'] : NULL;
			$modRencanaDetail->rencanaaskepdet_ketkolaborasi = isset($row['rencanaaskepdet_ketkolaborasi']) ? $row['rencanaaskepdet_ketkolaborasi'] : "";
			$modRencanaDetail->rencanaaskepdet_hari = isset($row['rencanaaskepdet_hari']) ? $row['rencanaaskepdet_hari'] : NULL;
			
			if ($modRencanaDetail->validate()) {
				$modRencanaDetail->save();
				if ($row['alternatifdx_id']) {
					$this->savePilihDiagnosaAlternatif($modRencanaDetail, $row['alternatifdx_id']);
				}
				if ($row['tandagejala_id']) {
					$this->savePilihTanda($modRencanaDetail, $row['tandagejala_id']);
				}
				if ($row['kriteriahasildet_id']) {
					$this->savePilihKriteria($modRencanaDetail, $row['kriteriahasildet_id'], $row['rencanaaskep_ir'], $row['rencanaaskep_er']);
				}

				if ($row['intervensidet_id']) {
					$this->savePilihIntervensi($modRencanaDetail, $row['intervensidet_id']);
				}
//					$this->savePilihRencana($row,$modRencanaDetail,$_POST['ASKriteriahasildetM'][$i]);
				$this->successSave = $this->successSave && true;
			} else {
				$this->successSave = false;
			}
		}
		return $modRencanaDetail;
	}

	public function savePilihDiagnosaAlternatif($rencanadetail, $post) {
		foreach ($post as $i => $row) {
			$modRencanaDetail = new ASPilihrencanaaskepT;
			$modRencanaDetail->rencanaaskepdet_id = $rencanadetail->rencanaaskepdet_id;
			$modRencanaDetail->alternatifdx_id = $row;
			
			if ($modRencanaDetail->validate()) {
				$modRencanaDetail->save();
				$this->successSave = $this->successSave && true;
			} else {
				$this->successSave = false;
			}
		}
		return $modRencanaDetail;
	}
	
	public function savePilihTanda($rencanadetail, $post) {
		foreach ($post as $i => $row) {
			$modRencanaDetail = new ASPilihrencanaaskepT;
			$modRencanaDetail->rencanaaskepdet_id = $rencanadetail->rencanaaskepdet_id;
			$modRencanaDetail->tandagejala_id = $row;
			
			if ($modRencanaDetail->validate()) {
				$modRencanaDetail->save();
				$this->successSave = $this->successSave && true;
			} else {
				$this->successSave = false;
			}
		}
		return $modRencanaDetail;
	}

	public function savePilihKriteria($rencanadetail, $kriteria, $ir, $er) {
		foreach ($kriteria as $i => $row) {
			if ($row > 0) {
				$modRencanaDetail = new ASPilihrencanaaskepT;
				$modRencanaDetail->rencanaaskepdet_id = $rencanadetail->rencanaaskepdet_id;
				$modRencanaDetail->kriteriahasildet_id = $row;
				$modRencanaDetail->rencanaaskep_ir = isset($ir[$i]['rencanaaskep_ir']) ? $ir[$i]['rencanaaskep_ir'] : NULL;
				$modRencanaDetail->rencanaaskep_er = isset($er[$i]['rencanaaskep_er']) ? $er[$i]['rencanaaskep_er'] : NULL;
				if ($modRencanaDetail->validate()) {
					$modRencanaDetail->save();
					$this->successSave = $this->successSave && true;
				} else {
					$this->successSave = false;
				}
			}
		}
		return $modRencanaDetail;
	}

	public function savePilihIntervensi($rencanadetail, $post) {
		foreach ($post as $i => $row) {
			$modRencanaDetail = new ASPilihrencanaaskepT;
			$modRencanaDetail->rencanaaskepdet_id = $rencanadetail->rencanaaskepdet_id;
			$modRencanaDetail->intervensidet_id = $row;
			if ($modRencanaDetail->validate()) {
				$modRencanaDetail->save();
				$this->successSave = $this->successSave && true;
			} else {
				$this->successSave = false;
			}
		}
		return $modRencanaDetail;
	}

	protected function savePilihRencana($row, $rencanaaskepdet, $kriteria) {

		$modPilihRencana = new ASPilihrencanaaskepT;
		$modPilihRencana->attributes = $row;
		$modPilihRencana->rencanaaskepdet_id = $rencanaaskepdet['rencanaaskepdet_id'];
		$modPilihRencana->tandagejala_id = $row['tandagejala_id'];
		$modPilihRencana->intervensidet_id = $row['intervensidet_id'];
		$modPilihRencana->kriteriahasildet_id = $row['kriteriadet_id'];
		$modPilihRencana->rencanaaskep_ir = isset($kriteria['rencanaaskep_ir']) ? $kriteria['rencanaaskep_ir'] : NULL;
		$modPilihRencana->rencanaaskep_er = isset($kriteria['rencanaaskep_er']) ? $kriteria['rencanaaskep_er'] : NULL;
		if ($modPilihRencana->validate()) {
			$modPilihRencana->save();
			$this->successSave = $this->successSave && true;
		} else {
			$this->successSave = false;
		}

		return $modPilihRencana;
	}

	public function actionPrint() {
		$model = ASRencanaaskepT::model()->findByPk($_REQUEST['rencanaaskep_id']);
		$model->attributes = $model;
		$modPengkajian = ASPengkajianaskepT::model()->findByPk($model->pengkajianaskep_id);
		
		if($modPengkajian->iskeperawatan == 1){
			$modPasien = ASInfopengkajianaskepV::model()->findByAttributes(array('pengkajianaskep_id' => $model->pengkajianaskep_id));

		}
		if($modPengkajian->iskeperawatan == 0){
			$modPasien = ASInfopengkajiankebidananV::model()->findByAttributes(array('pengkajianaskep_id' => $model->pengkajianaskep_id));
		}

		$modDetail = new ASRencanaaskepdetT;
		$judulLaporan = 'Rencana Keperawatan';
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

	public function actionGetPenunjang($pengkajianaskep_id) {
		if (Yii::app()->getRequest()->getIsAjaxRequest()) {
			$penunjang = ASDatapenunjangT::model()->findAllByAttributes(array('pengkajianaskep_id' => $pengkajianaskep_id));
			$data['form'] = "";

			if (count($penunjang) > 0) {
				foreach ($penunjang AS $i => $modPenunjang) {
					$data['form'] .= $this->renderPartial($this->path_view . '_rowPenunjang', array('modPenunjang' => $modPenunjang), true);
				}
			} else {
				$data['form'] .= $this->renderPartial($this->path_view . '_rowPenunjang', array('modPenunjang' => $modPenunjang), true);
			}
			echo CJSON::encode($data);
			Yii::app()->end();
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
	
	public function actionGetDiagnosaRow($diagnosakep_id = null) {
		if (Yii::app()->request->isAjaxRequest) {
			$modRencanaDet = new ASRencanaaskepdetT;
			$data['form'] = "";
			$diagnosa = ASDiagnosakepM::model()->findByPk($diagnosakep_id);
			$data['form'] .= "<div class='diagdetail'>";
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
			$data['form'] .= CHtml::activeCheckBoxList($modRencanaDet, '[0]alternatifdx_id', CHtml::listData(AlternatifdxM::model()->findAllByAttributes(array('alternatifdx_aktif' => true, 'diagnosakep_id' => $diagnosakep_id)), 'alternatifdx_id', 'alternatifdx_nama'));
			
			$data['form'] .= "</div>";
		}
		echo CJSON::encode($data);
		Yii::app()->end();
	}
	
	public function actionDetailPengkajian() {
		$this->layout = "//layouts/iframe";
		$modPengkajian = ASInfopengkajianaskepV::model()->findByAttributes(array('pengkajianaskep_id' => $_GET['pengkajianaskep_id']));
		$modPengkajian->attributes = $modPengkajian;

		$anamnesa = new ASAnamnesaT;
		$criteria = new CDbCriteria();
		$criteria->addCondition('anamesa_id =' . $modPengkajian->anamesa_id);
		$modAnamnesa = new CActiveDataProvider($anamnesa, array(
			'criteria' => $criteria,
		));

		$periksafisik = new ASPemeriksaanfisikT;
		$criteria = new CDbCriteria();
		$criteria->addCondition('pemeriksaanfisik_id =' . $modPengkajian->pemeriksaanfisik_id);
		$modPeriksaFisik = new CActiveDataProvider($periksafisik, array(
			'criteria' => $criteria,
		));

		$penunjang = new ASDatapenunjangT;
		$criteria = new CDbCriteria();
		$criteria->addCondition('pengkajianaskep_id =' . $modPengkajian->pengkajianaskep_id);
		$modPenunjang = new CActiveDataProvider($penunjang, array(
			'criteria' => $criteria,
		));


		$this->render($this->path_view . '_detailPengkajian', array(
			'modPengkajian' => $modPengkajian,
			'modAnamnesa' => $modAnamnesa,
			'modPeriksaFisik' => $modPeriksaFisik,
			'modPenunjang' => $modPenunjang
		));
	}
	
	public function actionDetailPengkajianKeb() {
		$this->layout = "//layouts/iframe";
		$modPengkajian = ASInfopengkajiankebidananV::model()->findByAttributes(array('pengkajianaskep_id'=>$_GET['pengkajianaskep_id']));
		$modPengkajian->attributes = $modPengkajian;

		$anamnesa = new ASAnamnesaT;
		$criteria = new CDbCriteria();
		$criteria->addCondition('anamesa_id ='.$modPengkajian->anamesa_id);
		$modAnamnesa = ASAnamnesaT::model()->find($criteria);
		
		$periksafisik = new ASPemeriksaanfisikT;
		$criteria = new CDbCriteria();
		$criteria->addCondition('pemeriksaanfisik_id ='.$modPengkajian->pemeriksaanfisik_id);
		$modPemeriksaanFisik = ASPemeriksaanfisikT::model()->find($criteria);
		$modPemeriksaanGambar = ASPemeriksaangambarT::model()->findAllByAttributes(array('pendaftaran_id' => $modPemeriksaanFisik->pendaftaran_id));
		$modGambarTubuh = new ASGambartubuhM();
		$modBagianTubuh = new ASBagiantubuhM();
		
		$penunjang = new ASDatapenunjangT;
		$criteria = new CDbCriteria();
		$criteria->addCondition('pengkajianaskep_id ='.$modPengkajian->pengkajianaskep_id);
		$modPenunjang = new CActiveDataProvider($penunjang, array(
			'criteria' => $criteria,
		));
		
		$perkawinan = new ASRiwayatperkawinanR;
		$persalinan = new ASRiwayatpersalinanR;
        $criteria = new CDbCriteria();
		$criteria->addCondition('anamesa_id =' . $modPengkajian->anamesa_id);

		$modPerkawinan = new CActiveDataProvider($perkawinan, array(
			'criteria' => $criteria,
		));
		$modPersalinan = new CActiveDataProvider($persalinan, array(
			'criteria' => $criteria,
		));


		$this->render($this->path_view . '_detailPengkajianKeb', array(
			'modPengkajian' => $modPengkajian, 
			'modAnamnesa' => $modAnamnesa, 
			'modPemeriksaanFisik' => $modPemeriksaanFisik,
			'modPemeriksaanGambar' => $modPemeriksaanGambar,
			'modGambarTubuh' => $modGambarTubuh,
			'modBagianTubuh' => $modBagianTubuh,
			'modPenunjang' => $modPenunjang,
			'modPerkawinan' => $modPerkawinan,
			'modPersalinan' => $modPersalinan,
		));
	}

}
