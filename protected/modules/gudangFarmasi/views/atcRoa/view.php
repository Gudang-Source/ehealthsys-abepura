<?php
$this->breadcrumbs=array(
	'Gfatc Ms'=>array('index'),
	$model->lookup_id,
);
?>
<fieldset class="box">
    <legend class="rim">Lihat Route of Adm Atc</legend>
    <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
    <div class="row-fluid">
        <?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
                            'data'=>$model,
                            'attributes'=>array(
                                    'lookup_name',
                                    'lookup_value',
                                    'lookup_urutan',
                            ),
        )); ?>
    </div>
    <div class="row-fluid">
        <div class="form-actions">
        <?php echo CHtml::link(Yii::t('mds','{icon} Ubah',array('{icon}'=>'<i class="icon-pencil icon-white"></i>')),$this->createUrl('update',array('id'=>$model->lookup_id,'modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
        <?php echo CHtml::link(Yii::t('mds','{icon} Pengaturan Route of Adm Atc',array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),$this->createUrl('admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
        <?php $this->widget('UserTips',array('content'=>''));?>
        </div>
    </div>
</fieldset>