<?php
$this->breadcrumbs=array(
	'Kpindikatorperilaku Ms'=>array('index'),
	$model->indikatorperilaku_id=>array('view','id'=>$model->indikatorperilaku_id),
	'Update',
);

?>
<fieldset class="box">
	<legend class="rim">Ubah Indikator Perilaku</legend>

	<?php $this->widget('bootstrap.widgets.BootAlert'); ?>

	<?php echo $this->renderPartial('_form',array('model'=>$model)); ?></div>
</fieldset>