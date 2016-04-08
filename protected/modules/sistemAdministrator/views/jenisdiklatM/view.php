<?php
$this->breadcrumbs=array(
	'Kpjenisdiklat Ms'=>array('index'),
	$model->jenisdiklat_id,
);
?>
<div class="white-container">
	<legend class="rim2">Lihat <b>Jenis Diklat</b></legend>
	<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
		<div class="row-fluid">
		<div class="span6">
		<?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
				'data'=>$model,
				'attributes'=>array(
                                    'jenisdiklat_id',
                                    'jenisdiklat_nama',
                                    'jenisdiklat_deskripsi',
				),
		)); ?>
		</div>
		<div class="span6">
			<?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
				'data'=>$model,
				'attributes'=>array(
				'jenisdiklat_namalainnya',
				array(
					'name'=>'jenisdiklat_aktif',
					'type'=>'raw',
					'filter'=>false,
					'value'=>(($model->jenisdiklat_aktif)?"Aktif":"Tidak Aktif"),
				),
				),
		)); ?>
		</div>
	</div>
	<div class="row-fluid">
		<div class="form-actions">
		<?php echo CHtml::link(Yii::t('mds','{icon} Ubah',array('{icon}'=>'<i class="icon-pencil icon-white"></i>')),$this->createUrl('update',array('id'=>$model->jenisdiklat_id,'modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
		<?php echo CHtml::link(Yii::t('mds','{icon} Pengaturan Jenis Diklat',array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),$this->createUrl('admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
		<?php $this->widget('UserTips',array('content'=>''));?>
		</div>
	</div>
</div>
