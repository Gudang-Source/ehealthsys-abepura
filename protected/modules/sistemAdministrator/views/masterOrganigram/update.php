<?php
$this->breadcrumbs=array(
	'Kporganigram Ms'=>array('index'),
	$model->organigram_id=>array('view','id'=>$model->organigram_id),
	'Update',
);

?>
<div class="white-container">
	<legend class="rim2">Ubah Organigram</legend>

	<?php $this->widget('bootstrap.widgets.BootAlert'); ?>

	<?php echo $this->renderPartial($this->path_view.'_form',array('model'=>$model)); ?>

	<?php $this->renderPartial($this->path_view.'_tabMenu',array()); ?>
	<?php $this->renderPartial($this->path_view.'_jsFunctions',array()); ?>
	<div>
		<iframe id="frame" src="" width='100%' frameborder="0" style="overflow-y:scroll" ></iframe>
	<div>
</div>
