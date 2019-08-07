<?php

class InformasiUmurPiutangController extends MyAuthController {
        
    public $layout = '//layouts/column1';
    public $path_view = 'akuntansi.views.informasiUmurPiutang.';
    
    public function actionIndex()
    {
        $model = new MAInvtanahT;
        $model->tgl_awal = date('Y-m-d');
        $model->tgl_akhir = date('Y-m-d');
        
        if (isset($_GET['MAInvtanahT'])){
            $model->attributes = $_GET['MAInvtanahT'];
            $model->barang_nama = $_GET['MAInvtanahT']['barang_nama'];
            $model->tgl_awal = MyFormatter::formatDateTimeForDb($_GET['MAInvtanahT']['tgl_awal']);
            $model->tgl_akhir = MyFormatter::formatDateTimeForDb($_GET['MAInvtanahT']['tgl_akhir']);
        }
        
        $this->render($this->path_view.'tanah/index', array('model'=>$model));
        
    }
}
