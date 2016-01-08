<?php
$this->breadcrumbs=array(
	'Pppekerjaan Ms'=>array('index'),
	$model->pekerjaan_id,
);

$this->widget('bootstrap.widgets.BootAlert'); ?>

<?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'pekerjaan_id',
		'pekerjaan_nama',
		'pekerjaan_namalainnya',
		 array(               // related city displayed as a link
                    'name'=>'pekerjaan_aktif',
                    'type'=>'raw',
                    'value'=>(($model->pekerjaan_aktif==1)? Yii::t('mds','Yes') : Yii::t('mds','No')),
                ),
	),
)); ?>

<div class="row-fluid">
    <div class="form-actions">
    <?php echo CHtml::link(Yii::t('mds','{icon} Ubah',array('{icon}'=>'<i class="icon-pencil icon-white"></i>')),$this->createUrl($this->id.'/update&id='.$model->pekerjaan_id,array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
    <?php echo CHtml::link(Yii::t('mds','{icon} Pengaturan Pekerjaan',array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),$this->createUrl($this->id.'/admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
    <?php $this->widget('UserTips',array('type'=>'view'));?>
    </div>
</div>