<?php
/*$this->breadcrumbs=array(
	'Sagelar Belakang Ms',
);

$arrMenu = array();
                array_push($arrMenu,array('label'=>Yii::t('mds','List').' Gelar Belakang ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
//                (Yii::app()->user->checkAccess('Create')) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Gelar Belakang', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
                (Yii::app()->user->checkAccess('Admin')) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Gelar Belakang', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

$this->menu=$arrMenu;

$this->widget('bootstrap.widgets.BootAlert'); ?>

<?php $this->widget('ext.bootstrap.widgets.BootListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>

<?php $this->widget('UserTips',array('type'=>'list')); */?>

<div class="white-container">
    <legend class="rim2">Master <b>Data</b></legend>
    <?php $this->renderPartial('_tabMenu',array()); ?>
    <?php $this->renderPartial('_jsFunctions',array()); ?>
    <div>
        <iframe class="biru" id="frame" src="" width='100%' frameborder="0" style="overflow-y:scroll" ></iframe>
    </div>
</div>