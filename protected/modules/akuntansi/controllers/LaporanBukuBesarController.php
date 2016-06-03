<?php
class LaporanBukuBesarController extends MyAuthController{
	
	public $path_view = 'akuntansi.views.laporanBukuBesar.';
	
	public function actionIndex() {
		$format = new MyFormatter();
		$modelLaporan = new AKLaporanbukubesarV('searchLaporan');
		$modelLaporan->unsetAttributes();
		$modelLaporan->periodeposting_id = isset(AKLaporanbukubesarV::model()->getTglPeriode()->periodeposting_id) ? AKLaporanbukubesarV::model()->getTglPeriode()->periodeposting_id : null;
		$criteria = new CDbCriteria;
		if (isset($_GET['AKLaporanbukubesarV'])) {
			$modelLaporan->attributes = $_GET['AKLaporanbukubesarV'];
			$modelLaporan->namarekening = $_GET['AKLaporanbukubesarV']['namarekening'];
			$modelLaporan->periodeposting_id = $_GET['AKLaporanbukubesarV']['periodeposting_id'];
			$modelLaporan->rekening5_id = $_GET['AKLaporanbukubesarV']['rekening5_id'];

			$criteria->compare('LOWER(nmrekening5)', strtolower($_GET['AKLaporanbukubesarV']['namarekening']),true);
			if (!empty($modelLaporan->periodeposting_id)) {
				$criteria->addCondition('periodeposting_id = ' . $modelLaporan->periodeposting_id);
			}
			if (!empty($modelLaporan->rekening5_id)) {
				$criteria->addCondition('rekening5_id = ' . $modelLaporan->rekening5_id);
			}
			if (empty($_GET['AKLaporanbukubesarV']['namarekening'])) {
				$qr_rekeningjurnal5_nama = null;
			} else {
				$qr_rekeningjurnal5_nama = "AND nmrekening5 = '" . $_GET['AKLaporanbukubesarV']['namarekening'] . "'";
			}

		} else {
			$qr_rekeningjurnal5_nama = null;
			$qr_kdrekening5 = null;
			if (!empty($modelLaporan->periodeposting_id)) {
				$criteria->addCondition('periodeposting_id = ' . $modelLaporan->periodeposting_id);
			}
		}
//		
		$criteria->order = 'rekening5_id, tglbukubesar, bukubesar_id';
		$model = AKLaporanbukubesarV::model()->findAll($criteria);

		if ($modelLaporan->ruangan_id == '') {
			$query_ruangan_id = null;
		} else {
			$query_ruangan_id = "ruangan_id=" . $modelLaporan->ruangan_id . " AND";
		}

		$criteria2 = new CDbCriteria();
		$criteria2->select = 'count(nmrekening5) as urutan';
		if (!empty($modelLaporan->ruangan_id)) {
			$criteria2->addCondition('ruangan_id = ' . $modelLaporan->ruangan_id);
		}
		
		if (!empty($modelLaporan->periodeposting_id)) {
			$criteria2->addCondition('periodeposting_id = ' . $modelLaporan->periodeposting_id);
		}
		if (empty($_GET['AKLaporanbukubesarV']['namarekening'])) {
			$qr_rekeningjurnal5_nama = null;
		} else {
			$criteria2->addCondition("nmrekening5 = '" . $_GET['AKLaporanbukubesarV']['namarekening'] . "'");
		}

		$criteria2->group = 'rekening5_id, tglbukubesar, bukubesar_id';
		$jmlRekening = AKLaporanbukubesarV::model()->findAll($criteria2);
		$this->render($this->path_view.'admin', array(
			'model' => $model,
			'modelLaporan' => $modelLaporan,
			'jmlrekening' => $jmlRekening
		));
	}

