<?php
$this->breadcrumbs=array(
	'Ppcaramasuk Ms'=>array('index'),
	$model->caramasuk_id,
);

$this->widget('bootstrap.widgets.BootAlert'); ?>

<?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'caramasuk_id',
		'caramasuk_nama',
		'caramasuk_namalainnya',
                array(
                    'name'=>'caramasuk_aktif',
                    'type'=>'raw',
                    'value'=>(($model->caramasuk_aktif == 1) ? Yii::t('mds', 'Yes') : Yii::t('mds', 'No')),
                ),
	),
)); ?>

<div class="row-fluid">
    <div class="form-actions">
    <?php echo CHtml::link(Yii::t('mds','{icon} Ubah',array('{icon}'=>'<i class="icon-pencil icon-white"></i>')),$this->createUrl($this->id.'/update&id='.$model->caramasuk_id,array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
    <?php echo CHtml::link(Yii::t('mds','{icon} Pengaturan Cara Masuk',array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),$this->createUrl($this->id.'/admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
    <?php $this->widget('UserTips',array('type'=>'view'));?>
    </div>
</div>