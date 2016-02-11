<?php if ($this->isFrame): ?>
<?php
$this->breadcrumbs=array(
	'Carakeluar Ms'=>array('index'),
	$model->carakeluar_id,
);
?>
<legend class="rim2">Lihat Cara Keluar</legend>
<?php endif; ?>
<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
<div class="row-fluid">
    <div class="span6">
    <?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
            'data'=>$model,
            'attributes'=>array(
        		'carakeluar_id',
		'carakeluar_nama',
		//'carakeluar_namalain',
		//'carakeluar_aktif',
            ),
    )); ?>
    </div>
    <div class="span6">
        <?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
            'data'=>$model,
            'attributes'=>array(
        		//'carakeluar_id',
		//'carakeluar_nama',
		'carakeluar_namalain',
		'carakeluar_aktif',
            ),
    )); ?>
    </div>
</div>
<div class="row-fluid">
    <div class="form-actions">
    <?php echo CHtml::link(Yii::t('mds','{icon} Ubah',array('{icon}'=>'<i class="icon-pencil icon-white"></i>')),$this->createUrl($this->id.'/update&id='.$model->carakeluar_id,array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
    <?php $this->widget('UserTips',array('type'=>'view'));?>
    </div>
</div>
