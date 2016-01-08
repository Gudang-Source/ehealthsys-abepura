<?php
$this->breadcrumbs=array(
	'Sabahanperawatan Ms'=>array('index'),
	$model->bahanperawatan_id=>array('view','id'=>$model->bahanperawatan_id),
	'Update',
);

?>
<div class="white-container">
	<legend class="rim2">Ubah Bahan Perawatan</legend>

	<?php $this->widget('bootstrap.widgets.BootAlert'); ?>

	<?php echo $this->renderPartial($this->path_view.'_form',array('model'=>$model)); ?></div>
