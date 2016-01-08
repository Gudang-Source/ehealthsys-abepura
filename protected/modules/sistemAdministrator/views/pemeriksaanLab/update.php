<?php
$this->breadcrumbs=array(
	'Sapemeriksaanlab Ms'=>array('index'),
	$model->pemeriksaanlab_id=>array('view','id'=>$model->pemeriksaanlab_id),
	'Update',
);

?>
<fieldset class="box">
    <legend class="rim">Ubah Pemeriksaan Lab</legend>
    <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
    <?php echo $this->renderPartial($this->path_view.'_form',array('model'=>$model)); ?>
</fieldset>