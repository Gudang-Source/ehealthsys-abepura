<?php
$this->breadcrumbs=array(
	'Ppgolonganumur Ms'=>array('index'),
	$model->golonganumur_id,
);

$this->widget('bootstrap.widgets.BootAlert'); ?>

<?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'golonganumur_id',
		'golonganumur_nama',
		'golonganumur_namalainnya',
		'golonganumur_minimal',
		'golonganumur_maksimal',
                array(
                    'name'=>'gologanumur_aktif',
                    'type'=>'raw',
                    'value'=>(($model->golonganumur_aktif == 1) ? Yii::t('mds', 'Yes') : Yii::t('mds', 'No'))
                )
	),
)); ?>

<div class="row-fluid">
    <div class="form-actions">
    <?php echo CHtml::link(Yii::t('mds','{icon} Ubah',array('{icon}'=>'<i class="icon-pencil icon-white"></i>')),$this->createUrl($this->id.'/update&id='.$model->golonganumur_id,array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
    <?php echo CHtml::link(Yii::t('mds','{icon} Pengaturan Golongan Umur',array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),$this->createUrl($this->id.'/admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
    <?php $this->widget('UserTips',array('type'=>'view'));?>
    </div>
</div>