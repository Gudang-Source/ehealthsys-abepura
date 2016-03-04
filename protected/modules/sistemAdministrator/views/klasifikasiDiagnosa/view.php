<fieldset class="box">
    <legend class="rim">Lihat Klasifikasi Diagnosa</legend>
    <?php
    $this->breadcrumbs=array(
            'Saklasifikasidiagnosa Ms'=>array('index'),
            $model->klasifikasidiagnosa_id,
    );
    ?>
    <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
    <div class="row-fluid">
        <div class="span6">
        <?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
                            'data'=>$model,
                            'attributes'=>array(
                                    'klasifikasidiagnosa_id',
                                    'klasifikasidiagnosa_kode',
                                    'klasifikasidiagnosa_nama',
                                    //'klasifikasidiagnosa_namalain',
                                    //'klasifikasidiagnosa_aktif',
                                    //'klasifikasidiagnosa_desc',
                            ),
        )); ?>
        </div>
        <div class="span6">
                    <?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
                            'data'=>$model,
                            'attributes'=>array(
                                    //'klasifikasidiagnosa_id',
                                    //'klasifikasidiagnosa_kode',
                                    //'klasifikasidiagnosa_nama',
                                    'klasifikasidiagnosa_namalain',
                                    'klasifikasidiagnosa_aktif',
                                    'klasifikasidiagnosa_desc',
                            ),
        )); ?>
        </div>
    </div>
    <div class="row-fluid">
        <div class="form-actions">
        <?php echo CHtml::link(Yii::t('mds','{icon} Ubah',array('{icon}'=>'<i class="icon-pencil icon-white"></i>')),$this->createUrl('update',array('id'=>$model->klasifikasidiagnosa_id,'modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
        <?php echo CHtml::link(Yii::t('mds','{icon} Pengaturan Klasifikasi Diagnosa',array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),$this->createUrl('admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
        <?php $this->widget('UserTips',array('type'=>'view'));?>
        </div>
    </div>
</fieldset>