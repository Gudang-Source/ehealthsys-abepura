<?php
$this->breadcrumbs=array(
	'Sarekeningcolumn Ms'=>array('index'),
	$model->tujuan_id=>array('view','id'=>$model->tujuan_id),
	'Update',
);

?>
<div class="white-container">
	<legend class="rim2">Ubah Tujuan</legend>

	<?php $this->widget('bootstrap.widgets.BootAlert'); ?>

	<?php echo $this->renderPartial($this->path_view.'_form',array('model'=>$model)); ?></div>
