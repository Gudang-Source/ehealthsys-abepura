<?php
$this->breadcrumbs=array(
	'Ppruangan Ms'=>array('index'),
	$model->ruangan_id,
);

$this->widget('bootstrap.widgets.BootAlert'); ?>

<?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'ruangan_id',
		
		'ruangan_nama',
		'ruangan_namalainnya',
		array(
                     'label'=>'Ruangan',
                     'type'=>'raw',
                     'value'=>$this->renderPartial('_kelaspelayanan',array('ruangan_id'=>$model->ruangan_id),true),
                 ), 
	),
)); ?>

<div class="row-fluid">
    <div class="form-actions">
    <?php echo CHtml::link(Yii::t('mds','{icon} Ubah',array('{icon}'=>'<i class="icon-pencil icon-white"></i>')),$this->createUrl($this->id.'/update&id='.$model->ruangan_id,array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
    <?php echo CHtml::link(Yii::t('mds','{icon} Pengaturan Kelas Ruangan',array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),$this->createUrl($this->id.'/admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
    <?php $this->widget('UserTips',array('type'=>'view'));?>
    </div>
</div>