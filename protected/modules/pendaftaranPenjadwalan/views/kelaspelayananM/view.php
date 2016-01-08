<?php
$this->breadcrumbs=array(
	'Ppkelaspelayanan Ms'=>array('index'),
	$model->kelaspelayanan_id,
);

$this->widget('bootstrap.widgets.BootAlert'); ?>

<?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'kelaspelayanan_id',
		'jeniskelas.jeniskelas_nama',
		'kelaspelayanan_nama',
		'kelaspelayanan_namalainnya',
		//'kelaspelayanan_aktif',
                array(
                     'label'=>'Ruangan',
                     'type'=>'raw',
                     'value'=>$this->renderPartial('_ruangan',array('kelaspelayanan_id'=>$model->kelaspelayanan_id),true),
                 ),
                array(
                    'name'=>'kelaspelayanan_aktif',
                    'type'=>'raw',
                    'value'=>(($model->kelaspelayanan_aktif == 1) ? Yii::t('mds', 'Yes') : Yii::t('mds', 'No')),
                ),
	),
)); ?>

<div class="row-fluid">
    <div class="form-actions">
    <?php echo CHtml::link(Yii::t('mds','{icon} Ubah',array('{icon}'=>'<i class="icon-pencil icon-white"></i>')),$this->createUrl($this->id.'/update&id='.$model->kelaspelayanan_id,array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
    <?php echo CHtml::link(Yii::t('mds','{icon} Pengaturan Kelas Pelayanan',array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),$this->createUrl($this->id.'/admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
    <?php $this->widget('UserTips',array('type'=>'view'));?>
    </div>
</div>