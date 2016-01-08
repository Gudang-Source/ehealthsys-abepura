<?php
$this->breadcrumbs=array(
	'Ppcarabayar Ms'=>array('index'),
	$model->carabayar_id,
);

$this->widget('bootstrap.widgets.BootAlert'); ?>

<?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'carabayar_id',
		'carabayar_nama',
		'carabayar_namalainnya',
		'metode_pembayaran',
		
		'carabayar_loket',
		'carabayar_singkatan',
		'carabayar_nourut', 
                array(
                    'name'=>'carabayar_aktif',
                    'type'=>'raw',
                    'value'=>(($model->carabayar_aktif == 1) ? Yii::t('mds', 'Yes') : Yii::t('mds', 'No')),
                ),
	),
)); ?>

<div class="row-fluid">
    <div class="form-actions">
    <?php echo CHtml::link(Yii::t('mds','{icon} Ubah',array('{icon}'=>'<i class="icon-pencil icon-white"></i>')),$this->createUrl($this->id.'/update&id='.$model->carabayar_id,array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
    <?php echo CHtml::link(Yii::t('mds','{icon} Pengaturan Cara Bayar',array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),$this->createUrl($this->id.'/admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
    <?php $this->widget('UserTips',array('type'=>'view'));?>
    </div>
</div>