<?php
$this->breadcrumbs=array(
	'Kpharilibur Ms'=>array('index'),
	$model->harilibur_id,
);
?>
<div class="white-container">
	<legend class="rim2">Lihat <b>Hari Libur</b></legend>
	<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
		<div class="row-fluid">
		<div class="span12">
		<?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
				'data'=>$model,
				'attributes'=>array(
					array(
						'name'=>'tglharilibur',
						'type'=>'raw',
						'value'=>  MyFormatter::formatDateTimeForUser($model->tglharilibur),
					),
				'namaharilibur',
					array(
						'name'=>'harilibur_aktif',
						'type'=>'raw',
						'value'=>(($model->harilibur_aktif) ? "Aktif" : "Tidak Aktif"),
					),
				),
		)); ?>
		</div>
	</div>
	<div class="row-fluid">
		<div class="form-actions">
		<?php echo CHtml::link(Yii::t('mds','{icon} Ubah',array('{icon}'=>'<i class="icon-pencil icon-white"></i>')),$this->createUrl('update',array('id'=>$model->harilibur_id,'modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
		<?php echo CHtml::link(Yii::t('mds','{icon} Pengaturan Hari Libur',array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),$this->createUrl('admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
		<?php $this->widget('UserTips',array('content'=>''));?>
		</div>
	</div>
</div>
