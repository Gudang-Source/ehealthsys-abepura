<?php
$this->breadcrumbs=array(
	'Kpkompetensi Ms'=>array('index'),
	'Create',
);
?>
<fieldset class="box">
	<legend class="rim">Tambah Kompetensi</legend>
	<?php $this->widget('bootstrap.widgets.BootAlert'); ?>

	<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
</fieldset>