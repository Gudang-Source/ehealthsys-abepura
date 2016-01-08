<?php
$this->breadcrumbs=array(
	'Gupesanbarang Ts'=>array('index'),
	'Create',
);

$this->widget('bootstrap.widgets.BootAlert'); ?>

<?php echo $this->renderPartial('gudangUmum.views.pesanbarangT._form', array('model'=>$model, 'modDetail'=>$modDetail)); ?>