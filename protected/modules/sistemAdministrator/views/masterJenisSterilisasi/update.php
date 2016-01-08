<?php
$this->breadcrumbs=array(
	'Sajenissterilisasi Ms'=>array('index'),
	$model->jenissterilisasi_id=>array('view','id'=>$model->jenissterilisasi_id),
	'Update',
);

?>
<div class="white-container">
	<legend class="rim2">Ubah Master Jenis Sterilisasi</legend>

	<?php $this->widget('bootstrap.widgets.BootAlert'); ?>

	<?php echo $this->renderPartial($this->path_view.'_form',array('model'=>$model)); ?></div>
