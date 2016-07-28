<?php

class SetoranBendaharaKeBankController extends MyAuthController
{
	public $path_view = "keuangan.views.setoranBendaharaKeBank.";
	
	public function actionAutoCompletePegawai()
	{
		//$this->render('autoCompletePegawai');
	}

	public function actionAutoCompletePegawaiMengetahui()
	{
		//$this->render('autoCompletePegawaiMengetahui');
	}

	public function actionDetail()
	{
		$this->render($this->path_view.'detail');
	}

	public function actionIndex($id = null)
	{
		$model = new KUSetoranbdharaT;
		$detail = array();
		
		$model->nosetoranbdhara = MyGenerator::noSetoranBendahara();
		$model->pegawai_id = Yii::app()->user->getState('pegawai_id');
		$model->tgl_awal = $model->tgl_akhir = MyFormatter::formatDateTimeForUser(date('Y-m-d'));
		
		$p = PegawaiM::model()->findByPk($model->pegawai_id);
		if (!empty($p)) $model->pegawai_nama = $p->namaLengkap;
		
		if (isset($_POST['KUSetoranbdharaT']) && isset($_POST['detail'])) {
			$trans = Yii::app()->db->beginTransaction();
			$ok = true;
			
			try {
				$model->attributes = $_POST['KUSetoranbdharaT'];
				$model->profilrs_id = Yii::app()->user->getState('profilrs_id');
				$model->ruangan_id = Yii::app()->user->getState('ruangan_id');
				$model->tglmengetahui = date('Y-m-d H:i:s');

				if ($model->validate()) {
					$ok = $ok && $model->save();
				} else $ok = false;

				foreach ($_POST['detail'] as $setorankasir_id => $detail) {
					foreach ($detail as $kelompoktindakan_id => $item) {
						$det = new RinciansetoranbdharaT;
						$det->attributes = $item;
						$det->setoranbdhara_id = $model->setoranbdhara_id;
						$det->setorankasir_id = $setorankasir_id;
						$det->kelompoktindakan_id = $kelompoktindakan_id;

						if ($det->validate()) {
							$ok = $ok && $det->save();
						} else $ok = false;
					}
				}

				if ($ok) {
					$trans->commit();
					Yii::app()->user->setFlash("success", "Data Berhasil Disimpan.");
					$this->redirect(array('index', 'id'=>$model->setoranbdhara_id));
				} else {
					$trans->rollback();
					Yii::app()->user->setFlash("error", "Data Gagal Disimpan.");
				}
			} catch (Exception $e) {
				$trans->rollback();
				Yii::app()->user->setFlash("error", "Data Gagal Disimpan (E).");
			}
			//var_dump($_POST, $model->validate(), $model->errors, $model->attributes); die;
		}
		
		if (isset($id)) {
			$model = KUSetoranbdharaT::model()->findByPk($id);
			if (!empty($model->pegawai_id)) {
				$p = PegawaiM::model()->findByPk($model->pegawai_id);
				$model->pegawai_nama = $p->namaLengkap;
			}
			if (!empty($model->mengetahui_id)) {
				$p = PegawaiM::model()->findByPk($model->mengetahui_id);
				$model->mengetahui_nama = $p->namaLengkap;
			}
		}
		
		$this->render($this->path_view.'index', array('model'=>$model, 'detail'=>$detail, 'id'=>$id));
	}

	public function actionInformasi()
	{
		$this->render($this->path_view.'informasi');
	}

	public function actionLoadSetoran()
	{
		if(Yii::app()->request->isAjaxRequest) {
			$c = new CDbCriteria();
			$c->addBetweenCondition('tglsetorankasir::date', $_POST['tgl_awal'], $_POST['tgl_akhir']);
			
			$setoran = SetorankasirT::model()->findAll($c);
			$detail = $this->tabularDetailSetoranKasir($setoran);
			
			// var_dump($detail); die;
			
			$total = 0;
			
			foreach ($detail as $item) {
				foreach ($item['det'] as $item2) {
					$total += $item2['total'];
				}
			}
			
			echo CJSON::encode(array(
				'html'=>$this->renderPartial($this->path_view.'sub/_tabdetail', array('detail'=>$detail), true),
				'footer'=>$this->renderPartial($this->path_view.'sub/_tabtotal', array('total'=>$total), true),
			));
		}
		Yii::app()->end();
	}
	
	private function tabularDetailSetoranKasir($setoran) {
		$res = array();
		foreach ($setoran as $item) {
			if (empty($item->bendaharapenerima_id)) continue; 
			
			$set = RinciansetoranbdharaT::model()->findByAttributes(array(
				'setorankasir_id'=> $item->setorankasir_id
			));
			
			// if (!empty($set)) continue;
			
			if (empty($res[$item->setorankasir_id])) {
				$res[$item->setorankasir_id] = array(
					'no'=>$item->nosetorankasir,
					'det'=>array(),
				);
			}
			$sub = array();
			
			$det = TindakankomponenclosingV::model()->findAllByAttributes(array(
				'closingkasir_id'=>$item->closingkasir_id,
				'penjamin_id'=>Params::PENJAMIN_ID_UMUM,
			));
			
			foreach ($det as $item2) {
				if (empty($sub[$item2->kelompoktindakan_id])) {
					$sub[$item2->kelompoktindakan_id] = array(
						'nama'=>$item2->kelompoktindakan_nama,
						'total'=>0,
					);
				}
				
				$sub[$item2->kelompoktindakan_id]['total'] += $item2->tarif_tindakankomp;
			}
			
			$res[$item->setorankasir_id]['det'] = $sub;
		}
		
		
		return $res;
	}
	
	private function tabularDetailSetoranBendahara($detailSetoran) {
		
	}

	public function actionPrint($id, $frame = null)
	{
		$this->layout='//layouts/printWindows';
        if (!empty($frame)){
            $this->layout='//layouts/iframe';
        }
		
		$model = KUSetoranbdharaT::model()->findByPk($id);
		if (!empty($model->pegawai_id)) {
			$p = PegawaiM::model()->findByPk($model->pegawai_id);
			$model->pegawai_nama = $p->namaLengkap;
		}
		if (!empty($model->mengetahui_id)) {
			$p = PegawaiM::model()->findByPk($model->mengetahui_id);
			$model->mengetahui_nama = $p->namaLengkap;
		}
		
		$det = array();
		$mdet = RinciansetoranbdharaT::model()->findAllByAttributes(array(
			'setoranbdhara_id'=>$model->setoranbdhara_id,
		));
		
		$total = 0;
		
		foreach ($mdet as $item) {
			$rek = Rekening5M::model()->findByPk($item->rekening5_id);
			$kel = KelompoktindakanM::model()->findByPk($item->kelompoktindakan_id);
			
			if (empty($det[$item->setorankasir_id])) {
				$set = SetorankasirT::model()->findByPk($item->setorankasir_id);
				
				$det[$item->setorankasir_id] = array(
					'no'=>$set->nosetorankasir,
					'det'=>array(),
				);
				
				
			}
			
			array_push($det[$item->setorankasir_id]['det'], array(
				'rek'=>$rek->kdrekening5." - ".$rek->nmrekening5,
				'kel'=>$kel->kelompoktindakan_nama,
				'nilai'=>$item->jmlsetoranbdhara,
			));
			
			$total += $item->jmlsetoranbdhara;
		}
		
		$this->render($this->path_view.'print', array('model'=>$model, 'det'=>$det, 'total'=>$total));
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