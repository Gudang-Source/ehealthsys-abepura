<?php
$this->breadcrumbs=array(
	'Sashift Ms'=>array('index'),
	$model->shift_id=>array('view','id'=>$model->shift_id),
	'Update',
);

?>
<fieldset class="box row-fluid">
    <legend class="rim">Pengaturan Shift</legend>
<!--<div class="white-container">
	<legend class="rim2">Ubah Shift</legend>-->

	<?php $this->widget('bootstrap.widgets.BootAlert'); ?>

	<?php echo $this->renderPartial($this->path_view.'_form',array('model'=>$model)); ?>
<!--</div>-->
</fieldset>

