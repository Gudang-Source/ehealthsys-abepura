<?php
$this->breadcrumbs=array(
	'Sapemeriksaanalatrad Ms'=>array('index'),
	'Create',
);
?>
<fieldset class="box">
	<legend class="rim">Tambah Alat Radiologi</legend>
	<?php $this->widget('bootstrap.widgets.BootAlert'); ?>

	<?php echo $this->renderPartial($this->path_view.'_form', array('model'=>$model)); ?>
</fieldlset>