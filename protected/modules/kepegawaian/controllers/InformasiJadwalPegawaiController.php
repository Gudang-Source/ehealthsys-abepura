<?php

class InformasiJadwalPegawaiController extends MyAuthController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column1';
	public $defaultAction = 'index';
	public $path_view = 'kepegawaian.views.informasiJadwalPegawai.';

	/**
	 * Melihat daftar data.
	 */
	public function actionIndex()
	{
		$format = new MyFormatter; 
		$model	= new KPInformasijadwalpegawaiV;
		$model->unsetAttributes();  // clear any default values
		$model->instalasi_id = Yii::app()->user->getState('instalasi_id');
		$model->ruangan_id = Yii::app()->user->getState('ruangan_id');
        $model->tgl_awal = date('Y-m-d');
        $model->tgl_akhir = date('Y-m-d');
		if(isset($_GET['KPInformasijadwalpegawaiV'])){
			$model->attributes=$_GET['KPInformasijadwalpegawaiV'];
            $model->tgl_awal = $format->formatDateTimeForDb($model->tgl_awal);
            $model->tgl_akhir = $format->formatDateTimeForDb($model->tgl_akhir);
            if($model->ruangan_id == ""){
                $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
            }
		}
		$this->render($this->path_view.'index',array(
				'model'=>$model, 'format'=>$format
		));
	}
	
}
