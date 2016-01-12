<div class="white-container">
    <legend class="rim2">Lihat <b>Gambar Tubuh</b></legend>
    <?php
    $this->breadcrumbs=array(
            'Sagambartubuh Ms'=>array('index'),
            $model->gambartubuh_id,
    );
    ?>
    <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
    <div class="row-fluid">
            <div class="span4">
                    <img src='<?php echo Params::urlPhotoAnatomiTubuh().$model->nama_file_gbr; ?>'/>
            </div>
        <div class="span8">
        <?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
                            'data'=>$model,
                            'attributes'=>array(
                                    'gambartubuh_id',
                                    'nama_gambar',
                                    'nama_file_gbr',
                                    'path_gambar',
                                    'gambar_resolusi_x',
                                    'gambar_resolusi_y',
                                    'gambar_create',
                                    'gambar_update',
                                    'gambartubuh_aktif',
                            ),
        )); ?>
        </div>
    </div>
    <div class="row-fluid">
        <div class="form-actions">
        <?php echo CHtml::link(Yii::t('mds','{icon} Ubah',array('{icon}'=>'<i class="icon-pencil icon-white"></i>')),$this->createUrl($this->id.'/update&id='.$model->gambartubuh_id,array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
        <?php echo CHtml::link(Yii::t('mds','{icon} Pengaturan Gambar Tubuh',array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),$this->createUrl($this->id.'/admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
        <?php $this->widget('UserTips',array('type'=>'view'));?>
        </div>
    </div>
</div>