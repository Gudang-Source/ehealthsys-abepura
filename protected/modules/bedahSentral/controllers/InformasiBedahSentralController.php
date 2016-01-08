<?php

class InformasiBedahSentralController extends MyAuthController
{
        
    
	public function actionInformasiJadwalOperasi()
	{
                $model = new BSRencanaOperasiT('search');
                $model->tgl_awal = date('Y-m-d');
                $model->tgl_akhir = date('Y-m-d');
                if (isset($_GET['BSRencanaOperasiT'])) {
                        $format = new MyFormatter;
                        $model->attributes = $_GET['BSRencanaOperasiT'];
                        $model->tgl_awal = $format->formatDateTimeForDb($_GET['BSRencanaOperasiT']['tgl_awal']);
                        $model->tgl_akhir = $format->formatDateTimeForDb($_GET['BSRencanaOperasiT']['tgl_akhir']);
                }
                    
		$this->render('jadwalOperasi/admin',array('model'=>$model));
	}
        
       

}