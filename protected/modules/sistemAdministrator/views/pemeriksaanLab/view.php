<?php
$this->breadcrumbs=array(
	'Sapemeriksaanlab Ms'=>array('index'),
	$model->pemeriksaanlab_id,
);
?>
<!--<fieldset class="box">-->
    <!--<legend class="rim">Lihat Pemeriksaan Lab</legend>-->
    <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
    <div class="row-fluid">
        <div class="span6">
        <?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
                            'data'=>$model,
                            'attributes'=>array(
                                    'pemeriksaanlab_id',
                                    'jenispemeriksaanlab_id',
                                    'daftartindakan_id',
                                    'pemeriksaanlab_kode',
                                    //'pemeriksaanlab_urutan',
                                    //'pemeriksaanlab_nama',
                                    //'pemeriksaanlab_namalainnya',
                                    //'pemeriksaanlab_aktif',
                            ),
        )); ?>
        </div>
        <div class="span6">
                    <?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
                            'data'=>$model,
                            'attributes'=>array(
                                    //'pemeriksaanlab_id',
                                    //'jenispemeriksaanlab_id',
                                    //'daftartindakan_id',
                                    //'pemeriksaanlab_kode',
                                    'pemeriksaanlab_urutan',
                                    'pemeriksaanlab_nama',
                                    'pemeriksaanlab_namalainnya',
                                    'pemeriksaanlab_aktif',
                            ),
        )); ?>
        </div>
    </div>
    <div class="row-fluid">
        <div class="form-actions">
        <?php echo CHtml::link(Yii::t('mds','{icon} Ubah',array('{icon}'=>'<i class="icon-pencil icon-white"></i>')),$this->createUrl('update&id='.$model->pemeriksaanlab_id,array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
        <?php echo CHtml::link(Yii::t('mds','{icon} Pengaturan Pemeriksaan Lab',array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),$this->createUrl('admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
        <?php 
            $content = $this->renderPartial($this->path_view.'tips/tipsView',array(),true);
            $this->widget('UserTips',array('type'=>'view','content'=>$content));
            ?>
        </div>
    </div>
<!--</fieldset>-->