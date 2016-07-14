<fieldset class = "box">
    <legend class = "rim">Lihat Kelurahan</legend>
<?php
$this->breadcrumbs=array(
	'Ppkelurahan Ms'=>array('index'),
	$model->kelurahan_id,
);

$this->widget('bootstrap.widgets.BootAlert'); ?>

<?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'kelurahan_id',
		'kecamatan.kecamatan_nama',
		'kelurahan_nama',
		'kelurahan_namalainnya',
                'latitude',
                'longitude',
		'kode_pos',
		//'kelurahan_aktif',
                array(
                    'name'=>'kelurahan_aktif',
                    'type'=>'raw',
                    'value'=>(($model->kelurahan_aktif) ? Yii::t('mds', 'Yes') : Yii::t('mds', 'No')),
                )
	),
)); ?>

<div class="row-fluid">
    <div class="form-actions">
    <?php echo CHtml::link(Yii::t('mds','{icon} Ubah',array('{icon}'=>'<i class="icon-pencil icon-white"></i>')),$this->createUrl($this->id.'/update&id='.$model->kelurahan_id,array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
    <?php echo CHtml::link(Yii::t('mds','{icon} Pengaturan Kelurahan',array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),$this->createUrl($this->id.'/admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
    <?php $this->widget('UserTips',array('type'=>'view'));?>
    </div>
</div>
</fieldset>