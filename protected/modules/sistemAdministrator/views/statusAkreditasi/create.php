<?php
$this->breadcrumbs=array(
	'Gfatc Ms'=>array('index'),
	'Create',
);
?>
<legend class="rim">Tambah Status Akreditasi</legend>
<?php $this->widget('bootstrap.widgets.BootAlert'); ?>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
