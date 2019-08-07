<?php
$this->breadcrumbs=array(
	'Warnadokrm Ms'=>array('index'),
	'Create',
);
?>
<fieldset class="box">
	<legend class="rim">Tambah <b>Warna Dokumen</b></legend>
	<?php $this->widget('bootstrap.widgets.BootAlert'); ?>

	<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
</fieldset>