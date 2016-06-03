<?php

class InformasiReEvaluasiAssetController extends MyAuthController {
	public $layout='//layouts/column1';
	
	public function actionIndex()
	{
		$format = new MyFormatter; 
		$model	= new MAReevaluasiasetV('searchInformasi');
		$model->unsetAttributes();  // clear any default values
        $model->reevaluasiaset_tgl = date('Y-m-d');
		if(isset($_GET['MAReevaluasiasetV'])){
			$model->attributes=$_GET['MAReevaluasiasetV'];
            $model->reevaluasiaset_tgl = $format->formatDateTimeForDb($model->reevaluasiaset_tgl);
            $model->reevaluasiaset_no = $model->reevaluasiaset_no;
		}
		$this->render('index',array(
				'model'=>$model, 'format'=>$format
		));
	}
        
        public function actionDetail($id) {
            $this->layout = '//layouts/iframe';
            $model = new BarangV();
            $this->render('manajemenAset.views.reevaluasiasetT.Print', array(
                'model'=>$model,
                'judulLaporan'=>'',
            ));
        }
}

