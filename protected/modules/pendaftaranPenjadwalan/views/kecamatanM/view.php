<?php
$this->breadcrumbs=array(
	'Ppkecamatan Ms'=>array('index'),
	$model->kecamatan_id,
);

$this->widget('bootstrap.widgets.BootAlert'); ?>

<?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'kecamatan_id',
		'kabupaten.kabupaten_nama',
		'kecamatan_nama',
		'kecamatan_namalainnya',
		//'kecamatan_aktif',
                array(
                    'name'=>'kecamatan_aktif',
                    'type'=>'raw',
                    'value'=>(($model->kecamatan_aktif == 1) ? Yii::t('mds', 'Yes') : Yii::t('mds', 'No')) 
                )
	),
)); ?>

<div class="row-fluid">
    <div class="form-actions">
    <?php echo CHtml::link(Yii::t('mds','{icon} Ubah',array('{icon}'=>'<i class="icon-pencil icon-white"></i>')),$this->createUrl($this->id.'/update&id='.$model->kecamatan_id,array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
    <?php echo CHtml::link(Yii::t('mds','{icon} Pengaturan Kecamatan',array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),$this->createUrl($this->id.'/admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
    <?php $this->widget('UserTips',array('type'=>'view'));?>
    </div>
</div>