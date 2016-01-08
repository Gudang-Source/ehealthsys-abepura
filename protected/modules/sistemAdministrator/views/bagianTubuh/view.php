<div class="white-container">
    <legend class="rim2">Lihat <b>Bagian Tubuh</b></legend>
    <?php
    $this->breadcrumbs=array(
            'Sabagiantubuh Ms'=>array('index'),
            $model->bagiantubuh_id,
    );
    ?>
    <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
    <div class="row-fluid">
        <div class="span6">
        <?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
                            'data'=>$model,
                            'attributes'=>array(
                                    'bagiantubuh_id',
                                    'namabagtubuh',
                                    'bagtubuh_namalain',
                                    //'kordinat_x',
                                    //'kordinat_y',
                                    //'bagiantubuh_aktif',
                            ),
        )); ?>
        </div>
        <div class="span6">
                    <?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
                            'data'=>$model,
                            'attributes'=>array(
                                    //'bagiantubuh_id',
                                    //'namabagtubuh',
                                    //'bagtubuh_namalain',
                                    'kordinat_x',
                                    'kordinat_y',
                                    'bagiantubuh_aktif',
                            ),
        )); ?>
        </div>
    </div>
    <div class="row-fluid">
        <div class="form-actions">
        <?php echo CHtml::link(Yii::t('mds','{icon} Ubah',array('{icon}'=>'<i class="icon-pencil icon-white"></i>')),$this->createUrl($this->id.'/update&id='.$model->bagiantubuh_id,array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
        <?php echo CHtml::link(Yii::t('mds','{icon} Pengaturan Bagian Tubuh',array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),$this->createUrl($this->id.'/admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
        <?php $this->widget('UserTips',array('type'=>'view'));?>
        </div>
    </div>
</div>