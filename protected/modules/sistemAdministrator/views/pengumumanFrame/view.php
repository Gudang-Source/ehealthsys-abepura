<?php
$this->breadcrumbs=array(
	'Sapengumumen'=>array('index'),
	$model->pengumuman_id,
);
?>
<!-- <legend class="rim2">Lihat Pengumuman</legend> -->
<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
<div class="row-fluid">
    <div class="span6">
    <?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
            'data'=>$model,
            'attributes'=>array(
        		'pengumuman_id',
		'judul',
		array(
            'name'=>'isi',
            'type'=>'raw',
        ),
		'status_publish',
		'create_loginpemakai_id',
		//'create_time',
		//'update_loginpemakai_id',
		//'update_time',
		//'publish_loginpemakai_id',
            ),
    )); ?>
    </div>
    <div class="span6">
        <?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
            'data'=>$model,
            'attributes'=>array(
        		//'pengumuman_id',
		//'judul',
		//'isi',
		//'status_publish',
		//'create_loginpemakai_id',
		'create_time',
		'update_loginpemakai_id',
		'update_time',
		'publish_loginpemakai_id',
            ),
    )); ?>
    </div>
</div>
<div class="row-fluid">
    <div class="form-actions">
    <?php //echo CHtml::link(Yii::t('mds','{icon} Ubah',array('{icon}'=>'<i class="icon-pencil icon-white"></i>')),$this->createUrl($this->id.'/update&id='.$model->pengumuman_id,array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
    <?php echo CHtml::link(Yii::t('mds','{icon} Kembali',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')),$this->createUrl($this->id.'/admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
    <?php //$this->widget('UserTips',array('type'=>'view'));?>
    </div>
</div>
