<?php
$this->breadcrumbs=array(
	'Saperiodeposting Ms'=>array('index'),
	$model->periodeposting_id=>array('view','id'=>$model->periodeposting_id),
	'Update',
);

?>
<div class="white-container">
	<legend class="rim2">Ubah Periode Posting</legend>

	<?php $this->widget('bootstrap.widgets.BootAlert'); ?>

	<?php echo $this->renderPartial($this->path_view.'_form',array('model'=>$model)); ?></div>
