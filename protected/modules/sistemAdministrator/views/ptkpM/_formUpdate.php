<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'ptkp-m-form',
	'enableAjaxValidation'=>false,
    'type'=>'horizontal',
    'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
    'focus'=>'#',
)); ?>

	<p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>

	<?php echo $form->errorSummary($model); ?>
    <div class="control-group ">
        <?php echo $form->labelEx($model, 'tglberlaku', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php $this->widget('MyDateTimePicker',array(
                'model'=>$model,
                'attribute'=>'tglberlaku',
                'mode'=>'date',
                'options'=> array(
                    'dateFormat'=>Params::DATE_FORMAT,
                ),
                'htmlOptions'=>array('readonly'=>true,
                    'onkeypress'=>"return $(this).focusNextInputField(event)",
                    'class'=>'dtPicker3',
                ),
            )); ?> 
        </div>
    </div>

    <?php echo $form->textFieldRow($model,'jmltanggunan',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
    <?php echo $form->dropDownListRow($model, 'wajibpajak_thn', CustomFunction::getTahun(null,null), array('class' => "span3",'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
    <?php echo $form->dropDownListRow($model, 'wajibpajak_bln', CustomFunction::getBulan(), array('class' => "span3",'onkeypress' => "return $(this).focusNextInputField(event)")); ?>    
    <div>
		<?php echo $form->dropDownListRow($model,'statusperkawinan', LookupM::model()->GetItems('statusperkawinan'), 
				array('empty'=>'-- Pilih --', 'onkeypress'=>"return $(this).focusNextInputField(event)", 'style'=>'width:140px', 
		)); ?>
    </div>
    <div class = "control-group">
            <?php echo $form->labelEx($model, 'berlaku',array('class'=>'control-label')); ?>
        <div class = "control">
                <?php echo '&nbsp;&nbsp;'.$form->checkBox($model, 'berlaku'); ?>
        </div>
    </div>
	<div class="form-actions">
            <?php echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="icon-ok icon-white"></i>')) : 
                Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
                array('class'=>'btn btn-primary', 'type'=>'submit','onKeypress'=>'return formSubmit(this,event)')); ?>
           <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                                                                    Yii::app()->createUrl($this->module->id.'/propinsiM/admin'), 
                                                                    array('class'=>'btn btn-danger',
                                                                    'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));  ?>
            <?php
                echo CHtml::link(Yii::t('mds', '{icon} Pengaturan PTKP', array('{icon}'=>'<i class="icon-file icon-white"></i>')), $this->createUrl(Yii::app()->controller->id.'/admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'))."&nbsp";
                $this->widget('UserTips',array('type'=>'create'));
            ?>
	</div>

<?php $this->endWidget(); ?>
