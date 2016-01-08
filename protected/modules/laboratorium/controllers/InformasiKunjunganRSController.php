<?php

class InformasiKunjunganRSController extends MyAuthController
{
        
    public function actionIndex()
    {
        $format = new MyFormatter();
        $model = new LBInfokunjunganrjrdriV;
        $model->tgl_awal = date('Y-m-d');
        $model->tgl_akhir = date('Y-m-d');

        if(isset($_GET['LBInfokunjunganrjrdriV'])){
            $model->attributes=$_GET['LBInfokunjunganrjrdriV'];
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['LBInfokunjunganrjrdriV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['LBInfokunjunganrjrdriV']['tgl_akhir']);

        }
        $this->render('index',array('model'=>$model,'format'=>$format));
    }
}