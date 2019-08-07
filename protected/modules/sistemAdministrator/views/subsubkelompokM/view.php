<div class="white-container">
    <legend class="rim2">Lihat <b>Sub Sub Kelompok</b></legend>
<?php
$this->breadcrumbs=array(
	'Sasubkelompok Ms'=>array('index'),
	$model->subsubkelompok_id,
);

$arrMenu = array();
                //array_push($arrMenu,array('label'=>Yii::t('mds','View').' Sub Kelompok', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
//                array_push($arrMenu,array('label'=>Yii::t('mds','List').' SASubkelompokM', 'icon'=>'list', 'url'=>array('index'))) ;
//                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' SASubkelompokM', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
//                (Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Update').' SASubkelompokM', 'icon'=>'pencil','url'=>array('update','id'=>$model->subkelompok_id))) :  '' ;
//                array_push($arrMenu,array('label'=>Yii::t('mds','Delete').' SASubkelompokM','icon'=>'trash','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->subkelompok_id),'confirm'=>Yii::t('mds','Are you sure you want to delete this item?')))) ;
                // (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Sub Kelompok', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

$this->menu=$arrMenu;

$this->widget('bootstrap.widgets.BootAlert'); ?>

<?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'subsubkelompok_id',
		'subkelompok_id',
		'subsubkelompok_kode',
		'subsubkelompok_nama',
		'subsubkelompok_namalainnya',
		'subsubkelompok_aktif',
	),
)); ?>

<?php 
echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Sub Sub Kelompok', array('{icon}'=>'<i class="icon-file icon-white"></i>')), $this->createUrl(Yii::app()->controller->id.'/admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'))."&nbsp";
$this->widget('UserTips',array('type'=>'view'));
?>
</div>