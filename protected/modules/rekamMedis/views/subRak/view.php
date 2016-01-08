<div class="white-container">
    <legend class="rim2">Lihat <b>Sub Rak</b></legend>
    <?php
    $this->breadcrumbs=array(
            'Rmsub Raks'=>array('index'),
            $model->subrak_id,
    );

    $arrMenu = array();
    //                array_push($arrMenu,array('label'=>Yii::t('mds','View').' Sub Rak ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' RKSubRak', 'icon'=>'list', 'url'=>array('index'))) ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' RKSubRak', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Update').' RKSubRak', 'icon'=>'pencil','url'=>array('update','id'=>$model->subrak_id))) :  '' ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','Delete').' RKSubRak','icon'=>'trash','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->subrak_id),'confirm'=>Yii::t('mds','Are you sure you want to delete this item?')))) ;
                    (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Sub Rak', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

    $this->menu=$arrMenu;

    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
            'data'=>$model,
            'attributes'=>array(
                    'subrak_id',
                    'subrak_nama',
                    'subrak_namalainnya',
                                    array(
                                        'label'=>'Aktif',
                                        'value'=>(($model->subrak_aktif==1)? "Ya" : "Tidak"),
                                    ),
            ),
    )); ?>

    <?php $this->widget('UserTips',array('type'=>'view'));?>
</div>