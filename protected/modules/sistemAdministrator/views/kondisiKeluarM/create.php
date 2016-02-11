<?php if (!$this->isFrame) : ?>
<?php
$this->breadcrumbs=array(
	'Kondisi Keluar Ms'=>array('index'),
	'Create',
);
?>
<legend class="rim2">Tambah Kondisi Keluar</legend>
<?php endif; ?>
<?php $this->widget('bootstrap.widgets.BootAlert'); ?>

<?php echo $this->renderPartial($this->path_view.'_form', array('model'=>$model)); ?>
