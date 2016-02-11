<?php if (!$this->isFrame): ?>
<?php
$this->breadcrumbs=array(
	'Carakeluar Ms'=>array('index'),
	$model->carakeluar_id=>array('view','id'=>$model->carakeluar_id),
	'Update',
);

?>
<legend class="rim2">Ubah Cara Keluar</legend>
<?php endif; ?>

<?php $this->widget('bootstrap.widgets.BootAlert'); ?>

<?php echo $this->renderPartial($this->path_view.'_form',array('model'=>$model)); ?>
