<?php
$this->breadcrumbs=array(
	'Kpindikatorperilaku Ms'=>array('index'),
	$model->indikatorperilaku_id=>array('view','id'=>$model->indikatorperilaku_id),
	'Update',
);

?>
<div class="white-container">
	<legend class="rim2">Ubah Indikator Perilaku</legend>

	<?php $this->widget('bootstrap.widgets.BootAlert'); ?>

	<?php echo $this->renderPartial($this->path_view.'_form',array('model'=>$model)); ?></div>
