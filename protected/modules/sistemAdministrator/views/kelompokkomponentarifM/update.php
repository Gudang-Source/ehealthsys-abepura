<?php
$this->breadcrumbs=array(
	'Sakelompokkomponentarif Ms'=>array('index'),
	$model->kelompokkomponentarif_id=>array('view','id'=>$model->kelompokkomponentarif_id),
	'Update',
);

?>
<div class="white-container">
	<legend class="rim2">Ubah Kelompok Komponen Tarif</legend>

	<?php $this->widget('bootstrap.widgets.BootAlert'); ?>

	<?php echo $this->renderPartial('_form',array('model'=>$model)); ?></div>
