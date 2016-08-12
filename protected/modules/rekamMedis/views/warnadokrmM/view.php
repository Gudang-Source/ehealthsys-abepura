<?php
$this->breadcrumbs=array(
	'Warnadokrm Ms'=>array('index'),
	$model->warnadokrm_id,
);
?>
<fieldset class="box">
	<legend class="rim">Lihat <b>Warna Dokumen</b></legend>
	<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
		<div class="row-fluid">
		<div class="span6">
		<?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
				'data'=>$model,
				'attributes'=>array(
					'warnadokrm_id',
				'warnadokrm_namawarna',
				'warnadokrm_kodewarna',
				//'warnadokrm_fungsi',
				//'warnadokrm_aktif',
				),
		)); ?>
		</div>
		<div class="span6">
			<?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
				'data'=>$model,
				'attributes'=>array(
					//'warnadokrm_id',
				//'warnadokrm_namawarna',
				//'warnadokrm_kodewarna',
				'warnadokrm_fungsi',
				'warnadokrm_aktif',
				),
		)); ?>
		</div>
	</div>
	<div class="row-fluid">
		<div class="form-actions">
		<?php echo CHtml::link(Yii::t('mds','{icon} Ubah',array('{icon}'=>'<i class="icon-pencil icon-white"></i>')),$this->createUrl('update',array('id'=>$model->warnadokrm_id,'modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
		<?php echo CHtml::link(Yii::t('mds','{icon} Pengaturan Warna Dokumen',array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),$this->createUrl('admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
		<?php $this->widget('UserTips',array('type'=>'view'));?>
		</div>
	</div>
</fieldset>
