<fieldset class = "box">
    <legend class = "rim">Lihat Kabupaten</legend>
<?php
$this->breadcrumbs=array(
	'Ppkabupaten Ms'=>array('index'),
	$model->kabupaten_id,
);

$this->widget('bootstrap.widgets.BootAlert'); ?>

<?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'kabupaten_id',
		'propinsi.propinsi_nama',
		'kabupaten_nama',
		'kabupaten_namalainnya',
                'longitude',
                'latitude',
		//'kabupaten_aktif',
                array(
                    'name'=>'kabupaten_aktif',
                    'type'=>'raw',
                    'value'=>(($model->kabupaten_aktif == 1) ? Yii::t('mds', 'Yes') : Yii::t('mds', 'No')),
                )
	),
)); ?>

<div class="row-fluid">
    <div class="form-actions">
    <?php echo CHtml::link(Yii::t('mds','{icon} Ubah',array('{icon}'=>'<i class="icon-pencil icon-white"></i>')),$this->createUrl($this->id.'/update&id='.$model->kabupaten_id,array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
    <?php echo CHtml::link(Yii::t('mds','{icon} Pengaturan Kabupaten',array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),$this->createUrl($this->id.'/admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
    <?php $this->widget('UserTips',array('type'=>'view'));?>
    </div>
</div>
</fieldset>