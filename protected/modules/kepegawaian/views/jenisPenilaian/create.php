<?php
$this->breadcrumbs=array(
	'Kpjenispenilaian Ms'=>array('index'),
	'Create',
);
?>
<fieldset class="box">
	<legend class="rim">Tambah Jenis Penilaian</legend>
	<?php $this->widget('bootstrap.widgets.BootAlert'); ?>

	<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
</fieldset>