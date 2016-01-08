<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'sagelar-belakang-m-form',
	'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
        'focus'=>'#',
)); ?>

	<p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>

	<?php echo $form->errorSummary($model); ?>

		<?php echo $form->textFieldRow($model,'esselon_nama',array('size'=>15,'maxlength'=>15,'class'=>'span3')); ?>
		<?php echo $form->textFieldRow($model,'esselon_namalainnya',array('size'=>15,'maxlength'=>15,'class'=>'span3')); ?>
		<?php echo $form->checkBoxRow($model,'esselon_aktif'); ?>
		<?php echo $form->error($model,'esselon_aktif'); ?>

            <div class="form-actions">
                        <?php echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="icon-ok icon-white"></i>')) : 
                                                             Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
                                                              array('class'=>'btn btn-primary', 'type'=>'submit','id'=>'submitButton','onKeypress'=>'return formSubmit(this,event)')); ?>
                        <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                                                              Yii::app()->createUrl($this->module->id.'/'.loginpemakaiK.'/admin'), 
                                                              array('class'=>'btn btn-danger','onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));  ?>
            </div>

<?php $this->endWidget(); ?>