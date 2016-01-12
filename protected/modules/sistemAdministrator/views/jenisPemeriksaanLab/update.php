<?php
$this->breadcrumbs=array(
	'Sajenispemeriksaanlab Ms'=>array('index'),
	$model->jenispemeriksaanlab_id=>array('view','id'=>$model->jenispemeriksaanlab_id),
	'Update',
);
?>
<fieldset class="box">
    <legend class="rim">Ubah Jenis Pemeriksaan Lab</legend>
    <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
    <?php echo $this->renderPartial($this->path_view.'_form',array('model'=>$model)); ?>
</fieldset>