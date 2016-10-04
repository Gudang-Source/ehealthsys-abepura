<?php
class InformasiPemesananAmbulansController extends MyAuthController
{
    public $layout='//layouts/column1';
    public $pathView = "ambulans.views.informasiPemesananAmbulans.";
    public $inisial_modul='';
    public $ambulansRS = 'PemakaianAmbulanPasienRS';
    public $ambulansLuar = 'PemakaianAmbulanPasienLuar';
    
    public function actionIndex(){
		$model = new AMInformasipesanambulansV;
		$format = new MyFormatter;
	    $model->tgl_awal  = date('Y-m-d');
	    $model->tgl_akhir  = date('Y-m-d');
            $model->inisial_modul = $this->inisial_modul;            
		if(isset($_GET['AMInformasipesanambulansV'])){
			$model->unsetAttributes();
			$model->attributes=$_GET['AMInformasipesanambulansV'];
			$model->tgl_awal = $format->formatDateTimeForDb($_GET['AMInformasipesanambulansV']['tgl_awal']);
                        $model->tgl_akhir = $format->formatDateTimeForDb($_GET['AMInformasipesanambulansV']['tgl_akhir']);
                        $model->inisial_modul = $_GET['AMInformasipesanambulansV']['inisial_modul'];                                    
		}
		$this->render($this->pathView.'index',array('model'=>$model,'format'=>$format));
	}
}