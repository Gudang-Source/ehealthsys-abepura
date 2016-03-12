<?php

class InformasiPenerimaanUmumController extends MyAuthController
{
	public $path_view = 'keuangan.views.informasiPenerimaanUmum.';
	public function actionIndex()
	{
            $modPenerimaan = new KUPenerimaanUmumT;
            $format = new MyFormatter();
            $modPenerimaan->tgl_awal=date('d M Y 00:00:00');
            $modPenerimaan->tgl_akhir=date('d M Y H:i:s');
		
            if(isset($_GET['AKPenerimaanUmumT'])){
                $modPenerimaan->attributes=$_GET['AKPenerimaanUmumT'];
                $modPenerimaan->tgl_awal = $format->formatDateTimeForDb($_GET['AKPenerimaanUmumT']['tgl_awal']);
                $modPenerimaan->tgl_akhir = $format->formatDateTimeForDb($_GET['AKPenerimaanUmumT']['tgl_akhir']);
            }
            
            $this->render($this->path_view. 'index', array('modPenerimaan'=>$modPenerimaan));
	}
        
        public function actionDetailPenerimaanUmum($penerimaanumum_id)
	{
		if(isset($_GET['caraPrint'])){
			$this->layout='//layouts/printWindows';
		}else{
			$this->layout = '//layouts/iframe';
		}
		$modPenerimaan = KUPenerimaanUmumT::model()->findByPk($penerimaanumum_id);
		if(!count($modPenerimaan)>0){
			echo "<h4>Data penerimaan umum tidak ditemukan!!</h4>";exit;
		}
		$modUraianTerimaUmum = UraianpenumumT::model()->findAllByAttributes(array('penerimaanumum_id'=>$penerimaanumum_id));
		$this->render($this->path_view. 'detailPenerimaan',array(
					'modUraianTerimaUmum'=>$modUraianTerimaUmum,
					'modPenerimaan'=>$modPenerimaan,
				));
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