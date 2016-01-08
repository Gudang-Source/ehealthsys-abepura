<?php

class PenutupanPeriodeAkuntansiTController extends MyAuthController {

	public $layout = "//layouts/column1";
	public $saldoAwal = true;
	public $updateRekPeriode = false;

	public function actionIndex() {
		$format = new MyFormatter;
		$model = new AKSaldoawalT;
		$modRekPeriod = new AKRekperiodM;
		$modRekPeriod->is_rekeningbaru = 1;

		// insert Rekening Periode Baru
		if (isset($_POST['AKRekperiodM'])) {
			$transaction = Yii::app()->db->beginTransaction();
			try {
				if ($_POST['AKRekperiodM']['is_rekeningbaru']) {
					$modRekPeriod = new AKRekperiodM;
					$modRekPeriod->attributes = $_POST['AKRekperiodM'];
					$modRekPeriod->perideawal = $format->formatDateTimeForDb($_POST['AKRekperiodM']['perideawal']);
					$modRekPeriod->sampaidgn = $format->formatDateTimeForDb($_POST['AKRekperiodM']['perideawal']);
					$modRekPeriod->save();
				}

				// insert saldoawal_t
				$totalDebit = $format->formatNumberForDb($_POST['totalDebit']);
				$totalKredit = $format->formatNumberForDb($_POST['totalKredit']);
				foreach ($_POST['AKSaldoawalT'] as $i => $detail) {
					$modDetail = new AKSaldoawalT;
					$modDetail->attributes = $detail;
					$modDetail->jmlanggaran = $totalDebit + $totalKredit;
					$modDetail->jmlsaldoawald = $totalDebit;
					$modDetail->jmlsaldoawalk = $totalKredit;
					$modDetail->jmlmutasid = 0;
					$modDetail->jmlmutasik = 0;
					$modDetail->jmlsaldoakhird = 0;
					$modDetail->jmlsaldoakhirk = 0;
					$modDetail->create_time = date("Y-m-d H:i:s");
					$modDetail->create_loginpemakai_id = Yii::app()->user->id;
					$modDetail->create_ruangan = Yii::app()->user->ruangan_id;
					if ($modDetail->save()) {
						$this->saldoAwal &= true;
					} else {
						$this->saldoAwal &= false;
					}
				}
				
				// update rekperiod_m isclosing = 'TRUE'  
				if ($this->saldoAwal) {
					$updateRekPeriode = RekperiodM::model()->updateByPk($_POST['AKSaldoawalT'][0]['rekperiod_id'], array('isclosing' => true));
					if ($updateRekPeriode) {
						$this->updateRekPeriode = true;
					}
				}

				if ($this->saldoAwal && $this->updateRekPeriode) {
					$transaction->commit();
					$this->redirect(array('index', 'sukses' => 1));
				} else {
					$transaction->rollback();
					Yii::app()->user->setFlash('error', "Data Penutupan Periode Rekening gagal disimpan !");
				}
			} catch (Exception $e) {
				$transaction->rollback();
				Yii::app()->user->setFlash('error', "Data Penutupan Periode Rekening gagal disimpan ! " . MyExceptionMessage::getMessage($e, true));
			}
		}
//		
		$this->render('index', array(
			'format' => $format,
			'modRekPeriod' => $modRekPeriod
		));
	}

	/**
	 * menampilkan data pencarian rekening baru
	 * @return row table 
	 */
	public function actionCariRekeningBaru() {
		if (Yii::app()->request->isAjaxRequest) {
			$format = new MyFormatter;
			$pesan = '';
			$deskripsi = '';
			$rekperiod_id = '';
			$perideawal = $format->formatDateTimeForDb($_POST['perideawal']);
			$sampaidgn = $format->formatDateTimeForDb($_POST['sampaidgn']);

			$criteria = new CDbCriteria();
			$criteria->addCondition("DATE(perideawal) = '" . $perideawal . "'");
			$criteria->addCondition("DATE(sampaidgn) = '" . $sampaidgn . "'");
			$criteria->addCondition('isclosing IS FALSE');
			$modRekPeriod = AKRekperiodM::model()->find($criteria);

			if (count($modRekPeriod) > 0) {
				$pesan = "Ada";
				$deskripsi = $modRekPeriod->deskripsi;
				$rekperiod_id = $modRekPeriod->rekperiod_id;
			}

			echo CJSON::encode(array(
				'rekperiod_id' => $rekperiod_id,
				'deskripsi' => $deskripsi,
				'pesan' => $pesan,
					)
			);
			exit;
		}
	}

	/**
	 * menampilkan data rekening
	 * @return row table 
	 */
	public function actionLoadTabelRekening() {
		if (Yii::app()->request->isAjaxRequest) {
			$format = new MyFormatter;
			$modSaldoAwal = new AKSaldoawalT;
			$pesan = '';
			$rekperiod_id = $_POST['rekperiod_id'];
//            $rekperiod_id	= 2;
			$criteria = new CDbCriteria;
			$criteria->join = "LEFT JOIN periodeposting_m ON periodeposting_m.periodeposting_id = t.periodeposting_id";
			$criteria->group = "t.periodeposting_id,rekening5_id, saldodebit,saldokredit";
			$criteria->select = $criteria->group . ", SUM(saldodebit) AS Debit, SUM(saldokredit) AS Kredit";
			if (!empty($this->periodeposting_id)) {
				$criteria->addCondition('t.periodeposting_id = ' . $this->periodeposting_id);
			}
			if (!empty($rekperiod_id)) {
				$criteria->addCondition('periodeposting_m.rekperiode_id = ' . $rekperiod_id);
			}

			$modRekenings = AKBukubesarT::model()->findAll($criteria);

			if (count($modRekenings) > 0)
				$pesan = "Ada";

			echo CJSON::encode(array(
				'pesan' => $pesan,
				'form' => $this->renderPartial('_rowRekening', array(
					'format' => $format,
					'modRekenings' => $modRekenings,
					'modSaldoAwal' => $modSaldoAwal
						), true))
			);
			exit;
		}
	}

	public function actionAutocompleteRekeningPeriode() {
		if (Yii::app()->request->isAjaxRequest) {
			$returnVal = array();
			$criteria = new CDbCriteria();
			$criteria->compare('LOWER(deskripsi)', strtolower($_GET['deskripsi']), true);
			$criteria->order = 'rekperiod_id';
			$criteria->limit = 5;
			$models = AKRekperiodM::model()->findAll($criteria);
			foreach ($models as $i => $model) {
				$attributes = $model->attributeNames();
				foreach ($attributes as $j => $attribute) {
					$returnVal[$i]["$attribute"] = $model->$attribute;
				}
				$returnVal[$i]['label'] = $model->deskripsi;
				$returnVal[$i]['value'] = $model->rekperiod_id;
			}

			echo CJSON::encode($returnVal);
		}
		Yii::app()->end();
	}

}
