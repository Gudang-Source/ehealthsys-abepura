<?php
$this->breadcrumbs=array(
	'Sumber Potongan'=>array('admin'),
	$model->namapotongan,
);

$this->menu=array(
array('label'=>'List Sumber Potongan ','url'=>array('admin')),
array('label'=>'Buat Baru Sumber Potongan','url'=>array('create')),
array('label'=>'Update Sumber Potongan','url'=>array('update','id'=>$model->potongansumber_id)),
array('label'=>'Hapus Sumber Potongan','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->potongansumber_id),'confirm'=>'Are you sure you want to delete this item?')),
array('label'=>'Kelola Sumber Potongan','url'=>array('admin')),
);
?>

<div class="col-md-12">
	<div class="panel panel-primary" data-collapsed="0">
		<div class="panel-body">
			<?php $this->widget('bootstrap.widgets.TbDetailView',array(
'data'=>$model,
'attributes'=>array(
		'potongansumber_id',
		'namapotongan',
		'namapotonganlainnya',
		//'potongansumber_aktif',
						array(               // related city displayed as a link
                                'name'=>'potongansumber_aktif',
                                'type'=>'raw',
                                'value'=>(($model->potongansumber_aktif==1)? "Ya" : "Tidak Aktif"),
                            ),
),
)); ?>
		</div>
		<div class="panel-footer">
			<?php echo Chtml::link('Kembali',$this->createUrl('/admin/PotongansumberM/admin'), array('class' => 'btn btn-link')); ?>
		</div>
	</div>
</div>