<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'faproduksiobat-t-form',
	'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
        'focus'=>'#',
)); ?>

	<p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>

	<?php echo $form->errorSummary($model); ?>

            <?php echo $form->textFieldRow($model,'ruangan_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
            <?php echo $form->textFieldRow($model,'pegawai_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
            <?php echo $form->textFieldRow($model,'tglproduksiobt',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
            <?php echo $form->textFieldRow($model,'noproduksiobt',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>20)); ?>
            <?php echo $form->textAreaRow($model,'keternganprdobat',array('rows'=>6, 'cols'=>50, 'class'=>'span5', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
            <?php echo $form->textFieldRow($model,'create_time',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
            <?php echo $form->textFieldRow($model,'update_time',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
            <?php echo $form->textFieldRow($model,'create_loginpemakai_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
            <?php echo $form->textFieldRow($model,'update_loginpemakai_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
            <?php echo $form->textFieldRow($model,'create_ruangan',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
	<div class="form-actions">
		                <?php echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="icon-ok icon-white"></i>')) : 
                                                                     Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
                                                array('class'=>'btn btn-primary', 'type'=>'submit','onKeypress'=>'return formSubmit(this,event)')); ?>
                <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                        Yii::app()->createUrl($this->module->id.'/'.produksiObat.'/admin'), 
                        array('class'=>'btn btn-danger',
                              'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));  ?>
	</div>

<?php $this->endWidget(); ?>
