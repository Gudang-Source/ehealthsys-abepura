<?php
$this->breadcrumbs=array(
	'Saasal Rujukan Ms'=>array('index'),
	$model->asalrujukan_id=>array('view','id'=>$model->asalrujukan_id),
	'Update',
);

$this->menu=array(
//        array('label'=>Yii::t('mds','Update').' Asal Rujukan ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master')),
//	array('label'=>Yii::t('mds','List').' Asal Rujukan', 'icon'=>'list', 'url'=>array('index')),
//	array('label'=>Yii::t('mds','Create').' Asal Rujukan', 'icon'=>'file', 'url'=>array('create')),
//	array('label'=>Yii::t('mds','View').' Asal Rujukan', 'icon'=>'eye-open', 'url'=>array('view','id'=>$model->asalrujukan_id)),
//	array('label'=>Yii::t('mds','Manage').' Asal Rujukan', 'icon'=>'folder-open', 'url'=>array('admin')),
);

$this->widget('bootstrap.widgets.BootAlert'); ?>
<fieldset class="box">
    <legend class="rim">Ubah Asal Rujukan</legend>
    <?php echo $this->renderPartial($this->path_view.'_formUpdate',array('model'=>$model)); ?>
    <?php //$this->widget('UserTips',array('type'=>'update'));?>
</fieldset>