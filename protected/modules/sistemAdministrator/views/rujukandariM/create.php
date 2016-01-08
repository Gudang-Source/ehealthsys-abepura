<?php
$this->breadcrumbs=array(
	'Rujukandari Ms'=>array('index'),
	'Create',
);

$arrMenu = array();
//                array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Daftar Rujukan ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
//                array_push($arrMenu,array('label'=>Yii::t('mds','List').' RujukandariM', 'icon'=>'list', 'url'=>array('index'))) ;
//                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Daftar Rujukan', 'icon'=>'folder-open', 'url'=>array('Admin'))) :  '' ;

$this->menu=$arrMenu;

$this->widget('bootstrap.widgets.BootAlert'); ?>
<fieldset class="box">
    <legend class="rim">Tambah Daftar Rujukan</legend>
    <?php echo $this->renderPartial($this->path_view.'_form', array('model'=>$model)); ?>
</fieldset>