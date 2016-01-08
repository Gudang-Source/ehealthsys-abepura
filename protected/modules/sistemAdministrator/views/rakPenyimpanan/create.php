<?php
$this->breadcrumbs=array(
	'Sarakpenyimpanan Ms'=>array('index'),
	'Create',
);
?>
<fieldset class="box">
    <legend class="rim">Tambah Rak Penyimpanan</legend>
    <?php $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php echo $this->renderPartial($this->path_view.'_form', array('model'=>$model)); ?>
</fieldset>