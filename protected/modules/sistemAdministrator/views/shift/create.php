<fieldset class="box row-fluid">
    <legend class="rim">Tambah Shift</legend>
<?php
$this->breadcrumbs=array(
	'Sashift Ms'=>array('index'),
	'Create',
);
?>
<!--<div class="white-container">
	<legend class="rim2">Tambah <b>Shift</b></legend>-->
	<?php $this->widget('bootstrap.widgets.BootAlert'); ?>

	<?php echo $this->renderPartial($this->path_view.'_form', array('model'=>$model,'modBerlaku'=>$modBerlaku)); ?>
<!--</div>-->
</fieldset>