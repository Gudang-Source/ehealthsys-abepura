<div class="white-container">
    <legend class="rim2">Pengaturan <b>Instalasi</b></legend>
    <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
    <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
    <?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
            'id'=>'sainstalasi-m-form',
            'enableAjaxValidation'=>false,
            'type'=>'horizontal',
            'focus'=>'#SAInstalasiM_instalasi_nama',
            'htmlOptions'=>array('enctype'=>'multipart/form-data','onKeyPress'=>'return disableKeyPress(event)'),
    )); ?>




        <div class="control-group">
            <?php // echo CHtml::label('Aktifasi Instalasi','',array('class'=>'control-label')); ?>
            <div class="controls">
                 <?php 
                        $instalasifalse = array();
                        $modInstalasifalse = InstalasiM::model()->findAll('instalasi_aktif=TRUE ORDER BY instalasi_nama ASC');
                         foreach($modInstalasifalse as $tampilInstalasi){
                            $instalasifalse[] = $tampilInstalasi['instalasi_id'];
                        } 
                       $this->widget('application.extensions.emultiselect.EMultiSelect',array('sortable'=>true, 'searchable'=>true));
                        echo CHtml::listBox('instalasi_nonaktif[]',$instalasifalse,CHtml::listData(InstalasiM::model()->findAll(array('order'=>'instalasi_nama ASC')),'instalasi_id', 'instalasi_nama'),array('multiple'=>'multiple','key'=>'instalasi_id', 'class'=>'multiselect','style'=>'width:500px;height:150px'));
                  ?>
            </div>
        </div>
        <div class="form-actions">
                                <?php echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="icon-ok icon-white"></i>')) : 
                                                                     Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
                                                array('class'=>'btn btn-primary', 'type'=>'submit','id'=>'btn_simpan','name'=>'submitInstalasi')); ?>
                <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                        Yii::app()->createUrl($this->module->id.'/instalasiM/admin'), 
                        array('class'=>'btn btn-danger',
                              'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));  ?>
                <?php
                    $content = $this->renderPartial('sistemAdministrator.views.tips.tipsaddedit',array(),true);
                    $this->widget('UserTips',array('type'=>'transaksi','content'=>$content));
                ?>
        </div>

    <?php $this->endWidget(); ?>
</div>