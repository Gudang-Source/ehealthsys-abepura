<?php
$this->breadcrumbs=array(
	'Carakeluar Ms'=>array('index'),
	'Create',
);
?>
<legend class="rim2">Tambah Cara Keluar</legend>
<?php $this->widget('bootstrap.widgets.BootAlert'); ?>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
