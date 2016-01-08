<?php
$this->breadcrumbs=array(
	'Kpkompetensi Ms'=>array('index'),
	$model->kompetensi_id=>array('view','id'=>$model->kompetensi_id),
	'Update',
);

?>
<fieldset class="box">
	<legend class="rim">Ubah Kompetensi</legend>

	<?php $this->widget('bootstrap.widgets.BootAlert'); ?>

	<?php echo $this->renderPartial('_form',array('model'=>$model)); ?></div>
</fieldset>