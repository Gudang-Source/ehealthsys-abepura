<?php

class InformasiKartuStokObatAlkesController extends MyAuthController
{
    public $defaultAction ='index';
    public $path_view ='gudangFarmasi.views.informasiKartuStokObatAlkes.';

    public function actionIndex()
    {
        $model=new GFInformasikartustokobatalkesV('search');
        $format = new MyFormatter();
        $disabled = false;
        $ruanganAsals = CHtml::listData(GFRuanganM::model()->findAll("ruangan_aktif = TRUE ORDER BY ruangan_nama ASC"), 'ruangan_id', 'ruangan_nama');
        $instalasiAsals = CHtml::listData(GFInstalasiM::getInstalasiStokOas(),'instalasi_id','instalasi_nama');
        $ruanganAsals = CHtml::listData(GFRuanganM::getRuanganStokOas(Params::INSTALASI_ID_FARMASI),'ruangan_id','ruangan_nama');
        $model->tgl_awal = date("Y-m-d");
        $model->tgl_akhir = date("Y-m-d");
        $model->instalasi_id = Yii::app()->user->getState('instalasi_id');
        $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
		if(Yii::app()->controller->module->id != 'gudangFarmasi'){
                        $disabled = true;
		}
        if(isset($_GET['GFInformasikartustokobatalkesV'])){
            $model->attributes=$_GET['GFInformasikartustokobatalkesV'];
            $model->tgl_awal=$format->formatDateTimeForDb($_GET['GFInformasikartustokobatalkesV']['tgl_awal']);
            $model->tgl_akhir=$format->formatDateTimeForDb($_GET['GFInformasikartustokobatalkesV']['tgl_akhir']);
			$model->transaksi = !empty($_GET['GFInformasikartustokobatalkesV']['transaksi'])?$_GET['GFInformasikartustokobatalkesV']['transaksi']:null;
        }
        $this->render($this->path_view.'index',array(
            'format'=>$format,
            'model'=>$model,
            'instalasiAsals'=>$instalasiAsals,
            'ruanganAsals'=>$ruanganAsals,
            'disabled' => $disabled,
        ));
    }
        
    /**
     * Mengatur dropdown ruangan
     * @param type $encode jika = true maka return array jika false maka set Dropdown 
     * @param type $model_nama
     * @param type $attr
     */
    public function actionSetDropdownRuangan($encode=false,$model_nama='',$attr='')
    {
        if(Yii::app()->request->isAjaxRequest) {
            $instalasi_id = null;
            if($model_nama !=='' && $attr == ''){
                $instalasi_id = $_POST["$model_nama"]['instalasi_id'];
            }
             else if ($model_nama == '' && $attr !== '') {
                $instalasi_id = $_POST["$attr"];
            }
             else if ($model_nama !== '' && $attr !== '') {
                $instalasi_id = $_POST["$model_nama"]["$attr"];
            }
            $models = null;
            $models = CHtml::listData(GFRuanganM::getRuanganStokOas($instalasi_id),'ruangan_id','ruangan_nama');

            if($encode){
                echo CJSON::encode($models);
            } else {
                if (count($models) > 1){
                    echo CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
                }elseif (count($models) == 0){
                    echo CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
                }                
                if(count($models) > 0){
                    foreach($models as $value=>$name){
                        echo CHtml::tag('option', array('value'=>$value),CHtml::encode($name),true);
                    }
                }
            }
        }
        Yii::app()->end();
    }
        
}

