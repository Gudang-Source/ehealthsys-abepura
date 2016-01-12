<?php
$this->breadcrumbs=array(
	'Sapemeriksaanalatrad Ms'=>array('index'),
	$model->pemeriksaanalatrad_id=>array('view','id'=>$model->pemeriksaanalatrad_id),
	'Update',
);

?>
<fieldset class="box">
	<legend class="rim">Ubah Alat Radiologi</legend>
	<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
	<?php echo $this->renderPartial($this->path_view.'_form',array('model'=>$model)); ?></div>
</fieldset>