<?php
$this->breadcrumbs=array(
	'Sakompgajirek Ms'=>array('index'),
	$model->komponengajirek_id=>array('view','id'=>$model->komponengajirek_id),
	'Update',
);

?>
<div class="white-container">
	<legend class="rim2">Ubah Rekening Komponen Gaji</legend>

	<?php $this->widget('bootstrap.widgets.BootAlert'); ?>

	<?php echo $this->renderPartial($this->path_view.'_form',array('model'=>$model)); ?></div>
