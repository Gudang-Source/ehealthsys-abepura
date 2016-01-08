<div class='white-container'>
    <legend class='rim2'>Lihat <b>Mata Uang</b></legend>
    <?php
    $this->breadcrumbs=array(
            'Matauang Ms'=>array('index'),
            $model->matauang_id,
    );

    $arrMenu = array();
    //                array_push($arrMenu,array('label'=>Yii::t('mds','View').' Mata Uang ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
                    (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Mata Uang ', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

    $this->menu=$arrMenu;

    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
            'data'=>$model,
            'attributes'=>array(
                    'matauang_id',
                    'matauang',
                    'singkatan',
                    array(            
                        'label'=>'Aktif',
                        'type'=>'raw',
                        'value'=>(($model->matauang_aktif==1)? ''.Yii::t('mds','Yes').'' : ''.Yii::t('mds','No').''),
                    ),
            ),
    )); ?>

    <?php $this->widget('UserTips',array('type'=>'view'));?>
</div>