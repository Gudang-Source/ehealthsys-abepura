<?php
$this->breadcrumbs=array(
	'Guinvgedung Ts',
);

$arrMenu = array();
                array_push($arrMenu,array('label'=>Yii::t('mds','List').' Inventarisasi Gedung dan Bangunan ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
                //(Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' MAInvgedungT', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Inventarisasi Gedung dan Bangunan', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

$this->menu=$arrMenu;

$this->widget('bootstrap.widgets.BootAlert'); ?>

<?php $this->widget('ext.bootstrap.widgets.BootListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>

<?php $this->widget('UserTips',array('type'=>'list'));?>