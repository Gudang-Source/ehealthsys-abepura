<?php
$this->breadcrumbs=array(
	'Kpharilibur Ms'=>array('index'),
	$model->harilibur_id=>array('view','id'=>$model->harilibur_id),
	'Update',
);

?>
<div class="white-container">
	<legend class="rim2">Ubah Hari Libur</legend>

	<?php $this->widget('bootstrap.widgets.BootAlert'); ?>

	<?php echo $this->renderPartial($this->path_view.'_form',array('model'=>$model,'format'=>$format)); ?></div>
