<?php
$this->breadcrumbs=array(
	'Kondisi Keluar Ms'=>array('index'),
	'Create',
);
?>
<legend class="rim2">Tambah Kondisi Keluar</legend>
<?php $this->widget('bootstrap.widgets.BootAlert'); ?>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
