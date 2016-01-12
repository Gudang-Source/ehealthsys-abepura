<?php
$this->breadcrumbs=array(
	'Sajenisalatsterilisasi Ms'=>array('index'),
	$model->jenisalatmedis_id=>array('view','id'=>$model->jenisalatmedis_id),
	'Update',
);

?>
<div class="white-container">
	<legend class="rim2">Ubah Jenis Alat Sterilisasi</legend>

	<?php $this->widget('bootstrap.widgets.BootAlert'); ?>

	<?php echo $this->renderPartial($this->path_view.'_form',array('model'=>$model)); ?></div>
