<?php
$this->breadcrumbs=array(
	'Salinen Ms'=>array('index'),
	$model->linen_id=>array('view','id'=>$model->linen_id),
	'Update',
);

?>
<div class="white-container">
	<legend class="rim2">Ubah Linen</legend>

	<?php $this->widget('bootstrap.widgets.BootAlert'); ?>

	<?php echo $this->renderPartial($this->path_view.'_form',array('model'=>$model)); ?></div>
