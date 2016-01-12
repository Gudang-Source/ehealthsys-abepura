<?php
$this->breadcrumbs=array(
	'saaksespengguna Ks'=>array('index'),
	$model->aksespengguna_id,
);
?>
<fieldset class="box">
    <legend class="rim">Lihat Akses Pemakai</legend>
    <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
    <div class="row-fluid">
        <div class="span6">
        <?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
            'data'=>$model,
            'attributes'=>array(
                    array(
                        'name'=>'loginpemakai.nama_pemakai',
                        'value'=>$model->loginpemakai->nama_pemakai,
                    ),
                    array(
                        'name'=>'peranpengguna.peranpenggunanama',
                        'value'=>$model->peranpengguna->peranpenggunanama,
                    ),
                    array(
                        'name'=>'modul.modul_nama',
                        'value'=>$model->modul->modul_nama,
                    ),
            ),
        )); ?>
        </div>
        <div class="span6">

        </div>
    </div>
    <div class="row-fluid">
        <div class="form-actions">
        <?php echo CHtml::link(Yii::t('mds','{icon} Ubah',array('{icon}'=>'<i class="icon-pencil icon-white"></i>')),$this->createUrl($this->id.'/update&id='.$model->aksespengguna_id,array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
        <?php echo CHtml::link(Yii::t('mds','{icon} Pengaturan Akses Pemakai',array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),$this->createUrl($this->id.'/admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
        <?php $this->widget('UserTips',array('type'=>'view'));?>
        </div>
    </div>
</fieldset>