<?php
$this->breadcrumbs=array(
	'Saformasishift Ms'=>array('index'),
	$model->formasishift_id=>array('view','id'=>$model->formasishift_id),
	'Update',
);

?>
<div class="white-container">
	<legend class="rim2">Ubah Formasi Shift</legend>

	<?php $this->widget('bootstrap.widgets.BootAlert'); ?>

	<?php echo $this->renderPartial($this->path_view.'_form',array('model'=>$model)); ?></div>
