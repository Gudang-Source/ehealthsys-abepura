<?php
$this->breadcrumbs=array(
	'Profil'=>array('/admin/ProfilS/'),
	'Pembaharuan',
);
	$this->menu=array(
	array('label'=>'List Profil','url'=>array('index')),
	array('label'=>'Buat Baru Profil','url'=>array('create')),
	array('label'=>'View Profil','url'=>array('view','id'=>$model->profilperusahaan_id)),
	array('label'=>'Kelola Profil','url'=>array('admin')),
	);
	?>

<div class="col-md-12">
	<div class="panel panel-primary" data-collapsed="0">
		<div class="panel-heading">
			<div class="panel-title"> Pembaharuan Profil Id <?php echo $model->profilperusahaan_id; ?> </div>  
		</div>
		<div class="panel-body">
			<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>		</div>
	</div>
</div>