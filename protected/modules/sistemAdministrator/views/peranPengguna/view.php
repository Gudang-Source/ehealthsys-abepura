<?php
$this->breadcrumbs=array(
	'Saperanpengguna Ks'=>array('index'),
	$model->peranpengguna_id,
);
?>
<fieldset class="box">
    <legend class="rim">Lihat Peran Pemakai</legend>
    <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
    <div class="row-fluid">
            <div class="span6">
            <?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
                            'data'=>$model,
                            'attributes'=>array(
                                    'peranpengguna_id',
                    'peranpenggunanama',
                    //'peranpenggunanamalain',
                    //'peranpengguna_aktif',
                            ),
            )); ?>
            </div>
            <div class="span6">
                    <?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
                            'data'=>$model,
                            'attributes'=>array(
                                    //'peranpengguna_id',
                    //'peranpenggunanama',
                    'peranpenggunanamalain',
                    'peranpengguna_aktif',
                            ),
            )); ?>
            </div>
    </div>
    <div class="row-fluid">
            <div class="form-actions">
            <?php echo CHtml::link(Yii::t('mds','{icon} Ubah',array('{icon}'=>'<i class="icon-pencil icon-white"></i>')),$this->createUrl($this->id.'/update&id='.$model->peranpengguna_id,array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
            <?php echo CHtml::link(Yii::t('mds','{icon} Pengaturan Peran Pemakai',array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),$this->createUrl($this->id.'/admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
            <?php $this->widget('UserTips',array('type'=>'view'));?>
            </div>
    </div>
</fieldset>