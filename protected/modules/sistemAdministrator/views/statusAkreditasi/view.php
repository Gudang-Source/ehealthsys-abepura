<?php
$this->breadcrumbs=array(
	'Gfatc Ms'=>array('index'),
	$model->lookup_id,
);
?>
<legend class="rim">Lihat Status Akreditasi</legend>
<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
<div class="row-fluid">
    <div class="span6">
    <?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
			'data'=>$model,
			'attributes'=>array(
				'lookup_name',
				'lookup_value',
				'lookup_urutan',
			),
    )); ?>
    </div>
</div>
<div class="row-fluid">
    <div class="form-actions">
    <?php echo CHtml::link(Yii::t('mds','{icon} Ubah',array('{icon}'=>'<i class="icon-pencil icon-white"></i>')),$this->createUrl('update',array('id'=>$model->lookup_id,'modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
    <?php echo CHtml::link(Yii::t('mds','{icon} Pengaturan Status Akreditasi',array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),$this->createUrl('admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
    <?php $this->widget('UserTips',array('content'=>''));?>
    </div>
</div>
