<?php
$this->breadcrumbs=array(
	'Sakelrekening Ms'=>array('index'),
	$model->kelrekening_id=>array('view','id'=>$model->kelrekening_id),
	'Update',
);

?>
<div class="white-container">
	<legend class="rim2">Ubah SAKelrekeningM</legend>

	<?php $this->widget('bootstrap.widgets.BootAlert'); ?>

	<?php echo $this->renderPartial($this->path_view.'_form',array('model'=>$model)); ?></div>
