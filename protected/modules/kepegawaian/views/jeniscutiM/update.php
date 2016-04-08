<?php
$this->breadcrumbs=array(
	'Jeniscuti Ms'=>array('index'),
	$model->jeniscuti_id=>array('view','id'=>$model->jeniscuti_id),
	'Update',
);

?>
<div class="white-container">
	<legend class="rim2">Ubah JeniscutiM</legend>

	<?php $this->widget('bootstrap.widgets.BootAlert'); ?>

	<?php echo $this->renderPartial('_form',array('model'=>$model)); ?></div>
