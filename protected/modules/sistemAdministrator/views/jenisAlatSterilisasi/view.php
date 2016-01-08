<?php
$this->breadcrumbs=array(
	'Sajenisalatsterilisasi Ms'=>array('index'),
	$model->jenisalatmedis_id,
);
?>
<div class="white-container">
	<legend class="rim2">Lihat <b>Jenis Alat Sterilisasi</b></legend>
	<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
		<div class="row-fluid">
		<div class="span6">
		<?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
				'data'=>$model,
				'attributes'=>array(
					'jenisalatmedis_id',
				'jenisalatmedis_nama',
				//'jenisalatmedis_namalain',
				//'jenisalatmedis_aktif',
				),
		)); ?>
		</div>
		<div class="span6">
			<?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
				'data'=>$model,
				'attributes'=>array(
					//'jenisalatmedis_id',
				'jenisalatmedis_nama',
				'jenisalatmedis_namalain',
				'jenisalatmedis_aktif',
				),
		)); ?>
		</div>
	</div>
	<div class="row-fluid">
		<div class="form-actions">
		<?php echo CHtml::link(Yii::t('mds','{icon} Ubah',array('{icon}'=>'<i class="icon-pencil icon-white"></i>')),$this->createUrl('update',array('id'=>$model->jenisalatmedis_id,'modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
		<?php echo CHtml::link(Yii::t('mds','{icon} Pengaturan Jenis Alat Sterilisasi',array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),$this->createUrl('admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
		<?php $this->widget('UserTips',array('content'=>''));?>
		</div>
	</div>
</div>
