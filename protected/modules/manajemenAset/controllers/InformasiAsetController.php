<?php
class InformasiAsetController extends MyAuthController
{
    public $layout = '//layouts/column1';
    public $path_view = 'manajementAset.views.informasiPenjualan.';
    
    public function actionRumahSakit()
    {
        $model = new MAInfoInventarisasiRuanganV;
       // $model->tgl_awal = date('Y-m-d');
       // $model->tgl_akhir = date('Y-m-d');
        
        if (isset($_GET['MAInfoInventarisasiRuanganV'])){
            $model->attributes = $_GET['MAInfoInventarisasiRuanganV'];
         //   $model->barang_nama = $_GET['MAInvtanahT']['barang_nama'];
           // $model->tgl_awal = MyFormatter::formatDateTimeForDb($_GET['MAInvtanahT']['tgl_awal']);
           // $model->tgl_akhir = MyFormatter::formatDateTimeForDb($_GET['MAInvtanahT']['tgl_akhir']);
        }
        
        $this->render('rumahSakit/index', array('model'=>$model));
        
    }
    
    
}
?>
