<?php
$this->breadcrumbs=array(
	'Kondisi Keluar Ms'=>array('index'),
	$model->kondisikeluar_id=>array('view','id'=>$model->kondisikeluar_id),
	'Update',
);

?>
<legend class="rim2">Ubah Kondisi Keluar</legend>

<?php $this->widget('bootstrap.widgets.BootAlert'); ?>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>
