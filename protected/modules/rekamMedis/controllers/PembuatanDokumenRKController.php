<?php
Yii::import('sistemAdministrator.controllers.DokumenRekamMedisController');
Yii::import('sistemAdministrator.models.*');
Yii::import('sistemAdministrator.views.dokumenRekamMedis');
class PembuatanDokumenRKController extends DokumenRekamMedisController
{
	public $path_view_rm = 'rekamMedis.views.pembuatanDokumenRK.';
	/**
	 * Membuat dan menyimpan data baru.
	 */
	public function actionCreate($pasien_id = null, $tipe = null)
	{
		$format = new MyFormatter();
		$model=new SADokrekammedisM;
		$model->nodokumenrm = '-Otomatis-';
                $model->tglmasukrak = date('y-m-d');
                $model->warnadokrm_id = $tipe;
		// Uncomment the following line if AJAX validation is needed
		
		if(isset($_GET['id'])){
			$model = SADokrekammedisM::model()->findByPk($_GET['id']);
		}

                $pasien = PasienM::model()->findByPk($pasien_id);
                
		if(isset($_POST['SADokrekammedisM']))
		{
			$model->attributes=$_POST['SADokrekammedisM'];
			$model->nodokumenrm = MyGenerator::noDokumenRM();
			$model->tglrekammedis = $format->formatDateTimeForDb($_POST['SADokrekammedisM']['tglrekammedis']);
			$model->tglmasukrak = $format->formatDateTimeForDb($_POST['SADokrekammedisM']['tglmasukrak']);
			$model->tglkeluarakhir = $format->formatDateTimeForDb($_POST['SADokrekammedisM']['tglkeluarakhir']);
			$model->tglmasukakhir = $format->formatDateTimeForDb($_POST['SADokrekammedisM']['tglmasukakhir']);
			$model->tgl_in_aktif = $format->formatDateTimeForDb($_POST['SADokrekammedisM']['tgl_in_aktif']);
			$model->tglpemusnahan = $format->formatDateTimeForDb($_POST['SADokrekammedisM']['tglpemusnahan']);
			$model->create_time = $format->formatDateTimeForDb($model->create_time);
			$model->create_loginpemakai_id = Yii::app()->user->id;
			$model->create_ruangan = Yii::app()->user->getState('ruangan_id');
			$model->statusrekammedis = Params::STATUSREKAMMEDIS_AKTIF;
			
			if($model->save()){
				Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
				$this->redirect(array('create','id'=>$model->dokrekammedis_id,'sukses'=>1));
			}
		}

		$this->render($this->path_view_rm.'create',array(
			'model'=>$model,
                        'pasien'=>$pasien,
                        'tipe'=>$tipe,
		));
	}
	
	/**
     * untuk print data pembuatan dokumen rekam medis baru
     */
    public function actionPrintDokumen($dokrekammedis_id,$caraPrint = null) 
    {
        $format = new MyFormatter;    
        $model = SADokrekammedisM::model()->findByPk($dokrekammedis_id);     
		$modPasien = RKPasienM::model()->findByPk($model->pasien_id);

        $judul_print = 'Pembuatan Dokumen Rekam Medis Bru';
        $caraPrint = isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null;
        if (isset($_GET['frame'])){
            $this->layout='//layouts/iframe';
        }
        if($caraPrint=='PRINT') {
            $this->layout='//layouts/printWindows';
        }
        else if($caraPrint=='EXCEL') {
            $this->layout='//layouts/printExcel';
        }
        
        $this->render($this->path_view_rm.'Print', array(
                'format'=>$format,
                'judul_print'=>$judul_print,
                'model'=>$model,
				'modPasien'=>$modPasien,
        ));
    }
}
