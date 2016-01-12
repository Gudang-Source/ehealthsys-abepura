<?php
$this->breadcrumbs=array(
	'Salokasipenyimpanan Ms'=>array('index'),
	$model->lokasipenyimpanan_id,
);
?>
<fieldset class="box">
    <legend class="rim">Lihat Lokasi Penyimpanan</legend>
    <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
            <div class="row-fluid">
            <div class="span6">
            <?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
                            'data'=>$model,
                            'attributes'=>array(
                                    'lokasipenyimpanan_id',
                            'instalasi_id',
                            'lokasipenyimpanan_kode',
                            //'lokasipenyimpanan_nama',
                            //'lokasipenyimpanan_namalain',
                            //'lokasipenyimpanan_aktif',
                            ),
            )); ?>
            </div>
            <div class="span6">
                    <?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
                            'data'=>$model,
                            'attributes'=>array(
                                    //'lokasipenyimpanan_id',
                            //'instalasi_id',
                            //'lokasipenyimpanan_kode',
                            'lokasipenyimpanan_nama',
                            'lokasipenyimpanan_namalain',
                            'lokasipenyimpanan_aktif',
                            ),
            )); ?>
            </div>
    </div>
    <div class="row-fluid">
            <div class="form-actions">
            <?php echo CHtml::link(Yii::t('mds','{icon} Ubah',array('{icon}'=>'<i class="icon-pencil icon-white"></i>')),$this->createUrl('update',array('id'=>$model->lokasipenyimpanan_id,'modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
            <?php echo CHtml::link(Yii::t('mds','{icon} Pengaturan Lokasi Penyimpanan',array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),$this->createUrl('admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
            <?php $this->widget('UserTips',array('content'=>''));?>
            </div>
    </div>
</fieldset>