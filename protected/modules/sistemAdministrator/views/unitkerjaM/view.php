<div class="white-container">
    <legend class="rim2">Lihat <b>Unit Kerja</b></legend>
    <?php
    $this->breadcrumbs=array(
            'Agunitkerja Ms'=>array('index'),
            $model->unitkerja_id,
    );
    ?>
    <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
    <div class="row-fluid">
        <div class="span6">
        <?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
                            'data'=>$model,
                            'attributes'=>array(
                                    'unitkerja_id',
                                    'kodeunitkerja',
                                    'namaunitkerja',
                                    //'namalain',
                                    //'unitkerja_aktif',
                            ),
        )); ?>
        </div>
        <div class="span6">
                    <?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
                            'data'=>$model,
                            'attributes'=>array(
                                    //'unitkerja_id',
                                    //'kodeunitkerja',
                                    //'namaunitkerja',
                                    'namalain',
                                    array(
                                            'name'=>'unitkerja_aktif',
                                            'type'=>'raw',
                                            'value'=>(($model->unitkerja_aktif) ? "Aktif" : "Tidak Aktif"),
                                    ),
                            ),
        )); ?>
        </div>
    </div>
    <div class="row-fluid">
        <div class="form-actions">
        <?php echo CHtml::link(Yii::t('mds','{icon} Ubah',array('{icon}'=>'<i class="icon-pencil icon-white"></i>')),$this->createUrl('update',array('id'=>$model->unitkerja_id,'modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
        <?php echo CHtml::link(Yii::t('mds','{icon} Pengaturan Unit Kerja',array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),$this->createUrl('admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
        <?php $this->widget('UserTips',array('type'=>'view'));?>
        </div>
    </div>
</div>