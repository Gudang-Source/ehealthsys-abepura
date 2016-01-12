<?php
$this->breadcrumbs=array(
	'Sarakpenyimpanan Ms'=>array('index'),
	$model->rakpenyimpanan_id=>array('view','id'=>$model->rakpenyimpanan_id),
	'Update',
);

?>
<fieldset class="box">
    <legend class="rim">Ubah Rak Penyimpanan</legend>

    <?php $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php echo $this->renderPartial($this->path_view.'_form',array('model'=>$model)); ?></div>
</fieldset>