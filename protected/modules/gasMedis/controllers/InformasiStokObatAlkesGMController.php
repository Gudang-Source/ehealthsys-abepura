<?php

Yii::import('gudangFarmasi.controllers.InformasiStokObatAlkesController');
Yii::import('gudangFarmasi.views.informasiStokObatAlkes.*');
Yii::import('gudangFarmasi.models.*');

class InformasiStokObatAlkesGMController extends InformasiStokObatAlkesController {
    
    public function actionIndex()
    {
        $model=new GMInformasistokobatalkesV('search');
        $format = new MyFormatter();
        $instalasiAsals = null; // CHtml::listData(GFInstalasiM::getInstalasiStokOas(),'instalasi_id','instalasi_nama');
        $ruanganAsals = null; // CHtml::listData(GFRuanganM::getRuanganStokOas(Params::INSTALASI_ID_FARMASI),'ruangan_id','ruangan_nama');
        $model->ruangan_id=Yii::app()->user->getState('ruangan_id');
        $model->jenisobatalkes_id = Params::JENISOBATALKES_ID_GASMEDIS;
        if(isset($_GET['GMInformasistokobatalkesV'])){
            $model->attributes=$_GET['GMInformasistokobatalkesV'];
            if(empty($model->ruangan_id)){ $model->ruangan_id=Yii::app()->user->getState('ruangan_id'); }
        }
        $this->render('index',array(
            'format'=>$format,
            'model'=>$model,
            'instalasiAsals'=>$instalasiAsals,
            'ruanganAsals'=>$ruanganAsals,
        ));
    }
    
}
