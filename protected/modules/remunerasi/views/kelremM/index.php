<?php
$this->breadcrumbs=array(
	'Kelrem Ms',
);

$this->menu=array(
	array('label'=>'Create KelremM', 'url'=>array('create')),
	array('label'=>'Manage KelremM', 'url'=>array('admin')),
);
?>

<h1>Kelrem Ms</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
