<?php
class InformasiPelatihanController extends MyAuthController
{
    public $layout='//layouts/column1';
    public $defaultAction = 'index';

    public function actionIndex(){
		
        $model = new KPPegawaidiklatT();
        $model->tgl_awal = date('Y-m-d');
        $model->tgl_akhir = date('Y-m-d');
        
        if (isset($_GET['KPPegawaidiklatT'])){
            $model->attributes = $_GET['KPPegawaidiklatT'];            
            $model->tgl_awal = MyFormatter::formatDateTimeForDb($_GET['KPPegawaidiklatT']['tgl_awal']); 
            $model->tgl_akhir = MyFormatter::formatDateTimeForDb($_GET['KPPegawaidiklatT']['tgl_akhir']);             
        }
        
        $this->render('index',array('model'=>$model));
    }

    
    
  
}