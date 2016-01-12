<div class="white-container">
    <legend class="rim2">Lihat <b>SMS Gateway</b></legend>
    <?php
    $this->breadcrumbs=array(
            'Sasmsgateway Ms'=>array('index'),
            $model->smsgateway_id,
    );
    ?>
    <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
    <div class="row-fluid">
        <div class="span6">
        <?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
                            'data'=>$model,
                            'attributes'=>array(
                                    'smsgateway_id',
                                    'modul_id',
                                    'tujuansms',
                                    'jenissms',
                                    'formatsms',
                                    'jmlkaraktersms',
                                    'katawalsms',
                                    //'kataakhirsms',
                                    //'ishurufkapital',
                                    //'modcontroller',
                                    //'modaction',
                                    //'templatesms',
                                    //'statussms',
                            ),
        )); ?>
        </div>
        <div class="span6">
                    <?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
                            'data'=>$model,
                            'attributes'=>array(
                                    //'smsgateway_id',
                                    //'modul_id',
                                    //'tujuansms',
                                    //'jenissms',
                                    //'formatsms',
                                    //'jmlkaraktersms',
                                    //'katawalsms',
                                    'kataakhirsms',
                                    'ishurufkapital',
                                    'modcontroller',
                                    'modaction',
                                    'templatesms',
                                    'statussms',
                            ),
        )); ?>
        </div>
    </div>
    <div class="row-fluid">
        <div class="form-actions">
        <?php echo CHtml::link(Yii::t('mds','{icon} Ubah',array('{icon}'=>'<i class="icon-pencil icon-white"></i>')),$this->createUrl($this->id.'/update&id='.$model->smsgateway_id,array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
        <?php echo CHtml::link(Yii::t('mds','{icon} Pengaturan Smsgateway',array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),$this->createUrl($this->id.'/admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
        <?php $this->widget('UserTips',array('type'=>'view'));?>
        </div>
    </div>
</div>