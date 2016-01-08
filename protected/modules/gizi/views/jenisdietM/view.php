<div class="white-container">
    <legend class="rim2">Lihat <b>Jenis Diet</b></legend>
    <?php
    $this->breadcrumbs=array(
            'Gzjenisdiet Ms'=>array('index'),
            $model->jenisdiet_id,
    );

    $arrMenu = array();
    //                array_push($arrMenu,array('label'=>Yii::t('mds','View').' Jenis Diet ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' Jenis Diet', 'icon'=>'list', 'url'=>array('index'))) ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Jenis Diet', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Update').' Jenis Diet', 'icon'=>'pencil','url'=>array('update','id'=>$model->jenisdiet_id))) :  '' ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','Delete').' Jenis Diet','icon'=>'trash','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->jenisdiet_id),'confirm'=>Yii::t('mds','Are you sure you want to delete this item?')))) ;
                    (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Jenis Diet', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

    $this->menu=$arrMenu;

    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
            'data'=>$model,
            'attributes'=>array(
                    'jenisdiet_id',
                    'jenisdiet_nama',
                    'jenisdiet_namalainnya',
                                    'jenisdiet_keterangan',
                    array(
                        'header'=>'catatan',
                        'type'=>'raw',
                        'value'=>nl2br($model->jenisdiet_catatan),
                    ),
                    array(            
                        'label'=>'Aktif',
                        'type'=>'raw',
                        'value'=>(($model->jenisdiet_aktif==1)? ''.Yii::t('mds','Yes').'' : ''.Yii::t('mds','No').''),
                    ),
            ),
    )); ?>

    <?php $this->widget('UserTips',array('type'=>'view'));?>
</div>