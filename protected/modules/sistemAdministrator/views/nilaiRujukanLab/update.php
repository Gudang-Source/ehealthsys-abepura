<?php
$this->breadcrumbs=array(
	'Sanilairujukan Ms'=>array('index'),
	$model->nilairujukan_id=>array('view','id'=>$model->nilairujukan_id),
	'Update',
);

?>
<fieldset class="box">
    <legend class="rim">Ubah Nilai Rujukan (Referensi</legend>
    <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
    <?php echo $this->renderPartial($this->path_view.'_form',array('model'=>$model)); ?>
</fieldset>