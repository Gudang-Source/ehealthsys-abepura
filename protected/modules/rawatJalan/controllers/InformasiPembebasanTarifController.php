<?php

class InformasiPembebasanTarifController extends MyAuthController{
    
    public $path_view = "rawatJalan.views.informasiPembebasanTarif.";
    
    public function actionIndex(){
        $model = new RJInformasipembebasantarifV('searchInformasi');
        $format = new MyFormatter();
        $model->unsetAttributes();
        $model->tgl_awal = date("d M Y");
        $model->tgl_akhir = date("d M Y");
        
        if(isset($_GET['RJInformasipembebasantarifV'])){
            $model->attributes = $_GET['RJInformasipembebasantarifV'];
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['RJInformasipembebasantarifV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['RJInformasipembebasantarifV']['tgl_akhir']);
            
            $model->tgl_awal = $model->tgl_awal;
            $model->tgl_akhir = $model->tgl_akhir;
        }
        
        
        $this->render($this->path_view.'index',array('model'=>$model));
    }
}
?>
