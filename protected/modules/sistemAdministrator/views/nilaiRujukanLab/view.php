<fieldset class="box">
    <legend class="rim">Lihat Nilai Rujukan (Referensi)</legend>
<?php
$this->breadcrumbs=array(
	'Sanilairujukan Ms'=>array('index'),
	$model->nilairujukan_id,
);
?>
<!--<fieldset class="box">-->
    <!--<legend class="rim">Lihat Nilai Rujukan (Referensi) Lab</legend>-->
    <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
    <div class="row-fluid">
        <div class="span6">
        <?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
                            'data'=>$model,
                            'attributes'=>array(
                                    'nilairujukan_id',
                                    'kelkumurhasillab_id',
                                    'kelompokdet',
                                    'namapemeriksaandet',
                                    'nilairujukan_jeniskelamin',
                                    'nilairujukan_nama',
                                    //'nilairujukan_min',
                                    //'nilairujukan_max',
                                    //'nilairujukan_satuan',
                                    //'nilairujukan_metode',
                                    //'nilairujukan_keterangan',
                                    //'nilairujukan_aktif',
                            ),
        )); ?>
        </div>
        <div class="span6">
                    <?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
                            'data'=>$model,
                            'attributes'=>array(
                                    //'nilairujukan_id',
                                    //'kelkumurhasillab_id',
                                    //'kelompokdet',
                                    //'namapemeriksaandet',
                                    //'nilairujukan_jeniskelamin',
                                    //'nilairujukan_nama',
                                    'nilairujukan_min',
                                    'nilairujukan_max',
                                    'nilairujukan_satuan',
                                    'nilairujukan_metode',
                                    'nilairujukan_keterangan',
                                    'nilairujukan_aktif',
                            ),
        )); ?>
        </div>
    </div>
    <div class="row-fluid">
        <div class="form-actions">
        <?php echo CHtml::link(Yii::t('mds','{icon} Ubah',array('{icon}'=>'<i class="icon-pencil icon-white"></i>')),$this->createUrl('update&id='.$model->nilairujukan_id,array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
        <?php //echo CHtml::link(Yii::t('mds','{icon} Pengaturan Nilai Rujukan (Referensi) Lab',array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),$this->createUrl('admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
        <?php echo CHtml::link(Yii::t('mds','{icon} Pengaturan Nilai Rujukan (Referensi)',array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),$this->createUrl('admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
        <?php 
            $content = $this->renderPartial($this->path_view.'tips/tipsView',array(),true);
            $this->widget('UserTips',array('content'=>$content));
            ?>
        </div>
    </div>
</fieldset>
