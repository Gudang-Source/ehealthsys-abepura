<?php
$this->breadcrumbs=array(
	'Saasal Rujukan Ms'=>array('index'),
	'Create',
);

$this->menu=array(
//        array('label'=>Yii::t('mds','Create').' Asal Rujukan ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master')),
//	array('label'=>Yii::t('mds','List').' Asal Rujukan', 'icon'=>'list', 'url'=>array('index')),
//	array('label'=>Yii::t('mds','Manage').' Asal Rujukan', 'icon'=>'folder-open', 'url'=>array('admin')),
);

$this->widget('bootstrap.widgets.BootAlert'); ?>
<fieldset class="box">
    <legend class="rim">Tambah Asal Rujukan</legend>
    <?php echo $this->renderPartial($this->path_view.'_form', array('model'=>$model)); ?>
    <?php //$this->widget('UserTips',array('type'=>'create'));?>
</fieldset>