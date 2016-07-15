<fieldset class = "box">
<legend class = "rim">Lihat Propinsi</legend>
<?php
$this->breadcrumbs=array(
	'Pppropinsi Ms'=>array('index'),
	$model->propinsi_id,
);

$this->widget('bootstrap.widgets.BootAlert'); ?>

<?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'propinsi_id',
		'propinsi_nama',
		'propinsi_namalainnya',
                'latitude',
                'longitude',
		//'propinsi_aktif',
                array(
                    'name'=>'propinsi_aktif',
                    'type'=>'raw',
                    'value'=>(($model->propinsi_aktif == 1) ? Yii::t('mds', 'Yes') : Yii::t('mds', 'No'))
                ),
	),
)); ?>

<div class="row-fluid">
    <div class="form-actions">
    <?php echo CHtml::link(Yii::t('mds','{icon} Ubah',array('{icon}'=>'<i class="icon-pencil icon-white"></i>')),$this->createUrl($this->id.'/update&id='.$model->propinsi_id,array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
    <?php echo CHtml::link(Yii::t('mds','{icon} Pengaturan Propinsi',array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),$this->createUrl($this->id.'/admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
    <?php $this->widget('UserTips',array('type'=>'view'));?>
    </div>
</div>
</fieldset>