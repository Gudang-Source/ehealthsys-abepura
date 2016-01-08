<fieldset class="box">
    <legend class="rim">Lihat Tugas Pemakai</legend>
    <?php
    $this->breadcrumbs=array(
            'Satugaspengguna Ks'=>array('index'),
            $model->tugaspengguna_id,
    );
    ?>
    <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
    <div class="row-fluid">
        <div class="span6">
        <?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
                        'data'=>$model,
                        'attributes'=>array(
                                'tugaspengguna_id',
                'peranpengguna_id',
                'tugas_nama',
                'tugas_namalainnya',
                'controller_nama',
                //'action_nama',
                //'keterangan_tugas',
                //'tugaspengguna_aktif',
                //'modul_id',
                        ),
        )); ?>
        </div>
        <div class="span6">
                <?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
                        'data'=>$model,
                        'attributes'=>array(
                                //'tugaspengguna_id',
                //'peranpengguna_id',
                //'tugas_nama',
                //'tugas_namalainnya',
                //'controller_nama',
                'action_nama',
                'keterangan_tugas',
                'tugaspengguna_aktif',
                'modul_id',
                        ),
        )); ?>
        </div>
    </div>
    <div class="row-fluid">
        <div class="form-actions">
        <?php echo CHtml::link(Yii::t('mds','{icon} Ubah',array('{icon}'=>'<i class="icon-pencil icon-white"></i>')),$this->createUrl($this->id.'/update&id='.$model->tugaspengguna_id,array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
        <?php echo CHtml::link(Yii::t('mds','{icon} Pengaturan Tugas Pemakai',array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),$this->createUrl($this->id.'/admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
        <?php $this->widget('UserTips',array('type'=>'view'));?>
        </div>
    </div>
</fieldset>