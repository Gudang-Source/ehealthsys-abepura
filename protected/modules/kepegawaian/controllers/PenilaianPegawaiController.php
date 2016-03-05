<?php

class PenilaianPegawaiController extends MyAuthController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column1';
	public $defaultAction = 'index';
	protected $path_view = 'kepegawaian.views.penilaianpegawai.';
	public $saveDetail = true;
	/**
	 * Lists all models.
	 */
	public function actionIndex($id=null)
	{
		$format = new MyFormatter;
		$model = new KPPenilaianpegawaiT();
		$modPegawai = new KPPegawaiM;
		$modPenilaianPegawaiDet = new KPPenilaianpegawaidetT();
		$model->tglpenilaian = date('d-m-Y'); // format seperti ini karena buat ngisi date mask
		if(isset($_POST['KPPenilaianpegawaiT'])){
                        $ok = true;
			$transaction = Yii::app()->db->beginTransaction();
			try {
				$model=new KPPenilaianpegawaiT();
				$model->attributes=$_POST['KPPenilaianpegawaiT'];
				$model->tglpenilaian=  MyFormatter::formatDateTimeForDb($_POST['KPPenilaianpegawaiT']['tglpenilaian']);
				$model->penilainama = isset($_POST['penilainama'])?$_POST['penilainama']:null;
				$model->pimpinannama = isset($_POST['pimpinannama'])?$_POST['pimpinannama']:null;
				$model->create_loginpemakai_id = Yii::app()->user->id;
				$model->create_ruangan = Yii::app()->user->ruangan_id;
				$model->create_time = date('Y-m-d H:i:s');
                                
                                $model->validate();
                                //var_dump($model->errors);
                                
				if($model->validate()){
					$ok = $ok && $model->save();
					foreach($_POST['KPPenilaianpegawaidetT'] as $i => $postDetail){
						$modPenilaianPegawaiDet=new KPPenilaianpegawaidetT();
						$modPenilaianPegawaiDet->attributes=$postDetail;
						$modPenilaianPegawaiDet->penilaianpegawai_id=$model->penilaianpegawai_id;
						$modPenilaianPegawaiDet->kolomrating_id=$postDetail['kolomrating_id'];
						$modPenilaianPegawaiDet->create_loginpemakai_id = Yii::app()->user->id;
						$modPenilaianPegawaiDet->create_ruangan = Yii::app()->user->ruangan_id;
						$modPenilaianPegawaiDet->create_time = date('Y-m-d H:i:s');
						if($modPenilaianPegawaiDet->save()){
							$this->saveDetail &= true;
						}else{
							$this->saveDetail &= false;
						}
					}
				} else {
                                    $ok = false;
                                }
                                //var_dump($ok, $this->saveDetail); die;
                                
				if($ok && $this->saveDetail){
					$transaction->commit();
					Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
					$this->redirect(array('index','id'=>$model->pegawai_id,'sukses'=>1));
				}else{
					$transaction->rollback();
					Yii::app()->user->setFlash('error',"<strong>Gagal!</strong> Data Gagal Disimpan.");
				}
			}catch (Exception $e){
				 $transaction->rollback();
				 Yii::app()->user->setFlash('error',"Data Penilaiaan gagal disimpan ! ".MyExceptionMessage::getMessage($e,true));
			}
		}
		
                if(!empty($id)){
			$modPegawai = KPPegawaiM::model()->findByPk($id);
			$modPegawai->jabatan_id = (isset($modPegawai->jabatan_id) ? $modPegawai->jabatan_id : null);
			$modPegawai->jabatan_nama = (isset($modPegawai->jabatan_id) ? $modPegawai->jabatan->jabatan_nama : "-");
			$modPegawai->pangkat_id = (isset($modPegawai->pangkat_id) ? $modPegawai->pangkat_id : null);
			$modPegawai->pangkat_nama = (isset($modPegawai->pangkat_id) ? $modPegawai->pangkat->pangkat_nama : "-");
			$modPegawai->kelompokpegawai_id = (isset($modPegawai->kelompokpegawai_id) ? $modPegawai->kelompokpegawai_id : null);
			$modPegawai->kelompokpegawai_nama = (isset($modPegawai->kelompokpegawai_id) ? $modPegawai->kelompokpegawai->kelompokpegawai_nama : "-");
			$modPegawai->pendidikan_id = (isset($modPegawai->pendidikan_id) ? $modPegawai->pendidikan_id : null);
			$modPegawai->pendidikan_nama = (isset($modPegawai->pendidikan_id) ? $modPegawai->pendidikan->pendidikan_nama : "-");
			$modPegawai->tgl_lahirpegawai = (isset($modPegawai->tgl_lahirpegawai) ? $format->formatDateTimeForUser($modPegawai->tgl_lahirpegawai) : "-");
			
			$tabelPenilaian = KPPenilaianpegawaiT::model()->findAllByAttributes(array('pegawai_id'=>$modPegawai->pegawai_id));
			$model->pegawai_id = $id;
		}
		
		$this->render('index',array(
			'format'=>$format,
			'model'=>$model,
			'modPegawai'=>$modPegawai,
			'modPenilaianPegawaiDet'=>$modPenilaianPegawaiDet,
			'tabelPenilaian'=>$tabelPenilaian
		));
	}
	
	public function actionGetDataPegawai()
	{
		if(Yii::app()->request->isAjaxRequest){
			$data = PegawaiM::model()->findByAttributes(array('pegawai_id'=>$_POST['idPegawai']));
			$post = array(
				'nomorindukpegawai'=>$data->nomorindukpegawai,
				'pegawai_id'=>$data->pegawai_id,
				'nama_pegawai'=>$data->nama_pegawai,
				'tempatlahir_pegawai'=>$data->tempatlahir_pegawai,
				'tgl_lahirpegawai' => $data->tgl_lahirpegawai,
				'jabatan_nama'=> (isset($data->jabatan->jabatan_nama) ? $data->jabatan->jabatan_nama : ''),
				'pangkat_nama'=> (isset($data->pangkat->pangkat_nama) ? $data->pangkat->pangkat_nama : ''),
				'kategoripegawai'=>$data->kategoripegawai,
				'kategoripegawaiasal'=>$data->kategoripegawaiasal,
				'kelompokpegawai_nama'=> (isset($data->kelompokpegawai->kelompokpegawai_nama) ? $data->kelompokpegawai->kelompokpegawai_nama : ''),
				'pendidikan_nama'=> (isset($data->pendidikan->pendidikan_nama) ? $data->pendidikan->pendidikan_nama : ''),
				'jeniskelamin'=>$data->jeniskelamin,
				'statusperkawinan'=>$data->statusperkawinan,
				'alamat_pegawai'=>$data->alamat_pegawai,
				'photopegawai'=>(!is_null($data->photopegawai) ? $data->photopegawai : ''),
			);
			echo CJSON::encode($post);
			Yii::app()->end();
		}
	}
	
	public function actionPegawairiwayatNip()
	{
		if(Yii::app()->request->isAjaxRequest) {
			$criteria = new CDbCriteria();
			$criteria->compare('LOWER(nomorindukpegawai)', strtolower($_GET['term']), true);
			$criteria->order = 'nomorindukpegawai';
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
	
	public function actionPegawairiwayat()
	{
		if(Yii::app()->request->isAjaxRequest) {
			$criteria = new CDbCriteria();
			$criteria->compare('LOWER(nama_pegawai)', strtolower($_GET['term']), true);
			$criteria->order = 'nama_pegawai';
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
	
	public function actionCekScore()
	{
		if(Yii::app()->request->isAjaxRequest) {
			$nilai = $_POST['nilai'];
			$indikator = $_POST['indikator'];
			$pesan = '';
                        $pesanSkor = '';
                        $rating_id = null;
                        $point = 0;
			if((!empty($nilai))&&(!empty($indikator))){
				//$modKolomRating = KPKolomratingM::model()->findByPk($kolomrating_id);
                                $cr = new CDbCriteria;
                                $cr->compare('indikatorperilaku_id',$indikator);
                                $cr->addCondition($nilai." between kolomrating_nilaiawal and kolomrating_nilaiakhir");
                                $modKolomRating = KPKolomratingM::model()->find($cr);
                                
				if(!empty($modKolomRating)){
                                        $pesanSkor = $modKolomRating->kolomrating_namalevel;
                                        $rating_id = $modKolomRating->kolomrating_id;
                                        $point = $modKolomRating->kolomrating_point;
				}else{
					$pesan = 'Rating diluar jangkauan';
				}
			}
			echo CJSON::encode(array('pesan'=>$pesan, 'pesanSkor'=>$pesanSkor, 'rating_id'=>$rating_id, 'point'=>$point));
		}
		Yii::app()->end();

	}
	
	function actionLoadDataAfterSave(){
		if(Yii::app()->request->isAjaxRequest) {
			$penilaianpegawai_id = $_POST['penilaianpegawai_id'];
			$modPenilaianPegawai = KPPenilaianpegawaiT::model()->findByPk($penilaianpegawai_id);
			$modPenilaianPegawaiDet = KPPenilaianpegawaidetT::model()->findAllByAttributes(array('penilaianpegawai_id'=>$penilaianpegawai_id));
			$penilai = KPPegawaiM::model()->findByAttributes(array('nomorindukpegawai'=>$modPenilaianPegawai->penilainip));
			$pimpinan = KPPegawaiM::model()->findByAttributes(array('nomorindukpegawai'=>$modPenilaianPegawai->pimpinannip));
			echo CJSON::encode(array('modPenilaianPegawai'=>$modPenilaianPegawai,'modPenilaianPegawaiDet'=>$modPenilaianPegawaiDet,'penilai'=>$penilai,'pimpinan'=>$pimpinan));
		}
		Yii::app()->end();
	}
	
	public function actionPrint($penilaianpegawai_id,$caraPrint = null){
		$this->layout='//layouts/printWindows';
        $penilaianpegawai_id = $_GET['penilaianpegawai_id'];
		$modPenilaianPegawai = KPPenilaianpegawaiT::model()->findByPk($penilaianpegawai_id);
		$modPenilaianPegawaiDet = KPPenilaianpegawaidetT::model()->findAllByAttributes(array('penilaianpegawai_id'=>$penilaianpegawai_id));
        $judul_print = 'Penilaian Pegawai';
        $caraPrint = isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null;
        $this->render('Print', array(
                'judul_print'=>$judul_print,
                'modPenilaianPegawai'=>$modPenilaianPegawai,
                'modPenilaianPegawaiDet'=>$modPenilaianPegawaiDet,
        ));
    }

}
