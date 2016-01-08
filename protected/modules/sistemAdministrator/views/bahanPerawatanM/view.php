<?php
$this->breadcrumbs=array(
	'Sabahanperawatan Ms'=>array('index'),
	$model->bahanperawatan_id,
);
?>
<div class="white-container">
	<legend class="rim2">Lihat <b>SABahanperawatanM</b></legend>
	<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
		<div class="row-fluid">
		<div class="span6">
		<?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
				'data'=>$model,
				'attributes'=>array(
					'bahanperawatan_id',
				'bahanperawatan_jenis',
				'bahanperawatan_nama',
				//'bahanperawatan_namalain',
				//'bahanperawatan_aktif',
				),
		)); ?>
		</div>
		<div class="span6">
			<?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
				'data'=>$model,
				'attributes'=>array(
					//'bahanperawatan_id',
				//'bahanperawatan_jenis',
				//'bahanperawatan_nama',
				'bahanperawatan_namalain',
				'bahanperawatan_aktif',
				),
		)); ?>
		</div>
	</div>
	<div class="row-fluid">
		<div class="form-actions">
		<?php echo CHtml::link(Yii::t('mds','{icon} Ubah',array('{icon}'=>'<i class="icon-pencil icon-white"></i>')),$this->createUrl('update',array('id'=>$model->bahanperawatan_id,'modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
		<?php echo CHtml::link(Yii::t('mds','{icon} Pengaturan Bahan Perawatan',array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),$this->createUrl('admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
		<?php $this->widget('UserTips',array('content'=>''));?>
		</div>
	</div>
</div>
