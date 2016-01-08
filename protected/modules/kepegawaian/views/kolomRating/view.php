<?php
$this->breadcrumbs=array(
	'Kpkolomrating Ms'=>array('index'),
	$model->kolomrating_id,
);
?>
<fieldset class="box">
	<legend class="rim">Lihat Kolom Rating</legend>
	<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
		<div class="row-fluid">
		<div class="span6">
		<?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
				'data'=>$model,
				'attributes'=>array(
					'kolomrating_id',
				'kolomrating_namalevel',
				'kolomrating_point',
				//'kolomrating_uraian',
				//'kolomrating_deskripsi',
				//'kolomrating_aktif',
				),
		)); ?>
		</div>
		<div class="span6">
			<?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
				'data'=>$model,
				'attributes'=>array(
					//'kolomrating_id',
				//'kolomrating_namalevel',
				//'kolomrating_point',
				'kolomrating_uraian',
				'kolomrating_deskripsi',
				'kolomrating_aktif',
				),
		)); ?>
		</div>
	</div>
	<div class="row-fluid">
		<div class="form-actions">
		<?php echo CHtml::link(Yii::t('mds','{icon} Ubah',array('{icon}'=>'<i class="icon-pencil icon-white"></i>')),$this->createUrl('update',array('id'=>$model->kolomrating_id,'modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
		<?php echo CHtml::link(Yii::t('mds','{icon} Pengaturan Kolom Rating',array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),$this->createUrl('admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
		<?php $this->widget('UserTips',array('content'=>''));?>
		</div>
	</div>
</fieldset>
