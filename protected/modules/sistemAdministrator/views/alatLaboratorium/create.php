<?php
$this->breadcrumbs=array(
	'Sapemeriksaanlabalat Ms'=>array('index'),
	'Create',
);
?>
<fieldset class="box">
	<legend class="rim">Tambah Master Alat Laboratorium</legend>
	<?php $this->widget('bootstrap.widgets.BootAlert'); ?>

	<?php echo $this->renderPartial($this->path_view.'_form', array('model'=>$model)); ?>
</fieldset>