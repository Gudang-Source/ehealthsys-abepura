<?php
$this->breadcrumbs=array(
	'Salokasipenyimpanan Ms'=>array('index'),
	$model->lokasipenyimpanan_id=>array('view','id'=>$model->lokasipenyimpanan_id),
	'Update',
);

?>
<fieldset class="box">
    <legend class="rim">Ubah Lokasi Penyimpanan</legend>

    <?php $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php echo $this->renderPartial($this->path_view.'_form',array('model'=>$model)); ?></div>
</fieldset>