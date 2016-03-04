<fieldset class="box">
<?php if (!$this->isFrame) : ?>
<legend class="rim2">Ubah Cara Keluar</legend>
<?php else: ?>
<legend class="rim">Ubah Cara Keluar</legend>
<?php endif; ?>
<?php
$this->breadcrumbs=array(
	'Carakeluar Ms'=>array('index'),
	$model->carakeluar_id=>array('view','id'=>$model->carakeluar_id),
	'Update',
);

?>


<?php $this->widget('bootstrap.widgets.BootAlert'); ?>

<?php echo $this->renderPartial($this->path_view.'_form',array('model'=>$model)); ?>
</fieldset>