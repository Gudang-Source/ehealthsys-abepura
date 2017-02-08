<?php
$this->breadcrumbs=array(
	'Saalatmedis Ms'=>array('index'),
	$model->alatmedis_id,
);
?>
<div class="white-container">
	<legend class="rim2">Lihat <b>SAAlatmedisM</b></legend>
	<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
		<div class="row-fluid">
		<div class="span6">
		<?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
				'data'=>$model,
				'attributes'=>array(
					'alatmedis_id',
				'instalasi_id',
				'jenisalatmedis_id',
				'alatmedis_noaset',
				'alatmedis_nama',
				//'alatmedis_namalain',
				//'alatmedis_aktif',
				//'alatmedis_kode',
				//'alatmedis_format',
				),
		)); ?>
		</div>
		<div class="span6">
			<?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
				'data'=>$model,
				'attributes'=>array(
					//'alatmedis_id',
				//'instalasi_id',
				//'jenisalatmedis_id',
				//'alatmedis_noaset',
				//'alatmedis_nama',
				'alatmedis_namalain',
				'alatmedis_aktif',
				'alatmedis_kode',
				'alatmedis_format',
				),
		)); ?>
		</div>
	</div>
	<div class="row-fluid">
		<div class="form-actions">
		<?php echo CHtml::link(Yii::t('mds','{icon} Ubah',array('{icon}'=>'<i class="icon-pencil icon-white"></i>')),$this->createUrl('update',array('id'=>$model->alatmedis_id,'modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
		<?php echo CHtml::link(Yii::t('mds','{icon} Pengaturan Alat Medis',array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),$this->createUrl('admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
		<?php $this->widget('UserTips',array('type'=>'view')); ?>
		</div>
	</div>
</div>
