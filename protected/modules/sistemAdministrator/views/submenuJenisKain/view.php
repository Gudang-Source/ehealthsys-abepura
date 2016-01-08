<?php
$this->breadcrumbs=array(
	'Sabahanlinen Ms'=>array('index'),
	$model->bahanlinen_id,
);
?>
<div class="white-container">
	<legend class="rim2">Lihat <b>Submenu Jenis Kain</b></legend>
	<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
		<div class="row-fluid">
		<div class="span6">
		<?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
				'data'=>$model,
				'attributes'=>array(
				'bahanlinen_id',
				'bahanlinen_nama',
				'bahanlinen_namalain',
				//'suhurekomendasi',
				//'bahanlinen_aktif',
				),
		)); ?>
		</div>
		<div class="span6">
			<?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
				'data'=>$model,
				'attributes'=>array(
					//'bahanlinen_id',
				//'bahanlinen_nama',
				//'bahanlinen_namalain',
				'suhurekomendasi',
				'bahanlinen_aktif',
				),
		)); ?>
		</div>
	</div>
	<div class="row-fluid">
		<div class="form-actions">
		<?php echo CHtml::link(Yii::t('mds','{icon} Ubah',array('{icon}'=>'<i class="icon-pencil icon-white"></i>')),$this->createUrl('update',array('id'=>$model->bahanlinen_id,'modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
		<?php echo CHtml::link(Yii::t('mds','{icon} Pengaturan Submenu Jenis Kain',array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),$this->createUrl('admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
		<?php $this->widget('UserTips',array('content'=>''));?>
		</div>
	</div>
</div>
