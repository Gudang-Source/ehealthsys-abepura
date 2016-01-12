<?php
$this->breadcrumbs=array(
	'Kpjenispenilaian Ms'=>array('index'),
	$model->jenispenilaian_id=>array('view','id'=>$model->jenispenilaian_id),
	'Update',
);

?>
<fieldset class="box">
	<legend class="rim">Ubah Jenis Penilaian</legend>

	<?php $this->widget('bootstrap.widgets.BootAlert'); ?>

	<?php echo $this->renderPartial('_form',array('model'=>$model)); ?></div>
</fieldset>