<?php

class InformasiStokBahanMakananController extends MyAuthController
{
	public function actionIndex()
	{               
            $model = new GZStokbahanmakananT();
            $model->tgl_awal = date('Y-m-d 00:00:00');
            $model->tgl_akhir = date('Y-m-d 23:59:59');                      
            $model->cekTgl = 1;
            if(isset($_GET['GZStokbahanmakananT'])){
                $model->attributes=$_GET['GZStokbahanmakananT'];
                $model->tgl_awal = MyFormatter::formatDateTimeForDb($_GET['GZStokbahanmakananT']['tgl_awal']." 00:00:00");
                $model->tgl_akhir = MyFormatter::formatDateTimeForDb($_GET['GZStokbahanmakananT']['tgl_akhir']." 23:59:59");
                $model->namabahanmakanan = $_GET['GZStokbahanmakananT']['namabahanmakanan'];
                $model->cekTgl = $_GET['GZStokbahanmakananT']['cekTgl'];

            }
            $this->render('index',array('model'=>$model));
	}
                 
}