<?php
$this->breadcrumbs=array(
	'Sapemeriksaanlabmapping Ms'=>array('index'),
	'Create',
);
?>
<fieldset class="box">
	<legend class="rim">Tambah Pemeriksaan Laboratorium</legend>
	<?php $this->widget('bootstrap.widgets.BootAlert'); ?>

	<?php echo $this->renderPartial($this->path_view.'_form', array('model'=>$model, 'modDetails'=>$modDetails)); ?>
</fieldset>