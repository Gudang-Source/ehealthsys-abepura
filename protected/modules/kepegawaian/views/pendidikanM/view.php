<?php
$this->breadcrumbs=array(
	'Sapendidikan Ms'=>array('index'),
	$model->pendidikan_id,
);

$arrMenu = array();
//                array_push($arrMenu,array('label'=>Yii::t('mds','View').' Pendidikan ','header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
//                array_push($arrMenu,array('label'=>Yii::t('mds','List').' Pendidikan', 'icon'=>'list', 'url'=>array('index'))) ;
//                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Pendidikan', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
//                (Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Update').' Pendidikan', 'icon'=>'pencil','url'=>array('update','id'=>$model->pendidikan_id))) :  '' ;
//                array_push($arrMenu,array('label'=>Yii::t('mds','Delete').' Pendidikan','icon'=>'trash','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->pendidikan_id),'confirm'=>Yii::t('mds','Are you sure you want to delete this item?')))) ;
                // (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Pendidikan', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

$this->menu=$arrMenu;

$this->widget('bootstrap.widgets.BootAlert'); ?>
<fieldset class="box">
    <legend class="rim">Lihat Pendidikan</legend>
    <?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
            'data'=>$model,
            'attributes'=>array(
                    'pendidikan_id',
                    'pendidikan_nama',
                    'pendidikan_namalainnya',
                     array(               // related city displayed as a link
                        'name'=>'pendidikan_aktif',
                        'type'=>'raw',
                        'value'=>(($model->pendidikan_aktif==1)? Yii::t('mds','Yes') : Yii::t('mds','No')),
                    ),
            ),
    )); ?>

    <?php 
            echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Pendidikan', array('{icon}'=>'<i class="icon-file icon-white"></i>')), $this->createUrl(Yii::app()->controller->id.'/admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'))."&nbsp";
            $this->widget('UserTips',array('type'=>'view'));
    ?>
</fieldset>