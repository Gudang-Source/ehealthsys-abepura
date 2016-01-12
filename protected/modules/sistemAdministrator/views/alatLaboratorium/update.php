<?php
$this->breadcrumbs=array(
	'Sapemeriksaanlabalat Ms'=>array('index'),
	$model->pemeriksaanlabalat_id=>array('view','id'=>$model->pemeriksaanlabalat_id),
	'Update',
);

?>
<fieldset class="box">
	<legend class="rim">Ubah Master Alat Laboratorium</legend>
	<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
	<?php echo $this->renderPartial($this->path_view.'_form',array('model'=>$model)); ?>
</fieldset>
