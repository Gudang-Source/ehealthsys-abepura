<?php
$this->breadcrumbs=array(
	'Salinen Ms'=>array('index'),
	'Create',
);
?>
<div class="white-container">
	<legend class="rim2">Tambah <b>Linen</b></legend>
	<?php $this->widget('bootstrap.widgets.BootAlert'); ?>

	<?php echo $this->renderPartial($this->path_view.'_form', array('model'=>$model)); ?>
</div>