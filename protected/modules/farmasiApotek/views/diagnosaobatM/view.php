<div class="white-container">
    <legend class="rim2">Lihat <b>Diagnosa Obat</b></legend>
    <?php
    $this->breadcrumbs=array(
            'Fadiagnosaobat Ms'=>array('index'),
            $model->diagnosa_id,
    );

    $arrMenu = array();
    //                array_push($arrMenu,array('label'=>Yii::t('mds','View').' Diagnosa Obat ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
                    (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Diagnosa Obat ', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

    $this->menu=$arrMenu;

    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php $this->widget('ext.bootstrap.widgets.BootDetailView', array(
            'data'=>$model,
            'attributes'=>array(
                    'diagnosa.diagnosa_kode',
                                    'diagnosa.diagnosa_nama',
                                    array(
                                        'label'=>'Obat Alkes',
                                        'type'=>'raw',
                                        'value'=>$this->renderPartial('_obatalkes', array('diagnosa_id'=>$model->diagnosa_id), true),
                                    ),
            ),
    )); ?>
    <?php $this->widget('UserTips',array('type'=>'view'));?>
</div>