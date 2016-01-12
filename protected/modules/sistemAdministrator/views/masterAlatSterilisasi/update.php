<?php
$this->breadcrumbs=array(
	'Saalatsterilisasi Ms'=>array('index'),
	$model->alatmedis_id=>array('view','id'=>$model->alatmedis_id),
	'Update',
);

?>
<div class="white-container">
	<legend class="rim2">Ubah Alat Sterilisasi</legend>

	<?php $this->widget('bootstrap.widgets.BootAlert'); ?>

	<?php echo $this->renderPartial($this->path_view.'_form',array('model'=>$model)); ?></div>
