<?php
$this->breadcrumbs=array(
	'Farakobat Ms'=>array('index'),
	$model->rakobat_id,
);
?>
<!--<fieldset class='box2'>-->
    <!--<legend class="rim">Lihat Rak Obat</legend>-->
    <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
    <div class="row-fluid">
        <div class="span6">
        <?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
                            'data'=>$model,
                            'attributes'=>array(
                                    'rakobat_id',
                                    'rakobat_nama',
                                    'rakobat_namalain',
                                    //'rakobat_label',
                                    //'rakobat_aktif',
                            ),
        )); ?>
        </div>
        <div class="span6">
                    <?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
                            'data'=>$model,
                            'attributes'=>array(
                                    //'rakobat_id',
                                    //'rakobat_nama',
                                    //'rakobat_namalain',
                                    'rakobat_label',
                                    'rakobat_aktif',
                            ),
        )); ?>
        </div>
    </div>
    <div class="row-fluid">
        <div class="form-actions">
        <?php echo CHtml::link(Yii::t('mds','{icon} Ubah',array('{icon}'=>'<i class="icon-pencil icon-white"></i>')),$this->createUrl('update',array('id'=>$model->rakobat_id,'modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
        <?php echo CHtml::link(Yii::t('mds','{icon} Pengaturan Rak Obat',array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),$this->createUrl('admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
        <?php $this->widget('UserTips',array('type'=>'view'));?>
        </div>
    </div>
<!--</fieldset>-->