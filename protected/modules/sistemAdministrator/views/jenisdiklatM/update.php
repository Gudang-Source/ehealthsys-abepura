<?php
$this->breadcrumbs=array(
	'Kpjenisdiklat Ms'=>array('index'),
	$model->jenisdiklat_id=>array('view','id'=>$model->jenisdiklat_id),
	'Update',
);

?>
<div class="white-container">
	<legend class="rim2">Ubah Jenis Diklat</legend>

	<?php $this->widget('bootstrap.widgets.BootAlert'); ?>

	<?php echo $this->renderPartial($this->path_view.'_form',array('model'=>$model)); ?></div>
