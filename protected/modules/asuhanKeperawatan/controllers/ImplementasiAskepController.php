<?php

class ImplementasiAskepController extends MyAuthController {

	protected $successSave = true;
	public $path_view = "asuhanKeperawatan.views.implementasiAskep.";

	public function actionIndex() {
		if (isset($_GET['frame'])) {
			$this->layout = "//layouts/iframe";
		}
		$model = new ASImplementasiaskepT;
		$modDetail = new ASImplementasiaskepdetT;
		$modPilih = new ASPilihimplementasiaskepT;
		$modRencana = new ASRencanaaskepT;
		$modPasien = new ASInforencanaaskepV;


                $model->no_implementasi = "- Otomatis -";
		$nama_modul = Yii::app()->controller->module->id;
		$nama_controller = Yii::app()->controller->id;
		$nama_action = Yii::app()->controller->action->id;
		$modul_id = ModulK::model()->findByAttributes(array('url_modul' => $nama_modul))->modul_id;

		$url_batal = Yii::app()->createAbsoluteUrl(
				Yii::app()->controller->module->id . '/' . Yii::app()->controller->id
		);
		$successSave = false;
//		
		if (isset($_GET['implementasiaskep_id'])) {
			$model = ASImplementasiaskepT::model()->findByPk($_GET['implementasiaskep_id']);

			$modRencana = ASRencanaaskepT::model()->findBySql('SELECT rencanaaskep_t.*,pegawai.nama_pegawai 
			FROM rencanaaskep_t
			JOIN pegawai_m AS pegawai ON pegawai.pegawai_id = rencanaaskep_t.pegawai_id
			WHERE rencanaaskep_id =' . $model->rencanaaskep_id);

			$modPasien = ASInforencanaaskepV::model()->findByAttributes(array('rencanaaskep_id' => $model->rencanaaskep_id));
		}

		if (isset($_POST['ASImplementasiaskepT']) && !empty($_POST['ASRencanaaskepT']['rencanaaskep_id'])) {
			$transaction = Yii::app()->db->beginTransaction();
			try {
				$model = $this->saveImplementasi($_POST['ASImplementasiaskepT'], $_POST['ASRencanaaskepT']);
				if (isset($_POST['ASRencanaaskepdetT'])) {
					$modDetail = $this->saveImplementasiDetail($_POST['ASRencanaaskepdetT'], $model, $_POST['ASRencanaaskepT']);
				}

				$successSave = $this->successSave;

				if ($successSave) {
					Yii::app()->user->setFlash('success', "Data berhasil disimpan");
					$transaction->commit();
					$this->redirect(array('index', 'status' => 1, 'implementasiaskep_id' => $model->implementasiaskep_id));
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
			'modRencana' => $modRencana,
			'modPasien' => $modPasien,
			'successSave' => $successSave,
			'url_batal' => $url_batal
				)
		);
	}
        
        public function actionCekRencanaId($rencanaaskep_id) {
		if (Yii::app()->request->isAjaxRequest) {
			$data = '';
			if (isset($rencanaaskep_id)) {
				$data = ASImplementasiaskepT::model()->findByAttributes(array('rencanaaskep_id'=>$rencanaaskep_id));
			}
			echo CJSON::encode($data);
		}
		Yii::app()->end();
	}

	public function actionLoadPasien($rencanaaskep_id) {
		if (Yii::app()->request->isAjaxRequest) {
			$data = '';
			if (isset($rencanaaskep_id)) {
				$data = ASInforencanaaskepV::model()->findByAttributes(array('rencanaaskep_id' => $rencanaaskep_id));
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
					LEFT JOIN diagnosakep_m AS diagnosakep ON diagnosakep.diagnosakep_id = rencanaaskepdet_t.diagnosakep_id
					LEFT JOIN tujuan_m AS tujuan ON tujuan.tujuan_id = rencanaaskepdet_t.tujuan_id
					LEFT JOIN kriteriahasil_m AS kriteriahasil ON kriteriahasil.kriteriahasil_id = rencanaaskepdet_t.kriteriahasil_id
					LEFT JOIN intervensi_m AS intervensi ON intervensi.intervensi_id = rencanaaskepdet_t.intervensi_id
					WHERE rencanaaskepdet_t.rencanaaskep_id=' . $rencanaaskep_id);
			$data['form'] = "";
			$data['modPilih'] = "";
			$rencanadet_jml = count($rencanadet);
			$modPilih = array();
			if ($rencanadet_jml > 0) {
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
					$data['form'] .= $this->renderPartial($this->path_view . '_rowImplementasiDetail', array('modDetail' => $modDetail, 'rencanadet_jml' => $rencanadet_jml), true);
				}
			} else {
				$data['form'] .= $this->renderPartial($this->path_view . '_rowImplementasiDetail', array('modDetail' => $modDetail), true);
			}
			echo CJSON::encode($data);
			Yii::app()->end();
		}
	}

	public function actionGetImplDet($implementasiaskep_id) {
		if (Yii::app()->getRequest()->getIsAjaxRequest()) {

			$impldet = ASImplementasiaskepdetT::model()->findAllBySql(
					'SELECT implementasiaskepdet_t.*,diagnosakep.*
					FROM implementasiaskepdet_t
					JOIN diagnosakep_m AS diagnosakep ON diagnosakep.diagnosakep_id = implementasiaskepdet_t.diagnosakep_id
					WHERE implementasiaskepdet_t.implementasiaskep_id=' . $implementasiaskep_id);
			$data['form'] = "";
			$data['modPilih'] = "";
			$impldet_jml = count($impldet);
			if ($impldet_jml > 0) {
				foreach ($impldet AS $i => $modDetail) {
					$pilih = ASPilihimplementasiaskepT::model()->findAllBySql(
							'SELECT pilihimplementasiaskep_t.*
							FROM pilihimplementasiaskep_t
							WHERE pilihimplementasiaskep_t.implementasiaskepdet_id =' . $modDetail->implementasiaskepdet_id);
					foreach ($pilih AS $x => $Pilih) {
						$modPilih[$i][$x]['pilihimplementasiaskep_id'] = $Pilih->pilihimplementasiaskep_id;
						$modPilih[$i][$x]['implementasiaskepdet_id'] = $Pilih->implementasiaskepdet_id;
						$modPilih[$i][$x]['indikatorimplkepdet_id'] = $Pilih->indikatorimplkepdet_id;
						$modPilih[$i][$x]['alternatifdx_id'] = $Pilih->alternatifdx_id;
					}

					$data['modPilih'] = $modPilih;
					$data['form'] .= $this->renderPartial($this->path_view . '_rowImplementasiDetail', array('modDetail' => $modDetail), true);
				}
			} else {
				$data['form'] .= $this->renderPartial($this->path_view . '_rowImplementasiDetail', array('modDetail' => $modDetail), true);
			}
			echo CJSON::encode($data);
			Yii::app()->end();
		}
	}

	protected function saveImplementasi($post, $rencanaaskep) {

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
              //  var_dump($modImplementasi->create_loginpemakai_id);die;
		if ($modImplementasi->validate()) {
                    
			$modImplementasi->save();
                        
			$this->successSave = $this->successSave && true;
		} else {
			$this->successSave = false;
		}

		return $modImplementasi;
	}

	public function saveImplementasiDetail($post, $impl) {
		foreach ($post as $i => $row) {
			$modImplDetail = new ASImplementasiaskepdetT;
			$modImplDetail->attributes = $row;
			$modImplDetail->implementasiaskep_id = $impl->implementasiaskep_id;
			$modImplDetail->diagnosakep_id = $row['diagnosakep_id'];
			$modImplDetail->implementasiaskepdet_iskolaborasi = isset($row['iskolaborasi']) ? $row['iskolaborasi'] : NULL;
			$modImplDetail->implementasiaskepdet_ketkolaborasi = isset($row['rencanaaskepdet_ketkolaborasi']) ? $row['rencanaaskepdet_ketkolaborasi'] : "";
			$modImplDetail->rencanaaskepdet_id = $row['rencanaaskepdet_id'];
			if ($row['isdiagnosa'] == 1) {
				if ($modImplDetail->validate()) {
					$modImplDetail->save();
					if ($row['alternatifdx_id']) {
						$this->savePilihDiagnosaAlternatif($modImplDetail, $row['alternatifdx_id']);
					}
					if ($row['indikatorimplkepdet_id']) {
						$this->savePilihImplementasi($modImplDetail, $row['indikatorimplkepdet_id']);
					}

					$this->successSave = $this->successSave && true;
				} else {
					$this->successSave = false;
				}
			}
		}
		return $modImplDetail;
	}

	public function savePilihDiagnosaAlternatif($impldetail, $post) {
		foreach ($post as $i => $row) {
			$modImplPilih = new ASPilihimplementasiaskepT;
			$modImplPilih->implementasiaskepdet_id = $impldetail->implementasiaskepdet_id;
			$modImplPilih->alternatifdx_id = $row;
			if ($modImplPilih->validate()) {
				$modImplPilih->save();
				$this->successSave = $this->successSave && true;
			} else {
				$this->successSave = false;
			}
		}
		return $modImplPilih;
	}

	public function savePilihImplementasi($impldetail, $post) {
		foreach ($post as $i => $row) {
			$modImplPilih = new ASPilihimplementasiaskepT;
			$modImplPilih->implementasiaskepdet_id = $impldetail->implementasiaskepdet_id;
			$modImplPilih->indikatorimplkepdet_id = $row;
			if ($modImplPilih->validate()) {
				$modImplPilih->save();
				$this->successSave = $this->successSave && true;
			} else {
				$this->successSave = false;
			}
		}
		return $modImplPilih;
	}

	public function actionPrint() {
		$model = ASImplementasiaskepT::model()->findByPk($_REQUEST['implementasiaskep_id']);
		$model->attributes = $model;
		$modRencana = ASInforencanaaskepV::model()->findByAttributes(array('rencanaaskep_id' => $model->rencanaaskep_id));
		$modPasien = ASInfopasienmasukkamarV::model()->findByAttributes(array('no_pendaftaran' => $modRencana->no_pendaftaran));
                
                if(count($modPasien) == 0){
			$modPasien = ASPasienpulangrddanriV::model()->findByAttributes(array('no_pendaftaran' => $modRencana->no_pendaftaran));
                }

		$modDetail = new ASImplementasiaskepdetT;
		$judulLaporan = 'Implementasi Asuhan Keperawatan';
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
                        $mpdf->mirrorMargins = 2;
			$stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
			$mpdf->WriteHTML($stylesheet, 1);
			$mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
			$mpdf->WriteHTML($this->renderPartial($this->path_view . 'Print', array('model' => $model, 'modPasien' => $modPasien, 'modDetail' => $modDetail, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
			$mpdf->Output($judulLaporan.'_'.date('Y-m-d').'.pdf','I');
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

	public function actionDetailRencana($rencanaaskep_id = null,$iskeperawatan = null) {
		$this->layout = "//layouts/iframe";

		$model = ASInforencanaaskepV::model()->findByAttributes(array('rencanaaskep_id' => $rencanaaskep_id));
		$model->attributes = $model;
                
                if($iskeperawatan == 1){
			$modPasien = ASInfopengkajianaskepV::model()->findByAttributes(array('pengkajianaskep_id' => $model->pengkajianaskep_id));
		}else{
			$modPasien = ASInfopengkajiankebidananV::model()->findByAttributes(array('pengkajianaskep_id' => $model->pengkajianaskep_id));
		}
                
		$modPasien = ASInfopengkajianaskepV::model()->findByAttributes(array('pengkajianaskep_id' => $model->pengkajianaskep_id));


		$this->render($this->path_view . '_detailRencana', array(
			'model' => $model,
			'modPasien' => $modPasien,
		));
	}
        
        public function actionAutocompleteRencana() {
		if (Yii::app()->request->isAjaxRequest) {
			$format = new MyFormatter();
			$returnVal = array();

			$criteria = new CDbCriteria();
                        $criteria->join = " LEFT JOIN implementasiaskep_t imple ON imple.rencanaaskep_id = t.rencanaaskep_id "
                                . " RIGHT  JOIN pengkajianaskep_t peng ON peng.pengkajianaskep_id = t.pengkajianaskep_id "
                                . " JOIN pendaftaran_t p ON p.pendaftaran_id = peng.pendaftaran_id "                                 
                                . " JOIN pegawai_m peg ON peg.pegawai_id = t.pegawai_id";		                
                        $criteria->addCondition(' imple.rencanaaskep_id IS NULL');		
                        $criteria->addCondition("t.ruangan_id  = '".Yii::app()->user->getState('ruangan_id')."' ");
			$criteria->compare('LOWER(t.no_rencana)', strtolower($_GET['term']), true);
			$criteria->limit = 5;
			//$models = ASInforencanaaskepV::model()->findAll($criteria);
                        $models = ASRencanaaskepT::model()->findAll($criteria);
			foreach ($models as $i => $model) {
				$attributes = $model->attributeNames();
				foreach ($attributes as $j => $attribute) {
					$returnVal[$i]["$attribute"] = $model->$attribute;
				}
				$returnVal[$i]['label'] = $model->no_rencana . ' - ' . $model->pengkajianaskep->pendaftaran->pasien->no_rekam_medik . ' - ' . $model->pengkajianaskep->pendaftaran->pasien->nama_pasien . (!empty($model->pengkajianaskep->pendaftaran->pasien->nama_bin) ? "(" . $model->pengkajianaskep->pendaftaran->pasien->nama_bin . ")" : "");
				$returnVal[$i]['value'] = $model->no_rencana;
			}

			echo CJSON::encode($returnVal);
		}
		Yii::app()->end();
	}
	
	public function actionPegawairiwayat()
        {
            if(Yii::app()->request->isAjaxRequest) {
                $criteria = new CDbCriteria();
                $criteria->compare('LOWER(nama_pegawai)', strtolower($_GET['term']), true);
                $criteria->limit=5;
                $models = PegawaiM::model()->findAll($criteria);

                foreach($models as $i=>$model)
                {
                    $attributes = $model->attributeNames();
                    foreach($attributes as $j=>$attribute) {
                        $returnVal[$i]["$attribute"] = $model->$attribute;
                    }
                    $returnVal[$i]['label'] = $model->nomorindukpegawai.' - '.$model->nama_pegawai.' - '.$model->jeniskelamin;
                    $returnVal[$i]['nama_pegawai'] = $model->nama_pegawai;
                    $returnVal[$i]['value'] = $model->pegawai_id;
                    $returnVal[$i]['jabatan_nama'] = (isset($model->jabatan->jabatan_nama) ? $model->jabatan->jabatan_nama : '-');
                }

                echo CJSON::encode($returnVal);
            }
            Yii::app()->end();

        }

}
