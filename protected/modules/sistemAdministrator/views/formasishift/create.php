<?php
$this->breadcrumbs=array(
	'Saformasishift Ms'=>array('index'),
	'Create',
);
?>
<!--<div class="white-container">
	<legend class="rim2">Tambah <b>Formasi Shift</b></legend>-->
<fieldset class="box row-fluid">
    <legend class="rim">Tambah Formasi Shift</legend>
	<?php $this->widget('bootstrap.widgets.BootAlert'); ?>

	<?php echo $this->renderPartial($this->path_view.'_formCreate', array('model'=>$model,'modInstalasi'=>$modInstalasi, 'instalasiTujuans'=>$instalasiTujuans, 'ruanganTujuans'=>$ruanganTujuans)); ?>
	
<!--</div>-->
</fieldset>

<?php echo $this->renderPartial($this->path_view.'_jsFunctions', array('model'=>$model)); ?>