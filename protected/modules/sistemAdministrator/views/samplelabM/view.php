<div class="white-container">
    <legend class="rim2">Lihat <b>Sampel Laboratorium</b></legend>
	<?php
    $this->breadcrumbs=array(
            'Lksamplelab Ms'=>array('index'),
            $model->samplelab_id,
    );

    $arrMenu = array();
    //                array_push($arrMenu,array('label'=>Yii::t('mds','View').' Sampel Lab'/*.$model->samplelab_id*/, 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' Sampel lab', 'icon'=>'list', 'url'=>array('index'))) ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Sampel Lab', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Update').' Sampel Lab', 'icon'=>'pencil','url'=>array('update','id'=>$model->samplelab_id))) :  '' ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','Delete').' Sampel Lab','icon'=>'trash','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->samplelab_id),'confirm'=>Yii::t('mds','Are you sure you want to delete this item?')))) ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Sampel Lab ', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

    $this->menu=$arrMenu;

    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
            'data'=>$model,
            'attributes'=>array(
                    'samplelab_id',
                    'samplelab_nama',
                    'samplelab_namalainnya',
                    //'samplelab_aktif',
                    array(
                        'label'=>'Aktif',
                        'type'=>'raw',
                        'value'=>(($model->samplelab_aktif == 1) ? Yii::t('mds', 'Yes') : Yii::t('mds', 'No')),
                    ),
            ),
    )); ?>

    <?php echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Sampel Lab', array('{icon}'=>'<i class="icon-file icon-white"></i>')), $this->createUrl('admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'))."&nbsp";
            $this->widget('UserTips',array('type'=>'view'));?>
</div>