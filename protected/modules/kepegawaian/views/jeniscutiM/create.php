<?php
$this->breadcrumbs=array(
	'Jeniscuti Ms'=>array('index'),
	'Create',
);
?>
<div class="white-container">
	<legend class="rim2">Tambah <b>JeniscutiM</b></legend>
	<?php $this->widget('bootstrap.widgets.BootAlert'); ?>

	<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
</div>