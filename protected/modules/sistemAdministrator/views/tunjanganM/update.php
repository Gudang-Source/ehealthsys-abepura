<?php
$this->breadcrumbs=array(
	'Kptunjangan Ms'=>array('index'),
	$model->tunjangan_id=>array('view','id'=>$model->tunjangan_id),
	'Update',
);

?>
<div class="white-container">
	<legend class="rim2">Ubah Tunjangan</legend>

	<?php $this->widget('bootstrap.widgets.BootAlert'); ?>

	<?php echo $this->renderPartial($this->path_view.'_form',array('model'=>$model)); ?></div>
