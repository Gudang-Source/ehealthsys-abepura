<?php
$this->breadcrumbs=array(
	'Potonganpph21 Ms'=>array('index'),
	'Create',
);
?>
<div class="white-container">
	<legend class="rim2">Tambah <b>Potongan PPH 21</b></legend>
	<?php $this->widget('bootstrap.widgets.BootAlert'); ?>

	<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
</div>