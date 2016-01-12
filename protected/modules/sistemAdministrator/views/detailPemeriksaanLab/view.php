<?php
$this->breadcrumbs=array(
	'Sapemeriksaanlabdet Ms'=>array('index'),
	$model->pemeriksaanlabdet_id,
);
?>
<!--<fieldset class="box">-->
    <!--<legend class="rim">Lihat Detail Pemeriksaan</legend>-->
    <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
    <div class="row-fluid">
        <div class="span6">
        <?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
                            'data'=>$model,
                            'attributes'=>array(
                                    'pemeriksaanlabdet_id',
                                    'nilairujukan_id',
                                    //'pemeriksaanlab_id',
                                    //'pemeriksaanlabdet_nourut',
                            ),
        )); ?>
        </div>
        <div class="span6">
                    <?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
                            'data'=>$model,
                            'attributes'=>array(
                                    //'pemeriksaanlabdet_id',
                                    //'nilairujukan_id',
                                    'pemeriksaanlab_id',
                                    'pemeriksaanlabdet_nourut',
                            ),
        )); ?>
        </div>
    </div>
    <div class="row-fluid">
        <div class="form-actions">
        <?php echo CHtml::link(Yii::t('mds','{icon} Ubah',array('{icon}'=>'<i class="icon-pencil icon-white"></i>')),$this->createUrl('index&id='.$model->pemeriksaanlabdet_id,array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
        <?php echo CHtml::link(Yii::t('mds','{icon} Pengaturan Detail Pemeriksaan',array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),$this->createUrl('admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
        <?php $this->widget('UserTips',array('type'=>'view'));?>
        </div>
    </div>
<!--</fieldset>-->