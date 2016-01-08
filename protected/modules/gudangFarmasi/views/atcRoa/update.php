<?php
$this->breadcrumbs=array(
	'Gfatc Ms'=>array('index'),
	$model->lookup_id=>array('view','id'=>$model->lookup_id),
	'Update',
);

?>
<fieldset class="box">
    <legend class="rim">Ubah Route of Adm Atc</legend>
    <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
    <?php echo $this->renderPartial('_form',array('model'=>$model)); ?>
</fieldset>