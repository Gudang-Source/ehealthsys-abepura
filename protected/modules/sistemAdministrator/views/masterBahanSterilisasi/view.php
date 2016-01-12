<?php
$this->breadcrumbs=array(
	'Sabahansterilisasi Ms'=>array('index'),
	$model->bahansterilisasi_id,
);
?>
<div class="white-container">
	<legend class="rim2">Lihat <b>Master Bahan Sterilisasi</b></legend>
	<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
		<div class="row-fluid">
		<div class="span6">
		<?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
				'data'=>$model,
				'attributes'=>array(
					'bahansterilisasi_id',
				'bahansterilisasi_nama',
				'bahansterilisasi_namalain',
				'bahansterilisasi_jumlah',
				//'bahansterilisasi_satuan',
				//'bahansterilisasi_warna',
				//'bahansterilisasi_maksuhu',
				//'bahansterilisasi_aktif',
				),
		)); ?>
		</div>
		<div class="span6">
			<?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
				'data'=>$model,
				'attributes'=>array(
					//'bahansterilisasi_id',
				//'bahansterilisasi_nama',
				//'bahansterilisasi_namalain',
				//'bahansterilisasi_jumlah',
				'bahansterilisasi_satuan',
				'bahansterilisasi_warna',
				'bahansterilisasi_maksuhu',
				'bahansterilisasi_aktif',
				),
		)); ?>
		</div>
	</div>
	<div class="row-fluid">
		<div class="form-actions">
		<?php echo CHtml::link(Yii::t('mds','{icon} Ubah',array('{icon}'=>'<i class="icon-pencil icon-white"></i>')),$this->createUrl('update',array('id'=>$model->bahansterilisasi_id,'modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
		<?php echo CHtml::link(Yii::t('mds','{icon} Pengaturan Master Bahan Sterilisasi',array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),$this->createUrl('admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
		<?php $this->widget('UserTips',array('content'=>''));?>
		</div>
	</div>
</div>
