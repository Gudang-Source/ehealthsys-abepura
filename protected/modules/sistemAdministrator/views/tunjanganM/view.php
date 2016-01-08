<?php
$this->breadcrumbs=array(
	'Kptunjangan Ms'=>array('index'),
	$model->tunjangan_id,
);
?>
<div class="white-container">
	<legend class="rim2">Lihat <b>Tunjangan</b></legend>
	<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
		<div class="row-fluid">
		<div class="span6">
		<?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
				'data'=>$model,
				'attributes'=>array(
					array(
						'name'=>'pangkat_id',
						'type'=>'raw',
						'value'=>$model->pangkat->pangkat_nama
					),
					array(
						'name'=>'jabatan_id',
						'type'=>'raw',
						'value'=>$model->jabatan->jabatan_nama
					),
					array(
						'name'=>'komponengaji_id',
						'type'=>'raw',
						'value'=>$model->komponengaji->komponengaji_nama
					),
				),
		)); ?>
		</div>
		<div class="span6">
			<?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
				'data'=>$model,
				'attributes'=>array(
					array(
						'name'=>'nominaltunjangan',
						'type'=>'raw',
						'value'=>  MyFormatter::formatNumberForUser($model->nominaltunjangan),
					),
					array(
						'name'=>'tunjangan_aktif',
						'type'=>'raw',
						'value'=>(($model->tunjangan_aktif) ? "Aktif" : "Tidak Aktif"),
					),
				),
		)); ?>
		</div>
	</div>
	<div class="row-fluid">
		<div class="form-actions">
		<?php echo CHtml::link(Yii::t('mds','{icon} Ubah',array('{icon}'=>'<i class="icon-pencil icon-white"></i>')),$this->createUrl('update',array('id'=>$model->tunjangan_id,'modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
		<?php echo CHtml::link(Yii::t('mds','{icon} Pengaturan Tunjangan',array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),$this->createUrl('admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
		<?php $this->widget('UserTips',array('content'=>''));?>
		</div>
	</div>
</div>
