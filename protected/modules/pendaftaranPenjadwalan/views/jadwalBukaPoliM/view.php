<div class="white-container">
    <?php
    $this->breadcrumbs=array(
            'Ppjadwal Buka Poli Ms'=>array('index'),
            $model->jadwalbukapoli_id,
    );

    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
            'data'=>$model,
            'attributes'=>array(
                    'jadwalbukapoli_id',
                    'ruangan.ruangan_nama',
                    'hari',
                    'jmabuka',
                    'jammulai',
                    'jamtutup',
                    'maxantiranpoli',
    //		'create_time',
    //		'update_time',
    //		'create_loginpemakai_id',
    //		'update_loginpemakai_id',
    //		'create_ruangan',
            ),
    )); ?>

    <div class="row-fluid">
        <div class="form-actions">
        <?php echo CHtml::link(Yii::t('mds','{icon} Ubah',array('{icon}'=>'<i class="icon-pencil icon-white"></i>')),$this->createUrl($this->id.'/update&id='.$model->jadwalbukapoli_id,array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
        <?php echo CHtml::link(Yii::t('mds','{icon} Pengaturan Jadwal Buka Poli',array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),$this->createUrl($this->id.'/admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
        <?php $this->widget('UserTips',array('type'=>'view'));?>
        </div>
    </div>
</div>