<?php
$this->breadcrumbs=array(
	'Sumber Potongan',
);

$this->menu=array(
array('label'=>'Create Sumber Potongan','url'=>array('create')),
array('label'=>'Manage Sumber Potongan','url'=>array('admin')),
);
?>

<h1>Sumber Potongan</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
'dataProvider'=>$dataProvider,
'itemView'=>'_view',
)); ?>
