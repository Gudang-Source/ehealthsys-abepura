<?php
$this->breadcrumbs=array(
	'Rmbody Mass Indexes'=>array('index'),
	$model->bodymassindex_id,
);

$arrMenu = array();
                array_push($arrMenu,array('label'=>Yii::t('mds','View').'  Body Mass Index', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
//                array_push($arrMenu,array('label'=>Yii::t('mds','List').' SABodymassindexM', 'icon'=>'list', 'url'=>array('index'))) ;
//                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' SABodymassindexM', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
//                (Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Update').' SABodymassindexM', 'icon'=>'pencil','url'=>array('update','id'=>$model->bodymassindex_id))) :  '' ;
//                array_push($arrMenu,array('label'=>Yii::t('mds','Delete').' SABodymassindexM','icon'=>'trash','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->bodymassindex_id),'confirm'=>Yii::t('mds','Are you sure you want to delete this item?')))) ;
                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Body Mass Index', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

$this->menu=$arrMenu;

$this->widget('bootstrap.widgets.BootAlert'); ?>

<?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'bodymassindex_id',
		'bmi_range',
		'bmi_minimum',
		'bmi_maksimum',
		'bmi_sign',
		'bmi_defenisi',
		'bmi_pesan',
                                array(
                                    'label'=>'Aktif',
                                    'value'=>(($model->bodymassindex_aktif==1)? "Ya" : "Tidak")
                                ),
	),
)); ?>

<?php $this->widget('UserTips',array('type'=>'view'));?>