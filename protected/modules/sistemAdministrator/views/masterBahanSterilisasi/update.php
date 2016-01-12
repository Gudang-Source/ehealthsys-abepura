<?php
$this->breadcrumbs=array(
	'Sabahansterilisasi Ms'=>array('index'),
	$model->bahansterilisasi_id=>array('view','id'=>$model->bahansterilisasi_id),
	'Update',
);

?>
<div class="white-container">
	<legend class="rim2">Ubah Master Bahan Sterilisasi</legend>

	<?php $this->widget('bootstrap.widgets.BootAlert'); ?>

	<?php echo $this->renderPartial($this->path_view.'_form',array('model'=>$model)); ?></div>
