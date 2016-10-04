<?php
$this->breadcrumbs=array(
	'Pegawai'=>array('admin'),
	'Tambah Baru',
);

$this->menu=array(
array('label'=>'List PegawaiM','url'=>array('index')),
array('label'=>'Manage PegawaiM','url'=>array('admin')),
);
?>
<style type="text/css">
	.input-group-addon{
		cursor: pointer;	
	}
</style>
<div class="col-md-12">
	<div class="panel panel-primary" data-collapsed="0">
		<div class="panel-heading">
			<div class="panel-title">Pendataan Pegawai</div>  
		</div>
		<div class="panel-body">
			<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>		</div>
	</div>
</div>


