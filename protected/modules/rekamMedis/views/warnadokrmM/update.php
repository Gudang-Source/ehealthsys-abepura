<?php
$this->breadcrumbs=array(
	'Warnadokrm Ms'=>array('index'),
	$model->warnadokrm_id=>array('view','id'=>$model->warnadokrm_id),
	'Update',
);

?>
<fieldset class="box">
	<legend class="rim">Ubah Warna Dokumen</legend>

	<?php $this->widget('bootstrap.widgets.BootAlert'); ?>

	<?php echo $this->renderPartial('_form',array('model'=>$model)); ?></fieldset>
