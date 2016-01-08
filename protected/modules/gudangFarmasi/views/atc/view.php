<?php
$this->breadcrumbs=array(
	'Gfatc Ms'=>array('index'),
	$model->atc_id,
);
?>
<fieldset class="box">
    <legend class="rim">Lihat Atc</legend>
    <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
    <div class="row-fluid">
        <div class="span6">
        <?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
                            'data'=>$model,
                            'attributes'=>array(
                                    'atc_id',
                                    'atc_kode',
                                    'atc_nama',
                                    'atc_namalain',
                                    'atc_singkatan',
                                    //'atc_ddd',
                                    //'atc_units',
                                    //'atc_admr',
                                    //'atc_note',
                                    //'atc_aktif',
                            ),
        )); ?>
        </div>
        <div class="span6">
                    <?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
                            'data'=>$model,
                            'attributes'=>array(
                                    //'atc_id',
                                    //'atc_kode',
                                    //'atc_nama',
                                    //'atc_namalain',
                                    //'atc_singkatan',
                                    'atc_ddd',
                                    'atc_units',
                                    'atc_admr',
                                    'atc_note',
                                    'atc_aktif',
                            ),
        )); ?>
        </div>
    </div>
    <div class="row-fluid">
        <div class="form-actions">
        <?php echo CHtml::link(Yii::t('mds','{icon} Ubah',array('{icon}'=>'<i class="icon-pencil icon-white"></i>')),$this->createUrl('update',array('id'=>$model->atc_id,'modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
        <?php echo CHtml::link(Yii::t('mds','{icon} Pengaturan Atc',array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),$this->createUrl('admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
        <?php $this->widget('UserTips',array('content'=>''));?>
        </div>
    </div>
</fieldset>