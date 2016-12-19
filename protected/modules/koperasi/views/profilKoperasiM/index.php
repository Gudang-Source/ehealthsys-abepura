<?php
$this->breadcrumbs=array(
	'Adprofil Ss',
);

$this->menu=array(
array('label'=>'Create ADProfilS','url'=>array('create')),
array('label'=>'Manage ADProfilS','url'=>array('admin')),
);
?>

<h1>Adprofil Ss</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
'dataProvider'=>$dataProvider,
'itemView'=>'_view',
)); ?>
