<?php
$this->breadcrumbs=array(
	'Gfatc Ms'=>array('index'),
	$model->atc_id=>array('view','id'=>$model->atc_id),
	'Update',
);

?>
<fieldset class="box">
    <legend class="rim">Ubah Atc</legend>

    <?php $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php echo $this->renderPartial('_form',array('model'=>$model)); ?>
</fieldset>