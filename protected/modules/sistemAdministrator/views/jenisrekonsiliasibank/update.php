<?php
$this->breadcrumbs=array(
	'Akjenisrekonsiliasibank Ms'=>array('index'),
	$model->jenisrekonsiliasibank_id=>array('view','id'=>$model->jenisrekonsiliasibank_id),
	'Update',
);

?>
<fieldset class="box">
	<legend class="rim">Ubah Jenis Rekonsiliasi Bank</legend>

	<?php $this->widget('bootstrap.widgets.BootAlert'); ?>

	<?php echo $this->renderPartial($this->path_view.'_form',array('model'=>$model)); ?>
</fieldset>
