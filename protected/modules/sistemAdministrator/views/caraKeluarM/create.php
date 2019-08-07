<fieldset class="box">
<?php if (!$this->isFrame) : ?>
<legend class="rim2">Tambah Cara Keluar</legend>
<?php else: ?>
<legend class="rim">Tambah Cara Keluar</legend>
<?php endif; ?>
<?php
$this->breadcrumbs=array(
	'Carakeluar Ms'=>array('index'),
	'Create',
);
?>

<?php $this->widget('bootstrap.widgets.BootAlert'); ?>

<?php echo $this->renderPartial($this->path_view.'_form', array('model'=>$model)); ?>
</fieldset>