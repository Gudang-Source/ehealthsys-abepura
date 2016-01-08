<?php
$this->breadcrumbs=array(
	'Saloket Ms'=>array('index'),
	$model->loket_id=>array('view','id'=>$model->loket_id),
	'Update',
);

?>
<div class="white-container">
	<legend class="rim2">Ubah Loket</legend>

	<?php $this->widget('bootstrap.widgets.BootAlert'); ?>

	<?php echo $this->renderPartial($this->path_view.'_form',array('model'=>$model)); ?></div>
