<div class="white-container">
    <legend class="rim2">Lihat <b>Lookup</b></legend>
    <?php
    $this->breadcrumbs=array(
            'Lookup Ms'=>array('index'),
            $model->lookup_id,
    );

    $this->menu=array(
    //        array('label'=>Yii::t('mds','View').' Lookup ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master')),
    );

    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
            'data'=>$model,
            'attributes'=>array(
                    'lookup_type',
            'lookup_kode',
                    'lookup_urutan',
            array(            
                'label'=>'Aktif',
                'type'=>'raw',
                'value'=>(($model->lookup_aktif==1)? ''.Yii::t('mds','Yes').'' : ''.Yii::t('mds','No').''),
            ),

            ),
    )); ?>
    <?php echo CHtml::link(Yii::t('mds','{icon} Ubah',array('{icon}'=>'<i class="icon-pencil icon-white"></i>')),$this->createUrl('update',array('id'=>$model->lookup_id,'modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
    <?php echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Lookup', array('{icon}'=>'<i class="icon-file icon-white"></i>')), $this->createUrl(Yii::app()->controller->id.'/admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'))."&nbsp";
            $this->widget('UserTips',array('type'=>'view'));?>
</div>