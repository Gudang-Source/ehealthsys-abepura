<?php
$this->breadcrumbs=array(
	'Kpkolomrating Ms'=>array('index'),
	$model->kolomrating_id=>array('view','id'=>$model->kolomrating_id),
	'Update',
);

?>
<fieldset class="box">
	<legend class="rim">Ubah Kolom Rating</legend>

	<?php $this->widget('bootstrap.widgets.BootAlert'); ?>

	<?php echo $this->renderPartial('_form',array('model'=>$model)); ?></div>
</fieldset>