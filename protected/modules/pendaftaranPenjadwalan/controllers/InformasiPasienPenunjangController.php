<?php

class InformasiPasienPenunjangController extends MyAuthController
{
        /**
	 * @return array action filters
	 */
        
        public $path_view = 'pendaftaranPenjadwalan.views.informasiPasienPenunjang.';
        
        
	public function actionIndex()
	{
            $this->pageTitle = Yii::app()->name." - Informasi Pasien Penunjang";
            $format = new MyFormatter();
            $model=new PPPasienMasukPenunjangT('searchPasienPenunjang');
//		$model->unsetAttributes(); // clear any default values
            $model->tgl_awal = date('Y-m-d');
            $model->tgl_akhir = date('Y-m-d');
            if(isset($_GET['PPPasienMasukPenunjangT']))
            {
                $model->attributes=$_GET['PPPasienMasukPenunjangT'];
                $model->tgl_awal  = $format->formatDateTimeForDb($_GET['PPPasienMasukPenunjangT']['tgl_awal']);
                $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPPasienMasukPenunjangT']['tgl_akhir']);
                $model->asalrujukan_id = $_GET['PPPasienMasukPenunjangT']['asalrujukan_id'];
                $model->rujukandari_id = $_GET['PPPasienMasukPenunjangT']['rujukandari_id'];
                $model->no_rekam_medik = $_GET['PPPasienMasukPenunjangT']['no_rekam_medik'];
                $model->nama_pasien = $_GET['PPPasienMasukPenunjangT']['nama_pasien'];
                $model->carabayar_id = $_GET['PPPasienMasukPenunjangT']['carabayar_id'];
                $model->penjamin_id = $_GET['PPPasienMasukPenunjangT']['penjamin_id'];
                $model->create_loginpemakai_id = $_GET['PPPasienMasukPenunjangT']['create_loginpemakai_id'];
                $model->statusperiksa_pendaftaran = $_GET['PPPasienMasukPenunjangT']['statusperiksa_pendaftaran'];
            }                
            $this->render($this->path_view.'index',array(
                    'model'=>$model,'format'=>$format
            ));
	}
        
	public function actionUbahKeteranganPendaftaran()
	{
		$model = new PendaftaranT;
		if(isset($_POST['PendaftaranT']))
		{
			if($_POST['PendaftaranT']['keterangan_pendaftaran'] != "")
			{
				$model->attributes = $_POST['PendaftaranT'];
				$transaction = Yii::app()->db->beginTransaction();
				try {
					$attributes = array('keterangan_pendaftaran'=>$_POST['PendaftaranT']['keterangan_pendaftaran']);
					$save = $model::model()->updateByPk($_POST['PendaftaranT']['pendaftaran_id'], $attributes);
					if($save)
					{
						$transaction->commit();
						echo CJSON::encode(array(
							'status'=>'proses_form', 
							'div'=>"<div class='flash-success'>Berhasil merubah Keterangan Pendaftaran.</div>",
							));
					}else{
						echo CJSON::encode(array(
							'status'=>'proses_form', 
							'div'=>"<div class='flash-error'>Data gagal disimpan.</div>",
							));                    
					}
					exit;
				}catch(Exception $exc) {
					$transaction->rollback();
				}
			}else{
				echo CJSON::encode(
					array(
						'status'=>'proses_form',
						'div'=>"<div class='flash-success'>Berhasil merubah data Keterangan Pendaftaran.</div>",
					)
				);
				exit;
			}
		}

		if (Yii::app()->request->isAjaxRequest)
		{
			echo CJSON::encode(array(
				'status'=>'create_form', 
				'div'=>$this->renderPartial($this->path_view.'_formUbahKeterangan', array('model'=>$model), true)));
			exit;               
		}
	}
	
	public function actionGetDataPendaftaranRJRDRI()
	{
		if (Yii::app()->request->isAjaxRequest){
			$id_pendaftaran = $_POST['pendaftaran_id'];
			$model = InfokunjunganrjrdriV::model()->findByAttributes(array('pendaftaran_id'=>$id_pendaftaran));
			$attributes = $model->attributeNames();
			foreach($attributes as $j=>$attribute) {
				$returnVal["$attribute"] = $model->$attribute;
			}
			$returnVal['gelardepan'] = (empty($model->gelardepan) ? "":$model->gelardepan);
			$returnVal['dokter'] = $model->nama_pegawai;
			$returnVal['gelarbelakang_nama'] = (empty($model->gelarbelakang_nama) ? "":$model->gelarbelakang_nama);
			echo json_encode($returnVal);
			Yii::app()->end();
		}
	}
	
}