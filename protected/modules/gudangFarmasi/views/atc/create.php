<?php
$this->breadcrumbs=array(
	'Gfatc Ms'=>array('index'),
	'Create',
);
?>
<fieldset class="box">
    <legend class="rim">Tambah Atc</legend>
    <?php $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
</fieldset>