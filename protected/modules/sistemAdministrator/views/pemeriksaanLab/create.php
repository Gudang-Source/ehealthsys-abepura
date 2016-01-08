<?php
$this->breadcrumbs=array(
	'Sapemeriksaanlab Ms'=>array('index'),
	'Create',
);
?>
<fieldset class="box">
    <legend class="rim">Tambah Pemeriksaan Lab</legend>
    <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
    <?php echo $this->renderPartial($this->path_view.'_form', array('model'=>$model)); ?>
</fieldset>