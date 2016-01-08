<?php
$this->breadcrumbs=array(
	'Farakobat Ms'=>array('index'),
	$model->rakobat_id=>array('view','id'=>$model->rakobat_id),
	'Update',
);

?>
<fieldset class='box'>
    <legend class="rim">Ubah Rak Obat</legend>
    <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
    <?php echo $this->renderPartial('_form',array('model'=>$model)); ?>
</fieldset>