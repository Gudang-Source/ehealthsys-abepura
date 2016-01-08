<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
<?php $this->renderPartial('/_ringkasDataPasien', array('modPendaftaran' => $modPendaftaran, 'modPasien' => $modPasien)); ?>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'psanamnesa-t-form',
	'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'htmlOptions'=>array('enctype'=>'multipart/form-data','onKeyPress'=>'return disableKeyPress(event)'),
        'focus'=>'#',
)); ?>
<?php $this->renderPartial('_formRiwayatKehamilan',array('modRiwayatKehamilan'=>$modRiwayatKehamilan)); ?>
<?php $this->renderPartial('_formPeriksaKehamilan',array('modPeriksaKehamilan'=>$modPeriksaKehamilan,'form'=>$form)); ?>
<div class="form-actions">
                <?php echo CHtml::htmlButton($modPeriksaKehamilan->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="icon-ok icon-white"></i>')) : 
                                                     Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
                                array('class'=>'btn btn-primary', 'type'=>'button', 'onclick'=>'validasi()')); ?>
                  <div style="display: none">     
                         <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="icon-ok icon-white"></i>')), array('class'=>'btn btn-primary', 'type'=>'submit','id'=>'btn_simpan')); ?>
                  </div> 
                    <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                        Yii::app()->createUrl($this->module->id.'/DaftarPasien/index'), 
                        array('class'=>'btn btn-danger',
                              'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));  ?>
</div>
<?php $this->endWidget(); ?>

