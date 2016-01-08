<?php
$this->breadcrumbs=array(
	'Carakeluar Ms'=>array('index'),
	$model->carakeluar_id=>array('view','id'=>$model->carakeluar_id),
	'Update',
);

?>
<legend class="rim2">Ubah Cara Keluar</legend>

<?php $this->widget('bootstrap.widgets.BootAlert'); ?>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>
