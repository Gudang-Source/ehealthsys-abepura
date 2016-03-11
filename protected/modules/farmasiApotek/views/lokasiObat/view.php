<?php
$this->breadcrumbs=array(
	'Falokasiobat Ms'=>array('index'),
	$model->lokasiobat_id,
);
?>
<!--<fieldset class="box2">-->
    <!--<legend class="rim">Lihat Lokasi Obat</legend>-->
    <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
    <div class="row-fluid">
        <div class="span6">
        <?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
                            'data'=>$model,
                            'attributes'=>array(
                                    'lokasiobat_id',
                                    'lokasiobat_nama',
                                    //'lokasiobat_namalain',
                                    //'lokasiobat_aktif',
                            ),
        )); ?>
        </div>
        <div class="span6">
                    <?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
                            'data'=>$model,
                            'attributes'=>array(
                                    //'lokasiobat_id',
                                    //'lokasiobat_nama',
                                    'lokasiobat_namalain',
                                    'lokasiobat_aktif',
                            ),
        )); ?>
        </div>
    </div>
    <div class="row-fluid">
        <div class="form-actions">
        <?php echo CHtml::link(Yii::t('mds','{icon} Ubah',array('{icon}'=>'<i class="icon-pencil icon-white"></i>')),$this->createUrl('update',array('id'=>$model->lokasiobat_id,'modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
        <?php echo CHtml::link(Yii::t('mds','{icon} Pengaturan Lokasi Obat',array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),$this->createUrl('admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
        <?php $this->widget('UserTips',array('type'=>'view'));  ?>
        </div>
    </div>
<!--</fieldset>-->