<?php
$this->breadcrumbs=array(
	'Pegawai'=>array('admin'),
	$model->nama_pegawai,
	'Pembaharuan',
);

	$this->menu=array(
	array('label'=>'List PegawaiM','url'=>array('index')),
	array('label'=>'Buat Baru PegawaiM','url'=>array('create')),
	array('label'=>'View PegawaiM','url'=>array('view','id'=>$model->pegawai_id)),
	array('label'=>'Kelola PegawaiM','url'=>array('admin')),
	);
	?>

<div class="col-md-12">
	<div class="panel panel-primary" data-collapsed="0">
		<div class="panel-heading">
		<div class="panel-title"> Pembaharuan Pegawai No.<?php echo $model->pegawai_id; ?></div>
		</div>
		<div class="panel-body">
			<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>		</div>
	</div>
</div>