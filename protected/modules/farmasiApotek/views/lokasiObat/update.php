<?php
$this->breadcrumbs=array(
	'Falokasiobat Ms'=>array('index'),
	$model->lokasiobat_id=>array('view','id'=>$model->lokasiobat_id),
	'Update',
);

?>
<fieldset class="box">
    <legend class="rim">Ubah Lokasi Obat</legend>
    <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
    <?php echo $this->renderPartial('_form',array('model'=>$model)); ?>
</fieldset>