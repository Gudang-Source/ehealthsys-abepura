<?php
$this->breadcrumbs=array(
	'Sumber Potongan'=>array('admin'),
	$model->namapotongan,
	'Pembaharuan',
);

	$this->menu=array(
	array('label'=>'List Sumber Potongan','url'=>array('admin')),
	array('label'=>'Buat Baru Sumber Potongan','url'=>array('create')),
	array('label'=>'View Sumber Potongan','url'=>array('view','id'=>$model->potongansumber_id)),
	array('label'=>'Kelola Sumber Potongan','url'=>array('admin')),
	);
	?>

<div class="col-md-12">
	<div class="panel panel-primary" data-collapsed="0">
		<div class="panel-heading">
		<div class="panel-title"> Pembaharuan Sumber Potongan <?php echo $model->namapotongan; ?></div>
		</div>
		<div class="panel-body">
			<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>		</div>
	</div>
</div>