	public function actionPrintLaporanBukuBesar() {
		$format = new MyFormatter();
		$modelLaporan = new AKLaporanbukubesarV('searchLaporan');
		$modelLaporan->unsetAttributes();
		$modelLaporan->periodeposting_id = AKLaporanbukubesarV::model()->getTglPeriode()->periodeposting_id;
		$criteria = new CDbCriteria;
		if (isset($_GET['AKLaporanbukubesarV'])) {
			$modelLaporan->attributes = $_GET['AKLaporanbukubesarV'];
			$modelLaporan->namarekening = $_GET['AKLaporanbukubesarV']['namarekening'];
			$modelLaporan->periodeposting_id = $_GET['AKLaporanbukubesarV']['periodeposting_id'];

			$criteria->compare('LOWER(nmrekening5)', strtolower($_GET['AKLaporanbukubesarV']['namarekening']),true);
			if (!empty($modelLaporan->periodeposting_id)) {
				$criteria->addCondition('periodeposting_id = ' . $modelLaporan->periodeposting_id);
			}

			if (empty($_GET['AKLaporanbukubesarV']['namarekening'])) {
				$qr_rekeningjurnal5_nama = null;
			} else {
				$qr_rekeningjurnal5_nama = "AND nmrekening5 = '" . $_GET['AKLaporanbukubesarV']['namarekening'] . "'";
			}
			
		} else {
			$qr_rekeningjurnal5_nama = null;
			$qr_kdrekening5 = null;
			if (!empty($modelLaporan->periodeposting_id)) {
				$criteria->addCondition('periodeposting_id = ' . $modelLaporan->periodeposting_id);
			}
		}
//		$criteria->compare('ruangan_id', $_GET['AKLaporanbukubesarV']['ruangan_id']);
		$criteria->order = 'rekening5_id, tglbukubesar';
		$model = AKLaporanbukubesarV::model()->findAll($criteria);

		if ($modelLaporan->ruangan_id == '') {
			$query_ruangan_id = null;
		} else {
			$query_ruangan_id = "ruangan_id=" . $modelLaporan->ruangan_id;
		}
		$criteria2 = new CDbCriteria();
		$criteria2->select = 'count(nmrekening5) as urutan';
		if (!empty($modelLaporan->ruangan_id)) {
			$criteria2->addCondition('ruangan_id = ' . $modelLaporan->ruangan_id);
		}
		if (!empty($modelLaporan->periodeposting_id)) {
			$criteria2->addCondition('periodeposting_id = ' . $modelLaporan->periodeposting_id);
		}
		if (empty($_GET['AKLaporanbukubesarV']['namarekening'])) {
			$qr_rekeningjurnal5_nama = null;
		} else {
			$criteria2->addCondition("nmrekening5 = '" . $_GET['AKLaporanbukubesarV']['namarekening'] . "'");
		}
		if (empty($_GET['AKLaporanbukubesarV']['koderekening'])) {
			$qr_kdrekening5 = null;
		} else {
			$criteria2->addCondition("kdrekeningdetail5 = '" . $_GET['AKLaporanbukubesarV']['koderekening'] . "'");
		}
		$criteria2->group = 'rekening5_id,nmrekening5';
		$jmlRekening = AKLaporanbukubesarV::model()->findAll($criteria2);
//        $sql= "select count(rekeningjurnal5_nama) as urutan from LaporanBukuBesar_V WHERE ".$query_ruangan_id." periodeposting_id ='".$modelLaporan->periodeposting_id."'".$qr_rekeningjurnal5_nama." ".$qr_kdrekening5." group by rekeningjurnal5_nama, rekeningjurnal1_id, rekeningjurnal2_id, rekeningjurnal3_id, rekeningjurnal4_id, rekeningjurnal5_id order by rekeningjurnal1_id, rekeningjurnal2_id,rekeningjurnal3_id, rekeningjurnal4_id, rekeningjurnal5_id";
//        $jmlRekening = Yii::app()->db->createCommand($sql)->queryAll();

		if ($_REQUEST['caraPrint'] == 'GRAFIK') {
			$model = new AKLaporanbukubesarV;

			if (isset($_REQUEST['AKLaporanbukubesarV'])) {
				$model->attributes = $_REQUEST['AKLaporanbukubesarV'];
				$model->periodeposting_id = AKLaporanbukubesarV::model()->getTglPeriode()->periodeposting_id;
			}
		}
		$judulLaporan = 'Laporan Buku Besar Berdasarkan Nama Rekening';

		//Data Grafik       
		$data['title'] = 'Grafik Laporan Buku Besar Berdasarkan Nama Rekening';
		isset($_REQUEST['type']) ? $data['type'] = $_REQUEST['type'] : $data['type'] = null;

		$caraPrint = $_REQUEST['caraPrint'];
		$target = $this->path_view.'_print';

		$periodeposting_id = AKPeriodepostingM::model()->findByPk($modelLaporan->periodeposting_id);

		$periode = isset($periodeposting_id->periodeposting_nama) ? $periodeposting_id->periodeposting_nama : "";

		$caraPrint = $_REQUEST['caraPrint'];
		$judulLaporan = 'Laporan Buku Besar';

		if ($caraPrint == 'PRINT') {
			$this->layout = '//layouts/printWindows';
			$this->render($target, array('model' => $model, 'modelLaporan' => $modelLaporan, 'jmlRekening' => $jmlRekening, 'periode' => $periode, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
		} else if ($caraPrint == 'EXCEL') {
			$this->layout = '//layouts/printExcel';
			$this->render($target, array('model' => $model, 'modelLaporan' => $modelLaporan, 'jmlRekening' => $jmlRekening, 'periode' => $periode, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
		} else if ($_REQUEST['caraPrint'] == 'PDF') {
			$ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');	  //Ukuran Kertas Pdf
			$posisi = 'L';		 //Posisi L->Landscape,P->Portait
			$mpdf = new MyPDF('', $ukuranKertasPDF);
			$mpdf->useOddEven = 2;
			$stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
			$mpdf->WriteHTML($stylesheet, 1);
			$mpdf->AddPage($posisi, '', '', '', '', 15, 15, 0, 5, 15, 15);
			$mpdf->tMargin = 5;
			$mpdf->WriteHTML($this->renderPartial($target, array('model' => $model, 'modelLaporan' => $modelLaporan, 'jmlRekening' => $jmlRekening, 'periode' => $periode, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
			$mpdf->Output();
		}
	}

	public function actionFrameGrafikLaporanBukuBesar() {
		$this->layout = '//layouts/iframe';
		$model = new AKLaporanbukubesarV('search');
		$model->tgl_awal = date('d M Y 00:00:00');
		$model->tgl_akhir = date('d M Y H:i:s');

		//Data Grafik
		$data['title'] = 'Grafik Laporan Buku Besar Berdasarkan Nama Rekening';
		$data['type'] = $_GET['type'];
		if (isset($_GET['AKLaporanbukubesarV'])) {
			$model->attributes = $_GET['AKLaporanbukubesarV'];
			$format = new MyFormatter();
			$model->tgl_awal = $format->formatDateTimeForDb($_GET['AKLaporanbukubesarV']['tgl_awal']);
			$model->tgl_akhir = $format->formatDateTimeForDb($_GET['AKLaporanbukubesarV']['tgl_akhir']);
		}

		$this->render($this->path_view.'_grafik', array(
			'model' => $model,
			'data' => $data,
		));
	}
	
	public function actionRekeningAkuntansi() {
		if (Yii::app()->request->isAjaxRequest) {
			$criteria = new CDbCriteria();
//                $criteria->compare('LOWER(nmrincianobyek)', strtolower($_GET['term']), true);
			$term = strtolower(trim($_GET['term']));

			$condition = "LOWER(nmrekening5) LIKE '%" . $term . "%' OR LOWER(nmrekening4) LIKE '%" . $term . "%' OR LOWER(nmrekening3) LIKE '%" . $term . "%'";
			if (isset($_GET['id_jenis_rek'])) {
				$condition = "(LOWER(nmrekening5) LIKE '%" . $term . "%' OR LOWER(nmrekening4) LIKE '%" . $term . "%' OR LOWER(nmrekening3) LIKE '%" . $term . "%') AND (rekening5_nb = 'D' OR rekening4_nb = 'D' OR rekening3_nb = 'D')";
				if ($_GET['id_jenis_rek'] == 'Kredit') {
					$condition = "(LOWER(nmrekening5) LIKE '%" . $term . "%' OR LOWER(nmrekening4) LIKE '%" . $term . "%' OR LOWER(nmrekening3) LIKE '%" . $term . "%') AND (rekening5_nb = 'K' OR rekening4_nb = 'K' OR rekening3_nb = 'K')";
				}
			}

			$criteria->addCondition($condition);
			$criteria->order = 'nmrekening5';
			$models = RekeningakuntansiV::model()->findAll($criteria);
			$returnVal = array();
			foreach ($models as $i => $model) {
				$attributes = $model->attributeNames();
				foreach ($attributes as $j => $attribute) {
					$returnVal[$i]["$attribute"] = $model->$attribute;
				}
				if (isset($model->rincianobyek_id)) {
					$kode_rekening = $model->kdrekening1 . "-" . $model->kdrekening2 . "-" . $model->kdrekening3 . "-" . $model->kdrekening4 . "-" . $model->kdrekening5;
					$nama_rekening = $model->nmrekening5;
				} else {
					if (isset($model->obyek_id)) {
						$kode_rekening = $model->kdrekening1 . "-" . $model->kdrekening2 . "-" . $model->kdrekening3 . "-" . $model->kdrekening4;
						$nama_rekening = $model->nmrekening4;
					} else {
						$kode_rekening = $model->kdrekening1 . "-" . $model->kdrekening2 . "-" . $model->kdrekening3;
						$nama_rekening = $model->nmrekening3;
					}
				}
				$returnVal[$i]['label'] = $kode_rekening . '-' . $nama_rekening;
				$returnVal[$i]['value'] = $nama_rekening;
			}
			echo CJSON::encode($returnVal);
		}
		Yii::app()->end();
	}
}
