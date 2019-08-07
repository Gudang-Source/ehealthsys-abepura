<?php
$this->breadcrumbs=array(
	'Pegawai',
);

$this->menu=array(
array('label'=>'Create PegawaiM','url'=>array('create')),
array('label'=>'Manage PegawaiM','url'=>array('admin')),
);
?>

<h1>Pegawai</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
'dataProvider'=>$dataProvider,
'itemView'=>'_view',
)); ?>
