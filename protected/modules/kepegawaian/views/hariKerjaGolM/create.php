<fieldset class="white-container">
    <legend class="rim2">Tambah <b>Hari Kerja Golongan</b></legend>
<?php
/*
$this->breadcrumbs=array(
	'Hari Kerja Golongan Ms'=>array('index'),
	'Create',
);
 * 
 */

//$arrMenu = array();
//array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Hari Kerja Golongan ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
//(Yii::app()->user->checkAccess('Admin')) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Hari Kerja Golongan', 'icon'=>'folder-open', 'url'=>array('Admin'))) :  '' ;

//$this->menu=$arrMenu;

$this->widget('bootstrap.widgets.BootAlert'); ?>
<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
</fieldset>