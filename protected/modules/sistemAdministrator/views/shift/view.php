<?php
$this->breadcrumbs=array(
	'Sashift Ms'=>array('index'),
	$model->shift_id,
);
?>
<!--<div class="white-container">
	<legend class="rim2">Lihat <b>Shift</b></legend>-->
<fieldset class="box row-fluid">
    <legend class="rim">Lihat Shift</legend>
	<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
		<div class="row-fluid">
		<div class="span6">
		<?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
				'data'=>$model,
				'attributes'=>array(
					'shift_id',
				'shift_nama',
				'shift_namalainnya',
				'shift_jamawal',
				//'shift_jamakhir',
				//'shift_aktif',
				//'shift_kode',
				//'shift_urutan',
				),
		)); ?>
		</div>
		<div class="span6">
			<?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
				'data'=>$model,
				'attributes'=>array(
					//'shift_id',
				//'shift_nama',
				//'shift_namalainnya',
				//'shift_jamawal',
				'shift_jamakhir',
				'shift_aktif',
				'shift_kode',
				'shift_urutan',
				),
		)); ?>
		</div>
	</div>
	<div class="row-fluid">
		<div class="form-actions">
		<?php echo CHtml::link(Yii::t('mds','{icon} Ubah',array('{icon}'=>'<i class="icon-pencil icon-white"></i>')),$this->createUrl('update',array('id'=>$model->shift_id,'modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
		<?php echo CHtml::link(Yii::t('mds','{icon} Pengaturan Shift',array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),$this->createUrl('admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
		<?php $this->widget('UserTips',array('type'=>'view'));?>
		</div>
	</div>
<!--</div>-->
</fieldset>
