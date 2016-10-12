<?php
class InformasiPenjualanController extends MyAuthController
{
    public $layout = '//layouts/column1';
    public $path_view = 'manajementAset.views.informasiPenjualan.';
    
    public function actionTanah()
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
        
        $this->render('tanah/index', array('model'=>$model));
        
    }
    
    public function actionPeralatanMedis()
    {
        $model = new MAInvperalatanT;
        $model->tgl_awal = date('Y-m-d');
        $model->tgl_akhir = date('Y-m-d');
        
        if (isset($_GET['MAInvperalatanT'])){
            $model->attributes = $_GET['MAInvperalatanT'];
            $model->barang_nama = $_GET['MAInvperalatanT']['barang_nama'];
            $model->tgl_awal = MyFormatter::formatDateTimeForDb($_GET['MAInvperalatanT']['tgl_awal']);
            $model->tgl_akhir = MyFormatter::formatDateTimeForDb($_GET['MAInvperalatanT']['tgl_akhir']);
        }
        
        $this->render('peralatanMedis/index', array('model'=>$model));
        
    }
    
    public function actionPeralatanNonMedis()
    {
        $model = new MAInvperalatanT;
        $model->tgl_awal = date('Y-m-d');
        $model->tgl_akhir = date('Y-m-d');
        
        if (isset($_GET['MAInvperalatanT'])){
            $model->attributes = $_GET['MAInvperalatanT'];
            $model->barang_nama = $_GET['MAInvperalatanT']['barang_nama'];
            $model->tgl_awal = MyFormatter::formatDateTimeForDb($_GET['MAInvperalatanT']['tgl_awal']);
            $model->tgl_akhir = MyFormatter::formatDateTimeForDb($_GET['MAInvperalatanT']['tgl_akhir']);
        }
        
        $this->render('peralatanNonMedis/index', array('model'=>$model));
        
    }
    
    public function actionKendaraan()
    {
        $model = new MAInvperalatanT;
        $model->tgl_awal = date('Y-m-d');
        $model->tgl_akhir = date('Y-m-d');
        
        if (isset($_GET['MAInvperalatanT'])){
            $model->attributes = $_GET['MAInvperalatanT'];
            $model->barang_nama = $_GET['MAInvperalatanT']['barang_nama'];
            $model->tgl_awal = MyFormatter::formatDateTimeForDb($_GET['MAInvperalatanT']['tgl_awal']);
            $model->tgl_akhir = MyFormatter::formatDateTimeForDb($_GET['MAInvperalatanT']['tgl_akhir']);
        }
        
        $this->render('kendaraan/index', array('model'=>$model));
        
    }
    
    public function actionGedungDanBangunan()
    {
        $model = new MAInvgedungT;
        $model->tgl_awal = date('Y-m-d');
        $model->tgl_akhir = date('Y-m-d');
        
        if (isset($_GET['MAInvgedungT'])){
            $model->attributes = $_GET['MAInvgedungT'];
            $model->barang_nama = $_GET['MAInvgedungT']['barang_nama'];
            $model->tgl_awal = MyFormatter::formatDateTimeForDb($_GET['MAInvgedungT']['tgl_awal']);
            $model->tgl_akhir = MyFormatter::formatDateTimeForDb($_GET['MAInvgedungT']['tgl_akhir']);
        }
        
        $this->render('gedungDanBangunan/index', array('model'=>$model));
        
    }
}
?>
